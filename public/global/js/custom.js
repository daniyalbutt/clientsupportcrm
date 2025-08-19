/**
Custom module for you to write your own javascript functions
**/
var Custom = function () {

    // private functions & variables

    var myFunc = function(text) {
        alert(text);
    }

    // public functions
    return {

        //main function
        init: function () {
            //initialize here something.            
        },

        //some helper function
        doSomeStuff: function () {
            myFunc();
        }

    };

}();

jQuery(document).ready(function() {    
   Custom.init(); 
});


//Use for sale create

    var tPrice = 0;
    var count = 0;
    var barcount = 1;
    function barCode(){
    
        if ($("#barcode_id_"+barcount).val() === '' || $("#barcode_id_"+barcount).val() === undefined) {
                        //alert("empty field.");
                       // $("#boxData_"+count).remove();
                }else{
                    //console.log(e);
                    var barcode_id = $("#barcode_id_"+barcount).val();
                    //var barcode_id = e.target.value;
                    //alert($("#barcode_id_"+barcount).val());

                            //ajax
                    $.get('/ajax-subcat?barcode_id=' + barcode_id, function(data){
                            //console.log(data);
                        if (data === 'nullval') {
                                           alert("null value"); 
                                           return false;
                        }else{
                            barcount = barcount + 1;
                            count = count + 1;
                            $.each(data, function(index,proObj){
                            var p;
                            
                            var pTotal = proObj.price * proObj.quantity;
                             tPrice = tPrice + Number(pTotal) ;
                            

                            $("#Nval_"+count).html("<br />"+proObj.name);
                            $("#Pval_"+count).html("<br />"+proObj.price);
                            $("#Qval_"+count).html("<br /><input class='form-control' id='quantity_"+count+"' name='quantity_"+count+"' type='number' autofocus>");
                            $("#Tval_"+count).html("<span class='pt' id='productTotal_"+count+"'><br /></span><input type='hidden' name='price_"+count+"' value='"+proObj.price+"'/><input type='hidden' name='cid' value='"+count+"'/>");


                            $("#boxData_").append("<tr id='row_"+barcount+"'><td class='numeric' id='bar_"+barcount+"'><div class='form-group form-md-line-input'><div class='col-md-12'><input type='text' class='form-control' name='barcode_id_"+barcount+"' id='barcode_id_"+barcount+"' onChange='barCode();' placeholder='Enter Barcode' /><div class='form-control-focus'></div></div></div></td><td id='Nval_"+barcount+"'></td><td id='Pval_"+barcount+"'></td><td id='Qval_"+barcount+"'><br /></td><td id='Tval_"+barcount+"'><span class='pt' id='productTotal_"+count+"'></span></td></tr>");
                                    
                                     
                            $("#totalPrice").html(tPrice);
                                    

                            $("#barcode_id_"+count).change(function() {
                                        var barcode_idd = $( this ).val();

                            $.get('/ajax-subcat?barcode_id=' + barcode_idd, function(data){
                                if (data === 'nullval') {
                                    alert("null value");
                                    $("#Nval_"+count).html("");
                                    $("#Pval_"+count).html("");
                                    $("#Qval_"+count).html("");
                                   $("#Tval_"+count).html(""); 
                                    return false;
                                }else{
                                        $.each(data, function(index,pro){
                                        
                                        var cTotal = pro.price * pro.quantity;
                                        // alert(cTotal);
                                        // alert(cTotal + tPrice);
                                        //alert($('.ptp').val());
                                        
                                   
                                        $("#Nval_"+count).html("<br />"+pro.name);
                                        $("#Pval_"+count).html("<br />"+pro.price);
                                        $("#Qval_"+count).html("<br /><input class='form-control' id='quantity_"+count+"' name='quantity_"+count+"' type='number' value='"+pro.quantity+"' autofocus>");
                                        $("#Tval_"+count).html("<span class='ptp' id='productTotal_"+count+"'><br />"+cTotal+"</span>");

                                        $("#quantity_"+count).blur(function(){
                                            var v = $("#quantity_"+count).val();
                                            var p = pro.price * v;
                                            var tPrice = p;

                    //                                    alert("This input field has lost its focus."+p);
                                        $("#productTotal_"+count).html('');
                                        $("#productTotal_"+count).html("<br />"+p+"<input type='hidden' name='total_"+count+"' value='"+p+"'/><input type='hidden' name='price_"+count+"' value='"+pro.price+"'/><input type='hidden' name='cid' value='"+count+"'/>");
                                        $("#totalPrice").html(tPrice);
                                        });
                                    });
                                }
                            });
                        });
                                       $("#quantity_"+count).blur(function(){
                                        var v = $("#quantity_"+count).val();
                                        var p = proObj.price * v;
                                        
                                        alert($("#productTotal_1").val());
                                        //  alert("This input field has lost its focus."+p);
                                            $("#productTotal_"+count).html('');
                                            $("#productTotal_"+count).html("<br />"+p+"<input type='hidden' name='total_"+count+"' value='"+p+"'/><input type='hidden' name='price_"+count+"' value='"+proObj.price+"'/><input type='hidden' name='cid' value='"+count+"'/>");
                                            $("#totalPrice").html(tPrice);
                                        });

                                });
                            }
                        });
                }
        }


            var count = 0;
            var barcount = 1;
        function editBarcode(){
              if ($("#barcode_id_"+barcount).val() === '' || $("#barcode_id_"+barcount).val() === undefined) {
                        //alert("empty field.");
                       // $("#boxData_"+count).remove();
                }else{
                    //console.log(e);
                    var barcode_id = $("#barcode_id_"+barcount).val();
                    //var barcode_id = e.target.value;
                    //alert($("#barcode_id_"+barcount).val());

                            //ajax
                    $.get('/ajax-subcat?barcode_id=' + barcode_id, function(data){
                            //console.log(data);
                        if (data === 'nullval') {
                                           alert("null value"); 
                                           return false;
                        }else{
                            barcount = barcount + 1;
                            count = count + 1;
                            $.each(data, function(index,proObj){
                            var p;
                            
                            var pTotal = proObj.price * proObj.quantity;
                             tPrice = tPrice + Number(pTotal) ;
                            

                            $("#Nval_"+count).html("<br />"+proObj.name);
                            $("#Pval_"+count).html("<br />"+proObj.price);
                            $("#Qval_"+count).html("<br /><input class='form-control' id='quantity_"+count+"' name='quantity_"+count+"' type='number' autofocus>");
                            $("#Tval_"+count).html("<span class='pt' id='productTotal_"+count+"'><br /></span><input type='hidden' name='price_"+count+"' value='"+proObj.price+"'/><input type='hidden' name='cid' value='"+count+"'/>");


                            $("#boxData_").append("<tr id='row_"+barcount+"'><td class='numeric' id='bar_"+barcount+"'><div class='form-group form-md-line-input'><div class='col-md-12'><input type='text' class='form-control' name='barcode_id_"+barcount+"' id='barcode_id_"+barcount+"' onChange='barCode();' placeholder='Enter Barcode' /><div class='form-control-focus'></div></div></div></td><td id='Nval_"+barcount+"'></td><td id='Pval_"+barcount+"'></td><td id='Qval_"+barcount+"'><br /></td><td id='Tval_"+barcount+"'><span class='pt' id='productTotal_"+count+"'></span></td></tr>");
                                    
                                     
                            $("#totalPrice").html(tPrice);
                                    

                            $("#barcode_id_"+count).change(function() {
                                        var barcode_idd = $( this ).val();

                            $.get('/ajax-subcat?barcode_id=' + barcode_idd, function(data){
                                if (data === 'nullval') {
                                    alert("null value");
                                    $("#Nval_"+count).html("");
                                    $("#Pval_"+count).html("");
                                    $("#Qval_"+count).html("");
                                   $("#Tval_"+count).html(""); 
                                    return false;
                                }else{
                                        $.each(data, function(index,pro){
                                        //alert(pro.name);
                                        var cTotal = pro.price * pro.quantity;
                                        
                                   
                                        $("#Nval_"+count).html("<br />"+pro.name);
                                        $("#Pval_"+count).html("<br />"+pro.price);
                                        $("#Qval_"+count).html("<br /><input class='form-control' id='quantity_"+count+"' name='quantity_"+count+"' type='number' value='"+pro.quantity+"' autofocus>");
                                        $("#Tval_"+count).html("<span class='pt' id='productTotal_"+count+"'><br />"+cTotal+"</span>");

                                        $("#quantity_"+count).blur(function(){
                                            var v = $("#quantity_"+count).val();
                                            var p = pro.price * v;
                                            var tPrice = p;

                    //                                    alert("This input field has lost its focus."+p);
                                        $("#productTotal_"+count).html('');
                                        $("#productTotal_"+count).html("<td id='sumId_"+count+"'><br />"+p+"<input type='hidden' name='total_"+count+"' value='"+p+"'/><input type='hidden' name='price_"+count+"' value='"+pro.price+"'/><input type='hidden' name='cid' value='"+count+"'/></td>");
                                        $("#totalPrice").html(tPrice);
                                        });
                                    });
                                }
                            });
                        });
                                       $("#quantity_"+count).blur(function(){
                                        var v = $("#quantity_"+count).val();
                                        var p = proObj.price * v;
                                        
                                        //alert($("#productTotal_1").val());
                                        //  alert("This input field has lost its focus."+p);
                                            $("#productTotal_"+count).html('');
                                            $("#productTotal_"+count).html("<td id='sumId_"+count+"'><br />"+p+"<input type='hidden' name='total_"+count+"' value='"+p+"'/><input type='hidden' name='price_"+count+"' value='"+proObj.price+"'/><input type='hidden' name='cid' value='"+count+"'/></td>");
                                            $("#totalPrice").html(tPrice);
                                        });

                                });
                            }
                        });
                }
        }

function formSubmit(){
                        if ($('#customerName').val() === '' ) 
                            {
                                alert('All field is required');
                                
                                return false;
                            }else{
                            //    //alert('done');
                            
                             //var str = $( "form" ).serializeArray();
                            // var name = $(this.form).attr('id')
                            // var fields = $( "form" ).serializeArray();
                            //                 $( "#totalAmount" ).empty();
                            //                 jQuery.each( fields, function( i, field ) {
                            //                   $( "#totalAmount" ).append(field.name[0] + " = " + field.value[0] + " " );
                            //                 });

                            var arr = $("form").serializeArray();
                            var len = arr.length;
                            var dataObj = {};
                            for (i=0; i<len; i++) {
                            dataObj[arr[i].name] = arr[i].value;
                            }
                            $( "#totalAmount" ).html(dataObj['customerName']);
                            //console.log(dataObj['customerName']); // returns John
                            //console.log(dataObj['customerNumber']);

                            //console.log(str);

                           

                        }

                            
                           
                           
                     }

 var ccount = 0;
 function creditMemo(){
    if ($("#customerNumber").val() === '' || $("#customerNumber").val() === undefined) {
                        //alert("empty field.");
                       
                }else{
                    //console.log(e);
                    var customerNumber = $("#customerNumber").val();
                       $.get(
                            '/ajax-getCreditData',
                            {"customerNumber":customerNumber},
                            function(data){
                            if (data === 'nullval') {
                                alert('nullval');
                                $('#boxData_').html('');
                                $('#boxData_').html('<tr id="row_1"><td class="numeric"><div class="form-group form-md-line-input"><div class="col-md-12"><select class="form-control" name="item" id="item"></select></div></div></td><td id="Pval_"></td><td id="Qval_"></td><td id="Tval_"></td></tr>');

                                return false;
                            }else{
                                var subcat = $('#item').empty();
                                var cusName = $('#custName').empty();                   
                                cusName.append('data');
                                subcat.append('<option value="">Select Product</option>'); 
                                $.each(data, function(key, value){
                                        subcat.append('<option value="'+value.id+'">'+value.name+'</option>'); 
                                        //alert(value.name);
                                        //console.log(key + ":" + value)
                                });
                            }  
                            });
                            $("#item").change(function(){
                                var proId = $(this).val();
                                // alert(proId);
                                //alert($('#customerNumber').val());
                                // alert(customerNumber);
                                ccount = ccount + 1;
                                 $.get(
                                    '/ajax-getProData',
                                    {"id":proId,"customerNumber":customerNumber},
                                    function(prodata){
                                    if (prodata === 'nullval') {
                                        $("#Pval_").html('');
                                        $("#Qval_").html('');
                                        $("#Tval_").html('');

                                        return false;
                                    } else{
                                    //var subcat = $('#item').empty();
                                     //var Nval = $("#Nval_"+count).empty();

                                        $.each(prodata, function(key, proValue){
                                            $("#Pval_").html("<br />"+proValue.price+"<input type='hidden' name='price' value='"+proValue.price+"'/>");
                                            $("#Qval_").html("<br /><input class='form-control' id='quantity' name='quantity' type='number' autofocus>");
                                            $("#Tval_").html("<span id='productTotal_'><br /><input type='hidden' name='total'/></span>");
                                    //Quantity sum    
                                        $("#quantity").blur(function(){
                                        var v = $("#quantity").val();
                                        var p = proValue.price * v;
                                        
                                       
                                            $('#productTotal_').html('');
                                            //$("#Tval_").html('');
                                            $('#productTotal_').html("<td id='sumId_'><br />"+p+"<input type='hidden' name='total' value='"+p+"'/><input type='hidden' name='quantity' value='"+v+"'/></td>");
                                            
                                        });



                                        });
                                    } 
                                    });


                                });
                                

                    }
                   

                   
    }
    $(document).ready(function(){
        //$('#successmsg').hide();
        //alert(33);
         function creditMemoUpdateQuantity(id, text, column_name){
                 $.get('/ajax-creditMemoUpdateData',{"id":id, "text":text, "column_name":column_name},
                    function(data){
                        alert(data);
                });
            }
            $(document).on('blur','.product_quantity',function(){
                var id = $(this).data("id3");
                var product_quantity = $(this).text();
                creditMemoUpdateQuantity(id, product_quantity, "product_quantity");
            });

             $(document).on('click','.btn_delete',function(){
                var id = $(this).data("id5");
                if (confirm('Are you sure do you want to delete?')) {
                     $.get('/ajax-creditMemoDeleteRow',{"id":id},
                        function(data){
                            if (data == true) {
                                $('#successmsg').show();
                            alert(data);
                            }
                            
                    });
                }
            });
    });
   


/***
Usage
***/
//Custom.doSomeStuff();