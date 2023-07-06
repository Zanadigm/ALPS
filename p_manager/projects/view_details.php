<?php
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT * from `project_list` where id = '{$_GET['id']}'");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=stripslashes($v);
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
        <h3 class="card-title"><?php echo "Cost Center Summary"?> </h3>
        <div class="card-tools">
            <button class="btn btn-sm btn-flat btn-success" id="print" type="button"><i class="fa fa-print"></i> Print</button>
            <a class="btn btn-sm btn-flat btn-default" href="?page=store_requisitions">Back</a>
        </div>
    </div>
    <div class="card-body" id="out_print">
        <div class="row">
            <div class="col-6 d-flex align-items-center">
                <div>
                    <p class="m-0"><?php echo $_settings->info('company_name') ?></p>
                    <p class="m-0"><?php echo $_settings->info('company_email') ?></p>
                    <p class="m-0"><?php echo $_settings->info('company_address') ?></p>
                </div>
            </div>
            
            <div class="col-6">
                <center><img src="<?php echo validate_image($_settings->info('logo')) ?>" alt="" height="200px"></center>
                <h2 class="text-center"><b>COST CENTER SUMMARY</b></h2>
            </div>
        </div>

        <div class="row mb 2">
        <div class="col-6 ">
                <div>
                    <p class="m-0"><?php echo $name?></p>
                    <p class="m-0"><?php echo $description?></p>
                    <p class="m-0"><?php echo $created_on?></p>
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
                            <th class="bg-navy disabled text-light px-1 py-1 text-center">Sub Total</th>
                        </tr>
                        
                    </thead>
                    <tbody>
                        <?php
                        $summary = $conn->query("SELECT p.*, sum(di.quantity) as quantity, di.unit, i.name, i.description, di.unit_price from `project_list` p
                        inner join `rq_list`r on r.p_id = p.id
                        inner join `delivery_list` d on d.rq_no = r.id and d.status = 1
                        inner join `delivery_items` di on di.dn_id = d.id
                        inner join `item_list` i on di.item_id = i.id
                        where p.id = '{$_GET['id']}' group by i.name");
                        $sub_total = 0;
                        while ($row = $summary->fetch_assoc()) :
                            $sub_total += ($row['quantity'] * $row['unit_price']);
                        ?>
                        
                        <tr class="po-item" data-id="">
                            <td class="align-middle p-0 text-center"><?php echo $row['quantity'] ?></td>
                            <td class="align-middle p-1"><?php echo $row['unit'] ?></td>
                            <td class="align-middle p-1"><?php echo $row['name'] ?></td>
                            <td class="align-middle p-1 item-description"><?php echo $row['description'] ?></td>
                            <td class="align-middle p-1"><?php echo number_format($row['unit_price']) ?></td>
                            <td class="align-middle p-1 text-right total-price"><?php echo number_format($row['quantity'] * $row['unit_price']) ?></td>
                        </tr>
                        <?php endwhile; ?>
                    <tfoot>
                        <tr class="bg-lightblue">
                        <tr>
                            <th class="p-1 text-right" colspan="5">Total</th>
                            <th class="p-1 text-right" id="total"><?php echo number_format($sub_total) ?></th>
                        </tr>
                        </tr>
                    </tfoot>
                </table>

            </div>
        </div>
    </div>
</div>

<script>
    $(function() {
        $('#print').click(function(e) {
            e.preventDefault();
            start_loader();
            var _h = $('head').clone()
            var _p = $('#out_print').clone()
            var _el = $('<div>')
            _p.find('thead th').attr('style', 'color:black !important')
            _p.find('tr:nth-of-type(odd)').attr('style', 'background-color:#0000000d !important')
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