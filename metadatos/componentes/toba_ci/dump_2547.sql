------------------------------------------------------------
--[2547]--  Cargar Asignaciones - CI 
------------------------------------------------------------

------------------------------------------------------------
-- apex_objeto
------------------------------------------------------------

--- INICIO Grupo de desarrollo 0
INSERT INTO apex_objeto (proyecto, objeto, anterior, identificador, reflexivo, clase_proyecto, clase, punto_montaje, subclase, subclase_archivo, objeto_categoria_proyecto, objeto_categoria, nombre, titulo, colapsable, descripcion, fuente_datos_proyecto, fuente_datos, solicitud_registrar, solicitud_obj_obs_tipo, solicitud_obj_observacion, parametro_a, parametro_b, parametro_c, parametro_d, parametro_e, parametro_f, usuario, creacion, posicion_botonera) VALUES (
	'gestion_aulas', --proyecto
	'2547', --objeto
	NULL, --anterior
	NULL, --identificador
	NULL, --reflexivo
	'toba', --clase_proyecto
	'toba_ci', --clase
	'19', --punto_montaje
	'ci_cargar_asignaciones', --subclase
	'cargar_asignaciones/ci_cargar_asignaciones.php', --subclase_archivo
	NULL, --objeto_categoria_proyecto
	NULL, --objeto_categoria
	'Cargar Asignaciones - CI', --nombre
	NULL, --titulo
	'0', --colapsable
	NULL, --descripcion
	NULL, --fuente_datos_proyecto
	NULL, --fuente_datos
	NULL, --solicitud_registrar
	NULL, --solicitud_obj_obs_tipo
	NULL, --solicitud_obj_observacion
	NULL, --parametro_a
	NULL, --parametro_b
	NULL, --parametro_c
	NULL, --parametro_d
	NULL, --parametro_e
	NULL, --parametro_f
	NULL, --usuario
	'2015-08-31 10:53:45', --creacion
	'abajo'  --posicion_botonera
);
--- FIN Grupo de desarrollo 0

------------------------------------------------------------
-- apex_objeto_eventos
------------------------------------------------------------

--- INICIO Grupo de desarrollo 0
INSERT INTO apex_objeto_eventos (proyecto, evento_id, objeto, identificador, etiqueta, maneja_datos, sobre_fila, confirmacion, estilo, imagen_recurso_origen, imagen, en_botonera, ayuda, orden, ci_predep, implicito, defecto, display_datos_cargados, grupo, accion, accion_imphtml_debug, accion_vinculo_carpeta, accion_vinculo_item, accion_vinculo_objeto, accion_vinculo_popup, accion_vinculo_popup_param, accion_vinculo_target, accion_vinculo_celda, accion_vinculo_servicio, es_seleccion_multiple, es_autovinculo) VALUES (
	'gestion_aulas', --proyecto
	'1395', --evento_id
	'2547', --objeto
	'volver', --identificador
	'Volver a Inicio', --etiqueta
	'0', --maneja_datos
	NULL, --sobre_fila
	NULL, --confirmacion
	NULL, --estilo
	'apex', --imagen_recurso_origen
	'volver.png', --imagen
	'1', --en_botonera
	NULL, --ayuda
	'1', --orden
	NULL, --ci_predep
	'0', --implicito
	'0', --defecto
	NULL, --display_datos_cargados
	NULL, --grupo
	NULL, --accion
	NULL, --accion_imphtml_debug
	NULL, --accion_vinculo_carpeta
	NULL, --accion_vinculo_item
	NULL, --accion_vinculo_objeto
	NULL, --accion_vinculo_popup
	NULL, --accion_vinculo_popup_param
	NULL, --accion_vinculo_target
	NULL, --accion_vinculo_celda
	NULL, --accion_vinculo_servicio
	'0', --es_seleccion_multiple
	'0'  --es_autovinculo
);
INSERT INTO apex_objeto_eventos (proyecto, evento_id, objeto, identificador, etiqueta, maneja_datos, sobre_fila, confirmacion, estilo, imagen_recurso_origen, imagen, en_botonera, ayuda, orden, ci_predep, implicito, defecto, display_datos_cargados, grupo, accion, accion_imphtml_debug, accion_vinculo_carpeta, accion_vinculo_item, accion_vinculo_objeto, accion_vinculo_popup, accion_vinculo_popup_param, accion_vinculo_target, accion_vinculo_celda, accion_vinculo_servicio, es_seleccion_multiple, es_autovinculo) VALUES (
	'gestion_aulas', --proyecto
	'1658', --evento_id
	'2547', --objeto
	'volver_a_asig', --identificador
	'Volver a Asignación', --etiqueta
	'0', --maneja_datos
	NULL, --sobre_fila
	NULL, --confirmacion
	NULL, --estilo
	'apex', --imagen_recurso_origen
	'volver.png', --imagen
	'1', --en_botonera
	NULL, --ayuda
	'2', --orden
	NULL, --ci_predep
	'0', --implicito
	'0', --defecto
	NULL, --display_datos_cargados
	NULL, --grupo
	NULL, --accion
	NULL, --accion_imphtml_debug
	NULL, --accion_vinculo_carpeta
	NULL, --accion_vinculo_item
	NULL, --accion_vinculo_objeto
	NULL, --accion_vinculo_popup
	NULL, --accion_vinculo_popup_param
	NULL, --accion_vinculo_target
	NULL, --accion_vinculo_celda
	NULL, --accion_vinculo_servicio
	'0', --es_seleccion_multiple
	'0'  --es_autovinculo
);
--- FIN Grupo de desarrollo 0

------------------------------------------------------------
-- apex_objeto_mt_me
------------------------------------------------------------
INSERT INTO apex_objeto_mt_me (objeto_mt_me_proyecto, objeto_mt_me, ev_procesar_etiq, ev_cancelar_etiq, ancho, alto, posicion_botonera, tipo_navegacion, botonera_barra_item, con_toc, incremental, debug_eventos, activacion_procesar, activacion_cancelar, ev_procesar, ev_cancelar, objetos, post_procesar, metodo_despachador, metodo_opciones) VALUES (
	'gestion_aulas', --objeto_mt_me_proyecto
	'2547', --objeto_mt_me
	NULL, --ev_procesar_etiq
	NULL, --ev_cancelar_etiq
	'900px', --ancho
	NULL, --alto
	NULL, --posicion_botonera
	'tab_v', --tipo_navegacion
	'0', --botonera_barra_item
	'0', --con_toc
	NULL, --incremental
	NULL, --debug_eventos
	NULL, --activacion_procesar
	NULL, --activacion_cancelar
	NULL, --ev_procesar
	NULL, --ev_cancelar
	NULL, --objetos
	NULL, --post_procesar
	NULL, --metodo_despachador
	NULL  --metodo_opciones
);

------------------------------------------------------------
-- apex_objeto_dependencias
------------------------------------------------------------

--- INICIO Grupo de desarrollo 0
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'gestion_aulas', --proyecto
	'1612', --dep_id
	'2547', --objeto_consumidor
	'2757', --objeto_proveedor
	'calendario', --identificador
	NULL, --parametros_a
	NULL, --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	NULL  --orden
);
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'gestion_aulas', --proyecto
	'1527', --dep_id
	'2547', --objeto_consumidor
	'2682', --objeto_proveedor
	'cuadro', --identificador
	NULL, --parametros_a
	NULL, --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	NULL  --orden
);
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'gestion_aulas', --proyecto
	'1495', --dep_id
	'2547', --objeto_consumidor
	'2649', --objeto_proveedor
	'cuadro_asignaciones', --identificador
	NULL, --parametros_a
	NULL, --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	NULL  --orden
);
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'gestion_aulas', --proyecto
	'1616', --dep_id
	'2547', --objeto_consumidor
	'2761', --objeto_proveedor
	'cuadro_docentes', --identificador
	NULL, --parametros_a
	NULL, --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	NULL  --orden
);
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'gestion_aulas', --proyecto
	'1614', --dep_id
	'2547', --objeto_consumidor
	'2759', --objeto_proveedor
	'cuadro_fechas', --identificador
	NULL, --parametros_a
	NULL, --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	NULL  --orden
);
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'gestion_aulas', --proyecto
	'1650', --dep_id
	'2547', --objeto_consumidor
	'2779', --objeto_proveedor
	'cuadro_horarios_disponibles', --identificador
	NULL, --parametros_a
	NULL, --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	NULL  --orden
);
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'gestion_aulas', --proyecto
	'1490', --dep_id
	'2547', --objeto_consumidor
	'2644', --objeto_proveedor
	'cuadro_personas', --identificador
	NULL, --parametros_a
	NULL, --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	NULL  --orden
);
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'gestion_aulas', --proyecto
	'1392', --dep_id
	'2547', --objeto_consumidor
	'2544', --objeto_proveedor
	'datos', --identificador
	NULL, --parametros_a
	NULL, --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	NULL  --orden
);
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'gestion_aulas', --proyecto
	'1617', --dep_id
	'2547', --objeto_consumidor
	'2762', --objeto_proveedor
	'docentes_seleccionados', --identificador
	NULL, --parametros_a
	NULL, --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	NULL  --orden
);
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'gestion_aulas', --proyecto
	'1526', --dep_id
	'2547', --objeto_consumidor
	'2681', --objeto_proveedor
	'filtro', --identificador
	NULL, --parametros_a
	NULL, --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	NULL  --orden
);
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'gestion_aulas', --proyecto
	'1618', --dep_id
	'2547', --objeto_consumidor
	'2763', --objeto_proveedor
	'filtro_busqueda', --identificador
	NULL, --parametros_a
	NULL, --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	NULL  --orden
);
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'gestion_aulas', --proyecto
	'1615', --dep_id
	'2547', --objeto_consumidor
	'2760', --objeto_proveedor
	'filtro_docentes', --identificador
	NULL, --parametros_a
	NULL, --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	NULL  --orden
);
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'gestion_aulas', --proyecto
	'1399', --dep_id
	'2547', --objeto_consumidor
	'2552', --objeto_proveedor
	'form_asignacion', --identificador
	NULL, --parametros_a
	NULL, --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	NULL  --orden
);
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'gestion_aulas', --proyecto
	'1398', --dep_id
	'2547', --objeto_consumidor
	'2551', --objeto_proveedor
	'form_datos', --identificador
	NULL, --parametros_a
	NULL, --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	NULL  --orden
);
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'gestion_aulas', --proyecto
	'1619', --dep_id
	'2547', --objeto_consumidor
	'2764', --objeto_proveedor
	'form_fechas', --identificador
	NULL, --parametros_a
	NULL, --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	NULL  --orden
);
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'gestion_aulas', --proyecto
	'1397', --dep_id
	'2547', --objeto_consumidor
	'2550', --objeto_proveedor
	'form_persona', --identificador
	NULL, --parametros_a
	NULL, --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	NULL  --orden
);
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'gestion_aulas', --proyecto
	'1394', --dep_id
	'2547', --objeto_consumidor
	'2546', --objeto_proveedor
	'formulario', --identificador
	NULL, --parametros_a
	NULL, --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	NULL  --orden
);
--- FIN Grupo de desarrollo 0

------------------------------------------------------------
-- apex_objeto_ci_pantalla
------------------------------------------------------------

--- INICIO Grupo de desarrollo 0
INSERT INTO apex_objeto_ci_pantalla (objeto_ci_proyecto, objeto_ci, pantalla, identificador, orden, etiqueta, descripcion, tip, imagen_recurso_origen, imagen, objetos, eventos, subclase, subclase_archivo, template, template_impresion, punto_montaje) VALUES (
	'gestion_aulas', --objeto_ci_proyecto
	'2547', --objeto_ci
	'1262', --pantalla
	'pant_edicion', --identificador
	'1', --orden
	'Inicio', --etiqueta
	NULL, --descripcion
	NULL, --tip
	'apex', --imagen_recurso_origen
	'item.gif', --imagen
	NULL, --objetos
	NULL, --eventos
	NULL, --subclase
	NULL, --subclase_archivo
	'<table>
	<tbody>
		<tr>
			<td>
				[dep id=formulario]</td>
		</tr>
		<tr>
			<td>
				[dep id=filtro]</td>
		</tr>
		<tr>
			<td>
				&nbsp;</td>
		</tr>
		<tr>
			<td>
				[dep id=cuadro]</td>
		</tr>
		<tr>
			<td>
				<hr />
			</td>
		</tr>
		<tr>
			<td>
				[dep id=filtro_busqueda]</td>
		</tr>
		<tr>
			<td>
				&nbsp;</td>
		</tr>
		<tr>
			<td>
				[dep id=cuadro_personas]</td>
		</tr>
		<tr>
			<td>
				&nbsp;</td>
		</tr>
		<tr>
			<td>
				[dep id=form_persona]</td>
		</tr>
	</tbody>
</table>
<p>&nbsp;</p>', --template
	NULL, --template_impresion
	'19'  --punto_montaje
);
INSERT INTO apex_objeto_ci_pantalla (objeto_ci_proyecto, objeto_ci, pantalla, identificador, orden, etiqueta, descripcion, tip, imagen_recurso_origen, imagen, objetos, eventos, subclase, subclase_archivo, template, template_impresion, punto_montaje) VALUES (
	'gestion_aulas', --objeto_ci_proyecto
	'2547', --objeto_ci
	'1263', --pantalla
	'pant_persona', --identificador
	'2', --orden
	'Busqueda', --etiqueta
	NULL, --descripcion
	NULL, --tip
	'apex', --imagen_recurso_origen
	NULL, --imagen
	NULL, --objetos
	NULL, --eventos
	NULL, --subclase
	NULL, --subclase_archivo
	'<table>
	<tbody>
		<tr>
			<td>
				[dep id=filtro_busqueda]</td>
		</tr>
		<tr>
			<td>
				&nbsp;
				<hr />
			</td>
		</tr>
		<tr>
			<td>
				[dep id=form_persona]</td>
		</tr>
		<tr>
			<td>
				[dep id=cuadro_personas]</td>
		</tr>
	</tbody>
</table>
<p>&nbsp;</p>', --template
	NULL, --template_impresion
	'19'  --punto_montaje
);
INSERT INTO apex_objeto_ci_pantalla (objeto_ci_proyecto, objeto_ci, pantalla, identificador, orden, etiqueta, descripcion, tip, imagen_recurso_origen, imagen, objetos, eventos, subclase, subclase_archivo, template, template_impresion, punto_montaje) VALUES (
	'gestion_aulas', --objeto_ci_proyecto
	'2547', --objeto_ci
	'1264', --pantalla
	'pant_asignacion', --identificador
	'3', --orden
	'Asignación', --etiqueta
	NULL, --descripcion
	NULL, --tip
	'apex', --imagen_recurso_origen
	'add.png', --imagen
	NULL, --objetos
	NULL, --eventos
	NULL, --subclase
	NULL, --subclase_archivo
	'<table>
	<tbody>
		<tr>
			<td>
				<fieldset style="border-radius:15px">
					[dep id=form_datos]</fieldset>
			</td>
		</tr>
		<tr>
			<td>
				<fieldset style="border-radius:15px">
					[dep id=cuadro_asignaciones]</fieldset>
			</td>
		</tr>
		<tr>
			<td>
				<fieldset style="border-radius:15px">
					[dep id=form_asignacion]</fieldset>
			</td>
		</tr>
	</tbody>
</table>
<p>&nbsp;</p>', --template
	NULL, --template_impresion
	'19'  --punto_montaje
);
INSERT INTO apex_objeto_ci_pantalla (objeto_ci_proyecto, objeto_ci, pantalla, identificador, orden, etiqueta, descripcion, tip, imagen_recurso_origen, imagen, objetos, eventos, subclase, subclase_archivo, template, template_impresion, punto_montaje) VALUES (
	'gestion_aulas', --objeto_ci_proyecto
	'2547', --objeto_ci
	'1313', --pantalla
	'pant_extra', --identificador
	'4', --orden
	'Calendario', --etiqueta
	NULL, --descripcion
	NULL, --tip
	'apex', --imagen_recurso_origen
	'calendario.gif', --imagen
	NULL, --objetos
	NULL, --eventos
	NULL, --subclase
	NULL, --subclase_archivo
	'<table align="center" border="1">
	<tbody>
		<tr>
			<td align="center" colspan="2">
				[dep id=form_fechas]</td>
		</tr>
		<tr>
			<td style="text-align: center; background-color: rgb(0, 51, 153); color:white; font-weight:bold;">
				Fechas</td>
			<td style="text-align: center; background-color: rgb(0, 51, 153); color:white;font-weight:bold;">
				Horarios Disponibles</td>
		</tr>
		<tr>
			<td>
				[dep id=cuadro_fechas]</td>
			<td style="vertical-align: top;">
				[dep id=cuadro_horarios_disponibles]</td>
		</tr>
		<tr>
			<td>
				[dep id=calendario]</td>
			<td style="vertical-align: top;">
				&nbsp;</td>
		</tr>
	</tbody>
</table>
<p>&nbsp;</p>', --template
	NULL, --template_impresion
	'19'  --punto_montaje
);
INSERT INTO apex_objeto_ci_pantalla (objeto_ci_proyecto, objeto_ci, pantalla, identificador, orden, etiqueta, descripcion, tip, imagen_recurso_origen, imagen, objetos, eventos, subclase, subclase_archivo, template, template_impresion, punto_montaje) VALUES (
	'gestion_aulas', --objeto_ci_proyecto
	'2547', --objeto_ci
	'1314', --pantalla
	'pant_catedra', --identificador
	'5', --orden
	'Cátedra', --etiqueta
	NULL, --descripcion
	NULL, --tip
	'apex', --imagen_recurso_origen
	'add_user_1.png', --imagen
	NULL, --objetos
	NULL, --eventos
	NULL, --subclase
	NULL, --subclase_archivo
	'<table align="center">
	<tbody>
		<tr>
			<td colspan="2" style="text-align: center;">
				[dep id=filtro_docentes]</td>
		</tr>
		<tr>
			<td colspan="2">
				<hr />
			</td>
		</tr>
		<tr>
			<td style="vertical-align: top;">
				[dep id=cuadro_docentes]</td>
			<td style="vertical-align: top;">
				[dep id=docentes_seleccionados]</td>
		</tr>
	</tbody>
</table>
<p>&nbsp;</p>', --template
	NULL, --template_impresion
	'19'  --punto_montaje
);
--- FIN Grupo de desarrollo 0

------------------------------------------------------------
-- apex_objetos_pantalla
------------------------------------------------------------
INSERT INTO apex_objetos_pantalla (proyecto, pantalla, objeto_ci, orden, dep_id) VALUES (
	'gestion_aulas', --proyecto
	'1262', --pantalla
	'2547', --objeto_ci
	'0', --orden
	'1394'  --dep_id
);
INSERT INTO apex_objetos_pantalla (proyecto, pantalla, objeto_ci, orden, dep_id) VALUES (
	'gestion_aulas', --proyecto
	'1262', --pantalla
	'2547', --objeto_ci
	'5', --orden
	'1397'  --dep_id
);
INSERT INTO apex_objetos_pantalla (proyecto, pantalla, objeto_ci, orden, dep_id) VALUES (
	'gestion_aulas', --proyecto
	'1262', --pantalla
	'2547', --objeto_ci
	'4', --orden
	'1490'  --dep_id
);
INSERT INTO apex_objetos_pantalla (proyecto, pantalla, objeto_ci, orden, dep_id) VALUES (
	'gestion_aulas', --proyecto
	'1262', --pantalla
	'2547', --objeto_ci
	'1', --orden
	'1526'  --dep_id
);
INSERT INTO apex_objetos_pantalla (proyecto, pantalla, objeto_ci, orden, dep_id) VALUES (
	'gestion_aulas', --proyecto
	'1262', --pantalla
	'2547', --objeto_ci
	'2', --orden
	'1527'  --dep_id
);
INSERT INTO apex_objetos_pantalla (proyecto, pantalla, objeto_ci, orden, dep_id) VALUES (
	'gestion_aulas', --proyecto
	'1262', --pantalla
	'2547', --objeto_ci
	'3', --orden
	'1618'  --dep_id
);
INSERT INTO apex_objetos_pantalla (proyecto, pantalla, objeto_ci, orden, dep_id) VALUES (
	'gestion_aulas', --proyecto
	'1263', --pantalla
	'2547', --objeto_ci
	'2', --orden
	'1397'  --dep_id
);
INSERT INTO apex_objetos_pantalla (proyecto, pantalla, objeto_ci, orden, dep_id) VALUES (
	'gestion_aulas', --proyecto
	'1263', --pantalla
	'2547', --objeto_ci
	'1', --orden
	'1490'  --dep_id
);
INSERT INTO apex_objetos_pantalla (proyecto, pantalla, objeto_ci, orden, dep_id) VALUES (
	'gestion_aulas', --proyecto
	'1263', --pantalla
	'2547', --objeto_ci
	'0', --orden
	'1618'  --dep_id
);
INSERT INTO apex_objetos_pantalla (proyecto, pantalla, objeto_ci, orden, dep_id) VALUES (
	'gestion_aulas', --proyecto
	'1264', --pantalla
	'2547', --objeto_ci
	'0', --orden
	'1398'  --dep_id
);
INSERT INTO apex_objetos_pantalla (proyecto, pantalla, objeto_ci, orden, dep_id) VALUES (
	'gestion_aulas', --proyecto
	'1264', --pantalla
	'2547', --objeto_ci
	'2', --orden
	'1399'  --dep_id
);
INSERT INTO apex_objetos_pantalla (proyecto, pantalla, objeto_ci, orden, dep_id) VALUES (
	'gestion_aulas', --proyecto
	'1264', --pantalla
	'2547', --objeto_ci
	'1', --orden
	'1495'  --dep_id
);
INSERT INTO apex_objetos_pantalla (proyecto, pantalla, objeto_ci, orden, dep_id) VALUES (
	'gestion_aulas', --proyecto
	'1313', --pantalla
	'2547', --objeto_ci
	'0', --orden
	'1612'  --dep_id
);
INSERT INTO apex_objetos_pantalla (proyecto, pantalla, objeto_ci, orden, dep_id) VALUES (
	'gestion_aulas', --proyecto
	'1313', --pantalla
	'2547', --objeto_ci
	'1', --orden
	'1614'  --dep_id
);
INSERT INTO apex_objetos_pantalla (proyecto, pantalla, objeto_ci, orden, dep_id) VALUES (
	'gestion_aulas', --proyecto
	'1313', --pantalla
	'2547', --objeto_ci
	'2', --orden
	'1619'  --dep_id
);
INSERT INTO apex_objetos_pantalla (proyecto, pantalla, objeto_ci, orden, dep_id) VALUES (
	'gestion_aulas', --proyecto
	'1313', --pantalla
	'2547', --objeto_ci
	'3', --orden
	'1650'  --dep_id
);
INSERT INTO apex_objetos_pantalla (proyecto, pantalla, objeto_ci, orden, dep_id) VALUES (
	'gestion_aulas', --proyecto
	'1314', --pantalla
	'2547', --objeto_ci
	'0', --orden
	'1615'  --dep_id
);
INSERT INTO apex_objetos_pantalla (proyecto, pantalla, objeto_ci, orden, dep_id) VALUES (
	'gestion_aulas', --proyecto
	'1314', --pantalla
	'2547', --objeto_ci
	'1', --orden
	'1616'  --dep_id
);
INSERT INTO apex_objetos_pantalla (proyecto, pantalla, objeto_ci, orden, dep_id) VALUES (
	'gestion_aulas', --proyecto
	'1314', --pantalla
	'2547', --objeto_ci
	'2', --orden
	'1617'  --dep_id
);

------------------------------------------------------------
-- apex_eventos_pantalla
------------------------------------------------------------
INSERT INTO apex_eventos_pantalla (pantalla, objeto_ci, evento_id, proyecto) VALUES (
	'1263', --pantalla
	'2547', --objeto_ci
	'1395', --evento_id
	'gestion_aulas'  --proyecto
);
INSERT INTO apex_eventos_pantalla (pantalla, objeto_ci, evento_id, proyecto) VALUES (
	'1264', --pantalla
	'2547', --objeto_ci
	'1395', --evento_id
	'gestion_aulas'  --proyecto
);
INSERT INTO apex_eventos_pantalla (pantalla, objeto_ci, evento_id, proyecto) VALUES (
	'1313', --pantalla
	'2547', --objeto_ci
	'1658', --evento_id
	'gestion_aulas'  --proyecto
);
INSERT INTO apex_eventos_pantalla (pantalla, objeto_ci, evento_id, proyecto) VALUES (
	'1314', --pantalla
	'2547', --objeto_ci
	'1658', --evento_id
	'gestion_aulas'  --proyecto
);
