<?php
// Conecte ao banco de dados e faça a consulta para obter a imagem
// ...

$id_da_imagem = $_GET['id']; // Você deve validar e limpar essa entrada para evitar injeção de SQL

$sql = "SELECT arquivo, png FROM escalas WHERE id = id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $imagem = $row['arquivo'];
    $tipo = $row['tipo_da_imagem'];

    // Configurar cabeçalhos para indicar que é uma imagem
    header("Content-Type: $tipo");
    header("Content-Disposition: attachment; filename=$imagem");
    header("Content-Type: image/png");


    // Enviar o conteúdo da imagem
    echo $imagem;
} else {
    echo "Imagem não encontrada";
}

$conn->close();
?>
