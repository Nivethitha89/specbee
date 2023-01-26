<?php

namespace Drupal\specbee\Services;

use Drupal\Core\Config\ConfigFactoryInterface;

/**
 * Provides current time from timezone.
 */
class SpecbeeService {

  /**
   * Constructs a new SpecbeeService object.
   */
  public function __construct(ConfigFactoryInterface $config_factory) {
    $this->specbeeConfig = $config_factory->get('specbee.settings');
  }

  /**
   * Get Current time from selected timezone from configuration.
   */
  public function getCurrentTimeFromTimezone() {
    $timezone = $this->specbeeConfig->get('timezone');

    $now = new \DateTime('now', new \DateTimeZone($timezone));
    return $now->format('jS M Y - H:i A');
  }

}
