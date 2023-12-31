<?php if ($_settings->chk_flashdata('success')) : ?>
    <script>
        alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success')
    </script>
<?php endif; ?>
<?php
if (isset($_GET['id']) && $_GET['id'] > 0) {
    $qry = $conn->query("SELECT r.*, p.name as cost_center  from `rq_list` r join `project_list` p on p.id = r.p_id where r.id = '{$_GET['id']}' ");
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
        <h3 class="card-title"><?php echo ("Requisition Order Details") ?> </h3>
        <div class="card-tools">
            <?php if ($status == 0) : ?>
                <a class="btn btn-flat btn-primary approve_requisition" href="javascript:void(0)" data-id="<?php echo $id ?>" style="margin-right: 10px‒;margin-right: 309px;">Approve this order</a>
            <?php endif; ?>
            <button class="btn btn-sm btn-flat btn-success" id="print" type="button"><i class="fa fa-print"></i> Print</button>
            <a class="btn btn-sm btn-flat btn-default" href="?page=store_requisitions">Back</a>
        </div>
    </div>
    <div class="card-body" id="out_print">


        <div class="row">
            <div class="col-4">
                <img src="<?php echo validate_image($_settings->info('logo')) ?>" alt="" height="200px">

            </div>
            <div class="col-4 d-flex align-items-center">
                <div>
                    <p class="m-0" style="font-weight: bold; text-transform: uppercase"><?php echo $_settings->info('company_name') ?></p>
                    <p class="m-0"><?php echo $_settings->info('company_location') ?></p>
                    <p class="m-0"><?php echo $_settings->info('company_address') ?></p>
                    <p class="m-0"><?php echo $_settings->info('company_mobile') ?></p>
                    <p class="m-0"><?php echo $_settings->info('company_email') ?></p>
                </div>
            </div>
            <div class="col-4 d-flex align-items-center">
                <div>
                    <H2>STORE REQUISITION ORDER</H2>
                    <p class="m-0">RQ No : <?php echo ($rq_no) ?></p>
                    <p class="m-0">Date : <?php echo date("Y-m-d", strtotime($date_created)) ?></p>
                    <?php 
                    switch ($status) {
                        case 1:
                            echo "<p class='m-0'>Status: Approved</p>";
                            break;
                        case 2:
                            echo "<p class='m-0'>Status: Processing</p>";
                            break;
                        case 3:
                            echo "<p class='m-0'>Status: Fulfilled</p>";
                            break;
                        default:
                            echo "<p class='m-0'>Status: Pending</p>";
                            break;
                    }
                    ?>
                </div>
            </div>

        </div>

        <div class="row">

            <div class="col-md-4 form-group" style="border: 1px solid #dee2e6;">
                <label for="ordered_by" class="contorol-label">Ordered By:</label>
                <?php
                if (isset($ordered_by) && ($ordered_by == 2)) {
                    $users_qry = $conn->query("SELECT concat(firstname,' ',lastname) as name FROM `users` WHERE type = 2");
                    $rows = $users_qry->fetch_assoc(); ?>
                    <p><?php echo $rows['name'] ?></p>
                <?php }
                ?>
            </div>

            <div class="col-md-4 form-group" style="border: 1px solid #dee2e6;">
                <label for="approved_by" class="contorol-label">Approved By:</label>
                <?php
                if ($status != 0) {
                    if (isset($approved_by) && ($approved_by == 3)) {
                        $user_qry = $conn->query("SELECT concat(firstname,' ',lastname) as name FROM `users` WHERE type = 3");
                        $row = $user_qry->fetch_assoc(); ?>
                        <p><?php echo $row['name'] ?></p>
                    <?php }
                } else { ?>
                    <p style="color:red"><?php echo ("Pending Approval") ?></p>
                <?php } ?>
            </div>

            <div class="col-md-4 form-group" style="border: 1px solid #dee2e6;">
                <label for="p_id" class="control-label">Account to Charge/Cost Center:</label>
                <p><?php echo isset($cost_center) ? $cost_center : '' ?></p>
            </div>

            <div class="col-md-4 form-group" style="border: 1px solid #dee2e6;">
                <label for="deliver_to" class="contorol-label">Deliver To:</label>
                <p><?php echo isset($deliver_to) ? $deliver_to : '' ?></p>
            </div>

            <div class="col-md-4 form-group" style="border: 1px solid #dee2e6;">
                <label for="department_name" class="control-label">Department Name:</label>
                <p><?php echo isset($department_name) ? $department_name : '' ?></p>
            </div>

            <div class="col-md-4 form-group" style="border: 1px solid #dee2e6;">
                <label for="building_name" class="control-label">Building Name & Room Number:</label>
                <p><?php echo isset($building_name) ? $building_name : '' ?></p>
            </div>

        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-striped table-bordered" id="item-list">
                    <colgroup>
                        <col width="10%">
                        <col width="10%">
                        <col width="20%">
                        <col width="30%">
                        <col width="15%">
                        <col width="15%">
                    </colgroup>
                    <thead>
                        <tr class="bg-navy disabled">
                            <th class="bg-navy disabled text-light px-1 py-1 text-center">Qty</th>
                            <th class="bg-navy disabled text-light px-1 py-1 text-center">Unit</th>
                            <th class="bg-navy disabled text-light px-1 py-1 text-center">Item</th>
                            <th class="bg-navy disabled text-light px-1 py-1 text-center">Description</th>
                            <th class="bg-navy disabled text-light px-1 py-1 text-center">Price</th>
                            <th class="bg-navy disabled text-light px-1 py-1 text-center">Sub Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (isset($id)) :
                            $requested_items_qry = $conn->query("SELECT r.*,i.name, i.unit, i.description, i.selling_price FROM `requisition_items` r inner join item_list i on r.item_id = i.id where r.`rq_id` = '$id' ");
                            $sub_total = 0;
                            while ($row = $requested_items_qry->fetch_assoc()) :
                                $sub_total += ($row['quantity'] * $row['selling_price']);
                        ?>
                                <tr class="po-item" data-id="">
                                    <td class="align-middle p-0 text-center"><?php echo $row['quantity'] ?></td>
                                    <td class="align-middle p-1"><?php echo $row['unit'] ?></td>
                                    <td class="align-middle p-1"><?php echo $row['name'] ?></td>
                                    <td class="align-middle p-1 item-description"><?php echo $row['description'] ?></td>
                                    <td class="align-middle p-1"><?php echo number_format($row['selling_price']) ?></td>
                                    <td class="align-middle p-1 text-right total-price"><?php echo number_format($row['quantity'] * $row['selling_price']) ?></td>
                                </tr>
                        <?php endwhile;
                        endif; ?>
                    </tbody>
                    <tfoot>
                        <tr class="bg-lightblue">
                        <tr>
                            <th class="p-1 text-right" colspan="5">Total</th>
                            <th class="p-1 text-right" id="total"><?php echo number_format($sub_total) ?></th>
                        </tr>
                        </tr>
                    </tfoot>
                </table>

                <div class="row">

                    <div class="col-12">
                        <label for="notes" class="control-label">Notes</label>
                        <p><?php echo isset($notes) ? $notes : '' ?></p>
                    </div>

                    <div class="col-md-4 form-group" style="border: 1px solid #dee2e6;">
                        <label for="date_fulfilled" class="contorol-label">Date Fulfilled:</label>
                        <?php
                        if ($status == 3) { ?>
                            <p><?php echo isset($date_fulfilled) ? $date_fulfilled : "" ?></p>
                        <?php } else { ?>
                            <p style="color:red"><?php echo ("Pending Fulfillment") ?></p>
                        <?php }
                        ?>
                    </div>

                    <div class="col-md-4 form-group" style="border: 1px solid #dee2e6;">
                        <label for="approved_by" class="contorol-label">Fulflled By:</label>
                        <?php
                        if ($status == 3) {
                            if (isset($fulfilled_by) && ($fulfilled_by == 4)) {
                                $user_qry = $conn->query("SELECT concat(firstname,' ',lastname) as name FROM `users` WHERE type = 4");
                                $row = $user_qry->fetch_assoc(); ?>
                                <p><?php echo $row['name'] ?></p>
                            <?php }
                        } else { ?>
                            <p style="color:red"><?php echo ("Pending Fulfillment") ?></p>
                        <?php } ?>
                    </div>

                    <div class="col-md-4 form-group" style="border: 1px solid #dee2e6;">
                        <label for="approved_by" class="contorol-label">Checked By:</label>
                        <?php
                        if ($status == 3) {
                            if (isset($checked_by) && ($checked_by == 5)) {
                                $user_qry = $conn->query("SELECT concat(firstname,' ',lastname) as name FROM `users` WHERE type = 5");
                                $row = $user_qry->fetch_assoc(); ?>
                                <p><?php echo $row['name'] ?></p>
                            <?php }
                        } else { ?>
                            <p style="color:red"><?php echo ("Pending Fulfillment") ?></p>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
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
            <input type="number" step="any" class="text-right w-100 border-0" name="selling_price[]" value="0" />
        </td>
        <td class="align-middle p-1 text-right total-price">0</td>
    </tr>
</table>
<script>
    $(function() {
        $(document).ready(function() {
            $('.approve_requisition').click(function() {
                _conf("Are you sure to approve this Requisition Order? Action cannot be undone!", "approve_requisition", [$(this).attr('data-id')])
            })
        })

        $('#print').click(function(e) {
            e.preventDefault();
            start_loader();
            var _h = $('head').clone()
            var _p = $('#out_print').clone()
            var _el = $('<div>')
            _p.find('thead th').attr('style', 'color:black !important')
            _el.append(_h)
            _el.append(_p)

            var nw = window.open("", "", "width=1200,height=950")
            nw.document.write(_el.html())
            nw.document.close()
            setTimeout(() => {
                nw.print()
                setTimeout(() => {
                    end_loader();
                    nw.close()
                }, 300);
            }, 200);
        })
    })

    function approve_requisition($id) {
        start_loader();
        $.ajax({
            url: _base_url_ + "classes/Master.php?f=approve_requisition",
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