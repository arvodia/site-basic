<?php

/**
 * @agency      : EURL ARVODIA
 * @author      : SS.Redouane
 * @email       : arvodia@hotmail.com
 * @project     : Uzin à Site
 * @Date        : 2017/2018
 */

namespace Drupal\sdr_contact;

use Drupal\node\Entity\Node;
use Drupal\comment\Entity\Comment;

class SdrNotification {

    private static function RenderMarkup($texthtml, $i, $c = 0) {
        return \Drupal\filter\Render\FilteredMarkup::create(htmlentities(
                                $texthtml)
                        . (($i) ?
                        '<span class="badge '
                        . ((\Drupal::languageManager()->getCurrentLanguage()->getId() == 'ar') ? 'pull-left' : '') .
                        ' glyphicon glyphicon-bell">' . $i . '</span> ' : '')
                        . (($c) ?
                        '<span class="badge '
                        . ((\Drupal::languageManager()->getCurrentLanguage()->getId() == 'ar') ? 'pull-left' : '') .
                        ' glyphicon glyphicon-comment">' . $c . '</span> ' : '')
        );
    }

    public static function allcontent($titre) {
        $i = 0;
        foreach (Node::loadMultiple(\Drupal::entityQuery('node')
                        ->condition('type', 'messager', '<>')
                        ->condition('type', 'commentaire_supprime', '<>')
                        ->execute()) as $node) {
            if ((!history_read($node->id())) || (($node->get('changed')->value) > history_read($node->id())))
                $i++;
        }
        if (!$i)
            return $titre;
        else
            return self::RenderMarkup($titre, $i);
    }

    public static function owncontent($titre) {
        $i = 0;
        $c = 0;
        foreach (Node::loadMultiple(\Drupal::entityQuery('node')
                        ->condition('type', 'article')
                        ->condition('uid', \Drupal::currentUser()->id())
                        ->execute()) as $node) {
            if ((!history_read($node->id())) || (($node->get('changed')->value) > history_read($node->id())))
                $i++;
            foreach (Comment::loadMultiple(\Drupal::entityQuery('comment')
                            ->condition('comment_type', 'comment', '=', \Drupal::languageManager()->getCurrentLanguage()->getId())
                            ->condition('status', 1)
                            ->condition('entity_id', $node->id())
                            ->execute()) as $com) {
                if ((!history_read($node->id())) || (($com->get('changed')->value) > history_read($node->id())))
                    $c++;
            }
        }
        if (!$i && !$c)
            return $titre;
        else
            return self::RenderMarkup($titre, $i, $c);
    }

    public static function messager($titre) {
        $i = 0;
        foreach (Node::loadMultiple(\Drupal::entityQuery('node')
                        ->condition('type', 'messager')
                        ->condition('status', 1)
                        ->condition('field_recipient', \Drupal::currentUser()->id())
                        ->execute()) as $node) {
            if ((!history_read($node->id())) || (($node->get('changed')->value) > history_read($node->id())))
                $i++;
        }
        if (!$i)
            return $titre;
        else
            return self::RenderMarkup($titre, $i);
    }

    public static function noapprove($titre) {
        $i = 0;
        foreach (Comment::loadMultiple(\Drupal::entityQuery('comment')
                        ->condition('comment_type', 'comment')
                        ->condition('status', 0)
                        ->execute()) as $node) {
            if ((!history_read($node->id())) || (($node->get('changed')->value) > history_read($node->id())))
                $i++;
        }
        if (!$i)
            return $titre;
        else
            return self::RenderMarkup($titre, $i);
    }

    public static function deleted($titre) {
        $i = 0;
        foreach (Node::loadMultiple(\Drupal::entityQuery('node')
                        ->condition('type', 'commentaire_supprime')
                        ->execute()) as $node) {
            if ((!history_read($node->id())) || (($node->get('changed')->value) > history_read($node->id())))
                $i++;
        }
        if (!$i)
            return $titre;
        else
            return self::RenderMarkup($titre, $i);
    }

}
