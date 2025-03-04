#!/bin/bash
SERVER=""
PORT="22"
USER=""
PASSWORD=""
SOURCE="/var/www/profiles/"
TARGET="/home/"
NOW=$(date +"%Y%m%d%H%M%S")
SKIP="lost+found"

# sshpass
if ! [ -x "$(command -v sshpass)" ]; then
	echo "Error: sshpass missing. Please run: sudo apt -y install sshpass"
	exit
fi
# rsync
if ! [ -x "$(command -v rsync)" ]; then
	echo "Error: rsync missing. Please run: sudo apt -y install rsync"
	exit
fi

LOGFILE="true"

### read commandline args
while [ $# -gt 0 ]
do
	if [ $1 = "--debug" ]; then
		LOGFILE="false"
	elif [ $1 = "--help" ]; then
		echo "help"
	fi
	shift
done

### run rsync
if [ -v TARGET ]; then
	if [ $LOGFILE = "true" ]; then
		sshpass -p "$PASSWORD" rsync --exclude $SKIP --rsh="ssh -p $PORT" --delete --stats -av $SOURCE $USER@$SERVER:$TARGET 3>&1 1> "rsync.log" 2>&1
	else
		sshpass -p "$PASSWORD" rsync --exclude $SKIP --rsh="ssh -p $PORT" --delete --stats --progress -av $SOURCE $USER@$SERVER:$TARGET
	fi
fi
