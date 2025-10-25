<?php

namespace App\Http\Controllers;

use App\Models\Catalog;
use Illuminate\Http\Request;;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Mortezaa97\Catalogs\Http\Resources\CatalogResource;
class CatalogController extends Controller
{
    public function index()
    {
        Gate::authorize('viewAny', Catalog::class);
        return CatalogResource::collection(Catalog::all());
    }

    public function store(Request $request)
    {
        Gate::authorize('create', Catalog::class);
        try {
            DB::beginTransaction();
            DB::commit();
        } catch (\Exception $exception) {
            return response()->json($exception->getMessage(),419);
        }
        return new CatalogResource($catalog);
    }

    public function show(Catalog $catalog)
    {
        Gate::authorize('view', $catalog);
        return new CatalogResource($catalog);
    }

    public function update(Request $request, Catalog $catalog)
    {
        Gate::authorize('update', $catalog);
        try {
            DB::beginTransaction();
            DB::commit();
        } catch (\Exception $exception) {
            return response()->json($exception->getMessage(),419);
        }
        return new CatalogResource($catalog);
    }

    public function destroy(Catalog $catalog)
    {
        Gate::authorize('delete', $catalog);
        try {
            DB::beginTransaction();
            DB::commit();
        } catch (\Exception $exception) {
            return response()->json($exception->getMessage(),419);
        }
        return response()->json("با موفقیت حذف شد");
    }
}
