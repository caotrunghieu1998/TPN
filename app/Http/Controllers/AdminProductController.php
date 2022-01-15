<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use App\Components\Recusive;
use App\Http\Requests\ProductAddRequest;
use App\ProductImage;
use App\ProductTag;
use App\Tag;
use App\Traits\StorageImageTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AdminProductController extends Controller
{
    use StorageImageTrait;
    private $category;
    private $product;
    private $productImage;
    private $tag;
    private $productTag;

    public function __construct()
    {
        $this->category = new Category();
        $this->product = new Product();
        $this->productImage = new ProductImage();
        $this->tag = new Tag();
        $this->productTag = new ProductTag();
    }
    // Get view index
    public function index()
    {
        if(!auth()->check()){
            return redirect()->route('admin.login');
        }
        $products = $this->product->latest()->paginate(5);
        return view('admin.products.index', compact('products'));
    }
    // Get view Create
    public function create()
    {
        if(!auth()->check()){
            return redirect()->route('admin.login');
        }
        $htmlOption = $this->getCategory('');
        return view('admin.products.add', compact('htmlOption'));
    }
    // Get all category (Distinguish parent and child)
    public function getCategory($parentId)
    {
        $data = $this->category->all();
        $recusive = new Recusive($data);
        return $recusive->categoryRecusive($parentId);
    }
    // Add new product
    public function store(ProductAddRequest $request)
    {
        try {
            DB::beginTransaction();
            $dataProductCreate = [
                'name' => $request->name,
                'price' => $request->price,
                'content' => $request->content,
                'user_id' => auth()->id(),
                'category_id' => $request->category_id
            ];
            $dataUploadFeatureImage = $this->storageTraitUpload($request, 'feature_image_path', 'product');
            if (!empty($dataUploadFeatureImage)) {
                $dataProductCreate['feature_image_name'] = $dataUploadFeatureImage['file_name'];
                $dataProductCreate['feature_image_path'] = $dataUploadFeatureImage['file_path'];
            }
            $productInfo = $this->product->create($dataProductCreate);
            // Insert Data to product_images
            if ($request->hasFile('image_path')) {
                foreach ($request->image_path as $fileItem) {
                    $dataProductImageDetail = $this->storageTraitUploadMutiple($fileItem, 'product');
                    $productInfo->images()->create([
                        'product_id' => $productInfo->id,
                        'image_path' => $dataProductImageDetail['file_path'],
                        'image_name' => $dataProductImageDetail['file_name']
                    ]);
                }
            }
            $tagIds = [];
            // Insert tags for product
            if (!empty($request->tags)) {
                foreach ($request->tags as $tagItem) {
                    // Insert to tags
                    $tagInstance = $this->tag->firstOrCreate(['name' => $tagItem]);
                    array_push($tagIds, $tagInstance->id);
                }
            }
            $productInfo->tags()->attach($tagIds);
            DB::commit();
            return redirect()->route('product.index');
        } catch (\Exception $ex) {
            DB::rollBack();
            Log::error('Message: ' . $ex->getMessage() . '---Line:' . $ex->getLine());
        }
    }
    // Get view edit
    public function edit($id)
    {
        if(!auth()->check()){
            return redirect()->route('admin.login');
        }
        $product = $this->product->find($id);
        if (empty($product)) {
            return redirect()->route('product.index');
        }
        $htmlOption = $this->getCategory($product->category_id);
        return view('admin.products.edit', compact('htmlOption', 'product'));
    }
    // Update function
    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $dataProductUpdate = [
                'name' => $request->name,
                'price' => $request->price,
                'content' => $request->content,
                'user_id' => auth()->id(),
                'category_id' => $request->category_id
            ];
            $dataUploadFeatureImage = $this->storageTraitUpload($request, 'feature_image_path', 'product');
            if (!empty($dataUploadFeatureImage)) {
                $dataProductUpdate['feature_image_name'] = $dataUploadFeatureImage['file_name'];
                $dataProductUpdate['feature_image_path'] = $dataUploadFeatureImage['file_path'];
            }
            $productInfo = $this->product->find($id);
            if (!empty($productInfo)) {
                $productInfo->update($dataProductUpdate);
                // Insert Data to product_images
                if ($request->hasFile('image_path')) {
                    $this->productImage->where('product_id', $id)->delete();
                    foreach ($request->image_path as $fileItem) {
                        $dataProductImageDetail = $this->storageTraitUploadMutiple($fileItem, 'product');
                        $productInfo->images()->create([
                            'product_id' => $productInfo->id,
                            'image_path' => $dataProductImageDetail['file_path'],
                            'image_name' => $dataProductImageDetail['file_name']
                        ]);
                    }
                }
                $tagIds = [];
                // Insert tags for product
                if (!empty($request->tags)) {
                    foreach ($request->tags as $tagItem) {
                        // Insert to tags
                        $tagInstance = $this->tag->firstOrCreate(['name' => $tagItem]);
                        array_push($tagIds, $tagInstance->id);
                    }
                }
                $productInfo->tags()->sync($tagIds);
            }
            DB::commit();
            return redirect()->route('product.index');
        } catch (\Exception $ex) {
            DB::rollBack();
            Log::error('Message: ' . $ex->getMessage() . '---Line:' . $ex->getLine());
        }
    }
    // Delete Function
    public function delete($id)
    {
        try {
            $this->product->find($id)->delete();
            return response()->json([
                'code' => 200,
                'message' => 'success'
            ], 200);
        } catch (\Exception $ex) {
            Log::error('Message: ' . $ex->getMessage() . '---Line:' . $ex->getLine());
            return response()->json([
                'code' => 500,
                'message' => 'fail'
            ], 500);
        }
    }
}
