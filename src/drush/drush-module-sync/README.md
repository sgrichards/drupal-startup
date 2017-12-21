# Drush Module Sync

[![Build Status](https://travis-ci.org/droath/drush-module-sync.svg?branch=master)](https://travis-ci.org/droath/drush-module-sync)

Sync Drupal modules based on a defined scope. Scopes are arbitrary but in most cases they're setup to match different environments, which are usually invoked based on different build processes that need to take place. The appropriate module(s) will be synced (installed/uninstalled) based on the scope definition that are defined in a YAML configuration.

## Dependencies
- Drush
- Drupal 8

## Similar Concept

- [Master](https://www.drupal.org/project/master) - Drupal 7

## Getting Started

First, you'll need to download the `drush-module-sync` library using composer:

```bash
composer require droath/drush-module-sync
```

Next, you need to create a `module-sync` configuration file. This can be done by executing the following command:

```bash
drush module-sync-generate
```

Once invoked, the command will prompt for input as it generates your `module-sync.yml` configuration. When adding scopes I usually input both **local** and **stage**, as those are common environments that require different modules to be installed or uninstalled. By default the `module-sync.yml` file will be generated in the Drupal site path, which is usually `path-to-drupal/sites/default` if you're not using a multi-site configuration.

You can set the save path to a different directory, by providing the **--path** option.

```bash
drush module-sync-generate --path=../configs
```

Now you can edit the `module-sync.yml` configuration that was generated. You can define different modules for each scope `modules` directive:

```yaml
scope:
  stage:
    extend_base: true
    modules:
      - file_stage_proxy
  local:
    extend_base: true
    modules:
      - devel
      - file_stage_proxy
base:
  - field
  - views
  ...
```
As you can see the scope can extend from the `base` directive, as this is useful to remove module redundancy between multiple scopes. If you don't want to extend from the base, just set `extend_base` to `false`. Make sure to remove any modules from the `base` directive if you only want that module to be installed for a particular scope, which should already been defined.

Finally, after you've tweaked your `module-sync` configurations to your liking you can run the following command to execute the sync process.

```bash
drush module-sync --scope=local
```

**Note:** You can pass along the --yes|-y flag to confirm all prompts.

The command will evaluate what modules that have already been installed or need to be uninstalled for the given scope. Make sure you only run this command with the `--yes` flag when your certain all modules have been accounted for, as you could have undesired consequences.
