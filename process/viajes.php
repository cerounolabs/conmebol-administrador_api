<?php
    require __DIR__.'/../src/connect.php';

    $DOMFICAUS      = 'SFHOLOX';
    $DOMFICAIP      = '0.0.0.0';

    function getFechaSolicitud(){

        global $DOMFICAUS;
        global $DOMFICAIP;

        $sql00  =   "UPDATE [via].[SOLDVU] SET SOLDVUEST = (SELECT DOMFICCOD FROM [adm].[DOMFIC] WHERE DOMFICVAL = 'VIAJESOLICITUDDETALLEVUELOESTADO' AND DOMFICPAR = 2), SOLDVUAUS = ?,	SOLDVUAFH = GETDATE(), SOLDVUAIP = ?  WHERE SOLDVUFEC < CONVERT(varchar(10), GETDATE(), 103) AND SOLDVUEST = (SELECT DOMFICCOD FROM [adm].[DOMFIC] WHERE DOMFICVAL = 'VIAJESOLICITUDDETALLEVUELOESTADO' AND DOMFICPAR = 1)";

        $sql01  =   "UPDATE [via].[SOLDHO] SET SOLDHOEST = (SELECT DOMFICCOD FROM [adm].[DOMFIC] WHERE DOMFICVAL = 'VIAJESOLICITUDDETALLEHOSPEDAJEESTADO' AND DOMFICPAR = 2), SOLDHOAUS = ?, SOLDHOAFH = GETDATE(), SOLDHOAIP = ? WHERE SOLDHOFOU < CONVERT(varchar(10), GETDATE(), 103) AND SOLDHOEST = (SELECT DOMFICCOD FROM [adm].[DOMFIC] WHERE DOMFICVAL = 'VIAJESOLICITUDDETALLEHOSPEDAJEESTADO' AND DOMFICPAR = 1)";

        $sql02  =   "UPDATE [via].[SOLDTR] SET SOLDTREST = (SELECT DOMFICCOD FROM [adm].[DOMFIC] WHERE DOMFICVAL = 'VIAJESOLICITUDDETALLETRASLADOESTADO' AND DOMFICPAR = 2), SOLDTRAUS = ?, SOLDTRAFH = GETDATE(), SOLDTRAIP = ? WHERE  SOLDTRFEC < CONVERT(varchar(10), GETDATE(), 103) AND SOLDTREST = (SELECT DOMFICCOD FROM [adm].[DOMFIC] WHERE DOMFICVAL = 'VIAJESOLICITUDDETALLETRASLADOESTADO' AND DOMFICPAR = 1)";
   
        try {
            $connMSSQL  = getConnectionMSSQLv2();

            $stmtMSSQL00= $connMSSQL->prepare($sql00);
            $stmtMSSQL00->execute([$DOMFICAUS, $DOMFICAIP]);

            $stmtMSSQL01= $connMSSQL->prepare($sql01);
            $stmtMSSQL01->execute([$DOMFICAUS, $DOMFICAIP]);

            $stmtMSSQL02= $connMSSQL->prepare($sql02);
            $stmtMSSQL02->execute([$DOMFICAUS, $DOMFICAIP]);

            $stmtMSSQL00->closeCursor();
            $stmtMSSQL01->closeCursor();
            $stmtMSSQL02->closeCursor();

            $stmtMSSQL00    = null;
            $stmtMSSQL01    = null;
            $stmtMSSQL02    = null;

        } catch (PDOException $e) {
            echo "\n";
            echo 'Error getFechaSolicitud(): '.$e;
        }

        $connMSSQL  = null;
    }

    echo "\n";
    echo "++++++++++++++++++++++++++PROCESO DE ACTUALIZACIÓN FECHA SOLICITUD++++++++++++++++++++++++++";
    echo "\n";

    echo "INICIO getFechaSolicitud() => ".date('Y-m-d H:i:s');
    getFechaSolicitud();
    echo "\n";
    echo "FIN getFechaSolicitud() => ".date('Y-m-d H:i:s');
    echo "\n";
?>