<?php
$this->load->view('admin/header');
$this->load->view('admin/sidebar');
?>
	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">

	    <!-- Content Header (Page header) -->
	    <div class="content-header">
	      <div class="container-fluid">
	        <div class="row mb-2">
	          <div class="col-sm-6">
	            <h1 class="m-0 text-dark"><?php echo $app_title;?></h1>
	          </div><!-- /.col -->
	
	        </div><!-- /.row -->
	      </div><!-- /.container-fluid -->
	    </div>
	    <!-- /.content-header -->

<?php
$this->load->view($content);
?>
	</div> <!-- /.content-wrapper -->
</div> <!-- ./wrapper -->
</body>
</html>

