<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "batman";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
?> 


<?php




$dir = "/Users/bat/Desktop/23344/cdr";         
$pattern = '/\.(cdr|CDR)$/'; // check only file with these ext.          
$newstamp = 0;            
$newname = "";

if ($handle = opendir($dir)) {               
       while (false !== ($fname = readdir($handle)))  {            
         // Eliminate current directory, parent directory            
         if (preg_match('/^\.{1,2}$/',$fname)) continue;            
         // Eliminate other pages not in pattern            
         if (! preg_match($pattern,$fname)) continue;            
         $timedat = filemtime("$dir/$fname");            
         if ($timedat > $newstamp) {
            $newstamp = $timedat;
            $newname = $fname;
          }
         }
        }
closedir ($handle);



$file1 = file_get_contents(':/Users/bat/Desktop/23344/cdr/'.$newname, FILE_USE_INCLUDE_PATH);

$arr1 = explode("\n", $file1);
foreach ($arr1 as $key => $value) {
    $colArray = [];
    // $colArray['id'] = null;
    $colArray['hashkey'] = md5(uniqid(rand(), true));

    $split = explode(";", $value);
    foreach ($split as $key => $val) {
        # code...
        $arr   = (explode('=', $val));
        $field = 'ch';
        $item  = '0';
        $field = $arr[0];
        $item  = $arr[1];
        $item  = str_replace(str_split(')(\/'), '', $item);

        $colArray[$field] = $item;
    }

    $columns = implode(', ', array_keys($colArray));
    $values = implode(', ', $colArray);
    $sql = "INSERT INTO `bat`.`logs`  (" . $columns . ") VALUES (" . $values . ")";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
