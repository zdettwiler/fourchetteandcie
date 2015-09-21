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

//----------------------------------------------------------------------------//
// DELETE IMG
//----------------------------------------------------------------------------//
    public static function delete_img($ref, $img_nb)
    {
        $item = new Item($ref);
        $_ = '';
        $path_originals = public_path().'/pictures/'. $ref[0] .'/originals/';
        $path_100px = public_path().'/pictures/'. $ref[0] .'/100px/';
        $path_500px = public_path().'/pictures/'. $ref[0] .'/500px/';

        if($img_nb != 0 AND $img_nb != 1)
        {
            $_ = '_';
        }
        if($img_nb == 0 OR $img_nb == 1)
        {
            $img_nb = '';
        }

        unlink($path_originals . $ref .'_original'. $_.$img_nb .'.jpg');
        unlink($path_100px . $ref .'_thumb'. $_.$img_nb .'.jpg');
        unlink($path_500px . $ref.$_.$img_nb .'.jpg');

        echo 'deleted '.$ref .'_'. $img_nb .'.jpg <br>';
        $item->set_img_count($item->get_img_count() - 1);
        $item->update_db_item();

        if($img_nb == 0)
        {
            $img_nb = 1;
        }

        for($i=$img_nb+1 ; $i<=$item->get_img_count()+1 ; $i++)
        {
            echo $i;
            if($i == 2)
            {
                rename(
                    $path_originals . $ref .'_original_' .$i .'.jpg',
                    $path_originals . $ref .'_original.jpg'
                );
                rename(
                    $path_100px . $ref .'_thumb_'. $i .'.jpg',
                    $path_100px . $ref .'_thumb.jpg'
                );
                rename(
                    $path_500px . $ref . '_'. $i .'.jpg',
                    $path_500px . $ref .'.jpg'
                );
            }
            else
            {
                rename(
                    $path_originals . $ref .'_original_'. $i .'.jpg',
                    $path_originals . $ref .'_original_'. ($i-1) .'.jpg'
                );
                rename(
                    $path_100px . $ref .'_thumb_'. $i .'.jpg',
                    $path_100px . $ref .'_thumb_'. ($i-1) .'.jpg'
                );
                rename(
                    $path_500px . $ref .'_'. $i .'.jpg',
                    $path_500px . $ref .'_'. ($i-1) .'.jpg'
                );
            }

        }

        // echo 'EDIT_PRICE-'. $ref .'-'. $item->get_price();
    }
}
