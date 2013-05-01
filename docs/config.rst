Configuration
=============

Each stack must be defined in the stacks config.

* **kvs** The key value store to use to store the data
* **processor** The processor to use to consume the data
* **interval** Minimum interval in seconds between two iterations of the stack processor
* **max_execution** Maximum number of execution of the processor in the same daemon instance

In addition each stack KVSs and processors come with their own config entries. Those entries are detailled in the relevant sections.


