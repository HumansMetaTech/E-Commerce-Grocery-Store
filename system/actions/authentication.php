<?php
include_once(__DIR__ . '\classes\DBUser.php');

if (isset($_POST['submit'])) {
    $email = $_POST['Email'];
    $passwd = $_POST['Password'];

    if ($email != "" && $passwd != "") {
        $dbuser = new DBUser();
        $con = $dbuser->GetConnection();
        $query = "SELECT COUNT(*) as count FROM `tabUsers` WHERE user_name = ? AND password = ? AND disabled = 0";
        $stmt = $con->prepare($query);
        $stmt->bind_param("ss", $email, md5($passwd));
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $total = $row['count'];
        $stmt->close();
        $conn->close();
        if ($total >= 1) {
            session_start();
            $_SESSION['system_user'] = $email;
            header("Location: system-index.php");
            exit();
        } else {
            echo "Invalid Username or Password";
        }
    } else {
        echo "All Fields Required";
    }
}
