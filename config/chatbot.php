<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Chatbot API Configuration
    |--------------------------------------------------------------------------
    |
    | Configure the chatbot API endpoint URL based on environment
    |
    */

    'api_url' => env('CHATBOT_API_URL', 'http://localhost:3000'),
    
    'enabled' => env('CHATBOT_ENABLED', true),
    
    'timeout' => env('CHATBOT_TIMEOUT', 30),
];
