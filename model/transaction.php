<?php 

/**
 * 
 */
class Transaction{
	private $db;
	public function __construct(){
		$this->db = new Database;
	}
	public function addTransaction($data){
		// prepare the query
		$this->db->query("INSERT INTO
         transactions (
             cart_id, 
            email,
            full_name,
            city,
            street, 
            -- street2,
            state, 
            sub_total,
            grand_total, 
            currency,
            tax
            )
         VALUES (
            :cart_id,
            :email,
            :full_name, 
            :city,
            :street,
            -- :street2,
            :state, 
            :sub_total, 
            :grand_total,
            :currency,
            :tax)");
         $this->db->bind(':cart_id', $data['cart_id']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':full_name', $data['full_name']);
        $this->db->bind(':city', $data['city']);
        $this->db->bind(':street', $data['street']);
        // $this->db->bind(':street2', $data['street2']);
        $this->db->bind(':state', $data['state']);
        
        $this->db->bind(':sub_total', $data['sub_total']);
        
        $this->db->bind(':grand_total', $data['grand_total']);
        $this->db->bind(':currency', $data['currency']);
        $this->db->bind(':tax', $data['tax']);
    //    print_r($_POST);
		
		// execute the query
		if($this->db->execute()){
			return true;
		}else{
			return false;
		}

	}
}
