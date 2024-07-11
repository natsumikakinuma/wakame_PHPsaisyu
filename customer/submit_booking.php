<?php
session_start();
include('../common/functions.php');
check_customer_login();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $salon_id = $_POST['salon_id'];
    $customer_id = $_SESSION['customer_id'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $service = $_POST['service'];

    $pdo = connect_to_db();
    $sql = "INSERT INTO bookings (salon_id, customer_id, date, time, service) VALUES (:salon_id, :customer_id, :date, :time, :service)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':salon_id', $salon_id, PDO::PARAM_INT);
    $stmt->bindValue(':customer_id', $customer_id, PDO::PARAM_INT);
    $stmt->bindValue(':date', $date, PDO::PARAM_STR);
    $stmt->bindValue(':time', $time, PDO::PARAM_STR);
    $stmt->bindValue(':service', $service, PDO::PARAM_STR);

    if ($stmt->execute()) {
        echo "Booking successful.";
        // ここで予約成功後にリダイレクトするか、成功メッセージを表示するなどの処理を追加します
    } else {
        echo "Error: Could not book appointment.";
    }
} else {
    echo "Invalid request.";
}
?>
