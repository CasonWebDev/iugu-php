<?php

class Iugu_Refund extends APIResource {

  const URL_REFUND_BASE = 'https://api.iugu.com/v1/invoices/' ;

  public static function create(Array $attributes)
  {

    return self::API()->request(
      'POST',
      self::URL_REFUND_BASE.$attributes['id'].'/refund',
      [$attributes['partial_value_refund_cents']]
    );
  }
}