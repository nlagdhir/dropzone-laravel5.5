# Dropzone.js and Laravel 5.5 image uploads with delete links

I have implement Dropzone.js and Laravel 5.5 image upload functionality in my recent project.

What is covered in this repo:

    - Auto image upload
    - Remove images directly from Dropzone preview with AJAX request
    - Saving image data to database
    - Unique file names for images on server side
    - Displaying already uploaded images in Dropzone

## Installation

When you clone this project cd into directory and then:

 - Copy .env.example to .env
 - `composer install`
 - `chmod -R 777 storage/ bootstrap/`
 - `php artisan key:generate`
 - Fill .env file with database credentials and upload paths.
 - `php artisan migrate`
   
Now you are all set.