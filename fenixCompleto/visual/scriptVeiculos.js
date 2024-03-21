$(document).ready(function () {
    // Buscar tipos de veículo usando AJAX
    $.ajax({
        type: "GET",
        url: "../includes/AJAX_carregarTipos.php", // Arquivo PHP para buscar tipos
        dataType: "json", // Define o tipo de dados esperado
        success: function (data) {
            var options = "";
            data.forEach(function (tipos) {
                options += "<option value='" + tipos.id + "'>" + tipos.tipo + "</option>";
            });
            $(".tipo_id").html(options);
        }
    });
    
// Função para carregar veículos usando AJAX
function carregarVeiculos() {
    $.ajax({
        type: "GET",
        url: "../includes/AJAX_carregarVeiculos.php",
        dataType: "json",
        success: function (data) {
            // Inicialize o Select2 no seu elemento de seleção
            $(".veiculo_id").select2({
                data: data.map(function (veiculo) {
                    return {
                        id: veiculo.id,
                        text: veiculo.numero,
                        class: veiculo.cor
                    };
                })
            });
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error("Erro na requisição AJAX: " + textStatus, errorThrown);
        }
    });
}

// Carrega todos os veículos ao carregar a página
carregarVeiculos();

});
