<?
date_default_timezone_set('America/Argentina/Buenos_Aires');
$mes=date("m");
$aniopre=date("Y");
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
$con=mysqli_connect("mysql.hostinger.com.ar","u300421416_root","registrospnb");
mysqli_select_db($con,"u300421416_regis") or die ("no se ha podido encontrar la base de datos");
$aa="select Date_format(Fechanac,'%W') AS ndnac,Date_format(Fechanac,'%d') AS dnac,Date_format(Fechanac,'%M') AS mnac,Date_format(Fechanac,'%Y') AS anac,Date_format(Fechabau,'%W') AS ndbau,Date_format(Fechabau,'%d') AS dbau,Date_format(Fechabau,'%M') AS mbau,Date_format(Fechabau,'%Y') AS abau,Unguotro,Sexo,Anciano,Siervomin,Precreg,Nombre,Familia from publicadores where Idpublicadores=$publicador";	
$bb=mysqli_query($con,$aa) or die ("error buscando ".$aa);
$mref=mysqli_fetch_array($bb);
$Nombrepub=$mref['Nombre'];
$Unguotro=$mref['Unguotro'];
$Sexo=$mref['Sexo'];
$Anciano=$mref['Anciano'];
$Siervomin=$mref['Siervomin'];
$Precreg=$mref['Precreg'];
$Familia=$mref['Familia'];
$ndnac=$mref['ndnac'];
$dnac=$mref['dnac'];
$mnac=$mref['mnac'];
$anac=$mref['anac'];
$ndbau=$mref['ndbau'];
$dbau=$mref['dbau'];
$mbau=$mref['mbau'];
$abau=$mref['abau'];

//--------------------------------------------------------------
//Determina si la fecha sera mostrada o no en un datepicker
switch($modo)
{
	case "edicion":
		if ($mnac == "January"){
		  $mnac = "01";
		  }
		  if ($mnac == "February"){
		  $mnac = "02";
		  }
		  if ($mnac == "March"){
		  $mnac = "03";
		  }
		  if ($mnac == "April"){
		  $mnac = "04";
		  }
		  if ($mnac == "May"){
		  $mnac = "05";
		  }
		  if ($mnac == "June"){
		  $mnac = "06";
		  }
		  if ($mnac == "July"){
		  $mnac = "07";
		  }
		  if ($mnac == "August"){
		  $mnac = "08";
		  }
		  if ($mnac == "September"){
		  $mnac = "09";
		  }
		  if ($mnac == "October"){
		  $mnac = "10";
		  }
		  if ($mnac == "November"){
		  $mnac = "11";
		  }
		  if ($mnac == "December"){
		  $mnac = "12";
		  }
		$fechanac =$dnac."/".$mnac."/".$anac;
		if ($mbau == "January"){
		  $mbau = "01";
		  }
		  if ($mbau == "February"){
		  $mbau = "02";
		  }
		  if ($mbau == "March"){
		  $mbau = "03";
		  }
		  if ($mbau == "April"){
		  $mbau = "04";
		  }
		  if ($mbau == "May"){
		  $mbau = "05";
		  }
		  if ($mbau == "June"){
		  $mbau = "06";
		  }
		  if ($mbau == "July"){
		  $mbau = "07";
		  }
		  if ($mbau == "August"){
		  $mbau = "08";
		  }
		  if ($mbau == "September"){
		  $mbau = "09";
		  }
		  if ($mbau == "October"){
		  $mbau = "10";
		  }
		  if ($mbau == "November"){
		  $mbau = "11";
		  }
		  if ($mbau == "December"){
		  $mbau = "12";
		  }
		$fechabau =$dbau."/".$mbau."/".$abau;
	break;
	case "vista":
		if ($ndnac == "Monday"){
	  $ndnac = "Lunes";
	  }
	  if ($ndnac == "Tuesday"){
	  $ndnac = "Martes";
	  }
	  if ($ndnac == "Wednesday"){
	  $ndnac = "Miércoles";
	  }
	  if ($ndnac == "Thursday"){
	  $ndnac = "Jueves";
	  }
	  if ($ndnac == "Friday"){
	  $ndnac = "Viernes";
	  }
	  if ($ndnac == "Saturday"){
	  $ndnac = "Sábado";
	  }
	  if ($ndnac == "Sunday"){
	  $ndnac = "Domingo";
	  }
	  
	  if ($mnac == "January"){
	  $mnac = "Enero";
	  }
	  if ($mnac == "February"){
	  $mnac = "Febrero";
	  }
	  if ($mnac == "March"){
	  $mnac = "Marzo";
	  }
	  if ($mnac == "April"){
	  $mnac = "Abril";
	  }
	  if ($mnac == "May"){
	  $mnac = "Mayo";
	  }
	  if ($mnac == "June"){
	  $mnac = "Junio";
	  }
	  if ($mnac == "July"){
	  $mnac = "Julio";
	  }
	  if ($mnac == "August"){
	  $mnac = "Agosto";
	  }
	  if ($mnac == "September"){
	  $mnac = "Septiembre";
	  }
	  if ($mnac == "October"){
	  $mnac = "Octubre";
	  }
	  if ($mnac == "November"){
	  $mnac = "Noviembre";
	  }
	  if ($mnac == "December"){
	  $mnac = "Diciembre";
	  }
	  $fechanac =$ndnac." ".$dnac."/".$mnac."/".$anac;
	//--------------------------------------------------------------
	//--------------------------------------------------------------
	if ($ndbau == "Monday"){
	  $ndbau = "Lunes";
	  }
	  if ($ndbau == "Tuesday"){
	  $ndbau = "Martes";
	  }
	  if ($ndbau == "Wednesday"){
	  $ndbau = "Miércoles";
	  }
	  if ($ndbau == "Thursday"){
	  $ndbau = "Jueves";
	  }
	  if ($ndbau == "Friday"){
	  $ndbau = "Viernes";
	  }
	  if ($ndbau == "Saturday"){
	  $ndbau = "Sábado";
	  }
	  if ($ndbau == "Sunday"){
	  $ndbau = "Domingo";
	  }
	  
	  if ($mbau == "January"){
	  $mbau = "Enero";
	  }
	  if ($mbau == "February"){
	  $mbau = "Febrero";
	  }
	  if ($mbau == "March"){
	  $mbau = "Marzo";
	  }
	  if ($mbau == "April"){
	  $mbau = "Abril";
	  }
	  if ($mbau == "May"){
	  $mbau = "Mayo";
	  }
	  if ($mbau == "June"){
	  $mbau = "Junio";
	  }
	  if ($mbau == "July"){
	  $mbau = "Julio";
	  }
	  if ($mbau == "August"){
	  $mbau = "Agosto";
	  }
	  if ($mbau == "September"){
	  $mbau = "Septiembre";
	  }
	  if ($mbau == "October"){
	  $mbau = "Octubre";
	  }
	  if ($mbau == "November"){
	  $mbau = "Noviembre";
	  }
	  if ($mbau == "December"){
	  $mbau = "Diciembre";
	  }
	  $fechabau =$ndbau." ".$dbau."/".$mbau."/".$abau;
	break;
}
	
//--------------------------------------------------------------


switch ($modo)
{
	case "edicion":
		echo '<table width="100%" border="0" cellspacing="3">'
		  .'<tr>'
		   .' <td>Nombre de publicador:</td>'
		   .' <td><input name="publicador" type="text" id="publicador" value="'.$Nombrepub.'"/></td>'
		 .' </tr>'
		 .' <tr>';
		  switch($Unguotro)
		  {
			  case "UN":
			   echo '<td colspan="2" align="center">Ungido<input type="radio" name="ungoutro" id="Ungg" value="UN" checked="checked"/>Otras ovejas<input type="radio" name="ungoutro" id="Otov" value="OO" /></td>';
			  break;
			  case "OO":
			  echo '<td colspan="2" align="center">Ungido<input type="radio" name="ungoutro" id="Ungg" value="UN"/>Otras ovejas<input type="radio" name="ungoutro" id="Otov" value="OO" checked="checked"/></td>';
			  break;
			}
		  echo ' </tr>'
		 .' <tr>'
		  .'  <td>Sexo:</td>';
		  switch($Sexo)
		  {
			  case "M":
			   echo ' <td>Masculino<input type="radio" name="sexo" id="Mas" value="M" checked="checked"/>Femenino<input type="radio" name="sexo" id="Fem" value="F" /></td>';
			  break;
			  case "F":
			  echo ' <td>Masculino<input type="radio" name="sexo" id="Mas" value="M"/>Femenino<input type="radio" name="sexo" id="Fem" value="F" checked="checked"/></td>';
			  break;
			}
		  echo '</tr>'
		 .' <tr>'
			.'<td>Anciano:</td>';
		    switch($Anciano)
		  {
			  case "SI":
			   echo ' <td>Si<input type="radio" name="sianc" id="Sian" value="SI" checked="checked"/>No<input type="radio" name="sianc" id="Noan" value="NO" /></td>';
			  break;
			  case "NO":
			   echo ' <td>Si<input type="radio" name="sianc" id="Sian" value="SI"/>No<input type="radio" name="sianc" id="Noan" value="NO" checked="checked"/></td>';
			  break;
			}
		 echo ' </tr>'
		 .' <tr>'
		 . '  <td>Siervo ministerial:</td>';
		    switch($Siervomin)
		  {
			  case "SI":
			   echo ' <td>Si<input type="radio" name="sisierv" id="Sisi" value="SI" checked="checked"/>No<input type="radio" name="sisierv" id="Nosi" value="NO" /></td>';
			  break;
			  case "NO":
			   echo ' <td>Si<input type="radio" name="sisierv" id="Sisi" value="SI"/>No<input type="radio" name="sisierv" id="Nosi" value="NO" checked="checked"/></td>';
			  break;
			}
		 echo ' </tr>'
		  .'<tr>'
			.'<td>Precursor regular:</td>';
		    switch($Precreg)
		  {
			  case "SI":
			   echo ' <td>Si<input type="radio" name="siprecr" id="Sipre" value="SI" checked="checked"/>No<input type="radio" name="siprecr" id="Nopre" value="NO" /></td>';
			  break; 
			  case "NO":
			   echo ' <td>Si<input type="radio" name="siprecr" id="Sipre" value="SI"/>No<input type="radio" name="siprecr" id="Nopre" value="NO" checked="checked"/></td>';
			  break;
			}
		 echo ' </tr>'
		 .' <tr>'
		  .'  <td>Fecha de nacimiento:</td>'
		   .' <td><input name="fechaanac" type="text" id="fechaanac" value="'.$fechanac.'"/></td>'
		  .'</tr>'
		 .' <tr>'
		   .' <td>Fecha de bautismo:</td>'
		   .' <td><input name="fechaabau" type="text" id="fechaabau" value="'.$fechabau.'"/></td>'
		 .' </tr>'
		 .' <tr>'
		   .' <td colspan="2" style="text-align:center"><input id="editardetails" type="button" value="Editar detalles de '.$Nombrepub.'" onclick="editandodetalles('.$publicador.')"/></td>'
		 .' </tr>'
		.'</table>';
	break;
	case "vista":
		switch($Sexo)
		{
			case "M":
				$Sexo="Masculino";
			break;
			case "F":
				$Sexo="Femenino";
			break;
		}
		echo '<table width="100%" border="0" cellspacing="3">'
		  .'<tr>'
		   .' <td>Nombre de publicador:</td>'
		   .' <td>'.$Nombrepub.'</td>'
		 .' </tr>'
		 .' <tr>'
		   .' <td>Ungido u otras ovejas:</td>'
			.'<td>'.$Unguotro.'</td>'
		 .' </tr>'
		 .' <tr>'
		  .'  <td>Sexo:</td>'
		  .'  <td>'.$Sexo.'</td>'
		  .'</tr>'
		 .' <tr>'
			.'<td>Anciano:</td>'
		   .' <td>'.$Anciano.'</td>'
		 .' </tr>'
		 .' <tr>'
		 . '  <td>Siervo ministerial:</td>'
		  .'  <td>'.$Siervomin.'</td>'
		 .' </tr>'
		  .'<tr>'
			.'<td>Precursor regular:</td>'
		   .' <td>'.$Precreg.'</td>'
		 .' </tr>'
		 .' <tr>'
		  .'  <td>Fecha de nacimiento:</td>'
		   .' <td>'.$fechanac.'</td>'
		  .'</tr>'
		 .' <tr>'
		   .' <td>Fecha de bautismo:</td>'
		   .' <td>'.$fechabau.'</td>'
		 .' </tr>'
		.'</table>';
		$ad="select * from records where Publicador=$publicador ORDER BY Anio ASC";	
		$da=mysqli_query($con,$ad) or die ("error buscando ".$ad);
		$cantan=mysqli_num_rows($da);
		$anioactual=0;
		echo '<div id="acordeonregistroo">'
		.'<h2>Ver historial de informes</h2>'
			.'<div>';
			if ($cantan!=0)
			{
			while ($mrec=mysqli_fetch_array($da))
			{
				$anio=$mrec['Anio'];
				if ($anioactual!=$anio)
				{
					$anioactual=$anio;
					echo $anioactual;
					echo '<table width="100%" border="0" cellspacing="3">'
				  .'<tr>'
					.'<td>      </td>'
				   .' <td>Libros</td>'
				   .' <td>Fol. y trat.</td>'
				   .' <td>Horas</td>'
				   .' <td>Revistas</td>'
				   .' <td>Revisitas</td>'
				   .' <td>Est. biblicos</td>'
				   .' <td>Notas</td>'
				 .' </tr>';
				 for ($x=1;$x<=12;$x++)
				 { 
					if ($anioactual != $aniopre || $x<=$mes)
					{
						$ae="select * from records where Publicador=$publicador AND Mes=$x AND Anio=$anioactual ORDER BY Anio ASC";	
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
							$Librosrec=$mregis['Libros'];
							$Folletosrec=$mregis['Folletos'];
							$Horasrec=$mregis['Horas'];
							$Revistasrec=$mregis['Revistas'];
							$Revisitasrec=$mregis['Revisitas']; 
							$Estbibrec=$mregis['Estbib'];
							$Notasrec=$mregis['Notas'];
							   echo ' <td align="center">'.$Librosrec.'</td>'
							   .' <td align="center">'.$Folletosrec.'</td>'
							   .' <td align="center">'.$Horasrec.'</td>'
							   .' <td align="center">'.$Revistasrec.'</td>'
							   .' <td align="center">'.$Revisitasrec.'</td>'
							   .' <td align="center">'.$Estbibrec.'</td>'
							   .' <td align="center">'.$Notasrec.'</td>';
						}
						else
						{
							echo ' <td align="center">-</td>'
							   .' <td align="center">-</td>'
							   .' <td align="center">-</td>'
							   .' <td align="center">-</td>'
							   .' <td align="center">-</td>'
							   .' <td align="center">-</td>'
							   .' <td align="center">-</td>';
						}
						echo '</tr>';
					}
					
				 }
				echo '</table>';	
				}
			}
			echo '</div>'
	.'</div>';
			
			}
			else
			{
				echo "Este publicador no tiene ningun registro en su historial";
			}
	break;
}
	

?>


	