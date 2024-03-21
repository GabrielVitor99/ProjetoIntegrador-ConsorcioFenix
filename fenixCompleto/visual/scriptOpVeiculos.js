// Obtém o botão de edição e a div de formulário
const botaoEditar = document.getElementById("editarVeiculo");
const formularioEdicao = document.getElementById("formularioEdicao");

// Adiciona um ouvinte de evento de clique ao botão de edição
botaoEditar.addEventListener("click", function() {
  // Remove a propriedade "display: none" da div de edição
  formularioEdicao.style.display = "block";
});
