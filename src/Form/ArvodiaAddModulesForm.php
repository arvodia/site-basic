<?php

namespace Drupal\arvodia\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Extension\ExtensionDiscovery;
use Drupal\Component\Serialization\Yaml;

class ArvodiaAddModulesForm extends FormBase {

    private $modules;
    private $subscript;
    private $listing;

    public function getFormId() {
        return 'arvodia_select_module_form';
    }

    public function buildForm(array $form, FormStateInterface $form_state, $install_state = NULL) {
        $form['#title'] = $this->t('Installation Module');
        $form['build'] = [
            '#type' => 'markup',
            '#markup' => $this->t('arvodia vous propose des models de site clé a la main'),
            '#weight' => '-5',
        ];

        $form['actions'] = ['#type' => 'actions'];
        $form['actions']['submit'] = [
            '#type' => 'submit',
            '#value' => $this->t('Next'),
            '#button_type' => 'primary',
        ];
        return $form;
    }

    public function validateForm(array &$form, FormStateInterface $form_state) {
        if(!mkdir(\Drupal::service('file_system')->realpath("public://").'/src'))
            $form_state->setErrorByName('submit', 'Impossible d\'installer les fichiers');
        if (!\Drupal::service('module_installer')->install(['sdr_basic']))
            $form_state->setErrorByName('submit', 'Impossible d\'installer les modules');
    }

    public function submitForm(array &$form, FormStateInterface $form_state) {
        
    }

}
