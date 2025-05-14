# ai-web
ai server kumpulan script penting yang sering
digunakan seperti alat hacking, editor text dan banyak lagi

<b> Update aiv1.4</b>
penambahan rincian isi path pada tools filemanager
dan save scrolling cache pada editor text tradisional
<br><br>

<b> Update aiv1.9</b>
penambahan galery untuk membuka kumpulan gambar musik dan video
fitur ini bisa dibuka dengan klik filemanager other lalu pilih
galery image atau yang lain.
<br><br>

<b> Update aiv1.10</b>
Penambahan gallery document untuk membuka file pdf, fitur ini
bisa dibuka di filemanager sama seperti gallery yang lain
<br><br>

<b> Update aiv2.4</b>
versi stabil, file tar untuk mendapatkan release
<br><br>

<b> Update aiv2.6</b>
versi stabil, penambahan fungsi thread ini berguna untuk<br>
membuka gallery lebih dari satu misal music dan foto<br>
penggunaanya cukup mudah:<br>
1). buka filemanager<br>
2). pilih other select<br>
3). pilih create gallery thread<br>
4). tekan go untuk menuju ke thread baru<br>
NOTE: versi ini belum bisa edit text menggunakan warna
<br><br><br>


![](output.gif)

# Config
```
$ nano /etc/php/7.4/apache2/php.ini
;;;;;;;;;;;;;;;;
; File Uploads ;
;;;;;;;;;;;;;;;;

; Whether to allow HTTP file uploads.
; http://php.net/file-uploads
file_uploads = On

; Temporary directory for HTTP uploaded files (will use system default if not
; specified).
; http://php.net/upload-tmp-dir
upload_tmp_dir = "/media/jin/4abb279b-6d65-4663-97c2-26987f64673a/home/yuna/.myruntime/tm>

; Maximum allowed size for uploaded files.
; http://php.net/upload-max-filesize
upload_max_filesize = 20G
post_max_size = 20G

; Maximum number of files that can be uploaded via a single request
max_file_uploads = 20

```

# Requitments
1). php 7 keatas <br>
2). ffmpeg <br>
3). pdftoppm <br>

# Install 
1). copy folder ai-web ke server <br>
2). tes menggunakan localhost/ai-web/ai.php <br>
3). finish <br>

