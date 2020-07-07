FROM php:cli-alpine

LABEL maintainer="Varun Sridharan <varunsridharan23@gmail.com>"

RUN docker-php-ext-install mbstring

RUN docker-php-ext-install intl

COPY entrypoint.sh /entrypoint.sh

COPY app /vs-utility-app/

RUN chmod 777 entrypoint.sh

RUN chmod -R 777 /vs-utility-app/

ENTRYPOINT ["/entrypoint.sh"]