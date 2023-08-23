<?php
// Start the session
session_start();
	require_once("dao.php");
	$dao=new DAO();
	$dao->connexion();

//$title=$dao->getBook();
$description=$dao->getDescription($_GET['book_id']);
// Set session variables

//Valeur a la session uniquement si le get de book_id est défini


$author=array();
$category=array();

foreach($description as $value){
  if(in_array($value[2],$author)){    
  }else{array_push($author,$value[2]);}

  if(in_array($value[3],$category)){    
  }else{array_push($category,$value[3]);}
}
if (isset($_GET['book_id'])){
  $_SESSION["idbook"] = $_GET['book_id'];
  $_SESSION["author"] = $author;
  $_SESSION["category"] = $category;
  $_SESSION["description"] = $description;
}
//print_r($author);
//print_r($category);
//print_r($description);
if(isset ($_GET['delete'])){
  $dao->deleteBook($_SESSION["idbook"]);
  header("location:./index.php");
}

if (isset($_GET['edit'])){
header("location:./changebook.php");
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link href="styledesc.css" rel="stylesheet">
  </head>
    <title>Library description</title>
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
                              <a class="nav-link " href="customers.php">Customer</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="emprunt.php">Borrow</a>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link" href="ajoutbook.php">Add a book</a>
                            </li>
                         </ul>
                    </div>
                </div>
            </div>
        </nav>
    </header>


    <div class="card mb-3 mt-3 mx-auto border-Secondary" style="max-width:1000px">
  <div class="row g-0">
    <div class="col-md-4"style="max-width:540px">
      <img src="<?php  print $description[0]['image'];?>" class="img-fluid rounded-start" alt="...">
    </div>
    <div class="col-md-8">
      <div class="card-body"> 
      <div class="row">
        <h5 class="card-title">Title: <?php  print $description[0]['title'];?></h5>
        <p class="card-text">Author: <?php  foreach($author as $value){print $value;print "/";};?></p>
        <p class="card-text">Category: <?php  foreach($category as $value){print $value;print "/";};?></p>
        <p class="card-text">Description:<?php  print $description[0]['description'];?></p>
        <p class="card-text col-6">ISBN: <?php  print $description[0]['isbn'];?></p>
        <p class="card-text col-6">Number of pages: <?php  print $description[0]['pages'];?></p>
        <p class="card-text col-6">Format: <?php  print $description[0]['11'];?></p>
        <p class="card-text col-6">Rating: <?php  print $description[0]['rating'];?></p>
        <p class="card-text col-6">Rating count: <?php  print $description[0]['rating_count'];?></p>
        <p class="card-text col-6">Quantity: <?php  print $description[0]['quantity'];?></p>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="d-grid gap-2 col-6 mx-auto">
  <div class="row">
  <form action="changebook.php" method="GET">
  <input type="hidden" name="book_id" value="<?php print ($description[0][0]); ?>"></input>
    <button type="submit" class="btn btn-success" name="edit" style="width:100%;">Edit</button>
</form>

<form action="newEmprunt.php" method="GET">
<input type="hidden" name="book_id" value="<?php print ($description[0][0]); ?>"></input>
 <button type="submit" class="btn btn-primary text-light" name="emprunt" style="width:100%;">Emprunt</button>
</form>

<div>
    <button id="myBtn" class="btn btn-danger" style="width:100%;">Delete</button>
</div>
    
  </div>
</div>

<!-- The Modal -->
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
    <p>Are you sure ?</p>
    <form>
    <button id="myBtn" name="delete" type="submit" class="btn btn-danger" value="<?php $_GET['book_id']; ?>" style="width:100%;">YES</button>
    </form>
    <button id="btnNo" class="btn btn-success mt-3" >NO</button>
  </div>

</div>

    <script src="scriptdesc.js" type="text/javascript"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>
<?php $dao->deconnexion();?>