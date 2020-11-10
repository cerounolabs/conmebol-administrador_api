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

    $app->get('/v2/200/comprobante', function($request) {//20201105
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
            b.DOMFICPAR         AS          tipo_estado_parametro,
            b.DOMFICICO         AS          tipo_estado_icono,
            b.DOMFICCSS         AS          tipo_estado_CSS,

            c.DOMFICCOD         AS          tipo_comprobante_codigo,
            c.DOMFICNOI         AS          tipo_comprobante_ingles,
            c.DOMFICNOC         AS          tipo_comprobante_castellano,
            c.DOMFICNOP         AS          tipo_comprobante_portugues,
            c.DOMFICPAR         AS          tipo_comprobante_parametro,
            c.DOMFICICO         AS          tipo_comprobante_icono,
            c.DOMFICCSS         AS          tipo_comprobante_CSS,

            d.DOMFICCOD         AS          tipo_mes_codigo,
            d.DOMFICNOI         AS          tipo_mes_ingles,
            d.DOMFICNOC         AS          tipo_mes_castellano,
            d.DOMFICNOP         AS          tipo_mes_portugues,
            d.DOMFICPAR         AS          tipo_mes_parametro,
            d.DOMFICICO         AS          tipo_mes_icono,
            d.DOMFICCSS         AS          tipo_mes_CSS

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

                $periodo    = $rowMSSQL00['comprobante_periodo'];
                $mes        = $rowMSSQL00['tipo_mes_parametro'];
                $tipoComprobante =  $rowMSSQL00['tipo_comprobante_parametro'];

                if ($rowMSSQL00['tipo_mes_parametro'] > 0 && $rowMSSQL00['tipo_mes_parametro'] < 10){
                    $codigobarra = $nroDoc.'-'.$periodo.'/'.'0'.$mes.'-'.$tipoComprobante;
                } else {
                    $codigobarra = $nroDoc.'-'.$periodo.'/'.$mes.'-'.$tipoComprobante;
                }
              
                $detalle    = array(
                    'comprobante_codigo'                => $rowMSSQL00['comprobante_codigo'],
                    'comprobante_periodo'               => $rowMSSQL00['comprobante_periodo'],
                    'comprobante_colaborador'           => trim(strtoupper(strtolower($rowMSSQL01['nombre_completo']))),
                    'comprobante_documento'             => trim(strtoupper(strtolower($rowMSSQL00['comprobante_documento']))),
                    'comprobante_adjunto'               => trim(strtolower($rowMSSQL00['comprobante_adjunto'])),
                    'comprobante_observacion'           => trim(strtoupper(strtolower($rowMSSQL00['comprobante_observacion']))),
                    'comprobante_codigo_barra'          => trim(strtoupper(strtolower($codigobarra))),

                    'auditoria_usuario'                 => trim(strtoupper(strtolower($rowMSSQL01['auditoria_usuario']))),
                    'auditoria_fecha_hora'              => date("d/m/Y", strtotime($rowMSSQL01['auditoria_fecha_hora'])),
                    'auditoria_ip'                      => trim(strtoupper(strtolower($rowMSSQL01['auditoria_ip']))),

                    'tipo_estado_codigo'                => $rowMSSQL00['tipo_estado_codigo'],
                    'tipo_estado_ingles'                => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_ingles']))),
                    'tipo_estado_castellano'            => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_castellano']))),
                    'tipo_estado_portugues'             => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_portugues']))),
                    'tipo_estado_parametro'             => $rowMSSQL00['tipo_estado_parametro'],
                    'tipo_estado_icono'                 => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_icono']))),
                    'tipo_estado_CSS'                   => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_CSS']))),

                    'tipo_comprobante_codigo'           => $rowMSSQL00['tipo_comprobante_codigo'],
                    'tipo_comprobante_ingles'           => trim(strtoupper(strtolower($rowMSSQL00['tipo_comprobante_ingles']))),
                    'tipo_comprobante_castellano'       => trim(strtoupper(strtolower($rowMSSQL00['tipo_comprobante_castellano']))),
                    'tipo_comprobante_portugues'        => trim(strtoupper(strtolower($rowMSSQL00['tipo_comprobante_portugues']))),
                    'tipo_comprobante_parametro'        => $rowMSSQL00['tipo_comprobante_parametro'],
                    'tipo_comprobante_icono'            => trim(strtoupper(strtolower($rowMSSQL00['tipo_comprobante_icono']))),
                    'tipo_comprobante_CSS'              => trim(strtoupper(strtolower($rowMSSQL00['tipo_comprobante_CSS']))),

                    'tipo_mes_codigo'                   => $rowMSSQL00['tipo_mes_codigo'],
                    'tipo_mes_castellano'               => trim(strtoupper(strtolower($rowMSSQL00['tipo_mes_castellano']))),
                    'tipo_mes_ingles'                   => trim(strtoupper(strtolower($rowMSSQL00['tipo_mes_ingles']))),
                    'tipo_mes_portugues'                => trim(strtoupper(strtolower($rowMSSQL00['tipo_mes_portugues']))),
                    'tipo_mes_parametro'                => $rowMSSQL00['tipo_mes_parametro'],
                    'tipo_mes_icono'                    => trim(strtoupper(strtolower($rowMSSQL00['tipo_mes_icono']))),
                    'tipo_mes_CSS'                      => trim(strtoupper(strtolower($rowMSSQL00['tipo_mes_CSS']))),

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
                    'comprobante_codigo_barra'          => '',
                    
                    'auditoria_usuario'                 => '',
                    'auditoria_fecha_hora'              => '',
                    'auditoria_ip'                      => '',

                    'tipo_estado_codigo'                => '',
                    'tipo_estado_ingles'                => '',
                    'tipo_estado_castellano'            => '',
                    'tipo_estado_portugues'             => '',
                    'tipo_estado_parametro'             => '',
                    'tipo_estado_icono'                 => '',
                    'tipo_estado_CSS'                   => '',

                    'tipo_comprobante_codigo'           => '',
                    'tipo_comprobante_ingles'           => '',
                    'tipo_comprobante_castellano'       => '',
                    'tipo_comprobante_portugues'        => '',
                    'tipo_comprobante_parametro'        => '',
                    'tipo_comprobante_icono'            => '',
                    'tipo_comprobante_CSS'              => '',

                    'tipo_mes_codigo'                   => '',
                    'tipo_mes_castellano'               => '',
                    'tipo_mes_ingles'                   => '',
                    'tipo_mes_portugues'                => '',
                    'tipo_mes_parametro'                => '',
                    'tipo_mes_icono'                    => '',
                    'tipo_mes_CSS'                      => '',
                    
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
            a.SOLFICVUE         AS          solicitud_vuelo,
            a.SOLFICHOS         AS          solicitud_hospedaje,
            a.SOLFICTRA         AS          solicitud_traslado,
            a.SOLFICSTV         AS          solicitud_solicitante_tarifa_vuelo,
            a.SOLFICSTH         AS          solicitud_solicitante_tarifa_hospedaje,
            a.SOLFICSTT         AS          solicitud_solicitante_tarifa_traslado,
            a.SOLFICPCV         AS          solicitud_proveedor_carga_vuelo,
            a.SOLFICPCH         AS          solicitud_proveedor_carga_hospedaje,
            a.SOLFICPCT		    AS	        solicitud_proveedor_carga_traslado,
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
            a.SOLFICDNP         AS          solicitud_proveedor_documento,

            m.DOMFICCOD         AS          tipo_dificultad_codigo,
            m.DOMFICNOI         AS          tipo_dificultad_ingles,
            m.DOMFICNOC         AS          tipo_dificultad_castellano,
            m.DOMFICNOP         AS          tipo_dificultad_portugues,
            m.DOMFICPAR         AS          tipo_dificultad_parametro,
            m.DOMFICICO         AS          tipo_dificultad_icono,
            m.DOMFICCSS         AS          tipo_dificultad_css,

            n.DOMFICCOD         AS          tipo_estado_codigo,
            n.DOMFICNOI         AS          tipo_estado_ingles,
            n.DOMFICNOC         AS          tipo_estado_castellano,
            n.DOMFICNOP         AS          tipo_estado_portugues,
            n.DOMFICPAR         AS          tipo_estado_parametro,
            n.DOMFICICO         AS          tipo_estado_icono,
            n.DOMFICCSS         AS          tipo_estado_css

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
            INNER JOIN [adm].[DOMFIC] k ON a.SOLFICTPC = k.DOMFICCOD
            LEFT OUTER JOIN [CSF].[dbo].[empleados_AxisONE] l1 ON a.SOLFICDNS COLLATE SQL_Latin1_General_CP1_CI_AS = l1.CedulaEmpleado
            LEFT OUTER JOIN [CSF].[dbo].[empleados_AxisONE] l2 ON a.SOLFICDNJ COLLATE SQL_Latin1_General_CP1_CI_AS = l2.CedulaEmpleado
            LEFT OUTER JOIN [CSF].[dbo].[empleados_AxisONE] l3 ON a.SOLFICDNE COLLATE SQL_Latin1_General_CP1_CI_AS = l3.CedulaEmpleado
            LEFT OUTER JOIN [CSF].[dbo].[empleados_AxisONE] l4 ON a.SOLFICDNP COLLATE SQL_Latin1_General_CP1_CI_AS = l4.CedulaEmpleado
            INNER JOIN [adm].[DOMFIC] m ON a.SOLFICTDC = m.DOMFICCOD
            INNER JOIN [adm].[DOMFIC] n ON a.SOLFICEST = n.DOMFICCOD

            ORDER BY a.SOLFICCOD DESC";

        try {
            $connMSSQL  = getConnectionMSSQLv2();
            $stmtMSSQL00= $connMSSQL->prepare($sql00);
            $stmtMSSQL00->execute();

            while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                if(!empty($rowMSSQL00['solicitud_fecha_carga'])){
                    $solicitud_fecha_carga_1    = $rowMSSQL00['solicitud_fecha_carga'];
                    $solicitud_fecha_carga_2    = date("d/m/Y", strtotime($rowMSSQL00['solicitud_fecha_carga']));
                } else {
                    $solicitud_fecha_carga_1    = '';
                    $solicitud_fecha_carga_2    = '';
                }

                $detalle = array(                    
                    'solicitud_codigo'                      => $rowMSSQL00['solicitud_codigo'],
                    'solicitud_periodo'                     => $rowMSSQL00['solicitud_periodo'],
                    'solicitud_motivo'                      => trim(strtoupper(strtolower($rowMSSQL00['solicitud_motivo']))),
                    'solicitud_vuelo'                       => trim(strtoupper(strtolower($rowMSSQL00['solicitud_vuelo']))),
                    'solicitud_hospedaje'                   => trim(strtoupper(strtolower($rowMSSQL00['solicitud_hospedaje']))),
                    'solicitud_traslado'                    => trim(strtoupper(strtolower($rowMSSQL00['solicitud_traslado']))),
                    'solicitud_solicitante_tarifa_vuelo'    => trim(strtoupper(strtolower($rowMSSQL00['solicitud_solicitante_tarifa_vuelo']))),
                    'solicitud_solicitante_tarifa_hospedaje'=> trim(strtoupper(strtolower($rowMSSQL00['solicitud_solicitante_tarifa_hospedaje']))),
                    'solicitud_solicitante_tarifa_traslado' => trim(strtoupper(strtolower($rowMSSQL00['solicitud_solicitante_tarifa_traslado']))),
                    'solicitud_proveedor_carga_hospedaje'   => trim(strtoupper(strtolower($rowMSSQL00['solicitud_proveedor_carga_hospedaje']))),
                    'solicitud_proveedor_carga_hospedaje'   => trim(strtoupper(strtolower($rowMSSQL00['solicitud_proveedor_carga_hospedaje']))),
                    'solicitud_proveedor_carga_traslado'    => trim(strtoupper(strtolower($rowMSSQL00['solicitud_proveedor_carga_traslado']))),
                    'solicitud_fecha_carga_1'               => $solicitud_fecha_carga_1,
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
                    'tipo_prioridad_css'                    => trim(strtolower($rowMSSQL00['tipo_prioridad_css'])),

                    'tipo_dificultad_codigo'                => $rowMSSQL00['tipo_dificultad_codigo'],
                    'tipo_dificultad_ingles'                => trim(strtoupper(strtolower($rowMSSQL00['tipo_dificultad_ingles']))),
                    'tipo_dificultad_castellano'            => trim(strtoupper(strtolower($rowMSSQL00['tipo_dificultad_castellano']))),
                    'tipo_dificultad_portugues'             => trim(strtoupper(strtolower($rowMSSQL00['tipo_dificultad_portugues']))),
                    'tipo_dificultad_parametro'             => $rowMSSQL00['tipo_dificultad_parametro'],
                    'tipo_dificultad_icono'                 => trim(strtolower($rowMSSQL00['tipo_dificultad_icono'])),
                    'tipo_dificultad_css'                   => trim(strtolower($rowMSSQL00['tipo_dificultad_css'])),

                    'tipo_estado_codigo'                    => $rowMSSQL00['tipo_estado_codigo'],
                    'tipo_estado_ingles'                    => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_ingles']))),
                    'tipo_estado_castellano'                => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_castellano']))),
                    'tipo_estado_portugues'                 => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_portugues']))),
                    'tipo_estado_parametro'                 => $rowMSSQL00['tipo_estado_parametro'],
                    'tipo_estado_icono'                     => trim(strtolower($rowMSSQL00['tipo_estado_icono'])),
                    'tipo_estado_css'                       => trim(strtolower($rowMSSQL00['tipo_estado_css']))
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
                    'solicitud_vuelo'                       => '',
                    'solicitud_hospedaje'                   => '',
                    'solicitud_traslado'                    => '',
                    'solicitud_solicitante_tarifa_vuelo'    => '',
                    'solicitud_solicitante_tarifa_hospedaje'=> '',
                    'solicitud_solicitante_tarifa_traslado' => '',
                    'solicitud_proveedor_carga_vuelo'       => '',
                    'solicitud_proveedor_carga_hospedaje'   => '',
                    'solicitud_proveedor_carga_traslado'    => '',
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
                    'tipo_prioridad_css'                    => '',

                    'tipo_dificultad_codigo'                => '',
                    'tipo_dificultad_ingles'                => '',
                    'tipo_dificultad_castellano'            => '',
                    'tipo_dificultad_portugues'             => '',
                    'tipo_dificultad_parametro'             => '',
                    'tipo_dificultad_icono'                 => '',
                    'tipo_dificultad_css'                   => '',

                    'tipo_estado_codigo'                    => '',
                    'tipo_estado_ingles'                    => '',
                    'tipo_estado_castellano'                => '',
                    'tipo_estado_portugues'                 => '',
                    'tipo_estado_parametro'                 => '',
                    'tipo_estado_icono'                     => '',
                    'tipo_estado_css'                       => ''
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

    $app->get('/v2/400/solicitud/consulta/{codigo}', function($request) {//20201102//20201105 M
        require __DIR__.'/../src/connect.php';

        $val01  = $request->getAttribute('codigo'); 
        $sql00  = "SELECT 
            a.SOLCONCOD	        AS          solicitud_consulta_codigo,
            a.SOLCONPDO         AS          solicitud_consulta_persona_documento,
            a.SOLCONPNO	        AS          solicitud_consulta_persona_nombre,
            a.SOLVUEFEC	        AS          solicitud_consulta_fecha,
            a.SOLCONOBS	        AS          solicitud_consulta_observacion,
            
            a.SOLCONAUS         AS          auditoria_usuario,
            a.SOLCONAFH	        AS          auditoria_fecha_hora,
            a.SOLCONAIP         AS          auditoria_ip,
            
            b.DOMFICCOD         AS          tipo_estado_codigo,
            b.DOMFICNOI         AS          tipo_estado_nombre_ingles,
            b.DOMFICNOC         AS          tipo_estado_nombre_castellano,
            b.DOMFICNOP         AS          tipo_estado_nombre_portugues,         
            b.DOMFICPAR         AS          tipo_estado_parametro,
            b.DOMFICCSS         AS          tipo_estado_CSS,	
            b.DOMFICICO         AS          tipo_estado_icono,
            
            c.SOLFICCOD         AS          solicitud_codigo,
            c.SOLFICPER         AS          solicitud_periodo,
            c.SOLFICMOT         AS          solicitud_motivo,
            c.SOLFICVUE         AS          solicitud_vuelo,
            c.SOLFICHOS         AS          solicitud_hospedaje,
            c.SOLFICTRA         AS          solicitud_traslado,
            c.SOLFICSTV         AS          solicitud_solicitante_tarifa_vuelo,
            c.SOLFICSTH         AS          solicitud_solicitante_tarifa_hospedaje,
            c.SOLFICSTT         AS          solicitud_solicitante_tarifa_traslado,
            c.SOLFICPCV         AS          solicitud_proveedor_carga_vuelo,
            c.SOLFICPCH         AS          solicitud_proveedor_carga_hospedaje,
            c.SOLFICPCT		    AS	        solicitud_proveedor_carga_traslado,
            c.SOLFICFEC         AS          solicitud_fecha_carga,
            c.SOLFICSCC         AS          solicitud_sap_centro_costo,
            c.SOLFICTCA         AS          solicitud_tarea_cantidad,
            c.SOLFICTRE         AS          solicitud_tarea_resuelta,
            c.SOLFICOBS         AS          solicitud_observacion,
            
            d.DOMFICCOD         AS          tipo_consulta_codigo,
            b.DOMFICNOI         AS          tipo_consulta_nombre_ingles,
            b.DOMFICNOC         AS          tipo_consulta_nombre_castellano,
            b.DOMFICNOP         AS          tipo_consulta_nombre_portugues,      
            d.DOMFICPAR         AS          tipo_consulta_parametro,
            d.DOMFICCSS         AS          tipo_consulta_CSS,	
            d.DOMFICICO         AS          tipo_consulta_icono,
            
            e.DOMFICCOD         AS          tipo_solicitud_codigo,
            e.DOMFICNOI         AS          tipo_solicitud_nombre_ingles,
            e.DOMFICNOC         AS          tipo_solicitud_nombre_castellano,
            e.DOMFICNOP         AS          tipo_solicitud_nombre_portugues,      
            e.DOMFICPAR         AS          tipo_solicitud_parametro,
            e.DOMFICCSS         AS          tipo_solicitud_CSS,	
            e.DOMFICICO         AS          tipo_solicitud_icono
            
            FROM via.SOLCON a
            INNER JOIN adm.DOMFIC b ON a.SOLCONEST = b.DOMFICCOD
            INNER JOIN via.SOLFIC c ON a.SOLCONSOC = c.SOLFICCOD
            INNER JOIN adm.DOMFIC d ON a.SOLCONTCT = d.DOMFICCOD
            INNER JOIN adm.DOMFIC e ON a.SOLCONTSC = e.DOMFICCOD
            
            WHERE a.SOLCONSOC = ?
            
            ORDER BY a.SOLCONCOD DESC";

        try {
            $connMSSQL  = getConnectionMSSQLv2();
            $stmtMSSQL00= $connMSSQL->prepare($sql00);
            $stmtMSSQL00->execute([$val01]);

            while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                if(!empty($rowMSSQL00['solicitud_consulta_fecha'])){
                    $solicitud_consulta_fecha_1    = $rowMSSQL00['solicitud_consulta_fecha'];
                    $solicitud_consulta_fecha_2    = date("d/m/Y", strtotime($rowMSSQL00['solicitud_consulta_fecha']));
                } else {
                    $solicitud_consulta_fecha_1    = '';
                    $solicitud_consulta_fecha_2    = '';
                }

                if(!empty($rowMSSQL00['solicitud_fecha_carga'])){
                    $solicitud_fecha_carga_1    = $rowMSSQL00['solicitud_fecha_carga'];
                    $solicitud_fecha_carga_2    = date("d/m/Y", strtotime($rowMSSQL00['solicitud_fecha_carga']));
                } else {
                    $solicitud_fecha_carga_1    = '';
                    $solicitud_fecha_carga_2    = '';
                }

                $detalle = array(                    
                    'solicitud_consulta_codigo'                      => $rowMSSQL00['solicitud_consulta_codigo'],
                    'solicitud_consulta_persona_documento'           => trim(strtoupper(strtolower($rowMSSQL00['solicitud_consulta_persona_documento']))),
                    'solicitud_consulta_persona_nombre'              => trim(strtoupper(strtolower($rowMSSQL00['solicitud_consulta_persona_nombre']))),
                    'solicitud_consulta_fecha_1'                     => $solicitud_consulta_fecha_1,
                    'solicitud_consulta_fecha_2'                     => $solicitud_consulta_fecha_2,

                    'auditoria_usuario'                              => trim(strtoupper(strtolower($rowMSSQL00['auditoria_usuario']))),
                    'auditoria_fecha_hora'                           => date("d/m/Y", strtotime($rowMSSQL00['auditoria_fecha_hora'])),
                    'auditoria_ip'                                   => trim(strtoupper(strtolower($rowMSSQL00['auditoria_ip']))),

                    'tipo_estado_codigo'                             => $rowMSSQL00['tipo_estado_codigo'],
                    'tipo_estado_nombre_ingles'                      => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_nombre_ingles']))),
                    'tipo_estado_nombre_castellano'                  => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_nombre_castellano']))),
                    'tipo_estado_nombre_portugues'                   => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_nombre_portugues']))),   
                    'tipo_estado_parametro'                          => $rowMSSQL00['tipo_estado_parametro'],
                    'tipo_estado_CSS'	                             => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_CSS']))),
                    'tipo_estado_icono'                              => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_icono']))),
                    

                    'solicitud_codigo'                               => $rowMSSQL00['solicitud_codigo'],
                    'solicitud_periodo'                              => $rowMSSQL00['solicitud_periodo'],
                    'solicitud_motivo'                               => trim(strtoupper(strtolower($rowMSSQL00['solicitud_motivo']))),
                    'solicitud_vuelo'                                => trim(strtoupper(strtolower($rowMSSQL00['solicitud_vuelo']))),
                    'solicitud_hospedaje'                            => trim(strtoupper(strtolower($rowMSSQL00['solicitud_hospedaje']))),
                    'solicitud_traslado'                             => trim(strtoupper(strtolower($rowMSSQL00['solicitud_traslado']))),
                    'solicitud_solicitante_tarifa_vuelo'             => trim(strtoupper(strtolower($rowMSSQL00['solicitud_solicitante_tarifa_vuelo']))),
                    'solicitud_solicitante_tarifa_hospedaje'         => trim(strtoupper(strtolower($rowMSSQL00['solicitud_solicitante_tarifa_hospedaje']))),
                    'solicitud_solicitante_tarifa_traslado'          => trim(strtoupper(strtolower($rowMSSQL00['solicitud_solicitante_tarifa_traslado']))),
                    'solicitud_proveedor_carga_hospedaje'            => trim(strtoupper(strtolower($rowMSSQL00['solicitud_proveedor_carga_hospedaje']))),
                    'solicitud_proveedor_carga_hospedaje'            => trim(strtoupper(strtolower($rowMSSQL00['solicitud_proveedor_carga_hospedaje']))),
                    'solicitud_proveedor_carga_traslado'             => trim(strtoupper(strtolower($rowMSSQL00['solicitud_proveedor_carga_traslado']))),
                    'solicitud_fecha_carga_1'                        => $solicitud_fecha_carga_1,
                    'solicitud_fecha_carga_2'                        => $solicitud_fecha_carga_2,
                    'solicitud_sap_centro_costo'                     => trim(strtoupper(strtolower($rowMSSQL00['solicitud_sap_centro_costo']))),
                    'solicitud_tarea_cantidad'                       => $rowMSSQL00['solicitud_tarea_cantidad'],
                    'solicitud_tarea_resuelta'                       => $rowMSSQL00['solicitud_tarea_resuelta'],
                    'solicitud_tarea_porcentaje'                     => number_format((($rowMSSQL00['solicitud_tarea_resuelta'] * 100) / $rowMSSQL00['solicitud_tarea_cantidad']), 2, '.', ''),
                    'solicitud_solicitante_nombre'                   => trim(strtoupper(strtolower($rowMSSQL00['solicitud_solicitante_nombre']))),
                    'solicitud_solicitante_documento'                => trim(strtoupper(strtolower($rowMSSQL00['solicitud_solicitante_documento']))),
                    'solicitud_jefatura_nombre'                      => trim(strtoupper(strtolower($rowMSSQL00['solicitud_jefatura_nombre']))),
                    'solicitud_jefatura_documento'                   => trim(strtoupper(strtolower($rowMSSQL00['solicitud_jefatura_documento']))),
                    'solicitud_ejecutivo_nombre'                     => trim(strtoupper(strtolower($rowMSSQL00['solicitud_ejecutivo_nombre']))),
                    'solicitud_ejecutivo_documento'                  => trim(strtoupper(strtolower($rowMSSQL00['solicitud_ejecutivo_documento']))),
                    'solicitud_proveedor_nombre'                     => trim(strtoupper(strtolower($rowMSSQL00['solicitud_proveedor_nombre']))),
                    'solicitud_proveedor_documento'                  => trim(strtoupper(strtolower($rowMSSQL00['solicitud_proveedor_documento']))),
                    'solicitud_observacion'                          => trim(strtoupper(strtolower($rowMSSQL00['solicitud_observacion']))),

                    'tipo_consulta_codigo'                           => $rowMSSQL00['tipo_consulta_codigo'],
                    'tipo_consulta_nombre_ingles'                    => trim(strtoupper(strtolower($rowMSSQL00['tipo_consulta_nombre_ingles']))),
                    'tipo_consulta_nombre_castellano'                => trim(strtoupper(strtolower($rowMSSQL00['tipo_consulta_nombre_castellano']))),
                    'tipo_consulta_nombre_portugues'                 => trim(strtoupper(strtolower($rowMSSQL00['tipo_consulta_nombre_portugues']))),   
                    'tipo_consulta_parametro'                        => $rowMSSQL00['tipo_consulta_parametro'],
                    'tipo_consulta_CSS'	                             => trim(strtoupper(strtolower($rowMSSQL00['tipo_consulta_CSS']))),
                    'tipo_consulta_icono'                            => trim(strtoupper(strtolower($rowMSSQL00['tipo_consulta_icono']))),

                    'tipo_solicitud_codigo'                          => $rowMSSQL00['tipo_solicitud_codigo'],
                    'tipo_solicitud_nombre_ingles'                   => trim(strtoupper(strtolower($rowMSSQL00['tipo_solicitud_nombre_ingles']))),
                    'tipo_solicitud_nombre_castellano'               => trim(strtoupper(strtolower($rowMSSQL00['tipo_solicitud_nombre_castellano']))),
                    'tipo_solicitud_nombre_portugues'                => trim(strtoupper(strtolower($rowMSSQL00['tipo_solicitud_nombre_portugues']))),    
                    'tipo_solicitud_parametro'                       => $rowMSSQL00['tipo_solicitud_parametro'],
                    'tipo_solicitud_CSS'	                         => trim(strtoupper(strtolower($rowMSSQL00['tipo_solicitud_CSS']))),
                    'tipo_solicitud_icono'                           => trim(strtoupper(strtolower($rowMSSQL00['tipo_solicitud_icono'])))

                );

                $result[]   = $detalle;
            }

            if (isset($result)){
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } else {
                $detalle    = array(
                    'solicitud_consulta_codigo'                     => '',
                    'solicitud_consulta_persona_documento'          => '',
                    'solicitud_consulta_persona_nombre'             => '',
                    'solicitud_consulta_fecha_1'                    => '',
                    'solicitud_consulta_fecha_2'                    => '',

                    'auditoria_usuario'                             => '',
                    'auditoria_fecha_hora'                          => '',
                    'auditoria_ip'                                  => '',

                    'tipo_estado_codigo'                            => '',
                    'tipo_estado_nombre_ingles'                     => '',
                    'tipo_estado_nombre_castellano'                 => '',
                    'tipo_estado_nombre_portugues'                  => '',  
                    'tipo_estado_parametro'                         => '',
                    'tipo_estado_CSS'	                            => '',
                    'tipo_estado_icono'                             => '',

                    'solicitud_periodo'                             => '',
                    'solicitud_motivo'                              => '',
                    'solicitud_vuelo'                               => '',
                    'solicitud_hospedaje'                           => '',
                    'solicitud_traslado'                            => '',
                    'solicitud_solicitante_tarifa_vuelo'            => '',
                    'solicitud_solicitante_tarifa_hospedaje'        => '',
                    'solicitud_solicitante_tarifa_traslado'         => '',
                    'solicitud_proveedor_carga_vuelo'               => '',
                    'solicitud_proveedor_carga_hospedaje'           => '',
                    'solicitud_proveedor_carga_traslado'            => '',
                    'solicitud_fecha_carga_1'                       => '',
                    'solicitud_fecha_carga_2'                       => '',
                    'solicitud_sap_centro_costo'                    => '',
                    'solicitud_tarea_cantidad'                      => '',
                    'solicitud_tarea_resuelta'                      => '',
                    'solicitud_tarea_porcentaje'                    => '',
                    'solicitud_solicitante_nombre'                  => '',
                    'solicitud_solicitante_documento'               => '',
                    'solicitud_jefatura_nombre'                     => '',
                    'solicitud_jefatura_documento'                  => '',
                    'solicitud_ejecutivo_nombre'                    => '',
                    'solicitud_ejecutivo_documento'                 => '',
                    'solicitud_proveedor_nombre'                    => '',
                    'solicitud_proveedor_documento'                 => '',
                    'solicitud_observacion'                         => '',

                    'tipo_consulta_codigo'                          => '', 
                    'tipo_consulta_nombre_ingles'                   => '',
                    'tipo_consulta_nombre_castellano'               => '',
                    'tipo_consulta_nombre_portugues'                => '',
                    'tipo_consulta_parametro'                       => '',
                    'tipo_consulta_CSS'	                            => '',
                    'tipo_consulta_icono'                           => '',

                    'tipo_solicitud_codigo'                         => '', 
                    'tipo_solicitud_nombre_ingles'                  => '', 
                    'tipo_solicitud_nombre_castellano'              => '', 
                    'tipo_solicitud_nombre_portugues'               => '',    
                    'tipo_solicitud_parametro'                      => '', 
                    'tipo_solicitud_CSS'	                        => '', 
                    'tipo_solicitud_icono'                          => ''
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

    $app->get('/v2/400/solicitud/opcion/adjunto/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01 = $request->getAttribute('codigo'); 
        $sql00  = "SELECT 
            a.SOLOPACOD         AS          solicitud_opcion_codigo, 	
            a.SOLOPAPAT	        AS          solicitud_opcion_pat,
            a.SOLOPACOM         AS          solicitud_opcion_comentario,
            
            a.SOLOPAAUS	        AS          auditoria_usuario,
            a.SOLOPAAFH         AS          auditoria_fecha_hora,	
            a.SOLOPAAIP         AS          auditoria_ip,
            
            b.DOMFICCOD         AS          tipo_estado_codigo,
            b.DOMFICNOI         AS          tipo_estado_nombre_ingles,
            b.DOMFICNOC         AS          tipo_estado_nombre_castellano,
            b.DOMFICNOP         AS          tipo_estado_nombre_portugues,
            b.DOMFICPAR         AS          tipo_estado_parametro,
            b.DOMFICICO         AS          tipo_estado_icono,
            b.DOMFICCSS         AS          tipo_estado_css,
            
            c.DOMFICCOD         AS          tipo_documento_codigo,
            c.DOMFICNOI         AS          tipo_documento_nombre_ingles,
            c.DOMFICNOC         AS          tipo_documento_nombre_castellano,
            c.DOMFICNOP         AS          tipo_documento_nombre_portugues,
            c.DOMFICPAR         AS          tipo_documento_parametro,
            c.DOMFICICO         AS          tipo_documento_icono,
            c.DOMFICCSS         AS          tipo_documento_css,

            d.SOLFICCOD         AS          solicitud_codigo,
            d.SOLFICPER         AS          solicitud_periodo,
            d.SOLFICMOT         AS          solicitud_motivo,
            d.SOLFICVUE         AS          solicitud_vuelo,
            d.SOLFICHOS         AS          solicitud_hospedaje,
            d.SOLFICTRA         AS          solicitud_traslado,
            d.SOLFICSTV         AS          solicitud_solicitante_tarifa_vuelo,
            d.SOLFICSTH         AS          solicitud_solicitante_tarifa_hospedaje,
            d.SOLFICSTT         AS          solicitud_solicitante_tarifa_traslado,
            d.SOLFICPCV         AS          solicitud_proveedor_carga_vuelo,
            d.SOLFICPCH         AS          solicitud_proveedor_carga_hospedaje,
            d.SOLFICPCT		    AS	        solicitud_proveedor_carga_traslado,
            d.SOLFICFEC         AS          solicitud_fecha_carga,
            d.SOLFICSCC         AS          solicitud_sap_centro_costo,
            d.SOLFICTCA         AS          solicitud_tarea_cantidad,
            d.SOLFICTRE         AS          solicitud_tarea_resuelta,
            d.SOLFICOBS         AS          solicitud_observacion

            FROM via.SOLOPA a
            INNER JOIN adm.DOMFIC b ON a.SOLOPAEST = b.DOMFICCOD
            INNER JOIN adm.DOMFIC c ON a.SOLOPATDC = c.DOMFICCOD
            INNER JOIN via.SOLFIC d ON a.SOLOPASOC = d.SOLFICCOD
            
            WHERE a.SOLOPASOC = ?
            
            ORDER BY a.SOLOPACOD DESC";

        try {
            $connMSSQL  = getConnectionMSSQLv2();
            $stmtMSSQL00= $connMSSQL->prepare($sql00);
            $stmtMSSQL00->execute([$val01]);

            while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                if(!empty($rowMSSQL00['solicitud_fecha_carga'])){
                    $solicitud_fecha_carga_1    = $rowMSSQL00['solicitud_fecha_carga'];
                    $solicitud_fecha_carga_2    = date("d/m/Y", strtotime($rowMSSQL00['solicitud_fecha_carga']));
                } else {
                    $solicitud_fecha_carga_1    = '';
                    $solicitud_fecha_carga_2    = '';
                }

                $detalle = array(                    
                    'solicitud_opcion_codigo'                       => $rowMSSQL00['solicitud_opcion_codigo'],
                    'solicitud_opcion_pat'                          => trim(strtolower($rowMSSQL00['solicitud_opcion_pat'])),
                    'solicitud_opcion_comentario'                   => trim(strtoupper(strtolower($rowMSSQL00['solicitud_opcion_comentario']))),

                    'auditoria_usuario'                             => trim(strtoupper(strtolower($rowMSSQL00['auditoria_usuario']))),
                    'auditoria_fecha_hora'                          => date("d/m/Y", strtotime($rowMSSQL00['auditoria_fecha_hora'])),
                    'auditoria_ip'                                  => trim(strtoupper(strtolower($rowMSSQL00['auditoria_ip']))),

                    'tipo_estado_codigo'                            => $rowMSSQL00['tipo_estado_codigo'],
                    'tipo_estado_nombre_ingles'                     => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_nombre_ingles']))),
                    'tipo_estado_nombre_castellano'                 => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_nombre_castellano']))),
                    'tipo_estado_nombre_portugues'                  => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_nombre_portugues']))),
                    'tipo_estado_parametro'                         => $rowMSSQL00['tipo_estado_parametro'],
                    'tipo_estado_icono'                             => trim(strtolower($rowMSSQL00['tipo_estado_icono'])),       
                    'tipo_estado_css'                               => trim(strtolower($rowMSSQL00['tipo_estado_css'])),

                    'tipo_documento_codigo'                         => $rowMSSQL00['tipo_documento_codigo'],                      
                    'tipo_documento_nombre_ingles'                  => trim(strtoupper(strtolower($rowMSSQL00['tipo_documento_nombre_ingles']))),
                    'tipo_documento_nombre_castellano'              => trim(strtoupper(strtolower($rowMSSQL00['tipo_documento_nombre_castellano']))),
                    'tipo_documento_nombre_portugues'               => trim(strtoupper(strtolower($rowMSSQL00['tipo_documento_nombre_portugues']))),
                    'tipo_documento_parametro'                      => $rowMSSQL00['tipo_documento_parametro'],
                    'tipo_documento_icono'                          => trim(strtolower($rowMSSQL00['tipo_documento_icono'])),
                    'tipo_documento_css'                            => trim(strtolower($rowMSSQL00['tipo_documento_css'])),

                    'solicitud_codigo'                               => $rowMSSQL00['solicitud_codigo'],
                    'solicitud_periodo'                              => $rowMSSQL00['solicitud_periodo'],
                    'solicitud_motivo'                               => trim(strtoupper(strtolower($rowMSSQL00['solicitud_motivo']))),
                    'solicitud_vuelo'                                => trim(strtoupper(strtolower($rowMSSQL00['solicitud_vuelo']))),
                    'solicitud_hospedaje'                            => trim(strtoupper(strtolower($rowMSSQL00['solicitud_hospedaje']))),
                    'solicitud_traslado'                             => trim(strtoupper(strtolower($rowMSSQL00['solicitud_traslado']))),
                    'solicitud_solicitante_tarifa_vuelo'             => trim(strtoupper(strtolower($rowMSSQL00['solicitud_solicitante_tarifa_vuelo']))),
                    'solicitud_solicitante_tarifa_hospedaje'         => trim(strtoupper(strtolower($rowMSSQL00['solicitud_solicitante_tarifa_hospedaje']))),
                    'solicitud_solicitante_tarifa_traslado'          => trim(strtoupper(strtolower($rowMSSQL00['solicitud_solicitante_tarifa_traslado']))),
                    'solicitud_proveedor_carga_vuelo'                => trim(strtoupper(strtolower($rowMSSQL00['solicitud_proveedor_carga_vuelo']))),
                    'solicitud_proveedor_carga_hospedaje'            => trim(strtoupper(strtolower($rowMSSQL00['solicitud_proveedor_carga_hospedaje']))),
                    'solicitud_proveedor_carga_traslado'             => trim(strtoupper(strtolower($rowMSSQL00['solicitud_proveedor_carga_traslado']))),
                    'solicitud_fecha_carga_1'                        => $solicitud_fecha_carga_1,
                    'solicitud_fecha_carga_2'                        => $solicitud_fecha_carga_2,
                    'solicitud_sap_centro_costo'                     => trim(strtoupper(strtolower($rowMSSQL00['solicitud_sap_centro_costo']))),
                    'solicitud_tarea_cantidad'                       => $rowMSSQL00['solicitud_tarea_cantidad'],
                    'solicitud_tarea_resuelta'                       => $rowMSSQL00['solicitud_tarea_resuelta'],
                    'solicitud_observacion'                          => trim(strtoupper(strtolower($rowMSSQL00['solicitud_observacion'])))
     
                );

                $result[]   = $detalle;
            }

            if (isset($result)){
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } else {
                $detalle    = array(
                    'solicitud_opcion_codigo'                       => '',
                    'solicitud_opcion_pat'                          => '',
                    'solicitud_opcion_comentario'                   => '',

                    'auditoria_usuario'                             => '',
                    'auditoria_fecha_hora'                          => '',
                    'auditoria_ip'                                  => '',

                    'tipo_estado_codigo'                            => '',
                    'tipo_estado_nombre_ingles'                     => '',
                    'tipo_estado_nombre_castellano'                 => '',
                    'tipo_estado_nombre_portugues'                  => '',
                    'tipo_estado_parametro'                         => '',
                    'tipo_estado_icono'                             => '',
                    'tipo_estado_css'                               => '',

                    'tipo_documento_codigo'                         => '',
                    'tipo_documento_nombre_ingles'                  => '', 
                    'tipo_documento_nombre_castellano'              => '', 
                    'tipo_documento_nombre_portugues'               => '', 
                    'tipo_documento_parametro'                      => '', 
                    'tipo_documento_icono'                          => '', 
                    'tipo_documento_css'                            => '',

                    'solicitud_codigo'                               => '',
                    'solicitud_periodo'                              => '',
                    'solicitud_motivo'                               => '',
                    'solicitud_vuelo'                                => '',
                    'solicitud_hospedaje'                            => '',
                    'solicitud_traslado'                             => '',
                    'solicitud_solicitante_tarifa_vuelo'             => '',
                    'solicitud_solicitante_tarifa_hospedaje'         => '',
                    'solicitud_solicitante_tarifa_traslado'          => '',
                    'solicitud_proveedor_carga_vuelo'                => '',
                    'solicitud_proveedor_carga_hospedaje'            => '',
                    'solicitud_proveedor_carga_traslado'             => '',
                    'solicitud_fecha_carga_1'                        => '',
                    'solicitud_fecha_carga_2'                        => '',
                    'solicitud_sap_centro_costo'                     => '',
                    'solicitud_tarea_cantidad'                       => '',
                    'solicitud_tarea_resuelta'                       => '',
                    'solicitud_observacion'                          => ''
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
                a.SOLFICVUE         AS          solicitud_vuelo,
                a.SOLFICHOS         AS          solicitud_hospedaje,
                a.SOLFICTRA         AS          solicitud_traslado,
                a.SOLFICSTV         AS          solicitud_solicitante_tarifa_vuelo,
                a.SOLFICSTH         AS          solicitud_solicitante_tarifa_hospedaje,
                a.SOLFICSTT         AS          solicitud_solicitante_tarifa_traslado,
                a.SOLFICPCV         AS          solicitud_proveedor_carga_vuelo,
                a.SOLFICPCH         AS          solicitud_proveedor_carga_hospedaje,
                a.SOLFICPCT		    AS	        solicitud_proveedor_carga_traslado,
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
                a.SOLFICDNP         AS          solicitud_proveedor_documento,

                m.DOMFICCOD         AS          tipo_dificultad_codigo,
                m.DOMFICNOI         AS          tipo_dificultad_ingles,
                m.DOMFICNOC         AS          tipo_dificultad_castellano,
                m.DOMFICNOP         AS          tipo_dificultad_portugues,
                m.DOMFICPAR         AS          tipo_dificultad_parametro,
                m.DOMFICICO         AS          tipo_dificultad_icono,
                m.DOMFICCSS         AS          tipo_dificultad_css,

                n.DOMFICCOD         AS          tipo_estado_codigo,
                n.DOMFICNOI         AS          tipo_estado_ingles,
                n.DOMFICNOC         AS          tipo_estado_castellano,
                n.DOMFICNOP         AS          tipo_estado_portugues,
                n.DOMFICPAR         AS          tipo_estado_parametro,
                n.DOMFICICO         AS          tipo_estado_icono,
                n.DOMFICCSS         AS          tipo_estado_css

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
                INNER JOIN [adm].[DOMFIC] k ON a.SOLFICTPC = k.DOMFICCOD
                LEFT OUTER JOIN [CSF].[dbo].[empleados_AxisONE] l1 ON a.SOLFICDNS COLLATE SQL_Latin1_General_CP1_CI_AS = l1.CedulaEmpleado
                LEFT OUTER JOIN [CSF].[dbo].[empleados_AxisONE] l2 ON a.SOLFICDNJ COLLATE SQL_Latin1_General_CP1_CI_AS = l2.CedulaEmpleado
                LEFT OUTER JOIN [CSF].[dbo].[empleados_AxisONE] l3 ON a.SOLFICDNE COLLATE SQL_Latin1_General_CP1_CI_AS = l3.CedulaEmpleado
                LEFT OUTER JOIN [CSF].[dbo].[empleados_AxisONE] l4 ON a.SOLFICDNP COLLATE SQL_Latin1_General_CP1_CI_AS = l4.CedulaEmpleado
                INNER JOIN [adm].[DOMFIC] m ON a.SOLFICTDC = m.DOMFICCOD
                INNER JOIN [adm].[DOMFIC] n ON a.SOLFICEST = n.DOMFICCOD

                WHERE a.SOLFICCOD = ?
                
                ORDER BY a.SOLFICCOD DESC";

            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val01]);

                while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                    if(!empty($rowMSSQL00['solicitud_fecha_carga'])){
                        $solicitud_fecha_carga_1    = $rowMSSQL00['solicitud_fecha_carga'];
                        $solicitud_fecha_carga_2    = date("d/m/Y", strtotime($rowMSSQL00['solicitud_fecha_carga']));
                    } else {
                        $solicitud_fecha_carga_1    = '';
                        $solicitud_fecha_carga_2    = '';
                    }
    
                    $detalle = array(                    
                        'solicitud_codigo'                      => $rowMSSQL00['solicitud_codigo'],
                        'solicitud_periodo'                     => $rowMSSQL00['solicitud_periodo'],
                        'solicitud_motivo'                      => trim(strtoupper(strtolower($rowMSSQL00['solicitud_motivo']))),
                        'solicitud_vuelo'                       => trim(strtoupper(strtolower($rowMSSQL00['solicitud_vuelo']))),
                        'solicitud_hospedaje'                   => trim(strtoupper(strtolower($rowMSSQL00['solicitud_hospedaje']))),
                        'solicitud_traslado'                    => trim(strtoupper(strtolower($rowMSSQL00['solicitud_traslado']))),
                        'solicitud_solicitante_tarifa_vuelo'    => trim(strtoupper(strtolower($rowMSSQL00['solicitud_solicitante_tarifa_vuelo']))),
                        'solicitud_solicitante_tarifa_hospedaje'=> trim(strtoupper(strtolower($rowMSSQL00['solicitud_solicitante_tarifa_hospedaje']))),
                        'solicitud_solicitante_tarifa_traslado' => trim(strtoupper(strtolower($rowMSSQL00['solicitud_solicitante_tarifa_traslado']))),
                        'solicitud_proveedor_carga_hospedaje'   => trim(strtoupper(strtolower($rowMSSQL00['solicitud_proveedor_carga_hospedaje']))),
                        'solicitud_proveedor_carga_hospedaje'   => trim(strtoupper(strtolower($rowMSSQL00['solicitud_proveedor_carga_hospedaje']))),
                        'solicitud_proveedor_carga_traslado'    => trim(strtoupper(strtolower($rowMSSQL00['solicitud_proveedor_carga_traslado']))),
                        'solicitud_fecha_carga_1'               => $solicitud_fecha_carga_1,
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
                        'tipo_prioridad_css'                    => trim(strtolower($rowMSSQL00['tipo_prioridad_css'])),
    
                        'tipo_dificultad_codigo'                => $rowMSSQL00['tipo_dificultad_codigo'],
                        'tipo_dificultad_ingles'                => trim(strtoupper(strtolower($rowMSSQL00['tipo_dificultad_ingles']))),
                        'tipo_dificultad_castellano'            => trim(strtoupper(strtolower($rowMSSQL00['tipo_dificultad_castellano']))),
                        'tipo_dificultad_portugues'             => trim(strtoupper(strtolower($rowMSSQL00['tipo_dificultad_portugues']))),
                        'tipo_dificultad_parametro'             => $rowMSSQL00['tipo_dificultad_parametro'],
                        'tipo_dificultad_icono'                 => trim(strtolower($rowMSSQL00['tipo_dificultad_icono'])),
                        'tipo_dificultad_css'                   => trim(strtolower($rowMSSQL00['tipo_dificultad_css'])),
    
                        'tipo_estado_codigo'                    => $rowMSSQL00['tipo_estado_codigo'],
                        'tipo_estado_ingles'                    => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_ingles']))),
                        'tipo_estado_castellano'                => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_castellano']))),
                        'tipo_estado_portugues'                 => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_portugues']))),
                        'tipo_estado_parametro'                 => $rowMSSQL00['tipo_estado_parametro'],
                        'tipo_estado_icono'                     => trim(strtolower($rowMSSQL00['tipo_estado_icono'])),
                        'tipo_estado_css'                       => trim(strtolower($rowMSSQL00['tipo_estado_css']))
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
                        'solicitud_vuelo'                       => '',
                        'solicitud_hospedaje'                   => '',
                        'solicitud_traslado'                    => '',
                        'solicitud_solicitante_tarifa_vuelo'    => '',
                        'solicitud_solicitante_tarifa_hospedaje'=> '',
                        'solicitud_solicitante_tarifa_traslado' => '',
                        'solicitud_proveedor_carga_vuelo'       => '',
                        'solicitud_proveedor_carga_hospedaje'   => '',
                        'solicitud_proveedor_carga_traslado'    => '',
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
                        'tipo_prioridad_css'                    => '',
    
                        'tipo_dificultad_codigo'                => '',
                        'tipo_dificultad_ingles'                => '',
                        'tipo_dificultad_castellano'            => '',
                        'tipo_dificultad_portugues'             => '',
                        'tipo_dificultad_parametro'             => '',
                        'tipo_dificultad_icono'                 => '',
                        'tipo_dificultad_css'                   => '',
    
                        'tipo_estado_codigo'                    => '',
                        'tipo_estado_ingles'                    => '',
                        'tipo_estado_castellano'                => '',
                        'tipo_estado_portugues'                 => '',
                        'tipo_estado_parametro'                 => '',
                        'tipo_estado_icono'                     => '',
                        'tipo_estado_css'                       => ''
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
                a.SOLFICVUE         AS          solicitud_vuelo,
                a.SOLFICHOS         AS          solicitud_hospedaje,
                a.SOLFICTRA         AS          solicitud_traslado,
                a.SOLFICSTV         AS          solicitud_solicitante_tarifa_vuelo,
                a.SOLFICSTH         AS          solicitud_solicitante_tarifa_hospedaje,
                a.SOLFICSTT         AS          solicitud_solicitante_tarifa_traslado,
                a.SOLFICPCV         AS          solicitud_proveedor_carga_vuelo,
                a.SOLFICPCH         AS          solicitud_proveedor_carga_hospedaje,
                a.SOLFICPCT		    AS	        solicitud_proveedor_carga_traslado,
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
                a.SOLFICDNP         AS          solicitud_proveedor_documento,

                m.DOMFICCOD         AS          tipo_dificultad_codigo,
                m.DOMFICNOI         AS          tipo_dificultad_ingles,
                m.DOMFICNOC         AS          tipo_dificultad_castellano,
                m.DOMFICNOP         AS          tipo_dificultad_portugues,
                m.DOMFICPAR         AS          tipo_dificultad_parametro,
                m.DOMFICICO         AS          tipo_dificultad_icono,
                m.DOMFICCSS         AS          tipo_dificultad_css,

                n.DOMFICCOD         AS          tipo_estado_codigo,
                n.DOMFICNOI         AS          tipo_estado_ingles,
                n.DOMFICNOC         AS          tipo_estado_castellano,
                n.DOMFICNOP         AS          tipo_estado_portugues,
                n.DOMFICPAR         AS          tipo_estado_parametro,
                n.DOMFICICO         AS          tipo_estado_icono,
                n.DOMFICCSS         AS          tipo_estado_css

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
                INNER JOIN [adm].[DOMFIC] k ON a.SOLFICTPC = k.DOMFICCOD
                LEFT OUTER JOIN [CSF].[dbo].[empleados_AxisONE] l1 ON a.SOLFICDNS COLLATE SQL_Latin1_General_CP1_CI_AS = l1.CedulaEmpleado
                LEFT OUTER JOIN [CSF].[dbo].[empleados_AxisONE] l2 ON a.SOLFICDNJ COLLATE SQL_Latin1_General_CP1_CI_AS = l2.CedulaEmpleado
                LEFT OUTER JOIN [CSF].[dbo].[empleados_AxisONE] l3 ON a.SOLFICDNE COLLATE SQL_Latin1_General_CP1_CI_AS = l3.CedulaEmpleado
                LEFT OUTER JOIN [CSF].[dbo].[empleados_AxisONE] l4 ON a.SOLFICDNP COLLATE SQL_Latin1_General_CP1_CI_AS = l4.CedulaEmpleado
                INNER JOIN [adm].[DOMFIC] m ON a.SOLFICTDC = m.DOMFICCOD
                INNER JOIN [adm].[DOMFIC] n ON a.SOLFICEST = n.DOMFICCOD

                WHERE a.SOLFICDNS = ?

                ORDER BY a.SOLFICCOD DESC";

            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val01]);

                while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                    if(!empty($rowMSSQL00['solicitud_fecha_carga'])){
                        $solicitud_fecha_carga_1    = $rowMSSQL00['solicitud_fecha_carga'];
                        $solicitud_fecha_carga_2    = date("d/m/Y", strtotime($rowMSSQL00['solicitud_fecha_carga']));
                    } else {
                        $solicitud_fecha_carga_1    = '';
                        $solicitud_fecha_carga_2    = '';
                    }
    
                    $detalle = array(                    
                        'solicitud_codigo'                      => $rowMSSQL00['solicitud_codigo'],
                        'solicitud_periodo'                     => $rowMSSQL00['solicitud_periodo'],
                        'solicitud_motivo'                      => trim(strtoupper(strtolower($rowMSSQL00['solicitud_motivo']))),
                        'solicitud_vuelo'                       => trim(strtoupper(strtolower($rowMSSQL00['solicitud_vuelo']))),
                        'solicitud_hospedaje'                   => trim(strtoupper(strtolower($rowMSSQL00['solicitud_hospedaje']))),
                        'solicitud_traslado'                    => trim(strtoupper(strtolower($rowMSSQL00['solicitud_traslado']))),
                        'solicitud_solicitante_tarifa_vuelo'    => trim(strtoupper(strtolower($rowMSSQL00['solicitud_solicitante_tarifa_vuelo']))),
                        'solicitud_solicitante_tarifa_hospedaje'=> trim(strtoupper(strtolower($rowMSSQL00['solicitud_solicitante_tarifa_hospedaje']))),
                        'solicitud_solicitante_tarifa_traslado' => trim(strtoupper(strtolower($rowMSSQL00['solicitud_solicitante_tarifa_traslado']))),
                        'solicitud_proveedor_carga_hospedaje'   => trim(strtoupper(strtolower($rowMSSQL00['solicitud_proveedor_carga_hospedaje']))),
                        'solicitud_proveedor_carga_hospedaje'   => trim(strtoupper(strtolower($rowMSSQL00['solicitud_proveedor_carga_hospedaje']))),
                        'solicitud_proveedor_carga_traslado'    => trim(strtoupper(strtolower($rowMSSQL00['solicitud_proveedor_carga_traslado']))),
                        'solicitud_fecha_carga_1'               => $solicitud_fecha_carga_1,
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
                        'tipo_prioridad_css'                    => trim(strtolower($rowMSSQL00['tipo_prioridad_css'])),
    
                        'tipo_dificultad_codigo'                => $rowMSSQL00['tipo_dificultad_codigo'],
                        'tipo_dificultad_ingles'                => trim(strtoupper(strtolower($rowMSSQL00['tipo_dificultad_ingles']))),
                        'tipo_dificultad_castellano'            => trim(strtoupper(strtolower($rowMSSQL00['tipo_dificultad_castellano']))),
                        'tipo_dificultad_portugues'             => trim(strtoupper(strtolower($rowMSSQL00['tipo_dificultad_portugues']))),
                        'tipo_dificultad_parametro'             => $rowMSSQL00['tipo_dificultad_parametro'],
                        'tipo_dificultad_icono'                 => trim(strtolower($rowMSSQL00['tipo_dificultad_icono'])),
                        'tipo_dificultad_css'                   => trim(strtolower($rowMSSQL00['tipo_dificultad_css'])),
    
                        'tipo_estado_codigo'                    => $rowMSSQL00['tipo_estado_codigo'],
                        'tipo_estado_ingles'                    => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_ingles']))),
                        'tipo_estado_castellano'                => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_castellano']))),
                        'tipo_estado_portugues'                 => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_portugues']))),
                        'tipo_estado_parametro'                 => $rowMSSQL00['tipo_estado_parametro'],
                        'tipo_estado_icono'                     => trim(strtolower($rowMSSQL00['tipo_estado_icono'])),
                        'tipo_estado_css'                       => trim(strtolower($rowMSSQL00['tipo_estado_css']))
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
                        'solicitud_vuelo'                       => '',
                        'solicitud_hospedaje'                   => '',
                        'solicitud_traslado'                    => '',
                        'solicitud_solicitante_tarifa_vuelo'    => '',
                        'solicitud_solicitante_tarifa_hospedaje'=> '',
                        'solicitud_solicitante_tarifa_traslado' => '',
                        'solicitud_proveedor_carga_vuelo'       => '',
                        'solicitud_proveedor_carga_hospedaje'   => '',
                        'solicitud_proveedor_carga_traslado'    => '',
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
                        'tipo_prioridad_css'                    => '',
    
                        'tipo_dificultad_codigo'                => '',
                        'tipo_dificultad_ingles'                => '',
                        'tipo_dificultad_castellano'            => '',
                        'tipo_dificultad_portugues'             => '',
                        'tipo_dificultad_parametro'             => '',
                        'tipo_dificultad_icono'                 => '',
                        'tipo_dificultad_css'                   => '',
    
                        'tipo_estado_codigo'                    => '',
                        'tipo_estado_ingles'                    => '',
                        'tipo_estado_castellano'                => '',
                        'tipo_estado_portugues'                 => '',
                        'tipo_estado_parametro'                 => '',
                        'tipo_estado_icono'                     => '',
                        'tipo_estado_css'                       => ''
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

    $app->get('/v2/400/solicitud/solicitante/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val01  = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
                a.SOLFICCOD         AS          solicitud_codigo,
                a.SOLFICPER         AS          solicitud_periodo,
                a.SOLFICMOT         AS          solicitud_motivo,
                a.SOLFICVUE         AS          solicitud_vuelo,
                a.SOLFICHOS         AS          solicitud_hospedaje,
                a.SOLFICTRA         AS          solicitud_traslado,
                a.SOLFICSTV         AS          solicitud_solicitante_tarifa_vuelo,
                a.SOLFICSTH         AS          solicitud_solicitante_tarifa_hospedaje,
                a.SOLFICSTT         AS          solicitud_solicitante_tarifa_traslado,
                a.SOLFICPCV         AS          solicitud_proveedor_carga_vuelo,
                a.SOLFICPCH         AS          solicitud_proveedor_carga_hospedaje,
                a.SOLFICPCT		    AS	        solicitud_proveedor_carga_traslado,
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
                a.SOLFICDNP         AS          solicitud_proveedor_documento,

                m.DOMFICCOD         AS          tipo_dificultad_codigo,
                m.DOMFICNOI         AS          tipo_dificultad_ingles,
                m.DOMFICNOC         AS          tipo_dificultad_castellano,
                m.DOMFICNOP         AS          tipo_dificultad_portugues,
                m.DOMFICPAR         AS          tipo_dificultad_parametro,
                m.DOMFICICO         AS          tipo_dificultad_icono,
                m.DOMFICCSS         AS          tipo_dificultad_css,

                n.DOMFICCOD         AS          tipo_estado_codigo,
                n.DOMFICNOI         AS          tipo_estado_ingles,
                n.DOMFICNOC         AS          tipo_estado_castellano,
                n.DOMFICNOP         AS          tipo_estado_portugues,
                n.DOMFICPAR         AS          tipo_estado_parametro,
                n.DOMFICICO         AS          tipo_estado_icono,
                n.DOMFICCSS         AS          tipo_estado_css

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
                INNER JOIN [adm].[DOMFIC] k ON a.SOLFICTPC = k.DOMFICCOD
                LEFT OUTER JOIN [CSF].[dbo].[empleados_AxisONE] l1 ON a.SOLFICDNS COLLATE SQL_Latin1_General_CP1_CI_AS = l1.CedulaEmpleado
                LEFT OUTER JOIN [CSF].[dbo].[empleados_AxisONE] l2 ON a.SOLFICDNJ COLLATE SQL_Latin1_General_CP1_CI_AS = l2.CedulaEmpleado
                LEFT OUTER JOIN [CSF].[dbo].[empleados_AxisONE] l3 ON a.SOLFICDNE COLLATE SQL_Latin1_General_CP1_CI_AS = l3.CedulaEmpleado
                LEFT OUTER JOIN [CSF].[dbo].[empleados_AxisONE] l4 ON a.SOLFICDNP COLLATE SQL_Latin1_General_CP1_CI_AS = l4.CedulaEmpleado
                INNER JOIN [adm].[DOMFIC] m ON a.SOLFICTDC = m.DOMFICCOD
                INNER JOIN [adm].[DOMFIC] n ON a.SOLFICEST = n.DOMFICCOD

                WHERE a.SOLFICDNS = ?

                ORDER BY a.SOLFICCOD DESC";

            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val01]);

                while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                    if(!empty($rowMSSQL00['solicitud_fecha_carga'])){
                        $solicitud_fecha_carga_1    = $rowMSSQL00['solicitud_fecha_carga'];
                        $solicitud_fecha_carga_2    = date("d/m/Y", strtotime($rowMSSQL00['solicitud_fecha_carga']));
                    } else {
                        $solicitud_fecha_carga_1    = '';
                        $solicitud_fecha_carga_2    = '';
                    }
    
                    $detalle = array(                    
                        'solicitud_codigo'                      => $rowMSSQL00['solicitud_codigo'],
                        'solicitud_periodo'                     => $rowMSSQL00['solicitud_periodo'],
                        'solicitud_motivo'                      => trim(strtoupper(strtolower($rowMSSQL00['solicitud_motivo']))),
                        'solicitud_vuelo'                       => trim(strtoupper(strtolower($rowMSSQL00['solicitud_vuelo']))),
                        'solicitud_hospedaje'                   => trim(strtoupper(strtolower($rowMSSQL00['solicitud_hospedaje']))),
                        'solicitud_traslado'                    => trim(strtoupper(strtolower($rowMSSQL00['solicitud_traslado']))),
                        'solicitud_solicitante_tarifa_vuelo'    => trim(strtoupper(strtolower($rowMSSQL00['solicitud_solicitante_tarifa_vuelo']))),
                        'solicitud_solicitante_tarifa_hospedaje'=> trim(strtoupper(strtolower($rowMSSQL00['solicitud_solicitante_tarifa_hospedaje']))),
                        'solicitud_solicitante_tarifa_traslado' => trim(strtoupper(strtolower($rowMSSQL00['solicitud_solicitante_tarifa_traslado']))),
                        'solicitud_proveedor_carga_hospedaje'   => trim(strtoupper(strtolower($rowMSSQL00['solicitud_proveedor_carga_hospedaje']))),
                        'solicitud_proveedor_carga_hospedaje'   => trim(strtoupper(strtolower($rowMSSQL00['solicitud_proveedor_carga_hospedaje']))),
                        'solicitud_proveedor_carga_traslado'    => trim(strtoupper(strtolower($rowMSSQL00['solicitud_proveedor_carga_traslado']))),
                        'solicitud_fecha_carga_1'               => $solicitud_fecha_carga_1,
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
                        'tipo_prioridad_css'                    => trim(strtolower($rowMSSQL00['tipo_prioridad_css'])),
    
                        'tipo_dificultad_codigo'                => $rowMSSQL00['tipo_dificultad_codigo'],
                        'tipo_dificultad_ingles'                => trim(strtoupper(strtolower($rowMSSQL00['tipo_dificultad_ingles']))),
                        'tipo_dificultad_castellano'            => trim(strtoupper(strtolower($rowMSSQL00['tipo_dificultad_castellano']))),
                        'tipo_dificultad_portugues'             => trim(strtoupper(strtolower($rowMSSQL00['tipo_dificultad_portugues']))),
                        'tipo_dificultad_parametro'             => $rowMSSQL00['tipo_dificultad_parametro'],
                        'tipo_dificultad_icono'                 => trim(strtolower($rowMSSQL00['tipo_dificultad_icono'])),
                        'tipo_dificultad_css'                   => trim(strtolower($rowMSSQL00['tipo_dificultad_css'])),
    
                        'tipo_estado_codigo'                    => $rowMSSQL00['tipo_estado_codigo'],
                        'tipo_estado_ingles'                    => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_ingles']))),
                        'tipo_estado_castellano'                => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_castellano']))),
                        'tipo_estado_portugues'                 => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_portugues']))),
                        'tipo_estado_parametro'                 => $rowMSSQL00['tipo_estado_parametro'],
                        'tipo_estado_icono'                     => trim(strtolower($rowMSSQL00['tipo_estado_icono'])),
                        'tipo_estado_css'                       => trim(strtolower($rowMSSQL00['tipo_estado_css']))
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
                        'solicitud_vuelo'                       => '',
                        'solicitud_hospedaje'                   => '',
                        'solicitud_traslado'                    => '',
                        'solicitud_solicitante_tarifa_vuelo'    => '',
                        'solicitud_solicitante_tarifa_hospedaje'=> '',
                        'solicitud_solicitante_tarifa_traslado' => '',
                        'solicitud_proveedor_carga_vuelo'       => '',
                        'solicitud_proveedor_carga_hospedaje'   => '',
                        'solicitud_proveedor_carga_traslado'    => '',
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
                        'tipo_prioridad_css'                    => '',
    
                        'tipo_dificultad_codigo'                => '',
                        'tipo_dificultad_ingles'                => '',
                        'tipo_dificultad_castellano'            => '',
                        'tipo_dificultad_portugues'             => '',
                        'tipo_dificultad_parametro'             => '',
                        'tipo_dificultad_icono'                 => '',
                        'tipo_dificultad_css'                   => '',
    
                        'tipo_estado_codigo'                    => '',
                        'tipo_estado_ingles'                    => '',
                        'tipo_estado_castellano'                => '',
                        'tipo_estado_portugues'                 => '',
                        'tipo_estado_parametro'                 => '',
                        'tipo_estado_icono'                     => '',
                        'tipo_estado_css'                       => ''
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

    $app->get('/v2/400/solicitud/jefatura/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val01  = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
                a.SOLFICCOD         AS          solicitud_codigo,
                a.SOLFICPER         AS          solicitud_periodo,
                a.SOLFICMOT         AS          solicitud_motivo,
                a.SOLFICVUE         AS          solicitud_vuelo,
                a.SOLFICHOS         AS          solicitud_hospedaje,
                a.SOLFICTRA         AS          solicitud_traslado,
                a.SOLFICSTV         AS          solicitud_solicitante_tarifa_vuelo,
                a.SOLFICSTH         AS          solicitud_solicitante_tarifa_hospedaje,
                a.SOLFICSTT         AS          solicitud_solicitante_tarifa_traslado,
                a.SOLFICPCV         AS          solicitud_proveedor_carga_vuelo,
                a.SOLFICPCH         AS          solicitud_proveedor_carga_hospedaje,
                a.SOLFICPCT		    AS	        solicitud_proveedor_carga_traslado,
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
                a.SOLFICDNP         AS          solicitud_proveedor_documento,

                m.DOMFICCOD         AS          tipo_dificultad_codigo,
                m.DOMFICNOI         AS          tipo_dificultad_ingles,
                m.DOMFICNOC         AS          tipo_dificultad_castellano,
                m.DOMFICNOP         AS          tipo_dificultad_portugues,
                m.DOMFICPAR         AS          tipo_dificultad_parametro,
                m.DOMFICICO         AS          tipo_dificultad_icono,
                m.DOMFICCSS         AS          tipo_dificultad_css,

                n.DOMFICCOD         AS          tipo_estado_codigo,
                n.DOMFICNOI         AS          tipo_estado_ingles,
                n.DOMFICNOC         AS          tipo_estado_castellano,
                n.DOMFICNOP         AS          tipo_estado_portugues,
                n.DOMFICPAR         AS          tipo_estado_parametro,
                n.DOMFICICO         AS          tipo_estado_icono,
                n.DOMFICCSS         AS          tipo_estado_css

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
                INNER JOIN [adm].[DOMFIC] k ON a.SOLFICTPC = k.DOMFICCOD
                LEFT OUTER JOIN [CSF].[dbo].[empleados_AxisONE] l1 ON a.SOLFICDNS COLLATE SQL_Latin1_General_CP1_CI_AS = l1.CedulaEmpleado
                LEFT OUTER JOIN [CSF].[dbo].[empleados_AxisONE] l2 ON a.SOLFICDNJ COLLATE SQL_Latin1_General_CP1_CI_AS = l2.CedulaEmpleado
                LEFT OUTER JOIN [CSF].[dbo].[empleados_AxisONE] l3 ON a.SOLFICDNE COLLATE SQL_Latin1_General_CP1_CI_AS = l3.CedulaEmpleado
                LEFT OUTER JOIN [CSF].[dbo].[empleados_AxisONE] l4 ON a.SOLFICDNP COLLATE SQL_Latin1_General_CP1_CI_AS = l4.CedulaEmpleado
                INNER JOIN [adm].[DOMFIC] m ON a.SOLFICTDC = m.DOMFICCOD
                INNER JOIN [adm].[DOMFIC] n ON a.SOLFICEST = n.DOMFICCOD

                WHERE a.SOLFICDNJ = ?

                ORDER BY a.SOLFICCOD DESC";

            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val01]);

                while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                    if(!empty($rowMSSQL00['solicitud_fecha_carga'])){
                        $solicitud_fecha_carga_1    = $rowMSSQL00['solicitud_fecha_carga'];
                        $solicitud_fecha_carga_2    = date("d/m/Y", strtotime($rowMSSQL00['solicitud_fecha_carga']));
                    } else {
                        $solicitud_fecha_carga_1    = '';
                        $solicitud_fecha_carga_2    = '';
                    }
    
                    $detalle = array(                    
                        'solicitud_codigo'                      => $rowMSSQL00['solicitud_codigo'],
                        'solicitud_periodo'                     => $rowMSSQL00['solicitud_periodo'],
                        'solicitud_motivo'                      => trim(strtoupper(strtolower($rowMSSQL00['solicitud_motivo']))),
                        'solicitud_vuelo'                       => trim(strtoupper(strtolower($rowMSSQL00['solicitud_vuelo']))),
                        'solicitud_hospedaje'                   => trim(strtoupper(strtolower($rowMSSQL00['solicitud_hospedaje']))),
                        'solicitud_traslado'                    => trim(strtoupper(strtolower($rowMSSQL00['solicitud_traslado']))),
                        'solicitud_solicitante_tarifa_vuelo'    => trim(strtoupper(strtolower($rowMSSQL00['solicitud_solicitante_tarifa_vuelo']))),
                        'solicitud_solicitante_tarifa_hospedaje'=> trim(strtoupper(strtolower($rowMSSQL00['solicitud_solicitante_tarifa_hospedaje']))),
                        'solicitud_solicitante_tarifa_traslado' => trim(strtoupper(strtolower($rowMSSQL00['solicitud_solicitante_tarifa_traslado']))),
                        'solicitud_proveedor_carga_hospedaje'   => trim(strtoupper(strtolower($rowMSSQL00['solicitud_proveedor_carga_hospedaje']))),
                        'solicitud_proveedor_carga_hospedaje'   => trim(strtoupper(strtolower($rowMSSQL00['solicitud_proveedor_carga_hospedaje']))),
                        'solicitud_proveedor_carga_traslado'    => trim(strtoupper(strtolower($rowMSSQL00['solicitud_proveedor_carga_traslado']))),
                        'solicitud_fecha_carga_1'               => $solicitud_fecha_carga_1,
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
                        'tipo_prioridad_css'                    => trim(strtolower($rowMSSQL00['tipo_prioridad_css'])),
    
                        'tipo_dificultad_codigo'                => $rowMSSQL00['tipo_dificultad_codigo'],
                        'tipo_dificultad_ingles'                => trim(strtoupper(strtolower($rowMSSQL00['tipo_dificultad_ingles']))),
                        'tipo_dificultad_castellano'            => trim(strtoupper(strtolower($rowMSSQL00['tipo_dificultad_castellano']))),
                        'tipo_dificultad_portugues'             => trim(strtoupper(strtolower($rowMSSQL00['tipo_dificultad_portugues']))),
                        'tipo_dificultad_parametro'             => $rowMSSQL00['tipo_dificultad_parametro'],
                        'tipo_dificultad_icono'                 => trim(strtolower($rowMSSQL00['tipo_dificultad_icono'])),
                        'tipo_dificultad_css'                   => trim(strtolower($rowMSSQL00['tipo_dificultad_css'])),
    
                        'tipo_estado_codigo'                    => $rowMSSQL00['tipo_estado_codigo'],
                        'tipo_estado_ingles'                    => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_ingles']))),
                        'tipo_estado_castellano'                => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_castellano']))),
                        'tipo_estado_portugues'                 => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_portugues']))),
                        'tipo_estado_parametro'                 => $rowMSSQL00['tipo_estado_parametro'],
                        'tipo_estado_icono'                     => trim(strtolower($rowMSSQL00['tipo_estado_icono'])),
                        'tipo_estado_css'                       => trim(strtolower($rowMSSQL00['tipo_estado_css']))
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
                        'solicitud_vuelo'                       => '',
                        'solicitud_hospedaje'                   => '',
                        'solicitud_traslado'                    => '',
                        'solicitud_solicitante_tarifa_vuelo'    => '',
                        'solicitud_solicitante_tarifa_hospedaje'=> '',
                        'solicitud_solicitante_tarifa_traslado' => '',
                        'solicitud_proveedor_carga_vuelo'       => '',
                        'solicitud_proveedor_carga_hospedaje'   => '',
                        'solicitud_proveedor_carga_traslado'    => '',
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
                        'tipo_prioridad_css'                    => '',
    
                        'tipo_dificultad_codigo'                => '',
                        'tipo_dificultad_ingles'                => '',
                        'tipo_dificultad_castellano'            => '',
                        'tipo_dificultad_portugues'             => '',
                        'tipo_dificultad_parametro'             => '',
                        'tipo_dificultad_icono'                 => '',
                        'tipo_dificultad_css'                   => '',
    
                        'tipo_estado_codigo'                    => '',
                        'tipo_estado_ingles'                    => '',
                        'tipo_estado_castellano'                => '',
                        'tipo_estado_portugues'                 => '',
                        'tipo_estado_parametro'                 => '',
                        'tipo_estado_icono'                     => '',
                        'tipo_estado_css'                       => ''
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

    $app->get('/v2/400/solicitud/ejecutivo/asignado/cantidad', function($request) {//20201105
        require __DIR__.'/../src/connect.php';

        $sql00  = "SELECT 
            b.CedulaEmpleado AS solicitud_ejecutivo_documento,
            b.NombreEmpleado   AS solicitud_ejecutivo_nombre,
            COUNT(*) AS TOTAL_ASIGNADOS
            
            FROM [via].[SOLFIC] a
            LEFT OUTER JOIN [CSF].[dbo].[empleados_AxisONE] b ON a.SOLFICDNE COLLATE SQL_Latin1_General_CP1_CI_AS = b.CedulaEmpleado  

            WHERE SOLFICDNE IS NOT NULL

            GROUP BY a.SOLFICDNE, b.CedulaEmpleado, b.NombreEmpleado";

        try {
            $connMSSQL  = getConnectionMSSQLv2();
            $stmtMSSQL00= $connMSSQL->prepare($sql00);
            $stmtMSSQL00->execute();

            while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                $detalle = array(                    
                    'solicitud_ejecutivo_documento'                 => trim(strtoupper(strtolower($rowMSSQL00['solicitud_ejecutivo_documento']))),
                    'solicitud_ejecutivo_nombre'                    => trim(strtoupper(strtolower($rowMSSQL00['solicitud_ejecutivo_nombre']))),
                    'TOTAL_ASIGNADOS'                               => $rowMSSQL00['TOTAL_ASIGNADOS']
                );

                $result[]   = $detalle;
            }

            if (isset($result)){
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } else {
                $detalle    = array(
                    'solicitud_ejecutivo_documento'                 => '',
                    'solicitud_ejecutivo_nombre'                    => '',
                    'TOTAL_ASIGNADOS'                               => ''
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

    $app->get('/v2/400/solicitud/ejecutivo/asignado/listado/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val01  = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
                a.SOLFICCOD         AS          solicitud_codigo,
                a.SOLFICPER         AS          solicitud_periodo,
                a.SOLFICMOT         AS          solicitud_motivo,
                a.SOLFICVUE         AS          solicitud_vuelo,
                a.SOLFICHOS         AS          solicitud_hospedaje,
                a.SOLFICTRA         AS          solicitud_traslado,
                a.SOLFICSTV         AS          solicitud_solicitante_tarifa_vuelo,
                a.SOLFICSTH         AS          solicitud_solicitante_tarifa_hospedaje,
                a.SOLFICSTT         AS          solicitud_solicitante_tarifa_traslado,
                a.SOLFICPCV         AS          solicitud_proveedor_carga_vuelo,
                a.SOLFICPCH         AS          solicitud_proveedor_carga_hospedaje,
                a.SOLFICPCT		    AS	        solicitud_proveedor_carga_traslado,
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
                a.SOLFICDNP         AS          solicitud_proveedor_documento,

                m.DOMFICCOD         AS          tipo_dificultad_codigo,
                m.DOMFICNOI         AS          tipo_dificultad_ingles,
                m.DOMFICNOC         AS          tipo_dificultad_castellano,
                m.DOMFICNOP         AS          tipo_dificultad_portugues,
                m.DOMFICPAR         AS          tipo_dificultad_parametro,
                m.DOMFICICO         AS          tipo_dificultad_icono,
                m.DOMFICCSS         AS          tipo_dificultad_css,

                n.DOMFICCOD         AS          tipo_estado_codigo,
                n.DOMFICNOI         AS          tipo_estado_ingles,
                n.DOMFICNOC         AS          tipo_estado_castellano,
                n.DOMFICNOP         AS          tipo_estado_portugues,
                n.DOMFICPAR         AS          tipo_estado_parametro,
                n.DOMFICICO         AS          tipo_estado_icono,
                n.DOMFICCSS         AS          tipo_estado_css

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
                INNER JOIN [adm].[DOMFIC] k ON a.SOLFICTPC = k.DOMFICCOD
                LEFT OUTER JOIN [CSF].[dbo].[empleados_AxisONE] l1 ON a.SOLFICDNS COLLATE SQL_Latin1_General_CP1_CI_AS = l1.CedulaEmpleado
                LEFT OUTER JOIN [CSF].[dbo].[empleados_AxisONE] l2 ON a.SOLFICDNJ COLLATE SQL_Latin1_General_CP1_CI_AS = l2.CedulaEmpleado
                LEFT OUTER JOIN [CSF].[dbo].[empleados_AxisONE] l3 ON a.SOLFICDNE COLLATE SQL_Latin1_General_CP1_CI_AS = l3.CedulaEmpleado
                LEFT OUTER JOIN [CSF].[dbo].[empleados_AxisONE] l4 ON a.SOLFICDNP COLLATE SQL_Latin1_General_CP1_CI_AS = l4.CedulaEmpleado
                INNER JOIN [adm].[DOMFIC] m ON a.SOLFICTDC = m.DOMFICCOD
                INNER JOIN [adm].[DOMFIC] n ON a.SOLFICEST = n.DOMFICCOD

                WHERE a.SOLFICDNE = ?

                ORDER BY a.SOLFICCOD DESC";

            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val01]);

                while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                    if(!empty($rowMSSQL00['solicitud_fecha_carga'])){
                        $solicitud_fecha_carga_1    = $rowMSSQL00['solicitud_fecha_carga'];
                        $solicitud_fecha_carga_2    = date("d/m/Y", strtotime($rowMSSQL00['solicitud_fecha_carga']));
                    } else {
                        $solicitud_fecha_carga_1    = '';
                        $solicitud_fecha_carga_2    = '';
                    }
    
                    $detalle = array(                    
                        'solicitud_codigo'                      => $rowMSSQL00['solicitud_codigo'],
                        'solicitud_periodo'                     => $rowMSSQL00['solicitud_periodo'],
                        'solicitud_motivo'                      => trim(strtoupper(strtolower($rowMSSQL00['solicitud_motivo']))),
                        'solicitud_vuelo'                       => trim(strtoupper(strtolower($rowMSSQL00['solicitud_vuelo']))),
                        'solicitud_hospedaje'                   => trim(strtoupper(strtolower($rowMSSQL00['solicitud_hospedaje']))),
                        'solicitud_traslado'                    => trim(strtoupper(strtolower($rowMSSQL00['solicitud_traslado']))),
                        'solicitud_solicitante_tarifa_vuelo'    => trim(strtoupper(strtolower($rowMSSQL00['solicitud_solicitante_tarifa_vuelo']))),
                        'solicitud_solicitante_tarifa_hospedaje'=> trim(strtoupper(strtolower($rowMSSQL00['solicitud_solicitante_tarifa_hospedaje']))),
                        'solicitud_solicitante_tarifa_traslado' => trim(strtoupper(strtolower($rowMSSQL00['solicitud_solicitante_tarifa_traslado']))),
                        'solicitud_proveedor_carga_hospedaje'   => trim(strtoupper(strtolower($rowMSSQL00['solicitud_proveedor_carga_hospedaje']))),
                        'solicitud_proveedor_carga_hospedaje'   => trim(strtoupper(strtolower($rowMSSQL00['solicitud_proveedor_carga_hospedaje']))),
                        'solicitud_proveedor_carga_traslado'    => trim(strtoupper(strtolower($rowMSSQL00['solicitud_proveedor_carga_traslado']))),
                        'solicitud_fecha_carga_1'               => $solicitud_fecha_carga_1,
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
                        'tipo_prioridad_css'                    => trim(strtolower($rowMSSQL00['tipo_prioridad_css'])),
    
                        'tipo_dificultad_codigo'                => $rowMSSQL00['tipo_dificultad_codigo'],
                        'tipo_dificultad_ingles'                => trim(strtoupper(strtolower($rowMSSQL00['tipo_dificultad_ingles']))),
                        'tipo_dificultad_castellano'            => trim(strtoupper(strtolower($rowMSSQL00['tipo_dificultad_castellano']))),
                        'tipo_dificultad_portugues'             => trim(strtoupper(strtolower($rowMSSQL00['tipo_dificultad_portugues']))),
                        'tipo_dificultad_parametro'             => $rowMSSQL00['tipo_dificultad_parametro'],
                        'tipo_dificultad_icono'                 => trim(strtolower($rowMSSQL00['tipo_dificultad_icono'])),
                        'tipo_dificultad_css'                   => trim(strtolower($rowMSSQL00['tipo_dificultad_css'])),
    
                        'tipo_estado_codigo'                    => $rowMSSQL00['tipo_estado_codigo'],
                        'tipo_estado_ingles'                    => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_ingles']))),
                        'tipo_estado_castellano'                => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_castellano']))),
                        'tipo_estado_portugues'                 => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_portugues']))),
                        'tipo_estado_parametro'                 => $rowMSSQL00['tipo_estado_parametro'],
                        'tipo_estado_icono'                     => trim(strtolower($rowMSSQL00['tipo_estado_icono'])),
                        'tipo_estado_css'                       => trim(strtolower($rowMSSQL00['tipo_estado_css']))
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
                        'solicitud_vuelo'                       => '',
                        'solicitud_hospedaje'                   => '',
                        'solicitud_traslado'                    => '',
                        'solicitud_solicitante_tarifa_vuelo'    => '',
                        'solicitud_solicitante_tarifa_hospedaje'=> '',
                        'solicitud_solicitante_tarifa_traslado' => '',
                        'solicitud_proveedor_carga_vuelo'       => '',
                        'solicitud_proveedor_carga_hospedaje'   => '',
                        'solicitud_proveedor_carga_traslado'    => '',
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
                        'tipo_prioridad_css'                    => '',
    
                        'tipo_dificultad_codigo'                => '',
                        'tipo_dificultad_ingles'                => '',
                        'tipo_dificultad_castellano'            => '',
                        'tipo_dificultad_portugues'             => '',
                        'tipo_dificultad_parametro'             => '',
                        'tipo_dificultad_icono'                 => '',
                        'tipo_dificultad_css'                   => '',
    
                        'tipo_estado_codigo'                    => '',
                        'tipo_estado_ingles'                    => '',
                        'tipo_estado_castellano'                => '',
                        'tipo_estado_portugues'                 => '',
                        'tipo_estado_parametro'                 => '',
                        'tipo_estado_icono'                     => '',
                        'tipo_estado_css'                       => ''
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
    
    $app->get('/v2/400/solicitud/ejecutivo/sinasignar/cantidad', function($request) {//20201105
        require __DIR__.'/../src/connect.php';

        $sql00  = "SELECT
            '1'         AS solicitud_tipo,
            COUNT(*)    AS solicitud_cantidad
            FROM [via].[SOLFIC] a
            
            WHERE a.SOLFICDNE IS NULL";

        try {
            $connMSSQL  = getConnectionMSSQLv2();
            $stmtMSSQL00= $connMSSQL->prepare($sql00);
            $stmtMSSQL00->execute();

            while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                $detalle = array(                    
                    'solicitud_tipo'                        => $rowMSSQL00['solicitud_tipo'],
                    'solicitud_cantidad'                    => $rowMSSQL00['solicitud_cantidad']
                );

                $result[]   = $detalle;
            }

            if (isset($result)){
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } else {
                $detalle    = array(
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

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v2/400/solicitud/ejecutivo/sinasignar/detalle', function($request) {
        require __DIR__.'/../src/connect.php';

        $sql00  = "SELECT
            a.SOLFICCOD         AS          solicitud_codigo,
            a.SOLFICPER         AS          solicitud_periodo,
            a.SOLFICMOT         AS          solicitud_motivo,
            a.SOLFICVUE         AS          solicitud_vuelo,
            a.SOLFICHOS         AS          solicitud_hospedaje,
            a.SOLFICTRA         AS          solicitud_traslado,
            a.SOLFICSTV         AS          solicitud_solicitante_tarifa_vuelo,
            a.SOLFICSTH         AS          solicitud_solicitante_tarifa_hospedaje,
            a.SOLFICSTT         AS          solicitud_solicitante_tarifa_traslado,
            a.SOLFICPCV         AS          solicitud_proveedor_carga_vuelo,
            a.SOLFICPCH         AS          solicitud_proveedor_carga_hospedaje,
            a.SOLFICPCT		    AS	        solicitud_proveedor_carga_traslado,
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
            a.SOLFICDNP         AS          solicitud_proveedor_documento,

            m.DOMFICCOD         AS          tipo_dificultad_codigo,
            m.DOMFICNOI         AS          tipo_dificultad_ingles,
            m.DOMFICNOC         AS          tipo_dificultad_castellano,
            m.DOMFICNOP         AS          tipo_dificultad_portugues,
            m.DOMFICPAR         AS          tipo_dificultad_parametro,
            m.DOMFICICO         AS          tipo_dificultad_icono,
            m.DOMFICCSS         AS          tipo_dificultad_css,

            n.DOMFICCOD         AS          tipo_estado_codigo,
            n.DOMFICNOI         AS          tipo_estado_ingles,
            n.DOMFICNOC         AS          tipo_estado_castellano,
            n.DOMFICNOP         AS          tipo_estado_portugues,
            n.DOMFICPAR         AS          tipo_estado_parametro,
            n.DOMFICICO         AS          tipo_estado_icono,
            n.DOMFICCSS         AS          tipo_estado_css

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
            INNER JOIN [adm].[DOMFIC] k ON a.SOLFICTPC = k.DOMFICCOD
            LEFT OUTER JOIN [CSF].[dbo].[empleados_AxisONE] l1 ON a.SOLFICDNS COLLATE SQL_Latin1_General_CP1_CI_AS = l1.CedulaEmpleado
            LEFT OUTER JOIN [CSF].[dbo].[empleados_AxisONE] l2 ON a.SOLFICDNJ COLLATE SQL_Latin1_General_CP1_CI_AS = l2.CedulaEmpleado
            LEFT OUTER JOIN [CSF].[dbo].[empleados_AxisONE] l3 ON a.SOLFICDNE COLLATE SQL_Latin1_General_CP1_CI_AS = l3.CedulaEmpleado
            LEFT OUTER JOIN [CSF].[dbo].[empleados_AxisONE] l4 ON a.SOLFICDNP COLLATE SQL_Latin1_General_CP1_CI_AS = l4.CedulaEmpleado
            INNER JOIN [adm].[DOMFIC] m ON a.SOLFICTDC = m.DOMFICCOD
            INNER JOIN [adm].[DOMFIC] n ON a.SOLFICEST = n.DOMFICCOD

            WHERE a.SOLFICDNE IS NULL

            ORDER BY a.SOLFICCOD DESC";

        try {
            $connMSSQL  = getConnectionMSSQLv2();
            $stmtMSSQL00= $connMSSQL->prepare($sql00);
            $stmtMSSQL00->execute();

            while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                if(!empty($rowMSSQL00['solicitud_fecha_carga'])){
                    $solicitud_fecha_carga_1    = $rowMSSQL00['solicitud_fecha_carga'];
                    $solicitud_fecha_carga_2    = date("d/m/Y", strtotime($rowMSSQL00['solicitud_fecha_carga']));
                } else {
                    $solicitud_fecha_carga_1    = '';
                    $solicitud_fecha_carga_2    = '';
                }

                $detalle = array(                    
                    'solicitud_codigo'                      => $rowMSSQL00['solicitud_codigo'],
                    'solicitud_periodo'                     => $rowMSSQL00['solicitud_periodo'],
                    'solicitud_motivo'                      => trim(strtoupper(strtolower($rowMSSQL00['solicitud_motivo']))),
                    'solicitud_vuelo'                       => trim(strtoupper(strtolower($rowMSSQL00['solicitud_vuelo']))),
                    'solicitud_hospedaje'                   => trim(strtoupper(strtolower($rowMSSQL00['solicitud_hospedaje']))),
                    'solicitud_traslado'                    => trim(strtoupper(strtolower($rowMSSQL00['solicitud_traslado']))),
                    'solicitud_solicitante_tarifa_vuelo'    => trim(strtoupper(strtolower($rowMSSQL00['solicitud_solicitante_tarifa_vuelo']))),
                    'solicitud_solicitante_tarifa_hospedaje'=> trim(strtoupper(strtolower($rowMSSQL00['solicitud_solicitante_tarifa_hospedaje']))),
                    'solicitud_solicitante_tarifa_traslado' => trim(strtoupper(strtolower($rowMSSQL00['solicitud_solicitante_tarifa_traslado']))),
                    'solicitud_proveedor_carga_hospedaje'   => trim(strtoupper(strtolower($rowMSSQL00['solicitud_proveedor_carga_hospedaje']))),
                    'solicitud_proveedor_carga_hospedaje'   => trim(strtoupper(strtolower($rowMSSQL00['solicitud_proveedor_carga_hospedaje']))),
                    'solicitud_proveedor_carga_traslado'    => trim(strtoupper(strtolower($rowMSSQL00['solicitud_proveedor_carga_traslado']))),
                    'solicitud_fecha_carga_1'               => $solicitud_fecha_carga_1,
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
                    'tipo_prioridad_css'                    => trim(strtolower($rowMSSQL00['tipo_prioridad_css'])),

                    'tipo_dificultad_codigo'                => $rowMSSQL00['tipo_dificultad_codigo'],
                    'tipo_dificultad_ingles'                => trim(strtoupper(strtolower($rowMSSQL00['tipo_dificultad_ingles']))),
                    'tipo_dificultad_castellano'            => trim(strtoupper(strtolower($rowMSSQL00['tipo_dificultad_castellano']))),
                    'tipo_dificultad_portugues'             => trim(strtoupper(strtolower($rowMSSQL00['tipo_dificultad_portugues']))),
                    'tipo_dificultad_parametro'             => $rowMSSQL00['tipo_dificultad_parametro'],
                    'tipo_dificultad_icono'                 => trim(strtolower($rowMSSQL00['tipo_dificultad_icono'])),
                    'tipo_dificultad_css'                   => trim(strtolower($rowMSSQL00['tipo_dificultad_css'])),

                    'tipo_estado_codigo'                    => $rowMSSQL00['tipo_estado_codigo'],
                    'tipo_estado_ingles'                    => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_ingles']))),
                    'tipo_estado_castellano'                => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_castellano']))),
                    'tipo_estado_portugues'                 => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_portugues']))),
                    'tipo_estado_parametro'                 => $rowMSSQL00['tipo_estado_parametro'],
                    'tipo_estado_icono'                     => trim(strtolower($rowMSSQL00['tipo_estado_icono'])),
                    'tipo_estado_css'                       => trim(strtolower($rowMSSQL00['tipo_estado_css']))
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
                    'solicitud_vuelo'                       => '',
                    'solicitud_hospedaje'                   => '',
                    'solicitud_traslado'                    => '',
                    'solicitud_solicitante_tarifa_vuelo'    => '',
                    'solicitud_solicitante_tarifa_hospedaje'=> '',
                    'solicitud_solicitante_tarifa_traslado' => '',
                    'solicitud_proveedor_carga_vuelo'       => '',
                    'solicitud_proveedor_carga_hospedaje'   => '',
                    'solicitud_proveedor_carga_traslado'    => '',
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
                    'tipo_prioridad_css'                    => '',

                    'tipo_dificultad_codigo'                => '',
                    'tipo_dificultad_ingles'                => '',
                    'tipo_dificultad_castellano'            => '',
                    'tipo_dificultad_portugues'             => '',
                    'tipo_dificultad_parametro'             => '',
                    'tipo_dificultad_icono'                 => '',
                    'tipo_dificultad_css'                   => '',

                    'tipo_estado_codigo'                    => '',
                    'tipo_estado_ingles'                    => '',
                    'tipo_estado_castellano'                => '',
                    'tipo_estado_portugues'                 => '',
                    'tipo_estado_parametro'                 => '',
                    'tipo_estado_icono'                     => '',
                    'tipo_estado_css'                       => ''
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

    $app->get('/v2/400/solicitud/ejecutivo/estado/cantidad/{documento}', function($request) {//20201103
        require __DIR__.'/../src/connect.php';
        
        $val01  = $request->getAttribute('documento');
        
        if (isset($val01)) {
            $sql00  = "SELECT 
                a.DOMFICCOD         AS          tipo_estado_codigo,
                a.DOMFICNOC         AS          tipo_estado_nombre,
                a.DOMFICCSS         AS          tipo_estado_css,
                COUNT(*)            AS          tipo_estado_cantidad
                FROM adm.DOMFIC a 
                INNER JOIN via.SOLFIC b ON a.DOMFICCOD = b.SOLFICEST
                WHERE DOMFICVAL = 'SOLICITUDESTADO' AND b.SOLFICDNE = ? 
                
                GROUP BY a.DOMFICCOD, a.DOMFICNOC, a.DOMFICCSS ";

            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val01]);

                while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {    
                    $detalle = array(                    
                        'tipo_estado_codigo'                    => $rowMSSQL00['tipo_estado_codigo'],
                        'tipo_estado_nombre'                    => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_nombre']))),
                        'tipo_estado_css'                       => trim($rowMSSQL00['tipo_estado_css']),
                        'tipo_estado_cantidad'                  => $rowMSSQL00['tipo_estado_cantidad']
                    );
    
                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle    = array(
                        'tipo_estado_codigo'                    => '',
                        'tipo_estado_nombre'                    => '',
                        'tipo_estado_css'                       => '',
                        'tipo_estado_cantidad'                  => ''
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

    $app->get('/v2/400/solicitud/proveedor/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val01  = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
                a.SOLFICCOD         AS          solicitud_codigo,
                a.SOLFICPER         AS          solicitud_periodo,
                a.SOLFICMOT         AS          solicitud_motivo,
                a.SOLFICVUE         AS          solicitud_vuelo,
                a.SOLFICHOS         AS          solicitud_hospedaje,
                a.SOLFICTRA         AS          solicitud_traslado,
                a.SOLFICSTV         AS          solicitud_solicitante_tarifa_vuelo,
                a.SOLFICSTH         AS          solicitud_solicitante_tarifa_hospedaje,
                a.SOLFICSTT         AS          solicitud_solicitante_tarifa_traslado,
                a.SOLFICPCV         AS          solicitud_proveedor_carga_vuelo,
                a.SOLFICPCH         AS          solicitud_proveedor_carga_hospedaje,
                a.SOLFICPCT		    AS	        solicitud_proveedor_carga_traslado,
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
                a.SOLFICDNP         AS          solicitud_proveedor_documento,

                m.DOMFICCOD         AS          tipo_dificultad_codigo,
                m.DOMFICNOI         AS          tipo_dificultad_ingles,
                m.DOMFICNOC         AS          tipo_dificultad_castellano,
                m.DOMFICNOP         AS          tipo_dificultad_portugues,
                m.DOMFICPAR         AS          tipo_dificultad_parametro,
                m.DOMFICICO         AS          tipo_dificultad_icono,
                m.DOMFICCSS         AS          tipo_dificultad_css,

                n.DOMFICCOD         AS          tipo_estado_codigo,
                n.DOMFICNOI         AS          tipo_estado_ingles,
                n.DOMFICNOC         AS          tipo_estado_castellano,
                n.DOMFICNOP         AS          tipo_estado_portugues,
                n.DOMFICPAR         AS          tipo_estado_parametro,
                n.DOMFICICO         AS          tipo_estado_icono,
                n.DOMFICCSS         AS          tipo_estado_css

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
                INNER JOIN [adm].[DOMFIC] k ON a.SOLFICTPC = k.DOMFICCOD
                LEFT OUTER JOIN [CSF].[dbo].[empleados_AxisONE] l1 ON a.SOLFICDNS COLLATE SQL_Latin1_General_CP1_CI_AS = l1.CedulaEmpleado
                LEFT OUTER JOIN [CSF].[dbo].[empleados_AxisONE] l2 ON a.SOLFICDNJ COLLATE SQL_Latin1_General_CP1_CI_AS = l2.CedulaEmpleado
                LEFT OUTER JOIN [CSF].[dbo].[empleados_AxisONE] l3 ON a.SOLFICDNE COLLATE SQL_Latin1_General_CP1_CI_AS = l3.CedulaEmpleado
                LEFT OUTER JOIN [CSF].[dbo].[empleados_AxisONE] l4 ON a.SOLFICDNP COLLATE SQL_Latin1_General_CP1_CI_AS = l4.CedulaEmpleado
                INNER JOIN [adm].[DOMFIC] m ON a.SOLFICTDC = m.DOMFICCOD
                INNER JOIN [adm].[DOMFIC] n ON a.SOLFICEST = n.DOMFICCOD

                WHERE a.SOLFICDNP = ?

                ORDER BY a.SOLFICCOD DESC";

            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val01]);

                while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                    if(!empty($rowMSSQL00['solicitud_fecha_carga'])){
                        $solicitud_fecha_carga_1    = $rowMSSQL00['solicitud_fecha_carga'];
                        $solicitud_fecha_carga_2    = date("d/m/Y", strtotime($rowMSSQL00['solicitud_fecha_carga']));
                    } else {
                        $solicitud_fecha_carga_1    = '';
                        $solicitud_fecha_carga_2    = '';
                    }
    
                    $detalle = array(                    
                        'solicitud_codigo'                      => $rowMSSQL00['solicitud_codigo'],
                        'solicitud_periodo'                     => $rowMSSQL00['solicitud_periodo'],
                        'solicitud_motivo'                      => trim(strtoupper(strtolower($rowMSSQL00['solicitud_motivo']))),
                        'solicitud_vuelo'                       => trim(strtoupper(strtolower($rowMSSQL00['solicitud_vuelo']))),
                        'solicitud_hospedaje'                   => trim(strtoupper(strtolower($rowMSSQL00['solicitud_hospedaje']))),
                        'solicitud_traslado'                    => trim(strtoupper(strtolower($rowMSSQL00['solicitud_traslado']))),
                        'solicitud_solicitante_tarifa_vuelo'    => trim(strtoupper(strtolower($rowMSSQL00['solicitud_solicitante_tarifa_vuelo']))),
                        'solicitud_solicitante_tarifa_hospedaje'=> trim(strtoupper(strtolower($rowMSSQL00['solicitud_solicitante_tarifa_hospedaje']))),
                        'solicitud_solicitante_tarifa_traslado' => trim(strtoupper(strtolower($rowMSSQL00['solicitud_solicitante_tarifa_traslado']))),
                        'solicitud_proveedor_carga_hospedaje'   => trim(strtoupper(strtolower($rowMSSQL00['solicitud_proveedor_carga_hospedaje']))),
                        'solicitud_proveedor_carga_hospedaje'   => trim(strtoupper(strtolower($rowMSSQL00['solicitud_proveedor_carga_hospedaje']))),
                        'solicitud_proveedor_carga_traslado'    => trim(strtoupper(strtolower($rowMSSQL00['solicitud_proveedor_carga_traslado']))),
                        'solicitud_fecha_carga_1'               => $solicitud_fecha_carga_1,
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
                        'tipo_prioridad_css'                    => trim(strtolower($rowMSSQL00['tipo_prioridad_css'])),
    
                        'tipo_dificultad_codigo'                => $rowMSSQL00['tipo_dificultad_codigo'],
                        'tipo_dificultad_ingles'                => trim(strtoupper(strtolower($rowMSSQL00['tipo_dificultad_ingles']))),
                        'tipo_dificultad_castellano'            => trim(strtoupper(strtolower($rowMSSQL00['tipo_dificultad_castellano']))),
                        'tipo_dificultad_portugues'             => trim(strtoupper(strtolower($rowMSSQL00['tipo_dificultad_portugues']))),
                        'tipo_dificultad_parametro'             => $rowMSSQL00['tipo_dificultad_parametro'],
                        'tipo_dificultad_icono'                 => trim(strtolower($rowMSSQL00['tipo_dificultad_icono'])),
                        'tipo_dificultad_css'                   => trim(strtolower($rowMSSQL00['tipo_dificultad_css'])),
    
                        'tipo_estado_codigo'                    => $rowMSSQL00['tipo_estado_codigo'],
                        'tipo_estado_ingles'                    => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_ingles']))),
                        'tipo_estado_castellano'                => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_castellano']))),
                        'tipo_estado_portugues'                 => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_portugues']))),
                        'tipo_estado_parametro'                 => $rowMSSQL00['tipo_estado_parametro'],
                        'tipo_estado_icono'                     => trim(strtolower($rowMSSQL00['tipo_estado_icono'])),
                        'tipo_estado_css'                       => trim(strtolower($rowMSSQL00['tipo_estado_css']))
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
                        'solicitud_vuelo'                       => '',
                        'solicitud_hospedaje'                   => '',
                        'solicitud_traslado'                    => '',
                        'solicitud_solicitante_tarifa_vuelo'    => '',
                        'solicitud_solicitante_tarifa_hospedaje'=> '',
                        'solicitud_solicitante_tarifa_traslado' => '',
                        'solicitud_proveedor_carga_vuelo'       => '',
                        'solicitud_proveedor_carga_hospedaje'   => '',
                        'solicitud_proveedor_carga_traslado'    => '',
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
                        'tipo_prioridad_css'                    => '',
    
                        'tipo_dificultad_codigo'                => '',
                        'tipo_dificultad_ingles'                => '',
                        'tipo_dificultad_castellano'            => '',
                        'tipo_dificultad_portugues'             => '',
                        'tipo_dificultad_parametro'             => '',
                        'tipo_dificultad_icono'                 => '',
                        'tipo_dificultad_css'                   => '',
    
                        'tipo_estado_codigo'                    => '',
                        'tipo_estado_ingles'                    => '',
                        'tipo_estado_castellano'                => '',
                        'tipo_estado_portugues'                 => '',
                        'tipo_estado_parametro'                 => '',
                        'tipo_estado_icono'                     => '',
                        'tipo_estado_css'                       => ''
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

    $app->get('/v2/400/solicitud/proveedor/asignado/cantidad', function($request) {//20201106
        require __DIR__.'/../src/connect.php';

        $sql00  = "SELECT 
            b.CedulaEmpleado AS solicitud_ejecutivo_documento,
            b.NombreEmpleado   AS solicitud_ejecutivo_nombre,
            COUNT(*) AS TOTAL_ASIGNADOS
            
            FROM [via].[SOLFIC] a
            LEFT OUTER JOIN [CSF].[dbo].[empleados_AxisONE] b ON a.SOLFICDNE COLLATE SQL_Latin1_General_CP1_CI_AS = b.CedulaEmpleado  

            WHERE a.SOLFICDNE IS NOT NULL AND a.SOLFICDNP IS NOT NULL

            GROUP BY a.SOLFICDNE, b.CedulaEmpleado, b.NombreEmpleado";

        try {
            $connMSSQL  = getConnectionMSSQLv2();
            $stmtMSSQL00= $connMSSQL->prepare($sql00);
            $stmtMSSQL00->execute();

            while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                $detalle = array(                    
                    'solicitud_ejecutivo_documento'                 => trim(strtoupper(strtolower($rowMSSQL00['solicitud_ejecutivo_documento']))),
                    'solicitud_ejecutivo_nombre'                    => trim(strtoupper(strtolower($rowMSSQL00['solicitud_ejecutivo_nombre']))),
                    'TOTAL_ASIGNADOS'                               => $rowMSSQL00['TOTAL_ASIGNADOS']
                );

                $result[]   = $detalle;
            }

            if (isset($result)){
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } else {
                $detalle    = array(
                    'solicitud_ejecutivo_documento'                 => '',
                    'solicitud_ejecutivo_nombre'                    => '',
                    'TOTAL_ASIGNADOS'                               => ''
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

    $app->get('/v2/400/solicitud/proveedor/sinasignar/cantidad', function($request) {//20201106
        require __DIR__.'/../src/connect.php';

        $sql00  = "SELECT
            '1'         AS solicitud_tipo,
            COUNT(*)    AS solicitud_cantidad
            FROM [via].[SOLFIC] a
            
            WHERE a.SOLFICDNP IS NULL AND a.SOLFICDNE IS NOT NULL";

        try {
            $connMSSQL  = getConnectionMSSQLv2();
            $stmtMSSQL00= $connMSSQL->prepare($sql00);
            $stmtMSSQL00->execute();

            while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                $detalle = array(                    
                    'solicitud_tipo'                        => $rowMSSQL00['solicitud_tipo'],
                    'solicitud_cantidad'                    => $rowMSSQL00['solicitud_cantidad']
                );

                $result[]   = $detalle;
            }

            if (isset($result)){
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } else {
                $detalle    = array(
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

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v2/400/solicitud/proveedor/sinasignar/detalle', function($request) {//20201106
        require __DIR__.'/../src/connect.php';

        $sql00  = "SELECT
            a.SOLFICCOD         AS          solicitud_codigo,
            a.SOLFICPER         AS          solicitud_periodo,
            a.SOLFICMOT         AS          solicitud_motivo,
            a.SOLFICVUE         AS          solicitud_vuelo,
            a.SOLFICHOS         AS          solicitud_hospedaje,
            a.SOLFICTRA         AS          solicitud_traslado,
            a.SOLFICSTV         AS          solicitud_solicitante_tarifa_vuelo,
            a.SOLFICSTH         AS          solicitud_solicitante_tarifa_hospedaje,
            a.SOLFICSTT         AS          solicitud_solicitante_tarifa_traslado,
            a.SOLFICPCV         AS          solicitud_proveedor_carga_vuelo,
            a.SOLFICPCH         AS          solicitud_proveedor_carga_hospedaje,
            a.SOLFICPCT		    AS	        solicitud_proveedor_carga_traslado,
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
            a.SOLFICDNP         AS          solicitud_proveedor_documento,

            m.DOMFICCOD         AS          tipo_dificultad_codigo,
            m.DOMFICNOI         AS          tipo_dificultad_ingles,
            m.DOMFICNOC         AS          tipo_dificultad_castellano,
            m.DOMFICNOP         AS          tipo_dificultad_portugues,
            m.DOMFICPAR         AS          tipo_dificultad_parametro,
            m.DOMFICICO         AS          tipo_dificultad_icono,
            m.DOMFICCSS         AS          tipo_dificultad_css,

            n.DOMFICCOD         AS          tipo_estado_codigo,
            n.DOMFICNOI         AS          tipo_estado_ingles,
            n.DOMFICNOC         AS          tipo_estado_castellano,
            n.DOMFICNOP         AS          tipo_estado_portugues,
            n.DOMFICPAR         AS          tipo_estado_parametro,
            n.DOMFICICO         AS          tipo_estado_icono,
            n.DOMFICCSS         AS          tipo_estado_css

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
            INNER JOIN [adm].[DOMFIC] k ON a.SOLFICTPC = k.DOMFICCOD
            LEFT OUTER JOIN [CSF].[dbo].[empleados_AxisONE] l1 ON a.SOLFICDNS COLLATE SQL_Latin1_General_CP1_CI_AS = l1.CedulaEmpleado
            LEFT OUTER JOIN [CSF].[dbo].[empleados_AxisONE] l2 ON a.SOLFICDNJ COLLATE SQL_Latin1_General_CP1_CI_AS = l2.CedulaEmpleado
            LEFT OUTER JOIN [CSF].[dbo].[empleados_AxisONE] l3 ON a.SOLFICDNE COLLATE SQL_Latin1_General_CP1_CI_AS = l3.CedulaEmpleado
            LEFT OUTER JOIN [CSF].[dbo].[empleados_AxisONE] l4 ON a.SOLFICDNP COLLATE SQL_Latin1_General_CP1_CI_AS = l4.CedulaEmpleado
            INNER JOIN [adm].[DOMFIC] m ON a.SOLFICTDC = m.DOMFICCOD
            INNER JOIN [adm].[DOMFIC] n ON a.SOLFICEST = n.DOMFICCOD

            WHERE a.SOLFICDNP IS NULL AND a.SOLFICDNE IS NOT NULL

            ORDER BY a.SOLFICCOD DESC";

        try {
            $connMSSQL  = getConnectionMSSQLv2();
            $stmtMSSQL00= $connMSSQL->prepare($sql00);
            $stmtMSSQL00->execute();

            while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                if(!empty($rowMSSQL00['solicitud_fecha_carga'])){
                    $solicitud_fecha_carga_1    = $rowMSSQL00['solicitud_fecha_carga'];
                    $solicitud_fecha_carga_2    = date("d/m/Y", strtotime($rowMSSQL00['solicitud_fecha_carga']));
                } else {
                    $solicitud_fecha_carga_1    = '';
                    $solicitud_fecha_carga_2    = '';
                }

                $detalle = array(                    
                    'solicitud_codigo'                      => $rowMSSQL00['solicitud_codigo'],
                    'solicitud_periodo'                     => $rowMSSQL00['solicitud_periodo'],
                    'solicitud_motivo'                      => trim(strtoupper(strtolower($rowMSSQL00['solicitud_motivo']))),
                    'solicitud_vuelo'                       => trim(strtoupper(strtolower($rowMSSQL00['solicitud_vuelo']))),
                    'solicitud_hospedaje'                   => trim(strtoupper(strtolower($rowMSSQL00['solicitud_hospedaje']))),
                    'solicitud_traslado'                    => trim(strtoupper(strtolower($rowMSSQL00['solicitud_traslado']))),
                    'solicitud_solicitante_tarifa_vuelo'    => trim(strtoupper(strtolower($rowMSSQL00['solicitud_solicitante_tarifa_vuelo']))),
                    'solicitud_solicitante_tarifa_hospedaje'=> trim(strtoupper(strtolower($rowMSSQL00['solicitud_solicitante_tarifa_hospedaje']))),
                    'solicitud_solicitante_tarifa_traslado' => trim(strtoupper(strtolower($rowMSSQL00['solicitud_solicitante_tarifa_traslado']))),
                    'solicitud_proveedor_carga_hospedaje'   => trim(strtoupper(strtolower($rowMSSQL00['solicitud_proveedor_carga_hospedaje']))),
                    'solicitud_proveedor_carga_hospedaje'   => trim(strtoupper(strtolower($rowMSSQL00['solicitud_proveedor_carga_hospedaje']))),
                    'solicitud_proveedor_carga_traslado'    => trim(strtoupper(strtolower($rowMSSQL00['solicitud_proveedor_carga_traslado']))),
                    'solicitud_fecha_carga_1'               => $solicitud_fecha_carga_1,
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
                    'tipo_prioridad_css'                    => trim(strtolower($rowMSSQL00['tipo_prioridad_css'])),

                    'tipo_dificultad_codigo'                => $rowMSSQL00['tipo_dificultad_codigo'],
                    'tipo_dificultad_ingles'                => trim(strtoupper(strtolower($rowMSSQL00['tipo_dificultad_ingles']))),
                    'tipo_dificultad_castellano'            => trim(strtoupper(strtolower($rowMSSQL00['tipo_dificultad_castellano']))),
                    'tipo_dificultad_portugues'             => trim(strtoupper(strtolower($rowMSSQL00['tipo_dificultad_portugues']))),
                    'tipo_dificultad_parametro'             => $rowMSSQL00['tipo_dificultad_parametro'],
                    'tipo_dificultad_icono'                 => trim(strtolower($rowMSSQL00['tipo_dificultad_icono'])),
                    'tipo_dificultad_css'                   => trim(strtolower($rowMSSQL00['tipo_dificultad_css'])),

                    'tipo_estado_codigo'                    => $rowMSSQL00['tipo_estado_codigo'],
                    'tipo_estado_ingles'                    => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_ingles']))),
                    'tipo_estado_castellano'                => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_castellano']))),
                    'tipo_estado_portugues'                 => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_portugues']))),
                    'tipo_estado_parametro'                 => $rowMSSQL00['tipo_estado_parametro'],
                    'tipo_estado_icono'                     => trim(strtolower($rowMSSQL00['tipo_estado_icono'])),
                    'tipo_estado_css'                       => trim(strtolower($rowMSSQL00['tipo_estado_css']))
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
                    'solicitud_vuelo'                       => '',
                    'solicitud_hospedaje'                   => '',
                    'solicitud_traslado'                    => '',
                    'solicitud_solicitante_tarifa_vuelo'    => '',
                    'solicitud_solicitante_tarifa_hospedaje'=> '',
                    'solicitud_solicitante_tarifa_traslado' => '',
                    'solicitud_proveedor_carga_vuelo'       => '',
                    'solicitud_proveedor_carga_hospedaje'   => '',
                    'solicitud_proveedor_carga_traslado'    => '',
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
                    'tipo_prioridad_css'                    => '',

                    'tipo_dificultad_codigo'                => '',
                    'tipo_dificultad_ingles'                => '',
                    'tipo_dificultad_castellano'            => '',
                    'tipo_dificultad_portugues'             => '',
                    'tipo_dificultad_parametro'             => '',
                    'tipo_dificultad_icono'                 => '',
                    'tipo_dificultad_css'                   => '',

                    'tipo_estado_codigo'                    => '',
                    'tipo_estado_ingles'                    => '',
                    'tipo_estado_castellano'                => '',
                    'tipo_estado_portugues'                 => '',
                    'tipo_estado_parametro'                 => '',
                    'tipo_estado_icono'                     => '',
                    'tipo_estado_css'                       => ''
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

    $app->get('/v2/400/solicitud/char01/documento/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val01  = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
            '1' AS solicitud_codigo,
            'solicitud_total' AS solicitud_tipo,
            COUNT(*) AS solicitud_cantidad

            FROM [via].[SOLFIC] a
            WHERE a.SOLFICDNS = ?

            UNION ALL

            SELECT
            '2' AS solicitud_codigo,
            'solicitud_pendiente' AS solicitud_tipo,
            COUNT(*) AS solicitud_cantidad

            FROM [via].[SOLFIC] a
            WHERE a.SOLFICDNS = ?";

            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val01, $val01]);

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

    $app->get('/v2/400/solicitud/char01/colaborador/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val01  = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
            '1' AS solicitud_codigo,
            'solicitud_total' AS solicitud_tipo,
            COUNT(*) AS solicitud_cantidad

            FROM [via].[SOLFIC] a
            WHERE a.SOLFICDNJ = ?

            UNION ALL

            SELECT
            '2' AS solicitud_codigo,
            'solicitud_pendiente' AS solicitud_tipo,
            COUNT(*) AS solicitud_cantidad

            FROM [via].[SOLFIC] a
            WHERE a.SOLFICDNJ = ?";

            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val01, $val01]);

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

    $app->get('/v2/400/solicitud/char01/solicitante/{documento}', function($request) {//20201103
        require __DIR__.'/../src/connect.php';
        
        $val01  = $request->getAttribute('documento');
        
        if (isset($val01)) {
            $sql00  = "SELECT 
            a.DOMFICCOD         AS          tipo_estado_codigo,
            a.DOMFICNOC         AS          tipo_estado_nombre,
            a.DOMFICCSS         AS          tipo_estado_css,
            COUNT(*)            AS          solicitud_cantidad
            FROM adm.DOMFIC a 
            INNER JOIN via.SOLFIC b ON a.DOMFICCOD = b.SOLFICEST
            WHERE DOMFICVAL = 'SOLICITUDESTADO' AND b.SOLFICDNS = ? 
            
            GROUP BY a.DOMFICCOD, a.DOMFICNOC, a.DOMFICCSS";

            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val01]);

                while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {    
                    $detalle = array(                    
                        'tipo_estado_codigo'                      => $rowMSSQL00['tipo_estado_codigo'],
                        'tipo_estado_nombre'                      => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_nombre']))),
                        'tipo_estado_css'                         => trim($rowMSSQL00['tipo_estado_css']),
                        'solicitud_cantidad'                      => $rowMSSQL00['solicitud_cantidad']
                    );
    
                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle    = array(
                        'tipo_estado_codigo'                        => '',
                        'tipo_estado_nombre'                        => '',
                        'tipo_estado_css'                           => '',
                        'solicitud_cantidad'                        => ''
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

    $app->get('/v2/400/solicitud/char01/jefatura/{documento}', function($request) {//20201103
        require __DIR__.'/../src/connect.php';
        
        $val01  = $request->getAttribute('documento');
        
        if (isset($val01)) {
            $sql00  = "SELECT 
                a.DOMFICCOD         AS          tipo_estado_codigo,
                a.DOMFICNOC         AS          tipo_estado_nombre,
                a.DOMFICCSS         AS          tipo_estado_css,
                COUNT(*)            AS          solicitud_cantidad
                FROM adm.DOMFIC a 
                INNER JOIN via.SOLFIC b ON a.DOMFICCOD = b.SOLFICEST
                WHERE DOMFICVAL = 'SOLICITUDESTADO' AND b.SOLFICDNJ = ? 
                
                GROUP BY a.DOMFICCOD, a.DOMFICNOC, a.DOMFICCSS ";

            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val01]);

                while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {    
                    $detalle = array(                    
                        'tipo_estado_codigo'                      => $rowMSSQL00['tipo_estado_codigo'],
                        'tipo_estado_nombre'                      => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_nombre']))),
                        'tipo_estado_css'                         => trim($rowMSSQL00['tipo_estado_css']),
                        'solicitud_cantidad'                      => $rowMSSQL00['solicitud_cantidad']
                    );
    
                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle    = array(
                        'tipo_estado_codigo'                        => '',
                        'tipo_estado_nombre'                        => '',
                        'tipo_estado_css'                           => '',
                        'solicitud_cantidad'                        => ''
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

    $app->get('/v2/400/solicitud/char01/proveedor/{documento}', function($request) {//20201103
        require __DIR__.'/../src/connect.php';
        
        $val01  = $request->getAttribute('documento');
        
        if (isset($val01)) {
            $sql00  = "SELECT 
                a.DOMFICCOD         AS          tipo_estado_codigo,
                a.DOMFICNOC         AS          tipo_estado_nombre,
                a.DOMFICCSS         AS          tipo_estado_css,
                COUNT(*)            AS          solicitud_cantidad
                FROM adm.DOMFIC a 
                INNER JOIN via.SOLFIC b ON a.DOMFICCOD = b.SOLFICEST
                WHERE DOMFICVAL = 'SOLICITUDESTADO' AND b.SOLFICDNP = ? 
                
                GROUP BY a.DOMFICCOD, a.DOMFICNOC, a.DOMFICCSS ";

            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val01]);

                while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {    
                    $detalle = array(                    
                        'tipo_estado_codigo'                      => $rowMSSQL00['tipo_estado_codigo'],
                        'tipo_estado_nombre'                      => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_nombre']))),
                        'tipo_estado_css'                         => trim($rowMSSQL00['tipo_estado_css']),
                        'solicitud_cantidad'                      => $rowMSSQL00['solicitud_cantidad']
                    );
    
                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle    = array(
                        'tipo_estado_codigo'                        => '',
                        'tipo_estado_nombre'                        => '',
                        'tipo_estado_css'                           => '',
                        'solicitud_cantidad'                        => ''
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

    $app->get('/v2/400/solicitud/detalle/vuelo/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val01  = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
                a.SOLVUECOD         AS          solicitud_detalle_vuelo_codigo,
                a.SOLVUECOM         AS          solicitud_detalle_vuelo_comentario,
                a.SOLVUEFSA         AS          solicitud_detalle_vuelo_fecha_salida,
                a.SOLVUEFRE         AS          solicitud_detalle_vuelo_fecha_retorno,
                a.SOLVUETVC         AS          tipo_vuelo_codigo,

                a.SOLVUEAUS         AS          auditoria_usuario,
                a.SOLVUEAFH         AS          auditoria_fecha_hora,
                a.SOLVUEAIP         AS          auditoria_ip,

                b.DOMFICCOD         AS          tipo_estado_codigo,
                b.DOMFICNOI         AS          tipo_estado_ingles,
                b.DOMFICNOC         AS          tipo_estado_castellano,
                b.DOMFICNOP         AS          tipo_estado_portugues,
                b.DOMFICPAR         AS          tipo_estado_parametro,
                b.DOMFICICO         AS          tipo_estado_icono,
                b.DOMFICCSS         AS          tipo_estado_css,

                c.DOMFICCOD         AS          tipo_horario_salida_codigo,
                c.DOMFICNOI         AS          tipo_horario_salida_ingles,
                c.DOMFICNOC         AS          tipo_horario_salida_castellano,
                c.DOMFICNOP         AS          tipo_horario_salida_portugues,
                c.DOMFICPAR         AS          tipo_horario_salida_parametro,
                c.DOMFICICO         AS          tipo_horario_salida_icono,
                c.DOMFICCSS         AS          tipo_horario_salida_css,

                d.DOMFICCOD         AS          tipo_horario_retorno_codigo,
                d.DOMFICNOI         AS          tipo_horario_retorno_ingles,
                d.DOMFICNOC         AS          tipo_horario_retorno_castellano,
                d.DOMFICNOP         AS          tipo_horario_retorno_portugues,
                d.DOMFICPAR         AS          tipo_horario_retorno_parametro,
                d.DOMFICICO         AS          tipo_horario_retorno_icono,
                d.DOMFICCSS         AS          tipo_horario_retorno_css,

                e1.LOCCIUCOD        AS          localidad_ciudad_origen_codigo,
                e1.LOCCIUORD        AS          localidad_ciudad_origen_orden,
                e1.LOCCIUNOM        AS          localidad_ciudad_origen_nombre,
                e1.LOCCIUOBS        AS          localidad_ciudad_origen_observacion,

                f1.LOCPAICOD        AS          localidad_pais_origen_codigo,
                f1.LOCPAIORD        AS          localidad_pais_origen_orden,
                f1.LOCPAINOM        AS          localidad_pais_origen_nombre,
                f1.LOCPAIPAT        AS          localidad_pais_origen_path,
                f1.LOCPAIIC2        AS          localidad_pais_origen_iso_char2,
                f1.LOCPAIIC3        AS          localidad_pais_origen_iso_char3,
                f1.LOCPAIIN3        AS          localidad_pais_origen_iso_num3,
                f1.LOCPAIOBS        AS          localidad_pais_origen_observacion,

                e2.LOCCIUCOD        AS          localidad_ciudad_destino_codigo,
                e2.LOCCIUORD        AS          localidad_ciudad_destino_orden,
                e2.LOCCIUNOM        AS          localidad_ciudad_destino_nombre,
                e2.LOCCIUOBS        AS          localidad_ciudad_destino_observacion,

                f2.LOCPAICOD        AS          localidad_pais_destino_codigo,
                f2.LOCPAIORD        AS          localidad_pais_destino_orden,
                f2.LOCPAINOM        AS          localidad_pais_destino_nombre,
                f2.LOCPAIPAT        AS          localidad_pais_destino_path,
                f2.LOCPAIIC2        AS          localidad_pais_destino_iso_char2,
                f2.LOCPAIIC3        AS          localidad_pais_destino_iso_char3,
                f2.LOCPAIIN3        AS          localidad_pais_destino_iso_num3,
                f2.LOCPAIOBS        AS          localidad_pais_destino_observacion,

                g.SOLFICCOD         AS          solicitud_codigo,
                g.SOLFICPER         AS          solicitud_periodo,
                g.SOLFICMOT         AS          solicitud_motivo,
                g.SOLFICVUE         AS          solicitud_vuelo,
                g.SOLFICHOS         AS          solicitud_hospedaje,
                g.SOLFICTRA         AS          solicitud_traslado,
                g.SOLFICSTV         AS          solicitud_solicitante_tarifa_vuelo,
                g.SOLFICSTH         AS          solicitud_solicitante_tarifa_hospedaje,
                g.SOLFICSTT         AS          solicitud_solicitante_tarifa_traslado,
                g.SOLFICPCV         AS          solicitud_proveedor_carga_vuelo,
                g.SOLFICPCH         AS          solicitud_proveedor_carga_hospedaje,
                g.SOLFICPCT		    AS	        solicitud_proveedor_carga_traslado,
                g.SOLFICFEC         AS          solicitud_fecha_carga,
                g.SOLFICSCC         AS          solicitud_sap_centro_costo,
                g.SOLFICTCA         AS          solicitud_tarea_cantidad,
                g.SOLFICTRE         AS          solicitud_tarea_resuelta,
                g.SOLFICOBS         AS          solicitud_observacion,

                h1.NombreEmpleado   AS          solicitud_solicitante_nombre,
                g.SOLFICDNS         AS          solicitud_solicitante_documento,
                h2.NombreEmpleado   AS          solicitud_jefatura_nombre,
                g.SOLFICDNJ         AS          solicitud_jefatura_documento,
                h3.NombreEmpleado   AS          solicitud_ejecutivo_nombre,
                g.SOLFICDNE         AS          solicitud_ejecutivo_documento,
                h4.NombreEmpleado   AS          solicitud_proveedor_nombre,
                g.SOLFICDNP         AS          solicitud_proveedor_documento

                FROM [via].[SOLVUE] a
                INNER JOIN [adm].[DOMFIC] b ON a.SOLVUEEST = b.DOMFICCOD
                INNER JOIN [adm].[DOMFIC] c ON a.SOLVUETSC = c.DOMFICCOD
                INNER JOIN [adm].[DOMFIC] d ON a.SOLVUETRC = d.DOMFICCOD

                LEFT OUTER JOIN [adm].[LOCCIU] e1 ON a.SOLVUECOC = e1.LOCCIUCOD
                LEFT OUTER JOIN [adm].[LOCPAI] f1 ON e1.LOCCIUPAC = f1.LOCPAICOD

                LEFT OUTER JOIN [adm].[LOCCIU] e2 ON a.SOLVUECDC = e2.LOCCIUCOD
                LEFT OUTER JOIN [adm].[LOCPAI] f2 ON e2.LOCCIUPAC = f2.LOCPAICOD

                LEFT OUTER JOIN [via].[SOLFIC] g ON a.SOLVUESOC = g.SOLFICCOD

                LEFT OUTER JOIN [CSF].[dbo].[empleados_AxisONE] h1 ON g.SOLFICDNS COLLATE SQL_Latin1_General_CP1_CI_AS = h1.CedulaEmpleado
                LEFT OUTER JOIN [CSF].[dbo].[empleados_AxisONE] h2 ON g.SOLFICDNJ COLLATE SQL_Latin1_General_CP1_CI_AS = h2.CedulaEmpleado
                LEFT OUTER JOIN [CSF].[dbo].[empleados_AxisONE] h3 ON g.SOLFICDNE COLLATE SQL_Latin1_General_CP1_CI_AS = h3.CedulaEmpleado
                LEFT OUTER JOIN [CSF].[dbo].[empleados_AxisONE] h4 ON g.SOLFICDNP COLLATE SQL_Latin1_General_CP1_CI_AS = h4.CedulaEmpleado

                WHERE a.SOLVUESOC = ?

                ORDER BY a.SOLVUECOD";

            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val01]);

                while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                    if(!empty($rowMSSQL00['solicitud_detalle_vuelo_fecha_salida'])){
                        $solicitud_detalle_vuelo_fecha_salida_1    = $rowMSSQL00['solicitud_detalle_vuelo_fecha_salida'];
                        $solicitud_detalle_vuelo_fecha_salida_2    = date("d/m/Y", strtotime($rowMSSQL00['solicitud_detalle_vuelo_fecha_salida']));
                    } else {
                        $solicitud_detalle_vuelo_fecha_salida_1    = '';
                        $solicitud_detalle_vuelo_fecha_salida_2    = '';
                    }

                    if(!empty($rowMSSQL00['solicitud_detalle_vuelo_fecha_retorno'])){
                        $solicitud_detalle_vuelo_fecha_retorno_1    = $rowMSSQL00['solicitud_detalle_vuelo_fecha_retorno'];
                        $solicitud_detalle_vuelo_fecha_retorno_2    = date("d/m/Y", strtotime($rowMSSQL00['solicitud_detalle_vuelo_fecha_retorno']));
                    } else {
                        $solicitud_detalle_vuelo_fecha_retorno_1    = '';
                        $solicitud_detalle_vuelo_fecha_retorno_2    = '';
                    }

                    if(!empty($rowMSSQL00['solicitud_fecha_carga'])){
                        $solicitud_fecha_carga_1    = $rowMSSQL00['solicitud_fecha_carga'];
                        $solicitud_fecha_carga_2    = date("d/m/Y", strtotime($rowMSSQL00['solicitud_fecha_carga']));
                    } else {
                        $solicitud_fecha_carga_1    = '';
                        $solicitud_fecha_carga_2    = '';
                    }

                    if ($rowMSSQL00['tipo_vuelo_codigo'] == 'R'){
                        $tipo_vuelo_nombre = 'ROUNDTRIP';
                    } else {
                        $tipo_vuelo_nombre = 'ONE-WAY';
                    }

                    $detalle = array(
                        'solicitud_detalle_vuelo_codigo'                            => $rowMSSQL00['solicitud_detalle_vuelo_codigo'],
                        'solicitud_detalle_vuelo_comentario'                        => trim($rowMSSQL00['solicitud_detalle_vuelo_comentario']),
                        'solicitud_detalle_vuelo_fecha_salida_1'                    => $solicitud_detalle_vuelo_fecha_salida_1,
                        'solicitud_detalle_vuelo_fecha_salida_2'                    => $solicitud_detalle_vuelo_fecha_salida_2,
                        'solicitud_detalle_vuelo_fecha_retorno_1'                   => $solicitud_detalle_vuelo_fecha_retorno_1,
                        'solicitud_detalle_vuelo_fecha_retorno_2'                   => $solicitud_detalle_vuelo_fecha_retorno_2,

                        'tipo_vuelo_codigo'                                         => trim(strtoupper(strtolower($rowMSSQL00['tipo_vuelo_codigo']))),
                        'tipo_vuelo_nombre'                                         => $tipo_vuelo_nombre,

                        'auditoria_usuario'                                         => trim(strtoupper(strtolower($rowMSSQL00['auditoria_usuario']))),
                        'auditoria_fecha_hora'                                      => date("d/m/Y H:i:s", strtotime($rowMSSQL00['auditoria_fecha_hora'])),
                        'auditoria_ip'                                              => trim(strtoupper(strtolower($rowMSSQL00['auditoria_ip']))),

                        'tipo_estado_codigo'                                        => $rowMSSQL00['tipo_estado_codigo'],
                        'tipo_estado_ingles'                                        => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_ingles']))),
                        'tipo_estado_castellano'                                    => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_castellano']))),
                        'tipo_estado_portugues'                                     => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_portugues']))),
                        'tipo_estado_parametro'                                     => $rowMSSQL00['tipo_estado_parametro'],
                        'tipo_estado_icono'                                         => trim(strtolower($rowMSSQL00['tipo_estado_icono'])),
                        'tipo_estado_css'                                           => trim(strtolower($rowMSSQL00['tipo_estado_css'])),

                        'tipo_horario_salida_codigo'                                => $rowMSSQL00['tipo_horario_salida_codigo'],
                        'tipo_horario_salida_ingles'                                => trim(strtoupper(strtolower($rowMSSQL00['tipo_horario_salida_ingles']))),
                        'tipo_horario_salida_castellano'                            => trim(strtoupper(strtolower($rowMSSQL00['tipo_horario_salida_castellano']))),
                        'tipo_horario_salida_portugues'                             => trim(strtoupper(strtolower($rowMSSQL00['tipo_horario_salida_portugues']))),
                        'tipo_horario_salida_parametro'                             => $rowMSSQL00['tipo_horario_salida_parametro'],
                        'tipo_horario_salida_icono'                                 => trim(strtolower($rowMSSQL00['tipo_horario_salida_icono'])),
                        'tipo_horario_salida_css'                                   => trim(strtolower($rowMSSQL00['tipo_horario_salida_css'])),

                        'tipo_horario_retorno_codigo'                               => $rowMSSQL00['tipo_horario_retorno_codigo'],
                        'tipo_horario_retorno_ingles'                               => trim(strtoupper(strtolower($rowMSSQL00['tipo_horario_retorno_ingles']))),
                        'tipo_horario_retorno_castellano'                           => trim(strtoupper(strtolower($rowMSSQL00['tipo_horario_retorno_castellano']))),
                        'tipo_horario_retorno_portugues'                            => trim(strtoupper(strtolower($rowMSSQL00['tipo_horario_retorno_portugues']))),
                        'tipo_horario_retorno_parametro'                            => $rowMSSQL00['tipo_horario_retorno_parametro'],
                        'tipo_horario_retorno_icono'                                => trim(strtolower($rowMSSQL00['tipo_horario_retorno_icono'])),
                        'tipo_horario_retorno_css'                                  => trim(strtolower($rowMSSQL00['tipo_horario_retorno_css'])),

                        'solicitud_codigo'                                          => $rowMSSQL00['solicitud_codigo'],
                        'solicitud_periodo'                                         => $rowMSSQL00['solicitud_periodo'],
                        'solicitud_motivo'                                          => trim(strtoupper(strtolower($rowMSSQL00['solicitud_motivo']))),
                        'solicitud_vuelo'                                           => trim(strtoupper(strtolower($rowMSSQL00['solicitud_vuelo']))),
                        'solicitud_hospedaje'                                       => trim(strtoupper(strtolower($rowMSSQL00['solicitud_hospedaje']))),
                        'solicitud_traslado'                                        => trim(strtoupper(strtolower($rowMSSQL00['solicitud_traslado']))),
                        'solicitud_solicitante_tarifa_vuelo'                        => trim(strtoupper(strtolower($rowMSSQL00['solicitud_solicitante_tarifa_vuelo']))),
                        'solicitud_solicitante_tarifa_hospedaje'                    => trim(strtoupper(strtolower($rowMSSQL00['solicitud_solicitante_tarifa_hospedaje']))),
                        'solicitud_solicitante_tarifa_traslado'                     => trim(strtoupper(strtolower($rowMSSQL00['solicitud_solicitante_tarifa_traslado']))),
                        'solicitud_proveedor_carga_hospedaje'                       => trim(strtoupper(strtolower($rowMSSQL00['solicitud_proveedor_carga_hospedaje']))),
                        'solicitud_proveedor_carga_hospedaje'                       => trim(strtoupper(strtolower($rowMSSQL00['solicitud_proveedor_carga_hospedaje']))),
                        'solicitud_proveedor_carga_traslado'                        => trim(strtoupper(strtolower($rowMSSQL00['solicitud_proveedor_carga_traslado']))),
                        'solicitud_fecha_carga_1'                                   => $solicitud_fecha_carga_1,
                        'solicitud_fecha_carga_2'                                   => $solicitud_fecha_carga_2,
                        'solicitud_sap_centro_costo'                                => trim(strtoupper(strtolower($rowMSSQL00['solicitud_sap_centro_costo']))),
                        'solicitud_tarea_cantidad'                                  => $rowMSSQL00['solicitud_tarea_cantidad'],
                        'solicitud_tarea_resuelta'                                  => $rowMSSQL00['solicitud_tarea_resuelta'],
                        'solicitud_tarea_porcentaje'                                => number_format((($rowMSSQL00['solicitud_tarea_resuelta'] * 100) / $rowMSSQL00['solicitud_tarea_cantidad']), 2, '.', ''),
                        'solicitud_solicitante_nombre'                              => trim(strtoupper(strtolower($rowMSSQL00['solicitud_solicitante_nombre']))),
                        'solicitud_solicitante_documento'                           => trim(strtoupper(strtolower($rowMSSQL00['solicitud_solicitante_documento']))),
                        'solicitud_jefatura_nombre'                                 => trim(strtoupper(strtolower($rowMSSQL00['solicitud_jefatura_nombre']))),
                        'solicitud_jefatura_documento'                              => trim(strtoupper(strtolower($rowMSSQL00['solicitud_jefatura_documento']))),
                        'solicitud_ejecutivo_nombre'                                => trim(strtoupper(strtolower($rowMSSQL00['solicitud_ejecutivo_nombre']))),
                        'solicitud_ejecutivo_documento'                             => trim(strtoupper(strtolower($rowMSSQL00['solicitud_ejecutivo_documento']))),
                        'solicitud_proveedor_nombre'                                => trim(strtoupper(strtolower($rowMSSQL00['solicitud_proveedor_nombre']))),
                        'solicitud_proveedor_documento'                             => trim(strtoupper(strtolower($rowMSSQL00['solicitud_proveedor_documento']))),
                        'solicitud_observacion'                                     => trim(strtoupper(strtolower($rowMSSQL00['solicitud_observacion']))),

                        'localidad_ciudad_origen_codigo'                            => $rowMSSQL00['localidad_ciudad_origen_codigo'],
                        'localidad_ciudad_origen_orden'                             => $rowMSSQL00['localidad_ciudad_origen_orden'],
                        'localidad_ciudad_origen_nombre'                            => trim(strtoupper(strtolower($rowMSSQL00['localidad_ciudad_origen_nombre']))),
                        'localidad_ciudad_origen_observacion'                       => trim(strtolower($rowMSSQL00['localidad_ciudad_origen_observacion'])),

                        'localidad_pais_origen_codigo'                              => $rowMSSQL00['localidad_pais_origen_codigo'],
                        'localidad_pais_origen_orden'                               => $rowMSSQL00['localidad_pais_origen_orden'],
                        'localidad_pais_origen_nombre'                              => trim(strtoupper(strtolower($rowMSSQL00['localidad_pais_origen_nombre']))),
                        'localidad_pais_origen_path'                                => trim(strtolower($rowMSSQL00['localidad_pais_origen_path'])),
                        'localidad_pais_origen_iso_char2'                           => trim(strtoupper(strtolower($rowMSSQL00['localidad_pais_origen_iso_char2']))),
                        'localidad_pais_origen_iso_char3'                           => trim(strtoupper(strtolower($rowMSSQL00['localidad_pais_origen_iso_char3']))),
                        'localidad_pais_origen_iso_num3'                            => trim(strtoupper(strtolower($rowMSSQL00['localidad_pais_origen_iso_num3']))),
                        'localidad_pais_origen_observacion'                         => trim(strtoupper(strtolower($rowMSSQL00['localidad_pais_origen_observacion']))),

                        'localidad_ciudad_destino_codigo'                           => $rowMSSQL00['localidad_ciudad_destino_codigo'],
                        'localidad_ciudad_destino_orden'                            => $rowMSSQL00['localidad_ciudad_destino_orden'],
                        'localidad_ciudad_destino_nombre'                           => trim(strtoupper(strtolower($rowMSSQL00['localidad_ciudad_destino_nombre']))),
                        'localidad_ciudad_destino_observacion'                      => trim(strtolower($rowMSSQL00['localidad_ciudad_destino_observacion'])),

                        'localidad_pais_destino_codigo'                             => $rowMSSQL00['localidad_pais_destino_codigo'],
                        'localidad_pais_destino_orden'                              => $rowMSSQL00['localidad_pais_destino_orden'],
                        'localidad_pais_destino_nombre'                             => trim(strtoupper(strtolower($rowMSSQL00['localidad_pais_destino_nombre']))),
                        'localidad_pais_destino_path'                               => trim(strtolower($rowMSSQL00['localidad_pais_destino_path'])),
                        'localidad_pais_destino_iso_char2'                          => trim(strtoupper(strtolower($rowMSSQL00['localidad_pais_destino_iso_char2']))),
                        'localidad_pais_destino_iso_char3'                          => trim(strtoupper(strtolower($rowMSSQL00['localidad_pais_destino_iso_char3']))),
                        'localidad_pais_destino_iso_num3'                           => trim(strtoupper(strtolower($rowMSSQL00['localidad_pais_destino_iso_num3']))),
                        'localidad_pais_destino_observacion'                        => trim(strtoupper(strtolower($rowMSSQL00['localidad_pais_destino_observacion'])))
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle    = array(
                        'solicitud_detalle_vuelo_codigo'                            => '',
                        'solicitud_detalle_vuelo_comentario'                        => '',
                        'solicitud_detalle_vuelo_fecha_salida_1'                    => '',
                        'solicitud_detalle_vuelo_fecha_salida_2'                    => '',
                        'solicitud_detalle_vuelo_fecha_retorno_1'                   => '',
                        'solicitud_detalle_vuelo_fecha_retorno_2'                   => '',

                        'tipo_vuelo_codigo'                                         => '',
                        'tipo_vuelo_nombre'                                         => '',

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

                        'tipo_horario_salida_codigo'                                => '',
                        'tipo_horario_salida_ingles'                                => '',
                        'tipo_horario_salida_castellano'                            => '',
                        'tipo_horario_salida_portugues'                             => '',
                        'tipo_horario_salida_parametro'                             => '',
                        'tipo_horario_salida_icono'                                 => '',
                        'tipo_horario_salida_css'                                   => '',

                        'tipo_horario_retorno_codigo'                               => '',
                        'tipo_horario_retorno_ingles'                               => '',
                        'tipo_horario_retorno_castellano'                           => '',
                        'tipo_horario_retorno_portugues'                            => '',
                        'tipo_horario_retorno_parametro'                            => '',
                        'tipo_horario_retorno_icono'                                => '',
                        'tipo_horario_retorno_css'                                  => '',

                        'solicitud_codigo'                                          => '',
                        'solicitud_periodo'                                         => '',
                        'solicitud_motivo'                                          => '',
                        'solicitud_vuelo'                                           => '',
                        'solicitud_hospedaje'                                       => '',
                        'solicitud_traslado'                                        => '',
                        'solicitud_solicitante_tarifa_vuelo'                        => '',
                        'solicitud_solicitante_tarifa_hospedaje'                    => '',
                        'solicitud_solicitante_tarifa_traslado'                     => '',
                        'solicitud_proveedor_carga_hospedaje'                       => '',
                        'solicitud_proveedor_carga_hospedaje'                       => '',
                        'solicitud_proveedor_carga_traslado'                        => '',
                        'solicitud_fecha_carga_1'                                   => '',
                        'solicitud_fecha_carga_2'                                   => '',
                        'solicitud_sap_centro_costo'                                => '',
                        'solicitud_tarea_cantidad'                                  => '',
                        'solicitud_tarea_resuelta'                                  => '',
                        'solicitud_tarea_porcentaje'                                => '',
                        'solicitud_solicitante_nombre'                              => '',
                        'solicitud_solicitante_documento'                           => '',
                        'solicitud_jefatura_nombre'                                 => '',
                        'solicitud_jefatura_documento'                              => '',
                        'solicitud_ejecutivo_nombre'                                => '',
                        'solicitud_ejecutivo_documento'                             => '',
                        'solicitud_proveedor_nombre'                                => '',
                        'solicitud_proveedor_documento'                             => '',
                        'solicitud_observacion'                                     => '',

                        'localidad_ciudad_origen_codigo'                            => '',
                        'localidad_ciudad_origen_orden'                             => '',
                        'localidad_ciudad_origen_nombre'                            => '',
                        'localidad_ciudad_origen_observacion'                       => '',

                        'localidad_pais_origen_codigo'                              => '',
                        'localidad_pais_origen_orden'                               => '',
                        'localidad_pais_origen_nombre'                              => '',
                        'localidad_pais_origen_path'                                => '',
                        'localidad_pais_origen_iso_char2'                           => '',
                        'localidad_pais_origen_iso_char3'                           => '',
                        'localidad_pais_origen_iso_num3'                            => '',
                        'localidad_pais_origen_observacion'                         => '',

                        'localidad_ciudad_destino_codigo'                           => '',
                        'localidad_ciudad_destino_orden'                            => '',
                        'localidad_ciudad_destino_nombre'                           => '',
                        'localidad_ciudad_destino_observacion'                      => '',

                        'localidad_pais_destino_codigo'                             => '',
                        'localidad_pais_destino_orden'                              => '',
                        'localidad_pais_destino_nombre'                             => '',
                        'localidad_pais_destino_path'                               => '',
                        'localidad_pais_destino_iso_char2'                          => '',
                        'localidad_pais_destino_iso_char3'                          => '',
                        'localidad_pais_destino_iso_num3'                           => '',
                        'localidad_pais_destino_observacion'                        => ''
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

    $app->get('/v2/400/solicitud/historico/vuelo/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val01  = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
                a.SOLHVUIDD         AS          historico_vuelo_id,
                a.SOLHVUAME         AS          historico_vuelo_metodo,
                a.SOLHVUCOD         AS          historico_vuelo_codigo,
                a.SOLHVUCOM         AS          historico_vuelo_comentario,
                a.SOLHVUFSA         AS          historico_vuelo_fecha_salida,
                a.SOLHVUFRE         AS          historico_vuelo_fecha_retorno,

                a.SOLHVUTVC         AS          tipo_vuelo_codigo,

                a.SOLHVUAUS         AS          auditoria_usuario,
                a.SOLHVUAFH         AS          auditoria_fecha_hora,
                a.SOLHVUAIP         AS          auditoria_ip,

                b.DOMFICCOD         AS          tipo_estado_codigo,
                b.DOMFICNOI         AS          tipo_estado_ingles,
                b.DOMFICNOC         AS          tipo_estado_castellano,
                b.DOMFICNOP         AS          tipo_estado_portugues,
                b.DOMFICPAR         AS          tipo_estado_parametro,
                b.DOMFICICO         AS          tipo_estado_icono,
                b.DOMFICCSS         AS          tipo_estado_css,

                c.DOMFICCOD         AS          tipo_horario_salida_codigo,
                c.DOMFICNOI         AS          tipo_horario_salida_ingles,
                c.DOMFICNOC         AS          tipo_horario_salida_castellano,
                c.DOMFICNOP         AS          tipo_horario_salida_portugues,
                c.DOMFICPAR         AS          tipo_horario_salida_parametro,
                c.DOMFICICO         AS          tipo_horario_salida_icono,
                c.DOMFICCSS         AS          tipo_horario_salida_css,

                d.DOMFICCOD         AS          tipo_horario_retorno_codigo,
                d.DOMFICNOI         AS          tipo_horario_retorno_ingles,
                d.DOMFICNOC         AS          tipo_horario_retorno_castellano,
                d.DOMFICNOP         AS          tipo_horario_retorno_portugues,
                d.DOMFICPAR         AS          tipo_horario_retorno_parametro,
                d.DOMFICICO         AS          tipo_horario_retorno_icono,
                d.DOMFICCSS         AS          tipo_horario_retorno_css,

                e.SOLFICCOD         AS          solicitud_codigo,
                e.SOLFICPER         AS          solicitud_periodo,
                e.SOLFICMOT         AS          solicitud_motivo,
                e.SOLFICVUE         AS          solicitud_vuelo,
                e.SOLFICHOS         AS          solicitud_hospedaje,
                e.SOLFICTRA         AS          solicitud_traslado,
                e.SOLFICSTV         AS          solicitud_solicitante_tarifa_vuelo,
                e.SOLFICSTH         AS          solicitud_solicitante_tarifa_hospedaje,
                e.SOLFICSTT         AS          solicitud_solicitante_tarifa_traslado,
                e.SOLFICPCV         AS          solicitud_proveedor_carga_vuelo,
                e.SOLFICPCH         AS          solicitud_proveedor_carga_hospedaje,
                e.SOLFICPCT         AS          solicitud_proveedor_carga_traslado,
                e.SOLFICFEC         AS          solicitud_fecha_carga,
                e.SOLFICSCC         AS          solicitud_sap_centro_costo,
                e.SOLFICTCA         AS          solicitud_tarea_cantidad,
                e.SOLFICTRE         AS          solicitud_tarea_resuelta,
                e.SOLFICOBS         AS          solicitud_observacion,

                f1.LOCCIUCOD        AS          localidad_ciudad_origen_codigo,
                f1.LOCCIUORD        AS          localidad_ciudad_origen_orden,
                f1.LOCCIUNOM        AS          localidad_ciudad_origen_nombre,
                f1.LOCCIUOBS        AS          localidad_ciudad_origen_observacion,

                g1.LOCPAICOD        AS          localidad_pais_origen_codigo,
                g1.LOCPAIORD        AS          localidad_pais_origen_orden,
                g1.LOCPAINOM        AS          localidad_pais_origen_nombre,
                g1.LOCPAIPAT        AS          localidad_pais_origen_path,
                g1.LOCPAIIC2        AS          localidad_pais_origen_iso_char2,
                g1.LOCPAIIC3        AS          localidad_pais_origen_iso_char3,
                g1.LOCPAIIN3        AS          localidad_pais_origen_iso_num3,
                g1.LOCPAIOBS        AS          localidad_pais_origen_observacion,

                f2.LOCCIUCOD        AS          localidad_ciudad_destino_codigo,
                f2.LOCCIUORD        AS          localidad_ciudad_destino_orden,
                f2.LOCCIUNOM        AS          localidad_ciudad_destino_nombre,
                f2.LOCCIUOBS        AS          localidad_ciudad_destino_observacion,

                g2.LOCPAICOD        AS          localidad_pais_destino_codigo,
                g2.LOCPAIORD        AS          localidad_pais_destino_orden,
                g2.LOCPAINOM        AS          localidad_pais_destino_nombre,
                g2.LOCPAIPAT        AS          localidad_pais_destino_path,
                g2.LOCPAIIC2        AS          localidad_pais_destino_iso_char2,
                g2.LOCPAIIC3        AS          localidad_pais_destino_iso_char3,
                g2.LOCPAIIN3        AS          localidad_pais_destino_iso_num3,
                g2.LOCPAIOBS        AS          localidad_pais_destino_observacion

                FROM [via].[SOLHVU] a
                INNER JOIN [adm].[DOMFIC] b ON a.SOLHVUEST = b.DOMFICCOD
                INNER JOIN [adm].[DOMFIC] c ON a.SOLHVUTSC = c.DOMFICCOD
                INNER JOIN [adm].[DOMFIC] d ON a.SOLHVUTRC = d.DOMFICCOD
                INNER JOIN [via].[SOLFIC] e ON a.SOLHVUSOC = e.SOLFICCOD
                LEFT OUTER JOIN [adm].[LOCCIU] f1 ON a.SOLHVUCOC = f1.LOCCIUCOD
                LEFT OUTER JOIN [adm].[LOCPAI] g1 ON f1.LOCCIUPAC = g1.LOCPAICOD
                LEFT OUTER JOIN [adm].[LOCCIU] f2 ON a.SOLHVUCDC = f2.LOCCIUCOD
                LEFT OUTER JOIN [adm].[LOCPAI] g2 ON f2.LOCCIUPAC = g2.LOCPAICOD

                WHERE a.SOLHVUSOC = ?
                
                ORDER BY a.SOLHVUIDD";

            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val01]);

                while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                    if(!empty($rowMSSQL00['historico_vuelo_fecha_salida'])){
                        $historico_vuelo_fecha_salida_1 = $rowMSSQL00['historico_vuelo_fecha_salida'];
                        $historico_vuelo_fecha_salida_2 = date("d/m/Y", strtotime($rowMSSQL00['historico_vuelo_fecha_salida']));
                    } else {
                        $historico_vuelo_fecha_salida_1    = '';
                        $historico_vuelo_fecha_salida_2    = '';
                    }

                    if(!empty($rowMSSQL00['historico_vuelo_fecha_retorno'])){
                        $historico_vuelo_fecha_retorno_1    = $rowMSSQL00['historico_vuelo_fecha_retorno'];
                        $historico_vuelo_fecha_retorno_2    = date("d/m/Y", strtotime($rowMSSQL00['historico_vuelo_fecha_retorno']));
                    } else {
                        $historico_vuelo_fecha_retorno_1    = '';
                        $historico_vuelo_fecha_retorno_2    = '';
                    }

                    if(!empty($rowMSSQL00['solicitud_fecha_carga'])){
                        $solicitud_fecha_carga_1    = $rowMSSQL00['solicitud_fecha_carga'];
                        $solicitud_fecha_carga_2    = date("d/m/Y", strtotime($rowMSSQL00['solicitud_fecha_carga']));
                    } else {
                        $solicitud_fecha_carga_1    = '';
                        $solicitud_fecha_carga_2    = '';
                    }

                    if ($rowMSSQL00['tipo_vuelo_codigo'] == 'R'){
                        $tipo_vuelo_nombre = 'ROUNDTRIP';
                    } else {
                        $tipo_vuelo_nombre = 'ONE-WAY';
                    }

                    $detalle = array(
                        'historico_vuelo_id'                                        => $rowMSSQL00['historico_vuelo_id'],
                        'historico_vuelo_metodo'                                    => trim($rowMSSQL00['historico_vuelo_metodo']),
                        'historico_vuelo_codigo'                                    => $rowMSSQL00['historico_vuelo_codigo'],
                        'historico_vuelo_comentario'                                => trim($rowMSSQL00['historico_vuelo_comentario']),
                        'historico_vuelo_fecha_salida_1'                            => $historico_vuelo_fecha_salida_1,
                        'historico_vuelo_fecha_salida_2'                            => $historico_vuelo_fecha_salida_2,
                        'historico_vuelo_fecha_retorno_1'                           => $historico_vuelo_fecha_retorno_1,
                        'historico_vuelo_fecha_retorno_2'                           => $historico_vuelo_fecha_retorno_2,

                        'tipo_vuelo_codigo'                                         => trim(strtoupper(strtolower($rowMSSQL00['tipo_vuelo_codigo']))),
                        'tipo_vuelo_nombre'                                         => $tipo_vuelo_nombre,

                        'auditoria_usuario'                                         => trim(strtoupper(strtolower($rowMSSQL00['auditoria_usuario']))),
                        'auditoria_fecha_hora'                                      => date("d/m/Y H:i:s", strtotime($rowMSSQL00['auditoria_fecha_hora'])),
                        'auditoria_ip'                                              => trim(strtoupper(strtolower($rowMSSQL00['auditoria_ip']))),

                        'tipo_estado_codigo'                                        => $rowMSSQL00['tipo_estado_codigo'],
                        'tipo_estado_ingles'                                        => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_ingles']))),
                        'tipo_estado_castellano'                                    => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_castellano']))),
                        'tipo_estado_portugues'                                     => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_portugues']))),
                        'tipo_estado_parametro'                                     => $rowMSSQL00['tipo_estado_parametro'],
                        'tipo_estado_icono'                                         => trim(strtolower($rowMSSQL00['tipo_estado_icono'])),
                        'tipo_estado_css'                                           => trim(strtolower($rowMSSQL00['tipo_estado_css'])),

                        'tipo_horario_salida_codigo'                                => $rowMSSQL00['tipo_horario_salida_codigo'],
                        'tipo_horario_salida_ingles'                                => trim(strtoupper(strtolower($rowMSSQL00['tipo_horario_salida_ingles']))),
                        'tipo_horario_salida_castellano'                            => trim(strtoupper(strtolower($rowMSSQL00['tipo_horario_salida_castellano']))),
                        'tipo_horario_salida_portugues'                             => trim(strtoupper(strtolower($rowMSSQL00['tipo_horario_salida_portugues']))),
                        'tipo_horario_salida_parametro'                             => $rowMSSQL00['tipo_horario_salida_parametro'],
                        'tipo_horario_salida_icono'                                 => trim(strtolower($rowMSSQL00['tipo_horario_salida_icono'])),
                        'tipo_horario_salida_css'                                   => trim(strtolower($rowMSSQL00['tipo_horario_salida_css'])),

                        'tipo_horario_retorno_codigo'                               => $rowMSSQL00['tipo_horario_retorno_codigo'],
                        'tipo_horario_retorno_ingles'                               => trim(strtoupper(strtolower($rowMSSQL00['tipo_horario_retorno_ingles']))),
                        'tipo_horario_retorno_castellano'                           => trim(strtoupper(strtolower($rowMSSQL00['tipo_horario_retorno_castellano']))),
                        'tipo_horario_retorno_portugues'                            => trim(strtoupper(strtolower($rowMSSQL00['tipo_horario_retorno_portugues']))),
                        'tipo_horario_retorno_parametro'                            => $rowMSSQL00['tipo_horario_retorno_parametro'],
                        'tipo_horario_retorno_icono'                                => trim(strtolower($rowMSSQL00['tipo_horario_retorno_icono'])),
                        'tipo_horario_retorno_css'                                  => trim(strtolower($rowMSSQL00['tipo_horario_retorno_css'])),

                        'solicitud_codigo'                                          => $rowMSSQL00['solicitud_codigo'],
                        'solicitud_periodo'                                         => $rowMSSQL00['solicitud_periodo'],
                        'solicitud_motivo'                                          => trim(strtoupper(strtolower($rowMSSQL00['solicitud_motivo']))),
                        'solicitud_vuelo'                                           => trim(strtoupper(strtolower($rowMSSQL00['solicitud_vuelo']))),
                        'solicitud_hospedaje'                                       => trim(strtoupper(strtolower($rowMSSQL00['solicitud_hospedaje']))),
                        'solicitud_traslado'                                        => trim(strtoupper(strtolower($rowMSSQL00['solicitud_traslado']))),
                        'solicitud_solicitante_tarifa_vuelo'                        => trim(strtoupper(strtolower($rowMSSQL00['solicitud_solicitante_tarifa_vuelo']))),
                        'solicitud_solicitante_tarifa_hospedaje'                    => trim(strtoupper(strtolower($rowMSSQL00['solicitud_solicitante_tarifa_hospedaje']))),
                        'solicitud_solicitante_tarifa_traslado'                     => trim(strtoupper(strtolower($rowMSSQL00['solicitud_solicitante_tarifa_traslado']))),
                        'solicitud_proveedor_carga_hospedaje'                       => trim(strtoupper(strtolower($rowMSSQL00['solicitud_proveedor_carga_hospedaje']))),
                        'solicitud_proveedor_carga_hospedaje'                       => trim(strtoupper(strtolower($rowMSSQL00['solicitud_proveedor_carga_hospedaje']))),
                        'solicitud_proveedor_carga_traslado'                        => trim(strtoupper(strtolower($rowMSSQL00['solicitud_proveedor_carga_traslado']))),
                        'solicitud_fecha_carga_1'                                   => $solicitud_fecha_carga_1,
                        'solicitud_fecha_carga_2'                                   => $solicitud_fecha_carga_2,
                        'solicitud_sap_centro_costo'                                => trim(strtoupper(strtolower($rowMSSQL00['solicitud_sap_centro_costo']))),
                        'solicitud_tarea_cantidad'                                  => $rowMSSQL00['solicitud_tarea_cantidad'],
                        'solicitud_tarea_resuelta'                                  => $rowMSSQL00['solicitud_tarea_resuelta'],
                        'solicitud_tarea_porcentaje'                                => number_format((($rowMSSQL00['solicitud_tarea_resuelta'] * 100) / $rowMSSQL00['solicitud_tarea_cantidad']), 2, '.', ''),
                        'solicitud_solicitante_nombre'                              => trim(strtoupper(strtolower($rowMSSQL00['solicitud_solicitante_nombre']))),
                        'solicitud_solicitante_documento'                           => trim(strtoupper(strtolower($rowMSSQL00['solicitud_solicitante_documento']))),
                        'solicitud_jefatura_nombre'                                 => trim(strtoupper(strtolower($rowMSSQL00['solicitud_jefatura_nombre']))),
                        'solicitud_jefatura_documento'                              => trim(strtoupper(strtolower($rowMSSQL00['solicitud_jefatura_documento']))),
                        'solicitud_ejecutivo_nombre'                                => trim(strtoupper(strtolower($rowMSSQL00['solicitud_ejecutivo_nombre']))),
                        'solicitud_ejecutivo_documento'                             => trim(strtoupper(strtolower($rowMSSQL00['solicitud_ejecutivo_documento']))),
                        'solicitud_proveedor_nombre'                                => trim(strtoupper(strtolower($rowMSSQL00['solicitud_proveedor_nombre']))),
                        'solicitud_proveedor_documento'                             => trim(strtoupper(strtolower($rowMSSQL00['solicitud_proveedor_documento']))),
                        'solicitud_observacion'                                     => trim(strtoupper(strtolower($rowMSSQL00['solicitud_observacion']))),

                        'localidad_ciudad_origen_codigo'                            => $rowMSSQL00['localidad_ciudad_origen_codigo'],
                        'localidad_ciudad_origen_orden'                             => $rowMSSQL00['localidad_ciudad_origen_orden'],
                        'localidad_ciudad_origen_nombre'                            => trim(strtoupper(strtolower($rowMSSQL00['localidad_ciudad_origen_nombre']))),
                        'localidad_ciudad_origen_observacion'                       => trim(strtolower($rowMSSQL00['localidad_ciudad_origen_observacion'])),

                        'localidad_pais_origen_codigo'                              => $rowMSSQL00['localidad_pais_origen_codigo'],
                        'localidad_pais_origen_orden'                               => $rowMSSQL00['localidad_pais_origen_orden'],
                        'localidad_pais_origen_nombre'                              => trim(strtoupper(strtolower($rowMSSQL00['localidad_pais_origen_nombre']))),
                        'localidad_pais_origen_path'                                => trim(strtolower($rowMSSQL00['localidad_pais_origen_path'])),
                        'localidad_pais_origen_iso_char2'                           => trim(strtoupper(strtolower($rowMSSQL00['localidad_pais_origen_iso_char2']))),
                        'localidad_pais_origen_iso_char3'                           => trim(strtoupper(strtolower($rowMSSQL00['localidad_pais_origen_iso_char3']))),
                        'localidad_pais_origen_iso_num3'                            => trim(strtoupper(strtolower($rowMSSQL00['localidad_pais_origen_iso_num3']))),
                        'localidad_pais_origen_observacion'                         => trim(strtoupper(strtolower($rowMSSQL00['localidad_pais_origen_observacion']))),

                        'localidad_ciudad_destino_codigo'                           => $rowMSSQL00['localidad_ciudad_destino_codigo'],
                        'localidad_ciudad_destino_orden'                            => $rowMSSQL00['localidad_ciudad_destino_orden'],
                        'localidad_ciudad_destino_nombre'                           => trim(strtoupper(strtolower($rowMSSQL00['localidad_ciudad_destino_nombre']))),
                        'localidad_ciudad_destino_observacion'                      => trim(strtolower($rowMSSQL00['localidad_ciudad_destino_observacion'])),

                        'localidad_pais_destino_codigo'                             => $rowMSSQL00['localidad_pais_destino_codigo'],
                        'localidad_pais_destino_orden'                              => $rowMSSQL00['localidad_pais_destino_orden'],
                        'localidad_pais_destino_nombre'                             => trim(strtoupper(strtolower($rowMSSQL00['localidad_pais_destino_nombre']))),
                        'localidad_pais_destino_path'                               => trim(strtolower($rowMSSQL00['localidad_pais_destino_path'])),
                        'localidad_pais_destino_iso_char2'                          => trim(strtoupper(strtolower($rowMSSQL00['localidad_pais_destino_iso_char2']))),
                        'localidad_pais_destino_iso_char3'                          => trim(strtoupper(strtolower($rowMSSQL00['localidad_pais_destino_iso_char3']))),
                        'localidad_pais_destino_iso_num3'                           => trim(strtoupper(strtolower($rowMSSQL00['localidad_pais_destino_iso_num3']))),
                        'localidad_pais_destino_observacion'                        => trim(strtoupper(strtolower($rowMSSQL00['localidad_pais_destino_observacion'])))
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle    = array(
                        'historico_vuelo_id'                                        => '',
                        'historico_vuelo_metodo'                                    => '',
                        'historico_vuelo_codigo'                                    => '',
                        'historico_vuelo_comentario'                                => '',
                        'historico_vuelo_fecha_salida_1'                            => '',
                        'historico_vuelo_fecha_salida_2'                            => '',
                        'historico_vuelo_fecha_retorno_1'                           => '',
                        'historico_vuelo_fecha_retorno_2'                           => '',

                        'tipo_vuelo_codigo'                                         => '',
                        'tipo_vuelo_nombre'                                         => '',

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

                        'tipo_horario_salida_codigo'                                => '',
                        'tipo_horario_salida_ingles'                                => '',
                        'tipo_horario_salida_castellano'                            => '',
                        'tipo_horario_salida_portugues'                             => '',
                        'tipo_horario_salida_parametro'                             => '',
                        'tipo_horario_salida_icono'                                 => '',
                        'tipo_horario_salida_css'                                   => '',

                        'tipo_horario_retorno_codigo'                               => '',
                        'tipo_horario_retorno_ingles'                               => '',
                        'tipo_horario_retorno_castellano'                           => '',
                        'tipo_horario_retorno_portugues'                            => '',
                        'tipo_horario_retorno_parametro'                            => '',
                        'tipo_horario_retorno_icono'                                => '',
                        'tipo_horario_retorno_css'                                  => '',

                        'solicitud_codigo'                                          => '',
                        'solicitud_periodo'                                         => '',
                        'solicitud_motivo'                                          => '',
                        'solicitud_vuelo'                                           => '',
                        'solicitud_hospedaje'                                       => '',
                        'solicitud_traslado'                                        => '',
                        'solicitud_solicitante_tarifa_vuelo'                        => '',
                        'solicitud_solicitante_tarifa_hospedaje'                    => '',
                        'solicitud_solicitante_tarifa_traslado'                     => '',
                        'solicitud_proveedor_carga_hospedaje'                       => '',
                        'solicitud_proveedor_carga_hospedaje'                       => '',
                        'solicitud_proveedor_carga_traslado'                        => '',
                        'solicitud_fecha_carga_1'                                   => '',
                        'solicitud_fecha_carga_2'                                   => '',
                        'solicitud_sap_centro_costo'                                => '',
                        'solicitud_tarea_cantidad'                                  => '',
                        'solicitud_tarea_resuelta'                                  => '',
                        'solicitud_tarea_porcentaje'                                => '',
                        'solicitud_solicitante_nombre'                              => '',
                        'solicitud_solicitante_documento'                           => '',
                        'solicitud_jefatura_nombre'                                 => '',
                        'solicitud_jefatura_documento'                              => '',
                        'solicitud_ejecutivo_nombre'                                => '',
                        'solicitud_ejecutivo_documento'                             => '',
                        'solicitud_proveedor_nombre'                                => '',
                        'solicitud_proveedor_documento'                             => '',
                        'solicitud_observacion'                                     => '',

                        'localidad_ciudad_origen_codigo'                            => '',
                        'localidad_ciudad_origen_orden'                             => '',
                        'localidad_ciudad_origen_nombre'                            => '',
                        'localidad_ciudad_origen_observacion'                       => '',

                        'localidad_pais_origen_codigo'                              => '',
                        'localidad_pais_origen_orden'                               => '',
                        'localidad_pais_origen_nombre'                              => '',
                        'localidad_pais_origen_path'                                => '',
                        'localidad_pais_origen_iso_char2'                           => '',
                        'localidad_pais_origen_iso_char3'                           => '',
                        'localidad_pais_origen_iso_num3'                            => '',
                        'localidad_pais_origen_observacion'                         => '',

                        'localidad_ciudad_destino_codigo'                           => '',
                        'localidad_ciudad_destino_orden'                            => '',
                        'localidad_ciudad_destino_nombre'                           => '',
                        'localidad_ciudad_destino_observacion'                      => '',

                        'localidad_pais_destino_codigo'                             => '',
                        'localidad_pais_destino_orden'                              => '',
                        'localidad_pais_destino_nombre'                             => '',
                        'localidad_pais_destino_path'                               => '',
                        'localidad_pais_destino_iso_char2'                          => '',
                        'localidad_pais_destino_iso_char3'                          => '',
                        'localidad_pais_destino_iso_num3'                           => '',
                        'localidad_pais_destino_observacion'                        => ''
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
    
    $app->get('/v2/400/solicitud/detalle/hospedaje/{codigo}', function($request) {//20201102
        require __DIR__.'/../src/connect.php';
        
        $val01  = $request->getAttribute('codigo');
        
        if (isset($val01)) {
                $sql00  = "SELECT 
                    a.SOLHOSCOD         AS          solicitud_detalle_hospedaje_codigo,
                    a.SOLHOSCOM         AS          solicitud_detalle_hospedaje_comentario,   
                    a.SOLHOSALI         AS          solicitud_detalle_hospedaje_alimentacion,	
                    a.SOLHOSLAV	        AS          solicitud_detalle_hospedaje_lavanderia,
                    a.SOLHOSFIN         AS          solicitud_detalle_hospedaje_fecha_checkin,	
                    a.SOLHOSFOU         AS          solicitud_detalle_hospedaje_fecha_checkout,
                    a.SOLHOSCNO	        AS          solicitud_detalle_hospedaje_cantidad_noche,

                    a.SOLHOSAUS	        AS          auditoria_usuario,
                    a.SOLHOSAFH         AS          auditoria_fecha_hora,	
                    a.SOLHOSAIP         AS          auditoria_ip,
                    
                    b.DOMFICCOD         AS          tipo_estado_codigo,
                    b.DOMFICNOI         AS          tipo_estado_ingles,
                    b.DOMFICNOC         AS          tipo_estado_castellano,
                    b.DOMFICNOP         AS          tipo_estado_portugues,
                    b.DOMFICPAR         AS          tipo_estado_parametro,
                    b.DOMFICICO         AS          tipo_estado_icono,
                    b.DOMFICCSS         AS          tipo_estado_css,
                    
                    c.SOLFICCOD         AS          solicitud_codigo,
                    c.SOLFICPER         AS          solicitud_periodo,
                    c.SOLFICMOT         AS          solicitud_motivo,
                    c.SOLFICVUE         AS          solicitud_vuelo,
                    c.SOLFICHOS         AS          solicitud_hospedaje,
                    c.SOLFICTRA         AS          solicitud_traslado,
                    c.SOLFICSTV         AS          solicitud_solicitante_tarifa_vuelo,
                    c.SOLFICSTH         AS          solicitud_solicitante_tarifa_hospedaje,
                    c.SOLFICSTT         AS          solicitud_solicitante_tarifa_traslado,
                    c.SOLFICPCV         AS          solicitud_proveedor_carga_vuelo,
                    c.SOLFICPCH         AS          solicitud_proveedor_carga_hospedaje,
                    c.SOLFICPCT		    AS	        solicitud_proveedor_carga_traslado,
                    c.SOLFICFEC         AS          solicitud_fecha_carga,
                    c.SOLFICSCC         AS          solicitud_sap_centro_costo,
                    c.SOLFICTCA         AS          solicitud_tarea_cantidad,
                    c.SOLFICTRE         AS          solicitud_tarea_resuelta,
                    c.SOLFICOBS         AS          solicitud_observacion,

                    h1.NombreEmpleado   AS          solicitud_solicitante_nombre,
                    c.SOLFICDNS         AS          solicitud_solicitante_documento,
                    h2.NombreEmpleado   AS          solicitud_jefatura_nombre,
                    c.SOLFICDNJ         AS          solicitud_jefatura_documento,
                    h3.NombreEmpleado   AS          solicitud_ejecutivo_nombre,
                    c.SOLFICDNE         AS          solicitud_ejecutivo_documento,
                    h4.NombreEmpleado   AS          solicitud_proveedor_nombre,
                    c.SOLFICDNP         AS          solicitud_proveedor_documento,
                    
                    d2.LOCCIUCOD        AS          localidad_ciudad_destino_codigo,
                    d2.LOCCIUORD        AS          localidad_ciudad_destino_orden,
                    d2.LOCCIUNOM        AS          localidad_ciudad_destino_nombre,
                    d2.LOCCIUOBS        AS          localidad_ciudad_destino_observacion,

                    e2.LOCPAICOD        AS          localidad_pais_destino_codigo,
                    e2.LOCPAIORD        AS          localidad_pais_destino_orden,
                    e2.LOCPAINOM        AS          localidad_pais_destino_nombre,
                    e2.LOCPAIPAT        AS          localidad_pais_destino_path,
                    e2.LOCPAIIC2        AS          localidad_pais_destino_iso_char2,
                    e2.LOCPAIIC3        AS          localidad_pais_destino_iso_char3,
                    e2.LOCPAIIN3        AS          localidad_pais_destino_iso_num3,
                    e2.LOCPAIOBS        AS          localidad_pais_destino_observacion

                    FROM via.SOLHOS a
                    INNER JOIN adm.DOMFIC b ON a.SOLHOSEST = b.DOMFICCOD
                    INNER JOIN via.SOLFIC c ON a.SOLHOSSOC = c.SOLFICCOD
                    INNER JOIN adm.LOCCIU d2 ON a.SOLHOSCDC = d2.LOCCIUCOD
                    LEFT OUTER JOIN [adm].[LOCPAI] e2 ON d2.LOCCIUPAC = e2.LOCPAICOD
                    LEFT OUTER JOIN [CSF].[dbo].[empleados_AxisONE] h1 ON c.SOLFICDNS COLLATE SQL_Latin1_General_CP1_CI_AS = h1.CedulaEmpleado
                    LEFT OUTER JOIN [CSF].[dbo].[empleados_AxisONE] h2 ON c.SOLFICDNJ COLLATE SQL_Latin1_General_CP1_CI_AS = h2.CedulaEmpleado
                    LEFT OUTER JOIN [CSF].[dbo].[empleados_AxisONE] h3 ON c.SOLFICDNE COLLATE SQL_Latin1_General_CP1_CI_AS = h3.CedulaEmpleado
                    LEFT OUTER JOIN [CSF].[dbo].[empleados_AxisONE] h4 ON c.SOLFICDNP COLLATE SQL_Latin1_General_CP1_CI_AS = h4.CedulaEmpleado
                    
                    WHERE a.SOLHOSSOC = ?

                    ORDER BY a.SOLHOSCOD";

            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val01]);

                while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {

                    if ($rowMSSQL00['solicitud_detalle_hospedaje_fecha_checkin'] == '1900-01-01' || $rowMSSQL00['solicitud_detalle_hospedaje_fecha_checkin'] == null){
                        $solicitud_detalle_hospedaje_fecha_checkin_1 = '';
                        $solicitud_detalle_hospedaje_fecha_checkin_2 = '';
                    } else {
                        $solicitud_detalle_hospedaje_fecha_checkin_1 = $rowMSSQL00['solicitud_detalle_hospedaje_fecha_checkin'];
                        $solicitud_detalle_hospedaje_fecha_checkin_2 = date('d/m/Y', strtotime($rowMSSQL00['solicitud_detalle_hospedaje_fecha_checkin']));
                    }

                    if ($rowMSSQL00['solicitud_detalle_hospedaje_fecha_checkout'] == '1900-01-01' || $rowMSSQL00['solicitud_detalle_hospedaje_fecha_checkout'] == null){
                        $solicitud_detalle_hospedaje_fecha_checkout_1 = '';
                        $solicitud_detalle_hospedaje_fecha_checkout_2 = '';
                    } else {
                        $solicitud_detalle_hospedaje_fecha_checkout_1 = $rowMSSQL00['solicitud_detalle_hospedaje_fecha_checkout'];
                        $solicitud_detalle_hospedaje_fecha_checkout_2 = date('d/m/Y', strtotime($rowMSSQL00['solicitud_detalle_hospedaje_fecha_checkout']));
                    }
                    
                    if ($rowMSSQL00['solicitud_fecha_carga'] == '1900-01-01' || $rowMSSQL00['solicitud_fecha_carga'] == null){
                        $solicitud_fecha_carga_1 = '';
                        $solicitud_fecha_carga_2 = '';
                    } else {
                        $solicitud_fecha_carga_1 = $rowMSSQL00['solicitud_fecha_carga'];
                        $solicitud_fecha_carga_2 = date('d/m/Y', strtotime($rowMSSQL00['solicitud_fecha_carga']));
                    }

                    $detalle = array(
                        'solicitud_detalle_hospedaje_codigo'                        => $rowMSSQL00['solicitud_detalle_hospedaje_codigo'],
                        'solicitud_detalle_hospedaje_comentario'                    => trim(strtoupper(strtolower($rowMSSQL00['solicitud_detalle_hospedaje_comentario']))),
                        'solicitud_detalle_hospedaje_alimentacion'                  => trim(strtoupper(strtolower($rowMSSQL00['solicitud_detalle_hospedaje_alimentacion']))),
                        'solicitud_detalle_hospedaje_lavanderia'                    => trim(strtoupper(strtolower($rowMSSQL00['solicitud_detalle_hospedaje_lavanderia']))),
                        'solicitud_detalle_hospedaje_fecha_checkin_1'               => $solicitud_detalle_hospedaje_fecha_checkin_1,
                        'solicitud_detalle_hospedaje_fecha_checkin_2'               => $solicitud_detalle_hospedaje_fecha_checkin_2,
                        'solicitud_detalle_hospedaje_fecha_checkout_1'              => $solicitud_detalle_hospedaje_fecha_checkout_1,
                        'solicitud_detalle_hospedaje_fecha_checkout_2'              => $solicitud_detalle_hospedaje_fecha_checkout_2,
                        'solicitud_detalle_hospedaje_cantidad_noche'                => $rowMSSQL00['solicitud_detalle_hospedaje_cantidad_noche'],
                        
                        'auditoria_usuario'                                         => trim(strtoupper(strtolower($rowMSSQL00['auditoria_usuario']))),
                        'auditoria_fecha_hora'                                      => date("d/m/Y H:i:s", strtotime($rowMSSQL00['auditoria_fecha_hora'])),
                        'auditoria_ip'                                              => trim(strtoupper(strtolower($rowMSSQL00['auditoria_ip']))),

                        'tipo_estado_codigo'                                        => $rowMSSQL00['tipo_estado_codigo'],
                        'tipo_estado_ingles'                                        => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_ingles']))),
                        'tipo_estado_castellano'                                    => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_castellano']))),
                        'tipo_estado_portugues'                                     => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_portugues']))),
                        'tipo_estado_parametro'                                     => $rowMSSQL00['tipo_estado_parametro'],
                        'tipo_estado_icono'                                         => trim(strtolower($rowMSSQL00['tipo_estado_icono'])),
                        'tipo_estado_css'                                           => trim(strtolower($rowMSSQL00['tipo_estado_css'])),

                        'solicitud_codigo'                                          => $rowMSSQL00['solicitud_codigo'],
                        'solicitud_periodo'                                         => $rowMSSQL00['solicitud_periodo'],
                        'solicitud_motivo'                                          => trim(strtoupper(strtolower($rowMSSQL00['solicitud_motivo']))),
                        'solicitud_vuelo'                                           => trim(strtoupper(strtolower($rowMSSQL00['solicitud_vuelo']))),
                        'solicitud_hospedaje'                                       => trim(strtoupper(strtolower($rowMSSQL00['solicitud_hospedaje']))),
                        'solicitud_traslado'                                        => trim(strtoupper(strtolower($rowMSSQL00['solicitud_traslado']))),
                        'solicitud_solicitante_tarifa_vuelo'                        => trim(strtoupper(strtolower($rowMSSQL00['solicitud_solicitante_tarifa_vuelo']))),
                        'solicitud_solicitante_tarifa_hospedaje'                    => trim(strtoupper(strtolower($rowMSSQL00['solicitud_solicitante_tarifa_hospedaje']))),
                        'solicitud_solicitante_tarifa_traslado'                     => trim(strtoupper(strtolower($rowMSSQL00['solicitud_solicitante_tarifa_traslado']))),
                        'solicitud_proveedor_carga_hospedaje'                       => trim(strtoupper(strtolower($rowMSSQL00['solicitud_proveedor_carga_hospedaje']))),
                        'solicitud_proveedor_carga_hospedaje'                       => trim(strtoupper(strtolower($rowMSSQL00['solicitud_proveedor_carga_hospedaje']))),
                        'solicitud_proveedor_carga_traslado'                        => trim(strtoupper(strtolower($rowMSSQL00['solicitud_proveedor_carga_traslado']))),
                        'solicitud_fecha_carga_1'                                   => $solicitud_fecha_carga_1,
                        'solicitud_fecha_carga_2'                                   => $solicitud_fecha_carga_2,
                        'solicitud_sap_centro_costo'                                => trim(strtoupper(strtolower($rowMSSQL00['solicitud_sap_centro_costo']))),
                        'solicitud_tarea_cantidad'                                  => $rowMSSQL00['solicitud_tarea_cantidad'],
                        'solicitud_tarea_resuelta'                                  => $rowMSSQL00['solicitud_tarea_resuelta'],
                        'solicitud_tarea_porcentaje'                                => number_format((($rowMSSQL00['solicitud_tarea_resuelta'] * 100) / $rowMSSQL00['solicitud_tarea_cantidad']), 2, '.', ''),
                        'solicitud_solicitante_nombre'                              => trim(strtoupper(strtolower($rowMSSQL00['solicitud_solicitante_nombre']))),
                        'solicitud_solicitante_documento'                           => trim(strtoupper(strtolower($rowMSSQL00['solicitud_solicitante_documento']))),
                        'solicitud_jefatura_nombre'                                 => trim(strtoupper(strtolower($rowMSSQL00['solicitud_jefatura_nombre']))),
                        'solicitud_jefatura_documento'                              => trim(strtoupper(strtolower($rowMSSQL00['solicitud_jefatura_documento']))),
                        'solicitud_ejecutivo_nombre'                                => trim(strtoupper(strtolower($rowMSSQL00['solicitud_ejecutivo_nombre']))),
                        'solicitud_ejecutivo_documento'                             => trim(strtoupper(strtolower($rowMSSQL00['solicitud_ejecutivo_documento']))),
                        'solicitud_proveedor_nombre'                                => trim(strtoupper(strtolower($rowMSSQL00['solicitud_proveedor_nombre']))),
                        'solicitud_proveedor_documento'                             => trim(strtoupper(strtolower($rowMSSQL00['solicitud_proveedor_documento']))),
                        'solicitud_observacion'                                     => trim(strtoupper(strtolower($rowMSSQL00['solicitud_observacion']))),

                        'localidad_ciudad_destino_codigo'                           => $rowMSSQL00['localidad_ciudad_destino_codigo'],
                        'localidad_ciudad_destino_orden'                            => $rowMSSQL00['localidad_ciudad_destino_orden'],
                        'localidad_ciudad_destino_nombre'                           => trim(strtoupper(strtolower($rowMSSQL00['localidad_ciudad_destino_nombre']))),
                        'localidad_ciudad_destino_observacion'                      => trim(strtolower($rowMSSQL00['localidad_ciudad_destino_observacion'])),

                        'localidad_pais_destino_codigo'                             => $rowMSSQL00['localidad_pais_destino_codigo'],
                        'localidad_pais_destino_orden'                              => $rowMSSQL00['localidad_pais_destino_orden'],
                        'localidad_pais_destino_nombre'                             => trim(strtoupper(strtolower($rowMSSQL00['localidad_pais_destino_nombre']))),
                        'localidad_pais_destino_path'                               => trim(strtolower($rowMSSQL00['localidad_pais_destino_path'])),
                        'localidad_pais_destino_iso_char2'                          => trim(strtoupper(strtolower($rowMSSQL00['localidad_pais_destino_iso_char2']))),
                        'localidad_pais_destino_iso_char3'                          => trim(strtoupper(strtolower($rowMSSQL00['localidad_pais_destino_iso_char3']))),
                        'localidad_pais_destino_iso_num3'                           => trim(strtoupper(strtolower($rowMSSQL00['localidad_pais_destino_iso_num3']))),
                        'localidad_pais_destino_observacion'                        => trim(strtoupper(strtolower($rowMSSQL00['localidad_pais_destino_observacion'])))
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle    = array(
                        'solicitud_detalle_hospedaje_codigo'                => '',
                        'solicitud_detalle_hospedaje_comentario'            => '',
                        'solicitud_detalle_hospedaje_alimentacion'          => '',
                        'solicitud_detalle_hospedaje_lavanderia'            => '',
                        'solicitud_detalle_hospedaje_fecha_checkin_1'       => '',
                        'solicitud_detalle_hospedaje_fecha_checkin_2'       => '',
                        'solicitud_detalle_hospedaje_fecha_checkout_1'      => '',
                        'solicitud_detalle_hospedaje_fecha_checkout_2'      => '',
                        
                        'auditoria_usuario'                                 => '',
                        'auditoria_fecha_hora'                              => '',
                        'auditoria_ip'                                      => '',

                        'tipo_estado_codigo'                                => '',
                        'tipo_estado_ingles'                                => '',
                        'tipo_estado_castellano'                            => '',
                        'tipo_estado_portugues'                             => '',
                        'tipo_estado_parametro'                             => '',
                        'tipo_estado_icono'                                 => '',
                        'tipo_estado_css'                                   => '',

                        'solicitud_periodo'                                 => '',
                        'solicitud_motivo'                                  => '',
                        'solicitud_vuelo'                                   => '',
                        'solicitud_hospedaje'                               => '',
                        'solicitud_traslado'                                => '',
                        'solicitud_solicitante_tarifa_vuelo'                => '',
                        'solicitud_solicitante_tarifa_hospedaje'            => '',
                        'solicitud_solicitante_tarifa_traslado'             => '',
                        'solicitud_proveedor_carga_vuelo'                   => '',
                        'solicitud_proveedor_carga_hospedaje'               => '',
                        'solicitud_proveedor_carga_traslado'                => '',
                        'solicitud_fecha_carga_1'                           => '',
                        'solicitud_fecha_carga_2'                           => '',
                        'solicitud_sap_centro_costo'                        => '',
                        'solicitud_tarea_cantidad'                          => '',
                        'solicitud_tarea_resuelta'                          => '',
                        'solicitud_tarea_porcentaje'                        => '',
                        'solicitud_solicitante_nombre'                      => '',
                        'solicitud_solicitante_documento'                   => '',
                        'solicitud_jefatura_nombre'                         => '',
                        'solicitud_jefatura_documento'                      => '',
                        'solicitud_ejecutivo_nombre'                        => '',
                        'solicitud_ejecutivo_documento'                     => '',
                        'solicitud_proveedor_nombre'                        => '',
                        'solicitud_proveedor_documento'                     => '',
                        'solicitud_observacion'                             => '',
                        
                        'localidad_ciudad_destino_codigo'                    => '',
                        'localidad_ciudad_destino_orden'                     => '',
                        'localidad_ciudad_destino_nombre'                    => '',
                        'localidad_ciudad_destino_observacion'               => '',

                        'localidad_pais_destino_codigo'                      => '',
                        'localidad_pais_destino_orden'                       => '',
                        'localidad_pais_destino_nombre'                      => '',
                        'localidad_pais_destino_path'                        => '',
                        'localidad_pais_destino_iso_char2'                   => '',
                        'localidad_pais_destino_iso_char3'                   => '',
                        'localidad_pais_destino_iso_num3'                    => '',
                        'localidad_pais_destino_observacion'                 => ''

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

    $app->get('/v2/400/solicitud/historico/hospedaje/{codigo}', function($request) {//20201104
        require __DIR__.'/../src/connect.php';
        
        $val01  = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT 
                a.SOLHHOIDD	        AS      historico_hospedaje_id,   
                a.SOLHHOAME         AS      historico_hospedaje_metodo,	
                a.SOLHHOCOD	        AS      historico_hospedaje_codigo,
                a.SOLHHOCOM         AS      historico_hospedaje_comentario,
                a.SOLHHOALI         AS      historico_hospedaje_alimentacion,	
                a.SOLHHOLAV	        AS      historico_hospedaje_lavanderia,
                a.SOLHHOFIN         AS      historico_hospedaje_fecha_checkin,	
                a.SOLHHOFOU         AS      historico_hospedaje_fecha_checkout,	
                a.SOLHHOCNO         AS      historico_hospedaje_cantidad_noche,	
                
                a.SOLHHOAUS         AS      auditoria_usuario,	
                a.SOLHHOAFH         AS      auditoria_fecha_hora,	
                a.SOLHHOAIP         AS      auditoria_ip,
                
                b.DOMFICCOD         AS          tipo_estado_codigo,
                b.DOMFICNOI         AS          tipo_estado_nombre_ingles,
                b.DOMFICNOC         AS          tipo_estado_nombre_castellano,
                b.DOMFICNOP         AS          tipo_estado_nombre_portugues,
                b.DOMFICPAR         AS          tipo_estado_parametro,
                b.DOMFICICO         AS          tipo_estado_icono,
                b.DOMFICCSS         AS          tipo_estado_css,
                
                c.SOLFICCOD         AS          solicitud_codigo,
                c.SOLFICPER         AS          solicitud_periodo,
                c.SOLFICMOT         AS          solicitud_motivo,
                c.SOLFICVUE         AS          solicitud_vuelo,
                c.SOLFICHOS         AS          solicitud_hospedaje,
                c.SOLFICTRA         AS          solicitud_traslado,
                c.SOLFICSTV         AS          solicitud_solicitante_tarifa_vuelo,
                c.SOLFICSTH         AS          solicitud_solicitante_tarifa_hospedaje,
                c.SOLFICSTT         AS          solicitud_solicitante_tarifa_traslado,
                c.SOLFICPCV         AS          solicitud_proveedor_carga_vuelo,
                c.SOLFICPCH         AS          solicitud_proveedor_carga_hospedaje,
                c.SOLFICPCT         AS          solicitud_proveedor_carga_traslado,
                c.SOLFICFEC         AS          solicitud_fecha_carga,
                c.SOLFICSCC         AS          solicitud_sap_centro_costo,
                c.SOLFICTCA         AS          solicitud_tarea_cantidad,
                c.SOLFICTRE         AS          solicitud_tarea_resuelta,
                c.SOLFICOBS         AS          solicitud_observacion,
                
                d.LOCCIUCOD        AS          localidad_ciudad_destino_codigo,
                d.LOCCIUORD        AS          localidad_ciudad_destino_orden,
                d.LOCCIUNOM        AS          localidad_ciudad_destino_nombre,
                d.LOCCIUOBS        AS          localidad_ciudad_destino_observacion,
                
                e.LOCPAICOD        AS          localidad_pais_destino_codigo,
                e.LOCPAIORD        AS          localidad_pais_destino_orden,
                e.LOCPAINOM        AS          localidad_pais_destino_nombre,
                e.LOCPAIPAT        AS          localidad_pais_destino_path,
                e.LOCPAIIC2        AS          localidad_pais_destino_iso_char2,
                e.LOCPAIIC3        AS          localidad_pais_destino_iso_char3,
                e.LOCPAIIN3        AS          localidad_pais_destino_iso_num3,
                e.LOCPAIOBS        AS          localidad_pais_destino_observacion
                                
                FROM via.SOLHHO a
                INNER JOIN adm.DOMFIC b ON a.SOLHHOEST = b.DOMFICCOD
                INNER JOIN via.SOLFIC c ON a.SOLHHOSOC = c.SOLFICCOD
                INNER JOIN adm.LOCCIU d ON a.SOLHHOCDC = d.LOCCIUCOD
                INNER JOIN adm.LOCPAI e ON d.LOCCIUPAC = e.LOCPAICOD
                
                WHERE a.SOLHHOSOC = ?
                
                ORDER BY a.SOLHHOIDD DESC";

            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val01]);

                while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                    if ($rowMSSQL00['historico_hospedaje_fecha_checkin'] == '1900-01-01' || $rowMSSQL00['historico_hospedaje_fecha_checkin'] == null){
                        $historico_hospedaje_fecha_checkin_1 = '';
                        $historico_hospedaje_fecha_checkin_2 = '';
                    } else {
                        $historico_hospedaje_fecha_checkin_1 = $rowMSSQL00['historico_hospedaje_fecha_checkin'];
                        $historico_hospedaje_fecha_checkin_2 = date('d/m/Y', strtotime($rowMSSQL00['historico_hospedaje_fecha_checkin']));
                    }

                    if ($rowMSSQL00['historico_hospedaje_fecha_checkout'] == '1900-01-01' || $rowMSSQL00['historico_hospedaje_fecha_checkout'] == null){
                        $historico_hospedaje_fecha_checkout_1 = '';
                        $historico_hospedaje_fecha_checkout_2 = '';
                    } else {
                        $historico_hospedaje_fecha_checkout_1 = $rowMSSQL00['historico_hospedaje_fecha_checkout'];
                        $historico_hospedaje_fecha_checkout_2 = date('d/m/Y', strtotime($rowMSSQL00['historico_hospedaje_fecha_checkout']));
                    }
                    
                    if ($rowMSSQL00['solicitud_fecha_carga'] == '1900-01-01' || $rowMSSQL00['solicitud_fecha_carga'] == null){
                        $solicitud_fecha_carga_1 = '';
                        $solicitud_fecha_carga_2 = '';
                    } else {
                        $solicitud_fecha_carga_1 = $rowMSSQL00['solicitud_fecha_carga'];
                        $solicitud_fecha_carga_2 = date('d/m/Y', strtotime($rowMSSQL00['solicitud_fecha_carga']));
                    }

                    $detalle = array(

                        'historico_hospedaje_id'                                    => $rowMSSQL00['historico_hospedaje_id'],
                        'historico_hospedaje_metodo'                                => trim($rowMSSQL00['historico_hospedaje_metodo']),
                        'historico_hospedaje_codigo'                                => $rowMSSQL00['historico_hospedaje_codigo'],
                        'historico_hospedaje_comentario'                            => trim($rowMSSQL00['historico_hospedaje_comentario']),
                        'historico_hospedaje_alimentacion'                          => trim(strtoupper(strtolower($rowMSSQL00['historico_hospedaje_alimentacion']))),
                        'historico_hospedaje_lavanderia'                            => trim(strtoupper(strtolower($rowMSSQL00['historico_hospedaje_lavanderia']))),
                        'historico_hospedaje_fecha_checkin_1'                       => $historico_hospedaje_fecha_checkin_1,
                        'historico_hospedaje_fecha_checkin_2'                       => $historico_hospedaje_fecha_checkin_2,
                        'historico_hospedaje_fecha_checkout_1'                      => $historico_hospedaje_fecha_checkout_1,
                        'historico_hospedaje_fecha_checkout_2'                      => $historico_hospedaje_fecha_checkout_2,
                        'historico_hospedaje_cantidad_noche'                        => $rowMSSQL00['historico_hospedaje_cantidad_noche'],                     

                        'auditoria_usuario'                                         => trim(strtoupper(strtolower($rowMSSQL00['auditoria_usuario']))),
                        'auditoria_fecha_hora'                                      => date("d/m/Y H:i:s", strtotime($rowMSSQL00['auditoria_fecha_hora'])),
                        'auditoria_ip'                                              => trim(strtoupper(strtolower($rowMSSQL00['auditoria_ip']))),

                        'tipo_estado_codigo'                                        => $rowMSSQL00['tipo_estado_codigo'],
                        'tipo_estado_nombre_ingles'                                 => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_nombre_ingles']))),
                        'tipo_estado_nombre_castellano'                             => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_nombre_castellano']))),
                        'tipo_estado_nombre_portugues'                              => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_nombre_portugues']))),
                        'tipo_estado_parametro'                                     => $rowMSSQL00['tipo_estado_parametro'],
                        'tipo_estado_icono'                                         => trim(strtolower($rowMSSQL00['tipo_estado_icono'])),
                        'tipo_estado_css'                                           => trim(strtolower($rowMSSQL00['tipo_estado_css'])),

                        'solicitud_codigo'                                          => $rowMSSQL00['solicitud_codigo'],
                        'solicitud_periodo'                                         => $rowMSSQL00['solicitud_periodo'],
                        'solicitud_motivo'                                          => trim(strtoupper(strtolower($rowMSSQL00['solicitud_motivo']))),
                        'solicitud_vuelo'                                           => trim(strtoupper(strtolower($rowMSSQL00['solicitud_vuelo']))),
                        'solicitud_hospedaje'                                       => trim(strtoupper(strtolower($rowMSSQL00['solicitud_hospedaje']))),
                        'solicitud_traslado'                                        => trim(strtoupper(strtolower($rowMSSQL00['solicitud_traslado']))),
                        'solicitud_solicitante_tarifa_vuelo'                        => trim(strtoupper(strtolower($rowMSSQL00['solicitud_solicitante_tarifa_vuelo']))),
                        'solicitud_solicitante_tarifa_hospedaje'                    => trim(strtoupper(strtolower($rowMSSQL00['solicitud_solicitante_tarifa_hospedaje']))),
                        'solicitud_solicitante_tarifa_traslado'                     => trim(strtoupper(strtolower($rowMSSQL00['solicitud_solicitante_tarifa_traslado']))),
                        'solicitud_proveedor_carga_vuelo'                           => trim(strtoupper(strtolower($rowMSSQL00['solicitud_proveedor_carga_vuelo']))),
                        'solicitud_proveedor_carga_hospedaje'                       => trim(strtoupper(strtolower($rowMSSQL00['solicitud_proveedor_carga_hospedaje']))),
                        'solicitud_proveedor_carga_traslado'                        => trim(strtoupper(strtolower($rowMSSQL00['solicitud_proveedor_carga_traslado']))),
                        'solicitud_fecha_carga_1'                                   => $solicitud_fecha_carga_1,
                        'solicitud_fecha_carga_2'                                   => $solicitud_fecha_carga_2,
                        'solicitud_sap_centro_costo'                                => trim(strtoupper(strtolower($rowMSSQL00['solicitud_sap_centro_costo']))),
                        'solicitud_tarea_cantidad'                                  => $rowMSSQL00['solicitud_tarea_cantidad'],
                        'solicitud_tarea_resuelta'                                  => $rowMSSQL00['solicitud_tarea_resuelta'],
                        'solicitud_observacion'                                     => trim(strtoupper(strtolower($rowMSSQL00['solicitud_observacion']))),

                        'localidad_ciudad_destino_codigo'                           => $rowMSSQL00['localidad_ciudad_destino_codigo'],
                        'localidad_ciudad_destino_orden'                            => $rowMSSQL00['localidad_ciudad_destino_orden'],
                        'localidad_ciudad_destino_nombre'                           => trim(strtoupper(strtolower($rowMSSQL00['localidad_ciudad_destino_nombre']))),
                        'localidad_ciudad_destino_observacion'                      => trim(strtolower($rowMSSQL00['localidad_ciudad_destino_observacion'])),

                        'localidad_pais_destino_codigo'                             => $rowMSSQL00['localidad_pais_destino_codigo'],
                        'localidad_pais_destino_orden'                              => $rowMSSQL00['localidad_pais_destino_orden'],
                        'localidad_pais_destino_nombre'                             => trim(strtoupper(strtolower($rowMSSQL00['localidad_pais_destino_nombre']))),
                        'localidad_pais_destino_path'                               => trim(strtolower($rowMSSQL00['localidad_pais_destino_path'])),
                        'localidad_pais_destino_iso_char2'                          => trim(strtoupper(strtolower($rowMSSQL00['localidad_pais_destino_iso_char2']))),
                        'localidad_pais_destino_iso_char3'                          => trim(strtoupper(strtolower($rowMSSQL00['localidad_pais_destino_iso_char3']))),
                        'localidad_pais_destino_iso_num3'                           => trim(strtoupper(strtolower($rowMSSQL00['localidad_pais_destino_iso_num3']))),
                        'localidad_pais_destino_observacion'                        => trim(strtoupper(strtolower($rowMSSQL00['localidad_pais_destino_observacion'])))
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle    = array(
                        'historico_hospedaje_id'                                    => '',
                        'historico_hospedaje_metodo'                                => '',
                        'historico_hospedaje_codigo'                                => '',
                        'historico_hospedaje_comentario'                            => '',
                        'historico_hospedaje_alimentacion'                          => '',
                        'historico_hospedaje_lavanderia'                            => '',
                        'historico_hospedaje_fecha_checkin_1'                       => '',
                        'historico_hospedaje_fecha_checkin_2'                       => '',
                        'historico_hospedaje_fecha_checkout_1'                      => '',
                        'historico_hospedaje_fecha_checkout_2'                      => '',
                        'historico_hospedaje_cantidad_noche'                        => '',                     

                        'auditoria_usuario'                                         => '',
                        'auditoria_fecha_hora'                                      => '',
                        'auditoria_ip'                                              => '',

                        'tipo_estado_codigo'                                        => '',
                        'tipo_estado_nombre_ingles'                                 => '',
                        'tipo_estado_nombre_castellano'                             => '',
                        'tipo_estado_nombre_portugues'                              => '',
                        'tipo_estado_parametro'                                     => '',
                        'tipo_estado_icono'                                         => '',
                        'tipo_estado_css'                                           => '',

                        'solicitud_codigo'                                          => '',
                        'solicitud_periodo'                                         => '',
                        'solicitud_motivo'                                          => '',
                        'solicitud_vuelo'                                           => '',
                        'solicitud_hospedaje'                                       => '',
                        'solicitud_traslado'                                        => '',
                        'solicitud_solicitante_tarifa_vuelo'                        => '',
                        'solicitud_solicitante_tarifa_hospedaje'                    => '',
                        'solicitud_solicitante_tarifa_traslado'                     => '',
                        'solicitud_proveedor_carga_vuelo'                           => '',
                        'solicitud_proveedor_carga_hospedaje'                       => '',
                        'solicitud_proveedor_carga_traslado'                        => '',
                        'solicitud_fecha_carga_1'                                   => '',
                        'solicitud_fecha_carga_2'                                   => '',
                        'solicitud_sap_centro_costo'                                => '',
                        'solicitud_tarea_cantidad'                                  => '',
                        'solicitud_tarea_resuelta'                                  => '',
                        'solicitud_observacion'                                     => '',

                        'localidad_ciudad_destino_codigo'                           => '',
                        'localidad_ciudad_destino_orden'                            => '',
                        'localidad_ciudad_destino_nombre'                           => '',
                        'localidad_ciudad_destino_observacion'                      => '',

                        'localidad_pais_destino_codigo'                             => '',
                        'localidad_pais_destino_orden'                              => '',
                        'localidad_pais_destino_nombre'                             => '',
                        'localidad_pais_destino_path'                               => '',
                        'localidad_pais_destino_iso_char2'                          => '',
                        'localidad_pais_destino_iso_char3'                          => '',
                        'localidad_pais_destino_iso_num3'                           => '',
                        'localidad_pais_destino_observacion'                        => ''
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

    $app->get('/v2/400/solicitud/detalle/traslado/{codigo}', function($request) {//20201102
        require __DIR__.'/../src/connect.php';
        
        $val01  = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT 
                a.SOLTRACOD         AS          solicitud_detalle_traslado_codigo,
                a.SOLTRACOM         AS          solicitud_detalle_traslado_comentario,
                a.SOLTRASAL         AS          solicitud_detalle_traslado_origen,
                a.SOLTRADES         AS          solicitud_detalle_traslado_destino,
                a.SOLTRAFSA         AS          solicitud_detalle_traslado_fecha,
                a.SOLTRAHSA         AS          solicitud_detalle_traslado_hora,

                a.SOLVUETTC         AS          tipo_traslado_codigo,

                CASE
                  WHEN a.SOLVUETTC = 'I' THEN 'TRASLADO IN'
                  WHEN a.SOLVUETTC = 'O' THEN 'TRASLADO OUT'
                  WHEN a.SOLVUETTC = 'T' THEN 'OTROS TRASLADOS'
                END AS tipo_traslado_nombre,

                a.SOLTRAAUS         AS          auditoria_usuario,
                a.SOLTRAAFH         AS          auditoria_fecha_hora,
                a.SOLTRAAIP         AS          auditoria_ip,

                b.DOMFICCOD         AS          tipo_estado_codigo,
                b.DOMFICNOI         AS          tipo_estado_ingles,
                b.DOMFICNOC         AS          tipo_estado_castellano,
                b.DOMFICNOP         AS          tipo_estado_portugues,
                b.DOMFICPAR         AS          tipo_estado_parametro,
                b.DOMFICICO         AS          tipo_estado_icono,
                b.DOMFICCSS         AS          tipo_estado_css,

                c.SOLFICCOD         AS          solicitud_codigo,
                c.SOLFICPER         AS          solicitud_periodo,
                c.SOLFICMOT         AS          solicitud_motivo,
                c.SOLFICVUE         AS          solicitud_vuelo,
                c.SOLFICHOS         AS          solicitud_hospedaje,
                c.SOLFICTRA         AS          solicitud_traslado,
                c.SOLFICSTV         AS          solicitud_solicitante_tarifa_vuelo,
                c.SOLFICSTH         AS          solicitud_solicitante_tarifa_hospedaje,
                c.SOLFICSTT         AS          solicitud_solicitante_tarifa_traslado,
                c.SOLFICPCV         AS          solicitud_proveedor_carga_vuelo,
                c.SOLFICPCH         AS          solicitud_proveedor_carga_hospedaje,
                c.SOLFICPCT		    AS	        solicitud_proveedor_carga_traslado,
                c.SOLFICFEC         AS          solicitud_fecha_carga,
                c.SOLFICSCC         AS          solicitud_sap_centro_costo,
                c.SOLFICTCA         AS          solicitud_tarea_cantidad,
                c.SOLFICTRE         AS          solicitud_tarea_resuelta,
                c.SOLFICOBS         AS          solicitud_observacion,

                h1.NombreEmpleado   AS          solicitud_solicitante_nombre,
                c.SOLFICDNS         AS          solicitud_solicitante_documento,
                h2.NombreEmpleado   AS          solicitud_jefatura_nombre,
                c.SOLFICDNJ         AS          solicitud_jefatura_documento,
                h3.NombreEmpleado   AS          solicitud_ejecutivo_nombre,
                c.SOLFICDNE         AS          solicitud_ejecutivo_documento,
                h4.NombreEmpleado   AS          solicitud_proveedor_nombre,
                c.SOLFICDNP         AS          solicitud_proveedor_documento
                
                FROM via.SOLTRA a
                INNER JOIN adm.DOMFIC b ON a.SOLTRAEST = b.DOMFICCOD
                INNER JOIN via.SOLFIC c ON a.SOLTRASOC = c.SOLFICCOD
                LEFT OUTER JOIN [CSF].[dbo].[empleados_AxisONE] h1 ON c.SOLFICDNS COLLATE SQL_Latin1_General_CP1_CI_AS = h1.CedulaEmpleado
                LEFT OUTER JOIN [CSF].[dbo].[empleados_AxisONE] h2 ON c.SOLFICDNJ COLLATE SQL_Latin1_General_CP1_CI_AS = h2.CedulaEmpleado
                LEFT OUTER JOIN [CSF].[dbo].[empleados_AxisONE] h3 ON c.SOLFICDNE COLLATE SQL_Latin1_General_CP1_CI_AS = h3.CedulaEmpleado
                LEFT OUTER JOIN [CSF].[dbo].[empleados_AxisONE] h4 ON c.SOLFICDNP COLLATE SQL_Latin1_General_CP1_CI_AS = h4.CedulaEmpleado
                
                WHERE a.SOLTRASOC = ?";

            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val01]);

                while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {

                    if ($rowMSSQL00['solicitud_detalle_traslado_fecha'] == '1900-01-01' || $rowMSSQL00['solicitud_detalle_traslado_fecha'] == null){
                        $solicitud_detalle_traslado_fecha_1 = '';
                        $solicitud_detalle_traslado_fecha_2 = '';
                    } else {
                        $solicitud_detalle_traslado_fecha_1 = $rowMSSQL00['solicitud_detalle_traslado_fecha'];
                        $solicitud_detalle_traslado_fecha_2 = date('d/m/Y', strtotime($rowMSSQL00['solicitud_detalle_traslado_fecha']));
                    }
                    
                    if ($rowMSSQL00['solicitud_fecha_carga'] == '1900-01-01' || $rowMSSQL00['solicitud_fecha_carga'] == null){
                        $solicitud_fecha_carga_1 = '';
                        $solicitud_fecha_carga_2 = '';
                    } else {
                        $solicitud_fecha_carga_1 = $rowMSSQL00['solicitud_fecha_carga'];
                        $solicitud_fecha_carga_2 = date('d/m/Y', strtotime($rowMSSQL00['solicitud_fecha_carga']));
                    }

                    $detalle = array(
                        'solicitud_detalle_traslado_codigo'                         => $rowMSSQL00['solicitud_detalle_traslado_codigo'],
                        'solicitud_detalle_traslado_comentario'                     => trim(strtoupper(strtolower($rowMSSQL00['solicitud_detalle_traslado_comentario']))),
                        'solicitud_detalle_traslado_origen'                         => trim(strtoupper(strtolower($rowMSSQL00['solicitud_detalle_traslado_origen']))),
                        'solicitud_detalle_traslado_destino'                        => trim(strtoupper(strtolower($rowMSSQL00['solicitud_detalle_traslado_destino']))),
                        'solicitud_detalle_traslado_fecha_1'                        => $solicitud_detalle_traslado_fecha_1,
                        'solicitud_detalle_traslado_fecha_2'                        => $solicitud_detalle_traslado_fecha_2,
                        'solicitud_detalle_traslado_hora'                           => trim(strtoupper(strtolower($rowMSSQL00['solicitud_detalle_traslado_hora']))),

                        'tipo_traslado_codigo'                                      => trim(strtoupper(strtolower($rowMSSQL00['tipo_traslado_codigo']))),
                        'tipo_traslado_nombre'                                      => trim(strtoupper(strtolower($rowMSSQL00['tipo_traslado_nombre']))),
                        
                        'auditoria_usuario'                                         => trim(strtoupper(strtolower($rowMSSQL00['auditoria_usuario']))),
                        'auditoria_fecha_hora'                                      => date("d/m/Y H:i:s", strtotime($rowMSSQL00['auditoria_fecha_hora'])),
                        'auditoria_ip'                                              => trim(strtoupper(strtolower($rowMSSQL00['auditoria_ip']))),

                        'tipo_estado_codigo'                                        => $rowMSSQL00['tipo_estado_codigo'],
                        'tipo_estado_ingles'                                        => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_ingles']))),
                        'tipo_estado_castellano'                                    => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_castellano']))),
                        'tipo_estado_portugues'                                     => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_portugues']))),
                        'tipo_estado_parametro'                                     => $rowMSSQL00['tipo_estado_parametro'],
                        'tipo_estado_icono'                                         => trim(strtolower($rowMSSQL00['tipo_estado_icono'])),
                        'tipo_estado_css'                                           => trim(strtolower($rowMSSQL00['tipo_estado_css'])),

                        'solicitud_codigo'                                          => $rowMSSQL00['solicitud_codigo'],
                        'solicitud_periodo'                                         => $rowMSSQL00['solicitud_periodo'],
                        'solicitud_motivo'                                          => trim(strtoupper(strtolower($rowMSSQL00['solicitud_motivo']))),
                        'solicitud_vuelo'                                           => trim(strtoupper(strtolower($rowMSSQL00['solicitud_vuelo']))),
                        'solicitud_hospedaje'                                       => trim(strtoupper(strtolower($rowMSSQL00['solicitud_hospedaje']))),
                        'solicitud_traslado'                                        => trim(strtoupper(strtolower($rowMSSQL00['solicitud_traslado']))),
                        'solicitud_solicitante_tarifa_vuelo'                        => trim(strtoupper(strtolower($rowMSSQL00['solicitud_solicitante_tarifa_vuelo']))),
                        'solicitud_solicitante_tarifa_hospedaje'                    => trim(strtoupper(strtolower($rowMSSQL00['solicitud_solicitante_tarifa_hospedaje']))),
                        'solicitud_solicitante_tarifa_traslado'                     => trim(strtoupper(strtolower($rowMSSQL00['solicitud_solicitante_tarifa_traslado']))),
                        'solicitud_proveedor_carga_hospedaje'                       => trim(strtoupper(strtolower($rowMSSQL00['solicitud_proveedor_carga_hospedaje']))),
                        'solicitud_proveedor_carga_hospedaje'                       => trim(strtoupper(strtolower($rowMSSQL00['solicitud_proveedor_carga_hospedaje']))),
                        'solicitud_proveedor_carga_traslado'                        => trim(strtoupper(strtolower($rowMSSQL00['solicitud_proveedor_carga_traslado']))),
                        'solicitud_fecha_carga_1'                                   => $solicitud_fecha_carga_1,
                        'solicitud_fecha_carga_2'                                   => $solicitud_fecha_carga_2,
                        'solicitud_sap_centro_costo'                                => trim(strtoupper(strtolower($rowMSSQL00['solicitud_sap_centro_costo']))),
                        'solicitud_tarea_cantidad'                                  => $rowMSSQL00['solicitud_tarea_cantidad'],
                        'solicitud_tarea_resuelta'                                  => $rowMSSQL00['solicitud_tarea_resuelta'],
                        'solicitud_tarea_porcentaje'                                => number_format((($rowMSSQL00['solicitud_tarea_resuelta'] * 100) / $rowMSSQL00['solicitud_tarea_cantidad']), 2, '.', ''),
                        'solicitud_solicitante_nombre'                              => trim(strtoupper(strtolower($rowMSSQL00['solicitud_solicitante_nombre']))),
                        'solicitud_solicitante_documento'                           => trim(strtoupper(strtolower($rowMSSQL00['solicitud_solicitante_documento']))),
                        'solicitud_jefatura_nombre'                                 => trim(strtoupper(strtolower($rowMSSQL00['solicitud_jefatura_nombre']))),
                        'solicitud_jefatura_documento'                              => trim(strtoupper(strtolower($rowMSSQL00['solicitud_jefatura_documento']))),
                        'solicitud_ejecutivo_nombre'                                => trim(strtoupper(strtolower($rowMSSQL00['solicitud_ejecutivo_nombre']))),
                        'solicitud_ejecutivo_documento'                             => trim(strtoupper(strtolower($rowMSSQL00['solicitud_ejecutivo_documento']))),
                        'solicitud_proveedor_nombre'                                => trim(strtoupper(strtolower($rowMSSQL00['solicitud_proveedor_nombre']))),
                        'solicitud_proveedor_documento'                             => trim(strtoupper(strtolower($rowMSSQL00['solicitud_proveedor_documento']))),
                        'solicitud_observacion'                                     => trim(strtoupper(strtolower($rowMSSQL00['solicitud_observacion'])))

                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle    = array(
                        'solicitud_detalle_traslado_codigo'                 => '',            
                        'solicitud_detalle_traslado_comentario'             => '',       
                        'solicitud_detalle_traslado_origen'                 => '',        
                        'solicitud_detalle_traslado_destino'                => '',        
                        'solicitud_detalle_traslado_fecha_1'                => '',      
                        'solicitud_detalle_traslado_fecha_2'                => '',    
                        'solicitud_detalle_traslado_hora'                   => '',     

                        'tipo_traslado_codigo'                              => '',
                        'tipo_traslado_nombre'                              => '',     
                        
                        'auditoria_usuario'                                 => '',
                        'auditoria_fecha_hora'                              => '',
                        'auditoria_ip'                                      => '',

                        'tipo_estado_codigo'                                => '',
                        'tipo_estado_ingles'                                => '',
                        'tipo_estado_castellano'                            => '',
                        'tipo_estado_portugues'                             => '',
                        'tipo_estado_parametro'                             => '',
                        'tipo_estado_icono'                                 => '',
                        'tipo_estado_css'                                   => '',

                        'solicitud_periodo'                                 => '',
                        'solicitud_motivo'                                  => '',
                        'solicitud_vuelo'                                   => '',
                        'solicitud_hospedaje'                               => '',
                        'solicitud_traslado'                                => '',
                        'solicitud_solicitante_tarifa_vuelo'                => '',
                        'solicitud_solicitante_tarifa_hospedaje'            => '',
                        'solicitud_solicitante_tarifa_traslado'             => '',
                        'solicitud_proveedor_carga_vuelo'                   => '',
                        'solicitud_proveedor_carga_hospedaje'               => '',
                        'solicitud_proveedor_carga_traslado'                => '',
                        'solicitud_fecha_carga_1'                           => '',
                        'solicitud_fecha_carga_2'                           => '',
                        'solicitud_sap_centro_costo'                        => '',
                        'solicitud_tarea_cantidad'                          => '',
                        'solicitud_tarea_resuelta'                          => '',
                        'solicitud_tarea_porcentaje'                        => '',
                        'solicitud_solicitante_nombre'                      => '',
                        'solicitud_solicitante_documento'                   => '',
                        'solicitud_jefatura_nombre'                         => '',
                        'solicitud_jefatura_documento'                      => '',
                        'solicitud_ejecutivo_nombre'                        => '',
                        'solicitud_ejecutivo_documento'                     => '',
                        'solicitud_proveedor_nombre'                        => '',
                        'solicitud_proveedor_documento'                     => '',
                        'solicitud_observacion'                             => ''

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

    $app->get('/v2/400/solicitud/historico/traslado/{codigo}', function($request) {//20201104
        require __DIR__.'/../src/connect.php';
        
        $val01  = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT 
                a.SOLHTRIDD         AS          historico_traslado_id,	
                a.SOLHTRAME         AS          historico_traslado_metodo,	
                a.SOLHTRCOD	        AS          historico_traslado_codigo,
                a.SOLHTRCOM	        AS          historico_traslado_comentario,
                a.SOLHTRSAL         AS          historico_traslado_origen,	
                a.SOLHTRDES         AS          historico_traslado_destino,	
                a.SOLHTRFSA         AS          historico_traslado_fecha_salida,	
                a.SOLHTRHSA         AS          historico_traslado_hora_salida,
                
                a.SOLHTRTTC         AS          historico_tipo_traslado_codigo,

                a.SOLHTRAUS	        AS          auditoria_usuario,
                a.SOLHTRAFH         AS          auditoria_fecha_hora,      	
                a.SOLHTRAIP         AS          auditoria_ip,
                
                b.DOMFICCOD         AS          tipo_estado_codigo,
                b.DOMFICNOI         AS          tipo_estado_nombre_ingles,
                b.DOMFICNOC         AS          tipo_estado_nombre_castellano,
                b.DOMFICNOP         AS          tipo_estado_nombre_portugues,
                b.DOMFICPAR         AS          tipo_estado_parametro,
                b.DOMFICICO         AS          tipo_estado_icono,
                b.DOMFICCSS         AS          tipo_estado_css,
                
                c.SOLFICCOD         AS          solicitud_codigo,
                c.SOLFICPER         AS          solicitud_periodo,
                c.SOLFICMOT         AS          solicitud_motivo,
                c.SOLFICVUE         AS          solicitud_vuelo,
                c.SOLFICHOS         AS          solicitud_hospedaje,
                c.SOLFICTRA         AS          solicitud_traslado,
                c.SOLFICSTV         AS          solicitud_solicitante_tarifa_vuelo,
                c.SOLFICSTH         AS          solicitud_solicitante_tarifa_hospedaje,
                c.SOLFICSTT         AS          solicitud_solicitante_tarifa_traslado,
                c.SOLFICPCV         AS          solicitud_proveedor_carga_vuelo,
                c.SOLFICPCH         AS          solicitud_proveedor_carga_hospedaje,
                c.SOLFICPCT         AS          solicitud_proveedor_carga_traslado,
                c.SOLFICFEC         AS          solicitud_fecha_carga,
                c.SOLFICSCC         AS          solicitud_sap_centro_costo,
                c.SOLFICTCA         AS          solicitud_tarea_cantidad,
                c.SOLFICTRE         AS          solicitud_tarea_resuelta,
                c.SOLFICOBS         AS          solicitud_observacion
                
                FROM via.SOLHTR a
                INNER JOIN adm.DOMFIC b ON a.SOLHTREST = b.DOMFICCOD
                INNER JOIN via.SOLFIC c ON a.SOLHTRSOC = c.SOLFICCOD
                
                WHERE a.SOLHTRSOC = ?
                
                ORDER BY a.SOLHTRIDD DESC";

            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val01]);

                while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                    if ($rowMSSQL00['historico_traslado_fecha_salida'] == '1900-01-01' || $rowMSSQL00['historico_traslado_fecha_salida'] == null){
                        $historico_traslado_fecha_salida_1 = '';
                        $historico_traslado_fecha_salida_2 = '';
                    } else {
                        $historico_traslado_fecha_salida_1 = $rowMSSQL00['historico_traslado_fecha_salida'];
                        $historico_traslado_fecha_salida_2 = date('d/m/Y', strtotime($rowMSSQL00['historico_traslado_fecha_salida']));
                    }
                    
                    if ($rowMSSQL00['solicitud_fecha_carga'] == '1900-01-01' || $rowMSSQL00['solicitud_fecha_carga'] == null){
                        $solicitud_fecha_carga_1 = '';
                        $solicitud_fecha_carga_2 = '';
                    } else {
                        $solicitud_fecha_carga_1 = $rowMSSQL00['solicitud_fecha_carga'];
                        $solicitud_fecha_carga_2 = date('d/m/Y', strtotime($rowMSSQL00['solicitud_fecha_carga']));
                    }

                    $detalle = array(

                        'historico_traslado_id'                                     => $rowMSSQL00['historico_traslado_id'],
                        'historico_traslado_metodo'                                 => trim($rowMSSQL00['historico_traslado_metodo']),
                        'historico_traslado_codigo'                                 => $rowMSSQL00['historico_traslado_codigo'],
                        'historico_traslado_comentario'                             => trim($rowMSSQL00['historico_traslado_comentario']),
                        'historico_traslado_origen'                                 => trim(strtoupper(strtolower($rowMSSQL00['historico_traslado_origen']))),
                        'historico_traslado_destino'                                => trim(strtoupper(strtolower($rowMSSQL00['historico_traslado_destino']))),
                        'historico_traslado_fecha_salida_1'                         => $historico_traslado_fecha_salida_1,
                        'historico_traslado_fecha_salida_2'                         => $historico_traslado_fecha_salida_2,
                        'historico_traslado_hora_salida'                            => trim(strtoupper(strtolower($rowMSSQL00['historico_traslado_hora_salida']))),   
                        'historico_tipo_traslado_codigo'                            => trim(strtoupper(strtolower($rowMSSQL00['historico_tipo_traslado_codigo']))),

                        'auditoria_usuario'                                         => trim(strtoupper(strtolower($rowMSSQL00['auditoria_usuario']))),
                        'auditoria_fecha_hora'                                      => date("d/m/Y H:i:s", strtotime($rowMSSQL00['auditoria_fecha_hora'])),
                        'auditoria_ip'                                              => trim(strtoupper(strtolower($rowMSSQL00['auditoria_ip']))),

                        'tipo_estado_codigo'                                        => $rowMSSQL00['tipo_estado_codigo'],
                        'tipo_estado_nombre_ingles'                                 => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_nombre_ingles']))),
                        'tipo_estado_nombre_castellano'                             => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_nombre_castellano']))),
                        'tipo_estado_nombre_portugues'                              => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_nombre_portugues']))),
                        'tipo_estado_parametro'                                     => $rowMSSQL00['tipo_estado_parametro'],
                        'tipo_estado_icono'                                         => trim(strtolower($rowMSSQL00['tipo_estado_icono'])),
                        'tipo_estado_css'                                           => trim(strtolower($rowMSSQL00['tipo_estado_css'])),

                        'solicitud_codigo'                                          => $rowMSSQL00['solicitud_codigo'],
                        'solicitud_periodo'                                         => $rowMSSQL00['solicitud_periodo'],
                        'solicitud_motivo'                                          => trim(strtoupper(strtolower($rowMSSQL00['solicitud_motivo']))),
                        'solicitud_vuelo'                                           => trim(strtoupper(strtolower($rowMSSQL00['solicitud_vuelo']))),
                        'solicitud_hospedaje'                                       => trim(strtoupper(strtolower($rowMSSQL00['solicitud_hospedaje']))),
                        'solicitud_traslado'                                        => trim(strtoupper(strtolower($rowMSSQL00['solicitud_traslado']))),
                        'solicitud_solicitante_tarifa_vuelo'                        => trim(strtoupper(strtolower($rowMSSQL00['solicitud_solicitante_tarifa_vuelo']))),
                        'solicitud_solicitante_tarifa_hospedaje'                    => trim(strtoupper(strtolower($rowMSSQL00['solicitud_solicitante_tarifa_hospedaje']))),
                        'solicitud_solicitante_tarifa_traslado'                     => trim(strtoupper(strtolower($rowMSSQL00['solicitud_solicitante_tarifa_traslado']))),
                        'solicitud_proveedor_carga_vuelo'                           => trim(strtoupper(strtolower($rowMSSQL00['solicitud_proveedor_carga_vuelo']))),
                        'solicitud_proveedor_carga_hospedaje'                       => trim(strtoupper(strtolower($rowMSSQL00['solicitud_proveedor_carga_hospedaje']))),
                        'solicitud_proveedor_carga_traslado'                        => trim(strtoupper(strtolower($rowMSSQL00['solicitud_proveedor_carga_traslado']))),
                        'solicitud_fecha_carga_1'                                   => $solicitud_fecha_carga_1,
                        'solicitud_fecha_carga_2'                                   => $solicitud_fecha_carga_2,
                        'solicitud_sap_centro_costo'                                => trim(strtoupper(strtolower($rowMSSQL00['solicitud_sap_centro_costo']))),
                        'solicitud_tarea_cantidad'                                  => $rowMSSQL00['solicitud_tarea_cantidad'],
                        'solicitud_tarea_resuelta'                                  => $rowMSSQL00['solicitud_tarea_resuelta'],
                        'solicitud_observacion'                                     => trim(strtoupper(strtolower($rowMSSQL00['solicitud_observacion'])))

                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle    = array(
                        'historico_traslado_id'                                     => '',
                        'historico_traslado_metodo'                                 => '',
                        'historico_traslado_codigo'                                 => '',
                        'historico_traslado_comentario'                             => '',
                        'historico_traslado_origen'                                 => '',
                        'historico_traslado_destino'                                => '',
                        'historico_traslado_fecha_salida_1'                         => '',
                        'historico_traslado_fecha_salida_2'                         => '',
                        'historico_traslado_hora_salida'                            => '',   
                        'historico_tipo_traslado_codigo'                            => '',

                        'auditoria_usuario'                                         => '',
                        'auditoria_fecha_hora'                                      => '',
                        'auditoria_ip'                                              => '',

                        'tipo_estado_codigo'                                        => '',
                        'tipo_estado_nombre_ingles'                                 => '',
                        'tipo_estado_nombre_castellano'                             => '',
                        'tipo_estado_nombre_portugues'                              => '',
                        'tipo_estado_parametro'                                     => '',
                        'tipo_estado_icono'                                         => '',
                        'tipo_estado_css'                                           => '',

                        'solicitud_codigo'                                          => '',
                        'solicitud_periodo'                                         => '',
                        'solicitud_motivo'                                          => '',
                        'solicitud_vuelo'                                           => '',
                        'solicitud_hospedaje'                                       => '',
                        'solicitud_traslado'                                        => '',
                        'solicitud_solicitante_tarifa_vuelo'                        => '',
                        'solicitud_solicitante_tarifa_hospedaje'                    => '',
                        'solicitud_solicitante_tarifa_traslado'                     => '',
                        'solicitud_proveedor_carga_vuelo'                           => '',
                        'solicitud_proveedor_carga_hospedaje'                       => '',
                        'solicitud_proveedor_carga_traslado'                        => '',
                        'solicitud_fecha_carga_1'                                   => '',
                        'solicitud_fecha_carga_2'                                   => '',
                        'solicitud_sap_centro_costo'                                => '',
                        'solicitud_tarea_cantidad'                                  => '',
                        'solicitud_tarea_resuelta'                                  => '',
                        'solicitud_observacion'                                     => ''  
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

    $app->get('/v2/400/solicitud/opcion/cabecera/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val01  = $request->getAttribute('codigo');

        if (isset($val01)){
            $sql00  = "SELECT 
                a.SOLOPCCOD     AS      solicitud_opcion_cabecera_codigo,
                a.SOLOPCOPC     AS      solicitud_opcion_cabecera_nombre,
                a.SOLOPCTIM     AS      solicitud_opcion_cabecera_tarifa_importe,
                a.SOLOPCRES     AS      solicitud_opcion_cabecera_reserva,
                a.SOLOPCCO1     AS      solicitud_opcion_cabecera_comentario_1,
                a.SOLOPCCO2     AS      solicitud_opcion_cabecera_comentario_2,
                a.SOLOPCCO3     AS      solicitud_opcion_cabecera_comentario_3,
                a.SOLOPCCO4     AS      solicitud_opcion_cabecera_comentario_4,
                a.SOLOPCPAT     AS      solicitud_opcion_cabecera_directorio,
                
                a.SOLOPCAUS     AS      auditoria_usuario,
                a.SOLOPCAFH     AS      auditoria_fecha_hora,
                a.SOLOPCAIP     AS      auditoria_ip,
                
                b.DOMFICCOD     AS      tipo_estado_codigo,
                b.DOMFICNOC     AS      tipo_estado_nombre,
                b.DOMFICPAR     AS      tipo_estado_parametro,
                b.DOMFICCSS     AS      tipo_estado_css,
                
                c.DOMFICCOD     AS      tipo_solicitud_codigo,
                c.DOMFICNOC     AS      tipo_solicitud_nombre,
                c.DOMFICPAR     AS      tipo_solicitud_parametro,
                c.DOMFICCSS     AS      tipo_solicitud_css,

                d.SOLFICCOD     AS      solicitud_codigo,
                d.SOLFICPER     AS      solicitud_periodo,
                d.SOLFICMOT     AS      solicitud_motivo,
                d.SOLFICVUE     AS      solicitud_vuelo,
                d.SOLFICHOS     AS      solicitud_hospedaje,
                d.SOLFICTRA     AS      solicitud_traslado,
                d.SOLFICFEC     AS      solicitud_fecha_carga,
                d.SOLFICSCC     AS      solicitud_sap_centro_costo,
                d.SOLFICTCA     AS      solicitud_tarea_cantidad,
                d.SOLFICTRE     AS      solicitud_tarea_resuelta,
                d.SOLFICOBS     AS      solicitud_observacion
                
                FROM via.SOLOPC a

                INNER JOIN adm.DOMFIC      b ON a.SOLOPCEST = b.DOMFICCOD
                INNER JOIN adm.DOMFIC      c ON a.SOLOPCTSC = c.DOMFICCOD
                INNER JOIN via.SOLFIC      d ON a.SOLOPCSOC = d.SOLFICCOD

                WHERE a.SOLOPCSOC = ?

                ORDER BY a.SOLOPCCOD";

            try {
                $connMSSQL  = getConnectionMSSQLv2();

                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val01, $val02]);

                while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                    $detalle    = array(
                        'solicitud_opcion_cabecera_codigo'                   =>      $rowMSSQL00['solicitud_opcion_cabecera_codigo'],
                        'solicitud_opcion_cabecera_nombre'                   =>      trim(strtoupper($rowMSSQL00['solicitud_opcion_cabecera_nombre'])),
                        'solicitud_opcion_cabecera_tarifa_importe'           =>      $rowMSSQL00['solicitud_opcion_cabecera_tarifa_importe'],
                        'solicitud_opcion_cabecera_reserva'                  =>      trim(strtoupper($rowMSSQL00['solicitud_opcion_cabecera_reserva'])),
                        'solicitud_opcion_cabecera_comentario_1'             =>      trim(strtoupper($rowMSSQL00['solicitud_opcion_cabecera_comentario_1'])),
                        'solicitud_opcion_cabecera_comentario_2'             =>      trim(strtoupper($rowMSSQL00['solicitud_opcion_cabecera_comentario_2'])),
                        'solicitud_opcion_cabecera_comentario_3'             =>      trim(strtoupper($rowMSSQL00['solicitud_opcion_cabecera_comentario_3'])),
                        'solicitud_opcion_cabecera_comentario_4'             =>      trim(strtoupper($rowMSSQL00['solicitud_opcion_cabecera_comentario_4'])),
                        'solicitud_opcion_cabecera_directorio'               =>      trim(strtolower($rowMSSQL00['solicitud_opcion_cabecera_directorio'])),

                        'tipo_estado_codigo'                                =>       $rowMSSQL00['tipo_estado_codigo'],
                        'tipo_estado_nombre'                                =>       trim(strtoupper($rowMSSQL00['tipo_estado_nombre'])),
                        'tipo_estado_parametro'                             =>       $rowMSSQL00['tipo_estado_parametro'],
                        'tipo_estado_css'                                   =>       trim(strtolower($rowMSSQL00['tipo_estado_css'])),

                        'tipo_solicitud_codigo'                             =>       $rowMSSQL00['tipo_solicitud_codigo'],
                        'tipo_solicitud_nombre'                             =>       trim(strtoupper($rowMSSQL00['tipo_solicitud_nombre'])),
                        'tipo_solicitud_parametro'                          =>       $rowMSSQL00['tipo_solicitud_parametro'],
                        'tipo_solicitud_css'                                =>       trim(strtolower($rowMSSQL00['tipo_solicitud_css'])),

                        'solicitud_codigo'                                  =>       $rowMSSQL00['solicitud_codigo'],
                        'solicitud_periodo'                                 =>       $rowMSSQL00['solicitud_periodo'],
                        'solicitud_motivo'                                  =>       trim(strtoupper($rowMSSQL00['solicitud_motivo'])),
                        'solicitud_vuelo'                                   =>       trim(strtoupper($rowMSSQL00['solicitud_vuelo'])),
                        'solicitud_hospedaje'                               =>       trim(strtoupper($rowMSSQL00['solicitud_hospedaje'])),
                        'solicitud_traslado'                                =>       trim(strtoupper($rowMSSQL00['solicitud_traslado'])),
                        'solicitud_fecha_carga'                             =>       date("d/m/Y", strtotime($rowMSSQL00['solicitud_fecha_carga'])),
                        'solicitud_sap_centro_costo'                        =>       trim(strtoupper($rowMSSQL00['solicitud_sap_centro_costo'])),     
                        'solicitud_tarea_cantidad'                          =>       $rowMSSQL00['solicitud_tarea_cantidad'],
                        'solicitud_tarea_resuelta'                          =>       $rowMSSQL00['solicitud_tarea_resuelta'],
                        'solicitud_observacion'                             =>       trim(strtoupper($rowMSSQL00['solicitud_observacion'])),

                        'auditoria_usuario'                                 =>       trim(strtoupper($rowMSSQL00['auditoria_usuario'])),
                        'auditoria_fecha_hora'                              =>       date("d/m/Y H:i:s", strtotime($rowMSSQL00['auditoria_fecha_hora'])),
                        'auditoria_ip'                                      =>       trim(strtoupper($rowMSSQL00['auditoria_ip']))
                     );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else { 
                    $detalle    =   array(
                        'solicitud_opcioncabecera_codigo'                   => '',
                        'solicitud_opcioncabecera_nombre'                   => '',
                        'solicitud_opcioncabecera_tarifa_importe'           => '',
                        'solicitud_opcioncabecera_visualiza_solicitante'    => '',
                        'solicitud_opcioncabecera_visualiza_jefatura'       => '',
                        'solicitud_opcioncabecera_visualiza_ejecutivo'      => '',
                        'solicitud_opcioncabecera_visualiza_proveedor'      => '',
                        'solicitud_opcioncabecera_reserva'                  => '',
                        'solicitud_opcioncabecera_comentario_1'             => '',
                        'solicitud_opcioncabecera_comentario_2'             => '',
                        'solicitud_opcioncabecera_comentario_3'             => '',
                        'solicitud_opcioncabecera_comentario_4'             => '',
                        'solicitud_opcioncabecera_directorio'               => '',

                        'tipo_estado_codigo'                                => '',
                        'tipo_estado_nombre'                                => '',
                        'tipo_estado_parametro'                             => '',
                        'tipo_estado_css'                                   => '',

                        'tipo_solicitud_codigo'                             => '',
                        'tipo_solicitud_nombre'                             => '',
                        'tipo_solicitud_parametro'                          => '',
                        'tipo_solicitud_css'                                => '',
                        
                        'solicitud_codigo'                                  => '',
                        'solicitud_periodo'                                 => '',
                        'solicitud_motivo'                                  => '',
                        'solicitud_pasaje'                                  => '',
                        'solicitud_hospedaje'                               => '',
                        'solicitud_traslado'                                => '',
                        'solicitud_fecha_carga'                             => '',
                        'solicitud_sap_centro_costo'                        => '', 
                        'solicitud_tarea_cantidad'                          => '',
                        'solicitud_tarea_resuelta'                          => '',
                        'solicitud_observacion'                             => '',

                        'proveedor_codigo'                                  => '',
                        'proveedor_nombre'                                  => '',
                        'proveedor_razon_social'                            => '',
                        'proveedor_ruc'                                     => '',
                        'proveedor_direccion'                               => '',
                        'proveedor_sap_castastrado'                         => '',
                        'proveedor_sap_codigo'                              => '',
                        'proveedor_observacion'                             => '',

                        'auditoria_usuario'                                 => '',
                        'auditoria_fecha_hora'                              => '',
                        'auditoria_ip'                                      => ''
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

    $app->get('/v2/400/solicitud/opcion/vuelo/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val01  = $request->getAttribute('codigo');

        if(isset($val01)) {
            $sql00  = "SELECT 
                a.SOLOPVCOD     AS      solicitud_opcion_vuelo_codigo,
                a.SOLOPVVUE     AS      solicitud_opcion_vuelo_vuelo,	
                a.SOLOPVCOM     AS      solicitud_opcion_vuelo_companhia,	
                a.SOLOPVFEC	    AS      solicitud_opcion_vuelo_fecha,
                a.SOLOPVDES     AS      solicitud_opcion_vuelo_desde,  	
                a.SOLOPVHAS     AS      solicitud_opcion_vuelo_hasta,	
                a.SOLOPVSAL	    AS      solicitud_opcion_vuelo_salida,
                a.SOLOPVLLE	    AS      solicitud_opcion_vuelo_llegada,    
                a.SOLOPVOBS     AS      solicitud_opcion_vuelo_observacion,
                
                a.SOLOPVAUS	    AS      auditoria_usuario,
                a.SOLOPVAFH     AS      auditoria_fecha_hora,	
                a.SOLOPVAIP     AS      auditoria_ip,
                
                b.DOMFICCOD     AS      tipo_estado_codigo,
                b.DOMFICNOC     AS      tipo_estado_nombre,
                b.DOMFICPAR     AS      tipo_estado_parametro,
                b.DOMFICCSS     AS      tipo_estado_css,
                
                c.SOLOPCCOD     AS      solicitud_opcion_cabecera_codigo,
                c.SOLOPCOPC     AS      solicitud_opcion_cabecera_nombre,
                c.SOLOPCTIM     AS      solicitud_opcion_cabecera_tarifa_importe,
                c.SOLOPCRES     AS      solicitud_opcion_cabecera_reserva,
                c.SOLOPCCO1     AS      solicitud_opcion_cabecera_comentario_1,
                c.SOLOPCCO2     AS      solicitud_opcion_cabecera_comentario_2,
                c.SOLOPCCO3     AS      solicitud_opcion_cabecera_comentario_3,
                c.SOLOPCCO4     AS      solicitud_opcion_cabecera_comentario_4,
                c.SOLOPCPAT     AS      solicitud_opcion_cabecera_directorio,

                d.SOLFICCOD     AS      solicitud_codigo,
                d.SOLFICPER     AS      solicitud_periodo,
                d.SOLFICMOT     AS      solicitud_motivo,
                d.SOLFICVUE     AS      solicitud_vuelo,
                d.SOLFICHOS     AS      solicitud_hospedaje,
                d.SOLFICTRA     AS      solicitud_traslado,
                d.SOLFICFEC     AS      solicitud_fecha_carga,
                d.SOLFICSCC     AS      solicitud_sap_centro_costo,
                d.SOLFICTCA     AS      solicitud_tarea_cantidad,
                d.SOLFICTRE     AS      solicitud_tarea_resuelta,
                d.SOLFICOBS     AS      solicitud_observacion,

                e.AERFICCOD     AS      aerolinea_codigo,
                e.AERFICORD     AS      aerolinea_orden,
                e.AERFICNOM     AS      aerolinea_nombre
                
                FROM via.SOLOPV a
                INNER JOIN adm.DOMFIC b ON a.SOLOPVEST = b.DOMFICCOD
                INNER JOIN via.SOLOPC c ON a.SOLOPVOPC = c.SOLOPCCOD
                INNER JOIN via.SOLFIC d ON c.SOLOPCSOC = d.SOLFICCOD
                INNER JOIN via.AERFIC e ON a.SOLOPVAEC = e.AERFICCOD

                WHERE c.SOLOPCSOC = ?
                
                ORDER BY a.SOLOPVCOD";

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

                    $detalle    = array(
                        'solicitud_opcion_vuelo_codigo'                      => $rowMSSQL00['solicitud_opcion_vuelo_codigo'],
                        'solicitud_opcion_vuelo_vuelo'                       => trim(strtoupper(strtolower($rowMSSQL00['solicitud_opcion_vuelo_vuelo']))),
                        'solicitud_opcion_vuelo_companhia'                   => trim(strtoupper(strtolower($rowMSSQL00['solicitud_opcion_vuelo_companhia']))),
                        'solicitud_opcion_vuelo_fecha'                       => trim(strtoupper(strtolower($rowMSSQL00['solicitud_opcion_vuelo_fecha']))),
                        'solicitud_opcion_vuelo_desde'                       => trim(strtoupper(strtolower($rowMSSQL00['solicitud_opcion_vuelo_desde']))),
                        'solicitud_opcion_vuelo_hasta'                       => trim(strtoupper(strtolower($rowMSSQL00['solicitud_opcion_vuelo_hasta']))),
                        'solicitud_opcion_vuelo_salida'                      => trim(strtoupper(strtolower($rowMSSQL00['solicitud_opcion_vuelo_salida']))),
                        'solicitud_opcion_vuelo_llegada'                     => trim(strtoupper(strtolower($rowMSSQL00['solicitud_opcion_vuelo_llegada']))),
                        'solicitud_opcion_vuelo_observacion'                 => trim(strtoupper(strtolower($rowMSSQL00['solicitud_opcion_vuelo_observacion']))),

                        'auditoria_usuario'                                 => trim(strtoupper(strtolower($rowMSSQL00['auditoria_usuario']))),
                        'auditoria_fecha_hora'                              => $rowMSSQL00['auditoria_fecha_hora'],
                        'auditoria_ip'                                      => trim(strtoupper(strtolower($rowMSSQL00['auditoria_ip']))),

                        'tipo_estado_codigo'                                => $rowMSSQL00['tipo_estado_codigo'],
                        'tipo_estado_nombre'                                => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_nombre']))),
                        'tipo_estado_parametro'                             => $rowMSSQL00['tipo_estado_parametro'],
                        'tipo_estado_css'                                   => trim(strtolower($rowMSSQL00['tipo_estado_css'])),

                        'solicitud_opcion_cabecera_codigo'                   => $rowMSSQL00['solicitud_opcion_cabecera_codigo'],
                        'solicitud_opcion_cabecera_nombre'                   => trim(strtoupper($rowMSSQL00['solicitud_opcion_cabecera_nombre'])),
                        'solicitud_opcion_cabecera_tarifa_importe'           => $rowMSSQL00['solicitud_opcion_cabecera_tarifa_importe'],
                        'solicitud_opcion_cabecera_reserva'                  => trim(strtoupper($rowMSSQL00['solicitud_opcion_cabecera_reserva'])),
                        'solicitud_opcion_cabecera_comentario_1'             => trim(strtoupper($rowMSSQL00['solicitud_opcion_cabecera_comentario_1'])),
                        'solicitud_opcion_cabecera_comentario_2'             => trim(strtoupper($rowMSSQL00['solicitud_opcion_cabecera_comentario_2'])),
                        'solicitud_opcion_cabecera_comentario_3'             => trim(strtoupper($rowMSSQL00['solicitud_opcion_cabecera_comentario_3'])),
                        'solicitud_opcion_cabecera_comentario_4'             => trim(strtoupper($rowMSSQL00['solicitud_opcion_cabecera_comentario_4'])),
                        'solicitud_opcion_cabecera_directorio'               => trim(strtolower($rowMSSQL00['solicitud_opcion_cabecera_directorio'])),

                        'solicitud_codigo'                                  => $rowMSSQL00['solicitud_codigo'],
                        'solicitud_periodo'                                 => $rowMSSQL00['solicitud_periodo'],
                        'solicitud_motivo'                                  => trim(strtoupper(strtolower($rowMSSQL00['solicitud_motivo']))),
                        'solicitud_vuelo'                                   => trim(strtoupper(strtolower($rowMSSQL00['solicitud_vuelo']))),
                        'solicitud_hospedaje'                               => trim(strtoupper(strtolower($rowMSSQL00['solicitud_hospedaje']))),
                        'solicitud_traslado'                                => trim(strtoupper(strtolower($rowMSSQL00['solicitud_traslado']))),
                        'solicitud_fecha_carga_1'                           => $rowMSSQL00['solicitud_fecha_carga'],
                        'solicitud_fecha_carga_2'                           => $solicitud_fecha_carga_2,
                        'solicitud_sap_centro_costo'                        => trim(strtoupper(strtolower($rowMSSQL00['solicitud_sap_centro_costo']))),
                        'solicitud_tarea_cantidad'                          => $rowMSSQL00['solicitud_tarea_cantidad'],
                        'solicitud_tarea_resuelta'                          => $rowMSSQL00['solicitud_tarea_resuelta'],
                        'solicitud_tarea_porcentaje'                        => number_format((($rowMSSQL00['solicitud_tarea_resuelta'] * 100) / $rowMSSQL00['solicitud_tarea_cantidad']), 2, '.', ''),
                        'solicitud_observacion'                             => trim(strtoupper(strtolower($rowMSSQL00['solicitud_observacion']))),

                        'aerolinea_codigo'                                  => $rowMSSQL00['aerolinea_codigo'],
                        'aerolinea_orden'                                   => $rowMSSQL00['aerolinea_orden'],
                        'aerolinea_nombre'                                  => trim(strtoupper(strtolower($rowMSSQL00['aerolinea_nombre']))),
                        'aerolinea_observacion'                             => trim(strtoupper(strtolower($rowMSSQL00['aerolinea_observacion']))),
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'solicitud_opcion_vuelo_codigo'              => '',
                        'solicitud_opcion_vuelo_vuelo'               => '',
                        'solicitud_opcion_vuelo_companhia'           => '',
                        'solicitud_opcion_vuelo_fecha'               => '',
                        'solicitud_opcion_vuelo_desde'               => '',
                        'solicitud_opcion_vuelo_hasta'               => '',
                        'solicitud_opcion_vuelo_salida_llegada'      => '',
                        'solicitud_opcion_vuelo_observacion'         => '',

                        'tipo_icono'                                => '',
                        'tipo_dominio'                              => '',
                        'tipo_observacion'                          => '',

                        'auditoria_usuario'                         => '',
                        'auditoria_fecha_hora'                      => '',
                        'auditoria_ip'                              => '',

                        'solicitud_opcion_cabecera_codigo'           => '',
                        'solicitud_opcion_cabecera_nombre'           => '',
                        'solicitud_opcion_cabecera_tarifa'           => '',
                        'solicitud_opcion_cabecera_observacion'      => '',
                        'solicitud_opcion_cabecera_directorio'       => '',

                        'solicitud_codigo'                          => '',
                        'solicitud_periodo'                         => '',
                        'solicitud_motivo'                          => '',
                        'solicitud_vuelo'                           => '',
                        'solicitud_hospedaje'                       => '',
                        'solicitud_traslado'                        => '',
                        'solicitud_fecha_carga_1'                   => '',
                        'solicitud_fecha_carga_2'                   => '',
                        'solicitud_sap_centro_costo'                => '',
                        'solicitud_tarea_cantidad'                  => '',
                        'solicitud_tarea_resuelta'                  => '',
                        'solicitud_tarea_porcentaje'                => '',
                        'solicitud_observacion'                     => ''
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

    $app->get('/v2/400/solicitud/opcion/hospedaje/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val01  = $request->getAttribute('codigo');

        if(isset($val01)) {
            $sql00  = "SELECT 
                a.SOLOPHCOD     AS      solicitud_opcionhospedaje_codigo,
                a.SOLOPHHOS     AS      solicitud_opcionhospedaje_hospedaje,	
                a.SOLOPHDIR     AS      solicitud_opcionhospedaje_direccion,	
                a.SOLOPHFIN	    AS      solicitud_opcionhospedaje_fecha_desde,
                a.SOLOPHFOU     AS      solicitud_opcionhospedaje_fecha_hasta,  	
                a.SOLOPHCAN     AS      solicitud_opcionhospedaje_cantidad,	
                a.SOLOPHTNO	    AS      solicitud_opcionhospedaje_tarifa_noche,
                a.SOLOPHTCO	    AS      solicitud_opcionhospedaje_tarifa_consumo,    
                a.SOLOPHTLA     AS      solicitud_opcionhospedaje_tarifa_lavanderia,
                a.SOLOPHTAD     AS      solicitud_opcionhospedaje_tarifa_adicional,
                a.SOLOPHOBS     AS      solicitud_opcionhospedaje_observacion,

                a.SOLOPHAUS     AS      auditoria_usuario,
                a.SOLOPHAFH     AS      auditoria_fecha_hora,
                a.SOLOPHAIP     AS      auditoria_ip,

                b.DOMFICCOD     AS      tipo_estado_codigo,
                b.DOMFICNOC     AS      tipo_estado_nombre,
                b.DOMFICPAR     AS      tipo_estado_parametro,
                b.DOMFICCSS     AS      tipo_estado_css,

                c.DOMFICCOD     AS      tipo_habitacion_codigo,
                c.DOMFICNOC     AS      tipo_habitacion_nombre,
                c.DOMFICPAR     AS      tipo_habitacion_parametro,
                c.DOMFICCSS     AS      tipo_habitacion_css,
                
                d.SOLOPCCOD     AS      solicitud_opcioncabecera_codigo,
                d.SOLOPCOPC     AS      solicitud_opcioncabecera_nombre,
                d.SOLOPCTIM     AS      solicitud_opcioncabecera_tarifa_importe,
                d.SOLOPCTVS     AS      solicitud_opcioncabecera_visualiza_solicitante,
                d.SOLOPCTVJ     AS      solicitud_opcioncabecera_visualiza_jefatura,
                d.SOLOPCTVE     AS      solicitud_opcioncabecera_visualiza_ejecutivo,
                d.SOLOPCTVP     AS      solicitud_opcioncabecera_visualiza_proveedor,
                d.SOLOPCRES     AS      solicitud_opcioncabecera_reserva,
                d.SOLOPCCO1     AS      solicitud_opcioncabecera_comentario_1,
                d.SOLOPCCO2     AS      solicitud_opcioncabecera_comentario_2,
                d.SOLOPCCO3     AS      solicitud_opcioncabecera_comentario_3,
                d.SOLOPCCO4     AS      solicitud_opcioncabecera_comentario_4,
                d.SOLOPCPAT     AS      solicitud_opcioncabecera_directorio,

                e.SOLFICCOD     AS      solicitud_codigo,
                e.SOLFICPER     AS      solicitud_periodo,
                e.SOLFICMOT     AS      solicitud_motivo,
                e.SOLFICPAS     AS      solicitud_pasaje,
                e.SOLFICHOS     AS      solicitud_hospedaje,
                e.SOLFICTRA     AS      solicitud_traslado,
                e.SOLFICFEC     AS      solicitud_fecha_carga,
                e.SOLFICSCC     AS      solicitud_sap_centro_costo,
                e.SOLFICTCA     AS      solicitud_tarea_cantidad,
                e.SOLFICTRE     AS      solicitud_tarea_resuelta,
                e.SOLFICOBS     AS      solicitud_observacion
                
                FROM via.SOLOPH a
                INNER JOIN adm.DOMFIC b ON a.SOLOPHEST = b.DOMFICCOD
                INNER JOIN adm.DOMFIC c ON a.SOLOPHTHC = c.DOMFICCOD
                INNER JOIN via.SOLOPC d ON a.SOLOPHOPC = d.SOLOPCCOD
                INNER JOIN via.SOLFIC e ON d.SOLOPCSOC = e.SOLFICCOD

                WHERE d.SOLOPCSOC = ?
                
                ORDER BY a.SOLOPHCOD";

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

                    if(!empty($rowMSSQL00['solicitud_opcionhospedaje_fecha_desde'])){
                        $solicitud_opcionhospedaje_fecha_desde_2    = date("d/m/Y", strtotime($rowMSSQL00['solicitud_opcionhospedaje_fecha_desde']));
                    } else {
                        $solicitud_opcionhospedaje_fecha_desde_2    = '';
                    }

                    if(!empty($rowMSSQL00['solicitud_opcionhospedaje_fecha_hasta'])){
                        $solicitud_opcionhospedaje_fecha_hasta_2    = date("d/m/Y", strtotime($rowMSSQL00['solicitud_opcionhospedaje_fecha_hasta']));
                    } else {
                        $solicitud_opcionhospedaje_fecha_hasta_2    = '';
                    }

                    $detalle    = array(
                        'solicitud_opcionhospedaje_codigo'                  => $rowMSSQL00['solicitud_opcionhospedaje_codigo'],
                        'solicitud_opcionhospedaje_hospedaje'               => trim(strtoupper(strtolower($rowMSSQL00['solicitud_opcionhospedaje_hospedaje']))),
                        'solicitud_opcionhospedaje_direccion'               => trim(strtoupper(strtolower($rowMSSQL00['solicitud_opcionhospedaje_direccion']))),
                        'solicitud_opcionhospedaje_fecha_desde_1'           => $rowMSSQL00['solicitud_opcionhospedaje_fecha_desde'],
                        'solicitud_opcionhospedaje_fecha_desde_2'           => $solicitud_opcionhospedaje_fecha_desde_2,
                        'solicitud_opcionhospedaje_fecha_hasta_1'           => $rowMSSQL00['solicitud_opcionhospedaje_fecha_hasta'],
                        'solicitud_opcionhospedaje_fecha_hasta_2'           => $solicitud_opcionhospedaje_fecha_hasta_2,
                        'solicitud_opcionhospedaje_cantidad'                => $rowMSSQL00['solicitud_opcionhospedaje_cantidad'],
                        'solicitud_opcionhospedaje_tarifa_noche'            => $rowMSSQL00['solicitud_opcionhospedaje_tarifa_noche'],
                        'solicitud_opcionhospedaje_tarifa_consumo'          => $rowMSSQL00['solicitud_opcionhospedaje_tarifa_consumo'],
                        'solicitud_opcionhospedaje_tarifa_lavanderia'       => $rowMSSQL00['solicitud_opcionhospedaje_tarifa_lavanderia'],
                        'solicitud_opcionhospedaje_tarifa_adicional'        => $rowMSSQL00['solicitud_opcionhospedaje_tarifa_adicional'],
                        'solicitud_opcionhospedaje_observacion'             => trim(strtoupper(strtolower($rowMSSQL00['solicitud_opcionhospedaje_observacion']))),

                        'auditoria_usuario'                                 => trim(strtoupper(strtolower($rowMSSQL00['auditoria_usuario']))),
                        'auditoria_fecha_hora'                              => $rowMSSQL00['auditoria_fecha_hora'],
                        'auditoria_ip'                                      => trim(strtoupper(strtolower($rowMSSQL00['auditoria_ip']))),

                        'tipo_estado_codigo'                                => $rowMSSQL00['tipo_estado_codigo'],
                        'tipo_estado_nombre'                                => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_nombre']))),
                        'tipo_estado_parametro'                             => $rowMSSQL00['tipo_estado_parametro'],
                        'tipo_estado_css'                                   => trim(strtolower($rowMSSQL00['tipo_estado_css'])),

                        'tipo_habitacion_codigo'                            => $rowMSSQL00['tipo_habitacion_codigo'],
                        'tipo_habitacion_nombre'                            => trim(strtoupper(strtolower($rowMSSQL00['tipo_habitacion_nombre']))),
                        'tipo_habitacion_parametro'                         => $rowMSSQL00['tipo_habitacion_parametro'],
                        'tipo_habitacion_css'                               => trim(strtolower($rowMSSQL00['tipo_habitacion_css'])),

                        'solicitud_opcioncabecera_codigo'                   => $rowMSSQL00['solicitud_opcioncabecera_codigo'],
                        'solicitud_opcioncabecera_nombre'                   => trim(strtoupper($rowMSSQL00['solicitud_opcioncabecera_nombre'])),
                        'solicitud_opcioncabecera_tarifa_importe'           => $rowMSSQL00['solicitud_opcioncabecera_tarifa_importe'],
                        'solicitud_opcioncabecera_visualiza_solicitante'    => trim(strtoupper($rowMSSQL00['solicitud_opcioncabecera_visualiza_solicitante'])),
                        'solicitud_opcioncabecera_visualiza_jefatura'       => trim(strtoupper($rowMSSQL00['solicitud_opcioncabecera_visualiza_jefatura'])),
                        'solicitud_opcioncabecera_visualiza_ejecutivo'      => trim(strtoupper($rowMSSQL00['solicitud_opcioncabecera_visualiza_ejecutivo'])),
                        'solicitud_opcioncabecera_visualiza_proveedor'      => trim(strtoupper($rowMSSQL00['solicitud_opcioncabecera_visualiza_proveedor'])),
                        'solicitud_opcioncabecera_reserva'                  => trim(strtoupper($rowMSSQL00['solicitud_opcioncabecera_reserva'])),
                        'solicitud_opcioncabecera_comentario_1'             => trim(strtoupper($rowMSSQL00['solicitud_opcioncabecera_comentario_1'])),
                        'solicitud_opcioncabecera_comentario_2'             => trim(strtoupper($rowMSSQL00['solicitud_opcioncabecera_comentario_2'])),
                        'solicitud_opcioncabecera_comentario_3'             => trim(strtoupper($rowMSSQL00['solicitud_opcioncabecera_comentario_3'])),
                        'solicitud_opcioncabecera_comentario_4'             => trim(strtoupper($rowMSSQL00['solicitud_opcioncabecera_comentario_4'])),
                        'solicitud_opcioncabecera_directorio'               => trim(strtolower($rowMSSQL00['solicitud_opcioncabecera_directorio'])),

                        'solicitud_codigo'                                  => $rowMSSQL00['solicitud_codigo'],
                        'solicitud_periodo'                                 => $rowMSSQL00['solicitud_periodo'],
                        'solicitud_motivo'                                  => trim(strtoupper(strtolower($rowMSSQL00['solicitud_motivo']))),
                        'solicitud_pasaje'                                  => trim(strtoupper(strtolower($rowMSSQL00['solicitud_pasaje']))),
                        'solicitud_hospedaje'                               => trim(strtoupper(strtolower($rowMSSQL00['solicitud_hospedaje']))),
                        'solicitud_traslado'                                => trim(strtoupper(strtolower($rowMSSQL00['solicitud_traslado']))),
                        'solicitud_fecha_carga_1'                           => $rowMSSQL00['solicitud_fecha_carga'],
                        'solicitud_fecha_carga_2'                           => $solicitud_fecha_carga_2,
                        'solicitud_sap_centro_costo'                        => trim(strtoupper(strtolower($rowMSSQL00['solicitud_sap_centro_costo']))),
                        'solicitud_tarea_cantidad'                          => $rowMSSQL00['solicitud_tarea_cantidad'],
                        'solicitud_tarea_resuelta'                          => $rowMSSQL00['solicitud_tarea_resuelta'],
                        'solicitud_tarea_porcentaje'                        => number_format((($rowMSSQL00['solicitud_tarea_resuelta'] * 100) / $rowMSSQL00['solicitud_tarea_cantidad']), 2, '.', ''),
                        'solicitud_observacion'                             => trim(strtoupper(strtolower($rowMSSQL00['solicitud_observacion'])))
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'solicitud_opcionhospedaje_codigo'                  => '',
                        'solicitud_opcionhospedaje_hospedaje'               => '',
                        'solicitud_opcionhospedaje_direccion'               => '',
                        'solicitud_opcionhospedaje_fecha_desde_1'           => '',
                        'solicitud_opcionhospedaje_fecha_desde_2'           => '',
                        'solicitud_opcionhospedaje_fecha_hasta_1'           => '',
                        'solicitud_opcionhospedaje_fecha_hasta_2'           => '',
                        'solicitud_opcionhospedaje_cantidad'                => '',
                        'solicitud_opcionhospedaje_tarifa_noche'            => '',
                        'solicitud_opcionhospedaje_tarifa_consumo'          => '',
                        'solicitud_opcionhospedaje_tarifa_lavanderia'       => '',
                        'solicitud_opcionhospedaje_tarifa_adicional'        => '',
                        'solicitud_opcionhospedaje_observacion'             => '',

                        'auditoria_usuario'                                 => '',
                        'auditoria_fecha_hora'                              => '',
                        'auditoria_ip'                                      => '',

                        'tipo_estado_codigo'                                => '',
                        'tipo_estado_nombre'                                => '',
                        'tipo_estado_parametro'                             => '',
                        'tipo_estado_css'                                   => '',

                        'tipo_habitacion_codigo'                            => '',
                        'tipo_habitacion_nombre'                            => '',
                        'tipo_habitacion_parametro'                         => '',
                        'tipo_habitacion_css'                               => '',

                        'solicitud_opcioncabecera_codigo'                   => '',
                        'solicitud_opcioncabecera_nombre'                   => '',
                        'solicitud_opcioncabecera_tarifa'                   => '',
                        'solicitud_opcioncabecera_ver_solicitante'          => '',
                        'solicitud_opcioncabecera_ver_jefatura'             => '',
                        'solicitud_opcioncabecera_ver_ejecutivo'            => '',
                        'solicitud_opcioncabecera_ver_proveedor'            => '',
                        'solicitud_opcioncabecera_observacion'              => '',
                        'solicitud_opcioncabecera_directorio'               => '',

                        'solicitud_codigo'                                  => '',
                        'solicitud_periodo'                                 => '',
                        'solicitud_motivo'                                  => '',
                        'solicitud_pasaje'                                  => '',
                        'solicitud_hospedaje'                               => '',
                        'solicitud_traslado'                                => '',
                        'solicitud_fecha_carga_1'                           => '',
                        'solicitud_fecha_carga_2'                           => '',
                        'solicitud_sap_centro_costo'                        => '',
                        'solicitud_tarea_cantidad'                          => '',
                        'solicitud_tarea_resuelta'                          => '',
                        'solicitud_tarea_porcentaje'                        => '',
                        'solicitud_observacion'                             => ''
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

    $app->get('/v2/400/solicitud/opcion/traslado/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val01  = $request->getAttribute('codigo');

        if(isset($val01)) {
            $sql00  = "SELECT 
                a.SOLOPTCOD     AS      solicitud_opciontraslado_codigo,
                a.SOLOPTTRA     AS      solicitud_opciontraslado_traslado,	
                a.SOLOPTTAR     AS      solicitud_opciontraslado_tarifa_dia,	
                a.SOLOPTOBS	    AS      solicitud_opciontraslado_observacion,

                a.SOLOPHAUS     AS      auditoria_usuario,
                a.SOLOPHAFH     AS      auditoria_fecha_hora,
                a.SOLOPHAIP     AS      auditoria_ip,

                b.DOMFICCOD     AS      tipo_estado_codigo,
                b.DOMFICNOC     AS      tipo_estado_nombre,
                b.DOMFICPAR     AS      tipo_estado_parametro,
                b.DOMFICCSS     AS      tipo_estado_css,

                c.DOMFICCOD     AS      tipo_vehiculo_codigo,
                c.DOMFICNOC     AS      tipo_vehiculo_nombre,
                c.DOMFICPAR     AS      tipo_vehiculo_parametro,
                c.DOMFICCSS     AS      tipo_vehiculo_css,
                
                d.SOLOPCCOD     AS      solicitud_opcioncabecera_codigo,
                d.SOLOPCOPC     AS      solicitud_opcioncabecera_nombre,
                d.SOLOPCTIM     AS      solicitud_opcioncabecera_tarifa_importe,
                d.SOLOPCTVS     AS      solicitud_opcioncabecera_visualiza_solicitante,
                d.SOLOPCTVJ     AS      solicitud_opcioncabecera_visualiza_jefatura,
                d.SOLOPCTVE     AS      solicitud_opcioncabecera_visualiza_ejecutivo,
                d.SOLOPCTVP     AS      solicitud_opcioncabecera_visualiza_proveedor,
                d.SOLOPCRES     AS      solicitud_opcioncabecera_reserva,
                d.SOLOPCCO1     AS      solicitud_opcioncabecera_comentario_1,
                d.SOLOPCCO2     AS      solicitud_opcioncabecera_comentario_2,
                d.SOLOPCCO3     AS      solicitud_opcioncabecera_comentario_3,
                d.SOLOPCCO4     AS      solicitud_opcioncabecera_comentario_4,
                d.SOLOPCPAT     AS      solicitud_opcioncabecera_directorio,

                e.SOLFICCOD     AS      solicitud_codigo,
                e.SOLFICPER     AS      solicitud_periodo,
                e.SOLFICMOT     AS      solicitud_motivo,
                e.SOLFICPAS     AS      solicitud_pasaje,
                e.SOLFICHOS     AS      solicitud_hospedaje,
                e.SOLFICTRA     AS      solicitud_traslado,
                e.SOLFICFEC     AS      solicitud_fecha_carga,
                e.SOLFICSCC     AS      solicitud_sap_centro_costo,
                e.SOLFICTCA     AS      solicitud_tarea_cantidad,
                e.SOLFICTRE     AS      solicitud_tarea_resuelta,
                e.SOLFICOBS     AS      solicitud_observacion
                
                FROM via.SOLOPT a
                INNER JOIN adm.DOMFIC b ON a.SOLOPTEST = b.DOMFICCOD
                INNER JOIN adm.DOMFIC c ON a.SOLOPTTVC = c.DOMFICCOD
                INNER JOIN via.SOLOPC d ON a.SOLOPTOPC = d.SOLOPCCOD
                INNER JOIN via.SOLFIC e ON d.SOLOPCSOC = e.SOLFICCOD

                WHERE d.SOLOPCSOC = ?
                
                ORDER BY a.SOLOPHCOD";

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

                    $detalle    = array(
                        'solicitud_opciontraslado_codigo'                   => $rowMSSQL00['solicitud_opciontraslado_codigo'],
                        'solicitud_opciontraslado_traslado'                 => trim(strtoupper(strtolower($rowMSSQL00['solicitud_opciontraslado_traslado']))),
                        'solicitud_opciontraslado_tarifa_dia'               => $rowMSSQL00['solicitud_opciontraslado_tarifa_dia'],
                        'solicitud_opciontraslado_observacion'              => trim(strtoupper(strtolower($rowMSSQL00['solicitud_opciontraslado_observacion']))),

                        'auditoria_usuario'                                 => trim(strtoupper(strtolower($rowMSSQL00['auditoria_usuario']))),
                        'auditoria_fecha_hora'                              => $rowMSSQL00['auditoria_fecha_hora'],
                        'auditoria_ip'                                      => trim(strtoupper(strtolower($rowMSSQL00['auditoria_ip']))),

                        'tipo_estado_codigo'                                => $rowMSSQL00['tipo_estado_codigo'],
                        'tipo_estado_nombre'                                => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_nombre']))),
                        'tipo_estado_parametro'                             => $rowMSSQL00['tipo_estado_parametro'],
                        'tipo_estado_css'                                   => trim(strtolower($rowMSSQL00['tipo_estado_css'])),

                        'tipo_vehiculo_codigo'                              => $rowMSSQL00['tipo_vehiculo_codigo'],
                        'tipo_vehiculo_nombre'                              => trim(strtoupper(strtolower($rowMSSQL00['tipo_vehiculo_nombre']))),
                        'tipo_vehiculo_parametro'                           => $rowMSSQL00['tipo_vehiculo_parametro'],
                        'tipo_vehiculo_css'                                 => trim(strtolower($rowMSSQL00['tipo_vehiculo_css'])),

                        'solicitud_opcioncabecera_codigo'                   => $rowMSSQL00['solicitud_opcioncabecera_codigo'],
                        'solicitud_opcioncabecera_nombre'                   => trim(strtoupper($rowMSSQL00['solicitud_opcioncabecera_nombre'])),
                        'solicitud_opcioncabecera_tarifa_importe'           => $rowMSSQL00['solicitud_opcioncabecera_tarifa_importe'],
                        'solicitud_opcioncabecera_visualiza_solicitante'    => trim(strtoupper($rowMSSQL00['solicitud_opcioncabecera_visualiza_solicitante'])),
                        'solicitud_opcioncabecera_visualiza_jefatura'       => trim(strtoupper($rowMSSQL00['solicitud_opcioncabecera_visualiza_jefatura'])),
                        'solicitud_opcioncabecera_visualiza_ejecutivo'      => trim(strtoupper($rowMSSQL00['solicitud_opcioncabecera_visualiza_ejecutivo'])),
                        'solicitud_opcioncabecera_visualiza_proveedor'      => trim(strtoupper($rowMSSQL00['solicitud_opcioncabecera_visualiza_proveedor'])),
                        'solicitud_opcioncabecera_reserva'                  => trim(strtoupper($rowMSSQL00['solicitud_opcioncabecera_reserva'])),
                        'solicitud_opcioncabecera_comentario_1'             => trim(strtoupper($rowMSSQL00['solicitud_opcioncabecera_comentario_1'])),
                        'solicitud_opcioncabecera_comentario_2'             => trim(strtoupper($rowMSSQL00['solicitud_opcioncabecera_comentario_2'])),
                        'solicitud_opcioncabecera_comentario_3'             => trim(strtoupper($rowMSSQL00['solicitud_opcioncabecera_comentario_3'])),
                        'solicitud_opcioncabecera_comentario_4'             => trim(strtoupper($rowMSSQL00['solicitud_opcioncabecera_comentario_4'])),
                        'solicitud_opcioncabecera_directorio'               => trim(strtolower($rowMSSQL00['solicitud_opcioncabecera_directorio'])),

                        'solicitud_codigo'                                  => $rowMSSQL00['solicitud_codigo'],
                        'solicitud_periodo'                                 => $rowMSSQL00['solicitud_periodo'],
                        'solicitud_motivo'                                  => trim(strtoupper(strtolower($rowMSSQL00['solicitud_motivo']))),
                        'solicitud_pasaje'                                  => trim(strtoupper(strtolower($rowMSSQL00['solicitud_pasaje']))),
                        'solicitud_hospedaje'                               => trim(strtoupper(strtolower($rowMSSQL00['solicitud_hospedaje']))),
                        'solicitud_traslado'                                => trim(strtoupper(strtolower($rowMSSQL00['solicitud_traslado']))),
                        'solicitud_fecha_carga_1'                           => $rowMSSQL00['solicitud_fecha_carga'],
                        'solicitud_fecha_carga_2'                           => $solicitud_fecha_carga_2,
                        'solicitud_sap_centro_costo'                        => trim(strtoupper(strtolower($rowMSSQL00['solicitud_sap_centro_costo']))),
                        'solicitud_tarea_cantidad'                          => $rowMSSQL00['solicitud_tarea_cantidad'],
                        'solicitud_tarea_resuelta'                          => $rowMSSQL00['solicitud_tarea_resuelta'],
                        'solicitud_tarea_porcentaje'                        => number_format((($rowMSSQL00['solicitud_tarea_resuelta'] * 100) / $rowMSSQL00['solicitud_tarea_cantidad']), 2, '.', ''),
                        'solicitud_observacion'                             => trim(strtoupper(strtolower($rowMSSQL00['solicitud_observacion'])))
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'solicitud_opciontraslado_codigo'                   => '',
                        'solicitud_opciontraslado_traslado'                 => '',
                        'solicitud_opcionhospedaje_direccion'               => '',
                        'solicitud_opciontraslado_tarifa_dia'               => '',
                        'solicitud_opciontraslado_observacion'              => '',

                        'auditoria_usuario'                                 => '',
                        'auditoria_fecha_hora'                              => '',
                        'auditoria_ip'                                      => '',

                        'tipo_estado_codigo'                                => '',
                        'tipo_estado_nombre'                                => '',
                        'tipo_estado_parametro'                             => '',
                        'tipo_estado_css'                                   => '',

                        'tipo_vehiculo_codigo'                              => '',
                        'tipo_vehiculo_nombre'                              => '',
                        'tipo_vehiculo_parametro'                           => '',
                        'tipo_vehiculo_css'                                 => '',

                        'solicitud_opcioncabecera_codigo'                   => '',
                        'solicitud_opcioncabecera_nombre'                   => '',
                        'solicitud_opcioncabecera_tarifa'                   => '',
                        'solicitud_opcioncabecera_ver_solicitante'          => '',
                        'solicitud_opcioncabecera_ver_jefatura'             => '',
                        'solicitud_opcioncabecera_ver_ejecutivo'            => '',
                        'solicitud_opcioncabecera_ver_proveedor'            => '',
                        'solicitud_opcioncabecera_observacion'              => '',
                        'solicitud_opcioncabecera_directorio'               => '',

                        'solicitud_codigo'                                  => '',
                        'solicitud_periodo'                                 => '',
                        'solicitud_motivo'                                  => '',
                        'solicitud_pasaje'                                  => '',
                        'solicitud_hospedaje'                               => '',
                        'solicitud_traslado'                                => '',
                        'solicitud_fecha_carga_1'                           => '',
                        'solicitud_fecha_carga_2'                           => '',
                        'solicitud_sap_centro_costo'                        => '',
                        'solicitud_tarea_cantidad'                          => '',
                        'solicitud_tarea_resuelta'                          => '',
                        'solicitud_tarea_porcentaje'                        => '',
                        'solicitud_observacion'                             => ''
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

    $app->get('/v2/400/aerolinea', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $sql00  = "SELECT
            a.AERFICCOD         AS          aerolinea_codigo,
            a.AERFICORD         AS          aerolinea_orden,
            a.AERFICNOM         AS          aerolinea_nombre,
            a.AERFICOBS         AS          aerolinea_observacion,

            a.AERFICAUS         AS          auditoria_usuario,
            a.AERFICAFH         AS          auditoria_fecha_hora,
            a.AERFICAIP         AS          auditoria_ip,

            b.DOMFICCOD         AS          tipo_estado_codigo,
            b.DOMFICNOI         AS          tipo_estado_ingles,
            b.DOMFICNOC         AS          tipo_estado_castellano,
            b.DOMFICNOP         AS          tipo_estado_portugues
            
            FROM [via].[AERFIC] a
            INNER JOIN [adm].[DOMFIC] b ON a.AERFICEST = b.DOMFICCOD

            ORDER BY a.AERFICORD, a.AERFICNOM";

        try {
            $connMSSQL  = getConnectionMSSQLv2();

            $stmtMSSQL00= $connMSSQL->prepare($sql00);
            $stmtMSSQL00->execute();
            
            while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                $detalle    = array(
                    'aerolinea_codigo'       => $rowMSSQL00['aerolinea_codigo'],
                    'aerolinea_orden'        => $rowMSSQL00['aerolinea_orden'],
                    'aerolinea_nombre'       => trim(strtoupper(strtolower($rowMSSQL00['aerolinea_nombre']))),
                    'aerolinea_observacion'  => trim(strtoupper(strtolower($rowMSSQL00['aerolinea_observacion']))),

                    'auditoria_usuario'     => trim(strtoupper($rowMSSQL00['auditoria_usuario'])),
                    'auditoria_fecha_hora'  => $rowMSSQL00['auditoria_fecha_hora'],
                    'auditoria_ip'          => trim(strtoupper($rowMSSQL00['auditoria_ip'])),

                    'tipo_estado_codigo'    => $rowMSSQL00['tipo_estado_codigo'],
                    'tipo_estado_ingles'    => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_ingles']))),
                    'tipo_estado_castellano'=> trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_castellano']))),
                    'tipo_estado_portugues' => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_portugues'])))
                );

                $result[]   = $detalle;
            }

            if (isset($result)){
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } else {
                $detalle = array(
                    'aerolinea_codigo'       => '',
                    'aerolinea_orden'        => '',
                    'aerolinea_nombre'       => '',
                    'aerolinea_observacion'  => '',

                    'auditoria_usuario'     => '',
                    'auditoria_fecha_hora'  => '',
                    'auditoria_ip'          => '',

                    'tipo_estado_codigo'    => '',
                    'tipo_estado_ingles'    => '',
                    'tipo_estado_castellano'=> '',
                    'tipo_estado_portugues' => ''
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

    $app->get('/v2/400/solicitud/notificacion/solicitud/{codigo}', function($request) {//20201103
        require __DIR__.'/../src/connect.php';
        $val00 = $request->getAttribute('codigo');

        $sql00  = "SELECT 
        a.SOLCONSOC         AS          solicitud_codigo,

        a.SOLCONCOD         AS          solicitud_consulta_codigo,	
        a.SOLCONPDO         AS          solicitud_consulta_persona_documento,	
        a.SOLCONPNO         AS          solicitud_consulta_persona_nombre,	
        a.SOLVUEFEC         AS          solicitud_consulta_fecha_carga,	
        a.SOLCONOBS         AS          solicitud_consulta_comentario,
            
        a.SOLCONAUS         AS          auditoria_usuario, 	
        a.SOLCONAFH         AS          auditoria_fecha_hora,	
        a.SOLCONAIP         AS          auditoria_ip,
        
        b.DOMFICCOD         AS          tipo_estado_codigo,
        b.DOMFICNOI         AS          tipo_estado_nombre_ingles,
        b.DOMFICNOC         AS          tipo_estado_nombre_castellano,
        b.DOMFICNOP         AS          tipo_estado_nombre_portugues,
        b.DOMFICPAR         AS          tipo_estado_parametro,
        b.DOMFICICO         AS          tipo_estado_icono,
        b.DOMFICCSS         AS          tipo_estado_css,
        
        c.DOMFICCOD         AS          tipo_consulta_codigo,
        c.DOMFICNOI         AS          tipo_consulta_nombre_ingles,
        c.DOMFICNOC         AS          tipo_consulta_nombre_castellano,
        c.DOMFICNOP         AS          tipo_consulta_nombre_portugues,
        c.DOMFICPAR         AS          tipo_consulta_parametro,
        c.DOMFICICO         AS          tipo_consulta_icono,
        c.DOMFICCSS         AS          tipo_consulta_css,

        d.DOMFICCOD         AS          tipo_solicitud_codigo,
        d.DOMFICNOI         AS          tipo_solicitud_nombre_ingles,
        d.DOMFICNOC         AS          tipo_solicitud_nombre_castellano,
        d.DOMFICNOP         AS          tipo_solicitud_nombre_portugues,
        d.DOMFICPAR         AS          tipo_solicitud_parametro,
        d.DOMFICICO         AS          tipo_solicitud_icono,
        d.DOMFICCSS         AS          tipo_solicitud_css
        
        FROM via.SOLCON a
        INNER JOIN adm.DOMFIC b ON a.SOLCONEST = b.DOMFICCOD
        INNER JOIN adm.DOMFIC c ON a.SOLCONTCT = c.DOMFICCOD 
        INNER JOIN adm.DOMFIC d ON a.SOLCONTSC = d.DOMFICCOD 

        WHERE a.SOLCONSOC = ?
        
        ORDER BY b.DOMFICPAR ASC, a.SOLCONCOD DESC";

        try {
            $connMSSQL  = getConnectionMSSQLv2();
            $stmtMSSQL00= $connMSSQL->prepare($sql00);
            $stmtMSSQL00->execute([$val00]);

            while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                if(!empty($rowMSSQL00['solicitud_consulta_fecha_carga'])){
                    $solicitud_consulta_fecha_carga_1    = $rowMSSQL00['solicitud_consulta_fecha_carga'];
                    $solicitud_consulta_fecha_carga_2    = date("d/m/Y", strtotime($rowMSSQL00['solicitud_consulta_fecha_carga']));
                } else {
                    $solicitud_consulta_fecha_carga_1    = '';
                    $solicitud_consulta_fecha_carga_2    = '';
                }

                $detalle = array(    
                    'solicitud_codigo'                                  => $rowMSSQL00['solicitud_codigo'],
                    'solicitud_consulta_codigo'                         => $rowMSSQL00['solicitud_consulta_codigo'],
                    'solicitud_consulta_persona_documento'              => trim(strtoupper(strtolower($rowMSSQL00['solicitud_consulta_persona_documento']))),
                    'solicitud_consulta_persona_nombre'                 => trim(strtoupper(strtolower($rowMSSQL00['solicitud_consulta_persona_nombre']))),
                    'solicitud_consulta_fecha_carga_1'                  => $solicitud_consulta_fecha_carga_1,
                    'solicitud_consulta_fecha_carga_2'                  => $solicitud_consulta_fecha_carga_2,
                    'solicitud_consulta_comentario'                     => trim($rowMSSQL00['solicitud_consulta_comentario']),

                    'auditoria_usuario'                                 => trim(strtoupper(strtolower($rowMSSQL00['auditoria_usuario']))),
                    'auditoria_fecha_hora'                              => date("d/m/Y", strtotime($rowMSSQL00['auditoria_fecha_hora'])),
                    'auditoria_ip'                                      => trim(strtoupper(strtolower($rowMSSQL00['auditoria_ip']))),

                    'tipo_estado_codigo'                                => $rowMSSQL00['tipo_estado_codigo'],
                    'tipo_estado_nombre_ingles'                         => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_nombre_ingles']))),
                    'tipo_estado_nombre_castellano'                     => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_nombre_castellano']))),
                    'tipo_estado_nombre_portugues'                      => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_nombre_portugues']))),
                    'tipo_estado_parametro'                             => $rowMSSQL00['tipo_estado_parametro'],
                    'tipo_estado_icono'                                 => trim(strtolower($rowMSSQL00['tipo_estado_icono'])),
                    'tipo_estado_css'                                   => trim(strtolower($rowMSSQL00['tipo_estado_css'])),

                    'tipo_consulta_codigo'                              => $rowMSSQL00['tipo_consulta_codigo'],
                    'tipo_consulta_nombre_ingles'                       => trim(strtoupper(strtolower($rowMSSQL00['tipo_consulta_nombre_ingles']))),
                    'tipo_consulta_nombre_castellano'                   => trim(strtoupper(strtolower($rowMSSQL00['tipo_consulta_nombre_castellano']))),
                    'tipo_consulta_nombre_portugues'                    => trim(strtoupper(strtolower($rowMSSQL00['tipo_consulta_nombre_portugues']))),
                    'tipo_consulta_parametro'                           => $rowMSSQL00['tipo_consulta_parametro'],
                    'tipo_consulta_icono'                               => trim(strtolower($rowMSSQL00['tipo_consulta_icono'])),
                    'tipo_consulta_css'                                 => trim(strtolower($rowMSSQL00['tipo_consulta_css'])),

                    'tipo_solicitud_codigo'                              => $rowMSSQL00['tipo_solicitud_codigo'],
                    'tipo_solicitud_nombre_ingles'                       => trim(strtoupper(strtolower($rowMSSQL00['tipo_solicitud_nombre_ingles']))),
                    'tipo_solicitud_nombre_castellano'                   => trim(strtoupper(strtolower($rowMSSQL00['tipo_solicitud_nombre_castellano']))),
                    'tipo_solicitud_nombre_portugues'                    => trim(strtoupper(strtolower($rowMSSQL00['tipo_solicitud_nombre_portugues']))),
                    'tipo_solicitud_parametro'                           => $rowMSSQL00['tipo_solicitud_parametro'],
                    'tipo_solicitud_icono'                               => trim(strtolower($rowMSSQL00['tipo_solicitud_icono'])),
                    'tipo_solicitud_css'                                 => trim(strtolower($rowMSSQL00['tipo_solicitud_css']))
                    
                );

                $result[]   = $detalle;
            }

            if (isset($result)){
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } else {
                $detalle    = array(
                    'solicitud_codigo'                                  => '',
                    'solicitud_consulta_codigo'                         => '',
                    'solicitud_consulta_persona_documento'              => '',
                    'solicitud_consulta_persona_nombre'                 => '',
                    'solicitud_consulta_fecha_carga_1'                  => '',
                    'solicitud_consulta_fecha_carga_2'                  => '',
                    'solicitud_consulta_comentario'                     => '',

                    'auditoria_usuario'                                 => '',
                    'auditoria_fecha_hora'                              => '',
                    'auditoria_ip'                                      => '',

                    'tipo_estado_nombre_codigo'                         => '',
                    'tipo_estado_nombre_ingles'                         => '',
                    'tipo_estado_nombre_castellano'                     => '',
                    'tipo_estado_nombre_portugues'                      => '',
                    'tipo_estado_parametro'                             => '',
                    'tipo_estado_icono'                                 => '',
                    'tipo_estado_css'                                   => '',

                    'tipo_consulta_codigo'                              => '',
                    'tipo_consulta_nombre_ingles'                       => '',
                    'tipo_consulta_nombre_castellano'                   => '',
                    'tipo_consulta_nombre_portugues'                    => '',
                    'tipo_consulta_parametro'                           => '',
                    'tipo_consulta_icono'                               => '',
                    'tipo_consulta_css'                                 => '',

                    'tipo_solicitud_codigo'                              => '',
                    'tipo_solicitud_nombre_ingles'                       => '',
                    'tipo_solicitud_nombre_castellano'                   => '',
                    'tipo_solicitud_nombre_portugues'                    => '',
                    'tipo_solicitud_parametro'                           => '',
                    'tipo_solicitud_icono'                               => '',
                    'tipo_solicitud_css'                                 => ''

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

    $app->get('/v2/400/solicitud/notificacion/top10/{documento}', function($request) {//20201103
        require __DIR__.'/../src/connect.php';
        $val00 = $request->getAttribute('documento');

        $sql00  = "SELECT TOP 10
        a.SOLFICCOD         AS          solicitud_codigo,

        b.SOLCONCOD         AS          solicitud_consulta_codigo,
        b.SOLCONPDO         AS          solicitud_consulta_persona_documento,	
        b.SOLCONPNO         AS          solicitud_consulta_persona_nombre,	
        b.SOLVUEFEC         AS          solicitud_consulta_fecha_carga,	
        b.SOLCONOBS         AS          solicitud_consulta_comentario,
            
        b.SOLCONAUS         AS          auditoria_usuario, 	
        b.SOLCONAFH         AS          auditoria_fecha_hora,	
        b.SOLCONAIP         AS          auditoria_ip,
        
        c.DOMFICCOD         AS          tipo_estado_codigo,
        c.DOMFICNOI         AS          tipo_estado_nombre_ingles,
        c.DOMFICNOC         AS          tipo_estado_nombre_castellano,
        c.DOMFICNOP         AS          tipo_estado_nombre_portugues,
        c.DOMFICPAR         AS          tipo_estado_parametro,
        c.DOMFICICO         AS          tipo_estado_icono,
        c.DOMFICCSS         AS          tipo_estado_css,
        
        d.DOMFICCOD         AS          tipo_consulta_codigo,
        d.DOMFICNOI         AS          tipo_consulta_nombre_ingles,
        d.DOMFICNOC         AS          tipo_consulta_nombre_castellano,
        d.DOMFICNOP         AS          tipo_consulta_nombre_portugues,
        d.DOMFICPAR         AS          tipo_consulta_parametro,
        d.DOMFICICO         AS          tipo_consulta_icono,
        d.DOMFICCSS         AS          tipo_consulta_css
        
        FROM via.SOLFIC a
        INNER JOIN via.SOLCON b ON a.SOLFICCOD = b.SOLCONSOC
        INNER JOIN adm.DOMFIC c ON b.SOLCONEST = c.DOMFICCOD
        INNER JOIN adm.DOMFIC d ON b.SOLCONTCT = d.DOMFICCOD 

        WHERE (a.SOLFICDNS = ? OR a.SOLFICDNE = ? OR a.SOLFICDNP = ?) AND (b.SOLCONPDO <> ?) 
        
        ORDER BY c.DOMFICPAR ASC, b.SOLCONCOD DESC";

        try {
            $connMSSQL  = getConnectionMSSQLv2();
            $stmtMSSQL00= $connMSSQL->prepare($sql00);
            $stmtMSSQL00->execute([$val00, $val00, $val00, $val00]);

            while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                if(!empty($rowMSSQL00['solicitud_consulta_fecha_carga'])){
                    $solicitud_consulta_fecha_carga_1    = $rowMSSQL00['solicitud_consulta_fecha_carga'];
                    $solicitud_consulta_fecha_carga_2    = date("d/m/Y", strtotime($rowMSSQL00['solicitud_consulta_fecha_carga']));
                } else {
                    $solicitud_consulta_fecha_carga_1    = '';
                    $solicitud_consulta_fecha_carga_2    = '';
                }

                $detalle = array(  
                    'solicitud_codigo'                                  => $rowMSSQL00['solicitud_codigo'],

                    'solicitud_consulta_codigo'                         => $rowMSSQL00['solicitud_consulta_codigo'],
                    'solicitud_consulta_persona_documento'              => trim(strtoupper(strtolower($rowMSSQL00['solicitud_consulta_persona_documento']))),
                    'solicitud_consulta_persona_nombre'                 => trim(strtoupper(strtolower($rowMSSQL00['solicitud_consulta_persona_nombre']))),
                    'solicitud_consulta_fecha_carga_1'                  => $solicitud_consulta_fecha_carga_1,
                    'solicitud_consulta_fecha_carga_2'                  => $solicitud_consulta_fecha_carga_2,
                    'solicitud_consulta_comentario'                     => trim($rowMSSQL00['solicitud_consulta_comentario']),

                    'auditoria_usuario'                                 => trim(strtoupper(strtolower($rowMSSQL00['auditoria_usuario']))),
                    'auditoria_fecha_hora'                              => date("d/m/Y", strtotime($rowMSSQL00['auditoria_fecha_hora'])),
                    'auditoria_ip'                                      => trim(strtoupper(strtolower($rowMSSQL00['auditoria_ip']))),

                    'tipo_estado_codigo'                                => $rowMSSQL00['tipo_estado_codigo'],
                    'tipo_estado_nombre_ingles'                         => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_nombre_ingles']))),
                    'tipo_estado_nombre_castellano'                     => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_nombre_castellano']))),
                    'tipo_estado_nombre_portugues'                      => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_nombre_portugues']))),
                    'tipo_estado_parametro'                             => $rowMSSQL00['tipo_estado_parametro'],
                    'tipo_estado_icono'                                 => trim(strtolower($rowMSSQL00['tipo_estado_icono'])),
                    'tipo_estado_css'                                   => trim(strtolower($rowMSSQL00['tipo_estado_css'])),

                    'tipo_consulta_codigo'                              => $rowMSSQL00['tipo_consulta_codigo'],
                    'tipo_consulta_nombre_ingles'                       => trim(strtoupper(strtolower($rowMSSQL00['tipo_consulta_nombre_ingles']))),
                    'tipo_consulta_nombre_castellano'                     => trim(strtoupper(strtolower($rowMSSQL00['tipo_consulta_nombre_castellano']))),
                    'tipo_consulta_nombre_portugues'                    => trim(strtoupper(strtolower($rowMSSQL00['tipo_consulta_nombre_portugues']))),
                    'tipo_consulta_parametro'                           => $rowMSSQL00['tipo_consulta_parametro'],
                    'tipo_consulta_icono'                               => trim(strtolower($rowMSSQL00['tipo_consulta_icono'])),
                    'tipo_consulta_css'                                 => trim(strtolower($rowMSSQL00['tipo_consulta_css']))

                    
                );

                $result[]   = $detalle;
            }

            if (isset($result)){
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } else {
                $detalle    = array(
                    'solicitud_codigo'                                  => '',

                    'solicitud_consulta_codigo'                         => '',
                    'solicitud_consulta_persona_documento'              => '',
                    'solicitud_consulta_persona_nombre'                 => '',
                    'solicitud_consulta_fecha_carga_1'                  => '',
                    'solicitud_consulta_fecha_carga_2'                  => '',
                    'solicitud_consulta_comentario'                     => '',

                    'auditoria_usuario'                                 => '',
                    'auditoria_fecha_hora'                              => '',
                    'auditoria_ip'                                      => '',

                    'tipo_estado_nombre_codigo'                         => '',
                    'tipo_estado_nombre_ingles'                         => '',
                    'tipo_estado_nombre_castellano'                     => '',
                    'tipo_estado_nombre_portugues'                      => '',
                    'tipo_estado_parametro'                             => '',
                    'tipo_estado_icono'                                 => '',
                    'tipo_estado_css'                                   => '',

                    'tipo_consulta_codigo'                              => '',
                    'tipo_consulta_nombre_ingles'                       => '',
                    'tipo_consulta_nombre_castellano'                   => '',
                    'tipo_consulta_nombre_portugues'                    => '',
                    'tipo_consulta_parametro'                           => '',
                    'tipo_consulta_icono'                               => '',
                    'tipo_consulta_css'                                 => ''

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

    $app->get('/v2/400/solicitud/notificacion/listado/{documento}', function($request) {//20201103
        require __DIR__.'/../src/connect.php';
        $val00 = $request->getAttribute('documento');

        $sql00  = "SELECT 
        a.SOLFICCOD         AS          solicitud_codigo,

        b.SOLCONCOD         AS          solicitud_consulta_codigo,	
        b.SOLCONPDO         AS          solicitud_consulta_persona_documento,	
        b.SOLCONPNO         AS          solicitud_consulta_persona_nombre,	
        b.SOLVUEFEC         AS          solicitud_consulta_fecha_carga,	
        b.SOLCONOBS         AS          solicitud_consulta_comentario,
            
        b.SOLCONAUS         AS          auditoria_usuario, 	
        b.SOLCONAFH         AS          auditoria_fecha_hora,	
        b.SOLCONAIP         AS          auditoria_ip,
        
        c.DOMFICCOD         AS          tipo_estado_codigo,
        c.DOMFICNOI         AS          tipo_estado_nombre_ingles,
        c.DOMFICNOC         AS          tipo_estado_nombre_castellano,
        c.DOMFICNOP         AS          tipo_estado_nombre_portugues,
        c.DOMFICPAR         AS          tipo_estado_parametro,
        c.DOMFICICO         AS          tipo_estado_icono,
        c.DOMFICCSS         AS          tipo_estado_css,
        
        d.DOMFICCOD         AS          tipo_consulta_codigo,
        d.DOMFICNOI         AS          tipo_consulta_nombre_ingles,
        d.DOMFICNOC         AS          tipo_consulta_nombre_castellano,
        d.DOMFICNOP         AS          tipo_consulta_nombre_portugues,
        d.DOMFICPAR         AS          tipo_consulta_parametro,
        d.DOMFICICO         AS          tipo_consulta_icono,
        d.DOMFICCSS         AS          tipo_consulta_css
        
        FROM via.SOLFIC a
        INNER JOIN via.SOLCON b ON a.SOLFICCOD = b.SOLCONSOC
        INNER JOIN adm.DOMFIC c ON b.SOLCONEST = c.DOMFICCOD
        INNER JOIN adm.DOMFIC d ON b.SOLCONTCT = d.DOMFICCOD 

        WHERE (a.SOLFICDNS = ? OR a.SOLFICDNE = ? OR a.SOLFICDNP = ?) AND (b.SOLCONPDO <> ?) 
        
        ORDER BY c.DOMFICPAR ASC, b.SOLCONCOD DESC";

        try {
            $connMSSQL  = getConnectionMSSQLv2();
            $stmtMSSQL00= $connMSSQL->prepare($sql00);
            $stmtMSSQL00->execute([$val00, $val00, $val00, $val00]);

            while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                if(!empty($rowMSSQL00['solicitud_consulta_fecha_carga'])){
                    $solicitud_consulta_fecha_carga_1    = $rowMSSQL00['solicitud_consulta_fecha_carga'];
                    $solicitud_consulta_fecha_carga_2    = date("d/m/Y", strtotime($rowMSSQL00['solicitud_consulta_fecha_carga']));
                } else {
                    $solicitud_consulta_fecha_carga_1    = '';
                    $solicitud_consulta_fecha_carga_2    = '';
                }

                $detalle = array(    
                    'solicitud_codigo'                                  => $rowMSSQL00['solicitud_codigo'],

                    'solicitud_consulta_codigo'                         => $rowMSSQL00['solicitud_consulta_codigo'],
                    'solicitud_consulta_persona_documento'              => trim(strtoupper(strtolower($rowMSSQL00['solicitud_consulta_persona_documento']))),
                    'solicitud_consulta_persona_nombre'                 => trim(strtoupper(strtolower($rowMSSQL00['solicitud_consulta_persona_nombre']))),
                    'solicitud_consulta_fecha_carga_1'                  => $solicitud_consulta_fecha_carga_1,
                    'solicitud_consulta_fecha_carga_2'                  => $solicitud_consulta_fecha_carga_2,
                    'solicitud_consulta_comentario'                     => trim($rowMSSQL00['solicitud_consulta_comentario']),

                    'auditoria_usuario'                                 => trim(strtoupper(strtolower($rowMSSQL00['auditoria_usuario']))),
                    'auditoria_fecha_hora'                              => date("d/m/Y", strtotime($rowMSSQL00['auditoria_fecha_hora'])),
                    'auditoria_ip'                                      => trim(strtoupper(strtolower($rowMSSQL00['auditoria_ip']))),

                    'tipo_estado_codigo'                                => $rowMSSQL00['tipo_estado_codigo'],
                    'tipo_estado_nombre_ingles'                         => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_nombre_ingles']))),
                    'tipo_estado_nombre_castellano'                     => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_nombre_castellano']))),
                    'tipo_estado_nombre_portugues'                      => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_nombre_portugues']))),
                    'tipo_estado_parametro'                             => $rowMSSQL00['tipo_estado_parametro'],
                    'tipo_estado_icono'                                 => trim(strtolower($rowMSSQL00['tipo_estado_icono'])),
                    'tipo_estado_css'                                   => trim(strtolower($rowMSSQL00['tipo_estado_css'])),

                    'tipo_consulta_codigo'                              => $rowMSSQL00['tipo_consulta_codigo'],
                    'tipo_consulta_nombre_ingles'                       => trim(strtoupper(strtolower($rowMSSQL00['tipo_consulta_nombre_ingles']))),
                    'tipo_consulta_nombre_castellano'                   => trim(strtoupper(strtolower($rowMSSQL00['tipo_consulta_nombre_castellano']))),
                    'tipo_consulta_nombre_portugues'                    => trim(strtoupper(strtolower($rowMSSQL00['tipo_consulta_nombre_portugues']))),
                    'tipo_consulta_parametro'                           => $rowMSSQL00['tipo_consulta_parametro'],
                    'tipo_consulta_icono'                               => trim(strtolower($rowMSSQL00['tipo_consulta_icono'])),
                    'tipo_consulta_css'                                 => trim(strtolower($rowMSSQL00['tipo_consulta_css']))
                    
                );

                $result[]   = $detalle;
            }

            if (isset($result)){
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } else {
                $detalle    = array(
                    'solicitud_codigo'                                  => '',

                    'solicitud_consulta_codigo'                         => '',
                    'solicitud_consulta_persona_documento'              => '',
                    'solicitud_consulta_persona_nombre'                 => '',
                    'solicitud_consulta_fecha_carga_1'                  => '',
                    'solicitud_consulta_fecha_carga_2'                  => '',
                    'solicitud_consulta_comentario'                     => '',

                    'auditoria_usuario'                                 => '',
                    'auditoria_fecha_hora'                              => '',
                    'auditoria_ip'                                      => '',

                    'tipo_estado_nombre_codigo'                         => '',
                    'tipo_estado_nombre_ingles'                         => '',
                    'tipo_estado_nombre_castellano'                     => '',
                    'tipo_estado_nombre_portugues'                      => '',
                    'tipo_estado_parametro'                             => '',
                    'tipo_estado_icono'                                 => '',
                    'tipo_estado_css'                                   => '',

                    'tipo_consulta_codigo'                              => '',
                    'tipo_consulta_nombre_ingles'                       => '',
                    'tipo_consulta_nombre_castellano'                   => '',
                    'tipo_consulta_nombre_portugues'                    => '',
                    'tipo_consulta_parametro'                           => '',
                    'tipo_consulta_icono'                               => '',
                    'tipo_consulta_css'                                 => ''

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

    $app->get('/v2/400/solicitud/calendario/{documento}', function($request) {//20201106
        require __DIR__.'/../src/connect.php';
        
        $val01  = $request->getAttribute('documento');
        
        if (isset($val01)) {
            $sql00  = "SELECT 
                a.SOLFICCOD AS solicitud_calendario_codigo,

                b.SOLVUEFSA AS solicitud_calendario_fecha_salida,
                b.SOLVUEFRE AS solicitud_calendario_fecha_retorno,
                RTRIM(c.LOCCIUNOM)+' - '+RTRIM(d.LOCPAINOM) AS solicitud_calendario_origen,
                RTRIM(e.LOCCIUNOM)+' - '+RTRIM(f.LOCPAINOM) AS solicitud_calendario_destino
                
                FROM via.SOLFIC a

                INNER JOIN via.SOLVUE b ON a.SOLFICCOD = b.SOLVUESOC
                INNER JOIN adm.LOCCIU c ON b.SOLVUECOC = c.LOCCIUCOD
                INNER JOIN adm.LOCPAI d ON c.LOCCIUPAC = d.LOCPAICOD
                INNER JOIN adm.LOCCIU e ON b.SOLVUECDC = e.LOCCIUCOD
                INNER JOIN adm.LOCPAI f ON e.LOCCIUPAC = f.LOCPAICOD

                WHERE a.SOLFICDNE = ?
                
                UNION ALL
                
                SELECT
                a.SOLFICCOD AS solicitud_calendario_codigo,

                b.SOLHOSFIN AS solicitud_calendario_fecha_salida,
                b.SOLHOSFOU AS solicitud_calendario_fecha_retorno,
                RTRIM(c.LOCCIUNOM)+' - '+RTRIM(d.LOCPAINOM) AS solicitud_calendario_origen,
                RTRIM(e.LOCCIUNOM)+' - '+RTRIM(f.LOCPAINOM) AS solicitud_calendario_destino
                
                FROM via.SOLFIC a

                INNER JOIN via.SOLHOS b ON a.SOLFICCOD = b.SOLHOSSOC
                INNER JOIN adm.LOCCIU c ON b.SOLHOSCDC = c.LOCCIUCOD
                INNER JOIN adm.LOCPAI d ON c.LOCCIUPAC = d.LOCPAICOD
                INNER JOIN adm.LOCCIU e ON b.SOLHOSCDC = e.LOCCIUCOD
                INNER JOIN adm.LOCPAI f ON c.LOCCIUPAC = f.LOCPAICOD

                WHERE a.SOLFICDNE = ?
                
                UNION ALL
                
                SELECT
                a.SOLFICCOD AS solicitud_calendario_codigo,
                b.SOLTRAFSA AS solicitud_calendario_fecha_salida,
                b.SOLTRAFSA AS solicitud_calendario_fecha_retorno,
                RTRIM(b.SOLTRASAL)+' - '+RTRIM(b.SOLTRADES) AS solicitud_calendario_origen,
                RTRIM(b.SOLTRASAL)+' - '+RTRIM(b.SOLTRADES) AS solicitud_calendario_destino
                
                FROM via.SOLFIC a

                INNER JOIN via.SOLTRA b ON a.SOLFICCOD = b.SOLTRASOC

                WHERE a.SOLFICDNE = ?
                
                ORDER BY a.SOLFICCOD DESC";

            try {
                $connMSSQL  = getConnectionMSSQLv2();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val01, $val01, $val01]);

                while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                    if(!empty($rowMSSQL00['solicitud_calendario_fecha_salida'])){
                        $solicitud_calendario_fecha_salida_1    = $rowMSSQL00['solicitud_calendario_fecha_salida'];
                        $solicitud_calendario_fecha_salida_2    = date("d/m/Y", strtotime($rowMSSQL00['solicitud_calendario_fecha_salida']));
                    } else {
                        $solicitud_calendario_fecha_salida_1    = '';
                        $solicitud_calendario_fecha_salida_2    = '';
                    }

                    if(!empty($rowMSSQL00['solicitud_calendario_fecha_retorno'])){
                        $solicitud_calendario_fecha_retorno_1    = $rowMSSQL00['solicitud_calendario_fecha_retorno'];
                        $solicitud_calendario_fecha_retorno_2    = date("d/m/Y", strtotime($rowMSSQL00['solicitud_calendario_fecha_retorno']));
                    } else {
                        $solicitud_calendario_fecha_retorno_1    = '';
                        $solicitud_calendario_fecha_retorno_2    = '';
                    }

                    $detalle = array(
                        'solicitud_calendario_codigo'                              => $rowMSSQL00['solicitud_calendario_codigo'],
                        'solicitud_calendario_fecha_salida_1'                      => $solicitud_calendario_fecha_salida_1,
                        'solicitud_calendario_fecha_salida_2'                      => $solicitud_calendario_fecha_salida_2,
                        'solicitud_calendario_fecha_retorno_1'                     => $solicitud_calendario_fecha_retorno_1,
                        'solicitud_calendario_fecha_retorno_2'                     => $solicitud_calendario_fecha_retorno_2,
                        'solicitud_calendario_origen'                              => trim(strtoupper(strtolower($rowMSSQL00['solicitud_calendario_origen']))),
                        'solicitud_calendario_destino'                             => trim(strtoupper(strtolower($rowMSSQL00['solicitud_calendario_destino'])))
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle    = array(
                        'solicitud_calendario_codigo'                               => '',
                        'solicitud_calendario_fecha_salida_1'                       => '',
                        'solicitud_calendario_fecha_salida_2'                       => '',
                        'solicitud_calendario_fecha_retorno_1'                      => '',
                        'solicitud_calendario_fecha_retorno_2'                      => '',
                        'solicitud_calendario_origen'                               => ''   
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
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v2/500/rendicion/chart01/{codigo}', function($request) {//20201031
        require __DIR__.'/../src/connect.php';

        $val01  = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT 
            '1' AS TOTAL_CODIGO,
            'TOTAL DECLARADO' AS TOTAL_NOMBRE,
            'bg-blue' AS TOTAL_CSS,
            CASE WHEN SUM(b.RENFDEIMP *a.RENFCACAM) IS NULL THEN 0  
                 WHEN SUM(b.RENFDEIMP *a.RENFCACAM) IS NOT NULL THEN SUM(b.RENFDEIMP *a.RENFCACAM) 
              END AS TOTAL_IMPORTE  
        
            FROM con.RENFCA a 
            
            INNER JOIN con.RENFDE b ON a.RENFCACOD = b.RENFDEFCC

            WHERE a.RENFCAREC = ?";

            $sql01 = "SELECT 
            '2' AS TOTAL_CODIGO,
            'TOTAL PENDIENTE' AS TOTAL_NOMBRE,
            'bg-info' AS TOTAL_CSS,
             CASE WHEN SUM(b.RENFDEIMP *a.RENFCACAM) IS NULL THEN 0    
                    WHEN SUM(b.RENFDEIMP *a.RENFCACAM) IS NOT NULL THEN SUM(b.RENFDEIMP *a.RENFCACAM) 
             END AS TOTAL_IMPORTE

             FROM con.RENFCA a 
             
             INNER JOIN con.RENFDE b ON a.RENFCACOD = b.RENFDEFCC
             
             WHERE a.RENFCAREC = ? AND b.RENFDEECC IN (SELECT DOMFICCOD FROM adm.DOMFIC WHERE DOMFICPAR NOT IN (3, 5, 9) AND DOMFICVAL = 'WORKFLOWESTADO')
            ";

            $sql02 = " SELECT 
            '3' AS TOTAL_CODIGO,
            'TOTAL APROBADO' AS TOTAL_NOMBRE,
            'bg-orange' AS TOTAL_CSS,
             CASE WHEN SUM(b.RENFDEIMP * a.RENFCACAM) IS NULL THEN 0  
                    WHEN SUM(b.RENFDEIMP * a.RENFCACAM) IS NOT NULL THEN SUM(b.RENFDEIMP * a.RENFCACAM) 
             END AS TOTAL_IMPORTE  
         
             FROM con.RENFCA a 
             
             INNER JOIN con.RENFDE b ON a.RENFCACOD = b.RENFDEFCC
             
             WHERE a.RENFCAREC = ? AND b.RENFDEECC IN (SELECT DOMFICCOD FROM adm.DOMFIC WHERE DOMFICPAR = 9 AND DOMFICVAL = 'WORKFLOWESTADO')";    

            $sql03 = " SELECT 
            '4' AS TOTAL_CODIGO,
            'TOTAL RECHAZADO' AS TOTAL_NOMBRE,
            'bg-red' AS TOTAL_CSS,
             CASE WHEN SUM(b.RENFDEIMP * a.RENFCACAM) IS NULL THEN 0  
                  WHEN SUM(b.RENFDEIMP * a.RENFCACAM) IS NOT NULL THEN SUM(b.RENFDEIMP *a.RENFCACAM) 
             END AS TOTAL_IMPORTE    
         
             FROM con.RENFCA a 
             
             INNER JOIN con.RENFDE b ON a.RENFCACOD = b.RENFDEFCC
             
             WHERE a.RENFCAREC = ? AND b.RENFDEECC IN (SELECT DOMFICCOD FROM adm.DOMFIC WHERE DOMFICPAR IN (3,5) AND DOMFICVAL = 'WORKFLOWESTADO')";

            try {
                $connMSSQL   = getConnectionMSSQLv2();
                $stmtMSSQL00 = $connMSSQL->prepare($sql00);
                $stmtMSSQL01 = $connMSSQL->prepare($sql01);
                $stmtMSSQL02 = $connMSSQL->prepare($sql02);
                $stmtMSSQL03 = $connMSSQL->prepare($sql03);

                $stmtMSSQL00->execute([$val01]);
                $stmtMSSQL01->execute([$val01]);
                $stmtMSSQL02->execute([$val01]);
                $stmtMSSQL03->execute([$val01]);


                while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                    $detalle    = array(
                        'TOTAL_CODIGO'      =>  $rowMSSQL00['TOTAL_CODIGO'],
                        'TOTAL_NOMBRE'      =>  trim(strtoupper(strtolower($rowMSSQL00['TOTAL_NOMBRE']))),
                        'TOTAL_CSS'         =>  trim(strtolower($rowMSSQL00['TOTAL_CSS'])),
                        'TOTAL_IMPORTE'     =>  number_format($rowMSSQL00['TOTAL_IMPORTE'], 2, ',', '.') 
                    );

                    $result[]   = $detalle;
                }

                
                while ($rowMSSQL00 = $stmtMSSQL01->fetch()) {
                    $detalle    = array(
                        'TOTAL_CODIGO'      =>  $rowMSSQL00['TOTAL_CODIGO'],
                        'TOTAL_NOMBRE'      =>  trim(strtoupper(strtolower($rowMSSQL00['TOTAL_NOMBRE']))),
                        'TOTAL_CSS'         =>  trim(strtolower($rowMSSQL00['TOTAL_CSS'])),
                        'TOTAL_IMPORTE'     =>  number_format($rowMSSQL00['TOTAL_IMPORTE'], 2, ',', '.')
                    );

                    $result[]   = $detalle;
                }

                                
                while ($rowMSSQL00 = $stmtMSSQL02->fetch()) { 
                    $detalle    = array(
                        'TOTAL_CODIGO'      =>  $rowMSSQL00['TOTAL_CODIGO'],
                        'TOTAL_NOMBRE'      =>  trim(strtoupper(strtolower($rowMSSQL00['TOTAL_NOMBRE']))),
                        'TOTAL_CSS'         =>  trim(strtolower($rowMSSQL00['TOTAL_CSS'])),
                        'TOTAL_IMPORTE'     =>  number_format($rowMSSQL00['TOTAL_IMPORTE'], 2, ',', '.')
                    );

                    $result[]   = $detalle;
                }

                while ($rowMSSQL00 = $stmtMSSQL03->fetch()) {
                    $detalle    = array(
                        'TOTAL_CODIGO'      =>  $rowMSSQL00['TOTAL_CODIGO'],
                        'TOTAL_NOMBRE'      =>  trim(strtoupper(strtolower($rowMSSQL00['TOTAL_NOMBRE']))),
                        'TOTAL_CSS'         =>  trim(strtolower($rowMSSQL00['TOTAL_CSS'])),
                        'TOTAL_IMPORTE'     =>  number_format($rowMSSQL00['TOTAL_IMPORTE'], 2, ',', '.')
                    );

                    $result[]   = $detalle;
                }
                
                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle    = array(
                        'TOTAL_CODIGO'       => '',
                        'TOTAL_NOMBRE'       => '',
                        'TOTAL_CSS'          => '',
                        'TOTAL_IMPORTE'      => ''
                        
                    );

                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                }

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
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
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

    $app->get('/v2/500/rendicion/consulta/{codigo}', function($request) {//20201101
        require __DIR__.'/../src/connect.php';
        $val01  = $request->getAttribute('codigo');

        $sql00  = "SELECT 
            a.RENCONCOD         AS          rendicion_consulta_codigo,
            a.RENCONDNU         AS          rendicion_consulta_persona_documento,
            a.RENCONNOM         AS          rendicion_consulta_persona_nombre,
            a.RENCONCOM         AS          rendicion_consulta_comentario,     
            a.RENCONFHC         AS          rendicion_consulta_fecha_hora_carga,
        
            a.RENCONAUS         AS          auditoria_usuario,
            a.RENCONAFH         AS          auditoria_fecha_hora,
            a.RENCONAIP         AS          auditoria_ip,
        
            b.RENFICCOD         AS          rendicion_codigo,
            b.RENFICPER         AS          rendicion_periodo,
            b.RENFICENO         AS          rendicion_evento_nombre,
            b.RENFICEFE         AS          rendicion_evento_fecha,
            b.RENFICDNS         AS          rendicion_documento_solicitante,
            b.RENFICDNJ         AS          rendicion_documento_jefatura,
            b.RENFICDNA         AS          rendicion_documento_analista,
            b.RENFICFEC         AS          rendicion_carga_fecha,
            b.RENFICTCA         AS          rendicion_tarea_cantidad,
            b.RENFICTRE         AS          rendicion_tarea_resuelta,
            b.RENFICOBS         AS          rendicion_observacion,
        
            c.DOMFICCOD         AS          tipo_estado_codigo,
            c.DOMFICNOC         AS          tipo_estado_nombre_castellano,
            c.DOMFICNOI         AS          tipo_estado_nombre_ingles,
            c.DOMFICNOP         AS          tipo_estado_nombre_portugues,
            c.DOMFICPAR         AS          tipo_estado_parametro,
            c.DOMFICCSS	        AS          tipo_estado_CSS,
            c.DOMFICICO         AS          tipo_estado_icono
        
            FROM con.RENCON a
            INNER JOIN con.RENFIC b ON a.RENCONREC = b.RENFICCOD
            INNER JOIN adm.DOMFIC c ON a.RENCONEST = c.DOMFICCOD
        
            WHERE a.RENCONREC = ?
            
            ORDER BY a.RENCONCOD";
            
        try {
            $connMSSQL  = getConnectionMSSQLv2();
            $stmtMSSQL00= $connMSSQL->prepare($sql00);
            $stmtMSSQL00->execute([$val01]);

            while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {

                if ($rowMSSQL00['rendicion_consulta_fecha_hora_carga'] == '1900-01-01' || $rowMSSQL00['rendicion_consulta_fecha_hora_carga'] == null){
                    $rendicion_consulta_fecha_hora_carga_1 = '';
                    $rendicion_consulta_fecha_hora_carga_2 = '';
                } else {
                    $rendicion_consulta_fecha_hora_carga_1 = $rowMSSQL00['rendicion_consulta_fecha_hora_carga'];
                    $rendicion_consulta_fecha_hora_carga_2 = date('d/m/Y', strtotime($rowMSSQL00['rendicion_consulta_fecha_hora_carga']));
                }

                if ($rowMSSQL00['rendicion_carga_fecha'] == '1900-01-01' || $rowMSSQL00['rendicion_carga_fecha'] == null){
                    $rendicion_carga_fecha_1 = '';
                    $rendicion_carga_fecha_2 = '';
                } else {
                    $rendicion_carga_fecha_1 = $rowMSSQL00['rendicion_carga_fecha'];
                    $rendicion_carga_fecha_2 = date('d/m/Y', strtotime($rowMSSQL00['rendicion_carga_fecha']));
                }

                $detalle    = array(
                    'rendicion_consulta_codigo'                 => $rowMSSQL00['rendicion_consulta_codigo'],
                    'rendicion_consulta_persona_documento'      => trim(strtoupper(strtolower($rowMSSQL00['rendicion_consulta_persona_documento']))),
                    'rendicion_consulta_persona_nombre'         => trim(strtoupper(strtolower($rowMSSQL00['rendicion_consulta_persona_nombre']))),
                    'rendicion_consulta_comentario'             => trim(strtoupper(strtolower($rowMSSQL00['rendicion_consulta_comentario']))),    
                    'rendicion_consulta_fecha_hora_carga_1'     => $rendicion_consulta_fecha_hora_carga_1,
                    'rendicion_consulta_fecha_hora_carga_2'     => $rendicion_consulta_fecha_hora_carga_2,
                    'tipo_estado_CSS'                           => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_CSS']))),
                    'tipo_estado_icono'                         => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_icono']))),

                    'rendicion_codigo'                          => $rowMSSQL00['rendicion_codigo'],
                    'rendicion_periodo'                         => $rowMSSQL00['rendicion_periodo'],
                    'rendicion_evento_nombre'                   => trim(strtoupper(strtolower($rowMSSQL00['rendicion_evento_nombre']))),
                    'rendicion_evento_fecha'                    => date("d/m/Y", strtotime($rowMSSQL00['rendicion_evento_fecha'])),
                    'rendicion_documento_solicitante'           => trim(strtoupper(strtolower($rowMSSQL00['rendicion_documento_solicitante']))),
                    'rendicion_documento_jefatura'              => trim(strtoupper(strtolower($rowMSSQL00['rendicion_documento_jefatura']))),
                    'rendicion_documento_analista'              => trim(strtoupper(strtolower($rowMSSQL00['rendicion_documento_analista']))),
                    'rendicion_carga_fecha_1'                   => $rendicion_carga_fecha_1,
                    'rendicion_carga_fecha_2'                   => $rendicion_carga_fecha_2,
                    'rendicion_tarea_cantidad'                  => $rowMSSQL00['rendicion_tarea_cantidad'],
                    'rendicion_tarea_resuelta'                  => $rowMSSQL00['rendicion_tarea_resuelta'],
                    'rendicion_tarea_porcentaje'                => number_format((($rowMSSQL00['rendicion_tarea_resuelta'] * 100) / $rowMSSQL00['rendicion_tarea_cantidad']), 2, '.', ''),
                    'rendicion_observacion'                     => trim(strtoupper(strtolower($rowMSSQL00['rendicion_observacion']))),

                    'auditoria_usuario'                         => trim(strtoupper(strtolower($rowMSSQL00['auditoria_usuario']))),
                    'auditoria_fecha_hora'                      => date("d/m/Y", strtotime($rowMSSQL00['auditoria_fecha_hora'])),
                    'auditoria_ip'                              => trim(strtoupper(strtolower($rowMSSQL00['auditoria_ip']))), 

                    'tipo_estado_codigo'                        => $rowMSSQL00['tipo_estado_codigo'],
                    'tipo_estado_nombre_catellano'              => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_nombre_catellano']))),
                    'tipo_estado_nombre_ingles'                 => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_nombre_ingles']))),
                    'tipo_estado_nombre_portugues'              => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_nombre_portugues']))),             
                    'tipo_estado_parametro'                     => $rowMSSQL00['tipo_estado_parametro'],
                    'tipo_estado_CSS'                           => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_CSS']))),  
                    'tipo_estado_icono'                         => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_icono'])))
                );

                $result[]   = $detalle;
            }

            if (isset($result)){
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } else {
                $detalle    = array(
                    'rendicion_consulta_codigo'                 => '',
                    'rendicion_consulta_persona_documento'      => '',
                    'rendicion_consulta_persona_nombre'         => '',
                    'rendicion_consulta_comentario'             => '',   
                    'rendicion_consulta_fecha_hora_carga_1'     => '',
                    'rendicion_consulta_fecha_hora_carga_2'     => '',
                    
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

                    'auditoria_usuario'                         => '',
                    'auditoria_fecha_hora'                      => '',
                    'auditoria_ip'                              => '',

                    'tipo_estado_codigo'                        => '',
                    'tipo_estado_nombre_catellano'              => '',
                    'tipo_estado_nombre_ingles'                 => '',
                    'tipo_estado_nombre_portugues'              => '',            
                    'tipo_estado_parametro'                     => '',
                    'tipo_estado_CSS'                           => '',  
                    'tipo_estado_icono'                         => ''
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
/*MODULO RENDICION*/