<?php

class StackTest extends PHPUnit_Framework_TestCase
{
    public function testSetGetConfig()
    {
        $cfg = array(
            'my-stack' => array(
                'kvs' => 'MyKvs',
            ),
        );

        StackIt\Stack::setConfig($cfg);
        $this->assertEquals($cfg, StackIt\Stack::getConfig());
        $this->assertEquals($cfg['my-stack'], StackIt\Stack::getConfig('my-stack'));
        $this->assertEquals($cfg, StackIt\Stack::getConfig('foo'));

        $ini = tempnam('/tmp', 'foo');
        file_put_contents($ini, "[my-stack]\nkvs=MyKvs");

        StackIt\Stack::setConfig($ini);
        $this->assertEquals($cfg, StackIt\Stack::getConfig());
        $this->assertEquals($cfg['my-stack'], StackIt\Stack::getConfig('my-stack'));
        $this->assertEquals($cfg, StackIt\Stack::getConfig('foo'));

        $this->assertEquals(array_keys($cfg), StackIt\Stack::getStacksIds());
    }

    public function testFactory()
    {
        $cfg = array(
            'my-stack' => array(
                'kvs' => 'MyKvs',
            ),
            'my-second-stack' => array(
                'kvs' => 'MyKvs',
            ),
            'foo' => array(),
            'wiz' => array(
                'kvs' => 'wiz',
            ),
        );
        StackIt\Stack::setConfig($cfg);
        $o = StackIt\Stack::factory('my-stack');
        $this->assertInstanceOf('MyKvs', $o);
        StackIt\Stack::push('my-stack', 'oups');

        $o2 = StackIt\Stack::factory('my-stack');
        $this->assertSame($o, $o2);

        $o3 = StackIt\Stack::factory('my-second-stack');
        $this->assertInstanceOf('MyKvs', $o3);

        try {
            $o4 = StackIt\Stack::factory('bar');
            $this->fail('An expected exception has not been raised');
        } catch (StackIt\Exception $e) {
        }

        try {
            $o5 = StackIt\Stack::factory('foo');
            $this->fail('An expected exception has not been raised');
        } catch (StackIt\Exception $e) {
        }

        try {
            $o5 = StackIt\Stack::factory('wiz');
            $this->fail('An expected exception has not been raised');
        } catch (StackIt\Exception $e) {
        }
    }

    public function testPush()
    {
        $cfg = array(
            'foo' => array(
                'kvs' => 'MyKvs',
            ),
        );

        StackIt\Stack::setConfig($cfg);
        StackIt\Stack::push('foo', 'bar');
        StackIt\Stack::push('foo', 'wiz');

        $o = MyKvs::singleton($cfg['foo']);
        $this->assertEquals(array('bar', 'wiz'), $o->pop('foo'));
    }

    public function testProcess()
    {
        $cfg = array(
            'stack' => array(
                'kvs' => 'MyKvs',
                'processor' => 'MyProc',
            ),
            'wiz' => array(
                'kvs' => 'MyKvs',
            ),
        );

        StackIt\Stack::setConfig($cfg);
        try {
            StackIt\Stack::process('bar');
            $this->fail('An expected exception has not been raised');
        } catch (Exception $e) {
        }

        try {
            StackIt\Stack::process('wiz');
            $this->fail('An expected exception has not been raised');
        } catch (Exception $e) {
        }

        StackIt\Stack::push('stack', 'bar');
        StackIt\Stack::push('stack', 'wiz');
        $r = StackIt\Stack::process('stack');
        $this->assertEquals(array('bar', 'wiz'), $r);
    }
}

class MyKvs extends StackIt\Kvs\AKvs implements StackIt\Kvs\IKvs
{
    public $stacks;

    protected function _initCli()
    {
        $this->stacks = array();
    }

    public function push($id, $value)
    {
        if (!isset($this->stacks[$id])) {
            $this->stacks[$id] = array();
        }

        $this->stacks[$id][] = $value;
    }

    public function pop($id)
    {
        if (!isset($this->stacks[$id])) {
            return array();
        }

        return $this->stacks[$id];
    }
}

class MyProc extends StackIt\Processor\AProcessor implements StackIt\Processor\IProcessor
{
    public function process($items)
    {
        return $items;
    }
}
