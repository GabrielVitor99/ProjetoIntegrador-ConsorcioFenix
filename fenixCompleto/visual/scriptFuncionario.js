$(document).ready(function () {
    // Buscar cargos usando AJAX
    $.ajax({
        type: "GET",
        url: "../includes/AJAX_carregarCargos.php",
        dataType: "json",
        success: function (data) {
            var options = "";
            data.forEach(function (cargos) {
                options += "<option value='" + cargos.id + "'>" + cargos.cargo + "</option>";
            });
            $(".cargo_id").html(options);

            // Inicializar o Select2 para o campo de cargos
            $(".cargo_id").select2();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error("Erro na requisição AJAX: " + textStatus, errorThrown);
        }
    });

    // Nova função para carregar funcionários usando AJAX
    function carregarFuncionarios() {
        $.ajax({
            type: "GET",
            url: "../includes/AJAX_carregarFuncionarios.php",
            dataType: "json",
            success: function (data) {
                // Inicializar o Select2 no seu elemento de seleção
                $(".funcionario_id").select2({
                    data: data.map(function (funcionario) {
                        return {
                            id: funcionario.id,
                            text: funcionario.nome + " - " + funcionario.matricula,
                            class: funcionario.cor
                        };
                    })
                });
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error("Erro na requisição AJAX: " + textStatus, errorThrown);
            }
        });
    }

    // Carregar funcionários ao carregar a página
    carregarFuncionarios();
});
