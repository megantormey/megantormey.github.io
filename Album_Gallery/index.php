<?php
include("includes/init.php");

const MAX_FILE_SIZE = 1000000;

$feedback = array();

// File upload

if (isset($_POST['submit_upload'])) {

  //filter file inputs
  $album_title = filter_input(INPUT_POST, "album_title", FILTER_SANITIZE_STRING);
  trim($album_title);

  $artist = filter_input(INPUT_POST, "artist", FILTER_SANITIZE_STRING);
  trim($artist);

  $upload_info = $_FILES['album_file'];

  if (!empty('album_file')) {
    if ($upload_info['error'] == UPLOAD_ERR_OK) {
      if ($upload_info['size'] < MAX_FILE_SIZE) {
        $file_name = basename($upload_info['name']);

        $upload_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
      } else {
        array_push($feedback, "File upload unsuccessful, file was too large.");
      }
    } else {
      array_push($feedback, "File upload unsuccessful, there was an error");
    }
  } else {
    array_push($feedback, "Please select an album cover to upload!");
  }

  $sql = "INSERT INTO albums (file_name, file_ext, album_title, artist) VALUES (:file_name, :file_ext, :album_title, :artist)";
  $params = array(
    ':file_name' => $file_name,
    ':file_ext' => $upload_ext,
    'album_title' => $album_title,
    'artist' => $artist
  );

  $add = exec_sql_query($db, $sql, $params);

  $new_id = $db->lastInsertId('id');
  $new_path = "uploads/albums/$new_id.$upload_ext";
  move_uploaded_file($_FILES['album_file']["tmp_name"], $new_path);
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

  <div class=filter_and_add>

    <div class="upload_and_gallery">

    </div>

    <div class="filter_and_title">
      <h1>Album Gallery</h1>
      <p>Click the albums and tags below for more information</p>

      <div class="filter">
        <h5>Tags:</h5>
        <ul>
          <?php
          $tags_sql = "SELECT * FROM tags";
          $all_tags = exec_sql_query($db, $tags_sql, NULL)->fetchAll();
          if (count($all_tags) > 0) {
            foreach ($all_tags as $all_tag) {
              $in_tag_query = array(
                'id' => htmlspecialchars($all_tag['id'])
              );

              echo "<a href=\"tagdetails.php?" . http_build_query($in_tag_query) . "\"><p class=\"indiv_filter\">" . htmlspecialchars($all_tag["tag"]) . "</p></a>";
            }
          }
          ?>

        </ul>

      </div>
    </div>

    <div>

      <div class="add_form_total">
        <button type="button" id="pop_up_form" class="upload_button">Upload+</button>
        <form class="formadd" action="index.php" method="post" id="add_album_form" enctype="multipart/form-data" novalidate>

          <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_FILE_SIZE; ?>">

          <h4>Upload new album cover to the gallery:</h4>

          <div class="upload_inputs">
            <div class="input">
              <div class=error_container>
                <span id="file_error" class="hidden">Please select a file to upload</span>
                <div>
                  <label for="album_file">Upload File:</label>
                  <input id="album_file" type="file" name="album_file" accept="image/*" required />
                </div>
              </div>
            </div>

            <div class="input">
              <label for="new_album_title"> Album Title:</label>
              <input type="text" name="new_album_title" />
            </div>

            <div class="input">
              <label for="new_album_artist"> Artist Name:</label>
              <input type="text" name="new_album_artist" />
            </div>
          </div>

          <div>
            <span></span>
            <button name="submit_upload" type="submit" class="file_upload_button">Upload File</button>
          </div>

        </form>

      </div>

      <?php
      foreach ($feedback as $feed) {
        echo "<p>" . htmlspecialchars($feed) . "<p>\n";
      }
      ?>


      <div class="wrap_images">
        <?php
        $records = exec_sql_query($db, "SELECT * FROM albums")->fetchAll(PDO::FETCH_ASSOC);


        if (count($records) > 0) {
          foreach ($records as $record) {
            $in_query = array(
              'id' => htmlspecialchars($record['id'])
            );

            echo "<div class= \"gal_images\"><a href=\"details.php?" . http_build_query($in_query) . "\"><img src=\"uploads/albums/" . $record["id"] . "." . $record["file_ext"] . "\" class = \"gal_img_class\" alt=\"" . $record["album_title"] . $record["artist"] . "\"></a><cite><a class= \" citation\" href=\"" . $record["source"] . "\">//Album Source</a></cite></div>";
          }
        } else {
          array_push($feedback, "No files have been uploaded.  Try uploading an album cover!");
        }
        ?>
      </div>
    </div>
  </div>








</body>

</html>
