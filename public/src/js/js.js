$(document).on('submit', '#createGroupForm', function(e) {

    e.preventDefault();
    let formData = $(this).serialize();

    $.ajax({
        method: "POST",
        data: formData,
        url: `ajax/criar_grupo.php`,
        success: function (res) {
            console.log(res);
        },
        error: function (error) {
        },
      });
});