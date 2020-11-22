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
           $xpath = $exl[2];
           $xgalfile = $exl[3];

           $xpath = preg_replace("/ |'|\(|\)|\&/", '\\\${0}', $xpath);
           $xgalfile = preg_replace("/ |'|\(|\)|\&/", '\\\${0}', $xgalfile);

           $iminfo = getimagesize($xpath.'/'.$xgalfile); 
           $x = $iminfo[0] / 2;
           $y = $iminfo[1] / 2;

           while ($x >= 420 || $y >= 380) {
              $x = $x / 2;
              $y = $y / 2;
           }

           exec('ffmpeg -i '.$xpath.'/'.$xgalfile.' -vf scale='.$x.':'.$y.' thumbs/'.$xgalfile);
           echo $exl[3];
       }
       if ($exl[1] == "audio") 
       {
           $xpath = $exl[2];
           $xgalfile = $exl[3];

           $xpath = preg_replace("/ |'|\(|\)|\&/", '\\\${0}', $xpath);
           $xgalfile = preg_replace("/ |'|\(|\)|\&/", '\\\${0}', $xgalfile);

           exec('ffmpeg -i '.$xpath.'/'.$xgalfile.' -an -vcodec copy thumbs/'.$xgalfile.'.jpg');
           
           //echo $exl[3];
          
           $jpath = preg_replace('/\s+/', '\-jin-', $exl[2]);
           $jname = preg_replace('/\s+/', '\-jin-', $exl[3]);

           $xxx = str_replace(" ", "-jin-", $exl[3]);
           $yyy = str_replace(" ", "-jin-", $exl[2]);

           $data = [  "jpath" => $jpath,
                      "jname"=> $exl[3],
                      "jxxx" => $xxx,
                      "jyyy" => $yyy,
                      "galfile" => $exl[3],
           ];

           echo json_encode($data);
       }
    }
    elseif ($exl[0] == "copy") {
        array_map('unlink', glob("thumbs/*.mp3"));
       
        $path = $exl[1];
        $name = $exl[2];

        $path = str_replace("-jin-", ' ', $path);
        $name = str_replace("-jin-", ' ', $name);


        copy($path.'/'.$name, 'thumbs/'.$exl[2]);
        echo $exl[2];
    }
}
?>