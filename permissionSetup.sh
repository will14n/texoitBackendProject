sudo chgrp -R www-data bootstrap/ storage/ storage/logs/
sudo chmod -R g+w bootstrap/ storage/ storage/logs/
cd bootstrap/
sudo find -type d -exec chmod g+s {} +
cd ../storage/
sudo find -type d -exec chmod g+s {} +
cd logs/
sudo find -type d -exec chmod g+s {} +
