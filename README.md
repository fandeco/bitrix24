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
      "url": "https://github.com/webnitros/app"
    }
  ],
  "require": {
    "webnitros/app": "^1.0.0"
  }
}
```

# phpunit

Переменные для env задаются в файле phpunit.xml


```js
Array
(
    [TITLE] => Из чата 79345555061
    [NAME] => Мария Кияшко
    [SECOND_NAME] => 
    [LAST_NAME] => 
    [STATUS_ID] => NEW
    [OPENED] => Y
    [ASSIGNED_BY_ID] => 12822
    [TYPE] => chat
    [REGISTER_SONET_EVENT] => Y
    [ADDRESS_CITY] => 
    [UTM_TERM] => 
    [ADDRESS_REGION] => 
    [ADDRESS_COUNTRY] => 
    [UF_CRM_1665568341670] => fandeco
    [UF_CRM_1662118608905] => 0
    [UF_CRM_1663927628378] => Fandeco.ru
    [UF_CRM_1663927675305] => 
    [SOURCE_ID] => 4
    [WEB] => Array
        (
            [0] => Array
                (
                    [VALUE] => https://fandeco.ru/
                    [VALUE_TYPE] => WORK
                )

        )

    [PHONE] => Array
        (
            [0] => Array
                (
                    [VALUE] => 79345555061
                    [VALUE_TYPE] => WORK
                )

        )

    [EMAIL] => Array
        (
            [0] => Array
                (
                    [VALUE] => 
                    [VALUE_TYPE] => WORK
                )

        )

)
```
