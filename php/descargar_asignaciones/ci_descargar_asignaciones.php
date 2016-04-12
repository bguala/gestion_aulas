<?php
class ci_descargar_asignaciones extends toba_ci
{
    
        protected $s__asignaciones;
        protected $s__id_sede;


        //---- Cuadro -----------------------------------------------------------------------

	function conf__cuadro(toba_ei_cuadro $cuadro)
	{
            if(isset($this->s__asignaciones)){
                $cuadro->descolapsar();
                $cuadro->set_datos($this->s__asignaciones);
            }
            else{
                $cuadro->colapsar();
            }
	}

	function evt__cuadro__descargar_archivo($datos)
	{
            print_r($datos);exit();
	}

	//---- Formulario -------------------------------------------------------------------

	function conf__formulario(toba_ei_formulario $form)
	{
//            $nombre_usuario=toba::usuario()->get_id();
//            $sql="SELECT id_sede
//                  FROM administrador 
//                  WHERE nombre_usuario='$nombre_usuario'";
//            $id_sede=toba::db('gestion_aulas')->consultar($sql);
//            $this->s__id_sede=$id_sede[0]['id_sede'];
            $this->s__id_sede=1;
	}

	function evt__formulario__asignaciones ($datos)
	{
            print_r($datos);
            $this->s__asignaciones=$this->dep('datos')->tabla('asignacion')->get_asignaciones_por_cuatrimestre($datos['cuatrimestre'], $datos['anio'], $this->s__id_sede);
//            if($this->validar_datos_usuario()){
//                
//            }
//            else{
//                $mensaje="No existen asignaciones cargadas en el sistema para el año y cuatrimestre actual";
//                toba::notificacion()->agregar(utf8_decode($mensaje), 'error');
//            }
	}

	        
        function vista_pdf (toba_vista_pdf $salida){
            //obtebemos un objeto Cezpdf
            $pdf=$salida->get_pdf();
            
            //configuramos los margenes de las paginas que componen al pdf (top, bottom, left, right)
            $pdf->ezSetMargins(10, 10, 10, 10);
            
            //agregamos el encabezado al documento
            $this->configurar_encabezado($pdf);
                      
            $horarios_agrupados=$this->configurar_datos();
            
            $this->agregar_tablas($pdf, $horarios_agrupados);
            
        }
        
        /*
         * Esta funcion agrega el cuerpo del archivo pdf.
         */
        function agregar_tablas (Cezpdf $pdf, $horarios_agrupados){
            //definimos la cantidad de columnas que posee la tabla
            //print_r($horarios_agrupados);exit();           
            foreach ($horarios_agrupados as $dia=>$asignacion){
                $texto="\n$dia\n";
                $pdf->ezText(utf8_d_seguro($texto), 8, array('justification'=>'center'));
                $this->agregar_tabla_con_cortes($pdf, $asignacion);
            }
        }
        
        /*
         * Esta funcion agrega el aula y una tabla con los horarios ocupados en la misma.
         * @$pdf es un objeto Cezpdf.
         * @$asignaciones aula=>(asignaciones)
         */
        function agregar_tabla_con_cortes (Cezpdf $pdf, $asignaciones){
            //definimos las columnas de la tabla
            $columnas=array(
                'materia' => 'Materia',
                'hora_inicio' => 'Hora de Inicio',
                'hora_fin' => 'Hora de Fin',
                'confirmacion' => utf8_d_seguro('Confirmación?'),
                'materia_2' => 'Materia',
                'hora_inicio_2' => 'Hora de Inicio',
                'hora_fin_2' => 'Hora de Fin',
            );
            
            //definimos el formato de las tablas 
            $opciones=array(
                'splitRows' => 0,
                'rowGraph' => 0,
                'showHeadings' => true,
                'titleFontSize' => 6,
                'fontSize' => 5, //definimos el tamanio de fuente
                'shadeCol' => array(0.9,0.9,0.9),//especificamos el color de cada fila
                'xOrientation' => 'center',
                'width' => 500,
                'xPos' => 'center',
                'yPos' => 'center',
                
            );
            
            $justificacion=array('justification'=>'left');
            foreach ($asignaciones as $aula=>$asignacion){
                //print_r($aula);print_r($asignacion);exit();
                $texto="Aula : $aula\n";
                $pdf->ezText(utf8_d_seguro($texto), 8, $justificacion);
                $pdf->ezTable(utf8_d_seguro($asignacion), $columnas, "", $opciones);
            }
        }
        
        /*
         * Esta funcion crea el encabezado del documento.
         * @$pdf es un objeto de tipo Cezpdf.
         */
        function configurar_encabezado (Cezpdf $pdf){
            
            $guiones_inicio=$this->generar_precontenido(215,"-");
            //agregamos la primer hilera de guiones
            $pdf->ezText($guiones_inicio, 8, array('justification'=>'left'));
            $pdf->ezText("Asignaciones", 8, array('justification'=>'center'));
            
            //obtenemos una cadena formada por espacios en blanco
            $espacios_en_blanco=$this->generar_precontenido(210, " ");
            
            $cadena="Año : 2014".$espacios_en_blanco."Cuatrimestre : 1";
            
            $pdf->ezText(utf8_d_seguro($cadena), 8, array('justification'=>'left'));
            
            $guiones_fin=$this->generar_precontenido(215, "-");
            
            $pdf->ezText($guiones_fin);          
            
        }
        
        /*
         * Esta funcion genera una cadena con eltos separadores.
         * @$longitud contiene la cantidad de eltos separadores que forman la cadena de retorno.
         * @separador para este caso puede ser un guion (-) o un caracter en blanco (" ")  
         */
        function generar_precontenido ($longitud, $separador){
            $i=0;
            $cadena="";           
            while($i < $longitud){
                $cadena .= $separador;
                $i += 1;
            }
            
            return $cadena;
        }
        
        /*
         * Esta funcion crea un arreglo con la estructura adecuada para incluirlo en un documento pdf.
         * Esa estructura es (dia => aulas (asignaciones))
         */
        function configurar_datos (){
            $horarios=array();
            
            $dias=array(
                1 => 'Lunes',
                2 => 'Martes',
                3 => 'Miércoles',
                4 => 'Jueves',
                5 => 'Viernes'
            );
            
            $aulas=$this->dep('datos')->tabla('aula')->get_aulas($this->s__id_sede);
            
            foreach($dias as $dia){
                $horarios[$dia]=$this->agrupar_horarios_por_aula_y_dia($dia, $aulas);
            }
            
            return $horarios;
        }
        
        /*
         * Esta funcion devuelve todos los horarios ocupados en cada aula de una Unidad Academica.
         * @$dia contiene un dia habil de la semana.
         * @$aulas contiene todas las aulas de una Unidad Academica.
         */
        function agrupar_horarios_por_aula_y_dia ($dia, $aulas){
            $horarios_agrupados=array();
            foreach($aulas as $aula){
                $horarios_agrupados[($aula['aula'])]=$this->obtener_horarios_por_aula($aula, $dia);
            }
            
            return $horarios_agrupados;
        }
        
        /*
         * Esta funcion devuelve todos los horarios ocupados en un aula.
         */
        function obtener_horarios_por_aula ($aula, $dia){
            $horarios=array();
            foreach ($this->s__asignaciones as $clave=>$asignacion){
                if(($asignacion['id_aula'] == $aula['id_aula']) && (strcmp($asignacion['dia'], $dia) == 0)){
                    //aca se podria crear un arreglo el siguiente formato (materia,hora_inicio,hora_fin)
                    $horarios[]=$asignacion;
                }
            }
            
            return $horarios;
        }   

}

?>