<?php
    include ('db.php');
    include ('function.php');
    $user = $_POST['user_log'];
    $pwd = $_POST['pwd_log'];

    //check for empty fields
    if (!empty($user) || !empty($pwd)){
        $user_checked = mysqli_real_escape_string($conn, (string)htmlspecialchars(strip_tags($user)));
        $sql = "SELECT * FROM registration.users WHERE email = ? OR username = ?";
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt,$sql);
        mysqli_stmt_bind_param($stmt, "ss", $user_checked,$user_checked);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        //check result form query
        if (mysqli_num_rows($result) > 0){
            //from obj to array
           while ($row = mysqli_fetch_assoc($result)){
                foreach ($row as $value=>$key){
                    if ($value == 'pwd'){
                        $pwd_from_base = $key;
                        //check password
                        if (password_verify($pwd,$pwd_from_base)){
                         //   echo $pwd_from_base;
                            session_start();
                            $_SESSION['username'] = $user;
                            header("Location:../index.php?message=success_login");
                            mysqli_stmt_close($stmt);
                            exit();
                        }else{
                            header("Location:../index.php?message=error_with_pass");
                            mysqli_stmt_close($stmt);
                            exit();
                        }

                    }
                }
           }
         // if user not exists
        }else{
            header("Location:../index.php?message=no_such_user");
            mysqli_stmt_close($stmt);
            exit();
        }

    }else{
        header('Location:../index.php?message=404');
        exit();
    }