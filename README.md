## [ナンバープレート](https://www.airia.or.jp/info/number/01.html)

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

# jetstream

[jetstream](https://qiita.com/manbolila/items/498aae00f3574c72f031)

# [migrate](https://qiita.com/manbolila/items/c19735438affefbfbe69)

# 1. 動作環境

||varsion|
|-|-|
|macOS Big Sur | 11.4 |
|MAMP | 6.3 |
|PHP | 8.0.0 |
|MySQL | 5.7.32 |
|Laravel | 8.48.1 |

# 2. PHPのインストール

ターミナルにて、以下のコマンドを打ちます

```% php -v ```

# 3. Laravelのインストール

laravelをインストールする為に、```composer```を初めにインストールします

```% brew install composer ```

インストール後、以下のコマンドでバージョンを確認します
```
% composer -V
Composer version 2.1.3 2021-06-09 16:31:20
```

Laravelのインストールをします

```% composer global require "laravel/installer”```

# 4. 初期設定

会員管理ライブラリ JetStreamのインストール

```% composer require laravel/jetstream  ```

画像検索用ライブラリTesseractOCRのインストール

```
% brew install tesseract 
% brew install tesseract-lang
% composer require thiagoalessio/tesseract_ocr
```

画像ファイルアップロード先フォルダのエイリアス作成

```% php artisan storage:link```

# 5. データベース　マイグレーション

```
% php artisan migrate
Migration table created successfully.
Migrating: 2014_10_12_000000_create_users_table
Migrated:  2014_10_12_000000_create_users_table (3.98ms)
```

# 6. 起動

```
% php artisan serve 
Starting Laravel development server: http://127.0.0.1:8000
```
ブラウザを開き、http://127.0.0.1:8000にアクセスをする