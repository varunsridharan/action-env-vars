FROM alpine:latest

RUN apk add --no-cache bash

LABEL maintainer="Varun Sridharan <varunsridharan23@gmail.com>"

COPY entrypoint.sh /entrypoint.sh

COPY scripts /vs-action-utility/

RUN chmod 777 entrypoint.sh

RUN chmod -R 777 /vs-action-utility/

ENTRYPOINT ["/entrypoint.sh"]