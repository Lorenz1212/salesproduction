<div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
		<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
			<div class="d-flex align-items-center flex-wrap mr-1">
				<div class="d-flex align-items-baseline flex-wrap mr-5">
					<h5 class="text-dark font-weight-bold my-1 mr-5">Medallion</h5>
					<ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
						<li class="breadcrumb-item text-muted">
							<a href="" class="text-muted">Dashboard</a>
						</li>
						<li class="breadcrumb-item text-muted">
							<a href="" class="text-muted">Medallion</a>
						</li>
						<li class="breadcrumb-item text-muted">
							<a href="" class="text-muted">List</a>
						</li>
					</ul>
				</div>
			</div>
			<div class="d-flex align-items-center">
				<button class="btn btn-light-dark font-weight-bolder btn-sm mr-2" data-toggle="modal" data-target="#production"><i class="flaticon2-chart mr-2"></i>Generate Production</button>
				<button class="btn btn-light-warning font-weight-bolder btn-sm mr-2" data-toggle="modal" data-target="#target"><i class="flaticon2-graphic-1 mr-2"></i>Generate Target</button>
				<button class="btn btn-light-primary font-weight-bolder btn-sm mr-2" data-toggle="modal" data-target="#date"><i class="flaticon2-calendar-2 mr-2"></i>Generate Date</button>
			</div>
		</div>
	</div>
<div class="d-flex flex-column-fluid">
	<div class="container">
		<div class="card card-custom gutter-b">
			    <div class="card-header card-header-tabs-line">
			        <div class="card-toolbar">
			            <ul class="nav nav-tabs nav-bold nav-tabs-line mr-2">
			                <li class="nav-item">
			                    <a class="nav-link active" data-toggle="tab" href="#validation">
			                        <span class="nav-icon"><i class="flaticon2-chart2"></i></span>
			                        <span class="nav-text">Validation</span>
			                    </a>
			                </li>
			                <li class="nav-item">
			                    <a class="nav-link" data-toggle="tab" href="#unit">
			                        <span class="nav-icon"><i class="flaticon2-avatar"></i></span>
			                        <span class="nav-text">Unit Team</span>
			                    </a>
			                </li>
			                <li class="nav-item">
			                    <a class="nav-link" data-toggle="tab" href="#quarterly">
			                        <span class="nav-icon"><i class="flaticon-calendar-with-a-clock-time-tools"></i></span>
			                        <span class="nav-text">Quarterly</span>
			                    </a>
			                </li>
			                <li class="nav-item">
			                    <a class="nav-link" data-toggle="tab" href="#strategic">
			                        <span class="nav-icon"><i class="flaticon2-infographic"></i></span>
			                        <span class="nav-text">Strategic Plan</span>
			                    </a>
			                </li>
			            </ul>
			             <div class="mr-2">
			                <select class="form-control">
			                	<option value="">SELECT DATE TARGET</option>
			                </select>
			            </div>
			        </div>
			        <div class="card-toolbar">
			            <div class="dropdown dropdown-inline dropleft">
			                <button type="button" class="btn btn-hover-light-primary btn-icon btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			                    <i class="ki ki-more-hor text-warning"></i>
			                </button>
			                <div class="dropdown-menu dropdown-menu-sm">
			                    <a class="dropdown-item" href="javascript:;"><i class="flaticon-upload text-success mr-2"></i> Import</a>
			                    <a class="dropdown-item" href="javascript:;"><i class="flaticon2-download text-success mr-2"></i>  Export</a>
			                    <a class="dropdown-item" href="javascript:;"><i class="flaticon2-psd text-success mr-2"></i> Template</a>
			                    <div class="dropdown-divider"></div>
			                    <a class="dropdown-item" href="#">Separated link</a>
			                </div>
			            </div>
			        </div>
			    </div>
			    <div class="card-body">
			        <div class="tab-content">
			            <div class="tab-pane fade show active" id="validation" role="tabpanel" aria-labelledby="validation">
			               <div data-scroll="true" data-height="300" class="kt_table_validation">
				                
			               <div>
			            </div>
			            <div class="tab-pane fade" id="unit" role="tabpanel" aria-labelledby="unit">
			               <div data-scroll="true" data-height="300" class="kt_table_unit_validation">
				                
			               <div>
			            </div>
			            <div class="tab-pane fade" id="quarterly" role="tabpanel" aria-labelledby="quarterly">
			               <div data-scroll="true" data-height="300" class="kt_table_quarterly">
				                
			               <div>
			            </div>
			            <div class="tab-pane fade" id="strategic" role="tabpanel" aria-labelledby="strategic">
			             	 <div data-scroll="true" data-height="300" class="kt_table_strategic">
				                
			               <div>
			            </div>
			        </div>
			    </div>
			</div>
		</div>
	</div>
</div>
<!-- Modal-->	
<div class="modal fade" id="target" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Generate Target</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
            	<form class="form" id="create_target">
            		<div class="form-group row">
					 	<div class="col-lg-12 col-xxl-12 col-md-12">
					 		<label>Date<span class="text-danger">*</span></label>
						    <select class="form-control" name="generate_id">
						    	<?php 
						    		$query = $this->db->select('*')->from('tbl_generate_date')->get();
						    		foreach($query->result() as $row){
						    			echo '<option value="'.$row->id.'">'.date('F d, Y',strtotime($row->date_to)).' - '.date('F d, Y',strtotime($row->date_from)).'</option>';
						    		}
						    	?>
						    </select>
					 	</div>
					 </div>
					 <div class="form-group row">
					 	<div class="col-lg-12 col-xxl-12 col-md-12">
					 		<label>Target Amount <span class="text-danger">*</span></label>
						    <input type="text" class="form-control" name="amount"  placeholder="Enter name......" autocomplete="off"/>
					 	</div>
					 </div>
    			 </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary font-weight-bold btn-create-target">Save changes</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="date" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Generate Date</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
            	<form class="form" id="create_date">
					 <div class="form-group row">
					 	<div class="col-lg-12 col-xxl-12 col-md-12">
					 		<label>Date From <span class="text-danger">*</span></label>
						    <input type="text" class="form-control" name="from" id="kt_datepicker_1" placeholder="Select date" placeholder="Enter name......" autocomplete="off" readonly />
					 	</div>
					 </div>
					 <div class="form-group row">
					 	<div class="col-lg-12 col-xxl-12 col-md-12">
					 		<label>Date To <span class="text-danger">*</span></label>
						    <input type="text" class="form-control" name="to"  id="kt_datepicker_1" placeholder="Select date" autocomplete="off" readonly />
					 	</div>
					 </div>
    			 </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary font-weight-bold btn-create-date">Save changes</button>
            </div>
        </div>
    </div>
</div>