FROM node:11

LABEL mantainer "hacklab/ <contato@hacklab.com.br>"

COPY compose/local/watcher/entrypoint.sh /entrypoint.sh

ENTRYPOINT /entrypoint.sh

RUN chmod +x /entrypoint.sh

RUN mkdir /app

WORKDIR /app