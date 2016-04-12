<?php
class formulario_extendido extends toba_ei_formulario
{
    function extender_objeto_js() {
        echo "{$this->objeto_js}.evt__apellido__validar = function (){
            var apellido=this.ef('apellido').get_estado();
            var nombre=this.ef('nombre').get_estado();
            
            var parametros=[ nombre, apellido ];
            
            this.controlador.ajax('crear_nombre_usuario', parametros, this, this.atender_respuesta);
            
            return true;
        } 
        
        {$this->objeto_js}.evt__nro_doc__validar = function (){
            var pw=this.ef('nro_doc').get_estado();
            this.ef('contrasenia').set_estado(pw);
            return true;
        }
                
        {$this->objeto_js}.atender_respuesta = function (respuesta){
            var nombre_usuario=respuesta['user'];
            this.ef('nombre_usuario').set_estado(nombre_usuario);
            return true;
        }";
    }
}
?>