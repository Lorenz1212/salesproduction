<div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
		<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
			<div class="d-flex align-items-center flex-wrap mr-1">
				<div class="d-flex align-items-baseline flex-wrap mr-5">
					<h5 class="text-dark font-weight-bold my-1 mr-5">Unit Team List</h5>
					<ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
						<li class="breadcrumb-item text-muted">
							<a href="" class="text-muted">Dashboard</a>
						</li>
						<li class="breadcrumb-item text-muted">
							<a href="" class="text-muted">Unit</a>
						</li>
						<li class="breadcrumb-item text-muted">
							<a href="" class="text-muted">List</a>
						</li>
					</ul>
				</div>
			</div>
			<div class="d-flex align-items-center">
				<button class="btn btn-light-primary font-weight-bolder btn-sm" data-toggle="modal" data-target="#Create">Create New</button>
			</div>
		</div>
	</div>
<div class="d-flex flex-column-fluid">
	<div class="container">
		<div class="card card-custom">
			<div class="card-header">
				<div class="card-title">
					<span class="card-icon">
						<span class="svg-icon menu-icon">
							<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
							    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
							        <rect x="0" y="0" width="24" height="24"/>
							        <path d="M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z" fill="#000000"/>
							        <rect fill="#000000" opacity="0.3" transform="translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519) " x="16.3255682" y="2.94551858" width="3" height="18" rx="1"/>
							    </g>
							</svg>
						</span>
					</span>
					<h3 class="card-label">List</h3>
				</div>
			</div>
			<div class="card-body">
						<table class="table table-bordered table-hover table-checkable" id="kt_datatable_unit" style="margin-top: 13px !important">
							<thead>
								<tr>
									<th>No</th>
									<th>Name</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Modal-->	
<div class="modal fade" id="Create" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Team</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
            	<form class="form" id="create_unit">
					 <div class="form-group row">
					 	<div class="col-lg-12 col-xxl-12 col-md-12">
					 		<label>Unit Name <span class="text-danger">*</span></label>
						    <input type="text" class="form-control" name="name"  placeholder="Enter name......" autocomplete="off"/>
					 	</div>
					 </div>
    			 </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary font-weight-bold btn-create">Save changes</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="update" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Team</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
            	<form class="form" id="update_unit">
					 <div class="form-group row">
					 	<div class="col-lg-12 col-xxl-12 col-md-12">
					 		<label>Unit Name <span class="text-danger">*</span></label>
						    <input type="text" class="form-control" name="name_update"  placeholder="Enter name......" autocomplete="off"/>
					 	</div>
					 </div>
    			 </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary font-weight-bold btn-update">Save changes</button>
            </div>
        </div>
    </div>
</div>