<?php
    $app->put('/v2/100/dominio/{codigo}', function($request) {
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
            $sql00  = "UPDATE [adm].[DOMFIC] SET DOMFICEST = ?, DOMFICORD = ?, DOMFICNOI = ?, DOMFICNOC = ?, DOMFICNOP = ?, DOMFICPAT = ?, DOMFICOBS = ?, DOMFICUSU = ?, DOMFICFEC = GETDATE(), DOMFICDIP = ? WHERE DOMFICCOD = ?";

            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val01, $val02, $val03, $val04, $val05, $val06, $val08, $aud01, $aud03, $val00]);

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

    $app->put('/v2/100/dominiosub', function($request) {
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
            $sql00  = "UPDATE [adm].[DOMSUB] SET DOMSUBEST = ?, DOMSUBORD = ?, DOMSUBPAT = ?, DOMSUBOBS = ?, DOMSUBAUS = ?, DOMSUBAFE = GETDATE(), DOMSUBAIP = ? WHERE DOMSUBCO1 = ? AND DOMSUBCO2 = ? AND DOMSUBVAL = ?";
            
            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val03, $val04, $val05, $val07, $aud01, $aud03, $val01, $val02, $val06]);

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
        $val02      = $request->getParsedBody()['ciudad_orden'];
        $val03      = $request->getParsedBody()['pais_codigo'];
        $val04      = $request->getParsedBody()['ciudad_nombre'];
        $val05      = $request->getParsedBody()['ciudad_observacion'];

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

    $app->put('/v2/300/workflow/{codigo}', function($request) {
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

    $app->put('/v2/400/proveedor/{codigo}', function($request) {
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
            $sql00  = "UPDATE [via].[PROFIC] SET PROFICEST = ?, PROFICTPC = ?, PROFICTCC = ?, PROFICCIC = ?, PROFICNOM = ?, PROFICRAZ = ?, PROFICRUC = ?, PROFICPAI = ?, PROFICDIR = ?, PROFICSPC = ?, PROFICSPI = ?, PROFICSPU = ?, PROFICOBS = ?, PROFICAUS = ?, PROFICAFH = GETDATE(), PROFICAIP = ? WHERE PROFICCOD = ?";
            
            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val01, $val02, $val03, $val04, $val05, $val06, $val07, $val08, $val09, $val10, $val11, $val12, $val13, $aud01, $aud03, $val00]);
                $stmtMSSQL00->closeCursor();
                $stmtMSSQL00= null;

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

    $app->put('/v2/400/habitacion/{codigo}', function($request) {
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
            $sql00  = "UPDATE [via].[PROHAB] SET PROHABEST = ?, PROHABTHC = ?, PROHABNOM = ?, PROHABPRE = ?, PROHABPAT = ?, PROHABOBS = ?, PROHABAUS = ?, PROHABAFH = GETDATE(), PROHABAIP = ? WHERE PROHABCOD = ?";
            
            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);

                $stmtMSSQL00->execute([$val01, $val02, $val04, $val05, $val06, $val07, $aud01, $aud03, $val00]);

                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success UPDATE', 'codigo' => 0), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

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