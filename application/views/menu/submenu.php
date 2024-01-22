<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col-lg">
            <?php if (validation_errors()) : ?>
                <div class="alert alert-danger role=" alert">
                    <?= validation_errors() ?>
                </div>
            <?php endif; ?>

            <?= $this->session->flashdata('message'); ?>

            <button class="btn btn-success btn-md mb-3" data-toggle="modal" data-target="#modalAdd"><i class="fa-solid fa-square-plus mr-2"></i>Add New</button>

            <table class="table table-hover" id="dataTable">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Title</th>
                        <th scope="col">Menu</th>
                        <th scope="col">Url</th>
                        <th scope="col">icon</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    foreach ($submenu as $data_submenu) :
                    ?>
                        <tr>
                            <td scope="row"><?= $i ?></td>
                            <td><?= $data_submenu['title']; ?></td>
                            <td><?= $data_submenu['menu']; ?></td>
                            <td><?= $data_submenu['url']; ?></td>
                            <td><?= $data_submenu['icon']; ?></td>
                            <td><?= $data_submenu['status']; ?></td>
                            <td>
                                <a class="btn btn-warning" onclick="getData(<?= $data_submenu['id'] ?>)"><i class="fa-solid fa-pen-to-square m-1"></i><text class="col-md">Edit</text></a>
                                <a class="btn btn-danger" href="<?= base_url('menu/delete?') . 'delete=submenu&id=' . $data_submenu['id'] ?>" onclick="return confirm('Delete data ?')"><i class="fa-solid fa-square-xmark m-1"></i>Delete</a>
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
                <h5 class="modal-title" id="modalAddlabel">Add Submenu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('menu/submenu') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" id="inTitle" name="inTitle" placeholder="Submenu Name">
                    </div>
                    <div class="form-group">
                        <select name="inMenu_id" id="inMenu_id" class="form-control">
                            <option value="">Select</option>
                            <?php foreach ($menu as $data_menu) : ?>
                                <option value="<?= $data_menu['id'] ?>"><?= $data_menu['menu'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="inUrl" name="inUrl" placeholder="Submenu Url">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="inIcon" name="inIcon" placeholder="Submenu Icon">
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" name="inStatus" id="inStatus" checked>
                            <label class="form-check-label" for="defaultCheck1">
                                Active ?
                            </label>
                        </div>
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