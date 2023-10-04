<?php

namespace App\Http\Controllers\Api\V1\Front;

use App\Models\Product;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Http\Controllers\Controller;
use App\Http\Resources\Product\Resource;
use App\Http\Resources\Product\Collection;

class ProductController extends Controller
{
    use ApiResponser;

    protected $productService;

    public function __construct()
    {
        $this->productService = new ProductService;
    }

    public function index(Request $request)
    {
        $products = $this->productService->collection($request);

        return new Collection($products);
    }

    public function show(Product $product)
    {
        $product = $this->productService->resource($product->id);

        return $this->success(new Resource($product));
    }
}
