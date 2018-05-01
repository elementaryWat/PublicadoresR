<?
session_start();
date_default_timezone_set('America/Argentina/Buenos_Aires');
$user=$_GET['myuser'];
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
$aa="select Usuario,Pass from usuarios where Iduser=$user";	
$bb=mysqli_query($con,$aa) or die ("error buscando ".$aa);
$mref=mysqli_fetch_array($bb);
$Usuario=$mref['Usuario'];
$Pass=$mref['Pass'];
echo '<table width="100%" border="0" cellspacing="4" cellpadding="1">'
	  .'<tr>'
		.'<td>Nombre de usuario</td>'
		.'<td><input type="text" name="userr" id="userr" value="'.$Usuario.'"/></td>'
	  .'</tr>'
	  .'<tr>'
		.'<td>Contraseña</td>'
		.'<td><input type="text" name="passs" id="passs" value="'.$Pass.'"/></td>'
	  .'</tr>'
	  .'<tr>'
		.'<td colspan="2" align="center"><input type="button" name="cambiar" id="cambiar" value="Editar datos" /></td>'
	  .'</tr>'
	.'</table>';

	

?>



	