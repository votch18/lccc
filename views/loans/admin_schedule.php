<?php
    $loan = new Loan();
    $payment = new Payment();

	$member = new Member();
	$member = $member->getMemberById($this->data['member_id']);
			
	?>

<div class="alert alert-success" role="alert">
    <h4 class="alert-heading">Borrower's Information</h4>
    <hr>
    <div class="row">
        <div class="col-md-2 text-md-center">
            <?php
            $img = file_exists('/uploads/members/'.$member['img']) ? '/uploads/members/'.$member['img'] :  '/uploads/members/avatar.png';
        ?>
            <img src="<?=$img ?>" style="width: 120px; height: 120px; border-radius: 50%; background-color: #e9ecef;" />
        </div>
        <div class="col-md-10">
            <div class="row">
                <div class="col-md-5">
                    <span>Name:
                        <?=$member['name']?></span>
                    <br />
                    <span>Gender:
                        <?=$member['gender']?>,
                        <?=floor($member['age'])?> years</span>

                </div>
                <div class="col-md-5">
                    <span>Mobile:
                        <?=$member['mobile']?></span>
                    <br />
                    <span>Address:
                        <?=$member['address']?></span>
                </div>
            </div>
            <hr />
            <a href="/admin/loans/view_loans/<?=$member['member_id']?>" class="btn btn-primary">View Loans</a>
        </div>
        <div class="col-md-2">

        </div>
    </div>
</div>

<!-- Example DataTables Card-->
<div class="card mb-3">
    <div class="card-header">
        <ul class="nav nav-tabs card-header-tabs" id="myTab">
            <li class="nav-item">
                <a class="nav-link active" href="#summary">Summary</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#payments">Payments</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#repayment"><i class="fa fa-paypal"></i> Repayment</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#schedule"><i class="fa fa-table"></i> Loan Schedule</a>
            </li>
            <li class="nav-item ml-auto">
                <a class="btn btn-info " href="/print/payments/" style="margin-top: -5px;">
                    <i class="fa fa-fw fa-print"></i> Print</a>
            </li>
        </ul>

        <div class="pull-right">

        </div>

    </div>
    <div class="card-body">
        <div class="tab-content" id="nav-tabContent">

            <!-- SUMMARY -->

            <div class="tab-pane fade show active" id="summary" role="tabpanel" aria-labelledby="summary-tab">

            <?php 
                $loan = new Loan();
                $res = $loan->getLoansByLoanId($this->data['loan_id']);
                //print_r($res) 
            ?>
              <div class="alert alert-success">Loan Details</div>
                  
                <table class="table">
                    <tr>
                        <td>Loan ID#</td>
                        <td><?=$res['loan_id'] ?></td>
                        <td></td>
                        <td></td>
                    </tr>   

                    <tr>
                        <td>Fund Type</td>
                        <td><?=$res['loan_type'] ?></td>
                        <td>Principal</td>
                        <td><?=Util::n_format($res['principal'], 2) ?></td>
                    </tr>                
                    <tr>
                        <td>Terms</td>
                        <td><?=$res['terms'].' Months'?></td>
                        <td>Deductions</td>
                        <td><?=Util::n_format($res['deductions'], 2) ?></td>
                    </tr>
                    <tr>
                        <td>Interest Type</td>
                        <td><?=$res['interest_type'] ?></td>
                        <td>Net Proceed</td>
                        <td><?=Util::n_format($res['net_proceed'], 2) ?></td>
                    </tr>
                    <tr>
                        <td>Interest</td>
                        <td><?=$res['interest'].' % '.$res['interest_term']?></td>
                        <td>Monthly</td>
                        <td><?=Util::n_format($res['monthly'], 2) ?></td>
                    </tr>
                    <tr>
                        <td>Release Date</td>
                        <td><?=Util::date_format($res['date_approved'])?></td>
                        <td>Total Amount Payable</td>
                        <td><?=Util::n_format($res['amount_payable'], 2) ?></td>
                    </tr>
                    <tr>
                        <td>Maturity Date</td>
                        <td><?=Util::date_format($res['maturity_date'])?></td>
                        <td>Balance</td>
                        <td><?=Util::n_format($res['balance'], 2) ?></td>
                    </tr>
                </table>
               



            </div>

            <!-- LOANS -->
            <div class="tab-pane fade show" id="payments" role="tabpanel" aria-labelledby="payments-tab">
            <?php
                  
                  $loans = $loan->getLoanBalance($this->data['loan_id']);

                  //$loans = (count($loans) <= 0 ) ? $loan->getLoansByLoanId($this->data['loan_id']) : $loans;
              
                  if (count($loans) > 0 ) { 
              
                      ?>
      
                      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
      
                          <thead>
                              <tr>
                                  <th>ID#</th>
                                  <th>Date</th>
                                  <th>Amount Paid</th>
                                  <th>Balance</th>
                              </tr>
      
                          </thead>
                          <tbody>
                              <?php foreach ($loans as $res) { ?>
                              <tr>
                                  <td>
                                      <?=$res['loan_id'] ?>
                                  </td>
                             
                                  <td style="text-align: right;">
                                      <?=Util::date_format($res['date']) ?>
                                  </td>
                                  <td style="text-align: right;">
                                      <?=Util::n_format($res['amount']); ?>
                                  </td>
                                  <td style="text-align: right;">
                                      <?=Util::n_format($res['balance']); ?>
                                  </td>
                               
                                
                              </tr>
      
                              <?php } ?>
      
                          </tbody>
                      </table>
 
                  <?php } else { ?>
                      
                      <div class="alert alert-danger">
                        No payment has been made!
                      </div>
                      <?php
                } ?>

            </div>


            <!-- REPAYMET -->
            <div class="tab-pane fade" id="repayment" role="tabpanel" aria-labelledby="repayment-tab">
                <form method="POST">
                
                    <?php
                        //check current balance, if balance is zero do not show the form
                        $balance = $payment->checkBalance($this->data['member_id'], $this->data['loan_id']);
                        if($balance > 1){ 
                   
                        $payments = $loan->getLoansById($this->data['loan_id']);

                    ?>

                    <input type="hidden" name="id" value="<?=isset($payments['payment_id']) ? $payments['payment_id']: '' ?>" id="payment_id" required="" />
                    <input type="hidden" name="loan_id" value="<?=isset($payments['loan_id']) ? $payments['loan_id']: '' ?>" id="loan_id" required="" />
                    <input type="hidden" name="member_id" value="<?=isset($payments['member_id']) ? $payments['member_id']: '' ?>" id="member_id" required="" />
                    <input type="hidden" name="period" value="<?=isset($payments['period']) ? $payments['period']: '' ?>" id="period" required="" />
                    <input type="hidden" name="penalty" value="" id="penalty" required="" />


                     <div class="alert alert-success">Payment Details</div>

                    <div class="row mb-3">
                        <div class="col-md-3 text-md-right ">
                            <label for="payment_date">Payment Date</label>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-8">
                                    <input type="date" class="form-control" name="dop" required="" value="<?=Util::date_format("now")?>" id="dop">
                                </div>
                                <div class="col-md-4">
                                    <button class="btn btn-primary d-block" id="genAmount">Compute Payment</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">

                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3 text-md-right">
                            <label for="loanId">Payment Type</label>
                        </div>
                        <div class="col-md-6">
                        <select id="payment_type" class="form-control" name="payment_type">
                            <option value="1" selected>Repayment</option>
                            <option value="2">Full Payment</option>
                        </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3 text-md-right">
                            <label for="loanId">Loan ID.</label>
                        </div>
                        <div class="col-md-6">
                            <input type="text" value="<?=isset($payments['loan_id']) ? $payments['loan_id'] : '' ?>" name="loan_id" class="form-control"
                                readonly>
                        </div>
                    </div>



                    <div class="row mb-3">
                        <div class="col-md-3 text-md-right ">
                            <label for="loanrelease">Loan Release Date</label>
                        </div>
                        <div class="col-md-6">
                            <input type="date" class="form-control" name="date_approved" required="" value="<?=Util::date_format($payments['date_approved'])?>"
                                id="loanrelease" readonly>
                        </div>
                        <div class="col-md-3">

                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 text-md-right">
                            <label for="or_no">OR No.*</label>
                        </div>
                        <div class="col-md-6">
                            <input type="decimal" class="form-control" name="or_no" required="" id="or_no" value="<?=Util::generateRandomCode2(8)?>">
                        </div>
                        <div class="col-md-3">
                            <small class="form-text text-muted">System generated.</small>
                            <span></span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3 text-md-right ">
                            <label for="amount_due">Amount Due*</label>
                        </div>
                        <div class="col-md-6">
                            <input type="decimal" class="form-control" name="amount_due" required="" id="amount_due"
                                value="<?=isset($payments['monthly']) ? $payments['monthly'] : '' ?>" readonly>
                        </div>
                        <div class="col-md-3">

                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3 text-md-right ">
                            <label for="amount">Payment Amount*</label>
                        </div>
                        <div class="col-md-6">
                            <input type="decimal" class="form-control" name="amount" required="" id="amount" value="">
                        </div>
                        <div class="col-md-3">

                        </div>
                    </div>

                    <hr />

                    <div class="row mb-3">
                        <div class="col-md-3 text-md-right ">

                        </div>
                        <div class="col-md-6 ">

                        </div>
                        <div class="col-md-3 text-right">
                            <input type="submit" class="btn btn-primary btn-lg" name="loan" value="PROCEED" style="width: 150px;" />
                        </div>
                    </div>

                    <?php
                        }else{
                            ?>
                                <div class="alert alert-success" role="alert">
                                    <h4 class="alert-heading">Well done!</h4>                                   
                                    <hr>
                                    <p>This loan is already close. </p>
                                </div>
                            <?php
                        }
                    ?>
                </form>


                
            </div>



            <!-- SCHEDULE -->
            <div class="tab-pane fade" id="schedule" role="tabpanel" aria-labelledby="nav-profile-tab">

                <?php 

                  
                    $loans = $loan->getLoansById($this->data['loan_id']);

                    $data = array(
                        'member_id' => $loans['member_id'],
                        'loan_id' => $loans['loan_id'],
                        'terms' => $loans['terms'],
                        'monthly' => $loans['monthly'],
                        'date_approved' => $loans['date_approved'],
                        'amount_payable' => $loans['amount_payable'],
                        'principal' => $loans['principal'],
                        'interest' => $loans['interest'],
                        'interest_type' => $loans['interest_type'],
                        'interest_term' => $loans['interest_term']				
                    );

                    $schedule = $loan->showScheduleofPayments($data);

                    if (count($schedule) > 0 ) { 
                
                ?>

                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

                    <thead>
                        <tr>
                            <th>Period</th>
                            <th>Date</th>
                            <th>Principal</th>
                            <th>Interest</th>
                            <th>Amount</th>
                            <th>Balance</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($schedule as $res) { ?>
                        <tr>
                            <td>
                                <?php echo $res['period']; ?>
                            </td>
                            <td>
                                <?=$res['date_due']; ?>
                            </td>
                            <td style="text-align: right;">
                                <?=Util::n_format($res['principal']) ?>
                            </td>
                            <td style="text-align: right;">
                                <?=Util::n_format($res['interest']) ?>
                            </td>
                            <td style="text-align: right;">
                                <?=Util::n_format($res['amortization']) ?>
                            </td>
                            <td style="text-align: right;">
                                <?=Util::n_format($res['balance']) ?>
                            </td>
                        </tr>

                        <?php } ?>

                    </tbody>
                </table>

                <?php } else { Session::setFlash("No record found!"); } ?>
            </div>

        </div>

    </div>

</div>

    <!-- Search Funds Modal-->
    <div class="modal fade pt-5" id="addPaymentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">PAYMENT</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>

                    <div class="modal-body p-3">
                        <input type="hidden" name="member_id" id="member_id" />
                        <input type="hidden" name="loan_id" id="loan_id" />
                        <input type="hidden" name="period" id="period" />
                        <input type="hidden" name="penalty" id="penalty" />
                        <div class="row row-sm-offset">

                            <div class="col">
                                <div class="form-group">
                                    <label for="or_no">OR No.*</label>
                                    <input type="decimal" class="form-control" name="or_no" required="" id="or_no"
                                        value="<?=Util::generateRandomCode2(8)?>" readonly>
                                </div>
                            </div>

                            <div class="col">
                                <div class="form-group">
                                    <label for="dop">Date of Payment*</label>
                                    <input type="date" class="form-control" name="dop" required="" id="dop" value="<?=date('Y-m-d', strtotime("
                                        now"))?>" >
                                </div>
                            </div>

                        </div>

                        <div class="row row-sm-offset">

                            <div class="col-xs-12 col-md-12">
                                <div class="form-group">
                                    <label for="amount_due">Amount Due*</label>
                                    <input type="decimal" class="form-control" name="amount_due" required="" id="amount_due"
                                        value="" readonly>
                                </div>
                            </div>

                            <div class="col-xs-12 col-md-12">
                                <div class="form-group">
                                    <label for="amount">Amount Paid*</label>
                                    <input type="decimal" class="form-control" name="amount" required="" id="amount">
                                    <small class="text-muted" id="balance"></small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">CANCEL</button>
                        <input type="submit" class="btn btn-primary" value="ADD PAYMENT" />
                    </div>
                </form>
            </div>
        </div>
    </div>

<script>
    //change active tabs
    $('#myTab a').on('click', function (e) {
        e.preventDefault()
        $(this).tab('show')
    })

    $('#payment_type').on('change', function(){
        $('#genAmount').trigger('click');
    });

    $('#amount').on('change keypress keyup', function(){
       
       var amount = $(this).val();
       var payable = $('#amount_due').val();
       var balance = payable -  amount;

       $('#balance').val(balance.toFixed(2));
    });

    $('#genAmount').on('click', function(e){
        e.preventDefault();
            var loan_id = $('#loan_id').val();
            var member_id = $('#member_id').val();
            var dop = $('#dop').val();

            var $data  = {
                'loan_id': loan_id,
                'member_id': member_id,
                'dop': dop,
            };
        // alert(dop);
        ajaxFn($data);

    });

    var timeOutId = 0;
    var ajaxFn = function ($data) {
        $.ajax({
            url: "/ajax/payments/calculate/" + $data.loan_id + "/" + $data.member_id + "/" + $data.dop,
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            type: "GET",
            success: function (response) {
                if (response) {
                    
                    var datas = response;
                    //$('#amount').val(datas.amount);
                    $('#amount_due').val(datas.amount);

                } else {
                    //do nothing baby
                }
            }
        });
    }
</script>