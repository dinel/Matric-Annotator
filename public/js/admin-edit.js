$(document).ready(function() {
    $('#users-to-add').on('click', '#btn-add-user', function () {
        const selected = $('#add-user').val();
        $.ajax({
            type: "POST",
            url: '/admin/add-user-to-task/' + currentTask + "/" + selected,
            success: function (data) {
                $('#info-users').html(data.htmlForUsers);
                $('#users-to-add').html(data.usersToAdd);
            }
        })
    });

    $('#info-users').on('click', '.delete-button', function (){
        const selected = $(this).data('id');
        const name = $(this).data('name');
        if(confirm("Are you sure you want to remove " + name + " from the task?")) {
            $.ajax({
                type: "POST",
                url: '/admin/remove-user-from-task/' + selected,
                success: function (data) {
                    $('#info-users').html(data.htmlForUsers);
                    $('#users-to-add').html(data.usersToAdd);
                }
            })
        }
    });

    $('#users-to-add').on('change', '#add-user', function () {
        $('#btn-add-user').prop('disabled', false);
    });
});