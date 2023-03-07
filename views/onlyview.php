<html>

<head>
  <?php require_once("components/header.php"); ?>
</head>

<body>

  <?php

  // Numele fișierului CSV
  $file = 'data/concurentiTimp.csv';

  // Deschide fișierul CSV pentru citire
  if (($handle = fopen($file, "r")) !== FALSE) {

    // Crează tabelul HTML
    echo "<table class='table table-striped'>\n";

    // Loop prin fiecare linie din fișierul CSV
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

      // Crează un rând de tabel HTML pentru această linie
      echo "<tr>";

      // Loop prin fiecare coloană din linie
      foreach ($data as $cell) {

        // Adaugă fiecare valoare într-o celulă de tabel
        echo "<td>" . htmlspecialchars($cell) . "</td>";

      }

      // Închide rândul de tabel
      echo "</tr>\n";

    }

    // Închide tabelul HTML
    echo "</table>\n";

    // Închide fișierul CSV
    fclose($handle);

  }

  ?>
</body>

</html>