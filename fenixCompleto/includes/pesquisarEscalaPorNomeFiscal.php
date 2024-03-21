<?php
// Conexão com o banco de dados
require "conexaoBanco.php";

$pesquisar = strip_tags($_POST['pesquisaPorFuncionario']);

// Verificar se uma das caixas está vazia
$requiredFields = array('pesquisaPorFuncionario');
$missingFields = array();

foreach ($requiredFields as $field) {
    if (empty($_POST[$field])) {
        $missingFields[] = $field;
    }
}

if (!empty($missingFields)) {
    $missingFieldsList = implode(', ', $missingFields);
    echo '<script>alert("Por favor, preencha os seguintes campos: ' . $missingFieldsList . '")</script>';
} else {

$sql = $pdo->prepare("SELECT * FROM escalas WHERE motorista_id = :pesquisar OR cobrador_id = :pesquisar");
$sql->bindParam(':pesquisar', $pesquisar);
$sql->execute();
$tabular = $sql->fetchAll();

$num_nome = count($tabular);


if(count($tabular) > 0){

// estilo da tabulação dos dados
echo "<table>
<caption> Escala do funcionário $pesquisar </caption>
<tr>
  <th>ID</th>
  <th>Número de escala</th>
  <th>Veículo</th>
  <th>Motorista</th>
  <th>Cobrador</th>
  <th>Início da jornada</th>
  <th>Tempo de intervalo</th>
  <th>Final da jornada</th>
  <th>Arquivo da escala</th>
  <th>Data de cadastro</th>
</tr>";
foreach ($tabular as $key => $value) {
    echo "<tr>";
    echo "<td>" . $value[0] . "</td>";
    echo "<td>" . $value[1] . "</td>";
    echo "<td>" . $value[2] . "</td>";
    echo "<td>" . $value[3] . "</td>";
    echo "<td>" . $value[4] . "</td>";
    echo "<td>" . $value[5] . "</td>";
    echo "<td>" . $value[6] . "</td>";
    echo "<td>" . $value[7] . "</td>";
    echo "<td><a href='" . $value[8] . "'download>Download</a></td>";
    echo "<td>" . $value[9] . "</td>";
    echo "</tr>";
}
echo "</table>";
} else {
  echo "<script>alert('Erro: não há uma escala cadastrada com este funcionário')</script>";
}
}

?>
