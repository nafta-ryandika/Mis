<div class="container">
    <!-- Outer Row -->
    <div class="row justify-content-center">

        <div class="col-lg-6">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg">
                            <div class="p-5">
                                <div class="text-center">
                                    <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;" src="<?= base_url('assets/'); ?>img/logo_mmp.png" alt="...">
                                </div>
                                <div class="text-center">
                                    <b style="font-size: 32px;">Web</b><a style="font-size: 30px;"> Information System</a>
                                </div>
                                <?= $this->session->flashdata('message'); ?>
                                <form class="user" method="post" action="<?= base_url('auth/changePassword'); ?>">
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user" id="inPassword1" name="inPassword1" placeholder="Password">
                                        <?= form_error('inPassword1', '<small class="text-danger pl-3">', '</small>') ?>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user" id="inPassword2" name="inPassword2" placeholder="Repeat Password">
                                        <?= form_error('inPassword2', '<small class="text-danger pl-3">', '</small>') ?>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                        Change Password
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>