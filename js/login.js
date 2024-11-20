function fazLogin(event) {
  var url = "php/faz-login.php";
  var request = new XMLHttpRequest();
  request.open('POST', url, true);
  request.onload = function () { // request successful
    // we can use server response to our request now
    console.log(request.responseText);
    res_json = JSON.parse(request.responseText);
    if (res_json["sucesso"]) {
	  window.location.href = res_json["location"];
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

function mostrarSenhaLogin(){
  if (document.getElementById("mostrar-senha").checked === true){
    document.getElementById("senha").type = "text";
  }else{
    document.getElementById("senha").type = "password";
  }
}

document.getElementsByName("form-login")[0].addEventListener("submit",fazLogin);