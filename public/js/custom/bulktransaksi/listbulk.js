$(function () {
    $("#dataTable1").DataTable();
    $("#dataTable2").DataTable({
        paging: true,
        lengthChange: false,
        searching: true,
        ordering: true,
        info: true,
        autoWidth: true,
    });

    $("#dataTableDetailUpload").DataTable({
        paging: false,
        lengthChange: false,
        searching: true,
        ordering: true,
        info: false,
        autoWidth: true,
        pageLength: 25,
        // dom: 'lrtip'
    });

    $("#searchContainer").append($("#dataTableDetailUpload_filter"));
});
