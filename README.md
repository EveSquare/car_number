## [ナンバープレート](https://www.airia.or.jp/info/number/01.html)

## ComposerのInstall

``` composer install ```

## .envファイルの用意

``` 
  DB_CONNECTION=mysql
  DB_HOST=127.0.0.1
  DB_PORT=8889
  DB_DATABASE=car_number
  DB_USERNAME=root
  DB_PASSWORD=root
  DB_SOCKET=/Applications/MAMP/tmp/mysql/mysql.sock
```

php.iniに以下を追記
```
extension=php_fileinfo.dll
```

composer require thiagoalessio/tesseract_ocr

# jetstream

[jetstream](https://qiita.com/manbolila/items/498aae00f3574c72f031)

# [migrate](https://qiita.com/manbolila/items/c19735438affefbfbe69)