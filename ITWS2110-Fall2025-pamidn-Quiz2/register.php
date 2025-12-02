<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $nickName = $_POST['nickName'];
    $password = $_POST['password'];

    $salt = bin2hex(random_bytes(16));
    $passwordHash = hash('sha256', $salt.$password);

    $stmt = $conn->prepare("INSERT INTO users (firstName,lastName,nickName,salt,passwordHash) VALUES (?,?,?,?,?)");
    $stmt->bind_param("sssss",$firstName,$lastName,$nickName,$salt,$passwordHash);
    if ($stmt->execute()) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error: ".$stmt->error;
    }
}
?>

<form method="post">
First Name: <input type="text" name="firstName" required><br>
Last Name: <input type="text" name="lastName" required><br>
Nickname: <input type="text" name="nickName"><br>
Password: <input type="password" name="password" required><br>
<input type="submit" value="Register">
</form>
