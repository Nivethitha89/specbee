<?php

namespace Drupal\specbee\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure specbee settings for this site.
 */
class SpecbeeSettingsForm extends ConfigFormBase {

  /** 
   * Config settings.
   *
   * @var string
   */
  const SETTINGS = 'specbee.settings';

  /** 
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'specbee_admin_settings';
  }

  /** 
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      static::SETTINGS,
    ];
  }

  /** 
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config(static::SETTINGS);

    $form['country'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Country'),
      '#default_value' => $config->get('country') ? $config->get('country') : 'India',
    ];  

    $form['city'] = [
      '#type' => 'textfield',
      '#title' => $this->t('City'),
      '#default_value' => $config->get('city') ? $config->get('city') : 'Kolkata',
    ]; 
    
    $options = ['America/Chicago' => 'America/Chicago',
      'America/New_York' => 'America/New_York',
      'Asia/Tokyo' => 'Asia/Tokyo',
      'Asia/Dubai' => 'Asia/Dubai',
      'Asia/Kolkata' => 'Asia/Kolkata',
      'Europe/Amsterdam' => 'Europe/Amsterdam',
      'Europe/Oslo' => 'Europe/Oslo',
      'Europe/London' => 'Europe/London'];
    
    $form['timezone'] = [
      '#type' => 'select',
      '#title' => $this->t('Timezone'),
      '#default_value' => $config->get('timezone') ? $config->get('timezone') : 'Asia/Kolkata',
      '#options' => $options
    ]; 

    return parent::buildForm($form, $form_state);
  }

  /** 
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Retrieve the configuration.
    $this->config(static::SETTINGS)
      // Set the submitted configuration setting.
      ->set('timezone', $form_state->getValue('timezone'))
      // You can set multiple configurations at once by making
      // multiple calls to set().
      ->set('city', $form_state->getValue('city'))
      ->set('country', $form_state->getValue('country'))
      ->save();

    parent::submitForm($form, $form_state);
  }

}