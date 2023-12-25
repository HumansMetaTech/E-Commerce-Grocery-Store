<?php
include_once('../classes/DBUser.php');

if (isset($_POST['submit'])) {
    $email = $_POST['Email'];
    $passwd = $_POST['Password'];

    if ($email != "" && $passwd != "") {
        $con = new DBUser();
        $d = $con->GetConnection();
        $query = "SELECT COUNT(*) as count FROM `tabUsers` WHERE email = ? AND password = ?";
        $stmt = $conn->prepare($query);

        // Bind parameters
        $stmt->bind_param("ss", $email, $passwd);

        // Execute the query
        $stmt->execute();

        // Get the result
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $total = $row['count'];
        $stmt->close();
        $conn->close();

        if ($total == 1) {
            session_start();
            $_SESSION['customer'] = $email;
            header("Location: system-index.php");
            exit();
        } else {
            echo "Invalid Username or Password";
        }
    } else {
        echo "All Fields Required";
    }
}
