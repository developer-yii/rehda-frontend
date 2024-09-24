$(document).ready(function () {
    $("#registrations").DataTable({
        processing: true,
        serverSide: false,
        scrollX: true,

        ajax: {
            url: getRejectedRegistrations,
            type: "GET",
        },
        columns: [
            {
                className: 'control',
                orderable: false,
                targets: 0,
                searchable: false,
                render: function (data, type, full, meta) {
                    return '';
                }
            },
            {
                data: "d_created_at",
                name: "d_created_at",
            },
            {
                data: "member_type",
                name: "member_type",
            },
            {
                data: "d_compname",
                name: "d_compname",
            },
            {
                data: "parent_company",
                name: "parent_company",
            },
            {
                data: "d_datecompform",
                name: "d_datecompform",
            },
            {
                data: "details",
                name: "details",
            },
            {
                data: "paid_up_capital",
                name: "paid_up_capital",
            },
            {
                data: "supporting_docs",
                name: "supporting_docs",
            },
            {
                data: "d_remarks",
                name: "d_remarks",
            },
            {
                data: "actions",
                name: "actions",
            },
        ],
        destroy: true,
        dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
        responsive: {
            details: {
                display: $.fn.dataTable.Responsive.display.modal({
                    header: function (row) {
                        var data = row.data();
                        return 'Details';
                    }
                }),
                type: 'column',
                renderer: function (api, rowIdx, columns) {
                    var data = $.map(columns, function (col, i) {
                        return col.title !== '' // ? Do not show row in modal popup if title is blank (for check box)
                            ? '<tr data-dt-row="' +
                            col.rowIndex +
                            '" data-dt-column="' +
                            col.columnIndex +
                            '">' +
                            '<td>' +
                            col.title +
                            ':' +
                            '</td> ' +
                            '<td>' +
                            col.data +
                            '</td>' +
                            '</tr>'
                            : '';
                    }).join('');

                    return data ? $('<table class="table"/><tbody />').append(data) : false;
                }
            }
        },
        order: [[1, 'desc']],
        stateSave: true,
        initComplete: function (settings, json) {
            $('[data-bs-toggle="tooltip"]').tooltip();
        },
        drawCallback: function (settings) {
            $('[data-bs-toggle="tooltip"]').tooltip();
        }
    });
});