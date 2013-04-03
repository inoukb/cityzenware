
<?php
// Receive command from cityzenbox and store in db
require("dbcredentials.php");
$filename = 'log.txt';
// Opens a connection to MySQL server
try
{
    $db_selected = new PDO('mysql:host=localhost;dbname=' . $database, $username, $password);
}
catch (Exception $e)
{
        die('error: ' . $e->getMessage());
}
// Process data from CityZenWare
foreach ($_POST['Lines'] as $line) {
  // Write received string in debug file
  if (is_writable($filename)) {
    if (!$handle = fopen($filename, 'a')) {
      echo "Can't Open $filename";
      exit;
    }
    if (fwrite($handle, $_POST['Lines']) === FALSE) {
      echo "Can't write in $filename";
      exit;
    }
    fwrite($handle, "\n");
    fclose($handle);
  }
  else {
      echo "$filename no right";
  }
  // Process received string and add to database
  $receivedArray = explode(',', $_POST['Lines']);
  echo print_r($receivedArray);
  if ($receivedArray[2] != '' && $receivedArray[2] != ',') {
    $req = $db_selected->prepare('INSERT INTO particulate(particulate, lat, lng, time) VALUES(:particulate, :lat, :lng, :time)');
    $req->execute(array(
        'particulate' => $receivedArray[12],
        'lat' => $receivedArray[3],
        'lng' => $receivedArray[2],
        'time' => $receivedArray[1]
        ));
  }
  else {
    die ('CityZenBox sent empty string');
  }
}
?>