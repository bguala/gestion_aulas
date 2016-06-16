
------------------------------------------------------------
-- apex_dimension
------------------------------------------------------------

--- INICIO Grupo de desarrollo 0
INSERT INTO apex_dimension (proyecto, dimension, nombre, descripcion, schema, tabla, col_id, col_desc, col_desc_separador, multitabla_col_tabla, multitabla_id_tabla, fuente_datos_proyecto, fuente_datos) VALUES (
	'gestion_aulas', --proyecto
	'13', --dimension
	'id_sede_admin', --nombre
	'Perfil de datos asociado a cada responsable de aulas.', --descripcion
	NULL, --schema
	'sede', --tabla
	'id_sede', --col_id
	'sigla', --col_desc
	NULL, --col_desc_separador
	NULL, --multitabla_col_tabla
	NULL, --multitabla_id_tabla
	'gestion_aulas', --fuente_datos_proyecto
	'gestion_aulas'  --fuente_datos
);
--- FIN Grupo de desarrollo 0
