<? 
session_start();
if ($_SESSION["idusrecor"]==0)
{
	header ("Location:inicioses.php");
}
$usuario=$_SESSION["Usuariorec"];
$passus=$_SESSION["Pass"];
$Categoria=$_SESSION["Categoriarec"];
$Email=$_SESSION["Email"];
$Nombre=$_SESSION["Nombre"];
$Apellido=$_SESSION["Apellido"];
$Grupo=$_SESSION["Grupo"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Registro de publicadores</title>
<link rel="shortcut icon" href="images/Pagina/registro.png">
<link rel="stylesheet" type="text/css" href="style.css" media="screen" />
<link type="text/css" href="js/jquery/jquery-ui.css" rel="stylesheet" />
<?
date_default_timezone_set('America/Argentina/Buenos_Aires');
$mes=date("m");
$anio=date("Y");
if ($mes==1)
{
	$mes=12;
	$anio-=1;
}
else
{
	$mes-=1;
}
?>
<script type="text/javascript" src="js/jquery/jquery.js"> </script>
<script type="text/javascript" src="js/jquery/jquery-ui.js"> </script>
<script>
     $.datepicker.regional['es'] = {
     closeText: 'Cerrar',
     prevText: '<Ant',
     nextText: 'Sig>',
     currentText: 'Hoy',
     monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
     monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
     dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
     dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
     dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
     weekHeader: 'Sm',
     dateFormat: 'dd/mm/yy',
     firstDay: 1,
     isRTL: false,
     showMonthAfterYear: false,
     yearSuffix: ''
     };
     $.datepicker.setDefaults($.datepicker.regional['es']);
    </script>
<script type="text/javascript">
	$(document).ready(function(e) {
       obtenerasistencias();
	   obtenerhistreun();
    });
	function obtenerasistencias()
	{
		Mes=$("#mesinf").val();
		Anio=$("#anioinf").val();
		divregistros=$("#listarec");
		mesactual=<? echo $mes;?>;
		anioactual=<? echo $anio;?>;
		if (Anio==anioactual && Mes>mesactual)
		{
			if ((mesactual+1)==Mes)
			{
				divregistros.html("<h2>Este mes aun no se ha completado</h2>");
				$("#infogen").html("<p>Mes incompleto</p>");
			}
			else
			{
				divregistros.html("<h2>Este mes aun no ha llegado. No hay ningun registro en la base de datos</h2>");
				$("#infogen").html("<p>El mes no llego</p>");
			}
		}
		else
		{
			$.ajax(
					{
						async:true,
						type:"GET",
						cache:false,
						url:"scriptsphp/obtenerasistencias.php?Mes="+Mes+"&Anio="+Anio,
						success: function(data)
							{
								divregistros.html(data);
							}
					}
				);
		}
	}
	function obtenerhistreun()
	{
		divhistorial=$("#dialogoresumen");
		$.ajax(
					{
						async:true,
						type:"GET",
						cache:false,
						url:"scriptsphp/obtenerreuniones.php?Mes="+Mes+"&Anio="+Anio,
						success: function(data)
							{
								divhistorial.html(data);
							}
					}
				);
	}
	function editarasistencia(Nombrereu,reunion,mes,anio)
	{
		dialogoinsercion=$("#formerelleno");
		$.ajax(
				{
					async:true,
					type:"GET",
					cache:false,
					url:"scriptsphp/obtenerasistencia.php?Reunion="+reunion+"&Mes="+mes+"&Anio="+anio+"&modo=edicion",
					success: function(data)
						{
							dialogoinsercion.html(data);
							$("#dialogoregistro").dialog({resizable: false,width:"auto",show:{effect:"explode",duration:"2000"},hide:{effect:"explode",duration:"2000"}});
							$("#modificaras").attr("onclick","editandoasistencia("+reunion+","+mes+","+anio+")");
							$("#modificaras").attr("value","Agregar asistencia de "+Nombrereu);
							$("#detalles").html("Ingrese los detalles de "+mes+"/"+anio+" para "+Nombrereu);
						}
				}
			);
	}
	function agregarasistencia(Nombrereu,reunion,mes,anio)
	{
		dialogoinsercion=$("#formerelleno");
		$.ajax(
				{
					async:true,
					type:"GET",
					cache:false,
					url:"scriptsphp/obtenerasistencia.php?Reunion="+reunion+"&Mes="+mes+"&Anio="+anio+"&modo=insercion",
					success: function(data)
						{
							dialogoinsercion.html(data);
							$("#dialogoregistro").dialog({resizable: false,width:"auto",show:{effect:"explode",duration:"2000"},hide:{effect:"explode",duration:"2000"}});
							$("#agregaras").attr("onclick","agregandoasistencia("+reunion+","+mes+","+anio+")");
							$("#agregaras").attr("value","Agregar asistencia de "+Nombrereu);
							$("#detalles").html("Ingrese los detalles de "+mes+"/"+anio+" para "+Nombrereu);
						}
				}
			);
	}
	function aparecermensajedeerror(elemento,mensaje)
	{
		$("#"+elemento).html(mensaje);
		$("#"+elemento).css("display","block");
	}
	function desaparecermensajedeerror(elemento)
	{
		$("#"+elemento).css("display","none");
	}
	function agregandoasistencia(reunion,mes,anio)
	{
		dialogomensaje=$("#dialogo");
		numreu=$("#numreu").val();
		asist=$("#asist").val();
		if (numreu=="" || isNaN(numreu) || asist=="" || isNaN(asist))
		{
			if (isNaN(numreu))
			{
				aparecermensajedeerror("errornureu","<p>Esto no es un numero</p>");
				$("#numreu").attr("onkeyup","desaparecermensajedeerror('errornureu')");
			}
			if (numreu=="")
			{
				aparecermensajedeerror("errornureu","<p>No se ha ingresado la cantidad de reuniones</p>");
				$("#numreu").attr("onkeyup","desaparecermensajedeerror('errornureu')");
			}
			if (isNaN(asist))
			{
				aparecermensajedeerror("errorasist","<p>Esto no es un numero</p>");
				$("#asist").attr("onkeyup","desaparecermensajedeerror('errorasist')");
			}
			if (asist=="")
			{
				aparecermensajedeerror("errorasist","<p>No se ha ingresado la asistencia</p>");
				$("#asist").attr("onkeyup","desaparecermensajedeerror('errorasist')");
			}
		}
		else
		{
			$.ajax(
				{
					async:true,
					type:"GET",
					cache:false,
					url:"scriptsphp/agregarasistencia.php?Reunion="+reunion+"&Mes="+mes+"&Anio="+anio+"&Numreu="+numreu+"&Asistencia="+asist,
					success: function(data)
						{
							$("#dialogoregistro").dialog("close");
							dialogomensaje.html(data);
							dialogomensaje.dialog({resizable: false,width:"auto",show:{effect:"puff",duration:"2000"},hide:{effect:"puff",duration:"2000"}});
							obtenerasistencias();
						}
				}
			);	
		}
	}
	function editandoasistencia(reunion,mes,anio)
	{
		dialogomensaje=$("#dialogo");
		numreu=$("#numreu").val();
		asist=$("#asist").val();
		if (numreu=="" || isNaN(numreu) || asist=="" || isNaN(asist))
		{
			if (isNaN(numreu))
			{
				aparecermensajedeerror("errornureu","<p>Esto no es un numero</p>");
				$("#numreu").attr("onkeyup","desaparecermensajedeerror('errornureu')");
			}
			if (numreu=="")
			{
				aparecermensajedeerror("errornureu","<p>No se ha ingresado la cantidad de reuniones</p>");
				$("#numreu").attr("onkeyup","desaparecermensajedeerror('errornureu')");
			}
			if (isNaN(asist))
			{
				aparecermensajedeerror("errorasist","<p>Esto no es un numero</p>");
				$("#asist").attr("onkeyup","desaparecermensajedeerror('errorasist')");
			}
			if (asist=="")
			{
				aparecermensajedeerror("errorasist","<p>No se ha ingresado la asistencia</p>");
				$("#asist").attr("onkeyup","desaparecermensajedeerror('errorasist')");
			}
		}
		else
		{
			$.ajax(
				{
					async:true,
					type:"GET",
					cache:false,
					url:"scriptsphp/editarasistencia.php?Reunion="+reunion+"&Mes="+mes+"&Anio="+anio+"&Numreu="+numreu+"&Asistencia="+asist,
					success: function(data)
						{
							$("#dialogoregistro").dialog("close");
							dialogomensaje.html(data);
							dialogomensaje.dialog({resizable: false,width:"auto",show:{effect:"puff",duration:"2000"},hide:{effect:"puff",duration:"2000"}});
							obtenerasistencias();
						}
				}
			);	
		}
	}
	function verinforme()
	{
		
	}
</script>
</head>
<body>
<div id="wrapper">
	<div id="header" class="container">
		<div id="logo">
			<h1><a href="#">Regitro de publicadores</a></h1>
		</div>
		<div id="banner"><img src="images/img01.jpg" width="667" height="118" alt="" /></div>
	</div>
	<div id="menu" class="container">
		<ul>
			<li><a href="index.php">Datos de publicadores</a></li>
			<li><a href="agregarinforme.php">Agregar informes</a></li>
            <li class="active"><a href="#">Asistencia a reuniones</a></li>
		</ul>
	</div>
	<div id="top-bar" class="container">
		<div class="bar">
            <div class="text" style="font-size:18px; color:#00C;">Ver asistencia de: 
              <select name="mesinf" size="1" id="mesinf" onchange="obtenerasistencias()">
                <option <? if ($mes==1){?>selected="selected"<? }?> value="1">Enero</option>
                <option <? if ($mes==2){?>selected="selected"<? }?> value="2">Febrero</option>
                <option <? if ($mes==3){?>selected="selected"<? }?> value="3">Marzo</option>
                <option <? if ($mes==4){?>selected="selected"<? }?> value="4">Abril</option>
                <option <? if ($mes==5){?>selected="selected"<? }?> value="5">Mayo</option>
                <option <? if ($mes==6){?>selected="selected"<? }?> value="6">Junio</option>
                <option <? if ($mes==7){?>selected="selected"<? }?> value="7">Julio</option>
                <option <? if ($mes==8){?>selected="selected"<? }?> value="8">Agosto</option>
                <option <? if ($mes==9){?>selected="selected"<? }?> value="9">Septiembre</option>
                <option <? if ($mes==10){?>selected="selected"<? }?> value="10">Octubre</option>
                <option <? if ($mes==11){?>selected="selected"<? }?> value="11">Noviembre</option>
                <option <? if ($mes==12){?>selected="selected"<? }?> value="12">Diciembre</option>
              </select> 
              <select name="anioinf" id="anioinf" onchange="obtenerasistencias()">
              	<option <? if ($anio==2012){?>selected="selected"<? }?>>2012</option>
                <option <? if ($anio==2013){?>selected="selected"<? }?>>2013</option>
                <option <? if ($anio==2014){?>selected="selected"<? }?>>2014</option>
                <option <? if ($anio==2015){?>selected="selected"<? }?>>2015</option>
              </select>
            </div>
		</div>
	</div>
	<div id="page" class="container"><div class="inner_copy"></div>
		<div id="content">
        <table width="100%" border="0" cellspacing="3">
          <tr>
            <td colspan="2" align="center"><h2>Referencias</h2></td>
          </tr>
          <tr>
            <td width="50%" style="background-color:#DAFED3; font-size:22px" align="center"><img src="images/Pagina/ok.png" width="30" height="30" alt="datos"/>Completado</td>
            <td width="50%" style="background-color:#FFD7E6; font-size:22px" align="center"><img src="images/Pagina/incorrecto.png" width="30" height="30" alt="datos"/>No completado</td>
          </tr>
        </table>
        <h2>&nbsp;</h2>
        <div id="dialogoresumen">
        
        </div>
<div id="listarec" style="font-size:24px; font-weight:bolder;">
  
</div>
		</div>
        <div id="dialogo"></div>
        <div id="dialogolista"></div>
        <div id="dialogoregistro">
        <h4 id="detalles"></h4>
        <span id="formerelleno"></span>
        	
        </div>
		<div id="sidebar">
		</div>
		<div class="clearfix">&nbsp;</div>
		<div id="footer-bar" class="two-cols">
			<div class="col1">
				<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d3539.449103929037!2d-58.94800122460632!3d-27.4864051156554!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x944572c91def9be9%3A0xf42d52aa5eea4fee!2sJuan+B.+Justo+4435%2C+Barranqueras%2C+Chaco!5e0!3m2!1ses-419!2sar!4v1423845097603" width="100%" height="150" frameborder="0" style="border:0"></iframe>
			</div>
			<div class="col2">
				<ul>
					<li><a href="#">Juan B Justo 4435</a><a href="#"></a></li>
				</ul>
			</div>
			<div class="clearfix">&nbsp;</div>
		</div>
	</div>
</div>
<div class="container">
	<div id="footer"><p style="text-align:center">Datos de congregacion Norte Barranqueras</p></div>
</div>
</body>
</html>