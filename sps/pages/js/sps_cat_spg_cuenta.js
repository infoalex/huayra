// JavaScript Document

var url    ='../php/sps_cat_spg_cuenta.php';
var params ='operacion';
var metodo ='get';

function ue_ver_spg_cuentas()
{ 
  validarOpener();                    //valida que el catalogo sea llamado de una pagina
  if (arguments.length > 0)
  {changeCase(arguments[0]);}
  var params = 
  {
	operacion    : "ue_ver_spg_cuentas",
	spg_cuenta   : $F('txtcodigo'),
	denominacion : $F('txtdenominacion')
  };
  new Ajax.Request(url,{method:metodo,parameters:$H(params).toQueryString(),onComplete:onVerCuentas});
  
  function onVerCuentas(respuesta)
  {
	var respuestas = respuesta.responseText.split('&');
	if ($('data_grid_header') != null)
	{$('data_grid_header').id = (respuestas[0]<=10)?"sin_ordenar":"data_grid_header";}
	else
	{$('sin_ordenar').id = (respuestas[0]<=10)?"sin_ordenar":"data_grid_header";}
	$('viewPort').innerHTML = respuestas[1];

	// Creamos la Grid
    var opts = 
    {
	  prefetchBuffer: true, 
	  onscroll : updateHeader,
      sortAscendImg:  '../../../shared/imagebank/sort_asc.gif',
      sortDescendImg: '../../../shared/imagebank/sort_desc.gif'
    };
	var params = 
    {
	  spg_cuenta   : $F('txtcodigo'),
	  denominacion : $F('txtdenominacion')
    };
    new Rico.LiveGrid("data_grid",10, respuestas[0],url+"?"+$H(params).toQueryString(),opts);
  }	
}

//funcion para ordenar por campo y actualiza la tabla al hacer scroll
function updateHeader(liveGrid, offset)
{
	$('marcador').innerHTTML = "Mostrando Registros" + (offset+2) + " - " + 
	                           (offset+liveGrid.metaData.getPageSize()+1)	+ " de " +
	                            liveGrid.metaData.getTotalRows();
	
	var sortInfo = "";
	if (liveGrid.sortCol)
	{
		sortInfo = "&data_grid_sort_col=" + liveGrid.sortCol + "&data_grid_sort_dir="+liveGrid.sortDir;
	}
}

function ue_seleccionar(arreglo)
{
	opener.ue_cargar_registro_spg_cuenta(arreglo); 
	close();
}