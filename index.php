<?php
include "config/dbconfig.php";

session_start();

if( isset($_COOKIE['user_login']) )
{
    $root = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';
    header("location: {$root}creativehope-authentication/home.php");
    exit();
}

if ( isset($_POST['user_login']) )
{
    $username =	stripslashes($_POST['username']);
    $password = stripslashes($_POST['password']);
    if( isset($username) && isset($password) )
    {
        $hashed_password = md5($password);

        $sql = "SELECT * FROM users
                WHERE username = '$username'
                AND password = '$hashed_password'";

        $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $count = mysqli_num_rows($result);

        if($count == 1) {
            $_SESSION['user_login'] = $row;
            $number_of_days = 1 ;
            $date_of_expiry = time() + 60 * 60 * 24 * $number_of_days ;
            $root = $_SERVER['HTTP_HOST'];

            setcookie("user_login", serialize($_SESSION['user_login']), $date_of_expiry, "/", $root);

            $root = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/creativehope-authentication\/';
            header("location: {$root}home.php");
            unset($_SESSION['login_error']);
            exit();
        }
        else
        {
            $_SESSION['login_error'] = "Your Login Name or Password is invalid";
        }
    }
}

?>
<!DOCTYPE html>
<html>
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- CSS only -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

        <title>CRH AUTHENTICATION</title>
    </head>
    <body>
        <div class="container">
            <div class="card">
                <div class="card-header">
                    <h2>Login</h2>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <div class="mb-3 row">
                            <div class="col-sm-12">
                                <input type="text" class="form-control" name="username" id="username" placeholder="Username">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <div class="col-sm-12">
                                <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                            </div>
                        </div>
                        <?php if( isset($_SESSION['login_error']) ):?>
                            <div id="errortd" class="p-3 mb-2 bg-danger text-white">
                                <span id="Errorshow"><?= $_SESSION['login_error']; ?></span>
                            </div>
                        <?php endif; ?>
                        <button type="submit" class="btn btn-primary" name="user_login">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>