<? 
session_start();
if ($_SESSION["idusrecor"]==0)
{
	header ("Location:inicioses.php");
}
$usuario=$_SESSION["Usuariorec"];
$passus=$_SESSION["Pass"];
$idusuario=$_SESSION["idusrecor"];
$Categoria=$_SESSION["Categoriarec"];
$Email=$_SESSION["Email"];
$Nombre=$_SESSION["Nombre"];
$Apellido=$_SESSION["Apellido"];
$Grupo=$_SESSION["Grupo"];
$Congre = $_SESSION["Congregacion"];
$servidor=$_SESSION['servidor'];
$dbusuario=$_SESSION['dbusuario'];
$dbcontrasena=$_SESSION['dbcontrasena'];
$nomdb=$_SESSION['nomdb'];
$mendb=$_SESSION['condb'];
$con=mysqli_connect($servidor,$dbusuario,$dbcontrasena);
mysqli_select_db($con,$nomdb) or die ($mendb);
$ac="select * from congregaciones where idcong=$Congre";	
$bc=mysqli_query($con,$ac) or die ("error buscando ".$ac);
$mref=mysqli_fetch_array($bc);
$NombCong=$mref['NombCong'];
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

#datnom td:nth-child(odd){
    background: #09234B;
    color: #04A2EE;
}
 
#datnom td:nth-child(even){
	background: #04A2EE;
    color: #09234B;
}
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
	   obtenernotificaciones();
	   $("#dialogoregistro").css("display","none");
	   $("input").keydown(enter2tab); 
    });
	 function enter2tab(e) {
          if (e.keyCode == 13) {
		   //Obtiene el atributo tab index del elemento y le suma uno para obtener el siguiente elemento del formulario que debera tomar foco
           cb = parseInt($(this).attr('tabindex'));
    
           if ($(':input[tabindex=\'' + (cb + 1) + '\']') != null) {
               $(':input[tabindex=\'' + (cb + 1) + '\']').focus();
               $(':input[tabindex=\'' + (cb + 1) + '\']').select();
               e.preventDefault();
    
               return false;
           }
       }
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
	function obtenernotificaciones()
	{
		$.ajax(
				{
					async:true,
					type:"GET",
					cache:false,
					url:"scriptsphp/obtenernotificaciones.php",
					success: function(data)
						{
							//alert(data);
							if (data==1)
							{
								obtenerregistros("");
								obtenerinfogen();
								//alert("Hola");
							}
							setTimeout("obtenernotificaciones()","5000");
						}
				}
			);	
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
		publicaciones=$("#publicaciones").val();
		videos=$("#videos").val();
		horas=$("#horas").val();
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
		if (publicaciones=="" || isNaN(publicaciones) || videos=="" || isNaN(videos) || horas=="" || isNaN(horas)  || revisitas==""  || isNaN(revisitas) ||  estudios==""  || isNaN(estudios) || notas=="" || precuaux==true && precureg==true || (publicaciones=="0" && videos=="0" && horas=="0" && revisitas=="0" && estudios=="0"))
		{
			if (publicaciones=="0" && videos=="0" && horas=="0" && revisitas=="0" && estudios=="0")
			{
				aparecermensajedeerror("errorestudios","Todos los campos tienen el valor de 0. El informe no es considerado como entregado");
				$("#publicaciones").attr("onkeyup","desaparecermensajedeerror('errorestudios')");
				$("#videos").attr("onkeyup","desaparecermensajedeerror('errorestudios')");
				$("#horas").attr("onkeyup","desaparecermensajedeerror('errorestudios')");
				$("#revisitas").attr("onkeyup","desaparecermensajedeerror('errorestudios')");
				$("#estudios").attr("onkeyup","desaparecermensajedeerror('errorestudios')");
			}
			if (isNaN(publicaciones))
			{
				aparecermensajedeerror("errorpublicaciones","Esto no es un numero");
				$("#publicaciones").attr("onkeyup","desaparecermensajedeerror('errorpublicaciones')");
			}
			if (publicaciones=="")
			{
				aparecermensajedeerror("errorpublicaciones","La cantidad de libros no ha sido ingresada (Ingrese un 0 en caso de no haber datos)");
				$("#publicaciones").attr("onkeyup","desaparecermensajedeerror('errorpublicaciones')");
			}
			if (isNaN(videos))
			{
				aparecermensajedeerror("errorvideos","Esto no es un numero");
				$("#videos").attr("onkeyup","desaparecermensajedeerror('errorvideos')");
			}
			if (videos=="")
			{
				aparecermensajedeerror("errorvideos","La cantidad de folletos no ha sido ingresada (Ingrese un 0 en caso de no haber datos)");
				$("#videos").attr("onkeyup","desaparecermensajedeerror('errorvideos')");
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
					url:"scriptsphp/agregarrecord.php?Publicador="+publicador+"&Mes="+mes+"&Anio="+anio+"&Publicaciones="+publicaciones+"&Videos="+videos+"&Horas="+horas+"&Revisitas="+revisitas+"&Estbib="+estudios+"&Notas="+notas+"&Precaux="+cadenaprecaux+"&Precreg="+cadenaprecreg,
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
		$("#acordeoninfo").accordion({ heightStyle: "content",active: 0,collapsible: true});
		Mes=$("#mesinf").val();
		Anio=$("#anioinf").val();
		divinfogen=$("#infogen");
		var rangopub=$("input[name=rangoviz]:checked").val();
		if (rangopub=="Todos")
		{
			rangopub=0;
		}
		$.ajax(
				{
					async:true,
					type:"GET",
					cache:false,
					url:"scriptsphp/obtenerinfogen.php?Mes="+Mes+"&Anio="+Anio+"&Grupo="+rangopub,
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
		publicaciones=$("#publicaciones").val();
		videos=$("#videos").val();
		horas=$("#horas").val();
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
		if (publicaciones=="" || isNaN(publicaciones) || videos=="" || isNaN(videos) || horas=="" || isNaN(horas)  || revisitas==""  || isNaN(revisitas) ||  estudios==""  || isNaN(estudios) || notas=="" || precuaux==true && precureg==true || (publicaciones=="0" && videos=="0" && horas=="0" && revisitas=="0" && estudios=="0"))
		{
			if (publicaciones=="0" && videos=="0" && horas=="0" && revisitas=="0" && estudios=="0")
			{
				aparecermensajedeerror("errorestudios","Todos los campos tienen el valor de 0. El informe no es considerado como entregado");
				$("#publicaciones").attr("onkeyup","desaparecermensajedeerror('errorestudios')");
				$("#videos").attr("onkeyup","desaparecermensajedeerror('errorestudios')");
				$("#horas").attr("onkeyup","desaparecermensajedeerror('errorestudios')");
				$("#revisitas").attr("onkeyup","desaparecermensajedeerror('errorestudios')");
				$("#estudios").attr("onkeyup","desaparecermensajedeerror('errorestudios')");
			}
			if (isNaN(publicaciones))
			{
				aparecermensajedeerror("errorpublicaciones","Esto no es un numero");
				$("#publicaciones").attr("onkeyup","desaparecermensajedeerror('errorpublicaciones')");
			}
			if (publicaciones=="")
			{
				aparecermensajedeerror("errorpublicaciones","La cantidad de libros no ha sido ingresada (Ingrese un 0 en caso de no haber datos)");
				$("#publicaciones").attr("onkeyup","desaparecermensajedeerror('errorpublicaciones')");
			}
			if (isNaN(videos))
			{
				aparecermensajedeerror("errorvideos","Esto no es un numero");
				$("#videos").attr("onkeyup","desaparecermensajedeerror('errorvideos')");
			}
			if (videos=="")
			{
				aparecermensajedeerror("errorvideos","La cantidad de folletos no ha sido ingresada (Ingrese un 0 en caso de no haber datos)");
				$("#videos").attr("onkeyup","desaparecermensajedeerror('errorvideos')");
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
						url:"scriptsphp/editarrecord.php?Publicador="+publicador+"&Mes="+mes+"&Anio="+anio+"&Publicaciones="+publicaciones+"&Videos="+videos+"&Horas="+horas+"&Revisitas="+revisitas+"&Estbib="+estudios+"&Notas="+notas+"&Precaux="+cadenaprecaux+"&Precreg="+cadenaprecreg,
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
	function vernombres(tipo,grupo)
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
						url:"scriptsphp/obtenernombres.php?Tipo="+tipo+"&Mes="+Mes+"&Anio="+Anio+"&Grupo="+grupo,
						success: function(data)
							{
								dialogomensaje.html(data);
								dialogomensaje.dialog({resizable: false,width:"auto",show:{effect:"puff",duration:"2000"},hide:{effect:"puff",duration:"2000"},title: titulo});
							}
					}
				);
		
	}
function editardatacount()
	{
		dialogodata=$("#dialogo");
		Usuario=$("#userr").val();
		Pass=$("#passs").val();
		myuser=<? echo $idusuario;?>;
		$.ajax(
				{
					async:true,
					type:"GET",
					url:"scriptsphp/editarcount.php?idusuario="+myuser+"&Usuario="+Usuario+"&Pass="+Pass,
					cache:false,
					success: function(data)
					{
						dialogodata.html(data);
						dialogodata.dialog({show:{effect:"fold",duration:"2000"},hide:{effect:"fold",duration:"2000"}});
						$("#miuser").html(Usuario);
						$("#mipasw").html(Pass);
					}
				});
	}
	function editardetallesdecuenta()
	{
		dialogodata=$("#datosdecuenta");
		myuser=<? echo $idusuario;?>;
		$.ajax(
				{
					async:true,
					type:"GET",
					url:"scriptsphp/obtenercuenta.php?myuser="+myuser,
					cache:false,
					success: function(data)
					{
						dialogodata.html(data);
						$("#cambiar").button();
						$("#cambiar").click(editardatacount);
						dialogodata.dialog({show:{effect:"puff",duration:"2000"},hide:{effect:"puff",duration:"2000"}});
					}
				});
	}
	function mostrardatosus()
	{
		dialogodestino=$("#dialogodus");
		dialogodestino.dialog({resizable: false,width:"auto",show:{effect:"fold",duration:"2000"},hide:{effect:"fold",duration:"2000"}});
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
			<? if ($Categoria==1) {?>
			<li><a href="index.php">Datos de publicadores</a></li>
            <? }?>
			<li class="active"><a href="#">Agregar informes</a></li>
            <? if ($Categoria==1) {?>
            <li><a href="reuniones.php">Asistencia a reuniones</a></li>
            <? }?>
            <li><a href="#" onclick="mostrardatosus()">Datos de mi cuenta</a></li>
            <li><a href="scriptsphp/cerrarses.php">Cerrar sesion</a></li>
		</ul>
	</div>
	<div id="top-bar" class="container">
		<div class="bar">
			<div class="text" style="font-size:18px; color:#00C;">Buscador de publicadores por nombre<input type="text" name="busqueda" id="labusqueda" onkeyup="obtenerregistros()"/></div> 
           
            <? if ($Categoria!=1) {
				switch($mes)
				{
					case 1:
						$mesmue="Enero";
					break;
					case 2:
						$mesmue="Febrero";
					break;
					case 3:
						$mesmue="Marzo";
					break;
					case 4:
						$mesmue="Abril";
					break;
					case 5:
						$mesmue="Mayo";
					break;
					case 6:
						$mesmue="Junio";
					break;
					case 7:
						$mesmue="Julio";
					break;
					case 8:
						$mesmue="Agosto";
					break;
					case 9:
						$mesmue="Septiembre";
					break;
					case 10:
						$mesmue="Octubre";
					break;
					case 11:
						$mesmue="Noviembre";
					break;
					case 12:
						$mesmue="Diciembre";
					break;
				}
				?> 
            <div class="text" style="font-size:18px; color:#00C;"> <? echo "Informes de ".$mesmue."/".$anio;?></div>
            <? } else {?>
            <div class="text" style="font-size:18px; color:#00C;">Agregar informe de
             <? } ?>
              <select name="mesinf" size="1" id="mesinf" onchange="obtenerregistros('')"  <? if ($Categoria!=1) {?>hidden<? }?>>
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
              <select name="anioinf" id="anioinf" onchange="obtenerregistros('')" <? if ($Categoria!=1) {?>hidden<? }?>>
              <? for ($i=2012;$i<=$anio;$i++)
			  { ?>
				  <option <? if ($anio==$i){?>selected="selected"<? }?>> <? echo $i;?></option>
				<? }?>
              	
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
        <div id="dialogodus" style="display:none">
        	<h2>Datos de mi cuenta</h2>
                <div>
                    <ul>
                    	<li><p>Nombre: <? echo $Nombre;?></p></li>
                        <li><p>Apellido: <? echo $Apellido;?></p></li>
                        <li><p>Congregacion: <? echo $NombCong;?></p></li>
                        <li><p>Grupo: <? echo $Grupo;?></p></li>
                        <li><p>Nombre de usuario: <span id="miuser"><? echo $usuario;?></span></p></li>
                        <li><p>Contraseña: <span id="mipasw"><? echo $passus;?></span></p></li>
                        <li><p>Correo electronico: <? echo $Email;?></p></li>
                        <li><h4><a href="javascript:" onclick="editardetallesdecuenta()">Editar nombre de usuario y/o contraseña</a></h4></li>
                    </ul>
                </div>
        </div>
        <div id="dialogo"></div>
        <div id="datosdecuenta"></div>
        <div id="dialogolista"></div>
        <div id="dialogoregistro">
        <h4 id="detalles"></h4>
        <span id="formerelleno"></span>
        	
        </div>
		<div id="sidebar">
        	<ul>
                	<li><h3>Rango de publicadores</h3></li>
                    <? if ($Categoria!=1) {?>
                    <h4>Grupo <? echo $Grupo;?></h4>
                    <? }?>
                    <li><p <? if ($Categoria!=1) {?>style="display:none"<? }?>>
                      Todos<input type="radio" name="rangoviz" id="rangoviz" value="Todos" <? if ($Grupo==0){?>checked="checked" <? }?>onchange="obtenerregistros('');obtenerinfogen();"/>
                    </p>
                    </li>
                    <? $ac="select * from grupos where Congregacion=$Congre";	
						$bc=mysqli_query($con,$ac) or die ("error buscando ".$ac);
						while ($mgrupp=mysqli_fetch_array($bc))
						{
							$Numgrupo=$mgrupp['NumGrupo'];
					?>
                    <li><p <? if ($Categoria!=1) {?>style="display:none"<? }?>>
                    	Grupo <? echo $Numgrupo;?><input type="radio" name="rangoviz" id="rangoviz" value="<? echo $Numgrupo;?>"  <? if ($Grupo==$Numgrupo){?>checked="checked" <? }?>onchange="obtenerregistros('');obtenerinfogen();"/>
                    </p></li>
                    <? }?>
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