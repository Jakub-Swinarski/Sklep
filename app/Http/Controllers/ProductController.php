<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangeDescriptionRequest;
use App\Http\Requests\ChangeNameRequest;
use App\Http\Requests\ChangePriceRequest;
use App\Http\Requests\changeSupplyRequest;
use App\Http\Requests\DeleteImageRequest;
use App\Http\Requests\DeleteProductRequest;
use App\Http\Requests\DeleteRatingRequest;
use App\Http\Requests\GetProductRequest;
use App\Http\Requests\NewImageRequest;
use App\Http\Requests\NewProductRequest;
use App\Models\Product;
use App\Models\Product_image;
use Exception;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function getProduct(GetProductRequest $request)
    {
        $data = $request->validated();
        return Product::with(['images', 'ratings', 'categories'])
            ->find($data['product_id']);
    }

    public function getAllProducts()
    {
        return Product::with(['first_image'])
            ->get();
    }

    public function newProduct(NewProductRequest $request)
    {
        $data = $request->validated();
        DB::beginTransaction();
        try {
            $product_id = DB::table('products')
                ->insertGetId([
                    'name' => $data['name'],
                    'price' => $data['price'],
                    'supply' => $data['supply'],
                    'description' => $data['description']
                ]);
            if (isset($data['images'])) {
                foreach ($data['images'] as $image) {
                    DB::table('products_images')
                        ->insert([
                            'product_id' => $product_id,
                            'image' => $image
                        ]);
                }
            }
            if (isset($data['categories'])) {
                foreach ($data['categories'] as $category) {
                    $category_id = DB::table('products_categories')
                        ->where('name', '=', $category)
                        ->first();
                    DB::table('products_products_categories')
                        ->insert([
                            'product_id' => $product_id,
                            'category_id' => $category_id
                        ]);
                }
            }
            if (isset($data['newCategories'])) {
                foreach ($data['newCategories'] as $category) {
                    $category_id = DB::table('products_categories')
                        ->insertGetId([
                            'name' => $category
                        ]);
                    DB::table('products_products_categories')
                        ->insert([
                            'product_id' => $product_id,
                            'category_id' => $category_id
                        ]);
                }
            }
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            return $exception;
        }
        return true;
    }

    public function deleteImage(DeleteImageRequest $request){
        $data = $request->validated();
        Product_image::find($data['product_id'])
            ->delete();
    }
    public function newImage(NewImageRequest $request)
    {
        $file = request()->file('image');
        $filename = uniqid("product_image_") . "." .  $file->extension();
        $file->storeAs('public', $filename);

        $product_image = new Product_image;
        $product_image->product_id = request()->get('product_id');
        $product_image->image = $filename;
        $product_image->save();
    }

    public function changeSupply(changeSupplyRequest $request)
    {
        $data = $request->validated();
        DB::table('products')
            ->where('id', '=', $data['product_id'])
            ->update([
                'supply' => $data['supply']
            ]);
    }

    public function changeName(ChangeNameRequest $request)
    {
        $data = $request->validated();
        DB::table('products')
            ->where('id', '=', $data['product_id'])
            ->update([
                'name' => $data['name']
            ]);
    }

    public function changeDescription(ChangeDescriptionRequest $request)
    {
        $data = $request->validated();
        DB::table('products')
            ->where('id', '=', $data['product_id'])
            ->update([
                'description' => $data['description']
            ]);
    }

    public function changePrice(ChangePriceRequest $request)
    {
        $data = $request->validated();
        DB::table('products')
            ->where('id', '=', $data['product_id'])
            ->update([
                'price' => $data['price']
            ]);
    }

    public function deleteProduct(DeleteProductRequest $request)
    {
        $data = $request->validated();
        Product::find($data['product_id'])
            ->delete();
    }
}
