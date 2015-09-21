<?php namespace FandC\Facades;

use DB;
use Config;
use Item;
use Session;

class ItemQuickEditing
{

//----------------------------------------------------------------------------//
// TOGGLE NEW
//----------------------------------------------------------------------------//
    public static function toggle_new($ref)
    {
        $item = new Item($ref);

        if($item->get_is_new() == 0)
        {
            $item->set_is_new(1);
            $item->update_db_item();
        }
        elseif($item->get_is_new() == 1)
        {
            $item->set_is_new(0);
            $item->update_db_item();
        }

        echo 'TOGGLE_NEW-'. $ref .'-'. $item->get_is_new();
    }

//----------------------------------------------------------------------------//
// TOGGLE BEST SELLER
//----------------------------------------------------------------------------//
    public static function toggle_best_seller($ref)
    {
        $item = new Item($ref);

        if($item->get_is_best_seller() == 0)
        {
            $item->set_is_best_seller(1);
            $item->update_db_item();
        }
        elseif($item->get_is_best_seller() == 1)
        {
            $item->set_is_best_seller(0);
            $item->update_db_item();
        }

        echo 'TOGGLE_BEST_SELLER-'. $ref .'-'. $item->get_is_best_seller();
    }

//----------------------------------------------------------------------------//
// TOGGLE SOLD OUT
//----------------------------------------------------------------------------//
    public static function toggle_sold_out($ref)
    {
        $item = new Item($ref);

        if($item->get_is_sold_out() == 0)
        {
            $item->set_is_sold_out(1);
            $item->update_db_item();
        }
        elseif($item->get_is_sold_out() == 1)
        {
            $item->set_is_sold_out(0);
            $item->update_db_item();
        }

        echo 'TOGGLE_SOLD_OUT-'. $ref .'-'. $item->get_is_sold_out();
    }

//----------------------------------------------------------------------------//
// EDIT NAME
//----------------------------------------------------------------------------//
    public static function edit_name($ref, $name)
    {
        $item = new Item($ref);

        $item->set_name($name);
        $item->update_db_item();

        echo 'EDIT_NAME-'. $ref .'-'. $item->get_name();
    }

//----------------------------------------------------------------------------//
// EDIT DESCR
//----------------------------------------------------------------------------//
    public static function edit_descr($ref, $descr)
    {
        $item = new Item($ref);

        $item->set_descr($descr);
        $item->update_db_item();

        echo 'EDIT_DESCR-'. $ref .'-'. $item->get_descr();
    }

//----------------------------------------------------------------------------//
// EDIT CATEG
//----------------------------------------------------------------------------//
    public static function edit_categ($ref, $categs)
    {
        $item = new Item($ref);

        $item->set_categ($categs);
        $item->update_db_item();

        return false;
    }

//----------------------------------------------------------------------------//
// EDIT PRICE
//----------------------------------------------------------------------------//
    public static function edit_price($ref, $price)
    {
        $item = new Item($ref);

        $item->set_price($price);
        $item->update_db_item();

        echo 'EDIT_PRICE-'. $ref .'-'. $item->get_price();
    }
}
