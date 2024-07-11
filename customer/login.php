<?php
session_start();
$_SESSION['lang'] = 'en'; // 顧客側のデフォルト言語は英語
include('../common/functions.php');

$lang = $_SESSION['lang'];
include "../lang/lang_$lang.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $pdo = connect_to_db();
        $sql = "SELECT * FROM customers WHERE email=:email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['customer_id'] = $user['id'];
            header('Location: home.php');
            exit();
        } else {
            echo "Invalid email or password.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $lang_texts['customer_login']; ?></title>
</head>
<body>
    <h2><?php echo $lang_texts['customer_login']; ?></h2>
    <form method="POST" action="login.php">
        <label for="email"><?php echo $lang_texts['email']; ?>:</label>
        <input type="email" name="email" required>
        <br>
        <label for="password"><?php echo $lang_texts['password']; ?>:</label>
        <input type="password" name="password" required>
        <br>
        <button type="submit"><?php echo $lang_texts['login']; ?></button>
    </form>
</body>
</html>
