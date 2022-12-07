# Library Management Web Application
Group Project in CPSC 3660: Introduction to Database    
Fall 2021 

## How to run the project
1. Change the database information in the config.php to connect to the database.
2. Change the library database name in the seeder.sql. It should match the database name in the config.php
3. Run the seeder.sql file to create the tables and insert sample data.
   
## Repo structure

**index.php**  
Home page

**config.php**  
DB configurations

**head.php**  
Head part of the pages

**footer.php**  
Footer part of the pages

**seeder.sql**  
Create and insert statements, sample data

**assets/**  
Images used

**css/**  
Stylings

**js/**  
Javascript

**create/**  
Contains all the pages with forms to create a new record

**insert/**  
DB insert handler

**list/**  
Contains all the pages to list all records of each entity

**view/**  
Individual pages to view a record of an entity

**edit/**  
Contains all pages to edit a record in a form

**update/**  
DB update handler

**delete/**  
DB delete handler

**ajax/**  
Pages whose data will be displayed onto the page via ajax

**docs/**  
Documentation of the project including proposals, erd, and relational models





