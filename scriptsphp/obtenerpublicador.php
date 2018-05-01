<?
session_start();
use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;
date_default_timezone_set('America/Argentina/Buenos_Aires');
$fechahoy=date("Y-m-d");
$mes=date("m");
$aniopre=date("Y");
if ($mes==1)
{
	$mes=12;
	$aniopre-=1;
}
else
{
	$mes-=1;
}
$salpdf="";
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
$ac="select * from congregaciones where idcong=$Congre";	
$bc=mysqli_query($con,$ac) or die ("error buscando ".$ac);
$mref=mysqli_fetch_array($bc);
$NombCong=$mref['NombCong'];
$aa="select Date_format(Fechanac,'%W') AS ndnac,Date_format(Fechanac,'%d') AS dnac,Date_format(Fechanac,'%M') AS mnac,Date_format(Fechanac,'%Y') AS anac,Date_format(Fechabau,'%W') AS ndbau,Date_format(Fechabau,'%d') AS dbau,Date_format(Fechabau,'%M') AS mbau,Date_format(Fechabau,'%Y') AS abau,Date_format(Fechanom,'%W') AS ndnom,Date_format(Fechanom,'%d') AS dnom,Date_format(Fechanom,'%M') AS mnom,Date_format(Fechanom,'%Y') AS anom,Domicilio,Telefono,Celular,Unguotro,Sexo,Anciano,Siervomin,Precreg,Idprec,Nombre,Familia,Bautizado,Grupo,Fechabau,Fechanac,Fechanom,DNI,Passpub from publicadores where Idpublicadores=$publicador";	
$bb=mysqli_query($con,$aa) or die ("error buscando ".$aa);
$mref=mysqli_fetch_array($bb);
$Nombrepub=$mref['Nombre'];
$Unguotro=$mref['Unguotro'];
$Sexo=$mref['Sexo'];
$Anciano=$mref['Anciano'];
$Siervomin=$mref['Siervomin'];
$Precreg=$mref['Precreg'];
$Idprec=$mref['Idprec'];
$Familia=$mref['Familia'];
$aa="select * from familias where idfamilia=$Familia";	
$bb=mysqli_query($con,$aa) or die ("error buscando ".$aa);
$mrefami=mysqli_fetch_array($bb);
$Apellidofam=$mrefami['Nombrefam'];
$Domicilio=$mref['Domicilio'];
$Telefono=$mref['Telefono'];
$Celular=$mref['Celular'];
$Bautizado=$mref['Bautizado'];
$Grupo=$mref['Grupo'];
$ndnac=$mref['ndnac'];
$dnac=$mref['dnac'];
$mnac=$mref['mnac'];
$anac=$mref['anac'];
$ndbau=$mref['ndbau'];
$dbau=$mref['dbau'];
$mbau=$mref['mbau'];
$abau=$mref['abau'];
$ndnom=$mref['ndnom'];
$dnom=$mref['dnom'];
$mnom=$mref['mnom'];
$anom=$mref['anom'];
$Fechabau=$mref['Fechabau'];
$Fechanac=$mref['Fechanac'];
$Fechaprec=$mref['Fechanom'];
$DNI=$mref['DNI'];
$PassPub=$mref['Passpub'];
if ($PassPub=="")
{
	$PassPub=$DNI;
}
//Calcula los años pasados desde la fecha de naciemiento
function calculardiferenciafecha($fInicio,$fFinal)
{
	$AInicio=0;
	$AInicio = substr($fInicio,0,4);
	$minicio=0;
	$minicio = substr($fInicio,5,2);
	$diainicio=0;
	$diainicio = substr($fInicio,8,2);
	$AFinal = 0;
	$AFinal = substr($fFinal,0,4);
	$mfinal = 0;
	$mfinal = substr($fFinal,5,2);
	$dfinal = 0;
	$dfinal = substr($fFinal,8,2);
	for ($i = $AInicio; $i <= $AFinal; $i++) {
	$bis = 0;	
		if (($i % 4) == 0)
		{
			if (($i % 100)==0 && ($i % 400)==0)
			{
				$bis = 86400;
			}
		}
	$sumadiasBis += $bis;
	}
	// Calculamos los segundos entre las dos fechas
	$fechaInicio = strtotime($fInicio);
	$fechaFinal = strtotime($fFinal);
	$segundos = ($fechaFinal - $fechaInicio);
	$anyos = floor(($segundos)/31536000);
	$segundosRestante = ($segundos)%(31536000);
	$meses = round($segundosRestante/2592000);
	$segundosRestante = ($segundosRestante%2592000);
	$dias = round($segundosRestante/86400);
	if ($dias==0)
	{
		$cadenadia="";
	}
	else
	{
		if ($dias==1)
		{
			$cadenadia="1 dia";
		}
		else
		{
			$cadenadia=$dias. " d&iacute;as";
		}
	}
	if ($meses==0)
	{
		$cadenames="";
	}
	else
	{
		if ($meses==1)
		{
			$cadenames="1 mes ";
		}
		else
		{
			$cadenames=$meses. " meses ";
		}
	}
	if ($anyos==0)
	{
		$cadenaanio="Aun no ha cumplido el año";
	}
	else
	{
		if ($anyos==1)
		{
			$cadenaanio="1 a&ntilde;o";
		}
		else
		{
			$cadenaanio=$anyos. " a&ntilde;os";
		}
	}
	$cadenafinal=$cadenaanio;
	return $cadenafinal;
}

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
		/*------------------------------------------------------------*/
		if ($mnom == "January"){
		  $mnom = "01";
		  }
		  if ($mnom == "February"){
		  $mnom = "02";
		  }
		  if ($mnom == "March"){
		  $mnom = "03";
		  }
		  if ($mnom == "April"){
		  $mnom = "04";
		  }
		  if ($mnom == "May"){
		  $mnom = "05";
		  }
		  if ($mnom == "June"){
		  $mnom = "06";
		  }
		  if ($mnom == "July"){
		  $mnom = "07";
		  }
		  if ($mnom == "August"){
		  $mnom = "08";
		  }
		  if ($mnom == "September"){
		  $mnom = "09";
		  }
		  if ($mnom == "October"){
		  $mnom = "10";
		  }
		  if ($mnom == "November"){
		  $mnom = "11";
		  }
		  if ($mnom == "December"){
		  $mnom = "12";
		  }
		$fechanom =$dnom."/".$mnom."/".$anom;
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
	  
	  if ($ndnom == "Monday"){
	  $ndnom = "Lunes";
	  }
	  if ($ndnom == "Tuesday"){
	  $ndnom = "Martes";
	  }
	  if ($ndnom == "Wednesday"){
	  $ndnom = "Miércoles";
	  }
	  if ($ndnom == "Thursday"){
	  $ndnom = "Jueves";
	  }
	  if ($ndnom == "Friday"){
	  $ndnom = "Viernes";
	  }
	  if ($ndnom == "Saturday"){
	  $ndnom = "Sábado";
	  }
	  if ($ndnom == "Sunday"){
	  $ndnom = "Domingo";
	  }
	  
	  if ($mnom == "January"){
	  $mnom = "Enero";
	  }
	  if ($mnom == "February"){
	  $mnom = "Febrero";
	  }
	  if ($mnom == "March"){
	  $mnom = "Marzo";
	  }
	  if ($mnom == "April"){
	  $mnom = "Abril";
	  }
	  if ($mnom == "May"){
	  $mnom = "Mayo";
	  }
	  if ($mnom == "June"){
	  $mnom = "Junio";
	  }
	  if ($mnom == "July"){
	  $mnom = "Julio";
	  }
	  if ($mnom == "August"){
	  $mnom = "Agosto";
	  }
	  if ($mnom == "September"){
	  $mnom = "Septiembre";
	  }
	  if ($mnom == "October"){
	  $mnom = "Octubre";
	  }
	  if ($mnom == "November"){
	  $mnom = "Noviembre";
	  }
	  if ($mnom == "December"){
	  $mnom = "Diciembre";
	  }
	  $fechanom =$ndnom." ".$dnom."/".$mnom."/".$anom;
	break;
}
	
//--------------------------------------------------------------

switch ($modo)
{
	case "edicion":
		echo '<table width="100%" border="0" cellspacing="3">'
		  .'<tr>'
		   .' <td>Nombre de publicador:</td>'
		   .' <td><input name="publicador" type="text" id="publicador" value="'.$Nombrepub.'"/><p><span id="errorpublicador" style="color:#F00"></span></p></td>'
		 .' </tr>'
		 .'<tr>'
		   .' <td>DNI:</td>'
		   .' <td><input name="dni" type="text" id="dni" value="'.$DNI.'"/><p><span id="errordni" style="color:#F00"></span></p></td>'
		 .' </tr>'
		 .'<tr>'
		   .' <td>Domicilio:</td>'
		   .' <td><input name="domicilio" type="text" id="domicilio" value="'.$Domicilio.'"/><p><span id="errordomicilio" style="color:#F00"></span></p></td>'
		 .' </tr>'
		 .'<tr>'
		   .' <td>Telefono fijo: </td>'
		   .' <td><input name="telefono" type="text" id="telefono" value="'.$Telefono.'"/><p><span id="errortelefono" style="color:#F00"></span></p></td>'
		 .' </tr>'
		 .'<tr>'
		   .' <td>Telefono celular: </td>'
		   .' <td><input name="celular" type="text" id="celular" value="'.$Celular.'"/><p><span id="errorcelular" style="color:#F00"></span></p></td>'
		 .' </tr>';
		 $ab=" select * from grupos";	
		$ba=mysqli_query($con,$ab) or die ("error buscando ".$ab);
		 echo'<tr>'
		   .' <td>Grupo: </td>'
		   .' <td><select name="grupe" id="grupe">';
		   while ($mgrup=mysqli_fetch_array($ba))
		   {
			   $idg=$mgrup['idgrupo'];
			   $seleccion="";
			   if ($Grupo==$idg){$seleccion =' selected="selected"'; }
			   echo '<option'.$seleccion.'> '.$idg.'</option>';
			} 
		   echo '</select></td>'
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
			   echo ' <td>Si<input type="radio" name="siprecr" id="Sipre" value="SI" checked="checked" onchange="mostrarocultarnom()"/>No<input type="radio" name="siprecr" id="Nopre" value="NO" onchange="mostrarocultarnom()"/></td>';
			  break; 
			  case "NO":
			   echo ' <td>Si<input type="radio" name="siprecr" id="Sipre" value="SI" onchange="mostrarocultarnom()"/>No<input type="radio" name="siprecr" id="Nopre" value="NO" checked="checked" onchange="mostrarocultarnom()"/></td>';
			  break;
			}
			if ($Precreg=="SI")
				{
					 echo ' <tr>'
						.' <td align="center">';
						echo '<div id="nombradate">'
						.'<table width="100%" border="0" cellspacing="4" cellpadding="1">'
							.' <tr>'
							.' <td>ID Precursor/a:</td>'
							.' <td><input name="idpreccu" type="text" id="idpreccu" value="'.$Idprec.'"/><p><span id="erroridprecu" style="color:#F00"></span></p></td>'
						.' </tr>'
							.' <tr>'
							.' <td>Fecha de nombramiento:</td>'
							.' <td><input name="fechanomb" type="text" id="fechanomb" value="'.$fechanom.'"/><p><span id="errorfechanom" style="color:#F00"></span></p></td>'
						.' </tr>'
						.'</table>'
						.'</div>';
						echo '</td>'
					.' </tr>';
				}
				else
				{
					 echo ' <tr>'
						.' <td align="center">';
					 echo '<div id="nombradate" style="display:none">'
						.'<table width="100%" border="0" cellspacing="4" cellpadding="1">'
							.' <tr>'
							.' <td>ID Precursor/a:</td>'
							.' <td><input name="idpreccu" type="text" id="idpreccu"/><p><span id="erroridprecu" style="color:#F00"></span></p></td>'
						.' </tr>'
							.' <tr>'
							.' <td>Fecha de nombramiento:</td>'
							.' <td><input name="fechanomb" type="text" id="fechanomb"/><p><span id="errorfechanom" style="color:#F00"></span></p></td>'
						.' </tr>'
						.'</table>'
					.'</div>';
						echo '</td>'
					.' </tr>';
				}
		 echo ' </tr>'
		 .' <tr>'
		  .'  <td>Fecha de nacimiento:</td>'
		   .' <td><input name="fechaanac" type="text" id="fechaanac" value="'.$fechanac.'"/></td>'
		  .'</tr>'
		  .'<tr>'
		.'<td>Bautizado:</td>';
		    switch($Bautizado)
		  {
			  case "SI":
			   echo ' <td>Si<input type="radio" name="sibaut" id="sibaut" value="SI" checked="checked" onchange="mostrarocultarbaut()"/>No<input type="radio" name="sibaut" id="nobaut" value="NO" onchange="mostrarocultarbaut()"/></td>';
			  break; 
			  case "NO":
			  echo ' <td>Si<input type="radio" name="sibaut" id="sibaut" value="SI" onchange="mostrarocultarbaut()"/>No<input type="radio" name="sibaut" id="nobaut" value="NO" checked="checked" onchange="mostrarocultarbaut()"/></td>';
			  break;
			}
		 echo ' </tr>';
		 if ($Bautizado=="SI")
		{
			 echo ' <tr id="bautismodate">'
			  	.' <td>Fecha de bautismo:</td>'
		   		.' <td><input name="fechaabau" type="text" id="fechaabau" value="'.$fechabau.'"/><p><span id="errorfechabau" style="color:#F00"></span></p></td>'
		 	.' </tr>';
		}
		else
		{
			 echo ' <tr style="display:none" id="bautismodate">'
			  	.' <td>Fecha de bautismo:</td>'
		   		.' <td><input name="fechaabau" type="text" id="fechaabau"/><p><span id="errorfechabau" style="color:#F00"></span></p></td>'
		 	.' </tr>';
		}
		   
		 echo ' <tr>'
		   .' <td colspan="2" style="text-align:center"><input id="editardetails" type="button" value="Editar detalles de '.$Nombrepub.'" onclick="editandodetalles('.$publicador.')"/></td>'
		 .' </tr>'
		.'</table>';
	break;
	case "vista":
		switch($Sexo)
		{
			case "M":
				$Sexo="Masculino";
				$hmm="Hombre";
			break;
			case "F":
				$Sexo="Femenino";
				$hmm="Mujer";
			break;
		}switch($Unguotro)
		{
			case "OO":
				$Unguotro="Otras ovejas";
			break;
			case "UN":
				$Unguotro="Grupo ungido";
			break;
		}
		$cadenaanciano="";
		$cadenasiervomin="";
		$cadenaprecreg="";
		if ($Anciano=="SI")
		{
			$cadenaanciano='checked="checked"';
		}
		if ($Siervomin=="SI")
		{
			$cadenasiervomin='checked="checked"';
		}
		if ($Precreg=="SI")
		{
			$cadenaprecreg='checked="checked"';
		}
		if ($DNI==0)
		{
			$DNI="No definido";
			$PassPub="No definida";
		}
		echo '<table width="100%" border="0" cellspacing="3">'
		  .'<tr>'
		   .' <td>Nombre de publicador:</td>'
		   .' <td>'.$Nombrepub.'</td>'
		 .' </tr>'
		 .'<tr>'
		   .' <td>DNI:</td>'
		   .' <td>'.$DNI.'</td>'
		 .' </tr>'
		 .'<tr>'
		   .' <td>Contraseña:</td>'
		   .' <td>'.$PassPub.'</td>'
		 .' </tr>'
		 .'<tr>'
		   .' <td>Domicilio:</td>'
		   .' <td>'.$Domicilio.'</td>'
		 .' </tr>'
		 .'<tr>'
		   .' <td>Telefono fijo:</td>'
		   .' <td>'.$Telefono.'</td>'
		 .' </tr>'
		 .'<tr>'
		   .' <td>Telefono celular:</td>'
		   .' <td>'.$Celular.'</td>'
		 .' </tr>'
		 .'<tr>'
		   .' <td>Pertenece al grupo:</td>'
		   .' <td>'.$Grupo.'</td>'
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
		   . ' </tr>';
		   if ($Precreg=="SI")
		   {
			    echo ' <tr>'
				   .' <td align="center">'
				    .'<table width="100%" border="0" cellspacing="4" cellpadding="1">'
						.' <tr>'
						   .' <td>ID Precursora: </td>'
						   .' <td>'.$Idprec.'</td>'
						 .' </tr>'
						.' <tr>'
						   .' <td>Fecha de nombramiento:</td>';
							  $aniosprec=calculardiferenciafecha($Fechaprec,$fechahoy);
							   echo ' <td>'.$fechanom.'('.$aniosprec.')'.'</td>'
						.' </tr>'
					.'</table>'
				 .' </td></tr>';
			}
		 echo ' <tr>'
		  .'  <td>Fecha de nacimiento:</td>';
		  $aniosnac=calculardiferenciafecha($Fechanac,$fechahoy);
		   echo ' <td>'.$fechanac.' ('.$aniosnac.')'.'</td>'
		  .'</tr>';
		  switch($Bautizado)
		  {
			  case "SI":
			   echo ' <tr>'
				   .' <td>Bautizado: </td>'
				   .' <td>SI</td>'
				 .' </tr>'
			   		.' <tr>'
				   .' <td>Fecha de bautismo:</td>';
		  $aniosbau=calculardiferenciafecha($Fechabau,$fechahoy);
		   echo ' <td>'.$fechabau.' ('.$aniosbau.')'.'</td>'
				 .' </tr>';
			  break; 
			  case "NO":
			   echo ' <tr>'
				   .' <td>Bautizado: </td>'
				   .' <td>NO</td>'
				 .' </tr>';
			  break;
		}
		echo '</table>';
		$salnormal="";
		$saldatos='<table width="100%" border="1">
		  <tbody>
			<tr>
			  <td colspan="3" align="center">REGISTRO DE PUBLICADOR DE LA CONGREGACION '.strtoupper($NombCong).'</td>
			</tr>
			<tr>
			  <td colspan="2">Nombre:'.$Nombrepub.' '.$Apellidofam.'</td>
			  <td width="33%">'.$hmm.'</td>
			</tr>
			<tr>
			  <td width="33%">Tel. Fijo:'.$Telefono.'</td>
			  <td width="33%">Tel. Movil:'.$Celular.'</td>
			  <td width="33%">Fecha nacimiento:'.$fechanac.'</td>
			</tr>
			<tr>
			  <td width="33%">Fecha de bautismo:'.$fechabau.'</td>
			  <td width="33%">Pertenece a :'.$Unguotro.'</td>
			  <td width="33%"><label><input type="checkbox" '.$cadenaanciano.'>
      Anciano</label> 
      <label><input type="checkbox" '.$cadenasiervomin.'>
      Siervo ministerial</label> 
      <label><input type="checkbox" '.$cadenaprecreg.'>
      Precursor/a regular</label></td>
			</tr>
		  </tbody>
		</table>';
		$ad="select * from records2 where Publicador=$publicador ORDER BY Anio ASC";	
		$da=mysqli_query($con,$ad) or die ("error buscando ".$ad);
		$cantan=mysqli_num_rows($da);
		$anioactual=0;
		$contans=1;
		$sal1.= '<div id="acordeonregistroo">'
		.'<h2>Ver historial de informes</h2>'
			.'<div>';
			if ($cantan!=0)
			{
			while ($mrec=mysqli_fetch_array($da))
			{
				$sal="";
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
							$pr="select * from records2 where Publicador=$publicador AND Mes=$x AND Anio=$anioactual ORDER BY Anio ASC";	
							$qpr=mysqli_query($con,$pr) or die ("error buscando ".$pr);
							$cpr=mysqli_num_rows($qpr);
							if ($cpr!=0)
							{
								$anioac++;
							}
						 }
						 if ($anioac!=0)
						 {
							 $TotalPublicaciones=0;
							 $Totalvideos=0;
							 $Totalhoras=0;
							 $Totalrevisitas=0;
							 $Totalestudios=0;
							 $sal.= '<p>Año de servicio '.($anioactual-1).'/'.$anioactual.'</p>';
							 $sal.="Descargar como pdf";
							$sal.= '<table width="100%" border="0" cellspacing="3">'
						  .'<tr>'
							.'<td>      </td>'
						   .' <td>Publicaciones</td>'
						   .' <td>Presentaciones de videos</td>'
						   .' <td>Horas</td>'
						   .' <td>Revisitas</td>'
						   .' <td>Est. biblicos</td>'
						   .' <td>Notas</td>'
						 .' </tr>';
						 for ($x=9;$x<=12;$x++)
							 { 
								if ($anioactual != $aniopre || $x<=$mes)
								{
										$sal.= '<tr>';
												switch($x)
												{
													case 1:
													$sal.= '<td>Enero</td>';
													break;
													case 2:
													$sal.= '<td>Febrero</td>';
													break;
													case 3:
													$sal.= '<td>Marzo</td>';
													break;
													case 4:
													$sal.= '<td>Abril</td>';
													break;
													case 5:
													$sal.= '<td>Mayo</td>';
													break;
													case 6:
													$sal.= '<td>Junio</td>';
													break;
													case 7:
													$sal.= '<td>Julio</td>';
													break;
													case 8:
													$sal.= '<td>Agosto</td>';
													break;
													case 9:
													$sal.= '<td>Septiembre</td>';
													break;
													case 10:
													$sal.= '<td>Octubre</td>';
													break;
													case 11:
													$sal.= '<td>Noviembre</td>';
													break;
													case 12:
													$sal.= '<td>Diciembre</td>';
													break;
												}
										$sal.= ' <td align="center">-</td>'
											   .' <td align="center">-</td>'
											   .' <td align="center">-</td>'
											   .' <td align="center">-</td>'
											   .' <td align="center">-</td>'
											   .' <td align="center">-</td>';
										$sal.= '</tr>';
								} 
							} 
							$sal.= '<tr><td align="center">'.$anioactual.'</td></tr>';
							for ($x=1;$x<=8;$x++)
							 { 
								if ($anioactual != $aniopre || $x<=$mes)
								{
										$ae="select * from records2 where Publicador=$publicador AND Mes=$x AND Anio=$anioactual ORDER BY Anio ASC";	
										$ea=mysqli_query($con,$ae) or die ("error buscando ".$ae);
										$cantentm=mysqli_num_rows($ea);
										$mregis=mysqli_fetch_array($ea);
										$sal.= '<tr>';
												switch($x)
												{
													case 1:
													$sal.= '<td>Enero</td>';
													break;
													case 2:
													$sal.= '<td>Febrero</td>';
													break;
													case 3:
													$sal.= '<td>Marzo</td>';
													break;
													case 4:
													$sal.= '<td>Abril</td>';
													break;
													case 5:
													$sal.= '<td>Mayo</td>';
													break;
													case 6:
													$sal.= '<td>Junio</td>';
													break;
													case 7:
													$sal.= '<td>Julio</td>';
													break;
													case 8:
													$sal.= '<td>Agosto</td>';
													break;
													case 9:
													$sal.= '<td>Septiembre</td>';
													break;
													case 10:
													$sal.= '<td>Octubre</td>';
													break;
													case 11:
													$sal.= '<td>Noviembre</td>';
													break;
													case 12:
													$sal.= '<td>Diciembre</td>';
													break;
												}
										if ($cantentm!=0)
										{
											$Publicacionesrec=$mregis['Publicaciones'];
											$Videosrec=$mregis['Videos'];
											$Horasrec=$mregis['Horas'];
											$Revisitasrec=$mregis['Revisitas']; 
											$Estbibrec=$mregis['Estbib'];
											$Notasrec=$mregis['Notas'];
											$Totalpublicaciones+=$Publicacionesrec;
											 $Totalvideos+=$Videosrec;
											 $Totalhoras+=$Horasrec;
											 $Totalrevisitas+=$Revisitasrec;
											 $Totalestudios+=$Estbibrec;
											   $sal.= ' <td align="center">'.$Publicacionesrec.'</td>'
											   .' <td align="center">'.$Videosrec.'</td>'
											   .' <td align="center">'.$Horasrec.'</td>'
											   .' <td align="center">'.$Revisitasrec.'</td>'
											   .' <td align="center">'.$Estbibrec.'</td>'
											   .' <td align="center">'.$Notasrec.'</td>';
										}
										else
										{
											$sal.= ' <td align="center">-</td>'
											   .' <td align="center">-</td>'
											   .' <td align="center">-</td>'
											   .' <td align="center">-</td>'
											   .' <td align="center">-</td>'
											   .' <td align="center">-</td>';
										}
										$sal.= '</tr>';
								} 
							} 
							$Promediopublicaciones=round($Totalpublicaciones/$anioac);
							$Promediovideos=round($Totalvideos/$anioac);
							$Promediohoras=round($Totalhoras/$anioac);
							$Promediorevisitas=round($Totalrevisitas/$anioac);
							$Promedioestudios=round($Totalestudios/$anioac);
								$sal.= '<tr style="font-weight:bolder; font-size:18px">';
									$sal.= ' <td align="center">Total</td>'
									.' <td align="center">'.$Totalpublicaciones.'</td>'
									.' <td align="center">'.$Totalvideos.'</td>'
									.' <td align="center">'.$Totalhoras.'</td>'
									.' <td align="center">'.$Totalrevisitas.'</td>'
									.' <td align="center">'.$Totalestudios.'</td>'
									.' <td align="center">-</td>';
								$sal.= '</tr>';
								$sal.= '<tr style="font-weight:bolder; font-size:18px">';
									$sal.= ' <td align="center">Promedio</td>'
									.' <td align="center">'.$Promediopublicaciones.'</td>'
									.' <td align="center">'.$Promediovideos.'</td>'
									.' <td align="center">'.$Promediohoras.'</td>'
									.' <td align="center">'.$Promediorevisitas.'</td>'
									.' <td align="center">'.$Promedioestudios.'</td>'
									.' <td align="center">-</td>';
								$sal.= '</tr>';
							$sal.= '</table>';
							$sal.= '<br/>';
							$salpdf.='<table width="100%" border="1"><tr><td>'.$saldatos.$sal.'</td></tr></table>';
					$enlace=htmlentities('<table width="100%" border="1"><tr><td>'.$saldatos.$sal.'</td></tr></table>');
					$salnormal.='<p><a href="#" onclick="establecerpdf('.$contans.')">Descargar año de servicio '.($anioactual-1).'/'.$anioactual.' como pdf <img src="images/pdf.png" width="20" heigth="20"/> </a></p><input type="hidden" id="textopdf'.$contans.'" value="'.$enlace.'">'.$sal;
							$contans++;
						}
					}
					$sal="";
					$cantans=0;
					for ($x=9;$x<=12;$x++)
					 { 
						$pr="select * from records2 where Publicador=$publicador AND Mes=$x AND Anio=$anioactual ORDER BY Anio ASC";	
						$qpr=mysqli_query($con,$pr) or die ("error buscando ".$pr);
						$cpr=mysqli_num_rows($qpr);
						if ($cpr!=0)
						{
							$cantans++;
						}
					 }
					 for ($x=1;$x<=8;$x++)
					 { 
						$pr="select * from records2 where Publicador=$publicador AND Mes=$x AND Anio=($anioactual+1) ORDER BY Anio ASC";	
						$qpr=mysqli_query($con,$pr) or die ("error buscando ".$pr);
						$cpr=mysqli_num_rows($qpr);
						if ($cpr!=0)
						{
							$cantans++;
						}
					 }
					 if ($cantans!=0)
					 {
						$TotalPublicaciones=0;
						$Totalvideos=0;
						$Totalhoras=0;
						$Totalrevisitas=0;
						$Totalestudios=0;
						$sal.= '<p>Año de servicio '.$anioactual.'/'.($anioactual+1).'</p>';
						//$sal.='<p>Descargar como pdf <img src="images/pdf.png" width="20" heigth="20"/> </p>';
						$sal.= '<table width="100%" border="0" cellspacing="3">'
					  .'<tr>'
						.'<td>      </td>'
						   .' <td>Publicaciones</td>'
						   .' <td>Presentaciones de videos</td>'
						   .' <td>Horas</td>'
						   .' <td>Revisitas</td>'
						   .' <td>Est. biblicos</td>'
						   .' <td>Notas</td>'
					 .' </tr>';
					 for ($x=9;$x<=12;$x++)
					 { 
						if ($anioactual != $aniopre || $x<=$mes)
						{
							$ae="select * from records2 where Publicador=$publicador AND Mes=$x AND Anio=$anioactual ORDER BY Anio ASC";	
							$ea=mysqli_query($con,$ae) or die ("error buscando ".$ae);
							$cantentm=mysqli_num_rows($ea);
							$mregis=mysqli_fetch_array($ea);
							$sal.= '<tr>';
									switch($x)
									{
										case 1:
										$sal.= '<td>Enero</td>';
										break;
										case 2:
										$sal.= '<td>Febrero</td>';
										break;
										case 3:
										$sal.= '<td>Marzo</td>';
										break;
										case 4:
										$sal.= '<td>Abril</td>';
										break;
										case 5:
										$sal.= '<td>Mayo</td>';
										break;
										case 6:
										$sal.= '<td>Junio</td>';
										break;
										case 7:
										$sal.= '<td>Julio</td>';
										break;
										case 8:
										$sal.= '<td>Agosto</td>';
										break;
										case 9:
										$sal.= '<td>Septiembre</td>';
										break;
										case 10:
										$sal.= '<td>Octubre</td>';
										break;
										case 11:
										$sal.= '<td>Noviembre</td>';
										break;
										case 12:
										$sal.= '<td>Diciembre</td>';
										break;
									}
							if ($cantentm!=0)
							{
								$Publicacionesrec=$mregis['Publicaciones'];
								$Videosrec=$mregis['Videos'];
								$Horasrec=$mregis['Horas'];
								$Revisitasrec=$mregis['Revisitas']; 
								$Estbibrec=$mregis['Estbib'];
								$Notasrec=$mregis['Notas'];
								$Totalpublicaciones+=$Publicacionesrec;
								 $Totalvideos+=$Videosrec;
								 $Totalhoras+=$Horasrec;
								 $Totalrevisitas+=$Revisitasrec;
								 $Totalestudios+=$Estbibrec;
								 $sal.= ' <td align="center">'.$Publicacionesrec.'</td>'
							   .' <td align="center">'.$Videosrec.'</td>'
							   .' <td align="center">'.$Horasrec.'</td>'
							   .' <td align="center">'.$Revisitasrec.'</td>'
							  	.' <td align="center">'.$Estbibrec.'</td>'
							.' <td align="center">'.$Notasrec.'</td>';
							}
							else
							{
								$sal.= ' <td align="center">-</td>'
								   .' <td align="center">-</td>'
								   .' <td align="center">-</td>'
								   .' <td align="center">-</td>'
								   .' <td align="center">-</td>'
								   .' <td align="center">-</td>';
							}
							$sal.= '</tr>';
						}
					 }
					 $sal.= '<tr><td align="center">'.($anioactual+1).'</td></tr>';
					 for ($x=1;$x<=8;$x++)
					 { 
						if (($anioactual+1) != $aniopre || $x<=$mes)
						{
							if (($anioactual+1)<=$aniopre)
							{
								$ae="select * from records2 where Publicador=$publicador AND Mes=$x AND Anio=($anioactual+1) ORDER BY Anio ASC";	
								$ea=mysqli_query($con,$ae) or die ("error buscando ".$ae);
								$cantentm=mysqli_num_rows($ea);
								$mregis=mysqli_fetch_array($ea);
								$sal.= '<tr>';
										switch($x)
										{
											case 1:
											$sal.= '<td>Enero</td>';
											break;
											case 2:
											$sal.= '<td>Febrero</td>';
											break;
											case 3:
											$sal.= '<td>Marzo</td>';
											break;
											case 4:
											$sal.= '<td>Abril</td>';
											break;
											case 5:
											$sal.= '<td>Mayo</td>';
											break;
											case 6:
											$sal.= '<td>Junio</td>';
											break;
											case 7:
											$sal.= '<td>Julio</td>';
											break;
											case 8:
											$sal.= '<td>Agosto</td>';
											break;
											case 9:
											$sal.= '<td>Septiembre</td>';
											break;
											case 10:
											$sal.= '<td>Octubre</td>';
											break;
											case 11:
											$sal.= '<td>Noviembre</td>';
											break;
											case 12:
											$sal.= '<td>Diciembre</td>';
											break;
										}
								if ($cantentm!=0)
								{
									$Publicacionesrec=$mregis['Publicaciones'];
									$Videosrec=$mregis['Videos'];
									$Horasrec=$mregis['Horas'];
									$Revisitasrec=$mregis['Revisitas']; 
									$Estbibrec=$mregis['Estbib'];
									$Notasrec=$mregis['Notas'];
									$Totalpublicaciones+=$Publicacionesrec;
									 $Totalvideos+=$Videosrec;
									 $Totalhoras+=$Horasrec;
									 $Totalrevisitas+=$Revisitasrec;
									 $Totalestudios+=$Estbibrec;
									 $sal.= ' <td align="center">'.$Publicacionesrec.'</td>'
								   .' <td align="center">'.$Videosrec.'</td>'
								   .' <td align="center">'.$Horasrec.'</td>'
								   .' <td align="center">'.$Revisitasrec.'</td>'
									.' <td align="center">'.$Estbibrec.'</td>'
								.' <td align="center">'.$Notasrec.'</td>';
								}
								else
								{
									$sal.= ' <td align="center">-</td>'
									   .' <td align="center">-</td>'
									   .' <td align="center">-</td>'
									   .' <td align="center">-</td>'
									   .' <td align="center">-</td>'
									   .' <td align="center">-</td>';
								}
								$sal.= '</tr>';
							}
						} 
					}
						$Promediopublicaciones=round($Totalpublicaciones/$cantans);
						$Promediovideos=round($Totalvideos/$cantans);
						$Promediohoras=round($Totalhoras/$cantans);
						$Promediorevisitas=round($Totalrevisitas/$cantans);
						$Promedioestudios=round($Totalestudios/$cantans);
					$sal.= '<tr style="font-weight:bolder; font-size:18px">';
									$sal.= ' <td align="center">Total</td>'
									.' <td align="center">'.$Totalpublicaciones.'</td>'
									.' <td align="center">'.$Totalvideos.'</td>'
									.' <td align="center">'.$Totalhoras.'</td>'
									.' <td align="center">'.$Totalrevisitas.'</td>'
									.' <td align="center">'.$Totalestudios.'</td>'
									.' <td align="center">-</td>';
								$sal.= '</tr>';
					$sal.= '<tr style="font-weight:bolder; font-size:18px">';
									$sal.= ' <td align="center">Promedio</td>'
									.' <td align="center">'.$Promediopublicaciones.'</td>'
									.' <td align="center">'.$Promediovideos.'</td>'
									.' <td align="center">'.$Promediohoras.'</td>'
									.' <td align="center">'.$Promediorevisitas.'</td>'
									.' <td align="center">'.$Promedioestudios.'</td>'
									.' <td align="center">-</td>';
								$sal.= '</tr>';
					$sal.= '</table>';
					$sal.= '<br/>';
					$salpdf.='<table width="100%" border="1"><tr><td>'.$saldatos.$sal.'</td></tr></table>';
					$enlace=htmlentities('<table width="100%" border="1"><tr><td>'.$saldatos.$sal.'</td></tr></table>');
					$salnormal.='<p><a href="#" onclick="establecerpdf('.$contans.')">Descargar año de servicio '.$anioactual.'/'.($anioactual+1).' como pdf <img src="images/pdf.png" width="20" heigth="20"/> </a></p><input type="hidden" id="textopdf'.$contans.'" value="'.$enlace.'">'.$sal;
							$contans++;
				 }	
				}
			}
			$sal2.= '</div>'
	.'</div>';
			$enlace=htmlentities($salpdf);
			echo $sal1.'<p><a href="#" onclick="establecerpdf(0)">Descargar todo como pdf <img src="images/pdf.png" width="20" heigth="20"/> </a></p><input type="hidden" id="textopdf0" value="'.$enlace.'">'.$salnormal.$sal2;
			
			}
			else
			{
				echo "Este publicador no tiene ningun registro en su historial";
			}
	/*
    require_once dirname(__FILE__).'/html2pdf/vendor/autoload.php';
    $html2pdf = new Html2Pdf('P','A4','fr');
    $html2pdf->WriteHTML($sal);
    $html2pdf->Output('exemple.pdf');
	*/
	
		
	break;
}
	

?>


	