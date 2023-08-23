<?php
	require_once("dao.php");
	$dao=new DAO();
	$dao->connexion();
    $tab=$dao->getRental();
    if (isset($_GET['return'])){
        $dao->delRental($_GET['return']);
        header("location:./emprunt.php");
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
    <title>Borrow</title>
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
                                <a class="nav-link"style='border-bottom:solid 1px white;' href="emprunt.php">Borrow</a>
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
    <!--------------------------------------tableau--------------------------------------------------------->
    <table id="tableid" class="table table-dark table-striped w-75 position-absolute top-50 start-50 translate-middle container text-center " style="background-color: white">
        <thead>
            <tr>
                <th>Rental number</th>
                <th>Title</th>
                <th>Customer last name</th>
                <th>Customer first name</th>
                <th>Phone</th>
                <th>Return date</th>
                <th>ID staff</th>
                <th>Return</th>
            </tr>
            </thead>
            <tbody> 
                <?php foreach($tab as $row) {
                    print "<tr>".
                    "<td>".$row['rental_id']."</td>"
                    ."<td>".$row['title']."</td>"
                    ."<td>".$row['last_name']."</td>".
                    "<td>".$row['first_name']."</td>".
                    "<td>".$row['phone']."</td>".
                    "<td>".$row['return_date']."</td>".
                    "<td>".$row['staff_id']."</td>".
                    "<td><form><button name='return' class='btn btn-outline-light' type='submit' value='".$row['rental_id']."'>Return</button></form>".
                    "</tr>";
                }?>               
            </tbody>
        </table>





    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>

<?php $dao->deconnexion(); ?>