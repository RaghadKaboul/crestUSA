<?php
namespace App\Traits;
use http\Env\Response;

trait HttpResponses{
    protected function succes($data,$message=null,$code=200)
    {
        return response()->json([
            'status'=>'request was succesful .',
            'message'=>$message,
            'data'=>$data,
        ],$code);
    }
    protected function error($data,$message=null,$code)
    {
        return response()->json([
            'status'=>'Error has occurred..',
            'message'=>$message,
            'data'=>$data,
        ],$code);
    }
}
