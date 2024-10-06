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
    'profile_retrieved_successfully' => 'Profile retrieved successfully.',
    'profile_retrieval_failed' => 'Failed to retrieve profile: :error',
    'profile_updated_successfully' => 'Profile updated successfully.',
    'profile_update_failed' => 'Failed to update profile: :error',
    'account_deleted_successfully' => 'Customer account deleted successfully.',
    'account_deletion_failed' => 'Failed to delete account: :error',
    'customer_not_found' => 'Customer not found.',
    'customer_retrieved_successfully' => 'Customer retrieved successfully.',
    'customer_retrieval_failed' => 'Failed to retrieve customer: :error',
    'validation_errors' => 'Validation errors occurred.',
];
