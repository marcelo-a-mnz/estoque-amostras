
function descarteUnicoChecked() {
  document.getElementById("unico").checked = true;
  document.getElementById("massivo").checked = false;
  document.getElementById("lacre").style.display = "block";
  document.getElementById("prateleira").style.display = "none";
  document.getElementById("campo-prateleira-descarte").removeAttribute("required");
  document.getElementById("campo-lacre-descarte").setAttribute("required","");
}

function descarteMassivoChecked() {
  document.getElementById("massivo").checked = true;
  document.getElementById("unico").checked = false;
  document.getElementById("lacre").style.display = "none";
  document.getElementById("prateleira").style.display = "block";
  document.getElementById("campo-lacre-descarte").removeAttribute("required");
  document.getElementById("campo-prateleira-descarte").setAttribute("required","");
}

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

function descadAmostra(event) {
  var url = "php/descartar-amostra.php";
  if ((document.getElementById("campo-lacre-descarte").style.display === "block")){
	if (document.getElementById("campo-lacre-descarte").value.length < 5) {
		Swal.fire({title: "O lacre não pode ter menos que 5 caractéries!",icon: "error"});
		event.preventDefault();
		return;
	}
  }
  var request = new XMLHttpRequest();
  request.open('POST', url, true);
  request.onload = function () {
    console.log(request.responseText);
    res_json = JSON.parse(request.responseText);
    if (res_json["sucesso"]) {
      document.getElementById("campo-lacre").value = "";
	  lacres = res_json["lacres"];
	  
	  lacres = lacres.sort();
	  i = 0;
	  linha_cont = 1;
	  txt_lacres = '<table align="center"><tr class="tr-descarte">';
	  while (i < lacres.length){
		  txt_lacres += "<td>"+lacres[i]+"</td>";
		  if (linha_cont == 3){
			  txt_lacres += '</tr></table><table align="center" class="table-descarte"><tr>';
			  linha_cont = 0;
		  }
		linha_cont += 1;
		i += 1;
	  }
	  txt_lacres += "</table>";
		  
	  Swal.fire({title: res_json["msg"],icon: "success","html":txt_lacres+"<br><br><strong>Total:</strong> "+lacres.length});
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

function consultarAmostra(event){
	var url = "php/consultar-amostra.php";
	var request = new XMLHttpRequest();
  request.open('POST', url, true);
  request.onload = function () {
    console.log(request.responseText);
    res_json = JSON.parse(request.responseText);
    if (res_json["sucesso"]) {
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
document.getElementsByName("form-descartar-amostra")[0].addEventListener("submit", descadAmostra);
document.getElementsByName("form-editar-amostra")[0].addEventListener("submit", editAmostra);
document.getElementsByName("form-consultar-amostra")[0].addEventListener("submit",consultarAmostra)