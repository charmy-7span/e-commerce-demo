<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Products\Store;
use App\Http\Requests\Products\Upsert;
use App\Http\Resources\Product\Collection;
use App\Http\Resources\Product\Resource;
use App\Models\Product;
use App\Services\ProductService;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

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

    public function store(Store $request)
    {
        $product = $this->productService->store($request->all());

        return $this->success(new Resource($product));
    }

    public function show(Product $product)
    {
        $product = $this->productService->resource($product->id);

        return $this->success(new Resource($product));
    }

    public function update(Upsert $request, Product $product)
    {   
        $product = $this->productService->edit($request->validated(), $product->id);

        return $product;
    }

    public function destroy(Product $product)
    {
        $product = $this->productService->destroy($product->id);

        return $product;
    }
}
