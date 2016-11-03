#!/bin/bash

set -ex

echo 'export LC_ALL=en_US.UTF-8
export LANG=en_US.UTF-8
export LANGUAGE=en_US.UTF-8' >> ~/.bashrc

# update apt.list
echo 'deb http://cn.archive.ubuntu.com/ubuntu/ trusty main restricted universe multiverse
deb http://cn.archive.ubuntu.com/ubuntu/ trusty-security main restricted universe multiverse
deb http://cn.archive.ubuntu.com/ubuntu/ trusty-updates main restricted universe multiverse

# curl new version
deb http://ppa.launchpad.net/costamagnagianfranco/ettercap-stable-backports/ubuntu trusty main
deb http://ppa.launchpad.net/ondrej/php/ubuntu trusty main
' > /etc/apt/sources.list
rm -rf /etc/apt/sources.list.d/*

apt-get update

# install deps
while ! apt-get install -y --force-yes git nginx curl supervisor beanstalkd \
    php7.0  php7.0-dev  php7.0-gd  php7.0-gmp  php7.0-curl php7.0-mysql php7.0-fpm php7.0-opcache \
    php7.0-mbstring php7.0-bcmath php7.0-mcrypt php7.0-cli php7.0-json php7.0-xml php7.0-zip ; do

    /bin/true
done