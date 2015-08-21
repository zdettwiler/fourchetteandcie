<?php namespace FandC\Models;

use Illuminate\Database\Eloquent\Model;
use FanC\Models\Item as Item

class Basket extends Model
{
	public function items()
    {
        return $this->hasMany(Item);
    }
}
