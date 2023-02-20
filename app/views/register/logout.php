<?php

unset($_SESSION["id"]);
session_destroy();

header("Location: " . URLROOT . "register/login");
