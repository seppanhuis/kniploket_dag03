<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Medewerker extends Model
{
    protected $table = 'Medewerker';

    public function sp_GetAllMedewerkers(?string $specialisatie = 'alle'): array
    {
        return DB::select('CALL sp_GetAllMedewerkers(:specialisatie)', [
            'specialisatie' => $specialisatie,
        ]);
    }

    public function sp_GetMedewerkerById(int $id)
    {
        return DB::selectOne('CALL sp_GetMedewerkerById(:id)', [
            'id' => $id,
        ]);
    }

    public function sp_UpdateMedewerker(array $data): int
    {
        $row = DB::selectOne(
            'CALL sp_UpdateMedewerker(:id, :voornaam, :tussenvoegsel, :achternaam, :specialisatie, :geboortedatum, :contactEmail, :straatnaam, :huisnummer, :toevoeging, :postcode, :plaats, :mobiel, :opmerking)',
            [
                'id' => $data['id'],
                'voornaam' => $data['voornaam'],
                'tussenvoegsel' => $data['tussenvoegsel'],
                'achternaam' => $data['achternaam'],
                'specialisatie' => $data['specialisatie'],
                'geboortedatum' => $data['geboortedatum'],
                'contactEmail' => $data['contact_email'],
                'straatnaam' => $data['straatnaam'],
                'huisnummer' => $data['huisnummer'],
                'toevoeging' => $data['toevoeging'],
                'postcode' => $data['postcode'],
                'plaats' => $data['plaats'],
                'mobiel' => $data['mobiel'],
                'opmerking' => $data['opmerking'],
            ]
        );

        return $row->affected ?? 0;
    }
}
