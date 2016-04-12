<?php
class formulario_extendido extends toba_ei_formulario
{
    function extender_objeto_js() {
        
//        {$this->objeto_js}.evt__tipo__validar = function () {
//            var tipo=this.ef('tipo').get_estado().toString();
//            switch (tipo){
//            
//            case 'Denuncia de aula' :    //alert('LLega');
//                                         this.ef('descripcion').mostrar();
//                                         this.ef('fecha').ocultar();
//                                         this.ef('id_aula').mostrar();
//                
//                                         this.ef('fijo3').mostrar();
//                                         this.ef('den1').mostrar();
//                                         this.ef('den2').mostrar();
//                                         this.ef('den3').mostrar();
//                                         this.ef('den4').mostrar();
//                                         break;
//                                         
//            case 'Solicitud de aula' :   this.ef('descripcion').input().value='';
//                                         this.ef('descripcion').ocultar();
//                                         this.ef('fijo3').ocultar();
//                
//                                         this.ef('den1').input().checked=false;
//                                         this.ef('den1').ocultar();
//                
//                                         this.ef('den2').input().checked=false;
//                                         this.ef('den2').ocultar();
//                
//                                         this.ef('den3').input().checked=false;
//                                         this.ef('den3').ocultar();
//                
//                                         this.ef('den4').input().checked=false;
//                                         this.ef('den4').ocultar();
//                
//                                         this.ef('id_aula').ocultar();
//                                         this.ef('fecha').mostrar();
//                                         break;
//                                         
//            case 'nopar' :               this.ef('descripcion').input().value='';
//                                         this.ef('descripcion').ocultar();
//                                         this.ef('fijo3').ocultar();
//                
//                                         this.ef('den1').input().checked=false;
//                                         this.ef('den1').ocultar();
//                
//                                         this.ef('den2').input().checked=false;
//                                         this.ef('den2').ocultar();
//                
//                                         this.ef('den3').input().checked=false;
//                                         this.ef('den3').ocultar();
//                
//                                         this.ef('den4').input().checked=false;
//                                         this.ef('den4').ocultar();
//                
//                                         this.ef('id_aula').ocultar();
//                                         break;
//            
//            }
//            return true;
//        }
        
        echo "       
        {$this->objeto_js}.evt__legajo__validar = function () {
                this.controlador.ajax_cadenas('autocompletar_form', this.ef('legajo').get_estado(), this, this.atender_respuesta);
                return true;
        }
        
        {$this->objeto_js}.atender_respuesta = function (respuesta) {
                
                var accion = respuesta.get_cadena('accion');
                
                if(accion == 'y'){
                    var nombre = respuesta.get_cadena('nombre');
                    var apellido = respuesta.get_cadena('apellido');
            
                    this.ef('nombre').set_estado(nombre);
                    this.ef('apellido').set_estado(apellido);
                        
                    return false;
                }
                else{
                    alert('El legajo ingresado no pertenece a un docente registrado en el sistema');
                    this.ef('legajo').set_estado('');
                    this.ef('nombre').set_estado('');
                    this.ef('apellido').set_estado('');
                    
                    return false;
                }
                
        }
        ";
    }
    
    
}
?>