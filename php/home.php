<?php
//Acceso BBDD
require_once "config.php";
session_start();

if (!isset($_SESSION["username"])) {
    header("location:index.php");
}

//Consultar la tabla `users`
$query = "SELECT * FROM users";
//Array de resultados de la consulta a BBDD
$result = mysqli_query($connection, $query);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Users</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="container mt-4">
        <h2 class="text-center">Welcome to My App!</h2>
        <a href="logout.php" class="btn btn-danger mb-4">Logout</a>

        <div class="row">
            <?php
            //Generar Bootstrap cards para cada usuario
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <div class="col-md-4">
                        <div class="card mb-4 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">Username: <?php echo htmlspecialchars($row['username']); ?></h5>
                                <p class="card-text">User ID: <?php echo htmlspecialchars($row['id']); ?></p>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "<p class='text-center'>No users found.</p>";
            }
            ?>
        </div>
    </div>
</body>
</html>
