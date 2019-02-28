<?php

namespace Drupal\sdr_contact\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\user\RoleInterface;

class ContactForm extends FormBase {

    private $default;
    private $tableau;

    public function getFormId() {
        return 'contact_form';
    }

    public function buildForm(array $form, FormStateInterface $form_state) {
        switch (\Drupal::languageManager()->getCurrentLanguage()->getId()) {
            case 'ar':
                $this->default = \Drupal::languageManager()->getLanguageConfigOverride('ar', 'block.block.contactblock')->get('settings.contact_text');
                break;
            case 'en':
                $this->default = \Drupal::config('block.block.contactblock')->get('settings.contact_text');
                break;
            case 'fr':
                $this->default = \Drupal::languageManager()->getLanguageConfigOverride('fr', 'block.block.contactblock')->get('settings.contact_text');
                break;
        }
        $form = [];
        $form['build'] = [
            '#type' => 'markup',
            '#markup' => $this->t('Website main contact form parameter') . '<br/><hr />',
            '#weight' => '-7',
        ];
        $form['email_address'] = [
            '#type' => 'email',
            '#title' => $this->t('Email of formulair actuale'),
            '#required' => TRUE,
            '#description' => $this->t('reception mail messagerie'),
            '#default_value' => \Drupal::config('contact.form.gerant')->get('recipients')[0],
            '#weight' => '-04',
            '#required' => TRUE,
        ];
        $form['contact_text'] = [
            '#type' => 'textarea',
            '#rows' => 10,
            '#title' => $this->t('Contact Text'),
            '#description' => $this->t('Description of the main contact form of the site'),
            '#default_value' => $this->default,
            '#weight' => '-06',
        ];
        $form['select_form'] = [
            '#type' => 'radios',
            '#required' => TRUE,
            '#options' => [
                'website' => '<br/>' . t('The message will be sent only on email of formulair actuale'),
                'personal' => t('     The message will be sent on email of formulair actuale and also on internal mail and personal email of the admins.'),
            ],
            '#weight' => '-03',
            '#default_value' => 'website',
        ];
        if (isset(\Drupal::config('contact.form.gerant')->get('recipients')[1])) {
            $form['select_form']['#default_value'] = 'personal';
        } else
            $form['select_form']['#default_value'] = 'website';
        $tmp = '';
        foreach ((\Drupal::entityQuery('user')->condition('roles', 'admin')->execute()) as $key => $valuer) {
            $tmp = $tmp . ' ' . \Drupal\user\Entity\User::load($key)->getEmail();
        }
        $form['email_admin'] = [
            '#type' => 'email',
            '#title' => $this->t('Email address'),
            '#required' => TRUE,
            '#description' => $this->t('reception mail messagerie'),
            '#default_value' => $tmp,
            '#weight' => '-02',
            '#required' => TRUE,
            '#disabled' => TRUE,
        ];
        $form['quantity'] = [
            '#type' => 'number',
            '#title' => $this->t('Quantity'),
            '#description' => $this->t('The number of messages that can be sent with the personal contact form in one hour'),
            '#default_value' => \Drupal::config('contact.settings')->get('flood.limit'),
            '#weight' => '-02',
        ];
        $form['build3'] = [
            '#type' => 'markup',
            '#markup' => '<hr />',
            '#weight' => '-02',
        ];
        $form['submit'] = [
            '#type' => 'submit',
            '#value' => $this->t('Submit'),
            '#weight' => '0',
        ];
        return $form;
    }

    public function validateForm(array &$form, FormStateInterface $form_state) {
        parent::validateForm($form, $form_state);
        if (!is_numeric($form_state->getValue('quantity')))
            $form_state->setErrorByName("quantity", $this->t('ERROR : Please use a number.'));
        if ($form_state->getValue('email_address') !== '' && !\Drupal::service('email.validator')->isValid($form_state->getValue('email_address')))
            $form_state->setErrorByName("email_address", $this->t('ERROR : The email address mail is not valid.'));
        if ($form_state->getValue('select_form') !== 'personal' && $form_state->getValue('select_form') !== 'website')
            $form_state->setErrorByName("select_form", $this->t('ERROR : Please enter a valid value.'));
    }

    public function submitForm(array &$form, FormStateInterface $form_state) {
        \Drupal::configFactory()->getEditable('contact.settings')->set('flood.limit', $form_state->getValue('quantity'))->save();
        switch (\Drupal::languageManager()->getCurrentLanguage()->getId()) {
            case 'ar':
                \Drupal::languageManager()->getLanguageConfigOverride('ar', 'block.block.contactblock')->set('settings.contact_text', $form_state->getValue('contact_text'))->save();
                break;
            case 'en':
                \Drupal::languageManager()->getLanguageConfigOverride('en', 'block.block.contactblock')->set('settings.contact_text', $form_state->getValue('contact_text'))->save();
                break;
            case 'fr':
                \Drupal::languageManager()->getLanguageConfigOverride('fr', 'block.block.contactblock')->set('settings.contact_text', $form_state->getValue('contact_text'))->save();
                break;
        }
        switch ($form_state->getValue('select_form')) {
            case 'website':
                \Drupal::configFactory()->getEditable('contact.form.gerant')->set('recipients', [$form_state->getValue('email_address')])->save();
                break;
            case 'personal':
                $this->tableau[] = $form_state->getValue('email_address');
                foreach ((\Drupal::entityQuery('user')->condition('roles', 'admin')->execute()) as $key => $valuer) {
                    $this->tableau[] = \Drupal\user\Entity\User::load($key)->getEmail();
                }
                \Drupal::configFactory()->getEditable('contact.form.gerant')->set('recipients', $this->tableau)->save();
                break;
        }
        \Drupal::messenger()->addMessage(t('The settings are saved successfully.'));
    }

}
