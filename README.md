# DESCRIPTION

The project is singe page app that lists nearby shops. it was built using PHP/Symfony 4 and Vue.js.

Technical spec
---------------
The application was splited between a **back-end** and a **web front-end**.

The **front-end** is a single page app implemented using: 
* Vue.js
* Vue Router
* Vuex
* Axios
...

For the **back-end**, Symfony 4.2 was used along with some useful bundles: 
* FOSUserBundle
* Symfony Validator
* NelmioApiDocBundle 
* JMSSerializerBundle
* SecurityBundle
* WebpackEncoreBundle
...

Functional spec
---------------
The app lists shops nearby. 

- As a User, I can sign up using my email & password
- As a User, I can sign in using my email & password
- As a User, I can display the list of shops sorted by distance
- As a User, I can like a shop, so it can be added to my preferred shops (liked shops wouldn’t be displayed on the main page)
- As a User, I can dislike a shop, so it won’t be displayed within “Nearby Shops” list during the next 2 hours
- As a User, I can display the list of preferred shops
- As a User, I can remove a shop from my preferred shops list

Usage
--------------- 

For start you need to configure the database in .env file

After configuring your database you can use the following commands for quick start.

- To create database: "php bin/console doctrine:database:create"
- To create database schema: "php bin/console doctrine:schema:create"
- To populate database: "php bin/console doctrine:fixtures:load"

Enter the path "/api/doc" to check the back-end rest api documentation. (use admin:admin for credentials)
