<?
$Publicador=$_GET['Publicador'];
$Mes=$_GET['Mes'];
$Anio=$_GET['Anio'];
$Libros=$_GET['Libros'];
$Folletos=$_GET['Folletos'];
$Horas=$_GET['Horas'];
$Revistas=$_GET['Revistas'];
$Revisitas=$_GET['Revisitas'];
$Estbib=$_GET['Estbib'];
$Precaux=$_GET['Precaux'];
$Precreg=$_GET['Precreg'];
$Notas=$_GET['Notas'];
$con=mysqli_connect("mysql.hostinger.com.ar","u300421416_root","registrospnb");
mysqli_select_db($con,"u300421416_regis") or die ("no se ha podido encontrar la base de datos");
$aa="insert into records (Publicador,Mes,Anio,Libros,Folletos,Horas,Revistas,Revisitas,Estbib,Notas,Precaux,Precreg) values ($Publicador,$Mes,$Anio,$Libros,$Folletos,$Horas,$Revistas,$Revisitas,$Estbib,'$Notas','$Precaux','$Precreg')";	
$bb=mysqli_query($con,$aa) or die ("error buscando ".$aa);
echo "Se ha insertado este registro de forma correcta";
?>


	