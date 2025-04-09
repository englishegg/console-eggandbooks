<?php

// -------------------------------------------------------------
// Load Route Files from app/Routes/*.php
// -------------------------------------------------------------
$routesPath = APPPATH . 'Routes';

foreach (glob("$routesPath/*.php") as $routeFile) {
    require $routeFile;
}
