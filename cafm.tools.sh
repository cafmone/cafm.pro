#!/bin/bash
PROFILESDIR="/var/www/profiles"
DBHOST="localhost"
DBUSER="root"
DBPASS=""
EXCLUDES=""

if [ "$(whoami)" != "root" ]
	then
		echo "usage: sudo $0"
		exit 0
fi

for DIR in ${PROFILESDIR}/*; do
	if [[ -d ${DIR} ]]; then
	
		BASENAME=$(basename $DIR)
		if [[ "$EXCLUDES" == *"$BASENAME"* ]]; then
			continue
		fi

		SETTINGSFILE="${DIR}/settings.ini"
		if [[ -f ${SETTINGSFILE} ]]; then
			DB=""
			while IFS='= ' read var val; do
				if [[ $var == \[*] ]]; then
					section=$var
				elif [[ $val ]]; then
					if [[ "${section}${var}" == "[query]db" ]]; then
						DB=$(echo "$val" | sed -e "s/^\"//" -e "s/\"$//")
						break
					fi
				fi
			done < $SETTINGSFILE
			if [ ! -z ${DB} ]; then
				PASS=""
				if [ ! -z ${DBPASS} ]; then 
					PASS=" -p${DBPASS}"
				fi
				DUMP=$(mysqldump -h "$DBHOST" -u "${DBUSER}"${PASS} --allow-keywords --add-drop-table --complete-insert --quote-names "$DB" 2>/dev/null)
				if [[ $? -eq 0 ]]; then
					DATE=$(date +"%Y-%m-%d-%H-%M-%S")
					FILE="$DIR/webdav/backup/$DB.backup.$DATE.sql"
					echo -e "$DUMP" > $FILE
					gzip $FILE
					if [[ -f ${FILE} ]]; then
						rm $FILE
					fi
					chown www-data:www-data ${FILE}.gz
				fi
			fi
		fi

	fi
done
