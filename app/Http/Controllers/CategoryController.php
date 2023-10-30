<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteCategoryRequest;
use App\Http\Requests\EditCategoryRequest;
use App\Http\Requests\GetProductCategoryRequest;
use App\Http\Requests\NewCategoryRequest;
use App\Models\Products_category;
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
        DB::table('products_categories')
            ->where('id', '=', $data['category_id'])
            ->update([
                'is_deleted' => true
            ]);
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
}
