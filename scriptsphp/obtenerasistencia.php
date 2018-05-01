
<?
session_start();
$modo=$_GET['modo'];
$Reunion=$_GET['Reunion'];
$Mes=$_GET['Mes'];
$Anio=$_GET['Anio'];
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
switch ($modo)
{
	case "edicion":
	$aa="select * from asistencias where Reunion=$Reunion AND Mes=$Mes AND Anio=$Anio";	
	$bb=mysqli_query($con,$aa) or die ("error buscando ".$aa);
	$mref=mysqli_fetch_array($bb);
	$numreu=$mref['Numreuniones'];
	$asisto=$mref['Asistenciatot'];
              echo '<table width="100%" border="0" cellspacing="3">'
				  .'<tr>'
					.'<td width="50%">Numero de reuniones</td>'
					.'<td width="50%"><input type="text" name="numreu" id="numreu" value="'.$numreu.'"/><span id="errornureu"></span></td>'
				 .' </tr>'
				 .' <tr>'
					.'<td>Asistencia total para mes</td>'
					.'<td><input type="text" name="asist" id="asist" value="'.$asisto.'"/><span id="errorasist"></span></td>'
				  .'</tr>'
				  .'<tr>'
					.'<td colspan="2" align="center"><input type="submit" name="modificaras" id="modificaras" value="Enviar" /></td>'
				 .' </tr>'
				.'</table>';
	break;
	case "insercion":
		echo '<table width="100%" border="0" cellspacing="3">'
				  .'<tr>'
					.'<td width="50%">Numero de reuniones</td>'
					.'<td width="50%"><input type="text" name="numreu" id="numreu" /><span id="errornureu"></span></td>'
				 .' </tr>'
				 .' <tr>'
					.'<td>Asistencia total para mes</td>'
					.'<td><input type="text" name="asist" id="asist" /><span id="errorasist"></span></td>'
				  .'</tr>'
				  .'<tr>'
					.'<td colspan="2" align="center"><input type="submit" name="agregaras" id="agregaras" value="Enviar" /></td>'
				 .' </tr>'
				.'</table>';
	break;
}





?>


	