
function mostrarSenhaCadastro(){
  if (document.getElementById("mostrar-senha").checked === true){
    document.getElementById("senha").type = "text";
    document.getElementById("confirmar-senha").type = "text";
  }else{
    document.getElementById("senha").type = "password";
    document.getElementById("confirmar-senha").type = "password";
  }
}

function modalEditarUsuario(usuario,privilegio){
  document.getElementById("usuario").value = usuario;
  if (privilegio == "1"){
    document.getElementById("funcao").checked = true;
  }else{
    document.getElementById("funcao2").checked = true;
  }
}

function cadastrarUsuario(event) {
  var url = "php/cadastrar-usuario.php";
  if (document.getElementById("senha").value != document.getElementById("confirmar-senha").value){
    Swal.fire({title: "As senhas não são iguais",icon:"error"}).then((result) => {if (result.isConfirmed){document.getElementById("senha").type = "text";document.getElementById("confirmar-senha").type = "text";}});
    event.preventDefault();
    return;
  }
  if (document.getElementById("senha").value.length < 8){
    Swal.fire({title: "A senha não pode ter menos que 8 caractéries!",icon:"error"});
    event.preventDefault();return;
  }
    
  var request = new XMLHttpRequest();
  request.open('POST', url, true);
  request.onload = function () {
    console.log(request.responseText);
    res_json = JSON.parse(request.responseText);
    if (res_json["sucesso"]) {
    Swal.fire({title: res_json["msg"],icon: "success"}).then((result) => {if (result.isConfirmed){window.location.reload();}});
    }else{
     Swal.fire({title: res_json["msg"],icon: "error"});
  }
  };

  request.onerror = function () {
     Swal.fire({title: "Erro na requisição!",icon: "error"});
  };

  request.send(new FormData(event.target));
  event.preventDefault();
}

function editarUsuario(event) {
  var url = "php/editar-usuario.php";
  if (document.getElementById("nova-senha").value != document.getElementById("nova-senha-confirmar").value){
    Swal.fire({title: "As senhas não são iguais",icon:"error"}).then((result) => {if (result.isConfirmed){document.getElementById("senha").type = "text";document.getElementById("confirmar-senha").type = "text";}});
    event.preventDefault();
    return;
  }
    
  var request = new XMLHttpRequest();
  request.open('POST', url, true);
  request.onload = function () {
    console.log(request.responseText);
    res_json = JSON.parse(request.responseText);
    if (res_json["sucesso"]) {
    Swal.fire({title: res_json["msg"],icon: "success"}).then((result) => {if (result.isConfirmed){window.location.reload();}});
    }else{
     Swal.fire({title: res_json["msg"],icon: "error"});
  }
  };

  request.onerror = function () {
     Swal.fire({title: "Erro na requisição!",icon: "error"});
  };

  request.send(new FormData(event.target));
  event.preventDefault();
}

function modalEditarUsuario(usuario,privilegio){
  document.getElementById("usuario").value = usuario;
  if (privilegio == "1"){
    document.getElementById("funcao").checked = true;
  }else{
    document.getElementById("funcao2").checked = true;
  }
}

function deletarUsuario(usuario) {
  var url = "php/deletar-usuario.php";
   Swal.fire({title: "Deseja realmente deletar esse usuário do sistema?",icon:"warning",showCloseButton: true,
   showCancelButton: true}).then((result) => {if (result.isConfirmed){formulario = new FormData();formulario.append("usuario",usuario);request.send(formulario);}else{event.preventDefault();return;}});
	  
  var request = new XMLHttpRequest();
  request.open('POST', url, true);
  request.onload = function () { // request successful
    // we can use server response to our request now
    console.log(request.responseText);
    res_json = JSON.parse(request.responseText);
    if (res_json["sucesso"]) {
	  Swal.fire({title: res_json["msg"],icon: "success"}).then((result) => {if (result.isConfirmed){window.location.reload();}});
    }else{
		 Swal.fire({title: res_json["msg"],icon: "error"});
	}
	};
	request.onerror = function () {
     Swal.fire({title: "Erro na requisição!",icon: "error"});
  };
}

document.getElementsByName("form-cadastrar-usuario")[0].addEventListener("submit",cadastrarUsuario);
document.getElementsByName("form-editar-usuario")[0].addEventListener("submit",editarUsuario);