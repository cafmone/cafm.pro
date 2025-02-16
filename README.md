sudo bash  
apt -y install wget nano  
adduser [new user here]  
usermod -aG sudo [new user here]  
nano /etc/ssh/sshd_config  
```
PasswordAuthentication yes  
PermitRootLogin no  
```
sudo service ssh restart  
wget https://raw.githubusercontent.com/cafmone/cafm.pro/refs/heads/main/setup.sh  
chmod +x setup.sh  
nano setup.sh  
