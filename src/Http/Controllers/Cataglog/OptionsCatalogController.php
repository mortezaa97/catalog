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

class OptionsCatalogController extends Controller
{

    public function __invoke(Request $request,Catalog $catalog)
    {
        $options = [];

        $options['brands'] = BrandSimpleResource::collection(Brand::all());

        $options['prices'] = [
            ['min' => 0, 'max' => 5],
            ['min' => 5, 'max' => 10],
            ['min' => 10, 'max' => 15],
            ['min' => 15, 'max' => 20],
            ['min' => 20, 'max' => 25],
            ['min' => 25, 'max' => null],
        ];

        $options['sortTypes'] = [
            ['key' => 'lowest_price', 'label' => 'کمترین قیمت'],
            ['key' => 'highest_price', 'label' => 'بیشترین قیمت'],
            ['key' => 'most_sold', 'label' => 'پرفروش‌ترین'],
            ['key' => 'newest', 'label' => 'جدیدترین'],
            ['key' => 'highest_discount', 'label' => 'بیشترین تخفیف'],
        ];

        $catalogItems = $catalog->items(ModelType::PRODUCT->value)->get();
        
        /// add attributes which 
        return response()->json($options);

    }
}
