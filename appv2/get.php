<?php
    $app->get('/v2/100/dominio', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $sql00  = "SELECT
            a.DOMFICCOD         AS          tipo_codigo,
            a.DOMFICORD         AS          tipo_orden,
            a.DOMFICNOI         AS          tipo_nombre_ingles,
            a.DOMFICNOC         AS          tipo_nombre_castellano,
            a.DOMFICNOP         AS          tipo_nombre_portugues,
            a.DOMFICPAT         AS          tipo_path,
            a.DOMFICCSS         AS          tipo_css,
            a.DOMFICPAR         AS          tipo_parametro,
            a.DOMFICICO         AS          tipo_icono,
            a.DOMFICVAL         AS          tipo_dominio,
            a.DOMFICOBS         AS          tipo_observacion,

            a.DOMFICUSU         AS          auditoria_usuario,
            a.DOMFICFEC         AS          auditoria_fecha_hora,
            a.DOMFICDIP         AS          auditoria_ip,

            b.DOMFICCOD         AS          tipo_estado_codigo,
            b.DOMFICNOI         AS          tipo_estado_ingles,
            b.DOMFICNOC         AS          tipo_estado_castellano,
            b.DOMFICNOP         AS          tipo_estado_portugues,
            b.DOMFICPAR         AS          tipo_estado_parametro,
            b.DOMFICICO         AS          tipo_estado_icono,
            b.DOMFICCSS         AS          tipo_estado_css
        
            FROM [adm].[DOMFIC] a
            INNER JOIN [adm].[DOMFIC] b ON a.DOMFICEST = b.DOMFICCOD

            ORDER BY a.DOMFICVAL, a.DOMFICORD";

        try {
            $connMSSQL  = getConnectionMSSQLv2();
            $stmtMSSQL00= $connMSSQL->prepare($sql00);
            $stmtMSSQL00->execute();
            
            while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                $detalle    = array(
                    'tipo_codigo'                               => $rowMSSQL00['tipo_codigo'],
                    'tipo_orden'                                => $rowMSSQL00['tipo_orden'],
                    'tipo_nombre_ingles'                        => trim(strtoupper(strtolower($rowMSSQL00['tipo_nombre_ingles']))),
                    'tipo_nombre_castellano'                    => trim(strtoupper(strtolower($rowMSSQL00['tipo_nombre_castellano']))),
                    'tipo_nombre_portugues'                     => trim(strtoupper(strtolower($rowMSSQL00['tipo_nombre_portugues']))),
                    'tipo_path'                                 => trim(strtolower($rowMSSQL00['tipo_path'])),
                    'tipo_css'                                  => trim(strtolower($rowMSSQL00['tipo_css'])),
                    'tipo_parametro'                            => $rowMSSQL00['tipo_parametro'],
                    'tipo_icono'                                => trim(strtolower($rowMSSQL00['tipo_icono'])),
                    'tipo_dominio'                              => trim(strtoupper(strtolower($rowMSSQL00['tipo_dominio']))),
                    'tipo_observacion'                          => trim(strtoupper(strtolower($rowMSSQL00['tipo_observacion']))),

                    'auditoria_usuario'                         => trim(strtoupper(strtolower($rowMSSQL00['auditoria_usuario']))),
                    'auditoria_fecha_hora'                      => $rowMSSQL00['auditoria_fecha_hora'],
                    'auditoria_ip'                              => trim(strtoupper(strtolower($rowMSSQL00['auditoria_ip']))),

                    'tipo_estado_codigo'                        => $rowMSSQL00['tipo_estado_codigo'],
                    'tipo_estado_ingles'                        => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_ingles']))),
                    'tipo_estado_castellano'                    => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_castellano']))),
                    'tipo_estado_portugues'                     => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_portugues']))),
                    'tipo_estado_parametro'                     => $rowMSSQL00['tipo_estado_parametro'],
                    'tipo_estado_icono'                         => trim(strtolower($rowMSSQL00['tipo_estado_icono'])),
                    'tipo_estado_css'                           => trim(strtolower($rowMSSQL00['tipo_estado_css']))
                );

                $result[]   = $detalle;
            }

            if (isset($result)){
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } else {
                $detalle = array(
                    'tipo_codigo'                               => '',
                    'tipo_orden'                                => '',
                    'tipo_nombre_ingles'                        => '',
                    'tipo_nombre_castellano'                    => '',
                    'tipo_nombre_portugues'                     => '',
                    'tipo_path'                                 => '',
                    'tipo_css'                                  => '',
                    'tipo_parametro'                            => '',
                    'tipo_icono'                                => '',
                    'tipo_dominio'                              => '',
                    'tipo_observacion'                          => '',

                    'auditoria_usuario'                         => '',
                    'auditoria_fecha_hora'                      => '',
                    'auditoria_ip'                              => '',

                    'tipo_estado_codigo'                        => '',
                    'tipo_estado_ingles'                        => '',
                    'tipo_estado_castellano'                    => '',
                    'tipo_estado_portugues'                     => '',
                    'tipo_estado_parametro'                     => '',
                    'tipo_estado_icono'                         => '',
                    'tipo_estado_css'                           => ''
                );

                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }

            $stmtMSSQL00->closeCursor();
            $stmtMSSQL00 = null;
        } catch (PDOException $e) {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v2/100/dominio/valor/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val01      = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
                a.DOMFICCOD         AS          tipo_codigo,
                a.DOMFICORD         AS          tipo_orden,
                a.DOMFICNOI         AS          tipo_nombre_ingles,
                a.DOMFICNOC         AS          tipo_nombre_castellano,
                a.DOMFICNOP         AS          tipo_nombre_portugues,
                a.DOMFICPAT         AS          tipo_path,
                a.DOMFICCSS         AS          tipo_css,
                a.DOMFICPAR         AS          tipo_parametro,
                a.DOMFICICO         AS          tipo_icono,
                a.DOMFICVAL         AS          tipo_dominio,
                a.DOMFICOBS         AS          tipo_observacion,
                a.DOMFICUSU         AS          auditoria_usuario,
                a.DOMFICFEC         AS          auditoria_fecha_hora,
                a.DOMFICDIP         AS          auditoria_ip,

                b.DOMFICCOD         AS          tipo_estado_codigo,
                b.DOMFICNOI         AS          tipo_estado_ingles,
                b.DOMFICNOC         AS          tipo_estado_castellano,
                b.DOMFICNOP         AS          tipo_estado_portugues,
                b.DOMFICPAR         AS          tipo_estado_parametro,
                b.DOMFICICO         AS          tipo_estado_icono,
                b.DOMFICCSS         AS          tipo_estado_css
                
                FROM [adm].[DOMFIC] a
                INNER JOIN [adm].[DOMFIC] b ON a.DOMFICEST = b.DOMFICCOD

                WHERE a.DOMFICVAL = ?

                ORDER BY a.DOMFICVAL, a.DOMFICORD";

            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val01]);
                
                while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                    $detalle    = array(
                        'tipo_codigo'                               => $rowMSSQL00['tipo_codigo'],
                        'tipo_orden'                                => $rowMSSQL00['tipo_orden'],
                        'tipo_nombre_ingles'                        => trim(strtoupper(strtolower($rowMSSQL00['tipo_nombre_ingles']))),
                        'tipo_nombre_castellano'                    => trim(strtoupper(strtolower($rowMSSQL00['tipo_nombre_castellano']))),
                        'tipo_nombre_portugues'                     => trim(strtoupper(strtolower($rowMSSQL00['tipo_nombre_portugues']))),
                        'tipo_path'                                 => trim(strtolower($rowMSSQL00['tipo_path'])),
                        'tipo_css'                                  => trim(strtolower($rowMSSQL00['tipo_css'])),
                        'tipo_parametro'                            => $rowMSSQL00['tipo_parametro'],
                        'tipo_icono'                                => trim(strtolower($rowMSSQL00['tipo_icono'])),
                        'tipo_dominio'                              => trim(strtoupper(strtolower($rowMSSQL00['tipo_dominio']))),
                        'tipo_observacion'                          => trim(strtoupper(strtolower($rowMSSQL00['tipo_observacion']))),
    
                        'auditoria_usuario'                         => trim(strtoupper(strtolower($rowMSSQL00['auditoria_usuario']))),
                        'auditoria_fecha_hora'                      => $rowMSSQL00['auditoria_fecha_hora'],
                        'auditoria_ip'                              => trim(strtoupper(strtolower($rowMSSQL00['auditoria_ip']))),
    
                        'tipo_estado_codigo'                        => $rowMSSQL00['tipo_estado_codigo'],
                        'tipo_estado_ingles'                        => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_ingles']))),
                        'tipo_estado_castellano'                    => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_castellano']))),
                        'tipo_estado_portugues'                     => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_portugues']))),
                        'tipo_estado_parametro'                     => $rowMSSQL00['tipo_estado_parametro'],
                        'tipo_estado_icono'                         => trim(strtolower($rowMSSQL00['tipo_estado_icono'])),
                        'tipo_estado_css'                           => trim(strtolower($rowMSSQL00['tipo_estado_css']))
                    );
    
                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'tipo_codigo'                               => '',
                        'tipo_orden'                                => '',
                        'tipo_nombre_ingles'                        => '',
                        'tipo_nombre_castellano'                    => '',
                        'tipo_nombre_portugues'                     => '',
                        'tipo_path'                                 => '',
                        'tipo_css'                                  => '',
                        'tipo_parametro'                            => '',
                        'tipo_icono'                                => '',
                        'tipo_dominio'                              => '',
                        'tipo_observacion'                          => '',
    
                        'auditoria_usuario'                         => '',
                        'auditoria_fecha_hora'                      => '',
                        'auditoria_ip'                              => '',
    
                        'tipo_estado_codigo'                        => '',
                        'tipo_estado_ingles'                        => '',
                        'tipo_estado_castellano'                    => '',
                        'tipo_estado_portugues'                     => '',
                        'tipo_estado_parametro'                     => '',
                        'tipo_estado_icono'                         => '',
                        'tipo_estado_css'                           => ''
                    );

                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                }

                $stmtMSSQL00->closeCursor();
                $stmtMSSQL00 = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v2/100/auditoria/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
                a.DOMFICCOD         AS          tipo_codigo,
                a.DOMFICORD         AS          tipo_orden,
                a.DOMFICNOI         AS          tipo_nombre_ingles,
                a.DOMFICNOC         AS          tipo_nombre_castellano,
                a.DOMFICNOP         AS          tipo_nombre_portugues,
                a.DOMFICPAT         AS          tipo_path,
                a.DOMFICCSS         AS          tipo_css,
                a.DOMFICPAR         AS          tipo_parametro,
                a.DOMFICVAL         AS          tipo_dominio,
                a.DOMFICOBS         AS          tipo_observacion,

                a.DOMFICIDD         AS          auditoria_codigo,
                a.DOMFICMET         AS          auditoria_metodo,
                a.DOMFICUSU         AS          auditoria_usuario,
                a.DOMFICFEC         AS          auditoria_fecha_hora,
                a.DOMFICDIP         AS          auditoria_ip,

                b.DOMFICCOD         AS          tipo_estado_codigo,
                b.DOMFICNOI         AS          tipo_estado_ingles,
                b.DOMFICNOC         AS          tipo_estado_castellano,
                b.DOMFICNOP         AS          tipo_estado_portugues,
                b.DOMFICPAR         AS          tipo_estado_parametro
                
                FROM [aud].[DOMFIC] a
                INNER JOIN [adm].[DOMFIC] b ON a.DOMFICEST = b.DOMFICCOD
                
                WHERE a.DOMFICVAL = ?
                
                ORDER BY a.DOMFICIDD DESC";

            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val01]);
                
                while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                    $detalle    = array(
                        'tipo_codigo'                               => $rowMSSQL00['tipo_codigo'],
                        'tipo_orden'                                => $rowMSSQL00['tipo_orden'],
                        'tipo_nombre_ingles'                        => trim(strtoupper(strtolower($rowMSSQL00['tipo_nombre_ingles']))),
                        'tipo_nombre_castellano'                    => trim(strtoupper(strtolower($rowMSSQL00['tipo_nombre_castellano']))),
                        'tipo_nombre_portugues'                     => trim(strtoupper(strtolower($rowMSSQL00['tipo_nombre_portugues']))),
                        'tipo_path'                                 => trim(strtolower($rowMSSQL00['tipo_path'])),
                        'tipo_css'                                  => trim(strtolower($rowMSSQL00['tipo_css'])),
                        'tipo_parametro'                            => $rowMSSQL00['tipo_parametro'],
                        'tipo_dominio'                              => trim(strtoupper(strtolower($rowMSSQL00['tipo_dominio']))),
                        'tipo_observacion'                          => trim(strtoupper(strtolower($rowMSSQL00['tipo_observacion']))),

                        'auditoria_codigo'                          => trim(strtoupper(strtolower($rowMSSQL00['auditoria_codigo']))),
                        'auditoria_metodo'                          => trim(strtoupper(strtolower($rowMSSQL00['auditoria_metodo']))),
                        'auditoria_usuario'                         => trim(strtoupper(strtolower($rowMSSQL00['auditoria_usuario']))),
                        'auditoria_fecha_hora'                      => $rowMSSQL00['auditoria_fecha_hora'],
                        'auditoria_ip'                              => trim(strtoupper(strtolower($rowMSSQL00['auditoria_ip']))),

                        'tipo_estado_codigo'                        => $rowMSSQL00['tipo_estado_codigo'],
                        'tipo_estado_ingles'                        => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_ingles']))),
                        'tipo_estado_castellano'                    => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_castellano']))),
                        'tipo_estado_portugues'                     => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_portugues']))),
                        'tipo_estado_parametro'                     => $rowMSSQL00['tipo_estado_parametro']
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'tipo_codigo'                               => '',
                        'tipo_orden'                                => '',
                        'tipo_nombre_ingles'                        => '',
                        'tipo_nombre_castellano'                    => '',
                        'tipo_nombre_portugues'                     => '',
                        'tipo_path'                                 => '',
                        'tipo_css'                                  => '',
                        'tipo_parametro'                            => '',
                        'tipo_dominio'                              => '',
                        'tipo_observacion'                          => '',

                        'auditoria_codigo'                          => '',
                        'auditoria_metodo'                          => '',
                        'auditoria_usuario'                         => '',
                        'auditoria_fecha_hora'                      => '',
                        'auditoria_ip'                              => '',

                        'tipo_estado_codigo'                        => '',
                        'tipo_estado_ingles'                        => '',
                        'tipo_estado_castellano'                    => '',
                        'tipo_estado_portugues'                     => '',
                        'tipo_estado_parametro'                     => ''
                    );

                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                }

                $stmtMSSQL00->closeCursor();
                $stmtMSSQL00 = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v2/100/dominiosub', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $sql00  = "SELECT
            a.DOMSUBORD         AS          tipo_orden,
            a.DOMSUBPAT         AS          tipo_path,
            a.DOMSUBCSS         AS          tipo_css,
            a.DOMSUBPAR         AS          tipo_parametro,
            a.DOMSUBVAL         AS          tipo_dominio,
            a.DOMSUBOBS         AS          tipo_observacion,

            a.DOMSUBAUS         AS          auditoria_usuario,
            a.DOMSUBAFE         AS          auditoria_fecha_hora,
            a.DOMSUBAIP         AS          auditoria_ip,

            b.DOMFICCOD         AS          tipo_estado_codigo,
            b.DOMFICNOI         AS          tipo_estado_ingles,
            b.DOMFICNOC         AS          tipo_estado_castellano,
            b.DOMFICNOP         AS          tipo_estado_portugues,
            b.DOMFICPAR         AS          tipo_estado_parametro,
            b.DOMFICICO         AS          tipo_estado_icono,
            b.DOMFICCSS         AS          tipo_estado_css

            c.DOMFICCOD         AS          tipo_dominio1_codigo,
            c.DOMFICORD         AS          tipo_dominio1_orden,
            c.DOMFICNOI         AS          tipo_dominio1_nombre_ingles,
            c.DOMFICNOC         AS          tipo_dominio1_nombre_castellano,
            c.DOMFICNOP         AS          tipo_dominio1_nombre_portugues,
            c.DOMFICPAT         AS          tipo_dominio1_path,
            c.DOMFICCSS         AS          tipo_dominio1_css,
            c.DOMFICPAR         AS          tipo_dominio1_parametro,
            c.DOMFICICO         AS          tipo_dominio1_icono,
            c.DOMFICVAL         AS          tipo_dominio1_dominio,
            c.DOMFICOBS         AS          tipo_dominio1_observacion,

            d.DOMFICCOD         AS          tipo_dominio2_codigo,
            d.DOMFICORD         AS          tipo_dominio2_orden,
            d.DOMFICNOI         AS          tipo_dominio2_nombre_ingles,
            d.DOMFICNOC         AS          tipo_dominio2_nombre_castellano,
            d.DOMFICNOP         AS          tipo_dominio2_nombre_portugues,
            d.DOMFICPAT         AS          tipo_dominio2_path,
            d.DOMFICCSS         AS          tipo_dominio2_css,
            d.DOMFICPAR         AS          tipo_dominio2_parametro,
            d.DOMFICICO         AS          tipo_dominio2_icono,
            d.DOMFICVAL         AS          tipo_dominio2_dominio,
            d.DOMFICOBS         AS          tipo_dominio2_observacion
            
            FROM [adm].[DOMSUB] a
            INNER JOIN [adm].[DOMFIC] b ON a.DOMSUBEST = b.DOMFICCOD
            INNER JOIN [adm].[DOMFIC] c ON a.DOMSUBCO1 = c.DOMFICCOD
            INNER JOIN [adm].[DOMFIC] d ON a.DOMSUBCO2 = d.DOMFICCOD

            ORDER BY a.DOMSUBVAL, a.DOMSUBORD";

        try {
            $connMSSQL  = getConnectionMSSQLv2();
            $stmtMSSQL00= $connMSSQL->prepare($sql00);
            $stmtMSSQL00->execute();
            
            while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                $detalle    = array(
                    'tipo_orden'                                => $rowMSSQL00['tipo_orden'],
                    'tipo_path'                                 => trim(strtolower($rowMSSQL00['tipo_path'])),
                    'tipo_css'                                  => trim(strtolower($rowMSSQL00['tipo_css'])),
                    'tipo_parametro'                            => $rowMSSQL00['tipo_parametro'],
                    'tipo_dominio'                              => trim(strtoupper(strtolower($rowMSSQL00['tipo_dominio']))),
                    'tipo_observacion'                          => trim(strtoupper(strtolower($rowMSSQL00['tipo_observacion']))),

                    'auditoria_usuario'                         => trim(strtoupper(strtolower($rowMSSQL00['auditoria_usuario']))),
                    'auditoria_fecha_hora'                      => $rowMSSQL00['auditoria_fecha_hora'],
                    'auditoria_ip'                              => trim(strtoupper(strtolower($rowMSSQL00['auditoria_ip']))),

                    'tipo_estado_codigo'                        => $rowMSSQL00['tipo_estado_codigo'],
                    'tipo_estado_ingles'                        => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_ingles']))),
                    'tipo_estado_castellano'                    => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_castellano']))),
                    'tipo_estado_portugues'                     => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_portugues']))),
                    'tipo_estado_parametro'                     => $rowMSSQL00['tipo_estado_parametro'],
                    'tipo_estado_icono'                         => trim(strtolower($rowMSSQL00['tipo_estado_icono'])),
                    'tipo_estado_css'                           => trim(strtolower($rowMSSQL00['tipo_estado_css'])),

                    'tipo_dominio1_codigo'                      => $rowMSSQL00['tipo_dominio1_codigo'],
                    'tipo_dominio1_orden'                       => $rowMSSQL00['tipo_dominio1_orden'],
                    'tipo_dominio1_nombre_ingles'               => trim(strtoupper(strtolower($rowMSSQL00['tipo_dominio1_nombre_ingles']))),
                    'tipo_dominio1_nombre_castellano'           => trim(strtoupper(strtolower($rowMSSQL00['tipo_dominio1_nombre_castellano']))),
                    'tipo_dominio1_nombre_portugues'            => trim(strtoupper(strtolower($rowMSSQL00['tipo_dominio1_nombre_portugues']))),
                    'tipo_dominio1_path'                        => trim(strtolower($rowMSSQL00['tipo_dominio1_path'])),
                    'tipo_dominio1_css'                         => trim(strtolower($rowMSSQL00['tipo_dominio1_css'])),
                    'tipo_dominio1_parametro'                   => $rowMSSQL00['tipo_dominio1_parametro'],
                    'tipo_dominio1_icono'                       => trim(strtolower($rowMSSQL00['tipo_dominio1_icono'])),
                    'tipo_dominio1_dominio'                     => trim(strtoupper(strtolower($rowMSSQL00['tipo_dominio1_dominio']))),
                    'tipo_dominio1_observacion'                 => trim(strtoupper(strtolower($rowMSSQL00['tipo_dominio1_observacion']))),

                    'tipo_dominio2_codigo'                      => $rowMSSQL00['tipo_dominio2_codigo'],
                    'tipo_dominio2_orden'                       => $rowMSSQL00['tipo_dominio2_orden'],
                    'tipo_dominio2_nombre_ingles'               => trim(strtoupper(strtolower($rowMSSQL00['tipo_dominio2_nombre_ingles']))),
                    'tipo_dominio2_nombre_castellano'           => trim(strtoupper(strtolower($rowMSSQL00['tipo_dominio2_nombre_castellano']))),
                    'tipo_dominio2_nombre_portugues'            => trim(strtoupper(strtolower($rowMSSQL00['tipo_dominio2_nombre_portugues']))),
                    'tipo_dominio2_path'                        => trim(strtolower($rowMSSQL00['tipo_dominio2_path'])),
                    'tipo_dominio2_css'                         => trim(strtolower($rowMSSQL00['tipo_dominio2_css'])),
                    'tipo_dominio2_parametro'                   => $rowMSSQL00['tipo_dominio2_parametro'],
                    'tipo_dominio2_icono'                       => trim(strtolower($rowMSSQL00['tipo_dominio2_icono'])),
                    'tipo_dominio2_dominio'                     => trim(strtoupper(strtolower($rowMSSQL00['tipo_dominio2_dominio']))),
                    'tipo_dominio2_observacion'                 => trim(strtoupper(strtolower($rowMSSQL00['tipo_dominio2_observacion'])))
                );

                $result[]   = $detalle;
            }

            if (isset($result)){
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } else {
                $detalle = array(
                    'tipo_orden'                                => '',
                    'tipo_path'                                 => '',
                    'tipo_css'                                  => '',
                    'tipo_parametro'                            => '',
                    'tipo_dominio'                              => '',
                    'tipo_observacion'                          => '',
                    'auditoria_usuario'                         => '',

                    'auditoria_fecha_hora'                      => '',
                    'auditoria_ip'                              => '',

                    'tipo_estado_codigo'                        => '',
                    'tipo_estado_ingles'                        => '',
                    'tipo_estado_castellano'                    => '',
                    'tipo_estado_portugues'                     => '',
                    'tipo_estado_parametro'                     => '',
                    'tipo_estado_icono'                         => '',
                    'tipo_estado_css'                           => '',

                    'tipo_dominio1_codigo'                      => '',
                    'tipo_dominio1_orden'                       => '',
                    'tipo_dominio1_nombre_ingles'               => '',
                    'tipo_dominio1_nombre_castellano'           => '',
                    'tipo_dominio1_nombre_portugues'            => '',
                    'tipo_dominio1_path'                        => '',
                    'tipo_dominio1_css'                         => '',
                    'tipo_dominio1_parametro'                   => '',
                    'tipo_dominio1_icono'                       => '',
                    'tipo_dominio1_dominio'                     => '',
                    'tipo_dominio1_observacion'                 => '',

                    'tipo_dominio2_codigo'                      => '',
                    'tipo_dominio2_orden'                       => '',
                    'tipo_dominio2_nombre_ingles'               => '',
                    'tipo_dominio2_nombre_castellano'           => '',
                    'tipo_dominio2_nombre_portugues'            => '',
                    'tipo_dominio2_path'                        => '',
                    'tipo_dominio2_css'                         => '',
                    'tipo_dominio2_parametro'                   => '',
                    'tipo_dominio2_icono'                       => '',
                    'tipo_dominio2_dominio'                     => '',
                    'tipo_dominio2_observacion'                 => ''
                );

                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }

            $stmtMSSQL00->closeCursor();
            $stmtMSSQL00 = null;
        } catch (PDOException $e) {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v2/100/solicitud', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $sql00  = "SELECT
        a.DOMSOLCOD         AS          tipo_permiso_codigo,
        a.DOMSOLEST         AS          tipo_estado_codigo,
        a.DOMSOLTST         AS          tipo_solicitud_codigo,
        a.DOMSOLPC1         AS          tipo_permiso_codigo1,
        a.DOMSOLPC2         AS          tipo_permiso_codigo2,
        a.DOMSOLPC3         AS          tipo_permiso_codigo3,
        a.DOMSOLORD         AS          tipo_orden_numero,
        a.DOMSOLDIC         AS          tipo_dia_cantidad,
        a.DOMSOLDIO         AS          tipo_dia_corrido,
        a.DOMSOLDIU         AS          tipo_dia_unidad,
        a.DOMSOLADJ         AS          tipo_archivo_adjunto,
        a.DOMSOLOBS         AS          tipo_observacion,
        a.DOMSOLUSU         AS          auditoria_usuario,
        a.DOMSOLFEC         AS          auditoria_fecha_hora,
        a.DOMSOLDIP         AS          auditoria_ip
        
        FROM [adm].[DOMSOL] a

        ORDER BY a.DOMSOLTST, a.DOMSOLORD";

        try {
            $connMSSQL  = getConnectionMSSQLv2();

            $stmtMSSQL00= $connMSSQL->prepare($sql00);
            $stmtMSSQL00->execute();
            
            while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                $sql01  = '';

                switch ($rowMSSQL00['tipo_estado_codigo']) {
                    case 'A':
                        $tipo_estado_nombre = 'ACTIVO';
                        break;
                    
                    case 'I':
                        $tipo_estado_nombre = 'INACTIVO';
                        break;
                }

                switch ($rowMSSQL00['tipo_solicitud_codigo']) {
                    case 'L':
                        $tipo_solicitud_nombre  = 'LICENCIA';
                        $sql01                  = "SELECT U_NOMBRE AS tipo_permiso_nombre FROM [CSF].[dbo].[@A1A_TILC] WHERE U_CODIGO = ?";
                        break;
                    
                    case 'P':
                        $tipo_solicitud_nombre  = 'PERMISO';
                        $sql01                  = "SELECT U_NOMBRE AS tipo_permiso_nombre FROM [CSF].[dbo].[@A1A_TIPE] WHERE U_CODIGO = ?";
                        break;
    
                    case 'I':
                        $tipo_solicitud_nombre  = 'INASISTENCIA';
                        $sql01                  = "SELECT U_DESAMP AS tipo_permiso_nombre FROM [CSF].[dbo].[@A1A_TIIN] WHERE U_CODIGO = ?";
                        break;
                }

                $stmtMSSQL01= $connMSSQL->prepare($sql01);
                $stmtMSSQL01->execute([trim(strtoupper($rowMSSQL00['tipo_permiso_codigo3']))]);
                $rowMSSQL01 = $stmtMSSQL01->fetch(PDO::FETCH_ASSOC);

                $tipo_permiso_nombre = $rowMSSQL01['tipo_permiso_nombre'];

                $detalle    = array(
                    'tipo_permiso_codigo'                       => $rowMSSQL00['tipo_permiso_codigo'],
                    'tipo_estado_codigo'                        => $rowMSSQL00['tipo_estado_codigo'],
                    'tipo_estado_nombre'                        => trim(strtoupper($tipo_estado_nombre)),
                    'tipo_solicitud_codigo'                     => $rowMSSQL00['tipo_solicitud_codigo'],
                    'tipo_solicitud_nombre'                     => trim(strtoupper($tipo_solicitud_nombre)),
                    'tipo_permiso_codigo1'                      => $rowMSSQL00['tipo_permiso_codigo1'],
                    'tipo_permiso_codigo2'                      => $rowMSSQL00['tipo_permiso_codigo2'],
                    'tipo_permiso_codigo3'                      => trim(strtoupper($rowMSSQL00['tipo_permiso_codigo3'])),
                    'tipo_permiso_nombre'                       => trim(strtoupper($tipo_permiso_nombre)),
                    'tipo_orden_numero'                         => $rowMSSQL00['tipo_orden_numero'],
                    'tipo_dia_cantidad'                         => $rowMSSQL00['tipo_dia_cantidad'],
                    'tipo_dia_corrido'                          => trim(strtoupper($rowMSSQL00['tipo_dia_corrido'])),
                    'tipo_dia_unidad'                           => trim(strtoupper($rowMSSQL00['tipo_dia_unidad'])),
                    'tipo_archivo_adjunto'                      => trim(strtoupper($rowMSSQL00['tipo_archivo_adjunto'])),
                    'tipo_observacion'                          => trim(strtoupper($rowMSSQL00['tipo_observacion'])),
                    'auditoria_usuario'                         => trim(strtoupper($rowMSSQL00['auditoria_usuario'])),
                    'auditoria_fecha_hora'                      => $rowMSSQL00['auditoria_fecha_hora'],
                    'auditoria_ip'                              => trim(strtoupper($rowMSSQL00['auditoria_ip']))
                );

                $result[]   = $detalle;

                $stmtMSSQL01->closeCursor();
                $stmtMSSQL01 = null;
            }

            if (isset($result)){
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } else {
                $detalle = array(
                    'tipo_permiso_codigo'                       => '',
                    'tipo_estado_codigo'                        => '',
                    'tipo_estado_nombre'                        => '',
                    'tipo_solicitud_codigo'                     => '',
                    'tipo_solicitud_nombre'                     => '',
                    'tipo_permiso_codigo1'                      => '',
                    'tipo_permiso_codigo2'                      => '',
                    'tipo_permiso_codigo3'                      => '',
                    'tipo_permiso_nombre'                       => '',
                    'tipo_orden_numero'                         => '',
                    'tipo_dia_cantidad'                         => '',
                    'tipo_dia_corrido'                          => '',
                    'tipo_dia_unidad'                           => '',
                    'tipo_archivo_adjunto'                      => '',
                    'tipo_observacion'                          => '',
                    'auditoria_usuario'                         => '',
                    'auditoria_fecha_hora'                      => '',
                    'auditoria_ip'                              => ''
                );

                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }

            $stmtMSSQL00->closeCursor();
            $stmtMSSQL00 = null;
        } catch (PDOException $e) {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v2/100/solicitud/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val01      = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
            a.DOMSOLCOD         AS          tipo_permiso_codigo,
            a.DOMSOLEST         AS          tipo_estado_codigo,
            a.DOMSOLTST         AS          tipo_solicitud_codigo,
            a.DOMSOLPC1         AS          tipo_permiso_codigo1,
            a.DOMSOLPC2         AS          tipo_permiso_codigo2,
            a.DOMSOLPC3         AS          tipo_permiso_codigo3,
            a.DOMSOLORD         AS          tipo_orden_numero,
            a.DOMSOLDIC         AS          tipo_dia_cantidad,
            a.DOMSOLDIO         AS          tipo_dia_corrido,
            a.DOMSOLDIU         AS          tipo_dia_unidad,
            a.DOMSOLADJ         AS          tipo_archivo_adjunto,
            a.DOMSOLOBS         AS          tipo_observacion,
            a.DOMSOLUSU         AS          auditoria_usuario,
            a.DOMSOLFEC         AS          auditoria_fecha_hora,
            a.DOMSOLDIP         AS          auditoria_ip
            
            FROM [adm].[DOMSOL] a

            WHERE a.DOMSOLCOD = ?

            ORDER BY a.DOMSOLTST, a.DOMSOLORD";

            try {
                $connMSSQL  = getConnectionMSSQLv2();

                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val01]);
                
                while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                    $sql01  = '';

                    switch ($rowMSSQL00['tipo_estado_codigo']) {
                        case 'A':
                            $tipo_estado_nombre = 'ACTIVO';
                            break;
                        
                        case 'I':
                            $tipo_estado_nombre = 'INACTIVO';
                            break;
                    }

                    switch ($rowMSSQL00['tipo_solicitud_codigo']) {
                        case 'L':
                            $tipo_solicitud_nombre  = 'LICENCIA';
                            $sql01                  = "SELECT U_NOMBRE AS tipo_permiso_nombre FROM [CSF].[dbo].[@A1A_TILC] WHERE U_CODIGO = ?";
                            break;
                        
                        case 'P':
                            $tipo_solicitud_nombre  = 'PERMISO';
                            $sql01                  = "SELECT U_NOMBRE AS tipo_permiso_nombre FROM [CSF].[dbo].[@A1A_TIPE] WHERE U_CODIGO = ?";
                            break;
        
                        case 'I':
                            $tipo_solicitud_nombre  = 'INASISTENCIA';
                            $sql01                  = "SELECT U_DESAMP AS tipo_permiso_nombre FROM [CSF].[dbo].[@A1A_TIIN] WHERE U_CODIGO = ?";
                            break;
                    }

                    $stmtMSSQL01= $connMSSQL->prepare($sql01);
                    $stmtMSSQL01->execute([trim(strtoupper($rowMSSQL00['tipo_permiso_codigo3']))]);
                    $rowMSSQL01 = $stmtMSSQL01->fetch(PDO::FETCH_ASSOC);

                    $tipo_permiso_nombre = $rowMSSQL01['tipo_permiso_nombre'];

                    $detalle    = array(
                        'tipo_permiso_codigo'                       => $rowMSSQL00['tipo_permiso_codigo'],
                        'tipo_estado_codigo'                        => $rowMSSQL00['tipo_estado_codigo'],
                        'tipo_estado_nombre'                        => trim(strtoupper($tipo_estado_nombre)),
                        'tipo_solicitud_codigo'                     => $rowMSSQL00['tipo_solicitud_codigo'],
                        'tipo_solicitud_nombre'                     => trim(strtoupper($tipo_solicitud_nombre)),
                        'tipo_permiso_codigo1'                      => $rowMSSQL00['tipo_permiso_codigo1'],
                        'tipo_permiso_codigo2'                      => $rowMSSQL00['tipo_permiso_codigo2'],
                        'tipo_permiso_codigo3'                      => trim(strtoupper($rowMSSQL00['tipo_permiso_codigo3'])),
                        'tipo_permiso_nombre'                       => trim(strtoupper($tipo_permiso_nombre)),
                        'tipo_orden_numero'                         => $rowMSSQL00['tipo_orden_numero'],
                        'tipo_dia_cantidad'                         => $rowMSSQL00['tipo_dia_cantidad'],
                        'tipo_dia_corrido'                          => trim(strtoupper($rowMSSQL00['tipo_dia_corrido'])),
                        'tipo_dia_unidad'                           => trim(strtoupper($rowMSSQL00['tipo_dia_unidad'])),
                        'tipo_archivo_adjunto'                      => trim(strtoupper($rowMSSQL00['tipo_archivo_adjunto'])),
                        'tipo_observacion'                          => trim(strtoupper($rowMSSQL00['tipo_observacion'])),
                        'auditoria_usuario'                         => trim(strtoupper($rowMSSQL00['auditoria_usuario'])),
                        'auditoria_fecha_hora'                      => $rowMSSQL00['auditoria_fecha_hora'],
                        'auditoria_ip'                              => trim(strtoupper($rowMSSQL00['auditoria_ip']))
                    );

                    $result[]   = $detalle;

                    $stmtMSSQL01->closeCursor();
                    $stmtMSSQL01 = null;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'tipo_permiso_codigo'                       => '',
                        'tipo_estado_codigo'                        => '',
                        'tipo_estado_nombre'                        => '',
                        'tipo_solicitud_codigo'                     => '',
                        'tipo_solicitud_nombre'                     => '',
                        'tipo_permiso_codigo1'                      => '',
                        'tipo_permiso_codigo2'                      => '',
                        'tipo_permiso_codigo3'                      => '',
                        'tipo_permiso_nombre'                       => '',
                        'tipo_orden_numero'                         => '',
                        'tipo_dia_cantidad'                         => '',
                        'tipo_dia_corrido'                          => '',
                        'tipo_dia_unidad'                           => '',
                        'tipo_archivo_adjunto'                      => '',
                        'tipo_observacion'                          => '',
                        'auditoria_usuario'                         => '',
                        'auditoria_fecha_hora'                      => '',
                        'auditoria_ip'                              => ''
                    );

                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                }

                $stmtMSSQL00->closeCursor();
                $stmtMSSQL00 = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v2/100/pais', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $sql00  = "SELECT
            a.LOCPAICOD         AS          localidad_pais_codigo,
            a.LOCPAIORD         AS          localidad_pais_orden,
            a.LOCPAINOM         AS          localidad_pais_nombre,
            a.LOCPAIPAT         AS          localidad_pais_path,
            a.LOCPAIIC2         AS          localidad_pais_iso_char2,
            a.LOCPAIIC3         AS          localidad_pais_iso_char3,
            a.LOCPAIIN3         AS          localidad_pais_iso_num3,
            a.LOCPAIOBS         AS          localidad_pais_observacion,

            a.LOCPAIAUS         AS          auditoria_usuario,
            a.LOCPAIAFH         AS          auditoria_fecha_hora,
            a.LOCPAIAIP         AS          auditoria_ip,

            b.DOMFICCOD         AS          tipo_estado_codigo,
            b.DOMFICNOI         AS          tipo_estado_ingles,
            b.DOMFICNOC         AS          tipo_estado_castellano,
            b.DOMFICNOP         AS          tipo_estado_portugues
            
            FROM [adm].[LOCPAI] a
            INNER JOIN [adm].[DOMFIC] b ON a.LOCPAIEST = b.DOMFICCOD

            ORDER BY a.LOCPAIORD, a.LOCPAINOM";

        try {
            $connMSSQL  = getConnectionMSSQLv2();

            $stmtMSSQL00= $connMSSQL->prepare($sql00);
            $stmtMSSQL00->execute();
            
            while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                $detalle    = array(
                    'localidad_pais_codigo'             => $rowMSSQL00['localidad_pais_codigo'],
                    'localidad_pais_orden'              => $rowMSSQL00['localidad_pais_orden'],
                    'localidad_pais_nombre'             => trim(strtoupper(strtolower($rowMSSQL00['localidad_pais_nombre']))),
                    'localidad_pais_path'               => trim(strtolower($rowMSSQL00['localidad_pais_path'])),
                    'localidad_pais_iso_char2'          => trim(strtoupper(strtolower($rowMSSQL00['localidad_pais_iso_char2']))),
                    'localidad_pais_iso_char3'          => trim(strtoupper(strtolower($rowMSSQL00['localidad_pais_iso_char3']))),
                    'localidad_pais_iso_num3'           => sprintf("%03d", trim(strtoupper(strtolower($rowMSSQL00['localidad_pais_iso_num3'])))),
                    'localidad_pais_observacion'        => trim(strtoupper(strtolower($rowMSSQL00['localidad_pais_observacion']))),

                    'auditoria_usuario'                 => trim(strtoupper($rowMSSQL00['auditoria_usuario'])),
                    'auditoria_fecha_hora'              => $rowMSSQL00['auditoria_fecha_hora'],
                    'auditoria_ip'                      => trim(strtoupper($rowMSSQL00['auditoria_ip'])),

                    'tipo_estado_codigo'                => $rowMSSQL00['tipo_estado_codigo'],
                    'tipo_estado_ingles'                => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_ingles']))),
                    'tipo_estado_castellano'            => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_castellano']))),
                    'tipo_estado_portugues'             => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_portugues'])))
                );

                $result[]   = $detalle;
            }

            if (isset($result)){
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } else {
                $detalle = array(
                    'localidad_pais_codigo'             => '',
                    'localidad_pais_orden'              => '',
                    'localidad_pais_nombre'             => '',
                    'localidad_pais_path'               => '',
                    'localidad_pais_iso_char2'          => '',
                    'localidad_pais_iso_char3'          => '',
                    'localidad_pais_iso_num3'           => '',
                    'localidad_pais_observacion'        => '',

                    'auditoria_usuario'                 => '',
                    'auditoria_fecha_hora'              => '',
                    'auditoria_ip'                      => '',

                    'tipo_estado_codigo'                => '',
                    'tipo_estado_ingles'                => '',
                    'tipo_estado_castellano'            => '',
                    'tipo_estado_portugues'             => ''
                );

                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }

            $stmtMSSQL00->closeCursor();
            $stmtMSSQL00 = null;
        } catch (PDOException $e) {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v2/100/ciudad', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $sql00  = "SELECT
            a.LOCCIUCOD         AS          localidad_ciudad_codigo,
            a.LOCCIUORD         AS          localidad_ciudad_orden,
            a.LOCCIUNOM         AS          localidad_ciudad_nombre,
            a.LOCCIUOBS         AS          localidad_ciudad_observacion,

            a.LOCCIUAUS         AS          auditoria_usuario,
            a.LOCCIUAFH         AS          auditoria_fecha_hora,
            a.LOCCIUAIP         AS          auditoria_ip,

            b.DOMFICCOD         AS          tipo_estado_codigo,
            b.DOMFICNOI         AS          tipo_estado_ingles,
            b.DOMFICNOC         AS          tipo_estado_castellano,
            b.DOMFICNOP         AS          tipo_estado_portugues,

            c.LOCPAICOD         AS          localidad_pais_codigo,
            c.LOCPAIORD         AS          localidad_pais_orden,
            c.LOCPAINOM         AS          localidad_pais_nombre,
            c.LOCPAIPAT         AS          localidad_pais_path,
            c.LOCPAIIC2         AS          localidad_pais_iso_char2,
            c.LOCPAIIC3         AS          localidad_pais_iso_char3,
            c.LOCPAIIN3         AS          localidad_pais_iso_num3,
            c.LOCPAIOBS         AS          localidad_pais_observacion
            
            FROM [adm].[LOCCIU] a
            INNER JOIN [adm].[DOMFIC] b ON a.LOCCIUEST = b.DOMFICCOD
            INNER JOIN [adm].[LOCPAI] c ON a.LOCCIUPAC = c.LOCPAICOD

            ORDER BY a.LOCCIUORD, c.LOCPAINOM, a.LOCCIUNOM";

        try {
            $connMSSQL  = getConnectionMSSQLv2();

            $stmtMSSQL00= $connMSSQL->prepare($sql00);
            $stmtMSSQL00->execute();
            
            while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                $detalle    = array(
                    'localidad_ciudad_codigo'           => $rowMSSQL00['localidad_ciudad_codigo'],
                    'localidad_ciudad_orden'            => $rowMSSQL00['localidad_ciudad_orden'],
                    'localidad_ciudad_nombre'           => trim(strtoupper(strtolower($rowMSSQL00['localidad_ciudad_nombre']))),
                    'localidad_ciudad_observacion'      => trim(strtolower($rowMSSQL00['localidad_ciudad_observacion'])),

                    'auditoria_usuario'                 => trim(strtoupper($rowMSSQL00['auditoria_usuario'])),
                    'auditoria_fecha_hora'              => $rowMSSQL00['auditoria_fecha_hora'],
                    'auditoria_ip'                      => trim(strtoupper($rowMSSQL00['auditoria_ip'])),

                    'tipo_estado_codigo'                => $rowMSSQL00['tipo_estado_codigo'],
                    'tipo_estado_ingles'                => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_ingles']))),
                    'tipo_estado_castellano'            => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_castellano']))),
                    'tipo_estado_portugues'             => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_portugues']))),

                    'localidad_pais_codigo'             => $rowMSSQL00['localidad_pais_codigo'],
                    'localidad_pais_orden'              => $rowMSSQL00['localidad_pais_orden'],
                    'localidad_pais_nombre'             => trim(strtoupper(strtolower($rowMSSQL00['localidad_pais_nombre']))),
                    'localidad_pais_path'               => trim(strtolower($rowMSSQL00['localidad_pais_path'])),
                    'localidad_pais_iso_char2'          => trim(strtoupper(strtolower($rowMSSQL00['localidad_pais_iso_char2']))),
                    'localidad_pais_iso_char3'          => trim(strtoupper(strtolower($rowMSSQL00['localidad_pais_iso_char3']))),
                    'localidad_pais_iso_num3'           => trim(strtoupper(strtolower($rowMSSQL00['localidad_pais_iso_num3']))),
                    'localidad_pais_observacion'        => trim(strtoupper(strtolower($rowMSSQL00['localidad_pais_observacion'])))
                );

                $result[]   = $detalle;
            }

            if (isset($result)){
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } else {
                $detalle = array(
                    'localidad_ciudad_codigo'           => '',
                    'localidad_ciudad_orden'            => '',
                    'localidad_ciudad_nombre'           => '',
                    'localidad_ciudad_observacion'      => '',

                    'auditoria_usuario'                 => '',
                    'auditoria_fecha_hora'              => '',
                    'auditoria_ip'                      => '',

                    'tipo_estado_codigo'                => '',
                    'tipo_estado_ingles'                => '',
                    'tipo_estado_castellano'            => '',
                    'tipo_estado_portugues'             => '',

                    'localidad_pais_codigo'             => '',
                    'localidad_pais_orden'              => '',
                    'localidad_pais_nombre'             => '',
                    'localidad_pais_path'               => '',
                    'localidad_pais_iso_char2'          => '',
                    'localidad_pais_iso_char3'          => '',
                    'localidad_pais_iso_num3'           => '',
                    'localidad_pais_observacion'        => ''
                );

                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }

            $stmtMSSQL00->closeCursor();
            $stmtMSSQL00 = null;
        } catch (PDOException $e) {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v2/100/aeropuerto', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $sql00  = "SELECT
            a.LOCAERCOD         AS          localidad_aeropuerto_codigo,
            a.LOCAERORD         AS          localidad_aeropuerto_orden,
            a.LOCAERNOM         AS          localidad_aeropuerto_nombre,
            a.LOCAEROBS         AS          localidad_aeropuerto_observacion,

            a.LOCAERAUS         AS          auditoria_usuario,
            a.LOCAERAFH         AS          auditoria_fecha_hora,
            a.LOCAERAIP         AS          auditoria_ip,

            b.DOMFICCOD         AS          tipo_estado_codigo,
            b.DOMFICNOI         AS          tipo_estado_ingles,
            b.DOMFICNOC         AS          tipo_estado_castellano,
            b.DOMFICNOP         AS          tipo_estado_portugues,

            c.LOCPAICOD         AS          localidad_pais_codigo,
            c.LOCPAIORD         AS          localidad_pais_orden,
            c.LOCPAINOM         AS          localidad_pais_nombre,
            c.LOCPAIPAT         AS          localidad_pais_path,
            c.LOCPAIIC2         AS          localidad_pais_iso_char2,
            c.LOCPAIIC3         AS          localidad_pais_iso_char3,
            c.LOCPAIIN3         AS          localidad_pais_iso_num3,
            c.LOCPAIOBS         AS          localidad_pais_observacion
            
            FROM [adm].[LOCAER] a
            INNER JOIN [adm].[DOMFIC] b ON a.LOCAEREST = b.DOMFICCOD
            INNER JOIN [adm].[LOCPAI] c ON a.LOCAERPAC = c.LOCPAICOD

            ORDER BY a.LOCAERORD, c.LOCPAINOM, a.LOCAERNOM";

        try {
            $connMSSQL  = getConnectionMSSQLv2();

            $stmtMSSQL00= $connMSSQL->prepare($sql00);
            $stmtMSSQL00->execute();
            
            while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                $detalle    = array(
                    'localidad_aeropuerto_codigo'       => $rowMSSQL00['localidad_aeropuerto_codigo'],
                    'localidad_aeropuerto_orden'        => $rowMSSQL00['localidad_aeropuerto_orden'],
                    'localidad_aeropuerto_nombre'       => trim(strtoupper(strtolower($rowMSSQL00['localidad_aeropuerto_nombre']))),
                    'localidad_aeropuerto_observacion'  => trim(strtolower($rowMSSQL00['localidad_aeropuerto_observacion'])),

                    'auditoria_usuario'                 => trim(strtoupper($rowMSSQL00['auditoria_usuario'])),
                    'auditoria_fecha_hora'              => $rowMSSQL00['auditoria_fecha_hora'],
                    'auditoria_ip'                      => trim(strtoupper($rowMSSQL00['auditoria_ip'])),

                    'tipo_estado_codigo'                => $rowMSSQL00['tipo_estado_codigo'],
                    'tipo_estado_ingles'                => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_ingles']))),
                    'tipo_estado_castellano'            => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_castellano']))),
                    'tipo_estado_portugues'             => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_portugues']))),

                    'localidad_pais_codigo'             => $rowMSSQL00['localidad_pais_codigo'],
                    'localidad_pais_orden'              => $rowMSSQL00['localidad_pais_orden'],
                    'localidad_pais_nombre'             => trim(strtoupper(strtolower($rowMSSQL00['localidad_pais_nombre']))),
                    'localidad_pais_path'               => trim(strtolower($rowMSSQL00['localidad_pais_path'])),
                    'localidad_pais_iso_char2'          => trim(strtoupper(strtolower($rowMSSQL00['localidad_pais_iso_char2']))),
                    'localidad_pais_iso_char3'          => trim(strtoupper(strtolower($rowMSSQL00['localidad_pais_iso_char3']))),
                    'localidad_pais_iso_num3'           => trim(strtoupper(strtolower($rowMSSQL00['localidad_pais_iso_num3']))),
                    'localidad_pais_observacion'        => trim(strtoupper(strtolower($rowMSSQL00['localidad_pais_observacion'])))
                );

                $result[]   = $detalle;
            }

            if (isset($result)){
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } else {
                $detalle = array(
                    'localidad_aeropuerto_codigo'       => '',
                    'localidad_aeropuerto_orden'        => '',
                    'localidad_aeropuerto_nombre'       => '',
                    'localidad_aeropuerto_observacion'  => '',

                    'auditoria_usuario'                 => '',
                    'auditoria_fecha_hora'              => '',
                    'auditoria_ip'                      => '',

                    'tipo_estado_codigo'                => '',
                    'tipo_estado_ingles'                => '',
                    'tipo_estado_castellano'            => '',
                    'tipo_estado_portugues'             => '',

                    'localidad_pais_codigo'             => '',
                    'localidad_pais_orden'              => '',
                    'localidad_pais_nombre'             => '',
                    'localidad_pais_path'               => '',
                    'localidad_pais_iso_char2'          => '',
                    'localidad_pais_iso_char3'          => '',
                    'localidad_pais_iso_num3'           => '',
                    'localidad_pais_observacion'        => ''
                );

                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }

            $stmtMSSQL00->closeCursor();
            $stmtMSSQL00 = null;
        } catch (PDOException $e) {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v2/200/solicitudes', function($request) {
        require __DIR__.'/../src/connect.php';
        
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
            b.DOMSOLPC1         AS          tipo_permiso_codigo1,
            b.DOMSOLPC2         AS          tipo_permiso_codigo2,
            b.DOMSOLPC3         AS          tipo_permiso_codigo3,
            b.DOMSOLORD         AS          tipo_orden_numero,
            b.DOMSOLDIC         AS          tipo_dia_cantidad,
            b.DOMSOLDIO         AS          tipo_dia_corrido,
            b.DOMSOLDIU         AS          tipo_dia_unidad,
            b.DOMSOLADJ         AS          tipo_archivo_adjunto,
            b.DOMSOLOBS         AS          tipo_observacion

            FROM [hum].[SOLFIC] a
            INNER JOIN [adm].[DOMSOL] b ON a.SOLFICTST = b.DOMSOLCOD";

        $sql03  = "SELECT
            a.CedulaEmpleado            AS          documento,
            a.ApellidoPaterno           AS          apellido_1,
            a.ApellidoMaterno           AS          apellido_2,
            a.PrimerNombre              AS          nombre_1,
            a.SegundoNombre             AS          nombre_2,
            a.NombreEmpleado            AS          nombre_completo,
            a.Sexo                      AS          tipo_sexo_codigo,
            a.EstadoCivil               AS          estado_civil_codigo,
            a.Email                     AS          email,
            a.FechaNacimiento           AS          fecha_nacimiento,
            a.CodigoCargo               AS          cargo_codigo,
            a.Cargo                     AS          cargo_nombre,
            a.CodigoGerencia            AS          gerencia_codigo,
            a.Gerencia                  AS          gerencia_nombre,
            a.CodigoDepto               AS          departamento_codigo,
            a.Departamento              AS          departamento_nombre,         
            a.CodCargoSuperior          AS          superior_cargo_codigo,
            a.NombreCargoSuperior       AS          superior_cargo_nombre,
            a.Manager                   AS          superior_manager_nombre,
            a.EmailManager              AS          superior_manager_email

            FROM [CSF].[dbo].[empleados_AxisONE] a

            WHERE a.CedulaEmpleado = ?";

        try {
            $connMSSQL  = getConnectionMSSQLv2();
            
            $stmtMSSQL01= $connMSSQL->prepare($sql01);
            $stmtMSSQL01->execute([]);

            while ($rowMSSQL01 = $stmtMSSQL01->fetch()) {
                switch ($rowMSSQL01['solicitud_estado_codigo']) {
                    case 'I':
                        $solicitud_estado_nombre = 'INGRESADO';
                        break;
                    
                    case 'A':
                        $solicitud_estado_nombre = 'AUTORIZADO';
                        break;
                    
                    case 'P':
                        $solicitud_estado_nombre = 'APROBADO';
                        break;

                    case 'C':
                        $solicitud_estado_nombre = 'ANULADO';
                        break;
                }

                switch ($rowMSSQL01['tipo_solicitud_codigo']) {
                    case 'L':
                        $tipo_solicitud_nombre  = 'LICENCIA';
                        $sql02                  = "SELECT U_NOMBRE AS tipo_permiso_nombre FROM [CSF].[dbo].[@A1A_TILC] WHERE U_CODIGO = ?";
                        break;
                    
                    case 'P':
                        $tipo_solicitud_nombre  = 'PERMISO';
                        $sql02                  = "SELECT U_NOMBRE AS tipo_permiso_nombre FROM [CSF].[dbo].[@A1A_TIPE] WHERE U_CODIGO = ?";
                        break;
    
                    case 'I':
                        $tipo_solicitud_nombre  = 'INASISTENCIA';
                        $sql02                  = "SELECT U_DESAMP AS tipo_permiso_nombre FROM [CSF].[dbo].[@A1A_TIIN] WHERE U_CODIGO = ?";
                        break;
                }

                $stmtMSSQL02= $connMSSQL->prepare($sql02);
                $stmtMSSQL02->execute([trim(strtoupper($rowMSSQL01['tipo_permiso_codigo3']))]);
                $rowMSSQL02 = $stmtMSSQL02->fetch(PDO::FETCH_ASSOC);

                $stmtMSSQL03= $connMSSQL->prepare($sql03);
                $stmtMSSQL03->execute([trim(strtoupper($rowMSSQL01['solicitud_documento']))]);
                $rowMSSQL03 = $stmtMSSQL03->fetch(PDO::FETCH_ASSOC);

                $tipo_permiso_nombre= $rowMSSQL02['tipo_permiso_nombre'];
                $solicitud_persona  = $rowMSSQL03['nombre_completo'];

                $detalle    = array(
                    'tipo_permiso_codigo'               => $rowMSSQL01['tipo_permiso_codigo'],
                    'tipo_permiso_nombre'               => trim(strtoupper($tipo_permiso_nombre)),
                    'solicitud_codigo'                  => $rowMSSQL01['solicitud_codigo'],
                    'solicitud_estado_codigo'           => $rowMSSQL01['solicitud_estado_codigo'],
                    'solicitud_estado_nombre'           => trim(strtoupper($solicitud_estado_nombre)),
                    'solicitud_documento'               => trim(strtoupper($rowMSSQL01['solicitud_documento'])),
                    'solicitud_persona'                 => trim(strtoupper($solicitud_persona)),
                    'solicitud_fecha_desde_1'           => $rowMSSQL01['solicitud_fecha_desde'],
                    'solicitud_fecha_desde_2'           => date("d/m/Y", strtotime($rowMSSQL01['solicitud_fecha_desde'])),
                    'solicitud_fecha_hasta_1'           => $rowMSSQL01['solicitud_fecha_hasta'],
                    'solicitud_fecha_hasta_2'           => date("d/m/Y", strtotime($rowMSSQL01['solicitud_fecha_hasta'])),
                    'solicitud_fecha_cantidad'          => $rowMSSQL01['solicitud_fecha_cantidad'],
                    'solicitud_hora_desde'              => trim(strtoupper($rowMSSQL01['solicitud_hora_desde'])),
                    'solicitud_hora_hasta'              => trim(strtoupper($rowMSSQL01['solicitud_hora_hasta'])),
                    'solicitud_hora_cantidad'           => $rowMSSQL01['solicitud_hora_cantidad'],
                    'solicitud_adjunto'                 => trim(strtolower($rowMSSQL01['solicitud_adjunto'])),
                    'solicitud_usuario_colaborador'     => trim(strtoupper($rowMSSQL01['solicitud_usuario_colaborador'])),
                    'solicitud_fecha_hora_colaborador'  => date("d/m/Y", strtotime($rowMSSQL01['solicitud_fecha_hora_colaborador'])),
                    'solicitud_ip_colaborador'          => trim(strtoupper($rowMSSQL01['solicitud_ip_colaborador'])),
                    'solicitud_observacion_colaborador' => trim(strtoupper($rowMSSQL01['solicitud_observacion_colaborador'])),
                    'solicitud_usuario_superior'        => trim(strtoupper($rowMSSQL01['solicitud_usuario_superior'])),
                    'solicitud_fecha_hora_superior'     => date("d/m/Y", strtotime($rowMSSQL01['solicitud_fecha_hora_superior'])),
                    'solicitud_ip_superior'             => trim(strtoupper($rowMSSQL01['solicitud_ip_superior'])),
                    'solicitud_observacion_superior'    => trim(strtoupper($rowMSSQL01['solicitud_observacion_superior'])),
                    'solicitud_usuario_talento'         => trim(strtoupper($rowMSSQL01['solicitud_usuario_talento'])),
                    'solicitud_fecha_hora_talento'      => date("d/m/Y", strtotime($rowMSSQL01['solicitud_fecha_hora_talento'])),
                    'solicitud_ip_talento'              => trim(strtoupper($rowMSSQL01['solicitud_ip_talento'])),
                    'solicitud_observacion_talento'     => trim(strtoupper($rowMSSQL01['solicitud_observacion_talento'])),
                    'auditoria_usuario'                 => trim(strtoupper($rowMSSQL01['auditoria_usuario'])),
                    'auditoria_fecha_hora'              => date("d/m/Y", strtotime($rowMSSQL01['auditoria_fecha_hora'])),
                    'auditoria_ip'                      => trim(strtoupper($rowMSSQL01['auditoria_ip'])),

                    'gerencia_codigo'                   => $rowMSSQL03['gerencia_codigo'],
                    'gerencia_nombre'                   => trim(strtoupper($rowMSSQL03['gerencia_nombre'])),
                    'tipo_sexo_codigo'                  => trim(strtoupper($rowMSSQL03['tipo_sexo_codigo'])),
                    'colaborador_edad'                  => date('Y') - date('Y', strtotime($rowMSSQL03['fecha_nacimiento'])),
                    'departamento_codigo'               => $rowMSSQL03['departamento_codigo'],
                    'departamento_nombre'               => trim(strtoupper($rowMSSQL03['departamento_nombre']))
                );

                $result[]   = $detalle;
            }

            if (isset($result)){
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } else {
                $detalle    = array(
                    'tipo_solicitud_codigo'             => '',
                    'tipo_permiso_nombre'               => '',
                    'solicitud_codigo'                  => '',
                    'solicitud_estado_codigo'           => '',
                    'solicitud_estado_nombre'           => '',
                    'solicitud_documento'               => '',
                    'solicitud_fecha_desde_1'           => '',
                    'solicitud_fecha_desde_2'           => '',
                    'solicitud_fecha_hasta_1'           => '',
                    'solicitud_fecha_hasta_2'           => '',
                    'solicitud_fecha_cantidad'          => '',
                    'solicitud_hora_desde'              => '',
                    'solicitud_hora_hasta'              => '',
                    'solicitud_hora_cantidad'           => '',
                    'solicitud_adjunto'                 => '',
                    'solicitud_usuario_colaborador'     => '',
                    'solicitud_fecha_hora_colaborador'  => '',
                    'solicitud_ip_colaborador'          => '',
                    'solicitud_observacion_colaborador' => '',
                    'solicitud_usuario_superior'        => '',
                    'solicitud_fecha_hora_superior'     => '',
                    'solicitud_ip_superior'             => '',
                    'solicitud_observacion_superior'    => '',
                    'solicitud_usuario_talento'         => '',
                    'solicitud_fecha_hora_talento'      => '',
                    'solicitud_ip_talento'              => '',
                    'solicitud_observacion_talento'     => '',
                    'auditoria_usuario'                 => '',
                    'auditoria_fecha_hora'              => '',
                    'auditoria_ip'                      => '',
                    'gerencia_codigo'                   => '',
                    'gerencia_nombre'                   => '',
                    'tipo_sexo_codigo'                  => '',
                    'colaborador_edad'                  => '',
                    'departamento_codigo'               => '',
                    'departamento_nombre'               => ''
                );

                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }

            $stmtMSSQL01->closeCursor();
            $stmtMSSQL01 = null;

            $stmtMSSQL02->closeCursor();
            $stmtMSSQL02 = null;

            $stmtMSSQL03->closeCursor();
            $stmtMSSQL03 = null;
        } catch (PDOException $e) {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v2/200/solicitudes/{tipo}/{codigo}/{estado}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val01      = $request->getAttribute('tipo');
        $val02      = $request->getAttribute('codigo');
        $val03      = $request->getAttribute('estado');
        
        if (isset($val01) && isset($val02)) {            
            if ($val01 == '1') {
                $sql00  = "SELECT
                    a.IDEmpleado                AS          codigo,
                    a.Estado                    AS          estado,
                    a.CedulaEmpleado            AS          documento,
                    a.ApellidoPaterno           AS          apellido_1,
                    a.ApellidoMaterno           AS          apellido_2,
                    a.PrimerNombre              AS          nombre_1,
                    a.SegundoNombre             AS          nombre_2,
                    a.NombreEmpleado            AS          nombre_completo,
                    a.Sexo                      AS          tipo_sexo_codigo,
                    a.EstadoCivil               AS          estado_civil_codigo,
                    a.Email                     AS          email,
                    a.FechaNacimiento           AS          fecha_nacimiento,
                    a.IDUsuario                 AS          usuario_id,
                    a.UsuarioSAP                AS          usuario_sap,
                    a.IDTarjeta                 AS          tarjeta_id,
                    a.CodigoCargo               AS          cargo_codigo,
                    a.Cargo                     AS          cargo_nombre,
                    a.CodigoGerencia            AS          gerencia_codigo,
                    a.Gerencia                  AS          gerencia_nombre,
                    a.CodigoDepto               AS          departamento_codigo,
                    a.Departamento              AS          departamento_nombre,
                    a.CodCargoSuperior          AS          superior_cargo_codigo,
                    a.NombreCargoSuperior       AS          superior_cargo_nombre,
                    a.Manager                   AS          superior_manager_nombre,
                    a.EmailManager              AS          superior_manager_email

                    FROM [CSF].[dbo].[empleados_AxisONE] a

                    WHERE a.CedulaEmpleado = ?";
            } elseif ($val01 == '2') {
                $sql00  = "SELECT
                    a.IDEmpleado                AS          codigo,
                    a.Estado                    AS          estado,
                    a.CedulaEmpleado            AS          documento,
                    a.ApellidoPaterno           AS          apellido_1,
                    a.ApellidoMaterno           AS          apellido_2,
                    a.PrimerNombre              AS          nombre_1,
                    a.SegundoNombre             AS          nombre_2,
                    a.NombreEmpleado            AS          nombre_completo,
                    a.Sexo                      AS          tipo_sexo_codigo,
                    a.EstadoCivil               AS          estado_civil_codigo,
                    a.Email                     AS          email,
                    a.FechaNacimiento           AS          fecha_nacimiento,
                    a.IDUsuario                 AS          usuario_id,
                    a.UsuarioSAP                AS          usuario_sap,
                    a.IDTarjeta                 AS          tarjeta_id,
                    a.CodigoCargo               AS          cargo_codigo,
                    a.Cargo                     AS          cargo_nombre,
                    a.CodigoGerencia            AS          gerencia_codigo,
                    a.Gerencia                  AS          gerencia_nombre,
                    a.CodigoDepto               AS          departamento_codigo,
                    a.Departamento              AS          departamento_nombre,
                    a.CodCargoSuperior          AS          superior_cargo_codigo,
                    a.NombreCargoSuperior       AS          superior_cargo_nombre,
                    a.Manager                   AS          superior_manager_nombre,
                    a.EmailManager              AS          superior_manager_email

                    FROM [CSF].[dbo].[empleados_AxisONE] a
                    LEFT OUTER JOIN [CSF].[dbo].[empleados_AxisONE] b ON a.CodCargoSuperior = b.CodigoCargo

                    WHERE b.CedulaEmpleado = ?";
            } elseif ($val01 == '3') {
                $sql00  = "SELECT
                    a.IDEmpleado                AS          codigo,
                    a.Estado                    AS          estado,
                    a.CedulaEmpleado            AS          documento,
                    a.ApellidoPaterno           AS          apellido_1,
                    a.ApellidoMaterno           AS          apellido_2,
                    a.PrimerNombre              AS          nombre_1,
                    a.SegundoNombre             AS          nombre_2,
                    a.NombreEmpleado            AS          nombre_completo,
                    a.Sexo                      AS          tipo_sexo_codigo,
                    a.EstadoCivil               AS          estado_civil_codigo,
                    a.Email                     AS          email,
                    a.FechaNacimiento           AS          fecha_nacimiento,
                    a.IDUsuario                 AS          usuario_id,
                    a.UsuarioSAP                AS          usuario_sap,
                    a.IDTarjeta                 AS          tarjeta_id,
                    a.CodigoCargo               AS          cargo_codigo,
                    a.Cargo                     AS          cargo_nombre,
                    a.CodigoGerencia            AS          gerencia_codigo,
                    a.Gerencia                  AS          gerencia_nombre,
                    a.CodigoDepto               AS          departamento_codigo,
                    a.Departamento              AS          departamento_nombre,
                    a.CodCargoSuperior          AS          superior_cargo_codigo,
                    a.NombreCargoSuperior       AS          superior_cargo_nombre,
                    a.Manager                   AS          superior_manager_nombre,
                    a.EmailManager              AS          superior_manager_email

                    FROM [CSF].[dbo].[empleados_AxisONE] a
                    LEFT OUTER JOIN [CSF].[dbo].[empleados_AxisONE] b ON a.CodCargoSuperior = b.CodigoCargo";
            } elseif ($val01 == '4') {
                $sql00  = "SELECT
                    a.IDEmpleado                AS          codigo,
                    a.Estado                    AS          estado,
                    a.CedulaEmpleado            AS          documento,
                    a.ApellidoPaterno           AS          apellido_1,
                    a.ApellidoMaterno           AS          apellido_2,
                    a.PrimerNombre              AS          nombre_1,
                    a.SegundoNombre             AS          nombre_2,
                    a.NombreEmpleado            AS          nombre_completo,
                    a.Sexo                      AS          tipo_sexo_codigo,
                    a.EstadoCivil               AS          estado_civil_codigo,
                    a.Email                     AS          email,
                    a.FechaNacimiento           AS          fecha_nacimiento,
                    a.IDUsuario                 AS          usuario_id,
                    a.UsuarioSAP                AS          usuario_sap,
                    a.IDTarjeta                 AS          tarjeta_id,
                    a.CodigoCargo               AS          cargo_codigo,
                    a.Cargo                     AS          cargo_nombre,
                    a.CodigoGerencia            AS          gerencia_codigo,
                    a.Gerencia                  AS          gerencia_nombre,
                    a.CodigoDepto               AS          departamento_codigo,
                    a.Departamento              AS          departamento_nombre,
                    a.CodCargoSuperior          AS          superior_cargo_codigo,
                    a.NombreCargoSuperior       AS          superior_cargo_nombre,
                    a.Manager                   AS          superior_manager_nombre,
                    a.EmailManager              AS          superior_manager_email

                    FROM [CSF].[dbo].[empleados_AxisONE] a
                    LEFT OUTER JOIN [CSF].[dbo].[empleados_AxisONE] b ON a.CodCargoSuperior = b.CodigoCargo

                    WHERE a.CedulaEmpleado = ? OR b.CedulaEmpleado = ?";
            } elseif ($val01 == '5') {
                $sql00  = "SELECT
                    c.IDEmpleado                AS          codigo,
                    c.Estado                    AS          estado,
                    c.CedulaEmpleado            AS          documento,
                    c.ApellidoPaterno           AS          apellido_1,
                    c.ApellidoMaterno           AS          apellido_2,
                    c.PrimerNombre              AS          nombre_1,
                    c.SegundoNombre             AS          nombre_2,
                    c.NombreEmpleado            AS          nombre_completo,
                    c.Sexo                      AS          tipo_sexo_codigo,
                    c.EstadoCivil               AS          estado_civil_codigo,
                    c.Email                     AS          email,
                    c.FechaNacimiento           AS          fecha_nacimiento,
                    c.IDUsuario                 AS          usuario_id,
                    c.UsuarioSAP                AS          usuario_sap,
                    c.IDTarjeta                 AS          tarjeta_id,
                    c.CodigoCargo               AS          cargo_codigo,
                    c.Cargo                     AS          cargo_nombre,
                    c.CodigoGerencia            AS          gerencia_codigo,
                    c.Gerencia                  AS          gerencia_nombre,
                    c.CodigoDepto               AS          departamento_codigo,
                    c.Departamento              AS          departamento_nombre,
                    c.CodCargoSuperior          AS          superior_cargo_codigo,
                    c.NombreCargoSuperior       AS          superior_cargo_nombre,
                    c.Manager                   AS          superior_manager_nombre,
                    c.EmailManager              AS          superior_manager_email

                    FROM [CSF].[dbo].[empleados_AxisONE] a
                    LEFT OUTER JOIN [CSF].[dbo].[empleados_AxisONE] b ON a.CodigoCargo = b.CodCargoSuperior
                    LEFT OUTER JOIN [CSF].[dbo].[empleados_AxisONE] c ON b.CodigoCargo = c.CodCargoSuperior

                    WHERE a.CedulaEmpleado = ?";
            }

            if ($val03 == 'I' || $val03 == 'A' || $val03 == 'P' || $val03 == 'C') {
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
                    b.DOMSOLPC1         AS          tipo_permiso_codigo1,
                    b.DOMSOLPC2         AS          tipo_permiso_codigo2,
                    b.DOMSOLPC3         AS          tipo_permiso_codigo3,
                    b.DOMSOLORD         AS          tipo_orden_numero,
                    b.DOMSOLDIC         AS          tipo_dia_cantidad,
                    b.DOMSOLDIO         AS          tipo_dia_corrido,
                    b.DOMSOLDIU         AS          tipo_dia_unidad,
                    b.DOMSOLADJ         AS          tipo_archivo_adjunto,
                    b.DOMSOLOBS         AS          tipo_observacion

                    FROM [hum].[SOLFIC] a
                    INNER JOIN [adm].[DOMSOL] b ON a.SOLFICTST = b.DOMSOLCOD

                    WHERE a.SOLFICDOC = ? AND a.SOLFICEST = ?
                    
                    ORDER BY a.SOLFICCOD DESC";
            } elseif ($val03 == 'PC') {
                $val03  = 'C';
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
                    b.DOMSOLPC1         AS          tipo_permiso_codigo1,
                    b.DOMSOLPC2         AS          tipo_permiso_codigo2,
                    b.DOMSOLPC3         AS          tipo_permiso_codigo3,
                    b.DOMSOLORD         AS          tipo_orden_numero,
                    b.DOMSOLDIC         AS          tipo_dia_cantidad,
                    b.DOMSOLDIO         AS          tipo_dia_corrido,
                    b.DOMSOLDIU         AS          tipo_dia_unidad,
                    b.DOMSOLADJ         AS          tipo_archivo_adjunto,
                    b.DOMSOLOBS         AS          tipo_observacion

                    FROM [hum].[SOLFIC] a
                    INNER JOIN [adm].[DOMSOL] b ON a.SOLFICTST = b.DOMSOLCOD

                    WHERE a.SOLFICDOC = ? AND (a.SOLFICEST = 'P' OR a.SOLFICEST = ?) AND a.SOLFICUST <> ''
                    
                    ORDER BY a.SOLFICCOD DESC";
            } elseif ($val03 == 'T') {
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
                    b.DOMSOLPC1         AS          tipo_permiso_codigo1,
                    b.DOMSOLPC2         AS          tipo_permiso_codigo2,
                    b.DOMSOLPC3         AS          tipo_permiso_codigo3,
                    b.DOMSOLORD         AS          tipo_orden_numero,
                    b.DOMSOLDIC         AS          tipo_dia_cantidad,
                    b.DOMSOLDIO         AS          tipo_dia_corrido,
                    b.DOMSOLDIU         AS          tipo_dia_unidad,
                    b.DOMSOLADJ         AS          tipo_archivo_adjunto,
                    b.DOMSOLOBS         AS          tipo_observacion

                    FROM [hum].[SOLFIC] a
                    INNER JOIN [adm].[DOMSOL] b ON a.SOLFICTST = b.DOMSOLCOD

                    WHERE a.SOLFICDOC = ? AND a.SOLFICEST <> ?
                    
                    ORDER BY a.SOLFICCOD DESC";
            }

            try {
                $connMSSQL  = getConnectionMSSQLv2();
                
                $stmtMSSQL00= $connMSSQL->prepare($sql00);

                if ($val01 == '1' || $val01 == '2') {
                    $stmtMSSQL00->execute([$val02]);
                } elseif ($val01 == '3') {
                    $stmtMSSQL00->execute([]);
                } elseif ($val01 == '4') {
                    $stmtMSSQL00->execute([$val02, $val02]);
                } elseif ($val01 == '5') {
                    $stmtMSSQL00->execute([$val02]);
                }

                $stmtMSSQL01= $connMSSQL->prepare($sql01);

                while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                    $stmtMSSQL01->execute([$rowMSSQL00['documento'], $val03]);

                    while ($rowMSSQL01 = $stmtMSSQL01->fetch()) {
                        switch ($rowMSSQL01['solicitud_estado_codigo']) {
                            case 'I':
                                $solicitud_estado_nombre = 'INGRESADO';
                                break;
                            
                            case 'A':
                                $solicitud_estado_nombre = 'AUTORIZADO';
                                break;
                            
                            case 'P':
                                $solicitud_estado_nombre = 'APROBADO';
                                break;
    
                            case 'C':
                                $solicitud_estado_nombre = 'ANULADO';
                                break;
                        }
    
                        switch ($rowMSSQL01['tipo_solicitud_codigo']) {
                            case 'L':
                                $tipo_solicitud_nombre  = 'LICENCIA';
                                $sql02                  = "SELECT U_NOMBRE AS tipo_permiso_nombre FROM [CSF].[dbo].[@A1A_TILC] WHERE U_CODIGO = ?";
                                break;
                            
                            case 'P':
                                $tipo_solicitud_nombre  = 'PERMISO';
                                $sql02                  = "SELECT U_NOMBRE AS tipo_permiso_nombre FROM [CSF].[dbo].[@A1A_TIPE] WHERE U_CODIGO = ?";
                                break;
            
                            case 'I':
                                $tipo_solicitud_nombre  = 'INASISTENCIA';
                                $sql02                  = "SELECT U_DESAMP AS tipo_permiso_nombre FROM [CSF].[dbo].[@A1A_TIIN] WHERE U_CODIGO = ?";
                                break;
                        }
    
                        $stmtMSSQL02= $connMSSQL->prepare($sql02);
                        $stmtMSSQL02->execute([trim(strtoupper($rowMSSQL01['tipo_permiso_codigo3']))]);
                        $rowMSSQL02 = $stmtMSSQL02->fetch(PDO::FETCH_ASSOC);

                        $tipo_permiso_nombre= $rowMSSQL02['tipo_permiso_nombre'];
                        $solicitud_persona  = $rowMSSQL00['nombre_completo'];
    
                        $detalle    = array(
                            'tipo_permiso_codigo'               => $rowMSSQL01['tipo_permiso_codigo'],
                            'tipo_permiso_nombre'               => trim(strtoupper($tipo_permiso_nombre)),
                            'solicitud_codigo'                  => $rowMSSQL01['solicitud_codigo'],
                            'solicitud_estado_codigo'           => $rowMSSQL01['solicitud_estado_codigo'],
                            'solicitud_estado_nombre'           => trim(strtoupper($solicitud_estado_nombre)),
                            'solicitud_documento'               => trim(strtoupper($rowMSSQL01['solicitud_documento'])),
                            'solicitud_persona'                 => trim(strtoupper($solicitud_persona)),
                            'solicitud_fecha_desde_1'           => $rowMSSQL01['solicitud_fecha_desde'],
                            'solicitud_fecha_desde_2'           => date("d/m/Y", strtotime($rowMSSQL01['solicitud_fecha_desde'])),
                            'solicitud_fecha_hasta_1'           => $rowMSSQL01['solicitud_fecha_hasta'],
                            'solicitud_fecha_hasta_2'           => date("d/m/Y", strtotime($rowMSSQL01['solicitud_fecha_hasta'])),
                            'solicitud_fecha_cantidad'          => $rowMSSQL01['solicitud_fecha_cantidad'],
                            'solicitud_hora_desde'              => trim(strtoupper($rowMSSQL01['solicitud_hora_desde'])),
                            'solicitud_hora_hasta'              => trim(strtoupper($rowMSSQL01['solicitud_hora_hasta'])),
                            'solicitud_hora_cantidad'           => $rowMSSQL01['solicitud_hora_cantidad'],
                            'solicitud_adjunto'                 => trim(strtolower($rowMSSQL01['solicitud_adjunto'])),
                            'solicitud_usuario_colaborador'     => trim(strtoupper($rowMSSQL01['solicitud_usuario_colaborador'])),
                            'solicitud_fecha_hora_colaborador'  => date("d/m/Y", strtotime($rowMSSQL01['solicitud_fecha_hora_colaborador'])),
                            'solicitud_ip_colaborador'          => trim(strtoupper($rowMSSQL01['solicitud_ip_colaborador'])),
                            'solicitud_observacion_colaborador' => trim(strtoupper($rowMSSQL01['solicitud_observacion_colaborador'])),
                            'solicitud_usuario_superior'        => trim(strtoupper($rowMSSQL01['solicitud_usuario_superior'])),
                            'solicitud_fecha_hora_superior'     => date("d/m/Y", strtotime($rowMSSQL01['solicitud_fecha_hora_superior'])),
                            'solicitud_ip_superior'             => trim(strtoupper($rowMSSQL01['solicitud_ip_superior'])),
                            'solicitud_observacion_superior'    => trim(strtoupper($rowMSSQL01['solicitud_observacion_superior'])),
                            'solicitud_usuario_talento'         => trim(strtoupper($rowMSSQL01['solicitud_usuario_talento'])),
                            'solicitud_fecha_hora_talento'      => date("d/m/Y", strtotime($rowMSSQL01['solicitud_fecha_hora_talento'])),
                            'solicitud_ip_talento'              => trim(strtoupper($rowMSSQL01['solicitud_ip_talento'])),
                            'solicitud_observacion_talento'     => trim(strtoupper($rowMSSQL01['solicitud_observacion_talento'])),
                            'auditoria_usuario'                 => trim(strtoupper($rowMSSQL01['auditoria_usuario'])),
                            'auditoria_fecha_hora'              => date("d/m/Y", strtotime($rowMSSQL01['auditoria_fecha_hora'])),
                            'auditoria_ip'                      => trim(strtoupper($rowMSSQL01['auditoria_ip']))
                        );
    
                        $result[]   = $detalle;

                        $stmtMSSQL02->closeCursor();
                        $stmtMSSQL02 = null;
                    }
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle    = array(
                        'tipo_solicitud_codigo'             => '',
                        'tipo_permiso_nombre'               => '',
                        'solicitud_codigo'                  => '',
                        'solicitud_estado_codigo'           => '',
                        'solicitud_estado_nombre'           => '',
                        'solicitud_documento'               => '',
                        'solicitud_fecha_desde_1'           => '',
                        'solicitud_fecha_desde_2'           => '',
                        'solicitud_fecha_hasta_1'           => '',
                        'solicitud_fecha_hasta_2'           => '',
                        'solicitud_fecha_cantidad'          => '',
                        'solicitud_hora_desde'              => '',
                        'solicitud_hora_hasta'              => '',
                        'solicitud_hora_cantidad'           => '',
                        'solicitud_adjunto'                 => '',
                        'solicitud_usuario_colaborador'     => '',
                        'solicitud_fecha_hora_colaborador'  => '',
                        'solicitud_ip_colaborador'          => '',
                        'solicitud_observacion_colaborador' => '',
                        'solicitud_usuario_superior'        => '',
                        'solicitud_fecha_hora_superior'     => '',
                        'solicitud_ip_superior'             => '',
                        'solicitud_observacion_superior'    => '',
                        'solicitud_usuario_talento'         => '',
                        'solicitud_fecha_hora_talento'      => '',
                        'solicitud_ip_talento'              => '',
                        'solicitud_observacion_talento'     => '',
                        'auditoria_usuario'                 => '',
                        'auditoria_fecha_hora'              => '',
                        'auditoria_ip'                      => ''
                    );

                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                }

                $stmtMSSQL00->closeCursor();
                $stmtMSSQL00 = null;

                $stmtMSSQL01->closeCursor();
                $stmtMSSQL01 = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v2/200/solicitudes/grafico/tipocab/{sexo}/{tipo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val01  = $request->getAttribute('sexo');
        $val02  = $request->getAttribute('tipo');

        $sql01  = "SELECT count(*) AS solicitud_cantidad, 'TOTAL_COLABORADOR' AS solicitud_tipo
        FROM [CSF].[dbo].[empleados_AxisONE] a
        WHERE a.SEXO = ?
        UNION
        SELECT count(*)  AS solicitud_cantidad, 'CON_SOLICITUD' AS solicitud_tipo
        FROM [CSF].[dbo].[empleados_AxisONE] a
        WHERE a.SEXO = ? AND EXISTS (SELECT * FROM [hum].[SOLFIC] b WHERE b.SOLFICEST <> 'C' AND b.SOLFICTST = ? AND a.CedulaEmpleado = b.SOLFICDOC COLLATE SQL_Latin1_General_CP1_CI_AS)
        UNION
        SELECT count(*)  AS solicitud_cantidad, 'SIN_SOLICITUD' AS solicitud_tipo
        FROM [CSF].[dbo].[empleados_AxisONE] a
        WHERE a.SEXO = ? AND NOT EXISTS (SELECT * FROM [hum].[SOLFIC] b WHERE b.SOLFICEST <> 'C' AND b.SOLFICTST = ? AND a.CedulaEmpleado = b.SOLFICDOC COLLATE SQL_Latin1_General_CP1_CI_AS)";

        try {
            $connMSSQL  = getConnectionMSSQLv2();
            
            $stmtMSSQL01= $connMSSQL->prepare($sql01);
            $stmtMSSQL01->execute([$val01, $val01, $val02, $val01, $val02]);

            while ($rowMSSQL01 = $stmtMSSQL01->fetch()) {
                $detalle    = array(
                    'solicitud_tipo'            => $rowMSSQL01['solicitud_tipo'],
                    'solicitud_cantidad'        => $rowMSSQL01['solicitud_cantidad']
                );

                $result[]   = $detalle;
            }

            if (isset($result)){
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } else {
                $detalle    = array(
                    'solicitud_tipo'            => '',
                    'solicitud_cantidad'        => ''
                );

                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }

            $stmtMSSQL01->closeCursor();
            $stmtMSSQL01 = null;
        } catch (PDOException $e) {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v2/200/solicitudes/grafico/tipodet/{sexo}/{tipo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val01  = $request->getAttribute('sexo');
        $val02  = $request->getAttribute('tipo');

        $sql01  = "SELECT a.CedulaEmpleado AS solicitud_documento, a.NombreEmpleado AS solicitud_persona, 'CON_SOLICITUD' AS solicitud_tipo
        FROM [CSF].[dbo].[empleados_AxisONE] a
        WHERE a.SEXO = ? AND EXISTS (SELECT * FROM [hum].[SOLFIC] b WHERE b.SOLFICEST <> 'C' AND b.SOLFICTST = ? AND a.CedulaEmpleado = b.SOLFICDOC COLLATE SQL_Latin1_General_CP1_CI_AS)
        UNION
        SELECT a.CedulaEmpleado AS solicitud_documento, a.NombreEmpleado AS solicitud_persona, 'SIN_SOLICITUD' AS solicitud_tipo
        FROM [CSF].[dbo].[empleados_AxisONE] a
        WHERE a.SEXO = ? AND NOT EXISTS (SELECT * FROM [hum].[SOLFIC] b WHERE b.SOLFICEST <> 'C' AND b.SOLFICTST = ? AND a.CedulaEmpleado = b.SOLFICDOC COLLATE SQL_Latin1_General_CP1_CI_AS)";

        try {
            $connMSSQL  = getConnectionMSSQLv2();
            
            $stmtMSSQL01= $connMSSQL->prepare($sql01);
            $stmtMSSQL01->execute([$val01, $val02, $val01, $val02]);

            while ($rowMSSQL01 = $stmtMSSQL01->fetch()) {
                $detalle    = array(
                    'solicitud_documento'           => $rowMSSQL01['solicitud_documento'],
                    'solicitud_persona'             => $rowMSSQL01['solicitud_persona'],
                    'solicitud_tipo'                => $rowMSSQL01['solicitud_tipo']
                );

                $result[]   = $detalle;
            }

            if (isset($result)){
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } else {
                $detalle    = array(
                    'solicitud_documento'           => '',
                    'solicitud_persona'             => '',
                    'solicitud_tipo'                => ''
                );

                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }

            $stmtMSSQL01->closeCursor();
            $stmtMSSQL01 = null;
        } catch (PDOException $e) {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v2/200/exportar/tipo/{codigo}/{estado}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val01      = $request->getAttribute('codigo');
        $val02      = $request->getAttribute('estado');
        
        if (isset($val01)) {
            $sql00  = "SELECT
                a.SOLAXICOD         AS          solicitud_detalle_codigo,
                a.SOLAXICAB         AS          solicitud_detalle_cabecera,
                a.SOLAXIEST         AS          solicitud_detalle_estado,
                a.SOLAXISOL         AS          solicitud_detalle_solicitud,
                a.SOLAXIDOC         AS          solicitud_detalle_empleado,
                a.SOLAXIFED         AS          solicitud_detalle_fecha_desde,
                a.SOLAXIFEH         AS          solicitud_detalle_fecha_hasta,
                a.SOLAXIAPD         AS          solicitud_detalle_aplicacion_desde,
                a.SOLAXIAPH         AS          solicitud_detalle_aplicacion_hasta,
                a.SOLAXICAN         AS          solicitud_detalle_cantidad_dia,
                a.SOLAXITIP         AS          solicitud_detalle_tipo,
                a.SOLAXIDIA         AS          solicitud_detalle_cantidad_diaria,
                a.SOLAXIUNI         AS          solicitud_detalle_unidad,
                a.SOLAXICOM         AS          solicitud_detalle_comentario,
                a.SOLAXIIDP         AS          solicitud_detalle_people_gate,
                a.SOLAXICON         AS          solicitud_detalle_cantidad_convertida,         
                a.SOLAXICLA         AS          solicitud_detalle_clase,
                a.SOLAXILIN         AS          solicitud_detalle_evento,
                a.SOLAXIORI         AS          solicitud_detalle_origen,
                a.SOLAXIGRU         AS          solicitud_detalle_grupo,
                a.SOLAXIUSU         AS          auditoria_usuario,
                a.SOLAXIFEC         AS          auditoria_fecha_hora,
                a.SOLAXIDIP         AS          auditoria_ip

                FROM [hum].[SOLAXI] a

                WHERE a.SOLAXISOL = ? AND a.SOLAXIEST = ?";

            try {
                $connMSSQL  = getConnectionMSSQLv2();

                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val01, $val02]);

                while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                    $detalle    = array(
                        'solicitud_detalle_codigo'                      => $rowMSSQL00['solicitud_detalle_codigo'],
                        'solicitud_detalle_cabecera'                    => $rowMSSQL00['solicitud_detalle_cabecera'],
                        'solicitud_detalle_estado'                      => trim(strtoupper($rowMSSQL00['solicitud_detalle_estado'])),
                        'solicitud_detalle_solicitud'                   => trim(strtoupper($rowMSSQL00['solicitud_detalle_solicitud'])),
                        'solicitud_detalle_empleado'                    => trim(strtoupper($rowMSSQL00['solicitud_detalle_empleado'])),
                        'solicitud_detalle_fecha_desde'                 => date("d/m/Y", strtotime($rowMSSQL00['solicitud_detalle_fecha_desde'])),
                        'solicitud_detalle_fecha_hasta'                 => date("d/m/Y", strtotime($rowMSSQL00['solicitud_detalle_fecha_hasta'])),
                        'solicitud_detalle_aplicacion_desde'            => date("d/m/Y", strtotime($rowMSSQL00['solicitud_detalle_aplicacion_desde'])),
                        'solicitud_detalle_aplicacion_hasta'            => date("d/m/Y", strtotime($rowMSSQL00['solicitud_detalle_aplicacion_hasta'])),
                        'solicitud_detalle_cantidad_dia'                => $rowMSSQL00['solicitud_detalle_cantidad_dia'],
                        'solicitud_detalle_tipo'                        => trim(strtoupper($rowMSSQL00['solicitud_detalle_tipo'])),
                        'solicitud_detalle_cantidad_diaria'             => $rowMSSQL00['solicitud_detalle_cantidad_diaria'],
                        'solicitud_detalle_unidad'                      => $rowMSSQL00['solicitud_detalle_unidad'],
                        'solicitud_detalle_comentario'                  => trim(strtoupper($rowMSSQL00['solicitud_detalle_comentario'])),
                        'solicitud_detalle_people_gate'                 => trim(strtoupper($rowMSSQL00['solicitud_detalle_people_gate'])),
                        'solicitud_detalle_cantidad_convertida'         => trim(strtoupper($rowMSSQL00['solicitud_detalle_cantidad_convertida'])),
                        'solicitud_detalle_clase'                       => trim(strtoupper($rowMSSQL00['solicitud_detalle_clase'])),
                        'solicitud_detalle_evento'                      => trim(strtoupper($rowMSSQL00['solicitud_detalle_evento'])),
                        'solicitud_detalle_origen'                      => trim(strtoupper($rowMSSQL00['solicitud_detalle_origen'])),
                        'solicitud_detalle_grupo'                       => $rowMSSQL00['solicitud_detalle_grupo'],
                        'auditoria_usuario'                             => trim(strtoupper($rowMSSQL00['auditoria_usuario'])),
                        'auditoria_fecha_hora'                          => date("d/m/Y H:i:s", strtotime($rowMSSQL00['auditoria_fecha_hora'])),
                        'auditoria_ip'                                  => trim(strtoupper($rowMSSQL00['auditoria_ip']))
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle    = array(
                        'solicitud_detalle_codigo'                      => '',
                        'solicitud_detalle_cabecera'                    => '',
                        'solicitud_detalle_estado'                      => '',
                        'solicitud_detalle_solicitud'                   => '',
                        'solicitud_detalle_empleado'                    => '',
                        'solicitud_detalle_fecha_desde'                 => '',
                        'solicitud_detalle_fecha_hasta'                 => '',
                        'solicitud_detalle_aplicacion_desde'            => '',
                        'solicitud_detalle_aplicacion_hasta'            => '',
                        'solicitud_detalle_cantidad_dia'                => '',
                        'solicitud_detalle_tipo'                        => '',
                        'solicitud_detalle_cantidad_diaria'             => '',
                        'solicitud_detalle_unidad'                      => '',
                        'solicitud_detalle_comentario'                  => '',
                        'solicitud_detalle_people_gate'                 => '',
                        'solicitud_detalle_cantidad_convertida'         => '',
                        'solicitud_detalle_clase'                       => '',
                        'solicitud_detalle_evento'                      => '',
                        'solicitud_detalle_origen'                      => '',
                        'solicitud_detalle_grupo'                       => '',
                        'auditoria_usuario'                             => '',
                        'auditoria_fecha_hora'                          => '',
                        'auditoria_ip'                                  => ''
                    );

                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                }

                $stmtMSSQL00->closeCursor();
                $stmtMSSQL00 = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v2/200/comprobante', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $sql00  = "SELECT
            a.COMFICCOD         AS          comprobante_codigo,
            a.COMFICPER         AS          comprobante_periodo,
            a.COMFICDOC         AS          comprobante_documento,
            a.COMFICADJ         AS          comprobante_adjunto,
            a.COMFICOBS         AS          comprobante_observacion,
            a.COMFICUSU         AS          auditoria_usuario,
            a.COMFICFEC         AS          auditoria_fecha_hora,
            a.COMFICDIP         AS          auditoria_ip,

            b.DOMFICCOD         AS          tipo_estado_codigo,
            b.DOMFICNOI         AS          tipo_estado_ingles,
            b.DOMFICNOC         AS          tipo_estado_castellano,
            b.DOMFICNOP         AS          tipo_estado_portugues,

            c.DOMFICCOD         AS          tipo_comprobante_codigo,
            c.DOMFICNOI         AS          tipo_comprobante_ingles,
            c.DOMFICNOC         AS          tipo_comprobante_castellano,
            c.DOMFICNOP         AS          tipo_comprobante_portugues,

            d.DOMFICCOD         AS          tipo_mes_codigo,
            d.DOMFICNOI         AS          tipo_mes_ingles,
            d.DOMFICNOC         AS          tipo_mes_castellano,
            d.DOMFICNOP         AS          tipo_mes_portugues

            FROM [hum].[COMFIC] a
            INNER JOIN [adm].[DOMFIC] b ON a.COMFICEST = b.DOMFICCOD
            INNER JOIN [adm].[DOMFIC] c ON a.COMFICTCC = c.DOMFICCOD
            INNER JOIN [adm].[DOMFIC] d ON a.COMFICTMC = d.DOMFICCOD
            
            ORDER BY a.COMFICPER ASC, a.COMFICTMC ASC";

        $sql01  = "SELECT
            a.CedulaEmpleado            AS          documento,
            a.ApellidoPaterno           AS          apellido_1,
            a.ApellidoMaterno           AS          apellido_2,
            a.PrimerNombre              AS          nombre_1,
            a.SegundoNombre             AS          nombre_2,
            a.NombreEmpleado            AS          nombre_completo,
            a.Sexo                      AS          tipo_sexo_codigo,
            a.EstadoCivil               AS          estado_civil_codigo,
            a.Email                     AS          email,
            a.FechaNacimiento           AS          fecha_nacimiento,
            a.CodigoCargo               AS          cargo_codigo,
            a.Cargo                     AS          cargo_nombre,
            a.CodigoGerencia            AS          gerencia_codigo,
            a.Gerencia                  AS          gerencia_nombre,
            a.CodigoDepto               AS          departamento_codigo,
            a.Departamento              AS          departamento_nombre,         
            a.CodCargoSuperior          AS          superior_cargo_codigo,
            a.NombreCargoSuperior       AS          superior_cargo_nombre,
            a.Manager                   AS          superior_manager_nombre,
            a.EmailManager              AS          superior_manager_email

            FROM [CSF].[dbo].[empleados_AxisONE] a

            WHERE a.CedulaEmpleado = ?";

        try {
            $connMSSQL  = getConnectionMSSQLv2();
            
            $stmtMSSQL00= $connMSSQL->prepare($sql00);
            $stmtMSSQL01= $connMSSQL->prepare($sql01);

            $stmtMSSQL00->execute();

            while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                $nroDoc     = trim(strtoupper(strtolower($rowMSSQL00['comprobante_documento'])));
                $stmtMSSQL01->execute([$nroDoc]);
                $rowMSSQL01 = $stmtMSSQL01->fetch(PDO::FETCH_ASSOC);

                $detalle    = array(
                    'comprobante_codigo'                => $rowMSSQL00['comprobante_codigo'],
                    'comprobante_periodo'               => $rowMSSQL00['comprobante_periodo'],
                    'comprobante_colaborador'           => trim(strtoupper(strtolower($rowMSSQL01['nombre_completo']))),
                    'comprobante_documento'             => trim(strtoupper(strtolower($rowMSSQL00['comprobante_documento']))),
                    'comprobante_adjunto'               => trim(strtolower($rowMSSQL00['comprobante_adjunto'])),
                    'comprobante_observacion'           => trim(strtoupper(strtolower($rowMSSQL00['comprobante_observacion']))),

                    'auditoria_usuario'                 => trim(strtoupper(strtolower($rowMSSQL01['auditoria_usuario']))),
                    'auditoria_fecha_hora'              => date("d/m/Y", strtotime($rowMSSQL01['auditoria_fecha_hora'])),
                    'auditoria_ip'                      => trim(strtoupper(strtolower($rowMSSQL01['auditoria_ip']))),

                    'tipo_estado_codigo'                => $rowMSSQL00['tipo_estado_codigo'],
                    'tipo_estado_nombre'                => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_castellano']))),

                    'tipo_comprobante_codigo'           => $rowMSSQL00['tipo_comprobante_codigo'],
                    'tipo_comprobante_nombre'           => trim(strtoupper(strtolower($rowMSSQL00['tipo_comprobante_castellano']))),

                    'tipo_mes_codigo'                   => $rowMSSQL00['tipo_mes_codigo'],
                    'tipo_mes_nombre'                   => trim(strtoupper(strtolower($rowMSSQL00['tipo_mes_castellano']))),

                    'tipo_gerencia_codigo'               => $rowMSSQL01['gerencia_codigo'],
                    'tipo_gerencia_nombre'               => trim(strtoupper(strtolower($rowMSSQL01['gerencia_nombre']))),

                    'tipo_departamento_codigo'           => $rowMSSQL01['departamento_codigo'],
                    'tipo_departamento_nombre'           => trim(strtoupper(strtolower($rowMSSQL01['departamento_nombre'])))
                );

                $result[]   = $detalle;
            }

            if (isset($result)){
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } else {
                $detalle    = array(
                    'comprobante_codigo'                => '',
                    'comprobante_periodo'               => '',
                    'comprobante_colaborador'           => '',
                    'comprobante_documento'             => '',
                    'comprobante_adjunto'               => '',
                    'comprobante_observacion'           => '',
                    'auditoria_usuario'                 => '',
                    'auditoria_fecha_hora'              => '',
                    'auditoria_ip'                      => '',
                    'tipo_estado_codigo'                => '',
                    'tipo_estado_nombre'                => '',
                    'tipo_comprobante_codigo'           => '',
                    'tipo_comprobante_nombre'           => '',
                    'tipo_mes_codigo'                   => '',
                    'tipo_mes_nombre'                   => '',
                    'tipo_gerencia_codigo'              => '',
                    'tipo_gerencia_nombre'              => '',
                    'tipo_departamento_codigo'          => '',
                    'tipo_departamento_nombre'          => ''
                );

                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }

            $stmtMSSQL00->closeCursor();
            $stmtMSSQL01->closeCursor();

            $stmtMSSQL00 = null;
            $stmtMSSQL01 = null;
        } catch (PDOException $e) {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });
    
/*MODULO WORKFLOW*/
    $app->get('/v2/300/workflow/cabecera', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $sql00  = "SELECT
            a.WRKFICCOD         AS          workflow_codigo,
            a.WRKFICORD         AS          workflow_orden,
            a.WRKFICNOM         AS          workflow_tarea,
            a.WRKFICOBS         AS          workflow_observacion,

            a.WRKFICAUS         AS          auditoria_usuario,
            a.WRKFICAFE         AS          auditoria_fecha_hora,
            a.WRKFICAIP         AS          auditoria_ip,

            b.DOMFICCOD         AS          tipo_estado_codigo,
            b.DOMFICNOI         AS          tipo_estado_ingles,
            b.DOMFICNOC         AS          tipo_estado_castellano,
            b.DOMFICNOP         AS          tipo_estado_portugues,
            b.DOMFICPAR         AS          tipo_estado_parametro,
            b.DOMFICICO         AS          tipo_estado_icono,
            b.DOMFICCSS         AS          tipo_estado_css,

            c.DOMFICCOD         AS          tipo_workflow_codigo,
            c.DOMFICNOI         AS          tipo_workflow_ingles,
            c.DOMFICNOC         AS          tipo_workflow_castellano,
            c.DOMFICNOP         AS          tipo_workflow_portugues,
            c.DOMFICPAR         AS          tipo_workflow_parametro,
            c.DOMFICICO         AS          tipo_workflow_icono,
            c.DOMFICCSS         AS          tipo_workflow_css,

            d.U_CODIGO          AS          tipo_cargo_codigo,
            d.CODE              AS          tipo_cargo_codigo_referencia,
            d.NAME              AS          tipo_cargo_codigo_nombre,
            d.U_NOMBRE          AS          tipo_cargo_nombre

            FROM [wrk].[WRKFIC] a
            INNER JOIN [adm].[DOMFIC] b ON a.WRKFICEST = b.DOMFICCOD
            INNER JOIN [adm].[DOMFIC] c ON a.WRKFICTWC = c.DOMFICCOD
            INNER JOIN [CSF].[dbo].[@A1A_TICA] d ON a.WRKFICTCC = d.U_CODIGO
            
            ORDER BY a.WRKFICORD";

        try {
            $connMSSQL  = getConnectionMSSQLv2();
            $stmtMSSQL00= $connMSSQL->prepare($sql00);
            $stmtMSSQL00->execute();

            while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                $detalle    = array(
                    'workflow_codigo'                   => $rowMSSQL00['workflow_codigo'],
                    'workflow_orden'                    => $rowMSSQL00['workflow_orden'],
                    'workflow_tarea'                    => trim(strtoupper(strtolower($rowMSSQL00['workflow_tarea']))),
                    'workflow_observacion'              => trim(strtoupper(strtolower($rowMSSQL00['workflow_observacion']))),

                    'auditoria_usuario'                 => trim(strtoupper(strtolower($rowMSSQL00['auditoria_usuario']))),
                    'auditoria_fecha_hora'              => date("d/m/Y", strtotime($rowMSSQL00['auditoria_fecha_hora'])),
                    'auditoria_ip'                      => trim(strtoupper(strtolower($rowMSSQL00['auditoria_ip']))),

                    'tipo_estado_codigo'                => $rowMSSQL00['tipo_estado_codigo'],
                    'tipo_estado_ingles'                => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_ingles']))),
                    'tipo_estado_castellano'            => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_castellano']))),
                    'tipo_estado_portugues'             => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_portugues']))),
                    'tipo_estado_parametro'             => $rowMSSQL00['tipo_estado_parametro'],
                    'tipo_estado_icono'                 => trim(strtolower($rowMSSQL00['tipo_estado_icono'])),
                    'tipo_estado_css'                   => trim(strtolower($rowMSSQL00['tipo_estado_css'])),

                    'tipo_workflow_codigo'              => $rowMSSQL00['tipo_workflow_codigo'],
                    'tipo_workflow_ingles'              => trim(strtoupper(strtolower($rowMSSQL00['tipo_workflow_ingles']))),
                    'tipo_workflow_castellano'          => trim(strtoupper(strtolower($rowMSSQL00['tipo_workflow_castellano']))),
                    'tipo_workflow_portugues'           => trim(strtoupper(strtolower($rowMSSQL00['tipo_workflow_portugues']))),
                    'tipo_workflow_parametro'           => $rowMSSQL00['tipo_workflow_parametro'],
                    'tipo_workflow_icono'               => trim(strtolower($rowMSSQL00['tipo_workflow_icono'])),
                    'tipo_workflow_css'                 => trim(strtolower($rowMSSQL00['tipo_workflow_css'])),

                    'tipo_cargo_codigo'                 => $rowMSSQL00['tipo_cargo_codigo'],
                    'tipo_cargo_codigo_nombre'          => trim(strtoupper(strtolower($rowMSSQL00['tipo_cargo_codigo_nombre']))),
                    'tipo_cargo_codigo_referencia'      => trim(strtoupper(strtolower($rowMSSQL00['tipo_cargo_codigo_referencia']))),
                    'tipo_cargo_nombre'                 => trim(strtoupper(strtolower($rowMSSQL00['tipo_cargo_nombre'])))
                );

                $result[]   = $detalle;
            }

            if (isset($result)){
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } else {
                $detalle    = array(
                    'workflow_codigo'                   => '',
                    'workflow_orden'                    => '',
                    'workflow_tarea'                    => '',
                    'workflow_observacion'              => '',

                    'auditoria_usuario'                 => '',
                    'auditoria_fecha_hora'              => '',
                    'auditoria_ip'                      => '',

                    'tipo_estado_codigo'                => '',
                    'tipo_estado_ingles'                => '',
                    'tipo_estado_castellano'            => '',
                    'tipo_estado_portugues'             => '',
                    'tipo_estado_parametro'             => '',
                    'tipo_estado_icono'                 => '',
                    'tipo_estado_css'                   => '',

                    'tipo_workflow_codigo'              => '',
                    'tipo_workflow_ingles'              => '',
                    'tipo_workflow_castellano'          => '',
                    'tipo_workflow_portugues'           => '',
                    'tipo_workflow_parametro'           => '',
                    'tipo_workflow_icono'               => '',
                    'tipo_workflow_css'                 => '',

                    'tipo_cargo_codigo'                 => '',
                    'tipo_cargo_codigo_nombre'          => '',
                    'tipo_cargo_codigo_referencia'      => '',
                    'tipo_cargo_nombre'                 => ''
                );

                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }

            $stmtMSSQL00->closeCursor();
            $stmtMSSQL00 = null;
        } catch (PDOException $e) {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v2/300/workflow/cabecera/codigo/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01  = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
                a.WRKFICCOD         AS          workflow_codigo,
                a.WRKFICORD         AS          workflow_orden,
                a.WRKFICNOM         AS          workflow_tarea,
                a.WRKFICOBS         AS          workflow_observacion,

                a.WRKFICAUS         AS          auditoria_usuario,
                a.WRKFICAFE         AS          auditoria_fecha_hora,
                a.WRKFICAIP         AS          auditoria_ip,

                b.DOMFICCOD         AS          tipo_estado_codigo,
                b.DOMFICNOI         AS          tipo_estado_ingles,
                b.DOMFICNOC         AS          tipo_estado_castellano,
                b.DOMFICNOP         AS          tipo_estado_portugues,
                b.DOMFICPAR         AS          tipo_estado_parametro,
                b.DOMFICICO         AS          tipo_estado_icono,
                b.DOMFICCSS         AS          tipo_estado_css,

                c.DOMFICCOD         AS          tipo_workflow_codigo,
                c.DOMFICNOI         AS          tipo_workflow_ingles,
                c.DOMFICNOC         AS          tipo_workflow_castellano,
                c.DOMFICNOP         AS          tipo_workflow_portugues,
                c.DOMFICPAR         AS          tipo_workflow_parametro,
                c.DOMFICICO         AS          tipo_workflow_icono,
                c.DOMFICCSS         AS          tipo_workflow_css,

                d.U_CODIGO          AS          tipo_cargo_codigo,
                d.CODE              AS          tipo_cargo_codigo_referencia,
                d.NAME              AS          tipo_cargo_codigo_nombre,
                d.U_NOMBRE          AS          tipo_cargo_nombre

                FROM [wrk].[WRKFIC] a
                INNER JOIN [adm].[DOMFIC] b ON a.WRKFICEST = b.DOMFICCOD
                INNER JOIN [adm].[DOMFIC] c ON a.WRKFICTWC = c.DOMFICCOD
                INNER JOIN [CSF].[dbo].[@A1A_TICA] d ON a.WRKFICTCC = d.U_CODIGO

                WHERE a.WRKFICCOD = ?
                
                ORDER BY a.WRKFICORD";

            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val01]);

                while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                    $detalle    = array(
                        'workflow_codigo'                   => $rowMSSQL00['workflow_codigo'],
                        'workflow_orden'                    => $rowMSSQL00['workflow_orden'],
                        'workflow_tarea'                    => trim(strtoupper(strtolower($rowMSSQL00['workflow_tarea']))),
                        'workflow_observacion'              => trim(strtoupper(strtolower($rowMSSQL00['workflow_observacion']))),

                        'auditoria_usuario'                 => trim(strtoupper(strtolower($rowMSSQL00['auditoria_usuario']))),
                        'auditoria_fecha_hora'              => date("d/m/Y", strtotime($rowMSSQL00['auditoria_fecha_hora'])),
                        'auditoria_ip'                      => trim(strtoupper(strtolower($rowMSSQL00['auditoria_ip']))),

                        'tipo_estado_codigo'                => $rowMSSQL00['tipo_estado_codigo'],
                        'tipo_estado_ingles'                => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_ingles']))),
                        'tipo_estado_castellano'            => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_castellano']))),
                        'tipo_estado_portugues'             => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_portugues']))),
                        'tipo_estado_parametro'             => $rowMSSQL00['tipo_estado_parametro'],
                        'tipo_estado_icono'                 => trim(strtolower($rowMSSQL00['tipo_estado_icono'])),
                        'tipo_estado_css'                   => trim(strtolower($rowMSSQL00['tipo_estado_css'])),
    
                        'tipo_workflow_codigo'              => $rowMSSQL00['tipo_workflow_codigo'],
                        'tipo_workflow_ingles'              => trim(strtoupper(strtolower($rowMSSQL00['tipo_workflow_ingles']))),
                        'tipo_workflow_castellano'          => trim(strtoupper(strtolower($rowMSSQL00['tipo_workflow_castellano']))),
                        'tipo_workflow_portugues'           => trim(strtoupper(strtolower($rowMSSQL00['tipo_workflow_portugues']))),
                        'tipo_workflow_parametro'           => $rowMSSQL00['tipo_workflow_parametro'],
                        'tipo_workflow_icono'               => trim(strtolower($rowMSSQL00['tipo_workflow_icono'])),
                        'tipo_workflow_css'                 => trim(strtolower($rowMSSQL00['tipo_workflow_css'])),

                        'tipo_cargo_codigo'                 => $rowMSSQL00['tipo_cargo_codigo'],
                        'tipo_cargo_codigo_nombre'          => trim(strtoupper(strtolower($rowMSSQL00['tipo_cargo_codigo_nombre']))),
                        'tipo_cargo_codigo_referencia'      => trim(strtoupper(strtolower($rowMSSQL00['tipo_cargo_codigo_referencia']))),
                        'tipo_cargo_nombre'                 => trim(strtoupper(strtolower($rowMSSQL00['tipo_cargo_nombre'])))
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle    = array(
                        'workflow_codigo'                   => '',
                        'workflow_orden'                    => '',
                        'workflow_tarea'                    => '',
                        'workflow_observacion'              => '',

                        'auditoria_usuario'                 => '',
                        'auditoria_fecha_hora'              => '',
                        'auditoria_ip'                      => '',

                        'tipo_estado_codigo'                => '',
                        'tipo_estado_ingles'                => '',
                        'tipo_estado_castellano'            => '',
                        'tipo_estado_portugues'             => '',
                        'tipo_estado_parametro'             => '',
                        'tipo_estado_icono'                 => '',
                        'tipo_estado_css'                   => '',
    
                        'tipo_workflow_codigo'              => '',
                        'tipo_workflow_ingles'              => '',
                        'tipo_workflow_castellano'          => '',
                        'tipo_workflow_portugues'           => '',
                        'tipo_workflow_parametro'           => '',
                        'tipo_workflow_icono'               => '',
                        'tipo_workflow_css'                 => '',

                        'tipo_cargo_codigo'                 => '',
                        'tipo_cargo_codigo_nombre'          => '',
                        'tipo_cargo_codigo_referencia'      => '',
                        'tipo_cargo_nombre'                 => ''
                    );

                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                }

                $stmtMSSQL00->closeCursor();
                $stmtMSSQL00 = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        }  else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v2/300/workflow/cabecera/cargo/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01  = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
                a.WRKFICCOD         AS          workflow_codigo,
                a.WRKFICORD         AS          workflow_orden,
                a.WRKFICNOM         AS          workflow_tarea,
                a.WRKFICOBS         AS          workflow_observacion,

                a.WRKFICAUS         AS          auditoria_usuario,
                a.WRKFICAFE         AS          auditoria_fecha_hora,
                a.WRKFICAIP         AS          auditoria_ip,

                b.DOMFICCOD         AS          tipo_estado_codigo,
                b.DOMFICNOI         AS          tipo_estado_ingles,
                b.DOMFICNOC         AS          tipo_estado_castellano,
                b.DOMFICNOP         AS          tipo_estado_portugues,
                b.DOMFICPAR         AS          tipo_estado_parametro,
                b.DOMFICICO         AS          tipo_estado_icono,
                b.DOMFICCSS         AS          tipo_estado_css,

                c.DOMFICCOD         AS          tipo_workflow_codigo,
                c.DOMFICNOI         AS          tipo_workflow_ingles,
                c.DOMFICNOC         AS          tipo_workflow_castellano,
                c.DOMFICNOP         AS          tipo_workflow_portugues,
                c.DOMFICPAR         AS          tipo_workflow_parametro,
                c.DOMFICICO         AS          tipo_workflow_icono,
                c.DOMFICCSS         AS          tipo_workflow_css,

                d.U_CODIGO          AS          tipo_cargo_codigo,
                d.CODE              AS          tipo_cargo_codigo_referencia,
                d.NAME              AS          tipo_cargo_codigo_nombre,
                d.U_NOMBRE          AS          tipo_cargo_nombre

                FROM [wrk].[WRKFIC] a
                INNER JOIN [adm].[DOMFIC] b ON a.WRKFICEST = b.DOMFICCOD
                INNER JOIN [adm].[DOMFIC] c ON a.WRKFICTWC = c.DOMFICCOD
                INNER JOIN [CSF].[dbo].[@A1A_TICA] d ON a.WRKFICTCC = d.U_CODIGO

                WHERE a.WRKFICTCC = ?
                
                ORDER BY a.WRKFICORD";

            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val01]);

                while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                    $detalle    = array(
                        'workflow_codigo'                   => $rowMSSQL00['workflow_codigo'],
                        'workflow_orden'                    => $rowMSSQL00['workflow_orden'],
                        'workflow_tarea'                    => trim(strtoupper(strtolower($rowMSSQL00['workflow_tarea']))),
                        'workflow_observacion'              => trim(strtoupper(strtolower($rowMSSQL00['workflow_observacion']))),

                        'auditoria_usuario'                 => trim(strtoupper(strtolower($rowMSSQL00['auditoria_usuario']))),
                        'auditoria_fecha_hora'              => date("d/m/Y", strtotime($rowMSSQL00['auditoria_fecha_hora'])),
                        'auditoria_ip'                      => trim(strtoupper(strtolower($rowMSSQL00['auditoria_ip']))),

                        'tipo_estado_codigo'                => $rowMSSQL00['tipo_estado_codigo'],
                        'tipo_estado_ingles'                => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_ingles']))),
                        'tipo_estado_castellano'            => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_castellano']))),
                        'tipo_estado_portugues'             => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_portugues']))),
                        'tipo_estado_parametro'             => $rowMSSQL00['tipo_estado_parametro'],
                        'tipo_estado_icono'                 => trim(strtolower($rowMSSQL00['tipo_estado_icono'])),
                        'tipo_estado_css'                   => trim(strtolower($rowMSSQL00['tipo_estado_css'])),
    
                        'tipo_workflow_codigo'              => $rowMSSQL00['tipo_workflow_codigo'],
                        'tipo_workflow_ingles'              => trim(strtoupper(strtolower($rowMSSQL00['tipo_workflow_ingles']))),
                        'tipo_workflow_castellano'          => trim(strtoupper(strtolower($rowMSSQL00['tipo_workflow_castellano']))),
                        'tipo_workflow_portugues'           => trim(strtoupper(strtolower($rowMSSQL00['tipo_workflow_portugues']))),
                        'tipo_workflow_parametro'           => $rowMSSQL00['tipo_workflow_parametro'],
                        'tipo_workflow_icono'               => trim(strtolower($rowMSSQL00['tipo_workflow_icono'])),
                        'tipo_workflow_css'                 => trim(strtolower($rowMSSQL00['tipo_workflow_css'])),

                        'tipo_cargo_codigo'                 => $rowMSSQL00['tipo_cargo_codigo'],
                        'tipo_cargo_codigo_nombre'          => trim(strtoupper(strtolower($rowMSSQL00['tipo_cargo_codigo_nombre']))),
                        'tipo_cargo_codigo_referencia'      => trim(strtoupper(strtolower($rowMSSQL00['tipo_cargo_codigo_referencia']))),
                        'tipo_cargo_nombre'                 => trim(strtoupper(strtolower($rowMSSQL00['tipo_cargo_nombre'])))
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle    = array(
                        'workflow_codigo'                   => '',
                        'workflow_orden'                    => '',
                        'workflow_tarea'                    => '',
                        'workflow_observacion'              => '',

                        'auditoria_usuario'                 => '',
                        'auditoria_fecha_hora'              => '',
                        'auditoria_ip'                      => '',

                        'tipo_estado_codigo'                => '',
                        'tipo_estado_ingles'                => '',
                        'tipo_estado_castellano'            => '',
                        'tipo_estado_portugues'             => '',
                        'tipo_estado_parametro'             => '',
                        'tipo_estado_icono'                 => '',
                        'tipo_estado_css'                   => '',
    
                        'tipo_workflow_codigo'              => '',
                        'tipo_workflow_ingles'              => '',
                        'tipo_workflow_castellano'          => '',
                        'tipo_workflow_portugues'           => '',
                        'tipo_workflow_parametro'           => '',
                        'tipo_workflow_icono'               => '',
                        'tipo_workflow_css'                 => '',
                        
                        'tipo_cargo_codigo'                 => '',
                        'tipo_cargo_codigo_nombre'          => '',
                        'tipo_cargo_codigo_referencia'      => '',
                        'tipo_cargo_nombre'                 => ''
                    );

                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                }

                $stmtMSSQL00->closeCursor();
                $stmtMSSQL00 = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        }  else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v2/300/workflow/detalle', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $sql00  = "SELECT
            a.WRKDETCOD         AS          workflow_detalle_codigo,
            a.WRKDETORD         AS          workflow_detalle_orden,
            a.WRKDETNOM         AS          workflow_detalle_tarea,
            a.WRKDETHOR         AS          workflow_detalle_hora,
            a.WRKDETNOT         AS          workflow_detalle_notifica,
            a.WRKDETOBS         AS          workflow_detalle_observacion,

            a.WRKDETAUS         AS          auditoria_usuario,
            a.WRKDETAFE         AS          auditoria_fecha_hora,
            a.WRKDETAIP         AS          auditoria_ip,

            b.U_CODIGO          AS          tipo_cargo_codigo,
            b.NAME              AS          tipo_cargo_codigo_nombre,
            b.CODE              AS          tipo_cargo_codigo_referencia,
            b.U_NOMBRE          AS          tipo_cargo_nombre,

            c.DOMFICCOD         AS          estado_anterior_codigo,
            c.DOMFICNOI         AS          estado_anterior_ingles,
            c.DOMFICNOC         AS          estado_anterior_castellano,
            c.DOMFICNOP         AS          estado_anterior_portugues,
            c.DOMFICPAR         AS          estado_anterior_parametro,
            c.DOMFICICO         AS          estado_anterior_icono,
            c.DOMFICCSS         AS          estado_anterior_css,

            d.DOMFICCOD         AS          estado_actual_codigo,
            d.DOMFICNOI         AS          estado_actual_ingles,
            d.DOMFICNOC         AS          estado_actual_castellano,
            d.DOMFICNOP         AS          estado_actual_portugues,
            d.DOMFICPAR         AS          estado_actual_parametro,
            d.DOMFICICO         AS          estado_actual_icono,
            d.DOMFICCSS         AS          estado_actual_css,

            e.DOMFICCOD         AS          tipo_prioridad_codigo,
            e.DOMFICNOI         AS          tipo_prioridad_ingles,
            e.DOMFICNOC         AS          tipo_prioridad_castellano,
            e.DOMFICNOP         AS          tipo_prioridad_portugues,
            e.DOMFICPAR         AS          tipo_prioridad_parametro,
            e.DOMFICICO         AS          tipo_prioridad_icono,
            e.DOMFICCSS         AS          tipo_prioridad_css,

            f.WRKFICCOD         AS          workflow_codigo,
            f.WRKFICORD         AS          workflow_orden,
            f.WRKFICNOM         AS          workflow_tarea,
            f.WRKFICOBS         AS          workflow_observacion

            FROM [wrk].[WRKDET] a
            INNER JOIN [CSF].[dbo].[@A1A_TICA] b ON a.WRKDETTCC = b.U_CODIGO
            INNER JOIN [adm].[DOMFIC] c ON a.WRKDETEAC = c.DOMFICCOD
            INNER JOIN [adm].[DOMFIC] d ON a.WRKDETECC = d.DOMFICCOD
            INNER JOIN [adm].[DOMFIC] e ON a.WRKDETTPC = e.DOMFICCOD
            INNER JOIN [wrk].[WRKFIC] f ON a.WRKDETWFC = f.WRKFICCOD
            
            ORDER BY a.WRKDETORD";

        try {
            $connMSSQL  = getConnectionMSSQLv2();
            $stmtMSSQL00= $connMSSQL->prepare($sql00);
            $stmtMSSQL00->execute();

            while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                $detalle    = array(
                    'workflow_detalle_codigo'           => $rowMSSQL00['workflow_detalle_codigo'],
                    'workflow_detalle_orden'            => $rowMSSQL00['workflow_detalle_orden'],
                    'workflow_detalle_tarea'            => trim(strtoupper(strtolower($rowMSSQL00['workflow_detalle_tarea']))),
                    'workflow_detalle_hora'             => $rowMSSQL00['workflow_detalle_hora'],
                    'workflow_detalle_notifica'         => trim(strtoupper(strtolower($rowMSSQL00['workflow_detalle_notifica']))),
                    'workflow_detalle_observacion'      => trim(strtoupper(strtolower($rowMSSQL00['workflow_detalle_observacion']))),

                    'auditoria_usuario'                 => trim(strtoupper(strtolower($rowMSSQL00['auditoria_usuario']))),
                    'auditoria_fecha_hora'              => date("d/m/Y", strtotime($rowMSSQL00['auditoria_fecha_hora'])),
                    'auditoria_ip'                      => trim(strtoupper(strtolower($rowMSSQL00['auditoria_ip']))),

                    'tipo_cargo_codigo'                 => $rowMSSQL00['tipo_cargo_codigo'],
                    'tipo_cargo_codigo_nombre'          => trim(strtoupper(strtolower($rowMSSQL00['tipo_cargo_codigo_nombre']))),
                    'tipo_cargo_codigo_referencia'      => trim(strtoupper(strtolower($rowMSSQL00['tipo_cargo_codigo_referencia']))),
                    'tipo_cargo_nombre'                 => trim(strtoupper(strtolower($rowMSSQL00['tipo_cargo_nombre']))),

                    'estado_anterior_codigo'            => $rowMSSQL00['estado_anterior_codigo'],
                    'estado_anterior_ingles'            => trim(strtoupper(strtolower($rowMSSQL00['estado_anterior_ingles']))),
                    'estado_anterior_castellano'        => trim(strtoupper(strtolower($rowMSSQL00['estado_anterior_castellano']))),
                    'estado_anterior_portugues'         => trim(strtoupper(strtolower($rowMSSQL00['estado_anterior_portugues']))),
                    'estado_anterior_parametro'         => $rowMSSQL00['estado_anterior_parametro'],
                    'estado_anterior_icono'             => trim(strtolower($rowMSSQL00['estado_anterior_icono'])),
                    'estado_anterior_css'               => trim(strtolower($rowMSSQL00['estado_anterior_css'])),

                    'estado_actual_codigo'              => $rowMSSQL00['estado_actual_codigo'],
                    'estado_actual_ingles'              => trim(strtoupper(strtolower($rowMSSQL00['estado_actual_ingles']))),
                    'estado_actual_castellano'          => trim(strtoupper(strtolower($rowMSSQL00['estado_actual_castellano']))),
                    'estado_actual_portugues'           => trim(strtoupper(strtolower($rowMSSQL00['estado_actual_portugues']))),
                    'estado_actual_parametro'           => $rowMSSQL00['estado_actual_parametro'],
                    'estado_actual_icono'               => trim(strtolower($rowMSSQL00['estado_actual_icono'])),
                    'estado_actual_css'                 => trim(strtolower($rowMSSQL00['estado_actual_css'])),

                    'tipo_prioridad_codigo'             => $rowMSSQL00['tipo_prioridad_codigo'],
                    'tipo_prioridad_ingles'             => trim(strtoupper(strtolower($rowMSSQL00['tipo_prioridad_ingles']))),
                    'tipo_prioridad_castellano'         => trim(strtoupper(strtolower($rowMSSQL00['tipo_prioridad_castellano']))),
                    'tipo_prioridad_portugues'          => trim(strtoupper(strtolower($rowMSSQL00['tipo_prioridad_portugues']))),
                    'tipo_prioridad_parametro'          => $rowMSSQL00['tipo_prioridad_parametro'],
                    'tipo_prioridad_icono'              => trim(strtolower($rowMSSQL00['tipo_prioridad_icono'])),
                    'tipo_prioridad_css'                => trim(strtolower($rowMSSQL00['tipo_prioridad_css'])),

                    'workflow_codigo'                   => $rowMSSQL00['workflow_codigo'],
                    'workflow_orden'                    => $rowMSSQL00['workflow_orden'],
                    'workflow_tarea'                    => trim(strtoupper(strtolower($rowMSSQL00['workflow_tarea']))),
                    'workflow_observacion'              => trim(strtoupper(strtolower($rowMSSQL00['workflow_observacion'])))
                );

                $result[]   = $detalle;
            }

            if (isset($result)){
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } else {
                $detalle    = array(
                    'workflow_detalle_codigo'           => '',
                    'workflow_detalle_orden'            => '',
                    'workflow_detalle_tarea'            => '',
                    'workflow_detalle_hora'             => '',
                    'workflow_detalle_notifica'         => '',
                    'workflow_detalle_observacion'      => '',

                    'auditoria_usuario'                 => '',
                    'auditoria_fecha_hora'              => '',
                    'auditoria_ip'                      => '',

                    'tipo_cargo_codigo'                 => '',
                    'tipo_cargo_codigo_nombre'          => '',
                    'tipo_cargo_codigo_referencia'      => '',
                    'tipo_cargo_nombre'                 => '',

                    'estado_anterior_codigo'            => '',
                    'estado_anterior_ingles'            => '',
                    'estado_anterior_castellano'        => '',
                    'estado_anterior_portugues'         => '',
                    'estado_anterior_parametro'         => '',
                    'estado_anterior_icono'             => '',
                    'estado_anterior_css'               => '',

                    'estado_actual_codigo'              => '',
                    'estado_actual_ingles'              => '',
                    'estado_actual_castellano'          => '',
                    'estado_actual_portugues'           => '',
                    'estado_actual_parametro'           => '',
                    'estado_actual_icono'               => '',
                    'estado_actual_css'                 => '',

                    'tipo_prioridad_codigo'             => '',
                    'tipo_prioridad_ingles'             => '',
                    'tipo_prioridad_castellano'         => '',
                    'tipo_prioridad_portugues'          => '',
                    'tipo_prioridad_parametro'          => '',
                    'tipo_prioridad_icono'              => '',
                    'tipo_prioridad_css'                => '',

                    'workflow_codigo'                   => '',
                    'workflow_orden'                    => '',
                    'workflow_tarea'                    => '',
                    'workflow_observacion'              => ''
                );

                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }

            $stmtMSSQL00->closeCursor();
            $stmtMSSQL00 = null;
        } catch (PDOException $e) {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v2/300/workflow/detalle/codigo/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val01  = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
                a.WRKDETCOD         AS          workflow_detalle_codigo,
                a.WRKDETORD         AS          workflow_detalle_orden,
                a.WRKDETNOM         AS          workflow_detalle_tarea,
                a.WRKDETHOR         AS          workflow_detalle_hora,
                a.WRKDETNOT         AS          workflow_detalle_notifica,
                a.WRKDETOBS         AS          workflow_detalle_observacion,

                a.WRKDETAUS         AS          auditoria_usuario,
                a.WRKDETAFE         AS          auditoria_fecha_hora,
                a.WRKDETAIP         AS          auditoria_ip,

                b.U_CODIGO          AS          tipo_cargo_codigo,
                b.NAME              AS          tipo_cargo_codigo_nombre,
                b.CODE              AS          tipo_cargo_codigo_referencia,
                b.U_NOMBRE          AS          tipo_cargo_nombre,

                c.DOMFICCOD         AS          estado_anterior_codigo,
                c.DOMFICNOI         AS          estado_anterior_ingles,
                c.DOMFICNOC         AS          estado_anterior_castellano,
                c.DOMFICNOP         AS          estado_anterior_portugues,
                c.DOMFICPAR         AS          estado_anterior_parametro,
                c.DOMFICICO         AS          estado_anterior_icono,
                c.DOMFICCSS         AS          estado_anterior_css,

                d.DOMFICCOD         AS          estado_actual_codigo,
                d.DOMFICNOI         AS          estado_actual_ingles,
                d.DOMFICNOC         AS          estado_actual_castellano,
                d.DOMFICNOP         AS          estado_actual_portugues,
                d.DOMFICPAR         AS          estado_actual_parametro,
                d.DOMFICICO         AS          estado_actual_icono,
                d.DOMFICCSS         AS          estado_actual_css,

                e.DOMFICCOD         AS          tipo_prioridad_codigo,
                e.DOMFICNOI         AS          tipo_prioridad_ingles,
                e.DOMFICNOC         AS          tipo_prioridad_castellano,
                e.DOMFICNOP         AS          tipo_prioridad_portugues,
                e.DOMFICPAR         AS          tipo_prioridad_parametro,
                e.DOMFICICO         AS          tipo_prioridad_icono,
                e.DOMFICCSS         AS          tipo_prioridad_css,

                f.WRKFICCOD         AS          workflow_codigo,
                f.WRKFICORD         AS          workflow_orden,
                f.WRKFICNOM         AS          workflow_tarea,
                f.WRKFICOBS         AS          workflow_observacion

                FROM [wrk].[WRKDET] a
                INNER JOIN [CSF].[dbo].[@A1A_TICA] b ON a.WRKDETTCC = b.U_CODIGO
                INNER JOIN [adm].[DOMFIC] c ON a.WRKDETEAC = c.DOMFICCOD
                INNER JOIN [adm].[DOMFIC] d ON a.WRKDETECC = d.DOMFICCOD
                INNER JOIN [adm].[DOMFIC] e ON a.WRKDETTPC = e.DOMFICCOD
                INNER JOIN [wrk].[WRKFIC] f ON a.WRKDETWFC = f.WRKFICCOD

                WHERE a.WRKDETCOD = ?
                
                ORDER BY a.WRKDETORD";

            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val01]);

                while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                    $detalle    = array(
                        'workflow_detalle_codigo'           => $rowMSSQL00['workflow_detalle_codigo'],
                        'workflow_detalle_orden'            => $rowMSSQL00['workflow_detalle_orden'],
                        'workflow_detalle_tarea'            => trim(strtoupper(strtolower($rowMSSQL00['workflow_detalle_tarea']))),
                        'workflow_detalle_hora'             => $rowMSSQL00['workflow_detalle_hora'],
                        'workflow_detalle_notifica'         => trim(strtoupper(strtolower($rowMSSQL00['workflow_detalle_notifica']))),
                        'workflow_detalle_observacion'      => trim(strtoupper(strtolower($rowMSSQL00['workflow_detalle_observacion']))),
    
                        'auditoria_usuario'                 => trim(strtoupper(strtolower($rowMSSQL00['auditoria_usuario']))),
                        'auditoria_fecha_hora'              => date("d/m/Y", strtotime($rowMSSQL00['auditoria_fecha_hora'])),
                        'auditoria_ip'                      => trim(strtoupper(strtolower($rowMSSQL00['auditoria_ip']))),
    
                        'tipo_cargo_codigo'                 => $rowMSSQL00['tipo_cargo_codigo'],
                        'tipo_cargo_codigo_nombre'          => trim(strtoupper(strtolower($rowMSSQL00['tipo_cargo_codigo_nombre']))),
                        'tipo_cargo_codigo_referencia'      => trim(strtoupper(strtolower($rowMSSQL00['tipo_cargo_codigo_referencia']))),
                        'tipo_cargo_nombre'                 => trim(strtoupper(strtolower($rowMSSQL00['tipo_cargo_nombre']))),
    
                        'estado_anterior_codigo'            => $rowMSSQL00['estado_anterior_codigo'],
                        'estado_anterior_ingles'            => trim(strtoupper(strtolower($rowMSSQL00['estado_anterior_ingles']))),
                        'estado_anterior_castellano'        => trim(strtoupper(strtolower($rowMSSQL00['estado_anterior_castellano']))),
                        'estado_anterior_portugues'         => trim(strtoupper(strtolower($rowMSSQL00['estado_anterior_portugues']))),
                        'estado_anterior_parametro'         => $rowMSSQL00['estado_anterior_parametro'],
                        'estado_anterior_icono'             => trim(strtolower($rowMSSQL00['estado_anterior_icono'])),
                        'estado_anterior_css'               => trim(strtolower($rowMSSQL00['estado_anterior_css'])),
    
                        'estado_actual_codigo'              => $rowMSSQL00['estado_actual_codigo'],
                        'estado_actual_ingles'              => trim(strtoupper(strtolower($rowMSSQL00['estado_actual_ingles']))),
                        'estado_actual_castellano'          => trim(strtoupper(strtolower($rowMSSQL00['estado_actual_castellano']))),
                        'estado_actual_portugues'           => trim(strtoupper(strtolower($rowMSSQL00['estado_actual_portugues']))),
                        'estado_actual_parametro'           => $rowMSSQL00['estado_actual_parametro'],
                        'estado_actual_icono'               => trim(strtolower($rowMSSQL00['estado_actual_icono'])),
                        'estado_actual_css'                 => trim(strtolower($rowMSSQL00['estado_actual_css'])),
    
                        'tipo_prioridad_codigo'             => $rowMSSQL00['tipo_prioridad_codigo'],
                        'tipo_prioridad_ingles'             => trim(strtoupper(strtolower($rowMSSQL00['tipo_prioridad_ingles']))),
                        'tipo_prioridad_castellano'         => trim(strtoupper(strtolower($rowMSSQL00['tipo_prioridad_castellano']))),
                        'tipo_prioridad_portugues'          => trim(strtoupper(strtolower($rowMSSQL00['tipo_prioridad_portugues']))),
                        'tipo_prioridad_parametro'          => $rowMSSQL00['tipo_prioridad_parametro'],
                        'tipo_prioridad_icono'              => trim(strtolower($rowMSSQL00['tipo_prioridad_icono'])),
                        'tipo_prioridad_css'                => trim(strtolower($rowMSSQL00['tipo_prioridad_css'])),
    
                        'workflow_codigo'                   => $rowMSSQL00['workflow_codigo'],
                        'workflow_orden'                    => $rowMSSQL00['workflow_orden'],
                        'workflow_tarea'                    => trim(strtoupper(strtolower($rowMSSQL00['workflow_tarea']))),
                        'workflow_observacion'              => trim(strtoupper(strtolower($rowMSSQL00['workflow_observacion'])))
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle    = array(
                        'workflow_detalle_codigo'           => '',
                        'workflow_detalle_orden'            => '',
                        'workflow_detalle_tarea'            => '',
                        'workflow_detalle_hora'             => '',
                        'workflow_detalle_notifica'         => '',
                        'workflow_detalle_observacion'      => '',
    
                        'auditoria_usuario'                 => '',
                        'auditoria_fecha_hora'              => '',
                        'auditoria_ip'                      => '',
    
                        'tipo_cargo_codigo'                 => '',
                        'tipo_cargo_codigo_nombre'          => '',
                        'tipo_cargo_codigo_referencia'      => '',
                        'tipo_cargo_nombre'                 => '',
    
                        'estado_anterior_codigo'            => '',
                        'estado_anterior_ingles'            => '',
                        'estado_anterior_castellano'        => '',
                        'estado_anterior_portugues'         => '',
                        'estado_anterior_parametro'         => '',
                        'estado_anterior_icono'             => '',
                        'estado_anterior_css'               => '',
    
                        'estado_actual_codigo'              => '',
                        'estado_actual_ingles'              => '',
                        'estado_actual_castellano'          => '',
                        'estado_actual_portugues'           => '',
                        'estado_actual_parametro'           => '',
                        'estado_actual_icono'               => '',
                        'estado_actual_css'                 => '',
    
                        'tipo_prioridad_codigo'             => '',
                        'tipo_prioridad_ingles'             => '',
                        'tipo_prioridad_castellano'         => '',
                        'tipo_prioridad_portugues'          => '',
                        'tipo_prioridad_parametro'          => '',
                        'tipo_prioridad_icono'              => '',
                        'tipo_prioridad_css'                => '',
    
                        'workflow_codigo'                   => '',
                        'workflow_orden'                    => '',
                        'workflow_tarea'                    => '',
                        'workflow_observacion'              => ''
                    );

                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                }

                $stmtMSSQL00->closeCursor();
                $stmtMSSQL00 = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        }  else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v2/300/workflow/detalle/cabecera/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val01  = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
                a.WRKDETCOD         AS          workflow_detalle_codigo,
                a.WRKDETORD         AS          workflow_detalle_orden,
                a.WRKDETNOM         AS          workflow_detalle_tarea,
                a.WRKDETHOR         AS          workflow_detalle_hora,
                a.WRKDETNOT         AS          workflow_detalle_notifica,
                a.WRKDETOBS         AS          workflow_detalle_observacion,

                a.WRKDETAUS         AS          auditoria_usuario,
                a.WRKDETAFE         AS          auditoria_fecha_hora,
                a.WRKDETAIP         AS          auditoria_ip,

                b.U_CODIGO          AS          tipo_cargo_codigo,
                b.NAME              AS          tipo_cargo_codigo_nombre,
                b.CODE              AS          tipo_cargo_codigo_referencia,
                b.U_NOMBRE          AS          tipo_cargo_nombre,

                c.DOMFICCOD         AS          estado_anterior_codigo,
                c.DOMFICNOI         AS          estado_anterior_ingles,
                c.DOMFICNOC         AS          estado_anterior_castellano,
                c.DOMFICNOP         AS          estado_anterior_portugues,
                c.DOMFICPAR         AS          estado_anterior_parametro,
                c.DOMFICICO         AS          estado_anterior_icono,
                c.DOMFICCSS         AS          estado_anterior_css,

                d.DOMFICCOD         AS          estado_actual_codigo,
                d.DOMFICNOI         AS          estado_actual_ingles,
                d.DOMFICNOC         AS          estado_actual_castellano,
                d.DOMFICNOP         AS          estado_actual_portugues,
                d.DOMFICPAR         AS          estado_actual_parametro,
                d.DOMFICICO         AS          estado_actual_icono,
                d.DOMFICCSS         AS          estado_actual_css,

                e.DOMFICCOD         AS          tipo_prioridad_codigo,
                e.DOMFICNOI         AS          tipo_prioridad_ingles,
                e.DOMFICNOC         AS          tipo_prioridad_castellano,
                e.DOMFICNOP         AS          tipo_prioridad_portugues,
                e.DOMFICPAR         AS          tipo_prioridad_parametro,
                e.DOMFICICO         AS          tipo_prioridad_icono,
                e.DOMFICCSS         AS          tipo_prioridad_css,

                f.WRKFICCOD         AS          workflow_codigo,
                f.WRKFICORD         AS          workflow_orden,
                f.WRKFICNOM         AS          workflow_tarea,
                f.WRKFICOBS         AS          workflow_observacion

                FROM [wrk].[WRKDET] a
                INNER JOIN [CSF].[dbo].[@A1A_TICA] b ON a.WRKDETTCC = b.U_CODIGO
                INNER JOIN [adm].[DOMFIC] c ON a.WRKDETEAC = c.DOMFICCOD
                INNER JOIN [adm].[DOMFIC] d ON a.WRKDETECC = d.DOMFICCOD
                INNER JOIN [adm].[DOMFIC] e ON a.WRKDETTPC = e.DOMFICCOD
                INNER JOIN [wrk].[WRKFIC] f ON a.WRKDETWFC = f.WRKFICCOD

                WHERE a.WRKDETWFC = ?
                
                ORDER BY a.WRKDETORD";

            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val01]);

                while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                    $detalle    = array(
                        'workflow_detalle_codigo'           => $rowMSSQL00['workflow_detalle_codigo'],
                        'workflow_detalle_orden'            => $rowMSSQL00['workflow_detalle_orden'],
                        'workflow_detalle_tarea'            => trim(strtoupper(strtolower($rowMSSQL00['workflow_detalle_tarea']))),
                        'workflow_detalle_hora'             => $rowMSSQL00['workflow_detalle_hora'],
                        'workflow_detalle_notifica'         => trim(strtoupper(strtolower($rowMSSQL00['workflow_detalle_notifica']))),
                        'workflow_detalle_observacion'      => trim(strtoupper(strtolower($rowMSSQL00['workflow_detalle_observacion']))),
    
                        'auditoria_usuario'                 => trim(strtoupper(strtolower($rowMSSQL00['auditoria_usuario']))),
                        'auditoria_fecha_hora'              => date("d/m/Y", strtotime($rowMSSQL00['auditoria_fecha_hora'])),
                        'auditoria_ip'                      => trim(strtoupper(strtolower($rowMSSQL00['auditoria_ip']))),
    
                        'tipo_cargo_codigo'                 => $rowMSSQL00['tipo_cargo_codigo'],
                        'tipo_cargo_codigo_nombre'          => trim(strtoupper(strtolower($rowMSSQL00['tipo_cargo_codigo_nombre']))),
                        'tipo_cargo_codigo_referencia'      => trim(strtoupper(strtolower($rowMSSQL00['tipo_cargo_codigo_referencia']))),
                        'tipo_cargo_nombre'                 => trim(strtoupper(strtolower($rowMSSQL00['tipo_cargo_nombre']))),
    
                        'estado_anterior_codigo'            => $rowMSSQL00['estado_anterior_codigo'],
                        'estado_anterior_ingles'            => trim(strtoupper(strtolower($rowMSSQL00['estado_anterior_ingles']))),
                        'estado_anterior_castellano'        => trim(strtoupper(strtolower($rowMSSQL00['estado_anterior_castellano']))),
                        'estado_anterior_portugues'         => trim(strtoupper(strtolower($rowMSSQL00['estado_anterior_portugues']))),
                        'estado_anterior_parametro'         => $rowMSSQL00['estado_anterior_parametro'],
                        'estado_anterior_icono'             => trim(strtolower($rowMSSQL00['estado_anterior_icono'])),
                        'estado_anterior_css'               => trim(strtolower($rowMSSQL00['estado_anterior_css'])),
    
                        'estado_actual_codigo'              => $rowMSSQL00['estado_actual_codigo'],
                        'estado_actual_ingles'              => trim(strtoupper(strtolower($rowMSSQL00['estado_actual_ingles']))),
                        'estado_actual_castellano'          => trim(strtoupper(strtolower($rowMSSQL00['estado_actual_castellano']))),
                        'estado_actual_portugues'           => trim(strtoupper(strtolower($rowMSSQL00['estado_actual_portugues']))),
                        'estado_actual_parametro'           => $rowMSSQL00['estado_actual_parametro'],
                        'estado_actual_icono'               => trim(strtolower($rowMSSQL00['estado_actual_icono'])),
                        'estado_actual_css'                 => trim(strtolower($rowMSSQL00['estado_actual_css'])),
    
                        'tipo_prioridad_codigo'             => $rowMSSQL00['tipo_prioridad_codigo'],
                        'tipo_prioridad_ingles'             => trim(strtoupper(strtolower($rowMSSQL00['tipo_prioridad_ingles']))),
                        'tipo_prioridad_castellano'         => trim(strtoupper(strtolower($rowMSSQL00['tipo_prioridad_castellano']))),
                        'tipo_prioridad_portugues'          => trim(strtoupper(strtolower($rowMSSQL00['tipo_prioridad_portugues']))),
                        'tipo_prioridad_parametro'          => $rowMSSQL00['tipo_prioridad_parametro'],
                        'tipo_prioridad_icono'              => trim(strtolower($rowMSSQL00['tipo_prioridad_icono'])),
                        'tipo_prioridad_css'                => trim(strtolower($rowMSSQL00['tipo_prioridad_css'])),
    
                        'workflow_codigo'                   => $rowMSSQL00['workflow_codigo'],
                        'workflow_orden'                    => $rowMSSQL00['workflow_orden'],
                        'workflow_tarea'                    => trim(strtoupper(strtolower($rowMSSQL00['workflow_tarea']))),
                        'workflow_observacion'              => trim(strtoupper(strtolower($rowMSSQL00['workflow_observacion'])))
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle    = array(
                        'workflow_detalle_codigo'           => '',
                        'workflow_detalle_orden'            => '',
                        'workflow_detalle_tarea'            => '',
                        'workflow_detalle_hora'             => '',
                        'workflow_detalle_notifica'         => '',
                        'workflow_detalle_observacion'      => '',
    
                        'auditoria_usuario'                 => '',
                        'auditoria_fecha_hora'              => '',
                        'auditoria_ip'                      => '',
    
                        'tipo_cargo_codigo'                 => '',
                        'tipo_cargo_codigo_nombre'          => '',
                        'tipo_cargo_codigo_referencia'      => '',
                        'tipo_cargo_nombre'                 => '',
    
                        'estado_anterior_codigo'            => '',
                        'estado_anterior_ingles'            => '',
                        'estado_anterior_castellano'        => '',
                        'estado_anterior_portugues'         => '',
                        'estado_anterior_parametro'         => '',
                        'estado_anterior_icono'             => '',
                        'estado_anterior_css'               => '',
    
                        'estado_actual_codigo'              => '',
                        'estado_actual_ingles'              => '',
                        'estado_actual_castellano'          => '',
                        'estado_actual_portugues'           => '',
                        'estado_actual_parametro'           => '',
                        'estado_actual_icono'               => '',
                        'estado_actual_css'                 => '',
    
                        'tipo_prioridad_codigo'             => '',
                        'tipo_prioridad_ingles'             => '',
                        'tipo_prioridad_castellano'         => '',
                        'tipo_prioridad_portugues'          => '',
                        'tipo_prioridad_parametro'          => '',
                        'tipo_prioridad_icono'              => '',
                        'tipo_prioridad_css'                => '',
    
                        'workflow_codigo'                   => '',
                        'workflow_orden'                    => '',
                        'workflow_tarea'                    => '',
                        'workflow_observacion'              => ''
                    );

                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                }

                $stmtMSSQL00->closeCursor();
                $stmtMSSQL00 = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        }  else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });
/*MODULO WORKFLOW*/

/*MODULO VIAJE*/
    $app->get('/v2/400/proveedor', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $sql00  = "SELECT
            a.PROFICCOD         AS          proveedor_codigo,
            a.PROFICNOM         AS          proveedor_nombre,
            a.PROFICRAZ         AS          proveedor_razon_social,
            a.PROFICRUC         AS          proveedor_ruc,
            a.PROFICDIR         AS          proveedor_direccion,
            a.PROFICSPC         AS          proveedor_sap_castastrado,
            a.PROFICSPI         AS          proveedor_sap_codigo,
            a.PROFICOBS         AS          proveedor_observacion,

            a.PROFICAUS         AS          auditoria_usuario,
            a.PROFICAFH         AS          auditoria_fecha_hora,
            a.PROFICAIP         AS          auditoria_ip,

            b.DOMFICCOD         AS          tipo_estado_codigo,
            b.DOMFICNOI         AS          tipo_estado_ingles,
            b.DOMFICNOC         AS          tipo_estado_castellano,
            b.DOMFICNOP         AS          tipo_estado_portugues,
            b.DOMFICPAR         AS          tipo_estado_parametro,
            b.DOMFICICO         AS          tipo_estado_icono,
            b.DOMFICCSS         AS          tipo_estado_css,

            c.DOMFICCOD         AS          tipo_proveedor_codigo,
            c.DOMFICNOI         AS          tipo_proveedor_ingles,
            c.DOMFICNOC         AS          tipo_proveedor_castellano,
            c.DOMFICNOP         AS          tipo_proveedor_portugues,
            c.DOMFICPAR         AS          tipo_proveedor_parametro,
            c.DOMFICICO         AS          tipo_proveedor_icono,
            c.DOMFICCSS         AS          tipo_proveedor_css,

            d.LOCCIUCOD         AS          ciudad_codigo,
            d.LOCCIUORD         AS          ciudad_orden,
            d.LOCCIUNOM         AS          ciudad_nombre,
            d.LOCCIUOBS         AS          ciudad_observacion,

            e.LOCPAICOD         AS          pais_codigo,
            e.LOCPAIORD         AS          pais_orden,
            e.LOCPAINOM         AS          pais_nombre,
            e.LOCPAIPAT         AS          pais_path,
            e.LOCPAIIC2         AS          pais_iso_char2,
            e.LOCPAIIC3         AS          pais_iso_char3,
            e.LOCPAIIN3         AS          pais_iso_num3,
            e.LOCPAIOBS         AS          pais_observacion

            FROM [via].[PROFIC] a
            INNER JOIN [adm].[DOMFIC] b ON a.PROFICEST = b.DOMFICCOD
            INNER JOIN [adm].[DOMFIC] c ON a.PROFICTPC = c.DOMFICCOD
            INNER JOIN [adm].[LOCCIU] d ON a.PROFICCIC = d.LOCCIUCOD
            INNER JOIN [adm].[LOCPAI] e ON d.LOCCIUPAC = e.LOCPAICOD
            
            ORDER BY a.PROFICTPC";

        try {
            $connMSSQL  = getConnectionMSSQLv2();
            $stmtMSSQL00= $connMSSQL->prepare($sql00);
            $stmtMSSQL00->execute();

            while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                $detalle    = array(
                    'proveedor_codigo'                  => $rowMSSQL00['proveedor_codigo'],
                    'proveedor_nombre'                  => trim(strtoupper(strtolower($rowMSSQL00['proveedor_nombre']))),
                    'proveedor_razon_social'            => trim(strtoupper(strtolower($rowMSSQL00['proveedor_razon_social']))),
                    'proveedor_ruc'                     => trim(strtoupper(strtolower($rowMSSQL00['proveedor_ruc']))),
                    'proveedor_direccion'               => trim(strtoupper(strtolower($rowMSSQL00['proveedor_direccion']))),
                    'proveedor_sap_castastrado'         => trim(strtoupper(strtolower($rowMSSQL00['proveedor_sap_castastrado']))),
                    'proveedor_sap_codigo'              => trim(strtoupper(strtolower($rowMSSQL00['proveedor_sap_codigo']))),
                    'proveedor_observacion'             => trim(strtoupper(strtolower($rowMSSQL00['proveedor_observacion']))),

                    'auditoria_usuario'                 => trim(strtoupper(strtolower($rowMSSQL00['auditoria_usuario']))),
                    'auditoria_fecha_hora'              => date("d/m/Y", strtotime($rowMSSQL00['auditoria_fecha_hora'])),
                    'auditoria_ip'                      => trim(strtoupper(strtolower($rowMSSQL00['auditoria_ip']))),

                    'tipo_estado_codigo'                => $rowMSSQL00['tipo_estado_codigo'],
                    'tipo_estado_ingles'                => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_ingles']))),
                    'tipo_estado_castellano'            => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_castellano']))),
                    'tipo_estado_portugues'             => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_portugues']))),
                    'tipo_estado_parametro'             => $rowMSSQL00['tipo_estado_parametro'],
                    'tipo_estado_icono'                 => trim(strtolower($rowMSSQL00['tipo_estado_icono'])),
                    'tipo_estado_css'                   => trim(strtolower($rowMSSQL00['tipo_estado_css'])),

                    'tipo_proveedor_codigo'             => $rowMSSQL00['tipo_proveedor_codigo'],
                    'tipo_proveedor_ingles'             => trim(strtoupper(strtolower($rowMSSQL00['tipo_proveedor_ingles']))),
                    'tipo_proveedor_castellano'         => trim(strtoupper(strtolower($rowMSSQL00['tipo_proveedor_castellano']))),
                    'tipo_proveedor_portugues'          => trim(strtoupper(strtolower($rowMSSQL00['tipo_proveedor_portugues']))),
                    'tipo-proveedor_parametro'          => $rowMSSQL00['tipo_proveedor_parametro'],
                    'tipo_proveedor_icono'              => trim(strtolower($rowMSSQL00['tipo_proveedor_icono'])),
                    'tipo_proveedor_css'                => trim(strtolower($rowMSSQL00['tipo_proveedor_css'])),

                    'ciudad_codigo'                     => $rowMSSQL00['ciudad_codigo'],
                    'ciudad_orden'                      => $rowMSSQL00['ciudad_orden'],
                    'ciudad_nombre'                     => trim(strtoupper(strtolower($rowMSSQL00['ciudad_nombre']))),
                    'ciudad_observacion'                => trim(strtolower($rowMSSQL00['ciudad_observacion'])),

                    'pais_codigo'                       => $rowMSSQL00['pais_codigo'],
                    'pais_orden'                        => $rowMSSQL00['pais_orden'],
                    'pais_nombre'                       => trim(strtoupper(strtolower($rowMSSQL00['pais_nombre']))),
                    'pais_path'                         => trim(strtolower($rowMSSQL00['pais_path'])),
                    'pais_iso_char2'                    => trim(strtoupper(strtolower($rowMSSQL00['pais_iso_char2']))),
                    'pais_iso_char3'                    => trim(strtoupper(strtolower($rowMSSQL00['pais_iso_char3']))),
                    'pais_iso_num3'                     => trim(strtoupper(strtolower($rowMSSQL00['pais_iso_num3']))),
                    'pais_observacion'                  => trim(strtoupper(strtolower($rowMSSQL00['pais_observacion'])))
                );

                $result[]   = $detalle;
            }

            if (isset($result)){
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } else {
                $detalle    = array(
                    'proveedor_codigo'                  => '',
                    'proveedor_nombre'                  => '',
                    'proveedor_razon_social'            => '',
                    'proveedor_ruc'                     => '',
                    'proveedor_direccion'               => '',
                    'proveedor_sap_castastrado'         => '',
                    'proveedor_sap_codigo'              => '',
                    'proveedor_observacion'             => '',

                    'auditoria_usuario'                 => '',
                    'auditoria_fecha_hora'              => '',
                    'auditoria_ip'                      => '',

                    'tipo_estado_codigo'                => '',
                    'tipo_estado_ingles'                => '',
                    'tipo_estado_castellano'            => '',
                    'tipo_estado_portugues'             => '',
                    'tipo_estado_parametro'             => '',
                    'tipo_estado_icono'                 => '',
                    'tipo_estado_css'                   => '',

                    'tipo_proveedor_codigo'             => '',
                    'tipo_proveedor_ingles'             => '',
                    'tipo_proveedor_castellano'         => '',
                    'tipo_proveedor_portugues'          => '',
                    'tipo_proveedor_parametro'          => '',
                    'tipo_proveedor_icono'              => '',
                    'tipo_proveedor_css'                => '',

                    'ciudad_codigo'                     => '',
                    'ciudad_orden'                      => '',
                    'ciudad_nombre'                     => '',
                    'ciudad_observacion'                => '',

                    'pais_codigo'                       => '',
                    'pais_orden'                        => '',
                    'pais_nombre'                       => '',
                    'pais_path'                         => '',
                    'pais_iso_char2'                    => '',
                    'pais_iso_char3'                    => '',
                    'pais_iso_num3'                     => '',
                    'pais_observacion'                  => ''
                );

                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }

            $stmtMSSQL00->closeCursor();
            $stmtMSSQL00 = null;
        } catch (PDOException $e) {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v2/400/proveedor/codigo/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01  = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
                a.PROFICCOD         AS          proveedor_codigo,
                a.PROFICNOM         AS          proveedor_nombre,
                a.PROFICRAZ         AS          proveedor_razon_social,
                a.PROFICRUC         AS          proveedor_ruc,
                a.PROFICDIR         AS          proveedor_direccion,
                a.PROFICSPC         AS          proveedor_sap_castastrado,
                a.PROFICSPI         AS          proveedor_sap_codigo,
                a.PROFICOBS         AS          proveedor_observacion,

                a.PROFICAUS         AS          auditoria_usuario,
                a.PROFICAFH         AS          auditoria_fecha_hora,
                a.PROFICAIP         AS          auditoria_ip,

                b.DOMFICCOD         AS          tipo_estado_codigo,
                b.DOMFICNOI         AS          tipo_estado_ingles,
                b.DOMFICNOC         AS          tipo_estado_castellano,
                b.DOMFICNOP         AS          tipo_estado_portugues,
                b.DOMFICPAR         AS          tipo_estado_parametro,
                b.DOMFICICO         AS          tipo_estado_icono,
                b.DOMFICCSS         AS          tipo_estado_css,

                c.DOMFICCOD         AS          tipo_proveedor_codigo,
                c.DOMFICNOI         AS          tipo_proveedor_ingles,
                c.DOMFICNOC         AS          tipo_proveedor_castellano,
                c.DOMFICNOP         AS          tipo_proveedor_portugues,
                c.DOMFICPAR         AS          tipo_proveedor_parametro,
                c.DOMFICICO         AS          tipo_proveedor_icono,
                c.DOMFICCSS         AS          tipo_proveedor_css,

                d.LOCCIUCOD         AS          ciudad_codigo,
                d.LOCCIUORD         AS          ciudad_orden,
                d.LOCCIUNOM         AS          ciudad_nombre,
                d.LOCCIUOBS         AS          ciudad_observacion,

                e.LOCPAICOD         AS          pais_codigo,
                e.LOCPAIORD         AS          pais_orden,
                e.LOCPAINOM         AS          pais_nombre,
                e.LOCPAIPAT         AS          pais_path,
                e.LOCPAIIC2         AS          pais_iso_char2,
                e.LOCPAIIC3         AS          pais_iso_char3,
                e.LOCPAIIN3         AS          pais_iso_num3,
                e.LOCPAIOBS         AS          pais_observacion

                FROM [via].[PROFIC] a
                INNER JOIN [adm].[DOMFIC] b ON a.PROFICEST = b.DOMFICCOD
                INNER JOIN [adm].[DOMFIC] c ON a.PROFICTPC = c.DOMFICCOD
                INNER JOIN [adm].[LOCCIU] d ON a.PROFICCIC = d.LOCCIUCOD
                INNER JOIN [adm].[LOCPAI] e ON d.LOCCIUPAC = e.LOCPAICOD

                WHERE a.PROFICCOD = ?
                
                ORDER BY a.PROFICTPC";

            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val01]);

                while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                    $detalle    = array(
                        'proveedor_codigo'                  => $rowMSSQL00['proveedor_codigo'],
                        'proveedor_nombre'                  => trim(strtoupper(strtolower($rowMSSQL00['proveedor_nombre']))),
                        'proveedor_razon_social'            => trim(strtoupper(strtolower($rowMSSQL00['proveedor_razon_social']))),
                        'proveedor_ruc'                     => trim(strtoupper(strtolower($rowMSSQL00['proveedor_ruc']))),
                        'proveedor_direccion'               => trim(strtoupper(strtolower($rowMSSQL00['proveedor_direccion']))),
                        'proveedor_sap_castastrado'         => trim(strtoupper(strtolower($rowMSSQL00['proveedor_sap_castastrado']))),
                        'proveedor_sap_codigo'              => trim(strtoupper(strtolower($rowMSSQL00['proveedor_sap_codigo']))),
                        'proveedor_observacion'             => trim(strtoupper(strtolower($rowMSSQL00['proveedor_observacion']))),
    
                        'auditoria_usuario'                 => trim(strtoupper(strtolower($rowMSSQL00['auditoria_usuario']))),
                        'auditoria_fecha_hora'              => date("d/m/Y", strtotime($rowMSSQL00['auditoria_fecha_hora'])),
                        'auditoria_ip'                      => trim(strtoupper(strtolower($rowMSSQL00['auditoria_ip']))),
    
                        'tipo_estado_codigo'                => $rowMSSQL00['tipo_estado_codigo'],
                        'tipo_estado_ingles'                => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_ingles']))),
                        'tipo_estado_castellano'            => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_castellano']))),
                        'tipo_estado_portugues'             => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_portugues']))),
                        'tipo_estado_parametro'             => $rowMSSQL00['tipo_estado_parametro'],
                        'tipo_estado_icono'                 => trim(strtolower($rowMSSQL00['tipo_estado_icono'])),
                        'tipo_estado_css'                   => trim(strtolower($rowMSSQL00['tipo_estado_css'])),

                        'tipo_proveedor_codigo'             => $rowMSSQL00['tipo_proveedor_codigo'],
                        'tipo_proveedor_ingles'             => trim(strtoupper(strtolower($rowMSSQL00['tipo_proveedor_ingles']))),
                        'tipo_proveedor_castellano'         => trim(strtoupper(strtolower($rowMSSQL00['tipo_proveedor_castellano']))),
                        'tipo_proveedor_portugues'          => trim(strtoupper(strtolower($rowMSSQL00['tipo_proveedor_portugues']))),
                        'tipo-proveedor_parametro'          => $rowMSSQL00['tipo_proveedor_parametro'],
                        'tipo_proveedor_icono'              => trim(strtolower($rowMSSQL00['tipo_proveedor_icono'])),
                        'tipo_proveedor_css'                => trim(strtolower($rowMSSQL00['tipo_proveedor_css'])),
                        
                        'ciudad_codigo'                     => $rowMSSQL00['ciudad_codigo'],
                        'ciudad_orden'                      => $rowMSSQL00['ciudad_orden'],
                        'ciudad_nombre'                     => trim(strtoupper(strtolower($rowMSSQL00['ciudad_nombre']))),
                        'ciudad_observacion'                => trim(strtolower($rowMSSQL00['ciudad_observacion'])),
    
                        'pais_codigo'                       => $rowMSSQL00['pais_codigo'],
                        'pais_orden'                        => $rowMSSQL00['pais_orden'],
                        'pais_nombre'                       => trim(strtoupper(strtolower($rowMSSQL00['pais_nombre']))),
                        'pais_path'                         => trim(strtolower($rowMSSQL00['pais_path'])),
                        'pais_iso_char2'                    => trim(strtoupper(strtolower($rowMSSQL00['pais_iso_char2']))),
                        'pais_iso_char3'                    => trim(strtoupper(strtolower($rowMSSQL00['pais_iso_char3']))),
                        'pais_iso_num3'                     => trim(strtoupper(strtolower($rowMSSQL00['pais_iso_num3']))),
                        'pais_observacion'                  => trim(strtoupper(strtolower($rowMSSQL00['pais_observacion'])))
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle    = array(
                        'proveedor_codigo'                  => '',
                        'proveedor_nombre'                  => '',
                        'proveedor_razon_social'            => '',
                        'proveedor_ruc'                     => '',
                        'proveedor_direccion'               => '',
                        'proveedor_sap_castastrado'         => '',
                        'proveedor_sap_codigo'              => '',
                        'proveedor_observacion'             => '',
    
                        'auditoria_usuario'                 => '',
                        'auditoria_fecha_hora'              => '',
                        'auditoria_ip'                      => '',
    
                        'tipo_estado_codigo'                => '',
                        'tipo_estado_ingles'                => '',
                        'tipo_estado_castellano'            => '',
                        'tipo_estado_portugues'             => '',
                        'tipo_estado_parametro'             => '',
                        'tipo_estado_icono'                 => '',
                        'tipo_estado_css'                   => '',

                        'tipo_proveedor_codigo'             => '',
                        'tipo_proveedor_ingles'             => '',
                        'tipo_proveedor_castellano'         => '',
                        'tipo_proveedor_portugues'          => '',
                        'tipo_proveedor_parametro'          => '',
                        'tipo_proveedor_icono'              => '',
                        'tipo_proveedor_css'                => '',
    
                        'ciudad_codigo'                     => '',
                        'ciudad_orden'                      => '',
                        'ciudad_nombre'                     => '',
                        'ciudad_observacion'                => '',
    
                        'pais_codigo'                       => '',
                        'pais_orden'                        => '',
                        'pais_nombre'                       => '',
                        'pais_path'                         => '',
                        'pais_iso_char2'                    => '',
                        'pais_iso_char3'                    => '',
                        'pais_iso_num3'                     => '',
                        'pais_observacion'                  => ''
                    );

                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                }

                $stmtMSSQL00->closeCursor();
                $stmtMSSQL00 = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }

        }  else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v2/400/proveedor/contacto/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01  = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
                a.PROCONCOD         AS          proveedor_contacto_codigo,
                a.PROCONNOM         AS          proveedor_contacto_nombre,
                a.PROCONEMA         AS          proveedor_contacto_email,
                a.PROCONTEL         AS          proveedor_contacto_telefono,
                a.PROCONWHA         AS          proveedor_contacto_whatsapp,
                a.PROCONSKY         AS          proveedor_contacto_skype,
                a.PROCONOBS         AS          proveedor_contacto_observacion,

                a.PROCONAUS         AS          auditoria_usuario,
                a.PROCONAFH         AS          auditoria_fecha_hora,
                a.PROCONAIP         AS          auditoria_ip,

                b.DOMFICCOD         AS          tipo_estado_codigo,
                b.DOMFICNOI         AS          tipo_estado_ingles,
                b.DOMFICNOC         AS          tipo_estado_castellano,
                b.DOMFICNOP         AS          tipo_estado_portugues,
                b.DOMFICPAR         AS          tipo_estado_parametro,
                b.DOMFICICO         AS          tipo_estado_icono,
                b.DOMFICCSS         AS          tipo_estado_css,

                c.PROFICCOD         AS          proveedor_codigo,
                c.PROFICNOM         AS          proveedor_nombre,
                c.PROFICRAZ         AS          proveedor_razon_social,
                c.PROFICRUC         AS          proveedor_ruc,
                c.PROFICDIR         AS          proveedor_direccion,
                c.PROFICSPC         AS          proveedor_sap_castastrado,
                c.PROFICSPI         AS          proveedor_sap_codigo,
                c.PROFICOBS         AS          proveedor_observacion

                FROM [via].[PROCON] a
                INNER JOIN [adm].[DOMFIC] b ON a.PROCONEST = b.DOMFICCOD
                INNER JOIN [via].[PROFIC] c ON a.PROCONPRC = c.PROFICCOD

                WHERE a.PROCONPRC = ?
                
                ORDER BY a.PROCONPRC";

            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val01]);

                while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                    $detalle    = array(
                        'proveedor_contacto_codigo'         => $rowMSSQL00['proveedor_contacto_codigo'],
                        'proveedor_contacto_nombre'         => trim(strtoupper(strtolower($rowMSSQL00['proveedor_contacto_nombre']))),
                        'proveedor_contacto_email'          => trim(strtolower($rowMSSQL00['proveedor_contacto_email'])),
                        'proveedor_contacto_telefono'       => trim(strtoupper(strtolower($rowMSSQL00['proveedor_contacto_telefono']))),
                        'proveedor_contacto_whatsapp'       => trim(strtoupper(strtolower($rowMSSQL00['proveedor_contacto_whatsapp']))),
                        'proveedor_contacto_skype'          => trim(strtolower($rowMSSQL00['proveedor_contacto_skype'])),
                        'proveedor_contacto_observacion'    => trim(strtoupper(strtolower($rowMSSQL00['proveedor_contacto_observacion']))),

                        'auditoria_usuario'                 => trim(strtoupper(strtolower($rowMSSQL00['auditoria_usuario']))),
                        'auditoria_fecha_hora'              => date("d/m/Y", strtotime($rowMSSQL00['auditoria_fecha_hora'])),
                        'auditoria_ip'                      => trim(strtoupper(strtolower($rowMSSQL00['auditoria_ip']))),

                        'tipo_estado_codigo'                => $rowMSSQL00['tipo_estado_codigo'],
                        'tipo_estado_ingles'                => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_ingles']))),
                        'tipo_estado_castellano'            => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_castellano']))),
                        'tipo_estado_portugues'             => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_portugues']))),
                        'tipo_estado_parametro'             => $rowMSSQL00['tipo_estado_parametro'],
                        'tipo_estado_icono'                 => trim(strtolower($rowMSSQL00['tipo_estado_icono'])),
                        'tipo_estado_css'                   => trim(strtolower($rowMSSQL00['tipo_estado_css'])),

                        'proveedor_codigo'                  => $rowMSSQL00['proveedor_codigo'],
                        'proveedor_nombre'                  => trim(strtoupper(strtolower($rowMSSQL00['proveedor_nombre']))),
                        'proveedor_razon_social'            => trim(strtoupper(strtolower($rowMSSQL00['proveedor_razon_social']))),
                        'proveedor_ruc'                     => trim(strtoupper(strtolower($rowMSSQL00['proveedor_ruc']))),
                        'proveedor_direccion'               => trim(strtoupper(strtolower($rowMSSQL00['proveedor_direccion']))),
                        'proveedor_sap_castastrado'         => trim(strtoupper(strtolower($rowMSSQL00['proveedor_sap_castastrado']))),
                        'proveedor_sap_codigo'              => trim(strtoupper(strtolower($rowMSSQL00['proveedor_sap_codigo']))),
                        'proveedor_observacion'             => trim(strtoupper(strtolower($rowMSSQL00['proveedor_observacion'])))
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle    = array(
                        'proveedor_contacto_codigo'         => '',
                        'proveedor_contacto_nombre'         => '',
                        'proveedor_contacto_email'          => '',
                        'proveedor_contacto_telefono'       => '',
                        'proveedor_contacto_whatsapp'       => '',
                        'proveedor_contacto_skype'          => '',
                        'proveedor_contacto_observacion'    => '',

                        'auditoria_usuario'                 => '',
                        'auditoria_fecha_hora'              => '',
                        'auditoria_ip'                      => '',

                        'tipo_estado_codigo'                => '',
                        'tipo_estado_ingles'                => '',
                        'tipo_estado_castellano'            => '',
                        'tipo_estado_portugues'             => '',
                        'tipo_estado_parametro'             => '',
                        'tipo_estado_icono'                 => '',
                        'tipo_estado_css'                   => '',
                        
                        'proveedor_codigo'                  => '',
                        'proveedor_nombre'                  => '',
                        'proveedor_razon_social'            => '',
                        'proveedor_ruc'                     => '',
                        'proveedor_direccion'               => '',
                        'proveedor_sap_castastrado'         => '',
                        'proveedor_sap_codigo'              => '',
                        'proveedor_observacion'             => ''
                    );

                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                }

                $stmtMSSQL00->closeCursor();
                $stmtMSSQL00 = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }

        }  else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v2/400/proveedor/habitacion/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01  = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
                a.PROHABCOD         AS          proveedor_habitacion_codigo,
                a.PROHABNOM         AS          proveedor_habitacion_nombre,
                a.PROHABPRE         AS          proveedor_habitacion_precio,
                a.PROHABCAN         AS          proveedor_habitacion_cantidad,
                a.PROHABPAT         AS          proveedor_habitacion_path,
                a.PROHABOBS         AS          proveedor_habitacion_observacion,

                a.PROHABAUS         AS          auditoria_usuario,
                a.PROHABAFH         AS          auditoria_fecha_hora,
                a.PROHABAIP         AS          auditoria_ip,

                b.DOMFICCOD         AS          tipo_estado_codigo,
                b.DOMFICNOI         AS          tipo_estado_ingles,
                b.DOMFICNOC         AS          tipo_estado_castellano,
                b.DOMFICNOP         AS          tipo_estado_portugues,
                b.DOMFICPAR         AS          tipo_estado_parametro,
                b.DOMFICICO         AS          tipo_estado_icono,
                b.DOMFICCSS         AS          tipo_estado_css,

                c.DOMFICCOD         AS          tipo_habitacion_codigo,
                c.DOMFICNOI         AS          tipo_habitacion_ingles,
                c.DOMFICNOC         AS          tipo_habitacion_castellano,
                c.DOMFICNOP         AS          tipo_habitacion_portugues,
                c.DOMFICPAR         AS          tipo_habitacion_parametro,
                c.DOMFICICO         AS          tipo_habitacion_icono,
                c.DOMFICCSS         AS          tipo_habitacion_css,

                d.PROFICCOD         AS          proveedor_codigo,
                d.PROFICNOM         AS          proveedor_nombre,
                d.PROFICRAZ         AS          proveedor_razon_social,
                d.PROFICRUC         AS          proveedor_ruc,
                d.PROFICDIR         AS          proveedor_direccion,
                d.PROFICSPC         AS          proveedor_sap_castastrado,
                d.PROFICSPI         AS          proveedor_sap_codigo,
                d.PROFICOBS         AS          proveedor_observacion

                FROM [via].[PROHAB] a
                INNER JOIN [adm].[DOMFIC] b ON a.PROHABEST = b.DOMFICCOD
                INNER JOIN [adm].[DOMFIC] c ON a.PROHABTHC = c.DOMFICCOD
                INNER JOIN [via].[PROFIC] d ON a.PROHABPRC = d.PROFICCOD

                WHERE a.PROHABPRC = ?
                
                ORDER BY a.PROHABPRC";

            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val01]);

                while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                    $detalle    = array(
                        'proveedor_habitacion_codigo'       => $rowMSSQL00['proveedor_habitacion_codigo'],
                        'proveedor_habitacion_nombre'       => trim(strtoupper(strtolower($rowMSSQL00['proveedor_habitacion_nombre']))),
                        'proveedor_habitacion_precio'       => trim(strtoupper(strtolower($rowMSSQL00['proveedor_habitacion_precio']))),
                        'proveedor_habitacion_cantidad'     => $rowMSSQL00['proveedor_habitacion_cantidad'],
                        'proveedor_habitacion_path'         => trim(strtolower($rowMSSQL00['proveedor_habitacion_path'])),
                        'proveedor_habitacion_observacion'  => trim(strtoupper(strtolower($rowMSSQL00['proveedor_habitacion_observacion']))),

                        'auditoria_usuario'                 => trim(strtoupper(strtolower($rowMSSQL00['auditoria_usuario']))),
                        'auditoria_fecha_hora'              => date("d/m/Y", strtotime($rowMSSQL00['auditoria_fecha_hora'])),
                        'auditoria_ip'                      => trim(strtoupper(strtolower($rowMSSQL00['auditoria_ip']))),

                        'tipo_estado_codigo'                => $rowMSSQL00['tipo_estado_codigo'],
                        'tipo_estado_ingles'                => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_ingles']))),
                        'tipo_estado_castellano'            => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_castellano']))),
                        'tipo_estado_portugues'             => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_portugues']))),
                        'tipo_estado_parametro'             => $rowMSSQL00['tipo_estado_parametro'],
                        'tipo_estado_icono'                 => trim(strtolower($rowMSSQL00['tipo_estado_icono'])),
                        'tipo_estado_css'                   => trim(strtolower($rowMSSQL00['tipo_estado_css'])),

                        'tipo_habitacion_codigo'            => $rowMSSQL00['tipo_habitacion_codigo'],
                        'tipo_habitacion_ingles'            => trim(strtoupper(strtolower($rowMSSQL00['tipo_habitacion_ingles']))),
                        'tipo_habitacion_castellano'        => trim(strtoupper(strtolower($rowMSSQL00['tipo_habitacion_castellano']))),
                        'tipo_habitacion_portugues'         => trim(strtoupper(strtolower($rowMSSQL00['tipo_habitacion_portugues']))),
                        'tipo_habitacion_parametro'         => $rowMSSQL00['tipo_habitacion_parametro'],
                        'tipo_habitacion_icono'             => trim(strtolower($rowMSSQL00['tipo_habitacion_icono'])),
                        'tipo_habitacion_css'               => trim(strtolower($rowMSSQL00['tipo_habitacion_css'])),

                        'proveedor_codigo'                  => $rowMSSQL00['proveedor_codigo'],
                        'proveedor_nombre'                  => trim(strtoupper(strtolower($rowMSSQL00['proveedor_nombre']))),
                        'proveedor_razon_social'            => trim(strtoupper(strtolower($rowMSSQL00['proveedor_razon_social']))),
                        'proveedor_ruc'                     => trim(strtoupper(strtolower($rowMSSQL00['proveedor_ruc']))),
                        'proveedor_direccion'               => trim(strtoupper(strtolower($rowMSSQL00['proveedor_direccion']))),
                        'proveedor_sap_castastrado'         => trim(strtoupper(strtolower($rowMSSQL00['proveedor_sap_castastrado']))),
                        'proveedor_sap_codigo'              => trim(strtoupper(strtolower($rowMSSQL00['proveedor_sap_codigo']))),
                        'proveedor_observacion'             => trim(strtoupper(strtolower($rowMSSQL00['proveedor_observacion'])))
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle    = array(
                        'proveedor_habitacion_codigo'       => '',
                        'proveedor_habitacion_nombre'       => '',
                        'proveedor_habitacion_precio'       => '',
                        'proveedor_habitacion_cantidad'     => '',
                        'proveedor_habitacion_path'         => '',
                        'proveedor_habitacion_observacion'  => '',

                        'auditoria_usuario'                 => '',
                        'auditoria_fecha_hora'              => '',
                        'auditoria_ip'                      => '',

                        'tipo_estado_codigo'                => '',
                        'tipo_estado_ingles'                => '',
                        'tipo_estado_castellano'            => '',
                        'tipo_estado_portugues'             => '',
                        'tipo_estado_parametro'             => '',
                        'tipo_estado_icono'                 => '',
                        'tipo_estado_css'                   => '',

                        'tipo_habitacion_codigo'            => '',
                        'tipo_habitacion_ingles'            => '',
                        'tipo_habitacion_castellano'        => '',
                        'tipo_habitacion_portugues'         => '',
                        'tipo_habitacion_parametro'         => '',
                        'tipo_habitacion_icono'             => '',
                        'tipo_habitacion_css'               => '',

                        'proveedor_codigo'                  => '',
                        'proveedor_nombre'                  => '',
                        'proveedor_razon_social'            => '',
                        'proveedor_ruc'                     => '',
                        'proveedor_direccion'               => '',
                        'proveedor_sap_castastrado'         => '',
                        'proveedor_sap_codigo'              => '',
                        'proveedor_observacion'             => ''
                    );

                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                }

                $stmtMSSQL00->closeCursor();
                $stmtMSSQL00 = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }

        }  else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v2/400/proveedor/imagen/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01  = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
                a.PROIMACOD         AS          proveedor_imagen_codigo,
                a.PROIMAPAT         AS          proveedor_imagen_path,
                a.PROIMAOBS         AS          proveedor_imagen_observacion,

                a.PROIMAAUS         AS          auditoria_usuario,
                a.PROIMAAFH         AS          auditoria_fecha_hora,
                a.PROIMAAIP         AS          auditoria_ip,

                b.DOMFICCOD         AS          tipo_estado_codigo,
                b.DOMFICNOI         AS          tipo_estado_ingles,
                b.DOMFICNOC         AS          tipo_estado_castellano,
                b.DOMFICNOP         AS          tipo_estado_portugues,
                b.DOMFICPAR         AS          tipo_estado_parametro,
                b.DOMFICICO         AS          tipo_estado_icono,
                b.DOMFICCSS         AS          tipo_estado_css,

                c.PROFICCOD         AS          proveedor_codigo,
                c.PROFICNOM         AS          proveedor_nombre,
                c.PROFICRAZ         AS          proveedor_razon_social,
                c.PROFICRUC         AS          proveedor_ruc,
                c.PROFICDIR         AS          proveedor_direccion,
                c.PROFICSPC         AS          proveedor_sap_castastrado,
                c.PROFICSPI         AS          proveedor_sap_codigo,
                c.PROFICOBS         AS          proveedor_observacion

                FROM [via].[PROIMA] a
                INNER JOIN [adm].[DOMFIC] b ON a.PROIMAEST = b.DOMFICCOD
                INNER JOIN [via].[PROFIC] c ON a.PROIMAPRC = c.PROFICCOD

                WHERE a.PROIMAPRC = ?
                
                ORDER BY a.PROIMAPRC";

            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val01]);

                while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                    $detalle    = array(
                        'proveedor_imagen_codigo'           => $rowMSSQL00['proveedor_imagen_codigo'],
                        'proveedor_imagen_path'             => trim(strtolower($rowMSSQL00['proveedor_imagen_path'])),
                        'proveedor_imagen_observacion'      => trim(strtoupper(strtolower($rowMSSQL00['proveedor_imagen_observacion']))),

                        'auditoria_usuario'                 => trim(strtoupper(strtolower($rowMSSQL00['auditoria_usuario']))),
                        'auditoria_fecha_hora'              => date("d/m/Y", strtotime($rowMSSQL00['auditoria_fecha_hora'])),
                        'auditoria_ip'                      => trim(strtoupper(strtolower($rowMSSQL00['auditoria_ip']))),

                        'tipo_estado_codigo'                => $rowMSSQL00['tipo_estado_codigo'],
                        'tipo_estado_ingles'                => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_ingles']))),
                        'tipo_estado_castellano'            => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_castellano']))),
                        'tipo_estado_portugues'             => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_portugues']))),
                        'tipo_estado_parametro'             => $rowMSSQL00['tipo_estado_parametro'],
                        'tipo_estado_icono'                 => trim(strtolower($rowMSSQL00['tipo_estado_icono'])),
                        'tipo_estado_css'                   => trim(strtolower($rowMSSQL00['tipo_estado_css'])),

                        'proveedor_codigo'                  => $rowMSSQL00['proveedor_codigo'],
                        'proveedor_nombre'                  => trim(strtoupper(strtolower($rowMSSQL00['proveedor_nombre']))),
                        'proveedor_razon_social'            => trim(strtoupper(strtolower($rowMSSQL00['proveedor_razon_social']))),
                        'proveedor_ruc'                     => trim(strtoupper(strtolower($rowMSSQL00['proveedor_ruc']))),
                        'proveedor_direccion'               => trim(strtoupper(strtolower($rowMSSQL00['proveedor_direccion']))),
                        'proveedor_sap_castastrado'         => trim(strtoupper(strtolower($rowMSSQL00['proveedor_sap_castastrado']))),
                        'proveedor_sap_codigo'              => trim(strtoupper(strtolower($rowMSSQL00['proveedor_sap_codigo']))),
                        'proveedor_observacion'             => trim(strtoupper(strtolower($rowMSSQL00['proveedor_observacion'])))
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle    = array(
                        'proveedor_imagen_codigo'           => '',
                        'proveedor_imagen_path'             => '',
                        'proveedor_imagen_observacion'      => '',

                        'auditoria_usuario'                 => '',
                        'auditoria_fecha_hora'              => '',
                        'auditoria_ip'                      => '',

                        'tipo_estado_codigo'                => '',
                        'tipo_estado_ingles'                => '',
                        'tipo_estado_castellano'            => '',
                        'tipo_estado_portugues'             => '',
                        'tipo_estado_parametro'             => '',
                        'tipo_estado_icono'                 => '',
                        'tipo_estado_css'                   => '',

                        'proveedor_codigo'                  => '',
                        'proveedor_nombre'                  => '',
                        'proveedor_razon_social'            => '',
                        'proveedor_ruc'                     => '',
                        'proveedor_direccion'               => '',
                        'proveedor_sap_castastrado'         => '',
                        'proveedor_sap_codigo'              => '',
                        'proveedor_observacion'             => ''
                    );

                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                }

                $stmtMSSQL00->closeCursor();
                $stmtMSSQL00 = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }

        }  else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v2/400/evento', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $sql00  = "SELECT
            a.EVEFICCOD         AS          evento_codigo,
            a.EVEFICORD         AS          evento_orden,
            a.EVEFICNOM         AS          evento_nombre,
            a.EVEFICFVI         AS          evento_fecha_inicio,
            a.EVEFICFVF         AS          evento_fecha_fin,
            a.EVEFICOBS         AS          evento_observacion,

            a.EVEFICAUS         AS          auditoria_usuario,
            a.EVEFICAFH         AS          auditoria_fecha_hora,
            a.EVEFICAIP         AS          auditoria_ip,

            b.DOMFICCOD         AS          tipo_estado_codigo,
            b.DOMFICNOI         AS          tipo_estado_ingles,
            b.DOMFICNOC         AS          tipo_estado_castellano,
            b.DOMFICNOP         AS          tipo_estado_portugues,
            b.DOMFICPAR         AS          tipo_estado_parametro,
            b.DOMFICICO         AS          tipo_estado_icono,
            b.DOMFICCSS         AS          tipo_estado_css,

            c.DOMFICCOD         AS          tipo_evento_codigo,
            c.DOMFICNOI         AS          tipo_evento_ingles,
            c.DOMFICNOC         AS          tipo_evento_castellano,
            c.DOMFICNOP         AS          tipo_evento_portugues,
            c.DOMFICPAR         AS          tipo_evento_parametro,
            c.DOMFICICO         AS          tipo_evento_icono,
            c.DOMFICCSS         AS          tipo_evento_css,

            d.LOCCIUCOD         AS          localidad_ciudad_codigo,
            d.LOCCIUORD         AS          localidad_ciudad_orden,
            d.LOCCIUNOM         AS          localidad_ciudad_nombre,
            d.LOCCIUOBS         AS          localidad_ciudad_observacion,

            e.LOCPAICOD         AS          localidad_pais_codigo,
            e.LOCPAIORD         AS          localidad_pais_orden,
            e.LOCPAINOM         AS          localidad_pais_nombre,
            e.LOCPAIPAT         AS          localidad_pais_path,
            e.LOCPAIIC2         AS          localidad_pais_iso_char2,
            e.LOCPAIIC3         AS          localidad_pais_iso_char3,
            e.LOCPAIIN3         AS          localidad_pais_iso_num3,
            e.LOCPAIOBS         AS          localidad_pais_observacion

            FROM [via].[EVEFIC] a
            INNER JOIN [adm].[DOMFIC] b ON a.EVEFICEST = b.DOMFICCOD
            INNER JOIN [adm].[DOMFIC] c ON a.EVEFICTEC = c.DOMFICCOD
            INNER JOIN [adm].[LOCCIU] d ON a.EVEFICCIC = d.LOCCIUCOD
            INNER JOIN [adm].[LOCPAI] e ON d.LOCCIUPAC = e.LOCPAICOD
            
            ORDER BY a.EVEFICORD";

        try {
            $connMSSQL  = getConnectionMSSQLv2();
            $stmtMSSQL00= $connMSSQL->prepare($sql00);
            $stmtMSSQL00->execute();

            while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                $detalle    = array(
                    'evento_codigo'                     => $rowMSSQL00['evento_codigo'],
                    'evento_orden'                      => $rowMSSQL00['evento_orden'],
                    'evento_nombre'                     => trim(strtoupper(strtolower($rowMSSQL00['evento_nombre']))),
                    'evento_fecha_inicio_1'             => $rowMSSQL00['evento_fecha_inicio'],
                    'evento_fecha_inicio_2'             => date("d/m/Y", strtotime($rowMSSQL00['evento_fecha_inicio'])),
                    'evento_fecha_fin_1'                => $rowMSSQL00['evento_fecha_fin'],
                    'evento_fecha_fin_2'                => date("d/m/Y", strtotime($rowMSSQL00['evento_fecha_fin'])),
                    'evento_observacion'                => trim(strtoupper(strtolower($rowMSSQL00['evento_observacion']))),

                    'auditoria_usuario'                 => trim(strtoupper(strtolower($rowMSSQL00['auditoria_usuario']))),
                    'auditoria_fecha_hora'              => date("d/m/Y", strtotime($rowMSSQL00['auditoria_fecha_hora'])),
                    'auditoria_ip'                      => trim(strtoupper(strtolower($rowMSSQL00['auditoria_ip']))),

                    'tipo_estado_codigo'                => $rowMSSQL00['tipo_estado_codigo'],
                    'tipo_estado_ingles'                => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_ingles']))),
                    'tipo_estado_castellano'            => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_castellano']))),
                    'tipo_estado_portugues'             => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_portugues']))),
                    'tipo_estado_parametro'             => $rowMSSQL00['tipo_estado_parametro'],
                    'tipo_estado_icono'                 => trim(strtolower($rowMSSQL00['tipo_estado_icono'])),
                    'tipo_estado_css'                   => trim(strtolower($rowMSSQL00['tipo_estado_css'])),

                    'tipo_evento_codigo'                => $rowMSSQL00['tipo_evento_codigo'],
                    'tipo_evento_ingles'                => trim(strtoupper(strtolower($rowMSSQL00['tipo_evento_ingles']))),
                    'tipo_evento_castellano'            => trim(strtoupper(strtolower($rowMSSQL00['tipo_evento_castellano']))),
                    'tipo_evento_portugues'             => trim(strtoupper(strtolower($rowMSSQL00['tipo_evento_portugues']))),
                    'tipo_evento_parametro'             => $rowMSSQL00['tipo_evento_parametro'],
                    'tipo_evento_icono'                 => trim(strtolower($rowMSSQL00['tipo_evento_icono'])),
                    'tipo_evento_css'                   => trim(strtolower($rowMSSQL00['tipo_evento_css'])),

                    'localidad_ciudad_codigo'           => $rowMSSQL00['localidad_ciudad_codigo'],
                    'localidad_ciudad_orden'            => $rowMSSQL00['localidad_ciudad_orden'],
                    'localidad_ciudad_nombre'           => trim(strtoupper(strtolower($rowMSSQL00['localidad_ciudad_nombre']))),
                    'localidad_ciudad_observacion'      => trim(strtolower($rowMSSQL00['localidad_ciudad_observacion'])),

                    'localidad_pais_codigo'             => $rowMSSQL00['localidad_pais_codigo'],
                    'localidad_pais_orden'              => $rowMSSQL00['localidad_pais_orden'],
                    'localidad_pais_nombre'             => trim(strtoupper(strtolower($rowMSSQL00['localidad_pais_nombre']))),
                    'localidad_pais_path'               => trim(strtolower($rowMSSQL00['localidad_pais_path'])),
                    'localidad_pais_iso_char2'          => trim(strtoupper(strtolower($rowMSSQL00['localidad_pais_iso_char2']))),
                    'localidad_pais_iso_char3'          => trim(strtoupper(strtolower($rowMSSQL00['localidad_pais_iso_char3']))),
                    'localidad_pais_iso_num3'           => trim(strtoupper(strtolower($rowMSSQL00['localidad_pais_iso_num3']))),
                    'localidad_pais_observacion'        => trim(strtoupper(strtolower($rowMSSQL00['localidad_pais_observacion'])))
                );

                $result[]   = $detalle;
            }

            if (isset($result)){
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } else {
                $detalle    = array(
                    'evento_codigo'                     => '',
                    'evento_orden'                      => '',
                    'evento_nombre'                     => '',
                    'evento_fecha_inicio_1'             => '',
                    'evento_fecha_inicio_2'             => '',
                    'evento_fecha_fin_1'                => '',
                    'evento_fecha_fin_2'                => '',
                    'evento_observacion'                => '',

                    'auditoria_usuario'                 => '',
                    'auditoria_fecha_hora'              => '',
                    'auditoria_ip'                      => '',

                    'tipo_estado_codigo'                => '',
                    'tipo_estado_ingles'                => '',
                    'tipo_estado_castellano'            => '',
                    'tipo_estado_portugues'             => '',
                    'tipo_estado_parametro'             => '',
                    'tipo_estado_icono'                 => '',
                    'tipo_estado_css'                   => '',

                    'tipo_evento_codigo'                => '',
                    'tipo_evento_ingles'                => '',
                    'tipo_evento_castellano'            => '',
                    'tipo_evento_portugues'             => '',
                    'tipo_evento_parametro'             => '',
                    'tipo_evento_icono'                 => '',
                    'tipo_evento_css'                   => '',
                    
                    'localidad_ciudad_codigo'           => '',
                    'localidad_ciudad_orden'            => '',
                    'localidad_ciudad_nombre'           => '',
                    'localidad_ciudad_observacion'      => '',

                    'localidad_pais_codigo'             => '',
                    'localidad_pais_orden'              => '',
                    'localidad_pais_nombre'             => '',
                    'localidad_pais_path'               => '',
                    'localidad_pais_iso_char2'          => '',
                    'localidad_pais_iso_char3'          => '',
                    'localidad_pais_iso_num3'           => '',
                    'localidad_pais_observacion'        => ''
                );

                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }

            $stmtMSSQL00->closeCursor();
            $stmtMSSQL00 = null;
        } catch (PDOException $e) {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v2/400/solicitud', function($request) {
        require __DIR__.'/../src/connect.php';

        $sql00  = "SELECT
            a.SOLFICCOD         AS          solicitud_codigo,
            a.SOLFICPER         AS          solicitud_periodo,
            a.SOLFICMOT         AS          solicitud_motivo,
            a.SOLFICPAS         AS          solicitud_pasaje,
            a.SOLFICHOS         AS          solicitud_hospedaje,
            a.SOLFICTRA         AS          solicitud_traslado,
            a.SOLFICFEC         AS          solicitud_fecha_carga,
            a.SOLFICSCC         AS          solicitud_sap_centro_costo,
            a.SOLFICTCA         AS          solicitud_tarea_cantidad,
            a.SOLFICTRE         AS          solicitud_tarea_resuelta,
            a.SOLFICOBS         AS          solicitud_observacion,

            a.SOLFICAUS         AS          auditoria_usuario,
            a.SOLFICAFH         AS          auditoria_fecha_hora,
            a.SOLFICAIP         AS          auditoria_ip,

            b.CODE              AS          tipo_gerencia_codigo,
            b.NAME              AS          tipo_gerencia_codigo_nombre,
            b.U_CODIGO          AS          tipo_gerencia_codigo_referencia,
            b.U_NOMBRE          AS          tipo_gerencia_nombre,

            c.CODE              AS          tipo_departamento_codigo,
            c.NAME              AS          tipo_departamento_codigo_nombre,
            c.U_CODIGO          AS          tipo_departamento_codigo_referencia,
            c.U_NOMBRE          AS          tipo_departamento_nombre,

            d.CODE              AS          tipo_jefatura_codigo_referencia,
            d.NAME              AS          tipo_jefatura_codigo_nombre,
            d.U_CODIGO          AS          tipo_jefatura_codigo,
            d.U_NOMBRE          AS          tipo_jefatura_nombre,

            e.CODE              AS          tipo_cargo_codigo_referencia,
            e.NAME              AS          tipo_cargo_codigo_nombre,
            e.U_CODIGO          AS          tipo_cargo_codigo,
            e.U_NOMBRE          AS          tipo_cargo_nombre,

            f.EVEFICCOD         AS          evento_codigo,
            f.EVEFICORD         AS          evento_orden,
            f.EVEFICNOM         AS          evento_nombre,
            f.EVEFICFVI         AS          evento_fecha_inicio,
            f.EVEFICFVF         AS          evento_fecha_fin,
            f.EVEFICOBS         AS          evento_observacion,

            g.WRKFICCOD         AS          workflow_codigo,
            g.WRKFICORD         AS          workflow_orden,
            g.WRKFICNOM         AS          workflow_tarea,

            h.DOMFICCOD         AS          estado_anterior_codigo,
            h.DOMFICNOI         AS          estado_anterior_ingles,
            h.DOMFICNOC         AS          estado_anterior_castellano,
            h.DOMFICNOP         AS          estado_anterior_portugues,
            h.DOMFICPAR         AS          estado_anterior_parametro,
            h.DOMFICICO         AS          estado_anterior_icono,
            h.DOMFICCSS         AS          estado_anterior_css,

            i.DOMFICCOD         AS          estado_actual_codigo,
            i.DOMFICNOI         AS          estado_actual_ingles,
            i.DOMFICNOC         AS          estado_actual_castellano,
            i.DOMFICNOP         AS          estado_actual_portugues,
            i.DOMFICPAR         AS          estado_actual_parametro,
            i.DOMFICICO         AS          estado_actual_icono,
            i.DOMFICCSS         AS          estado_actual_css,

            j.WRKDETCOD         AS          workflow_detalle_codigo,
            j.WRKDETORD         AS          workflow_detalle_orden,
            j.WRKDETTCC         AS          workflow_detalle_cargo,
            j.WRKDETHOR         AS          workflow_detalle_hora,
            j.WRKDETNOM         AS          workflow_detalle_tarea,

            k.DOMFICCOD         AS          tipo_prioridad_codigo,
            k.DOMFICNOI         AS          tipo_prioridad_ingles,
            k.DOMFICNOC         AS          tipo_prioridad_castellano,
            k.DOMFICNOP         AS          tipo_prioridad_portugues,
            k.DOMFICPAR         AS          tipo_prioridad_parametro,
            k.DOMFICICO         AS          tipo_prioridad_icono,
            k.DOMFICCSS         AS          tipo_prioridad_css,

            l1.NombreEmpleado   AS          solicitud_solicitante_nombre,
            a.SOLFICDNS         AS          solicitud_solicitante_documento,
            l2.NombreEmpleado   AS          solicitud_jefatura_nombre,
            a.SOLFICDNJ         AS          solicitud_jefatura_documento,
            l3.NombreEmpleado   AS          solicitud_ejecutivo_nombre,
            a.SOLFICDNE         AS          solicitud_ejecutivo_documento,
            l4.NombreEmpleado   AS          solicitud_proveedor_nombre,
            a.SOLFICDNP         AS          solicitud_proveedor_documento

            FROM [via].[SOLFIC] a
            INNER JOIN [CSF].[dbo].[@A1A_TIGE] b ON a.SOLFICGEC = b.U_CODIGO
            INNER JOIN [CSF].[dbo].[@A1A_TIDE] c ON a.SOLFICDEC = c.U_CODIGO
            INNER JOIN [CSF].[dbo].[@A1A_TICA] d ON a.SOLFICJEC = d.U_CODIGO
            INNER JOIN [CSF].[dbo].[@A1A_TICA] e ON a.SOLFICCAC = e.U_CODIGO
            LEFT OUTER JOIN [via].[EVEFIC] f ON a.SOLFICEVC = f.EVEFICCOD
            LEFT OUTER JOIN [wrk].[WRKFIC] g ON a.SOLFICWFC = g.WRKFICCOD
            LEFT OUTER JOIN [adm].[DOMFIC] h ON a.SOLFICEAC = h.DOMFICCOD
            LEFT OUTER JOIN [adm].[DOMFIC] i ON a.SOLFICECC = i.DOMFICCOD
            LEFT OUTER JOIN [wrk].[WRKDET] j ON a.SOLFICWFC = j.WRKDETWFC AND a.SOLFICECC = j.WRKDETEAC
            LEFT OUTER JOIN [adm].[DOMFIC] k ON j.WRKDETTPC = k.DOMFICCOD
            LEFT OUTER JOIN [CSF].[dbo].[empleados_AxisONE] l1 ON a.SOLFICDNS COLLATE SQL_Latin1_General_CP1_CI_AS = l1.CedulaEmpleado
            LEFT OUTER JOIN [CSF].[dbo].[empleados_AxisONE] l2 ON a.SOLFICDNJ COLLATE SQL_Latin1_General_CP1_CI_AS = l2.CedulaEmpleado
            LEFT OUTER JOIN [CSF].[dbo].[empleados_AxisONE] l3 ON a.SOLFICDNE COLLATE SQL_Latin1_General_CP1_CI_AS = l3.CedulaEmpleado
            LEFT OUTER JOIN [CSF].[dbo].[empleados_AxisONE] l4 ON a.SOLFICDNP COLLATE SQL_Latin1_General_CP1_CI_AS = l4.CedulaEmpleado

            WHERE j.WRKDETCOD = (SELECT MIN(j1.WRKDETCOD) FROM [wrk].[WRKDET] j1 WHERE j1.WRKDETWFC = a.SOLFICWFC AND j1.WRKDETEAC = a.SOLFICECC)
            
            ORDER BY a.SOLFICCOD DESC";

        try {
            $connMSSQL  = getConnectionMSSQLv2();
            $stmtMSSQL00= $connMSSQL->prepare($sql00);
            $stmtMSSQL00->execute();

            while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                if(!empty($rowMSSQL00['solicitud_fecha_carga'])){
                    $solicitud_fecha_carga_2    = date("d/m/Y", strtotime($rowMSSQL00['solicitud_fecha_carga']));
                } else {
                    $solicitud_fecha_carga_2    = '';
                }

                $detalle = array(                    
                    'solicitud_codigo'                      => $rowMSSQL00['solicitud_codigo'],
                    'solicitud_periodo'                     => $rowMSSQL00['solicitud_periodo'],
                    'solicitud_motivo'                      => trim(strtoupper(strtolower($rowMSSQL00['solicitud_motivo']))),
                    'solicitud_pasaje'                      => trim(strtoupper(strtolower($rowMSSQL00['solicitud_pasaje']))),
                    'solicitud_hospedaje'                   => trim(strtoupper(strtolower($rowMSSQL00['solicitud_hospedaje']))),
                    'solicitud_traslado'                    => trim(strtoupper(strtolower($rowMSSQL00['solicitud_traslado']))),
                    'solicitud_fecha_carga_1'               => $rowMSSQL00['solicitud_fecha_carga'],
                    'solicitud_fecha_carga_2'               => $solicitud_fecha_carga_2,
                    'solicitud_sap_centro_costo'            => trim(strtoupper(strtolower($rowMSSQL00['solicitud_sap_centro_costo']))),
                    'solicitud_tarea_cantidad'              => $rowMSSQL00['solicitud_tarea_cantidad'],
                    'solicitud_tarea_resuelta'              => $rowMSSQL00['solicitud_tarea_resuelta'],
                    'solicitud_tarea_porcentaje'            => number_format((($rowMSSQL00['solicitud_tarea_resuelta'] * 100) / $rowMSSQL00['solicitud_tarea_cantidad']), 2, '.', ''),
                    'solicitud_solicitante_nombre'          => trim(strtoupper(strtolower($rowMSSQL00['solicitud_solicitante_nombre']))),
                    'solicitud_solicitante_documento'       => trim(strtoupper(strtolower($rowMSSQL00['solicitud_solicitante_documento']))),
                    'solicitud_jefatura_nombre'             => trim(strtoupper(strtolower($rowMSSQL00['solicitud_jefatura_nombre']))),
                    'solicitud_jefatura_documento'          => trim(strtoupper(strtolower($rowMSSQL00['solicitud_jefatura_documento']))),
                    'solicitud_ejecutivo_nombre'            => trim(strtoupper(strtolower($rowMSSQL00['solicitud_ejecutivo_nombre']))),
                    'solicitud_ejecutivo_documento'         => trim(strtoupper(strtolower($rowMSSQL00['solicitud_ejecutivo_documento']))),
                    'solicitud_proveedor_nombre'            => trim(strtoupper(strtolower($rowMSSQL00['solicitud_proveedor_nombre']))),
                    'solicitud_proveedor_documento'         => trim(strtoupper(strtolower($rowMSSQL00['solicitud_proveedor_documento']))),
                    'solicitud_observacion'                 => trim(strtoupper(strtolower($rowMSSQL00['solicitud_observacion']))),

                    'auditoria_usuario'                     => trim(strtoupper(strtolower($rowMSSQL00['auditoria_usuario']))),
                    'auditoria_fecha_hora'                  => date("d/m/Y", strtotime($rowMSSQL00['auditoria_fecha_hora'])),
                    'auditoria_ip'                          => trim(strtoupper(strtolower($rowMSSQL00['auditoria_ip']))),

                    'tipo_gerencia_codigo'                  => $rowMSSQL00['tipo_gerencia_codigo'],
                    'tipo_gerencia_codigo_nombre'           => $rowMSSQL00['tipo_gerencia_codigo_nombre'],
                    'tipo_gerencia_codigo_referencia'       => $rowMSSQL00['tipo_gerencia_codigo_referencia'],
                    'tipo_gerencia_nombre'                  => trim(strtoupper(strtolower($rowMSSQL00['tipo_gerencia_nombre']))),

                    'tipo_departamento_codigo'              => $rowMSSQL00['tipo_departamento_codigo'],
                    'tipo_departamento_codigo_nombre'       => $rowMSSQL00['tipo_departamento_codigo_nombre'],
                    'tipo_departamento_codigo_referencia'   => $rowMSSQL00['tipo_departamento_codigo_referencia'],
                    'tipo_departamento_nombre'              => trim(strtoupper(strtolower($rowMSSQL00['tipo_departamento_nombre']))),
                    
                    'tipo_jefatura_codigo'                  => $rowMSSQL00['tipo_jefatura_codigo'],
                    'tipo_jefatura_codigo_nombre'           => $rowMSSQL00['tipo_jefatura_codigo_nombre'],
                    'tipo_jefatura_codigo_referencia'       => $rowMSSQL00['tipo_jefatura_codigo_referencia'],
                    'tipo_jefatura_nombre'                  => trim(strtoupper(strtolower($rowMSSQL00['tipo_jefatura_nombre']))),

                    'tipo_cargo_codigo'                     => $rowMSSQL00['tipo_cargo_codigo'],
                    'tipo_cargo_codigo_nombre'              => $rowMSSQL00['tipo_cargo_codigo_nombre'],
                    'tipo_cargo_codigo_referencia'          => $rowMSSQL00['tipo_cargo_codigo_referencia'],
                    'tipo_cargo_nombre'                     => trim(strtoupper(strtolower($rowMSSQL00['tipo_cargo_nombre']))),

                    'evento_codigo'                         => $rowMSSQL00['evento_codigo'],
                    'evento_orden'                          => $rowMSSQL00['evento_orden'],
                    'evento_nombre'                         => trim(strtoupper(strtolower($rowMSSQL00['evento_nombre']))),
                    'evento_fecha_inicio_1'                 => $rowMSSQL00['evento_fecha_inicio'],
                    'evento_fecha_inicio_2'                 => date("d/m/Y", strtotime($rowMSSQL00['evento_fecha_inicio'])),
                    'evento_fecha_fin_1'                    => $rowMSSQL00['evento_fecha_fin'],
                    'evento_fecha_fin_2'                    => date("d/m/Y", strtotime($rowMSSQL00['evento_fecha_fin'])),
                    'evento_observacion'                    => trim(strtoupper(strtolower($rowMSSQL00['evento_observacion']))),

                    'workflow_codigo'                       => $rowMSSQL00['workflow_codigo'],
                    'workflow_orden'                        => $rowMSSQL00['workflow_orden'],
                    'workflow_tarea'                        => trim(strtoupper(strtolower($rowMSSQL00['workflow_tarea']))),

                    'estado_anterior_codigo'                => $rowMSSQL00['estado_anterior_codigo'],
                    'estado_anterior_ingles'                => trim(strtoupper(strtolower($rowMSSQL00['estado_anterior_ingles']))),
                    'estado_anterior_castellano'            => trim(strtoupper(strtolower($rowMSSQL00['estado_anterior_castellano']))),
                    'estado_anterior_portugues'             => trim(strtoupper(strtolower($rowMSSQL00['estado_anterior_portugues']))),
                    'estado_anterior_parametro'             => $rowMSSQL00['estado_anterior_parametro'],
                    'estado_anterior_icono'                 => trim(strtolower($rowMSSQL00['estado_anterior_icono'])),
                    'estado_anterior_css'                   => trim(strtolower($rowMSSQL00['estado_anterior_css'])),

                    'estado_actual_codigo'                  => $rowMSSQL00['estado_actual_codigo'],
                    'estado_actual_ingles'                  => trim(strtoupper(strtolower($rowMSSQL00['estado_actual_ingles']))),
                    'estado_actual_castellano'              => trim(strtoupper(strtolower($rowMSSQL00['estado_actual_castellano']))),
                    'estado_actual_portugues'               => trim(strtoupper(strtolower($rowMSSQL00['estado_actual_portugues']))),
                    'estado_actual_parametro'               => $rowMSSQL00['estado_actual_parametro'],
                    'estado_actual_icono'                   => trim(strtolower($rowMSSQL00['estado_actual_icono'])),
                    'estado_actual_css'                     => trim(strtolower($rowMSSQL00['estado_actual_css'])),

                    'workflow_detalle_codigo'               => $rowMSSQL00['workflow_detalle_codigo'],
                    'workflow_detalle_orden'                => $rowMSSQL00['workflow_detalle_orden'],
                    'workflow_detalle_cargo'                => $rowMSSQL00['workflow_detalle_cargo'],
                    'workflow_detalle_hora'                 => trim(strtoupper(strtolower($rowMSSQL00['workflow_detalle_hora']))),
                    'workflow_detalle_tarea'                => trim(strtoupper(strtolower($rowMSSQL00['workflow_detalle_tarea']))),

                    'tipo_prioridad_codigo'                 => $rowMSSQL00['tipo_prioridad_codigo'],
                    'tipo_prioridad_ingles'                 => trim(strtoupper(strtolower($rowMSSQL00['tipo_prioridad_ingles']))),
                    'tipo_prioridad_castellano'             => trim(strtoupper(strtolower($rowMSSQL00['tipo_prioridad_castellano']))),
                    'tipo_prioridad_portugues'              => trim(strtoupper(strtolower($rowMSSQL00['tipo_prioridad_portugues']))),
                    'tipo_prioridad_parametro'              => $rowMSSQL00['tipo_prioridad_parametro'],
                    'tipo_prioridad_icono'                  => trim(strtolower($rowMSSQL00['tipo_prioridad_icono'])),
                    'tipo_prioridad_css'                    => trim(strtolower($rowMSSQL00['tipo_prioridad_css']))
                );

                $result[]   = $detalle;
            }

            if (isset($result)){
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } else {
                $detalle    = array(
                    'solicitud_codigo'                      => '',
                    'solicitud_periodo'                     => '',
                    'solicitud_motivo'                      => '',
                    'solicitud_pasaje'                      => '',
                    'solicitud_hospedaje'                   => '',
                    'solicitud_traslado'                    => '',
                    'solicitud_fecha_carga_1'               => '',
                    'solicitud_fecha_carga_2'               => '',
                    'solicitud_sap_centro_costo'            => '',
                    'solicitud_tarea_cantidad'              => '',
                    'solicitud_tarea_resuelta'              => '',
                    'solicitud_tarea_porcentaje'            => '',
                    'solicitud_solicitante_nombre'          => '',
                    'solicitud_solicitante_documento'       => '',
                    'solicitud_jefatura_nombre'             => '',
                    'solicitud_jefatura_documento'          => '',
                    'solicitud_ejecutivo_nombre'            => '',
                    'solicitud_ejecutivo_documento'         => '',
                    'solicitud_proveedor_nombre'            => '',
                    'solicitud_proveedor_documento'         => '',
                    'solicitud_observacion'                 => '',

                    'auditoria_usuario'                     => '',
                    'auditoria_fecha_hora'                  => '',
                    'auditoria_ip'                          => '',

                    'tipo_gerencia_codigo'                  => '',
                    'tipo_gerencia_codigo_nombre'           => '',
                    'tipo_gerencia_codigo_referencia'       => '',
                    'tipo_gerencia_nombre'                  => '',

                    'tipo_departamento_codigo'              => '',
                    'tipo_departamento_codigo_nombre'       => '',
                    'tipo_departamento_codigo_referencia'   => '',
                    'tipo_departamento_nombre'              => '',
                    
                    'tipo_jefatura_codigo'                  => '',
                    'tipo_jefatura_codigo_nombre'           => '',
                    'tipo_jefatura_codigo_referencia'       => '',
                    'tipo_jefatura_nombre'                  => '',

                    'tipo_cargo_codigo'                     => '',
                    'tipo_cargo_codigo_nombre'              => '',
                    'tipo_cargo_codigo_referencia'          => '',
                    'tipo_cargo_nombre'                     => '',

                    'evento_codigo'                         => '',
                    'evento_orden'                          => '',
                    'evento_nombre'                         => '',
                    'evento_fecha_inicio_1'                 => '',
                    'evento_fecha_inicio_2'                 => '',
                    'evento_fecha_fin_1'                    => '',
                    'evento_fecha_fin_2'                    => '',
                    'evento_observacion'                    => '',

                    'workflow_codigo'                       => '',
                    'workflow_orden'                        => '',
                    'workflow_tarea'                        => '',
                    
                    'estado_anterior_codigo'                => '',
                    'estado_anterior_ingles'                => '',
                    'estado_anterior_castellano'            => '',
                    'estado_anterior_portugues'             => '',
                    'estado_anterior_parametro'             => '',
                    'estado_anterior_icono'                 => '',
                    'estado_anterior_css'                   => '',

                    'estado_actual_codigo'                  => '',
                    'estado_actual_ingles'                  => '',
                    'estado_actual_castellano'              => '',
                    'estado_actual_portugues'               => '',
                    'estado_actual_parametro'               => '',
                    'estado_actual_icono'                   => '',
                    'estado_actual_css'                     => '',

                    'workflow_detalle_codigo'               => '',
                    'workflow_detalle_orden'                => '',
                    'workflow_detalle_cargo'                => '',
                    'workflow_detalle_hora'                 => '',
                    'workflow_detalle_tarea'                => '',

                    'tipo_prioridad_codigo'                 => '',
                    'tipo_prioridad_ingles'                 => '',
                    'tipo_prioridad_castellano'             => '',
                    'tipo_prioridad_portugues'              => '',
                    'tipo_prioridad_parametro'              => '',
                    'tipo_prioridad_icono'                  => '',
                    'tipo_prioridad_css'                    => ''
                );

                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }

            $stmtMSSQL00->closeCursor();
            $stmtMSSQL00 = null;
        } catch (PDOException $e) {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v2/400/solicitud/codigo/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val01  = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
                a.SOLFICCOD         AS          solicitud_codigo,
                a.SOLFICPER         AS          solicitud_periodo,
                a.SOLFICMOT         AS          solicitud_motivo,
                a.SOLFICPAS         AS          solicitud_pasaje,
                a.SOLFICHOS         AS          solicitud_hospedaje,
                a.SOLFICTRA         AS          solicitud_traslado,
                a.SOLFICFEC         AS          solicitud_fecha_carga,
                a.SOLFICSCC         AS          solicitud_sap_centro_costo,
                a.SOLFICTCA         AS          solicitud_tarea_cantidad,
                a.SOLFICTRE         AS          solicitud_tarea_resuelta,
                a.SOLFICOBS         AS          solicitud_observacion,

                a.SOLFICAUS         AS          auditoria_usuario,
                a.SOLFICAFH         AS          auditoria_fecha_hora,
                a.SOLFICAIP         AS          auditoria_ip,

                b.CODE              AS          tipo_gerencia_codigo,
                b.NAME              AS          tipo_gerencia_codigo_nombre,
                b.U_CODIGO          AS          tipo_gerencia_codigo_referencia,
                b.U_NOMBRE          AS          tipo_gerencia_nombre,

                c.CODE              AS          tipo_departamento_codigo,
                c.NAME              AS          tipo_departamento_codigo_nombre,
                c.U_CODIGO          AS          tipo_departamento_codigo_referencia,
                c.U_NOMBRE          AS          tipo_departamento_nombre,

                d.CODE              AS          tipo_jefatura_codigo_referencia,
                d.NAME              AS          tipo_jefatura_codigo_nombre,
                d.U_CODIGO          AS          tipo_jefatura_codigo,
                d.U_NOMBRE          AS          tipo_jefatura_nombre,

                e.CODE              AS          tipo_cargo_codigo_referencia,
                e.NAME              AS          tipo_cargo_codigo_nombre,
                e.U_CODIGO          AS          tipo_cargo_codigo,
                e.U_NOMBRE          AS          tipo_cargo_nombre,

                f.EVEFICCOD         AS          evento_codigo,
                f.EVEFICORD         AS          evento_orden,
                f.EVEFICNOM         AS          evento_nombre,
                f.EVEFICFVI         AS          evento_fecha_inicio,
                f.EVEFICFVF         AS          evento_fecha_fin,
                f.EVEFICOBS         AS          evento_observacion,

                g.WRKFICCOD         AS          workflow_codigo,
                g.WRKFICORD         AS          workflow_orden,
                g.WRKFICNOM         AS          workflow_tarea,

                h.DOMFICCOD         AS          estado_anterior_codigo,
                h.DOMFICNOI         AS          estado_anterior_ingles,
                h.DOMFICNOC         AS          estado_anterior_castellano,
                h.DOMFICNOP         AS          estado_anterior_portugues,
                h.DOMFICPAR         AS          estado_anterior_parametro,
                h.DOMFICICO         AS          estado_anterior_icono,
                h.DOMFICCSS         AS          estado_anterior_css,

                i.DOMFICCOD         AS          estado_actual_codigo,
                i.DOMFICNOI         AS          estado_actual_ingles,
                i.DOMFICNOC         AS          estado_actual_castellano,
                i.DOMFICNOP         AS          estado_actual_portugues,
                i.DOMFICPAR         AS          estado_actual_parametro,
                i.DOMFICICO         AS          estado_actual_icono,
                i.DOMFICCSS         AS          estado_actual_css,

                j.WRKDETCOD         AS          workflow_detalle_codigo,
                j.WRKDETORD         AS          workflow_detalle_orden,
                j.WRKDETTCC         AS          workflow_detalle_cargo,
                j.WRKDETHOR         AS          workflow_detalle_hora,
                j.WRKDETNOM         AS          workflow_detalle_tarea,

                k.DOMFICCOD         AS          tipo_prioridad_codigo,
                k.DOMFICNOI         AS          tipo_prioridad_ingles,
                k.DOMFICNOC         AS          tipo_prioridad_castellano,
                k.DOMFICNOP         AS          tipo_prioridad_portugues,
                k.DOMFICPAR         AS          tipo_prioridad_parametro,
                k.DOMFICICO         AS          tipo_prioridad_icono,
                k.DOMFICCSS         AS          tipo_prioridad_css,

                l1.NombreEmpleado   AS          solicitud_solicitante_nombre,
                a.SOLFICDNS         AS          solicitud_solicitante_documento,
                l2.NombreEmpleado   AS          solicitud_jefatura_nombre,
                a.SOLFICDNJ         AS          solicitud_jefatura_documento,
                l3.NombreEmpleado   AS          solicitud_ejecutivo_nombre,
                a.SOLFICDNE         AS          solicitud_ejecutivo_documento,
                l4.NombreEmpleado   AS          solicitud_proveedor_nombre,
                a.SOLFICDNP         AS          solicitud_proveedor_documento

                FROM [via].[SOLFIC] a
                INNER JOIN [CSF].[dbo].[@A1A_TIGE] b ON a.SOLFICGEC = b.U_CODIGO
                INNER JOIN [CSF].[dbo].[@A1A_TIDE] c ON a.SOLFICDEC = c.U_CODIGO
                INNER JOIN [CSF].[dbo].[@A1A_TICA] d ON a.SOLFICJEC = d.U_CODIGO
                INNER JOIN [CSF].[dbo].[@A1A_TICA] e ON a.SOLFICCAC = e.U_CODIGO
                LEFT OUTER JOIN [via].[EVEFIC] f ON a.SOLFICEVC = f.EVEFICCOD
                LEFT OUTER JOIN [wrk].[WRKFIC] g ON a.SOLFICWFC = g.WRKFICCOD
                LEFT OUTER JOIN [adm].[DOMFIC] h ON a.SOLFICEAC = h.DOMFICCOD
                LEFT OUTER JOIN [adm].[DOMFIC] i ON a.SOLFICECC = i.DOMFICCOD
                LEFT OUTER JOIN [wrk].[WRKDET] j ON a.SOLFICWFC = j.WRKDETWFC AND a.SOLFICEAC = j.WRKDETEAC AND a.SOLFICECC = j.WRKDETECC
                LEFT OUTER JOIN [adm].[DOMFIC] k ON j.WRKDETTPC = k.DOMFICCOD
                LEFT OUTER JOIN [CSF].[dbo].[empleados_AxisONE] l1 ON a.SOLFICDNS COLLATE SQL_Latin1_General_CP1_CI_AS = l1.CedulaEmpleado
                LEFT OUTER JOIN [CSF].[dbo].[empleados_AxisONE] l2 ON a.SOLFICDNJ COLLATE SQL_Latin1_General_CP1_CI_AS = l2.CedulaEmpleado
                LEFT OUTER JOIN [CSF].[dbo].[empleados_AxisONE] l3 ON a.SOLFICDNE COLLATE SQL_Latin1_General_CP1_CI_AS = l3.CedulaEmpleado
                LEFT OUTER JOIN [CSF].[dbo].[empleados_AxisONE] l4 ON a.SOLFICDNP COLLATE SQL_Latin1_General_CP1_CI_AS = l4.CedulaEmpleado

                WHERE a.SOLFICCOD = ?
                
                ORDER BY a.SOLFICCOD DESC";

            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val01]);

                while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                    if(!empty($rowMSSQL00['solicitud_fecha_carga'])){
                        $solicitud_fecha_carga_2    = date("d/m/Y", strtotime($rowMSSQL00['solicitud_fecha_carga']));
                    } else {
                        $solicitud_fecha_carga_2    = '';
                    }
    
                    $detalle = array(                    
                        'solicitud_codigo'                      => $rowMSSQL00['solicitud_codigo'],
                        'solicitud_periodo'                     => $rowMSSQL00['solicitud_periodo'],
                        'solicitud_motivo'                      => trim(strtoupper(strtolower($rowMSSQL00['solicitud_motivo']))),
                        'solicitud_pasaje'                      => trim(strtoupper(strtolower($rowMSSQL00['solicitud_pasaje']))),
                        'solicitud_hospedaje'                   => trim(strtoupper(strtolower($rowMSSQL00['solicitud_hospedaje']))),
                        'solicitud_traslado'                    => trim(strtoupper(strtolower($rowMSSQL00['solicitud_traslado']))),
                        'solicitud_fecha_carga_1'               => $rowMSSQL00['solicitud_fecha_carga'],
                        'solicitud_fecha_carga_2'               => $solicitud_fecha_carga_2,
                        'solicitud_sap_centro_costo'            => trim(strtoupper(strtolower($rowMSSQL00['solicitud_sap_centro_costo']))),
                        'solicitud_tarea_cantidad'              => $rowMSSQL00['solicitud_tarea_cantidad'],
                        'solicitud_tarea_resuelta'              => $rowMSSQL00['solicitud_tarea_resuelta'],
                        'solicitud_tarea_porcentaje'            => number_format((($rowMSSQL00['solicitud_tarea_resuelta'] * 100) / $rowMSSQL00['solicitud_tarea_cantidad']), 2, '.', ''),
                        'solicitud_solicitante_nombre'          => trim(strtoupper(strtolower($rowMSSQL00['solicitud_solicitante_nombre']))),
                        'solicitud_solicitante_documento'       => trim(strtoupper(strtolower($rowMSSQL00['solicitud_solicitante_documento']))),
                        'solicitud_jefatura_nombre'             => trim(strtoupper(strtolower($rowMSSQL00['solicitud_jefatura_nombre']))),
                        'solicitud_jefatura_documento'          => trim(strtoupper(strtolower($rowMSSQL00['solicitud_jefatura_documento']))),
                        'solicitud_ejecutivo_nombre'            => trim(strtoupper(strtolower($rowMSSQL00['solicitud_ejecutivo_nombre']))),
                        'solicitud_ejecutivo_documento'         => trim(strtoupper(strtolower($rowMSSQL00['solicitud_ejecutivo_documento']))),
                        'solicitud_proveedor_nombre'            => trim(strtoupper(strtolower($rowMSSQL00['solicitud_proveedor_nombre']))),
                        'solicitud_proveedor_documento'         => trim(strtoupper(strtolower($rowMSSQL00['solicitud_proveedor_documento']))),
                        'solicitud_observacion'                 => trim(strtoupper(strtolower($rowMSSQL00['solicitud_observacion']))),
    
                        'auditoria_usuario'                     => trim(strtoupper(strtolower($rowMSSQL00['auditoria_usuario']))),
                        'auditoria_fecha_hora'                  => date("d/m/Y", strtotime($rowMSSQL00['auditoria_fecha_hora'])),
                        'auditoria_ip'                          => trim(strtoupper(strtolower($rowMSSQL00['auditoria_ip']))),
    
                        'tipo_gerencia_codigo'                  => $rowMSSQL00['tipo_gerencia_codigo'],
                        'tipo_gerencia_codigo_nombre'           => $rowMSSQL00['tipo_gerencia_codigo_nombre'],
                        'tipo_gerencia_codigo_referencia'       => $rowMSSQL00['tipo_gerencia_codigo_referencia'],
                        'tipo_gerencia_nombre'                  => trim(strtoupper(strtolower($rowMSSQL00['tipo_gerencia_nombre']))),
    
                        'tipo_departamento_codigo'              => $rowMSSQL00['tipo_departamento_codigo'],
                        'tipo_departamento_codigo_nombre'       => $rowMSSQL00['tipo_departamento_codigo_nombre'],
                        'tipo_departamento_codigo_referencia'   => $rowMSSQL00['tipo_departamento_codigo_referencia'],
                        'tipo_departamento_nombre'              => trim(strtoupper(strtolower($rowMSSQL00['tipo_departamento_nombre']))),
                        
                        'tipo_jefatura_codigo'                  => $rowMSSQL00['tipo_jefatura_codigo'],
                        'tipo_jefatura_codigo_nombre'           => $rowMSSQL00['tipo_jefatura_codigo_nombre'],
                        'tipo_jefatura_codigo_referencia'       => $rowMSSQL00['tipo_jefatura_codigo_referencia'],
                        'tipo_jefatura_nombre'                  => trim(strtoupper(strtolower($rowMSSQL00['tipo_jefatura_nombre']))),
    
                        'tipo_cargo_codigo'                     => $rowMSSQL00['tipo_cargo_codigo'],
                        'tipo_cargo_codigo_nombre'              => $rowMSSQL00['tipo_cargo_codigo_nombre'],
                        'tipo_cargo_codigo_referencia'          => $rowMSSQL00['tipo_cargo_codigo_referencia'],
                        'tipo_cargo_nombre'                     => trim(strtoupper(strtolower($rowMSSQL00['tipo_cargo_nombre']))),
    
                        'evento_codigo'                         => $rowMSSQL00['evento_codigo'],
                        'evento_orden'                          => $rowMSSQL00['evento_orden'],
                        'evento_nombre'                         => trim(strtoupper(strtolower($rowMSSQL00['evento_nombre']))),
                        'evento_fecha_inicio_1'                 => $rowMSSQL00['evento_fecha_inicio'],
                        'evento_fecha_inicio_2'                 => date("d/m/Y", strtotime($rowMSSQL00['evento_fecha_inicio'])),
                        'evento_fecha_fin_1'                    => $rowMSSQL00['evento_fecha_fin'],
                        'evento_fecha_fin_2'                    => date("d/m/Y", strtotime($rowMSSQL00['evento_fecha_fin'])),
                        'evento_observacion'                    => trim(strtoupper(strtolower($rowMSSQL00['evento_observacion']))),
    
                        'workflow_codigo'                       => $rowMSSQL00['workflow_codigo'],
                        'workflow_orden'                        => $rowMSSQL00['workflow_orden'],
                        'workflow_tarea'                        => trim(strtoupper(strtolower($rowMSSQL00['workflow_tarea']))),
    
                        'estado_anterior_codigo'                => $rowMSSQL00['estado_anterior_codigo'],
                        'estado_anterior_ingles'                => trim(strtoupper(strtolower($rowMSSQL00['estado_anterior_ingles']))),
                        'estado_anterior_castellano'            => trim(strtoupper(strtolower($rowMSSQL00['estado_anterior_castellano']))),
                        'estado_anterior_portugues'             => trim(strtoupper(strtolower($rowMSSQL00['estado_anterior_portugues']))),
                        'estado_anterior_parametro'             => $rowMSSQL00['estado_anterior_parametro'],
                        'estado_anterior_icono'                 => trim(strtolower($rowMSSQL00['estado_anterior_icono'])),
                        'estado_anterior_css'                   => trim(strtolower($rowMSSQL00['estado_anterior_css'])),
    
                        'estado_actual_codigo'                  => $rowMSSQL00['estado_actual_codigo'],
                        'estado_actual_ingles'                  => trim(strtoupper(strtolower($rowMSSQL00['estado_actual_ingles']))),
                        'estado_actual_castellano'              => trim(strtoupper(strtolower($rowMSSQL00['estado_actual_castellano']))),
                        'estado_actual_portugues'               => trim(strtoupper(strtolower($rowMSSQL00['estado_actual_portugues']))),
                        'estado_actual_parametro'               => $rowMSSQL00['estado_actual_parametro'],
                        'estado_actual_icono'                   => trim(strtolower($rowMSSQL00['estado_actual_icono'])),
                        'estado_actual_css'                     => trim(strtolower($rowMSSQL00['estado_actual_css'])),
    
                        'workflow_detalle_codigo'               => $rowMSSQL00['workflow_detalle_codigo'],
                        'workflow_detalle_orden'                => $rowMSSQL00['workflow_detalle_orden'],
                        'workflow_detalle_cargo'                => $rowMSSQL00['workflow_detalle_cargo'],
                        'workflow_detalle_hora'                 => trim(strtoupper(strtolower($rowMSSQL00['workflow_detalle_hora']))),
                        'workflow_detalle_tarea'                => trim(strtoupper(strtolower($rowMSSQL00['workflow_detalle_tarea']))),
    
                        'tipo_prioridad_codigo'                 => $rowMSSQL00['tipo_prioridad_codigo'],
                        'tipo_prioridad_ingles'                 => trim(strtoupper(strtolower($rowMSSQL00['tipo_prioridad_ingles']))),
                        'tipo_prioridad_castellano'             => trim(strtoupper(strtolower($rowMSSQL00['tipo_prioridad_castellano']))),
                        'tipo_prioridad_portugues'              => trim(strtoupper(strtolower($rowMSSQL00['tipo_prioridad_portugues']))),
                        'tipo_prioridad_parametro'              => $rowMSSQL00['tipo_prioridad_parametro'],
                        'tipo_prioridad_icono'                  => trim(strtolower($rowMSSQL00['tipo_prioridad_icono'])),
                        'tipo_prioridad_css'                    => trim(strtolower($rowMSSQL00['tipo_prioridad_css']))
                    );
    
                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle    = array(
                        'solicitud_codigo'                      => '',
                        'solicitud_periodo'                     => '',
                        'solicitud_motivo'                      => '',
                        'solicitud_pasaje'                      => '',
                        'solicitud_hospedaje'                   => '',
                        'solicitud_traslado'                    => '',
                        'solicitud_fecha_carga_1'               => '',
                        'solicitud_fecha_carga_2'               => '',
                        'solicitud_sap_centro_costo'            => '',
                        'solicitud_tarea_cantidad'              => '',
                        'solicitud_tarea_resuelta'              => '',
                        'solicitud_tarea_porcentaje'            => '',
                        'solicitud_solicitante_nombre'          => '',
                        'solicitud_solicitante_documento'       => '',
                        'solicitud_jefatura_nombre'             => '',
                        'solicitud_jefatura_documento'          => '',
                        'solicitud_ejecutivo_nombre'            => '',
                        'solicitud_ejecutivo_documento'         => '',
                        'solicitud_proveedor_nombre'            => '',
                        'solicitud_proveedor_documento'         => '',
                        'solicitud_observacion'                 => '',
    
                        'auditoria_usuario'                     => '',
                        'auditoria_fecha_hora'                  => '',
                        'auditoria_ip'                          => '',
    
                        'tipo_gerencia_codigo'                  => '',
                        'tipo_gerencia_codigo_nombre'           => '',
                        'tipo_gerencia_codigo_referencia'       => '',
                        'tipo_gerencia_nombre'                  => '',
    
                        'tipo_departamento_codigo'              => '',
                        'tipo_departamento_codigo_nombre'       => '',
                        'tipo_departamento_codigo_referencia'   => '',
                        'tipo_departamento_nombre'              => '',
                        
                        'tipo_jefatura_codigo'                  => '',
                        'tipo_jefatura_codigo_nombre'           => '',
                        'tipo_jefatura_codigo_referencia'       => '',
                        'tipo_jefatura_nombre'                  => '',
    
                        'tipo_cargo_codigo'                     => '',
                        'tipo_cargo_codigo_nombre'              => '',
                        'tipo_cargo_codigo_referencia'          => '',
                        'tipo_cargo_nombre'                     => '',
    
                        'evento_codigo'                         => '',
                        'evento_orden'                          => '',
                        'evento_nombre'                         => '',
                        'evento_fecha_inicio_1'                 => '',
                        'evento_fecha_inicio_2'                 => '',
                        'evento_fecha_fin_1'                    => '',
                        'evento_fecha_fin_2'                    => '',
                        'evento_observacion'                    => '',
    
                        'workflow_codigo'                       => '',
                        'workflow_orden'                        => '',
                        'workflow_tarea'                        => '',
                        
                        'estado_anterior_codigo'                => '',
                        'estado_anterior_ingles'                => '',
                        'estado_anterior_castellano'            => '',
                        'estado_anterior_portugues'             => '',
                        'estado_anterior_parametro'             => '',
                        'estado_anterior_icono'                 => '',
                        'estado_anterior_css'                   => '',
    
                        'estado_actual_codigo'                  => '',
                        'estado_actual_ingles'                  => '',
                        'estado_actual_castellano'              => '',
                        'estado_actual_portugues'               => '',
                        'estado_actual_parametro'               => '',
                        'estado_actual_icono'                   => '',
                        'estado_actual_css'                     => '',
    
                        'workflow_detalle_codigo'               => '',
                        'workflow_detalle_orden'                => '',
                        'workflow_detalle_cargo'                => '',
                        'workflow_detalle_hora'                 => '',
                        'workflow_detalle_tarea'                => '',
    
                        'tipo_prioridad_codigo'                 => '',
                        'tipo_prioridad_ingles'                 => '',
                        'tipo_prioridad_castellano'             => '',
                        'tipo_prioridad_portugues'              => '',
                        'tipo_prioridad_parametro'              => '',
                        'tipo_prioridad_icono'                  => '',
                        'tipo_prioridad_css'                    => ''
                    );

                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                }

                $stmtMSSQL00->closeCursor();
                $stmtMSSQL00 = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        }  else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v2/400/solicitud/documento/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val01  = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
                a.SOLFICCOD         AS          solicitud_codigo,
                a.SOLFICPER         AS          solicitud_periodo,
                a.SOLFICMOT         AS          solicitud_motivo,
                a.SOLFICPAS         AS          solicitud_pasaje,
                a.SOLFICHOS         AS          solicitud_hospedaje,
                a.SOLFICTRA         AS          solicitud_traslado,
                a.SOLFICFEC         AS          solicitud_fecha_carga,
                a.SOLFICSCC         AS          solicitud_sap_centro_costo,
                a.SOLFICTCA         AS          solicitud_tarea_cantidad,
                a.SOLFICTRE         AS          solicitud_tarea_resuelta,
                a.SOLFICOBS         AS          solicitud_observacion,

                a.SOLFICAUS         AS          auditoria_usuario,
                a.SOLFICAFH         AS          auditoria_fecha_hora,
                a.SOLFICAIP         AS          auditoria_ip,

                b.CODE              AS          tipo_gerencia_codigo,
                b.NAME              AS          tipo_gerencia_codigo_nombre,
                b.U_CODIGO          AS          tipo_gerencia_codigo_referencia,
                b.U_NOMBRE          AS          tipo_gerencia_nombre,

                c.CODE              AS          tipo_departamento_codigo,
                c.NAME              AS          tipo_departamento_codigo_nombre,
                c.U_CODIGO          AS          tipo_departamento_codigo_referencia,
                c.U_NOMBRE          AS          tipo_departamento_nombre,

                d.CODE              AS          tipo_jefatura_codigo_referencia,
                d.NAME              AS          tipo_jefatura_codigo_nombre,
                d.U_CODIGO          AS          tipo_jefatura_codigo,
                d.U_NOMBRE          AS          tipo_jefatura_nombre,

                e.CODE              AS          tipo_cargo_codigo_referencia,
                e.NAME              AS          tipo_cargo_codigo_nombre,
                e.U_CODIGO          AS          tipo_cargo_codigo,
                e.U_NOMBRE          AS          tipo_cargo_nombre,

                f.EVEFICCOD         AS          evento_codigo,
                f.EVEFICORD         AS          evento_orden,
                f.EVEFICNOM         AS          evento_nombre,
                f.EVEFICFVI         AS          evento_fecha_inicio,
                f.EVEFICFVF         AS          evento_fecha_fin,
                f.EVEFICOBS         AS          evento_observacion,

                g.WRKFICCOD         AS          workflow_codigo,
                g.WRKFICORD         AS          workflow_orden,
                g.WRKFICNOM         AS          workflow_tarea,

                h.DOMFICCOD         AS          estado_anterior_codigo,
                h.DOMFICNOI         AS          estado_anterior_ingles,
                h.DOMFICNOC         AS          estado_anterior_castellano,
                h.DOMFICNOP         AS          estado_anterior_portugues,
                h.DOMFICPAR         AS          estado_anterior_parametro,
                h.DOMFICICO         AS          estado_anterior_icono,
                h.DOMFICCSS         AS          estado_anterior_css,

                i.DOMFICCOD         AS          estado_actual_codigo,
                i.DOMFICNOI         AS          estado_actual_ingles,
                i.DOMFICNOC         AS          estado_actual_castellano,
                i.DOMFICNOP         AS          estado_actual_portugues,
                i.DOMFICPAR         AS          estado_actual_parametro,
                i.DOMFICICO         AS          estado_actual_icono,
                i.DOMFICCSS         AS          estado_actual_css,

                j.WRKDETCOD         AS          workflow_detalle_codigo,
                j.WRKDETORD         AS          workflow_detalle_orden,
                j.WRKDETTCC         AS          workflow_detalle_cargo,
                j.WRKDETHOR         AS          workflow_detalle_hora,
                j.WRKDETNOM         AS          workflow_detalle_tarea,

                k.DOMFICCOD         AS          tipo_prioridad_codigo,
                k.DOMFICNOI         AS          tipo_prioridad_ingles,
                k.DOMFICNOC         AS          tipo_prioridad_castellano,
                k.DOMFICNOP         AS          tipo_prioridad_portugues,
                k.DOMFICPAR         AS          tipo_prioridad_parametro,
                k.DOMFICICO         AS          tipo_prioridad_icono,
                k.DOMFICCSS         AS          tipo_prioridad_css,

                l1.NombreEmpleado   AS          solicitud_solicitante_nombre,
                a.SOLFICDNS         AS          solicitud_solicitante_documento,
                l2.NombreEmpleado   AS          solicitud_jefatura_nombre,
                a.SOLFICDNJ         AS          solicitud_jefatura_documento,
                l3.NombreEmpleado   AS          solicitud_ejecutivo_nombre,
                a.SOLFICDNE         AS          solicitud_ejecutivo_documento,
                l4.NombreEmpleado   AS          solicitud_proveedor_nombre,
                a.SOLFICDNP         AS          solicitud_proveedor_documento

                FROM [via].[SOLFIC] a
                INNER JOIN [CSF].[dbo].[@A1A_TIGE] b ON a.SOLFICGEC = b.U_CODIGO
                INNER JOIN [CSF].[dbo].[@A1A_TIDE] c ON a.SOLFICDEC = c.U_CODIGO
                INNER JOIN [CSF].[dbo].[@A1A_TICA] d ON a.SOLFICJEC = d.U_CODIGO
                INNER JOIN [CSF].[dbo].[@A1A_TICA] e ON a.SOLFICCAC = e.U_CODIGO
                LEFT OUTER JOIN [via].[EVEFIC] f ON a.SOLFICEVC = f.EVEFICCOD
                LEFT OUTER JOIN [wrk].[WRKFIC] g ON a.SOLFICWFC = g.WRKFICCOD
                LEFT OUTER JOIN [adm].[DOMFIC] h ON a.SOLFICEAC = h.DOMFICCOD
                LEFT OUTER JOIN [adm].[DOMFIC] i ON a.SOLFICECC = i.DOMFICCOD
                LEFT OUTER JOIN [wrk].[WRKDET] j ON a.SOLFICWFC = j.WRKDETWFC AND a.SOLFICEAC = j.WRKDETEAC AND a.SOLFICECC = j.WRKDETECC
                LEFT OUTER JOIN [adm].[DOMFIC] k ON j.WRKDETTPC = k.DOMFICCOD
                LEFT OUTER JOIN [CSF].[dbo].[empleados_AxisONE] l1 ON a.SOLFICDNS COLLATE SQL_Latin1_General_CP1_CI_AS = l1.CedulaEmpleado
                LEFT OUTER JOIN [CSF].[dbo].[empleados_AxisONE] l2 ON a.SOLFICDNJ COLLATE SQL_Latin1_General_CP1_CI_AS = l2.CedulaEmpleado
                LEFT OUTER JOIN [CSF].[dbo].[empleados_AxisONE] l3 ON a.SOLFICDNE COLLATE SQL_Latin1_General_CP1_CI_AS = l3.CedulaEmpleado
                LEFT OUTER JOIN [CSF].[dbo].[empleados_AxisONE] l4 ON a.SOLFICDNP COLLATE SQL_Latin1_General_CP1_CI_AS = l4.CedulaEmpleado

                WHERE a.SOLFICDNS = ?

                ORDER BY a.SOLFICCOD DESC";

            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val01]);

                while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                    if(!empty($rowMSSQL00['solicitud_fecha_carga'])){
                        $solicitud_fecha_carga_2    = date("d/m/Y", strtotime($rowMSSQL00['solicitud_fecha_carga']));
                    } else {
                        $solicitud_fecha_carga_2    = '';
                    }
    
                    $detalle = array(                    
                        'solicitud_codigo'                      => $rowMSSQL00['solicitud_codigo'],
                        'solicitud_periodo'                     => $rowMSSQL00['solicitud_periodo'],
                        'solicitud_motivo'                      => trim(strtoupper(strtolower($rowMSSQL00['solicitud_motivo']))),
                        'solicitud_pasaje'                      => trim(strtoupper(strtolower($rowMSSQL00['solicitud_pasaje']))),
                        'solicitud_hospedaje'                   => trim(strtoupper(strtolower($rowMSSQL00['solicitud_hospedaje']))),
                        'solicitud_traslado'                    => trim(strtoupper(strtolower($rowMSSQL00['solicitud_traslado']))),
                        'solicitud_fecha_carga_1'               => $rowMSSQL00['solicitud_fecha_carga'],
                        'solicitud_fecha_carga_2'               => $solicitud_fecha_carga_2,
                        'solicitud_sap_centro_costo'            => trim(strtoupper(strtolower($rowMSSQL00['solicitud_sap_centro_costo']))),
                        'solicitud_tarea_cantidad'              => $rowMSSQL00['solicitud_tarea_cantidad'],
                        'solicitud_tarea_resuelta'              => $rowMSSQL00['solicitud_tarea_resuelta'],
                        'solicitud_tarea_porcentaje'            => number_format((($rowMSSQL00['solicitud_tarea_resuelta'] * 100) / $rowMSSQL00['solicitud_tarea_cantidad']), 2, '.', ''),
                        'solicitud_solicitante_nombre'          => trim(strtoupper(strtolower($rowMSSQL00['solicitud_solicitante_nombre']))),
                        'solicitud_solicitante_documento'       => trim(strtoupper(strtolower($rowMSSQL00['solicitud_solicitante_documento']))),
                        'solicitud_jefatura_nombre'             => trim(strtoupper(strtolower($rowMSSQL00['solicitud_jefatura_nombre']))),
                        'solicitud_jefatura_documento'          => trim(strtoupper(strtolower($rowMSSQL00['solicitud_jefatura_documento']))),
                        'solicitud_ejecutivo_nombre'            => trim(strtoupper(strtolower($rowMSSQL00['solicitud_ejecutivo_nombre']))),
                        'solicitud_ejecutivo_documento'         => trim(strtoupper(strtolower($rowMSSQL00['solicitud_ejecutivo_documento']))),
                        'solicitud_proveedor_nombre'            => trim(strtoupper(strtolower($rowMSSQL00['solicitud_proveedor_nombre']))),
                        'solicitud_proveedor_documento'         => trim(strtoupper(strtolower($rowMSSQL00['solicitud_proveedor_documento']))),
                        'solicitud_observacion'                 => trim(strtoupper(strtolower($rowMSSQL00['solicitud_observacion']))),
    
                        'auditoria_usuario'                     => trim(strtoupper(strtolower($rowMSSQL00['auditoria_usuario']))),
                        'auditoria_fecha_hora'                  => date("d/m/Y", strtotime($rowMSSQL00['auditoria_fecha_hora'])),
                        'auditoria_ip'                          => trim(strtoupper(strtolower($rowMSSQL00['auditoria_ip']))),
    
                        'tipo_gerencia_codigo'                  => $rowMSSQL00['tipo_gerencia_codigo'],
                        'tipo_gerencia_codigo_nombre'           => $rowMSSQL00['tipo_gerencia_codigo_nombre'],
                        'tipo_gerencia_codigo_referencia'       => $rowMSSQL00['tipo_gerencia_codigo_referencia'],
                        'tipo_gerencia_nombre'                  => trim(strtoupper(strtolower($rowMSSQL00['tipo_gerencia_nombre']))),
    
                        'tipo_departamento_codigo'              => $rowMSSQL00['tipo_departamento_codigo'],
                        'tipo_departamento_codigo_nombre'       => $rowMSSQL00['tipo_departamento_codigo_nombre'],
                        'tipo_departamento_codigo_referencia'   => $rowMSSQL00['tipo_departamento_codigo_referencia'],
                        'tipo_departamento_nombre'              => trim(strtoupper(strtolower($rowMSSQL00['tipo_departamento_nombre']))),
                        
                        'tipo_jefatura_codigo'                  => $rowMSSQL00['tipo_jefatura_codigo'],
                        'tipo_jefatura_codigo_nombre'           => $rowMSSQL00['tipo_jefatura_codigo_nombre'],
                        'tipo_jefatura_codigo_referencia'       => $rowMSSQL00['tipo_jefatura_codigo_referencia'],
                        'tipo_jefatura_nombre'                  => trim(strtoupper(strtolower($rowMSSQL00['tipo_jefatura_nombre']))),
    
                        'tipo_cargo_codigo'                     => $rowMSSQL00['tipo_cargo_codigo'],
                        'tipo_cargo_codigo_nombre'              => $rowMSSQL00['tipo_cargo_codigo_nombre'],
                        'tipo_cargo_codigo_referencia'          => $rowMSSQL00['tipo_cargo_codigo_referencia'],
                        'tipo_cargo_nombre'                     => trim(strtoupper(strtolower($rowMSSQL00['tipo_cargo_nombre']))),
    
                        'evento_codigo'                         => $rowMSSQL00['evento_codigo'],
                        'evento_orden'                          => $rowMSSQL00['evento_orden'],
                        'evento_nombre'                         => trim(strtoupper(strtolower($rowMSSQL00['evento_nombre']))),
                        'evento_fecha_inicio_1'                 => $rowMSSQL00['evento_fecha_inicio'],
                        'evento_fecha_inicio_2'                 => date("d/m/Y", strtotime($rowMSSQL00['evento_fecha_inicio'])),
                        'evento_fecha_fin_1'                    => $rowMSSQL00['evento_fecha_fin'],
                        'evento_fecha_fin_2'                    => date("d/m/Y", strtotime($rowMSSQL00['evento_fecha_fin'])),
                        'evento_observacion'                    => trim(strtoupper(strtolower($rowMSSQL00['evento_observacion']))),
    
                        'workflow_codigo'                       => $rowMSSQL00['workflow_codigo'],
                        'workflow_orden'                        => $rowMSSQL00['workflow_orden'],
                        'workflow_tarea'                        => trim(strtoupper(strtolower($rowMSSQL00['workflow_tarea']))),
    
                        'estado_anterior_codigo'                => $rowMSSQL00['estado_anterior_codigo'],
                        'estado_anterior_ingles'                => trim(strtoupper(strtolower($rowMSSQL00['estado_anterior_ingles']))),
                        'estado_anterior_castellano'            => trim(strtoupper(strtolower($rowMSSQL00['estado_anterior_castellano']))),
                        'estado_anterior_portugues'             => trim(strtoupper(strtolower($rowMSSQL00['estado_anterior_portugues']))),
                        'estado_anterior_parametro'             => $rowMSSQL00['estado_anterior_parametro'],
                        'estado_anterior_icono'                 => trim(strtolower($rowMSSQL00['estado_anterior_icono'])),
                        'estado_anterior_css'                   => trim(strtolower($rowMSSQL00['estado_anterior_css'])),
    
                        'estado_actual_codigo'                  => $rowMSSQL00['estado_actual_codigo'],
                        'estado_actual_ingles'                  => trim(strtoupper(strtolower($rowMSSQL00['estado_actual_ingles']))),
                        'estado_actual_castellano'              => trim(strtoupper(strtolower($rowMSSQL00['estado_actual_castellano']))),
                        'estado_actual_portugues'               => trim(strtoupper(strtolower($rowMSSQL00['estado_actual_portugues']))),
                        'estado_actual_parametro'               => $rowMSSQL00['estado_actual_parametro'],
                        'estado_actual_icono'                   => trim(strtolower($rowMSSQL00['estado_actual_icono'])),
                        'estado_actual_css'                     => trim(strtolower($rowMSSQL00['estado_actual_css'])),
    
                        'workflow_detalle_codigo'               => $rowMSSQL00['workflow_detalle_codigo'],
                        'workflow_detalle_orden'                => $rowMSSQL00['workflow_detalle_orden'],
                        'workflow_detalle_cargo'                => $rowMSSQL00['workflow_detalle_cargo'],
                        'workflow_detalle_hora'                 => trim(strtoupper(strtolower($rowMSSQL00['workflow_detalle_hora']))),
                        'workflow_detalle_tarea'                => trim(strtoupper(strtolower($rowMSSQL00['workflow_detalle_tarea']))),
    
                        'tipo_prioridad_codigo'                 => $rowMSSQL00['tipo_prioridad_codigo'],
                        'tipo_prioridad_ingles'                 => trim(strtoupper(strtolower($rowMSSQL00['tipo_prioridad_ingles']))),
                        'tipo_prioridad_castellano'             => trim(strtoupper(strtolower($rowMSSQL00['tipo_prioridad_castellano']))),
                        'tipo_prioridad_portugues'              => trim(strtoupper(strtolower($rowMSSQL00['tipo_prioridad_portugues']))),
                        'tipo_prioridad_parametro'              => $rowMSSQL00['tipo_prioridad_parametro'],
                        'tipo_prioridad_icono'                  => trim(strtolower($rowMSSQL00['tipo_prioridad_icono'])),
                        'tipo_prioridad_css'                    => trim(strtolower($rowMSSQL00['tipo_prioridad_css']))
                    );
    
                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle    = array(
                        'solicitud_codigo'                      => '',
                        'solicitud_periodo'                     => '',
                        'solicitud_motivo'                      => '',
                        'solicitud_pasaje'                      => '',
                        'solicitud_hospedaje'                   => '',
                        'solicitud_traslado'                    => '',
                        'solicitud_fecha_carga_1'               => '',
                        'solicitud_fecha_carga_2'               => '',
                        'solicitud_sap_centro_costo'            => '',
                        'solicitud_tarea_cantidad'              => '',
                        'solicitud_tarea_resuelta'              => '',
                        'solicitud_tarea_porcentaje'            => '',
                        'solicitud_solicitante_nombre'          => '',
                        'solicitud_solicitante_documento'       => '',
                        'solicitud_jefatura_nombre'             => '',
                        'solicitud_jefatura_documento'          => '',
                        'solicitud_ejecutivo_nombre'            => '',
                        'solicitud_ejecutivo_documento'         => '',
                        'solicitud_proveedor_nombre'            => '',
                        'solicitud_proveedor_documento'         => '',
                        'solicitud_observacion'                 => '',
    
                        'auditoria_usuario'                     => '',
                        'auditoria_fecha_hora'                  => '',
                        'auditoria_ip'                          => '',
    
                        'tipo_gerencia_codigo'                  => '',
                        'tipo_gerencia_codigo_nombre'           => '',
                        'tipo_gerencia_codigo_referencia'       => '',
                        'tipo_gerencia_nombre'                  => '',
    
                        'tipo_departamento_codigo'              => '',
                        'tipo_departamento_codigo_nombre'       => '',
                        'tipo_departamento_codigo_referencia'   => '',
                        'tipo_departamento_nombre'              => '',
                        
                        'tipo_jefatura_codigo'                  => '',
                        'tipo_jefatura_codigo_nombre'           => '',
                        'tipo_jefatura_codigo_referencia'       => '',
                        'tipo_jefatura_nombre'                  => '',
    
                        'tipo_cargo_codigo'                     => '',
                        'tipo_cargo_codigo_nombre'              => '',
                        'tipo_cargo_codigo_referencia'          => '',
                        'tipo_cargo_nombre'                     => '',
    
                        'evento_codigo'                         => '',
                        'evento_orden'                          => '',
                        'evento_nombre'                         => '',
                        'evento_fecha_inicio_1'                 => '',
                        'evento_fecha_inicio_2'                 => '',
                        'evento_fecha_fin_1'                    => '',
                        'evento_fecha_fin_2'                    => '',
                        'evento_observacion'                    => '',
    
                        'workflow_codigo'                       => '',
                        'workflow_orden'                        => '',
                        'workflow_tarea'                        => '',
                        
                        'estado_anterior_codigo'                => '',
                        'estado_anterior_ingles'                => '',
                        'estado_anterior_castellano'            => '',
                        'estado_anterior_portugues'             => '',
                        'estado_anterior_parametro'             => '',
                        'estado_anterior_icono'                 => '',
                        'estado_anterior_css'                   => '',
    
                        'estado_actual_codigo'                  => '',
                        'estado_actual_ingles'                  => '',
                        'estado_actual_castellano'              => '',
                        'estado_actual_portugues'               => '',
                        'estado_actual_parametro'               => '',
                        'estado_actual_icono'                   => '',
                        'estado_actual_css'                     => '',
    
                        'workflow_detalle_codigo'               => '',
                        'workflow_detalle_orden'                => '',
                        'workflow_detalle_cargo'                => '',
                        'workflow_detalle_hora'                 => '',
                        'workflow_detalle_tarea'                => '',
    
                        'tipo_prioridad_codigo'                 => '',
                        'tipo_prioridad_ingles'                 => '',
                        'tipo_prioridad_castellano'             => '',
                        'tipo_prioridad_portugues'              => '',
                        'tipo_prioridad_parametro'              => '',
                        'tipo_prioridad_icono'                  => '',
                        'tipo_prioridad_css'                    => ''
                    );

                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                }

                $stmtMSSQL00->closeCursor();
                $stmtMSSQL00 = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        }  else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v2/400/solicitud/colaborador/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val01  = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
                a.SOLFICCOD         AS          solicitud_codigo,
                a.SOLFICPER         AS          solicitud_periodo,
                a.SOLFICMOT         AS          solicitud_motivo,
                a.SOLFICPAS         AS          solicitud_pasaje,
                a.SOLFICHOS         AS          solicitud_hospedaje,
                a.SOLFICTRA         AS          solicitud_traslado,
                a.SOLFICFEC         AS          solicitud_fecha_carga,
                a.SOLFICSCC         AS          solicitud_sap_centro_costo,
                a.SOLFICTCA         AS          solicitud_tarea_cantidad,
                a.SOLFICTRE         AS          solicitud_tarea_resuelta,
                a.SOLFICOBS         AS          solicitud_observacion,

                a.SOLFICAUS         AS          auditoria_usuario,
                a.SOLFICAFH         AS          auditoria_fecha_hora,
                a.SOLFICAIP         AS          auditoria_ip,

                b.CODE              AS          tipo_gerencia_codigo,
                b.NAME              AS          tipo_gerencia_codigo_nombre,
                b.U_CODIGO          AS          tipo_gerencia_codigo_referencia,
                b.U_NOMBRE          AS          tipo_gerencia_nombre,

                c.CODE              AS          tipo_departamento_codigo,
                c.NAME              AS          tipo_departamento_codigo_nombre,
                c.U_CODIGO          AS          tipo_departamento_codigo_referencia,
                c.U_NOMBRE          AS          tipo_departamento_nombre,

                d.CODE              AS          tipo_jefatura_codigo_referencia,
                d.NAME              AS          tipo_jefatura_codigo_nombre,
                d.U_CODIGO          AS          tipo_jefatura_codigo,
                d.U_NOMBRE          AS          tipo_jefatura_nombre,

                e.CODE              AS          tipo_cargo_codigo_referencia,
                e.NAME              AS          tipo_cargo_codigo_nombre,
                e.U_CODIGO          AS          tipo_cargo_codigo,
                e.U_NOMBRE          AS          tipo_cargo_nombre,

                f.EVEFICCOD         AS          evento_codigo,
                f.EVEFICORD         AS          evento_orden,
                f.EVEFICNOM         AS          evento_nombre,
                f.EVEFICFVI         AS          evento_fecha_inicio,
                f.EVEFICFVF         AS          evento_fecha_fin,
                f.EVEFICOBS         AS          evento_observacion,

                g.WRKFICCOD         AS          workflow_codigo,
                g.WRKFICORD         AS          workflow_orden,
                g.WRKFICNOM         AS          workflow_tarea,

                h.DOMFICCOD         AS          estado_anterior_codigo,
                h.DOMFICNOI         AS          estado_anterior_ingles,
                h.DOMFICNOC         AS          estado_anterior_castellano,
                h.DOMFICNOP         AS          estado_anterior_portugues,
                h.DOMFICPAR         AS          estado_anterior_parametro,
                h.DOMFICICO         AS          estado_anterior_icono,
                h.DOMFICCSS         AS          estado_anterior_css,

                i.DOMFICCOD         AS          estado_actual_codigo,
                i.DOMFICNOI         AS          estado_actual_ingles,
                i.DOMFICNOC         AS          estado_actual_castellano,
                i.DOMFICNOP         AS          estado_actual_portugues,
                i.DOMFICPAR         AS          estado_actual_parametro,
                i.DOMFICICO         AS          estado_actual_icono,
                i.DOMFICCSS         AS          estado_actual_css,

                j.WRKDETCOD         AS          workflow_detalle_codigo,
                j.WRKDETORD         AS          workflow_detalle_orden,
                j.WRKDETTCC         AS          workflow_detalle_cargo,
                j.WRKDETHOR         AS          workflow_detalle_hora,
                j.WRKDETNOM         AS          workflow_detalle_tarea,

                k.DOMFICCOD         AS          tipo_prioridad_codigo,
                k.DOMFICNOI         AS          tipo_prioridad_ingles,
                k.DOMFICNOC         AS          tipo_prioridad_castellano,
                k.DOMFICNOP         AS          tipo_prioridad_portugues,
                k.DOMFICPAR         AS          tipo_prioridad_parametro,
                k.DOMFICICO         AS          tipo_prioridad_icono,
                k.DOMFICCSS         AS          tipo_prioridad_css,

                l1.NombreEmpleado   AS          solicitud_solicitante_nombre,
                a.SOLFICDNS         AS          solicitud_solicitante_documento,
                l2.NombreEmpleado   AS          solicitud_jefatura_nombre,
                a.SOLFICDNJ         AS          solicitud_jefatura_documento,
                l3.NombreEmpleado   AS          solicitud_ejecutivo_nombre,
                a.SOLFICDNE         AS          solicitud_ejecutivo_documento,
                l4.NombreEmpleado   AS          solicitud_proveedor_nombre,
                a.SOLFICDNP         AS          solicitud_proveedor_documento

                FROM [via].[SOLFIC] a
                INNER JOIN [CSF].[dbo].[@A1A_TIGE] b ON a.SOLFICGEC = b.U_CODIGO
                INNER JOIN [CSF].[dbo].[@A1A_TIDE] c ON a.SOLFICDEC = c.U_CODIGO
                INNER JOIN [CSF].[dbo].[@A1A_TICA] d ON a.SOLFICJEC = d.U_CODIGO
                INNER JOIN [CSF].[dbo].[@A1A_TICA] e ON a.SOLFICCAC = e.U_CODIGO
                LEFT OUTER JOIN [via].[EVEFIC] f ON a.SOLFICEVC = f.EVEFICCOD
                LEFT OUTER JOIN [wrk].[WRKFIC] g ON a.SOLFICWFC = g.WRKFICCOD
                LEFT OUTER JOIN [adm].[DOMFIC] h ON a.SOLFICEAC = h.DOMFICCOD
                LEFT OUTER JOIN [adm].[DOMFIC] i ON a.SOLFICECC = i.DOMFICCOD
                LEFT OUTER JOIN [wrk].[WRKDET] j ON a.SOLFICWFC = j.WRKDETWFC AND a.SOLFICEAC = j.WRKDETEAC AND a.SOLFICECC = j.WRKDETECC
                LEFT OUTER JOIN [adm].[DOMFIC] k ON j.WRKDETTPC = k.DOMFICCOD
                LEFT OUTER JOIN [CSF].[dbo].[empleados_AxisONE] l1 ON a.SOLFICDNS COLLATE SQL_Latin1_General_CP1_CI_AS = l1.CedulaEmpleado
                LEFT OUTER JOIN [CSF].[dbo].[empleados_AxisONE] l2 ON a.SOLFICDNJ COLLATE SQL_Latin1_General_CP1_CI_AS = l2.CedulaEmpleado
                LEFT OUTER JOIN [CSF].[dbo].[empleados_AxisONE] l3 ON a.SOLFICDNE COLLATE SQL_Latin1_General_CP1_CI_AS = l3.CedulaEmpleado
                LEFT OUTER JOIN [CSF].[dbo].[empleados_AxisONE] l4 ON a.SOLFICDNP COLLATE SQL_Latin1_General_CP1_CI_AS = l4.CedulaEmpleado

                WHERE a.SOLFICDNJ = ?

                ORDER BY a.SOLFICCOD DESC";

            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val01]);

                while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                    if(!empty($rowMSSQL00['solicitud_fecha_carga'])){
                        $solicitud_fecha_carga_2    = date("d/m/Y", strtotime($rowMSSQL00['solicitud_fecha_carga']));
                    } else {
                        $solicitud_fecha_carga_2    = '';
                    }
    
                    $detalle = array(                    
                        'solicitud_codigo'                      => $rowMSSQL00['solicitud_codigo'],
                        'solicitud_periodo'                     => $rowMSSQL00['solicitud_periodo'],
                        'solicitud_motivo'                      => trim(strtoupper(strtolower($rowMSSQL00['solicitud_motivo']))),
                        'solicitud_pasaje'                      => trim(strtoupper(strtolower($rowMSSQL00['solicitud_pasaje']))),
                        'solicitud_hospedaje'                   => trim(strtoupper(strtolower($rowMSSQL00['solicitud_hospedaje']))),
                        'solicitud_traslado'                    => trim(strtoupper(strtolower($rowMSSQL00['solicitud_traslado']))),
                        'solicitud_fecha_carga_1'               => $rowMSSQL00['solicitud_fecha_carga'],
                        'solicitud_fecha_carga_2'               => $solicitud_fecha_carga_2,
                        'solicitud_sap_centro_costo'            => trim(strtoupper(strtolower($rowMSSQL00['solicitud_sap_centro_costo']))),
                        'solicitud_tarea_cantidad'              => $rowMSSQL00['solicitud_tarea_cantidad'],
                        'solicitud_tarea_resuelta'              => $rowMSSQL00['solicitud_tarea_resuelta'],
                        'solicitud_tarea_porcentaje'            => number_format((($rowMSSQL00['solicitud_tarea_resuelta'] * 100) / $rowMSSQL00['solicitud_tarea_cantidad']), 2, '.', ''),
                        'solicitud_solicitante_nombre'          => trim(strtoupper(strtolower($rowMSSQL00['solicitud_solicitante_nombre']))),
                        'solicitud_solicitante_documento'       => trim(strtoupper(strtolower($rowMSSQL00['solicitud_solicitante_documento']))),
                        'solicitud_jefatura_nombre'             => trim(strtoupper(strtolower($rowMSSQL00['solicitud_jefatura_nombre']))),
                        'solicitud_jefatura_documento'          => trim(strtoupper(strtolower($rowMSSQL00['solicitud_jefatura_documento']))),
                        'solicitud_ejecutivo_nombre'            => trim(strtoupper(strtolower($rowMSSQL00['solicitud_ejecutivo_nombre']))),
                        'solicitud_ejecutivo_documento'         => trim(strtoupper(strtolower($rowMSSQL00['solicitud_ejecutivo_documento']))),
                        'solicitud_proveedor_nombre'            => trim(strtoupper(strtolower($rowMSSQL00['solicitud_proveedor_nombre']))),
                        'solicitud_proveedor_documento'         => trim(strtoupper(strtolower($rowMSSQL00['solicitud_proveedor_documento']))),
                        'solicitud_observacion'                 => trim(strtoupper(strtolower($rowMSSQL00['solicitud_observacion']))),
    
                        'auditoria_usuario'                     => trim(strtoupper(strtolower($rowMSSQL00['auditoria_usuario']))),
                        'auditoria_fecha_hora'                  => date("d/m/Y", strtotime($rowMSSQL00['auditoria_fecha_hora'])),
                        'auditoria_ip'                          => trim(strtoupper(strtolower($rowMSSQL00['auditoria_ip']))),
    
                        'tipo_gerencia_codigo'                  => $rowMSSQL00['tipo_gerencia_codigo'],
                        'tipo_gerencia_codigo_nombre'           => $rowMSSQL00['tipo_gerencia_codigo_nombre'],
                        'tipo_gerencia_codigo_referencia'       => $rowMSSQL00['tipo_gerencia_codigo_referencia'],
                        'tipo_gerencia_nombre'                  => trim(strtoupper(strtolower($rowMSSQL00['tipo_gerencia_nombre']))),
    
                        'tipo_departamento_codigo'              => $rowMSSQL00['tipo_departamento_codigo'],
                        'tipo_departamento_codigo_nombre'       => $rowMSSQL00['tipo_departamento_codigo_nombre'],
                        'tipo_departamento_codigo_referencia'   => $rowMSSQL00['tipo_departamento_codigo_referencia'],
                        'tipo_departamento_nombre'              => trim(strtoupper(strtolower($rowMSSQL00['tipo_departamento_nombre']))),
                        
                        'tipo_jefatura_codigo'                  => $rowMSSQL00['tipo_jefatura_codigo'],
                        'tipo_jefatura_codigo_nombre'           => $rowMSSQL00['tipo_jefatura_codigo_nombre'],
                        'tipo_jefatura_codigo_referencia'       => $rowMSSQL00['tipo_jefatura_codigo_referencia'],
                        'tipo_jefatura_nombre'                  => trim(strtoupper(strtolower($rowMSSQL00['tipo_jefatura_nombre']))),
    
                        'tipo_cargo_codigo'                     => $rowMSSQL00['tipo_cargo_codigo'],
                        'tipo_cargo_codigo_nombre'              => $rowMSSQL00['tipo_cargo_codigo_nombre'],
                        'tipo_cargo_codigo_referencia'          => $rowMSSQL00['tipo_cargo_codigo_referencia'],
                        'tipo_cargo_nombre'                     => trim(strtoupper(strtolower($rowMSSQL00['tipo_cargo_nombre']))),
    
                        'evento_codigo'                         => $rowMSSQL00['evento_codigo'],
                        'evento_orden'                          => $rowMSSQL00['evento_orden'],
                        'evento_nombre'                         => trim(strtoupper(strtolower($rowMSSQL00['evento_nombre']))),
                        'evento_fecha_inicio_1'                 => $rowMSSQL00['evento_fecha_inicio'],
                        'evento_fecha_inicio_2'                 => date("d/m/Y", strtotime($rowMSSQL00['evento_fecha_inicio'])),
                        'evento_fecha_fin_1'                    => $rowMSSQL00['evento_fecha_fin'],
                        'evento_fecha_fin_2'                    => date("d/m/Y", strtotime($rowMSSQL00['evento_fecha_fin'])),
                        'evento_observacion'                    => trim(strtoupper(strtolower($rowMSSQL00['evento_observacion']))),
    
                        'workflow_codigo'                       => $rowMSSQL00['workflow_codigo'],
                        'workflow_orden'                        => $rowMSSQL00['workflow_orden'],
                        'workflow_tarea'                        => trim(strtoupper(strtolower($rowMSSQL00['workflow_tarea']))),
    
                        'estado_anterior_codigo'                => $rowMSSQL00['estado_anterior_codigo'],
                        'estado_anterior_ingles'                => trim(strtoupper(strtolower($rowMSSQL00['estado_anterior_ingles']))),
                        'estado_anterior_castellano'            => trim(strtoupper(strtolower($rowMSSQL00['estado_anterior_castellano']))),
                        'estado_anterior_portugues'             => trim(strtoupper(strtolower($rowMSSQL00['estado_anterior_portugues']))),
                        'estado_anterior_parametro'             => $rowMSSQL00['estado_anterior_parametro'],
                        'estado_anterior_icono'                 => trim(strtolower($rowMSSQL00['estado_anterior_icono'])),
                        'estado_anterior_css'                   => trim(strtolower($rowMSSQL00['estado_anterior_css'])),
    
                        'estado_actual_codigo'                  => $rowMSSQL00['estado_actual_codigo'],
                        'estado_actual_ingles'                  => trim(strtoupper(strtolower($rowMSSQL00['estado_actual_ingles']))),
                        'estado_actual_castellano'              => trim(strtoupper(strtolower($rowMSSQL00['estado_actual_castellano']))),
                        'estado_actual_portugues'               => trim(strtoupper(strtolower($rowMSSQL00['estado_actual_portugues']))),
                        'estado_actual_parametro'               => $rowMSSQL00['estado_actual_parametro'],
                        'estado_actual_icono'                   => trim(strtolower($rowMSSQL00['estado_actual_icono'])),
                        'estado_actual_css'                     => trim(strtolower($rowMSSQL00['estado_actual_css'])),
    
                        'workflow_detalle_codigo'               => $rowMSSQL00['workflow_detalle_codigo'],
                        'workflow_detalle_orden'                => $rowMSSQL00['workflow_detalle_orden'],
                        'workflow_detalle_cargo'                => $rowMSSQL00['workflow_detalle_cargo'],
                        'workflow_detalle_hora'                 => trim(strtoupper(strtolower($rowMSSQL00['workflow_detalle_hora']))),
                        'workflow_detalle_tarea'                => trim(strtoupper(strtolower($rowMSSQL00['workflow_detalle_tarea']))),
    
                        'tipo_prioridad_codigo'                 => $rowMSSQL00['tipo_prioridad_codigo'],
                        'tipo_prioridad_ingles'                 => trim(strtoupper(strtolower($rowMSSQL00['tipo_prioridad_ingles']))),
                        'tipo_prioridad_castellano'             => trim(strtoupper(strtolower($rowMSSQL00['tipo_prioridad_castellano']))),
                        'tipo_prioridad_portugues'              => trim(strtoupper(strtolower($rowMSSQL00['tipo_prioridad_portugues']))),
                        'tipo_prioridad_parametro'              => $rowMSSQL00['tipo_prioridad_parametro'],
                        'tipo_prioridad_icono'                  => trim(strtolower($rowMSSQL00['tipo_prioridad_icono'])),
                        'tipo_prioridad_css'                    => trim(strtolower($rowMSSQL00['tipo_prioridad_css']))
                    );
    
                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle    = array(
                        'solicitud_codigo'                      => '',
                        'solicitud_periodo'                     => '',
                        'solicitud_motivo'                      => '',
                        'solicitud_pasaje'                      => '',
                        'solicitud_hospedaje'                   => '',
                        'solicitud_traslado'                    => '',
                        'solicitud_fecha_carga_1'               => '',
                        'solicitud_fecha_carga_2'               => '',
                        'solicitud_sap_centro_costo'            => '',
                        'solicitud_tarea_cantidad'              => '',
                        'solicitud_tarea_resuelta'              => '',
                        'solicitud_tarea_porcentaje'            => '',
                        'solicitud_solicitante_nombre'          => '',
                        'solicitud_solicitante_documento'       => '',
                        'solicitud_jefatura_nombre'             => '',
                        'solicitud_jefatura_documento'          => '',
                        'solicitud_ejecutivo_nombre'            => '',
                        'solicitud_ejecutivo_documento'         => '',
                        'solicitud_proveedor_nombre'            => '',
                        'solicitud_proveedor_documento'         => '',
                        'solicitud_observacion'                 => '',
    
                        'auditoria_usuario'                     => '',
                        'auditoria_fecha_hora'                  => '',
                        'auditoria_ip'                          => '',
    
                        'tipo_gerencia_codigo'                  => '',
                        'tipo_gerencia_codigo_nombre'           => '',
                        'tipo_gerencia_codigo_referencia'       => '',
                        'tipo_gerencia_nombre'                  => '',
    
                        'tipo_departamento_codigo'              => '',
                        'tipo_departamento_codigo_nombre'       => '',
                        'tipo_departamento_codigo_referencia'   => '',
                        'tipo_departamento_nombre'              => '',
                        
                        'tipo_jefatura_codigo'                  => '',
                        'tipo_jefatura_codigo_nombre'           => '',
                        'tipo_jefatura_codigo_referencia'       => '',
                        'tipo_jefatura_nombre'                  => '',
    
                        'tipo_cargo_codigo'                     => '',
                        'tipo_cargo_codigo_nombre'              => '',
                        'tipo_cargo_codigo_referencia'          => '',
                        'tipo_cargo_nombre'                     => '',
    
                        'evento_codigo'                         => '',
                        'evento_orden'                          => '',
                        'evento_nombre'                         => '',
                        'evento_fecha_inicio_1'                 => '',
                        'evento_fecha_inicio_2'                 => '',
                        'evento_fecha_fin_1'                    => '',
                        'evento_fecha_fin_2'                    => '',
                        'evento_observacion'                    => '',
    
                        'workflow_codigo'                       => '',
                        'workflow_orden'                        => '',
                        'workflow_tarea'                        => '',
                        
                        'estado_anterior_codigo'                => '',
                        'estado_anterior_ingles'                => '',
                        'estado_anterior_castellano'            => '',
                        'estado_anterior_portugues'             => '',
                        'estado_anterior_parametro'             => '',
                        'estado_anterior_icono'                 => '',
                        'estado_anterior_css'                   => '',
    
                        'estado_actual_codigo'                  => '',
                        'estado_actual_ingles'                  => '',
                        'estado_actual_castellano'              => '',
                        'estado_actual_portugues'               => '',
                        'estado_actual_parametro'               => '',
                        'estado_actual_icono'                   => '',
                        'estado_actual_css'                     => '',
    
                        'workflow_detalle_codigo'               => '',
                        'workflow_detalle_orden'                => '',
                        'workflow_detalle_cargo'                => '',
                        'workflow_detalle_hora'                 => '',
                        'workflow_detalle_tarea'                => '',
    
                        'tipo_prioridad_codigo'                 => '',
                        'tipo_prioridad_ingles'                 => '',
                        'tipo_prioridad_castellano'             => '',
                        'tipo_prioridad_portugues'              => '',
                        'tipo_prioridad_parametro'              => '',
                        'tipo_prioridad_icono'                  => '',
                        'tipo_prioridad_css'                    => ''
                    );

                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                }

                $stmtMSSQL00->closeCursor();
                $stmtMSSQL00 = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        }  else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v2/400/solicitud/ejecutivo/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val01  = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
                a.SOLFICCOD         AS          solicitud_codigo,
                a.SOLFICPER         AS          solicitud_periodo,
                a.SOLFICMOT         AS          solicitud_motivo,
                a.SOLFICPAS         AS          solicitud_pasaje,
                a.SOLFICHOS         AS          solicitud_hospedaje,
                a.SOLFICTRA         AS          solicitud_traslado,
                a.SOLFICFEC         AS          solicitud_fecha_carga,
                a.SOLFICSCC         AS          solicitud_sap_centro_costo,
                a.SOLFICTCA         AS          solicitud_tarea_cantidad,
                a.SOLFICTRE         AS          solicitud_tarea_resuelta,
                a.SOLFICOBS         AS          solicitud_observacion,

                a.SOLFICAUS         AS          auditoria_usuario,
                a.SOLFICAFH         AS          auditoria_fecha_hora,
                a.SOLFICAIP         AS          auditoria_ip,

                b.CODE              AS          tipo_gerencia_codigo,
                b.NAME              AS          tipo_gerencia_codigo_nombre,
                b.U_CODIGO          AS          tipo_gerencia_codigo_referencia,
                b.U_NOMBRE          AS          tipo_gerencia_nombre,

                c.CODE              AS          tipo_departamento_codigo,
                c.NAME              AS          tipo_departamento_codigo_nombre,
                c.U_CODIGO          AS          tipo_departamento_codigo_referencia,
                c.U_NOMBRE          AS          tipo_departamento_nombre,

                d.CODE              AS          tipo_jefatura_codigo_referencia,
                d.NAME              AS          tipo_jefatura_codigo_nombre,
                d.U_CODIGO          AS          tipo_jefatura_codigo,
                d.U_NOMBRE          AS          tipo_jefatura_nombre,

                e.CODE              AS          tipo_cargo_codigo_referencia,
                e.NAME              AS          tipo_cargo_codigo_nombre,
                e.U_CODIGO          AS          tipo_cargo_codigo,
                e.U_NOMBRE          AS          tipo_cargo_nombre,

                f.EVEFICCOD         AS          evento_codigo,
                f.EVEFICORD         AS          evento_orden,
                f.EVEFICNOM         AS          evento_nombre,
                f.EVEFICFVI         AS          evento_fecha_inicio,
                f.EVEFICFVF         AS          evento_fecha_fin,
                f.EVEFICOBS         AS          evento_observacion,

                g.WRKFICCOD         AS          workflow_codigo,
                g.WRKFICORD         AS          workflow_orden,
                g.WRKFICNOM         AS          workflow_tarea,

                h.DOMFICCOD         AS          estado_anterior_codigo,
                h.DOMFICNOI         AS          estado_anterior_ingles,
                h.DOMFICNOC         AS          estado_anterior_castellano,
                h.DOMFICNOP         AS          estado_anterior_portugues,
                h.DOMFICPAR         AS          estado_anterior_parametro,
                h.DOMFICICO         AS          estado_anterior_icono,
                h.DOMFICCSS         AS          estado_anterior_css,

                i.DOMFICCOD         AS          estado_actual_codigo,
                i.DOMFICNOI         AS          estado_actual_ingles,
                i.DOMFICNOC         AS          estado_actual_castellano,
                i.DOMFICNOP         AS          estado_actual_portugues,
                i.DOMFICPAR         AS          estado_actual_parametro,
                i.DOMFICICO         AS          estado_actual_icono,
                i.DOMFICCSS         AS          estado_actual_css,

                j.WRKDETCOD         AS          workflow_detalle_codigo,
                j.WRKDETORD         AS          workflow_detalle_orden,
                j.WRKDETTCC         AS          workflow_detalle_cargo,
                j.WRKDETHOR         AS          workflow_detalle_hora,
                j.WRKDETNOM         AS          workflow_detalle_tarea,

                k.DOMFICCOD         AS          tipo_prioridad_codigo,
                k.DOMFICNOI         AS          tipo_prioridad_ingles,
                k.DOMFICNOC         AS          tipo_prioridad_castellano,
                k.DOMFICNOP         AS          tipo_prioridad_portugues,
                k.DOMFICPAR         AS          tipo_prioridad_parametro,
                k.DOMFICICO         AS          tipo_prioridad_icono,
                k.DOMFICCSS         AS          tipo_prioridad_css,

                l1.NombreEmpleado   AS          solicitud_solicitante_nombre,
                a.SOLFICDNS         AS          solicitud_solicitante_documento,
                l2.NombreEmpleado   AS          solicitud_jefatura_nombre,
                a.SOLFICDNJ         AS          solicitud_jefatura_documento,
                l3.NombreEmpleado   AS          solicitud_ejecutivo_nombre,
                a.SOLFICDNE         AS          solicitud_ejecutivo_documento,
                l4.NombreEmpleado   AS          solicitud_proveedor_nombre,
                a.SOLFICDNP         AS          solicitud_proveedor_documento

                FROM [via].[SOLFIC] a
                INNER JOIN [CSF].[dbo].[@A1A_TIGE] b ON a.SOLFICGEC = b.U_CODIGO
                INNER JOIN [CSF].[dbo].[@A1A_TIDE] c ON a.SOLFICDEC = c.U_CODIGO
                INNER JOIN [CSF].[dbo].[@A1A_TICA] d ON a.SOLFICJEC = d.U_CODIGO
                INNER JOIN [CSF].[dbo].[@A1A_TICA] e ON a.SOLFICCAC = e.U_CODIGO
                LEFT OUTER JOIN [via].[EVEFIC] f ON a.SOLFICEVC = f.EVEFICCOD
                LEFT OUTER JOIN [wrk].[WRKFIC] g ON a.SOLFICWFC = g.WRKFICCOD
                LEFT OUTER JOIN [adm].[DOMFIC] h ON a.SOLFICEAC = h.DOMFICCOD
                LEFT OUTER JOIN [adm].[DOMFIC] i ON a.SOLFICECC = i.DOMFICCOD
                LEFT OUTER JOIN [wrk].[WRKDET] j ON a.SOLFICWFC = j.WRKDETWFC AND a.SOLFICEAC = j.WRKDETEAC AND a.SOLFICECC = j.WRKDETECC
                LEFT OUTER JOIN [adm].[DOMFIC] k ON j.WRKDETTPC = k.DOMFICCOD
                LEFT OUTER JOIN [CSF].[dbo].[empleados_AxisONE] l1 ON a.SOLFICDNS COLLATE SQL_Latin1_General_CP1_CI_AS = l1.CedulaEmpleado
                LEFT OUTER JOIN [CSF].[dbo].[empleados_AxisONE] l2 ON a.SOLFICDNJ COLLATE SQL_Latin1_General_CP1_CI_AS = l2.CedulaEmpleado
                LEFT OUTER JOIN [CSF].[dbo].[empleados_AxisONE] l3 ON a.SOLFICDNE COLLATE SQL_Latin1_General_CP1_CI_AS = l3.CedulaEmpleado
                LEFT OUTER JOIN [CSF].[dbo].[empleados_AxisONE] l4 ON a.SOLFICDNP COLLATE SQL_Latin1_General_CP1_CI_AS = l4.CedulaEmpleado

                WHERE a.SOLFICDNE = ?

                ORDER BY a.SOLFICCOD DESC";

            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val01]);

                while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                    if(!empty($rowMSSQL00['solicitud_fecha_carga'])){
                        $solicitud_fecha_carga_2    = date("d/m/Y", strtotime($rowMSSQL00['solicitud_fecha_carga']));
                    } else {
                        $solicitud_fecha_carga_2    = '';
                    }
    
                    $detalle = array(                    
                        'solicitud_codigo'                      => $rowMSSQL00['solicitud_codigo'],
                        'solicitud_periodo'                     => $rowMSSQL00['solicitud_periodo'],
                        'solicitud_motivo'                      => trim(strtoupper(strtolower($rowMSSQL00['solicitud_motivo']))),
                        'solicitud_pasaje'                      => trim(strtoupper(strtolower($rowMSSQL00['solicitud_pasaje']))),
                        'solicitud_hospedaje'                   => trim(strtoupper(strtolower($rowMSSQL00['solicitud_hospedaje']))),
                        'solicitud_traslado'                    => trim(strtoupper(strtolower($rowMSSQL00['solicitud_traslado']))),
                        'solicitud_fecha_carga_1'               => $rowMSSQL00['solicitud_fecha_carga'],
                        'solicitud_fecha_carga_2'               => $solicitud_fecha_carga_2,
                        'solicitud_sap_centro_costo'            => trim(strtoupper(strtolower($rowMSSQL00['solicitud_sap_centro_costo']))),
                        'solicitud_tarea_cantidad'              => $rowMSSQL00['solicitud_tarea_cantidad'],
                        'solicitud_tarea_resuelta'              => $rowMSSQL00['solicitud_tarea_resuelta'],
                        'solicitud_tarea_porcentaje'            => number_format((($rowMSSQL00['solicitud_tarea_resuelta'] * 100) / $rowMSSQL00['solicitud_tarea_cantidad']), 2, '.', ''),
                        'solicitud_solicitante_nombre'          => trim(strtoupper(strtolower($rowMSSQL00['solicitud_solicitante_nombre']))),
                        'solicitud_solicitante_documento'       => trim(strtoupper(strtolower($rowMSSQL00['solicitud_solicitante_documento']))),
                        'solicitud_jefatura_nombre'             => trim(strtoupper(strtolower($rowMSSQL00['solicitud_jefatura_nombre']))),
                        'solicitud_jefatura_documento'          => trim(strtoupper(strtolower($rowMSSQL00['solicitud_jefatura_documento']))),
                        'solicitud_ejecutivo_nombre'            => trim(strtoupper(strtolower($rowMSSQL00['solicitud_ejecutivo_nombre']))),
                        'solicitud_ejecutivo_documento'         => trim(strtoupper(strtolower($rowMSSQL00['solicitud_ejecutivo_documento']))),
                        'solicitud_proveedor_nombre'            => trim(strtoupper(strtolower($rowMSSQL00['solicitud_proveedor_nombre']))),
                        'solicitud_proveedor_documento'         => trim(strtoupper(strtolower($rowMSSQL00['solicitud_proveedor_documento']))),
                        'solicitud_observacion'                 => trim(strtoupper(strtolower($rowMSSQL00['solicitud_observacion']))),
    
                        'auditoria_usuario'                     => trim(strtoupper(strtolower($rowMSSQL00['auditoria_usuario']))),
                        'auditoria_fecha_hora'                  => date("d/m/Y", strtotime($rowMSSQL00['auditoria_fecha_hora'])),
                        'auditoria_ip'                          => trim(strtoupper(strtolower($rowMSSQL00['auditoria_ip']))),
    
                        'tipo_gerencia_codigo'                  => $rowMSSQL00['tipo_gerencia_codigo'],
                        'tipo_gerencia_codigo_nombre'           => $rowMSSQL00['tipo_gerencia_codigo_nombre'],
                        'tipo_gerencia_codigo_referencia'       => $rowMSSQL00['tipo_gerencia_codigo_referencia'],
                        'tipo_gerencia_nombre'                  => trim(strtoupper(strtolower($rowMSSQL00['tipo_gerencia_nombre']))),
    
                        'tipo_departamento_codigo'              => $rowMSSQL00['tipo_departamento_codigo'],
                        'tipo_departamento_codigo_nombre'       => $rowMSSQL00['tipo_departamento_codigo_nombre'],
                        'tipo_departamento_codigo_referencia'   => $rowMSSQL00['tipo_departamento_codigo_referencia'],
                        'tipo_departamento_nombre'              => trim(strtoupper(strtolower($rowMSSQL00['tipo_departamento_nombre']))),
                        
                        'tipo_jefatura_codigo'                  => $rowMSSQL00['tipo_jefatura_codigo'],
                        'tipo_jefatura_codigo_nombre'           => $rowMSSQL00['tipo_jefatura_codigo_nombre'],
                        'tipo_jefatura_codigo_referencia'       => $rowMSSQL00['tipo_jefatura_codigo_referencia'],
                        'tipo_jefatura_nombre'                  => trim(strtoupper(strtolower($rowMSSQL00['tipo_jefatura_nombre']))),
    
                        'tipo_cargo_codigo'                     => $rowMSSQL00['tipo_cargo_codigo'],
                        'tipo_cargo_codigo_nombre'              => $rowMSSQL00['tipo_cargo_codigo_nombre'],
                        'tipo_cargo_codigo_referencia'          => $rowMSSQL00['tipo_cargo_codigo_referencia'],
                        'tipo_cargo_nombre'                     => trim(strtoupper(strtolower($rowMSSQL00['tipo_cargo_nombre']))),
    
                        'evento_codigo'                         => $rowMSSQL00['evento_codigo'],
                        'evento_orden'                          => $rowMSSQL00['evento_orden'],
                        'evento_nombre'                         => trim(strtoupper(strtolower($rowMSSQL00['evento_nombre']))),
                        'evento_fecha_inicio_1'                 => $rowMSSQL00['evento_fecha_inicio'],
                        'evento_fecha_inicio_2'                 => date("d/m/Y", strtotime($rowMSSQL00['evento_fecha_inicio'])),
                        'evento_fecha_fin_1'                    => $rowMSSQL00['evento_fecha_fin'],
                        'evento_fecha_fin_2'                    => date("d/m/Y", strtotime($rowMSSQL00['evento_fecha_fin'])),
                        'evento_observacion'                    => trim(strtoupper(strtolower($rowMSSQL00['evento_observacion']))),
    
                        'workflow_codigo'                       => $rowMSSQL00['workflow_codigo'],
                        'workflow_orden'                        => $rowMSSQL00['workflow_orden'],
                        'workflow_tarea'                        => trim(strtoupper(strtolower($rowMSSQL00['workflow_tarea']))),
    
                        'estado_anterior_codigo'                => $rowMSSQL00['estado_anterior_codigo'],
                        'estado_anterior_ingles'                => trim(strtoupper(strtolower($rowMSSQL00['estado_anterior_ingles']))),
                        'estado_anterior_castellano'            => trim(strtoupper(strtolower($rowMSSQL00['estado_anterior_castellano']))),
                        'estado_anterior_portugues'             => trim(strtoupper(strtolower($rowMSSQL00['estado_anterior_portugues']))),
                        'estado_anterior_parametro'             => $rowMSSQL00['estado_anterior_parametro'],
                        'estado_anterior_icono'                 => trim(strtolower($rowMSSQL00['estado_anterior_icono'])),
                        'estado_anterior_css'                   => trim(strtolower($rowMSSQL00['estado_anterior_css'])),
    
                        'estado_actual_codigo'                  => $rowMSSQL00['estado_actual_codigo'],
                        'estado_actual_ingles'                  => trim(strtoupper(strtolower($rowMSSQL00['estado_actual_ingles']))),
                        'estado_actual_castellano'              => trim(strtoupper(strtolower($rowMSSQL00['estado_actual_castellano']))),
                        'estado_actual_portugues'               => trim(strtoupper(strtolower($rowMSSQL00['estado_actual_portugues']))),
                        'estado_actual_parametro'               => $rowMSSQL00['estado_actual_parametro'],
                        'estado_actual_icono'                   => trim(strtolower($rowMSSQL00['estado_actual_icono'])),
                        'estado_actual_css'                     => trim(strtolower($rowMSSQL00['estado_actual_css'])),
    
                        'workflow_detalle_codigo'               => $rowMSSQL00['workflow_detalle_codigo'],
                        'workflow_detalle_orden'                => $rowMSSQL00['workflow_detalle_orden'],
                        'workflow_detalle_cargo'                => $rowMSSQL00['workflow_detalle_cargo'],
                        'workflow_detalle_hora'                 => trim(strtoupper(strtolower($rowMSSQL00['workflow_detalle_hora']))),
                        'workflow_detalle_tarea'                => trim(strtoupper(strtolower($rowMSSQL00['workflow_detalle_tarea']))),
    
                        'tipo_prioridad_codigo'                 => $rowMSSQL00['tipo_prioridad_codigo'],
                        'tipo_prioridad_ingles'                 => trim(strtoupper(strtolower($rowMSSQL00['tipo_prioridad_ingles']))),
                        'tipo_prioridad_castellano'             => trim(strtoupper(strtolower($rowMSSQL00['tipo_prioridad_castellano']))),
                        'tipo_prioridad_portugues'              => trim(strtoupper(strtolower($rowMSSQL00['tipo_prioridad_portugues']))),
                        'tipo_prioridad_parametro'              => $rowMSSQL00['tipo_prioridad_parametro'],
                        'tipo_prioridad_icono'                  => trim(strtolower($rowMSSQL00['tipo_prioridad_icono'])),
                        'tipo_prioridad_css'                    => trim(strtolower($rowMSSQL00['tipo_prioridad_css']))
                    );
    
                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle    = array(
                        'solicitud_codigo'                      => '',
                        'solicitud_periodo'                     => '',
                        'solicitud_motivo'                      => '',
                        'solicitud_pasaje'                      => '',
                        'solicitud_hospedaje'                   => '',
                        'solicitud_traslado'                    => '',
                        'solicitud_fecha_carga_1'               => '',
                        'solicitud_fecha_carga_2'               => '',
                        'solicitud_sap_centro_costo'            => '',
                        'solicitud_tarea_cantidad'              => '',
                        'solicitud_tarea_resuelta'              => '',
                        'solicitud_tarea_porcentaje'            => '',
                        'solicitud_solicitante_nombre'          => '',
                        'solicitud_solicitante_documento'       => '',
                        'solicitud_jefatura_nombre'             => '',
                        'solicitud_jefatura_documento'          => '',
                        'solicitud_ejecutivo_nombre'            => '',
                        'solicitud_ejecutivo_documento'         => '',
                        'solicitud_proveedor_nombre'            => '',
                        'solicitud_proveedor_documento'         => '',
                        'solicitud_observacion'                 => '',
    
                        'auditoria_usuario'                     => '',
                        'auditoria_fecha_hora'                  => '',
                        'auditoria_ip'                          => '',
    
                        'tipo_gerencia_codigo'                  => '',
                        'tipo_gerencia_codigo_nombre'           => '',
                        'tipo_gerencia_codigo_referencia'       => '',
                        'tipo_gerencia_nombre'                  => '',
    
                        'tipo_departamento_codigo'              => '',
                        'tipo_departamento_codigo_nombre'       => '',
                        'tipo_departamento_codigo_referencia'   => '',
                        'tipo_departamento_nombre'              => '',
                        
                        'tipo_jefatura_codigo'                  => '',
                        'tipo_jefatura_codigo_nombre'           => '',
                        'tipo_jefatura_codigo_referencia'       => '',
                        'tipo_jefatura_nombre'                  => '',
    
                        'tipo_cargo_codigo'                     => '',
                        'tipo_cargo_codigo_nombre'              => '',
                        'tipo_cargo_codigo_referencia'          => '',
                        'tipo_cargo_nombre'                     => '',
    
                        'evento_codigo'                         => '',
                        'evento_orden'                          => '',
                        'evento_nombre'                         => '',
                        'evento_fecha_inicio_1'                 => '',
                        'evento_fecha_inicio_2'                 => '',
                        'evento_fecha_fin_1'                    => '',
                        'evento_fecha_fin_2'                    => '',
                        'evento_observacion'                    => '',
    
                        'workflow_codigo'                       => '',
                        'workflow_orden'                        => '',
                        'workflow_tarea'                        => '',
                        
                        'estado_anterior_codigo'                => '',
                        'estado_anterior_ingles'                => '',
                        'estado_anterior_castellano'            => '',
                        'estado_anterior_portugues'             => '',
                        'estado_anterior_parametro'             => '',
                        'estado_anterior_icono'                 => '',
                        'estado_anterior_css'                   => '',
    
                        'estado_actual_codigo'                  => '',
                        'estado_actual_ingles'                  => '',
                        'estado_actual_castellano'              => '',
                        'estado_actual_portugues'               => '',
                        'estado_actual_parametro'               => '',
                        'estado_actual_icono'                   => '',
                        'estado_actual_css'                     => '',
    
                        'workflow_detalle_codigo'               => '',
                        'workflow_detalle_orden'                => '',
                        'workflow_detalle_cargo'                => '',
                        'workflow_detalle_hora'                 => '',
                        'workflow_detalle_tarea'                => '',
    
                        'tipo_prioridad_codigo'                 => '',
                        'tipo_prioridad_ingles'                 => '',
                        'tipo_prioridad_castellano'             => '',
                        'tipo_prioridad_portugues'              => '',
                        'tipo_prioridad_parametro'              => '',
                        'tipo_prioridad_icono'                  => '',
                        'tipo_prioridad_css'                    => ''
                    );

                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                }

                $stmtMSSQL00->closeCursor();
                $stmtMSSQL00 = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        }  else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v2/400/solicitud/ejecutivo/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val01  = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
                a.SOLFICCOD         AS          solicitud_codigo,
                a.SOLFICPER         AS          solicitud_periodo,
                a.SOLFICMOT         AS          solicitud_motivo,
                a.SOLFICPAS         AS          solicitud_pasaje,
                a.SOLFICHOS         AS          solicitud_hospedaje,
                a.SOLFICTRA         AS          solicitud_traslado,
                a.SOLFICFEC         AS          solicitud_fecha_carga,
                a.SOLFICSCC         AS          solicitud_sap_centro_costo,
                a.SOLFICTCA         AS          solicitud_tarea_cantidad,
                a.SOLFICTRE         AS          solicitud_tarea_resuelta,
                a.SOLFICOBS         AS          solicitud_observacion,

                a.SOLFICAUS         AS          auditoria_usuario,
                a.SOLFICAFH         AS          auditoria_fecha_hora,
                a.SOLFICAIP         AS          auditoria_ip,

                b.CODE              AS          tipo_gerencia_codigo,
                b.NAME              AS          tipo_gerencia_codigo_nombre,
                b.U_CODIGO          AS          tipo_gerencia_codigo_referencia,
                b.U_NOMBRE          AS          tipo_gerencia_nombre,

                c.CODE              AS          tipo_departamento_codigo,
                c.NAME              AS          tipo_departamento_codigo_nombre,
                c.U_CODIGO          AS          tipo_departamento_codigo_referencia,
                c.U_NOMBRE          AS          tipo_departamento_nombre,

                d.CODE              AS          tipo_jefatura_codigo_referencia,
                d.NAME              AS          tipo_jefatura_codigo_nombre,
                d.U_CODIGO          AS          tipo_jefatura_codigo,
                d.U_NOMBRE          AS          tipo_jefatura_nombre,

                e.CODE              AS          tipo_cargo_codigo_referencia,
                e.NAME              AS          tipo_cargo_codigo_nombre,
                e.U_CODIGO          AS          tipo_cargo_codigo,
                e.U_NOMBRE          AS          tipo_cargo_nombre,

                f.EVEFICCOD         AS          evento_codigo,
                f.EVEFICORD         AS          evento_orden,
                f.EVEFICNOM         AS          evento_nombre,
                f.EVEFICFVI         AS          evento_fecha_inicio,
                f.EVEFICFVF         AS          evento_fecha_fin,
                f.EVEFICOBS         AS          evento_observacion,

                g.WRKFICCOD         AS          workflow_codigo,
                g.WRKFICORD         AS          workflow_orden,
                g.WRKFICNOM         AS          workflow_tarea,

                h.DOMFICCOD         AS          estado_anterior_codigo,
                h.DOMFICNOI         AS          estado_anterior_ingles,
                h.DOMFICNOC         AS          estado_anterior_castellano,
                h.DOMFICNOP         AS          estado_anterior_portugues,
                h.DOMFICPAR         AS          estado_anterior_parametro,
                h.DOMFICICO         AS          estado_anterior_icono,
                h.DOMFICCSS         AS          estado_anterior_css,

                i.DOMFICCOD         AS          estado_actual_codigo,
                i.DOMFICNOI         AS          estado_actual_ingles,
                i.DOMFICNOC         AS          estado_actual_castellano,
                i.DOMFICNOP         AS          estado_actual_portugues,
                i.DOMFICPAR         AS          estado_actual_parametro,
                i.DOMFICICO         AS          estado_actual_icono,
                i.DOMFICCSS         AS          estado_actual_css,

                j.WRKDETCOD         AS          workflow_detalle_codigo,
                j.WRKDETORD         AS          workflow_detalle_orden,
                j.WRKDETTCC         AS          workflow_detalle_cargo,
                j.WRKDETHOR         AS          workflow_detalle_hora,
                j.WRKDETNOM         AS          workflow_detalle_tarea,

                k.DOMFICCOD         AS          tipo_prioridad_codigo,
                k.DOMFICNOI         AS          tipo_prioridad_ingles,
                k.DOMFICNOC         AS          tipo_prioridad_castellano,
                k.DOMFICNOP         AS          tipo_prioridad_portugues,
                k.DOMFICPAR         AS          tipo_prioridad_parametro,
                k.DOMFICICO         AS          tipo_prioridad_icono,
                k.DOMFICCSS         AS          tipo_prioridad_css,

                l1.NombreEmpleado   AS          solicitud_solicitante_nombre,
                a.SOLFICDNS         AS          solicitud_solicitante_documento,
                l2.NombreEmpleado   AS          solicitud_jefatura_nombre,
                a.SOLFICDNJ         AS          solicitud_jefatura_documento,
                l3.NombreEmpleado   AS          solicitud_ejecutivo_nombre,
                a.SOLFICDNE         AS          solicitud_ejecutivo_documento,
                l4.NombreEmpleado   AS          solicitud_proveedor_nombre,
                a.SOLFICDNP         AS          solicitud_proveedor_documento

                FROM [via].[SOLFIC] a
                INNER JOIN [CSF].[dbo].[@A1A_TIGE] b ON a.SOLFICGEC = b.U_CODIGO
                INNER JOIN [CSF].[dbo].[@A1A_TIDE] c ON a.SOLFICDEC = c.U_CODIGO
                INNER JOIN [CSF].[dbo].[@A1A_TICA] d ON a.SOLFICJEC = d.U_CODIGO
                INNER JOIN [CSF].[dbo].[@A1A_TICA] e ON a.SOLFICCAC = e.U_CODIGO
                LEFT OUTER JOIN [via].[EVEFIC] f ON a.SOLFICEVC = f.EVEFICCOD
                LEFT OUTER JOIN [wrk].[WRKFIC] g ON a.SOLFICWFC = g.WRKFICCOD
                LEFT OUTER JOIN [adm].[DOMFIC] h ON a.SOLFICEAC = h.DOMFICCOD
                LEFT OUTER JOIN [adm].[DOMFIC] i ON a.SOLFICECC = i.DOMFICCOD
                LEFT OUTER JOIN [wrk].[WRKDET] j ON a.SOLFICWFC = j.WRKDETWFC AND a.SOLFICEAC = j.WRKDETEAC AND a.SOLFICECC = j.WRKDETECC
                LEFT OUTER JOIN [adm].[DOMFIC] k ON j.WRKDETTPC = k.DOMFICCOD
                LEFT OUTER JOIN [CSF].[dbo].[empleados_AxisONE] l1 ON a.SOLFICDNS COLLATE SQL_Latin1_General_CP1_CI_AS = l1.CedulaEmpleado
                LEFT OUTER JOIN [CSF].[dbo].[empleados_AxisONE] l2 ON a.SOLFICDNJ COLLATE SQL_Latin1_General_CP1_CI_AS = l2.CedulaEmpleado
                LEFT OUTER JOIN [CSF].[dbo].[empleados_AxisONE] l3 ON a.SOLFICDNE COLLATE SQL_Latin1_General_CP1_CI_AS = l3.CedulaEmpleado
                LEFT OUTER JOIN [CSF].[dbo].[empleados_AxisONE] l4 ON a.SOLFICDNP COLLATE SQL_Latin1_General_CP1_CI_AS = l4.CedulaEmpleado

                WHERE a.SOLFICDNP = ?

                ORDER BY a.SOLFICCOD DESC";

            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val01]);

                while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                    if(!empty($rowMSSQL00['solicitud_fecha_carga'])){
                        $solicitud_fecha_carga_2    = date("d/m/Y", strtotime($rowMSSQL00['solicitud_fecha_carga']));
                    } else {
                        $solicitud_fecha_carga_2    = '';
                    }
    
                    $detalle = array(                    
                        'solicitud_codigo'                      => $rowMSSQL00['solicitud_codigo'],
                        'solicitud_periodo'                     => $rowMSSQL00['solicitud_periodo'],
                        'solicitud_motivo'                      => trim(strtoupper(strtolower($rowMSSQL00['solicitud_motivo']))),
                        'solicitud_pasaje'                      => trim(strtoupper(strtolower($rowMSSQL00['solicitud_pasaje']))),
                        'solicitud_hospedaje'                   => trim(strtoupper(strtolower($rowMSSQL00['solicitud_hospedaje']))),
                        'solicitud_traslado'                    => trim(strtoupper(strtolower($rowMSSQL00['solicitud_traslado']))),
                        'solicitud_fecha_carga_1'               => $rowMSSQL00['solicitud_fecha_carga'],
                        'solicitud_fecha_carga_2'               => $solicitud_fecha_carga_2,
                        'solicitud_sap_centro_costo'            => trim(strtoupper(strtolower($rowMSSQL00['solicitud_sap_centro_costo']))),
                        'solicitud_tarea_cantidad'              => $rowMSSQL00['solicitud_tarea_cantidad'],
                        'solicitud_tarea_resuelta'              => $rowMSSQL00['solicitud_tarea_resuelta'],
                        'solicitud_tarea_porcentaje'            => number_format((($rowMSSQL00['solicitud_tarea_resuelta'] * 100) / $rowMSSQL00['solicitud_tarea_cantidad']), 2, '.', ''),
                        'solicitud_solicitante_nombre'          => trim(strtoupper(strtolower($rowMSSQL00['solicitud_solicitante_nombre']))),
                        'solicitud_solicitante_documento'       => trim(strtoupper(strtolower($rowMSSQL00['solicitud_solicitante_documento']))),
                        'solicitud_jefatura_nombre'             => trim(strtoupper(strtolower($rowMSSQL00['solicitud_jefatura_nombre']))),
                        'solicitud_jefatura_documento'          => trim(strtoupper(strtolower($rowMSSQL00['solicitud_jefatura_documento']))),
                        'solicitud_ejecutivo_nombre'            => trim(strtoupper(strtolower($rowMSSQL00['solicitud_ejecutivo_nombre']))),
                        'solicitud_ejecutivo_documento'         => trim(strtoupper(strtolower($rowMSSQL00['solicitud_ejecutivo_documento']))),
                        'solicitud_proveedor_nombre'            => trim(strtoupper(strtolower($rowMSSQL00['solicitud_proveedor_nombre']))),
                        'solicitud_proveedor_documento'         => trim(strtoupper(strtolower($rowMSSQL00['solicitud_proveedor_documento']))),
                        'solicitud_observacion'                 => trim(strtoupper(strtolower($rowMSSQL00['solicitud_observacion']))),
    
                        'auditoria_usuario'                     => trim(strtoupper(strtolower($rowMSSQL00['auditoria_usuario']))),
                        'auditoria_fecha_hora'                  => date("d/m/Y", strtotime($rowMSSQL00['auditoria_fecha_hora'])),
                        'auditoria_ip'                          => trim(strtoupper(strtolower($rowMSSQL00['auditoria_ip']))),
    
                        'tipo_gerencia_codigo'                  => $rowMSSQL00['tipo_gerencia_codigo'],
                        'tipo_gerencia_codigo_nombre'           => $rowMSSQL00['tipo_gerencia_codigo_nombre'],
                        'tipo_gerencia_codigo_referencia'       => $rowMSSQL00['tipo_gerencia_codigo_referencia'],
                        'tipo_gerencia_nombre'                  => trim(strtoupper(strtolower($rowMSSQL00['tipo_gerencia_nombre']))),
    
                        'tipo_departamento_codigo'              => $rowMSSQL00['tipo_departamento_codigo'],
                        'tipo_departamento_codigo_nombre'       => $rowMSSQL00['tipo_departamento_codigo_nombre'],
                        'tipo_departamento_codigo_referencia'   => $rowMSSQL00['tipo_departamento_codigo_referencia'],
                        'tipo_departamento_nombre'              => trim(strtoupper(strtolower($rowMSSQL00['tipo_departamento_nombre']))),
                        
                        'tipo_jefatura_codigo'                  => $rowMSSQL00['tipo_jefatura_codigo'],
                        'tipo_jefatura_codigo_nombre'           => $rowMSSQL00['tipo_jefatura_codigo_nombre'],
                        'tipo_jefatura_codigo_referencia'       => $rowMSSQL00['tipo_jefatura_codigo_referencia'],
                        'tipo_jefatura_nombre'                  => trim(strtoupper(strtolower($rowMSSQL00['tipo_jefatura_nombre']))),
    
                        'tipo_cargo_codigo'                     => $rowMSSQL00['tipo_cargo_codigo'],
                        'tipo_cargo_codigo_nombre'              => $rowMSSQL00['tipo_cargo_codigo_nombre'],
                        'tipo_cargo_codigo_referencia'          => $rowMSSQL00['tipo_cargo_codigo_referencia'],
                        'tipo_cargo_nombre'                     => trim(strtoupper(strtolower($rowMSSQL00['tipo_cargo_nombre']))),
    
                        'evento_codigo'                         => $rowMSSQL00['evento_codigo'],
                        'evento_orden'                          => $rowMSSQL00['evento_orden'],
                        'evento_nombre'                         => trim(strtoupper(strtolower($rowMSSQL00['evento_nombre']))),
                        'evento_fecha_inicio_1'                 => $rowMSSQL00['evento_fecha_inicio'],
                        'evento_fecha_inicio_2'                 => date("d/m/Y", strtotime($rowMSSQL00['evento_fecha_inicio'])),
                        'evento_fecha_fin_1'                    => $rowMSSQL00['evento_fecha_fin'],
                        'evento_fecha_fin_2'                    => date("d/m/Y", strtotime($rowMSSQL00['evento_fecha_fin'])),
                        'evento_observacion'                    => trim(strtoupper(strtolower($rowMSSQL00['evento_observacion']))),
    
                        'workflow_codigo'                       => $rowMSSQL00['workflow_codigo'],
                        'workflow_orden'                        => $rowMSSQL00['workflow_orden'],
                        'workflow_tarea'                        => trim(strtoupper(strtolower($rowMSSQL00['workflow_tarea']))),
    
                        'estado_anterior_codigo'                => $rowMSSQL00['estado_anterior_codigo'],
                        'estado_anterior_ingles'                => trim(strtoupper(strtolower($rowMSSQL00['estado_anterior_ingles']))),
                        'estado_anterior_castellano'            => trim(strtoupper(strtolower($rowMSSQL00['estado_anterior_castellano']))),
                        'estado_anterior_portugues'             => trim(strtoupper(strtolower($rowMSSQL00['estado_anterior_portugues']))),
                        'estado_anterior_parametro'             => $rowMSSQL00['estado_anterior_parametro'],
                        'estado_anterior_icono'                 => trim(strtolower($rowMSSQL00['estado_anterior_icono'])),
                        'estado_anterior_css'                   => trim(strtolower($rowMSSQL00['estado_anterior_css'])),
    
                        'estado_actual_codigo'                  => $rowMSSQL00['estado_actual_codigo'],
                        'estado_actual_ingles'                  => trim(strtoupper(strtolower($rowMSSQL00['estado_actual_ingles']))),
                        'estado_actual_castellano'              => trim(strtoupper(strtolower($rowMSSQL00['estado_actual_castellano']))),
                        'estado_actual_portugues'               => trim(strtoupper(strtolower($rowMSSQL00['estado_actual_portugues']))),
                        'estado_actual_parametro'               => $rowMSSQL00['estado_actual_parametro'],
                        'estado_actual_icono'                   => trim(strtolower($rowMSSQL00['estado_actual_icono'])),
                        'estado_actual_css'                     => trim(strtolower($rowMSSQL00['estado_actual_css'])),
    
                        'workflow_detalle_codigo'               => $rowMSSQL00['workflow_detalle_codigo'],
                        'workflow_detalle_orden'                => $rowMSSQL00['workflow_detalle_orden'],
                        'workflow_detalle_cargo'                => $rowMSSQL00['workflow_detalle_cargo'],
                        'workflow_detalle_hora'                 => trim(strtoupper(strtolower($rowMSSQL00['workflow_detalle_hora']))),
                        'workflow_detalle_tarea'                => trim(strtoupper(strtolower($rowMSSQL00['workflow_detalle_tarea']))),
    
                        'tipo_prioridad_codigo'                 => $rowMSSQL00['tipo_prioridad_codigo'],
                        'tipo_prioridad_ingles'                 => trim(strtoupper(strtolower($rowMSSQL00['tipo_prioridad_ingles']))),
                        'tipo_prioridad_castellano'             => trim(strtoupper(strtolower($rowMSSQL00['tipo_prioridad_castellano']))),
                        'tipo_prioridad_portugues'              => trim(strtoupper(strtolower($rowMSSQL00['tipo_prioridad_portugues']))),
                        'tipo_prioridad_parametro'              => $rowMSSQL00['tipo_prioridad_parametro'],
                        'tipo_prioridad_icono'                  => trim(strtolower($rowMSSQL00['tipo_prioridad_icono'])),
                        'tipo_prioridad_css'                    => trim(strtolower($rowMSSQL00['tipo_prioridad_css']))
                    );
    
                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle    = array(
                        'solicitud_codigo'                      => '',
                        'solicitud_periodo'                     => '',
                        'solicitud_motivo'                      => '',
                        'solicitud_pasaje'                      => '',
                        'solicitud_hospedaje'                   => '',
                        'solicitud_traslado'                    => '',
                        'solicitud_fecha_carga_1'               => '',
                        'solicitud_fecha_carga_2'               => '',
                        'solicitud_sap_centro_costo'            => '',
                        'solicitud_tarea_cantidad'              => '',
                        'solicitud_tarea_resuelta'              => '',
                        'solicitud_tarea_porcentaje'            => '',
                        'solicitud_solicitante_nombre'          => '',
                        'solicitud_solicitante_documento'       => '',
                        'solicitud_jefatura_nombre'             => '',
                        'solicitud_jefatura_documento'          => '',
                        'solicitud_ejecutivo_nombre'            => '',
                        'solicitud_ejecutivo_documento'         => '',
                        'solicitud_proveedor_nombre'            => '',
                        'solicitud_proveedor_documento'         => '',
                        'solicitud_observacion'                 => '',
    
                        'auditoria_usuario'                     => '',
                        'auditoria_fecha_hora'                  => '',
                        'auditoria_ip'                          => '',
    
                        'tipo_gerencia_codigo'                  => '',
                        'tipo_gerencia_codigo_nombre'           => '',
                        'tipo_gerencia_codigo_referencia'       => '',
                        'tipo_gerencia_nombre'                  => '',
    
                        'tipo_departamento_codigo'              => '',
                        'tipo_departamento_codigo_nombre'       => '',
                        'tipo_departamento_codigo_referencia'   => '',
                        'tipo_departamento_nombre'              => '',
                        
                        'tipo_jefatura_codigo'                  => '',
                        'tipo_jefatura_codigo_nombre'           => '',
                        'tipo_jefatura_codigo_referencia'       => '',
                        'tipo_jefatura_nombre'                  => '',
    
                        'tipo_cargo_codigo'                     => '',
                        'tipo_cargo_codigo_nombre'              => '',
                        'tipo_cargo_codigo_referencia'          => '',
                        'tipo_cargo_nombre'                     => '',
    
                        'evento_codigo'                         => '',
                        'evento_orden'                          => '',
                        'evento_nombre'                         => '',
                        'evento_fecha_inicio_1'                 => '',
                        'evento_fecha_inicio_2'                 => '',
                        'evento_fecha_fin_1'                    => '',
                        'evento_fecha_fin_2'                    => '',
                        'evento_observacion'                    => '',
    
                        'workflow_codigo'                       => '',
                        'workflow_orden'                        => '',
                        'workflow_tarea'                        => '',
                        
                        'estado_anterior_codigo'                => '',
                        'estado_anterior_ingles'                => '',
                        'estado_anterior_castellano'            => '',
                        'estado_anterior_portugues'             => '',
                        'estado_anterior_parametro'             => '',
                        'estado_anterior_icono'                 => '',
                        'estado_anterior_css'                   => '',
    
                        'estado_actual_codigo'                  => '',
                        'estado_actual_ingles'                  => '',
                        'estado_actual_castellano'              => '',
                        'estado_actual_portugues'               => '',
                        'estado_actual_parametro'               => '',
                        'estado_actual_icono'                   => '',
                        'estado_actual_css'                     => '',
    
                        'workflow_detalle_codigo'               => '',
                        'workflow_detalle_orden'                => '',
                        'workflow_detalle_cargo'                => '',
                        'workflow_detalle_hora'                 => '',
                        'workflow_detalle_tarea'                => '',
    
                        'tipo_prioridad_codigo'                 => '',
                        'tipo_prioridad_ingles'                 => '',
                        'tipo_prioridad_castellano'             => '',
                        'tipo_prioridad_portugues'              => '',
                        'tipo_prioridad_parametro'              => '',
                        'tipo_prioridad_icono'                  => '',
                        'tipo_prioridad_css'                    => ''
                    );

                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                }

                $stmtMSSQL00->closeCursor();
                $stmtMSSQL00 = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        }  else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v2/400/solicitud/char01/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val01  = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
            '1' AS solicitud_codigo,
            'solicitud_total' AS solicitud_tipo,
            COUNT(*) AS solicitud_cantidad

            FROM [via].[SOLFIC] a
            WHERE (a.SOLFICDNS = ? OR a.SOLFICDNJ = ? OR a.SOLFICDNE = ? OR a.SOLFICDNP = ?)

            UNION ALL

            SELECT
            '2' AS solicitud_codigo,
            'solicitud_pendiente' AS solicitud_tipo,
            COUNT(*) AS solicitud_cantidad

            FROM [via].[SOLFIC] a
            WHERE (a.SOLFICDNS = ? OR a.SOLFICDNJ = ? OR a.SOLFICDNE = ? OR a.SOLFICDNP = ?)";

            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val01, $val01, $val01, $val01, $val01, $val01, $val01, $val01]);

                while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {    
                    $detalle = array(                    
                        'solicitud_codigo'                      => $rowMSSQL00['solicitud_codigo'],
                        'solicitud_tipo'                        => trim(strtoupper(strtolower($rowMSSQL00['solicitud_tipo']))),
                        'solicitud_cantidad'                    => $rowMSSQL00['solicitud_cantidad']
                    );
    
                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle    = array(
                        'solicitud_codigo'                      => '',
                        'solicitud_tipo'                        => '',
                        'solicitud_cantidad'                    => ''
                    );

                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                }

                $stmtMSSQL00->closeCursor();
                $stmtMSSQL00 = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        }  else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v2/400/solicitud/detalle/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val01  = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
                a.SOLDETCOD         AS          solicitud_detalle_codigo,
                a.SOLDETPRE         AS          solicitud_detalle_preferencia,
                a.SOLDETSLU         AS          solicitud_detalle_salida_lugar,
                a.SOLDETSFE         AS          solicitud_detalle_salida_fecha,
                a.SOLDETSHO         AS          solicitud_detalle_salida_hora,
                a.SOLDETRLU         AS          solicitud_detalle_retorno_lugar,
                a.SOLDETRFE         AS          solicitud_detalle_retorno_fecha,
                a.SOLDETRHO         AS          solicitud_detalle_retorno_hora,
                a.SOLDETALU         AS          solicitud_detalle_auditorio_lugar,
                a.SOLDETAFE         AS          solicitud_detalle_auditorio_fecha,
                a.SOLDETAHO         AS          solicitud_detalle_auditorio_hora,
                a.SOLDETACA         AS          solicitud_detalle_auditorio_cantidad,
                a.SOLDETOBS         AS          solicitud_detalle_observacion,

                a.SOLDETAUS         AS          auditoria_usuario,
                a.SOLDETAFH         AS          auditoria_fecha_hora,
                a.SOLDETAIP         AS          auditoria_ip,

                b.DOMFICCOD         AS          tipo_estado_codigo,
                b.DOMFICNOI         AS          tipo_estado_ingles,
                b.DOMFICNOC         AS          tipo_estado_castellano,
                b.DOMFICNOP         AS          tipo_estado_portugues,
                b.DOMFICPAR         AS          tipo_estado_parametro,
                b.DOMFICICO         AS          tipo_estado_icono,
                b.DOMFICCSS         AS          tipo_estado_css,

                c.DOMFICCOD         AS          tipo_solicitud_codigo,
                c.DOMFICNOI         AS          tipo_solicitud_ingles,
                c.DOMFICNOC         AS          tipo_solicitud_castellano,
                c.DOMFICNOP         AS          tipo_solicitud_portugues,
                c.DOMFICPAR         AS          tipo_solicitud_parametro,
                c.DOMFICICO         AS          tipo_solicitud_icono,
                c.DOMFICCSS         AS          tipo_solicitud_css,

                d.SOLFICCOD         AS          solicitud_codigo,
                d.SOLFICPER         AS          solicitud_periodo,
                d.SOLFICMOT         AS          solicitud_motivo,
                d.SOLFICPAS         AS          solicitud_pasaje,
                d.SOLFICHOS         AS          solicitud_hospedaje,
                d.SOLFICTRA         AS          solicitud_traslado,
                d.SOLFICFEC         AS          solicitud_fecha_carga,
                d.SOLFICSCC         AS          solicitud_sap_centro_costo,
                d.SOLFICTCA         AS          solicitud_tarea_cantidad,
                d.SOLFICTRE         AS          solicitud_tarea_resuelta,
                d.SOLFICOBS         AS          solicitud_observacion,

                e.LOCAERCOD         AS          solicitud_detalle_salida_aeropuerto_codigo,
                e.LOCAERORD         AS          solicitud_detalle_salida_aeropuerto_orden,
                e.LOCAERNOM         AS          solicitud_detalle_salida_aeropuerto_nombre,
                e.LOCAEROBS         AS          solicitud_detalle_salida_aeropuerto_observacion,

                f.LOCCIUCOD         AS          solicitud_detalle_salida_ciudad_codigo,
                f.LOCCIUORD         AS          solicitud_detalle_salida_ciudad_orden,
                f.LOCCIUNOM         AS          solicitud_detalle_salida_ciudad_nombre,
                f.LOCCIUOBS         AS          solicitud_detalle_salida_ciudad_observacion,

                g.LOCPAICOD         AS          solicitud_detalle_salida_pais_codigo,
                g.LOCPAIORD         AS          solicitud_detalle_salida_pais_orden,
                g.LOCPAINOM         AS          solicitud_detalle_salida_pais_nombre,
                g.LOCPAIPAT         AS          solicitud_detalle_salida_pais_path,
                g.LOCPAIIC2         AS          solicitud_detalle_salida_pais_iso_char2,
                g.LOCPAIIC3         AS          solicitud_detalle_salida_pais_iso_char3,
                g.LOCPAIIN3         AS          solicitud_detalle_salida_pais_iso_num3,
                g.LOCPAIOBS         AS          solicitud_detalle_salida_pais_observacion,

                h.DOMFICCOD         AS          solicitud_detalle_salida_horario_codigo,
                h.DOMFICNOI         AS          solicitud_detalle_salida_horario_ingles,
                h.DOMFICNOC         AS          solicitud_detalle_salida_horario_castellano,
                h.DOMFICNOP         AS          solicitud_detalle_salida_horario_portugues,
                h.DOMFICPAR         AS          solicitud_detalle_salida_horario_parametro,
                h.DOMFICICO         AS          solicitud_detalle_salida_horario_icono,
                h.DOMFICCSS         AS          solicitud_detalle_salida_horario_css,

                i.LOCAERCOD         AS          solicitud_detalle_retorno_aeropuerto_codigo,
                i.LOCAERORD         AS          solicitud_detalle_retorno_aeropuerto_orden,
                i.LOCAERNOM         AS          solicitud_detalle_retorno_aeropuerto_nombre,
                i.LOCAEROBS         AS          solicitud_detalle_retorno_aeropuerto_observacion,

                j.LOCCIUCOD         AS          solicitud_detalle_retorno_ciudad_codigo,
                j.LOCCIUORD         AS          solicitud_detalle_retorno_ciudad_orden,
                j.LOCCIUNOM         AS          solicitud_detalle_retorno_ciudad_nombre,
                j.LOCCIUOBS         AS          solicitud_detalle_retorno_ciudad_observacion,

                k.LOCPAICOD         AS          solicitud_detalle_retorno_pais_codigo,
                k.LOCPAIORD         AS          solicitud_detalle_retorno_pais_orden,
                k.LOCPAINOM         AS          solicitud_detalle_retorno_pais_nombre,
                k.LOCPAIPAT         AS          solicitud_detalle_retorno_pais_path,
                k.LOCPAIIC2         AS          solicitud_detalle_retorno_pais_iso_char2,
                k.LOCPAIIC3         AS          solicitud_detalle_retorno_pais_iso_char3,
                k.LOCPAIIN3         AS          solicitud_detalle_retorno_pais_iso_num3,
                k.LOCPAIOBS         AS          solicitud_detalle_retorno_pais_observacion,

                l.DOMFICCOD         AS          solicitud_detalle_retorno_horario_codigo,
                l.DOMFICNOI         AS          solicitud_detalle_retorno_horario_ingles,
                l.DOMFICNOC         AS          solicitud_detalle_retorno_horario_castellano,
                l.DOMFICNOP         AS          solicitud_detalle_retorno_horario_portugues,
                l.DOMFICPAR         AS          solicitud_detalle_retorno_horario_parametro,
                l.DOMFICICO         AS          solicitud_detalle_retorno_horario_icono,
                l.DOMFICCSS         AS          solicitud_detalle_retorno_horario_css,

                m.LOCCIUCOD         AS          solicitud_detalle_auditorio_ciudad_codigo,
                m.LOCCIUORD         AS          solicitud_detalle_auditorio_ciudad_orden,
                m.LOCCIUNOM         AS          solicitud_detalle_auditorio_ciudad_nombre,
                m.LOCCIUOBS         AS          solicitud_detalle_auditorio_ciudad_observacion,

                n.LOCPAICOD         AS          solicitud_detalle_auditorio_pais_codigo,
                n.LOCPAIORD         AS          solicitud_detalle_auditorio_pais_orden,
                n.LOCPAINOM         AS          solicitud_detalle_auditorio_pais_nombre,
                n.LOCPAIPAT         AS          solicitud_detalle_auditorio_pais_path,
                n.LOCPAIIC2         AS          solicitud_detalle_auditorio_pais_iso_char2,
                n.LOCPAIIC3         AS          solicitud_detalle_auditorio_pais_iso_char3,
                n.LOCPAIIN3         AS          solicitud_detalle_auditorio_pais_iso_num3,
                n.LOCPAIOBS         AS          solicitud_detalle_auditorio_pais_observacion,

                o.DOMFICCOD         AS          solicitud_detalle_auditorio_horario_codigo,
                o.DOMFICNOI         AS          solicitud_detalle_auditorio_horario_ingles,
                o.DOMFICNOC         AS          solicitud_detalle_auditorio_horario_castellano,
                o.DOMFICNOP         AS          solicitud_detalle_auditorio_horario_portugues,
                o.DOMFICPAR         AS          solicitud_detalle_auditorio_horario_parametro,
                o.DOMFICICO         AS          solicitud_detalle_auditorio_horario_icono,
                o.DOMFICCSS         AS          solicitud_detalle_auditorio_horario_css

                FROM [via].[SOLDET] a
                INNER JOIN [adm].[DOMFIC] b ON a.SOLDETEST = b.DOMFICCOD
                INNER JOIN [adm].[DOMFIC] c ON a.SOLDETTSC = c.DOMFICCOD
                INNER JOIN [via].[SOLFIC] d ON a.SOLDETSOC = d.SOLFICCOD

                LEFT OUTER JOIN [adm].[LOCAER] e ON a.SOLDETSAE = e.LOCAERCOD
                LEFT OUTER JOIN [adm].[LOCCIU] f ON a.SOLDETSCI = f.LOCCIUCOD
                LEFT OUTER JOIN [adm].[LOCPAI] g ON f.LOCCIUPAC = g.LOCPAICOD
                LEFT OUTER JOIN [adm].[DOMFIC] h ON a.SOLDETSHR = h.DOMFICCOD

                LEFT OUTER JOIN [adm].[LOCAER] i ON a.SOLDETRAE = i.LOCAERCOD
                LEFT OUTER JOIN [adm].[LOCCIU] j ON a.SOLDETRCI = j.LOCCIUCOD
                LEFT OUTER JOIN [adm].[LOCPAI] k ON j.LOCCIUPAC = k.LOCPAICOD
                LEFT OUTER JOIN [adm].[DOMFIC] l ON a.SOLDETRHR = l.DOMFICCOD

                LEFT OUTER JOIN [adm].[LOCCIU] m ON a.SOLDETACI = m.LOCCIUCOD
                LEFT OUTER JOIN [adm].[LOCPAI] n ON j.LOCCIUPAC = n.LOCPAICOD
                LEFT OUTER JOIN [adm].[DOMFIC] o ON a.SOLDETAHR = o.DOMFICCOD

                WHERE a.SOLDETSOC = ?

                ORDER BY a.SOLDETTSC";

            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val01]);

                while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                    if(!empty($rowMSSQL00['solicitud_detalle_salida_fecha'])){
                        $solicitud_detalle_salida_fecha_2    = date("d/m/Y", strtotime($rowMSSQL00['solicitud_detalle_salida_fecha']));
                    } else {
                        $solicitud_detalle_salida_fecha_2    = '';
                    }

                    if(!empty($rowMSSQL00['solicitud_detalle_retorno_fecha'])){
                        $solicitud_detalle_retorno_fecha_2    = date("d/m/Y", strtotime($rowMSSQL00['solicitud_detalle_retorno_fecha']));
                    } else {
                        $solicitud_detalle_retorno_fecha_2    = '';
                    }

                    if(!empty($rowMSSQL00['solicitud_detalle_auditorio_fecha'])){
                        $solicitud_detalle_auditorio_fecha_2    = date("d/m/Y", strtotime($rowMSSQL00['solicitud_detalle_auditorio_fecha']));
                    } else {
                        $solicitud_detalle_auditorio_fecha_2    = '';
                    }

                    if(!empty($rowMSSQL00['solicitud_fecha_carga'])){
                        $solicitud_fecha_carga_2    = date("d/m/Y", strtotime($rowMSSQL00['solicitud_fecha_carga']));
                    } else {
                        $solicitud_fecha_carga_2    = '';
                    }

                    $detalle = array(
                        'solicitud_detalle_codigo'                                  => $rowMSSQL00['solicitud_detalle_codigo'],
                        'solicitud_detalle_preferencia'                             => trim(strtoupper(strtolower($rowMSSQL00['solicitud_detalle_preferencia']))),
                        'solicitud_detalle_salida_lugar'                            => trim(strtoupper(strtolower($rowMSSQL00['solicitud_detalle_salida_lugar']))),
                        'solicitud_detalle_salida_fecha_1'                          => $rowMSSQL00['solicitud_detalle_salida_fecha'],
                        'solicitud_detalle_salida_fecha_2'                          => $solicitud_detalle_salida_fecha_2,
                        'solicitud_detalle_salida_hora'                             => trim(strtoupper(strtolower($rowMSSQL00['solicitud_detalle_salida_hora']))),
                        'solicitud_detalle_retorno_lugar'                           => trim(strtoupper(strtolower($rowMSSQL00['solicitud_detalle_retorno_lugar']))),
                        'solicitud_detalle_retorno_fecha_1'                         => $rowMSSQL00['solicitud_detalle_retorno_fecha'],
                        'solicitud_detalle_retorno_fecha_2'                         => $solicitud_detalle_retorno_fecha_2,
                        'solicitud_detalle_retorno_hora'                            => trim(strtoupper(strtolower($rowMSSQL00['solicitud_detalle_retorno_hora']))),
                        'solicitud_detalle_auditorio_lugar'                         => trim(strtoupper(strtolower($rowMSSQL00['solicitud_detalle_auditorio_lugar']))),
                        'solicitud_detalle_auditorio_fecha_1'                       => $rowMSSQL00['solicitud_detalle_auditorio_fecha'],
                        'solicitud_detalle_auditorio_fecha_2'                       => $solicitud_detalle_auditorio_fecha_2,
                        'solicitud_detalle_auditorio_hora'                          => trim(strtoupper(strtolower($rowMSSQL00['solicitud_detalle_auditorio_hora']))),
                        'solicitud_detalle_auditorio_cantidad'                      => $rowMSSQL00['solicitud_detalle_auditorio_cantidad'],
                        'solicitud_detalle_observacion'                             => trim(strtoupper(strtolower($rowMSSQL00['solicitud_detalle_observacion']))),

                        'auditoria_usuario'                                         => trim(strtoupper(strtolower($rowMSSQL00['auditoria_usuario']))),
                        'auditoria_fecha_hora'                                      => date("d/m/Y", strtotime($rowMSSQL00['auditoria_fecha_hora'])),
                        'auditoria_ip'                                              => trim(strtoupper(strtolower($rowMSSQL00['auditoria_ip']))),

                        'tipo_estado_codigo'                                        => $rowMSSQL00['tipo_estado_codigo'],
                        'tipo_estado_ingles'                                        => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_ingles']))),
                        'tipo_estado_castellano'                                    => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_castellano']))),
                        'tipo_estado_portugues'                                     => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_portugues']))),
                        'tipo_estado_parametro'                                     => $rowMSSQL00['tipo_estado_parametro'],
                        'tipo_estado_icono'                                         => trim(strtolower($rowMSSQL00['tipo_estado_icono'])),
                        'tipo_estado_css'                                           => trim(strtolower($rowMSSQL00['tipo_estado_css'])),

                        'tipo_solicitud_codigo'                                     => $rowMSSQL00['tipo_solicitud_codigo'],
                        'tipo_solicitud_ingles'                                     => trim(strtoupper(strtolower($rowMSSQL00['tipo_solicitud_ingles']))),
                        'tipo_solicitud_castellano'                                 => trim(strtoupper(strtolower($rowMSSQL00['tipo_solicitud_castellano']))),
                        'tipo_solicitud_portugues'                                  => trim(strtoupper(strtolower($rowMSSQL00['tipo_solicitud_portugues']))),
                        'tipo_solicitud_parametro'                                  => $rowMSSQL00['tipo_solicitud_parametro'],
                        'tipo_solicitud_icono'                                      => trim(strtolower($rowMSSQL00['tipo_solicitud_icono'])),
                        'tipo_solicitud_css'                                        => trim(strtolower($rowMSSQL00['tipo_solicitud_css'])),

                        'solicitud_codigo'                                          => $rowMSSQL00['solicitud_codigo'],
                        'solicitud_periodo'                                         => $rowMSSQL00['solicitud_periodo'],
                        'solicitud_motivo'                                          => trim(strtoupper(strtolower($rowMSSQL00['solicitud_motivo']))),
                        'solicitud_pasaje'                                          => trim(strtoupper(strtolower($rowMSSQL00['solicitud_pasaje']))),
                        'solicitud_hospedaje'                                       => trim(strtoupper(strtolower($rowMSSQL00['solicitud_hospedaje']))),
                        'solicitud_traslado'                                        => trim(strtoupper(strtolower($rowMSSQL00['solicitud_traslado']))),
                        'solicitud_fecha_carga_1'                                   => $rowMSSQL00['solicitud_fecha_carga'],
                        'solicitud_fecha_carga_2'                                   => $solicitud_fecha_carga_2,
                        'solicitud_sap_centro_costo'                                => trim(strtoupper(strtolower($rowMSSQL00['solicitud_sap_centro_costo']))),
                        'solicitud_tarea_cantidad'                                  => $rowMSSQL00['solicitud_tarea_cantidad'],
                        'solicitud_tarea_resuelta'                                  => $rowMSSQL00['solicitud_tarea_resuelta'],
                        'solicitud_tarea_porcentaje'                                => number_format((($rowMSSQL00['solicitud_tarea_resuelta'] * 100) / $rowMSSQL00['solicitud_tarea_cantidad']), 2, '.', ''),
                        'solicitud_observacion'                                     => trim(strtoupper(strtolower($rowMSSQL00['solicitud_observacion']))),

                        'solicitud_detalle_salida_aeropuerto_codigo'                => $rowMSSQL00['solicitud_detalle_salida_aeropuerto_codigo'],
                        'solicitud_detalle_salida_aeropuerto_orden'                 => $rowMSSQL00['solicitud_detalle_salida_aeropuerto_orden'],
                        'solicitud_detalle_salida_aeropuerto_nombre'                => trim(strtoupper(strtolower($rowMSSQL00['solicitud_detalle_salida_aeropuerto_nombre']))),
                        'solicitud_detalle_salida_aeropuerto_observacion'           => trim(strtolower($rowMSSQL00['solicitud_detalle_salida_aeropuerto_observacion'])),

                        'solicitud_detalle_salida_ciudad_codigo'                    => $rowMSSQL00['solicitud_detalle_salida_ciudad_codigo'],
                        'solicitud_detalle_salida_ciudad_orden'                     => $rowMSSQL00['solicitud_detalle_salida_ciudad_orden'],
                        'solicitud_detalle_salida_ciudad_nombre'                    => trim(strtoupper(strtolower($rowMSSQL00['solicitud_detalle_salida_ciudad_nombre']))),
                        'solicitud_detalle_salida_ciudad_observacion'               => trim(strtolower($rowMSSQL00['solicitud_detalle_salida_ciudad_observacion'])),

                        'solicitud_detalle_salida_pais_codigo'                      => $rowMSSQL00['solicitud_detalle_salida_pais_codigo'],
                        'solicitud_detalle_salida_pais_orden'                       => $rowMSSQL00['solicitud_detalle_salida_pais_orden'],
                        'solicitud_detalle_salida_pais_nombre'                      => trim(strtoupper(strtolower($rowMSSQL00['solicitud_detalle_salida_pais_nombre']))),
                        'solicitud_detalle_salida_pais_path'                        => trim(strtolower($rowMSSQL00['solicitud_detalle_salida_pais_path'])),
                        'solicitud_detalle_salida_pais_iso_char2'                   => trim(strtoupper(strtolower($rowMSSQL00['solicitud_detalle_salida_pais_iso_char2']))),
                        'solicitud_detalle_salida_pais_iso_char3'                   => trim(strtoupper(strtolower($rowMSSQL00['solicitud_detalle_salida_pais_iso_char3']))),
                        'solicitud_detalle_salida_pais_iso_num3'                    => trim(strtoupper(strtolower($rowMSSQL00['solicitud_detalle_salida_pais_iso_num3']))),
                        'solicitud_detalle_salida_pais_observacion'                 => trim(strtoupper(strtolower($rowMSSQL00['solicitud_detalle_salida_pais_observacion']))),

                        'solicitud_detalle_salida_horario_codigo'                   => $rowMSSQL00['solicitud_detalle_salida_horario_codigo'],
                        'solicitud_detalle_salida_horario_ingles'                   => trim(strtoupper(strtolower($rowMSSQL00['solicitud_detalle_salida_horario_ingles']))),
                        'solicitud_detalle_salida_horario_castellano'               => trim(strtoupper(strtolower($rowMSSQL00['solicitud_detalle_salida_horario_castellano']))),
                        'solicitud_detalle_salida_horario_portugues'                => trim(strtoupper(strtolower($rowMSSQL00['solicitud_detalle_salida_horario_portugues']))),
                        'solicitud_detalle_salida_horario_parametro'                => $rowMSSQL00['solicitud_detalle_salida_horario_parametro'],
                        'solicitud_detalle_salida_horario_icono'                    => trim(strtolower($rowMSSQL00['solicitud_detalle_salida_horario_icono'])),
                        'solicitud_detalle_salida_horario_css'                      => trim(strtolower($rowMSSQL00['solicitud_detalle_salida_horario_css'])),

                        'solicitud_detalle_retorno_aeropuerto_codigo'               => $rowMSSQL00['solicitud_detalle_retorno_aeropuerto_codigo'],
                        'solicitud_detalle_retorno_aeropuerto_orden'                => $rowMSSQL00['solicitud_detalle_retorno_aeropuerto_orden'],
                        'solicitud_detalle_retorno_aeropuerto_nombre'               => trim(strtoupper(strtolower($rowMSSQL00['solicitud_detalle_retorno_aeropuerto_nombre']))),
                        'solicitud_detalle_retorno_aeropuerto_observacion'          => trim(strtolower($rowMSSQL00['solicitud_detalle_retorno_aeropuerto_observacion'])),

                        'solicitud_detalle_retorno_ciudad_codigo'                   => $rowMSSQL00['solicitud_detalle_retorno_ciudad_codigo'],
                        'solicitud_detalle_retorno_ciudad_orden'                    => $rowMSSQL00['solicitud_detalle_retorno_ciudad_orden'],
                        'solicitud_detalle_retorno_ciudad_nombre'                   => trim(strtoupper(strtolower($rowMSSQL00['solicitud_detalle_retorno_ciudad_nombre']))),
                        'solicitud_detalle_retorno_ciudad_observacion'              => trim(strtolower($rowMSSQL00['solicitud_detalle_retorno_ciudad_observacion'])),

                        'solicitud_detalle_retorno_pais_codigo'                     => $rowMSSQL00['solicitud_detalle_retorno_pais_codigo'],
                        'solicitud_detalle_retorno_pais_orden'                      => $rowMSSQL00['solicitud_detalle_retorno_pais_orden'],
                        'solicitud_detalle_retorno_pais_nombre'                     => trim(strtoupper(strtolower($rowMSSQL00['solicitud_detalle_retorno_pais_nombre']))),
                        'solicitud_detalle_retorno_pais_path'                       => trim(strtolower($rowMSSQL00['solicitud_detalle_retorno_pais_path'])),
                        'solicitud_detalle_retorno_pais_iso_char2'                  => trim(strtoupper(strtolower($rowMSSQL00['solicitud_detalle_retorno_pais_iso_char2']))),
                        'solicitud_detalle_retorno_pais_iso_char3'                  => trim(strtoupper(strtolower($rowMSSQL00['solicitud_detalle_retorno_pais_iso_char3']))),
                        'solicitud_detalle_retorno_pais_iso_num3'                   => trim(strtoupper(strtolower($rowMSSQL00['solicitud_detalle_retorno_pais_iso_num3']))),
                        'solicitud_detalle_retorno_pais_observacion'                => trim(strtoupper(strtolower($rowMSSQL00['solicitud_detalle_retorno_pais_observacion']))),

                        'solicitud_detalle_retorno_horario_codigo'                  => $rowMSSQL00['solicitud_detalle_retorno_horario_codigo'],
                        'solicitud_detalle_retorno_horario_ingles'                  => trim(strtoupper(strtolower($rowMSSQL00['solicitud_detalle_retorno_horario_ingles']))),
                        'solicitud_detalle_retorno_horario_castellano'              => trim(strtoupper(strtolower($rowMSSQL00['solicitud_detalle_retorno_horario_castellano']))),
                        'solicitud_detalle_retorno_horario_portugues'               => trim(strtoupper(strtolower($rowMSSQL00['solicitud_detalle_retorno_horario_portugues']))),
                        'solicitud_detalle_retorno_horario_parametro'               => $rowMSSQL00['solicitud_detalle_retorno_horario_parametro'],
                        'solicitud_detalle_retorno_horario_icono'                   => trim(strtolower($rowMSSQL00['solicitud_detalle_retorno_horario_icono'])),
                        'solicitud_detalle_retorno_horario_css'                     => trim(strtolower($rowMSSQL00['solicitud_detalle_retorno_horario_css'])),

                        'solicitud_detalle_auditorio_ciudad_codigo'                 => $rowMSSQL00['solicitud_detalle_auditorio_ciudad_codigo'],
                        'solicitud_detalle_auditorio_ciudad_orden'                  => $rowMSSQL00['solicitud_detalle_auditorio_ciudad_orden'],
                        'solicitud_detalle_auditorio_ciudad_nombre'                 => trim(strtoupper(strtolower($rowMSSQL00['solicitud_detalle_auditorio_ciudad_nombre']))),
                        'solicitud_detalle_auditorio_ciudad_observacion'            => trim(strtolower($rowMSSQL00['solicitud_detalle_auditorio_ciudad_observacion'])),

                        'solicitud_detalle_auditorio_pais_codigo'                   => $rowMSSQL00['solicitud_detalle_auditorio_pais_codigo'],
                        'solicitud_detalle_auditorio_pais_orden'                    => $rowMSSQL00['solicitud_detalle_auditorio_pais_orden'],
                        'solicitud_detalle_auditorio_pais_nombre'                   => trim(strtoupper(strtolower($rowMSSQL00['solicitud_detalle_auditorio_pais_nombre']))),
                        'solicitud_detalle_auditorio_pais_path'                     => trim(strtolower($rowMSSQL00['solicitud_detalle_auditorio_pais_path'])),
                        'solicitud_detalle_auditorio_pais_iso_char2'                => trim(strtoupper(strtolower($rowMSSQL00['solicitud_detalle_auditorio_pais_iso_char2']))),
                        'solicitud_detalle_auditorio_pais_iso_char3'                => trim(strtoupper(strtolower($rowMSSQL00['solicitud_detalle_auditorio_pais_iso_char3']))),
                        'solicitud_detalle_auditorio_pais_iso_num3'                 => trim(strtoupper(strtolower($rowMSSQL00['solicitud_detalle_auditorio_pais_iso_num3']))),
                        'solicitud_detalle_auditorio_pais_observacion'              => trim(strtoupper(strtolower($rowMSSQL00['solicitud_detalle_auditorio_pais_observacion']))),

                        'solicitud_detalle_auditorio_horario_codigo'                => $rowMSSQL00['solicitud_detalle_auditorio_horario_codigo'],
                        'solicitud_detalle_auditorio_horario_ingles'                => trim(strtoupper(strtolower($rowMSSQL00['solicitud_detalle_auditorio_horario_ingles']))),
                        'solicitud_detalle_auditorio_horario_castellano'            => trim(strtoupper(strtolower($rowMSSQL00['solicitud_detalle_auditorio_horario_castellano']))),
                        'solicitud_detalle_auditorio_horario_portugues'             => trim(strtoupper(strtolower($rowMSSQL00['solicitud_detalle_auditorio_horario_portugues']))),
                        'solicitud_detalle_auditorio_horario_parametro'             => $rowMSSQL00['solicitud_detalle_auditorio_horario_parametro'],
                        'solicitud_detalle_auditorio_horario_icono'                 => trim(strtolower($rowMSSQL00['solicitud_detalle_auditorio_horario_icono'])),
                        'solicitud_detalle_auditorio_horario_css'                   => trim(strtolower($rowMSSQL00['solicitud_detalle_auditorio_horario_css']))
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle    = array(
                        'solicitud_detalle_codigo'                                  => '',
                        'solicitud_detalle_preferencia'                             => '',
                        'solicitud_detalle_salida_lugar'                            => '',
                        'solicitud_detalle_salida_fecha_1'                          => '',
                        'solicitud_detalle_salida_fecha_2'                          => '',
                        'solicitud_detalle_salida_hora'                             => '',
                        'solicitud_detalle_retorno_lugar'                           => '',
                        'solicitud_detalle_retorno_fecha_1'                         => '',
                        'solicitud_detalle_retorno_fecha_2'                         => '',
                        'solicitud_detalle_retorno_hora'                            => '',
                        'solicitud_detalle_auditorio_lugar'                         => '',
                        'solicitud_detalle_auditorio_fecha_1'                       => '',
                        'solicitud_detalle_auditorio_fecha_2'                       => '',
                        'solicitud_detalle_auditorio_hora'                          => '',
                        'solicitud_detalle_auditorio_cantidad'                      => '',
                        'solicitud_detalle_observacion'                             => '',

                        'auditoria_usuario'                                         => '',
                        'auditoria_fecha_hora'                                      => '',
                        'auditoria_ip'                                              => '',

                        'tipo_estado_codigo'                                        => '',
                        'tipo_estado_ingles'                                        => '',
                        'tipo_estado_castellano'                                    => '',
                        'tipo_estado_portugues'                                     => '',
                        'tipo_estado_parametro'                                     => '',
                        'tipo_estado_icono'                                         => '',
                        'tipo_estado_css'                                           => '',

                        'tipo_solicitud_codigo'                                     => '',
                        'tipo_solicitud_ingles'                                     => '',
                        'tipo_solicitud_castellano'                                 => '',
                        'tipo_solicitud_portugues'                                  => '',
                        'tipo_solicitud_parametro'                                  => '',
                        'tipo_solicitud_icono'                                      => '',
                        'tipo_solicitud_css'                                        => '',

                        'solicitud_codigo'                                          => '',
                        'solicitud_periodo'                                         => '',
                        'solicitud_motivo'                                          => '',
                        'solicitud_pasaje'                                          => '',
                        'solicitud_hospedaje'                                       => '',
                        'solicitud_traslado'                                        => '',
                        'solicitud_fecha_carga_1'                                   => '',
                        'solicitud_fecha_carga_2'                                   => '',
                        'solicitud_sap_centro_costo'                                => '',
                        'solicitud_tarea_cantidad'                                  => '',
                        'solicitud_tarea_resuelta'                                  => '',
                        'solicitud_tarea_porcentaje'                                => '',
                        'solicitud_observacion'                                     => '',

                        'solicitud_detalle_salida_aeropuerto_codigo'                => '',
                        'solicitud_detalle_salida_aeropuerto_orden'                 => '',
                        'solicitud_detalle_salida_aeropuerto_nombre'                => '',
                        'solicitud_detalle_salida_aeropuerto_observacion'           => '',

                        'solicitud_detalle_salida_ciudad_codigo'                    => '',
                        'solicitud_detalle_salida_ciudad_orden'                     => '',
                        'solicitud_detalle_salida_ciudad_nombre'                    => '',
                        'solicitud_detalle_salida_ciudad_observacion'               => '',

                        'solicitud_detalle_salida_pais_codigo'                      => '',
                        'solicitud_detalle_salida_pais_orden'                       => '',
                        'solicitud_detalle_salida_pais_nombre'                      => '',
                        'solicitud_detalle_salida_pais_path'                        => '',
                        'solicitud_detalle_salida_pais_iso_char2'                   => '',
                        'solicitud_detalle_salida_pais_iso_char3'                   => '',
                        'solicitud_detalle_salida_pais_iso_num3'                    => '',
                        'solicitud_detalle_salida_pais_observacion'                 => '',

                        'solicitud_detalle_salida_horario_codigo'                   => '',
                        'solicitud_detalle_salida_horario_ingles'                   => '',
                        'solicitud_detalle_salida_horario_castellano'               => '',
                        'solicitud_detalle_salida_horario_portugues'                => '',
                        'solicitud_detalle_salida_horario_parametro'                => '',
                        'solicitud_detalle_salida_horario_icono'                    => '',
                        'solicitud_detalle_salida_horario_css'                      => '',

                        'solicitud_detalle_retorno_aeropuerto_codigo'               => '',
                        'solicitud_detalle_retorno_aeropuerto_orden'                => '',
                        'solicitud_detalle_retorno_aeropuerto_nombre'               => '',
                        'solicitud_detalle_retorno_aeropuerto_observacion'          => '',

                        'solicitud_detalle_retorno_ciudad_codigo'                   => '',
                        'solicitud_detalle_retorno_ciudad_orden'                    => '',
                        'solicitud_detalle_retorno_ciudad_nombre'                   => '',
                        'solicitud_detalle_retorno_ciudad_observacion'              => '',

                        'solicitud_detalle_retorno_pais_codigo'                     => '',
                        'solicitud_detalle_retorno_pais_orden'                      => '',
                        'solicitud_detalle_retorno_pais_nombre'                     => '',
                        'solicitud_detalle_retorno_pais_path'                       => '',
                        'solicitud_detalle_retorno_pais_iso_char2'                  => '',
                        'solicitud_detalle_retorno_pais_iso_char3'                  => '',
                        'solicitud_detalle_retorno_pais_iso_num3'                   => '',
                        'solicitud_detalle_retorno_pais_observacion'                => '',

                        'solicitud_detalle_retorno_horario_codigo'                  => '',
                        'solicitud_detalle_retorno_horario_ingles'                  => '',
                        'solicitud_detalle_retorno_horario_castellano'              => '',
                        'solicitud_detalle_retorno_horario_portugues'               => '',
                        'solicitud_detalle_retorno_horario_parametro'               => '',
                        'solicitud_detalle_retorno_horario_icono'                   => '',
                        'solicitud_detalle_retorno_horario_css'                     => '',

                        'solicitud_detalle_auditorio_ciudad_codigo'                 => '',
                        'solicitud_detalle_auditorio_ciudad_orden'                  => '',
                        'solicitud_detalle_auditorio_ciudad_nombre'                 => '',
                        'solicitud_detalle_auditorio_ciudad_observacion'            => '',

                        'solicitud_detalle_auditorio_pais_codigo'                   => '',
                        'solicitud_detalle_auditorio_pais_orden'                    => '',
                        'solicitud_detalle_auditorio_pais_nombre'                   => '',
                        'solicitud_detalle_auditorio_pais_path'                     => '',
                        'solicitud_detalle_auditorio_pais_iso_char2'                => '',
                        'solicitud_detalle_auditorio_pais_iso_char3'                => '',
                        'solicitud_detalle_auditorio_pais_iso_num3'                 => '',
                        'solicitud_detalle_auditorio_pais_observacion'              => '',

                        'solicitud_detalle_auditorio_horario_codigo'                => '',
                        'solicitud_detalle_auditorio_horario_ingles'                => '',
                        'solicitud_detalle_auditorio_horario_castellano'            => '',
                        'solicitud_detalle_auditorio_horario_portugues'             => '',
                        'solicitud_detalle_auditorio_horario_parametro'             => '',
                        'solicitud_detalle_auditorio_horario_icono'                 => '',
                        'solicitud_detalle_auditorio_horario_css'                   => ''
                    );

                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                }

                $stmtMSSQL00->closeCursor();
                $stmtMSSQL00 = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        }  else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });
/*MODULO VIAJE*/

/*MODULO RENDICION*/
    $app->get('/v2/500/rendicion', function($request) {
        require __DIR__.'/../src/connect.php';

        $sql00  = "SELECT
            a.RENFICCOD         AS          rendicion_codigo,
            a.RENFICPER         AS          rendicion_periodo,
            a.RENFICENO         AS          rendicion_evento_nombre,
            a.RENFICEFE         AS          rendicion_evento_fecha,
            a.RENFICDNS         AS          rendicion_documento_solicitante,
            a.RENFICDNJ         AS          rendicion_documento_jefatura,
            a.RENFICDNA         AS          rendicion_documento_analista,
            a.RENFICFEC         AS          rendicion_carga_fecha,
            a.RENFICTCA         AS          rendicion_tarea_cantidad,
            a.RENFICTRE         AS          rendicion_tarea_resuelta,
            a.RENFICOBS         AS          rendicion_observacion,

            a.RENFICAUS         AS          auditoria_usuario,
            a.RENFICAFH         AS          auditoria_fecha_hora,
            a.RENFICAIP         AS          auditoria_ip,

            b.CODE              AS          tipo_gerencia_codigo,
            b.NAME              AS          tipo_gerencia_codigo_nombre,
            b.U_CODIGO          AS          tipo_gerencia_codigo_referencia,
            b.U_NOMBRE          AS          tipo_gerencia_nombre,

            c.CODE              AS          tipo_departamento_codigo,
            c.NAME              AS          tipo_departamento_codigo_nombre,
            c.U_CODIGO          AS          tipo_departamento_codigo_referencia,
            c.U_NOMBRE          AS          tipo_departamento_nombre,

            d.CODE              AS          tipo_jefatura_codigo_referencia,
            d.NAME              AS          tipo_jefatura_codigo_nombre,
            d.U_CODIGO          AS          tipo_jefatura_codigo,
            d.U_NOMBRE          AS          tipo_jefatura_nombre,

            e.CODE              AS          tipo_cargo_codigo_referencia,
            e.NAME              AS          tipo_cargo_codigo_nombre,
            e.U_CODIGO          AS          tipo_cargo_codigo,
            e.U_NOMBRE          AS          tipo_cargo_nombre,

            f.LOCCIUCOD         AS          ciudad_codigo,
            f.LOCCIUORD         AS          ciudad_orden,
            f.LOCCIUNOM         AS          ciudad_nombre,

            g.LOCPAICOD         AS          pais_codigo,
            g.LOCPAIORD         AS          pais_orden,
            g.LOCPAINOM         AS          pais_nombre,
            g.LOCPAIPAT         AS          pais_path,
            g.LOCPAIIC2         AS          pais_iso_char2,
            g.LOCPAIIC3         AS          pais_iso_char3,
            g.LOCPAIIN3         AS          pais_iso_num3,

            h.WRKFICCOD         AS          workflow_codigo,
            h.WRKFICORD         AS          workflow_orden,
            h.WRKFICNOM         AS          workflow_tarea,

            i.DOMFICCOD         AS          estado_anterior_codigo,
            i.DOMFICNOI         AS          estado_anterior_ingles,
            i.DOMFICNOC         AS          estado_anterior_castellano,
            i.DOMFICNOP         AS          estado_anterior_portugues,
            i.DOMFICCSS         AS          estado_anterior_css,
            i.DOMFICPAR         AS          estado_anterior_parametro,

            j.DOMFICCOD         AS          estado_actual_codigo,
            j.DOMFICNOI         AS          estado_actual_ingles,
            j.DOMFICNOC         AS          estado_actual_castellano,
            j.DOMFICNOP         AS          estado_actual_portugues,
            j.DOMFICCSS         AS          estado_actual_css,
            j.DOMFICPAR         AS          estado_actual_parametro,

            k.WRKDETCOD         AS          workflow_detalle_codigo,
            k.WRKDETORD         AS          workflow_detalle_orden,
            k.WRKDETTCC         AS          workflow_detalle_cargo,
            k.WRKDETHOR         AS          workflow_detalle_hora,
            k.WRKDETNOM         AS          workflow_detalle_tarea,

            l.DOMFICCOD         AS          tipo_prioridad_codigo,
            l.DOMFICNOI         AS          tipo_prioridad_ingles,
            l.DOMFICNOC         AS          tipo_prioridad_castellano,
            l.DOMFICNOP         AS          tipo_prioridad_portugues,
            l.DOMFICCSS         AS          tipo_prioridad_css,
            l.DOMFICPAR         AS          tipo_prioridad_parametro,

            m1.NombreEmpleado   AS          rendicion_nombre_solicitante,
            m2.NombreEmpleado   AS          rendicion_nombre_jefatura,
            m3.NombreEmpleado   AS          rendicion_nombre_analista

            FROM [con].[RENFIC] a
            INNER JOIN [CSF].[dbo].[@A1A_TIGE] b ON a.RENFICGEC = b.U_CODIGO
            INNER JOIN [CSF].[dbo].[@A1A_TIDE] c ON a.RENFICDEC = c.U_CODIGO
            INNER JOIN [CSF].[dbo].[@A1A_TICA] d ON a.RENFICJEC = d.U_CODIGO
            INNER JOIN [CSF].[dbo].[@A1A_TICA] e ON a.RENFICCAC = e.U_CODIGO
            INNER JOIN [adm].[LOCCIU] f ON a.RENFICCIC = f.LOCCIUCOD
            INNER JOIN [adm].[LOCPAI] g ON f.LOCCIUPAC = g.LOCPAICOD
            INNER JOIN [wrk].[WRKFIC] h ON a.RENFICWFC = h.WRKFICCOD
            INNER JOIN [adm].[DOMFIC] i ON a.RENFICEAC = i.DOMFICCOD
            INNER JOIN [adm].[DOMFIC] j ON a.RENFICECC = j.DOMFICCOD
            INNER JOIN [wrk].[WRKDET] k ON a.RENFICWFC = k.WRKDETWFC AND a.RENFICECC = k.WRKDETEAC
            INNER JOIN [adm].[DOMFIC] l ON k.WRKDETTPC = l.DOMFICCOD
            LEFT OUTER JOIN [CSF].[dbo].[empleados_AxisONE] m1 ON a.RENFICDNS COLLATE SQL_Latin1_General_CP1_CI_AS = m1.CedulaEmpleado
            LEFT OUTER JOIN [CSF].[dbo].[empleados_AxisONE] m2 ON a.RENFICDNJ COLLATE SQL_Latin1_General_CP1_CI_AS = m2.CedulaEmpleado
            LEFT OUTER JOIN [CSF].[dbo].[empleados_AxisONE] m3 ON a.RENFICDNA COLLATE SQL_Latin1_General_CP1_CI_AS = m3.CedulaEmpleado

            WHERE k.WRKDETCOD = (SELECT MIN(k1.WRKDETCOD) FROM [wrk].[WRKDET] k1 WHERE k1.WRKDETWFC = a.RENFICWFC AND k1.WRKDETEAC = a.RENFICECC)

            ORDER BY a.RENFICCOD DESC";
            
        try {
            $connMSSQL  = getConnectionMSSQLv2();
            $stmtMSSQL00= $connMSSQL->prepare($sql00);
            $stmtMSSQL00->execute();

            while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                $detalle    = array(
                    'rendicion_codigo'                      => $rowMSSQL00['rendicion_codigo'],
                    'rendicion_periodo'                     => $rowMSSQL00['rendicion_periodo'],
                    'rendicion_evento_nombre'               => trim(strtoupper(strtolower($rowMSSQL00['rendicion_evento_nombre']))),
                    'rendicion_evento_fecha'                => date("d/m/Y", strtotime($rowMSSQL00['rendicion_evento_fecha'])),
                    'rendicion_documento_solicitante'       => trim(strtoupper(strtolower($rowMSSQL00['rendicion_documento_solicitante']))),
                    'rendicion_documento_jefatura'          => trim(strtoupper(strtolower($rowMSSQL00['rendicion_documento_jefatura']))),
                    'rendicion_documento_analista'          => trim(strtoupper(strtolower($rowMSSQL00['rendicion_documento_analista']))),
                    'rendicion_carga_fecha'                 => date("d/m/Y", strtotime($rowMSSQL00['rendicion_carga_fecha'])),
                    'rendicion_tarea_cantidad'              => $rowMSSQL00['rendicion_tarea_cantidad'],
                    'rendicion_tarea_resuelta'              => $rowMSSQL00['rendicion_tarea_resuelta'],
                    'rendicion_tarea_porcentaje'            => number_format((($rowMSSQL00['rendicion_tarea_resuelta'] * 100) / $rowMSSQL00['rendicion_tarea_cantidad']), 2, '.', ''),
                    'rendicion_observacion'                 => trim(strtoupper(strtolower($rowMSSQL00['rendicion_observacion']))),

                    'auditoria_usuario'                     => trim(strtoupper(strtolower($rowMSSQL00['auditoria_usuario']))),
                    'auditoria_fecha_hora'                  => date("d/m/Y", strtotime($rowMSSQL00['auditoria_fecha_hora'])),
                    'auditoria_ip'                          => trim(strtoupper(strtolower($rowMSSQL00['auditoria_ip']))),

                    'tipo_gerencia_codigo'                  => $rowMSSQL00['tipo_gerencia_codigo'],
                    'tipo_gerencia_codigo_nombre'           => $rowMSSQL00['tipo_gerencia_codigo_nombre'],
                    'tipo_gerencia_codigo_referencia'       => $rowMSSQL00['tipo_gerencia_codigo_referencia'],
                    'tipo_gerencia_nombre'                  => trim(strtoupper(strtolower($rowMSSQL00['tipo_gerencia_nombre']))),

                    'tipo_departamento_codigo'              => $rowMSSQL00['tipo_departamento_codigo'],
                    'tipo_departamento_codigo_nombre'       => $rowMSSQL00['tipo_departamento_codigo_nombre'],
                    'tipo_departamento_codigo_referencia'   => $rowMSSQL00['tipo_departamento_codigo_referencia'],
                    'tipo_departamento_nombre'              => trim(strtoupper(strtolower($rowMSSQL00['tipo_departamento_nombre']))),
                    
                    'tipo_jefatura_codigo'                  => $rowMSSQL00['tipo_jefatura_codigo'],
                    'tipo_jefatura_codigo_nombre'           => $rowMSSQL00['tipo_jefatura_codigo_nombre'],
                    'tipo_jefatura_codigo_referencia'       => $rowMSSQL00['tipo_jefatura_codigo_referencia'],
                    'tipo_jefatura_nombre'                  => trim(strtoupper(strtolower($rowMSSQL00['tipo_jefatura_nombre']))),

                    'tipo_cargo_codigo'                     => $rowMSSQL00['tipo_cargo_codigo'],
                    'tipo_cargo_codigo_nombre'              => $rowMSSQL00['tipo_cargo_codigo_nombre'],
                    'tipo_cargo_codigo_referencia'          => $rowMSSQL00['tipo_cargo_codigo_referencia'],
                    'tipo_cargo_nombre'                     => trim(strtoupper(strtolower($rowMSSQL00['tipo_cargo_nombre']))),

                    'ciudad_codigo'                         => $rowMSSQL00['ciudad_codigo'],
                    'ciudad_orden'                          => $rowMSSQL00['ciudad_orden'],
                    'ciudad_nombre'                         => trim(strtoupper(strtolower($rowMSSQL00['ciudad_nombre']))),

                    'pais_codigo'                           => $rowMSSQL00['pais_codigo'],
                    'pais_orden'                            => $rowMSSQL00['pais_orden'],
                    'pais_nombre'                           => trim(strtoupper(strtolower($rowMSSQL00['pais_nombre']))),
                    'pais_path'                             => trim(strtolower($rowMSSQL00['pais_path'])),
                    'pais_iso_char2'                        => trim(strtoupper(strtolower($rowMSSQL00['pais_iso_char2']))),
                    'pais_iso_char3'                        => trim(strtoupper(strtolower($rowMSSQL00['pais_iso_char3']))),
                    'pais_iso_num3'                         => trim(strtoupper(strtolower($rowMSSQL00['pais_iso_num3']))),

                    'workflow_codigo'                       => $rowMSSQL00['workflow_codigo'],
                    'workflow_orden'                        => $rowMSSQL00['workflow_orden'],
                    'workflow_tarea'                        => trim(strtoupper(strtolower($rowMSSQL00['workflow_tarea']))),

                    'estado_anterior_codigo'                => $rowMSSQL00['estado_anterior_codigo'],
                    'estado_anterior_ingles'                => trim(strtoupper(strtolower($rowMSSQL00['estado_anterior_ingles']))),
                    'estado_anterior_castellano'            => trim(strtoupper(strtolower($rowMSSQL00['estado_anterior_castellano']))),
                    'estado_anterior_portugues'             => trim(strtoupper(strtolower($rowMSSQL00['estado_anterior_portugues']))),
                    'estado_anterior_css'                   => trim(strtolower($rowMSSQL00['estado_anterior_css'])),
                    'estado_anterior_parametro'             => $rowMSSQL00['estado_anterior_css'],

                    'estado_actual_codigo'                  => $rowMSSQL00['estado_actual_codigo'],
                    'estado_actual_ingles'                  => trim(strtoupper(strtolower($rowMSSQL00['estado_actual_ingles']))),
                    'estado_actual_castellano'              => trim(strtoupper(strtolower($rowMSSQL00['estado_actual_castellano']))),
                    'estado_actual_portugues'               => trim(strtoupper(strtolower($rowMSSQL00['estado_actual_portugues']))),
                    'estado_actual_css'                     => trim(strtolower($rowMSSQL00['estado_actual_css'])),
                    'estado_actual_parametro'               => $rowMSSQL00['estado_actual_parametro'],

                    'workflow_detalle_codigo'               => $rowMSSQL00['workflow_detalle_codigo'],
                    'workflow_detalle_orden'                => $rowMSSQL00['workflow_detalle_orden'],
                    'workflow_detalle_cargo'                => $rowMSSQL00['workflow_detalle_cargo'],
                    'workflow_detalle_hora'                 => trim(strtoupper(strtolower($rowMSSQL00['workflow_detalle_hora']))),
                    'workflow_detalle_tarea'                => trim(strtoupper(strtolower($rowMSSQL00['workflow_detalle_tarea']))),

                    'tipo_prioridad_codigo'                 => $rowMSSQL00['tipo_prioridad_codigo'],
                    'tipo_prioridad_ingles'                 => trim(strtoupper(strtolower($rowMSSQL00['tipo_prioridad_ingles']))),
                    'tipo_prioridad_castellano'             => trim(strtoupper(strtolower($rowMSSQL00['tipo_prioridad_castellano']))),
                    'tipo_prioridad_portugues'              => trim(strtoupper(strtolower($rowMSSQL00['tipo_prioridad_portugues']))),
                    'tipo_prioridad_css'                    => trim(strtolower($rowMSSQL00['tipo_prioridad_css'])),
                    'tipo_prioridad_parametro'              => $rowMSSQL00['tipo_prioridad_parametro'],

                    'rendicion_nombre_solicitante'          => trim(strtoupper(strtolower($rowMSSQL00['rendicion_nombre_solicitante']))),
                    'rendicion_nombre_jefatura'             => trim(strtoupper(strtolower($rowMSSQL00['rendicion_nombre_jefatura']))),
                    'rendicion_nombre_analista'             => trim(strtoupper(strtolower($rowMSSQL00['rendicion_nombre_analista'])))
                );

                $result[]   = $detalle;
            }

            if (isset($result)){
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } else {
                $detalle    = array(
                    'rendicion_codigo'                      => '',
                    'rendicion_periodo'                     => '',
                    'rendicion_evento_nombre'               => '',
                    'rendicion_evento_fecha'                => '',
                    'rendicion_documento_solicitante'       => '',
                    'rendicion_documento_jefatura'          => '',
                    'rendicion_documento_analista'          => '',
                    'rendicion_carga_fecha'                 => '',
                    'rendicion_tarea_cantidad'              => '',
                    'rendicion_tarea_resuelta'              => '',
                    'rendicion_tarea_porcentaje'            => '',
                    'rendicion_observacion'                 => '',

                    'auditoria_usuario'                     => '',
                    'auditoria_fecha_hora'                  => '',
                    'auditoria_ip'                          => '',

                    'tipo_gerencia_codigo'                  => '',
                    'tipo_gerencia_codigo_nombre'           => '',
                    'tipo_gerencia_codigo_referencia'       => '',
                    'tipo_gerencia_nombre'                  => '',

                    'tipo_departamento_codigo'              => '',
                    'tipo_departamento_codigo_nombre'       => '',
                    'tipo_departamento_codigo_referencia'   => '',
                    'tipo_departamento_nombre'              => '',
                    
                    'tipo_jefatura_codigo'                  => '',
                    'tipo_jefatura_codigo_nombre'           => '',
                    'tipo_jefatura_codigo_referencia'       => '',
                    'tipo_jefatura_nombre'                  => '',

                    'tipo_cargo_codigo'                     => '',
                    'tipo_cargo_codigo_nombre'              => '',
                    'tipo_cargo_codigo_referencia'          => '',
                    'tipo_cargo_nombre'                     => '',

                    'ciudad_codigo'                         => '',
                    'ciudad_orden'                          => '',
                    'ciudad_nombre'                         => '',

                    'pais_codigo'                           => '',
                    'pais_orden'                            => '',
                    'pais_nombre'                           => '',
                    'pais_path'                             => '',
                    'pais_iso_char2'                        => '',
                    'pais_iso_char3'                        => '',
                    'pais_iso_num3'                         => '',

                    'workflow_codigo'                       => '',
                    'workflow_orden'                        => '',
                    'workflow_tarea'                        => '',

                    'estado_anterior_codigo'                => '',
                    'estado_anterior_ingles'                => '',
                    'estado_anterior_castellano'            => '',
                    'estado_anterior_portugues'             => '',
                    'estado_anterior_css'                   => '',
                    'estado_anterior_parametro'             => '',

                    'estado_actual_codigo'                  => '',
                    'estado_actual_ingles'                  => '',
                    'estado_actual_castellano'              => '',
                    'estado_actual_portugues'               => '',
                    'estado_actual_css'                     => '',
                    'estado_actual_parametro'               => '',

                    'workflow_detalle_codigo'               => '',
                    'workflow_detalle_orden'                => '',
                    'workflow_detalle_cargo'                => '',
                    'workflow_detalle_hora'                 => '',
                    'workflow_detalle_tarea'                => '',

                    'tipo_prioridad_codigo'                 => '',
                    'tipo_prioridad_ingles'                 => '',
                    'tipo_prioridad_castellano'             => '',
                    'tipo_prioridad_portugues'              => '',
                    'tipo_prioridad_css'                    => '',
                    'tipo_prioridad_parametro'              => '',

                    'rendicion_nombre_solicitante'          => '',
                    'rendicion_nombre_jefatura'             => '',
                    'rendicion_nombre_analista'             => ''
                );

                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }

            $stmtMSSQL00->closeCursor();
            $stmtMSSQL00 = null;
        } catch (PDOException $e) {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v2/500/rendicion/codigo/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01  = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
                a.RENFICCOD         AS          rendicion_codigo,
                a.RENFICPER         AS          rendicion_periodo,
                a.RENFICENO         AS          rendicion_evento_nombre,
                a.RENFICEFE         AS          rendicion_evento_fecha,
                a.RENFICDNS         AS          rendicion_documento_solicitante,
                a.RENFICDNJ         AS          rendicion_documento_jefatura,
                a.RENFICDNA         AS          rendicion_documento_analista,
                a.RENFICFEC         AS          rendicion_carga_fecha,
                a.RENFICTCA         AS          rendicion_tarea_cantidad,
                a.RENFICTRE         AS          rendicion_tarea_resuelta,
                a.RENFICOBS         AS          rendicion_observacion,

                a.RENFICAUS         AS          auditoria_usuario,
                a.RENFICAFH         AS          auditoria_fecha_hora,
                a.RENFICAIP         AS          auditoria_ip,

                b.CODE              AS          tipo_gerencia_codigo,
                b.NAME              AS          tipo_gerencia_codigo_nombre,
                b.U_CODIGO          AS          tipo_gerencia_codigo_referencia,
                b.U_NOMBRE          AS          tipo_gerencia_nombre,

                c.CODE              AS          tipo_departamento_codigo,
                c.NAME              AS          tipo_departamento_codigo_nombre,
                c.U_CODIGO          AS          tipo_departamento_codigo_referencia,
                c.U_NOMBRE          AS          tipo_departamento_nombre,

                d.CODE              AS          tipo_jefatura_codigo_referencia,
                d.NAME              AS          tipo_jefatura_codigo_nombre,
                d.U_CODIGO          AS          tipo_jefatura_codigo,
                d.U_NOMBRE          AS          tipo_jefatura_nombre,

                e.CODE              AS          tipo_cargo_codigo_referencia,
                e.NAME              AS          tipo_cargo_codigo_nombre,
                e.U_CODIGO          AS          tipo_cargo_codigo,
                e.U_NOMBRE          AS          tipo_cargo_nombre,

                f.LOCCIUCOD         AS          ciudad_codigo,
                f.LOCCIUORD         AS          ciudad_orden,
                f.LOCCIUNOM         AS          ciudad_nombre,

                g.LOCPAICOD         AS          pais_codigo,
                g.LOCPAIORD         AS          pais_orden,
                g.LOCPAINOM         AS          pais_nombre,
                g.LOCPAIPAT         AS          pais_path,
                g.LOCPAIIC2         AS          pais_iso_char2,
                g.LOCPAIIC3         AS          pais_iso_char3,
                g.LOCPAIIN3         AS          pais_iso_num3,

                h.WRKFICCOD         AS          workflow_codigo,
                h.WRKFICORD         AS          workflow_orden,
                h.WRKFICNOM         AS          workflow_tarea,

                i.DOMFICCOD         AS          estado_anterior_codigo,
                i.DOMFICNOI         AS          estado_anterior_ingles,
                i.DOMFICNOC         AS          estado_anterior_castellano,
                i.DOMFICNOP         AS          estado_anterior_portugues,
                i.DOMFICCSS         AS          estado_anterior_css,
                i.DOMFICPAR         AS          estado_anterior_parametro,

                j.DOMFICCOD         AS          estado_actual_codigo,
                j.DOMFICNOI         AS          estado_actual_ingles,
                j.DOMFICNOC         AS          estado_actual_castellano,
                j.DOMFICNOP         AS          estado_actual_portugues,
                j.DOMFICCSS         AS          estado_actual_css,
                j.DOMFICPAR         AS          estado_actual_parametro,

                k.WRKDETCOD         AS          workflow_detalle_codigo,
                k.WRKDETORD         AS          workflow_detalle_orden,
                k.WRKDETTCC         AS          workflow_detalle_cargo,
                k.WRKDETHOR         AS          workflow_detalle_hora,
                k.WRKDETNOM         AS          workflow_detalle_tarea,

                l.DOMFICCOD         AS          tipo_prioridad_codigo,
                l.DOMFICNOI         AS          tipo_prioridad_ingles,
                l.DOMFICNOC         AS          tipo_prioridad_castellano,
                l.DOMFICNOP         AS          tipo_prioridad_portugues,
                l.DOMFICCSS         AS          tipo_prioridad_css,
                l.DOMFICPAR         AS          tipo_prioridad_parametro,

                m1.NombreEmpleado   AS          rendicion_nombre_solicitante,
                m2.NombreEmpleado   AS          rendicion_nombre_jefatura,
                m3.NombreEmpleado   AS          rendicion_nombre_analista

                FROM [con].[RENFIC] a
                INNER JOIN [CSF].[dbo].[@A1A_TIGE] b ON a.RENFICGEC = b.U_CODIGO
                INNER JOIN [CSF].[dbo].[@A1A_TIDE] c ON a.RENFICDEC = c.U_CODIGO
                INNER JOIN [CSF].[dbo].[@A1A_TICA] d ON a.RENFICJEC = d.U_CODIGO
                INNER JOIN [CSF].[dbo].[@A1A_TICA] e ON a.RENFICCAC = e.U_CODIGO
                INNER JOIN [adm].[LOCCIU] f ON a.RENFICCIC = f.LOCCIUCOD
                INNER JOIN [adm].[LOCPAI] g ON f.LOCCIUPAC = g.LOCPAICOD
                INNER JOIN [wrk].[WRKFIC] h ON a.RENFICWFC = h.WRKFICCOD
                INNER JOIN [adm].[DOMFIC] i ON a.RENFICEAC = i.DOMFICCOD
                INNER JOIN [adm].[DOMFIC] j ON a.RENFICECC = j.DOMFICCOD
                LEFT OUTER JOIN [wrk].[WRKDET] k ON h.WRKFICCOD = k.WRKDETWFC AND a.RENFICEAC = k.WRKDETEAC AND a.RENFICECC = k.WRKDETECC
                LEFT OUTER JOIN [adm].[DOMFIC] l ON k.WRKDETTPC = l.DOMFICCOD
                LEFT OUTER JOIN [CSF].[dbo].[empleados_AxisONE] m1 ON a.RENFICDNS COLLATE SQL_Latin1_General_CP1_CI_AS = m1.CedulaEmpleado
                LEFT OUTER JOIN [CSF].[dbo].[empleados_AxisONE] m2 ON a.RENFICDNJ COLLATE SQL_Latin1_General_CP1_CI_AS = m2.CedulaEmpleado
                LEFT OUTER JOIN [CSF].[dbo].[empleados_AxisONE] m3 ON a.RENFICDNA COLLATE SQL_Latin1_General_CP1_CI_AS = m3.CedulaEmpleado

                WHERE a.RENFICCOD = ?

                ORDER BY a.RENFICCOD DESC";

            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val01]);

                while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                    $detalle    = array(
                        'rendicion_codigo'                      => $rowMSSQL00['rendicion_codigo'],
                        'rendicion_periodo'                     => $rowMSSQL00['rendicion_periodo'],
                        'rendicion_evento_nombre'               => trim(strtoupper(strtolower($rowMSSQL00['rendicion_evento_nombre']))),
                        'rendicion_evento_fecha'                => date("d/m/Y", strtotime($rowMSSQL00['rendicion_evento_fecha'])),
                        'rendicion_documento_solicitante'       => trim(strtoupper(strtolower($rowMSSQL00['rendicion_documento_solicitante']))),
                        'rendicion_documento_jefatura'          => trim(strtoupper(strtolower($rowMSSQL00['rendicion_documento_jefatura']))),
                        'rendicion_documento_analista'          => trim(strtoupper(strtolower($rowMSSQL00['rendicion_documento_analista']))),
                        'rendicion_carga_fecha'                 => date("d/m/Y", strtotime($rowMSSQL00['rendicion_carga_fecha'])),
                        'rendicion_tarea_cantidad'              => $rowMSSQL00['rendicion_tarea_cantidad'],
                        'rendicion_tarea_resuelta'              => $rowMSSQL00['rendicion_tarea_resuelta'],
                        'rendicion_tarea_porcentaje'            => number_format((($rowMSSQL00['rendicion_tarea_resuelta'] * 100) / $rowMSSQL00['rendicion_tarea_cantidad']), 2, '.', ''),
                        'rendicion_observacion'                 => trim(strtoupper(strtolower($rowMSSQL00['rendicion_observacion']))),

                        'auditoria_usuario'                     => trim(strtoupper(strtolower($rowMSSQL00['auditoria_usuario']))),
                        'auditoria_fecha_hora'                  => date("d/m/Y", strtotime($rowMSSQL00['auditoria_fecha_hora'])),
                        'auditoria_ip'                          => trim(strtoupper(strtolower($rowMSSQL00['auditoria_ip']))),

                        'tipo_gerencia_codigo'                  => $rowMSSQL00['tipo_gerencia_codigo'],
                        'tipo_gerencia_codigo_nombre'           => $rowMSSQL00['tipo_gerencia_codigo_nombre'],
                        'tipo_gerencia_codigo_referencia'       => $rowMSSQL00['tipo_gerencia_codigo_referencia'],
                        'tipo_gerencia_nombre'                  => trim(strtoupper(strtolower($rowMSSQL00['tipo_gerencia_nombre']))),

                        'tipo_departamento_codigo'              => $rowMSSQL00['tipo_departamento_codigo'],
                        'tipo_departamento_codigo_nombre'       => $rowMSSQL00['tipo_departamento_codigo_nombre'],
                        'tipo_departamento_codigo_referencia'   => $rowMSSQL00['tipo_departamento_codigo_referencia'],
                        'tipo_departamento_nombre'              => trim(strtoupper(strtolower($rowMSSQL00['tipo_departamento_nombre']))),
                        
                        'tipo_jefatura_codigo'                  => $rowMSSQL00['tipo_jefatura_codigo'],
                        'tipo_jefatura_codigo_nombre'           => $rowMSSQL00['tipo_jefatura_codigo_nombre'],
                        'tipo_jefatura_codigo_referencia'       => $rowMSSQL00['tipo_jefatura_codigo_referencia'],
                        'tipo_jefatura_nombre'                  => trim(strtoupper(strtolower($rowMSSQL00['tipo_jefatura_nombre']))),

                        'tipo_cargo_codigo'                     => $rowMSSQL00['tipo_cargo_codigo'],
                        'tipo_cargo_codigo_nombre'              => $rowMSSQL00['tipo_cargo_codigo_nombre'],
                        'tipo_cargo_codigo_referencia'          => $rowMSSQL00['tipo_cargo_codigo_referencia'],
                        'tipo_cargo_nombre'                     => trim(strtoupper(strtolower($rowMSSQL00['tipo_cargo_nombre']))),

                        'ciudad_codigo'                         => $rowMSSQL00['ciudad_codigo'],
                        'ciudad_orden'                          => $rowMSSQL00['ciudad_orden'],
                        'ciudad_nombre'                         => trim(strtoupper(strtolower($rowMSSQL00['ciudad_nombre']))),

                        'pais_codigo'                           => $rowMSSQL00['pais_codigo'],
                        'pais_orden'                            => $rowMSSQL00['pais_orden'],
                        'pais_nombre'                           => trim(strtoupper(strtolower($rowMSSQL00['pais_nombre']))),
                        'pais_path'                             => trim(strtolower($rowMSSQL00['pais_path'])),
                        'pais_iso_char2'                        => trim(strtoupper(strtolower($rowMSSQL00['pais_iso_char2']))),
                        'pais_iso_char3'                        => trim(strtoupper(strtolower($rowMSSQL00['pais_iso_char3']))),
                        'pais_iso_num3'                         => trim(strtoupper(strtolower($rowMSSQL00['pais_iso_num3']))),

                        'workflow_codigo'                       => $rowMSSQL00['workflow_codigo'],
                        'workflow_orden'                        => $rowMSSQL00['workflow_orden'],
                        'workflow_tarea'                        => trim(strtoupper(strtolower($rowMSSQL00['workflow_tarea']))),

                        'estado_anterior_codigo'                => $rowMSSQL00['estado_anterior_codigo'],
                        'estado_anterior_ingles'                => trim(strtoupper(strtolower($rowMSSQL00['estado_anterior_ingles']))),
                        'estado_anterior_castellano'            => trim(strtoupper(strtolower($rowMSSQL00['estado_anterior_castellano']))),
                        'estado_anterior_portugues'             => trim(strtoupper(strtolower($rowMSSQL00['estado_anterior_portugues']))),
                        'estado_anterior_css'                   => trim(strtolower($rowMSSQL00['estado_anterior_css'])),
                        'estado_anterior_parametro'             => $rowMSSQL00['estado_anterior_parametro'],

                        'estado_actual_codigo'                  => $rowMSSQL00['estado_actual_codigo'],
                        'estado_actual_ingles'                  => trim(strtoupper(strtolower($rowMSSQL00['estado_actual_ingles']))),
                        'estado_actual_castellano'              => trim(strtoupper(strtolower($rowMSSQL00['estado_actual_castellano']))),
                        'estado_actual_portugues'               => trim(strtoupper(strtolower($rowMSSQL00['estado_actual_portugues']))),
                        'estado_actual_css'                     => trim(strtolower($rowMSSQL00['estado_actual_css'])),
                        'estado_actual_parametro'               => $rowMSSQL00['estado_actual_parametro'],

                        'workflow_detalle_codigo'               => $rowMSSQL00['workflow_detalle_codigo'],
                        'workflow_detalle_orden'                => $rowMSSQL00['workflow_detalle_orden'],
                        'workflow_detalle_cargo'                => $rowMSSQL00['workflow_detalle_cargo'],
                        'workflow_detalle_hora'                 => trim(strtoupper(strtolower($rowMSSQL00['workflow_detalle_hora']))),
                        'workflow_detalle_tarea'                => trim(strtoupper(strtolower($rowMSSQL00['workflow_detalle_tarea']))),

                        'tipo_prioridad_codigo'                 => $rowMSSQL00['tipo_prioridad_codigo'],
                        'tipo_prioridad_ingles'                 => trim(strtoupper(strtolower($rowMSSQL00['tipo_prioridad_ingles']))),
                        'tipo_prioridad_castellano'             => trim(strtoupper(strtolower($rowMSSQL00['tipo_prioridad_castellano']))),
                        'tipo_prioridad_portugues'              => trim(strtoupper(strtolower($rowMSSQL00['tipo_prioridad_portugues']))),
                        'tipo_prioridad_css'                    => trim(strtolower($rowMSSQL00['tipo_prioridad_css'])),
                        'tipo_prioridad_parametro'              => $rowMSSQL00['tipo_prioridad_parametro'],

                        'rendicion_nombre_solicitante'          => trim(strtoupper(strtolower($rowMSSQL00['rendicion_nombre_solicitante']))),
                        'rendicion_nombre_jefatura'             => trim(strtoupper(strtolower($rowMSSQL00['rendicion_nombre_jefatura']))),
                        'rendicion_nombre_analista'             => trim(strtoupper(strtolower($rowMSSQL00['rendicion_nombre_analista'])))
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle    = array(
                        'rendicion_codigo'                      => '',
                        'rendicion_periodo'                     => '',
                        'rendicion_evento_nombre'               => '',
                        'rendicion_evento_fecha'                => '',
                        'rendicion_documento_solicitante'       => '',
                        'rendicion_documento_jefatura'          => '',
                        'rendicion_documento_analista'          => '',
                        'rendicion_carga_fecha'                 => '',
                        'rendicion_tarea_cantidad'              => '',
                        'rendicion_tarea_resuelta'              => '',
                        'rendicion_tarea_porcentaje'            => '',
                        'rendicion_observacion'                 => '',

                        'auditoria_usuario'                     => '',
                        'auditoria_fecha_hora'                  => '',
                        'auditoria_ip'                          => '',

                        'tipo_gerencia_codigo'                  => '',
                        'tipo_gerencia_codigo_nombre'           => '',
                        'tipo_gerencia_codigo_referencia'       => '',
                        'tipo_gerencia_nombre'                  => '',

                        'tipo_departamento_codigo'              => '',
                        'tipo_departamento_codigo_nombre'       => '',
                        'tipo_departamento_codigo_referencia'   => '',
                        'tipo_departamento_nombre'              => '',
                        
                        'tipo_jefatura_codigo'                  => '',
                        'tipo_jefatura_codigo_nombre'           => '',
                        'tipo_jefatura_codigo_referencia'       => '',
                        'tipo_jefatura_nombre'                  => '',

                        'tipo_cargo_codigo'                     => '',
                        'tipo_cargo_codigo_nombre'              => '',
                        'tipo_cargo_codigo_referencia'          => '',
                        'tipo_cargo_nombre'                     => '',

                        'ciudad_codigo'                         => '',
                        'ciudad_orden'                          => '',
                        'ciudad_nombre'                         => '',

                        'pais_codigo'                           => '',
                        'pais_orden'                            => '',
                        'pais_nombre'                           => '',
                        'pais_path'                             => '',
                        'pais_iso_char2'                        => '',
                        'pais_iso_char3'                        => '',
                        'pais_iso_num3'                         => '',

                        'workflow_codigo'                       => '',
                        'workflow_orden'                        => '',
                        'workflow_tarea'                        => '',

                        'estado_anterior_codigo'                => '',
                        'estado_anterior_ingles'                => '',
                        'estado_anterior_castellano'            => '',
                        'estado_anterior_portugues'             => '',
                        'estado_anterior_css'                   => '',
                        'estado_anterior_parametro'             => '',

                        'estado_actual_codigo'                  => '',
                        'estado_actual_ingles'                  => '',
                        'estado_actual_castellano'              => '',
                        'estado_actual_portugues'               => '',
                        'estado_actual_css'                     => '',
                        'estado_actual_parametro'               => '',

                        'workflow_detalle_codigo'               => '',
                        'workflow_detalle_orden'                => '',
                        'workflow_detalle_cargo'                => '',
                        'workflow_detalle_hora'                 => '',
                        'workflow_detalle_tarea'                => '',

                        'tipo_prioridad_codigo'                 => '',
                        'tipo_prioridad_ingles'                 => '',
                        'tipo_prioridad_castellano'             => '',
                        'tipo_prioridad_portugues'              => '',
                        'tipo_prioridad_css'                    => '',
                        'tipo_prioridad_parametro'              => '',

                        'rendicion_nombre_solicitante'          => '',
                        'rendicion_nombre_jefatura'             => '',
                        'rendicion_nombre_analista'             => ''
                    );

                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                }

                $stmtMSSQL00->closeCursor();
                $stmtMSSQL00 = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        }  else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v2/500/rendicion/cabecera/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01  = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
                a.RENFCACOD         AS          rendicion_cabecera_codigo,
                a.RENFCATNR         AS          rendicion_cabecera_timbrado_numero,
                a.RENFCATVE         AS          rendicion_cabecera_timbrado_vencimiento,
                a.RENFCAFFE         AS          rendicion_cabecera_factura_fecha,
                a.RENFCAFNU         AS          rendicion_cabecera_factura_numero,
                a.RENFCAFRS         AS          rendicion_cabecera_factura_razonsocial,
                a.RENFCAFAD         AS          rendicion_cabecera_factura_adjunto,
                a.RENFCAFTO         AS          rendicion_cabecera_factura_importe,
                a.RENFCAOBS         AS          rendicion_cabecera_observacion,

                a.RENFCAAUS         AS          auditoria_usuario,
                a.RENFCAAFH         AS          auditoria_fecha_hora,
                a.RENFCAAIP         AS          auditoria_ip,

                b.DOMFICCOD         AS          tipo_moneda_codigo,
                b.DOMFICNOI         AS          tipo_moneda_ingles,
                b.DOMFICNOC         AS          tipo_moneda_castellano,
                b.DOMFICNOP         AS          tipo_moneda_portugues,

                c.DOMFICCOD         AS          tipo_factura_codigo,
                c.DOMFICNOI         AS          tipo_factura_ingles,
                c.DOMFICNOC         AS          tipo_factura_castellano,
                c.DOMFICNOP         AS          tipo_factura_portugues,
                c.DOMFICCSS         AS          tipo_factura_css,
                c.DOMFICPAR         AS          tipo_factura_parametro,

                d.DOMFICCOD         AS          tipo_condicion_codigo,
                d.DOMFICNOI         AS          tipo_condicion_ingles,
                d.DOMFICNOC         AS          tipo_condicion_castellano,
                d.DOMFICNOP         AS          tipo_condicion_portugues,
                d.DOMFICCSS         AS          tipo_condicion_css,
                d.DOMFICPAR         AS          tipo_condicion_parametro,

                e.WRKFICCOD         AS          workflow_codigo,
                e.WRKFICORD         AS          workflow_orden,
                e.WRKFICNOM         AS          workflow_tarea,

                f.DOMFICCOD         AS          estado_anterior_codigo,
                f.DOMFICNOI         AS          estado_anterior_ingles,
                f.DOMFICNOC         AS          estado_anterior_castellano,
                f.DOMFICNOP         AS          estado_anterior_portugues,
                f.DOMFICCSS         AS          estado_anterior_css,
                f.DOMFICPAR         AS          estado_anterior_parametro,

                g.DOMFICCOD         AS          estado_actual_codigo,
                g.DOMFICNOI         AS          estado_actual_ingles,
                g.DOMFICNOC         AS          estado_actual_castellano,
                g.DOMFICNOP         AS          estado_actual_portugues,
                g.DOMFICCSS         AS          estado_actual_css,
                g.DOMFICPAR         AS          estado_actual_parametro,

                h.RENFICCOD         AS          rendicion_codigo,
                h.RENFICPER         AS          rendicion_periodo,
                h.RENFICENO         AS          rendicion_evento_nombre,
                h.RENFICEFE         AS          rendicion_evento_fecha,
                h.RENFICDNS         AS          rendicion_documento_solicitante,
                h.RENFICDNJ         AS          rendicion_documento_jefatura,
                h.RENFICDNA         AS          rendicion_documento_analista,
                h.RENFICFEC         AS          rendicion_carga_fecha,
                h.RENFICTCA         AS          rendicion_tarea_cantidad,
                h.RENFICTRE         AS          rendicion_tarea_resuelta,
                h.RENFICOBS         AS          rendicion_observacion,

                i.WRKDETCOD         AS          workflow_detalle_codigo,
                i.WRKDETORD         AS          workflow_detalle_orden,
                i.WRKDETTCC         AS          workflow_detalle_cargo,
                i.WRKDETHOR         AS          workflow_detalle_hora,
                i.WRKDETNOM         AS          workflow_detalle_tarea

                FROM [con].[RENFCA] a
                INNER JOIN [adm].[DOMFIC] b ON a.RENFCATMC = b.DOMFICCOD
                INNER JOIN [adm].[DOMFIC] c ON a.RENFCATFC = c.DOMFICCOD
                INNER JOIN [adm].[DOMFIC] d ON a.RENFCATCC = d.DOMFICCOD
                INNER JOIN [wrk].[WRKFIC] e ON a.RENFCAWFC = e.WRKFICCOD
                INNER JOIN [adm].[DOMFIC] f ON a.RENFCAEAC = f.DOMFICCOD
                INNER JOIN [adm].[DOMFIC] g ON a.RENFCAECC = g.DOMFICCOD
                INNER JOIN [con].[RENFIC] h ON a.RENFCAREC = h.RENFICCOD
                LEFT OUTER JOIN [wrk].[WRKDET] i ON e.WRKFICCOD = i.WRKDETWFC AND a.RENFCAEAC = i.WRKDETEAC AND a.RENFCAECC = i.WRKDETECC

                WHERE a.RENFCAREC = ?

                ORDER BY a.RENFCACOD DESC";

            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val01]);

                while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                    $detalle    = array(
                        'rendicion_cabecera_codigo'                 => $rowMSSQL00['rendicion_cabecera_codigo'],
                        'rendicion_cabecera_timbrado_numero'        => trim(strtoupper(strtolower($rowMSSQL00['rendicion_cabecera_timbrado_numero']))),
                        'rendicion_cabecera_timbrado_vencimiento'   => date("d/m/Y", strtotime($rowMSSQL00['rendicion_cabecera_timbrado_vencimiento'])),
                        'rendicion_cabecera_factura_fecha'          => date("d/m/Y", strtotime($rowMSSQL00['rendicion_cabecera_factura_fecha'])),
                        'rendicion_cabecera_factura_numero'         => trim(strtoupper(strtolower($rowMSSQL00['rendicion_cabecera_factura_numero']))),
                        'rendicion_cabecera_factura_razonsocial'    => trim(strtoupper(strtolower($rowMSSQL00['rendicion_cabecera_factura_razonsocial']))),
                        'rendicion_cabecera_factura_adjunto'        => trim(strtolower($rowMSSQL00['rendicion_cabecera_factura_adjunto'])),
                        'rendicion_cabecera_factura_importe'        => $rowMSSQL00['rendicion_cabecera_factura_importe'],
                        'rendicion_cabecera_observacion'            => trim(strtoupper(strtolower($rowMSSQL00['rendicion_cabecera_observacion']))),

                        'auditoria_usuario'                         => trim(strtoupper(strtolower($rowMSSQL00['auditoria_usuario']))),
                        'auditoria_fecha_hora'                      => date("d/m/Y", strtotime($rowMSSQL00['auditoria_fecha_hora'])),
                        'auditoria_ip'                              => trim(strtoupper(strtolower($rowMSSQL00['auditoria_ip']))),

                        'tipo_moneda_codigo'                        => $rowMSSQL00['tipo_moneda_codigo'],
                        'tipo_moneda_ingles'                        => trim(strtoupper(strtolower($rowMSSQL00['tipo_moneda_ingles']))),
                        'tipo_moneda_castellano'                    => trim(strtoupper(strtolower($rowMSSQL00['tipo_moneda_castellano']))),
                        'tipo_moneda_portugues'                     => trim(strtoupper(strtolower($rowMSSQL00['tipo_moneda_portugues']))),
                        'tipo_moneda_css'                           => trim(strtolower($rowMSSQL00['tipo_moneda_css'])),
                        'tipo_moneda_parametro'                     => $rowMSSQL00['tipo_moneda_parametro'],

                        'tipo_factura_codigo'                       => $rowMSSQL00['tipo_factura_codigo'],
                        'tipo_factura_ingles'                       => trim(strtoupper(strtolower($rowMSSQL00['tipo_factura_ingles']))),
                        'tipo_factura_castellano'                   => trim(strtoupper(strtolower($rowMSSQL00['tipo_factura_castellano']))),
                        'tipo_factura_portugues'                    => trim(strtoupper(strtolower($rowMSSQL00['tipo_factura_portugues']))),
                        'tipo_factura_css'                          => trim(strtolower($rowMSSQL00['tipo_factura_css'])),
                        'tipo_factura_parametro'                    => $rowMSSQL00['tipo_factura_parametro'],

                        'tipo_condicion_codigo'                     => $rowMSSQL00['tipo_condicion_codigo'],
                        'tipo_condicion_ingles'                     => trim(strtoupper(strtolower($rowMSSQL00['tipo_condicion_ingles']))),
                        'tipo_condicion_castellano'                 => trim(strtoupper(strtolower($rowMSSQL00['tipo_condicion_castellano']))),
                        'tipo_condicion_portugues'                  => trim(strtoupper(strtolower($rowMSSQL00['tipo_condicion_portugues']))),
                        'tipo_condicion_css'                        => trim(strtolower($rowMSSQL00['tipo_condicion_css'])),
                        'tipo_condicion_parametro'                  => $rowMSSQL00['tipo_condicion_parametro'],

                        'workflow_codigo'                           => $rowMSSQL00['workflow_codigo'],
                        'workflow_orden'                            => $rowMSSQL00['workflow_orden'],
                        'workflow_tarea'                            => trim(strtoupper(strtolower($rowMSSQL00['workflow_tarea']))),

                        'workflow_detalle_codigo'                   => $rowMSSQL00['workflow_detalle_codigo'],
                        'workflow_detalle_orden'                    => $rowMSSQL00['workflow_detalle_orden'],
                        'workflow_detalle_cargo'                    => $rowMSSQL00['workflow_detalle_cargo'],
                        'workflow_detalle_hora'                     => trim(strtoupper(strtolower($rowMSSQL00['workflow_detalle_hora']))),
                        'workflow_detalle_tarea'                    => trim(strtoupper(strtolower($rowMSSQL00['workflow_detalle_tarea']))),

                        'estado_anterior_codigo'                    => $rowMSSQL00['estado_anterior_codigo'],
                        'estado_anterior_ingles'                    => trim(strtoupper(strtolower($rowMSSQL00['estado_anterior_ingles']))),
                        'estado_anterior_castellano'                => trim(strtoupper(strtolower($rowMSSQL00['estado_anterior_castellano']))),
                        'estado_anterior_portugues'                 => trim(strtoupper(strtolower($rowMSSQL00['estado_anterior_portugues']))),
                        'estado_anterior_css'                       => trim(strtolower($rowMSSQL00['estado_anterior_css'])),
                        'estado_anterior_parametro'                 => $rowMSSQL00['estado_anterior_parametro'],

                        'estado_actual_codigo'                      => $rowMSSQL00['estado_actual_codigo'],
                        'estado_actual_ingles'                      => trim(strtoupper(strtolower($rowMSSQL00['estado_actual_ingles']))),
                        'estado_actual_castellano'                  => trim(strtoupper(strtolower($rowMSSQL00['estado_actual_castellano']))),
                        'estado_actual_portugues'                   => trim(strtoupper(strtolower($rowMSSQL00['estado_actual_portugues']))),
                        'estado_actual_css'                         => trim(strtolower($rowMSSQL00['estado_actual_css'])),
                        'estado_actual_parametro'                   => $rowMSSQL00['estado_actual_parametro'],

                        'rendicion_codigo'                          => $rowMSSQL00['rendicion_codigo'],
                        'rendicion_periodo'                         => $rowMSSQL00['rendicion_periodo'],
                        'rendicion_evento_nombre'                   => trim(strtoupper(strtolower($rowMSSQL00['rendicion_evento_nombre']))),
                        'rendicion_evento_fecha'                    => date("d/m/Y", strtotime($rowMSSQL00['rendicion_evento_fecha'])),
                        'rendicion_documento_solicitante'           => trim(strtoupper(strtolower($rowMSSQL00['rendicion_documento_solicitante']))),
                        'rendicion_documento_jefatura'              => trim(strtoupper(strtolower($rowMSSQL00['rendicion_documento_jefatura']))),
                        'rendicion_documento_analista'              => trim(strtoupper(strtolower($rowMSSQL00['rendicion_documento_analista']))),
                        'rendicion_carga_fecha'                     => date("d/m/Y", strtotime($rowMSSQL00['rendicion_carga_fecha'])),
                        'rendicion_tarea_cantidad'                  => $rowMSSQL00['rendicion_tarea_cantidad'],
                        'rendicion_tarea_resuelta'                  => $rowMSSQL00['rendicion_tarea_resuelta'],
                        'rendicion_tarea_porcentaje'                => number_format((($rowMSSQL00['rendicion_tarea_resuelta'] * 100) / $rowMSSQL00['rendicion_tarea_cantidad']), 2, '.', ''),
                        'rendicion_observacion'                     => trim(strtoupper(strtolower($rowMSSQL00['rendicion_observacion'])))
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle    = array(
                        'rendicion_cabecera_codigo'                 => '',
                        'rendicion_cabecera_timbrado_numero'        => '',
                        'rendicion_cabecera_timbrado_vencimiento'   => '',
                        'rendicion_cabecera_factura_fecha'          => '',
                        'rendicion_cabecera_factura_numero'         => '',
                        'rendicion_cabecera_factura_razonsocial'    => '',
                        'rendicion_cabecera_factura_adjunto'        => '',
                        'rendicion_cabecera_factura_importe'        => '',
                        'rendicion_cabecera_observacion'            => '',

                        'auditoria_usuario'                         => '',
                        'auditoria_fecha_hora'                      => '',
                        'auditoria_ip'                              => '',

                        'tipo_moneda_codigo'                        => '',
                        'tipo_moneda_ingles'                        => '',
                        'tipo_moneda_castellano'                    => '',
                        'tipo_moneda_portugues'                     => '',

                        'tipo_factura_codigo'                       => '',
                        'tipo_factura_ingles'                       => '',
                        'tipo_factura_castellano'                   => '',
                        'tipo_factura_portugues'                    => '',
                        'tipo_factura_css'                          => '',
                        'tipo_factura_parametro'                    => '',

                        'tipo_condicion_codigo'                     => '',
                        'tipo_condicion_ingles'                     => '',
                        'tipo_condicion_castellano'                 => '',
                        'tipo_condicion_portugues'                  => '',
                        'tipo_condicion_css'                        => '',
                        'tipo_condicion_parametro'                  => '',

                        'workflow_codigo'                           => '',
                        'workflow_orden'                            => '',
                        'workflow_tarea'                            => '',

                        'workflow_detalle_codigo'                   => '',
                        'workflow_detalle_orden'                    => '',
                        'workflow_detalle_cargo'                    => '',
                        'workflow_detalle_hora'                     => '',
                        'workflow_detalle_tarea'                    => '',

                        'estado_anterior_codigo'                    => '',
                        'estado_anterior_ingles'                    => '',
                        'estado_anterior_castellano'                => '',
                        'estado_anterior_portugues'                 => '',
                        'estado_anterior_css'                       => '',
                        'estado_anterior_parametro'                 => '',

                        'estado_actual_codigo'                      => '',
                        'estado_actual_ingles'                      => '',
                        'estado_actual_castellano'                  => '',
                        'estado_actual_portugues'                   => '',
                        'estado_actual_css'                         => '',
                        'estado_actual_parametro'                   => '',

                        'rendicion_codigo'                          => '',
                        'rendicion_periodo'                         => '',
                        'rendicion_evento_nombre'                   => '',
                        'rendicion_evento_fecha'                    => '',
                        'rendicion_documento_solicitante'           => '',
                        'rendicion_documento_jefatura'              => '',
                        'rendicion_documento_analista'              => '',
                        'rendicion_carga_fecha'                     => '',
                        'rendicion_tarea_cantidad'                  => '',
                        'rendicion_tarea_resuelta'                  => '',
                        'rendicion_tarea_porcentaje'                => '',
                        'rendicion_observacion'                     => ''
                    );

                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                }

                $stmtMSSQL00->closeCursor();
                $stmtMSSQL00 = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        }  else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v2/500/rendicion/detalle/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01  = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
                a.RENFDECOD         AS          rendicion_detalle_codigo,
                a.RENFDEDES         AS          rendicion_detalle_descripcion,
                a.RENFDEIMP         AS          rendicion_detalle_importe,
                a.RENFDECSS         AS          rendicion_detalle_css,
                a.RENFDEOBS         AS          rendicion_detalle_observacion,

                a.RENFDEAUS         AS          auditoria_usuario,
                a.RENFDEAFH         AS          auditoria_fecha_hora,
                a.RENFDEAIP         AS          auditoria_ip,

                b.RENFCACOD         AS          rendicion_cabecera_codigo,
                b.RENFCATNR         AS          rendicion_cabecera_timbrado_numero,
                b.RENFCATVE         AS          rendicion_cabecera_timbrado_vencimiento,
                b.RENFCAFFE         AS          rendicion_cabecera_factura_fecha,
                b.RENFCAFNU         AS          rendicion_cabecera_factura_numero,
                b.RENFCAFRS         AS          rendicion_cabecera_factura_razonsocial,
                b.RENFCAFAD         AS          rendicion_cabecera_factura_adjunto,
                b.RENFCAFTO         AS          rendicion_cabecera_factura_importe,
                b.RENFCAOBS         AS          rendicion_cabecera_observacion,

                c.RENFICCOD         AS          rendicion_codigo,
                c.RENFICPER         AS          rendicion_periodo,
                c.RENFICENO         AS          rendicion_evento_nombre,
                c.RENFICEFE         AS          rendicion_evento_fecha,
                c.RENFICDNS         AS          rendicion_documento_solicitante,
                c.RENFICDNJ         AS          rendicion_documento_jefatura,
                c.RENFICDNA         AS          rendicion_documento_analista,
                c.RENFICFEC         AS          rendicion_carga_fecha,
                c.RENFICTCA         AS          rendicion_tarea_cantidad,
                c.RENFICTRE         AS          rendicion_tarea_resuelta,
                c.RENFICOBS         AS          rendicion_observacion,

                d.DOMFICCOD         AS          tipo_concepto_codigo,
                d.DOMFICNOI         AS          tipo_concepto_ingles,
                d.DOMFICNOC         AS          tipo_concepto_castellano,
                d.DOMFICNOP         AS          tipo_concepto_portugues,
                d.DOMFICCSS         AS          tipo_concepto_css,
                d.DOMFICPAR         AS          tipo_concepto_parametro,

                e.DOMFICCOD         AS          tipo_alerta_codigo,
                e.DOMFICNOI         AS          tipo_alerta_ingles,
                e.DOMFICNOC         AS          tipo_alerta_castellano,
                e.DOMFICNOP         AS          tipo_alerta_portugues,
                e.DOMFICCSS         AS          tipo_alerta_css,
                e.DOMFICPAR         AS          tipo_alerta_parametro,

                f.WRKFICCOD         AS          workflow_codigo,
                f.WRKFICORD         AS          workflow_orden,
                f.WRKFICNOM         AS          workflow_tarea,

                g.DOMFICCOD         AS          estado_anterior_codigo,
                g.DOMFICNOI         AS          estado_anterior_ingles,
                g.DOMFICNOC         AS          estado_anterior_castellano,
                g.DOMFICNOP         AS          estado_anterior_portugues,
                g.DOMFICCSS         AS          estado_anterior_css,
                g.DOMFICPAR         AS          estado_anterior_parametro,

                h.DOMFICCOD         AS          estado_actual_codigo,
                h.DOMFICNOI         AS          estado_actual_ingles,
                h.DOMFICNOC         AS          estado_actual_castellano,
                h.DOMFICNOP         AS          estado_actual_portugues,
                h.DOMFICCSS         AS          estado_actual_css,
                h.DOMFICPAR         AS          estado_actual_parametro,

                i.WRKDETCOD         AS          workflow_detalle_codigo,
                i.WRKDETORD         AS          workflow_detalle_orden,
                i.WRKDETTCC         AS          workflow_detalle_cargo,
                i.WRKDETHOR         AS          workflow_detalle_hora,
                i.WRKDETNOM         AS          workflow_detalle_tarea

                FROM [con].[RENFDE] a
                INNER JOIN [con].[RENFCA] b ON a.RENFDEFCC = b.RENFCACOD
                INNER JOIN [con].[RENFIC] c ON b.RENFCAREC = c.RENFICCOD
                INNER JOIN [adm].[DOMFIC] d ON a.RENFDETCC = d.DOMFICCOD
                INNER JOIN [adm].[DOMFIC] e ON a.RENFDETAC = e.DOMFICCOD
                INNER JOIN [wrk].[WRKFIC] f ON a.RENFDEWFC = f.WRKFICCOD
                INNER JOIN [adm].[DOMFIC] g ON a.RENFDEEAC = g.DOMFICCOD
                INNER JOIN [adm].[DOMFIC] h ON a.RENFDEECC = h.DOMFICCOD
                INNER JOIN [wrk].[WRKDET] i ON f.WRKFICCOD = i.WRKDETWFC AND a.RENFDEEAC = i.WRKDETEAC AND a.RENFDEECC = i.WRKDETECC

                WHERE c.RENFICCOD = ?

                ORDER BY a.RENFDEFCC DESC";

            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val01]);

                while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                    $detalle    = array(
                        'rendicion_detalle_codigo'                  => $rowMSSQL00['rendicion_detalle_codigo'],
                        'rendicion_detalle_descripcion'             => trim(strtoupper(strtolower($rowMSSQL00['rendicion_detalle_descripcion']))),
                        'rendicion_detalle_importe'                 => number_format($rowMSSQL00['rendicion_detalle_importe'], 2, '.', ''),
                        'rendicion_detalle_css'                     => trim(strtoupper(strtolower($rowMSSQL00['rendicion_detalle_css']))),
                        'rendicion_detalle_observacion'             => trim(strtoupper(strtolower($rowMSSQL00['rendicion_detalle_observacion']))),

                        'auditoria_usuario'                         => trim(strtoupper(strtolower($rowMSSQL00['auditoria_usuario']))),
                        'auditoria_fecha_hora'                      => date("d/m/Y", strtotime($rowMSSQL00['auditoria_fecha_hora'])),
                        'auditoria_ip'                              => trim(strtoupper(strtolower($rowMSSQL00['auditoria_ip']))),

                        'rendicion_cabecera_codigo'                 => $rowMSSQL00['rendicion_cabecera_codigo'],
                        'rendicion_cabecera_timbrado_numero'        => trim(strtoupper(strtolower($rowMSSQL00['rendicion_cabecera_timbrado_numero']))),
                        'rendicion_cabecera_timbrado_vencimiento'   => date("d/m/Y", strtotime($rowMSSQL00['rendicion_cabecera_timbrado_vencimiento'])),
                        'rendicion_cabecera_factura_fecha'          => date("d/m/Y", strtotime($rowMSSQL00['rendicion_cabecera_factura_fecha'])),
                        'rendicion_cabecera_factura_numero'         => trim(strtoupper(strtolower($rowMSSQL00['rendicion_cabecera_factura_numero']))),
                        'rendicion_cabecera_factura_razonsocial'    => trim(strtoupper(strtolower($rowMSSQL00['rendicion_cabecera_factura_razonsocial']))),
                        'rendicion_cabecera_factura_adjunto'        => trim(strtolower($rowMSSQL00['rendicion_cabecera_factura_adjunto'])),
                        'rendicion_cabecera_factura_importe'        => $rowMSSQL00['rendicion_cabecera_factura_importe'],
                        'rendicion_cabecera_observacion'            => trim(strtoupper(strtolower($rowMSSQL00['rendicion_cabecera_observacion']))),

                        'rendicion_codigo'                          => $rowMSSQL00['rendicion_codigo'],
                        'rendicion_periodo'                         => $rowMSSQL00['rendicion_periodo'],
                        'rendicion_evento_nombre'                   => trim(strtoupper(strtolower($rowMSSQL00['rendicion_evento_nombre']))),
                        'rendicion_evento_fecha'                    => date("d/m/Y", strtotime($rowMSSQL00['rendicion_evento_fecha'])),
                        'rendicion_documento_solicitante'           => trim(strtoupper(strtolower($rowMSSQL00['rendicion_documento_solicitante']))),
                        'rendicion_documento_jefatura'              => trim(strtoupper(strtolower($rowMSSQL00['rendicion_documento_jefatura']))),
                        'rendicion_documento_analista'              => trim(strtoupper(strtolower($rowMSSQL00['rendicion_documento_analista']))),
                        'rendicion_carga_fecha'                     => date("d/m/Y", strtotime($rowMSSQL00['rendicion_carga_fecha'])),
                        'rendicion_tarea_cantidad'                  => $rowMSSQL00['rendicion_tarea_cantidad'],
                        'rendicion_tarea_resuelta'                  => $rowMSSQL00['rendicion_tarea_resuelta'],
                        'rendicion_tarea_porcentaje'                => number_format((($rowMSSQL00['rendicion_tarea_resuelta'] * 100) / $rowMSSQL00['rendicion_tarea_cantidad']), 2, '.', ''),
                        'rendicion_observacion'                     => trim(strtoupper(strtolower($rowMSSQL00['rendicion_observacion']))),

                        'tipo_concepto_codigo'                      => $rowMSSQL00['tipo_concepto_codigo'],
                        'tipo_concepto_ingles'                      => trim(strtoupper(strtolower($rowMSSQL00['tipo_concepto_ingles']))),
                        'tipo_concepto_castellano'                  => trim(strtoupper(strtolower($rowMSSQL00['tipo_concepto_castellano']))),
                        'tipo_concepto_portugues'                   => trim(strtoupper(strtolower($rowMSSQL00['tipo_concepto_portugues']))),
                        'tipo_concepto_css'                         => trim(strtolower($rowMSSQL00['tipo_concepto_css'])),
                        'tipo_concepto_parametro'                   => $rowMSSQL00['tipo_concepto_parametro'],

                        'tipo_alerta_codigo'                        => $rowMSSQL00['tipo_alerta_codigo'],
                        'tipo_alerta_ingles'                        => trim(strtoupper(strtolower($rowMSSQL00['tipo_alerta_ingles']))),
                        'tipo_alerta_castellano'                    => trim(strtoupper(strtolower($rowMSSQL00['tipo_alerta_castellano']))),
                        'tipo_alerta_portugues'                     => trim(strtoupper(strtolower($rowMSSQL00['tipo_alerta_portugues']))),
                        'tipo_alerta_css'                           => trim(strtolower($rowMSSQL00['tipo_alerta_css'])),
                        'tipo_alerta_parametro'                     => $rowMSSQL00['tipo_alerta_parametro'],

                        'workflow_codigo'                           => $rowMSSQL00['workflow_codigo'],
                        'workflow_orden'                            => $rowMSSQL00['workflow_orden'],
                        'workflow_tarea'                            => trim(strtoupper(strtolower($rowMSSQL00['workflow_tarea']))),

                        'workflow_detalle_codigo'                   => $rowMSSQL00['workflow_detalle_codigo'],
                        'workflow_detalle_orden'                    => $rowMSSQL00['workflow_detalle_orden'],
                        'workflow_detalle_cargo'                    => $rowMSSQL00['workflow_detalle_cargo'],
                        'workflow_detalle_hora'                     => trim(strtoupper(strtolower($rowMSSQL00['workflow_detalle_hora']))),
                        'workflow_detalle_tarea'                    => trim(strtoupper(strtolower($rowMSSQL00['workflow_detalle_tarea']))),

                        'estado_anterior_codigo'                    => $rowMSSQL00['estado_anterior_codigo'],
                        'estado_anterior_ingles'                    => trim(strtoupper(strtolower($rowMSSQL00['estado_anterior_ingles']))),
                        'estado_anterior_castellano'                => trim(strtoupper(strtolower($rowMSSQL00['estado_anterior_castellano']))),
                        'estado_anterior_portugues'                 => trim(strtoupper(strtolower($rowMSSQL00['estado_anterior_portugues']))),
                        'estado_anterior_css'                       => trim(strtolower($rowMSSQL00['estado_anterior_css'])),
                        'estado_anterior_parametro'                 => $rowMSSQL00['estado_anterior_parametro'],

                        'estado_actual_codigo'                      => $rowMSSQL00['estado_actual_codigo'],
                        'estado_actual_ingles'                      => trim(strtoupper(strtolower($rowMSSQL00['estado_actual_ingles']))),
                        'estado_actual_castellano'                  => trim(strtoupper(strtolower($rowMSSQL00['estado_actual_castellano']))),
                        'estado_actual_portugues'                   => trim(strtoupper(strtolower($rowMSSQL00['estado_actual_portugues']))),
                        'estado_actual_css'                         => trim(strtolower($rowMSSQL00['estado_actual_css'])),
                        'estado_actual_parametro'                   => $rowMSSQL00['estado_actual_parametro']
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle    = array(
                        'rendicion_detalle_codigo'                  => '',
                        'rendicion_detalle_descripcion'             => '',
                        'rendicion_detalle_importe'                 => '',
                        'rendicion_detalle_css'                     => '',
                        'rendicion_detalle_observacion'             => '',

                        'auditoria_usuario'                         => '',
                        'auditoria_fecha_hora'                      => '',
                        'auditoria_ip'                              => '',

                        'rendicion_cabecera_codigo'                 => '',
                        'rendicion_cabecera_timbrado_numero'        => '',
                        'rendicion_cabecera_timbrado_vencimiento'   => '',
                        'rendicion_cabecera_factura_fecha'          => '',
                        'rendicion_cabecera_factura_numero'         => '',
                        'rendicion_cabecera_factura_razonsocial'    => '',
                        'rendicion_cabecera_factura_adjunto'        => '',
                        'rendicion_cabecera_factura_importe'        => '',
                        'rendicion_cabecera_observacion'            => '',

                        'rendicion_codigo'                          => '',
                        'rendicion_periodo'                         => '',
                        'rendicion_evento_nombre'                   => '',
                        'rendicion_evento_fecha'                    => '',
                        'rendicion_documento_solicitante'           => '',
                        'rendicion_documento_jefatura'              => '',
                        'rendicion_documento_analista'              => '',
                        'rendicion_carga_fecha'                     => '',
                        'rendicion_tarea_cantidad'                  => '',
                        'rendicion_tarea_resuelta'                  => '',
                        'rendicion_tarea_porcentaje'                => '',
                        'rendicion_observacion'                     => '',

                        'tipo_concepto_codigo'                      => '',
                        'tipo_concepto_ingles'                      => '',
                        'tipo_concepto_castellano'                  => '',
                        'tipo_concepto_portugues'                   => '',
                        'tipo_concepto_css'                         => '',
                        'tipo_concepto_parametro'                   => '',

                        'tipo_alerta_codigo'                        => '',
                        'tipo_alerta_ingles'                        => '',
                        'tipo_alerta_castellano'                    => '',
                        'tipo_alerta_portugues'                     => '',
                        'tipo_alerta_css'                           => '',
                        'tipo_alerta_parametro'                     => '',

                        'workflow_codigo'                           => '',
                        'workflow_orden'                            => '',
                        'workflow_tarea'                            => '',

                        'workflow_detalle_codigo'                   => '',
                        'workflow_detalle_orden'                    => '',
                        'workflow_detalle_cargo'                    => '',
                        'workflow_detalle_hora'                     => '',
                        'workflow_detalle_tarea'                    => '',

                        'estado_anterior_codigo'                    => '',
                        'estado_anterior_ingles'                    => '',
                        'estado_anterior_castellano'                => '',
                        'estado_anterior_portugues'                 => '',
                        'estado_anterior_css'                       => '',
                        'estado_anterior_parametro'                 => '',

                        'estado_actual_codigo'                      => '',
                        'estado_actual_ingles'                      => '',
                        'estado_actual_castellano'                  => '',
                        'estado_actual_portugues'                   => '',
                        'estado_actual_css'                         => '',
                        'estado_actual_parametro'                   => ''
                    );

                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                }

                $stmtMSSQL00->closeCursor();
                $stmtMSSQL00 = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        }  else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });
/*MODULO RENDICION*/