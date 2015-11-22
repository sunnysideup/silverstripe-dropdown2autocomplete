<?php

/**
 * just like a ListboxField but now with an autocomplete
 * system baked into it.
 *
 *
 */
  
class Listbox2AutocompleteField extends ListboxField {

	/**
	 * @var boolean
	 */ 
	private $autocomplete = true;

	/**
	 *
	 * @return $this
	 */ 
	function turnOnAutocomplete() {
		$this->autocomplete = true;
		return $this;
	}

	/**
	 *
	 * @return $this
	 */ 
	function turnOffAutocomplete() {
		$this->autocomplete = false;
		return $this;
	}

	/**
	 * @param array $parameters
	 * @return string
	 */ 
	function Field($parameters = array()) {
		$field = parent::Field($parameters);
		if($this->autocomplete) {
			Requirements::css("dropdown2autodropdown/javascript/chosen/chosen.min.css");
			Requirements::javascript(THIRDPARTY_DIR . '/jquery/jquery.js');
			Requirements::javascript("dropdown2autodropdown/javascript/chosen/chosen.jquery.min.js");
			Requirements::customScript('jQuery("#'.$this->ID().'").chosen();', $this->ID()."_chosen_setup");
		}
		return $field;
		
	}

}
