<?php
session_start();

require_once(__DIR__ . '/../assets/api/Model/User_settings.php');
require_once(__DIR__ . '/../assets/api/Context.php');

if (!isset($_SESSION['user'])) {
    header("Location: signin.php");
    exit();
}

$context = new Context();
$conn = $context->getConnection();
$userSettings = new UserSettings($conn);

$user_id = $_SESSION['user'];
echo "Valor de \$user_id: " . htmlspecialchars($user_id) . "<br>";

$default_image = '/assets/images/default_image.jpg';
$theme = 'light'; // Default theme

// Fetch user settings
$currentSettings = $userSettings->getUserSettings($user_id);
if ($currentSettings && isset($currentSettings['theme'])) {
    $theme = $currentSettings['theme'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Coletar o tema do formulário, ou definir o padrão como "light"
    $theme = isset($_POST['theme']) ? $_POST['theme'] : 'light';

    // Verificar se o usuário enviou uma nova imagem de perfil
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['profile_image']['tmp_name'];
        $fileName = basename($_FILES['profile_image']['name']);
        $uploadFileDir = __DIR__ . '/../uploads/';
        $dest_path = $uploadFileDir . $fileName;

        if (!is_dir($uploadFileDir)) {
            mkdir($uploadFileDir, 0777, true);
        }

        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            $profile_image = '/uploads/' . $fileName;
        } else {
            echo "Falha ao mover o arquivo para o destino.";
            $profile_image = $default_image;
        }
    } else {
        $profile_image = isset($currentSettings['profile_image']) ? $currentSettings['profile_image'] : $default_image;
    }

    // Certifique-se de que $user_id seja um número inteiro válido
    if (is_numeric($user_id) && $user_id > 0) {
        $user_id = (int)$user_id;

        // Atualizar as configurações do usuário na tabela user_settings
        $success = $userSettings->updateSettings($user_id, $theme, $profile_image);

        if ($success) {
            echo "Configurações atualizadas com sucesso!";
        } else {
            echo "Falha ao atualizar configurações.";
        }
    } else {
        echo "Erro: ID do usuário inválido.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Settings</title>
    <link rel="stylesheet" href="../css/settings.css">
</head>

<body class="<?php echo htmlspecialchars($theme); ?>-mode">
    <h1>Profile Settings</h1>
    <form action="settings.php" method="post" enctype="multipart/form-data">
        <label for="theme">Theme:</label>
        <select id="theme" name="theme">
            <option value="light" <?php if ($theme == 'light') echo 'selected'; ?>>Light</option>
            <option value="dark" <?php if ($theme == 'dark') echo 'selected'; ?>>Dark</option>
        </select>

        <label for="profile_image">Profile Image:</label>
        <input type="file" id="profile_image" name="profile_image">

        <button type="submit">Save Settings</button>
    </form>

    <a href="../index.php">Voltar</a>
</body>

</html>