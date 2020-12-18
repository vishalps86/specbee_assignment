<?php

namespace Drupal\assignment\Services;

use Drupal\Core\Datetime\DrupalDateTime;

/**
 * Class CustomService.
 */
class CustomService {

  /**
   * Constructs a new CustomService object.
   */
  public function __construct() {

  }

  public function getServiceData() {
    $config = \Drupal::config('assignment.settings');

    $timezone = $config->get('timezone');

    $current_time = new DrupalDateTime('now', $timezone);	

    $time = $current_time->format('jS M Y - H:i A');

    return $time;
  }
  
}