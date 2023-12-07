<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddLikeRequest;
use App\Http\Requests\DeleteLikeRequest;
use App\Http\Requests\GetProductLikeRequest;
use App\Http\Requests\GetUserLikeRequest;
use App\Models\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function addLike(AddLikeRequest $request)
    {
        $data = $request->validated();
        $like = new Like();
        $like->user_id = $data['user_id'];
        $like->product_id = $data['product_id'];
        $like->save();
    }

    public function deleteLike(DeleteLikeRequest $request)
    {
        $data = $request->validated();
        Like::where('id', $data['like_id'])->delete();
    }

    public function getUserLike(GetUserLikeRequest $request)
    {
        $data = $request->validated();
        return Like::where('user_id', $data['user_id'])->get();
    }

    public function getProductLike(GetProductLikeRequest $request)
    {
        $data = $request->validated();
        return Like::where(['product_id', $data['product_id'], 'user_id', $data['user_id']])->first();
    }
}
