## [ナンバープレート](https://www.airia.or.jp/info/number/01.html)

php.iniに以下を追記
```
extension=php_fileinfo.dll
```

# [migrate](https://qiita.com/manbolila/items/c19735438affefbfbe69)

# 1. 動作環境

||varsion|
|-|-|
|macOS Big Sur | 11.4 |
|PHP | 8.0.0 |
|MySQL | 5.7.32 |
|Laravel | 8.48.1 |

# 2. PHPのインストール(Homebrewが入っている前提)

ターミナルにて、以下のコマンドを打ちます

```% php -v ```

ターミナルにバージョンが出てこなかった場合以下のコマンドを実行します

```% brew install php@8.0```

# 3. 初期設定

画像検索用ライブラリTesseractOCRのインストール

```
% brew install tesseract 
% brew install tesseract-lang　←(時間が掛かる可能性があります。)
```

# 4. 起動

```
% php artisan serve 
Starting Laravel development server: http://127.0.0.1:8000
```
ブラウザを開き、<a href="http://127.0.0.1:8000">http://127.0.0.1:8000</a>にアクセスをする

# 5. 登録済みのデータ

#### アカウント

username : test@qmail.com

password : PassW@rd

ナンバーの登録済みデータ↓
``` 
上から順番に

品川　500

あ　0 0 0 0

です
```