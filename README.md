# StackIt PHP library

Optimizes your fronts reducing database inserts

## Objectives

The first objectiv of the StackIt library is to reduce the number of "log" insert in
databases performing regularly a mass insert.

For example if, in a website,  you insert some logs like this when a page is
called

insert into my_log_table (something, something_else) values ('foo', 'bar');

We'll try to replace them doing periodicly something like this


insert into my_log_table (something, something_else) values
    ('foo', 'bar'),
    ('foo1', 'bar1'),
    ('foo2', 'bar2'),
    ('foo3', 'bar3'),
    ('foo4', 'bar4');

So to do this the first step is to replace the log insertion in database, by an
insertion on a key value store (like [Redis](http://redios.io)).

Then a daemon will periodicly insert in the database all the
entries stored in the kvs.

## Install

 * Download the archive files or checkout the source
 * Put it somewhere in yout path
 * Use it

## Examples

Set the config:

    StackIt\Stack::setConfig(array(
        'my-stack' => array(
            'kvs' => 'StackIt\Kvs\Redis',
            'processor' => 'StackIt\Processor\PostgreSQL\CopyFromStdin',
            'redis_host' => '127.0.0.1',
            'redis_port' => 6379,
        ),
    ));

Add data to the stack:

    StackIt\Stack::push('my-stack', array(
        'foo' => 'v1',
        'bar' => 'v2',
        'log_date' => date('Y-m-d H:i:s'),
    ));

Process the stack:

    StackIt\Daemon::singleton()->run();

