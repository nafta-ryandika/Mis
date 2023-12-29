<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <h5>Role : <?= $role['role']; ?></h5>

    <div class="row">
        <div class="col-lg">

            <?= $this->session->flashdata('message'); ?>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Menu</th>
                        <th scope="col">Access</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    foreach ($menu as $data_menu) :
                    ?>
                        <tr>
                            <th scope="row"><?= $i ?></th>
                            <td><?= $data_menu['menu']; ?></td>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" <?= checkAccess($role['id'], $data_menu['id']); ?> data-role="<?= $role['id'] ?>" data-menu=" <?= $data_menu['id'] ?> ">
                                </div>
                            </td>
                        </tr>
                    <?php
                        $i++;
                    endforeach;
                    ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->