<?php

/**
 * Default Settings values
 */
class Setting
{
    public function getSiteName()
    {
        return "STCMWA";
    }

    public function getUrl()
    {
        return "http://localhost:" . $_SERVER['SERVER_PORT'] . "/stcmwa/";
    }

    public function redirect($url)
    {

        ob_start();
        if (!headers_sent()) {
            header("Location: " . $this->getUrl() . $url);
        }
        ob_end_flush();
        die();
        exit();
    }
}
