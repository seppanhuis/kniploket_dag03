<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Afspraak extends Model
{
    protected $table = 'Afspraak';

    public function sp_GetAllAfspraken($status = null)
    {
        return DB::select('CALL sp_GetAllAfspraken(:status)', [
            'status' => $status,
        ]);
    }

    public function sp_GetAfspraakById($id)
    {
        return DB::selectOne('CALL sp_GetAfspraakById(:id)', [
            'id' => $id,
        ]);
    }

    public function sp_UpdateAfspraak($id, $medewerkerId, $behandelingId, $datum, $starttijd, $status)
    {
        return DB::selectOne(
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
    }

    public function sp_GetAlleMedewerkersDropdown()
    {
        return DB::select('CALL sp_GetAlleMedewerkersDropdown()');
    }

    public function sp_GetAlleBehandelingenDropdown()
    {
        return DB::select('CALL sp_GetAlleBehandelingenDropdown()');
    }
}
