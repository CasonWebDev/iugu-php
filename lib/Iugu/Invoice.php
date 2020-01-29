<?php

class Iugu_Invoice extends APIResource
{
    public static function create($attributes = [])
    {
        return self::createAPI($attributes);
    }

    public static function fetch($key)
    {
        return self::fetchAPI($key);
    }

    public static function fetchLogs($key)
    {
        return self::fetchLogsAPI($key, 'logs');
    }

    public static function update($attributes = [])
    {
        return self::updateAPI($attributes);
    }

    public function save()
    {
        return $this->saveAPI();
    }

    public static function delete($attributes = [])
    {
        return self::deleteAPI($attributes);
    }

    public function refresh()
    {
        return $this->refreshAPI();
    }

    public static function search($options = [])
    {
        return self::searchAPI($options);
    }

    public function customer()
    {
        if (!isset($this->customer_id)) {
            return false;
        }
        if (!$this->customer_id) {
            return false;
        }

        return Iugu_Customer::fetch($this->customer_id);
    }

    public static function email($attributes = [])
    {
        if ($attributes['id'] == null) {
            return false;
        }

        try {
            $response = self::API()->request(
                'POST',
                static::url($attributes['id']).'/send_email'
            );

            if (isset($response->errors)) {
                throw new IuguRequestException();
            }
        } catch (Exception $e) {
            return false;
        }

        return true;
    }

    public static function cancel($attributes = [])
    {
        if ($attributes['id'] == null) {
            return false;
        }

        try {
            $response = self::API()->request(
                'PUT',
                static::url($attributes['id']).'/cancel'
            );

            if (isset($response->errors)) {
                throw new IuguRequestException();
            }
        } catch (Exception $e) {
            return false;
        }

        return true;
    }

    public function refund()
    {
        if ($this->is_new()) {
            return false;
        }

        try {
            $response = self::API()->request(
                'POST',
                static::url($this).'/refund'
            );
            if (isset($response->errors)) {
                throw new IuguRequestException($response->errors);
            }
            $new_object = self::createFromResponse($response);
            $this->copy($new_object);
            $this->resetStates();
        } catch (Exception $e) {
            return false;
        }

        return true;
    }

    /*public static function duplicate($attributes = [])
    {

          if ($attributes['id'] == null) {
              return false;
          }

          try {
              $response = self::API()->request(
                  "POST",
                  static::url($attributes['id']) . "/duplicate"
              );

          } catch (Exception $e) {
              return false;
          }

      return $response;
    }  */
    public static function duplicate($options=[])
    {
        if ($options['id'] == null) {
            return false;
        }

        try {
            $response = self::API()->request(
                "POST",
                static::url($options['id']) . "/duplicate",
                $options
            );
            if (isset($response->errors)) {
                throw new IuguRequestException( $response->errors );
            }
            return self::createFromResponse($response);
        } catch (Exception $e) {
            return false;
        }
        return true;
    }


    public function capture()
    {
        if ($this->is_new()) {
            return false;
        }

        try {
            $response = self::API()->request(
                'POST',
                static::url($this).'/capture'
            );
            if (isset($response->errors)) {
                throw new IuguRequestException($response->errors);
            }
            $new_object = self::createFromResponse($response);
            $this->copy($new_object);
            $this->resetStates();
        } catch (Exception $e) {
            return false;
        }

        return true;
    }
}
