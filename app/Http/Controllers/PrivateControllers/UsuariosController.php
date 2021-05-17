<?php

namespace App\Http\Controllers\PrivateControllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\JWT\User;
use JWTAuth;
use DB;
use Validator;


class UsuariosController extends Controller{
    
    public function getAll(Request $request){
        $usuarios = User::all();

        return response()->json(['status'=>200,'message'=>'Usuario creado correctamente','data'=>$usuarios],200);
    }

    public function create(Request $request){
        $rules = [
            'email' =>  'required|email',
            'password' =>  'required',
            'nombres'     =>  'required',
            'apellidos'     =>  'required',
        ];

        $v = Validator::make($request->all(),$rules);

        if ($v->fails()){
            $msg = "";
            foreach ($v->messages()->all() as $err) {
                $msg .= $err. " - ";
            }
            return response()->json(['status' => 400, 'message' => $msg],400);
        }

        try {
            if (! $authUser = JWTAuth::parseToken()->authenticate())
                return response()->json(['user_not_found'], 404);
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }

        try{
            $u = new User();
            $u->email = $request->email;
            $u->password = md5($request->password);
            $u->nombres = $request->nombres;
            $u->apellidos = $request->apellidos;
            $u->usuarioCreacion = $authUser->email;
            $u->save();
        }catch(QueryException $e){
            Log::error('Error Exception', ['time' => Carbon::now(), 'code' => $e->getCode(), 'msg' => $e->getMessage()]);
            return response()->json(['status' => 500,'errors' => 'Hubo un error al crear el usuario.'],500);
        }

        return response()->json(['status'=>200,'message'=>'Usuario creado correctamente'],200);
    }

    public function show(Request $request){
        $rules = [
            'idUsuario' =>  'required|numeric',
        ];

        $v = Validator::make($request->all(),$rules);

        if ($v->fails()){
            $msg = "";
            foreach ($v->messages()->all() as $err) {
                $msg .= $err. " - ";
            }
            return response()->json(['status' => 400, 'message' => $msg],400);
        }
        $idUsuario = (int)$request->idUsuario;
        try{
            $u = User::findOrFail($idUsuario);
        }catch(QueryException $e){
            Log::error('Error Exception', ['time' => Carbon::now(), 'code' => $e->getCode(), 'msg' => $e->getMessage()]);
            return response()->json(['status' => 500,'errors' => 'Hubo un error al buscar el usuario.'],500);
        }

        return response()->json(['status'=>200,'message'=>'Usuario encontrado','data'=>$u],200);
    }

    public function update(Request $request){
        $rules = [
            'idUsuario' =>  'required|numeric',
            'email' =>  'required|email',
            'password' =>  'required',
            'nombres'     =>  'required',
            'apellidos'     =>  'required',
        ];

        $v = Validator::make($request->all(),$rules);

        if ($v->fails()){
            $msg = "";
            foreach ($v->messages()->all() as $err) {
                $msg .= $err. " - ";
            }
            return response()->json(['status' => 400, 'message' => $msg],400);
        }

        try {
            if (! $authUser = JWTAuth::parseToken()->authenticate())
                return response()->json(['user_not_found'], 404);
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }

        $idUsuario = (int)$request->idUsuario;
        try{
            $u = User::findOrFail($idUsuario);
            $u->email = $request->email;
            $u->password = md5($request->password);
            $u->nombres = $request->nombres;
            $u->apellidos = $request->apellidos;
            $u->usuarioCreacion = $authUser->email;
            $u->save();
        }catch(QueryException $e){
            Log::error('Error Exception', ['time' => Carbon::now(), 'code' => $e->getCode(), 'msg' => $e->getMessage()]);
            return response()->json(['status' => 500,'errors' => 'Hubo un error al actualizar el usuario.'],500);
        }

        return response()->json(['status'=>200,'message'=>'Usuario actualizado correctamente'],200);
    }

    public function delete(Request $request){
        $rules = [
            'idUsuario' =>  'required|numeric',
        ];

        $v = Validator::make($request->all(),$rules);

        if ($v->fails()){
            $msg = "";
            foreach ($v->messages()->all() as $err) {
                $msg .= $err. " - ";
            }
            return response()->json(['status' => 400, 'message' => $msg],400);
        }
        $idUsuario = (int)$request->idUsuario;
        try{
            $u = User::findOrFail($idUsuario);
            $u->delete();
        }catch(QueryException $e){
            Log::error('Error Exception', ['time' => Carbon::now(), 'code' => $e->getCode(), 'msg' => $e->getMessage()]);
            return response()->json(['status' => 500,'errors' => 'Hubo un error al eliminar el usuario.'],500);
        }

        return response()->json(['status'=>200,'message'=>'Usuario eliminado'],200);
    }
}
