<?php

/**
 * @file
 * Contains codedemo_orders\codedemo_orders.views.inc..
 * Provide a custom views field data that isn't tied to any other module. */

use Drupal\Component\Utility\NestedArray;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Entity\Sql\SqlContentEntityStorage;
use Drupal\Core\Render\Markup;
use Drupal\field\FieldConfigInterface;
use Drupal\field\FieldStorageConfigInterface;
use Drupal\system\ActionConfigEntityInterface;

/**
* Implements hook_views_data().
*/
function codedemo_orders_views_data() {

    $data['views']['table']['group'] = t('Custom Global');
    $data['views']['table']['join'] = [
      // #global is a special flag which allows a table to appear all the time.
      '#global' => [],
    ];


    $data['views']['customer_order_views_field'] = [
        'title' => t('Customer Order Views Field'),
        'help' => t('My awesome custom views field plugin.'),
        'field' => [
            'id' => 'customer_order_views_field',
        ],
    ];

    return $data;
}
