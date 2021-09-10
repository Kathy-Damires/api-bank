<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registro;
use Exception;
use PhpParser\Node\Stmt\Break_;

class RegistroController extends ApiController
{

    public function evento(Request $request){
        switch ($request->tipo) {
            case "deposito":
                try {
                    $Registro = Registro::find($request->destino);
                    $Registro->balance = $Registro->balance + $request->input('monto');
                    $Registro->save();
                    return $this->sendResponse($Registro, "Se ha depositado correcamente");
                } catch (Exception $e) {
                    return $this->sendError("Error","La cuenta no existe",404);
                } 
            break;
            
            case "retiro":
                try {
                    $Registro = Registro::find($request->origen);
                    $Registro->balance = $Registro->balance - $request->input('monto');
                    $Registro->save();
                    return $this->sendResponse($Registro, "Retiro efecivo");
                } catch (Exception $e) {
                    return $this->sendError("Error", "La cuenta no existe",404);
                } 
            break; 

            case "transferencia":
                try {
                    $RegistroOrigen = Registro::find($request->origen);
                    $RegistroDestino = Registro::find($request->destino);
                    if ($RegistroOrigen->balance >= $request->input('monto')){
                    $RegistroOrigen->balance = $RegistroOrigen->balance - $request->input('monto');
                    $RegistroDestino->balance = $RegistroDestino->balance + $request->input('monto');
                    $RegistroOrigen->save();
                    $RegistroDestino->save();
                    }else{
                        return $this->sendError("Error", "El balance de la cuenta de origen no es suficiente", 404);
                    }
                    return $this->sendResponse($RegistroOrigen, $RegistroDestino, "Transferencia efectiva");
                } catch (Exception $e) {
                    return $this->sendError("Error", "La cuenta no existe", 404);
                } 
            break; 
        }
    }

    public function balance($id)
    {
        try{
            $Registro = Registro::find($id);
            return $this->sendResponse($Registro->id, $Registro->balance);
        }catch (Exception $e) {
            return $this->sendError("El numero de cuenta no existe", 404);
        }
    }

    public function nuevaCuenta(Request $request) {
        $id = $request->input('id');
        $mail = $request->input('mail');
        $Registro = Registro::find($id);
        if($Registro){
            return $this->sendError("El usuario ya existe");
        }else{
        $Registro = new Registro();
        $Registro->id = $id;
        $Registro->balance = 0;
        $Registro->Mail = $mail;
        $Registro->save();
        return $this->sendResponse($Registro, "Cuenta creada");
        }
    }

    public function reset(){
        Registro::Truncate();
        return $this->sendError(404);
    }

}
