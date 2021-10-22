<?php
class wishlistItem {
    public $wishlist_id;
    public $login_information_id;
    public $item_name;
    public $item_description;
    public $item_link;
    public $quantity;
    public $item_price;
    public $birthday_gift;
    public $holiday_gift;
    public $already_purchased;

    function addWishlistItemClass(int $login_information_id, ?string $item_name, ?string $item_description, ?string $item_link, ?float $quantity, ?float $item_price, ?bool $birthday_gift, ?bool $holiday_gift, ?bool $already_purchased){

        $this->login_information_id= $login_information_id;
        $this->item_name= $item_name;
        $this->item_description= $item_description;
        $this->item_link= $item_link;
        $this->quantity= $quantity;
        $this->item_price= $item_price;
        $this->birthday_gift= $birthday_gift;
        $this->holiday_gift= $holiday_gift;
        $this->already_purchased= $already_purchased;

    }

    function updateFamilyWishlist(int $wishlist_id, ?bool $already_purchased){
         $this->wishlist_id = $wishlist_id;
         $this->already_purchased = $already_purchased;
  }

    
}



?>