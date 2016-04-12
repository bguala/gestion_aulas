<?php
class ci_aulas_disponibles extends toba_ci
{
        
        protected $s__horarios_disponibles=array();
        protected $s__facultad;
        protected $s__id_sede;
        protected $s__dia;


        //---- Cuadro -----------------------------------------------------------------------

	function conf__cuadro(toba_ei_cuadro $cuadro)
	{
            if(!isset($this->s__horarios_disponibles)){
                $cuadro->colapsar();
            }
            else{
                $cuadro->descolapsar();
                $cuadro->set_titulo("Aulas disponibles de ".$this->s__facultad);
                $cuadro->set_datos($this->s__horarios_disponibles);
                //debemos vaciar el arreglo para no acumular paginas
                $this->s__horarios_disponibles=array();
            }
	}

	function evt__cuadro__seleccion($datos)
	{print_r($this->s__dia);
            $parametros=array(
                'id_aula' => $datos['id_aula'],
                'hora_inicio' => $datos['hora_inicio'],
                'hora_fin' => $datos['hora_fin'],
                'dia_semana' => $this->s__dia[0],
                'pantalla' => 'pant_persona',
            );
            toba::vinculador()->navegar_a("gestion_aulas", 3508,$parametros);                        
	}

	//---- Formulario -------------------------------------------------------------------

	function conf__formulario(toba_ei_formulario $form)
	{

//            $nombre_usuario=toba::usuario()->get_id();
//            $sql="SELECT t_a.id_sede, t_ua.descripcion as facultad
//                  FROM administrador t_a 
//                  JOIN sede t_s ON (t_a.id_sede=t_s.id_sede) 
//                  JOIN unidad_academica t_ua ON (t_s.sigla=t_ua.sigla)
//                  WHERE t_a.nombre_usuario=$nombre_usuario";
//            $datos_usuario=toba::db('gestion_aulas')->consultar($sql);
//            $this->s__facultad=$datos_usuario['facultad'];
//            $this->s__id_sede=$datos_usuario['id_sede'];
            $this->s__id_sede=1;
	}

	function evt__formulario__alta($datos)
	{
            
//            $nombre_usuario=toba::usuario()->get_id();
//            $sql="SELECT t_a.nombre, t_a.capacidad, t_ua.descripcion as facultad 
//                  FROM aula t_a
//                  JOIN sede t_s ON (t_a.id_sede=t_s.id_sede)
//                  JOIN unidad_academica t_ua ON (t_s.sigla=t_ua.sigla) 
//                  JOIN administrador t_admin ON (t_s.id_sede=t_admin.id_sede)
//                  WHERE t_admin.nombre_usuario=$nombre_usuario AND t_a.capacidad >= {$datos['capacidad']}";
//            $aulas=toba::db('gestion_aulas')->consultar($sql);
            
            $this->s__facultad="Administracion Central";
            $aulas_ua=$this->dep('datos')->tabla('aula')->get_aulas_con_capacidad($this->s__id_sede, $datos['capacidad']);
            
            $dia=$this->recuperar_dia($datos['fecha']);
            $this->s__dia=$dia;
            //print_r("El nombre de dia es : {$dia[0]} ");exit();
            
            //obtenemos todas las asignaciones para el dia especificado por el usuario. Se incluyen asignaciones
            //definitivas y por periodo 
            $asignaciones=$this->obtener_asignaciones($dia[0], $datos['capacidad'], $datos['fecha']);
            
//            print_r("<br><b><br>Estas son todas las asignaciones : <br><br><br>");
//            print_r($asignaciones);
//            print_r("<br><br><br>");exit();
            
            //a partir de las asignaciones para un dia de semana obtenemos todas las aulas involucradas
            $aulas=$this->obtener_aulas($asignaciones);
            
//            print_r("<br><br>Estas son las aulas : <br><br>");
//            print_r($aulas);
//            print_r("<br><br>");
            
            //obtenemos las aulas con disponibilidad total, de 8 a 22 hs
            $aulas_disponibles=$this->obtener_aulas_con_disponibilidad_total($aulas, $aulas_ua);
            
//            print_r("<br><br>Estas son las aulas con disponibilidad total : <br><br>");
//            print_r($aulas_disponibles);
//            print_r("<br><br>");
           
            //por cada aula obtenemos todos los horarios de cursado
            $espacios_filtrados=$this->filtrar_espacios($aulas, $asignaciones);
            
//            print_r("<br><br>Estos son los espacios filtrados : <br><br>");
//            print_r($espacios_filtrados);
//            print_r("<br><br>");

            //obtenemos un arreglo con todos los horarios disponibles
            $horarios_disponibles=$this->obtener_horarios_disponibles($aulas, $espacios_filtrados);
            
            //no hay problemas con el arreglo s__horarios_disponibles porque siempre agregamos eltos. 
            //al final del mismo
            if(count($aulas_disponibles)>0){
                $total=$this->obtener_horarios_disponibles($aulas_disponibles, array());
            }
            
            //print_r($this->s__horarios_disponibles);
//            print_r("<br><br><br>Estos son los horarios disponibles : <br><br><br>");
//            print_r($this->s__horarios_disponibles);
//            print_r("<br><br><br>");
            if(isset($datos['hora_inicio']) || isset($datos['hora_fin'])){
                $this->filtrar_horarios($datos['hora_inicio'], $datos['hora_fin']);
            }
       	}
        
        function obtener_asignaciones ($dia, $capacidad, $fecha){
            //$fecha_actual=date();
            
            $anio=$this->recuperar_anio($fecha);
            //print_r("Este es el dia : $dia y este es el año : $anio");exit();
            $cuatrimestre=$this->obtener_cuatrimestre();
            
            //hace falta dos consultas separadas??? SI, porque lo que nos interesa es obtener
            //los horarios exactos que estan ocupados para un dia de la semana. Pueden haber 
            //varios periodos incluidos en una asignacion definitiva.
            //a $sql_1 hay que agregarle esta condicion en el 2do JOIN:
            // AND ($fecha BETWEEN t_p.fecha_inicio AND t_p.fecha_fin)
            //con esta instruccion lo que hacemos es obtener los periodos activos
            $sql_1="SELECT t_a.hora_inicio, t_a.hora_fin, t_a.finalidad, t_au.nombre as aula, t_au.id_aula
                  FROM asignacion t_a
                  JOIN aula t_au ON (t_a.id_aula=t_au.id_aula)
                  JOIN asignacion_periodo t_p ON (t_a.id_asignacion=t_p.id_asignacion)
                  JOIN esta_formada t_f ON (t_p.id_asignacion=t_f.id_asignacion AND t_f.nombre='$dia' AND t_f.cuatrimestre=$cuatrimestre AND t_f.anio=$anio)
                  WHERE (t_au.capacidad >= $capacidad) AND (t_au.id_sede={$this->s__id_sede})";
            $asignaciones_periodo=toba::db('gestion_aulas')->consultar($sql_1);
            
//            print_r("<br><br>Estas son las asignaciones por periodo: <br><br>");
//            print_r($asignaciones_periodo);
//            print_r("<br><br><br>");
            
            $sql_2="SELECT t_a.hora_inicio, t_a.hora_fin, t_a.finalidad, t_au.nombre as aula, t_au.id_aula
                  FROM asignacion t_a 
                  JOIN aula t_au ON (t_a.id_aula=t_au.id_aula)
                  JOIN asignacion_definitiva t_d ON (t_a.id_asignacion=t_d.id_asignacion AND t_d.nombre='$dia' AND t_d.cuatrimestre=$cuatrimestre AND t_d.anio=$anio)
                  WHERE (t_au.capacidad >= $capacidad) AND (t_au.id_sede={$this->s__id_sede})";
            $asignaciones_definitivas=toba::db('gestion_aulas')->consultar($sql_2);
            
//            print_r("Estas son las asignaciones definitivas : <br><br>");
//            print_r($asignaciones_definitivas);//exit();
            
            if(count($asignaciones_periodo) > 0){
                //quitamos las asignaciones definitivas solapadas con las asignaciones por periodo.
                //Las asignaciones por periodo tiene prioridad.
                $this->descartar_asignaciones_definitivas($asignaciones_periodo, &$asignaciones_definitivas);
            
                //unimos las asignaciones por periodo y definitivas en una misma estructura
                $this->unificar_asignaciones(&$asignaciones_periodo, $asignaciones_definitivas);
                
                return $asignaciones_periodo;
            }
            else{
                return $asignaciones_definitivas;
            }
        }
        
        function descartar_asignaciones_definitivas ($asig_periodo, $asig_definitiva){
            $longitud=count($asig_definitiva);
            $i=0;
            foreach ($asig_periodo as $periodo){
                while($i<$longitud){
                    
                    if($this->existe_inclusion($periodo,$asig_definitiva[$i])){
                        //borramos una asignacion definitiva si contiene a una por periodo.
                        //Las asignaciones por periodo tiene prioridad
                        $asig_definitiva[$i]=null;
                    }
                    $i += 1;
                }
                
                $i=0;
            }
        }
        
        /*
         * devuelve true si una asignacion por periodo esta incluida en una definitiva.
         */
        function existe_inclusion ($periodo, $definitiva){
            return ((strcmp($periodo['aula'], $definitiva['aula'])==0) && 
                   (($periodo['hora_inicio'] >= $definitiva['hora_inicio']) && ($periodo['hora_inicio'] <= $definitiva['hora_fin'])) &&
                   ($periodo['hora_fin'] <= $definitiva['hora_fin']));
        }
        
        function unificar_asignaciones ($periodo, $definitiva){
            foreach ($definitiva as $clave=>$valor){
                if(isset($valor)){
                   $periodo[]=$valor; //agrega al final
                }
            }            
        }
        
        /*
         * genera un arreglo con las aulas utilizadas en un dia especifico
         * @espacios_concedidos contiene todos los espacios concedidos en las aulas de una Unidad Academica en un dia especifico  
         */
        function obtener_aulas ($espacios_concedidos){
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
         * verifica si un aula ya se encuentra presente en la estructura aulas
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
        
        function obtener_cuatrimestre (){
            $fecha=  getdate();
            $cuatrimestre=2;
            if(($fecha['mon'])>=1 && ($fecha['mon'])<=6){
                $cuatrimestre=1;
            }
            
            return $cuatrimestre;
        }
        
        function obtener_dia ($dia_numerico){
            $dias=array( 
                         1 => 'Lunes', 
                         2 => 'Martes',
                         3 => 'Miércoles', 
                         4 => 'Jueves', 
                         5 => 'Viernes', 
                         6 => 'Sábado'
            );
            $dia='';
            foreach($dias as $clave=>$valor){
                if($clave == $dia_numerico){
                   $dia=$valor; 
                }
            }
            
            return $dia;
        }
        
        /*
         * genera un recordset con todos los horarios ocupados en un aula. Cada Elto del recordset
         * posee todos los horarios para un aula x
         */
        function filtrar_espacios ($aulas, $espacios_concedidos){
            $indice=0;
            $espacios_filtrados=array();
            foreach($aulas as $clave=>$aula){
                $espacios=$this->obtener_espacios($aula,$espacios_concedidos);
                $espacios_filtrados[$indice]=$espacios;
                $indice += 1;
            }
            return $espacios_filtrados;
        }
        
        /*
         * genera un arreglo con todos los horarios ocupados en un aula x
         * @espacio es un arreglo con el siguiente formato (hora_inicio, hora_fin, aula)
         */
        function obtener_espacios ($aula, $espacios_concedidos){
            $espacios=array();
            $indice=0;
            foreach($espacios_concedidos as $clave=>$espacio){
                if(strcmp($aula['id_aula'], $espacio['id_aula'])==0){
                    $espacios[$indice]=$espacio;
                    $indice += 1;
                }
            }
            return $espacios;
        }
        
        /*
         * calcula los espacios disponibles en un aula (se tiene en cuenta el dia)
         * @espacios es un arreglo con todos los horarios ocupados en un aula x (se tiene en cuenta el dia).
         * Espacios tambien puede contener NULL, en este caso el foreach no genera ningun error al trabajar con la variable
         * nula. Lo que devolvemos en este caso es un arreglo con los horarios de 8 a 22 marcados en FALSE
         * lo cual es correcto.
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
         * devuelve todas las aulas que poseen diponibilidad total de horarios (de 8 a 22 hs)
         */
        function obtener_aulas_con_disponibilidad_total ($aulas, $aulas_ua){
            $aulas_disponibles=array();
            if(count($aulas) == count($aulas_ua)){
                return $aulas_disponibles; //no hay aulas con disponibilidad total
            }
            else{
                foreach ($aulas_ua as $aula){
                    $existe=FALSE;
                    foreach ($aulas as $a){
                        //strcmp($aula['id_aula'], $a['id_aula']) == 0
                        if($aula['id_aula'] == $a['id_aula']){
                            $existe=TRUE;
                        }
                    }
                    
                    if(!$existe){
                        $aulas_disponibles[]=$aula;
                    }
                }
                return $aulas_disponibles;
            }
            
        }
        
        /*
         * Esta funcion dispara el calculo de horarios disponibles
         */
        function obtener_horarios_disponibles ($aulas, $horarios_ocupados){
            //$horarios_disponibles=array();
            foreach ($aulas as $clave=>$aula){
                //obtenemos los horarios ocupados para un aula especifica
                $horarios_ocupados_por_aula=$this->obtener_horarios_ocupados_por_aula($aula, $horarios_ocupados);
                //print_r(gettype($horarios_ocupados_por_aula));
                //$aula no es necesario, quitar mas adelante
                //obtenemos todos los horarios ocupados y disponibles
                $horarios=$this->calcular_espacios_disponibles($aula, $horarios_ocupados_por_aula);
                
                $horarios_depurados=$this->depurar_horarios($horarios, $aula);
                
                //$horarios_disponibles[]=$horarios_depurados;
            }
            
            //return $horarios_disponibles;
        }
        
        /*
         * devuelve los horarios ocupados por aula
         * @$horarios_ocupados contiene todos los horarios ocupados por aula
         */
        function obtener_horarios_ocupados_por_aula ($aula, $horarios_ocupados){
            $fin=FALSE;
            $i=0;
            $longitud=count($horarios_ocupados);
            
            while ($i<$longitud && !$fin){
                $elemento=$horarios_ocupados[$i];
                if(strcmp($elemento[0]['id_aula'], $aula['id_aula']) == 0){
                    $fin=TRUE;
                }
                
                $i += 1;
            }
            
            return $elemento; // indice => Array ( 0 => Array(), 1 => Array() ... )
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
            if((($indice_horario - 1)<$longitud) && $horarios[($indice_horario-1)][1]){
                $hora_fin=$horarios[($indice_horario-1)][0];
            }
            return $indice_horario;
        }
               
        //---- Calculo de horarios disponibles segun hora ---------------------------------------------
        
        /*
         * Esta funcion permite implementar el filtro de la operacion "aulas disponibles". 
         */
        function filtrar_horarios ($hora_inicio, $hora_fin){
            if(isset($hora_inicio) && isset($hora_fin)){
                //hora de inicio y fin no nulas
                //debemos obtener los horarios disponibles que estan incluidos en hora_inicio y hora_fin
                $hora_inicio="$hora_inicio:00";
                $hora_fin="$hora_fin:00";
                $this->obtener_horarios_segun_hora(3,$hora_inicio, $hora_fin);
            }
            else{
                if(isset($hora_inicio) && !isset($hora_fin)){
                    //hora de inicio con valor y hora de fin nula
                    //debemos obtener los horarios disponibles cuya hora_inicio sea mayor o igual a hora_inicio
                    $hora_inicio="$hora_inicio:00";
                    $this->obtener_horarios_segun_hora(1,$hora_inicio,null);
                }
                else{
                    if(!isset($hora_inicio) && isset($hora_fin)){
                        //hora de inicio nula y hora de fin con valor
                        //debemos obtener los horarios disponibles cuya hora_fin sea menor? o igual a la hora_fin
                        $hora_fin="$hora_fin:00";
                        $this->obtener_horarios_segun_hora(2,null,$hora_fin);
                    }
                    else{
                        //hora de inicio y fin nulas, no hay que filtrar horarios
                    }
                }
            }
        }
                
        /*
         * Esta funcion permite filtrar horarios disponibles segun requerimientos de hora
         */
        function obtener_horarios_segun_hora ($req, $hora_inicio=null, $hora_fin=null){
            $horarios_disponibles=array();
            switch($req){
                case 1 : foreach($this->s__horarios_disponibles as $clave=>$horario){
                            if($horario['hora_inicio'] >= $hora_inicio){
                                $horarios_disponibles[]=$horario;
                            }
                         }
                         break;
                         
                case 2 : 
                         foreach($this->s__horarios_disponibles as $clave=>$horario){
                            if($horario['hora_fin'] <= $hora_fin){
                                $horarios_disponibles[]=$horario;
                            }
                         }
                         break;
                         
                case 3 : foreach($this->s__horarios_disponibles as $clave=>$horario){
                            if($this->esta_incluido($horario, $hora_inicio, $hora_fin)){
                                $horarios_disponibles[]=$horario;
                            }
                         }
                         break;
            }
            
            $this->s__horarios_disponibles=$horarios_disponibles;
        }
        
        /*
         * Esta funcion devuelve true si un horario disponible esta incluido en un horario especificado
         * por el usuario
         */
        function esta_incluido ($horario, $hora_inicio, $hora_fin){
            return (($horario['hora_inicio']>=$hora_inicio && $horario['hora_inicio']<=$hora_fin) && ($horario['hora_fin']<=$hora_fin));
        }
        
        /*
         * A partir de una fecha devolvemos el nombre del dia 
         */
        function recuperar_dia ($fecha){
            //si usamos w obtenemos 0 para domingo y 6 para sabado
            //si usamos N obtenemos 1 para lunes y 7 para domingo
            $dia_numerico=date('N', strtotime($fecha));
            
            return (array($this->obtener_dia($dia_numerico)));
        }
        
        /*
         * A partir de una fecha devolvemos el anio 
         */
        function recuperar_anio ($fecha){
            $anio=date('Y', strtotime($fecha));
            
            return $anio;
        }
        

}

?>