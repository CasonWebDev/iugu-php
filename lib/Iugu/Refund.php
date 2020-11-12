<?php

class Iugu_Refund extends APIResource
{
  public function create($attributes = [])
  {
    $result = self::createAPI($attributes);
    if (!isset($result->success) && !isset($result->errors)) {
      $result->success = false;
    }
    return $result;
  }
}