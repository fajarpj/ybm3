<?php

if (! function_exists('auth_user')) {
    function auth_user(): ?array
    {
        $session = session();
        $user = $session->get('auth_user');

        return is_array($user) ? $user : null;
    }
}

if (! function_exists('is_logged_in')) {
    function is_logged_in(): bool
    {
        return auth_user() !== null;
    }
}

if (! function_exists('is_admin')) {
    function is_admin(): bool
    {
        return (auth_user()['role'] ?? null) === 'admin';
    }
}
