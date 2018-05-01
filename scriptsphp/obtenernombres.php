<? 
session_start();
$Congre = $_SESSION["Congregacion"];
$Tipo=$_GET['Tipo'];
$Mes=$_GET['Mes'];
$Anio=$_GET['Anio'];
$Grupo=$_GET['Grupo'];
$consg="";
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
$ac="select * from grupos where Congregacion=$Congre ORDER BY idgrupo Asc";	
$ca=mysqli_query($con,$ac) or die ("error buscando ".$ac);
$cantgrup=mysqli_num_rows($ca);
$anchoc='width="'.round(100/$cantgrup).'%"';
if ($Grupo!=0)
{
	$consg=" AND NumGrupo=$Grupo";
	$anchoc="";
}
switch($Tipo)
{	
	case 'informantes':
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
		$ac="select * from grupos where Congregacion=$Congre $consg ORDER BY idgrupo Asc";	
		$ca=mysqli_query($con,$ac) or die ("error buscando ".$ac);
		echo '<table width="100%" border="0" cellspacing="3" id="datnom">';
		  //Va recorriendo una matriz con los grupos
		echo '<tr>';
		while ($mgru=mysqli_fetch_array($ca))
		{
			$idgrupo=$mgru['idgrupo'];
			//Esta variable se encarga de contabilizar la cantidad de registros encontrados en un grupo pertenecientes al mes y año correspondientes
			$contengrupo=0;
			echo '<td '.$anchoc.'><p>Grupo '.$idgrupo.'</p>';
			$aa="select * from familias where Congregacion=$Congre ORDER BY Nombrefam Asc";	
			$bb=mysqli_query($con,$aa) or die ("error buscando ".$aa);
			echo '';
				while ($mref=mysqli_fetch_array($bb))
				{
				$idfamilia=$mref['idfamilia'];
				$Nombrefam=$mref['Nombrefam'];
				//En cada iteracion del ciclo consulta en la base de datos los publicadores que pertenecen al mismo
				//Esto a su vez crea una matriz 
				$ab="select * from publicadores where Familia=$idfamilia AND Grupo=$idgrupo ORDER BY Nombre Asc";
				$ba=mysqli_query($con,$ab) or die ("error buscando ".$ab);
					//En cada iteracion de este ciclo sobre la matriz de todos los publicadores del grupo actual de la iteracion superior
					//Se va consultando si el publicador informo el mes actual
					while ($mrecc=mysqli_fetch_array($ba))
					{
						$idpublicadorr=$mrecc['Idpublicadores'];
						$Nombre=$mrecc['Nombre'];
						$ad="select * from records2 where Publicador=$idpublicadorr AND Mes=$Mes AND Anio=$Anio";
						$da=mysqli_query($con,$ad) or die ("error buscando ".$ad);
						$cantpub=mysqli_num_rows($da);
						//Si informo simplemente muestra su nombre y apellido en una lista de la columna del grupo
						//e incrementa un contador de la cantidad de publicadores que informaron en este grupo
						if ($cantpub!=0)
						{
							echo '<p>'.$Nombre.' '.$Nombrefam.'</p>';
							$contengrupo++;
						}
					}
				}
				//Si ningun publicador informo este mes en este grupo muestra el mensaje correspondiente
				if ($contengrupo==0)
					{
						echo '<p>Ningun publicador de este grupo ha informado</p>';
					}
			echo '</td>';
		}
		echo '</tr>';
		echo '</table>';
	break;
	case 'noinformantes':
		$ac="select * from grupos where Congregacion=$Congre $consg ORDER BY idgrupo Asc";	
		$ca=mysqli_query($con,$ac) or die ("error buscando ".$ac);
		echo '<table width="100%" border="0" cellspacing="3" id="datnom">';
		  //Va recorriendo una matriz con los grupos
		echo '<tr>';
		while ($mgru=mysqli_fetch_array($ca))
		{
			$idgrupo=$mgru['idgrupo'];
			//Esta variable se encarga de contabilizar la cantidad de registros encontrados en un grupo pertenecientes al mes y año correspondientes
			$contengrupo=0;
			echo '<td '.$anchoc.'><p>Grupo '.$idgrupo.'</p>';
			$aa="select * from familias where Congregacion=$Congre ORDER BY Nombrefam Asc";	
			$bb=mysqli_query($con,$aa) or die ("error buscando ".$aa);
			echo '';
				while ($mref=mysqli_fetch_array($bb))
				{
				$idfamilia=$mref['idfamilia'];
				$Nombrefam=$mref['Nombrefam'];
				//En cada iteracion del ciclo consulta en la base de datos los publicadores que pertenecen al mismo
				//Esto a su vez crea una matriz 
				$ab="select * from publicadores where Familia=$idfamilia AND Grupo=$idgrupo ORDER BY Nombre Asc";
				$ba=mysqli_query($con,$ab) or die ("error buscando ".$ab);
					//En cada iteracion de este ciclo sobre la matriz de todos los publicadores del grupo actual de la iteracion superior
					//Se va consultando si el publicador informo el mes actual
					while ($mrecc=mysqli_fetch_array($ba))
					{
						$idpublicadorr=$mrecc['Idpublicadores'];
						$Nombre=$mrecc['Nombre'];
						$ad="select * from records2 where Publicador=$idpublicadorr AND Mes=$Mes AND Anio=$Anio";
						$da=mysqli_query($con,$ad) or die ("error buscando ".$ad);
						$cantpub=mysqli_num_rows($da);
						//Si el publicador no informo muestra su nombre y apellido en una lista de la columna del grupo
						//e incrementa un contador de la cantidad de publicadores que no informaron en este grupo
						if ($cantpub==0)
						{
							echo '<p>'.$Nombre.' '.$Nombrefam.'</p>';
							$contengrupo++;
						}
					}
				}
				//Si todos los publicadores informaron este mes en este grupo muestra el mensaje correspondiente
				if ($contengrupo==0)
					{
						echo '<p>Todos los publicadores informaron en este grupo</p>';
					}
			echo '</td>';
		}
		echo '</tr>';
		echo '</table>';
	break;
	case 'activos':
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
		$ac="select * from grupos where Congregacion=$Congre $consg ORDER BY idgrupo Asc";		
		$ca=mysqli_query($con,$ac) or die ("error buscando ".$ac);
		echo '<table width="100%" border="0" cellspacing="3" id="datnom">';
		  //Va recorriendo una matriz con los grupos
		echo '<tr>';
		while ($mgru=mysqli_fetch_array($ca))
		{
			$idgrupo=$mgru['idgrupo'];
			//Esta variable se encarga de contabilizar la cantidad de registros encontrados en un grupo pertenecientes al mes y año correspondientes
			$contengrupo=0;
			echo '<td '.$anchoc.'><p>Grupo '.$idgrupo.'</p>';
			$aa="select * from familias where Congregacion=$Congre ORDER BY Nombrefam Asc";	
			$bb=mysqli_query($con,$aa) or die ("error buscando ".$aa);
			echo '';
				while ($mref=mysqli_fetch_array($bb))
				{
				$idfamilia=$mref['idfamilia'];
				$Nombrefam=$mref['Nombrefam'];
				//En cada iteracion del ciclo consulta en la base de datos los publicadores que pertenecen al mismo
				//Esto a su vez crea una matriz 
				$ab="select * from publicadores where Familia=$idfamilia AND Grupo=$idgrupo ORDER BY Nombre Asc";
				$ba=mysqli_query($con,$ab) or die ("error buscando ".$ab);
				$canta=0;
					//En cada iteracion de este ciclo sobre la matriz de todos los publicadores del grupo actual de la iteracion superior
					//Se va consultando si el publicador informo el mes actual
					while ($mrecc=mysqli_fetch_array($ba))
					{
						$cantmes=0;
						$idpublicador=$mrecc['Idpublicadores'];
						$nompublicador=$mrecc['Nombre'];
						if ($mes<6)
						{
							$difanio=6-$mes;
							$anioseiser=$anio-1;
							$meseiser=12-($difanio-1);
							for ($x=$meseiser;$x<=12;$x++)
							{
								$af="select * from records2 where Publicador=$idpublicador AND Mes=$x AND Anio=$anioseiser";
								$fa=mysqli_query($con,$af) or die ("error buscando ".$af);
								$canttemp=mysqli_num_rows($fa);
								if ($canttemp!=0)
								{
									$cantmes++;	
								}
							}
							for ($x=1;$x<=$mes;$x++)
							{
								$af="select * from records2 where Publicador=$idpublicador AND Mes=$x AND Anio=$anio";
								$fa=mysqli_query($con,$af) or die ("error buscando ".$af);
								$canttemp=mysqli_num_rows($fa);
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
								$af="select * from records2 where Publicador=$idpublicador AND Mes=$x AND Anio=$anio";
								$fa=mysqli_query($con,$af) or die ("error buscando ".$af);
								$canttemp=mysqli_num_rows($fa);
								if ($canttemp!=0)
								{
									$cantmes++;	
								}
							}
						}
						if ($cantmes>=1)
						{
							echo '<p>'.$nompublicador.' '.$Nombrefam.'</p>';
							$contengrupo++;
						}
					}
				}
				//Si todos los publicadores informaron este mes en este grupo muestra el mensaje correspondiente
				if ($contengrupo==0)
					{
						echo '<p>No hay ningun publicador activo en este grupo</p>';
					}
			echo '</td>';
		}
		echo '</tr>';
		echo '</table>';
	
	break;
	case 'inactivos':
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
		$ac="select * from grupos where Congregacion=$Congre $consg ORDER BY idgrupo Asc";		
		$ca=mysqli_query($con,$ac) or die ("error buscando ".$ac);
		echo '<table width="100%" border="0" cellspacing="3" id="datnom">';
		  //Va recorriendo una matriz con los grupos
		echo '<tr>';
		while ($mgru=mysqli_fetch_array($ca))
		{
			$idgrupo=$mgru['idgrupo'];
			//Esta variable se encarga de contabilizar la cantidad de registros encontrados en un grupo pertenecientes al mes y año correspondientes
			$contengrupo=0;
			echo '<td '.$anchoc.'><p>Grupo '.$idgrupo.'</p>';
			$aa="select * from familias where Congregacion=$Congre ORDER BY Nombrefam Asc";	
			$bb=mysqli_query($con,$aa) or die ("error buscando ".$aa);
			echo '';
				while ($mref=mysqli_fetch_array($bb))
				{
				$idfamilia=$mref['idfamilia'];
				$Nombrefam=$mref['Nombrefam'];
				//En cada iteracion del ciclo consulta en la base de datos los publicadores que pertenecen al mismo
				//Esto a su vez crea una matriz 
				$ab="select * from publicadores where Familia=$idfamilia AND Grupo=$idgrupo ORDER BY Nombre Asc";
				$ba=mysqli_query($con,$ab) or die ("error buscando ".$ab);
				$canta=0;
					//En cada iteracion de este ciclo sobre la matriz de todos los publicadores del grupo actual de la iteracion superior
					//Se va consultando si el publicador informo el mes actual
					while ($mrecc=mysqli_fetch_array($ba))
					{
						$cantmes=0;
						$idpublicador=$mrecc['Idpublicadores'];
						$nompublicador=$mrecc['Nombre'];
						if ($mes<6)
						{
							$difanio=6-$mes;
							$anioseiser=$anio-1;
							$meseiser=12-($difanio-1);
							for ($x=$meseiser;$x<=12;$x++)
							{
								$af="select * from records2 where Publicador=$idpublicador AND Mes=$x AND Anio=$anioseiser";
								$fa=mysqli_query($con,$af) or die ("error buscando ".$af);
								$canttemp=mysqli_num_rows($fa);
								if ($canttemp!=0)
								{
									$cantmes++;	
								}
							}
							for ($x=1;$x<=$mes;$x++)
							{
								$af="select * from records2 where Publicador=$idpublicador AND Mes=$x AND Anio=$anio";
								$fa=mysqli_query($con,$af) or die ("error buscando ".$af);
								$canttemp=mysqli_num_rows($fa);
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
								$af="select * from records2 where Publicador=$idpublicador AND Mes=$x AND Anio=$anio";
								$fa=mysqli_query($con,$af) or die ("error buscando ".$af);
								$canttemp=mysqli_num_rows($fa);
								if ($canttemp!=0)
								{
									$cantmes++;	
								}
							}
						}
						if ($cantmes==0)
						{
							echo '<p>'.$nompublicador.' '.$Nombrefam.'</p>';
							$contengrupo++;
						}
					}
				}
				//Si todos los publicadores informaron este mes en este grupo muestra el mensaje correspondiente
				if ($contengrupo==0)
					{
						echo '<p>No hay ningun publicador inactivo en este grupo</p>';
					}
			echo '</td>';
		}
		echo '</tr>';
		echo '</table>';
	
	break;
	case 'publicadores':
	$Mes=$_GET['Mes'];
	$Anio=$_GET['Anio'];
			$ac="select * from grupos where Congregacion=$Congre $consg ORDER BY idgrupo Asc";		
		$ca=mysqli_query($con,$ac) or die ("error buscando ".$ac);
		echo '<table width="100%" border="0" cellspacing="3" id="datnom">';
		  //Va recorriendo una matriz con los grupos
		echo '<tr>';
		while ($mgru=mysqli_fetch_array($ca))
		{
			$idgrupo=$mgru['idgrupo'];
			//Esta variable se encarga de contabilizar la cantidad de registros encontrados en un grupo pertenecientes al mes y año correspondientes
			$contengrupo=0;
			echo '<td '.$anchoc.'><p>Grupo '.$idgrupo.'</p>';
			$aa="select * from familias where Congregacion=$Congre ORDER BY Nombrefam Asc";	
			$bb=mysqli_query($con,$aa) or die ("error buscando ".$aa);
			echo '';
				while ($mref=mysqli_fetch_array($bb))
				{
				$idfamilia=$mref['idfamilia'];
				$Nombrefam=$mref['Nombrefam'];
				//En cada iteracion del ciclo consulta en la base de datos los publicadores que pertenecen al mismo
				//Esto a su vez crea una matriz 
				$ab="select * from publicadores where Familia=$idfamilia AND Grupo=$idgrupo ORDER BY Nombre Asc";
				$ba=mysqli_query($con,$ab) or die ("error buscando ".$ab);
					//En cada iteracion de este ciclo sobre la matriz de todos los publicadores del grupo actual de la iteracion superior
					//Se va consultando si el publicador informo el mes actual
					while ($mrecc=mysqli_fetch_array($ba))
					{
						$idpublicadorr=$mrecc['Idpublicadores'];
						$Nombre=$mrecc['Nombre'];
						$ad='SELECT * FROM records2 WHERE Mes='.$Mes.' AND Anio='.$Anio.' AND Publicador='.$idpublicadorr.' AND (Precreg = "NO" AND Precaux = "NO")';
						$da=mysqli_query($con,$ad) or die ("error buscando ".$ad);
						$cantpub=mysqli_num_rows($da);
						//Si el publicador no informo muestra su nombre y apellido en una lista de la columna del grupo
						//e incrementa un contador de la cantidad de publicadores que no informaron en este grupo
						if ($cantpub!=0)
						{
							echo '<p>'.$Nombre.' '.$Nombrefam.'</p>';
							$contengrupo++;
						}
					}
				}
				//Si todos los publicadores informaron este mes en este grupo muestra el mensaje correspondiente
				if ($contengrupo==0)
					{
						echo '<p>No hay ningun publicador que haya informado en este grupo este mes</p>';
					}
			echo '</td>';
		}
		echo '</tr>';
		echo '</table>';
	break;
	case 'precursoresauxiliares':
	$Mes=$_GET['Mes'];
	$Anio=$_GET['Anio'];
		$ac="select * from grupos where Congregacion=$Congre $consg ORDER BY idgrupo Asc";
		$ca=mysqli_query($con,$ac) or die ("error buscando ".$ac);
		echo '<table width="100%" border="0" cellspacing="3" id="datnom">';
		  //Va recorriendo una matriz con los grupos
		echo '<tr>';
		while ($mgru=mysqli_fetch_array($ca))
		{
			$idgrupo=$mgru['idgrupo'];
			//Esta variable se encarga de contabilizar la cantidad de registros encontrados en un grupo pertenecientes al mes y año correspondientes
			$contengrupo=0;
			echo '<td '.$anchoc.'><p>Grupo '.$idgrupo.'</p>';
			$aa="select * from familias where Congregacion=$Congre ORDER BY Nombrefam Asc";	
			$bb=mysqli_query($con,$aa) or die ("error buscando ".$aa);
			echo '';
				while ($mref=mysqli_fetch_array($bb))
				{
				$idfamilia=$mref['idfamilia'];
				$Nombrefam=$mref['Nombrefam'];
				//En cada iteracion del ciclo consulta en la base de datos los publicadores que pertenecen al mismo
				//Esto a su vez crea una matriz 
				$ab="select * from publicadores where Familia=$idfamilia AND Grupo=$idgrupo ORDER BY Nombre Asc";
				$ba=mysqli_query($con,$ab) or die ("error buscando ".$ab);
					//En cada iteracion de este ciclo sobre la matriz de todos los publicadores del grupo actual de la iteracion superior
					//Se va consultando si el publicador informo el mes actual
					while ($mrecc=mysqli_fetch_array($ba))
					{
						$idpublicadorr=$mrecc['Idpublicadores'];
						$Nombre=$mrecc['Nombre'];
						$ad='SELECT * FROM records2 WHERE Mes='.$Mes.' AND Anio='.$Anio.' AND Publicador='.$idpublicadorr.' AND  Precaux = "SI"';
						$da=mysqli_query($con,$ad) or die ("error buscando ".$ad);
						$cantpub=mysqli_num_rows($da);
						//Si el publicador es precursor auxiliar se muestra su nombre y apellido en una lista de la columna del grupo
						//e incrementa un contador de la cantidad de precursores este grupo
						if ($cantpub!=0)
						{
							echo '<p>'.$Nombre.' '.$Nombrefam.'</p>';
							$contengrupo++;
						}
					}
				}
				//Si todos los publicadores informaron este mes en este grupo muestra el mensaje correspondiente
				if ($contengrupo==0)
					{
						echo '<p>No hay ningun precursor auxiliar que haya informado en este grupo este mes</p>';
					}
			echo '</td>';
		}
		echo '</tr>';
		echo '</table>';
	break;
	case 'precursoresregulares':
	$Mes=$_GET['Mes'];
	$Anio=$_GET['Anio'];
		$ac="select * from grupos where Congregacion=$Congre $consg ORDER BY idgrupo Asc";	
		$ca=mysqli_query($con,$ac) or die ("error buscando ".$ac);
		echo '<table width="100%" border="0" cellspacing="3" id="datnom">';
		  //Va recorriendo una matriz con los grupos
		echo '<tr>';
		while ($mgru=mysqli_fetch_array($ca))
		{
			$idgrupo=$mgru['idgrupo'];
			//Esta variable se encarga de contabilizar la cantidad de registros encontrados en un grupo pertenecientes al mes y año correspondientes
			$contengrupo=0;
			echo '<td '.$anchoc.'><p>Grupo '.$idgrupo.'</p>';
			$aa="select * from familias where Congregacion=$Congre ORDER BY Nombrefam Asc";	
			$bb=mysqli_query($con,$aa) or die ("error buscando ".$aa);
			echo '';
				while ($mref=mysqli_fetch_array($bb))
				{
				$idfamilia=$mref['idfamilia'];
				$Nombrefam=$mref['Nombrefam'];
				//En cada iteracion del ciclo consulta en la base de datos los publicadores que pertenecen al mismo
				//Esto a su vez crea una matriz 
				$ab="select * from publicadores where Familia=$idfamilia AND Grupo=$idgrupo ORDER BY Nombre Asc";
				$ba=mysqli_query($con,$ab) or die ("error buscando ".$ab);
					//En cada iteracion de este ciclo sobre la matriz de todos los publicadores del grupo actual de la iteracion superior
					//Se va consultando si el publicador informo el mes actual
					while ($mrecc=mysqli_fetch_array($ba))
					{
						$idpublicadorr=$mrecc['Idpublicadores'];
						$Nombre=$mrecc['Nombre'];
						$ad='SELECT * FROM records2 WHERE Mes='.$Mes.' AND Anio='.$Anio.' AND Publicador='.$idpublicadorr.' AND Precreg = "SI"';
						$da=mysqli_query($con,$ad) or die ("error buscando ".$ad);
						$cantpub=mysqli_num_rows($da);
						//Si el publicador es precursor regular se muestra su nombre y apellido en una lista de la columna del grupo
						//e incrementa un contador de la cantidad de precursores este grupo
						if ($cantpub!=0)
						{
							echo '<p>'.$Nombre.' '.$Nombrefam.'</p>';
							$contengrupo++;
						}
					}
				}
				//Si todos los publicadores informaron este mes en este grupo muestra el mensaje correspondiente
				if ($contengrupo==0)
					{
						echo '<p>No hay ningun precursor regular que haya informado en este grupo este mes</p>';
					}
			echo '</td>';
		}
		echo '</tr>';
	break;
}
?>