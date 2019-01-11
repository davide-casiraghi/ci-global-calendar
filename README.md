[![License](https://img.shields.io/badge/license-MIT-blue.svg?style=flat-square)](LICENSE)
[![GitHub last commit](https://img.shields.io/github/last-commit/davide-casiraghi/ci-global-calendar.svg)](https://github.com/davide-casiraghi/ci-global-calendar) 

# Global Contact Improvisation Calendar

The **CI Global Calendar** is part of the **Round Robin Project (RRP)**, an international adventure initiated in 2008, to serve the dance form **Contact Improvisation (CI)** and all the people worldwide who are engaged in that work—dance practitioners, performers, researchers, teachers, and any other interested people. 

The goal of the **CI Global Calendar** is to make information about Contact Improvisation events easily accessible in several languages—representing, at a glance, CI activities around the globe. It offers listings of CI classes, jams, workshops, festivals, and events happening throughout the global CI community, posted individually by event organizers and teachers.

The calendar is still in beta testing phase and not yet available online, we plan to fully operate starting from January 2019 on.

For further info about the history of the project: [roundrobinproject.weebly.com](https://roundrobinproject.weebly.com/) 


# Get Involved
The Round Robin Project brings together a collective of dancers involved in the practice of Contact Improvisation and led by the desire to share this dance form with a wider and wider audience.

We are actively looking for people to support the Project, especially (but not only) in regard with:

- Developing/supporting the website: computer people, web designers, programmers, we need you!
- Fundraising/inventing ways to support the further development and maintenance of this project
- Advertising the project in whatever Contact Improvisation contexts you travel through
- Using this website and recommending it to your students and partners

# Contribute as web developer
The project is developed using this technlogies:
- PHP framework: **Laravel 5.7**
- Javascript framework: **jQuery**
- CSS framework: **Bootstrap 4**
- Version control: **Git**  
- Testing frameworks: **PHPUnit**, **Laravel Dusk**

Below you can find informations about download the source code on your computer and join the developer team.

# How to install

1) Send to Davide your SSH Public Key ([check Github tutorial on SSH](https://help.github.com/articles/checking-for-existing-ssh-keys/))
2) Clone the git branch 

3) Procede with the installation: 
    - **npm install**
    - **composer install**
    - **copy .env.example .env**
    - **php artisan key:generate**
    - create on your local machine a database called **CIGC-local**
    - go to your .env file and set yours DB_USERNAME and DB_PASSWORD 
    - import the database file in your mysql database (ask to Davide the most updated vesion)
    - create an apache virtual host with the same url you set in the APP_URL parameter in .env
    - **php artisan cache:clear**
    
# Tests
In order to keep the code mantainable and improvable on the long term by a pool of developers, most of the functionalities of the calendar are tested by a series of unit test and browser test.
For this reason a **TDD approach** is encouraged.

Unit tests and browser tests are implemented using **PHPUnit** and **Laravel Dusk**.  
Before merge on the branch master please check the testsrunning in the project root folder:
- **./vendor/bin/phpunit**
- **php artisan dusk**

## Local test environment

**How to setup the local test environment**
Before running the tests you need to create another database that is used to create dummy datas by the test functions.
- create on your local machine a database called **CIGC-local-test**
- **php artisan migrate --database=testing**
- create a file .env.testing in the root folder copying .env  (used by phpunit)
  - DB_CONNECTION=testing  
  - DB_DATABASE=CIGC-local-test
- create a copy of .env.testing and name it .env.dusk.local  (used by laravel dusk)
- in **composer.json** remove temporary "laravel/dusk" from "dont-discover", run **composer update** and add "laravel/dusk" again in "dont-discover", this because laravel/dusk should not be insalled on the production and testing environments.

## Online testing environment 

It's also available for the developers a testing environment, parallel to the production environment where is possible to test fixes and releases before roll them out on the production environment.
This environment show the content of the branch **testing** that is almost aligned to the branch master and is reachable at this URL: 

## Production environment

The production environment show the content of the branch **master** and is reachable at this URL: 

# Web developers team
Davide Casiraghi

# License
The Global Contact Improvisation Calendar is free software distributed under the terms of the [MIT license](https://opensource.org/licenses/mit-license.php).   
The source code is developed and mantained by this [contributors](https://github.com/davide-casiraghi/ci-global-calendar/graphs/contributors).



