<?php
include("laComanda/clases/Puesto.php");
include("laComanda/clases/IApiPuesto.php");
class PuestoAPI extends Puesto implements IApiPuesto{
		  
	 function __construct()
	 {
	 }
      
     public function insertarPuesto($request, $response){
        $clase = new stdclass();
        $perfil = $_REQUEST['perfil'];        
        if($perfil != "socio"){
            $clase->respuesta =  "no tiene permisos para asignar un empleado al pedido" ;
        } else{
                $obj=$request->getParsedBody();
                $existe = Puesto::traerIdPuesto($obj['nombre']);
                if($existe == NULL){
                    $p = new Puesto ($obj['nombre']);
                    if(Puesto::insertar($p)){
                        $clase->respuesta = "Se ingreso el puesto correctamente" ;
                    }
                    else {
                        $clase->respuesta = "No se pudo ingresar el puesto, intentelo de nuevo" ;
                    }
                }else {
                    $clase->respuesta = "El puesto ya existe , ingrese otro por favor" ;
                }
        } 
        $newResponse=$response->withJson($clase, 401);
        return $newResponse;
     }
	  
     public function bajaPuesto($request, $response){
        $obj=$request->getParsedBody();
        $existe = Puesto::IdPuesto($obj['id']);
        $clase = new stdclass();
            if($existe[0][0] != null){            
            if(Puesto::eliminar($obj['id'])){
                $clase->respuesta = "Se Elimino el puesto correctamente" ;
            }
            else {
                $clase->respuesta = "No se pudo Eliminar el puesto, intentelo de nuevo" ;
            }
        }else {
            $clase->respuesta = "El puesto no existe , ingrese otro por favor" ;
        }
        $newResponse=$response->withJson($clase, 401);
        return $newResponse;
     }
    
	 public function modifPuesto($request, $response){
        $obj=$request->getParsedBody();
        $existe = Puesto::IdPuesto($obj['id']);
        $clase = new stdclass();
            if($existe != null){            
            if(Puesto::modificar($obj['id'],$obj['nombre'])){
                $clase->respuesta = "Se modifico el puesto correctamente" ;
            }
            else {
                $clase->respuesta = "No se pudo modificar el puesto, intentelo de nuevo" ;
            }
        }else {
            $clase->respuesta = "El puesto no existe , ingrese otro por favor" ;
        }
        $newResponse=$response->withJson($clase, 401);
        return $newResponse; 
     } 
}



?>