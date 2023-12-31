<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col-lg-6">
            <?= $this->session->flashdata('message'); ?>
            <form action="<?= base_url('user/changepassword') ?>" method="post">
                <div class="form-group">
                    <label for="currentPassword">Current Password</label>
                    <input type="password" class="form-control" id="inCurrentpassword" name="inCurrentpassword">
                    <?= form_error('inCurrentpassword', '<small class="text-danger pl-3">', '</small>') ?>
                </div>
                <div class="form-group">
                    <label for="newPassword1">New Password</label>
                    <input type="password" class="form-control" id="inNewpassword1" name="inNewpassword1">
                    <?= form_error('inNewpassword1', '<small class="text-danger pl-3">', '</small>') ?>
                </div>
                <div class="form-group">
                    <label for="newPassword2">Repeat Password</label>
                    <input type="password" class="form-control" id="inNewpassword2" name="inNewpassword2">
                    <?= form_error('inNewpassword2', '<small class="text-danger pl-3">', '</small>') ?>
                </div>
                <div class="class formgroup">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->