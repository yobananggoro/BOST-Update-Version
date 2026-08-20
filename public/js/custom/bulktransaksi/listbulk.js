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

    $("#dataTableReportBulk").DataTable({
        paging: true,
        lengthChange: false,
        searching: true,
        ordering: true,
        info: false,
        autoWidth: true,
        pageLength: 25,
        // dom: 'lrtip'
    });

    $("#dataTableList").DataTable({
        paging: true,
        lengthChange: false,
        searching: true,
        ordering: true,
        info: false,
        autoWidth: true,
        // dom: 'lrtip'
    });

    $("#searchContainer").append($("#dataTableDetailUpload_filter"));
    $("#searchContainer_list").append($("#dataTableList_filter"));
    $("#pagingContainer_list").append($("#dataTableList_paginate"));

    $("#searchContainer_report").append($("#dataTableReportBulk_filter"));
    $("#pagingContainer_listreport").append($("#dataTableReportBulk_paginate"));
});
