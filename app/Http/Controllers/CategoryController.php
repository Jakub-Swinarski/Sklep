<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddCategoryToProductRequest;
use App\Http\Requests\DeleteCategoryRequest;
use App\Http\Requests\EditCategoryRequest;
use App\Http\Requests\GetProductCategoryRequest;
use App\Http\Requests\NewCategoryRequest;
use App\Models\Products_category;
use App\Models\Products_products_category;
use App\Models\User;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function newCategory(NewCategoryRequest $request)
    {
        $data = $request->validated();
        DB::table('products_categories')
            ->insert([
                'name' => $data['name']
            ]);
    }

    public function editCategory(EditCategoryRequest $request)
    {
        $data = $request->validated();

        DB::table('products_categories')
            ->where('id', '=', $data['category_id'])
            ->update([
                'name' => $data['name']
            ]);
    }

    public function deleteCategory(DeleteCategoryRequest $request)
    {
        $data = $request->validated();
        return Products_products_category::where('product_id',$data['product_id'])
            ->where('category_id',$data['category_id'])
            ->delete();
    }

    public function getAllCategories()
    {

        return DB::table('products_categories')
            ->get();
    }

    public function getProductCategory(GetProductCategoryRequest $request)
    {
        $data = $request->validated();
        return DB::table('products')
            ->where('id', '=', $data['product_id'])
            ->leftJoin('products_products_categories', function (JoinClause $join) {
                $join->on('id', '=', 'product_id');
                $join->leftJoin('products_categories', 'category_id', '=', 'id');
            })->get();
    }
    public function addCategoryToProduct(AddCategoryToProductRequest $request){
        $data = $request->validated();
        $category = Products_category::firstWhere('name',$data['name']);
        if (isset($category)){
            $category_product = new Products_products_category();
            $category_product->category_id = $category->id;
            $category_product->product_id = $data['product_id'];
            $category_product->save();
        }else{
            $category_id = Products_category::insertGetId(['name' => $data['name']]);
            Products_products_category::insert([
                'category_id' => $category_id,
                'product_id' => $data['product_id']
            ]);
        }
    }
}
