function Valida_Rut(elEvento,Objeto) {

	var enter = [13];

  var evento = elEvento || window.event;
  var codigoCaracter = evento.charCode || evento.keyCode;
  var caracter = String.fromCharCode(codigoCaracter);

  var entra = false;
  for(var i in enter) {
    if(codigoCaracter == enter[i]) {
      entra = true;
    }
  }


  if(entra){
	var tmpstr = ""; 
	var intlargo = Objeto.value;
 
	if (intlargo.length> 0) { 
		crut = Objeto.value;
		largo = crut.length; 
		if ( largo <2 ) { 
			alert('RUT INVALIDO');
			Objeto.focus();
			return false; 
		} 
 
		for ( i=0; i <crut.length ; i++ ) {
			if ( crut.charAt(i) != ' ' && crut.charAt(i) != '.' && crut.charAt(i) != '-' ) { 
				tmpstr = tmpstr + crut.charAt(i); 
			} 
		}	
			rut = tmpstr; 
			crut=tmpstr; 
			largo = crut.length; 
			if ( largo> 2 ){ 
				rut = crut.substring(0, largo - 1); 
			}else{ rut = crut.charAt(0); }
 
				dv = crut.charAt(largo-1); 
				if ( rut == null || dv == null ){ return 0; }
				var dvr = '0'; 
				suma = 0; 
				mul = 2; 
 
				for (i= rut.length-1 ; i>= 0; i--) { 
					suma = suma + rut.charAt(i) * mul; 
					if (mul == 7) mul = 2; 
					else mul++; 
				} 
 
				res = suma % 11; 
				if (res==1){ dvr = 'k'; 
				}else{ if (res==0){ dvr = '0'; 
				}else { dvi = 11-res; dvr = dvi + ""; } 
				}
 
				if ( dvr != dv.toLowerCase() ) { 
					alert('El Rut Ingresado es Invalido'); 
					Objeto.focus(); 
					return false; 
				} 
				alert('El Rut Ingresado es Correcto!');  
				Objeto.value=daformato(tmpstr);
				
				return true; 
	}
  
  } 
}

function valida(Objeto){
	var tmpstr = ""; 
	var intlargo = Objeto.value;
 
	if (intlargo.length> 0) { 
		crut = Objeto.value;
		largo = crut.length; 
		if ( largo <2 ) { 
			alert('RUT inválido');
			Objeto.focus();
			return false; 
		} 
 
		for ( i=0; i <crut.length ; i++ ) {
			if ( crut.charAt(i) != ' ' && crut.charAt(i) != '.' && crut.charAt(i) != '-' ) { 
				tmpstr = tmpstr + crut.charAt(i); 
			} 
		}	
			rut = tmpstr; 
			crut=tmpstr; 
			largo = crut.length; 
			if ( largo> 2 ){ 
				rut = crut.substring(0, largo - 1); 
			}else{ rut = crut.charAt(0); }
 
				dv = crut.charAt(largo-1); 
				if ( rut == null || dv == null ){ return 0; }
				var dvr = '0'; 
				suma = 0; 
				mul = 2; 
 
				for (i= rut.length-1 ; i>= 0; i--) { 
					suma = suma + rut.charAt(i) * mul; 
					if (mul == 7) mul = 2; 
					else mul++; 
				} 
 
				res = suma % 11; 
				if (res==1){ dvr = 'k'; 
				}else{ if (res==0){ dvr = '0'; 
				}else { dvi = 11-res; dvr = dvi + ""; } 
				}
 
				if ( dvr != dv.toLowerCase() ) { 
					alert('El Rut Ingreso es Invalido'); 
					Objeto.focus(); 
					return false; 
				} 
				  
				Objeto.value=daformator(tmpstr);
				return true; 
	}else{
	   alert('RUT inválido');
	   Objeto.focus();
	   return false;
	}	
	
}

function daformato(cadena){
	var resultado="";
	if(cadena.length>=8){
		if(cadena.length==8){
			cadena='0'+cadena;			
		}
		for ( i=0; i <cadena.length ; i++ ) {
			if (i==2 || i==5) { 
				resultado = resultado + '.'; 
			} 
			if(i==8){
				resultado = resultado+'-'
			}
			resultado = resultado + cadena.charAt(i); 
		}
		return resultado;		
	}
}

function daformator(cadena){
	var resultado="";
	var tmpstr = ""; 
		for ( i=0; i <cadena.length ; i++ ) {
			if ( cadena.charAt(i) != ' ' && cadena.charAt(i) != '.' && cadena.charAt(i) != '-' ) { 
				tmpstr = tmpstr + cadena.charAt(i); 
			} 
		}	
	if(tmpstr.length>=8){
		if(tmpstr.length==8){
			tmpstr='0'+cadena;			
		}
		for ( i=0; i <tmpstr.length ; i++ ) {
			if (i==2 || i==5) { 
				resultado = resultado + '.'; 
			} 
			if(i==8){
				resultado = resultado+'-'
			}
			resultado = resultado + tmpstr.charAt(i); 
		}
		return resultado;		
	}
	return cadena;
}


function valida_cadena(Objeto){
	var tmpstr = ""; 
	var intlargo = Objeto;
 
	if (intlargo.length> 0) { 
		crut = Objeto;
		largo = crut.length; 
		if ( largo <2 ) { 
			alert('RUT inválido');

			return false; 
		} 
 
		for ( i=0; i <crut.length ; i++ ) {
			if ( crut.charAt(i) != ' ' && crut.charAt(i) != '.' && crut.charAt(i) != '-' ) { 
				tmpstr = tmpstr + crut.charAt(i); 
			} 
		}	
			rut = tmpstr; 
			crut=tmpstr; 
			largo = crut.length; 
			if ( largo> 2 ){ 
				rut = crut.substring(0, largo - 1); 
			}else{ rut = crut.charAt(0); }
 
				dv = crut.charAt(largo-1); 
				if ( rut == null || dv == null ){ return 0; }
				var dvr = '0'; 
				suma = 0; 
				mul = 2; 
 
				for (i= rut.length-1 ; i>= 0; i--) { 
					suma = suma + rut.charAt(i) * mul; 
					if (mul == 7) mul = 2; 
					else mul++; 
				} 
 
				res = suma % 11; 
				if (res==1){ dvr = 'k'; 
				}else{ if (res==0){ dvr = '0'; 
				}else { dvi = 11-res; dvr = dvi + ""; } 
				}
 
				if ( dvr != dv.toLowerCase() ) { 
					alert('El Rut Ingreso es Invalido'); 
					
					return false; 
				} 
				  
				//Objeto.value=daformator(tmpstr);
				return true; 
	}else{
	   alert('RUT inválido');
	   
	   return false;
	}	
	
}