	<!-- Stepper -->
        <div class="steps-form mt-3">
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
                    <a href="#step-3" class="btn btn-default btn-circle" disabled="disabled">3</a>
                    <p>Loan Summary</p>
                </div>
            </div>
        </div>
	
	<span>Deductions</span>
				<hr/>
			
			
				<?php
					$advance_interest = Deduction::get("advance_interest") * $this->data['principal'];
					$life_insurance = Deduction::get("life_insurance");
					$service_charge = Deduction::get("service_charge") * $this->data['principal'];
					$loan_insurance = Deduction::get("service_charge") * $this->data['principal'];
					$booklet = Deduction::get("booklet");
					$filing_fee = Deduction::get("filing_fee");
					$mortuary_aid = Deduction::get("mortuary_aid");
					if($this->data['loan_type'] == 1){
						$cbu = Deduction::get("cbu") * $this->data['principal'];
					}else {
						$cbu = 0;
					}
					
				?>
			
			<form method="POST">
				<input type="hidden" name="loan_id" value="<?=$this->data['loan_id']?>" />
				<input type="hidden" name="member_id"  value="<?=$this->data['member_id']?>" />
				<div class="row mb-3">
					<div class="col-md-3 text-md-right ">
					</div>
					<div class="col-md-6">
						<div class="row mt-3">
							<div class="col-sm-5">
								<label for="advance_interest">Advance Interest</label>
							</div>
							<div class="col-sm-5">
								<input class="form-control text-right" type="decimal" name="advance_interest" id="advance_interest" value="<?=Util::n_format($advance_interest)?>" readonly/>
							</div>
							<div class="col-sm-2">
								
							</div>
						</div>
						
						<div class="row mt-3">
							<div class="col-sm-5">
								<label for="life_insurance">Life Insurance <small class="form-text text-muted">(Optional)</small></label>
							</div>
							<div class="col-sm-5">
								<input class="form-control text-right" type="decimal" value="" name="life_insurance" id="life_insurance"/>
							</div>
							<div class="col-sm-2">
								<a href="#" class="btn btn-success btn-sm" id="btnAddLifeInsurance"><i class="fa fa-plus"></i></a>
								<a href="#" class="btn btn-danger btn-sm" id="btnRemoveLifeInsurance"><i class="fa fa-minus"></i></a>
							</div>
						</div>
						
						<div class="row mt-3">
							<div class="col-sm-5">
								<label for="service_charge">Service Charge</label>
							</div>
							<div class="col-sm-5">
								<input class="form-control text-right" type="decimal" value="<?=Util::n_format($service_charge)?>" name="service_charge" id="service_charge" readonly/>
							</div>
							<div class="col-sm-2">
								
							</div>
						</div>
					
					
						<div class="row mt-3">
							<div class="col-sm-5">
								<label for="loan_insurance">Loan Insurance <small class="form-text text-muted">(Optional)</small></label>
							</div>
							<div class="col-sm-5">
								<input class="form-control text-right" type="decimal" value="" name="loan_insurance" id="loan_insurance"/>
							</div>
							<div class="col-sm-2">
								<a href="#" class="btn btn-success btn-sm" id="btnAddLoanInsurance"><i class="fa fa-plus"></i></a>
								<a href="#" class="btn btn-danger btn-sm" id="btnRemoveLoanInsurance"><i class="fa fa-minus"></i></a>
							</div>
						</div>
						
						<div class="row mt-3">
							<div class="col-sm-5">
								<label for="booklet">Booklet <small class="form-text text-muted">(Optional)</small></label>
							</div>
							<div class="col-sm-5">
								<input class="form-control text-right" type="decimal" value="" name="booklet" id="booklet"/>
							</div>
							<div class="col-sm-2">
								<a href="#" class="btn btn-success btn-sm" id="btnAddBooklet"><i class="fa fa-plus"></i></a>
								<a href="#" class="btn btn-danger btn-sm" id="btnRemoveBooklet"><i class="fa fa-minus"></i></a>
							</div>
						</div>
						
						<div class="row mt-3">
							<div class="col-sm-5">
								<label for="filing_fee">Filing Fee</label>
							</div>
							<div class="col-sm-5">
								<input class="form-control text-right" type="decimal" value="" name="filing_fee" id="filing_fee"/>
							</div>
							<div class="col-sm-2">
								<a href="#" class="btn btn-success btn-sm" id="btnAddFilingFee"><i class="fa fa-plus"></i></a>
								<a href="#" class="btn btn-danger btn-sm" id="btnRemoveFilingFee"><i class="fa fa-minus"></i></a>
							</div>
						</div>
						
						<div class="row mt-3">
							<div class="col-sm-5">
								<label for="mortuary_aid">Mortuary Aid <small class="form-text text-muted">(Optional)</small></label>
							</div>
							<div class="col-sm-5">
								<input class="form-control text-right" type="decimal" value="" name="mortuary_aid" id="mortuary_aid"/>
							</div>
							<div class="col-sm-2">
								<a href="#" class="btn btn-success btn-sm" id="btnAddMortuaryAid"><i class="fa fa-plus"></i></a>
								<a href="#" class="btn btn-danger btn-sm" id="btnRemoveMortuaryAid"><i class="fa fa-minus"></i></a>
							</div>
						</div>
						
						<div class="row mt-3">
							<div class="col-sm-5">
								<label for="cbu">CBU</label>
							</div>
							<div class="col-sm-5">
								<input class="form-control text-right" type="decimal" value="" name="cbu" id="cbu" />
							</div>
							<div class="col-sm-2">
								<a href="#" class="btn btn-success btn-sm" id="btnAddCBU"><i class="fa fa-plus"></i></a>
								<a href="#" class="btn btn-danger btn-sm" id="btnRemoveCBU"><i class="fa fa-minus"></i></a>
							</div>
						</div>
						
					
					</div>
					
					
					<div class="col-md-3">
						
					</div>
					
					
				</div>
				
				<hr/>
				
												
				<div class="row mb-3">
					<div class="col-md-3 ">
						<a href="#" class="btn btn-secondary btn-lg" style="width: 150px;">BACK</a>
					</div>
					<div class="col-md-6 ">
						
					</div>
					<div class="col-md-3 text-right" >
						<input type="submit" class="btn btn-primary btn-lg" name="loan" value="PROCEED" style="width: 150px;"/>
					</div>
				</div>
			</form>

<script>

	$life_insurance = <?=$life_insurance?>;
	$loan_insurance = <?=$loan_insurance?>;
	$booklet = <?=$booklet?>;
	$filing_fee = <?=$filing_fee?>;
	$mortuary_aid = <?=$mortuary_aid?>;
	$cbu = <?=$cbu?>;


	//life insurance
	$('body').on('click', '#btnAddLifeInsurance', function(){
		$('#life_insurance').val(parseFloat($life_insurance).toFixed(2));
	});
	$('body').on('click', '#btnRemoveLifeInsurance', function(){
		$('#life_insurance').val('');
	});

	//loan insurance
	$('body').on('click', '#btnAddLoanInsurance', function(){
		$('#loan_insurance').val(parseFloat($loan_insurance).toFixed(2));
	});
	$('body').on('click', '#btnRemoveLoanInsurance', function(){
		$('#loan_insurance').val('');
	});

	//booklet
	$('body').on('click', '#btnAddBooklet', function(){
		$('#booklet').val(parseFloat($booklet).toFixed(2));
	});
	$('body').on('click', '#btnRemoveBooklet', function(){
		$('#booklet').val('');
	});

	
	//filing_fee
	$('body').on('click', '#btnAddFilingFee', function(){
		$('#filing_fee').val(parseFloat($filing_fee).toFixed(2));
	});
	$('body').on('click', '#btnRemoveFilingFee', function(){
		$('#filing_fee').val('');
	});


	//mortuary_aid
	$('body').on('click', '#btnAddMortuaryAid', function(){
		$('#mortuary_aid').val(parseFloat($mortuary_aid).toFixed(2));
	});
	$('body').on('click', '#btnRemoveMortuaryAid', function(){
		$('#mortuary_aid').val('');
	});


	//cbu
	$('body').on('click', '#btnAddCBU', function(){
		$('#cbu').val(parseFloat($cbu).toFixed(2));
	});
	$('body').on('click', '#btnRemoveCBU', function(){
		$('#cbu').val('');
	});

</script>