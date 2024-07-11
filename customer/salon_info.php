<?php
session_start();
include('../common/functions.php');

$pdo = connect_to_db();
$sql = "SELECT * FROM salons";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$salons = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Salon Information</title>
    <link rel="stylesheet" type="text/css" href="../styles.css">
</head>
<body>
    <div class="container">
        <h1>Salon Information</h1>
        <?php if ($salons): ?>
            <ul>
                <?php foreach ($salons as $salon): ?>
                    <li>
                        <h2><?php echo htmlspecialchars($salon['name']); ?></h2>
                        <p><?php echo htmlspecialchars($salon['address']); ?></p>
                        <p><?php echo htmlspecialchars($salon['phone']); ?></p>
                        <p><?php echo htmlspecialchars($salon['hours']); ?></p>
                        <p><?php echo htmlspecialchars($salon['description']); ?></p>
                        <p><?php echo htmlspecialchars($salon['menu']); ?></p>
                        <?php if (!empty($salon['photos'])): ?>
                            <img src="<?php echo htmlspecialchars($salon['photos']); ?>" alt="Salon Photo" style="max-width: 100%; height: auto;">
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No salons found.</p>
        <?php endif; ?>
    </div>
</body>
</html>
