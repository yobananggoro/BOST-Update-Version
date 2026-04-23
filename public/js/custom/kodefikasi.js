$(function () {
    // $("#dataTable1").DataTable();
    $("#dataTable1").DataTable({
        paging: true,
        lengthChange: true,
        searching: true,
        ordering: true,
        info: true,
        autoWidth: true,
        order: [[1, 'asc']]
    });
});