<?php


namespace App\Repositories;

use App\Models\Product;
use App\Services\StoreImageService;
use Illuminate\Http\UploadedFile;

class ProductRepository
{
    protected $model;
    protected $imgaeService;
    public function __construct(Product $product, StoreImageService $imgaeService)
    {
        $this->model = $product;
        $this->imgaeService = $imgaeService;
    }
    public function getAll()
    {
        return $this->model->all();
    }

    function getById($id)
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data)
    {

        $product = Product::create($data);

        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            $product->image = $this->imgaeService->storeImage($data['image'], 'products');
            $product->save();
        }

        return $product;
    }

    public function update(Product $product, array $data)
    {
        $product->update($data);
        return $product;
    }

    public function delete($id)
    {
        $product = $this->model->find($id);
        $imgePath = public_path($product->getRawOriginal('image'));
        if (file_exists($imgePath)) {
            unlink($imgePath);
        }
        return $this->model->destroy($id);
    }

    function updateImage(Product $product,$image) {
        $imagePath = public_path($product->getRawOriginal('image'));
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
        $product->image = $this->imgaeService->storeImage($image, 'products');
        $product->save();
        return $product;
    }
}
