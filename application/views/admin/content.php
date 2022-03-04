<?php 
$this->load->view('admin/layouts/header'); 
$this->load->view('admin/layouts/navbar'); 
if($this->session->userdata('view')){
	$page_view = 'admin/view/'.$this->session->userdata('view');
}else{
	$page_view = 'admin/view/dashboard';
}
?>
<!--begin::Content-->
	<div class="content d-flex flex-column flex-column-fluid" id="kt_content_container">
		<div class="post d-flex flex-column-fluid" id="kt_content">
				<?php $this->load->view($page_view);?>
		</div>
	</div>
<!--end::Content-->
		<?php 
		$this->load->view('admin/layouts/footer');
		$this->load->view('script/adminscript'); 
		?>
	</body>
</html>