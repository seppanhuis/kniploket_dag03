<?php

namespace App\Http\Controllers;

use App\Models\Behandeling;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class BehandelingController extends Controller
{
    private const BEKENDE_SOORTEN = [
        'Knippen',
        'Combi behandelingen',
        'Kleuren',
        'Permanent',
        'Extensions',
    ];

    private const PER_PAGE = 4;

    private Behandeling $behandelingModel;

    public function __construct()
    {
        $this->behandelingModel = new Behandeling();
    }

    /**
     * Overzicht van alle behandelingen, met filter op soort en paginering.
     */
    public function index(Request $request)
    {
        $filter = $request->query('filter', 'alle');

        if ($filter !== 'alle' && $filter !== 'overig' && !in_array($filter, self::BEKENDE_SOORTEN, true)) {
            $filter = 'alle';
        }

        try {
            $alleBehandelingen = $this->behandelingModel->sp_GetAllBehandelingen($filter);
        } catch (\Throwable $e) {
            Log::error('BehandelingController@index - Fout bij ophalen behandelingen: ' . $e->getMessage());
            $alleBehandelingen = [];
        }

        $page = (int) LengthAwarePaginator::resolveCurrentPage('page');
        $page = $page > 0 ? $page : 1;

        $items = array_slice($alleBehandelingen, ($page - 1) * self::PER_PAGE, self::PER_PAGE);

        $behandelingen = new LengthAwarePaginator(
            $items,
            count($alleBehandelingen),
            self::PER_PAGE,
            $page,
            [
                'path' => route('behandelingen.index'),
                'query' => $request->query(),
            ]
        );

        return view('behandelingen.index', [
            'title' => 'Behandelingen',
            'behandelingen' => $behandelingen,
            'filter' => $filter,
            'soorten' => self::BEKENDE_SOORTEN,
        ]);
    }

    /**
     * Producten die gekoppeld zijn aan een specifieke behandeling.
     */
    public function producten(int $id)
    {
        try {
            $behandeling = $this->behandelingModel->sp_GetBehandelingById($id);
            abort_if(!$behandeling, 404);

            $producten = $this->behandelingModel->sp_GetProductenPerBehandeling($id);
        } catch (\Throwable $e) {
            Log::error('BehandelingController@producten - Fout bij ophalen producten: ' . $e->getMessage());
            abort(500, 'Er is een fout opgetreden bij het ophalen van de producten.');
        }

        return view('behandelingen.producten', [
            'title' => 'Producten per behandeling',
            'behandeling' => $behandeling,
            'producten' => $producten,
        ]);
    }

    /**
     * Detailpagina van één product.
     */
    public function productDetail(int $behandelingId, int $productId)
    {
        try {
            $behandeling = $this->behandelingModel->sp_GetBehandelingById($behandelingId);
            abort_if(!$behandeling, 404);

            $product = $this->behandelingModel->sp_GetProductDetail($productId);
            abort_if(!$product, 404);
        } catch (\Throwable $e) {
            Log::error('BehandelingController@productDetail - Fout bij ophalen productdetail: ' . $e->getMessage());
            abort(500, 'Er is een fout opgetreden bij het ophalen van het product.');
        }

        return view('behandelingen.product-detail', [
            'title' => 'Productdetail',
            'behandelingId' => $behandelingId,
            'product' => $product,
        ]);
    }

    /**
     * Wijzig-formulier van een product (alleen verkoopprijs is bewerkbaar).
     */
    public function productEdit(int $behandelingId, int $productId)
    {
        try {
            $behandeling = $this->behandelingModel->sp_GetBehandelingById($behandelingId);
            abort_if(!$behandeling, 404);

            $product = $this->behandelingModel->sp_GetProductDetail($productId);
            abort_if(!$product, 404);
        } catch (\Throwable $e) {
            Log::error('BehandelingController@productEdit - Fout bij ophalen product voor wijzigen: ' . $e->getMessage());
            abort(500, 'Er is een fout opgetreden bij het ophalen van het product.');
        }

        return view('behandelingen.product-edit', [
            'title' => 'Product wijzigen',
            'behandelingId' => $behandelingId,
            'product' => $product,
        ]);
    }

    /**
     * Verwerk de wijziging van de verkoopprijs.
     * Validatie: nieuwe verkoopprijs moet minimaal 30% boven de inkoopprijs liggen.
     */
    public function productUpdate(Request $request, int $behandelingId, int $productId)
    {
        $data = $request->validate([
            'nieuwe_verkoopprijs' => 'required|numeric|min:0',
        ], [
            'nieuwe_verkoopprijs.required' => 'Nieuwe verkoopprijs is verplicht.',
            'nieuwe_verkoopprijs.numeric' => 'Nieuwe verkoopprijs moet een geldig bedrag zijn.',
        ]);

        try {
            $product = $this->behandelingModel->sp_GetProductDetail($productId);
            abort_if(!$product, 404);
        } catch (\Throwable $e) {
            Log::error('BehandelingController@productUpdate - Fout bij ophalen product: ' . $e->getMessage());

            return back()->withInput()->with('error', 'Gegevens niet bijgewerkt');
        }

        $minimumVerkoopprijs = round(((float) $product->InkoopPrijs) * 1.3, 2);
        $nieuweVerkoopprijs = (float) $data['nieuwe_verkoopprijs'];

        if ($nieuweVerkoopprijs < $minimumVerkoopprijs) {
            return back()
                ->withInput()
                ->withErrors(['nieuwe_verkoopprijs' => 'Verkoopprijs moet minimaal 30 procent boven de inkoopprijs liggen.'])
                ->with('error', 'Gegevens niet bijgewerkt');
        }

        try {
            $affected = $this->behandelingModel->sp_UpdateProductVerkoopprijs($productId, $nieuweVerkoopprijs);
        } catch (\Throwable $e) {
            Log::error('BehandelingController@productUpdate - Fout bij bijwerken verkoopprijs: ' . $e->getMessage());

            return back()->withInput()->with('error', 'Gegevens niet bijgewerkt');
        }

        if ($affected > 0) {
            return redirect()
                ->route('behandelingen.producten.show', [$behandelingId, $productId])
                ->with('success', 'Productprijs bijgewerkt.');
        }

        return back()->withInput()->with('error', 'Gegevens niet bijgewerkt');
    }
}
