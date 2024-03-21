$(document).ready(function () {
    // Função para carregar os funcionários
    function carregarFuncionarios() {
      $.ajax({
        type: "GET",
        url: "../includes/AJAX_carregarFuncionarios.php",
        dataType: "json",
        success: function (data) {
          var select = $(".funcionario_id");

          // Limpar o select
          select.empty();

          // Adicionar as opções com cores corretas
          data.forEach(function (funcionario) {
            var optionClass = funcionario.em_escala == 1 ? "vermelho" : "verde";
            var option = $("<option></option>")
              .val(funcionario.id)
              .text(funcionario.nome + " - " + funcionario.matricula)
              .addClass(optionClass);

            select.append(option);
          });

          // Inicializar o Select2 após carregar os funcionários
          select.select2();
        },
        error: function (xhr, status, error) {
          console.error("Erro na solicitação AJAX: " + status + " - " + error);
        }
      });
    }

    // Carregar todos os funcionários ao carregar a página
    carregarFuncionarios();

    // Função para carregar as escalas
    function carregarEscalas() {
      $.ajax({
        type: "GET",
        url: "../includes/AJAX_carregarNEscalas.php",
        dataType: "json",
        success: function (data) {
          var options = "";
          data.forEach(function (nEscalas) {
            options +=
              "<option value='" +
              nEscalas.id +
              "'>" +
              nEscalas.numero_escala +
              "</option>";
          });

          $(".escala_id").html(options);

          // Inicializar o Select2 após carregar as escalas
          $(".escala_id").select2();
        },
      });

    }

    // Carregar todas as escalas ao carregar a página
    carregarEscalas();

    // Função para carregar veículos usando AJAX
    function carregarVeiculos() {
      $.ajax({
        type: "GET",
        url: "../includes/AJAX_carregarVeiculos.php",
        dataType: "json",
        success: function (data) {
          var select = $(".veiculo_id");

          // Adicionar as opções com cores corretas
          data.forEach(function (veiculo) {
            var option = $("<option></option>")
              .val(veiculo.id)
              .text(veiculo.numero)
              .addClass(veiculo.cor);

            select.append(option);
          });

          // Inicializar o Select2 após carregar os veículos
          select.select2();
        },
        error: function (jqXHR, textStatus, errorThrown) {
          console.error("Erro na requisição AJAX: " + textStatus, errorThrown);
        }
      });
    }

    // Carrega todos os veículos ao carregar a página
    carregarVeiculos();

    // Função para carregar motoristas usando AJAX
    function carregarMotoristas() {
      $.ajax({
        type: "GET",
        url: "../includes/AJAX_carregarMotoristas.php",
        dataType: "json",
        success: function (data) {
          var select = $(".motorista_id");

          // Adicionar as opções com cores corretas
          data.forEach(function (motorista) {
            var optionClass = motorista.em_escala == 1 ? "vermelho" : "verde";
            var option = $("<option></option>")
              .val(motorista.id)
              .text(motorista.nome + " - " + motorista.matricula)
              .addClass(optionClass);

            select.append(option);
          });

          // Inicializar o Select2 após carregar os motoristas
          select.select2();
        },
        error: function (jqXHR, textStatus, errorThrown) {
          console.error("Erro na requisição AJAX: " + textStatus, errorThrown);
        }
      });
    }

    // Carregar motoristas ao carregar a página
    carregarMotoristas();

    // Função para carregar cobradores usando AJAX
    function carregarCobradores() {
        $.ajax({
          type: "GET",
          url: "../includes/AJAX_carregarCobradores.php",
          dataType: "json",
          success: function (data) {
            var select = $(".cobrador_id");
  
            // Adicionar as opções com cores corretas
            data.forEach(function (cobrador) {
              var optionClass = cobrador.em_escala == 1 ? "vermelho" : "verde";
              var option = $("<option></option>")
                .val(cobrador.id)
                .text(cobrador.nome + " - " + cobrador.matricula)
                .addClass(optionClass);
  
              select.append(option);
            });
  
            // Inicializar o Select2 após carregar os cobradores
            select.select2();
          },
          error: function (jqXHR, textStatus, errorThrown) {
            console.error("Erro na requisição AJAX: " + textStatus, errorThrown);
          }
        });
      }
  
      // Carregar cobradores ao carregar a página
      carregarCobradores();

    // Carregar veículos cadastrados em uma escala
    function carregarVeiculosComEscala() {
      $.ajax({
        type: "GET",
        url: "../includes/AJAX_carregarVeiculosComEscala.php",
        dataType: "json",
        success: function (data) {
          var select = $(".veiculo_idPesquisa");

          data.forEach(function (veiculo) {
            var option = $("<option></option>")
              .val(veiculo.id)
              .text(veiculo.numero);

            select.append(option);
          });

          // Inicializar o Select2 após carregar os veículos com escala
          select.select2();
        },
        error: function (jqXHR, textStatus, errorThrown) {
          console.error("Erro na requisição AJAX: " + textStatus, errorThrown);
        }
      });
    }

    // Carrega todos os veículos ao carregar a página
    carregarVeiculosComEscala();

    // Carregar funcionários cadastrados em uma escala
    function carregarFuncionariosComEscala() {
      $.ajax({
        type: "GET",
        url: "../includes/AJAX_carregarFuncComEscala.php",
        dataType: "json",
        success: function (data) {
          var select = $(".funcionario_idPesquisa");

          data.forEach(function (funcionario) {
            var option = $("<option></option>")
              .val(funcionario.id)
              .text(funcionario.nome);

            select.append(option);
          });

          // Inicializar o Select2 após carregar os funcionários com escala
          select.select2();
        },
        error: function (jqXHR, textStatus, errorThrown) {
          console.error("Erro na requisição AJAX: " + textStatus, errorThrown);
        }
      });
    }

    // Carrega todos os funcionários ao carregar a página
    carregarFuncionariosComEscala();
  });