<?php

class Deduction extends Model
{

    public function getDeductions(){
        $sql = "select * from l_deductions";

        return $this->db->query($sql);
    }

    public function getDeductionsByKey($key){
        $key = $this->db->escape($key);
        $sql = "select * from l_deductions where key_word ='{$key}' limit 1";

        $result = $this->db->query($sql);
        if (isset($result[0])){
            return $result[0];
        }
        return false;
    }

    public static function get($key){
        $deduction = new Deduction();
        $deductions = $deduction->getDeductionsByKey($key);
        return $deductions['value'];
    }
	
	public static function getRow($key){
        $deduction = new Deduction();
        $deductions = $deduction->getDeductionsByKey($key);
        return $deductions;
    }
}