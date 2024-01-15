<?php
if ($title == 'Menu Management') {
?>
    <script type="text/javascript" src="<?= base_url('assets/js/') . 'menu.js'; ?>"></script>
<?php
} else if ($title == 'Submenu Management') {
    echo '<script type="text/javascript" src="' . base_url("assets/js/") . 'submenu.js"></script>';
?>

<?php
}
