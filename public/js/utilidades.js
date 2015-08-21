function salto(elEvento,OBJETO){

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
    
	  OBJETO.focus();	
  }	
}

function salto_combo(OBJETO){
	OBJETO.focus();		
}

function trim (myString)
{
return myString.replace(/^\s+/g,'');
}

function justNumbers(e)
{
    var keynum = window.event ? window.event.keyCode : e.which;
    if ((keynum == 8) || (keynum == 46))
        return true;
 
    return /\d/.test(String.fromCharCode(keynum));
}
    
    
function vacio(cadena){
    if (!cadena || cadena.length === 0) { 
        return true; 
    } 

    return !/\S/.test(cadena);     
}  

function campos_vacios(arreglo){
  //var hay_vacio=false;
  for(i=0;i<arreglo.length;i++){
    if(vacio(arreglo[i])){
      //hay_vacio=true;
      return true;
    }
  }
  //return hay_vacio;
  return false;
}

var statSend = false;
function checkSubmit() {
    if (!statSend) {
        statSend = true;
        return true;
    } else {
        alert("El formulario ya se esta enviando...");
        return false;
    }
}  


function retorna_nombre_proveedor_por_rut(rut_proveedor,id_campo_nombre){
  var el_id="#"+id_campo_nombre;
  $(el_id).val("");
 
  $.getJSON('json/datos_proveedor.php',{format: "json",rut: rut_proveedor}, function(data){
    if(data['encontro']=='SI'){
      $(el_id).val(data['nombre']);
      $(el_id).focus();      
    }else{
      alert("Proveedor No Encontrado!");
      $(el_id).val("");       
    }      
  });
  
}

function vacios(arreglo){
  //var hay_vacio=false;
  for(i=0;i<arreglo.length;i++){
    var dato = $("#"+arreglo[i]).val();
    if(vacio(dato)){
      //hay_vacio=true;
      return true;
    }
  }
  //return hay_vacio;
  return false;
}

function salto_enter(activador,destino){
  $("#"+activador).on("keypress",function(event){
    if(event.which == 13){
      $("#"+destino).focus();
    }
  });
}

function activar_boton(id_boton,func)
{
  //
  $("#"+id_boton).on("click",function(event){
    event.preventDefault();
    func();
  });
}

function activar_al_enter(id_campo,func)
{
  //
  $("#"+id_campo).on("keypress",function(event){
    if(event.which == 13){
      func();
    }
  });
}

function accion_boton(id_boton,func,arr)
{
  $("#"+id_boton).on("click",function(){
    func(arr);
  });
}