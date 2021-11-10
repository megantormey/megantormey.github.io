<?php include("includes/init.php");

$feedback = array();

// Get the list of current tags in the database
$current_tags = exec_sql_query($db, "SELECT tag FROM tags", NULL)->fetchAll(PDO::FETCH_COLUMN);

// Get the list of current album titles in the database
$current_albums = exec_sql_query($db, "SELECT album_title FROM albums", NULL)->fetchAll(PDO::FETCH_COLUMN);

// Add tag form



if (isset($_POST['add_tag_submit'])) {
  $valid_tag = TRUE;


  $id = htmlspecialchars($_REQUEST['id']);

  // filter inputs
  $new_tag_name = filter_input(INPUT_POST, 'new_tag_name', FILTER_SANITIZE_STRING);
  $existing_tag_add = filter_input(INPUT_POST, 'existing_tag_add', FILTER_SANITIZE_STRING);
  $album_tag_match = filter_input(INPUT_POST, 'album_tag_match', FILTER_SANITIZE_STRING);

  // album_tag_match required
  if ((empty($new_tag_name) && empty($existing_tag_add))) {
    $valid_tag = FALSE;
  }

  // insert valid tag into database
  if ($valid_tag) {
    if (!empty($new_tag_name)) {

      // add new tag to tags table
      $new_tag_sql = "INSERT INTO tags (tag) VALUES (:tag)";
      $new_tag_params = array(
        ':tag' => $new_tag_name
      );
      $result = exec_sql_query($db, $new_tag_sql, $new_tag_params);

      // match new tag to album
      $new_tag_id_sql = "SELECT id FROM tags WHERE tag= :new_tag";
      $new_tag_id_params = array(
        ':new_tag' => $new_tag_name
      );
      $new_tag_id = exec_sql_query($db, $new_tag_id_sql, $new_tag_id_params)->fetchAll(PDO::FETCH_ASSOC);



      $new_tag_sql = "INSERT INTO album_tags (album_id, tag_id) VALUES (:album_id, :tag_id)";
      $new_tag_params = array(
        ':album_id' => $id,
        ':tag_id' => $new_tag_id[0]['id']
      );

      exec_sql_query($db, $new_tag_sql, $new_tag_params);
    } elseif (isset($existing_tag_add)) {

      // get tag id of selected tag
      $existing_tag_id_sql = "SELECT id FROM tags WHERE tag = :existing_tag_add";
      $existing_tag_id_params = array(
        ':existing_tag_add' => $existing_tag_add
      );

      $existing_tag_id = exec_sql_query($db, $existing_tag_id_sql, $existing_tag_id_params)->fetchAll(PDO::FETCH_ASSOC);


      // add new connection into album_tags database
      $existing_tag_sql = "INSERT INTO album_tags (album_id, tag_id) VALUES (:album_id, :tag_id)";
      $exisiting_tag_params = array(
        ':album_id' => $id,
        ':tag_id' => $existing_tag_id[0]['id']
      );

      exec_sql_query($db, $existing_tag_sql, $exisiting_tag_params);
    }
  } else {
    array_push($feedback, "Please select or add a new tag to this album!");
  }
}



// delete album

if (isset($_POST['delete_submit'])) {
  $id = htmlspecialchars($_REQUEST['id']);

  $get_album = exec_sql_query($db, "SELECT * FROM albums WHERE id = $id")->fetchAll(PDO::FETCH_ASSOC);

  $album_deleted = exec_sql_query($db, "DELETE FROM albums WHERE id=$id")->fetchAll(PDO::FETCH_ASSOC);

  unlink("uploads/albums/" . htmlspecialchars($get_album[0]['id']) . "." . htmlspecialchars($get_album[0]['file_ext']));


  $any_tags = exec_sql_query($db, "SELECT * FROM album_tags WHERE album_id = $id")->fetchAll();

  if (!empty($any_tags)) {
    $album_relation_deleted = exec_sql_query($db, "DELETE FROM album_tags WHERE album_id = $id")->fetchAll(PDO::FETCH_ASSOC);
  }

  array_push($feedback, "Album cover successfully deleted.  Click below to return to gallery page.");
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
    echo "<p>" . htmlspecialchars($feed) . "<p>\n";
  }

  // display the clicked on image
  ?>
  <div class="details_all" id="details">
    <div>

      <div class="album_and_details">
        <div class="clicked_image">
          <?php

          $var = htmlspecialchars($_GET['id']);

          $clicked_image_sql = "SELECT * FROM albums WHERE id = :var";
          $clicked_image_params = array(
            ':var' => $var
          );
          $clicked_image_records = exec_sql_query($db, $clicked_image_sql, $clicked_image_params)->fetchAll();

          if (count($clicked_image_records) > 0) {
            foreach ($clicked_image_records as $clicked_image_record) {

              echo "<div class= \"image_with_tags\"><img src=\"uploads/albums/" . $clicked_image_record["id"] . "." . $clicked_image_record["file_ext"] . "\" class = \"selected_image\" alt=\"" . $clicked_image_record["album_title"] . $clicked_image_record["artist"] . "\"></div>";
            }
          }
          ?>
        </div>
        <div class="image_tags">
          <?php

          // display all tags for this image

          $tags_for_image_sql = "SELECT tags.id, tags.tag FROM tags INNER JOIN album_tags ON tags.id = album_tags.tag_id WHERE album_tags.album_id = :var";
          $tags_for_image_params = array(
            ':var' => $var
          );

          $tags_for_image_records = exec_sql_query($db, $tags_for_image_sql, $tags_for_image_params)->fetchAll();

          ?>

          <ul>
            <?php

            if (count($tags_for_image_records) > 0) {
              foreach ($tags_for_image_records as $tags_for_image_record) {
                $in_query = array(
                  'id' => htmlspecialchars($tags_for_image_record['id'])
                );

                echo "<a href=\"tagdetails.php?" . http_build_query($in_query) . "\"><li class=\"details_tag\">" . htmlspecialchars($tags_for_image_record["tag"]) . "</li></a>";
              }
            }

            ?>
          </ul>
        </div>
      </div>
    </div>

    <div class="menu_button">
      <button type="button" id="pop_up_menu"> ... </button>

      <div id="menu">
        <button type="button" id="pop_up_add">Add Tag</button>
        <div id="for_add_button">
          <h3 class="add_tag_header">Add a Tag to This Album</h3>
          <form method="post" action="details.php?id=<?php echo $var; ?>" class="add_tag_form" id="add_tag_form" novalidate>

            <div class="options">
              <div class="add_input">
                <label for="new_tag_name">Create New Tag</label>
                <input type="text" name="new_tag_name" placeholder="type here..." />
              </div>

              <div class="or">
                <p>OR</p>
              </div>

              <div class="add_input">
                <label for="existing_tag_add">Select existing tag to add:</label>
                <select name="existing_tag_add">
                  <option value="" selected disabled>Choose Tag</option>
                  <?php
                  foreach ($current_tags as $current_tag) {
                    echo "<option value=\"" . htmlspecialchars($current_tag) . "\">" . htmlspecialchars($current_tag) . "</option>";
                  }
                  ?>
                </select>
              </div>
            </div>

            <div>
              <button type="submit" name="add_tag_submit" class="tag_add_button">+ tag</button>
            </div>

          </form>
        </div>

        <div class="specific_image_menu">

          <form method="post" action="details.php?id=<?php echo $var; ?>" id="delete_album_form">
            <input type="hidden" name="delete_image_id" value=<?php echo $var ?> />
            <div>
              <button type="button" id=initial_delete>Delete Album</button>
              <button type="submit" name="delete_submit" id="album_delete_button">Confirm Delete</button>
            </div>
          </form>
        </div>

      </div>
    </div>
  </div>


</body>

</html>
