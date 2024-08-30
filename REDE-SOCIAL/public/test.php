<?php
session_start();

require_once(__DIR__ . '/../assets/api/Model/User_settings.php');
require_once(__DIR__ . '/../assets/api/Context.php');

$theme = 'light'; // Default theme

if (!isset($_SESSION['user'])) {
    header("Location: signin.php");
    exit();
}

$context = new Context();
$conn = $context->getConnection();
$userSettings = new UserSettings($conn);
$user_id = $_SESSION['user'];

// Fetch user settings
$currentSettings = $userSettings->getUserSettings($user_id);
if ($currentSettings && isset($currentSettings['theme'])) {
    $theme = $currentSettings['theme'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Toggle the theme
    $theme = $theme === 'light' ? 'dark' : 'light';

    // Update the theme in the database
    $userSettings->updateSettings($user_id, $theme, $currentSettings['profile_image'] ?? null);

    // Apply the theme immediately
    echo "<script>document.body.className = '" . htmlspecialchars($theme) . "-mode';</script>";
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Settings</title>
    <link rel="stylesheet" href="../css/profile.css">
</head>

<body class="<?php echo htmlspecialchars($theme); ?>-mode">
    <h1>Profile Settings</h1>
    <form action="settings.php" method="post">
        <button type="submit">Toggle Theme</button>
    </form>
</body>

</html>