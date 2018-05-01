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
$aa="UPDATE records SET Libros=$Libros,Folletos=$Folletos,Horas=$Horas,Revistas=$Revistas,Revisitas=$Revisitas,Estbib=$Estbib,Notas='$Notas',Precaux='$Precaux',Precreg='$Precreg' where Publicador=$Publicador AND Mes=$Mes AND Anio=$Anio";	
$bb=mysqli_query($con,$aa) or die ("error buscando ".$aa);
echo "Se ha modificado este registro de forma correcta";
?>


	