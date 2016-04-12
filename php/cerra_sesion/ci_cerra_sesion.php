<?php
class ci_cerra_sesion extends toba_ci
{
	//---- Cuadro -----------------------------------------------------------------------

	function conf__cuadro(toba_ei_cuadro $cuadro)
	{
		$cuadro->set_datos($this->dep('datos')->tabla('asignacion')->get_listado());
	}

	function evt__cuadro__seleccion($datos)
	{
		$this->dep('datos')->cargar($datos);
	}

	//---- Formulario -------------------------------------------------------------------

	function conf__formulario(toba_ei_formulario $form)
	{
//		if ($this->dep('datos')->esta_cargada()) {
//			$form->set_datos($this->dep('datos')->tabla('asignacion')->get());
//		}
            //guardamos la ruta en donde se encuentra almacenada la imagen
            $path_imagen=  toba_dir()."\www\img\logout_1.png";
            print_r($path_imagen);
            //obtenemos path y url de un archivo temporal llamado logout_1
            $tmp=toba::proyecto()->get_www_temp('logout_1.png');
            
            //abrimos el archivo temporal en modo escritura
            $archivo_tmp=fopen($tmp['path'], 'w');
            //abrimos la imagen que vamos a poner en el ef_fijo en modo lectura
            $imagen=  fopen($path_imagen, 'r');
            
            //transferimos el contenido de la imagen al archivo temporal (origen, destino)
            stream_copy_to_stream($imagen, $archivo_tmp);
            
            //cerramos ambos flujos
            fclose($archivo_tmp);
            fclose($imagen);
            
            $form->ef('imagen')->set_estado("<img src='{$tmp['url']}' align='left'>");
	}

	function evt__formulario__aceptar($datos)
	{
//		$this->dep('datos')->tabla('asignacion')->set($datos);
//		$this->dep('datos')->sincronizar();
//		$this->resetear();
            toba::manejador_sesiones()->logout();
	}

	function evt__formulario__modificacion($datos)
	{
		$this->dep('datos')->tabla('asignacion')->set($datos);
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

}

?>