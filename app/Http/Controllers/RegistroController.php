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
                    return $this->sendResponse($Registro->id, $Registro->balance);
                } catch (Exception $e) {
                    return $this->sendError(404);
                } 
            break;
            
            case "retiro":
                try {
                    $Registro = Registro::find($request->origen);
                    $Registro->balance = $Registro->balance - $request->input('monto');
                    $Registro->save();
                    return $this->sendResponse($Registro->id, $Registro->balance);
                } catch (Exception $e) {
                    return $this->sendError(404);
                } 
            break; 

            case "transferencia":
                try {
                    $RegistroOrigen = Registro::find($request->origen);
                    $RegistroDestino = Registro::find($request->destino);
                    $RegistroOrigen->balance = $RegistroOrigen->balance - $request->input('monto');
                    $RegistroDestino->balance = $RegistroDestino->balance + $request->input('monto');
                    $RegistroOrigen->save();
                    $RegistroDestino->save();
                    return $this->sendResponse($RegistroOrigen->id, $RegistroOrigen->balance, $RegistroDestino->id, $RegistroDestino->balance);
                } catch (Exception $e) {
                    return $this->sendError(404);
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

    public function reset(){
        $Registro = Registro::Truncate();
        return $this->sendError(404);
    }

}
