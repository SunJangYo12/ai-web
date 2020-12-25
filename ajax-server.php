<?php
session_start();

if (isset($_GET['id']))
{
    $id = $_GET['id'];

    if ($id == "galimg") {
        $data = [   "text"  => "ini text",
            "image" => "http://192.168.0.105/ai-web/download.php?id=gambar://home/jin/Pictures/Telegram/IMG_20201016_092849_001.jpg",
            "link"  => "ini link",
            "okee"  => "ini okee",
            "yosh"  => "ini yosh",
        ];
        print_r(json_encode($data));
    }
    elseif ($id == "prog-upload") {
        $key = ini_get("session.upload_progress.prefix") . "myForm";
        if (!empty($_SESSION[$key])) {
           $current = $_SESSION[$key]["bytes_processed"];
           $total = $_SESSION[$key]["content_length"];
           echo $current < $total ? ceil($current / $total * 100) : 100;
        }
        else {
           echo 100;
        }
    }
}
elseif (isset($_GET['idexl'])) {
    $exl = explode(":", $_GET['idexl']);

    if ($exl[0] == "ffmpeg") 
    {
       if ($exl[1] == "image") 
       {
           $xfiles = $exl[2];

           $xbase = basename($exl[2]);

           $xfiles = trim(preg_replace('/\s\s+/', ' ', $xfiles));

           $xfiles = preg_replace("/ |'|\(|\)|\&/", '\\\${0}', $xfiles);
           $encname = preg_replace("/ |'|\(|\)|\&/", '\\\${0}', $xbase);

           $iminfo = getimagesize($xfiles); 
           $x = $iminfo[0] / 2;
           $y = $iminfo[1] / 2;

           while ($x >= 420 || $y >= 380) {
              $x = $x / 2;
              $y = $y / 2;
           }
           
           exec('ffmpeg -i '.$xfiles.' -vf scale='.$x.':'.$y.' thumbs/'.$encname);
           
           $newtext = delete_text_line("playlist.txt", 0);
           $xdir = dirname($newtext);
           $newtext = basename($newtext);
           $oldtext = $xbase;

           $encpath = preg_replace("/ |'|\(|\)|\&/", '\\\${0}', $xdir);

           $data = [  "new" => $newtext,
                      "old" => $oldtext,
                      "encpath" => $encpath,
                      "encname" => $encname,
                      "path" => $xdir,
                      "oldpath" => urlencode(dirname($exl[2])),
                      "tes" => $xdir,
           ];

           echo json_encode($data);
       }
       if ($exl[1] == "audio")  {
           $xfiles = $exl[2];

           $xfiles = preg_replace("/ |'|\(|\)|\&/", '\\\${0}', $xfiles);
           $xbase = get_basename($xfiles);
           $encname = get_basename($xfiles);

           $encname = trim(preg_replace('/\s\s+/', ' ', $encname));
          
           exec('ffmpeg -i '.$xfiles.' -an -vcodec copy thumbs/'.$encname.'.jpg');
           
           $newname = delete_text_line("playlist.txt", 0); // jangan akses dua kali
           $newdir = get_dirname($newname);
           $newname = get_basename($newname);
           $oldtext = get_basename($exl[2]);

           $data = [  
                      "new" => $newname,
                      "old" => $oldtext,
                      "size" => fsize($exl[2]),
                      "jalbum" => getinfomedia($xfiles),
                      "path" => $newdir,
                      "urlencpath" =>  urlencode(get_dirname($exl[2])),
                      "urlencname" =>  urlencode(get_basename($exl[2])),
                      "tes" => get_basename($exl[2]),
           ];

           echo json_encode($data);
       }
       if ($exl[1] == "doc")  {
           $xfiles = $exl[2];

           $xbase = basename($exl[2]);
           $encbase = basename($exl[2]);

           $encbase = trim(preg_replace('/\s\s+/', ' ', $encbase));
           

           $xfiles = preg_replace("/ |'|\(|\)|\&|\[|\]/", '\\\${0}', $xfiles); // replace unicode path and name
           $encname = preg_replace("/ |'|\(|\)|\&|\[|\]/", '\\\${0}', $encbase);

           $xfiles = trim(preg_replace('/\s\s+/', ' ', $xfiles)); // hapus enter
          
           exec('pdftoppm -l 1 -scale-to 500 -jpeg '.$xfiles.' > thumbs/'.basename($xfiles).'.jpg');

           $newtext = delete_text_line("playlist.txt", 0); // jangan akses dua kali
           $xdir = dirname($newtext);
           $newtext = basename($newtext);
           $oldtext = $xbase;

           $encpath = preg_replace("/ |'|\(|\)|\&/", '\\\${0}', $xdir);

           $data = [  
                      "new" => $newtext,
                      "old" => $oldtext,
                      "size" => fsize($exl[2]),
                      "encpath" => $encpath,
                      "encname" => $encname,
                      "path" => $xdir,
                      "urlencpath" =>  urlencode(dirname($exl[2])),
                      "urlencname" =>  urlencode(basename($exl[2])),
                      "tes" => dirname($xfiles),
           ];

           echo json_encode($data);
       }
       if ($exl[1] == "video")  {
           $xfiles = $exl[2];

           $xfiles = preg_replace("/ |'|\(|\)|\&/", '\\\${0}', $xfiles);
           $xbase = get_basename($xfiles);
           $encname = get_basename($xfiles);

           $encname = trim(preg_replace('/\s\s+/', ' ', $encname));

           exec('ffmpeg -ss 30 -t 3 -i '.$xfiles.' -vf "fps=10,scale=320:-1:flags=lanczos,split[s0][s1];[s0]palettegen[p];[s1][p]paletteuse" -loop 0 thumbs/'.$encname.'.gif');

           $newname = delete_text_line("playlist.txt", 0); // jangan akses dua kali
           $newdir = get_dirname($newname);
           $newname = get_basename($newname);
           $oldtext = get_basename($exl[2]);

           $data = [  "new" => $newname,
                      "old" => $oldtext,
                      "size" => base64_encode(fsize($exl[2])),
                      "path" => $newdir,
                      "urlencpath" =>  urlencode(get_dirname($exl[2])),
                      "urlencname" =>  urlencode(get_basename($exl[2])),
                      "tes" => get_dirname($exl[2]),
           ];

           echo json_encode($data);
       }
    }
    elseif ($exl[0] == "copymus") {
        array_map('unlink', glob("thumbs/*.mp3"));
       
        $path = $exl[1];
        $name = $exl[2];

        $path = urldecode($path);
        $name = urldecode($name);

        copy($path.'/'.$name, 'thumbs/'.$name);

        echo $name;
    }
    elseif ($exl[0] == "copydoc") {
        array_map('unlink', glob("thumbs/*.pdf"));
       
        $path = $exl[1];
        $name = $exl[2];

        $path = urldecode($path);
        $name = urldecode($name);

        $name = trim(preg_replace('/\s\s+/', ' ', $name));
        copy($path.'/'.$name, 'thumbs/open.pdf');

        echo $name;
    }
    elseif ($exl[0] == "copyvid") {
        array_map('unlink', glob("thumbs/*.mp4"));
       
        $path = $exl[1];
        $name = $exl[2];

        $path = urldecode($path);
        $name = urldecode($name);

        $path = str_replace("-jin-", ' ', $path);
        $name = str_replace("-jin-", ' ', $name);


        copy($path.'/'.$name, 'thumbs/'.$name);
        echo $name;
    }
    elseif ($exl[0] == "infomedia") {
        $path = urldecode($exl[1]);
        $name = urldecode($exl[2]);

        $input = $path."/".$name;
        $input = preg_replace("/ |'|\(|\)|\&/", '\\\${0}', $input);
        $objmusic = json_decode(shell_exec('ffprobe -v quiet -print_format json -show_format -show_streams '.$input));  

        /*foreach ($objmusic->{'format'} as $value) {
              foreach ($value as $key) {
                $output .= $key."\r";
              }
        }*/
        echo "<pre>";
        print_r($objmusic);
    }
    elseif ($exl[0] == "musfavorite") {
        $path = urldecode($exl[1]);
        $name = urldecode($exl[2]);

        $input = $path."/".$name;
        $input = preg_replace("/ |'|\(|\)|\&/", '\\\${0}', $input);
        $objmusic = json_decode(shell_exec('ffprobe -v quiet -print_format json -show_format -show_streams '.$input));  
        $artist = $objmusic->{'format'}->{'tags'}->{'artist'};

        songedit($path, $name, "artist", "best ".$artist);
    }
    elseif ($exl[0] == "musedit") {
        $path = urldecode($exl[1]);
        $name = urldecode($exl[2]);

        $input = $path."/".$name;
        $input = preg_replace("/ |'|\(|\)|\&/", '\\\${0}', $input);
        $objmusic = json_decode(shell_exec('ffprobe -v quiet -print_format json -show_format -show_streams '.$input));  
        $title = $objmusic->{'format'}->{'tags'}->{'title'};
        $artist = $objmusic->{'format'}->{'tags'}->{'artist'};
        $album_artist = $objmusic->{'format'}->{'tags'}->{'album_artist'};
        $album = $objmusic->{'format'}->{'tags'}->{'album'};
        $track = $objmusic->{'format'}->{'tags'}->{'track'};
        $disk = $objmusic->{'format'}->{'tags'}->{'disc'};
        $comment = $objmusic->{'format'}->{'tags'}->{'comment'};
        $genre = $objmusic->{'format'}->{'tags'}->{'genre'};
        $date = $objmusic->{'format'}->{'tags'}->{'date'};
        $encoder = $objmusic->{'format'}->{'tags'}->{'encoder'};
        $iTunPGAP = $objmusic->{'format'}->{'tags'}->{'iTunPGAP'};
        $iTunNORM = $objmusic->{'format'}->{'tags'}->{'iTunNORM'};
        $iTunSMPB = $objmusic->{'format'}->{'tags'}->{'iTunSMPB'};

        echo '<head>
                <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalabe=no"/>
            </head>';
        echo "<form method=POST action=''>";
        echo "<h3>Song info editing<h3/>";
        echo '
            <style>
                img {
                    border: 4px solid #575D63;
                    padding: 10px;
                }
            </style>';
        echo "<img width=300 height=300 src='thumbs/".$name.".jpg' />";
        $iminfo = getimagesize("thumbs/".$name.".jpg"); 
        echo "<t>".$iminfo[0]." x ".$iminfo[1]."</t>";

        echo "<pre><b>";
        echo "Title<br><input type=edit name=title value=".'"'.$title.'"'." /><br><br>";
        echo "Artist<br><input type=edit name=artist value=".'"'.$artist.'"'." /><br><br>";
        echo "Album<br><input type=edit name=album value=".'"'.$album.'"'." /><br><br>";
        echo "Album artist<br><input type=edit name=album_artist value=".'"'.$album_artist.'"'." /><br><br>";
        echo "Track<br><input type=edit name=track value=".'"'.$track.'"'." /><br><br>";
        echo "Disk<br><input type=edit name=disk value=".'"'.$disk.'"'." /><br><br>";
        echo "Comment<br><input type=edit name=comment value=".'"'.$comment.'"'." /><br><br>";
        echo "Genre<br><input type=edit name=genre value=".'"'.$genre.'"'." /><br><br>";
        echo "Date<br><input type=edit name=date value=".'"'.$date.'"'." /><br><br>";
        echo "Encoder<br><input type=edit name=encoder value=".'"'.$encoder.'"'." /><br><br>";
        echo "iTunPGAP<br><input type=edit name=iTunPGAP value=".'"'.$iTunPGAP.'"'." /><br><br>";
        echo "iTunNORM<br><input type=edit name=iTunNORM value=".'"'.$iTunNORM.'"'." /><br><br>";
        echo "iTunSMPB<br><input type=edit name=iTunSMPB value=".'"'.$iTunSMPB.'"'." /><br><br>";
       
        echo "<h3><input type=submit name=mussave value=Save </input></h3>";
        echo "<h3><input type=hidden name=name value=".urlencode($name)." ></input></h3>";
        echo "<h3><input type=hidden name=path value=".urlencode($path)." ></input></h3>";

        echo "<input type=hidden name=last_title value=".urlencode($title)." ></input>";
        echo "<input type=hidden name=last_artist value=".urlencode($artist)." ></input>";
        echo "<input type=hidden name=last_album value=".urlencode($album)." ></input>";
        echo "<input type=hidden name=last_album_artist value=".urlencode($album_artist)." ></input>";
        echo "<input type=hidden name=last_track value=".urlencode($track)." ></input>";
        echo "<input type=hidden name=last_disk value=".urlencode($disk)." ></input>";
        echo "<input type=hidden name=last_comment value=".urlencode($comment)." ></input>";
        echo "<input type=hidden name=last_genre value=".urlencode($genre)." ></input>";
        echo "<input type=hidden name=last_date value=".urlencode($date)." ></input>";
        
        echo "</pre></b>";
        echo "</form>";
    }
    elseif ($exl[0] == "pdfhissave") {
        $name = $exl[1];
        $page = $exl[2];

        if (!file_exists("pdfhistory")) {
            mkdir("pdfhistory", 0777, true);
        }
        $file = fopen("pdfhistory/".$name, "w");
        fwrite($file, $page);
        fclose($file);

        echo "saved";
    }
}

if (isset($_POST['mussave'])) {
    $title = $_POST['title'];
    $artist = $_POST['artist'];
    $album = $_POST['album'];
    $album_artist = $_POST['album_artist'];
    $track = $_POST['track'];
    $disk = $_POST['disk'];
    $comment = $_POST['comment'];
    $genre = $_POST['genre'];
    $date = $_POST['date'];

    $name = urldecode($_POST['name']);
    $path = urldecode($_POST['path']);

    $last_title = urldecode($_POST['last_title']);
    $last_artist = urldecode($_POST['last_artist']);
    $last_album = urldecode($_POST['last_album']);
    $last_album_artist = urldecode($_POST['last_album_artist']);
    $last_track = urldecode($_POST['last_track']);
    $last_disk = urldecode($_POST['last_disk']);
    $last_comment = urldecode($_POST['last_comment']);
    $last_genre = urldecode($_POST['last_genre']);
    $last_date = urldecode($_POST['last_date']);

    if ($title != $last_title) {
        songedit($path, $name, "title", $title);
    }
    elseif ($artist != $last_artist) {
        songedit($path, $name, "artist", $artist);
    }
    elseif ($album != $last_album) {
        songedit($path, $name, "album", $album);
    }
    elseif ($album_artist != $last_album_artist) {
        songedit($path, $name, "album_artist", $album_artist);
    }
    elseif ($track != $last_track) {
        songedit($path, $name, "track", $track);
    }
    elseif ($disk != $last_disk) {
        songedit($path, $name, "disk", $disk);
    }
    elseif ($comment != $last_comment) {
        songedit($path, $name, "comment", $comment);
    }
    elseif ($genre != $last_genre) {
        songedit($path, $name, "genre", $genre);
    }
    elseif ($date != $last_date) {
        songedit($path, $name, "date", $date);
    }
}

function songedit($path, $name, $metadata, $isimeta) {
    $xname = preg_replace("/ |'|\(|\)|\&|\[|\]/", '\\\${0}', $name);
    exec("ffmpeg -y -i thumbs/'".$name."' -c copy -metadata ".$metadata."='".$isimeta."' thumbs/edit.".$xname);

    if (file_exists('thumbs/edit.'.$name)) {
        if (!file_exists('backup')) {
            echo "<script>alert('Directory backup created');</script>";
            mkdir('backup', 0777, true);
        }
        copy($path.'/'.$name, 'backup/'.$name);
        unlink($path.'/'.$name);
        copy('thumbs/edit.'.$name, $path.'/'.$name);
            
        echo "<script>alert('Success Edit ".$metadata."');</script>";
    }
    else {
        echo "<script>alert('Failed Edit Songs');</script>";
    }
}

function getinfomedia($input) {
    $output = "";
    $objmusic = json_decode(shell_exec('ffprobe -v quiet -print_format json -show_format -show_streams '.$input));  
    $title = $objmusic->{'format'}->{'tags'}->{'title'};
    $artist = $objmusic->{'format'}->{'tags'}->{'artist'};
    $album_artist = $objmusic->{'format'}->{'tags'}->{'album_artist'};
    $album = $objmusic->{'format'}->{'tags'}->{'album'};
    $track = $objmusic->{'format'}->{'tags'}->{'track'};
    $disk = $objmusic->{'format'}->{'tags'}->{'disc'};
    $comment = $objmusic->{'format'}->{'tags'}->{'comment'};
    $genre = $objmusic->{'format'}->{'tags'}->{'genre'};
    $date = $objmusic->{'format'}->{'tags'}->{'date'};

    if ($title != null) $output .= "<font color=white>Tittle : </font>".$title."<br>";
    if ($title == null) $output .= "<font color=red>File : </font>".get_basename($input)."<br>";

    if ($artist != null) {
        $best = explode('best', $artist);
        if ($best[1] != null)
            $output .= "<font color=white>Artist : </font><font color=#FF69B4>".$artist."</font><br>";
        else
            $output .= "<font color=white>Artist : </font>".$artist."<br>";
    }
    if ($album != null) $output .= "<font color=white>Album : </font>".$album."<br>";
    if ($track != null) $output .= "<font color=white>Track : </font>".$track."<br>";
    if ($disk != null) $output .= "<font color=white>Disk : </font>".$disk."<br>";
    if ($comment != null) $output .= "<font color=white>Comment : </font>".$comment."<br>";
    if ($album_artist != null) $output .= "<font color=white>Album Artist : </font>".$album_artist."<br>";
    if ($genre != null) $output .= "<font color=white>Genre : </font>".$genre."<br>";
    if ($date != null) $output .= "<font color=white>Date : </font>".$date."<br>";

    return $output;
}

function delete_text_line($filepath, $num) {
    $row_number = $num;
    $file_out = file($filepath);
    unset($file_out[$row_number]);
    unlink($filepath);
    file_put_contents($filepath, implode("", $file_out));

    $file = fopen($filepath, 'r');
    if (!$file) {
      die('File tidak ada');
      return "File tidak ada";
    }
    else {
      return fgets($file);
    }
}

function get_basename($filename)
{
    $exl = explode('/', $filename);
    $count = count($exl);

    $out = $exl[$count - 1];
    $delent = explode("\n", $out);
    $out = $delent[0];

    return $out;
}
function get_dirname($filename)
{
  $exl = explode('/', $filename);
  $count = count($exl);
  $out = "";

  for($i=0; $i<$count; $i++) {
    if ($i != $count -1) {
      $out .= $exl[$i]."/";
    }
  }
  $out = substr($out, 0, -1); // delete last string

  return $out;
}

function fsize($input) {
    $size = filesize($input)/1024;
    $size = round($size,3);
    if($size >= 1024){
       $size = round($size/1024,2).' MB';
    }else{
       $size = $size.' KB';
    }

    return $size;
}
?>