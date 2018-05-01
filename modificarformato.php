<? 
$servidor="localhost";
$dbusuario="root";
$dbcontrasena="";
$nomdb="registros";
$mendb="no se ha podido encontrar la base de datos";
$con=mysqli_connect($servidor,$dbusuario,$dbcontrasena);
mysqli_select_db($con,$nomdb) or die ($mendb);
$ac="select * from records";	
$bc=mysqli_query($con,$ac) or die ("error buscando ".$ac);
while ($mref=mysqli_fetch_array($bc))
{
	$Publicador=$mref['Publicador'];
	$Anio=$mref['Anio'];
	$Mes=$mref['Mes'];
	$Publicaciones=$mref['Libros']+$mref['Folletos']+$mref['Revistas'];
	$Horas=$mref['Horas'];
	$Revisitas=$mref['Revisitas'];
	$Estbib=$mref['Estbib'];	
	$Notas=$mref['Notas'];
	$Precaux=$mref['Precaux'];
	$Precreg=$mref['Precreg'];
	$Grupo=$mref['Grupo'];
	$aa="insert into records2 (Publicador,Mes,Anio,Publicaciones,Videos,Horas,Revisitas,Estbib,Notas,Precaux,Precreg,Grupo) values ($Publicador,$Mes,$Anio,$Publicaciones,0,$Horas,$Revisitas,$Estbib,'$Notas','$Precaux','$Precreg',$Grupo)";	
	$bb=mysqli_query($con,$aa) or die ("error buscando ".$aa);
}
?>
