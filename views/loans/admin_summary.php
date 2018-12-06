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

                <?php if (count($this->data['data']) > 0 ) { ?>

                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

                    <thead>
                    <tr>
                        <th>ID#</th>
                        <th>Period</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Amount Paid</th>
                        <th>Balance</th>
                    </tr>
                    
                    </thead>
                    <tbody>
                    <?php foreach ($this->data['data'] as $res) { ?>
                        <tr>
                            <td><?=$res['loan_id'] ?></td>
                            <td><?=$res['period'] ?></td>
                            <td><?=Util::d_format($res['date_due']); ?></td>
                            <td style="text-align: right;"><?=Util::n_format($res['amortization']) ?></td>
                            <td style="text-align: right;"><?=Util::n_format($res['payment']); ?></td>
                            <td style="text-align: right;"><?=Util::n_format($res['balance']); ?></td> 
                           
                        </tr>

                    <?php } ?>

                    </tbody>
                </table>

                <?php } else { Session::setFlash("No record found!"); } ?>


        </div>
    </div>
</div>



<!-- Search Funds Modal-->
<div class="modal fade pt-5" id="addPaymentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                <input type="decimal" class="form-control" name="or_no" required="" id="or_no" value="<?=Util::generateRandomCode2(8)?>" readonly>
                            </div>
                        </div>
						
                        <div class="col">
                            <div class="form-group">
                                <label for="dop">Date of Payment*</label>
                                <input type="date" class="form-control" name="dop" required="" id="dop" value="<?=date('Y-m-d', strtotime("now"))?>" >
                            </div>
                        </div>

                    </div>
					
					 <div class="row row-sm-offset">
				
						
                        <div class="col-xs-12 col-md-12">
                            <div class="form-group">
                                <label for="amount_due">Amount Due*</label>
                                <input type="decimal" class="form-control" name="amount_due" required="" id="amount_due" value="" readonly>
                            </div>
                        </div>
						
						
						<div class="col-xs-12 col-md-12">
                            <div class="form-group">
                                <label for="amount">Amount Paid*</label>
                                <input type="decimal" class="form-control" name="amount" required="" id="amount" >
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
	
	var bal_field = $('#balance');
	
	$('.pay').on('click', function(e){
		var $loan_id = $(this).attr('id').split("-")[0];
		var $member_id = $(this).attr('id').split("-")[1];
		var $period = $(this).attr('id').split("-")[2];
		var $amount = $(this).attr('id').split("-")[3];
		
		$('#loan_id').val($loan_id);
		$('#member_id').val($member_id);
		$('#period').val($period);
		$('#amount_due').val($amount);
		
	});
	
	$('#amount').on('change keypress keyup', function (e){
		var $balance = $('#amount_due').val() - $(this).val();
		var keyword = ($balance < 0 ? 'Change: ' : 'Balance: ');
		$val = ($balance < 0 ? ($balance * -1) : $balance);
		
		bal_field.html(keyword + $val);
		
	});
	
	</script>