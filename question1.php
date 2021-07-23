<?php include "includes/header.php" ?>

<body>
    <!--back to home(question) page --->
    <ul>
        <li><a href="index.php">Home</a></li>
    </ul>
    <div>
        <!-- To display polling units for user to select -->
        <form method="post">
            <select name="polling_unit">
                <option style="font-weight: bold">Select a polling unit</option>
                <?php
                //get polling unit name from database
                $displayResult = $connection->query("SELECT polling_unit_name FROM polling_unit") or die("Connection Failed" . mysqli_connect_error());

                while ($row = $displayResult->fetch_assoc()) {
                    $polling_unit_name = $row["polling_unit_name"];
                    // $polling_unit_uniqueid = $row["uniqueid"];

                    echo "<option value='$polling_unit_name'>  $polling_unit_name </option>";
                }

                ?>
            </select>
            <input type="submit" name="submit" value=" See Result" />
        </form>

        <!--<div> -->
        <?php

        if (isset($_POST['submit'])) {
            $polling_unit_uniqueid = "";
            $selected = $_POST['polling_unit'];
            echo "Selected = " . $selected;
            echo "<br/>";
            $uniqueid = $connection->query("SELECT uniqueid FROM polling_unit WHERE polling_unit_name = '$selected'") or die("Connection Failed" . mysqli_connect_error());

            while ($row = $uniqueid->fetch_assoc()) {
                //$polling_unit_name = $row["polling_unit_name"];
                $polling_unit_uniqueid = $row["uniqueid"];

                echo "uniqueid = " . $polling_unit_uniqueid;
                echo "<br/>";
            }

            $pu_result = $connection->query("SELECT party_abbreviation, party_score
                        FROM announced_pu_results
                        INNER JOIN polling_unit
                        ON polling_unit.uniqueid = announced_pu_results.polling_unit_uniqueid
                        WHERE announced_pu_results.polling_unit_uniqueid = '$polling_unit_uniqueid'") or
                die("Connection Failed" . mysqli_connect_error());


        ?>
            <table class="table">
                <!--table-striped  thead-light -->
                <thead class="table_thead">
                    <tr>
                        <!--<th scope="col">Id</th> from hidden input with name and id="code" -->
                        <th scope="col">Party</th>
                        <th scope="col">Party Score</th>
                    </tr>
                </thead>
                <?php while ($row = $pu_result->fetch_assoc()) : ?>
                    <tbody>
                        <tr>
                            <td><?php echo $row['party_abbreviation']; ?></td>
                            <td><?php echo $row['party_score']; ?></td>
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