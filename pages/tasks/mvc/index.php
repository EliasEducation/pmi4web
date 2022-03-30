<?


$dbh = '';
try {
	$dbh = new PDO('mysql:host=localhost;dbname=classicmodels', 'test_user', 'Password21!');
}
catch( PDOException $Exception ) {
	var_dump($Exception);
}

$res = $dbh->query("SELECT * FROM customers WHERE customerNumber = 103");

foreach($dbh->query("SELECT * FROM customers WHERE customerNumber = 2222") as $row) {
	var_dump($row);
}

?>
