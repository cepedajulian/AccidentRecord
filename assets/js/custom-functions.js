
//variables globales
var map;
var dataInfo = {};
var locations = [];
var circles = {};
var personas = {};
var hackLat = 0;


function getFormatedDayTime(value){
	return value.substring(8,10) +"/"+ value.substring(5,7) +"/"+ value.substring(0,4) + " " +value.substring(11) + " hs";
}

function createLocArraysByEmpleado(locObjCompleto){
	//meto el jason en el ARRAY locations
	$.each(locObjCompleto, function(key, loc) {
		if (!locations[key]){
			locations[key] = [];
		} 
		var loc_actual = locations[key];
		loc_actual.push(loc);
		
		//agrego cada persona distinta
		if (!personas[loc.idVendedor]){
			var persona_data = {nombre:loc.nombre, id:loc.idVendedor, cat:loc.categoria};
			personas[loc.idVendedor] = persona_data;
		}
	});
	
	crearBotonesDePersonas();
}

function crearBotonesDePersonas(){
	$("#botones_personas").html('<select id="select_personas" onchange="verRecorridoPersona(this)">'+
		'<option value="0">Seleccione una Persona</option>'+
	'</select>');
	var sel = document.getElementById('select_personas');
	$.each(personas, function(key, persona) {
		var opt = document.createElement('option');
	    opt.value = persona.id;
	    opt.innerHTML = persona.nombre;
	    sel.appendChild(opt);
	});
}

function crearLinksPosiciones(id, nombre){
	$("#botones_locations").html("<div style='margin-top:10px; margin-bottom:10px; font-weight:bold; text-align:center'> Posiciones de " + nombre + "</div>");
	for (i = 0; i < locations.length; i++) { 
		var loc = locations[i];
		loc = loc[0];
		var lat = loc.lat; 
		lat = lat.replace(",",".");		
		var lng = loc.lng; 
		lng = lng.replace(",",".");
		var hora = loc.fecha_hora
		hora = hora.substring(11,16);
		if (loc.idVendedor == id){  
			var newPersonaButton = "<div style='float:left; margin-left:5px; margin-right:5px;'><button type='button' class='btn btn-default' onclick='mapGoTo(" + lat + ","+ lng +")' >" + hora + "</button></div>";
			$("#botones_locations").html($("#botones_locations").html() + newPersonaButton);
		}
	}
}


function mapGoTo(lat, lng){
	var coord = new nokia.maps.geo.Coordinate(lat, lng);
	map.set("center", coord);
	map.set('zoomLevel', 16);
}

function verRecorridoPersona(select) {
	$("#botones_locations").html("");
	var id = select.value;
	var nombre = select.options[select.selectedIndex].innerHTML;
	if (id==0) return false;
	
	//limpio el mapa
	map.objects.clear();
	
	//recorro la lista completa de alertas y dibujo las del empleado track seleccionado
	for (i = 0; i < locations.length; i++) { 
		var loc = locations[i];
		
		//como viene un array con un sólo elemento que tiene un "object" tengo que sacar el primero.
		loc = loc[0];
		
		var lat = loc.lat; 
		lat = lat.replace(",",".");
		
		var lng = loc.lng; 
		lng = lng.replace(",",".");
		
		var hora = loc.fecha_hora
		hora = hora.substring(11,16);
		
		if (loc.idVendedor == id){            
			var marker = new nokia.maps.map.StandardMarker( [parseFloat(lat),parseFloat(lng)] , 
           		{
           			text: hora,
           			textPen: {
           				strokeColor: "#000"
           			},
           			brush: {
           				color: "#FFF"
           			},           			
           			pen: {
           				strokeColor: "#BDBDBD"
           			}, 
           			draggable: true
           		} 
           	);
           		
			// Agrego el marker al mapa
			map.objects.add(marker);
		}		
	}
	//creo la lista de puntos
	crearLinksPosiciones(id, nombre);
}

function getMarkersData(cleanAll){
	
	if (cleanAll==true) {
		locations = []; // limpio locations
		personas = {}; // limpio personas
		$("#botones_locations").html(""); //limpio botones
		map.objects.clear();//limpio el mapa
	}
	
	var post_data = "";
	var fecha = $("#input_date").val();
	if (fecha!=''){ post_data = "fecha="+fecha; }
	$.ajax({
		contentType: "application/x-www-form-urlencoded; charset=UTF-8",
		type: "POST",
		url: "findCheckedPoints",
		data: 	post_data,
		dataType: "json",
		success: function(result){
			createLocArraysByEmpleado(result);
		}
	});
}

$(document).ready(function() {	
	nokia.Settings.set("appId", "URXZdgxbeucuoNFFV0Yk"); 
	nokia.Settings.set("authenticationToken", "Vu6n1j_yDQ2XLQaXU3RKjw");
	
	//Obtenemos la posicion Central para el MAPA, hoy Buenos Aires
	latc=  -34.610343;	
	lngc=  -58.444285;	
	
	var mapContainer = document.getElementById("map");
	map = new nokia.maps.map.Display(mapContainer, {
		center: [latc,lngc],
		zoomLevel: 12,
		components:[new nokia.maps.map.component.Behavior()]
	});
	
	$('#input_date').datepicker({ dateFormat: "dd/mm/yy", altFormat: "yy-mm-dd", altField: "#input_date" });
	
	getMarkersData();		
});