<?
session_start();
$Reunion=$_GET['Reunion'];
$Mes=$_GET['Mes'];
$Anio=$_GET['Anio'];
$Numreu=$_GET['Numreu'];
$Asistencia=$_GET['Asistencia'];
$Promedio=round($Asistencia/$Numreu);
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
$aa="UPDATE asistencias SET Numreuniones=$Numreu,Asistenciatot=$Asistencia,Promedio=$Promedio where Reunion=$Reunion AND Mes=$Mes AND Anio=$Anio";	
$bb=mysqli_query($con,$aa) or die ("error buscando ".$aa);
echo "Se ha modificado esta asistencia de forma correcta";
?>


	