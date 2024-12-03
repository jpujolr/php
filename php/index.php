<?php
require_once "config.php";

session_start();

if (isset($_SESSION["username"])){
    //$_SESSION nombre del user que ha logeado
    header("location:home.php");
}

if(isset($_POST["login"])){
    //$connection para buscar si hay un usuario con username y password
    //enviados por la petición post http

    $username = mysqli_real_escape_string($connection,$_POST["username"]);
    $password = mysqli_real_escape_string($connection,$_POST["password"]);
    $query = "SELECT * FROM users WHERE username = '$username'";

    //ejecutar select
    $result = mysqli_query($connection,$query);

    if(mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);

        if(password_verify($password, $row["password"])){
            //return true
            $_SESSION["username"] = $username;
            header("location:home.php");
        } else {
            //return false
            echo '<script>alert("EEPP. Wrong user details")</script>';
        }
    
    } else{
        echo '<script> alert("Error en el login!") </script>';
    }
}

if(isset($_POST["register"])){
    if(empty($_POST["username"]) || empty($_POST["password"]) || empty($_POST["repeat_password"])){
        echo '<script> alert("All fields are mandatory!") </script>';
    }
    else if($_POST["password"] != $_POST["repeat_password"]){
        echo '<script> alert("Passwords don`t match!") </script>';
    }
    else {
        $username = mysqli_real_escape_string($connection,$_POST["username"]);
        $password = mysqli_real_escape_string($connection,$_POST["password"]); 
        //HASH
        $password = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO users(username,password) VALUES ('$username','$password')";

        if(mysqli_query($connection,$query)){
            echo '<script> alert("Register done") </script>';
            //header("location:index.php");
        }
    }
    
}

?>

<!DOCTYPE html>  
<html>  
    <head>  
        <title>Introduction to PHP</title>  
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="boostrap" />
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="styles.css">
    </head>  

    <body>
        <div class="container align-middle">
            <?php
            if (isset($_GET["action"]) == "register"){
            ?>
            <form method="post">
                <h3 class="text-center">Register</h3>

                <!-- Username input -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <input type="text" id="username" name="username" class="form-control" />
                    <label class="form-label" for="username">Username</label>
                </div>

                <!-- Password input -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <input type="password" id="password" name="password" class="form-control" />
                    <label class="form-label" for="password">Password</label>
                </div>

                <!-- Password input -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <input type="password" id="repeat_password" name="repeat_password" class="form-control" />
                    <label class="form-label" for="repeat_password">Repeat Password</label>
                </div>

                <!-- Submit button -->
                <input type="submit" class="btn btn-primary btn-block mb-4" value="Register" name="register" />

                <!-- Register buttons -->
                <div class="text-center">
                    <p>Already a member? <a href="index.php">Login</a></p>
                </div>
            </form> 
            <?php
            }
            else {
            ?>
            <form method="post">
                <h3 class="text-center">Login</h3>

                <!-- Username input -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <input type="text" id="username" name="username" class="form-control" />
                    <label class="form-label" for="username">Username</label>
                </div>

                <!-- Password input -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <input type="password" id="password" name="password" class="form-control" />
                    <label class="form-label" for="password">Password</label>
                </div>

                <!-- Submit button -->
                <input type="submit" class="btn btn-primary btn-block mb-4" value="Login" name="login" />

                <!-- Register buttons -->
                <div class="text-center">
                    <p>Not a member? <a href="index.php?action=register">Register</a></p>
                </div>
            </form> 
            <?php
            }
            ?>
        </div>  
    </body>  
</html> 