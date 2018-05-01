<?
$con=mysqli_connect("mysql.hostinger.com.ar","u300421416_root","registrospnb");
mysqli_select_db($con,"u300421416_regis") or die ("no se ha podido encontrar la base de datos");
$modo=$_GET['modo'];
$Publicador=$_GET['Publicador'];
$Mes=$_GET['Mes'];
$Anio=$_GET['Anio'];
$aa="select * from records where Mes=$Mes AND Anio=$Anio";
$bb=mysqli_query($con,$aa) or die ("error buscando ".$aa);
$cantrecords=mysqli_num_rows($bb);
echo '<li><h3>Cantidad de publicadores que informaron: '.$cantrecords.'</h3></li>';
echo '<li><h3>&nbsp;</h3></li>';
function mostrartotal($rango)
{
	$Mes=$_GET['Mes'];
	$Anio=$_GET['Anio'];
	switch ($rango)
	{
		case "Total":
			$aa="select * from records where Mes=$Mes AND Anio=$Anio";	
			$bb=mysql_query($aa) or die ("error buscando ".$aa);
			$cantrecords=mysql_num_rows($bb);
			echo '<li><h3>Datos totales</h3></li>';
		break;
		case "Publicadores":
			$aa="select * from records where Mes=$Mes AND Anio=$Anio AND Precaux='NO' AND Precreg='NO'";
			$bb=mysqli_query($con,$aa) or die ("error buscando ".$aa);
			$cantrecords=mysqli_num_rows($bb);	
			echo '<li><h3>Datos de publicadores ('.$cantrecords.')</h3></li>';
		break;
		case "Precursores auxiliares":
			$aa="select * from records where Mes=$Mes AND Anio=$Anio AND Precaux='SI'";	
			$bb=mysqli_query($con,$aa) or die ("error buscando ".$aa);
			$cantrecords=mysqli_num_rows($bb);
			echo '<li><h3>Datos de precursores auxiliares ('.$cantrecords.')</h3></li>';
		break;
		case "Precursores regulares":
			$aa="select * from records where Mes=$Mes AND Anio=$Anio AND Precreg='SI'";	
			$bb=mysqli_query($con,$aa) or die ("error buscando ".$aa);
			$cantrecords=mysqli_num_rows($bb);
			echo '<li><h3>Datos de precursores regulares ('.$cantrecords.')</h3></li>';
		break;	
	}
			$totallibros=0;
			$totalfolletos=0;
			$totalhoras=0;
			$totalrevistas=0;
			$totalrevisitas=0;
			$totalestbib=0;
			$promediolibros=0;
			$promediofolletos=0;
			$promediohoras=0;
			$promediorevistas=0;
			$promediorevisitas=0;
			$promedioestbib=0;
			while ($mref=mysqli_fetch_array($bb))
			{
				$Libros=$mref['Libros'];
				$totallibros+=$Libros;
				$Folletos=$mref['Folletos'];
				$totalfolletos+=$Folletos;
				$Horas=$mref['Horas'];
				$totalhoras+=$Horas;
				$Revistas=$mref['Revistas'];
				$totalrevistas+=$Revistas;
				$Revisitas=$mref['Revisitas'];
				$totalrevisitas+=$Revisitas;
				$Estbib=$mref['Estbib'];
				$totalestbib+=$Estbib;	
			}
			$promediolibros=$totallibros/$cantrecords;
			$promediofolletos=$totalfolletos/$cantrecords;
			$promediohoras=$totalhoras/$cantrecords;
			$promediorevistas=$totalrevistas/$cantrecords;
			$promediorevisitas=$totalrevisitas/$cantrecords;
			$promedioestbib=$totalestbib/$cantrecords;
			echo '<li><p>Total de libros: '.$totallibros.'</p></li>';
			echo '<li><p>Total de folletos: '.$totalfolletos.'</p></li>';
			echo '<li><p>Total de horas: '.$totalhoras.'</p></li>';
			echo '<li><p>Total de revistas: '.$totalrevistas.'</p></li>';
			echo '<li><p>Total de revisitas: '.$totalrevisitas.'</p></li>';
			echo '<li><p>Total de estudios biblicos: '.$totalestbib.'</p></li>';	
}
mostrartotal("Total");
mostrartotal("Publicadores");
mostrartotal("Precursores auxiliares");
mostrartotal("Precursores regulares");
?>


	