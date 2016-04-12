<?php

require_once(toba_dir().'/php/3ros/phpmailer/class.phpmailer.php');
require_once(toba_dir().'/php/3ros/phpmailer/class.smtp.php');

class ci_reportar_incidencia extends toba_ci
{
    
        protected $s__de;
            
    	//---- Cuadro -----------------------------------------------------------------------

	function conf__cuadro(toba_ei_cuadro $cuadro)
	{
		$cuadro->set_datos($this->dep('datos')->tabla('asignacion')->get_listado());
	}

	function evt__cuadro__seleccion($datos)
	{
		$this->dep('datos')->cargar($datos);
	}

	//---- Formulario -------------------------------------------------------------------

	function conf__formulario(toba_ei_formulario $form)
	{
            if(!isset($this->s__de)){
//                $nombre_usuario=toba::usuario()->get_id();
//                $sql="SELECT t_p.correo_electronico as correo
//                      FROM persona t_p 
//                      JOIN administrador t_a ON (t_p.nro_doc=t_a.nro_doc AND t_p.tipo_doc=t_a.tipo_doc)
//                      WHERE t_a.nombre_usuario=$nombre_usuario";
//                $datos_admin=toba::db('gestion_aulas')->consultar($sql);
//                $this->s__de=$datos_admin['correo'];
                $this->s__de='sed.uncoma@gmail.com';
                
            }
            
            $form->ef('de')->set_estado_defecto($this->s__de);
                        
	}

	function evt__formulario__enviar($datos)
	{
            $this->enviar_email($datos);
	}
        
        function enviar_email ($datos){
            
            $email=new PHPMailer();
            $email->IsSMTP(); //utilizamos el protocolo smtp para el envio de correo electronico, tambien podemos usar html
            $email->SMTPAuth='true';
            $email->SMTPSecure='ssl'; //especificamos un protocolo de seguridad para encriptar los datos enviados
            $email->Host='smtp.gmail.com'; //especificamos en servidor de correo electronico
            $email->Port=465; //especificamos el puerto de la aplicacion
            
            $email->Username='sed.uncoma@gmail.com';
            //$email->Password=$datos['pass'];
            $email->Password='n1s.toba15';
            $email->Timeout=100;
            
            $email->SetFrom('sed.uncoma@gmail.com'); // de
            
//            $nombre_archivo=$datos['archivo_adjunto']['name'];
//            $path=toba::proyecto()->get_www_temp($nombre_archivo);
//            print_r("<br><br>RUTA : {$path['path']} <br><br>");
            //print_r($datos);exit();
            try{
                $email->Subject=$datos['asunto'];
                $email->Body=$datos['descripcion'];
                //$email->AddAddress($this->s__para);
                $email->AddAddress('sed.uncoma@gmail.com'); // para
                //print_r($datos);exit();
                if(strcmp($datos['archivo_adjunto']['name'], '') != 0){
                    $email->AddAttachment($datos['archivo_adjunto']['tmp_name'],$datos['archivo_adjunto']['name']);
                }
                
                $mensaje=" El email no pudo enviarse. ";
                $info="error";
                if($email->Send()){
                    $mensaje=utf8_decode(" El email se envió correctamente. ");
                    $info="info";
                }
                
                toba::notificacion()->agregar($mensaje, $info);
                
            } catch (phpmailerException $ex) {
                print_r($ex);   
            }
            
        }


}

?>