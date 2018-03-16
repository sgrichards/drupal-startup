```
 ____ _____  _    ____ _____ _   _ ____  
/ ___|_   _|/ \  |  _ \_   _| | | |  _ \ 
\___ \ | | / _ \ | |_) || | | | | | |_) |
 ___) || |/ ___ \|  _ < | | | |_| |  __/ 
|____/ |_/_/   \_\_| \_\|_|  \___/|_|    

########################################
```

[![Build Status](https://travis-ci.org/sgrichards/drupal-startup.svg?branch=develop)](https://travis-ci.org/sgrichards/drupal-startup)

# Drupal 8 / Lando flavoured project startup

Development Environment
----------------------

### Prerequisites

1. Install [Lando](https://docs.devwithlando.io/installation/installing.html).

### Setup

Run `lando start` from within the project directory

### Tooling

**Install/Reinstall** (install drupal site) - `lando install`

**Reset** (remove generated code) - `lando reset` 

**composer** - `lando composer {install}, {require} etc.`

**drush** - `lando drush {cr}, {site-install} etc.`

**phpcs** - `lando phpcs` - _see ./phpcs.xml.dist for scope_

**phpunit** - `lando phpunit` - _see ./phpunit.xml.dist for scope_

Further lando related commands see: https://docs.devwithlando.io/config/tooling.html