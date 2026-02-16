<?php

return [
    'singular' => 'User',
    'plural' => 'Users',
    'roles' => [
        'admin' => 'Admin',
        'warehouse_manager' => 'Warehouse Manager',
        'receiver' => 'Receiver',
        'compliance_officer' => 'Compliance Officer',
    ],
    'fields' => [
        'name' => 'Name',
        'email' => 'Email Address',
        'password' => 'Password',
        'warehouse' => 'Warehouse',
        'phone' => 'Phone Number',
        'role' => 'Role',
        'created_at' => 'Created At',
        'updated_at' => 'Updated At',
        'email_verified_at' => 'Email Verified At',
    ],
    'sections' => [
        'user_details' => 'User Details',
        'security' => 'Security',
    ],
    'actions' => [
        'create' => 'Create User',
    ],
];
