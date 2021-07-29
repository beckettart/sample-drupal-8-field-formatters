<?php

namespace Drupal\tooltip_textfield\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\Annotation\FieldFormatter;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\tooltip_textfield\Plugin\Field\FieldFormatter\Drupal\tooltip_textfield\TooltipTextfield;

/**
 * Plugin implementation of the 'tooltip_textfield' formatter.
 *
 * @FieldFormatter(
 *   id = "tooltip_textfield",
 *   label = @Translation("Default"),
 *   field_types = {
 *     "tooltip_textfield"
 *   }
 * )
 */
class TooltipTextfieldFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];
    $summary[] = $this->t('Create text that displays a tooltip when hovered over.');
    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $elements = parent::settingsForm($form, $form_state);

    $elements['tooltip_textfield'] = [
      '#type' => 'tooltip_textfield',
      '#format' => 'string',
      '#title' => $this->t('Text'),
      '#size' => 60,
      '#default_value' => $this->getSetting('tooltip_textfield'),
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
      $elements[$delta] = [
        '#type' => 'processed_text',
        '#text' => $this->t($item->value),
        '#format' => $item->format,
        '#langcode' => $item->getLangcode(),
      ];
    }

    return $elements;
  }

}
