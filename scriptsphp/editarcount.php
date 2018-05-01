<?
session_start();
$idusuario=$_GET['idusuario'];
$Usuario=$_GET['Usuario'];
$Pass=$_GET['Pass'];
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
$aa="UPDATE usuarios SET Usuario='$Usuario',Pass='$Pass' WHERE Iduser=$idusuario";	
$bb=mysqli_query($con,$aa) or die ("error buscando ".$aa);
echo "Los datos de tu cuentas han sido modificados con exito";
?>


	