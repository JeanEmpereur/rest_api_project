Comment start le projet :

lancer un wamp ou autre :)

bien modifier les valeurs de la BD mysql dans le .env

Ensuite pour start le server symfony

se mettre dans ce dossier et faire :

symfony server:start







Documentation de l'API : 

Users : 

model :
-username
-password

GET /users
Afin de récuperer tous les users
Responses : 
status 200 OK

GET /user/{user}
Afin de récuperer un user suivant l'id mis en param
Responses : 
status 200 OK

POST /user
Afin de créer un nouveau user dans la bdd
Responses : 
status 201 Created
status 406 Not acceptable
status 501 Not implemented

PUT /user/{user}
Afin de modifier un user 
Responses : 
status 201 Created
status 304 Not modified

DELETE /user/{user}
Afin de supprimer un user
Responses : 
status 201 Created
status 304 Not Modified
status 200 Ok

GET /login
Afin de se connecter avec un user
Responses : 
status 200 OK
status 406 Not acceptable

Articles :

model : 
-titre
-contenu

GET /articles
Afin de récupérer les articles dans la bdd
Responses : 
status 200 OK

GET /article/{article}
Afin de récuperer un article suivant l'id mis en param
Responses : 
status 200 OK

POST /article
Afin de créer un article dans la bdd
Responses : 
status 201 Created
status 406 Not acceptable
status 501 Not implemented

PUT /article/{article}
Afin de modifier un article
Responses : 
status 201 Created
status 304 Not modified

DELETE /product/{product}
Afin de supprimer un product
Responses : 
status 201 Created
status 304 Not Modified
status 200 Ok

Dons :

model : 
-prix
-name
-banquaire

GET /dons
Afin de récupérer les dons dans la bdd
Responses : 
status 200 OK

GET /don/{don}
Afin de récuperer un don suivant l'id mis en param
Responses : 
status 200 OK

POST /don
Afin de créer un don dans la bdd
Responses : 
status 201 Created
status 406 Not acceptable
status 501 Not implemented

Paniers :

model : 
-product:Product
-quantite
-user:User
-etat

GET /panier
Afin de récupérer les paniers dans la bdd
Responses : 
status 200 OK

GET /panier/{user}
Afin de récuperer un ou plusieurs panier suivant l'id mis en param
Responses : 
status 200 OK

GET /panier/{panier}
Afin de récuperer un panier suivant l'id mis en param
Responses : 
status 200 OK

POST /panier
Afin de créer un panier dans la bdd
Responses : 
status 201 Created
status 406 Not acceptable 
status 501 Not implemented

PUT /panier/{panier}
Afin de modifier un panier
Responses : 
status 201 Created
status 304 Not modified

DELETE /panier/{panier}
Afin de supprimer un panier
Responses : 
status 201 Created
status 304 Not Modified
status 200 Ok

Pets :

model : 
-name
-description 
-adopter
-poids
-race
-age
-date

GET /pets
Afin de récupérer les pets dans la bdd
Responses : 
status 200 OK

GET /pet/{pets}
Afin de récuperer un pet suivant l'id mis en param
Responses : 
status 200 OK

POST /pet
Afin de créer un pet dans la bdd
Responses : 
status 201 Created
status 406 Not acceptable
status 501 Not implemented

PUT /pet/{pets}
Afin de modifier un pet
Responses : 
status 201 Created
status 304 Not modified

DELETE /pet/{pets}
Afin de supprimer un pet
Responses : 
status 201 Created
status 304 Not Modified
status 200 Ok

GET /pet/random
Afin de récuperer un 5 pet aléatoire
Responses : 
status 200 OK

Products :

model : 
-prix
-name
-description
-stock

GET /products
Afin de récupérer les products dans la bdd
Responses : 
status 200 OK

GET /product/{product}
Afin de récuperer un product suivant l'id mis en param
Responses : 
status 200 OK

POST /product
Afin de créer un product dans la bdd
Responses : 
status 201 Created
status 406 Not acceptable
status 501 Not implemented

PUT /product/{product}
Afin de modifier un product
Responses : 
status 201 Created
status 304 Not modified

DELETE /product/{product}
Afin de supprimer un product
Responses : 
status 201 Created
status 304 Not Modified
status 200 Ok

GET /product/random
Afin de récuperer un 5 product aléatoire
Responses : 
status 200 OK

