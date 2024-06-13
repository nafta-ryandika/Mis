<?php
$xyz = date('YmmddHis');

if ($title == 'Menu Management') {
    echo '<script type="text/javascript" src="' . base_url("assets/js/") . 'menu.js?version=' . $xyz . '"></script>';
} else if ($title == 'Submenu Management') {
    echo '<script type="text/javascript" src="' . base_url("assets/js/") . 'submenu.js?version=' . $xyz . '"></script>';
} else if ($title == 'Role Access') {
    echo '<script type="text/javascript" src="' . base_url("assets/js/") . 'role_access.js?version=' . $xyz . '"></script>';
} else if ($title == 'Role') {
    echo '<script type="text/javascript" src="' . base_url("assets/js/") . 'role.js?version=' . $xyz . '"></script>';
} else if ($title == 'Exit Permit') {
    echo '<script type="text/javascript" src="' . base_url("assets/js/") . 'exit_permit.js?version=' . $xyz . '"></script>';
} else if ($title == 'Report Exit Permit') {
    echo '<script type="text/javascript" src="' . base_url("assets/js/") . 'report_exit_permit.js?version=' . $xyz . '"></script>';
} else if ($title == 'User') {
    echo '<script type="text/javascript" src="' . base_url("assets/js/") . 'user.js?version=' . $xyz . '"></script>';
} else if ($title == 'Vote') {
    echo '<script type="text/javascript" src="' . base_url("assets/js/") . 'vote.js?version=' . $xyz . '"></script>';
}
