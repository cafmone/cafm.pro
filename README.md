sudo bash  
adduser [new user here]  
usermod -aG sudo [new user here]  
/etc/ssh/sshd_config PasswordAuthentication yes  
/etc/ssh/sshd_config PermitRootLogin no  
sudo service ssh restart  
apt -y install nano  
touch setup.sh  
chmod +x setup.sh  
nano setup.sh  
