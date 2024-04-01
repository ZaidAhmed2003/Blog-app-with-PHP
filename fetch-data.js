$(document).ready(function () {
  // Fetch data using AJAX when the document is ready
  $.ajax({
    url: "fetch-data.php", // Your PHP file to handle AJAX requests
    type: "POST",
    dataType: "json",
    success: function (data) {
      // Update featured post section
      if (data.featured) {
        $("#featuredSection").html(`
                    <!-- Your HTML markup to display the featured post -->
                `);
      } else {
        $("#featuredSection").html(`
                    <!-- Your HTML markup when there's no featured post -->
                `);
      }

      // Update latest posts section
      if (data.posts.length > 0) {
        $("#postsSection").html(`
                    <!-- Your HTML markup to display the latest posts -->
                `);
      } else {
        $("#postsSection").html(`
                    <!-- Your HTML markup when there are no latest posts -->
                `);
      }

      // Update category buttons section
      if (data.categories.length > 0) {
        $("#categoryButtonsSection").html(`
                    <!-- Your HTML markup to display category buttons -->
                `);
      } else {
        $("#categoryButtonsSection").html(`
                    <!-- Your HTML markup when there are no categories -->
                `);
      }
    },
    error: function (xhr, status, error) {
      console.error(xhr.responseText);
    },
  });
});
