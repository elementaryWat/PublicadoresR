<?
session_start();
$publicador=$_GET['publicador'];
$Nombre=$_GET['Nombre'];
$Grupo=$_GET['Grupo'];
$Domicilio=$_GET['Domicilio'];
$Telefono=$_GET['Telefono'];
$Celular=$_GET['Celular'];
$Fechanac=$_GET['Fechanac'];
$Fechanac=substr($Fechanac,6,4)."-".substr($Fechanac,3,2)."-".substr($Fechanac,0,2);
$Bautisino=$_GET['Bautisino'];
$Fechabau=$_GET['Fechabau'];
$Fechabau=substr($Fechabau,6,4)."-".substr($Fechabau,3,2)."-".substr($Fechabau,0,2);
$Unguotro=$_GET['Unguotro'];
$Sexo=$_GET['Sexo'];
$Anciano=$_GET['Anciano'];
$Siervomin=$_GET['Siervomin'];
$Precreg=$_GET['Precreg'];
$dni=$_GET['dni'];
$fechanomb=$_GET['fechanomb'];
$idpreccu=$_GET['idpreccu'];
$fechanomb=substr($fechanomb,6,4)."-".substr($fechanomb,3,2)."-".substr($fechanomb,0,2);
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
$aa="UPDATE publicadores SET Nombre='$Nombre', DNI=$dni,Grupo=$Grupo,Domicilio='$Domicilio',Telefono=$Telefono,Celular=$Celular,Fechanac='$Fechanac',Fechabau='$Fechabau',Bautizado='$Bautisino',Unguotro='$Unguotro',Sexo='$Sexo',Anciano='$Anciano',Siervomin='$Siervomin',Precreg='$Precreg',Fechanom='$fechanomb',Idprec=$idpreccu WHERE Idpublicadores=$publicador";	
$bb=mysqli_query($con,$aa) or die ("error buscando ".$aa);
echo "Los datos de ".$Nombre." han sido modificados con exito";
?>


	