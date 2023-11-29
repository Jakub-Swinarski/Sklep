<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteAddressRequest;
use App\Http\Requests\EditAddressRequest;
use App\Http\Requests\GetUserAddressRequest;
use App\Http\Requests\NewAddressRequest;
use App\Models\Address;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;


class AddressController extends Controller
{
    public function addAddress(NewAddressRequest $request)
    {
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
            $address->user_id = $data['user_id'];
            $address->save();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            ValidationException::withMessages(['data' => $e]);
        }

    }

    public function editAddress(EditAddressRequest $request)
    {
        $data = $request->validated();
        $address = Address::where('id', $data['address_id'])->first();
        DB::beginTransaction();
        try {
            if (isset($data['name']) and $address->name != $data['name']) {
                Address::where('id', $data['address_id'])
                    ->update([
                        'name' => $data['name']
                    ]);
            }
            if (isset($data['surname']) and $address->surname != $data['surname']) {
                Address::where('id', $data['address_id'])
                    ->update([
                        'surname' => $data['surname']
                    ]);
            }
            if (isset($data['address']) and $address->address != $data['address']) {
                Address::where('id', $data['address_id'])
                    ->update([
                        'address' => $data['address']
                    ]);
            }
            if (isset($data['city']) and $address->city != $data['city']) {
                Address::where('id', $data['address_id'])
                    ->update([
                        'city' => $data['city']
                    ]);
            }
            if (isset($data['zipcode']) and $address->zipcode != $data['zipcode']) {
                Address::where('id', $data['address_id'])
                    ->update([
                        'zipcode' => $data['zipcode']
                    ]);
            }
            if (isset($data['number']) and $address->number != $data['number']) {
                Address::where('id', $data['address_id'])
                    ->update([
                        'number' => $data['number']
                    ]);
            }
            DB::commit();
        } catch (Exception $e){
            DB::rollBack();
            ValidationException::withMessages(['data' => $e]);
        }

        return true;

    }

    public function deleteAddress(DeleteAddressRequest $request)
    {
        $data = $request->validated();
        Address::where('id', $data['delivery_id'])->delete();
    }

    public function getUserAddress(GetUserAddressRequest $request)
    {
        $data = $request->validated();
        return Address::where('user_id', $data['user_id'])->get();
    }
}
