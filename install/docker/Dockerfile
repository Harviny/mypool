FROM phusion/baseimage:0.9.18

ADD composer /usr/local/bin/composer

ADD init.sh /tmp/init.sh
RUN /bin/bash /tmp/init.sh

# nginx conf
ADD nginx.run.sh /etc/service/nginx/run
ADD nginx.conf /etc/nginx/nginx.conf
ADD nginx.site.conf /etc/nginx/sites-enabled/default

# php conf
ADD php7.run.sh /etc/service/phpfpm/run
ADD php7-production.ini /etc/service/phpfpm/php-production.ini
ADD php7-dev.ini /etc/service/phpfpm/php-dev.ini
ADD phpfpm-production.conf /etc/service/phpfpm/phpfpm-production.conf
ADD phpfpm-dev.conf /etc/service/phpfpm/phpfpm-dev.conf

# supervisord
ADD supervisord.run.sh /etc/service/supervisord/run

# beanstalkd
ADD beanstalkd.run.sh /etc/service/beanstalkd/run

# optimize
ADD optimize.sh /etc/service/phpfpm/optimize.sh

# crontab
ADD cron /etc/cron.d/chain
RUN chmod 700 /etc/cron.d/chain

# supervisor
ADD supervisord.queue.default.conf /etc/supervisor/conf.d/
ADD supervisord.pool_stats_merge.conf /etc/supervisor/conf.d/
ADD supervisord.pool_share_history_merge.conf /etc/supervisor/conf.d/
ADD supervisord.pool_blocks_merge_btc.conf /etc/supervisor/conf.d/
ADD supervisord.pool_blocks_merge_nmc.conf /etc/supervisor/conf.d/
ADD supervisord.newblock_notification_btc.conf /etc/supervisor/conf.d/
ADD supervisord.newblock_notification_nmc.conf /etc/supervisor/conf.d/

VOLUME ["/work/site"]
CMD ["/sbin/my_init"]
EXPOSE 80
