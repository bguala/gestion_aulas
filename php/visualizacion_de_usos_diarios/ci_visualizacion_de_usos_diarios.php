<?php
class ci_visualizacion_de_usos_diarios extends toba_ci
{
        protected $s__pedido=0;
        protected $s__establecimiento;                    //Guarda el nombre del establecimiento 
        protected $s__sede;                               //Se usa para obtener todas las aulas de una sede
        protected $s__hora_actual;                        //contiene la hora actual que se usa para hacer la consulta sql
        protected $s__horarios_disponibles=array();
        
        protected $s__fecha_consulta;
        protected $s__dia_consulta;
        protected $s__id_aula;


        //---- Cuadro -----------------------------------------------------------------------
        
        function ini__operacion() {
            $this->dep('cuadro')->colapsar();
            $this->dep('form_encabezado')->colapsar();
        } 
        
	function conf__cuadro(toba_ei_cuadro $cuadro)
	{
                //obtenemos un arreglo que posee todos los datos relacionados a la fecha y hora
                $fecha=  getdate();
                $this->s__sede=1;
                
                //obtenemos el periodo correspondiente
                $fecha_consulta=date('Y-m-d');
                $anio_lectivo=date('Y');
                $periodo=$this->dep('datos')->tabla('periodo')->get_periodo_calendario($fecha_consulta, $anio_lectivo);
                
                $this->s__fecha_consulta=$fecha_consulta;
                //obtenemos el dia de la semana
                $this->s__dia_consulta=$this->obtener_dia($fecha['wday']);
                                                                
                $this->s__hora_actual="'".$fecha['hours'].":".$fecha['minutes'].":".$fecha['seconds']."'";
                //$this->s__hora_actual="'12:55:00'";
            
                $cuadro->descolapsar();
                
                //obtenemos todas las aulas de una unidad academica para hacer una resta de cjtos. mas adelante
                $aulas_ua=$this->dep('datos')->tabla('aula')->get_aulas_por_sede($this->s__sede);        
                              
                //obtenemos todas las asignaciones que pertenecen a una unidad academica, que incluyen la hora actual
                $asignaciones=$this->procesar_periodo($periodo, 'xx');
                
                //obtenemos las aulas que tienen un horario disponible. Esos horarios no incluyen la hora actual
                $aulas_disponibles=$this->obtener_espacios_disponibles($aulas_ua, $asignaciones);
                
                $this->unificar_asignaciones(&$asignaciones, $aulas_disponibles);
                
                $cuadro->set_datos($asignaciones);
                
//            }
	}
        
//        function obtener_horarios_disponibles ($aulas_disponibles){
//            foreach ($aulas_disponibles as $aula){
//                //obtener todos los horarios ocupados para $aula, en el dia, cuatrimestre, anio y hora actual (hay que obtener las asignaciones por periodo y descartar las definitivas)
//                //La consulta debe traer (hora_inicio,hora_fin,materia,responsable,ua)
//                //obtener todos los espacios disponibles
//                //obtener el espacio disponible donde esta incluida la hora actual
//            }
//        }

        /*
         * une dos arreglos
         * @periodo es un parametro pasao por referencia desde conf__cuadro
         */
        function unificar_asignaciones ($periodo, $definitiva){
            foreach ($definitiva as $clave=>$valor){
                if(isset($valor)){
                   $periodo[]=$valor; //agrega al final
                }
            }            
        }
        
        /*
         * El objetivo de esta funcion es devolver todos los espacios disponibles en un determinado horario 
         * @aulas contiene todas las aulas de una Unidad Academica
         * @$asignaciones contiene todos los horarios ocupados en las aulas de una Unidad Academica, puede 
         * contener asignaciones por cuatrimestre y examen final. 
         */
        function obtener_espacios_disponibles ($aulas, $asignaciones){
            
            //obtenemos las aulas que actualmente estan ocupadas 
            $aulas_ocupadas=$this->obtener_aulas_ocupadas($asignaciones);
            
            //obtenemos todas las aulas de una Unidad Academica que estan desocupadas
            $this->descartar_aulas(&$aulas, $aulas_ocupadas);
            
            $aulas_disponibles=array();
            if(count($aulas)>0){
                $this->completar_aulas_disponibles($aulas, &$aulas_disponibles);
            }
            
            return $aulas_disponibles;
            
        }
        
        /*
         * Esta funcion completa el arreglo de aulas disponibles con 
         * (hora_inicio,hora_fin,materia,responsable,ua) 
         */
        function completar_aulas_disponibles ($aulas, $aulas_disponibles){          
            
            //guardamos todas las aulas que en la hora actual estan disponibles
            foreach ($aulas as $clave=>$aula){
                if(isset($aula)){ 
                    $this->s__id_aula=$aula['id_aula'];
                    $horario_disponible=$this->obtener_horario_disponible($aula);

                    $aula['hora_inicio']=$horario_disponible['hora_inicio'];
                    $aula['hora_fin']=$horario_disponible['hora_fin'];
                    $aula['finalidad']="*** DISPONIBLE ***";
                    $aula['responsable']="************";
                    $aula['descripcion']="************";
                    $aulas_disponibles[]=$aula; //agrega al final
                }
            }
           
        }
        
        /*
         * Esta funcion devuelve un horario disponible que contiene a la hora actual. El calculo de horarios
         * disponibles se realiza teniendo en cuenta las asignaciones de UN aula para la fecha actual.
         */
        function obtener_horario_disponible ($aula){
                                  
            $anio_lectivo=date('Y');
            $periodo=$this->dep('datos')->tabla('periodo')->get_periodo_calendario($this->s__fecha_consulta, $anio_lectivo);
            //$asignaciones_por_aula=$this->dep('datos')->tabla('asignacion')->get_asignaciones_por_aula($dia, $cuatrimestre, $anio, $aula['id_aula']);
            $asignaciones_por_aula=$this->procesar_periodo($periodo, 'au');
            
            $horarios=$this->calcular_espacios_disponibles(array(), $asignaciones_por_aula);
            
            $this->depurar_horarios($horarios, $aula);
            
            $horario_disponible=$this->extraer_horario_disponible();
            
            $this->s__horarios_disponibles=array();
            
            return $horario_disponible;
            
        }
        
        function extraer_horario_disponible (){
            $i=0;
            $longitud=count($this->s__horarios_disponibles);
            $fin=FALSE;
            //guardamos el horario disponible que contiene a la hora actual
            $horario=array();
            while(($i < $longitud) && !$fin){
                
                //s__horarios_disponibles=Array ( 0 => Array() 1 => Array() )
                $elto=$this->s__horarios_disponibles[$i];
                $hora_inicio="'{$elto['hora_inicio']}'";
                $hora_fin="'{$elto['hora_fin']}'";
                //print_r(" dfgdf {$elto['hora_inicio']} {$elto['hora_fin']}");exit();
                if(($this->s__hora_actual >= $hora_inicio) && ($this->s__hora_actual <= $hora_fin)){
                    
                    $horario['hora_inicio']=$elto['hora_inicio'];
                    $horario['hora_fin']=$elto['hora_fin'];
                    $fin=TRUE;
                }
                
                $i += 1;
            }
            
            return $horario;
            
        }
        
        /*
         * Esta funcion realiza una resta de conjuntos
         * @aulas contiene todas las aulas de una Unidad Academica
         * @aulas_ocupadas contiene las aulas que estan siendo utilizadas en un determinado horario
         */
        function descartar_aulas ($aulas, $aulas_ocupadas){
            $n=count($aulas);
            $m=count($aulas_ocupadas);
            if($n != $m){ //si la longitud de ambos arreglos es distinta debemos descartar al menos 1 aula de $aulas
                $i=0;
                
                //recorro el arreglo aulas 
                while ($i < $n){
                    $fin=FALSE;
                    $j=0;
                    //recorro el arreglo aulas_ocupadas
                    while (($j < $m) && !$fin){
                        
                        if(strcmp($aulas[$i]['id_aula'], $aulas_ocupadas[$j]['id_aula'])==0){
                            $aulas[$i]=null;
                            $fin=TRUE;
                        }
                            
                        $j += 1;
                    }
                    
                    $i += 1;
                }
            }
            else{
                $aulas=array();
            }
        }
        
        /*
         * Genera un arreglo con las aulas utilizadas en un dia especifico
         * @espacios_concedidos contiene todos los horarios ocupados en las aulas de una Unidad Academica en un dia especifico  
         */
        function obtener_aulas_ocupadas ($espacios_concedidos){
            $aulas=array();       
            $indice=0;
            foreach($espacios_concedidos as $clave=>$valor){
                $aula=array(); // indice => (aula, id_aula)
                $aula['aula']=$valor['aula'];
                $aula['id_aula']=$valor['id_aula'];
                $existe=$this->existe($aulas, $aula);
                if(!$existe){
                    $aulas[$indice]=$aula;
                    $indice += 1;
                }
            }
            return $aulas;
        }
        
        /*
         * Verifica si un aula ya se encuentra presente en la estructura aulas
         * @aulas contiene un cjto de aulas
         * @aula se verifica que si exista en aulas.
         */
        function existe ($aulas, $aula){
            $existe=FALSE;
            
            if(count($aulas) != 0){
                $indice=0;
                $longitud=count($aulas);
                while(($indice < $longitud) && !$existe){
                    $existe=(strcmp($aulas[$indice]['id_aula'], $aula['id_aula'])==0) ? TRUE : FALSE;
                    $indice += 1;
                }
            }
            return $existe;
        }
        

	//---- Filtro ---------------------------------------------------------------------------------

	function conf__filtro (toba_ei_formulario $form)
	{
//		if ($this->dep('datos')->esta_cargada()) {
//			$form->set_datos($this->dep('datos')->tabla('asignacion')->get());
//		}
            if(isset($this->s__establecimiento)){
                $form->ef('unidad_academica')->set_estado($this->s__establecimiento);
                $form->ef('sede')->set_estado($this->s__sede);
                //$form->set_solo_lectura(array('unidad_academica', 'sede'));
            }
            
            
        }

	function evt__filtro__buscar_aulas ($datos)
	{
//		$this->dep('datos')->tabla('asignacion')->set($datos);
//		$this->dep('datos')->sincronizar();
//		$this->resetear();
            //print_r($datos);
            $this->s__establecimiento=$datos['unidad_academica'];
            $this->s__sede=$datos['sede'];
            
            
	}
        
        /*
         * Este formulario posee una extension javascript que permite actualizar la pantalla cada cierto 
         * periodo de tiempo.
         */
        function conf__from_prueba (toba_ei_formulario $form){
            
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
        
        //---- Form Encabezado ------------------------------------------------------------------------
        
        function conf__form_encabezado (toba_ei_formulario $form){
//            if(isset($this->s__sede)){
                $form->descolapsar();
                date_default_timezone_set('UTC-03:00');
                $hora_actual=date('H:i:s');
                $fecha_actual=date('Y-m-d');
                $form->ef('fecha_actual')->set_estado($fecha_actual);
                $form->ef('hora_actual')->set_estado($hora_actual);
                $form->ef('fijo')->set_estado("<center><p style='font-size: 25px; font-weight: bold; text-align: center; padding-left:175px; padding-right:175px; '>Pantalla de Usos Actuales</p></center>");
//            }
        }
        
        function obtener_cuatrimestre (){
            $fecha=  getdate();
            $cuatrimestre=2;
            if(($fecha['mon'])>=1 && ($fecha['mon'])<=6){
                $cuatrimestre=1;
            }
            
            return $cuatrimestre;
        }
        
        function obtener_dia ($dia){
            $dias=array(  0=>'Lunes', 
                          1=>'Martes', 
                          2=>'Miércoles', 
                          3=>'Jueves', 
                          4=>'Viernes', 
                          5=>'Sábado'
                );
                        
            return $dias[$dia];
        }
        
        function evt__volver (){
            $this->set_pantalla('pant_filtro');
        }
        
        //---- Funciones para calcular espacios disponibles -------------------------------------------
        
        /*
         * calcula los espacios disponibles en un aula (se tiene en cuenta el dia)
         * @espacios es un arreglo con todos los horarios ocupados en un aula x (se tiene en cuenta el dia)
         */
        function calcular_espacios_disponibles ($aula, $espacios){
            
            //$longitud=count($horarios);
            
//            print_r($espacios);
//            print_r("<br><br>");
//            print_r("Esto es false : ".FALSE);
//            print_r("<br><br>");
            
            //creo un arreglo con todos los horarios de cursado por dia
            $horarios=$this->crear_horarios();
            $longitud=count($horarios);
            foreach ($espacios as $clave=>$espacio){
                $indice=0; //debe ir ahi porque el arreglo no esta ordenado
                $fin=FALSE;
                while(($indice < $longitud) && !$fin){
                    //cambiar por ? :
                    if(strcmp(($horarios[$indice][0]), ($espacio['hora_inicio'])) == 0){
//                        print_r(strcmp(($horarios[$indice][0]), ($espacio['hora_inicio'])));
//                        print_r($espacio['hora_fin']);
                        
                        //para que el arreglo horarios pueda ser modificado en la rutina eliminar_horarios
                        //hay que realizar un pasaje de parametros por referencia (&horarios)
                        $this->eliminar_horario(&$horarios, $indice, $longitud, $espacio['hora_fin']);
                        
//                        print_r("SE ELIMINO U ESPACIO<br><br>");
//                        print_r("EL VALOR DE INDICE ES : $indice");
                        $fin=TRUE;
                        
                        //para volver a recorrer todo el arreglo de  nuevo en la proxima iteracion.
                        //Evita conflictos si el arreglo no esta ordenado.
                        $indice=0;
                    }
                    else{
                        $indice += 1;
                    }
                }
            }
            return $horarios;
        }
        
        /*
         * crea un arreglo con los horarios disponbles 
         */
        function crear_horarios (){
            $hora=8;
            $indice=0;
            $prefijo="";
            $horarios=array();
            while($hora <= 22){
                
                $prefijo=($hora <= 9) ? "0".$hora : $hora ;
                
                $horarios[$indice]=array(
                    0 => "$prefijo:00:00",
                    1 => TRUE
                );
                $indice += 1;
                //replica, para obtener los horarios disponibles
                $horarios[$indice]=array(
                    0 => "$prefijo:00:00",
                    1 => TRUE
                );
                $indice += 1;
                $horarios[$indice]=array(
                    0 => "$prefijo:15:00",
                    1 => TRUE
                );
                $indice += 1;
                $horarios[$indice]=array(
                    0 => "$prefijo:30:00",
                    1 => TRUE
                );
                $indice += 1;
                //replica, para obtener los horarios disponibles
                $horarios[$indice]=array(
                    0 => "$prefijo:30:00",
                    1 => TRUE
                );
                $indice += 1;
                $horarios[$indice]=array(
                    0 => "$prefijo:45:00",
                    1 => TRUE
                );
                
                $indice += 1;
                $hora += 1;
                
            }
            
            return $horarios;
        }
        
        /*
         * devuelve un arreglo con los horarios disponibles para un aula x
         * @horarios contiene los horarios ocupados y disponibles para un aula 
         * TRUE indica horario disponible
         * FALSE indica horario ocupado 
         */
        function depurar_horarios ($horarios, $aula){
            $horarios_disponibles=array();
            $indice=0;
            $longitud=count($horarios);
            $indice_horario=0;
            //guarda un horario disponible con el formato (hora_inicio, hora_fin, aula)
            $horario=array();
            $hora_fin="";
            while($indice_horario < $longitud){
                if($horarios[$indice_horario][1]){
                    
                    $hora_inicio=$horarios[$indice_horario][0];
                    $horario['hora_inicio']=$hora_inicio;
//                    print_r("<br><br>ESTA ES LA HORA INICIO : $hora_inicio<br><br>");
                    //aca no hay que acumular el retorno
                    $indice_horario = $this->obtener_horario($indice_horario, $horarios, &$hora_fin);
                    $horario['hora_fin']=$hora_fin;
                    $horario['aula']=$aula['aula'];
                    $horario['id_aula']=$aula['id_aula'];
                    $horarios_disponibles[$indice]=$horario;
                    //los eltos se agregan al final del arreglo
                    $this->s__horarios_disponibles[]=$horario;
                    $indice += 1;
                }
                else{
                    $indice_horario += 1;
                }
            }
            return $horarios_disponibles;
        }
        
        function obtener_horario ($indice_horario, $horarios, $hora_fin){
            
            $longitud=count($horarios);
            $fin=FALSE;
            while(($indice_horario < $longitud) && !$fin){
                
                if(!$horarios[$indice_horario][1]){
                    $hora_fin=$horarios[$indice_horario][0];
//                    print_r("<br><br>ESTA ES LA HORA FIN : $hora_fin<br><br>");
                    $fin=TRUE;
                }
                $indice_horario += 1;
            }
            
            //para computar el ultimo horario, 22:45
            if((($indice_horario - 1)<$longitud) && $horarios[($indice_horario-1)][1]){
                $hora_fin=$horarios[($indice_horario-1)][0];
            }
            
            return $indice_horario;
        }
        
        /*
         * @horarios contiene los horarios de clase para un dia de semana
         * @indice contiene la posicion desde donde hay que borrar horarios
         * @longitud contiene la cantidad de eltos que posee el arreglo horarios 
         * @hora_fin indica un tope para borrar horarios
         */
        function eliminar_horario ($horarios, $indice, $longitud, $hora_fin){
            $fin=FALSE;
            while(($indice < $longitud) && !$fin){
                //print_r("ENTRA EN BUCLE DE ELIMINAR HORARIOS");
                
                //asignando false indicamos que un espacio ya esta ocupado
//                print_r($indice);
//                print_r($horarios[$indice][1]);
                
                //en este caso false significa que el horario esta ocupado
                $horarios[$indice][1]=FALSE;
//                if(!$horarios[$indice][1]){
//                    print_r($horarios[$indice]);
//                }
                if(strcmp(($horarios[$indice][0]), $hora_fin) == 0){
                    $fin=TRUE;
                }
                $indice += 1;
            }
            
            return $indice;
        }
        
        //---- Funcion para procesar periodos -------------------------------------------------------------
        //---- Procesa dos periodos, cuatrimestre y examen final ------------------------------------------
        
        function procesar_periodo ($periodo, $accion){
            foreach ($periodo as $clave=>$valor){
                
                switch ($valor['tipo']){
                    case 'Cuatrimestre' : if(strcmp($accion, 'au')==0){
                                              $cuatrimestre=$this->dep('datos')->tabla('asignacion')->get_asignaciones_por_aula_cuatrimestre($this->s__dia_consulta, $valor['id_periodo'], $this->s__fecha_consulta, $this->s__id_aula);
                                          }
                                          else{
                                              $cuatrimestre=$this->dep('datos')->tabla('asignacion')->get_asignaciones_cuatrimestre_por_hora($this->s__id_sede, $this->s__dia_consulta, $valor['id_periodo'], $this->s__fecha_consulta, $this->s__hora_actual);
                                          }
                                          break;
                                      
                    case 'Examen Final' :  if(strcmp($accion, 'au')==0){
                                              $examen_final=$this->dep('datos')->tabla('asignacion')->get_asignaciones_por_aula_examen_final($this->s__dia_consulta, $valor['id_periodo'], $this->s__fecha_consulta, $this->s__id_aula);
                                           }
                                           else{
                                              //obtenemos todas las asignaciones por periodo, que estan inluidas en un cuatrimestre,
                                              //pero que pertenecen a un examen_final
                                              $examen_final=$this->dep('datos')->tabla('asignacion')->get_asignaciones_examen_final_por_hora($this->s__id_sede, $this->s__dia_consulta, $valor['id_periodo'], $this->s__fecha_consulta, $this->s__hora_actual);
                                           }                                   
                                           break;
                }
                
            }
            
            if((count($cuatrimestre)>0) && (count($examen_final)>0)){
                
                //debemos iniciar descarte y unificacion
                //asig_definitivas = cuatrimestre, asig_periodo = examen final.
                $this->descartar_asignaciones_definitivas($examen_final, &$cuatrimestre);

                $this->unificar_asignaciones(&$examen_final, $cuatrimestre);

                return $examen_final;
                
                
            }
            
            if((count($cuatrimestre)>0) && (count($examen_final)==0)){
                
                //devolvemos solo cuatrimestre
                return $cuatrimestre;
                
                
            }
            
            if((count($cuatrimestre)==0) && (count($examen_final)>0)){
                
                //devolvemos solo examen final
                return $examen_final;
                
            }
            
            if((count($cuatrimestre)==0) && (count($examen_final)==0)){
                                
                //devolvemos vacio
                return array();
                               
            }
        }
        
        //---- Funcion para procesar asignaciones por aula ------------------------------------------------
        //---- Se utiliza para calcular horarios disponibles por aula -------------------------------------

}

?>