<?php
/**
 * Admin Page Framework
 * 
 * http://en.michaeluno.jp/admin-page-framework/
 * Copyright (c) 2013-2015 Michael Uno; Licensed MIT
 * 
 */

/**
 * Provides the space to store the shared properties.
 * 
 * This class stores various types of values. This is used to encapsulate properties so that it helps to avoid naming conflicts.
 * 
 * @since       2.0.0
 * @package     AdminPageFramework
 * @subpackage  Property
 * @extends     AdminPageFramework_Property_Base
 * @internal
 */
class AdminPageFramework_Property_Page extends AdminPageFramework_Property_Base {
    
    /**
     * Defines the property type.
     * @remark Setting the property type helps to check whether some components are loaded such as scripts that can be reused per a class type basis.
     * @since 3.0.0
     * @internal
     */
    public $_sPropertyType = 'page';
    
    /**
     * Defines the fields type.
     * 
     * @since 3.1.0
     */
    public $sFieldsType = 'page';
    
    /**
     * Stores framework's instantiated object name.
     * 
     * @since 2.0.0
     */ 
    public $sClassName;    
    
    /**
     * Stores the md5 hash string of framework's instantiated object name.
     * @since 2.1.1
     */
    public $sClassHash;
    
    /**
     * Stores the access level to the root page. 
     * 
     * When sub pages are added and the capability value is not provided, this will be applied.
     * 
     * @since 2.0.0
     */     
    public $sCapability = 'manage_options';    
    
    /**
     * Stores the tag for the page heading navigation bar.
     * @since 2.0.0
     */ 
    public $sPageHeadingTabTag = 'h2';

    /**
     * Stores the tag for the in-page tab navigation bar.
     * @since 2.0.0
     */ 
    public $sInPageTabTag = 'h3';
    
    /**
     * Stores the default page slug.
     * @since 2.0.0
     */     
    public $sDefaultPageSlug;
        
    // Container arrays.
    /**
     * A two-dimensional array storing registering sub-menu(page) item information with keys of the page slug.
     * @since 2.0.0
     */     
    public $aPages = array(); 

    /**
     * Stores the hidden page slugs.
     * @since 2.1.4
     */
    public $aHiddenPages = array();
    
    /**
     * Stores the registered sub menu pages.
     * 
     * Unlike the above $aPages that holds the pages to be added, this stores the added pages. This is referred when adding a help section.
     * 
     * @since 2.1.0
     */ 
    public $aRegisteredSubMenuPages = array();
    
    /**
     * Stores the root menu item information for one set root menu item.
     * @since 2.0.0
     */         
    public $aRootMenu = array(
        'sTitle'        => null, // menu label that appears on the menu list
        'sPageSlug'     => null, // menu slug that identifies the menu item
        'sIcon16x16'    => null, // the associated icon that appears beside the label on the list
        'iPosition'     => null, // determines the position of the menu
        'fCreateRoot'   => null, // indicates whether the framework should create the root menu or not.
    ); 
    
    /**
     * Stores in-page tabs.
     * @since 2.0.0
     */     
    public $aInPageTabs = array();     
    
    /**
     * Stores the default in-page tab.
     * @since 2.0.0
     */         
    public $aDefaultInPageTabs = array();     
        
    /**
     * Stores link text that is scheduled to be embedded in the plugin listing table's description column cell.
     * @since 2.0.0
     */             
    public $aPluginDescriptionLinks = array(); 

    /**
     * Stores link text that is scheduled to be embedded in the plugin listing table's title column cell.
     * @since 2.0.0
     */             
    public $aPluginTitleLinks = array();     
            
    // Settings API
    // public $aOptions; // Stores the framework's options. Do not even declare the property here because the __get() magic method needs to be triggered when it accessed for the first time.

    /**
     * The instantiated class name will be assigned in the constructor if the first parameter is not set.
     * @since 2.0.0
     */                 
    public $sOptionKey = '';     

    /**
     * Stores contextual help tabs.
     * @since 2.1.0
     */     
    public $aHelpTabs = array();
    
    /**
     * Set one of the followings: application/x-www-form-urlencoded, multipart/form-data, text/plain
     * @since 2.0.0
     */                     
    public $sFormEncType = 'multipart/form-data';    
    
    /**
     * Stores the label for for the "Insert to Post" button in the media uploader box.
     * @since 2.0.0
     * @internal
     */     
    public $sThickBoxButtonUseThis = '';
    
    // Flags    
    /**
     * Decides whether the setting form tag is rendered or not.    
     * 
     * This will be enabled when a settings section and a field is added.
     * @since 2.0.0
     */                         
    public $bEnableForm = false;     
    
    /**
     * Indicates whether the page title should be displayed.
     * @since 2.0.0
     */                         
    public $bShowPageTitle = true;    
    
    /**
     * Indicates whether the page heading tabs should be displayed.
     * @since 2.0.0
     * @remark Used by the setPageHeadingTabsVisibility() method.
     */     
    public $bShowPageHeadingTabs = true;

    /**
     * Indicates whether the in-page tabs should be displayed.
     * 
     * This sets globally among the script using the framework. 
     * 
     * @since 2.1.2
     * @remark Used by the setInPageTabsVisibility() method.
     */
    public $bShowInPageTabs = true;

    /**
     * Stores the set administration notices.
     * 
     * The index number will be incremented as a script is enqueued regardless a previously added enqueue item has been removed or not.
     * This is because this index number will be used for the style handle ID which is automatically generated.
     * @since 2.1.2
     */
    public $aAdminNotices = array();
    
    /**
     * Stores the disallowed query keys in the links generated by the main class of the framework.
     * 
     * @remark Currently this does not take effect on the meta box and post type classes of the framework.
     * @since 2.1.2
     */
    public $aDisallowedQueryKeys = array( 
        'settings-updated', 
        'confirmation',     // 3.3.0+
        'field_errors'      // 3.4.1+
    );
        
        
    /** 
     * Stores the target page redirected to when the user submit the form of the framework.
     * 
     * @since 3.1.0
     */
    public $sTargetFormPage = '';
     
     
    /**
     * Indicates whether the menu building procedure has been completed. 
     * 
     * @since 3.1.0
     * @internal
     */
    public $_bBuiltMenu = false; 
     
    /**
     * Indicates whether the form data should be automatically saved in the options table.
     * @since 3.1.0
     */ 
    public $_bDisableSavingOptions = false;
     
    /**
     * Stores added page hooks.
     * 
     * @since 3.1.2
     */ 
    public $aPageHooks = array();
     
    /**
     * Stores the wrapper element class attribute.
     * 
     * This allows users to set own class selector such as "wrap about-wrap" for About pages.
     * 
     * @since       3.5.0
     */ 
    public $sWrapperClassAttribute = 'wrap';
     
    /**
     * Constructs the instance of AdminPageFramework_Property_Page class object.
     * 
     * @remark      Used by the setInPageTabsVisibility() method.
     * @since       2.0.0
     * @since       2.1.5   The $oCaller parameter was added.
     * @return      void
     */ 
    public function __construct( $oCaller, $sCallerPath, $sClassName, $sOptionKey, $sCapability='manage_options', $sTextDomain='admin-page-framework' ) {
        
        parent::__construct( $oCaller, $sCallerPath, $sClassName, $sCapability, $sTextDomain, $this->sFieldsType );
        
        $this->sTargetFormPage          = $_SERVER['REQUEST_URI'];
        $this->sOptionKey               = $sOptionKey ? $sOptionKey : $sClassName;
        $this->_bDisableSavingOptions   = '' === $sOptionKey ? true : false;

        /* Store the page class objects in the global storage. These will be referred by the meta box class to determine if the passed page slug's screen ID (hook suffix). */
        $GLOBALS['aAdminPageFramework']['aPageClasses'] = isset( $GLOBALS['aAdminPageFramework']['aPageClasses'] ) && is_array( $GLOBALS['aAdminPageFramework']['aPageClasses'] )
            ? $GLOBALS['aAdminPageFramework']['aPageClasses']
            : array();
        $GLOBALS['aAdminPageFramework']['aPageClasses'][ $sClassName ] = $oCaller; // The meta box class for pages needs to access the object.
                
        // The capability for the settings. $this->sOptionKey is the part that is set in the settings_fields() function.
        // This prevents the "Cheatin' huh?" message.
        add_filter( "option_page_capability_{$this->sOptionKey}", array( $this, '_replyToGetCapability' ) );
        
    }
    
        /**
         * Checks whether the currently loading page is in one of the pages to which the framework can add pages.
         * 
         * @since 3.0.3
         * @internal
         */
        protected function _isAdminPage() {
            
            if ( ! is_admin() ) {
                return false;
            }
            return isset( $_GET['page'] );
            
        }    
    
    /**
     * Returns the option array.
     * 
     * @since       3.1.0
     * @since       3.3.0       Forced to return an array as it is possible that the options value get modified by third party scripts. 
     * @internal
     * @return      array       The options array.
     */
    protected function _getOptions() {
    
        $_aOptions = $this->oUtil->addAndApplyFilter( // Parameters: $oCallerObject, $sFilter, $vInput, $vArgs...
            $this->oCaller, // 3.4.1+ changed from $GLOBALS['aAdminPageFramework']['aPageClasses'][ $this->sClassName ], // the caller object
            'options_' . $this->sClassName, // options_{instantiated class name}
            $this->sOptionKey ? get_option( $this->sOptionKey, array() ) : array()
        );
// @todo examine whether it is appropriate to merge with $_aLastInput or it should be done in the getSavedOptions() factory method.
// It seems it is better to merge the last input array here because this method is only called once when the aOptions property is first accessed
// while getSavedOptions() method is called every time a field is processed for outputs.
// However, in getSavedOptions, also the last input array is merged when the 'confirmation' query key is set,
// that should be done here.
        $_aLastInput = isset( $_GET['field_errors'] ) && $_GET['field_errors'] ? $this->_getLastInput() : array();
        $_aOptions   = $_aLastInput + $this->oUtil->getAsArray( $_aOptions );
        return $_aOptions;
    }
        
    /*
     * Magic methods
     * */
    /**
     * 
     * @since       3.2.0       Removed the ampersand prepended in the method name.
     * @since       3.4.1       Deprecated
     * @deprecated
     */
/*     public function __get( $sName ) {
                        
        // For regular undefined items, 
        return parent::__get( $sName );
        
    } */
    
    /*
     * Utility methods
     * */
     
    /**
     * Saves the options into the database.
     * 
     * @since       3.1.0
     * @since       3.1.1       Made it return a value.
     * @return      boolean     True if saved; otherwise, false.
     */
    public function updateOption( $aOptions=null ) {

        if ( $this->_bDisableSavingOptions ) {
            return;
        }
    
        return update_option( 
            $this->sOptionKey, 
            null !== $aOptions
                ? $aOptions 
                : $this->aOptions 
        );
        
    }
    
    
    /**
     * Checks if the given page slug is one of the pages added by the framework.
     * @since       2.0.0
     * @since       2.1.0       Set the default value to the parameter and if the parameter value is empty, it applies the current $_GET['page'] value.
     * @return      boolean      Returns true if it is of framework's added page; otherwise, false.
     */
    public function isPageAdded( $sPageSlug='' ) {    
        
        $sPageSlug = trim( $sPageSlug );
        $sPageSlug = $sPageSlug 
            ? $sPageSlug 
            : $this->getCurrentPageSlug();
        return isset( $this->aPages[ $sPageSlug ] );

    }
    
    /**
     * Retrieves the currently loading page slug.
     * 
     * @since       3.5.3
     * @return      string      The found page slug. An empty string if not found.
     * @remark      Do not return `null` when not found as some framework methods check the retuened value with `isset()` and if null is given, `isset()` yields `false` while it does `true` for an emtpy string ('').
     */
    public function getCurrentPageSlug() {
        return $this->oUtil->getElement( 
            $_GET,  // subject array
            'page', // key
            ''      // default
        );            
    }

    /**
     * Retrieves the currently loading tab slug.
     * 
     * The tricky part is that even no tab is set in the $_GET array, it's possible that it could be the default tab of the loading page.
     * This method checks that.
     * 
     * @since       3.0.0
     * @since       3.5.0       Added the `$sCurrentPageSlug` parameter because the page-meta-box class determines the caller factory object by page slug.
     * @since       3.5.3       Changed the name from 'getCurrentTab()' to be more specific.
     * @return      string      The found tab slug. An empty string if not found.
     * @remark      Do not return `null` when not found as some framework methods check the returned value with `isset()` and if null is given, `isset()` yields `false` while it does `true` for an empty string ('').
     */    
    public function getCurrentTabSlug( $sCurrentPageSlug='' ) {
        
        if ( isset( $_GET['tab'] ) && $_GET['tab'] ) { 
            return $_GET['tab'];
        }
        $sCurrentPageSlug = $sCurrentPageSlug
            ? $sCurrentPageSlug
            : $this->getCurrentPageSlug();
        return $sCurrentPageSlug
            ? $this->getDefaultInPageTab( $sCurrentPageSlug )
            : '';
            
    }    
        /**
         * An alias of getCurrentTabSlug();
         * 
         * @deprecated  3.5.3
         */
        public function getCurrentTab( $sCurrentPageSlug='' ) {
            return $this->getCurrentTabSlug( $sCurrentPageSlug );            
        }
    
    /**
     * Retrieves the default in-page tab from the given tab slug.
     * 
     * @since 2.0.0
     * @since 2.1.5 Made it public and moved from the AdminPageFramework_Page class since this method is used by the AdminPageFramework_HeadTab class as well.
     * @internal
     * @remark Used in the __call() method in the main class.
     * @return string The default in-page tab slug if found; otherwise, an empty string.
     */         
    public function getDefaultInPageTab( $sPageSlug ) {
    
        if ( ! $sPageSlug ) { 
            return ''; 
        }
        return $this->oUtil->getElement( 
            $this->aDefaultInPageTabs,  // subject array
            $sPageSlug, // key
            ''    // default
        );
        
    }    
        
    /**
     * Returns the default values of all the added fields.
     * 
     * @since 3.0.0
     */
    public function getDefaultOptions( $aFields ) {
        
        $_aDefaultOptions = array();
        foreach( $aFields as $_sSectionID => $_aFields  ) {
            
            foreach( $_aFields as $_sFieldID => $_aField ) {
                
                $_vDefault = $this->_getDefautValue( $_aField );
                
                if ( isset( $_aField['section_id'] ) && $_aField['section_id'] != '_default' ) {
                    $_aDefaultOptions[ $_aField['section_id'] ][ $_sFieldID ] = $_vDefault;
                } else {
                    $_aDefaultOptions[ $_sFieldID ] = $_vDefault;
                }
                    
            }
                
        }     
        
        return $_aDefaultOptions;     
        
    }
        /**
         * Returns the default value from the given field definition array.
         * 
         * This is a helper function for the above getDefaultOptions() method.
         * 
         * @since 3.0.0
         */
        private function _getDefautValue( $aField ) {
            
            // Check if sub-fields exist whose keys are numeric
            $_aSubFields = $this->oUtil->getIntegerKeyElements( $aField );

            // If there are no sub-fields     
            if ( count( $_aSubFields ) == 0 ) {
                return $this->oUtil->getElement(
                    $aField,   // subject
                    'value',    // key
                    $this->oUtil->getElement(   // default value
                        $aField,   // subject  
                        'default',  // key
                        null        // default value
                    )
                );
            }
            
            // Otherwise, there are sub-fields
            $_aDefault = array();
            array_unshift( $_aSubFields, $aField ); // insert the main field into the very first index.
            foreach( $_aSubFields as $_iIndex => $_aField ) {
                $_aDefault[ $_iIndex ] = $this->oUtil->getElement( 
                    $_aField,   // subject
                    'value',    // key
                    $this->oUtil->getElement(   // default value
                        $_aField,   // subject  
                        'default',  // key
                        null        // default value
                    )
                ); 
            }
            return $_aDefault;
            
        }
    
    /**
     * Returns the set capability.
     * @callback        option_page_capability_{$this->sOptionKey}
     */ 
    public function _replyToGetCapability() {
        return $this->sCapability;
    }
        
}