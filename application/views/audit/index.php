<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row content" id="contentArea">
        <div class="col-lg">
            <div class="card shadow mt-4 mb-4">
                <!-- Card Header - Accordion -->
                <a href="#collapse" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
                    <h6 class="m-0 font-weight-bold text-primary">Parameter</h6>
                </a>
                <!-- Card Content - Collapse -->
                <div class="collapse show" id="collapse" style="">
                    <table id="tableSetting" width="100%">
                        <tr>
                            <td>
                                <div class="row col-12">
                                    <div class="col-12 m-2">
                                        <div class="form-group row">
                                            <div class="col-4">
                                                <select class="form-control" id="inAuditaction" style="width: 100%;" onchange="set(this,'')">
                                                    <option value="" disabled selected hidden>Action</option>
                                                    <?php
                                                    foreach ($audit_action as $data_audit_action) :
                                                        echo "<option value='" . $data_audit_action["id"] . "'>" . $data_audit_action["action"] . "</option>";
                                                    endforeach;
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-2">
                                                <a class="btn btn-success col-6" id="btnSet" title="Set" onclick="set()">Set</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="card shadow mt-4 mb-4 formArea" id="form1" style="display: none;">
                <div class="row col-12 mt-2 mb-2">
                    <div class="col-12 form-group m-2">
                        <form id="uploadForm" enctype="multipart/form-data">
                            <div class="d-flex flex-wrap align-items-center">
                                <div class="col-4 custom-file mr-2" style="flex: 1 1 auto; min-width: 250px;">
                                    <input type="file" class="custom-file-input" id="inFile1" name="file" accept=".xls,.xlsx">
                                    <label class="custom-file-label" for="inFile1">Choose file</label>
                                </div>

                                <button type="submit" class="col-1 btn btn-success ml-2" id="btnPreview" title="Preview">Preview</button>
                                <button class="col-1 btn btn-success ml-2" id="btnUpload" title="Upload">Upload</button>

                                <button type="button" class="col-1 btn btn-secondary ml-2" id="btnTemplate" title="Template">Template</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card shadow mt-4 mb-4 formArea" id="form2" style="display: none;">
                <div class="row col-12 mt-2 mb-2 fromArea">
                    <div class="col-12 form-group m-2">
                        <div class="d-flex flex-wrap align-items-center">
                            <button class="col-1 btn btn-success ml-2" id="btnSync" title="Sync">Sync</button>
                        </div>
                    </div>
                </div>
            </div>


            <?= form_error('inMenu', '<div class="alert alert-danger role="alert">', '</div>'); ?>
            <?= $this->session->flashdata('message'); ?>

            <div class="card shadow mt-4 mb-4 viewArea" style="display:none">
                <!-- Card Header - Accordion -->
                <a href="#collapse2" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
                    <h6 class="m-0 font-weight-bold text-primary">View Data</h6>
                </a>
                <!-- Card Content - Collapse -->
                <div class="collapse show" id="collapse2" style="">
                    <div class="card-body">
                        <div class="content" id="tableArea">
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
<div class="modal fade" id="modalAdd" tabindex="-1" aria-labelledby="modalDetaillabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" style="max-width: 60% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDetaillabel">Vote</h5>
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
                                    <div class="col-sm-8 h6 mb-0 font-weight-bold text-gray-800" id="txtId"></div>
                                </div>
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="row col mr-2">
                                    <div class="col-sm-4 h6 font-weight-bold text-primary text-uppercase mb-1">Name</div>
                                    <div class="col-sm-8 h6 mb-0 font-weight-bold text-gray-800" id="txtName"></div>
                                </div>
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="row col mr-2">
                                    <div class="col-sm-4 h6 font-weight-bold text-primary text-uppercase mb-1">Department</div>
                                    <div class="col-sm-8 h6 mb-0 font-weight-bold text-gray-800" id="txtDepartment"></div>
                                </div>
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="row col mr-2">
                                    <div class="col-sm-4 h6 font-weight-bold text-primary text-uppercase mb-1">Division</div>
                                    <div class="col-sm-8 h6 mb-0 font-weight-bold text-gray-800" id="txtDivision"></div>
                                </div>
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="row col mr-2">
                                    <div class="col-sm-4 h6 font-weight-bold text-primary text-uppercase mb-1">Position</div>
                                    <div class="col-sm-8 h6 mb-0 font-weight-bold text-gray-800" id="txtPosition"></div>
                                </div>
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="card shadow mb-4 mt-4">
                                    <div class="card-header py-4 text-center">
                                        <h6 class="m-0 font-weight-bold text-primary">Candidate</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row" id="viewCandidate">

                                        </div>
                                    </div>
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