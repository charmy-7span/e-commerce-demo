<?php

namespace App\Services;

use App\Helpers\MediaUploaderHelper;
use App\Models\Product;
use App\Traits\ApiResponser;
use App\Traits\BaseModel;

class ProductService
{
    use BaseModel;
    private $productObj;
    public function __construct()
    {
        $this->productObj = new Product;
    }

    public function collection($inputs)
    {
        $products = $this->productObj->getQB();
        $inputs['limit'] = isset($inputs['limit']) ? $inputs['limit'] : config('site.pagination.limit');

        if (!empty($inputs['include'])) {
            $products = $products->with($inputs['include']);
        }
        
        return (isset($inputs['limit']) && $inputs['limit'] == '-1') ? $products->get() : $products->paginate($inputs['limit']);
   }

    public function store($inputs)
    {
        $product = $this->productObj->create($inputs);

        $media = MediaUploaderHelper::upload($inputs['image'], 'product');

        $product->attachMedia($media, 'product');

        return $product;
    }

    public function resource(int $id)
    {
        $product = $this->productObj->findOrFail($id);

        return $product;
    }

    public function edit(array $inputs, int $id)
    {
        $this->resource($id)->update($inputs);

        $data['message'] = 'Product detail updated successfully';

        return $data;
    }

    public function destroy(int $id)
    {
        $this->resource($id)->delete();

        $data['message'] = 'Product deleted successfully';

        return $data;
    }
}
