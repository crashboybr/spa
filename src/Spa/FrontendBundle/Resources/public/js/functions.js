// LIMPAR CAMPO ONFOCUS
function clearText(elm){
	if (elm.defaultValue == elm.value)
		elm.value = ""
}

// OCULTAR/MOSTRAR OBJETO POR PARAMETRO 
function toggleObject(obj) {
	var objectDisplay = document.getElementById(obj).style.display;
	
	if (objectDisplay == "none") {
		document.getElementById(obj).style.display = "inline";
	}
	else {
		document.getElementById(obj).style.display = "none";
	}
}