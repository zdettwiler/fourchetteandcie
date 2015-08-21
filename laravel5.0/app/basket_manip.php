<?php
// BASKET MANIPULATIONS
// Deals with various functions to add, delete, update items in basket, and display a basket.

// CREATE THE BASKET
function create_basket()
{
	if(!isset($_SESSION['basket']))
	{
		$_SESSION['basket']=array();
	}
}
	
// EMPTY THE BASKET
function empty_basket()
{
	$_SESSION['basket']=array();
}

// ADD AN ITEM TO THE BASKET
function add_to_basket($ref_to_add)
{
	$found = false;

	// Check if item is already in the basket
	for($i=0 ; $i<=count($_SESSION['basket']) ; $i++)
	{
		// If YES, add a other one
		if( $_SESSION['basket'][$i]['ref'] == $ref_to_add)
		{
			$_SESSION['basket'][$i]['quantity']++;
			$found = true;
			break;
		}
	}
	
	// If NO, add the item in the basket
	if(!$found)
	{
		$position = count($_SESSION['basket']);
		$_SESSION['basket'][$position]['ref'] = $ref_to_add;
		$_SESSION['basket'][$position]['quantity'] = 1;
	}
}

// CHANGE THE QUANTITY OF AN ITEM ALREADY IN THE BASKET
function update_quantity($id_to_update, $new_quantity)
{
	// If the new quantity is not 0, change in basket
	if($new_quantity != 0)
	{
		$found = false;

		// Search the basket for the item
		for($i=0 ; $i<=count($_SESSION['basket']) ; $i++)
		{
			// If found
			if($_SESSION['basket'][$i]['id'] == $id_to_update)
			{
				$_SESSION['basket'][$i]['quantity'] = $new_quantity;
				$found = true;
				break;
			}
		}
		
		// If NO, add the item in the basket with the provided quantity
		if(!$found)
		{
			$position = count($_SESSION['basket']);
			$_SESSION['basket'][$position]['id'] = $id_to_update;
			$_SESSION['basket'][$position]['quantity'] = $new_quantity;
		}
	}
	// If the new quantity is 0, delete the item from the basket
	if($new_quantity == 0)
	{
		// Search the basket for the item
		for($i=0 ; $i<=count($_SESSION['basket']) ; $i++)
		{
			// If found, delete it
			if($_SESSION['basket'][$i]['id'] == $id_to_update)
			{
				unset($_SESSION['basket'][$i]);
				$_SESSION['basket'] = array_values($_SESSION['basket']);
				break;
			}
		}
		
	}
}

// DELETE AN ITEM FROM THE BASKET
function remove_from_basket($id_to_remove)
{
	////////// Check if item with this id exists!
	
	// Delete the item from the basket, and shift all the next ones to fill the position
	for($i=0 ; $i<=count($_SESSION['basket']) ; $i++)
	{
		// If YES, add a other one
		if($_SESSION['basket'][$i]['id'] == $id_to_remove)
		{
			unset($_SESSION['basket'][$i]);
			break;
		}
	}

	$_SESSION['basket'] = array_values($_SESSION['basket']);
}


// GET THE CATEGORY FULL NAME FROM REF
function get_categ_id($ref)
{
	$categ = $ref[0];
	$id = (int) substr($ref, 1);

	switch($categ)
	{
		case 'c':
			$categfullname = 'cutlery';
			break;
		case 'f':
			$categfullname = 'furniture';
			break;
		case 'l':
			$categfullname = 'lighting';
			break;
		case 'b':
			$categfullname = 'bric-a-brac';
			break;
	}

	// list($item_categ, $item_id, $item_categfullname) = array($categ, $id, $categfullname);
	// echo $item_categ.' '.$item_id.' '.$item_categfullname;

	return array($categ, $id, $categfullname);
}

// GET DETAILS OF THE BASKET
function populate_basket($basket, $db)
{
	$basket_contents = array(); // id, qty, price, stamped, descr, img
	$basket_totals = array(
						'total_basket' => 0,
						'total_items' => 0
						);

	
	for($i=0 ; $i<=count($basket)-1 ; $i++)
	{
		list($item_categ, $item_id, $item_categfullname) = get_categ_id($basket[$i]['ref']);

		$request = db_query($db, "SELECT id, descr, stamped, price, img FROM ".$item_categfullname." WHERE id=".$item_id);
			
		while ($data = $request->fetch())
		{
			$basket_totals['total_basket'] += $basket[$i]['quantity'] * $data["price"];
			$basket_totals['total_items'] += $basket[$i]['quantity'];

			$item = array(
						'ref' => $basket[$i]['ref'],
						'qty' => $basket[$i]['quantity'],
						'price' => $data['price'],
						'stamped' => $data['stamped'],
						'descr' => $data['descr'],
						'img' => $data['img']
					);
			array_push($basket_contents, $item);
		}
	}

	array_push($basket_contents, $basket_totals);

	return $basket_contents;
}

// MAKE HTML BASKET FOR FRONTEND
function make_html_basket($populated_basket)
{
	foreach (array_slice($populated_basket, 0, -1) as $item)
	{
		echo "<tr>";
		echo "<td>".$item['ref']."</td>";
		echo "<td>".$item['qty']."</td>";
		echo "<td>".$item['stamped']."<br><i>".$item['descr']."</i></td>";
		echo "<td>".$item['price']."</td>";
		echo "</tr>\n";
	}
}