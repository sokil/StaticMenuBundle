StaticMenuBundle
================

Configure menus in symfony configuration file. This is wrapper over `knp-menu-bundle`.

## Installation

You can install bundle through Composer:
```
composer require sokil/static-menu-bundle
```

## Menu configuration

Configure menu in `app/config/config.yml`

```yaml
static_menu:
  someMenuName: # set some name to your menu
    childrenAttributes:
      class: nav navbar-nav
    items: # configure items of menu
      - label: menu_tasks
        role: ROLE_TASK_VIEWER # role allowed to see menu
        uri: /#tasks
      - label: menu_contacts
        route: contact_us_index
      - label: menu_new_task
        uri: /#tasks/new
        role: IS_AUTHENTICATED_REMEMBERED
        linkAttributes:
          class: visible-xs
```

See item options at vendor/knplabs/knp-menu/src/Knp/Menu/Factory/CoreExtension.php

## Menu rendering

KNP menus rendered by calling {{ knp_menu_render('static_menu.someMenuName') }}