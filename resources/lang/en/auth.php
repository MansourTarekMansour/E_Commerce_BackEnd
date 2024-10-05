<?php

return [
    'name' => [
        'required' => 'Name is required.',
        'string' => 'Name must be a valid string.',
    ],
    'email' => [
        'required' => 'Email is required.',
        'email' => 'Please provide a valid email address.',
        'unique' => 'This email is already registered.',
    ],
    'password' => [
        'required' => 'Password is required.',
        'min' => 'Password must be at least 8 characters long.',
        'confirmed' => 'Password confirmation does not match.',
    ],
    'phone_number' => [
        'required' => 'Phone number is required.',
        'size' => 'Phone number must be exactly 11 digits.',
        'unique' => 'This phone number is already registered.',
    ],
    'validation_errors' => 'Validation errors occurred.',
    'registration_success' => 'Customer registered successfully.',
    'login_success' => 'Customer logged in successfully.',
    'logout_success' => 'Successfully logged out.',
    'token_refreshed' => 'Token refreshed successfully.',
    'invalid_credentials' => 'Invalid credentials.',
    'registration_error' => 'Could not register the customer.',
    'login_error' => 'An error occurred during login.',
    'logout_error' => 'An error occurred during logout.',
    'refresh_error' => 'Could not refresh the token.',
];