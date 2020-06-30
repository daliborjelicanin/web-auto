<?php
 require "dbBroker.php";
 require "model/korisnik.php";

 session_start();

 if(isset($_POST['username']) && isset($_POST['password'])) {
     $username=$_POST['username'];
     $password=$_POST['password'];

    $rs = Korisnik::logInUser($username, $password, $conn);


      if($rs->num_rows==1) {
          echo "You have successfully logged in!";
          $row = $rs->fetch_assoc();
          $_SESSION['user'] = $row['ime'];
          $_SESSION['uloga'] = $row['uloga'];
          $_SESSION['id'] = $row['id'];
          header('Location: home.php');
          exit();
      } else {
         
          echo '<script type="text/javascript">alert("You have entered incorrect password!"); 
                                                window.location.href = "http://localhost/iteh/";</script>';
          exit();
      }
 }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="shortcut icon"  type="image/x-icon" href="img/favicon.png" />
    <title>WEB auto - prijava</title>

</head>
<body>
    <div class="login-form">
        <div class="main-div">
            <form method="POST" action="#">
                

                <div class="container">
                    <H3>Unesite podatke za prijavljivanje:</H3>
                    <input type="text" placeholder="Username" name="username" class="form-control"  required>
                    <input type="password" placeholder="Password" name="password" class="form-control" required>
                    <button type="submit" class="btn btn-primary" name="submit">Prijavi se</button>
                </div>

            </form>
        </div>
    </div>
</body>
</html>