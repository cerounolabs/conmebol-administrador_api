<?php
    require __DIR__.'/../src/connect.php';

    $DOMFICAUS      = 'SFHOLOX';
    $DOMFICAIP      = '0.0.0.0';

    function getActualizarEstado(){

        global $DOMFICAUS;
        global $DOMFICAIP;

        $sql00  =   "UPDATE [hum].[EVEFIC] SET EVEFICEST = (SELECT DOMFICCOD FROM [adm].[DOMFIC] WHERE DOMFICVAL = 'PERMISOEVENTOESTADO' AND DOMFICPAR = 3), EVEFICAUS = ?,	EVEFICAFH = GETDATE(), EVEFICAIP = ?  WHERE EVEFICFEH < CONVERT(varchar(10), GETDATE(), 103) AND EVEFICEST = (SELECT DOMFICCOD FROM [adm].[DOMFIC] WHERE DOMFICVAL = 'PERMISOEVENTOESTADO' AND DOMFICPAR = 1)";
   
        try {
            $connMSSQL  = getConnectionMSSQLv2();

            $stmtMSSQL00= $connMSSQL->prepare($sql00);
            $stmtMSSQL00->execute([$DOMFICAUS, $DOMFICAIP]);

            $stmtMSSQL00->closeCursor();
            $stmtMSSQL00    = null;

        } catch (PDOException $e) {
            echo "\n";
            echo 'Error getActualizarEstado(): '.$e;
        }

        $connMSSQL  = null;
    }

    echo "\n";
    echo "++++++++++++++++++++++++++PROCESO DE ACTUALIZACIÓN ESTADO++++++++++++++++++++++++++";
    echo "\n";

    echo "INICIO getActualizarEstado() => ".date('Y-m-d H:i:s');
    getActualizarEstado();
    echo "\n";
    echo "FIN getActualizarEstado() => ".date('Y-m-d H:i:s');
    echo "\n";
?>