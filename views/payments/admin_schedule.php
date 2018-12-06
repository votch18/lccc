
    <!-- Example DataTables Card-->
<div class="card mb-3">
    <div class="card-header">
        <i class="fa fa-table"></i> PAYMENT SCHEDULE
        <div class="pull-right">
            <a class="btn btn-success" href="/admin/loans/new/" style="color: #ffffff;" >
                <i class="fa fa-fw fa-area-chart"></i> New Loan Application</a>

             
        </div>

    </div>
    <div class="card-body">
        <div class="table-responsive">
            <?php if (count($this->data['data']) > 0 ) { ?>

                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

                    <thead>
                    <tr>
                        <th>ID#</th>
                        <th>Period</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Penalty</th>
                        <th>Status</th>
                        <th style="width: 80px;">Action</th>
                    </tr>

                    </thead>
                    <tbody>
                    <?php foreach ($this->data['data'] as $res) { ?>
                        <tr>
                            <td><?=$res['loan_id'] ?></td>
                            <td><?=$res['period'] ?></td>
                            <td><?=$res['date_due'] ?></td>
                            <td style="text-align: right;"><?=Util::n_format($res['amortization']) ?></td>
                            <td style="text-align: right;"></td>
                            <td style="text-align: right;"></td> 
                            <td>
                            <a class="btn btn-success" data-toggle="modal" data-target="#addPaymentModal" style="color: #ffffff;">
                <i class="fa fa-fw fa-bank"></i> Add Payment</a>
                                <a href="/admin/loans/view/<?=$res['loan_id']?>" title="View" class="btn btn-primary btn-xs"><i class="fa fa-eye fa-lg"></i></a>
                                <a href="/admin/loans/delete/<?=$res['loan_id']?>" title="Delete" class="btn btn-danger btn-xs" onclick="return confirmDelete('Are you sure you want to deactivate this account?');"><i class="fa fa-trash-o fa-lg"></i></a>
                            </td>
                        </tr>

                    <?php } ?>

                    </tbody>
                </table>



            <?php } else { Session::setFlash("No record found!"); } ?>

        </div>
    </div>

</div>



<!-- Search Funds Modal-->
<div class="modal fade" id="addPaymentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">SELECT CUSTOMER</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <div class="modal-body">

                    <input type="hidden" name="member_id" id="member_id" />
                    <div class="row row-sm-offset">

                        <div class="col-xs-12 col-md-12">
                            <div class="form-group">
                                <label for="member_id">Member Name*</label>
                                <input type="text" class="form-control" name="member" placeholder="Member Name" required="" id="name" >
                            </div>
                        </div>

                    
                    </div>

                
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">CANCEL</button>
                </div>
            </form>
        </div>
    </div>
</div>