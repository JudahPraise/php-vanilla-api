# PHP Vanilla API

A simple PHP API built without any frameworks to demonstrate the basics of creating a RESTful API.

## Features

- **Routing:** Basic routing mechanism
- **Environment Configuration:** Uses `.env` for configuration
- **PSR-4 Autoloading:** Autoloading with Composer

## Requirements

- PHP 7.4 or higher
- Composer

## Installation

1. Clone the repository:

   ```sh
   git clone https://github.com/JudahPraise/php-vanilla-api.git
   cd php-vanilla-api
   ```

2. Install dependencies:

   ```sh
   composer install
   ```

3. Copy the example environment file and configure it:

   ```sh
   cp .env.example .env
   ```

4. Start the PHP built-in server:
   ```sh
   php -S localhost:8000 -t public
   ```

## Usage

Access the API at `http://localhost:8000`.

## Project Structure

- **config:** Configuration files
- **public:** Publicly accessible files (entry point)
- **routes:** Route definitions
- **src:** Source code
