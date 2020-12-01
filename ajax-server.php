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

           $xbase = basename($exl[2]);
           $encbase = basename($exl[2]);

           $encbase = trim(preg_replace('/\s\s+/', ' ', $encbase));
           

           $xfiles = preg_replace("/ |'|\(|\)|\&|\[|\]/", '\\\${0}', $xfiles); // replace unicode path and name
           $encname = preg_replace("/ |'|\(|\)|\&|\[|\]/", '\\\${0}', $encbase);

           $xfiles = trim(preg_replace('/\s\s+/', ' ', $xfiles)); // hapus enter
          
           exec('ffmpeg -i '.$xfiles.' -an -vcodec copy thumbs/'.basename($xfiles).'.jpg');
           
           $newtext = delete_text_line("playlist.txt", 0); // jangan akses dua kali
           $xdir = dirname($newtext);
           $newtext = basename($newtext);
           $oldtext = $xbase;

           $encpath = preg_replace("/ |'|\(|\)|\&/", '\\\${0}', $xdir);

           $data = [  
                      "new" => $newtext,
                      "old" => $oldtext,
                      "size" => fsize($exl[2]),
                      "jalbum" => getinfomedia($xfiles),
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

           $xbase = basename($exl[2]);
           $encbase = basename($exl[2]);

           $xfiles = trim(preg_replace('/\s\s+/', ' ', $xfiles)); // hapus enter
           $encbase = trim(preg_replace('/\s\s+/', ' ', $encbase));

           $xfiles = preg_replace("/ |'|\(|\)|\&/", '\\\${0}', $xfiles); // replace unicode path and name
           $encname = preg_replace("/ |'|\(|\)|\&/", '\\\${0}', $encbase);

           exec('ffmpeg -ss 30 -t 3 -i '.$xfiles.' -vf "fps=10,scale=320:-1:flags=lanczos,split[s0][s1];[s0]palettegen[p];[s1][p]paletteuse" -loop 0 thumbs/'.$encname.'.gif');

           //echo $exl[3];
          
           $newtext = delete_text_line("playlist.txt", 0); // jangan akses dua kali
           $xdir = dirname($newtext);
           $newtext = basename($newtext);
           $oldtext = $xbase;

           $encpath = preg_replace("/ |'|\(|\)|\&/", '\\\${0}', $xdir);

           $data = [  "new" => $newtext,
                      "old" => $oldtext,
                      "size" => base64_encode(fsize($exl[2])),
                      "encpath" => $encpath,
                      "encname" => $encname,
                      "path" => $xdir,
                      "urlencpath" =>  urlencode(dirname($exl[2])),
                      "urlencname" =>  urlencode(basename($exl[2])),
                      "tes" => $exl[2],
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

        $name = trim(preg_replace('/\s\s+/', ' ', $name));
        copy($path.'/'.$name, 'thumbs/'.$name);

        echo $name;
    }
    elseif ($exl[0] == "copyvid") {
        array_map('unlink', glob("thumbs/*.mp4"));
       
        $path = $exl[1];
        $name = $exl[2];

        $path = str_replace("-jin-", ' ', $path);
        $name = str_replace("-jin-", ' ', $name);


        copy($path.'/'.$name, 'thumbs/'.$exl[2]);
        echo $exl[2];
    }
    elseif ($exl[0] == "infomedia") {
        $path = urldecode($exl[1]);
        $name = urldecode($exl[2]);

        $path = trim(preg_replace('/\s\s+/', ' ', $path));
        $name = trim(preg_replace('/\s\s+/', ' ', $name));

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
    if ($artist != null) $output .= "<font color=white>Artist : </font>".$artist."<br>";
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

function fsize($input) {
    $sizedata = trim(preg_replace('/\s\s+/', ' ', $input)); //hapus enter
    $size = filesize($sizedata)/1024;
    $size = round($size,3);
    if($size >= 1024){
       $size = round($size/1024,2).' MB';
    }else{
       $size = $size.' KB';
    }

    return $size;
}
?>