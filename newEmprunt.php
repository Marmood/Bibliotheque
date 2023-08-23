<?php
	require_once("dao.php");
	$dao=new DAO();
	$dao->connexion();
  
    if (isset($_GET['envoi'])){
    $dao->setRental(date("Y-m-d"),$_GET['book_id'],date("Y-m-d" , strtotime(" + 15 days")),$_GET['customerid'],$_GET['staffid']);
    header("location:./index.php");
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  </head>
    <title>NewEmprunt</title>
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
                            <a class="nav-link" href="ajoutbook.php">Add a book</a>
                            </li>
                         </ul>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <?php 
    $customers = $dao->getCustomer();
    $staff = $dao->getStaff();
    $description = $dao->getDescription($_GET['book_id']);
    ?>

    <form action="" method="GET">
    <div class="card mb-3 mt-3 mx-auto border-Secondary" style="max-width:1000px">
  <div class="row g-0">
    <div class="col-md-4"style="max-width:540px">
      <img src="<?php  print $description[0]['image'];?>" class="img-fluid rounded-start" alt="...">
    </div>
    <div class="col-md-8">
      <div class="card-body"> 
      <div class="row">
        <h5 class="card-title"><?php print $description[0]['title'] ?></h5>
        <!---------------------------------------------------- select clien ----------------------------------------------->
        <select name="customerid" class="form-select w-75" aria-label="Default select example">
  <option selected disabled>Emprunteur</option>
  <?php 
  foreach($customers as $value){
    ?> <option value="<?php print $value['customer_id'] ?>"><?php print $value['last_name']." ".$value['first_name']." ".$value['customer_id'] ?></option>
  <?php } ?>
</select>
        <!---------------------------------------------------- date ----------------------------------------------->
    
        <p class="card-text">Date d'emprunt: <?php print date("d-m-Y"); ?></p>
        <p class="card-text">Date de retour: <?php print date("d-m-Y" , strtotime(" + 15 days")) ; ?></p>
        <!---------------------------------------------------- select staff ----------------------------------------------->

        <select name="staffid"class="form-select w-75" aria-label="Default select example">
  <option selected disabled>Staff</option>
  <?php 
  foreach($staff as $value){
    ?> <option value="<?php print $value['staff_id'] ?>"><?php print $value['last_name']." ".$value['first_name']." ".$value['staff_id'] ?></option>
  <?php } ?>
</select>

        </div>
      </div>
    </div>
  </div>
</div>

<div class="d-grid gap-2 col-6 mx-auto">
<input type="hidden" name="book_id" value="<?php print $_GET['book_id'] ?>"></input>
<button type="submit" class="btn btn-success text-light m-auto " name="envoi" style="width:50%;">Valider</button>
</div>

</form>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>

<?php $dao->deconnexion(); ?>