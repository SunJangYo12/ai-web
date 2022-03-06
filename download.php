<?php

    $dfile = $_GET['id'];
    $version = "3.0";
    $aksi = explode(":", $dfile);

    if ($aksi[0] == 'musicview' || $aksi[0] == 'videoview') {
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
                img {
                    border: 4px solid #575D63;
                    padding: 10px;
                    width: 300px;
                    height: 300px
                }
            </style>
        </head>
        ';
    }

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
    elseif ($aksi[0] == 'musictextview') {

        echo '
            <link rel="stylesheet" type="text/css" href="bg.css">
            <center>
            <div id="spinner" class="loading"></div><br>
            <div id="header"></div>
            <div id="hasil"></div>
            </center>
            <script>

            var total = "'.$aksi[2].'";
            var total = total - 1;
            var targetpath = "'.$aksi[3].'";

            function task(name, pathname, line) 
            {
                var xhr = new XMLHttpRequest();
                var url = "ajax-server.php?idexl=getstr:"+pathname+":"+line+":"+targetpath;

                xhr.onloadstart = function () {
                    document.getElementById("spinner").style.display = "block";
                    document.getElementById("header").innerHTML = "<h1><font color=yellow>"+name+"&nbsp&nbsp"+line+"/"+total+"</font></h1>";
                }
                xhr.onreadystatechange = function() {
                    if (this.responseText !== "" && this.readyState == 4) 
                    {
                        var data = JSON.parse(this.responseText);
                        var content = document.createElement("h5");
                        
                        content.innerHTML = "<font color=yellow>"+data.line+"</font>&nbsp"+data.strdata+"&nbsp&nbsp<font color=yellow>|</font>&nbsp&nbsp"+data.strfix;
                        document.getElementById("hasil").append(content);

                        if (line != total)
                        {
                            line += 1;
                            task(name, pathname, line);
                        }
                        else {
                            document.getElementById("spinner").style.display = "";
                            document.getElementById("header").innerHTML += "<h2><font color=green>Finish process</font></h2><form method=post action=ai.php><input type=submit name=updmusiktxt value=Update></input><input type=hidden name=updmusiktxtdata value="+pathname+"></input></form>";
                        }
                    }
                };
                xhr.open("GET", url, true);
                xhr.send();
            }

            task("'.basename($aksi[1]).'", "'.$aksi[1].'", 0);
            </script>
        ';


    }
    elseif ($aksi[0] == 'musicview') {
        $path = $aksi[1];
        $name = $aksi[2];

        echo '
            <link rel = "icon" type = "thumbs/'.$name.'.jpg" href = "name-of-image.png">
            <a onclick=saveimg()><img src="thumbs/'.$name.'.jpg" alt=""></img></a>
            <div id="hasil"></div>
            <div class="fab-container">
                <span onclick=prev() class="fab-label">Prev</span>
                <span onclick=next() class="fab-label">Next</span><br><br>
            </div>

            <script>
            var isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
            document.title = "'.$name.'";
            //document.alt = "thumbs/'.$name.'.jpg";
            </script>

            <style>
                .fab-container {
                    position: fixed;
                    bottom: 115px;
                    right: 50px;
                    z-index: 999;
                    cursor: pointer;
                }
                .fab-label {
                    padding: 2px 5px;
                    align-self: center;
                    user-select: none;
                    white-space: nowrap;
                    border-radius: 3px;
                    font-size: 19px;
                    background: #666666;
                    color: #ffffff;
                    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
                    margin-right: 10px;
                }
            </style>

            <script>

            function next() {
                var xhr = new XMLHttpRequest();
                var url = "ajax-server.php?idexl=nextaudio:"+"'.$path.':'.$name.'";
                xhr.onloadstart = function () {
                }

                xhr.onreadystatechange = function() {
                    if (this.responseText !== "" && this.readyState == 4) 
                    {
                        var data = JSON.parse(this.responseText);
                        location.href = "download.php?id=musicview:"+data.nextpath+":"+data.nextname;
                    }
                };
                xhr.open("GET", url, true);
                xhr.send();
            }
            function prev() {
                var xhr = new XMLHttpRequest();
                var url = "ajax-server.php?idexl=prevaudio:"+"'.$path.':'.$name.'";
                xhr.onloadstart = function () {
                }

                xhr.onreadystatechange = function() {
                    if (this.responseText !== "" && this.readyState == 4) 
                    {
                        var data = JSON.parse(this.responseText);
                        location.href = "download.php?id=musicview:"+data.prevpath+":"+data.prevname;
                    }
                };
                xhr.open("GET", url, true);
                xhr.send();
            }

            function favorite() {
                var name = "'.$path.':'.$name.'";

                window.open(
                    "ajax-server.php?idexl=musfavorite:"+name,
                    "_blank"
                );
            }
            function edit() {
                var name = "'.$path.':'.$name.'";

                window.open(
                    "ajax-server.php?idexl=musedit:"+name,
                    "_blank"
                );
            }
            function rincian() {
                var name = "'.$path.':'.$name.'";

                window.open(
                    "ajax-server.php?idexl=infomedia:"+name,
                    "_blank"
                );
            }
            function saveimg() {
                var name = "'.$name.'.jpg";

                if (confirm("Simpan Gambar ini?")) {
                    window.open(
                        "download.php?id=thumbs/"+name,
                        "_blank"
                    );
                }  
            }
            function sukses() {
                next();
            }

            function getAudio(name) {
                var xhr = new XMLHttpRequest();
                var url = "ajax-server.php?idexl=ffmpeg:audioinfo:"+name;
                xhr.onloadstart = function () {
                }

                xhr.onreadystatechange = function() {
                    if (this.responseText !== "" && this.readyState == 4) 
                    {
                        var data = JSON.parse(this.responseText);

                        document.getElementById("hasil").innerHTML += "<font color=yellow><h5>"+data.jalbum+"</h5><b>Size: "+data.size+"</b></font>";
                        document.getElementById("hasil").innerHTML += "&nbsp&nbsp<input type=submit value=Favorite onclick=favorite() />";
                        document.getElementById("hasil").innerHTML += "&nbsp&nbsp<input type=submit value=Rincian onclick=rincian() />";
                        document.getElementById("hasil").innerHTML += "&nbsp&nbsp<input type=submit value=Edit onclick=edit() />";
                        ';

                        echo "

                        document.getElementById('hasil').innerHTML += '<br><br>&nbsp&nbsp<audio id=playmusgal onended=sukses() autoplay controls> <source <source <source src=".'"'."'+data.playname+'".'"'." type=audio/mpeg> Browser Error </audio><br><br>';

                        ";

                        echo '

                    }
                };
                xhr.open("GET", url, true);
                xhr.send();
            }
            getAudio("'.$path.'/'.$name.'");

            </script>

        ';

    }
    elseif ($aksi[0] == 'videoview') {

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
