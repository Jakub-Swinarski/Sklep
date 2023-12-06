<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteOrderRequest;
use App\Http\Requests\EditOrderRequest;
use App\Http\Requests\GetOrderRequest;
use App\Http\Requests\GetUserOrdersRequest;
use App\Http\Requests\NewOrderNotLoggedRequest;
use App\Http\Requests\NewOrderRequest;
use App\Models\Address;
use App\Models\Order;
use App\Models\Orders_product;
use App\Models\Type_of_delivery;
use Illuminate\Support\Facades\DB;
use Nette\Schema\ValidationException;


class OrderController extends Controller
{
    public function newOrder(NewOrderRequest $request)
    {
        $data = $request->validated();
        DB::beginTransaction();
        try {
            $delivery_type_id = Type_of_delivery::firstWhere('name', $data['delivery']);
            $order = new Order();
            $order->type_of_delivery_id = $delivery_type_id->id;
            $order->address_id = $data['address_id'];
            $order->pay_type = $data['pay_type'];
            $order->invoice_number = fake()->numberBetween();
            $order->user_id = $data['user_id'];
            $order->save();
            $order_id = $order->id;
            foreach ($data['products'] as $product) {
                $order_product = new Orders_product();
                $order_product->order_id = $order_id;
                $order_product->product_id = $product['id'];
                $order_product->how_many = $product['numberOfItems'];
                $order_product->save();
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw \Illuminate\Validation\ValidationException::withMessages(['data' => $e]);
        }

        return true;
    }
    public function newOrderNotLogged(NewOrderNotLoggedRequest $request){
        $data = $request->validated();
        DB::beginTransaction();
        try {
            $address = new Address;
            $address->name = $data['name'];
            $address->surname = $data['surname'];
            $address->address = $data['address'];
            $address->city = $data['city'];
            $address->zipcode = $data['zipcode'];
            $address->number = $data['number'];
            $address->save();
            $address_id = $address->id;

            $delivery_type_id = Type_of_delivery::firstWhere('name', $data['delivery']);
            $order = new Order();
            $order->type_of_delivery_id = $delivery_type_id->id;
            $order->address_id = $address_id;
            $order->pay_type = $data['pay_type'];
            $order->invoice_number = fake()->numberBetween();
            $order->save();
            $order_id = $order->id;
            foreach ($data['products'] as $product) {
                $order_product = new Orders_product();
                $order_product->order_id = $order_id;
                $order_product->product_id = $product['id'];
                $order_product->how_many = $product['numberOfItems'];
                $order_product->save();
            }

           DB::commit();
        }catch (\Exception $e){
            DB::rollBack();
            throw \Illuminate\Validation\ValidationException::withMessages(['data' => $e]);
        }
    }
    public function getUserOrders(GetUserOrdersRequest $request)
    {
        $data = $request->validated();
        return Order::with(['products', 'typeOfDelivery', 'user', 'address'])
            ->where('user_id', '=', $data['user_id'])
            ->get();
    }

    public function getOrder(GetOrderRequest $request)
    {
        $data = $request->validated();
        return Order::with(['products', 'typeOfDelivery', 'user', 'address'])->find($data['order_id']);
    }

    public function getAllOrders()
    {
        return Order::with(['products', 'typeOfDelivery', 'user', 'address'])->get();
    }

    public function editOrder(EditOrderRequest $request)
    {

    }

    public function deleteOrder(DeleteOrderRequest $request)
    {

    }
}
