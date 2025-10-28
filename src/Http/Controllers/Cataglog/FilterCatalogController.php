<?php

namespace Mortezaa97\Catalogs\Http\Controllers\Cataglog;

use App\Enums\ModelType;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mortezaa97\Brands\Http\Resources\BrandSimpleResource;
use Mortezaa97\Brands\Models\Brand;
use Mortezaa97\Catalogs\Models\Catalog;
use Mortezaa97\Shop\Models\Attribute;
use Mortezaa97\Shop\Models\AttributeValue;

class FilterCatalogController extends Controller
{

    public function __invoke(Request $request,Catalog $catalog)
    {
        
        return response()->json('success');

    }
}
