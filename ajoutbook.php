<?php
if(isset($_GET["envoi"])){
try {
	$dbh = new PDO('mysql:host=localhost;dbname=bookbook', 'root', '');

    $result5=$dbh->query ("SELECT `isbn` FROM `book` WHERE isbn LIKE '".addslashes($_GET['isbn'])."'");
    $rows5=$result5->fetchAll();
            if(count($rows5)){
                print "Livre existant";
            }else{

			$result3=$dbh->query ("SELECT `format_id`, `name` FROM `format` WHERE name LIKE '".addslashes($_GET['format'])."'");
			$rows3=$result3->fetchAll();
			if (count($rows3)) {
				$formatid=$rows3[0]["format_id"];
			} else {
				$dbh->query("INSERT INTO `format`(`name`) VALUES ('".addslashes($_GET['format'])."')");
				$formatid=$dbh->lastInsertId();
			}
			
		$dbh->query ("INSERT into book (title,description,isbn,image,rating,rating_count,pages,quantity,format_id)
             values ('" . addslashes($_GET['title']) . "','" . addslashes($_GET['description']) . "','" . addslashes($_GET['isbn']) . "','" . addslashes($_GET['picture']) . "','" . addslashes($_GET['rating']) . "','" . addslashes($_GET['rating_count']) . "','" . addslashes($_GET['pages']) . "','" . addslashes($_GET['quantity']) . "','" . $formatid. "');");
		$bookid=$dbh->lastInsertId();
		

		
            
            for($i=1;$i<7;$i++) {
                print $_GET['author'.$i];
                if ($_GET['author'.$i]!="") {
                    $author=$dbh->query ("SELECT `author_id`, `name` FROM `author` WHERE name LIKE '".addslashes($_GET['author'.$i])."'");
                    $authors=$author->fetchAll();
                    if (count($authors)) {
                        $authorid=$authors[0]["author_id"];
                    } else {
                        $dbh->query("INSERT INTO `author`(`name`) VALUES ('".addslashes($_GET['author'.$i])."')");
                        $authorid=$dbh->lastInsertId();
                    }$dbh->query("INSERT INTO `book_author`(`book_id`,`author_id`) VALUES ('".$bookid."','".$authorid."')");}
                }
                    
		
			
            for($i=1;$i<7;$i++) {
                if ($_GET['category'.$i]!="") {
                    $category=$dbh->query ("SELECT `category_id`, `name` FROM `category` WHERE name LIKE '".addslashes($_GET['category'.$i])."'");
                    $categorys=$category->fetchAll();
                    if (count($categorys)) {
                        $categoryid=$categorys[0]["category_id"];
                    } else {
                        $dbh->query("INSERT INTO `category`(`name`) VALUES ('".addslashes($_GET['category'.$i])."')");
                        $categoryid=$dbh->lastInsertId();
                    }$dbh->query("INSERT INTO `book_category`(`book_id`,`category_id`) VALUES ('".$bookid."','".$categoryid."')");}
                }
			
		print "Gagné!";
        header("location:./index.php");
        }
	$dbh = null;
}catch (PDOException $e) {
print "Oups !: Perdu<br/>";
    die();
}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  </head>
    <title>Library</title>
</head>
<body style="background-image:url(book.png);">
    <header>
        <div class="text-light">
        <img src="livre.png" class="float-start">
        <img src="livre.png" class="float-end">
        <h1 class="text-center">Library</h1>
        </div>
        <nav class="navbar navbar-expand-lg m-auto " data-bs-theme="dark">
            <div class="container-fluid d-flex justify-content-evenly">
                <div class="row">
                    <div class="collapse navbar-collapse " id="navbarNav">
                        <ul class="navbar-nav " >
                            <li class="nav-item">
                                <a class="nav-link " aria-current="page" href="index.php">Home</a>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link " href="customers.php">Customer
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="emprunt.php">Borrow</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" style='border-bottom:solid 1px white;' href="ajoutbook.php">Add a book</a>
                            </li>
                         </ul>
                    </div>
                </div>
            </div>
        </nav>
    </header>
<div  >
    <h1 class="text-light text-center">Add a book</h1>
	<form action="" method="GET">
    <div class=" container-fluid d-flex justify-content-evenly row ">
	
        <input name= "title" class="form-control w-25 m-3" type="text" placeholder="Title" aria-label="default input example"required>
        <input name= "format" class="form-control w-25 m-3" type="text" placeholder="Format" aria-label="default input example"required>
        <input name= "rating" class="form-control w-25 m-3" type="text" placeholder="rating" aria-label="default input example">
        <input name= "rating_count" class="form-control w-25 m-3" type="text" placeholder="rating_count" aria-label="default input example">
        <input name= "pages" class="form-control w-25 m-3" type="text" placeholder="pages" aria-label="default input example">
        <input name= "author1" class="form-control w-25 m-3" type="text" placeholder="Author1" aria-label="default input example"required>
		<input name= "author2" class="form-control w-25 m-3" type="text" placeholder="Author2" aria-label="default input example">
		<input name= "author3" class="form-control w-25 m-3" type="text" placeholder="Author3" aria-label="default input example">
		<input name= "author4" class="form-control w-25 m-3" type="text" placeholder="Author4" aria-label="default input example">
		<input name= "author5" class="form-control w-25 m-3" type="text" placeholder="Author5" aria-label="default input example">
		<input name= "author6" class="form-control w-25 m-3" type="text" placeholder="Author6" aria-label="default input example">
        <input name= "category1" class="form-control w-25 m-3" type="text" placeholder="Category1" aria-label="default input example"required>
		<input name= "category2" class="form-control w-25 m-3" type="text" placeholder="Category2" aria-label="default input example">
		<input name= "category3" class="form-control w-25 m-3" type="text" placeholder="Category3" aria-label="default input example">
		<input name= "category4" class="form-control w-25 m-3" type="text" placeholder="Category4" aria-label="default input example">
		<input name= "category5" class="form-control w-25 m-3" type="text" placeholder="Category5" aria-label="default input example">
		<input name= "category6" class="form-control w-25 m-3" type="text" placeholder="Category6" aria-label="default input example">
        <input name= "isbn" class="form-control w-25 m-3" type="text" placeholder="Isbn" aria-label="default input example" required>
        <input name= "quantity" class="form-control w-25 m-3" type="text" placeholder="Quantity" aria-label="default input example"required>
        <label name= "title" class="text-light text-center">Description</label>
        <textarea name="description" class="form-control  w-25 m-3" id="exampleFormControlTextarea1" rows="3"required></textarea>
    </div>
    <div class="mb-3 text-light">
        <h2 class="text-center">Select a picture </h2>
        <input name="picture" class="form-control" type="text" placeholder="link picture" aria-label="default input example"required>
    </div>
    <div class="d-grid gap-2 col-6 mx-auto mb-2">
		<input name="envoi" class="btn btn-success" type="submit">
        </div>
	</form>
</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <!-- <script></script> -->
</body>
</html>
