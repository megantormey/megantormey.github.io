<div class="forms">

  <div class="filter_total">
    <button id="filter_button">Filter</button>
  </div>

  <div class="search_form_total">
    <form method="post" action="index.php" novalidate>
      <select name="search_type" id="selector">
        <option>All</option>
        <option>Album</option>
        <option>Tag</option>
      </select>
      <input type="text" name="search_bar" placeholder="Search." />
      <button type="submit">Go</button>
    </form>
  </div>

  <div class="add_form_total" id="pop_up_form">
    <form action="index.php" method="get" novalidate>

      <div class="input">
        <label for="new_file_name">File Name:</label>
        <input type="text" name="new_file_name" />
      </div>

      <div class="input">
        <label for="new_album_title">Album Title:</label>
        <input type="text" name="new_album_title" />
      </div>

      <div>
        <button type="submit">Add +</button>
      </div>

    </form>
  </div>
</div>
