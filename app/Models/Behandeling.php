<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Behandeling extends Model
{
    protected $table = 'Behandeling';

    public function sp_GetAllBehandelingen(?string $filter = 'alle'): array
    {
        try {
            return DB::select('CALL sp_GetAllBehandelingen(:filter)', [
                'filter' => $filter,
            ]);
        } catch (\Exception $e) {
            Log::error('Fout bij ophalen behandelingen: ' . $e->getMessage());
            return [];
        }
    }

    public function sp_GetBehandelingById(int $id)
    {
        try {
            return DB::selectOne('CALL sp_GetBehandelingById(:id)', [
                'id' => $id,
            ]);
        } catch (\Exception $e) {
            Log::error('Fout bij ophalen behandeling met ID ' . $id . ': ' . $e->getMessage());
            return null;
        }
    }

    public function sp_GetProductenPerBehandeling(int $behandelingId): array
    {
        try {
            return DB::select('CALL sp_GetProductenPerBehandeling(:behandelingId)', [
                'behandelingId' => $behandelingId,
            ]);
        } catch (\Exception $e) {
            Log::error('Fout bij ophalen producten voor behandeling ' . $behandelingId . ': ' . $e->getMessage());
            return [];
        }
    }

    public function sp_GetProductDetail(int $productId)
    {
        try {
            return DB::selectOne('CALL sp_GetProductDetail(:productId)', [
                'productId' => $productId,
            ]);
        } catch (\Exception $e) {
            Log::error('Fout bij ophalen productdetail met ID ' . $productId . ': ' . $e->getMessage());
            return null;
        }
    }

    public function sp_UpdateProductVerkoopprijs(int $productId, float $nieuweVerkoopprijs): int
    {
        try {
            $row = DB::selectOne('CALL sp_UpdateProductVerkoopprijs(:productId, :nieuweVerkoopprijs)', [
                'productId' => $productId,
                'nieuweVerkoopprijs' => $nieuweVerkoopprijs,
            ]);

            return $row->affected ?? 0;

        } catch (\Exception $e) {
            Log::error('Fout bij aanpassen verkoopprijs product ' . $productId . ': ' . $e->getMessage());
            return 0;
        }
    }
}