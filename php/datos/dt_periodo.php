<?php
class dt_periodo extends toba_datos_tabla
{
        /*
         * Esta funcion se utiliza en la operacion Registrar Periodo, para actualizar un cuadro que muestra 
         * todos los periodos academicos registrados en el sistema.
         */
	function get_listado($anio_lectivo)
	{
		$sql_1 = "(SELECT t_p.id_periodo,
                               t_p.fecha_inicio,
                               t_p.fecha_fin,
			       t_p.anio_lectivo,
                               t_c.numero,
                               '----' as turno,
                               'Cuatrimestre' as tipo_periodo
                        FROM   periodo as t_p
                        JOIN cuatrimestre t_c ON (t_p.id_periodo=t_c.id_periodo AND t_p.anio_lectivo=$anio_lectivo))
                        
                   ";
                
                $cuatrimestre=toba::db('gestion_aulas')->consultar($sql_1);
                
                $sql_2="                       
                        (SELECT t_p.id_periodo,
                                t_p.fecha_inicio,
                                t_p.fecha_fin,
                                t_p.anio_lectivo,
                                t_ef.turno,
                                t_ef.numero,
                                'Examen Final' as tipo_periodo
                         FROM periodo t_p 
                         JOIN examen_final t_ef ON (t_p.id_periodo=t_ef.id_periodo AND t_p.anio_lectivo=$anio_lectivo))";
                
                $examen_final=toba::db('gestion_aulas')->consultar($sql_2);
                
                $sql_3="(SELECT t_p.id_periodo,
                                 t_p.fecha_inicio,
                                 t_p.fecha_fin,
                                 t_p.anio_lectivo,
                                 'Curso de Ingreso' as tipo_periodo,
                                 '----' as numero,
                                 t_ci.facultad as turno
                         FROM periodo t_p 
                         JOIN curso_ingreso t_ci ON (t_p.id_periodo=t_ci.id_periodo AND t_p.anio_lectivo=$anio_lectivo)
                         )";
                
                $curso_ingreso=toba::db('gestion_aulas')->consultar($sql_3);
                
                $this->unificar_periodos(&$cuatrimestre, $examen_final);
                
                $this->unificar_periodos(&$cuatrimestre, $curso_ingreso);
                
                return $cuatrimestre;
                
        }
        
        /*
         * Esta funcion realiza una union de conjuntos
         */
        function unificar_periodos ($periodo, $conjunto){
            foreach ($conjunto as $clave=>$valor){
                if(isset($valor)){
                   $periodo[]=$valor; //agrega al final
                }
            }            
        }
        
        /*
         * Esta funcion se utiliza en la operacion Registrar Periodo, para cargar un formulario con los datos
         * de un periodo seleccionado.
         */
        function get_periodo ($id_periodo){
            $sql_c="(SELECT *, 'Cuatrimestre' as tipo_periodo 
                  FROM periodo t_p
                  JOIN cuatrimestre t_c ON (t_p.id_periodo=t_c.id_periodo AND t_c.id_periodo=$id_periodo))"; 
            $cuatrimestre=toba::db('gestion_aulas')->consultar($sql_c);          
            
            $sql_e="(SELECT *, 'Examen Final' as tipo_periodo
                  FROM periodo as t_p
                  JOIN examen_final as t_ef ON (t_p.id_periodo=t_ef.id_periodo AND t_ef.id_periodo=$id_periodo))";
            $examen_final=toba::db('gestion_aulas')->consultar($sql_e);
                   
            $sql_ci="(SELECT *, 'Curso de Ingreso' as tipo_periodo
                  FROM periodo as t_p
                  JOIN curso_ingreso t_ci ON (t_p.id_periodo=t_ci.id_periodo AND t_ci.id_periodo=$id_periodo))";
            $curso_ingreso=toba::db('gestion_aulas')->consultar($sql_ci);      
                        
            if(count($cuatrimestre)>0){
                return $cuatrimestre;
            }
            else{
                if(count($examen_final)>0){
                    return $examen_final;
                }
                else{
                    return $curso_ingreso;
                }
            }
            
        }
        
        /*
         * Esta funcion se utiliza en la operacion Cargar Asignaciones, para llenar el combo periodo.
         * @fecha : contiene una fecha para filtrar periodos. 
         */
        function get_periodos_activos (){
            
            $fecha=date('Y-m-d');
            $anio_lectivo=date('Y');
            
            $sql_1="SELECT t_p.id_periodo,
                           t_c.numero || ' ' || 'CUATRIMESTRE' as descripcion 
                    FROM periodo t_p 
                    JOIN cuatrimestre t_c ON (t_p.id_periodo=t_c.id_periodo AND t_p.anio_lectivo=$anio_lectivo
                         AND (('$fecha' <= t_p.fecha_inicio) OR ('$fecha' BETWEEN t_p.fecha_inicio AND t_p.fecha_fin)))";
            $cuatrimestre=toba::db('gestion_aulas')->consultar($sql_1);
            
            $sql_2="SELECT t_p.id_periodo,
                           'TURNO DE EXAMEN' || ' ' || t_ef.turno || ' ' || t_ef.numero || ' ' || 'LLAMADO' as descripcion
                    FROM periodo t_p 
                    JOIN examen_final t_ef ON (t_p.id_periodo=t_ef.id_periodo AND t_p.anio_lectivo=$anio_lectivo
                         AND (('$fecha' <= t_p.fecha_inicio) OR ('$fecha' BETWEEN t_p.fecha_inicio AND t_p.fecha_fin)))";
            $examen_final=toba::db('gestion_aulas')->consultar($sql_2);
            
            $sql_3="SELECT t_p.id_periodo,
                           'CURSO DE INGRESO' || ' ' || t_ci.facultad || ' ' || t_ci.nombre as descripcion
                    FROM periodo t_p 
                    JOIN curso_ingreso t_ci ON (t_p.id_periodo=t_ci.id_periodo AND t_p.anio_lectivo=$anio_lectivo
                         AND (('$fecha' <= t_p.fecha_inicio) OR ('$fecha' BETWEEN t_p.fecha_inicio AND t_p.fecha_fin)) )";
            $curso_ingreso=toba::db('gestion_aulas')->consultar($sql_3);
            
            $this->unificar_periodos(&$cuatrimestre, $examen_final);
            
            $this->unificar_periodos(&$cuatrimestre, $curso_ingreso);
            
            return $cuatrimestre;            
            
        }
        
        /*
         * Esta funcion se utiliza en las operaciones que requieren calcular espacios disponibles
         * (Calendario Comahue, Generar Solicitud, Ver Solicitudes). Nos permite 
         * obtener periodos para comenzar el calculo de horarios disponibles.
         */
        function get_periodo_calendario ($fecha, $anio_lectivo){
            $sql="(SELECT t_p.id_periodo, 'Cuatrimestre' as tipo_periodo 
                  FROM periodo t_p 
                  JOIN cuatrimestre t_c ON (t_p.id_periodo=t_c.id_periodo)
                  WHERE (t_p.anio_lectivo=$anio_lectivo) AND 
                        ('$fecha' BETWEEN t_p.fecha_inicio AND t_p.fecha_fin)) 
                  
                  UNION 
                  
                  (SELECT t_p.id_periodo, 'Examen Final' as tipo_periodo
                  FROM periodo t_p 
                  JOIN examen_final t_ef ON (t_p.id_periodo=t_ef.id_periodo)
                  WHERE (t_p.anio_lectivo=$anio_lectivo) AND 
                        ('$fecha' BETWEEN t_p.fecha_inicio AND t_p.fecha_fin))";
            
            return (toba::db('gestion_aulas')->consultar($sql));
        }
        
        /*
         * Esta funcion se utiliza en la operacion Asignaciones por Dia.
         */
        function get_id_periodo ($cuatrimestre, $anio_lectivo){
            $sql="SELECT t_p.id_periodo
                  FROM periodo t_p 
                  JOIN cuatrimestre t_c ON (t_p.id_periodo=t_c.id_periodo)
                  WHERE t_c.numero=$cuatrimestre AND t_p.anio_lectivo=$anio_lectivo ";
            
            $periodo=toba::db('gestion_aulas')->consultar($sql);
            
            return ($periodo[0]);
        }

}

?>