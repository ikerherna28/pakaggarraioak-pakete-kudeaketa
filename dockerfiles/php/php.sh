#! /bin/sh
line=$(head -n 1 /etc/hosts)
line2=$(echo $line | awk '{print $2}')
echo "$line $line2.localdomain" >> /etc/hosts
echo "$(hostname -i)\t$(hostname) $(hostname).localhost" >> /etc/hosts
echo "O HostsFile=/etc/hosts" >> /etc/mail/sendmail.cf
/etc/init.d/sendmail start
php-fpm