<?php

session_start();

// 1. Skip routing untuk file statis
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
if (file_exists(__DIR__ . $path) && is_file(__DIR__ . $path)) {
    return false;
}

// 2. Load Autoloader
require_once __DIR__ . '/../vendor/autoload.php';

use App\Router;
use App\Controllers\HomeController;
use App\Controllers\LoginController;

// Member Controllers//
use App\Controllers\Member\DashboardController as MemberDashboardController;
use App\Controllers\Member\ProfileController as MemberProfileController;
use App\Controllers\Member\GalleryController as MemberGalleryController;
use App\Controllers\Member\AttendanceController as MemberAttendanceController;
use App\Controllers\Member\AnnouncementController as MemberAnnouncementsController;
use App\Controllers\Member\VotingController as MemberVotingController;
use App\Controllers\Member\DocumentController as MemberDocumentController;
use App\Controllers\Member\ForumController as MemberForumController;

//Admin Controllers//
use App\Controllers\Admin\DashboardController as DashboardController;
use App\Controllers\Admin\MemberController as MemberController;
use App\Controllers\Admin\DivisionController as DivisionController;
use App\Controllers\Admin\RecruitmentController as RecruitmentController;

use App\Middlewares\GuestMiddleware;
use App\Middlewares\MemberMiddleware;

$router = new Router();

// ===== PUBLIC ROUTES =====
$router->get("/", HomeController::class, "index");
$router->get("/home", HomeController::class, "index");

// ===== AUTH ROUTES =====
$router->get("/login", LoginController::class, "index")
    ->middleware(GuestMiddleware::class);

$router->post("/login", LoginController::class, "authenticate");

$router->get("/register", LoginController::class, "showRegister");
$router->get("/forgot-password", LoginController::class, "showForgot");

// Tambahkan logout
$router->get("/logout", LoginController::class, "logout");

// ===== MEMBER ROUTES =====
$router->get("/member/dashboard", MemberDashboardController::class, "index")
    ->middleware(MemberMiddleware::class);

$router->get("/member/profile", MemberProfileController::class, "index")
    ->middleware(MemberMiddleware::class);

$router->get("/member/profile/edit", MemberProfileController::class, "edit");
    // ->middleware(MemberMiddleware::class);

$router->post("/member/profile/update", MemberProfileController::class, "update");
    // ->middleware(MemberMiddleware::class);

// Tambahkan ini di bagian rute GET
$router->get('/member/gallery', App\Controllers\Member\GalleryController::class, 'index');
    // ->middleware(MemberMiddleware::class);

$router->get('/member/attendance', App\Controllers\Member\AttendanceController::class, 'index');
    // ->middleware(MemberMiddleware::class);

$router->get('/member/announcements', App\Controllers\Member\AnnouncementController::class, 'index');
    // ->middleware(MemberMiddleware::class);

$router->get('/member/announcements/detail', \App\Controllers\Member\AnnouncementController::class, 'detail');
    // ->middleware(MemberMiddleware::class);

$router->get('/member/voting', App\Controllers\Member\VotingController::class, 'index');
    // ->middleware(MemberMiddleware::class);
$router->post('/member/voting/submit', \App\Controllers\Member\VotingController::class, 'submit');
    // ->middleware(MemberMiddleware::class);

$router->get('/member/documents', \App\Controllers\Member\DocumentController::class, 'index');
    // ->middleware(MemberMiddleware::class);

$router->get('/member/forum', \App\Controllers\Member\ForumController::class, 'index');
    // ->middleware(MemberMiddleware::class);

$router->post('/member/forum/store', MemberForumController::class, 'store');
    // ->middleware(MemberMiddleware::class);

$router->get('/member/forum/create', MemberForumController::class, 'create');
    // ->middleware(MemberMiddleware::class);

$router->get('/member/forum/detail', MemberForumController::class, 'detail');
    // ->middleware(MemberMiddleware::class);

// Tambahkan di bawah rute /member/forum/store
$router->post('/member/forum/comment', \App\Controllers\Member\ForumController::class, 'storeComment');
    // ->middleware(MemberMiddleware::class);

// ===== ADMIN ROUTES =====
$router->get("/admin/dashboard", DashboardController::class, "index")
    ->middleware(MemberMiddleware::class);

$router->get("/admin/members", MemberController::class, "index")
    ->middleware(MemberMiddleware::class);

$router->get('/admin/members/edit', \App\Controllers\Admin\MemberController::class, 'edit');
    // ->middleware(MemberMiddleware::class);

$router->post('/admin/members/update', \App\Controllers\Admin\MemberController::class, 'update');
    // ->middleware(MemberMiddleware::class);

$router->get('/admin/members/create', \App\Controllers\Admin\MemberController::class, 'create');
    // ->middleware(MemberMiddleware::class);

$router->get('/admin/divisions', \App\Controllers\Admin\DivisionController::class, 'index');
    // ->middleware(MemberMiddleware::class);

$router->get('/admin/divisions/edit', \App\Controllers\Admin\DivisionController::class, 'edit');
    // ->middleware(MemberMiddleware::class);

$router->post('/admin/divisions/update', \App\Controllers\Admin\DivisionController::class, 'update');
    // ->middleware(MemberMiddleware::class);

$router->get('/admin/recruitment', \App\Controllers\Admin\RecruitmentController::class, 'index');
    // ->middleware(MemberMiddleware::class);

$router->get('/admin/recruitment/applicants', \App\Controllers\Admin\RecruitmentController::class, 'applicants');
    // ->middleware(MemberMiddleware::class);

$router->get('/admin/recruitment/applicant/detail', \App\Controllers\Admin\RecruitmentController::class, 'applicantDetail');
    // ->middleware(MemberMiddleware::class);

$router->get('/admin/recruitment/create', \App\Controllers\Admin\RecruitmentController::class, 'create');
    // ->middleware(MemberMiddleware::class);

$router->post('/admin/recruitment/store', \App\Controllers\Admin\RecruitmentController::class, 'store');
    // ->middleware(MemberMiddleware::class);

// Tambahkan di bagian GET routes
$router->get('/admin/recruitment/edit', \App\Controllers\Admin\RecruitmentController::class, 'edit');
    // ->middleware(MemberMiddleware::class);

// Tambahkan di bagian POST routes
$router->post('/admin/recruitment/update', \App\Controllers\Admin\RecruitmentController::class, 'update');
    // ->middleware(MemberMiddleware::class);

$router->get('/admin/recruitment/delete', \App\Controllers\Admin\RecruitmentController::class, 'delete');
    // ->middleware(MemberMiddleware::class);
// 3. Jalankan Router
$router->dispatch();