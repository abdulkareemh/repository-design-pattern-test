<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }
    public function index()
    {
        return $this->productRepository->getAll();
    }

    public function store(ProductStoreRequest $request)
    {
        try {
            return $this->productRepository->create($request->validated());
        } catch (\Exception $e) {
            logger()->error('Error creating product: ' . $e->getMessage());

            return response()->json(['error' => 'An error occurred while creating the product.'], 500);
        }
    }

    public function show(string $id)
    {
        return $this->productRepository->getById($id);
    }

    public function update(Request $request, $id)
    {
        try {
            $product = Product::findOrfail($id);
            $validator = Validator::make($request->all(), [
                'name' => 'sometimes|required|string|max:255',
                'description' => 'sometimes|required|string',
                'price' => 'sometimes|required|numeric|min:0',
                'username' => [
                    'sometimes',
                    'string',
                    'max:255',
                    Rule::unique('product', 'slug')->ignore($product ? $product->id : null),
                ],
                'is_active' => 'nullable|boolean',
            ]);
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }
            return $this->productRepository->update($product, $request->all());
        } catch (\Exception $e) {
            logger()->error('Error update update: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while update the product.'], 500);
        }
    }

    public function destroy(string $id)
    {
        
        try {
            return  $this->productRepository->delete($id);
        } catch (\Exception $e) {
            logger()->error('Error deleted product: ' . $e->getMessage());

            return response()->json(['error' => 'An error occurred while deleted the product.'], 500);
        }
    }

    public function updateImage(Request $request, $id)
    {
        try {
            $product = Product::findOrfail($id);
            $validator = $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
            return $this->productRepository->updateImage($product, $request->image);
        } catch (\Exception $e) {
            logger()->error('Error update prudoct: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while update prudoct.'], 500);
        }
    }
}
