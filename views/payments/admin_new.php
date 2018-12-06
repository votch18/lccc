
	<?php
	$member = new Member();
	$member = $member->getMemberById($this->data['member_id']);
            
    print_r($this->data);
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

<div class="card">
  <div class="card-header">
    <ul class="nav nav-tabs card-header-tabs">
      <li class="nav-item">
        <a class="nav-link active" href="#loan" id="loanapplication"><h5>Repayment</h5></a>
      </li>
    </ul>
  </div>
	<div class="card-body">
	<form method="POST">
       
		<div id="loan">

            <div class="alert alert-success">Payment Date</div>
            <div class="row mb-3">
					<div class="col-md-3 text-md-right ">
						<label for="payment_date">Payment Date</label>
					</div>
					<div class="col-md-6">
                        <div class="row">
                            <div class="col-md-8">
                                <input type="date" class="form-control" name="dop" required="" value="<?=Util::date_format("now")?>" id="payment_date">
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-primary d-block" id="genAmount">Compute Payment</button>
                            </div>
                        </div>
                    </div>
					<div class="col-md-3">
						
					</div>
				</div>
				

			<div class="alert alert-success">Payment Details</div>
                <input type="hidden" name="id" value="<?=$this->data['payment_id']?>" id="payment_id" required=""/>
				<input type="hidden" name="member_id" value="<?=$this->data['member_id']?>" required=""/>
                <input type="hidden" name="period" value="<?=$this->data['period']?>" id="period" required=""/>
				
				<div class="row mb-3">
					<div class="col-md-3 text-md-right">
						<label for="loanId">Loan ID.</label>
					</div>
					<div class="col-md-6">
						<input type="text" value="<?=$this->data['loan_id'] ?>" name="loan_id" class="form-control" readonly>
					</div>
				</div>

                <div class="row mb-3">
					<div class="col-md-3 text-md-right ">
						<label for="loanrelease">Loan Release Date</label>
					</div>
					<div class="col-md-6">
						<input type="date" class="form-control" name="date_approved" required="" value="<?=Util::date_format($this->data['date_approved'])?>" id="loanrelease" readonly>
					</div>
					<div class="col-md-3">
						
					</div>
				</div>

                  <div class="row mb-3">
					<div class="col-md-3 text-md-right ">
						<label for="duedate">Due Date</label>
					</div>
					<div class="col-md-6">
						<input type="date" class="form-control" name="date_due" required="" value="<?=Util::date_format($this->data['date_due'])?>" id="duedate" readonly>
					</div>
					<div class="col-md-3">
						
					</div>
				</div>
				
				
                <div class="row mb-3">
					<div class="col-md-3 text-md-right">
                    <label for="or_no">OR No.*</label>
					</div>
                    <div class="col-md-6">                           
                        <input type="decimal" class="form-control" name="or_no" required="" id="or_no" value="<?=Util::generateRandomCode2(8)?>" readonly>
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
                        <input type="decimal" class="form-control" name="amount_due" required="" id="amount_due" value="<?=$this->data['amount']?>" readonly> 
                    </div>
					<div class="col-md-3">
						
					</div>
				</div>

				<div class="row mb-3">
					<div class="col-md-3 text-md-right ">
                    <label for="amount">Payment Amount*</label>
					</div>
                    <div class="col-md-6">
                        <input type="decimal" class="form-control" name="amount" required="" id="amount" value="<?=$this->data['amount']?>"> 
                    </div>
					<div class="col-md-3">
						
					</div>
				</div>

                <div class="row mb-3">
					<div class="col-md-3 text-md-right ">
                    <label for="balance">Balance</label>
					</div>
                    <div class="col-md-6">
                        <input type="decimal" class="form-control" name="balance" required="" id="balance" value="0.00"> 
                    </div>
					<div class="col-md-3">
						
					</div>
				</div>

				<hr/>
						
				<div class="row mb-3">
					<div class="col-md-3 text-md-right ">
						
					</div>
					<div class="col-md-6 ">
						
					</div>
					<div class="col-md-3 text-right">
						<input type="submit" class="btn btn-primary btn-lg" name="loan" value="PROCEED" style="width: 150px;"/>
					</div>
				</div>
			
		</div>
	</form>
	
		<div id="calculator" style="display: none">
		
		</div>
	</div>
</div>

<script>
    $('#amount').on('change keypress keyup', function(){
       
        var amount = $(this).val();
        var payable = $('#amount_due').val();
        var balance = payable -  amount;

        $('#balance').val(balance.toFixed(2));
    });

    $('#genAmount').on('click', function(e){
        e.preventDefault();
         var payment_id = $('#payment_id').val();
         var dop = $('#payment_date').val();

       // alert(dop);
        ajaxFn(payment_id, dop);


    });

var timeOutId = 0;
var ajaxFn = function (id, dop) {
    $.ajax({
        url: "/ajax/payments/calculate/" + id + "/" + dop,
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        type: "GET",
        success: function (response) {
            if (response) {
                
                var datas = response;
                $('#amount').val(datas.amount);
                $('#amount_due').val(datas.amount);

            } else {
                //do nothing baby
            }
        }
    });
}


</script>