<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row content" id="contentArea">
        <div class="col-lg">
            <div class="content" id="btnArea">
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
                                                    <option value="dt1.employee_id">Employee ID</option>
                                                    <option value="dt2.name">Name</option>
                                                    <option value="dt4.department">Department</option>
                                                    <option value="dt5.division">Division</option>
                                                    <option value="dt1.date_out">Date OUT</option>
                                                    <option value="TIME_FORMAT(dt1.time_out, '%H:%i')">Time OUT</option>
                                                    <option value="dt1.date_in">Date IN</option>
                                                    <option value="TIME_FORMAT(dt1.time_in, '%H:%i')">Time IN</option>
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
                                                    <!-- <a class="dropdown-item" href="#" onclick="report('pdf2','exitPermit')">PDF (FRM-SKR-039 REV.01) </a> -->
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