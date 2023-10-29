<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteOrderRequest;
use App\Http\Requests\EditOrderRequest;
use App\Http\Requests\GetOrderRequest;
use App\Http\Requests\GetUserOrdersRequest;
use App\Http\Requests\NewOrderRequest;
use Illuminate\Support\Facades\DB;


class OrderController extends Controller
{
    public function newOrder(NewOrderRequest $request)
    {
        $data = $request->validated();
        $order_id = DB::table('orders')
            ->insertGetId([
                'type_of_delivery' => $data['delivery_id'],
                'address' => $data['address_id'],
                'pay_online' => $data['pay'],
                'invoice_id' => $data['invoice_id']
            ]);
        foreach ($data['products'] as $product){
            DB::table('orders_products')
                ->insert([
                    'order_id' => $order_id,
                    'products_id' => $product['id']
                ]);
        }
    }

    public function getUserOrders(GetUserOrdersRequest $request)
    {

    }

    public function getOrder(GetOrderRequest $request)
    {

    }

    public function editOrder(EditOrderRequest $request)
    {

    }

    public function deleteOrder(DeleteOrderRequest $request)
    {
        $data = $request->validated();
        DB::table('orders')
            ->where('id', '=', $data['order_id'])
            ->update([
                'is_deleted' => true
            ]);

    }
}
