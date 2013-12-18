<?php
class DateCustomFieldType extends AdminPageFramework_CustomFieldType {
		
	/**
	 * Returns the array of the field type specific default keys.
	 */
	protected function getDefaultKeys() { 
		return array(
			'vSize'					=> 10,
			'vDateFormat'	 		=> 'yy/mm/dd',				// ( array or string ) This is for the date field type that specifies the date format.
			'vMaxLength'			=> 400,
		);	
	}

	/**
	 * Loads the field type necessary components.
	 */ 
	public function replyToFieldLoader() {
		wp_enqueue_script( 'jquery-ui-datepicker' );
	}	
	
	/**
	 * Returns an array holding the urls of enqueuing scripts.
	 */
	// protected function getEnqueuingScripts() { 
		// return array(
		// );
	// }	

	/**
	 * Returns an array holding the urls of enqueuing styles.
	 */
	protected function getEnqueuingStyles() { 
		return array(
			dirname( __FILE__ ) . '/css/jquery-ui-1.10.3.min.css',
		); 
	}	
	
	/**
	 * Returns the field type specific JavaScript script.
	 */ 
	public function replyToGetInputScripts() {
		return "";		
	}	

	/**
	 * Returns the field type specific CSS rules.
	 */ 
	public function replyToGetInputStyles() {
		return "
		/* Date Picker */
		.ui-datepicker.ui-widget.ui-widget-content.ui-helper-clearfix.ui-corner-all {
			display: none;
		}		
		" . PHP_EOL;		
	}

	/**
	 * Returns the field type specific CSS rules.
	 */ 
	public function replyToGetInputIEStyles() {
		return "";		
	}
	
	/**
	 * Returns the output of the geometry custom field type.
	 * 
	 */
	public function replyToGetInputField( $vValue, $aField, $aOptions, $aErrors, $aFieldDefinition ) {

		$aOutput = array();
		$sFieldName = $aField['strFieldName'];
		$sTagID = $aField['strTagID'];
		$sFieldClassSelector = $aField['strFieldClassSelector'];
		$aDefaultKeys = $aFieldDefinition['arrDefaultKeys'];	
		
		$aFields = $aField['fRepeatable'] ? 
			( empty( $vValue ) ? array( '' ) : ( array ) $vValue )
			: $aField['vLabel'];		
		
		foreach( ( array ) $aFields as $sKey => $sLabel ) 
			$aOutput[] = 
				"<div class='{$sFieldClassSelector}' id='field-{$sTagID}_{$sKey}'>"
					. "<div class='admin-page-framework-input-label-container'>"
						. "<label for='{$sTagID}_{$sKey}'>"
							. $this->getCorrespondingArrayValue( $aField['vBeforeInputTag'], $sKey, $aDefaultKeys['vBeforeInputTag'] ) 
							. ( $sLabel && ! $aField['fRepeatable']
								? "<span class='admin-page-framework-input-label-string' style='min-width:" . $this->getCorrespondingArrayValue( $aField['vLabelMinWidth'], $sKey, $aDefaultKeys['vLabelMinWidth'] ) . "px;'>" . $sLabel . "</span>"
								: "" 
							)
							. "<input id='{$sTagID}_{$sKey}' "
								. "class='datepicker " . $this->getCorrespondingArrayValue( $aField['vClassAttribute'], $sKey, $aDefaultKeys['vClassAttribute'] ) . "' "
								. "size='" . $this->getCorrespondingArrayValue( $aField['vSize'], $sKey, $aDefaultKeys['vSize'] ) . "' "
								. "maxlength='" . $this->getCorrespondingArrayValue( $aField['vMaxLength'], $sKey, $aDefaultKeys['vMaxLength'] ) . "' "
								. "type='text' "	// text, password, etc.
								. "name=" . ( is_array( $aFields ) ? "'{$sFieldName}[{$sKey}]' " : "'{$sFieldName}' " )
								. "value='" . $this->getCorrespondingArrayValue( $vValue, $sKey, null ) . "' "
								. ( $this->getCorrespondingArrayValue( $aField['vDisable'], $sKey ) ? "disabled='Disabled' " : '' )
								. ( $this->getCorrespondingArrayValue( $aField['vReadOnly'], $sKey ) ? "readonly='readonly' " : '' )
							. "/>"
							. $this->getCorrespondingArrayValue( $aField['vAfterInputTag'], $sKey, $aDefaultKeys['vAfterInputTag'] )
						. "</label>"
					. "</div>"	// end of label container
					. $this->getDatePickerEnablerScript( "{$sTagID}_{$sKey}", $this->getCorrespondingArrayValue( $aField['vDateFormat'], $sKey, $aDefaultKeys['vDateFormat'] ) )
				. "</div>"	// end of admin-page-framework-field
				. ( ( $sDelimiter = $this->getCorrespondingArrayValue( $aField['vDelimiter'], $sKey, $aDefaultKeys['vDelimiter'], true ) )
					? "<div class='delimiter' id='delimiter-{$sTagID}_{$sKey}'>" . $sDelimiter . "</div>"
					: ""
				);
				
		return "<div class='admin-page-framework-field-date' id='{$sTagID}'>" 
				. implode( '', $aOutput ) 
			. "</div>";
		
	}	
		/**
		 * A helper function for the above replyToGetInputField() method.
		 * 
		 */
		private function getDatePickerEnablerScript( $sID, $sDateFormat ) {
			return 
				"<script type='text/javascript' class='date-picker-enabler-script' data-id='{$sID}' data-date_format='{$sDateFormat}'>
					jQuery( document ).ready( function() {
						jQuery( '#{$sID}' ).datepicker({
							dateFormat : '{$sDateFormat}'
						});
					});
				</script>";
		}

}