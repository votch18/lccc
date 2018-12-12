	<!-- Stepper -->
        <div class="steps-form">
            <div class="steps-row setup-panel">
                <div class="steps-step">
                    <a href="#step-1" class="btn btn-success btn-circle active">1</a>
                    <p>Loan Terms</p>
                </div>
                <div class="steps-step">
                    <a href="#step-2" class="btn btn-success btn-circle  active" disabled="disabled">2</a>
                    <p>Deductions</p>
                </div>
                <div class="steps-step">
                    <a href="#step-3" class="btn btn-default btn-circle active" disabled="disabled">3</a>
                    <p>Loan Summary</p>
                </div>
            </div>
        </div>
	
	
	<?php
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
            <img src="<?=$img ?>" style="width: 120px; height: 120px; border-radius: 50%; background-color: #e9ecef;"/>
        </div>
        <div class="col-md-10">
            <div class="row">
                <div class="col-md-5">
                    <span>Name: <?=$member['name']?></span>
                    <br/>
                    <span>Gender: <?=$member['gender']?>, <?=floor($member['age'])?> years</span>

                </div>
                <div class="col-md-5">
                    <span>Mobile: <?=$member['mobile']?></span>
                    <br/>
                    <span>Address: <?=$member['address']?></span>
                 </div>
            </div>
            <hr/>
            <a href="/admin/loans/view_loans/<?=$member['member_id']?>" class="btn btn-primary">View Loans</a>
        </div>
        <div class="col-md-2">

        </div>
    </div>
</div>

<!-- Example DataTables Card-->
<div class="card mb-3">
    <div class="card-header">
        <i class="fa fa-table"></i> SUMMARY
        <div class="pull-right">
           <a class="btn btn-info" href="/print/payments/?loanid=<?= $this->data['loan_id'] ?>&member=<?=$this->data['member_id']?>">
                <i class="fa fa-fw fa-print"></i> Print</a>
        </div>

    </div>
    <div class="card-body">
        <div class="table-responsive">
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
               

                <div class="alert alert-success mt-3">Loan Schedule</div>

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

                if (count($schedule ) > 0 ) { ?>

                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

                    <thead>
                    <tr>
                        <th>ID#</th>
                        <th>Period</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Balance</th>
                    </tr>
                    
                    </thead>
                    <tbody>
                    <?php foreach ($schedule  as $res) { ?>
                        <tr>
                            <td><?=$res['loan_id'] ?></td>
                            <td><?=$res['period'] ?></td>
                            <td><?=Util::d_format($res['date_due']); ?></td>
                            <td style="text-align: right;"><?=Util::n_format($res['amortization']) ?></td>
                            <td style="text-align: right;"><?=Util::n_format($res['balance']); ?></td> 
                           
                        </tr>

                    <?php } ?>

                    </tbody>
                </table>

                <?php } else { Session::setFlash("No record found!"); } ?>


        </div>
    </div>
</div>