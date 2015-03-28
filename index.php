<?php
/*
Plugin Name: Yes Equality Support Ribbon
Description: This plugin allows you to add a 'I support YES Equality' ribbon to your site with a few simple clicks
Version: 1.0

I'm sorry for whomever wants to maintain this code because it really is god awful
*/

function insert_my_footer() {
  $yer_position = get_option('yer_position', 'top_left');
  $yer_type = get_option('yer_type', 'camo');

  if (strpos($yer_position, 'left') !== FALSE) {
    $x_direction = "left";
  } else {
    $x_direction = "right";
  }

  if (strpos($yer_position, 'top') !== FALSE) {
    $y_direction = "top";
  } else {
    $y_direction = "top";
  }

  $image_url = plugins_url('images/'. $yer_type . '_' . $yer_position . '.png', __FILE__);

  echo '<a href="http://www.yesequality.ie"><img style="position: absolute; ' . $y_direction . ': 0; ' . $x_direction . ': 0; border: 0; z-index: 99999" src="' . $image_url . '" alt="We Support Marriage Equality!"></a>';
}

add_action('wp_footer', 'insert_my_footer');


/* Wordpress Plugin Admin Page */
add_action('admin_menu', 'my_plugin_menu');

function my_plugin_menu() {
  add_options_page('Yes Equality Ribbon', 'Yes Equality Ribbon', 'manage_options', 'yes-equality-options', 'my_plugin_options');

  add_action('admin_init', 'register_yer_settings');
}

function register_yer_settings() {
  register_setting('yer-settings-group', 'yer_position');
  register_setting('yer-settings-group', 'yer_type');
}

function my_plugin_options() {
  if ( !current_user_can( 'manage_options' ) )  {
    wp_die( __('You do not have sufficient permissions to access this page.') );
  }

  $yer_position = esc_attr( get_option('yer_position', 'top_left') );
  $yer_type = esc_attr( get_option('yer_type', 'camo') );

?>
  
  <div class="wrap">
    <h2>Yes Equality Ribbon Options</h2>
    <p>Here you can choose what kind of Yes Equality Ribbon you want to add to your website.</p>
    <form method="post" action="options.php">
      <?php
        settings_fields('yer-settings-group');
      ?>
      <table class="form-table" width="100%" cellpadding="10">
        <tbody>
          <tr>
            <td scope="row" align="left">
              <label>Position (<?php echo $yer_position ?>)</label>
              <select name="yer_position" id="yer-position">
                <option value="top_left" <?php echo ($yer_position == 'top_left') ? 'selected' : '' ?>>Top Left</option>
                <option value="top_right" <?php echo ($yer_position == 'top_right') ? 'selected' : '' ?>>Top Right</option>
                <option value="bottom_left" <?php echo ($yer_position == 'bottom_left') ? 'selected' : '' ?>>Bottom Left</option>
                <option value="bottom_right" <?php echo ($yer_position == 'bottom_right') ? 'selected' : '' ?>>Bottom Right</option>
              </select>
            </td>
          </tr>
          <tr>
            <td scope="row" align="left">
              <label>Style (<?php echo $yer_type ?>)</label>
              <select name="yer_type" id="yer-type">
                <option value="camo" <?php echo ($yer_type == 'camo') ? 'selected' : '' ?>>Colored</option>
                <option value="white" <?php echo ($yer_type == 'white') ? 'selected' : '' ?>>White</option>
              </select>
            </td>
          </tr>
        </tbody>
      </table>

      <?php submit_button(); ?>
    </form>

    <h3>Preview</h3>
    <div id="yer-preview"></div>
  </div>

  <script>
    jQuery(document).ready(function() {
      var position = "<?php echo $yer_position ?>";
      var type = "<?php echo $yer_type ?>";

      var positionInput = jQuery("#yer-position");
      var typeInput = jQuery("#yer-type");

      positionInput.change(function() {
        position = jQuery(this).val();

        displayPreview();
      });

      typeInput.change(function() {
        type = jQuery(this).val();

        displayPreview();
      });

      displayPreview = function() {
        jQuery("#yer-preview").html('<img src="http://hackforequality.github.io/ribbon/img/' + type + '_' + position + '.png" />');
      };

      displayPreview();
    });
  </script>

  <?php
}
?>