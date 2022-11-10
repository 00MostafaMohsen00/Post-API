<?php
namespace App\Http\Controllers\API;

trait apiResponseTrait
{
    public function apiResponse($data=null,$message=null,$status=null){

        $response=[
            'data'=>$data,
            'message'=>$message,
            'status'=>$status
        ];

        return response($response);
    }
}
