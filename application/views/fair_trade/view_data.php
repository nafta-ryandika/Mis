<style>
    td.nowrap-column {
        white-space: nowrap
    }
</style>

<table class="table table-hover" id="dataTable">
    <thead>
        <tr>
            <th scope="col" style="text-align: center;">#</th>
            <th scope="col" style="text-align: center;">ID</th>
            <th scope="col" style="text-align: center;">Name</th>
            <th scope="col" style="text-align: center;">Department</th>
            <th scope="col" style="text-align: center;">Section</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 1;
        foreach ($collection as $data_collection) :
        ?>
            <tr>
                <td scope="row" style="text-align: center;"><?= $i ?></td>
                <td style="text-align: center;"><?= $data_collection['id']; ?></td>
                <td><?= $data_collection['Nama_Kry']; ?></td>
                <td><?= $data_collection['Nama_Dept']; ?></td>
                <td><?= $data_collection['Nama_Sec']; ?></td>
            </tr>
        <?php
            $i++;
        endforeach;
        ?>
    </tbody>
</table>