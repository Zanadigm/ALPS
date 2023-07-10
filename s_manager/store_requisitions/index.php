<?php if ($_settings->chk_flashdata('success')) : ?>
	<script>
		alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success')
	</script>
<?php endif; ?>
<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">List of Approved Store Requisitions</h3>
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
						$qry = $conn->query("SELECT rq.*, p.name as pname FROM `rq_list` rq inner join `project_list` p on rq.p_id = p.id where rq.status !=0 order by unix_timestamp(rq.date_updated)");
						while ($row = $qry->fetch_assoc()) :
							$row['item_count'] = $conn->query("SELECT * FROM requisition_items where rq_id = '{$row['id']}'")->num_rows;
							$row['total_amount'] = $conn->query("SELECT sum(r.quantity * i.unit_price) as total FROM requisition_items r inner join item_list i on i.id = r.item_id where rq_id = '{$row['id']}'")->fetch_array()['total'];
						?>

							<tr>
								<td class="text-center"><?php echo $i++; ?></td>
								<td class=""><?php echo date("M d,Y H:i", strtotime($row['date_created'])); ?></td>
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
	$(document).ready(function() {
		$('.view_details').click(function() {
			uni_modal("Requisition Order Details", "store_requisitions/view_rq.php?id=" + $(this).attr('data-id'), 'mid-large')
		})
		$('.table th,.table td').addClass('px-1 py-0 align-middle')
		$('.table').dataTable();
	})
</script>