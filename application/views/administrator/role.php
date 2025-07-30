<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col-lg">

            <?= form_error('inRole', '<div class="alert alert-danger role="alert">', '</div>'); ?>
            <?= $this->session->flashdata('message'); ?>

            <button class="btn btn-success btn-md mb-3" data-toggle="modal" data-target="#modalAdd"><i class="fa-solid fa-square-plus mr-2"></i>Add New</button>

            <table class="table table-hover" id="dataTable">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Role</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    foreach ($role as $data_role) :
                    ?>
                        <tr>
                            <th scope="row"><?= $i ?></th>
                            <td><?= $data_role['role']; ?></td>
                            <td>
                                <a class="btn btn-success" href="<?= base_url('administrator/roleaccess/') . $data_role['id'] ?>"><i class="fa-solid fa-square-xmark m-1"></i>Access</a>
                                <a class="btn btn-warning" data-toggle="modal" data-target="#modalAdd" onclick="getData('<?= $data_role['id']; ?>','<?= $data_role['role']; ?>')"><i class="fa-solid fa-pen-to-square m-1"></i><text class="col-md">Edit</text></a>
                                <a class="btn btn-danger" href="<?= base_url('administrator/delete?') . 'delete=role&id=' . $data_role['id'] ?>" onclick="return confirm('Delete data ?')"><i class="fa-solid fa-square-xmark m-1"></i>Delete</a>
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
                <h5 class="modal-title" id="modalAddlabel">Add Role</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('administrator/role') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" id="inRole" name="inRole" placeholder="Role Name">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>