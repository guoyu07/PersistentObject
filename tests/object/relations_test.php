<?php
/**
 *
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 * 
 *   http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 *
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @version //autogentag//
 * @filesource
 * @package PersistentObject
 * @subpackage Tests
 */

/**
 * Tests the ezcPersistentObjecRelations class.
 *
 * @package PersistentObject
 * @subpackage Tests
 */
class ezcPersistentObjectRelationsTest extends ezcTestCase
{
    protected function setUp()
    {
    }

    protected function tearDown()
    {
    }

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( 'ezcPersistentObjectRelationsTest' );
    }

    public function testConstructureSuccess()
    {
        $relations = new ezcPersistentObjectRelations();
        $this->assertEquals(
            0,
            count( $relations )
        );
    }

    public function testArrayAccessSuccess()
    {
        $relations = new ezcPersistentObjectRelations();
        $relation = new ezcPersistentOneToManyRelation( 'foo', 'bar' );
        $relations['foo'] = $relation;

        $this->assertEquals(
            1,
            count( $relations )
        );
        $this->assertSame(
            $relation,
            $relations['foo']
        );
    }

    public function testArrayAccessFailure()
    {
        $relations = new ezcPersistentObjectRelations();

        $this->genericArrayAccessFailure(
            $relations,
            'foo',
            array(
                23, 23.42, true, "test", array(), new stdClass(),
            ),
            'ezcBaseValueException'
        );
        $this->genericArrayAccessFailure(
            $relations,
            23,
            array(
                new ezcPersistentOneToManyRelation( 'foo', 'bar' ),
            ),
            'ezcBaseValueException'
        );
    }

    public function testExchangeArraySuccess()
    {
        $relations = new ezcPersistentObjectRelations();
        $relations['foo'] = new ezcPersistentOneToManyRelation( 'foo', 'bar' );
        
        $this->assertEquals(
            1,
            count( $relations )
        );

        $relations->exchangeArray( array() );
        $this->assertEquals(
            0,
            count( $relations )
        );

        $relations->exchangeArray(
            array(
                'foo' => new ezcPersistentOneToManyRelation( 'foo', 'bar' ),
                'bar' => new ezcPersistentOneToManyRelation( 'foo', 'bar' ),
            )
        );
        $this->assertEquals(
            2,
            count( $relations )
        );
    }

    public function testExchangeArrayFailure()
    {
        $relations = new ezcPersistentObjectRelations();
        $relations['foo'] = new ezcPersistentOneToManyRelation( 'foo', 'bar' );
        
        $this->assertEquals(
            1,
            count( $relations )
        );

        try
        {
            $relations->exchangeArray(
                array( 'foo' => 23 )
            );
            $this->fail( 'ezcBaseValueException not thrown on invalid value in exchange array.' );
        }
        catch ( ezcBaseValueException $e ) {}

        try
        {
            $relations->exchangeArray(
                array( 23 => new ezcPersistentObjectProperty )
            );
            $this->fail( 'ezcBaseValueException not thrown on invalid offset in exchange array.' );
        }
        catch ( ezcBaseValueException $e ) {}
    }

    public function testSetFlagsSuccess()
    {
        $relations = new ezcPersistentObjectRelations();
        $relations->setFlags( 0 );
        $this->assertEquals(
            0,
            $relations->getFlags()
        );
    }

    public function testSetFlagsFailure()
    {
        $relations = new ezcPersistentObjectRelations();

        try
        {
            $relations->setFlags( 23 );
            $this->fail( 'ezcBaseValueException not thrown on flags different to 0.' );
        }
        catch ( ezcBaseValueException $e ) {}
        $this->assertEquals(
            0,
            $relations->getFlags()
        );
    }

    public function testAppendFailure()
    {
        $relations = new ezcPersistentObjectRelations();

        try
        {
            $relations[] = new ezcPersistentOneToManyRelation( 'foo', 'bar' );
            $this->fail( 'ezcBaseValueException not thrown on trying to append.' );
        }
        catch ( Exception $e ) {}
        $this->assertEquals(
            0,
            count( $relations )
        );
    }

    protected function genericArrayAccessFailure( ArrayAccess $relations, $offset, array $values, $exceptionClass )
    {
        foreach ( $values as $value )
        {
            try
            {
                $relations[$offset] = $value;
                $this->fail( $exceptionClass . ' not thrown on value ' . gettype( $value ) . ' for offset ' . $offset . ' in class ' . get_class( $relations ) . '.' );
            }
            catch ( Exception $e )
            {
                $this->assertEquals(
                    $exceptionClass,
                    get_class( $e ),
                    $exceptionClass . ' not thrown on value ' . gettype( $value ) . ' for offset ' . $offset . ' in class ' . get_class( $relations ) . ', ' . get_class( $e ) . ' thrown instead.'
                );
            }
        }
    }

}


?>
