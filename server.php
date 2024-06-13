<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "meu_site";

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Funções para manipular o banco de dados
function get_mesas($conn) {
    $sql = "SELECT * FROM mesas";
    $result = $conn->query($sql);

    $mesas = [];
    while($row = $result->fetch_assoc()) {
        $mesas[] = $row;
    }
    echo json_encode($mesas);
}

function search_mesas($conn, $query) {
    $sql = "SELECT * FROM mesas WHERE tags LIKE '%$query%'";
    $result = $conn->query($sql);

    $mesas = [];
    while($row = $result->fetch_assoc()) {
        $mesas[] = $row;
    }
    echo json_encode($mesas);
}

function create_mesa($conn) {
    $nome = $_POST['mesa-nome'];
    $tags = $_POST['mesa-tags'];
    $horario = $_POST['mesa-horario'];
    $descricao = $_POST['mesa-descricao'];
    $imagem = upload_file($_FILES['mesa-imagem']);

    $sql = "INSERT INTO mesas (nome, tags, horario_jogo, descricao, imagem, usuario_id) VALUES ('$nome', '$tags', '$horario', '$descricao', '$imagem', 1)";

    if ($conn->query($sql) === TRUE) {
        echo "Mesa criada com sucesso!";
    } else {
        echo "Erro: " . $sql . "<br>" . $conn->error;
    }
}

function upload_file($file) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($file["name"]);
    move_uploaded_file($file["tmp_name"], $target_file);
    return $target_file;
}

// Roteamento básico
if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'get_mesas':
            get_mesas($conn);
            break;
        case 'search_mesas':
            search_mesas($conn, $_GET['query']);
            break;
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    create_mesa($conn);
}

$conn->close();
?>