<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">List of Deliveries</h3>
	</div>
	<div class="card-body">
		<div class="container-fluid">
        <div class="container-fluid">
			<table class="table table-hover table-striped">
				<colgroup>
					<col width="5%">
					<col width="20%">
					<col width="20%">
					<col width="25%">
					<col width="10%">
					<col width="10%">
					<col width="10%">
				</colgroup>
				<thead>
					<tr class="bg-navy disabled">
						<th>#</th>
						<th>Date Created</th>
						<th>DN #</th>
						<th>Driver</th>
						<th>Items</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$i = 1;
					$qry = $conn->query("SELECT dl.*, u.username FROM `delivery_list` dl inner join `users` u on dl.driver_id = u.id order by unix_timestamp(dl.date_updated) ");
						while($row = $qry->fetch_assoc()):
							$row['item_count'] = $conn->query("SELECT * FROM delivery_items where dn_id = '{$row['id']}'")->num_rows;
							$row['total_amount'] = $conn->query("SELECT sum(d.quantity * i.selling_price) as total FROM delivery_items d inner join item_list i on i.id = d.item_id where dn_id = '{$row['id']}'")->fetch_array()['total'];
					?>  
					    
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td class=""><?php echo date("M d,Y H:i",strtotime($row['date_created'])) ; ?></td>
							<td class=""><?php echo $row['dn_no'] ?></td>
							<td class=""><?php echo $row['username'] ?></td>
							<td class="text-right"><?php echo number_format($row['item_count']) ?></td>
							<td>
								<?php 
									switch ($row['status']) {
										case '1':
											echo '<span class="badge badge-success">Confirmed</span>';
											break;
										case '2':
											echo '<span class="badge badge-success">Cancelled</span>';
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
								 	<a class="dropdown-item" href="?page=deliveries/view_details&id=<?php echo $row['id'] ?>"><span class="fa fa-eye text-primary"></span> View</a>
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
		$('.view_details').click(function(){
			uni_modal("Delivery Details","deliveries/view_details.php?id="+$(this).attr('data-id'),'mid-large')
		})
		$('.table th,.table td').addClass('px-1 py-0 align-middle')
		$('.table').dataTable();
	})
	
</script>