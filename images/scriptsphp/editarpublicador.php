<?
$publicador=$_GET['publicador'];
$Nombre=$_GET['Nombre'];
$Fechanac=$_GET['Fechanac'];
$Fechanac=substr($Fechanac,6,4)."-".substr($Fechanac,3,2)."-".substr($Fechanac,0,2);
$Fechabau=$_GET['Fechabau'];
$Fechabau=substr($Fechabau,6,4)."-".substr($Fechabau,3,2)."-".substr($Fechabau,0,2);
$Unguotro=$_GET['Unguotro'];
$Sexo=$_GET['Sexo'];
$Anciano=$_GET['Anciano'];
$Siervomin=$_GET['Siervomin'];
$Precreg=$_GET['Precreg'];
$con=mysqli_connect("mysql.hostinger.com.ar","u300421416_root","registrospnb");
mysqli_select_db($con,"u300421416_regis") or die ("no se ha podido encontrar la base de datos");
$aa="UPDATE publicadores SET Nombre='$Nombre',Fechanac='$Fechanac',Fechabau='$Fechabau',Unguotro='$Unguotro',Sexo='$Sexo',Anciano='$Anciano',Siervomin='$Siervomin',Precreg='$Precreg' WHERE Idpublicadores=$publicador";	
$bb=mysqli_query($con,$aa) or die ("error buscando ".$aa);
echo "Los datos de ".$Nombre." han sido modificados con exito";
?>


	