<?php
class Fund extends Model{

    public function getFundType(){
        $sql = "select * from l_funds";

        return $this->db->query($sql);
    }

    public function getFundsByType(){
        $sql = "SELECT
            a.description,
            IFNULL((SELECT SUM(b.amount) FROM t_accounts b WHERE b.account_code = a.lid), 0) AS total,
            IFNULL((SELECT SUM(b.principal) FROM t_loans b WHERE b.fund_id = a.lid AND (b.amount_payable - IFNULL((SELECT SUM(c.amount) FROM t_payments c WHERE c.loan_id = b.loan_id), 0)) >= 0), 0) AS loans,
            IFNULL(
                (
                    IFNULL((SELECT SUM(b.amount) FROM t_accounts b WHERE b.account_code = a.lid), 0) 
                    - 
                    IFNULL((SELECT SUM(b.principal) FROM t_loans b WHERE b.fund_id = a.lid AND (b.amount_payable - IFNULL((SELECT SUM(c.amount) FROM t_payments c WHERE c.loan_id = b.loan_id), 0)) >= 0), 0) 
                ), 
            0) AS amount
            FROM l_funds a 
            ";

        return $this->db->query($sql);
    }

    public function getFunds(){

        $sql = "SELECT
            a.member_id,
            concat(a.lname, ', ', a.fname, ' ', a.mname) as member,
            IFNULL(
                (SELECT SUM(b.amount) FROM t_accounts b WHERE b.member_id = a.member_id AND b.account_code = 1) , 
            0) AS CBU,
            IFNULL(
                (SELECT SUM(b.amount) FROM t_accounts b WHERE b.member_id = a.member_id AND b.account_code = 2), 
            0) AS WP,
            IFNULL(
                (SELECT SUM(b.amount) FROM t_accounts b WHERE b.member_id = a.member_id AND b.account_code = 3), 
            0) AS ICI,
            IFNULL(
                (SELECT SUM(b.amount) FROM t_accounts b WHERE b.member_id = a.member_id AND b.account_code = 4), 
            0) AS membership
          
            FROM t_members a
            ORDER BY a.lname, a.fname, a.mname";

        return $this->db->query($sql);
    }

    public function getFundsById($id){
        $id = $this->db->escape($id);
        $sql = "select * from t_funds where id ='{$id}' limit 1";

        $result = $this->db->query($sql);
        if (isset($result[0])){
            return $result[0];
        }
        return false;
    }

    public function save($data, $id = null){
        $id = $this->db->escape($id);

        $member_id = $this->db->escape($data['member_id']);
        $fund_id = $this->db->escape($data['fund_id']);
        $amount = $this->db->escape($data['amount']);

        if (!$id){

            $sql = "insert into `t_accounts`
            set
            `account_code`='{$fund_id}',
            `amount`='{$amount}',
            `member_id`='{$member_id}',
            `date`=NOW()
            ";

        }else {
            $sql = "update `t_accounts`
            SET
            `account_code`='{$fund_id}',
            `amount`='{$amount}',
            `member_id`='{$member_id}'
            WHERE id = '{$id}'
            ";

            print_r($sql);


        }
        return $this->db->query($sql);;
    }

    public function change_image($id = null){
        $id = $this->db->escape($id);

        if ($id){
            /*change file name before uploading to website*/
            $temp = explode(".", $_FILES["file"]["name"]);
            $new_filename = strtotime("now"). '.' . end($temp);

            $fname       = $_FILES['file']['name'];
            $temp_name  = $_FILES['file']['tmp_name'];
            if(isset($fname)){
                if(!empty($fname)){
                    $loc = 'uploads/carousel/';
                    if(move_uploaded_file($temp_name, $loc.$new_filename)){
                    }
                }
            }  else {
                return false;
            }

            $sql = "UPDATE `l_carousel` SET
            `img`='{$new_filename}'
            WHERE lid ='{$id}'
            ";

        }
        return $this->db->query($sql);;
    }


    public function delete($id){
        $id = $this->db->escape($id);
        $sql = "DELETE from l_carousel where lid='{$id}'";


        return $this->db->query($sql);
    }
}
