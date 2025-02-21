## Basic Server Setup  
sudo bash  
cd /root/  
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
nano setup.sh  
```
TO=""
FROM=""
SMTP_SERVER=""
SMTP_PORT="465"
SMTP_USER=""
SMTP_PASSWORD=""
```
./setup.sh  
## Webserver Setup  
wget https://raw.githubusercontent.com/cafmone/cafm.pro/refs/heads/main/apache.sh  
chmod +x apache.sh  
./apache.sh  
## SSH Storage Setup  
wget https://raw.githubusercontent.com/cafmone/cafm.pro/refs/heads/main/storage.sshfs.sh  
chmod +x storage.sshfs.sh  
./storage.sshfs.sh  
## Webdav Storage Setup  
wget https://raw.githubusercontent.com/cafmone/cafm.pro/refs/heads/main/storage.davfs.sh  
chmod +x storage.davfs.sh  
./storage.davfs.sh  

