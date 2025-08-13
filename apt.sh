#!/bin/bash
if [ -x "$(command -v msmtp)" ]; then
	apt update 3>&1 1> "apt.log" 2>&1
	apt upgrade -y 3>&1 1>> "apt.log" 2>&1
	HOST=$(ip addr show | grep -Eo 'inet (addr:)?([0-9]*\.){3}[0-9]*'| grep -Eo '([0-9]*\.){3}[0-9]*' | grep -v '127.0.0.1')
	LOG=$(cat apt.log)
	echo -e "Subject: apt $HOST\n\n$LOG\n\n" | msmtp default
fi
