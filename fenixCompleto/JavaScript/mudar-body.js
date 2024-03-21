// CSS

var btnLogin = document.querySelector("#login")
var btnCadastrar = document.querySelector("#cadastrar")

var body = document.querySelector("body")

btnLogin.addEventListener("click", function(){
    body.className = "login-js"
})
btnCadastrar.addEventListener("click", function(){
    body.className = "cadastrar-js"
})

