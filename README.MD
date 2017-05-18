# Apheed

## Summary

A Drupal 8 website and custom Python/Django API which takes in user in put and makes queries to twitter and reddit to scrape the web pages for new posts to be displayed in the user's feed.

## Author

Dylan Stackhouse

## Setup

1. Download [php](https://secure.php.net/)
2. Download [drupal 8](https://www.drupal.org/download)
3. Download [mysql](https://www.mysql.com/)
4. Download [apache](https://httpd.apache.org/)
5. Download [Python 2.7.10+](https://www.python.org/download/releases/2.7/)
6. Import the mqsql database (db_backup/apheed.sql.zip) into your mysql server (Server running on port 8889)
6. Create a user in phpMyAdmin for the pantheon database with the username 'apheed-admin' and password 'admin'
7. Set your apache document root to apheed/drupal-environment.
8. Navigate to apheed/python-environment/myVe and run $ `source bin/activate`
9. From myVE go to myVE/apheed and run $ `python manage.py runserver`
10. Navigate to your local host for your apache server (Port 8888)




## IP

MIT Commons Dylan Stackhouse 2017
