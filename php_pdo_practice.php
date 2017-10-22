<?php
$hostname = "sql.njit.edu";
$username = "ejc23";
$password = "carabao74";
$conn = NULL;
try 
{
    $conn = new PDO("mysql:host=$hostname;dbname=ejc23",
    $username, $password);

    echo "<h1>Connected Successfuly </h1> <br>";
    
}
catch(PDOException $e)
{
	// echo "Connection failed: " . $e->getMessage();
	http_error("500 Internal Server Error\n\n"."There was a SQL error:\n\n" . $e->getMessage());
}

// Runs SQL query and returns results (if valid)
function runQuery($query) {
	global $conn;
    try {
		$q = $conn->prepare($query);
		$q->execute();
		$results = $q->fetchAll();
		$q->closeCursor();
		return $results;	
	} catch (PDOException $e) {
		http_error("500 Internal Server Error\n\n"."There was a SQL error:\n\n" . $e->getMessage());
	}	  
}

function http_error($message) 
{
	header("Content-type: text/plain");
	die($message);
}



$sql = "SELECT * FROM accounts WHERE id<6";
$results = runQuery($sql);

echo "The number of records found in accounts whose id is less than 6 is " . count($results) . "<br>";
if(count($results) > 0)
{
	echo "<table border=\"1\"><tr><th>ID</th><th>Email</th><th>First Name</th><th>Pass</th></tr>";
	foreach ($results as $row) {
		echo "<tr><td>".$row["id"]."</td><td>".$row["email"]."</td><td>".$row["fname"]."</td><td>".$row["password"]."</td></tr>";
	}
	
}else{
    echo '0 results';
}

?>