<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response as ResponseHttpFoundation;

class AuthenticateController extends ApiController
{

    protected  $headers = [
        'Access-Control-Allow-Origin'=> '*' ,
        'Access-Control-Allow-Methods'=> 'POST, GET, OPTIONS, PUT, DELETE',
        'Access-Control-Allow-Headers'=> 'X-Requested-With, Content-Type, X-Auth-Token, Origin, Authorization' ,
    ] ;

    /**     * The authenticated user.
     * @var \App\User|null
     */
    protected $user;

    /**
     * Is the user signed in?
     * @var \App\User|null
     */
    protected $signedIn;


    public function __construct()
    {


        // jwt is : JSON Web Token Authentication
        $this->middleware('jwt.auth', ['except' => ['authenticate' , 'signup'  ]]);

        // get authentic user
        $this->user = $this->signedIn = Auth::user();

    }


    /**
     * Login method  for authenticate user
     * @param Request $request
     * @return mixed
     */
    public function authenticate(Request $request)
    {
        try {
            // Try to login with credentials info
            if (! $token = JWTAuth::attempt($this->getVerifiedCredentials($request))) {
                // Error with credentials info
                return response()->json(['error' => 'invalid_credentials'], 401, $this->headers);
            }
        } catch (JWTException $e) {
            // something went wrong
            return response()->json(['error' => 'could_not_create_token'], 500, $this->headers);
        }


        // return success message , status code and token
        return $this->loggedInWithToken('You have been successfully logged in' , $token ) ;
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

    /**
     * Get token for Authenticated User
     * @return mixed
     */
    public function getAuthenticatedUser()
    {
        try {

        if (! $this->user = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['user_not_found'], 404, $this->headers);
        }

        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode(), $this->headers);

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode(), $this->headers);

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode(), $this->headers);

        }

        // if token is valid then get user info
         return response()->json(  JWTAuth::parseToken()->authenticate(), 200 , $this->headers);

    }


    /**
     * Api Registration new user
     * @param Request $request
     * @return mixed
     */
    public function signup(Request $request)
    {

        // Begin Validations
        $validator =   $this->user_validation($request ,   "create");
        if ($validator->fails()) {
            // return validation errors response
            return $this->respondError("validation error",$validator->errors() , ResponseHttpFoundation::HTTP_BAD_REQUEST);
        }
        // End Validations

        // Insert user
        try {
            $user = User::create([
                'username' => $request['username'],
                'email' => $request['email'],
                'password' => bcrypt($request['password']),
            ]);
        } catch (Exception $e) {
            // Error in process
            return $this->respondError('Sorry . User Registration process failed  ');
        }

        // Success and get token
        $token = JWTAuth::fromUser($user);
        // return success message , status code and token
        return $this->respondCreatedWithToken('Consultant Registered Successfully'   ,$token) ;

    }


    /**
     * User inputs validations with messages
     * @param Request $request
     * @param string $method
     */
    protected function user_validation(Request $request , $method  )
    {
        if($method == "create"){
            $validator = Validator::make(  $request->all() ,[
                'username' => 'required|min:2|max:150',
                'email' => 'required|email|max:150|unique:users',
                'password' => 'required|min:6|confirmed',
            ],
                [
                    'username.required' => 'First name Required',
                    'username.min' => 'First name must be at least 2 char',
                    'username.max' => 'First name maximum 150 char',
                    'email.required' => 'Email Required',
                    'email.email' => 'Email inserted not correct',
                    'email.max' => 'Email maximum 150 char',
                    'email.unique' => 'Email must be unique',
                    'password.required' => 'Password Required',
                    'password.min' => 'Password name must be at least 6 char or numbers',
                    'password.max' => 'Password maximum 150 char',
                    'password.confirmed' => 'Password not confirmed correctly',
                ]
            );
        }

        return $validator ;

    }

}
