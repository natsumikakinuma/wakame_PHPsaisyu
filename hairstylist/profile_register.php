<?php
session_start();
include('../common/functions.php');
check_hairstylist_login();

$hairstylist_id = $_SESSION['hairstylist_id'];
$pdo = connect_to_db();

// プロフィールの存在確認
$sql = "SELECT * FROM salons WHERE hairstylist_id = :hairstylist_id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':hairstylist_id', $hairstylist_id, PDO::PARAM_INT);
$stmt->execute();
$salon = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $hours = $_POST['hours'];
    $description = $_POST['description'];
    $staff = $_POST['staff'];
    $menu = $_POST['menu'];

    $uploadDir = '/Applications/XAMPP/xamppfiles/htdocs/Gs/wakame2/uploads/';
    $relativeUploadDir = '/Gs/wakame2/uploads/';
    $uploadedFiles = [];

    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    foreach ($_FILES['photos']['tmp_name'] as $key => $tmp_name) {
        $file_name = basename($_FILES['photos']['name'][$key]);
        $targetFilePath = $uploadDir . $file_name;
        $relativeFilePath = $relativeUploadDir . $file_name;

        if (move_uploaded_file($tmp_name, $targetFilePath)) {
            $uploadedFiles[] = $relativeFilePath;
        }
    }

    $photos = implode(',', $uploadedFiles);

    if ($salon) {
        // プロフィール更新
        $sql = "UPDATE salons SET name = :name, address = :address, phone = :phone, hours = :hours, description = :description, staff = :staff, menu = :menu, photos = :photos WHERE hairstylist_id = :hairstylist_id";
        $stmt = $pdo->prepare($sql);
    } else {
        // プロフィール新規登録
        $sql = "INSERT INTO salons (hairstylist_id, name, address, phone, hours, description, staff, menu, photos) VALUES (:hairstylist_id, :name, :address, :phone, :hours, :description, :staff, :menu, :photos)";
        $stmt = $pdo->prepare($sql);
    }

    $stmt->bindValue(':hairstylist_id', $hairstylist_id, PDO::PARAM_INT);
    $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    $stmt->bindValue(':address', $address, PDO::PARAM_STR);
    $stmt->bindValue(':phone', $phone, PDO::PARAM_STR);
    $stmt->bindValue(':hours', $hours, PDO::PARAM_STR);
    $stmt->bindValue(':description', $description, PDO::PARAM_STR);
    $stmt->bindValue(':staff', $staff, PDO::PARAM_STR);
    $stmt->bindValue(':menu', $menu, PDO::PARAM_STR);
    $stmt->bindValue(':photos', $photos, PDO::PARAM_STR);

    if ($stmt->execute()) {
        header('Location: home.php'); // ホームページにリダイレクト
        exit();
    } else {
        echo "Error: Could not register profile.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register Salon Profile</title>
</head>
<body>
    <h2><?php echo $salon ? 'Update' : 'Register'; ?> Salon Profile</h2>
    <form method="POST" action="profile_register.php" enctype="multipart/form-data">
        <label for="name">Salon Name:</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($salon['name'] ?? ''); ?>" required>
        <br>
        <label for="address">Address:</label>
        <input type="text" name="address" value="<?php echo htmlspecialchars($salon['address'] ?? ''); ?>" required>
        <br>
        <label for="phone">Phone:</label>
        <input type="text" name="phone" value="<?php echo htmlspecialchars($salon['phone'] ?? ''); ?>" required>
        <br>
        <label for="hours">Hours:</label>
        <textarea name="hours" required><?php echo htmlspecialchars($salon['hours'] ?? ''); ?></textarea>
        <br>
        <label for="description">Description:</label>
        <textarea name="description"><?php echo htmlspecialchars($salon['description'] ?? ''); ?></textarea>
        <br>
        <label for="staff">Staff:</label>
        <textarea name="staff"><?php echo htmlspecialchars($salon['staff'] ?? ''); ?></textarea>
        <br>
        <label for="menu">Menu:</label>
        <textarea name="menu"><?php echo htmlspecialchars($salon['menu'] ?? ''); ?></textarea>
        <br>
        <label for="photos">Photos:</label>
        <input type="file" name="photos[]" multiple>
        <br>
        <button type="submit"><?php echo $salon ? 'Update' : 'Register'; ?></button>
    </form>
</body>
</html>
