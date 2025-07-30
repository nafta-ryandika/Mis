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
                    <div class="row col-12 m-3">
                        <table id="tableSetting" width="100%">
                            <tr>
                                <td>
                                    <div class="form-group row">
                                        <div class="col-3">
                                            <select class="form-control" id="inParameter" style="width: 100%;">
                                                <option value="">Parameter</option>
                                                <?php
                                                foreach ($collection as $data_collection) :
                                                    echo "<option value='" . $data_collection["id"] . "'>" . $data_collection["collection"] . "</option>";
                                                endforeach;
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-2">
                                            <a class="btn btn-success col-6" id="btnLock" title="Search" onclick="lock()"><i class="fas fa-fw fa-solid fa-lock-open m-1"></i>Lock</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="content col-lg-4 offset-lg-4" id="inputArea">
                <input type="text" name="inId" class="form-control" id="inId" placeholder="ID / ID Card" style="text-align: center;" autofocus>
            </div>

            <div class="card shadow mt-4 mb-4">
                <!-- Card Header - Accordion -->
                <a href="#collapseCardExample" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
                    <h6 class="m-0 font-weight-bold text-primary">Search Data</h6>
                </a>
                <!-- Card Content - Collapse -->
                <div class="collapse show" id="collapseCardExample" style="">
                    <table id="tableSearch" width="100%">
                        <tr>
                            <td>
                                <div class="row col-12">
                                    <div class="col-8 m-2">
                                        <div class="form-group row">
                                            <div class="col-3">
                                                <select class="form-control inSearchcolumn" style="width: 100%;" onchange="get('searchColumn',this,'')">
                                                    <option value="">Parameter</option>
                                                    <option value="dt1.id">ID</option>
                                                    <option value="dt2.Nama_Kry">Name</option>
                                                    <option value="dt2.Ucode_Dept">Department</option>
                                                    <option value="dt2.Ucode_Sec">Section</option>
                                                </select>
                                            </div>
                                            <div class="col-2">
                                                <select class="form-control inSearchparameter" style="width: 100%;">
                                                    <option value="=">Equal</option>
                                                    <option value="like">Like</option>
                                                </select>
                                            </div>
                                            <div class="col-5">
                                                <input type="text" class="form-control inSearchinput">
                                            </div>
                                            <div class="col-2">
                                                <a class="btn btn-success" id="btnAdd" title="Add" onclick="add('parameter',this)"><i class="fas fa-fw fa-solid fa-square-plus m-1"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-3 m-2">
                                        <div class="form-group float-right row">
                                            <a class="btn btn-info col-6" id="btnSearch" title="Search" onclick="viewData()"><i class="fas fa-fw fa-solid fa-magnifying-glass m-1"></i>Search</a>
                                            <div class="dropdown ml-2 col-1">
                                                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" disabled>
                                                    <i class="fas fa-fw fa-solid fa-file-export m-1"></i>Export
                                                </button>
                                                <div class="dropdown-menu animated--fade-in" aria-labelledby="dropdownMenuButton" style="">
                                                    <a class="dropdown-item" href="#" onclick="report('pdf','')">PDF</a>
                                                    <!-- <a class="dropdown-item" href="#" onclick="report('pdf2','exitPermit')">PDF (FRM-SKR-039 REV.01) </a> -->
                                                    <a class="dropdown-item" href="#" onclick="report('excel','')">Excel</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <?= form_error('inMenu', '<div class="alert alert-danger role="alert">', '</div>'); ?>
            <?= $this->session->flashdata('message'); ?>

            <div class="card shadow mt-4 mb-4">
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