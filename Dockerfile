FROM php:cli-alpine

LABEL maintainer="Varun Sridharan <varunsridharan23@gmail.com>"

ADD https://raw.githubusercontent.com/mlocati/docker-php-extension-installer/master/install-php-extensions /usr/local/bin/

RUN chmod uga+x /usr/local/bin/install-php-extensions && sync && install-php-extensions intl mbstring

COPY entrypoint.sh /entrypoint.sh

COPY app /vs-utility-app/

RUN chmod 777 entrypoint.sh

RUN chmod -R 777 /vs-utility-app/

ENTRYPOINT ["/entrypoint.sh"]