$(document).ready(function () {
    $("#notification").DataTable({
        processing: true,
        serverSide: true,
        scrollX: true,
        fixedColumns: true,

        ajax: {
            url: getNotifications,
            type: "GET",
        },
        columns: [
            {
                data: "data",
                name: "data",
            },
            {
                data: "created_at",
                name: "created_at",
            },
        ],
    });

});
