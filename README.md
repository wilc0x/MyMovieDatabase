Movie Database v1.4

To run--
1. ensure "extension=intl" is uncommented in php.ini
2. to load dependencies, execute command from root project directory: $ composer install
3. to load initial database values, execute command from root project directory: $ php data/load_db.php
4. to launch, execute command from root project directory: $ php -S 0.0.0.0:8080 -t public index.php


For this project I opted to learn a little bit about Zend Framework 3.

Features:
- basic CRUD functionality for entering and modifying movie data
- local storage with Sqlite
- table rows sortable by column
- movie descriptions fetched via javascript from OMDB on click of movie title and dynamically loaded into UI
- ratings, automatically fetched via Zend if not user provided