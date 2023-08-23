<?php
	session_start();
	if($_SESSION['account'] !=1){
		header("location:./connexion.php");
	}
	
	require_once("dao.php");
	$dao=new DAO();
	$dao->connexion();
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  </head>
    <title>Library</title>
</head>
<body style="background-image:url(book.png); background-attachment: fixed;">
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
                                <a class="nav-link " style='border-bottom:solid 1px white;' aria-current="page" href="index.php">Home</a>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link " href="customers.php">Customer
                                </a>
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

    <div class="container-fluid">
        <div class="row">
            <form class="d-flex w-25 mx-auto" role="search" action="" method="GET">
                <input name="search" minlength="3" class="form-control me-2" type="search"  placeholder="Search" aria-label="Search">
                <button name="envoi" class="btn btn-outline-success" type="submit">Search</button>
            </form>
        </div>

            
                    
<?php      

    
//========================================================== Calcul nombre de pages ============================================================

     if(!isset($_GET['envoi'])){   
        $totalBook= ($dao->page());
    //========================================================== Nombre d'affichage de livre par pages ============================================================
    $bookParPage = 2000;
    $bookTotal=count($totalBook);
    $pageTotal= ceil($bookTotal/$bookParPage);
    if(isset($_GET['page']) AND !empty($_GET['page'] AND $_GET['page']>0)){
        $_GET['page']=intval($_GET['page']);
        $pageCourante = $_GET['page'];
    }else {
        $pageCourante = 1;
    }
    
    $depart = ($pageCourante-1)*$bookParPage;
    
    
    
?>
            <nav aria-label="Page navigation example">
                <ul class="pagination mt-3 justify-content-center ">
                    <li class="page-item"><a class="page-link" href="index.php?page=<?php if($pageCourante==1){print($pageTotal);}else{print ($pageCourante-1);} ?> ">Previous</a></li>
                    <?php  for($i=1;$i<=$pageTotal;$i++) { ?>
                        <li class="page-item"><a class="page-link" href="index.php?page=<?php print $i; ?> "> <?php print $i; ?></a></li>
                         <?php } ?>
             
                    <li class="page-item"><a class="page-link" href="index.php?page=<?php if($pageCourante==$pageTotal){print 1;}else{print ($pageCourante+1);} ?> ">Next</a></li>
                </ul>
            </nav>
<?php }else{
    $bookParPage = 2000;
    $depart = 1;
} ?>
            <!-- ========================================================== création de carde  ============================================================ -->
    <div class="container-fluid">
    <div class="row justify-content-md-center">
        <?php 
        if(isset($_GET['envoi'])){
            $rows=$dao->getBook($depart,$bookParPage,$_GET['search']);
        }else{
            $rows=$dao->getBook($depart,$bookParPage);
        }

        if(count($rows)==0){ ?>
         <h1 class="text-center text-light position-absolute top-50">  <?= "The search returns nothing";?></h1>
        <?php }
        foreach($rows as $row) {?>
        <div class="card col-3" style=" margin: 10px;" id="card" >
            <a href="description.php?book_id=<?php print $row['book_id']; ?>" style="text-decoration:none; color:black">
            <div class="row ">
                    <div class="col-4">
                            <img src="<?php print $row["image"] ?>" class="img-fluid rounded-start">
                        </div>
                        <div class="col-8">
                            <div class="card-body">
                                <h5 class="card-title">Title : <?= $row["title"]; ?> </h5>
                                
                                <p class="card-text">Author :
                                <?php 
                            
                                    $author=($dao->getAuthor($row["book_id"]));
                                
                                    foreach($author as $value){
                                        print $value[1];
                                        print "/";
                                    }?></p>
                                <p class="card-text">Category : <?php 
                                    $category=($dao->getCategorry($row["book_id"]));
                                    foreach($category as $value){
                                        print $value[1];
                                        print " ";
                                    }?> </p>
                                
                                <p class="card-text">Rating : <?= $row["rating"];?> </p>
                            </div>
                        </div>
                    </div>
                </a>
                </div>
                <?php  }?>
                </div>
                </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>
<?php $dao->deconnexion();?>