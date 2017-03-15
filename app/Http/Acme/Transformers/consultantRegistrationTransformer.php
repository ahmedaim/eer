<?php


namespace App\Http\Acme\Transformers;


class consultantRegistrationTransformer extends Transformer{


    public function transform($consultant)
    {

        return [
            'idConsultantRegistration' => $consultant['idConsultantRegistration'] ,
            'first_name' => $consultant['first_name'] ,
            'last_name' => $consultant['last_name'] ,
            'gender' => $consultant['gender'] ,
            'email' => $consultant['email'] ,
            'idAdmin_notified' => $consultant['idAdmin_notified'] ,
            'idCountry_nationality' => $consultant['idCountry_nationality'] ,
            'idCountry_residential' => $consultant['idCountry_residential'] ,
            'about' => $consultant['about'] ,
            'mobile_number' => $consultant['mobile_number'] ,
            'comments_by_admin' => $consultant['comments_by_admin'] ,
            'created_at' => $consultant['created_at']->toDateTimeString() ,
            'updated_at' => $consultant['updated_at']->toDateTimeString() ,


        ];

    }


}