<?php

/**
 * @file
 * Contains order_entity.page.inc.
 *
 * Page callback for Order entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Order templates.
 *
 * Default template: order_entity.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_order_entity(array &$variables) {
  // Fetch OrderEntity Entity Object.
  $order_entity = $variables['elements']['#order_entity'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
