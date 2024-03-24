## About this app

- Laravel 11 (Jetstream, Livewire, Sanctum)
- PHP 8.3
- Tailwind

Scheme:

    Frontend:
    	Login
    
        Backend:
    	Dashboard		(procedures)	        [table]
    		New/Edit	(procedure)		[modal]
    	Detail			(bookings)		[table]	

    DB:
    	procedures
    		title			string
    		type_id			id
    		state_id		id
    		is_featured		boolean
    		ended_at		date
  
    	types
    		name			string		[event, registration, coupon, payment]
    
    	states
    		name			string		[pending, progress, done]
    
    	bookings
    		procedure_id	id
    		card			string		[dni]

    API:
    	CRUD	(procedures)
    	Filter	(status, type)

## API REST

<p><img src="/public/img/s01.jpg" width="700"></p>
<p><img src="/public/img/s02.jpg" width="700"></p>
<p><img src="/public/img/s03.jpg" width="700"></p>
<p><img src="/public/img/s04.jpg" width="700"></p>
<p><img src="/public/img/s05.jpg" width="700"></p>

## Installation

Please check the official Laravel installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/11.x/installation)

Clone the repository

    git clone https://github.com/benzuri/eagora.git

Switch to the app folder

    cd eagora

Install all the dependencies using composer

    composer install

Make the required configuration changes in the .env file if you need

    cp .env.example .env

Generate a new application key

    php artisan key:generate

Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate:fresh

Start the local development server

    php artisan serve

You can now access the server at http://localhost:8000
