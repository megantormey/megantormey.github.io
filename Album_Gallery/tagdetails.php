<?php include("includes/init.php");

$feedback = array();
$message = array();

// remove the tag from albums

if (isset($_POST['tag_delete_button'])) {
  $id = htmlspecialchars($_GET['id']);

  $get_tag = exec_sql_query($db, "SELECT * FROM tags WHERE id= $id")->fetchALL(PDO::FETCH_ASSOC);

  $any_albums = exec_sql_query($db, "SELECT * FROM album_tags WHERE tag_id = $id");
  if (!empty($any_albums)) {
    $tag_relation_deleted = exec_sql_query($db, "DELETE FROM album_tags WHERE tag_id = $id")->fetchAll(PDO::FETCH_ASSOC);
  }

  array_push($feedback, "This tag has been successfully removed from these albums.  Click above to return to gallery page.");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <title>Album Gallery</title>

  <link rel="stylesheet" type="text/css" href="styles/site.css" media="all" />
  <script src="scripts/jquery-3.4.1.min.js" type="text/javascript"></script>
  <script src="scripts/sitejs.js" type="text/javascript"></script>
</head>

<body>

  <p class="return"><a class="return" href=index.php>
      <--</a> Return to <a class="return" href=index.php>gallery page
    </a></p>
  <?php

  foreach ($feedback as $feed) {
    echo "<p class= \"return \">" . htmlspecialchars($feed) . "<p>\n";
  }

  ?>

  <div class=tag_details_all>
    <div class="tag_and_delete">
      <div>
        <?php
        // display clicked tag
        $vart = htmlspecialchars($_GET['id']);

        $clicked_tag_sql = "SELECT * FROM tags WHERE id= :var";
        $clicked_tag_params = array(
          ':var' => $vart
        );
        $clicked_tag_records = exec_sql_query($db, $clicked_tag_sql, $clicked_tag_params)->fetchAll();

        if (count($clicked_tag_records) > 0) {
          foreach ($clicked_tag_records as $clicked_tag_record) {
            echo "<div class= \"tag_for_img\"><p>" . htmlspecialchars($clicked_tag_record['tag']) . "</p>";
          }
        }
        ?>
      </div>

      <!-- menu button with tag deletion options -->
      <div class="all_menu">
        <div>
          <button type="button" id="tag_menu_button"> ... </button>
        </div>

        <div id="menu_toggle">
          <div class="delete_but">
            <button type="button" id="pop_up_tag_delete">Remove tag from albums!</button>
          </div>
          <div class="delete_form">
            <form action="tagdetails.php?id=<?php echo $vart; ?>" method="post" id="tag_delete_form">

              <div>
                <button name="tag_delete_button" type="submit" id="tag_delete_button">Confirm remove</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="spec_album_wrap">
      <?php
      // display all corresponding albums
      $vari = htmlspecialchars($_GET['id']);

      $image_with_tag_sql = "SELECT albums.id, albums.file_name, albums.file_ext, albums.album_title, albums.artist FROM albums INNER JOIN album_tags ON albums.id = album_tags.album_id WHERE album_tags.tag_id = :var";
      $image_with_tag_params = array(
        ':var' => $vari
      );
      $images_with_tag_records = exec_sql_query($db, $image_with_tag_sql, $image_with_tag_params)->fetchAll(PDO::FETCH_ASSOC);


      if (count($images_with_tag_records) > 0) {
        foreach ($images_with_tag_records as $images_with_tag_record) {
          $in_album_query = array(
            'id' => htmlspecialchars($images_with_tag_record['id'])
          );

          echo "<div class=\" matching_albums \"><a href=\"details.php?" . http_build_query($in_album_query) . "\"><img src=\"uploads/albums/" . $images_with_tag_record["id"] . "." . $images_with_tag_record['file_ext'] . "\" class = \"gal_img_class\" alt=\"" . $images_with_tag_record["album_title"] . $images_with_tag_record["artist"] . "\"></a></div>";
        }
      } else {
        array_push($message, "Couldn't find any albums for the tag you are looking for.  Return to gallery page and add this tag to an album.");
      }
      ?>

    </div>
  </div>
  <?php
  foreach ($message as $mess) {
    echo "<p class= \"return \">" . htmlspecialchars($mess) . "<p>\n";
  }
  ?>

</body>

</html>
