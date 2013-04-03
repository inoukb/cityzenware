<?php
//Send command to wakeup cityzenware box
$ParametersArray = array(
'Reference=2013010005',
'Lines[]='.urlencode('$GSMINFO'),
'Lines[]='.urlencode('$CALL=[+33666723718]')
);
$Context = stream_context_create(array('http' => array(
'method' => 'POST',
'content' => implode('&', $ParametersArray)
)));
fopen('https://178.32.211.101/php/Send.php', 'r', false, $Context);
?>

