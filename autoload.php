<?php
spl_autoload_register(function ($class) {
    include 'src/models/'. strtolower($class) . '.php';
});
