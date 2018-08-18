<?php

namespace App\Team\Helpers;

use App\Project;

class ColorsHelper {
	
	private static $colors = [
		// yellowish
		'ED6A5A',
		'FFD166',
		// greenish 
		'C1EDCC',
		'B0C0BC',
		// bluish
		'9BC1BC',
		'5CA4A9',
		'9DD1F1',		
		'2F97C1',
		// purplish
		'9984D4',
		'7D869C',
		// redish 
		'EF476F',
		// pinkish 
		'E3C0D3',
		'95818D',
	];

	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

	/**
     * Suggest unused
     *
     * @return void
     */
    public function suggest()
    {
        $used = Project::select('color')->distinct('color')->get();
        $unused = array_diff($this->colors, $used);
        return $unused;
    }
	
	public static function display() {
		
		$colors = self::$colors;
		
		?>
		<div class="tat-g bottom-1-2">
			<?php 
			foreach ($colors as $color) {
				?>
				<i class="swatch tat-f-0-0" style="background-color: #<?php echo $color; ?>;"></i>
				<?php 
			}
			?>
		</div>
		<?php 
		
	}
	
	public static function isDark($hex) {
		list($r, $g, $b) = sscanf($hex, "%02x%02x%02x");
		$lightness = (max($r, $r, $b) + min($r, $g, $b)) / 510.0;
		if ($lightness<0.5) {
			return true;
		} else {
			return false;
		}
	}

}