#Setting up

### install dependencies
    docker run --rm -v $(pwd):/app composer install --ignore-platform-reqs

### run docker
    docker-compose up -d
    
### enter to mysql console    
    docker exec -it url-minimizer_database_1 mysql -p'secret' symfony
    
### copy code of minimize table and paste to mysql console     
    vim ~/data/sql/minimize_urls.sql
    
http://localhost