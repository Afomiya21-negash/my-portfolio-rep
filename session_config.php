<?php
// Ensure no output before session start
if (ob_get_level()) ob_end_clean();

// Set secure session parameters
ini_set('session.use_only_cookies', 1);
ini_set('session.use_strict_mode', 1);
ini_set('session.cookie_httponly', 1);
ini_set('session.use_trans_sid', 0);
ini_set('session.cache_limiter', 'nocache');

// Set session cookie parameters
$currentCookieParams = session_get_cookie_params();
session_set_cookie_params(
    1800, // 30 minutes lifetime
    '/', // Path
    $currentCookieParams["domain"], // Domain
    isset($_SERVER['HTTPS']), // Secure only if HTTPS
    true // HttpOnly
);

// Start the session
session_start();

// Regenerate session ID periodically to prevent session fixation
if (!isset($_SESSION['last_regeneration'])) {
    $_SESSION['last_regeneration'] = time();
    session_regenerate_id(true);
} else if (time() - $_SESSION['last_regeneration'] > 300) {
    // Regenerate session ID every 5 minutes
    $_SESSION['last_regeneration'] = time();
    session_regenerate_id(true);
}
