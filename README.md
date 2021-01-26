# Тестовое задание

## Задача

Спарсить (программно) первые 15 новостей с www.rbk.ru 
(блок, откуда брать новости показан на скриншоте) и вставить в базу данных 
(составить структуру самому) или в файл. 
Вывести все новости, сократив текст до 200 символов в качестве описания, 
со ссылкой на полную новость с кнопкой подробнее. На полной новости выводить 
картинку если есть в новости.

**Было бы плюсом:** 
возможность расширения функционала парсинга для добавления дополнительных новостных
ресурсов.

## Реализация

### Окружение для разработки

Для разработки использовал _Linux Mint_, _Docker_, _Git_. 
Больше ничего не нужно. Все остальное поднимается внутри через 
_docker-compose_ и многоэтапную (_multi-stage_) сборку образов контейнеров.      

```
git clone https://github.com/eugene-khorev/rbc-parser.git
cd rbc-parser
docker-compose up -d
```

Т.к. я решил ~~усложнить~~ разнообразить себе жизнь, было принято решение 
разработать относительно "взрослое" решение на основе паттерна _CQRS_, 
а также использовать свежий стек. Поэтому вышеприведенная команда 
поднимает следующие контейнеры:  

* Caddy server (_caddy-2.2.1-alpine_)
* PHP-FPM (_php-8.0.1-fpm-alpine_)
* PostgreSQL (_postgres-13.1-alpine_)
* RabbitMQ (_rabbitmq-3.8.11-alpine_)

Внутри зашито все что нужно, начиная от административной панели _RabbitMQ_, 
до менеджеров управления пакетами _Composer_ и _Yarn_. 

### Архитектура

В качестве базы решил взять последнюю версию _Symfony_ (5.2),
т.к. последний раз работал с версией 4.4.
Как говорилось выше, в основе реализации лежит паттерн _CQRS_. 
Это одновременно дает возможность выполнять парсинг в фоновом режиме 
и реализовать любые способы получения и сохранения данных из разных источников.
Реализация паттерна основана на компоненте _Symfony Messenger_. 
Интерфейсы и классы поверх компонента простенькие и отдельного описания, 
на мой взгляд, не заслуживают. Лежат в пространстве имен `App\Common\Cqrs\`.

Для ручного запуска парсинга можно воспользоваться командой 
`php bin/console app:parse-news`. Она помещает в шину команду на получение 
списка новостей `ParseNewsListCommand` с сайта www.rbc.ru. 

Для обработки очереди команд необходимо выполнить 
`php bin/console messenger:consume`.

В перспективе возможно добавление любого источника данных, от текстового файла до фида RSS,
т.к. обработчик команды `ParseNewsListHandler` принимает на вход 
интерфейсы `DataProviderInterface` и `NewsListParserInterface`, 
которые можно реализовать как угодно. 

В текущей версии, эти интерфейсы
реализуются классами `HttpDataProvider` 
(использует PSR-18 совместимый `HttpClient`) и
`NewsListParser`, основанный на `CrawlerBasedParser` 
(используюет компонент _Symfony Crawler_ для парсинга).

Далее обработчик команды `ParseNewsListHandler` находит ссылки
на новости, и помещает в шину команды на парсинг каждой 
отдельной новости `ParseNewsArticleCommand`.
Обработчик этой команды `ParseNewsArticleHandler` устроен 
аналогично. Благодаря зависимостям только от интерфейсов
ему все равно, откуда придут данные, как их парсить.

!!! ПРО QUERY сохранение и вывод новостей !!!

Вывод новостей реализован тривиально. 
Есть контроллер с двумя методами и два шаблона.
Для "красоты" и удобного просмотра как с монитора,
так и с экрана мобильного телефона, используется 
_Bootstrap 4_.
