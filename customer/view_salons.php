<?php
session_start();
include('../common/functions.php');
check_customer_login();

$pdo = connect_to_db();
$sql = "SELECT * FROM salons";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$salons = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Salons</title>
    <style>
        .salons-container {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 20px;
            padding: 20px;
        }
        .salon {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }
        .salon img {
            max-width: 100%;
            height: auto;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            background-color: #f8f8f8;
            border-bottom: 1px solid #ccc;
        }
        .logout {
            margin-right: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Salon Profiles</h2>
        <a class="logout" href="../common/logout.php">Logout</a>
    </div>
    <div class="salons-container">
        <?php foreach ($salons as $salon): ?>
            <div class="salon">
                <h3><?php echo htmlspecialchars($salon['name']); ?></h3>
                <p><strong>Address:</strong> <?php echo htmlspecialchars($salon['address']); ?></p>
                <p><strong>Phone:</strong> <?php echo htmlspecialchars($salon['phone']); ?></p>
                <p><strong>Hours:</strong> <?php echo nl2br(htmlspecialchars($salon['hours'])); ?></p>
                <p><strong>Description:</strong> <?php echo nl2br(htmlspecialchars($salon['description'])); ?></p>
                <p><strong>Staff:</strong> <?php echo nl2br(htmlspecialchars($salon['staff'])); ?></p>
                <p><strong>Menu:</strong> <?php echo nl2br(htmlspecialchars($salon['menu'])); ?></p>
                <p><strong>Photos:</strong><br>
                    <?php 
                    $photos = explode(',', $salon['photos']);
                    foreach ($photos as $photo): 
                    ?>
                        <img src="<?php echo htmlspecialchars($photo); ?>" alt="Photo">
                    <?php endforeach; ?>
                </p>
                <p><a href="book_appointment.php?salon_id=<?php echo $salon['id']; ?>">Book Appointment</a></p>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
