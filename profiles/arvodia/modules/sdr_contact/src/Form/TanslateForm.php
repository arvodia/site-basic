<?php

namespace Drupal\sdr_contact\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class TanslateForm extends FormBase {

    public function getFormId() {
        return 'parametre_form';
    }

    public function buildForm(array $form, FormStateInterface $form_state) {
        $form = [];
        if (!\Drupal::config('translate.select')->get('lang')) {
            \Drupal::configFactory()->getEditable('translate.select')->set('lang', [
                'ar' => TRUE,
                'en' => TRUE,
                'fr' => TRUE
            ])->save();
        }
        $form['build'] = [
            '#type' => 'markup',
            '#markup' => $this->t('Multi-language support')
            . '<br/><hr />',
            '#weight' => '-20',
        ];
        $form['activate_ar'] = [
            '#type' => 'checkbox',
            '#title' => $this->t('Activate the Arabic language'),
            '#default_value' => \Drupal::config('translate.select')->get('lang')['ar'],
            '#weight' => '-17',
        ];
        $form['activate_en'] = [
            '#type' => 'checkbox',
            '#title' => $this->t('Activate the English language'),
            '#default_value' => \Drupal::config('translate.select')->get('lang')['en'],
            '#weight' => '-17',
        ];
        $form['activate_fr'] = [
            '#type' => 'checkbox',
            '#title' => $this->t('Activate the French language'),
            '#default_value' => \Drupal::config('translate.select')->get('lang')['fr'],
            '#weight' => '-17',
        ];
        $form['build2'] = [
            '#type' => 'markup',
            '#markup' => '<hr />',
            '#weight' => '-16',
        ];
        $form['sitename_ar'] = [
            '#type' => 'textfield',
            '#title' => $this->t('The website title in the Arabic language'),
            '#default_value' => \Drupal::languageManager()->getLanguageConfigOverride('ar', 'system.site')->get('name'),
            '#maxlength' => 64,
            '#size' => 64,
            '#weight' => '-15',
        ];
        $form['slogan_ar'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Slogan in the Arabic'),
            '#default_value' => \Drupal::languageManager()->getLanguageConfigOverride('ar', 'system.site')->get('slogan'),
            '#maxlength' => 64,
            '#size' => 64,
            '#weight' => '-15',
        ];
        $form['sitename_en'] = [
            '#type' => 'textfield',
            '#title' => $this->t('The website title in the English language'),
            '#default_value' => \Drupal::configFactory()->getEditable('system.site')->get('name'),
            '#maxlength' => 64,
            '#size' => 64,
            '#weight' => '-14',
        ];
        $form['slogan_en'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Slogan in the English'),
            '#default_value' => \Drupal::configFactory()->getEditable('system.site')->get('slogan'),
            '#maxlength' => 64,
            '#size' => 64,
            '#weight' => '-14',
        ];
        $form['sitename_fr'] = [
            '#type' => 'textfield',
            '#title' => $this->t('The website title in the French language'),
            '#default_value' => \Drupal::languageManager()->getLanguageConfigOverride('fr', 'system.site')->get('name'),
            '#maxlength' => 64,
            '#size' => 64,
            '#weight' => '-13',
        ];
        $form['slogan_fr'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Slogan in the French'),
            '#default_value' => \Drupal::languageManager()->getLanguageConfigOverride('fr', 'system.site')->get('slogan'),
            '#maxlength' => 64,
            '#size' => 64,
            '#weight' => '-13',
        ];
        $form['build3'] = [
            '#type' => 'markup',
            '#markup' => '<hr />',
            '#weight' => '-12',
        ];
        $form['language_select'] = [
            '#type' => 'select',
            '#title' => $this->t('Default language'),
            '#default_value' => \Drupal::config('system.site')->get('default_langcode'),
            '#weight' => '-19',
            '#options' => [
                'en' => $this->t('Anglais'),
                'ar' => $this->t('Arabic'),
                'fr' => $this->t('French'),
            ],
        ];
        $form['build4'] = [
            '#type' => 'markup',
            '#markup' => '<hr />',
            '#weight' => '-18',
        ];
        $form['submit'] = [
            '#type' => 'submit',
            '#value' => $this->t('Submit'),
            '#weight' => '-9',
        ];
        return $form;
    }

    public function validateForm(array &$form, FormStateInterface $form_state) {
        parent::validateForm($form, $form_state);
        if (is_bool($form_state->getValue('activate_ar')) === true)
            $form_state->setErrorByName("activate_ar", $this->t('ERROR : Please enter a valid value.'));
        if (is_bool($form_state->getValue('activate_en')) === true)
            $form_state->setErrorByName("activate_en", $this->t('ERROR : Please enter a valid value.'));
        if (is_bool($form_state->getValue('activate_en')) === true)
            $form_state->setErrorByName("activate_en", $this->t('ERROR : Please enter a valid value.'));
        if ($form_state->getValue('language_select') !== 'ar' && $form_state->getValue('language_select') !== 'en' && $form_state->getValue('language_select') !== 'fr')
            $form_state->setErrorByName("select_form", $this->t('ERROR : Please enter a valid value.'));
        if (!$form_state->getValue('activate_ar') && !$form_state->getValue('activate_en') && !$form_state->getValue('activate_fr'))
            $form_state->setErrorByName("activate_ar", $this->t('ERROR : Please selecte one language.'));
        if (!$form_state->getValue('activate_' . $form_state->getValue('language_select') . ''))
            $form_state->setErrorByName("select_form", $this->t('ERROR : Language (' . $form_state->getValue('language_select') . ') is not activate'));
    }

    public function submitForm(array &$form, FormStateInterface $form_state) {
        \Drupal::configFactory()->getEditable('system.site')->set('default_langcode', $form_state->getValue('language_select'))->save(TRUE);
        \Drupal::configFactory()->getEditable('system.site')->set('name', $form_state->getValue('sitename_en'))->save();
        \Drupal::languageManager()->getLanguageConfigOverride('fr', 'system.site')->set('name', $form_state->getValue('sitename_fr'))->save();
        \Drupal::languageManager()->getLanguageConfigOverride('ar', 'system.site')->set('name', $form_state->getValue('sitename_ar'))->save();
        \Drupal::configFactory()->getEditable('system.site')->set('slogan', $form_state->getValue('slogan_en'))->save();
        \Drupal::languageManager()->getLanguageConfigOverride('fr', 'system.site')->set('slogan', $form_state->getValue('slogan_fr'))->save();
        \Drupal::languageManager()->getLanguageConfigOverride('ar', 'system.site')->set('slogan', $form_state->getValue('slogan_ar'))->save();
        \Drupal::configFactory()->getEditable('translate.select')->set('lang', [
            'ar' => $form_state->getValue('activate_ar'),
            'en' => $form_state->getValue('activate_en'),
            'fr' => $form_state->getValue('activate_fr')
        ])->save();
        \Drupal::messenger()->addMessage(t('The settings are saved successfully.'));
    }

}
