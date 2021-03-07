## コマンド
### コンテナないで対話的そうさ　
```
docker exec -it laravel_sns_practice_app_1 bash
```
### appコンテナ内でコマンド実行
```
docker-compose exec app
```
### コントローラー作成d
```
docker-compose exec app php artisan make:controller ArticleController
```
### モデル作成
```
docker-compose exec app php artisan make:model Article
```
### マイグレーションファイル作成
```
docker-compose exec app php artisan make:migration create_articles_table --create=articles
```
### マイグレーション実行
```
docker-compose exec app php artisan migrate
```
### ロールバック
```
docker-compose exec app php artisan migrate:rollback
```
### マイグレーション実行ステータス
```
docker-compose exec app php artisan migrate:status
```
### SQLに接続
```
docker-compose exec db bash -c 'mysql -u${MYSQL_USER} -p${MYSQL_PASSWORD} ${MYSQL_DATABASE}'
```

### ルートリスト
```
php artisan route:list
```