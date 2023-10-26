<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteOrderRequest;
use App\Http\Requests\EditOrderRequest;
use App\Http\Requests\GetOrderRequest;
use App\Http\Requests\GetUserOrdersRequest;
use App\Http\Requests\NewOrderRequest;


class OrderController extends Controller
{
    public function newOrder(NewOrderRequest $request){

    }
    public function getUserOrders(GetUserOrdersRequest $request){

    }
    public function getOrder(GetOrderRequest $request){

    }
    public function editOrder(EditOrderRequest $request){

    }
    public function deleteOrder(DeleteOrderRequest $request){

    }
}
