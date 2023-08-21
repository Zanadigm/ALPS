<?php if ($_settings->chk_flashdata('success')) : ?>
	<script>
		alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success')
	</script>
<?php endif; ?>
<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">List of Invoices</h3>
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
							<th>IN #</th>
							<th>Client</th>
							<th>Items</th>
							<th>Total Amount</th>
							<th>Status</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$i = 1;
						$qry = $conn->query("SELECT v.*,r.deliver_to FROM `invoice_list` v inner join `rq_list` r on r.id = v.rq_id");
						while ($row = $qry->fetch_assoc()) :
							$row['item_count'] = $conn->query("SELECT * FROM delivery_items inner join delivery_list on id = dn_id where rq_no = '{$row['rq_id']}'")->num_rows;
							$row['total_amount'] = $conn->query("SELECT sum(d.quantity * i.selling_price) as total FROM delivery_items d inner join item_list i on i.id = d.item_id inner join delivery_list dl on dl.id = d.dn_id where rq_no = '{$row['rq_id']}'")->fetch_array()['total'];
						?>

							<tr>
								<td class="text-center"><?php echo $i++; ?></td>
								<td class=""><?php echo date("M d,Y H:i", strtotime($row['date_created'])); ?></td>
								<td class=""><?php echo $row['in_no'] ?></td>
								<td class=""><?php echo $row['deliver_to']?></td>
								<td class="text-right"><?php echo number_format($row['item_count']) ?></td>
								<td class="text-right"><?php echo number_format($row['total_amount']) ?></td>
								<td>
									<?php
									switch ($row['status']) {
										case '1':
											echo '<span class="badge badge-success">Paid</span>';
											break;
										case '2':
											echo '<span class="badge badge-danger">Overdue</span>';
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
										<a class="dropdown-item" href="?page=invoices/view_details&id=<?php echo $row['id'] ?>"><span class="fa fa-eye text-primary"></span> View</a>
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
	$(document).ready(function() {
		$('.delete_data').click(function() {
			_conf("Are you sure to delete this invoice permanently?", "delete_in", [$(this).attr('data-id')])
		})
		$('.view_details').click(function() {
			uni_modal("Reservaton Details", "invoices/view_details.php?id=" + $(this).attr('data-id'), 'mid-large')
		})
		$('.table th,.table td').addClass('px-1 py-0 align-middle')
		$('.table').dataTable();
	})

	function delete_in($id) {
		start_loader();
		$.ajax({
			url: _base_url_ + "classes/Master.php?f=delete_in",
			method: "POST",
			data: {
				id: $id
			},
			dataType: "json",
			error: err => {
				console.log(err)
				alert_toast("An error occured.", 'error');
				end_loader();
			},
			success: function(resp) {
				if (typeof resp == 'object' && resp.status == 'success') {
					location.reload();
				} else {
					alert_toast("An error occured.", 'error');
					end_loader();
				}
			}
		})
	}
</script>