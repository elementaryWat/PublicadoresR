

<?
/*  
Obteniendo todos los registros de un mes 
$publicadorsino=$_GET['Pub'];
$precauxsino=$_GET['Pra'];
$precregsino=$_GET['Prr'];
 if ($publicadorsino=="SI")
 {
	 $conpublicador='OR (`Precreg` =  "NO" AND  `Precaux` =  "NO")';
}
else
{
	$conpublicador='';
}

if ($precregsino=="SI")
 {
	 $conprecreg='(Precreg =  "SI" AND Precaux =  "NO")';
}
else
{
	$conprecreg='(Precreg =  "SI" AND Precaux =  "SI")';
}

if ($precauxsino=="SI")
 {
	 $conpreaux='OR (Precreg =  "NO" AND Precaux =  "SI")';
}
else
{
	$conpreaux='OR (Precreg =  "SI" AND Precaux =  "SI")';
}
*/
session_start();
$rango=$_GET['rango'];
$busqueda=$_GET['busqueda'];
$Mes=$_GET['Mes'];
$Anio=$_GET['Anio'];
$Rangopub=$_GET['Rangopub'];
$Congre = $_SESSION["Congregacion"];
$encontr=0;
$idusuario=$_SESSION["idusrecor"];
$Categoria=$_SESSION["Categoriarec"];
$Congre = $_SESSION["Congregacion"];
$servidor=$_SESSION['servidor'];
$dbusuario=$_SESSION['dbusuario'];
$dbcontrasena=$_SESSION['dbcontrasena'];
$nomdb=$_SESSION['nomdb'];
$servidor=$_SESSION['servidor'];
$dbusuario=$_SESSION['dbusuario'];
$dbcontrasena=$_SESSION['dbcontrasena'];
$nomdb=$_SESSION['nomdb'];
$mendb=$_SESSION['condb'];
$con=mysqli_connect($servidor,$dbusuario,$dbcontrasena);
mysqli_select_db($con,$nomdb) or die ($mendb);
	$aa="select * from familias where Congregacion=$Congre ORDER BY Nombrefam Asc";	
	$bb=mysqli_query($con,$aa) or die ("error buscando ".$aa);
	
	echo '<table width="100%" border="0" cellspacing="3">';
		while ($mref=mysqli_fetch_array($bb))
		{
		$idfamilia=$mref['idfamilia'];
		$Nombrefam=$mref['Nombrefam'];
		switch ($rango)
		{
		case "todo":
			switch($Rangopub)
			{
				case "Todos":
				$ab="select * from publicadores where Familia=$idfamilia ORDER BY Nombre Asc";
				break;
				default: 
					$ab="select * from grupos where Congregacion=$Congre";	
					$ba=mysqli_query($con,$ab) or die ("error buscando ".$ab);
					while ($mgrup=mysqli_fetch_array($ba))
					{
						$NumGrupo=$mgrup['NumGrupo'];
						if ($Rangopub==$NumGrupo)
						{
							$ab="select * from publicadores where Familia=$idfamilia AND Grupo=$NumGrupo ORDER BY Nombre Asc";
						}
					}
			}	
		break;
		case "especifico":
			switch($Rangopub)
			{
				case "Todos":
				$ab="select * from publicadores where Nombre LIKE '%$busqueda%' AND Familia=$idfamilia ORDER BY Nombre Asc";
				break;
				default: 
					$ab="select * from grupos where Congregacion=$Congre";	
					$ba=mysqli_query($con,$ab) or die ("error buscando ".$ab);
					while ($mgrup=mysqli_fetch_array($ba))
					{
						$NumGrupo=$mgrup['NumGrupo'];
						if ($Rangopub==$NumGrupo)
						{
							$ab="select * from publicadores where Nombre LIKE '%$busqueda%' AND Familia=$idfamilia AND Grupo=$NumGrupo ORDER BY Nombre Asc";
						}
					}
			}	
		break;
		}		
		$ba=mysqli_query($con,$ab) or die ("error buscando ".$ab);
		$cantpub=mysqli_num_rows($ba);
			if ($cantpub!=0)
			{
			$encontr=1;
			echo '<tr><td style="font-size:24px; font-weight:bolder; text-align:center; background-color: #B7B7B7">'.$Nombrefam.'</td></tr>';
			echo '<tr><td>';
			echo '<div>';
			echo '<table width="100%" border="0" cellspacing="3">';
					while ($mpub=mysqli_fetch_array($ba))
					{
					$idpublicador=$mpub['Idpublicadores'];
					$ac="select * from records2 where Publicador=$idpublicador AND Mes=$Mes AND Anio=$Anio";	
					$ca=mysqli_query($con,$ac) or die ("error buscando ".$ac);
					$cantreff=mysqli_num_rows($ca);
					$mregg=mysqli_fetch_array($ca);
					$Publicaciones=$mregg['Publicaciones'];
					$Videos=$mregg['Videos'];
					$Horas=$mregg['Horas'];
					$Revisitas=$mregg['Revisitas'];
					$Estbib=$mregg['Estbib'];
					$Notas=$mregg['Notas'];
					$Nombrepub=$mpub['Nombre'];
					switch ($Mes)
					{
						case 1:
						$nombremes="Enero";
						break;
						case 2:
						$nombremes="Febrero";
						break;
						case 3:
						$nombremes="Marzo";
						break;
						case 4:
						$nombremes="Abril";
						break;
						case 5:
						$nombremes="Mayo";
						break;
						case 6:
						$nombremes="Junio";
						break;
						case 7:
						$nombremes="Julio";
						break;
						case 8:
						$nombremes="Agosto";
						break;
						case 9:
						$nombremes="Septiembre";
						break;
						case 10:
						$nombremes="Octubre";
						break;
						case 11:
						$nombremes="Noviembre";
						break;
						case 12:
						$nombremes="Diciembre";
						break;
					}
						if ($cantreff!=0)
						{
							echo '<tr style="text-align:center;font-size:20px;background-color:#DAFED3">'
								.'<td width="20%"><img src="images/Pagina/ok.png" width="30" height="30" alt="datos" title="Informe de '.$nombremes.' de '.$Nombrepub.' entregado"/></td>'
								.'<td width="80%"><span style="font-weight:bolder; font-size:22px">'.$Nombrepub.'</span>  <a href="javascript:" onclick="editarinforme(\''.$Nombrepub.'\','.$idpublicador.','.$Mes.','.$Anio.')"><img src="images/Pagina/editar2.png" width="30" height="30" alt="datos" title="Editar informe '.$nombremes.'/'.$Anio.' de '.$Nombrepub.'"/></a>'
								.'<table width="100%" border="1" cellspacing="3" style="font-size:14px">'
								 .' <tr>'
									.'<td>Publicaciones (impresas y electronicas)</td>'
									.'<td>Presentaciones de videos</td>'
									.'<td>Horas</td>'
									.'<td>Revisitas</td>'
									.'<td>Estudios biblicos</td>'
									.'<td>Notas</td>'
								 .' </tr>'
								  .'<tr>'
									.'<td>'.$Publicaciones.'</td>'
									.'<td>'.$Videos.'</td>'
									.'<td>'.$Horas.'</td>'
									.'<td>'.$Revisitas.'</td>'
									.'<td>'.$Estbib.'</td>'
									.'<td>'.$Notas.'</td>'
								  .'</tr>'
								.'</table>'
								.'</td>'
							 .' </tr>';
						}
						else
						{
							echo '<tr style="text-align:center;font-size:20px;background-color:#FFD7E6">'
								.'<td width="20%"><img src="images/Pagina/incorrecto.png" width="30" height="30" alt="datos" title="Informe de '.$nombremes.' de '.$Nombrepub.' no entregado"/></td>'
								.'<td width="80%"><span style="font-weight:bolder; font-size:22px">'.$Nombrepub.'</span> <a href="javascript:" onclick="agregarinforme(\''.$Nombrepub.'\','.$idpublicador.','.$Mes.','.$Anio.')"><img src="images/Pagina/mas1.png" width="30" height="30" alt="datos" title="Agregar informe '.$nombremes.'/'.$Anio.' de '.$Nombrepub.'"/></a></td>'
							 .' </tr>';
						}
					}
					echo '</table>';
				echo '</div>';
			}
		echo '</td></tr>';
		}
		if ($encontr==0)
		{
			if ($Rangopub=="Todos")
				{
					echo '<tr><td style="font-size:24px; font-weight:bolder; text-align:center;">Sin resultados para "'.$busqueda.'"</td></tr>';
				}
				else
				{
					echo '<tr><td style="font-size:24px; font-weight:bolder; text-align:center;">Sin resultados para "'.$busqueda.'" en '.$Rangopub.'</td></tr>';
				}
		}
		echo '</table>';	
		date_default_timezone_set('America/Argentina/Buenos_Aires');
$fechaagre=date("Y-m-d");
$hora=date("G:i:s");
$fechaagre.=" ".$hora;	
$aa="UPDATE usuarios SET Fechaultnot='$fechaagre' where Iduser=$idusuario";	
$bb=mysqli_query($con,$aa) or die ("error buscando ".$aa);		
?>


	