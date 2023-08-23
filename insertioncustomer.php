<?php
try {
	$dbh = new PDO('mysql:host=localhost;dbname=bookbook', 'root', '');

$file = fopen("fdfdsfds.csv", "r");
	while (!feof($file)) {
        $line[] = fgetcsv($file, 10000, ";");
    }
	fclose($file);

	//print_r ($line);
    for ($i = 0; $i <= count($line) - 1; $i++){
    	print $i;
    	print PHP_EOL;
    			$dbh->query("INSERT INTO `address`(`address`,`city`,`postal_code`) VALUES ('" . addslashes($line[$i][3]) . "','" . addslashes($line[$i][2]) . "','" . addslashes($line[$i][4])."');");
                $adressid=$dbh->lastInsertId();
    print ("INSERT INTO `staff`(`first_name`,`last_name`,`phone`,`email`,`adress_id`) VALUES ('" . addslashes($line[$i][1]) . "','" . addslashes($line[$i][0]) . "','" . addslashes($line[$i][5])."','" . addslashes($line[$i][6])."','" .$adressid."');");
                $dbh->query("INSERT INTO `staff`(`first_name`,`last_name`,`phone`,`email`,`address_id`) VALUES ('" . addslashes($line[$i][1]) . "','" . addslashes($line[$i][0]) . "','" . addslashes($line[$i][5])."','" . addslashes($line[$i][6])."','" .$adressid."');");
    		
    
    }
	
	$dbh = null;
}catch (PDOException $e) {
print "Oups !: Perdu<br/>";
	
    die();
}


?>
