<style>
    td.nowrap-column {
        white-space: nowrap
    }
</style>

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
            <th scope="col">Date OUT</th>
            <th scope="col">Time OUT</th>
            <th scope="col">Date IN</th>
            <th scope="col">Time IN</th>
            <th scope="col">Necessity</th>
            <th scope="col">Remark</th>
            <th scope="col">Status</th>
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
                    <?php

                    $status = $data_exit_permit['status'];

                    if ($status == 0) {
                        echo "<text style='color : orange;'>";
                    } else if ($status == 1) {
                        echo "<text style='color : green;'>";
                    } else if ($status == 2) {
                        echo "<text style='color : red;'>";
                    } else {
                        echo "<text>";
                    }

                    echo ($data_exit_permit['status_name']);

                    echo "</text>";
                    ?>
                </td>
            </tr>
        <?php
            $i++;
        endforeach;
        ?>
    </tbody>
</table>