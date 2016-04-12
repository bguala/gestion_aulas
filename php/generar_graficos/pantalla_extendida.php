<?php
//php_referencia::instancia()->agregar(__FILE__);

class pantalla_extendida extends toba_ei_pantalla
{
    function generar_layout() {
        //esta es la ruta completa del archivo png que queremos imprimir en la pantalla.
        //Es imprescindible especificar la extension del archivo que estamos abriendo, caso contrario dicho
        //archivo no se puede abrir.
//        $ruta="C:/Users/Bruno/Desktop/mosaico_de_japon.png";
//        print_r($ruta);
        
        //abrimos el achivo en modo lectura para transferir su contenido al archivo temporal
//        $fp=  fopen($ruta, 'r');
        
        //obtenemos una ruta a un directorio temporal
//        $img=toba::proyecto()->get_www_temp('mosaico_de_japon.png');
        
        //abrimos el archivo temporal en modo escritura para guardar el contenido de $fp
//        $temp_fp=  fopen($img['path'], 'w');
        //copiamos el contenido de $fp en $temp_fp
//        stream_copy_to_stream($fp, $temp_fp);
        //cerramos $temp_fp y $fp
//        fclose($temp_fp);
//        fclose($fp);
//        print_r($img);
        
        //imprimimos la imagen en la pantalla
//        echo "<img src='{$img['url']}'>";
// ------------------------------------------------------------------------------------------------  
        
        //desactivamos la pantalla pant_edicion
        $this->controlador()->pantalla()->tab('pant_edicion')->desactivar();
        
        //recuperamos el id_aula almacenado en el arreglo $_SESSION
        $id_aula=toba::memoria()->get_dato_operacion(1);
        //print_r("Este es el id_aula en  memoria : ".$id_aula);
        
        //cargarmos el datos tabla aula con un unico registro
        $this->controlador()->dep('datos')->tabla('aula')->cargar(array('id_aula' => $id_aula));
        
        //obtenemos el registro almacenado en el datos tabla, lo que nos interesa es poder utilizar el
        //atributo x_dbr_clave
        $aula=$this->controlador()->dep('datos')->tabla('aula')->get();
        
        //obtenemos el blob almacenado el la bd, usando el atributo x_dbr_clave
        $fp_imagen=$this->controlador()->dep('datos')->tabla('aula')->get_blob('imagen', $aula['x_dbr_clave']);
        
        if(isset($fp_imagen)){
            
            //creamos un nombre temporal para el archivo de imagen que vamos a mostrar por pantalla
            $temp_nombre=  md5(uniqid(time()));
            
            //obtenemos path y url del archivo temporal
            $temp_archivo=toba::proyecto()->get_www_temp($temp_nombre);
            //print_r($temp_archivo);
            
            //abrimos el archivo temporal en modo escritura para guardar el blob que sacamos de la bd
            $fp=  fopen($temp_archivo['path'], 'w');
            //copiamos el contenido del blob almacenado en la bd a nuestro archivo temporal
            stream_copy_to_stream($fp_imagen, $fp);
            //cerramos el archivo temporal
            fclose($fp);
            
            echo "<div style='background-color:#C5C4CB;border:2px solid;margin-bottom:10px;'><p style='font-size:15px'>{$aula['ubicacion']}</p></div>";
            //pegamos la imagen en la pantalla usando la url del archivo temporal
            echo "<div ><img src='{$temp_archivo['url']}' width='750px' height='400px' id=1></div>";
            
            //reseteamos el datos tabla para que el cursor no quede posicionado en el mismo registro.  
            //Si esto ocurre, en la pantalla, vamos a visualizar siempre la misma imagen
            $this->controlador()->dep('datos')->tabla('aula')->resetear();
        }
        
    }
    
    function extender_objeto_js() {
        echo "{$this->objeto_js}.evt__volver = function (){
           //document.getElementById(1).innerHTML='';
           //No existe ningun conflicto al tener implementados los metodos extender_objeto_js y generar_layout
           //en la misma clase
        }";
    }
}

?>