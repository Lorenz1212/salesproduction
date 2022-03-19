'use strict';
var APPHANDLER = function(){
  //apphandlerglobal
    var _init = async function(){
         _check_url(window.location.pathname);

          $(window).on("popstate", function (e) {
              e.preventDefault();
              location.reload();
          });
          Array.from($(".menu-link,.logout,.profile")).forEach(function(element){
            if(element.getAttribute('href')){
               element.addEventListener("click", function(e){
                e.preventDefault();
                $('.menu-item').removeClass('menu-item-active  menu-item-open');
                $('.'+element.getAttribute('href')).addClass('menu-item-active menu-item-open'); 
                  $(element).parent().addClass('menu-item-active menu-item-open');
                  _loadpage(element.getAttribute('href'));
              })
            }
        });
    };
    var _getParams = async function (url){
        var params = {};
        var parser = document.createElement('a');
        parser.href = url;
        var query = parser.search.substring(1);
        var vars = query.split('&');
        for (var i = 0; i < vars.length; i++) {
            var pair = vars[i].split('=');
            params[pair[0]] = decodeURIComponent(pair[1]);
        }
        return params;
    };
    var _check_url =  async function (url){;   
          $('.menu-item').removeClass('menu-item-active menu-item-open');
          if(url.split('/')[3] == 'adminview'){
            _loadpage(url.split('/')[4]);
            $('.'+url.split('/')[4]).addClass('menu-item-active menu-item-open'); 
          }else{
            _loadpage(url.split('/')[4]);
            $('.dashboard').addClass('menu-item-active menu-item-open'); 
          }
    };
    var _sessionStorage = function (session,val) {
      // Check browser support
      if (typeof(Storage) !== "undefined") {
        sessionStorage.setItem(session, val);
      } else {
        console.log("Sorry, your browser does not support Web Storage...");
      }
    }
    var _getItem = function (session){
      return sessionStorage.getItem(session);
    }
    var _showToast = function(type,message){
        const Toast = Swal.mixin({toast: true,position: 'top-end',showConfirmButton: false,timer: 3000,timerProgressBar: true,onOpen: (toast) => {toast.addEventListener('mouseenter', Swal.stopTimer),toast.addEventListener('mouseleave', Swal.resumeTimer)}});Toast.fire({icon: type,title: message});
    }
  var _initCurrency_format = function(action){
    $( document ).ready(function() {
      $(''+action+'').mask('000,000,000,000,000.00', {reverse: true});
    });
  } 
  var _number_seperator = function(action){
     $( document ).ready(function() {
       $(''+action+'').keyup(function(event) {
        alert('ok')
          if (event.which >= 37 && event.which <= 40) return;
          // $(this).text(function(index, value) {
          //   return value
          //     // Keep only digits, decimal points, and dashes at the start of the string:
          //     .replace(/[^\d.-]|(?!^)-/g, "")
          //     // Remove duplicated decimal points, if they exist:
          //     .replace(/^([^.]*\.)(.*$)/, (_, g1, g2) => g1 + g2.replace(/\./g, ''))
          //     // Keep only two digits past the decimal point:
          //     .replace(/\.(\d{2})\d+/, '.$1')
          //     // Add thousands separators:
          //     .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
          // });
        });
    });
  }
  var _initNumberOnly = function(action){
      $(document).on('input', action, function(evt){
        var self = $(this);
        self.val(self.val().replace(/[^0-9\.]/g,''));
        if ((evt.which < 48 || evt.which > 57)) 
        {
          evt.preventDefault();
        }
      });
   }
    var _showSwal  = function(type,message,title) {
      if(!title){
        swal.fire({
          text: message,
          icon: type,
          buttonsStyling: false,
          confirmButtonText: "Ok, got it!",
          customClass: {
            confirmButton: "btn font-weight-bold btn-light-primary"
          }
          })
      }else{
        swal.fire({
          title: title,
          text: message,
          icon: type,
          buttonsStyling: false,
          confirmButtonText: "Ok, got it!",
          customClass: {
            confirmButton: "btn font-weight-bold btn-light-primary"
          }
          })
      } 
    }
    var _showSwalHtml = function(type,message,title){
      	if(!title){
      		title=type;
      	}
      	swal.fire({
             title: title,
  			html: message,
  			icon: type,
  			buttonsStyling: false,
  			confirmButtonText: "Ok, got it!",
  			customClass: {
  		   		confirmButton: "btn font-weight-bold btn-light-primary"
  			}
  		})
    }
    var _ShowHidePassword = function(id){
      $("#"+id+" span").on('click', function(e) {
        e.preventDefault();
        if($('#'+id+' input').attr("type") == "text"){
            $('#'+id+' input').attr('type', 'password');
            $('#'+id+' i').addClass( "fa-eye-slash" );
            $('#'+id+' i').removeClass( "fa-eye" );
        }else if($('#'+id+' input').attr("type") == "password"){
            $('#'+id+' input').attr('type', 'text');
            $('#'+id+' i').removeClass( "fa-eye-slash" );
            $('#'+id+' i').addClass( "fa-eye" );
        }
      });
    }
    var  animateValueDecimal=function(obj, start, end, duration) {
        let startTimestamp = null;
        const step = (timestamp) => {
          if (!startTimestamp) startTimestamp = timestamp;
          const progress = Math.min((timestamp - startTimestamp) / duration, 1);
          obj.innerHTML = parseFloat(progress * (end - start) + start).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
          if (progress < 1) {
            window.requestAnimationFrame(step);
          }
        };
        window.requestAnimationFrame(step);
    }
    var  animateValue=function(obj, start, end, duration) {
      let startTimestamp = null;
      const step = (timestamp) => {
        if (!startTimestamp) startTimestamp = timestamp;
        const progress = Math.min((timestamp - startTimestamp) / duration, 1);
        obj.innerHTML = Math.floor(progress * (end - start) + start);
        if (progress < 1) {
          window.requestAnimationFrame(step);
        }
      };
      window.requestAnimationFrame(step);
    }
    var _getlastpath = function (url){
          let lastpath = url.split('/').pop();
          if(lastpath == 'shop'){
            return false;
          }else if(lastpath == null || lastpath == ''){
            return false;
          }else{
            return lastpath;
          }
    };
    var _yearpicker = function() {
      $('.yearpicker').datepicker({
          format: "yyyy",
          weekStart: 1,
          orientation: "bottom",
          language: "{{ app.request.locale }}",
          keyboardNavigation: false,
          viewMode: "years",
          minViewMode: "years"
      });
    }
    var _loadpage =  function(page){
                  $.ajax({
                    url: base_url+"view/page",
                    type: "POST",
                    data: {page : page},
                    dataType: "html",
                    beforeSend: function(){
                      window.history.pushState(null, null,'view/adminview/'+page);
                      KTApp.blockPage({
                      overlayColor: '#000000',
                      state: 'primary',
                      message: 'Loading...'
                     });
                      $('.offcanvas-close, .offcanvas-overlay').trigger('click');
                    },
                    complete: function(){
                      $("#kt_content").fadeIn(3000);
                      $("html, body").animate({ scrollTop: 0 }, "slow");
                      $("head > title").empty().append("Miracle Tree | "+page.toUpperCase());
                       KTApp.unblockPage();
                    },
                    success: async function(response){
                        if(response){ 
                          $("#kt_content").empty();
                          $("#kt_content").append(response).promise().done(function(){_initview(page);});
                        }else{

                        }
                    },
                    error: function(xhr,status,error){
                      // if(xhr.status == 200){
                      //   if(xhr.responseText=="signed-out"){
                      //     Swal.fire({
                      //     title:"Oopps!",
                      //     text: "Your account was signed-out.",
                      //     icon: "info",
                      //     showCancelButton: false,
                      //     confirmButtonText: "Ok, Got it",
                      //         reverseButtons: true
                      //     }).then(function(result) {
                      //       window.location.replace("authentication/AdminLogin");
                      //     });
                      //   }else{
                      //     Swal.fire("Ops!", "Check your internet connection.", "error");
                      //   }
                      // }else 
                      if(xhr.status == 500){
                        Swal.fire("Ops!", 'Internal error: ' + xhr.responseText, "error");
                      }else if(status=="error"){
                         Swal.fire({
                          title:"Oopps!",
                          text: "Your account was signed-out.",
                          icon: "info",
                          showCancelButton: false,
                          confirmButtonText: "Ok, Got it",
                              reverseButtons: true
                          }).then(function(result) {
                            window.location.replace("authentication/AdminLogin");
                          });
                      }else{
                        console.log(xhr);
                        console.log(status);
                        Swal.fire("Ops!", 'Something went wrong..', "error");
                      }
                    }  
            });  
    };

    var _initview = async function(view){
      _yearpicker();
      switch(view){
         case"advisor":{
            KTBootstrapDatepicker.init();
            var avatar5 = new KTImageInput('kt_image_5');
            KTDatatablesDataSourceAjaxServer.init('kt_datatable_advisor');
            KTFormControls.init('advisor');
            $('#kt_subheader > div > div:nth-child(2) > button').on('click',function(e){
              e.preventDefault();
              document.getElementById('create_advisor').reset();
              $('#kt_image_5 > span:nth-child(3)').trigger('click');
              $('#create').modal('show');
              $('.form-control').removeClass('is-valid');
              $('.form-control').removeClass('is-invalid');
              $('.fv-help-block').remove();
              $('#update_advisor').attr('data-id',"");
            })
            $("body").delegate('.update_advisor_edit','click',function(e){
               e.stopImmediatePropagation(); 
                  let element=$(this);
                  _ajaxrequest(_constructBlockUi('blockPage', false, "Advisor..."), _constructForm(['advisor', 'fetch_advisor',element.attr('data-id')]));
            });
             $('body').delegate('.update_advisor_status','change', function(e){
                e.stopImmediatePropagation();
                let element=$(this);
                _ajaxrequest(_constructBlockUi('blockPage', false, 'Please wait...'), _constructForm(['advisor', 'update_advisor_status',element.attr('data-id'),(this.checked)?1:0]));
              })
             $('.btn-edit').on('click',function(e){
              e.preventDefault();
               let action = $(this).attr('data-action');
               let status = $(this).attr('data-status');
               let attr = $('.btn-edit[data-action="'+action+'"]').attr('data-function');
               if(status =='select'){var element = 'select';}else{var element = 'input';}
               if(attr == 'save'){
                  let val =$(''+element+'[name="'+action+'_update"]').val();
                   _ajaxrequest(_constructBlockUi('blockPage', false, "Update Advisor..."), _constructForm(['advisor', 'update_advisor', $('#update_advisor').attr('data-id'),val,action]));
                   $(''+element+'[name="'+action+'_update"]').attr('disabled',true);
                   $('.btn-edit[data-action="'+action+'"]').removeAttr('data-function');
                   $('.btn-edit[data-action="'+action+'"] > i').removeClass('flaticon2-check-mark').addClass('flaticon2-pen');
               }else{
                 $(''+element+'[name="'+action+'_update"]').attr('disabled',false);
                 $('.btn-edit[data-action="'+action+'"]').attr('data-function','save');
                 $('.btn-edit[data-action="'+action+'"] > i').removeClass('flaticon2-pen').addClass('flaticon2-check-mark');
               }
            });
          break;
         }
         case "unit":{
           KTDatatablesDataSourceAjaxServer.init('kt_datatable_unit');
           KTFormControls.init('unit');
            $("body").delegate('.update_unit_edit','click',function(e){
                e.stopImmediatePropagation(); 
                  let element=$(this);
                  _ajaxrequest(_constructBlockUi('blockPage', false, "unit..."), _constructForm(['unit', 'fetch_unit',element.attr('data-id')]));
            });
          break;
         }
         case"validation":{
            KTDatatablesDataSourceAjaxServer.init('kt_datatable_validation_date');
            KTBootstrapDatepicker.init();
            KTFormControls.init('validation');
            KTSpreadSheetControls.init('validation');
            _initCurrency_format('.input-currency');
            $('.btn-search').on('click',function(e){
              e.preventDefault();
                let team = $('select[name=team_search]').val();
                let month = $('select[name=month]').val();
                let year = $('input[name=year]').val();
                let date = $('select[name=generate_date]').val();
                if(!year){
                  _showToast('info','Please check all text box before click the button');
                }else{
                   _ajaxrequest(_constructBlockUi('blockPage', false, "Advisor..."), _constructForm(['validation', 'fetch_advisor_production',false,date,month,year,team]));
                }
            });
            $('#list_date > div > div > div.modal-footer > button.btn.btn-primary.font-weight-bold').on('click',function(e){
                e.preventDefault();
                $('.form-action').attr('data-action','create_validation_date');
                $('input[name="from"]').attr('data-id',"0");
                document.getElementById('create_date').reset();
            });
            $('body').delegate('.update_validation_date','click',function(e){
                 e.stopImmediatePropagation(); 
                  let element=$(this);
                  _ajaxrequest(_constructBlockUi('blockPage', false, "unit..."), _constructForm(['validation', 'fetch_validation_date',element.attr('data-id')]));
            });
            $('select[name="generate_id"]').on('change',function(e){
                e.preventDefault();
                 _ajaxrequest(_constructBlockUi('blockPage', false, "unit..."), _constructForm(['validation', 'fetch_validation_target',$(this).val()]));
            });
            $('#kt_content > div.d-flex.flex-column-fluid > div > div > div.card-header.card-header-tabs-line > div:nth-child(2) > div > div > a:nth-child(1)').on('click',function(e){
                  $('.import_validation_data > div > div:nth-child(2)').removeClass('d-none');
                  $('.import_validation_data > div > div:nth-child(3)').removeClass('d-none');
                  $('.import_validation_data > div:nth-child(2)').removeClass('d-none');
                  $('#import > div > div > div.modal-header > h5').text('Import Data');
                  $('.import_validation_data').attr('import');
                  $('.import_validation_data').attr('id','import_validation');
                  $('.btn-import-export').attr('id','btn-import');
                  $('#import').modal('show');
            });
            $('#kt_content > div.d-flex.flex-column-fluid > div > div > div.card-header.card-header-tabs-line > div:nth-child(2) > div > div > a:nth-child(2)').on('click',function(e){
                  $('.import_validation_data > div > div:nth-child(2)').addClass('d-none');
                  $('.import_validation_data > div > div:nth-child(3)').addClass('d-none');
                  $('.import_validation_data > div:nth-child(2)').addClass('d-none');
                  $('.import_validation_data').attr('export');
                  $('.import_validation_data').attr('id','export_validation');
                  $('.import > div > div > div.modal-header > h5').text('Export Data');
                  $('.btn-import-export').attr('id','btn-export');
                  $('#import').modal('show');
            });
            $('.btn-click-file').one('click',function(e){
              $('.file').trigger('click');
              return false;
            });
             $('.btn-download-template').on('click',function(e){
                e.preventDefault();
                     window.open(base_url+"SpreadSheetController/DownloadTemplate", '_blank');
                     _showToast('success','Template Downloaded');
              });
            $('select[name="search"]').on('change',function(e){
              _ajaxrequest(_constructBlockUi('blockPage', false, "Advisor..."), _constructForm(['validation', 'fetch_validation_product',false,$(this).val()]));
            })
             $('select[name="search"]').trigger('change');
            break;
         }
      }
    };
    var _construct = async function(response, type, element, object){
        switch(type){
          case "fetch_advisor":{
            var avatar5 = new KTImageInput('kt_image_6');
            $('#update_advisor').attr('data-id',response.id);
            $('input[name=advisor_code_update]').val(response.result.advisor_code);
            $('input[name=date_coded_update]').val(response.date);
            $('input[name=fname_update]').val(response.result.fname);
            $('input[name=lname_update]').val(response.result.lname);
            $('input[name=mname_update]').val(response.result.mname);
            $('input[name=mobile_update]').val(response.result.mobile);
            $('input[name=email_update]').val(response.result.email);
            $('select[name=gender_update]').val(response.result.gender);
            $('select[name=team_update]').val(response.result.team).change();
            $('select[name=position_update]').val(response.result.position).change();
            $('#update_advisor .form-control').attr('disabled',true);
            $('#update_advisor .form-control').attr('disabled',true);
            $('.btn-edit').attr('data-function','edit');
            $('.btn-edit > i').removeClass('flaticon2-check-mark').addClass('flaticon2-pen');
            $('#kt_image_6').css('background-image',' url(http://localhost/salesproduction/images/profile/'+response.result.image+')');
            $('#update').modal('show');
            break;
          }
          case "update_advisor_status":
          case "update_advisor":{
            if(response == 'Saved Changes'){
              _showToast('success',response);
              KTDatatablesDataSourceAjaxServer.init('kt_datatable_advisor');
            }else{
              _showToast('error',response);
            }
            break;
          }
          case "fetch_unit":{
            $('#update_unit').attr('data-id',response.id);
            $('input[name=name_update]').val(response.result.name);
            $('#update').modal('show');
            break;
          }
          case "fetch_advisor_production":{
            let table = $('#Kt_table_generate_table > tbody:last-child');
            table.empty();
            if(response.length > 0){
              $('#create_production > div:nth-child(2) > div > div > h3').empty();
              for(let i=0;i<response.length;i++){
                  let html=$('<tr row_id="'+response[i].id+'">\
                              <td>'+response[i].advisor_code+'</td>\
                              <td>'+response[i].fullname+'</td>\
                              <td>'+response[i].position+'</td>\
                              <td contenteditable="true" data-status="submitted">'+response[i].submitted+'</td>\
                              <td contenteditable="true" data-status="settled">'+response[i].settled+'</td>\
                              <td id="inputnumbertext'+i+'" contenteditable="true" data-status="ac" >'+response[i].ac+'</td>\
                              <td id="inputnumbertext'+i+'" contenteditable="true" data-status="nsc">'+response[i].nsc+'</td>\
                          </tr>');
                   _initNumberOnly("#inputnumbertext"+i);
                table.append(html).promise().done(function(){
                    $('table td').blur(function(e){
                        e.preventDefault();
                        e.stopImmediatePropagation();
                        let id = $(this).closest('tr').attr('row_id'); 
                        let status = $(this).attr('data-status');
                        let amount = $(this).text();
                        let month = $('select[name=month]').val();
                        let year = $('input[name=year]').val();
                        let date = $('select[name=generate_date]').val();
                        _ajaxrequest(_constructBlockUi(false, false, false), _constructForm(['validation', 'create_advisor_production',false,date,month,year,false,amount,id,status]));
                    });
                });
               }
            }else{
              $('#create_production > div:nth-child(2) > div > div > h3').append('NO DATA AVAILABLE');
            }
            break;
          }
          case "create_advisor_production":{
            if(response == 'Created Successfully'){
              _showToast('success',response);
            }
            break;
          }
          case "fetch_validation_target":{
            if(response){
              $('input[name="amount"]').val(response);
            }
            break;
          }
          case "fetch_validation_date":{
            if(response){
              $('.form-action').attr('data-action','update_validation_date');
              $('input[name="from"]').val(response.date_from);
              $('input[name="from"]').attr('data-id',response.id);
              $('input[name="to"]').val(response.date_to);
              $('#date').modal('show');
            }
            break;
          }
          case "fetch_validation_product":{
             $('.kt_tab_table_production').empty().append(response);
            break;
          }

        }
    };
    // start making formdata
    var _constructForm = function(args){
          let formData = new FormData();
          for (var i = 1; (args.length+1) > i; i++){
             formData.append('data'+ i, args[i-1]);
           }  
          return formData;
    };
    var _constructBlockUi = function(type, element, message){
          let formData = new FormData();
           formData.append('type', type);
           formData.append('element', element);
           formData.append('message', message);
           if(formData){
             return formData;
           }
    };
    var _ajaxrequest = async function(blockUi, formData){
      return new Promise((resolve, reject) => {
             let y = true;
             $.ajax({
              url: base_url+'AdminController/Controller',
              type: 'POST',
              data: formData,
              contentType: false,
              processData: false,
              dataType: "json",
              beforeSend: function(){
                if(blockUi.get("type") == "blockPage"){
                   if(blockUi.get("message") != "false"){
                      KTApp.blockPage({
                      overlayColor: '#000000',
                      state: 'primary',
                      message: blockUi.get("message")
                     });
                   }else{
                      KTApp.blockPage();
                   }
                }else if(blockUi.get("type") == "blockContent"){
                      KTApp.block(blockUi.get("element"));
                }else{
                }
              },
              complete: function(){
                if(blockUi.get("type") == "blockPage"){
                  KTApp.unblockPage();
                }else if(blockUi.get("type") == "blockContent"){
                  KTApp.unblock(blockUi.get("element"));
                }else{
                }
                 resolve(y)
              },
              success: function(res){
                 if(res.status == 'success'){
                    if(window.atob(res.payload) != false){
                      _construct(JSON.parse(window.atob(res.payload)), formData.get("data2"));
                    }else{
                      _construct(res.message, formData.get("data2"));
                    }
                 }else if(res.status == 'not_found'){
                    Swal.fire("Ops!", res.message, "info");
                 }else{
                    Swal.fire("Ops!", res.message, "info");
                 } 
              },
              error: function(xhr,status,error){
                // if(xhr.status == 200){
                //   if(xhr.responseText.trim()=="signed-out"){
                //     Swal.fire({
                //     title:"Oopps!",
                //     text: "Your account was signed-out.",
                //     icon: "info",
                //     showCancelButton: false,
                //     confirmButtonText: "Ok, Got it",
                //         reverseButtons: true
                //     }).then(function(result) {
                //       window.location.replace("login");
                //     });
                //   }else{
                //     Swal.fire("Ops!", "Check your internet connection.", "error");
                //   }
                // }else 
                if(xhr.status == 500){
                  Swal.fire("Ops!", 'Internal error: ' + xhr.responseText, "error");
                }else{
                  console.log(xhr);
                  console.log(status);
                  Swal.fire("Ops!", 'Something went wrong..', "error");
                }
              }       
        });      
       })
    };
 
  return {
    callFunction:  function(type,val1,val2,val3){
      
     },
    init: function(){
        _init();
    }
  };
}();
$(document).ready(function(){
   	APPHANDLER.init();
});




  