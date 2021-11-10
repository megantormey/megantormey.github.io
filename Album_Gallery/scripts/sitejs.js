$(document).ready(function () {
  $("#pop_up_form").click(function () {
    $("#add_album_form").toggle("fast");
  });

  $("#pop_up_filter").click(function () {
    $("#filter_options").toggle("fast");
  });

  $("#pop_up_menu").click(function () {
    $("#menu").toggle("fast");
  }).click();

  $("#pop_up_add").click(function () {
    $("#for_add_button").toggle("fast");
  }).click();

  $("#initial_delete").click(function () {
    $("#album_delete_button").toggle("fold");
  }).click();

  $("#pop_up_tag_delete").click(function () {
    $("#tag_delete_button").toggle("fold");
  }).click();

  $("#tag_menu_button").click(function () {
    $("#menu_toggle").toggle("fast");
  }).click();


  $("#add_album_form").on("submit", function () {
    var valid = true;

    if ($("#album_file").prop("validity").valid) {
      $("#file_error").addClass("hidden");
    } else {
      $("#file_error").removeClass("hidden");
      valid = false
    }
    return valid;
  });


});
