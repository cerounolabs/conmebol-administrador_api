<?php
    $app->put('/v2/100/dominio/{codigo}', function($request) {
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
            $sql00  = "UPDATE [adm].[DOMFIC] SET DOMFICEST = ?, DOMFICORD = ?, DOMFICNOI = ?, DOMFICNOC = ?, DOMFICNOP = ?, DOMFICPAT = ?, DOMFICCSS = ?, DOMFICPAR = ?, DOMFICICO = ?, DOMFICOBS = ?, DOMFICUSU = ?, DOMFICFEC = GETDATE(), DOMFICDIP = ? WHERE DOMFICCOD = ?";

            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val01, $val02, $val03, $val04, $val05, $val06, $val07, $val08, $val09, $val11, $aud01, $aud03, $val00]);

                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success UPDATE', 'codigo' => $val00), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtMSSQL00->closeCursor();
                $stmtMSSQL00 = null;
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

    $app->put('/v2/100/dominiosub', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getParsedBody()['tipo_dominio1_codigo'];
        $val02      = $request->getParsedBody()['tipo_dominio2_codigo'];
        $val03      = $request->getParsedBody()['tipo_estado_codigo'];
        $val04      = $request->getParsedBody()['tipo_orden'];
        $val05      = $request->getParsedBody()['tipo_path'];
        $val06      = $request->getParsedBody()['tipo_css'];
        $val07      = $request->getParsedBody()['tipo_parametro'];
        $val08      = $request->getParsedBody()['tipo_dominio'];
        $val09      = $request->getParsedBody()['tipo_observacion'];

        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        if (isset($val01) && isset($val02) && isset($val08)) {
            $sql00  = "UPDATE [adm].[DOMSUB] SET DOMSUBEST = ?, DOMSUBORD = ?, DOMSUBPAT = ?, DOMSUBCSS = ?, DOMSUBPAR = ?, DOMSUBOBS = ?, DOMSUBAUS = ?, DOMSUBAFE = GETDATE(), DOMSUBAIP = ? WHERE DOMSUBCO1 = ? AND DOMSUBCO2 = ? AND DOMSUBVAL = ?";
            
            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val03, $val04, $val05, $val06, $val07, $val09, $aud01, $aud03, $val01, $val02, $val07]);

                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success UPDATE', 'codigo' => 0), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtMSSQL00->closeCursor();
                $stmtMSSQL00 = null;
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

    $app->put('/v2/100/solicitud/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val00      = $request->getAttribute('codigo');
        $val01      = $request->getParsedBody()['tipo_estado_codigo'];
        $val02      = $request->getParsedBody()['tipo_orden_numero'];
        $val03      = $request->getParsedBody()['tipo_dia_cantidad'];
        $val04      = $request->getParsedBody()['tipo_dia_corrido'];
        $val05      = $request->getParsedBody()['tipo_dia_unidad'];
        $val06      = $request->getParsedBody()['tipo_archivo_adjunto'];
        $val07      = $request->getParsedBody()['tipo_observacion'];

        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        if (isset($val00)) {
            $sql00  = "UPDATE [adm].[DOMSOL] SET DOMSOLEST = ?, DOMSOLORD = ?, DOMSOLDIC = ?, DOMSOLDIO = ?, DOMSOLDIU = ?, DOMSOLADJ = ?, DOMSOLOBS = ?, DOMSOLUSU = ?, DOMSOLFEC = GETDATE(), DOMSOLDIP = ? WHERE DOMSOLCOD = ?";

            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val01, $val02, $val03, $val04, $val05, $val06, $val07, $aud01, $aud03, $val00]);

                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success UPDATE', 'codigo' => $val00), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtMSSQL00->closeCursor();
                $stmtMSSQL00 = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error INSERT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->put('/v2/100/pais/{codigo}', function($request) {
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
            $sql00  = "UPDATE [adm].[LOCPAI] SET LOCPAIEST = ?, LOCPAIORD = ?, LOCPAINOM = ?, LOCPAIPAT = ?, LOCPAIIC2 = ?, LOCPAIIC3 = ?, LOCPAIIN3 = ?, LOCPAIOBS = ?, LOCPAIAUS = ?, LOCPAIAFH = GETDATE(), LOCPAIAIP  = ? WHERE LOCPAICOD = ?";

            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val01, $val02, $val03, $val04, $val05, $val06, $val07, $val08, $aud01, $aud03, $val00]);

                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success UPDATE', 'codigo' => $val00), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtMSSQL00->closeCursor();
                $stmtMSSQL00 = null;
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

    $app->put('/v2/100/ciudad/{codigo}', function($request) {
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
            $sql00  = "UPDATE [adm].[LOCCIU] SET LOCCIUEST = ?, LOCCIUORD = ?, LOCCIUPAC = ?, LOCCIUNOM = ?, LOCCIUOBS = ?, LOCCIUAUS = ?, LOCCIUAFH = GETDATE(), LOCCIUAIP  = ? WHERE LOCCIUCOD = ?";

            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val01, $val02, $val03, $val04, $val05, $aud01, $aud03, $val00]);

                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success UPDATE', 'codigo' => $val00), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtMSSQL00->closeCursor();
                $stmtMSSQL00 = null;
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

    $app->put('/v2/100/aeropuerto/{codigo}', function($request) {
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
            $sql00  = "UPDATE [adm].[LOCAER] SET LOCAEREST = ?, LOCAERORD = ?, LOCAERPAC = ?, LOCAERNOM = ?, LOCAEROBS = ?, LOCAERAUS = ?, LOCAERAFH = GETDATE(), LOCAERAIP  = ? WHERE LOCAERCOD = ?";

            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val01, $val02, $val03, $val04, $val05, $aud01, $aud03, $val00]);

                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success UPDATE', 'codigo' => $val00), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtMSSQL00->closeCursor();
                $stmtMSSQL00 = null;
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

    $app->put('/v2/200/solicitudes/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val00      = $request->getAttribute('codigo');
        $val01      = $request->getParsedBody()['tipo_estado_codigo'];
        $val02      = $request->getParsedBody()['solicitud_codigo'];
        $val03      = $request->getParsedBody()['solicitud_observacion'];
        $val04      = $request->getParsedBody()['solicitud_usuario'];
        $val05      = $request->getParsedBody()['solicitud_fecha_hora'];
        $val06      = $request->getParsedBody()['solicitud_ip'];
        $val07      = $request->getParsedBody()['tipo_accion_codigo'];

        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        if (isset($val00)) {
            if ($val07 === 'J'){
                $sql00  = "UPDATE [hum].[SOLFIC] SET SOLFICEST = ?, SOLFICOBS = ?, SOLFICUSS = ?, SOLFICFCS = GETDATE(), SOLFICIPS = ?, SOLFICUSU = ?, SOLFICFEC = GETDATE(), SOLFICDIP = ? WHERE SOLFICCOD = ?";
            } else {
                $sql00  = "UPDATE [hum].[SOLFIC] SET SOLFICEST = ?, SOLFICOBT = ?, SOLFICUST = ?, SOLFICFCT = GETDATE(), SOLFICIPT = ?, SOLFICUSU = ?, SOLFICFEC = GETDATE(), SOLFICDIP = ? WHERE SOLFICCOD = ?";
            }

            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val01, $val03, $val04, $val06, $aud01, $aud03, $val00]);

                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success UPDATE', 'codigo' => $val00), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtMSSQL00->closeCursor();
                $stmtMSSQL00 = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error INSERT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->put('/v2/200/exportar/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val00      = $request->getAttribute('codigo');

        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        if (isset($val00)) {
            $sql00  = "UPDATE [hum].[SOLAXI] SET SOLFICEST = ?, SOLAXIUSU = ?, SOLAXIFEC = GETDATE(), SOLAXIDIP = ? WHERE SOLAXICOD = ?";

            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute(['E', $aud01, $aud03, $val00]);

                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success UPDATE', 'codigo' => $val00), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtMSSQL00->closeCursor();
                $stmtMSSQL00 = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error INSERT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->put('/v2/200/comprobante/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val00      = $request->getAttribute('codigo');
        $val01      = $request->getParsedBody()['tipo_estado_codigo'];
        $val02      = $request->getParsedBody()['comprobante_observacion'];

        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        if (isset($val00)) {
            if ($val01 == 40){
                $sql00  = "UPDATE [hum].[COMFIC] SET COMFICEST = ?, COMFICUSU = ?, COMFICFEC = GETDATE(), COMFICDIP = ? WHERE COMFICCOD = ?";
            } else {
                $sql00  = "UPDATE [hum].[COMFIC] SET COMFICEST = ?, COMFICOBS = ?, COMFICUSU = ?, COMFICFEC = GETDATE(), COMFICDIP = ? WHERE COMFICCOD = ?";
            }

            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);

                if ($val01 == 40){
                    $stmtMSSQL00->execute([$val01, $aud01, $aud03, $val00]);
                } else {
                    $stmtMSSQL00->execute([$val01, $val02, $aud01, $aud03, $val00]);
                }

                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success UPDATE', 'codigo' => $val00), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtMSSQL00->closeCursor();
                $stmtMSSQL00 = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error INSERT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

/*MODULO WORKFLOW*/
    $app->put('/v2/300/workflow/cabecera/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val00      = $request->getAttribute('codigo');
        $val01      = $request->getParsedBody()['tipo_estado_codigo'];
        $val02      = $request->getParsedBody()['tipo_workflow_codigo'];
        $val03      = $request->getParsedBody()['tipo_evento_codigo'];
        $val04      = $request->getParsedBody()['tipo_cargo_codigo'];
        $val05      = $request->getParsedBody()['workflow_anterior_codigo'];
        $val06      = $request->getParsedBody()['workflow_orden'];
        $val07      = $request->getParsedBody()['workflow_tarea'];
        $val08      = $request->getParsedBody()['workflow_observacion'];

        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        if (isset($val00) && isset($val01) && isset($val02) && isset($val03) && isset($val04)) {        
            $sql00  = "UPDATE [wrf].[WRFFIC] SET WRFFICEST = ?, WRFFICTEC = ?, WRFFICTCC = ?, WRFFICWAC = ?, WRFFICORD = ?, WRFFICNOM = ?, WRFFICOBS = ?, WRFFICAUS = ?, WRFFICAFE = GETDATE(), WRFFICAIP = ? WHERE WRFFICCOD = ? AND WRFFICTWC = ?";
            
            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);

                $stmtMSSQL00->execute([$val01, $val03, $val04, $val05, $val06, $val07, $val08, $aud01, $aud03, $val00, $val02]);

                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success UPDATE', 'codigo' => $val00), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtMSSQL00->closeCursor();

                $stmtMSSQL00 = null;
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
/*MODULO WORKFLOW*/

/*MODULO VIAJE*/
    $app->put('/v2/400/proveedor/{codigo}', function($request) {
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
            $sql00  = "UPDATE [via].[PROFIC] SET PROFICEST = ?, PROFICTPC = ?, PROFICCIC = ?, PROFICNOM = ?, PROFICRAZ = ?, PROFICRUC = ?, PROFICDIR = ?, PROFICSPC = ?, PROFICSPI = ?, PROFICOBS = ?, PROFICAUS = ?, PROFICAFH = GETDATE(), PROFICAIP = ? WHERE PROFICCOD = ?";
            
            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val01, $val02, $val03, $val04, $val05, $val06, $val07, $val08, $val09, $val10, $aud01, $aud03, $val00]);
                $stmtMSSQL00->closeCursor();
                $stmtMSSQL00= null;

                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success UPDATE', 'codigo' => $val00), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
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

    $app->put('/v2/400/proveedor/contacto/{codigo}', function($request) {
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
            $sql00  = "UPDATE [via].[PROCON] SET PROCONEST = ?, PROCONNOM = ?, PROCONEMA = ?, PROCONTEL = ?, PROCONWHA = ?, PROCONSKY = ?, PROCONOBS = ?, PROCONAUS = ?, PROCONAFH = GETDATE(), PROCONAIP = ? WHERE PROCONCOD = ?";
            
            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);

                $stmtMSSQL00->execute([$val01, $val03, $val04, $val05, $val06, $val07, $val08, $aud01, $aud03, $val00]);

                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success UPDATE', 'codigo' => $val00), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtMSSQL00->closeCursor();

                $stmtMSSQL00 = null;
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

    $app->put('/v2/400/proveedor/habitacion/{codigo}', function($request) {
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
            $sql00  = "UPDATE [via].[PROHAB] SET PROHABEST = ?, PROHABTHC = ?, PROHABNOM = ?, PROHABPRE = ?, PROHABCAN = ?, PROHABPAT = ?, PROHABOBS = ?, PROHABAUS = ?, PROHABAFH = GETDATE(), PROHABAIP = ? WHERE PROHABCOD = ?";
            
            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);

                $stmtMSSQL00->execute([$val01, $val02, $val04, $val05, $val06, $val07, $val08, $aud01, $aud03, $val00]);

                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success UPDATE', 'codigo' => $val00), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtMSSQL00->closeCursor();

                $stmtMSSQL00 = null;
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

    $app->put('/v2/400/proveedor/imagen/{codigo}', function($request) {
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
            $sql00  = "UPDATE [via].[PROIMA] SET PROIMAEST = ?, PROIMAPAT = ?, PROIMAOBS = ?, PROIMAAUS = ?, PROIMAAFH = GETDATE(), PROIMAAIP = ? WHERE PROIMACOD = ?";
            
            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);

                $stmtMSSQL00->execute([$val01, $val03, $val04, $aud01, $aud03, $val00]);

                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success UPDATE', 'codigo' => $val00), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtMSSQL00->closeCursor();

                $stmtMSSQL00 = null;
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

    $app->put('/v2/400/evento/{codigo}', function($request) {
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
            $sql00  = "UPDATE [via].[EVEFIC] SET EVEFICEST = ?, EVEFICTEC = ?, EVEFICCIC = ?, EVEFICORD = ?, EVEFICNOM = ?, EVEFICFVI = ?, EVEFICFVF = ?, EVEFICOBS = ?, EVEFICAUS = ?, EVEFICAFH = GETDATE(), EVEFICAIP = ? WHERE EVEFICCOD = ?";
            
            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);

                $stmtMSSQL00->execute([$val01, $val02, $val03, $val04, $val05, $val06, $val07, $val08, $aud01, $aud03, $val00]);

                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success UPDATE', 'codigo' => $val00), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtMSSQL00->closeCursor();

                $stmtMSSQL00 = null;
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

    $app->put('/v2/400/solicitud/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val00      = $request->getAttribute('codigo');
        $val00_1    = $request->getParsedBody()['tipo_accion_codigo'];
        $val01      = $request->getParsedBody()['estado_anterior_codigo'];
        $val02      = $request->getParsedBody()['estado_actual_codigo'];
        $val03      = $request->getParsedBody()['tipo_prioridad_codigo'];
        $val04      = $request->getParsedBody()['tipo_dificultad_codigo'];
        $val05      = $request->getParsedBody()['tipo_gerencia_codigo'];
        $val06      = $request->getParsedBody()['tipo_departamento_codigo'];
        $val07      = $request->getParsedBody()['tipo_jefatura_codigo'];
        $val08      = $request->getParsedBody()['tipo_cargo_codigo'];
        $val09      = $request->getParsedBody()['evento_codigo'];
        $val10      = $request->getParsedBody()['workflow_codigo'];
        $val11      = $request->getParsedBody()['solicitud_periodo'];
        $val12      = trim(strtoupper(strtolower($request->getParsedBody()['solicitud_motivo'])));
        $val13      = trim(strtoupper(strtolower($request->getParsedBody()['solicitud_pasaje'])));
        $val14      = trim(strtoupper(strtolower($request->getParsedBody()['solicitud_hospedaje'])));
        $val15      = trim(strtoupper(strtolower($request->getParsedBody()['solicitud_traslado'])));
        $val16      = trim(strtoupper(strtolower($request->getParsedBody()['solicitud_tarifa'])));
        $val17      = trim(strtoupper(strtolower($request->getParsedBody()['solicitud_proveedor_hospedaje'])));
        $val18      = trim(strtoupper(strtolower($request->getParsedBody()['solicitud_proveedor_traslado'])));
        $val19      = trim(strtoupper(strtolower($request->getParsedBody()['solicitud_documento_solicitante'])));
        $val20      = trim(strtoupper(strtolower($request->getParsedBody()['solicitud_documento_jefatura'])));
        $val21      = trim(strtoupper(strtolower($request->getParsedBody()['solicitud_documento_ejecutivo'])));
        $val22      = trim(strtoupper(strtolower($request->getParsedBody()['solicitud_documento_proveedor'])));
        $val23      = $request->getParsedBody()['solicitud_fecha_carga'];
        $val24      = trim(strtoupper(strtolower($request->getParsedBody()['solicitud_sap_centro_costo'])));
        $val25      = $request->getParsedBody()['solicitud_tarea_cantidad'];
        $val26      = $request->getParsedBody()['solicitud_tarea_resuelta'];
        $val27      = trim(strtoupper(strtolower($request->getParsedBody()['solicitud_observacion'])));

        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        if (isset($val00) && isset($val00_1)) {
            $sql00  = "";

            switch ($val00_1) {
                case 1:
                    $sql00  = "UPDATE [via].[SOLFIC] SET SOLFICEVC = ?, SOLFICMOT = ?, SOLFICPAS = ?, SOLFICHOS = ?, SOLFICTRA = ?, SOLFICSCC = ?, SOLFICOBS = ?, SOLFICAUS = ?, SOLFICAFH = GETDATE(), SOLFICAIP = ? WHERE SOLFICCOD = ?";
                    break;

                case 2:
                    $sql00  = "UPDATE [via].[SOLFIC] SET SOLFICEAC = ?, SOLFICECC = ?, SOLFICAUS = ?, SOLFICAFH = GETDATE(), SOLFICAIP = ? WHERE SOLFICCOD = ?";
                    break;

                case 3:
                    $sql00  = "UPDATE [via].[SOLFIC] SET SOLFICDNE = ?, SOLFICAUS = ?, SOLFICAFH = GETDATE(), SOLFICAIP = ? WHERE SOLFICCOD = ?";
                    break;

                case 4:
                    $sql00  = "UPDATE [via].[SOLFIC] SET SOLFICDNP = ?, SOLFICAUS = ?, SOLFICAFH = GETDATE(), SOLFICAIP = ? WHERE SOLFICCOD = ?";
                    break;

                case 5:
                    $sql00  = "UPDATE [via].[SOLFIC] SET SOLFICEAC = ?, SOLFICECC = ?, SOLFICAUS = ?, SOLFICAFH = GETDATE(), SOLFICAIP = ? WHERE SOLFICCOD = ?";
                    break;

                case 6:
                    $sql00  = "UPDATE [via].[SOLFIC] SET SOLFICEVC = ?, SOLFICAUS = ?, SOLFICAFH = GETDATE(), SOLFICAIP = ? WHERE SOLFICCOD = ?";
                    break;

                case 7:
                    $sql00  = "UPDATE [via].[SOLFIC] SET SOLFICTPC = ?, SOLFICAUS = ?, SOLFICAFH = GETDATE(), SOLFICAIP = ? WHERE SOLFICCOD = ?";
                    break;

                case 8:
                    $sql00  = "UPDATE [via].[SOLFIC] SET SOLFICTDC = ?, SOLFICAUS = ?, SOLFICAFH = GETDATE(), SOLFICAIP = ? WHERE SOLFICCOD = ?";
                    break;

                case 9:
                    $sql00  = "UPDATE [via].[SOLFIC] SET SOLFICTAR = ?, SOLFICAUS = ?, SOLFICAFH = GETDATE(), SOLFICAIP = ? WHERE SOLFICCOD = ?";
                    break;

                case 10:
                    $sql00  = "UPDATE [via].[SOLFIC] SET SOLFICPHO = ?, SOLFICAUS = ?, SOLFICAFH = GETDATE(), SOLFICAIP = ? WHERE SOLFICCOD = ?";
                    break;

                case 11:
                    $sql00  = "UPDATE [via].[SOLFIC] SET SOLFICPTR = ?, SOLFICAUS = ?, SOLFICAFH = GETDATE(), SOLFICAIP = ? WHERE SOLFICCOD = ?";
                    break;

                case 12:
                    $sql00  = "UPDATE [via].[SOLFIC] SET SOLFICSCC = ?, SOLFICAUS = ?, SOLFICAFH = GETDATE(), SOLFICAIP = ? WHERE SOLFICCOD = ?";
                    break;
            }

            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);

                switch ($val00_1) {
                    case 1:
                        $stmtMSSQL00->execute([$val09, $val12, $val13, $val14, $val15, $val24, $val27, $aud01, $aud03, $val00]);
                        break;

                    case 2:
                        $stmtMSSQL00->execute([$val01, $val02, $aud01, $aud03, $val00]);
                        break;

                    case 3:
                        $stmtMSSQL00->execute([$val21, $aud01, $aud03, $val00]);
                        break;

                    case 4:
                        $stmtMSSQL00->execute([$val22, $aud01, $aud03, $val00]);
                        break;

                    case 5:
                        $stmtMSSQL00->execute([$val01, $val02, $aud01, $aud03, $val00]);
                        break;

                    case 6:
                        $stmtMSSQL00->execute([$val09, $aud01, $aud03, $val00]);
                        break;

                    case 7:
                        $stmtMSSQL00->execute([$val03, $aud01, $aud03, $val00]);
                        break;

                    case 8:
                        $stmtMSSQL00->execute([$val04, $aud01, $aud03, $val00]);
                        break;

                    case 9:
                        $stmtMSSQL00->execute([$val16, $aud01, $aud03, $val00]);
                        break;

                    case 10:
                        $stmtMSSQL00->execute([$val17, $aud01, $aud03, $val00]);
                        break;

                    case 11:
                        $stmtMSSQL00->execute([$val18, $aud01, $aud03, $val00]);
                        break;

                    case 12:
                        $stmtMSSQL00->execute([$val24, $aud01, $aud03, $val00]);
                        break;
                }

                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success UPDATE', 'codigo' => $val00), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtMSSQL00->closeCursor();

                $stmtMSSQL00 = null;
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

    $app->put('/v2/400/solicitud/detalle/vuelo/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val00      = $request->getAttribute('codigo');
        $val01      = 2;
        $val02      = $request->getParsedBody()['tipo_horario_salida_codigo'];
        $val03      = $request->getParsedBody()['tipo_horario_retorno_codigo'];
        $val04      = trim(strtoupper(strtolower($request->getParsedBody()['tipo_vuelo_codigo'])));
        $val05      = $request->getParsedBody()['solicitud_codigo']; 
        $val06      = $request->getParsedBody()['localidad_ciudad_origen_codigo'];
        $val07      = $request->getParsedBody()['localidad_ciudad_destino_codigo'];
        $val08      = trim($request->getParsedBody()['solicitud_detalle_vuelo_comentario']);
        $val09      = $request->getParsedBody()['solicitud_detalle_vuelo_fecha_salida'];
        $val10      = $request->getParsedBody()['solicitud_detalle_vuelo_fecha_retorno'];

        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        if (isset($val01) && isset($val04) && isset($val05)) {
            $sql00  = "UPDATE [via].[SOLVUE] SET SOLVUEEST = (SELECT DOMFICCOD FROM adm.DOMFIC WHERE DOMFICVAL = 'SOLICITUDESTADODETALLE' AND DOMFICPAR = ?), SOLVUETSC = (SELECT DOMFICCOD FROM adm.DOMFIC WHERE DOMFICVAL = 'SOLICITUDHORARIO' AND DOMFICPAR = ?), SOLVUETRC = (SELECT DOMFICCOD FROM adm.DOMFIC WHERE DOMFICVAL = 'SOLICITUDHORARIO' AND DOMFICPAR = ?), SOLVUETVC = ?, SOLVUECOC = ?, SOLVUECDC = ?, SOLVUECOM = ?, SOLVUEFSA = ?, SOLVUEFRE = ?, SOLVUEAUS = ?, SOLVUEAFH = GETDATE(), SOLVUEAIP = ? WHERE SOLVUECOD = ?";
            
            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);

                $stmtMSSQL00->execute([$val01, $val02, $val03, $val04, $val06, $val07, $val08, $val09, $val10, $aud01, $aud03, $val00]);

                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success UPDATE', 'codigo' => $val00), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtMSSQL00->closeCursor();

                $stmtMSSQL00 = null;
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

    $app->put('/v2/400/solicitud/detalle/hospedaje/{codigo}', function($request) {//20201102
        require __DIR__.'/../src/connect.php';

        $val00      = $request->getAttribute('codigo');
        $val01      = $request->getParsedBody()['tipo_estado_codigo'];
        $val02      = $request->getParsedBody()['solicitud_codigo'];
        $val03      = $request->getParsedBody()['localidad_ciudad_destino_codigo'];
        $val04      = trim($request->getParsedBody()['solicitud_detalle_hospedaje_comentario']);
        $val05      = trim($request->getParsedBody()['solicitud_detalle_hospedaje_alimentacion']);
        $val06      = trim($request->getParsedBody()['solicitud_detalle_hospedaje_lavanderia']);
        $val07      = $request->getParsedBody()['solicitud_detalle_hospedaje_fecha_checkin']; 
        $val08      = $request->getParsedBody()['solicitud_detalle_hospedaje_fecha_checkout'];
        $val09      = $request->getParsedBody()['solicitud_detalle_hospedaje_cantidad_noche'];

        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        if (isset($val00) && isset($val01) && isset($val02) && isset($val03)) {
            $sql00 = "UPDATE [via].[SOLHOS] SET SOLHOSEST = (SELECT DOMFICCOD FROM adm.DOMFIC WHERE DOMFICVAL = 'SOLICITUDESTADODETALLE' AND DOMFICPAR = ?), SOLHOSSOC = ?, SOLHOSCDC = ?, SOLHOSCOM = ?, SOLHOSALI = ?, SOLHOSLAV = ?, SOLHOSFIN = ?, SOLHOSFOU = ?, SOLHOSCNO = ?, SOLHOSAUS = ?, SOLHOSAFH = GETDATE(), SOLHOSAIP = ? WHERE SOLHOSCOD = ?";
            try { 
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);

                $stmtMSSQL00->execute([$val01, $val02, $val03, $val04, $val05, $val06, $val07, $val08, $val09, $aud01, $aud03, $val00]);

                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success UPDATE', 'codigo' => $val00), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtMSSQL00->closeCursor();

                $stmtMSSQL00 = null;
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

    $app->put('/v2/400/solicitud/detalle/traslado/{codigo}', function($request) {//20201102
        require __DIR__.'/../src/connect.php';

        $val00      = $request->getAttribute('codigo');
        $val01      = $request->getParsedBody()['tipo_estado_codigo'];
        $val02      = trim(strtoupper(strtolower($request->getParsedBody()['tipo_traslado_codigo'])));
        $val03      = $request->getParsedBody()['solicitud_codigo']; 
        $val04      = trim($request->getParsedBody()['solicitud_detalle_traslado_comentario']);
        $val05      = trim($request->getParsedBody()['solicitud_detalle_traslado_origen']);
        $val06      = trim($request->getParsedBody()['solicitud_detalle_traslado_destino']);
        $val07      = $request->getParsedBody()['solicitud_detalle_traslado_fecha'];
        $val08      = $request->getParsedBody()['solicitud_detalle_traslado_hora'];

        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        if (isset($val00) && isset($val01) && isset($val02) && isset($val03)) {
            $sql00 = "UPDATE [via].[SOLTRA] SET SOLTRAEST = (SELECT DOMFICCOD FROM adm.DOMFIC WHERE DOMFICVAL = 'SOLICITUDESTADODETALLE' AND DOMFICPAR = ?), SOLVUETTC = ?, SOLTRASOC = ?, SOLTRACOM = ?, SOLTRASAL = ?, SOLTRADES = ?, SOLTRAFSA = ?, SOLTRAHSA = ?, SOLTRAAUS = ?, SOLTRAAFH = GETDATE(), SOLTRAAIP = ? WHERE SOLTRACOD = ?";
                                                                                                                                                     
            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);

                $stmtMSSQL00->execute([$val01, $val02, $val03, $val04, $val05, $val06, $val07, $val08, $aud01, $aud03, $val00]);

                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success UPDATE', 'codigo' => $val00), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtMSSQL00->closeCursor();

                $stmtMSSQL00 = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error UPDATE: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => $val00.', '.$val01.', '.$val02.', '.$val03), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->put('/v2/400/solicitud/notificacion/{codigo}', function($request) {//20201102
        require __DIR__.'/../src/connect.php';

        $val00      = $request->getAttribute('codigo');
        $val01      = $request->getParsedBody()['tipo_estado_codigo'];
        $val02      = $request->getParsedBody()['tipo_consulta_codigo'];
        $val03      = $request->getParsedBody()['solicitud_codigo'];
        $val04      = trim($request->getParsedBody()['solicitud_consulta_persona_documento']);
        $val05      = trim($request->getParsedBody()['solicitud_consulta_persona_nombre']);
        $val06      = trim($request->getParsedBody()['solicitud_consulta_fecha']);
        $val07      = trim($request->getParsedBody()['solicitud_consulta_comentario']);

        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        if (isset($val00) && isset($val01) && isset($val02) && isset($val03)) {
            $sql00 = "UPDATE [via].[SOLCON] SET SOLCONEST = (SELECT DOMFICCOD FROM adm.DOMFIC WHERE DOMFICVAL = 'SOLICITUDESTADOCONSULTA' AND DOMFICPAR = ?), SOLCONAUS = ?, SOLCONAFH = GETDATE(), SOLCONAIP = ? WHERE SOLCONCOD = ?";
                                                                                                                                                     
            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);

                $stmtMSSQL00->execute([$val01, $aud01, $aud03, $val00]);

                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success UPDATE', 'codigo' => $val00), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtMSSQL00->closeCursor();

                $stmtMSSQL00 = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error UPDATE: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => $val00.', '.$val01.', '.$val02.', '.$val03), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->put('/v2/400/solicitud/opcioncabecera/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val00      = $request->getAttribute('codigo');
        $val00_1    = $request->getParsedBody()['tipo_accion_codigo'];
        $val01      = $request->getParsedBody()['tipo_estado_codigo'];
        $val02      = $request->getParsedBody()['tipo_solicitud_codigo'];
        $val03      = $request->getParsedBody()['solicitud_codigo'];
        $val04      = $request->getParsedBody()['proveedor_codigo'];        
        $val05      = trim(strtoupper(strtolower($request->getParsedBody()['solicitud_opcioncabecera_nombre'])));
        $val06      = $request->getParsedBody()['solicitud_opcioncabecera_tarifa_importe'];
        $val07      = trim(strtoupper(strtolower($request->getParsedBody()['solicitud_opcioncabecera_visualiza_solicitante'])));
        $val08      = trim(strtoupper(strtolower($request->getParsedBody()['solicitud_opcioncabecera_visualiza_jefatura'])));
        $val09      = trim(strtoupper(strtolower($request->getParsedBody()['solicitud_opcioncabecera_visualiza_ejecutivo'])));
        $val10      = trim(strtoupper(strtolower($request->getParsedBody()['solicitud_opcioncabecera_visualiza_proveedor'])));
        $val11      = trim(strtoupper(strtolower($request->getParsedBody()['solicitud_opcioncabecera_reserva'])));
        $val12      = trim(strtoupper(strtolower($request->getParsedBody()['solicitud_opcioncabecera_comentario_1'])));
        $val13      = trim(strtoupper(strtolower($request->getParsedBody()['solicitud_opcioncabecera_comentario_2'])));
        $val14      = trim(strtoupper(strtolower($request->getParsedBody()['solicitud_opcioncabecera_comentario_3'])));
        $val15      = trim(strtoupper(strtolower($request->getParsedBody()['solicitud_opcioncabecera_comentario_4'])));

        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        if (isset($val00) && isset($val00_1)) {
            switch ($val00_1) {
                case 1:
                    $sql00  = "UPDATE [via].[SOLOPC] SET SOLOPCEST = ?, SOLOPCPRC = ?, SOLOPCOPC = ?, SOLOPCTIM = ?, SOLOPCTVS = ?, SOLOPCTVJ = ?, SOLOPCTVE = ?, SOLOPCTVP = ?, SOLOPCRES = ?, SOLOPCCO1 = ?, SOLOPCCO2 = ?, SOLOPCCO3 = ?, SOLOPCCO4 = ?, SOLOPCAUS = ?, SOLOPCAFH = GETDATE(), SOLOPCAIP = ? WHERE SOLOPCCOD = ?";
                    break;
                
                case 2:
                    $sql00  = "UPDATE [via].[SOLOPC] SET SOLOPCEST = (SELECT DOMFICCOD FROM adm.DOMFIC WHERE DOMFICVAL = 'SOLICITUDESTADOOPCION' AND DOMFICPAR = ?), SOLOPCAUS = ?, SOLOPCAFH = GETDATE(), SOLOPCAIP = ? WHERE SOLOPCCOD = ?";
                    break;

                case 3:
                    $sql00  = "UPDATE [via].[SOLOPC] SET SOLOPCEST = (SELECT DOMFICCOD FROM adm.DOMFIC WHERE DOMFICVAL = 'SOLICITUDESTADOOPCION' AND DOMFICPAR = ?), SOLOPCAUS = ?, SOLOPCAFH = GETDATE(), SOLOPCAIP = ? WHERE SOLOPCSOC = ?";
                    $sql01  = "UPDATE [via].[SOLOPC] SET SOLOPCEST = (SELECT DOMFICCOD FROM adm.DOMFIC WHERE DOMFICVAL = 'SOLICITUDESTADOOPCION' AND DOMFICPAR = ?), SOLOPCAUS = ?, SOLOPCAFH = GETDATE(), SOLOPCAIP = ? WHERE SOLOPCCOD = ?";
                    break;
            }
            
            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);

                switch ($val00_1) {
                    case 1:
                        $stmtMSSQL00->execute([$val01, $val04, $val05, $val06, $val07, $val08, $val09, $val10, $val11, $val12, $val13, $val14, $val15, $aud01, $aud03, $val00]);
                        break;
                    
                    case 2:
                        $stmtMSSQL00->execute([$val01, $aud01, $aud03, $val00]);
                        break;

                    case 3:
                        $stmtMSSQL01= $connMSSQL->prepare($sql01);

                        $stmtMSSQL00->execute([4, $aud01, $aud03, $val03]);
                        $stmtMSSQL01->execute([$val01, $aud01, $aud03, $val00]);

                        $stmtMSSQL01->closeCursor();
                        $stmtMSSQL01 = null;

                        break;
                }
                
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success UPDATE', 'codigo' => $val00), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtMSSQL00->closeCursor();

                $stmtMSSQL00 = null;
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

    $app->put('/v2/400/solicitud/opcionvuelo/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val00      = $request->getAttribute('codigo');
        $val00_1    = $request->getParsedBody()['tipo_accion_codigo'];
        $val01      = $request->getParsedBody()['tipo_estado_codigo'];
        $val02      = $request->getParsedBody()['solicitud_opcioncabecera_codigo'];
        $val03      = $request->getParsedBody()['aerolinea_codigo'];
        $val04      = trim(strtoupper(strtolower($request->getParsedBody()['solicitud_opcionvuelo_vuelo'])));
        $val05      = trim(strtoupper(strtolower($request->getParsedBody()['solicitud_opcionvuelo_companhia'])));
        $val06      = trim(strtoupper(strtolower($request->getParsedBody()['solicitud_opcionvuelo_fecha'])));
        $val07      = trim(strtoupper(strtolower($request->getParsedBody()['solicitud_opcionvuelo_desde'])));
        $val08      = trim(strtoupper(strtolower($request->getParsedBody()['solicitud_opcionvuelo_hasta'])));
        $val09      = trim(strtoupper(strtolower($request->getParsedBody()['solicitud_opcionvuelo_salida'])));
        $val10      = trim(strtoupper(strtolower($request->getParsedBody()['solicitud_opcionvuelo_llegada'])));
        $val11      = trim(strtoupper(strtolower($request->getParsedBody()['solicitud_opcionvuelo_observacion'])));

        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        if (isset($val00) && isset($val00_1)) {
            switch ($val00_1) {
                case 1:
                    $sql00  = "UPDATE [via].[SOLOPV] SET SOLOPVEST = ?, SOLOPVAEC = ?, SOLOPVVUE = ?, SOLOPVCOM = ?, SOLOPVFEC = ?, SOLOPVDES = ?, SOLOPVHAS = ?, SOLOPVSAL = ?, SOLOPVLLE = ?, SOLOPVOBS = ?, SOLOPVAUS = ?, SOLOPVAFH = GETDATE(), SOLOPVAIP = ? WHERE SOLOPVCOD = ?";
                    break;
                
                case 2:
                    $sql00  = "UPDATE [via].[SOLOPV] SET SOLOPVEST = (SELECT DOMFICCOD FROM adm.DOMFIC WHERE DOMFICVAL = 'SOLICITUDESTADOOPCION' AND DOMFICPAR = ?), SOLOPVAUS = ?, SOLOPVAFH = GETDATE(), SOLOPVAIP = ? WHERE SOLOPVCOD = ?";
                    break;
            }
            
            
            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);

                switch ($val00_1) {
                    case 1:
                        $stmtMSSQL00->execute([$val01, $val03, $val04, $val05, $val06, $val07, $val08, $val09, $val10, $val11, $aud01, $aud03, $val00]);
                        break;
                    
                    case 2:
                        $stmtMSSQL00->execute([$val01, $aud01, $aud03, $val00]);
                        break;
                }

                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success UPDATE', 'codigo' => $val00), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtMSSQL00->closeCursor();

                $stmtMSSQL00 = null;
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

    $app->put('/v2/400/aerolinea/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val00      = $request->getAttribute('codigo');
        $val01      = $request->getParsedBody()['tipo_estado_codigo'];
        $val02      = $request->getParsedBody()['aerolinea_orden'];
        $val03      = trim(strtoupper(strtolower($request->getParsedBody()['aerolinea_nombre'])));
        $val04      = trim(strtoupper(strtolower($request->getParsedBody()['aerolinea_observacion'])));

        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        if (isset($val00) && isset($val01) && isset($val03)) { 
            $sql00  = "UPDATE [via].[AERFIC] SET AERFICEST = ?, AERFICORD = ?, AERFICNOM = ?, AERFICOBS = ?, AERFICAUS = ?, AERFICAFH = GETDATE(), AERFICAIP  = ? WHERE AERFICCOD = ?";

            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val01, $val02, $val03, $val04, $aud01, $aud03, $val00]);

                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success UPDATE', 'codigo' => $val00), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtMSSQL00->closeCursor();
                $stmtMSSQL00 = null;
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
/*MODULO VIAJE*/

/*MODULO RENDICION*/
    $app->put('/v2/500/rendicion/asignar/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val00      = $request->getAttribute('codigo');
        $val01      = $request->getParsedBody()['rendicion_codigo'];
        $val02      = trim(strtoupper(strtolower($request->getParsedBody()['rendicion_documento_analista'])));

        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        if (isset($val00) && isset($val01) && isset($val02)) {
            $sql00  = "UPDATE [con].[RENFIC] SET RENFICDNA = ?, RENFICAUS = ?, RENFICAFH = GETDATE(), RENFICAIP = ? WHERE RENFICCOD = ? AND RENFICCOD = ?";

            try {
                $connMSSQL  = getConnectionMSSQLv2();

                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val02, $aud01, $aud03, $val00, $val01]);

                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success UPDATE Asigando a la RENDICIÓN NRO.: '.$val00, 'codigo' => $val00), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtMSSQL00->closeCursor();
                $stmtMSSQL00 = null;
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

    $app->put('/v2/500/rendicion/detalle/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val00      = $request->getAttribute('codigo');
        $val01      = $request->getParsedBody()['estado_anterior_codigo'];
        $val02      = $request->getParsedBody()['estado_actual_codigo'];
        $val03      = $request->getParsedBody()['tipo_concepto_codigo'];
        $val04      = $request->getParsedBody()['tipo_alerta_codigo'];
        $val05      = $request->getParsedBody()['workflow_codigo'];
        $val06      = $request->getParsedBody()['rendicion_cabecera_codigo'];
        $val07      = trim(strtoupper(strtolower($request->getParsedBody()['rendicion_detalle_descripcion'])));
        $val08      = $request->getParsedBody()['rendicion_detalle_importe'];
        $val09      = trim(strtolower($request->getParsedBody()['rendicion_detalle_css']));
        $val10      = trim(strtoupper(strtolower($request->getParsedBody()['rendicion_detalle_observacion'])));

        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        if (isset($val00) && isset($val01) && isset($val02) && isset($val03) && isset($val04) && isset($val05) && isset($val06)) {   
            $sql00  = "UPDATE [con].[RENFDE] SET RENFDETCC = ?, RENFDEDES = ?, RENFDEIMP = ?, RENFDEOBS = ?, RENFDEAUS = ?, RENFDEAFH = GETDATE(), RENFDEAIP = ? WHERE RENFDECOD = ?";

            try {
                $connMSSQL  = getConnectionMSSQLv2();

                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val03, $val07, $val08, $val10, $aud01, $aud03, $val00]);

                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success UPDATE', 'codigo' => $val00), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtMSSQL00->closeCursor();
                $stmtMSSQL00 = null;
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
    
    $app->put('/v2/500/rendicion/cabecera/workflow/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val00      = $request->getAttribute('codigo');
        $val01      = $request->getParsedBody()['estado_anterior_codigo'];
        $val02      = $request->getParsedBody()['estado_actual_codigo'];
        $val03      = $request->getParsedBody()['tipo_concepto_codigo'];
        $val04      = $request->getParsedBody()['tipo_alerta_codigo'];
        $val05      = $request->getParsedBody()['workflow_codigo'];
        $val06      = $request->getParsedBody()['rendicion_codigo'];
        $val07      = $request->getParsedBody()['rendicion_cabecera_codigo'];
        $val08      = trim(strtoupper(strtolower($request->getParsedBody()['rendicion_detalle_descripcion'])));
        $val09      = $request->getParsedBody()['rendicion_detalle_importe'];
        $val10      = trim(strtolower($request->getParsedBody()['rendicion_detalle_css']));
        $val11      = trim(strtoupper(strtolower($request->getParsedBody()['rendicion_detalle_observacion'])));

        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        if (isset($val00) && isset($val01) && isset($val02) && isset($val03) && isset($val04) && isset($val05) && isset($val06) && isset($val07)) {   
            $sql00  = "UPDATE [con].[RENFCA] SET RENFCAEAC = ?, RENFCAECC = ?, RENFCAAUS = ?, RENFCAAFH = GETDATE(), RENFCAAIP = ? WHERE RENFCACOD = ? AND RENFCAWFC = ?";

            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val01, $val02, $aud01, $aud03, $val07, $val05]);

                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success UPDATE', 'codigo' => $val00), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtMSSQL00->closeCursor();
                $stmtMSSQL00 = null;
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

    $app->put('/v2/500/rendicion/detalle/workflow/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val00      = $request->getAttribute('codigo');
        $val01      = $request->getParsedBody()['estado_anterior_codigo'];
        $val02      = $request->getParsedBody()['estado_actual_codigo'];
        $val03      = $request->getParsedBody()['tipo_concepto_codigo'];
        $val04      = $request->getParsedBody()['tipo_alerta_codigo'];
        $val05      = $request->getParsedBody()['workflow_codigo'];
        $val06      = $request->getParsedBody()['rendicion_codigo'];
        $val07      = $request->getParsedBody()['rendicion_cabecera_codigo'];
        $val08      = trim(strtoupper(strtolower($request->getParsedBody()['rendicion_detalle_descripcion'])));
        $val09      = $request->getParsedBody()['rendicion_detalle_importe'];
        $val10      = trim(strtolower($request->getParsedBody()['rendicion_detalle_css']));
        $val11      = trim(strtoupper(strtolower($request->getParsedBody()['rendicion_detalle_observacion'])));

        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        if (isset($val00) && isset($val01) && isset($val02) && isset($val03) && isset($val04) && isset($val05) && isset($val06) && isset($val07)) {   
            $sql00  = "UPDATE [con].[RENFDE] SET RENFDEEAC = ?, RENFDEECC = ?, RENFDEAUS = ?, RENFDEAFH = GETDATE(), RENFDEAIP = ? WHERE RENFDECOD = ? AND RENFDEWFC = ?";
            $sql01  = "SELECT * FROM [con].[RENFCA] a WHERE a.RENFCACOD = ? AND a.RENFCAWFC = ? AND EXISTS (SELECT * FROM [con].[RENFDE] b WHERE b.RENFDEFCC = a.RENFCACOD AND b.RENFDEWFC = a.RENFCAWFC AND b.RENFDEEAC = a.RENFCAEAC AND b.RENFDEECC = a.RENFCAECC)";
            $sql02  = "UPDATE [con].[RENFCA] SET RENFCAEAC = ?, RENFCAECC = ?, RENFCAAUS = ?, RENFCAAFH = GETDATE(), RENFCAAIP = ? WHERE RENFCACOD = ? AND RENFCAWFC = ?";
            $sql03  = "SELECT * FROM [con].[RENFIC] a WHERE a.RENFICCOD = ? AND a.RENFICWFC = ? AND EXISTS (SELECT * FROM [con].[RENFCA] b WHERE b.RENFCAREC = a.RENFICCOD AND b.RENFCAWFC = a.RENFICWFC AND b.RENFCAEAC = a.RENFICEAC AND b.RENFCAECC = a.RENFICECC)";
            $sql04  = "UPDATE [con].[RENFIC] SET RENFICEAC = ?, RENFICECC = ?, RENFICAUS = ?, RENFICAFH = GETDATE(), RENFICAIP = ? WHERE RENFICCOD = ? AND RENFICWFC = ?";

            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL01= $connMSSQL->prepare($sql01);
                $stmtMSSQL02= $connMSSQL->prepare($sql02);
                $stmtMSSQL03= $connMSSQL->prepare($sql03);
                $stmtMSSQL04= $connMSSQL->prepare($sql04);

                $stmtMSSQL00->execute([$val01, $val02, $aud01, $aud03, $val00, $val05]);

                $stmtMSSQL01->execute([$val07, $val05]);
                $row_mssql01= $stmtMSSQL01->fetch(PDO::FETCH_ASSOC);

                if(empty($row_mssql01)){
                    $stmtMSSQL02->execute([$val01, $val02, $aud01, $aud03, $val07, $val05]);
                }

                $stmtMSSQL03->execute([$val06, $val05]);
                $row_mssql03= $stmtMSSQL03->fetch(PDO::FETCH_ASSOC);

                if(empty($row_mssql03)){
                    $stmtMSSQL04->execute([$val01, $val02, $aud01, $aud03, $val06, $val05]);
                }

                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success UPDATE', 'codigo' => $val00), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtMSSQL00->closeCursor();
                $stmtMSSQL01->closeCursor();
                $stmtMSSQL02->closeCursor();
                $stmtMSSQL03->closeCursor();
                $stmtMSSQL04->closeCursor();

                $stmtMSSQL00 = null;
                $stmtMSSQL01 = null;
                $stmtMSSQL02 = null;
                $stmtMSSQL03 = null;
                $stmtMSSQL04 = null;
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
/*MODULO RENDICION*/