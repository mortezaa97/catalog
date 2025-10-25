<?php

namespace Mortezaa97\Catalogs\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Mortezaa97\Catalogs\Http\Resources\ModelHasCatalogResource;
use Mortezaa97\Catalogs\Models\ModelHasCatalog;

class ModelHasCatalogController extends Controller
{
    public function index()
    {
        Gate::authorize('viewAny', ModelHasCatalog::class);
        return ModelHasCatalogResource::collection(ModelHasCatalog::all());
    }

    public function store(Request $request)
    {
        Gate::authorize('create', ModelHasCatalog::class);
        try {
            DB::beginTransaction();
            DB::commit();
        } catch (\Exception $exception) {
            return response()->json($exception->getMessage(),419);
        }
        return new ModelHasCatalogResource($modelHasCatalog);
    }

    public function show(ModelHasCatalog $modelHasCatalog)
    {
        Gate::authorize('view', $modelHasCatalog);
        return new ModelHasCatalogResource($modelHasCatalog);
    }

    public function update(Request $request, ModelHasCatalog $modelHasCatalog)
    {
        Gate::authorize('update', $modelHasCatalog);
        try {
            DB::beginTransaction();
            DB::commit();
        } catch (\Exception $exception) {
            return response()->json($exception->getMessage(),419);
        }
        return new ModelHasCatalogResource($modelHasCatalog);
    }

    public function destroy(ModelHasCatalog $modelHasCatalog)
    {
        Gate::authorize('delete', $modelHasCatalog);
        try {
            DB::beginTransaction();
            DB::commit();
        } catch (\Exception $exception) {
            return response()->json($exception->getMessage(),419);
        }
        return response()->json("با موفقیت حذف شد");
    }
}
