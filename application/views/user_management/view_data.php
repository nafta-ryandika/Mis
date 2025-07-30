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
            <th scope="col">Department</th>
            <th scope="col">Division</th>
            <th scope="col">Role</th>
            <th scope="col">Email</th>
            <th scope="col">Image</th>
            <th scope="col">Status</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 1;
        foreach ($user as $data_user) :
        ?>
            <tr>
                <td scope="row"><?= $i ?></td>
                <td><?= $data_user['user_id']; ?></td>
                <td><?= $data_user['name']; ?></td>
                <td><?= $data_user['department']; ?></td>
                <td><?= $data_user['division']; ?></td>
                <td><?= $data_user['role']; ?></td>
                <td><?= $data_user['email']; ?></td>
                <td><?= $data_user['image']; ?></td>
                <td>
                    <?php

                    $status = $data_user['status'];

                    if ($status == 0) {
                        echo "<text style='color : red;'>";
                    } else if ($status == 1) {
                        echo "<text style='color : green;'>";
                    } else {
                        echo "<text>";
                    }

                    echo ($data_user['status_name']);

                    echo "</text>";
                    ?>
                </td>
                <td>
                    <a class="btn btn-info m-1" id="btnDetail" title="Detail" onclick="get('detail','<?= $data_user['id']; ?>','')"><i class="fas fa-fw fa-solid fa-eye m-1"></i></a>
                    <a class="btn btn-warning m-1" id="btnEdit" title="Edit" onclick="get('edit','<?= $data_user['id']; ?>','')"><i class="fas fa-fw fa-solid fa-pen-to-square m-1"></i></a>
                    <a class="btn btn-danger m-1" id="btnDelete" title="Delete" onclick="remove('data','<?= $data_user['id']; ?>')"><i class="fas fa-fw fa-solid fa-square-xmark m-1"></i></a>
                    <a class="btn btn-success m-1" id="btnReset" title="Reset Password" onclick="remove('password','<?= $data_user['id']; ?>')"><i class="fas fa-fw fa-solid fa-retweet m-1"></i></a>
                </td>
            </tr>
        <?php
            $i++;
        endforeach;
        ?>
    </tbody>
</table>