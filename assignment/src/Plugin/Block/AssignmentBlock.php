<?php

namespace Drupal\assignment\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Cache\Cache;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\assignment\Services\CustomService;


/**
 * Provides a 'location' block.
 *
 * @Block(
 *   id = "site_location_block",
 *   admin_label = @Translation("Site Location block"),
 *   category = @Translation("Custom location block")
 * )
 */
class AssignmentBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * @var $time \Drupal\assignment\Services\CustomService
   */
  protected $time;

  /**
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   * @param array $configuration
   * @param string $plugin_id
   * @param mixed $plugin_definition
   *
   * @return static
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('assignment.custom_services')
    );
  }

   /**
   * @param array $configuration
   * @param string $plugin_id
   * @param mixed $plugin_definition
   * @param \Drupal\assignment\Services\CustomService $get_time
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, CustomService $get_time) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);    
    $this->time = $get_time;
  }


  /**
   * {@inheritdoc}
   */

  public function build() {

   	$current_time= $this->time->getServiceData();
    
   	$config = \Drupal::config('assignment.settings');

	  $city = $config->get('city');
	  $country = $config->get('country');

	  $location = $city.' '.$country;

	  return array(
      '#theme' => 'location',
      '#time' => $current_time,
      '#location' => $location,      
      
      /*'#cache' => array(
          'tags' => $this->getCacheTags(),          
        ),*/      
    );    
  }


  public function getCacheTags() {
    $current_time = $this->time->getServiceData();
    return Cache::mergeTags(parent::getCacheTags(), array($current_time));  
  }
 
}