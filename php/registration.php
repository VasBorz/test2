<?php
    include ('function.php');
    include ('db.php');
    $login = $_POST['login'];
    $email = $_POST['email'];
    $pwd = $_POST['pwd'];
    $pwd_retype = $_POST['pwd_retype'];

    //Checking for empty fields
    if (!empty($login) || !empty($email) || !empty($pwd) || !empty($pwd_retype)){
        //checking for login symbols
        if (!preg_match('^[0-9A-Za-z_]+$^', $login)){
           header('Location:../index.php?message=login_not_correct');
           exit();
        }
        //validate email
        if (!filter_var($email,FILTER_VALIDATE_EMAIL)){
            header('Location:../index.php?message=email_not_correct');
            exit();
        }
        // checking pwd
        if ($pwd !== $pwd_retype){
            header('Location:../index.php?message=password_not_the_same');
            exit();
        }else{
            //check if email exist
            $stmt = mysqli_stmt_init($conn);
            $email_checked = mysqli_real_escape_string($conn, (string)htmlspecialchars(strip_tags($email)));
            $sql = "SELECT * FROM registration.users where email = ? or username = ?";
            mysqli_stmt_prepare($stmt,$sql);
            mysqli_stmt_bind_param($stmt, "ss", $email_checked, $login);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if (mysqli_num_rows($result)){
                mysqli_stmt_close($stmt);
                header('Location:../index.php?message=email_already_exists');
                exit();
            }else{
                //registration of new user
                $login_checked = mysqli_real_escape_string($conn,(string)htmlspecialchars(strip_tags($login)));
                $email_checked = mysqli_real_escape_string($conn,(string)htmlspecialchars(strip_tags($email)));
                $pwd_hashed = password_hash($pwd, PASSWORD_DEFAULT);
                $sql = "INSERT INTO registration.users (`username`, `pwd`, `email`, `date`) VALUES (?,?,?,now())";
                $stmt = mysqli_stmt_init($conn);

                mysqli_stmt_prepare($stmt,$sql);
                mysqli_stmt_bind_param($stmt,"sss",$login_checked,$pwd_hashed, $email_checked);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
                header("Location: ../index.php?message=successfully");
                exit();
            }
        }
    }else{
        header('Location:../index.php?message=404');
        exit();
    }




