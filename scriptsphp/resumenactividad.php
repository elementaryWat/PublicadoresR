
<?
$meses=array(
	1 => "Enero",
	2 => "Febrero",
	3 => "Marzo",
	4 => "Abril",
	5 => "Mayo",
	6 => "Junio",
	7 => "Julio",
	8 => "Agosto",
	9 => "Septiembre",
	10 => "Octubre",
	11 => "Noviembre",
	12 => "Diciembre"
);
session_start();
$criterio=$_GET['criterio'];
$servidor=$_SESSION['servidor'];
$dbusuario=$_SESSION['dbusuario'];
$dbcontrasena=$_SESSION['dbcontrasena'];
$nomdb=$_SESSION['nomdb'];
$mendb=$_SESSION['condb'];
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
$con=mysqli_connect($servidor,$dbusuario,$dbcontrasena);
mysqli_select_db($con,$nomdb) or die ($mendb);
$Congre = $_SESSION["Congregacion"];
	$cadenac='';
	if ($criterio=='')
	{
		$cadenac="";
	}
	else
	{
		switch($criterio)
		{
			case 'Ancianos':
				$cadenac=" AND publicadores.Anciano='SI'";
			break;
			case 'Siervosministeriales':
				$cadenac=" AND publicadores.Siervomin='SI'";
			break;
			case 'Precursoresregulares':
				$cadenac=" AND publicadores.Precreg='SI'";
			break;
			case 'Publicadores':
				$cadenac=" AND publicadores.Precreg='NO'";
			break;
		}
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
	$tpromediopublicaciones=0;
	$tpromediovideos=0;
	$tpromediohoras=0;
	$tpromediorevisitas=0;
	$tpromedioestbib=0;
	$idactual=0;
	$sal= '<table width="100%" border="1">
			  <tbody>
			    <tr>
			      <td></td>
			      <td>Publicaciones</td>
			      <td>Videos</td>
			      <td>Horas</td>
			      <td>Revisitas</td>
			      <td>Estudios</td>
		        </tr>';
	$ab="SELECT publicadores.`Idpublicadores` FROM  `publicadores` INNER JOIN familias ON publicadores.Familia = familias.idfamilia AND familias.Congregacion =$Congre $cadenac";
		if ($mes<6)
			{
				$difanio=6-$mes;
				$anioseiser=$anio-1;
				$meseiser=12-($difanio-1);
				for ($x=$meseiser;$x<=12;$x++)
				{
					$ba=mysqli_query($con,$ab) or die ("error buscando ".$ab);
					$cantrecords=mysqli_num_rows($ba);
					$totalparpublicaciones=0;
					$totalparvideos=0;
					$totalparhoras=0;
					$totalparrevisitas=0;
					$totalparestbib=0;
					$promedioparpublicaciones=0;
					$promedioparvideos=0;
					$promedioparhoras=0;
					$promedioparrevisitas=0;
					$promedioparestbib=0;
					while ($mrecc=mysqli_fetch_array($ba))
					{
						$idpublicador=$mrecc['Idpublicadores'];
						$ac="select * from records2 where Publicador=$idpublicador AND Mes=$x AND Anio=$anioseiser";
						$ca=mysqli_query($con,$ac) or die ("error buscando ".$ac);
						$canttemp=mysqli_num_rows($ca);
						$mref=mysqli_fetch_array($ca);
						if ($canttemp!=0)
						{
							$Publicaciones=$mref['Publicaciones'];
							$totalparpublicaciones+=$Publicaciones;
							$totalpublicaciones+=$Publicaciones;
							$Videos=$mref['Videos'];
							$totalparvideos+=$Videos;
							$totalvideos+=$Videos;
							$Horas=$mref['Horas'];
							$totalparhoras+=$Horas;
							$totalhoras+=$Horas;
							$Revisitas=$mref['Revisitas'];
							$totalparrevisitas+=$Revisitas;
							$totalrevisitas+=$Revisitas;
							$Estbib=$mref['Estbib'];
							$totalparestbib+=$Estbib;
							$totalestbib+=$Estbib;		
						}
					}	
					$promedioparpublicaciones=round($totalparpublicaciones/($cantrecords),2);
					$promedioparvideos=round($totalparvideos/($cantrecords),2);
					$promedioparhoras=round($totalparhoras/($cantrecords),2);
					$promedioparrevisitas=round($totalparrevisitas/($cantrecords),2);
					$promedioparestbib=round($totalparestbib/($cantrecords),2);
					$sal.='
						<tr>
					      <td colspan="6" align="center"><strong>'.$meses[$x].'</strong></td>
				        </tr>
						<tr>
					      <td>Total</td>
					      <td>'.$totalparpublicaciones.'</td>
					      <td>'.$totalparvideos.'</td>
					      <td>'.$totalparhoras.'</td>
					      <td>'.$totalparrevisitas.'</td>
					      <td>'.$totalparestbib.'</td>
				        </tr>
						<tr>
					      <td>Promedio</td>
					      <td>'.$promedioparpublicaciones.'</td>
					      <td>'.$promedioparvideos.'</td>
					      <td>'.$promedioparhoras.'</td>
					      <td>'.$promedioparrevisitas.'</td>
					      <td>'.$promedioparestbib.'</td>
				        </tr>';
				}
				for ($x=1;$x<=$mes;$x++)
				{
					$ba=mysqli_query($con,$ab) or die ("error buscando ".$ab);
					$cantrecords=mysqli_num_rows($ba);
					$totalparpublicaciones=0;
					$totalparvideos=0;
					$totalparhoras=0;
					$totalparrevisitas=0;
					$totalparestbib=0;
					$promedioparpublicaciones=0;
					$promedioparvideos=0;
					$promedioparhoras=0;
					$promedioparrevisitas=0;
					$promedioparestbib=0;
					while ($mrecc=mysqli_fetch_array($ba))
					{
						$idpublicador=$mrecc['Idpublicadores'];
						$ac="select * from records2 where Publicador=$idpublicador AND Mes=$x AND Anio=$anioseiser";
						$ca=mysqli_query($con,$ac) or die ("error buscando ".$ac);
						$canttemp=mysqli_num_rows($ca);
						$mref=mysqli_fetch_array($ca);
						if ($canttemp!=0)
						{
							$Publicaciones=$mref['Publicaciones'];
							$totalparpublicaciones+=$Publicaciones;
							$totalpublicaciones+=$Publicaciones;
							$Videos=$mref['Videos'];
							$totalparvideos+=$Videos;
							$totalvideos+=$Videos;
							$Horas=$mref['Horas'];
							$totalparhoras+=$Horas;
							$totalhoras+=$Horas;
							$Revisitas=$mref['Revisitas'];
							$totalparrevisitas+=$Revisitas;
							$totalrevisitas+=$Revisitas;
							$Estbib=$mref['Estbib'];
							$totalparestbib+=$Estbib;
							$totalestbib+=$Estbib;	
						}
					}	
					$promedioparpublicaciones=round($totalparpublicaciones/($cantrecords),2);
					$promedioparvideos=round($totalparvideos/($cantrecords),2);
					$promedioparhoras=round($totalparhoras/($cantrecords),2);
					$promedioparrevisitas=round($totalparrevisitas/($cantrecords),2);
					$promedioparestbib=round($totalparestbib/($cantrecords),2);
					$sal.='
						<tr>
					      <td colspan="6" align="center"><strong>'.$meses[$x].'</strong></td>
				        </tr>
						<tr>
					      <td>Total</td>
					      <td>'.$totalparpublicaciones.'</td>
					      <td>'.$totalparvideos.'</td>
					      <td>'.$totalparhoras.'</td>
					      <td>'.$totalparrevisitas.'</td>
					      <td>'.$totalparestbib.'</td>
				        </tr>
						<tr>
					      <td>Promedio</td>
					      <td>'.$promedioparpublicaciones.'</td>
					      <td>'.$promedioparvideos.'</td>
					      <td>'.$promedioparhoras.'</td>
					      <td>'.$promedioparrevisitas.'</td>
					      <td>'.$promedioparestbib.'</td>
				        </tr>';
				}
			}
			else
			{
				$meseiser=$mes-(5);
				for ($x=$meseiser;$x<=$mes;$x++)
				{
					$ba=mysqli_query($con,$ab) or die ("error buscando ".$ab);
					$cantrecords=mysqli_num_rows($ba);
					$totalparpublicaciones=0;
					$totalparvideos=0;
					$totalparhoras=0;
					$totalparrevisitas=0;
					$totalparestbib=0;
					$promedioparpublicaciones=0;
					$promedioparvideos=0;
					$promedioparhoras=0;
					$promedioparrevisitas=0;
					$promedioparestbib=0;
					while ($mrecc=mysqli_fetch_array($ba))
					{
						$idpublicador=$mrecc['Idpublicadores'];
						$ac="select * from records2 where Publicador=$idpublicador AND Mes=$x AND Anio=$anio";
						$ca=mysqli_query($con,$ac) or die ("error buscando ".$ac);
						$canttemp=mysqli_num_rows($ca);
						$mref=mysqli_fetch_array($ca);
						if ($canttemp!=0)
						{
							$Publicaciones=$mref['Publicaciones'];
							$totalparpublicaciones+=$Publicaciones;
							$totalpublicaciones+=$Publicaciones;
							$Videos=$mref['Videos'];
							$totalparvideos+=$Videos;
							$totalvideos+=$Videos;
							$Horas=$mref['Horas'];
							$totalparhoras+=$Horas;
							$totalhoras+=$Horas;
							$Revisitas=$mref['Revisitas'];
							$totalparrevisitas+=$Revisitas;
							$totalrevisitas+=$Revisitas;
							$Estbib=$mref['Estbib'];
							$totalparestbib+=$Estbib;
							$totalestbib+=$Estbib;			
						}
					}	
					$promedioparpublicaciones=round($totalparpublicaciones/($cantrecords),2);
					$promedioparvideos=round($totalparvideos/($cantrecords),2);
					$promedioparhoras=round($totalparhoras/($cantrecords),2);
					$promedioparrevisitas=round($totalparrevisitas/($cantrecords),2);
					$promedioparestbib=round($totalparestbib/($cantrecords),2);
					$sal.='
						<tr>
					      <td colspan="6" align="center"><strong>'.$meses[$x].'</strong></td>
				        </tr>
						<tr>
					      <td>Total</td>
					      <td>'.$totalparpublicaciones.'</td>
					      <td>'.$totalparvideos.'</td>
					      <td>'.$totalparhoras.'</td>
					      <td>'.$totalparrevisitas.'</td>
					      <td>'.$totalparestbib.'</td>
				        </tr>
						<tr>
					      <td>Promedio</td>
					      <td>'.$promedioparpublicaciones.'</td>
					      <td>'.$promedioparvideos.'</td>
					      <td>'.$promedioparhoras.'</td>
					      <td>'.$promedioparrevisitas.'</td>
					      <td>'.$promedioparestbib.'</td>
				        </tr>';
				}
			}
		
		$promediopublicaciones=round($totalpublicaciones/($cantrecords*6),2);
		$promediovideos=round($totalvideos/($cantrecords*6),2);
		$promediohoras=round($totalhoras/($cantrecords*6),2);
		$promediorevisitas=round($totalrevisitas/($cantrecords*6),2);
		$promedioestbib=round($totalestbib/($cantrecords*6),2);
		
			   $sal.='
			   <tr>
			      <td> </td>
			      <td> </td>
			      <td> </td>
			      <td> </td>
			      <td> </td>
			      <td> </td>
		        </tr>
			   <tr>
			      <td><strong>Total general</strong></td>
			      <td>'.$totalpublicaciones.'</td>
			      <td>'.$totalvideos.'</td>
			      <td>'.$totalhoras.'</td>
			      <td>'.$totalrevisitas.'</td>
			      <td>'.$totalestbib.'</td>
		        </tr>
				<tr>
			      <td><strong>Promedio General</strong></td>
			      <td>'.$promediopublicaciones.'</td>
			      <td>'.$promediovideos.'</td>
			      <td>'.$promediohoras.'</td>
			      <td>'.$promediorevisitas.'</td>
			      <td>'.$promedioestbib.'</td>
		        </tr>
		      </tbody>
		  </table>';
	echo $sal;
?>


	