$(document).ready(function () {

    $("#invoiceTable").DataTable({
        processing: true,
        serverSide: false,
        scrollX: true,
        fixedColumns: true,
        bSort: true,
        language: {
            loadingRecords: '<div class="sk-wave sk-primary"><div class="sk-wave-rect"></div><div class="sk-wave-rect"></div><div class="sk-wave-rect"></div><div class="sk-wave-rect"></div><div class="sk-wave-rect"></div></div>',
        },
        order : [[0, 'desc']],

        ajax: {
            url: getInvoice,
            type: "GET",
        },
        columns: [
            {
                data: "date",
                name: "date",
            },
            {
                data: "invoice_no",
                name: "invoice_no",
            },
            {
                data: "amount",
                name: "amount",
            },
            {
                data: "actions",
                name: "actions",
            },
        ],
        columnDefs: [
            { orderable: false, targets: 1 },
            { width: '15%', targets: 3 },
        ],
        buttons: [],
        dom: '<"row"<"col-sm-12 col-md-3"l><"col-sm-12 col-md-3 d-flex justify-content-center justify-content-md-start dataTables_length"B><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
        initComplete: function (settings, json) {
            $('[data-bs-toggle="tooltip"]').tooltip();
        },
        drawCallback: function (settings) {
            $('[data-bs-toggle="tooltip"]').tooltip();
        }
    });

});