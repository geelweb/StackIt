Data providers
==============

Built-in data providers
-----------------------

A data provider is an object used to push data into a stack.

Redis
^^^^^

The StackIt\Kvs\Redis data provider use the `phpredis`_ extension. This data provider require the following config entries

* **redis_host** The Redis server host
* **redis_port** The Redis server port

Example of configuration::

    ;; The Redis server host
    redis_host="127.0.0.1"

    ;; The Redis server port
    redis_port=6379

Dependances:

* A Redis server
* The `phpredis`_ extension

PRedis
^^^^^^

If you can not install the `phpredis`_ extension you can use the StackIt\Kvs\PRedis data processor which use the `predis`_ client. The required config entries are

* **redis_host** The Redis server host
* **redis_port** The Redis server port

Dependances:

* A Redis server
* The `predis`_ client

Create your own data provider
-----------------------------

This section is not done


.. _phpredis: https://github.com/nicolasff/phpredis
.. _predis: https://github.com/nrk/predis
