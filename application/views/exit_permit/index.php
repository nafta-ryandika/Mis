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
                <h5 class="modal-title" id="modalAddlabel">Transaction</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="inTransaction_id" disabled>
                <div class="form-group row">
                    <label for="inId" class="col-sm-3 col-form-label">ID</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" id="inId" disabled>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inName" class="col-sm-3 col-form-label">Name</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="inName" disabled>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inDepartment" class="col-sm-3 col-form-label">Department</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="inDepartment" disabled>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inDivision" class="col-sm-3 col-form-label">Division</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="inDivision" disabled>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inPosition" class="col-sm-3 col-form-label">Position</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="inPosition" disabled>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inNecessity" class="col-sm-3 col-form-label">Necessity</label>
                    <div class="col-sm-9">
                        <select class="form-control" style="width: 100%;" id="inNecessity">
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
                <button type="submit" class="btn btn-primary btn-md col-2" id="btnSave">Save</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalUpdate" tabindex="-1" aria-labelledby="modalUpdatelabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalUpdatelabel">Transaction</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <input type="hidden" id="inTransaction_id" disabled>
                            <div class="row no-gutters align-items-center">
                                <div class="row col mr-2">
                                    <div class="col-sm-4 h6 font-weight-bold text-primary text-uppercase mb-1"></div>
                                    <div class="col-sm-8 h6 mb-0 font-weight-bold text-gray-800"></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                </div>
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="row col mr-2">
                                    <div class="col-sm-4 h6 font-weight-bold text-primary text-uppercase mb-1">ID</div>
                                    <div class="col-sm-8 h6 mb-0 font-weight-bold text-gray-800" id="inId"></div>
                                </div>
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="row col mr-2">
                                    <div class="col-sm-4 h6 font-weight-bold text-primary text-uppercase mb-1">Name</div>
                                    <div class="col-sm-8 h6 mb-0 font-weight-bold text-gray-800" id="inName"></div>
                                </div>
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="row col mr-2">
                                    <div class="col-sm-4 h6 font-weight-bold text-primary text-uppercase mb-1">Department</div>
                                    <div class="col-sm-8 h6 mb-0 font-weight-bold text-gray-800" id="inDepartment"></div>
                                </div>
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="row col mr-2">
                                    <div class="col-sm-4 h6 font-weight-bold text-primary text-uppercase mb-1">Division</div>
                                    <div class="col-sm-8 h6 mb-0 font-weight-bold text-gray-800" id="inDivision"></div>
                                </div>
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="row col mr-2">
                                    <div class="col-sm-4 h6 font-weight-bold text-primary text-uppercase mb-1">Position</div>
                                    <div class="col-sm-8 h6 mb-0 font-weight-bold text-gray-800" id="inPosition"></div>
                                </div>
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="row col mr-2">
                                    <div class="col-sm-4 h6 font-weight-bold text-primary text-uppercase mb-1">Date OUT</div>
                                    <div class="col-sm-8 h6 mb-0 font-weight-bold text-gray-800" id="inDate_out"></div>
                                </div>
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="row col mr-2">
                                    <div class="col-sm-4 h6 font-weight-bold text-primary text-uppercase mb-1">Time OUT</div>
                                    <div class="col-sm-8 h6 mb-0 font-weight-bold text-gray-800" id="inTime_out"></div>
                                </div>
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="row col mr-2">
                                    <div class="col-sm-4 h6 font-weight-bold text-primary text-uppercase mb-1">Necessity</div>
                                    <div class="col-sm-8 h6 mb-0 font-weight-bold text-gray-800" id="inNecessity"></div>
                                </div>
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="row col mr-2">
                                    <div class="col-sm-4 h6 font-weight-bold text-primary text-uppercase mb-1">Remark / Destination</div>
                                    <div class="col-sm-8 h6 mb-0 font-weight-bold text-gray-800" id="inRemark"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-md col-2" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary btn-md col-2" id="btnSave">Save</button>
                <button type="submit" class="btn btn-success btn-md col-2" id="btnNew">New</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalDetail" tabindex="-1" aria-labelledby="modalDetaillabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDetaillabel">Detail Transaction</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="row col mr-2">
                                    <div class="col-sm-4 h6 font-weight-bold text-primary text-uppercase mb-1"></div>
                                    <div class="col-sm-8 h6 mb-0 font-weight-bold text-gray-800"></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                </div>
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="row col mr-2">
                                    <div class="col-sm-4 h6 font-weight-bold text-primary text-uppercase mb-1">ID</div>
                                    <div class="col-sm-8 h6 mb-0 font-weight-bold text-gray-800" id="inId"></div>
                                </div>
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="row col mr-2">
                                    <div class="col-sm-4 h6 font-weight-bold text-primary text-uppercase mb-1">Name</div>
                                    <div class="col-sm-8 h6 mb-0 font-weight-bold text-gray-800" id="inName"></div>
                                </div>
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="row col mr-2">
                                    <div class="col-sm-4 h6 font-weight-bold text-primary text-uppercase mb-1">Department</div>
                                    <div class="col-sm-8 h6 mb-0 font-weight-bold text-gray-800" id="inDepartment"></div>
                                </div>
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="row col mr-2">
                                    <div class="col-sm-4 h6 font-weight-bold text-primary text-uppercase mb-1">Division</div>
                                    <div class="col-sm-8 h6 mb-0 font-weight-bold text-gray-800" id="inDivision"></div>
                                </div>
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="row col mr-2">
                                    <div class="col-sm-4 h6 font-weight-bold text-primary text-uppercase mb-1">Position</div>
                                    <div class="col-sm-8 h6 mb-0 font-weight-bold text-gray-800" id="inPosition"></div>
                                </div>
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="row col mr-2">
                                    <div class="col-sm-4 h6 font-weight-bold text-primary text-uppercase mb-1">Date OUT</div>
                                    <div class="col-sm-8 h6 mb-0 font-weight-bold text-gray-800" id="inDate_out"></div>
                                </div>
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="row col mr-2">
                                    <div class="col-sm-4 h6 font-weight-bold text-primary text-uppercase mb-1">Time OUT</div>
                                    <div class="col-sm-8 h6 mb-0 font-weight-bold text-gray-800" id="inTime_out"></div>
                                </div>
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="row col mr-2">
                                    <div class="col-sm-4 h6 font-weight-bold text-primary text-uppercase mb-1">Date IN</div>
                                    <div class="col-sm-8 h6 mb-0 font-weight-bold text-gray-800" id="inDate_in"></div>
                                </div>
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="row col mr-2">
                                    <div class="col-sm-4 h6 font-weight-bold text-primary text-uppercase mb-1">Time IN</div>
                                    <div class="col-sm-8 h6 mb-0 font-weight-bold text-gray-800" id="inTime_in"></div>
                                </div>
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="row col mr-2">
                                    <div class="col-sm-4 h6 font-weight-bold text-primary text-uppercase mb-1">Necessity</div>
                                    <div class="col-sm-8 h6 mb-0 font-weight-bold text-gray-800" id="inNecessity"></div>
                                </div>
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="row col mr-2">
                                    <div class="col-sm-4 h6 font-weight-bold text-primary text-uppercase mb-1">Remark / Destination</div>
                                    <div class="col-sm-8 h6 mb-0 font-weight-bold text-gray-800" id="inRemark"></div>
                                </div>
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="row col mr-2">
                                    <div class="col-sm-4 h6 font-weight-bold text-primary text-uppercase mb-1">Created By</div>
                                    <div class="col-sm-8 h6 mb-0 font-weight-bold text-gray-800" id="inCreated_by"></div>
                                </div>
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="row col mr-2">
                                    <div class="col-sm-4 h6 font-weight-bold text-primary text-uppercase mb-1">Created At</div>
                                    <div class="col-sm-8 h6 mb-0 font-weight-bold text-gray-800" id="inCreated_at"></div>
                                </div>
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="row col mr-2">
                                    <div class="col-sm-4 h6 font-weight-bold text-primary text-uppercase mb-1">Log By</div>
                                    <div class="col-sm-8 h6 mb-0 font-weight-bold text-gray-800" id="inLog_by"></div>
                                </div>
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="row col mr-2">
                                    <div class="col-sm-4 h6 font-weight-bold text-primary text-uppercase mb-1">Log At</div>
                                    <div class="col-sm-8 h6 mb-0 font-weight-bold text-gray-800" id="inLog_at"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-md col-2" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>