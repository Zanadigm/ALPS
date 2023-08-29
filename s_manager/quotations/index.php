<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">List of Quotations</h3>
		<div class="card-tools">
			<a href="?page=quotations/manage_quote" class="btn btn-flat btn-primary"><span class="fas fa-plus"></span>  Create New</a>
		</div>
	</div>
	<div class="card-body">
		<div class="container-fluid">
        <div class="container-fluid">
			<table class="table table-hover table-striped">
				<colgroup>
					<col width="5%">
					<col width="20%">
					<col width="15%">
					<col width="30%">
					<col width="10%">
					<col width="10%">
					<col width="10%">
				</colgroup>
				<thead>
					<tr class="bg-navy disabled">
						<th>#</th>
						<th>Date Created</th>
						<th>QO #</th>
						<th>Client</th>
						<th>Items</th>
						<th>Total Amount</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$i = 1;
					$qry = $conn->query("SELECT qo.*, c.name as client_name FROM `quotation_list` qo inner join `client_list` c on qo.client_id = c.id order by unix_timestamp(qo.date_updated)");
						while($row = $qry->fetch_assoc()):
							$row['item_count'] = $conn->query("SELECT * FROM quotation_items where qo_id = '{$row['id']}'")->num_rows;
							$row['total_amount'] = $conn->query("SELECT sum(r.quantity * i.selling_price) as total FROM quotation_items r inner join item_list i on i.id = r.item_id where qo_id = '{$row['id']}'")->fetch_array()['total'];
					?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td class=""><?php echo date("M d,Y H:i",strtotime($row['date_created'])) ; ?></td>
							<td class="">
								<a href="?page=quotations/view_details&id=<?php echo $row['id'] ?>"><?php echo $row['qo_no'] ?></a>
							</td>
							<td class=""><?php echo $row['client_name'] ?></td>
							<td class="text-right"><?php echo number_format($row['item_count']) ?></td>
							<td class="text-right"><?php echo number_format(($row['total_amount'] + $row['labor_amount']) - $row['discount_amount']) ?></td>

							<td align="center">
								<button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
				                 		Action
				                   <span class="sr-only">Toggle Dropdown</span>
				                </button>
				                <div class="dropdown-menu" role="menu">
								 	<a class="dropdown-item" href="?page=quotations/view_details&id=<?php echo $row['id'] ?>"><span class="fa fa-eye text-primary"></span> View</a>
				                   <div class="dropdown-divider"></div>
				                   <a class="dropdown-item" href="?page=quotations/manage_quote&id=<?php echo $row['id'] ?>"><span class="fa fa-edit text-primary"></span> Edit</a>
				                   <div class="dropdown-divider"></div>
				                   <a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-trash text-danger"></span> Delete</a>
				                </div>
							</td>
						</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('.delete_data').click(function(){
			_conf("Are you sure to delete this quotation permanently?","delete_qo",[$(this).attr('data-id')])
		})
		$('.view_details').click(function(){
			uni_modal("Reservaton Details","quotations/view_details.php?id="+$(this).attr('data-id'),'mid-large')
		})
		$('.table th,.table td').addClass('px-1 py-0 align-middle')
		$('.table').dataTable();
	})
	function delete_qo($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_qo",
			method:"POST",
			data:{id: $id},
			dataType:"json",
			error:err=>{
				console.log(err)
				alert_toast("An error occured.",'error');
				end_loader();
			},
			success:function(resp){
				if(typeof resp== 'object' && resp.status == 'success'){
					location.reload();
				}else{
					alert_toast("An error occured.",'error');
					end_loader();
				}
			}
		})
	}
	
</script>