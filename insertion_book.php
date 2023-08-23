<?php

try {
	$dbh = new PDO('mysql:host=localhost;dbname=bookbook', 'root', '');

$file = fopen("book_data.csv", "r");
	while (!feof($file)) {
        $line[] = fgetcsv($file, 100000, ",");
    }
	fclose($file);

	//print_r ($line);
	for ($i = 0; $i <= count($line) - 1; $i++){
		print $i;
		print PHP_EOL;
		
	


			$result3=$dbh->query ("SELECT `format_id`, `name` FROM `format` WHERE name LIKE '".addslashes($line[$i][3])."'");
			$rows3=$result3->fetchAll();
			if (count($rows3)) {
				$formatid=$rows3[0]["format_id"];
			} else {
				$dbh->query("INSERT INTO `format`(`name`) VALUES ('".addslashes($line[$i][3])."')");
				$formatid=$dbh->lastInsertId();
			}
			
		



		$dbh->query ("INSERT into book (title,description,isbn,image,rating,rating_count,pages,format_id)
             values ('" . addslashes($line[$i][9]) . "','" . addslashes($line[$i][1]) . "','" . addslashes($line[$i][4]) . "','" . addslashes($line[$i][11]) . "','" . addslashes($line[$i][6]) . "','" . addslashes($line[$i][7]) . "','" . addslashes($line[$i][5]) . "','" . $formatid. "');");
		$bookid=$dbh->lastInsertId();
		

		
		$t=explode("|",$line[$i][0]);
		$t=array_unique($t);
		foreach($t as $author) {

			$result=$dbh->query ("SELECT `author_id`, `name` FROM `author` WHERE name LIKE '".addslashes($author)."'");
			$rows=$result->fetchAll();
			if (count($rows)) {
				$authorid=$rows[0]["author_id"];
			} else {
				$dbh->query("INSERT INTO `author`(`name`) VALUES ('".addslashes($author)."')");
				$authorid=$dbh->lastInsertId();
			}
			
			$dbh->query("INSERT INTO `book_author`(`book_id`,`author_id`) VALUES ('".$bookid."','".$authorid."')");
		}
		
		
		
		$y=explode("|",$line[$i][10]);
		$y=array_unique($y);
		foreach($y as $category) {
		
			$result2=$dbh->query ("SELECT `category_id`, `name` FROM `category` WHERE name LIKE '".addslashes($category)."'");
			$rows2=$result2->fetchAll();
			if (count($rows2)) {
				$categoryid=$rows2[0]["category_id"];
				
			} else {
				$dbh->query("INSERT INTO `category`(`name`) VALUES ('".addslashes($category)."')");
				$categoryid=$dbh->lastInsertId();
			}
			$dbh->query("INSERT INTO `book_category`(`book_id`,`category_id`) VALUES ('".$bookid."','".$categoryid."');");
			//print "INSERT INTO `book_category`(`book_id`,`category_id`) VALUES ('".$bookid."','".$categoryid."');";
			print $bookid;
		}	
		
	
	}
	
	$dbh = null;
}catch (PDOException $e) {
print "Oups !: Perdu<br/>";
	
    die();
}


?>
