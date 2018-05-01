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
<style type="text/css">
 .ui-button.botones {
    background-color: #025688;
}
 .check:focus{ background-color: #025688;}
 .boton:focus{ background-color: #025688; color: #FFF; font-weight:bolder}
</style>
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
       obtenerregistros("");
	   obtenerinfogen();
	   $("#dialogoregistro").css("display","none");
	   $("input").keydown(enter2tab); 
    });
	 function enter2tab(e) {
         alert("Hola");
 	}
	function obtenerregistros(busqueda)
	{
		busqueda=$("#labusqueda").val();
		rangopub=$("input[name=rangoviz]:checked").val();
		if (busqueda=="")
		{
			var rangoa="todo";
		}
		else
		{
			var rangoa="especifico";
		}
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
					url:"scriptsphp/recpublicadores.php?rango="+rangoa+"&busqueda="+busqueda+"&Mes="+Mes+"&Anio="+Anio+"&Rangopub="+rangopub,
					success: function(data)
						{
							divregistros.html(data);
							obtenerinfogen();
						}
				}
			);	
		}
	}
	function editarinforme(nombrepub,publicador,mes,anio)
	{
		dialogoinsercion=$("#formerelleno");
		$.ajax(
				{
					async:true,
					type:"GET",
					cache:false,
					url:"scriptsphp/obtenerregistro.php?Publicador="+publicador+"&Mes="+mes+"&Anio="+anio+"&modo=edicion",
					success: function(data)
						{
							dialogoinsercion.html(data);
							$("#dialogoregistro").css("display","block");
							$("#dialogoregistro").dialog({resizable: false,width:"auto",show:{effect:"explode",duration:"2000"},hide:{effect:"explode",duration:"2000"}});
							$("#agregarregistro").attr("onclick","editandoinforme("+publicador+","+mes+","+anio+")");
							$("#agregarregistro").attr("value","Modificar registro de "+nombrepub);
							$("#agregarregistro").button();
							$("#agregarregistro").enhanceWithin();
							$("#detalles").html("Modifique los detalles de "+mes+"/"+anio+" para "+nombrepub);
						}
				}
			);
	}
	function agregarinforme(nombrepub,publicador,mes,anio)
	{
		dialogoinsercion=$("#formerelleno");
		$.ajax(
				{
					async:true,
					type:"GET",
					cache:false,
					url:"scriptsphp/obtenerregistro.php?Publicador="+publicador+"&Mes="+mes+"&Anio="+anio+"&modo=insercion",
					success: function(data)
						{
							dialogoinsercion.html(data);
							$("#dialogoregistro").css("display","block");
							$("#dialogoregistro").dialog({resizable: false,width:"auto",show:{effect:"explode",duration:"2000"},hide:{effect:"explode",duration:"2000"}});
							$("#agregarregistro").attr("onclick","agregandoinforme("+publicador+","+mes+","+anio+")");
							$("#agregarregistro").attr("value","Agregar registro de "+nombrepub);
							$("#agregarregistro").button();
							$("#agregarregistro").enhanceWithin();
							$("#detalles").html("Ingrese los detalles de "+mes+"/"+anio+" para "+nombrepub);
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
	function agregandoinforme(publicador,mes,anio)
	{
		dialogomensaje=$("#dialogo");
		libros=$("#libros").val();
		folletos=$("#folletos").val();
		horas=$("#horas").val();
		revistas=$("#revistas").val();
		revisitas=$("#revisitas").val();
		estudios=$("#estudios").val();
		notas=$("#notas").val();
		precureg=$("#precureg").is(":checked");
		precuaux=$("#precuaux").is(":checked");
		if (notas==" " || notas=="  ")
		{
			notas="-";
		}
		if (precuaux)
		{
			cadenaprecaux="SI";
		}
		else
		{
			cadenaprecaux="NO";
		}
		if (precureg)
		{
			cadenaprecreg="SI";
		}
		else
		{
			cadenaprecreg="NO";
		}
		if (libros=="" || isNaN(libros) || folletos=="" || isNaN(folletos) || horas=="" || isNaN(horas) || revistas=="" || isNaN(revistas) || revisitas==""  || isNaN(revisitas) ||  estudios==""  || isNaN(estudios) || notas=="" || precuaux==true && precureg==true)
		{
			if (isNaN(libros))
			{
				aparecermensajedeerror("errorlibros","Esto no es un numero");
				$("#libros").attr("onkeyup","desaparecermensajedeerror('errorlibros')");
			}
			if (libros=="")
			{
				aparecermensajedeerror("errorlibros","La cantidad de libros no ha sido ingresada (Ingrese un 0 en caso de no haber datos)");
				$("#libros").attr("onkeyup","desaparecermensajedeerror('errorlibros')");
			}
			if (isNaN(folletos))
			{
				aparecermensajedeerror("errorfolletos","Esto no es un numero");
				$("#folletos").attr("onkeyup","desaparecermensajedeerror('errorfolletos')");
			}
			if (folletos=="")
			{
				aparecermensajedeerror("errorfolletos","La cantidad de folletos no ha sido ingresada (Ingrese un 0 en caso de no haber datos)");
				$("#folletos").attr("onkeyup","desaparecermensajedeerror('errorfolletos')");
			}
			if (isNaN(horas))
			{
				aparecermensajedeerror("errorhoras","Esto no es un numero");
				$("#horas").attr("onkeyup","desaparecermensajedeerror('errorhoras')");
			}
			if (horas=="")
			{
				aparecermensajedeerror("errorhoras","La cantidad de horas no ha sido ingresada (Ingrese un 0 en caso de no haber datos)");
				$("#horas").attr("onkeyup","desaparecermensajedeerror('errorhoras')");
			}
			if (isNaN(revistas))
			{
				aparecermensajedeerror("errorrevistas","Esto no es un numero");
				$("#revistas").attr("onkeyup","desaparecermensajedeerror('errorrevistas')");
			}
			if (revistas=="")
			{
				aparecermensajedeerror("errorrevistas","La cantidad de revistas no ha sido ingresada (Ingrese un 0 en caso de no haber datos)");
				$("#revistas").attr("onkeyup","desaparecermensajedeerror('errorrevistas')");
			}
			if (isNaN(revisitas))
			{
				aparecermensajedeerror("errorrevisitas","Esto no es un numero");
				$("#revisitas").attr("onkeyup","desaparecermensajedeerror('errorrevisitas')");
			}
			if (revisitas=="")
			{
				aparecermensajedeerror("errorrevisitas","La cantidad de revisitas no ha sido ingresada (Ingrese un 0 en caso de no haber datos)");
				$("#revisitas").attr("onkeyup","desaparecermensajedeerror('errorrevisitas')");
			}
			if (isNaN(estudios))
			{
				aparecermensajedeerror("errorestudios","Esto no es un numero");
				$("#estudios").attr("onkeyup","desaparecermensajedeerror('errorestudios')");
			}
			if (estudios=="")
			{
				aparecermensajedeerror("errorestudios","La cantidad de estudios no ha sido ingresada (Ingrese un 0 en caso de no haber datos)");
				$("#estudios").attr("onkeyup","desaparecermensajedeerror('errorestudios')");
			}
			if (notas=="")
			{
				aparecermensajedeerror("errornotas","Las notas no han sido ingresadas (Ingrese un '-' en caso de no haber datos)");
				$("#notas").attr("onkeyup","desaparecermensajedeerror('errornotas')");
			}
			if (precuaux==true && precureg==true)
			{
				aparecermensajedeerror("errorprec","No pueden ser elegidos ambos al mismo tiempo");
				$("#precuaux").attr("onclick","desaparecermensajedeerror('errorprec')");
				$("#precureg").attr("onclick","desaparecermensajedeerror('errorprec')");
			}
		}
		else
		{
			$.ajax(
				{
					async:true,
					type:"GET",
					cache:false,
					url:"scriptsphp/agregarrecord.php?Publicador="+publicador+"&Mes="+mes+"&Anio="+anio+"&Libros="+libros+"&Folletos="+folletos+"&Horas="+horas+"&Revistas="+revistas+"&Revisitas="+revisitas+"&Estbib="+estudios+"&Notas="+notas+"&Precaux="+cadenaprecaux+"&Precreg="+cadenaprecreg,
					success: function(data)
						{
							$("#dialogoregistro").dialog("close");
							dialogomensaje.html(data);
							dialogomensaje.dialog({resizable: false,width:"auto",show:{effect:"puff",duration:"2000"},hide:{effect:"puff",duration:"2000"}});
							obtenerregistros("");
						}
				}
			);	
		}
	}
	function obtenerinfogen()
	{
		$("#acordeoninfo").accordion({ heightStyle: "content",active: false,collapsible: true});
		Mes=$("#mesinf").val();
		Anio=$("#anioinf").val();
		divinfogen=$("#infogen");
		$.ajax(
				{
					async:true,
					type:"GET",
					cache:false,
					url:"scriptsphp/obtenerinfogen.php?Mes="+Mes+"&Anio="+Anio,
					success: function(data)
						{
							divinfogen.html(data);
						}
				}
			);
	}
	function editandoinforme(publicador,mes,anio)
	{
		dialogomensaje=$("#dialogo");
		libros=$("#libros").val();
		folletos=$("#folletos").val();
		horas=$("#horas").val();
		revistas=$("#revistas").val();
		revisitas=$("#revisitas").val();
		estudios=$("#estudios").val();
		notas=$("#notas").val();
		precureg=$("#precureg").is(":checked");
		precuaux=$("#precuaux").is(":checked");
		if (precuaux)
		{
			cadenaprecaux="SI";
		}
		else
		{
			cadenaprecaux="NO";
		}
		if (precureg)
		{
			cadenaprecreg="SI";
		}
		else
		{
			cadenaprecreg="NO";
		}
		if (libros=="" || isNaN(libros) || folletos=="" || isNaN(folletos) || horas=="" || isNaN(horas) || revistas=="" || isNaN(revistas) || revisitas==""  || isNaN(revisitas) ||  estudios==""  || isNaN(estudios) || notas=="" || precuaux==true && precureg==true)
		{
			if (isNaN(libros))
			{
				aparecermensajedeerror("errorlibros","Esto no es un numero");
				$("#libros").attr("onkeyup","desaparecermensajedeerror('errorlibros')");
			}
			if (libros=="")
			{
				aparecermensajedeerror("errorlibros","La cantidad de libros no ha sido ingresada (Ingrese un 0 en caso de no haber datos)");
				$("#libros").attr("onkeyup","desaparecermensajedeerror('errorlibros')");
			}
			if (isNaN(folletos))
			{
				aparecermensajedeerror("errorfolletos","Esto no es un numero");
				$("#folletos").attr("onkeyup","desaparecermensajedeerror('errorfolletos')");
			}
			if (folletos=="")
			{
				aparecermensajedeerror("errorfolletos","La cantidad de folletos no ha sido ingresada (Ingrese un 0 en caso de no haber datos)");
				$("#folletos").attr("onkeyup","desaparecermensajedeerror('errorfolletos')");
			}
			if (isNaN(horas))
			{
				aparecermensajedeerror("errorhoras","Esto no es un numero");
				$("#horas").attr("onkeyup","desaparecermensajedeerror('errorhoras')");
			}
			if (horas=="")
			{
				aparecermensajedeerror("errorhoras","La cantidad de horas no ha sido ingresada (Ingrese un 0 en caso de no haber datos)");
				$("#horas").attr("onkeyup","desaparecermensajedeerror('errorhoras')");
			}
			if (isNaN(revistas))
			{
				aparecermensajedeerror("errorrevistas","Esto no es un numero");
				$("#revistas").attr("onkeyup","desaparecermensajedeerror('errorrevistas')");
			}
			if (revistas=="")
			{
				aparecermensajedeerror("errorrevistas","La cantidad de revistas no ha sido ingresada (Ingrese un 0 en caso de no haber datos)");
				$("#revistas").attr("onkeyup","desaparecermensajedeerror('errorrevistas')");
			}
			if (isNaN(revisitas))
			{
				aparecermensajedeerror("errorrevisitas","Esto no es un numero");
				$("#revisitas").attr("onkeyup","desaparecermensajedeerror('errorrevisitas')");
			}
			if (revisitas=="")
			{
				aparecermensajedeerror("errorrevisitas","La cantidad de revisitas no ha sido ingresada (Ingrese un 0 en caso de no haber datos)");
				$("#revisitas").attr("onkeyup","desaparecermensajedeerror('errorrevisitas')");
			}
			if (isNaN(estudios))
			{
				aparecermensajedeerror("errorestudios","Esto no es un numero");
				$("#estudios").attr("onkeyup","desaparecermensajedeerror('errorestudios')");
			}
			if (estudios=="")
			{
				aparecermensajedeerror("errorestudios","La cantidad de estudios no ha sido ingresada (Ingrese un 0 en caso de no haber datos)");
				$("#estudios").attr("onkeyup","desaparecermensajedeerror('errorestudios')");
			}
			if (notas=="")
			{
				aparecermensajedeerror("errornotas","Las notas no han sido ingresadas (Ingrese un '-' en caso de no haber datos)");
				$("#notas").attr("onkeyup","desaparecermensajedeerror('errornotas')");
			}
			if (precuaux==true && precureg==true)
			{
				aparecermensajedeerror("errorprec","No pueden ser elegidos ambos al mismo tiempo");
				$("#precuaux").attr("onclick","desaparecermensajedeerror('errorprec')");
				$("#precureg").attr("onclick","desaparecermensajedeerror('errorprec')");
			}
		}
		else
		{
			$.ajax(
					{
						async:true,
						type:"GET",
						cache:false,
						url:"scriptsphp/editarrecord.php?Publicador="+publicador+"&Mes="+mes+"&Anio="+anio+"&Libros="+libros+"&Folletos="+folletos+"&Horas="+horas+"&Revistas="+revistas+"&Revisitas="+revisitas+"&Estbib="+estudios+"&Notas="+notas+"&Precaux="+cadenaprecaux+"&Precreg="+cadenaprecreg,
						success: function(data)
							{
								dialogomensaje.html(data);
								dialogomensaje.dialog({resizable: false,width:"auto",show:{effect:"puff",duration:"2000"},hide:{effect:"puff",duration:"2000"}});
								obtenerregistros("");
							}
					}
				);
		}
	}
	function vernombres(tipo)
	{
		dialogomensaje=$("#dialogolista");
		Mes=$("#mesinf").val();
		Anio=$("#anioinf").val();
		var titulo;
		switch (tipo)
		{
			case "informantes":
				titulo="Lista de publicadores que informaron";
			break;
			case "noinformantes":
				titulo="Lista de publicadores que no informaron";
			break;
			case "activos":
				titulo="Lista de publicadores activos";
			break;
			case "publicadores":
				titulo="Lista de publicadores";
			break;
			case "precursoresauxiliares":
				titulo="Lista de precursores auxiliares";
			break;
			case "precursoresregulares":
				titulo="Lista de precursores regulares";
			break;
	 	}
		$.ajax(
					{
						async:true,
						type:"GET",
						cache:false,
						url:"scriptsphp/obtenernombres.php?Tipo="+tipo+"&Mes="+Mes+"&Anio="+Anio,
						success: function(data)
							{
								dialogomensaje.html(data);
								dialogomensaje.dialog({resizable: false,width:"auto",show:{effect:"puff",duration:"2000"},hide:{effect:"puff",duration:"2000"},title: titulo});
							}
					}
				);
		
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
			<li class="active"><a href="#">Agregar informes</a></li>
            <li><a href="reuniones.php">Asistencia a reuniones</a></li>
		</ul>
	</div>
	<div id="top-bar" class="container">
		<div class="bar">
			<div class="text" style="font-size:18px; color:#00C;">Buscador de publicadores por nombre<input type="text" name="busqueda" id="labusqueda" onkeyup="obtenerregistros()" /></div>
            <div class="text" style="font-size:18px; color:#00C;">Agregar informe de 
              <select name="mesinf" size="1" id="mesinf" onchange="obtenerregistros('')">
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
              <select name="anioinf" id="anioinf" onchange="obtenerregistros('')">
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
            <td width="50%" style="background-color:#DAFED3; font-size:22px" align="center"><img src="images/Pagina/ok.png" width="30" height="30" alt="datos"/>Entregado</td>
            <td width="50%" style="background-color:#FFD7E6; font-size:22px" align="center"><img src="images/Pagina/incorrecto.png" width="30" height="30" alt="datos"/>No entregado</td>
          </tr>
        </table>
        <h2>&nbsp;</h2>
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
        	<ul>
                	<li><h3>Rango de publicadores</h3></li>
                    <li><p>
                      Todos<input type="radio" name="rangoviz" id="rangoviz" value="Todos" <? if ($Grupo==0){?>checked="checked" <? }?>onchange="obtenerregistros('')"/>
                    </p>
                    </li>
                    <li><p>
                    	Grupo 1<input type="radio" name="rangoviz" id="rangoviz" value="Grupo1"  <? if ($Grupo==1){?>checked="checked" <? }?>onchange="obtenerregistros('')"/>
                    </p></li>
                    <li><p>
                    	Grupo 2<input type="radio" name="rangoviz" id="rangoviz" value="Grupo2"  <? if ($Grupo==2){?>checked="checked" <? }?>onchange="obtenerregistros('')"/>
                    </p></li>
                    <li><p>
                    	Grupo 3<input type="radio" name="rangoviz" id="rangoviz" value="Grupo3"  <? if ($Grupo==3){?>checked="checked" <? }?>onchange="obtenerregistros('')"/>
                    </p></li>
                    <li><p>
                    	Grupo 4<input type="radio" name="rangoviz" id="rangoviz" value="Grupo4"  <? if ($Grupo==4){?>checked="checked" <? }?>onchange="obtenerregistros('')"/>
                    </p></li>
                </ul>
            <div id="acordeoninfo">
                <h2>Ver totales del servicio del campo de este mes</h2>
                <div>
                    <ul id="infogen">
                    </ul>
                </div>  
          </div>
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