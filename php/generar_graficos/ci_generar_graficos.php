<?php
class ci_generar_graficos extends toba_ci
{
    
        protected $s__id_sede;
        
	//---- Cuadro -----------------------------------------------------------------------

	function conf__cuadro(toba_ei_cuadro $cuadro)
	{
            $this->pantalla()->tab('pant_grafico')->desactivar();
            //Si s__id_sede no es nula el cuadro se mantiene cargado en cada pedido de pagina
            if(isset($this->s__id_sede)){
                $sql="SELECT t_a.nombre, t_a.capacidad, t_t.descripcion as tipo, t_a.id_aula
                      FROM aula t_a 
                      JOIN tipo t_t ON (t_a.id_tipo=t_t.id_tipo)
                      WHERE t_a.id_sede={$this->s__id_sede}";
                $aulas=toba::db('gestion_aulas')->consultar($sql);
                $cuadro->set_titulo("Listado de Aulas");
                $cuadro->set_datos($aulas);
            }
            else{
                $cuadro->descolapsar();
            }
	}

	function evt__cuadro__seleccion($datos)
	{
            //$this->dep('datos')->cargar($datos);
            //print_r($datos);
            $this->dep('datos')->tabla('aula')->cargar(array('id_aula'=>$datos['id_aula']));
            $aula=$this->dep('datos')->tabla('aula')->get();
            $fp=$this->dep('datos')->tabla('aula')->get_blob('imagen', $aula['x_dbr_clave']);
            
            if(!isset($fp)){
                $this->dep('datos')->tabla('aula')->resetear();
                $mensaje=" El aula seleccionada no tiene una imagen disponible ";
                toba::notificacion()->agregar($mensaje, 'info');
            }
            else{
                //guardamos el id_aula en el arreglo $_SESSION
                toba::memoria()->set_dato_operacion(1, $datos['id_aula']);
                $this->set_pantalla('pant_grafico');
            }
	}

	//---- Formulario -------------------------------------------------------------------

	function conf__formulario(toba_ei_formulario $form)
	{
//		if ($this->dep('datos')->esta_cargada()) {
//			$form->set_datos($this->dep('datos')->tabla('aula')->get());
//		}
                
//            $nombre_usuario=toba::usuario()->get_id();    
//            $sql="SELECT t_a.nombre, t_a.capacidad
//                  FROM aula t_a
//                  JOIN sede t_s ON (t_a.id_sede=t_s.id_sede)
//                  JOIN administrador t_admin ON (t_s.id_sede=t_admin.id_sede)
//                  WHERE t_admin.nombre_usuario=$nombre_usuario";
//            $aulas=toba::db('gestion_aulas')->consultar($sql);
             if(isset($this->s__id_sede)){
                 
             }
	}

	function evt__formulario__alta($datos)
	{
//		$this->dep('datos')->tabla('aula')->set($datos);
//		$this->dep('datos')->sincronizar();
//		$this->resetear();
            //print_r($datos);
            $this->s__id_sede=$datos['sede'];
	}

	function evt__formulario__modificacion($datos)
	{
		$this->dep('datos')->tabla('aula')->set($datos);
		$this->dep('datos')->sincronizar();
		$this->resetear();
	}

	function evt__formulario__baja()
	{
		$this->dep('datos')->eliminar_todo();
		$this->resetear();
	}

	function evt__formulario__cancelar()
	{
		$this->resetear();
	}

	function resetear()
	{
		$this->dep('datos')->resetear();
	}
        
        function evt__volver (){
            //print_r("Se ejecuta volver");
            $this->set_pantalla('pant_edicion');
        }

}

?>