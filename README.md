![Schematische Darstellung](https://github.com/cafmone/cafm.pro/blob/main/Middleware.png?raw=true)  
![CAFM.ONE Checkliste](https://github.com/cafmone/cafm.pro/blob/main/Checkliste.png?raw=true)
## Basic Server Setup  
sudo bash  
cd /root/  
timedatectl set-timezone Europe/Berlin  
apt -y install wget nano  
adduser [new user here]  
usermod -aG sudo [new user here]  
nano /etc/ssh/sshd_config  
```
PasswordAuthentication yes  
PermitRootLogin no  
```
sudo service ssh restart  
## Advanced Server Setup  
wget https://raw.githubusercontent.com/cafmone/cafm.pro/refs/heads/main/setup.sh  
chmod +x setup.sh  
./setup.sh  
nano /etc/php/[php version]/apache2/php.ini  
```
memory_limit = 256M
display_errors = On
post_max_size = 40M
file_uploads = On
upload_max_filesize = 20M
```
/etc/init.d/apache2 restart
## Webserver Setup  
wget https://raw.githubusercontent.com/cafmone/cafm.pro/refs/heads/main/apache.sh  
chmod +x apache.sh  
./apache.sh  
## SSH Storage Setup  
wget https://raw.githubusercontent.com/cafmone/cafm.pro/refs/heads/main/storage.sshfs.sh  
chmod +x storage.sshfs.sh  
./storage.sshfs.sh  
## WebDAV Storage Setup  
wget https://raw.githubusercontent.com/cafmone/cafm.pro/refs/heads/main/storage.davfs.sh  
chmod +x storage.davfs.sh  
./storage.davfs.sh  
## Update Check  
wget https://raw.githubusercontent.com/cafmone/cafm.pro/refs/heads/main/apt.sh  
chmod +x apt.sh  
./apt.sh  
## Rsync (Backup)  
wget https://raw.githubusercontent.com/cafmone/cafm.pro/refs/heads/main/rsync.sh  
chmod +x rsync.sh  
nano rsync.sh  
```
SERVER=""
PORT="22"
USER=""
PASSWORD=""
SOURCE="/var/www/profiles/"
TARGET="/home/"
SKIP="lost+found"
```
./rsync.sh  
## CRON Jobs  
crontab -e
```
0 2 * * 7 /root/rsync.sh
0 4 * * 7 /root/apt.sh
```

