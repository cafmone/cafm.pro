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
	fi
}
remote() {
	read -e -p "SSH Server: " -i "sftp.hidrive.strato.com:/users/$USER/" REMOTE
	if [ -z "${REMOTE}" ]; then
		remote
	fi
}
target() {
	read -e -p "Local Mount: " -i "/var/www/profiles/" TARGET
	if [ -z "${TARGET}" ]; then
		target
	fi
}
askinstall() {
	echo -n "Udate fstab (y/n)?"
	while read -r -n 1 -s answer; do
		if [[ $answer = [YyNn] ]]; then
			[[ $answer = [Yy] ]] && retval=0
			[[ $answer = [Nn] ]] && retval=1
			break
		fi
	done
	return $retval
}
askrestore() {
	echo -n "Restore fstab (y/n)?"
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
	if user; then
		if pass; then
			if remote; then
				if target; then
					if askinstall; then
						echo ''
						cat $FSTAB > $FSTAB.bak
						echo -e "$USER@$REMOTE $TARGET fuse.sshfs allow_other,uid=$(id -u www-data),gid=$(id -g www-data),_netdev,reconnect,ServerAliveInterval=15,ServerAliveCountMax=3,IdentityFile=$PASS 0 0" >> $FSTAB
						systemctl daemon-reload
						mount -a
						if askrestore; then
							echo ''
							cat $FSTAB.bak > $FSTAB
							rm $FSTAB.bak
							systemctl daemon-reload
							mount -a
						else
							echo ''
						fi
					fi
				fi
			fi
		fi
	fi
}

setup
