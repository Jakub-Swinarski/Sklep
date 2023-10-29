<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteAddressRequest;
use App\Http\Requests\EditAddressRequest;
use App\Http\Requests\GetUserAddressRequest;
use App\Http\Requests\NewAddressRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;


class AddressController extends Controller
{
    public function addAddress(NewAddressRequest $request){
        $data = $request->validated();
        DB::beginTransaction();
        try {
            $address_id = DB::table('address')
                ->insertGetId([
                    'name'=> $data['name'],
                    'surname' => $data['surname'],
                    'address' => $data['address'],
                    'city' => $data['city'],
                    'zipcode' => $data['zipcode'],
                    'number' => $data['number']
                ]);
            DB::table('address_user')
                ->insert([
                    'user_id' => $data['user_id'],
                    'address_id' => $address_id
                ]);
            DB::commit();
        }catch (Exception $e){
            DB::rollBack();
            ValidationException::withMessages(['data' => $e]);
        }

    }
    public function editAddress(EditAddressRequest $request){
        $data = $request->validated();
        try {
            if(isset($data['name'])){
                DB::table('address')
                    ->where('id', '=', $data['address_id'])
                    ->update([
                        'name' => $data['name']
                    ]);
            }
            if(isset($data['surname'])){
                DB::table('address')
                    ->where('id', '=', $data['address_id'])
                    ->update([
                        'name' => $data['surname']
                    ]);
            }
            if(isset($data['address'])){
                DB::table('address')
                    ->where('id', '=', $data['address_id'])
                    ->update([
                        'name' => $data['address']
                    ]);
            }
            if(isset($data['city'])){
                DB::table('address')
                    ->where('id', '=', $data['address_id'])
                    ->update([
                        'name' => $data['city']
                    ]);
            }
            if(isset($data['zipcode'])){
                DB::table('address')
                    ->where('id', '=', $data['address_id'])
                    ->update([
                        'name' => $data['zipcode']
                    ]);
            }
            if(isset($data['number'])){
                DB::table('address')
                    ->where('id', '=', $data['address_id'])
                    ->update([
                        'name' => $data['number']
                    ]);
            }
        }catch (Exception $e){
            ValidationException::withMessages(['data' => 'nie udało się']);
        }
    }
    public function deleteAddress(DeleteAddressRequest $request){
        $data = $request->validated();
        DB::table('address')
            ->where('id', '=', $data['address_id'])
            ->update([
                'is_deleted' => true
            ]);
    }
    public function getUserAddress(GetUserAddressRequest $request){
        $data = $request->validated();
        return DB::table('address_user', 'au')
            ->where('user_id', '=', $data['user_id'])
            ->leftJoin('address','au.address_id','=', 'address.id')
            ->get();
    }
}
