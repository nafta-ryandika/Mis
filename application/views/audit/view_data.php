<style>
    td.nowrap-column {
        white-space: nowrap
    }
</style>

<div class="table-responsive">
    <table class="table table-hover" id="dataTable">
        <thead>
            <tr>
                <?php
                // if ($inAuditaction == 1) {
                ?>
                <!-- <th scope="col" style="width: 10%; text-align: center;">#</th>
                <th scope="col" style="width: 90%; text-align: center;">ID</th> -->
                <?php
                // }
                ?>

                <th scope="col" style="width: 5%; text-align: center;">#</th>

                <?php
                $header = array_shift($sheetData);
                foreach ($header as $headCell) {
                ?>
                    <th scope="col" style="text-align: center;"><?= htmlspecialchars($headCell) ?></th>
                <?php
                }
                ?>

            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;
            foreach ($sheetData as $rowData) :
            ?>
                <tr>
                    <td scope="row" style="text-align: center;"><?= $i ?></td>
                    <?php foreach ($rowData as $cell): ?>
                        <td style="text-align: center;"><?= htmlspecialchars($cell) ?></td>
                    <?php endforeach; ?>
                </tr>
            <?php
                $i++;
            endforeach;
            ?>
        </tbody>
    </table>
</div>