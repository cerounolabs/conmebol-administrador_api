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
                                            $user_var06 = base64_encode($i[$j][0]);
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
            $sql04      = "INSERT INTO [adm].[DOMSOL] (DOMSOLEST, DOMSOLTST, DOMSOLORD, DOMSOLPC1, DOMSOLPC2, DOMSOLPC3, DOMSOLDIC, DOMSOLDIO, DOMSOLOBS, DOMSOLUSU, DOMSOLFEC, DOMSOLDIP) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, GETDATE(), ?)";

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

    $app->post('/v1/100/pais', function($request) {
        require __DIR__.'/../src/connect.php';

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

        if (isset($val01) && isset($val04) && isset($val07)) {    
            $sql00  = "INSERT INTO [adm].[LOCPAI] (LOCPAIEST, LOCPAIORD, LOCPAINOM, LOCPAIPAT, LOCPAIIC2, LOCPAIIC3, LOCPAIIN3, LOCPAIOBS, LOCPAIAUS, LOCPAIAFH, LOCPAIAIP) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, GETDATE(), ?)";

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

    $app->post('/v1/100/ciudad', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getParsedBody()['tipo_estado_codigo'];
        $val02      = $request->getParsedBody()['ciudad_orden'];
        $val03      = $request->getParsedBody()['pais_codigo'];
        $val04      = $request->getParsedBody()['ciudad_nombre'];
        $val05      = $request->getParsedBody()['ciudad_observacion'];

        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        if (isset($val01) && isset($val02) && isset($val04)) {    
            $sql00  = "INSERT INTO [adm].[LOCCIU] (LOCCIUEST, LOCCIUORD, LOCCIUPAC, LOCCIUNOM, LOCCIUOBS, LOCCIUAUS, LOCCIUAFH, LOCCIUAIP) VALUES (?, ?, ?, ?, ?, ?, GETDATE(), ?)";

            try {
                $connMSSQL  = getConnectionMSSQLv1();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val01, $val02, $val03, $val04, $val05, $aud01, $aud03]);

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
        $val12_1    = $request->getParsedBody()['solicitud_adjunto1'];
        $val12_2    = $request->getParsedBody()['solicitud_adjunto2'];
        $val12_3    = $request->getParsedBody()['solicitud_adjunto3'];
        $val12_4    = $request->getParsedBody()['solicitud_adjunto4'];
        $val13      = $request->getParsedBody()['solicitud_observacion_colaborador'];

        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        if (isset($val01) && isset($val02) && isset($val04)) {
            $sql00  = "INSERT INTO [hum].[SOLFIC] (SOLFICEST, SOLFICTST, SOLFICDOC, SOLFICFH1, SOLFICFH2, SOLFICFHC, SOLFICHO1, SOLFICHO2, SOLFICHOC, SOLFICPER, SOLFICDOJ, SOLFICADJ, SOLFICAD2, SOLFICAD3, SOLFICAD4, SOLFICUSC, SOLFICFCC, SOLFICIPC, SOLFICOBC, SOLFICUSU, SOLFICFEC, SOLFICDIP)
                                           SELECT          ?,         ?,         ?,        ?,          ?,         ?,        ?,          ?,         ?,        ?,          ?,         ?,         ?,        ?,          ?,        ?,  GETDATE(),        ?,         ?,         ?,  GETDATE(),     ? 
                                           WHERE NOT EXISTS(SELECT * FROM [hum].[SOLFIC] WHERE SOLFICEST = ? AND SOLFICTST = ? AND SOLFICDOC = ? AND SOLFICFH1 = ?)";
            $sql01  = "SELECT MAX(SOLFICCOD) AS solicitud_codigo FROM [hum].[SOLFIC] WHERE SOLFICEST = ? AND SOLFICTST = ? AND SOLFICDOC = ?";
            
            try {
                $connMSSQL  = getConnectionMSSQLv1();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL01= $connMSSQL->prepare($sql01);

                $stmtMSSQL00->execute([$val01, $val02, $val03, $val04, $val05, $val06, $val07, $val08, $val09, $val10, $val11, $val12_1, $val12_2, $val12_3, $val12_4, $aud01, $aud03, $val13, $aud01, $aud03, $val01, $val02, $val03, $val04]);
                
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

    $app->post('/v1/200/solicitudessap', function($request) {
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

                FROM [hum].[SOLFIC] a
                INNER JOIN [adm].[DOMSOL] b ON a.SOLFICTST = b.DOMSOLCOD
                
                WHERE a.SOLFICCOD = ?";

            $sql03  = "INSERT INTO [hum].[SOLAXI] (SOLAXICAB, SOLAXIEST, SOLAXISOL, SOLAXIDOC, SOLAXIFED, SOLAXIFEH, SOLAXIAPD, SOLAXIAPH, SOLAXICAN, SOLAXITIP, SOLAXIDIA, SOLAXIUNI, SOLAXICOM, SOLAXIIDP, SOLAXICON, SOLAXICLA, SOLAXILIN, SOLAXIORI, SOLAXIGRU, SOLAXIUSU, SOLAXIFEC, SOLAXIDIP) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, GETDATE(), ?)";

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
                    $SOLAXIEST  = trim(strtoupper($rowMSSQL01['solicitud_estado_codigo']));
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

                       //$SOLAXICON  = get_format($auxHor);
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
        $val03      = $request->getParsedBody()['tipo_cargo_codigo'];
        $val04      = $request->getParsedBody()['workflow_orden'];
        $val05      = trim(strtoupper(strtolower($request->getParsedBody()['workflow_tarea'])));
        $val06      = trim(strtoupper(strtolower($request->getParsedBody()['workflow_observacion'])));

        $aud01      = trim(strtoupper(strtolower($request->getParsedBody()['auditoria_usuario'])));
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = trim(strtoupper(strtolower($request->getParsedBody()['auditoria_ip'])));

        if (isset($val01) && isset($val02) && isset($val03)) {        
            $sql00  = "INSERT INTO [wrk].[WRKFIC] (WRKFICEST, WRKFICTWC, WRKFICTCC, WRKFICORD, WRKFICNOM, WRKFICOBS, WRKFICAUS, WRKFICAFE, WRKFICAIP) VALUES (?, ?, (SELECT 'WF: ' + RTRIM(LTRIM(a.U_NOMBRE)) FROM [CSF].[dbo].[@A1A_TICA] a WHERE CAST(a.U_CODIGO AS INT) = ?), ?, ?, ?, ?, GETDATE(), ?)";
            
            try {
                $connMSSQL  = getConnectionMSSQLv1();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);

                $stmtMSSQL00->execute([$val01, $val02, $val03, $val04, $val05, $val06, $aud01, $aud03]);

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
        $val03      = $request->getParsedBody()['tipo_cargo_codigo'];
        $val04      = $request->getParsedBody()['workflow_orden'];
        $val05      = trim(strtoupper(strtolower($request->getParsedBody()['workflow_tarea'])));
        $val06      = trim(strtoupper(strtolower($request->getParsedBody()['workflow_observacion'])));

        $aud01      = trim(strtoupper(strtolower($request->getParsedBody()['auditoria_usuario'])));
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = trim(strtoupper(strtolower($request->getParsedBody()['auditoria_ip'])));

        if (isset($val01) && isset($val02) && isset($val03)) {      
            $sql00  = "SELECT CAST(a.U_CODIGO AS INT) AS tipo_cargo_codigo, a.U_NOMBRE AS tipo_cargo_nombre FROM [CSF].[dbo].[@A1A_TICA] a WHERE NOT EXISTS (SELECT * FROM [wrk].[WRKFIC] b WHERE b.WRKFICTCC = a.U_CODIGO AND b.WRKFICTWC = ?)";
            $sql01  = "INSERT INTO [wrk].[WRKFIC] (WRKFICEST, WRKFICTWC, WRKFICTCC, WRKFICORD, WRKFICNOM, WRKFICOBS, WRKFICAUS, WRKFICAFE, WRKFICAIP) VALUES (?, ?, ?, ?, ?, ?, ?, GETDATE(), ?)";
            $sql02  = "SELECT a.WRKFICCOD AS workflow_codigo, a.WRKFICTCC AS tipo_cargo_codigo, a.WRKFICNOM AS workflow_tarea FROM [wrk].[WRKFIC] a WHERE a.WRKFICTWC = ? AND NOT EXISTS(SELECT * FROM [wrk].[WRKDET] b WHERE a.WRKFICCOD = b.WRKDETWFC)";

            switch ($val02) {
                case 38:
                    $sql03  = "INSERT INTO [wrk].[WRKDET]
                        (WRKDETTCC, WRKDETEAC, WRKDETECC, WRKDETTPC, WRKDETWFC, WRKDETORD, WRKDETNOM, WRKDETHOR, WRKDETNOT, WRKDETOBS, WRKDETAUS, WRKDETAFE, WRKDETAIP) VALUES 
                        (        ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?, GETDATE(),         ?),
                        (        ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?, GETDATE(),         ?),
                        (        ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?, GETDATE(),         ?),
                        
                        ((SELECT CASE WHEN a.U_CARSUP IS NOT NULL THEN CAST(a.U_CARSUP AS INT) ELSE CAST(a.U_CODIGO AS INT) END FROM [CSF].[dbo].[@A1A_TICA] a WHERE CAST(a.U_CODIGO AS INT) = ?),         ?,         ?,         ?,         ?,         ?, (SELECT 'TAREA#200: PENDIENTE EN ' + RTRIM(LTRIM(a.U_NOMBRE)) FROM [CSF].[dbo].[@A1A_TICA] a WHERE CAST(a.U_CODIGO AS INT) = ?),         ?,         ?,         ?,         ?, GETDATE(),         ?),
                        ((SELECT CASE WHEN a.U_CARSUP IS NOT NULL THEN CAST(a.U_CARSUP AS INT) ELSE CAST(a.U_CODIGO AS INT) END FROM [CSF].[dbo].[@A1A_TICA] a WHERE CAST(a.U_CODIGO AS INT) = ?),         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?, GETDATE(),         ?),
                        ((SELECT CASE WHEN a.U_CARSUP IS NOT NULL THEN CAST(a.U_CARSUP AS INT) ELSE CAST(a.U_CODIGO AS INT) END FROM [CSF].[dbo].[@A1A_TICA] a WHERE CAST(a.U_CODIGO AS INT) = ?),         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?, GETDATE(),         ?),
                        
                        (        ?,         ?,         ?,         ?,         ?,         ?, (SELECT 'TAREA#300: PENDIENTE EN ' + RTRIM(LTRIM(a.U_NOMBRE)) FROM [CSF].[dbo].[@A1A_TICA] a WHERE CAST(a.U_CODIGO AS INT) = ?),         ?,         ?,         ?,         ?, GETDATE(),         ?),
                        (        ?,         ?,         ?,         ?,         ?,         ?, (SELECT 'TAREA#301: RECHAZADO POR ' + RTRIM(LTRIM(a.U_NOMBRE)) FROM [CSF].[dbo].[@A1A_TICA] a WHERE CAST(a.U_CODIGO AS INT) = ?),         ?,         ?,         ?,         ?, GETDATE(),         ?),
                        (        ?,         ?,         ?,         ?,         ?,         ?, (SELECT 'TAREA#302: VUELVE AL ESTADO ANTERIOR POR ' + RTRIM(LTRIM(a.U_NOMBRE)) FROM [CSF].[dbo].[@A1A_TICA] a WHERE CAST(a.U_CODIGO AS INT) = ?),         ?,         ?,         ?,         ?, GETDATE(),         ?),
                        
                        (        ?,         ?,         ?,         ?,         ?,         ?, (SELECT 'TAREA#400: PENDIENTE EN ' + RTRIM(LTRIM(a.U_NOMBRE)) FROM [CSF].[dbo].[@A1A_TICA] a WHERE CAST(a.U_CODIGO AS INT) = ?),         ?,         ?,         ?,         ?, GETDATE(),         ?),
                        (        ?,         ?,         ?,         ?,         ?,         ?, (SELECT 'TAREA#401: RECHAZADO POR ' + RTRIM(LTRIM(a.U_NOMBRE)) FROM [CSF].[dbo].[@A1A_TICA] a WHERE CAST(a.U_CODIGO AS INT) = ?),         ?,         ?,         ?,         ?, GETDATE(),         ?),
                        (        ?,         ?,         ?,         ?,         ?,         ?, (SELECT 'TAREA#402: VUELVE AL ESTADO ANTERIOR POR ' + RTRIM(LTRIM(a.U_NOMBRE)) FROM [CSF].[dbo].[@A1A_TICA] a WHERE CAST(a.U_CODIGO AS INT) = ?),         ?,         ?,         ?,         ?, GETDATE(),         ?),
                        
                        (        ?,         ?,         ?,         ?,         ?,         ?, (SELECT 'TAREA#500: PENDIENTE EN ' + RTRIM(LTRIM(a.U_NOMBRE)) FROM [CSF].[dbo].[@A1A_TICA] a WHERE CAST(a.U_CODIGO AS INT) = ?),         ?,         ?,         ?,         ?, GETDATE(),         ?),
                        (        ?,         ?,         ?,         ?,         ?,         ?, (SELECT 'TAREA#501: RECHAZADO POR ' + RTRIM(LTRIM(a.U_NOMBRE)) FROM [CSF].[dbo].[@A1A_TICA] a WHERE CAST(a.U_CODIGO AS INT) = ?),         ?,         ?,         ?,         ?, GETDATE(),         ?),
                        (        ?,         ?,         ?,         ?,         ?,         ?, (SELECT 'TAREA#502: VUELVE AL ESTADO ANTERIOR POR ' + RTRIM(LTRIM(a.U_NOMBRE)) FROM [CSF].[dbo].[@A1A_TICA] a WHERE CAST(a.U_CODIGO AS INT) = ?),         ?,         ?,         ?,         ?, GETDATE(),         ?),
                        (        ?,         ?,         ?,         ?,         ?,         ?, (SELECT 'TAREA#503: APROBADO POR ' + RTRIM(LTRIM(a.U_NOMBRE)) FROM [CSF].[dbo].[@A1A_TICA] a WHERE CAST(a.U_CODIGO AS INT) = ?),         ?,         ?,         ?,         ?, GETDATE(),         ?),

                        (        ?,         ?,         ?,         ?,         ?,         ?, (SELECT 'TAREA#600: APROBADO POR ' + RTRIM(LTRIM(a.U_NOMBRE)) FROM [CSF].[dbo].[@A1A_TICA] a WHERE CAST(a.U_CODIGO AS INT) = ?),         ?,         ?,         ?,         ?, GETDATE(),         ?),
                        (        ?,         ?,         ?,         ?,         ?,         ?, (SELECT 'TAREA#601: RECHAZADO POR ' + RTRIM(LTRIM(a.U_NOMBRE)) FROM [CSF].[dbo].[@A1A_TICA] a WHERE CAST(a.U_CODIGO AS INT) = ?),         ?,         ?,         ?,         ?, GETDATE(),         ?),
                        (        ?,         ?,         ?,         ?,         ?,         ?, (SELECT 'TAREA#602: VUELVE AL ESTADO ANTERIOR POR ' + RTRIM(LTRIM(a.U_NOMBRE)) FROM [CSF].[dbo].[@A1A_TICA] a WHERE CAST(a.U_CODIGO AS INT) = ?),         ?,         ?,         ?,         ?, GETDATE(),         ?)";
                    
                    break;
                
                case 47:
                    $sql03  = "INSERT INTO [wrk].[WRKDET]
                        (WRKDETTCC, WRKDETEAC, WRKDETECC, WRKDETTPC, WRKDETWFC, WRKDETORD, WRKDETNOM, WRKDETHOR, WRKDETNOT, WRKDETOBS, WRKDETAUS, WRKDETAFE, WRKDETAIP) VALUES 
                        (        ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?, GETDATE(),         ?),
                        (        ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?, GETDATE(),         ?),
                        (        ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?, GETDATE(),         ?),
                        
                        ((SELECT CASE WHEN a.U_CARSUP IS NOT NULL THEN CAST(a.U_CARSUP AS INT) ELSE CAST(a.U_CODIGO AS INT) END FROM [CSF].[dbo].[@A1A_TICA] a WHERE CAST(a.U_CODIGO AS INT) = ?),         ?,         ?,         ?,         ?,         ?, (SELECT 'TAREA#200: PENDIENTE EN ' + RTRIM(LTRIM(a.U_NOMBRE)) FROM [CSF].[dbo].[@A1A_TICA] a WHERE CAST(a.U_CODIGO AS INT) = ?),         ?,         ?,         ?,         ?, GETDATE(),         ?),
                        ((SELECT CASE WHEN a.U_CARSUP IS NOT NULL THEN CAST(a.U_CARSUP AS INT) ELSE CAST(a.U_CODIGO AS INT) END FROM [CSF].[dbo].[@A1A_TICA] a WHERE CAST(a.U_CODIGO AS INT) = ?),         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?, GETDATE(),         ?),
                        ((SELECT CASE WHEN a.U_CARSUP IS NOT NULL THEN CAST(a.U_CARSUP AS INT) ELSE CAST(a.U_CODIGO AS INT) END FROM [CSF].[dbo].[@A1A_TICA] a WHERE CAST(a.U_CODIGO AS INT) = ?),         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?,         ?, GETDATE(),         ?),
                        
                        (        ?,         ?,         ?,         ?,         ?,         ?, (SELECT 'TAREA#300: PENDIENTE EN ' + RTRIM(LTRIM(a.U_NOMBRE)) FROM [CSF].[dbo].[@A1A_TICA] a WHERE CAST(a.U_CODIGO AS INT) = ?),         ?,         ?,         ?,         ?, GETDATE(),         ?),
                        (        ?,         ?,         ?,         ?,         ?,         ?, (SELECT 'TAREA#301: RECHAZADO POR ' + RTRIM(LTRIM(a.U_NOMBRE)) FROM [CSF].[dbo].[@A1A_TICA] a WHERE CAST(a.U_CODIGO AS INT) = ?),         ?,         ?,         ?,         ?, GETDATE(),         ?),
                        (        ?,         ?,         ?,         ?,         ?,         ?, (SELECT 'TAREA#302: VUELVE AL ESTADO ANTERIOR POR ' + RTRIM(LTRIM(a.U_NOMBRE)) FROM [CSF].[dbo].[@A1A_TICA] a WHERE CAST(a.U_CODIGO AS INT) = ?),         ?,         ?,         ?,         ?, GETDATE(),         ?),
                        
                        (        ?,         ?,         ?,         ?,         ?,         ?, (SELECT 'TAREA#400: PENDIENTE EN ' + RTRIM(LTRIM(a.U_NOMBRE)) FROM [CSF].[dbo].[@A1A_TICA] a WHERE CAST(a.U_CODIGO AS INT) = ?),         ?,         ?,         ?,         ?, GETDATE(),         ?),
                        (        ?,         ?,         ?,         ?,         ?,         ?, (SELECT 'TAREA#401: RECHAZADO POR ' + RTRIM(LTRIM(a.U_NOMBRE)) FROM [CSF].[dbo].[@A1A_TICA] a WHERE CAST(a.U_CODIGO AS INT) = ?),         ?,         ?,         ?,         ?, GETDATE(),         ?),
                        (        ?,         ?,         ?,         ?,         ?,         ?, (SELECT 'TAREA#402: VUELVE AL ESTADO ANTERIOR POR ' + RTRIM(LTRIM(a.U_NOMBRE)) FROM [CSF].[dbo].[@A1A_TICA] a WHERE CAST(a.U_CODIGO AS INT) = ?),         ?,         ?,         ?,         ?, GETDATE(),         ?),
                        
                        (        ?,         ?,         ?,         ?,         ?,         ?, (SELECT 'TAREA#500: PENDIENTE EN ' + RTRIM(LTRIM(a.U_NOMBRE)) FROM [CSF].[dbo].[@A1A_TICA] a WHERE CAST(a.U_CODIGO AS INT) = ?),         ?,         ?,         ?,         ?, GETDATE(),         ?),
                        (        ?,         ?,         ?,         ?,         ?,         ?, (SELECT 'TAREA#501: RECHAZADO POR ' + RTRIM(LTRIM(a.U_NOMBRE)) FROM [CSF].[dbo].[@A1A_TICA] a WHERE CAST(a.U_CODIGO AS INT) = ?),         ?,         ?,         ?,         ?, GETDATE(),         ?),
                        (        ?,         ?,         ?,         ?,         ?,         ?, (SELECT 'TAREA#502: VUELVE AL ESTADO ANTERIOR POR ' + RTRIM(LTRIM(a.U_NOMBRE)) FROM [CSF].[dbo].[@A1A_TICA] a WHERE CAST(a.U_CODIGO AS INT) = ?),         ?,         ?,         ?,         ?, GETDATE(),         ?),
                        (        ?,         ?,         ?,         ?,         ?,         ?, (SELECT 'TAREA#503: APROBADO POR ' + RTRIM(LTRIM(a.U_NOMBRE)) FROM [CSF].[dbo].[@A1A_TICA] a WHERE CAST(a.U_CODIGO AS INT) = ?),         ?,         ?,         ?,         ?, GETDATE(),         ?),

                        (        ?,         ?,         ?,         ?,         ?,         ?, (SELECT 'TAREA#600: APROBADO POR ' + RTRIM(LTRIM(a.U_NOMBRE)) FROM [CSF].[dbo].[@A1A_TICA] a WHERE CAST(a.U_CODIGO AS INT) = ?),         ?,         ?,         ?,         ?, GETDATE(),         ?),
                        (        ?,         ?,         ?,         ?,         ?,         ?, (SELECT 'TAREA#601: RECHAZADO POR ' + RTRIM(LTRIM(a.U_NOMBRE)) FROM [CSF].[dbo].[@A1A_TICA] a WHERE CAST(a.U_CODIGO AS INT) = ?),         ?,         ?,         ?,         ?, GETDATE(),         ?),
                        (        ?,         ?,         ?,         ?,         ?,         ?, (SELECT 'TAREA#602: VUELVE AL ESTADO ANTERIOR POR ' + RTRIM(LTRIM(a.U_NOMBRE)) FROM [CSF].[dbo].[@A1A_TICA] a WHERE CAST(a.U_CODIGO AS INT) = ?),         ?,         ?,         ?,         ?, GETDATE(),         ?),

                        (        ?,         ?,         ?,         ?,         ?,         ?, (SELECT 'TAREA#700: APROBADO POR ' + RTRIM(LTRIM(a.U_NOMBRE)) FROM [CSF].[dbo].[@A1A_TICA] a WHERE CAST(a.U_CODIGO AS INT) = ?),         ?,         ?,         ?,         ?, GETDATE(),         ?),
                        (        ?,         ?,         ?,         ?,         ?,         ?, (SELECT 'TAREA#701: RECHAZADO POR ' + RTRIM(LTRIM(a.U_NOMBRE)) FROM [CSF].[dbo].[@A1A_TICA] a WHERE CAST(a.U_CODIGO AS INT) = ?),         ?,         ?,         ?,         ?, GETDATE(),         ?),
                        (        ?,         ?,         ?,         ?,         ?,         ?, (SELECT 'TAREA#702: VUELVE AL ESTADO ANTERIOR POR ' + RTRIM(LTRIM(a.U_NOMBRE)) FROM [CSF].[dbo].[@A1A_TICA] a WHERE CAST(a.U_CODIGO AS INT) = ?),         ?,         ?,         ?,         ?, GETDATE(),         ?),

                        (        ?,         ?,         ?,         ?,         ?,         ?, (SELECT 'TAREA#800: APROBADO POR ' + RTRIM(LTRIM(a.U_NOMBRE)) FROM [CSF].[dbo].[@A1A_TICA] a WHERE CAST(a.U_CODIGO AS INT) = ?),         ?,         ?,         ?,         ?, GETDATE(),         ?),
                        (        ?,         ?,         ?,         ?,         ?,         ?, (SELECT 'TAREA#801: RECHAZADO POR ' + RTRIM(LTRIM(a.U_NOMBRE)) FROM [CSF].[dbo].[@A1A_TICA] a WHERE CAST(a.U_CODIGO AS INT) = ?),         ?,         ?,         ?,         ?, GETDATE(),         ?),
                        (        ?,         ?,         ?,         ?,         ?,         ?, (SELECT 'TAREA#802: VUELVE AL ESTADO ANTERIOR POR ' + RTRIM(LTRIM(a.U_NOMBRE)) FROM [CSF].[dbo].[@A1A_TICA] a WHERE CAST(a.U_CODIGO AS INT) = ?),         ?,         ?,         ?,         ?, GETDATE(),         ?),

                        (        ?,         ?,         ?,         ?,         ?,         ?, (SELECT 'TAREA#900: APROBADO POR ' + RTRIM(LTRIM(a.U_NOMBRE)) FROM [CSF].[dbo].[@A1A_TICA] a WHERE CAST(a.U_CODIGO AS INT) = ?),         ?,         ?,         ?,         ?, GETDATE(),         ?),
                        (        ?,         ?,         ?,         ?,         ?,         ?, (SELECT 'TAREA#901: RECHAZADO POR ' + RTRIM(LTRIM(a.U_NOMBRE)) FROM [CSF].[dbo].[@A1A_TICA] a WHERE CAST(a.U_CODIGO AS INT) = ?),         ?,         ?,         ?,         ?, GETDATE(),         ?),
                        (        ?,         ?,         ?,         ?,         ?,         ?, (SELECT 'TAREA#902: VUELVE AL ESTADO ANTERIOR POR ' + RTRIM(LTRIM(a.U_NOMBRE)) FROM [CSF].[dbo].[@A1A_TICA] a WHERE CAST(a.U_CODIGO AS INT) = ?),         ?,         ?,         ?,         ?, GETDATE(),         ?);";
                    break;
            }

            try {
                $connMSSQL  = getConnectionMSSQLv1();

                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL01= $connMSSQL->prepare($sql01);
                $stmtMSSQL02= $connMSSQL->prepare($sql02);
                $stmtMSSQL03= $connMSSQL->prepare($sql03);

                $stmtMSSQL00->execute([$val02]);

                while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                    $stmtMSSQL01->execute([$val01, $val02, $rowMSSQL00['tipo_cargo_codigo'], $val04, 'WF: '.trim(strtoupper(strtolower($rowMSSQL00['tipo_cargo_nombre']))), $val06, $aud01, $aud03]);
                }

                $stmtMSSQL02->execute([$val02]);

                while ($rowMSSQL02 = $stmtMSSQL02->fetch()) {
                    $codTarea = $rowMSSQL02['workflow_codigo'];
                    $codCargo = $rowMSSQL02['tipo_cargo_codigo'];

                    switch ($val02) {
                        case 38:
                            $stmtMSSQL03->execute([
                                $codCargo, 4,  4, 49, $codTarea, 100, 'TAREA#100: NUEVO EN SOLICITANTE',    40, 'S', '', $aud01, $aud03,
                                $codCargo, 4,  5, 49, $codTarea, 101, 'TAREA#101: PENDIENTE EN JEFE INMEDIATO',    40, 'S', '', $aud01, $aud03,
                                $codCargo, 4,  6, 49, $codTarea, 102, 'TAREA#102: ANULADO POR SOLICITANTE',      40, 'S', '', $aud01, $aud03,
        
                                $codCargo, 5, 51, 49, $codTarea, 200, 58, 40, 'S', '', $aud01, $aud03,
                                $codCargo, 5, 52, 49, $codTarea, 201, 'TAREA#201: RECHAZADO POR JEFE INMEDIATO', 40, 'S', '', $aud01, $aud03,
                                $codCargo, 5,  4, 49, $codTarea, 202, 'TAREA#202: VUELVE AL ESTADO ANTERIOR POR JEFE INMEDIATO',              40, 'S', '', $aud01, $aud03,
        
                                58, 51, 53, 49, $codTarea, 300, 56, 40, 'S', '', $aud01, $aud03,
                                58, 51, 52, 49, $codTarea, 301, 58, 40, 'S', '', $aud01, $aud03,
                                58, 51,  5, 49, $codTarea, 302, 58, 40, 'S', '', $aud01, $aud03,
        
                                56, 53,  7, 49, $codTarea, 400, 24, 40, 'S', '', $aud01, $aud03,
                                56, 53, 52, 49, $codTarea, 401, 56, 40, 'S', '', $aud01, $aud03,
                                56, 53, 51, 49, $codTarea, 402, 56, 40, 'S', '', $aud01, $aud03,
        
                                24,  7, 54, 49, $codTarea, 500,  6, 40, 'S', '', $aud01, $aud03,
                                24,  7, 52, 49, $codTarea, 501, 24, 40, 'S', '', $aud01, $aud03,
                                24,  7, 53, 49, $codTarea, 502, 24, 40, 'S', '', $aud01, $aud03,
                                24,  7,  8, 49, $codTarea, 503, 24, 40, 'S', '', $aud01, $aud03,

                                 6, 54,  8, 49, $codTarea, 600,  6, 40, 'S', '', $aud01, $aud03,
                                 6, 54, 52, 49, $codTarea, 601,  6, 40, 'S', '', $aud01, $aud03,
                                 6, 54,  7, 49, $codTarea, 602,  6, 40, 'S', '', $aud01, $aud03
                            ]);

                            break;

                        case 47:
                            $stmtMSSQL03->execute([
                                $codCargo,  73, 73, 49,     $codTarea,  100,    'TAREA#100: ', 40, 'N', '', $aud01, $aud03,
                                $codCargo,  73,  5, 49,     $codTarea,  101,    'TAREA#101: ', 40, 'N', '', $aud01, $aud03,
                                $codCargo,  73, 79, 49,     $codTarea,  102,    'TAREA#102: ', 40, 'N', '', $aud01, $aud03,
        
                                $codCargo,   5, 81, 49,     $codTarea,  200,    'TAREA#200: ', 40, 'N', '', $aud01, $aud03,
                                $codCargo,   5, 80, 49,     $codTarea,  201,    'TAREA#201: ', 40, 'N', '', $aud01, $aud03,
                                $codCargo,   5, 73, 49,     $codTarea,  202,    'TAREA#202: ', 40, 'N', '', $aud01, $aud03,
        
                                60,         81, 74, 49,     $codTarea,  300,    'TAREA#300: ', 40, 'N', '', $aud01, $aud03,
                                60,         81, 82, 49,     $codTarea,  301,    'TAREA#301: ', 40, 'N', '', $aud01, $aud03,
                                60,         81,  5, 49,     $codTarea,  302,    'TAREA#302: ', 40, 'N', '', $aud01, $aud03,
        
                                56,         53,  7, 49,     $codTarea,  400,    'TAREA#400: ', 40, 'N', '', $aud01, $aud03,
                                56,         53, 52, 49,     $codTarea,  401,    'TAREA#401: ', 40, 'N', '', $aud01, $aud03,
                                56,         53, 51, 49,     $codTarea,  402,    'TAREA#402: ', 40, 'N', '', $aud01, $aud03,
        
                                24,          7, 54, 49,     $codTarea,  500,    'TAREA#500: ', 40, 'N', '', $aud01, $aud03,
                                24,          7, 52, 49,     $codTarea,  501,    'TAREA#501: ', 40, 'N', '', $aud01, $aud03,
                                24,          7, 53, 49,     $codTarea,  502,    'TAREA#502: ', 40, 'N', '', $aud01, $aud03,
                                24,          7,  8, 49,     $codTarea,  503,    'TAREA#503: ', 40, 'N', '', $aud01, $aud03,

                                 6,         54,  8, 49,     $codTarea,  600,    'TAREA#600: ', 40, 'N', '', $aud01, $aud03,
                                 6,         54, 52, 49,     $codTarea,  601,    'TAREA#601: ', 40, 'N', '', $aud01, $aud03,
                                 6,         54,  7, 49,     $codTarea,  602,    'TAREA#602: ', 40, 'N', '', $aud01, $aud03,
                                 6,         54,  7, 49,     $codTarea,  603,    'TAREA#603: ', 40, 'N', '', $aud01, $aud03,

                                 6,         54,  8, 49,     $codTarea,  700,    'TAREA#700: ', 40, 'N', '', $aud01, $aud03,
                                 6,         54, 52, 49,     $codTarea,  701,    'TAREA#701: ', 40, 'N', '', $aud01, $aud03,
                                 6,         54,  7, 49,     $codTarea,  702,    'TAREA#702: ', 40, 'N', '', $aud01, $aud03,
                                 6,         54,  7, 49,     $codTarea,  703,    'TAREA#703: ', 40, 'N', '', $aud01, $aud03,

                                 6,         54,  8, 49,     $codTarea,  800,    'TAREA#800: ', 40, 'N', '', $aud01, $aud03,
                                 6,         54, 52, 49,     $codTarea,  801,    'TAREA#801: ', 40, 'N', '', $aud01, $aud03,
                                 6,         54,  7, 49,     $codTarea,  802,    'TAREA#802: ', 40, 'N', '', $aud01, $aud03,
                                 6,         54,  7, 49,     $codTarea,  803,    'TAREA#803: ', 40, 'N', '', $aud01, $aud03,
                                 6,         54,  7, 49,     $codTarea,  804,    'TAREA#804: ', 40, 'N', '', $aud01, $aud03,

                                 6,         54,  8, 49,     $codTarea,  900,    'TAREA#900: ', 40, 'N', '', $aud01, $aud03,
                                 6,         54, 52, 49,     $codTarea,  901,    'TAREA#901: ', 40, 'N', '', $aud01, $aud03,
                            ]);
                            break;
                    }
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
        $val03      = $request->getParsedBody()['estado_actual_codigo'];
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
            $sql00  = "INSERT INTO [wrk].[WRKDET] (WRKDETTCC, WRKDETEAC, WRKDETECC, WRKDETTPC, WRKDETWFC, WRKDETORD, WRKDETNOM, WRKDETHOR, WRKDETNOT, WRKDETOBS, WRKDETAUS, WRKDETAFE, WRKDETAIP) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, GETDATE(), ?)";
            
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
    
    $app->post('/v1/400/proveedor', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getParsedBody()['tipo_estado_codigo'];
        $val02      = $request->getParsedBody()['tipo_proveedor_codigo'];
        $val03      = $request->getParsedBody()['localidad_ciudad_codigo'];
        $val04      = trim(strtoupper(strtolower($request->getParsedBody()['proveedor_nombre'])));
        $val05      = trim(strtoupper(strtolower($request->getParsedBody()['proveedor_razon_social'])));
        $val06      = trim(strtoupper(strtolower($request->getParsedBody()['proveedor_ruc'])));
        $val07      = trim(strtoupper(strtolower($request->getParsedBody()['proveedor_pais'])));
        $val08      = trim(strtoupper(strtolower($request->getParsedBody()['proveedor_direccion'])));
        $val09      = trim(strtoupper(strtolower($request->getParsedBody()['proveedor_sap_castastrado'])));
        $val10      = trim(strtoupper(strtolower($request->getParsedBody()['proveedor_sap_codigo'])));
        $val11      = trim(strtoupper(strtolower($request->getParsedBody()['proveedor_observacion'])));

        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        if (isset($val01) && isset($val02) && isset($val03) && isset($val04) && isset($val05) && isset($val06)) {        
            $sql00  = "INSERT INTO [via].[PROFIC] (PROFICEST, PROFICTPC, PROFICCIC, PROFICNOM, PROFICRAZ, PROFICRUC, PROFICPAI, PROFICDIR, PROFICSPC, PROFICSPI, PROFICOBS, PROFICAUS, PROFICAFH, PROFICAIP) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, GETDATE(), ?)";
            $sql01  = "SELECT MAX(PROFICCOD) AS proveedor_codigo FROM [via].[PROFIC]";

            try {
                $connMSSQL  = getConnectionMSSQLv1();

                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val01, $val02, $val03, $val04, $val05, $val06, $val07, $val08, $val09, $val10, $val11, $aud01, $aud03]);
                
                $stmtMSSQL01= $connMSSQL->prepare($sql01);
                $stmtMSSQL01->execute();
                $row_mssql01= $stmtMSSQL01->fetch(PDO::FETCH_ASSOC);
                $codigo     = $row_mssql01['proveedor_codigo'];

                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success INSERT', 'codigo' => $codigo), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

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

    $app->post('/v1/400/proveedor/contacto', function($request) { 
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getParsedBody()['tipo_estado_codigo'];
        $val02      = $request->getParsedBody()['proveedor_codigo'];
        $val03      = trim(strtoupper(strtolower($request->getParsedBody()['proveedor_contacto_nombre'])));
        $val04      = trim(strtolower($request->getParsedBody()['proveedor_contacto_email']));
        $val05      = trim(strtoupper(strtolower($request->getParsedBody()['proveedor_contacto_telefono'])));
        $val06      = trim(strtoupper(strtolower($request->getParsedBody()['proveedor_contacto_whatsapp'])));
        $val07      = trim(strtoupper(strtolower($request->getParsedBody()['proveedor_contacto_skype'])));
        $val08      = trim(strtoupper(strtolower($request->getParsedBody()['proveedor_contacto_observacion'])));

        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        if (isset($val01) && isset($val02) && isset($val03)) {        
            $sql00  = "INSERT INTO [via].[PROCON] (PROCONEST, PROCONPRC, PROCONNOM, PROCONEMA, PROCONTEL, PROCONWHA, PROCONSKY, PROCONOBS, PROCONAUS, PROCONAFH, PROCONAIP) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, GETDATE(), ?)";
            
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

    $app->post('/v1/400/proveedor/habitacion', function($request) {
        require __DIR__.'/../src/connect.php';

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

        if (isset($val01) && isset($val02) && isset($val03)) {        
            $sql00  = "INSERT INTO [via].[PROHAB] (PROHABEST, PROHABTHC, PROHABPRC, PROHABNOM, PROHABPRE, PROHABCAN, PROHABPAT, PROHABOBS, PROHABAUS, PROHABAFH, PROHABAIP) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, GETDATE(), ?)";
            
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

    $app->post('/v1/500/rendicion', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getParsedBody()['estado_anterior_codigo'];
        $val02      = $request->getParsedBody()['estado_actual_codigo'];
        $val03      = $request->getParsedBody()['tipo_gerencia_codigo'];
        $val04      = $request->getParsedBody()['tipo_departamento_codigo'];
        $val05      = $request->getParsedBody()['tipo_jefatura_codigo'];
        $val06      = $request->getParsedBody()['tipo_cargo_codigo'];
        $val07      = $request->getParsedBody()['ciudad_codigo'];
        $val08      = $request->getParsedBody()['workflow_codigo'];
        $val09      = $request->getParsedBody()['rendicion_periodo'];
        $val10      = trim(strtoupper(strtolower($request->getParsedBody()['rendicion_evento_nombre'])));
        $val11      = trim(strtoupper(strtolower($request->getParsedBody()['rendicion_documento_solicitante'])));
        $val12      = trim(strtoupper(strtolower($request->getParsedBody()['rendicion_documento_jefatura'])));
        $val13      = trim(strtoupper(strtolower($request->getParsedBody()['rendicion_documento_analista'])));
        $val14      = $request->getParsedBody()['rendicion_carga_fecha'];
        $val15      = $request->getParsedBody()['rendicion_evento_fecha'];
        $val16      = trim(strtoupper(strtolower($request->getParsedBody()['rendicion_observacion'])));

        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        if (isset($val01) && isset($val02) && isset($val03) && isset($val04) && isset($val05) && isset($val06) && isset($val07) && isset($val08) && isset($val09)) {
            $sql00  = "INSERT INTO [con].[RENFIC] (RENFICEAC, RENFICECC, RENFICGEC, RENFICDEC, RENFICJEC, RENFICCAC, RENFICCIC, RENFICWFC, RENFICPER, RENFICEVE, RENFICDNS, RENFICDNJ, RENFICDNA, RENFICFEC, RENFICFEE, RENFICOBS, RENFICAUS, RENFICAFH, RENFICAIP) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, GETDATE(), ?)";
            $sql01  = "SELECT MAX(RENFICCOD) AS rendicion_codigo FROM [con].[RENFIC]";

            try {
                $connMSSQL  = getConnectionMSSQLv1();

                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val01, $val02, $val03, $val04, $val05, $val06, $val07, $val08, $val09, $val10, $val11, $val12, $val13, $val14, $val15, $val16, $aud01, $aud03]);

                $stmtMSSQL01= $connMSSQL->prepare($sql01);
                $stmtMSSQL01->execute();
                $row_mssql01= $stmtMSSQL01->fetch(PDO::FETCH_ASSOC);
                $codigo     = $row_mssql01['rendicion_codigo'];

                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success INSERT', 'codigo' => $codigo), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

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

    $app->post('/v1/500/cabecera', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getParsedBody()['estado_anterior_codigo'];
        $val02      = $request->getParsedBody()['estado_actual_codigo'];
        $val03      = $request->getParsedBody()['tipo_moneda_codigo'];
        $val04      = $request->getParsedBody()['tipo_factura_codigo'];
        $val05      = $request->getParsedBody()['tipo_condicion_codigo'];
        $val06      = $request->getParsedBody()['workflow_codigo'];
        $val07      = $request->getParsedBody()['rendicion_codigo'];
        $val08      = trim(strtoupper(strtolower($request->getParsedBody()['rendicion_cabecera_timbrado_numero'])));
        $val09      = $request->getParsedBody()['rendicion_cabecera_timbrado_vencimiento'];
        $val10      = $request->getParsedBody()['rendicion_cabecera_factura_fecha'];
        $val11      = trim(strtoupper(strtolower($request->getParsedBody()['rendicion_cabecera_factura_numero'])));
        $val12      = trim(strtoupper(strtolower($request->getParsedBody()['rendicion_cabecera_factura_razonsocial'])));
        $val13      = trim(strtolower($request->getParsedBody()['rendicion_cabecera_factura_adjunto']));
        $val14      = $request->getParsedBody()['rendicion_cabecera_factura_importe'];
        $val15      = trim(strtoupper(strtolower($request->getParsedBody()['rendicion_cabecera_observacion'])));

        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        if (isset($val01) && isset($val02) && isset($val03) && isset($val04) && isset($val05) && isset($val06) && isset($val07)) {        
            $sql00  = "INSERT INTO [con].[RENFCA] (RENFCAEAC, RENFCAECC, RENFCATMC, RENFCATFC, RENFCATCC, RENFCAWFC, RENFCAREC, RENFCATNR, RENFCATVE, RENFCAFFE, RENFCAFNU, RENFCAFRS, RENFCAFAD, RENFCAFTO, RENFCAOBS, RENFCAAUS, RENFCAAFH, RENFCAAIP) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, GETDATE(), ?)";
            $sql01  = "SELECT MAX(RENFCACOD) AS rendicion_cabecera_codigo FROM [con].[RENFCA]";
            
            try {
                $connMSSQL  = getConnectionMSSQLv1();

                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val01, $val02, $val03, $val04, $val05, $val06, $val07, $val08, $val09, $val10, $val11, $val12, $val13, $val14, $val15, $aud01, $aud03]);

                $stmtMSSQL01= $connMSSQL->prepare($sql01);
                $stmtMSSQL01->execute();
                $row_mssql01= $stmtMSSQL01->fetch(PDO::FETCH_ASSOC);
                $codigo     = $row_mssql01['rendicion_cabecera_codigo'];

                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success INSERT', 'codigo' => $codigo), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

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

    $app->post('/v1/500/detalle', function($request) {
        require __DIR__.'/../src/connect.php';

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

        if (isset($val01) && isset($val02) && isset($val03) && isset($val04) && isset($val05) && isset($val06)) {        
            $sql00  = "INSERT INTO [con].[RENFDE] (RENFDEEAC, RENFDEECC, RENFDETCC, RENFDETAC, RENFDEWFC, RENFDEFCC, RENFDEDES, RENFDEIMP, RENFDECSS, RENFDEOBS, RENFDEAUS, RENFDEAFH, RENFDEAIP) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, GETDATE(), ?)";
            $sql01  = "SELECT MAX(RENFDECOD) AS rendicion_detalle_codigo FROM [con].[RENFDE]";
            
            try {
                $connMSSQL  = getConnectionMSSQLv1();

                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val01, $val02, $val03, $val04, $val05, $val06, $val07, $val08, $val09, $val10, $aud01, $aud03]);

                $stmtMSSQL01= $connMSSQL->prepare($sql01);
                $stmtMSSQL01->execute();
                $row_mssql01= $stmtMSSQL01->fetch(PDO::FETCH_ASSOC);
                $codigo     = $row_mssql01['rendicion_detalle_codigo'];

                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success INSERT', 'codigo' => $codigo), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

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

    $app->post('/v1/500/comentario', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getParsedBody()['estado_anterior_codigo'];
        $val02      = $request->getParsedBody()['estado_actual_codigo'];
        $val03      = $request->getParsedBody()['workflow_codigo'];
        $val04      = $request->getParsedBody()['rendicion_detalle_codigo'];
        $val05      = trim(strtoupper(strtolower($request->getParsedBody()['rendicion_comentario_observacion'])));

        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        if (isset($val01) && isset($val02) && isset($val03) && isset($val04)) {        
            $sql00  = "INSERT INTO [con].[RENFCO] (RENFCOEAC, RENFCOECC, RENFCOWFC, RENFCOFDC, RENFCOOBS, RENFCOAUS, RENFCOAFH, RENFCOAIP) VALUES (?, ?, ?, ?, ?, ?, GETDATE(), ?)";
            $sql01  = "SELECT MAX(RENFCOCOD) AS rendicion_detalle_codigo FROM [con].[RENFCO]";
            
            try {
                $connMSSQL  = getConnectionMSSQLv1();

                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val01, $val02, $val03, $val04, $val05, $aud01, $aud03]);

                $stmtMSSQL01= $connMSSQL->prepare($sql01);
                $stmtMSSQL01->execute();
                $row_mssql01= $stmtMSSQL01->fetch(PDO::FETCH_ASSOC);
                $codigo     = $row_mssql01['rendicion_detalle_codigo'];

                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success INSERT', 'codigo' => $codigo), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

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

    /*MODULO PERMISOS*/
    $app->post('/v1/200/tarjetapersonal', function($request) {
        require __DIR__.'/../src/connect.php';

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
            $sql00  = "INSERT INTO [hum].[TPEFIC] (TPEFICEST, TPEFICORD, TPEFICGEC, TPEFICDEC, TPEFICJEC, TPEFICCAC, TPEFICCNC, TPEFICDNU, TPEFICEMA, TPEFICNOV, TPEFICAPV, TPEFICOBS, TPEFICAUS, TPEFICAFH, TPEFICAIP) VALUES ((SELECT DOMFICCOD FROM adm.DOMFIC WHERE DOMFICVAL = 'TARJETAPERSONALESTADO' AND DOMFICPAR = ?), ?, ?,?, ?, ?, (SELECT DOMFICCOD FROM adm.DOMFIC WHERE DOMFICVAL = 'TARJETAPERSONALCANTIDAD' AND DOMFICPAR = ?), ?, ?, ?, ?, ?, ?,GETDATE(), ?)";                                                                                                                                                                                            
            $sql01  = "SELECT MAX(TPEFICCOD) AS tarjeta_personal_codigo FROM [hum].[TPEFIC]";
            
            try {
                $connMSSQL  = getConnectionMSSQLv1();

                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val01, $val03, $val04, $val05, $val06, $val07, $val02, $val08, $val09, $val10, $val11, $val12, $aud01, $aud03]);

                $stmtMSSQL01= $connMSSQL->prepare($sql01);
                $stmtMSSQL01->execute();
                $row_mssql01= $stmtMSSQL01->fetch(PDO::FETCH_ASSOC);
                $codigo     = $row_mssql01['tarjeta_personal_codigo'];

                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success INSERT', 'codigo' => $codigo), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

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

    $app->post('/v1/200/tarjetapersonal/redsocial', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getParsedBody()['tipo_estado_parametro'];
        $val02      = $request->getParsedBody()['tarjeta_personal_red_social_orden'];
        $val03      = $request->getParsedBody()['tipo_red_social_parametro'];
        $val04      = $request->getParsedBody()['tarjeta_personal_codigo'];
        $val05      = trim(strtolower($request->getParsedBody()['tarjeta_personal_red_social_direccion']));
        $val06      = trim(strtoupper($request->getParsedBody()['tarjeta_personal_red_social_visualizar']));
        $val07      = trim($request->getParsedBody()['tarjeta_personal_red_social_observacion']);

        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        if (isset($val01) && isset($val03) &&  isset($val04)) {        
            $sql00  = "INSERT INTO [hum].[TPERSO] (TPERSOEST, TPERSOORD, TPERSOTRC, TPERSOTAC, TPERSODIR, TPERSOVIS, TPERSOOBS, TPERSOAUS, TPERSOAFH, TPERSOAIP) VALUES ((SELECT DOMFICCOD FROM adm.DOMFIC WHERE DOMFICVAL = 'REDSOCIALESTADO' AND DOMFICPAR = ?), ?, (SELECT DOMFICCOD FROM adm.DOMFIC WHERE DOMFICVAL = 'REDSOCIALTIPO' AND DOMFICPAR = ?), ?, ?, ?, ?, ?, GETDATE(), ?)";
            $sql01  = "SELECT MAX(TPERSOCOD) AS tarjeta_personal_red_social_codigo FROM [hum].[TPERSO]";
            
            try {
                $connMSSQL  = getConnectionMSSQLv1();

                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val01, $val02, $val03, $val04, $val05, $val06, $val07, $aud01, $aud03]);

                $stmtMSSQL01= $connMSSQL->prepare($sql01);
                $stmtMSSQL01->execute();
                $row_mssql01= $stmtMSSQL01->fetch(PDO::FETCH_ASSOC);
                $codigo     = $row_mssql01['tarjeta_personal_red_social_codigo'];

                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success INSERT', 'codigo' => $codigo), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

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

    $app->post('/v1/200/tarjetapersonal/telefonoprefijo', function($request) {
        require __DIR__.'/../src/connect.php';

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
            $sql00  = "INSERT INTO [hum].[TPETEL] (TPETELEST, TPETELORD, TPETELTPC, TPETELTAC, TPETELVIS, TPETELNUM, TPETELOBS, TPETELAUS, TPETELAFH, TPETELAIP) VALUES ((SELECT DOMFICCOD FROM adm.DOMFIC WHERE DOMFICVAL = 'TELEFONOESTADO' AND DOMFICPAR = ?), ?, (SELECT DOMFICCOD FROM adm.DOMFIC WHERE DOMFICVAL = 'TELEFONOPAIS' AND DOMFICPAR = ?), ?, ?, ?, ?, ?, GETDATE(), ?)";
            $sql01  = "SELECT MAX(TPETELCOD) AS tarjeta_personal_telefono_codigo FROM [hum].[TPETEL]";
            
            try {
                $connMSSQL  = getConnectionMSSQLv1();

                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val01, $val02, $val03, $val04, $val05, $val06, $val07, $aud01, $aud03]);

                $stmtMSSQL01= $connMSSQL->prepare($sql01);
                $stmtMSSQL01->execute();
                $row_mssql01= $stmtMSSQL01->fetch(PDO::FETCH_ASSOC);
                $codigo     = $row_mssql01['tarjeta_personal_telefono_codigo'];

                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success INSERT', 'codigo' => $codigo), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

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

    $app->post('/v1/200/testpcr', function($request) {
        require __DIR__.'/../src/connect.php';

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

        $aud01      = trim($request->getParsedBody()['auditoria_usuario']);
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      =  trim($request->getParsedBody()['auditoria_ip']);

        if (isset($val01) && isset($val02) && isset($val05) && isset($val06) && isset($val07)) {
            $sql00  = "INSERT INTO [hum].[SOLPCR](                                                                          SOLPCREST, SOLPCRORD,                                                                                  SOLPCRTSC,                                                                          SOLPCRTRC, SOLPCRNOM, SOLPCRAPE, SOLPCRDOC, SOLPCRDOJ, SOLPCREMA, SOLPCRFE1, SOLPCRFE2, SOLPCRHO1, SOLPCRHO2, SOLPCRAD1, SOLPCRAD2, SOLPCRAD3, SOLPCRAD4, SOLPCRUSC, SOLPCRFEC, SOLPCRIPC, SOLPCROBC, SOLPCRAUS, SOLPCRAFH, SOLPCRAIP) 
                                        SELECT (SELECT DOMFICCOD FROM adm.DOMFIC WHERE DOMFICVAL = 'TESTPCRESTADO' AND DOMFICPAR = ?),          ?, (SELECT DOMFICCOD FROM adm.DOMFIC WHERE DOMFICVAL = 'TESTPCRSOLICITUD' AND DOMFICPAR = ?), (SELECT DOMFICCOD FROM adm.DOMFIC WHERE DOMFICVAL = 'TESTPCRROL' AND DOMFICPAR = ?),        ?,         ?,         ?,          ?,        ?,          ?,        ?,          ?,         ?,        ?,         ?,          ?,        ?,         ?, GETDATE(),         ?,         ?,         ?, GETDATE(),       ?
                                        WHERE NOT EXISTS(SELECT * FROM [hum].[SOLPCR] WHERE SOLPCREST = (SELECT DOMFICCOD FROM adm.DOMFIC WHERE DOMFICVAL = 'TESTPCRESTADO' AND DOMFICPAR = ?) AND SOLPCRTSC = (SELECT DOMFICCOD FROM adm.DOMFIC WHERE DOMFICVAL = 'TESTPCRSOLICITUD' AND DOMFICPAR = ?) AND SOLPCRDOC = ? AND SOLPCRFE1 = ?)";
            $sql01  = "SELECT MAX(SOLPCRCOD) AS testpcr_codigo FROM [hum].[SOLPCR]";
            
            try {
                $connMSSQL  = getConnectionMSSQLv1();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL01= $connMSSQL->prepare($sql01);

                $stmtMSSQL00->execute([$val01, $val04, $val02, $val03, $val05, $val06, $val07, $val10, $val08, $val11, $val12, $val13, $val14, $val15, $val16, $val17, $val18, $val26, $val28, $val09, $aud01, $aud03, $val01, $val02, $val07, $val11]);
                
                $stmtMSSQL01->execute();
                $row_mssql01= $stmtMSSQL01->fetch(PDO::FETCH_ASSOC);
                $SOLFICCOD  = $row_mssql01['testpcr_codigo'];

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

/*MODULO PERMISOS*/