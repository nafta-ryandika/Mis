<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-globe"></i>
        </div>
        <div class="sidebar-brand-text mx-1">Web Information System</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <?php
    $role_id = $this->session->userdata('role_id');
    $query_menu = "SELECT a.id, a.menu 
                FROM m_menu a JOIN m_access b
                ON a.id = b.menu_id
                WHERE b.role_id = $role_id 
                ORDER BY b.menu_id ASC";

    $menu = $this->db->query($query_menu)->result_array();
    ?>


    <!-- Heading -->
    <?php foreach ($menu as $data_menu) : ?>
        <div class="sidebar-heading">
            <?= $data_menu['menu'] ?>
        </div>

        <?php
        $menu_id = $data_menu['id'];
        $query_submenu = "SELECT * 
                        FROM m_submenu a JOIN m_menu b
                        ON a.menu_id = b.id 
                        WHERE a.menu_id = $menu_id AND a.status = 1";

        $submenu = $this->db->query($query_submenu)->result_array();
        ?>

        <?php foreach ($submenu as $data_submenu) : ?>
            <?php if ($title == $data_submenu['title']) : ?>
                <li class="nav-item active">
                <?php else : ?>
                <li class="nav-item">
                <?php endif; ?>
                <a class="nav-link pb-0" href="<?= base_url($data_submenu['url']) ?>">
                    <i class="<?= $data_submenu['icon'] ?>"></i>
                    <span><?= $data_submenu['title'] ?></span></a>
                </li>
            <?php endforeach; ?>

            <hr class="sidebar-divider mt-3">

        <?php endforeach; ?>

        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('auth/logout'); ?>">
                <i class="fas fa-fw fa-right-from-bracket"></i>
                <span>Logout</span></a>
        </li>

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-cog"></i>
                <span>Components</span>
            </a>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Custom Components:</h6>
                    <a class="collapse-item" href="buttons.html">Buttons</a>
                    <a class="collapse-item" href="cards.html">Cards</a>
                </div>
            </div>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

</ul>
<!-- End of Sidebar -->