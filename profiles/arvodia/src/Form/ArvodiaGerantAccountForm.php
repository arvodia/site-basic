<?php

namespace Drupal\arvodia\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\contact\Entity\ContactForm;

class ArvodiaGerantAccountForm extends FormBase {

    private $user;

    public function getFormId() {
        return 'arvodia_gerant_form';
    }

    public function buildForm(array $form, FormStateInterface $form_state) {
        $form['#title'] = $this->t('Gerant Account');
        $form['build'] = [
            '#type' => 'markup',
            '#markup' => $this->t('Site maintenance account') . '<br/><hr />',
            '#weight' => '-7',
        ];
        $form['name'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Username'),
            '#maxlength' => USERNAME_MAX_LENGTH,
            '#description' => $this->t("Several special characters are allowed, including space, period (.), hyphen (-), apostrophe ('), underscore (_), and the @ sign."),
            '#required' => TRUE,
            '#attributes' => ['class' => ['username']],
        ];
        $form['auto'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Auto Generate Password'),
            '#required' => false,
            '#size' => 25,
            '#default_value' => user_password()];
        $form['pass1'] = [
            '#type' => 'password',
            '#title' => $this->t('Password'),
            '#required' => TRUE,
            '#size' => 25,
            '#attributes' => ['class' => ['password-field js-password-field form-text required'],
                'id' => ['edit-pass-pass1'],
        ]];
        $form['pass2'] = [
            '#type' => 'password',
            '#title' => $this->t('Confirm password'),
            '#required' => TRUE,
            '#size' => 25,
            '#attributes' => ['class' => ['password-field js-password-field form-text required'],
                'id' => ['edit-pass-pass2'],
        ]];
        $form['mail'] = [
            '#type' => 'email',
            '#title' => $this->t('Email address'),
            '#required' => TRUE,
        ];
        $form['submit'] = [
            '#type' => 'submit',
            '#value' => $this->t('Save and continue'),
            '#button_type' => 'primary',
        ];
        return $form;
    }

    public function validateForm(array &$form, FormStateInterface $form_state) {
        if ($form_state->getValue('pass1') != $form_state->getValue('pass2'))
            $form_state->setErrorByName('pass', 'Password field is required.');
        if ($form_state->getValue('mail') !== '' && !\Drupal::service('email.validator')->isValid($form_state->getValue('mail')))
            $form_state->setErrorByName("mail", $this->t('ERROR : The email address mail is not valid.'));
        if (user_validate_name($form_state->getValue('name')) !== NULL) {
            $form_state->setErrorByName('name', user_validate_name($form_state->getValue('name')));
        }
        if (user_validate_name($form_state->getValue('name')) !== NULL) {
            $form_state->setErrorByName('name', user_validate_name($form_state->getValue('name')));
        }
        $this->user = \Drupal::entityQuery('user')
                ->condition('name', $form_state->getValue('name'));
        if (!empty($this->user->execute())) {
            $form_state->setErrorByName('name', 'Username existe déja');
        }
    }

    public function submitForm(array &$form, FormStateInterface $form_state) {
        $account_values = $form_state->getValue('name');
        $this->user = \Drupal\user\Entity\User::create();
        $this->user->setPassword($form_state->getValue('pass1'));
        $this->user->enforceIsNew();
        $this->user->setEmail($form_state->getValue('mail'));
        $this->user->setUsername($form_state->getValue('name'));
        $this->user->set("init", 'email');
        $this->user->set("langcode", \Drupal::languageManager()->getCurrentLanguage()->getId());
        $this->user->addRole('admin');
        $this->user->set('user_picture', file_save_data(file_get_contents("profiles/arvodia/modules/sdr_contact/img/profile.png"), "public://src/profile.png", FILE_EXISTS_REPLACE)->id());
        $this->user->activate();
        $this->user->save();
        ContactForm::load('gerant')->setRecipients([$form_state->getValue('mail')])->trustData()->save();
        \Drupal::configFactory()->getEditable('contact.settings')->set('default_form', 'gerant')->save();
    }

}
