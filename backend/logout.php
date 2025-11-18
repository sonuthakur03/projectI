<?php
session_start();
session_unset();
session_destroy();

// Redirect to login page in frontend
header("Location: /projectI/index.php?page=loginPage");
exit();
