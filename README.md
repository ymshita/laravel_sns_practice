## コマンド
### コントローラー作成
- docker-compose exec app php artisan make:controller ArticleController

###　マイグレーションファイル作成
- docker-compose exec app php artisan make:migration create_articles_table --create=articles