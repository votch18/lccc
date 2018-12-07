
    <!-- Example DataTables Card-->
<div class="card mb-3">
    <div class="card-header">
        <i class="fa fa-table"></i> LIST OF PENDING LOANS
        <div class="pull-right">
            <a class="btn btn-success" href="/admin/loans/new/" style="color: #ffffff;" >
                <i class="fa fa-fw fa-bank"></i> New Loan</a>

               <a class="btn btn-info" href="/print/loans/">
                <i class="fa fa-fw fa-print"></i> Print</a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <?php if (count($this->data['data']) > 0 ) { ?>

                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

                    <thead>
                    <tr>
                        <th>ID#</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Interest Type</th>
                        <th>Terms</th>
                        <th>Principal</th>
                        <th>Monthly</th>
                        <th>Status</th>
                        <th style="width: 80px;">Action</th>
                    </tr>

                    </thead>
                    <tbody>
                    <?php foreach ($this->data['data'] as $res) { ?>
                        <tr>
                            <td><?=$res['member_id'] ?></td>
                            <td><?=$res['name'] ?></td>
                            <td><?=$res['type'] ?></td>
                            <td><?=$res['interest_type'] ?></td>
                            <td><?=$res['terms'] ?></td>
                            <td style="text-align: right;"><?=Util::n_format($res['principal']) ?></td>
                            <td style="text-align: right;"><?=Util::n_format($res['monthly']) ?></td> 
                            <td style="text-align: right;"><?=$res['status'] ?></td> 

                            <td>
                                <a href="/admin/loans/deductions/<?=$res['loan_id']?>/<?=$res['member_id']?>" title="View" class="btn btn-primary btn-xs"><i class="fa fa-arrow-right fa-lg"></i></a>
                                <a href="/admin/loans/delete/<?=$res['loan_id']?>" title="Delete" class="btn btn-danger btn-xs btn-delete"><i class="fa fa-trash-o fa-lg"></i></a>
                            </td>
                        </tr>

                    <?php } ?>

                    </tbody>
                </table>
            <?php } else { Session::setFlash("No record found!"); } ?>

        </div>
    </div>

</div>