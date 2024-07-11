<?php
session_start();
$_SESSION['lang'] = 'en'; // 顧客側のデフォルト言語は英語
include('../common/functions.php');

$lang = $_SESSION['lang'];
include "../lang/lang_$lang.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // パスワードをハッシュ化

        $pdo = connect_to_db();
        $sql = "INSERT INTO customers (name, email, password) VALUES (:name, :email, :password)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':password', $password, PDO::PARAM_STR);
        if ($stmt->execute()) {
            header('Location: login.php');
            exit();
        } else {
            echo "Error: Could not register.";
        }
    } else {
        echo "Please fill in all fields.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $lang_texts['customer_register']; ?></title>
</head>
<body>
    <h2><?php echo $lang_texts['customer_register']; ?></h2>
    <form method="POST" action="register.php">
        <label for="name"><?php echo $lang_texts['name']; ?>:</label>
        <input type="text" name="name" required>
        <br>
        <label for="email"><?php echo $lang_texts['email']; ?>:</label>
        <input type="email" name="email" required>
        <br>
        <label for="password"><?php echo $lang_texts['password']; ?>:</label>
        <input type="password" name="password" required>
        <br>
        <button type="submit"><?php echo $lang_texts['register']; ?></button>
    </form>
</body>
</html>
