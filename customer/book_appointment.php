<?php
session_start();
include('../common/functions.php');
check_customer_login();

if (!isset($_GET['salon_id'])) {
    echo "Salon ID is missing.";
    exit();
}

$salon_id = $_GET['salon_id'];

$pdo = connect_to_db();
$sql = "SELECT * FROM salons WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $salon_id, PDO::PARAM_INT);
$stmt->execute();
$salon = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$salon) {
    echo "Salon not found.";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Book Appointment</title>
</head>
<body>
    <h2>Book Appointment at <?php echo htmlspecialchars($salon['name']); ?></h2>
    <form method="POST" action="submit_booking.php">
        <input type="hidden" name="salon_id" value="<?php echo htmlspecialchars($salon['id']); ?>">
        <label for="date">Date:</label>
        <input type="date" name="date" required>
        <br>
        <label for="time">Time:</label>
        <input type="time" name="time" required>
        <br>
        <label for="service">Service:</label>
        <input type="text" name="service" required>
        <br>
        <button type="submit">Book Appointment</button>
    </form>
</body>
</html>
