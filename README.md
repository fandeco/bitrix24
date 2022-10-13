## TemplateApp

Заготовка для создания пакетов для composer

### Для mac

Утилита

```bash
brew install gh
```

Публикация нового релиза вместе с тегом через утилиту gh

```bash
gh release create "v0.0.8" --generate-notes
```

### Настройка папокыы

В phpStorm настроить "Directories" для папок

```http request
src = App\
tests = Tests\
```

## Подключения в composer.json

```json
{
  "repositories": [
    {
      "type": "vcs",
      "url": "https://github.com/webnitros/bitrix24"
    }
  ],
  "require": {
    "webnitros/bitrix24": "^1.0.0"
  }
}
```

# phpunit

Переменные для env задаются в файле phpunit.xml

# Быстрый старт

```js
BITRIX_URL = ''
BITRIX_BOT_DEFAULT = 'API'
BITRIX_REST_API = ''
BITRIX_BOTS = 'NAME BOT:API KEY'
```

Модели работают аналогично объектам из базы данных с той разнице что выполнение запросов проиходит через REST

```php
$Object = \Bitrix24\Model::get('Lead', 21225)
$Object->get('NAME') // Имя пользователя
```
