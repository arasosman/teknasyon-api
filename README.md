## Rahatlatıcı Müzikler Api

### Kurulum

    git clone https://github.com/arasosman/teknasyon-api.git
	cd teknasyon-api/src
	cp .env.example .env 
    docker run --rm -v $(pwd):/app composer install
    
## Docker Compose işlemleri   

    docker-compose build
    docker-compose up -d
    
##Veritabanı işlemleri

    docker-compose exec php /usr/share/nginx/html/artisan key:generate
    docker-compose exec php /usr/share/nginx/html/artisan l5-swagger:generate
    docker-compose exec php /usr/share/nginx/html/artisan migrate
    docker-compose exec php /usr/share/nginx/html/artisan db:seed
    
    
    
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
    
