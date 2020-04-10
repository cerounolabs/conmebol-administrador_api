<?php
    $app->put('/v1/100/solicitud/{codigo}', function($request) {
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
            $sql00  = "UPDATE [CSF_PERMISOS].[adm].[DOMSOL] SET DOMSOLEST = ?, DOMSOLORD = ?, DOMSOLDIC = ?, DOMSOLDIO = ?, DOMSOLDIU = ?, DOMSOLADJ = ?, DOMSOLOBS = ?, DOMSOLUSU = ?, DOMSOLAFEC = GETDATE(), DOMSOLDIP = ? WHERE DOMSOLCOD = ?";

            try {
                $connMSSQL  = getConnectionMSSQLv1();
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

    $app->put('/v1/200/{codigo}', function($request) {
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
                $sql00  = "UPDATE [CSF_PERMISOS].[hum].[SOLFIC] SET SOLFICEST = ?, SOLFICOBS = ?, SOLFICUSS = ?, SOLFICFCS = GETDATE(), SOLFICIPS = ?, SOLFICUSU = ?, SOLFICFEC = GETDATE(), SOLFICDIP = ? WHERE SOLFICCOD = ?";
            } else {
                $sql00  = "UPDATE [CSF_PERMISOS].[hum].[SOLFIC] SET SOLFICEST = ?, SOLFICOBT = ?, SOLFICUST = ?, SOLFICFCT = GETDATE(), SOLFICIPT = ?, SOLFICUSU = ?, SOLFICFEC = GETDATE(), SOLFICDIP = ? WHERE SOLFICCOD = ?";
            }

            try {
                $connMSSQL  = getConnectionMSSQLv1();
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

    $app->put('/v1/200/detalle/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val00      = $request->getAttribute('codigo');

        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        if (isset($val00)) {
            $sql00  = "UPDATE [CSF_PERMISOS].[hum].[SOLAXI] SET SOLFICEST = ?, SOLAXIUSU = ?, SOLAXIFEC = GETDATE(), SOLAXIDIP = ? WHERE SOLAXICOD = ?";

            try {
                $connMSSQL  = getConnectionMSSQLv1();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute(['G', $aud01, $aud03, $val00]);

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