<?php 
class holiday {
    public $holiday_id;
    public $family_id;
    public $holiday_name;
    public $holiday_date;
    public $gift_exchange_type;
    public $price_limit;

    
    function createHoliday(int $family_id, ?string $holiday_name, ?string $holiday_date, ?string $gift_exchange_type, ?float $price_limit){

        $this->family_id = $family_id;
        $this->holiday_name =$holiday_name;
        $this->holiday_date =$holiday_date;
        $this->gift_exchange_type = $gift_exchange_type;
        $this->price_limit = $price_limit;
    }

}
?>