<?php

namespace Drupal\arvodia\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Extension\ExtensionDiscovery;
use Drupal\Component\Serialization\Yaml;

class ArvodiaAddModulesForm extends FormBase {

    private $subscript;
    private $listing;

    public function getFormId() {
        return 'arvodia_select_module_form';
    }

    public function buildForm(array $form, FormStateInterface $form_state, $install_state = NULL) {
        $form['#title'] = $this->t('Select an installation Module');
        $form['build'] = [
            '#type' => 'markup',
            '#markup' => $this->t('arvodia vous propose des models de site clé a la main').'</br></br>'
            . 'Pack Blog et Pro : disponible à la demande sur <b>arvodia@hotmail.com</b>',
            '#weight' => '-5',
        ];
        $this->listing = new ExtensionDiscovery(\Drupal::root());
        $this->listing = $this->listing->scan('module');
        $test = [];
        foreach ($this->listing as $module) {
            if (!preg_match("#^core/modules/#", $module->getPath())) {
                $mInfo = Yaml::decode(file_get_contents($module->getPathname()));
                $module = [$module->getName(), [
                        'package' => (isset($mInfo['package']) ? $mInfo['package'] : null),
                        'name' => (isset($mInfo['name']) ? $mInfo['name'] : null),
                        'description' => (isset($mInfo['description']) ? $mInfo['description'] : null),
                        'hidden' => (isset($mInfo['hidden']) ? $mInfo['hidden'] : null),
                ]];
                if (!isset($module[1]['package']))
                    continue;
                if ($module[1]['package'] != 'EURL ARVODIA PACK')
                    continue;
                if (!isset($module[1]['name']))
                    continue;
                $this->subscript[$module[0]] = $module;
            }
        }
        if (!empty($this->subscript)) {
            $form['subscript'] = [
                '#type' => 'radios',
                '#title' => $this->t('Select a subscription'),
                '#required' => TRUE,
                '#weight' => '-4',
            ];
            foreach ($this->subscript as $key => $module) {
                array_multisort($this->subscript);
                $form['subscript']['#options'][$key] = isset($module[1]['description']) ? ' <strong>' . $this->t($module[1]['name']) . '</strong> : </br><small><i>' . $module[1]['description'] . '</i></small>' : ' <strong>' . $this->t($module[1]['name']) . '</strong>';
            }
        }
        $form['actions'] = ['#type' => 'actions'];
        $form['actions']['submit'] = [
            '#type' => 'submit',
            '#value' => $this->t('Save and continue'),
            '#button_type' => 'primary',
        ];
        return $form;
    }

    public function validateForm(array &$form, FormStateInterface $form_state) {
        
    }

    public function submitForm(array &$form, FormStateInterface $form_state) {
        
    }

}
