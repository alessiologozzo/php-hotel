<?php

$hotels = [

  [
    'name' => 'Hotel Belvedere',
    'description' => 'Hotel Belvedere Descrizione',
    'parking' => true,
    'vote' => 4,
    'distance_to_center' => 10.4
  ],
  [
    'name' => 'Hotel Futuro',
    'description' => 'Hotel Futuro Descrizione',
    'parking' => true,
    'vote' => 2,
    'distance_to_center' => 2
  ],
  [
    'name' => 'Hotel Rivamare',
    'description' => 'Hotel Rivamare Descrizione',
    'parking' => false,
    'vote' => 1,
    'distance_to_center' => 1
  ],
  [
    'name' => 'Hotel Bellavista',
    'description' => 'Hotel Bellavista Descrizione',
    'parking' => false,
    'vote' => 5,
    'distance_to_center' => 5.5
  ],
  [
    'name' => 'Hotel Milano',
    'description' => 'Hotel Milano Descrizione',
    'parking' => true,
    'vote' => 2,
    'distance_to_center' => 50
  ],

];

$indexes = array();

if (!empty($_GET["voteFilter"])) {
  $voteFilter = $_GET["voteFilter"];

  if (!empty($_GET["parkingFilter"]))
    $parkingFilter = $_GET["parkingFilter"];

  for ($i = 0; $i < count($hotels); $i++)
    if ($hotels[$i]["vote"] >= $voteFilter && isset($parkingFilter) && $hotels[$i]["parking"])
      array_push($indexes, $i);
    else if($hotels[$i]["vote"] >= $voteFilter && !isset($parkingFilter))
      array_push($indexes, $i);

}
else
  for($i = 0; $i < count($hotels); $i++)
    array_push($indexes, $i);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <link rel="stylesheet" href="./css/style.css">
  <title>PHP Hotel</title>
</head>

<body>
  <div class="container">
    <h1 class="text-center pt-2">PHP Hotel</h1>

    <div class="d-flex justify-content-center justify-content-md-end py-4">
      <form action="index.php" method="GET" class="d-flex justify-content-center align-items-center gap-2 al-border mb-2">

        <label for="vote-filter">Stelle minime</label>
        <select name="voteFilter" id="vote-filter" class="me-4">
          <option value="1" selected>1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
        </select>

        <label for="parking-filter">Parcheggio incluso</label>
        <input type="checkbox" name="parkingFilter" id="parking-filter" class="me-4 mt-1">

        <input type="submit" value="Filtra">
      </form>
    </div>
    <table class="table table-dark table-striped">
      <thead>
        <tr>
          <th scope="col">Nome</th>
          <th scope="col">Stelle</th>
          <th scope="col">Parcheggio</th>
          <th scope="col">Km dal centro</th>
          <th scope="col">Descrizione</th>
        </tr>
      </thead>
      <tbody>

        <?php
          if(count($indexes) < 1){
            echo
            "<tr>
              <td colspan='5' class='text-center'> Nessun Hotel soddisfa i criteri di ricerca</td>
            </tr>";
          }

          for ($i = 0; $i < count($indexes); $i++) {
            $name = $hotels[$indexes[$i]]["name"];
            $vote = $hotels[$indexes[$i]]["vote"];

            $parking = $hotels[$indexes[$i]]["parking"];
            if($parking == 1)
              $parking = "Si";
            else
              $parking = "No";

            $center = $hotels[$indexes[$i]]["distance_to_center"];
            $description = $hotels[$indexes[$i]]["description"];

            echo
              "<tr>
                <th scope='row'>$name</th>
                <td>$vote</td>
                <td>$parking</td>
                <td>$center</td>
                <td>$description</td>
              </tr>";
        }
        ?>
      </tbody>
    </table>
  </div>

  <script>
    let voteButton = document.getElementById("vote-filter");
    let parkingButton = document.getElementById("parking-filter");

    let voteFilter = <?php 
      if(isset($voteFilter))
        echo(json_encode($voteFilter));
      else
        echo(json_encode(null));
    ?>

    let parkingFilter = <?php 
      if(isset($parkingFilter))
        echo(json_encode(true));
      else
        echo(json_encode(null));
    ?>

    if(voteFilter != null)
      voteButton.value = voteFilter;

    if(parkingFilter != null)
      parkingButton.checked = true;
      
  </script>
</body>

</html>