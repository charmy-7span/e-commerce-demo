<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Categories\Store;
use App\Http\Requests\Categories\Upsert;
use App\Http\Resources\Category\Collection;
use App\Http\Resources\Category\Resource;
use App\Models\Category;
use App\Services\CategoryService;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use ApiResponser;

    private $categoryService;

    public function __construct()
    {
        $this->categoryService = new CategoryService;
    }

    public function index(Request $request)
    {
        $categories = $this->categoryService->collection($request);

        return new Collection($categories);
    }

    public function store(Store $request)
    {
        $category = $this->categoryService->store($request->all());

        return $this->success(new Resource($category));
    }

    public function show(Category $category)
    {
        $category = $this->categoryService->resource($category->id);

        return $this->success(new Resource($category));
    }

    public function update(Upsert $request, Category $category)
    {
        $category = $this->categoryService->update($request->validated(), $category->id);

        return $category;
    }

    public function destroy(Category $category)
    {
        $category = $this->categoryService->destroy($category->id);

        return $category;
    }
}
