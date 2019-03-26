<?php

namespace Drupal\codedemo_orders\Plugin\views\field;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Utility\Random;
use Drupal\views\Plugin\views\field\FieldPluginBase;
use Drupal\views\ResultRow;
use Drupal\user\Entity\User;
use Drupal\Core\Link;
use Drupal\Core\Url;


/**
 * A handler to provide a field that is completely custom by the administrator.
 *
 * @ingroup views_field_handlers
 *
 * @ViewsField("customer_order_views_field")
 */
class CustomerOrderViewsField extends FieldPluginBase {

  /**
   * {@inheritdoc}
   */
  public function usesGroupBy() {
    return FALSE;
  }

  /**
   * {@inheritdoc}
   */
  public function query() {
    // Do nothing -- to override the parent query.
  }

  /**
   * {@inheritdoc}
   */
  protected function defineOptions() {
    $options = parent::defineOptions();

    $options['hide_alter_empty'] = ['default' => FALSE];
    return $options;
  }

  /**
   * {@inheritdoc}
   */
  public function buildOptionsForm(&$form, FormStateInterface $form_state) {
    parent::buildOptionsForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function render(ResultRow $values) {

    // Simple check for the current user to alter the text in the table
    // to specify which orders the user needs to complete.
    $userCurrent = User::load(\Drupal::currentUser()->id());
    $node = $values->_entity;

    $query = \Drupal::entityQuery('order_entity');
    $query->condition('field_customer', $userCurrent->id());
    $query->condition('field_meal', $node->id());
    $order_results = $query->execute();
    $order_id = reset($order_results);

    if ($order_id) {
      $link = Link::fromTextAndUrl('Edit your order for this meal', Url::fromRoute('codedemo_orders.order_controller_edit', ['meal' => $node->id()]));
    }
    else {
      $link = Link::fromTextAndUrl('Don\'t go hungry! Place an order for this meal', Url::fromRoute('codedemo_orders.order_controller_edit', ['meal' => $node->id()]));
    }
   return $link->toRenderable();
  }
}
