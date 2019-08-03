<?php


	$dfile = $_GET['id'];
	$filename = basename($dfile);
	$finfo = finfo_open(FILEINFO_MIME_TYPE);
	header('Content-Type: ' . finfo_file($finfo, $dfile));
	header('Content-Length: '. filesize($dfile));
	header(sprintf('Content-Disposition: attachment; filename=%s',
		strpos('MSIE',$_SERVER['HTTP_REFERER']) ? rawurlencode($filename) : "\"$filename\"" ));
	ob_flush();
	readfile($dfile);
	
	exit;
	
?>