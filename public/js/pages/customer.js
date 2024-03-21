var quote = {
    listTable: '#customerTable',
    init: function () {
        var obj = this;
        var $table = $(obj.listTable);
        if ($table.length) {
            var dt = $table.DataTable({
                dom: 'Bfrtip',
                bProcessing: false,
                bServerSide: true,
                sAjaxSource: quoteAjax,
                // fnServerParams: function (aoData) {
                //     //d.type = 'bo';
                //     aoData.push(
                //         {
                //             'name': 'quote_status',
                //             'value': $('#quote_status').val()
                //         }, {
                //             'name': 'quote_type',
                //             'value': $('#chkTestQuote').is(':checked')
                //         });
                // },
                pageLength: 15,
                rowGroup: {
                    enable: false
                },
                autoWidth: false,
                columns: [
                    {data: 'id'},
                    {data: 'fullname'},
                    {data: 'email'},
                    {data: 'contact', className: 'text-center'},
                    {data: 'status'},
                    {data: 'created_at'},
                    {data: 'controls'}
                ],
                columnDefs: [
                    {className: 'text-center', "targets": [0]},
                    {className: 'text-center', "targets": [1]},
                    {className: 'text-center', "targets": [2]},
                    {className: 'text-center', "targets": [3]},
                    {className: 'text-center', "targets": [4]},
                    {className: 'text-center', "targets": [5]},
                    {className: 'text-center', "targets": [6]}
                ],
                order: [[0, 'desc']],
                buttons: [
                    //'copy', 'csv', 'excel', 'pdf', 'print'
                ],
                stateSave: false,
                // stateSaveCallback: function (settings, data) {
                //     localStorage.setItem('invoice_' + settings.sInstance, JSON.stringify(data));
                // },
                // stateLoadCallback: function (settings) {
                //     return JSON.parse(localStorage.getItem('invoice_' + settings.sInstance));
                // }
            });
            // $('body').on('click', '#refreshInvoices', function () {
            //     dt.ajax.reload();
            // });
            $('body').on('change', '#quote_status', function () {
                dt.ajax.reload();
            });
        }
    },
}

$(function (){
    quote.init();
});


$(document).on('change','#role',function(e){
    e.preventDefault();
    $('#id_manager').val('');
    if($(this).val() == 3){
        $('.depend_on_executive').show();
        $('.depend_on_area_manager').hide();
    }else if($(this).val() == 2){
        $('.depend_on_area_manager').show();
        $('.depend_on_executive').hide();
    }else{
        $('.depend_on_executive').hide();
        $('.depend_on_area_manager').hide();
    }
});

$(document).on('click','.change_password',function(e){
    e.preventDefault();
    $('#confirm_password').val('');
    $('#password').val('');
    var customer_id = $(this).data('id');
    $('#passwordChangeModal').modal({
        keyboard: false
    })
    $("#id_customer").val(customer_id);
});

$(document).on('click','#savePasswordBtn',function(e){
    e.preventDefault();
    var customer_id = $('#id_customer').val();
    var password = $('#password').val();
    var confirm_password = $('#confirm_password').val();

    if(!password && !confirm_password){
        messages.error("Password","Please enter password.")
        return false;
    }

    if(password != confirm_password){
        messages.error("Password","Confirm password should be same as password")
        return false;
    }

    $.post(siteUrl+'/admin/customer/change-password', {
        customer_id,
        password,
        confirm_password
    },function(jsonResponse){
        // Iterate through the errors object and display errors
        if(jsonResponse.statusCode == 200){
            messages.saved(jsonResponse.message);
            $('#passwordChangeModal').modal('hide');
        }else{
            for (const fieldName in jsonResponse.errors) {
                if (jsonResponse.errors.hasOwnProperty(fieldName)) {
                    const errorMessages = jsonResponse.errors[fieldName];

                    // Join multiple error messages into one string (if any)
                    const errorMessage = errorMessages.join(' ');

                    // Find the corresponding input field
                    const inputField = document.querySelector(`[name="${fieldName}"]`);

                    if (inputField) {
                        // Create a <div> element to hold the error message
                        const errorDiv = document.createElement('div');
                        errorDiv.className = 'error'; // You can apply your CSS classes here

                        // Set the error message
                        errorDiv.textContent = errorMessage;

                        // Insert the error message after the input field
                        inputField.parentNode.insertBefore(errorDiv, inputField.nextSibling);
                    }
                }
            }
        }
    });
});
