$(document).ready(function() {
    console.log("Sortable initialized");

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var sortable = new Sortable(document.getElementById('sort-table-newsletter'), {
        animation: 150,
        handle: '.fa-arrows-alt',
        onEnd: function (evt) {
            console.log('Drag ended, item position changed.');
        }
    });


    $('#saveOrder').on('click', function() {
        // Get the sorted order of newsletter IDs
        var sortedIDs = [];
        $('#sort-table-newsletter tr').each(function() {
            sortedIDs.push($(this).data('id'));
        });

        // Send the sorted order to the server
        $.ajax({
            url: updateSort,
            method: 'POST',
            data: {
                sortedIDs: sortedIDs // Send the array of sorted IDs
            },
            success: function(res) {
                console.log("Sorting updated successfully");
                showToastMessage("success", res.message);
            },
            error: function(xhr) {
                console.log(xhr);

                console.log("Error occurred while saving sorting");
                alert("Failed to save sorting.");
            }
        });
    });
});
