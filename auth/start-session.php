<?php
ini_set('session.cache_limiter', 'private_no_expire');
session_cache_limiter(false);
if (!isset($_SESSION)) {
    session_start();
}
