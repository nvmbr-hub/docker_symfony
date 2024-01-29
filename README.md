### Начальные условия ###
На компьютере должен быть установлен docker (желательно, но не обязательно Docker Desktop)  https://docs.docker.com/get-docker/
и docker compose https://docs.docker.com/compose/install/


После чего запускаем проект
```
docker compose up -d
```
запуститься три контейнера - php-fpm, nginx, postgresql


## Начинаем проект Symfony skeleton ##
1. заходим в контейнер

```
docker exec -it php-skeleton  /bin/bash
```
устанавливаем симфу
```
composer install
```

2. Добавляем
```
composer require symfony/orm-pack
composer require --dev symfony/maker-bundle
composer require symfony/security-bundle
```

 Добавляем в .env файл
```
DATABASE_URL="postgresql://usr:97y2amDpm@pg-cmf:5432/usr?serverVersion=15&charset=utf8"
MESSENGER_TRANSPORT_DSN=doctrine://default?auto_setup=0
```

3. Добавляем анотации и мессенджер


```
  composer require doctrine/annotations
  composer require templates
  composer require form validator
```
4. Curl команды для ручного тестирования 

```
    ### Расчет цены продукта
    curl -X POST http://127.0.0.1:80/calculate-price -H "Content-Type: application/json" -d '{"product": 1, "taxNumber": "DE123456789", "couponCode": "D15"}'
    
    ### Покупка продукта
    curl -X POST http://127.0.0.1:80/purchase -H "Content-Type: application/json" -d '{"product": 1, "taxNumber": "IT12345678900", "couponCode": "D15", "paymentProcessor": "paypal"}'

```
