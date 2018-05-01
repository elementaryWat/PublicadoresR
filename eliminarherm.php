<? 
$con=mysqli_connect("mysql.hostinger.com.ar","u300421416_root","registrospnb");
mysqli_select_db($con,"u300421416_regis") or die ("no se ha podido encontrar la base de datos");
$id=$_GET['id'];
$a="UPDATE `publicadores` SET Familia=0 WHERE `Idpublicadores` = $id";
$b=mysqli_query($con,$a) or die ("error buscando ".$a);
?>