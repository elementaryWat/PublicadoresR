
<?
$rango=$_GET['rango'];
$busqueda=$_GET['busqueda'];
$con=mysqli_connect("mysql.hostinger.com.ar","u300421416_root","registrospnb");
mysqli_select_db($con,"u300421416_regis") or die ("no se ha podido encontrar la base de datos");
	$aa="select * from familias ORDER BY Nombrefam Asc";	
	$bb=mysqli_query($con,$aa) or die ("error buscando ".$aa);
	echo '<div id="acordeonpublicadores">';
		while ($mref=mysqli_fetch_array($bb))
		{
		$idfamilia=$mref['idfamilia'];
		$Nombrefam=$mref['Nombrefam'];
		switch ($rango)
		{
		case "todo":
			$ab="select * from publicadores where Familia=$idfamilia ORDER BY Nombre Asc";	
		break;
		case "especifico":
			$ab="select * from publicadores where Nombre LIKE '%$busqueda%' AND Familia=$idfamilia ORDER BY Nombre Asc";
		break;
		}		
		$ba=mysqli_query($con,$ab) or die ("error buscando ".$ab);
		$cantpub=mysqli_num_rows($ba);
			if ($cantpub!=0)
			{
					echo '<h2 style="font-size:24px">'.$Nombrefam.'</h2>';
			echo '<div>';
			echo '<h3 style="background-color:#CCC"><a href="#" style="color:#003">Editar datos de la familia</a></h3>';
					while ($mpub=mysqli_fetch_array($ba))
					{
					$idpublicador=$mpub['Idpublicadores'];
					$Nombrepub=$mpub['Nombre'];
					echo '<p style="text-align:center;font-weight:bolder;font-size:20px">'.$Nombrepub.'  <a href="javascript:" onclick=" mostrarpublicador('.$idpublicador.')"><img src="images/Pagina/archivoicno.png" width="30" height="30" alt="datos" title="Ver los datos de '.$Nombrepub.'"/></a><a href="javascript:" onclick=" editarpublicador('.$idpublicador.')"><img src="images/Pagina/editar.png" width="30" height="30" alt="datos" title="Editar los datos de '.$Nombrepub.'"/></a></p>';
					}
				echo '</div>';
			}
		}
		echo '</div>';			
?>


	