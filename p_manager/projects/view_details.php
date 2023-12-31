<?php
if (isset($_GET['id']) && $_GET['id'] > 0) {
    $qry = $conn->query("SELECT p.*, c.name as clientname from `project_list` p inner join client_list c on c.id = p.client where p.id = '{$_GET['id']}'");
    if ($qry->num_rows > 0) {
        foreach ($qry->fetch_assoc() as $k => $v) {
            $$k = stripslashes($v);
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
        <h3 class="card-title"><?php echo "Cost Center Summary" ?> </h3>
        <div class="card-tools">
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
                    <H2>COST CENTER MATERIAL SUMMARY</H2>
                    <p class="m-0">Cost Center : <?php echo ($name) ?></p>
                    <p class="m-0">Client : <?php echo ($clientname) ?></p>
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
                        $summary = $conn->query("SELECT p.*, sum(di.quantity) as quantity, i.unit, i.name, i.description, i.selling_price from `project_list` p
                        inner join `rq_list`r on r.p_id = p.id
                        inner join `delivery_list` d on d.rq_no = r.id and d.status = 1
                        inner join `delivery_items` di on di.dn_id = d.id
                        inner join `item_list` i on di.item_id = i.id
                        where p.id = '{$_GET['id']}' group by i.name");
                        $sub_total = 0;
                        while ($row = $summary->fetch_assoc()) :
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

<div class="card card-outline card-info">
    <div class="card-header">
        <h3 class="card-title"><?php echo "Associated Deliveries" ?> </h3>
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
                        $qry = $conn->query("SELECT dl.*, u.username FROM `delivery_list` dl 
                                inner join `users` u on dl.driver_id = u.id 
                                inner join `rq_list` r on r.id = dl.rq_no 
                                inner join `project_list`p on p.id = r.p_id
                                where  p.id = '{$_GET['id']}'order by unix_timestamp(dl.date_updated)");
                        while ($row = $qry->fetch_assoc()) :
                            $row['item_count'] = $conn->query("SELECT * FROM delivery_items where dn_id = '{$row['id']}'")->num_rows;
                            $row['total_amount'] = $conn->query("SELECT sum(d.quantity * i.selling_price) as total FROM delivery_items d inner join item_list i on i.id = d.item_id where dn_id = '{$row['id']}'")->fetch_array()['total'];
                        ?>

                            <tr>
                                <td class="text-center"><?php echo $i++; ?></td>
                                <td class=""><?php echo date("M d,Y H:i", strtotime($row['date_created'])); ?></td>
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