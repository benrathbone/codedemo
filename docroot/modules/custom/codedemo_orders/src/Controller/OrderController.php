<?php

namespace Drupal\codedemo_orders\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\user\Entity\User;
use Drupal\codedemo_orders\Entity\OrderEntity;
use Drupal\node\Entity\Node;

/**
 * Class OrderController.
 */
class OrderController extends ControllerBase {

  /**
   *
   * Controller for the main task of this module. Gets current user and
   * node ID for a Meal content type from the {meal} parameter. Either creates
   * a new Order Entity for the user or returns the one they've already
   * submitted.
   *
   */
  public function edit($meal) {

    // Get Meal node from parameter.
    $meal_node = Node::load($meal);

    // Make sure we have a real node.
    if ($meal_node instanceof \Drupal\node\NodeInterface ) {

      // Get current user.
      $userCurrent = User::load(\Drupal::currentUser()->id());

      // Look up if the current user has already created an Order Entity
      // for this Meal node. If so, return it. If not, start a new one.
      $query = \Drupal::entityQuery('order_entity');
      $query->condition('field_customer', $userCurrent->id());
      $query->condition('field_meal', $meal);
      $order_results = $query->execute();
      $order_id = reset($order_results);
      if ($order_id) {
        $entity = OrderEntity::load($order_id);
      }
      else {
        $entity = OrderEntity::create();
      }

      // User the form_builder service to load a form from the entity.
      // Note that this uses the customer_order_form mode, which was used
      // to hide unneeded fields from the Customer user.
      $form = \Drupal::service('entity.form_builder')
        ->getForm($entity, 'customer_order_form');

      // In the form we present to the Customer, we must only show the options
      // set by the admin in the Meal node. This means removing all the other
      // options.
      // So:
      // 1. For each course, get the options that are saved in the Meal node
      //    and put into an array of Field Items.
      // 2. For each course, run a foreach to get just the option id, which is
      //    a taxonomy term id, into a simple array.
      // 3. For each course, on the form, go through each option and remove
      //    it, if it's not in the array of options we got from the Meal node.

      // 1. Get the options for each course saved in this Meal node.
      $starter_options = $meal_node->get('field_starter');
      $main_options = $meal_node->get('field_main');
      $dessert_options = $meal_node->get('field_desert');

      // 2. Get the Taxonomy terms for each course's options into an array.
      foreach($starter_options as $option) {
        $starter_options_array[] = $option->target_id;
      }
      foreach($main_options as $option) {
        $main_options_array[] = $option->target_id;
      }
      foreach($dessert_options as $option) {
        $dessert_options_array[] = $option->target_id;
      }

      // 3. Remove the options from the form.
      foreach($form['field_starter']['widget']['#options'] as $key=>$option) {
        if (!in_array($key, $starter_options_array)) {
          unset($form['field_starter']['widget'][$key]);
        }
      }
      foreach($form['field_main']['widget']['#options'] as $key=>$option) {
        if (!in_array($key, $main_options_array)) {
          unset($form['field_main']['widget'][$key]);
        }
      }
      foreach($form['field_dessert']['widget']['#options'] as $key=>$option) {
        if (!in_array($key, $dessert_options_array)) {
          unset($form['field_dessert']['widget'][$key]);
        }
      }

      // Don't show the publishing status field to the Customer.
      $form['status']['#access'] = FALSE;

      // Set the title of the form from the Meal's name.
      $form['#title'] = $meal_node->getTitle();

      return $form;
    }
    throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException();
  }
}
