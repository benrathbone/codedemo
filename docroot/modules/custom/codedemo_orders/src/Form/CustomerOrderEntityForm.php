<?php

namespace Drupal\codedemo_orders\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\user\Entity\User;

/**
 * Form controller for Order edit forms.
 *
 * @ingroup codedemo_orders
 */
class CustomerOrderEntityForm extends OrderEntityForm {

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form = parent::buildForm($form, $form_state);
    $entity = $this->entity;

    // Set a hidden field with the node ID of the Meal. This is so the
    // save method knows which Meal to associate this Order Entity with.
    $parameters = \Drupal::routeMatch()->getParameters();
    $form['#meal_nid'] = array(
      '#type' => 'hidden',
      '#value' => $parameters->get('meal'),
    );
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {

    // Save the associations for this particular Order with the logged-in
    // user and which meal this is for.
    $entity = $this->getEntity();
    $entity->field_meal->target_id = $form['#meal_nid']['#value'];
    $userCurrent = User::load(\Drupal::currentUser()->id());
    $entity->field_customer->target_id = $userCurrent->id();

    // Publish the entity for the user.
    $entity->status->value = True;
    $entity->save();

    // Redirect back to the 'Your Meals' View.
    $form_state->setRedirect('view.your_meals_nodes.page_1');
  }
}

