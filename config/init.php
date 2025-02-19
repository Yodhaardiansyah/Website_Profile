<?php
if (!function_exists('base_url')) {
    function base_url($path = '') {
        return "/profile-yodha/public/" . ltrim($path, '/');
    }
}
?>
