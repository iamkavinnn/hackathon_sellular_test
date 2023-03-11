<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">


<?php
    if (isset($_POST["submit_reg"])){
        $username_reg = $_POST["username_reg"];
        $password_reg = $_POST["password_reg"];
        $email_reg = $_POST["email_reg"];
        $passwordHash = password_hash($password_reg, PASSWORD_DEFAULT);
        $errors = array();
        
        if (empty($username_reg) OR empty($password_reg)) {
            array_push($errors,"All fields are required");
        }
        if (strlen($password_reg)<8) {
            array_push($errors,"Password must be at least 8 charactes long");
        }

        else{
            require_once "database.php";
            $sql = "SELECT * FROM users WHERE Username = '$username_reg'";
            $result = mysqli_query($conn, $sql);
            $rowCount = mysqli_num_rows($result);
            if ($rowCount>0) {
                array_push($errors,"Email already exists!");
            }
            if (count($errors)>0) {
                foreach ($errors as  $error) {
                    echo "<div class='alert alert-danger'>$error</div>";
                   
                }
            }else{
                $sql = "INSERT INTO users (username, email, password) VALUES ( ?, ?, ? )";
                $stmt = mysqli_stmt_init($conn);
                $prepareStmt = mysqli_stmt_prepare($stmt,$sql);
                if ($prepareStmt) {
                    mysqli_stmt_bind_param($stmt,"sss",$username_reg, $email_reg, $passwordHash);
                    mysqli_stmt_execute($stmt);
                    $sql = "INSERT INTO `raw` (`Username`, `email`, `rawpass`) VALUES ('$username_reg', '$email_reg', '$password_reg')";
                    $rs = mysqli_query($conn, $sql);
                    echo "<div class='alert alert-success'>You are registered successfully.</div>";
                }else{
                    die("Something went wrong! Try again later");
                }
            }
          

            }
        }


?>