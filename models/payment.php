<?php

class Payment extends Model
{

    public function getPayments(){

        $sql = "select a.*,
				a.id as payment_id,
                b.member_id,
                concat(b.lname, ', ', b.fname, ' ', b.extn, ' ', b.mname) as name,
				a.date as dop,
				c.*
                from t_payments a 
				inner join t_members b on b.member_id = a.member_id
				inner join t_loans c on c.member_id = a.member_id and c.loan_id = a.loan_id
                order by a.date desc";

        return $this->db->query($sql);
    }

    public function getPaymentById($id){

        $id = $this->db->escape($id);

        $sql = "select a.*,
				a.id as payment_id,
                b.member_id,
                concat(b.lname, ', ', b.fname, ' ', b.extn, ' ', b.mname) as name,
				a.date as dop,
                a.amount,
				((c.amount_payable / c.terms) - a.amount) as balance
                from t_payments a 
				inner join t_members b on b.member_id = a.member_id
                inner join t_loans c on c.member_id = a.member_id and c.loan_id = a.loan_id
                where a.id = {$id}
                order by a.date desc";

        $result = $this->db->query($sql);
        if (isset($result[0])){
            return $result[0];
        }
        return false;
    }

    /**
     * payment per schedule of repayment
     * @param mixed $id - loan_id
     * @return array
     */
    public function getPayableByPeriod($id, $dop){

        $id = $this->db->escape($id);
        $dop = $this->db->escape($dop);
      
        $sql = "SELECT
            b.loan_id,
            b.date_approved,
            a.date_due,
            c.member_id,
            concat(c.lname, ', ', c.fname, ' ', c.extn, ' ', c.mname) as name,
            a.date_due,
            (CASE WHEN b.terms = 1 AND DATEDIFF(STR_TO_DATE('$dop', '%Y-%m-%d'), a.date_due) < 0              /** if terms = 1 month calculate amortization by date*/
            THEN b.principal + (((b.principal * (b.interest / 100)) / 30) * DATEDIFF(STR_TO_DATE('$dop', '%Y-%m-%d'), b.date_approved))                   
            ELSE                                                                    /** if terms is not 1 month */
                (CASE WHEN DATEDIFF(STR_TO_DATE('$dop', '%Y-%m-%d'), a.date_due) > 0                          /** check if overdue else return payment amount*/
                THEN
                    (a.amortization + (a.amortization * 0.02))
                ELSE
                    a.amortization 
                END)
            END) as amount,                                
            a.amortization 			
            FROM loans a 
            INNER JOIN t_members c ON c.member_id = a.member_id
            WHERE a.loan_id = {$id}";

        $result = $this->db->query($sql);
        if (isset($result[0])){
            return $result[0];
        }
        return false;
    }

    /**
     * Make a full payment
     * @param mixed $id - loan_id
     * @return array
     */
    public function getFullPaymentAmount($data){

        $loan_id = $this->db->escape($data['loan_id']);
        $member_id = $this->db->escape($data['member_id']);
        $dop = $this->db->escape($data['dop']);
        $payment_type = $this->db->escape($data['type']);

        $sql = "";

        if($payment_type == 1){
            $sql = "SELECT
            a.loan_id,
            a.date_approved,
            a.maturity_date,            
            concat(c.lname, ', ', c.fname, ' ', c.extn, ' ', c.mname) as name,

            
            (
                a.principal + 

                (((a.principal * (a.interest / 100)) / 30) * DATEDIFF(STR_TO_DATE('{$dop}', '%Y-%m-%d'), a.date_approved)) -

                (
                    IFNULL( (SELECT SUM(x.amount) FROM t_payments x WHERE x.loan_id = a.loan_id AND x.member_id = a.member_id) , 0)
                )    
        
            ) as amount                       
            FROM t_loans a 
            INNER JOIN t_members c ON c.member_id = a.member_id
            WHERE a.loan_id = '{$loan_id}' AND a.member_id = '{$member_id}'";
        }else{
            $sql = "SELECT
                a.loan_id,
                a.date_approved,
                a.maturity_date,
                (((a.principal * (a.interest / 100)) / 30) * DATEDIFF(STR_TO_DATE('{$dop}', '%Y-%m-%d'), a.date_approved)) as aa,
                concat(c.lname, ', ', c.fname, ' ', c.extn, ' ', c.mname) as name,
                (
                    a.principal + 

                    (((a.principal * (a.interest / 100)) / 30) * DATEDIFF(STR_TO_DATE('{$dop}', '%Y-%m-%d'), a.date_approved)) -

                    (
                        IFNULL( (SELECT SUM(x.amount) FROM t_payments x WHERE x.loan_id = a.loan_id AND x.member_id = a.member_id) , 0)
                    )    
            
                ) as amount                       
                FROM t_loans a 
                INNER JOIN t_members c ON c.member_id = a.member_id
                WHERE a.loan_id = '{$loan_id}' AND a.member_id = '{$member_id}'";
        }
        

        $result = $this->db->query($sql);
        if (isset($result[0])){
            return $result[0];
        }
        return false;
    }



    public function calculatePayment($id, $dop){
        
        $id = $this->db->escape($id);
        $dop = $this->db->escape($dop);
      
        $sql = "SELECT
            a.id as payment_id,
            a.period,
            b.loan_id,
            b.date_approved,
            a.date_due,
            c.member_id,
            concat(c.lname, ', ', c.fname, ' ', c.extn, ' ', c.mname) as name,
            a.date_due,
            (CASE WHEN b.terms = 1 AND DATEDIFF(STR_TO_DATE('$dop', '%Y-%m-%d'), a.date_due) < 0              /** if terms = 1 month calculate amortization by date*/
            THEN b.principal + (((b.principal * (b.interest / 100)) / 30) * DATEDIFF(STR_TO_DATE('$dop', '%Y-%m-%d'), b.date_approved))                   
            ELSE                                                                    /** if terms is not 1 month */
                (CASE WHEN DATEDIFF(STR_TO_DATE('$dop', '%Y-%m-%d'), a.date_due) > 0                          /** check if overdue calculate else return payment amount*/
                THEN
                    (a.amortization + (a.amortization * 0.02))
                ELSE
                    a.amortization 
                END)
            END) as amount,                                
            a.amortization 			
            FROM t_schedule_of_payments a 
            INNER JOIN t_loans b ON b.loan_id = a.loan_id
            INNER JOIN t_members c ON c.member_id = b.member_id
            WHERE a.id = {$id}";

        $result = $this->db->query($sql);
        if (isset($result[0])){
            return $result[0];
        }
        return false;
    }

    public function getPaymentsByMemberId($cust_id){

        $cust_id = $this->db->escape($cust_id);
        $sql = "select a.*
                from t_payments a
                inner join t_reservation b
                on b.resv_no = a.resv_no
                where b.cust_id = '{$cust_id}'
                order by a.date desc";

        return $this->db->query($sql);
    }

    public function save($data, $id = null){

        $id = $this->db->escape($id);

        $member_id = $this->db->escape($data['member_id']);
        $loan_id = $this->db->escape($data['loan_id']);
        $period = $this->db->escape($data['period']);
        $amount = $this->db->escape($data['amount']);
        $penalty =  $this->db->escape($data['penalty']);
        $or_no =  $this->db->escape($data['or_no']);
        $dop =  $this->db->escape($data['dop']);
        $userid = Session::get('userid');

        if($data['payment_type'] == '2'){
            $loan = new Loan();

            $loan->updateLoanPayable($loan_id, $amount);
        }

        if(self::checkBalance($member_id, $loan_id) <= 0) return false;

        if (!$id){
            $sql= "insert into `t_payments` 
                set 
                `member_id`='{$member_id}',
                `loan_id`='{$loan_id}',
                `period`='{$period}',
                `amount`='{$amount}',
                `penalty`='{$penalty}',
                `userid`='{$userid}',
                `or_no`='{$or_no}',
                `date`='{$dop}'
                ";
        }else{
            $sql="update `t_payments` 
            set 
            `member_id`='{$member_id}',
            `loan_id`='{$loan_id}',
            `period`='{$period}',
            `amount`='{$amount}',
            `penalty`='{$penalty}',
            `userid`='{$userid}',
            `or_no`='{$or_no}',
            `date`='{$dop}'
            where
            `id` = '{$id}'
            ";
        }
        
        return $this->db->query($sql);;
    }


    public function delete($id){
        $id = $this->db->escape($id);
        $sql = "delete from t_payments where id ='{$id}'";
        $this->db->query($sql);

        return true;
    }

    
    public function checkBalance($member_id, $loan_id){

        $sql = "SELECT 
            ((a.amount_payable) - IFNULL((SELECT SUM(x.amount) FROM t_payments x WHERE x.member_id = a.member_id AND x.loan_id = a.loan_id), 0)) as balance 
            FROM t_loans a 
            WHERE a.member_id = '{$member_id}' and a.loan_id = '{$loan_id}' and a.status = 2";

        $result = $this->db->query($sql);
        if (isset($result[0])){
            return $result[0]['balance'];
        }
        return false;

    }

}
