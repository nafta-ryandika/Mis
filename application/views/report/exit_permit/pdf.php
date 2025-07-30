<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title_pdf; ?></title>
    <style>
        table {
            border-collapse: collapse;
        }

        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
            background-color: transparent;
        }

        .table th,
        .table td {
            padding: 0.75rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
        }

        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #dee2e6;
        }

        .table tbody+tbody {
            border-top: 2px solid #dee2e6;
        }

        .table-bordered {
            border: 1px solid #dee2e6;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid #dee2e6;
        }

        .table-bordered thead th,
        .table-bordered thead td {
            border-bottom-width: 2px;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid #dee2e6 !important;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.05);
        }

        header {
            position: fixed;
            left: 0px;
            right: 0px;
            height: 60px;
            margin-top: 60px;
        }

        /* footer{
        position: fixed;
        left: 0px;
        right: 0px;
        height: 50px;
        margin-bottom: -50px;
      } */
    </style>
</head>

<body>
    <table class="table table-bordered table-striped" style="page-break-inside: auto !important;">
        <thead>
            <tr>
                <th scope="col">No</th>
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
            foreach ($exit_permit as $data_exit_permit) {
                echo '<tr>';
                echo '<td>' . $i . '</td>';
                echo '<td style="text-align: center;">' . $data_exit_permit['employee_id'] . '</td>';
                echo '<td style="text-align: center;">' . $data_exit_permit['name'] . '</td>';
                echo '<td>' . $data_exit_permit['company'] . '</td>';
                echo '<td>' . $data_exit_permit['department'] . '</td>';
                echo '<td>' . $data_exit_permit['division'] . '</td>';
                echo '<td>' . $data_exit_permit['position'] . '</td>';
                echo '<td>' . $data_exit_permit['date_out'] . '</td>';
                echo '<td>' . $data_exit_permit['time_out'] . '</td>';
                echo '<td>' . $data_exit_permit['date_in'] . '</td>';
                echo '<td>' . $data_exit_permit['time_in'] . '</td>';
                echo '<td>' . $data_exit_permit['necessity'] . '</td>';
                echo '<td>' . $data_exit_permit['remark'] . '</td>';
                echo '<td>' . $data_exit_permit['status_name'] . '</td>';
                echo '</tr>';
                $i++;
            }
            ?>
        </tbody>
    </table>
</body>

</html>