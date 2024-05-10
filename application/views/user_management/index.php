<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row content" id="contentArea">
        <div class="col-lg">
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
                                    <div class="col-12 m-2">
                                        <div class="content" id="btnArea">
                                            <a class="btn btn-success col-1" id="btnAdd" title="Add" onclick="add('add','')"><i class="fas fa-fw fa-solid fa-square-plus m-1"></i>Add</a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="row col-12">
                                    <div class="col-8 m-2">
                                        <div class="form-group row">
                                            <div class="col-3">
                                                <select class="form-control inSearchcolumn" style="width: 100%;" onchange="get('searchColumn',this,'')">
                                                    <option value="">Parameter</option>
                                                    <option value="dt1.employee_id">Employee ID</option>
                                                    <option value="dt2.name">Name</option>
                                                    <option value="dt4.department">Department</option>
                                                    <option value="dt5.division">Division</option>
                                                    <option value="dt1.date_in">Date IN</option>
                                                    <option value="TIME_FORMAT(dt1.time_in, '%H:%i')">Time IN</option>
                                                    <option value="dt1.date_out">Date OUT</option>
                                                    <option value="TIME_FORMAT(dt1.time_out, '%H:%i')">Time OUT</option>
                                                    <option value="dt1.necessity_id">Necessity</option>
                                                    <option value="dt1.status">Status</option>
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
                                                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-fw fa-solid fa-file-export m-1"></i>Export
                                                </button>
                                                <div class="dropdown-menu animated--fade-in" aria-labelledby="dropdownMenuButton" style="">
                                                    <a class="dropdown-item" href="#" onclick="report('pdf','exitPermit')">PDF</a>
                                                    <a class="dropdown-item" href="#" onclick="report('excel','exitPermit')">Excel</a>
                                                </div>
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
        <div class="card shadow mt-4 mb-4">
            <!-- Card Header - Accordion -->
            <a href="#collapseCardExample1" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
                <h6 class="m-0 font-weight-bold text-primary">View Data</h6>
            </a>
            <!-- Card Content - Collapse -->
            <div class="collapse show" id="collapseCardExample1" style="">
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
<div class="modal fade" id="modalAdd" aria-labelledby="modalAddlabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAddlabel">User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formAdd">
                    <input type="hidden" class="form-control" id="inMode">
                    <input type="hidden" class="form-control" id="inIdx">
                    <div class="form-group row">
                        <label for="inId" class="col-sm-3 col-form-label">ID</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="inId" name="inId" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inName" class="col-sm-3 col-form-label">Name</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="inName" name="inName" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inDepartment" class="col-sm-3 col-form-label">Department</label>
                        <div class="col-sm-9">
                            <select class="form-control select2" style="width: 100%;" id="inDepartment" name="inDepartment" required>
                                <option value="">Select</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inDivision" class="col-sm-3 col-form-label">Division</label>
                        <div class="col-sm-9">
                            <select class="form-control select2" style="width: 100%;" id="inDivision" name="inDivision" required>
                                <option value="">Select</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inRole" class="col-sm-3 col-form-label">Role</label>
                        <div class="col-sm-9">
                            <select class="form-control" style="width: 100%;" id="inRole" name="inRole" required>
                                <option value="">Select</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inEmail" class="col-sm-3 col-form-label">Email</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="inEmail" name="inEmail">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inImage" class="col-sm-3 col-form-label">Image</label>
                        <div class="col-sm-9">
                            <div class=" custom-file">
                                <input type="file" class="custom-file-input" id="inImage" disabled>
                                <label class="custom-file-label" for="customFile">Choose file</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inPassword" class="col-sm-3 col-form-label">Password</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control" id="inPassword" name="inPassword" required>
                        </div>
                        <div class="invalid-feedback">
                            Password dont match !
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inRepeatpassword" class="col-sm-3 col-form-label">Repeat Password</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control" id="inRepeatpassword" name="inRepeatpassword" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inStatus" class="col-sm-3 col-form-label">Status</label>
                        <div class="col-sm-3">
                            <select class="form-control" style="width: 100%;" id="inStatus">
                                <option value="1">Active</option>
                                <option value="0">Not Active</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-md col-2" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary btn-md col-2" id="btnSave">Save</button>
            </div>
        </div>
    </div>
</div>