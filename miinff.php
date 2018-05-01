<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Inicio de sesion</title>
<link rel="shortcut icon" href="images/Pagina/registro.png">
<link type="text/css" href="js/jquery/jquery-ui.css" rel="stylesheet" />
<script type="text/javascript" src="js/jquery/jquery.js"> </script>
<script type="text/javascript" src="js/jquery/jquery-ui.js"> </script>
<link rel="stylesheet" href="https://cdn.rawgit.com/twbs/bootstrap/v4-dev/dist/css/bootstrap.css" integrity="sha384-XXXXXXXX" crossorigin="anonymous">
<script src="https://cdn.rawgit.com/twbs/bootstrap/v4-dev/dist/js/bootstrap.js" integrity="sha384-XXXXXXXX" crossorigin="anonymous"></script>
<style type="text/css">
*{
  box-sizing:border-box;
  -moz-box-sizing:border-box;
  -webkit-box-sizing:border-box;
  font-family:arial;
}
body{background:url("http://www.galaxiastudio.com/wp-content/uploads/2014/03/DesertBlurredBG012.jpg")#FF9000}
h1{
  color:#AAA173;
  text-align:center;
  font-faimly:icon;
}

.login-form{
	width: 100%;
	padding: 40px 30px;
	background: rgba(0,0,0,0.4);
	border-radius: 4px;
	-moz-border-radius: 4px;
	-webkit-border-radius: 4px;
	margin: 50px auto;
}
.form-group{
  position: relative;
  margin-bottom:15px;
}
.form-control{
  width:100%;
  height:50px;
  border:none;
  padding:5px 7px 5px 15px;
  background:#fff;
  color:#6
  66;
  border:2px solid #E0D68F;
  border-radius:4px;
  -moz-border-radius:4px;
  -webkit-border-radius:4px;
}
.form-control:focus, .form-control:focus + .fa{
  border-color:#10CE88;
  color:#10CE88;
}
.form-group .fa{
  position: absolute;
  right:15px;
  top:17px;
  color:#999;
}
.log-status.right-entry {
  -webkit-animation: right-log 0.3s;
  -moz-animation: right-log 0.3s;
  -ms-animation: right-log 0.3s;
  animation: right-log 0.3s;
}
.log-status.right-entry .form-control, .right-entry .form-control + .fa {
  border-color: #37B145;
  color: #37B145;
}
.log-status.wrong-entry {
  -webkit-animation: wrong-log 0.3s;
  -moz-animation: wrong-log 0.3s;
  -ms-animation: wrong-log 0.3s;
  animation: wrong-log 0.3s;
}
.log-status.wrong-entry .form-control, .wrong-entry .form-control + .fa {
  border-color: #ed1c24;
  color: #ed1c24;
}
@keyframes wrong-log {
  0% { left: 0px;}
  20% {left: 15px;}
  40% {left: -15px;}
  60% {left: 15px;}
  80% {left: -15px;}
  100% {left: 0px;}
}
@-ms-keyframes wrong-log {
  0% { left: 0px;}
  20% {left: 15px;}
  40% {left: -15px;}
  60% {left: 15px;}
  80% {left: -15px;}
  100% {left: 0px;}
}
@-moz-keyframes wrong-log {
  0% { left: 0px;}
  20% {left: 15px;}
  40% {left: -15px;}
  60% {left: 15px;}
  80% {left: -15px;}
  100% {left: 0px;}
}
@-webkit-keyframes wrong-log {
  0% { left: 0px;}
  20% {left: 15px;}
  40% {left: -15px;}
  60% {left: 15px;}
  80% {left: -15px;}
  100% {left: 0px;}
}
@keyframes right-log {
  0% { top: 0px;}
  20% {top: 15px;}
  40% {top: -15px;}
  60% {top: 15px;}
  80% {top: -15px;}
  100% {top: 0px;}
}
@-ms-keyframes right-log {
  0% { top: 0px;}
  20% {top: 15px;}
  40% {top: -15px;}
  60% {top: 15px;}
  80% {top: -15px;}
  100% {top: 0px;}
}
@-moz-keyframes right-log {
  0% { top: 0px;}
  20% {top: 15px;}
  40% {top: -15px;}
  60% {top: 15px;}
  80% {top: -15px;}
  100% {top: 0px;}
}
@-webkit-keyframes right-log {
  0% { top: 0px;}
  20% {top: 15px;}
  40% {top: -15px;}
  60% {top: 15px;}
  80% {top: -15px;}
  100% {top: 0px;}
}
.log-btn{
  background:#0AC986;
  dispaly:inline-block;
  width:100%;
  font-size:16px;
  height:50px;
  color:#fff;
  text-decoration:none;
  border:none;
  border-radius:4px;
  -moz-border-radius:4px;
  -webkit-border-radius:4px;
}

.link{
  text-decoration:none;
  color:#9D8E79;
  display:block;
  text-align:right;
  font-size:12px;
  margin-bottom:15px;
}
.link:hover{
  text-decoration:underline;
  color:#8C918F;
}
.alert{
  display:none;
  font-size:12px;
  color:#f00;
  float:left;
}
</style>

<script type="text/javascript">
$(document).ready(function(e) {
    $("#ingreso").button();
	var boton=$("#ingreso");
	boton.click(iniciar);
	$("#dialogorecpass").css("display","none");
	$("#solicitar").button();
	var botonsol=$("#solicitar");
	botonsol.click(enviardatos);
	var input1=$("input[name=user]");
	input1.change(ocultar);
	input1.keyup(ocultar);
	var input2=$("input[name=pass]");
	input2.change(ocultar);
	input2.keyup(ocultar);
});
function ocultar()
	{
		var mensaje=$("#mensaje");
		mensaje.css("display","none");
		mensaje.html("");
	}
function redireccionar()
	{
		document.location="index.php";
	}
	function iniciar()
	{
		var mensaje=$("#mensaje");
		var usuario=$("input[name=user]").val();
		var pass=$("input[name=pass]").val();
		if (usuario=="" || pass=="")
		{
		mensaje.css("display","block");
		mensaje.css("color","#F00");
		mensaje.css("font-size","18px");
		mensaje.css("text-align","center");
			if (usuario=="" && pass=="")
			{
			mensaje.html("<p>No se ha ingresado ningun dato</p>");
			}else if (usuario=="")
			{
			mensaje.html("<p>No se ha ingresado el usuario</p>");	
			}else if (pass=="")
			{
			mensaje.html("<p>No se ha ingresado la contraseña</p>");
			}
		}
		else
		{
			$.ajax(
			{
				async:true,
				type:"GET",
				url:"scriptsphp/iniciandolases.php?usuario="+usuario+"&pass="+pass,
				cache:false,
				success: function(data)
					{
						if (data=="ok")
						{
							mensaje.css("display","block");
							mensaje.html("<p>Los datos ingresados son correctos</p><p>Espere unos segundos y sera redireccionado</p>");
							mensaje.css("color","#4AA663");
							mensaje.css("font-size","14px");
							mensaje.css("text-align","center");
							$('.log-status').addClass('right-entry');
							 $('.form-control').keypress(function(){
								$('.log-status').removeClass('right-entry');
							});
							setTimeout("redireccionar()","3000");
						} else if (data=="no")
						{
							mensaje.css("display","block");
							mensaje.html("<p>Nombre de usuario o contraseña incorrectos</p>");
							mensaje.css("color","#8B4849");
							mensaje.css("font-size","14px");
							mensaje.css("text-align","center");
							$('.log-status').addClass('wrong-entry');
							 $('.form-control').keypress(function(){
								$('.log-status').removeClass('wrong-entry');
							});
						}
					}
				}
			);
		}
	}
	function ocultarmensajeem()
	{
		var mensaje=$("#mensajesol");
		mensaje.css("display","none");
	}
	function enviardatos()
	{
		var mensaje=$("#mensajesol");
		var Email=$("#emaill").val();
		$.ajax(
			{
				async:true,
				type:"GET",
				url:"scriptsphp/enviandoemail.php?Email="+Email,
				cache:false,
				success: function(data)
					{
						if (data=="ok")
						{
							mensaje.css("display","block");
							mensaje.html("<p>Los datos de su cuenta han sido enviados a su correo de forma exitosa</p><p>El mensaje sera agregado a su bandeja de entrada en unos instantes</p>");
							mensaje.css("color","#F00");
							mensaje.css("text-align","center");
							$("#emaill").keyup(ocultarmensajeem);
						} else if (data=="no")
						{
							mensaje.css("display","block");
							mensaje.html("<p>No existe este correo en la base de datos.</p><p>Revise la ortografia y si el bloqueador de mayusculas no esta activado</p>");
							mensaje.css("color","#F00");
							mensaje.css("text-align","center");
							$("#emaill").keyup(ocultarmensajeem);
						}
					}
				}
			);
	}
	function mostrarsolicitud()
	{
		$("#dialogorecpass").css("display","block");
		$("#dialogorecpass").dialog({resizable: false,show:{effect:"puff",duration:"2000"},hide:{effect:"puff",duration:"2000"}})
	}
 </script>
<link href="login-box.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="login-form">
	<div class="container">
    	<div class="row">
        	<div class="col-xs-12">
            <h1>Mi informe</h1>
            </div>
        </div>
    </div>
    <div class=" container form-group log-status">
    	<div class="row">
                <div class="col-xs-8"><input type="number" class="form-control" placeholder="Publicaciones impresas o electronicas" id="UserName" name="user" max="999"></div>
            </div>
     </div>
      <div class="form-group log-status">
    	<div class="container">
            <div class="row">
                <div class="col-xs-8"><input type="text" class="form-control" placeholder="Presentaciones de videos" id="UserName" name="user"></div>
            </div>
         </div>
     </div>
      <div class="form-group log-status">
    	<div class="container">
            <div class="row">
                <div class="col-xs-8"><input type="text" class="form-control" placeholder="Numero de horas" id="UserName" name="user"></div>
            </div>
         </div>
     </div>
      <div class="form-group log-status">
    	<div class="container">
            <div class="row">
                <div class="col-xs-8"><input type="text" class="form-control" placeholder="Cantidad de revisitas" id="UserName" name="user"></div>
            </div>
         </div>
     </div>
      <div class="form-group log-status">
    	<div class="container">
            <div class="row">
                <div class="col-xs-8"><input type="text" class="form-control" placeholder="Cantidad de estudios biblicos" id="UserName" name="user"></div>
            </div>
         </div>
     </div>
     <button type="button" class="log-btn" id="ingreso">Ingresar</button>
     <p id="mensaje" style="display:none">El nombre o la contraseña son incorrectos</p>
    
   </div>

</div>
    <div id="dialogorecpass">
    <p id="mensajeder"></p>
    	<table width="100%" border="0" cellspacing="3">
          <tr>
            <td colspan="2" align="center">Ingrese su correo electronico y se le enviaran sus datos al mismo</td>
          </tr>
          <tr>
            <td width="50%">Email</td>
            <td width="50%"><label for="emaill"></label>
            <input type="text" name="emaill" id="emaill" /></td>
          </tr>
          <tr>
            <td colspan="2" align="center"><input type="button" name="solicitar" id="solicitar" value="Solicitar datos" /><p><span id="mensajesol"></span></p></td>
          </tr>
        </table>
    </div>
</div>
</body>
</html>
