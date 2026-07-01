<?php

namespace Sunnysideup\Dropdown2Autocomplete\Forms;

use Override;
use SilverStripe\Forms\ListboxField;
use SilverStripe\View\Requirements;

/**
 * just like a ListboxField but now with an autocomplete
 * system baked into it.
 */
class Listbox2AutocompleteField extends ListboxField
{
    /**
     * @var bool
     */
    private $autocomplete = true;

    /**
     * @return $this
     */
    public function turnOnAutocomplete()
    {
        $this->autocomplete = true;

        return $this;
    }

    /**
     * @return $this
     */
    public function turnOffAutocomplete()
    {
        $this->autocomplete = false;

        return $this;
    }

    /**
     * @param array $parameters
     *
     * @return string
     */
    #[Override]
    public function Field($parameters = [])
    {
        $field = parent::Field($parameters);
        if ($this->autocomplete) {
            $this->addExtraClass('chosenAutocompleteField');
            $field = parent::Field($parameters);
            Requirements::css('sunnysideup/dropdown2autocomplete: client/javascript/chosen/chosen.min.css');
            Requirements::javascript('https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js');
            Requirements::javascript('sunnysideup/dropdown2autocomplete: client/javascript/chosen/chosen.jquery.min.js');
            Requirements::customScript(
                '
                    jQuery("#' . $this->ID() . '").chosen(' . $this->Config()->get('js_settings') . ');
                    jQuery("body").on(
                        "focus",
                        ".chosenAutocompleteField:visible",
                        function(){
                            jQuery(this).chosen(' . $this->Config()->get('js_settings') . ');
                        }
                    );
                ',
                $this->ID() . '_chosen_setup'
            );
        }

        return $field;
    }
}
