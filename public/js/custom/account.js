$(function() {
  $(".numeric").on('input', function(e) {
      $(this).val($(this).val().replace(/[^0-9]/g, ''));
  });
});

if($("#accuse").val()=="internal"){
  $("#extAcctNumber").hide();
  $("#branch").show();
  $("#cif").show();
  $("#suffix").show(); 
}else{
  $("#extAcctNumber").show();
  $("#branch").hide();
  $("#cif").hide();
  $("#suffix").hide();
}

$("#btnToggleAccount").click(function(){
  if($("#accuse").val()=="internal"){
      $("#accuse").val("external");
      $("#extAcctNumber").show();
      $("#extAcctNumber").focus();
      $("#extAcctNumber").change();
      $("#branch").hide();
      $("#cif").hide();
      $("#suffix").hide();
  }else{
      $("#accuse").val("internal");
      $("#extAcctNumber").hide();
      $("#branch").show();
      $("#branch").focus();
      $("#branch").change();
      $("#cif").show();
      $("#suffix").show();
  }
});

$("#btnEnter").click(function(){
  // alert("masuk");
  return validate();
})

function validate(){
  var zlab = $("#branch").val();
  var zlan = $("#cif").val();
  var zlas = $("#suffix").val();
  var zlean = $("#extAcctNumber").val();
  var accuse = $("#accuse").val();
  var err = false;

  if(accuse=="internal"){
      if(zlab==""){
          $("#branch").css("background-color","red");
          err = true;
      }
      if(zlan==""){
          $("#cif").css("background-color","red");
          err = true;
      }
      if(zlas==""){
          $("#suffix").css("background-color","red");
          err = true;
      }
  }else{
      if(zlean==""){
          $("#extAcctNumber").css("background-color","red");
          err = true;
      }
  }
              
  if(err){
      alert("Field wajib diisi");
      return false
  }

  return true;
}