Data consumers
==============

Build-in data consumers
-----------------------

Console Exec
^^^^^^^^^^^^

Call exec for each item in the stack the log the output using the defined method.

Config options:

* **exec_log_method** The method to use to log the exec output, available values are

  * *syslog* Log in syslog
  * *file* Log in file
  * *none* do not log

* **exec_log_file** The path to the log file to use if log method is *file*

MySQL Insert
^^^^^^^^^^^^

The StackIt\Processor\Mysql\Insert provider perform an insert for each data in the stack

Dependances:

* MySQL database

Config options:

* **mysql_server** The MySQL server host
* **mysql_username** The MySQL username
* **mysql_password** The MySQL password
* **mysql_database** The database to use
* **mysql_insert_table** The table where insert the data
* **mysql_insert_columns** A coma separated list of columns name

Sample config::

    mysql_server=locahost
    mysql_username=foo
    mysql_password=bar
    mysql_database=mydb
    mysql_insert_table=order_log
    mysql_insert_columns=customer_id,order_amount,order_date

MySQL MassInsert
^^^^^^^^^^^^^^^^

The StackIt\Processor\MySQL\MassInsert provider will use the same config entries than the StackIt\Processor\MySQL\Insert but all the stacked data will be inserted in one query.

PostgreSQL Insert
^^^^^^^^^^^^^^^^^

The StackIt\Processor\PostgreSQL\Insert processor perform an insert query for each data in the stack

Dependances:

* PostgreSQL database

Config options:

* **pg_conn_str** The PostgreSQL connection string
* **pg_insert_table** The table where insert the stacked data
* **pg_insert_columns** The table columns

Config sample::

    pg_conn_str="dbname=dbtest"
    pg_insert_table="order_log"
    pg_insert_columns="customer_id,order_amount,order_date"

PostgreSQL copyFromStdin
^^^^^^^^^^^^^^^^^^^^^^^^

The StackIt\Processor\PostgreSQL\CopyFromStdin will store the stacked data in a PostgreSQL database using a "copy from stdin" method rather than many inserts.

Config options:

* **pg_conn_str** The PostgreSQL connection string
* **pg_insert_table** The table where insert the stacked data
* **pg_insert_columns** The table columns

Config sample::

    pg_conn_str="dbname=dbtest"
    pg_insert_table="order_log"
    pg_insert_columns="customer_id,order_amount,order_date"


