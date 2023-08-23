<?php

try {
	$dbh = new PDO('mysql:host=localhost;dbname=bookbook', 'root', '');
if(isset($_GET["change"])){
    $oui=$_GET["change"];
$jambon=$dbh->query("SELECT `first_name`,`last_name`,`phone`,`email`,`create_date`,`customer_id`,`address`.`address`,`address`.`city`,`address`.`postal_code`,`address`.`address_id` FROM customer INNER JOIN address ON customer.address_id=address.address_id where address.address_id=".$oui.";");
$tab = $jambon->fetchAll();

}

if(isset($_GET["modif"])){

$dbh->query ("UPDATE `address` SET `address`='".addslashes($_GET["address"])."',`city`='".addslashes($_GET["city"])."',`postal_code`='".$_GET["postal_code"]."' WHERE address_id=".$_GET["id"].";");
$dbh->query ("UPDATE `customer` SET `first_name`='".addslashes($_GET["firstname"])."',`last_name`='".addslashes($_GET["last_name"])."',`phone`='".$_GET["phone"]."',`email`='".addslashes($_GET["email"])."' WHERE address_id=".$_GET["id"].";");
header("location:./customers.php");
}

} catch (PDOException $e) {
print "Oups !: Perdu<br/>";
	
    die();
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
                            <a class="nav-link" href="ajoutbook.php">Add a book</a>
                            </li>
                         </ul>
                    </div>
                </div>
            </div>
        </nav>
    </header>

<form action="" method="GET">
    <div class=" container-fluid d-flex justify-content-evenly row ">
	
        <input name= "firstname" class="form-control w-25 m-3" type="text" value="<?php print $tab[0]["first_name"] ?>" aria-label="default input example" required>
        <input name= "last_name" class="form-control w-25 m-3" type="text"value="<?php print $tab[0]["last_name"] ?>" aria-label="default input example" required>
        <input name= "phone" class="form-control w-25 m-3" type="text" value="<?php print $tab[0]["phone"] ?>" aria-label="default input example" required>
        <input name= "email" class="form-control w-25 m-3" type="text" value="<?php print $tab[0]["email"] ?>" aria-label="default input example" required>
        <input name= "address" class="form-control w-25 m-3" type="text" value="<?php print $tab[0]["address"] ?>" aria-label="default input example" required>
        <input name= "city" class="form-control w-25 m-3" type="text"value="<?php print $tab[0]["city"] ?>" aria-label="default input example" required>
        <input name= "postal_code" class="form-control w-25 m-3" type="text" value="<?php print $tab[0]["postal_code"] ?>" aria-label="default input example" required>
        <input name="id" type="hidden" value="<?php print $tab[0]['address_id'] ?>">
     
    </div>    
    
    <div class="d-grid gap-2 col-6 mx-auto mb-5">
		<input name="modif" class="btn btn-success" type="submit">
        </div>

	</form>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>