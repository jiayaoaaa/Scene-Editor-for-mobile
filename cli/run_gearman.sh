#!/bin/sh
PHPCMD=`which php`
if [ ! -x $PHPCMD ]; then
		echo "PHP not found	or access denied"
		exit 1;
fi

HX_CMD=$1

PREFIX=/usr
SPROOT=/sproot
CLI_ROOT=${SPROOT}/cli/gearman
PATH_PID=/var/run
workers_user="worker_participants"


if [ "$HX_CMD" != "start" -a "$HX_CMD" != "stop"  -a "$HX_CMD" != "status" ]; then
	   echo	"support like:start/stop/status trade";
	   exit	1;
fi

start()
{	
	worker_type=$1;
	eval workers="$"workers_${worker_type}
	if [ -f	"$PATH_PID/${worker_type}.pid" ];then
		echo "workers ${worker_type} has runing"
		cat	"${PATH_PID}/${worker_type}.pid"
		exit 1;
	else
		echo "begin	start trade	workers";
		for worker in $workers
		do
			echo ${CLI_ROOT}/${worker}.php
			nohup ${PHPCMD} ${CLI_ROOT}/${worker}.php > /dev/null 2>&1 &
			echo $! >> "$PATH_PID/${worker_type}.pid"
		done
	fi
}

status()
{	
	worker_type=$1;
	 if	[ -f "$PATH_PID/${worker_type}.pid" ];then
		echo "workers ${worker_type} is runing"
		cat	"${PATH_PID}/${worker_type}.pid"
	 else
		echo "workers ${worker_type} not runing"
	 fi
	 exit;
}

stop()
{
	worker_type=$1;

	if [ -f	"$PATH_PID/${worker_type}.pid" ];then
		echo "begin	stop ${worker_type} workers"
		for	HX_PID in `cat "$PATH_PID/${worker_type}.pid"` 
		do
			echo kill -9 $HX_PID
			kill -9 $HX_PID
		done
		rm	-f "$PATH_PID/${worker_type}.pid"
	else
		echo "sorry,workers	not	running!";
	fi
	exit 1;
}

case "$2" in
	user)
	${HX_CMD} user
	;;
	*)
	echo "no such node"
esac