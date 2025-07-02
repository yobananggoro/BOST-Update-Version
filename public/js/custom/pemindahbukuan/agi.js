$(function() {
    $("input[name$='group1']").click(function() {
        var test = $(this).val();
        
        $("div.sumber").hide();
        $("#rek" + test).show();
    });
    
    $("input[name$='group2']").click(function() {  
        var test = $(this).val();
        
        $("div.tujuan").hide();
        $("#rek" + test).show();
    });
    
    $('.number-separator').keypress(function(e) {
        if (/^-?\d*[,.]?(\d{0,3},)*(\d{3},)?\d{0,3}$/.test(e.key)) {
            $('.number-separator').on('input', function () {
                e.target.value = numberSeparator(e.target.value);
            });
        } else {
            e.preventDefault();
            return false;
        }
    });
    
    $('#nominalSrc_').keyup(function(e){
        var nom = $('#nominalSrc_').val();
        
        // $('#nominalSrc').val(parseFloat(nom.replace(/,/g, "")));
        if(nom.length > 0){
            $('#nominalSrc').val(parseFloat(nom.replace(/,/g, "")));
        } else {
            $('#nominalSrc').val("");
        }
    });
    
    $("#btnEnter").click(function(e){
        var cek = validateForm();
        if(cek != "success"){
            alert(cek);
            return false;
        }
        
        $(".loading-page").show();
        // $("#formAccount").attr('target', '_self').submit();
    });
    
    $("#listRekening").click(function(){
        // resetContent()
    });
    
    $('.rekSumber').keyup(function(e){
        $(".detailSrc").val("");
        $(".detailSrc").html("");
    });
    
    $(document).on("keyup", ".rekTujuan", function() {
        var regex = /\d+/g;
        var string = $(this).attr('id');
        var match = string.match(regex);
        
        // console.log(string.match(regex)); 
        
        $(".detailDst"+match).val("");
        $(".detailDst"+match).html("");
    });
    
    $('.nar').keyup(function(e){
        this.value = this.value.replace(/[^a-zA-Z0-9 \t\n\r]/g, '');
    });
    
});

var i = 2;
function dynamicField(){
    var max = 10;
    
    if(i <= max) {
        $("#dynamicAddRemove").append('<div class="col-12" id="tujuan'+i+'"><label>Rekening Tujuan '+i+' <span style="color: red">*</span></label><div class="row"><div class="col-sm-2"><input type="text" name="branchDst[]" id="branchDst'+i+'" class="form-control rekTujuan number" maxlength="4" placeholder="Branch"></div><div class="col-sm-3"><input type="text" name="cifDst[]" id="cifDst'+i+'" class="form-control rekTujuan ucase" maxlength="6" placeholder="CIF"></div><div class="col-sm-2"><input type="text" name="suffixDst[]" id="suffixDst'+i+'" class="form-control rekTujuan number" maxlength="3" placeholder="Suffix"><input type="hidden" name="tipeDst[]" id="tipeDst'+i+'" class="form-control detailDst'+i+'" readonly><input type="hidden" name="namaDst[]" id="namaDst'+i+'" class="form-control detailDst'+i+'" readonly><input type="hidden" name="ccyDst[]" id="ccyDst'+i+'" class="form-control detailDst'+i+'" readonly></div><button type="button" class="btn btn-sm btn-info" value="'+i+'" onclick="detailTujuan(this);"><i class="fa fa-fw fa-info-circle"></i> Detail</button><div class="col-7" style="margin-top: 10px"><input type="text" id="nominalDst'+i+'" class="form-control currency text-right" onkeyup="nomtujuan(this)" placeholder="Nominal Tujuan '+i+'"><input type="hidden" id="nominalDst'+i+'_" name="nominalDst[]" class="form-control nomtujuan text-right" readonly></div></div><table style="margin-left: 30px; margin-top: 10px"><tr><td style="width: 110px; font-weight: bold">Nama Account</td><td> :&nbsp;&nbsp;</td><td id="nama_tujuan'+i+'" class="detailDst'+i+'"></td></tr><tr><td style="width: 110px; font-weight: bold">Tipe Account</td><td> :&nbsp;&nbsp;</td><td id="tipe_rek_tujuan'+i+'" class="detailDst'+i+'"></td></tr><tr><td style="width: 110px; font-weight: bold">Currency</td><td> :&nbsp;&nbsp;</td><td id="tipe_ccy_tujuan'+i+'" class="detailDst'+i+'"></td></tr></table><br></div>');
        $(".removeField").css("display", "");
        ++i;
        return i; 
    } 
}

function deleteField(){
    var count = i-1;
    $("#tujuan"+count).remove();
    i--;
    total()
    
    if(i <= 2){
        $(".removeField").css("display", "none");
    } 
    
    return i;
}

function total(){ //sum nominal rekening tujuan
    var total = 0;
    $('.nomtujuan').each(function(){
        total += parseInt($(this).val()-0);
    });
    console.log(total);
    if (!isNaN(total)) {
        $('#total_').val(total.toFixed().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
        $('#total').val(total);
    }
}

function komparasi() { //membandingkan isian form total nominal
    
    let rekSumber = $('#tipe_sumber').val();
    let nomSumber = $('#nomsumber').val();
    let nomTujuan = $('#total').val();
    
    if(!rekSumber){
        alert ("Silahkan isi Rekening Sumber");
    } else if(!nomSumber){
        alert ("Silahkan isi Nominal Sumber");
    } else if(!nomTujuan){
        alert ("Silahkan isi Nominal Tujuan!");
    } else {
        if (nomSumber === nomTujuan) {
            $("#validate, #reff").show();
        } else {
            alert ("Jumlah Nonimal Sumber dan Total Nonimal Sumber harus sama!");
            $("#validate, #reff").hide();
        }
    }
};

function numberSeparator(Number) {
    var commaCounter = 10;
    Number += '';
    
    for (var i = 0; i < commaCounter; i++) {
        Number = Number.replace(',', '');
    }
    
    x = Number.split('.');
    y = x[0];
    z = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    
    while (rgx.test(y)) {
        y = y.replace(rgx, '$1' + ',' + '$2');
    }
    commaCounter++;
    return y + z;
}

function validasiLimit() { 
    var nominal = parseInt(document.getElementById('nomsumber').value);
    var limit = parseInt(document.getElementById('limit').value);
    var status = document.getElementById('status').value;
    
    // alert(nominal);
    // alert(limit);
    if (status != "Success") {
        alert('Transaksi tidak dapat dilakukan!');
    } else {
        if (nominal > limit){
            alert('Nominal melebihi ketentuan limit, silahkan lakukan otorisasi!');
            $("#otorisasi").show();
            $("#subm").show();
            $("#verified").hide();
        } else {
            // alert('lanzuut');
            $("#verified").hide();
            $("#subm").show();
        }
    }
    
}

function validateForm(){
    var result      = "success";
    var branchSrc   = $('#branchSrc').val();
    var cifSrc      = $('#cifSrc').val();
    var suffixSrc   = $('#suffixSrc').val();
    
    if(branchSrc == "" || cifSrc == "" || suffixSrc == ""){
        $("#branchSrc").css("background-color","red");
        $("#cifSrc").css("background-color","red");
        $("#suffixSrc").css("background-color","red");
        
        result = "Rekening Sumber Tidak Boleh Kosong";
        return result;
    } else {
        $("#branchSrc").css("background-color","");
        $("#cifSrc").css("background-color","");
        $("#suffixSrc").css("background-color","");
    }
    
    if($('#tipeSrc').val() == ""){
        result = "Klik tombol Detail terlebih dahulu pada kolom Rekening Sumber";
        return result;
    }
    
    for(x = 1; x <= 10; x++){
        var form = document.getElementById('branchDst'+x);
        if(form != null){
            if($('#branchDst'+x).val()=="" || $('#cifDst'+x).val()=="" || $('#suffixDst'+x).val()==""){
                $('#branchDst'+x).css("background-color","red");
                $('#cifDst'+x).css("background-color","red");
                $('#suffixDst'+x).css("background-color","red");
                
                result = "Rekening Tujuan "+x+" Tidak Boleh Kosong";
                return result;
            } else {
                $('#branchDst'+x).css("background-color","");
                $('#cifDst'+x).css("background-color","");
                $('#suffixDst'+x).css("background-color","");
            }
            
            if($('#tipeDst'+x).val() == ""){
                result = "Klik tombol Detail terlebih dahulu pada kolom Rekening Tujuan "+x+" ";
                return result;
            }
            
            if($('#nominalDst'+x).val() == ""){
                $("#nominalDst"+x).css("background-color","red");
                
                result = "Nominal Tujuan "+x+" Tidak Boleh Kosong";
                return result;
            } else{
                $("#nominalDst"+x).css("background-color","");
            }
            
            if($('#nominalDst'+x).val() == 0){
                $("#nominalDst"+x).css("background-color","red");
                
                result = "Nominal Tujuan "+x+" Tidak Boleh diisi Angka 0!";
                return result;
            } else{
                $("#nominalDst"+x).css("background-color","");
            }
        }
    }
    
    if($('#nominalSrc_').val() == ""){
        $("#nominalSrc_").css("background-color","red");
        
        result = "Nominal Sumber Tidak Boleh Kosong";
        return result;
    } else {
        $("#nominalSrc_").css("background-color","");
    }
    
    if($('#nominalSrc').val() == 0){
        $("#nominalSrc_").css("background-color","red");
        
        result = "Nominal Sumber Tidak Boleh diisi Angka 0!";
        return result;
    } else {
        $("#nominalSrc_").css("background-color","");
    }
    
    if($('#nominalSrc').val() != $('#total').val()){
        result = "Nominal Sumber dan Total Nominal Tujuan harus sama";
        return result;
    }
    
    return "success";
}

function detailSumber() {
    // alert('ds');
    var branch  = $("#branchSrc").val();
    var cif     = $("#cifSrc").val();
    var suffix  = $("#suffixSrc").val();
    
    $('.loading-page').show(); //show progress bar
    
    $.ajax({
        url: "account-gi", 
        type: "POST",
        data: {
            "branch": branch,
            "cif": cif,
            "suffix": suffix,
        }, 
        success:function(data){ 
            $('.loading-page').hide(); //show progress bar 
            console.log(data);
            
            if(data.status == 200){
                if(data.code == '00'){
                    $("#nama_sumber").html(data.accountShortName);
                    $("#tipe_rek_sumber").html(data.accountType);
                    $("#tipe_ccy_sumber").html(data.currency);
                    
                    $("#tipeSrc").val(data.accountType);
                    $("#namaSrc").val(data.accountShortName);
                    $("#ccySrc").val(data.currency);
                    
                    $('.toastrDefaultInfo').show(function() {
                        toastr.info("Data ditemukan!")
                    });
                } else {
                    $('.toastrDefaultError').show(function() {
                        toastr.error(data.msgdesc)
                    });
                }
            } else if(data.status == 500){
                $('.toastrDefaultError').show(function() {
                    toastr.error(data.message)
                });
            } else if(data.status == 400){
                $('.toastrDefaultError').show(function() {
                    toastr.error(data.message)
                });
            } else{
                $('.toastrDefaultError').show(function() {
                    toastr.error(data.message)
                });
            }
        },
        error:function(error){
            $('.loading-page').hide();
            console.log(error);
            
            $('.toastrDefaultError').show(function() {
                toastr.error(error)
            });
        }
    });
}

function detailTujuan(val) {
    var branch  = $("#branchDst"+val.value).val();
    var cif     = $("#cifDst"+val.value).val();
    var suffix  = $("#suffixDst"+val.value).val();
    
    $('.loading-page').show(); //show progress bar
    
    $.ajax({
        url: "account-gi", 
        type: "POST",
        data: {
            "branch": branch,
            "cif": cif,
            "suffix": suffix,
        }, 
        success:function(data){ 
            $('.loading-page').hide(); //show progress bar 
            console.log(data);
            if(data.status == 200){
                if(data.code == '00'){
                    $("#nama_tujuan"+val.value).html(data.accountShortName);
                    $("#tipe_rek_tujuan"+val.value).html(data.accountType);
                    $("#tipe_ccy_tujuan"+val.value).html(data.currency);
                    
                    $("#tipeDst"+val.value).val(data.accountType);
                    $("#namaDst"+val.value).val(data.accountShortName);
                    $("#ccyDst"+val.value).val(data.currency);
                    
                    $('.toastrDefaultInfo').show(function() {
                        toastr.info("Data ditemukan!")
                    });
                } else {
                    $('.toastrDefaultError').show(function() {
                        toastr.error(data.msgdesc)
                    });
                }
            } else if(data.status == 500){
                $('.toastrDefaultError').show(function() {
                    toastr.error(data.message)
                });
            } else if(data.status == 400){
                $('.toastrDefaultError').show(function() {
                    toastr.error(data.message)
                });
            } else{
                $('.toastrDefaultError').show(function() {
                    toastr.error(data.message)
                });
            }
        },
        error:function(error){
            $('.loading-page').hide(); //hide progress bar
            console.log(error);
            
            $('.toastrDefaultError').show(function() {
                toastr.error(error)
            });
        }
    });
}

// Modal List Rekening Start
function listRekening(action) {
    // alert(action);
    var nama = $('#namaRekening').val();
    var cif = $('#cifRekening').val();
    var i = $('#paging').val() == "" ? 1 : parseInt($('#paging').val());
    var page = i;
    
    
    if(action == 'next'){
        page = i+1;
    } else if(action == 'prev'){
        page = i-1;
    } else {
        page = i;
    }
    
    $.ajax({
        url: "rekening-list?page="+page, 
        type: "GET",
        data: {'nama':nama, 'cif':cif},
        cache: true,
        success:function(response){ 
            // console.log(response.data);
            
            var table_data = '';
            $('#tableData').empty();
            
            for(var i = 0; i<response.data.length;i++) {
                table_data += '<tr onclick="getRowData(this)">';
                table_data += '<td class="text-center">'+ (i+1) +'.</td>';
                table_data += '<td class="nameAccount">' + response.data[i].nama + '</td>'
                table_data += '<td class="noAccount text-center">' + response.data[i].branch +"-"+ response.data[i].cif +"-"+ response.data[i].suffix + '</td>'
                table_data += '<td class="zlab" style="display:none">' + response.data[i].branch + '</td>'
                table_data += '<td class="zlan" style="display:none">' + response.data[i].cif + '</td>'
                table_data += '<td class="zlas" style="display:none">' + response.data[i].suffix + '</td>'
                table_data += '<td class="tipeAccount text-center">' + response.data[i].tipe_rek + '</td>'
                table_data += '<td class="tipeCcy text-center">' + response.data[i].tipe_ccy + '</td>'
                table_data += '</tr>'; 
            }
            
            $('#tableData').append(table_data);
            $('#halaman').html('Halaman ke : '+page);
            $('#paging').val(parseInt(page));
        }  
    });
}

// var a = 1;
function getRowData(element){
    var zlab = $(element).find(".zlab").text();
    var zlan = $(element).find(".zlan").text();
    var zlas = $(element).find(".zlas").text();
    
    if($('#branchSrc').val()=="" || $('#cifSrc').val()=="" || $('#suffixSrc').val()==""){
        $('#branchSrc').val(zlab);
        $('#cifSrc').val(zlan);
        $('#suffixSrc').val(zlas);
        $('#closeModal').click();   
        $('#branchSrc').focus();
    } else{
        for(x = 1; x <= 3; x++){
            var form = document.getElementById('branchDst'+x);
            if(form != null){
                if($('#branchDst'+x).val()=="" || $('#cifDst'+x).val()=="" || $('#suffixDst'+x).val()==""){
                    // console.log('ada'); 
                    $('#branchDst'+x).val(zlab);
                    $('#cifDst'+x).val(zlan);
                    $('#suffixDst'+x).val(zlas);
                    $('#closeModal').click();
                    $('#branchDst'+x).focus();  
                    break;
                } else{
                    continue;
                }
            } else{
                break;
            }
        }  
    }
}

function paginate(id){
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
// Modal List Rekening End

function nomtujuan(e){
    var nom = $('#'+e.id).val();
    
    // $('#'+e.id+'_').val(parseFloat(nom.replace(/,/g, "")));
    if(nom.length > 0){
        $('#'+e.id+'_').val(parseFloat(nom.replace(/,/g, "")));
    } else {
        $('#'+e.id+'_').val("");
    }
    
    total()
}
