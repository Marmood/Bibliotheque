<?php
try {
	$dbh = new PDO('mysql:host=localhost;dbname=bookbook', 'root', '');

if(isset($_GET["envoi"])){

$dbh->query("INSERT INTO `address`(`address`,`city`,`postal_code`) VALUES ('".$_GET["address"]."','".$_GET["city"]."','".$_GET["postal_code"]."');");
				$addressid=$dbh->lastInsertId();
                print $addressid;
$dbh->query("INSERT INTO `customer`(`first_name`, `last_name`, `phone`, `email`,`create_date`,`address_id`) VALUES ('".$_GET["firstname"]."','".$_GET["last_name"]."','".$_GET["phone"]."','".$_GET["email"]."','".date("Y-m-d")."','".$addressid."');"); 
$dbh = null;
header("location:./customers.php");
}

$jambon=$dbh->query("SELECT `first_name`,`last_name`,`phone`,`email`,`create_date`,`customer_id`,`address`.`address`,`address`.`city`,`address`.`postal_code`,`address`.`address_id` FROM customer INNER JOIN address ON customer.address_id=address.address_id;");
$tab = $jambon->fetchAll();
if (isset($_GET['delete'])){
    $dbh->query("DELETE FROM customer WHERE address_id='".$_GET['delete']."'; DELETE FROM address WHERE address_id='".$_GET['delete']."';");
    header("location:./customers.php");
}


if(isset ($_GET['change'])){

    header("location:./changecustomers.php?change=".$_GET['change']);

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
    <script type="text/javascript" src="jquery-3.6.3.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="datatables_script.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.dataTables.min.css">
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
                            <a class="nav-link " style='border-bottom:solid 1px white;' href="customers.php">Customer
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

<div class="table table-dark table-striped">
    <table id="tableid" class="cell-border table table-dark table-striped" style="background-color: white">
        <thead>
            <tr>
                <th>First Name</th>
                <th>Last name</th>
                <th>Phone</th>
                <th>Mail</th>
                <th>Create Date</th>
                <th>Id Customer</th>
                <th>Address</th>
                <th>City</th>
                <th>Postal Code</th>
                <th>Change</th>
                <th>Delete</th>
            </tr>
            </thead>
            <tbody> 
                <?php foreach($tab as $row) {
                    print "<tr>".
                    "<td>".$row['first_name']."</td>"
                    ."<td>".$row['last_name']."</td>"
                    ."<td>".$row['phone']."</td>".
                    "<td>".$row['email']."</td>".
                    "<td>".$row['create_date']."</td>".
                    "<td>".$row['customer_id']."</td>".
                    "<td>".$row['address']."</td>".
                    "<td>".$row['city']."</td>".
                    "<td>".$row['postal_code']."</td>".
                    "<td><form><button name='change' class='btn btn-success' type='submit' value='".$row['address_id']."'>Change</button></form>".
                    "<td><form><button name='delete' class='btn btn-danger' type='submit' value='".$row['address_id']."'>Delete</button></form>".
                    "</tr>";
                }?>               
            </tbody>
        </table>
</div>
<div  >
    <h1 class="text-light text-center">Add a customer</h1>
	<form action="" method="GET">
    <div class=" container-fluid d-flex justify-content-evenly row ">
	
        <input name= "firstname" class="form-control w-25 m-3" type="text" placeholder="First Name" aria-label="default input example" required>
        <input name= "last_name" class="form-control w-25 m-3" type="text" placeholder="Last Name" aria-label="default input example" required>
        <input name= "phone" class="form-control w-25 m-3" type="text" placeholder="Phone" aria-label="default input example" required>
        <input name= "email" class="form-control w-25 m-3" type="text" placeholder="Mail" aria-label="default input example" required>
        <input name= "address" class="form-control w-25 m-3" type="text" placeholder="Address" aria-label="default input example" required>
        <input name= "city" class="form-control w-25 m-3" type="text" placeholder="City" aria-label="default input example" required>
        <input name= "postal_code" class="form-control w-25 m-3" type="text" placeholder="Postal Code" aria-label="default input example" required>
     
    </div >
    <div class="d-grid gap-2 col-6 mx-auto mb-5">
		<input name="envoi" class="btn btn-success" type="submit">
        </div>
	</form>
</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <!-- <script></script> -->
</body>
</html>
