 <?php

$servername = "server";
$username = "root";
$password = "pass";
$dbname = "db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
?> 


<?php


$sql = "SELECT id from logs where tAnswer like '%+%' group by tStart union all SELECT id from logs where state like 'Mobile%' and (omob like '07%' or omob like '+%') group by tStart union all SELECT id from logs where tEnd like '%+%' and imob is not null and state like '%Lan%' and tAnswer not like '%+%' and (imob like '07%' or imob like '+%') group by tStart";

$result = $conn->query($sql);
$valid=array();

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        #echo  $row["id"];
        $valid[]=$row["id"];
        #echo "\n";
    }
} else {
    echo "0 results";
}
#var_dump($valid);
$valid = implode("','",$valid);
#$del = "select * from logs where id in ('".$valid."')";
$del = "delete from logs where id not in ('".$valid."')";

if ($conn->query($del) === TRUE) {
    echo "Record deleted successfully";
} else {
    echo "Error deleting record: " . $conn->error;
}


#$query=mysqli_query($conn, "SELECT name FROM users WHERE id IN ('".$array."')");
/**$sql = "UPDATE logs SET {$field}='{$item}' WHERE hashkey='{$keys}'";

if ($conn->query($sql) === TRUE) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $conn->error;
}*/
