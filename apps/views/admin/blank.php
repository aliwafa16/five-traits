        <section class="content-header">
          <h1>
            Blank page
            <small>it all starts here</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Examples</a></li>
            <li class="active">Blank page</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">

          <!-- Default box -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Title</h3>
              <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              Start creating your amazing application!
              <?php echo "<pre>";echo print_r($this->session->all_userdata())."</pre><br/>";?>
              <?php echo "<pre>";echo print_r($this->session->userdata('contents'))."</pre><br/>";
		$id = 1;
		$items = $this->session->userdata('contents');
		$dateNow = date('Y-m-d H:i:s');
		$data = array();
		foreach($items as $k => $v)
		{
			$data[$k]['f_parent_id'] = $id;
			$data[$k]['f_account_active'] = 1;
			$data[$k]['f_account_name'] = $v['f_account_name'];
			$data[$k]['f_account_email'] = $v['f_account_email'];
			$data[$k]['f_account_tlp'] = $v['f_account_tlp'];
			$data[$k]['f_account_mobile'] = $v['f_account_mobile'];
			$data[$k]['f_account_type'] = $v['f_account_type'];
			$data[$k]['f_account_created_on'] = $dateNow;
			$data[$k]['f_account_created_by'] = $this->session->userdata('sName');
			$data[$k]['f_city_id']			= $v['f_city_id'];
			$data[$k]['f_country_id']		= $v['f_country_id'];
			$data[$k]['f_province_id']		= $v['f_province_id'];

			if($v['f_account_type']  == 'contact')
			{
				$data[$k]['f_account_title']	= $v['f_account_title'];
				$data[$k]['f_account_job']		= $v['f_account_job'];
			}
			else
			{
				$data[$k]['f_address']			= $v['f_address'];
				$data[$k]['f_address2']			= $v['f_address2'];
				$data[$k]['f_postal_code'] 		= $v['f_postal_code'];
			}
		}
		
		echo "<pre>";echo print_r($data)."</pre><br/>";
              ?>
            </div><!-- /.box-body -->
            <div class="box-footer">
              Footer
            </div><!-- /.box-footer-->
          </div><!-- /.box -->

        </section><!-- /.content -->
