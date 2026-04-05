# laravel-docker-template

## 環境構築

Dockerビルド
・git clone git@github.com:Estra-Coachtech/laravel-docker-template.git
・mv laravel-docker-template coachtech-contact-form
・git remote set-url origin git@github.com:105lovechildren-yui/coachtech-contact-form.git
・docker-compose up -d --build

## Laravel環境構築

1. コンテナの起動
   docker-compose up -d
2. パッケージのインストール
   docker-compose exec php composer install
   <!-- 3. アプリケーションキーの生成 -->
   docker-compose exec php php artisan key:generate
3. 権限エラー回避のためユーザーを指定してphpコンテナに入る
   docker-compose exec -u www-data php bash
4. マイグレーションの実行（権限指定）
   docker-compose exec -u www-data php php artisan migrate
   <!-- 5. シーディングの実行（カテゴリーデータの作成） -->
   docker-compose exec -u www-data php php artisan db:seed

## 開発時の注意点（権限エラーが発生する場合）
マイグレーションファイルの作成や実行時に Permission denied が発生する場合は、以下のコマンドでディレクトリの権限を更新
`docker-compose exec php chmod -R 777 storage database/migrations`

## 開発環境

・お問い合わせ画面:
・ユーザー登録:
・phpMyAdmin:http://localhost:8080/

## 使用技術（実行環境）

・PHP 8.1.34
・Laravel 8.83.8
・Composer version 2.7.1 2024-02-09 15:26:28
・Mysql 8.0.26
・nginx 1.21.1

<!-- ・jQuery -->

## ER図

![ER図](./images/er-diagram.png)

## URL
