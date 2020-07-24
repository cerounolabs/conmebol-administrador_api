<?php
    $app->post('/v1/login', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getParsedBody()['usuario_var01'];
        $val02      = $request->getParsedBody()['usuario_var02'];
        $val03      = $request->getParsedBody()['usuario_var03'];
        $val04      = $request->getParsedBody()['usuario_var04'];
        $val05      = $request->getParsedBody()['usuario_var05'];
        $val06      = $request->getParsedBody()['usuario_var06'];

        if (isset($val01) && isset($val02) && isset($val03)) {
            try {
                $servidor_LDAP    = "172.16.50.1";
                $dominio_LDAP     = "conmebol.com";
                $dn_LDAP          = "dc=conmebol,dc=com";
                $usuario_LDAP     = $val01;
                $contrasena_LDAP  = $val02;
                $filtro_LDAP      = '(&(objectClass=user)(objectCategory=person)(samaccountname='.$usuario_LDAP.'))';
                $atributo_LDAP    = array('givenname', 'userprincipalname', 'samaccountname', 'sn', 'postalcode', 'thumbnailphoto', 'thumbnail', 'jpegphoto');
                $conectado_LDAP   = ldap_connect($servidor_LDAP);

                ldap_set_option($conectado_LDAP, LDAP_OPT_PROTOCOL_VERSION, 3);
                ldap_set_option($conectado_LDAP, LDAP_OPT_REFERRALS, 0);

                if ($conectado_LDAP) {
                    $autenticado_LDAP = ldap_bind($conectado_LDAP, $usuario_LDAP."@".$dominio_LDAP, $contrasena_LDAP);
                    
                    if ($autenticado_LDAP) {
                        $resultado_LDAP = ldap_search($conectado_LDAP, $dn_LDAP, $filtro_LDAP);
                        $numero_LDAP    = ldap_count_entries($conectado_LDAP, $resultado_LDAP);
                        $entrada_LDAP   = ldap_get_entries($conectado_LDAP, $resultado_LDAP);

                        foreach($entrada_LDAP as $i){
                            foreach($atributo_LDAP as $j){
                                if(isset($i[$j])){
                                    switch ($j) {
                                        case 'givenname':
                                            $user_var01 = strtoupper(htmlspecialchars($i[$j][0]));
                                            break;
                                        case 'userprincipalname':
                                            $user_var02 = strtolower(htmlspecialchars($i[$j][0]));
                                            break;
                                        case 'samaccountname':
                                            $user_var03 = strtoupper(htmlspecialchars($i[$j][0]));
                                            break;
                                        case 'sn':
                                            $user_var04 = strtoupper(htmlspecialchars($i[$j][0]));
                                            break;
                                        case 'postalcode':
                                            $user_var05 = strtoupper(htmlspecialchars($i[$j][0]));
                                            break;

                                        case 'thumbnailphoto':
                                            $user_var06 = strtoupper(htmlspecialchars($i[$j][0]));
                                            break;

                                        case 'thumbnail':
                                            $user_var08 = strtoupper(htmlspecialchars($i[$j][0]));
                                            break;

                                        case 'jpegphoto':
                                            $user_var07 = strtoupper(htmlspecialchars($i[$j][0]));
                                            break;
                                    }
                                }
                            }
                        }

                        $detalle    = array(
                            'user_var01' => $user_var01,
                            'user_var02' => $user_var02,
                            'user_var03' => $user_var03,
                            'user_var04' => $user_var04,
                            'user_var05' => $user_var05,
                            'user_var06' => $user_var06,
                            'user_var07' => $user_var07,
                            'user_var08' => $user_var08,
                        );

                        $reCode     = 200;
                        $reMessage  = 'Success LOGIN';

                        ldap_close($conectado_LDAP);
                    } else {
                        $reCode     = 201;
                        $reMessage  = 'ERROR: Verifique su usuario y su contraseña introducida';
                        $detalle    = array(
                            'user_var01' => '',
                            'user_var02' => '',
                            'user_var03' => '',
                            'user_var04' => '',
                            'user_var05' => '',
                            'user_var06' => '',
                            'user_var07' => '',
                            'user_var08' => ''
                        );
                    }
                } else {
                    $reCode     = 204;
                    $reMessage  = 'ERROR: Inconveniente al acceder al Servidor';
                    $detalle    = array(
                        'user_var01' => '',
                        'user_var02' => '',
                        'user_var03' => '',
                        'user_var04' => '',
                        'user_var05' => '',
                        'user_var06' => '',
                        'user_var07' => '',
                        'user_var08' => ''
                    );
                }

                $result[]   = $detalle;

                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => $reCode, 'status' => 'ok', 'message' => $reMessage, 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error LOGIN: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        return $json;
    });

    $app->post('/v1/100/dominio', function($request) {
        require __DIR__.'/../src/connect.php';

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

        if (isset($val01) && isset($val04) && isset($val07)) {    
            $sql00  = "INSERT INTO [adm].[DOMFIC] (DOMFICEST, DOMFICORD, DOMFICNOI, DOMFICNOC, DOMFICNOP, DOMFICPAT, DOMFICVAL, DOMFICOBS, DOMFICUSU, DOMFICFEC, DOMFICDIP) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, GETDATE(), ?)";

            try {
                $connMSSQL  = getConnectionMSSQLv1();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val01, $val02, $val03, $val04, $val05, $val06, $val07, $val08, $aud01, $aud03]);

                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success INSERT', 'codigo' => 0), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

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

    $app->post('/v1/100/dominiosub', function($request) {
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

        if (isset($val01) && isset($val04) && isset($val07)) {    
            $sql00  = "INSERT INTO [adm].[DOMSUB] (DOMSUBCO1, DOMSUBCO2, DOMSUBEST, DOMSUBORD, DOMSUBPAT, DOMSUBVAL, DOMSUBOBS, DOMSUBAUS, DOMSUBAFE, DOMSUBAIP) VALUES (?, ?, ?, ?, ?, ?, ?, ?, GETDATE(), ?)";

            try {
                $connMSSQL  = getConnectionMSSQLv1();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val01, $val02, $val03, $val04, $val05, $val06, $val07, $aud01, $aud03]);

                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success INSERT', 'codigo' => 0), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

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

    $app->post('/v1/100/solicitud', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getParsedBody()['tipo_estado_codigo'];
        $val02      = $request->getParsedBody()['tipo_solicitud_codigo'];
        $val03      = $request->getParsedBody()['tipo_orden_numero'];
        $val04      = $request->getParsedBody()['tipo_permiso_codigo'];
        $val05      = $request->getParsedBody()['tipo_dia_cantidad'];
        $val06      = $request->getParsedBody()['tipo_dia_corrido'];
        $val07      = $request->getParsedBody()['tipo_dia_unidad'];
        $val08      = $request->getParsedBody()['tipo_archivo_adjunto'];
        $val09      = $request->getParsedBody()['tipo_observacion'];

        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        if (isset($val01) && isset($val02) && isset($val04)) {    
            $sql00  = "";

            switch ($val02) {
                case 'L':
                    $sql00  = "SELECT Code, Name, U_CODIGO FROM dbo.[@A1A_TILC] WHERE Code = ?";
                    break;
                
                case 'P':
                    $sql00  = "SELECT Code, Name, U_CODIGO FROM dbo.[@A1A_TIPE] WHERE Code = ?";
                    break;

                case 'I':
                    $sql00  = "SELECT Code, Name, U_CODIGO FROM dbo.[@A1A_TIIN] WHERE Code = ?";
                    break;
            }        
            
            $sql01  = "INSERT INTO [adm].[DOMSOL] (DOMSOLEST, DOMSOLTST, DOMSOLORD, DOMSOLPC1, DOMSOLPC2, DOMSOLPC3, DOMSOLDIC, DOMSOLDIO, DOMSOLDIU, DOMSOLADJ, DOMSOLOBS, DOMSOLUSU, DOMSOLFEC, DOMSOLDIP) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, GETDATE(), ?)";

            try {
                $connMSSQL  = getConnectionMSSQLv1();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val04]);

                $row00      = $stmtMSSQL00->fetch(PDO::FETCH_ASSOC);
                $DOMSOLPC1  = $row00['Code'];
                $DOMSOLPC2  = $row00['Name'];
                $DOMSOLPC3  = $row00['U_CODIGO'];

                $stmtMSSQL  = $connMSSQL->prepare($sql01);
                $stmtMSSQL->execute([$val01, $val02, $val03, $DOMSOLPC1, $DOMSOLPC2, $DOMSOLPC3, $val05, $val06, $val07, $val08, $val09, $aud01, $aud03]);

                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success INSERT', 'codigo' => 0), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtMSSQL00->closeCursor();
                $stmtMSSQL00 = null;

                $stmtMSSQL01->closeCursor();
                $stmtMSSQL01 = null;
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

    $app->post('/v1/100/procesar', function($request) {
        require __DIR__.'/../src/connect.php';

        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        if (isset($aud01) && isset($aud02) && isset($aud03)) {
            $DOMSOLEST  = 'A';
            $DOMSOLORD  = 0;
            $DOMSOLDIC  = 0;
            $DOMSOLDIO  = '';
            $DOMSOLOBS  = '';
            $DOMSOLUSU  = $aud01;
            $DOMSOLDIP  = $aud03;

            $sql00      = "SELECT a.CODE AS tipo_codigo, a.NAME AS tipo_codigo_nombre, a.U_CODIGO AS tipo_codigo_referencia FROM [CSF].[dbo].[@A1A_TILC] a ORDER BY a.U_CODIGO";
            $sql01      = "SELECT a.CODE AS tipo_codigo, a.NAME AS tipo_codigo_nombre, a.U_CODIGO AS tipo_codigo_referencia FROM [CSF].[dbo].[@A1A_TIPE] a ORDER BY a.U_CODIGO";
            $sql02      = "SELECT a.CODE AS tipo_codigo, a.NAME AS tipo_codigo_nombre, a.U_CODIGO AS tipo_codigo_referencia FROM [CSF].[dbo].[@A1A_TIIN] a ORDER BY a.U_CODIGO";
            $sql03      = "SELECT * FROM [adm].[DOMSOL] WHERE DOMSOLTST = ? AND DOMSOLPC1 = ? AND DOMSOLPC2 = ? AND DOMSOLPC3 = ?";
            $sql04      = "INSERT INTO [CSF_SFHOLOX].[adm].[DOMSOL] (DOMSOLEST, DOMSOLTST, DOMSOLORD, DOMSOLPC1, DOMSOLPC2, DOMSOLPC3, DOMSOLDIC, DOMSOLDIO, DOMSOLOBS, DOMSOLUSU, DOMSOLFEC, DOMSOLDIP) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, GETDATE(), ?)";

            try {
                $connMSSQL  = getConnectionMSSQLv1();

                $DOMSOLTST  = 'L';
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute();

                $stmtMSSQL03= $connMSSQL->prepare($sql03);
                $stmtMSSQL04= $connMSSQL->prepare($sql04);

                while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                    $stmtMSSQL03->execute([$DOMSOLTST, $rowMSSQL00['tipo_codigo'], $rowMSSQL00['tipo_codigo_nombre'], $rowMSSQL00['tipo_codigo_referencia']]);
                    $rowMSSQL03 = $stmtMSSQL03->fetch(PDO::FETCH_ASSOC);

                    if (!$rowMSSQL03) {
                        $stmtMSSQL04->execute([$DOMSOLEST, $DOMSOLTST, $DOMSOLORD, $rowMSSQL00['tipo_codigo'], $rowMSSQL00['tipo_codigo_nombre'], $rowMSSQL00['tipo_codigo_referencia'], $DOMSOLDIC, $DOMSOLDIO, $DOMSOLOBS, $DOMSOLUSU, $DOMSOLDIP]);
                    }
                }

                $DOMSOLTST  = 'P';
                $stmtMSSQL01= $connMSSQL->prepare($sql01);
                $stmtMSSQL01->execute();

                while ($rowMSSQL01 = $stmtMSSQL01->fetch()) {
                    $stmtMSSQL03->execute([$DOMSOLTST, $rowMSSQL01['tipo_codigo'], $rowMSSQL01['tipo_codigo_nombre'], $rowMSSQL01['tipo_codigo_referencia']]);
                    $rowMSSQL03 = $stmtMSSQL03->fetch(PDO::FETCH_ASSOC);

                    if (!$rowMSSQL03) {
                        $stmtMSSQL04->execute([$DOMSOLEST, $DOMSOLTST, $DOMSOLORD, $rowMSSQL01['tipo_codigo'], $rowMSSQL01['tipo_codigo_nombre'], $rowMSSQL01['tipo_codigo_referencia'], $DOMSOLDIC, $DOMSOLDIO, $DOMSOLOBS, $DOMSOLUSU, $DOMSOLDIP]);
                    }
                }

                $DOMSOLTST  = 'I';
                $stmtMSSQL02= $connMSSQL->prepare($sql02);
                $stmtMSSQL02->execute();

                while ($rowMSSQL02 = $stmtMSSQL02->fetch()) {
                    $stmtMSSQL03->execute([$DOMSOLTST, $rowMSSQL02['tipo_codigo'], $rowMSSQL02['tipo_codigo_nombre'], $rowMSSQL02['tipo_codigo_referencia']]);
                    $rowMSSQL03 = $stmtMSSQL03->fetch(PDO::FETCH_ASSOC);

                    if (!$rowMSSQL03) {
                        $stmtMSSQL04->execute([$DOMSOLEST, $DOMSOLTST, $DOMSOLORD, $rowMSSQL02['tipo_codigo'], $rowMSSQL02['tipo_codigo_nombre'], $rowMSSQL02['tipo_codigo_referencia'], $DOMSOLDIC, $DOMSOLDIO, $DOMSOLOBS, $DOMSOLUSU, $DOMSOLDIP]);
                    }
                }

                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success PROCESAR', 'codigo' => 0), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtMSSQL00->closeCursor();
                $stmtMSSQL00 = null;

                $stmtMSSQL01->closeCursor();
                $stmtMSSQL01 = null;

                $stmtMSSQL02->closeCursor();
                $stmtMSSQL02 = null;

                $stmtMSSQL03->closeCursor();
                $stmtMSSQL03 = null;

                $stmtMSSQL04->closeCursor();
                $stmtMSSQL04 = null;
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

    $app->post('/v1/200/solicitudes', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getParsedBody()['tipo_estado_codigo'];
        $val02      = $request->getParsedBody()['tipo_solicitud_codigo'];
        $val03      = $request->getParsedBody()['solicitud_documento'];
        $val04      = $request->getParsedBody()['solicitud_fecha_desde'];
        $val05      = $request->getParsedBody()['solicitud_fecha_hasta'];
        $val06      = $request->getParsedBody()['solicitud_fecha_cantidad'];
        $val07      = $request->getParsedBody()['solicitud_hora_desde'];
        $val08      = $request->getParsedBody()['solicitud_hora_hasta'];
        $val09      = $request->getParsedBody()['solicitud_hora_cantidad'];
        $val10      = $request->getParsedBody()['solicitud_periodo'];
        $val11      = $request->getParsedBody()['solicitud_documento_jefe'];
        $val12      = $request->getParsedBody()['solicitud_adjunto'];
        $val13      = $request->getParsedBody()['solicitud_observacion_colaborador'];

        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        if (isset($val01) && isset($val02) && isset($val04)) {
            $sql00  = "INSERT INTO [hum].[SOLFIC] (SOLFICEST, SOLFICTST, SOLFICDOC, SOLFICFH1, SOLFICFH2, SOLFICFHC, SOLFICHO1, SOLFICHO2, SOLFICHOC, SOLFICPER, SOLFICDOJ, SOLFICADJ, SOLFICUSC, SOLFICFCC, SOLFICIPC, SOLFICOBC, SOLFICUSU, SOLFICFEC, SOLFICDIP) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, GETDATE(), ?, ?, ?, GETDATE(), ?)";
            $sql01  = "SELECT MAX(SOLFICCOD) AS solicitud_codigo FROM [hum].[SOLFIC] WHERE SOLFICEST = ? AND SOLFICTST = ? AND SOLFICDOC = ?";
            
            try {
                $connMSSQL  = getConnectionMSSQLv1();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL01= $connMSSQL->prepare($sql01);

                $stmtMSSQL00->execute([$val01, $val02, $val03, $val04, $val05, $val06, $val07, $val08, $val09, $val10, $val11, $val12, $aud01, $aud03, $val13, $aud01, $aud03]);
                
                $stmtMSSQL01->execute([$val01, $val02, $val03]);
                $row_mssql01= $stmtMSSQL01->fetch(PDO::FETCH_ASSOC);
                $SOLFICCOD  = $row_mssql01['solicitud_codigo'];

                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success INSERT', 'codigo' => $SOLFICCOD), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtMSSQL00->closeCursor();
                $stmtMSSQL01->closeCursor();

                $stmtMSSQL00 = null;
                $stmtMSSQL01 = null;
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

    $app->post('/v1/200/exportar', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getParsedBody()['solicitud_codigo'];

        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        if (isset($val01)) {        
            $sql01  = "SELECT
                a.SOLFICCOD         AS          solicitud_codigo,
                a.SOLFICEST         AS          solicitud_estado_codigo,
                a.SOLFICDOC         AS          solicitud_documento,
                a.SOLFICFH1         AS          solicitud_fecha_desde,
                a.SOLFICFH2         AS          solicitud_fecha_hasta,
                a.SOLFICFHC         AS          solicitud_fecha_cantidad,
                a.SOLFICHO1         AS          solicitud_hora_desde,
                a.SOLFICHO2         AS          solicitud_hora_hasta,
                a.SOLFICHOC         AS          solicitud_hora_cantidad,
                a.SOLFICADJ         AS          solicitud_adjunto,
                a.SOLFICUSC         AS          solicitud_usuario_colaborador,
                a.SOLFICFCC         AS          solicitud_fecha_hora_colaborador,
                a.SOLFICIPC         AS          solicitud_ip_colaborador, 
                a.SOLFICOBC         AS          solicitud_observacion_colaborador,
                a.SOLFICUSS         AS          solicitud_usuario_superior,
                a.SOLFICFCS         AS          solicitud_fecha_hora_superior,
                a.SOLFICIPS         AS          solicitud_ip_superior,
                a.SOLFICOBS         AS          solicitud_observacion_superior,
                a.SOLFICUST         AS          solicitud_usuario_talento,
                a.SOLFICFCT         AS          solicitud_fecha_hora_talento,
                a.SOLFICIPT         AS          solicitud_ip_talento,
                a.SOLFICOBT         AS          solicitud_observacion_talento,
                a.SOLFICUSU         AS          auditoria_usuario,
                a.SOLFICFEC         AS          auditoria_fecha_hora,
                a.SOLFICDIP         AS          auditoria_ip,

                b.DOMSOLCOD         AS          tipo_permiso_codigo,
                b.DOMSOLEST         AS          tipo_estado_codigo,
                b.DOMSOLTST         AS          tipo_solicitud_codigo,
                b.DOMSOLORD         AS          tipo_orden_numero,
                b.DOMSOLPC1         AS          tipo_permiso_codigo1,
                b.DOMSOLPC2         AS          tipo_permiso_codigo2,
                b.DOMSOLPC3         AS          tipo_permiso_codigo3,
                b.DOMSOLDIC         AS          tipo_dia_cantidad,
                b.DOMSOLDIO         AS          tipo_dia_corrido,
                b.DOMSOLDIU         AS          tipo_dia_unidad,
                b.DOMSOLADJ         AS          tipo_archivo_adjunto,
                b.DOMSOLOBS         AS          tipo_observacion

                FROM [CSF_SFHOLOX].[hum].[SOLFIC] a
                INNER JOIN [CSF_SFHOLOX].[adm].[DOMSOL] b ON a.SOLFICTST = b.DOMSOLCOD
                
                WHERE a.SOLFICCOD = ?";

            $sql03  = "INSERT INTO [CSF_SFHOLOX].[hum].[SOLAXI] (SOLAXICAB, SOLAXIEST, SOLAXISOL, SOLAXIDOC, SOLAXIFED, SOLAXIFEH, SOLAXIAPD, SOLAXIAPH, SOLAXICAN, SOLAXITIP, SOLAXIDIA, SOLAXIUNI, SOLAXICOM, SOLAXIIDP, SOLAXICON, SOLAXICLA, SOLAXILIN, SOLAXIORI, SOLAXIGRU, SOLAXIUSU, SOLAXIFEC, SOLAXIDIP) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, GETDATE(), ?)";

            try {
                $connMSSQL  = getConnectionMSSQLv1();
                $stmtMSSQL01= $connMSSQL->prepare($sql01);
                $stmtMSSQL01->execute([$val01]);

                $stmtMSSQL03= $connMSSQL->prepare($sql03);

                while ($rowMSSQL01 = $stmtMSSQL01->fetch()) {
                    switch ($rowMSSQL01['tipo_solicitud_codigo']) {
                        case 'L':
                            $tipo_solicitud_nombre  = 'LICENCIA';
                            $sql02                  = "SELECT U_NOMBRE AS tipo_permiso_nombre,  U_CODINA AS tipo_permiso_codigo, U_TIPO AS tipo_permiso_valor FROM [CSF].[dbo].[@A1A_TILC] WHERE U_CODIGO = ?";
                            break;
                        
                        case 'P':
                            $tipo_solicitud_nombre  = 'PERMISO';
                            $sql02                  = "SELECT U_NOMBRE AS tipo_permiso_nombre, U_CODINA AS tipo_permiso_codigo, U_CALIFICA AS tipo_permiso_valor FROM [CSF].[dbo].[@A1A_TIPE] WHERE U_CODIGO = ?";
                            break;
        
                        case 'I':
                            $tipo_solicitud_nombre  = 'INASISTENCIA';
                            $sql02                  = "SELECT U_DESAMP AS tipo_permiso_nombre, U_CODIGO AS tipo_permiso_codigo, U_IDENT AS tipo_permiso_valor FROM [CSF].[dbo].[@A1A_TIIN] WHERE U_CODIGO = ?";
                            break;
                    }

                    $stmtMSSQL02= $connMSSQL->prepare($sql02);
                    $stmtMSSQL02->execute([trim(strtoupper($rowMSSQL01['tipo_permiso_codigo3']))]);
                    $rowMSSQL02 = $stmtMSSQL02->fetch(PDO::FETCH_ASSOC);

                    $SOLAXICAB  = $val01;
                    $SOLAXIEST  = 'P';
                    $SOLAXIDOC  = trim(strtoupper($rowMSSQL01['solicitud_documento']));
                    $SOLAXIFED  = $rowMSSQL01['solicitud_fecha_desde'];
                    $SOLAXIFEH  = $rowMSSQL01['solicitud_fecha_hasta'];
                    $SOLAXIAPD  = $rowMSSQL01['solicitud_fecha_desde'];
                    $SOLAXIAPH  = $rowMSSQL01['solicitud_fecha_hasta'];
                    $SOLAXICAN  = 0;
                    $SOLAXITIP  = trim(strtoupper($rowMSSQL01['tipo_permiso_codigo3']));
                    $SOLAXIDIA  = 1;
                    $SOLAXIUNI  = trim(strtoupper($rowMSSQL01['tipo_dia_unidad']));
                    $SOLAXICOM  = trim(strtoupper($rowMSSQL02['tipo_permiso_nombre']));
                    $SOLAXIIDP  = '';
                    $SOLAXICON  = '00:00';
                    $SOLAXICLA  = trim(strtoupper($rowMSSQL02['tipo_permiso_valor']));
                    $SOLAXISOL  = trim(strtoupper($rowMSSQL01['tipo_solicitud_codigo']));
                    $SOLAXILIN  = '';
                    $SOLAXIORI  = '';
                    $SOLAXIGRU  = '';
                    $SOLAXIUSU  = trim(strtoupper($aud01));
                    $SOLAXIFEC  = $aud02;
                    $SOLAXIDIP  = trim(strtoupper($aud03));

                    if ($SOLAXIFED == $SOLAXIFEH) {
                        $SOLAXICAN = 1;
                    } else {
                        $auxFech   = $SOLAXIFED;

                        while ($SOLAXIFEH >= $auxFech) {
                            $dia = date('w', strtotime($auxFech));
    
                            if ($dia >= 1 && $dia <= 5) {
                                $SOLAXICAN = $SOLAXICAN + 1;
                            } else {
                                if ($rowMSSQL01['tipo_dia_corrido'] == 'S') {
                                    $SOLAXICAN = $SOLAXICAN + 1;
                                }
                            }
    
                            $auxFech = date('Y-m-d', strtotime('+1 day', strtotime($auxFech)));
                        }
                    }

                    if ($rowMSSQL01['tipo_dia_unidad'] == 'H') {
                        $date1      = new DateTime('Y-m-d '.$rowMSSQL01['solicitud_hora_desde'].':00');
                        $date2      = new DateTime('Y-m-d '.$rowMSSQL01['solicitud_hora_hasta'].':00');
                        $diff       = $date1->diff($date2);
                        $auxHor     = '';
                        $auxHor     .= ($diff->invert == 1) ? ' - ' : '';

                        if ($diff->h > 0) {
                            $auxHor .= ($diff->h > 1) ? $diff->h.':' : $diff->h . ':';
                        }
                        
                        if ($diff->i > 0) {
                            $auxHor .= ($diff->i > 1) ? $diff->i.':00' : $diff->i . ':00';
                        }

                        $SOLAXICON  = get_format($auxHor);
                    }

                    if (trim(strtoupper($rowMSSQL01['tipo_permiso_codigo3'])) == 'DSM' && trim(strtoupper($rowMSSQL01['tipo_solicitud_codigo'])) == 'I') {
                        $SOLAXISOL  = 'V';
                        $SOLAXITIP  = 'VAC';
                        $SOLAXILIN  = 'UV';
                    }

                    $stmtMSSQL03->execute([$SOLAXICAB, $SOLAXIEST, $SOLAXISOL, $SOLAXIDOC, $SOLAXIFED, $SOLAXIFEH, $SOLAXIAPD, $SOLAXIAPH, $SOLAXICAN, $SOLAXITIP, $SOLAXIDIA, $SOLAXIUNI, $SOLAXICOM, $SOLAXIIDP, $SOLAXICON, $SOLAXICLA, $SOLAXILIN, $SOLAXIORI, $SOLAXIGRU, $SOLAXIUSU, $SOLAXIDIP]);
                    
                    $auxFech    = $SOLAXIFEH;
                    $SOLAXICAN  = 1;
                    $SOLAXISOL  = 'I';
                    $SOLAXITIP  =  trim(strtoupper($rowMSSQL02['tipo_permiso_codigo']));
                    $SOLAXIGRU  = $connMSSQL->lastInsertId();

                    if (trim(strtoupper($rowMSSQL01['tipo_permiso_codigo3'])) == 'DSM' && trim(strtoupper($rowMSSQL01['tipo_solicitud_codigo'])) == 'I') {
                        $SOLAXITIP  = 'DSM';
                        $SOLAXILIN  = '';
                    }

                    if ($SOLAXIFED == $auxFech) {
                        $SOLAXIFEH  = $SOLAXIFED;
                        $SOLAXIAPH  = $SOLAXIFED;

                        $stmtMSSQL03->execute([$SOLAXICAB, $SOLAXIEST, $SOLAXISOL, $SOLAXIDOC, $SOLAXIFED, $SOLAXIFEH, $SOLAXIAPD, $SOLAXIAPH, $SOLAXICAN, $SOLAXITIP, $SOLAXIDIA, $SOLAXIUNI, $SOLAXICOM, $SOLAXIIDP, $SOLAXICON, $SOLAXICLA, $SOLAXILIN, $SOLAXIORI, $SOLAXIGRU, $SOLAXIUSU, $SOLAXIDIP]);
                    } else {
                        while ($auxFech >= $SOLAXIFED) {
                            $dia        = date('w', strtotime($SOLAXIFED));
                            $SOLAXIFEH  = $SOLAXIFED;
                            $SOLAXIAPH  = $SOLAXIFED;
    
                            if ($dia >= 1 && $dia <= 5) {
                                $stmtMSSQL03->execute([$SOLAXICAB, $SOLAXIEST, $SOLAXISOL, $SOLAXIDOC, $SOLAXIFED, $SOLAXIFEH, $SOLAXIAPD, $SOLAXIAPH, $SOLAXICAN, $SOLAXITIP, $SOLAXIDIA, $SOLAXIUNI, $SOLAXICOM, $SOLAXIIDP, $SOLAXICON, $SOLAXICLA, $SOLAXILIN, $SOLAXIORI, $SOLAXIGRU, $SOLAXIUSU, $SOLAXIDIP]);
                            } else {
                                if ($rowMSSQL01['tipo_dia_corrido'] == 'S') {
                                    $stmtMSSQL03->execute([$SOLAXICAB, $SOLAXIEST, $SOLAXISOL, $SOLAXIDOC, $SOLAXIFED, $SOLAXIFEH, $SOLAXIAPD, $SOLAXIAPH, $SOLAXICAN, $SOLAXITIP, $SOLAXIDIA, $SOLAXIUNI, $SOLAXICOM, $SOLAXIIDP, $SOLAXICON, $SOLAXICLA, $SOLAXILIN, $SOLAXIORI, $SOLAXIGRU, $SOLAXIUSU, $SOLAXIDIP]);
                                }
                            }
    
                            $SOLAXIFED = date('Y-m-d', strtotime('+1 day', strtotime($SOLAXIFED)));
                        }
                    }
                }

                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success INSERT', 'codigo' => 0), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtMSSQL01->closeCursor();
                $stmtMSSQL01 = null;
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

    $app->post('/v1/200/comprobante', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getParsedBody()['tipo_estado_codigo'];
        $val02      = $request->getParsedBody()['tipo_comprobante_codigo'];
        $val03      = $request->getParsedBody()['tipo_mes_codigo'];
        $val04      = $request->getParsedBody()['comprobante_documento'];
        $val05      = $request->getParsedBody()['comprobante_periodo'];
        $val06      = $request->getParsedBody()['comprobante_adjunto'];
        $val07      = $request->getParsedBody()['comprobante_observacion'];

        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        if (isset($val01) && isset($val02) && isset($val03) && isset($val04) && isset($val05) && isset($val06)) {        
            $sql00  = "INSERT INTO [hum].[COMFIC] (COMFICEST, COMFICTCC, COMFICTMC, COMFICDOC, COMFICPER, COMFICADJ, COMFICOBS, COMFICUSU, COMFICFEC, COMFICDIP) VALUES (?, ?, ?, ?, ?, ?, ?, ?, GETDATE(), ?)";
            
            try {
                $connMSSQL  = getConnectionMSSQLv1();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);

                $stmtMSSQL00->execute([$val01, $val02, $val03, $val04, $val05, $val06, $val07, $aud01, $aud03]);

                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success INSERT', 'codigo' => 0), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

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

    $app->post('/v1/300/workflow', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getParsedBody()['tipo_estado_codigo'];
        $val02      = $request->getParsedBody()['tipo_workflow_codigo'];
        $val03      = $request->getParsedBody()['tipo_evento_codigo'];
        $val04      = $request->getParsedBody()['tipo_cargo_codigo'];
        $val05      = $request->getParsedBody()['workflow_orden'];
        $val06      = trim(strtoupper(strtolower($request->getParsedBody()['workflow_tarea'])));
        $val07      = trim(strtoupper(strtolower($request->getParsedBody()['workflow_observacion'])));

        $aud01      = trim(strtoupper(strtolower($request->getParsedBody()['auditoria_usuario'])));
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = trim(strtoupper(strtolower($request->getParsedBody()['auditoria_ip'])));

        if (isset($val01) && isset($val02) && isset($val03) && isset($val04)) {        
            $sql00  = "INSERT INTO [wrk].[WRKFIC] (WRKFICEST, WRKFICTWC, WRKFICTEC, WRKFICTCC, WRKFICORD, WRKFICNOM, WRKFICOBS, WRKFICAUS, WRKFICAFE, WRKFICAIP) VALUES (?, ?, ?, ?, ?, ?, ?, ?, GETDATE(), ?)";
            
            try {
                $connMSSQL  = getConnectionMSSQLv1();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);

                $stmtMSSQL00->execute([$val01, $val02, $val03, $val04, $val05, $val06, $val07, $aud01, $aud03]);

                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success INSERT', 'codigo' => 0), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

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

    $app->post('/v1/300/workflow/sincronizar', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getParsedBody()['tipo_estado_codigo'];
        $val02      = $request->getParsedBody()['tipo_workflow_codigo'];
        $val03      = $request->getParsedBody()['tipo_evento_codigo'];
        $val04      = $request->getParsedBody()['tipo_cargo_codigo'];
        $val05      = $request->getParsedBody()['workflow_orden'];
        $val06      = trim(strtoupper(strtolower($request->getParsedBody()['workflow_tarea'])));
        $val07      = trim(strtoupper(strtolower($request->getParsedBody()['workflow_observacion'])));

        $aud01      = trim(strtoupper(strtolower($request->getParsedBody()['auditoria_usuario'])));
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = trim(strtoupper(strtolower($request->getParsedBody()['auditoria_ip'])));

        if (isset($val01) && isset($val02) && isset($val03) && isset($val04)) {      
            $sql00  = "SELECT CAST(a.U_CODIGO AS INT) AS tipo_cargo_codigo, a.U_NOMBRE AS tipo_cargo_nombre FROM [CSF].[dbo].[@A1A_TICA] a WHERE NOT EXISTS (SELECT * FROM [wrk].[WRKFIC] b WHERE b.WRKFICTCC = a.U_CODIGO AND b.WRKFICTWC = ?)";
            $sql01  = "INSERT INTO [wrk].[WRKFIC] (WRKFICEST, WRKFICTWC, WRKFICTEC, WRKFICTCC, WRKFICORD, WRKFICNOM, WRKFICOBS, WRKFICAUS, WRKFICAFE, WRKFICAIP) VALUES (?, ?, ?, ?, ?, ?, ?, ?, GETDATE(), ?)";
            $sql02  = "SELECT a.WRKFICCOD AS workflow_codigo, a.WRKFICTCC AS tipo_cargo_codigo, a.WRKFICNOM AS workflow_tarea FROM [wrk].[WRKFIC] a WHERE a.WRKFICTWC = ?"; 
            $sql03  = "INSERT INTO [wrk].[WRKDET] 
            (WRKDETTCC, WRKDETEAC, WRKDETESC, WRKDETTPC, WRKDETWFC, WRKDETORD, WRKDETNOM, WRKDETHOR, WRKDETNOT, WRKDETOBS, WRKDETAUS, WRKDETAFE, WRKDETAIP) VALUES 
            (        ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?, GETDATE(),         ?),
            (        ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?, GETDATE(),         ?),
            (        ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?, GETDATE(),         ?),
            
            ((SELECT CASE WHEN U_CARSUP IS NULL THEN CAST(a.U_CODIGO AS INT) ELSE CAST(a.U_CARSUP AS INT) END FROM [CSF].[dbo].[@A1A_TICA] a WHERE a.U_CODIGO = ?),         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?, GETDATE(),         ?),
            ((SELECT CASE WHEN U_CARSUP IS NULL THEN CAST(a.U_CODIGO AS INT) ELSE CAST(a.U_CARSUP AS INT) END FROM [CSF].[dbo].[@A1A_TICA] a WHERE a.U_CODIGO = ?),         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?, GETDATE(),         ?),
            ((SELECT CASE WHEN U_CARSUP IS NULL THEN CAST(a.U_CODIGO AS INT) ELSE CAST(a.U_CARSUP AS INT) END FROM [CSF].[dbo].[@A1A_TICA] a WHERE a.U_CODIGO = ?),         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?, GETDATE(),         ?),
            
            (        ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?, GETDATE(),         ?),
            (        ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?, GETDATE(),         ?),
            (        ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?, GETDATE(),         ?),
            
            (        ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?, GETDATE(),         ?),
            (        ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?, GETDATE(),         ?),
            (        ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?, GETDATE(),         ?),
            
            (        ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?, GETDATE(),         ?),
            (        ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?, GETDATE(),         ?),
            (        ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?, GETDATE(),         ?),
            (        ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?, GETDATE(),         ?),
            
            (        ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?, GETDATE(),         ?),
            (        ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?, GETDATE(),         ?),
            (        ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?, GETDATE(),         ?),
            
            (        ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?, GETDATE(),         ?),
            (        ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?, GETDATE(),         ?),
            (        ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?, GETDATE(),         ?)";

            try {
                $connMSSQL  = getConnectionMSSQLv1();

                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL01= $connMSSQL->prepare($sql01);
                $stmtMSSQL02= $connMSSQL->prepare($sql02);
                $stmtMSSQL03= $connMSSQL->prepare($sql03);

                $stmtMSSQL00->execute([$val02]);

                while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                    $stmtMSSQL01->execute([$val01, $val02, $val03, $rowMSSQL00['tipo_cargo_codigo'], $val05, $val06.' '.trim(strtoupper(strtolower($rowMSSQL00['tipo_cargo_nombre']))), $val07, $aud01, $aud03]);
                }

                $stmtMSSQL02->execute([$val02]);

                while ($rowMSSQL02 = $stmtMSSQL02->fetch()) {
                    $codTarea = $rowMSSQL02['workflow_codigo'];
                    $nomTarea = $rowMSSQL02['workflow_nombre'];
                    $codCargo = $rowMSSQL02['tipo_cargo_codigo'];

                    $stmtMSSQL03->execute(
                        [
                            $codCargo, 4, 4, 49, $codTarea, 100, 'TAREA#100', 40, 'S', '', $aud01, $aud03,
                            $codCargo, 4, 5, 49, $codTarea, 101, 'TAREA#101', 40, 'S', '', $aud01, $aud03,
                            $codCargo, 4, 6, 49, $codTarea, 102, 'TAREA#102', 40, 'S', '', $aud01, $aud03,

                            $codCargo, 5, 51, 49, $codTarea, 200, 'TAREA#200', 40, 'S', '', $aud01, $aud03,
                            $codCargo, 5, 52, 49, $codTarea, 201, 'TAREA#201', 40, 'S', '', $aud01, $aud03,
                            $codCargo, 5, 4,  49, $codTarea, 202, 'TAREA#202', 40, 'S', '', $aud01, $aud03,

                            58, 51, 53, 49, $codTarea, 300, 'TAREA#300', 40, 'S', '', $aud01, $aud03,
                            58, 51, 52, 49, $codTarea, 301, 'TAREA#301', 40, 'S', '', $aud01, $aud03,
                            58, 51, 5,  49, $codTarea, 302, 'TAREA#302', 40, 'S', '', $aud01, $aud03,

                            56, 53, 7,  49, $codTarea, 400, 'TAREA#400', 40, 'S', '', $aud01, $aud03,
                            56, 53, 52, 49, $codTarea, 401, 'TAREA#401', 40, 'S', '', $aud01, $aud03,
                            56, 53, 51, 49, $codTarea, 402, 'TAREA#402', 40, 'S', '', $aud01, $aud03,

                            24, 7, 8, 49, $codTarea, 500, 'TAREA#500', 40, 'S', '', $aud01, $aud03,
                            24, 7, 52, 49, $codTarea, 501, 'TAREA#501', 40, 'S', '', $aud01, $aud03,
                            24, 7, 53, 49, $codTarea, 502, 'TAREA#502', 40, 'S', '', $aud01, $aud03,
                            24, 7, 54, 49, $codTarea, 503, 'TAREA#503', 40, 'S', '', $aud01, $aud03,

                            6, 7, 8, 49, $codTarea, 500, 'TAREA#500', 40, 'S', '', $aud01, $aud03,
                            6, 7, 52, 49, $codTarea, 501, 'TAREA#501', 40, 'S', '', $aud01, $aud03,
                            6, 7, 53, 49, $codTarea, 502, 'TAREA#502', 40, 'S', '', $aud01, $aud03,

                            6, 54, 8, 49, $codTarea, 600, 'TAREA#600', 40, 'S', '', $aud01, $aud03,
                            6, 54, 52, 49, $codTarea, 601, 'TAREA#601', 40, 'S', '', $aud01, $aud03,
                            6, 54, 7, 49, $codTarea, 602, 'TAREA#602', 40, 'S', '', $aud01, $aud03
                        ]
                    );
                }

                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success INSERT', 'codigo' => 0), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtMSSQL00->closeCursor();
                $stmtMSSQL01->closeCursor();
                $stmtMSSQL02->closeCursor();
                $stmtMSSQL03->closeCursor();

                $stmtMSSQL00 = null;
                $stmtMSSQL01 = null;
                $stmtMSSQL02 = null;
                $stmtMSSQL03 = null;
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

    $app->post('/v1/300/detalle', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getParsedBody()['tipo_cargo_codigo'];
        $val02      = $request->getParsedBody()['estado_anterior_codigo'];
        $val03      = $request->getParsedBody()['estado_siguiente_codigo'];
        $val04      = $request->getParsedBody()['tipo_prioridad_codigo'];
        $val05      = $request->getParsedBody()['workflow_codigo'];
        $val06      = $request->getParsedBody()['workflow_detalle_orden'];
        $val07      = trim(strtoupper(strtolower($request->getParsedBody()['workflow_detalle_tarea'])));
        $val08      = $request->getParsedBody()['workflow_detalle_hora'];
        $val09      = trim(strtoupper(strtolower($request->getParsedBody()['workflow_detalle_notifica'])));
        $val10      = trim(strtoupper(strtolower($request->getParsedBody()['workflow_detalle_observacion'])));

        $aud01      = trim(strtoupper(strtolower($request->getParsedBody()['auditoria_usuario'])));
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = trim(strtoupper(strtolower($request->getParsedBody()['auditoria_ip'])));

        if (isset($val01) && isset($val02) && isset($val03) && isset($val04) && isset($val05)) {
            $sql00  = "INSERT INTO [wrk].[WRKDET] (WRKDETTCC, WRKDETEAC, WRKDETESC, WRKDETTPC, WRKDETWFC, WRKDETORD, WRKDETNOM, WRKDETHOR, WRKDETNOT, WRKDETOBS, WRKDETAUS, WRKDETAFE, WRKDETAIP) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, GETDATE(), ?)";
            
            try {
                $connMSSQL  = getConnectionMSSQLv1();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);

                $stmtMSSQL00->execute([$val01, $val02, $val03, $val04, $val05, $val06, $val07, $val08, $val09, $val10, $aud01, $aud03]);

                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success INSERT', 'codigo' => 0), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

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
