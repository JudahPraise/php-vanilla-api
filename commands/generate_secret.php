<?php

if (php_sapi_name() !== 'cli') {
    die("This script can only be run from the command line.");
}

// Generate a random secret key
$secretKey = bin2hex(random_bytes(32));

// Define the path to the .env file
$envFilePath = __DIR__ . '/../.env';

// Read the existing .env file content
$envContent = file_get_contents($envFilePath);

// Check if JWT_SECRET already exists
if (strpos($envContent, 'JWT_SECRET') !== false) {
    // Replace the existing JWT_SECRET value
    $envContent = preg_replace('/^JWT_SECRET=.*$/m', 'JWT_SECRET=' . $secretKey, $envContent);
} else {
    // Append the JWT_SECRET value
    $envContent .= PHP_EOL . 'JWT_SECRET=' . $secretKey;
}

// Write the updated content back to the .env file
file_put_contents($envFilePath, $envContent);

echo "JWT_SECRET has been updated in the .env file." . PHP_EOL;
