<?php

class DAO {

private $host="localhost";
private $user="root";
private $password="";
private $database="bookbook";
private $charset='utf8';
private $connexion;
private $error;


public function __construct() {
	
}
public function connexion(){
    try {
        $this->connexion = new PDO('mysql:host='.$this->host.';dbname='.$this->database.';charset='.$this->charset,$this->user,$this->password);
    }
    catch(PDOException $e){
        $this->error=$e->getMessage();
    }
}

public function deconnexion() {
    $this->connexion=null;
}

public function executeQuery($sql) {
    try {
        $resultat=$this->connexion->query($sql);
        return $resultat->fetchAll();
    } catch (PDOException $e) {
        $this->error=$e->getMessage();
    }
}


public function getBook($depart="",$bookParPage="",$search=""){
    $sql="SELECT book.book_id, `title`, `description`, `isbn`, `image`, `rating`, `rating_count`, `pages`, `quantity`, `format_id` FROM `book`";

    $where=array();

    
    if($search){
        $sql.=" INNER JOIN book_author ON book_author.book_id=book.book_id INNER JOIN author ON author.author_id=book_author.author_id";
       // $sql.=" INNER JOIN book_category ON book_category.book_id=book.book_id INNER JOIN category ON category.category_id=book_category.category_id";
        $where[]="`title` LIKE '%".$search."%'";
        $where[]="author.name LIKE '%".$search."%'";
      //  $where[]="category.name LIKE '%".$search."%'";
    }
    if (!$search&&count($where)) {
        $sql.=" WHERE ".implode(" AND ",$where)." GROUP BY `book`.`book_id` ASC LIMIT $depart,$bookParPage";
    }
    if ($search&&count($where)) {
        $sql.=" WHERE ".implode(" OR ",$where)." GROUP BY `book`.`book_id` ASC LIMIT $depart,$bookParPage";
    }
    if (!count($where)) {
        $sql.=" GROUP BY `book`.`book_id` ASC LIMIT $depart,$bookParPage";
    }
   
    return $this->executeQuery($sql);

}
public function getCategorry($id_book=""){
    $sql3="SELECT book_category.book_id, category.name FROM `category` INNER JOIN book_category ON book_category.category_id=category.category_id ";
    $where=array();

    
    if($id_book){
        $where[]="book_category.book_id=".$id_book;
    }
    if (count($where)) {
        $sql3.=" WHERE ".implode(" AND ",$where)." GROUP BY category.name";
    }
    return $this->executeQuery($sql3);

}

 public function getAuthor($id_book=""){
     $sql4="SELECT  book_author.book_id, author.name FROM `author` INNER JOIN book_author ON book_author.author_id=author.author_id";
     $where=array();

     if($id_book){
        $where[]="book_author.book_id=".$id_book;
    }

    if (count($where)) {
        $sql4.=" WHERE ".implode(" AND ",$where)." GROUP BY author.name";
    }

 return $this -> executeQuery($sql4);
 }


public function page(){
    $sql2="SELECT title FROM `book` GROUP BY title";     
    return $this ->executeQuery($sql2);    
}

public function getLastError() {
    return $this->error;
}


public function getDescription($id_book=""){

    $sql="SELECT book.book_id , title, author.name,category.name, description, isbn, image, rating, rating_count, pages, quantity, format.name FROM `book` INNER JOIN format ON format.format_id=book.format_id INNER JOIN book_author ON book_author.book_id=book.book_id INNER JOIN author ON author.author_id=book_author.author_id INNER JOIN book_category ON book_category.book_id=book.book_id INNER JOIN category ON category.category_id=book_category.category_id WHERE book.book_id=$id_book GROUP BY author.name,category.name;";
    
    return $this->executeQuery($sql);
    
}

public function deleteBook($id_book){
    $sql="DELETE FROM book_author WHERE book_id='".$id_book."'; DELETE FROM book_category WHERE book_id='".$id_book."'; DELETE FROM book WHERE book_id='".$id_book."';";
    return $this->executeQuery($sql);
}

public function getCustomer(){
    $sql="SELECT first_name, last_name, customer_id FROM customer;";
    return $this->executeQuery($sql);
}

public function getStaff(){
    $sql="SELECT first_name, last_name, username, password, staff_id FROM staff;";
    return $this->executeQuery($sql);

}

public function setRental($rental_date="",$book_id="",$return_date="",$customer_id="",$staff_id=""){
    $sql="INSERT into rental (rental_date,book_id,return_date,customer_id,staff_id)
             values ('" . $rental_date . "','" . $book_id . "','" . $return_date . "','" . $customer_id . "','" . $staff_id . "');";
    return $this->executeQuery($sql);
}


public function getRental(){
    $sql="SELECT rental_id, book.title, customer.last_name, customer.first_name, customer.phone, return_date, staff_id  FROM rental INNER JOIN customer ON customer.customer_id=rental.customer_id INNER JOIN book ON book.book_id=rental.book_id  ORDER BY `rental`.`return_date` ASC";
    return $this->executeQuery($sql);
}

public function delRental($rental_id=""){
    $sql="DELETE FROM rental WHERE rental_id='".$rental_id."';";
    return $this->executeQuery($sql);
}



public function changeBook($tabAuthor,$tabDesc,$tabCategory,$idbook){

    $sql="DELETE FROM book_author WHERE book_id='".$idbook."'; DELETE FROM book_category WHERE book_id='".$idbook."'; DELETE FROM book WHERE book_id='".$idbook."';";
    $this->executeQuery($sql);
	$sql2="SELECT `isbn` FROM `book` WHERE isbn LIKE '".addslashes($tabDesc[5])."';";
    $result2=$this->executeQuery($sql2);	
            if(count($result2)){
                print "Attention ce code isbn est déja utilisé!";
            }else{ 

			$sql3="SELECT `format_id`, `name` FROM `format` WHERE name LIKE '".addslashes($tabDesc[1])."';";
			$result3=$this->executeQuery($sql3);
			if (count($result3)) {
				$formatid=$result3[0]["format_id"];				
			} else {
				$sql4="INSERT INTO `format`(`name`) VALUES ('".addslashes($tabDesc[1])."');";
				$this->executeQuery($sql4);				
				$sql5="SELECT `format_id`, `name` FROM `format` WHERE name LIKE '".addslashes($tabDesc[1])."';";
				$result5=$this->executeQuery($sql5);
				$formatid=$result5[0]["format_id"];
			}
		
		$sql15= "INSERT into book (title,book_id,description,isbn,image,rating,rating_count,pages,quantity,format_id)
             values ('" . addslashes($tabDesc[0]) . "','" . $idbook . "','" . addslashes($tabDesc[7]) . "','" . addslashes($tabDesc[5]) . "','" . addslashes($tabDesc[8]) . "','" . addslashes($tabDesc[2]) . "','" . addslashes($tabDesc[3]) . "','" . addslashes($tabDesc[4]) . "','" . addslashes($tabDesc[6]) . "','" . $formatid. "');";
		$this->executeQuery($sql15);
			
		$authors= array();
		$categories= array();
		
		for($i=0;$i<=count($tabAuthor) - 1;$i++){
		if($tabAuthor[$i] != ""){
			array_push($authors,$tabAuthor[$i]);
		}
		}
		
		for($i=0;$i<=count($tabCategory) - 1;$i++){
		if($tabCategory[$i] != ""){
			array_push($categories,$tabCategory[$i]);
		}
		}
		
		 foreach($authors as $value) {
               $sql7="SELECT `author_id`, `name` FROM `author` WHERE name LIKE '".addslashes($value)."';";
			$result7=$this->executeQuery($sql7);
			if (count($result7)) {
				$authorid=$result7[0]["author_id"];				
			} else {
				$sql8="INSERT INTO `author`(`name`) VALUES ('".addslashes($value)."');";
				$this->executeQuery($sql8);				
				$sql9="SELECT `author_id`, `name` FROM `author` WHERE name LIKE '".addslashes($value)."';";
				$result9=$this->executeQuery($sql9);
				$authorid=$result9[0]["author_id"];
			}
			   $sql10="INSERT INTO `book_author`(`book_id`,`author_id`) VALUES ('".$idbook."','".$authorid."');";
			   $this->executeQuery($sql10);
                }
				
		foreach($categories as $value) {
               $sql11="SELECT `category_id`, `name` FROM `category` WHERE name LIKE '".addslashes($value)."';";
			$result11=$this->executeQuery($sql11);
			if (count($result11)) {
				$categoryid=$result11[0]["category_id"];				
			} else {
				$sql12="INSERT INTO `category`(`name`) VALUES ('".addslashes($value)."');";
				$this->executeQuery($sql12);				
				$sql13="SELECT `category_id`, `name` FROM `category` WHERE name LIKE '".addslashes($value)."';";
				$result13=$this->executeQuery($sql13);
				$categoryid=$result13[0]["category_id"];
			}
			   $sql14="INSERT INTO `book_category`(`book_id`,`category_id`) VALUES ('".$idbook."','".$categoryid."');";
			   $this->executeQuery($sql14);
                }			
		print "Gagné!";
        header("location:./description.php?book_id=".$idbook."");
        }
    }
}


?>