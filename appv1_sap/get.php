<?php
    $app->get('/v1/000/permiso', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $sql00  = "SELECT
        a.CODE                  AS          tipo_permiso_codigo,
        a.NAME                  AS          tipo_permiso_codigo_nombre,
        a.U_CODIGO              AS          tipo_permiso_codigo_referencia,
        a.U_NOMBRE              AS          tipo_permiso_nombre,
        a.U_CODINA              AS          tipo_permiso_coordina,
        a.U_CALIFICA            AS          tipo_permiso_califica,
        a.U_PERIODO             AS          tipo_permiso_periodo,
        a.U_CANPER              AS          tipo_permiso_cantidad
        
        FROM [CSF_PRUEBA].[dbo].[@A1A_TIPE] a

        ORDER BY a.U_CODIGO";

        try {
            $connMSSQL  = getConnectionMSSQLv1();
            $stmtMSSQL  = $connMSSQL->prepare($sql00);
            $stmtMSSQL->execute(); 

            while ($rowMSSQL = $stmtMSSQL->fetch()) {
                $detalle    = array(
                    'tipo_permiso_codigo'                       => $rowMSSQL['tipo_permiso_codigo'],
                    'tipo_permiso_codigo_nombre'                => $rowMSSQL['tipo_permiso_codigo_nombre'],
                    'tipo_permiso_codigo_referencia'            => trim(strtoupper($rowMSSQL['tipo_permiso_codigo_referencia'])),
                    'tipo_permiso_nombre'                       => trim(strtoupper($rowMSSQL['tipo_permiso_nombre'])),
                    'tipo_permiso_coordina'                     => trim(strtoupper($rowMSSQL['tipo_permiso_coordina'])),
                    'tipo_permiso_califica'                     => trim(strtoupper($rowMSSQL['tipo_permiso_califica'])),
                    'tipo_permiso_periodo'                      => trim(strtoupper($rowMSSQL['tipo_permiso_periodo'])),
                    'tipo_permiso_cantidad'                     => $rowMSSQL['tipo_permiso_cantidad']
                );

                $result[]   = $detalle;
            }

            if (isset($result)){
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } else {
                $detalle = array(
                    'tipo_permiso_codigo'                       => '',
                    'tipo_permiso_codigo_nombre'                => '',
                    'tipo_permiso_codigo_referencia'            => '',
                    'tipo_permiso_nombre'                       => '',
                    'tipo_permiso_coordina'                     => '',
                    'tipo_permiso_califica'                     => '',
                    'tipo_permiso_periodo'                      => '',
                    'tipo_permiso_cantidad'                     => ''
                );

                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }

            $stmtMSSQL->closeCursor();
            $stmtMSSQL = null;
        } catch (PDOException $e) {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v1/000/permiso/codigo/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
            a.CODE                  AS          tipo_permiso_codigo,
            a.NAME                  AS          tipo_permiso_codigo_nombre,
            a.U_CODIGO              AS          tipo_permiso_codigo_referencia,
            a.U_NOMBRE              AS          tipo_permiso_nombre,
            a.U_CODINA              AS          tipo_permiso_coordina,
            a.U_CALIFICA            AS          tipo_permiso_califica,
            a.U_PERIODO             AS          tipo_permiso_periodo,
            a.U_CANPER              AS          tipo_permiso_cantidad
            
            FROM [CSF_PRUEBA].[dbo].[@A1A_TIPE] a

            WHERE a.CODE = ?

            ORDER BY a.U_CODIGO";

            try {
                $connMSSQL  = getConnectionMSSQLv1();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01]); 

                while ($rowMSSQL = $stmtMSSQL->fetch()) {
                    $detalle    = array(
                        'tipo_permiso_codigo'                       => $rowMSSQL['tipo_permiso_codigo'],
                        'tipo_permiso_codigo_nombre'                => $rowMSSQL['tipo_permiso_codigo_nombre'],
                        'tipo_permiso_codigo_referencia'            => trim(strtoupper($rowMSSQL['tipo_permiso_codigo_referencia'])),
                        'tipo_permiso_nombre'                       => trim(strtoupper($rowMSSQL['tipo_permiso_nombre'])),
                        'tipo_permiso_coordina'                     => trim(strtoupper($rowMSSQL['tipo_permiso_coordina'])),
                        'tipo_permiso_califica'                     => trim(strtoupper($rowMSSQL['tipo_permiso_califica'])),
                        'tipo_permiso_periodo'                      => trim(strtoupper($rowMSSQL['tipo_permiso_periodo'])),
                        'tipo_permiso_cantidad'                     => $rowMSSQL['tipo_permiso_cantidad']
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'tipo_permiso_codigo'                       => '',
                        'tipo_permiso_codigo_nombre'                => '',
                        'tipo_permiso_codigo_referencia'            => '',
                        'tipo_permiso_nombre'                       => '',
                        'tipo_permiso_coordina'                     => '',
                        'tipo_permiso_califica'                     => '',
                        'tipo_permiso_periodo'                      => '',
                        'tipo_permiso_cantidad'                     => ''
                    );

                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                }

                $stmtMSSQL->closeCursor();
                $stmtMSSQL = null;
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

    $app->get('/v1/000/permiso/referencia/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
            a.CODE                  AS          tipo_permiso_codigo,
            a.NAME                  AS          tipo_permiso_codigo_nombre,
            a.U_CODIGO              AS          tipo_permiso_codigo_referencia,
            a.U_NOMBRE              AS          tipo_permiso_nombre,
            a.U_CODINA              AS          tipo_permiso_coordina,
            a.U_CALIFICA            AS          tipo_permiso_califica,
            a.U_PERIODO             AS          tipo_permiso_periodo,
            a.U_CANPER              AS          tipo_permiso_cantidad
            
            FROM [CSF_PRUEBA].[dbo].[@A1A_TIPE] a

            WHERE a.U_CODIGO = ?

            ORDER BY a.U_CODIGO";

            try {
                $connMSSQL  = getConnectionMSSQLv1();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01]); 

                while ($rowMSSQL = $stmtMSSQL->fetch()) {
                    $detalle    = array(
                        'tipo_permiso_codigo'                       => $rowMSSQL['tipo_permiso_codigo'],
                        'tipo_permiso_codigo_nombre'                => $rowMSSQL['tipo_permiso_codigo_nombre'],
                        'tipo_permiso_codigo_referencia'            => trim(strtoupper($rowMSSQL['tipo_permiso_codigo_referencia'])),
                        'tipo_permiso_nombre'                       => trim(strtoupper($rowMSSQL['tipo_permiso_nombre'])),
                        'tipo_permiso_coordina'                     => trim(strtoupper($rowMSSQL['tipo_permiso_coordina'])),
                        'tipo_permiso_califica'                     => trim(strtoupper($rowMSSQL['tipo_permiso_califica'])),
                        'tipo_permiso_periodo'                      => trim(strtoupper($rowMSSQL['tipo_permiso_periodo'])),
                        'tipo_permiso_cantidad'                     => $rowMSSQL['tipo_permiso_cantidad']
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'tipo_permiso_codigo'                       => '',
                        'tipo_permiso_codigo_nombre'                => '',
                        'tipo_permiso_codigo_referencia'            => '',
                        'tipo_permiso_nombre'                       => '',
                        'tipo_permiso_coordina'                     => '',
                        'tipo_permiso_califica'                     => '',
                        'tipo_permiso_periodo'                      => '',
                        'tipo_permiso_cantidad'                     => ''
                    );

                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                }

                $stmtMSSQL->closeCursor();
                $stmtMSSQL = null;
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

    $app->get('/v1/000/permiso/coordina/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
            a.CODE                  AS          tipo_permiso_codigo,
            a.NAME                  AS          tipo_permiso_codigo_nombre,
            a.U_CODIGO              AS          tipo_permiso_codigo_referencia,
            a.U_NOMBRE              AS          tipo_permiso_nombre,
            a.U_CODINA              AS          tipo_permiso_coordina,
            a.U_CALIFICA            AS          tipo_permiso_califica,
            a.U_PERIODO             AS          tipo_permiso_periodo,
            a.U_CANPER              AS          tipo_permiso_cantidad
            
            FROM [CSF_PRUEBA].[dbo].[@A1A_TIPE] a

            WHERE a.U_CODINA = ?

            ORDER BY a.U_CODIGO";

            try {
                $connMSSQL  = getConnectionMSSQLv1();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01]); 

                while ($rowMSSQL = $stmtMSSQL->fetch()) {
                    $detalle    = array(
                        'tipo_permiso_codigo'                       => $rowMSSQL['tipo_permiso_codigo'],
                        'tipo_permiso_codigo_nombre'                => $rowMSSQL['tipo_permiso_codigo_nombre'],
                        'tipo_permiso_codigo_referencia'            => trim(strtoupper($rowMSSQL['tipo_permiso_codigo_referencia'])),
                        'tipo_permiso_nombre'                       => trim(strtoupper($rowMSSQL['tipo_permiso_nombre'])),
                        'tipo_permiso_coordina'                     => trim(strtoupper($rowMSSQL['tipo_permiso_coordina'])),
                        'tipo_permiso_califica'                     => trim(strtoupper($rowMSSQL['tipo_permiso_califica'])),
                        'tipo_permiso_periodo'                      => trim(strtoupper($rowMSSQL['tipo_permiso_periodo'])),
                        'tipo_permiso_cantidad'                     => $rowMSSQL['tipo_permiso_cantidad']
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'tipo_permiso_codigo'                       => '',
                        'tipo_permiso_codigo_nombre'                => '',
                        'tipo_permiso_codigo_referencia'            => '',
                        'tipo_permiso_nombre'                       => '',
                        'tipo_permiso_coordina'                     => '',
                        'tipo_permiso_califica'                     => '',
                        'tipo_permiso_periodo'                      => '',
                        'tipo_permiso_cantidad'                     => ''
                    );

                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                }

                $stmtMSSQL->closeCursor();
                $stmtMSSQL = null;
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

    $app->get('/v1/000/licencia', function($request) {
        require __DIR__.'/../src/connect.php';

        $sql00  = "SELECT
        a.CODE                  AS          tipo_licencia_codigo,
        a.NAME                  AS          tipo_licencia_codigo_nombre,
        a.U_CODIGO              AS          tipo_licencia_codigo_referencia,
        a.U_NOMBRE              AS          tipo_licencia_nombre,
        a.U_TIPO                AS          tipo_licencia_tipo,
        a.U_CODINA              AS          tipo_licencia_coordina
        
        FROM [CSF_PRUEBA].[dbo].[@A1A_TILC] a

        ORDER BY a.U_CODIGO";

        try {
            $connMSSQL  = getConnectionMSSQLv1();
            $stmtMSSQL  = $connMSSQL->prepare($sql00);
            $stmtMSSQL->execute(); 

            while ($rowMSSQL = $stmtMSSQL->fetch()) {
                $detalle    = array(
                    'tipo_licencia_codigo'                      => $rowMSSQL['tipo_licencia_codigo'],
                    'tipo_licencia_codigo_nombre'               => $rowMSSQL['tipo_licencia_codigo_nombre'],
                    'tipo_licencia_codigo_referencia'           => trim(strtoupper($rowMSSQL['tipo_licencia_codigo_referencia'])),
                    'tipo_licencia_nombre'                      => trim(strtoupper($rowMSSQL['tipo_licencia_nombre'])),
                    'tipo_licencia_tipo'                        => trim(strtoupper($rowMSSQL['tipo_licencia_tipo'])),
                    'tipo_licencia_coordina'                    => trim(strtoupper($rowMSSQL['tipo_licencia_coordina']))
                );

                $result[]   = $detalle;
            }

            if (isset($result)){
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } else {
                $detalle = array(
                    'tipo_licencia_codigo'                      => '',
                    'tipo_licencia_codigo_nombre'               => '',
                    'tipo_licencia_codigo_referencia'           => '',
                    'tipo_licencia_nombre'                      => '',
                    'tipo_licencia_tipo'                        => '',
                    'tipo_licencia_coordina'                    => ''
                );

                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }

            $stmtMSSQL->closeCursor();
            $stmtMSSQL = null;
        } catch (PDOException $e) {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v1/000/licencia/codigo/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
            a.CODE                  AS          tipo_licencia_codigo,
            a.NAME                  AS          tipo_licencia_codigo_nombre,
            a.U_CODIGO              AS          tipo_licencia_codigo_referencia,
            a.U_NOMBRE              AS          tipo_licencia_nombre,
            a.U_TIPO                AS          tipo_licencia_tipo,
            a.U_CODINA              AS          tipo_licencia_coordina
            
            FROM [CSF_PRUEBA].[dbo].[@A1A_TILC] a

            WHERE a.CODE = ?

            ORDER BY a.U_CODIGO";

            try {
                $connMSSQL  = getConnectionMSSQLv1();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01]); 

                while ($rowMSSQL = $stmtMSSQL->fetch()) {
                    $detalle    = array(
                        'tipo_licencia_codigo'                      => $rowMSSQL['tipo_licencia_codigo'],
                        'tipo_licencia_codigo_nombre'               => $rowMSSQL['tipo_licencia_codigo_nombre'],
                        'tipo_licencia_codigo_referencia'           => trim(strtoupper($rowMSSQL['tipo_licencia_codigo_referencia'])),
                        'tipo_licencia_nombre'                      => trim(strtoupper($rowMSSQL['tipo_licencia_nombre'])),
                        'tipo_licencia_tipo'                        => trim(strtoupper($rowMSSQL['tipo_licencia_tipo'])),
                        'tipo_licencia_coordina'                    => trim(strtoupper($rowMSSQL['tipo_licencia_coordina']))
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'tipo_licencia_codigo'                      => '',
                        'tipo_licencia_codigo_nombre'               => '',
                        'tipo_licencia_codigo_referencia'           => '',
                        'tipo_licencia_nombre'                      => '',
                        'tipo_licencia_tipo'                        => '',
                        'tipo_licencia_coordina'                    => ''
                    );

                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                }

                $stmtMSSQL->closeCursor();
                $stmtMSSQL = null;
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

    $app->get('/v1/000/licencia/referencia/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
            a.CODE                  AS          tipo_licencia_codigo,
            a.NAME                  AS          tipo_licencia_codigo_nombre,
            a.U_CODIGO              AS          tipo_licencia_codigo_referencia,
            a.U_NOMBRE              AS          tipo_licencia_nombre,
            a.U_TIPO                AS          tipo_licencia_tipo,
            a.U_CODINA              AS          tipo_licencia_coordina
            
            FROM [CSF_PRUEBA].[dbo].[@A1A_TILC] a

            WHERE a.U_CODIGO = ?

            ORDER BY a.U_CODIGO";

            try {
                $connMSSQL  = getConnectionMSSQLv1();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01]); 

                while ($rowMSSQL = $stmtMSSQL->fetch()) {
                    $detalle    = array(
                        'tipo_licencia_codigo'                      => $rowMSSQL['tipo_licencia_codigo'],
                        'tipo_licencia_codigo_nombre'               => $rowMSSQL['tipo_licencia_codigo_nombre'],
                        'tipo_licencia_codigo_referencia'           => trim(strtoupper($rowMSSQL['tipo_licencia_codigo_referencia'])),
                        'tipo_licencia_nombre'                      => trim(strtoupper($rowMSSQL['tipo_licencia_nombre'])),
                        'tipo_licencia_tipo'                        => trim(strtoupper($rowMSSQL['tipo_licencia_tipo'])),
                        'tipo_licencia_coordina'                    => trim(strtoupper($rowMSSQL['tipo_licencia_coordina']))
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'tipo_licencia_codigo'                      => '',
                        'tipo_licencia_codigo_nombre'               => '',
                        'tipo_licencia_codigo_referencia'           => '',
                        'tipo_licencia_nombre'                      => '',
                        'tipo_licencia_tipo'                        => '',
                        'tipo_licencia_coordina'                    => ''
                    );

                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                }

                $stmtMSSQL->closeCursor();
                $stmtMSSQL = null;
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

    $app->get('/v1/000/licencia/coordina/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
            a.CODE                  AS          tipo_licencia_codigo,
            a.NAME                  AS          tipo_licencia_codigo_nombre,
            a.U_CODIGO              AS          tipo_licencia_codigo_referencia,
            a.U_NOMBRE              AS          tipo_licencia_nombre,
            a.U_TIPO                AS          tipo_licencia_tipo,
            a.U_CODINA              AS          tipo_licencia_coordina
            
            FROM [CSF_PRUEBA].[dbo].[@A1A_TILC] a

            WHERE a.U_CODINA = ?

            ORDER BY a.U_CODIGO";

            try {
                $connMSSQL  = getConnectionMSSQLv1();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01]); 

                while ($rowMSSQL = $stmtMSSQL->fetch()) {
                    $detalle    = array(
                        'tipo_licencia_codigo'                      => $rowMSSQL['tipo_licencia_codigo'],
                        'tipo_licencia_codigo_nombre'               => $rowMSSQL['tipo_licencia_codigo_nombre'],
                        'tipo_licencia_codigo_referencia'           => trim(strtoupper($rowMSSQL['tipo_licencia_codigo_referencia'])),
                        'tipo_licencia_nombre'                      => trim(strtoupper($rowMSSQL['tipo_licencia_nombre'])),
                        'tipo_licencia_tipo'                        => trim(strtoupper($rowMSSQL['tipo_licencia_tipo'])),
                        'tipo_licencia_coordina'                    => trim(strtoupper($rowMSSQL['tipo_licencia_coordina']))
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'tipo_licencia_codigo'                      => '',
                        'tipo_licencia_codigo_nombre'               => '',
                        'tipo_licencia_codigo_referencia'           => '',
                        'tipo_licencia_nombre'                      => '',
                        'tipo_licencia_tipo'                        => '',
                        'tipo_licencia_coordina'                    => ''
                    );

                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                }

                $stmtMSSQL->closeCursor();
                $stmtMSSQL = null;
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

    $app->get('/v1/000/inasistencia', function($request) {
        require __DIR__.'/../src/connect.php';

        $sql00  = "SELECT
        a.CODE                  AS          tipo_inasistencia_codigo,
        a.NAME                  AS          tipo_inasistencia_codigo_nombre,
        a.U_CODIGO              AS          tipo_inasistencia_codigo_referencia,
        a.U_DESAMP              AS          tipo_inasistencia_nombre,
        a.U_TIPO                AS          tipo_inasistencia_tipo,
        a.U_UNIDAD              AS          tipo_inasistencia_unidad,
        a.U_IDENT               AS          tipo_inasistencia_identidad
        
        FROM [CSF_PRUEBA].[dbo].[@A1A_TIIN] a

        ORDER BY a.U_CODIGO";

        try {
            $connMSSQL  = getConnectionMSSQLv1();
            $stmtMSSQL  = $connMSSQL->prepare($sql00);
            $stmtMSSQL->execute(); 

            while ($rowMSSQL = $stmtMSSQL->fetch()) {
                $detalle    = array(
                    'tipo_inasistencia_codigo'                      => $rowMSSQL['tipo_inasistencia_codigo'],
                    'tipo_inasistencia_codigo_nombre'               => $rowMSSQL['tipo_inasistencia_codigo_nombre'],
                    'tipo_inasistencia_codigo_referencia'           => trim(strtoupper($rowMSSQL['tipo_inasistencia_codigo_referencia'])),
                    'tipo_inasistencia_nombre'                      => trim(strtoupper($rowMSSQL['tipo_inasistencia_nombre'])),
                    'tipo_inasistencia_tipo'                        => trim(strtoupper($rowMSSQL['tipo_inasistencia_tipo'])),
                    'tipo_inasistencia_unidad'                      => trim(strtoupper($rowMSSQL['tipo_inasistencia_unidad'])),
                    'tipo_inasistencia_identidad'                   => trim(strtoupper($rowMSSQL['tipo_inasistencia_identidad']))
                );

                $result[]   = $detalle;
            }

            if (isset($result)){
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } else {
                $detalle = array(
                    'tipo_inasistencia_codigo'                      => '',
                    'tipo_inasistencia_codigo_nombre'               => '',
                    'tipo_inasistencia_codigo_referencia'           => '',
                    'tipo_inasistencia_nombre'                      => '',
                    'tipo_inasistencia_tipo'                        => '',
                    'tipo_inasistencia_unidad'                      => '',
                    'tipo_inasistencia_identidad'                   => ''
                );

                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }

            $stmtMSSQL->closeCursor();
            $stmtMSSQL = null;
        } catch (PDOException $e) {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v1/000/inasistencia/codigo/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
            a.CODE                  AS          tipo_inasistencia_codigo,
            a.NAME                  AS          tipo_inasistencia_codigo_nombre,
            a.U_CODIGO              AS          tipo_inasistencia_codigo_referencia,
            a.U_DESAMP              AS          tipo_inasistencia_nombre,
            a.U_TIPO                AS          tipo_inasistencia_tipo,
            a.U_UNIDAD              AS          tipo_inasistencia_unidad,
            a.U_IDENT               AS          tipo_inasistencia_identidad
            
            FROM [CSF_PRUEBA].[dbo].[@A1A_TIIN] a

            WHERE a.CODE = ?

            ORDER BY a.U_CODIGO";

            try {
                $connMSSQL  = getConnectionMSSQLv1();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01]); 

                while ($rowMSSQL = $stmtMSSQL->fetch()) {
                    $detalle    = array(
                        'tipo_inasistencia_codigo'                      => $rowMSSQL['tipo_inasistencia_codigo'],
                        'tipo_inasistencia_codigo_nombre'               => $rowMSSQL['tipo_inasistencia_codigo_nombre'],
                        'tipo_inasistencia_codigo_referencia'           => trim(strtoupper($rowMSSQL['tipo_inasistencia_codigo_referencia'])),
                        'tipo_inasistencia_nombre'                      => trim(strtoupper($rowMSSQL['tipo_inasistencia_nombre'])),
                        'tipo_inasistencia_tipo'                        => trim(strtoupper($rowMSSQL['tipo_inasistencia_tipo'])),
                        'tipo_inasistencia_unidad'                      => trim(strtoupper($rowMSSQL['tipo_inasistencia_unidad'])),
                        'tipo_inasistencia_identidad'                   => trim(strtoupper($rowMSSQL['tipo_inasistencia_identidad']))
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'tipo_inasistencia_codigo'                      => '',
                        'tipo_inasistencia_codigo_nombre'               => '',
                        'tipo_inasistencia_codigo_referencia'           => '',
                        'tipo_inasistencia_nombre'                      => '',
                        'tipo_inasistencia_tipo'                        => '',
                        'tipo_inasistencia_unidad'                      => '',
                        'tipo_inasistencia_identidad'                   => ''
                    );

                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                }

                $stmtMSSQL->closeCursor();
                $stmtMSSQL = null;
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

    $app->get('/v1/000/inasistencia/referencia/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
            a.CODE                  AS          tipo_inasistencia_codigo,
            a.NAME                  AS          tipo_inasistencia_codigo_nombre,
            a.U_CODIGO              AS          tipo_inasistencia_codigo_referencia,
            a.U_DESAMP              AS          tipo_inasistencia_nombre,
            a.U_TIPO                AS          tipo_inasistencia_tipo,
            a.U_UNIDAD              AS          tipo_inasistencia_unidad,
            a.U_IDENT               AS          tipo_inasistencia_identidad
            
            FROM [CSF_PRUEBA].[dbo].[@A1A_TIIN] a

            WHERE a.U_CODIGO = ?

            ORDER BY a.U_CODIGO";

            try {
                $connMSSQL  = getConnectionMSSQLv1();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01]); 

                while ($rowMSSQL = $stmtMSSQL->fetch()) {
                    $detalle    = array(
                        'tipo_inasistencia_codigo'                      => $rowMSSQL['tipo_inasistencia_codigo'],
                        'tipo_inasistencia_codigo_nombre'               => $rowMSSQL['tipo_inasistencia_codigo_nombre'],
                        'tipo_inasistencia_codigo_referencia'           => trim(strtoupper($rowMSSQL['tipo_inasistencia_codigo_referencia'])),
                        'tipo_inasistencia_nombre'                      => trim(strtoupper($rowMSSQL['tipo_inasistencia_nombre'])),
                        'tipo_inasistencia_tipo'                        => trim(strtoupper($rowMSSQL['tipo_inasistencia_tipo'])),
                        'tipo_inasistencia_unidad'                      => trim(strtoupper($rowMSSQL['tipo_inasistencia_unidad'])),
                        'tipo_inasistencia_identidad'                   => trim(strtoupper($rowMSSQL['tipo_inasistencia_identidad']))
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'tipo_inasistencia_codigo'                      => '',
                        'tipo_inasistencia_codigo_nombre'               => '',
                        'tipo_inasistencia_codigo_referencia'           => '',
                        'tipo_inasistencia_nombre'                      => '',
                        'tipo_inasistencia_tipo'                        => '',
                        'tipo_inasistencia_unidad'                      => '',
                        'tipo_inasistencia_identidad'                   => ''
                    );

                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                }

                $stmtMSSQL->closeCursor();
                $stmtMSSQL = null;
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

    $app->get('/v1/000/cargo', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $sql00  = "SELECT
        a.CODE              AS          tipo_cargo_codigo,
        a.NAME              AS          tipo_cargo_codigo_nombre,
        a.U_CODIGO          AS          tipo_cargo_codigo_referencia,
        a.U_NOMBRE          AS          tipo_cargo_nombre,
        a.U_PUESTOS         AS          tipo_cargo_puesto_cantidad,
        a.U_PUEOCU          AS          tipo_cargo_puesto_ocupado,
        a.U_PUELIB          AS          tipo_cargo_libre,
        a.U_GRADO           AS          tipo_cargo_grado,

        b.CODE              AS          tipo_superior_cargo_codigo,
        b.NAME              AS          tipo_superior_cargo_codigo_nombre,
        b.U_CODIGO          AS          tipo_superior_cargo_codigo_referencia,
        b.U_NOMBRE          AS          tipo_superior_cargo_nombre
        
        FROM [CSF_PRUEBA].[dbo].[@A1A_TICA] a
        LEFT OUTER JOIN [CSF_PRUEBA].[dbo].[@A1A_TICA] b ON a.U_CARSUP = b.U_CODIGO

        ORDER BY a.U_CODIGO";

        try {
            $connMSSQL  = getConnectionMSSQLv1();
            $stmtMSSQL  = $connMSSQL->prepare($sql00);
            $stmtMSSQL->execute(); 

            while ($rowMSSQL = $stmtMSSQL->fetch()) {
                $detalle    = array(
                    'tipo_cargo_codigo'                             => $rowMSSQL['tipo_cargo_codigo'],
                    'tipo_cargo_codigo_nombre'                      => $rowMSSQL['tipo_cargo_codigo_nombre'],
                    'tipo_cargo_codigo_referencia'                  => $rowMSSQL['tipo_cargo_codigo_referencia'],
                    'tipo_cargo_nombre'                             => trim(strtoupper($rowMSSQL['tipo_cargo_nombre'])),
                    'tipo_cargo_puesto_cantidad'                    => $rowMSSQL['tipo_cargo_puesto_cantidad'],
                    'tipo_cargo_puesto_ocupado'                     => $rowMSSQL['tipo_cargo_puesto_ocupado'],
                    'tipo_cargo_libre'                              => $rowMSSQL['tipo_cargo_libre'],
                    'tipo_cargo_grado'                              => $rowMSSQL['tipo_cargo_grado'],
                    'tipo_superior_cargo_codigo'                    => $rowMSSQL['tipo_superior_cargo_codigo'],
                    'tipo_superior_cargo_codigo_nombre'             => $rowMSSQL['tipo_superior_cargo_codigo_nombre'],
                    'tipo_superior_cargo_codigo_referencia'         => $rowMSSQL['tipo_superior_cargo_codigo_referencia'],
                    'tipo_superior_cargo_nombre'                    => trim(strtoupper($rowMSSQL['tipo_superior_cargo_nombre']))
                );

                $result[]   = $detalle;
            }

            if (isset($result)){
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } else {
                $detalle = array(
                    'tipo_cargo_codigo'                             => '',
                    'tipo_cargo_codigo_nombre'                      => '',
                    'tipo_cargo_codigo_referencia'                  => '',
                    'tipo_cargo_nombre'                             => '',
                    'tipo_cargo_puesto_cantidad'                    => '',
                    'tipo_cargo_puesto_ocupado'                     => '',
                    'tipo_cargo_libre'                              => '',
                    'tipo_cargo_grado'                              => '',
                    'tipo_superior_cargo_codigo'                    => '',
                    'tipo_superior_cargo_codigo_nombre'             => '',
                    'tipo_superior_cargo_codigo_referencia'         => '',
                    'tipo_superior_cargo_nombre'                    => ''
                );

                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }

            $stmtMSSQL->closeCursor();
            $stmtMSSQL = null;
        } catch (PDOException $e) {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v1/000/cargo/codigo/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
            a.CODE              AS          tipo_cargo_codigo,
            a.NAME              AS          tipo_cargo_codigo_nombre,
            a.U_CODIGO          AS          tipo_cargo_codigo_referencia,
            a.U_NOMBRE          AS          tipo_cargo_nombre,
            a.U_PUESTOS         AS          tipo_cargo_puesto_cantidad,
            a.U_PUEOCU          AS          tipo_cargo_puesto_ocupado,
            a.U_PUELIB          AS          tipo_cargo_libre,
            a.U_GRADO           AS          tipo_cargo_grado,

            b.CODE              AS          tipo_superior_cargo_codigo,
            b.NAME              AS          tipo_superior_cargo_codigo_nombre,
            b.U_CODIGO          AS          tipo_superior_cargo_codigo_referencia,
            b.U_NOMBRE          AS          tipo_superior_cargo_nombre
            
            FROM [CSF_PRUEBA].[dbo].[@A1A_TICA] a
            LEFT OUTER JOIN [CSF_PRUEBA].[dbo].[@A1A_TICA] b ON a.U_CARSUP = b.U_CODIGO

            WHERE a.CODE = ?

            ORDER BY a.U_CODIGO";

            try {
                $connMSSQL  = getConnectionMSSQLv1();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01]); 

                while ($rowMSSQL = $stmtMSSQL->fetch()) {
                    $detalle    = array(
                        'tipo_cargo_codigo'                             => $rowMSSQL['tipo_cargo_codigo'],
                        'tipo_cargo_codigo_nombre'                      => $rowMSSQL['tipo_cargo_codigo_nombre'],
                        'tipo_cargo_codigo_referencia'                  => $rowMSSQL['tipo_cargo_codigo_referencia'],
                        'tipo_cargo_nombre'                             => trim(strtoupper($rowMSSQL['tipo_cargo_nombre'])),
                        'tipo_cargo_puesto_cantidad'                    => $rowMSSQL['tipo_cargo_puesto_cantidad'],
                        'tipo_cargo_puesto_ocupado'                     => $rowMSSQL['tipo_cargo_puesto_ocupado'],
                        'tipo_cargo_libre'                              => $rowMSSQL['tipo_cargo_libre'],
                        'tipo_cargo_grado'                              => $rowMSSQL['tipo_cargo_grado'],
                        'tipo_superior_cargo_codigo'                    => $rowMSSQL['tipo_superior_cargo_codigo'],
                        'tipo_superior_cargo_codigo_nombre'             => $rowMSSQL['tipo_superior_cargo_codigo_nombre'],
                        'tipo_superior_cargo_codigo_referencia'         => $rowMSSQL['tipo_superior_cargo_codigo_referencia'],
                        'tipo_superior_cargo_nombre'                    => trim(strtoupper($rowMSSQL['tipo_superior_cargo_nombre']))
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'tipo_cargo_codigo'                             => '',
                        'tipo_cargo_codigo_nombre'                      => '',
                        'tipo_cargo_codigo_referencia'                  => '',
                        'tipo_cargo_nombre'                             => '',
                        'tipo_cargo_puesto_cantidad'                    => '',
                        'tipo_cargo_puesto_ocupado'                     => '',
                        'tipo_cargo_libre'                              => '',
                        'tipo_cargo_grado'                              => '',
                        'tipo_superior_cargo_codigo'                    => '',
                        'tipo_superior_cargo_codigo_nombre'             => '',
                        'tipo_superior_cargo_codigo_referencia'         => '',
                        'tipo_superior_cargo_nombre'                    => ''
                    );

                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                }

                $stmtMSSQL->closeCursor();
                $stmtMSSQL = null;
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

    $app->get('/v1/000/cargo/referencia/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
            a.CODE              AS          tipo_cargo_codigo,
            a.NAME              AS          tipo_cargo_codigo_nombre,
            a.U_CODIGO          AS          tipo_cargo_codigo_referencia,
            a.U_NOMBRE          AS          tipo_cargo_nombre,
            a.U_PUESTOS         AS          tipo_cargo_puesto_cantidad,
            a.U_PUEOCU          AS          tipo_cargo_puesto_ocupado,
            a.U_PUELIB          AS          tipo_cargo_libre,
            a.U_GRADO           AS          tipo_cargo_grado,

            b.CODE              AS          tipo_superior_cargo_codigo,
            b.NAME              AS          tipo_superior_cargo_codigo_nombre,
            b.U_CODIGO          AS          tipo_superior_cargo_codigo_referencia,
            b.U_NOMBRE          AS          tipo_superior_cargo_nombre
            
            FROM [CSF_PRUEBA].[dbo].[@A1A_TICA] a
            LEFT OUTER JOIN [CSF_PRUEBA].[dbo].[@A1A_TICA] b ON a.U_CARSUP = b.U_CODIGO

            WHERE a.U_CODIGO = ?

            ORDER BY a.U_CODIGO";

            try {
                $connMSSQL  = getConnectionMSSQLv1();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01]); 

                while ($rowMSSQL = $stmtMSSQL->fetch()) {
                    $detalle    = array(
                        'tipo_cargo_codigo'                             => $rowMSSQL['tipo_cargo_codigo'],
                        'tipo_cargo_codigo_nombre'                      => $rowMSSQL['tipo_cargo_codigo_nombre'],
                        'tipo_cargo_codigo_referencia'                  => $rowMSSQL['tipo_cargo_codigo_referencia'],
                        'tipo_cargo_nombre'                             => trim(strtoupper($rowMSSQL['tipo_cargo_nombre'])),
                        'tipo_cargo_puesto_cantidad'                    => $rowMSSQL['tipo_cargo_puesto_cantidad'],
                        'tipo_cargo_puesto_ocupado'                     => $rowMSSQL['tipo_cargo_puesto_ocupado'],
                        'tipo_cargo_libre'                              => $rowMSSQL['tipo_cargo_libre'],
                        'tipo_cargo_grado'                              => $rowMSSQL['tipo_cargo_grado'],
                        'tipo_superior_cargo_codigo'                    => $rowMSSQL['tipo_superior_cargo_codigo'],
                        'tipo_superior_cargo_codigo_nombre'             => $rowMSSQL['tipo_superior_cargo_codigo_nombre'],
                        'tipo_superior_cargo_codigo_referencia'         => $rowMSSQL['tipo_superior_cargo_codigo_referencia'],
                        'tipo_superior_cargo_nombre'                    => trim(strtoupper($rowMSSQL['tipo_superior_cargo_nombre']))
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'tipo_cargo_codigo'                             => '',
                        'tipo_cargo_codigo_nombre'                      => '',
                        'tipo_cargo_codigo_referencia'                  => '',
                        'tipo_cargo_nombre'                             => '',
                        'tipo_cargo_puesto_cantidad'                    => '',
                        'tipo_cargo_puesto_ocupado'                     => '',
                        'tipo_cargo_libre'                              => '',
                        'tipo_cargo_grado'                              => '',
                        'tipo_superior_cargo_codigo'                    => '',
                        'tipo_superior_cargo_codigo_nombre'             => '',
                        'tipo_superior_cargo_codigo_referencia'         => '',
                        'tipo_superior_cargo_nombre'                    => ''
                    );

                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                }

                $stmtMSSQL->closeCursor();
                $stmtMSSQL = null;
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

    $app->get('/v1/000/cargo/superior/codigo/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
            a.CODE              AS          tipo_cargo_codigo,
            a.NAME              AS          tipo_cargo_codigo_nombre,
            a.U_CODIGO          AS          tipo_cargo_codigo_referencia,
            a.U_NOMBRE          AS          tipo_cargo_nombre,
            a.U_PUESTOS         AS          tipo_cargo_puesto_cantidad,
            a.U_PUEOCU          AS          tipo_cargo_puesto_ocupado,
            a.U_PUELIB          AS          tipo_cargo_libre,
            a.U_GRADO           AS          tipo_cargo_grado,

            b.CODE              AS          tipo_superior_cargo_codigo,
            b.NAME              AS          tipo_superior_cargo_codigo_nombre,
            b.U_CODIGO          AS          tipo_superior_cargo_codigo_referencia,
            b.U_NOMBRE          AS          tipo_superior_cargo_nombre
            
            FROM [CSF_PRUEBA].[dbo].[@A1A_TICA] a
            LEFT OUTER JOIN [CSF_PRUEBA].[dbo].[@A1A_TICA] b ON a.U_CARSUP = b.U_CODIGO

            WHERE b.CODE = ?

            ORDER BY a.U_CODIGO";

            try {
                $connMSSQL  = getConnectionMSSQLv1();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01]); 

                while ($rowMSSQL = $stmtMSSQL->fetch()) {
                    $detalle    = array(
                        'tipo_cargo_codigo'                             => $rowMSSQL['tipo_cargo_codigo'],
                        'tipo_cargo_codigo_nombre'                      => $rowMSSQL['tipo_cargo_codigo_nombre'],
                        'tipo_cargo_codigo_referencia'                  => $rowMSSQL['tipo_cargo_codigo_referencia'],
                        'tipo_cargo_nombre'                             => trim(strtoupper($rowMSSQL['tipo_cargo_nombre'])),
                        'tipo_cargo_puesto_cantidad'                    => $rowMSSQL['tipo_cargo_puesto_cantidad'],
                        'tipo_cargo_puesto_ocupado'                     => $rowMSSQL['tipo_cargo_puesto_ocupado'],
                        'tipo_cargo_libre'                              => $rowMSSQL['tipo_cargo_libre'],
                        'tipo_cargo_grado'                              => $rowMSSQL['tipo_cargo_grado'],
                        'tipo_superior_cargo_codigo'                    => $rowMSSQL['tipo_superior_cargo_codigo'],
                        'tipo_superior_cargo_codigo_nombre'             => $rowMSSQL['tipo_superior_cargo_codigo_nombre'],
                        'tipo_superior_cargo_codigo_referencia'         => $rowMSSQL['tipo_superior_cargo_codigo_referencia'],
                        'tipo_superior_cargo_nombre'                    => trim(strtoupper($rowMSSQL['tipo_superior_cargo_nombre']))
                        
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'tipo_cargo_codigo'                             => '',
                        'tipo_cargo_codigo_nombre'                      => '',
                        'tipo_cargo_codigo_referencia'                  => '',
                        'tipo_cargo_nombre'                             => '',
                        'tipo_cargo_puesto_cantidad'                    => '',
                        'tipo_cargo_puesto_ocupado'                     => '',
                        'tipo_cargo_libre'                              => '',
                        'tipo_cargo_grado'                              => '',
                        'tipo_superior_cargo_codigo'                    => '',
                        'tipo_superior_cargo_codigo_nombre'             => '',
                        'tipo_superior_cargo_codigo_referencia'         => '',
                        'tipo_superior_cargo_nombre'                    => ''
                    );

                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                }

                $stmtMSSQL->closeCursor();
                $stmtMSSQL = null;
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

    $app->get('/v1/000/cargo/superior/referencia/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
            a.CODE              AS          tipo_cargo_codigo,
            a.NAME              AS          tipo_cargo_codigo_nombre,
            a.U_CODIGO          AS          tipo_cargo_codigo_referencia,
            a.U_NOMBRE          AS          tipo_cargo_nombre,
            a.U_PUESTOS         AS          tipo_cargo_puesto_cantidad,
            a.U_PUEOCU          AS          tipo_cargo_puesto_ocupado,
            a.U_PUELIB          AS          tipo_cargo_libre,
            a.U_GRADO           AS          tipo_cargo_grado,

            b.CODE              AS          tipo_superior_cargo_codigo,
            b.NAME              AS          tipo_superior_cargo_codigo_nombre,
            b.U_CODIGO          AS          tipo_superior_cargo_codigo_referencia,
            b.U_NOMBRE          AS          tipo_superior_cargo_nombre
            
            FROM [CSF_PRUEBA].[dbo].[@A1A_TICA] a
            LEFT OUTER JOIN [CSF_PRUEBA].[dbo].[@A1A_TICA] b ON a.U_CARSUP = b.U_CODIGO

            WHERE b.U_CODIGO = ?

            ORDER BY a.U_CODIGO";

            try {
                $connMSSQL  = getConnectionMSSQLv1();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01]); 

                while ($rowMSSQL = $stmtMSSQL->fetch()) {
                    $detalle    = array(
                        'tipo_cargo_codigo'                             => $rowMSSQL['tipo_cargo_codigo'],
                        'tipo_cargo_codigo_nombre'                      => $rowMSSQL['tipo_cargo_codigo_nombre'],
                        'tipo_cargo_codigo_referencia'                  => $rowMSSQL['tipo_cargo_codigo_referencia'],
                        'tipo_cargo_nombre'                             => trim(strtoupper($rowMSSQL['tipo_cargo_nombre'])),
                        'tipo_cargo_puesto_cantidad'                    => $rowMSSQL['tipo_cargo_puesto_cantidad'],
                        'tipo_cargo_puesto_ocupado'                     => $rowMSSQL['tipo_cargo_puesto_ocupado'],
                        'tipo_cargo_libre'                              => $rowMSSQL['tipo_cargo_libre'],
                        'tipo_cargo_grado'                              => $rowMSSQL['tipo_cargo_grado'],
                        'tipo_superior_cargo_codigo'                    => $rowMSSQL['tipo_superior_cargo_codigo'],
                        'tipo_superior_cargo_codigo_nombre'             => $rowMSSQL['tipo_superior_cargo_codigo_nombre'],
                        'tipo_superior_cargo_codigo_referencia'         => $rowMSSQL['tipo_superior_cargo_codigo_referencia'],
                        'tipo_superior_cargo_nombre'                    => trim(strtoupper($rowMSSQL['tipo_superior_cargo_nombre']))
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'tipo_cargo_codigo'                             => '',
                        'tipo_cargo_codigo_nombre'                      => '',
                        'tipo_cargo_codigo_referencia'                  => '',
                        'tipo_cargo_nombre'                             => '',
                        'tipo_cargo_puesto_cantidad'                    => '',
                        'tipo_cargo_puesto_ocupado'                     => '',
                        'tipo_cargo_libre'                              => '',
                        'tipo_cargo_grado'                              => '',
                        'tipo_superior_cargo_codigo'                    => '',
                        'tipo_superior_cargo_codigo_nombre'             => '',
                        'tipo_superior_cargo_codigo_referencia'         => '',
                        'tipo_superior_cargo_nombre'                    => ''
                    );

                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                }

                $stmtMSSQL->closeCursor();
                $stmtMSSQL = null;
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

    $app->get('/v1/000/gerencia', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $sql00  = "SELECT
        a.CODE              AS          tipo_gerencia_codigo,
        a.NAME              AS          tipo_gerencia_codigo_nombre,
        a.U_CODIGO          AS          tipo_gerencia_codigo_referencia,
        a.U_NOMBRE          AS          tipo_gerencia_nombre
        
        FROM [CSF_PRUEBA].[dbo].[@A1A_TIGE] a

        ORDER BY a.U_CODIGO";

        try {
            $connMSSQL  = getConnectionMSSQLv1();
            $stmtMSSQL  = $connMSSQL->prepare($sql00);
            $stmtMSSQL->execute(); 

            while ($rowMSSQL = $stmtMSSQL->fetch()) {
                $detalle    = array(
                    'tipo_gerencia_codigo'                             => $rowMSSQL['tipo_gerencia_codigo'],
                    'tipo_gerencia_codigo_nombre'                      => $rowMSSQL['tipo_gerencia_codigo_nombre'],
                    'tipo_gerencia_codigo_referencia'                  => $rowMSSQL['tipo_gerencia_codigo_referencia'],
                    'tipo_gerencia_nombre'                             => trim(strtoupper($rowMSSQL['tipo_gerencia_nombre']))
                );

                $result[]   = $detalle;
            }

            if (isset($result)){
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } else {
                $detalle = array(
                    'tipo_gerencia_codigo'                             => '',
                    'tipo_gerencia_codigo_nombre'                      => '',
                    'tipo_gerencia_codigo_referencia'                  => '',
                    'tipo_gerencia_nombre'                             => ''
                );

                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }

            $stmtMSSQL->closeCursor();
            $stmtMSSQL = null;
        } catch (PDOException $e) {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v1/000/gerencia/codigo/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val01      = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
            a.CODE              AS          tipo_gerencia_codigo,
            a.NAME              AS          tipo_gerencia_codigo_nombre,
            a.U_CODIGO          AS          tipo_gerencia_codigo_referencia,
            a.U_NOMBRE          AS          tipo_gerencia_nombre
            
            FROM [CSF_PRUEBA].[dbo].[@A1A_TIGE] a

            WHERE a.CODE = ?

            ORDER BY a.U_CODIGO";

            try {
                $connMSSQL  = getConnectionMSSQLv1();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01]); 

                while ($rowMSSQL = $stmtMSSQL->fetch()) {
                    $detalle    = array(
                        'tipo_gerencia_codigo'                             => $rowMSSQL['tipo_gerencia_codigo'],
                        'tipo_gerencia_codigo_nombre'                      => $rowMSSQL['tipo_gerencia_codigo_nombre'],
                        'tipo_gerencia_codigo_referencia'                  => $rowMSSQL['tipo_gerencia_codigo_referencia'],
                        'tipo_gerencia_nombre'                             => trim(strtoupper($rowMSSQL['tipo_gerencia_nombre']))
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'tipo_gerencia_codigo'                             => '',
                        'tipo_gerencia_codigo_nombre'                      => '',
                        'tipo_gerencia_codigo_referencia'                  => '',
                        'tipo_gerencia_nombre'                             => ''
                    );

                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                }

                $stmtMSSQL->closeCursor();
                $stmtMSSQL = null;
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

    $app->get('/v1/000/gerencia/referencia/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val01      = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
            a.CODE              AS          tipo_gerencia_codigo,
            a.NAME              AS          tipo_gerencia_codigo_nombre,
            a.U_CODIGO          AS          tipo_gerencia_codigo_referencia,
            a.U_NOMBRE          AS          tipo_gerencia_nombre
            
            FROM [CSF_PRUEBA].[dbo].[@A1A_TIGE] a

            WHERE a.U_CODIGO = ?

            ORDER BY a.U_CODIGO";

            try {
                $connMSSQL  = getConnectionMSSQLv1();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01]); 

                while ($rowMSSQL = $stmtMSSQL->fetch()) {
                    $detalle    = array(
                        'tipo_gerencia_codigo'                             => $rowMSSQL['tipo_gerencia_codigo'],
                        'tipo_gerencia_codigo_nombre'                      => $rowMSSQL['tipo_gerencia_codigo_nombre'],
                        'tipo_gerencia_codigo_referencia'                  => $rowMSSQL['tipo_gerencia_codigo_referencia'],
                        'tipo_gerencia_nombre'                             => trim(strtoupper($rowMSSQL['tipo_gerencia_nombre']))
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'tipo_gerencia_codigo'                             => '',
                        'tipo_gerencia_codigo_nombre'                      => '',
                        'tipo_gerencia_codigo_referencia'                  => '',
                        'tipo_gerencia_nombre'                             => ''
                    );

                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                }

                $stmtMSSQL->closeCursor();
                $stmtMSSQL = null;
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

    $app->get('/v1/000/departamento', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $sql00  = "SELECT
        a.CODE              AS          tipo_departamento_codigo,
        a.NAME              AS          tipo_departamento_codigo_nombre,
        a.U_CODIGO          AS          tipo_departamento_codigo_referencia,
        a.U_NOMBRE          AS          tipo_departamento_nombre,

        b.CODE              AS          tipo_gerencia_codigo,
        b.NAME              AS          tipo_gerencia_codigo_nombre,
        b.U_CODIGO          AS          tipo_gerencia_codigo_referencia,
        b.U_NOMBRE          AS          tipo_gerencia_nombre
        
        FROM [CSF_PRUEBA].[dbo].[@A1A_TIDE] a
        LEFT OUTER JOIN [CSF_PRUEBA].[dbo].[@A1A_TIGE] b ON a.U_CODGER = b.U_CODIGO

        ORDER BY a.U_CODIGO";

        try {
            $connMSSQL  = getConnectionMSSQLv1();
            $stmtMSSQL  = $connMSSQL->prepare($sql00);
            $stmtMSSQL->execute(); 

            while ($rowMSSQL = $stmtMSSQL->fetch()) {
                $detalle    = array(
                    'tipo_departamento_codigo'                      => $rowMSSQL['tipo_departamento_codigo'],
                    'tipo_departamento_codigo_nombre'               => $rowMSSQL['tipo_departamento_codigo_nombre'],
                    'tipo_departamento_codigo_referencia'           => $rowMSSQL['tipo_departamento_codigo_referencia'],
                    'tipo_departamento_nombre'                      => trim(strtoupper($rowMSSQL['tipo_departamento_nombre'])),
                    'tipo_gerencia_codigo'                          => $rowMSSQL['tipo_gerencia_codigo'],
                    'tipo_gerencia_codigo_nombre'                   => $rowMSSQL['tipo_gerencia_codigo_nombre'],
                    'tipo_gerencia_codigo_referencia'               => $rowMSSQL['tipo_gerencia_codigo_referencia'],
                    'tipo_gerencia_nombre'                          => trim(strtoupper($rowMSSQL['tipo_gerencia_nombre']))
                );

                $result[]   = $detalle;
            }

            if (isset($result)){
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } else {
                $detalle = array(
                    'tipo_departamento_codigo'                      => '',
                    'tipo_departamento_codigo_nombre'               => '',
                    'tipo_departamento_codigo_referencia'           => '',
                    'tipo_departamento_nombre'                      => '',
                    'tipo_gerencia_codigo'                          => '',
                    'tipo_gerencia_codigo_nombre'                   => '',
                    'tipo_gerencia_codigo_referencia'               => '',
                    'tipo_gerencia_nombre'                          => ''
                );

                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }

            $stmtMSSQL->closeCursor();
            $stmtMSSQL = null;
        } catch (PDOException $e) {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v1/000/departamento/codigo/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val01      = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
            a.CODE              AS          tipo_departamento_codigo,
            a.NAME              AS          tipo_departamento_codigo_nombre,
            a.U_CODIGO          AS          tipo_departamento_codigo_referencia,
            a.U_NOMBRE          AS          tipo_departamento_nombre,

            b.CODE              AS          tipo_gerencia_codigo,
            b.NAME              AS          tipo_gerencia_codigo_nombre,
            b.U_CODIGO          AS          tipo_gerencia_codigo_referencia,
            b.U_NOMBRE          AS          tipo_gerencia_nombre
            
            FROM [CSF_PRUEBA].[dbo].[@A1A_TIDE] a
            LEFT OUTER JOIN [CSF_PRUEBA].[dbo].[@A1A_TIGE] b ON a.U_CODGER = b.U_CODIGO

            WHERE a.CODE = ?

            ORDER BY a.U_CODIGO";

            try {
                $connMSSQL  = getConnectionMSSQLv1();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01]); 

                while ($rowMSSQL = $stmtMSSQL->fetch()) {
                    $detalle    = array(
                        'tipo_departamento_codigo'                      => $rowMSSQL['tipo_departamento_codigo'],
                        'tipo_departamento_codigo_nombre'               => $rowMSSQL['tipo_departamento_codigo_nombre'],
                        'tipo_departamento_codigo_referencia'           => $rowMSSQL['tipo_departamento_codigo_referencia'],
                        'tipo_departamento_nombre'                      => trim(strtoupper($rowMSSQL['tipo_departamento_nombre'])),
                        'tipo_gerencia_codigo'                          => $rowMSSQL['tipo_gerencia_codigo'],
                        'tipo_gerencia_codigo_nombre'                   => $rowMSSQL['tipo_gerencia_codigo_nombre'],
                        'tipo_gerencia_codigo_referencia'               => $rowMSSQL['tipo_gerencia_codigo_referencia'],
                        'tipo_gerencia_nombre'                          => trim(strtoupper($rowMSSQL['tipo_gerencia_nombre']))
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'tipo_departamento_codigo'                      => '',
                        'tipo_departamento_codigo_nombre'               => '',
                        'tipo_departamento_codigo_referencia'           => '',
                        'tipo_departamento_nombre'                      => '',
                        'tipo_gerencia_codigo'                          => '',
                        'tipo_gerencia_codigo_nombre'                   => '',
                        'tipo_gerencia_codigo_referencia'               => '',
                        'tipo_gerencia_nombre'                          => ''
                    );

                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                }

                $stmtMSSQL->closeCursor();
                $stmtMSSQL = null;
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

    $app->get('/v1/000/departamento/referencia/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val01      = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
            a.CODE              AS          tipo_departamento_codigo,
            a.NAME              AS          tipo_departamento_codigo_nombre,
            a.U_CODIGO          AS          tipo_departamento_codigo_referencia,
            a.U_NOMBRE          AS          tipo_departamento_nombre,

            b.CODE              AS          tipo_gerencia_codigo,
            b.NAME              AS          tipo_gerencia_codigo_nombre,
            b.U_CODIGO          AS          tipo_gerencia_codigo_referencia,
            b.U_NOMBRE          AS          tipo_gerencia_nombre
            
            FROM [CSF_PRUEBA].[dbo].[@A1A_TIDE] a
            LEFT OUTER JOIN [CSF_PRUEBA].[dbo].[@A1A_TIGE] b ON a.U_CODGER = b.U_CODIGO

            WHERE a.U_CODIGO = ?

            ORDER BY a.U_CODIGO";

            try {
                $connMSSQL  = getConnectionMSSQLv1();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01]); 

                while ($rowMSSQL = $stmtMSSQL->fetch()) {
                    $detalle    = array(
                        'tipo_departamento_codigo'                      => $rowMSSQL['tipo_departamento_codigo'],
                        'tipo_departamento_codigo_nombre'               => $rowMSSQL['tipo_departamento_codigo_nombre'],
                        'tipo_departamento_codigo_referencia'           => $rowMSSQL['tipo_departamento_codigo_referencia'],
                        'tipo_departamento_nombre'                      => trim(strtoupper($rowMSSQL['tipo_departamento_nombre'])),
                        'tipo_gerencia_codigo'                          => $rowMSSQL['tipo_gerencia_codigo'],
                        'tipo_gerencia_codigo_nombre'                   => $rowMSSQL['tipo_gerencia_codigo_nombre'],
                        'tipo_gerencia_codigo_referencia'               => $rowMSSQL['tipo_gerencia_codigo_referencia'],
                        'tipo_gerencia_nombre'                          => trim(strtoupper($rowMSSQL['tipo_gerencia_nombre']))
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'tipo_departamento_codigo'                      => '',
                        'tipo_departamento_codigo_nombre'               => '',
                        'tipo_departamento_codigo_referencia'           => '',
                        'tipo_departamento_nombre'                      => '',
                        'tipo_gerencia_codigo'                          => '',
                        'tipo_gerencia_codigo_nombre'                   => '',
                        'tipo_gerencia_codigo_referencia'               => '',
                        'tipo_gerencia_nombre'                          => ''
                    );

                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                }

                $stmtMSSQL->closeCursor();
                $stmtMSSQL = null;
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

    $app->get('/v1/000/departamento/gerencia/codigo/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val01      = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
            a.CODE              AS          tipo_departamento_codigo,
            a.NAME              AS          tipo_departamento_codigo_nombre,
            a.U_CODIGO          AS          tipo_departamento_codigo_referencia,
            a.U_NOMBRE          AS          tipo_departamento_nombre,

            b.CODE              AS          tipo_gerencia_codigo,
            b.NAME              AS          tipo_gerencia_codigo_nombre,
            b.U_CODIGO          AS          tipo_gerencia_codigo_referencia,
            b.U_NOMBRE          AS          tipo_gerencia_nombre
            
            FROM [CSF_PRUEBA].[dbo].[@A1A_TIDE] a
            LEFT OUTER JOIN [CSF_PRUEBA].[dbo].[@A1A_TIGE] b ON a.U_CODGER = b.U_CODIGO

            WHERE b.CODE = ?

            ORDER BY a.U_CODIGO";

            try {
                $connMSSQL  = getConnectionMSSQLv1();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01]); 

                while ($rowMSSQL = $stmtMSSQL->fetch()) {
                    $detalle    = array(
                        'tipo_departamento_codigo'                      => $rowMSSQL['tipo_departamento_codigo'],
                        'tipo_departamento_codigo_nombre'               => $rowMSSQL['tipo_departamento_codigo_nombre'],
                        'tipo_departamento_codigo_referencia'           => $rowMSSQL['tipo_departamento_codigo_referencia'],
                        'tipo_departamento_nombre'                      => trim(strtoupper($rowMSSQL['tipo_departamento_nombre'])),
                        'tipo_gerencia_codigo'                          => $rowMSSQL['tipo_gerencia_codigo'],
                        'tipo_gerencia_codigo_nombre'                   => $rowMSSQL['tipo_gerencia_codigo_nombre'],
                        'tipo_gerencia_codigo_referencia'               => $rowMSSQL['tipo_gerencia_codigo_referencia'],
                        'tipo_gerencia_nombre'                          => trim(strtoupper($rowMSSQL['tipo_gerencia_nombre']))
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'tipo_departamento_codigo'                      => '',
                        'tipo_departamento_codigo_nombre'               => '',
                        'tipo_departamento_codigo_referencia'           => '',
                        'tipo_departamento_nombre'                      => '',
                        'tipo_gerencia_codigo'                          => '',
                        'tipo_gerencia_codigo_nombre'                   => '',
                        'tipo_gerencia_codigo_referencia'               => '',
                        'tipo_gerencia_nombre'                          => ''
                    );

                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                }

                $stmtMSSQL->closeCursor();
                $stmtMSSQL = null;
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

    $app->get('/v1/000/departamento/gerencia/referencia/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val01      = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
            a.CODE              AS          tipo_departamento_codigo,
            a.NAME              AS          tipo_departamento_codigo_nombre,
            a.U_CODIGO          AS          tipo_departamento_codigo_referencia,
            a.U_NOMBRE          AS          tipo_departamento_nombre,

            b.CODE              AS          tipo_gerencia_codigo,
            b.NAME              AS          tipo_gerencia_codigo_nombre,
            b.U_CODIGO          AS          tipo_gerencia_codigo_referencia,
            b.U_NOMBRE          AS          tipo_gerencia_nombre
            
            FROM [CSF_PRUEBA].[dbo].[@A1A_TIDE] a
            LEFT OUTER JOIN [CSF_PRUEBA].[dbo].[@A1A_TIGE] b ON a.U_CODGER = b.U_CODIGO

            WHERE b.U_CODIGO = ?

            ORDER BY a.U_CODIGO";

            try {
                $connMSSQL  = getConnectionMSSQLv1();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01]); 

                while ($rowMSSQL = $stmtMSSQL->fetch()) {
                    $detalle    = array(
                        'tipo_departamento_codigo'                      => $rowMSSQL['tipo_departamento_codigo'],
                        'tipo_departamento_codigo_nombre'               => $rowMSSQL['tipo_departamento_codigo_nombre'],
                        'tipo_departamento_codigo_referencia'           => $rowMSSQL['tipo_departamento_codigo_referencia'],
                        'tipo_departamento_nombre'                      => trim(strtoupper($rowMSSQL['tipo_departamento_nombre'])),
                        'tipo_gerencia_codigo'                          => $rowMSSQL['tipo_gerencia_codigo'],
                        'tipo_gerencia_codigo_nombre'                   => $rowMSSQL['tipo_gerencia_codigo_nombre'],
                        'tipo_gerencia_codigo_referencia'               => $rowMSSQL['tipo_gerencia_codigo_referencia'],
                        'tipo_gerencia_nombre'                          => trim(strtoupper($rowMSSQL['tipo_gerencia_nombre']))
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'tipo_departamento_codigo'                      => '',
                        'tipo_departamento_codigo_nombre'               => '',
                        'tipo_departamento_codigo_referencia'           => '',
                        'tipo_departamento_nombre'                      => '',
                        'tipo_gerencia_codigo'                          => '',
                        'tipo_gerencia_codigo_nombre'                   => '',
                        'tipo_gerencia_codigo_referencia'               => '',
                        'tipo_gerencia_nombre'                          => ''
                    );

                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                }

                $stmtMSSQL->closeCursor();
                $stmtMSSQL = null;
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

    $app->get('/v1/000/colaborador', function($request) {
        require __DIR__.'/../src/connect.php';

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

            FROM [CSF_PRUEBA].[dbo].[empleados_AxisONE] a";

        try {
            $connMSSQL  = getConnectionMSSQLv1();

            $stmtMSSQL00= $connMSSQL->prepare($sql00);
            $stmtMSSQL00->execute([$val01]);

            while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                switch ($rowMSSQL00['tipo_sexo_codigo']) {
                    case 'M':
                        $tipo_sexo_nombre = 'MASCULINO';
                        break;
                    
                    case 'F':
                        $tipo_sexo_nombre = 'FEMENINO';
                        break;
                }

                switch ($rowMSSQL00['estado_civil_codigo']) {
                    case 'S':
                        $estado_civil_nombre = 'SOLTERO/A';
                        break;
                    
                    case 'C':
                        $estado_civil_nombre = 'CASADO/A';
                        break;

                    case 'D':
                        $estado_civil_nombre = 'DIVORCIADO/A';
                        break;

                    case 'V':
                        $estado_civil_nombre = 'VIUDO/A';
                        break;
                }

                $detalle    = array(
                    'codigo'                        => $rowMSSQL00['codigo'],
                    'estado'                        => trim(strtoupper($rowMSSQL00['estado'])),
                    'documento'                     => $rowMSSQL00['documento'],
                    'apellido_1'                    => trim(strtoupper($rowMSSQL00['apellido_1'])),
                    'apellido_2'                    => trim(strtoupper($rowMSSQL00['apellido_2'])),
                    'nombre_1'                      => trim(strtoupper($rowMSSQL00['nombre_1'])),
                    'nombre_2'                      => trim(strtoupper($rowMSSQL00['nombre_2'])),
                    'nombre_completo'               => trim(strtoupper($rowMSSQL00['nombre_completo'])),
                    'tipo_sexo_codigo'              => trim(strtoupper($rowMSSQL00['tipo_sexo_codigo'])),
                    'tipo_sexo_nombre'              => trim(strtoupper($tipo_sexo_nombre)),
                    'estado_civil_codigo'           => trim(strtoupper($rowMSSQL00['estado_civil_codigo'])),
                    'estado_civil_nombre'           => trim(strtoupper($estado_civil_nombre)),
                    'email'                         => trim(strtolower($rowMSSQL00['email'])),
                    'fecha_nacimiento'              => $rowMSSQL00['fecha_nacimiento'],
                    'fecha_nacimiento_2'            => date("d/m/Y", strtotime($rowMSSQL00['fecha_nacimiento'])),
                    'usuario_id'                    => $rowMSSQL00['usuario_id'],
                    'usuario_sap'                   => trim(strtoupper($rowMSSQL00['usuario_sap'])),
                    'tarjeta_id'                    => $rowMSSQL00['tarjeta_id'],
                    'cargo_codigo'                  => $rowMSSQL00['cargo_codigo'],
                    'cargo_nombre'                  => trim(strtoupper($rowMSSQL00['cargo_nombre'])),
                    'gerencia_codigo'               => $rowMSSQL00['gerencia_codigo'],
                    'gerencia_nombre'               => trim(strtoupper($rowMSSQL00['gerencia_nombre'])),
                    'departamento_codigo'           => $rowMSSQL00['departamento_codigo'],
                    'departamento_nombre'           => trim(strtoupper($rowMSSQL00['departamento_nombre'])),
                    'superior_cargo_codigo'         => $rowMSSQL00['superior_cargo_codigo'],
                    'superior_cargo_nombre'         => trim(strtoupper($rowMSSQL00['superior_cargo_nombre'])),
                    'superior_manager_nombre'       => trim(strtoupper($rowMSSQL00['superior_manager_nombre'])),
                    'superior_manager_email'        => trim(strtolower($rowMSSQL00['superior_manager_email']))
                );

                $result[]   = $detalle;
            }

            if (isset($result)){
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } else {
                $detalle    = array(
                    'codigo'                        => '',
                    'estado'                        => '',
                    'documento'                     => '',
                    'apellido_1'                    => '',
                    'apellido_2'                    => '',
                    'nombre_1'                      => '',
                    'nombre_2'                      => '',
                    'nombre_completo'               => '',
                    'tipo_sexo_codigo'              => '',
                    'tipo_sexo_nombre'              => '',
                    'estado_civil_codigo'           => '',
                    'estado_civil_nombre'           => '',
                    'email'                         => '',
                    'fecha_nacimiento'              => '',
                    'fecha_nacimiento_2'            => '',
                    'usuario_id'                    => '',
                    'usuario_sap'                   => '',
                    'tarjeta_id'                    => '',
                    'cargo_codigo'                  => '',
                    'cargo_nombre'                  => '',
                    'gerencia_codigo'               => '',
                    'gerencia_nombre'               => '',
                    'departamento_codigo'           => '',
                    'departamento_nombre'           => '',
                    'superior_cargo_codigo'         => '',
                    'superior_cargo_nombre'         => '',
                    'superior_manager_nombre'       => '',
                    'superior_manager_email'        => ''
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

    $app->get('/v1/000/colaborador/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val01      = $request->getAttribute('codigo');
        
        if (isset($val01)) {
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

                FROM [CSF_PRUEBA].[dbo].[empleados_AxisONE] a

                WHERE a.CedulaEmpleado = ?";

            try {
                $connMSSQL  = getConnectionMSSQLv1();

                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val01]);

                while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                    switch ($rowMSSQL00['tipo_sexo_codigo']) {
                        case 'M':
                            $tipo_sexo_nombre = 'MASCULINO';
                            break;
                        
                        case 'F':
                            $tipo_sexo_nombre = 'FEMENINO';
                            break;
                    }

                    switch ($rowMSSQL00['estado_civil_codigo']) {
                        case 'S':
                            $estado_civil_nombre = 'SOLTERO/A';
                            break;
                        
                        case 'C':
                            $estado_civil_nombre = 'CASADO/A';
                            break;

                        case 'D':
                            $estado_civil_nombre = 'DIVORCIADO/A';
                            break;

                        case 'V':
                            $estado_civil_nombre = 'VIUDO/A';
                            break;
                    }

                    $detalle    = array(
                        'codigo'                        => $rowMSSQL00['codigo'],
                        'estado'                        => trim(strtoupper($rowMSSQL00['estado'])),
                        'documento'                     => $rowMSSQL00['documento'],
                        'apellido_1'                    => trim(strtoupper($rowMSSQL00['apellido_1'])),
                        'apellido_2'                    => trim(strtoupper($rowMSSQL00['apellido_2'])),
                        'nombre_1'                      => trim(strtoupper($rowMSSQL00['nombre_1'])),
                        'nombre_2'                      => trim(strtoupper($rowMSSQL00['nombre_2'])),
                        'nombre_completo'               => trim(strtoupper($rowMSSQL00['nombre_completo'])),
                        'tipo_sexo_codigo'              => trim(strtoupper($rowMSSQL00['tipo_sexo_codigo'])),
                        'tipo_sexo_nombre'              => trim(strtoupper($tipo_sexo_nombre)),
                        'estado_civil_codigo'           => trim(strtoupper($rowMSSQL00['estado_civil_codigo'])),
                        'estado_civil_nombre'           => trim(strtoupper($estado_civil_nombre)),
                        'email'                         => trim(strtolower($rowMSSQL00['email'])),
                        'fecha_nacimiento'              => $rowMSSQL00['fecha_nacimiento'],
                        'fecha_nacimiento_2'            => date("d/m/Y", strtotime($rowMSSQL00['fecha_nacimiento'])),
                        'usuario_id'                    => $rowMSSQL00['usuario_id'],
                        'usuario_sap'                   => trim(strtoupper($rowMSSQL00['usuario_sap'])),
                        'tarjeta_id'                    => $rowMSSQL00['tarjeta_id'],
                        'cargo_codigo'                  => $rowMSSQL00['cargo_codigo'],
                        'cargo_nombre'                  => trim(strtoupper($rowMSSQL00['cargo_nombre'])),
                        'gerencia_codigo'               => $rowMSSQL00['gerencia_codigo'],
                        'gerencia_nombre'               => trim(strtoupper($rowMSSQL00['gerencia_nombre'])),
                        'departamento_codigo'           => $rowMSSQL00['departamento_codigo'],
                        'departamento_nombre'           => trim(strtoupper($rowMSSQL00['departamento_nombre'])),
                        'superior_cargo_codigo'         => $rowMSSQL00['superior_cargo_codigo'],
                        'superior_cargo_nombre'         => trim(strtoupper($rowMSSQL00['superior_cargo_nombre'])),
                        'superior_manager_nombre'       => trim(strtoupper($rowMSSQL00['superior_manager_nombre'])),
                        'superior_manager_email'        => trim(strtolower($rowMSSQL00['superior_manager_email']))
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle    = array(
                        'codigo'                        => '',
                        'estado'                        => '',
                        'documento'                     => '',
                        'apellido_1'                    => '',
                        'apellido_2'                    => '',
                        'nombre_1'                      => '',
                        'nombre_2'                      => '',
                        'nombre_completo'               => '',
                        'tipo_sexo_codigo'              => '',
                        'tipo_sexo_nombre'              => '',
                        'estado_civil_codigo'           => '',
                        'estado_civil_nombre'           => '',
                        'email'                         => '',
                        'fecha_nacimiento'              => '',
                        'fecha_nacimiento_2'            => '',
                        'usuario_id'                    => '',
                        'usuario_sap'                   => '',
                        'tarjeta_id'                    => '',
                        'cargo_codigo'                  => '',
                        'cargo_nombre'                  => '',
                        'gerencia_codigo'               => '',
                        'gerencia_nombre'               => '',
                        'departamento_codigo'           => '',
                        'departamento_nombre'           => '',
                        'superior_cargo_codigo'         => '',
                        'superior_cargo_nombre'         => '',
                        'superior_manager_nombre'       => '',
                        'superior_manager_email'        => ''
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

    $app->get('/v1/000/colaboradores/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val01      = $request->getAttribute('codigo');
        
        if (isset($val01)) {
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

                FROM [CSF_PRUEBA].[dbo].[empleados_AxisONE] a
                INNER JOIN [CSF_PRUEBA].[dbo].[empleados_AxisONE] b ON a.CodCargoSuperior = b.CodigoCargo

                WHERE b.CedulaEmpleado = ?";

            try {
                $connMSSQL  = getConnectionMSSQLv1();
                
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val01]);

                while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                    switch ($rowMSSQL00['tipo_sexo_codigo']) {
                        case 'M':
                            $tipo_sexo_nombre = 'MASCULINO';
                            break;
                        
                        case 'F':
                            $tipo_sexo_nombre = 'FEMENINO';
                            break;
                    }

                    switch ($rowMSSQL00['estado_civil_codigo']) {
                        case 'S':
                            $estado_civil_nombre = 'SOLTERO/A';
                            break;
                        
                        case 'C':
                            $estado_civil_nombre = 'CASADO/A';
                            break;

                        case 'D':
                            $estado_civil_nombre = 'DIVORCIADO/A';
                            break;

                        case 'V':
                            $estado_civil_nombre = 'VIUDO/A';
                            break;
                    }

                    $detalle    = array(
                        'codigo'                        => $rowMSSQL00['codigo'],
                        'estado'                        => trim(strtoupper($rowMSSQL00['estado'])),
                        'documento'                     => $rowMSSQL00['documento'],
                        'apellido_1'                    => trim(strtoupper($rowMSSQL00['apellido_1'])),
                        'apellido_2'                    => trim(strtoupper($rowMSSQL00['apellido_2'])),
                        'nombre_1'                      => trim(strtoupper($rowMSSQL00['nombre_1'])),
                        'nombre_2'                      => trim(strtoupper($rowMSSQL00['nombre_2'])),
                        'nombre_completo'               => trim(strtoupper($rowMSSQL00['nombre_completo'])),
                        'tipo_sexo_codigo'              => trim(strtoupper($rowMSSQL00['tipo_sexo_codigo'])),
                        'tipo_sexo_nombre'              => trim(strtoupper($tipo_sexo_nombre)),
                        'estado_civil_codigo'           => trim(strtoupper($rowMSSQL00['estado_civil_codigo'])),
                        'estado_civil_nombre'           => trim(strtoupper($estado_civil_nombre)),
                        'email'                         => trim(strtolower($rowMSSQL00['email'])),
                        'fecha_nacimiento'              => $rowMSSQL00['fecha_nacimiento'],
                        'fecha_nacimiento_2'            => date("d/m/Y", strtotime($rowMSSQL00['fecha_nacimiento'])),
                        'usuario_id'                    => $rowMSSQL00['usuario_id'],
                        'usuario_sap'                   => trim(strtoupper($rowMSSQL00['usuario_sap'])),
                        'tarjeta_id'                    => $rowMSSQL00['tarjeta_id'],
                        'cargo_codigo'                  => $rowMSSQL00['cargo_codigo'],
                        'cargo_nombre'                  => trim(strtoupper($rowMSSQL00['cargo_nombre'])),
                        'gerencia_codigo'               => $rowMSSQL00['gerencia_codigo'],
                        'gerencia_nombre'               => trim(strtoupper($rowMSSQL00['gerencia_nombre'])),
                        'departamento_codigo'           => $rowMSSQL00['departamento_codigo'],
                        'departamento_nombre'           => trim(strtoupper($rowMSSQL00['departamento_nombre'])),
                        'superior_cargo_codigo'         => $rowMSSQL00['superior_cargo_codigo'],
                        'superior_cargo_nombre'         => trim(strtoupper($rowMSSQL00['superior_cargo_nombre'])),
                        'superior_manager_nombre'       => trim(strtoupper($rowMSSQL00['superior_manager_nombre'])),
                        'superior_manager_email'        => trim(strtolower($rowMSSQL00['superior_manager_email']))
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle    = array(
                        'codigo'                        => '',
                        'estado'                        => '',
                        'documento'                     => '',
                        'apellido_1'                    => '',
                        'apellido_2'                    => '',
                        'nombre_1'                      => '',
                        'nombre_2'                      => '',
                        'nombre_completo'               => '',
                        'tipo_sexo_codigo'              => '',
                        'tipo_sexo_nombre'              => '',
                        'estado_civil_codigo'           => '',
                        'estado_civil_nombre'           => '',
                        'email'                         => '',
                        'fecha_nacimiento'              => '',
                        'fecha_nacimiento_2'            => '',
                        'usuario_id'                    => '',
                        'usuario_sap'                   => '',
                        'tarjeta_id'                    => '',
                        'cargo_codigo'                  => '',
                        'cargo_nombre'                  => '',
                        'gerencia_codigo'               => '',
                        'gerencia_nombre'               => '',
                        'departamento_codigo'           => '',
                        'departamento_nombre'           => '',
                        'superior_cargo_codigo'         => '',
                        'superior_cargo_nombre'         => '',
                        'superior_manager_nombre'       => '',
                        'superior_manager_email'        => ''
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