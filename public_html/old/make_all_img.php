<?php 

// include composer autoload
require '../vendor/autoload.php';

// import the Intervention Image Manager Class
use Intervention\Image\ImageManager;

// create an image manager instance with favored driver
$manager = new ImageManager(array('driver' => 'gd'));

// to finally create image instances


if ($handle = opendir('pictures/cutlery/500px'))
{
	while (false !== ($entry = readdir($handle)))
	{
		if (pathinfo($entry, PATHINFO_EXTENSION) == 'jpg')
		{
			// echo $entry.'<br>';
			$filename = substr($entry, 0, -4);

			
			$img_path_100px = 'pictures/cutlery/100px';
			$image = $manager->make('pictures/cutlery/500px/'.$entry)->resize(100, 100)->save($img_path_100px.'/'.$filename.'_thumb.jpg');
			
		}
		
	}
	closedir($handle);
}


/*

// paths
			// $img_path_original = 'pictures/'.$section.'/originals';
			// $img_path_500px = 'pictures/'.$section.'/500px';


for($i=0 ; $i<=$imgs_count-1 ; $i++)
{
	
}*/