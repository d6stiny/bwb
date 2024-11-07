<?php
require_once 'controllers/Auth.php';
$auth = new AuthController();
$auth->logout();