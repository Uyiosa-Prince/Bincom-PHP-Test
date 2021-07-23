<?php include "includes/header.php" ?>

<body>
    <!--back to home(question) page --->
    <ul>
        <li><a href="index.php">Home</a></li>
    </ul>
    <div>
        <!-- To display local government area for user to select -->
        <form method="post">
            <select name="lga">
                <option style="font-weight: bold">Select LGA</option>
                <?php
                //get local government area name from database
                $displayResult = $connection->query("SELECT lga_name, uniqueid FROM lga") or die("Connection Failed" . mysqli_connect_error());

                while ($row = $displayResult->fetch_assoc()) {
                    $lga_name = $row["lga_name"];
                    // $lga_name = $row["uniqueid"];

                    echo "<option value='$lga_name'>  $lga_name </option>";
                }

                ?>
            </select>
            <input type="submit" name="submit" value=" See Result" />
        </form>

        <!--<div> -->
        <?php

        if (isset($_POST['submit'])) {
            //$lga_uniqueid = "";
            //$lga_id = "";
            $selected_lga = "";
            $selected = $_POST['lga'];

            echo "Selected = " . $selected;
            echo "<br/>";
            //$lga_uniqueid = $connection->query("SELECT uniqueid FROM lga WHERE lga_name = '$selected'") or die("Connection Failed" . mysqli_connect_error());
            $lga_id = $connection->query("SELECT lga_id FROM lga WHERE lga_name = '$selected'")
                or die("Connection Failed" . mysqli_connect_error());

            while ($row = $lga_id->fetch_assoc()) {
                //$polling_unit_name = $row["polling_unit_name"];
                $selected_lga = $row["lga_id"];

                echo "lga_id = " . $selected_lga;
                echo "<br/>";
            }

            $lga_pu_results = $connection->query("SELECT announced_pu_results.polling_unit_uniqueid, polling_unit_name, sum(party_score) as total_result
                        FROM announced_pu_results
                        INNER JOIN polling_unit
                        ON polling_unit.uniqueid = announced_pu_results.polling_unit_uniqueid
                        INNER JOIN lga
                        ON polling_unit.lga_id = lga.lga_id
                        WHERE  lga.lga_id = '$selected_lga'
                        GROUP BY announced_pu_results.polling_unit_uniqueid
                        ORDER BY lga.lga_id") or
                die("Connection Failed" . mysqli_connect_error());


        ?>
            <table class="table">
                <!--table-striped  thead-light -->
                <thead class="table_thead">
                    <tr>
                        <!--<th scope="col">Id</th> from hidden input with name and id="code" -->
                        <th scope="col">POLLING UNIT</th>
                        <th scope="col">TOTAL RESULT</th>
                    </tr>
                </thead>
                <?php while ($row = $lga_pu_results->fetch_assoc()) : ?>
                    <tbody>
                        <tr>
                            <td><?php echo $row['polling_unit_name']; ?></td>
                            <td><?php echo $row['total_result']; ?></td>
                        </tr>
                    </tbody>
            <?php endwhile;
            }
            ?>

            </table>
            <!--</div>-->
    </div>

</body>

</html>