<div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
		<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
			<div class="d-flex align-items-center flex-wrap mr-1">
				<div class="d-flex align-items-baseline flex-wrap mr-5">
					<h5 class="text-dark font-weight-bold my-1 mr-5">Advisor List</h5>
					<ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
						<li class="breadcrumb-item text-muted">
							<a href="" class="text-muted">Dashboard</a>
						</li>
						<li class="breadcrumb-item text-muted">
							<a href="" class="text-muted">Advisor</a>
						</li>
						<li class="breadcrumb-item text-muted">
							<a href="" class="text-muted">List</a>
						</li>
					</ul>
				</div>
			</div>
			<div class="d-flex align-items-center">
				<button class="btn btn-light-primary font-weight-bolder btn-sm">Create New</button>
			</div>
		</div>
	</div>
<div class="d-flex flex-column-fluid">
	<div class="container">
		<div class="card card-custom">
			<div class="card-header">
				<div class="card-title">
					<span class="card-icon">
						<i class="flaticon-users-1 text-primary"></i>
					</span>
					<h3 class="card-label">List</h3>
				</div>
			</div>
			<div class="card-body">
						<table class="table table-bordered table-hover table-checkable" id="kt_datatable_advisor" style="margin-top: 13px !important">
							<thead>
								<tr>
									<th>No</th>
									<th>Code</th>
									<th>Name</th>
									<th>Position</th>
									<th>Status</th>
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
<div class="modal fade" id="update" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Advisor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
            	<form class="form" id="update_advisor">
            		<div class="form-group row">
            			<div class="col-lg-4">
	            			<div class="image-input image-input-empty image-input-outline" id="kt_image_6" style="background-image: url(<?php echo base_url()?>assets/media/users/blank.png)">
							 <div class="image-input-wrapper"></div>
							 <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change avatar">
							  <i class="fa fa-pen icon-sm text-muted"></i>
							  <input type="file" name="image_update" accept=".png, .jpg, .jpeg"/>
							  <input type="hidden" name="image_update_remove"/>
							 </label>
							 <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="Cancel avatar">
							  <i class="ki ki-bold-close icon-xs text-muted"></i>
							 </span>
							 <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="remove" data-toggle="tooltip" title="Remove avatar">
							  <i class="ki ki-bold-close icon-xs text-muted"></i>
							 </span>
							</div>
						</div>
					</div>
					 <div class="form-group row">
					 	<div class="col-lg-2">
					 		<label>Advisor Code <span class="text-danger">*</span></label>
					 		 <div class="input-group">
							     <input type="text" class="form-control" name="advisor_code_update" placeholder="Enter code" autocomplete="off" disabled/>
							     <div class="input-group-append">
							      	<button  type="button" class="btn btn-light-dark font-weight-bold btn-edit" data-action="advisor_code"><i class="flaticon2-pen"></i></button>
							     </div>
							 </div>
					 	</div>
					 	<div class="col-lg-3">
					 		<label>Team <span class="text-danger">*</span></label>
					 		<div class="input-group">
								<select class="form-control" name="team_update" disabled>
								 		<option value="">SELECT TEAM</option>
									   	<?php 
									   		$query = $this->db->select('*')->from('tbl_team')->where('status',1)->get();
									   		foreach($query->result() as $row){
									   			echo '<option value="'.$row->id.'">'.$row->name.'</option>';
									   		}
									   	?>
								   </select>
							     <div class="input-group-append">
							      	<button  type="button" class="btn btn-light-dark font-weight-bold btn-edit" data-status="select" data-action="team"><i class="flaticon2-pen"></i></button>
							     </div>
							 </div>
					 	</div>
					    <div class="col-lg-4">
					 		<label>Position <span class="text-danger">*</span></label>
					    	<div class="input-group">
								<select class="form-control" name="position_update" disabled>
						    		<option value="">SELECT POSITION</option>
						    		<option value="1">Branch Manager (BM)</option>
						    		<option value="2">Sales Manager (SM)</option>
						    		<option value="3">UNIT Manager (UM)</option>
						    		<option value="4">Manager Candidate (MC)</option>
						    		<option value="5">Advisor (A)</option>
						    	</select>
							     <div class="input-group-append">
							      	<button  type="button" class="btn btn-light-dark font-weight-bold btn-edit" data-action="position" data-status="select"><i class="flaticon2-pen"></i></button>
							     </div>
							 </div>
					 	</div>
					 	<div class="col-lg-3">
					 		<label>Date Coded<span class="text-danger">*</span></label>
					 		<div class="input-group">
								  <input type="text" class="form-control" name="date_coded_update" id="kt_datepicker_1" placeholder="Select date" disabled>
							     <div class="input-group-append">
							      	<button  type="button" class="btn btn-light-dark font-weight-bold btn-edit" data-action="date_coded"><i class="flaticon2-pen"></i></button>
							     </div>
							 </div>
					 	</div>	
					 </div>
					   <div class="form-group row">
					   		<div class="col-lg-3">
						    	<label>Last Name <span class="text-danger">*</span></label>
						    	<div class="input-group">
								  <input type="text" class="form-control" name="lname_update"  placeholder="Enter Last Name....." autocomplete="off" disabled />
							    	 <div class="input-group-append">
							      		<button  type="button" class="btn btn-light-dark font-weight-bold btn-edit" data-action="lname"><i class="flaticon2-pen"></i></button>
							     	</div>
								 </div>
							</div>
							<div class="col-lg-3">
						    	<label>First Name <span class="text-danger">*</span></label>
						    	<div class="input-group">
						    	  <input type="text" class="form-control" name="fname_update"  placeholder="Enter First Name....." autocomplete="off" disabled />
							    	 	<div class="input-group-append">
							      		<button  type="button" class="btn btn-light-dark font-weight-bold btn-edit" data-action="fname"><i class="flaticon2-pen"></i></button>
							     	   </div>
								 	</div>	
							</div>
							<div class="col-lg-3">
						    	<label>Middle Name/Initial <span class="text-danger">*</span></label>
						    	<div class="input-group">
						    	<input type="text" class="form-control" name="mname_update"  placeholder="Enter Name/Initial....." autocomplete="off" disabled />
						    	 	<div class="input-group-append">
						      		<button  type="button" class="btn btn-light-dark font-weight-bold btn-edit" data-action="mname"><i class="flaticon2-pen"></i></button>
						     	   </div>
							</div>
						</div>
							<div class="col-lg-2">
					   			<label>Gender <span class="text-danger">*</span></label>
						    	<div class="input-group">
							    	<select class="form-control" name="gender_update" disabled>
							    		<option value="1">Male</option>
							    		<option value="2">Female</option>
							    	</select>
						    	 	<div class="input-group-append">
						      		<button  type="button" class="btn btn-light-dark font-weight-bold btn-edit" data-action="gender" data-status="select"><i class="flaticon2-pen"></i></button>
						     	   </div>
								</div>
					   		</div>
					   </div>
					   <div class="form-group row">
					   		<div class="col-lg-4">
					   			<label>Mobile No. <span class="text-danger">*</span></label>
						    	<div class="input-group">
						    		<input type="text" class="form-control" name="mobile_update"  placeholder="Enter Mobile No....." autocomplete="off" disabled/>
						    	 	<div class="input-group-append">
						      		<button  type="button" class="btn btn-light-dark font-weight-bold btn-edit" data-action="mobile"><i class="flaticon2-pen"></i></button>
						     	   </div>
								</div>
					   		</div>
					   		<div class="col-lg-4">
					   			<label>Email <span class="text-danger">*</span></label>
					   			<div class="input-group">
						    		<input type="email" class="form-control" name="email_update"  placeholder="Enter Email Address....." autocomplete="off" disabled/>
						    	 	<div class="input-group-append">
						      		<button  type="button" class="btn btn-light-dark font-weight-bold btn-edit" data-action="email"><i class="flaticon2-pen"></i></button>
						     	   </div>
								</div>
					   		</div>
					   </div>
    			 </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>	
<div class="modal fade" id="create" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Advisor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
            	<form class="form" id="create_advisor">
            		<div class="form-group row">
            			<div class="col-lg-4">
	            			<div class="image-input image-input-empty image-input-outline" id="kt_image_5" style="background-image: url(<?php echo base_url()?>images/profile/default.png)">
							 <div class="image-input-wrapper"></div>
							 <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change avatar">
							  <i class="fa fa-pen icon-sm text-muted"></i>
							  <input type="file" name="image" accept=".png, .jpg, .jpeg"/>
							  <input type="hidden" name="image_remove"/>
							 </label>
							 <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="Cancel avatar">
							  <i class="ki ki-bold-close icon-xs text-muted"></i>
							 </span>
							 <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="remove" data-toggle="tooltip" title="Remove avatar">
							  <i class="ki ki-bold-close icon-xs text-muted"></i>
							 </span>
							</div>
						</div>
					</div>
					 <div class="form-group row">
					 	<div class="col-lg-2">
					 		<label>Advisor Code <span class="text-danger">*</span></label>
						    <input type="text" class="form-control" name="advisor_code"  placeholder="Enter code" autocomplete="off"/>
					 	</div>
					 	<div class="col-lg-3">
					 		<label>Team <span class="text-danger">*</span></label>
						 	<select class="form-control" name="team">
						 		<option value="">SELECT TEAM</option>
						   	<?php 
						   		$query = $this->db->select('*')->from('tbl_team')->where('status',1)->get();
						   		foreach($query->result() as $row){
						   			echo '<option value="'.$row->id.'">'.$row->name.'</option>';
						   		}
						   	?>
						   </select>
					 	</div>
					    <div class="col-lg-4">
					 		<label>Position <span class="text-danger">*</span></label>
					    	<select class="form-control" name="position">
					    		<option value="">SELECT POSITION</option>
					    		<option value="1">Branch Manager (BM)</option>
					    		<option value="2">Sales Manager (SM)</option>
					    		<option value="3">UNIT Manager (UM)</option>
					    		<option value="4">Manager Candidate (MC)</option>
					    		<option value="5">Advisor (A)</option>
					    	</select>
					 	</div>
					 	<div class="col-lg-3">
					 		<label>Date Coded<span class="text-danger">*</span></label>
						    <input type="text" class="form-control" name="date_coded" id="kt_datepicker_1" readonly="readonly" placeholder="Select date" readonly>
					 	</div>	
					 </div>
					   <div class="form-group row">
					   		<div class="col-lg-4">
						    	<label>Last Name <span class="text-danger">*</span></label>
							    <input type="text" class="form-control" name="lname"  placeholder="Enter Last Name....." autocomplete="off" />
							</div>
							<div class="col-lg-4">
						    	<label>First Name <span class="text-danger">*</span></label>
						   		 <input type="text" class="form-control" name="fname"  placeholder="Enter First Name....." autocomplete="off" />
							</div>
							<div class="col-lg-4">
						    	<label>Middle Name/Initial <span class="text-danger">*</span></label>
						    	<input type="text" class="form-control" name="mname"  placeholder="Enter Name/Initial....." autocomplete="off" />
							</div>
					   </div>
					   <div class="form-group row">
					   		<div class="col-lg-4">
					   			<label>Gender <span class="text-danger">*</span></label>
						    	<select class="form-control" name="gender">
						    		<option value="1">Male</option>
						    		<option value="2">Female</option>
						    	</select>
					   		</div>
					   		<div class="col-lg-4">
					   			<label>Mobile No. <span class="text-danger">*</span></label>
						    	<input type="text" class="form-control" name="mobile"  placeholder="Enter Mobile No....." autocomplete="off" />
					   		</div>
					   		<div class="col-lg-4">
					   			<label>Email <span class="text-danger">*</span></label>
						    	<input type="email" class="form-control" name="email"  placeholder="Enter Email Address....." autocomplete="off" />
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