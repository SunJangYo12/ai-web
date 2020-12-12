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
    elseif ($aksi[0] == 'pdf') {
        $pdf = $aksi[1];
        echo '
            <script type="text/javascript">
                var url = "'.$pdf.'";
            </script>
            <body>
                <div>
                    <span>Page: <span id="page_num"></span> / <span id="page_count"></span></span>
                    &nbsp&nbsp<input type="submit" value="<" onclick="onPrevPage()">
                    &nbsp<input type="submit" value=">" onclick="onNextPage()">
                    &nbsp<input type="number" id="edtgo">
                    &nbsp<input type="submit" value="Go" onclick="onGotoPage()">
                </div>
                <div>
                    <canvas id="the-canvas" style="border:0px solid black"></canvas>
                </div>
                <script type="text/javascript" src="pdf.js"></script>
                <script type="text/javascript" src="pdfuse.js"></script>

                <div class="fab-container">
                    <span onclick=onPrevPage() class="fab-label">Prev</span><br><br>
                    <span onclick=onNextPage() class="fab-label">Next</span><br><br>
                </div>
            </body>

            <style>
                .fab-container {
                    position: fixed;
                    top: 50px;
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
                    font-size: 16px;
                    background: #666666;
                    color: #ffffff;
                    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
                    margin-right: 10px;
                }
            </style>
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