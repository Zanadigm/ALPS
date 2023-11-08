<?php if ($_settings->chk_flashdata('success')) : ?>
    <script>
        alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success')
    </script>
<?php endif; ?>
<?php
if (isset($_GET['id']) && $_GET['id'] > 0) {
    $qry = $conn->query("SELECT * from `po_list` where id = '{$_GET['id']}' ");
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

    [name="tax_percentage"],
    [name="discount_percentage"] {
        width: 5vw;
    }
</style>
<div class="card card-outline card-info">
    <div class="card-header">
        <h3 class="card-title"><?php echo isset($id) ? "Update Purchase Order Details" : "New Purchase Order" ?> </h3>
        <div class="card-tools">
            <button class="btn btn-sm btn-flat btn-success" id="print" type="button"><i class="fa fa-print"></i> Print</button>

            <?php if ($status != 1) : ?>
                <a class="btn btn-sm btn-flat btn-primary" href="?page=purchase_orders/manage_po&id=<?php echo $id ?>">Edit</a>
            <?php endif; ?>

            <a class="btn btn-sm btn-flat btn-default" href="?page=purchase_orders">Back</a>
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
                    <H2>PURCHASE ORDER</H2>
                    <p class="m-0">Order No : <?php echo ($po_no) ?></p>
                    <p class="m-0">Date : <?php echo date("Y-m-d", strtotime($date_created)) ?></p>
                    <?php if ($status == 0){?>
                    <p class="m-0">Status : Pending</p>
                    <?php }else{?>
                        <p class="m-0">Status : Approved</p>
                        <p class="m-0">Approved By : Remmy Amya</p>
                    <?php } ?>
                </div>
            </div>

        </div>
        <div class="row mb-2" style="margin-bottom: 1.5rem !important">
            <div class="div col-8" style="align-self: flex-end">
                <p style="margin-bottom: 0;">Please supply the following items in good order and condition as per your quote.</p>
            </div>
            <div class="col-4">
                <p class="m-0"><b>Vendor</b></p>
                <?php
                $sup_qry = $conn->query("SELECT * FROM supplier_list where id = '{$supplier_id}'");
                $supplier = $sup_qry->fetch_array();
                ?>
                <div>
                    <p class="m-0"><?php echo $supplier['name'] ?></p>
                    <p class="m-0"><?php echo $supplier['contact'] ?></p>
                    <p class="m-0"><?php echo $supplier['email'] ?></p>
                </div>
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
                            <th class="bg-navy disabled text-light px-1 py-1 text-center">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (isset($id)) :
                            $order_items_qry = $conn->query("SELECT o.*,i.name, i.unit, i.description, i.buying_price FROM `order_items` o inner join item_list i on o.item_id = i.id where o.`po_id` = '$id' ");
                            $sub_total = 0;
                            while ($row = $order_items_qry->fetch_assoc()) :
                                $sub_total += ($row['quantity'] * $row['buying_price']);
                        ?>
                                <tr class="po-item" data-id="">
                                    <td class="align-middle p-0 text-center"><?php echo $row['quantity'] ?></td>
                                    <td class="align-middle p-1"><?php echo $row['unit'] ?></td>
                                    <td class="align-middle p-1"><?php echo $row['name'] ?></td>
                                    <td class="align-middle p-1 item-description"><?php echo $row['description'] ?></td>
                                    <td class="align-middle p-1"><?php echo number_format($row['buying_price']) ?></td>
                                    <td class="align-middle p-1 text-right total-price"><?php echo number_format($row['quantity'] * $row['buying_price']) ?></td>
                                </tr>
                        <?php endwhile;
                        endif; ?>
                    </tbody>
                    <tfoot>
                        <tr class="bg-lightblue">
                        <tr>
                            <th class="p-1 text-right" colspan="5">Sub Total</th>
                            <th class="p-1 text-right" id="sub_total"><?php echo number_format($sub_total) ?></th>
                        </tr>
                        <tr>
                            <th class="p-1 text-right" colspan="5">Discount (<?php echo isset($discount_percentage) ? $discount_percentage : 0 ?>%)
                            </th>
                            <th class="p-1 text-right"><?php echo isset($discount_amount) ? number_format($discount_amount) : 0 ?></th>
                        </tr>
                        <tr>
                            <th class="p-1 text-right" colspan="5">Tax Exclusive (<?php echo isset($tax_percentage) ? $tax_percentage : 0 ?>%)</th>
                            <th class="p-1 text-right"><?php echo isset($tax_amount) ? number_format($tax_amount) : 0 ?></th>
                        </tr>
                        <tr>
                            <th class="p-1 text-right" colspan="5">Total</th>
                            <th class="p-1 text-right" id="total"><?php echo isset($tax_amount) ? number_format($sub_total + $tax_amount - $discount_amount) : 0 ?></th>
                        </tr>
                        </tr>
                    </tfoot>
                </table>
                <div class="row">
                    <div class="col-12">
                        <label for="notes" class="control-label">Notes</label>
                        <p><?php echo isset($notes) ? $notes : '' ?></p>
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
            <input type="number" step="any" class="text-right w-100 border-0" name="buying_price[]" value="0" />
        </td>
        <td class="align-middle p-1 text-right total-price">0</td>
    </tr>
</table>
<script>
    $(function() {
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
</script>