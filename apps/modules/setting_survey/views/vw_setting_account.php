<!-- load css dan js -->
<link type="text/css" rel="stylesheet" href="<?php echo PLUG_URL;?>datatables/dataTables.bootstrap.min.css" />
<script src="<?php echo PLUG_URL;?>datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo PLUG_URL;?>datatables/dataTables.bootstrap.min.js"></script>
<!-- end load css dan js -->

<section class="content">
	<div class="container-fluid">
		<div class="card"> <!-- start .box -->
			<div class="card-header"> <!-- start .card-header -->
				<a class="btn btn-sm btn-primary" id="addSetting_account"><i class="fa fa-plus"></i> Tambah</a>&nbsp;&nbsp;
			</div> <!-- end .card-header -->
			
			<div class="card-body"> <!-- start .card-body -->
				<table id="tableSetting_account" class="table datares">
					<thead>
						<tr>				
							<th>No</th>				
							<th>f_account_name</th>				
							<th>f_account_contact</th>				
							<th>f_account_phone</th>				
							<th>f_account_email</th>				
							<th>f_account_noacc</th>				
							<th>f_account_logo</th>				
							<th>f_account_created_on</th>				
							<th>f_account_created_by</th>				
							<th>f_account_updated_on</th>				
							<th>f_account_updated_by</th>				
							<th>f_account_status</th>
							<th>Action</th>
						</tr>
					</thead>
				</table>
			</div> <!-- end .card-body -->
			<div class="card-footer" align="right"> <!-- start card-footer -->
			  <p>Page rendered in <strong>{elapsed_time}</strong> seconds</p>
			</div> <!-- end .card-footer-->
		</div> <!-- end .card -->
	</div> <!-- end .container-fluid -->
</section><!-- /.content -->

<script>
var oTable;
$(document).ready(function(){
	oTable = $('#tableSetting_account').DataTable({
		"order": [[ 0, "desc" ]],
		"processing": true,
		"serverSide": true,
		"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
		"ajax": {
            "url": "<?php echo site_url('setting_account/fnSetting_accountDataJson');?>",
            "type": "POST"
        },
		"columns": [
			{ data: 'f_account_id', searchable: false, name: 'f_account_id',className: 'left' , orderable: false,
				render: function (data, type, row, meta) {
					return meta.row + meta.settings._iDisplayStart + 1;
				}
			},
			{ data: 'f_account_name', name: 'f_account_name' },
			{ data: 'f_account_contact', name: 'f_account_contact' },
			{ data: 'f_account_phone', name: 'f_account_phone' },
			{ data: 'f_account_email', name: 'f_account_email' },
			{ data: 'f_account_noacc', name: 'f_account_noacc' },
			{ data: 'f_account_logo', name: 'f_account_logo' },
			{ data: 'f_account_created_on', name: 'f_account_created_on' },
			{ data: 'f_account_created_by', name: 'f_account_created_by' },
			{ data: 'f_account_updated_on', name: 'f_account_updated_on' },
			{ data: 'f_account_updated_by', name: 'f_account_updated_by' },
			{ data: 'f_account_status', name: 'f_account_status' },
			{ data: 'f_account_id', searchable: false, name: 'f_account_id',className: 'center' , orderable: false,
				render: function (data, type, row, meta) {
					var button = "";
					button += "&nbsp;<a href='javascript:void(0)' class='tip' title='Edit' onclick='fnEdit("+data+")'><i class='far fa-edit'></i></a>&nbsp;&nbsp;"; 
					button += "&nbsp;<a href='javascript:void(0)'  class='tip' title='Hapus' onclick='fnDelete("+data+")'><i class='text-red far fa-trash-alt'></i></a>&nbsp;"; 
					return button;
				}
			},
		],
	});
	$(".dataTables_filter input").attr("placeholder","Cari Kata disini ...");

	$('#addSetting_account').click(function()	{
		window.location.href = "<?php echo site_url('setting_account/fnSetting_accountAdd');?>";
	});
});

function fnEdit(idRow)
{
	window.location.href = "<?php echo site_url('setting_account/fnSetting_accountEdit');?>/"+idRow;
}

function fnDelete(idRow)
{
	Swal.fire({
		title: 'Konfirmasi',
		text: 'Yakin ingin dihapus ?',
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Ya, hapus!'
	}).then((result) => {
		var urlUpdate='<?php echo site_url('setting_account/fnSetting_accountDelete');?>';
		if(result.value)
		{
			$.post(urlUpdate,{id : idRow,<?php echo $this->security->get_csrf_token_name();?>:'<?php echo $this->security->get_csrf_hash(); ?>'},function(html){
				if(html.msg) { oTable.ajax.reload();} 
				else
				{
					swal.fire({text: html.pesan,icon: 'error',confirmButtonText:'Close',confirmButtonColor: '#FF0000'});
				} 
			},'json');
		}	
	});
}

</script>



