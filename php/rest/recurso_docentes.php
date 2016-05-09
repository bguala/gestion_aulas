<?php

/*
 * Definimos parte de la api para utilizar servicios web. Se supone que esta api debe estar del lado del servidor,  
 * este recibe el pedido y retorna un resultado
 */

    function get ($where){
        $sql="SELECT t_p.nro_doc,
                     t_p.tipo_doc,
                     t_p.nombre,
                     t_p.apellido,
                     t_d.legajo
              FROM persona t_p 
              JOIN docente t_d ON (t_p.nro_doc=t_d.nro_doc AND t_p.tipo_doc=t_d.tipo_doc)
              WHERE $where";

        rest::response()->get(toba::db('gestion_aulas')->consultar($sql));
    }

?>

