<?php

require 'vendor/autoload.php';

require_once 'UserTableWrapper.php';

use PHPUnit\Framework\TestCase;

class UserTableWrapperTest extends TestCase
{
    public function providerInsert()
    {
        return [
            [['name' => 'Alice', 'email' => 'alice@example.com']],
            [['name' => 'Bob', 'email' => 'bob@example.com']],
        ];
    }

    public function providerUpdate()
    {
        return [
            [0, ['name' => 'Alice Updated', 'email' => 'alice_updated@example.com']],
            [1, ['name' => 'Bob Updated', 'email' => 'bob_updated@example.com']],
        ];
    }

    public function providerDelete()
    {
        return [
            [0],
            [1],
        ];
    }

    public function testInsert()
    {
        $table = new UserTableWrapper();
        foreach ($this->providerInsert() as $values) {
            $table->insert($values[0]);
        }
        $this->assertCount(2, $table->get());
    }

    /**
     * @dataProvider providerUpdate
     */
    public function testUpdate($id, $values)
    {
        $table = new UserTableWrapper();
        $table->insert(['name' => 'Alice', 'email' => 'alice@example.com']);
        $table->insert(['name' => 'Bob', 'email' => 'bob@example.com']);
        
        $updatedRow = $table->update($id, $values);
        $this->assertEquals($values, $updatedRow);
    }

    /**
     * @dataProvider providerDelete
     */
    public function testDelete($id)
    {
        $table = new UserTableWrapper();
        $table->insert(['name' => 'Alice', 'email' => 'alice@example.com']);
        $table->insert(['name' => 'Bob', 'email' => 'bob@example.com']);
        
        $table->delete($id);
        $this->assertCount(1, $table->get());
    }

    public function testGet()
    {
        $table = new UserTableWrapper();
        $table->insert(['name' => 'Alice', 'email' => 'alice@example.com']);
        $table->insert(['name' => 'Bob', 'email' => 'bob@example.com']);

        $result = $table->get();
        $this->assertCount(2, $result);
    }
}