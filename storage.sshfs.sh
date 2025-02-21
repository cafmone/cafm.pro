#!/bin/bash
FSTAB="/etc/fstab"
CURRENT=$(whoami)
if [ "$CURRENT" != "root" ]
	then
		echo "usage: sudo $0"
		exit 0
fi
if ! [ -x "$(command -v sshfs)" ]; then
	echo -e "Please run: apt -y install sshfs"
	exit 0
fi
user() {
	read -e -p "SSH Username: " USER
	if [ -z "${USER}" ]; then
		user
	fi
}
pass() {
	read -e -p "Path to SSH Private Key: " -i "/root/.ssh/" PASS
	if [ -z "${PASS}" ]; then
		pass
	else
		if confirm "Edit ${PASS}?"; then
			nano ${PASS}
		fi
		if [ -f "${PASS}" ]; then
			chmod 0600 ${PASS}
		else
			echo "SSH Private Key ${PASS} not found!"
			pass
		fi
	fi
}
server() {
	read -e -p "Remote Server: " -i "sftp.hidrive.strato.com" SERVER
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
							echo -e "${USER}@${SERVER}:${FOLDER} ${TARGET} fuse.sshfs allow_other,uid=$(id -u www-data),gid=$(id -g www-data),_netdev,reconnect,ServerAliveInterval=15,ServerAliveCountMax=3,IdentityFile=$PASS 0 0" >> $FSTAB
							systemctl daemon-reload
							mount -a
							if confirm "Restore ${FSTAB}?"; then
								cat $FSTAB.bak > $FSTAB
								rm $FSTAB.bak
								## Umount?
								systemctl daemon-reload
								mount -a
							fi
						fi
					fi
				fi
			fi
		fi
	else
		if user; then
			if server; then
				if folder; then
					if target; then
					sshfs ${USER}@${SERVER}:${FOLDER} ${TARGET} -o allow_other,uid=$(id -u www-data),gid=$(id -g www-data),_netdev,reconnect,ServerAliveInterval=15,ServerAliveCountMax=3
					echo "To unmount run: fusermount3 -u ${TARGET}"
					echo ''
					fi
				fi
			fi
		fi
	fi
}

setup
