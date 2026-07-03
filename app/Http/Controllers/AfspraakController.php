<?php

namespace App\Http\Controllers;

use App\Models\Afspraak;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class AfspraakController extends Controller
{
    private $afspraakModel;

    public function __construct()
    {
        $this->afspraakModel = new Afspraak();
    }

    /**
     * User Story_03 - Overzicht afspraken (met status-filter).
     */
    public function index(Request $request)
    {
        $status = $request->query('status', '');

        $alleAfspraken = collect(
            $this->afspraakModel->sp_GetAllAfspraken($status !== '' ? $status : null)
        );

        $perPage = 4;
        $page = LengthAwarePaginator::resolveCurrentPage();

        $afspraken = new LengthAwarePaginator(
            $alleAfspraken->forPage($page, $perPage)->values(),
            $alleAfspraken->count(),
            $perPage,
            $page,
            [
                'path' => LengthAwarePaginator::resolveCurrentPath(),
                'query' => $request->query(),
            ]
        );

        return view('afspraken.index', [
            'title' => 'Overzicht afspraken',
            'afspraken' => $afspraken,
            'statussen' => ['Inbehandeling', 'Behandeld', 'Verzet', 'Geannuleerd'],
            'geselecteerdeStatus' => $status,
        ]);
    }

    /**
     * Afspraakdetail.
     */
    public function show($id)
    {
        $afspraak = $this->afspraakModel->sp_GetAfspraakById($id);
        abort_if(!$afspraak, 404);

        return view('afspraken.show', [
            'title' => 'Afspraakdetail',
            'afspraak' => $afspraak,
        ]);
    }

    /**
     * User Story_04 - formulier om een afspraak te wijzigen.
     */
    public function edit($id)
    {
        $afspraak = $this->afspraakModel->sp_GetAfspraakById($id);
        abort_if(!$afspraak, 404);

        return view('afspraken.edit', [
            'title' => 'Afspraak wijzigen',
            'afspraak' => $afspraak,
            'medewerkers' => $this->afspraakModel->sp_GetAlleMedewerkersDropdown(),
            'behandelingen' => $this->afspraakModel->sp_GetAlleBehandelingenDropdown(),
            'statussen' => ['Inbehandeling', 'Behandeld', 'Verzet', 'Geannuleerd'],
        ]);
    }

    /**
     * User Story_04 - afspraak daadwerkelijk bijwerken, inclusief
     * controle op dubbele boeking van de medewerker.
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'medewerker_id' => 'required|integer',
            'behandeling_id' => 'required|integer',
            'datum' => 'required|date',
            'starttijd' => 'required',
            'status' => 'required|string|max:50',
        ]);

        try {
            $result = $this->afspraakModel->sp_UpdateAfspraak(
                $id,
                $data['medewerker_id'],
                $data['behandeling_id'],
                $data['datum'],
                $data['starttijd'],
                $data['status']
            );
        } catch (\Throwable $e) {
            report($e);

            return back()->withInput()
                ->with('error', 'Afspraakgegevens zijn niet bijgewerkt');
        }

        if ($result && (int) $result->Success === 1) {
            return redirect()->route('afspraken.index')
                ->with('success', 'Afspraak bijgewerkt.');
        }

        $errors = [];

        if ($result && $result->ErrorCode === 'DUBBELE_BOEKING') {
            $errors['datum'] = 'De medewerker heeft al een afspraak op de gekozen datum en tijd';
            $errors['starttijd'] = 'Kies een ander tijdstip voor deze medewerker';
        } else {
            $errors['medewerker_id'] = 'Er is geen koppeling gevonden tussen deze medewerker en behandeling';
        }

        return back()->withInput()->withErrors($errors)
            ->with('error', 'Afspraakgegevens zijn niet bijgewerkt');
    }
}
