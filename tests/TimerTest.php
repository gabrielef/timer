<?php
use gabrielef\Timer;
use PHPUnit\Framework\TestCase;

final class TimerTest extends TestCase
{
    public function testTimerIsStarted()
    {
        $t = new Timer();
        $t1 = $t->start('t1');

        $this->assertInstanceOf(DateTime::class, $t1);
    }

    public function testKeyList()
    {
        $t = new Timer();
        $this->assertIsArray($t->list());

        $t->start('abc');
        $this->assertIsArray($t->list());
    }

    public function testKeyListCount()
    {
        $t = new Timer();
        $this->assertCount(0, $t->list());
        $this->assertEquals([], $t->list());

        $t->start('a');
        $this->assertCount(1, $t->list());
        $this->assertEquals(['a'], $t->list());

        $t->start('b');
        $this->assertCount(2, $t->list());
        $this->assertEquals(['a', 'b'], $t->list());

        $t->end('b');
        $this->assertCount(1, $t->list());
        $this->assertEquals(['a'], $t->list());
    }

    public function testHas()
    {
        $t = new Timer();
        $this->assertFalse($t->has('a'));

        $t->start('a');
        $this->assertTrue($t->has('a'));

        $t->start('b');
        $this->assertTrue($t->has('b'));
        $this->assertTrue($t->has('a'));
    }

    public function testLook()
    {
        $d = 0.1;
        $t = new Timer();

        $t->start('a', 2);
        $t->start('b', 2);

        $this->assertEqualsWithDelta(0, $t->look('a'), $d);

        time_nanosleep(0, 500000000);
        $this->assertEqualsWithDelta(0.5, $t->look('a'), $d);

        time_nanosleep(0, 500000000);
        $this->assertEqualsWithDelta(1, $t->look('a'), $d);
        $this->assertEqualsWithDelta(1, $t->look('b'), $d);
    }

    public function testEnd()
    {
        $d = 0.1;
        $t = new Timer();

        $t->start('a', 2);
        $t->start('b', 2);

        time_nanosleep(0, 500000000);
        $this->assertEqualsWithDelta(0.5, $t->end('a'), $d);
        $this->assertEquals(['b',], $t->list());
        
        time_nanosleep(0, 500000000);
        $this->assertEqualsWithDelta(1, $t->end('b'), $d);
        $this->assertEquals([], $t->list());
    }

    public function testClear()
    {
        $t = new Timer();

        $t->start('a');
        $t->start('b');
        $t->start('c');

        $t->clear('a');
        $this->assertEquals(['b', 'c'], $t->list());

        $t->clear('b');
        $this->assertEquals(['c'], $t->list());

        $t->clear('c');
        $this->assertEquals([], $t->list());
    }
}
