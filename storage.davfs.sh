#!/bin/bash
FSTAB="/etc/fstab"
DAVFS="/etc/davfs2/secrets"
CURRENT=$(whoami)
if [ "$CURRENT" != "root" ]
	then
		echo "usage: sudo $0"
		exit 0
fi
if ! [ -x "$(command -v mount.davfs)" ]; then
	echo -e "Please run: apt -y install davfs2"
	exit 0
fi
user() {
	read -e -p "Webdav User: " USER
	if [ -z "${USER}" ]; then
		user
	fi
}
pass() {
	read -e -p "Webdav Password: " -i "" PASS
	if [ -z "${PASS}" ]; then
		pass
	fi
}
server() {
	read -e -p "Webdav Server: " -i "https://webdav.hidrive.strato.com" SERVER
	if [ -z "${SERVER}" ]; then
		server
	fi
}
folder() {
	read -e -p "Remote Folder: " -i "/users/$USER/" FOLDER
	if [ -z "${FOLDER}" ]; then
		folder
	fi
}
target() {
	read -e -p "Local Mount: " -i "/var/www/profiles/" TARGET
	if [ -z "${TARGET}" ]; then
		target
	fi
}

confirm() {
	echo -n "${1} (y/n)"
	while read -r -n 1 -s aw; do
		if [[ $aw = [YyNn] ]]; then
			[[ $aw = [Yy] ]] && ret=0
			[[ $aw = [Nn] ]] && ret=1
			break
		fi
	done
	echo ''
	return $ret
}

setup() {
	if confirm "Update ${FSTAB}?"; then
		if user; then
			if pass; then
				if server; then
					if folder; then
						if target; then
							echo "Updating ${FSTAB} ..."
							cat $FSTAB > $FSTAB.bak
							echo -e "${TARGET} ${USER} \"${PASS}\"" >> $DAVFS
							echo -e "${SERVER}${FOLDER} $TARGET davfs rw,uid=$(id -u www-data),gid=$(id -g www-data),_netdev 0 0" >> $FSTAB
							systemctl daemon-reload
							mount -a
							if confirm "Restore ${FSTAB}?"; then
								echo ''
								cat $FSTAB.bak > $FSTAB
								rm $FSTAB.bak
								systemctl daemon-reload
								mount -a
							fi
						fi
					fi
				fi
			fi
		fi
	else
		if server; then
			if folder; then
				if target; then
					mount.davfs ${SERVER}${FOLDER} ${TARGET} -o rw,uid=$(id -u www-data),gid=$(id -g www-data),_netdev
					echo "To unmount run: fusermount -u ${TARGET}"
					echo ''
				fi
			fi
		fi
	fi
}

setup
