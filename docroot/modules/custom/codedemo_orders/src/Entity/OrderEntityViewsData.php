<?php

namespace Drupal\codedemo_orders\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for Order entities.
 */
class OrderEntityViewsData extends EntityViewsData {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    // Additional information for Views integration, such as table joins, can be
    // put here.

    return $data;
  }

}
