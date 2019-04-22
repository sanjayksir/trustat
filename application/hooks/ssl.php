<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function force_ssl() {
    $server=$_SERVER["SERVER_NAME"];
    $uri=$_SERVER["REQUEST_URI"];
    if ($_SERVER['HTTPS'] == 'off') {
        redirect("https://{$server}{$uri}");
    }
}