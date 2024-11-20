
function editAmostraFormulario(prateleira,lacre,data_amostragem){
	document.getElementById("campo-prateleira-editar").value = prateleira;
	document.getElementById("campo-lacre-editar").value = lacre;
	document.getElementById("campo-data-amostra-editar").value = data_amostragem;
}

function cadAmostra(event) {
  var url = "php/cadastrar-amostra.php";
  if (document.getElementById("campo-lacre").value.length < 5) {
    Swal.fire({title: "O lacre não pode ter menos que 5 caractéries!",icon: "error"});
    event.preventDefault();
    return;
  }
  var request = new XMLHttpRequest();
  request.open('POST', url, true);
  request.onload = function () {
    console.log(request.responseText);
    res_json = JSON.parse(request.responseText);
    if (res_json["sucesso"]) {
      document.getElementById("campo-lacre").value = "";
	  Swal.fire({title: res_json["msg"],icon: "success"}).then((result) => {if (result.isConfirmed){if (document.title == "Formulário"){window.location.reload();}}});;
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

function deletarAmostra(lacre) {
  var url = "php/deletar-amostra.php";
   Swal.fire({title: "Deseja realmente deletar essa amostra do sistema?",icon:"warning",showCloseButton: true,
   showCancelButton: true}).then((result) => {if (result.isConfirmed){formulario = new FormData();formulario.append("lacre",lacre);request.send(formulario);}else{event.preventDefault();return;}});
	  
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

function editAmostra(event) {
  var url = "php/editar-amostra.php";
  if (document.getElementById("campo-lacre-editar").value.length < 5) {
    Swal.fire({title: "O lacre não pode ter menos que 5 caractéries!",icon: "error"});
    event.preventDefault();
    return;
  }
  var request = new XMLHttpRequest();
  request.open('POST', url, true);
  request.onload = function () {
    console.log(request.responseText);
    res_json = JSON.parse(request.responseText);
    if (res_json["sucesso"]) {
      document.getElementById("campo-lacre-editar").value = "";
    Swal.fire({title: res_json["msg"],icon: "success"});
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

// Restringe o input campo-data-amostra somente a data de hoje ou antigas
var dtToday = new Date();
var month = dtToday.getMonth() + 1;
var day = dtToday.getDate();
var year = dtToday.getFullYear();

if (month < 10) {
	month = '0' + month.toString();
}
if (day < 10) {
	day = '0' + day.toString();
}

var maxDate = year + '-' + month + '-' + day;
// seta a data de hoje como default no input campo-data-amostra
document.getElementById("campo-data-amostra").max = maxDate;
document.getElementById("campo-data-amostra").value = maxDate;
document.getElementById("campo-data-amostra-editar").max = maxDate;
document.getElementById("campo-data-amostra-editar").value = maxDate;

// Eventos
document.getElementsByName("form-cadastrar-amostra")[0].addEventListener("submit", cadAmostra);
document.getElementsByName("form-editar-amostra")[0].addEventListener("submit", editAmostra);
