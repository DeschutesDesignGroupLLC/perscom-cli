FROM php:8.1-cli

RUN apt-get update \
    && apt-get install -y wget \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /perscom-cli

RUN wget https://github.com/DeschutesDesignGroupLLC/perscom-cli/releases/latest/download/perscom

COPY perscom /usr/local/bin/perscom

ENTRYPOINT ["php", "perscom"]
