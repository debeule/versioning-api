 ```
      /~\           
     ( oo|              
     _\=/_                             
    /     \                       ___   
   //|/.\|\\                     / ()\ 
  ||  \_/  ||                  _|_____|_ 
  || |\ /| ||                 | | === | |
  #  \_ _/ #                  |_|  O  |_|
     | | |                     ||  O  ||
     | | |                     ||__*__||
     []|[]                    |~ \___/ ~|
     | | |                    /=\ /=\ /=\
____/_]_[_\___________________[_]_[_]_[_]

 ```

 # setup project
 docker compose up -d

 # setup project
 docker exec app composer start

 # setup testing environment: 
docker exec app composer testing

# generate api bearer token
docker exec app php artisan api-token:generate