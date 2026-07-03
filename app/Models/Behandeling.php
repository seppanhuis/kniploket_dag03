<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Behandeling extends Model
{
    protected $table = 'Behandeling';

    public function sp_GetAllBehandelingen(?string $filter = 'alle'): array
    {
        return DB::select('CALL sp_GetAllBehandelingen(:filter)', [
            'filter' => $filter,
        ]);
    }

    public function sp_GetBehandelingById(int $id)
    {
        return DB::selectOne('CALL sp_GetBehandelingById(:id)', [
            'id' => $id,
        ]);
    }

    public function sp_GetProductenPerBehandeling(int $behandelingId): array
    {
        return DB::select('CALL sp_GetProductenPerBehandeling(:behandelingId)', [
            'behandelingId' => $behandelingId,
        ]);
    }

    public function sp_GetProductDetail(int $productId)
    {
        return DB::selectOne('CALL sp_GetProductDetail(:productId)', [
            'productId' => $productId,
        ]);
    }

    public function sp_UpdateProductVerkoopprijs(int $productId, float $nieuweVerkoopprijs): int
    {
        $row = DB::selectOne('CALL sp_UpdateProductVerkoopprijs(:productId, :nieuweVerkoopprijs)', [
            'productId' => $productId,
            'nieuweVerkoopprijs' => $nieuweVerkoopprijs,
        ]);

        return $row->affected ?? 0;
    }
}