<?
$con=mysqli_connect("mysql.hostinger.com.ar","u300421416_root","registrospnb");
mysqli_select_db($con,"u300421416_regis") or die ("no se ha podido encontrar la base de datos");
$modo=$_GET['modo'];
$Publicador=$_GET['Publicador'];
$Mes=$_GET['Mes'];
$Anio=$_GET['Anio'];
$ab="select * from publicadores where Familia!=0";
$ba=mysqli_query($con,$ab) or die ("error buscando ".$ab);
$cantpubli=mysqli_num_rows($ba);
$ab="SELECT * FROM records WHERE Mes=$Mes AND Anio=$Anio ORDER BY Publicador DESC ";
$ba=mysqli_query($con,$ab) or die ("error buscando ".$ab);
$cantrecord=0;
$idactual=0;
while  ($mrecca=mysqli_fetch_array($ba))
{
	$idpub=$mrecca['Publicador'];
	if ($idactual!=$idpub)
	{
		$idactual=$idpub;
		$cantrecord++;
	}
}
$noinformantes=$cantpubli-$cantrecord;
if ($cantrecord==0)
{
	echo '<li><h3>Cantidad de publicadores que informaron: '.$cantrecord.'</h3></li>';
}
else
{
	echo '<li><h3>Cantidad de publicadores que informaron: <a title="Ver lista de publicadores que informaron" href="javascript: " onclick="vernombres(\'informantes\')">'.$cantrecord.'<a></h3></li>';	
}
if ($noinformantes==0)
{
	echo '<li><h3>Cantidad de publicadores que no informaron: '.$noinformantes.'</h3></li>';
}
else
{
	echo '<li><h3>Cantidad de publicadores que no informaron: <a title="Ver lista de publicadores que no informaron" href="javascript: " onclick="vernombres(\'noinformantes\')">'.$noinformantes.'<a></h3></li>';
}
echo '<li><h3>&nbsp;</h3></li>';
/*Publicadores activos*/
/*-----------------------------------------------------------------------------------*/
date_default_timezone_set('America/Argentina/Buenos_Aires');
$mes=date("m");;
$anio=date("Y");;
if ($mes==1)
{
	$mes=12;
	$anio-=1;
}
else
{
	$mes-=1;
}

/*Revisa en la base de datos aquellos publicadores que tengan informado los seis meses anteriores al actual*/

/*--------------------------------------------------------------------------------------*/
$ab="select * from publicadores where Familia!=0";
$ba=mysqli_query($con,$ab) or die ("error buscando ".$ab);
$cantrecords=mysqli_num_rows($ba);
$canta=0;
while ($mrecc=mysqli_fetch_array($ba))
{
	$cantmes=0;
	$idpublicador=$mrecc['Idpublicadores'];
	if ($mes<6)
	{
		$difanio=6-$mes;
		$anioseiser=$anio-1;
		$meseiser=12-($difanio-1);
		for ($x=$meseiser;$x<=12;$x++)
		{
			$ac="select * from records where Publicador=$idpublicador AND Mes=$x AND Anio=$anioseiser";
			$ca=mysqli_query($con,$ac) or die ("error buscando ".$ac);
			$canttemp=mysqli_num_rows($ca);
			if ($canttemp!=0)
			{
				$cantmes++;	
			}
		}
		for ($x=1;$x<=$mes;$x++)
		{
			$ac="select * from records where Publicador=$idpublicador AND Mes=$x AND Anio=$anio";
			$ca=mysqli_query($con,$ac) or die ("error buscando ".$ac);
			$canttemp=mysqli_num_rows($ca);
			if ($canttemp!=0)
			{
				$cantmes++;	
			}
		}
	}
	else
	{
		$meseiser=$mes-($difanio-1);
		for ($x=$meseiser;$x<=$mes;$x++)
		{
			$ac="select * from records where Publicador=$idpublicador AND Mes=$x AND Anio=$anio";
			$ca=mysqli_query($con,$ac) or die ("error buscando ".$ac);
			$canttemp=mysqli_num_rows($ca);
			if ($canttemp!=0)
			{
				$cantmes++;	
			}
		}
	}
	if ($cantmes==6)
	{
		$canta++;
	}
}
echo '<li><h3>Cantidad de publicadores activos:<a title="Ver lista de publicadores activos" href="javascript: " onclick="vernombres(\'activos\')">'.$canta.'<a></h3></li>';
echo '<li><h3>&nbsp;</h3></li>';


/*-------------------------------------------------------------------------------------*/
function mostrartotal($rango)
{
	$con=mysqli_connect("mysql.hostinger.com.ar","u300421416_root","registrospnb");
	mysqli_select_db($con,"u300421416_regis") or die ("no se ha podido encontrar la base de datos");
	$Mes=$_GET['Mes'];
	$Anio=$_GET['Anio'];
	switch ($rango)
	{
		case "Total":
			$aa="select * from records where Mes=$Mes AND Anio=$Anio";
			$bb=mysqli_query($con,$aa) or die ("error buscando ".$aa);
			$cantrecords=mysqli_num_rows($bb);
			echo '<li><h3>Datos totales</h3></li>';
		break;
		case "Publicadores":
			$aa="select * from records where Mes=$Mes AND Anio=$Anio AND Precaux='NO' AND Precreg='NO'";
			$bb=mysqli_query($con,$aa) or die ("error buscando ".$aa);
			$cantrecords=0;	
			$idactual=0;
			while  ($mreccb=mysqli_fetch_array($bb))
			{
				$idpub=$mreccb['Publicador'];
				if ($idactual!=$idpub)
				{
					$idactual=$idpub;
					$cantrecords++;
				}
			}
			$aa="select * from records where Mes=$Mes AND Anio=$Anio AND Precaux='NO' AND Precreg='NO'";
			$bb=mysqli_query($con,$aa) or die ("error buscando ".$aa);
			if ($cantrecords==0)
			{
				echo '<li><h3>Datos de publicadores: '.$cantrecords.'</h3></li>';
			}
			else
			{
				echo '<li><h3>Datos de publicadores:  (<a title="Ver lista de publicadores" href="javascript: " onclick="vernombres(\'publicadores\')">'.$cantrecords.'<a>)</h3></li>';
			}
		break;
		case "Precursores auxiliares":
			$aa="select * from records where Mes=$Mes AND Anio=$Anio AND Precaux='SI'";	
			$bb=mysqli_query($con,$aa) or die ("error buscando ".$aa);
			$cantrecords=0;	
			$idactual=0;
			while  ($mreccb=mysqli_fetch_array($bb))
			{
				$idpub=$mreccb['Publicador'];
				if ($idactual!=$idpub)
				{
					$idactual=$idpub;
					$cantrecords++;
				}
			}
			$aa="select * from records where Mes=$Mes AND Anio=$Anio AND Precaux='SI'";	
			$bb=mysqli_query($con,$aa) or die ("error buscando ".$aa);
			if ($cantrecords==0)
			{
				echo '<li><h3>Datos de precursores auxiliares: '.$cantrecords.'</h3></li>';
			}
			else
			{
				echo '<li><h3>Datos de precursores auxiliares: (<a title="Ver lista de precursores auxiliares" href="javascript: " onclick="vernombres(\'precursoresauxiliares\')">'.$cantrecords.'<a>)</h3></li>';
			}
		break;
		case "Precursores regulares":
			$aa="select * from records where Mes=$Mes AND Anio=$Anio AND Precreg='SI'";	
			$bb=mysqli_query($con,$aa) or die ("error buscando ".$aa);
			$cantrecords=0;	
			$idactual=0;
			while  ($mreccb=mysqli_fetch_array($bb))
			{
				$idpub=$mreccb['Publicador'];
				if ($idactual!=$idpub)
				{
					$idactual=$idpub;
					$cantrecords++;
				}
			}
			$aa="select * from records where Mes=$Mes AND Anio=$Anio AND Precreg='SI'";	
			$bb=mysqli_query($con,$aa) or die ("error buscando ".$aa);
			if ($cantrecords==0)
			{
				echo '<li><h3>Datos de precursores regulares: '.$cantrecords.'</h3></li>';
			}
			else
			{
				echo '<li><h3>Datos de precursores regulares: (<a title="Ver lista de precursores regulares" href="javascript: " onclick="vernombres(\'precursoresregulares\')">'.$cantrecords.'<a>)</h3></li>';
			}
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
			$idactual=0;
			while ($mref=mysqli_fetch_array($bb))
			{
				$idpub=$mref['Publicador'];
				if ($idactual!=$idpub)
				{
					$idactual=$idpub;
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
			}
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


	