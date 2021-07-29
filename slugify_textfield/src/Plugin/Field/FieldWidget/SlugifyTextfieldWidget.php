<?php

namespace Drupal\slugify_textfield\Plugin\Field\FieldWidget;

use Drupal\Core\Field\Annotation\FieldWidget;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'slugify_textfield' widget.
 *
 * @FieldWidget(
 *   id = "slugify_textfield",
 *   label = @Translation("Slugify Textfield widget"),
 *   field_types = {
 *     "slugify_textfield",
 *   },
 * )
 */
class SlugifyTextfieldWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function fieldSettingsForm(array $form, FormStateInterface $form_state) {

    $element = [];

    // The key of the element should be the setting name.
    $element['separator'] = [
      '#title' => $this->t('Separator'),
      '#type' => 'textfield',
      '#default_value' => $this->getSetting('separator'),
    ];

    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $value = isset($items[$delta]->value) ? $items[$delta]->value : '';
    $element += [
      '#type' => 'textfield',
      '#default_value' => $value,
      '#size' => 60,
      '#maxlength' => 255,
      '#element_validate' => [
        [$this, 'validate'],
      ],
    ];

    return ['value' => $element];
  }

}
