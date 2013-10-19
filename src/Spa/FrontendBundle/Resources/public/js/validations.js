// JavaScript Document
function MascaraTelefone(tel,event){
	if(!event)
		var event=window.event;
	return formataCampo(tel,'(00) 0000-0000',event);
}
function formataCampo(campo,Mascara,evento){
	var Digitato;
	if(evento.keyCode)
		Digitato=evento.keyCode;
	else if(evento.which)
		Digitato=evento.which;
	if(Digitato!=8){
		campo.value=_formataCampo(campo,Mascara);
		return false;}
	return true;
}
function _formataCampo(campo,Mascara){
	var boleanoMascara;
	var exp=/[^0-9]|/g;
	var campoSoNumeros=campo.value.toString().replace(exp,"");
	var numerosDaMascara=Mascara.replace(exp,"");
	if(campoSoNumeros.length>numerosDaMascara.length){
		campoSoNumeros=campoSoNumeros.substr(0,numerosDaMascara.length);
	}
	var posicaoCampo=0;
	var NovoValorCampo="";
	var TamanhoMascara=campoSoNumeros.length;
	for(i=0;i<=TamanhoMascara;i++){
		boleanoMascara=((Mascara.charAt(i)=="-")||(Mascara.charAt(i)==".")||(Mascara.charAt(i)=="/"));
		boleanoMascara=boleanoMascara||((Mascara.charAt(i)=="(")||(Mascara.charAt(i)==")")||(Mascara.charAt(i)==" "));
		if(boleanoMascara){
			NovoValorCampo+=Mascara.charAt(i);
			TamanhoMascara++;
		}
		else {
			NovoValorCampo+=campoSoNumeros.charAt(posicaoCampo);posicaoCampo++;
		}
	}
	return NovoValorCampo;
}

function validateEmail(campo,aviso) {
	var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
	var address = document.getElementById(campo).value;
	if(reg.test(address) == false) {
		document.getElementById(aviso).style.display = "block"
		return false;
	}
	else
		document.getElementById(aviso).style.display = "none"
}

function validateField(elm1, elm2) {
	var content = elm1.value;
	if (content == false || content == "-1") {
		document.getElementById(elm2).style.display = "block"
	}
	else
		document.getElementById(elm2).style.display = "none"
}

function validateForm(elm1, elm2, elm3) {
	var obrFields = [elm1,elm2,elm3];
	var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
	var address = document.getElementById(elm2).value;
	
	for (x in obrFields) {
		document.getElementById
		if (document.getElementById(obrFields[x]).value == false || reg.test(address) == false) {
			alert("Por favor preencha os campos corretamente.");
			return false;
		}
		else
			return true;
	}
}
function validateFicha() {
	var obrFields = ["nome","cidade","estado","telefonefixo","telefonemovel","email","local_Abertura1","estado_abertura1","investimento"];
	var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
	var address = document.getElementById(obrFields[5]).value;
	
	for (x in obrFields) {
		document.getElementById
		if (document.getElementById(obrFields[x]).value == false || reg.test(address) == false || document.getElementById(obrFields[x]).value == "-1") {
			alert("Por favor preencha os campos corretamente.");
			return false;
		}
		else
			return true;
	}
}