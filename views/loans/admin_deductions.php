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
							<div class="col">
								<label for="advance_interest">Advance Interest</label>
							</div>
							<div class="col">
								<input class="form-control text-right" type="decimal" name="advance_interest" id="advance_interest" value="<?=Util::n_format($advance_interest)?>" readonly/>
							</div>
							
						</div>
						
						<div class="row mt-3">
							<div class="col">
								<label for="life_insurance">Life Insurance <small class="form-text text-muted">(Optional)</small></label>
							</div>
							<div class="col">
								<input class="form-control text-right" type="decimal" value="<?=Util::n_format($life_insurance)?>" name="life_insurance" id="life_insurance"/>
							</div>
						</div>
						
						<div class="row mt-3">
							<div class="col">
								<label for="service_charge">Service Charge</label>
							</div>
							<div class="col">
								<input class="form-control text-right" type="decimal" value="<?=Util::n_format($service_charge)?>" name="service_charge" id="service_charge" readonly/>
							</div>
						</div>
					
					
						<div class="row mt-3">
							<div class="col">
								<label for="loan_insurance">Loan Insurance <small class="form-text text-muted">(Optional)</small></label>
							</div>
							<div class="col">
								<input class="form-control text-right" type="decimal" value="<?=Util::n_format($loan_insurance)?>" name="loan_insurance" id="loan_insurance"/>
							</div>
						</div>
						
						<div class="row mt-3">
							<div class="col">
								<label for="booklet">Booklet <small class="form-text text-muted">(Optional)</small></label>
							</div>
							<div class="col">
								<input class="form-control text-right" type="decimal" value="<?=Util::n_format($booklet)?>" name="booklet" id="booklet"/>
							</div>
						</div>
						
						<div class="row mt-3">
							<div class="col">
								<label for="filing_fee">Filing Fee</label>
							</div>
							<div class="col">
								<input class="form-control text-right" type="decimal" value="<?=Util::n_format($filing_fee)?>" name="filing_fee" id="filing_fee"/>
							</div>
						</div>
						
						<div class="row mt-3">
							<div class="col">
								<label for="mortuary_aid">Mortuary Aid <small class="form-text text-muted">(Optional)</small></label>
							</div>
							<div class="col">
								<input class="form-control text-right" type="decimal" value="<?=Util::n_format($mortuary_aid)?>" name="mortuary_aid" id="mortuary_aid"/>
							</div>
						</div>
						
						<div class="row mt-3">
							<div class="col">
								<label for="cbu">CBU</label>
							</div>
							<div class="col">
								<input class="form-control text-right" type="decimal" value="<?=Util::n_format($cbu)?>" name="cbu" id="cbu" />
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
