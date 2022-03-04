// Class definition
var KTFormControls = function () {
	var validation;
	var _showToast = function(type,message) {
        const Toast = Swal.mixin({toast: true,position: 'top-end',showConfirmButton: false,timer: 3000,timerProgressBar: true,onOpen: (toast) => {toast.addEventListener('mouseenter', Swal.stopTimer),toast.addEventListener('mouseleave', Swal.resumeTimer)}});Toast.fire({icon: type,title: message});
    }
    var _showSwal  = function(type,message) {
        swal.fire({
          text: message,
          icon: type,
          buttonsStyling: false,
          confirmButtonText: "Ok, got it!",
          customClass: {
            confirmButton: "btn font-weight-bold btn-light-primary"
          }
          })
    }
	var _ajaxForm = function(formData,val=null,val2=null){
		 $.ajax({
                url: base_url+"AdminController/Action",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                dataType:"json",
                beforeSend: function(){
                  KTApp.blockPage();
                },
                complete: function(){
                  KTApp.unblockPage();
                },
                success: function(response){
                    if(response.status=="success"){
                        res=JSON.parse(window.atob(response.payload));
                        	_initResponse(res,val,val2);
                    }else if(response.status == "failed"){
                        Swal.fire("Oopps!", response.message, "info");
                    }else if(response.status == "error"){
                       Swal.fire("Oopps!", response.message, "info");
                    }else{
                       Swal.fire("Oopps!", "Something went wrong, Please try again later", "info");
                       console.log(JSON.parse(window.atob(response.payload)));
                    }
                  },
                  error: function(xhr,status,error){
                      console.log(xhr);
                      console.log(status);
                      console.log(error);
                      console.log(xhr.responseText);
                      Swal.fire("Oopps!", "Something went wrong, Please try again later", "info");
                 } 
            })
	}
	var _InitView = function(form,id){
		switch(form){
			case "advisor":{
		        var form = KTUtil.getById('create_advisor');
		       	validation = FormValidation.formValidation(
		            form,{
		                fields: {
							advisor_code: {
								validators: {
									notEmpty: {
										message: 'Advisor Code is required'
									},
								}
							},
							fname: {
								validators: {
									notEmpty: {
										message: 'First Name is required'
									},
								}
							},

							lname: {
								validators: {
									notEmpty: {
										message: 'Last Name is required'
									},
								}
							},

							gender: {
								validators: {
									notEmpty: {
										message: 'Gender is required'
									},
								}
							},

							position: {
								validators: {
									notEmpty: {
										message: 'Position is required'
									},
								}
							},
							team: {
								validators: {
									notEmpty: {
										message: 'Team is required'
									},
								}
							},

		                },

		                plugins: {
		                    trigger: new FormValidation.plugins.Trigger(),
		                    bootstrap: new FormValidation.plugins.Bootstrap(),
		                }
		            }
		        );
				$('.btn-create').on('click',function(e){
		            e.preventDefault();
		            validation.validate().then(function(status) {
		                if (status == 'Valid') {
		                    let formData = new FormData(form);
		                        formData.append("action", "advisor");
		                        formData.append("type", 'create_advisor');
		                        _ajaxForm(formData,'create_advisor',false);
		                }	
	                });                
	            });
	            $('#kt_image_6 > label > input[type=file]:nth-child(2)').on('change',function(e){
	            	Swal.fire({
					        title: "Are you sure?",
					        text: "You want to upload this!",
					        icon: "warning",
					        showCancelButton: true,
					        confirmButtonText: "Yes, Upload it!",
					        cancelButtonText: "No, cancel!",
					        reverseButtons: true
					    }).then(function(result) {
					        if (result.value) {
								let formData = new FormData();
		                        formData.append("action", "advisor");
		                        formData.append("type", 'update_advisor_image');
		                        formData.append("id",$('#update_advisor').attr('data-id'));
		                        formData.append("image",$('input[name=image_update]')[0].files[0]);
		                        _ajaxForm(formData,'update_advisor_image',false);
					        } else if (result.dismiss === "cancel") {
					        	$('#kt_image_6 > span:nth-child(3)').trigger('click');
					            Swal.fire("Cancelled","Your imaginary file is safe :)","error")
					        }
					    });
	            });
				break;	
			}
			case"unit":{
				var form_create = KTUtil.getById('create_unit');
		       	var validation_create = FormValidation.formValidation(
		            form_create,{
		                fields: {
							name: {
								validators: {
									notEmpty: {
										message: 'Unit Name is required'
									},
								}
							},
		                },
		                plugins: {
		                    trigger: new FormValidation.plugins.Trigger(),
		                    bootstrap: new FormValidation.plugins.Bootstrap(),
		                }
		            }
		        );
				$('.btn-create').on('click',function(e){
		            e.preventDefault();
		            validation_create.validate().then(function(status) {
		                if (status == 'Valid') {
		                    let formData = new FormData(form_create);
		                        formData.append("action", "unit");
		                        formData.append("type", 'create_unit');
		                        _ajaxForm(formData,'create_unit',false);
		                }	
	                });                
	            });
	            var form = KTUtil.getById('update_unit');
		       	validation = FormValidation.formValidation(
		            form,{
		                fields: {
							name: {
								validators: {
									notEmpty: {
										message: 'Unit Name is required'
									},
								}
							},
		                },
		                plugins: {
		                    trigger: new FormValidation.plugins.Trigger(),
		                    bootstrap: new FormValidation.plugins.Bootstrap(),
		                }
		            }
		        );
	            $('.btn-update').on('click',function(e){
		            e.preventDefault();
		             e.preventDefault();
		            validation.validate().then(function(status) {
		                if (status == 'Valid') {
		                     let formData = new FormData();
	                        formData.append("action", "unit");
	                        formData.append("type", 'update_unit');
	                        formData.append("id", $('#update_unit').attr('data-id'));
	                        formData.append("name", $('input[name="name_update"]').val());
	                        _ajaxForm(formData,'update_unit',false);      
		                }	
	                });       
	            });
				break;
			}
			case "validation":{
				 var form_target = KTUtil.getById('create_target');
		       	var validation_target = FormValidation.formValidation(
		            form_target,{
		                fields: {
							generate_id: {
								validators: {
									notEmpty: {
										message: 'Date From - To is required'
									},
								}
							},
							amount: {
								validators: {
									notEmpty: {
										message: 'Amount is required'
									},
								}
							}
		                },
		                plugins: {
		                    trigger: new FormValidation.plugins.Trigger(),
		                    bootstrap: new FormValidation.plugins.Bootstrap(),
		                }
		            }
		        );
				 $('.btn-create-target').on('click',function(e){
		            e.preventDefault();
		            validation_target.validate().then(function(status) {
		                if (status == 'Valid') {
		                     let formData = new FormData(form_target);
	                        formData.append("action", "validation");
	                        formData.append("type", 'create_target');
	                        _ajaxForm(formData,'create_validation_target',false);      
		                }	
	                });       
	            });
				var form_date = KTUtil.getById('create_date');
		       	var validation_date = FormValidation.formValidation(
		            form_date,{
		                fields: {
							from: {
								validators: {
									notEmpty: {
										message: 'Date From is required'
									},
								}
							},
							to: {
								validators: {
									notEmpty: {
										message: 'Date To is required'
									},
								}
							},
		                },
		                plugins: {
		                    trigger: new FormValidation.plugins.Trigger(),
		                    bootstrap: new FormValidation.plugins.Bootstrap(),
		                }
		            }
		        );
				 $('.btn-create-date').on('click',function(e){
		            e.preventDefault();
		            validation_date.validate().then(function(status) {
		                if (status == 'Valid') {
		                     let formData = new FormData(form_date);
	                        formData.append("action", "validation");
	                        formData.append("type", 'create_date');
	                        _ajaxForm(formData,'create_validation_date',false);      
		                }	
	                });       
	            });

				break;
			}
		}
	}
	var _initResponse = function(response,val,val2){
		switch(val){
			case "create_advisor":{
				_showToast('success',res);
				document.getElementById('create_advisor').reset();
				 $('#kt_image_5 > span:nth-child(3)').trigger('click');
				KTDatatablesDataSourceAjaxServer.init('kt_datatable_advisor');
				break;
			}
			case "update_advisor_image":{
				if(response.status='Saved Image Changes'){
					_showToast('success',response.status);
					$('#kt_image_6').css('background-image',' url(http://localhost/salesproduction/images/profile/'+response.image+')');
					$('#kt_image_6 > label > input[type=file]:nth-child(2)').val("");
				}else{
					_showToast('error',response);
				}
				break;
			}
			case "create_unit":{
				_showToast('success',res);
				document.getElementById('create_unit').reset();
				KTDatatablesDataSourceAjaxServer.init('kt_datatable_unit');
				break;
			}
			case "update_unit":{
				_showToast('success',res);
				KTDatatablesDataSourceAjaxServer.init('kt_datatable_unit');
				break;
			}
			case "create_validation_date":{
				if(res == 'Created Successfully'){
					_showToast('success',res);
				}else{
					_showToast('info',res);
				}
				document.getElementById('create_date').reset();
				break;
			}
			case "create_validation_target":{
				if(res == 'Created Successfully'){
					_showToast('success',res);
					document.getElementById('create_target').reset();
				}else{
					_showToast('success',res);
				}
				break;
			}
		}
	}
	return {
		// public functions
		init: function(form,val=false){
			_InitView(form,val);
		}
	};
}();

// jQuery(document).ready(function() {
// 	KTFormControls.init();
// });
