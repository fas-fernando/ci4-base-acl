<?php

if (function_exists("user_logged") === false) {
    function user_logged()
    {
        return service("auth")->getUserLogged();
    }
}
