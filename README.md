```
 ____ _____  _    ____ _____ _   _ ____  
/ ___|_   _|/ \  |  _ \_   _| | | |  _ \ 
\___ \ | | / _ \ | |_) || | | | | | |_) |
 ___) || |/ ___ \|  _ < | | | |_| |  __/ 
|____/ |_/_/   \_\_| \_\|_|  \___/|_|    

########################################
```

[ ![Codeship Status for sgrichards/drupal-startup](https://app.codeship.com/projects/c1e6f9f0-bdb5-0136-09c5-5eb317ea9055/status?branch=develop)](https://app.codeship.com/projects/312923)

# Drupal 8 / Docker flavoured project template

This project should be used as a skeleton starting point for new Drupal 8 based projects. As such some assumptions
and opinionated decisions are included to bootstrap a project with everything you might need to get started!

...delete as appropriate!

## Start me up

Start-up your `newproject` in the current directory using composer:

`composer create-project --no-install -s dev sgrichards/drupal-startup newproject`

## Project structure

The tree below outlines the project structure and purpose.

```bash
newproject
|
├── conf # container related config (eg. solr)
├── config
|   └── sync # Drupal config files
|
├── doc # Project related documentation 
|
├── docroot
|   ├── modules
|   |   └── custom # Custom modules
|   ├── profiles
|   |   └── custom # Custom install profiles
|   ├── sites
|   |   └── default # Default site settings
|   └── themes 
|       └── custom # Custom themes
|
├── scripts
|   ├── deployment # Shell scripts for deployment
|   ├── development # Shell scripts for local dev
|   └── common.inc.sh # Shared scripts for all environments
|
└── test
    └── behat # Behat tests
``` 


## Development Environment

### Prerequisites

1. Install Docker-for-mac
2. Install [Lando](https://docs.devwithlando.io/installation/installing.html).

### Setup

Run `lando start` from within the project directory.

### Tooling

| Command                                       | Description                                             |
|---                                            |---                                                      |
|`lando install`                                |Install Drupal site                                      |
|`lando reset`                                  |Reset codebase removing generated code and lock file     |
|`lando refresh`                                |Refresh your project (clear cache, import config etc...) |
|`lando composer {install}, {require} etc.`     |Run composer commands in the appserver container         |
|`lando drush {cr}, {site-install} etc.`        |Run drush commands in the appserver container            |
|`lando phpcs`                                  |Run code style analysis _see ./phpcs.xml.dist for scope_ |
|`lando phpunit`                                |Run phpunit tests _see ./phpunit.xml.dist for scope_     |
|`lando behat`                                  |Run behat test suite                                     |
|`lando test`                                   |Run all tests and code evaluation                        |

For further lando related commands see: https://docs.devwithlando.io/config/tooling.html
