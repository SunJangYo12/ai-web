<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_FILES["userfile"])) {
    // move_uploaded_file()
}
?>
<html>
 <head>
  <title>File Upload Progress Bar</title>

  <style>
    #bar_blank {
        border: solid 1px #000;
        height: 20px;
        width: 300px;
    }
    #bar_color {
        background-color: #006666;
        height: 20px;
        width: 0px;
    }
    #bar_blank, #hidden_iframe {
        display: none;
    }
  </style>

 </head>
 <body>
  <div id="bar_blank">
   <div id="bar_color"></div>
  </div>
  <div id="status"></div>
  <form action="" method="POST" id="myForm" enctype="multipart/form-data" target="hidden_iframe">
   
   <input type="hidden" value="myForm" name="<?php echo ini_get("session.upload_progress.name"); ?>">
   <input type="file" name="userfile"><br>
   <input type="submit" value="Start Upload">
  
  </form>
  <iframe id="hidden_iframe" name="hidden_iframe" src="about:blank"></iframe>
  <script type="text/javascript" src="script.js"></script>
  
 </body>
</html>