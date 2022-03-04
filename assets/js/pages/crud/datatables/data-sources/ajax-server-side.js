"use strict";
var KTDatatablesDataSourceAjaxServer = function() {
	$.fn.dataTable.Api.register('column().title()', function() {return $(this.header()).text().trim();});
	$.fn.dataTable.ext.errMode = 'throw';
	var table;
	var initAdvisor = function(table) {
		table = $('#'+table);
        table.DataTable().clear().destroy();
		table.DataTable({
			responsive: true,
			processing: true,
			serverSide: true,
        	order: [],
        	language: {emptyTable: "No Advisor Available"},
			ajax: {
				url: base_url +'Serverside_Controller/Serverside_Advisor',
				type: 'POST',
			},
			columnDefs: [
				{ 
                    targets: [0,1,2,3,4,5,-1],
                    className: "text-nowrap"
                },
				{
					targets: 5,
					orderable: false,
					render: function(data,type,row ) {
                    	let stat='';
						if(row[4]=='1'){
							stat='checked';
						}
						return '\
							<div class="d-flex flex-row">\
								<div class="dropdown dropdown-inline">\
									<a href="javascript:;" id="dropdownMenuButton" class="btn btn-icon btn-light btn-hover-primary btn-sm m-1" data-toggle="dropdown" aria-expanded="true">\
        									<i class="la la-cog"></i>\
        									</a>\
							        <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">\
									    <ul class="nav nav-hoverable flex-column">\
									        <li class="nav-item">\
									            <a class="nav-link" href="javascript:;">\
									                <i class="nav-icon la la-leaf"></i>\
									                <span class="nav-text">Status</span>\
									                <span class="switch switch-sm switch-icon">\
									                    <label>\
									                        <input type="checkbox" class="update_advisor_status" '+stat+' data-status='+row[4]+' data-id='+row[5]+'><span></span>\
									                    </label>\
									                </span>\
									            </a>\
									        </li>\
									    </ul>\
									</div>\
								</div>\
								<a href="javascript:;" class="btn btn-icon btn-light btn-hover-info btn-sm m-1 update_advisor_edit" data-status='+row[4]+'  data-id='+row[5]+'  title="Edit">\
									<i class="la la-pencil"></i>\
								</a>\
						</div>';
                	},
				},
				{
					targets: 3,
					render: function(data, type, full, meta) {
						var status = {
							'1': {'title': 'Branch Manager', 'state': 'success'},
							'2': {'title': 'Sales Manager', 'state': 'primary'},
							'3': {'title': 'Unit Manager', 'state': 'info'},
							'4': {'title': 'MC', 'state': 'warning'},
							'5': {'title': 'Agent', 'state': 'dark'}
						};
						if (typeof status[data] === 'undefined') {
							return data;
						}
						return '<div class="d-flex flex-row align-items-center"><span class="label label-' + status[data].state + ' label-dot mr-2"></span>' +
							'<span class="font-weight-bold text-' + status[data].state + '">' + status[data].title + '</span></div>';
					},
				},
				{
					targets: 4,
					render: function(data, type, full, meta) {
						var status = {
							'0': {'title': 'Inactive', 'state': 'danger'},
							'1': {'title': 'Active', 'state': 'success'}
						};
						if (typeof status[data] === 'undefined') {
							return data;
						}
						return '<div class="d-flex flex-row align-items-center"><span class="label label-' + status[data].state + ' label-dot mr-2"></span>' +
							'<span class="font-weight-bold text-' + status[data].state + '">' + status[data].title + '</span></div>';
					},
				},

			],
		});
	};
	var initUnit = function(table) {
		table = $('#'+table);
        table.DataTable().clear().destroy();
		table.DataTable({
			responsive: true,
			processing: true,
			serverSide: true,
        	order: [],
        	language: {emptyTable: "No Unit Team Available"},
			ajax: {
				url: base_url +'Serverside_Controller/Serverside_Unit',
				type: 'POST',
			},
			columnDefs: [
				{ 
                    targets: [0,1,2,-1],
                    className: "text-nowrap"
                },
				{
					targets: -1,
					orderable: false,
					render: function(data,type,row) {
						return '\
							<div class="d-flex flex-row">\
								<a href="javascript:;" class="btn btn-icon btn-light btn-hover-info btn-sm m-1 update_unit_edit"  data-id='+row[2]+'  title="Edit">\
									<i class="la la-pencil"></i>\
								</a>\
						</div>';
                	},
				},
			],
		});
	  
	};
	return {
		//main function to initiate the module
		init: function(table,action) {
			if(table == 'kt_datatable_advisor'){
				initAdvisor(table,action);
			}
			if(table == 'kt_datatable_unit'){
				initUnit(table,action);
			}
		},
	};
}();

// jQuery(document).ready(function() {
// 	KTDatatablesDataSourceAjaxServer.init();
// });