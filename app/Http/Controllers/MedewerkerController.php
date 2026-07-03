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
            'geboortedatum' => 'required|date|before:today', // Mag niet in de toekomst of vandaag zijn
            'contact_email' => 'required|email:filter|max:150', // :filter zorgt voor een strengere e-mail check
            'straatnaam' => 'required|string|max:150',
            'huisnummer' => 'required|integer|min:1|max:99999', // Voorkomt extreem grote getallen
            'toevoeging' => 'nullable|string|max:20',
            // Strikte Nederlandse postcode regex (bvb: 1234 AB of 1234AB, sluit ongeldige combinaties uit)
            'postcode' => ['required', 'string', 'regex:/^[1-9][0-9]{3}\s?(?!(?i)(sa|sd|ss))[a-zA-Z]{2}$/'],
            // Flexibele maar veilige telefoon regex (06-nummer, +316 of 00316 met tussen de 9 en 13 tekens)
            'mobiel' => ['required', 'string', 'regex:/^(\+31|0031|0)(6[\s-]?\d{8}|[1-9]\d{1,3}[\s-]?\d{5,7})$/'],
            'opmerking' => 'nullable|string|max:255',
        ], [
            'naam.required' => 'Naam is verplicht.',
            'naam.max' => 'De naam mag niet langer zijn dan 191 tekens.',
            'specialisatie.required' => 'Specialisatie is verplicht.',
            'geboortedatum.required' => 'Geboortedatum is verplicht.',
            'geboortedatum.before' => 'De geboortedatum moet in het verleden liggen.',
            'contact_email.required' => 'Contact e-mail is verplicht.',
            'contact_email.email' => 'Vul een geldig e-mailadres in.',
            'huisnummer.min' => 'Het huisnummer moet minimaal 1 zijn.',
            'postcode.required' => 'Postcode is verplicht.',
            'postcode.regex' => 'Vul een geldige Nederlandse postcode in (bijv. 1234 AB).',
            'mobiel.required' => 'Mobiel nummer is verplicht.',
            'mobiel.regex' => 'Vul een geldig Nederlands telefoonnummer in (bijv. 0612345678 of +31612345678).',
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
                'postcode' => strtoupper(str_replace(' ', '', $data['postcode'])), // Slaat postcode netjes op zonder spaties en in caps
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
