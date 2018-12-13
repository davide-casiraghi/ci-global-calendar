# Global Contact Improvisation Calendar

The **CI Global Calendar** is part of the **Round Robin Project (RRP)**, an international adventure initiated in 2008, to serve the dance form **Contact Improvisation (CI)** and all the people worldwide who are engaged in that work—dance practitioners, performers, researchers, teachers, and any other interested people. 

The goal of the **CI Global Calendar** is to make information about Contact Improvisation events easily accessible in several languages—representing, at a glance, CI activities around the globe. It offers listings of CI classes, jams, workshops, festivals, and events happening throughout the global CI community, posted individually by event organizers and teachers.

# Get Involved
The Round Robin Project brings together a collective of dancers involved in the practice of Contact Improvisation and led by the desire to share this dance form with a wider and wider audience.

We are actively looking for people to support the Project, especially (but not only) in regard with:

- Developing/supporting the website: computer people, web designers, programmers, we need you!
- Fundraising/inventing ways to support the further development and maintenance of this project
- Advertising the project in whatever Contact Improvisation contexts you travel through
- Using this website and recommending it to your students and partners

# Contribute as web developer
The project is developed with the PHP framework **Laravel 5.7**

# How to install
Once you have cloned the branch run: 
- npm install
- composer install
- copy .env.example .env
- php artisan key:generate
- go to your .env file and change database details
- import the database file in your mysql database (ask to Davide the most updated vesion)
- create an apache virtual host with the same url you set in the APP_URL parameter in .env
- or.. start then the server running: php artisan serve

# Credits and contributors
Davide Casiraghi

# License
The Global Contact Improvisation Calendar is free software distributed under the terms of the MIT license.
