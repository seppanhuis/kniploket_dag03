<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    /**
     * Haal alle actieve categorieën op (voor de filter-dropdown).
     */
    public function sp_GetAllCategorieen()
    {
        return DB::select('CALL sp_GetAllCategorieen()');
    }

    /**
     * Haal alle actieve producten op, optioneel gefilterd op categorie.
     *
     * @param int|null $categorieId
     */
    public function sp_GetAllProducten($categorieId = null)
    {
        return DB::select('CALL sp_GetAllProducten(:categorieId)', [
            'categorieId' => $categorieId,
        ]);
    }

    /**
     * Haal 1 product op inclusief categorie, voorraad en leverancier.
     */
    public function sp_GetProductById($id)
    {
        return DB::selectOne('CALL sp_GetProductById(:id)', [
            'id' => $id,
        ]);
    }

    /**
     * Werk de houdbaarheidsdatum van een product bij.
     *
     * @return int aantal gewijzigde rijen
     */
    public function sp_UpdateProductHoudbaarheid($id, $nieuweHoudbaarheidsdatum)
    {
        $row = DB::selectOne(
            'CALL sp_UpdateProductHoudbaarheid(:id, :nieuweHoudbaarheidsdatum)',
            [
                'id' => $id,
                'nieuweHoudbaarheidsdatum' => $nieuweHoudbaarheidsdatum,
            ]
        );

        return $row->affected ?? 0;
    }
}
