<?php
if ($title == 'Menu Management') {
    echo '<script type="text/javascript" src="' . base_url("assets/js/") . 'menu.js"></script>';
} else if ($title == 'Submenu Management') {
    echo '<script type="text/javascript" src="' . base_url("assets/js/") . 'submenu.js"></script>';
} else if ($title == 'Role Access') {
    echo '<script type="text/javascript" src="' . base_url("assets/js/") . 'role_access.js"></script>';
}
