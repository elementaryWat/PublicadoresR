<? 
session_start();
$usuario=$_GET['usuario'];
$pass=$_GET['pass'];
$con=mysqli_connect("mysql.hostinger.com.ar","u300421416_root","registrospnb");
mysqli_select_db($con,"u300421416_regis") or die ("no se ha podido encontrar la base de datos");

$a="select * from usuarios where Usuario = '$usuario'";
$b = mysqli_query ($con,$a)
or die ("error buscando".$a);
$cant=mysqli_num_rows($b);
$m=mysqli_fetch_array ($b);
if ($cant <> 0 ) {
	$idusuario=$m['Iduser'];
	$usuario=$m['Usuario'];
	$passus=$m['Pass'];
	$Categoria=$m['Categoria'];
	if ($pass == $passus ) {
	$_SESSION["idusrecor"] = $idusuario;
	$_SESSION["Usuariorec"] = $usuario;
	$_SESSION["Categoriarec"] = $Categoria;
	echo "ok";
	} else {
	echo "no";
	}
} else {
echo "no";
}
?>