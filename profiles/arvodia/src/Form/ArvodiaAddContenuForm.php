<?php

namespace Drupal\arvodia\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use \Drupal\node\Entity\Node;

\Drupal::service('entity.definition_update_manager')->applyUpdates();

class ArvodiaAddContenuForm extends FormBase {

    private $entity_type;
    private $bundle;
    private $entity_def;
    private $new_node;
    private $data;
    private $file;
    private $new_post;
    private $node;

    public function getFormId() {
        return 'arvodia_add_contenu_form';
    }

    public function buildForm(array $form, FormStateInterface $form_state) {
        $form = [];
        $form['#title'] = $this->t('Add contenu');
        $form['build'] = [
            '#type' => 'markup',
            '#markup' => $this->t('Ajouter du contenu predefinie.'),
        ];
        $form['submit'] = [
            '#type' => 'submit',
            '#value' => t('Fin installation'),
        ];
        return $form;
    }

    public function validateForm(array &$form, FormStateInterface $form_state) {
        
    }

    public function submitForm(array &$form, FormStateInterface $form_state) {
        if (\Drupal::service('module_handler')->moduleExists('sdr_contact')) {
            $this->entity_type = "node";
            $this->bundle = "page";
            $this->entity_def = \Drupal::entityManager()->getDefinition($this->entity_type);
            $this->data = file_get_contents("profiles/arvodia/modules/sdr_contact/img/favorites.png");
            $this->file = file_save_data($this->data, "public://src/favorites.png", FILE_EXISTS_REPLACE);
            $this->new_node = [
                'uid' => 3,
                'title' => 'About us',
                'body' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.'
                . ' Mauris id ligula eget libero tristique hendrerit a fermentum enim.'
                . ' Duis dignissim nulla at lectus porta, a mattis justo consectetur.'
                . ' Morbi efficitur, tortor non varius vulputate, massa urna fringilla erat,'
                . ' id varius ipsum lacus vel ex. Proin finibus pulvinar tortor, sit amet venenatis est finibus non.'
                . ' Aenean sit amet pulvinar leo. Donec et consequat dolor. Donec felis elit, rutrum in accumsan sit amet,'
                . ' volutpat aliquet enim.',
                'promote' => 1,
                'langcode' => 'en',
                'created' => REQUEST_TIME,
                'changed' => REQUEST_TIME,
                'field_rubrique_logo' => [
                    'target_id' => $this->file->id(),
                    'alt' => 'Sample',
                    'title' => 'Sample File'
                ],
                $this->entity_def->get('entity_keys')['bundle'] => $this->bundle
            ];
            $this->new_post = \Drupal::entityManager()->getStorage($this->entity_type)->create($this->new_node);
            $this->new_post->addTranslation('ar', ['title' => 'من نحن',
                'body' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.'
                . ' Mauris id ligula eget libero tristique hendrerit a fermentum enim.'
                . ' Duis dignissim nulla at lectus porta, a mattis justo consectetur.'
                . ' Morbi efficitur, tortor non varius vulputate, massa urna fringilla erat,'
                . ' id varius ipsum lacus vel ex. Proin finibus pulvinar tortor, sit amet venenatis est finibus non.'
                . ' Aenean sit amet pulvinar leo. Donec et consequat dolor. Donec felis elit, rutrum in accumsan sit amet,'
                . ' volutpat aliquet enim.',
            ]);
            $this->new_post->addTranslation('fr', ['title' => 'À propos',
                'body' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.'
                . ' Mauris id ligula eget libero tristique hendrerit a fermentum enim.'
                . ' Duis dignissim nulla at lectus porta, a mattis justo consectetur.'
                . ' Morbi efficitur, tortor non varius vulputate, massa urna fringilla erat,'
                . ' id varius ipsum lacus vel ex. Proin finibus pulvinar tortor, sit amet venenatis est finibus non.'
                . ' Aenean sit amet pulvinar leo. Donec et consequat dolor. Donec felis elit, rutrum in accumsan sit amet,'
                . ' volutpat aliquet enim.',
            ]);
            $this->new_post->save();
            $this->data = file_get_contents("profiles/arvodia/modules/sdr_contact/img/folder.png");
            $this->file = file_save_data($this->data, "public://src/folder.png", FILE_EXISTS_REPLACE);
            $this->new_node = [
                'uid' => 3,
                'title' => 'Documentation',
                'body' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.'
                . ' Mauris id ligula eget libero tristique hendrerit a fermentum enim.'
                . ' Duis dignissim nulla at lectus porta, a mattis justo consectetur.'
                . ' Morbi efficitur, tortor non varius vulputate, massa urna fringilla erat,'
                . ' id varius ipsum lacus vel ex. Proin finibus pulvinar tortor, sit amet venenatis est finibus non.'
                . ' Aenean sit amet pulvinar leo. Donec et consequat dolor. Donec felis elit, rutrum in accumsan sit amet,'
                . ' volutpat aliquet enim.',
                'promote' => 1,
                'field_rubrique_logo' => [
                    'target_id' => $this->file->id(),
                    'alt' => 'Sample',
                    'title' => 'Sample File'
                ],
                $this->entity_def->get('entity_keys')['bundle'] => $this->bundle
            ];
            $this->new_post = \Drupal::entityManager()->getStorage($this->entity_type)->create($this->new_node);
            $this->new_post->addTranslation('ar', ['title' => 'توثيق',
                'body' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.'
                . ' Mauris id ligula eget libero tristique hendrerit a fermentum enim.'
                . ' Duis dignissim nulla at lectus porta, a mattis justo consectetur.'
                . ' Morbi efficitur, tortor non varius vulputate, massa urna fringilla erat,'
                . ' id varius ipsum lacus vel ex. Proin finibus pulvinar tortor, sit amet venenatis est finibus non.'
                . ' Aenean sit amet pulvinar leo. Donec et consequat dolor. Donec felis elit, rutrum in accumsan sit amet,'
                . ' volutpat aliquet enim.',
            ]);
            $this->new_post->addTranslation('fr', ['title' => 'Documentation',
                'body' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.'
                . ' Mauris id ligula eget libero tristique hendrerit a fermentum enim.'
                . ' Duis dignissim nulla at lectus porta, a mattis justo consectetur.'
                . ' Morbi efficitur, tortor non varius vulputate, massa urna fringilla erat,'
                . ' id varius ipsum lacus vel ex. Proin finibus pulvinar tortor, sit amet venenatis est finibus non.'
                . ' Aenean sit amet pulvinar leo. Donec et consequat dolor. Donec felis elit, rutrum in accumsan sit amet,'
                . ' volutpat aliquet enim.',
            ]);
            $this->new_post->save();
            $this->data = file_get_contents("profiles/arvodia/modules/sdr_contact/img/images.png");
            $this->file = file_save_data($this->data, "public://src/images.png", FILE_EXISTS_REPLACE);
            $this->new_node = [
                'uid' => 3,
                'title' => 'Products',
                'body' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.'
                . ' Mauris id ligula eget libero tristique hendrerit a fermentum enim.'
                . ' Duis dignissim nulla at lectus porta, a mattis justo consectetur.'
                . ' Morbi efficitur, tortor non varius vulputate, massa urna fringilla erat,'
                . ' id varius ipsum lacus vel ex. Proin finibus pulvinar tortor, sit amet venenatis est finibus non.'
                . ' Aenean sit amet pulvinar leo. Donec et consequat dolor. Donec felis elit, rutrum in accumsan sit amet,'
                . ' volutpat aliquet enim.',
                'promote' => 1,
                'field_rubrique_logo' => [
                    'target_id' => $this->file->id(),
                    'alt' => 'Sample',
                    'title' => 'Sample File'
                ],
                $this->entity_def->get('entity_keys')['bundle'] => $this->bundle
            ];
            $this->new_post = \Drupal::entityManager()->getStorage($this->entity_type)->create($this->new_node);
            $this->new_post->addTranslation('ar', ['title' => 'المنتجات',
                'body' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.'
                . ' Mauris id ligula eget libero tristique hendrerit a fermentum enim.'
                . ' Duis dignissim nulla at lectus porta, a mattis justo consectetur.'
                . ' Morbi efficitur, tortor non varius vulputate, massa urna fringilla erat,'
                . ' id varius ipsum lacus vel ex. Proin finibus pulvinar tortor, sit amet venenatis est finibus non.'
                . ' Aenean sit amet pulvinar leo. Donec et consequat dolor. Donec felis elit, rutrum in accumsan sit amet,'
                . ' volutpat aliquet enim.',
            ]);
            $this->new_post->addTranslation('fr', ['title' => 'Produits',
                'body' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.'
                . ' Mauris id ligula eget libero tristique hendrerit a fermentum enim.'
                . ' Duis dignissim nulla at lectus porta, a mattis justo consectetur.'
                . ' Morbi efficitur, tortor non varius vulputate, massa urna fringilla erat,'
                . ' id varius ipsum lacus vel ex. Proin finibus pulvinar tortor, sit amet venenatis est finibus non.'
                . ' Aenean sit amet pulvinar leo. Donec et consequat dolor. Donec felis elit, rutrum in accumsan sit amet,'
                . ' volutpat aliquet enim.',
            ]);
            $this->new_post->save();
            $this->entity_type = "node";
            $this->bundle = "contenu_laterale";
            $this->entity_def = \Drupal::entityManager()->getDefinition($this->entity_type);
            $this->data = file_get_contents("profiles/arvodia/modules/sdr_contact/doc/Introduction-to-the-web.pdf");
            $this->file = file_save_data($this->data, "public://src/Introduction-to-the-web.pdf", FILE_EXISTS_REPLACE);
            $this->new_node = [
                'uid' => 3,
                'title' => 'Our online catalog',
                'body' => 'Discover without delay our catalog 2017 in which you will find all our products'
                . '',
                'promote' => 0,
                'field_document' => [
                    'target_id' => $this->file->id(),
                    'alt' => 'Sample',
                    'title' => 'Sample File'
                ],
                $this->entity_def->get('entity_keys')['bundle'] => $this->bundle
            ];
            $this->new_post = \Drupal::entityManager()->getStorage($this->entity_type)->create($this->new_node);
            $this->new_post->addTranslation('ar', ['title' => 'فهرس على الانترنت',
                'body' => 'اكتشاف دون تأخير لدينا كتالوج 2017 التي سوف تجد جميع منتجاتنا',
            ]);
            $this->new_post->addTranslation('fr', ['title' => 'Notre catalogue en ligne',
                'body' => 'Découvrez sans plus tarder notre catalogue 2017 dans lequel vous trouverez la totalité de nos produits'
            ]);
            $this->new_post->save();
            $this->new_node = [
                'uid' => 3,
                'title' => 'Contact information',
                'body' => 'Fix/Fax : 213 00 00 00'
                . 'Mobile : 213 00 00 00'
                . 'Notre équipe vous'
                . 'répond de 08 h 00 à 22'
                . 'h 00, 7 jours sur 7.'
                ,
                $this->entity_def->get('entity_keys')['bundle'] => $this->bundle
            ];
            $this->new_post = \Drupal::entityManager()->getStorage($this->entity_type)->create($this->new_node);
            $this->new_post->addTranslation('ar', ['title' => 'معلومات الاتصال',
                'body' => 'Fix/Fax : 213 00 00 00'
                . 'Mobile : 213 00 00 00'
                . 'Notre équipe vous'
                . 'répond de 08 h 00 à 22'
                . 'h 00, 7 jours sur 7.'
                    ,
            ]);
            $this->new_post->addTranslation('fr', ['title' => 'Coordonnées de contact',
                'body' => 'Fix/Fax : 213 00 00 00'
                . 'Mobile : 213 00 00 00'
                . 'Notre équipe vous'
                . 'répond de 08 h 00 à 22'
                . 'h 00, 7 jours sur 7.'
                    ,
            ]);
            $this->new_post->save();
        }
        if (\Drupal::service('module_handler')->moduleExists('sdr_carousel')) {
            $this->data = file_get_contents("profiles/arvodia/modules/sdr_contact/sdr_carousel/img/1.png");
            $this->file = file_save_data($this->data, "public://src/1.png", FILE_EXISTS_REPLACE);
            $this->node = Node::create([
                        'type' => 'carousel',
                        'title' => 'Welcome',
                        'body' => 'to website...',
                        'uid' => 3,
                        'field_img_carousel' => [
                            'target_id' => $this->file->id(),
                            'alt' => 'Sample',
                            'title' => 'Sample File'
                        ],
            ]);
            $this->node->addTranslation('ar', ['title' => 'أهلا بك',
                'body' => 'إلى الموقع ...',
            ]);
            $this->node->addTranslation('fr', ['title' => 'Bienvenue',
                'body' => 'sur le site...'
            ]);
            $this->node->save();
            $this->data = file_get_contents("profiles/arvodia/modules/sdr_contact/sdr_carousel/img/2.png");
            $this->file = file_save_data($this->data, "public://src/2.png", FILE_EXISTS_REPLACE);
            $this->node = Node::create([
                        'type' => 'carousel',
                        'title' => 'Contact us',
                        'body' => 'We are listening to you',
                        'uid' => 3,
                        'field_img_carousel' => [
                            'target_id' => $this->file->id(),
                            'alt' => 'Sample',
                            'title' => 'Sample File'
                        ],
            ]);
            $this->node->addTranslation('ar', ['title' => 'اتصل بنا',
                'body' => 'نحن تحت تصرفكم',
            ]);
            $this->node->addTranslation('fr', ['title' => 'Contactez nous',
                'body' => 'Nous sommes à votre écoute'
            ]);
            $this->node->save();
            $this->data = file_get_contents("profiles/arvodia/modules/sdr_contact/sdr_carousel/img/3.png");
            $this->file = file_save_data($this->data, "public://src/3.png", FILE_EXISTS_REPLACE);
            $this->node = Node::create([
                        'type' => 'carousel',
                        'title' => 'Responsive design',
                        'body' => '',
                        'uid' => 3,
                        'field_img_carousel' => [
                            'target_id' => $this->file->id(),
                            'alt' => 'Sample',
                            'title' => 'Sample File'
                        ],
            ]);
            $this->node->addTranslation('ar', ['title' => 'الرسم المتجاوب',
                'body' => '',
            ]);
            $this->node->addTranslation('fr', ['title' => 'Conception réactive',
                'body' => ''
            ]);
            $this->node->save();
        }
        if (\Drupal::service('module_handler')->moduleExists('exlink')) {
            $this->data = file_get_contents("profiles/arvodia/modules/sdr_contact/exlink/img/google.com.ico");
            $this->file = file_save_data($this->data, "public://src/google.com.ico", FILE_EXISTS_REPLACE);
            $this->data = file_get_contents("profiles/arvodia/modules/sdr_contact/exlink/img/twitter.com.png");
            $this->file = file_save_data($this->data, "public://src/twitter.com.png", FILE_EXISTS_REPLACE);
            $this->data = file_get_contents("profiles/arvodia/modules/sdr_contact/exlink/img/default.png");
            $this->file = file_save_data($this->data, "public://src/default.png", FILE_EXISTS_REPLACE);
            $this->node = Node::create([
                        'type' => 'external_link',
                        'title' => 'Connect with us',
                        'field_external_link' => [
                            [
                                'uri' => 'http://www.youtube.com'
                            ],
                            [
                                'uri' => 'http://www.google.com'
                            ],
                            [
                                'uri' => 'http://www.twitter.com'
                            ],
                        ],
                        'uid' => 3,
            ]);
            $this->node->addTranslation('ar', ['title' => 'تواصل معنا',
            ]);
            $this->node->addTranslation('fr', ['title' => 'Connectez-vous avec nous',
            ]);
            $this->node->save();
            $this->node = Node::create([
                        'type' => 'external_link',
                        'title' => 'Partner',
                        'status' => false,
                        'uid' => 3,
            ]);
            $this->node->addTranslation('ar', ['title' => 'شريك',
            ]);
            $this->node->addTranslation('fr', ['title' => 'Partenaire',
            ]);
            $this->node->save();
            $this->node = Node::create([
                        'type' => 'external_link',
                        'title' => 'Favorits',
                        'field_external_link' => [
                            [
                                'uri' => 'https://www.drupal.org/'
                            ],
                            [
                                'uri' => 'http://getbootstrap.com/'
                            ],
                            [
                                'uri' => 'http://php.net/'
                            ],
                        ],
                        'uid' => 3,
            ]);
            $this->node->addTranslation('ar', ['title' => 'المفضلة',
            ]);
            $this->node->addTranslation('fr', ['title' => 'Favories',
            ]);
            $this->node->save();
        }
    }

}
