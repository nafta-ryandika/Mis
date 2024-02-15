<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row content" id="contentArea">
        <div class="col-lg">
            <div class="content col-lg-4 offset-lg-4" id="inputArea">
                <input type="text" name="inId" class="form-control" id="inId" placeholder="ID / ID Card" style="text-align: center;" autofocus>
            </div>

            <?= form_error('inMenu', '<div class="alert alert-danger role="alert">', '</div>'); ?>
            <?= $this->session->flashdata('message'); ?>
            <div class="content" id="btnArea">
            </div>
            <div class="card shadow mt-4 mb-4">
                <!-- Card Header - Accordion -->
                <a href="#collapseCardExample" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
                    <h6 class="m-0 font-weight-bold text-primary">View Data</h6>
                </a>
                <!-- Card Content - Collapse -->
                <div class="collapse show" id="collapseCardExample" style="">
                    <div class="card-body">
                        <div class="content" id="tableArea">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- Modal -->
<div class="modal fade" id="modalAdd" tabindex="-1" aria-labelledby="modalAddlabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAddlabel">Add Menu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label for="inId" class="col-sm-3 col-form-label">ID</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" id="inId">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inName" class="col-sm-3 col-form-label">Name</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="inName">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inDepartment" class="col-sm-3 col-form-label">Department</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="inDepartment">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inDivision" class="col-sm-3 col-form-label">Division</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="inDivision">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inPosition" class="col-sm-3 col-form-label">Position</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="inPosition">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inNecessity" class="col-sm-3 col-form-label">Necessity</label>
                    <div class="col-sm-9">
                        <select class="form-control select2" style="width: 100%;" id="inNecessity">
                            <option value="">Select</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inRemark" class="col-sm-3 col-form-label">Remark / Destination</label>
                    <div class="col-sm-9">
                        <textarea type="text" class="form-control" id="inRemark"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-md col-2" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary btn-md col-2">Save</button>
            </div>
        </div>
    </div>
</div>