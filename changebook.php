<?php
session_start();
if(isset($_GET['book_id'])){
$_SESSION["id_book"] = $_GET['book_id'];
}
//print $_SESSION["id_book"];
//print_r($_SESSION["author"]);
//print_r($_SESSION["category"]);
//print_r($_SESSION["description"]);
require_once("dao.php");
	$dao=new DAO();
	$dao->connexion();
$tabAuthor=$_SESSION["author"];
$tabCategory=$_SESSION["category"];
$tabDesc=$_SESSION["description"];
if(isset ($_GET['envoi'])){
$tabBook=[
    $_GET['title'],
    $_GET['format'],
    $_GET['rating'],
    $_GET['rating_count'],
    $_GET['pages'],
    $_GET['isbn'],
    $_GET['quantity'],
    $_GET['description'],
    $_GET['picture'],
    $_SESSION["id_book"],
];

$authors= array();
$category2= array();
for($i=0;$i<60;$i++){
if (isset ($_GET['author'.$i.''])){
array_push($authors,$_GET['author'.$i.'']);}}
for($i=0;$i<30;$i++){
    if (isset ($_GET['category'.$i.''])){
    array_push($category2,$_GET['category'.$i.'']);}}

$dao->changeBook($authors,$tabBook,$category2,$_SESSION["id_book"]);

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styleChange.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  </head>
    <title>Library</title>
</head>
<body style="background-image:url(book.png); ">
    <header>
        <div class="text-light">
        <img src="livre.png" class="float-start">
        <img src="livre.png" class="float-end">
        <h1 class="text-center">Biblioteque</h1>
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
                                <a class="nav-link " href="#">Description
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Loan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="ajout.php">Add a book</a>
                            </li>
                         </ul>
                    </div>
                </div>
            </div>
        </nav>
    </header>
<div  >
    <h1 class="text-light text-center">Edit a book</h1>
	<form action="" method="GET">
    <div class=" container-fluid d-flex justify-content-evenly row ">
	
        <input name= "title" class="form-control w-25 m-3" type="text" aria-label="default input example" placeholder="Title" value="<?php print $tabDesc[0]['title'];?>" required >
        <input name= "format" class="form-control w-25 m-3" type="text" placeholder="Format" aria-label="default input example" value="<?php print $tabDesc[0][11];?>" required>
        <input name= "rating" class="form-control w-25 m-3" type="text" placeholder="rating" aria-label="default input example" value="<?php print $tabDesc[0]['rating']; ?>">
        <input name= "rating_count" class="form-control w-25 m-3" type="text" placeholder="rating_count" aria-label="default input example" value="<?php print $tabDesc[0]['rating_count']; ?>">
        <input name= "pages" class="form-control w-25 m-3" type="text" placeholder="pages" aria-label="default input example" value="<?php print $tabDesc[0]['pages']; ?>">
        <?php
        $i=0;
         foreach ($tabAuthor as $author){
            print '<input name= "author'.$i.'" class="form-control w-25 m-3" type="text" placeholder="Author1" aria-label="default input example" value="'.$author.'" >';
            $i++;
        }
        $x=0;
       foreach ($tabCategory as $category){
          print '<input name= "category'.$x.'" class="form-control w-25 m-3" type="text" placeholder="Author1" aria-label="default input example" value="'.$category.'" >';
          $x++;
      }
      
        
        ?>

        <input name= "isbn" class="form-control w-25 m-3" type="text" placeholder="Isbn" aria-label="default input example" value="<?php print $tabDesc[0]['isbn'];?>" required>
        <input name= "quantity" class="form-control w-25 m-3" type="text" placeholder="Quantity" aria-label="default input example" value="<?php print $tabDesc[0]['quantity'];?>" required>
        <label name= "title" class="text-light text-center">Description</label>
        <textarea name="description" class="form-control  w-25 m-3" id="exampleFormControlTextarea1" rows="10" required><?php print $tabDesc[0]['description'];?></textarea>
    </div>
    <div class="mb-3 text-light">
        <h2 class="text-center">Select a picture </h2>
        <input name="picture" class="form-control" type="text" placeholder="link picture" aria-label="default input example"required value="<?php print $tabDesc[0]['image'];?>">
    </div>
		<div class="d-grid gap-2 col-6 mx-auto mb-5">
		<input name="envoi" class="btn btn-success" type="submit">
        </div>
	</form>
</div>

    </body>
    </html>
    <?php $dao->deconnexion();?>