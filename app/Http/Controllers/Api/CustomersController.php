<?php

namespace App\Http\Controllers\Api;

use App\Customer;
use App\Http\Acme\Transformers\customerTransformer;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response as ResponseHttpFoundation;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class CustomersController extends ApiController
{
    // HTTP Headers params
    protected $headers = [
        'Access-Control-Allow-Origin'=> '*' ,
        'Access-Control-Allow-Methods'=> 'POST, GET, OPTIONS, PUT, DELETE',
        'Access-Control-Allow-Headers'=> 'X-Requested-With, Content-Type, X-Auth-Token, Origin, Authorization'
    ];

    protected $customerTransformer ;

    public function __construct(customerTransformer  $customerTransformer)
    {
        $this->middleware('jwt.auth'  , ['except' => ['store' , 'customer_login']]);
        $this->customerTransformer = $customerTransformer;
    }

    /**
     * Get all Customers with dynamic limited pagination and dynamic sorting with date
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
        $customers = Customer::query();

        // order data with date and return it with pagination
        $customers = $customers
            ->orderBy('created_at', $date_order)
            ->paginate($limit) ;

        // if return data equal 0 then return no data respond
        if($customers->count() == 0){
            return $this->respondNotFound('No data found')->header('status_code', ResponseHttpFoundation::HTTP_NOT_FOUND);;
        }

        // commence process successfully with pagination params and customer transformer params
        return $this->respondWithPagination($customers,
            [
                'customers' =>  $this->customerTransformer->transformCollection($customers->all())
            ]
        );

    }


    /**
     * To create new Customer
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {

        // Begin Validations
        $validator =   $this->customers_validation($request ,   "create");
        if ($validator->fails()) {
            // return validation errors response
            return $this->respondValidationError("result",
                $validator->errors(0) , ResponseHttpFoundation::HTTP_BAD_REQUEST);
        }
        // End Validations

        // Create Customer
        // first create new user in users table
        try {
            $new_user = User::create([
                'email' => $request->email ,
                'password' => bcrypt($request->password)
            ]  );
        } catch (JWTException $e) {
            // something went wrong
            // Process Fail
            return $this->respondError('result' ,'Sorry . User Registration process failed  ');
        }




        if($new_user){
            // new user created successfully . and next , creating new customer and linked with this user
            try {
                $customer = $new_user->customers()->save(Customer::open([
                    'first_name' => $request->first_name ,
                    'last_name' => $request->last_name ,
                    'email' => $request->email ,
                    'gender' => $request->gender ,
                ]));
            }catch (JWTException $e) {
                // something went wrong
                // Process Fail
                return $this->respondError('result' ,'Sorry . Customer Registration process failed  ');
            }

            if($customer){
                // Process success
                // Success and get token
                $token = JWTAuth::fromUser($new_user);
                return $this->respondCreated( 'result' , 'Customer Registered Successfully'   , $token  );
            }

        }




    }



    /**
     * Customer inputs validations with messages
     * @param Request $request
     * @param string $method
     */
    protected function customers_validation(Request $request , $method  )
    {
        if($method == "create"){
            $validator = Validator::make(  $request->all() ,[
                'first_name' => 'required|min:2|max:45',
                'last_name' => 'required|min:2|max:45',
                'email' => 'required|email|max:150|unique:users',
                'gender'=> 'required|min:1|max:1',
                'password' => 'required|min:6',
            ],
                [
                    'first_name.required' => 'First name Required',
                    'first_name.min' => 'First name must be at least 2 char',
                    'first_name.max' => 'First name maximum 45 char',
                    'last_name.required' => 'Last name Required',
                    'last_name.min' => 'Last name must be at least 2 char',
                    'last_name.max' => 'Last name maximum 45 char',
                    'email.required' => 'Email Required',
                    'email.email' => 'Email inserted not correct',
                    'email.max' => 'Email maximum 150 char',
                    'email.unique' => 'Email must be unique',
                    'gender.required' => 'Gender Required',
                    'gender.min' => 'Gender must be at least 1 char ',
                    'gender.max' => 'Gender maximum 1 char',
                    'password.required' => 'Password Required',
                    'password.min' => 'Password name must be at least 6 char or numbers',
                    'password.max' => 'Password maximum 150 char',
                ]
            );
        }

        return $validator ;

    }


    public function customer_login(Request $request){

        $validator = Validator::make(  $request->all() ,[
            'email' => 'required|email|max:150',
            'password' => 'required|min:6|max:150'
        ],
            [
                'email.required' => 'Email Required',
                'email.email' => 'Email inserted not correct',
                'email.max' => 'Email maximum 150 char',
                'password.required' => 'Password Required',
                'password.min' => 'Password name must be at least 6 char or numbers',
                'password.max' => 'Password maximum 150 char',
            ]
        );

        if ($validator->fails()) {
            // return validation errors response
            return $this->respondValidationError("result",
                $validator->errors(0) , ResponseHttpFoundation::HTTP_BAD_REQUEST);
        }

        try {
            // Try to login with credentials info
            if (! $token = JWTAuth::attempt($this->getVerifiedCredentials($request))) {
                // Error with credentials info
                return $this->respondError('result' ,'Invalid credentials ');

            }
        } catch (JWTException $e) {
            // something went wrong
            return $this->respondError('result' ,'Login process failed ');
        }

        // return success message , status code and token
        return $this->loggedInWithToken('result' ,'You have been successfully logged in' , $token ) ;
    }

    /**
     * Check if this user verified
     * @param Request $request
     * @return array
     */
    protected function getVerifiedCredentials(Request $request)
    {
        return [
            'email' => $request->input('email'),
            'password' => $request->input('password')
//            'verified' => true
        ] ;
    }


    public function customer_change_password(Request $request){

        $validator = Validator::make(  $request->all() ,[
            'current_password' => 'required|min:6|max:150',
            'new_password' => 'required|min:6|max:150'
        ],
            [
                'current_password.required' => 'Current password required',
                'current_password.min' => 'Current password must be at least 6 char or numbers',
                'current_password.max' => 'Current password maximum 150 char or numbers',
                'new_password.required' => 'New password required',
                'new_password.min' => 'New password name must be at least 6 char or numbers',
                'new_password.max' => 'New password maximum 150 char or numbers',
            ]
        );

        if ($validator->fails()) {
            // return validation errors response
            return $this->respondValidationError("result",
                $validator->errors(0) , ResponseHttpFoundation::HTTP_BAD_REQUEST);
        }

            $user = JWTAuth::parseToken()->authenticate();


        if($user){
            if (Hash::check($request['current_password'], $user->password)) {
                $user->update([
                    'password' => bcrypt($request['new_password']),
                ]);
                $token = JWTAuth::fromUser($user);
                return $this->respondCreated( 'result' , 'Your password has been changed successfully'   , $token  );
            }else{
                return $this->respondError('result' ,'Sorry . Changing password process failed  ');
            }
        }


    }



}
