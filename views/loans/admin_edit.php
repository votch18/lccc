	<!-- Stepper -->
    <div class="steps-form">
            <div class="steps-row setup-panel">
                <div class="steps-step">
                    <a href="#step-1" class="btn btn-success btn-circle active">1</a>
                    <p>Loan Terms</p>
                </div>
                <div class="steps-step">
                    <a href="#step-2" class="btn btn-default btn-circle" disabled="disabled">2</a>
                    <p>Deductions</p>
                </div>
                <div class="steps-step">
                    <a href="#step-3" class="btn btn-default btn-circle" disabled="disabled">3</a>
                    <p>Loan Summary</p>
                </div>
            </div>
        </div>
	

<div class="card">
  <div class="card-header">
    <ul class="nav nav-tabs card-header-tabs">
      <li class="nav-item">
        <a class="nav-link active" href="#loan" id="loanapplication"><h5>Loan Application</h5></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#calculator" id="loancalculator"><h5>Loan Calculator</h5></a>
      </li>
    </ul>
  </div>
	<div class="card-body">
	<form method="POST">
		<div id="loan">
			<div class="alert alert-success">Borrower's Information</div>
			
				<div class="row">
					<div class="col-md-3 text-md-right">
						<label for="borrowerName">Name of Borrower</label>
					</div>
					<div class="col-md-6">
						
						 <div class="input-group mb-2 mb-sm-0">
							<input type="text" class="form-control" id="borrowerName" placeholder="Enter Borrower's name" value="<?=$this->data['name']?>" required>
							<div class="input-group-addon"><a href="#" data-toggle="modal" data-target="#searchModal"><i class="fa fa-search"></i></a></div>
						  </div>
					</div>
					<div class="col-md-3">
						
					</div>
				</div>
				<br/>
		
			<br/>
			
			
			<div class="alert alert-success">Loan Details</div>
			<span>Loan Terms</span>
			<hr/>
				<input type="hidden" name="member_id" value="<?=$this->data['member_id']?>" required=""/>
				
				<div class="row mb-3">
					<div class="col-md-3 text-md-right">
						<label for="loanType">Type of Loan</label>
					</div>
					<div class="col-md-6">
						<select name="loan_type" class="form-control" required="" id="loan_type">
							<?php
							$fund = new Fund();
							$category = $fund->getFundType();
							foreach ($category as $res) { ?>
								<option value="<?= $res['lid']?>"><?= $res['description']?></option>
							<?php } ?>
						</select>
					</div>
					<div class="col-md-3">
						
					</div>
				</div>
				
				<div class="row mb-3">
					<div class="col-md-3 text-md-right">
						<label for="loanId">Loan ID.</label>
					</div>
					<div class="col-md-6">
						<input type="text" value="<?=Util::generateRandomCode2().strtotime("now") ?>" name="loan_id" class="form-control" readonly>
					</div>
					<div class="col-md-3">
						<small class="form-text text-muted">System generated.</small>
						<span></span>
					</div>
				</div>
				
				
				<div class="row mb-3">
					<div class="col-md-3 text-md-right ">
						<label for="principal">Principal Amount</label>
					</div>
					<div class="col-md-6">
						<input type="number" class="form-control" name="amount" required="" value="" min="500" id="amount">
					</div>
					<div class="col-md-3">
						
					</div>
				</div>
				
				<div class="row mb-3">
					<div class="col-md-3 text-md-right ">
						<label for="loanrelease">Loan Release Date</label>
					</div>
					<div class="col-md-6">
						<input type="date" class="form-control" name="date_approved" required="" value="<?=Util::date_format("now")?>" id="loanrelease">
					</div>
					<div class="col-md-3">
						
					</div>
				</div>
				
				
				<span>Interest</span>
				<hr/>
				<div class="row mb-3">
					<div class="col-md-3 text-md-right ">
						<label for="interesttype">Type of Interest</label>
					</div>
					<div class="col-md-6">
						<select name="interest_type" class="form-control" required="" id="interest_type">
							<?php
							$term = new Interest();
							$category = $term->getInterestType();
							foreach ($category as $res) { ?>
								<option value="<?= $res['lid']?>"><?= $res['description']?></option>
							<?php } ?>
						</select>
					</div>
					<div class="col-md-3">
						
					</div>
				</div>
				
				
				<div class="row mb-3">
					<div class="col-md-3 text-md-right ">
						<label for="interesttype">Interest Rate</label>
					</div>
					<div class="col-md-3">
						<input type="number" class="form-control" name="interest" id="interest" value="<?=Setting::get("interest")?>" required/>
					</div>
					<div class="col-md-3">
						<select name="interest_term" class="form-control" required="" id="interest_term" >
							<?php
							$term = new Interest();
							$category = $term->getInterestTerm();
							foreach ($category as $res) { ?>
								<option value="<?= $res['lid']?>" <?=Setting::get("interest_term") == $res['lid'] ? 'selected' : ''?>><?= $res['description']?></option>
							<?php } ?>
						</select>
					</div>
					<div class="col-md-3">
						
					</div>
				</div>
				
				<span>Duration</span>
				<hr/>
				<div class="row mb-3">
					<div class="col-md-3 text-md-right ">
						<label for="terms">Payment Terms</label>
					</div>
					<div class="col-md-6">
						<select name="terms" class="form-control" required="" id="terms">
							<?php
							$term = new Term();
							$category = $term->getTerms();
							foreach ($category as $res) { ?>
								<option value="<?= $res['lid']?>" <?=$res['lid'] == 6 ? 'selected' : ''?>><?= $res['description']?></option>
							<?php } ?>
						</select>
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



<!-- Search Funds Modal-->
<div class="modal fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="GET">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Search Borrower</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <input type="hidden" name="member_id" id="member_id" />
                    <div class="row row-sm-offset">

                        <div class="col-xs-12 col-md-12">
                            <div class="form-group">
                                <label for="member_id"><strong>Search</strong> [Lastname, Firstname Middlename]</label>
                                <input type="text" class="form-control" name="member" placeholder="Member Name" required="" id="name" >
                            </div>
                        </div>

                        <div class="col-xs-12 col-md-12">
                            <div id="search_result" style="height: 300px;"></div>
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



<script type="text/javascript">
$(document).ready(function(){

$( "#name" ).keyup(function() {
    
    //alert('shit');
    ajaxFn($( "#name" ).val());


});

var timeOutId = 0;
var ajaxFn = function (str) {
    $.ajax({
        url: "/ajax/loans/?q=" + str,
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        type: "GET",
        success: function (response) {
            if (response) {
                
                console.log(response);
                console.log(response["member_id"]);
                var datas = response;

                var content = "<table class ='table'>";
                var x = 0;
                $.each(datas, function() {
                    content += '<tr><td>' + datas[x].name + '</td><td class="text-right"><a href="/admin/loans/new/?id=' + datas[x].member_id + '" class="btn btn-success">SELECT</a></td></tr>';
                    x++;
                });
                content += "</table>";

                $("#search_result").html('' + content + '');
            } else {
                //do nothing baby
            }
        }
    });
}


});

</script>



<?php
    //json_encode to pass from php to javascript 
    $rate = json_encode(0.06);
    $deduction = null;
?>
<script>
    /*
    calculateLoan();

    $('#terms').on('change', function (e) {
        calculateLoan();
    });

    $('#amount').on('keyup', function (e) {
        calculateLoan();
    });

    //click calculate button
    /*
    $('#calc').on('click', function (e) {
        calculateLoan();
    });
    */

    //TODO: fix diminishing interest
	/*
    function calculateLoan(){
        //actual passing of value from php to javascript 
        var rate = 0.06;
        //var deductions = 
        var amount = $('#amount').val();
        var terms = $('#terms').val();

        //calculate deductions
        var new_rate = rate / terms;
        var monthly = -1 * round(PMT(new_rate, terms, amount,0,0), 2);
        var advance_interest = getInterestAmount(monthly, amount, new_rate, terms);
        var life_insurance = 350;
        var service_charge = amount * 0.02;
        var loan_insurance = ((amount / 1000) * 1.35) * terms;
        var booklet = 20;
        var filing_fee = 50;
        var mortuary_aid = 50;
        var cbu =  amount * 0.02;

        $('#monthly').val(monthly);

        var deductions = advance_interest + life_insurance + service_charge + loan_insurance + booklet + filing_fee + mortuary_aid + cbu;
        $('#deductions').val(deductions);

        //net proceed 
        var net_proceed = amount - deductions;
        $('#net_proceed').val(net_proceed);

 
		$('#advance_interest').val(advance_interest );
		$('#life_insurance').val(life_insurance  );
        $('#service_charge').val( service_charge  );
        $('#loan_insurance').val(loan_insurance  );
        $('#booklet').val(booklet  );
		$('#filing_fee').val( filing_fee  );
		$('#mortuary_aid').val(mortuary_aid  );
        $('#cbu').val( cbu  );

        
    }

    
//get monthly payment
function PMT(rate, nperiod, pv, fv, type) {
    if (!fv) fv = 0;
    if (!type) type = 0;
    if (rate == 0) return -(pv + fv)/nperiod;
    var pvif = Math.pow(1 + rate, nperiod);
    var pmt = rate / (pvif - 1) * -(pv * pvif + fv);
    if (type == 1) {
    pmt /= (1 + rate);
    }
return pmt;
}

//get total interest accommulated
function getInterestAmount(monthly, principal, monthlyrate, terms){

    var accommulatedInterest = 0;
    var runningBalance = principal;

    for(var x = 1; x <= terms; x++){
        var interestPerMonth = runningBalance * monthlyrate;
        accommulatedInterest += round(interestPerMonth, 2);
        runningBalance = runningBalance - round(monthly - interestPerMonth, 2);

        console.log("Principal: " + runningBalance + " Interest: " + interestPerMonth + " Monthly: " + monthly + " Total Interest: " + accommulatedInterest);
    }

    return round(accommulatedInterest, 2);
}

function round(value, decimals) {
  return Number(Math.round(value+'e'+decimals)+'e-'+decimals);
}


*/

</script>