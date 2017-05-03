# Laravel CRUD sample application

By [Jose Celano](http://josecelano.com/)

A Laravel sample application.

The purpose: build a simple Laravel application in a CRUD way to be refactor later to DDD approach.
I have read a lot of posts saying that DDD is ony valid for complex domain. But sometimes I also have read some of them 
saying DDD can also be applied for simple problems. I think I would use a CRUD approach for prototypes and refactor
later to DDD as soon as the project becomes a long term project. But on the other hand I do not see a very greater
cost on implementing DDD from the beginning. With this sample I want to test both solutions for the same simple problem.

> For the time being is only implemented the CRUD rapid approach.

## Specifications

Create a website where users will be able to see a variety of home appliances, creating a wishlist of their favourite ones 
which can be shared with friends.

The application will use another site as a primary data source: https://www.appliancesdelivered.ie .
The new site should contain products from both the small appliances and dishwashers categories:
* https://www.appliancesdelivered.ie/search/small-appliances
* https://www.appliancesdelivered.ie/dishwashers

Users will be able to see the data for these products presented in a clean and attractive format, regardless of the 
device they're using to view the site. 

* Users can order the data by title or price.
* When on the site, a user can create an account to save their favourite appliances to their wishlist.
* Their wishlist can then be shared with other friends.
* Their friends may not like the appliances the user has selected, so the user may also need to quickly remove items 
from their wishlist!

We'll want our new site to have good data, so need the ability to regularly sync new data from
AppliancesDelivered.ie to our great new site. But keep in mind that if our new site gets very popular, we don't want
to kill the source site with increased requests and server load, so we need to think carefully about how we handle this 
syncing process (how often it's run, when it's triggered, what we do with the resulting data etc).

We also need to allow for the case that AppliancesDelivered.ie may be down for maintenance, but we want our site 
to stay alive, so keep that in mind also when thinking about your approach here. The more confidence we can have in 
the continued operation of the site, the better! At some point in the future, if this site is successful the data source 
may be migrated from this crawler approach to a more formal API-based approach, so keep that path in mind when 
structuring your code.

The above are the main points of the application, but if you feel the application can be improved or any interesting 
other features implemented, then feel free to go wild!

## Installation

```bash
mysqladmin -u homestead -psecret create homestead
git clone git@github.com:josecelano/my-favourite-appliances.git
cd my-favourite-appliances
composer install
php artisan migrate
php artisan db:seed
php artisan serve
```

## Run crawler

```bash
php artisan import:dishwashers
php artisan import:small-appliances
```

Scheduler is set to execute import hourly:

```bash
php artisan schedule:run
```

## Demo accounts

https://github.com/josecelano/my-favourite-appliances/blob/master/database/seeds/Access/UserTableSeeder.php

Open localhost:8000 in the browser.

## TODO

* Remove appliances not updated in the last 24 hours.
* Enable more social authentication providers.
* Order list by title and price.
* Dislike button on each wishlist item (ReactJS component). Show different icon if user has already clicked.
* Dislikes counter (ReatcJS component).
* Add username to user profile and change permalink for users' wishlist (http://localhost:8000/1/wishlist to http://localhost:8000/username/wishlist)

## Acknowledgment

I have used this boilerplate: https://github.com/rappasoft/laravel-5-boilerplate