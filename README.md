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

## Authentication

### Commands Directory and Secret Key Generator

This guide explains how to run a command script that generates a random secret key and updates the `.env` file with this key.

### Steps

1. **Generate JWT_SECRET:**

   After running the command the token will automatically added on your `.env`. Make sure JWT_SECRET is present inside your `.env`;

   ```sh
   php commands/generate_secret.php
   ```

## Authentication Token Configuration Documentation

This documentation describes the implementation and configuration of the auth_token feature in a PHP application, including the setup of JWT tokens and optional cookie storage for secure client-side handling.

### Overview

The auth_token configuration allows you to manage the storage and expiration of JWT tokens. Tokens can be sent to the client as cookies or directly in the response based on the configuration settings.

Inside the auth config, set the values as needed.

```
   'auth_token' => [
      'send_to_cookie' => true,
      'expires' => 60,
      'secure' => true,
      'httponly' => true,
      'samesite' => 'Strict',
   ],
```

### Usage

### Logging In

When a user attempts to log in, the `AuthController`’s `login` method will process the credentials. If the credentials are valid, a JWT token is generated. Based on the configuration, the token is either sent as a cookie or returned in the response.

### Configuration Options

- `send_to_cookie` (boolean): If `true`, the JWT token is set as a cookie.
- `expires` (integer): Token expiration time in minutes.
- `secure` (boolean): If `true`, the cookie is sent only over HTTPS.
- `httponly` (boolean): If `true`, the cookie is inaccessible to JavaScript.
- `samesite` (string): SameSite attribute for the cookie (`Strict`, `Lax`, `None`).

### Example

1. **Set `send_to_cookie` to `true`**:

   - The token will be set as an `HttpOnly` cookie.
   - The client can use the token for subsequent authenticated requests without exposing it to JavaScript.

2. **Set `send_to_cookie` to `false`**:
   - The token will be returned in the JSON response.
   - The client can store the token in a secure manner (e.g., in memory) and use it for subsequent requests.

### Security Considerations

- **HttpOnly Cookies**: Prevents JavaScript access to the token, mitigating XSS attacks.
- **Secure Cookies**: Ensures cookies are only sent over HTTPS, protecting against man-in-the-middle attacks.
- **SameSite Attribute**: Helps mitigate CSRF attacks by controlling when cookies are sent.

By configuring the `auth_token` settings, you can securely manage JWT tokens and tailor the authentication process to your application’s needs.
