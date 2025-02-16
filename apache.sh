#!/bin/bash
SITESDIR="/etc/apache2/sites-enabled/"
CURRENT=$(whoami)
if [ "$CURRENT" != "root" ]
	then
		echo "usage: sudo $0"
		exit
fi
server() {
	read -e -p "ServerName: " -i "" SERVER
	if [ -z "${SERVER}" ]; then
		server
	fi
}
admin() {
	read -e -p "ServerAdmin: " -i "" ADMIN
	if [ -z "${ADMIN}" ]; then
		admin
	fi
}
root() {
	read -e -p "DocumentRoot: " -i "/var/www/html" ROOT
	if [ -z "${ROOT}" ]; then
		root
	fi
}
start() {
[ -d /var/www/logs ] || mkdir -m 777 /var/www/logs
[ -d /var/www/logs/${SERVER} ] || mkdir -m 777 /var/www/logs/${SERVER}
cat <<EOT > ${SITESDIR}${SERVER}.conf
<VirtualHost *:80>
	ServerName "${SERVER}"
	ServerAdmin ${ADMIN}
	DocumentRoot ${ROOT}
	<Directory "${ROOT}">
		AllowOverride All
	</Directory>
	LogFormat "%h %t \"%r\" %>s %b" custom
	ErrorLog "|/usr/bin/rotatelogs /var/www/logs/${SERVER}/error-%Y-%m-%d.log 86400"
	CustomLog "|/usr/bin/rotatelogs /var/www/logs/${SERVER}/access-%Y-%m-%d.log 86400" custom
</VirtualHost>
EOT
echo ''
if askinstall "Make site default" ; then
cat <<EOT > ${SITESDIR}000-default.conf 
<VirtualHost *:80>
	Redirect permanent / http://${SERVER}
</VirtualHost>
EOT
fi
if askinstall "Run certbot" ; then
	certbot
fi
/etc/init.d/apache2 restart
echo ''
}
askinstall() {
	echo -n "$1 (y/n)?"
	while read -r -n 1 -s answer; do
		if [[ $answer = [YyNn] ]]; then
			[[ $answer = [Yy] ]] && retval=0
			[[ $answer = [Nn] ]] && retval=1
			break
		fi
	done
	return $retval
}
setup() {
	if server; then
		if admin; then
			if root; then
				if askinstall "Udate apache2" ; then
					start
				else
					echo ''
				fi
			fi
		fi
	fi
}
setup
