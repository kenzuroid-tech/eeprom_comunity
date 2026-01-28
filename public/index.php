<?php

session_start();

$requestUri = $_SERVER['REQUEST_URI'];
$path = parse_url($requestUri, PHP_URL_PATH);

$staticExtensions = ['css', 'js', 'png', 'jpg', 'jpeg', 'gif', 'svg', 'ico', 'woff', 'woff2', 'ttf', 'eot', 'map', 'html'];

$extension = pathinfo($path, PATHINFO_EXTENSION);
if ($extension && in_array(strtolower($extension), $staticExtensions)) {
    if (file_exists(__DIR__ . $path) && is_file(__DIR__ . $path)) {
        return false;
    }
}

require_once __DIR__ . '/../vendor/autoload.php';

use App\Router;
use App\Controllers\HomeController;
use App\Controllers\ActivityController;
use App\Controllers\MemberController;
use App\Controllers\ContactController;
use App\Controllers\LoginController;
use App\Controllers\RecruitmentController;
use App\Controllers\ProductController;
use App\Controllers\DelegateController;

// Member Controllers
use App\Controllers\Member\DashboardController as MemberDashboard;
use App\Controllers\Member\ProfileController as MemberProfile;
use App\Controllers\Member\GalleryController as MemberGallery;
use App\Controllers\Member\AttendanceController as MemberAttendance;
use App\Controllers\Member\AnnouncementController as MemberAnnouncement;
use App\Controllers\Member\VotingController as MemberVoting;
use App\Controllers\Member\DocumentController as MemberDocument;
use App\Controllers\Member\ForumController as MemberForum;
use App\Controllers\Member\SettingController as MemberSetting;
use App\Controllers\Alumni\AlumniController as AlumniController;

// Admin Controllers
use App\Controllers\Admin\DashboardController as AdminDashboard;
use App\Controllers\Admin\MemberController as AdminMember;
use App\Controllers\Admin\DivisionController as AdminDivision;
use App\Controllers\Admin\RecruitmentController as AdminRecruitment;
use App\Controllers\Admin\MeetingController as AdminMeeting;
use App\Controllers\Admin\AnnouncementController as AdminAnnouncement;
use App\Controllers\Admin\ActivitiesController as AdminActivities;
use App\Controllers\Admin\VotingController as AdminVoting;
use App\Controllers\Admin\DocumentController as AdminDocument;
use App\Controllers\Admin\GalleryController as AdminGallery;
use App\Controllers\Admin\ForumController as AdminForum;
use App\Controllers\Admin\ContactController as AdminContact;
use App\Controllers\Admin\AboutController as AdminAbout;
use App\Controllers\Admin\AchievementsController as AdminAchievement;
use App\Controllers\Admin\SettingsController as AdminSettings;
use App\Controllers\Admin\AdminProductController as AdminProduct;

// Middlewares
use App\Middlewares\GuestMiddleware;
use App\Middlewares\MemberMiddleware;
use App\Middlewares\AdminMiddleware;

$router = new Router();

$router->get("/check-nim", \App\Controllers\LoginController::class, "checkNim");
$router->post("/register", \App\Controllers\LoginController::class, "register");

$router->get("/products", ProductController::class, "index");
$router->get("/products/detail", ProductController::class, "detail");
$router->get("/products/cart", ProductController::class, "cart");
$router->get('/products/orders', ProductController::class, 'orders');
$router->get('/products/order-detail', ProductController::class, 'orderDetail');
$router->post("/products/add-to-cart", ProductController::class, "addToCart");
$router->post("/products/update-cart", ProductController::class, "updateCart");
$router->post('/products/remove-from-cart', ProductController::class, 'removeFromCart');
$router->get('/products/checkout', ProductController::class, 'checkout');
$router->post('/products/checkout', ProductController::class, 'checkout');


$router->get("/form", \App\Controllers\RecruitmentController::class, "showForm");
$router->post("/form/submit", \App\Controllers\RecruitmentController::class, "submit");
$router->get("/form/success", \App\Controllers\RecruitmentController::class, "success");
$router->get("/profile", \App\Controllers\MemberController::class, "showProfile");


// ==========================================
// 1. PUBLIC & AUTH ROUTES
// ==========================================
$router->get("/", HomeController::class, "index");
$router->get("/home", HomeController::class, "index");
$router->get("/activity", ActivityController::class, "index");
$router->get("/member", MemberController::class, "index");
$router->get("/member-profile", MemberController::class, "profile");
$router->get("/contact", ContactController::class, "index");
$router->post("/contact/submit", ContactController::class, "submit");
$router->get("/login", LoginController::class, "index")->middleware(GuestMiddleware::class);
$router->post("/login", LoginController::class, "authenticate");
$router->get("/logout", LoginController::class, "logout");

$router->get("/register", LoginController::class, "showRegister");
$router->get("/forgot-password", LoginController::class, "showForgot");


// Delegate Routes
$router->get('/delegate/login', \App\Controllers\Delegate\DelegateController::class, 'login');
$router->post('/delegate/authenticate', \App\Controllers\Delegate\DelegateController::class, 'authenticate');
$router->get('/delegate/voting', \App\Controllers\Delegate\DelegateController::class, 'voting');
$router->post('/delegate/submit-vote', \App\Controllers\Delegate\DelegateController::class, 'submitVote');
$router->get('/delegate/logout', \App\Controllers\Delegate\DelegateController::class, 'logout');
$router->post('/delegate/process-login', \App\Controllers\Delegate\DelegateController::class, 'processLogin');
$router->get('/delegate/enter-code', \App\Controllers\Delegate\DelegateController::class, 'accessCode');
$router->post('/delegate/verify-code', \App\Controllers\Delegate\DelegateController::class, 'verifyCode');
$router->get('/delegate/voting', \App\Controllers\Delegate\DelegateController::class, 'voting');
$router->post('/delegate/submit-vote', \App\Controllers\Delegate\DelegateController::class, 'submitVote');
$router->get('/delegate/logout', \App\Controllers\Delegate\DelegateController::class, 'logout');
$router->get('/delegate/back-to-login', \App\Controllers\Delegate\DelegateController::class, 'backToLogin');

//Alumni Routes
$router->get('/alumni/login', AlumniController::class, 'login');
$router->post('/alumni/process-login', AlumniController::class, 'processLogin');
$router->get('/alumni/vote', AlumniController::class, 'vote');
$router->post('/alumni/submit-vote', AlumniController::class, 'submitVote');
$router->get('/alumni/logout', AlumniController::class, 'logout');
$router->get('/alumni/enter-code', AlumniController::class, 'accessCode');
$router->post('/alumni/verify-code', AlumniController::class, 'verifyCode');
$router->get('/alumni/back-to-login', AlumniController::class, 'backToLogin');

// ==========================================
// 2. MEMBER ROUTES (Protected)
// ==========================================
$router->get("/member/dashboard", MemberDashboard::class, "index")->middleware(MemberMiddleware::class);

// Profile & Settings
$router->get("/member/profile", MemberProfile::class, "index")->middleware(MemberMiddleware::class);
$router->get("/member/profile/edit", MemberProfile::class, "edit")->middleware(MemberMiddleware::class);
$router->post("/member/profile/update", MemberProfile::class, "update")->middleware(MemberMiddleware::class);
$router->get('/member/setting', MemberSetting::class, 'index')->middleware(MemberMiddleware::class);
$router->post('/member/setting/update', MemberSetting::class, 'update')->middleware(MemberMiddleware::class);

// Features
$router->get('/member/gallery', MemberGallery::class, 'index')->middleware(MemberMiddleware::class);
$router->get('/member/attendance', MemberAttendance::class, 'index')->middleware(MemberMiddleware::class);
$router->get('/member/documents', MemberDocument::class, 'index')->middleware(MemberMiddleware::class);

// Announcements
$router->get('/member/announcements', MemberAnnouncement::class, 'index')->middleware(MemberMiddleware::class);
$router->get('/member/announcements/detail', MemberAnnouncement::class, 'detail')->middleware(MemberMiddleware::class);

// Voting
// Voting
$router->get('/member/voting', MemberVoting::class, 'index')->middleware(MemberMiddleware::class);
$router->post('/member/voting/submit', MemberVoting::class, 'submit')->middleware(MemberMiddleware::class);
$router->get('/member/voting/enter-code', MemberVoting::class, 'enterCode')->middleware(MemberMiddleware::class);
$router->post('/member/voting/verify-code', MemberVoting::class, 'verifyCode')->middleware(MemberMiddleware::class);

// Forum
$router->get('/member/forum', MemberForum::class, 'index')->middleware(MemberMiddleware::class);
$router->get('/member/forum/create', MemberForum::class, 'create')->middleware(MemberMiddleware::class);
$router->get('/member/forum/detail', MemberForum::class, 'detail')->middleware(MemberMiddleware::class);
$router->post('/member/forum/store', MemberForum::class, 'store')->middleware(MemberMiddleware::class);
$router->post('/member/forum/comment', MemberForum::class, 'storeComment')->middleware(MemberMiddleware::class);


// ==========================================
// 3. ADMIN ROUTES (Protected)
// ==========================================
$router->get("/admin", AdminDashboard::class, "index")->middleware(AdminMiddleware::class);

// Member & Division Management
$router->get("/admin/members", AdminMember::class, "index")->middleware(AdminMiddleware::class);
$router->get('/admin/members/create', AdminMember::class, 'create')->middleware(AdminMiddleware::class);
$router->get('/admin/members/edit', AdminMember::class, 'edit')->middleware(AdminMiddleware::class);
$router->post('/admin/members/store', AdminMember::class, 'store')->middleware(AdminMiddleware::class);
$router->post('/admin/members/update', AdminMember::class, 'update')->middleware(AdminMiddleware::class);
$router->get('/admin/members/delete', AdminMember::class, 'delete')->middleware(AdminMiddleware::class);
$router->post('/admin/members/reset-password', \App\Controllers\Admin\MemberController::class, 'resetPassword');
$router->post('/admin/members/bulkAlumni', \App\Controllers\Admin\MemberController::class, 'bulkAlumni');
$router->post('/admin/members/bulkHapus', \App\Controllers\Admin\MemberController::class, 'bulkHapus');

//Product Management
$router->get('/admin/products', AdminProduct::class, 'adminIndex')->middleware(AdminMiddleware::class);
$router->post('/admin/products/store', AdminProduct::class, 'store')->middleware(AdminMiddleware::class);
$router->get('/admin/products/edit', AdminProduct::class, 'edit')->middleware(AdminMiddleware::class);
$router->post('/admin/products/update', AdminProduct::class, 'update')->middleware(AdminMiddleware::class);
$router->get('/admin/products/delete', AdminProduct::class, 'delete')->middleware(AdminMiddleware::class);

// Order Management
$router->get('/admin/orders', \App\Controllers\Admin\AdminOrderController::class, 'index');
$router->get('/admin/orders/detail', \App\Controllers\Admin\AdminOrderController::class, 'detail');
$router->post('/admin/orders/update-status', \App\Controllers\Admin\AdminOrderController::class, 'updateStatus');

//Divisions
$router->get('/admin/divisions', AdminDivision::class, 'index')->middleware(AdminMiddleware::class);
$router->get('/admin/divisions/edit', AdminDivision::class, 'edit')->middleware(AdminMiddleware::class);
$router->post('/admin/divisions/update', AdminDivision::class, 'update')->middleware(AdminMiddleware::class);

// Recruitment
$router->get('/admin/recruitment', AdminRecruitment::class, 'index')->middleware(AdminMiddleware::class);
$router->get('/admin/recruitment/applicants', AdminRecruitment::class, 'applicants')->middleware(AdminMiddleware::class);
$router->get('/admin/recruitment/applicant/detail', AdminRecruitment::class, 'applicantDetail')->middleware(AdminMiddleware::class);
$router->get('/admin/recruitment/create', AdminRecruitment::class, 'create')->middleware(AdminMiddleware::class);
$router->get('/admin/recruitment/edit', AdminRecruitment::class, 'edit')->middleware(AdminMiddleware::class);
$router->post('/admin/recruitment/store', AdminRecruitment::class, 'store')->middleware(AdminMiddleware::class);
$router->post('/admin/recruitment/update', AdminRecruitment::class, 'update')->middleware(AdminMiddleware::class);
$router->get('/admin/recruitment/delete', AdminRecruitment::class, 'delete')->middleware(AdminMiddleware::class);

// Meetings & Attendance
$router->get('/admin/meetings', AdminMeeting::class, 'index')->middleware(AdminMiddleware::class);
$router->get('/admin/meetings/create', AdminMeeting::class, 'create')->middleware(AdminMiddleware::class);
$router->get('/admin/meetings/notulensi', AdminMeeting::class, 'notulensi')->middleware(AdminMiddleware::class);
$router->get('/admin/meetings/notulensi/create', \App\Controllers\Admin\MeetingController::class, 'createNotulensi')->middleware(AdminMiddleware::class);
$router->post('/admin/meetings/notulensi/store', \App\Controllers\Admin\MeetingController::class, 'storeNotulensi')->middleware(AdminMiddleware::class);
$router->post('/admin/meetings/store', AdminMeeting::class, 'store')->middleware(AdminMiddleware::class);

$router->get('/admin/attendance', AdminMeeting::class, 'index')->middleware(AdminMiddleware::class);
$router->get('/admin/attendance/input', AdminMeeting::class, 'attendanceInput')->middleware(AdminMiddleware::class);
$router->get('/admin/attendance/scan', AdminMeeting::class, 'attendanceInput')->middleware(AdminMiddleware::class);
$router->post('/admin/attendance/update', AdminMeeting::class, 'attendanceUpdate')->middleware(AdminMiddleware::class);
$router->get('/admin/meetings', AdminMeeting::class, 'index')->middleware(AdminMiddleware::class);
$router->get('/scan/(\d+)', AdminMeeting::class, 'scan');
$router->get('/scan', AdminMeeting::class, 'scan');
$router->get('/admin/attendance', AdminMeeting::class, 'index')->middleware(AdminMiddleware::class);

// Content & Communication
$router->get('/admin/announcements', AdminAnnouncement::class, 'index')->middleware(AdminMiddleware::class);
$router->get('/admin/announcements/create', AdminAnnouncement::class, 'create')->middleware(AdminMiddleware::class);
$router->get('/admin/announcements/edit', AdminAnnouncement::class, 'edit')->middleware(AdminMiddleware::class);
$router->post('/admin/announcements/store', AdminAnnouncement::class, 'store')->middleware(AdminMiddleware::class);
$router->post('/admin/announcements/update', AdminAnnouncement::class, 'update')->middleware(AdminMiddleware::class);
$router->get('/admin/announcements/delete', AdminAnnouncement::class, 'delete')->middleware(AdminMiddleware::class);

$router->get('/admin/activities', AdminActivities::class, 'index')->middleware(AdminMiddleware::class);
$router->get('/admin/activities/create', AdminActivities::class, 'create')->middleware(AdminMiddleware::class);
$router->post('/admin/activities/store', AdminActivities::class, 'store')->middleware(AdminMiddleware::class);

// Voting (Election)
$router->get('/admin/voting', AdminVoting::class, 'index')->middleware(AdminMiddleware::class);
$router->get('/admin/voting/create', AdminVoting::class, 'create')->middleware(AdminMiddleware::class);
$router->get('/admin/voting/candidates', AdminVoting::class, 'candidates')->middleware(AdminMiddleware::class);
$router->get('/admin/voting/results', AdminVoting::class, 'results')->middleware(AdminMiddleware::class);
$router->get('/admin/voting/candidates/delete', AdminVoting::class, 'deleteCandidate')->middleware(AdminMiddleware::class);
$router->post('/admin/voting/reset', AdminVoting::class, 'resetVotes')->middleware(AdminMiddleware::class);
$router->post('/admin/voting/candidates/store', AdminVoting::class, 'storeCandidate')->middleware(AdminMiddleware::class);
$router->post('/admin/voting/store-election', AdminVoting::class, 'storeElection')->middleware(AdminMiddleware::class);
$router->get('/admin/voting/access-codes', AdminVoting::class, 'accessCodes')->middleware(AdminMiddleware::class);
$router->post('/admin/voting/generate-delegate-code', AdminVoting::class, 'generateDelegateCode')->middleware(AdminMiddleware::class);
$router->get('/admin/voting/delete-code', AdminVoting::class, 'deleteCode')->middleware(AdminMiddleware::class);
$router->get('/admin/voting/export-codes', AdminVoting::class, 'exportCodes')->middleware(AdminMiddleware::class);
$router->get('/admin/voting/print-vouchers', AdminVoting::class, 'printVouchers');

// Static Content & Misc
$router->get('/admin/about', AdminAbout::class, 'index')->middleware(AdminMiddleware::class);
$router->post('/admin/about/update', AdminAbout::class, 'update')->middleware(AdminMiddleware::class);

$router->post('/admin/about/update-vision', AdminAbout::class, 'updateVision')->middleware(AdminMiddleware::class);
$router->post('/admin/about/update-mission', AdminAbout::class, 'updateMission')->middleware(AdminMiddleware::class);
$router->post('/admin/about/update-motto', AdminAbout::class, 'updateMotto')->middleware(AdminMiddleware::class);

$router->get('/admin/achievement', AdminAchievement::class, 'index')->middleware(AdminMiddleware::class);
$router->post('/admin/achievement/store', AdminAchievement::class, 'store')->middleware(AdminMiddleware::class);
$router->get('/admin/achievement/delete', AdminAchievement::class, 'delete')->middleware(AdminMiddleware::class);

$router->get('/admin/documents', AdminDocument::class, 'index')->middleware(AdminMiddleware::class);
$router->get('/admin/gallery', AdminGallery::class, 'index')->middleware(AdminMiddleware::class);
$router->get('/admin/forum', AdminForum::class, 'index')->middleware(AdminMiddleware::class);
$router->get('/admin/forum/detail', \App\Controllers\Admin\ForumController::class, 'detail')->middleware(AdminMiddleware::class);
$router->get('/admin/forum/create', AdminForum::class, 'create')->middleware(AdminMiddleware::class);
$router->get('/admin/forum/detail', AdminForum::class, 'detail')->middleware(AdminMiddleware::class);
$router->get('/admin/forum/delete', AdminForum::class, 'delete')->middleware(AdminMiddleware::class);
$router->post('/admin/forum/store', \App\Controllers\Admin\ForumController::class, 'store')->middleware(AdminMiddleware::class);

// Contacts
$router->get('/admin/contacts', AdminContact::class, 'index')->middleware(AdminMiddleware::class);
$router->post('/admin/contacts/update-main', AdminContact::class, 'updateMain')->middleware(AdminMiddleware::class);
$router->post('/admin/contacts/save-cp', AdminContact::class, 'saveCP')->middleware(AdminMiddleware::class);
$router->get('/admin/contacts/delete-cp', AdminContact::class, 'deleteCP')->middleware(AdminMiddleware::class);

// Settings
$router->get('/admin/settings', AdminSettings::class, 'index')->middleware(AdminMiddleware::class);
$router->post('/admin/settings/update', AdminSettings::class, 'update')->middleware(AdminMiddleware::class);

// Dispatch
$router->dispatch();
