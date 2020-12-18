


<?php

spl_autoload_register(function ($class_name) {
    require 'app/models/' . $class_name . '.php';
});