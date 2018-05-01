<? 
session_start();
$Email=$_GET['Email'];
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

$a="select * from usuarios where Email = '$Email'";
$b = mysqli_query ($con,$a)
or die ("error buscando".$a);
$cant=mysqli_num_rows($b);
$m=mysqli_fetch_array ($b);
if ($cant != 0 ) 
{
	$usuario=$m['Usuario'];
	$passus=$m['Pass'];
	$Nombre=$m['Nombre'];
	$Apellido=$m['Apellido'];
	$destinatario = $Email; 
	$asunto = "Informacion de cuenta de www.registrospnb.890m.com"; 
	$cuerpo = ' 
	<html> 
	<head> 
	   <title>Informacionde cuenta</title> 
	</head> 
	<body> 
	<h1>Hola '.$Nombre.' '.$Apellido.'</h1> 
	<p> 
	Aqui te envio la informacion de tu cuenta para poder ingresar al sitio www.registrospnb.890m.com. 
	</p> 
	<p> 
	Nombre de usuario: '.$usuario.'
	</p> 
	<p> 
	Contraseña: '.$passus.'
	</p> 
	<p> 
	<b>Espero que esta herramienta pueda ayudarte a administrar de forma mas facil y eficiente el registro de horas de los publicadores de nuestra congregacion. Ante cualquier sugerencia para mejorar la aplicacion no dudes en hacermela llegar.</b>
	</p> 
	<p> 
	<b>Atentamente: Augusto Romero</b>
	</p> 
	</body> 
	</html> 
	'; 
	
	//para el envío en formato HTML 
	$headers = "MIME-Version: 1.0\r\n"; 
	$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
	
	//dirección del remitente 
	$headers .= "From: Gerardo Augusto Romero <geragusto@hotmail.com>\r\n"; 
	
	//dirección de respuesta, si queremos que sea distinta que la del remitente 
	$headers .= "Reply-To: geragusto@hotmail.com\r\n"; 
	
	mail($destinatario,$asunto,$cuerpo,$headers);
	echo "ok";
} 
else 
{
	echo "no";
}
?>