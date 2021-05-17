<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\Traits\RefreshTokenTrait;

class CustomController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests,RefreshTokenTrait;

    function return200($data,$message=''){
    	return response()->json(array_merge(['success'=>true,'status_code'=>200,'message'=>$message,'data'=>$data]),200);
    }
}
