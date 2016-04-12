<?php
class form_prueba_extendido extends toba_ei_formulario
{
    function extender_objeto_js() {
          echo "//la funcion actualizar_pantalla se ejecuta cada 30 segundos
                window.setInterval(actualizar_pantalla, 30000);
                
                function actualizar_pantalla (){
                    //alert('Transcurrieron 20 segundos'); 
                    location.reload();
                    
                }"
          ;
    }
}
?>