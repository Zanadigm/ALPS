<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">List of Store Requisitions</h3>
		<div class="card-tools">
			<a href="?page=store_requisitions/manage_rq" class="btn btn-flat btn-primary"><span class="fas fa-plus"></span>  Create New</a>
		</div>
	</div>
	<div class="card-body">
		<div class="container-fluid">
        <div class="container-fluid">
			<table class="table table-hover table-striped">
				<colgroup>
					<col width="5%">
					<col width="15%">
					<col width="20%">
					<col width="20%">
					<col width="10%">
					<col width="10%">
					<col width="10%">
					<col width="10%">
				</colgroup>
				<thead>
					<tr class="bg-navy disabled">
						<th>#</th>
						<th>Date Created</th>
						<th>RQ #</th>
						<th>Cost Center</th>
						<th>Items</th>
						<th>Total Amount</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$i = 1;
					$qry = $conn->query("SELECT rq.*, p.name as pname FROM `rq_list` rq inner join `project_list` p on rq.p_id = p.id order by unix_timestamp(rq.date_updated)");
						while($row = $qry->fetch_assoc()):
							$row['item_count'] = $conn->query("SELECT * FROM requisition_items where rq_id = '{$row['id']}'")->num_rows;
							$row['total_amount'] = $conn->query("SELECT sum(r.quantity * i.unit_price) as total FROM requisition_items r inner join item_list i on i.id = r.item_id where rq_id = '{$row['id']}'")->fetch_array()['total'];
					?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td class=""><?php echo date("M d,Y H:i",strtotime($row['date_created'])) ; ?></td>
							<td class=""><?php echo $row['rq_no'] ?></td>
							<td class=""><?php echo $row['pname'] ?></td>
							<td class="text-right"><?php echo number_format($row['item_count']) ?></td>
							<td class="text-right"><?php echo number_format($row['total_amount']) ?></td>
							<td>
								<?php 
									switch ($row['status']) {
										case '1':
											echo '<span class="badge badge-secondary">Approved</span>';
											break;
										case '2':
											echo '<span class="badge badge-success">Processing</span>';
											break;
										case '3':
											echo '<span class="badge badge-success">Fulfilled</span>';
											break;
										default:
											echo '<span class="badge badge-secondary">Pending</span>';
											break;
									}
								?>
							</td>
							<td align="center">
								 <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
				                  		Action
				                    <span class="sr-only">Toggle Dropdown</span>
				                  </button>
				                  <div class="dropdown-menu" role="menu">
								  	<a class="dropdown-item" href="?page=store_requisitions/view_rq&id=<?php echo $row['id'] ?>"><span class="fa fa-eye text-primary"></span> View</a>
									<?php if($row['status'] == 0): ?>
				                    <div class="dropdown-divider"></div>
				                    <a class="dropdown-item" href="?page=store_requisitions/manage_rq&id=<?php echo $row['id'] ?>"><span class="fa fa-edit text-primary"></span> Edit</a>
				                    <div class="dropdown-divider"></div>
				                    <a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-trash text-danger"></span> Delete</a>
									<?php endif;?>
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
			_conf("Are you sure to delete this requisition order permanently?","delete_rq",[$(this).attr('data-id')])
		})
		$('.view_details').click(function(){
			uni_modal("Reservaton Details","store_requisitions/view_details.php?id="+$(this).attr('data-id'),'mid-large')
		})
		$('.table th,.table td').addClass('px-1 py-0 align-middle')
		$('.table').dataTable();
	})
	function delete_rq($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_rq",
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