echo "Navegando para o diretório do projeto"
cd user-contacts
echo  "Construindo container e iniciando os contêineres do projeto em segundo plano"
docker-compose up -d --build
echo  "Rodando composer install, migrates e gerando keys"
docker-compose exec user-contacts-app /bin/bash -c "composer install && php artisan migrate && php artisan key:generate"
echo  "Criando fila no localstack"
docker exec user-contacts-localstack bash -c "awslocal sqs create-queue --queue-name EMAIL_QUEUE"

cd ..
echo  "Navegando para o diretório do projeto"
cd user-contacts-listener
echo  "Construindo container e iniciando os contêineres do projeto em segundo plano"
docker-compose up -d --build