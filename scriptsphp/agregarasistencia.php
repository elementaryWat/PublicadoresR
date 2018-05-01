<?
session_start();
$Congre = $_SESSION["Congregacion"];
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
$aa="insert into asistencias (Reunion,Mes,Anio,Numreuniones,Asistenciatot,Promedio,Congregacion) values ($Reunion,$Mes,$Anio,$Numreu,$Asistencia,$Promedio,$Congre)";	
$bb=mysqli_query($con,$aa) or die ("error buscando ".$aa);
echo "Se ha insertado esta asistencia de forma correcta";
?>


	