$(function () {
    $("#dtTables1").DataTable();
    $("#dtTables2").DataTable({
        paging: true,
        lengthChange: false,
        searching: true,
        ordering: true,
        info: true,
        autoWidth: true,
    });
});

function checkAll(box) {
    // Ambil DataTable instance
    let table = $('#dtTables1').DataTable();

    // Ambil semua checkbox pada halaman yang sedang tampil (bukan seluruh halaman)
    let checkboxes = table.$('input[type="checkbox"]');
    checkboxes.prop('checked', box.checked);
}

// function checkAll(box) 
// {
//     let checkboxes = document.getElementsByTagName('input');
//     if (box.checked) { // jika checkbox teratar dipilih maka semua tag input juga dipilih
//         for (let i = 0; i < checkboxes.length; i++) {
//             if (checkboxes[i].type == 'checkbox') {
//                 checkboxes[i].checked = true;
//             }
//         }
//     } else { // jika checkbox teratas tidak dipilih maka semua tag input juga tidak dipilih
//         for (let i = 0; i < checkboxes.length; i++) {
//             if (checkboxes[i].type == 'checkbox') {
//                 checkboxes[i].checked = false;
//             }
//         }
//     }
// }

