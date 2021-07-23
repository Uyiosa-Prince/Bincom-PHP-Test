<?php include "includes/header.php" ?>

<body>
    <!--back to home(question) page --->
    <ul>
        <li><a href="index.php">Home</a></li>
    </ul>
    <div>
        <!-- Form to get user selections -->
        <form method="post">
            <!-- To display polling units for user to select -->
            <select name="polling_unit" required>
                <option style="font-weight: bold">Select a polling unit</option>
                <?php
                //get polling unit name from database
                $displayResult = $connection->query("SELECT polling_unit_name FROM polling_unit") or
                    die("Connection Failed" . mysqli_connect_error());

                while ($row = $displayResult->fetch_assoc()) {
                    $polling_unit_name = $row["polling_unit_name"];
                    // $polling_unit_uniqueid = $row["uniqueid"];

                    echo "<option value='$polling_unit_name'>  $polling_unit_name </option>";
                }

                ?>
            </select>

            <!-- To display party name for user to select -->
            <select name="party" required>
                <option style="font-weight: bold">Select party</option>
                <?php
                //get party name from database
                $display_party = $connection->query("SELECT partyname FROM party") or
                    die("Connection Failed" . mysqli_connect_error());

                while ($row = $display_party->fetch_assoc()) {
                    $part_name = $row["partyname"];

                    echo "<option value='$part_name'>  $part_name </option>";
                }

                ?>
            </select>

            <!-- input for user to enter and save party score -->
            <input type="number" name="party_score" id="party_score" value="Enter Party Score" required />

            <input type="submit" name="submit" value=" Save" />
        </form>



        <!--<div> -->
        <?php

        if (isset($_POST['submit'])) {
            $polling_unit_uniqueid = "";
            $selected_pu = $_POST['polling_unit'];
            $selected_party = $_POST['party'];
            $party_score = $_POST['party_score'];
            $partyid = "";

            $date = date('d-m-Y');
            $ip_address = $_SERVER['REMOTE_ADDR'];

            //Display polling unit name and unique id
            echo "Selected polling unit = " . $selected_pu;
            echo "<br/>";
            $uniqueid = $connection->query("SELECT uniqueid FROM polling_unit WHERE polling_unit_name = '$selected_pu'") or die("Connection Failed" . mysqli_connect_error());

            while ($row = $uniqueid->fetch_assoc()) {
                $polling_unit_uniqueid = $row["uniqueid"];

                echo "uniqueid = " . $polling_unit_uniqueid;
                echo "<br/>";
            }
            //Display party name and id
            echo "Selected party = " . $selected_party;
            echo "<br/>";
            $get_partyid = $connection->query("SELECT partyid FROM party WHERE partyname = '$selected_party'") or die("Connection Failed" . mysqli_connect_error());

            while ($row = $get_partyid->fetch_assoc()) {
                $partyid = $row["partyid"];

                echo "party id = " . $partyid;
                echo "<br/>";
            }
            echo "party score = " . $party_score;
            echo "<br/>";


            // insert the the party score into the database
            // I USED 'NDOKWA' to test NEW DATABASE input with unqueid = 109;
            // I USED 'SEIMBIRI' as my NEW DATABASE with unqueid = 108;
            $query = "SELECT * FROM announced_pu_results WHERE 
                polling_unit_uniqueid = '$polling_unit_uniqueid' AND party_abbreviation = '$partyid'";

            $check_db = mysqli_query($connection,  $query);

            $num_rows = mysqli_num_rows($check_db);

            if ($row == 1) {
                echo "<div>ERROR: Score already entered, kindly confirm or overwrite! </div>";
            } else {
                $add_score = "INSERT INTO announced_pu_results (polling_unit_uniqueid, party_abbreviation, party_score, date_entered, user_ip_address) 
                        VALUES('$polling_unit_uniqueid', '$partyid', '$party_score', '$date', '$ip_address')";
                mysqli_query($connection,  $add_score);
                echo "Result saved successfully!";
            }
        }

        ?>

    </div>

</body>