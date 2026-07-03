# Database opzetten (voor iedereen die het project van GitHub trekt)

Dit project gebruikt geen Laravel-migrations voor de eigen tabellen (Product,
Categorie, Klant, enz.) en stored procedures — die moeten **handmatig** in
MySQL aangemaakt worden. Vergeet je dat (of doe je het in de verkeerde
database), dan werken pagina's die stored procedures gebruiken niet, zoals nu
met de producten-pagina gebeurde.

## Stappen

1. **Database aanmaken** (bijv. via phpMyAdmin of `CREATE DATABASE kniploket_dag03;`)
   — de naam moet **exact** overeenkomen met `DB_DATABASE` in je `.env`.

2. **.env instellen op MySQL** (niet sqlite, dat is de standaard in `.env.example`):
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=kniploket_dag03
   DB_USERNAME=root
   DB_PASSWORD=
   ```

3. **Laravel-tabellen aanmaken:**
   ```
   php artisan migrate
   ```
   (dit maakt `users`, `cache`, `jobs`, `passkeys`)

4. **Alle overige tabellen, testdata én stored procedures in één keer aanmaken:**
   Importeer `00_setup_database.sql` in je database — bijvoorbeeld via
   phpMyAdmin: kies je database → tabblad "Importeren" → dit bestand
   selecteren → Start.

   Of via de terminal:
   ```
   mysql -u root -p kniploket_dag03 < 00_setup_database.sql
   ```

   Dit bestand doet automatisch, in de juiste volgorde:
   - `userinsert.sql` (vult `users`, nodig omdat andere tabellen daarnaar verwijzen)
   - `createscript.sql` (maakt alle overige tabellen + testdata)
   - **alle** stored procedures uit `database/scripts/*/*.sql`, inclusief die
     voor producten (`sp_GetAllProducten`, `sp_GetAllCategorieen`,
     `sp_GetProductById`, `sp_UpdateProductHoudbaarheid`)

5. Klaar. `php artisan serve` starten en de producten-pagina zou nu moeten werken.

## Als het nog steeds niet werkt

Kijk in `storage/logs/laravel.log` na een bezoek aan `/producten`. Staat daar
iets als `PROCEDURE ... does not exist` of `Unknown database`? Dan is stap 2
of 4 hierboven niet (goed) uitgevoerd — meestal doordat de databasenaam in
`.env` niet overeenkomt met de database waarin het script is geïmporteerd.
