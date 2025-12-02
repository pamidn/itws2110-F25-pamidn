<?php
include 'config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_POST['userId'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE userId=?");
    $stmt->bind_param("i",$userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        $checkHash = hash('sha256', $user['salt'].$password);
        if ($checkHash === $user['passwordHash']) {
            $_SESSION['userId'] = $user['userId'];
            header("Location: index.php");
            exit();
        } else {
            echo "Incorrect password.";
        }
    } else {
        header("Location: register.php");
        exit();
    }
}
?>

<form method="post">
User ID: <input type="number" name="userId" required><br>
Password: <input type="password" name="password" required><br>
<input type="submit" value="Login">
</form>
