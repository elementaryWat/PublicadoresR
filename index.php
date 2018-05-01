<?
session_start();
if ($_SESSION["idusrecor"]==0)
{
	header ("Location:inicioses.php");
}
$idusuario=$_SESSION["idusrecor"];
$Categoria=$_SESSION["Categoriarec"];
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

if ($Categoria== 2)
{
	header ("Location:agregarinforme.php");
}
$Email=$_SESSION["Email"];
$Nombre=$_SESSION["Nombre"];
$Apellido=$_SESSION["Apellido"];
$Grupo=$_SESSION["Grupo"];
$aa="select Usuario,Pass from usuarios where Iduser=$idusuario";
$bb=mysqli_query($con,$aa) or die ("error buscando ".$aa);
$mref=mysqli_fetch_array($bb);
$usuario=$mref["Usuario"];
$passus=$mref["Pass"];
//Cuenta de publicadores
$ab="SELECT publicadores.`Idpublicadores` FROM  `publicadores` INNER JOIN familias ON publicadores.Familia = familias.idfamilia AND familias.Congregacion =$Congre";
$ba=mysqli_query($con,$ab) or die ("error buscando ".$ab);
$cantTot=mysqli_num_rows($ba);
$ab="SELECT publicadores.`Idpublicadores` FROM  `publicadores` INNER JOIN familias ON publicadores.Familia = familias.idfamilia AND familias.Congregacion =$Congre AND publicadores.Anciano='SI'";
$ba=mysqli_query($con,$ab) or die ("error buscando ".$ab);
$cantAnc=mysqli_num_rows($ba);
$ab="SELECT publicadores.`Idpublicadores` FROM  `publicadores` INNER JOIN familias ON publicadores.Familia = familias.idfamilia AND familias.Congregacion =$Congre AND publicadores.Siervomin='SI'";
$ba=mysqli_query($con,$ab) or die ("error buscando ".$ab);
$cantSiervoM=mysqli_num_rows($ba);
$ab="SELECT publicadores.`Idpublicadores` FROM  `publicadores` INNER JOIN familias ON publicadores.Familia = familias.idfamilia AND familias.Congregacion =$Congre AND publicadores.Precreg='SI'";
$ba=mysqli_query($con,$ab) or die ("error buscando ".$ab);
$cantPrecR=mysqli_num_rows($ba);
$ab="SELECT publicadores.`Idpublicadores` FROM  `publicadores` INNER JOIN familias ON publicadores.Familia = familias.idfamilia AND familias.Congregacion =$Congre AND publicadores.Precreg='NO'";
$ba=mysqli_query($con,$ab) or die ("error buscando ".$ab);
$cantPubl=mysqli_num_rows($ba);
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
var congregacionuser;
		var cantidaddint;
	$(document).ready(function(e) {
        botonprueba=$("#prueba");
		obtenerpublicadores("");
		$("#filtrop").accordion({ heightStyle: "content",active: 0,collapsible: true});
		$( "#tipoher" ).buttonset();
		$("#addher").button();
		$("#delher").button();
		$("#lastsix").button();
		$("#ellher").button();
    });
function aparecermensajedeerror(elemento,mensaje)
	{
		$("#"+elemento).html(mensaje);
		$("#"+elemento).css("display","block");
		$("#"+elemento).css("color","#F00");
	}
	function desaparecermensajedeerror(elemento)
	{
		$("#"+elemento).css("display","none");
	}
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
/*--------------------------------------Agregando publicadores------------------------------*/
	function agregarhermano()
	{
		dialogodestino=$("#dialogoher");
		dialogodestino.dialog({resizable: false,width:"auto",show:{effect:"fold",duration:"2000"},hide:{effect:"fold",duration:"2000"}});
	}
	function compelher()
	{
		var listahermel= new Array();
		$("input:checkbox[id^=check]:checked").each(function(){
			listahermel.push(this.attributes["name"].value);
		});
		var canteh=listahermel.length;
		var mensaje="";
		var lisssth="";
		if (canteh!=0)
		{
			for (i=0;i<canteh;i++)
			{
				lisssth+='<tr><td colspan="2" align="center"><strong>'+listahermel[i]+'</strong><td></tr>';
			}
			mensaje='<table width="100%" border="0">'
              +'<tbody>'
               +'<tr>'
                  +'<td colspan="2" align="center">Esta seguro de que desea eliminar a estos hermanos de la lista de publicadores</td>'
                +'</tr>'+lisssth
                +'<tr>'
                  +'<td width="50%" align="center"><button id="sielh" onclick="eliminarhermano()">Si</button></td>'
                  +'<td width="50%" align="center"><button id="noelh">No</button></td>'
                +'</tr>'
              +'</tbody>'
            +'</table>';
			$("#mensajecelh").html(mensaje);
			$("#sielh").button();
			$("#noelh").button();
			$("#noelh").click(function(e) {
                $("#compelher").dialog( "close" );
            });
		} else
		{
			mensaje='<p>No se selecciono nigun hermano para eliminar</p>';
			$("#mensajecelh").html(mensaje);
		}
		var dialogocompeh=$("#compelher");
		dialogocompeh.dialog({resizable: false,width:"auto",show:{effect:"fold",duration:"2000"},hide:{effect:"fold",duration:"2000"}});
	}
	function eliminarhermano()
	{
		var listahermel= new Array();
		$("input:checkbox[id^=check]:checked").each(function(){
			listahermel.push($(this).val());
		});
		for (i=0;i<listahermel.length;i++)
		{
			eliminandoher(listahermel[i]);
		}
		setTimeout("comprobarfamilias()","2000");
		setTimeout("obtenerpublicadores('')","3000");
	}
	function verlastsix()
	{
		dialogoinsercion=$("#contenlastmonths");
		var criterio='';
		criterio=$("input[name=filtro]:checked").val();
		$.ajax(
				{
					async:true,
					type:"GET",
					cache:false,
					url:"scriptsphp/resumenactividad.php?criterio="+criterio,
					success: function(data)
						{
							dialogoinsercion.html(data);
							$("#dialogolastsix").css("display","block");
							$("#dialogolastsix").dialog({resizable: false,width:"auto",show:{effect:"explode",duration:"2000"},hide:{effect:"explode",duration:"2000"}});
						}
				}
			);
	}
	function comprobarfamilias()
	{
		$.ajax(
				{
					async:true,
					type:"GET",
					cache:false,
					url:"scriptsphp/eliminarherm.php?id="+id,
					success: function(data)
					{
						obtenerspublicadores("");
					}
				}
			);
	}
	function eliminandoher(id)
	{
		$.ajax(
				{
					async:true,
					type:"GET",
					cache:false,
					url:"scriptsphp/eliminarherm.php?id="+id,
					success: function(data)
					{
						obtenerspublicadores("");
					}
				}
			);
	}
//Esta funcion es para restablecer los valores originales del dialogo para agregar familias/hermanos
	function reiniciarvaloresadd()
	{

	}
	//Esta funcion se encarga de comprobar la existencia de una familia y agregarla en caso de que no exista
	function comprobandofam(familia,cantidaddint)
	{
		var divmensajefam=$("#mensajefamilia");
		//En esta parte comprueba se no existe una familia con el mismo nombre
		//Para eso hace una peticion al servidor de un archivo php que devuelve si
		//en caso de que exista la familia y en caso contrario no
		$.ajax(
				{
					async:true,
					type:"GET",
					cache:false,
					url:"scriptsphp/compexisfam.php?familia="+familia+"&congregacion="+congregacionuser,
					success: function(data)
					{
						if (data=="si")
						{
						divmensajefam.html("<p>Ya existe una familia con este apellido</p><p>Luego de introducir el apellido ingrese la inicial de un miembro para poder distinguirla a la familia (Por ejemplo Lopez J.)</p>");
						divmensajefam.css("display","block");
						divmensajefam.css("color","#F00");
						} else if (data=="no")
						{
						agregandofamilia(familia,cantidaddint);
						}

					}
				}
			);
	}
	//Esta funcion se encarga de agregar la familia recibiendo como parametro el nombre de la familia y la cantidad de integrantess
	function agregandofamilia(familia,cantidaddint)
	{
		var divmensajefam=$("#mensajefamilia");
		$.ajax(
				{
					async:true,
					type:"GET",
					cache:false,
					url:"scriptsphp/agregarfam.php?familia="+familia+"&congregacion="+congregacionuser,
					success: function(data)
					{
						if (data=="agregado")
						{
						divmensajefam.html("<p>La familia ha sido agregada con exito</p>");
						divmensajefam.css("display","block");
						divmensajefam.css("color","#3FB73C");
						consultarcodfam(cantidaddint);
						}
					}
				}
			);
	}
	//Esta funcion se encarga de consultar el codigo de la ultima familia agregada es decir de la actual
	function consultarcodfam(cantidaddint)
	{
		var divmensajefam=$("#mensajefamilia");
		$.ajax(
				{
					async:true,
					type:"GET",
					cache:false,
					url:"scriptsphp/consultarfam.php",
					success: function(data)
					{
						agregarmiembros(data,cantidaddint);
					}
				}
			);
	}
	//Esta funcion se encarga de comprobar el valor de todos los inputs de hermanos
	//En caso de que no encuentre ningun error va agregandolos de a uno llamando a la funcion agregandomiembros
	function agregarmiembros(familia,cantidaddint)
	{
		var divmensajehermanos=$("#mensajehermanos");
		divmensajehermanos.html("");
		var cante=0;
		var cantr=0;
		//Esta seccion se encarga de comprobar que se hayan ingresado todos los valores
		for (x=0;x<cantidaddint;x++)
		{
			var inputint=$("input[name=int"+x+"]").val();
			if (inputint=="")
			{
				cante++;
			}
		}
		//Esta seccion se encarga de comprobar que no se hayan ingresado valores repetidos
		for (x=0;x<(cantidaddint-1);x++)
		{
			var inputint1=$("input[name=int"+x+"]").val();
			for (y=x+1;y<cantidaddint;y++)
			{
				var inputint2=$("input[name=int"+y+"]").val();
				if (inputint1==inputint2)
				{
					cantr++;
				}
			}

		}
		if (cante>0)
		{
			divmensajehermanos.html("<p>No se han ingresados los nombres de algunos hermanos</p>");
			divmensajehermanos.css("display","block");
			divmensajehermanos.css("color","#F00");
		}
		else
		{
			if (cantr>0)
			{
			divmensajehermanos.append("<p>Se han ingresado nombres repetidos</p>");
			divmensajehermanos.css("display","block");
			divmensajehermanos.css("color","#F00");
			}
			else
			{
				//En el caso de que no hay ningun error se va agregando a cada hermano de a uno
				for (x=0;x<cantidaddint;x++)
				{
					var inputint=$("input[name=int"+x+"]").val();
					agregandomiembros(inputint,familia);
				}
				if (cantidaddint=1)
				{
					divmensajehermanos.append("<p>El hermano ha sido agregado. Modifique sus detalles en la pagina principal</p>");
				} else
				{
					divmensajehermanos.append("<p>Todos los hermanos han sido agregados. Modifique sus detalles en la pagina principal</p>");
				}
				divmensajehermanos.css("display","block");
				divmensajehermanos.css("color","#3FB73C");
				//Cuando termina de agregar todos los hermanos y las familias vuelve a cargar la lista de publicadores en el select
				setTimeout("obtenerpublicadores('')","3000")
			}

		}
	}
	function agregandomiembros(hermano,familia)
	{
		$.ajax(
				{
					async:true,
					type:"GET",
					cache:false,
					url:"scriptsphp/agregamiembro.php?hermano="+hermano+"&familia="+familia,
				}
			);
	}
//Esta funcion es llamada cuando se desea agregar una familia nueva con todos sus integrantes
	function agregarfamilian()
	{
		var divmensajefam=$("#mensajefamilia");
		var inpfamilia=$("input[name=familia]").val();
		if (inpfamilia=="")
		{
			divmensajefam.html("No se ha ingresado el apellido de la familia");
			divmensajefam.css("display","block");
			divmensajefam.css("color","#F00");
		}
		else
		{
			comprobandofam(inpfamilia,cantidaddint);
		}
	}
//Esta funcion es llamada cuando la opcion seleccionada es agregar a familia existente
	function agregarhermanos()
	{
		var selectfamilia=$("select[name=familiass]").val();
		agregarmiembros(selectfamilia,cantidaddint);
	}
	function agregarintegrantes()
{
	divmensaje=$("#mensajee");
	var cantidadint=$("input[name=integrantes]").val();
	//asignacion a la variable global
	cantidaddint=cantidadint;
	var divintegrantes=$("#integrantess");
	if (cantidadint==0 || cantidadint=="" || cantidadint>20 || isNaN(cantidadint))
	{
		if (cantidadint==0)
		{
			aparecermensajedeerror("mensajee","La cantidad ingresada no es valida");
			$("input[name=integrantes]").attr("onkeyup","desaparecermensajedeerror('mensajee')");
		}
		if (cantidadint=="")
		{
			aparecermensajedeerror("mensajee","No se ha ingresado la cantidad de integrantes");
			$("input[name=integrantes]").attr("onkeyup","desaparecermensajedeerror('mensajee')");
		}
		if (cantidadint>20)
		{
			aparecermensajedeerror("mensajee","Demasiados integrantes para una familia");
			$("input[name=integrantes]").attr("onkeyup","desaparecermensajedeerror('mensajee')");
		}
		if (isNaN(cantidadint))
		{
			aparecermensajedeerror("mensajee","Esto no es un numero");
			$("input[name=integrantes]").attr("onkeyup","desaparecermensajedeerror('mensajee')");
		}
	}
	else
	{
		divintegrantes.html("");
		for (x=0;x<cantidadint;x++)
		{
			divintegrantes.append('<tr>r<td>Nombre del hermano numero '+(x+1)+'</td><td><input name="int'+x+'" id="detaherman'+x+'" type="text" /></td></tr>');
		}
		//Agrega un div donde mostrar el estado de los hermanos
		divintegrantes.append('<span id="mensajehermanos"></span>');
		switch (tipofam)		//Dependiendo del valor de la variable global que almacena el tipo de la familia

		{
			case 'nueva':
			divintegrantes.append('<table><tr><td><input type="button" id="newintegrant" value="Modificar cantidad"/></td></tr>'+
		'<tr><td><input type="button" id="newfamilia"  data-theme="a" value="Añadir familia"/></td></tr></table>');
			break;
			case 'existente':
			divintegrantes.append('<table><tr><td><input type="button" id="newintegrant" value="Modificar cantidad"/></td></tr>'+
		'<tr><td><input type="button" id="newbrothers"  data-theme="a" value="Añadir hermanos a familia"/></td></tr></table>');
			break;
		}
		var botonnewin=$("#newintegrant");
		botonnewin.button();
		botonnewin.click(agregarintegrantes);
		var botonnewfam=$("#newfamilia");
		botonnewfam.button();
		botonnewfam.click(agregarfamilian);
		var botonnewbro=$("#newbrothers");
		botonnewbro.button();
		botonnewbro.click(agregarhermanos);
		for (x=0;x<cantidadint;x++)
		{
			$("#detaherman"+x).attr("onkeyup","desaparecermensajedeerror('mensajehermanos')");
		}
	}
}

function anadiendo(listafamialias)
			{
				var divdefinicionfamilia=$("#definiendohermano");
				divdefinicionfamilia.html('<table><tr><td>Familia</td><td>'+listafamialias+
			 ' </td></tr><tr><td>Ingrese la cantidad de hermanos</td><td><input name="integrantes" type="text" />'+
			  '<span id="mensajee"></span></td></tr>'+
			  '<tr><td colspan="2" align="center"><span id="integrantess">'+
			  '<input name="familia" type="button" id="newintegrant" value="Añadir integrantes"/>'+
			 '</span></td></tr></table>');
				var botonnewin=$("#newintegrant");
				botonnewin.button();
				botonnewin.click(agregarintegrantes);
				//Cuando se pulsa sobre el boton con la id anterior se llama a la funcionagregarintegrantes
				var cantidadint=$("input[name=integrantes]");
				$("#cantidadint").attr("onkeyup","desaparecermensajedeerror('mensajee')");
			}
	function definirtipoadd(valoropcion)
{
	congregacionuser=<? echo $Congre;?>;
	var divdefinicionfamilia=$("#definiendohermano");
	tipofam=valoropcion;
	switch(valoropcion)
	{
		case 'existente':
		$.ajax(
				{
					async:true,
					type:"GET",
					cache:false,
					url:"scriptsphp/obtenerfamilias.php?congregacion="+congregacionuser,
					success: function(data)
					{

						var listafamialias=data;
						if (listafamialias=="no")
						{
							divdefinicionfamilia.html("<p>No existen familias actualmente</p><p>Seleccione la opcion 'Añadir familia nueva'</p>");
							divdefinicionfamilia.css("color","#F00");
						}
						else
						{
							divdefinicionfamilia.css("color","#36AD29");
							anadiendo(listafamialias);
						}
					}
				}
		);
		break;
		case 'nueva':
		divdefinicionfamilia.html('<table><tr><td>Ingrese el apellido de la familia</td><td><input name="familia" type="text" />'+
		'<span id="mensajefamilia"></span></td></tr>'+
	 ' <tr><td>Cantidad de integrantes</td><td><input name="integrantes" type="text" />'+
      '<span id="mensajee"></span></td></tr>'+
      '<tr><td colspan="2"><span id="integrantess">'+
      '<input type="button" id="newintegrant" value="Añadir integrantes"/>'+
     '</span></td></tr></table>');
		break;
	}
	var botonnewin=$("#newintegrant");
	botonnewin.button();
	botonnewin.click(agregarintegrantes);
	//Cuando se pulsa sobre el boton con la id anterior se llama a la funcionagregarintegrantes
	$("input[name=familia]").attr("onkeyup","desaparecermensajedeerror('mensajefamilia')");
	$("input[name=integrantes]").attr("onkeyup","desaparecermensajedeerror('mensajee')");
}
/*-----------------------------------------------------------------------------------------------*/
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
						}
				}
			);
	}
	function obtenerspublicadores(busqueda)
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
		divpublicadoress=$("#lelher");
		$.ajax(
				{
					async:true,
					type:"GET",
					cache:false,
					url:"scriptsphp/obtenerspublicadores.php?rango="+rangoa+"&busqueda="+busqueda+"&criterio="+criterio,
					success: function(data)
						{
							divpublicadoress.html(data);
							$("input[id ^= check]").button();
							$("#dialogoelher").dialog({resizable: false,width:"auto",show:{effect:"fold",duration:"2000"},hide:{effect:"fold",duration:"2000"}});

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
					var myD=new Date();
					console.log(myD.getFullYear());
					dialogodestino.html(data);
					dialogodestino.css("display","block");
					dialogodestino.dialog({resizable: false,width:"auto",show:{effect:"fold",duration:"2000"},hide:{effect:"fold",duration:"2000"}});
					$("#fechaanac").datepicker({showAnim: "slideDown",changeMonth: true,changeYear: true,yearRange: "1925:"+myD.getFullYear()});
					$("#fechaabau").datepicker({showAnim: "slideDown",changeMonth: true,changeYear: true,yearRange: "1960:"+myD.getFullYear()});
					$("#fechanomb").datepicker({showAnim: "slideDown",changeMonth: true,changeYear: true,yearRange: "1980:"+myD.getFullYear()});
					$("#editardetails").button();
				}
			}
		);
	}
	function editandodetalles(idpublicador)
	{
		Nombre=$("#publicador").val();
		dni=$("#dni").val();
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
		if (Nombre=="" || dni=="" || isNaN(dni) || domicilio=="" || telefono=="" || isNaN(telefono) || celular=="" || isNaN(celular) || Fechabau=="" && Bautisino=="SI" || ((idpreccu=="" || fechanomb=="") || (isNaN(idpreccu))) && Precreg=="SI")
		{
			if (Nombre=="")
			{
				aparecermensajedeerror("errorpublicador","El nombre no ha sido ingresado");
				$("#publicador").attr("onkeyup","desaparecermensajedeerror('errorpublicador')");
			}
			if (isNaN(dni))
			{
				aparecermensajedeerror("errordni","Esto no es un numero");
				$("#dni").attr("onkeyup","desaparecermensajedeerror('errordni')");
			}
			if (dni=="")
			{
				aparecermensajedeerror("errordni","El dni no ha sido ingresado. En caso de no haber datos ingrese un 0");
				$("#dni").attr("onkeyup","desaparecermensajedeerror('errordni')");
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
				aparecermensajedeerror("errortelefono","El telefono no ha sido ingresado. En caso de no haber datos ingrese un 0");
				$("#telefono").attr("onkeyup","desaparecermensajedeerror('errortelefono')");
			}
			if (isNaN(celular))
			{
				aparecermensajedeerror("errorcelular","Esto no es un numero");
				$("#celular").attr("onkeyup","desaparecermensajedeerror('errorcelular')");
			}
			if (celular=="")
			{
				aparecermensajedeerror("errorcelular","El celular no ha sido ingresado. En caso de no haber datos ingrese un 0");
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
					url:"scriptsphp/editarpublicador.php?publicador="+idpublicador+"&Nombre="+Nombre+"&dni="+dni+"&Grupo="+Grupo+"&Fechanac="+Fechanac+"&Fechabau="+Fechabau+"&Unguotro="+Unguotro+"&Sexo="+Sexo+"&Anciano="+Anciano+"&Siervomin="+Siervomin+"&Precreg="+Precreg+"&fechanomb="+fechanomb+"&idpreccu="+idpreccu+"&Domicilio="+domicilio+"&Telefono="+telefono+"&Celular="+celular+"&Bautisino="+Bautisino,
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
	function establecerpdf(indice)
	{
		var valorpdf=$("#textopdf"+indice).val();
		$.ajax(
				{
					async:true,
					type:"POST",
					url:"establecerpdf.php",
					data:"valorpdf="+valorpdf,
					cache:false,
					success: function(data)
					{
						var win = window.open("generarpdf.php", '_blank');
  						win.focus();
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
        <div id="dialogolastsix" style="display:none" title="Resumen de la actividad en los ultimos seis meses"><div id="contenlastmonths"></div></div>
        <div id="dialogo"></div>
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
         <div id="dialogoher" style="display:none" title="Agregar hermano">
                <div id="tipoher">
          <input name="tipoher" type="radio" id="radio1" value="existente" onchange="definirtipoadd(this.value)"/><label for="radio1">Agregar a familia existente</label>
         <input name="tipoher" type="radio" id="radio2" value="nueva" onchange="definirtipoadd(this.value)"/><label for="radio2">Añadir familia nueva</label>
      		</div>
             <span id="definiendohermano">

      		</span>
        </div>
        <div id="compelher" style="display:none" title="Agregar hermano">
        	<div id="mensajecelh"></div>

        </div>
        <div id="dialogoelher" style="display:none" title="Eliminar hermano/s">
              <div id="lelher"></div>
              <br />
              <table width="100%"><tr><td align="center"><input type="button" name="ellher" id="ellher" onclick="compelher()" value="Eliminar"/></td></tr></table>

        </div>
        <div id="datosdecuenta"></div>
		<div id="sidebar">
        <input type="button" name="addher" id="addher" onclick="agregarhermano()" value="Agregar hermano"/>
        <input type="button" name="delher" id="delher" onclick="obtenerspublicadores('')" value="Eliminar hermano"/>
        <input type="button" name="verultseismeses" id="lastsix" onclick="verlastsix()" value="Resumen ultimos seis meses"/>
        <div id="spubb"></div>
        <p></p>
        	<div id="filtrop">
            	<h2>Ver solo</h2>
            	<div>
                <p><label><input type="radio" name="filtro" checked="checked" onchange="obtenerpublicadores('')" value=""/>Todos (<? echo $cantTot;?>)</label></p>
                 <p><label><input type="radio" name="filtro" onchange="obtenerpublicadores('')" value="Publicadores"/>Publicadores (<? echo $cantPubl;?>)</label></p>
                <p><label><input type="radio" name="filtro" onchange="obtenerpublicadores('')" value="Ancianos"/>Ancianos (<? echo $cantAnc;?>)</label></p>
                <p><label><input type="radio" name="filtro" onchange="obtenerpublicadores('')" value="Siervosministeriales"/>Siervos ministeriales (<? echo $cantSiervoM;?>)</label></p>
                <p><label><input type="radio" name="filtro" onchange="obtenerpublicadores('')" value="Precursoresregulares"/>Precursores regulares (<? echo $cantPrecR;?>)</label></p></div>
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
