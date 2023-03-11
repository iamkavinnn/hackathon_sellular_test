<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

<?php
        if (isset($_POST["login"])) {
           $username = $_POST["username"];
           $password = $_POST["password"];
            require_once "database.php";
            $sql = "SELECT * FROM users WHERE Username = '$username'";
            $result = mysqli_query($conn, $sql);
            $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
            if ($user) {
                if (password_verify($password, $user["Password"])) {
                    session_start();
                    $_SESSION["user"] = "yes";
                    header("Location: logged_in.php");
                    die();
                }else{
                    echo "<div class='alert alert-danger'>Password does not match</div>";
                    echo "<p>Please try again!</p>";
                    echo "<a href='index.php' class='btn btn-primary'>Home</a>";
                }
            }else{
                echo "<div class='alert alert-danger'>Email does not match</div>";
                echo "<p>Please try again!</p>";
                echo "<a href='index.php' class='btn btn-primary'>Home</a>";
            }
        }
?>