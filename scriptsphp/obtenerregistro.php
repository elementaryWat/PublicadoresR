<?
session_start();
$modo=$_GET['modo'];
$Publicador=$_GET['Publicador'];
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
$a="SELECT * FROM `publicadores` WHERE Idpublicadores=$Publicador";
$b = mysqli_query ($con,$a)
or die ("error buscando".$a);
$m=mysqli_fetch_array ($b);	
$EsPrecreg=$m['Precreg'];
switch ($modo)
{
	case "edicion":
	$aa="select * from records2 where Publicador=$Publicador AND Publicador=$Publicador AND Mes=$Mes AND Anio=$Anio";	
	$bb=mysqli_query($con,$aa) or die ("error buscando ".$aa);
	$mref=mysqli_fetch_array($bb);
	$Publicaciones=$mref['Publicaciones'];
	$Videos=$mref['Videos'];
	$Horas=$mref['Horas'];
	$Revisitas=$mref['Revisitas'];
	$Estbib=$mref['Estbib'];
	$Notas=$mref['Notas'];
	$Precaux=$mref['Precaux'];
	$Precreg=$mref['Precreg'];
	echo '<table width="100%" border="0" cellspacing="3">'
              .'<tr>'
               .' <td>Publicaciones (impresas y electronicas)</td>'
               .' <td><input name="publicaciones" type="text" id="publicaciones" value="'.$Publicaciones.'" class="boton" tabindex="1" onkeydown="enter2tab(e)"/><p><span id="errorpublicaciones" style="color:#F00"></span></p></td>'
              .'</tr>'
             .'<tr>'
               .' <td>Videos</td>'
                .'<td><input name="videos" type="text" id="videos" value="'.$Videos.'" class="boton" tabindex="2"/><p><span id="errorvideos" style="color:#F00"></span></p></td>'
              . '</tr>'
             .' <tr>'
                .'<td>Horas</td>'
               .' <td><input name="horas" type="text" id="horas" value="'.$Horas.'" class="boton" tabindex="3"/><p><span id="errorlibros" style="color:#F00"></span></p></td>'
              .'</tr>'
              .'<tr>'
                .'<td>Revisitas</td>'
               .' <td><input name="revisitas" type="text" id="revisitas" value="'.$Revisitas.'" class="boton" tabindex="5"/><p><span id="errorrevisitas" style="color:#F00"></span></p></td>'
             .' </tr>'
              .'<tr>'
                .'<td>Estudios biblicos</td>'
                .'<td><input name="estudios" type="text" id="estudios" value="'.$Estbib.'" class="boton" tabindex="6"/><p><span id="errorestudios" style="color:#F00"></span></p></td>'
              .'</tr>'
             .' <tr>'
			 .' <tr>';
			 	$Precaux=$mref['Precaux'];
				$Precreg=$mref['Precreg'];
				
				if ($EsPrecreg=="NO")
				{
					echo '<td colspan="2"><span';
					echo '>Precursorado auxiliar <input name="precuaux" id="precuaux" type="checkbox"';
					if ($Precaux=="SI")
					{
						 echo ' checked="checked" ';	
					}
					echo ' class="check" tabindex="7"/></span></td>';
				}
				
				
				if ($EsPrecreg=="SI")
				{
					echo '<td colspan="2"><span';
					echo '>Precursorado regular <input name="precureg" id="precureg" type="checkbox"';
					if ($EsPrecreg=="SI")
					{
						echo ' checked="checked" disabled readonly';
					}
					 echo ' class="check tabindex="8""/></span></td>';
				}
				
				echo ' <tr>'
					.'<td><p><span id="errorprec" style="color:#F00"></span></p></td>'	
				  .'</tr>';		
			 echo '</tr>'
                .'<td>Notas</td>'
                .'<td><textarea name="notas" id="notas" class="boton" tabindex="9">'.$Notas.'</textarea><p><span id="errornotas" style="color:#F00"></span></p></td>'
              .'</tr>'
             .' <tr>'
               .' <td colspan="2" align="center"><input name="agregarregistro" id="agregarregistro" type="button" class="boton" tabindex="10"/></td>'
              .'</tr>'
            .'</table>';
	break;
	case "insercion":
		echo '<table width="100%" border="0" cellspacing="3">'
              .'<tr>'
               .' <td>Publicaciones (impresas y electronicas)</td>'
               .' <td><input name="publicaciones" type="text" id="publicaciones" class="boton" tabindex="1"/><p><span id="errorpublicaciones" style="color:#F00"></span></p></td>'
              .'</tr>'
             .'<tr>'
               .' <td>Videos</td>'
                .'<td><input name="videos" type="text" id="videos" class="boton" tabindex="2"/><p><span id="errorvideos" style="color:#F00"></span></p></td>'
              . '</tr>'
             .' <tr>'
                .'<td>Horas</td>'
               .' <td><input name="horas" type="text" id="horas" class="boton" tabindex="3"/><p><span id="errorhoras" style="color:#F00"></span></p></td>'
              .'</tr>'
              .'<tr>'
                .'<td>Revisitas</td>'
               .' <td><input name="revisitas" type="text" id="revisitas" class="boton" tabindex="5"/><p><span id="errorrevisitas" style="color:#F00"></span></p></td>'
             .' </tr>'
              .'<tr>'
                .'<td>Estudios biblicos</td>'
                .'<td><input name="estudios" type="text" id="estudios" class="boton" tabindex="6"/><p><span id="errorestudios" style="color:#F00"></span></p></td>'
              .'</tr>';
			   echo ' <tr>';
				if ($EsPrecreg=="NO")
				{
					echo '<td colspan="2"><span';
					echo '>Precursorado auxiliar <input name="precuaux" id="precuaux" type="checkbox"';
					if ($Precaux=="SI")
					{
						 echo ' checked="checked" ';	
					}
					echo ' class="check" tabindex="7"/></span></td>';
				}
				
				
				if ($EsPrecreg=="SI")
				{
					echo '<td colspan="2"><span';
					echo '>Precursorado regular <input name="precureg" id="precureg" type="checkbox"';
					if ($EsPrecreg=="SI")
					{
						echo ' checked="checked" disabled readonly';
					}
					 echo ' class="check tabindex="8""/></span></td>';
				}
				  echo '</tr>';	
            echo ' <tr>'
                .'<td>Notas adicionales</td>'
                .'<td><textarea name="notas" id="notas" class="boton" tabindex="9"></textarea><p><span id="errornotas" style="color:#F00"></span></p></td>'
              .'</tr>'
             .' <tr>'
               .' <td colspan="2" align="center"><input name="agregarregistro" id="agregarregistro" type="button" tabindex="10"/></td>'
              .'</tr>'
            .'</table>';
	break;
}





?>


	