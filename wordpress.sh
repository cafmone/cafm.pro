#!/bin/bash
WORDPRESSURL="https://de.wordpress.org/latest-de_DE.zip"
WORDPRESSFILE="latest-de_DE.zip"

if ! [ -x "$(command -v unzip)" ]; then
	echo "apt -y install unzip"
	exit
fi

root() {
	read -e -p "Choose Wordpress DocumentRoot: " -i "/var/www" ROOT
	if [ -z "${ROOT}" ]; then
		root
	else
		if ! [ -d ${ROOT} ]; then
			echo "Directory ${ROOT} not found"
			root
		fi
	fi
}

start() {
	TMPDIR=$(mktemp -d)
	echo "Unziping to ${TMPDIR} .."
	unzip -q ${WORDPRESSFILE} -d ${TMPDIR}
	echo "Moving Files to ${ROOT} .."
	cp -r ${TMPDIR}/wordpress/. ${ROOT}
	chown -R www-data:www-data ${ROOT}
	find ${ROOT} -type d -print0 | xargs -0 chmod 777
	find ${ROOT} -type f -print0 | xargs -0 chmod 666
	echo "Removing ${TMPDIR} .."
	rm -r ${TMPDIR}
	echo "Done"
}

dbsetup() {
	DBPASS=$(openssl rand -base64 16)
	read -e -p "MySQL User: " -i "root" MYUSER
	read -e -p "MySQL Password: " -i "" MYPASS
	read -e -p "WordPress database and user: " -i "" WPDB
	export MYSQL_PWD=$MYPASS
	ERROR=$(mysql --user=$MYUSER -e "CREATE USER  IF NOT EXISTS '${WPDB}'@'localhost';" 2>&1)
	if [ $? == 1 ]; then
		echo "$ERROR"
		dbsetup
	fi
	ERROR=$(mysql --user=$MYUSER -e "ALTER USER '${WPDB}'@'localhost' IDENTIFIED BY '${DBPASS}';" 2>&1)
	if [ $? == 1 ]; then
		echo "$ERROR"
		dbsetup
	fi
	ERROR=$(mysql --user=$MYUSER -e "GRANT USAGE ON *.* TO '${WPDB}'@'localhost';" 2>&1)
	if [ $? == 1 ]; then
		echo "$ERROR"
		dbsetup
	fi
	ERROR=$(mysql --user=$MYUSER -e "CREATE DATABASE IF NOT EXISTS \`${WPDB}\` CHARACTER SET utf8 COLLATE utf8_general_ci;" 2>&1)
	if [ $? == 1 ]; then
		echo "$ERROR"
		dbsetup
	fi
	ERROR=$(mysql --user=$MYUSER -e "GRANT ALL PRIVILEGES ON \`${WPDB}\`.* TO '${WPDB}'@'localhost';" 2>&1)
	if [ $? == 1 ]; then
		echo "$ERROR"
		dbsetup
	fi
	ERROR=$(mysql --user=$MYUSER -e "FLUSH PRIVILEGES;" 2>&1)
	if [ $? == 1 ]; then
		echo "$ERROR"
		dbsetup
	fi
	echo "WordPress database: ${WPDB}"
	echo "WordPress user: ${WPDB}"
	echo "WordPress pass: ${DBPASS}"
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
	echo ''
	return $retval
}

setup() {
	if root; then
		if askinstall "Install Wordpress?" ; then
			start
			if askinstall "Install Database?" ; then
				dbsetup
			 else
				echo ''
			fi
		else
			echo ''
		fi
	fi
}

if ! [ -f ${WORDPRESSFILE} ]; then
	wget ${WORDPRESSURL}
fi
setup

