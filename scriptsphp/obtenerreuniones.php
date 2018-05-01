<?
session_start();
date_default_timezone_set('America/Argentina/Buenos_Aires');
$mes=date("m");
$aniopre=date("Y");
$Congre = $_SESSION["Congregacion"];
if ($mes==1)
{
	$mes=12;
	$anio-=1;
}
else
{
	$mes-=1;
}
$modo=$_GET['modo'];
$publicador=$_GET['publicador'];
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

	$aa="select * from reuniones ORDER BY Nombre Asc";	
	$bb=mysqli_query($con,$aa) or die ("error buscando ".$aa);
		while ($mref=mysqli_fetch_array($bb))
		{
			$idreunion=$mref['idreunion'];
			$Nombrereunion=$mref['Nombre'];
			$ad="select * from asistencias where Reunion=$idreunion AND Congregacion=$Congre ORDER BY Anio ASC";	
			$da=mysqli_query($con,$ad) or die ("error buscando ".$ad);
			$cantan=mysqli_num_rows($da);
			$anioactual=0;
			echo '<div id="acordeon'.$idreunion.'">'
			.'<h2>Ver historial de asistencias de '.$Nombrereunion.'</h2>'
				.'<div>';
				if ($cantan!=0)
				{
				while ($mrec=mysqli_fetch_array($da))
				{	
					$anio=$mrec['Anio'];
					if ($anioactual!=$anio)
					{
						//Determina si algun registro del año anterior fue asentado en la base de datos
						//De esta forma sabe si mostrar o no registros de meses de enero a agosto en caso de que los hubiera
						$aniop=$anioactual;
						$anioactual=$anio;
						if (($anioactual-1)!=$aniop)
						{
							$anioac=0;
							//Variable que se encarga de contar la cantidad de meses informados
							for ($x=1;$x<=8;$x++)
							 { 
								$pr="select * from asistencias where Reunion=$idreunion AND Mes=$x AND Anio=$anioactual AND Congregacion=$Congre";	
								$qpr=mysqli_query($con,$pr) or die ("error buscando ".$pr);
								$cpr=mysqli_num_rows($qpr);
								if ($cpr!=0)
								{
									$anioac++;
								}
							 }
							 if ($anioac!=0)
							 {
								 $Totalreuni=0;
								 $Totalasist=0;
								 $Totalsem=0;
								 echo '<p>Año de servicio '.($anioactual-1).'/'.$anioactual.'</p>';
								echo '<table width="100%" border="0" cellspacing="3">'
							  .'<tr>'
								.'<td>      </td>'
							   .' <td>Num de reuns.</td>'
							   .' <td>Asist. total para mes</td>'
							   .' <td>Prom. de asist. semanal</td>'
							 .' </tr>';
							 for ($x=9;$x<=12;$x++)
								 { 
									if ($anioactual != $aniopre || $x<=$mes)
									{
											echo '<tr>';
													switch($x)
													{
														case 1:
														echo '<td>Enero</td>';
														break;
														case 2:
														echo '<td>Febrero</td>';
														break;
														case 3:
														echo '<td>Marzo</td>';
														break;
														case 4:
														echo '<td>Abril</td>';
														break;
														case 5:
														echo '<td>Mayo</td>';
														break;
														case 6:
														echo '<td>Junio</td>';
														break;
														case 7:
														echo '<td>Julio</td>';
														break;
														case 8:
														echo '<td>Agosto</td>';
														break;
														case 9:
														echo '<td>Septiembre</td>';
														break;
														case 10:
														echo '<td>Octubre</td>';
														break;
														case 11:
														echo '<td>Noviembre</td>';
														break;
														case 12:
														echo '<td>Diciembre</td>';
														break;
													}
											echo ' <td align="center">-</td>'
												   .' <td align="center">-</td>'
												   .' <td align="center">-</td>';
											echo '</tr>';
									} 
								} 
								echo '<tr><td align="center">'.$anioactual.'</td></tr>';
								for ($x=1;$x<=8;$x++)
								 { 
									if ($anioactual != $aniopre || $x<=$mes)
									{
											$ae="select * from asistencias where Reunion=$idreunion AND Mes=$x AND Anio=$anioactual AND Congregacion=$Congre";	
											$ea=mysqli_query($con,$ae) or die ("error buscando ".$ae);
											$cantentm=mysqli_num_rows($ea);
											$mregis=mysqli_fetch_array($ea);
											echo '<tr>';
													switch($x)
													{
														case 1:
														echo '<td>Enero</td>';
														break;
														case 2:
														echo '<td>Febrero</td>';
														break;
														case 3:
														echo '<td>Marzo</td>';
														break;
														case 4:
														echo '<td>Abril</td>';
														break;
														case 5:
														echo '<td>Mayo</td>';
														break;
														case 6:
														echo '<td>Junio</td>';
														break;
														case 7:
														echo '<td>Julio</td>';
														break;
														case 8:
														echo '<td>Agosto</td>';
														break;
														case 9:
														echo '<td>Septiembre</td>';
														break;
														case 10:
														echo '<td>Octubre</td>';
														break;
														case 11:
														echo '<td>Noviembre</td>';
														break;
														case 12:
														echo '<td>Diciembre</td>';
														break;
													}
											if ($cantentm!=0)
											{
												$Numreuniones=$mregis['Numreuniones'];
												$Asistenciatot=$mregis['Asistenciatot'];
												$Promedio=$mregis['Promedio'];
												$Totalreuni+=$Numreuniones;
												$Totalasist+=$Asistenciatot;
												$Totalsem+=$Promedio;
												   echo ' <td align="center">'.$Numreuniones.'</td>'
													.' <td align="center">'.$Asistenciatot.'</td>'
													.' <td align="center">'.$Promedio.'</td>';
											}
											else
											{
												echo ' <td align="center">-</td>'
												   .' <td align="center">-</td>'
												   .' <td align="center">-</td>';
											}
											echo '</tr>';
									} 
								} 
								$Promedioreuni=round($Totalreuni/$anioac);
								$Promedioasist=round($Totalasist/$anioac);
								$Promediosem=round($Totalsem/$anioac);
									echo '<tr style="font-weight:bolder; font-size:18px">';
										echo ' <td align="center">Total</td>'
										.' <td align="center">'.$Totalreuni.'</td>'
										.' <td align="center">'.$Totalasist.'</td>'
										.' <td align="center">'.$Totalsem.'</td>';
									echo '</tr>';
									echo '<tr style="font-weight:bolder; font-size:18px">';
										echo ' <td align="center">Promedio</td>'
										.' <td align="center">'.$Promedioreuni.'</td>'
										.' <td align="center">'.$Promedioasist.'</td>'
										.' <td align="center">'.$Promediosem.'</td>';
									echo '</tr>';
								echo '</table>';
								echo '<p>&nbsp;</p>';
							}
						}
						$cantans=0;
						for ($x=9;$x<=12;$x++)
						 { 
							$pr="select * from asistencias where Reunion=$idreunion AND Mes=$x AND Anio=$anioactual AND Congregacion=$Congre";	
							$qpr=mysqli_query($con,$pr) or die ("error buscando ".$pr);
							$cpr=mysqli_num_rows($qpr);
							if ($cpr!=0)
							{
								$cantans++;
							}
						 }
						 for ($x=1;$x<=8;$x++)
						 { 
							$pr="select * from asistencias where Reunion=$idreunion AND Mes=$x AND Anio=($anioactual+1) AND Congregacion=$Congre";	
							$qpr=mysqli_query($con,$pr) or die ("error buscando ".$pr);
							$cpr=mysqli_num_rows($qpr);
							if ($cpr!=0)
							{
								$cantans++;
							}
						 }
						 if ($cantans!=0)
						 {
							  	$Totalreuni=0;
								 $Totalasist=0;
								 $Totalsem=0;
								 echo '<p>Año de servicio '.$anioactual.'/'.($anioactual+1).'</p>';
								echo '<table width="100%" border="0" cellspacing="3">'
							  .'<tr>'
								.'<td>      </td>'
							   .' <td>Num de reuns.</td>'
							   .' <td>Asist. total para mes</td>'
							   .' <td>Prom. de asist. semanal</td>'
						 .' </tr>';
						 for ($x=9;$x<=12;$x++)
						 { 
							if ($anioactual != $aniopre || $x<=$mes)
							{
								$ae="select * from asistencias where Reunion=$idreunion AND Mes=$x AND Anio=$anioactual AND Congregacion=$Congre";	
								$ea=mysqli_query($con,$ae) or die ("error buscando ".$ae);
								$cantentm=mysqli_num_rows($ea);
								$mregis=mysqli_fetch_array($ea);
								echo '<tr>';
										switch($x)
										{
											case 1:
											echo '<td>Enero</td>';
											break;
											case 2:
											echo '<td>Febrero</td>';
											break;
											case 3:
											echo '<td>Marzo</td>';
											break;
											case 4:
											echo '<td>Abril</td>';
											break;
											case 5:
											echo '<td>Mayo</td>';
											break;
											case 6:
											echo '<td>Junio</td>';
											break;
											case 7:
											echo '<td>Julio</td>';
											break;
											case 8:
											echo '<td>Agosto</td>';
											break;
											case 9:
											echo '<td>Septiembre</td>';
											break;
											case 10:
											echo '<td>Octubre</td>';
											break;
											case 11:
											echo '<td>Noviembre</td>';
											break;
											case 12:
											echo '<td>Diciembre</td>';
											break;
										}
								if ($cantentm!=0)
								{
									$Numreuniones=$mregis['Numreuniones'];
									$Asistenciatot=$mregis['Asistenciatot'];
									$Promedio=$mregis['Promedio'];
									$Totalreuni+=$Numreuniones;
									$Totalasist+=$Asistenciatot;
									$Totalsem+=$Promedio;
								   echo ' <td align="center">'.$Numreuniones.'</td>'
									.' <td align="center">'.$Asistenciatot.'</td>'
									.' <td align="center">'.$Promedio.'</td>';
								}
								else
								{
									echo ' <td align="center">-</td>'
									   .' <td align="center">-</td>'
									   .' <td align="center">-</td>';
								}
								echo '</tr>';
							}
						 }
						 echo '<tr><td align="center">'.($anioactual+1).'</td></tr>';
						 for ($x=1;$x<=8;$x++)
						 { 
							if (($anioactual+1) != $aniopre || $x<=$mes)
							{
								if (($anioactual+1)<=$aniopre)
								{
									$ae="select * from asistencias where Reunion=$idreunion AND Mes=$x AND Anio=($anioactual+1) AND Congregacion=$Congre";	
									$ea=mysqli_query($con,$ae) or die ("error buscando ".$ae);
									$cantentm=mysqli_num_rows($ea);
									$mregis=mysqli_fetch_array($ea);
									echo '<tr>';
											switch($x)
											{
												case 1:
												echo '<td>Enero</td>';
												break;
												case 2:
												echo '<td>Febrero</td>';
												break;
												case 3:
												echo '<td>Marzo</td>';
												break;
												case 4:
												echo '<td>Abril</td>';
												break;
												case 5:
												echo '<td>Mayo</td>';
												break;
												case 6:
												echo '<td>Junio</td>';
												break;
												case 7:
												echo '<td>Julio</td>';
												break;
												case 8:
												echo '<td>Agosto</td>';
												break;
												case 9:
												echo '<td>Septiembre</td>';
												break;
												case 10:
												echo '<td>Octubre</td>';
												break;
												case 11:
												echo '<td>Noviembre</td>';
												break;
												case 12:
												echo '<td>Diciembre</td>';
												break;
											}
									if ($cantentm!=0)
									{
										$Numreuniones=$mregis['Numreuniones'];
										$Asistenciatot=$mregis['Asistenciatot'];
										$Promedio=$mregis['Promedio'];
										$Totalreuni+=$Numreuniones;
										$Totalasist+=$Asistenciatot;
										$Totalsem+=$Promedio;
										   echo ' <td align="center">'.$Numreuniones.'</td>'
											.' <td align="center">'.$Asistenciatot.'</td>'
											.' <td align="center">'.$Promedio.'</td>';
									}
									else
									{
										echo ' <td align="center">-</td>'
										   .' <td align="center">-</td>'
										   .' <td align="center">-</td>';
									}
									echo '</tr>';
								}
							} 
						}
								$Promedioreuni=round($Totalreuni/$cantans);
								$Promedioasist=round($Totalasist/$cantans);
								$Promediosem=round($Totalsem/$cantans);
									echo '<tr style="font-weight:bolder; font-size:18px">';
										echo ' <td align="center">Total</td>'
										.' <td align="center">'.$Totalreuni.'</td>'
										.' <td align="center">'.$Totalasist.'</td>'
										.' <td align="center">'.$Totalsem.'</td>';
									echo '</tr>';
									echo '<tr style="font-weight:bolder; font-size:18px">';
										echo ' <td align="center">Promedio</td>'
										.' <td align="center">'.$Promedioreuni.'</td>'
										.' <td align="center">'.$Promedioasist.'</td>'
										.' <td align="center">'.$Promediosem.'</td>';
									echo '</tr>';
								echo '</table>';
								echo '<p>&nbsp;</p>';
					 }	
					}
					}
				}
				else
				{
					echo "No hay ningun registro de asistencia de esta reunion";
				}
			echo '</div>'
		.'</div>';
		}
	

?>


	