
<?php $__env->startSection('title', 'Fingerprint Status Check'); ?>
<?php $__env->startSection('content'); ?>
<?php if(auth()->user()->profile->isFinger == true): ?>
<script type="text/javascript">
    function getDevice() {
        var xhr = new XMLHttpRequest();
        var data = "";

        xhr.open('GET', "http://localhost:8086/bjbhid/deviceList", true);
        xhr.setRequestHeader("Content-Type", "application/json");
        xhr.setRequestHeader("Access-Control-Allow-Origin", "*");
        xhr.send(data);
        xhr.onreadystatechange = function() {
            // console.log(xhr);
            // console.log(xhr.status);
            // console.log(xhr.readyState);
            if (xhr.readyState == 4 && xhr.status == 200) {
                var response = JSON.parse(xhr.responseText);
                var data = response['data'];
                alert(response['message']);

                $("#status").html("Device Connected").css("color", "Green");
                $("#deviceId").html(data[0]);
                // toastr.info(response['message']);
            } else if (xhr.readyState == 4 && xhr.status == 404) {
                var response = JSON.parse(xhr.responseText);
                // console.log(response);
                // toastr.error(response['message']);
                alert(response['message']);

                $('#status').html("Device Not Connected").css("color", "Red");
                $("#deviceId").html("");
            } else if (xhr.readyState == 4 && xhr.status == 500) {
                var response = JSON.parse(xhr.responseText);
                // console.log(response);
                alert(response['message']);
                // toastr.error(response['error']);

                $('#status').html("Device Not Connected").css("color", "Red");
                $("#deviceId").html("");
            }
        };
    }

    function scanFinger() {
        alert('Silahkan Scan Jari Anda ...');
        $("#b64Finger").val('');

        var xhr = new XMLHttpRequest();
        var data = "";
        var usernameAuth = $("#usernameAuth").val();

        if (usernameAuth == "" || usernameAuth == null) {
            alert("Field Username Tidak Boleh Kosong !!");
        } else {
            $("#modal-finger").modal('show');

            xhr.open('GET', "http://localhost:8086/bjbhid/scanBase64/" + usernameAuth, true);
            xhr.setRequestHeader("Content-Type", "application/json");
            xhr.setRequestHeader("Access-Control-Allow-Origin", "*");
            xhr.send(data);
            xhr.onreadystatechange = function() {
                // console.log(xhr.status);
                $("#modal-finger").modal('hide');
                if (xhr.readyState == 4 && xhr.status == 200) {
                    toastr.info('Proses Scan Selesai ...');

                    var response = JSON.parse(xhr.responseText);
                    var data = response['data'];
                    toastr.info(response['message']);
                    // response['data'] = "";
                    // log(JSON.stringify(response)); 

                    $("#b64Finger").val(data['image']);
                    $('#statusData').html("Success").css("color", "Green");
                } else if (xhr.readyState == 4 && xhr.status == 404) {
                    var response = JSON.parse(xhr.responseText);
                    toastr.error(response['message']);
                    // log(xhr.responseText);

                    $("#b64Finger").val("");
                    $('#statusData').html("Null");
                } else if (xhr.readyState == 4 && xhr.status == 500) {
                    var response = JSON.parse(xhr.responseText);
                    toastr.info(response['status']);
                    toastr.error(response['error']);
                    // log(xhr.responseText);

                    $("#b64Finger").val("");
                    $('#statusData').html("Null");
                }
            };
        }
    }

    function validateForm() {
        var result = "success";

        if ($('#usernameAuth').val() == "") {
            result = "Username Tidak Boleh Kosong!";
            return result;
        }

        if ($('#b64Finger').val() == "") {
            result = "Data Fingerprint Kosong!";
            return result;
        }

        return "success";
    }

    function fingerCheck() {
        // alert('ds');
        var cek = validateForm();
        if (cek != "success") {
            alert(cek);
            return false;
        }

        var fngr = $("#b64Finger").val();
        var user = $("#usernameAuth").val();
        $('.loading-page').show(); //show progress bar

        $.ajax({
            url: "fingerprint-status/check",
            type: "POST",
            data: {
                "b64Finger": fngr,
                "usernameAuth": user,
            },
            success: function(data) {
                $('.loading-page').hide(); //show progress bar 
                // console.log(data);

                if (data.code == 200) {
                    toastr.success(data.desc);
                } else {
                    toastr.error(data.desc);
                }
            },
            error: function(error) {
                $('.loading-page').hide();
                // console.log(error);
                toastr.error(error)
            }
        });
    }
</script>
<div class="col-6">
    <div class="card card-default">
        <form action="<?php echo e(url('fingerprint-status/check')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="card-body">
                <fieldset style="background-color: #eeeeee; padding: 2px">
                    <legend>
                        <h5>Authorization Prompt</h5>
                    </legend>
                    <div class="col-sm-12">
                        <table cellspacing="0" cellpadding="2">
                            <tbody>
                                <tr>
                                    <td style="width: 200px; font-weight: bold">Fingerprint Agent Status</td>
                                    <td style="width: 25px"> :</td>
                                    <td style="width: 500px"><span id="status" style="color: red">Device Not Connected</span></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold">Device ID</td>
                                    <td> :</td>
                                    <td><span id="deviceId"></span></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold">Finger Print</td>
                                    <td> :</td>
                                    <td><button type="button" class="btn btn-xs btn-info col-sm-12" id="btnScan" onclick="scanFinger();" style="width: 70px; font-weight: bold"><i class="fa fa-fingerprint"> Scan</i></button></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold">Fingerprint Data</td>
                                    <td> :</td>
                                    <td><span id="statusData" style="color: red">Null</span></td>
                                    <input type="hidden" name="b64Finger" id="b64Finger" value="" readonly />
                                </tr>
                                <tr>
                                    <td style="font-weight: bold">Username</td>
                                    <td> :</td>
                                    <td><input type="text" class="form-control ucase" name="usernameAuth" id="usernameAuth" maxlength="4" style="width: 150px;"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div><br>
                </fieldset>

                <div class="modal fade" id="modal-finger">
                    <div class="modal-dialog">
                        <div class="overlay d-flex justify-content-center align-items-center">
                            <i class="fas fa-2x fa-sync fa-spin"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer clearfix">
                
                <button type="button" class="btn btn-sm btn-primary col-sm-12" onclick="fingerCheck()" style="width: 110px; font-weight: bold">Verifiy UIM</button>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    getDevice();
</script>
<?php else: ?>
<span class="metadata" id="info" title="Anda Tidak Memiliki Akses Fingerprint!"></span>
<script type="text/javascript">
    var info = document.getElementById('info').title;
    alert(info);
</script>
<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Data\Kerjaan\Bjb\Aplikasi AMT\Back Office\App\Local\bulk_kosongan\app\Modules\Fingerstatus\Providers/../views/default.blade.php ENDPATH**/ ?>