<?php
class Account extends Model{

    public function getAccountsSummary(){
        $sql = "SELECT a.account_code, b.description, SUM(a.amount) as amount FROM t_accounts a 
            INNER JOIN l_accounts b on a.account_code = b.account_code
            GROUP BY b.account_code, b.description";

        return $this->db->query($sql);
    }

}