<?php


namespace App\Http\Acme\Transformers;


class customerTransformer extends Transformer{


    public function transform($customer)
    {

        return [
            'idCustomer' => $customer['idCustomer'] ,
            'first_name' => $customer['first_name'] ,
            'last_name' => $customer['last_name'] ,
            'email' => $customer['email'] ,
            'username' => $customer['username'] ,
            'created_at' => $customer['created_at']->toDateTimeString() ,
            'updated_at' => $customer['updated_at']->toDateTimeString() ,

        ];

    }


}