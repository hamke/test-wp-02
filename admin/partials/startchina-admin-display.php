<?php
  if(!defined('ABSPATH')) exit;
  echo settings_errors();
?>
<div class="wrap">
  <h2><?php _e('StartChina', $this->text_domain); ?></h2>
  <p><?php _e('If your host is in china, you might need this plugin to make your website that running faster.', $this->text_domain); ?></p>

  <form method="post" action="options.php">

    <input type="hidden" name="startchina[update_plugins_roles_ids]" value="" />
    <input type="hidden" name="startchina[update_themes_roles_ids]" value="" />
    <input type="hidden" name="startchina[update_core_roles_ids]" value="" />
    <?php settings_fields( 'startchina_setting_group' ); ?>

    <ul id="qqworld-speed-4-china-tabs">
      <li class="current"><?php _e('Settings', $this->text_domain); ?></li>
      <li><?php _e('Contact', $this->text_domain); ?></li>
    </ul>

    <div class="tab-content">

      <h3><?php _e('Google Fonts', $this->text_domain); ?></h3>

      <table class="form-table">
        <tbody>
          <tr valign="top">
            <th scope="row">
              <label for="use-360-cdn"><?php _e('Front-End', $this->text_domain); ?></label>
            </th>
            <td>
              <aside class="admin_box_unit">
                <select name="startchina[google-font][frontend][type]" id="gravatar-service">
                  <option id="use-custom-cdn-yes" value="enabled" <?php selected($this->google_font_frontend_type, 'enabled'); ?>>
                    <?php _e('Enabled', $this->text_domain);_e('(Speed up)', $this->text_domain); ?>
                  </option>
                  <option id="use-custom-cdn-no" value="disabled" <?php selected($this->google_font_frontend_type, 'disabled'); ?>>
                    <?php _e('Disabled', $this->text_domain); ?>
                  </option>
                  <option id="use-custom-cdn-delete" value="delete" <?php selected($this->google_font_frontend_type, 'delete'); ?>>
                    <?php _e('Delete Google Font', $this->text_domain); ?>
                  </option>
                </select>
              </aside>
            </td>
          </tr>
          <tr valign="top">
            <th scope="row">
              <label for="use-google-fonts"><?php _e('Admin Page', $this->text_domain); ?></label>
            </th>
            <td>
              <aside class="admin_box_unit">
                <select name="startchina[google-font][backend][type]" id="gravatar-service">
                  <option id="use-custom-cdn-yes" value="enabled" <?php selected($this->google_font_backend_type, 'enabled'); ?>>
                    <?php _e('Enabled', $this->text_domain);_e('(Speed up)', $this->text_domain); ?>
                  </option>
                  <option id="use-custom-cdn-no" value="disabled" <?php selected($this->google_font_backend_type, 'disabled'); ?>>
                    <?php _e('Disabled', $this->text_domain); ?>
                  </option>
                  <option id="use-custom-cdn-delete" value="delete" <?php selected($this->google_font_backend_type, 'delete'); ?>>
                    <?php _e('Delete Google Font', $this->text_domain); ?>
                  </option>
                </select>
              </aside>
            </td>
          </tr>
        </tbody>
      </table>

      <h3><?php _e('Gravatar', $this->text_domain); ?></h3>

      <table class="form-table">
        <tbody>
          <tr valign="top">
            <th scope="row">
              <label for="using-gravatar"><?php _e('Using Gravatar', $this->text_domain); ?></label>
            </th>
            <td>
              <aside class="admin_box_unit">
                <select name="startchina[using-gravatar]" id="gravatar-service">
                  <option id="using-gravatar-yes" value="enabled" <?php selected($this->using_gravatar, 'enabled'); ?>>
                    <?php _e('Enabled', $this->text_domain); _e('(Slow)', $this->text_domain); ?>
                  </option>
                  <option id="using-gravatar-v2ex" value="v2ex" <?php selected($this->using_gravatar, 'v2ex'); ?>>
                    <?php _e('V2ex CDN', $this->text_domain); _e('(Speed up)', $this->text_domain); ?>
                  </option>
                  <option id="using-gravatar-no" value="disabled" <?php selected($this->using_gravatar, 'disabled'); ?>>
                    <?php _e('Disabled', $this->text_domain); _e('(Speed up)', $this->text_domain); ?>
                  </option>
                </select>
              </aside>
            </td>
          </tr>
          <tr valign="top" id="local-avatar-row"<?php if ($this->using_gravatar == 'enabled') echo ' class="hidden"'; ?>>
            <th scope="row">
              <label for="local-avatar">
                <?php _e('Local Avatar', $this->text_domain); ?>
              </label>
            </th>
            <td>
              <aside class="admin_box_unit">
                <?php
                if ( is_numeric($this->local_avatar) ) {
                  $id = $this->local_avatar;
                  $url = wp_get_attachment_url( $id );
                } else {
                  $id = '';
                  $url = $this->local_avatar;
                }
                ?>
                <div id="local-avatar">
                  <img src="<?php echo $url; ?>" width="80" height="80" default-avatar="<?php echo $this->default_avatar; ?>" title="<?php _e('Insert Avatar', $this->text_domain);?>" />
                </div>
                <input type="hidden" id="upload-avatar" name="startchina[local-avatar]" value="<?php echo $this->local_avatar; ?>" />
                <input type="button" class="button<?php if ( !is_numeric($this->local_avatar) ) echo ' hidden'; ?>" id="using-default-avatar" value="<?php _e('Using Default Avatar', $this->text_domain); ?>" />
              </aside>
            </td>
          </tr>
        </tbody>
      </table>

      <h3><?php _e('Emoji', $this->text_domain); ?></h3>

      <table class="form-table">
        <tbody>
          <tr valign="top">
            <th scope="row">
              <label for="disable-emoji"><?php _e('Using Emoji', $this->text_domain); ?></label>
            </th>
            <td>
              <aside class="admin_box_unit">
                <select name="startchina[disable-emoji]" id="gravatar-service">
                  <option id="enable-emoji" value="yes" <?php selected($this->disable_emoji, 'yes'); ?>>
                    <?php _e('Enabled', $this->text_domain); _e('(Slow)', $this->text_domain); ?>
                  </option>
                  <option id="disable-emoji" value="no" <?php selected($this->disable_emoji, 'no'); ?>>
                    <?php _e('Disabled', $this->text_domain); _e('(Speed up)', $this->text_domain); ?>
                  </option>
                </select>
              </aside>
            </td>
          </tr>
        </tbody>
      </table>

      <h3><?php _e('Upgrade', $this->text_domain); ?></h3>

      <p><?php _e("If you want to update, don't forget temporarily enable these options.", $this->text_domain); ?></p>

      <table class="form-table">
        <tbody>
          <tr valign="top">
            <th scope="row">
              <label for="auto-update-core"><?php _e('Auto Update Core', $this->text_domain); ?></label>
            </th>
            <td>
              <aside class="admin_box_unit">
                <select name="startchina[auto-update-core]" id="gravatar-service">
                  <option id="auto-update-core-yes" value="enabled" <?php selected($this->auto_update_core, 'enabled'); ?>>
                    <?php _e('Enabled', $this->text_domain); _e('(Slow)', $this->text_domain);?>
                  </option>
                  <option id="auto-update-core-no" value="disabled" <?php selected($this->auto_update_core, 'disabled'); ?>>
                    <?php _e('Disabled', $this->text_domain);_e('(Speed up)', $this->text_domain); ?>
                  </option>
                </select>
              </aside>
            </td>
          </tr>
          <tr valign="top">
            <th scope="row">
              <label for="auto-update-plugins"><?php _e('Auto Update Plugins', $this->text_domain); ?></label>
            </th>
            <td>
              <aside class="admin_box_unit">
                <select name="startchina[auto-update-plugins]" id="gravatar-service">
                  <option id="auto-update-plugins-yes" value="enabled" <?php selected($this->auto_update_plugins, 'enabled'); ?>>
                    <?php _e('Enabled', $this->text_domain); _e('(Slow)', $this->text_domain);?>
                  </option>
                  <option id="auto-update-plugins-no" value="disabled" <?php selected($this->auto_update_plugins, 'disabled'); ?>>
                    <?php _e('Disabled', $this->text_domain);_e('(Speed up)', $this->text_domain); ?>
                  </option>
                </select>
              </aside>
            </td>
          </tr>
          <tr valign="top">
            <th scope="row">
              <label for="auto-update-themes"><?php _e('Auto Update Themes', $this->text_domain); ?></label>
            </th>
            <td>
              <aside class="admin_box_unit">
                <select name="startchina[auto-update-themes]" id="gravatar-service">
                  <option id="auto-update-themes-yes" value="enabled" <?php selected($this->auto_update_themes, 'enabled'); ?>>
                    <?php _e('Enabled', $this->text_domain); _e('(Slow)', $this->text_domain);?>
                  </option>
                  <option id="auto-update-themes-no" value="disabled" <?php selected($this->auto_update_themes, 'disabled'); ?>>
                    <?php _e('Disabled', $this->text_domain);_e('(Speed up)', $this->text_domain); ?>
                  </option>
                </select>
              </aside>
            </td>
          </tr>
          <tr valign="top">
            <th scope="row">
              <label for="auto-update-themes"><?php _e('Advanced Speed Up', $this->text_domain); ?></label>
            </th>
            <td>
              <aside class="admin_box_unit">
                <select name="startchina[advanced-speed-up]" id="gravatar-service">
                  <option id="advanced-speed-up-yes" value="enabled" <?php selected($this->advanced_speed_up, 'enabled'); ?>>
                    <?php _e('Enabled', $this->text_domain);_e('(Speed up)', $this->text_domain); ?>
                  </option>
                  <option id="advanced-speed-up-no" value="disabled" <?php selected($this->advanced_speed_up, 'disabled'); ?>>
                    <?php _e('Disabled', $this->text_domain); ?>
                  </option>
                </select>
              </aside>
              <p class="description"><?php _e('If enabled this option, all update action will be disabled.', $this->text_domain); ?></p>
            </td>
          </tr>
          <tr valign="top">
            <th scope="row">
              <label for="auto-update-themes"><?php _e('Extend the Time of the Upgrade', $this->text_domain); ?></label>
            </th>
            <td>
              <aside class="admin_box_unit">
                <select name="startchina[extend-the-time-of-the-upgrade]" id="gravatar-service">
                  <option id="extend-the-time-of-the-upgrade-yes" value="enabled" <?php selected($this->extend_the_time_of_the_upgrade, 'enabled'); ?>>
                    <?php _e('Enabled', $this->text_domain); ?>
                  </option>
                  <option id="extend-the-time-of-the-upgrade-no" value="disabled" <?php selected($this->extend_the_time_of_the_upgrade, 'disabled'); ?>>
                    <?php _e('Disabled', $this->text_domain); ?>
                  </option>
                </select>
              </aside>
              <p class="description"><?php _e('If enabled this option, will never timeout when upgrading.', $this->text_domain); ?></p>
            </td>
          </tr>
        </tbody>
      </table>
    </div> <!-- .tab-content -->

    <!-- Contact -->
    <div class="tab-content hidden">
      <div class="">
        <img src="https://hellotblog.files.wordpress.com/2018/06/startchina-cover-01-800x400.png" alt="" style="width:300px;margin:0 auto;">
        <p>
          <a href="https://news.wp-talk.com/china-website-loading-speed-slow/" target="_blank">
            [참고] 중국에서 웹사이트/쇼핑몰에 접속할 때 로딩 속도가 느려지는 이유
          </a>
        </p>
      </div>
    </div> <!-- .tab-content -->

    <?php submit_button(); ?>

  </form>

</div>
