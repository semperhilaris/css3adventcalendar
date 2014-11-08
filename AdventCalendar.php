<?php

class AdventCalendar {
	
	private $calendarWidth;
	private $calendarHeight;
	private $entries;
	
	/**
	 * @param array $config 
	 */
	function __construct($config = array()) {
		$this->set_config($config);
	}
	
	/**
	 * Sets the config variables.
	 * @param array $config
	 */
	public function set_config($config) {
		$this->calendarWidth = $config['calendarWidth'] ? $config['calendarWidth'] : "500px";
		$this->calendarHeight = $config['calendarHeight'] ? $config['calendarHeight'] : "840px";
	}
	
	/**
	 * Adds a new entry to the calendar.
	 * @param array $entry
	 */
	public function set_entry($entry) {
		if ($this->validate_entry($entry)) {
			$this->entries[] = $entry;
		}
	}
	
	/**
	 * Checks if an entry can be added to the calendar.
	 * @param array $entry
	 */
	public function validate_entry($entry) {
		if (
			!array_key_exists('unlockDate', $entry) ||
			!array_key_exists('positionTop', $entry) ||
			!array_key_exists('positionLeft', $entry) ||
			(!array_key_exists('doorImageLeft', $entry) && !array_key_exists('doorImageRight', $entry)) ||
			!array_key_exists('url', $entry)
		) {
			return false;
		}
		return true;
	}
	
	/**
	 * Loads a calendar from a json string.
	 * @param string $json
	 */
	public function load_from_json($json) {
		$data = json_decode($json, true);
		$this->set_config($data['config']);
		foreach ($data['entries'] as $entry) {
			$this->set_entry($entry);
		}
	}
	
	/**
	 * Renders the HTML for the calendar.
	 * @param boolean $return if set to TRUE, returns the output rather than print it.
	 */
	public function render($return = false) {
		$now = time();
		$output = "";
		
		$output .= '<div class="advent-calendar" style="width:'.$this->calendarWidth.'px;height:'.$this->calendarHeight.'px;">';
		foreach ($this->entries as $entry) {
			if ($entry['doorImageLeft'] && $entry['doorImageRight']) {
				$totalwidth = $entry['doorWidth'] * 2;
			} else {
				$totalwidth = $entry['doorWidth'];
			}
			if (time() >= strtotime($entry['unlockDate'])) {
				$output .= '<a href="'.$entry['url'].'" class="advent-calendar-entry" style="width:'.$totalwidth.'px;top:'.$entry['positionTop'].'px;left:'.$entry['positionLeft'].'px;">';
				if ($entry['backgroundImage']) {
					$output .= '<img class="advent-calendar-background" src="'.$entry['backgroundImage'].'" alt="" />';
				}
				if ($entry['doorImageLeft']) {
					$output .= '<div class="advent-calendar-door-left-wrapper"><img class="advent-calendar-door" src="'.$entry['doorImageLeft'].'" alt="" /></div>';
				} 
				if ($entry['doorImageRight']) {
					$output .= '<div class="advent-calendar-door-right-wrapper"><img class="advent-calendar-door" src="'.$entry['doorImageRight'].'" alt="" /></div>';
				}
				$output .= '</a>';
			} else {
				$output .= '<div class="advent-calendar-entry" style="width:'.$totalwidth.'px;top:'.$entry['positionTop'].'px;left:'.$entry['positionLeft'].'px;">';
				if ($entry['doorImageLeft']) {
					$output .= '<div class="advent-calendar-door-left-wrapper"><img class="advent-calendar-door" src="'.$entry['doorImageLeft'].'" alt="" /></div>';
				} 
				if ($entry['doorImageRight']) {
					$output .= '<div class="advent-calendar-door-right-wrapper"><img class="advent-calendar-door" src="'.$entry['doorImageRight'].'" alt="" /></div>';				
				}
				$output .= '</div>';
			}
		}
		$output .= '</div>';
		
		if ($return) {
			return $output;
		} else {
			print $output;
		}
	}
	
}