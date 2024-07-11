<?php

function connect_to_db() {
    $host = 'localhost';
    $db = 'wakame2';
    $user = 'root';
    $pass = '';
    $charset = 'utf8mb4';

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];

    try {
        return new PDO($dsn, $user, $pass, $options);
    } catch (PDOException $e) {
        throw new PDOException($e->getMessage(), (int)$e->getCode());
    }
}

function check_customer_login() {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['customer_id'])) {
        header('Location: ../customer/login.php');
        exit();
    }
}

function check_hairstylist_login() {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['hairstylist_id'])) {
        header('Location: ../hairstylist/login.php');
        exit();
    }
}

function logout() {
    session_start();
    session_destroy();
    header('Location: ../customer/login.php'); // ログアウト後にリダイレクトするページを指定
    exit();
}
?>

