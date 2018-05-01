
<?
session_start();
$rango=$_GET['rango'];
$busqueda=$_GET['busqueda'];
$criterio=$_GET['criterio'];
$servidor=$_SESSION['servidor'];
$dbusuario=$_SESSION['dbusuario'];
$dbcontrasena=$_SESSION['dbcontrasena'];
$nomdb=$_SESSION['nomdb'];
$mendb=$_SESSION['condb'];
$con=mysqli_connect($servidor,$dbusuario,$dbcontrasena);
mysqli_select_db($con,$nomdb) or die ($mendb);
$Congre = $_SESSION["Congregacion"];
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
				$cadenac=" AND publicadores.Precreg='NO'";
			break;
		}
	}
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
					echo '<h2>'.$Nombrefam.'</h2>';
					while ($mpub=mysqli_fetch_array($ba))
					{
					$idpublicador=$mpub['Idpublicadores'];
					$Nombrepub=$mpub['Nombre'];
					echo '<input type="checkbox" id="check'.$idpublicador.'" value="'.$idpublicador.'" name="'.$Nombrepub.' '.$Nombrefam.'"/><label for="check'.$idpublicador.'">'.$Nombrepub.'</label>';
					}
				
			}	
		}		
?>


	