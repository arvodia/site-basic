<?php

namespace Drupal\sdr_contact\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'FooterBlock' block.
 *
 * @Block(
 *  id = "footer_block",
 *  admin_label = @Translation("Footer block"),
 * )
 */
class FooterBlock extends BlockBase {

    /**
     * {@inheritdoc}
     */
    public function defaultConfiguration() {
        return [
            'developed_by' => $this->t('Developed By EURL ARVODIA'),
                ] + parent::defaultConfiguration();
    }

    /**
     * {@inheritdoc}
     */
    public function blockForm($form, FormStateInterface $form_state) {
        $form['developed_by'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Developed By'),
            '#description' => $this->t('Enter your entreprise name'),
            '#default_value' => $this->configuration['developed_by'],
            '#maxlength' => 64,
            '#size' => 64,
            '#weight' => '0',
        ];

        return $form;
    }

    /**
     * {@inheritdoc}
     */
    public function blockSubmit($form, FormStateInterface $form_state) {
        $this->configuration['developed_by'] = $form_state->getValue('developed_by');
    }

    /**
     * {@inheritdoc}
     */
    public function build() {
        $build = [];
        //$build['footer_block_developed_by']['#markup'] = '<p>' . $this->configuration['developed_by'] . '</p>';
        $build['footer_block_developed_by']['#markup'] = '<p>Developed By <a href="mailto:arvodia@hotmail.com">EURL ARVODIA</a>, <a href="/contact/feedback">Website feedback</a>.</p>';
        return $build;
    }

}
