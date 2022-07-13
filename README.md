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
