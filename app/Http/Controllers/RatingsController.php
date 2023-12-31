<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteRatingRequest;
use App\Http\Requests\EditRatingRequest;
use App\Http\Requests\GetProductRatingsRequest;
use App\Http\Requests\GetRatingRequest;
use App\Http\Requests\GetUserRatingsRequest;
use App\Http\Requests\NewRatingRequest;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RatingsController extends Controller
{
    public function newRating(NewRatingRequest $request)
    {
        $data = $request->validated();
        $rating_id = DB::table('ratings')
            ->insertGetId([
                'product_id' => $data['product_id'],
                'user_id' => auth()->id(),
                'rating' => $data['rating'],

            ]);
        if (isset($data['heading'])) {
            DB::table('ratings')
                ->where('id', '=', $rating_id)
                ->insert(['heading' => $data['heading']]);

        }
        if (isset($data['description'])) {
            DB::table('ratings')
                ->where('id', '=', $rating_id)
                ->insert(['description' => $data['description']]);

        }
    }

    public function editRating(EditRatingRequest $request)
    {
        $data = $request->validated();
        if (isset($data['rating'])) {
            Rating::where('id', '=', $data['rating_id'])
                ->update([
                    'rating' => $data['rating'],
                ]);
        }
        if (isset($data['heading'])) {
            Rating::where('id', '=', $data['rating_id'])
                ->update([
                    'heading' => $data['heading'],
                ]);
        }
        if (isset($data['description'])) {
            Rating::where('id', '=', $data['rating_id'])
                ->update([
                    'description' => $data['description'],
                ]);
        }
        return true;
    }

    public function getRating(GetRatingRequest $request)
    {
        $data = $request->validated();
        return DB::table('ratings')
            ->where('id', '=', $data['rating_id'])
            ->get();

    }

    public function getProductRatings(GetProductRatingsRequest $request)
    {
        $data = $request->validated();
        return DB::table('ratings')
            ->where('product_id', '=', $data['product_id'])
            ->get();

    }

    public function getUserRatings(GetUserRatingsRequest $request)
    {
        $data = $request->validated();
        return Rating::with('product')->where('user_id', $data['user_id'])->get();
    }

    public function deleteRating(DeleteRatingRequest $request)
    {
        $data = $request->validated();
        DB::table('ratings')
            ->where('id', '=', $data['rating_id'])
            ->update([
                'is_deleted' => true
            ]);
    }
}
