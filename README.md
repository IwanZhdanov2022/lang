# lang
Вывод текстовых сообщений на выбранном языке
----

## Установка
```bash
composer require iwan07/lang
```

## Установка языка
Чтобы установить язык сообщений:
```php
use Iwan07\Lang\Lang;

Lang::setLanguage('ru');
```

## Использование

```php
use Iwan07\Lang\Lang;

$lang = new Lang;

echo $lang->main_page;        // Вариант 1
echo $lang->msg('main_page'); // Вариант 2
```

Тексты сообщений могут находиться в папке со скриптом, который их использует, или вышестоящих папках. Названия файлов с сообщениями "lang_**.php", где ** - код языка, указанный ранее в setLanguage.

Например:

lang_ru.php
```php
<?php

return [
    'main_page' => "Главная страница",
    'about'     => "О проекте",
    'contact'   => "Наши контакты",
];
```

lang_en.php
```php
<?php

return [
    'main_page' => "Home page",
    'about'     => "About project",
    'contact'   => "Our contacts",
];
```

## Использование сообщений с числительными

lang_ru.php
```php
<?php

return [
    'link' => ["ссылка", "ссылки", "ссылок"],
];
```
```php
// ...
echo $lang->num(1, 'link'); // "1 ссылка"
echo $lang->num(2, 'link'); // "2 ссылки"
echo $lang->num(5, 'link'); // "5 ссылок"

echo $lang->link; // "ссылка"
```

lang_en.php
```php
<?php

return [
    'link' => ["link", "links"],
];
```
```php
// ...
echo $lang->num(1, 'link'); // "1 link"
echo $lang->num(2, 'link'); // "2 links"
echo $lang->num(5, 'link'); // "5 links"

echo $lang->link; // "link"
```
