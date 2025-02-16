#!/bin/bash

TO=""
FROM=""
SMTP_SERVER=""
SMTP_PORT="465"
SMTP_USER=""
SMTP_PASSWORD=""

CURRENT=$(whoami)
if [ "$CURRENT" != "root" ]
	then
		echo "usage: sudo $0"
		exit
fi

## change to root dir
cd /root/

## Nano
if ! [ -x "$(command -v nano)" ]; then
	apt -y install nano
else
	echo -e "Nano already installed - nothing to do. $(which nano)"
fi

## Midnightcommander
if ! [ -x "$(command -v mc)" ]; then
	apt -y install mc
	echo -e "\nalias mc='. /usr/lib/mc/mc-wrapper.sh'" >> ~/.bashrc
	echo "1" | select-editor
else
	echo -e "Midnightcommander already installed - nothing to do. $(which mc)"
fi

## Apache
if ! [ -x "$(command -v apache2)" ]; then
	apt -y install apache2
else
	echo -e "Apache2 already installed - nothing to do. $(which apache2)"
fi

## Subversion (svn)
if ! [ -x "$(command -v svn)" ]; then
	apt -y install subversion
else
	echo -e "Subversion already installed - nothing to do. $(which svn)"
fi

## Git
if ! [ -x "$(command -v git)" ]; then
	apt -y install git
else
	echo -e "Git already installed - nothing to do. $(which git)"
fi

## Mysql
if ! [ -x "$(command -v mysql)" ]; then
	apt -y -q install mysql-server
	mysql -u root -e "CREATE USER 'hostmaster'@'localhost' IDENTIFIED BY 'hostmaster'; FLUSH PRIVILEGES;"
	mysql -u root -e "GRANT GRANT OPTION ON * . * TO 'hostmaster'@'localhost'; FLUSH PRIVILEGES;"
	mysql -u root -e "GRANT ALL PRIVILEGES ON * . * TO 'hostmaster'@'localhost'; FLUSH PRIVILEGES;"
else
	echo -e "Mysql already installed - nothing to do. $(which mysql)"
fi

## PHP
if ! [ -x "$(command -v php)" ]; then
	apt -y install php libapache2-mod-php php-mysql php-mbstring php-zip php-gd php-json php-curl
else
	echo -e "PHP already installed - nothing to do. $(which php)"
fi
## Certbot
if ! [ -x "$(command -v certbot)" ]; then
	apt -y install certbot python3-certbot-apache
else
	echo -e "Certbot already installed - nothing to do. $(which certbot)"
fi

## PHPMyadmin
if [ ! -f /usr/share/phpmyadmin/config.inc.php ]; then
apt -y install software-properties-common
add-apt-repository ppa:ondrej/apache2
apt -y install phpmyadmin

cat <<EOT > /usr/share/phpmyadmin/config.inc.php
<?php
\$cfg['blowfish_secret'] = 'xc32z45bw6rh2woqthpqlm9fu35asqj';
\$i = 0;
\$i++;
\$cfg['Servers'][\$i]['auth_type'] = 'cookie';
\$cfg['Servers'][\$i]['host'] = 'localhost';
\$cfg['Servers'][\$i]['compress'] = false;
\$cfg['Servers'][\$i]['AllowNoPassword'] = false;
\$cfg['Servers'][\$i]['user'] = 'hostmaster';
?>
EOT
else
	echo -e "PHPMyadmin already installed - nothing to do."
fi

## Mail
if [[ -z "${TO}" || -z "${FROM}" || -z "${SMTP_PORT}" || -z "${SMTP_SERVER}" || -z "${SMTP_USER}" || -z "${SMTP_PASSWORD}" ]]; then
	echo 'Skipping msmtp setup - nothing to do'
	exit 0
fi

if ! [ -x "$(command -v msmtp)" ]; then
apt -y install msmtp msmtp-mta

cat <<EOT > /etc/msmtprc
defaults
port $SMTP_PORT
tls on
tls_starttls off
aliases /etc/aliases
account provider
host $SMTP_SERVER
from $FROM
auth on
user $SMTP_USER
password $SMTP_PASSWORD
account default : provider
EOT

cat <<EOT > /etc/aliases
default: $TO
EOT

## Security
## Send mail on ssh login
cat <<EOT > /etc/ssh/sshrc
#!/bin/bash
HOST=\$(ip addr show | grep -Eo 'inet (addr:)?([0-9]*\.){3}[0-9]*'| grep -Eo '([0-9]*\.){3}[0-9]*' | grep -v '127.0.0.1')
IP=\$( echo "\$SSH_CONNECTION" | cut -d " " -f 1 )
echo "Subject: ssh \$USER@\$HOST from \$IP\n\n" | msmtp default &
EOT

else
	echo -e "Msmtp already installed - nothing to do. $(which msmtp)"
fi
