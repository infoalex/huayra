<?php 
session_start(); 
if((!array_key_exists("ls_database",$_SESSION))||(!array_key_exists("ls_hostname",$_SESSION))||(!array_key_exists("ls_gestor",$_SESSION))||(!array_key_exists("ls_login",$_SESSION))||(!array_key_exists("la_logusr",$_SESSION))||(!array_key_exists("la_empresa",$_SESSION)))
{
	print "<script language=JavaScript>";
	print "location.href='index.php'";
	print "</script>";		
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Sistema Administrativo HUAYRA -**- C.V.A.L -**- , <?php print $_SESSION["ls_nombrelogico"] ?> </title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<style type="text/css">
<!--
body{color:#666666;font-family:Tahoma, Verdana, Arial;font-size:11px;margin:0px;background-color:#EAEAEA;}
.titulo {
	font-family: Tahoma, Verdana, Arial;
	font-size: 16px;
	font-weight: bold;
	color: #666666;
}
.style1 {font-size: 12px}
.style6 {font-size: 16px}
.style7 {color: #FF0000}
.Estilo1 {
	font-size: 10;
	color: #898989;
}
-->
</style>
<link rel="stylesheet" type="text/css" href="css/principal.css"/>
</head>
<script language="javascript">

	function A()
	{
		window.onerror=B
		window.opener.focus();
		window.focus();
	}
	function B()
	{
		var url = document.location.href;
		partes = url.split('/');
		pagina=partes[partes.length-1];
		alert("No ha iniciado sesi�n para esta ventana");
		location.href=url.replace(pagina,"pagina_blanco.php");
		return true;
	} 
	A();
</script>
<body class="fondo_contenido_capa1">
<table width="655" height="521" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td >&nbsp;</td>
  </tr>
  <tr>
    <td >&nbsp;</td>
  </tr>
  <tr>
    <td >&nbsp;</td>
  </tr>
  <tr>
    <td >&nbsp;</td>
  </tr>
  <tr>
    <td ><div align="center"><img src="shared/imagebank/header_banner.png" width="509" height="40">        </div><!--<div align="center" class="estilo_titulo">HUAYRA</div>--></td>
  </tr>
  <tr>
    <td >&nbsp;</td>
  </tr>
  <tr>
    <td width="655" class="fondo">
    <div align="center" class="Estilo_ubicacion">Configuraci&oacute;n</div><br />
    <table width="581" border="0" align="center" height="337" class="fondo_contenido">
      <tr>
        <td width="267">&nbsp;</td>
        <td width="99">&nbsp;</td>
        <td width="201">&nbsp;</td>
      </tr>
      <tr>
        <td height="54"><div align="center" id="buttom-box">
                      <a href="sss/sigespwindow_blank.php" class="button_seguridad" target="_self"></a>
             </div></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="56"><div id="buttom-box" align="center">
              <a href="cfg/index.php" target="_self" class="button_instalar"></a>
          </div></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="54"><div id="buttom-box" align="center">
              <a href="mis/sigespwindow_blank.php" target="_self" class="button_integrator"></a>
          </div></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="54"><div id="buttom-box" align="center">
              <a href="ins/sigespwindow_blank.php" target="_self" class="button_mantenor"></a>
          </div></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="58">&nbsp;</td>
        <td>&nbsp;</td>
        <td><div id="buttom-box" align="center">
                      <a href="index_modules.php" target="_self" class="button_regmenu"></a>
             </div></td>
      </tr>
      <tr>
        <td height="14">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table>    </td>
  </tr>
</table>
</body>
</html>
