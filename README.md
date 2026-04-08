# laravel-docker-template

## 環境構築

Dockerビルド

```bash
git clone git@github.com:Estra-Coachtech/laravel-docker-template.git
mv laravel-docker-template coachtech-contact-form
cd coachtech-contact-form
git remote set-url origin git@github.com:105lovechildren-yui/coachtech-contact-form.git
docker-compose up -d --build
```

## Laravel環境構築

1. コンテナの起動

```bash
docker-compose up -d
```

2. パッケージのインストール

```bash
docker-compose exec php composer install
```

3. アプリケーションキーの生成

```bash
docker-compose exec php php artisan key:generate
```

4. マイグレーションの実行

```bash
docker-compose exec php php artisan migrate
```

5. シーディングの実行

```bash
docker-compose exec php php artisan db:seed
```

## 権限エラーが発生した場合

開発環境によっては、ファイルの所有者が異なり Permission denied エラーが発生する場合があります。
その場合は以下のコマンドで権限を修正してください。

```bash
sudo chown -R $USER:$USER src
```

必要に応じて、書き込み権限も付与します。

```bash
sudo chmod -R 775 src
```

※ 本環境では、docker-compose exec -u www-data を使用すると、ファイルの所有者が www-data となり、ホスト側で編集できなくなる可能性があります。そのため、開発時は -u オプションを付けずにコマンドを実行しています。

## 開発環境

・お問い合わせフォームページ:http://localhost
・ユーザー登録画面:http://localhost/register
・phpMyAdmin:http://localhost:8080/

## 使用技術（実行環境）

・PHP 8.1.34
・Laravel 8.83.8
・Composer version 2.7.1 2024-02-09 15:26:28
・Mysql 8.0.26
・nginx 1.21.1

## ER図

![ER図](./images/er-diagram.png)
