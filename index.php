<?php
    session_start();
    if (isset($_SESSION['username'])){
        echo "<h3>" . $_SESSION['username'] . " You have sign in</h3>";
        echo "<input type=\"button\" onclick=\"window.location='php/logout.php'\" value=\"Logout\"></input>";
    }else{
        echo '
    
    <h2>Login form</h2>
    <form action="php/login.php" method="POST" id="login">
        <input type="text" placeholder="Your login or email" name="user_log"><br><br>
        <input type="password" placeholder="Your password" name="pwd_log"><br><br>
        <button value="login" form="login" type="submit">Login</button>
    </form>
    <br><br>
    <h2>Register form</h2>
    <form action="php/registration.php" method="POST" id="registration">
        <input type="text" placeholder="Your login" name="login"><br><br>
        <input type="text" placeholder="Your email" name="email"><br><br>
        <input type="password" placeholder="Your password" name="pwd"><br><br>
        <input type="password" placeholder="Retype password" name="pwd_retype"><br><br>
        <button value="login" form="registration" type="submit">Register</button>
    </form>';
    }

