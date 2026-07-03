<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;

class ProductController extends Controller
{
    private $productModel;

    /**
     * Aantal producten per pagina, zoals in de wireframe (10 producten -> 3 pagina's).
     */
    private const PER_PAGE = 4;

    public function __construct()
    {
        $this->productModel = new Product();
    }

    /**
     * User Story_07 - Overzicht producten (Wireframe-02 / Wireframe-04)
     */
    public function index(Request $request)
    {
        try {
            $categorieIdRaw = $request->query('categorie_id');
            $categorieId = ($categorieIdRaw !== null && $categorieIdRaw !== '')
                ? (int) $categorieIdRaw
                : null;

            $alleProducten = $this->productModel->sp_GetAllProducten($categorieId);
            $categorieen = $this->productModel->sp_GetAllCategorieen();

            $huidigePagina = (int) $request->query('page', 1);
            $totaalAantal = count($alleProducten);
            $items = array_slice(
                $alleProducten,
                ($huidigePagina - 1) * self::PER_PAGE,
                self::PER_PAGE
            );

            $producten = new LengthAwarePaginator(
                $items,
                $totaalAantal,
                self::PER_PAGE,
                $huidigePagina,
                [
                    'path' => $request->url(),
                    'query' => $request->query(),
                ]
            );

            return view('producten.index', [
                'title' => 'Producten',
                'producten' => $producten,
                'categorieen' => $categorieen,
                'geselecteerdeCategorieId' => $categorieId,
            ]);
        } catch (\Throwable $e) {
            report($e);

            return back()->with('error', 'Er is een fout opgetreden bij het ophalen van de producten.');
        }
    }

    /**
     * Productdetail (Wireframe-03 / Wireframe-05)
     */
    public function show($id)
    {
        try {
            $product = $this->productModel->sp_GetProductById($id);
            abort_if(!$product, 404);

            return view('producten.show', [
                'title' => 'Productdetail',
                'product' => $product,
            ]);
        } catch (\Throwable $e) {
            report($e);

            return redirect()->route('producten.index')
                ->with('error', 'Er is een fout opgetreden bij het ophalen van het product.');
        }
    }

    /**
     * User Story_08 - Product wijzigen (Wireframe-04 editform)
     */
    public function edit($id)
    {
        try {
            $product = $this->productModel->sp_GetProductById($id);
            abort_if(!$product, 404);

            return view('producten.edit', [
                'title' => 'Product wijzigen',
                'product' => $product,
            ]);
        } catch (\Throwable $e) {
            report($e);

            return redirect()->route('producten.index')
                ->with('error', 'Er is een fout opgetreden bij het ophalen van het product.');
        }
    }

    /**
     * User Story_08 - Houdbaarheidsdatum bijwerken, maximaal 7 dagen verlengen
     * (Wireframe-05 succes / Wireframe-06 fout)
     */
    public function update(Request $request, $id)
    {
        $product = $this->productModel->sp_GetProductById($id);
        abort_if(!$product, 404);

        $data = $request->validate([
            'nieuwe_houdbaarheidsdatum' => 'required|date',
        ]);

        $huidigeDatum = Carbon::parse($product->Houdbaarheidsdatum)->startOfDay();
        $nieuweDatum = Carbon::parse($data['nieuwe_houdbaarheidsdatum'])->startOfDay();

        if ($nieuweDatum->lessThanOrEqualTo($huidigeDatum)) {
            return back()
                ->withInput()
                ->withErrors([
                    'nieuwe_houdbaarheidsdatum' => 'De nieuwe houdbaarheidsdatum moet na de huidige houdbaarheidsdatum liggen.',
                ])
                ->with('error', 'Gegevens niet bijgewerkt');
        }

        if ($huidigeDatum->diffInDays($nieuweDatum) > 7) {
            return back()
                ->withInput()
                ->withErrors([
                    'nieuwe_houdbaarheidsdatum' => 'De houdbaarheidsdatum is met meer dan 7 dagen verlengd.',
                ])
                ->with('error', 'Gegevens niet bijgewerkt');
        }

        try {
            $aangepast = $this->productModel->sp_UpdateProductHoudbaarheid(
                $id,
                $nieuweDatum->format('Y-m-d')
            );

            if ($aangepast > 0) {
                return redirect()->route('producten.show', $id)
                    ->with('success', 'Houdbaarheidsdatum bijgewerkt.');
            }

            return back()
                ->withInput()
                ->with('error', 'Gegevens niet bijgewerkt');
        } catch (\Throwable $e) {
            report($e);

            return back()
                ->withInput()
                ->with('error', 'Gegevens niet bijgewerkt');
        }
    }
}
