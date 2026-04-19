<?php

/**
 * Role aliases mapping.
 *
 * Use easy-to-type aliases (from route middleware or UI) and map them to the
 * canonical `tbl_roles.name` values used across the application.
 */
return [
    'aliases' => [
        // canonical => canonical (optional entries)
        // normalized alias => canonical role name
        'admin' => 'Administrator',
        'administrator' => 'Administrator',
        'superadmin' => 'Super Administrator',
        'super-administrator' => 'Super Administrator',
        'super_administrator' => 'Super Administrator',
        'super administrator' => 'Super Administrator',
        'officer' => 'Officer',
        'student' => 'Student',
    ],
];
