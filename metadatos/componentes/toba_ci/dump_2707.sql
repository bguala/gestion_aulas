------------------------------------------------------------
--[2707]--  Calendario Comahue - CI 
------------------------------------------------------------

------------------------------------------------------------
-- apex_objeto
------------------------------------------------------------

--- INICIO Grupo de desarrollo 0
INSERT INTO apex_objeto (proyecto, objeto, anterior, identificador, reflexivo, clase_proyecto, clase, punto_montaje, subclase, subclase_archivo, objeto_categoria_proyecto, objeto_categoria, nombre, titulo, colapsable, descripcion, fuente_datos_proyecto, fuente_datos, solicitud_registrar, solicitud_obj_obs_tipo, solicitud_obj_observacion, parametro_a, parametro_b, parametro_c, parametro_d, parametro_e, parametro_f, usuario, creacion, posicion_botonera) VALUES (
	'gestion_aulas', --proyecto
	'2707', --objeto
	NULL, --anterior
	NULL, --identificador
	NULL, --reflexivo
	'toba', --clase_proyecto
	'toba_ci', --clase
	'19', --punto_montaje
	'ci_calendario_comahue', --subclase
	'calendario_comahue/ci_calendario_comahue.php', --subclase_archivo
	NULL, --objeto_categoria_proyecto
	NULL, --objeto_categoria
	'Calendario Comahue - CI', --nombre
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
	'2015-12-18 18:05:18', --creacion
	'abajo'  --posicion_botonera
);
--- FIN Grupo de desarrollo 0

------------------------------------------------------------
-- apex_objeto_eventos
------------------------------------------------------------

--- INICIO Grupo de desarrollo 0
INSERT INTO apex_objeto_eventos (proyecto, evento_id, objeto, identificador, etiqueta, maneja_datos, sobre_fila, confirmacion, estilo, imagen_recurso_origen, imagen, en_botonera, ayuda, orden, ci_predep, implicito, defecto, display_datos_cargados, grupo, accion, accion_imphtml_debug, accion_vinculo_carpeta, accion_vinculo_item, accion_vinculo_objeto, accion_vinculo_popup, accion_vinculo_popup_param, accion_vinculo_target, accion_vinculo_celda, accion_vinculo_servicio, es_seleccion_multiple, es_autovinculo) VALUES (
	'gestion_aulas', --proyecto
	'1595', --evento_id
	'2707', --objeto
	'volver', --identificador
	'Volver', --etiqueta
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
	'1686', --evento_id
	'2707', --objeto
	'volver_horarios', --identificador
	'Volver', --etiqueta
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
	'2707', --objeto_mt_me
	NULL, --ev_procesar_etiq
	NULL, --ev_cancelar_etiq
	'950px', --ancho
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
	'1554', --dep_id
	'2707', --objeto_consumidor
	'2708', --objeto_proveedor
	'calendario', --identificador
	NULL, --parametros_a
	NULL, --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	NULL  --orden
);
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'gestion_aulas', --proyecto
	'1557', --dep_id
	'2707', --objeto_consumidor
	'2711', --objeto_proveedor
	'cuadro_asignaciones', --identificador
	NULL, --parametros_a
	NULL, --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	NULL  --orden
);
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'gestion_aulas', --proyecto
	'1622', --dep_id
	'2707', --objeto_consumidor
	'2765', --objeto_proveedor
	'cuadro_asignaciones_periodo', --identificador
	NULL, --parametros_a
	NULL, --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	NULL  --orden
);
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'gestion_aulas', --proyecto
	'1556', --dep_id
	'2707', --objeto_consumidor
	'2710', --objeto_proveedor
	'cuadro_horarios_disponibles', --identificador
	NULL, --parametros_a
	NULL, --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	NULL  --orden
);
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'gestion_aulas', --proyecto
	'1551', --dep_id
	'2707', --objeto_consumidor
	'2704', --objeto_proveedor
	'datos', --identificador
	NULL, --parametros_a
	NULL, --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	NULL  --orden
);
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'gestion_aulas', --proyecto
	'1559', --dep_id
	'2707', --objeto_consumidor
	'2712', --objeto_proveedor
	'filtro', --identificador
	NULL, --parametros_a
	NULL, --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	NULL  --orden
);
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'gestion_aulas', --proyecto
	'1555', --dep_id
	'2707', --objeto_consumidor
	'2709', --objeto_proveedor
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
	'2707', --objeto_ci
	'1302', --pantalla
	'pant_edicion', --identificador
	'1', --orden
	'Inicio', --etiqueta
	NULL, --descripcion
	NULL, --tip
	'apex', --imagen_recurso_origen
	'calendario.gif', --imagen
	NULL, --objetos
	NULL, --eventos
	NULL, --subclase
	NULL, --subclase_archivo
	NULL, --template
	NULL, --template_impresion
	NULL  --punto_montaje
);
INSERT INTO apex_objeto_ci_pantalla (objeto_ci_proyecto, objeto_ci, pantalla, identificador, orden, etiqueta, descripcion, tip, imagen_recurso_origen, imagen, objetos, eventos, subclase, subclase_archivo, template, template_impresion, punto_montaje) VALUES (
	'gestion_aulas', --objeto_ci_proyecto
	'2707', --objeto_ci
	'1303', --pantalla
	'pant_horarios', --identificador
	'2', --orden
	'Horarios', --etiqueta
	NULL, --descripcion
	NULL, --tip
	'apex', --imagen_recurso_origen
	'historia.png', --imagen
	NULL, --objetos
	NULL, --eventos
	NULL, --subclase
	NULL, --subclase_archivo
	'<table>
	<tbody>
		<tr>
			<td colspan="2">
				[dep id=formulario]</td>
		</tr>
		<tr>
			<td colspan="2">
				[dep id=filtro]</td>
		</tr>
		<tr>
			<td colspan="2">
				[dep id=cuadro_horarios_disponibles]</td>
		</tr>
		<tr>
			<td>
				[dep id=cuadro_asignaciones]</td>
		</tr>
	</tbody>
</table>
<p>&nbsp;</p>', --template
	NULL, --template_impresion
	'19'  --punto_montaje
);
INSERT INTO apex_objeto_ci_pantalla (objeto_ci_proyecto, objeto_ci, pantalla, identificador, orden, etiqueta, descripcion, tip, imagen_recurso_origen, imagen, objetos, eventos, subclase, subclase_archivo, template, template_impresion, punto_montaje) VALUES (
	'gestion_aulas', --objeto_ci_proyecto
	'2707', --objeto_ci
	'1317', --pantalla
	'pant_periodo', --identificador
	'3', --orden
	'Asignación', --etiqueta
	NULL, --descripcion
	NULL, --tip
	'apex', --imagen_recurso_origen
	'nota.gif', --imagen
	NULL, --objetos
	NULL, --eventos
	NULL, --subclase
	NULL, --subclase_archivo
	NULL, --template
	NULL, --template_impresion
	'19'  --punto_montaje
);
--- FIN Grupo de desarrollo 0

------------------------------------------------------------
-- apex_objetos_pantalla
------------------------------------------------------------
INSERT INTO apex_objetos_pantalla (proyecto, pantalla, objeto_ci, orden, dep_id) VALUES (
	'gestion_aulas', --proyecto
	'1302', --pantalla
	'2707', --objeto_ci
	'0', --orden
	'1554'  --dep_id
);
INSERT INTO apex_objetos_pantalla (proyecto, pantalla, objeto_ci, orden, dep_id) VALUES (
	'gestion_aulas', --proyecto
	'1303', --pantalla
	'2707', --objeto_ci
	'0', --orden
	'1555'  --dep_id
);
INSERT INTO apex_objetos_pantalla (proyecto, pantalla, objeto_ci, orden, dep_id) VALUES (
	'gestion_aulas', --proyecto
	'1303', --pantalla
	'2707', --objeto_ci
	'2', --orden
	'1556'  --dep_id
);
INSERT INTO apex_objetos_pantalla (proyecto, pantalla, objeto_ci, orden, dep_id) VALUES (
	'gestion_aulas', --proyecto
	'1303', --pantalla
	'2707', --objeto_ci
	'3', --orden
	'1557'  --dep_id
);
INSERT INTO apex_objetos_pantalla (proyecto, pantalla, objeto_ci, orden, dep_id) VALUES (
	'gestion_aulas', --proyecto
	'1303', --pantalla
	'2707', --objeto_ci
	'1', --orden
	'1559'  --dep_id
);
INSERT INTO apex_objetos_pantalla (proyecto, pantalla, objeto_ci, orden, dep_id) VALUES (
	'gestion_aulas', --proyecto
	'1317', --pantalla
	'2707', --objeto_ci
	'0', --orden
	'1622'  --dep_id
);

------------------------------------------------------------
-- apex_eventos_pantalla
------------------------------------------------------------
INSERT INTO apex_eventos_pantalla (pantalla, objeto_ci, evento_id, proyecto) VALUES (
	'1303', --pantalla
	'2707', --objeto_ci
	'1595', --evento_id
	'gestion_aulas'  --proyecto
);
INSERT INTO apex_eventos_pantalla (pantalla, objeto_ci, evento_id, proyecto) VALUES (
	'1317', --pantalla
	'2707', --objeto_ci
	'1686', --evento_id
	'gestion_aulas'  --proyecto
);
