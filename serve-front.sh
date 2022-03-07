#!/bin/bash
yum install httpd -y
service httpd start
chkconfig httpd on
cd /var/www/html 

cp /home/ec2-user/code/urna-eletronica/front/ .

