<?php
session_start();

// 顧客ページと美容師ページのデフォルト言語を設定
if (isset($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'];
} elseif (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'en'; // デフォルトは英語
}

$lang = $_SESSION['lang'];
include "lang/lang_$lang.php";
?>

<!DOCTYPE html>
<html>
<head>
    <title>WAKAME</title>
    <style>
        .container { width: 300px; margin: 0 auto; text-align: center; }
        .tab { display: none; }
        .tab.active { display: block; }
        .tabs { margin-bottom: 20px; }
        .tabs button { margin: 5px; }
    </style>
    <script>
        function showTab(tabId) {
            document.getElementById('customer-login-tab').classList.remove('active');
            document.getElementById('hairstylist-login-tab').classList.remove('active');
            document.getElementById('customer-register-tab').classList.remove('active');
            document.getElementById('hairstylist-register-tab').classList.remove('active');
            document.getElementById(tabId).classList.add('active');
        }
    </script>
</head>
<body>
    <div class="container">
        <h1><?php echo $lang_texts['welcome']; ?></h1>
        <div class="tabs">
            <button onclick="showTab('customer-login-tab')"><?php echo $lang_texts['customer_login']; ?></button>
            <button onclick="showTab('hairstylist-login-tab')"><?php echo $lang_texts['hairstylist_login']; ?></button>
            <button onclick="showTab('customer-register-tab')"><?php echo $lang_texts['customer_register']; ?></button>
            <button onclick="showTab('hairstylist-register-tab')"><?php echo $lang_texts['hairstylist_register']; ?></button>
        </div>

        <div>
            <select onchange="window.location.href='index.php?lang=' + this.value;">
                <option value="en" <?php if ($lang == 'en') echo 'selected'; ?>>English</option>
                <option value="ja" <?php if ($lang == 'ja') echo 'selected'; ?>>日本語</option>
            </select>
        </div>

        <div id="customer-login-tab" class="tab active">
            <h2><?php echo $lang_texts['customer_login']; ?></h2>
            <form method="POST" action="customer/login.php">
                <label for="email"><?php echo $lang_texts['email']; ?>:</label>
                <input type="email" name="email" required>
                <br>
                <label for="password"><?php echo $lang_texts['password']; ?>:</label>
                <input type="password" name="password" required>
                <br>
                <button type="submit"><?php echo $lang_texts['login']; ?></button>
            </form>
        </div>

        <div id="hairstylist-login-tab" class="tab">
            <h2><?php echo $lang_texts['hairstylist_login']; ?></h2>
            <form method="POST" action="hairstylist/login.php">
                <label for="email"><?php echo $lang_texts['email']; ?>:</label>
                <input type="email" name="email" required>
                <br>
                <label for="password"><?php echo $lang_texts['password']; ?>:</label>
                <input type="password" name="password" required>
                <br>
                <button type="submit"><?php echo $lang_texts['login']; ?></button>
            </form>
        </div>

        <div id="customer-register-tab" class="tab">
            <h2><?php echo $lang_texts['customer_register']; ?></h2>
            <form method="POST" action="customer/register.php">
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
        </div>

        <div id="hairstylist-register-tab" class="tab">
            <h2><?php echo $lang_texts['hairstylist_register']; ?></h2>
            <form method="POST" action="hairstylist/register.php">
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
        </div>

        <!-- 追加されたサロン情報ページへのリンク -->
        <div class="profile-link">
            <a href="customer/salon_info.php"><?php echo $lang_texts['view_salon_info']; ?></a>
        </div>
    </div>
</body>
</html>
