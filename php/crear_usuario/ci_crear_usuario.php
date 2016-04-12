<?php
class ci_crear_usuario extends toba_ci
{
        //---- Pant Edicion -----------------------------------------------------------------
        
        //---- Cuadro -----------------------------------------------------------------------
        
        function conf__cuadro (toba_ei_cuadro $cuadro){
            //$cuadro->set_datos($datos);
        }
        
        function evt__cuadro__seleccionar ($datos){
            
        }
        
	//---- Formulario -------------------------------------------------------------------

	function conf__formulario(toba_ei_formulario $form)
	{
            
	}

	function evt__formulario__alta($datos)
	{
            $usuario=$this->dep('datos')->tabla('persona')->get_persona($datos['nro_doc'], $datos['tipo_doc']);
            if(!isset($usuario)){
                $mensaje=" Ya existe un usuario registrado en el sistema con el número de documento {$datos['nro_doc']} ";
                toba::notificacion()->agregar(utf8_decode($mensaje), 'info');
            }
            else{
                //creamos la tupla para la tabla persona
                $persona=array(
                    'nro_doc' => $datos['nro_doc'],
                    'tipo_doc' => $datos['tipo_doc'],
                    'nombre' => $datos['nombre'],
                    'apllido' => $datos['apellido'],
                );
                $this->dep('datos')->tabla('persona')->nueva_fila($persona);
                $this->dep('datos')->tabla('persona')->sincronizar();
                $this->dep('datos')->tabla('persona')->resetear();
                
                //creamos la tupla para la tabla administrador
                $administrador=array(
                    'nro_doc' => $datos['nro_doc'],
                    'tipo_doc' => $datos['tipo_doc'],
                    'nombre_usuario' => $datos['nombre_usuario'],
                    'id_sede' => $datos['id_sede']
                );
                $this->dep('datos')->tabla('administrador')->nueva_fila($administrador);
                $this->dep('datos')->tabla('administrador')->sincronizar();
                $this->dep('datos')->tabla('administrador')->resetear();
                
                //creamos el usuario para el sistema    
                //Si no existe usuario 
                toba::instancia()->agregar_usuario($usuario, $nombre, $clave);
                toba::instancia()->vincular_usuario($proyecto, $usuario, $perfil_acceso);
            }
	}
        
	function evt__formulario__cancelar()
	{
		$this->resetear();
	}

	function resetear()
	{
		$this->dep('datos')->resetear();
	}
        
        //--------------------------------------------------------------------------------------
        //---- Aqui gestionamos las llamadas ajax ----------------------------------------------
        //--------------------------------------------------------------------------------------
        
        function ajax__crear_nombre_usuario ($parametros, toba_ajax_respuesta $respuesta){
            $nombre=$parametros[0];
            $apellido=$parametros[1];
            
            $nombre_usuario=($nombre[0]) . $apellido;
            
            $estructura=array(
                'user' => strtolower($nombre_usuario)
            );
                        
            $respuesta->set($estructura);
        }       
        

}

?>