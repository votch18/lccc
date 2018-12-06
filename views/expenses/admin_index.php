<div class="card mb-3">
    <div class="card-header">
        <i class="fa fa-table"></i> EXPENSES
        <div class="pull-right"> 
               <a class="btn btn-info" href="/print/payments/">
                <i class="fa fa-fw fa-print"></i> Print</a>
        </div>

    </div>
    <div class="card-body">
        <div class="table-responsive">
            <?php if (count($this->data['data']) > 0 ) { ?>

                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

                    <thead>
                    <tr>
                        <th>Date</th>
                        <th>Particulars</th>
                        <th>Amount</th>
                        <th>Fund Source</th>
                        <th style="width: 140px;">Action</th>
                    </tr>

                    </thead>
                    <tbody>
                    <?php foreach ($this->data['data'] as $res) { ?>
                        <tr>
                            <td><?=$res['date'] ?></td>
                            <td><?=$res['particulars'] ?></td>
                            <td style="text-align: right;"><?=Util::n_format($res['amount']) ?></td>
                            <td><?=$res['fund_source'] ?></td>
                            <td>
								<a href="/print/payments/receipt/<?=$res['payment_id']?>/" title="Print" class="btn btn-info btn-xs"><i class="fa fa-print fa-lg"></i></a>
                                <a href="/admin/payments/edit/<?=$res['payment_id']?>/" title="View" class="btn btn-primary btn-xs"><i class="fa fa-edit fa-lg"></i></a>
                                <a href="/admin/payments/delete/<?=$res['payment_id']?>/" title="Delete" class="btn btn-danger btn-xs" onclick="return confirmDelete('Are you sure you want to deactivate this account?');"><i class="fa fa-trash-o fa-lg"></i></a>
                            </td>
                        </tr>

                    <?php } ?>

                    </tbody>
                </table>



            <?php } else { Session::setFlash("No record found!"); } ?>

        </div>
    </div>

</div>