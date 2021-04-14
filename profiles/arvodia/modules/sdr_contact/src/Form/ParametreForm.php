<?php

namespace Drupal\sdr_contact\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\user\RoleInterface;

class ParametreForm extends FormBase {

    private $file;
    private $file_usage;

    public function getFormId() {
        return 'parametre_form';
    }

    public function buildForm(array $form, FormStateInterface $form_state) {
        $form = [];
        $form['Appearance'] = [
            '#type' => 'fieldset',
            '#weight' => '-22',
            '#title' => '<h2>' . $this->t('Appearance') . '</h2>',
        ];
        $form['Appearance']['ico_file'] = [
            '#type' => 'managed_file',
            '#name' => 'ico_file',
            '#title' => '<h3>' . t('Favicon') . '</h3>',
            '#size' => 20,
            '#description' => t('A favicon is a computer icon symbolizing a website'),
            '#upload_validators' => ['file_validate_extensions' => ['ico'],],
            '#upload_location' => 'public://src/',
            '#weight' => '-22',
        ];
        if (\Drupal::config('sdr_contact.parametre')->get('settings.favicon_id') != false) {
            $form['ico_file']['#default_value'] = [\Drupal::config('sdr_contact.parametre')->get('settings.favicon_id')];
        }
        $form['Appearance']['carousel_effet'] = [
            '#type' => 'radios',
            '#title' => t('Images carousel effect'),
            '#required' => TRUE,
            '#options' => [
                'image_resize' => t('Automatically resize the image 1140×456'),
                'image_scale_and_crop' => t('Automatically scale and crop the image 1140×456'),
            ], '#weight' => '-22',
            '#default_value' => 'website',
        ];
        if ((\Drupal::config('image.style.image_carousel')->get('effects.47599ae1-844a-4485-bc1d-ab7e387786a4.id') == 'image_scale_and_crop')) {
            $form['Appearance']['carousel_effet']['#default_value'] = 'image_scale_and_crop';
        } else
            $form['Appearance']['carousel_effet']['#default_value'] = 'image_resize';
        $form['activate_avatar'] = [
            '#type' => 'checkbox',
            '#title' => $this->t('Enable avatar'),
            '#description' => $this->t('Show photo of admin in carousel'),
            '#default_value' => \Drupal::config('sdr_contact.parametre')->get('settings.activate_avatar'),
            '#weight' => '-22',
        ];
        $form['Post'] = [
            '#type' => 'fieldset',
            '#weight' => '-21',
            '#title' => '<h2>' . $this->t('Post') . '</h2>',
        ];
        $form['Post']['view_content'] = [
            '#type' => 'checkbox',
            '#title' => $this->t('See the results'),
            '#description' => $this->t('allow them to connect to see the number of views of the contents.'),
            '#default_value' => (\Drupal\user\Entity\Role::load('authenticated')->hasPermission('view post access counter')) ? true : false,
            '#weight' => '-21',
        ];
        $form['shar'] = [
            '#type' => 'fieldset',
            '#weight' => '-8',
            '#title' => '<h2>' . $this->t('Shar') . '</h2>',
        ];
        $form['shar']['facebook_shar'] = [
            '#type' => 'checkbox',
            '#description' => $this->t('Enable facebook shar'),
            '#default_value' => \Drupal::config('sdr_contact.parametre')->get('settings.facebook_shar'),
            '#weight' => '-8',
        ];
        $form['shar']['linkedin_shar'] = [
            '#type' => 'checkbox',
            '#description' => $this->t('Enable linkedin shar'),
            '#default_value' => \Drupal::config('sdr_contact.parametre')->get('settings.linkedin_shar'),
            '#weight' => '-8',
        ];
        $form['shar']['twitter_shar'] = [
            '#type' => 'checkbox',
            '#description' => $this->t('Enable twitter shar'),
            '#default_value' => \Drupal::config('sdr_contact.parametre')->get('settings.twitter_shar'),
            '#weight' => '-8',
        ];
        $form['shar']['google_shar'] = [
            '#type' => 'checkbox',
            '#description' => $this->t('Enable google shar'),
            '#default_value' => \Drupal::config('sdr_contact.parametre')->get('settings.google_shar'),
            '#weight' => '-8',
        ];
        $form['shar']['email_shar'] = [
            '#type' => 'checkbox',
            '#description' => $this->t('Enable email shar'),
            '#default_value' => \Drupal::config('sdr_contact.parametre')->get('settings.email_shar'),
            '#weight' => '-8',
        ];
        $form['dev'] = [
            '#type' => 'fieldset',
            '#weight' => '-3',
            '#title' => '<h2>' . $this->t('Development') . '</h2>',
        ];
        $form['dev']['maintenance'] = [
            '#type' => 'checkbox',
            '#title' => $this->t('Put site into maintenance mode'),
            '#description' => $this->t('Authorized users can log in directly via the') . ' <a href="/user/login">' . $this->t('user login') . '</a> ' . $this->t('page.'),
            '#default_value' => \Drupal::state()->get('system.maintenance_mode'),
            '#weight' => '-3',
        ];
        $form['build8'] = [
            '#type' => 'markup',
            '#markup' => '<hr />',
            '#weight' => '-2',
        ];
        $form['submit'] = [
            '#type' => 'submit',
            '#value' => $this->t('Submit'),
            '#weight' => '10',
        ];
        return $form;
    }

    public function validateForm(array &$form, FormStateInterface $form_state) {
        parent::validateForm($form, $form_state);
        if (is_bool($form_state->getValue('activate_avatar')) === true)
            $form_state->setErrorByName("activate_avatar", $this->t('ERROR : Please enter a valid value.'));
        if (is_bool($form_state->getValue('cron_delete')) === true)
            $form_state->setErrorByName("cron_delete", $this->t('ERROR : Please enter a valid value.'));
        if (is_bool($form_state->getValue('avatar_blog')) === true)
            $form_state->setErrorByName("avatar_blog", $this->t('ERROR : Please enter a valid value.'));
        if (is_bool($form_state->getValue('facebook_shar')) === true)
            $form_state->setErrorByName("facebook_shar", $this->t('ERROR : Please enter a valid value.'));
        if (is_bool($form_state->getValue('linkedin_shar')) === true)
            $form_state->setErrorByName("linkedin_shar", $this->t('ERROR : Please enter a valid value.'));
        if (is_bool($form_state->getValue('twitter_shar')) === true)
            $form_state->setErrorByName("twitter_shar", $this->t('ERROR : Please enter a valid value.'));
        if (is_bool($form_state->getValue('google_shar')) === true)
            $form_state->setErrorByName("google_shar", $this->t('ERROR : Please enter a valid value.'));
        if (is_bool($form_state->getValue('email_shar')) === true)
            $form_state->setErrorByName("email_shar", $this->t('ERROR : Please enter a valid value.'));
    }

    public function submitForm(array &$form, FormStateInterface $form_state) {
        if ((\Drupal::currentUser()->id() == 1) || (in_array("system", \Drupal::currentUser()->getRoles())))
            \Drupal::configFactory()->getEditable('sdr_contact.parametre')->set('settings.map_key', $form_state->getValue('map_key'))->save();
        \Drupal::configFactory()->getEditable('sdr_contact.parametre')->set('settings.activate_avatar', $form_state->getValue('activate_avatar'))->save();
        \Drupal::configFactory()->getEditable('sdr_contact.parametre')->set('settings.facebook_shar', $form_state->getValue('facebook_shar'))->save();
        \Drupal::configFactory()->getEditable('sdr_contact.parametre')->set('settings.google_shar', $form_state->getValue('google_shar'))->save();
        \Drupal::configFactory()->getEditable('sdr_contact.parametre')->set('settings.twitter_shar', $form_state->getValue('twitter_shar'))->save();
        \Drupal::configFactory()->getEditable('sdr_contact.parametre')->set('settings.linkedin_shar', $form_state->getValue('linkedin_shar'))->save();
        \Drupal::configFactory()->getEditable('sdr_contact.parametre')->set('settings.email_shar', $form_state->getValue('email_shar'))->save();
        if (!empty($form_state->getValue('ico_file'))) {
            if (\Drupal::config('sdr_contact.parametre')->get('settings.favicon_id') != false) {
                if (\Drupal::config('sdr_contact.parametre')->get('settings.favicon_id') != $form_state->getValue('ico_file')[0]) {
                    \Drupal\file\Entity\File::load(\Drupal::config('sdr_contact.parametre')->get('settings.favicon_id'))->delete();
                }
            }
            $this->file = \Drupal\file\Entity\File::load($form_state->getValue('ico_file')[0]);
            $this->file->setPermanent();
            $this->file->save();
            $this->file_usage = \Drupal::service('file.usage');
            $this->file_usage->add($this->file, 'sdr_contact', 'managed_file', $form_state->getValue('ico_file')[0]);
            \Drupal::configFactory()->getEditable('as.settings')->set('favicon.path', \Drupal\file\Entity\File::load($form_state->getValue('ico_file')[0])->getFileUri())->save();
            \Drupal::configFactory()->getEditable('sdr_contact.parametre')->set('settings.favicon_id', $form_state->getValue('ico_file')[0])->save();
        }
        if (\Drupal::state()->get('system.maintenance_mode') != $form_state->getValue('maintenance')) {
            \Drupal::state()->set('system.maintenance_mode', $form_state->getValue('maintenance'));
            if ($form_state->getValue('maintenance'))
                if (\Drupal::currentUser()->id() == 1)
                    user_role_revoke_permissions('admin', ['access site in maintenance mode',]);
            if (!$form_state->getValue('maintenance'))
                if (\Drupal::currentUser()->id() == 1)
                    user_role_grant_permissions('admin', ['access site in maintenance mode',]);
            drupal_flush_all_caches();
        }
        if ((\Drupal::config('image.style.image_carousel')->get('effects.47599ae1-844a-4485-bc1d-ab7e387786a4.id')) != $form_state->getValue('carousel_effet')) {
            if ($form_state->getValue('carousel_effet') == 'image_resize')
                \Drupal::configFactory()->getEditable('image.style.image_carousel')->set('effects.47599ae1-844a-4485-bc1d-ab7e387786a4.id', 'image_resize')->save();
            else
                \Drupal::configFactory()->getEditable('image.style.image_carousel')->set('effects.47599ae1-844a-4485-bc1d-ab7e387786a4.id', 'image_scale_and_crop')->save();
            if ($form_state->getValue('carousel_effet') == 'image_scale_and_crop')
                \Drupal::configFactory()->getEditable('field.field.node.carousel.field_img_carousel')->set('description', 'Please select an image for the carousel <strong>"Automatically scale and crop  the image 1140×456"</strong>')->save();
            else
                \Drupal::configFactory()->getEditable('field.field.node.carousel.field_img_carousel')->set('description', 'Please select an image for the carousel <strong>"Automatically resize  the image 1140×456"</strong>')->save();
            drupal_flush_all_caches();
        }
        \Drupal::messenger()->addMessage(t('The settings are saved successfully.'));
    }

}
