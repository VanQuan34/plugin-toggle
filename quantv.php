<?php
    /*
    Plugin Name: myplug
    Version: 0.1
    Plugin URI: http://myplug.org
    Author: ME
    Description: Stupid plugin
     */
class DropdownOptionSetting {
    private $dropdown_option_setting_options;

    public function __construct() {
        add_action( 'admin_menu', array( $this, 'dropdown_option_setting_add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'dropdown_option_setting_page_init' ) );
        add_action( 'wp_head', array($this, 'callback_header'));
    }

    public function dropdown_option_setting_add_plugin_page() {
        add_options_page(
            'Dropdown Option Setting', // page_title
            'Dropdown Option Setting', // menu_title
            'manage_options', // capability
            'dropdown-option-setting', // menu_slug
            array( $this, 'dropdown_option_setting_create_admin_page' ) // function
        );
    }

    public function dropdown_option_setting_create_admin_page() {
        $this->dropdown_option_setting_options = get_option( 'dropdown_option_setting_option_name' ); ?>

        <div class="wrap">
            <h2>Dropdown Option Setting</h2>
            <p></p>
            <form method="post" action="options.php">
                <?php
                    settings_fields( 'dropdown_option_setting_option_group' );
                    do_settings_sections( 'dropdown-option-setting-admin' );
                    submit_button();
                ?>
            </form>
        </div>
    <?php }

    public function dropdown_option_setting_page_init() {
        register_setting(
            'dropdown_option_setting_option_group', // option_group
            'dropdown_option_setting_option_name', // option_name
            array( $this, 'dropdown_option_setting_sanitize' ) // sanitize_callback
        );

        add_settings_section(
            'dropdown_option_setting_setting_section', // id
            'Settings', // title
            array( $this, 'dropdown_option_setting_section_info' ), // callback
            'dropdown-option-setting-admin' // page
        );

        add_settings_field(
            'dropdown_option_0', // id
            'Dropdown Option', // title
            array( $this, 'dropdown_option_0_callback' ), // callback
            'dropdown-option-setting-admin', // page
            'dropdown_option_setting_setting_section' // section
        );
    }

    public function dropdown_option_setting_sanitize($input) {
        $sanitary_values = array();
        if ( isset( $input['dropdown_option_0'] ) ) {
            $sanitary_values['dropdown_option_0'] = $input['dropdown_option_0'];
        }
        if ( isset( $input['field_name'] ) ) {
            $sanitary_values['field_name'] = $input['field_name'];
        }

        return $sanitary_values;
    }

    public function dropdown_option_setting_section_info() {

    }

    public function dropdown_option_0_callback() {
        ?> 

<input type="checkbox" class="wppd-ui-toggle" id="field-id" name="dropdown_option_setting_option_name[dropdown_option_0]" value="1" <?php echo $this->dropdown_option_setting_options['dropdown_option_0'] === '1' ? 'checked' : '' ; ?> >
<label for="field-id">Enable this option</label>
        <?php
    }
public function callback_header(){
$dropdown_option = get_option( 'dropdown_option_setting_option_name' ); 
 $dropdown_value =  $dropdown_option ['dropdown_option_0']; 

    if($dropdown_value == 1){
        echo '<script>document.documentElement.className = document.documentElement.className.replace( "no-js", "js" )</script>';
    }
}
}
$dropdown_option_setting = new DropdownOptionSetting();

