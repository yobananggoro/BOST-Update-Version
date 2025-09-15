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
});