<?php

namespace Drupal\specbee\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'specbee' Block.
 *
 * @Block(
 *   id = "specbee_block",
 *   admin_label = @Translation("specbee block"),
 *   category = @Translation("Specbee"),
 * )
 */
class SpecbeeBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * Creates an instance of plugin.
   *
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   *   A container.
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   *
   * @return static
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('config.factory'),
      $container->get('specbee.services')
      );
  }

  /**
   * {@inheritdoc}
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, ConfigFactoryInterface $config, $specbee_service) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->config = $config;
    $this->specbeeService = $specbee_service;
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheMaxAge() {
    return 0;
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $config = $this->config->get('specbee.settings');
    $country = $config->get('country');
    $city = $config->get('city');
    $currentTime = $this->specbeeService->getCurrentTimeFromTimezone();
    return [
      '#theme' => 'specbee_block',
      '#time' => $currentTime,
      '#country' => $country,
      '#city' => $city,
    ];
  }

}
