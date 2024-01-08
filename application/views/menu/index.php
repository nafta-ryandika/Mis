<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col-lg">

            <?= form_error('inMenu', '<div class="alert alert-danger role="alert">', '</div>'); ?>
            <?= $this->session->flashdata('message'); ?>
            <button class="btn btn-success btn-md mb-3" data-toggle="modal" data-target="#modalAdd"><i class="fa-solid fa-square-plus mr-2"></i>Add New</button>
            <table class="table table-hover" id="dataTable">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Menu</th>
                        <th scope="col">Action</th>
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
                                <!-- <div class="class row">
                                    div.class
                                </div> -->
                                <div class="btn-group col-lg row" role="group">
                                    <a class="btn btn-warning btn-md btn-block" data-toggle="modal" data-target="#modalAdd" onclick="getData('<?= $data_menu['id']; ?>','<?= $data_menu['menu']; ?>')"><i class="fa-solid fa-pen-to-square mr-4"></i>Edit</a>
                                    <a class="btn btn-danger btn-md btn-block" href="<?= base_url('menu/delete?') . 'delete=menu&id=' . $data_menu['id'] ?>" onclick="return confirm('Delete data ?')"><i class="fa-solid fa-square-xmark mr-2"></i>Delete</a>
                                    <!-- <div class="col-md-6 custom">
                                        <button type="button" class="btn btn-sm btn-secondary">Edit</button>
                                    </div>
                                    <div class="col-md-6 custom">
                                        <form action="" method="POST">
                                            <button type="button" class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </div> -->
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

<!-- Modal -->
<div class="modal fade" id="modalAdd" tabindex="-1" aria-labelledby="modalAddlabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAddlabel">Add Menu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('menu') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" id="inMenu" name="inMenu" placeholder="Menu Name">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-md col-2" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-md col-2">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>