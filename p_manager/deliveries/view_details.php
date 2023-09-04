<?php if ($_settings->chk_flashdata('success')) : ?>
    <script>
        alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success')
    </script>
<?php endif; ?>
<?php
if (isset($_GET['id']) && $_GET['id'] > 0) {
    $qry = $conn->query("SELECT d.*, r.id as rid, r.rq_no, r.deliver_to, r.department_name, r.building_name FROM delivery_list d  inner join rq_list r on d.rq_no = r.id where d.id = '{$_GET['id']}' ");
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
        <h3 class="card-title"><?php echo  "Delivery Note " ?> </h3>
        <div class="card-tools">
            <?php if ($status == 0) : ?>
                <a class="btn btn-flat btn-primary confirm_delivery" href="javascript:void(0)" data-id="<?php echo $_GET['id'] ?>" style="margin-right: 10px‒;margin-right: 309px;">Confirm this Delivery</a>
            <?php endif?>
            <button class="btn btn-sm btn-flat btn-success" id="print" type="button"><i class="fa fa-print"></i> Print</button>
            <a class="btn btn-sm btn-flat btn-default" href="?page=deliveries">Back</a>
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
                    <H2>DELIVERY NOTE</H2>
                    <p class="m-0">Ref No : <?php echo ($dn_no) ?></p>
                    <p class="m-0">Requisition No : <a href="?page=store_requisitions/view_rq&id=<?php echo ($rid) ?>" style="text-decoration: none;"><?php echo ($rq_no) ?></a></p>
                    <p class="m-0">Date : <?php echo date("Y-m-d", strtotime($date_created)) ?></p>
                </div>
            </div>

        </div>

        <div class="row">

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
                        <col width="15%">
                        <col width="15%">
                        <col width="30%">
                        <col width="40%">
                    </colgroup>
                    <thead>
                        <tr class="bg-navy disabled">
                            <th class="bg-navy disabled text-light px-1 py-1 text-center">Qty</th>
                            <th class="bg-navy disabled text-light px-1 py-1 text-center">Unit</th>
                            <th class="bg-navy disabled text-light px-1 py-1 text-center">Item</th>
                            <th class="bg-navy disabled text-light px-1 py-1 text-center">Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (isset($id)) :
                            $requested_items_qry = $conn->query("SELECT r.*,i.name, i.unit, i.description FROM `delivery_items` r inner join item_list i on r.item_id = i.id where r.`dn_id` = '$id' ");
                            while ($row = $requested_items_qry->fetch_assoc()) : ?>
                                <tr class="po-item">
                                    <td class="align-middle p-0 text-center"><?php echo $row['quantity'] ?></td>
                                    <td class="align-middle p-1"><?php echo $row['unit'] ?></td>
                                    <td class="align-middle p-1"><?php echo $row['name'] ?></td>
                                    <td class="align-middle p-1 item-description"><?php echo $row['description'] ?></td>
                                </tr>
                        <?php endwhile;
                        endif;
                        ?>
                    </tbody>

                </table>

                <div class="row">
                    <div class="col-4">
                        <label for="notes" class="control-label">Notes</label>
                        <p><?php echo isset($notes) ? $notes : '' ?></p>
                    </div>
                </div>

                <div class="row">
                    <?php
                        $users_qry = $conn->query("SELECT concat(firstname,' ',lastname) as username FROM `users` WHERE type = '{$driver_id}'");
                        $driver = $users_qry->fetch_assoc(); 
                    ?>
                    <div class="col-md-4 form-group" style="border: 1px solid #dee2e6;">
                        <label for="delivered_by" class="control-label">Delivered By:</label>
                        <p><?php echo isset($driver['username']) ? $driver['username'] : '' ?></p>
                    </div>

                    <?php
                        $users_qry = $conn->query("SELECT concat(firstname,' ',lastname) as username FROM `users` WHERE type = '{$received_by}'");
                        $receiver = $users_qry->fetch_assoc(); 
                    ?>
                    <div class="col-md-4 form-group" style="border: 1px solid #dee2e6;">
                        <label for="received_by" class="control-label">Received By:</label>
                        <p><?php echo isset($receiver['username']) ? $receiver['username'] : '' ?></p>
                    </div>
                    
                    <div class="col-md-4 form-group" style="border: 1px solid #dee2e6;">
                        <label for="date_received" class="control-label">Date Received:</label>
                        <p><?php echo isset($date_received) ? $date_received : '' ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.confirm_delivery').click(function() {
            _conf("Are you sure to confirm this delivery? This action cannot be undone.", "confirm_delivery", [$(this).attr('data-id')])
        })
    })

    function confirm_delivery($id) {
        start_loader();
        $.ajax({
            url: _base_url_ + "classes/Master.php?f=confirm_delivery",
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

    $(function() {
        $('#print').click(function(e) {
            e.preventDefault();
            start_loader();
            var _h = $('head').clone()
            var _p = $('#out_print').clone()
            var _el = $('<div>')
            _p.find('thead th').attr('style', '')
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
</script>