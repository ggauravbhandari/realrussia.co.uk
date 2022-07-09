<?php
class AuroraService
{
    private $serverAuroraDB = "127.0.0.1";
    private $userAuroraDB = "Aurora";
    private $passwordAuroraDB = "N8he5Q46TDPxy8yQOnQW";

    const PARTNER_REAL_RUSSA = 11;

    /**
     * CBW edit
     * @param int $partnerID - AuroraService::PARTNER_REAL_RUSSA = 11
     */
    function getChannelID(int $tourId, int $partnerID = AuroraService::PARTNER_REAL_RUSSA)
    {

        $channelID = 0;
        
        $connectionInfo = array("Database" => "Aurora", "UID" => $this->userAuroraDB, "PWD" => $this->passwordAuroraDB);
        $conn = sqlsrv_connect($this->serverAuroraDB, $connectionInfo);

        if( $conn === false ) {
            die( print_r( sqlsrv_errors(), true));
        }

        $sql = "IF EXISTS(SELECT channelID FROM tblChannelAllocations WHERE partnerID =  " . $partnerID . " AND itemType = 56 AND itemID = " . $tourId . ") 
                SELECT channelID FROM Aurora.dbo.tblChannelAllocations WHERE partnerID = " . $partnerID . " AND itemType = 56 AND itemID = " . $tourId . "
                ELSE
                SELECT channelID FROM Aurora.dbo.tblChannelAllocations WHERE partnerID = " . $partnerID . " AND itemType = 56 AND  isDefault = 1;";

        $stmt = sqlsrv_query($conn, $sql);

        if( $stmt !== false && sqlsrv_fetch( $stmt ) !== false) {
            $channelID = sqlsrv_get_field($stmt, 0);
        }

        sqlsrv_close($conn);

        return $channelID;
    }
    /* CBW end edit */
}
?>