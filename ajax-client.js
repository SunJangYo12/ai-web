function procOpenImage(name) 
{
    var xhr = new XMLHttpRequest();
    var url = "ajax-server.php?idexl=copyprocimg:"+name;

    xhr.onloadstart = function () {
        alert("Opening image...");
        document.title = "Opening image...";
    }

    xhr.onreadystatechange = function() {
        if (this.responseText !== "" && this.readyState == 4) 
        {
            document.title = "sukses";
            if (confirm('Open Image?')) {
                window.open(
                    'download.php?id=gambar:thumbs/open.jpg',
                    '_blank'
                );
            } 
        }
    };
    xhr.open("GET", url, true);
    xhr.send();
}

function procOpenVideo(name, copy=false) 
{
    var xhr = new XMLHttpRequest();
    var url = "ajax-server.php?idexl=copyprocvid:"+name;


    xhr.onloadstart = function () {
        alert("Opening video...")
        document.title = "Opening video...";
    }

    xhr.onreadystatechange = function() {
        if (this.responseText !== "" && this.readyState == 4) 
        {
            document.title = "sukses";
            var vsize = 0;
            var isMobile = true;
            var vname = "open.mp4";

            if (confirm('Open Video?')) {
                window.open(
                    'download.php?id=videoview:'+vname+':'+vsize+':'+isMobile+':'+name,
                    '_blank'
                );
            } 
        }
    };

    if (copy) {
        url = "ajax-server.php?idexl=copyprocvidcopy:"+name;
        alert("Copy!");
    }
    else {
        alert("Symlink!");
    }
    
    xhr.open("GET", url, true);
    xhr.send();
}
function procConvertVid(name) 
{
    var xhr = new XMLHttpRequest();
    var url = "ajax-server.php?idexl=convertprocvid:"+name;

    xhr.onloadstart = function () {
        alert("Convert Video please wait...")
        document.title = "Converting...";
    }

    xhr.onreadystatechange = function() {
        if (this.responseText !== "" && this.readyState == 4) 
        {
            document.title = "Sukses converting video";

            if (confirm('Success\rBuka Music hasil convert?')) {
                window.open(
                    'download.php?id=suara:thumbs/convert.mp3',
                    '_blank'
                );
            } 
        }
    };
    xhr.open("GET", url, true);
    xhr.send();
}

function procOpenPdf(name) 
{
    var xhr = new XMLHttpRequest();
    var url = "ajax-server.php?idexl=copyprocpdf:"+name;

    xhr.onloadstart = function () {
        alert("Opening pdf...");
        document.title = "Opening Pdf...";
    }

    xhr.onreadystatechange = function() {
        if (this.responseText !== "" && this.readyState == 4) 
        {
            document.title = "sukses";
            
            if (confirm('Open Image?')) {
                window.open(
                    'download.php?id=pdf:thumbs/open.pdf',
                    '_blank'
                );
            } 
        }
    };
    xhr.open("GET", url, true);
    xhr.send();
}