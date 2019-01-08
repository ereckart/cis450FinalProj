<?php
function sendText($number, $message) {
    $xml=simplexml_load_file("https://dreamacinc.com/admin/PhoneAPI/publicAPI.php?api_key=hbjsuuilkwbhwerwebkkjbogwerxdtxui&phone=".$number."&message=".$message);
    return $xml->status;
}
?>
