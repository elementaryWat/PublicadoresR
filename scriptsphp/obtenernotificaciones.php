<?
session_start();
$idusuario=$_SESSION["idusrecor"];
$Congre = $_SESSION["Congregacion"];
date_default_timezone_set('America/Argentina/Buenos_Aires');
$fechaactual=date("Y-m-d");
$hora=date("G:i:s");
$fechaactual.=" ".$hora;	
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
$ab="select * from usuarios where Iduser=$idusuario";
$ba=mysqli_query($con,$ab) or die ("error buscando ".$ab);
$mpub=mysqli_fetch_array($ba);
$Fechalastnot=$mpub['Fechaultnot'];
$aa="select * from notificaciones where Congregacion=$Congre AND Fecha>'$Fechalastnot'";	
$bb=mysqli_query($con,$aa) or die ("error buscando ".$aa);
$cant=mysqli_num_rows($bb);
if ($cant>0)
{
	date_default_timezone_set('America/Argentina/Buenos_Aires');
	$fechaagre=date("Y-m-d");
	$hora=date("G:i:s");
	$fechaagre.=" ".$hora;	
	$aa="UPDATE usuarios SET Fechaultnot='$fechaagre' where Iduser=$idusuario";	
	$bb=mysqli_query($con,$aa) or die ("error buscando ".$aa);	
	echo 1;
}
else
{
	echo 0;
}
?>


	