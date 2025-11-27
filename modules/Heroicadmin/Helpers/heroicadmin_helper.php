<?php

if (! function_exists('user_id')) {
    /**
     * Provide codeigniter4/authentitication-implementation.
     * Get the unique identifier for a current user.
     *
     * @param string|null $guard
     *
     * @return int|string|null
     */
    function user_id()
    {
        return session()->get('user_id');
    }
}

function urlScope()
{
    return trim(config('Heroicadmin')->urlScope, '/');
}

function admin_url($uri = '')
{
    return site_url(trim(config('Heroicadmin')->urlScope, '/').'/'.trim($uri, '/'));
}
