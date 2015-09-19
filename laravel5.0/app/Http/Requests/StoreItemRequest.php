<?php namespace FandC\Http\Requests;

use FandC\Http\Requests\Request;

class StoreItemRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'new_item_imgs' => 'required|mimes:jpeg,bmp,png|max:5000',
			'new_item_name' => 'required|string',
			'new_item_descr' => 'required|string',
			'new_item_categ' => 'required|array',
			'new_item_price' => 'required|numeric'
		];
	}

}
