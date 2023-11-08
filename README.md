# Foodics-Test

## Run this Project

- clone repo and cd to repo dir
- copy .env.example .env
- docker-compose up --build -d
- run this command to access the container "docker exec -it foodics-test bash"
  - composer install
  - php artisan key:generate
  - php artisan migrate      "create database in your program with name foodics or you can change name but sjould update in env file"
  - php artisan db:seed
  - php artisan queue:work "to disbatch job that sending email"


## Postman Api collection link 

- **[ِCollection link ](https://www.postman.com/she3bo/workspace/foodics/collection/7931402-edd7fa8d-ba31-4516-af63-9ca4a8e2d4ae?action=share&creator=7931402)**
