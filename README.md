sudo bash  
apt -y install nano  
adduser [new user here]  
usermod -aG sudo [new user here]  
nano /etc/ssh/sshd_config >> PasswordAuthentication yes  
nano /etc/ssh/sshd_config >> PermitRootLogin no  
sudo service ssh restart  
touch setup.sh  
chmod +x setup.sh  
nano setup.sh  
