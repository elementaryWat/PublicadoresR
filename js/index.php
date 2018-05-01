<? 
session_start();
if ($_SESSION["idusrecor"]==0)
{
	header ("Location:inicioses.php");
}
$idusuario=$_SESSION["idusrecor"];
$Categoria=$_SESSION["Categoriarec"];
if ($Categoria== 2)
{
	header ("Location:agregarinforme.php");
}
$Email=$_SESSION["Email"];
$Nombre=$_SESSION["Nombre"];
$Apellido=$_SESSION["Apellido"];
$Grupo=$_SESSION["Grupo"];
$con=mysqli_connect("mysql.hostinger.com.ar","u300421416_root","registrospnb");
mysqli_select_db($con,"u300421416_regis") or die ("no se ha podido encontrar la base de datos");
$aa="select Usuario,Pass from usuarios where Iduser=$idusuario";	
$bb=mysqli_query($con,$aa) or die ("error buscando ".$aa);
$mref=mysqli_fetch_array($bb);
$usuario=$mref["Usuario"];
$passus=$mref["Pass"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Registro de publicadores</title>
<link rel="shortcut icon" href="images/Pagina/registro.png">
<link rel="stylesheet" type="text/css" href="style.css" media="screen" />
<link type="text/css" href="js/jquery/jquery-ui.css" rel="stylesheet" />
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
        botonprueba=$("#prueba");
		obtenerpublicadores("");
		$("#filtrop").accordion({ heightStyle: "content",active: 0,collapsible: true});
		$( "#tipoherm" ).buttonset();
		$("#addher").button();
    });
	function mostrarocultarbaut()
	{
		valorvista=$("input[name=sibaut]:checked").val();
		switch (valorvista)
		{
			case "SI":
				$("#bautismodate").show();
			break;
			case "NO":
				$("#bautismodate").hide();
			break;
		}
	}
	function mostrarocultarnom()
	{
		valorview=$("input[name=siprecr]:checked").val();
		switch (valorview)
		{
			case "SI":
				$("#nombradate").show();
			break;
			case "NO":
				$("#nombradate").hide();
			break;
		}
	}
	function agregarhermano()
	{
		dialogodestino=$("#dialogoher");
		dialogodestino.dialog({resizable: false,width:"auto",show:{effect:"fold",duration:"2000"},hide:{effect:"fold",duration:"2000"}});
	}
	function obtenerpublicadores(busqueda)
	{
		var criterio='';
		criterio=$("input[name=filtro]:checked").val();
		if (busqueda=="")
		{
			var rangoa="todo";
		}
		else
		{
			var rangoa="especifico";
		}
		divpublicadores=$("#datospub");
		$.ajax(
				{
					async:true,
					type:"GET",
					cache:false,
					url:"scriptsphp/obtenerpublicadores.php?rango="+rangoa+"&busqueda="+busqueda+"&criterio="+criterio,
					success: function(data)
						{
							divpublicadores.html(data);
							$("#acordeonpublicadores").accordion({ heightStyle: "content",active: false,collapsible: true});
							$("#acordeonpublicadores").enhanceWithin();
						}
				}
			);
	}
	function mostrarfamilia(familia)
	{
		alert("Se esta tratando de mostrar la familia "+familia);
	}
	function editarfamilia(familia)
	{
		alert("Se esta tratando de editar la familia "+familia);
	}
	function mostrardatosus()
	{
		dialogodestino=$("#dialogodus");
		dialogodestino.dialog({resizable: false,width:"auto",show:{effect:"fold",duration:"2000"},hide:{effect:"fold",duration:"2000"}});
	}
	function mostrarpublicador(publicador)
	{
		dialogodestino=$("#dialogo");
		$.ajax(
			{
				async:true,
				type:"GET",
				url:"scriptsphp/obtenerpublicador.php?publicador="+publicador+"&modo=vista",
				cache:false,
				success: function(data)
				{
					dialogodestino.html(data);
					dialogodestino.dialog({resizable: false,width:"auto",show:{effect:"fold",duration:"2000"},hide:{effect:"fold",duration:"2000"}});
					$("#acordeonregistroo").accordion({ heightStyle: "content",active: false,collapsible: true});
				}
			
			}
		);
	}
	function editarpublicador(publicador)
	{
		dialogodestino=$("#dialogo");
		$.ajax(
			{
				async:true,
				type:"GET",
				url:"scriptsphp/obtenerpublicador.php?publicador="+publicador+"&modo=edicion",
				cache:false,
				success: function(data)
				{
					dialogodestino.html(data);
					dialogodestino.css("display","block");
					dialogodestino.dialog({resizable: false,width:"auto",show:{effect:"fold",duration:"2000"},hide:{effect:"fold",duration:"2000"}});
					$("#fechaanac").datepicker({showAnim: "slideDown",changeMonth: true,changeYear: true,yearRange: "1925:2015"});
					$("#fechaabau").datepicker({showAnim: "slideDown",changeMonth: true,changeYear: true,yearRange: "1960:2015"});
					$("#fechanomb").datepicker({showAnim: "slideDown",changeMonth: true,changeYear: true,yearRange: "1980:2015"});
					$("#editardetails").button();
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
	function editandodetalles(idpublicador)
	{
		Nombre=$("#publicador").val();
		Grupo=$("#grupe").val();
		domicilio=$("#domicilio").val();
		telefono=$("#telefono").val();
		celular=$("#celular").val();
		Fechanac=$("#fechaanac").val();
		Bautisino=$("input[name=sibaut]:checked").val();
		Fechabau=$("#fechaabau").val();
		Unguotro=$("input[name=ungoutro]:checked").val();
		Sexo=$("input[name=sexo]:checked").val();
		Anciano=$("input[name=sianc]:checked").val();
		Siervomin=$("input[name=sisierv]:checked").val();
		Precreg=$("input[name=siprecr]:checked").val();
		idpreccu=$("#idpreccu").val();
		if (idpreccu=="")
		{
			idpreccu=0;
		}
		fechanomb=$("#fechanomb").val();
		dialogodestino=$("#dialogo");
		if (Nombre=="" || domicilio=="" || telefono=="" || isNaN(telefono) || celular=="" || isNaN(celular) || Fechabau=="" && Bautisino=="SI" || ((idpreccu=="" || fechanomb=="") || (isNaN(idpreccu))) && Precreg=="SI")
		{
			if (Nombre=="")
			{
				aparecermensajedeerror("errorpublicador","El nombre no ha sido ingresado");
				$("#publicador").attr("onkeyup","desaparecermensajedeerror('errorpublicador')");
			}
			if (domicilio=="")
			{
				aparecermensajedeerror("errordomicilio","El domicilio no ha sido ingresado. Ingrese un '-' en caso de no haber datos");
				$("#domicilio").attr("onkeyup","desaparecermensajedeerror('errordomicilio')");
			}
			if (isNaN(telefono))
			{
				aparecermensajedeerror("errortelefono","Esto no es un numero");
				$("#telefono").attr("onkeyup","desaparecermensajedeerror('errortelefono')");
			}
			if (telefono=="")
			{
				aparecermensajedeerror("errortelefono","El telefono no ha sido ingresado. En caso de que no haber datos ingrese un 0");
				$("#telefono").attr("onkeyup","desaparecermensajedeerror('errortelefono')");
			}
			if (isNaN(celular))
			{
				aparecermensajedeerror("errorcelular","Esto no es un numero");
				$("#celular").attr("onkeyup","desaparecermensajedeerror('errorcelular')");
			}
			if (celular=="")
			{
				aparecermensajedeerror("errorcelular","El celular no ha sido ingresado. En caso de que no haber datos ingrese un 0");
				$("#celular").attr("onkeyup","desaparecermensajedeerror('errorcelular')");
			}
			if (Fechabau=="")
			{
				if (Bautisino=="SI")
				{
					aparecermensajedeerror("errorfechabau","No se ha ingresado la fecha de bautismo");
					$("#fechaabau").attr("onchange","desaparecermensajedeerror('errorfechabau')");	
				}
			}
			if (Precreg=="SI")
			{
				if (isNaN(idpreccu))
				{
					aparecermensajedeerror("erroridprecu","Esto no es un numero");
					$("#idpreccu").attr("onkeyup","desaparecermensajedeerror('erroridprecu')");	
				}
				if (idpreccu=="")
				{
					aparecermensajedeerror("erroridprecu","No se ha ingresado el ID del/la precursor/a");
					$("#idpreccu").attr("onkeyup","desaparecermensajedeerror('erroridprecu')");	
				}
				if (fechanomb=="")
				{
					aparecermensajedeerror("errorfechanom","No se ha ingresado la fecha de nombramiento");
					$("#fechanomb").attr("onchange","desaparecermensajedeerror('errorfechanom')");	
				}
			}
		}
		else
		{
			if (Fechabau=="")
			{
				Fechabau="01/01/2000";
			}
			if (fechanomb=="")
			{
				fechanomb="01/01/2000";
			}
				$.ajax(
				{
					async:true,
					type:"GET",
					url:"scriptsphp/editarpublicador.php?publicador="+idpublicador+"&Nombre="+Nombre+"&Grupo="+Grupo+"&Fechanac="+Fechanac+"&Fechabau="+Fechabau+"&Unguotro="+Unguotro+"&Sexo="+Sexo+"&Anciano="+Anciano+"&Siervomin="+Siervomin+"&Precreg="+Precreg+"&fechanomb="+fechanomb+"&idpreccu="+idpreccu+"&Domicilio="+domicilio+"&Telefono="+telefono+"&Celular="+celular+"&Bautisino="+Bautisino,
					cache:false,
					success: function(data)
					{
						dialogodestino.html(data);
						dialogodestino.dialog({show:{effect:"explode",duration:"2000"},hide:{effect:"explode",duration:"2000"}});
					}
				}
			);	
		}
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
			<li class="active"><a href="#">Datos de publicadores</a></li>
            <? }?>
			<li><a href="agregarinforme.php">Agregar informes</a></li>
            <? if ($Categoria==1) {?>
            <li><a href="reuniones.php">Asistencia a reuniones</a></li>
            <? }?>
            <li><a href="#" onclick="mostrardatosus()">Datos de mi cuenta</a></li>
            <li><a href="scriptsphp/cerrarses.php">Cerrar sesion</a></li>
		</ul>
	</div>
	<div id="top-bar" class="container">
		<div class="bar">
			<div class="text" style="font-size:18px; color:#00C;">Buscador de publicadores por nombre<input type="text" name="busqueda" onkeyup="obtenerpublicadores(this.value)" /></div>
		</div>
	</div>
	<div id="page" class="container"><div class="inner_copy"></div>
		<div id="content">
			<div id="datospub">
            
            </div>
		</div>
        <div id="dialogo"></div>
        <div id="dialogodus" style="display:none">
        	<h2>Datos de mi cuenta</h2>
                <div>
                    <ul>
                    	<li><p>Nombre: <? echo $Nombre;?></p></li>
                        <li><p>Apellido: <? echo $Apellido;?></p></li>
                        <li><p>Grupo: <? echo $Grupo;?></p></li>
                        <li><p>Nombre de usuario: <span id="miuser"><? echo $usuario;?></span></p></li>
                        <li><p>Contraseña: <span id="mipasw"><? echo $passus;?></span></p></li>
                        <li><p>Correo electronico: <? echo $Email;?></p></li>
                        <li><h4><a href="javascript:" onclick="editardetallesdecuenta()">Editar nombre de usuario y/o contraseña</a></h4></li>
                    </ul>
                </div>
        </div>
         <div id="dialogoher" style="display:none">
        	<h2>Agregar hermano</h2>
                <div id="tipoherm">
          <label>Agregar a familia existente<input name="tipoher" type="radio" value="existente" onchange="definirtipoadd(this.value)"/></label>
          <label>Añadir familia nueva<input name="tipoher" type="radio" value="nueva" onchange="definirtipoadd(this.value)"/></label>
      		|</div>
        </div>
        
        <div id="datosdecuenta"></div>
		<div id="sidebar">
        <input type="button" name="addher" id="addher" onclick="agregarhermano()" value="Agregar hermano"/>
        <p></p>
        	<div id="filtrop">
            	<h2>Ver solo</h2>
            	<div>
                <p><label><input type="radio" name="filtro" checked="checked" onchange="obtenerpublicadores('')"/>Todos</label></p>
                <p><label><input type="radio" name="filtro" onchange="obtenerpublicadores('')" value="Ancianos"/>Ancianos</label></p>
                <p><label><input type="radio" name="filtro" onchange="obtenerpublicadores('')" value="Siervosministeriales"/>Siervos ministeriales</label></p>
                <p><label><input type="radio" name="filtro" onchange="obtenerpublicadores('')" value="Precursoresregulares"/>Precursores regulares</label></p></div>
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