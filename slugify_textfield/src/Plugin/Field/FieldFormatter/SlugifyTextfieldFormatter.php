<?php

namespace Drupal\slugify_textfield\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\Annotation\FieldFormatter;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Form\FormStateInterface;
use Cocur\Slugify\Slugify;

/**
 * Plugin implementation of the 'slugify_textfield' formatter.
 *
 * @FieldFormatter(
 *   id = "slugify_textfield",
 *   label = @Translation("Default"),
 *   field_types = {
 *     "slugify_textfield"
 *   }
 * )
 */
class SlugifyTextfieldFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
        'separator' => '-',
      ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $elements = parent::settingsForm($form, $form_state);
    $elements['separator'] = [
      '#type' => 'textfield',
      '#title' => t('Separator'),
      '#default_value' => $this->getSetting('separator'),
      '#description' => $this->t('The character(s) used to replace special characters.'),
      '#required' => FALSE,
    ];

    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];
    $summary[] = $this->t('Replaced special characters with a designated character.');

    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];

    // The ProcessedText element already handles cache context & tag bubbling.
    // @see \Drupal\filter\Element\ProcessedText::preRenderText()
    foreach ($items as $delta => $item) {
      $original_text = $this->t($item->value);

      /**
       * The character(s) that will replace special characters.
       *
       * @var $separator
       */
      $separator = $this->getSetting('separator') ?: '';

      $slugify = new Slugify();

      /**
       * The text that will be displayed on a rendered page.
       *
       * Special characters will be replaced with the $separator character(s).
       *
       * @var $output_text
       */
      $output_text = !empty($original_text) ?
        $slugify->slugify($original_text, $separator) :
        '';

      $elements[$delta] = [
        '#type' => 'processed_text',
        '#original_text' => $original_text,
        '#text' => $output_text,
        '#format' => $item->format,
        '#langcode' => $item->getLangcode(),
      ];
    }

    return $elements;
  }

}
