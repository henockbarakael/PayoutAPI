"use strict";

// Class definition
var KTUsersAddUser = function () {

    const form = document.getElementById('upload_form');

    // Init add schedule modal
    var initAddUser = () => {

        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
        var validator = FormValidation.formValidation(
            form,
            {
                fields: {
                    'formFile': {
                        validators: {
                            notEmpty: {
                                message: 'Upload file is required'
                            }
                        }
                    },
                    'no_transaction': {
                        validators: {
                            notEmpty: {
                                message: 'The total number of transaction is required',
                            },
                            numeric: {
                                message: 'The total number of transaction must be a number',
                            },
                        },
                    },
                },

                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    tachyons: new FormValidation.plugins.Tachyons(),
                    submitButton: new FormValidation.plugins.SubmitButton(),
                    icon: new FormValidation.plugins.Icon({
                        valid: 'fa fa-check',
                        invalid: 'fa fa-times',
                        validating: 'fa fa-refresh',
                    }),
                },
            }
        );

        // Submit button handler
        const submitButton = element.querySelector('[data-upload-action="submit"]');
        submitButton.addEventListener('click', e => {
            e.preventDefault();

            // Validate form before submit
            if (validator) {
                validator.validate().then(function (status) {
                    console.log('validated!');

                    if (status == 'Valid') {
                        // Show loading indication
                        submitButton.setAttribute('data-kt-indicator', 'on');

                        // Disable button to avoid multiple click 
                        submitButton.disabled = true;

                        // Simulate form submission. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                        setTimeout(function () {
                            // Remove loading indication
                            submitButton.removeAttribute('data-kt-indicator');
                            // Enable button
                            submitButton.disabled = false;
                            var url = "institution-user";
                            var file = $("input[name=file]").val();
                            var no_transaction = $("input[name=no_transaction]").val();
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            $.ajax({
                                url: url,
                                type:"POST",
                                data:{
                                    file:file,
                                    no_transaction:no_transaction,
                                },
                                success:function(response){
                                    if(response.status == false) {
                                        // Show error popup. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                                        Swal.fire({
                                            text: response.message,
                                            icon: "error",
                                            buttonsStyling: false,
                                            confirmButtonText: "Ok, got it!",
                                            customClass: {
                                                confirmButton: "btn btn-primary"
                                            }
                                        });
                                    }
                                    else if(response.status == true) {
                                        // Show message popup. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                                        Swal.fire({
                                            text: response.message,
                                            icon: "success",
                                            buttonsStyling: false,
                                            confirmButtonText: "Ok, got it!",
                                            customClass: {
                                                confirmButton: "btn btn-primary"
                                            }
                                        }).then(function (result) {
                                            if (result.isConfirmed) { 
                                                modal.hide();
                                                location.reload();	
                                            }
                                        });
                                    }
                                }
                            });
                            //form.submit(); // Submit form
                        }, 2000);
                    } else {
                        // Show popup warning. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                        Swal.fire({
                            text: "Sorry, looks like there are some errors detected, please try again.",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn btn-primary"
                            }
                        });
                    }
                });
            }
        });

    }

    return {
        // Public functions
        init: function () {
            initAddUser();
        }
    };
}();

// On document ready
$(document).ready(function (){
    KTUsersAddUser.init();
});

