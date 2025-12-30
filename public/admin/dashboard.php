<?php
require_once '../../src/Middlewares/AuthMiddleware.php';
Middlewares\AuthMiddleware::checkRole('admin');
include '../../src/Views/admin/dashboard.php';
?>