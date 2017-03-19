<?php

namespace App\Http\Controllers\Api;

use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\Response as ResponseHttpFoundation;

class ApiController extends Controller
{

    protected $statusCode = 200 ;

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
        return $this ;
    }

    protected function respondWithPagination(Paginator $item, $data  )
    {

        $data = array_merge($data, [
            'total' => $item->Total(),
            'per_page' => intval($item->PerPage()),
            'total_pages' => ceil($item->Total() / $item->PerPage()),
            'current_page' => $item->CurrentPage(),
            'last_page' => $item->LastPage(),
            'next_page_url' => $item->NextPageUrl(),
            'prev_page_url' => $item->previousPageUrl(),
            'from' => $item->firstItem(),
            'to' =>$item->lastItem(),
            'page_total' => $item->lastItem() -$item->firstItem(),
        ]);

        return $this->respond($data);
    }


    public function respondNotFound($message = 'Not Found!' , $status_code = ResponseHttpFoundation::HTTP_NOT_FOUND){

        return $this->setStatusCode($status_code)->respondWithError($message);

    }


    public function respond($data  , $status_code = ResponseHttpFoundation::HTTP_OK ,  $headers = []){
        return Response::json($data , $status_code , $headers);
    }

    /**
     * Return
     * @param $data
     * @param string $token
     * @param int $status_code
     * @return mixed
     */
//    public function respondWithToken($data  , $token = '', $status_code = ResponseHttpFoundation::HTTP_ACCEPTED  ){
//        return Response::json($data , $status_code ,   $token);
//    }


    /**
     * Return if respond with logged in successfully
     * @param $message
     * @param string $token
     * @param int $status_code
     * @return mixed
     */
    public function loggedInWithToken( $message  , $token = '', $status_code = ResponseHttpFoundation::HTTP_OK  ){

        return $this->respond([
            'message' => $message,
            'status_code' => $status_code ,
            'token' =>$token
        ], $status_code);
    }


    public function respondWithError($message){
        return $this->respond([
            'error' => [
                'message' => $message,
                'status_code' => $this->getStatusCode()
            ]
        ]   );
    }

    protected function respondError($error_object = 'error' , $message = 'Error' , $status_code = ResponseHttpFoundation::HTTP_EXPECTATION_FAILED)
    {

        return $this->respond(
            [
                $error_object => [
                    'message' => $message,
                    'status_code' => $status_code ,
                    'token' => ''
                ],
            ] );

//        return $this->respond(
//        [
//            'message' => $message,
//            'status_code' => $status_code ,
//            'token' => ''
//        ], $status_code);
    }


    /**
     * Return if respond with create row successfully
     * @param string $object
     * @param string $message
     * @param int $status_code
     * @param string $token
     * @return mixed
     */
    protected function respondCreated($object = "created" , $message = 'Successfully created' ,
                                      $status_code = ResponseHttpFoundation::HTTP_CREATED , $token = '')
    {
        return $this->respond(
            [
                $object => [
                    'message' => $message,
                    'status_code' => $status_code ,
                    'token' => $token
                ],
            ] );

    }


    /**
     * Return if respond with create row successfully with token
     * @param string $message
     * @param int $status_code
     * @param string $token
     * @return mixed
     */
    protected function respondCreatedWithToken($message = 'Successfully created' , $token = "",
                                               $status_code = ResponseHttpFoundation::HTTP_CREATED )
    {
        return $this->respond([
            'message' => $message,
            'status_code' => $status_code,
            'token' => $token
        ], $status_code);
    }


    /**
     * Return if respond with update row successfully
     * @param string $message
     * @param int $status_code
     * @return mixed
     */
    protected function respondUpdated($message = 'Successfully Updated' , $status_code = ResponseHttpFoundation::HTTP_OK)
    {
        return $this->respond([
            'message' => $message,
            'status_code' => $status_code
        ], $status_code);
    }

    /**
     * Return if respond with update row failed
     * @param string $message
     * @param int $status_code
     * @return mixed
     */
    protected function respondUpdateFailed($message = 'Update failed' , $status_code = ResponseHttpFoundation::HTTP_NOT_MODIFIED)
    {
        return $this->respond([
            'message' => $message,
            'status_code' => $status_code
        ], $status_code);
    }



}
