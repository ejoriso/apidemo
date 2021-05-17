<?php
namespace App\Traits;

use JWTAuth;
use DB;
use Carbon\Carbon;

trait RefreshTokenTrait {

    /**
     * Refrescar token de usuario autenticado.
     * or.merino
     *
     * @param      <type>  $fecha  La fecha que se desea corroborar en formato Y-m-d 00:00:00
     */
    public function refreshToken(){
      $token = JWTAuth::getToken();
      $new_token = JWTAuth::refresh($token);
      return $new_token;
    }
    
}