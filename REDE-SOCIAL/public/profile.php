<?php
// Iniciar a sessão
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['user'])) {
    header("Location: signin.php");
    exit();
}

// Incluir os arquivos necessários
require_once(__DIR__ . '/../assets/api/Model/User_profile.php');
require_once(__DIR__ . '/../assets/api/Model/User_settings.php');
require_once(__DIR__ . '/../assets/api/Context.php');

// Conectar ao banco de dados
$context = new Context();
$conn = $context->getConnection();

// Instanciar as classes necessárias
$userSettings = new UserSettings($conn);
$userProfile = new User_profile($conn);

// Pegar o ID do usuário da sessão
$user_id = $_SESSION['user'];

// Depuração: Exibir o valor de $user_id
echo "Valor de \$user_id: " . htmlspecialchars($user_id) . "<br>";

// Caminho para imagem padrão
$default_image = '/assets/images/default_image.jpg';

// Buscar as configurações atuais do usuário
$currentSettings = $userSettings->getUserSettings($user_id);

// Buscar os dados do perfil do usuário
$profileData = $userProfile->getProfileData($user_id);

// Verificar se o formulário foi submetido
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Coletar o tema do formulário, ou definir o padrão como "light"
    $theme = isset($_POST['theme']) ? $_POST['theme'] : 'light';

    // Verificar se o usuário enviou uma nova imagem de perfil
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
        // Obter informações sobre o arquivo enviado
        $fileTmpPath = $_FILES['profile_image']['tmp_name'];
        $fileName = basename($_FILES['profile_image']['name']);
        $uploadFileDir = __DIR__ . '/../uploads/';
        $dest_path = $uploadFileDir . $fileName;

        // Verifique se o diretório de upload existe, caso contrário, crie-o
        if (!is_dir($uploadFileDir)) {
            mkdir($uploadFileDir, 0777, true);
        }

        // Mover o arquivo para o diretório de uploads
        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            $profile_image = '/uploads/' . $fileName;
        } else {
            // Se o upload falhar, defina uma imagem padrão ou mostre uma mensagem de erro
            echo "Falha ao mover o arquivo para o destino.";
            $profile_image = $default_image;
        }
    } else {
        // Usar a imagem atual ou definir a padrão
        $profile_image = isset($currentSettings['profile_image']) ? $currentSettings['profile_image'] : $default_image;
    }

    // Certifique-se de que $user_id seja um número inteiro válido
    if (is_numeric($user_id) && $user_id > 0) {
        // Convertendo o ID para inteiro
        $user_id = (int)$user_id;

        // Atualizar as configurações do usuário na tabela user_settings
        $success = $userSettings->updateSettings($user_id, $theme, $profile_image);

        // Exibir mensagem de sucesso ou falha
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
    <title>Perfil do Usuário</title>
    <link rel="stylesheet" href="/path/to/your/css/file.css">
</head>

<body>
    <div class="profile-container">
        <h1>Bem-vindo, <?php echo htmlspecialchars($profileData['user_id']); ?></h1>

        <!-- Exibir foto de perfil -->
        <img src="<?php echo htmlspecialchars($profile_image); ?>" alt="Foto de Perfil" class="profile-photo">
    </div>
</body>

</html>