
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
    $link = "https";
} else {
    $link = "http";
}
$link .= "://";
$link .= $_SERVER['HTTP_HOST'];
$link .= $_SERVER['REQUEST_URI'];

if (!isset($_SESSION['userdata']) && !strpos($link, 'login.php')) {
    redirect('admin/login.php');
}

if (isset($_SESSION['userdata']) && strpos($link, 'login.php')) {
    redirect('admin/index.php');
}

$module = array('', 'admin', 'p_manager', 'ceo', 's_manager','driver');
$modulePaths = array('', 'admin/', 'p_manager/', 'ceo/', 's_manager','driver/'); // Define the module paths for each role

if (isset($_SESSION['userdata'])) {
    $userRole = $_SESSION['userdata']['type']; // Assuming 'role' is the field name in the users table that stores the user's role
    $moduleIndex = ($userRole >= 1 && $userRole < count($module)) ? $userRole : 0;
    $modulePath = $modulePaths[$moduleIndex];
    
    if ($modulePath !== '' && !strpos($link, $modulePath) && $_SESSION['userdata']['login_type'] != 1) {
        redirect($modulePath);
    }
}

// function redirect($url) {
//     header("Location: $url");
//     exit;
// }
?>
