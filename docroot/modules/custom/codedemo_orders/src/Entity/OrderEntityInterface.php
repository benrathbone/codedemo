<?php

namespace Drupal\codedemo_orders\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Order entities.
 *
 * @ingroup codedemo_orders
 */
interface OrderEntityInterface extends ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Order name.
   *
   * @return string
   *   Name of the Order.
   */
  public function getName();

  /**
   * Sets the Order name.
   *
   * @param string $name
   *   The Order name.
   *
   * @return \Drupal\codedemo_orders\Entity\OrderEntityInterface
   *   The called Order entity.
   */
  public function setName($name);

  /**
   * Gets the Order creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Order.
   */
  public function getCreatedTime();

  /**
   * Sets the Order creation timestamp.
   *
   * @param int $timestamp
   *   The Order creation timestamp.
   *
   * @return \Drupal\codedemo_orders\Entity\OrderEntityInterface
   *   The called Order entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Order published status indicator.
   *
   * Unpublished Order are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Order is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Order.
   *
   * @param bool $published
   *   TRUE to set this Order to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\codedemo_orders\Entity\OrderEntityInterface
   *   The called Order entity.
   */
  public function setPublished($published);

}
