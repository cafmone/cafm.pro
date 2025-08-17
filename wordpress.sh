#!/bin/bash
PWD=$(pwd)
DBPASS=$(mkkey 16)
WPTHEME="${PWD}/wordpress/themes/cafm.pro"
WPPREFIX='wp_'
WORDPRESSURL="https://de.wordpress.org/latest-de_DE.zip"
WORDPRESSFILE="latest-de_DE.zip"

mkkey(){
if [ -z "$1" ]
	then
		length=16
	else
		length=$1
	fi
	key=$(tr -dc "A-Za-z0-9()*+,-.:;<=>?@[]^_{|}" </dev/urandom | head -c ${length}; echo)
	echo ${key}
}

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
	chown -R www-data:www-data ${TMPDIR}
	find ${TMPDIR} -type d -print0 | xargs -0 chmod 777
	find ${TMPDIR} -type f -print0 | xargs -0 chmod 666
	echo "Moving Files to ${ROOT} .."
	cp -rp ${TMPDIR}/wordpress/. ${ROOT}
	echo "Removing ${TMPDIR} .."
	rm -r ${TMPDIR}
	if [ -d "${WPTHEME}" ]
	then
		USER=$(ls -ld ${WPTHEME} | awk '{print $3}')
		if [ ! ${USER} = "www-data" ]
		then
			chown -R www-data:www-data ${WPTHEME}
			find ${WPTHEME} -type d -print0 | xargs -0 chmod 777
			find ${WPTHEME} -type f -print0 | xargs -0 chmod 666
		fi
		ln -s ${WPTHEME} ${ROOT}/wp-content/themes/
	fi
	echo "Done"
}

dbsetup() {
	DBPASS=$(mkkey 24)
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
	echo ""
	echo "Configuring WordPress .."

	WPPREFIX='wp_'
	WPCONFIG="${ROOT}/wp-config.php"
	cp -p ${ROOT}/wp-config-sample.php ${WPCONFIG}

	sed -i -e "s/database_name_here/${WPDB}/g" ${WPCONFIG}
	sed -i -e "s/username_here/${WPDB}/g" ${WPCONFIG}
	sed -i -e "s/password_here/${DBPASS}/g" ${WPCONFIG}
	sed -i -e "s/$table_prefix = 'wp_'/$table_prefix = '${WPPREFIX}'/g" ${WPCONFIG}

	sed -i -e "s/^\(define.*'AUTH_KEY'.*\)put your unique phrase here\(.*\)$/\1$(mkkey 64)\2/" ${WPCONFIG}
	sed -i -e "s/^\(define.*'SECURE_AUTH_KEY'.*\)put your unique phrase here\(.*\)$/\1$(mkkey 64)\2/" ${WPCONFIG}
	sed -i -e "s/^\(define.*'LOGGED_IN_KEY'.*\)put your unique phrase here\(.*\)$/\1$(mkkey 64)\2/" ${WPCONFIG}
	sed -i -e "s/^\(define.*'NONCE_KEY'.*\)put your unique phrase here\(.*\)$/\1$(mkkey 64)\2/" ${WPCONFIG}
	sed -i -e "s/^\(define.*'AUTH_SALT'.*\)put your unique phrase here\(.*\)$/\1$(mkkey 64)\2/" ${WPCONFIG}
	sed -i -e "s/^\(define.*'SECURE_AUTH_SALT'.*\)put your unique phrase here\(.*\)$/\1$(mkkey 64)\2/" ${WPCONFIG}
	sed -i -e "s/^\(define.*'LOGGED_IN_SALT'.*\)put your unique phrase here\(.*\)$/\1$(mkkey 64)\2/" ${WPCONFIG}
	sed -i -e "s/^\(define.*'NONCE_SALT'.*\)put your unique phrase here\(.*\)$/\1$(mkkey 64)\2/" ${WPCONFIG}
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

### TODO install / backup /restore
#DBTODUMP=mydb
#SQL="SET group_concat_max_len = 10240;"
#SQL="${SQL} SELECT GROUP_CONCAT(table_name separator ' ')"
#SQL="${SQL} FROM information_schema.tables WHERE table_schema='${DBTODUMP}'"
#SQL="${SQL} AND table_name NOT IN ('t1','t2','t3')"
#TBLIST=`mysql -u... -p... -AN -e"${SQL}"`
#mysqldump -u... -p... ${DBTODUMP} ${TBLIST} > mydb_tables.sql



if ! [ -f ${WORDPRESSFILE} ]; then
	wget ${WORDPRESSURL}
fi
setup

