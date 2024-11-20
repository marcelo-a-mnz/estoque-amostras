function sair() {
  window.location.href = "logout.php"
  console.error(error)
}

function login() {
  window.location.href = "logout.php"
  console.error(error)
}

function tablePesquisar(){
	var q = document.getElementById("q").value.toLowerCase();
	var trs = document.getElementsByTagName("tr");
	
	 for ( var i = 1; i < trs.length; i++ ) {
		 if (trs[i].outerText.toLowerCase().includes(q) == false){
			 trs[i].style.display = "none";
		 }else{
			 trs[i].style.display = "";
		 }
	 }
}

function replaceEspecialInput(id){
	document.getElementById(id).value = document.getElementById(id).value.replace(/[^A-Za-z0-9._@/ ]+/g, '');
}

function e_value(id){
  return document.getElementById(id).value;
}