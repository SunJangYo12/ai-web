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

           $xfilesize = trim(preg_replace('/\s\s+/', ' ', $exl[2]));

           $iminfo = getimagesize($xfilesize); 
           $x = $iminfo[0];
           $y = $iminfo[1];

           while ($x >= 420 || $y >= 380) {
              $x = $x / 2;
              $y = $y / 2;
           }

           /*$_data = fopen("tees.txt", "w");
           fwrite($_data, "$x ff");
           fclose($_data);*/

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
       if ($exl[1] == "audioinfo") {
           $xfiles = $exl[2];

           $xfiles = preg_replace("/ |'|\(|\)|\&/", '\\\${0}', $xfiles);
           $name = basename($exl[2]);
           $name = trim(preg_replace('/\s\s+/', ' ', $name));

           array_map('unlink', glob("thumbs/*.mp3"));
           array_map('unlink', glob("thumbs/*.flac"));
           array_map('unlink', glob("thumbs/*.m4a"));

           copy($exl[2], "thumbs/".$name);

           $data = [  
                      "size" => fsize($exl[2]),
                      "playname" => "thumbs/".$name,
                      "jalbum" => getinfomedia($xfiles),
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
          
           exec('/usr/bin/pdftoppm -l 1 -scale-to 500 -jpeg '.$xfiles.' > thumbs/'.basename($xfiles).'.jpg');

           $newtext = delete_text_line("playlist.txt", 0); // jangan akses dua kali
           $xdir = dirname($newtext);
           $newtext = basename($newtext);
           $oldtext = $xbase;

           $encpath = preg_replace("/ |'|\(|\)|\&/", '\\\${0}', $xdir);

           $pathname = trim(preg_replace('/\s\s+/', ' ', $exl[2])); // hapus enter

           $data = [  
                      "new" => $newtext,
                      "old" => $oldtext,
                      "size" => fsize($exl[2]),
                      "encpath" => $encpath,
                      "encname" => $encname,
                      "path" => $xdir,
                      "urlencpath" =>  urlencode(dirname($exl[2])),
                      "urlencname" =>  urlencode(basename($exl[2])),
                      "pathname" => urlencode($pathname),
           ];

           echo json_encode($data);
       }
       if ($exl[1] == "video")  {
           $xfiles = $exl[2];

           $xfiles = preg_replace("/ |'|\(|\)|\&/", '\\\${0}', $xfiles);
           $xbase = get_basename($xfiles);
           $encname = get_basename($xfiles);

           $encname = trim(preg_replace('/\s\s+/', ' ', $encname));

           $format = $exl[3];

           if ($format == "gif") {
              exec('ffmpeg -ss 2 -t 3 -i '.$xfiles.' -vf "fps=10,scale=220:-1:flags=lanczos,split[s0][s1];[s0]palettegen[p];[s1][p]paletteuse" -loop 0 thumbs/'.$encname.'.gif');
           }
           else if ($format == "png"){
              exec('ffmpeg -i '.$xfiles.' -vf "scale=320:320:force_original_aspect_ratio=decrease" -ss 00:00:01.000 -vframes 1 thumbs/'.$encname.'.png');
           }
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
    elseif ($exl[0] == "copyprocpdf") {
        copy($exl[1], 'thumbs/open.pdf');

        echo 'sukses';
    }
    elseif ($exl[0] == "copyprocimg") {
        copy($exl[1], 'thumbs/open.jpg');

        echo 'sukses';
    }
    elseif ($exl[0] == "copyprocvid") {
        copy($exl[1], 'thumbs/open.mp4');

        echo 'sukses';
    }
    elseif ($exl[0] == "convertprocvid") {
        $conv = 'thumbs/open.mp4';
        
        copy($exl[1], $conv);

        exec('ffmpeg -i '.$conv.' -f mp3 -ab 192000 -vn thumbs/convert.mp3');

        echo 'sukses';
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

        if ($artist == null) 
            $artist = $objmusic->{'format'}->{'tags'}->{'ARTIST'};

        if ($artist == null) 
            $artist = $objmusic->{'format'}->{'tags'}->{'Artist'};

        if ($artist == null) 
            echo "<script>alert('Failed Edit : tidak ditemukan metadata artist');</script>";
        else
            songedit($path, $name, "artist", "best ".$artist);
    }
    elseif ($exl[0] == "musedit") {
        $path = urldecode($exl[1]);
        $name = urldecode($exl[2]);

        $input = $path."/".$name;
        $input = preg_replace("/ |'|\(|\)|\&/", '\\\${0}', $input);
        $objmusic = json_decode(shell_exec('ffprobe -v quiet -print_format json -show_format -show_streams '.$input));  

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

        $meta = "";
        $last_meta = "";
        $my_key = "";
        $i = 0;

        echo "<pre><b>";

        foreach ($objmusic->{'format'} as $value) {
            foreach ($value as $key=>$value) {
                $meta .= $key."<br><input type=edit name=meta_".$i." value=".'"'.$value.'"'." /><br><br>";
                $last_meta .= "<input type=hidden name=last_".$i." value=".urlencode($value)." ></input>";
                $my_key .= "<input type=hidden name=key_".$i." value=".urlencode($key)." ></input>";
                $i += 1;
            }
        }
        echo $meta;
        echo $last_meta;
        echo $my_key;
        
        echo "<h3><input type=submit name=mussave value=Save </input></h3>";
        echo "<h3><input type=hidden name=name value=".urlencode($name)." ></input></h3>";
        echo "<h3><input type=hidden name=path value=".urlencode($path)." ></input></h3>";

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
    elseif ($exl[0] == "nextaudio") {
        $path = $exl[1];
        $name = $exl[2];

        $getNPAudio = getPlayAudio($path."/".$name."\n", "next");

        $data = [  
            "nextpath" => get_dirname($getNPAudio),
            "nextname" => get_basename($getNPAudio),
        ];

        echo json_encode($data);
    }
    elseif ($exl[0] == "prevaudio") {
        $path = $exl[1];
        $name = $exl[2];

        $getNPAudio = getPlayAudio($path."/".$name."\n", "prev");

        $data = [  
            "prevpath" => get_dirname($getNPAudio),
            "prevname" => get_basename($getNPAudio),
        ];

        echo json_encode($data);
    }
    elseif ($exl[0] == "mount_ar") {
        $path = $exl[1];

        if (!file_exists('mount')) {
            mkdir('mount', 0777, true);
        }

        if (foldervoid('mount') == 1) {
            shell_exec('umount mount');
        }

        $pathname = $path;
        $pathname = preg_replace("/ |'|\(|\)|\&|\[|\]/", '\\\${0}', $pathname); // replace unicode path and name
        $pathname = trim(preg_replace('/\s\s+/', ' ', $pathname)); // hapus enter

        $status = shell_exec('fuse-archive '.$pathname." mount");

        $data = [  
            "status" => $status,
            "pathname" => $pathname,
        ];

        echo json_encode($data);
    }
}

if (isset($_POST['mussave'])) {
    $name = urldecode($_POST['name']);
    $path = urldecode($_POST['path']);

    for ($i=0; $i<100; $i++) {
        if (isset($_POST['last_'.$i])) {
            $last_value = urldecode($_POST['last_'.$i]);
            $value = urldecode($_POST['meta_'.$i]);
            $key = urldecode($_POST['key_'.$i]);

            if ($last_value != $value) {
                songedit($path, $name, $key, $value);
            }
        }
        else {
            break;
        }
    }
}

function foldervoid($path)
{
    if ($files = glob($path . "/*")) {
        //print_r($files);
      return 1;
    } else {
      return 0;
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

    foreach ($objmusic->{'format'} as $value) {
        foreach ($value as $key=>$value) {
            if ($key == "TITLE" || $key == "Title" || $key == "title" ||
                $key == "ARTIST" || $key == "Artist" || $key == "artist" ||
                $key == "ALBUM_ARTIST" || $key == "Album_artist" || $key == "album_artist" ||
                $key == "GENRE" || $key == "Genre" || $key == "genre" ||
                $key == "DATE" || $key == "Date" || $key == "date" ||
                $key == "TRACK" || $key == "Track" || $key == "track"
                ) {

                $exl = explode('best', $value);
                if ($exl[1] != null)
                    $output .= "<font color=white>".$key." : </font><font color=#FF69B4>".$value."</font><br>";
                else
                    $output .= "<font color=white>".$key." : </font>".$value."<br>";
            }
        }
    }

    return $output;
}

function getPlayAudio($strfind, $key) {
  $handle = fopen("playliststart.txt", "r");
  $arr = array();
  $i = 0;
  $result = "kosong";
  $resultNext = "kosong";
  $resultPrev = "kosong";
  $resultline = 0;

  if ($handle) {
      while (($line = fgets($handle)) !== false) {
          $arr[$i] = $line;

          if ($line == $strfind) {
            $result = $line;
            $resultline = $i;
          }
          $i++;
      }
      fclose($handle);
  } else {
      echo "file no found";
  }

  if ($key == "result") {
    $out = trim(preg_replace('/\s\s+/', ' ', $result));
    return $out;
  }
  elseif ($key == "next") {
    $out = trim(preg_replace('/\s\s+/', ' ', $arr[$resultline+1]));
    return $out;
  }
  elseif ($key == "prev") {
    $out = trim(preg_replace('/\s\s+/', ' ', $arr[$resultline-1]));
    return $out;
  }
  elseif ($key == "line") {
    $out = trim(preg_replace('/\s\s+/', ' ', $resultline));
    return $out;
  }
  else {
    return "key unkown";
  }
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
    $input = trim(preg_replace('/\s\s+/', ' ', $input));

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