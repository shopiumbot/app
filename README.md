Application
===========

#### First run
```
php composer global require "fxp/composer-asset-plugin:^1.2.0"
```

#### Either run for dev
```
php composer create-project shopiumbot/app . "dev-master"
```

#### Either run for production
```
php composer create-project --prefer-dist --no-dev --stability=dev shopiumbot/app . "dev-master"
```