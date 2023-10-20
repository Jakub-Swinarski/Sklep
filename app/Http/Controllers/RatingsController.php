<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteRatingRequest;
use App\Http\Requests\EditRatingRequest;
use App\Http\Requests\GetProductRatingsRequest;
use App\Http\Requests\GetRatingRequest;
use App\Http\Requests\GetUserRatingsRequest;
use App\Http\Requests\NewRatingRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RatingsController extends Controller
{
    public function newRating(NewRatingRequest $request){
        $data = $request->validated();
        DB::table('ratings')
            ->insert([
                'product_id' => $data['product_id'],
                'user_id' => auth()->id(),
                'rating' => $data['rating'],
                'heading' => $data['heading'],
                'description' => $data['description']
            ]);
    }
    public function editRating(EditRatingRequest $request){
        $data = $request->validated();
        if (isset($data['rating'])){
            DB::table('ratings')
                ->where('id','=',$data['rating_id'])
                ->update([
                    'rating' => $data['rating'],
                    'is_edited' => true
                ]);
        }
        if (isset($data['heading'])){
            DB::table('ratings')
                ->where('id','=',$data['rating_id'])
                ->update([
                    'heading' => $data['heading'],
                    'is_edited' => true
                ]);
        }
        if (isset($data['description'])){
            DB::table('ratings')
                ->where('id','=',$data['rating_id'])
                ->update([
                    'description' => $data['description'],
                    'is_edited' => true
                ]);
        }
    }
    public function getRating(GetRatingRequest $request){
        $data = $request->validated();
        return DB::table('ratings')
            ->where('id','=',$data['rating_id'])
            ->get();

    }
    public function getProductRatings(GetProductRatingsRequest $request){
        $data = $request->validated();
        return DB::table('ratings')
            ->where( 'product_id','=', $data['product_id'])
            ->get();

    }
    public function getUserRatings(GetUserRatingsRequest $request){
        $data = $request->validated();
        return DB::table('ratings')
            ->where( 'user_id','=', $data['user_id'])
            ->get();
    }
    public function deleteRating(DeleteRatingRequest $request){
        $data = $request->validated();
        DB::table('ratings')
            ->where('id','=', $data['rating_id'])
            ->update([
                'is_deleted' => true
            ]);
    }
}
