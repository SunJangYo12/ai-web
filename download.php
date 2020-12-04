<?php

    $dfile = $_GET['id'];
    $aksi = explode(":", $dfile);

    if ($aksi[0] == 'gambar') {
        $image = $aksi[1]; 
        $content = file_get_contents($image); 
        header('Content-Type: image/jpeg');
        echo $content;
        exit();
    }
    elseif ($aksi[0] == 'video') {
        $video = $aksi[1]; 
        $content = file_get_contents($video); 
        header('Content-Type: video/mp4');
        echo $content;
        exit();
    }
    elseif ($aksi[0] == 'suara') {
        $suara = $aksi[1]; 
        $content = file_get_contents($suara); 
        header('Content-Type: audio/mpeg');
        echo $content;
        exit();
    }
    else {
        $mime = strtolower(pathinfo($dfile, PATHINFO_EXTENSION));
        $filename = basename($dfile);
        $finfo = finfo_open(FILEINFO_MIME_TYPE);

        if ($mime == "apk") {
            header('Content-Type: application/vnd.android.package-archive');
        }
        else {
            header('Content-Type: ' . finfo_file($finfo, $dfile));
        }
        header('Content-Length: '. filesize($dfile));
        header(sprintf('Content-Disposition: attachment; filename=%s', strpos('MSIE',$_SERVER['HTTP_REFERER']) ? rawurlencode($filename) : "\"$filename\"" ));
        ob_flush();
        readfile($dfile);
        exit;
    }
?>