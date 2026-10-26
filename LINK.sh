ln -s /media/jin/4abb279b-6d65-4663-97c2-26987f64673a/home/yuna/.mycache/thumbs /var/www/html/ai-web/thumbs
ln -s /media/jin/4abb279b-6d65-4663-97c2-26987f64673a/home/yuna/.mycache/zip /var/www/html/ai-web/zip

exit

mkdir -p /dev/shm/thumbs
mkdir -p /dev/shm/zip
mkdir -p /dev/shm/mount

unlink thumbs
unlink zip
unlink mount

ln -s /dev/shm/thumbs thumbs
ln -s /dev/shm/zip zip
ln -s /dev/shm/mount mount
