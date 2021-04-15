<?php

/**
 * @author  : Sidi Said Redouane <sidisaidredouane@live.com>
 * @agency  : EURL ARVODIA
 * @email   : arvodia@hotmail.com
 * @project : Webfony
 * @date    : 2021
 * @license : tous droits réservés
 * @update  : 15 avr. 2021
 */

namespace Drupal\arvodia\scripts;

use Composer\Script\Event;
use Drupal\Component\Utility\Crypt;
use Drupal\Core\Site\Settings;
use function drupal_rewrite_settings;

/**
 * Description
 * 
 * @name    : Composer
 * @see     : 
 * @todo    : 
 *
 * @author Sidi Said Redouane <sidisaidredouane@live.com>
 */
class Composer {

    /**
     * 
     * @param Event $event
     */
    public static function postInstall(Event $event) {
        $composer = $event->getComposer();
        $drupalRoot = realpath($composer->getPackage()->getExtra()['drupal-scaffold']['locations']['web-root']);
        $defaultPath = $drupalRoot . '/sites/default';
        $sync = 'sync' . Crypt::randomBytesBase64(64);
        //------Prepare Folders
        $dirs = [
            // files
            $defaultPath . '/files' => 0777,
            $defaultPath . '/files/src' => 0777,
            $defaultPath . '/files/translations' => 0777,
            // sync
            $defaultPath . '/config' => 0777, //0755
            $defaultPath . '/config/' . $sync => 0777, //0755
            // SQLITE
            $defaultPath . '/data' => 0777,
            // private
            $defaultPath . '/private' => 0777,
        ];
        $oldmask = umask(0);
        foreach ($dirs as $dir => $chmod) {
            if (!file_exists($dir)) {
                mkdir($dir, $chmod);
            }
        }
        umask($oldmask);
        // Prepare the settings file for installation
        if (!file_exists($defaultPath . '/settings.php') && file_exists($defaultPath . '/default.settings.php')) {
            copy($defaultPath . '/default.settings.php', $defaultPath . '/settings.php');
            require_once $drupalRoot . '/core/includes/bootstrap.inc';
            require_once $drupalRoot . '/core/includes/install.inc';
            new Settings([]);
            $settings['settings']['config_sync_directory'] = (object) [
                        'value' => 'sites/default/config/' . $sync,
                        'required' => TRUE,
            ];
            $settings['settings']['file_private_path'] = (object) [
                        'value' => 'sites/default/private/',
                        'required' => TRUE,
            ];
            drupal_rewrite_settings($settings, $defaultPath . '/settings.php');
            self::patche($event);
            $event->getIO()->overwrite('<info>Success Install</info>.');
        }
    }

    /**
     * 
     * @param Event $event
     */
    public static function postPackageUpdate(Event $event) {
        // patches
        self::patche($event);
    }

    /**
     *
     * @param Event $event
     */
    public static function patche(Event $event) {
        $composer = $event->getComposer();
        $drupalRoot = realpath($composer->getPackage()->getExtra()['drupal-scaffold']['locations']['web-root']);
        // patches
        $module = false;
        foreach ($composer->getPackage()->getExtra()['installer-paths'] as $cle => $values) {
            if (in_array('type:drupal-module', $values)) {
                $module = realpath(str_ireplace('{$name}', '', $cle));
            }
        }
        if (is_dir($module)) {
            if (is_file(($patche = $module . '/calendar/src/CalendarHelper.php'))) {
                file_put_contents($patche, str_ireplace('Views::viewsData()->get();', 'Views::viewsData()->getAll();', file_get_contents($patche)));
            }
            if (is_file(($patche = $module . '/back_to_top/js/back_to_top.js'))) {
                file_put_contents($patche, str_ireplace('easeOutQuart', 'linear', file_get_contents($patche)));
            }
            if (is_file(($patche = $module . '/sitemap/sitemap.links.menu.yml'))) {
                unlink($patche);
            }
        }
    }

}
