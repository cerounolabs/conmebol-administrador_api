<?php
    $app->delete('/v1/100/dominio/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val00      = $request->getAttribute('codigo');
        $val01      = $request->getParsedBody()['tipo_estado_codigo'];
        $val02      = $request->getParsedBody()['tipo_orden'];
        $val03      = $request->getParsedBody()['tipo_nombre_ingles'];
        $val04      = $request->getParsedBody()['tipo_nombre_castellano'];
        $val05      = $request->getParsedBody()['tipo_nombre_portugues'];
        $val06      = $request->getParsedBody()['tipo_path'];
        $val07      = $request->getParsedBody()['tipo_dominio'];
        $val08      = $request->getParsedBody()['tipo_observacion'];

        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        if (isset($val00) && isset($val01) && isset($val04) && isset($val07)) {    
            $sql00  = "UPDATE [adm].[DOMFIC] SET DOMFICUSU = ?, DOMFICFEC = GETDATE(), DOMFICDIP = ? WHERE DOMFICCOD = ?";
            $sql01  = "DELETE [adm].[DOMFIC] WHERE DOMFICCOD = ?";

            try {
                $connMSSQL  = getConnectionMSSQLv1();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL01= $connMSSQL->prepare($sql01);

                $stmtMSSQL00->execute([$aud01, $aud03, $val00]);
                $stmtMSSQL01->execute([$val00]);

                $stmtMSSQL00->closeCursor();
                $stmtMSSQL01->closeCursor();

                $stmtMSSQL00= null;
                $stmtMSSQL01= null;

                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success DELETE', 'codigo' => 0), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error DELETE: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->delete('/v1/100/dominiosub', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getParsedBody()['tipo_dominio1_codigo'];
        $val02      = $request->getParsedBody()['tipo_dominio2_codigo'];
        $val03      = $request->getParsedBody()['tipo_estado_codigo'];
        $val04      = $request->getParsedBody()['tipo_orden'];
        $val05      = $request->getParsedBody()['tipo_path'];
        $val06      = $request->getParsedBody()['tipo_dominio'];
        $val07      = $request->getParsedBody()['tipo_observacion'];

        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        if (isset($val01) && isset($val02) && isset($val06)) {
            $sql00  = "UPDATE [adm].[DOMSUB] SET DOMSUBAUS = ?, DOMSUBAFE = GETDATE(), DOMSUBAIP = ? WHERE DOMSUBCO1 = ? AND DOMSUBCO2 = ? AND DOMSUBVAL = ?";
            $sql01  = "DELETE [adm].[DOMSUB] WHERE DOMSUBCO1 = ? AND DOMSUBCO2 = ? AND DOMSUBVAL = ?";

            try {
                $connMSSQL  = getConnectionMSSQLv1();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL01= $connMSSQL->prepare($sql01);

                $stmtMSSQL00->execute([$aud01, $aud03, $val01, $val02, $val06]);
                $stmtMSSQL01->execute([$val01, $val02, $val06]);

                $stmtMSSQL00->closeCursor();
                $stmtMSSQL01->closeCursor();

                $stmtMSSQL00= null;
                $stmtMSSQL01= null;

                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success UPDATE', 'codigo' => 0), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error UPDATE: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->delete('/v1/100/pais/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val00      = $request->getAttribute('codigo');
        $val01      = $request->getParsedBody()['tipo_estado_codigo'];
        $val02      = $request->getParsedBody()['pais_orden'];
        $val03      = $request->getParsedBody()['pais_nombre'];
        $val04      = $request->getParsedBody()['pais_path'];
        $val05      = $request->getParsedBody()['pais_iso_char2'];
        $val06      = $request->getParsedBody()['pais_iso_char3'];
        $val07      = $request->getParsedBody()['pais_iso_num3'];
        $val08      = $request->getParsedBody()['pais_observacion'];

        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        if (isset($val00) && isset($val01) && isset($val04) && isset($val07)) { 
            $sql00  = "UPDATE [adm].[LOCPAI] SET LOCPAIAUS = ?, LOCPAIAFH = GETDATE(), LOCPAIAIP  = ? WHERE LOCPAICOD = ?";
            $sql01  = "DELETE FROM [adm].[LOCPAI] WHERE LOCPAICOD = ?";

            try {
                $connMSSQL  = getConnectionMSSQLv1();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL01= $connMSSQL->prepare($sql01);

                $stmtMSSQL00->execute([$aud01, $aud03, $val00]);
                $stmtMSSQL01->execute([$val00]);

                $stmtMSSQL00->closeCursor();
                $stmtMSSQL01->closeCursor();

                $stmtMSSQL00= null;
                $stmtMSSQL01= null;

                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success DELETE', 'codigo' => $val00), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error DELETE: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->delete('/v1/100/ciudad/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val00      = $request->getAttribute('codigo');
        $val01      = $request->getParsedBody()['tipo_estado_codigo'];
        $val02      = $request->getParsedBody()['ciudad_orden'];
        $val03      = $request->getParsedBody()['pais_codigo'];
        $val04      = $request->getParsedBody()['ciudad_nombre'];
        $val05      = $request->getParsedBody()['ciudad_observacion'];

        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        if (isset($val00) && isset($val02) && isset($val04)) {    
            $sql00  = "UPDATE [adm].[LOCCIU] SET LOCCIUAUS = ?, LOCCIUAFH = GETDATE(), LOCCIUAIP  = ? WHERE LOCCIUCOD = ?";
            $sql01  = "DELETE FROM [adm].[LOCCIU] WHERE LOCCIUCOD = ?";

            try {
                $connMSSQL  = getConnectionMSSQLv1();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL01= $connMSSQL->prepare($sql01);

                $stmtMSSQL00->execute([$aud01, $aud03, $val00]);
                $stmtMSSQL01->execute([$val00]);

                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success DELETE', 'codigo' => $val00), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtMSSQL00->closeCursor();
                $stmtMSSQL00 = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error DELETE: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->delete('/v1/400/proveedor/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val00      = $request->getAttribute('codigo');
        $val01      = $request->getParsedBody()['tipo_estado_codigo'];
        $val02      = $request->getParsedBody()['tipo_proveedor_codigo'];
        $val03      = $request->getParsedBody()['tipo_categoria_codigo'];
        $val04      = $request->getParsedBody()['localidad_ciudad_codigo'];
        $val05      = trim(strtoupper(strtolower($request->getParsedBody()['proveedor_nombre'])));
        $val06      = trim(strtoupper(strtolower($request->getParsedBody()['proveedor_razon_social'])));
        $val07      = trim(strtoupper(strtolower($request->getParsedBody()['proveedor_ruc'])));
        $val08      = trim(strtoupper(strtolower($request->getParsedBody()['proveedor_pais'])));
        $val09      = trim(strtoupper(strtolower($request->getParsedBody()['proveedor_direccion'])));
        $val10      = trim(strtoupper(strtolower($request->getParsedBody()['proveedor_sap_castastrado'])));
        $val11      = trim(strtoupper(strtolower($request->getParsedBody()['proveedor_sap_codigo'])));
        $val12      = trim(strtoupper(strtolower($request->getParsedBody()['proveedor_sap_cuenta_contable'])));
        $val13      = trim(strtoupper(strtolower($request->getParsedBody()['proveedor_observacion'])));

        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        if (isset($val00) && isset($val01) && isset($val02) && isset($val03) && isset($val04) && isset($val05) && isset($val06)) {        
            $sql00  = "UPDATE [via].[PROFIC] SET PROFICUSU = ?, PROFICFEC = GETDATE(), PROFICDIP = ? WHERE PROFICCOD = ?";
            $sql01  = "DELETE [via].[PROFIC] WHERE PROFICCOD = ?";
            
            try {
                $connMSSQL  = getConnectionMSSQLv1();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL01= $connMSSQL->prepare($sql01);

                $stmtMSSQL00->execute([$aud01, $aud03, $val00]);
                $stmtMSSQL01->execute([$val00]);

                $stmtMSSQL00->closeCursor();
                $stmtMSSQL01->closeCursor();

                $stmtMSSQL00= null;
                $stmtMSSQL01= null;

                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success DELETE', 'codigo' => 0), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error DELETE: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->delete('/v1/400/proveedor/contacto/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val00      = $request->getAttribute('codigo');
        $val01      = $request->getParsedBody()['tipo_estado_codigo'];
        $val02      = $request->getParsedBody()['proveedor_codigo'];
        $val03      = trim(strtoupper(strtolower($request->getParsedBody()['proveedor_contacto_nombre'])));
        $val04      = trim(strtolower($request->getParsedBody()['proveedor_contacto_email']));
        $val05      = trim(strtolower($request->getParsedBody()['proveedor_contacto_telefono']));
        $val06      = trim(strtolower($request->getParsedBody()['proveedor_contacto_whatsapp']));
        $val07      = trim(strtolower($request->getParsedBody()['proveedor_contacto_skype']));
        $val08      = trim(strtoupper(strtolower($request->getParsedBody()['proveedor_contacto_observacion'])));

        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        if (isset($val00) && isset($val01) && isset($val02) && isset($val03)) {   
            $sql00  = "UPDATE [via].[PROCON] SET  PROCONAUS = ?, PROCONAFH = GETDATE(), PROCONAIP = ? WHERE PROCONCOD = ?";
            $sql01  = "DELETE FROM [via].[PROCON] WHERE PROCONCOD = ?";
            
            try {
                $connMSSQL  = getConnectionMSSQLv1();

                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL01= $connMSSQL->prepare($sql01);

                $stmtMSSQL00->execute([$aud01, $aud03, $val00]);
                $stmtMSSQL01->execute([$val00]);

                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success DELETE', 'codigo' => 0), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtMSSQL00->closeCursor();
                $stmtMSSQL01->closeCursor();

                $stmtMSSQL00 = null;
                $stmtMSSQL01 = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error DELETE: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->delete('/v1/400/proveedor/habitacion/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val00      = $request->getAttribute('codigo');
        $val01      = $request->getParsedBody()['tipo_estado_codigo'];
        $val02      = $request->getParsedBody()['tipo_habitacion_codigo'];
        $val03      = $request->getParsedBody()['proveedor_codigo'];
        $val04      = trim(strtoupper(strtolower($request->getParsedBody()['proveedor_habitacion_nombre'])));
        $val05      = trim(strtoupper(strtolower($request->getParsedBody()['proveedor_habitacion_precio'])));
        $val06      = trim(strtolower($request->getParsedBody()['proveedor_habitacion_path']));
        $val07      = trim(strtoupper(strtolower($request->getParsedBody()['proveedor_habitacion_observacion'])));

        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        if (isset($val00) && isset($val01) && isset($val02) && isset($val03)) {        
            $sql00  = "UPDATE [via].[PROHAB] SET  PROHABAUS = ?, PROHABAFH = GETDATE(), PROHABAIP = ? WHERE PROHABCOD = ?";
            $sql01  = "DELETE FROM [via].[PROHAB] WHERE PROHABCOD = ?";
            
            try {
                $connMSSQL  = getConnectionMSSQLv1();

                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL01= $connMSSQL->prepare($sql01);

                $stmtMSSQL00->execute([$aud01, $aud03, $val00]);
                $stmtMSSQL01->execute([$val00]);

                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success DELETE', 'codigo' => 0), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtMSSQL00->closeCursor();
                $stmtMSSQL01->closeCursor();

                $stmtMSSQL00 = null;
                $stmtMSSQL01 = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error DELETE: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    /*MODULO PERMISO*/
    $app->delete('/v1/200/tarjetapersonal/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val00      = $request->getAttribute('codigo');
        $val01      = $request->getParsedBody()['tipo_estado_parametro'];
        $val02      = $request->getParsedBody()['tipo_cantidad_parametro'];
        $val03      = $request->getParsedBody()['tarjeta_personal_orden'];
        $val04      = $request->getParsedBody()['tipo_gerencia_codigo'];
        $val05      = $request->getParsedBody()['tipo_departamento_codigo'];
        $val06      = $request->getParsedBody()['tipo_jefatura_codigo'];
        $val07      = $request->getParsedBody()['tipo_cargo_codigo'];
        $val08      = trim(strtoupper($request->getParsedBody()['tarjeta_personal_documento']));
        $val09      = trim(strtolower($request->getParsedBody()['tarjeta_personal_email']));
        $val10      = trim(strtoupper(strtolower($request->getParsedBody()['tarjeta_personal_nombre_visualizar'])));
        $val11      = trim(strtoupper(strtolower($request->getParsedBody()['tarjeta_personal_apellido_visualizar'])));
        $val12     =  trim($request->getParsedBody()['tarjeta_personal_observacion']);

        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        if (isset($val01) && isset($val02) && isset($val04) && isset($val05) && isset($val06) && isset($val07) && isset($val08)) {  
            $sql00  = "UPDATE [hum].[TPEFIC] SET TPEFICAUS = ?, TPEFICAFH = GETDATE(), TPEFICAIP = ? WHERE TPEFICCOD = ?";
            $sql01  = "DELETE [hum].[TPEFIC] WHERE TPEFICCOD = ?";
            
            try {
                $connMSSQL  = getConnectionMSSQLv1();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL01= $connMSSQL->prepare($sql01);

                $stmtMSSQL00->execute([$aud01, $aud03, $val00]);
                $stmtMSSQL01->execute([$val00]);

                $stmtMSSQL00->closeCursor();
                $stmtMSSQL01->closeCursor();

                $stmtMSSQL00= null;
                $stmtMSSQL01= null;

                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success DELETE', 'codigo' => $val00), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error DELETE: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->delete('/v1/200/tarjetapersonal/telefonoprefijo/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val00      = $request->getAttribute('codigo');
        $val01      = $request->getParsedBody()['tipo_estado_parametro'];
        $val02      = $request->getParsedBody()['tarjeta_personal_telefono_orden'];
        $val03      = $request->getParsedBody()['tipo_prefijo_parametro'];
        $val04      = $request->getParsedBody()['tarjeta_personal_codigo'];
        $val05      = trim(strtoupper($request->getParsedBody()['tarjeta_personal_telefono_visualizar']));
        $val06      = trim($request->getParsedBody()['tarjeta_personal_telefono_numero']);
        $val07      = trim($request->getParsedBody()['tarjeta_personal_telefono_observacion']);

        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        if (isset($val01) && isset($val03) &&  isset($val04)) {      
            $sql00  = "UPDATE [hum].[TPETEL] SET TPETELAUS = ?, TPETELAFH = GETDATE(), TPETELAIP = ? WHERE TPETELCOD = ?";
            $sql01  = "DELETE [hum].[TPETEL] WHERE TPETELCOD = ?";
            
            try {
                $connMSSQL  = getConnectionMSSQLv1();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL01= $connMSSQL->prepare($sql01);

                $stmtMSSQL00->execute([$aud01, $aud03, $val00]);
                $stmtMSSQL01->execute([$val00]);

                $stmtMSSQL00->closeCursor();
                $stmtMSSQL01->closeCursor();

                $stmtMSSQL00= null;
                $stmtMSSQL01= null;

                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success DELETE', 'codigo' => $val00), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error DELETE: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->delete('/v1/200/tarjetapersonal/redesocial/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

            $val00      = $request->getAttribute('codigo');
            $val01      = $request->getParsedBody()['tipo_estado_parametro'];
            $val02      = $request->getParsedBody()['tarjeta_personal_red_social_orden'];
            $val03      = $request->getParsedBody()['tipo_red_social_parametro'];
            $val04      = $request->getParsedBody()['tarjeta_personal_codigo'];
            $val05      = trim(strtolower($request->getParsedBody()['tarjeta_personal_red_social_direccion']));
            $val06      = trim($request->getParsedBody()['tarjeta_personal_red_social_observacion']);

            $aud01      = $request->getParsedBody()['auditoria_usuario'];
            $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
            $aud03      = $request->getParsedBody()['auditoria_ip'];

            if (isset($val00) && isset($val01) && isset($val03) &&  isset($val04)) {   
            $sql00  = "UPDATE [hum].[TPERSO] SET TPERSOAUS = ?, TPERSOAFH = GETDATE(), TPERSOAIP = ? WHERE TPERSOCOD = ?";
            $sql01  = "DELETE [hum].[TPERSO] WHERE TPERSOCOD = ?";
            
            try {
                $connMSSQL  = getConnectionMSSQLv1();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL01= $connMSSQL->prepare($sql01);

                $stmtMSSQL00->execute([$aud01, $aud03, $val00]);
                $stmtMSSQL01->execute([$val00]);

                $stmtMSSQL00->closeCursor();
                $stmtMSSQL01->closeCursor();

                $stmtMSSQL00= null;
                $stmtMSSQL01= null;

                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success DELETE', 'codigo' => $val00), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error DELETE: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->delete('/v1/200/testpcr/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val00      = $request->getAttribute('codigo');
        $val01      = $request->getParsedBody()['tipo_estado_parametro'];
        $val02      = $request->getParsedBody()['tipo_solicitud_parametro'];
        $val03      = $request->getParsedBody()['tipo_rol_parametro'];
        $val04      = $request->getParsedBody()['testpcr_orden'];
        $val05      = trim($request->getParsedBody()['testpcr_solicitante_nombre']);
        $val06      = trim($request->getParsedBody()['testpcr_solicitante_apellido']);
        $val07      = trim($request->getParsedBody()['testpcr_solicitante_documento']);
        $val08      = trim($request->getParsedBody()['testpcr_solicitante_email']);
        $val09      = trim($request->getParsedBody()['testpcr_solicitante_observacion']);
        $val10      = trim($request->getParsedBody()['testpcr_jefetura_documento']);
        $val11      = $request->getParsedBody()['testpcr_fecha_1'];
        $val12      = $request->getParsedBody()['testpcr_fecha_2'];
        $val13      = trim($request->getParsedBody()['testpcr_hora_1']);
        $val14      = trim($request->getParsedBody()['testpcr_hora_2']);
        $val15      = trim($request->getParsedBody()['testpcr_adjunto_1']);
        $val16      = trim($request->getParsedBody()['testpcr_adjunto_2']);
        $val17      = trim($request->getParsedBody()['testpcr_adjunto_3']);
        $val18      = trim($request->getParsedBody()['testpcr_adjunto_4']);
        $val19      = trim($request->getParsedBody()['testpcr_laboratorio_nombre']);
        $val20      = trim($request->getParsedBody()['testpcr_laboratorio_contacto']);
        $val21      = trim($request->getParsedBody()['testpcr_laboratorio_email']);
        $val22      = $request->getParsedBody()['testpcr_laboratorio_fecha_resultado'];
        $val23      = trim($request->getParsedBody()['testpcr_laboratorio_adjunto']);
        $val24      = trim(strtoupper(strtolower($request->getParsedBody()['testpcr_laboratorio_resultado'])));
        $val25      = trim($request->getParsedBody()['testpcr_laboratorio_observacion']);
        $val26      = trim($request->getParsedBody()['testpcr_carga_usuario']);
        $val27      = $request->getParsedBody()['testpcr_carga_fecha'];
        $val28      = $request->getParsedBody()['testpcr_carga_ip'];
        $val29      = trim($request->getParsedBody()['testpcr_talento_usuario']);
        $val30      = $request->getParsedBody()['testpcr_talento_fecha'];
        $val31      = $request->getParsedBody()['testpcr_talento_ip'];
        $val32      = trim($request->getParsedBody()['testpcr_talento_observacion']);

        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        if (isset($val01) && isset($val02) && isset($val05) && isset($val06) && isset($val07)){
            $sql00  = "UPDATE [hum].[SOLPCR] SET SOLPCRAUS = ?,	SOLPCRAFH = GETDATE(), SOLPCRAIP = ? WHERE SOLPCRCOD = ?";
            $sql01  = "DELETE FROM [hum].[SOLPCR] WHERE SOLPCRCOD = ?";
            
            try {
                $connMSSQL  = getConnectionMSSQLv1();

                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL01= $connMSSQL->prepare($sql01);

                $stmtMSSQL00->execute([$aud01, $aud03, $val00]);
                $stmtMSSQL01->execute([$val00]);

                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success DELETE', 'codigo' => $val00), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtMSSQL00->closeCursor();
                $stmtMSSQL01->closeCursor();

                $stmtMSSQL00 = null;
                $stmtMSSQL01 = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error DELETE: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });
/*MODULO PERMISO*/