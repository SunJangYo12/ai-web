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
    elseif ($aksi[0] == 'videoview') {

        echo '
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
        ';

        echo '<script>document.title = "'.$aksi[1].'"</script>';

        if ($aksi[3] == 'true') // mobile
            echo '<video width=340 height=280 controls><source src="thumbs/'.$aksi[1].'"/></video>';
        else
            echo '<video width=800 height=480 controls><source src="thumbs/'.$aksi[1].'"/></video>';

        echo '
            <font color=yellow><p>Title: <marquee>'.$aksi[1].'</marquee>
            <br><br>Size: '.$aksi[2].'
            &nbsp&nbsp<input type=submit value=Rincian id=nothing onclick=rincian(this.id) />

            <script>
            function rincian(name) {
                var name = "'.$aksi[4].'/'.$aksi[1].'";
                alert(name);
                var encname = encodeURIComponent(name).replace("%20","+");

                window.open(
                    "ajax-server.php?idexl=infomedia:"+encname,
                    "_blank"
                );
                
            }
            function sukses() {
                alert("play sukses");
                
            }
            </script>
</html>
        ';
    }
    elseif ($aksi[0] == 'pdfobj') {
        copy($aksi[1], "thumbs/open1.pdf");
        echo '<script>document.title = "'.basename($aksi[1]).'";</script>';
        echo '<iframe type="application/pdf" src="thumbs/open1.pdf" width="1200" height="800"></iframe>';
    }
    elseif ($aksi[0] == 'pdf') {
        $pdf = $aksi[1];
        $his = $aksi[2];
        $hispage = "";

        $scandir = scandir("pdfhistory");
        foreach($scandir as $dir){
           if ($dir == $his) {
               $file = fopen("pdfhistory/".$dir, 'r');
               if (!$file) {
                   die('File tidak ada');
               }
               else {
                   $hispage = fgets($file);
               }
           }
        }
    
        echo '
            <script type="text/javascript">
                var url = "'.$pdf.'";
                var hissave = "'.$aksi[2].'";
                var hispage = "'.$hispage.'";
            </script>
            <!DOCTYPE HTML>
            <html>
            <head>
                <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalabe=no"/>
            </head>
            <body>
                <div>
                    <span>Page: <span id="page_num"></span> / <span id="page_count"></span></span>
                    &nbsp&nbsp<input type="submit" value="<" onclick="onPrevPage()">
                    &nbsp<input type="submit" value=">" onclick="onNextPage()">
                    &nbsp<input type="number" id="edtgo">
                    &nbsp<input type="submit" value="Go" onclick="onGotoPage()">
                </div>
                
                <div id="mydiv"></div>

                <div>
                    <canvas id="the-canvas"></canvas>
                </div>
                <script type="text/javascript" src="pdf.js"></script>
                <script type="text/javascript" src="pdfuse.js"></script>

            </body>
        ';
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