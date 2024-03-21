<?php
require "conexaoBanco.php"; // Substitua pelo caminho correto para o seu arquivo de conexão

if (isset($_POST['excluirEscala'])) {
    // Obtendo o ID da escala a ser excluída
    $escala_id = strip_tags($_POST['escalaExcluirID']);

    try {
        // Verificar se a escala existe antes de excluí-la
        $verificarExistencia = $pdo->prepare("SELECT COUNT(*) FROM escalas WHERE id = ?");
        $verificarExistencia->execute([$escala_id]);
        $numEscalas = $verificarExistencia->fetchColumn();

        if ($numEscalas > 0) {
            // A escala existe, então exclua-a
            $excluirEscala = $pdo->prepare("DELETE FROM escalas WHERE id = ?");
            $excluirEscala->execute([$escala_id]);
            
            echo '<script>alert("Escala excluída com sucesso!")</script>';
        } else {
            echo '<script>alert("A escala com o ID especificado não foi encontrada.")</script>';
        }
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
} else {
    echo '<script>alert("ID da escala não fornecido.")</script>';
}

// Redirecionar de volta para a página de onde veio ou qualquer outra página desejada
echo '<script>window.location.href = "../visual/opEscalas.php";</script>';
?>
