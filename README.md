```
 ____ _____  _    ____ _____ _   _ ____  
/ ___|_   _|/ \  |  _ \_   _| | | |  _ \ 
\___ \ | | / _ \ | |_) || | | | | | |_) |
 ___) || |/ ___ \|  _ < | | | |_| |  __/ 
|____/ |_/_/   \_\_| \_\|_|  \___/|_|    

########################################
```

# Drupal 8 and Docker flavoured project startup

This is a [Composer](https://getcomposer.org/) based Drupal 8 startup project that utilises docker.

Stack:

- PHP 7.1 (w/ Xdebug)
- Apache
- Solr 4
- MariaDB
- Redis

## Requirements

- docker-for-mac
- docker-compose

## Build me...

```
docker-compose up -d
```

## Access points

- [Web](http://localhost:8080/)
- [Solr](http://localhost:8983/solr)
- [Redis Commander](http://localhost:8081)
