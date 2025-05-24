## Schematische Darstellung  
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
## WebDAV Server Setup  
a2enmod dav dav_fs  
nano /etc/apache2/sites-enabled/webdav.conf
```
Alias /webdav "/var/www/profiles/"
<Directory "/var/www/profiles/">
  DAV on
  AllowOverride All
  AuthType Basic
  AuthName DAV
  AuthUserFile /var/www/profiles/hostmaster/.htpasswd
  Require valid-user
</Directory>
```
/etc/init.d/apache2 restart  
## Samba Server Setup  
mkdir /home/public/  
chown nobody:nogroup /home/public/  
apt install wsdd samba samba-common smbclient  
systemctl enable smbd  
systemctl restart smbd  
smbpasswd -a hostmaster  
nano nano /etc/samba/smb.conf
```
[global]
allow insecure wide links = yes

[Public]
	path = /home/public/
	writable = yes
	guest ok = yes
	guest only = yes
	force create mode = 777
	force directory mode = 777
	follow symlinks = yes
	wide links = yes
```
systemctl restart smbd  
## Openstreetmap via Caching Proxy Server  
a2enmod cache cache_disk headers expires proxy proxy_http ssl  
mkdir /var/www/openstreetmap  
mkdir /var/www/openstreetmap/cache  
chmod --recursive 0777 /var/www/openstreetmap  
nano /etc/apache2/sites-enabled/openstreetmap.conf
```
Listen 8080
<VirtualHost *:8080>
	DocumentRoot /var/www/openstreemap
	<Directory "/var/www/opensteetmap">
		AllowOverride All
	</Directory>

	# enable caching for all requests; cache content on local disk
	CacheEnable disk /a
	CacheEnable disk /b
	CacheEnable disk /c
	CacheRoot /var/www/openstreemap/cache/

	# common caching directives
	CacheQuickHandler off
	CacheLock on
	CacheLockPath /tmp/mod_cache-lock
	CacheLockMaxAge 5
	CacheHeader On

	# cache control
	CacheIgnoreNoLastMod On
	CacheIgnoreCacheControl On
	CacheStoreNoStore On

	ProxyTimeout 600

	# reverse proxy requests to upstream server
	ProxyRequests On # used for forward proxying
	SSLProxyEngine On # required if proxying to https
	 
	ProxyPass /a https://a.tile.openstreetmap.de/
	ProxyPassReverse /a https://a.tile.openstreetmap.de/

	ProxyPass /b https://b.tile.openstreetmap.de/
	ProxyPassReverse /b https://b.tile.openstreetmap.de/
	 
	ProxyPass /c  https://c.tile.openstreetmap.de/
	ProxyPassReverse /c https://c.tile.openstreetmap.de/

</VirtualHost>
```
/etc/init.d/apache2 restart  
