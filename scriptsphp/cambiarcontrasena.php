<?
session_start();
$publicador=$_GET['Publicador'];
$NewContr=$_GET['NewContr'];
$servidor=$_SESSION['servidor'];
$dbusuario=$_SESSION['dbusuario'];
$dbcontrasena=$_SESSION['dbcontrasena'];
$nomdb=$_SESSION['nomdb'];
$mendb=$_SESSION['condb'];
$con=mysqli_connect($servidor,$dbusuario,$dbcontrasena);
mysqli_select_db($con,$nomdb) or die ($mendb);
$aa="UPDATE publicadores SET Passpub='$NewContr' WHERE Idpublicadores=$publicador";	
$bb=mysqli_query($con,$aa) or die ("error buscando ".$aa);
$_SESSION["Passpub"] = $NewContr;
echo "Se ha modificado tu contraseña con exito";
?>


	