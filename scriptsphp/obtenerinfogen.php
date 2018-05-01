<?
session_start();
$Congre = $_SESSION["Congregacion"];
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
$modo=$_GET['modo'];
$Publicador=$_GET['Publicador'];
$Mes=$_GET['Mes'];
$Anio=$_GET['Anio'];
$Grupo=$_GET['Grupo'];
$con1="";
$con2="";
if ($Grupo!=0)
{
	$con1="AND Grupo=$Grupo";
	$con2="AND publicadores.Grupo=$Grupo";
	echo "<h2><strong>Datos del grupo ".$Grupo."</strong></h2>";
}
else
{
	echo "<h2><strong>Datos de la congregacion</strong></h2>";
}
$ab="SELECT publicadores.`Idpublicadores` FROM  `publicadores` INNER JOIN familias ON publicadores.Familia = familias.idfamilia AND familias.Congregacion =$Congre $con2";
$ba=mysqli_query($con,$ab) or die ("error buscando ".$ab);
$cantpubli=mysqli_num_rows($ba);
$ab="SELECT records2.Publicador FROM (`records2` INNER JOIN publicadores ON records2.Publicador=publicadores.Idpublicadores $con2 AND records2.Mes=$Mes AND records2.Anio=$Anio) INNER JOIN familias ON publicadores.Familia=familias.idfamilia AND familias.Congregacion=$Congre ORDER BY records2.Publicador ASC ";
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
	echo '<li><h3>Cantidad de publicadores que informaron: <a title="Ver lista de publicadores que informaron" href="javascript: " onclick="vernombres(\'informantes\','.$Grupo.')">'.$cantrecord.'<a></h3></li>';	
}
if ($noinformantes==0)
{
	echo '<li><h3>Cantidad de publicadores que no informaron: '.$noinformantes.'</h3></li>';
}
else
{
	echo '<li><h3>Cantidad de publicadores que no informaron: <a title="Ver lista de publicadores que no informaron" href="javascript: " onclick="vernombres(\'noinformantes\','.$Grupo.')">'.$noinformantes.'<a></h3></li>';
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
$ab="SELECT publicadores.`Idpublicadores` FROM  `publicadores` INNER JOIN familias ON publicadores.Familia = familias.idfamilia AND familias.Congregacion =$Congre $con2";
$ba=mysqli_query($con,$ab) or die ("error buscando ".$ab);
$cantrecords=mysqli_num_rows($ba);
$canta=0;
$cantna=0;
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
			$ac="select * from records2 where Publicador=$idpublicador AND Mes=$x AND Anio=$anioseiser";
			$ca=mysqli_query($con,$ac) or die ("error buscando ".$ac);
			$canttemp=mysqli_num_rows($ca);
			if ($canttemp!=0)
			{
				$cantmes++;	
			}
		}
		for ($x=1;$x<=$mes;$x++)
		{
			$ac="select * from records2 where Publicador=$idpublicador AND Mes=$x AND Anio=$anio";
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
		$meseiser=$mes-(5);
		for ($x=$meseiser;$x<=$mes;$x++)
		{
			$ac="select * from records2 where Publicador=$idpublicador AND Mes=$x AND Anio=$anio";
			$ca=mysqli_query($con,$ac) or die ("error buscando ".$ac);
			$canttemp=mysqli_num_rows($ca);
			if ($canttemp!=0)
			{
				$cantmes++;	
			}
		}
	}
	if ($cantmes>=1)
	{
		$canta++;
	}
	else
	{
		$cantna++;
	}
}
echo '<li><h3>Cantidad de publicadores activos:<a title="La cantidad de publicadores activos se obtiene
al contar las tarjetas de todos los publicadores y precursores (regulares y especiales)
que informaron por lo menos una vez durante los últimos seis meses." href="javascript: " onclick="vernombres(\'activos\','.$Grupo.')">'.$canta.'<a></h3></li>';
echo '<li><h3>Cantidad de publicadores inactivos:<a title="Ver lista de publicadores inactivos" href="javascript: " onclick="vernombres(\'inactivos\','.$Grupo.')">'.$cantna.'<a></h3></li>';
echo '<li><h3>&nbsp;</h3></li>';


/*-------------------------------------------------------------------------------------*/
function mostrartotal($rango)
{
	session_start();
	$Congre = $_SESSION["Congregacion"];
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
	$Mes=$_GET['Mes'];
	$Anio=$_GET['Anio'];
	$Grupo=$_GET['Grupo'];
	$con1="";
	$con2="";
	if ($Grupo!=0)
	{
		$con1="AND Grupo=$Grupo";
		$con2="AND publicadores.Grupo=$Grupo";
	}
	switch ($rango)
	{
		case "Total":
			$aa="SELECT records2.Publicador,records2.Publicaciones,records2.Videos,records2.Horas,records2.Revisitas,records2.Estbib FROM (`records2` INNER JOIN publicadores ON records2.Publicador=publicadores.Idpublicadores $con2 AND records2.Mes=$Mes AND records2.Anio=$Anio) INNER JOIN familias ON publicadores.Familia=familias.idfamilia AND familias.Congregacion=$Congre";
			$bb=mysqli_query($con,$aa) or die ("error buscando ".$aa);
			$cantrecords=mysqli_num_rows($bb);
			echo '<li><h3>Datos totales</h3></li>';
		break;
		case "Publicadores":
			$aa="SELECT records2.Publicador FROM (`records2` INNER JOIN publicadores ON records2.Publicador=publicadores.Idpublicadores $con2 AND records2.Mes=$Mes AND records2.Anio=$Anio AND records2.Precaux='NO' AND records2.Precreg='NO') INNER JOIN familias ON publicadores.Familia=familias.idfamilia AND familias.Congregacion=$Congre";
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
			$aa="SELECT records2.Publicador,records2.Publicaciones,records2.Videos,records2.Horas,records2.Revisitas,records2.Estbib FROM (`records2` INNER JOIN publicadores ON records2.Publicador=publicadores.Idpublicadores $con2 AND records2.Mes=$Mes AND records2.Anio=$Anio AND records2.Precaux='NO' AND records2.Precreg='NO') INNER JOIN familias ON publicadores.Familia=familias.idfamilia AND familias.Congregacion=$Congre";
			$bb=mysqli_query($con,$aa) or die ("error buscando ".$aa);
			if ($cantrecords==0)
			{
				echo '<li><h3>Datos de publicadores: '.$cantrecords.'</h3></li>';
			}
			else
			{
				echo '<li><h3>Datos de publicadores:  (<a title="Ver lista de publicadores" href="javascript: " onclick="vernombres(\'publicadores\','.$Grupo.')">'.$cantrecords.'<a>)</h3></li>';
			}
		break;
		case "Precursores auxiliares":
			$aa="SELECT records2.Publicador FROM (`records2` INNER JOIN publicadores ON records2.Publicador=publicadores.Idpublicadores $con2 AND records2.Mes=$Mes AND records2.Anio=$Anio AND records2.Precaux='SI') INNER JOIN familias ON publicadores.Familia=familias.idfamilia AND familias.Congregacion=$Congre";
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
			$aa="SELECT records2.Publicador,records2.Publicaciones,records2.Videos,records2.Horas,records2.Revisitas,records2.Estbib FROM (`records2` INNER JOIN publicadores ON records2.Publicador=publicadores.Idpublicadores $con2 AND records2.Mes=$Mes AND records2.Anio=$Anio AND records2.Precaux='SI') INNER JOIN familias ON publicadores.Familia=familias.idfamilia AND familias.Congregacion=$Congre";	
			$bb=mysqli_query($con,$aa) or die ("error buscando ".$aa);
			if ($cantrecords==0)
			{
				echo '<li><h3>Datos de precursores auxiliares: '.$cantrecords.'</h3></li>';
			}
			else
			{
				echo '<li><h3>Datos de precursores auxiliares: (<a title="Ver lista de precursores auxiliares" href="javascript: " onclick="vernombres(\'precursoresauxiliares\','.$Grupo.')">'.$cantrecords.'<a>)</h3></li>';
			}
		break;
		case "Precursores regulares":
			$aa="SELECT records2.Publicador FROM (`records2` INNER JOIN publicadores ON records2.Publicador=publicadores.Idpublicadores $con2 AND records2.Mes=$Mes AND records2.Anio=$Anio AND records2.Precreg='SI') INNER JOIN familias ON publicadores.Familia=familias.idfamilia AND familias.Congregacion=$Congre";
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
			$aa="SELECT records2.Publicador,records2.Publicaciones,records2.Videos,records2.Horas,records2.Revisitas,records2.Estbib FROM (`records2` INNER JOIN publicadores ON records2.Publicador=publicadores.Idpublicadores $con2 AND records2.Mes=$Mes AND records2.Anio=$Anio AND records2.Precreg='SI') INNER JOIN familias ON publicadores.Familia=familias.idfamilia AND familias.Congregacion=$Congre";
			$bb=mysqli_query($con,$aa) or die ("error buscando ".$aa);
			if ($cantrecords==0)
			{
				echo '<li><h3>Datos de precursores regulares: '.$cantrecords.'</h3></li>';
			}
			else
			{
				echo '<li><h3>Datos de precursores regulares: (<a title="Ver lista de precursores regulares" href="javascript: " onclick="vernombres(\'precursoresregulares\','.$Grupo.')">'.$cantrecords.'<a>)</h3></li>';
			}
		break;	
	}
			$totalpublicaciones=0;
			$totalvideos=0;
			$totalhoras=0;
			$totalrevisitas=0;
			$totalestbib=0;
			$promediopublicaciones=0;
			$promediovideos=0;
			$promediohoras=0;
			$promediorevisitas=0;
			$promedioestbib=0;
			$idactual=0;
			while ($mref=mysqli_fetch_array($bb))
			{
				$idpub=$mref['Publicador'];
				if ($idactual!=$idpub)
				{
					$idactual=$idpub;
					$Publicaciones=$mref['Publicaciones'];
					$totalpublicaciones+=$Publicaciones;
					$Videos=$mref['Videos'];
					$totalvideos+=$Videos;
					$Horas=$mref['Horas'];
					$totalhoras+=$Horas;
					$Revisitas=$mref['Revisitas'];
					$totalrevisitas+=$Revisitas;
					$Estbib=$mref['Estbib'];
					$totalestbib+=$Estbib;	
				}
			}
			echo '<li><p>Total de publicaciones: '.$totalpublicaciones.'</br>';
			if ($cantrecords!=0)
			{
				echo 'Promedio de publicaciones: '.round($totalpublicaciones/$cantrecords,2).'</p></li>';
			}
			echo '<li><p>Total de videos: '.$totalvideos.'</br>';
			if ($cantrecords!=0)
			{
				echo 'Promedio de videos: '.round($totalvideos/$cantrecords,2).'</p></li>';
			}
			echo '<li><p><span style="background-color:#26770A"><br>Total de horas: '.$totalhoras.'</br></span>';
			if ($cantrecords!=0)
			{
				echo 'Promedio de horas: '.round($totalhoras/$cantrecords,2).'</p></li>';
			}
			echo '<li><p><span style="background-color:#26770A"><br>Total de revisitas: '.$totalrevisitas.'</br></span>';
			if ($cantrecords!=0)
			{
				echo 'Promedio de revisitas: '.round($totalrevisitas/$cantrecords,2).'</p></li>';
			}
			echo '<li><p><span style="background-color:#26770A"><br>Total de estudios biblicos: '.$totalestbib.'</br></span>';
			if ($cantrecords!=0)
			{
				echo 'Promedio de estudios biblicos: '.round($totalestbib/$cantrecords,2).'</p></li>';	
			}
}
mostrartotal("Total");
mostrartotal("Publicadores");
mostrartotal("Precursores auxiliares");
mostrartotal("Precursores regulares");
?>


	