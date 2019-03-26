<?php

namespace Drupal\codedemo_orders;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Order entity.
 *
 * @see \Drupal\codedemo_orders\Entity\OrderEntity.
 */
class OrderEntityAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\codedemo_orders\Entity\OrderEntityInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished order entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published order entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit order entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete order entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add order entities');
  }

}
