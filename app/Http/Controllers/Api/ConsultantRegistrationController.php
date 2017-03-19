<?php

namespace App\Http\Controllers\Api;

use App\ConsultantRegistration;
use App\Http\Acme\Transformers\consultantRegistrationTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
        $this->middleware('jwt.auth'  );
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
        $this->consultants_validation($request ,   "create");
        // End Validations

        // Create consultant
        $consultant_registration = ConsultantRegistration::open($request->all())->save($request->all());
        if($consultant_registration){
            // Process success
            return $this->respondCreated('Consultant Registered Successfully'  );
        }else{
            // Process Fail
            return $this->respondError('Sorry . Consultant Registration process failed  ');
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
                $this->validate($request, [
                    'first_name' => 'required|between:2,45',
                    'last_name' => 'required|between:2,45',
                    'gender' => 'required|min:1|max:1',
                    'email' => 'required|email|max:45',
                    'idAdmin_notified' => 'required|int',
                    'idCountry_nationality' => 'required|int',
                    'idCountry_residential' => 'required|int',
                    'about' => 'required|min:2|max:3000',
                    'mobile_number' => 'required|min:2|max:15',
                    'comments_by_admin' => 'required|min:2|max:1000',
                ],
                    [
                        'first_name.min' => 'First name must be at least 2 char',
                        'first_name.max' => 'First name maximum 45 char'
                    ]
                );

            }else{
                // validations for insert process
                $this->validate($request, [
                    'first_name' => 'required|between:2,45',
                    'last_name' => 'required|between:2,45',
                    'gender' => 'required|min:1|max:1',
                    'email' => 'required|email|max:45|unique:consultant_registrations',
                    'idAdmin_notified' => 'required|int',
                    'idCountry_nationality' => 'required|int',
                    'idCountry_residential' => 'required|int',
                    'about' => 'required|min:2|max:3000',
                    'mobile_number' => 'required|min:2|max:15',
                    'comments_by_admin' => 'required|min:2|max:1000',
                ],
                    [
                        'first_name.min' => 'First name must be at least 2 char',
                        'first_name.max' => 'First name maximum 45 char'
                    ]
                );


        }


    }

}
