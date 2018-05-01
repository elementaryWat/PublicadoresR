
<?
session_start();
$rango=$_GET['rango'];
$busqueda=$_GET['busqueda'];
$criterio=$_GET['criterio'];
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
	$aa="select * from familias where Congregacion=$Congre ORDER BY Nombrefam Asc";	
	$bb=mysqli_query($con,$aa) or die ("error buscando ".$aa);
	$cadenac='';
	if ($criterio=='')
	{
		$cadenac='';
	}
	else
	{
		switch($criterio)
		{
			case 'Ancianos':
				$cadenac=" AND Anciano='SI'";
			break;
			case 'Siervosministeriales':
				$cadenac=" AND Siervomin='SI'";
			break;
			case 'Precursoresregulares':
				$cadenac=" AND Precreg='SI'";
			break;
			case 'Publicadores':
				$cadenac=" AND Precreg='NO'";
			break;
		}
	}
	echo '<div id="acordeonpublicadores">';
		while ($mref=mysqli_fetch_array($bb))
		{
		$idfamilia=$mref['idfamilia'];
		$Nombrefam=$mref['Nombrefam'];
		switch ($rango)
		{
		case "todo":
			$ab="select * from publicadores where Familia=$idfamilia".$cadenac." ORDER BY Nombre Asc";	
		break;
		case "especifico":
			$ab="select * from publicadores where Nombre LIKE '%$busqueda%' AND Familia=$idfamilia".$cadenac." ORDER BY Nombre Asc";
		break;
		}		
		$ba=mysqli_query($con,$ab) or die ("error buscando ".$ab);
		$cantpub=mysqli_num_rows($ba);
			if ($cantpub!=0)
			{
					echo '<h2 style="font-size:24px">'.$Nombrefam.'</h2>';
			echo '<div>';
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


	