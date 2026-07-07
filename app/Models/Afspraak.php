<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Afspraak extends Model
{
    protected $table = 'Afspraak';

    /**
     * Haalt alle afspraken op, optioneel gefilterd op status
     *
     * @param string|null $status De status om op te filteren
     * @return array De afspraken
     */
    public function sp_GetAllAfspraken($status = null)
    {
        try {
            Log::info('Fetching all afspraken', ['status' => $status]);

            $result = DB::select('CALL sp_GetAllAfspraken(:status)', [
                'status' => $status,
            ]);

            Log::info('Successfully fetched afspraken', ['count' => count($result)]);
            return $result;
        } catch (\Exception $e) {
            Log::error('Error fetching afspraken', [
                'status' => $status,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            throw $e;
        }
    }

    /**
     * Haalt een specifieke afspraak op via ID
     *
     * @param int $id De ID van de afspraak
     * @return object|null De afspraak of null
     */
    public function sp_GetAfspraakById($id)
    {
        try {
            Log::info('Fetching afspraak by ID', ['id' => $id]);

            $result = DB::selectOne('CALL sp_GetAfspraakById(:id)', [
                'id' => $id,
            ]);

            Log::info('Successfully fetched afspraak', ['id' => $id]);
            return $result;
        } catch (\Exception $e) {
            Log::error('Error fetching afspraak by ID', [
                'id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            throw $e;
        }
    }

    /**
     * Werkt een afspraak bij met nieuwe gegevens
     *
     * @param int $id De ID van de afspraak
     * @param int $medewerkerId De medewerker ID
     * @param int $behandelingId De behandeling ID
     * @param string $datum De datum van de afspraak
     * @param string $starttijd De starttijd van de afspraak
     * @param string $status De status van de afspraak
     * @return object|null De bijgewerkte afspraak
     */
    public function sp_UpdateAfspraak($id, $medewerkerId, $behandelingId, $datum, $starttijd, $status)
    {
        try {
            Log::info('Updating afspraak', [
                'id' => $id,
                'medewerkerId' => $medewerkerId,
                'behandelingId' => $behandelingId,
                'datum' => $datum,
                'starttijd' => $starttijd,
                'status' => $status,
            ]);

            $result = DB::selectOne(
                'CALL sp_UpdateAfspraak(:id, :medewerkerId, :behandelingId, :datum, :starttijd, :status)',
                [
                    'id' => $id,
                    'medewerkerId' => $medewerkerId,
                    'behandelingId' => $behandelingId,
                    'datum' => $datum,
                    'starttijd' => $starttijd,
                    'status' => $status,
                ]
            );

            Log::info('Successfully updated afspraak', ['id' => $id]);
            return $result;
        } catch (\Exception $e) {
            Log::error('Error updating afspraak', [
                'id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            throw $e;
        }
    }

    /**
     * Haalt alle medewerkers op voor dropdown selectie
     *
     * @return array Alle medewerkers
     */
    public function sp_GetAlleMedewerkersDropdown()
    {
        try {
            Log::info('Fetching all medewerkers for dropdown');

            $result = DB::select('CALL sp_GetAlleMedewerkersDropdown()');

            Log::info('Successfully fetched medewerkers', ['count' => count($result)]);
            return $result;
        } catch (\Exception $e) {
            Log::error('Error fetching medewerkers for dropdown', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            throw $e;
        }
    }

    /**
     * Haalt alle behandelingen op voor dropdown selectie
     *
     * @return array Alle behandelingen
     */
    public function sp_GetAlleBehandelingenDropdown()
    {
        try {
            Log::info('Fetching all behandelingen for dropdown');

            $result = DB::select('CALL sp_GetAlleBehandelingenDropdown()');

            Log::info('Successfully fetched behandelingen', ['count' => count($result)]);
            return $result;
        } catch (\Exception $e) {
            Log::error('Error fetching behandelingen for dropdown', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            throw $e;
        }
    }
}
