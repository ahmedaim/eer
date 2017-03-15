<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthenticateController extends Controller
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

        $this->user = $this->signedIn = Auth::user();

    }


    /**
     * Login method  for authenticate user
     * @param Request $request
     * @return mixed
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password'  );
        try {
            if (! $token = JWTAuth::attempt($this->getVerifiedCredentials($request))) {
                return response()->json(['error' => 'invalid_credentials'], 401, $this->headers);
            }
        } catch (JWTException $e) {
            // something went wrong
            return response()->json(['error' => 'could_not_create_token'], 500, $this->headers);
        }

        // if no errors are encountered we can return a JWT
        return response()->json(compact('token'), 200 , $this->headers);
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

         return response()->json(  JWTAuth::parseToken()->authenticate(), 200 , $this->headers);
        // the token is valid and we have found the user via the sub claim
        return response()->json(compact('user'), 200 , $this->headers);
    }


    public function signup(Request $request)
    {

        try {
            $user = User::create([
                'username' => $request['username'],
                'email' => $request['email'],
                'password' => bcrypt($request['password']),
            ]);




        } catch (Exception $e) {
            return response()->json(['error' => 'this user exist  '], 500   );

        }

        $token = JWTAuth::fromUser($user);

        return response()->json(compact('token'));
    }



}
