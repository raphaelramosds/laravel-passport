FROM node:18-alpine

ARG UID=1000
ARG GID=1000
ARG USER=node

USER root

RUN apk update && apk add --no-cache shadow
RUN groupmod -g ${GID} ${USER} && \
    usermod -u ${UID} -g ${GID} ${USER}

WORKDIR /var/www/html

COPY package*.json ./
COPY . .

RUN chmod +x /var/www/html/scripts/init.sh
RUN chown -R ${USER}:${USER} /var/www/html

USER ${USER}

ENV PORT=3000
ENV HOSTNAME="0.0.0.0"

ENTRYPOINT ["sh", "/var/www/html/scripts/init.sh"]
