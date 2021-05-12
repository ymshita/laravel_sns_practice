## マニュアル
### 1. ローカルの適当なところにクローン
```
$ git clone git@hogehoge.git
```
### 2. プロジェクトディレクトリに移動
### 3. APP_KEYを設定

1. コンテナを実行(`--build`指定は初回のみ)
```
docker-compose up -d --build
```
2. composerパッケージをインストール
```
docker-compose exec app composer install
```
3. npmパッケージをインストール
```
docker-compose exec app npm install
```
2. `.env.example` から .envファイルを作成
```
docker-compose exec app cp .env.example .env
```
3. APP_KEYを作成
```
docker-compose exec app php artisan key:generate
```
4. .envファイルを確認し、`APP_KEY=`が自動で設定されていない場合には以下のコマンドの内容を設定
```
php artisan key:generate --show
```
### 4.DB作成とマイグレーション
```
docker-compose exec app php artisan migrate:fresh --seed
```

### 5.フロントエンドライブラリのコンパイル
```
docker-compose exec app npm run dev
OR
docker-compose exec app npm run watch-poll
```
### 6.ブラウザで動作確認
- [localhost](http://localhost:10080/)


## ステージング環境
```
http://xxx.xxx.xxx.xxx/
http://test.hogehoge.jp/
hoge / hogehoge
```
### デプロイ
1. ssh接続
2. プロジェクトのルートに移動
3. developで `git checkout Dockerfile`
4. developからプル
5. developで `sed -i -e "s/production/test/g" Dockerfile`
6. (必要あれば) developでマイグレーション
7. developでビルド
8. rootでアタッチ `docker exec -it --user root app bash`

## 課題
- npm install と npmコンパイル(npm run)のタイミングがまだわかっていない。webpackを使うとまた違うのか
- コンテナ内でユーザー設定ができていない


## コマンド
### コンテナないで対話的操作
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
### フォームリクエスト作成
```
docker-compose exec app php artisan make:request ArticleRequest
```
### マイグレーションファイル作成
```
docker-compose exec app php artisan make:migration create_XXXs_table --create=XXXs
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
docker-compose exec app php artisan route:list
```
### キャッシュクリア系
```
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan route:clear
docker-compose exec app php artisan view:clear
docker-compose build --no-cache
```
### tinkerの起動
```
docker-compose exec workspace php artisan tinker
```
### vendor publish
```
php artisan vendor:publish --provider="Barryvdh\Debugbar\ServiceProvider"
```