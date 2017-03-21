<?php

namespace App\Http\Controllers\Api;

use App\Consultant;
use App\ConsultantRegistration;
use App\Http\Acme\Transformers\consultantRegistrationTransformer;
use App\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as ResponseHttpFoundation;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ConsultantRegistrationController extends ApiController
{
    // HTTP Headers params
    protected $headers = [
        'Access-Control-Allow-Origin'=> '*' ,
        'Access-Control-Allow-Methods'=> 'POST, GET, OPTIONS, PUT, DELETE',
        'Access-Control-Allow-Headers'=> 'X-Requested-With, Content-Type, X-Auth-Token, Origin, Authorization'
    ];

    protected $consultantRegistrationTransformer ;

    public function __construct(consultantRegistrationTransformer  $consultantRegistrationTransformer)
    {
        $this->middleware('jwt.auth'  , ['except' => ['store'  ]]);
        $this->consultantRegistrationTransformer = $consultantRegistrationTransformer;
    }

    /**
     * Get all ConsultantRegistration with dynamic limited pagination and dynamic sorting with date
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {

        // set limit in request or default will be 12
        $limit = $request->limit?(int)$request->limit:12 ;

        // set date order in request or default will be ascending
        $date_order = $request->date_order?$request->date_order:"asc" ;

        // inti query from database
        $consultants = ConsultantRegistration::query();

        // order data with date and return it with pagination
        $consultants = $consultants
            ->orderBy('created_at', $date_order)
            ->paginate($limit) ;

        // if return data equal 0 then return no data respond
        if($consultants->count() == 0){
            return $this->respondNotFound('No data found');
        }

        // commence process successfully with pagination params and Consultant Registration transformer params
        return $this->respondWithPagination($consultants,
            [
                'consultants' =>  $this->consultantRegistrationTransformer->transformCollection($consultants->all())
            ]
        );

    }

    /**
     * To create new consultant
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {


        // Begin Validations
        $validator =   $this->consultants_validation($request ,   "create");

        if ($validator->fails()) {

            // return validation errors response
            return $this->respondValidationError("result",
                $validator->errors(0) , ResponseHttpFoundation::HTTP_BAD_REQUEST);
        }
        // End Validations





        // Create consultant
        $consultant_registration = ConsultantRegistration::create([
            'first_name' => $request->first_name ,
            'last_name' => $request->last_name ,
            'gender' => $request->gender ,
            'email' => $request->email ,
            'idCountry_nationality' => $request->idCountry_nationality ,
            'idCountry_residential' => $request->idCountry_residential ,
            'about' => $request->about ,
            'mobile_number' => $request->mobile_number ,
        ]);
        if($consultant_registration){
            // Process success
            return $this->respondCreated('result' ,'Consultant Registered Successfully'  );
        }else{
            // Process Fail
            return $this->respondError('result' ,'Sorry . Consultant Registration process failed  ');
        }



    }


    /**
     * To update specific consultant
     * @param $consultant
     * @param Request $request
     * @return mixed
     */
    public function update($consultant , Request $request){

        // Begin Validations
        $this->consultants_validation($request , "update");
        // End Validations

        // find with specific consultant id
        $consultant = ConsultantRegistration::find($consultant);

        // if consultant row found
        if($consultant)
        {
            // commence update process
            $consultant_update =  $consultant->update($request->all());

            // if process success
            if( $consultant_update){
                // Success
                return $this->respondUpdated('Consultant registration info Updated Successfully'  );
            }else{
                // Failed
                return $this->respondUpdateFailed('Sorry .process failed'  );
            }

        }else{
            // no data found
            return $this->respondNotFound('Sorry . no data found');
        }
    }
    /**
     * Get one consultant row if exist
     * @param $consultant
     * @return mixed
     */
    public function show($consultant){

        // find with specific consultant id
        $consultant = ConsultantRegistration::find($consultant);

        // detect if not found
        if(! $consultant)
        {
            // no data found
            return $this->respondNotFound('Sorry . no data found');
        }

        // Success
        return $this->respond([
            'consultant' => $this->consultantRegistrationTransformer->transform($consultant)
        ]  );

    }


    /**
     * Insert fake data for test process
     * @param Request $request
     */
    public function insert_fake_data(Request $request){

        // limit param for rows limitation
        $limit = $request->limit?(int)$request->limit:3 ;

        // initiate the process
        factory(ConsultantRegistration::class, $limit)->create();

    }

    /**
     * Consultants inputs validations with messages
     * @param Request $request
     * @param string $method
     */
    protected function consultants_validation(Request $request , $method  )
    {
        if($method == "update"){
                // validations for update process
            $validator = Validator::make(  $request->all() ,[
                    'first_name' => 'required|between:2,45',
                    'last_name' => 'required|between:2,45',
                    'gender' => 'required|min:1|max:1',
                    'email' => 'required|email|max:45',
                    'idCountry_nationality' => 'required|int',
                    'idCountry_residential' => 'required|int',
                    'about' => 'required|min:2|max:3000',
                    'mobile_number' => 'required|min:2|max:15',
//                    'comments_by_admin' => 'required|min:2|max:1000',
                ],
                    [
                        'first_name.required' => 'First name Required',
                        'first_name.min' => 'First name must be at least 2 char',
                        'first_name.max' => 'First name maximum 45 char',
                        'last_name.required' => 'Last name Required',
                        'last_name.min' => 'Last name must be at least 2 char',
                        'last_name.max' => 'Last name maximum 45 char',
                        'gender.required' => 'Gender Required',
                        'gender.min' => 'Gender must be at least 1 char',
                        'gender.max' => 'Gender maximum 1 char',
                        'email.required' => 'Email Required',
                        'email.email' => 'Email inserted not correct',
                        'email.max' => 'Email maximum 150 char',
                        'idCountry_nationality.required' => 'Nationality Required',
                        'idCountry_nationality.int' => 'Nationality not accepted ',
                        'idCountry_residential.required' => 'Country residential Required',
                        'idCountry_residential.int' => 'Country residential not accepted ',
                        'about.required' => 'About Required',
                        'about.min' => 'About must be at least 2 char',
                        'about.max' => 'About maximum 3000 char',

                        'mobile_number.required' => 'Phone number Required',
                        'mobile_number.min' => 'Phone number must be at least 2 char',
                        'mobile_number.max' => 'Phone number maximum 3000 char',

                    ]
                );

            }else{
                // validations for insert process
            $validator = Validator::make(  $request->all() ,[
                    'first_name' => 'required|between:2,45',
                    'last_name' => 'required|between:2,45',
                    'gender' => 'required|min:1|max:1',
                    'email' => 'required|email|max:45|unique:consultant_registrations',
                    'idCountry_nationality' => 'required|int',
                    'idCountry_residential' => 'required|int',
                    'about' => 'required|min:2|max:3000',
                    'mobile_number' => 'required|min:2|max:15',
//                    'comments_by_admin' => 'required|min:2|max:1000',
                ],
                    [
                        'first_name.required' => 'First name Required',
                        'first_name.min' => 'First name must be at least 2 char',
                        'first_name.max' => 'First name maximum 45 char',
                        'last_name.required' => 'Last name Required',
                        'last_name.min' => 'Last name must be at least 2 char',
                        'last_name.max' => 'Last name maximum 45 char',
                        'gender.required' => 'Gender Required',
                        'gender.min' => 'Gender must be at least 1 char',
                        'gender.max' => 'Gender maximum 1 char',
                        'email.required' => 'Email Required',
                        'email.email' => 'Email inserted not correct',
                        'email.max' => 'Email maximum 150 char',
                        'email.unique' => 'Email must be unique',
                        'idCountry_nationality.required' => 'Nationality Required',
                        'idCountry_nationality.int' => 'Nationality not accepted ',
                        'idCountry_residential.required' => 'Country residential Required',
                        'idCountry_residential.int' => 'Country residential not accepted ',
                        'about.required' => 'About Required',
                        'about.min' => 'About must be at least 2 char',
                        'about.max' => 'About maximum 3000 char',

                        'mobile_number.required' => 'Phone number Required',
                        'mobile_number.min' => 'Phone number must be at least 2 char',
                        'mobile_number.max' => 'Phone number maximum 3000 char',
                    ]
                );

            return $validator ;
        }


    }

}
