FROM php:cli-alpine

LABEL maintainer="Varun Sridharan <varunsridharan23@gmail.com>"

COPY entrypoint.sh /entrypoint.sh

COPY scripts /vs-action-utility/

COPY app /vs-utility-app/

RUN chmod 777 entrypoint.sh

RUN chmod -R 777 /vs-action-utility/

RUN chmod -R 777 /vs-utility-app/

ENTRYPOINT ["/entrypoint.sh"]