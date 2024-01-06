    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5 col-lg-7 mx-auto">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                            </div>
                            <form class="user" method="post" action="<?= base_url('auth/registration') ?>">
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" id="inUserid" name="inUserid" placeholder="User Id" value="<?= set_value('inUserid') ?>">
                                    <?= form_error('inUserid', '<small class="text-danger pl-3">', '</small>') ?>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" id="inUser" name="inUser" placeholder="User Name" value="<?= set_value('inUser') ?>">
                                    <?= form_error('inUser', '<small class="text-danger pl-3">', '</small>') ?>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" id="inEmail" name="inEmail" placeholder="Email Address" value="<?= set_value('inEmail') ?>">
                                    <?= form_error('inEmail', '<small class="text-danger pl-3">', '</small>') ?>
                                </div>
                                <!-- <div class="form-group">
                                    <input type="text" class="form-control form-control-user" id="inImage" name="inImage" placeholder="User Image">
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" id="inDepartment" name="inDepartment" placeholder="Department">
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" id="inDivision" name="inDivision" placeholder="Division">
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" id="inRole" name="inRole" placeholder="Role">
                                </div> -->
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" class="form-control form-control-user" id="inPassword1" name="inPassword1" placeholder="Password">
                                        <?= form_error('inPassword1', '<small class="text-danger pl-3">', '</small>') ?>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password" class="form-control form-control-user" id="inPassword2" name="inPassword2" placeholder="Repeat Password">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                    Register Account
                                </button>
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="<?= base_url('auth/forgotPassword') ?>">Forgot Password?</a>
                            </div>
                            <div class="text-center">
                                <a class="small" href="<?= base_url('auth') ?>">Already have an account? Login!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>