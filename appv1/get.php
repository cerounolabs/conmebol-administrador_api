<?php
    $app->get('/v1/100/dominio', function($request) {
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
            b.DOMFICORD         AS          tipo_estado_orden,
            b.DOMFICNOI         AS          tipo_estado_nombre_ingles,
            b.DOMFICNOC         AS          tipo_estado_nombre_castellano,
            b.DOMFICNOP         AS          tipo_estado_nombre_portugues,
            b.DOMFICPAT         AS          tipo_estado_path,
            b.DOMFICCSS         AS          tipo_estado_css,
            b.DOMFICPAR         AS          tipo_estado_parametro,
            b.DOMFICICO         AS          tipo_estado_icono,
            b.DOMFICVAL         AS          tipo_estado_dominio,
            b.DOMFICOBS         AS          tipo_estado_observacion
        
        FROM [adm].[DOMFIC] a
        INNER JOIN [adm].[DOMFIC] b ON a.DOMFICEST = b.DOMFICCOD

        ORDER BY a.DOMFICVAL, a.DOMFICORD";

        try {
            $connMSSQL  = getConnectionMSSQLv1();
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
                    'tipo_estado_orden'                         => $rowMSSQL00['tipo_estado_orden'],
                    'tipo_estado_nombre_ingles'                 => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_nombre_ingles']))),
                    'tipo_estado_nombre_castellano'             => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_nombre_castellano']))),
                    'tipo_estado_nombre_portugues'              => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_nombre_portugues']))),
                    'tipo_estado_path'                          => trim(strtolower($rowMSSQL00['tipo_estado_path'])),
                    'tipo_estado_css'                           => trim(strtolower($rowMSSQL00['tipo_estado_css'])),
                    'tipo_estado_parametro'                     => $rowMSSQL00['tipo_estado_parametro'],
                    'tipo_estado_icono'                         => trim(strtolower($rowMSSQL00['tipo_estado_icono'])),
                    'tipo_estado_dominio'                       => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_dominio']))),
                    'tipo_estado_observacion'                   => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_observacion'])))
                );

                $result[]   = $detalle;
            }

            if (isset($result)){
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } else {
                $detalle = array(
                    'tipo_codigo'                               => '',
                    'tipo_estado_codigo'                        => '',
                    'tipo_estado_ingles'                        => '',
                    'tipo_estado_castellano'                    => '',
                    'tipo_estado_portugues'                     => '',
                    'tipo_orden'                                => '',
                    'tipo_nombre_ingles'                        => '',
                    'tipo_nombre_castellano'                    => '',
                    'tipo_nombre_portugues'                     => '',
                    'tipo_path'                                 => '',
                    'tipo_dominio'                              => '',
                    'tipo_observacion'                          => '',

                    'auditoria_usuario'                         => '',
                    'auditoria_fecha_hora'                      => '',
                    'auditoria_ip'                              => '',

                    'tipo_estado_codigo'                        => '',
                    'tipo_estado_orden'                         => '',
                    'tipo_estado_nombre_ingles'                 => '',
                    'tipo_estado_nombre_castellano'             => '',
                    'tipo_estado_nombre_portugues'              => '',
                    'tipo_estado_path'                          => '',
                    'tipo_estado_css'                           => '',
                    'tipo_estado_parametro'                     => '',
                    'tipo_estado_icono'                         => '',
                    'tipo_estado_dominio'                       => '',
                    'tipo_estado_observacion'                   => ''

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

    $app->get('/v1/100/dominio/valor/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val01      = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
                a.DOMFICCOD         AS          tipo_estado_codigo,
                a.DOMFICORD         AS          tipo_estado_orden,
                a.DOMFICNOI         AS          tipo_estado_nombre_ingles,
                a.DOMFICNOC         AS          tipo_estado_nombre_castellano,
                a.DOMFICNOP         AS          tipo_estado_nombre_portugues,
                a.DOMFICPAT         AS          tipo_estado_path,
                a.DOMFICCSS         AS          tipo_estado_css,
                a.DOMFICPAR         AS          tipo_estado_parametro,
                a.DOMFICICO         AS          tipo_estado_icono,
                a.DOMFICVAL         AS          tipo_estado_dominio,
                a.DOMFICOBS         AS          tipo_estado_observacion,

                a.DOMFICUSU         AS          auditoria_usuario,
                a.DOMFICFEC         AS          auditoria_fecha_hora,
                a.DOMFICDIP         AS          auditoria_ip,

                b.DOMFICCOD         AS          tipo_estado_codigo,
                b.DOMFICORD         AS          tipo_estado_orden,
                b.DOMFICNOI         AS          tipo_estado_nombre_ingles,
                b.DOMFICNOC         AS          tipo_estado_nombre_castellano,
                b.DOMFICNOP         AS          tipo_estado_nombre_portugues,
                b.DOMFICPAT         AS          tipo_estado_path,
                b.DOMFICCSS         AS          tipo_estado_css,
                b.DOMFICPAR         AS          tipo_estado_parametro,
                b.DOMFICICO         AS          tipo_estado_icono,
                b.DOMFICVAL         AS          tipo_estado_dominio,
                b.DOMFICOBS         AS          tipo_estado_observacion
                
                FROM [adm].[DOMFIC] a
                INNER JOIN [adm].[DOMFIC] b ON a.DOMFICEST = b.DOMFICCOD

                WHERE a.DOMFICVAL = ?

                ORDER BY a.DOMFICVAL, a.DOMFICORD";

            try {
                $connMSSQL  = getConnectionMSSQLv1();
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
                        'tipo_estado_orden'                         => $rowMSSQL00['tipo_estado_orden'],
                        'tipo_estado_nombre_ingles'                 => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_nombre_ingles']))),
                        'tipo_estado_nombre_castellano'             => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_nombre_castellano']))),
                        'tipo_estado_nombre_portugues'              => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_nombre_portugues']))),
                        'tipo_estado_path'                          => trim(strtolower($rowMSSQL00['tipo_estado_path'])),
                        'tipo_estado_css'                           => trim(strtolower($rowMSSQL00['tipo_estado_css'])),
                        'tipo_estado_parametro'                     => $rowMSSQL00['tipo_estado_parametro'],
                        'tipo_estado_icono'                         => trim(strtolower($rowMSSQL00['tipo_estado_icono'])),
                        'tipo_estado_dominio'                       => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_dominio']))),
                        'tipo_estado_observacion'                   => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_observacion'])))
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'tipo_codigo'                               => '',
                        'tipo_estado_codigo'                        => '',
                        'tipo_estado_ingles'                        => '',
                        'tipo_estado_castellano'                    => '',
                        'tipo_estado_portugues'                     => '',
                        'tipo_orden'                                => '',
                        'tipo_nombre_ingles'                        => '',
                        'tipo_nombre_castellano'                    => '',
                        'tipo_nombre_portugues'                     => '',
                        'tipo_path'                                 => '',
                        'tipo_dominio'                              => '',
                        'tipo_observacion'                          => '',
    
                        'auditoria_usuario'                         => '',
                        'auditoria_fecha_hora'                      => '',
                        'auditoria_ip'                              => '',
    
                        'tipo_estado_codigo'                        => '',
                        'tipo_estado_orden'                         => '',
                        'tipo_estado_nombre_ingles'                 => '',
                        'tipo_estado_nombre_castellano'             => '',
                        'tipo_estado_nombre_portugues'              => '',
                        'tipo_estado_path'                          => '',
                        'tipo_estado_css'                           => '',
                        'tipo_estado_parametro'                     => '',
                        'tipo_estado_icono'                         => '',
                        'tipo_estado_dominio'                       => '',
                        'tipo_estado_observacion'                   => ''
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

    $app->get('/v1/100/auditoria/{codigo}', function($request) {
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
            b.DOMFICNOP         AS          tipo_estado_portugues
            
            FROM [aud].[DOMFIC] a
            INNER JOIN [adm].[DOMFIC] b ON a.DOMFICEST = b.DOMFICCOD
            
            WHERE a.DOMFICVAL = ?
            
            ORDER BY a.DOMFICIDD DESC";

            try {
                $connMSSQL  = getConnectionMSSQLv1();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val01]);
                
                while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                    $detalle    = array(
                        'tipo_codigo'                               => $rowMSSQL00['tipo_codigo'],
                        'tipo_estado_codigo'                        => $rowMSSQL00['tipo_estado_codigo'],
                        'tipo_estado_ingles'                        => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_ingles']))),
                        'tipo_estado_castellano'                    => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_castellano']))),
                        'tipo_estado_portugues'                     => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_portugues']))),
                        'tipo_orden'                                => $rowMSSQL00['tipo_orden'],
                        'tipo_nombre_ingles'                        => trim(strtoupper(strtolower($rowMSSQL00['tipo_nombre_ingles']))),
                        'tipo_nombre_castellano'                    => trim(strtoupper(strtolower($rowMSSQL00['tipo_nombre_castellano']))),
                        'tipo_nombre_portugues'                     => trim(strtoupper(strtolower($rowMSSQL00['tipo_nombre_portugues']))),
                        'tipo_path'                                 => trim(strtolower($rowMSSQL00['tipo_path'])),
                        'tipo_dominio'                              => trim(strtoupper(strtolower($rowMSSQL00['tipo_dominio']))),
                        'tipo_observacion'                          => trim(strtoupper(strtolower($rowMSSQL00['tipo_observacion']))),
                        'auditoria_codigo'                          => trim(strtoupper(strtolower($rowMSSQL00['auditoria_codigo']))),
                        'auditoria_metodo'                          => trim(strtoupper(strtolower($rowMSSQL00['auditoria_metodo']))),
                        'auditoria_usuario'                         => trim(strtoupper(strtolower($rowMSSQL00['auditoria_usuario']))),
                        'auditoria_fecha_hora'                      => $rowMSSQL00['auditoria_fecha_hora'],
                        'auditoria_ip'                              => trim(strtoupper(strtolower($rowMSSQL00['auditoria_ip'])))
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'tipo_codigo'                               => '',
                        'tipo_estado_codigo'                        => '',
                        'tipo_estado_ingles'                        => '',
                        'tipo_estado_castellano'                    => '',
                        'tipo_estado_portugues'                     => '',
                        'tipo_orden'                                => '',
                        'tipo_nombre_ingles'                        => '',
                        'tipo_nombre_castellano'                    => '',
                        'tipo_nombre_portugues'                     => '',
                        'tipo_path'                                 => '',
                        'tipo_dominio'                              => '',
                        'tipo_observacion'                          => '',
                        'auditoria_codigo'                          => '',
                        'auditoria_metodo'                          => '',
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

    $app->get('/v1/100/dominiosub', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $sql00  = "SELECT
        a.DOMSUBORD         AS          tipo_orden,
        a.DOMSUBPAT         AS          tipo_path,
        a.DOMSUBVAL         AS          tipo_dominio,
        a.DOMSUBPAR         AS          tipo_parametro,
        a.DOMSUBCSS         AS          tipo_css,
        a.DOMSUBOBS         AS          tipo_observacion,

        a.DOMSUBAUS         AS          auditoria_usuario,
        a.DOMSUBAFE         AS          auditoria_fecha_hora,
        a.DOMSUBAIP         AS          auditoria_ip,

        b.DOMFICCOD         AS          tipo_estado_codigo,
        b.DOMFICORD         AS          tipo_estado_orden,
        b.DOMFICNOI         AS          tipo_estado_nombre_ingles,
        b.DOMFICNOC         AS          tipo_estado_nombre_castellano,
        b.DOMFICNOP         AS          tipo_estado_nombre_portugues,
        b.DOMFICPAT         AS          tipo_estado_path,
        b.DOMFICCSS         AS          tipo_estado_css,
        b.DOMFICPAR         AS          tipo_estado_parametro,
        b.DOMFICICO         AS          tipo_estado_icono,
        b.DOMFICVAL         AS          tipo_estado_dominio,
        b.DOMFICOBS         AS          tipo_estado_observacion,

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
            $connMSSQL  = getConnectionMSSQLv1();
            $stmtMSSQL00= $connMSSQL->prepare($sql00);
            $stmtMSSQL00->execute();
            
            while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                $detalle    = array(
                    'tipo_orden'                                  => $rowMSSQL00['tipo_orden'],
                    'tipo_path'                                   => trim(strtolower($rowMSSQL00['tipo_path'])),
                    'tipo_dominio'                                => trim(strtoupper(strtolower($rowMSSQL00['tipo_dominio']))),
                    'tipo_observacion'                            => trim(strtoupper(strtolower($rowMSSQL00['tipo_observacion']))),

                    'tipo_estado_codigo'                          => $rowMSSQL00['tipo_estado_codigo'],
                    'tipo_estado_orden'                           => $rowMSSQL00['tipo_estado_orden'],
                    'tipo_estado_nombre_ingles'                   => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_nombre_ingles']))),
                    'tipo_estado_nombre_castellano'               => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_nombre_castellano']))),
                    'tipo_estado_nombre_portugues'                => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_nombre_portugues']))),
                    'tipo_estado_path'                            => trim(strtolower($rowMSSQL00['tipo_estado_path'])),
                    'tipo_estado_css'                             => trim(strtolower($rowMSSQL00['tipo_estado_css'])),
                    'tipo_estado_parametro'                       => $rowMSSQL00['tipo_estado_parametro'],
                    'tipo_estado_icono'                           => trim(strtolower($rowMSSQL00['tipo_estado_icono'])),
                    'tipo_estado_dominio'                         => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_dominio']))),
                    'tipo_estado_observacion'                     => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_observacion']))),

                    'auditoria_usuario'                           => trim(strtoupper(strtolower($rowMSSQL00['auditoria_usuario']))),
                    'auditoria_fecha_hora'                        => $rowMSSQL00['auditoria_fecha_hora'],
                    'auditoria_ip'                                => trim(strtoupper(strtolower($rowMSSQL00['auditoria_ip']))),

                    'tipo_dominio1_codigo'                        => $rowMSSQL00['tipo_dominio1_codigo'],
                    'tipo_dominio1_orden'                         => $rowMSSQL00['tipo_dominio1_orden'],
                    'tipo_dominio1_nombre_ingles'                 => trim(strtoupper(strtolower($rowMSSQL00['tipo_dominio1_nombre_ingles']))),
                    'tipo_dominio1_nombre_castellano'             => trim(strtoupper(strtolower($rowMSSQL00['tipo_dominio1_nombre_castellano']))),
                    'tipo_dominio1_nombre_portugues'              => trim(strtoupper(strtolower($rowMSSQL00['tipo_dominio1_nombre_portugues']))),
                    'tipo_dominio1_path'                          => trim(strtolower($rowMSSQL00['tipo_dominio1_path'])),
                    'tipo_dominio1_css'                           => trim(strtolower($rowMSSQL00['tipo_dominio1_css'])),
                    'tipo_dominio1_parametro'                     => $rowMSSQL00['tipo_dominio1_parametro'],
                    'tipo_dominio1_icono'                         => trim(strtolower($rowMSSQL00['tipo_dominio1_icono'])),
                    'tipo_dominio1_dominio'                       => trim(strtoupper(strtolower($rowMSSQL00['tipo_dominio1_dominio']))),
                    'tipo_dominio1_observacion'                   => trim(strtoupper(strtolower($rowMSSQL00['tipo_dominio1_observacion']))),

                    'tipo_dominio2_codigo'                        => $rowMSSQL00['tipo_dominio__codigo'],
                    'tipo_dominio2_orden'                         => $rowMSSQL00['tipo_dominio2_orden'],
                    'tipo_dominio2_nombre_ingles'                 => trim(strtoupper(strtolower($rowMSSQL00['tipo_dominio2_nombre_ingles']))),
                    'tipo_dominio2_nombre_castellano'             => trim(strtoupper(strtolower($rowMSSQL00['tipo_dominio2_nombre_castellano']))),
                    'tipo_dominio2_nombre_portugues'              => trim(strtoupper(strtolower($rowMSSQL00['tipo_dominio2_nombre_portugues']))),
                    'tipo_dominio2_path'                          => trim(strtolower($rowMSSQL00['tipo_dominio2_path'])),
                    'tipo_dominio2_css'                           => trim(strtolower($rowMSSQL00['tipo_dominio2_css'])),
                    'tipo_dominio2_parametro'                     => $rowMSSQL00['tipo_dominio2_parametro'],
                    'tipo_dominio2_icono'                         => trim(strtolower($rowMSSQL00['tipo_dominio2_icono'])),
                    'tipo_dominio2_dominio'                       => trim(strtoupper(strtolower($rowMSSQL00['tipo_dominio2_dominio']))),
                    'tipo_dominio2_observacion'                   => trim(strtoupper(strtolower($rowMSSQL00['tipo_dominio2_observacion'])))
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
                    'tipo_dominio'                              => '',
                    'tipo_observacion'                          => '',

                    'tipo_estado_codigo'                        => '',
                    'tipo_estado_orden'                         => '',
                    'tipo_estado_nombre_ingles'                 => '',
                    'tipo_estado_nombre_castellano'             => '',
                    'tipo_estado_nombre_portugues'              => '',
                    'tipo_estado_path'                          => '',
                    'tipo_estado_css'                           => '',
                    'tipo_estado_parametro'                     => '',
                    'tipo_estado_icono'                         => '',
                    'tipo_estado_dominio'                       => '',
                    'tipo_estado_observacion'                   => '',

                    'auditoria_usuario'                         => '',
                    'auditoria_fecha_hora'                      => '',
                    'auditoria_ip'                              => '',

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

    $app->get('/v1/100/solicitud', function($request) {
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
            $connMSSQL  = getConnectionMSSQLv1();

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

    $app->get('/v1/100/solicitud/{codigo}', function($request) {
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
                $connMSSQL  = getConnectionMSSQLv1();

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

    $app->get('/v1/100/pais', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $sql00  = "SELECT
            a.LOCPAICOD         AS          pais_codigo,
            a.LOCPAIORD         AS          pais_orden,
            a.LOCPAINOM         AS          pais_nombre,
            a.LOCPAIPAT         AS          pais_path,
            a.LOCPAIIC2         AS          pais_iso_char2,
            a.LOCPAIIC3         AS          pais_iso_char3,
            a.LOCPAIIN3         AS          pais_iso_num3,
            a.LOCPAIOBS         AS          pais_observacion,

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
            $connMSSQL  = getConnectionMSSQLv1();

            $stmtMSSQL00= $connMSSQL->prepare($sql00);
            $stmtMSSQL00->execute();
            
            while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                $detalle    = array(
                    'pais_codigo'               => $rowMSSQL00['pais_codigo'],
                    'pais_orden'                => $rowMSSQL00['pais_orden'],
                    'pais_nombre'               => trim(strtoupper(strtolower($rowMSSQL00['pais_nombre']))),
                    'pais_path'                 => trim(strtolower($rowMSSQL00['pais_path'])),
                    'pais_iso_char2'            => trim(strtoupper(strtolower($rowMSSQL00['pais_iso_char2']))),
                    'pais_iso_char3'            => trim(strtoupper(strtolower($rowMSSQL00['pais_iso_char3']))),
                    'pais_iso_num3'             => sprintf("%03d", trim(strtoupper(strtolower($rowMSSQL00['pais_iso_num3'])))),
                    'pais_observacion'          => trim(strtoupper(strtolower($rowMSSQL00['pais_observacion']))),

                    'auditoria_usuario'         => trim(strtoupper($rowMSSQL00['auditoria_usuario'])),
                    'auditoria_fecha_hora'      => $rowMSSQL00['auditoria_fecha_hora'],
                    'auditoria_ip'              => trim(strtoupper($rowMSSQL00['auditoria_ip'])),

                    'tipo_estado_codigo'        => $rowMSSQL00['tipo_estado_codigo'],
                    'tipo_estado_ingles'        => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_ingles']))),
                    'tipo_estado_castellano'    => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_castellano']))),
                    'tipo_estado_portugues'     => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_portugues'])))
                );

                $result[]   = $detalle;
            }

            if (isset($result)){
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } else {
                $detalle = array(
                    'pais_codigo'               => '',
                    'pais_orden'                => '',
                    'pais_nombre'               => '',
                    'pais_path'                 => '',
                    'pais_iso_char2'            => '',
                    'pais_iso_char3'            => '',
                    'pais_iso_num3'             => '',
                    'pais_observacion'          => '',

                    'auditoria_usuario'         => '',
                    'auditoria_fecha_hora'      => '',
                    'auditoria_ip'              => '',

                    'tipo_estado_codigo'        => '',
                    'tipo_estado_ingles'        => '',
                    'tipo_estado_castellano'    => '',
                    'tipo_estado_portugues'     => ''
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

    $app->get('/v1/100/ciudad', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $sql00  = "SELECT
            a.LOCCIUCOD         AS          ciudad_codigo,
            a.LOCCIUORD         AS          ciudad_orden,
            a.LOCCIUNOM         AS          ciudad_nombre,
            a.LOCCIUOBS         AS          ciudad_observacion,

            a.LOCCIUAUS         AS          auditoria_usuario,
            a.LOCCIUAFH         AS          auditoria_fecha_hora,
            a.LOCCIUAIP         AS          auditoria_ip,

            b.DOMFICCOD         AS          tipo_estado_codigo,
            b.DOMFICNOI         AS          tipo_estado_ingles,
            b.DOMFICNOC         AS          tipo_estado_castellano,
            b.DOMFICNOP         AS          tipo_estado_portugues,

            c.LOCPAICOD         AS          pais_codigo,
            c.LOCPAIORD         AS          pais_orden,
            c.LOCPAINOM         AS          pais_nombre,
            c.LOCPAIPAT         AS          pais_path,
            c.LOCPAIIC2         AS          pais_iso_char2,
            c.LOCPAIIC3         AS          pais_iso_char3,
            c.LOCPAIIN3         AS          pais_iso_num3,
            c.LOCPAIOBS         AS          pais_observacion
            
            FROM [adm].[LOCCIU] a
            INNER JOIN [adm].[DOMFIC] b ON a.LOCCIUEST = b.DOMFICCOD
            INNER JOIN [adm].[LOCPAI] c ON a.LOCCIUPAC = c.LOCPAICOD

            ORDER BY a.LOCCIUORD, c.LOCPAINOM, a.LOCCIUNOM";

        try {
            $connMSSQL  = getConnectionMSSQLv1();

            $stmtMSSQL00= $connMSSQL->prepare($sql00);
            $stmtMSSQL00->execute();
            
            while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                $detalle    = array(
                    'ciudad_codigo'             => $rowMSSQL00['ciudad_codigo'],
                    'ciudad_orden'              => $rowMSSQL00['ciudad_orden'],
                    'ciudad_nombre'             => trim(strtoupper(strtolower($rowMSSQL00['ciudad_nombre']))),
                    'ciudad_observacion'        => trim(strtolower($rowMSSQL00['ciudad_observacion'])),

                    'auditoria_usuario'         => trim(strtoupper($rowMSSQL00['auditoria_usuario'])),
                    'auditoria_fecha_hora'      => $rowMSSQL00['auditoria_fecha_hora'],
                    'auditoria_ip'              => trim(strtoupper($rowMSSQL00['auditoria_ip'])),

                    'tipo_estado_codigo'        => $rowMSSQL00['tipo_estado_codigo'],
                    'tipo_estado_ingles'        => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_ingles']))),
                    'tipo_estado_castellano'    => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_castellano']))),
                    'tipo_estado_portugues'     => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_portugues']))),

                    'pais_codigo'               => $rowMSSQL00['pais_codigo'],
                    'pais_orden'                => $rowMSSQL00['pais_orden'],
                    'pais_nombre'               => trim(strtoupper(strtolower($rowMSSQL00['pais_nombre']))),
                    'pais_path'                 => trim(strtolower($rowMSSQL00['pais_path'])),
                    'pais_iso_char2'            => trim(strtoupper(strtolower($rowMSSQL00['pais_iso_char2']))),
                    'pais_iso_char3'            => trim(strtoupper(strtolower($rowMSSQL00['pais_iso_char3']))),
                    'pais_iso_num3'             => sprintf("%03d", trim(strtoupper(strtolower($rowMSSQL00['pais_iso_num3'])))),
                    'pais_observacion'          => trim(strtoupper(strtolower($rowMSSQL00['pais_observacion'])))
                );

                $result[]   = $detalle;
            }

            if (isset($result)){
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } else {
                $detalle = array(
                    'ciudad_codigo'             => '',
                    'ciudad_orden'              => '',
                    'ciudad_nombre'             => '',
                    'ciudad_observacion'        => '',

                    'auditoria_usuario'         => '',
                    'auditoria_fecha_hora'      => '',
                    'auditoria_ip'              => '',

                    'tipo_estado_codigo'        => '',
                    'tipo_estado_ingles'        => '',
                    'tipo_estado_castellano'    => '',
                    'tipo_estado_portugues'     => '',

                    'pais_codigo'               => '',
                    'pais_orden'                => '',
                    'pais_nombre'               => '',
                    'pais_path'                 => '',
                    'pais_iso_char2'            => '',
                    'pais_iso_char3'            => '',
                    'pais_iso_num3'             => '',
                    'pais_observacion'          => ''
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

    $app->get('/v1/300/workflow', function($request) {
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

            c.DOMFICCOD         AS          tipo_workflow_codigo,
            c.DOMFICNOI         AS          tipo_workflow_ingles,
            c.DOMFICNOC         AS          tipo_workflow_castellano,
            c.DOMFICNOP         AS          tipo_workflow_portugues,

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
            $connMSSQL  = getConnectionMSSQLv1();
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

                    'tipo_workflow_codigo'              => $rowMSSQL00['tipo_workflow_codigo'],
                    'tipo_workflow_ingles'              => trim(strtoupper(strtolower($rowMSSQL00['tipo_workflow_ingles']))),
                    'tipo_workflow_castellano'          => trim(strtoupper(strtolower($rowMSSQL00['tipo_workflow_castellano']))),
                    'tipo_workflow_portugues'           => trim(strtoupper(strtolower($rowMSSQL00['tipo_workflow_portugues']))),

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

                    'tipo_workflow_codigo'              => '',
                    'tipo_workflow_ingles'              => '',
                    'tipo_workflow_castellano'          => '',
                    'tipo_workflow_portugues'           => '',

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

    $app->get('/v1/300/workflow/codigo/{codigo}', function($request) {
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

                c.DOMFICCOD         AS          tipo_workflow_codigo,
                c.DOMFICNOI         AS          tipo_workflow_ingles,
                c.DOMFICNOC         AS          tipo_workflow_castellano,
                c.DOMFICNOP         AS          tipo_workflow_portugues,

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
                $connMSSQL  = getConnectionMSSQLv1();
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

                        'tipo_workflow_codigo'              => $rowMSSQL00['tipo_workflow_codigo'],
                        'tipo_workflow_ingles'              => trim(strtoupper(strtolower($rowMSSQL00['tipo_workflow_ingles']))),
                        'tipo_workflow_castellano'          => trim(strtoupper(strtolower($rowMSSQL00['tipo_workflow_castellano']))),
                        'tipo_workflow_portugues'           => trim(strtoupper(strtolower($rowMSSQL00['tipo_workflow_portugues']))),

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

                        'tipo_workflow_codigo'              => '',
                        'tipo_workflow_ingles'              => '',
                        'tipo_workflow_castellano'          => '',
                        'tipo_workflow_portugues'           => '',

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

    $app->get('/v1/300/workflow/cargo/{codigo}', function($request) {
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

                c.DOMFICCOD         AS          tipo_workflow_codigo,
                c.DOMFICNOI         AS          tipo_workflow_ingles,
                c.DOMFICNOC         AS          tipo_workflow_castellano,
                c.DOMFICNOP         AS          tipo_workflow_portugues,

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
                $connMSSQL  = getConnectionMSSQLv1();
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

                        'tipo_workflow_codigo'              => $rowMSSQL00['tipo_workflow_codigo'],
                        'tipo_workflow_ingles'              => trim(strtoupper(strtolower($rowMSSQL00['tipo_workflow_ingles']))),
                        'tipo_workflow_castellano'          => trim(strtoupper(strtolower($rowMSSQL00['tipo_workflow_castellano']))),
                        'tipo_workflow_portugues'           => trim(strtoupper(strtolower($rowMSSQL00['tipo_workflow_portugues']))),

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

                        'tipo_workflow_codigo'              => '',
                        'tipo_workflow_ingles'              => '',
                        'tipo_workflow_castellano'          => '',
                        'tipo_workflow_portugues'           => '',
                        
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

    $app->get('/v1/300/detalle', function($request) {
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

            d.DOMFICCOD         AS          estado_actual_codigo,
            d.DOMFICNOI         AS          estado_actual_ingles,
            d.DOMFICNOC         AS          estado_actual_castellano,
            d.DOMFICNOP         AS          estado_actual_portugues,

            e.DOMFICCOD         AS          tipo_prioridad_codigo,
            e.DOMFICNOI         AS          tipo_prioridad_ingles,
            e.DOMFICNOC         AS          tipo_prioridad_castellano,
            e.DOMFICNOP         AS          tipo_prioridad_portugues,

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
            $connMSSQL  = getConnectionMSSQLv1();
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

                    'estado_actual_codigo'              => $rowMSSQL00['estado_actual_codigo'],
                    'estado_actual_ingles'              => trim(strtoupper(strtolower($rowMSSQL00['estado_actual_ingles']))),
                    'estado_actual_castellano'          => trim(strtoupper(strtolower($rowMSSQL00['estado_actual_castellano']))),
                    'estado_actual_portugues'           => trim(strtoupper(strtolower($rowMSSQL00['estado_actual_portugues']))),

                    'tipo_prioridad_codigo'             => $rowMSSQL00['tipo_prioridad_codigo'],
                    'tipo_prioridad_ingles'             => trim(strtoupper(strtolower($rowMSSQL00['tipo_prioridad_ingles']))),
                    'tipo_prioridad_castellano'         => trim(strtoupper(strtolower($rowMSSQL00['tipo_prioridad_castellano']))),
                    'tipo_prioridad_portugues'          => trim(strtoupper(strtolower($rowMSSQL00['tipo_prioridad_portugues']))),

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

                    'estado_actual_codigo'              => '',
                    'estado_actual_ingles'              => '',
                    'estado_actual_castellano'          => '',
                    'estado_actual_portugues'           => '',

                    'tipo_prioridad_codigo'             => '',
                    'tipo_prioridad_ingles'             => '',
                    'tipo_prioridad_castellano'         => '',
                    'tipo_prioridad_portugues'          => '',

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

    $app->get('/v1/300/detalle/codigo/{codigo}', function($request) {
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

                d.DOMFICCOD         AS          estado_actual_codigo,
                d.DOMFICNOI         AS          estado_actual_ingles,
                d.DOMFICNOC         AS          estado_actual_castellano,
                d.DOMFICNOP         AS          estado_actual_portugues,

                e.DOMFICCOD         AS          tipo_prioridad_codigo,
                e.DOMFICNOI         AS          tipo_prioridad_ingles,
                e.DOMFICNOC         AS          tipo_prioridad_castellano,
                e.DOMFICNOP         AS          tipo_prioridad_portugues,

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
                $connMSSQL  = getConnectionMSSQLv1();
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

                        'estado_actual_codigo'              => $rowMSSQL00['estado_actual_codigo'],
                        'estado_actual_ingles'              => trim(strtoupper(strtolower($rowMSSQL00['estado_actual_ingles']))),
                        'estado_actual_castellano'          => trim(strtoupper(strtolower($rowMSSQL00['estado_actual_castellano']))),
                        'estado_actual_portugues'           => trim(strtoupper(strtolower($rowMSSQL00['estado_actual_portugues']))),

                        'tipo_prioridad_codigo'             => $rowMSSQL00['tipo_prioridad_codigo'],
                        'tipo_prioridad_ingles'             => trim(strtoupper(strtolower($rowMSSQL00['tipo_prioridad_ingles']))),
                        'tipo_prioridad_castellano'         => trim(strtoupper(strtolower($rowMSSQL00['tipo_prioridad_castellano']))),
                        'tipo_prioridad_portugues'          => trim(strtoupper(strtolower($rowMSSQL00['tipo_prioridad_portugues']))),

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

                        'estado_actual_codigo'              => '',
                        'estado_actual_ingles'              => '',
                        'estado_actual_castellano'          => '',
                        'estado_actual_portugues'           => '',

                        'tipo_prioridad_codigo'             => '',
                        'tipo_prioridad_ingles'             => '',
                        'tipo_prioridad_castellano'         => '',
                        'tipo_prioridad_portugues'          => '',

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

    $app->get('/v1/300/detalle/workflow/{codigo}', function($request) {
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

                d.DOMFICCOD         AS          estado_actual_codigo,
                d.DOMFICNOI         AS          estado_actual_ingles,
                d.DOMFICNOC         AS          estado_actual_castellano,
                d.DOMFICNOP         AS          estado_actual_portugues,

                e.DOMFICCOD         AS          tipo_prioridad_codigo,
                e.DOMFICNOI         AS          tipo_prioridad_ingles,
                e.DOMFICNOC         AS          tipo_prioridad_castellano,
                e.DOMFICNOP         AS          tipo_prioridad_portugues,

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
                $connMSSQL  = getConnectionMSSQLv1();
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

                        'estado_actual_codigo'              => $rowMSSQL00['estado_actual_codigo'],
                        'estado_actual_ingles'              => trim(strtoupper(strtolower($rowMSSQL00['estado_actual_ingles']))),
                        'estado_actual_castellano'          => trim(strtoupper(strtolower($rowMSSQL00['estado_actual_castellano']))),
                        'estado_actual_portugues'           => trim(strtoupper(strtolower($rowMSSQL00['estado_actual_portugues']))),

                        'tipo_prioridad_codigo'             => $rowMSSQL00['tipo_prioridad_codigo'],
                        'tipo_prioridad_ingles'             => trim(strtoupper(strtolower($rowMSSQL00['tipo_prioridad_ingles']))),
                        'tipo_prioridad_castellano'         => trim(strtoupper(strtolower($rowMSSQL00['tipo_prioridad_castellano']))),
                        'tipo_prioridad_portugues'          => trim(strtoupper(strtolower($rowMSSQL00['tipo_prioridad_portugues']))),

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

                        'estado_actual_codigo'              => '',
                        'estado_actual_ingles'              => '',
                        'estado_actual_castellano'          => '',
                        'estado_actual_portugues'           => '',

                        'tipo_prioridad_codigo'             => '',
                        'tipo_prioridad_ingles'             => '',
                        'tipo_prioridad_castellano'         => '',
                        'tipo_prioridad_portugues'          => '',

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

    $app->get('/v1/400/proveedor', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $sql00  = "SELECT
            a.PROFICCOD         AS          proveedor_codigo,
            a.PROFICNOM         AS          proveedor_nombre,
            a.PROFICRAZ         AS          proveedor_razon_social,
            a.PROFICRUC         AS          proveedor_ruc,
            a.PROFICPAI         AS          proveedor_pais,
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

            c.DOMFICCOD         AS          tipo_proveedor_codigo,
            c.DOMFICNOI         AS          tipo_proveedor_ingles,
            c.DOMFICNOC         AS          tipo_proveedor_castellano,
            c.DOMFICNOP         AS          tipo_proveedor_portugues

            FROM [via].[PROFIC] a
            INNER JOIN [adm].[DOMFIC] b ON a.PROFICEST = b.DOMFICCOD
            INNER JOIN [adm].[DOMFIC] c ON a.PROFICTPC = c.DOMFICCOD
            
            ORDER BY a.PROFICTPC";

        try {
            $connMSSQL  = getConnectionMSSQLv1();
            $stmtMSSQL00= $connMSSQL->prepare($sql00);
            $stmtMSSQL00->execute();

            while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                $detalle    = array(
                    'proveedor_codigo'                  => $rowMSSQL00['proveedor_codigo'],
                    'proveedor_nombre'                  => trim(strtoupper(strtolower($rowMSSQL00['proveedor_nombre']))),
                    'proveedor_razon_social'            => trim(strtoupper(strtolower($rowMSSQL00['proveedor_razon_social']))),
                    'proveedor_ruc'                     => trim(strtoupper(strtolower($rowMSSQL00['proveedor_ruc']))),
                    'proveedor_pais'                    => trim(strtoupper(strtolower($rowMSSQL00['proveedor_pais']))),
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

                    'tipo_proveedor_codigo'             => $rowMSSQL00['tipo_proveedor_codigo'],
                    'tipo_proveedor_ingles'             => trim(strtoupper(strtolower($rowMSSQL00['tipo_proveedor_ingles']))),
                    'tipo_proveedor_castellano'         => trim(strtoupper(strtolower($rowMSSQL00['tipo_proveedor_castellano']))),
                    'tipo_proveedor_portugues'          => trim(strtoupper(strtolower($rowMSSQL00['tipo_proveedor_portugues'])))     
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
                    'proveedor_pais'                    => '',
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

                    'tipo_proveedor_codigo'             => '',
                    'tipo_proveedor_ingles'             => '',
                    'tipo_proveedor_castellano'         => '',
                    'tipo_proveedor_portugues'          => ''
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

    $app->get('/v1/400/proveedor/codigo/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01  = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
                a.PROFICCOD         AS          proveedor_codigo,
                a.PROFICNOM         AS          proveedor_nombre,
                a.PROFICRAZ         AS          proveedor_razon_social,
                a.PROFICRUC         AS          proveedor_ruc,
                a.PROFICPAI         AS          proveedor_pais,
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

                c.DOMFICCOD         AS          tipo_proveedor_codigo,
                c.DOMFICNOI         AS          tipo_proveedor_ingles,
                c.DOMFICNOC         AS          tipo_proveedor_castellano,
                c.DOMFICNOP         AS          tipo_proveedor_portugues

                FROM [via].[PROFIC] a
                INNER JOIN [adm].[DOMFIC] b ON a.PROFICEST = b.DOMFICCOD
                INNER JOIN [adm].[DOMFIC] c ON a.PROFICTPC = c.DOMFICCOD

                WHERE a.PROFICCOD = ?
                
                ORDER BY a.PROFICTPC";

            try {
                $connMSSQL  = getConnectionMSSQLv1();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val01]);

                while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                    $detalle    = array(
                        'proveedor_codigo'                  => $rowMSSQL00['proveedor_codigo'],
                        'proveedor_nombre'                  => trim(strtoupper(strtolower($rowMSSQL00['proveedor_nombre']))),
                        'proveedor_razon_social'            => trim(strtoupper(strtolower($rowMSSQL00['proveedor_razon_social']))),
                        'proveedor_ruc'                     => trim(strtoupper(strtolower($rowMSSQL00['proveedor_ruc']))),
                        'proveedor_pais'                    => trim(strtoupper(strtolower($rowMSSQL00['proveedor_pais']))),
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

                        'tipo_proveedor_codigo'             => $rowMSSQL00['tipo_proveedor_codigo'],
                        'tipo_proveedor_ingles'             => trim(strtoupper(strtolower($rowMSSQL00['tipo_proveedor_ingles']))),
                        'tipo_proveedor_castellano'         => trim(strtoupper(strtolower($rowMSSQL00['tipo_proveedor_castellano']))),
                        'tipo_proveedor_portugues'          => trim(strtoupper(strtolower($rowMSSQL00['tipo_proveedor_portugues'])))     
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
                        'proveedor_pais'                    => '',
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

                        'tipo_proveedor_codigo'             => '',
                        'tipo_proveedor_ingles'             => '',
                        'tipo_proveedor_castellano'         => '',
                        'tipo_proveedor_portugues'          => ''
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

    $app->get('/v1/400/proveedor/contacto/{codigo}', function($request) {
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

                c.PROFICCOD         AS          proveedor_codigo,
                c.PROFICNOM         AS          proveedor_nombre,
                c.PROFICRAZ         AS          proveedor_razon_social,
                c.PROFICRUC         AS          proveedor_ruc,
                c.PROFICPAI         AS          proveedor_pais,
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
                $connMSSQL  = getConnectionMSSQLv1();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val01]);

                while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                    $detalle    = array(
                        'proveedor_contacto_codigo'         => $rowMSSQL00['proveedor_contacto_codigo'],
                        'proveedor_contacto_nombre'         => trim(strtoupper(strtolower($rowMSSQL00['proveedor_contacto_nombre']))),
                        'proveedor_contacto_email'          => trim(strtolower($rowMSSQL00['proveedor_contacto_email'])),
                        'proveedor_contacto_telefono'       => trim(strtoupper(strtolower($rowMSSQL00['proveedor_contacto_telefono']))),
                        'proveedor_contacto_whatsapp'       => trim(strtoupper(strtolower($rowMSSQL00['proveedor_contacto_whatsapp']))),
                        'proveedor_contacto_skype'          => trim(strtoupper(strtolower($rowMSSQL00['proveedor_contacto_skype']))),
                        'proveedor_contacto_observacion'    => trim(strtoupper(strtolower($rowMSSQL00['proveedor_contacto_observacion']))),

                        'auditoria_usuario'                 => trim(strtoupper(strtolower($rowMSSQL00['auditoria_usuario']))),
                        'auditoria_fecha_hora'              => date("d/m/Y", strtotime($rowMSSQL00['auditoria_fecha_hora'])),
                        'auditoria_ip'                      => trim(strtoupper(strtolower($rowMSSQL00['auditoria_ip']))),

                        'tipo_estado_codigo'                => $rowMSSQL00['tipo_estado_codigo'],
                        'tipo_estado_ingles'                => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_ingles']))),
                        'tipo_estado_castellano'            => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_castellano']))),
                        'tipo_estado_portugues'             => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_portugues']))),

                        'proveedor_codigo'                  => $rowMSSQL00['proveedor_codigo'],
                        'proveedor_nombre'                  => trim(strtoupper(strtolower($rowMSSQL00['proveedor_nombre']))),
                        'proveedor_razon_social'            => trim(strtoupper(strtolower($rowMSSQL00['proveedor_razon_social']))),
                        'proveedor_ruc'                     => trim(strtoupper(strtolower($rowMSSQL00['proveedor_ruc']))),
                        'proveedor_pais'                    => trim(strtoupper(strtolower($rowMSSQL00['proveedor_pais']))),
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
                        
                        'proveedor_codigo'                  => '',
                        'proveedor_nombre'                  => '',
                        'proveedor_razon_social'            => '',
                        'proveedor_ruc'                     => '',
                        'proveedor_pais'                    => '',
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

    $app->get('/v1/400/proveedor/habitacion/{codigo}', function($request) {
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

                c.DOMFICCOD         AS          tipo_habitacion_codigo,
                c.DOMFICNOI         AS          tipo_habitacion_ingles,
                c.DOMFICNOC         AS          tipo_habitacion_castellano,
                c.DOMFICNOP         AS          tipo_habitacion_portugues,

                d.PROFICCOD         AS          proveedor_codigo,
                d.PROFICNOM         AS          proveedor_nombre,
                d.PROFICRAZ         AS          proveedor_razon_social,
                d.PROFICRUC         AS          proveedor_ruc,
                d.PROFICPAI         AS          proveedor_pais,
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
                $connMSSQL  = getConnectionMSSQLv1();
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

                        'tipo_habitacion_codigo'            => $rowMSSQL00['tipo_habitacion_codigo'],
                        'tipo_habitacion_ingles'            => trim(strtoupper(strtolower($rowMSSQL00['tipo_habitacion_ingles']))),
                        'tipo_habitacion_castellano'        => trim(strtoupper(strtolower($rowMSSQL00['tipo_habitacion_castellano']))),
                        'tipo_habitacion_portugues'         => trim(strtoupper(strtolower($rowMSSQL00['tipo_habitacion_portugues']))),

                        'proveedor_codigo'                  => $rowMSSQL00['proveedor_codigo'],
                        'proveedor_nombre'                  => trim(strtoupper(strtolower($rowMSSQL00['proveedor_nombre']))),
                        'proveedor_razon_social'            => trim(strtoupper(strtolower($rowMSSQL00['proveedor_razon_social']))),
                        'proveedor_ruc'                     => trim(strtoupper(strtolower($rowMSSQL00['proveedor_ruc']))),
                        'proveedor_pais'                    => trim(strtoupper(strtolower($rowMSSQL00['proveedor_pais']))),
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

                        'tipo_habitacion_codigo'            => '',
                        'tipo_habitacion_ingles'            => '',
                        'tipo_habitacion_castellano'        => '',
                        'tipo_habitacion_portugues'         => '',

                        'proveedor_codigo'                  => '',
                        'proveedor_nombre'                  => '',
                        'proveedor_razon_social'            => '',
                        'proveedor_ruc'                     => '',
                        'proveedor_pais'                    => '',
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

//MODULO PORTAL PERMISO
    $app->get('/v1/200/solicitudes', function($request) {
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
            a.SOLFICADJ         AS          solicitud_adjunto1,
            a.SOLFICAD2         AS          solicitud_adjunto2,
            a.SOLFICAD3         AS          solicitud_adjunto3,
            a.SOLFICAD4         AS          solicitud_adjunto4,
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
            $connMSSQL  = getConnectionMSSQLv1();
            
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

                $solicitud_adjunto1 = trim(strtolower($rowMSSQL01['solicitud_adjunto1']));
                $solicitud_adjunto2 = trim(strtolower($rowMSSQL01['solicitud_adjunto2']));
                $solicitud_adjunto3 = trim(strtolower($rowMSSQL01['solicitud_adjunto3']));
                $solicitud_adjunto4 = trim(strtolower($rowMSSQL01['solicitud_adjunto4']));

                if ($solicitud_adjunto1 == $solicitud_adjunto2){
                    $solicitud_adjunto2 = '';
                }

                if ($solicitud_adjunto1 == $solicitud_adjunto3){
                    $solicitud_adjunto3 = '';
                }

                if ($solicitud_adjunto1 == $solicitud_adjunto4){
                    $solicitud_adjunto4 = '';
                }

                if ($solicitud_adjunto2 == $solicitud_adjunto3){
                    $solicitud_adjunto3 = '';
                }

                if ($solicitud_adjunto2 == $solicitud_adjunto4){
                    $solicitud_adjunto4 = '';
                }

                if ($solicitud_adjunto3 == $solicitud_adjunto4){
                    $solicitud_adjunto4 = '';
                }

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
                    'solicitud_adjunto1'                => $solicitud_adjunto1,
                    'solicitud_adjunto2'                => $solicitud_adjunto2,
                    'solicitud_adjunto3'                => $solicitud_adjunto3,
                    'solicitud_adjunto4'                => $solicitud_adjunto4,
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
                    'solicitud_adjunto1'                => '',
                    'solicitud_adjunto2'                => '',
                    'solicitud_adjunto3'                => '',
                    'solicitud_adjunto4'                => '',
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

    $app->get('/v1/200/solicitudes/codigo/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getAttribute('codigo');

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
                a.SOLFICADJ         AS          solicitud_adjunto1,
                a.SOLFICAD2         AS          solicitud_adjunto2,
                a.SOLFICAD3         AS          solicitud_adjunto3,
                a.SOLFICAD4         AS          solicitud_adjunto4,
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
                
                WHERE a.SOLFICCOD = ?";

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
                $connMSSQL  = getConnectionMSSQLv1();
                
                $stmtMSSQL01= $connMSSQL->prepare($sql01);
                $stmtMSSQL01->execute([$val01]);

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

                    $solicitud_adjunto1 = trim(strtolower($rowMSSQL01['solicitud_adjunto1']));
                    $solicitud_adjunto2 = trim(strtolower($rowMSSQL01['solicitud_adjunto2']));
                    $solicitud_adjunto3 = trim(strtolower($rowMSSQL01['solicitud_adjunto3']));
                    $solicitud_adjunto4 = trim(strtolower($rowMSSQL01['solicitud_adjunto4']));

                    if ($solicitud_adjunto1 == $solicitud_adjunto2){
                        $solicitud_adjunto2 = '';
                    }

                    if ($solicitud_adjunto1 == $solicitud_adjunto3){
                        $solicitud_adjunto3 = '';
                    }

                    if ($solicitud_adjunto1 == $solicitud_adjunto4){
                        $solicitud_adjunto4 = '';
                    }

                    if ($solicitud_adjunto2 == $solicitud_adjunto3){
                        $solicitud_adjunto3 = '';
                    }

                    if ($solicitud_adjunto2 == $solicitud_adjunto4){
                        $solicitud_adjunto4 = '';
                    }

                    if ($solicitud_adjunto3 == $solicitud_adjunto4){
                        $solicitud_adjunto4 = '';
                    }

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
                        'solicitud_adjunto1'                => $solicitud_adjunto1,
                        'solicitud_adjunto2'                => $solicitud_adjunto2,
                        'solicitud_adjunto3'                => $solicitud_adjunto3,
                        'solicitud_adjunto4'                => $solicitud_adjunto4,
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
                        'solicitud_adjunto1'                => '',
                        'solicitud_adjunto2'                => '',
                        'solicitud_adjunto3'                => '',
                        'solicitud_adjunto4'                => '',
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
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v1/200/solicitudes/{tipo}/{codigo}/{estado}', function($request) {
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

                    WHERE b.CedulaEmpleado = ? AND (b.Estado = 'V' OR (b.Estado = 'N' AND (b.CedulaEmpleado = '798293' OR b.CedulaEmpleado = '1421530' OR b.CedulaEmpleado = '7951461' OR b.CedulaEmpleado = '574039' OR b.CedulaEmpleado = '17388982-7' OR b.CedulaEmpleado = '426942' OR b.CedulaEmpleado = '530962500')))";
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
                    LEFT OUTER JOIN [CSF].[dbo].[empleados_AxisONE] b ON a.CodCargoSuperior = b.CodigoCargo
                    
                    WHERE (b.Estado = 'V' OR b.Estado is null OR (b.Estado = 'N' AND (b.CedulaEmpleado = '798293' OR b.CedulaEmpleado = '1421530' OR b.CedulaEmpleado = '7951461' OR b.CedulaEmpleado = '574039' OR b.CedulaEmpleado = '17388982-7' OR b.CedulaEmpleado = '426942' OR b.CedulaEmpleado = '530962500')))";
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

                    WHERE (a.CedulaEmpleado = ? OR b.CedulaEmpleado = ?) AND (b.Estado = 'V' OR  b.Estado IS NULL OR (b.Estado = 'N' AND (b.CedulaEmpleado = '798293' OR b.CedulaEmpleado = '1421530' OR b.CedulaEmpleado = '7951461' OR b.CedulaEmpleado = '574039' OR b.CedulaEmpleado = '17388982-7' OR b.CedulaEmpleado = '426942' OR b.CedulaEmpleado = '530962500')))";
            } elseif ($val01 == '5') {
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
                    WHERE a.CedulaEmpleado IN (SELECT DISTINCT(CONVERT(VARCHAR(MAX), b.SOLFICDOC)) COLLATE SQL_Latin1_General_CP1_CI_AS FROM [hum].[SOLFIC] b WHERE b.SOLFICDOJ = ?)";
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
                    a.SOLFICADJ         AS          solicitud_adjunto1,
                    a.SOLFICAD2         AS          solicitud_adjunto2,
                    a.SOLFICAD3         AS          solicitud_adjunto3,
                    a.SOLFICAD4         AS          solicitud_adjunto4, 
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
                    a.SOLFICADJ         AS          solicitud_adjunto1,
                    a.SOLFICAD2         AS          solicitud_adjunto2,
                    a.SOLFICAD3         AS          solicitud_adjunto3,
                    a.SOLFICAD4         AS          solicitud_adjunto4, 
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
                    a.SOLFICADJ         AS          solicitud_adjunto1,
                    a.SOLFICAD2         AS          solicitud_adjunto2,
                    a.SOLFICAD3         AS          solicitud_adjunto3,
                    a.SOLFICAD4         AS          solicitud_adjunto4, 
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
                $connMSSQL  = getConnectionMSSQLv1();
                
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

                        $solicitud_adjunto1 = trim(strtolower($rowMSSQL01['solicitud_adjunto1']));
                        $solicitud_adjunto2 = trim(strtolower($rowMSSQL01['solicitud_adjunto2']));
                        $solicitud_adjunto3 = trim(strtolower($rowMSSQL01['solicitud_adjunto3']));
                        $solicitud_adjunto4 = trim(strtolower($rowMSSQL01['solicitud_adjunto4']));

                        if ($solicitud_adjunto1 == $solicitud_adjunto2){
                            $solicitud_adjunto2 = '';
                        }

                        if ($solicitud_adjunto1 == $solicitud_adjunto3){
                            $solicitud_adjunto3 = '';
                        }

                        if ($solicitud_adjunto1 == $solicitud_adjunto4){
                            $solicitud_adjunto4 = '';
                        }

                        if ($solicitud_adjunto2 == $solicitud_adjunto3){
                            $solicitud_adjunto3 = '';
                        }

                        if ($solicitud_adjunto2 == $solicitud_adjunto4){
                            $solicitud_adjunto4 = '';
                        }

                        if ($solicitud_adjunto3 == $solicitud_adjunto4){
                            $solicitud_adjunto4 = '';
                        }

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
                            'solicitud_adjunto1'                => $solicitud_adjunto1,
                            'solicitud_adjunto2'                => $solicitud_adjunto2,
                            'solicitud_adjunto3'                => $solicitud_adjunto3,
                            'solicitud_adjunto4'                => $solicitud_adjunto4,
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
                        'solicitud_adjunto1'                => '',
                        'solicitud_adjunto2'                => '',
                        'solicitud_adjunto3'                => '',
                        'solicitud_adjunto4'                => '',
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

    $app->get('/v1/200/solicitudes/grafico/tipocab/{sexo}/{tipo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val01  = $request->getAttribute('sexo');
        $val02  = $request->getAttribute('tipo');

        $sql01  = "SELECT count(*) AS solicitud_cantidad, 'TOTAL_COLABORADOR' AS solicitud_tipo
            FROM [CSF].[dbo].[empleados_AxisONE] a
            WHERE a.SEXO = ? AND a.Estado = 'V'
            UNION
            SELECT count(*)  AS solicitud_cantidad, 'CON_SOLICITUD' AS solicitud_tipo
            FROM [CSF].[dbo].[empleados_AxisONE] a
            WHERE a.SEXO = ? AND a.Estado = 'V' AND EXISTS (SELECT * FROM [hum].[SOLFIC] b WHERE b.SOLFICEST <> 'C' AND b.SOLFICTST = ? AND a.CedulaEmpleado = b.SOLFICDOC COLLATE SQL_Latin1_General_CP1_CI_AS)
            UNION
            SELECT count(*)  AS solicitud_cantidad, 'SIN_SOLICITUD' AS solicitud_tipo
            FROM [CSF].[dbo].[empleados_AxisONE] a
            WHERE a.SEXO = ? AND a.Estado = 'V' AND NOT EXISTS (SELECT * FROM [hum].[SOLFIC] b WHERE b.SOLFICEST <> 'C' AND b.SOLFICTST = ? AND a.CedulaEmpleado = b.SOLFICDOC COLLATE SQL_Latin1_General_CP1_CI_AS)";

        try {
            $connMSSQL  = getConnectionMSSQLv1();
            
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

    $app->get('/v1/200/solicitudes/grafico/tipodet/{sexo}/{tipo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val01  = $request->getAttribute('sexo');
        $val02  = $request->getAttribute('tipo');

        $sql01  = "SELECT a.CedulaEmpleado AS solicitud_documento, a.NombreEmpleado AS solicitud_persona, 'CON_SOLICITUD' AS solicitud_tipo
            FROM [CSF].[dbo].[empleados_AxisONE] a
            WHERE a.SEXO = ? AND a.Estado = 'V' AND EXISTS (SELECT * FROM [hum].[SOLFIC] b WHERE b.SOLFICEST <> 'C' AND b.SOLFICTST = ? AND a.CedulaEmpleado = b.SOLFICDOC COLLATE SQL_Latin1_General_CP1_CI_AS)
            UNION
            SELECT a.CedulaEmpleado AS solicitud_documento, a.NombreEmpleado AS solicitud_persona, 'SIN_SOLICITUD' AS solicitud_tipo
            FROM [CSF].[dbo].[empleados_AxisONE] a
            WHERE a.SEXO = ? AND a.Estado = 'V' AND NOT EXISTS (SELECT * FROM [hum].[SOLFIC] b WHERE b.SOLFICEST <> 'C' AND b.SOLFICTST = ? AND a.CedulaEmpleado = b.SOLFICDOC COLLATE SQL_Latin1_General_CP1_CI_AS)";

        try {
            $connMSSQL  = getConnectionMSSQLv1();
            
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

    $app->get('/v1/200/solicitudessap/axisone/{codigo}/{estado}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val01      = $request->getAttribute('codigo');
        $val02      = $request->getAttribute('estado');

        if (isset($val01) && isset($val02)){

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

                WHERE a.SOLAXISOL = ? AND a.SOLAXIEST = ?

                ORDER BY a.SOLAXICOD DESC";
                    
            try {
                $connMSSQL  = getConnectionMSSQLv1();

                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val01, $val02]);

                while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {

                    if ($rowMSSQL00['solicitud_detalle_fecha_desde'] == '1900-01-01' || $rowMSSQL00['solicitud_detalle_fecha_desde'] == null){
                        $solicitud_detalle_fecha_desde_1 = '';
                        $solicitud_detalle_fecha_desde_2 = '';
                    } else {
                        $solicitud_detalle_fecha_desde_1 = $rowMSSQL00['solicitud_detalle_fecha_desde'];
                        $solicitud_detalle_fecha_desde_2 = date('d/m/Y', strtotime($rowMSSQL00['solicitud_detalle_fecha_desde']));
                    }

                    if ($rowMSSQL00['solicitud_detalle_fecha_hasta'] == '1900-01-01' || $rowMSSQL00['solicitud_detalle_fecha_hasta'] == null){
                        $solicitud_detalle_fecha_hasta_1 = '';
                        $solicitud_detalle_fecha_hasta_2 = '';
                    } else {
                        $solicitud_detalle_fecha_hasta_1 = $rowMSSQL00['solicitud_detalle_fecha_hasta'];
                        $solicitud_detalle_fecha_hasta_2 = date('d/m/Y', strtotime($rowMSSQL00['solicitud_detalle_fecha_hasta']));
                    }

                    if ($rowMSSQL00['solicitud_detalle_aplicacion_desde'] == '1900-01-01' || $rowMSSQL00['solicitud_detalle_aplicacion_desde'] == null){
                        $solicitud_detalle_aplicacion_desde_1 = '';
                        $solicitud_detalle_aplicacion_desde_2 = '';
                    } else {
                        $solicitud_detalle_aplicacion_desde_1 = $rowMSSQL00['solicitud_detalle_aplicacion_desde'];
                        $solicitud_detalle_aplicacion_desde_2 = date('d/m/Y', strtotime($rowMSSQL00['solicitud_detalle_aplicacion_desde']));
                    }

                    if ($rowMSSQL00['solicitud_detalle_aplicacion_hasta'] == '1900-01-01' || $rowMSSQL00['solicitud_detalle_aplicacion_hasta'] == null){
                        $solicitud_detalle_aplicacion_hasta_1 = '';
                        $solicitud_detalle_aplicacion_desde_2 = '';
                    } else {
                        $solicitud_detalle_aplicacion_hasta_1 = $rowMSSQL00['solicitud_detalle_aplicacion_hasta'];
                        $solicitud_detalle_aplicacion_hasta_2 = date('d/m/Y', strtotime($rowMSSQL00['solicitud_detalle_aplicacion_hasta']));
                    }

                    $detalle    = array(
                        'solicitud_detalle_codigo'                      => $rowMSSQL00['solicitud_detalle_codigo'],
                        'solicitud_detalle_cabecera'                    => $rowMSSQL00['solicitud_detalle_cabecera'],
                        'solicitud_detalle_estado'                      => trim(strtoupper($rowMSSQL00['solicitud_detalle_estado'])),
                        'solicitud_detalle_solicitud'                   => trim(strtoupper($rowMSSQL00['solicitud_detalle_solicitud'])),
                        'solicitud_detalle_empleado'                    => trim(strtoupper($rowMSSQL00['solicitud_detalle_empleado'])),
                        'solicitud_detalle_fecha_desde_1'               => $solicitud_detalle_fecha_desde_1,
                        'solicitud_detalle_fecha_desde_2'               => $solicitud_detalle_fecha_desde_2,
                        'solicitud_detalle_fecha_hasta_1'               => $solicitud_detalle_fecha_hasta_1,
                        'solicitud_detalle_fecha_hasta_2'               => $solicitud_detalle_fecha_hasta_2,
                        'solicitud_detalle_aplicacion_desde_1'          => $solicitud_detalle_aplicacion_desde_1,
                        'solicitud_detalle_aplicacion_desde_2'          => $solicitud_detalle_aplicacion_desde_2,
                        'solicitud_detalle_aplicacion_hasta_1'          => $solicitud_detalle_aplicacion_hasta_1,
                        'solicitud_detalle_aplicacion_hasta_2'          => $solicitud_detalle_aplicacion_hasta_2,
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

    $app->get('/v1/200/comprobante', function($request) {
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
            b.DOMFICORD         AS          tipo_estado_orden,
            b.DOMFICPAR         AS          tipo_estado_parametro,
            b.DOMFICNOI         AS          tipo_estado_ingles,
            b.DOMFICNOC         AS          tipo_estado_castellano,
            b.DOMFICNOP         AS          tipo_estado_portugues,
            b.DOMFICPAT         AS          tipo_estado_path,
            b.DOMFICCSS         AS          tipo_estado_css,
            b.DOMFICICO         AS          tipo_estado_icono,
            b.DOMFICVAL         AS          tipo_estado_dominio,
            b.DOMFICOBS         AS          tipo_estado_observacion,

            c.DOMFICCOD         AS          tipo_comprobante_codigo,
            c.DOMFICORD         AS          tipo_comprobante_orden,
            c.DOMFICPAR         AS          tipo_comprobante_parametro,
            c.DOMFICNOI         AS          tipo_comprobante_ingles,
            c.DOMFICNOC         AS          tipo_comprobante_castellano,
            c.DOMFICNOP         AS          tipo_comprobante_portugues,
            c.DOMFICPAT         AS          tipo_comprobante_path,
            c.DOMFICCSS         AS          tipo_comprobante_css,
            c.DOMFICICO         AS          tipo_comprobante_icono,
            c.DOMFICVAL         AS          tipo_comprobante_dominio,

            d.DOMFICCOD         AS          tipo_mes_codigo,
            d.DOMFICORD         AS          tipo_mes_orden,
            d.DOMFICPAR         AS          tipo_mes_parametro,
            d.DOMFICNOI         AS          tipo_mes_ingles,
            d.DOMFICNOC         AS          tipo_mes_castellano,
            d.DOMFICNOP         AS          tipo_mes_portugues,
            d.DOMFICPAT         AS          tipo_mes_path,
            d.DOMFICCSS         AS          tipo_mes_css,
            d.DOMFICICO         AS          tipo_mes_icono,
            d.DOMFICVAL         AS          tipo_mes_dominio

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
            $connMSSQL  = getConnectionMSSQLv1();
            
            $stmtMSSQL00= $connMSSQL->prepare($sql00);
            $stmtMSSQL01= $connMSSQL->prepare($sql01);

            $stmtMSSQL00->execute();

            while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                $nroDoc     = trim(strtoupper(strtolower($rowMSSQL00['comprobante_documento'])));
                $stmtMSSQL01->execute([$nroDoc]);
                $rowMSSQL01 = $stmtMSSQL01->fetch(PDO::FETCH_ASSOC);

                $periodo    = $rowMSSQL00['comprobante_periodo'];
                $mes        = $rowMSSQL00['tipo_mes_parametro'];
                $comprobante= $rowMSSQL00['tipo_comprobante_parametro'];

                if ($rowMSSQL00['tipo_mes_parametro'] > 0 && $rowMSSQL00['tipo_mes_parametro'] < 10){
                    $comprobante_codigo_barra = $nroDoc."'".$periodo.'-'.'0'.$mes."'".$comprobante;
                } else {
                    $comprobante_codigo_barra = $nroDoc."'".$periodo.'-'.$mes."'".$comprobante;
                }

                $detalle    = array(
                    'comprobante_codigo'                => $rowMSSQL00['comprobante_codigo'],
                    'comprobante_codigo_barra'          => trim(strtoupper(strtolower($comprobante_codigo_barra))),
                    'comprobante_periodo'               => $rowMSSQL00['comprobante_periodo'],
                    'comprobante_colaborador'           => trim(strtoupper(strtolower($rowMSSQL01['nombre_completo']))),
                    'comprobante_email'                 => trim(strtolower($rowMSSQL01['email'])),
                    'comprobante_documento'             => trim(strtoupper(strtolower($rowMSSQL00['comprobante_documento']))),
                    'comprobante_adjunto'               => trim(strtolower($rowMSSQL00['comprobante_adjunto'])),
                    'comprobante_observacion'           => trim(strtoupper(strtolower($rowMSSQL00['comprobante_observacion']))),

                    'auditoria_usuario'                 => trim(strtoupper(strtolower($rowMSSQL01['auditoria_usuario']))),
                    'auditoria_fecha_hora'              => date("d/m/Y", strtotime($rowMSSQL01['auditoria_fecha_hora'])),
                    'auditoria_ip'                      => trim(strtoupper(strtolower($rowMSSQL01['auditoria_ip']))),

                    'tipo_estado_codigo'                => $rowMSSQL00['tipo_estado_codigo'],
                    'tipo_estado_orden'                 => $rowMSSQL00['tipo_estado_orden'],
                    'tipo_estado_parametro'             => $rowMSSQL00['tipo_estado_parametro'],
                    'tipo_estado_ingles'                => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_ingles']))),
                    'tipo_estado_castellano'            => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_castellano']))),
                    'tipo_estado_portugues'             => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_portugues']))),
                    'tipo_estado_path'                  => trim(strtolower($rowMSSQL00['tipo_estado_path'])),
                    'tipo_estado_css'                   => trim(strtolower($rowMSSQL00['tipo_estado_css'])),
                    'tipo_estado_icono'                 => trim(strtolower($rowMSSQL00['tipo_estado_icono'])),
                    'tipo_estado_dominio'               => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_dominio']))),
                    'tipo_estado_observacion'           => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_observacion']))),

                    'tipo_comprobante_codigo'           => $rowMSSQL00['tipo_comprobante_codigo'],
                    'tipo_comprobante_orden'            => $rowMSSQL00['tipo_comprobante_orden'],
                    'tipo_comprobante_parametro'        => $rowMSSQL00['tipo_comprobante_parametro'],
                    'tipo_comprobante_ingles'           => trim(strtoupper(strtolower($rowMSSQL00['tipo_comprobante_ingles']))),
                    'tipo_comprobante_castellano'       => trim(strtoupper(strtolower($rowMSSQL00['tipo_comprobante_castellano']))),
                    'tipo_comprobante_portugues'        => trim(strtoupper(strtolower($rowMSSQL00['tipo_comprobante_portugues']))),
                    'tipo_comprobante_path'             => trim(strtolower($rowMSSQL00['tipo_comprobante_path'])),
                    'tipo_comprobante_css'              => trim(strtolower($rowMSSQL00['tipo_comprobante_css'])),
                    'tipo_comprobante_icono'            => trim(strtolower($rowMSSQL00['tipo_comprobante_icono'])),
                    'tipo_comprobante_dominio'          => trim(strtoupper(strtolower($rowMSSQL00['tipo_comprobante_dominio']))),
                    'tipo_comprobante_observacion'      => trim(strtoupper(strtolower($rowMSSQL00['tipo_comprobante_observacion']))),

                    'tipo_mes_codigo'                   => $rowMSSQL00['tipo_mes_codigo'],
                    'tipo_mes_orden'                    => $rowMSSQL00['tipo_mes_orden'],
                    'tipo_mes_parametro'                => $rowMSSQL00['tipo_mes_parametro'],
                    'tipo_mes_ingles'                   => trim(strtoupper(strtolower($rowMSSQL00['tipo_mes_ingles']))),
                    'tipo_mes_castellano'               => trim(strtoupper(strtolower($rowMSSQL00['tipo_mes_castellano']))),
                    'tipo_mes_portugues'                => trim(strtoupper(strtolower($rowMSSQL00['tipo_mes_portugues']))),
                    'tipo_mes_path'                     => trim(strtolower($rowMSSQL00['tipo_mes_path'])),
                    'tipo_mes_css'                      => trim(strtolower($rowMSSQL00['tipo_mes_css'])),
                    'tipo_mes_icono'                    => trim(strtolower($rowMSSQL00['tipo_mes_icono'])),
                    'tipo_mes_dominio'                  => trim(strtoupper(strtolower($rowMSSQL00['tipo_mes_dominio']))),
                    'tipo_mes_observacion'              => trim(strtoupper(strtolower($rowMSSQL00['tipo_mes_observacion']))),

                    'tipo_gerencia_codigo'              => $rowMSSQL01['gerencia_codigo'],
                    'tipo_gerencia_nombre'              => trim(strtoupper(strtolower($rowMSSQL01['gerencia_nombre']))),

                    'tipo_departamento_codigo'          => $rowMSSQL01['departamento_codigo'],
                    'tipo_departamento_nombre'          => trim(strtoupper(strtolower($rowMSSQL01['departamento_nombre'])))
                );

                $result[]   = $detalle;
            }

            if (isset($result)){
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } else {
                $detalle    = array(
                    'comprobante_codigo'                => '',
                    'comprobante_codigo_barra'          => '',
                    'comprobante_periodo'               => '',
                    'comprobante_colaborador'           => '',
                    'comprobante_email'                 => '',
                    'comprobante_documento'             => '',
                    'comprobante_adjunto'               => '',
                    'comprobante_observacion'           => '',

                    'auditoria_usuario'                 => '',
                    'auditoria_fecha_hora'              => '',
                    'auditoria_ip'                      => '',

                    'tipo_estado_codigo'                => '',
                    'tipo_estado_orden'                 => '',
                    'tipo_estado_parametro'             => '',
                    'tipo_estado_ingles'                => '',
                    'tipo_estado_castellano'            => '',
                    'tipo_estado_portugues'             => '',
                    'tipo_estado_path'                  => '',
                    'tipo_estado_css'                   => '',
                    'tipo_estado_icono'                 => '',
                    'tipo_estado_dominio'               => '',
                    'tipo_estado_observacion'           => '',

                    'tipo_comprobante_codigo'           => '',
                    'tipo_comprobante_orden'            => '',
                    'tipo_comprobante_parametro'        => '',
                    'tipo_comprobante_ingles'           => '',
                    'tipo_comprobante_castellano'       => '',
                    'tipo_comprobante_portugues'        => '',
                    'tipo_comprobante_path'             => '',
                    'tipo_comprobante_css'              => '',
                    'tipo_comprobante_icono'            => '',
                    'tipo_comprobante_dominio'          => '',
                    'tipo_comprobante_observacion'      => '',

                    'tipo_mes_codigo'                   => '',
                    'tipo_mes_orden'                    => '',
                    'tipo_mes_parametro'                => '',
                    'tipo_mes_ingles'                   => '',
                    'tipo_mes_castellano'               => '',
                    'tipo_mes_portugues'                => '',
                    'tipo_mes_path'                     => '',
                    'tipo_mes_css'                      => '',
                    'tipo_mes_icono'                    => '',
                    'tipo_mes_dominio'                  => '',
                    'tipo_mes_observacion'              => '',

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

    $app->get('/v1/200/comprobante/codigobarra', function($request) {
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
            b.DOMFICORD         AS          tipo_estado_orden,
            b.DOMFICPAR         AS          tipo_estado_parametro,
            b.DOMFICNOI         AS          tipo_estado_ingles,
            b.DOMFICNOC         AS          tipo_estado_castellano,
            b.DOMFICNOP         AS          tipo_estado_portugues,
            b.DOMFICPAT         AS          tipo_estado_path,
            b.DOMFICCSS         AS          tipo_estado_css,
            b.DOMFICICO         AS          tipo_estado_icono,
            b.DOMFICVAL         AS          tipo_estado_dominio,
            b.DOMFICOBS         AS          tipo_estado_observacion,

            c.DOMFICCOD         AS          tipo_comprobante_codigo,
            c.DOMFICORD         AS          tipo_comprobante_orden,
            c.DOMFICPAR         AS          tipo_comprobante_parametro,
            c.DOMFICNOI         AS          tipo_comprobante_ingles,
            c.DOMFICNOC         AS          tipo_comprobante_castellano,
            c.DOMFICNOP         AS          tipo_comprobante_portugues,
            c.DOMFICPAT         AS          tipo_comprobante_path,
            c.DOMFICCSS         AS          tipo_comprobante_css,
            c.DOMFICICO         AS          tipo_comprobante_icono,
            c.DOMFICVAL         AS          tipo_comprobante_dominio,

            d.DOMFICCOD         AS          tipo_mes_codigo,
            d.DOMFICORD         AS          tipo_mes_orden,
            d.DOMFICPAR         AS          tipo_mes_parametro,
            d.DOMFICNOI         AS          tipo_mes_ingles,
            d.DOMFICNOC         AS          tipo_mes_castellano,
            d.DOMFICNOP         AS          tipo_mes_portugues,
            d.DOMFICPAT         AS          tipo_mes_path,
            d.DOMFICCSS         AS          tipo_mes_css,
            d.DOMFICICO         AS          tipo_mes_icono,
            d.DOMFICVAL         AS          tipo_mes_dominio

            FROM [hum].[COMFIC] a
            INNER JOIN [adm].[DOMFIC] b ON a.COMFICEST = b.DOMFICCOD
            INNER JOIN [adm].[DOMFIC] c ON a.COMFICTCC = c.DOMFICCOD
            INNER JOIN [adm].[DOMFIC] d ON a.COMFICTMC = d.DOMFICCOD

            WHERE (b.DOMFICVAL = 'COMPROBANTEESTADO' AND b.DOMFICPAR = 2)
            
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
            $connMSSQL  = getConnectionMSSQLv1();
            
            $stmtMSSQL00= $connMSSQL->prepare($sql00);
            $stmtMSSQL01= $connMSSQL->prepare($sql01);

            $stmtMSSQL00->execute([$val01]);

            while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                $nroDoc     = trim(strtoupper(strtolower($rowMSSQL00['comprobante_documento'])));
                $stmtMSSQL01->execute([$nroDoc]);
                $rowMSSQL01 = $stmtMSSQL01->fetch(PDO::FETCH_ASSOC);

                $periodo    = $rowMSSQL00['comprobante_periodo'];
                $mes        = $rowMSSQL00['tipo_mes_parametro'];
                $comprobante= $rowMSSQL00['tipo_comprobante_parametro'];

                if ($rowMSSQL00['tipo_mes_parametro'] > 0 && $rowMSSQL00['tipo_mes_parametro'] < 10){
                    $comprobante_codigo_barra = $nroDoc."'".$periodo.'-'.'0'.$mes."'".$comprobante;
                } else {
                    $comprobante_codigo_barra = $nroDoc."'".$periodo.'-'.$mes."'".$comprobante;
                }

                $detalle    = array(
                    'comprobante_codigo'                => $rowMSSQL00['comprobante_codigo'],
                    'comprobante_codigo_barra'          => trim(strtoupper(strtolower($comprobante_codigo_barra))),
                    'comprobante_periodo'               => $rowMSSQL00['comprobante_periodo'],
                    'comprobante_colaborador'           => trim(strtoupper(strtolower($rowMSSQL01['nombre_completo']))),
                    'comprobante_documento'             => trim(strtoupper(strtolower($rowMSSQL00['comprobante_documento']))),
                    'comprobante_adjunto'               => trim(strtolower($rowMSSQL00['comprobante_adjunto'])),
                    'comprobante_observacion'           => trim(strtoupper(strtolower($rowMSSQL00['comprobante_observacion']))),

                    'auditoria_usuario'                 => trim(strtoupper(strtolower($rowMSSQL01['auditoria_usuario']))),
                    'auditoria_fecha_hora'              => date("d/m/Y", strtotime($rowMSSQL01['auditoria_fecha_hora'])),
                    'auditoria_ip'                      => trim(strtoupper(strtolower($rowMSSQL01['auditoria_ip']))),

                    'tipo_estado_codigo'                => $rowMSSQL00['tipo_estado_codigo'],
                    'tipo_estado_orden'                 => $rowMSSQL00['tipo_estado_orden'],
                    'tipo_estado_parametro'             => $rowMSSQL00['tipo_estado_parametro'],
                    'tipo_estado_ingles'                => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_ingles']))),
                    'tipo_estado_castellano'            => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_castellano']))),
                    'tipo_estado_portugues'             => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_portugues']))),
                    'tipo_estado_path'                  => trim(strtolower($rowMSSQL00['tipo_estado_path'])),
                    'tipo_estado_css'                   => trim(strtolower($rowMSSQL00['tipo_estado_css'])),
                    'tipo_estado_icono'                 => trim(strtolower($rowMSSQL00['tipo_estado_icono'])),
                    'tipo_estado_dominio'               => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_dominio']))),
                    'tipo_estado_observacion'           => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_observacion']))),

                    'tipo_comprobante_codigo'           => $rowMSSQL00['tipo_comprobante_codigo'],
                    'tipo_comprobante_orden'            => $rowMSSQL00['tipo_comprobante_orden'],
                    'tipo_comprobante_parametro'        => $rowMSSQL00['tipo_comprobante_parametro'],
                    'tipo_comprobante_ingles'           => trim(strtoupper(strtolower($rowMSSQL00['tipo_comprobante_ingles']))),
                    'tipo_comprobante_castellano'       => trim(strtoupper(strtolower($rowMSSQL00['tipo_comprobante_castellano']))),
                    'tipo_comprobante_portugues'        => trim(strtoupper(strtolower($rowMSSQL00['tipo_comprobante_portugues']))),
                    'tipo_comprobante_path'             => trim(strtolower($rowMSSQL00['tipo_comprobante_path'])),
                    'tipo_comprobante_css'              => trim(strtolower($rowMSSQL00['tipo_comprobante_css'])),
                    'tipo_comprobante_icono'            => trim(strtolower($rowMSSQL00['tipo_comprobante_icono'])),
                    'tipo_comprobante_dominio'          => trim(strtoupper(strtolower($rowMSSQL00['tipo_comprobante_dominio']))),
                    'tipo_comprobante_observacion'      => trim(strtoupper(strtolower($rowMSSQL00['tipo_comprobante_observacion']))),

                    'tipo_mes_codigo'                   => $rowMSSQL00['tipo_mes_codigo'],
                    'tipo_mes_orden'                    => $rowMSSQL00['tipo_mes_orden'],
                    'tipo_mes_parametro'                => $rowMSSQL00['tipo_mes_parametro'],
                    'tipo_mes_ingles'                   => trim(strtoupper(strtolower($rowMSSQL00['tipo_mes_ingles']))),
                    'tipo_mes_castellano'               => trim(strtoupper(strtolower($rowMSSQL00['tipo_mes_castellano']))),
                    'tipo_mes_portugues'                => trim(strtoupper(strtolower($rowMSSQL00['tipo_mes_portugues']))),
                    'tipo_mes_path'                     => trim(strtolower($rowMSSQL00['tipo_mes_path'])),
                    'tipo_mes_css'                      => trim(strtolower($rowMSSQL00['tipo_mes_css'])),
                    'tipo_mes_icono'                    => trim(strtolower($rowMSSQL00['tipo_mes_icono'])),
                    'tipo_mes_dominio'                  => trim(strtoupper(strtolower($rowMSSQL00['tipo_mes_dominio']))),
                    'tipo_mes_observacion'              => trim(strtoupper(strtolower($rowMSSQL00['tipo_mes_observacion']))),

                    'tipo_gerencia_codigo'              => $rowMSSQL01['gerencia_codigo'],
                    'tipo_gerencia_nombre'              => trim(strtoupper(strtolower($rowMSSQL01['gerencia_nombre']))),

                    'tipo_departamento_codigo'          => $rowMSSQL01['departamento_codigo'],
                    'tipo_departamento_nombre'          => trim(strtoupper(strtolower($rowMSSQL01['departamento_nombre'])))
                );

                $result[]   = $detalle;
            }

            if (isset($result)){
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } else {
                $detalle    = array(
                    'comprobante_codigo'                => '',
                    'comprobante_codigo_barra'          => '',
                    'comprobante_periodo'               => '',
                    'comprobante_colaborador'           => '',
                    'comprobante_documento'             => '',
                    'comprobante_adjunto'               => '',
                    'comprobante_observacion'           => '',

                    'auditoria_usuario'                 => '',
                    'auditoria_fecha_hora'              => '',
                    'auditoria_ip'                      => '',

                    'tipo_estado_codigo'                => '',
                    'tipo_estado_orden'                 => '',
                    'tipo_estado_parametro'             => '',
                    'tipo_estado_ingles'                => '',
                    'tipo_estado_castellano'            => '',
                    'tipo_estado_portugues'             => '',
                    'tipo_estado_path'                  => '',
                    'tipo_estado_css'                   => '',
                    'tipo_estado_icono'                 => '',
                    'tipo_estado_dominio'               => '',
                    'tipo_estado_observacion'           => '',

                    'tipo_comprobante_codigo'           => '',
                    'tipo_comprobante_orden'            => '',
                    'tipo_comprobante_parametro'        => '',
                    'tipo_comprobante_ingles'           => '',
                    'tipo_comprobante_castellano'       => '',
                    'tipo_comprobante_portugues'        => '',
                    'tipo_comprobante_path'             => '',
                    'tipo_comprobante_css'              => '',
                    'tipo_comprobante_icono'            => '',
                    'tipo_comprobante_dominio'          => '',
                    'tipo_comprobante_observacion'      => '',

                    'tipo_mes_codigo'                   => '',
                    'tipo_mes_orden'                    => '',
                    'tipo_mes_parametro'                => '',
                    'tipo_mes_ingles'                   => '',
                    'tipo_mes_castellano'               => '',
                    'tipo_mes_portugues'                => '',
                    'tipo_mes_path'                     => '',
                    'tipo_mes_css'                      => '',
                    'tipo_mes_icono'                    => '',
                    'tipo_mes_dominio'                  => '',
                    'tipo_mes_observacion'              => '',

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

    $app->get('/v1/200/comprobante/periodo/{comprobante}/{periodo}/{mesdesde}/{meshasta}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01  = $request->getAttribute('comprobante');
        $val02  = $request->getAttribute('periodo');
        $val03  = $request->getAttribute('mesdesde');
        $val04  = $request->getAttribute('meshasta');
        
        if (isset($val01) && isset($val02) && isset($val03) && isset($val04)) {
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
                b.DOMFICORD         AS          tipo_estado_orden,
                b.DOMFICPAR         AS          tipo_estado_parametro,
                b.DOMFICNOI         AS          tipo_estado_ingles,
                b.DOMFICNOC         AS          tipo_estado_castellano,
                b.DOMFICNOP         AS          tipo_estado_portugues,
                b.DOMFICPAT         AS          tipo_estado_path,
                b.DOMFICCSS         AS          tipo_estado_css,
                b.DOMFICICO         AS          tipo_estado_icono,
                b.DOMFICVAL         AS          tipo_estado_dominio,
                b.DOMFICOBS         AS          tipo_estado_observacion,

                c.DOMFICCOD         AS          tipo_comprobante_codigo,
                c.DOMFICORD         AS          tipo_comprobante_orden,
                c.DOMFICPAR         AS          tipo_comprobante_parametro,
                c.DOMFICNOI         AS          tipo_comprobante_ingles,
                c.DOMFICNOC         AS          tipo_comprobante_castellano,
                c.DOMFICNOP         AS          tipo_comprobante_portugues,
                c.DOMFICPAT         AS          tipo_comprobante_path,
                c.DOMFICCSS         AS          tipo_comprobante_css,
                c.DOMFICICO         AS          tipo_comprobante_icono,
                c.DOMFICVAL         AS          tipo_comprobante_dominio,

                d.DOMFICCOD         AS          tipo_mes_codigo,
                d.DOMFICORD         AS          tipo_mes_orden,
                d.DOMFICPAR         AS          tipo_mes_parametro,
                d.DOMFICNOI         AS          tipo_mes_ingles,
                d.DOMFICNOC         AS          tipo_mes_castellano,
                d.DOMFICNOP         AS          tipo_mes_portugues,
                d.DOMFICPAT         AS          tipo_mes_path,
                d.DOMFICCSS         AS          tipo_mes_css,
                d.DOMFICICO         AS          tipo_mes_icono,
                d.DOMFICVAL         AS          tipo_mes_dominio

                FROM [hum].[COMFIC] a
                INNER JOIN [adm].[DOMFIC] b ON a.COMFICEST = b.DOMFICCOD
                INNER JOIN [adm].[DOMFIC] c ON a.COMFICTCC = c.DOMFICCOD
                INNER JOIN [adm].[DOMFIC] d ON a.COMFICTMC = d.DOMFICCOD

                WHERE a.COMFICTCC = ? AND a.COMFICPER = ? AND d.DOMFICPAR >= (SELECT e1.DOMFICPAR FROM adm.DOMFIC e1 WHERE e1.DOMFICCOD = ?) AND d.DOMFICPAR <= (SELECT e2.DOMFICPAR FROM adm.DOMFIC e2 WHERE e2.DOMFICCOD = ?)
                
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
                $connMSSQL  = getConnectionMSSQLv1();
                
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL01= $connMSSQL->prepare($sql01);

                $stmtMSSQL00->execute([$val01, $val02, $val03, $val04]);

                while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                    $nroDoc     = trim(strtoupper(strtolower($rowMSSQL00['comprobante_documento'])));
                    $stmtMSSQL01->execute([$nroDoc]);
                    $rowMSSQL01 = $stmtMSSQL01->fetch(PDO::FETCH_ASSOC);

                    $periodo    = $rowMSSQL00['comprobante_periodo'];
                    $mes        = $rowMSSQL00['tipo_mes_parametro'];
                    $comprobante= $rowMSSQL00['tipo_comprobante_parametro'];

                    if ($rowMSSQL00['tipo_mes_parametro'] > 0 && $rowMSSQL00['tipo_mes_parametro'] < 10){
                        $comprobante_codigo_barra = $nroDoc."'".$periodo.'-'.'0'.$mes."'".$comprobante;
                    } else {
                        $comprobante_codigo_barra = $nroDoc."'".$periodo.'-'.$mes."'".$comprobante;
                    }

                    $detalle    = array(
                        'comprobante_codigo'                => $rowMSSQL00['comprobante_codigo'],
                        'comprobante_codigo_barra'          => trim(strtoupper(strtolower($comprobante_codigo_barra))),
                        'comprobante_periodo'               => $rowMSSQL00['comprobante_periodo'],
                        'comprobante_colaborador'           => trim(strtoupper(strtolower($rowMSSQL01['nombre_completo']))),
                        'comprobante_documento'             => trim(strtoupper(strtolower($rowMSSQL00['comprobante_documento']))),
                        'comprobante_adjunto'               => trim(strtolower($rowMSSQL00['comprobante_adjunto'])),
                        'comprobante_observacion'           => trim(strtoupper(strtolower($rowMSSQL00['comprobante_observacion']))),

                        'auditoria_usuario'                 => trim(strtoupper(strtolower($rowMSSQL01['auditoria_usuario']))),
                        'auditoria_fecha_hora'              => date("d/m/Y", strtotime($rowMSSQL01['auditoria_fecha_hora'])),
                        'auditoria_ip'                      => trim(strtoupper(strtolower($rowMSSQL01['auditoria_ip']))),

                        'tipo_estado_codigo'                => $rowMSSQL00['tipo_estado_codigo'],
                        'tipo_estado_orden'                 => $rowMSSQL00['tipo_estado_orden'],
                        'tipo_estado_parametro'             => $rowMSSQL00['tipo_estado_parametro'],
                        'tipo_estado_ingles'                => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_ingles']))),
                        'tipo_estado_castellano'            => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_castellano']))),
                        'tipo_estado_portugues'             => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_portugues']))),
                        'tipo_estado_path'                  => trim(strtolower($rowMSSQL00['tipo_estado_path'])),
                        'tipo_estado_css'                   => trim(strtolower($rowMSSQL00['tipo_estado_css'])),
                        'tipo_estado_icono'                 => trim(strtolower($rowMSSQL00['tipo_estado_icono'])),
                        'tipo_estado_dominio'               => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_dominio']))),
                        'tipo_estado_observacion'           => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_observacion']))),

                        'tipo_comprobante_codigo'           => $rowMSSQL00['tipo_comprobante_codigo'],
                        'tipo_comprobante_orden'            => $rowMSSQL00['tipo_comprobante_orden'],
                        'tipo_comprobante_parametro'        => $rowMSSQL00['tipo_comprobante_parametro'],
                        'tipo_comprobante_ingles'           => trim(strtoupper(strtolower($rowMSSQL00['tipo_comprobante_ingles']))),
                        'tipo_comprobante_castellano'       => trim(strtoupper(strtolower($rowMSSQL00['tipo_comprobante_castellano']))),
                        'tipo_comprobante_portugues'        => trim(strtoupper(strtolower($rowMSSQL00['tipo_comprobante_portugues']))),
                        'tipo_comprobante_path'             => trim(strtolower($rowMSSQL00['tipo_comprobante_path'])),
                        'tipo_comprobante_css'              => trim(strtolower($rowMSSQL00['tipo_comprobante_css'])),
                        'tipo_comprobante_icono'            => trim(strtolower($rowMSSQL00['tipo_comprobante_icono'])),
                        'tipo_comprobante_dominio'          => trim(strtoupper(strtolower($rowMSSQL00['tipo_comprobante_dominio']))),
                        'tipo_comprobante_observacion'      => trim(strtoupper(strtolower($rowMSSQL00['tipo_comprobante_observacion']))),

                        'tipo_mes_codigo'                   => $rowMSSQL00['tipo_mes_codigo'],
                        'tipo_mes_orden'                    => $rowMSSQL00['tipo_mes_orden'],
                        'tipo_mes_parametro'                => $rowMSSQL00['tipo_mes_parametro'],
                        'tipo_mes_ingles'                   => trim(strtoupper(strtolower($rowMSSQL00['tipo_mes_ingles']))),
                        'tipo_mes_castellano'               => trim(strtoupper(strtolower($rowMSSQL00['tipo_mes_castellano']))),
                        'tipo_mes_portugues'                => trim(strtoupper(strtolower($rowMSSQL00['tipo_mes_portugues']))),
                        'tipo_mes_path'                     => trim(strtolower($rowMSSQL00['tipo_mes_path'])),
                        'tipo_mes_css'                      => trim(strtolower($rowMSSQL00['tipo_mes_css'])),
                        'tipo_mes_icono'                    => trim(strtolower($rowMSSQL00['tipo_mes_icono'])),
                        'tipo_mes_dominio'                  => trim(strtoupper(strtolower($rowMSSQL00['tipo_mes_dominio']))),
                        'tipo_mes_observacion'              => trim(strtoupper(strtolower($rowMSSQL00['tipo_mes_observacion']))),

                        'tipo_gerencia_codigo'              => $rowMSSQL01['gerencia_codigo'],
                        'tipo_gerencia_nombre'              => trim(strtoupper(strtolower($rowMSSQL01['gerencia_nombre']))),

                        'tipo_departamento_codigo'          => $rowMSSQL01['departamento_codigo'],
                        'tipo_departamento_nombre'          => trim(strtoupper(strtolower($rowMSSQL01['departamento_nombre'])))
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle    = array(
                        'comprobante_codigo'                => '',
                        'comprobante_codigo_barra'          => '',
                        'comprobante_periodo'               => '',
                        'comprobante_colaborador'           => '',
                        'comprobante_documento'             => '',
                        'comprobante_adjunto'               => '',
                        'comprobante_observacion'           => '',

                        'auditoria_usuario'                 => '',
                        'auditoria_fecha_hora'              => '',
                        'auditoria_ip'                      => '',

                        'tipo_estado_codigo'                => '',
                        'tipo_estado_orden'                 => '',
                        'tipo_estado_parametro'             => '',
                        'tipo_estado_ingles'                => '',
                        'tipo_estado_castellano'            => '',
                        'tipo_estado_portugues'             => '',
                        'tipo_estado_path'                  => '',
                        'tipo_estado_css'                   => '',
                        'tipo_estado_icono'                 => '',
                        'tipo_estado_dominio'               => '',
                        'tipo_estado_observacion'           => '',

                        'tipo_comprobante_codigo'           => '',
                        'tipo_comprobante_orden'            => '',
                        'tipo_comprobante_parametro'        => '',
                        'tipo_comprobante_ingles'           => '',
                        'tipo_comprobante_castellano'       => '',
                        'tipo_comprobante_portugues'        => '',
                        'tipo_comprobante_path'             => '',
                        'tipo_comprobante_css'              => '',
                        'tipo_comprobante_icono'            => '',
                        'tipo_comprobante_dominio'          => '',
                        'tipo_comprobante_observacion'      => '',

                        'tipo_mes_codigo'                   => '',
                        'tipo_mes_orden'                    => '',
                        'tipo_mes_parametro'                => '',
                        'tipo_mes_ingles'                   => '',
                        'tipo_mes_castellano'               => '',
                        'tipo_mes_portugues'                => '',
                        'tipo_mes_path'                     => '',
                        'tipo_mes_css'                      => '',
                        'tipo_mes_icono'                    => '',
                        'tipo_mes_dominio'                  => '',
                        'tipo_mes_observacion'              => '',

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
        }  else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v1/200/comprobante/documento/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val01  = $request->getAttribute('codigo');
        
        if (isset($val01)) {
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
                b.DOMFICORD         AS          tipo_estado_orden,
                b.DOMFICPAR         AS          tipo_estado_parametro,
                b.DOMFICNOI         AS          tipo_estado_ingles,
                b.DOMFICNOC         AS          tipo_estado_castellano,
                b.DOMFICNOP         AS          tipo_estado_portugues,
                b.DOMFICPAT         AS          tipo_estado_path,
                b.DOMFICCSS         AS          tipo_estado_css,
                b.DOMFICICO         AS          tipo_estado_icono,
                b.DOMFICVAL         AS          tipo_estado_dominio,
                b.DOMFICOBS         AS          tipo_estado_observacion,

                c.DOMFICCOD         AS          tipo_comprobante_codigo,
                c.DOMFICORD         AS          tipo_comprobante_orden,
                c.DOMFICPAR         AS          tipo_comprobante_parametro,
                c.DOMFICNOI         AS          tipo_comprobante_ingles,
                c.DOMFICNOC         AS          tipo_comprobante_castellano,
                c.DOMFICNOP         AS          tipo_comprobante_portugues,
                c.DOMFICPAT         AS          tipo_comprobante_path,
                c.DOMFICCSS         AS          tipo_comprobante_css,
                c.DOMFICICO         AS          tipo_comprobante_icono,
                c.DOMFICVAL         AS          tipo_comprobante_dominio,

                d.DOMFICCOD         AS          tipo_mes_codigo,
                d.DOMFICORD         AS          tipo_mes_orden,
                d.DOMFICPAR         AS          tipo_mes_parametro,
                d.DOMFICNOI         AS          tipo_mes_ingles,
                d.DOMFICNOC         AS          tipo_mes_castellano,
                d.DOMFICNOP         AS          tipo_mes_portugues,
                d.DOMFICPAT         AS          tipo_mes_path,
                d.DOMFICCSS         AS          tipo_mes_css,
                d.DOMFICICO         AS          tipo_mes_icono,
                d.DOMFICVAL         AS          tipo_mes_dominio

                FROM [hum].[COMFIC] a
                INNER JOIN [adm].[DOMFIC] b ON a.COMFICEST = b.DOMFICCOD
                INNER JOIN [adm].[DOMFIC] c ON a.COMFICTCC = c.DOMFICCOD
                INNER JOIN [adm].[DOMFIC] d ON a.COMFICTMC = d.DOMFICCOD

                WHERE a.COMFICDOC = ?
                
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
                $connMSSQL  = getConnectionMSSQLv1();
                
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL01= $connMSSQL->prepare($sql01);

                $stmtMSSQL00->execute([$val01]);

                while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                    $nroDoc     = trim(strtoupper(strtolower($rowMSSQL00['comprobante_documento'])));
                    $stmtMSSQL01->execute([$nroDoc]);
                    $rowMSSQL01 = $stmtMSSQL01->fetch(PDO::FETCH_ASSOC);

                    $periodo    = $rowMSSQL00['comprobante_periodo'];
                    $mes        = $rowMSSQL00['tipo_mes_parametro'];
                    $comprobante= $rowMSSQL00['tipo_comprobante_parametro'];

                    if ($rowMSSQL00['tipo_mes_parametro'] > 0 && $rowMSSQL00['tipo_mes_parametro'] < 10){
                        $comprobante_codigo_barra = $nroDoc."'".$periodo.'-'.'0'.$mes."'".$comprobante;
                    } else {
                        $comprobante_codigo_barra = $nroDoc."'".$periodo.'-'.$mes."'".$comprobante;
                    }

                    $detalle    = array(
                        'comprobante_codigo'                => $rowMSSQL00['comprobante_codigo'],
                        'comprobante_codigo_barra'          => trim(strtoupper(strtolower($comprobante_codigo_barra))),
                        'comprobante_periodo'               => $rowMSSQL00['comprobante_periodo'],
                        'comprobante_colaborador'           => trim(strtoupper(strtolower($rowMSSQL01['nombre_completo']))),
                        'comprobante_documento'             => trim(strtoupper(strtolower($rowMSSQL00['comprobante_documento']))),
                        'comprobante_adjunto'               => trim(strtolower($rowMSSQL00['comprobante_adjunto'])),
                        'comprobante_observacion'           => trim(strtoupper(strtolower($rowMSSQL00['comprobante_observacion']))),

                        'auditoria_usuario'                 => trim(strtoupper(strtolower($rowMSSQL01['auditoria_usuario']))),
                        'auditoria_fecha_hora'              => date("d/m/Y", strtotime($rowMSSQL01['auditoria_fecha_hora'])),
                        'auditoria_ip'                      => trim(strtoupper(strtolower($rowMSSQL01['auditoria_ip']))),

                        'tipo_estado_codigo'                => $rowMSSQL00['tipo_estado_codigo'],
                        'tipo_estado_orden'                 => $rowMSSQL00['tipo_estado_orden'],
                        'tipo_estado_parametro'             => $rowMSSQL00['tipo_estado_parametro'],
                        'tipo_estado_ingles'                => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_ingles']))),
                        'tipo_estado_castellano'            => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_castellano']))),
                        'tipo_estado_portugues'             => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_portugues']))),
                        'tipo_estado_path'                  => trim(strtolower($rowMSSQL00['tipo_estado_path'])),
                        'tipo_estado_css'                   => trim(strtolower($rowMSSQL00['tipo_estado_css'])),
                        'tipo_estado_icono'                 => trim(strtolower($rowMSSQL00['tipo_estado_icono'])),
                        'tipo_estado_dominio'               => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_dominio']))),
                        'tipo_estado_observacion'           => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_observacion']))),

                        'tipo_comprobante_codigo'           => $rowMSSQL00['tipo_comprobante_codigo'],
                        'tipo_comprobante_orden'            => $rowMSSQL00['tipo_comprobante_orden'],
                        'tipo_comprobante_parametro'        => $rowMSSQL00['tipo_comprobante_parametro'],
                        'tipo_comprobante_ingles'           => trim(strtoupper(strtolower($rowMSSQL00['tipo_comprobante_ingles']))),
                        'tipo_comprobante_castellano'       => trim(strtoupper(strtolower($rowMSSQL00['tipo_comprobante_castellano']))),
                        'tipo_comprobante_portugues'        => trim(strtoupper(strtolower($rowMSSQL00['tipo_comprobante_portugues']))),
                        'tipo_comprobante_path'             => trim(strtolower($rowMSSQL00['tipo_comprobante_path'])),
                        'tipo_comprobante_css'              => trim(strtolower($rowMSSQL00['tipo_comprobante_css'])),
                        'tipo_comprobante_icono'            => trim(strtolower($rowMSSQL00['tipo_comprobante_icono'])),
                        'tipo_comprobante_dominio'          => trim(strtoupper(strtolower($rowMSSQL00['tipo_comprobante_dominio']))),
                        'tipo_comprobante_observacion'      => trim(strtoupper(strtolower($rowMSSQL00['tipo_comprobante_observacion']))),

                        'tipo_mes_codigo'                   => $rowMSSQL00['tipo_mes_codigo'],
                        'tipo_mes_orden'                    => $rowMSSQL00['tipo_mes_orden'],
                        'tipo_mes_parametro'                => $rowMSSQL00['tipo_mes_parametro'],
                        'tipo_mes_ingles'                   => trim(strtoupper(strtolower($rowMSSQL00['tipo_mes_ingles']))),
                        'tipo_mes_castellano'               => trim(strtoupper(strtolower($rowMSSQL00['tipo_mes_castellano']))),
                        'tipo_mes_portugues'                => trim(strtoupper(strtolower($rowMSSQL00['tipo_mes_portugues']))),
                        'tipo_mes_path'                     => trim(strtolower($rowMSSQL00['tipo_mes_path'])),
                        'tipo_mes_css'                      => trim(strtolower($rowMSSQL00['tipo_mes_css'])),
                        'tipo_mes_icono'                    => trim(strtolower($rowMSSQL00['tipo_mes_icono'])),
                        'tipo_mes_dominio'                  => trim(strtoupper(strtolower($rowMSSQL00['tipo_mes_dominio']))),
                        'tipo_mes_observacion'              => trim(strtoupper(strtolower($rowMSSQL00['tipo_mes_observacion']))),

                        'tipo_gerencia_codigo'              => $rowMSSQL01['gerencia_codigo'],
                        'tipo_gerencia_nombre'              => trim(strtoupper(strtolower($rowMSSQL01['gerencia_nombre']))),

                        'tipo_departamento_codigo'          => $rowMSSQL01['departamento_codigo'],
                        'tipo_departamento_nombre'          => trim(strtoupper(strtolower($rowMSSQL01['departamento_nombre'])))
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle    = array(
                        'comprobante_codigo'                => '',
                        'comprobante_codigo_barra'          => '',
                        'comprobante_periodo'               => '',
                        'comprobante_colaborador'           => '',
                        'comprobante_documento'             => '',
                        'comprobante_adjunto'               => '',
                        'comprobante_observacion'           => '',

                        'auditoria_usuario'                 => '',
                        'auditoria_fecha_hora'              => '',
                        'auditoria_ip'                      => '',

                        'tipo_estado_codigo'                => '',
                        'tipo_estado_orden'                 => '',
                        'tipo_estado_parametro'             => '',
                        'tipo_estado_ingles'                => '',
                        'tipo_estado_castellano'            => '',
                        'tipo_estado_portugues'             => '',
                        'tipo_estado_path'                  => '',
                        'tipo_estado_css'                   => '',
                        'tipo_estado_icono'                 => '',
                        'tipo_estado_dominio'               => '',
                        'tipo_estado_observacion'           => '',

                        'tipo_comprobante_codigo'           => '',
                        'tipo_comprobante_orden'            => '',
                        'tipo_comprobante_parametro'        => '',
                        'tipo_comprobante_ingles'           => '',
                        'tipo_comprobante_castellano'       => '',
                        'tipo_comprobante_portugues'        => '',
                        'tipo_comprobante_path'             => '',
                        'tipo_comprobante_css'              => '',
                        'tipo_comprobante_icono'            => '',
                        'tipo_comprobante_dominio'          => '',
                        'tipo_comprobante_observacion'      => '',

                        'tipo_mes_codigo'                   => '',
                        'tipo_mes_orden'                    => '',
                        'tipo_mes_parametro'                => '',
                        'tipo_mes_ingles'                   => '',
                        'tipo_mes_castellano'               => '',
                        'tipo_mes_portugues'                => '',
                        'tipo_mes_path'                     => '',
                        'tipo_mes_css'                      => '',
                        'tipo_mes_icono'                    => '',
                        'tipo_mes_dominio'                  => '',
                        'tipo_mes_observacion'              => '',

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
        }  else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v1/200/tarjetapersonal/listado', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $sql00  = "SELECT 
            a.TPEFICCOD         AS          tarjeta_personal_codigo,	
            a.TPEFICORD         AS          tarjeta_personal_orden,  
            a.TPEFICDNU         AS          tarjeta_personal_documento, 
            a.TPEFICEMA         AS          tarjeta_personal_email,
            a.TPEFICNOV         AS          tarjeta_personal_nombre_visualizar,
            a.TPEFICAPV         AS          tarjeta_personal_apellido_visualizar,
            h.PRIMERNOMBRE      AS          tarjeta_personal_nombre1,
            h.SEGUNDONOMBRE     AS          tarjeta_personal_nombre2,   
            h.APELLIDOPATERNO   AS          tarjeta_personal_apellido1,
            h.APELLIDOMATERNO   AS          tarjeta_personal_apellido2,
            h.FECHANACIMIENTO   AS          tarjeta_personal_fecha_nacimiento,
            a.TPEFICOBS         AS          tarjeta_personal_observacion,
                
            a.TPEFICAUS         AS          auditoria_usuario,         	        
            a.TPEFICAFH         AS          auditoria_fecha_hora,	
            a.TPEFICAIP         AS          auditoria_ip,
            
            b.DOMFICCOD         AS          tipo_estado_codigo,
            b.DOMFICORD         AS          tipo_estado_orden,
            b.DOMFICNOI         AS          tipo_estado_ingles,
            b.DOMFICNOC         AS          tipo_estado_castellano,
            b.DOMFICNOP         AS          tipo_estado_portugues,
            b.DOMFICPAT         AS          tipo_estado_path,
            b.DOMFICCSS         AS          tipo_estado_css,
            b.DOMFICPAR         AS          tipo_estado_parametro,
            b.DOMFICICO         AS          tipo_estado_icono,
            b.DOMFICVAL         AS          tipo_estado_dominio,
            b.DOMFICOBS         AS          tipo_estado_observacion,
            
            c.DOMFICCOD         AS          tipo_cantidad_codigo,
            c.DOMFICORD         AS          tipo_cantidad_orden,
            c.DOMFICNOI         AS          tipo_cantidad_ingles,
            c.DOMFICNOC         AS          tipo_cantidad_castellano,
            c.DOMFICNOP         AS          tipo_cantidad_portugues,
            c.DOMFICPAT         AS          tipo_cantidad_path,
            c.DOMFICCSS         AS          tipo_cantidad_css,
            c.DOMFICPAR         AS          tipo_cantidad_parametro,
            c.DOMFICICO         AS          tipo_cantidad_icono,
            c.DOMFICVAL         AS          tipo_cantidad_dominio,
            c.DOMFICOBS         AS          tipo_cantidad_observacion,
            
            d.CODE              AS          tipo_gerencia_codigo,
            d.NAME              AS          tipo_gerencia_codigo_nombre,
            d.U_CODIGO          AS          tipo_gerencia_codigo_referencia,
            d.U_NOMBRE          AS          tipo_gerencia_nombre,
            
            e.CODE              AS          tipo_departamento_codigo,
            e.NAME              AS          tipo_departamento_codigo_nombre,
            e.U_CODIGO          AS          tipo_departamento_codigo_referencia,
            e.U_NOMBRE          AS          tipo_departamento_nombre,
            
            f.CODE              AS          tipo_jefatura_codigo,
            f.NAME              AS          tipo_jefatura_codigo_nombre,
            f.U_CODIGO          AS          tipo_jefatura_codigo_referencia,
            f.U_NOMBRE          AS          tipo_jefatura_nombre,
            
            g.CODE              AS          tipo_cargo_codigo,
            g.NAME              AS          tipo_cargo_codigo_nombre,
            g.U_CODIGO          AS          tipo_cargo_codigo_referencia,
            g.U_NOMBRE          AS          tipo_cargo_nombre
            
            FROM [hum].TPEFIC a
            LEFT OUTER JOIN [adm].DOMFIC b ON a.TPEFICEST = b.DOMFICCOD
            LEFT OUTER JOIN [adm].DOMFIC c ON a.TPEFICCNC = c.DOMFICCOD
            LEFT OUTER JOIN [CSF].[dbo].[@A1A_TIGE] d ON a.TPEFICGEC = d.U_CODIGO
            LEFT OUTER JOIN [CSF].[dbo].[@A1A_TIDE] e ON a.TPEFICDEC = e.U_CODIGO
            LEFT OUTER JOIN [CSF].[dbo].[@A1A_TICA] f ON a.TPEFICJEC = f.U_CODIGO
            LEFT OUTER JOIN [CSF].[dbo].[@A1A_TICA] g ON a.TPEFICCAC = g.U_CODIGO
            LEFT OUTER JOIN [CSF].[dbo].[empleados_AxisONE] h ON a.TPEFICDNU COLLATE SQL_Latin1_General_CP1_CI_AS = h.CedulaEmpleado
            
            ORDER BY a.TPEFICCOD DESC";

        try {
            $connMSSQL  = getConnectionMSSQLv1();

            $stmtMSSQL00= $connMSSQL->prepare($sql00);
            $stmtMSSQL00->execute();
            
            while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                if ($rowMSSQL00['tarjeta_personal_fecha_nacimiento'] == '1900-01-01' || $rowMSSQL00['tarjeta_personal_fecha_nacimiento'] == null){
                    $tarjeta_personal_fecha_nacimiento_1 = '';
                    $tarjeta_personal_fecha_nacimiento_2 = '';
                } else {
                    $tarjeta_personal_fecha_nacimiento_1 = $rowMSSQL00['tarjeta_personal_fecha_nacimiento'];
                    $tarjeta_personal_fecha_nacimiento_2 = date('d/m/Y', strtotime($rowMSSQL00['tarjeta_personal_fecha_nacimiento']));
                }

                if ($rowMSSQL00['tarjeta_personal_nombre_visualizar'] == 'P'){
                    $tarjeta_personal_nombre = trim($rowMSSQL00['tarjeta_personal_nombre1']);
                } else {
                    $tarjeta_personal_nombre = trim($rowMSSQL00['tarjeta_personal_nombre2']);
                }

                if ($rowMSSQL00['tarjeta_personal_apellido_visualizar'] == 'P'){
                    $tarjeta_personal_nombre = $tarjeta_personal_nombre.' '.trim($rowMSSQL00['tarjeta_personal_apellido1']);
                } else {
                    $tarjeta_personal_nombre = $tarjeta_personal_nombre.' '.trim($rowMSSQL00['tarjeta_personal_apellido2']);
                }

                $detalle    = array(
                    'tarjeta_personal_codigo'                   => $rowMSSQL00['tarjeta_personal_codigo'],
                    'tarjeta_personal_orden'                    => $rowMSSQL00['tarjeta_personal_orden'],
                    'tarjeta_personal_documento'                => trim(strtoupper(strtolower($rowMSSQL00['tarjeta_personal_documento']))),
                    'tarjeta_personal_email'                    => trim(strtolower($rowMSSQL00['tarjeta_personal_email'])),
                    'tarjeta_personal_nombre_visualizar'        => trim(strtoupper(strtolower($rowMSSQL00['tarjeta_personal_nombre_visualizar']))),
                    'tarjeta_personal_apellido_visualizar'      => trim(strtoupper(strtolower($rowMSSQL00['tarjeta_personal_apellido_visualizar']))),
                    'tarjeta_personal_nombre'                   => $tarjeta_personal_nombre,
                    'tarjeta_personal_nombre1'                  => trim($rowMSSQL00['tarjeta_personal_nombre1']),
                    'tarjeta_personal_nombre2'                  => trim($rowMSSQL00['tarjeta_personal_nombre2']),
                    'tarjeta_personal_apellido1'                => trim($rowMSSQL00['tarjeta_personal_apellido1']),
                    'tarjeta_personal_apellido2'                => trim($rowMSSQL00['tarjeta_personal_apellido2']),
                    'tarjeta_personal_fecha_nacimiento_1'       => $tarjeta_personal_fecha_nacimiento_1,
                    'tarjeta_personal_fecha_nacimiento_2'       => $tarjeta_personal_fecha_nacimiento_2,
                    'tarjeta_personal_observacion'              => trim($rowMSSQL00['tarjeta_personal_observacion']),
                    
                    'auditoria_usuario'                         => trim($rowMSSQL00['auditoria_usuario']),
                    'auditoria_fecha_hora'                      => $rowMSSQL00['auditoria_fecha_hora'],
                    'auditoria_ip'                              => trim($rowMSSQL00['auditoria_ip']),

                    'tipo_estado_codigo'                        => $rowMSSQL00['tipo_estado_codigo'],
                    'tipo_estado_orden'                         => $rowMSSQL00['tipo_estado_orden'],
                    'tipo_estado_ingles'                        => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_ingles']))),
                    'tipo_estado_castellano'                    => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_castellano']))),
                    'tipo_estado_portugues'                     => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_portugues']))),
                    'tipo_estado_parametro'                     => $rowMSSQL00['tipo_estado_parametro'],
                    'tipo_estado_icono'                         => trim(strtolower($rowMSSQL00['tipo_estado_icono'])),
                    'tipo_estado_path'                          => trim(strtolower($rowMSSQL00['tipo_estado_path'])),
                    'tipo_estado_css'                           => trim(strtolower($rowMSSQL00['tipo_estado_css'])),
                    'tipo_estado_dominio'                       => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_dominio']))), 
                    'tipo_estado_observacion'                   => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_observacion']))),


                    'tipo_cantidad_codigo'                       => $rowMSSQL00['tipo_cantidad_codigo'],
                    'tipo_cantidad_orden'                        => $rowMSSQL00['tipo_cantidad_orden'],
                    'tipo_cantidad_ingles'                       => trim(strtoupper(strtolower($rowMSSQL00['tipo_cantidad_ingles']))),
                    'tipo_cantidad_castellano'                   => trim(strtoupper(strtolower($rowMSSQL00['tipo_cantidad_castellano']))),
                    'tipo_cantidad_portugues'                    => trim(strtoupper(strtolower($rowMSSQL00['tipo_cantidad_portugues']))),
                    'tipo_cantidad_parametro'                    => $rowMSSQL00['tipo_cantidad_parametro'],
                    'tipo_cantidad_icono'                        => trim(strtolower($rowMSSQL00['tipo_cantidad_icono'])),
                    'tipo_cantidad_path'                         => trim(strtolower($rowMSSQL00['tipo_cantidad_path'])),
                    'tipo_cantidad_css'                          => trim(strtolower($rowMSSQL00['tipo_cantidad_css'])),
                    'tipo_cantidad_dominio'                      => trim(strtoupper(strtolower($rowMSSQL00['tipo_cantidad_dominio']))), 
                    'tipo_cantidad_observacion'                  => trim(strtoupper(strtolower($rowMSSQL00['tipo_cantidad_observacion']))),

                    'tipo_gerencia_codigo'                       => $rowMSSQL00['tipo_gerencia_codigo'],
                    'tipo_gerencia_codigo_nombre'                => trim(strtoupper(strtolower($rowMSSQL00['tipo_gerencia_codigo_nombre']))),
                    'tipo_gerencia_codigo_referencia'            => trim(strtoupper(strtolower($rowMSSQL00['tipo_gerencia_codigo_referencia']))),
                    'tipo_gerencia_nombre'                       => trim(strtoupper(strtolower($rowMSSQL00['tipo_gerencia_nombre']))), 

                    'tipo_departamento_codigo'                   => $rowMSSQL00['tipo_departamento_codigo'],
                    'tipo_departamento_codigo_nombre'            => trim(strtoupper(strtolower($rowMSSQL00['tipo_departamento_codigo_nombre']))),
                    'tipo_departamento_codigo_referencia'        => trim(strtoupper(strtolower($rowMSSQL00['tipo_departamento_codigo_referencia']))),
                    'tipo_departamento_nombre'                   => trim(strtoupper(strtolower($rowMSSQL00['tipo_departamento_nombre']))), 

                    'tipo_jefatura_codigo'                       => $rowMSSQL00['tipo_jefatura_codigo'],
                    'tipo_jefatura_codigo_nombre'                => trim(strtoupper(strtolower($rowMSSQL00['tipo_jefatura_codigo_nombre']))),
                    'tipo_jefatura_codigo_referencia'            => trim(strtoupper(strtolower($rowMSSQL00['tipo_jefatura_codigo_referencia']))),
                    'tipo_jefatura_nombre'                       => trim(strtoupper(strtolower($rowMSSQL00['tipo_jefatura_nombre']))), 

                    'tipo_cargo_codigo'                          => $rowMSSQL00['tipo_cargo_codigo'],
                    'tipo_cargo_codigo_nombre'                   => trim(strtoupper(strtolower($rowMSSQL00['tipo_cargo_codigo_nombre']))),
                    'tipo_cargo_codigo_referencia'               => trim(strtoupper(strtolower($rowMSSQL00['tipo_cargo_codigo_referencia']))),
                    'tipo_cargo_nombre'                          => trim(strtoupper(strtolower($rowMSSQL00['tipo_cargo_nombre'])))    
                );

                $result[]   = $detalle;
            }

            if (isset($result)){
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } else {
                $detalle = array(
                    'tarjeta_personal_codigo'                   => '',
                    'tarjeta_personal_orden'                    => '',
                    'tarjeta_personal_documento'                => '',
                    'tarjeta_personal_email'                    => '',
                    'tarjeta_personal_nombre_visualizar'        => '',
                    'tarjeta_personal_apellido_visualizar'      => '',
                    'tarjeta_personal_nombre'                   => '',
                    'tarjeta_personal_nombre1'                  => '',
                    'tarjeta_personal_apellido1'                => '',
                    'tarjeta_personal_apellido2'                => '',
                    'tarjeta_personal_fecha_nacimiento_1'       => '',
                    'tarjeta_personal_fecha_nacimiento_2'       => '',
                    'tarjeta_personal_observacion'              => '', 
                    
                    'auditoria_usuario'                         => '',
                    'auditoria_fecha_hora'                      => '',
                    'auditoria_ip'                              => '',

                    'tipo_estado_codigo'                        => '',
                    'tipo_estado_orden'                         => '',
                    'tipo_estado_ingles'                        => '',
                    'tipo_estado_castellano'                    => '',
                    'tipo_estado_portugues'                     => '',
                    'tipo_estado_parametro'                     => '',
                    'tipo_estado_icono'                         => '',
                    'tipo_estado_path'                          => '',
                    'tipo_estado_css'                           => '',
                    'tipo_estado_dominio'                       => '', 
                    'tipo_estado_observacion'                   => '',

                    'tipo_cantidad_codigo'                      => '',
                    'tipo_cantidad_orden'                       => '',
                    'tipo_cantidad_ingles'                      => '',
                    'tipo_cantidad_castellano'                  => '',
                    'tipo_cantidad_portugues'                   => '',
                    'tipo_cantidad_parametro'                   => '',
                    'tipo_cantidad_icono'                       => '',
                    'tipo_cantidad_path'                        => '',
                    'tipo_cantidad_css'                         => '',
                    'tipo_cantidad_dominio'                     => '', 
                    'tipo_cantidad_observacion'                 => '',

                    'tipo_gerencia_codigo'                      => '',
                    'tipo_gerencia_codigo_nombre'               => '',
                    'tipo_gerencia_codigo_referencia'           => '',
                    'tipo_gerencia_nombre'                      => '', 

                    'tipo_departamento_codigo'                  => '',
                    'tipo_departamento_codigo_nombre'           => '',
                    'tipo_departamento_codigo_referencia'       => '',
                    'tipo_departamento_nombre'                  => '', 

                    'tipo_jefatura_codigo'                      => '',
                    'tipo_jefatura_codigo_nombre'               => '',
                    'tipo_jefatura_codigo_referencia'           => '',
                    'tipo_jefatura_nombre'                      => '', 

                    'tipo_cargo_codigo'                         => '',
                    'tipo_cargo_codigo_nombre'                  => '',
                    'tipo_cargo_codigo_referencia'              => '',
                    'tipo_cargo_nombre'                         => ''
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

    $app->get('/v1/200/tarjetapersonal/codigo/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val00  = $request->getAttribute('codigo');

        if (isset($val00)) {
            $sql00  = "SELECT 
                a.TPEFICCOD         AS          tarjeta_personal_codigo,	
                a.TPEFICORD         AS          tarjeta_personal_orden,  
                a.TPEFICDNU         AS          tarjeta_personal_documento, 
                a.TPEFICEMA         AS          tarjeta_personal_email,
                a.TPEFICNOV         AS          tarjeta_personal_nombre_visualizar,
                a.TPEFICAPV         AS          tarjeta_personal_apellido_visualizar,
                h.PRIMERNOMBRE      AS          tarjeta_personal_nombre1,
                h.SEGUNDONOMBRE     AS          tarjeta_personal_nombre2,
                h.APELLIDOPATERNO   AS          tarjeta_personal_apellido1,
                h.APELLIDOMATERNO   AS          tarjeta_personal_apellido2,
                h.FECHANACIMIENTO   AS          tarjeta_personal_fecha_nacimiento,
                a.TPEFICOBS         AS          tarjeta_personal_observacion,
                    
                a.TPEFICAUS         AS          auditoria_usuario,         	        
                a.TPEFICAFH         AS          auditoria_fecha_hora,	
                a.TPEFICAIP         AS          auditoria_ip,
                
                b.DOMFICCOD         AS          tipo_estado_codigo,
                b.DOMFICORD         AS          tipo_estado_orden,
                b.DOMFICNOI         AS          tipo_estado_ingles,
                b.DOMFICNOC         AS          tipo_estado_castellano,
                b.DOMFICNOP         AS          tipo_estado_portugues,
                b.DOMFICPAT         AS          tipo_estado_path,
                b.DOMFICCSS         AS          tipo_estado_css,
                b.DOMFICPAR         AS          tipo_estado_parametro,
                b.DOMFICICO         AS          tipo_estado_icono,
                b.DOMFICVAL         AS          tipo_estado_dominio,
                b.DOMFICOBS         AS          tipo_estado_observacion,
                
                c.DOMFICCOD         AS          tipo_cantidad_codigo,
                c.DOMFICORD         AS          tipo_cantidad_orden,
                c.DOMFICNOI         AS          tipo_cantidad_ingles,
                c.DOMFICNOC         AS          tipo_cantidad_castellano,
                c.DOMFICNOP         AS          tipo_cantidad_portugues,
                c.DOMFICPAT         AS          tipo_cantidad_path,
                c.DOMFICCSS         AS          tipo_cantidad_css,
                c.DOMFICPAR         AS          tipo_cantidad_parametro,
                c.DOMFICICO         AS          tipo_cantidad_icono,
                c.DOMFICVAL         AS          tipo_cantidad_dominio,
                c.DOMFICOBS         AS          tipo_cantidad_observacion,
                
                d.CODE              AS          tipo_gerencia_codigo,
                d.NAME              AS          tipo_gerencia_codigo_nombre,
                d.U_CODIGO          AS          tipo_gerencia_codigo_referencia,
                d.U_NOMBRE          AS          tipo_gerencia_nombre,
                
                e.CODE              AS          tipo_departamento_codigo,
                e.NAME              AS          tipo_departamento_codigo_nombre,
                e.U_CODIGO          AS          tipo_departamento_codigo_referencia,
                e.U_NOMBRE          AS          tipo_departamento_nombre,
                
                f.CODE              AS          tipo_jefatura_codigo,
                f.NAME              AS          tipo_jefatura_codigo_nombre,
                f.U_CODIGO          AS          tipo_jefatura_codigo_referencia,
                f.U_NOMBRE          AS          tipo_jefatura_nombre,
                
                g.CODE              AS          tipo_cargo_codigo,
                g.NAME              AS          tipo_cargo_codigo_nombre,
                g.U_CODIGO          AS          tipo_cargo_codigo_referencia,
                g.U_NOMBRE          AS          tipo_cargo_nombre
                
                FROM [hum].TPEFIC a
                INNER JOIN [adm].DOMFIC b ON a.TPEFICEST = b.DOMFICCOD
                INNER JOIN [adm].DOMFIC c ON a.TPEFICCNC = c.DOMFICCOD
                LEFT OUTER JOIN [CSF].[dbo].[@A1A_TIGE] d ON a.TPEFICGEC = d.U_CODIGO
                LEFT OUTER JOIN [CSF].[dbo].[@A1A_TIDE] e ON a.TPEFICDEC = e.U_CODIGO
                LEFT OUTER JOIN [CSF].[dbo].[@A1A_TICA] f ON a.TPEFICJEC = f.U_CODIGO
                LEFT OUTER JOIN [CSF].[dbo].[@A1A_TICA] g ON a.TPEFICCAC = g.U_CODIGO
                LEFT OUTER JOIN [CSF].[dbo].[empleados_AxisONE] h ON a.TPEFICDNU COLLATE SQL_Latin1_General_CP1_CI_AS = h.CedulaEmpleado

                WHERE a.TPEFICCOD = ?
                
                ORDER BY a.TPEFICCOD DESC";

            try {
                $connMSSQL  = getConnectionMSSQLv1();

                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val00]);
                
                while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                    if ($rowMSSQL00['tarjeta_personal_fecha_nacimiento'] == '1900-01-01' || $rowMSSQL00['tarjeta_personal_fecha_nacimiento'] == null){
                        $tarjeta_personal_fecha_nacimiento_1 = '';
                        $tarjeta_personal_fecha_nacimiento_2 = '';
                    } else {
                        $tarjeta_personal_fecha_nacimiento_1 = $rowMSSQL00['tarjeta_personal_fecha_nacimiento'];
                        $tarjeta_personal_fecha_nacimiento_2 = date('d/m/Y', strtotime($rowMSSQL00['tarjeta_personal_fecha_nacimiento']));
                    }

                    if ($rowMSSQL00['tarjeta_personal_nombre_visualizar'] == 'P'){
                        $tarjeta_personal_nombre = trim($rowMSSQL00['tarjeta_personal_nombre1']);
                    } else {
                        $tarjeta_personal_nombre = trim($rowMSSQL00['tarjeta_personal_nombre2']);
                    }

                    if ($rowMSSQL00['tarjeta_personal_apellido_visualizar'] == 'P'){
                        $tarjeta_personal_nombre = $tarjeta_personal_nombre.' '.trim($rowMSSQL00['tarjeta_personal_apellido1']);
                    } else {
                        $tarjeta_personal_nombre = $tarjeta_personal_nombre.' '.trim($rowMSSQL00['tarjeta_personal_apellido2']);
                    }

                    $detalle    = array(
                        'tarjeta_personal_codigo'                   => $rowMSSQL00['tarjeta_personal_codigo'],
                        'tarjeta_personal_orden'                    => $rowMSSQL00['tarjeta_personal_orden'],
                        'tarjeta_personal_documento'                => trim(strtoupper(strtolower($rowMSSQL00['tarjeta_personal_documento']))),
                        'tarjeta_personal_email'                    => trim(strtolower($rowMSSQL00['tarjeta_personal_email'])),
                        'tarjeta_personal_nombre_visualizar'        => trim(strtoupper(strtolower($rowMSSQL00['tarjeta_personal_nombre_visualizar']))),
                        'tarjeta_personal_apellido_visualizar'      => trim(strtoupper(strtolower($rowMSSQL00['tarjeta_personal_apellido_visualizar']))),
                        'tarjeta_personal_nombre'                   => $tarjeta_personal_nombre,
                        'tarjeta_personal_nombre1'                  => trim($rowMSSQL00['tarjeta_personal_nombre1']),
                        'tarjeta_personal_nombre2'                  => trim($rowMSSQL00['tarjeta_personal_nombre2']),
                        'tarjeta_personal_apellido1'                => trim($rowMSSQL00['tarjeta_personal_apellido1']),
                        'tarjeta_personal_apellido2'                => trim($rowMSSQL00['tarjeta_personal_apellido2']),
                        'tarjeta_personal_fecha_nacimiento_1'       => $tarjeta_personal_fecha_nacimiento_1,
                        'tarjeta_personal_fecha_nacimiento_2'       => $tarjeta_personal_fecha_nacimiento_2,
                        'tarjeta_personal_observacion'              => trim($rowMSSQL00['tarjeta_personal_observacion']),
                        
                        'auditoria_usuario'                         => trim($rowMSSQL00['auditoria_usuario']),
                        'auditoria_fecha_hora'                      => $rowMSSQL00['auditoria_fecha_hora'],
                        'auditoria_ip'                              => trim($rowMSSQL00['auditoria_ip']),

                        'tipo_estado_codigo'                        => $rowMSSQL00['tipo_estado_codigo'],
                        'tipo_estado_orden'                         => $rowMSSQL00['tipo_estado_orden'],
                        'tipo_estado_ingles'                        => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_ingles']))),
                        'tipo_estado_castellano'                    => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_castellano']))),
                        'tipo_estado_portugues'                     => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_portugues']))),
                        'tipo_estado_parametro'                     => $rowMSSQL00['tipo_estado_parametro'],
                        'tipo_estado_icono'                         => trim(strtolower($rowMSSQL00['tipo_estado_icono'])),
                        'tipo_estado_path'                          => trim(strtolower($rowMSSQL00['tipo_estado_path'])),
                        'tipo_estado_css'                           => trim(strtolower($rowMSSQL00['tipo_estado_css'])),
                        'tipo_estado_dominio'                       => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_dominio']))), 
                        'tipo_estado_observacion'                   => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_observacion']))),


                        'tipo_cantidad_codigo'                       => $rowMSSQL00['tipo_cantidad_codigo'],
                        'tipo_cantidad_orden'                        => $rowMSSQL00['tipo_cantidad_orden'],
                        'tipo_cantidad_ingles'                       => trim(strtoupper(strtolower($rowMSSQL00['tipo_cantidad_ingles']))),
                        'tipo_cantidad_castellano'                   => trim(strtoupper(strtolower($rowMSSQL00['tipo_cantidad_castellano']))),
                        'tipo_cantidad_portugues'                    => trim(strtoupper(strtolower($rowMSSQL00['tipo_cantidad_portugues']))),
                        'tipo_cantidad_parametro'                    => $rowMSSQL00['tipo_cantidad_parametro'],
                        'tipo_cantidad_icono'                        => trim(strtolower($rowMSSQL00['tipo_cantidad_icono'])),
                        'tipo_cantidad_path'                         => trim(strtolower($rowMSSQL00['tipo_cantidad_path'])),
                        'tipo_cantidad_css'                          => trim(strtolower($rowMSSQL00['tipo_cantidad_css'])),
                        'tipo_cantidad_dominio'                      => trim(strtoupper(strtolower($rowMSSQL00['tipo_cantidad_dominio']))), 
                        'tipo_cantidad_observacion'                  => trim(strtoupper(strtolower($rowMSSQL00['tipo_cantidad_observacion']))),

                        'tipo_gerencia_codigo'                       => $rowMSSQL00['tipo_gerencia_codigo'],
                        'tipo_gerencia_codigo_nombre'                => trim(strtoupper(strtolower($rowMSSQL00['tipo_gerencia_codigo_nombre']))),
                        'tipo_gerencia_codigo_referencia'            => trim(strtoupper(strtolower($rowMSSQL00['tipo_gerencia_codigo_referencia']))),
                        'tipo_gerencia_nombre'                       => trim(strtoupper(strtolower($rowMSSQL00['tipo_gerencia_nombre']))), 

                        'tipo_departamento_codigo'                   => $rowMSSQL00['tipo_departamento_codigo'],
                        'tipo_departamento_codigo_nombre'            => trim(strtoupper(strtolower($rowMSSQL00['tipo_departamento_codigo_nombre']))),
                        'tipo_departamento_codigo_referencia'        => trim(strtoupper(strtolower($rowMSSQL00['tipo_departamento_codigo_referencia']))),
                        'tipo_departamento_nombre'                   => trim(strtoupper(strtolower($rowMSSQL00['tipo_departamento_nombre']))), 

                        'tipo_jefatura_codigo'                       => $rowMSSQL00['tipo_jefatura_codigo'],
                        'tipo_jefatura_codigo_nombre'                => trim(strtoupper(strtolower($rowMSSQL00['tipo_jefatura_codigo_nombre']))),
                        'tipo_jefatura_codigo_referencia'            => trim(strtoupper(strtolower($rowMSSQL00['tipo_jefatura_codigo_referencia']))),
                        'tipo_jefatura_nombre'                       => trim(strtoupper(strtolower($rowMSSQL00['tipo_jefatura_nombre']))), 

                        'tipo_cargo_codigo'                          => $rowMSSQL00['tipo_cargo_codigo'],
                        'tipo_cargo_codigo_nombre'                   => trim(strtoupper(strtolower($rowMSSQL00['tipo_cargo_codigo_nombre']))),
                        'tipo_cargo_codigo_referencia'               => trim(strtoupper(strtolower($rowMSSQL00['tipo_cargo_codigo_referencia']))),
                        'tipo_cargo_nombre'                          => trim(strtoupper(strtolower($rowMSSQL00['tipo_cargo_nombre'])))    
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'tarjeta_personal_codigo'                   => '',
                        'tarjeta_personal_orden'                    => '',
                        'tarjeta_personal_documento'                => '',
                        'tarjeta_personal_email'                    => '', 
                        'tarjeta_personal_nombre_visualizar'        => '',
                        'tarjeta_personal_apellido_visualizar'      => '',   
                        'tarjeta_personal_nombre'                   => '',
                        'tarjeta_personal_nombre1'                  => '',
                        'tarjeta_personal_nombre2'                  => '',
                        'tarjeta_personal_apellido1'                => '',
                        'tarjeta_personal_apellido2'                => '',
                        'tarjeta_personal_fecha_nacimiento_1'       => '',
                        'tarjeta_personal_fecha_nacimiento_2'       => '',
                        'tarjeta_personal_observacion'              => '', 
                        
                        'auditoria_usuario'                         => '',
                        'auditoria_fecha_hora'                      => '',
                        'auditoria_ip'                              => '',

                        'tipo_estado_codigo'                        => '',
                        'tipo_estado_orden'                         => '',
                        'tipo_estado_ingles'                        => '',
                        'tipo_estado_castellano'                    => '',
                        'tipo_estado_portugues'                     => '',
                        'tipo_estado_parametro'                     => '',
                        'tipo_estado_icono'                         => '',
                        'tipo_estado_path'                          => '',
                        'tipo_estado_css'                           => '',
                        'tipo_estado_dominio'                       => '', 
                        'tipo_estado_observacion'                   => '',

                        'tipo_cantidad_codigo'                      => '',
                        'tipo_cantidad_orden'                       => '',
                        'tipo_cantidad_ingles'                      => '',
                        'tipo_cantidad_castellano'                  => '',
                        'tipo_cantidad_portugues'                   => '',
                        'tipo_cantidad_parametro'                   => '',
                        'tipo_cantidad_icono'                       => '',
                        'tipo_cantidad_path'                        => '',
                        'tipo_cantidad_css'                         => '',
                        'tipo_cantidad_dominio'                     => '', 
                        'tipo_cantidad_observacion'                 => '',

                        'tipo_gerencia_codigo'                      => '',
                        'tipo_gerencia_codigo_nombre'               => '',
                        'tipo_gerencia_codigo_referencia'           => '',
                        'tipo_gerencia_nombre'                      => '', 

                        'tipo_departamento_codigo'                  => '',
                        'tipo_departamento_codigo_nombre'           => '',
                        'tipo_departamento_codigo_referencia'       => '',
                        'tipo_departamento_nombre'                  => '', 

                        'tipo_jefatura_codigo'                      => '',
                        'tipo_jefatura_codigo_nombre'               => '',
                        'tipo_jefatura_codigo_referencia'           => '',
                        'tipo_jefatura_nombre'                      => '', 

                        'tipo_cargo_codigo'                         => '',
                        'tipo_cargo_codigo_nombre'                  => '',
                        'tipo_cargo_codigo_referencia'              => '',
                        'tipo_cargo_nombre'                         => ''
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

    $app->get('/v1/200/tarjetapersonal/documento/{documento}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val00  = $request->getAttribute('documento');

        if (isset($val00)) {
            $sql00  = "SELECT 
                a.TPEFICCOD         AS          tarjeta_personal_codigo,	
                a.TPEFICORD         AS          tarjeta_personal_orden,  
                a.TPEFICDNU         AS          tarjeta_personal_documento, 
                a.TPEFICEMA         AS          tarjeta_personal_email,
                a.TPEFICNOV         AS          tarjeta_personal_nombre_visualizar,
                a.TPEFICAPV         AS          tarjeta_personal_apellido_visualizar,
                h.PRIMERNOMBRE      AS          tarjeta_personal_nombre1,
                h.SEGUNDONOMBRE     AS          tarjeta_personal_nombre2,
                h.APELLIDOPATERNO   AS          tarjeta_personal_apellido1,
                h.APELLIDOMATERNO   AS          tarjeta_personal_apellido2,
                h.FECHANACIMIENTO   AS          tarjeta_personal_fecha_nacimiento,
                a.TPEFICOBS         AS          tarjeta_personal_observacion,
                    
                a.TPEFICAUS         AS          auditoria_usuario,         	        
                a.TPEFICAFH         AS          auditoria_fecha_hora,	
                a.TPEFICAIP         AS          auditoria_ip,
                
                b.DOMFICCOD         AS          tipo_estado_codigo,
                b.DOMFICORD         AS          tipo_estado_orden,
                b.DOMFICNOI         AS          tipo_estado_ingles,
                b.DOMFICNOC         AS          tipo_estado_castellano,
                b.DOMFICNOP         AS          tipo_estado_portugues,
                b.DOMFICPAT         AS          tipo_estado_path,
                b.DOMFICCSS         AS          tipo_estado_css,
                b.DOMFICPAR         AS          tipo_estado_parametro,
                b.DOMFICICO         AS          tipo_estado_icono,
                b.DOMFICVAL         AS          tipo_estado_dominio,
                b.DOMFICOBS         AS          tipo_estado_observacion,
                
                c.DOMFICCOD         AS          tipo_cantidad_codigo,
                c.DOMFICORD         AS          tipo_cantidad_orden,
                c.DOMFICNOI         AS          tipo_cantidad_ingles,
                c.DOMFICNOC         AS          tipo_cantidad_castellano,
                c.DOMFICNOP         AS          tipo_cantidad_portugues,
                c.DOMFICPAT         AS          tipo_cantidad_path,
                c.DOMFICCSS         AS          tipo_cantidad_css,
                c.DOMFICPAR         AS          tipo_cantidad_parametro,
                c.DOMFICICO         AS          tipo_cantidad_icono,
                c.DOMFICVAL         AS          tipo_cantidad_dominio,
                c.DOMFICOBS         AS          tipo_cantidad_observacion,
                
                d.CODE              AS          tipo_gerencia_codigo,
                d.NAME              AS          tipo_gerencia_codigo_nombre,
                d.U_CODIGO          AS          tipo_gerencia_codigo_referencia,
                d.U_NOMBRE          AS          tipo_gerencia_nombre,
                
                e.CODE              AS          tipo_departamento_codigo,
                e.NAME              AS          tipo_departamento_codigo_nombre,
                e.U_CODIGO          AS          tipo_departamento_codigo_referencia,
                e.U_NOMBRE          AS          tipo_departamento_nombre,
                
                f.CODE              AS          tipo_jefatura_codigo,
                f.NAME              AS          tipo_jefatura_codigo_nombre,
                f.U_CODIGO          AS          tipo_jefatura_codigo_referencia,
                f.U_NOMBRE          AS          tipo_jefatura_nombre,
                
                g.CODE              AS          tipo_cargo_codigo,
                g.NAME              AS          tipo_cargo_codigo_nombre,
                g.U_CODIGO          AS          tipo_cargo_codigo_referencia,
                g.U_NOMBRE          AS          tipo_cargo_nombre
                
                FROM [hum].TPEFIC a
                INNER JOIN [adm].DOMFIC b ON a.TPEFICEST = b.DOMFICCOD
                INNER JOIN [adm].DOMFIC c ON a.TPEFICCNC = c.DOMFICCOD
                LEFT OUTER JOIN [CSF].[dbo].[@A1A_TIGE] d ON a.TPEFICGEC = d.U_CODIGO
                LEFT OUTER JOIN [CSF].[dbo].[@A1A_TIDE] e ON a.TPEFICDEC = e.U_CODIGO
                LEFT OUTER JOIN [CSF].[dbo].[@A1A_TICA] f ON a.TPEFICJEC = f.U_CODIGO
                LEFT OUTER JOIN [CSF].[dbo].[@A1A_TICA] g ON a.TPEFICCAC = g.U_CODIGO
                LEFT OUTER JOIN [CSF].[dbo].[empleados_AxisONE] h ON a.TPEFICDNU COLLATE SQL_Latin1_General_CP1_CI_AS = h.CedulaEmpleado

                WHERE a.TPEFICDNU = ?
                
                ORDER BY a.TPEFICCOD DESC";

            try {
                $connMSSQL  = getConnectionMSSQLv1();

                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val00]);
                
                while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                    if ($rowMSSQL00['tarjeta_personal_fecha_nacimiento'] == '1900-01-01' || $rowMSSQL00['tarjeta_personal_fecha_nacimiento'] == null){
                        $tarjeta_personal_fecha_nacimiento_1 = '';
                        $tarjeta_personal_fecha_nacimiento_2 = '';
                    } else {
                        $tarjeta_personal_fecha_nacimiento_1 = $rowMSSQL00['tarjeta_personal_fecha_nacimiento'];
                        $tarjeta_personal_fecha_nacimiento_2 = date('d/m/Y', strtotime($rowMSSQL00['tarjeta_personal_fecha_nacimiento']));
                    }

                    if ($rowMSSQL00['tarjeta_personal_nombre_visualizar'] == 'P'){
                        $tarjeta_personal_nombre = trim($rowMSSQL00['tarjeta_personal_nombre1']);
                    } else {
                        $tarjeta_personal_nombre = trim($rowMSSQL00['tarjeta_personal_nombre2']);
                    }

                    if ($rowMSSQL00['tarjeta_personal_apellido_visualizar'] == 'P'){
                        $tarjeta_personal_nombre = $tarjeta_personal_nombre.' '.trim($rowMSSQL00['tarjeta_personal_apellido1']);
                    } else {
                        $tarjeta_personal_nombre = $tarjeta_personal_nombre.' '.trim($rowMSSQL00['tarjeta_personal_apellido2']);
                    }

                    $detalle    = array(
                        'tarjeta_personal_codigo'                   => $rowMSSQL00['tarjeta_personal_codigo'],
                        'tarjeta_personal_orden'                    => $rowMSSQL00['tarjeta_personal_orden'],
                        'tarjeta_personal_documento'                => trim(strtoupper(strtolower($rowMSSQL00['tarjeta_personal_documento']))),
                        'tarjeta_personal_email'                    => trim(strtolower($rowMSSQL00['tarjeta_personal_email'])),
                        'tarjeta_personal_nombre_visualizar'        => trim(strtoupper(strtolower($rowMSSQL00['tarjeta_personal_nombre_visualizar']))),
                        'tarjeta_personal_apellido_visualizar'      => trim(strtoupper(strtolower($rowMSSQL00['tarjeta_personal_apellido_visualizar']))),
                        'tarjeta_personal_nombre'                   => $tarjeta_personal_nombre,
                        'tarjeta_personal_nombre1'                  => trim($rowMSSQL00['tarjeta_personal_nombre1']),
                        'tarjeta_personal_nombre2'                  => trim($rowMSSQL00['tarjeta_personal_nombre2']),
                        'tarjeta_personal_apellido1'                => trim($rowMSSQL00['tarjeta_personal_apellido1']),
                        'tarjeta_personal_apellido2'                => trim($rowMSSQL00['tarjeta_personal_apellido2']),
                        'tarjeta_personal_fecha_nacimiento_1'       => $tarjeta_personal_fecha_nacimiento_1,
                        'tarjeta_personal_fecha_nacimiento_2'       => $tarjeta_personal_fecha_nacimiento_2,
                        'tarjeta_personal_observacion'              => trim($rowMSSQL00['tarjeta_personal_observacion']),
                        
                        'auditoria_usuario'                         => trim($rowMSSQL00['auditoria_usuario']),
                        'auditoria_fecha_hora'                      => $rowMSSQL00['auditoria_fecha_hora'],
                        'auditoria_ip'                              => trim($rowMSSQL00['auditoria_ip']),

                        'tipo_estado_codigo'                        => $rowMSSQL00['tipo_estado_codigo'],
                        'tipo_estado_orden'                         => $rowMSSQL00['tipo_estado_orden'],
                        'tipo_estado_ingles'                        => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_ingles']))),
                        'tipo_estado_castellano'                    => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_castellano']))),
                        'tipo_estado_portugues'                     => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_portugues']))),
                        'tipo_estado_parametro'                     => $rowMSSQL00['tipo_estado_parametro'],
                        'tipo_estado_icono'                         => trim(strtolower($rowMSSQL00['tipo_estado_icono'])),
                        'tipo_estado_path'                          => trim(strtolower($rowMSSQL00['tipo_estado_path'])),
                        'tipo_estado_css'                           => trim(strtolower($rowMSSQL00['tipo_estado_css'])),
                        'tipo_estado_dominio'                       => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_dominio']))), 
                        'tipo_estado_observacion'                   => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_observacion']))),


                        'tipo_cantidad_codigo'                       => $rowMSSQL00['tipo_cantidad_codigo'],
                        'tipo_cantidad_orden'                        => $rowMSSQL00['tipo_cantidad_orden'],
                        'tipo_cantidad_ingles'                       => trim(strtoupper(strtolower($rowMSSQL00['tipo_cantidad_ingles']))),
                        'tipo_cantidad_castellano'                   => trim(strtoupper(strtolower($rowMSSQL00['tipo_cantidad_castellano']))),
                        'tipo_cantidad_portugues'                    => trim(strtoupper(strtolower($rowMSSQL00['tipo_cantidad_portugues']))),
                        'tipo_cantidad_parametro'                    => $rowMSSQL00['tipo_cantidad_parametro'],
                        'tipo_cantidad_icono'                        => trim(strtolower($rowMSSQL00['tipo_cantidad_icono'])),
                        'tipo_cantidad_path'                         => trim(strtolower($rowMSSQL00['tipo_cantidad_path'])),
                        'tipo_cantidad_css'                          => trim(strtolower($rowMSSQL00['tipo_cantidad_css'])),
                        'tipo_cantidad_dominio'                      => trim(strtoupper(strtolower($rowMSSQL00['tipo_cantidad_dominio']))), 
                        'tipo_cantidad_observacion'                  => trim(strtoupper(strtolower($rowMSSQL00['tipo_cantidad_observacion']))),

                        'tipo_gerencia_codigo'                       => $rowMSSQL00['tipo_gerencia_codigo'],
                        'tipo_gerencia_codigo_nombre'                => trim(strtoupper(strtolower($rowMSSQL00['tipo_gerencia_codigo_nombre']))),
                        'tipo_gerencia_codigo_referencia'            => trim(strtoupper(strtolower($rowMSSQL00['tipo_gerencia_codigo_referencia']))),
                        'tipo_gerencia_nombre'                       => trim(strtoupper(strtolower($rowMSSQL00['tipo_gerencia_nombre']))), 

                        'tipo_departamento_codigo'                   => $rowMSSQL00['tipo_departamento_codigo'],
                        'tipo_departamento_codigo_nombre'            => trim(strtoupper(strtolower($rowMSSQL00['tipo_departamento_codigo_nombre']))),
                        'tipo_departamento_codigo_referencia'        => trim(strtoupper(strtolower($rowMSSQL00['tipo_departamento_codigo_referencia']))),
                        'tipo_departamento_nombre'                   => trim(strtoupper(strtolower($rowMSSQL00['tipo_departamento_nombre']))), 

                        'tipo_jefatura_codigo'                       => $rowMSSQL00['tipo_jefatura_codigo'],
                        'tipo_jefatura_codigo_nombre'                => trim(strtoupper(strtolower($rowMSSQL00['tipo_jefatura_codigo_nombre']))),
                        'tipo_jefatura_codigo_referencia'            => trim(strtoupper(strtolower($rowMSSQL00['tipo_jefatura_codigo_referencia']))),
                        'tipo_jefatura_nombre'                       => trim(strtoupper(strtolower($rowMSSQL00['tipo_jefatura_nombre']))), 

                        'tipo_cargo_codigo'                          => $rowMSSQL00['tipo_cargo_codigo'],
                        'tipo_cargo_codigo_nombre'                   => trim(strtoupper(strtolower($rowMSSQL00['tipo_cargo_codigo_nombre']))),
                        'tipo_cargo_codigo_referencia'               => trim(strtoupper(strtolower($rowMSSQL00['tipo_cargo_codigo_referencia']))),
                        'tipo_cargo_nombre'                          => trim(strtoupper(strtolower($rowMSSQL00['tipo_cargo_nombre'])))    
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'tarjeta_personal_codigo'                   => '',
                        'tarjeta_personal_orden'                    => '',
                        'tarjeta_personal_documento'                => '',
                        'tarjeta_personal_email'                    => '',    
                        'tarjeta_personal_nombre_visualizar'        => '',
                        'tarjeta_personal_apellido_visualizar'      => '',
                        'tarjeta_personal_nombre'                   => '',
                        'tarjeta_personal_nombre1'                  => '',
                        'tarjeta_personal_apellido1'                => '',
                        'tarjeta_personal_fecha_nacimiento_1'       => '',
                        'tarjeta_personal_fecha_nacimiento_2'       => '',
                        'tarjeta_personal_observacion'              => '', 
                        
                        'auditoria_usuario'                         => '',
                        'auditoria_fecha_hora'                      => '',
                        'auditoria_ip'                              => '',

                        'tipo_estado_codigo'                        => '',
                        'tipo_estado_orden'                         => '',
                        'tipo_estado_ingles'                        => '',
                        'tipo_estado_castellano'                    => '',
                        'tipo_estado_portugues'                     => '',
                        'tipo_estado_parametro'                     => '',
                        'tipo_estado_icono'                         => '',
                        'tipo_estado_path'                          => '',
                        'tipo_estado_css'                           => '',
                        'tipo_estado_dominio'                       => '', 
                        'tipo_estado_observacion'                   => '',

                        'tipo_cantidad_codigo'                      => '',
                        'tipo_cantidad_orden'                       => '',
                        'tipo_cantidad_ingles'                      => '',
                        'tipo_cantidad_castellano'                  => '',
                        'tipo_cantidad_portugues'                   => '',
                        'tipo_cantidad_parametro'                   => '',
                        'tipo_cantidad_icono'                       => '',
                        'tipo_cantidad_path'                        => '',
                        'tipo_cantidad_css'                         => '',
                        'tipo_cantidad_dominio'                     => '', 
                        'tipo_cantidad_observacion'                 => '',

                        'tipo_gerencia_codigo'                      => '',
                        'tipo_gerencia_codigo_nombre'               => '',
                        'tipo_gerencia_codigo_referencia'           => '',
                        'tipo_gerencia_nombre'                      => '', 

                        'tipo_departamento_codigo'                  => '',
                        'tipo_departamento_codigo_nombre'           => '',
                        'tipo_departamento_codigo_referencia'       => '',
                        'tipo_departamento_nombre'                  => '', 

                        'tipo_jefatura_codigo'                      => '',
                        'tipo_jefatura_codigo_nombre'               => '',
                        'tipo_jefatura_codigo_referencia'           => '',
                        'tipo_jefatura_nombre'                      => '', 

                        'tipo_cargo_codigo'                         => '',
                        'tipo_cargo_codigo_nombre'                  => '',
                        'tipo_cargo_codigo_referencia'              => '',
                        'tipo_cargo_nombre'                         => ''

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

    $app->get('/v1/200/tarjetapersonal/ultimo/{documento}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val00  = $request->getAttribute('documento');

        if (isset($val00)) {
            $sql00  = "SELECT
                TOP 1
                a.TPEFICCOD         AS          tarjeta_personal_codigo,	
                a.TPEFICORD         AS          tarjeta_personal_orden,  
                a.TPEFICDNU         AS          tarjeta_personal_documento, 
                a.TPEFICEMA         AS          tarjeta_personal_email,
                a.TPEFICNOV         AS          tarjeta_personal_nombre_visualizar,
                a.TPEFICAPV         AS          tarjeta_personal_apellido_visualizar,
                h.PRIMERNOMBRE      AS          tarjeta_personal_nombre1,
                h.SEGUNDONOMBRE     AS          tarjeta_personal_nombre2,
                h.APELLIDOPATERNO   AS          tarjeta_personal_apellido1,
                h.APELLIDOMATERNO   AS          tarjeta_personal_apellido2,
                h.FECHANACIMIENTO   AS          tarjeta_personal_fecha_nacimiento,
                a.TPEFICOBS         AS          tarjeta_personal_observacion,
                    
                a.TPEFICAUS         AS          auditoria_usuario,         	        
                a.TPEFICAFH         AS          auditoria_fecha_hora,	
                a.TPEFICAIP         AS          auditoria_ip,
                
                b.DOMFICCOD         AS          tipo_estado_codigo,
                b.DOMFICORD         AS          tipo_estado_orden,
                b.DOMFICNOI         AS          tipo_estado_ingles,
                b.DOMFICNOC         AS          tipo_estado_castellano,
                b.DOMFICNOP         AS          tipo_estado_portugues,
                b.DOMFICPAT         AS          tipo_estado_path,
                b.DOMFICCSS         AS          tipo_estado_css,
                b.DOMFICPAR         AS          tipo_estado_parametro,
                b.DOMFICICO         AS          tipo_estado_icono,
                b.DOMFICVAL         AS          tipo_estado_dominio,
                b.DOMFICOBS         AS          tipo_estado_observacion,
                
                c.DOMFICCOD         AS          tipo_cantidad_codigo,
                c.DOMFICORD         AS          tipo_cantidad_orden,
                c.DOMFICNOI         AS          tipo_cantidad_ingles,
                c.DOMFICNOC         AS          tipo_cantidad_castellano,
                c.DOMFICNOP         AS          tipo_cantidad_portugues,
                c.DOMFICPAT         AS          tipo_cantidad_path,
                c.DOMFICCSS         AS          tipo_cantidad_css,
                c.DOMFICPAR         AS          tipo_cantidad_parametro,
                c.DOMFICICO         AS          tipo_cantidad_icono,
                c.DOMFICVAL         AS          tipo_cantidad_dominio,
                c.DOMFICOBS         AS          tipo_cantidad_observacion,
                
                d.CODE              AS          tipo_gerencia_codigo,
                d.NAME              AS          tipo_gerencia_codigo_nombre,
                d.U_CODIGO          AS          tipo_gerencia_codigo_referencia,
                d.U_NOMBRE          AS          tipo_gerencia_nombre,
                
                e.CODE              AS          tipo_departamento_codigo,
                e.NAME              AS          tipo_departamento_codigo_nombre,
                e.U_CODIGO          AS          tipo_departamento_codigo_referencia,
                e.U_NOMBRE          AS          tipo_departamento_nombre,
                
                f.CODE              AS          tipo_jefatura_codigo,
                f.NAME              AS          tipo_jefatura_codigo_nombre,
                f.U_CODIGO          AS          tipo_jefatura_codigo_referencia,
                f.U_NOMBRE          AS          tipo_jefatura_nombre,
                
                g.CODE              AS          tipo_cargo_codigo,
                g.NAME              AS          tipo_cargo_codigo_nombre,
                g.U_CODIGO          AS          tipo_cargo_codigo_referencia,
                g.U_NOMBRE          AS          tipo_cargo_nombre
                
                FROM [hum].TPEFIC a
                INNER JOIN [adm].DOMFIC b ON a.TPEFICEST = b.DOMFICCOD
                INNER JOIN [adm].DOMFIC c ON a.TPEFICCNC = c.DOMFICCOD
                LEFT OUTER JOIN [CSF].[dbo].[@A1A_TIGE] d ON a.TPEFICGEC = d.U_CODIGO
                LEFT OUTER JOIN [CSF].[dbo].[@A1A_TIDE] e ON a.TPEFICDEC = e.U_CODIGO
                LEFT OUTER JOIN [CSF].[dbo].[@A1A_TICA] f ON a.TPEFICJEC = f.U_CODIGO
                LEFT OUTER JOIN [CSF].[dbo].[@A1A_TICA] g ON a.TPEFICCAC = g.U_CODIGO
                LEFT OUTER JOIN [CSF].[dbo].[empleados_AxisONE] h ON a.TPEFICDNU COLLATE SQL_Latin1_General_CP1_CI_AS = h.CedulaEmpleado

                WHERE a.TPEFICDNU = ? AND a.TPEFICEST = (SELECT a1.DOMFICCOD FROM [adm].DOMFIC a1 WHERE a1.DOMFICVAL = 'TARJETAPERSONALESTADO' AND a1.DOMFICPAR = 2)
                
                ORDER BY a.TPEFICCOD DESC";

            try {
                $connMSSQL  = getConnectionMSSQLv1();

                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val00]);
                
                while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                    if ($rowMSSQL00['tarjeta_personal_fecha_nacimiento'] == '1900-01-01' || $rowMSSQL00['tarjeta_personal_fecha_nacimiento'] == null){
                        $tarjeta_personal_fecha_nacimiento_1 = '';
                        $tarjeta_personal_fecha_nacimiento_2 = '';
                    } else {
                        $tarjeta_personal_fecha_nacimiento_1 = $rowMSSQL00['tarjeta_personal_fecha_nacimiento'];
                        $tarjeta_personal_fecha_nacimiento_2 = date('d/m/Y', strtotime($rowMSSQL00['tarjeta_personal_fecha_nacimiento']));
                    }

                    if ($rowMSSQL00['tarjeta_personal_nombre_visualizar'] == 'P'){
                        $tarjeta_personal_nombre = trim($rowMSSQL00['tarjeta_personal_nombre1']);
                    } else {
                        $tarjeta_personal_nombre = trim($rowMSSQL00['tarjeta_personal_nombre2']);
                    }

                    if ($rowMSSQL00['tarjeta_personal_apellido_visualizar'] == 'P'){
                        $tarjeta_personal_nombre = $tarjeta_personal_nombre.' '.trim($rowMSSQL00['tarjeta_personal_apellido1']);
                    } else {
                        $tarjeta_personal_nombre = $tarjeta_personal_nombre.' '.trim($rowMSSQL00['tarjeta_personal_apellido2']);
                    }
                    
                    $detalle    = array(
                        'tarjeta_personal_codigo'                   => $rowMSSQL00['tarjeta_personal_codigo'],
                        'tarjeta_personal_orden'                    => $rowMSSQL00['tarjeta_personal_orden'],
                        'tarjeta_personal_documento'                => trim(strtoupper(strtolower($rowMSSQL00['tarjeta_personal_documento']))),
                        'tarjeta_personal_email'                    => trim(strtolower($rowMSSQL00['tarjeta_personal_email'])),
                        'tarjeta_personal_nombre_visualizar'        => trim(strtoupper(strtolower($rowMSSQL00['tarjeta_personal_nombre_visualizar']))),
                        'tarjeta_personal_apellido_visualizar'      => trim(strtoupper(strtolower($rowMSSQL00['tarjeta_personal_apellido_visualizar']))),
                        'tarjeta_personal_nombre'                   => $tarjeta_personal_nombre,
                        'tarjeta_personal_nombre1'                  => trim($rowMSSQL00['tarjeta_personal_nombre1']),
                        'tarjeta_personal_nombre2'                  => trim($rowMSSQL00['tarjeta_personal_nombre2']),
                        'tarjeta_personal_apellido1'                => trim($rowMSSQL00['tarjeta_personal_apellido1']),
                        'tarjeta_personal_apellido2'                => trim($rowMSSQL00['tarjeta_personal_apellido2']),
                        'tarjeta_personal_fecha_nacimiento_1'       => $tarjeta_personal_fecha_nacimiento_1,
                        'tarjeta_personal_fecha_nacimiento_2'       => $tarjeta_personal_fecha_nacimiento_2,
                        'tarjeta_personal_observacion'              => trim($rowMSSQL00['tarjeta_personal_observacion']),
                        
                        'auditoria_usuario'                         => trim($rowMSSQL00['auditoria_usuario']),
                        'auditoria_fecha_hora'                      => $rowMSSQL00['auditoria_fecha_hora'],
                        'auditoria_ip'                              => trim($rowMSSQL00['auditoria_ip']),

                        'tipo_estado_codigo'                        => $rowMSSQL00['tipo_estado_codigo'],
                        'tipo_estado_orden'                         => $rowMSSQL00['tipo_estado_orden'],
                        'tipo_estado_ingles'                        => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_ingles']))),
                        'tipo_estado_castellano'                    => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_castellano']))),
                        'tipo_estado_portugues'                     => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_portugues']))),
                        'tipo_estado_parametro'                     => $rowMSSQL00['tipo_estado_parametro'],
                        'tipo_estado_icono'                         => trim(strtolower($rowMSSQL00['tipo_estado_icono'])),
                        'tipo_estado_path'                          => trim(strtolower($rowMSSQL00['tipo_estado_path'])),
                        'tipo_estado_css'                           => trim(strtolower($rowMSSQL00['tipo_estado_css'])),
                        'tipo_estado_dominio'                       => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_dominio']))), 
                        'tipo_estado_observacion'                   => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_observacion']))),


                        'tipo_cantidad_codigo'                       => $rowMSSQL00['tipo_cantidad_codigo'],
                        'tipo_cantidad_orden'                        => $rowMSSQL00['tipo_cantidad_orden'],
                        'tipo_cantidad_ingles'                       => trim(strtoupper(strtolower($rowMSSQL00['tipo_cantidad_ingles']))),
                        'tipo_cantidad_castellano'                   => trim(strtoupper(strtolower($rowMSSQL00['tipo_cantidad_castellano']))),
                        'tipo_cantidad_portugues'                    => trim(strtoupper(strtolower($rowMSSQL00['tipo_cantidad_portugues']))),
                        'tipo_cantidad_parametro'                    => $rowMSSQL00['tipo_cantidad_parametro'],
                        'tipo_cantidad_icono'                        => trim(strtolower($rowMSSQL00['tipo_cantidad_icono'])),
                        'tipo_cantidad_path'                         => trim(strtolower($rowMSSQL00['tipo_cantidad_path'])),
                        'tipo_cantidad_css'                          => trim(strtolower($rowMSSQL00['tipo_cantidad_css'])),
                        'tipo_cantidad_dominio'                      => trim(strtoupper(strtolower($rowMSSQL00['tipo_cantidad_dominio']))), 
                        'tipo_cantidad_observacion'                  => trim(strtoupper(strtolower($rowMSSQL00['tipo_cantidad_observacion']))),

                        'tipo_gerencia_codigo'                       => $rowMSSQL00['tipo_gerencia_codigo'],
                        'tipo_gerencia_codigo_nombre'                => trim(strtoupper(strtolower($rowMSSQL00['tipo_gerencia_codigo_nombre']))),
                        'tipo_gerencia_codigo_referencia'            => trim(strtoupper(strtolower($rowMSSQL00['tipo_gerencia_codigo_referencia']))),
                        'tipo_gerencia_nombre'                       => trim(strtoupper(strtolower($rowMSSQL00['tipo_gerencia_nombre']))), 

                        'tipo_departamento_codigo'                   => $rowMSSQL00['tipo_departamento_codigo'],
                        'tipo_departamento_codigo_nombre'            => trim(strtoupper(strtolower($rowMSSQL00['tipo_departamento_codigo_nombre']))),
                        'tipo_departamento_codigo_referencia'        => trim(strtoupper(strtolower($rowMSSQL00['tipo_departamento_codigo_referencia']))),
                        'tipo_departamento_nombre'                   => trim(strtoupper(strtolower($rowMSSQL00['tipo_departamento_nombre']))), 

                        'tipo_jefatura_codigo'                       => $rowMSSQL00['tipo_jefatura_codigo'],
                        'tipo_jefatura_codigo_nombre'                => trim(strtoupper(strtolower($rowMSSQL00['tipo_jefatura_codigo_nombre']))),
                        'tipo_jefatura_codigo_referencia'            => trim(strtoupper(strtolower($rowMSSQL00['tipo_jefatura_codigo_referencia']))),
                        'tipo_jefatura_nombre'                       => trim(strtoupper(strtolower($rowMSSQL00['tipo_jefatura_nombre']))), 

                        'tipo_cargo_codigo'                          => $rowMSSQL00['tipo_cargo_codigo'],
                        'tipo_cargo_codigo_nombre'                   => trim(strtoupper(strtolower($rowMSSQL00['tipo_cargo_codigo_nombre']))),
                        'tipo_cargo_codigo_referencia'               => trim(strtoupper(strtolower($rowMSSQL00['tipo_cargo_codigo_referencia']))),
                        'tipo_cargo_nombre'                          => trim(strtoupper(strtolower($rowMSSQL00['tipo_cargo_nombre'])))    
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'tarjeta_personal_codigo'                   => '',
                        'tarjeta_personal_orden'                    => '',
                        'tarjeta_personal_documento'                => '',
                        'tarjeta_personal_email'                    => '',    
                        'tarjeta_personal_nombre_visualizar'        => '',
                        'tarjeta_personal_apellido_visualizar'      => '',
                        'tarjeta_personal_nombre'                   => '',
                        'tarjeta_personal_nombre1'                  => '',
                        'tarjeta_personal_apellido1'                => '',
                        'tarjeta_personal_fecha_nacimiento_1'       => '',
                        'tarjeta_personal_fecha_nacimiento_2'       => '',
                        'tarjeta_personal_observacion'              => '', 
                        
                        'auditoria_usuario'                         => '',
                        'auditoria_fecha_hora'                      => '',
                        'auditoria_ip'                              => '',

                        'tipo_estado_codigo'                        => '',
                        'tipo_estado_orden'                         => '',
                        'tipo_estado_ingles'                        => '',
                        'tipo_estado_castellano'                    => '',
                        'tipo_estado_portugues'                     => '',
                        'tipo_estado_parametro'                     => '',
                        'tipo_estado_icono'                         => '',
                        'tipo_estado_path'                          => '',
                        'tipo_estado_css'                           => '',
                        'tipo_estado_dominio'                       => '', 
                        'tipo_estado_observacion'                   => '',

                        'tipo_cantidad_codigo'                      => '',
                        'tipo_cantidad_orden'                       => '',
                        'tipo_cantidad_ingles'                      => '',
                        'tipo_cantidad_castellano'                  => '',
                        'tipo_cantidad_portugues'                   => '',
                        'tipo_cantidad_parametro'                   => '',
                        'tipo_cantidad_icono'                       => '',
                        'tipo_cantidad_path'                        => '',
                        'tipo_cantidad_css'                         => '',
                        'tipo_cantidad_dominio'                     => '', 
                        'tipo_cantidad_observacion'                 => '',

                        'tipo_gerencia_codigo'                      => '',
                        'tipo_gerencia_codigo_nombre'               => '',
                        'tipo_gerencia_codigo_referencia'           => '',
                        'tipo_gerencia_nombre'                      => '', 

                        'tipo_departamento_codigo'                  => '',
                        'tipo_departamento_codigo_nombre'           => '',
                        'tipo_departamento_codigo_referencia'       => '',
                        'tipo_departamento_nombre'                  => '', 

                        'tipo_jefatura_codigo'                      => '',
                        'tipo_jefatura_codigo_nombre'               => '',
                        'tipo_jefatura_codigo_referencia'           => '',
                        'tipo_jefatura_nombre'                      => '', 

                        'tipo_cargo_codigo'                         => '',
                        'tipo_cargo_codigo_nombre'                  => '',
                        'tipo_cargo_codigo_referencia'              => '',
                        'tipo_cargo_nombre'                         => ''

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

    $app->get('/v1/200/tarjetapersonal/redsocial/codigo/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val00  = $request->getAttribute('codigo');

        if (isset($val00)) {
            $sql00  = "SELECT 
                a.TPERSOCOD     AS          tarjeta_personal_red_social_codigo, 
                a.TPERSOORD     AS          tarjeta_personal_red_social_orden,
                a.TPERSODIR     AS          tarjeta_personal_red_social_direccion,
                a.TPERSOVIS     AS          tarjeta_personal_red_social_visualizar,
                a.TPERSOOBS     AS          tarjeta_personal_red_social_observacion,
                
                a.TPERSOAUS     AS          auditoria_usuario,
                a.TPERSOAFH     AS          auditoria_fecha_hora,
                a.TPERSOAIP     AS          auditoria_ip,
                
                b.DOMFICCOD     AS          tipo_estado_codigo,
                b.DOMFICORD     AS          tipo_estado_orden,
                b.DOMFICNOI     AS          tipo_estado_ingles,
                b.DOMFICNOC     AS          tipo_estado_castellano,
                b.DOMFICNOP     AS          tipo_estado_portugues,
                b.DOMFICPAT     AS          tipo_estado_path,
                b.DOMFICCSS     AS          tipo_estado_css,
                b.DOMFICPAR     AS          tipo_estado_parametro,
                b.DOMFICICO     AS          tipo_estado_icono,
                b.DOMFICVAL     AS          tipo_estado_dominio,
                b.DOMFICOBS     AS          tipo_estado_observacion,
                
                c.DOMFICCOD     AS          tipo_red_social_codigo,
                c.DOMFICORD     AS          tipo_red_social_orden,
                c.DOMFICNOI     AS          tipo_red_social_ingles,
                c.DOMFICNOC     AS          tipo_red_social_castellano,
                c.DOMFICNOP     AS          tipo_red_social_portugues,
                c.DOMFICPAT     AS          tipo_red_social_path,
                c.DOMFICCSS     AS          tipo_red_social_css,
                c.DOMFICPAR     AS          tipo_red_social_parametro,
                c.DOMFICICO     AS          tipo_red_social_icono,
                c.DOMFICVAL     AS          tipo_red_social_dominio,
                c.DOMFICOBS     AS          tipo_red_social_observacion,
                
                d.TPEFICCOD     AS          tarjeta_personal_codigo,	
                d.TPEFICORD     AS          tarjeta_personal_orden,  
                d.TPEFICDNU     AS          tarjeta_personal_documento, 
                d.TPEFICEMA     AS          tarjeta_personal_email,
                d.TPEFICNOV     AS          tarjeta_personal_nombre_visualizar,
                d.TPEFICAPV     AS          tarjeta_personal_apellido_visualizar,    	
                d.TPEFICOBS     AS          tarjeta_personal_observacion
                
                FROM [hum].[TPERSO] a
                INNER JOIN [adm].[DOMFIC] b ON a.TPERSOEST = b.DOMFICCOD
                INNER JOIN [adm].[DOMFIC] c ON a.TPERSOTRC = c.DOMFICCOD
                INNER JOIN [hum].[TPEFIC] d ON a.TPERSOTAC = d.TPEFICCOD

                WHERE a.TPERSOCOD = ?
                
                ORDER BY a.TPERSOCOD DESC";

            try {
                $connMSSQL  = getConnectionMSSQLv1();

                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val00]);
                
                while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                    $detalle    = array(
                        'tarjeta_personal_red_social_codigo'        => $rowMSSQL00['tarjeta_personal_red_social_codigo'],
                        'tarjeta_personal_red_social_orden'         => $rowMSSQL00['tarjeta_personal_red_social_orden'],
                        'tarjeta_personal_red_social_direccion'     => trim(strtolower($rowMSSQL00['tarjeta_personal_red_social_direccion'])),
                        'tarjeta_personal_red_social_visualizar'    => trim(strtoupper(strtolower($rowMSSQL00['tarjeta_personal_red_social_visualizar']))),
                        'tarjeta_personal_red_social_observacion'   => trim($rowMSSQL00['tarjeta_personal_red_social_observacion']),
                        
                        'auditoria_usuario'                         => trim($rowMSSQL00['auditoria_usuario']),
                        'auditoria_fecha_hora'                      => $rowMSSQL00['auditoria_fecha_hora'],
                        'auditoria_ip'                              => trim($rowMSSQL00['auditoria_ip']),

                        'tipo_estado_codigo'                        => $rowMSSQL00['tipo_estado_codigo'],
                        'tipo_estado_orden'                         => $rowMSSQL00['tipo_estado_orden'],
                        'tipo_estado_ingles'                        => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_ingles']))),
                        'tipo_estado_castellano'                    => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_castellano']))),
                        'tipo_estado_portugues'                     => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_portugues']))),
                        'tipo_estado_parametro'                     => $rowMSSQL00['tipo_estado_parametro'],
                        'tipo_estado_icono'                         => trim(strtolower($rowMSSQL00['tipo_estado_icono'])),
                        'tipo_estado_path'                          => trim(strtolower($rowMSSQL00['tipo_estado_path'])),
                        'tipo_estado_css'                           => trim(strtolower($rowMSSQL00['tipo_estado_css'])),
                        'tipo_estado_dominio'                       => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_dominio']))), 
                        'tipo_estado_observacion'                   => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_observacion']))),

                        'tipo_red_social_codigo'                    => $rowMSSQL00['tipo_red_social_codigo'],
                        'tipo_red_social_orden'                     => $rowMSSQL00['tipo_red_social_orden'],
                        'tipo_red_social_ingles'                    => trim(strtoupper(strtolower($rowMSSQL00['tipo_red_social_ingles']))),
                        'tipo_red_social_castellano'                => trim(strtoupper(strtolower($rowMSSQL00['tipo_red_social_castellano']))),
                        'tipo_red_social_portugues'                 => trim(strtoupper(strtolower($rowMSSQL00['tipo_red_social_portugues']))),
                        'tipo_red_social_parametro'                 => $rowMSSQL00['tipo_red_social_parametro'],
                        'tipo_red_social_path'                      => trim(strtolower($rowMSSQL00['tipo_red_social_path'])),
                        'tipo_red_social_icono'                     => trim(strtolower($rowMSSQL00['tipo_red_social_icono'])),
                        'tipo_red_social_css'                       => trim(strtolower($rowMSSQL00['tipo_red_social_css'])),
                        'tipo_red_social_dominio'                   => trim(strtoupper(strtolower($rowMSSQL00['tipo_red_social_dominio']))), 
                        'tipo_red_social_observacion'               => trim(strtoupper(strtolower($rowMSSQL00['tipo_red_social_observacion']))),

                        'tarjeta_personal_codigo'                   => $rowMSSQL00['tarjeta_personal_codigo'],
                        'tarjeta_personal_orden'                    => $rowMSSQL00['tarjeta_personal_orden'],
                        'tarjeta_personal_documento'                => trim(strtoupper(strtolower($rowMSSQL00['tarjeta_personal_documento']))),
                        'tarjeta_personal_email'                    => trim(strtolower($rowMSSQL00['tarjeta_personal_email'])),
                        'tarjeta_personal_nombre_visualizar'        => trim(strtoupper(strtolower($rowMSSQL00['tarjeta_personal_nombre_visualizar']))),
                        'tarjeta_personal_apellido_visualizar'      => trim(strtoupper(strtolower($rowMSSQL00['tarjeta_personal_apellido_visualizar']))),
                        'tarjeta_personal_observacion'              => trim($rowMSSQL00['tarjeta_personal_observacion'])        
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'tarjeta_personal_red_social_codigo'        => '',
                        'tarjeta_personal_red_social_orden'         => '',
                        'tarjeta_personal_red_social_direccion'     => '',
                        'tarjeta_personal_red_social_visualizar'    => '',
                        'tarjeta_personal_red_social_observacion'   => '',
                        
                        'auditoria_usuario'                         => '',
                        'auditoria_fecha_hora'                      => '',
                        'auditoria_ip'                              => '',

                        'tipo_estado_codigo'                        => '',
                        'tipo_estado_orden'                         => '',
                        'tipo_estado_ingles'                        => '',
                        'tipo_estado_castellano'                    => '',
                        'tipo_estado_portugues'                     => '',
                        'tipo_estado_parametro'                     => '',
                        'tipo_estado_path'                          => '',
                        'tipo_estado_icono'                         => '',
                        'tipo_estado_css'                           => '',
                        'tipo_estado_dominio'                       => '', 
                        'tipo_estado_observacion'                   => '',

                        'tipo_red_social_codigo'                    => '',
                        'tipo_red_social_orden'                     => '',
                        'tipo_red_social_ingles'                    => '',
                        'tipo_red_social_castellano'                => '',
                        'tipo_red_social_portugues'                 => '',
                        'tipo_red_social_parametro'                 => '',
                        'tipo_red_social_path'                      => '',
                        'tipo_red_social_icono'                     => '',
                        'tipo_red_social_css'                       => '',
                        'tipo_red_social_dominio'                   => '', 
                        'tipo_red_social_observacion'               => '',

                        'tarjeta_personal_codigo'                   => '',
                        'tarjeta_personal_orden'                    => '',
                        'tarjeta_personal_documento'                => '',
                        'tarjeta_personal_email'                    => '',
                        'tarjeta_personal_nombre_visualizar'        => '',
                        'tarjeta_personal_apellido_visualizar'      => '',
                        'tarjeta_personal_observacion'              => ''
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

    $app->get('/v1/200/tarjetapersonal/redsocial/documento/{documento}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val00  = $request->getAttribute('documento');

        if (isset($val00)) {
            $sql00  = "SELECT 
                a.TPERSOCOD     AS          tarjeta_personal_red_social_codigo, 
                a.TPERSOORD     AS          tarjeta_personal_red_social_orden,
                a.TPERSODIR     AS          tarjeta_personal_red_social_direccion,
                a.TPERSOVIS     AS          tarjeta_personal_red_social_visualizar,
                a.TPERSOOBS     AS          tarjeta_personal_red_social_observacion,
                
                a.TPERSOAUS     AS          auditoria_usuario,
                a.TPERSOAFH     AS          auditoria_fecha_hora,
                a.TPERSOAIP     AS          auditoria_ip,
                
                b.DOMFICCOD     AS          tipo_estado_codigo,
                b.DOMFICORD     AS          tipo_estado_orden,
                b.DOMFICNOI     AS          tipo_estado_ingles,
                b.DOMFICNOC     AS          tipo_estado_castellano,
                b.DOMFICNOP     AS          tipo_estado_portugues,
                b.DOMFICPAT     AS          tipo_estado_path,
                b.DOMFICCSS     AS          tipo_estado_css,
                b.DOMFICPAR     AS          tipo_estado_parametro,
                b.DOMFICICO     AS          tipo_estado_icono,
                b.DOMFICVAL     AS          tipo_estado_dominio,
                b.DOMFICOBS     AS          tipo_estado_observacion,
                
                c.DOMFICCOD     AS          tipo_red_social_codigo,
                c.DOMFICORD     AS          tipo_red_social_orden,
                c.DOMFICNOI     AS          tipo_red_social_ingles,
                c.DOMFICNOC     AS          tipo_red_social_castellano,
                c.DOMFICNOP     AS          tipo_red_social_portugues,
                c.DOMFICPAT     AS          tipo_red_social_path,
                c.DOMFICCSS     AS          tipo_red_social_css,
                c.DOMFICPAR     AS          tipo_red_social_parametro,
                c.DOMFICICO     AS          tipo_red_social_icono,
                c.DOMFICVAL     AS          tipo_red_social_dominio,
                c.DOMFICOBS     AS          tipo_red_social_observacion,
                
                d.TPEFICCOD     AS          tarjeta_personal_codigo,	
                d.TPEFICORD     AS          tarjeta_personal_orden,  
                d.TPEFICDNU     AS          tarjeta_personal_documento, 
                d.TPEFICEMA     AS          tarjeta_personal_email,
                d.TPEFICNOV     AS          tarjeta_personal_nombre_visualizar,
                d.TPEFICAPV     AS          tarjeta_personal_apellido_visualizar,    	
                d.TPEFICOBS     AS          tarjeta_personal_observacion
                
                FROM [hum].[TPERSO] a
                INNER JOIN [adm].[DOMFIC] b ON a.TPERSOEST = b.DOMFICCOD
                INNER JOIN [adm].[DOMFIC] c ON a.TPERSOTRC = c.DOMFICCOD
                INNER JOIN [hum].[TPEFIC] d ON a.TPERSOTAC = d.TPEFICCOD

                WHERE d.TPEFICDNU = ?
                
                ORDER BY a.TPERSOCOD DESC";

            try {
                $connMSSQL  = getConnectionMSSQLv1();

                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val00]);
                
                while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                    $detalle    = array(
                        'tarjeta_personal_red_social_codigo'        => $rowMSSQL00['tarjeta_personal_red_social_codigo'],
                        'tarjeta_personal_red_social_orden'         => $rowMSSQL00['tarjeta_personal_red_social_orden'],
                        'tarjeta_personal_red_social_direccion'     => trim(strtolower($rowMSSQL00['tarjeta_personal_red_social_direccion'])),
                        'tarjeta_personal_red_social_visualizar'    => trim(strtoupper(strtolower($rowMSSQL00['tarjeta_personal_red_social_visualizar']))),
                        'tarjeta_personal_red_social_observacion'   => trim($rowMSSQL00['tarjeta_personal_red_social_observacion']),
                        
                        'auditoria_usuario'                         => trim($rowMSSQL00['auditoria_usuario']),
                        'auditoria_fecha_hora'                      => $rowMSSQL00['auditoria_fecha_hora'],
                        'auditoria_ip'                              => trim($rowMSSQL00['auditoria_ip']),

                        'tipo_estado_codigo'                        => $rowMSSQL00['tipo_estado_codigo'],
                        'tipo_estado_orden'                         => $rowMSSQL00['tipo_estado_orden'],
                        'tipo_estado_ingles'                        => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_ingles']))),
                        'tipo_estado_castellano'                    => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_castellano']))),
                        'tipo_estado_portugues'                     => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_portugues']))),
                        'tipo_estado_parametro'                     => $rowMSSQL00['tipo_estado_parametro'],
                        'tipo_estado_icono'                         => trim(strtolower($rowMSSQL00['tipo_estado_icono'])),
                        'tipo_estado_path'                          => trim(strtolower($rowMSSQL00['tipo_estado_path'])),
                        'tipo_estado_css'                           => trim(strtolower($rowMSSQL00['tipo_estado_css'])),
                        'tipo_estado_dominio'                       => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_dominio']))), 
                        'tipo_estado_observacion'                   => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_observacion']))),

                        'tipo_red_social_codigo'                    => $rowMSSQL00['tipo_red_social_codigo'],
                        'tipo_red_social_orden'                     => $rowMSSQL00['tipo_red_social_orden'],
                        'tipo_red_social_ingles'                    => trim(strtoupper(strtolower($rowMSSQL00['tipo_red_social_ingles']))),
                        'tipo_red_social_castellano'                => trim(strtoupper(strtolower($rowMSSQL00['tipo_red_social_castellano']))),
                        'tipo_red_social_portugues'                 => trim(strtoupper(strtolower($rowMSSQL00['tipo_red_social_portugues']))),
                        'tipo_red_social_parametro'                 => $rowMSSQL00['tipo_red_social_parametro'],
                        'tipo_red_social_path'                      => trim(strtolower($rowMSSQL00['tipo_red_social_path'])),
                        'tipo_red_social_icono'                     => trim(strtolower($rowMSSQL00['tipo_red_social_icono'])),
                        'tipo_red_social_css'                       => trim(strtolower($rowMSSQL00['tipo_red_social_css'])),
                        'tipo_red_social_dominio'                   => trim(strtoupper(strtolower($rowMSSQL00['tipo_red_social_dominio']))), 
                        'tipo_red_social_observacion'               => trim(strtoupper(strtolower($rowMSSQL00['tipo_red_social_observacion']))),

                        'tarjeta_personal_codigo'                   => $rowMSSQL00['tarjeta_personal_codigo'],
                        'tarjeta_personal_orden'                    => $rowMSSQL00['tarjeta_personal_orden'],
                        'tarjeta_personal_documento'                => trim(strtoupper(strtolower($rowMSSQL00['tarjeta_personal_documento']))),
                        'tarjeta_personal_email'                    => trim(strtolower($rowMSSQL00['tarjeta_personal_email'])),
                        'tarjeta_personal_nombre_visualizar'        => trim(strtoupper(strtolower($rowMSSQL00['tarjeta_personal_nombre_visualizar']))),
                        'tarjeta_personal_apellido_visualizar'      => trim(strtoupper(strtolower($rowMSSQL00['tarjeta_personal_apellido_visualizar']))),
                        'tarjeta_personal_observacion'              => trim($rowMSSQL00['tarjeta_personal_observacion'])        
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'tarjeta_personal_red_social_codigo'        => '',
                        'tarjeta_personal_red_social_orden'         => '',
                        'tarjeta_personal_red_social_direccion'     => '',
                        'tarjeta_personal_red_social_visualizar'    => '',
                        'tarjeta_personal_red_social_observacion'   => '',
                        
                        'auditoria_usuario'                         => '',
                        'auditoria_fecha_hora'                      => '',
                        'auditoria_ip'                              => '',

                        'tipo_estado_codigo'                        => '',
                        'tipo_estado_orden'                         => '',
                        'tipo_estado_ingles'                        => '',
                        'tipo_estado_castellano'                    => '',
                        'tipo_estado_portugues'                     => '',
                        'tipo_estado_parametro'                     => '',
                        'tipo_estado_path'                          => '',
                        'tipo_estado_icono'                         => '',
                        'tipo_estado_css'                           => '',
                        'tipo_estado_dominio'                       => '', 
                        'tipo_estado_observacion'                   => '',

                        'tipo_red_social_codigo'                    => '',
                        'tipo_red_social_orden'                     => '',
                        'tipo_red_social_ingles'                    => '',
                        'tipo_red_social_castellano'                => '',
                        'tipo_red_social_portugues'                 => '',
                        'tipo_red_social_parametro'                 => '',
                        'tipo_red_social_path'                      => '',
                        'tipo_red_social_icono'                     => '',
                        'tipo_red_social_css'                       => '',
                        'tipo_red_social_dominio'                   => '', 
                        'tipo_red_social_observacion'               => '',

                        'tarjeta_personal_codigo'                   => '',
                        'tarjeta_personal_orden'                    => '',
                        'tarjeta_personal_documento'                => '',
                        'tarjeta_personal_email'                    => '',
                        'tarjeta_personal_nombre_visualizar'        => '',
                        'tarjeta_personal_apellido_visualizar'      => '',
                        'tarjeta_personal_observacion'              => '' 
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

    $app->get('/v1/200/tarjetapersonal/redsocial/tarjetapersonal/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val00  = $request->getAttribute('codigo');

        if (isset($val00)) {
            $sql00  = "SELECT 
                a.TPERSOCOD     AS          tarjeta_personal_red_social_codigo, 
                a.TPERSOORD     AS          tarjeta_personal_red_social_orden,
                a.TPERSODIR     AS          tarjeta_personal_red_social_direccion,
                a.TPERSOVIS     AS          tarjeta_personal_red_social_visualizar,
                a.TPERSOOBS     AS          tarjeta_personal_red_social_observacion,
                
                a.TPERSOAUS     AS          auditoria_usuario,
                a.TPERSOAFH     AS          auditoria_fecha_hora,
                a.TPERSOAIP     AS          auditoria_ip,
                
                b.DOMFICCOD     AS          tipo_estado_codigo,
                b.DOMFICORD     AS          tipo_estado_orden,
                b.DOMFICNOI     AS          tipo_estado_ingles,
                b.DOMFICNOC     AS          tipo_estado_castellano,
                b.DOMFICNOP     AS          tipo_estado_portugues,
                b.DOMFICPAT     AS          tipo_estado_path,
                b.DOMFICCSS     AS          tipo_estado_css,
                b.DOMFICPAR     AS          tipo_estado_parametro,
                b.DOMFICICO     AS          tipo_estado_icono,
                b.DOMFICVAL     AS          tipo_estado_dominio,
                b.DOMFICOBS     AS          tipo_estado_observacion,
                
                c.DOMFICCOD     AS          tipo_red_social_codigo,
                c.DOMFICORD     AS          tipo_red_social_orden,
                c.DOMFICNOI     AS          tipo_red_social_ingles,
                c.DOMFICNOC     AS          tipo_red_social_castellano,
                c.DOMFICNOP     AS          tipo_red_social_portugues,
                c.DOMFICPAT     AS          tipo_red_social_path,
                c.DOMFICCSS     AS          tipo_red_social_css,
                c.DOMFICPAR     AS          tipo_red_social_parametro,
                c.DOMFICICO     AS          tipo_red_social_icono,
                c.DOMFICVAL     AS          tipo_red_social_dominio,
                c.DOMFICOBS     AS          tipo_red_social_observacion,
                
                d.TPEFICCOD     AS          tarjeta_personal_codigo,	
                d.TPEFICORD     AS          tarjeta_personal_orden,  
                d.TPEFICDNU     AS          tarjeta_personal_documento, 
                d.TPEFICEMA     AS          tarjeta_personal_email,
                d.TPEFICNOV     AS          tarjeta_personal_nombre_visualizar,
                d.TPEFICAPV     AS          tarjeta_personal_apellido_visualizar,    	
                d.TPEFICOBS     AS          tarjeta_personal_observacion
                
                FROM [hum].[TPERSO] a
                INNER JOIN [adm].[DOMFIC] b ON a.TPERSOEST = b.DOMFICCOD
                INNER JOIN [adm].[DOMFIC] c ON a.TPERSOTRC = c.DOMFICCOD
                INNER JOIN [hum].[TPEFIC] d ON a.TPERSOTAC = d.TPEFICCOD

                WHERE a.TPERSOTAC = ?
                
                ORDER BY a.TPERSOCOD DESC";

            try {
                $connMSSQL  = getConnectionMSSQLv1();

                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val00]);
                
                while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                    $detalle    = array(
                        'tarjeta_personal_red_social_codigo'        => $rowMSSQL00['tarjeta_personal_red_social_codigo'],
                        'tarjeta_personal_red_social_orden'         => $rowMSSQL00['tarjeta_personal_red_social_orden'],
                        'tarjeta_personal_red_social_direccion'     => trim(strtolower($rowMSSQL00['tarjeta_personal_red_social_direccion'])),
                        'tarjeta_personal_red_social_visualizar'    => trim(strtoupper(strtolower($rowMSSQL00['tarjeta_personal_red_social_visualizar']))),
                        'tarjeta_personal_red_social_observacion'   => trim($rowMSSQL00['tarjeta_personal_red_social_observacion']),
                        
                        'auditoria_usuario'                         => trim($rowMSSQL00['auditoria_usuario']),
                        'auditoria_fecha_hora'                      => $rowMSSQL00['auditoria_fecha_hora'],
                        'auditoria_ip'                              => trim($rowMSSQL00['auditoria_ip']),

                        'tipo_estado_codigo'                        => $rowMSSQL00['tipo_estado_codigo'],
                        'tipo_estado_orden'                         => $rowMSSQL00['tipo_estado_orden'],
                        'tipo_estado_ingles'                        => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_ingles']))),
                        'tipo_estado_castellano'                    => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_castellano']))),
                        'tipo_estado_portugues'                     => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_portugues']))),
                        'tipo_estado_parametro'                     => $rowMSSQL00['tipo_estado_parametro'],
                        'tipo_estado_icono'                         => trim(strtolower($rowMSSQL00['tipo_estado_icono'])),
                        'tipo_estado_path'                          => trim(strtolower($rowMSSQL00['tipo_estado_path'])),
                        'tipo_estado_css'                           => trim(strtolower($rowMSSQL00['tipo_estado_css'])),
                        'tipo_estado_dominio'                       => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_dominio']))), 
                        'tipo_estado_observacion'                   => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_observacion']))),

                        'tipo_red_social_codigo'                    => $rowMSSQL00['tipo_red_social_codigo'],
                        'tipo_red_social_orden'                     => $rowMSSQL00['tipo_red_social_orden'],
                        'tipo_red_social_ingles'                    => trim(strtoupper(strtolower($rowMSSQL00['tipo_red_social_ingles']))),
                        'tipo_red_social_castellano'                => trim(strtoupper(strtolower($rowMSSQL00['tipo_red_social_castellano']))),
                        'tipo_red_social_portugues'                 => trim(strtoupper(strtolower($rowMSSQL00['tipo_red_social_portugues']))),
                        'tipo_red_social_parametro'                 => $rowMSSQL00['tipo_red_social_parametro'],
                        'tipo_red_social_path'                      => trim(strtolower($rowMSSQL00['tipo_red_social_path'])),
                        'tipo_red_social_icono'                     => trim(strtolower($rowMSSQL00['tipo_red_social_icono'])),
                        'tipo_red_social_css'                       => trim(strtolower($rowMSSQL00['tipo_red_social_css'])),
                        'tipo_red_social_dominio'                   => trim(strtoupper(strtolower($rowMSSQL00['tipo_red_social_dominio']))), 
                        'tipo_red_social_observacion'               => trim(strtoupper(strtolower($rowMSSQL00['tipo_red_social_observacion']))),

                        'tarjeta_personal_codigo'                   => $rowMSSQL00['tarjeta_personal_codigo'],
                        'tarjeta_personal_orden'                    => $rowMSSQL00['tarjeta_personal_orden'],
                        'tarjeta_personal_documento'                => trim(strtoupper(strtolower($rowMSSQL00['tarjeta_personal_documento']))),
                        'tarjeta_personal_email'                    => trim(strtolower($rowMSSQL00['tarjeta_personal_email'])),
                        'tarjeta_personal_nombre_visualizar'        => trim(strtoupper(strtolower($rowMSSQL00['tarjeta_personal_nombre_visualizar']))),
                        'tarjeta_personal_apellido_visualizar'      => trim(strtoupper(strtolower($rowMSSQL00['tarjeta_personal_apellido_visualizar']))),
                        'tarjeta_personal_observacion'              => trim($rowMSSQL00['tarjeta_personal_observacion'])         
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'tarjeta_personal_red_social_codigo'        => '',
                        'tarjeta_personal_red_social_orden'         => '',
                        'tarjeta_personal_red_social_direccion'     => '',
                        'tarjeta_personal_red_social_observacion'   => '',
                        
                        'auditoria_usuario'                         => '',
                        'auditoria_fecha_hora'                      => '',
                        'auditoria_ip'                              => '',

                        'tipo_estado_codigo'                        => '',
                        'tipo_estado_orden'                         => '',
                        'tipo_estado_ingles'                        => '',
                        'tipo_estado_castellano'                    => '',
                        'tipo_estado_portugues'                     => '',
                        'tipo_estado_parametro'                     => '',
                        'tipo_estado_path'                          => '',
                        'tipo_estado_icono'                         => '',
                        'tipo_estado_css'                           => '',
                        'tipo_estado_dominio'                       => '', 
                        'tipo_estado_observacion'                   => '',

                        'tipo_red_social_codigo'                    => '',
                        'tipo_red_social_orden'                     => '',
                        'tipo_red_social_ingles'                    => '',
                        'tipo_red_social_castellano'                => '',
                        'tipo_red_social_portugues'                 => '',
                        'tipo_red_social_parametro'                 => '',
                        'tipo_red_social_path'                      => '',
                        'tipo_red_social_icono'                     => '',
                        'tipo_red_social_css'                       => '',
                        'tipo_red_social_dominio'                   => '', 
                        'tipo_red_social_observacion'               => '',

                        'tarjeta_personal_codigo'                   => '',
                        'tarjeta_personal_orden'                    => '',
                        'tarjeta_personal_documento'                => '',
                        'tarjeta_personal_email'                    => '',
                        'tarjeta_personal_nombre_visualizar'        => '',
                        'tarjeta_personal_apellido_visualizar'      => '',
                        'tarjeta_personal_observacion'              => ''    
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

    $app->get('/v1/200/tarjetapersonal/telefonoprefijo/codigo/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val00  = $request->getAttribute('codigo');
        
        if (isset($val00)) {
            $sql00  = "SELECT 
                a.TPETELCOD     AS          tarjeta_personal_telefono_codigo,
                a.TPETELORD     AS          tarjeta_personal_telefono_orden,
                a.TPETELVIS     AS          tarjeta_personal_telefono_visualizar,
                a.TPETELNUM     AS          tarjeta_personal_telefono_numero,
                a.TPETELOBS     AS          tarjeta_personal_telefono_observacion,
                
                a.TPETELAUS     AS          auditoria_usuario,
                a.TPETELAFH     AS          auditoria_fecha_hora,
                a.TPETELAIP     AS          auditoria_ip,
                
                b.DOMFICCOD     AS          tipo_estado_codigo,
                b.DOMFICORD     AS          tipo_estado_orden,
                b.DOMFICNOI     AS          tipo_estado_ingles,
                b.DOMFICNOC     AS          tipo_estado_castellano,
                b.DOMFICNOP     AS          tipo_estado_portugues,
                b.DOMFICPAT     AS          tipo_estado_path,
                b.DOMFICCSS     AS          tipo_estado_css,
                b.DOMFICPAR     AS          tipo_estado_parametro,
                b.DOMFICICO     AS          tipo_estado_icono,
                b.DOMFICVAL     AS          tipo_estado_dominio,
                b.DOMFICOBS     AS          tipo_estado_observacion,
                
                c.DOMFICCOD     AS          tipo_prefijo_codigo,
                c.DOMFICORD     AS          tipo_prefijo_orden,
                c.DOMFICNOI     AS          tipo_prefijo_ingles,
                c.DOMFICNOC     AS          tipo_prefijo_castellano,
                c.DOMFICNOP     AS          tipo_prefijo_portugues,
                c.DOMFICPAT     AS          tipo_prefijo_path,
                c.DOMFICCSS     AS          tipo_prefijo_css,
                c.DOMFICPAR     AS          tipo_prefijo_parametro,
                c.DOMFICICO     AS          tipo_prefijo_icono,
                c.DOMFICVAL     AS          tipo_prefijo_dominio,
                c.DOMFICOBS     AS          tipo_prefijo_observacion,
                
                d.TPEFICCOD     AS          tarjeta_personal_codigo,	
                d.TPEFICORD     AS          tarjeta_personal_orden,  
                d.TPEFICDNU     AS          tarjeta_personal_documento, 
                d.TPEFICEMA     AS          tarjeta_personal_email,
                d.TPEFICNOV     AS          tarjeta_personal_nombre_visualizar,
                d.TPEFICAPV     AS          tarjeta_personal_apellido_visualizar,    	
                d.TPEFICOBS     AS          tarjeta_personal_observacion
                
                FROM [hum].TPETEL a
                INNER JOIN [adm].DOMFIC b ON a.TPETELEST = b.DOMFICCOD
                INNER JOIN [adm].DOMFIC c ON a.TPETELTPC = c.DOMFICCOD
                INNER JOIN [hum].TPEFIC d ON a.TPETELTAC = d.TPEFICCOD

                WHERE a.TPETELCOD = ?
                
                ORDER BY a.TPETELCOD DESC";

            try {
                $connMSSQL  = getConnectionMSSQLv1();

                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val00]);

                while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                    $tarjeta_personal_telefono_completo = '+'.trim(strtoupper(strtolower($rowMSSQL00['tipo_prefijo_castellano']))).' '.trim($rowMSSQL00['tarjeta_personal_telefono_numero']);

                    $detalle    = array(
                        'tarjeta_personal_telefono_codigo'          => $rowMSSQL00['tarjeta_personal_telefono_codigo'],
                        'tarjeta_personal_telefono_orden'           => $rowMSSQL00['tarjeta_personal_telefono_orden'],
                        'tarjeta_personal_telefono_visualizar'      => trim(strtoupper(strtolower($rowMSSQL00['tarjeta_personal_telefono_visualizar']))),
                        'tarjeta_personal_telefono_numero'          => trim($rowMSSQL00['tarjeta_personal_telefono_numero']),
                        'tarjeta_personal_telefono_completo'        => $tarjeta_personal_telefono_completo,
                        'tarjeta_personal_telefono_observacion'     => trim($rowMSSQL00['tarjeta_personal_telefono_observacion']),
                        
                        'auditoria_usuario'                         => trim(strtoupper($rowMSSQL00['auditoria_usuario'])),
                        'auditoria_fecha_hora'                      => $rowMSSQL00['auditoria_fecha_hora'],
                        'auditoria_ip'                              => trim(strtoupper($rowMSSQL00['auditoria_ip'])),

                        'tipo_estado_codigo'                        => $rowMSSQL00['tipo_estado_codigo'],
                        'tipo_estado_orden'                         => $rowMSSQL00['tipo_estado_orden'],
                        'tipo_estado_ingles'                        => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_ingles']))),
                        'tipo_estado_castellano'                    => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_castellano']))),
                        'tipo_estado_portugues'                     => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_portugues']))),
                        'tipo_estado_parametro'                     => $rowMSSQL00['tipo_estado_parametro'],
                        'tipo_estado_icono'                         => trim(strtolower($rowMSSQL00['tipo_estado_icono'])),
                        'tipo_estado_path'                          => trim(strtolower($rowMSSQL00['tipo_estado_path'])),
                        'tipo_estado_css'                           => trim(strtolower($rowMSSQL00['tipo_estado_css'])),
                        'tipo_estado_dominio'                       => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_dominio']))), 
                        'tipo_estado_observacion'                   => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_observacion']))),

                        'tipo_prefijo_codigo'                       => $rowMSSQL00['tipo_prefijo_codigo'],
                        'tipo_prefijo_orden'                         => $rowMSSQL00['tipo_prefijo_orden'],
                        'tipo_prefijo_ingles'                       => trim(strtoupper(strtolower($rowMSSQL00['tipo_prefijo_ingles']))),
                        'tipo_prefijo_castellano'                   => trim(strtoupper(strtolower($rowMSSQL00['tipo_prefijo_castellano']))),
                        'tipo_prefijo_portugues'                    => trim(strtoupper(strtolower($rowMSSQL00['tipo_prefijo_portugues']))),
                        'tipo_prefijo_parametro'                    => $rowMSSQL00['tipo_prefijo_parametro'],
                        'tipo_prefijo_icono'                        => trim(strtolower($rowMSSQL00['tipo_prefijo_icono'])),
                        'tipo_prefijo_path'                          => trim(strtolower($rowMSSQL00['tipo_prefijo_path'])),
                        'tipo_prefijo_css'                          => trim(strtolower($rowMSSQL00['tipo_prefijo_css'])),
                        'tipo_prefijo_dominio'                      => trim(strtoupper(strtolower($rowMSSQL00['tipo_prefijo_dominio']))), 
                        'tipo_prefijo_observacion'                  => trim(strtoupper(strtolower($rowMSSQL00['tipo_prefijo_observacion']))),

                        'tarjeta_personal_codigo'                   => $rowMSSQL00['tarjeta_personal_codigo'],
                        'tarjeta_personal_orden'                    => $rowMSSQL00['tarjeta_personal_orden'],
                        'tarjeta_personal_documento'                => trim(strtoupper(strtolower($rowMSSQL00['tarjeta_personal_documento']))),
                        'tarjeta_personal_email'                    => trim(strtolower($rowMSSQL00['tarjeta_personal_email'])),
                        'tarjeta_personal_nombre_visualizar'        => trim(strtoupper(strtolower($rowMSSQL00['tarjeta_personal_nombre_visualizar']))),
                        'tarjeta_personal_apellido_visualizar'      => trim(strtoupper(strtolower($rowMSSQL00['tarjeta_personal_apellido_visualizar']))),
                        'tarjeta_personal_observacion'              => trim($rowMSSQL00['tarjeta_personal_observacion'])         
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'tarjeta_personal_telefono_codigo'          => '',
                        'tarjeta_personal_telefono_orden'           => '',
                        'tarjeta_personal_telefono_visualizar'      => '',
                        'tarjeta_personal_telefono_numero'          => '',
                        'tarjeta_personal_telefono_completo'        => '',  
                        
                        'auditoria_usuario'                         => '',
                        'auditoria_fecha_hora'                      => '',
                        'auditoria_ip'                              => '',

                        'tipo_estado_codigo'                        => '',
                        'tipo_estado_orden'                         => '',
                        'tipo_estado_ingles'                        => '',
                        'tipo_estado_castellano'                    => '',
                        'tipo_estado_portugues'                     => '',
                        'tipo_estado_parametro'                     => '',
                        'tipo_estado_icono'                         => '',
                        'tipo_estado_path'                          => '',
                        'tipo_estado_css'                           => '',
                        'tipo_estado_dominio'                       => '', 
                        'tipo_estado_observacion'                   => '',

                        'tipo_prefijo_codigo'                       => '',
                        'tipo_prefijo_orden'                        => '',
                        'tipo_prefijo_ingles'                       => '',
                        'tipo_prefijo_castellano'                   => '',
                        'tipo_prefijo_portugues'                    => '',
                        'tipo_prefijo_parametro'                    => '',
                        'tipo_prefijo_icono'                        => '',
                        'tipo_prefijo_path'                         => '',
                        'tipo_prefijo_css'                          => '',
                        'tipo_prefijo_dominio'                      => '', 
                        'tipo_prefijo_observacion'                  => '',

                        'tarjeta_personal_codigo'                   => '',
                        'tarjeta_personal_orden'                    => '',
                        'tarjeta_personal_documento'                => '',
                        'tarjeta_personal_email'                    => '',
                        'tarjeta_personal_nombre_visualizar'        => '',
                        'tarjeta_personal_apellido_visualizar'      => '',
                        'tarjeta_personal_observacion'              => ''
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

    $app->get('/v1/200/tarjetapersonal/telefonoprefijo/documento/{documento}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val00  = $request->getAttribute('documento');
        
        if (isset($val00)) {
            $sql00  = "SELECT 
                a.TPETELCOD     AS          tarjeta_personal_telefono_codigo,
                a.TPETELORD     AS          tarjeta_personal_telefono_orden,
                a.TPETELVIS     AS          tarjeta_personal_telefono_visualizar,
                a.TPETELNUM     AS          tarjeta_personal_telefono_numero,
                a.TPETELOBS     AS          tarjeta_personal_telefono_observacion,
                
                a.TPETELAUS     AS          auditoria_usuario,
                a.TPETELAFH     AS          auditoria_fecha_hora,
                a.TPETELAIP     AS          auditoria_ip,
                
                b.DOMFICCOD     AS          tipo_estado_codigo,
                b.DOMFICORD     AS          tipo_estado_orden,
                b.DOMFICNOI     AS          tipo_estado_ingles,
                b.DOMFICNOC     AS          tipo_estado_castellano,
                b.DOMFICNOP     AS          tipo_estado_portugues,
                b.DOMFICPAT     AS          tipo_estado_path,
                b.DOMFICCSS     AS          tipo_estado_css,
                b.DOMFICPAR     AS          tipo_estado_parametro,
                b.DOMFICICO     AS          tipo_estado_icono,
                b.DOMFICVAL     AS          tipo_estado_dominio,
                b.DOMFICOBS     AS          tipo_estado_observacion,
                
                c.DOMFICCOD     AS          tipo_prefijo_codigo,
                c.DOMFICORD     AS          tipo_prefijo_orden,
                c.DOMFICNOI     AS          tipo_prefijo_ingles,
                c.DOMFICNOC     AS          tipo_prefijo_castellano,
                c.DOMFICNOP     AS          tipo_prefijo_portugues,
                c.DOMFICPAT     AS          tipo_prefijo_path,
                c.DOMFICCSS     AS          tipo_prefijo_css,
                c.DOMFICPAR     AS          tipo_prefijo_parametro,
                c.DOMFICICO     AS          tipo_prefijo_icono,
                c.DOMFICVAL     AS          tipo_prefijo_dominio,
                c.DOMFICOBS     AS          tipo_prefijo_observacion,
                
                d.TPEFICCOD     AS          tarjeta_personal_codigo,	
                d.TPEFICORD     AS          tarjeta_personal_orden,  
                d.TPEFICDNU     AS          tarjeta_personal_documento, 
                d.TPEFICEMA     AS          tarjeta_personal_email,
                d.TPEFICNOV     AS          tarjeta_personal_nombre_visualizar,
                d.TPEFICAPV     AS          tarjeta_personal_apellido_visualizar,    	
                d.TPEFICOBS     AS          tarjeta_personal_observacion
                
                FROM [hum].TPETEL a
                INNER JOIN [adm].DOMFIC b ON a.TPETELEST = b.DOMFICCOD
                INNER JOIN [adm].DOMFIC c ON a.TPETELTPC = c.DOMFICCOD
                INNER JOIN [hum].TPEFIC d ON a.TPETELTAC = d.TPEFICCOD

                WHERE d.TPEFICDNU = ?
                
                ORDER BY a.TPETELCOD DESC";

            try {
                $connMSSQL  = getConnectionMSSQLv1();

                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val00]);

                while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                    $tarjeta_personal_telefono_completo = '+'.trim(strtoupper(strtolower($rowMSSQL00['tipo_prefijo_castellano']))).' '.trim($rowMSSQL00['tarjeta_personal_telefono_numero']);

                    $detalle    = array(
                        'tarjeta_personal_telefono_codigo'          => $rowMSSQL00['tarjeta_personal_telefono_codigo'],
                        'tarjeta_personal_telefono_orden'           => $rowMSSQL00['tarjeta_personal_telefono_orden'],
                        'tarjeta_personal_telefono_visualizar'      => trim(strtoupper(strtolower($rowMSSQL00['tarjeta_personal_telefono_visualizar']))),
                        'tarjeta_personal_telefono_numero'          => trim($rowMSSQL00['tarjeta_personal_telefono_numero']),
                        'tarjeta_personal_telefono_completo'        => $tarjeta_personal_telefono_completo,
                        'tarjeta_personal_telefono_observacion'     => trim($rowMSSQL00['tarjeta_personal_telefono_observacion']),
                        
                        'auditoria_usuario'                         => trim(strtoupper($rowMSSQL00['auditoria_usuario'])),
                        'auditoria_fecha_hora'                      => $rowMSSQL00['auditoria_fecha_hora'],
                        'auditoria_ip'                              => trim(strtoupper($rowMSSQL00['auditoria_ip'])),

                        'tipo_estado_codigo'                        => $rowMSSQL00['tipo_estado_codigo'],
                        'tipo_estado_orden'                         => $rowMSSQL00['tipo_estado_orden'],
                        'tipo_estado_ingles'                        => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_ingles']))),
                        'tipo_estado_castellano'                    => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_castellano']))),
                        'tipo_estado_portugues'                     => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_portugues']))),
                        'tipo_estado_parametro'                     => $rowMSSQL00['tipo_estado_parametro'],
                        'tipo_estado_icono'                         => trim(strtolower($rowMSSQL00['tipo_estado_icono'])),
                        'tipo_estado_path'                          => trim(strtolower($rowMSSQL00['tipo_estado_path'])),
                        'tipo_estado_css'                           => trim(strtolower($rowMSSQL00['tipo_estado_css'])),
                        'tipo_estado_dominio'                       => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_dominio']))), 
                        'tipo_estado_observacion'                   => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_observacion']))),

                        'tipo_prefijo_codigo'                       => $rowMSSQL00['tipo_prefijo_codigo'],
                        'tipo_prefijo_orden'                         => $rowMSSQL00['tipo_prefijo_orden'],
                        'tipo_prefijo_ingles'                       => trim(strtoupper(strtolower($rowMSSQL00['tipo_prefijo_ingles']))),
                        'tipo_prefijo_castellano'                   => trim(strtoupper(strtolower($rowMSSQL00['tipo_prefijo_castellano']))),
                        'tipo_prefijo_portugues'                    => trim(strtoupper(strtolower($rowMSSQL00['tipo_prefijo_portugues']))),
                        'tipo_prefijo_parametro'                    => $rowMSSQL00['tipo_prefijo_parametro'],
                        'tipo_prefijo_icono'                        => trim(strtolower($rowMSSQL00['tipo_prefijo_icono'])),
                        'tipo_prefijo_path'                          => trim(strtolower($rowMSSQL00['tipo_prefijo_path'])),
                        'tipo_prefijo_css'                          => trim(strtolower($rowMSSQL00['tipo_prefijo_css'])),
                        'tipo_prefijo_dominio'                      => trim(strtoupper(strtolower($rowMSSQL00['tipo_prefijo_dominio']))), 
                        'tipo_prefijo_observacion'                  => trim(strtoupper(strtolower($rowMSSQL00['tipo_prefijo_observacion']))),

                        'tarjeta_personal_codigo'                   => $rowMSSQL00['tarjeta_personal_codigo'],
                        'tarjeta_personal_orden'                    => $rowMSSQL00['tarjeta_personal_orden'],
                        'tarjeta_personal_documento'                => trim(strtoupper(strtolower($rowMSSQL00['tarjeta_personal_documento']))),
                        'tarjeta_personal_email'                    => trim(strtolower($rowMSSQL00['tarjeta_personal_email'])),
                        'tarjeta_personal_nombre_visualizar'        => trim(strtoupper(strtolower($rowMSSQL00['tarjeta_personal_nombre_visualizar']))),
                        'tarjeta_personal_apellido_visualizar'      => trim(strtoupper(strtolower($rowMSSQL00['tarjeta_personal_apellido_visualizar']))),
                        'tarjeta_personal_observacion'              => trim($rowMSSQL00['tarjeta_personal_observacion'])        
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'tarjeta_personal_telefono_codigo'          => '',
                        'tarjeta_personal_telefono_orden'           => '',
                        'tarjeta_personal_telefono_visualizar'      => '',
                        'tarjeta_personal_telefono_numero'          => '',
                        'tarjeta_personal_telefono_completo'        => '',  
                        
                        'auditoria_usuario'                         => '',
                        'auditoria_fecha_hora'                      => '',
                        'auditoria_ip'                              => '',

                        'tipo_estado_codigo'                        => '',
                        'tipo_estado_orden'                         => '',
                        'tipo_estado_ingles'                        => '',
                        'tipo_estado_castellano'                    => '',
                        'tipo_estado_portugues'                     => '',
                        'tipo_estado_parametro'                     => '',
                        'tipo_estado_icono'                         => '',
                        'tipo_estado_path'                          => '',
                        'tipo_estado_css'                           => '',
                        'tipo_estado_dominio'                       => '', 
                        'tipo_estado_observacion'                   => '',

                        'tipo_prefijo_codigo'                       => '',
                        'tipo_prefijo_orden'                        => '',
                        'tipo_prefijo_ingles'                       => '',
                        'tipo_prefijo_castellano'                   => '',
                        'tipo_prefijo_portugues'                    => '',
                        'tipo_prefijo_parametro'                    => '',
                        'tipo_prefijo_icono'                        => '',
                        'tipo_prefijo_path'                         => '',
                        'tipo_prefijo_css'                          => '',
                        'tipo_prefijo_dominio'                      => '', 
                        'tipo_prefijo_observacion'                  => '',

                        'tarjeta_personal_codigo'                   => '',
                        'tarjeta_personal_orden'                    => '',
                        'tarjeta_personal_documento'                => '',
                        'tarjeta_personal_email'                    => '',
                        'tarjeta_personal_nombre_visualizar'        => '',
                        'tarjeta_personal_apellido_visualizar'      => '',
                        'tarjeta_personal_observacion'              => ''   
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

    $app->get('/v1/200/tarjetapersonal/telefonoprefijo/tarjetapersonal/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val00  = $request->getAttribute('codigo');
        
        if (isset($val00)) {
            $sql00  = "SELECT 
                a.TPETELCOD     AS          tarjeta_personal_telefono_codigo,
                a.TPETELORD     AS          tarjeta_personal_telefono_orden,
                a.TPETELVIS     AS          tarjeta_personal_telefono_visualizar,
                a.TPETELNUM     AS          tarjeta_personal_telefono_numero,
                a.TPETELOBS     AS          tarjeta_personal_telefono_observacion,
                
                a.TPETELAUS     AS          auditoria_usuario,
                a.TPETELAFH     AS          auditoria_fecha_hora,
                a.TPETELAIP     AS          auditoria_ip,
                
                b.DOMFICCOD     AS          tipo_estado_codigo,
                b.DOMFICORD     AS          tipo_estado_orden,
                b.DOMFICNOI     AS          tipo_estado_ingles,
                b.DOMFICNOC     AS          tipo_estado_castellano,
                b.DOMFICNOP     AS          tipo_estado_portugues,
                b.DOMFICPAT     AS          tipo_estado_path,
                b.DOMFICCSS     AS          tipo_estado_css,
                b.DOMFICPAR     AS          tipo_estado_parametro,
                b.DOMFICICO     AS          tipo_estado_icono,
                b.DOMFICVAL     AS          tipo_estado_dominio,
                b.DOMFICOBS     AS          tipo_estado_observacion,
                
                c.DOMFICCOD     AS          tipo_prefijo_codigo,
                c.DOMFICORD     AS          tipo_prefijo_orden,
                c.DOMFICNOI     AS          tipo_prefijo_ingles,
                c.DOMFICNOC     AS          tipo_prefijo_castellano,
                c.DOMFICNOP     AS          tipo_prefijo_portugues,
                c.DOMFICPAT     AS          tipo_prefijo_path,
                c.DOMFICCSS     AS          tipo_prefijo_css,
                c.DOMFICPAR     AS          tipo_prefijo_parametro,
                c.DOMFICICO     AS          tipo_prefijo_icono,
                c.DOMFICVAL     AS          tipo_prefijo_dominio,
                c.DOMFICOBS     AS          tipo_prefijo_observacion,
                
                d.TPEFICCOD     AS          tarjeta_personal_codigo,	
                d.TPEFICORD     AS          tarjeta_personal_orden,  
                d.TPEFICDNU     AS          tarjeta_personal_documento, 
                d.TPEFICEMA     AS          tarjeta_personal_email,
                d.TPEFICNOV     AS          tarjeta_personal_nombre_visualizar,
                d.TPEFICAPV     AS          tarjeta_personal_apellido_visualizar,    	
                d.TPEFICOBS     AS          tarjeta_personal_observacion
                
                FROM [hum].TPETEL a
                INNER JOIN [adm].DOMFIC b ON a.TPETELEST = b.DOMFICCOD
                INNER JOIN [adm].DOMFIC c ON a.TPETELTPC = c.DOMFICCOD
                INNER JOIN [hum].TPEFIC d ON a.TPETELTAC = d.TPEFICCOD

                WHERE a.TPETELTAC = ?
                
                ORDER BY a.TPETELCOD DESC";

            try {
                $connMSSQL  = getConnectionMSSQLv1();

                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val00]);

                while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                    $tarjeta_personal_telefono_completo = '+'.trim(strtoupper(strtolower($rowMSSQL00['tipo_prefijo_castellano']))).' '.trim($rowMSSQL00['tarjeta_personal_telefono_numero']);

                    $detalle    = array(
                        'tarjeta_personal_telefono_codigo'          => $rowMSSQL00['tarjeta_personal_telefono_codigo'],
                        'tarjeta_personal_telefono_orden'           => $rowMSSQL00['tarjeta_personal_telefono_orden'],
                        'tarjeta_personal_telefono_visualizar'      => trim(strtoupper(strtolower($rowMSSQL00['tarjeta_personal_telefono_visualizar']))),
                        'tarjeta_personal_telefono_numero'          => trim($rowMSSQL00['tarjeta_personal_telefono_numero']),
                        'tarjeta_personal_telefono_completo'        => $tarjeta_personal_telefono_completo,
                        'tarjeta_personal_telefono_observacion'     => trim($rowMSSQL00['tarjeta_personal_telefono_observacion']),
                        
                        'auditoria_usuario'                         => trim(strtoupper($rowMSSQL00['auditoria_usuario'])),
                        'auditoria_fecha_hora'                      => $rowMSSQL00['auditoria_fecha_hora'],
                        'auditoria_ip'                              => trim(strtoupper($rowMSSQL00['auditoria_ip'])),

                        'tipo_estado_codigo'                        => $rowMSSQL00['tipo_estado_codigo'],
                        'tipo_estado_orden'                         => $rowMSSQL00['tipo_estado_orden'],
                        'tipo_estado_ingles'                        => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_ingles']))),
                        'tipo_estado_castellano'                    => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_castellano']))),
                        'tipo_estado_portugues'                     => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_portugues']))),
                        'tipo_estado_parametro'                     => $rowMSSQL00['tipo_estado_parametro'],
                        'tipo_estado_icono'                         => trim(strtolower($rowMSSQL00['tipo_estado_icono'])),
                        'tipo_estado_path'                          => trim(strtolower($rowMSSQL00['tipo_estado_path'])),
                        'tipo_estado_css'                           => trim(strtolower($rowMSSQL00['tipo_estado_css'])),
                        'tipo_estado_dominio'                       => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_dominio']))), 
                        'tipo_estado_observacion'                   => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_observacion']))),

                        'tipo_prefijo_codigo'                       => $rowMSSQL00['tipo_prefijo_codigo'],
                        'tipo_prefijo_orden'                         => $rowMSSQL00['tipo_prefijo_orden'],
                        'tipo_prefijo_ingles'                       => trim(strtoupper(strtolower($rowMSSQL00['tipo_prefijo_ingles']))),
                        'tipo_prefijo_castellano'                   => trim(strtoupper(strtolower($rowMSSQL00['tipo_prefijo_castellano']))),
                        'tipo_prefijo_portugues'                    => trim(strtoupper(strtolower($rowMSSQL00['tipo_prefijo_portugues']))),
                        'tipo_prefijo_parametro'                    => $rowMSSQL00['tipo_prefijo_parametro'],
                        'tipo_prefijo_icono'                        => trim(strtolower($rowMSSQL00['tipo_prefijo_icono'])),
                        'tipo_prefijo_path'                          => trim(strtolower($rowMSSQL00['tipo_prefijo_path'])),
                        'tipo_prefijo_css'                          => trim(strtolower($rowMSSQL00['tipo_prefijo_css'])),
                        'tipo_prefijo_dominio'                      => trim(strtoupper(strtolower($rowMSSQL00['tipo_prefijo_dominio']))), 
                        'tipo_prefijo_observacion'                  => trim(strtoupper(strtolower($rowMSSQL00['tipo_prefijo_observacion']))),

                        'tarjeta_personal_codigo'                   => $rowMSSQL00['tarjeta_personal_codigo'],
                        'tarjeta_personal_orden'                    => $rowMSSQL00['tarjeta_personal_orden'],
                        'tarjeta_personal_documento'                => trim(strtoupper(strtolower($rowMSSQL00['tarjeta_personal_documento']))),
                        'tarjeta_personal_email'                    => trim(strtolower($rowMSSQL00['tarjeta_personal_email'])),
                        'tarjeta_personal_nombre_visualizar'        => trim(strtoupper(strtolower($rowMSSQL00['tarjeta_personal_nombre_visualizar']))),
                        'tarjeta_personal_apellido_visualizar'      => trim(strtoupper(strtolower($rowMSSQL00['tarjeta_personal_apellido_visualizar']))),
                        'tarjeta_personal_observacion'              => trim($rowMSSQL00['tarjeta_personal_observacion'])        
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'tarjeta_personal_telefono_codigo'          => '',
                        'tarjeta_personal_telefono_orden'           => '',
                        'tarjeta_personal_telefono_visualizar'      => '',
                        'tarjeta_personal_telefono_numero'          => '',
                        'tarjeta_personal_telefono_completo'        => '',  
                        
                        'auditoria_usuario'                         => '',
                        'auditoria_fecha_hora'                      => '',
                        'auditoria_ip'                              => '',

                        'tipo_estado_codigo'                        => '',
                        'tipo_estado_orden'                         => '',
                        'tipo_estado_ingles'                        => '',
                        'tipo_estado_castellano'                    => '',
                        'tipo_estado_portugues'                     => '',
                        'tipo_estado_parametro'                     => '',
                        'tipo_estado_icono'                         => '',
                        'tipo_estado_path'                          => '',
                        'tipo_estado_css'                           => '',
                        'tipo_estado_dominio'                       => '', 
                        'tipo_estado_observacion'                   => '',

                        'tipo_prefijo_codigo'                       => '',
                        'tipo_prefijo_orden'                        => '',
                        'tipo_prefijo_ingles'                       => '',
                        'tipo_prefijo_castellano'                   => '',
                        'tipo_prefijo_portugues'                    => '',
                        'tipo_prefijo_parametro'                    => '',
                        'tipo_prefijo_icono'                        => '',
                        'tipo_prefijo_path'                         => '',
                        'tipo_prefijo_css'                          => '',
                        'tipo_prefijo_dominio'                      => '', 
                        'tipo_prefijo_observacion'                  => '',

                        'tarjeta_personal_codigo'                   => '',
                        'tarjeta_personal_orden'                    => '',
                        'tarjeta_personal_documento'                => '',
                        'tarjeta_personal_email'                    => '',
                        'tarjeta_personal_nombre_visualizar'        => '',
                        'tarjeta_personal_apellido_visualizar'      => '',
                        'tarjeta_personal_observacion'              => ''    
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

    $app->get('/v1/200/testpcr/listado', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $sql00  = "SELECT 
            a.SOLPCRCOD         AS          testpcr_codigo,
            a.SOLPCRORD         AS          testpcr_orden,
            a.SOLPCRNOM         AS          testpcr_solicitante_nombre,
            a.SOLPCRAPE         AS          testpcr_solicitante_apellido,
            a.SOLPCRDOC         AS          testpcr_solicitante_documento,
            a.SOLPCREMA         AS          testpcr_solicitante_email,
            a.SOLPCROBC         AS          testpcr_solicitante_observacion,
            a.SOLPCRDOJ         AS          testpcr_jefetura_documento,
            a.SOLPCRFE1         AS          testpcr_fecha_1,
            a.SOLPCRFE2         AS          testpcr_fecha_2,
            a.SOLPCRHO1         AS          testpcr_hora_1,
            a.SOLPCRHO2         AS          testpcr_hora_2,
            a.SOLPCRAD1         AS          testpcr_adjunto_1,
            a.SOLPCRAD2         AS          testpcr_adjunto_2,
            a.SOLPCRAD3         AS          testpcr_adjunto_3,
            a.SOLPCRAD4         AS          testpcr_adjunto_4,
            a.SOLPCRLNO         AS          testpcr_laboratorio_nombre,
            a.SOLPCRLCO         AS          testpcr_laboratorio_contacto,
            a.SOLPCRLMA         AS          testpcr_laboratorio_email,
            a.SOLPCRLFR         AS          testpcr_laboratorio_fecha_resultado,
            a.SOLPCRLAD         AS          testpcr_laboratorio_adjunto,
            a.SOLPCRLRE         AS          testpcr_laboratorio_resultado, 
            a.SOLPCRLOB         AS          testpcr_laboratorio_observacion,
            a.SOLPCRUSC         AS          testpcr_carga_usuario,
            a.SOLPCRFEC         AS          testpcr_carga_fecha,
            a.SOLPCRIPC         AS          testpcr_carga_ip,
            a.SOLPCRUST         AS          testpcr_talento_usuario,
            a.SOLPCRFET         AS          testpcr_talento_fecha,
            a.SOLPCRIPT         AS          testpcr_talento_ip,
            a.SOLPCROBT         AS          testpcr_talento_observacion,
            
            a.SOLPCRAUS         AS          auditoria_usuario,
            a.SOLPCRAFH         AS          auditoria_fecha_hora,
            a.SOLPCRAIP         AS          auditoria_ip,
            
            b.DOMFICCOD         AS          tipo_estado_codigo,
            b.DOMFICORD         AS          tipo_estado_orden,
            b.DOMFICNOI         AS          tipo_estado_ingles,
            b.DOMFICNOC         AS          tipo_estado_castellano,
            b.DOMFICNOP         AS          tipo_estado_portugues,
            b.DOMFICPAT         AS          tipo_estado_path,
            b.DOMFICCSS         AS          tipo_estado_css,
            b.DOMFICPAR         AS          tipo_estado_parametro,
            b.DOMFICICO         AS          tipo_estado_icono,
            b.DOMFICVAL         AS          tipo_estado_dominio,
            b.DOMFICOBS         AS          tipo_estado_observacion,
            
            c.DOMFICCOD         AS          tipo_solicitud_codigo,
            c.DOMFICORD         AS          tipo_solicitud_orden,
            c.DOMFICNOI         AS          tipo_solicitud_ingles,
            c.DOMFICNOC         AS          tipo_solicitud_castellano,
            c.DOMFICNOP         AS          tipo_solicitud_portugues,
            c.DOMFICPAT         AS          tipo_solicitud_path,
            c.DOMFICCSS         AS          tipo_solicitud_css,
            c.DOMFICPAR         AS          tipo_solicitud_parametro,
            c.DOMFICICO         AS          tipo_solicitud_icono,
            c.DOMFICVAL         AS          tipo_solicitud_dominio,
            c.DOMFICOBS         AS          tipo_solicitud_observacion,
            
            d.DOMFICCOD         AS          tipo_rol_codigo,
            d.DOMFICORD         AS          tipo_rol_orden,
            d.DOMFICNOI         AS          tipo_rol_ingles,
            d.DOMFICNOC         AS          tipo_rol_castellano,
            d.DOMFICNOP         AS          tipo_rol_portugues,
            d.DOMFICPAT         AS          tipo_rol_path,
            d.DOMFICCSS         AS          tipo_rol_css,
            d.DOMFICPAR         AS          tipo_rol_parametro,
            d.DOMFICICO         AS          tipo_rol_icono,
            d.DOMFICVAL         AS          tipo_rol_dominio,
            d.DOMFICOBS         AS          tipo_rol_observacion
                    
            FROM [hum].[SOLPCR] a
            INNER JOIN adm.DOMFIC b ON a.SOLPCREST = b.DOMFICCOD
            INNER JOIN adm.DOMFIC c ON a.SOLPCRTSC = c.DOMFICCOD
            INNER JOIN adm.DOMFIC d ON a.SOLPCRTRC = d.DOMFICCOD
        
            ORDER BY a.SOLPCRCOD DESC";

        try {
            $connMSSQL  = getConnectionMSSQLv1();

            $stmtMSSQL00= $connMSSQL->prepare($sql00);
            $stmtMSSQL00->execute();
            
            while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                if ($rowMSSQL00['testpcr_fecha_1'] == '1900-01-01' || $rowMSSQL00['testpcr_fecha_1'] == null){
                    $testpcr_fecha_1_1 = '';
                    $testpcr_fecha_1_2 = '';
                } else {
                    $testpcr_fecha_1_1 = $rowMSSQL00['testpcr_fecha_1'];
                    $testpcr_fecha_1_2 = date('d/m/Y', strtotime($rowMSSQL00['testpcr_fecha_1']));
                }

                if ($rowMSSQL00['testpcr_fecha_2'] == '1900-01-01' || $rowMSSQL00['testpcr_fecha_2'] == null){
                    $testpcr_fecha_2_1 = '';
                    $testpcr_fecha_2_2 = '';
                } else {
                    $testpcr_fecha_2_1 = $rowMSSQL00['testpcr_fecha_2'];
                    $testpcr_fecha_2_2 = date('d/m/Y', strtotime($rowMSSQL00['testpcr_fecha_2']));
                }

                if ($rowMSSQL00['testpcr_laboratorio_fecha_resultado'] == '1900-01-01' || $rowMSSQL00['testpcr_laboratorio_fecha_resultado'] == null){
                    $testpcr_laboratorio_fecha_resultado_1 = '';
                    $testpcr_laboratorio_fecha_resultado_2 = '';
                } else {
                    $testpcr_laboratorio_fecha_resultado_1 = $rowMSSQL00['testpcr_laboratorio_fecha_resultado'];
                    $testpcr_laboratorio_fecha_resultado_2 = date('d/m/Y', strtotime($rowMSSQL00['testpcr_laboratorio_fecha_resultado']));
                }

                $detalle    = array(
                    'testpcr_codigo'                            => $rowMSSQL00['testpcr_codigo'],
                    'testpcr_orden'                             => $rowMSSQL00['testpcr_orden'],
                    'testpcr_solicitante_nombre'                => trim($rowMSSQL00['testpcr_solicitante_nombre']),
                    'testpcr_solicitante_apellido'              => trim($rowMSSQL00['testpcr_solicitante_apellido']),
                    'testpcr_solicitante_documento'             => trim(strtoupper(strtolower($rowMSSQL00['testpcr_solicitante_documento']))),
                    'testpcr_solicitante_email'                 => trim(strtolower($rowMSSQL00['testpcr_solicitante_email'])),
                    'testpcr_solicitante_observacion'           => trim($rowMSSQL00['testpcr_solicitante_observacion']),
                    'testpcr_jefetura_documento'                => trim(strtoupper(strtolower($rowMSSQL00['testpcr_jefetura_documento']))),
                    'testpcr_fecha_1_1'                         => $testpcr_fecha_1_1,
                    'testpcr_fecha_1_2'                         => $testpcr_fecha_1_2,
                    'testpcr_fecha_2_1'                         => $testpcr_fecha_2_1,
                    'testpcr_fecha_2_2'                         => $testpcr_fecha_2_2,
                    'testpcr_hora_1'                            => trim($rowMSSQL00['testpcr_hora_1']),
                    'testpcr_hora_2'                            => trim($rowMSSQL00['testpcr_hora_2']),
                    'testpcr_adjunto_1'                         => trim(strtoupper($rowMSSQL00['testpcr_adjunto_1'])),
                    'testpcr_adjunto_2'                         => trim(strtoupper($rowMSSQL00['testpcr_adjunto_2'])),
                    'testpcr_adjunto_3'                         => trim(strtoupper($rowMSSQL00['testpcr_adjunto_3'])),
                    'testpcr_adjunto_4'                         => trim(strtoupper($rowMSSQL00['testpcr_adjunto_4'])),
                    'testpcr_laboratorio_nombre'                => trim($rowMSSQL00['testpcr_laboratorio_nombre']),
                    'testpcr_laboratorio_contacto'              => trim($rowMSSQL00['testpcr_laboratorio_contacto']), 
                    'testpcr_laboratorio_email'                 => trim($rowMSSQL00['testpcr_laboratorio_email']), 
                    'testpcr_laboratorio_fecha_resultado_1'     => $testpcr_laboratorio_fecha_resultado_1, 
                    'testpcr_laboratorio_fecha_resultado_2'     => $testpcr_laboratorio_fecha_resultado_2, 
                    'testpcr_laboratorio_adjunto'               => trim(strtoupper($rowMSSQL00['testpcr_laboratorio_adjunto'])),
                    'testpcr_laboratorio_resultado'             => trim(strtoupper(strtolower($rowMSSQL00['testpcr_laboratorio_resultado']))),
                    'testpcr_laboratorio_observacion'           => trim($rowMSSQL00['testpcr_laboratorio_observacion']),
                    'testpcr_carga_usuario'                     => trim($rowMSSQL00['testpcr_carga_usuario']),
                    'testpcr_carga_fecha'                       => $rowMSSQL00['testpcr_carga_fecha'],
                    'testpcr_carga_ip'                          => trim($rowMSSQL00['testpcr_carga_ip']),
                    'testpcr_talento_usuario'                   => trim($rowMSSQL00['testpcr_talento_usuario']),
                    'testpcr_talento_fecha'                     => $rowMSSQL00['testpcr_talento_fecha'],
                    'testpcr_talento_ip'                        => trim($rowMSSQL00['testpcr_talento_ip']),
                    'testpcr_talento_observacion'               => trim($rowMSSQL00['testpcr_talento_observacion']),

                    'auditoria_usuario'                         => trim($rowMSSQL00['auditoria_usuario']),
                    'auditoria_fecha_hora'                      => $rowMSSQL00['auditoria_fecha_hora'],
                    'auditoria_ip'                              => trim($rowMSSQL00['auditoria_ip']),

                    'tipo_estado_codigo'                        => $rowMSSQL00['tipo_estado_codigo'],
                    'tipo_estado_orden'                         => $rowMSSQL00['tipo_estado_orden'],
                    'tipo_estado_ingles'                        => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_ingles']))),
                    'tipo_estado_castellano'                    => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_castellano']))),
                    'tipo_estado_portugues'                     => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_portugues']))),
                    'tipo_estado_parametro'                     => $rowMSSQL00['tipo_estado_parametro'],
                    'tipo_estado_icono'                         => trim(strtolower($rowMSSQL00['tipo_estado_icono'])),
                    'tipo_estado_path'                          => trim(strtolower($rowMSSQL00['tipo_estado_path'])),
                    'tipo_estado_css'                           => trim(strtolower($rowMSSQL00['tipo_estado_css'])),
                    'tipo_estado_dominio'                       => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_dominio']))), 
                    'tipo_estado_observacion'                   => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_observacion']))),

                    'tipo_solicitud_codigo'                     => $rowMSSQL00['tipo_solicitud_codigo'],
                    'tipo_solicitud_orden'                      => $rowMSSQL00['tipo_solicitud_orden'],
                    'tipo_solicitud_ingles'                     => trim(strtoupper(strtolower($rowMSSQL00['tipo_solicitud_ingles']))),
                    'tipo_solicitud_castellano'                 => trim(strtoupper(strtolower($rowMSSQL00['tipo_solicitud_castellano']))),
                    'tipo_solicitud_portugues'                  => trim(strtoupper(strtolower($rowMSSQL00['tipo_solicitud_portugues']))),
                    'tipo_solicitud_parametro'                  => $rowMSSQL00['tipo_solicitud_parametro'],
                    'tipo_solicitud_icono'                      => trim(strtolower($rowMSSQL00['tipo_solicitud_icono'])),
                    'tipo_solicitud_path'                       => trim(strtolower($rowMSSQL00['tipo_solicitud_path'])),
                    'tipo_solicitud_css'                        => trim(strtolower($rowMSSQL00['tipo_solicitud_css'])),
                    'tipo_solicitud_dominio'                    => trim(strtoupper(strtolower($rowMSSQL00['tipo_solicitud_dominio']))), 
                    'tipo_solicitud_observacion'                => trim(strtoupper(strtolower($rowMSSQL00['tipo_solicitud_observacion']))),

                    'tipo_rol_codigo'                           => $rowMSSQL00['tipo_rol_codigo'],
                    'tipo_rol_orden'                            => $rowMSSQL00['tipo_rol_orden'],
                    'tipo_rol_ingles'                           => trim(strtoupper(strtolower($rowMSSQL00['tipo_rol_ingles']))),
                    'tipo_rol_castellano'                       => trim(strtoupper(strtolower($rowMSSQL00['tipo_rol_castellano']))),
                    'tipo_rol_portugues'                        => trim(strtoupper(strtolower($rowMSSQL00['tipo_rol_portugues']))),
                    'tipo_rol_parametro'                        => $rowMSSQL00['tipo_rol_parametro'],
                    'tipo_rol_icono'                            => trim(strtolower($rowMSSQL00['tipo_rol_icono'])),
                    'tipo_rol_path'                             => trim(strtolower($rowMSSQL00['tipo_rol_path'])),
                    'tipo_rol_css'                              => trim(strtolower($rowMSSQL00['tipo_rol_css'])),
                    'tipo_rol_dominio'                          => trim(strtoupper(strtolower($rowMSSQL00['tipo_rol_dominio']))), 
                    'tipo_rol_observacion'                      => trim(strtoupper(strtolower($rowMSSQL00['tipo_rol_observacion'])))
                     
                );

                $result[]   = $detalle;
            }

            if (isset($result)){
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } else {
                $detalle = array(
                    'testpcr_codigo'                            => '',
                    'testpcr_orden'                             => '',
                    'testpcr_solicitante_nombre'                => '',
                    'testpcr_solicitante_apellido'              => '',
                    'testpcr_solicitante_documento'             => '',
                    'testpcr_solicitante_email'                 => '',
                    'testpcr_solicitante_observacion'           => '',
                    'testpcr_jefetura_documento'                => '',
                    'testpcr_fecha_1_1'                         => '',
                    'testpcr_fecha_1_2'                         => '',
                    'testpcr_fecha_2_1'                         => '',
                    'testpcr_fecha_2_2'                         => '',
                    'testpcr_hora_1'                            => '',
                    'testpcr_hora_2'                            => '',
                    'testpcr_adjunto_1'                         => '',
                    'testpcr_adjunto_2'                         => '',
                    'testpcr_adjunto_3'                         => '',
                    'testpcr_adjunto_4'                         => '',
                    'testpcr_laboratorio_nombre'                => '',
                    'testpcr_laboratorio_contacto'              => '', 
                    'testpcr_laboratorio_email'                 => '', 
                    'testpcr_laboratorio_fecha_resultado_1'     => '', 
                    'testpcr_laboratorio_fecha_resultado_2'     => '', 
                    'testpcr_laboratorio_adjunto'               => '',
                    'testpcr_laboratorio_resultado'             => '',
                    'testpcr_laboratorio_observacion'           => '',
                    'testpcr_carga_usuario'                     => '',
                    'testpcr_carga_fecha'                       => '',
                    'testpcr_carga_ip'                          => '',
                    'testpcr_talento_usuario'                   => '',
                    'testpcr_talento_fecha'                     => '',
                    'testpcr_talento_ip'                        => '',
                    'testpcr_talento_observacion'               => '',

                    'auditoria_usuario'                         => '',
                    'auditoria_fecha_hora'                      => '',
                    'auditoria_ip'                              => '',

                    'tipo_estado_codigo'                        => '',
                    'tipo_estado_orden'                         => '',
                    'tipo_estado_ingles'                        => '',
                    'tipo_estado_castellano'                    => '',
                    'tipo_estado_portugues'                     => '',
                    'tipo_estado_parametro'                     => '',
                    'tipo_estado_icono'                         => '',
                    'tipo_estado_path'                          => '',
                    'tipo_estado_css'                           => '',
                    'tipo_estado_dominio'                       => '', 
                    'tipo_estado_observacion'                   => '',

                    'tipo_solicitud_codigo'                     => '',
                    'tipo_solicitud_orden'                      => '',
                    'tipo_solicitud_ingles'                     => '',
                    'tipo_solicitud_castellano'                 => '',
                    'tipo_solicitud_portugues'                  => '',
                    'tipo_solicitud_parametro'                  => '',
                    'tipo_solicitud_icono'                      => '',
                    'tipo_solicitud_path'                       => '',
                    'tipo_solicitud_css'                        => '',
                    'tipo_solicitud_dominio'                    => '', 
                    'tipo_solicitud_observacion'                => '',

                    'tipo_rol_codigo'                           => '',
                    'tipo_rol_orden'                            => '',
                    'tipo_rol_ingles'                           => '',
                    'tipo_rol_castellano'                       => '',
                    'tipo_rol_portugues'                        => '',
                    'tipo_rol_parametro'                        => '',
                    'tipo_rol_icono'                            => '',
                    'tipo_rol_path'                             => '',
                    'tipo_rol_css'                              => '',
                    'tipo_rol_dominio'                          => '', 
                    'tipo_rol_observacion'                      => ''
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

    $app->get('/v1/200/testpcr/codigo/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val00  = $request->getAttribute('codigo');
        if (isset($val00)) {
        
            $sql00  = "SELECT 
                a.SOLPCRCOD         AS          testpcr_codigo,
                a.SOLPCRORD         AS          testpcr_orden,
                a.SOLPCRNOM         AS          testpcr_solicitante_nombre,
                a.SOLPCRAPE         AS          testpcr_solicitante_apellido,
                a.SOLPCRDOC         AS          testpcr_solicitante_documento,
                a.SOLPCREMA         AS          testpcr_solicitante_email,
                a.SOLPCROBC         AS          testpcr_solicitante_observacion,
                a.SOLPCRDOJ         AS          testpcr_jefetura_documento,
                a.SOLPCRFE1         AS          testpcr_fecha_1,
                a.SOLPCRFE2         AS          testpcr_fecha_2,
                a.SOLPCRHO1         AS          testpcr_hora_1,
                a.SOLPCRHO2         AS          testpcr_hora_2,
                a.SOLPCRAD1         AS          testpcr_adjunto_1,
                a.SOLPCRAD2         AS          testpcr_adjunto_2,
                a.SOLPCRAD3         AS          testpcr_adjunto_3,
                a.SOLPCRAD4         AS          testpcr_adjunto_4,
                a.SOLPCRLNO         AS          testpcr_laboratorio_nombre,
                a.SOLPCRLCO         AS          testpcr_laboratorio_contacto,
                a.SOLPCRLMA         AS          testpcr_laboratorio_email,
                a.SOLPCRLFR         AS          testpcr_laboratorio_fecha_resultado,
                a.SOLPCRLAD         AS          testpcr_laboratorio_adjunto,
                a.SOLPCRLRE         AS          testpcr_laboratorio_resultado, 
                a.SOLPCRLOB         AS          testpcr_laboratorio_observacion,
                a.SOLPCRUSC         AS          testpcr_carga_usuario,
                a.SOLPCRFEC         AS          testpcr_carga_fecha,
                a.SOLPCRIPC         AS          testpcr_carga_ip,
                a.SOLPCRUST         AS          testpcr_talento_usuario,
                a.SOLPCRFET         AS          testpcr_talento_fecha,
                a.SOLPCRIPT         AS          testpcr_talento_ip,
                a.SOLPCROBT         AS          testpcr_talento_observacion,
                
                a.SOLPCRAUS         AS          auditoria_usuario,
                a.SOLPCRAFH         AS          auditoria_fecha_hora,
                a.SOLPCRAIP         AS          auditoria_ip,
                
                b.DOMFICCOD         AS          tipo_estado_codigo,
                b.DOMFICORD         AS          tipo_estado_orden,
                b.DOMFICNOI         AS          tipo_estado_ingles,
                b.DOMFICNOC         AS          tipo_estado_castellano,
                b.DOMFICNOP         AS          tipo_estado_portugues,
                b.DOMFICPAT         AS          tipo_estado_path,
                b.DOMFICCSS         AS          tipo_estado_css,
                b.DOMFICPAR         AS          tipo_estado_parametro,
                b.DOMFICICO         AS          tipo_estado_icono,
                b.DOMFICVAL         AS          tipo_estado_dominio,
                b.DOMFICOBS         AS          tipo_estado_observacion,
                
                c.DOMFICCOD         AS          tipo_solicitud_codigo,
                c.DOMFICORD         AS          tipo_solicitud_orden,
                c.DOMFICNOI         AS          tipo_solicitud_ingles,
                c.DOMFICNOC         AS          tipo_solicitud_castellano,
                c.DOMFICNOP         AS          tipo_solicitud_portugues,
                c.DOMFICPAT         AS          tipo_solicitud_path,
                c.DOMFICCSS         AS          tipo_solicitud_css,
                c.DOMFICPAR         AS          tipo_solicitud_parametro,
                c.DOMFICICO         AS          tipo_solicitud_icono,
                c.DOMFICVAL         AS          tipo_solicitud_dominio,
                c.DOMFICOBS         AS          tipo_solicitud_observacion,
                
                d.DOMFICCOD         AS          tipo_rol_codigo,
                d.DOMFICORD         AS          tipo_rol_orden,
                d.DOMFICNOI         AS          tipo_rol_ingles,
                d.DOMFICNOC         AS          tipo_rol_castellano,
                d.DOMFICNOP         AS          tipo_rol_portugues,
                d.DOMFICPAT         AS          tipo_rol_path,
                d.DOMFICCSS         AS          tipo_rol_css,
                d.DOMFICPAR         AS          tipo_rol_parametro,
                d.DOMFICICO         AS          tipo_rol_icono,
                d.DOMFICVAL         AS          tipo_rol_dominio,
                d.DOMFICOBS         AS          tipo_rol_observacion
                        
                FROM [hum].[SOLPCR] a

                INNER JOIN adm.DOMFIC b ON a.SOLPCREST = b.DOMFICCOD
                INNER JOIN adm.DOMFIC c ON a.SOLPCRTSC = c.DOMFICCOD
                INNER JOIN adm.DOMFIC d ON a.SOLPCRTRC = d.DOMFICCOD

                WHERE a.SOLPCRCOD = ?
            
                ORDER BY a.SOLPCRCOD DESC";

            try {
                $connMSSQL  = getConnectionMSSQLv1();

                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val00]);
                
                while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                    if ($rowMSSQL00['testpcr_fecha_1'] == '1900-01-01' || $rowMSSQL00['testpcr_fecha_1'] == null){
                        $testpcr_fecha_1_1 = '';
                        $testpcr_fecha_1_2 = '';
                    } else {
                        $testpcr_fecha_1_1 = $rowMSSQL00['testpcr_fecha_1'];
                        $testpcr_fecha_1_2 = date('d/m/Y', strtotime($rowMSSQL00['testpcr_fecha_1']));
                    }

                    if ($rowMSSQL00['testpcr_fecha_2'] == '1900-01-01' || $rowMSSQL00['testpcr_fecha_2'] == null){
                        $testpcr_fecha_2_1 = '';
                        $testpcr_fecha_2_2 = '';
                    } else {
                        $testpcr_fecha_2_1 = $rowMSSQL00['testpcr_fecha_2'];
                        $testpcr_fecha_2_2 = date('d/m/Y', strtotime($rowMSSQL00['testpcr_fecha_2']));
                    }

                    if ($rowMSSQL00['testpcr_laboratorio_fecha_resultado'] == '1900-01-01' || $rowMSSQL00['testpcr_laboratorio_fecha_resultado'] == null){
                        $testpcr_laboratorio_fecha_resultado_1 = '';
                        $testpcr_laboratorio_fecha_resultado_2 = '';
                    } else {
                        $testpcr_laboratorio_fecha_resultado_1 = $rowMSSQL00['testpcr_laboratorio_fecha_resultado'];
                        $testpcr_laboratorio_fecha_resultado_2 = date('d/m/Y', strtotime($rowMSSQL00['testpcr_laboratorio_fecha_resultado']));
                    }

                    $detalle    = array(
                        'testpcr_codigo'                            => $rowMSSQL00['testpcr_codigo'],
                        'testpcr_orden'                             => $rowMSSQL00['testpcr_orden'],
                        'testpcr_solicitante_nombre'                => trim($rowMSSQL00['testpcr_solicitante_nombre']),
                        'testpcr_solicitante_apellido'              => trim($rowMSSQL00['testpcr_solicitante_apellido']),
                        'testpcr_solicitante_documento'             => trim(strtoupper(strtolower($rowMSSQL00['testpcr_solicitante_documento']))),
                        'testpcr_solicitante_email'                 => trim(strtolower($rowMSSQL00['testpcr_solicitante_email'])),
                        'testpcr_solicitante_observacion'           => trim($rowMSSQL00['testpcr_solicitante_observacion']),
                        'testpcr_jefetura_documento'                => trim(strtoupper(strtolower($rowMSSQL00['testpcr_jefetura_documento']))),
                        'testpcr_fecha_1_1'                         => $testpcr_fecha_1_1,
                        'testpcr_fecha_1_2'                         => $testpcr_fecha_1_2,
                        'testpcr_fecha_2_1'                         => $testpcr_fecha_2_1,
                        'testpcr_fecha_2_2'                         => $testpcr_fecha_2_2,
                        'testpcr_hora_1'                            => trim($rowMSSQL00['testpcr_hora_1']),
                        'testpcr_hora_2'                            => trim($rowMSSQL00['testpcr_hora_2']),
                        'testpcr_adjunto_1'                         => trim(strtoupper($rowMSSQL00['testpcr_adjunto_1'])),
                        'testpcr_adjunto_2'                         => trim(strtoupper($rowMSSQL00['testpcr_adjunto_2'])),
                        'testpcr_adjunto_3'                         => trim(strtoupper($rowMSSQL00['testpcr_adjunto_3'])),
                        'testpcr_adjunto_4'                         => trim(strtoupper($rowMSSQL00['testpcr_adjunto_4'])),
                        'testpcr_laboratorio_nombre'                => trim($rowMSSQL00['testpcr_laboratorio_nombre']),
                        'testpcr_laboratorio_contacto'              => trim($rowMSSQL00['testpcr_laboratorio_contacto']), 
                        'testpcr_laboratorio_email'                 => trim($rowMSSQL00['testpcr_laboratorio_email']), 
                        'testpcr_laboratorio_fecha_resultado_1'     => $testpcr_laboratorio_fecha_resultado_1, 
                        'testpcr_laboratorio_fecha_resultado_2'     => $testpcr_laboratorio_fecha_resultado_2, 
                        'testpcr_laboratorio_adjunto'               => trim(strtoupper($rowMSSQL00['testpcr_laboratorio_adjunto'])),
                        'testpcr_laboratorio_resultado'             => trim(strtoupper(strtolower($rowMSSQL00['testpcr_laboratorio_resultado']))),
                        'testpcr_laboratorio_observacion'           => trim($rowMSSQL00['testpcr_laboratorio_observacion']),
                        'testpcr_carga_usuario'                     => trim($rowMSSQL00['testpcr_carga_usuario']),
                        'testpcr_carga_fecha'                       => $rowMSSQL00['testpcr_carga_fecha'],
                        'testpcr_carga_ip'                          => trim($rowMSSQL00['testpcr_carga_ip']),
                        'testpcr_talento_usuario'                   => trim($rowMSSQL00['testpcr_talento_usuario']),
                        'testpcr_talento_fecha'                     => $rowMSSQL00['testpcr_talento_fecha'],
                        'testpcr_talento_ip'                        => trim($rowMSSQL00['testpcr_talento_ip']),
                        'testpcr_talento_observacion'               => trim($rowMSSQL00['testpcr_talento_observacion']),

                        'auditoria_usuario'                         => trim($rowMSSQL00['auditoria_usuario']),
                        'auditoria_fecha_hora'                      => $rowMSSQL00['auditoria_fecha_hora'],
                        'auditoria_ip'                              => trim($rowMSSQL00['auditoria_ip']),

                        'tipo_estado_codigo'                        => $rowMSSQL00['tipo_estado_codigo'],
                        'tipo_estado_orden'                         => $rowMSSQL00['tipo_estado_orden'],
                        'tipo_estado_ingles'                        => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_ingles']))),
                        'tipo_estado_castellano'                    => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_castellano']))),
                        'tipo_estado_portugues'                     => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_portugues']))),
                        'tipo_estado_parametro'                     => $rowMSSQL00['tipo_estado_parametro'],
                        'tipo_estado_icono'                         => trim(strtolower($rowMSSQL00['tipo_estado_icono'])),
                        'tipo_estado_path'                          => trim(strtolower($rowMSSQL00['tipo_estado_path'])),
                        'tipo_estado_css'                           => trim(strtolower($rowMSSQL00['tipo_estado_css'])),
                        'tipo_estado_dominio'                       => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_dominio']))), 
                        'tipo_estado_observacion'                   => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_observacion']))),

                        'tipo_solicitud_codigo'                     => $rowMSSQL00['tipo_solicitud_codigo'],
                        'tipo_solicitud_orden'                      => $rowMSSQL00['tipo_solicitud_orden'],
                        'tipo_solicitud_ingles'                     => trim(strtoupper(strtolower($rowMSSQL00['tipo_solicitud_ingles']))),
                        'tipo_solicitud_castellano'                 => trim(strtoupper(strtolower($rowMSSQL00['tipo_solicitud_castellano']))),
                        'tipo_solicitud_portugues'                  => trim(strtoupper(strtolower($rowMSSQL00['tipo_solicitud_portugues']))),
                        'tipo_solicitud_parametro'                  => $rowMSSQL00['tipo_solicitud_parametro'],
                        'tipo_solicitud_icono'                      => trim(strtolower($rowMSSQL00['tipo_solicitud_icono'])),
                        'tipo_solicitud_path'                       => trim(strtolower($rowMSSQL00['tipo_solicitud_path'])),
                        'tipo_solicitud_css'                        => trim(strtolower($rowMSSQL00['tipo_solicitud_css'])),
                        'tipo_solicitud_dominio'                    => trim(strtoupper(strtolower($rowMSSQL00['tipo_solicitud_dominio']))), 
                        'tipo_solicitud_observacion'                => trim(strtoupper(strtolower($rowMSSQL00['tipo_solicitud_observacion']))),

                        'tipo_rol_codigo'                           => $rowMSSQL00['tipo_rol_codigo'],
                        'tipo_rol_orden'                            => $rowMSSQL00['tipo_rol_orden'],
                        'tipo_rol_ingles'                           => trim(strtoupper(strtolower($rowMSSQL00['tipo_rol_ingles']))),
                        'tipo_rol_castellano'                       => trim(strtoupper(strtolower($rowMSSQL00['tipo_rol_castellano']))),
                        'tipo_rol_portugues'                        => trim(strtoupper(strtolower($rowMSSQL00['tipo_rol_portugues']))),
                        'tipo_rol_parametro'                        => $rowMSSQL00['tipo_rol_parametro'],
                        'tipo_rol_icono'                            => trim(strtolower($rowMSSQL00['tipo_rol_icono'])),
                        'tipo_rol_path'                             => trim(strtolower($rowMSSQL00['tipo_rol_path'])),
                        'tipo_rol_css'                              => trim(strtolower($rowMSSQL00['tipo_rol_css'])),
                        'tipo_rol_dominio'                          => trim(strtoupper(strtolower($rowMSSQL00['tipo_rol_dominio']))), 
                        'tipo_rol_observacion'                      => trim(strtoupper(strtolower($rowMSSQL00['tipo_rol_observacion'])))
                        
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'testpcr_codigo'                            => '',
                        'testpcr_orden'                             => '',
                        'testpcr_solicitante_nombre'                => '',
                        'testpcr_solicitante_apellido'              => '',
                        'testpcr_solicitante_documento'             => '',
                        'testpcr_solicitante_email'                 => '',
                        'testpcr_solicitante_observacion'           => '',
                        'testpcr_jefetura_documento'                => '',
                        'testpcr_fecha_1_1'                         => '',
                        'testpcr_fecha_1_2'                         => '',
                        'testpcr_fecha_2_1'                         => '',
                        'testpcr_fecha_2_2'                         => '',
                        'testpcr_hora_1'                            => '',
                        'testpcr_hora_2'                            => '',
                        'testpcr_adjunto_1'                         => '',
                        'testpcr_adjunto_2'                         => '',
                        'testpcr_adjunto_3'                         => '',
                        'testpcr_adjunto_4'                         => '',
                        'testpcr_laboratorio_nombre'                => '',
                        'testpcr_laboratorio_contacto'              => '', 
                        'testpcr_laboratorio_email'                 => '', 
                        'testpcr_laboratorio_fecha_resultado_1'     => '', 
                        'testpcr_laboratorio_fecha_resultado_2'     => '', 
                        'testpcr_laboratorio_adjunto'               => '',
                        'testpcr_laboratorio_resultado'             => '',
                        'testpcr_laboratorio_observacion'           => '',
                        'testpcr_carga_usuario'                     => '',
                        'testpcr_carga_fecha'                       => '',
                        'testpcr_carga_ip'                          => '',
                        'testpcr_talento_usuario'                   => '',
                        'testpcr_talento_fecha'                     => '',
                        'testpcr_talento_ip'                        => '',
                        'testpcr_talento_observacion'               => '',

                        'auditoria_usuario'                         => '',
                        'auditoria_fecha_hora'                      => '',
                        'auditoria_ip'                              => '',

                        'tipo_estado_codigo'                        => '',
                        'tipo_estado_orden'                         => '',
                        'tipo_estado_ingles'                        => '',
                        'tipo_estado_castellano'                    => '',
                        'tipo_estado_portugues'                     => '',
                        'tipo_estado_parametro'                     => '',
                        'tipo_estado_icono'                         => '',
                        'tipo_estado_path'                          => '',
                        'tipo_estado_css'                           => '',
                        'tipo_estado_dominio'                       => '', 
                        'tipo_estado_observacion'                   => '',

                        'tipo_solicitud_codigo'                     => '',
                        'tipo_solicitud_orden'                      => '',
                        'tipo_solicitud_ingles'                     => '',
                        'tipo_solicitud_castellano'                 => '',
                        'tipo_solicitud_portugues'                  => '',
                        'tipo_solicitud_parametro'                  => '',
                        'tipo_solicitud_icono'                      => '',
                        'tipo_solicitud_path'                       => '',
                        'tipo_solicitud_css'                        => '',
                        'tipo_solicitud_dominio'                    => '', 
                        'tipo_solicitud_observacion'                => '',

                        'tipo_rol_codigo'                           => '',
                        'tipo_rol_orden'                            => '',
                        'tipo_rol_ingles'                           => '',
                        'tipo_rol_castellano'                       => '',
                        'tipo_rol_portugues'                        => '',
                        'tipo_rol_parametro'                        => '',
                        'tipo_rol_icono'                            => '',
                        'tipo_rol_path'                             => '',
                        'tipo_rol_css'                              => '',
                        'tipo_rol_dominio'                          => '', 
                        'tipo_rol_observacion'                      => ''
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

    $app->get('/v1/200/testpcr/documento/{documento}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val00  = $request->getAttribute('documento');
        if (isset($val00)) {
        
            $sql00  = "SELECT 
                a.SOLPCRCOD         AS          testpcr_codigo,
                a.SOLPCRORD         AS          testpcr_orden,
                a.SOLPCRNOM         AS          testpcr_solicitante_nombre,
                a.SOLPCRAPE         AS          testpcr_solicitante_apellido,
                a.SOLPCRDOC         AS          testpcr_solicitante_documento,
                a.SOLPCREMA         AS          testpcr_solicitante_email,
                a.SOLPCROBC         AS          testpcr_solicitante_observacion,
                a.SOLPCRDOJ         AS          testpcr_jefetura_documento,
                a.SOLPCRFE1         AS          testpcr_fecha_1,
                a.SOLPCRFE2         AS          testpcr_fecha_2,
                a.SOLPCRHO1         AS          testpcr_hora_1,
                a.SOLPCRHO2         AS          testpcr_hora_2,
                a.SOLPCRAD1         AS          testpcr_adjunto_1,
                a.SOLPCRAD2         AS          testpcr_adjunto_2,
                a.SOLPCRAD3         AS          testpcr_adjunto_3,
                a.SOLPCRAD4         AS          testpcr_adjunto_4,
                a.SOLPCRLNO         AS          testpcr_laboratorio_nombre,
                a.SOLPCRLCO         AS          testpcr_laboratorio_contacto,
                a.SOLPCRLMA         AS          testpcr_laboratorio_email,
                a.SOLPCRLFR         AS          testpcr_laboratorio_fecha_resultado,
                a.SOLPCRLAD         AS          testpcr_laboratorio_adjunto,
                a.SOLPCRLRE         AS          testpcr_laboratorio_resultado, 
                a.SOLPCRLOB         AS          testpcr_laboratorio_observacion,
                a.SOLPCRUSC         AS          testpcr_carga_usuario,
                a.SOLPCRFEC         AS          testpcr_carga_fecha,
                a.SOLPCRIPC         AS          testpcr_carga_ip,
                a.SOLPCRUST         AS          testpcr_talento_usuario,
                a.SOLPCRFET         AS          testpcr_talento_fecha,
                a.SOLPCRIPT         AS          testpcr_talento_ip,
                a.SOLPCROBT         AS          testpcr_talento_observacion,
                
                a.SOLPCRAUS         AS          auditoria_usuario,
                a.SOLPCRAFH         AS          auditoria_fecha_hora,
                a.SOLPCRAIP         AS          auditoria_ip,
                
                b.DOMFICCOD         AS          tipo_estado_codigo,
                b.DOMFICORD         AS          tipo_estado_orden,
                b.DOMFICNOI         AS          tipo_estado_ingles,
                b.DOMFICNOC         AS          tipo_estado_castellano,
                b.DOMFICNOP         AS          tipo_estado_portugues,
                b.DOMFICPAT         AS          tipo_estado_path,
                b.DOMFICCSS         AS          tipo_estado_css,
                b.DOMFICPAR         AS          tipo_estado_parametro,
                b.DOMFICICO         AS          tipo_estado_icono,
                b.DOMFICVAL         AS          tipo_estado_dominio,
                b.DOMFICOBS         AS          tipo_estado_observacion,
                
                c.DOMFICCOD         AS          tipo_solicitud_codigo,
                c.DOMFICORD         AS          tipo_solicitud_orden,
                c.DOMFICNOI         AS          tipo_solicitud_ingles,
                c.DOMFICNOC         AS          tipo_solicitud_castellano,
                c.DOMFICNOP         AS          tipo_solicitud_portugues,
                c.DOMFICPAT         AS          tipo_solicitud_path,
                c.DOMFICCSS         AS          tipo_solicitud_css,
                c.DOMFICPAR         AS          tipo_solicitud_parametro,
                c.DOMFICICO         AS          tipo_solicitud_icono,
                c.DOMFICVAL         AS          tipo_solicitud_dominio,
                c.DOMFICOBS         AS          tipo_solicitud_observacion,
                
                d.DOMFICCOD         AS          tipo_rol_codigo,
                d.DOMFICORD         AS          tipo_rol_orden,
                d.DOMFICNOI         AS          tipo_rol_ingles,
                d.DOMFICNOC         AS          tipo_rol_castellano,
                d.DOMFICNOP         AS          tipo_rol_portugues,
                d.DOMFICPAT         AS          tipo_rol_path,
                d.DOMFICCSS         AS          tipo_rol_css,
                d.DOMFICPAR         AS          tipo_rol_parametro,
                d.DOMFICICO         AS          tipo_rol_icono,
                d.DOMFICVAL         AS          tipo_rol_dominio,
                d.DOMFICOBS         AS          tipo_rol_observacion
                        
                FROM [hum].[SOLPCR] a

                INNER JOIN adm.DOMFIC b ON a.SOLPCREST = b.DOMFICCOD
                INNER JOIN adm.DOMFIC c ON a.SOLPCRTSC = c.DOMFICCOD
                INNER JOIN adm.DOMFIC d ON a.SOLPCRTRC = d.DOMFICCOD

                WHERE a.SOLPCRDOC = ?
            
                ORDER BY a.SOLPCRCOD DESC";

            try {
                $connMSSQL  = getConnectionMSSQLv1();

                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val00]);
                
                while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                    if ($rowMSSQL00['testpcr_fecha_1'] == '1900-01-01' || $rowMSSQL00['testpcr_fecha_1'] == null){
                        $testpcr_fecha_1_1 = '';
                        $testpcr_fecha_1_2 = '';
                    } else {
                        $testpcr_fecha_1_1 = $rowMSSQL00['testpcr_fecha_1'];
                        $testpcr_fecha_1_2 = date('d/m/Y', strtotime($rowMSSQL00['testpcr_fecha_1']));
                    }

                    if ($rowMSSQL00['testpcr_fecha_2'] == '1900-01-01' || $rowMSSQL00['testpcr_fecha_2'] == null){
                        $testpcr_fecha_2_1 = '';
                        $testpcr_fecha_2_2 = '';
                    } else {
                        $testpcr_fecha_2_1 = $rowMSSQL00['testpcr_fecha_2'];
                        $testpcr_fecha_2_2 = date('d/m/Y', strtotime($rowMSSQL00['testpcr_fecha_2']));
                    }

                    if ($rowMSSQL00['testpcr_laboratorio_fecha_resultado'] == '1900-01-01' || $rowMSSQL00['testpcr_laboratorio_fecha_resultado'] == null){
                        $testpcr_laboratorio_fecha_resultado_1 = '';
                        $testpcr_laboratorio_fecha_resultado_2 = '';
                    } else {
                        $testpcr_laboratorio_fecha_resultado_1 = $rowMSSQL00['testpcr_laboratorio_fecha_resultado'];
                        $testpcr_laboratorio_fecha_resultado_2 = date('d/m/Y', strtotime($rowMSSQL00['testpcr_laboratorio_fecha_resultado']));
                    }

                    $detalle    = array(
                        'testpcr_codigo'                            => $rowMSSQL00['testpcr_codigo'],
                        'testpcr_orden'                             => $rowMSSQL00['testpcr_orden'],
                        'testpcr_solicitante_nombre'                => trim($rowMSSQL00['testpcr_solicitante_nombre']),
                        'testpcr_solicitante_apellido'              => trim($rowMSSQL00['testpcr_solicitante_apellido']),
                        'testpcr_solicitante_documento'             => trim(strtoupper(strtolower($rowMSSQL00['testpcr_solicitante_documento']))),
                        'testpcr_solicitante_email'                 => trim(strtolower($rowMSSQL00['testpcr_solicitante_email'])),
                        'testpcr_solicitante_observacion'           => trim($rowMSSQL00['testpcr_solicitante_observacion']),
                        'testpcr_jefetura_documento'                => trim(strtoupper(strtolower($rowMSSQL00['testpcr_jefetura_documento']))),
                        'testpcr_fecha_1_1'                         => $testpcr_fecha_1_1,
                        'testpcr_fecha_1_2'                         => $testpcr_fecha_1_2,
                        'testpcr_fecha_2_1'                         => $testpcr_fecha_2_1,
                        'testpcr_fecha_2_2'                         => $testpcr_fecha_2_2,
                        'testpcr_hora_1'                            => trim($rowMSSQL00['testpcr_hora_1']),
                        'testpcr_hora_2'                            => trim($rowMSSQL00['testpcr_hora_2']),
                        'testpcr_adjunto_1'                         => trim(strtoupper($rowMSSQL00['testpcr_adjunto_1'])),
                        'testpcr_adjunto_2'                         => trim(strtoupper($rowMSSQL00['testpcr_adjunto_2'])),
                        'testpcr_adjunto_3'                         => trim(strtoupper($rowMSSQL00['testpcr_adjunto_3'])),
                        'testpcr_adjunto_4'                         => trim(strtoupper($rowMSSQL00['testpcr_adjunto_4'])),
                        'testpcr_laboratorio_nombre'                => trim($rowMSSQL00['testpcr_laboratorio_nombre']),
                        'testpcr_laboratorio_contacto'              => trim($rowMSSQL00['testpcr_laboratorio_contacto']), 
                        'testpcr_laboratorio_email'                 => trim($rowMSSQL00['testpcr_laboratorio_email']), 
                        'testpcr_laboratorio_fecha_resultado_1'     => $testpcr_laboratorio_fecha_resultado_1, 
                        'testpcr_laboratorio_fecha_resultado_2'     => $testpcr_laboratorio_fecha_resultado_2, 
                        'testpcr_laboratorio_adjunto'               => trim(strtoupper($rowMSSQL00['testpcr_laboratorio_adjunto'])),
                        'testpcr_laboratorio_resultado'             => trim(strtoupper(strtolower($rowMSSQL00['testpcr_laboratorio_resultado']))),
                        'testpcr_laboratorio_observacion'           => trim($rowMSSQL00['testpcr_laboratorio_observacion']),
                        'testpcr_carga_usuario'                     => trim($rowMSSQL00['testpcr_carga_usuario']),
                        'testpcr_carga_fecha'                       => $rowMSSQL00['testpcr_carga_fecha'],
                        'testpcr_carga_ip'                          => trim($rowMSSQL00['testpcr_carga_ip']),
                        'testpcr_talento_usuario'                   => trim($rowMSSQL00['testpcr_talento_usuario']),
                        'testpcr_talento_fecha'                     => $rowMSSQL00['testpcr_talento_fecha'],
                        'testpcr_talento_ip'                        => trim($rowMSSQL00['testpcr_talento_ip']),
                        'testpcr_talento_observacion'               => trim($rowMSSQL00['testpcr_talento_observacion']),

                        'auditoria_usuario'                         => trim($rowMSSQL00['auditoria_usuario']),
                        'auditoria_fecha_hora'                      => $rowMSSQL00['auditoria_fecha_hora'],
                        'auditoria_ip'                              => trim($rowMSSQL00['auditoria_ip']),

                        'tipo_estado_codigo'                        => $rowMSSQL00['tipo_estado_codigo'],
                        'tipo_estado_orden'                         => $rowMSSQL00['tipo_estado_orden'],
                        'tipo_estado_ingles'                        => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_ingles']))),
                        'tipo_estado_castellano'                    => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_castellano']))),
                        'tipo_estado_portugues'                     => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_portugues']))),
                        'tipo_estado_parametro'                     => $rowMSSQL00['tipo_estado_parametro'],
                        'tipo_estado_icono'                         => trim(strtolower($rowMSSQL00['tipo_estado_icono'])),
                        'tipo_estado_path'                          => trim(strtolower($rowMSSQL00['tipo_estado_path'])),
                        'tipo_estado_css'                           => trim(strtolower($rowMSSQL00['tipo_estado_css'])),
                        'tipo_estado_dominio'                       => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_dominio']))), 
                        'tipo_estado_observacion'                   => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_observacion']))),

                        'tipo_solicitud_codigo'                     => $rowMSSQL00['tipo_solicitud_codigo'],
                        'tipo_solicitud_orden'                      => $rowMSSQL00['tipo_solicitud_orden'],
                        'tipo_solicitud_ingles'                     => trim(strtoupper(strtolower($rowMSSQL00['tipo_solicitud_ingles']))),
                        'tipo_solicitud_castellano'                 => trim(strtoupper(strtolower($rowMSSQL00['tipo_solicitud_castellano']))),
                        'tipo_solicitud_portugues'                  => trim(strtoupper(strtolower($rowMSSQL00['tipo_solicitud_portugues']))),
                        'tipo_solicitud_parametro'                  => $rowMSSQL00['tipo_solicitud_parametro'],
                        'tipo_solicitud_icono'                      => trim(strtolower($rowMSSQL00['tipo_solicitud_icono'])),
                        'tipo_solicitud_path'                       => trim(strtolower($rowMSSQL00['tipo_solicitud_path'])),
                        'tipo_solicitud_css'                        => trim(strtolower($rowMSSQL00['tipo_solicitud_css'])),
                        'tipo_solicitud_dominio'                    => trim(strtoupper(strtolower($rowMSSQL00['tipo_solicitud_dominio']))), 
                        'tipo_solicitud_observacion'                => trim(strtoupper(strtolower($rowMSSQL00['tipo_solicitud_observacion']))),

                        'tipo_rol_codigo'                           => $rowMSSQL00['tipo_rol_codigo'],
                        'tipo_rol_orden'                            => $rowMSSQL00['tipo_rol_orden'],
                        'tipo_rol_ingles'                           => trim(strtoupper(strtolower($rowMSSQL00['tipo_rol_ingles']))),
                        'tipo_rol_castellano'                       => trim(strtoupper(strtolower($rowMSSQL00['tipo_rol_castellano']))),
                        'tipo_rol_portugues'                        => trim(strtoupper(strtolower($rowMSSQL00['tipo_rol_portugues']))),
                        'tipo_rol_parametro'                        => $rowMSSQL00['tipo_rol_parametro'],
                        'tipo_rol_icono'                            => trim(strtolower($rowMSSQL00['tipo_rol_icono'])),
                        'tipo_rol_path'                             => trim(strtolower($rowMSSQL00['tipo_rol_path'])),
                        'tipo_rol_css'                              => trim(strtolower($rowMSSQL00['tipo_rol_css'])),
                        'tipo_rol_dominio'                          => trim(strtoupper(strtolower($rowMSSQL00['tipo_rol_dominio']))), 
                        'tipo_rol_observacion'                      => trim(strtoupper(strtolower($rowMSSQL00['tipo_rol_observacion'])))
                        
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'testpcr_codigo'                            => '',
                        'testpcr_orden'                             => '',
                        'testpcr_solicitante_nombre'                => '',
                        'testpcr_solicitante_apellido'              => '',
                        'testpcr_solicitante_documento'             => '',
                        'testpcr_solicitante_email'                 => '',
                        'testpcr_solicitante_observacion'           => '',
                        'testpcr_jefetura_documento'                => '',
                        'testpcr_fecha_1_1'                         => '',
                        'testpcr_fecha_1_2'                         => '',
                        'testpcr_fecha_2_1'                         => '',
                        'testpcr_fecha_2_2'                         => '',
                        'testpcr_hora_1'                            => '',
                        'testpcr_hora_2'                            => '',
                        'testpcr_adjunto_1'                         => '',
                        'testpcr_adjunto_2'                         => '',
                        'testpcr_adjunto_3'                         => '',
                        'testpcr_adjunto_4'                         => '',
                        'testpcr_laboratorio_nombre'                => '',
                        'testpcr_laboratorio_contacto'              => '', 
                        'testpcr_laboratorio_email'                 => '', 
                        'testpcr_laboratorio_fecha_resultado_1'     => '', 
                        'testpcr_laboratorio_fecha_resultado_2'     => '', 
                        'testpcr_laboratorio_adjunto'               => '',
                        'testpcr_laboratorio_resultado'             => '',
                        'testpcr_laboratorio_observacion'           => '',
                        'testpcr_carga_usuario'                     => '',
                        'testpcr_carga_fecha'                       => '',
                        'testpcr_carga_ip'                          => '',
                        'testpcr_talento_usuario'                   => '',
                        'testpcr_talento_fecha'                     => '',
                        'testpcr_talento_ip'                        => '',
                        'testpcr_talento_observacion'               => '',

                        'auditoria_usuario'                         => '',
                        'auditoria_fecha_hora'                      => '',
                        'auditoria_ip'                              => '',

                        'tipo_estado_codigo'                        => '',
                        'tipo_estado_orden'                         => '',
                        'tipo_estado_ingles'                        => '',
                        'tipo_estado_castellano'                    => '',
                        'tipo_estado_portugues'                     => '',
                        'tipo_estado_parametro'                     => '',
                        'tipo_estado_icono'                         => '',
                        'tipo_estado_path'                          => '',
                        'tipo_estado_css'                           => '',
                        'tipo_estado_dominio'                       => '', 
                        'tipo_estado_observacion'                   => '',

                        'tipo_solicitud_codigo'                     => '',
                        'tipo_solicitud_orden'                      => '',
                        'tipo_solicitud_ingles'                     => '',
                        'tipo_solicitud_castellano'                 => '',
                        'tipo_solicitud_portugues'                  => '',
                        'tipo_solicitud_parametro'                  => '',
                        'tipo_solicitud_icono'                      => '',
                        'tipo_solicitud_path'                       => '',
                        'tipo_solicitud_css'                        => '',
                        'tipo_solicitud_dominio'                    => '', 
                        'tipo_solicitud_observacion'                => '',

                        'tipo_rol_codigo'                           => '',
                        'tipo_rol_orden'                            => '',
                        'tipo_rol_ingles'                           => '',
                        'tipo_rol_castellano'                       => '',
                        'tipo_rol_portugues'                        => '',
                        'tipo_rol_parametro'                        => '',
                        'tipo_rol_icono'                            => '',
                        'tipo_rol_path'                             => '',
                        'tipo_rol_css'                              => '',
                        'tipo_rol_dominio'                          => '', 
                        'tipo_rol_observacion'                      => ''
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

    $app->get('/v1/200/testpcr/jefatura/{documento}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val00  = $request->getAttribute('documento');
        if (isset($val00)) {
        
            $sql00  = "SELECT 
                a.SOLPCRCOD         AS          testpcr_codigo,
                a.SOLPCRORD         AS          testpcr_orden,
                a.SOLPCRNOM         AS          testpcr_solicitante_nombre,
                a.SOLPCRAPE         AS          testpcr_solicitante_apellido,
                a.SOLPCRDOC         AS          testpcr_solicitante_documento,
                a.SOLPCREMA         AS          testpcr_solicitante_email,
                a.SOLPCROBC         AS          testpcr_solicitante_observacion,
                a.SOLPCRDOJ         AS          testpcr_jefetura_documento,
                a.SOLPCRFE1         AS          testpcr_fecha_1,
                a.SOLPCRFE2         AS          testpcr_fecha_2,
                a.SOLPCRHO1         AS          testpcr_hora_1,
                a.SOLPCRHO2         AS          testpcr_hora_2,
                a.SOLPCRAD1         AS          testpcr_adjunto_1,
                a.SOLPCRAD2         AS          testpcr_adjunto_2,
                a.SOLPCRAD3         AS          testpcr_adjunto_3,
                a.SOLPCRAD4         AS          testpcr_adjunto_4,
                a.SOLPCRLNO         AS          testpcr_laboratorio_nombre,
                a.SOLPCRLCO         AS          testpcr_laboratorio_contacto,
                a.SOLPCRLMA         AS          testpcr_laboratorio_email,
                a.SOLPCRLFR         AS          testpcr_laboratorio_fecha_resultado,
                a.SOLPCRLAD         AS          testpcr_laboratorio_adjunto,
                a.SOLPCRLRE         AS          testpcr_laboratorio_resultado, 
                a.SOLPCRLOB         AS          testpcr_laboratorio_observacion,
                a.SOLPCRUSC         AS          testpcr_carga_usuario,
                a.SOLPCRFEC         AS          testpcr_carga_fecha,
                a.SOLPCRIPC         AS          testpcr_carga_ip,
                a.SOLPCRUST         AS          testpcr_talento_usuario,
                a.SOLPCRFET         AS          testpcr_talento_fecha,
                a.SOLPCRIPT         AS          testpcr_talento_ip,
                a.SOLPCROBT         AS          testpcr_talento_observacion,
                
                a.SOLPCRAUS         AS          auditoria_usuario,
                a.SOLPCRAFH         AS          auditoria_fecha_hora,
                a.SOLPCRAIP         AS          auditoria_ip,
                
                b.DOMFICCOD         AS          tipo_estado_codigo,
                b.DOMFICORD         AS          tipo_estado_orden,
                b.DOMFICNOI         AS          tipo_estado_ingles,
                b.DOMFICNOC         AS          tipo_estado_castellano,
                b.DOMFICNOP         AS          tipo_estado_portugues,
                b.DOMFICPAT         AS          tipo_estado_path,
                b.DOMFICCSS         AS          tipo_estado_css,
                b.DOMFICPAR         AS          tipo_estado_parametro,
                b.DOMFICICO         AS          tipo_estado_icono,
                b.DOMFICVAL         AS          tipo_estado_dominio,
                b.DOMFICOBS         AS          tipo_estado_observacion,
                
                c.DOMFICCOD         AS          tipo_solicitud_codigo,
                c.DOMFICORD         AS          tipo_solicitud_orden,
                c.DOMFICNOI         AS          tipo_solicitud_ingles,
                c.DOMFICNOC         AS          tipo_solicitud_castellano,
                c.DOMFICNOP         AS          tipo_solicitud_portugues,
                c.DOMFICPAT         AS          tipo_solicitud_path,
                c.DOMFICCSS         AS          tipo_solicitud_css,
                c.DOMFICPAR         AS          tipo_solicitud_parametro,
                c.DOMFICICO         AS          tipo_solicitud_icono,
                c.DOMFICVAL         AS          tipo_solicitud_dominio,
                c.DOMFICOBS         AS          tipo_solicitud_observacion,
                
                d.DOMFICCOD         AS          tipo_rol_codigo,
                d.DOMFICORD         AS          tipo_rol_orden,
                d.DOMFICNOI         AS          tipo_rol_ingles,
                d.DOMFICNOC         AS          tipo_rol_castellano,
                d.DOMFICNOP         AS          tipo_rol_portugues,
                d.DOMFICPAT         AS          tipo_rol_path,
                d.DOMFICCSS         AS          tipo_rol_css,
                d.DOMFICPAR         AS          tipo_rol_parametro,
                d.DOMFICICO         AS          tipo_rol_icono,
                d.DOMFICVAL         AS          tipo_rol_dominio,
                d.DOMFICOBS         AS          tipo_rol_observacion
                        
                FROM [hum].[SOLPCR] a

                INNER JOIN adm.DOMFIC b ON a.SOLPCREST = b.DOMFICCOD
                INNER JOIN adm.DOMFIC c ON a.SOLPCRTSC = c.DOMFICCOD
                INNER JOIN adm.DOMFIC d ON a.SOLPCRTRC = d.DOMFICCOD

                WHERE a.SOLPCRDOJ = ?
            
                ORDER BY a.SOLPCRCOD DESC";

            try {
                $connMSSQL  = getConnectionMSSQLv1();

                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val00]);
                
                while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                    if ($rowMSSQL00['testpcr_fecha_1'] == '1900-01-01' || $rowMSSQL00['testpcr_fecha_1'] == null){
                        $testpcr_fecha_1_1 = '';
                        $testpcr_fecha_1_2 = '';
                    } else {
                        $testpcr_fecha_1_1 = $rowMSSQL00['testpcr_fecha_1'];
                        $testpcr_fecha_1_2 = date('d/m/Y', strtotime($rowMSSQL00['testpcr_fecha_1']));
                    }

                    if ($rowMSSQL00['testpcr_fecha_2'] == '1900-01-01' || $rowMSSQL00['testpcr_fecha_2'] == null){
                        $testpcr_fecha_2_1 = '';
                        $testpcr_fecha_2_2 = '';
                    } else {
                        $testpcr_fecha_2_1 = $rowMSSQL00['testpcr_fecha_2'];
                        $testpcr_fecha_2_2 = date('d/m/Y', strtotime($rowMSSQL00['testpcr_fecha_2']));
                    }

                    if ($rowMSSQL00['testpcr_laboratorio_fecha_resultado'] == '1900-01-01' || $rowMSSQL00['testpcr_laboratorio_fecha_resultado'] == null){
                        $testpcr_laboratorio_fecha_resultado_1 = '';
                        $testpcr_laboratorio_fecha_resultado_2 = '';
                    } else {
                        $testpcr_laboratorio_fecha_resultado_1 = $rowMSSQL00['testpcr_laboratorio_fecha_resultado'];
                        $testpcr_laboratorio_fecha_resultado_2 = date('d/m/Y', strtotime($rowMSSQL00['testpcr_laboratorio_fecha_resultado']));
                    }

                    $detalle    = array(
                        'testpcr_codigo'                            => $rowMSSQL00['testpcr_codigo'],
                        'testpcr_orden'                             => $rowMSSQL00['testpcr_orden'],
                        'testpcr_solicitante_nombre'                => trim($rowMSSQL00['testpcr_solicitante_nombre']),
                        'testpcr_solicitante_apellido'              => trim($rowMSSQL00['testpcr_solicitante_apellido']),
                        'testpcr_solicitante_documento'             => trim(strtoupper(strtolower($rowMSSQL00['testpcr_solicitante_documento']))),
                        'testpcr_solicitante_email'                 => trim(strtolower($rowMSSQL00['testpcr_solicitante_email'])),
                        'testpcr_solicitante_observacion'           => trim($rowMSSQL00['testpcr_solicitante_observacion']),
                        'testpcr_jefetura_documento'                => trim(strtoupper(strtolower($rowMSSQL00['testpcr_jefetura_documento']))),
                        'testpcr_fecha_1_1'                         => $testpcr_fecha_1_1,
                        'testpcr_fecha_1_2'                         => $testpcr_fecha_1_2,
                        'testpcr_fecha_2_1'                         => $testpcr_fecha_2_1,
                        'testpcr_fecha_2_2'                         => $testpcr_fecha_2_2,
                        'testpcr_hora_1'                            => trim($rowMSSQL00['testpcr_hora_1']),
                        'testpcr_hora_2'                            => trim($rowMSSQL00['testpcr_hora_2']),
                        'testpcr_adjunto_1'                         => trim(strtoupper($rowMSSQL00['testpcr_adjunto_1'])),
                        'testpcr_adjunto_2'                         => trim(strtoupper($rowMSSQL00['testpcr_adjunto_2'])),
                        'testpcr_adjunto_3'                         => trim(strtoupper($rowMSSQL00['testpcr_adjunto_3'])),
                        'testpcr_adjunto_4'                         => trim(strtoupper($rowMSSQL00['testpcr_adjunto_4'])),
                        'testpcr_laboratorio_nombre'                => trim($rowMSSQL00['testpcr_laboratorio_nombre']),
                        'testpcr_laboratorio_contacto'              => trim($rowMSSQL00['testpcr_laboratorio_contacto']), 
                        'testpcr_laboratorio_email'                 => trim($rowMSSQL00['testpcr_laboratorio_email']), 
                        'testpcr_laboratorio_fecha_resultado_1'     => $testpcr_laboratorio_fecha_resultado_1, 
                        'testpcr_laboratorio_fecha_resultado_2'     => $testpcr_laboratorio_fecha_resultado_2, 
                        'testpcr_laboratorio_adjunto'               => trim(strtoupper($rowMSSQL00['testpcr_laboratorio_adjunto'])),
                        'testpcr_laboratorio_resultado'             => trim(strtoupper(strtolower($rowMSSQL00['testpcr_laboratorio_resultado']))),
                        'testpcr_laboratorio_observacion'           => trim($rowMSSQL00['testpcr_laboratorio_observacion']),
                        'testpcr_carga_usuario'                     => trim($rowMSSQL00['testpcr_carga_usuario']),
                        'testpcr_carga_fecha'                       => $rowMSSQL00['testpcr_carga_fecha'],
                        'testpcr_carga_ip'                          => trim($rowMSSQL00['testpcr_carga_ip']),
                        'testpcr_talento_usuario'                   => trim($rowMSSQL00['testpcr_talento_usuario']),
                        'testpcr_talento_fecha'                     => $rowMSSQL00['testpcr_talento_fecha'],
                        'testpcr_talento_ip'                        => trim($rowMSSQL00['testpcr_talento_ip']),
                        'testpcr_talento_observacion'               => trim($rowMSSQL00['testpcr_talento_observacion']),

                        'auditoria_usuario'                         => trim($rowMSSQL00['auditoria_usuario']),
                        'auditoria_fecha_hora'                      => $rowMSSQL00['auditoria_fecha_hora'],
                        'auditoria_ip'                              => trim($rowMSSQL00['auditoria_ip']),

                        'tipo_estado_codigo'                        => $rowMSSQL00['tipo_estado_codigo'],
                        'tipo_estado_orden'                         => $rowMSSQL00['tipo_estado_orden'],
                        'tipo_estado_ingles'                        => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_ingles']))),
                        'tipo_estado_castellano'                    => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_castellano']))),
                        'tipo_estado_portugues'                     => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_portugues']))),
                        'tipo_estado_parametro'                     => $rowMSSQL00['tipo_estado_parametro'],
                        'tipo_estado_icono'                         => trim(strtolower($rowMSSQL00['tipo_estado_icono'])),
                        'tipo_estado_path'                          => trim(strtolower($rowMSSQL00['tipo_estado_path'])),
                        'tipo_estado_css'                           => trim(strtolower($rowMSSQL00['tipo_estado_css'])),
                        'tipo_estado_dominio'                       => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_dominio']))), 
                        'tipo_estado_observacion'                   => trim(strtoupper(strtolower($rowMSSQL00['tipo_estado_observacion']))),

                        'tipo_solicitud_codigo'                     => $rowMSSQL00['tipo_solicitud_codigo'],
                        'tipo_solicitud_orden'                      => $rowMSSQL00['tipo_solicitud_orden'],
                        'tipo_solicitud_ingles'                     => trim(strtoupper(strtolower($rowMSSQL00['tipo_solicitud_ingles']))),
                        'tipo_solicitud_castellano'                 => trim(strtoupper(strtolower($rowMSSQL00['tipo_solicitud_castellano']))),
                        'tipo_solicitud_portugues'                  => trim(strtoupper(strtolower($rowMSSQL00['tipo_solicitud_portugues']))),
                        'tipo_solicitud_parametro'                  => $rowMSSQL00['tipo_solicitud_parametro'],
                        'tipo_solicitud_icono'                      => trim(strtolower($rowMSSQL00['tipo_solicitud_icono'])),
                        'tipo_solicitud_path'                       => trim(strtolower($rowMSSQL00['tipo_solicitud_path'])),
                        'tipo_solicitud_css'                        => trim(strtolower($rowMSSQL00['tipo_solicitud_css'])),
                        'tipo_solicitud_dominio'                    => trim(strtoupper(strtolower($rowMSSQL00['tipo_solicitud_dominio']))), 
                        'tipo_solicitud_observacion'                => trim(strtoupper(strtolower($rowMSSQL00['tipo_solicitud_observacion']))),

                        'tipo_rol_codigo'                           => $rowMSSQL00['tipo_rol_codigo'],
                        'tipo_rol_orden'                            => $rowMSSQL00['tipo_rol_orden'],
                        'tipo_rol_ingles'                           => trim(strtoupper(strtolower($rowMSSQL00['tipo_rol_ingles']))),
                        'tipo_rol_castellano'                       => trim(strtoupper(strtolower($rowMSSQL00['tipo_rol_castellano']))),
                        'tipo_rol_portugues'                        => trim(strtoupper(strtolower($rowMSSQL00['tipo_rol_portugues']))),
                        'tipo_rol_parametro'                        => $rowMSSQL00['tipo_rol_parametro'],
                        'tipo_rol_icono'                            => trim(strtolower($rowMSSQL00['tipo_rol_icono'])),
                        'tipo_rol_path'                             => trim(strtolower($rowMSSQL00['tipo_rol_path'])),
                        'tipo_rol_css'                              => trim(strtolower($rowMSSQL00['tipo_rol_css'])),
                        'tipo_rol_dominio'                          => trim(strtoupper(strtolower($rowMSSQL00['tipo_rol_dominio']))), 
                        'tipo_rol_observacion'                      => trim(strtoupper(strtolower($rowMSSQL00['tipo_rol_observacion'])))
                        
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'testpcr_codigo'                            => '',
                        'testpcr_orden'                             => '',
                        'testpcr_solicitante_nombre'                => '',
                        'testpcr_solicitante_apellido'              => '',
                        'testpcr_solicitante_documento'             => '',
                        'testpcr_solicitante_email'                 => '',
                        'testpcr_solicitante_observacion'           => '',
                        'testpcr_jefetura_documento'                => '',
                        'testpcr_fecha_1_1'                         => '',
                        'testpcr_fecha_1_2'                         => '',
                        'testpcr_fecha_2_1'                         => '',
                        'testpcr_fecha_2_2'                         => '',
                        'testpcr_hora_1'                            => '',
                        'testpcr_hora_2'                            => '',
                        'testpcr_adjunto_1'                         => '',
                        'testpcr_adjunto_2'                         => '',
                        'testpcr_adjunto_3'                         => '',
                        'testpcr_adjunto_4'                         => '',
                        'testpcr_laboratorio_nombre'                => '',
                        'testpcr_laboratorio_contacto'              => '', 
                        'testpcr_laboratorio_email'                 => '', 
                        'testpcr_laboratorio_fecha_resultado_1'     => '', 
                        'testpcr_laboratorio_fecha_resultado_2'     => '', 
                        'testpcr_laboratorio_adjunto'               => '',
                        'testpcr_laboratorio_resultado'             => '',
                        'testpcr_laboratorio_observacion'           => '',
                        'testpcr_carga_usuario'                     => '',
                        'testpcr_carga_fecha'                       => '',
                        'testpcr_carga_ip'                          => '',
                        'testpcr_talento_usuario'                   => '',
                        'testpcr_talento_fecha'                     => '',
                        'testpcr_talento_ip'                        => '',
                        'testpcr_talento_observacion'               => '',

                        'auditoria_usuario'                         => '',
                        'auditoria_fecha_hora'                      => '',
                        'auditoria_ip'                              => '',

                        'tipo_estado_codigo'                        => '',
                        'tipo_estado_orden'                         => '',
                        'tipo_estado_ingles'                        => '',
                        'tipo_estado_castellano'                    => '',
                        'tipo_estado_portugues'                     => '',
                        'tipo_estado_parametro'                     => '',
                        'tipo_estado_icono'                         => '',
                        'tipo_estado_path'                          => '',
                        'tipo_estado_css'                           => '',
                        'tipo_estado_dominio'                       => '', 
                        'tipo_estado_observacion'                   => '',

                        'tipo_solicitud_codigo'                     => '',
                        'tipo_solicitud_orden'                      => '',
                        'tipo_solicitud_ingles'                     => '',
                        'tipo_solicitud_castellano'                 => '',
                        'tipo_solicitud_portugues'                  => '',
                        'tipo_solicitud_parametro'                  => '',
                        'tipo_solicitud_icono'                      => '',
                        'tipo_solicitud_path'                       => '',
                        'tipo_solicitud_css'                        => '',
                        'tipo_solicitud_dominio'                    => '', 
                        'tipo_solicitud_observacion'                => '',

                        'tipo_rol_codigo'                           => '',
                        'tipo_rol_orden'                            => '',
                        'tipo_rol_ingles'                           => '',
                        'tipo_rol_castellano'                       => '',
                        'tipo_rol_portugues'                        => '',
                        'tipo_rol_parametro'                        => '',
                        'tipo_rol_icono'                            => '',
                        'tipo_rol_path'                             => '',
                        'tipo_rol_css'                              => '',
                        'tipo_rol_dominio'                          => '', 
                        'tipo_rol_observacion'                      => ''
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
//MODULO PORTAL PERMISO