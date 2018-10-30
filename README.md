```
 ____ _____  _    ____ _____ _   _ ____  
/ ___|_   _|/ \  |  _ \_   _| | | |  _ \ 
\___ \ | | / _ \ | |_) || | | | | | |_) |
 ___) || |/ ___ \|  _ < | | | |_| |  __/ 
|____/ |_/_/   \_\_| \_\|_|  \___/|_|    

########################################
```

[ ![Codeship Status for sgrichards/drupal-startup](https://app.codeship.com/projects/c1e6f9f0-bdb5-0136-09c5-5eb317ea9055/status?branch=develop)](https://app.codeship.com/projects/312923)

# Drupal 8 / Lando flavoured project startup

Development Environment
----------------------

### Prerequisites

1. Install Docker-for-mac
2. Install [Lando](https://docs.devwithlando.io/installation/installing.html).

### Setup

Run `lando start` from within the project directory.

### Tooling

| Command                                       | Description                                             |
|---                                            |---                                                      |
|`lando install`                                |Install Drupal site                                      |
|`lando reset`                                  |Reset codebase removing generated code                   |
|`lando composer {install}, {require} etc.`     |Run composer commands in the appserver container         |
|`lando drush {cr}, {site-install} etc.`        |Run drush commands in the appserver container            |
|`lando phpcs`                                  |Run code style analysis _see ./phpcs.xml.dist for scope_ |
|`lando phpunit`                                |Run phpunit tests _see ./phpunit.xml.dist for scope_     |
|`lando behat`                                  |Run behat test suite                                     |
|`lando test`                                   |Run all tests and code evaluation                        |

For further lando related commands see: https://docs.devwithlando.io/config/tooling.html
