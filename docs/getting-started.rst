Getting Started
===============

Loading the library
------------------

Register the library using the Stackit\Autoloader object::

    require_once 'library/StackIt/Autoloader.php';
    StackIt\Autoloader::register();

Configure your stacks
---------------------

Create an ini config file to setup your first stack::

    ;; StackIt stack config for the stack "my-stack"
    [my-stack]

    ;; The key value store mapper to use
    kvs="StackIt\Kvs\Redis"

    ;; The processor implementation to use to process the stack
    processor="StackIt\Processor\PostgreSQL\CopyFromStdin"

    ;; Minimum interval between 2 iterations of the stack processor
    ;; (seconds) (0 to not define minimum interval, default 0)
    interval=30

    ;; Max number of execution of the stack processor in the same daemon
    ;; instance (0 if no limit, default 0)
    max_execution=2

Load your config::

    StackIt\Stack::setConfig('/path/to/config.ini');

You can replace the ini config file using a Php array::

    $config = array(
        'my-stack' => array(
            'kvs' => 'StackIt\Kvs\Redis',
            'processor' => 'StackIt\Processor\PostgreSQL\CopyFromStdin',
            'interval' => 30,
            'max_execution' => 2,
        ),
    );
    StackIt\Stack::setConfig($config);

Put in stack
------------

Now StackIt know your stacks, you can push data to it::

    StackIt\Stack::push('my-stack', array(
        'customer_id' => 123,
        'order_amount' => 59.99,
        'order_date' => date('Y-m-d H:i:s')
    ));

Consume stacks
--------------

Then in a cron job, for example, run the daemon to process the stacks::

    StackIt\Daemon::setConfig('/path/to/config.ini');
    $d = StackIt\Daemon::singleton();
    $d->run();

