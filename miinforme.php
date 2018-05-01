<? 
session_start();
if ($_SESSION["Idpublicador"]==0)
{
	header ("Location:inicioses.php");
}
$Idpublicador=$_SESSION["Idpublicador"];
$Nombre=$_SESSION["Nombre"];
$DNI=$_SESSION["DNI"];
$Passpub=$_SESSION["Passpub"];
if ($Passpub=="")
{
	$Passpub=$DNI;
}
$Grupo = $_SESSION["Grupo"];
$Precreg=$_SESSION['Precreg'];
$Familia=$_SESSION['Familia'];
$servidor=$_SESSION['servidor'];
$dbusuario=$_SESSION['dbusuario'];
$dbcontrasena=$_SESSION['dbcontrasena'];
$nomdb=$_SESSION['nomdb'];
$mendb=$_SESSION['condb'];
$con=mysqli_connect($servidor,$dbusuario,$dbcontrasena);
mysqli_select_db($con,$nomdb) or die ($mendb);
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
$mesmue="";
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
$a="SELECT * FROM `familias` WHERE `idfamilia` = $Familia";
	$b = mysqli_query ($con,$a)
	or die ("error buscando".$a);
	$cant=mysqli_num_rows($b);
	$m=mysqli_fetch_array ($b);	
	$Apellido=$m['Nombrefam'];
$a="SELECT * FROM `records2` WHERE `Publicador` = $Idpublicador AND Mes = $mes AND Anio=$anio";
	$b = mysqli_query ($con,$a)
	or die ("error buscando".$a);
	$cant=mysqli_num_rows($b);
	$m=mysqli_fetch_array ($b);	
	$Publicaciones="";
		$Videos="";
		$Horas="";
		$Revisitas="";
		$Estbib="";
		$Precuaux="";
		$Precureg=""; 	
		$Notas="";
		$Textoboton="Guardar datos";
		$accion="agregandoinforme(".$Idpublicador.",".$mes.",".$anio.")";
	if ($cant!=0)
	{
		$Textoboton="Modificar datos";
		$accion="editandoinforme(".$Idpublicador.",".$mes.",".$anio.")";
		$Publicaciones=$m['Publicaciones'];
		$Videos=$m['Videos'];
		$Horas=$m['Horas'];
		$Revisitas=$m['Revisitas'];
		$Estbib=$m['Estbib'];
		$Precuaux=$m['Precaux'];
		$Precureg=$_GET['Precreg']; 	
		$Notas=$m['Notas'];
	}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Mi informe</title>
<link href="css/bootstrap.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/jquery/jquery.js"> </script>
<link rel="stylesheet" type="text/css"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700"> <link rel="stylesheet" href="css/style.css">
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<script type="text/javascript">
function aparecermensajedeerror(elemento,mensaje)
	{
		$("#"+elemento).html(mensaje);
		$("#"+elemento).css("display","block");
	}
	function desaparecermensajedeerror(elemento)
	{
		$("#"+elemento).css("display","none");
	}
function editandoinforme(publicador,mes,anio)
{
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
		if (publicaciones=="" || isNaN(publicaciones) || videos=="" || isNaN(videos) || horas=="" || isNaN(horas)  || revisitas==""  || isNaN(revisitas) ||  estudios==""  || isNaN(estudios) || notas=="" || precuaux==true && precureg==true || (publicaciones=="0" && videos=="0" && horas=="0" && revisitas=="0" && estudios=="0")|| (publicaciones<0 || videos<0 || horas<0 || revisitas<0 || estudios<0))
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
			else 
			{
				if (publicaciones<0)
				{
					aparecermensajedeerror("errorpublicaciones","Debe ingresar un valor positivo");
					$("#publicaciones").attr("onkeyup","desaparecermensajedeerror('errorpublicaciones')");
				}
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
			else 
			{
				if (videos<0)
				{
					aparecermensajedeerror("errorvideos","Debe ingresar un valor positivo");
					$("#videos").attr("onkeyup","desaparecermensajedeerror('errorvideos')");
				}
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
			else 
			{
				if (horas<0)
				{
					aparecermensajedeerror("errorhoras","Debe ingresar un valor positivo");
					$("#horas").attr("onkeyup","desaparecermensajedeerror('errorhoras')");
				}
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
			else 
			{
				if (revisitas<0)
				{
					aparecermensajedeerror("errorrevisitas","Debe ingresar un valor positivo");
					$("#revisitas").attr("onkeyup","desaparecermensajedeerror('errorrevisitas')");
				}
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
			else 
			{
				if (estudios<0)
				{
					aparecermensajedeerror("errorestudios","Debe ingresar un valor positivo");
					$("#estudios").attr("onkeyup","desaparecermensajedeerror('errorestudios')");
				}
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
								$("#mensajefin").html(data);
								$("#mensajefin").css("display","block");
								setTimeout('$("#mensajefin").css("display","none");','5000');
							}
					}
				);
		}
}
function cerrarses()
	{
		document.location="scriptsphp/cerrarses.php";
	}
function redireccionar()
	{
		document.location="miinforme.php";
	}
function agregandoinforme(publicador,mes,anio)
	{
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
		if (publicaciones=="" || isNaN(publicaciones) || videos=="" || isNaN(videos) || horas=="" || isNaN(horas)  || revisitas==""  || isNaN(revisitas) ||  estudios==""  || isNaN(estudios) || notas=="" || precuaux==true && precureg==true || (publicaciones=="0" && videos=="0" && horas=="0" && revisitas=="0" && estudios=="0")|| (publicaciones<0 || videos<0 || horas<0 || revisitas<0 || estudios<0))
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
			else 
			{
				if (publicaciones<0)
				{
					aparecermensajedeerror("errorpublicaciones","Debe ingresar un valor positivo");
					$("#publicaciones").attr("onkeyup","desaparecermensajedeerror('errorpublicaciones')");
				}
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
			else 
			{
				if (videos<0)
				{
					aparecermensajedeerror("errorvideos","Debe ingresar un valor positivo");
					$("#videos").attr("onkeyup","desaparecermensajedeerror('errorvideos')");
				}
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
			else 
			{
				if (horas<0)
				{
					aparecermensajedeerror("errorhoras","Debe ingresar un valor positivo");
					$("#horas").attr("onkeyup","desaparecermensajedeerror('errorhoras')");
				}
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
			else 
			{
				if (revisitas<0)
				{
					aparecermensajedeerror("errorrevisitas","Debe ingresar un valor positivo");
					$("#revisitas").attr("onkeyup","desaparecermensajedeerror('errorrevisitas')");
				}
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
			else 
			{
				if (estudios<0)
				{
					aparecermensajedeerror("errorestudios","Debe ingresar un valor positivo");
					$("#estudios").attr("onkeyup","desaparecermensajedeerror('errorestudios')");
				}
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
							$("#mensajefin").html(data);
							$("#mensajefin").css("display","block");
							setTimeout('$("#mensajefin").css("display","none");','5000');
							setTimeout("redireccionar()","5500");
						}
				}
			);	
		}
	}
	function cambiandocontrasena(publicador)
	{
		newpass=$("#newpass").val();
		renewpass=$("#renewpass").val();
		conactual=$("#conactual").val();
		if (newpass==renewpass)
		{
			if (newpass==conactual)
			{
				aparecermensajedeerror("errornewpass","No se ha producido ningun cambio");
				$("#newpass").attr("onkeyup","desaparecermensajedeerror('errornewpass')");
				$("#renewpass").attr("onkeyup","desaparecermensajedeerror('errornewpass')");
			}
			else
			{
					$.ajax(
					{
						async:true,
						type:"GET",
						cache:false,
						url:"scriptsphp/cambiarcontrasena.php?Publicador="+publicador+"&NewContr="+newpass,
						success: function(data)
							{
								aparecermensajedeerror("errornewpass",data);
								$("#contractual").html(newpass);
								$("#conactual").val(newpass);
								setTimeout('$("#errornewpass").css("display","none");','5000');
								setTimeout("volveratras()","5500");
							}
					}
				);	
			}
		}
		else
		{
			aparecermensajedeerror("errornewpass","Las contraseñas no coinciden");
			$("#newpass").attr("onkeyup","desaparecermensajedeerror('errornewpass')");
			$("#renewpass").attr("onkeyup","desaparecermensajedeerror('errornewpass')");
		}
	}
	function cambiarcontrasena()
	{
		$("#forminforme").slideUp();
		$("#contrasenia").slideDown();
	}
	function volveratras()
	{
		$("#forminforme").slideDown();
		$("#contrasenia").slideUp();
		$("#newpass").val("");
		$("#renewpass").val("");
	}
</script>
<style type="text/css">
body{
	font-family:'Source Sans Pro', Helvetica, Arial, sans-serif;
	background: rgba(226,226,226,1);
background: -moz-linear-gradient(-45deg, rgba(226,226,226,1) 0%, rgba(219,219,219,1) 0%, rgba(209,209,209,1) 6%, rgba(254,254,254,1) 100%);
background: -webkit-gradient(left top, right bottom, color-stop(0%, rgba(226,226,226,1)), color-stop(0%, rgba(219,219,219,1)), color-stop(6%, rgba(209,209,209,1)), color-stop(100%, rgba(254,254,254,1)));
background: -webkit-linear-gradient(-45deg, rgba(226,226,226,1) 0%, rgba(219,219,219,1) 0%, rgba(209,209,209,1) 6%, rgba(254,254,254,1) 100%);
background: -o-linear-gradient(-45deg, rgba(226,226,226,1) 0%, rgba(219,219,219,1) 0%, rgba(209,209,209,1) 6%, rgba(254,254,254,1) 100%);
background: -ms-linear-gradient(-45deg, rgba(226,226,226,1) 0%, rgba(219,219,219,1) 0%, rgba(209,209,209,1) 6%, rgba(254,254,254,1) 100%);
background: linear-gradient(135deg, rgba(226,226,226,1) 0%, rgba(219,219,219,1) 0%, rgba(209,209,209,1) 6%, rgba(254,254,254,1) 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#e2e2e2', endColorstr='#fefefe', GradientType=1 );
}
h2,h3,h4,h5,p,label,span{
	color:rgba(226,226,226,1);
}
.mensaje{
	display:none; color:rgba(186,237,253,1.00);}
#myinf{
	width: 100%;
	padding: 20px 10px;
	background: rgba(0,0,0,0.4);
	border-radius: 4px;
	-moz-border-radius: 4px;
	-webkit-border-radius: 4px;
	margin: 50px auto;
	}
</style>
</head>

<body>
<div id="myinf">
 <div id="forminforme">
     <div class="container">
        <div class="row">
          <div class="col-xs-12 form-group">
            <h2><? echo "Informe de ".$mesmue."/".$anio;?></h2>
            <h3><? echo "Publicador/a : ".$Nombre." ".$Apellido;?></h3>
          </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
          <div class="col-xs-12 form-group">
            <div class="input-group"><span class="input-group-addon">Publicaciones</span>
                <input type="text" class="form-control" placeholder="Impresas o electrionicas" maxlength="3" value="<? echo $Publicaciones;?>" id="publicaciones">
              </div>
            </div>
            <div class="col-xs-12 form-group">
                <span id="errorpublicaciones" class="mensaje"></span>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
          <div class="col-xs-12 form-group">
            <div class="input-group"><span class="input-group-addon">Videos</span>
                <input type="text" class="form-control" placeholder="Presentaciones de videos"  maxlength="3" value="<? echo $Videos;?>" id="videos">
              </div>
            </div>
          <div class="col-xs-12 form-group">
                <span id="errorvideos" class="mensaje"></span>
            </div>
        </div>
    </div>
      
      <div class="container">
        <div class="row">
            <div class="col-xs-12 form-group">
            <div class="input-group"><span class="input-group-addon">Horas</span>
                <input type="text" class="form-control" placeholder="Horas en el ministerio"  maxlength="3" value="<? echo $Horas;?>" id="horas">
              </div>
            </div>
            <div class="col-xs-12 form-group">
                <span id="errorhoras" class="mensaje"></span>
            </div>
        </div>
    </div>
    
    <div class="container">
        <div class="row">
            <div class="col-xs-12 form-group">
            <div class="input-group"><span class="input-group-addon">Revisitas</span>
                <input type="text" class="form-control" placeholder="Cantidad de revisitas"  maxlength="3" value="<? echo $Revisitas;?>"id="revisitas">
              </div>
            </div>
            <div class="col-xs-12 form-group">
                <span id="errorrevisitas" class="mensaje"></span>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 form-group">
            <div class="input-group"><span class="input-group-addon">Estudios biblicos</span>
                <input type="text" class="form-control" placeholder="Cantidad de cursos biblicos"  maxlength="3" value="<? echo $Estbib;?>"id="estudios">
              </div>
            </div>
            <div class="col-xs-12 form-group">
                <span id="errorestudios" class="mensaje"></span>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-xs-6 form-group" <? if ($Precreg=="SI") {?> style="display:none"<? }?>>
                <div class="checkbox">
                  <label><input type="checkbox" value="" id="precuaux">Tome el precursorado auxiliar</label>
                </div>
            </div>
            <div class="col-xs-6 form-group" <? if ($Precreg=="NO") {?> style="display:none"<? }?>>
                <div class="checkbox">
                  <label><input type="checkbox" value="" id="precureg" <? if ($Precreg=="SI") {?> readonly disabled checked="checked"<? }?>>Precursor/a regular</label>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 form-group">
            <div class="input-group"><span class="input-group-addon">NOTAS</span>
              <textarea name="textarea" id="notas" class="form-control" placeholder="Detalles relevantes relacionados a la actividad del mes"><? echo $Notas;?></textarea>
            </div>
            </div>
            <div class="col-xs-12 form-group">
                <span id="errornotas" class="mensaje"></span>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
        <div class="col-xs-12 form-group" style="text-align:center">
                <h4 id="mensajefin" style="display:none"></h4>
            </div>
            <div class="col-xs-12 form-group">
                <button type="button" class="btn btn-primary center-block" onClick="<? echo $accion;?>"><? echo $Textoboton;?></button>
            </div>
            
            <div class="col-xs-12 form-group">
                <button type="button" class="btn btn-primary center-block" onClick="cerrarses();">Cerrar sesion</button>	
            </div>
            <div class="col-xs-12 form-group">
                <button type="button" class="btn btn-primary center-block" onClick="cambiarcontrasena()">Cambiar contraseña</button>
            </div>
        </div>
    </div>
 </div>
 <div id="contrasenia" style="display:none">
 	<div class="container">
        <div class="row">
          <div class="col-xs-12 form-group">
            <h3><? echo 'Contraseña actual : <span id="contractual">'.$Passpub.'</span>';?></h3>
            <input type="hidden" value="<? echo $Passpub;?>" id="conactual">
          </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
          <div class="col-xs-12 form-group">
            <div class="input-group"><span class="input-group-addon">Nueva contraseña</span>
                <input type="password" class="form-control" placeholder="Nueva contraseña" maxlength="15" id="newpass">
              </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
          <div class="col-xs-12 form-group">
            <div class="input-group"><span class="input-group-addon">Repita la contraseña</span>
                <input type="password" class="form-control" placeholder="Nueva contraseña"  maxlength="15" id="renewpass">
              </div>
            </div>
          <div class="col-xs-12 form-group center-block">
                <h4 id="errornewpass" class="mensaje"></h4>
            </div>
        </div>
    </div>
    <div class="container">
	<div class="row">
        <div class="col-xs-12 form-group">
			<button type="button" class="btn btn-primary center-block" onClick="cambiandocontrasena(<? echo $Idpublicador;?>)">Guardar nueva contraseña</button>
        </div>
        <div class="col-xs-12 form-group">
			<button type="button" class="btn btn-primary center-block" onClick="volveratras()">Volver atras</button>
        </div>
    </div>
</div>
 </div>
</div>
</body>
</html>
