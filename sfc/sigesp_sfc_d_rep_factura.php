<?Php
/******************************************/
/* FECHA: 13/08/2007                      */
/* AUTOR: ING. ZULHEYMAR RODR�GUEZ        */
/******************************************/

session_start();
if (!array_key_exists("la_logusr",$_SESSION))
   {
	 print "<script language=JavaScript>";
	 print "location.href='../sigesp_conexion.php'";
	 print "</script>";
   }
//$_SESSION["ls_codtienda"] = '0001';
$la_datemp=$_SESSION["la_empresa"];
$ls_codtie=$_SESSION["ls_codtienda"];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Listado de Facturas</title>
<meta http-equiv="" content="text/html; charset=iso-8859-1">
<meta http-equiv="" content="text/html; charset=iso-8859-1">
<script type="text/javascript" language="JavaScript1.2" src="js/stm31.js"></script>
<script type="text/javascript" language="JavaScript1.2" src="js/validaciones.js"></script>
<meta http-equiv="" content="text/html; charset=iso-8859-1"><meta http-equiv="" content="text/html; charset=iso-8859-1">
<link href="../shared/css/cabecera.css" rel="stylesheet" type="text/css">
<link href="../shared/js/css_intra/datepickercontrol.css" rel="stylesheet" type="text/css">
<link href="../shared/css/general.css" rel="stylesheet" type="text/css">
<link href="../shared/css/tablas.css" rel="stylesheet" type="text/css">
<link href="../shared/css/ventanas.css" rel="stylesheet" type="text/css">
<script type="text/javascript" language="JavaScript1.2" src="../shared/js/disabled_keys.js"></script>
<script language="javascript">
	if(document.all)
	{ //ie
		document.onkeydown = function(){
		if(window.event && (window.event.keyCode == 122 || window.event.keyCode == 116 || window.event.ctrlKey))
		{
			window.event.keyCode = 505;
		}
		if(window.event.keyCode == 505){ return false;}
		}
	}
</script>
<style type="text/css">
<!--
.style6 {color: #000000}
.Estilo1 {color: #6699CC}
-->
</style>
</head>
<body link="#006699" vlink="#006699" alink="#006699">
<table width="780" border="0" align="center" cellpadding="0" cellspacing="0" class="contorno" >
  <tr>
    <td height="30" colspan="2" class="cd-logo"><img src="../shared/imagebank/header.jpg" width="778" height="40"></td>
  </tr>
  <tr>
    <td width="517" height="20" class="cd-menu"><span class="descripcion_sistema Estilo1">Sistema de Facturaci&oacute;n</span></td>
    <td width="261" class="cd-menu"><div align="right"><b><?PHP print date("j/n/Y")." - ".date("h:i a");?></b></div></td>
  </tr>
  <tr>
    <td height="20" class="cd-menu">&nbsp;</td>
    <td height="20" class="cd-menu"><div align="right"><b><?PHP print $_SESSION["la_nomusu"]." ".$_SESSION["la_apeusu"];?></b></div></td>
  </tr>
  <tr>
    <td height="20" colspan="2" class="cd-menu">
	<script type="text/javascript" language="JavaScript1.2" src="js/menu.js"></script>	</td>
  </tr>
  <tr>
    <td height="20" colspan="2" bgcolor="#FFFFFF" class="toolbar">&nbsp;</td>
  </tr>
  <tr>
    <td height="20" colspan="2" bgcolor="#FFFFFF" class="toolbar"><a href="javascript: ue_ver();"><img src="../shared/imagebank/tools20/imprimir.gif" alt="Buscar" width="20" height="20" border="0"></a><a href="javascript: ue_ver2();"><img src="../shared/imagebank/tools20/excel.jpg" alt="Excel" width="22" height="20" border="0"></a><!--img src="../shared/imagebank/tools20/imprimir.gif" alt="Imprimir" width="20" height="20"--><a href="javascript:ue_eliminar();"><img src="../shared/imagebank/tools20/eliminar.gif" alt="Eliminar" width="20" height="20" border="0"></a><a href="sigespwindow_blank.php"><img src="../shared/imagebank/tools20/salir.gif" alt="Salir" width="20" height="20" border="0"></a></td>
  </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<?Php
//////////////////////////////////////////////         SEGURIDAD               /////////////////////////////////////////////
	require_once("../shared/class_folder/sigesp_c_seguridad.php");
	$io_seguridad= new sigesp_c_seguridad();

	$arre=$_SESSION["la_empresa"];
	$ls_empresa=$arre["codemp"];
	$ls_logusr=$_SESSION["la_logusr"];
	$ls_sistema="SFC";
	$ls_ventanas="sigesp_sfc_d_rep_factura.php";

	$la_seguridad["empresa"]=$ls_empresa;
	$la_seguridad["logusr"]=$ls_logusr;
	$la_seguridad["sistema"]=$ls_sistema;
	$la_seguridad["ventanas"]=$ls_ventanas;

	if (array_key_exists("permisos",$_POST))
	{

			$ls_permisos=             $_POST["permisos"];
			$la_permisos["leer"]=     $_POST["leer"];
			$la_permisos["incluir"]=  $_POST["incluir"];
			$la_permisos["cambiar"]=  $_POST["cambiar"];
			$la_permisos["eliminar"]= $_POST["eliminar"];
			$la_permisos["imprimir"]= $_POST["imprimir"];
			$la_permisos["anular"]=   $_POST["anular"];
			$la_permisos["ejecutar"]= $_POST["ejecutar"];

	}
	else
	{
		$la_permisos["leer"]="";
		$la_permisos["incluir"]="";
		$la_permisos["cambiar"]="";
		$la_permisos["eliminar"]="";
		$la_permisos["imprimir"]="";
		$la_permisos["anular"]="";
		$la_permisos["ejecutar"]="";
		$ls_permisos=$io_seguridad->uf_sss_load_permisos($ls_empresa,$ls_logusr,$ls_sistema,$ls_ventanas,$la_permisos);
	}

//////////////////////////////////////////////         SEGURIDAD               /////////////////////////////////////////////
require_once("../shared/class_folder/sigesp_include.php");
require_once("../shared/class_folder/class_mensajes.php");
require_once("../shared/class_folder/class_sql.php");
require_once("../shared/class_folder/class_funciones.php");
require_once("class_folder/sigesp_sfc_class_utilidades.php");
require_once("../shared/class_folder/class_datastore.php");
$io_datastore= new class_datastore();
$io_utilidad = new sigesp_sfc_class_utilidades();
$io_include=new sigesp_include();
$io_connect=$io_include->uf_conectar();
$io_msg=new class_mensajes();
$io_sql=new class_sql($io_connect);
$io_data=new class_datastore();
$io_funcion=new class_funciones();
$ls_codemp=$la_datemp["codemp"];


/**************************************************************************************************************************/
/**************************    SUBMIT   ***********************************************************************************/
/**************************************************************************************************************************/
if(array_key_exists("operacion",$_POST))
{
	$ls_operacion=$_POST["operacion"];
	/*$ls_nomcla="%".$_POST["nomcla"]."%";*/
	$ls_codusu="%/".$_POST["txtcodusu"]."%";
	$ls_codcli="%/".$_POST["txtcodcli"]."%";
	$ls_razcli=$_POST["txtrazcli"];
	/*$ls_fecemi=$_POST["txtfecemi"];*/
	$ls_fecemi=$_POST["txtfecemi"];
	$ls_fecemi2=$_POST["txtfecemi2"];
	$ls_orden=$_POST["combo_orden"];
	$ls_estatus=$_POST["combo_estatus"];
	$ls_ordenarpor=$_POST["combo_ordenarpor"];
	$ls_opcion=$_POST["opcion"];

	$ls_tienda_desde = $_POST["txtcodtienda_desde"];
	$ls_tienda_hasta = $_POST["txtcodtienda_hasta"];


	$ls_fecemi=$io_funcion->uf_convertirdatetobd($ls_fecemi);
	$ls_fecemi2=$io_funcion->uf_convertirdatetobd($ls_fecemi2);
	if ($ls_fecemi=="")
	{
	$ls_fecemi="%/".$ls_fecemi."%";
	}

	if ($ls_fecemi2=="")
	{
	$ls_fecemi2="%/".$ls_fecemi2."%";
	}
}
else
/************************************************************************************************************************/
/***************************   NO SUBMIT ********************************************************************************/
/************************************************************************************************************************/
{
	$ls_operacion="";
	$ls_codusu="";
	$ls_codcli="";
	$ls_razcli="";
	$ls_estatus="Null";
	$ls_opcion="detalles";
	$ls_fecemi="%%";
	$ls_fecemi2="%%";
	$ls_orden="";
	$ls_ordenarpor="Null";
}

if($ls_operacion=="ue_actualizar_option")
	{
		  if ( $ls_opcion=="detalles")
		  {
		  $ls_opcion="detalles";
		  $ls_ordenarpor="Null";
		  }else{
		  $ls_opcion="resumen";
		  $ls_ordenarpor="Null";
		  }


	}


?>
<form name="form1" method="post" action="">
<?php
//////////////////////////////////////////////         SEGURIDAD               /////////////////////////////////////////////
if (($ls_permisos))
{
	print("<input type=hidden name=permisos id=permisos value='$ls_permisos'>");
	print("<input type=hidden name=leer     id=leer value='$la_permisos[leer]'>");
	print("<input type=hidden name=incluir  id=incluir value='$la_permisos[incluir]'>");
	print("<input type=hidden name=cambiar  id=cambiar value='$la_permisos[cambiar]'>");
	print("<input type=hidden name=eliminar id=eliminar value='$la_permisos[eliminar]'>");
	print("<input type=hidden name=imprimir id=imprimir value='$la_permisos[imprimir]'>");
	print("<input type=hidden name=anular   id=anular value='$la_permisos[anular]'>");
	print("<input type=hidden name=ejecutar id=ejecutar value='$la_permisos[ejecutar]'>");
}
else
{

	print("<script language=JavaScript>");
	print(" location.href='sigespwindow_blank.php'");
	print("</script>");
}
//////////////////////////////////////////////         SEGURIDAD               /////////////////////////////////////////////
?>
    <table width="518" height="290" border="0" align="center" cellpadding="0" cellspacing="0" class="formato-blanco">
      <tr>
        <td width="506" height="248"><div align="center">
            <table  border="0" cellspacing="0" cellpadding="0" class="formato-blanco" align="center">
              <tr>
                <td colspan="3" class="titulo-ventana">Listado de Facturas (Filtrar) </td>
              </tr>
              <tr>
                <td colspan="3" class="sin-borde">&nbsp;</td>
              </tr>
              <tr>
                <td width="143" ><div align="right">
                  <input name="operacion" type="hidden" id="operacion" value="<? print $ls_operacion?>">
                  <input name="operacion1" type="hidden" id="operacion1" value="<? print $ls_opcion?>">
                  Ordenar por

                </div></td>
                <td width="200" ><p align="left">



                  <select name="combo_ordenarpor" size="1" >

				  <?php
				  if ($ls_ordenarpor=="Null")
				   {
				   ?>
				    <option value="Null" selected>Seleccione...</option>
                    <option value="f.codcli">C&eacute;dula &oacute; rif</option>
                    <option value="f.fecemi">Fecha</option>
                    <option value="f.monto">Monto</option>
                    <option value="f.numfac">N&uacute;mero factura</option>
                    <option value="f.estfaccon">Estatus factura</option>
				  <?php
				   }
				  elseif ($ls_ordenarpor=="f.codcli")
				   {
				    ?>
				    <option value="Null" >Seleccione...</option>
                    <option value="f.codcli"  >C&eacute;dula &oacute; rif</option>
                    <option value="f.fecemi">Fecha</option>
                    <option value="f.monto">Monto</option>
                    <option value="f.numfac">N&uacute;mero factura</option>
                    <option value="f.estfaccon">Estatus factura</option>
				  <?php
				   }
				   elseif ($ls_ordenarpor=="f.fecemi")
				   {
				    ?>
				    <option value="Null" >Seleccione...</option>
                    <option value="f.codcli" >C&eacute;dula &oacute; rif</option>
                    <option value="f.fecemi"  >Fecha</option>
                    <option value="f.monto">Monto</option>
                    <option value="f.numfac">N&uacute;mero factura</option>
                    <option value="f.estfaccon">Estatus factura</option>
				  <?php
				    }
				   elseif ($ls_ordenarpor=="f.monto")
				   {
				    ?>
				    <option value="Null" >Seleccione...</option>
                    <option value="f.codcli" >C&eacute;dula &oacute; rif</option>
                    <option value="f.fecemi">Fecha</option>
                    <option value="f.monto"  >Monto</option>
                    <option value="f.numfac">N&uacute;mero factura</option>
                    <option value="f.estfaccon">Estatus factura</option>
				  <?php
				   }
				   elseif ($ls_ordenarpor=="f.numfac")
				   {
				  ?>
                    <option value="Null">Seleccione...</option>
                    <option value="f.codcli">C&eacute;dula &oacute; rif</option>
                    <option value="f.fecemi">Fecha</option>
                    <option value="f.monto">Monto</option>
                    <option value="f.numfac">N&uacute;mero factura</option>
                    <option value="f.estfaccon">Estatus factura</option>
					<?php
				   }
				   elseif ($ls_ordenarpor=="f.estfaccon")
				   {
				  ?>
				  <option value="Null" >Seleccione...</option>
                    <option value="f.codcli" >C&eacute;dula &oacute; rif</option>
                    <option value="f.fecemi">Fecha</option>
                    <option value="f.monto" >Monto</option>
                    <option value="f.numfac">N&uacute;mero factura</option>
                   <option value="f.estfaccon" >Estatus factura</option>
				 <?php
				   }
				 ?>
                  </select>




                </p></td>
                <td width="104" >Orden<select name="combo_orden" size="1">
                  <?php
				  if ($ls_orden=="ASC")
				   {
				   ?>
                  <option value="ASC" selected>ASC</option>
                  <option value="DESC">DESC</option>
                  <?php
				   }
				  else
				   {
				   ?>
                  <option value="ASC" >ASC</option>
                  <option value="DESC" selected>DESC</option>
                  <?php
				  }
				  ?>
                </select></td>
              </tr>

               <?php
					if ($ls_codtie == '0001') {

					?>

                   <input type="hidden" name="hdnagrotienda" value=""/>

					<tr>
		                <td height="22" align="right">Desde Unidad Operativa de Suministro:</td>
		                <td colspan="3" >

		                <input name="txtdentienda_desde" type="text" id="txtdentienda_desde" size="30">
		                 <input name="txtcodtienda_desde" type="hidden" id="txtcodtienda_desde" size="30">
		                <a href="javascript: ue_buscar_tienda('desde');"><img src="../shared/imagebank/tools20/buscar.gif" alt="Buscar" width="20" height="20" border="0">Buscar</a></td>
					</tr>

					<tr>
		                <td height="22" align="right">Hasta Unidad Operativa de Suministro:</td>
		                <td colspan="3" >
		                <input name="txtdentienda_hasta" type="text" id="txtdentienda_hasta" size="30">
		                <input name="txtcodtienda_hasta" type="hidden" id="txtcodtienda_hasta" size="30">
		                <a href="javascript: ue_buscar_tienda('hasta');"><img src="../shared/imagebank/tools20/buscar.gif" alt="Buscar" width="20" height="20" border="0">Buscar</a></td>
					</tr>


					<?php
					}
					?>


              <tr>
                <td height="22" align="right">C<span class="style2">ajero </span></td>
                <td colspan="2" ><input name="txtcodusu" type="text" id="txtcodusu">
                <a href="javascript: ue_buscar_cajero();"><img src="../shared/imagebank/tools20/buscar.gif" alt="Buscar" width="20" height="20" border="0"></a></td>
              </tr>
              <tr>
                <td height="22" align="right"><input name="txtcodcli" type="hidden" id="txtcodcli">
                Cliente </td>
                <td ><input name="txtrazcli" type="text" id="txtrazcli">
                <a href="javascript: ue_buscar_cliente();"><img src="../shared/imagebank/tools20/buscar.gif" alt="Buscar" width="20" height="20" border="0"></a></td>
                <td ><a href="javascript: ue_ver();"></a></td>
              </tr>


			 <tr>
			 <td width="143" height="25" ><div align="right">
                  <input name="estatus" type="hidden" id="estatus" value="<? print $ls_estatus?>">

                 Estatus de Factura

                </div></td>
                <td width="153" ><p align="left">
                  <select name="combo_estatus" size="1">
                    <?php
				  if ($ls_estatus=="Null")
				   {
				   ?>
                    <option value="Null"  selected>Seleccione...</option>
                    <option value="N">Por Cobrar</option>
                    <option value="C">Cancelada</option>
                    <option value="A">Anulada</option>
                    <?php
				   }
				  elseif($ls_estatus=="N")
				   {
				   ?>
                    <option value="Null"  >Seleccione...</option>
                    <option value="N" selected>Por Cobrar</option>
                    <option value="C">Cancelada</option>
                   <option value="A">Anulada</option>
                    <?php
				  }

				  elseif($ls_estatus=="C")
				   {
				   ?>
                    <option value="Null" >Seleccione...</option>
                    <option value="N">Por Cobrar</option>
                    <option value="C" selected>Cancelada</option>
                    <option value="A">Anulada</option>
                    <?php
				  }

				  elseif($ls_estatus=="A")
				   {
				   ?>
                    <option value="Null"  >Seleccione...</option>
                    <option value="N">Por Cobrar</option>
                    <option value="C">Cancelada</option>
                   <option value="A" selected>Anulada</option>
                    <?php
				  }
				  ?>
                  </select>

			 </tr>

			  <tr>
                <td height="24" align="right">Fecha desde </td>
                <td colspan="2"><input name="txtfecemi" type="text" id="txtfecemi"  style="text-align:left" size="11" maxlength="10" onKeyPress="javascript:ue_validafecha();"  datepicker="true" readonly="true"></td>
              </tr>
              <tr align="left">
                <td height="23" align="right">Fecha hasta </td>
                <td colspan="2"><input name="txtfecemi2" type="text" id="txtfecemi2"  style="text-align:left" size="11" maxlength="10" onKeyPress="javascript:ue_validafecha();"  datepicker="true" readonly="true"></td>
              </tr>

			 <tr>
						<td height="3">&nbsp;</td>
			<td colspan="2"><p>
							<label>
							<?php
							 if ($ls_opcion=='detalles')
							   {
							   ?>
			                   <input name="opcion" type="radio" value="detalles"  checked="checked" onClick="actualizar_option()">
                 			   Detalles Facturas </label>
								 <label>
			                    <input name="opcion" type="radio" value="resumen"  onClick="actualizar_option()" >
			                   Resumen Facturas                 </label>
								<?php
								}
								else
								{
								?>
								 <input name="opcion" type="radio" value="detalles"  onClick="actualizar_option()">
			                   Detalles Facturas                 </label>
			                  <label>
			                    <input name="opcion" type="radio" value="resumen"  checked="checked" onClick="actualizar_option()">
			                   Resumen Facturas                  </label>

			<?php
								}
								?>
			                  <br>
			                </p>
			   </td>
			  </tr>


			  <tr>
                <td height="8">&nbsp;</td>
                <td colspan="2">&nbsp;</td>
              </tr>
            </table>
        </div></td>
      </tr>
    </table>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
</form>

<?php
/************************************************************************************************************************/
/******************************  BUSCAR *********************************************************************************/
/************************************************************************************************************************/

function sql_dinamica ($ls_tienda_desde,$ls_tienda_hasta,$alias_tabla,$ls_codtie)
{

$add_sql = '';
if ($ls_tienda_desde=='') {

$add_sql = "$alias_tabla.codtiend='$ls_codtie'";

}else {

$add_sql = "$alias_tabla.codtiend  BETWEEN '$ls_tienda_desde' AND '$ls_tienda_hasta'";

}

return $add_sql;
}

if($ls_operacion=="VER")
{
        $ls_operacion="";

	//print $ls_estatus."-".$ls_ordenarpor."-".$ls_operacion;
		$ls_suiche=false;
	if ($ls_ordenarpor!="Null")
	{
		if ($ls_fecemi=="%/%" AND $ls_fecemi2=="%/%")
		{

		$ls_suiche=true;



		if($ls_estatus=="Null")
			{



			$ls_sql="SELECT distinct f.numfac,f.codcli,f.fecemi,c.razcli,c.cedcli,f.monto,f.estfaccon,f.monto as montotot,f.codusu  ".
					" FROM sfc_factura f,sfc_cliente c,sfc_instpago i WHERE " .
					" f.codemp='".$ls_codemp."' AND  ".sql_dinamica ($ls_tienda_desde,$ls_tienda_hasta,'f',$ls_codtie)." AND f.codcli=c.codcli " .
					" AND f.codusu like '".$ls_codusu."' AND cedcli like '%".$ls_razcli."%'  AND substr(cast (f.fecemi as char(30)),0,11) like '".$ls_fecemi."' " .
					" AND i.numfac=f.numfac ".
					" GROUP BY f.codemp,f.numfac,f.fecemi,f.codcli,c.razcli,c.cedcli,f.monto,f.estfaccon,f.codusu ".
					" ORDER BY ".$ls_ordenarpor.",montotot ".$ls_orden.";";

			$ls_sql2="SELECT f.*,c.razcli,c.cedcli,f.monto as montotot,f.codusu FROM sfc_factura f,sfc_cliente c WHERE f.codemp='".$ls_codemp."' " .
					" AND ".sql_dinamica ($ls_tienda_desde,$ls_tienda_hasta,'f',$ls_codtie)." AND f.codcli=c.codcli AND f.codusu like '".$ls_codusu."'" .
					" AND cedcli like '%".$ls_razcli."%' AND substr(cast (f.fecemi as char(30)),0,11) like '".$ls_fecemi."'" .
					" AND f.estfaccon in ('C','A','P','N') and f.numfac not in (select numfac from sfc_instpago where " .
					" ".sql_dinamica ($ls_tienda_desde,$ls_tienda_hasta,'sfc_instpago',$ls_codtie).") ORDER BY ".$ls_ordenarpor.",montotot ".$ls_orden.";";

//print "1---------";


			}
			else
			{

			if($ls_estatus=="N")
			{

					$ls_sql="SELECT distinct f.numfac,f.codcli,f.fecemi,c.razcli,c.cedcli,f.monto,f.estfaccon,f.monto as montotot,f.codusu  FROM sfc_factura f,sfc_cliente c WHERE f.codemp='".$ls_codemp."'" .
								" AND ".sql_dinamica ($ls_tienda_desde,$ls_tienda_hasta,'f',$ls_codtie)." AND f.codcli=c.codcli " .
								" AND f.codusu like '".$ls_codusu."' AND cedcli like '%".$ls_razcli."%' AND substr(cast (f.codcli as char(30)),0,11) like '".$ls_fecemi."'" .
								" AND (f.estfaccon='P' OR  f.estfaccon='N') ".
								" GROUP BY f.codemp,f.numfac,f.fecemi,f.codcli,c.razcli,c.cedcli,f.monto,f.estfaccon,f.codusu ".
								" ORDER BY ".$ls_ordenarpor.",montotot ".$ls_orden.";";
						$ls_sql2="";

			//print "1.1";			
			//print $ls_sql;
			}

			else
			{

				if($ls_estatus=="C")

				{
					$ls_sql="SELECT distinct f.numfac,f.codcli,f.fecemi,c.razcli,c.cedcli,f.monto,f.estfaccon,f.monto as montotot,f.codusu  FROM sfc_factura f,sfc_cliente c,sfc_instpago i WHERE f.codemp='".$ls_codemp."'" .
								" AND ".sql_dinamica ($ls_tienda_desde,$ls_tienda_hasta,'f',$ls_codtie)."  AND f.codcli=c.codcli AND " .
								" f.codusu like '".$ls_codusu."' AND cedcli like '%".$ls_razcli."%' AND substr(cast (f.fecemi as char(30)),0,11) like '".$ls_fecemi."'" .
								" AND f.estfaccon='".$ls_estatus."'  AND i.numfac=f.numfac ".
								" GROUP BY f.codemp,f.numfac,f.fecemi,f.codcli,c.razcli,c.cedcli,f.monto,f.estfaccon,f.codusu ".
								" ORDER BY ".$ls_ordenarpor.",montotot ".$ls_orden.";";


					$ls_sql2="SELECT f.*,c.razcli,c.cedcli,f.monto as montotot,f.codusu FROM sfc_factura f,sfc_cliente c WHERE f.codemp='".$ls_codemp."' " .
					" AND ".sql_dinamica ($ls_tienda_desde,$ls_tienda_hasta,'f',$ls_codtie)." AND f.codcli=c.codcli AND f.codusu like '".$ls_codusu."'" .
					" AND cedcli like '%".$ls_razcli."%' AND substr(cast (f.fecemi as char(30)),0,11) like '".$ls_fecemi."'" .
					" AND f.estfaccon in ('C') and f.numfac not in (select numfac from sfc_instpago where " .
					" ".sql_dinamica ($ls_tienda_desde,$ls_tienda_hasta,'sfc_instpago',$ls_codtie).") ORDER BY ".$ls_ordenarpor.",montotot ".$ls_orden.";";



					//print $ls_codcli;
					
					//print "1.2";
					//print $ls_sql;
				}
				else
				{
					$ls_sql="SELECT distinct f.numfac,f.codcli,f.fecemi,c.razcli,c.cedcli,f.monto,f.estfaccon,f.monto as montotot,f.codusu  FROM sfc_factura f,sfc_cliente c,sfc_instpago i WHERE f.codemp='".$ls_codemp."'" .
								" AND ".sql_dinamica ($ls_tienda_desde,$ls_tienda_hasta,'f',$ls_codtie)."  AND f.codcli=c.codcli AND " .
								" f.codusu like '".$ls_codusu."' AND cedcli like '%".$ls_razcli."%' AND substr(cast (f.fecemi as char(30)),0,11) like '".$ls_fecemi."'" .
								" AND f.estfaccon='".$ls_estatus."'  AND i.numfac=f.numfac ".
								" GROUP BY f.codemp,f.numfac,f.fecemi,f.codcli,c.razcli,c.cedcli,f.monto,f.estfaccon,f.codusu ".
								" ORDER BY ".$ls_ordenarpor.",montotot ".$ls_orden.";";

					$ls_sql2="SELECT f.*,c.razcli,c.cedcli,f.monto as montotot,f.codusu FROM sfc_factura f,sfc_cliente c WHERE f.codemp='".$ls_codemp."'" .
								" AND ".sql_dinamica ($ls_tienda_desde,$ls_tienda_hasta,'f',$ls_codtie)." AND f.codcli=c.codcli " .
								" AND f.codusu like '".$ls_codusu."' AND cedcli like '%".$ls_razcli."%' AND substr(cast (f.fecemi as char(30)),0,11) like '".$ls_fecemi."'" .
								" AND f.estfaccon in ('A') and f.numfac not in (select numfac from sfc_instpago where " .
					" ".sql_dinamica ($ls_tienda_desde,$ls_tienda_hasta,'sfc_instpago',$ls_codtie).") ORDER BY ".$ls_ordenarpor.",montotot ".$ls_orden.";";
//print "1.3";


				}



			}

			}
//print "1-".$ls_sql."--".$ls_sql2."<br>";

        }
		elseif ($ls_fecemi<>"%/%" AND $ls_fecemi2<>"%/%")
		{
		  $ls_suiche=true;

			  if($ls_estatus=="Null")
			  {
			  	 $ls_sql="SELECT distinct f.numfac,f.codcli,f.fecemi,c.razcli,c.cedcli,f.monto,f.estfaccon,f.monto as montotot,f.codusu  FROM sfc_factura f,sfc_cliente c,sfc_instpago i WHERE " .
			   		"f.codemp='".$ls_codemp."' AND ".sql_dinamica ($ls_tienda_desde,$ls_tienda_hasta,'f',$ls_codtie)." AND f.codcli=c.codcli " .
			   		" AND f.codusu like '".$ls_codusu."' AND cedcli like '%".$ls_razcli."%' AND (substr(cast (f.fecemi as char(30)),0,11)>='".$ls_fecemi."'" .
			   		" AND substr(cast (f.fecemi as char(30)),0,11)<='".$ls_fecemi2."') AND i.numfac=f.numfac ".
					" GROUP BY f.codemp,f.numfac,f.fecemi,f.codcli,c.razcli,c.cedcli,f.monto,f.estfaccon,f.codusu ".
					" ORDER BY ".$ls_ordenarpor.",montotot ".$ls_orden.";";

			  	 $ls_sql2="SELECT f.*,c.razcli,c.cedcli,f.monto as montotot,f.codusu FROM sfc_factura f,sfc_cliente c WHERE f.codemp='".$ls_codemp."' " .
			   		" AND ".sql_dinamica ($ls_tienda_desde,$ls_tienda_hasta,'f',$ls_codtie)." AND f.codcli=c.codcli AND f.codusu like '".$ls_codusu."'" .
			   		" AND cedcli like '%".$ls_razcli."%' AND (substr(cast (f.fecemi as char(30)),0,11)>='".$ls_fecemi."' AND substr(cast (f.fecemi as char(30)),0,11)<='".$ls_fecemi2."')  " .
			   		" AND f.estfaccon in ('C','A','P','N') and f.numfac not in (select numfac from sfc_instpago where " .
					" ".sql_dinamica ($ls_tienda_desde,$ls_tienda_hasta,'sfc_instpago',$ls_codtie).") ORDER BY ".$ls_ordenarpor.",montotot ".$ls_orden.";";
			//print "2--";


			  }
			  else
			  {


			  		if($ls_estatus=="N")
					{

						$ls_sql="SELECT f.numfac,f.codcli,f.fecemi,c.razcli,c.cedcli,f.monto,f.estfaccon,f.monto as montotot,f.codusu  FROM sfc_factura f,sfc_cliente c WHERE f.codemp='".$ls_codemp."'" .
						" AND ".sql_dinamica ($ls_tienda_desde,$ls_tienda_hasta,'f',$ls_codtie)." AND f.codcli=c.codcli AND f.codusu like '".$ls_codusu."'" .
						" AND cedcli like '%".$ls_razcli."%' AND (f.estfaccon='P' OR  f.estfaccon='N') AND (substr(cast (f.fecemi as char(30)),0,11)>='".$ls_fecemi."'" .
						" AND substr(cast (f.fecemi as char(30)),0,11)<='".$ls_fecemi2."')  ".
						" GROUP BY f.codemp,f.numfac,f.fecemi,f.codcli,c.razcli,c.cedcli,f.monto,f.estfaccon,f.codusu ".						
						" ORDER BY ".$ls_ordenarpor.",montotot ".$ls_orden.";";

						$ls_sql2="";
				//print "2.1";

					}
					else
					{


						if($ls_estatus=="C")

						{
							$ls_sql="SELECT distinct f.numfac,f.codcli,f.fecemi,c.razcli,c.cedcli,f.monto,f.estfaccon,f.monto as montotot,f.codusu  FROM sfc_factura f,sfc_cliente c,sfc_instpago i WHERE f.codemp='".$ls_codemp."'" .
								" AND ".sql_dinamica ($ls_tienda_desde,$ls_tienda_hasta,'f',$ls_codtie)."  AND f.codcli=c.codcli AND " .
								" f.codusu like '".$ls_codusu."' AND cedcli like '%".$ls_razcli."%' AND (substr(cast (f.fecemi as char(30)),0,11)>='".$ls_fecemi."' AND substr(cast (f.fecemi as char(30)),0,11)<='".$ls_fecemi2."') " .
								"AND f.estfaccon='".$ls_estatus."'  AND i.numfac=f.numfac ".
								" GROUP BY f.codemp,f.numfac,f.fecemi,f.codcli,c.razcli,c.cedcli,f.monto,f.estfaccon,f.codusu ".	
								" ORDER BY ".$ls_ordenarpor.",montotot ".$ls_orden.";";


							$ls_sql2="SELECT f.*,c.razcli,c.cedcli,f.monto as montotot,f.codusu FROM sfc_factura f,sfc_cliente c WHERE f.codemp='".$ls_codemp."' " .
							" AND ".sql_dinamica ($ls_tienda_desde,$ls_tienda_hasta,'f',$ls_codtie)." AND f.codcli=c.codcli AND f.codusu like '".$ls_codusu."'" .
							" AND cedcli like '%".$ls_razcli."%' AND (substr(cast (f.fecemi as char(30)),0,11)>='".$ls_fecemi."' AND substr(cast (f.fecemi as char(30)),0,11)<='".$ls_fecemi2."') " .
							" AND f.estfaccon in ('C') and f.numfac not in (select numfac from sfc_instpago where " .
							" ".sql_dinamica ($ls_tienda_desde,$ls_tienda_hasta,'sfc_instpago',$ls_codtie).") ORDER BY ".$ls_ordenarpor.",montotot ".$ls_orden.";";



					//$ls_sql2="";
					//print "2.2";
					}
					else
					{
							$ls_sql="SELECT distinct f.numfac,f.codcli,f.fecemi,c.razcli,c.cedcli,f.monto,f.estfaccon,f.monto as montotot,f.codusu  FROM sfc_factura f,sfc_cliente c,sfc_instpago i WHERE f.codemp='".$ls_codemp."'" .
										" AND ".sql_dinamica ($ls_tienda_desde,$ls_tienda_hasta,'f',$ls_codtie)."  AND f.codcli=c.codcli AND " .
										" f.codusu like '".$ls_codusu."' AND cedcli like '%".$ls_razcli."%' AND (substr(cast (f.fecemi as char(30)),0,11)>='".$ls_fecemi."'" .
										" AND substr(cast (f.fecemi as char(30)),0,11)<='".$ls_fecemi2."') " .
										" AND f.estfaccon='".$ls_estatus."'  AND i.numfac=f.numfac ".
										" GROUP BY f.codemp,f.numfac,f.fecemi,f.codcli,c.razcli,c.cedcli,f.monto,f.estfaccon,f.codusu ".										
										" ORDER BY ".$ls_ordenarpor.",montotot ".$ls_orden.";";

							$ls_sql2="SELECT f.*,c.razcli,c.cedcli,f.monto as montotot,f.codusu FROM sfc_factura f,sfc_cliente c WHERE f.codemp='".$ls_codemp."'" .
										" AND ".sql_dinamica ($ls_tienda_desde,$ls_tienda_hasta,'f',$ls_codtie)." AND f.codcli=c.codcli " .
										" AND f.codusu like '".$ls_codusu."' AND cedcli like '%".$ls_razcli."%' AND (substr(cast (f.fecemi as char(30)),0,11)>='".$ls_fecemi."'" .
										" AND substr(cast (f.fecemi as char(30)),0,11)<='".$ls_fecemi2."') " .
										" AND f.estfaccon in ('A') and f.numfac not in (select numfac from sfc_instpago where " .
							" ".sql_dinamica ($ls_tienda_desde,$ls_tienda_hasta,'sfc_instpago',$ls_codtie).") ORDER BY ".$ls_ordenarpor.",montotot ".$ls_orden.";";
//print "2.3";

					}


				}


			  }
//print "2-".$ls_sql."--".$ls_sql2."<br>";


		}
        else
		{
		$io_msg->message("Debe introducir el rango completo de la fecha!");
		}
	 }//// FIN $ls_ordenarpor!="Null"

	else
	 {

	 	//print "PASEEEEEEEEEEEEE";
	 if ($ls_fecemi=="%/%" AND $ls_fecemi2=="%/%")
		{

		$ls_suiche=true;

			if($ls_estatus=="Null")
			{

				$ls_sql="SELECT distinct f.numfac,f.codcli,f.fecemi,c.razcli,c.cedcli,f.monto,f.estfaccon,f.monto as montotot,f.codusu  FROM sfc_factura f,sfc_cliente c,sfc_instpago i WHERE " .
					" f.codemp='".$ls_codemp."' AND  ".sql_dinamica ($ls_tienda_desde,$ls_tienda_hasta,'f',$ls_codtie)." AND f.codcli=c.codcli " .
					" AND f.codusu like '".$ls_codusu."' AND cedcli like '%".$ls_razcli."%' AND substr(cast (f.fecemi as char(30)),0,11) like '".$ls_fecemi."' " .
					" AND i.numfac=f.numfac ".
					" GROUP BY f.codemp,f.numfac,f.fecemi,f.codcli,c.razcli,c.cedcli,f.monto,f.estfaccon,f.codusu ".
					" ORDER BY f.numfac,montotot ASC;";

				$ls_sql2="SELECT f.*,c.razcli,c.cedcli,f.monto as montotot,f.codusu FROM sfc_factura f,sfc_cliente c WHERE f.codemp='".$ls_codemp."' " .
					" AND ".sql_dinamica ($ls_tienda_desde,$ls_tienda_hasta,'f',$ls_codtie)." AND f.codcli=c.codcli AND f.codusu like '".$ls_codusu."'" .
					" AND cedcli like '%".$ls_razcli."%' AND substr(cast (f.fecemi as char(30)),0,11) like '".$ls_fecemi."'" .
					" AND f.estfaccon in ('C','A','P','N') and f.numfac not in (select numfac from sfc_instpago where " .
					" ".sql_dinamica ($ls_tienda_desde,$ls_tienda_hasta,'sfc_instpago',$ls_codtie).") ORDER BY  f.numfac,montotot ASC;";

//print "3---";
			}
			else
			{

				if($ls_estatus=="N")
					{

						$ls_sql="SELECT f.numfac,f.codcli,f.fecemi,c.razcli,c.cedcli,f.monto,f.estfaccon,f.monto as montotot,f.codusu FROM sfc_factura f,sfc_cliente c WHERE f.codemp='".$ls_codemp."'" .
								" AND ".sql_dinamica ($ls_tienda_desde,$ls_tienda_hasta,'f',$ls_codtie)." AND f.codcli=c.codcli " .
								" AND f.codusu like '".$ls_codusu."' AND cedcli like '%".$ls_razcli."%' AND substr(cast (f.fecemi as char(30)),0,11) like '".$ls_fecemi."'" .
								" AND (f.estfaccon='P' OR  f.estfaccon='N') ".
								" GROUP BY f.codemp,f.numfac,f.fecemi,f.codcli,c.razcli,c.cedcli,f.monto,f.estfaccon,f.codusu ".
								" ORDER BY f.numfac,montotot ASC;";



						$ls_sql2="";


					//print "3.1-";

					}
					else
					{


						if($ls_estatus=="C")
						{
							$ls_sql="SELECT distinct f.numfac,f.codcli,f.fecemi,c.razcli,c.cedcli,f.monto,f.estfaccon,f.monto as montotot,f.codusu FROM sfc_factura f,sfc_cliente c,sfc_instpago i WHERE f.codemp='".$ls_codemp."'" .
								" AND ".sql_dinamica ($ls_tienda_desde,$ls_tienda_hasta,'f',$ls_codtie)."  AND f.codcli=c.codcli AND " .
								" f.codusu like '".$ls_codusu."' AND cedcli like '%".$ls_razcli."%' AND substr(cast (f.fecemi as char(30)),0,11) like '".$ls_fecemi."'" .
								" AND f.estfaccon='".$ls_estatus."' AND i.numfac=f.numfac ".
								" GROUP BY f.codemp,f.numfac,f.fecemi,f.codcli,c.razcli,c.cedcli,f.monto,f.estfaccon,f.codusu ".	
								" ORDER BY f.numfac,montotot ASC;";


							$ls_sql2="SELECT f.*,c.razcli,c.cedcli,f.monto as montotot,f.codusu FROM sfc_factura f,sfc_cliente c WHERE f.codemp='".$ls_codemp."' " .
								" AND ".sql_dinamica ($ls_tienda_desde,$ls_tienda_hasta,'f',$ls_codtie)." AND f.codcli=c.codcli AND f.codusu like '".$ls_codusu."'" .
								" AND cedcli like '%".$ls_razcli."%' AND substr(cast (f.fecemi as char(30)),0,11) like '".$ls_fecemi."'" .
								" AND f.estfaccon in ('C') and f.numfac not in (select numfac from sfc_instpago where " .
								" ".sql_dinamica ($ls_tienda_desde,$ls_tienda_hasta,'sfc_instpago',$ls_codtie).") ORDER BY f.numfac,montotot ASC;";

							//print "3.2";

						}
						else
						{
							$ls_sql="SELECT distinct f.numfac,f.codcli,f.fecemi,c.razcli,c.cedcli,f.monto,f.estfaccon,f.monto as montotot,f.codusu  FROM sfc_factura f,sfc_cliente c,sfc_instpago i WHERE f.codemp='".$ls_codemp."'" .
								" AND ".sql_dinamica ($ls_tienda_desde,$ls_tienda_hasta,'f',$ls_codtie)."  AND f.codcli=c.codcli AND " .
								" f.codusu like '".$ls_codusu."' AND cedcli like '%".$ls_razcli."%' AND substr(cast (f.fecemi as char(30)),0,11) like '".$ls_fecemi."'" .
								" AND f.estfaccon='".$ls_estatus."'  AND i.numfac=f.numfac ".
								" GROUP BY f.codemp,f.numfac,f.fecemi,f.codcli,c.razcli,c.cedcli,f.monto,f.estfaccon,f.codusu ".
								" ORDER BY f.numfac,montotot ASC;";

							$ls_sql2="SELECT f.*,c.razcli,c.cedcli,f.monto as montotot,f.codusu FROM sfc_factura f,sfc_cliente c WHERE f.codemp='".$ls_codemp."'" .
								" AND ".sql_dinamica ($ls_tienda_desde,$ls_tienda_hasta,'f',$ls_codtie)." AND f.codcli=c.codcli " .
								" AND f.codusu like '".$ls_codusu."' AND cedcli like '%".$ls_razcli."%' AND substr(cast (f.fecemi as char(30)),0,11) like '".$ls_fecemi."'" .
								" AND f.estfaccon in ('A') and f.numfac not in (select numfac from sfc_instpago where " .
								" ".sql_dinamica ($ls_tienda_desde,$ls_tienda_hasta,'sfc_instpago',$ls_codtie).") ORDER BY f.numfac,montotot ASC;";

							//print "3.3";
						}


					}


			}
//print "3-".$ls_sql."--".$ls_sql2."<br>";

        }

		elseif ($ls_fecemi<>"%/%" AND $ls_fecemi2<>"%/%")
		{
		  $ls_suiche=true;

			 if($ls_estatus=="Null")
			 {
			  //$ls_sql="SELECT f.*,c.razcli,c.cedcli,i.monto as montotot FROM sfc_factura f,sfc_cliente c,sfc_instpago i WHERE ".sql_dinamica ($ls_tienda_desde,$ls_tienda_desde,'f',$ls_codtie)." AND  f.codemp='".$ls_codemp."' AND f.codcli=c.codcli AND f.codusu like '".$ls_codusu."' AND cedcli like '%".$ls_razcli."%'  AND (f.fecemi>='".$ls_fecemi."' AND f.fecemi<='".$ls_fecemi2."') AND i.numfac=f.numfac;";

			 $ls_sql="SELECT distinct f.numfac,f.codcli,f.fecemi,c.razcli,c.cedcli,f.monto,f.estfaccon,f.monto as montotot,f.codusu  FROM sfc_factura f,sfc_cliente c,sfc_instpago i WHERE " .
			   		"f.codemp='".$ls_codemp."' AND ".sql_dinamica ($ls_tienda_desde,$ls_tienda_hasta,'f',$ls_codtie)." AND f.codcli=c.codcli " .
			   		" AND f.codusu like '".$ls_codusu."' AND cedcli like '%".$ls_razcli."%' AND (substr(cast (f.fecemi as char(30)),0,11)>='".$ls_fecemi."'" .
			   		" AND substr(cast (f.fecemi as char(30)),0,11)<='".$ls_fecemi2."') AND i.numfac=f.numfac ".
					" GROUP BY f.codemp,f.numfac,f.fecemi,f.codcli,c.razcli,c.cedcli,f.monto,f.estfaccon,f.codusu ".
					" ORDER BY f.numfac,montotot ASC;";

			  	 $ls_sql2="SELECT f.*,c.razcli,c.cedcli,f.monto as montotot,f.codusu FROM sfc_factura f,sfc_cliente c WHERE f.codemp='".$ls_codemp."' " .
			   		" AND ".sql_dinamica ($ls_tienda_desde,$ls_tienda_hasta,'f',$ls_codtie)." AND f.codcli=c.codcli AND f.codusu like '".$ls_codusu."'" .
			   		" AND cedcli like '%".$ls_razcli."%' AND (substr(cast (f.fecemi as char(30)),0,11)>='".$ls_fecemi."' AND substr(cast (f.fecemi as char(30)),0,11)<='".$ls_fecemi2."')  " .
			   		" AND f.estfaccon in ('C','A','P','N') and f.numfac not in (select numfac from sfc_instpago where " .
					" ".sql_dinamica ($ls_tienda_desde,$ls_tienda_hasta,'sfc_instpago',$ls_codtie).") ORDER BY f.numfac,montotot ASC;";


			// print "4---";

			 }
			 else
			 {
			  //$ls_sql="SELECT f.*,c.razcli,c.cedcli,i.monto as montotot FROM sfc_factura f,sfc_cliente c,sfc_instpago i WHERE ".sql_dinamica ($ls_tienda_desde,$ls_tienda_desde,'f',$ls_codtie)." AND  f.codemp='".$ls_codemp."' AND f.codcli=c.codcli AND f.codusu like '".$ls_codusu."' AND cedcli like '%".$ls_razcli."%' AND f.estfaccon='".$ls_estatus."' AND (f.fecemi>='".$ls_fecemi."' AND f.fecemi<='".$ls_fecemi2."') AND i.numfac=f.numfac;";

			 	if($ls_estatus=="N")
					{

						$ls_sql="SELECT f.numfac,f.codcli,f.fecemi,c.razcli,c.cedcli,f.monto,f.estfaccon,f.monto as montotot,f.codusu  FROM sfc_factura f,sfc_cliente c WHERE f.codemp='".$ls_codemp."'" .
						" AND ".sql_dinamica ($ls_tienda_desde,$ls_tienda_hasta,'f',$ls_codtie)." AND f.codcli=c.codcli AND f.codusu like '".$ls_codusu."'" .
						" AND cedcli like '%".$ls_razcli."%' AND (f.estfaccon='P' OR  f.estfaccon='N') AND (substr(cast (f.fecemi as char(30)),0,11)>='".$ls_fecemi."'" .
						" AND substr(cast (f.fecemi as char(30)),0,11)<='".$ls_fecemi2."') ".
						" GROUP BY f.codemp,f.numfac,f.fecemi,f.codcli,c.razcli,c.cedcli,f.monto,f.estfaccon,f.codusu ".	
						" ORDER BY f.numfac,montotot ASC;";

						$ls_sql2="";
				//print "4.1";

					}

				else
					{

						if($ls_estatus=="C")

						{
							$ls_sql="SELECT distinct f.numfac,f.codcli,f.fecemi,c.razcli,c.cedcli,f.monto,f.estfaccon,f.monto as montotot,f.codusu  FROM sfc_factura f,sfc_cliente c,sfc_instpago i WHERE f.codemp='".$ls_codemp."'" .
								" AND ".sql_dinamica ($ls_tienda_desde,$ls_tienda_hasta,'f',$ls_codtie)."  AND f.codcli=c.codcli AND " .
								" f.codusu like '".$ls_codusu."' AND cedcli like '%".$ls_razcli."%' AND (substr(cast (f.fecemi as char(30)),0,11)>='".$ls_fecemi."' AND substr(cast (f.fecemi as char(30)),0,11)<='".$ls_fecemi2."') " .
								" AND f.estfaccon='".$ls_estatus."'  AND i.numfac=f.numfac ".
								" GROUP BY f.codemp,f.numfac,f.fecemi,f.codcli,c.razcli,c.cedcli,f.monto,f.estfaccon,f.codusu ".
								" ORDER BY f.numfac,montotot ASC;";


							$ls_sql2="SELECT f.*,c.razcli,c.cedcli,f.monto as montotot,f.codusu FROM sfc_factura f,sfc_cliente c WHERE f.codemp='".$ls_codemp."' " .
							" AND ".sql_dinamica ($ls_tienda_desde,$ls_tienda_hasta,'f',$ls_codtie)." AND f.codcli=c.codcli AND f.codusu like '".$ls_codusu."'" .
							" AND cedcli like '%".$ls_razcli."%' AND (substr(cast (f.fecemi as char(30)),0,11)>='".$ls_fecemi."' AND substr(cast (f.fecemi as char(30)),0,11)<='".$ls_fecemi2."') " .
							" AND f.estfaccon in ('C') and f.numfac not in (select numfac from sfc_instpago where " .
							" ".sql_dinamica ($ls_tienda_desde,$ls_tienda_hasta,'sfc_instpago',$ls_codtie).") ORDER BY f.numfac,montotot ASC;";



					//$ls_sql2="";
					//print "4.2";
					}
					else
					{
							$ls_sql="SELECT distinct f.numfac,f.codcli,f.fecemi,c.razcli,c.cedcli,f.monto,f.estfaccon,f.monto as montotot,f.codusu  FROM sfc_factura f,sfc_cliente c,sfc_instpago i WHERE f.codemp='".$ls_codemp."'" .
										" AND ".sql_dinamica ($ls_tienda_desde,$ls_tienda_hasta,'f',$ls_codtie)."  AND f.codcli=c.codcli AND " .
										" f.codusu like '".$ls_codusu."' AND cedcli like '%".$ls_razcli."%' AND (substr(cast (f.fecemi as char(30)),0,11)>='".$ls_fecemi."'" .
										" AND substr(cast (f.fecemi as char(30)),0,11)<='".$ls_fecemi2."') " .
										" AND f.estfaccon='".$ls_estatus."'  AND i.numfac=f.numfac ".
										" GROUP BY f.codemp,f.numfac,f.fecemi,f.codcli,c.razcli,c.cedcli,f.monto,f.estfaccon,f.codusu ".										
										" ORDER BY f.numfac,montotot ASC;";

							$ls_sql2="SELECT f.*,c.razcli,c.cedcli,f.monto as montotot,f.codusu FROM sfc_factura f,sfc_cliente c WHERE f.codemp='".$ls_codemp."'" .
										" AND ".sql_dinamica ($ls_tienda_desde,$ls_tienda_hasta,'f',$ls_codtie)." AND f.codcli=c.codcli " .
										" AND f.codusu like '".$ls_codusu."' AND cedcli like '%".$ls_razcli."%' AND (substr(cast (f.fecemi as char(30)),0,11)>='".$ls_fecemi."'" .
										" AND substr(cast (f.fecemi as char(30)),0,11)<='".$ls_fecemi2."') " .
										" AND f.estfaccon in ('A') and f.numfac not in (select numfac from sfc_instpago where " .
							" ".sql_dinamica ($ls_tienda_desde,$ls_tienda_hasta,'sfc_instpago',$ls_codtie).") ORDER BY f.numfac,montotot ASC;";
					//print "4.3";

					}

				}

			 }
//print "4-".$ls_sql."--".$ls_sql2."<br>";
		}
        else
		{
		$io_msg->message("Debe introducir el rango completo de la fecha!");
		}

	 }///$ls_ordenarpor=="Null"
	$ls_ordenarpor="Null";
    ?>

     <script language="JavaScript">
   	 	var ls_sql="<?php print $ls_sql; ?>";
   	 	var ls_sql2="<?php print $ls_sql2; ?>";
		var ls_fecemi="<?php print $ls_fecemi; ?>";
		var ls_fecemi2="<?php print $ls_fecemi2; ?>";
		var ls_opcion="<?php print $ls_opcion; ?>";
		pagina="reportes/sigesp_sfc_rep_factura.php?sql="+ls_sql+"&fecemi2="+ls_fecemi2+"&fecemi="+ls_fecemi+"&opcion="+ls_opcion+"&sql2="+ls_sql2;
	  	popupWin(pagina,"catalogo",580,700);
     </script>
    <?

	}



if($ls_operacion=="VER2")
{

        $ls_operacion="";

	//print $ls_estatus."-".$ls_ordenarpor."-".$ls_operacion;
		$ls_suiche=false;
	if ($ls_ordenarpor!="Null")
	{
		if ($ls_fecemi=="%/%" AND $ls_fecemi2=="%/%")
		{

		$ls_suiche=true;

		if($ls_estatus=="Null")
			{
//1


			$ls_sql="SELECT distinct f.numfac,f.codcli,f.fecemi,c.razcli,c.cedcli,f.monto,f.estfaccon,f.monto as montotot,f.codusu  FROM sfc_factura f,sfc_cliente c,sfc_instpago i WHERE " .
					" f.codemp='".$ls_codemp."' AND  ".sql_dinamica ($ls_tienda_desde,$ls_tienda_hasta,'f',$ls_codtie)." AND f.codcli=c.codcli " .
					" AND f.codusu like '".$ls_codusu."' AND cedcli like '%".$ls_razcli."%'  AND substr(cast (f.fecemi as char(30)),0,11) like '".$ls_fecemi."' " .
					" AND i.numfac=f.numfac ".
					" GROUP BY f.codemp,f.numfac,f.fecemi,f.codcli,c.razcli,c.cedcli,f.monto,f.estfaccon,f.codusu ".
					" ORDER BY ".$ls_ordenarpor.",montotot ".$ls_orden.";";

			$ls_sql2="SELECT f.*,c.razcli,c.cedcli,f.monto as montotot,f.codusu FROM sfc_factura f,sfc_cliente c WHERE f.codemp='".$ls_codemp."' " .
					" AND ".sql_dinamica ($ls_tienda_desde,$ls_tienda_hasta,'f',$ls_codtie)." AND f.codcli=c.codcli AND f.codusu like '".$ls_codusu."'" .
					" AND cedcli like '%".$ls_razcli."%' AND substr(cast (f.fecemi as char(30)),0,11) like '".$ls_fecemi."'" .
					" AND f.estfaccon in ('C','A','P','N') and f.numfac not in (select numfac from sfc_instpago where " .
					" ".sql_dinamica ($ls_tienda_desde,$ls_tienda_hasta,'sfc_instpago',$ls_codtie).") ORDER BY ".$ls_ordenarpor.",montotot ".$ls_orden.";";

//print "1---------";


			}
			else
			{

			if($ls_estatus=="N")
			{
//1.1
					$ls_sql="SELECT f.numfac,f.codcli,f.fecemi,c.razcli,c.cedcli,f.monto,f.estfaccon,f.monto as montotot,f.codusu  FROM sfc_factura f,sfc_cliente c WHERE f.codemp='".$ls_codemp."'" .
								" AND ".sql_dinamica ($ls_tienda_desde,$ls_tienda_hasta,'f',$ls_codtie)." AND f.codcli=c.codcli " .
								" AND f.codusu like '".$ls_codusu."' AND cedcli like '%".$ls_razcli."%' AND substr(cast (f.fecemi as char(30)),0,11) like '".$ls_fecemi."'" .
								" AND (f.estfaccon='P' OR  f.estfaccon='N') ".
								" GROUP BY f.codemp,f.numfac,f.fecemi,f.codcli,c.razcli,c.cedcli,f.monto,f.estfaccon,f.codusu ".
								" ORDER BY ".$ls_ordenarpor.",montotot ".$ls_orden.";";



						$ls_sql2="";

			//print "1.1";
			}

			else
			{
//1.2
				if($ls_estatus=="C")

				{
					$ls_sql="SELECT distinct f.numfac,f.codcli,f.fecemi,c.razcli,c.cedcli,f.monto,f.estfaccon,f.monto as montotot,f.codusu  FROM sfc_factura f,sfc_cliente c,sfc_instpago i WHERE f.codemp='".$ls_codemp."'" .
								" AND ".sql_dinamica ($ls_tienda_desde,$ls_tienda_hasta,'f',$ls_codtie)."  AND f.codcli=c.codcli AND " .
								" f.codusu like '".$ls_codusu."' AND cedcli like '%".$ls_razcli."%' AND substr(cast (f.fecemi as char(30)),0,11) like '".$ls_fecemi."'" .
								" AND f.estfaccon='".$ls_estatus."'  AND i.numfac=f.numfac ".
								" GROUP BY f.codemp,f.numfac,f.fecemi,f.codcli,c.razcli,c.cedcli,f.monto,f.estfaccon,f.codusu ".	
								" ORDER BY ".$ls_ordenarpor.",montotot ".$ls_orden.";";


					$ls_sql2="SELECT f.*,c.razcli,c.cedcli,f.monto as montotot,f.codusu FROM sfc_factura f,sfc_cliente c WHERE f.codemp='".$ls_codemp."' " .
					" AND ".sql_dinamica ($ls_tienda_desde,$ls_tienda_hasta,'f',$ls_codtie)." AND f.codcli=c.codcli AND f.codusu like '".$ls_codusu."'" .
					" AND cedcli like '%".$ls_razcli."%' AND substr(cast (f.fecemi as char(30)),0,11) like '".$ls_fecemi."'" .
					" AND f.estfaccon in ('C') and f.numfac not in (select numfac from sfc_instpago where " .
					" ".sql_dinamica ($ls_tienda_desde,$ls_tienda_desde,'sfc_instpago',$ls_codtie).") ORDER BY ".$ls_ordenarpor.",montotot ".$ls_orden.";";



					//$ls_sql2="";
					//print "1.2";
				}
				else
				{
					$ls_sql="SELECT distinct f.numfac,f.codcli,f.fecemi,c.razcli,c.cedcli,f.monto,f.estfaccon,f.monto as montotot,f.codusu  FROM sfc_factura f,sfc_cliente c,sfc_instpago i WHERE f.codemp='".$ls_codemp."'" .
								" AND ".sql_dinamica ($ls_tienda_desde,$ls_tienda_hasta,'f',$ls_codtie)."  AND f.codcli=c.codcli AND " .
								" f.codusu like '".$ls_codusu."' AND cedcli like '%".$ls_razcli."%' AND substr(cast (f.fecemi as char(30)),0,11) like '".$ls_fecemi."'" .
								" AND f.estfaccon='".$ls_estatus."'  AND i.numfac=f.numfac ".
								" GROUP BY f.codemp,f.numfac,f.fecemi,f.codcli,c.razcli,c.cedcli,f.monto,f.estfaccon,f.codusu ".
								" ORDER BY ".$ls_ordenarpor.",montotot ".$ls_orden.";";

					$ls_sql2="SELECT f.*,c.razcli,c.cedcli,f.monto as montotot,f.codusu FROM sfc_factura f,sfc_cliente c WHERE f.codemp='".$ls_codemp."'" .
								" AND ".sql_dinamica ($ls_tienda_desde,$ls_tienda_hasta,'f',$ls_codtie)." AND f.codcli=c.codcli " .
								" AND f.codusu like '".$ls_codusu."' AND cedcli like '%".$ls_razcli."%' AND substr(cast (f.fecemi as char(30)),0,11) like '".$ls_fecemi."'" .
								" AND f.estfaccon in ('A') and f.numfac not in (select numfac from sfc_instpago where " .
					" ".sql_dinamica ($ls_tienda_desde,$ls_tienda_desde,'sfc_instpago',$ls_codtie).") ORDER BY ".$ls_ordenarpor.",montotot ".$ls_orden.";";
//print "1.3";


				}



			}

			}
//print "1-".$ls_sql."--".$ls_sql2."<br>";

        }
		elseif ($ls_fecemi<>"%/%" AND $ls_fecemi2<>"%/%")
		{
		  $ls_suiche=true;

			  if($ls_estatus=="Null")
			  {
			  	 $ls_sql="SELECT distinct f.numfac,f.codcli,f.fecemi,c.razcli,c.cedcli,f.monto,f.estfaccon,f.monto as montotot,f.codusu  FROM sfc_factura f,sfc_cliente c,sfc_instpago i WHERE " .
			   		"f.codemp='".$ls_codemp."' AND ".sql_dinamica ($ls_tienda_desde,$ls_tienda_hasta,'f',$ls_codtie)." AND f.codcli=c.codcli " .
			   		" AND f.codusu like '".$ls_codusu."' AND cedcli like '%".$ls_razcli."%' AND (substr(cast (f.fecemi as char(30)),0,11)>='".$ls_fecemi."'" .
			   		" AND substr(cast (f.fecemi as char(30)),0,11)<='".$ls_fecemi2."') AND i.numfac=f.numfac ".
					" GROUP BY f.codemp,f.numfac,f.fecemi,f.codcli,c.razcli,c.cedcli,f.monto,f.estfaccon,f.codusu ".
					" ORDER BY ".$ls_ordenarpor.",montotot ".$ls_orden.";";

			  	 $ls_sql2="SELECT f.*,c.razcli,c.cedcli,f.monto as montotot,f.codusu FROM sfc_factura f,sfc_cliente c WHERE f.codemp='".$ls_codemp."' " .
			   		" AND ".sql_dinamica ($ls_tienda_desde,$ls_tienda_hasta,'f',$ls_codtie)." AND f.codcli=c.codcli AND f.codusu like '".$ls_codusu."'" .
			   		" AND cedcli like '%".$ls_razcli."%' AND (substr(cast (f.fecemi as char(30)),0,11)>='".$ls_fecemi."' AND substr(cast (f.fecemi as char(30)),0,11)<='".$ls_fecemi2."')  " .
			   		" AND f.estfaccon in ('C','A','P','N') and f.numfac not in (select numfac from sfc_instpago where " .
					" ".sql_dinamica ($ls_tienda_desde,$ls_tienda_hasta,'sfc_instpago',$ls_codtie).") ORDER BY ".$ls_ordenarpor.",montotot ".$ls_orden.";";

			  }
			  else
			  {


			  		if($ls_estatus=="N")
					{

						$ls_sql="SELECT distinct f.numfac,f.codcli,f.fecemi,c.razcli,c.cedcli,f.monto,f.estfaccon,f.monto as montotot,f.codusu  FROM sfc_factura f,sfc_cliente c WHERE f.codemp='".$ls_codemp."'" .
						" AND ".sql_dinamica ($ls_tienda_desde,$ls_tienda_hasta,'f',$ls_codtie)." AND f.codcli=c.codcli AND f.codusu like '".$ls_codusu."'" .
						" AND cedcli like '%".$ls_razcli."%' AND (f.estfaccon='P' OR  f.estfaccon='N') AND (substr(cast (f.fecemi as char(30)),0,11)>='".$ls_fecemi."'" .
						" AND substr(cast (f.fecemi as char(30)),0,11)<='".$ls_fecemi2."')  ".
						" GROUP BY f.codemp,f.numfac,f.fecemi,f.codcli,c.razcli,c.cedcli,f.monto,f.estfaccon,f.codusu ".
						" ORDER BY ".$ls_ordenarpor.",montotot ".$ls_orden.";";

						$ls_sql2="";
					}
					else
					{


						if($ls_estatus=="C")

						{
							$ls_sql="SELECT distinct f.numfac,f.codcli,f.fecemi,c.razcli,c.cedcli,f.monto,f.estfaccon,f.monto as montotot,f.codusu  FROM sfc_factura f,sfc_cliente c,sfc_instpago i WHERE f.codemp='".$ls_codemp."'" .
								" AND ".sql_dinamica ($ls_tienda_desde,$ls_tienda_hasta,'f',$ls_codtie)."  AND f.codcli=c.codcli AND " .
								" f.codusu like '".$ls_codusu."' AND cedcli like '%".$ls_razcli."%' AND (substr(cast (f.fecemi as char(30)),0,11)>='".$ls_fecemi."' AND substr(cast (f.fecemi as char(30)),0,11)<='".$ls_fecemi2."') " .
								"AND f.estfaccon='".$ls_estatus."'  AND i.numfac=f.numfac ".
								" GROUP BY f.codemp,f.numfac,f.fecemi,f.codcli,c.razcli,c.cedcli,f.monto,f.estfaccon,f.codusu ".
								" ORDER BY ".$ls_ordenarpor.",montotot ".$ls_orden.";";


							$ls_sql2="SELECT f.*,c.razcli,c.cedcli,f.monto as montotot,f.codusu FROM sfc_factura f,sfc_cliente c WHERE f.codemp='".$ls_codemp."' " .
							" AND ".sql_dinamica ($ls_tienda_desde,$ls_tienda_hasta,'f',$ls_codtie)." AND f.codcli=c.codcli AND f.codusu like '".$ls_codusu."'" .
							" AND cedcli like '%".$ls_razcli."%' AND (substr(cast (f.fecemi as char(30)),0,11)>='".$ls_fecemi."' AND substr(cast (f.fecemi as char(30)),0,11)<='".$ls_fecemi2."') " .
							" AND f.estfaccon in ('C') and f.numfac not in (select numfac from sfc_instpago where " .
							" ".sql_dinamica ($ls_tienda_desde,$ls_tienda_hasta,'sfc_instpago',$ls_codtie).") ORDER BY ".$ls_ordenarpor.",montotot ".$ls_orden.";";



					//$ls_sql2="";
					}
					else
					{
							$ls_sql="SELECT distinct f.numfac,f.codcli,f.fecemi,c.razcli,c.cedcli,f.monto,f.estfaccon,f.monto as montotot,f.codusu  FROM sfc_factura f,sfc_cliente c,sfc_instpago i WHERE f.codemp='".$ls_codemp."'" .
										" AND ".sql_dinamica ($ls_tienda_desde,$ls_tienda_hasta,'f',$ls_codtie)."  AND f.codcli=c.codcli AND " .
										" f.codusu like '".$ls_codusu."' AND cedcli like '%".$ls_razcli."%' AND (substr(cast (f.fecemi as char(30)),0,11)>='".$ls_fecemi."'" .
										" AND substr(cast (f.fecemi as char(30)),0,11)<='".$ls_fecemi2."') " .
										" AND f.estfaccon='".$ls_estatus."'  AND i.numfac=f.numfac ".
										" GROUP BY f.codemp,f.numfac,f.fecemi,f.codcli,c.razcli,c.cedcli,f.monto,f.estfaccon,f.codusu ".										
										" ORDER BY ".$ls_ordenarpor.",montotot ".$ls_orden.";";

							$ls_sql2="SELECT f.*,c.razcli,c.cedcli,f.monto as montotot,f.codusu FROM sfc_factura f,sfc_cliente c WHERE f.codemp='".$ls_codemp."'" .
										" AND ".sql_dinamica ($ls_tienda_desde,$ls_tienda_hasta,'f',$ls_codtie)." AND f.codcli=c.codcli " .
										" AND f.codusu like '".$ls_codusu."' AND cedcli like '%".$ls_razcli."%' AND (substr(cast (f.fecemi as char(30)),0,11)>='".$ls_fecemi."'" .
										" AND substr(cast (f.fecemi as char(30)),0,11)<='".$ls_fecemi2."') " .
										" AND f.estfaccon in ('A') and f.numfac not in (select numfac from sfc_instpago where " .
							" ".sql_dinamica ($ls_tienda_desde,$ls_tienda_hasta,'sfc_instpago',$ls_codtie).") ORDER BY ".$ls_ordenarpor.",montotot ".$ls_orden.";";
//print "2.3";

					}


				}


			  }
//print "2-".$ls_sql."--".$ls_sql2."<br>";


		}
        else
		{
		$io_msg->message("Debe introducir el rango completo de la fecha!");
		}
	 }//// FIN $ls_ordenarpor!="Null"

	else
	 {

	 	//print "PASEEEEEEEEEEEEE";
	 if ($ls_fecemi=="%/%" AND $ls_fecemi2=="%/%")
		{

		$ls_suiche=true;

			if($ls_estatus=="Null")
			{

				$ls_sql="SELECT distinct f.numfac,f.codcli,f.fecemi,c.razcli,c.cedcli,f.monto,f.estfaccon,f.monto as montotot,f.codusu  FROM sfc_factura f,sfc_cliente c,sfc_instpago i WHERE " .
					" f.codemp='".$ls_codemp."' AND  ".sql_dinamica ($ls_tienda_desde,$ls_tienda_hasta,'f',$ls_codtie)." AND f.codcli=c.codcli " .
					" AND f.codusu like '".$ls_codusu."' AND cedcli like '%".$ls_razcli."%' AND substr(cast (f.fecemi as char(30)),0,11) like '".$ls_fecemi."' " .
					" AND i.numfac=f.numfac ".
					" GROUP BY f.codemp,f.numfac,f.fecemi,f.codcli,c.razcli,c.cedcli,f.monto,f.estfaccon,f.codusu ".
					" ORDER BY f.numfac,montotot ASC;";

				$ls_sql2="SELECT f.*,c.razcli,c.cedcli,f.monto as montotot,f.codusu FROM sfc_factura f,sfc_cliente c WHERE f.codemp='".$ls_codemp."' " .
					" AND ".sql_dinamica ($ls_tienda_desde,$ls_tienda_hasta,'f',$ls_codtie)." AND f.codcli=c.codcli AND f.codusu like '".$ls_codusu."'" .
					" AND cedcli like '%".$ls_razcli."%' AND substr(cast (f.fecemi as char(30)),0,11) like '".$ls_fecemi."'" .
					" AND f.estfaccon in ('C','A','P','N') and f.numfac not in (select numfac from sfc_instpago where " .
					" ".sql_dinamica ($ls_tienda_desde,$ls_tienda_hasta,'sfc_instpago',$ls_codtie).") ORDER BY  f.numfac,montotot ASC;";

//print "3---";
			}
			else
			{

				if($ls_estatus=="N")
					{

						$ls_sql="SELECT f.numfac,f.codcli,f.fecemi,c.razcli,c.cedcli,f.monto,f.estfaccon,f.monto as montotot,f.codusu  FROM sfc_factura f,sfc_cliente c WHERE f.codemp='".$ls_codemp."'" .
								" AND ".sql_dinamica ($ls_tienda_desde,$ls_tienda_hasta,'f',$ls_codtie)." AND f.codcli=c.codcli " .
								" AND f.codusu like '".$ls_codusu."' AND cedcli like '%".$ls_razcli."%' AND substr(cast (f.fecemi as char(30)),0,11) like '".$ls_fecemi."'" .
								" AND (f.estfaccon='P' OR  f.estfaccon='N') ".
								" GROUP BY f.codemp,f.numfac,f.fecemi,f.codcli,c.razcli,c.cedcli,f.monto,f.estfaccon,f.codusu ".
								" ORDER BY f.numfac,montotot ASC;";



						$ls_sql2="";


					//print "3.1-";

					}
					else
					{


						if($ls_estatus=="C")
						{
							$ls_sql="SELECT distinct f.numfac,f.codcli,f.fecemi,c.razcli,c.cedcli,f.monto,f.estfaccon,f.monto as montotot,f.codusu  FROM sfc_factura f,sfc_cliente c,sfc_instpago i WHERE f.codemp='".$ls_codemp."'" .
								" AND ".sql_dinamica ($ls_tienda_desde,$ls_tienda_hasta,'f',$ls_codtie)."  AND f.codcli=c.codcli AND " .
								" f.codusu like '".$ls_codusu."' AND cedcli like '%".$ls_razcli."%' AND substr(cast (f.fecemi as char(30)),0,11) like '".$ls_fecemi."'" .
								" AND f.estfaccon='".$ls_estatus."' AND i.numfac=f.numfac ".
								" GROUP BY f.codemp,f.numfac,f.fecemi,f.codcli,c.razcli,c.cedcli,f.monto,f.estfaccon,f.codusu ".
								" ORDER BY f.numfac,montotot ASC;";


							$ls_sql2="SELECT f.*,c.razcli,c.cedcli,f.monto as montotot,f.codusu FROM sfc_factura f,sfc_cliente c WHERE f.codemp='".$ls_codemp."' " .
								" AND ".sql_dinamica ($ls_tienda_desde,$ls_tienda_hasta,'f',$ls_codtie)." AND f.codcli=c.codcli AND f.codusu like '".$ls_codusu."'" .
								" AND cedcli like '%".$ls_razcli."%' AND substr(cast (f.fecemi as char(30)),0,11) like '".$ls_fecemi."'" .
								" AND f.estfaccon in ('C') and f.numfac not in (select numfac from sfc_instpago where " .
								" ".sql_dinamica ($ls_tienda_desde,$ls_tienda_hasta,'sfc_instpago',$ls_codtie).") ORDER BY f.numfac,montotot ASC;";

							//print "3.2";

						}
						else
						{
							$ls_sql="SELECT distinct f.numfac,f.codcli,f.fecemi,c.razcli,c.cedcli,f.monto,f.estfaccon,f.monto as montotot,f.codusu  FROM sfc_factura f,sfc_cliente c,sfc_instpago i WHERE f.codemp='".$ls_codemp."'" .
								" AND ".sql_dinamica ($ls_tienda_desde,$ls_tienda_hasta,'f',$ls_codtie)."  AND f.codcli=c.codcli AND " .
								" f.codusu like '".$ls_codusu."' AND cedcli like '%".$ls_razcli."%' AND substr(cast (f.fecemi as char(30)),0,11) like '".$ls_fecemi."'" .
								" AND f.estfaccon='".$ls_estatus."'  AND i.numfac=f.numfac ".
								" GROUP BY f.codemp,f.numfac,f.fecemi,f.codcli,c.razcli,c.cedcli,f.monto,f.estfaccon,f.codusu ".
								" ORDER BY f.numfac,montotot ASC;";

							$ls_sql2="SELECT f.*,c.razcli,c.cedcli,f.monto as montotot,f.codusu FROM sfc_factura f,sfc_cliente c WHERE f.codemp='".$ls_codemp."'" .
								" AND ".sql_dinamica ($ls_tienda_desde,$ls_tienda_hasta,'f',$ls_codtie)." AND f.codcli=c.codcli " .
								" AND f.codusu like '".$ls_codusu."' AND cedcli like '%".$ls_razcli."%' AND substr(cast (f.fecemi as char(30)),0,11) like '".$ls_fecemi."'" .
								" AND f.estfaccon in ('A') and f.numfac not in (select numfac from sfc_instpago where " .
								" ".sql_dinamica ($ls_tienda_desde,$ls_tienda_hasta,'sfc_instpago',$ls_codtie).") ORDER BY f.numfac,montotot ASC;";

							//print "3.3";
						}


					}


			}
//print "3-".$ls_sql."--".$ls_sql2."<br>";

        }

		elseif ($ls_fecemi<>"%/%" AND $ls_fecemi2<>"%/%")
		{
		  $ls_suiche=true;

			 if($ls_estatus=="Null")
			 {
			  //$ls_sql="SELECT f.*,c.razcli,c.cedcli,i.monto as montotot FROM sfc_factura f,sfc_cliente c,sfc_instpago i WHERE ".sql_dinamica ($ls_tienda_desde,$ls_tienda_desde,'f',$ls_codtie)." AND  f.codemp='".$ls_codemp."' AND f.codcli=c.codcli AND f.codusu like '".$ls_codusu."' AND cedcli like '%".$ls_razcli."%'  AND (f.fecemi>='".$ls_fecemi."' AND f.fecemi<='".$ls_fecemi2."') AND i.numfac=f.numfac;";

			 $ls_sql="SELECT distinct f.numfac,f.codcli,f.fecemi,c.razcli,c.cedcli,f.monto,f.estfaccon,f.monto as montotot,f.codusu  FROM sfc_factura f,sfc_cliente c,sfc_instpago i WHERE " .
			   		"f.codemp='".$ls_codemp."' AND ".sql_dinamica ($ls_tienda_desde,$ls_tienda_hasta,'f',$ls_codtie)." AND f.codcli=c.codcli " .
			   		" AND f.codusu like '".$ls_codusu."' AND cedcli like '%".$ls_razcli."%' AND (substr(cast (f.fecemi as char(30)),0,11)>='".$ls_fecemi."'" .
			   		" AND substr(cast (f.fecemi as char(30)),0,11)<='".$ls_fecemi2."') AND i.numfac=f.numfac ".
					" GROUP BY f.codemp,f.numfac,f.fecemi,f.codcli,c.razcli,c.cedcli,f.monto,f.estfaccon,f.codusu ".
					" ORDER BY f.numfac,montotot ASC;";

			  	 $ls_sql2="SELECT f.*,c.razcli,c.cedcli,f.monto as montotot,f.codusu FROM sfc_factura f,sfc_cliente c WHERE f.codemp='".$ls_codemp."' " .
			   		" AND ".sql_dinamica ($ls_tienda_desde,$ls_tienda_hasta,'f',$ls_codtie)." AND f.codcli=c.codcli AND f.codusu like '".$ls_codusu."'" .
			   		" AND cedcli like '%".$ls_razcli."%' AND (substr(cast (f.fecemi as char(30)),0,11)>='".$ls_fecemi."' AND substr(cast (f.fecemi as char(30)),0,11)<='".$ls_fecemi2."')  " .
			   		" AND f.estfaccon in ('C','A','P','N') and f.numfac not in (select numfac from sfc_instpago where " .
					" ".sql_dinamica ($ls_tienda_desde,$ls_tienda_hasta,'sfc_instpago',$ls_codtie).") ORDER BY f.numfac,montotot ASC;";


			// print "4---";

			 }
			 else
			 {
			  //$ls_sql="SELECT f.*,c.razcli,c.cedcli,i.monto as montotot FROM sfc_factura f,sfc_cliente c,sfc_instpago i WHERE ".sql_dinamica ($ls_tienda_desde,$ls_tienda_desde,'f',$ls_codtie)." AND  f.codemp='".$ls_codemp."' AND f.codcli=c.codcli AND f.codusu like '".$ls_codusu."' AND cedcli like '%".$ls_razcli."%' AND f.estfaccon='".$ls_estatus."' AND (f.fecemi>='".$ls_fecemi."' AND f.fecemi<='".$ls_fecemi2."') AND i.numfac=f.numfac;";

			 	if($ls_estatus=="N")
					{

						$ls_sql="SELECT distinct f.numfac,f.codcli,f.fecemi,c.razcli,c.cedcli,f.monto,f.estfaccon,f.monto as montotot,f.codusu  FROM sfc_factura f,sfc_cliente c WHERE f.codemp='".$ls_codemp."'" .
						" AND ".sql_dinamica ($ls_tienda_desde,$ls_tienda_hasta,'f',$ls_codtie)." AND f.codcli=c.codcli AND f.codusu like '".$ls_codusu."'" .
						" AND cedcli like '%".$ls_razcli."%' AND (f.estfaccon='P' OR  f.estfaccon='N') AND (substr(cast (f.fecemi as char(30)),0,11)>='".$ls_fecemi."'" .
						" AND substr(cast (f.fecemi as char(30)),0,11)<='".$ls_fecemi2."') ".
						" GROUP BY f.codemp,f.numfac,f.fecemi,f.codcli,c.razcli,c.cedcli,f.monto,f.estfaccon,f.codusu ".
						" ORDER BY f.numfac,montotot ASC;";

						$ls_sql2="";
				//print "4.1";

					}

				else
					{

						if($ls_estatus=="C")

						{
							$ls_sql="SELECT distinct f.numfac,f.codcli,f.fecemi,c.razcli,c.cedcli,f.monto,f.estfaccon,f.monto as montotot,f.codusu  FROM sfc_factura f,sfc_cliente c,sfc_instpago i WHERE f.codemp='".$ls_codemp."'" .
								" AND ".sql_dinamica ($ls_tienda_desde,$ls_tienda_hasta,'f',$ls_codtie)."  AND f.codcli=c.codcli AND " .
								" f.codusu like '".$ls_codusu."' AND cedcli like '%".$ls_razcli."%' AND (substr(cast (f.fecemi as char(30)),0,11)>='".$ls_fecemi."' AND substr(cast (f.fecemi as char(30)),0,11)<='".$ls_fecemi2."') " .
								" AND f.estfaccon='".$ls_estatus."'  AND i.numfac=f.numfac ".
								" GROUP BY f.codemp,f.numfac,f.fecemi,f.codcli,c.razcli,c.cedcli,f.monto,f.estfaccon,f.codusu ".
								" ORDER BY f.numfac,montotot ASC;";


							$ls_sql2="SELECT f.*,c.razcli,c.cedcli,f.monto as montotot,f.codusu FROM sfc_factura f,sfc_cliente c WHERE f.codemp='".$ls_codemp."' " .
							" AND ".sql_dinamica ($ls_tienda_desde,$ls_tienda_hasta,'f',$ls_codtie)." AND f.codcli=c.codcli AND f.codusu like '".$ls_codusu."'" .
							" AND cedcli like '%".$ls_razcli."%' AND (substr(cast (f.fecemi as char(30)),0,11)>='".$ls_fecemi."' AND substr(cast (f.fecemi as char(30)),0,11)<='".$ls_fecemi2."') " .
							" AND f.estfaccon in ('C') and f.numfac not in (select numfac from sfc_instpago where " .
							" ".sql_dinamica ($ls_tienda_desde,$ls_tienda_desde,'sfc_instpago',$ls_codtie).") ORDER BY f.numfac,montotot ASC;";



					//$ls_sql2="";
					//print "4.2";
					}
					else
					{
							$ls_sql="SELECT distinct f.numfac,f.codcli,f.fecemi,c.razcli,c.cedcli,f.monto,f.estfaccon,f.monto as montotot,f.codusu  FROM sfc_factura f,sfc_cliente c,sfc_instpago i WHERE f.codemp='".$ls_codemp."'" .
										" AND ".sql_dinamica ($ls_tienda_desde,$ls_tienda_hasta,'f',$ls_codtie)."  AND f.codcli=c.codcli AND " .
										" f.codusu like '".$ls_codusu."' AND cedcli like '%".$ls_razcli."%' AND (substr(cast (f.fecemi as char(30)),0,11)>='".$ls_fecemi."'" .
										" AND substr(cast (f.fecemi as char(30)),0,11)<='".$ls_fecemi2."') " .
										" AND f.estfaccon='".$ls_estatus."'  AND i.numfac=f.numfac ".
										" GROUP BY f.codemp,f.numfac,f.fecemi,f.codcli,c.razcli,c.cedcli,f.monto,f.estfaccon,f.codusu ".
										" ORDER BY f.numfac,montotot ASC;";

							$ls_sql2="SELECT f.*,c.razcli,c.cedcli,f.monto as montotot,f.codusu FROM sfc_factura f,sfc_cliente c WHERE f.codemp='".$ls_codemp."'" .
										" AND ".sql_dinamica ($ls_tienda_desde,$ls_tienda_hasta,'f',$ls_codtie)." AND f.codcli=c.codcli " .
										" AND f.codusu like '".$ls_codusu."' AND cedcli like '%".$ls_razcli."%' AND (substr(cast (f.fecemi as char(30)),0,11)>='".$ls_fecemi."'" .
										" AND substr(cast (f.fecemi as char(30)),0,11)<='".$ls_fecemi2."') " .
										" AND f.estfaccon in ('A') and f.numfac not in (select numfac from sfc_instpago where " .
							" ".sql_dinamica ($ls_tienda_desde,$ls_tienda_hasta,'sfc_instpago',$ls_codtie).") ORDER BY f.numfac,montotot ASC;";
					//print "4.3";

					}

				}

			 }
//print "4-".$ls_sql."--".$ls_sql2."<br>";
		}
        else
		{
		$io_msg->message("Debe introducir el rango completo de la fecha!");
		}

	 }///$ls_ordenarpor=="Null"

 $ls_ordenarpor="Null";

    ?>

     <script language="JavaScript">
   	 	var ls_sql="<?php print $ls_sql; ?>";
   	 	var ls_sql2="<?php print $ls_sql2; ?>";
		var ls_fecemi="<?php print $ls_fecemi; ?>";
		var ls_fecemi2="<?php print $ls_fecemi2; ?>";
		var ls_opcion="<?php print $ls_opcion; ?>";
		pagina="reportes/sigesp_sfc_rep_factura_excel.php?sql="+encodeURIComponent(ls_sql)+"&fecemi2="+ls_fecemi2+"&fecemi="+ls_fecemi+"&opcion="+ls_opcion+"&sql2="+ls_sql2;
	  	popupWin(pagina,"catalogo",580,700);
     </script>
    <?PHP
    /*}*/

}
?>
</body>
<!--************************************************************************************************************************/
/*************************** FUNCIONES DE JAVA SCRIPT **********************************************************************/
/*************************************************************************************************************************-->
<script language="JavaScript">

/************************* TIENDA***************************************/
function ue_buscar_tienda(intervalo)
{
	f=document.form1;
	if (intervalo == 'desde') {
	  f.hdnagrotienda.value='desde';
	  f.txtcodtienda_desde.value="";
	}else {
	  f.hdnagrotienda.value='hasta';
	  f.txtcodtienda_hasta.value="";
	}
	pagina="sigesp_cat_tienda.php";
	popupWin(pagina,"catalogo",600,250);
}


function ue_cargartienda (codtie,nomtie,dirtie,teltie,riftie,codpai,codest,codmun,codpar,items,spi_cuenta,denominacion,codunidad,denunidad,cuentapre,denpre,codestpro1,codestpro2,codestpro3,codestpro4,codestpro5)
{

	f=document.form1;
	if (f.hdnagrotienda.value == 'desde') {
	 f.txtcodtienda_desde.value=codtie;
	  f.txtdentienda_desde.value=nomtie;
	}else {
     f.txtcodtienda_hasta.value=codtie;
     f.txtdentienda_hasta.value=nomtie;
	}


}

/************************* TIENDA***************************************/


function ue_cargarcajero(codusu,nomusu,codtie,nomtie)
		{
		    f=document.form1;
			f.txtcodusu.value=codusu;

       	}
function ue_buscar_cajero()
{
	f=document.form1;
	f.operacion.value="";
	pagina="sigesp_cat_cajero.php";
	popupWin(pagina,"catalogo",650,300);

}

function ue_cargarcliente(codcli,nomcli,dircli,telcli,celcli,codpai,codest,codmun,codpar)
		{
			f=document.form1;

			f.txtcodcli.value=codcli;
            f.txtrazcli.value=nomcli;


		}

function ue_buscar_cliente()
 {
        f=document.form1;
		f.operacion.value="";
		pagina="sigesp_cat_cliente.php";
		popupWin(pagina,"catalogo",600,250);


 }

  function aceptar(codcla,nomcla)
  {
    opener.ue_cargarclasificacion(codcla,nomcla);
	close();
  }


  function ue_ver()
  {

  f=document.form1;
   li_imprimir=f.imprimir.value;
if(li_imprimir==1)
{
  f.operacion.value="VER";
  f.action="sigesp_sfc_d_rep_factura.php";
  f.submit();
 }
 else
	{alert("No tiene permiso para realizar esta operaci�n");}
  }


  function ue_ver2()
  {

  f=document.form1;
   li_imprimir=f.imprimir.value;
if(li_imprimir==1)
{
  f.operacion.value="VER2";
  f.action="sigesp_sfc_d_rep_factura.php";
  f.submit();
 }
 else
	{alert("No tiene permiso para realizar esta operaci�n");}
  }

  function actualizar_option()
{
			f=document.form1;
			f.operacion.value="ue_actualizar_option";
			f.action="sigesp_sfc_d_rep_factura.php";
			 f.submit();

}

  function actualizar_combo()
  {
   f=document.form1;
  f.combo_ordenarpor.value="VER";
  f.action="sigesp_sfc_d_rep_factura.php";
  f.submit();

  }

</script>

<script language="javascript" src="../shared/js/js_intra/datepickercontrol.js"></script>
</html>
