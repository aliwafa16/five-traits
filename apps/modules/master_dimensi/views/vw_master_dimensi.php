<!-- load css dan js -->
<link type="text/css" rel="stylesheet" href="<?php echo PLUG_URL;?>datatables/dataTables.bootstrap.min.css" />
<script src="<?php echo PLUG_URL;?>datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo PLUG_URL;?>datatables/dataTables.bootstrap.min.js"></script>
<!-- end load css dan js -->

<section class="content">
	<div class="container-fluid">
		<div class="card"> <!-- start .box -->
			<div class="card-header"> <!-- start .card-header -->
				<a class="btn btn-sm btn-primary" id="addMaster_dimensi"><i class="fa fa-plus"></i> Tambah</a>&nbsp;&nbsp;
			</div> <!-- end .card-header -->
			
			<div class="card-body"> <!-- start .card-body -->
				<table id="tableMaster_dimensi" class="table datares">
					<thead>
						<tr>				
							<th>No</th>				
							<th>Variabel</th>
							<th>Dimensi</th>				
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
	oTable = $('#tableMaster_dimensi').DataTable({
		"order": [[ 0, "desc" ]],
		"processing": true,
		"serverSide": true,
		"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
		"ajax": {
            "url": "<?php echo site_url('master_dimensi/fnMaster_dimensiDataJson');?>",
            "type": "POST"
        },
		"columns": [
			{ data: 'f_id', searchable: false, name: 'f_id',className: 'left' , orderable: false,
				render: function (data, type, row, meta) {
					return meta.row + meta.settings._iDisplayStart + 1;
				}
			},
			{ data: 'f_variabel_name', name: 'f_variabel_name' },
			{ data: 'f_dimensi_name', name: 'f_dimensi_name' },
			{ data: 'f_id', searchable: false, name: 'f_id',className: 'text-center' , orderable: false,
				render: function (data, type, row, meta) {
					var button = "";
					button += "&nbsp;<a href='javascript:void(0)' class='tip' title='Edit' onclick='fnEdit("+data+")'><i class='far fa-edit'></i></a>&nbsp;&nbsp;"; 
					//button += "&nbsp;<a href='javascript:void(0)'  class='tip' title='Hapus' onclick='fnDelete("+data+")'><i class='text-red far fa-trash-alt'></i></a>&nbsp;"; 
					return button;
				}
			},
		],
	});
	$(".dataTables_filter input").attr("placeholder","Cari Kata disini ...");

	$('#addMaster_dimensi').click(function()	{
		window.location.href = "<?php echo site_url('master_dimensi/fnMaster_dimensiAdd');?>";
	});
});

function fnEdit(idRow)
{
	window.location.href = "<?php echo site_url('master_dimensi/fnMaster_dimensiEdit');?>/"+idRow;
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
		var urlUpdate='<?php echo site_url('master_dimensi/fnMaster_dimensiDelete');?>';
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


