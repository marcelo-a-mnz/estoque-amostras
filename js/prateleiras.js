
function modalEditarPrateleira(prateleira,matriz,validade,capacidade_max){
  document.getElementById("campo-prateleira-editar").value = prateleira;
  document.getElementById("campo-matriz-editar").value = matriz;
  document.getElementById("campo-validade-editar").value = validade;
  document.getElementById("campo-capacidade-max-editar").value = capacidade_max;
}

function modalBaixarPrateleira(prateleira){
  document.getElementById("campo-prateleira-baixar").value = prateleira;
}

function deletarPrateleiraChecked(prateleira) {
  if (document.getElementById("deletar-prateleira-checkbox").checked){
    Swal.fire({title: "Caso haja amostras na prateleira, deseja mover automaticamente as amostras para outra prateleira cuja matriz é a mesma ("+e_value('campo-matriz-editar')+") ?",
      icon:"warning",
      showCloseButton: true,
   showCancelButton: true}).then((result) => {if (result.isConfirmed){
    document.getElementById("migrar-amostras").value = "true";
  }
  });
  }else{
    document.getElementById("migrar-amostras").value = "false";
  }

}

function delPrateleira(event) {
  var url = "php/deletar-prateleira.php";
  var request = new XMLHttpRequest();
  request.open('POST', url, true);
  request.onload = function () {
    console.log(request.responseText);
    res_json = JSON.parse(request.responseText);
    if (res_json["sucesso"]) {
      document.getElementById("campo-prateleira").value = "";
    Swal.fire({title: res_json["msg"],icon: "success"}).then((result) => {if (result.isConfirmed){window.location.reload();}})
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

function cadPrateleira(event) {
  var url = "php/cadastrar-prateleira.php";
  if (document.getElementById("campo-validade").value <= 0 ) {
    Swal.fire({title: "A validade não pode ser menor ou igual a zero!",icon: "error"});
    event.preventDefault();
    return;
  }
  if (document.getElementById("campo-capacidade-max").value <= 0 ) {
    Swal.fire({title: "A capacidade máxima não pode ser menor ou igual a zero!",icon: "error"});
    event.preventDefault();
    return;
  }
  var request = new XMLHttpRequest();
  request.open('POST', url, true);
  request.onload = function () {
    console.log(request.responseText);
    res_json = JSON.parse(request.responseText);
    if (res_json["sucesso"]) {
      document.getElementById("campo-prateleira").value = "";
	  Swal.fire({title: res_json["msg"],icon: "success"}).then((result) => {if (result.isConfirmed){window.location.reload();}})
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

function editPrateleira(event) {
  if (document.getElementById("deletar-prateleira-checkbox").checked){
    delPrateleira(event);
    return;
  }
  var url = "php/editar-prateleira.php";
  if (document.getElementById("campo-validade-editar").value <= 0 ) {
    Swal.fire({title: "A validade não pode ser menor ou igual a zero!",icon: "error"});
    event.preventDefault();
    return;
  }
  if (document.getElementById("campo-capacidade-max-editar").value <= 0 ) {
    Swal.fire({title: "A capacidade máxima não pode ser menor ou igual a zero!",icon: "error"});
    event.preventDefault();
    return;
  }
  var request = new XMLHttpRequest();
  request.open('POST', url, true);
  request.onload = function () {
    console.log(request.responseText);
    res_json = JSON.parse(request.responseText);
    if (res_json["sucesso"]) {
	  Swal.fire({title: res_json["msg"],icon: "success"}).then((result) => {if (result.isConfirmed){window.location.reload();}})
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

function baixarPrateleira(event) {
	swal_espere = Swal.fire({title:"Por favor, espere..."});
	var url = "php/baixar-prateleira.php";
	var request = new XMLHttpRequest();
	request.open('POST', url, true);
	request.onload = function () {
    console.log(request.responseText);
    res_json = JSON.parse(request.responseText);
    if (res_json["sucesso"]) {
		swal_espere.close();
		arquivos64 = res_json["arquivos64"];
		prateleira = document.getElementById("campo-prateleira-baixar").value;
		opcao = res_json["opcao"];
		cont = 1;
		for ( var i = 0; i < arquivos64.length; i++ ){
			link = document.createElement("a");
			link.download = prateleira+"_"+opcao+"_"+cont+".xlsx";
			link.href = "data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;base64,"+arquivos64[i];
			link.click();
			cont += 1;
		}
			
		Swal.fire({title: res_json["msg"],icon: "success"});
    }else{
		 Swal.fire({title: res_json["msg"],icon: "error"});
	}
  }

  request.onerror = function () {
     Swal.fire({title: "Erro na requisição!",icon: "error"});
  }

  request.send(new FormData(event.target)); // create FormData from form that triggered event
  event.preventDefault();
}

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
document.getElementById("data-inicio").max = maxDate;
document.getElementById("data-final").max = maxDate;
document.getElementById("data-final").value = maxDate;
	
// Eventos
document.getElementsByName("form-cadastrar-prateleiras")[0].addEventListener("submit",cadPrateleira);
document.getElementsByName("form-editar-prateleira")[0].addEventListener("submit",editPrateleira);
document.getElementsByName("form-baixar-prateleira")[0].addEventListener("submit",baixarPrateleira);