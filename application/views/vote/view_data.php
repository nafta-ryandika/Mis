<style>
    td.nowrap-column {
        white-space: nowrap
    }
</style>

<table class="table table-hover" id="dataTable">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Total</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 1;
        foreach ($vote as $data_vote) :
        ?>
            <tr>
                <td scope="row"><?= $i ?></td>
                <td><?= $data_vote['name']; ?></td>
                <td><?= $data_vote['total']; ?></td>
            </tr>
        <?php
            $i++;
        endforeach;
        ?>
    </tbody>
</table>