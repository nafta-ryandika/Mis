<table class="table table-hover" id="dataTable">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">ID</th>
            <th scope="col">Name</th>
            <th scope="col">Company</th>
            <th scope="col">Department</th>
            <th scope="col">Division</th>
            <th scope="col">Position</th>
            <th scope="col">Date IN</th>
            <th scope="col">Time IN</th>
            <th scope="col">Date OUT</th>
            <th scope="col">Time OUT</th>
            <th scope="col">Necessity</th>
            <th scope="col">Remark</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 1;
        foreach ($exit_permit as $data_exit_permit) :
        ?>
            <tr>
                <td scope="row"><?= $i ?></td>
                <td><?= $data_exit_permit['employee_id']; ?></td>
                <td><?= $data_exit_permit['name']; ?></td>
                <td><?= $data_exit_permit['company']; ?></td>
                <td><?= $data_exit_permit['department']; ?></td>
                <td><?= $data_exit_permit['division']; ?></td>
                <td><?= $data_exit_permit['position']; ?></td>
                <td><?= $data_exit_permit['date_out']; ?></td>
                <td><?= $data_exit_permit['time_out']; ?></td>
                <td><?= $data_exit_permit['date_in']; ?></td>
                <td><?= $data_exit_permit['time_in']; ?></td>
                <td><?= $data_exit_permit['necessity']; ?></td>
                <td><?= $data_exit_permit['remark']; ?></td>
                <td>
                    <a class="btn btn-warning" data-toggle="modal" data-target="#modalAdd" onclick="getData()"><i class="fa-solid fa-pen-to-square m-1"></i><text class="col-md">Edit</text></a>
                    <a class="btn btn-danger" href="<?= base_url('menu/delete?') . 'delete=menu&id=' ?>" onclick="return confirm('Delete data ?')"><i class="fa-solid fa-square-xmark m-1"></i>Delete</a>
                </td>
            </tr>
        <?php
            $i++;
        endforeach;
        ?>
    </tbody>
</table>