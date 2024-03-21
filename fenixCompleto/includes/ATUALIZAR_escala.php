<?php

require "conexaoBanco.php";

$escala_id = strip_tags($_POST['escala_id_atualizar']);
$veiculo_id = isset($_POST['manter_veiculo']) ? null : strip_tags($_POST['veiculo_id_atualizar']);
$motorista_id = isset($_POST['manter_motorista']) ? null : strip_tags($_POST['motorista_id_atualizar']);
$cobrador_id = isset($_POST['manter_cobrador']) ? null : strip_tags($_POST['cobrador_id_atualizar']);
$horario_inicio = strip_tags($_POST['horario_inicio_atualizar']);
$tempo_intervalo = strip_tags($_POST['tempo_intervalo_atualizar']);
$horario_final = strip_tags($_POST['horario_final_atualizar']);
$arquivo = isset($_POST['manter_arquivo']) ? null : strip_tags($_POST['file_atualizar']);

// Verificar se uma das caixas está vazia
$requiredFields = array('escala_id_atualizar', 'horario_inicio_atualizar', 'tempo_intervalo_atualizar', 'horario_final_atualizar');
$missingFields = array_filter($requiredFields, function($field) {
    return empty($_POST[$field]);
});

if (!empty($missingFields)) {
    $missingFieldsList = implode(', ', $missingFields);
    echo '<script>alert("Por favor, preencha os seguintes campos: ' . $missingFieldsList . '")</script>';
    echo '<script>window.location.href = "../visual/opEscalas.php";</script>';
} else {
    try {
        // Verificar se o motorista já está em outra escala
        if ($motorista_id) {
            $sqlMotorista = $pdo->prepare("SELECT id FROM escalas WHERE motorista_id = ? AND id != ?");
            $sqlMotorista->execute([$motorista_id, $escala_id]);
            $motoristaEmOutraEscala = $sqlMotorista->fetch();
            if ($motoristaEmOutraEscala) {
                echo '<script>alert("O motorista já está alocado em outra escala.")</script>';
                echo '<script>window.location.href = "../visual/opEscalas.php";</script>';
            }
        }

        // Verificar se o cobrador já está em outra escala
        if ($cobrador_id) {
            $sqlCobrador = $pdo->prepare("SELECT id FROM escalas WHERE cobrador_id = ? AND id != ?");
            $sqlCobrador->execute([$cobrador_id, $escala_id]);
            $cobradorEmOutraEscala = $sqlCobrador->fetch();
            if ($cobradorEmOutraEscala) {
                echo '<script>alert("O cobrador já está alocado em outra escala.")</script>';
                echo '<script>window.location.href = "../visual/opEscalas.php";</script>';
            }
        }

        // Atualizar no banco de dados
        $sql = $pdo->prepare("UPDATE escalas SET veiculo_id = COALESCE(?, veiculo_id), motorista_id = COALESCE(?, motorista_id), cobrador_id = COALESCE(?, cobrador_id), inicio_jornada = ?, tempo_intervalo = ?, final_jornada = ?, arquivo = COALESCE(?, arquivo) WHERE id = ?");
        $params = array($veiculo_id, $motorista_id, $cobrador_id, $horario_inicio, $tempo_intervalo, $horario_final, $arquivo, $escala_id);

        if ($sql->execute($params)) {
            echo '<script>alert("Escala atualizada com sucesso!")</script>';
        } else {
            echo '<script>alert("Erro ao atualizar a escala. Verifique se todos os campos foram preenchidos corretamente.")</script>';
        }
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
    echo '<script>window.location.href = "../visual/opEscalas.php";</script>';
}
?>
