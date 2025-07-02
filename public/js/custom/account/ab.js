$(function () {
  if ($("#accuse").val() == "internal") {
    $("#extAcctNumber").hide();
    $("#branch").show();
    $("#cif").show();
    $("#suffix").show();
  } else {
    $("#extAcctNumber").show();
    $("#branch").hide();
    $("#cif").hide();
    $("#suffix").hide();
  }

  $("#btnEnter").click(function () {
    // alert('das');
    var cek = validateForm();
    if (cek != "success") {
      alert(cek);
      return false;
    }

    $("#formAccount").attr("target", "_self").submit();
  });

  $("#btnToggleAccount").click(function () {
    if ($("#accuse").val() == "internal") {
      $("#accuse").val("external");
      $("#extAcctNumber").show();
      // $("#extAcctNumber").focus();
      // $("#extAcctNumber").change();
      $("#branch").hide();
      $("#cif").hide();
      $("#suffix").hide();
    } else {
      $("#accuse").val("internal");
      $("#extAcctNumber").hide();
      $("#branch").show();
      // $("#branch").focus();
      // $("#branch").change();
      $("#cif").show();
      $("#suffix").show();
    }
  });

  $("#listRekening").click(function () {
    resetContent();
  });
});

function validateForm() {
  var zlab = $("#branch").val();
  var zlan = $("#cif").val();
  var zlas = $("#suffix").val();
  var zlean = $("#extAcctNumber").val();
  var accuse = $("#accuse").val();
  var result = "success";

  if (accuse == "internal") {
    if (zlab == "") {
      $("#branch").css("background-color", "red");
      result = "Branch Tidak Boleh Kosong";
      return result;
    }
    if (zlan == "") {
      $("#cif").css("background-color", "red");
      result = "CIF Tidak Boleh Kosong";
      return result;
    }
    if (zlas == "") {
      $("#suffix").css("background-color", "red");
      result = "Suffix Tidak Boleh Kosong";
      return result;
    }
  } else {
    if (zlean == "") {
      $("#extAcctNumber").css("background-color", "red");
      result = "External Account Tidak Boleh Kosong";
      return result;
    }
  }

  return "success";
}

// Modal List Rekening Start
function listRekening(action) {
  var cif = $("#cifRekening").val();
  var i = $("#paging").val() == "" ? 1 : parseInt($("#paging").val());
  var page = i;

  if (action == "next") {
    page = i + 1;
  } else if (action == "prev") {
    page = i - 1;
  } else {
    page = i;
  }

  $.ajax({
    url: "rekening-list?page=" + page,
    type: "GET",
    data: { cif: cif },
    cache: true,
    success: function (response) {
      console.log(response.data);

      var table_data = "";
      $("#tableData").empty();

      for (var i = 0; i < response.data.length; i++) {
        table_data += '<tr onclick="getRowData(this)">';
        table_data += '<td class="text-center">' + (i + 1) + ".</td>";
        table_data +=
          '<td class="nameAccount">' + response.data[i].nama + "</td>";
        table_data +=
          '<td class="noAccount text-center">' +
          response.data[i].branch +
          "-" +
          response.data[i].cif +
          "-" +
          response.data[i].suffix +
          "</td>";
        table_data +=
          '<td class="zlean text-center">' +
          response.data[i].externalNum +
          "</td>";
        table_data +=
          '<td class="zlab" style="display:none">' +
          response.data[i].branch +
          "</td>";
        table_data +=
          '<td class="zlan" style="display:none">' +
          response.data[i].cif +
          "</td>";
        table_data +=
          '<td class="zlas" style="display:none">' +
          response.data[i].suffix +
          "</td>";
        table_data +=
          '<td class="tipeAccount text-center">' +
          response.data[i].tipe_rek +
          "</td>";
        table_data +=
          '<td class="tipeCcy text-center">' +
          response.data[i].tipe_ccy +
          "</td>";
        table_data += "</tr>";
      }

      $("#tableData").append(table_data);
      $("#halaman").html("Halaman ke : " + page);
      $("#paging").val(parseInt(page));

      if ($("#paging").val() == null || $("#paging").val() < 2) {
        $("#prev").css("visibility", "hidden");
      } else {
        $("#prev").css("visibility", "visible");
      }
    },
  });
}

function getRowData(element) {
  var zlab = $(element).find(".zlab").text();
  var zlan = $(element).find(".zlan").text();
  var zlas = $(element).find(".zlas").text();
  var externalNum = $(element).find(".zlean").text();

  $("#extAcctNumber").hide();
  $("#branch").show().val(zlab);
  $("#cif").show().val(zlan);
  $("#suffix").show().val(zlas);
  $("#extAcctNumber").val(externalNum);
  $("#closeModal").click();
}

function paginate(id) {
  var action = id;
  listRekening(action);
}

function resetContent() {
  $("#tableData").empty();
  $("#paging").empty().val("");
  $("#halaman").empty();
  $("#namaRekening").val("");
  $("#cifRekening").val("");
}
// Modal List Rekening Start
