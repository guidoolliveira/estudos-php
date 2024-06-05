function mostrarSenha(){
    let senha = document.getElementById("senha");

    if(senha.type == "password"){
        senha.setAttribute("type", "text");

    } else{
        senha.setAttribute("type", "password");
    }

}
function mostrarSenha2(){
    let senha = document.getElementById("senha2");

    if(senha.type == "password"){
        senha.setAttribute("type", "text");

    } else{
        senha.setAttribute("type", "password");
    }

}


/* Máscaras ER */
function mascara(obj,funcao){
    v_obj=obj
    v_fun=funcao
    setTimeout("execmascara()",1)
}
function execmascara(){
    v_obj.value=v_fun(v_obj.value)
}
function mtel(valor){
    valor=valor.replace(/\D/g,""); //Remove tudo o que não é dígito
    valor=valor.replace(/^(\d{2})(\d)/g,"($1) $2"); //Coloca parênteses em volta dos dois primeiros dígitos
    valor=valor.replace(/(\d)(\d{4})$/,"$1-$2"); //Coloca hífen entre o quarto e o quinto dígitos
    return valor;
}
function id( el ){
	return document.getElementById( el );
}
window.onload = function(){
	id('celular').onkeyup = function(){
		mascara( this, mtel );
	}
}
function mascara(obj,funcao){
    v_obj=obj
    v_fun=funcao
    setTimeout("execmascara()",1)
}
function execmascara(){
    v_obj.value=v_fun(v_obj.value)
}
function mtel(valor){
    valor=valor.replace(/\D/g,""); //Remove tudo o que não é dígito
    valor=valor.replace(/^(\d{2})(\d)/g,"($1) $2"); //Coloca parênteses em volta dos dois primeiros dígitos
    valor=valor.replace(/(\d)(\d{4})$/,"$1-$2"); //Coloca hífen entre o quarto e o quinto dígitos
    return valor;
}
function id( el ){
	return document.getElementById( el );
}
// Attach event listener to all input fields with class "celular"
var inputFields = document.getElementsByClassName('celular');
for (var i = 0; i < inputFields.length; i++) {
  inputFields[i].onkeyup = function(){
    mascara( this, mtel );
  }
}
function sair(){
    window.location = 'instrutores.php';
}
