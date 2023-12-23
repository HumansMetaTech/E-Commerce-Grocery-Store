<?php

if (isset($_POST['submit'])) {
    $email = $_POST['Email'];
    $passwd = $_POST['Password'];
    echo "<script type='text/javascript'>  User: $email; </script>";
    if ($email != "" && $passwd != "") {
        $query = "SELECT * from customers where email='$email' && password='$passwd'";
        $data = mysqli_query($conn, $query);
        $total = mysqli_num_rows($data);
        if ($total == 1) {
            $_SESSION['customer'] = $email;
            echo "<script type='text/javascript'>  window.location='system-index.php'; </script>";
        } else {
            echo "Invalid Username or Password";
        }
    } else {
        echo "All Fields Required";
    }
}
