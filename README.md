## コマンド
### コントローラー作成
```
docker-compose exec app php artisan make:controller ArticleController
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
docker-compose exec workspace php artisan migrate:rollback
```
### マイグレーション実行ステータス
```
docker-compose exec workspace php artisan migrate:status
```
### SQLに接続
```
docker-compose exec db bash -c 'mysql -u${MYSQL_USER} -p${MYSQL_PASSWORD} ${MYSQL_DATABASE}'
```