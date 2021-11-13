<?php

namespace Leankoala\ApiClient\Repository\Entity;

use Leankoala\ApiClient\Repository\Repository;

/**
 * This class was created by the LeanApiBundle.
 *
 * All changes made in this file will be overwritten by the next create run.
 *
 * @created 2021-11-13
 */
class WebsocketRepository extends Repository  {

  /**
   * Return a websocket server with the room names for the given user.
   * @param {Object} args
   */
  public function getRooms($args)
  {
    $route = ['path' => 'websockets/rooms', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge([], $args);

    return $this->connection->send($route, $argList);
  }

  /**
   * Return all websocket server with the room names.
   * @param {Object} args
   */
  public function getAllRooms($args)
  {
    $route = ['path' => 'websockets/rooms/all', 'method' => 'POST', 'version' =>  1];
    $argList = array_merge([], $args);

    return $this->connection->send($route, $argList);
  }

}
