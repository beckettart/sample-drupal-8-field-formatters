<?php

namespace Drupal\rot13_textfield\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\Annotation\FieldFormatter;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\rot13_textfield\ROT13Textfield;

/**
 * Plugin implementation of the 'rot13_textfield' formatter.
 *
 * @FieldFormatter(
 *   id = "rot13_textfield",
 *   label = @Translation("Default"),
 *   field_types = {
 *     "rot13_textfield"
 *   }
 * )
 */
class ROT13TextfieldFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];
    $summary[] = $this->t('Applies the ROT13 filter to custom text.');
    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $elements = parent::settingsForm($form, $form_state);

    $elements['rot13_textfield'] = [
      '#type' => 'rot13_textfield',
      '#format' => 'string',
      '#title' => $this->t('Text'),
      '#size' => 60,
      '#default_value' => $this->getSetting('rot13_textfield'),
    ];

    return $elements;
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
       * The text that will be displayed on the rendered page.
       *
       * @var $output_text
       */
      $output_text = !empty($original_text) ?
        ROT13Textfield::covertToRot13($original_text) :
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
