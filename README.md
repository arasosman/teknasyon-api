## Rahatlatıcı Müzikler Api

### Kurulum

    git clone https://github.com/arasosman/teknasyon-api.git
	cd teknasyon-api
	cd src
	cp .env.example .env 
    composer install
    php artisan key:generate
    php artisan l5-swagger:generate
    cd ..
## Docker Compose işlemleri   

    docker-compose build
    docker-compose up -d
##Veritabanı işlemleri

    cd src
    php artisan migrate
    php artisan db:seed
    
    
    
`api dökümanı` Swagger yardımı ile oluşmaktadır. Aşağıdaki linkten kullanılabilir duruma gelmektedir.
    
http://localhost:8080/api/documentation

###Veritabanına erişmek için bilgiler

    http://localhost:8081
    user: homestead
    pass: secret
    port: 
    
#Testler

    vendor/bin/phpunit
    composer run phpcs
    
##Conteiner hatası
proje conteiner'da mysql bağlantı hatası oluşursa. build in server kullanılabilir.

	src dizininde yapılmalıdır
	php artisan serve
    
http://localhost:8000/api/documentation
