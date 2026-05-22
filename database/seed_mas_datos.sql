USE bd_fundicion;

INSERT INTO combustible (com_id, com_descripcion, com_estado)
SELECT 92, 'GLP Industrial', 'Activo'
WHERE NOT EXISTS (SELECT 1 FROM combustible WHERE com_id = 92);

INSERT INTO combustible (com_id, com_descripcion, com_estado)
SELECT 93, 'Coque Metalurgico', 'Activo'
WHERE NOT EXISTS (SELECT 1 FROM combustible WHERE com_id = 93);

INSERT INTO combustible (com_id, com_descripcion, com_estado)
SELECT 94, 'Diesel Premium', 'Activo'
WHERE NOT EXISTS (SELECT 1 FROM combustible WHERE com_id = 94);

INSERT INTO combustible (com_id, com_descripcion, com_estado)
SELECT 95, 'Gas Propano', 'Activo'
WHERE NOT EXISTS (SELECT 1 FROM combustible WHERE com_id = 95);

INSERT INTO tipo_metal (tmetal_id, tmetal_descripcion, tmetal_estado)
SELECT 92, 'Hierro Gris', 'Activo'
WHERE NOT EXISTS (SELECT 1 FROM tipo_metal WHERE tmetal_id = 92);

INSERT INTO tipo_metal (tmetal_id, tmetal_descripcion, tmetal_estado)
SELECT 93, 'Bronce Industrial', 'Activo'
WHERE NOT EXISTS (SELECT 1 FROM tipo_metal WHERE tmetal_id = 93);

INSERT INTO tipo_metal (tmetal_id, tmetal_descripcion, tmetal_estado)
SELECT 94, 'Aluminio Reciclado', 'Activo'
WHERE NOT EXISTS (SELECT 1 FROM tipo_metal WHERE tmetal_id = 94);

INSERT INTO bodega (bod_id, bod_descripcion, bod_capacidad, bod_area, bod_estado)
SELECT 92, 'Bodega Metales Ferrosos', '1500 kg', '320 m2', 'Activo'
WHERE NOT EXISTS (SELECT 1 FROM bodega WHERE bod_id = 92);

INSERT INTO bodega (bod_id, bod_descripcion, bod_capacidad, bod_area, bod_estado)
SELECT 93, 'Bodega Aleaciones', '1200 kg', '280 m2', 'Activo'
WHERE NOT EXISTS (SELECT 1 FROM bodega WHERE bod_id = 93);

INSERT INTO bodega (bod_id, bod_descripcion, bod_capacidad, bod_area, bod_estado)
SELECT 94, 'Bodega Producto Terminado Norte', '2000 kg', '410 m2', 'Activo'
WHERE NOT EXISTS (SELECT 1 FROM bodega WHERE bod_id = 94);

INSERT INTO horno (hor_id, hor_descripcion, com_id, hor_estado)
SELECT 92, 'Horno Basculante 1', 92, 'Activo'
WHERE NOT EXISTS (SELECT 1 FROM horno WHERE hor_id = 92);

INSERT INTO horno (hor_id, hor_descripcion, com_id, hor_estado)
SELECT 93, 'Horno Crisol 2', 93, 'Activo'
WHERE NOT EXISTS (SELECT 1 FROM horno WHERE hor_id = 93);

INSERT INTO horno (hor_id, hor_descripcion, com_id, hor_estado)
SELECT 94, 'Horno Rotativo 3', 94, 'Activo'
WHERE NOT EXISTS (SELECT 1 FROM horno WHERE hor_id = 94);

INSERT INTO horno (hor_id, hor_descripcion, com_id, hor_estado)
SELECT 95, 'Horno Continuo 4', 95, 'Activo'
WHERE NOT EXISTS (SELECT 1 FROM horno WHERE hor_id = 95);

INSERT INTO cliente (cli_nit, cli_razon_social, cli_dir, cli_tel, cli_correo, cli_nombre_contacto, cli_estado, Cli_usu_crea)
SELECT '900100002', 'Metalurgica Andina SAS', 'Calle 45 # 12-30', '3105550101', 'compras@andina.com', 'Laura Moreno', 'Activo', 'admin'
WHERE NOT EXISTS (SELECT 1 FROM cliente WHERE cli_nit = '900100002');

INSERT INTO cliente (cli_nit, cli_razon_social, cli_dir, cli_tel, cli_correo, cli_nombre_contacto, cli_estado, Cli_usu_crea)
SELECT '900100003', 'Fundidos del Caribe SAS', 'Cra 18 # 70-15', '3105550102', 'logistica@caribe.com', 'Andres Pineda', 'Activo', 'admin'
WHERE NOT EXISTS (SELECT 1 FROM cliente WHERE cli_nit = '900100003');

INSERT INTO cliente (cli_nit, cli_razon_social, cli_dir, cli_tel, cli_correo, cli_nombre_contacto, cli_estado, Cli_usu_crea)
SELECT '900100004', 'Aceros Industriales de Occidente', 'Av 6N # 24-80', '3105550103', 'planeacion@acerosoccidente.com', 'Marta Gil', 'Activo', 'admin'
WHERE NOT EXISTS (SELECT 1 FROM cliente WHERE cli_nit = '900100004');

INSERT INTO cliente (cli_nit, cli_razon_social, cli_dir, cli_tel, cli_correo, cli_nombre_contacto, cli_estado, Cli_usu_crea)
SELECT '900100005', 'Piezas Tecnicas del Centro', 'Km 4 Via Industrial', '3105550104', 'abastecimiento@piezastecnicas.com', 'Sergio Duarte', 'Activo', 'admin'
WHERE NOT EXISTS (SELECT 1 FROM cliente WHERE cli_nit = '900100005');

INSERT INTO usuario (usu_cedula, usu_login, usu_nombres, usu_apellidos, usu_correo, per_codigo, usu_fecha_crea, usu_usucrea, usu_estado, usu_tel, usu_dir, car_codigo, usu_pass)
SELECT '1002003001', 'fundicion.ana', 'Ana', 'Torres', 'ana.torres@fundicion.local', 1, CURDATE(), 'admin', '1', '3001112233', 'Calle 10 # 20-30', 1, '123456'
WHERE NOT EXISTS (SELECT 1 FROM usuario WHERE usu_login = 'fundicion.ana');

INSERT INTO usuario (usu_cedula, usu_login, usu_nombres, usu_apellidos, usu_correo, per_codigo, usu_fecha_crea, usu_usucrea, usu_estado, usu_tel, usu_dir, car_codigo, usu_pass)
SELECT '1002003002', 'fundicion.luis', 'Luis', 'Castro', 'luis.castro@fundicion.local', 1, CURDATE(), 'admin', '1', '3001112244', 'Cra 22 # 14-18', 1, '123456'
WHERE NOT EXISTS (SELECT 1 FROM usuario WHERE usu_login = 'fundicion.luis');

INSERT INTO usuario (usu_cedula, usu_login, usu_nombres, usu_apellidos, usu_correo, per_codigo, usu_fecha_crea, usu_usucrea, usu_estado, usu_tel, usu_dir, car_codigo, usu_pass)
SELECT '1002003003', 'fundicion.sara', 'Sara', 'Mendez', 'sara.mendez@fundicion.local', 1, CURDATE(), 'admin', '1', '3001112255', 'Av 5 # 33-44', 1, '123456'
WHERE NOT EXISTS (SELECT 1 FROM usuario WHERE usu_login = 'fundicion.sara');

INSERT INTO producto_terminado (pro_id, pro_nombre, tmetal_id, pres_id, bod_id, pro_estado)
SELECT 9201, 'Lingote de Hierro Gris', 92, 91, 94, 'Activo'
WHERE NOT EXISTS (SELECT 1 FROM producto_terminado WHERE pro_id = 9201);

INSERT INTO producto_terminado (pro_id, pro_nombre, tmetal_id, pres_id, bod_id, pro_estado)
SELECT 9202, 'Buje de Bronce', 93, 1, 94, 'Activo'
WHERE NOT EXISTS (SELECT 1 FROM producto_terminado WHERE pro_id = 9202);

INSERT INTO producto_terminado (pro_id, pro_nombre, tmetal_id, pres_id, bod_id, pro_estado)
SELECT 9203, 'Tocho de Aluminio', 94, 91, 94, 'Activo'
WHERE NOT EXISTS (SELECT 1 FROM producto_terminado WHERE pro_id = 9203);

INSERT INTO producto_terminado (pro_id, pro_nombre, tmetal_id, pres_id, bod_id, pro_estado)
SELECT 9204, 'Placa Fundida Especial', 91, 2, 94, 'Activo'
WHERE NOT EXISTS (SELECT 1 FROM producto_terminado WHERE pro_id = 9204);

INSERT INTO materia_prima (mat_codigo, mat_descripcion, mat_peligrosidad, tmetal_id, ematp_id, pres_id, corr_id, bod_id, tpel_id, pro_id, mat_estado)
SELECT 9201, 'Chatarra de hierro clasificada', '91', 92, 91, 91, 1, 92, 91, 9201, 'Activo'
WHERE NOT EXISTS (SELECT 1 FROM materia_prima WHERE mat_codigo = 9201);

INSERT INTO materia_prima (mat_codigo, mat_descripcion, mat_peligrosidad, tmetal_id, ematp_id, pres_id, corr_id, bod_id, tpel_id, pro_id, mat_estado)
SELECT 9202, 'Retal de bronce limpio', '91', 93, 91, 1, 1, 93, 91, 9202, 'Activo'
WHERE NOT EXISTS (SELECT 1 FROM materia_prima WHERE mat_codigo = 9202);

INSERT INTO materia_prima (mat_codigo, mat_descripcion, mat_peligrosidad, tmetal_id, ematp_id, pres_id, corr_id, bod_id, tpel_id, pro_id, mat_estado)
SELECT 9203, 'Viruta de aluminio seleccionada', '91', 94, 91, 2, 1, 93, 91, 9203, 'Activo'
WHERE NOT EXISTS (SELECT 1 FROM materia_prima WHERE mat_codigo = 9203);

INSERT INTO materia_prima (mat_codigo, mat_descripcion, mat_peligrosidad, tmetal_id, ematp_id, pres_id, corr_id, bod_id, tpel_id, pro_id, mat_estado)
SELECT 9204, 'Retorno de piezas de acero', '91', 91, 91, 91, 1, 92, 91, 9204, 'Activo'
WHERE NOT EXISTS (SELECT 1 FROM materia_prima WHERE mat_codigo = 9204);

INSERT INTO registro_fundicion (rfun_id, rfun_fecha, usu_responsable, rfun_observacion, usu_crea)
SELECT 101, '2026-05-10', 'fundicion.ana', 'Lote de prueba para hierro gris', 'admin'
WHERE NOT EXISTS (SELECT 1 FROM registro_fundicion WHERE rfun_id = 101);

INSERT INTO registro_fundicion (rfun_id, rfun_fecha, usu_responsable, rfun_observacion, usu_crea)
SELECT 102, '2026-05-12', 'fundicion.luis', 'Produccion regular de bujes', 'admin'
WHERE NOT EXISTS (SELECT 1 FROM registro_fundicion WHERE rfun_id = 102);

INSERT INTO registro_fundicion (rfun_id, rfun_fecha, usu_responsable, rfun_observacion, usu_crea)
SELECT 103, '2026-05-15', 'fundicion.sara', 'Colada de aluminio para stock', 'admin'
WHERE NOT EXISTS (SELECT 1 FROM registro_fundicion WHERE rfun_id = 103);

INSERT INTO registro_fundicion (rfun_id, rfun_fecha, usu_responsable, rfun_observacion, usu_crea)
SELECT 104, '2026-05-18', 'fundicion.ana', 'Fabricacion de placas especiales', 'admin'
WHERE NOT EXISTS (SELECT 1 FROM registro_fundicion WHERE rfun_id = 104);

INSERT INTO detalle_fundicion (dfun_id, rfun_id, mat_codigo, Cli_mat, dfun_cantidad, pro_id, dfun_cantprot, esc_id, dfun_cantesc, hor_id, com_id, dfun_cantidad_com, dfun_hinicio, dfun_hfin, dfun_per_metal, dfun_num_docrres)
SELECT 101, 101, 9201, '900100002', 35, 9201, 31, 0, 4, 92, 92, 6, '06:00', '08:00', 2, 0
WHERE NOT EXISTS (SELECT 1 FROM detalle_fundicion WHERE dfun_id = 101);

INSERT INTO detalle_fundicion (dfun_id, rfun_id, mat_codigo, Cli_mat, dfun_cantidad, pro_id, dfun_cantprot, esc_id, dfun_cantesc, hor_id, com_id, dfun_cantidad_com, dfun_hinicio, dfun_hfin, dfun_per_metal, dfun_num_docrres)
SELECT 102, 102, 9202, '900100003', 28, 9202, 24, 0, 3, 93, 93, 7, '08:30', '11:00', 1, 0
WHERE NOT EXISTS (SELECT 1 FROM detalle_fundicion WHERE dfun_id = 102);

INSERT INTO detalle_fundicion (dfun_id, rfun_id, mat_codigo, Cli_mat, dfun_cantidad, pro_id, dfun_cantprot, esc_id, dfun_cantesc, hor_id, com_id, dfun_cantidad_com, dfun_hinicio, dfun_hfin, dfun_per_metal, dfun_num_docrres)
SELECT 103, 103, 9203, '900100004', 42, 9203, 37, 0, 5, 94, 94, 9, '12:00', '15:00', 3, 0
WHERE NOT EXISTS (SELECT 1 FROM detalle_fundicion WHERE dfun_id = 103);

INSERT INTO detalle_fundicion (dfun_id, rfun_id, mat_codigo, Cli_mat, dfun_cantidad, pro_id, dfun_cantprot, esc_id, dfun_cantesc, hor_id, com_id, dfun_cantidad_com, dfun_hinicio, dfun_hfin, dfun_per_metal, dfun_num_docrres)
SELECT 104, 104, 9204, '900100005', 30, 9204, 26, 0, 3, 95, 95, 8, '15:30', '18:00', 2, 0
WHERE NOT EXISTS (SELECT 1 FROM detalle_fundicion WHERE dfun_id = 104);
