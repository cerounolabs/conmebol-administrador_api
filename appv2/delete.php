<?php
/*MODULO PARAMETRO*/
    $app->delete('/v2/100/dominio/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val00      = $request->getAttribute('codigo');
        $val01      = $request->getParsedBody()['tipo_estado_codigo'];
        $val02      = $request->getParsedBody()['tipo_orden'];
        $val03      = trim(strtoupper(strtolower($request->getParsedBody()['tipo_nombre_ingles'])));
        $val04      = trim(strtoupper(strtolower($request->getParsedBody()['tipo_nombre_castellano'])));
        $val05      = trim(strtoupper(strtolower($request->getParsedBody()['tipo_nombre_portugues'])));
        $val06      = trim(strtolower($request->getParsedBody()['tipo_path']));
        $val07      = trim(strtolower($request->getParsedBody()['tipo_css']));
        $val08      = $request->getParsedBody()['tipo_parametro'];
        $val09      = trim(strtolower($request->getParsedBody()['tipo_icono']));
        $val10      = trim(strtoupper(strtolower($request->getParsedBody()['tipo_dominio'])));
        $val11      = trim(strtoupper(strtolower($request->getParsedBody()['tipo_observacion'])));

        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        if (isset($val00) && isset($val01) && isset($val04) && isset($val10)) {   
            $sql00  = "UPDATE [adm].[DOMFIC] SET DOMFICUSU = ?, DOMFICFEC = GETDATE(), DOMFICDIP = ? WHERE DOMFICCOD = ?";
            $sql01  = "DELETE [adm].[DOMFIC] WHERE DOMFICCOD = ?";

            try {
                $connMSSQL  = getConnectionMSSQLv2();
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

    $app->delete('/v2/100/dominiosub', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getParsedBody()['tipo_dominio1_codigo'];
        $val02      = $request->getParsedBody()['tipo_dominio2_codigo'];
        $val03      = $request->getParsedBody()['tipo_estado_codigo'];
        $val04      = $request->getParsedBody()['tipo_orden'];
        $val05      = $request->getParsedBody()['tipo_parametro'];
        $val06      = trim(strtolower($request->getParsedBody()['tipo_icono']));
        $val07      = trim(strtolower($request->getParsedBody()['tipo_css']));
        $val08      = trim(strtolower($request->getParsedBody()['tipo_path']));
        $val09      = trim(strtoupper(strtolower($request->getParsedBody()['tipo_dominio'])));
        $val10      = trim($request->getParsedBody()['tipo_observacion']);

        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        if (isset($val01) && isset($val02) && isset($val03) && isset($val05) && isset($val09)) { 
            $sql00  = "UPDATE [adm].[DOMSUB] SET
                DOMSUBAUS = ?,
                DOMSUBAFE = GETDATE(),
                DOMSUBAIP = ?
                WHERE DOMSUBCO1 = ? AND DOMSUBCO2 = ? AND DOMSUBVAL = ?";

            $sql01  = "DELETE [adm].[DOMSUB] WHERE DOMSUBCO1 = ? AND DOMSUBCO2 = ? AND DOMSUBVAL = ?";

            try {
                $connMSSQL  = getConnectionMSSQLv2();
                
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL01= $connMSSQL->prepare($sql01);

                $stmtMSSQL00->execute([$aud01, $aud03, $val01, $val02, $val09]);
                $stmtMSSQL01->execute([$val01, $val02, $val09]);

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

    $app->delete('/v2/100/pais/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val00      = $request->getAttribute('codigo');
        $val01      = $request->getParsedBody()['tipo_estado_codigo'];
        $val02      = $request->getParsedBody()['localidad_pais_orden'];
        $val03      = $request->getParsedBody()['localidad_pais_nombre'];
        $val04      = $request->getParsedBody()['localidad_pais_path'];
        $val05      = $request->getParsedBody()['localidad_pais_iso_char2'];
        $val06      = $request->getParsedBody()['localidad_pais_iso_char3'];
        $val07      = $request->getParsedBody()['localidad_pais_iso_num3'];
        $val08      = $request->getParsedBody()['localidad_pais_observacion'];

        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        if (isset($val00) && isset($val01) && isset($val04) && isset($val07)) { 
            $sql00  = "UPDATE [adm].[LOCPAI] SET LOCPAIAUS = ?, LOCPAIAFH = GETDATE(), LOCPAIAIP  = ? WHERE LOCPAICOD = ?";
            $sql01  = "DELETE FROM [adm].[LOCPAI] WHERE LOCPAICOD = ?";

            try {
                $connMSSQL  = getConnectionMSSQLv2();
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

    $app->delete('/v2/100/ciudad/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val00      = $request->getAttribute('codigo');
        $val01      = $request->getParsedBody()['tipo_estado_codigo'];
        $val02      = $request->getParsedBody()['localidad_ciudad_orden'];
        $val03      = $request->getParsedBody()['localidad_pais_codigo'];
        $val04      = $request->getParsedBody()['localidad_ciudad_nombre'];
        $val05      = $request->getParsedBody()['localidad_ciudad_observacion'];

        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        if (isset($val00) && isset($val02) && isset($val04)) {    
            $sql00  = "UPDATE [adm].[LOCCIU] SET LOCCIUAUS = ?, LOCCIUAFH = GETDATE(), LOCCIUAIP  = ? WHERE LOCCIUCOD = ?";
            $sql01  = "DELETE FROM [adm].[LOCCIU] WHERE LOCCIUCOD = ?";

            try {
                $connMSSQL  = getConnectionMSSQLv2();
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

    $app->delete('/v2/100/aeropuerto/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val00      = $request->getAttribute('codigo');
        $val01      = $request->getParsedBody()['tipo_estado_codigo'];
        $val02      = $request->getParsedBody()['localidad_aeropuerto_orden'];
        $val03      = $request->getParsedBody()['localidad_pais_codigo'];
        $val04      = $request->getParsedBody()['localidad_aeropuerto_nombre'];
        $val05      = $request->getParsedBody()['localidad_aeropuerto_observacion'];

        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        if (isset($val00) && isset($val01) && isset($val03) && isset($val04)) {  
            $sql00  = "UPDATE [adm].[LOCAER] SET LOCAERAUS = ?, LOCAERAFH = GETDATE(), LOCAERAIP  = ? WHERE LOCAERCOD = ?";
            $sql01  = "DELETE FROM [adm].[LOCAER] WHERE LOCAERCOD = ?";

            try {
                $connMSSQL  = getConnectionMSSQLv2();
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
/*MODULO PARAMETRO*/

/*MODULO PERMISO*/
    $app->delete('/v2/200/tarjetapersonal/{codigo}', function($request) {
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
                $connMSSQL  = getConnectionMSSQLv2();
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

    $app->delete('/v2/200/tarjetapersonal/telefonoprefijo/{codigo}', function($request) {
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
                $connMSSQL  = getConnectionMSSQLv2();
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

    $app->delete('/v2/200/tarjetapersonal/redesocial/{codigo}', function($request) {
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
                $connMSSQL  = getConnectionMSSQLv2();
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

    $app->delete('/v2/200/testpcr/{codigo}', function($request) {
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
                $connMSSQL  = getConnectionMSSQLv2();

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

    $app->delete('/v2/200/evento/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val00      = $request->getAttribute('codigo');
        $val01      = $request->getParsedBody()['tipo_estado_parametro'];
        $val02      = $request->getParsedBody()['tipo_evento_parametro'];
        $val03      = $request->getParsedBody()['evento_orden'];
        $val04      = $request->getParsedBody()['tipo_gerencia_codigo'];
        $val05      = $request->getParsedBody()['tipo_departamento_codigo'];
        $val06      = $request->getParsedBody()['tipo_cargo_codigo'];
        $val07      = trim($request->getParsedBody()['evento_descripcion']);
        $val08      = $request->getParsedBody()['evento_fecha_desde'];
        $val09      = $request->getParsedBody()['evento_fecha_hasta'];
        $val10      = trim($request->getParsedBody()['evento_observacion']);


        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        if (isset($val01) && isset($val02) && isset($val04) && isset($val05) && isset($val06) && isset($val07)){
            $sql00  = "UPDATE [hum].[EVEFIC] SET EVEFICAUS = ?,	EVEFICAFH = GETDATE(), EVEFICAIP = ? WHERE EVEFICCOD = ?";
            $sql01  = "DELETE FROM [hum].[EVEFIC] WHERE EVEFICCOD = ?";
            
            try {
                $connMSSQL  = getConnectionMSSQLv2();

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

    $app->delete('/v2/200/proveedor/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val00      = $request->getAttribute('codigo');
        $val01      = $request->getParsedBody()['tipo_estado_parametro'];
        $val02      = $request->getParsedBody()['tipo_rol_parametro'];
        $val03      = $request->getParsedBody()['proveedor_orden'];
        $val04      = $request->getParsedBody()['localidad_nacionalidad_codigo'];
        $val05      = $request->getParsedBody()['localidad_ciudad_codigo'];
        $val06      = trim(strtoupper(strtolower($request->getParsedBody()['proveedor_documento'])));
        $val07      = $request->getParsedBody()['proveedor_documento_fecha_emision'];
        $val08      = $request->getParsedBody()['proveedor_documento_fecha_vencimiento'];
        $val09      = trim($request->getParsedBody()['proveedor_nombre_apellido']);
        $val10      = $request->getParsedBody()['proveedor_fecha_nacimiento'];
        $val11      = trim($request->getParsedBody()['proveedor_federacion']);
        $val12      = trim(strtoupper(strtolower($request->getParsedBody()['proveedor_pasaporte_numero'])));
        $val13      = $request->getParsedBody()['proveedor_pasaporte_fecha_emision'];
        $val14      = $request->getParsedBody()['proveedor_pasaporte_fecha_vencimiento'];
        $val15      = trim($request->getParsedBody()['proveedor_observacion']);


        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        if (isset($val01) && isset($val02) && isset($val04) && isset($val05) && isset($val06) && isset($val07)){
            $sql00  = "UPDATE [hum].[PROFIC] SET PROFICAUS = ?,	PROFICAFH = GETDATE(), PROFICAIP = ? WHERE PROFICCOD = ?";
            $sql01  = "DELETE FROM [hum].[PROFIC] WHERE PROFICCOD = ?";
            
            try {
                $connMSSQL  = getConnectionMSSQLv2();

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

/*MODULO VIAJE*/
    $app->delete('/v2/400/proveedor/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val00      = $request->getAttribute('codigo');
        $val01      = $request->getParsedBody()['tipo_estado_codigo'];
        $val02      = $request->getParsedBody()['tipo_proveedor_codigo'];
        $val03      = $request->getParsedBody()['localidad_ciudad_codigo'];
        $val04      = trim(strtoupper(strtolower($request->getParsedBody()['proveedor_nombre'])));
        $val05      = trim(strtoupper(strtolower($request->getParsedBody()['proveedor_razon_social'])));
        $val06      = trim(strtoupper(strtolower($request->getParsedBody()['proveedor_ruc'])));
        $val07      = trim(strtoupper(strtolower($request->getParsedBody()['proveedor_direccion'])));
        $val08      = trim(strtoupper(strtolower($request->getParsedBody()['proveedor_sap_castastrado'])));
        $val09      = trim(strtoupper(strtolower($request->getParsedBody()['proveedor_sap_codigo'])));
        $val10      = trim(strtoupper(strtolower($request->getParsedBody()['proveedor_observacion'])));

        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        if (isset($val00) && isset($val01) && isset($val02) && isset($val03) && isset($val04) && isset($val05) && isset($val06)) {        
            $sql00  = "UPDATE [via].[PROFIC] SET PROFICUSU = ?, PROFICFEC = GETDATE(), PROFICDIP = ? WHERE PROFICCOD = ?";
            $sql01  = "DELETE [via].[PROFIC] WHERE PROFICCOD = ?";
            
            try {
                $connMSSQL  = getConnectionMSSQLv2();
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

    $app->delete('/v2/400/proveedor/contacto/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val00      = $request->getAttribute('codigo');
        $val01      = $request->getParsedBody()['tipo_estado_codigo'];
        $val02      = $request->getParsedBody()['proveedor_codigo'];
        $val03      = trim(strtoupper(strtolower($request->getParsedBody()['proveedor_contacto_nombre'])));
        $val04      = trim(strtolower($request->getParsedBody()['proveedor_contacto_email']));
        $val05      = trim(strtoupper(strtolower($request->getParsedBody()['proveedor_contacto_telefono'])));
        $val06      = trim(strtoupper(strtolower($request->getParsedBody()['proveedor_contacto_whatsapp'])));
        $val07      = trim(strtolower($request->getParsedBody()['proveedor_contacto_skype']));
        $val08      = trim(strtoupper(strtolower($request->getParsedBody()['proveedor_contacto_observacion'])));

        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        if (isset($val00) && isset($val01) && isset($val02) && isset($val03)) {   
            $sql00  = "UPDATE [via].[PROCON] SET PROCONAUS = ?, PROCONAFH = GETDATE(), PROCONAIP = ? WHERE PROCONCOD = ?";
            $sql01  = "DELETE FROM [via].[PROCON] WHERE PROCONCOD = ?";
            
            try {
                $connMSSQL  = getConnectionMSSQLv2();

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

    $app->delete('/v2/400/proveedor/habitacion/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val00      = $request->getAttribute('codigo');
        $val01      = $request->getParsedBody()['tipo_estado_codigo'];
        $val02      = $request->getParsedBody()['tipo_habitacion_codigo'];
        $val03      = $request->getParsedBody()['proveedor_codigo'];
        $val04      = trim(strtoupper(strtolower($request->getParsedBody()['proveedor_habitacion_nombre'])));
        $val05      = trim(strtoupper(strtolower($request->getParsedBody()['proveedor_habitacion_precio'])));
        $val06      = $request->getParsedBody()['proveedor_habitacion_cantidad'];
        $val07      = trim(strtolower($request->getParsedBody()['proveedor_habitacion_path']));
        $val08      = trim(strtoupper(strtolower($request->getParsedBody()['proveedor_habitacion_observacion'])));

        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        if (isset($val00) && isset($val01) && isset($val02) && isset($val03)) {        
            $sql00  = "UPDATE [via].[PROHAB] SET PROHABAUS = ?, PROHABAFH = GETDATE(), PROHABAIP = ? WHERE PROHABCOD = ?";
            $sql01  = "DELETE FROM [via].[PROHAB] WHERE PROHABCOD = ?";
            
            try {
                $connMSSQL  = getConnectionMSSQLv2();

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

    $app->delete('/v2/400/proveedor/imagen/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val00      = $request->getAttribute('codigo');
        $val01      = $request->getParsedBody()['tipo_estado_codigo'];
        $val02      = $request->getParsedBody()['proveedor_codigo'];
        $val03      = trim(strtolower($request->getParsedBody()['proveedor_imagen_path']));
        $val04      = trim(strtoupper(strtolower($request->getParsedBody()['proveedor_imagen_observacion'])));

        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        if (isset($val00) && isset($val01) && isset($val02) && isset($val03)) {        
            $sql00  = "UPDATE [via].[PROCON] SET PROCONAUS = ?, PROCONAFH = GETDATE(), PROCONAIP = ? WHERE PROCONCOD = ?";
            $sql01  = "DELETE FROM [via].[PROCON] WHERE PROCONCOD = ?";
            
            try {
                $connMSSQL  = getConnectionMSSQLv2();

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

    $app->delete('/v2/400/evento/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val00      = $request->getAttribute('codigo');
        $val01      = $request->getParsedBody()['tipo_estado_codigo'];
        $val02      = $request->getParsedBody()['tipo_evento_codigo'];
        $val03      = $request->getParsedBody()['localidad_ciudad_codigo'];
        $val04      = $request->getParsedBody()['evento_orden'];
        $val05      = trim(strtoupper(strtolower($request->getParsedBody()['evento_nombre'])));
        $val06      = $request->getParsedBody()['evento_fecha_inicio'];
        $val07      = $request->getParsedBody()['evento_fecha_fin'];
        $val08      = trim(strtoupper(strtolower($request->getParsedBody()['evento_observacion'])));

        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        if (isset($val01) && isset($val02) && isset($val03) && isset($val05)) {         
            $sql00  = "UPDATE [via].[EVEFIC] SET EVEFICAUS = ?, EVEFICAFH = ?, EVEFICAIP = ? WHERE EVEFICCOD = ?";
            $sql01  = "DELETE FROM [via].[EVEFIC] WHERE EVEFICCOD = ?";
            
            try {
                $connMSSQL  = getConnectionMSSQLv2();

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

    $app->delete('/v2/400/solicitud/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val00      = $request->getAttribute('codigo');
        $val02      = $request->getParsedBody()['estado_actual_codigo'];
        $val03      = $request->getParsedBody()['tipo_gerencia_codigo'];
        $val04      = $request->getParsedBody()['tipo_departamento_codigo'];
        $val05      = $request->getParsedBody()['tipo_jefatura_codigo'];
        $val06      = $request->getParsedBody()['tipo_cargo_codigo'];
        $val07      = $request->getParsedBody()['evento_codigo'];
        $val08      = $request->getParsedBody()['workflow_codigo'];
        $val09      = $request->getParsedBody()['solicitud_periodo'];
        $val10      = trim(strtoupper(strtolower($request->getParsedBody()['solicitud_motivo'])));
        $val11      = trim(strtoupper(strtolower($request->getParsedBody()['solicitud_pasaje'])));
        $val12      = trim(strtoupper(strtolower($request->getParsedBody()['solicitud_hospedaje'])));
        $val13      = trim(strtoupper(strtolower($request->getParsedBody()['solicitud_traslado'])));
        $val14      = trim(strtoupper(strtolower($request->getParsedBody()['solicitud_documento_solicitante'])));
        $val15      = trim(strtoupper(strtolower($request->getParsedBody()['solicitud_documento_jefatura'])));
        $val16      = trim(strtoupper(strtolower($request->getParsedBody()['solicitud_documento_ejecutivo'])));
        $val17      = trim(strtoupper(strtolower($request->getParsedBody()['solicitud_documento_proveedor'])));
        $val18      = $request->getParsedBody()['solicitud_fecha_carga'];
        $val19      = trim(strtoupper(strtolower($request->getParsedBody()['solicitud_sap_centro_costo'])));
        $val20      = $request->getParsedBody()['solicitud_tarea_cantidad'];
        $val21      = $request->getParsedBody()['solicitud_tarea_resuelta'];
        $val22      = trim(strtoupper(strtolower($request->getParsedBody()['solicitud_observacion'])));

        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        if (isset($val00) && isset($val01) && isset($val02) && isset($val03) && isset($val04) && isset($val05) && isset($val06) && isset($val07) && isset($val08)) {
            $sql00  = "UPDATE [via].[SOLFIC] SET SOLFICAUS = ?, SOLFICAFH = GETDATE(), SOLFICAIP = ? WHERE SOLFICCOD = ?";
            $sql01  = "DELETE FROM [via].[SOLFIC] WHERE SOLFICCOD = ?";
            
            try {
                $connMSSQL  = getConnectionMSSQLv2();

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

    $app->delete('/v2/400/solicitud/detalle/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val00      = $request->getAttribute('codigo');
        $val01      = $request->getParsedBody()['tipo_estado_codigo'];
        $val02      = $request->getParsedBody()['tipo_solicitud_codigo'];
        $val03      = $request->getParsedBody()['solicitud_codigo'];        
        $val04      = trim(strtoupper(strtolower($request->getParsedBody()['solicitud_detalle_preferencia'])));
        $val05      = $request->getParsedBody()['solicitud_detalle_salida_aeropuerto_codigo'];
        $val06      = $request->getParsedBody()['solicitud_detalle_salida_ciudad_codigo'];
        $val07      = $request->getParsedBody()['solicitud_detalle_salida_horario_codigo'];
        $val08      = trim(strtoupper(strtolower($request->getParsedBody()['solicitud_detalle_salida_lugar'])));
        $val09      = $request->getParsedBody()['solicitud_detalle_salida_fecha'];
        $val10      = trim(strtoupper(strtolower($request->getParsedBody()['solicitud_detalle_salida_hora'])));
        $val11      = $request->getParsedBody()['solicitud_detalle_retorno_aeropuerto_codigo'];
        $val12      = $request->getParsedBody()['solicitud_detalle_retorno_ciudad_codigo'];
        $val13      = $request->getParsedBody()['solicitud_detalle_retorno_horario_codigo'];
        $val14      = trim(strtoupper(strtolower($request->getParsedBody()['solicitud_detalle_retorno_lugar'])));
        $val15      = $request->getParsedBody()['solicitud_detalle_retorno_fecha'];
        $val16      = trim(strtoupper(strtolower($request->getParsedBody()['solicitud_detalle_retorno_hora'])));
        $val17      = $request->getParsedBody()['solicitud_detalle_auditorio_ciudad_codigo'];
        $val18      = $request->getParsedBody()['solicitud_detalle_auditorio_horario_codigo'];
        $val19      = trim(strtoupper(strtolower($request->getParsedBody()['solicitud_detalle_auditorio_lugar'])));
        $val20      = $request->getParsedBody()['solicitud_detalle_auditorio_fecha'];
        $val21      = trim(strtoupper(strtolower($request->getParsedBody()['solicitud_detalle_auditorio_hora'])));
        $val22      = $request->getParsedBody()['solicitud_detalle_auditorio_cantidad'];
        $val23      = trim(strtoupper(strtolower($request->getParsedBody()['solicitud_detalle_auditorio_formato_auditorio'])));
        $val24      = trim(strtoupper(strtolower($request->getParsedBody()['solicitud_detalle_auditorio_formato_escuela'])));
        $val25      = trim(strtoupper(strtolower($request->getParsedBody()['solicitud_detalle_auditorio_formato_mesa_u'])));
        $val26      = trim(strtoupper(strtolower($request->getParsedBody()['solicitud_detalle_auditorio_formato_mesa_junta'])));
        $val27      = trim(strtoupper(strtolower($request->getParsedBody()['solicitud_detalle_auditorio_audiovisual_requerido'])));
        $val28      = trim(strtoupper(strtolower($request->getParsedBody()['solicitud_detalle_auditorio_audiovisual_especificar'])));
        $val29      = trim(strtoupper(strtolower($request->getParsedBody()['solicitud_detalle_auditorio_alimentacion_requerido'])));
        $val30      = trim(strtoupper(strtolower($request->getParsedBody()['solicitud_detalle_auditorio_alimentacion_especificar'])));
        $val31      = trim(strtoupper(strtolower($request->getParsedBody()['solicitud_detalle_auditorio_interne_requerido'])));
        $val32      = trim(strtoupper(strtolower($request->getParsedBody()['solicitud_detalle_auditorio_internet_especificar'])));
        $val33      = trim(strtoupper(strtolower($request->getParsedBody()['solicitud_detalle_observacion'])));

        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        if (isset($val00) && isset($val01) && isset($val02) && isset($val03)) {
            $sql00  = "UPDATE [via].[SOLDET] SET SOLDETAUS = ?, SOLDETAFH = GETDATE(), SOLDETAIP = ? WHERE SOLDETCOD = ?";
            $sql01  = "DELETE FROM [via].[SOLDET] WHERE SOLDETCOD = ?";
            
            try {
                $connMSSQL  = getConnectionMSSQLv2();

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

    $app->delete('/v2/400/aerolinea/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val00      = $request->getAttribute('codigo');
        $val01      = $request->getParsedBody()['tipo_estado_codigo'];
        $val02      = $request->getParsedBody()['aerolinea_orden'];
        $val03      = $request->getParsedBody()['aerolinea_nombre'];
        $val04      = $request->getParsedBody()['aerolinea_observacion'];

        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        if (isset($val00) && isset($val01) && isset($val03)) { 
            $sql00  = "UPDATE [via].[AERFIC] SET AERFICAUS = ?, AERFICAFH = GETDATE(), AERFICAIP  = ? WHERE AERFICCOD = ?";
            $sql01  = "DELETE FROM [via].[AERFIC] WHERE AERFICCOD = ?";

            try {
                $connMSSQL  = getConnectionMSSQLv2();
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

    $app->delete('/v2/400/solicitud/opcion/adjunto/{codigo}', function($request) {//20201103//20201125
        require __DIR__.'/../src/connect.php';
        $val00      = $request->getParsedBody()['codigo'];
        $val01      = $request->getParsedBody()['tipo_estado_codigo'];
        $val02      = $request->getParsedBody()['tipo_documento_codigo'];
        $val03      = $request->getParsedBody()['solicitud_codigo'];
        $val04      = $request->getParsedBody()['solicitud_opcion_adjunto_codigo'];
        $val05      = trim(strtolower($request->getParsedBody()['solicitud_opcion_adjunto_pat']));
        $val06      = trim(strtoupper(strtolower($request->getParsedBody()['solicitud_opcion_adjunto_comentario'])));

        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        if (isset($val00) && isset($val01) && isset($val02) && isset($val03)) {
            $sql00  = "UPDATE [via].[SOLOPA] SET SOLOPAAUS = ?,	SOLOPAAFH = GETDATE(), SOLOPAAIP = ? WHERE SOLOPACOD = ?";
            $sql01  = "DELETE FROM [via].[SOLOPA] WHERE SOLOPACOD = ?";
            
            try {
                $connMSSQL  = getConnectionMSSQLv2();

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

    $app->delete('/v2/400/solicitud/opcion/cabecera/{codigo}', function($request) {//20201123
        require __DIR__.'/../src/connect.php';

        $val00      = $request->getAttribute('codigo');
        $val00_1    = $request->getParsedBody()['tipo_accion_codigo'];
        $val01      = $request->getParsedBody()['tipo_estado_codigo'];
        $val02      = $request->getParsedBody()['tipo_solicitud_codigo'];
        $val03      = $request->getParsedBody()['solicitud_codigo'];      
        $val04      = trim($request->getParsedBody()['solicitud_opcion_cabecera_nombre']);
        $val05      = $request->getParsedBody()['solicitud_opcion_cabecera_tarifa_importe'];
        $val06      = trim($request->getParsedBody()['solicitud_opcion_cabecera_reserva']);
        $val07      = trim($request->getParsedBody()['solicitud_opcion_cabecera_comentario_1']);
        $val08      = trim($request->getParsedBody()['solicitud_opcion_cabecera_comentario_2']);
        $val09      = trim($request->getParsedBody()['solicitud_opcion_cabecera_comentario_3']);
        $val10      = trim($request->getParsedBody()['solicitud_opcion_cabecera_comentario_4']);
        $val11      = trim(strtolower($request->getParsedBody()['solicitud_opcion_cabecera_directorio']));

        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        if (isset($val00)) {
            $sql00  = "UPDATE [via].[SOLOPC] SET SOLOPCAUS = ?,	SOLOPCAFH = GETDATE(), SOLOPCAIP = ? WHERE SOLOPCCOD = ?";
            $sql01  = "DELETE FROM [via].[SOLOPC] WHERE SOLOPCCOD = ?";
            
            try {
                $connMSSQL  = getConnectionMSSQLv2();

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

    $app->delete('/v2/400/solicitud/opcion/vuelo/{codigo}', function($request) {//20201124
        require __DIR__.'/../src/connect.php';

        $val00      = $request->getAttribute('codigo');
        $val01      = $request->getParsedBody()['tipo_estado_codigo'];
        $val02      = $request->getParsedBody()['solicitud_opcion_cabecera_codigo'];
        $val03      = $request->getParsedBody()['aerolinea_codigo'];
        $val04      = trim($request->getParsedBody()['solicitud_opcion_vuelo_vuelo']);
        $val05      = trim($request->getParsedBody()['solicitud_opcion_vuelo_companhia']);
        $val06      = trim($request->getParsedBody()['solicitud_opcion_vuelo_fecha']);
        $val07      = trim($request->getParsedBody()['solicitud_opcion_vuelo_desde']);
        $val08      = trim($request->getParsedBody()['solicitud_opcion_vuelo_hasta']);
        $val09      = trim($request->getParsedBody()['solicitud_opcion_vuelo_salida']);
        $val10      = trim($request->getParsedBody()['solicitud_opcion_vuelo_llegada']);
        $val11      = trim($request->getParsedBody()['solicitud_opcion_vuelo_observacion']);

        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        if (isset($val00) && isset($val01) && isset($val02) && isset($val03)) {
            $sql00  = "UPDATE [via].[SOLOPV] SET SOLOPVAUS = ?,	SOLOPVAFH = GETDATE(), SOLOPVAIP = ? WHERE SOLOPVCOD = ?";
            $sql01  = "DELETE FROM [via].[SOLOPV] WHERE SOLOPVCOD = ?";
            
            try {
                $connMSSQL  = getConnectionMSSQLv2();

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

    $app->delete('/v2/400/solicitud/opcion/hospedaje/{codigo}', function($request) {//20201124
        require __DIR__.'/../src/connect.php';

        $val00      = $request->getAttribute('codigo');
        $val01      = $request->getParsedBody()['tipo_estado_codigo'];
        $val02      = $request->getParsedBody()['tipo_habitacion_codigo'];
        $val03      = $request->getParsedBody()['solicitud_opcion_cabecera_codigo'];
        $val04      = trim($request->getParsedBody()['solicitud_opcion_hospedaje_hospedaje']);
        $val05      = trim($request->getParsedBody()['solicitud_opcion_hospedaje_direccion']);
        $val06      = $request->getParsedBody()['solicitud_opcion_hospedaje_fecha_checkin'];
        $val07      = $request->getParsedBody()['solicitud_opcion_hospedaje_fecha_checkout'];
        $val08      = $request->getParsedBody()['solicitud_opcion_hospedaje_cantidad_noche'];
        $val09      = $request->getParsedBody()['solicitud_opcion_hospedaje_tarifa_alimentacion'];
        $val10      = $request->getParsedBody()['solicitud_opcion_hospedaje_tarifa_lavanderia'];
        $val11      = $request->getParsedBody()['solicitud_opcion_hospedaje_tarifa_noche'];
        $val12      = trim($request->getParsedBody()['solicitud_opcion_hospedaje_observacion']);

        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        if (isset($val00) && isset($val01) && isset($val02) && isset($val03)) {
            $sql00  = "UPDATE [via].[SOLOPH] SET SOLOPHAUS = ?,	SOLOPHAFH = GETDATE(), SOLOPHAIP = ? WHERE SOLOPHCOD = ?";
            $sql01  = "DELETE FROM [via].[SOLOPH] WHERE SOLOPHCOD = ?";
            
            try {
                $connMSSQL  = getConnectionMSSQLv2();

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

    $app->delete('/v2/400/solicitud/opcion/traslado/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val00      = $request->getAttribute('codigo');
        $val01      = $request->getParsedBody()['tipo_estado_codigo'];
        $val02      = $request->getParsedBody()['tipo_traslado_codigo'];
        $val03      = $request->getParsedBody()['tipo_vehiculo_codigo'];
        $val04      = $request->getParsedBody()['solicitud_opcion_cabecera_codigo'];
        $val05      = trim($request->getParsedBody()['solicitud_opcion_traslado_traslado']);
        $val06      = trim($request->getParsedBody()['solicitud_opcion_traslado_salida']);
        $val07      = trim($request->getParsedBody()['solicitud_opcion_traslado_destino']);
        $val08      = trim($request->getParsedBody()['solicitud_opcion_traslado_fecha_salida']);
        $val09      = trim($request->getParsedBody()['solicitud_opcion_traslado_hora_salida']);
        $val10      = trim($request->getParsedBody()['solicitud_opcion_traslado_comentario']);
        $val11      = $request->getParsedBody()['solicitud_opcion_traslado_tarifa_dia'];
        $val12      = trim($request->getParsedBody()['solicitud_opcion_traslado_observacion']);

        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        if (isset($val00) && isset($val01) && isset($val02) && isset($val03) && isset($val04)) {
            $sql00  = "UPDATE [via].[SOLOPT] SET SOLOPTAUS = ?,	SOLOPTAFH = GETDATE(), SOLOPTAIP = ? WHERE SOLOPTCOD = ?";
            $sql01  = "DELETE FROM [via].[SOLOPT] WHERE SOLOPTCOD = ?";
            
            try {
                $connMSSQL  = getConnectionMSSQLv2();

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

/*MODULO VIAJE*/

/*MODULO RENDICION*/
    $app->delete('/v2/500/rendicion/detalle/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val00      = $request->getAttribute('codigo');
        $val00_1    = $request->getParsedBody()['tipo_accion_codigo'];
        $val01      = $request->getParsedBody()['estado_anterior_codigo'];
        $val02      = $request->getParsedBody()['estado_actual_codigo'];
        $val03      = $request->getParsedBody()['tipo_concepto_codigo'];
        $val04      = $request->getParsedBody()['tipo_alerta_codigo'];
        $val05      = $request->getParsedBody()['workflow_codigo'];
        $val06      = $request->getParsedBody()['rendicion_cabecera_codigo'];
        $val07      = trim($request->getParsedBody()['rendicion_detalle_descripcion']);
        $val08      = $request->getParsedBody()['rendicion_detalle_importe'];
        $val09      = trim(strtolower($request->getParsedBody()['rendicion_detalle_css']));
        $val10      = trim($request->getParsedBody()['rendicion_detalle_observacion']);

        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        if (isset($val00) && isset($val01) && isset($val02) && isset($val03) && isset($val04) && isset($val05) && isset($val06)) {  
            $sql00  = "UPDATE [con].[RENFDE] SET RENFDEAUS = ?, RENFDEAFH = GETDATE(), RENFDEAIP = ? WHERE RENFDECOD = ?";
            $sql01  = "DELETE [con].[RENFDE] WHERE RENFDECOD = ?";
            
            try {
                $connMSSQL  = getConnectionMSSQLv2();
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
/*MODULO RENDICION*/

/*MODULO OFICIAL*/
    $app->delete('/v2/600/colaborador/ficha/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val00      = $request->getAttribute('codigo');
        $val00_1    = $request->getParsedBody()['tipo_accion_codigo'];
        $val01      = $request->getParsedBody()['tipo_estado_codigo'];
        $val02      = $request->getParsedBody()['tipo_sexo_codigo'];
        $val03      = $request->getParsedBody()['tipo_rol_codigo'];
        $val04      = $request->getParsedBody()['localidad_nacionalidad_codigo'];
        $val05      = $request->getParsedBody()['persona_orden'];
        $val06      = trim(strtoupper(strtolower($request->getParsedBody()['persona_colaborador'])));
        $val07      = trim(strtoupper(strtolower($request->getParsedBody()['persona_nombre1'])));
        $val08      = trim(strtoupper(strtolower($request->getParsedBody()['persona_nombre2'])));
        $val09      = trim(strtoupper(strtolower($request->getParsedBody()['persona_apellido1'])));
        $val10      = trim(strtoupper(strtolower($request->getParsedBody()['persona_apellido2'])));
        $val11      = trim(strtoupper(strtolower($request->getParsedBody()['persona_apellido3'])));
        $val12      = $request->getParsedBody()['persona_fecha_nacimiento'];
        $val13      = trim(strtolower($request->getParsedBody()['persona_email']));
        $val14      = trim(strtolower($request->getParsedBody()['persona_foto']));
        $val15      = $request->getParsedBody()['persona_fecha_carga'];
        $val16      = trim($request->getParsedBody()['persona_observacion']);

        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        if (isset($val00) && isset($val00_1)) {  
            try {
                $sql00  = "UPDATE [ofi].[PERFIC] SET
                    PERFICAUS = ?,
                    PERFICAFH = GETDATE(),
                    PERFICAIP = ?
                    WHERE PERFICCOD = ?";

                $sql01  = "DELETE FROM [ofi].[PERFIC] WHERE PERFICCOD = ?";

                $connMSSQL  = getConnectionMSSQLv2();

                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL01= $connMSSQL->prepare($sql01);

                $stmtMSSQL00->execute([$aud01, $aud03, $val00]);
                $stmtMSSQL01->execute([$val00]);

                $stmtMSSQL00->closeCursor();
                $stmtMSSQL01->closeCursor();

                $stmtMSSQL00 = null;
                $stmtMSSQL01 = null;

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
/*MODULO OFICIAL*/