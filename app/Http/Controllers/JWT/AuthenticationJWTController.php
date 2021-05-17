<?php

namespace App\Http\Controllers\JWT;

use Auth;
use DB;
use JWTAuth;
use JWTFactory;
use Log;
use Validator;
use App\Http\Controllers\CustomController;
use App\Models\JWT\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

use Firebase\JWT\JWT;
use Firebase\JWT\SignatureInvalidException;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\BeforeValidException;

class AuthenticationJWTController extends CustomController{


    public function login(Request $request){

        //Validando que se reciba el JWT
        $validator = Validator::make($request->all(),[
            'email' => 'required|max:100',
            'password' =>'required|max:16',
        ]);

        if($validator->fails())
            return response()->json(['errors'=>'Las credenciales son obligatorias.','status'=>401],401); //401 UNAUTHORIZED

        //Encuentre el usuario
        $u = User;

        if(!$u)
            return response()->json(['status'=>401,'errors'=>'Acceso no autorizado!'],401);

        try{
            // Authenticando a partir del usuario encontrado
            if(! $token = JWTAuth::fromUser($u))
                return response()->json(['errors' => 'Credenciales incorrectas!','status'=>401], 401);
        } catch (JWTException $e) {
            Log::error('Error Exception', ['time' => Carbon::now(), 'code' => $e->getCode(), 'msg' => $e->getMessage()]);
            return response()->json(['errors' => 'No se pudo crear el token','status'=>500], 500);
        }
        return response()->json(['errors' => 'Usuario no encontrado!','status'=>401], 401);

        $data = array(
            'code' => 0, 
            'access_token' => /*$token*/,
            'token_type' => 'Bearer',
            "expires_in" => JWTAuth::factory()->getTTL() * 60
        );
            
        // data - token if exist - message
        return $this->return200($data,'Logged In');
    }


    public function refreshAuthTk(Request $request){
        $newToken = $this->refreshToken();
        return response()->json(['message'=>'Ok','status'=>200,'token'=>$newToken],200);
    }


    public function logout(){
        $token = JWTAuth::getToken();
        try{
            JWTAuth::invalidate($token);
            $data = array(
                'code' => 0, 
            );
            return $this->return200($data,'Se cerró la sesión correctamente!');
        }catch(JWTException $e){
            Log::error('Error Exception', ['time' => Carbon::now(), 'code' => $e->getCode(), 'msg' => $e->getMessage()]);
            return response()->json(['errors' => 'Hubo un error al cerrar sesión!','status_code'=>422], 422); //422 UNPROCESSABLE ENTITY
        }
    }

    public function getAuthenticatedUser(){
        try {
            if (! $u = JWTAuth::parseToken()->authenticate())
                return response()->json(['user_not_found'], 404);
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }

        $data = array(
            'usuario'   =>  array(
                                'id' => $u->id,
                                'nombre' =>$u->nombresUsuario,
                                'apellido' => $u->apellidosUsuario,
                                'iniciales' => $u->iniciales
                            )
        );
        // data - token if exist - message
        return $this->return200($data);
    }
}