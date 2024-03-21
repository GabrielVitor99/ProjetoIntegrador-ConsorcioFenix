$(document).ready(function () {
    // Buscar cargos usando AJAX
    $.ajax({
        type: "GET",
        url: "../includes/AJAX_carregarCargosAdmin.php",
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
});

