<?php
class Loan extends Model{

    //get all loans
    public function getLoans(){

        $sql = "SELECT 
                b.loan_id,
                a.member_id, 
                concat(a.lname, ', ', a.fname, ' ', a.extn, ' ', a.mname) as name,
                b.principal,
                (SELECT description FROM l_terms x WHERE x.lid = b.terms) as terms,
                (SELECT description FROM l_funds x WHERE x.lid = b.fund_id) as type,
                (SELECT description FROM l_interest_type x WHERE x.lid = b.interest_type) as interest_type,
                b.deductions,
                (b.amount_payable / b.terms) as monthly,
                b.net_proceed,
                (b.amount_payable - (SELECT SUM(x.amount) FROM t_payments x WHERE x.loan_id = b.loan_id AND x.member_id = b.member_id)) as balance,
                (SELECT description FROm l_loan_status x WHERE x.lid = b.status) as status
                FROM t_loans b INNER JOIN t_members a on b.member_id = a.member_id 
                WHERE a.is_active = 1 AND b.status = 2
                GROUP BY b.loan_id
                ";

        return $this->db->query($sql);
    }

     //get all loans
     public function getPendingLoans(){

        $sql = "SELECT 
                b.loan_id,
                a.member_id, 
                concat(a.lname, ', ', a.fname, ' ', a.extn, ' ', a.mname) as name,
                b.principal,
                (SELECT description FROM l_terms x WHERE x.lid = b.terms) as terms,
                (SELECT description FROM l_funds x WHERE x.lid = b.fund_id) as type,
                (SELECT description FROM l_interest_type x WHERE x.lid = b.interest_type) as interest_type,
                b.deductions,
                (b.amount_payable / b.terms) as monthly,
                b.net_proceed,
                (b.amount_payable - (SELECT SUM(x.amount) FROM t_payments x WHERE x.loan_id = b.loan_id AND x.member_id = b.member_id)) as balance,
                (SELECT description FROm l_loan_status x WHERE x.lid = b.status) as status
                FROM t_loans b INNER JOIN t_members a on b.member_id = a.member_id 
                WHERE a.is_active = 1 AND b.status = 1
                GROUP BY b.loan_id
                ";

        return $this->db->query($sql);
    }

    //search loans
    public function searchLoans($query){

        $query = $this->db->escape($query);

        $sql = "SELECT 
                b.loan_id,
                a.member_id, 
                concat(a.lname, ', ', a.fname, ' ', a.extn, ' ', a.mname) as name,
                b.principal,
                (SELECT description FROM l_terms x WHERE x.lid = b.terms) as terms,
                (SELECT description FROM l_funds x WHERE x.lid = b.fund_id) as type,
                b.deductions,
                (b.amount_payable / b.terms) as monthly,
                b.net_proceed,
                b.status
                FROM t_loans b 
                INNER JOIN t_members a on b.member_id = a.member_id 
                WHERE lname LIKE '%{$query}%' or fname LIKE '%{$query}%'
                GROUP BY b.loan_id";

        return $this->db->query($sql);
    }

    //get loan details by member id
    public function getLoansById($id){
        $id = $this->db->escape($id);
        $sql = "SELECT  *,
                (a.amount_payable / a.terms) as monthly,
                DATE_ADD(DATE(a.date_approved), INTERVAL a.terms MONTH) as maturity_date  
                FROM t_loans a 
                INNER JOIN t_members b ON b.member_id = a.member_id 
                WHERE a.loan_id = '{$id}'";

        $result = $this->db->query($sql);
        if (isset($result[0])){
            return $result[0];
        }
        return false;
    }

    //get open loans
    public function getOpenLoans(){

        $sql = "SELECT 
                COUNT(*) as open_loans
                FROM t_loans a 
                WHERE (a.amount_payable - IFNULL((SELECT SUM(b.amount) FROM t_payments b WHERE b.loan_id = a.loan_id AND b.member_id = a.member_id), 0)) >= 0
                ";

        $result = $this->db->query($sql);
        if (isset($result[0])){
            return $result[0];
        }
        return false;
    }


    
    //get close loans
    public function getCloseLoans(){

        $sql = "SELECT 
                COUNT(*) as close_loans
                FROM t_loans a 
                WHERE (a.amount_payable - IFNULL((SELECT SUM(b.amount) FROM t_payments b WHERE b.loan_id = a.loan_id AND b.member_id = a.member_id), 0)) <= 0
                ";

        $result = $this->db->query($sql);
        if (isset($result[0])){
            return $result[0];
        }
        return false;
    }


    //get loan details by loan id
    public function getLoansByLoanId($id){
        $id = $this->db->escape($id);
        $sql = "SELECT *,
                (SELECT x.description FROM l_funds x WHERE x.lid = a.fund_id) as loan_type,
                (SELECT x.description FROM l_interest_type x WHERE x.lid = a.interest_type) as interest_type,
                (SELECT x.description FROM l_interest_term x WHERE x.lid = a.interest_term) as interest_term,
                (0) as running_total, 
                (0) as amount,
                (a.amount_payable / a.terms) as monthly,
                DATE_ADD(DATE(a.date_approved), INTERVAL a.terms MONTH) as maturity_date,  
                (a.amount_payable) as balance 
                FROM t_loans a 
                INNER JOIN t_members b ON b.member_id = a.member_id 
                WHERE a.loan_id = '{$id}'";

        $result = $this->db->query($sql);
        if (isset($result[0])){
            return $result[0];
        }
        return false;
    }

    //get loan schedule by loan id
    public function getLoanSchedule($id){
        $id = $this->db->escape($id);
        $sql = "SELECT 
				(SELECT concat(x.lname, ', ', x.fname, ' ', x.extn, ' ', x.mname) as name FROM t_members x WHERE x.member_id = a.member_id) as name,
                a.*,
				(sum(b.amount) - a.amortization) as balance,
				sum(b.amount) as payment
                FROM t_schedule_of_payments a 
				LEFT JOIN t_payments b ON b.loan_id = a.loan_id and b.member_id = a.member_id and b.period = a.period
				WHERE a.loan_id = '{$id}'
				GROUP BY a.loan_id, a.member_id, a.period
				";

        return $this->db->query($sql);
    }

    /**
     * @param mixed     $id     Loan ID
     * @return array    
     */
    public function getPaymentAmount($id){
        $id = $this->db->escape($id);
        $sql = "SELECT *,

                FROM t_loans a 
                INNER JOIN t_members b ON b.member_id = a.member_id 
                WHERE a.loan_id = '{$id}'";

        $result = $this->db->query($sql);
        if (isset($result[0])){
            return $result[0];
        }
        return false;
    }


    public function getLoanBalance($loan_id){

        $loan_id = $this->db->escape($loan_id);

        $sql = "SELECT a.*, 
            (SELECT SUM(x.amount) FROM t_payments x WHERE x.loan_id = a.loan_id and x.member_id = a.member_id and x.id <= a.id) as running_total, 
            b.amount_payable,
            (b.amount_payable - (SELECT SUM(x.amount) FROM t_payments x WHERE x.loan_id = a.loan_id and x.member_id = a.member_id and x.id <= a.id) ) as balance
            FROM t_payments a 
            INNER JOIN t_loans b ON a.loan_id = b.loan_id AND a.member_id = b.member_id 
            WHERE a.loan_id = '{$loan_id}'";

        return $this->db->query($sql);

    }
    /**
     * validate loan, save details and add schedule of payments
     */
    public function save($data, $id = null){

        $id = $this->db->escape($id);

        $loan_id = $this->db->escape($data['loan_id']);
        $member_id = $this->db->escape($data['member_id']);
        $date_approved = $this->db->escape($data['date_approved']);
        $principal = $this->db->escape($data['amount']);
        $terms = $this->db->escape($data['terms']);
        $loan_type = $this->db->escape($data['loan_type']);
		$interest_type = $this->db->escape($data['interest_type']);
		$interest = $this->db->escape($data['interest']);
		$interest_term = $this->db->escape($data['interest_term']);
        $fund_id = $this->db->escape($data['loan_type']);
        $status = 1;

		$data = array(
					'principal' => $principal,
					'terms' => $terms,
					'interest' => $interest,
					'interest_type' => $interest_type,
					'interest_term' => $interest_term
                );
                
        $monthly = self::getMonthlyPayments($data);
		$amount_payable = self::getAmountPayable($data);
		
        $userid = Session::get('userid');
       
        if (!$id){
            $sql = "insert into `t_loans`
                set
                `loan_id`='{$loan_id}',
                `member_id`='{$member_id}',
                `date_approved`='{$date_approved}',
				`fund_id`='{$fund_id}',
				`loan_type`='{$loan_type}',
                `principal`='{$principal}',
				`amount_payable`='{$amount_payable}',
                `terms`='{$terms}',
				`interest_type`='{$interest_type}',
				`interest`='{$interest}',
				`interest_term`='{$interest_term}',
                `deductions`='{$deductions}',
                `net_proceed`='{$net_proceed}',  
                `status`='{$status}',
                `userid`='{$userid}'
            ";
        }else{
            $sql = "update `t_loans`
                set
                `loan_id`='{$loan_id}',
                `member_id`='{$member_id}',
                `date_approved`='{$date_approved}',
				`fund_id`='{$fund_id}',
				`loan_type`='{$loan_type}',
                `principal`='{$principal}',
				`amount_payable`='{$amount_payable}',
                `terms`='{$terms}',
				`interest_type`='{$interest_type}',
				`interest`='{$interest}',
				`interest_term`='{$interest_term}',
                `deductions`='{$deductions}',
                `net_proceed`='{$net_proceed}',               
                `status`='{$status}',
                `userid`='{$userid}'
                WHERE
                id = '{$id}'
            ";
        }

        return $this->db->query($sql);
    }


    public function delete($id){
        $id = $this->db->escape($id);

        //loans
        $sql = "DELETE FROM t_loans WHERE loan_id = '{$id}'";
        $this->db->query($sql);

        //accounts
        $sql = "DELETE FROM t_accounts WHERE loan_id = '{$id}'";
        $this->db->query($sql);


        //schedule of payments
        $sql = "DELETE FROM t_schedule_of_payments WHERE loan_id = '{$id}'";
        $this->db->query($sql);


        //payments
        $sql = "DELETE FROM t_payments WHERE loan_id = '{$id}'";
        $this->db->query($sql);

        $log = new Log();

        return true;
    }

    public function updateLoanPayable($loan_id, $amount){
        $loan_id = $this->db->escape($loan_id);
        $amount = $this->db->escape($amount);

        $sql = "UPDATE t_loans a
                SET a.amount_payable = IFNULL((SELECT SUM(x.amount) FROM t_payments x WHERE x.loan_id = a.loan_id), 0) + {$amount} 
                WHERE a.loan_id = '{$loan_id}'";

        $log = new Log();

        return $this->db->query($sql);
    }

    /**
     * Add schedule of payment
     * @param array $data
     * @return array
     */
   
    /**
     * Show schedule of payment
     * @param array $data
     * @return array
     */
    public function showScheduleofPayments($data){

        $result = array();

		$member_id = $data['member_id'];
		$loan_id = $data['loan_id'];
		$terms = $data['terms'];
		$monthly = $data['monthly'];
		$date_approved = $data['date_approved'];
		$amount_payable = $data['amount_payable'];
        $principal = $data['principal'];
		$interest = $data['interest'];
		$interest_type = $data['interest_type'];
		$interest_term = $data['interest_term'];
		
		$accommulatedInterest = 0;
        $runningBalance = $amount_payable;
        $runningPrincipal = $principal;
		
		$monthlyrate = 0;
		$monthly_principal = 0;
		$monthly_interest = 0;
		

        for ($x = 1; $x <= $terms; $x++){
		
			if($interest_type == 1){ 	//flat interest rate
				$monthlyrate = ((($terms / $interest_term) * $interest) / 100);
				$monthly_principal = round(($principal / $terms), 2);
                $interestPerMonth = round(($amount_payable / $terms) - $monthly_principal, 2);
			}else {				        //diminishing interest rate
				$monthlyrate = (($terms / $interest_term) * $interest / 100) / $terms;
				$interestPerMonth = round($runningPrincipal * $monthlyrate, 2);
				$monthly_principal = round(($amount_payable / $terms) - $interestPerMonth, 2);
                $accommulatedInterest += round($interestPerMonth, 2);               
            }
            
            $runningBalance -=  $monthly;
            $runningPrincipal -= $monthly_principal;
		
            $date = new DateTime($date_approved);
            $date->add(new DateInterval('P'.$x.'M'));
            
			$row = array(
                'member_id' => $member_id,
                'loan_id' => $loan_id,
                'period' => $x,
                'date_due' => $date->format('Y-m-d'),
                'amortization' => $monthly,
                'principal' => $monthly_principal,
                'interest' => $interestPerMonth,
                'balance' => $runningBalance			
            );

            $result[] = $row;
        }

        return  $result;
    }

    public function validateLoan($member_id, $fund_id){

        $sql = "SELECT * FROM t_loans a 
            WHERE a.member_id = '{$member_id}' and a.fund_id = '{$fund_id}' and status = 0";

        $result = $this->db->query($sql);
        if (isset($result[0])){
            return $result[0];
        }
        return false;

    }
	
	public function getMonthlyPayments($data){
	
		$principal = $data['principal'];
		$terms = $data['terms'];
		$interest = $data['interest'];
		$interest_type = $data['interest_type'];
		$interest_term = $data['interest_term'];
		
		$monthly = 0;
		
		if($interest_type == 1){ 	        //flat interest rate
			$interest = ((($terms / $interest_term) * $interest) / 100);
			$monthly = (($principal + ($principal * $interest)) / $terms);
		}else {				                //diminishing interest rate
			$interest = (($terms / $interest_term) * $interest / 100) / $terms;
			$monthly = self::PMT($interest, $terms, $principal, 0, 0);
		}
		
		return round($monthly, 2);
    }
    
    public function getAmountPayable($data){
	
		$principal = $data['principal'];
		$terms = $data['terms'];
		$interest = $data['interest'];
		$interest_type = $data['interest_type'];
		$interest_term = $data['interest_term'];
		
		$amount_payable = 0;
		
		if($interest_type == 1){ 	        //flat interest rate
			$interest = ((($terms / $interest_term) * $interest) / 100);
			$amount_payable = ($principal + ($principal * $interest));
		}else {				                //diminishing interest rate
			$interest = (($terms / $interest_term) * $interest / 100) / $terms;
			$amount_payable = (self::PMT($interest, $terms, $principal, 0, 0)) * $terms;
		}
		
		return round($amount_payable, 2);
    }

	
	public function saveDeductions($data){
	
		$loan_id = $data['loan_id'];
		$member_id = $data['member_id'];
			
		foreach($data as $key => $value){
			
			$deduction = Deduction::getRow($key);
			$account_code = $deduction['account_code'];
			
			if($account_code){
				$sql = "insert into `t_accounts` SET 
				`account_code`='{$account_code}',
				`loan_id`='{$loan_id}',
				`member_id`='{$member_id}',
				`amount`='{$value}',
				`remarks`='{$key}'
				";

				$this->db->query($sql);
				
			}
		}
		
		return true;
	}
	
	
	public function updateLoan($data){
		$loan_id = $data['loan_id'];
		$total_deductions = 0;
		
		foreach($data as $key => $value){
			$deduction = Deduction::getRow($key);
			$account_code = $deduction['account_code'];
			
			if($account_code){
				$total_deductions += $value;
			}
		}
		
		$loans = self::getLoansById($loan_id);
		$net_proceed = $loans['principal']  - $total_deductions;
		
		 $sql = "UPDATE `t_loans`
                SET
                `deductions`='{$total_deductions}',
                `net_proceed`='{$net_proceed}',               
                `status`= 2
                WHERE
                loan_id = '{$loan_id}'
            ";
		return $this->db->query($sql);
	}
	
	
	/**
	 * Copy of Excel's PMT function.

	 * @param double $interest        The interest rate for the loan.
	 * @param int    $num_of_payments The total number of payments for the loan in months.
	 * @param double $PV              The present value, or the total amount that a series of future payments is worth now;
	 *                                Also known as the principal.
	 * @param double $FV              The future value, or a cash balance you want to attain after the last payment is made.
	 *                                If fv is omitted, it is assumed to be 0 (zero), that is, the future value of a loan is 0.
	 * @param int    $Type            Optional, defaults to 0. The number 0 (zero) or 1 and indicates when payments are due.
	 *                                0 = At the end of period
	 *                                1 = At the beginning of the period
	 *
	 * @return float
	 */
	function PMT($interest,$num_of_payments,$PV,$FV = 0.00, $Type = 0){
		$xp=pow((1+$interest),$num_of_payments);
		return
			($PV* $interest*$xp/($xp-1)+$interest/($xp-1)*$FV)*
			($Type==0 ? 1 : 1/($interest+1));
	}
}