<?php

require_once('3ros/phpExcel/PHPExcel.php');

class ci_migrar_docentes extends toba_ci
{
	protected $s__registros_corruptos=array();
    
	//---- Formulario -------------------------------------------------------------------

	function conf__formulario(toba_ei_formulario $form)
	{

	}

	function evt__formulario__alta($datos)
	{
            $nombre_archivo=$datos['archivo']['name'];
            //verificamos la extension del archivo
            if($this->verificar_extension_archivo($nombre_archivo)){
                $this->s__registros_corruptos=array();
                $registros=$this->registrar_docentes($datos);
                //mostramos un mensaje de cierre
                $mensaje=" Se importaron con éxito $registros registros del archivo $nombre_archivo. ";
                
                $cantidad=count($this->s__registros_corruptos);
                if($cantidad > 0){
                    $this->decodificar_registros();
                    $mensaje .= "Sin Embargo se detectaron $cantidad registros con algún tipo de anomalía. Estos registros"
                            . " se deben volver a registrar. ";
                }
                
                toba::notificacion()->agregar(utf8_decode($mensaje), 'info');
            }
            else{
                $mensaje=" Extensión de archivo incorrecta. Las extensiones válidas son xls o xlsx ";
                toba::notificacion()->agregar(utf8_decode($mensaje), $nivel);
            }
                                   
	}
        
        function registrar_docentes ($datos){
                
            $archivo=$datos['archivo']['tmp_name'];
            $excel= PHPExcel_IOFactory::load($archivo);
            $hoja=$excel->getActiveSheet()->toArray(null, true,true,true);
            $fila=0;
            
            foreach ($hoja as $indice=>$registro){
                
                $es_registro_vacio=$this->es_registro_vacio($registro);
                
                if(!$es_registro_vacio){
                    
                    $fila += 1;
                    $problema="";
                    if(($this->es_documento($registro['A'], &$problema) && $this->es_tipo_doc($registro['B'], &$problema) && $this->es_documento($registro['J'], &$problema))){

                        $nro_doc=$registro['A'];
                        $tipo_doc=$registro['B'];

                        $persona=array(
                            'nro_doc' => $nro_doc,
                            'tipo_doc' => strtoupper($tipo_doc),
                            'nombre' => utf8_decode(strtoupper($registro['C'])),
                            'apellido' => utf8_decode(strtoupper($registro['D'])),
                            'telefono' => utf8_decode(strtoupper($registro['E'])),
                            'correo_electronico' => $registro['F'],
                            'domicilio' => utf8_decode(strtoupper($registro['G'])),
                            'ciudad' => utf8_decode(strtoupper($registro['H']))    
                        );

                        $docente=array(
                            'nro_doc' => $nro_doc,
                            'tipo_doc' => strtoupper($tipo_doc),
                            'titulo' => utf8_decode(strtoupper($registro['I'])),
                            'legajo' => $registro['J']
                        );

                        $this->dep('datos')->tabla('persona')->nueva_fila($persona);
                        $this->dep('datos')->tabla('persona')->sincronizar();
                        $this->dep('datos')->tabla('persona')->resetear();

                        $this->dep('datos')->tabla('docente')->nueva_fila($docente);
                        $this->dep('datos')->tabla('docente')->sincronizar();
                        $this->dep('datos')->tabla('docente')->resetear();

                    }
                    else{
                        $registro['problema']=$problema;
                        $this->s__registros_corruptos[]=$registro;
                        $fila--;
                    }
                }
            }
                        
            return $fila;
            
        }
        
        /*
         * Esta funcion verifica si un registro del Excel esta completamente vacio.
         * Devuelve TRUE si el registro esta vacio, FALSE caso contrario.
         */
        function es_registro_vacio ($registro){
            $indices=array(
                'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'problema'
            );
            $longitud=count($indices);
            $i=0;
            $es_vacio=TRUE;
            while (($i<$longitud) && $es_vacio){
                $es_vacio=(isset($registro[$indices[$i]])) ? FALSE : TRUE ;
                $i++;
            }
            
            return $es_vacio;
        }
        
        /*
         * Esta funcion decodifica palabras de los registros corruptos para evitar conflictos con los acentos
         * en el cuadro.
         */
        function decodificar_registros (){
            $indices=array(
                'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'problema'
            );
            $longitud=count($this->s__registros_corruptos);
            $i=0;
            while($i<$longitud){
                
                foreach ($indices as $clave=>$valor){
                    $this->s__registros_corruptos[$i][$valor]= utf8_d_seguro($this->s__registros_corruptos[$i][$valor]);
                }
                $i++;
            }
        }
               
               
        /*
         * Esta funcion se utiliza para verificar si el nro_doc y el legajo son numeros.
         */
        function es_documento ($numero, $problema){
            $resultado=FALSE;
            if(isset($numero)){ //si la celda esta vacia, php considera a ese elto null 
                if(is_numeric($numero)){
                    $resultado=TRUE;
                }
                else{
                    $problema=" El Número de Documento no es válido ";
                }
            }
            else{
                $problema=" Documento inexistente ";
            }
            
            return $resultado;
        }
        
        function es_cadena ($cadena, $problema){
            $resultado=FALSE;
            if(isset($cadena)){
                if($this->es_cadena_pura($cadena)){
                    $resultado=TRUE;
                }
                else{
                    $problema=" Nombre o Apellido incorrectos ";
                }
            }
            else{
                $problema=" Nombre o Apellido inexistentes ";
            }
            
            //para que ningun registro se guarde en el sistema debemos comentar esta linea
            return $resultado;
        }
        
        /*
         * Esta funcion verifica que una cadena posea solamente letras ascii.
         */
        function es_cadena_pura ($cadena){
            trim($cadena);
            $longitud=  strlen($cadena);
            $existe=TRUE;
            $i=0;
            while(($i < $longitud) && $existe){
                $caracter=$cadena[$i];
                $codigo=ord($caracter); //obtenemos el codigo ascii de un caracter
                
                if(($codigo>=65 && $codigo<=90)||($codigo>=97 && $codigo<=122) || $this->es_letra_con_acento($codigo)){
                    ;
                }
                else{
                    $existe=FALSE;
                }
                
                $i++;
            }
            
            return $existe;
        }
        
        /*
         * Esta funcion verifica si una vocal posee acento.
         */
        function es_letra_con_acento ($codigo){
//            'a' => 160, 'e' => 130, 'i' => 161, 'o' => 162, 'u' => 163,
//            'A' => 181, 'E' => 144, 'I' => 214, 'O' => 224, 'U' => 233
            $acentos=array(
                160, 130, 161, 162, 163,
                181, 144, 214, 224, 233
            );
            
            $longitud=10;
            $i=0;
            $existe=FALSE;
            while (($i < $longitud) && !$existe){
                $codigo_ascii=$acentos[$i];
                if($codigo == $codigo_ascii){
                    $existe=TRUE;
                }
                
                $i++;
            }
            
            return $existe;
        }
        
        /*
         * Esta funcion verifica que el tipo_doc ingresado sea pasaporte o dni.
         */
        function es_tipo_doc ($cadena, $problema){
            $resultado=FALSE;
            if(isset($cadena)){
                $cadena=  strtoupper($cadena);
                if((strcmp($cadena,'DNI')==0)||(strcmp($cadena, 'PASAPORTE')==0)){
                    $resultado=TRUE;
                }
                else{
                    $problema=" El tipo de documento no es Pasaporte o Dni ";
                }
            }
            else{
                $problema=" Tipo de documento inexistente "; //es necesario verificar si existe el tipo_doc porque
                                                             //es parte de la PK de persona
            }
            
            return $resultado;
        }
        
        
        /*
         * Esta funcion borra registros que posean el nro_doc repetido.
         * @$hoja : contiene el contenido del excel, en formato recordset. Se pasa por referencia.
         * @$copia : contiene una copia del contenido del excel.
         */
        function borrar_registros_repetidos ($hoja, $copia){
            foreach ($copia as $clave=>$registro){
                $nro_doc=$registro['A'];
                      
                if(isset($nro_doc)){ //verificaciones que no sea una celda en blanco
                $longitud=count($hoja);
                $contador=0;
                for($i=0;$i<$longitud;$i++){
                    $documento=$hoja[$i]['A'];
                    if(isset($documento)){
                        if($nro_doc == $documento){ //ambos eltos son de tipo double
                            $contador += 1;
                            
                            if($contador >= 2){
                                $hoja[$i]['A']=NULL; //asignando NULL en el campo nro_doc el registro se considera repetido
                            }
                        }
                    }
                }
              }
            }
        }
        
        /*
         * Esta funcion comprueba que la extension del archivo Excel sea correcta.
         * Las extensones validas son:
         * a) .xls para Excel 2003.
         * b) .xlsx para Excel 2007.
         */
        function verificar_extension_archivo ($nombre_archivo){
            $longitud_total=  strlen($nombre_archivo);
            $xlsx=  substr($nombre_archivo, ($longitud_total - 4), $longitud_total);
            $xls=  substr($nombre_archivo, ($longitud_total - 3), $longitud_total);
            return ((strcmp($xlsx, "xlsx")==0) || (strcmp($xls, "xls")==0));
        }
        
        //---- Cuadro ---------------------------------------------------------------------------------
        
        function conf__cuadro (toba_ei_cuadro $cuadro){
            if(count($this->s__registros_corruptos)==0){
                $cuadro->colapsar();
            }
            else{
                $cuadro->descolapsar();
                $cuadro->set_datos($this->s__registros_corruptos);
            }
        }

}

?>