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
            return false;
        }
        if($item->get_is_new() == 1)
        {
            $item->set_is_new(0);
            $item->update_db_item();
            return false;
        }
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
            return false;
        }
        if($item->get_is_best_seller() == 1)
        {
            $item->set_is_best_seller(0);
            $item->update_db_item();
            return false;
        }
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
            return false;
        }
        if($item->get_is_sold_out() == 1)
        {
            $item->set_is_sold_out(0);
            $item->update_db_item();
            return false;
        }
    }

//----------------------------------------------------------------------------//
// EDIT STAMPED
//----------------------------------------------------------------------------//
    public static function edit_stamped($ref, $stamped)
    {
        $item = new Item($ref);

        $item->set_stamped($stamped);
        $item->update_db_item();

        return false;
    }

//----------------------------------------------------------------------------//
// EDIT DESCR
//----------------------------------------------------------------------------//
    public static function edit_descr($ref, $stamped)
    {
        $item = new Item($ref);

        $item->set_descr($stamped);
        $item->update_db_item();

        return false;
    }

//----------------------------------------------------------------------------//
// EDIT CATEG
//----------------------------------------------------------------------------//
    public static function edit_categ($ref, $stamped)
    {
        $item = new Item($ref);

        $item->set_stamped($stamped);
        $item->update_db_item();

        return false;
    }

//----------------------------------------------------------------------------//
// EDIT CATEG
//----------------------------------------------------------------------------//
    public static function edit_price($ref, $stamped)
    {
        $item = new Item($ref);

        $item->set_price($stamped);
        $item->update_db_item();

        return false;
    }

//----------------------------------------------------------------------------//
// MAKE HTML ROW OF UPDATED ITEM
//----------------------------------------------------------------------------//
    public static function updated_item_html($ref)
    {
        $item = new Item($ref);

        $update ="<td class='cell-img'>
                <img class='item-img' src='http://www.fourchetteandcie.com/pictures/{$item->get_sectionfullname()}/100px/{$ref}_thumb.jpg' height='50'>
            </td>
            <td class='cell-details'>
                <span class='ref-box'>{$ref}</span>
                <b><span class='edit-text' target='EDIT_STAMPED'>{$item->get_stamped()}</span></b></<br>
                <span class='edit-text' target='EDIT_DESCR'>{$item->get_descr()}</span>
                (<span class='edit-text' target='EDIT_CATEG'>{$item->im_ex_plode_categs($item->get_categ())}</span>)
            </td>
            <td class='cell-check'>
                <span class='edit-toggle' target='TOGGLE_NEW'>
                    <img src='http://www.fourchetteandcie.com/pictures/{$item->get_is_new()}.png'>
                </span>
            </td>
            <td class='cell-check'>
                <span class='edit-toggle' target='TOGGLE_BEST_SELLER'>
                    <img src='http://www.fourchetteandcie.com/pictures/{$item->get_is_best_seller()}.png'>
                </span>
            </td>
            <td class='cell-check'>
                <span class='edit-toggle' target='TOGGLE_SOLD_OUT'>
                    <img src='http://www.fourchetteandcie.com/pictures/{$item->get_is_sold_out()}.png'>
                </span>
            </td>
            <td class='cell-price'>
                €<span class='edit-text' target='EDIT_PRICE'>{$item->get_price()}</span>
            </td>";

        echo $update;
    }
}
