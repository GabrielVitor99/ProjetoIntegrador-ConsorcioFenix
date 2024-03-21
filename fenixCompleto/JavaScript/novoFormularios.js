document.addEventListener("DOMContentLoaded", function () {
    // Obtendo os botões
    const opVeiculoBtn = document.getElementById("OpVeiculoBtn");
    const opFuncionarioBtn = document.getElementById("OpFuncionarioBtn");
    const opSistemaBuscaBtn = document.getElementById("OpSistemaBuscaBtn");

    // Obtendo os formulários e divs
    const centralOperacoesVeiculo = document.getElementById("centralOperacoesVeiculo");
    const cadastrarVeiculoDiv = document.getElementById("BtnCadastrarVeiculo");
    const pesquisarVeiculoDiv = document.getElementById("pesquisarVeiculoDiv");
    const centralOperacoesFuncionario0 = document.getElementById("centralOperacoesFuncionario0");
    const cadastrarFuncionarioDiv = document.getElementById("cadastrarFuncionarioDiv");
    const pesquisarFuncionarioDiv = document.getElementById("pesquisarFuncionarioDiv");
    const formSistemaBusca = document.getElementById("formSistemaBusca");
    const headerDois = document.getElementById("headerDois");
    const logo = document.getElementById("imagemLogo");

    // Função para mostrar um elemento e esconder os outros
    function mostrarElemento(elemento) {
        [centralOperacoesVeiculo, cadastrarVeiculoDiv, pesquisarVeiculoDiv, centralOperacoesFuncionario0, cadastrarFuncionarioDiv, pesquisarFuncionarioDiv, formSistemaBusca].forEach(el => {
            el.style.display = el === elemento ? "block" : "none";
        });
        logo.style.display = "none"; // Remover sempre o logo quando clicar num botão
        headerDois.style.display = "block"; // Mostrar sempre o header quando clicar num botão

    }

    // Quando clicar em "Operações de veículo"
    opVeiculoBtn.addEventListener("click", function () {
        mostrarElemento(centralOperacoesVeiculo);
    });

    // Quando clicar em "Cadastrar veículo"
    document.getElementById("cadastrarVeiculo").addEventListener("click", function () {
        mostrarElemento(cadastrarVeiculoDiv);
    });

    // Quando clicar em "Operações de funcionário"
    opFuncionarioBtn.addEventListener("click", function () {
        mostrarElemento(centralOperacoesFuncionario0);
    });

    // Quando clicar em "Cadastrar funcionário"
    document.getElementById("cadastrarFuncionario").addEventListener("click", function () {
        mostrarElemento(cadastrarFuncionarioDiv);
    });

    // Quando clicar em "Sistema de Buscas - escala"
    opSistemaBuscaBtn.addEventListener("click", function () {
        mostrarElemento(formSistemaBusca);
    });
});
