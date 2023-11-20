<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteOrderRequest;
use App\Http\Requests\EditOrderRequest;
use App\Http\Requests\GetOrderRequest;
use App\Http\Requests\GetUserOrdersRequest;
use App\Http\Requests\NewOrderRequest;
use App\Models\Order;
use Illuminate\Support\Facades\DB;


class OrderController extends Controller
{
    public function newOrder(NewOrderRequest $request)
    {

    }

    public function getUserOrders(GetUserOrdersRequest $request)
    {

    }

    public function getOrder(GetOrderRequest $request)
    {
        $data = $request->validated();
        return Order::with(['products','typeOfDelivery', 'user', 'address'])->find($data['order_id']);
    }
    public function getAllOrders(){
        return Order::with(['products','typeOfDelivery', 'user', 'address'])->get();
    }

    public function editOrder(EditOrderRequest $request)
    {

    }

    public function deleteOrder(DeleteOrderRequest $request)
    {

    }
}
