Base de données

Table "biens" :
    - id : int clé primaire AUTO-INCREMENT
    - type : varchar(255)
    - title : varchar(255)
    - description : text
    - surface : int
    - rooms : int
    - bedrooms : int
    - price : int
    - address : varchar(255)
    - postal_code : varchar(30)
    - city : varchar(100)
    - image : varchar(100)
    - created_at : datetime, valeur par défaut : CURRENT_TIMESTAMP

Table "users" :
    - id : int clé primaire AUTO-INCREMENT
    - username : varchar(255)
    - email : varchar(255)
    - password : varchar(255)