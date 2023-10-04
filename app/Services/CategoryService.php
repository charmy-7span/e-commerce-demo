<?php

namespace App\Services;

use App\Helpers\MediaUploaderHelper;
use App\Http\Requests\Categories\Upsert;
use App\Models\Category;
use Plank\Mediable\Facades\MediaUploader;

class CategoryService
{
    // use MediaUploader;
    //use the facade
    private $categoryObj;

    public function __construct()
    {
        $this->categoryObj = new Category;
    }

    public function collection($inputs)
    {
        $categories = $this->categoryObj->query();

        if (!empty($inputs['include'])) {
            $categories->with($inputs['include']);
        }

        return (isset($inputs['limit']) && $inputs['limit'] == '-1') ? $categories->get() : $categories->paginate($inputs['limit']);
    }
    public function store($inputs)
    {
        $category = $this->categoryObj->create($inputs);
    
        $media = MediaUploaderHelper::upload($inputs['image'], 'category');

        $category->attachMedia($media, 'category');
        return $category;
    }

    public function resource(int $id)
    {
        $category = $this->categoryObj->findOrFail($id);

        return $category;
    }

    public function update(array $inputs, int $id)
    {
        $this->resource($id)->update($inputs);

        $data['message'] = 'Category detail updated successfully';

        return $data;
    }

    public function destroy(int $id)
    {
        $this->resource($id)->delete();

        $data['message'] = 'Category deleted successfully';

        return $data;
    }
}
