<?php

namespace Drupal\sdr_contact\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'ContactBlock' block.
 *
 * @Block(
 *  id = "contact_block",
 *  admin_label = @Translation("Contact block"),
 * )
 */
class ContactBlock extends BlockBase {

    /**
     * {@inheritdoc}
     */
    public function defaultConfiguration() {
        return [
            'contact_text' => $this->t('Remplissez simplement le formulaire et envoyez-le.'),
                ] + parent::defaultConfiguration();
    }

    /**
     * {@inheritdoc}
     */
    public function blockForm($form, FormStateInterface $form_state) {
        $form['contact_text'] = [
            '#type' => 'textarea',
            '#title' => $this->t('Contact Text'),
            '#description' => $this->t('Text pour formulair de contacte'),
            '#default_value' => $this->configuration['contact_text'],
            '#weight' => '0',
        ];

        return $form;
    }

    /**
     * {@inheritdoc}
     */
    public function blockSubmit($form, FormStateInterface $form_state) {
        $this->configuration['contact_text'] = $form_state->getValue('contact_text');
    }

    /**
     * {@inheritdoc}
     */
    public function build() {
        $build = [];
        $build['contact_block_contact_text']['#markup'] = '<p>' . $this->configuration['contact_text'] . '</p>';

        return $build;
    }

}
