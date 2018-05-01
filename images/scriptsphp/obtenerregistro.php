<?
$modo=$_GET['modo'];
$Publicador=$_GET['Publicador'];
$Mes=$_GET['Mes'];
$Anio=$_GET['Anio'];
$con=mysqli_connect("mysql.hostinger.com.ar","u300421416_root","registrospnb");
mysqli_select_db($con,"u300421416_regis") or die ("no se ha podido encontrar la base de datos");
switch ($modo)
{
	case "edicion":
	$aa="select * from records where Publicador=$Publicador AND Publicador=$Publicador AND Mes=$Mes AND Anio=$Anio";	
	$bb=mysqli_query($con,$aa) or die ("error buscando ".$aa);
	$mref=mysqli_fetch_array($bb);
	$Libros=$mref['Libros'];
	$Folletos=$mref['Folletos'];
	$Horas=$mref['Horas'];
	$Revistas=$mref['Revistas'];
	$Revisitas=$mref['Revisitas'];
	$Estbib=$mref['Estbib'];
	$Notas=$mref['Notas'];
	$Precaux=$mref['Precaux'];
	$Precreg=$mref['Precreg'];
	echo '<table width="100%" border="0" cellspacing="3">'
              .'<tr>'
               .' <td>Libros</td>'
               .' <td><input name="libros" type="text" id="libros" value="'.$Libros.'"/><p><span id="errorlibros" style="color:#F00"></span></p></td>'
              .'</tr>'
             .'<tr>'
               .' <td>Folletos y tratados</td>'
                .'<td><input name="folletos" type="text" id="folletos" value="'.$Folletos.'"/><p><span id="errorfolletos" style="color:#F00"></span></p></td>'
              . '</tr>'
             .' <tr>'
                .'<td>Horas</td>'
               .' <td><input name="horas" type="text" id="horas" value="'.$Horas.'"/><p><span id="errorlibros" style="color:#F00"></span></p></td>'
              .'</tr>'
             .' <tr>'
               .' <td>Revistas</td>'
                .'<td><input name="revistas" type="text" id="revistas" value="'.$Revistas.'"/><p><span id="errorrevistas" style="color:#F00"></span></p></td>'
              .'</tr>'
              .'<tr>'
                .'<td>Revisitas</td>'
               .' <td><input name="revisitas" type="text" id="revisitas" value="'.$Revisitas.'"/><p><span id="errorrevisitas" style="color:#F00"></span></p></td>'
             .' </tr>'
              .'<tr>'
                .'<td>Estudios biblicos</td>'
                .'<td><input name="estudios" type="text" id="estudios" value="'.$Estbib.'"/><p><span id="errorestudios" style="color:#F00"></span></p></td>'
              .'</tr>'
             .' <tr>'
			 .' <tr>';
			 	$Precaux=$mref['Precaux'];
				$Precreg=$mref['Precreg'];
				if ($Precaux=="SI")
				{
					echo '<td>Precursorado auxiliar <input name="precuaux" id="precuaux" type="checkbox" checked="checked"/></td>';	
				}
				else
				{
					echo '<td>Precursorado auxiliar <input name="precuaux" id="precuaux" type="checkbox"/></td>';	
				}
				if ($Precreg=="SI")
				{
					echo '<td>Precursorado regular <input name="precureg" id="precureg" type="checkbox" checked="checked"/></td>';
				}
				else
				{
					echo '<td>Precursorado regular <input name="precureg" id="precureg" type="checkbox" /></td>';	
				}	
				echo ' <tr>'
					.'<td><p><span id="errorprec" style="color:#F00"></span></p></td>'	
				  .'</tr>';		
			 echo '</tr>'
                .'<td>Notas</td>'
                .'<td><textarea name="notas" id="notas">'.$Notas.'</textarea><p><span id="errornotas" style="color:#F00"></span></p></td>'
              .'</tr>'
             .' <tr>'
               .' <td colspan="2" align="center"><input name="agregarregistro" id="agregarregistro" type="button" /></td>'
              .'</tr>'
            .'</table>';
	break;
	case "insercion":
		echo '<table width="100%" border="0" cellspacing="3">'
              .'<tr>'
               .' <td>Libros</td>'
               .' <td><input name="libros" type="text" id="libros"/><p><span id="errorlibros" style="color:#F00"></span></p></td>'
              .'</tr>'
             .'<tr>'
               .' <td>Folletos y tratados</td>'
                .'<td><input name="folletos" type="text" id="folletos"/><p><span id="errorfolletos" style="color:#F00"></span></p></td>'
              . '</tr>'
             .' <tr>'
                .'<td>Horas</td>'
               .' <td><input name="horas" type="text" id="horas"/><p><span id="errorhoras" style="color:#F00"></span></p></td>'
              .'</tr>'
             .' <tr>'
               .' <td>Revistas</td>'
                .'<td><input name="revistas" type="text" id="revistas"/><p><span id="errorrevistas" style="color:#F00"></span></p></td>'
              .'</tr>'
              .'<tr>'
                .'<td>Revisitas</td>'
               .' <td><input name="revisitas" type="text" id="revisitas"/><p><span id="errorrevisitas" style="color:#F00"></span></p></td>'
             .' </tr>'
              .'<tr>'
                .'<td>Estudios biblicos</td>'
                .'<td><input name="estudios" type="text" id="estudios"/><p><span id="errorestudios" style="color:#F00"></span></p></td>'
              .'</tr>';
			   echo ' <tr>'
					.'<td>Precursorado auxiliar <input name="precuaux" id="precuaux" type="checkbox" /></td>'
					.'<td>Precursorado regular <input name="precureg" id="precureg" type="checkbox" /></td>'	
				  .'</tr>';	
				   echo ' <tr>'
					.'<td><p><span id="errorprec" style="color:#F00"></span></p></td>'	
				  .'</tr>';	
            echo ' <tr>'
                .'<td>Notas adicionales</td>'
                .'<td><textarea name="notas" id="notas"></textarea><p><span id="errornotas" style="color:#F00"></span></p></td>'
              .'</tr>'
             .' <tr>'
               .' <td colspan="2" align="center"><input name="agregarregistro" id="agregarregistro" type="button" /></td>'
              .'</tr>'
            .'</table>';
	break;
}





?>


	