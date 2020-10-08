<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Usuario;

use App\Models\TokenUsuario;

use Illuminate\Database\Eloquent\Model;

use DB;

class UsuarioController extends Controller
{
    public function login(Request $request)
    {
   //	return $request->all();	//echo hash('md5', '1234')	;

	    $nombre_usuario=$request->usuario;
	    $clave=hash('md5', $request->clave);
	    $usuario = Usuario::where('usuario', $nombre_usuario)
	    ->where('clave',$clave)
	    ->first();

   	
	    if (!empty($usuario)) {
			$token = UsuarioController::generar_token_seguro(200);
			$session= new TokenUsuario;
			$session->user_id=$usuario->id;
			$session->token=$token;
			$session->save();

			return response()->json(['res' => true, 'message' => "Bienvenido",'token'=>$session->token,'session_id'=>$session->id],200);
	    }else{
	    	return response()->json(['res' => false, 'message' => "Usuario y/o contraseña incorrectos"],200);
	    }
    }


	public function generar_token_seguro($longitud)
	{ 
	    if ($longitud < 4) {
	        $longitud = 4;
	    }
	 
	    return bin2hex(random_bytes(($longitud - ($longitud % 2)) / 2));
	}


	public function logout(Request $request)
	{
		//return $request->bearerToken();
		$usuario = TokenUsuario::where('token', $request->bearerToken())
		->delete();
	    if ($usuario) {
	    	return response()->json(['res' => true, 'message' => "Adios"],200);
	    }else{
	    	return response()->json(['res' => false, 'message' => "Error al cerrar sesion"],200);
	    }
		    
	}

	public function register(Request $request)
    {

		DB::beginTransaction();

		try {
		    $nombre_usuario=$request->usuario;
		    $clave=hash('md5', $request->clave);
			$usuario= new Usuario;
			$usuario->usuario=$nombre_usuario;
			$usuario->clave=$clave;
			$usuario->save();
			$token = UsuarioController::generar_token_seguro(200);
			$session= new TokenUsuario;
			$session->user_id=$usuario->id;
			$session->token=$token;
			$session->save();
			DB::commit();
			    // all good
			return response()->json(['res' => true, 'message' => "Bienvenido",'token'=>$session->token,'session_id'=>$session->id],200);
		} catch (\Exception $e) {
		    DB::rollback();
		    return response()->json(['res' => false, 'message' => "Fallo el registro",'detail'=>$e],200);
		}
   	
    }

}
