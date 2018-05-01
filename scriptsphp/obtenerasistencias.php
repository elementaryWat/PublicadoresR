
<?
session_start();
$Mes=$_GET['Mes'];
$Anio=$_GET['Anio'];
$Congre = $_SESSION["Congregacion"];
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
	echo '<table>';
		while ($mref=mysqli_fetch_array($bb))
		{
			$idreunion=$mref['idreunion'];
			$Nombrereunion=$mref['Nombre'];
			$ab="select * from asistencias where Reunion=$idreunion AND  Mes=$Mes AND Anio=$Anio AND Congregacion=$Congre";	
			$ba=mysqli_query($con,$ab) or die ("error buscando ".$ab);
			$cantas=mysqli_num_rows($ba);
			$masis=mysqli_fetch_array($ba);
			if ($cantas!=0)
						{
							$Numreuniones=$masis['Numreuniones'];
							$Asistenciatot=$masis['Asistenciatot'];
							$Promedio=$masis['Promedio'];
							echo '<tr style="text-align:center;font-size:20px;background-color:#DAFED3">'
								.'<td width="20%"><img src="images/Pagina/ok.png" width="30" height="30" alt="datos" title="Asistencia de '.$nombremes.' de '.$Nombrepub.' completada"/></td>'
								.'<td width="80%"><span style="font-weight:bolder; font-size:22px">'.$Nombrereunion.'</span>  <a href="javascript:" onclick="editarasistencia(\''.$Nombrereunion.'\','.$idreunion.','.$Mes.','.$Anio.')"><img src="images/Pagina/editar2.png" width="30" height="30" alt="datos" title="Editar asistencia '.$nombremes.'/'.$Anio.' de '.$Nombrereunion.'"/></a>'
								.'<table width="100%" border="1" cellspacing="3" style="font-size:14px">'
								 .' <tr>'
									.'<td>Numero de reuniones</td>'
									.'<td>Asitencia total para mes</td>'
									.'<td>Promedio de asistencia semanal</td>'
								 .' </tr>'
								  .'<tr>'
									.'<td>'.$Numreuniones.'</td>'
									.'<td>'.$Asistenciatot.'</td>'
									.'<td>'.$Promedio.'</td>'
								  .'</tr>'
								.'</table>'
								.'</td>'
							 .' </tr>';
						}
						else
						{
							echo '<tr style="text-align:center;font-size:20px;background-color:#FFD7E6">'
								.'<td width="20%"><img src="images/Pagina/incorrecto.png" width="30" height="30" alt="datos" title="Asistencia de '.$nombremes.' de '.$Nombrereunion.' no completada"/></td>'
								.'<td width="80%"><span style="font-weight:bolder; font-size:22px">'.$Nombrereunion.'</span> <a href="javascript:" onclick="agregarasistencia(\''.$Nombrereunion.'\','.$idreunion.','.$Mes.','.$Anio.')"><img src="images/Pagina/mas1.png" width="30" height="30" alt="datos" title="Agregar asistencia '.$nombremes.'/'.$Anio.' de '.$Nombrereunion.'"/></a></td>'
							 .' </tr>';
						}
		}
		echo '</table>';			
?>


	