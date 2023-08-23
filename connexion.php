<?php
	session_start();
	require_once("dao.php");
	$dao=new DAO();
	$dao->connexion();
    $staff=$dao->getStaff();
	
	$mauvais = 0;
	//print_r ($staff);
	
	if(isset($_POST['Login'])){
		foreach($staff as $value){
			if($_POST['username'] == $value['username'] && $_POST['password'] == $value['password']){
				$_SESSION["account"] = 1;
				header("location:./index.php");
				break;
			}else{
				$_SESSION["account"] = 0;
			}			
		}
		$mauvais=1;
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
<body style="background-image:url(book.png);background-attachment: fixed;">
    <div class="text-light">
        <img src="livre.png" class="float-start">
        <img src="livre.png" class="float-end">
        <h1 class="text-center">Library</h1>
        <h2 class="text-center">Connexion</h2>
    </div>
    <div class="container-fluid">
        <div class="row justify-content-md-center position-absolute top-50 start-50 translate-middle container text-center">
            <div class="card text-bg-dark mb-3 text-center" style="max-width: 18rem;">
			<?php if($mauvais==1){?> <h1 style="color:red; font-size:50px;">User:Test  mdp:1234</h1> <?php } ?>
                <div class="card-header">Log in</div>
                    <form action="" method='POST'>
                        <div class="card-body">
                            <p class="card-title">Username</p>
                            <input name="username" type="text">
                            <p class="card-text">Password</p>
                            <input name="password" type="password">
                            <div class="d-grid gap-2 col-6 mx-auto mb-5">
                                <input name="Login" class="btn btn-success mt-5" value='Login' type="submit"></input>
                            </div>
                        </div>
                    </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>
<?php $dao->deconnexion();?>