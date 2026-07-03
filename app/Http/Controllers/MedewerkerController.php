<?php

namespace App\Http\Controllers;

use App\Models\Medewerker;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class MedewerkerController extends Controller
{
    private const SPECIALISATIES = [
        'Extensions',
        'Kleuren',
        'Knippen',
        'Permanent',
        'Stylen',
    ];

    private const PER_PAGE = 4;

    private Medewerker $medewerkerModel;

    public function __construct()
    {
        $this->medewerkerModel = new Medewerker();
    }

    /**
     * Overzicht van alle medewerkers, met filter op specialisatie en paginering.
     */
    public function index(Request $request)
    {
        $filter = $request->query('specialisatie', 'alle');

        if ($filter !== 'alle' && !in_array($filter, self::SPECIALISATIES, true)) {
            $filter = 'alle';
        }

        try {
            $alleMedewerkers = $this->medewerkerModel->sp_GetAllMedewerkers($filter);
        } catch (\Throwable $e) {
            Log::error('MedewerkerController@index - Fout bij ophalen medewerkers: ' . $e->getMessage());
            $alleMedewerkers = [];
        }

        $page = (int) LengthAwarePaginator::resolveCurrentPage('page');
        $page = $page > 0 ? $page : 1;

        $items = array_slice($alleMedewerkers, ($page - 1) * self::PER_PAGE, self::PER_PAGE);

        $medewerkers = new LengthAwarePaginator(
            $items,
            count($alleMedewerkers),
            self::PER_PAGE,
            $page,
            [
                'path' => route('medewerkers.index'),
                'query' => $request->query(),
            ]
        );

        return view('medewerkers.index', [
            'title' => 'Medewerkers',
            'medewerkers' => $medewerkers,
            'filter' => $filter,
            'specialisaties' => self::SPECIALISATIES,
        ]);
    }

    /**
     * Detailpagina van één medewerker.
     */
    public function detail(int $id)
    {
        try {
            $medewerker = $this->medewerkerModel->sp_GetMedewerkerById($id);
            abort_if(!$medewerker, 404);
        } catch (\Throwable $e) {
            Log::error('MedewerkerController@detail - Fout bij ophalen medewerker: ' . $e->getMessage());
            abort(500, 'Er is een fout opgetreden bij het ophalen van de medewerker.');
        }

        return view('medewerkers.detail', [
            'title' => 'Medewerkerdetail',
            'medewerker' => $medewerker,
        ]);
    }

    /**
     * Wijzig-formulier van een medewerker.
     */
    public function edit(int $id)
    {
        try {
            $medewerker = $this->medewerkerModel->sp_GetMedewerkerById($id);
            abort_if(!$medewerker, 404);
        } catch (\Throwable $e) {
            Log::error('MedewerkerController@edit - Fout bij ophalen medewerker voor wijzigen: ' . $e->getMessage());
            abort(500, 'Er is een fout opgetreden bij het ophalen van de medewerker.');
        }

        return view('medewerkers.edit', [
            'title' => 'Medewerker wijzigen',
            'medewerker' => $medewerker,
            'specialisaties' => self::SPECIALISATIES,
        ]);
    }

    /**
     * Verwerk de wijziging van een medewerker.
     * Business-regel: minderjarige medewerkers (< 18 jaar) mogen niet de
     * specialisatie "Permanent" krijgen (werken met gevaarlijke stoffen/chemicaliën).
     */
    public function update(Request $request, int $id)
    {
        $data = $request->validate([
            'naam' => 'required|string|max:191',
            'specialisatie' => 'required|in:' . implode(',', self::SPECIALISATIES),
            'geboortedatum' => 'required|date',
            'contact_email' => 'required|email|max:150',
            'straatnaam' => 'required|string|max:150',
            'huisnummer' => 'required|integer|min:1',
            'toevoeging' => 'nullable|string|max:20',
            'postcode' => 'required|string|max:20',
            'plaats' => 'required|string|max:100',
            'mobiel' => 'required|string|max:50',
            'opmerking' => 'nullable|string|max:255',
        ], [
            'naam.required' => 'Naam is verplicht.',
            'specialisatie.required' => 'Specialisatie is verplicht.',
            'geboortedatum.required' => 'Geboortedatum is verplicht.',
        ]);

        $leeftijd = Carbon::parse($data['geboortedatum'])->age;

        if ($leeftijd < 18 && $data['specialisatie'] === 'Permanent') {
            return back()
                ->withInput()
                ->withErrors(['specialisatie' => 'Minderjarige medewerkers mogen geen specialisatie Permanent toegewezen krijgen vanwege het werken met gevaarlijke stoffen en chemicaliën.'])
                ->with('error', 'Medewerkergegevens zijn niet bijgewerkt');
        }

        [$voornaam, $tussenvoegsel, $achternaam] = $this->parseNaam($data['naam']);

        try {
            $affected = $this->medewerkerModel->sp_UpdateMedewerker([
                'id' => $id,
                'voornaam' => $voornaam,
                'tussenvoegsel' => $tussenvoegsel,
                'achternaam' => $achternaam,
                'specialisatie' => $data['specialisatie'],
                'geboortedatum' => $data['geboortedatum'],
                'contact_email' => $data['contact_email'],
                'straatnaam' => $data['straatnaam'],
                'huisnummer' => $data['huisnummer'],
                'toevoeging' => $data['toevoeging'] ?? null,
                'postcode' => $data['postcode'],
                'plaats' => $data['plaats'],
                'mobiel' => $data['mobiel'],
                'opmerking' => $data['opmerking'] ?? null,
            ]);
        } catch (\Throwable $e) {
            Log::error('MedewerkerController@update - Fout bij bijwerken medewerker: ' . $e->getMessage());

            return back()->withInput()->with('error', 'Medewerkergegevens zijn niet bijgewerkt');
        }

        if ($affected > 0) {
            return redirect()
                ->route('medewerkers.show', $id)
                ->with('success', 'Medewerkergegevens bijgewerkt.');
        }

        return back()->withInput()->with('error', 'Medewerkergegevens zijn niet bijgewerkt');
    }

    /**
     * Splits een volledige naam op in voornaam, tussenvoegsel en achternaam.
     * Eerste woord = voornaam, laatste woord = achternaam, alles ertussen = tussenvoegsel.
     */
    private function parseNaam(string $naam): array
    {
        $delen = preg_split('/\s+/', trim($naam));

        if (count($delen) === 1) {
            return [$delen[0], null, ''];
        }

        $voornaam = array_shift($delen);
        $achternaam = array_pop($delen);
        $tussenvoegsel = count($delen) > 0 ? implode(' ', $delen) : null;

        return [$voornaam, $tussenvoegsel, $achternaam];
    }
}
