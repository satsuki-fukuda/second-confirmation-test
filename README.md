# second-confirmation-test

## 環境構築
**Dockerビルド**
<br>1.`git@github.com:satsuki-fukuda/second-confirmation-test.git`</br>
<br>2. DockerDesktopアプリを立ち上げる</br>
<br>3. `docker-compose up -d --build`</br>

**Laravel環境構築**
1. `docker-compose exec php bash`
2. `composer install`
3. 「.env.example」ファイルを 「.env」ファイルに命名を変更。または、新しく.envファイルを作成
4. .envに以下の環境変数を追加
``` text
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel_db
DB_USERNAME=laravel_user
DB_PASSWORD=laravel_pass
```
5. アプリケーションキーの作成
``` bash
php artisan key:generate
```

6. マイグレーションの実行
``` bash
php artisan migrate
```

7. シーディングの実行
``` bash
php artisan db:seed
```

8.提供画像
<br>https://drive.google.com/file/d/1O_3WqPdrU9fOEdbKEkrJ_qMN0CcLD53d/view?usp=drive_link
をダウンロードしstorage/app/imagesファイルを作成、画像保存し下記を実行</br>
``` bash
php artisan storage:link
```

## 使用技術(実行環境)
- PHP8.1.34
- Laravel8.83.29
- MySQL8.0.26

## ER図
<img width="691" height="269" alt="end" src="https://github.com/user-attachments/assets/0ca3da0e-691c-4121-9eae-0c1710852989" />


## URL
- 開発環境：http://localhost/products
- phpMyAdmin:：http://localhost:8080/
