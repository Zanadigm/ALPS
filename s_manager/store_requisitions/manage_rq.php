<?php
if (isset($_GET['id']) && $_GET['id'] > 0) {
	$qry = $conn->query("SELECT * from `rq_list` where id = '{$_GET['id']}' ");
	if ($qry->num_rows > 0) {
		foreach ($qry->fetch_assoc() as $k => $v) {
			$$k = $v;
		}
	}
}
?>
<style>
	span.select2-selection.select2-selection--single {
		border-radius: 0;
		padding: 0.25rem 0.5rem;
		padding-top: 0.25rem;
		padding-right: 0.5rem;
		padding-bottom: 0.25rem;
		padding-left: 0.5rem;
		height: auto;
	}

	/* Chrome, Safari, Edge, Opera */
	input::-webkit-outer-spin-button,
	input::-webkit-inner-spin-button {
		-webkit-appearance: none;
		margin: 0;
	}
</style>
<div class="card card-outline card-info">
	<div class="card-header">
		<h3 class="card-title"><?php echo isset($id) ? "Update Store Requisition Details" : "New Requisition Order" ?> </h3>
	</div>
	<div class="card-body">
		<form action="" id="po-form">
			<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
			<?php
			$ordered_by = 2;
			$approved_by = 3;
			$fulfilled_by = 4;
			$checked_by = 5;
			?>
			<input type="hidden" name="ordered_by" value="<?php echo isset($ordered_by) ? $ordered_by : '' ?>">
			<input type="hidden" name="approved_by" value="<?php echo isset($approved_by) ? $approved_by : '' ?>">
			<input type="hidden" name="fulfilled_by" value="<?php echo isset($fulfilled_by) ? $fulfilled_by : '' ?>">
			<input type="hidden" name="checked_by" value="<?php echo isset($checked_by) ? $checked_by : '' ?>">

			<div class="row">
				<div class="col-md-4 form-group">
					<label for="deliver_to">Deliver To <span class="po_err_msg text-danger"></span></label>
					<input type="text" class="form-control form-control-sm rounded-0" id="deliver_to" name="deliver_to" value="<?php echo isset($deliver_to) ? $deliver_to : '' ?>">
				</div>

				<div class="col-md-4 form-group">
					<label for="department_name">Department Name <span class="po_err_msg text-danger"></span></label>
					<input type="text" class="form-control form-control-sm rounded-0" id="department_name" name="department_name" value="<?php echo isset($department_name) ? $department_name : '' ?>">
				</div>

				<div class="col-md-4 form-group">
					<label for="building_name">Building Name & Room Number<span class="po_err_msg text-danger"></span></label>
					<input type="text" class="form-control form-control-sm rounded-0" id="building_name" name="building_name" value="<?php echo isset($building_name) ? $building_name : '' ?>">
				</div>

				<div class="col-md-6 form-group">
					<label for="p_id">Cost Center/Account to Charge</label>
					<select name="p_id" id="p_id" class="custom-select custom-select-sm rounded-0 select2">
						<option value="" disabled <?php echo !isset($p_id) ? "selected" : '' ?>></option>
						<?php
						$project_qry = $conn->query("SELECT * FROM `project_list` order by `name` asc");
						while ($row = $project_qry->fetch_assoc()) :
						?>
							<option value="<?php echo $row['id'] ?>" <?php echo isset($p_id) && $p_id == $row['id'] ? 'selected' : '' ?> <?php echo $row['status'] == 1 ? 'disabled' : '' ?>><?php echo $row['name'] ?></option>
						<?php endwhile; ?>
					</select>
				</div>

				<div class="col-md-6 form-group">
					<label for="rq_no">RQ # <span class="po_err_msg text-danger"></span></label>
					<input type="text" class="form-control form-control-sm rounded-0" id="rq_no" name="rq_no" value="<?php echo isset($rq_no) ? $rq_no : '' ?>">
					<small><i>Leave this blank to Automatically Generate upon saving.</i></small>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<table class="table table-striped table-bordered" id="item-list">
						<colgroup>
							<col width="5%">
							<col width="5%">
							<col width="10%">
							<col width="20%">
							<col width="30%">
							<col width="15%">
							<col width="15%">
						</colgroup>
						<thead>
							<tr class="bg-navy disabled">
								<th class="px-1 py-1 text-center"></th>
								<th class="px-1 py-1 text-center">Qty</th>
								<th class="px-1 py-1 text-center">Unit</th>
								<th class="px-1 py-1 text-center">Item</th>
								<th class="px-1 py-1 text-center">Description</th>
								<th class="px-1 py-1 text-center">Price</th>
								<th class="px-1 py-1 text-center">Total</th>
							</tr>
						</thead>
						<tbody>
							<?php
							if (isset($id)) :
								$requested_items_qry = $conn->query("SELECT r.*,i.name, i.description FROM `requisition_items` r inner join item_list i on r.item_id = i.id where r.`rq_id` = '$id' ");
								echo $conn->error;
								while ($row = $requested_items_qry->fetch_assoc()) :
							?>
									<tr class="po-item" data-id="">
										<td class="align-middle p-1 text-center">
											<button class="btn btn-sm btn-danger py-0" type="button" onclick="rem_item($(this))"><i class="fa fa-times"></i></button>
										</td>
										<td class="align-middle p-0 text-center">
											<input type="number" class="text-center w-100 border-0" step="any" name="qty[]" value="<?php echo $row['quantity'] ?>" />
										</td>
										<td class="align-middle p-1">
											<input type="text" class="text-center w-100 border-0" name="unit[]" value="<?php echo $row['unit'] ?>" />
										</td>
										<td class="align-middle p-1">
											<input type="hidden" name="item_id[]" value="<?php echo $row['item_id'] ?>">
											<input type="text" class="text-center w-100 border-0 item_id" value="<?php echo $row['name'] ?>" required />
										</td>
										<td class="align-middle p-1 item-description"><?php echo $row['description'] ?></td>
										<td class="align-middle p-1">
											<input type="number" step="any" class="text-right w-100 border-0" name="unit_price[]" value="<?php echo ($row['unit_price']) ?>" />
										</td>
										<td class="align-middle p-1 text-right total-price"><?php echo number_format($row['quantity'] * $row['unit_price']) ?></td>
									</tr>
							<?php endwhile;
							endif; ?>
						</tbody>
						<tfoot>
							<tr class="bg-lightblue">
							<tr>
								<th class="p-1 text-right" colspan="6"><span><button class="btn btn btn-sm btn-flat btn-primary py-0 mx-1" type="button" id="add_row">Add Row</button></span> Sub Total</th>
								<th class="p-1 text-right" id="sub_total">0</th>
							</tr>
							<tr>
								<th class="p-1 text-right" colspan="6">Total</th>
								<th class="p-1 text-right" id="total">0</th>
							</tr>
							</tr>
						</tfoot>
					</table>
					<div class="row">
						<div class="col-md-6">
							<label for="notes" class="control-label">Notes</label>
							<textarea name="notes" id="notes" cols="10" rows="4" class="form-control rounded-0"><?php echo isset($notes) ? $notes : '' ?></textarea>
						</div>
						<div class="col-md-6">
							<label for="status" class="control-label">Status</label>
							<select name="status" id="status" class="form-control form-control-sm rounded-0">
								<option value="0" <?php echo isset($status) && $status == 0 ? 'selected' : '' ?>>Pending</option>
								<option value="1" <?php echo isset($status) && $status == 1 ? 'selected' : '' ?>>Processing</option>
								<option value="2" <?php echo isset($status) && $status == 2 ? 'selected' : '' ?>>Fulfilled</option>
							</select>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
	<div class="card-footer">
		<button class="btn btn-flat btn-primary" form="po-form">Save</button>
		<a class="btn btn-flat btn-default" href="?page=store_requisitions">Cancel</a>
	</div>
</div>
<table class="d-none" id="item-clone">
	<tr class="po-item" data-id="">
		<td class="align-middle p-1 text-center">
			<button class="btn btn-sm btn-danger py-0" type="button" onclick="rem_item($(this))"><i class="fa fa-times"></i></button>
		</td>
		<td class="align-middle p-0 text-center">
			<input type="number" class="text-center w-100 border-0" step="any" name="qty[]" />
		</td>
		<td class="align-middle p-1">
			<input type="text" class="text-center w-100 border-0" name="unit[]" />
		</td>
		<td class="align-middle p-1">
			<input type="hidden" name="item_id[]">
			<input type="text" class="text-center w-100 border-0 item_id" required />
		</td>
		<td class="align-middle p-1 item-description"></td>
		<td class="align-middle p-1">
			<input type="number" step="any" class="text-right w-100 border-0" name="unit_price[]" value="0" />
		</td>
		<td class="align-middle p-1 text-right total-price">0</td>
	</tr>
</table>
<script>
	function rem_item(_this) {
		_this.closest('tr').remove()
	}

	function calculate() {
		var _total = 0
		$('.po-item').each(function() {
			var qty = $(this).find("[name='qty[]']").val()
			var unit_price = $(this).find("[name='unit_price[]']").val()
			var row_total = 0;
			if (qty > 0 && unit_price > 0) {
				row_total = parseFloat(qty) * parseFloat(unit_price)
			}
			$(this).find('.total-price').text(parseFloat(row_total).toLocaleString('en-US'))
		})
		$('.total-price').each(function() {
			var _price = $(this).text()
			_price = _price.replace(/\,/gi, '')
			_total += parseFloat(_price)
		})
		$('#sub_total').text(parseFloat(_total).toLocaleString("en-US"))
		$('#total').text(parseFloat(_total).toLocaleString("en-US"))
	}

	function _autocomplete(_item) {
		_item.find('.item_id').autocomplete({
			source: function(request, response) {
				$.ajax({
					url: _base_url_ + "classes/Master.php?f=search_items",
					method: 'POST',
					data: {
						q: request.term
					},
					dataType: 'json',
					error: err => {
						console.log(err)
					},
					success: function(resp) {
						response(resp)
					}
				})
			},
			select: function(event, ui) {
				console.log(ui)
				_item.find('input[name="item_id[]"]').val(ui.item.id)
				_item.find('.item-description').text(ui.item.description)
			}
		})
	}

	$(document).ready(function() {
		$('#add_row').click(function() {
			var tr = $('#item-clone tr').clone()
			$('#item-list tbody').append(tr)
			_autocomplete(tr)
			tr.find('[name="qty[]"],[name="unit_price[]"]').on('input keypress', function(e) {
				calculate()
			})
		})
		if ($('#item-list .po-item').length > 0) {
			$('#item-list .po-item').each(function() {
				var tr = $(this)
				_autocomplete(tr)
				tr.find('[name="qty[]"],[name="unit_price[]"]').on('input keypress', function(e) {
					calculate()
				})
				$('#item-list tfoot').find('[name="discount_percentage"],[name="tax_percentage"]').on('input keypress', function(e) {
					calculate()
				})
				tr.find('[name="qty[]"],[name="unit_price[]"]').trigger('keypress')
			})
		} else {
			$('#add_row').trigger('click')
		}
		$('.select2').select2({
			placeholder: "Please Select here",
			width: "relative"
		})
		$('#po-form').submit(function(e) {
			e.preventDefault();
			var _this = $(this)
			$('.err-msg').remove();
			$('[name="rq_no"]').removeClass('border-danger')
			if ($('#item-list .po-item').length <= 0) {
				alert_toast(" Please add atleast 1 item on the list.", 'warning')
				return false;
			}
			start_loader();
			$.ajax({
				url: _base_url_ + "classes/Master.php?f=save_rq",
				data: new FormData($(this)[0]),
				cache: false,
				contentType: false,
				processData: false,
				method: 'POST',
				type: 'POST',
				dataType: 'json',
				error: err => {
					console.log(err)
					alert_toast("An error occured", 'error');
					end_loader();
				},
				success: function(resp) {
					if (typeof resp == 'object' && resp.status == 'success') {
						location.href = "./?page=store_requisitions/view_rq&id=" + resp.id;
					} else if ((resp.status == 'failed' || resp.status == 'rq_failed') && !!resp.msg) {
						var el = $('<div>')
						el.addClass("alert alert-danger err-msg").text(resp.msg)
						_this.prepend(el)
						el.show('slow')
						$("html, body").animate({
							scrollTop: 0
						}, "fast");
						end_loader()
						if (resp.status == 'rq_failed') {
							$('[name="rq_no"]').addClass('border-danger').focus()
						}
					} else {
						alert_toast("An error occured", 'error');
						end_loader();
						console.log(resp)
					}
				}
			})
		})

	})
</script>