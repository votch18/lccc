<!--Loan Information -->
<div class="row row-sm-offset">
<div class="col-xs-12 col-md-6">
<h3 class="alert alert-primary">Loan Information</h3>

<form method="POST" enctype="multipart/form-data">
    <input type="hidden" name="member_id" value="<?=$this->data['member_id']?>"/>
    <input type="text" name="deductions" id="deductions"/>
    <input type="text" name="monthly" id="monthly"/>
    <input type="text" name="net_proceed" id="net_proceed"/>

     <div class="row row-sm-offset">
        <div class="col-xs-12 col-md-12">
            <div class="form-group">
                <label class="form-control-label" for="form1-9-fname">Name<span class="form-asterisk">*</span></label>
                <input type="text" class="form-control" name="description" required="" value="<?=$this->data['name'] ?>">
            </div>
       </div>
     </div>

     <div class="row row-sm-offset">
        <div class="col-xs-12 col-md-12">
            <div class="form-group">
                <label for="gender">Funds Type*</label>
                <select name="fund_id" class="form-control" required="">
                    <?php
                    $fund = new Fund();
                    $category = $fund->getFundType();
                    foreach ($category as $res) { ?>
                        <option value="<?= $res['lid']?>"><?= $res['description']?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
    </div>

    <div class="row row-sm-offset">
        <div class="col-xs-12 col-md-12">
            <div class="form-group">
                <label class="form-control-label" for="form1-9-gender">Terms<span class="form-asterisk">*</span></label>
                <select name="terms" class="form-control" required="" id="terms">
                    <?php
                    $term = new Term();
                    $category = $term->getTerms();
                    foreach ($category as $res) { ?>
                        <option value="<?= $res['lid']?>"><?= $res['description']?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
    </div>

     <div class="row row-sm-offset">
        <div class="col-xs-12 col-md-12">
            <div class="form-group">
                <label class="form-control-label" for="form1-9-fname">Amount<span class="form-asterisk">*</span></label>
                <input type="number" class="form-control" name="amount" required="" value="1000" id="amount">
            </div>
       </div>
     </div>

    <div class="row row-sm-offset">
        <div class="col-xs-12 col-md-12">
            <div class="form-group">
                <label class="form-control-label" for="form1-9-fname">Date Approved<span class="form-asterisk">*</span></label>
                <input type="date" class="form-control" name="date_approved" required="" value="<?=Util::date_format("now")?>">
            </div>
       </div>
     </div>


     <hr/>
    
    <button class="btn btn-primary" id="button">SAVE</button>
       
   
    <br/>
      
    <br/>
</form>
<!--<button class="btn btn-default" id="calc">CALCULATE</button>-->
</div>

<!--Loan Schedule -->
<div class="col-xs-12 col-md-6">
<h3 class="alert alert-warning">Loan Details</h3>
<div id="loan_details">
</div>

</div>
</div>

<?php
    //json_encode to pass from php to javascript 
    $rate = json_encode(0.06);
    $deduction = null;
?>
<script>
    
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

    function calculateLoan(){
        //actual passing of value from php to javascript 
        var rate = <?=$rate?>;
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

        //set content
        var content = "";

        $('#loan_details').html('');
        content = "<table class='table'>";
        content += "<tr><td>Loan Amount</td><td></td><td style='text-align: right;'>" + amount + "</td></tr>";
        content += "<tr><td>Deductions</td><td></td><td style='text-align: right;'>" + deductions + "</td></tr>";

        //deduction details
        content += "<tr><td></td><td>Advance Interest</td><td style='text-align: right;'>" + advance_interest + "</td></tr>";
        content += "<tr><td></td><td>Life Insurance</td><td style='text-align: right;'>" + life_insurance + "</td></tr>";
        content += "<tr><td></td><td>Service Charge</td><td style='text-align: right;'>" + service_charge + "</td></tr>";
        content += "<tr><td></td><td>Loan Insurance</td><td style='text-align: right;'>" + loan_insurance + "</td></tr>";
        content += "<tr><td></td><td>Booklet</td><td style='text-align: right;'>" + booklet + "</td></tr>";
        content += "<tr><td></td><td>Filing Fee</td><td style='text-align: right;'>" + filing_fee + "</td></tr>";
        content += "<tr><td></td><td>Mortuary Aid</td><td style='text-align: right;'>" + mortuary_aid + "</td></tr>";
        content += "<tr><td></td><td>CBU</td><td style='text-align: right;'>" + cbu + "</td></tr>";

        
        content += "<tr><td>Net Proceed</td><td></td><td style='text-align: right;'>" + net_proceed + "</td></tr>";

        $('#loan_details').html(content);
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




</script>