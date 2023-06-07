$(document).ready(function () {
    let app_url = "{{ config('app.url') }}"
    var now = new Date();
    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);
    var today = now.getFullYear() + "-" + (month) + "-" + (day);

    $('#cheque_date').val(today);

    if( parseFloat($('#amount').val()) + parseFloat($('#expense_amount').val()) == parseFloat($('#invoice_amount').val()) )
        $("#receipt_create").attr('disabled', 'disabled');

    $("input[type='radio']").click(function () {
        var radioValue = $("input[name='type']:checked").val();
        if (radioValue) {
            if (radioValue == 0) {
                $('.cash').removeClass('d-none');
                $('.cheque').addClass('d-none');
            }
            else if (radioValue == 1) {
                $('.cash').addClass('d-none');
                $('.cheque').removeClass('d-none');
            }
        }
    });

    $(".change_product").change(function () {
        var customer_id = $("#customer_id").val();

        $.ajax({
            method: "get",
            url: app_url+"/admin/customer/check_receipt_type",
            data:  {
                customer_id: customer_id,
            },
            success: function (response, textStatus, jqXHR ) {
                $('#totalamount').addClass('text-right');
                $('#totalamount').html(response.total+'(৳)');
                if (response.customer.receipt_type==2) {
                    $("#non_ledger").removeClass('d-none');
                    $("#non_ledger").removeClass('d-none');
                }else if(response.customer.receipt_type==1){
                    $('#non_ledger').addClass("d-none")
                }
            }
        });
        submit_permision();

        $.ajax({
            type: "get",
            url: app_url+"/admin/get_invoice_rtv_expense",
            data: {
                customer_id: $("#customer_id").val(),
            },
            success: function (response) {
                response=jQuery.parseJSON(response);
                $("#invoice_id").html(response['invoices']);
                $("#rtv_id").html(response['rtvs']);
                $('#invoice_id').trigger('change.select2'); // Notify only Select2 of changes
            },
            error: function (e) {
                console.log(e)
            }
        });

    });
    $("#amount").keyup(function () {
        submit_permision();
    });

    ///First Time Load
    $('#invoice_id').trigger('change');
    $('#rtv_id').trigger('change');
});

function amount_update(e, type) {
    let app_url = "{{ config('app.url') }}"
    var ids = $(e).val();
    var type = type;

    $.ajax({
        type: "get",
        url: app_url+"/admin/gettotalamount",
        data: {ids:ids,type:type},
        success: function (response) {
            $("#" + type + "_amount").val(response);
            submit_permision();
        },
        error: function (e) {

            console.log(e)
        }
    });
}
$("#discount").keyup(function(){
    submit_permision();
});

function submit_permision() {
    var amount = parseFloat($("#amount").val());
    var total = amount + parseFloat($("#discount").val());
    $("#total").val(total);


    if (!$('#non_ledger').attr("class")|| ($('#non_ledger').attr("class")&& ($('#non_ledger').attr("class")=="" || $('#non_ledger').attr("class")==undefined))) {
        if ($('#invoice_id :selected').length > 1) {
            if (parseFloat($('#amount').val()) != 0 && (parseFloat($('#amount').val()) + parseFloat($('#discount').val())  == parseFloat($('#invoice_amount').val()))) {
                $("#amount").css('border-color', '');
                $("#total_amount").css('color', '');

                $("#invoice_amount").removeAttr('readonly', 'readonly');
//                        $("#rtv_amount").removeAttr('readonly', 'readonly');
                $("#expense_amount").removeAttr('readonly', 'readonly');

                $("#receipt_create").removeAttr('disabled', 'disabled');
            }
            else {
                $("#amount").css('border-color', 'red');
                $("#total_amount").css('color', 'red');
                $("#invoice_amount").attr('readonly', 'readonly');
//                        $("#rtv_amount").attr('readonly', 'readonly');
                $("#expense_amount").attr('readonly', 'readonly');
                $("#receipt_create").attr('disabled', 'disabled');
            }
        } else {
            if (parseFloat($('#amount').val()) != 0 && parseFloat($('#amount').val()) + parseFloat($('#discount').val()) <= parseFloat($('#invoice_amount').val())) {
                $("#amount").css('border-color', '');
                $("#total_amount").css('color', '');

                $("#invoice_amount").removeAttr('readonly', 'readonly');
//                        $("#rtv_amount").removeAttr('readonly', 'readonly');
                $("#expense_amount").removeAttr('readonly', 'readonly');

                $("#receipt_create").removeAttr('disabled', 'disabled');
            }else {
                $("#amount").css('border-color', 'red');
                $("#total_amount").css('color', 'red');
                $("#invoice_amount").attr('readonly', 'readonly');
//                        $("#rtv_amount").attr('readonly', 'readonly');
                $("#expense_amount").attr('readonly', 'readonly');
                $("#receipt_create").attr('disabled', 'disabled');
            }
        }
    }else{
        if($('#total').val()>0.0)
            $("#receipt_create").removeAttr('disabled', 'disabled');
    }
}
