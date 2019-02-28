<?php

use Drupal\contact\Entity\ContactForm;
use Drupal\Core\Form\FormStateInterface;

function arvodia_form_install_configure_form_alter(&$form, FormStateInterface $form_state) {
    $form['site_information']['slogan'] = [
        '#type' => 'textfield',
        '#title' => t('Slogan'),
        '#maxlength' => 64,
        '#size' => 64,
        '#weight' => '-20',
    ];
    $form['#submit'][] = 'arvodia_form_install_configure_submit';
}

function arvodia_form_install_configure_submit($form, FormStateInterface $form_state) {
    $site_name = $form_state->getValue('site_name');
    $slogan = $form_state->getValue('slogan');
    \Drupal::configFactory()->getEditable('system.site')->set('name', $site_name)->save();
    \Drupal::configFactory()->getEditable('system.site')->set('slogan', $slogan)->save();
    \Drupal::languageManager()->getLanguageConfigOverride('fr', 'system.site')->set('name', $site_name)->save();
    \Drupal::languageManager()->getLanguageConfigOverride('ar', 'system.site')->set('name', $site_name)->save();
    $site_mail = $form_state->getValue('site_mail');
    ContactForm::load('feedback')->setRecipients([$site_mail])->trustData()->save();
}

function arvodia_install_tasks(array &$install_state) {
    return [
        'arvodia_add_modules' => [
            'display_name' => t('Ajouter functionalities'),
            'display' => TRUE,
            'type' => 'form',
            'function' => 'Drupal\arvodia\Form\ArvodiaAddModulesForm',
        ],
        'arvodia_gerant_account' => [
            'display_name' => t('Admin account'),
            'display' => TRUE,
            'type' => 'form',
            'function' => 'Drupal\arvodia\Form\ArvodiaGerantAccountForm',
        ],
        'arvodia_add_content' => [
            'display_name' => t('Ajouter contenus'),
            'display' => TRUE,
            'type' => 'form',
            'function' => 'Drupal\arvodia\Form\ArvodiaAddContenuForm',
        ],
    ];
}

function arvodia_install_tasks_alter(&$tasks, $install_state) {
    $tasks['install_finished']['function'] = 'arvodia_install_finished';
}

function arvodia_install_finished(array &$install_state) {
    $profile = drupal_get_profile();
    module_set_weight($profile, 1000);
    \Drupal::service('router.builder')->rebuild();
    \Drupal::service('cron')->run();
    $success_message = t('Congratulations, you installed arvodia pack', [
        '@drupal' => drupal_install_profile_distribution_name(),
    ]);
    \Drupal::messenger()->addMessage($success_message);
    \Drupal::service('entity.definition_update_manager')->applyUpdates();
    \Drupal::languageManager()->getLanguageConfigOverride('fr', 'block.block.contactblock')->set('settings.contact_text', 'Remplissez simplement le formulaire et envoyer-le.')->save();
    \Drupal::languageManager()->getLanguageConfigOverride('ar', 'block.block.contactblock')->set('settings.contact_text', 'ببساطة ﺇﻣﻸ ﺍﻟﺠﺪﻭﻝ وإرساله.')->save();
    \Drupal::languageManager()->getLanguageConfigOverride('fr', 'block.block.contactblock')->set('settings.label', 'Configuration du formulaire de contact')->save();
    \Drupal::languageManager()->getLanguageConfigOverride('ar', 'block.block.contactblock')->set('settings.label', 'تكوين نموذج الاتصال')->save();
    \Drupal::languageManager()->getLanguageConfigOverride('fr', 'views.view.all_contents')->set('display.default.display_options.header.area.content.value', 'La liste des contenus')->save();
    \Drupal::languageManager()->getLanguageConfigOverride('ar', 'views.view.all_contents')->set('display.default.display_options.header.area.content.value', 'قائمة المحتويات')->save();
    if ($install_state['interactive']) {
        $account = Drupal\user\Entity\User::load(3);
        user_login_finalize($account);
    }
    \Drupal::state()->set('system.maintenance_mode', 1);
    drupal_flush_all_caches();
    \Drupal::service('router.builder')->rebuild();
}
function arvodia_requirements($phase) {
  $requirements = [];

  switch ($phase) {
    // Called while the module is installed.
    case 'install':
    if (!\Drupal::service('file_system')->realpath("private://")) {
        $requirements[] = [
          'title' => t('Private File System'),
          'value' => t('settings.php'),
          'description' => t('Create a directory for the private files.'
                  . '<br/>add the directory :'
                  . '<br/>\'sites/default/private/\''
                  . '<br/>add the line :'
                  . '<br/>$settings[\'file_private_path\'] = $site_path . \'/private/\';'
                  . '<br/>in settings.php'),
          'severity' => REQUIREMENT_ERROR,
        ];
      }
      break;
  }

  return $requirements;
}