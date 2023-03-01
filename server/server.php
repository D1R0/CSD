<?php
if (isset($_POST["command"])) {
    if (($_POST["command"]) == "write") {
        $myfile = fopen("../data/sessionPlayer.txt", "w");
        $txt = $_POST["active"];
        fwrite($myfile, $txt);
        fclose($myfile);
    }

    if ($_POST["command"] == "read") {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(getActivePlayer());
    }
    if ($_POST["command"] == "timp") {
        // Define the variables
        $row_identifier = getActivePlayer();
        $last_column_value = $_POST["timp"];
        echo replace_value("../data/concurentiTimp.csv", $row_identifier, $last_column_value);
    }
}
function getActivePlayer()
{
    $fileName = "../data/sessionPlayer.txt";
    $myfile = fopen($fileName, "r") or die("Unable to open file!");
    $player = fread($myfile, filesize($fileName));
    fclose($myfile);
    return $player;
}
function replace_value($csv_file, $row_identifier, $new_value) {
    // Create a temporary file
    $temp_file = tempnam(sys_get_temp_dir(), 'csv');
  
    // Open the CSV file using SplFileObject
    $file = new SplFileObject($csv_file, 'r');
  
    // Open the temporary file using SplFileObject
    $temp = new SplFileObject($temp_file, 'w');
  
    // Loop through each row in the file
    while (!$file->eof()) {
      // Get the current row as an array of values
      $row = $file->fgetcsv();
  
      // Check if the row identifier matches
      if ($row[0] == $row_identifier) {
        // Modify the value in the row array
        $row[5] = $new_value;
      }
  
      // Write the row to the temporary file
      $temp->fputcsv($row);
    }
  
    // Close both files
    $file = null;
    $temp = null;
  
    // Replace the original file with the temporary file
    unlink($csv_file);
    rename($temp_file, $csv_file);
  
    // Return true to indicate success
    return true;
  }
  