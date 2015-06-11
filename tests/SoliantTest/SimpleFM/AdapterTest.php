<?php

/**
 * This source file is subject to the MIT license that is bundled with this package in the file LICENSE.txt.
 *
 * @package   Soliant\SimpleFM
 * @copyright Copyright (c) 2007-2015 Soliant Consulting, Inc. (http://www.soliantconsulting.com)
 * @author    jsmall@soliantconsulting.com
 */

namespace SoliantTest\SimpleFM;

use Soliant\SimpleFM\Adapter;
use Soliant\SimpleFM\Loader\Mock;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2013-02-16 at 22:32:15.
 */
class AdapterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Adapter
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $params=array('hostname'=>'localhost','dbname'=>'testdb','username'=>'Admin','password'=>'');
        $this->object = new Adapter($params, new Mock());
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {

    }

    /**
     * @covers Soliant\SimpleFM\Adapter::setHostParams
     */
    public function testSetHostParams()
    {
        $params=array('hostname'=>'127.0.0.1','dbname'=>'testdb','username'=>'root','password'=>'soliant');
        $value = $this->object->setHostParams($params);
        $this->assertTrue($value instanceof $this->object);
        $this->assertEquals($this->object->getHostname(), '127.0.0.1');
        $this->assertEquals($this->object->getDbname(), 'testdb');
        $this->assertEquals($this->object->getUsername(), 'root');
        $this->assertEquals($this->object->getPort(), '80');
        $this->assertEquals($this->object->getProtocol(), 'http');

        $params=array('port'=>'9000','protocol'=>'https');
        $value = $this->object->setHostParams($params);
        $this->assertEquals($this->object->getPort(), '9000');
        $this->assertEquals($this->object->getProtocol(), 'https');

        $params=array('protocol'=>'xyz');
        $this->setExpectedException('InvalidArgumentException');
        $value = $this->object->setHostParams($params);
    }

    /**
     * @covers Soliant\SimpleFM\Adapter::setCredentials
     */
    public function testSetCredentials()
    {
        $params=array('username'=> 'root' , 'password'=>'soliant');
        $value = $this->object->setCredentials($params);
        $this->assertTrue($value instanceof $this->object);
        $this->assertEquals($this->object->getUsername(), 'root');
    }

    /**
     * @covers Soliant\SimpleFM\Adapter::setCallParams
     */
    public function testSetCallParams()
    {
        $params=array('layoutname'=> 'tab' , 'commandstring'=>'soliant=consulting');
        $value = $this->object->setCallParams($params);
        $this->assertTrue($value instanceof $this->object);
        $this->assertEquals($this->object->getLayoutname(), 'tab');
        $this->assertEquals($this->object->getCommandstring(), 'soliant=consulting');
    }

    /**
     * @covers Soliant\SimpleFM\Adapter::getHostname
     */
    public function testGetSetHostname()
    {
        $test = $this->object->setHostname('127.0.0.1');
        $this->assertTrue($test instanceof $this->object);
        $this->assertEquals($this->object->getHostname(), '127.0.0.1');
    }


    /**
     * @covers Soliant\SimpleFM\Adapter::getUsername
     */
    public function testGetSetUsername()
    {

        $test=$this->object->setUsername('root');
        $this->assertTrue($test instanceof $this->object);
        $this->assertEquals($this->object->getUsername(), 'root');
    }

    /**
     * @covers Soliant\SimpleFM\Adapter::setPassword
     */
    public function testSetPassword()
    {
        $value = $this->object->setpassword("Soliant");
        $this->assertTrue($value instanceof $this->object);
    }

    /**
     * @covers Soliant\SimpleFM\Adapter::setDbname
     * @covers Soliant\SimpleFM\Adapter::getDbname
     */
    public function testGetSetDbname()
    {
        $test = $this->object->setDbname('test');
        $this->assertTrue($test instanceof $this->object);
        $this->assertEquals($this->object->getDbname(), 'test');
    }

    /**
     * @covers Soliant\SimpleFM\Adapter::setLayoutname
     * @covers Soliant\SimpleFM\Adapter::getLayoutname
     */
    public function testGetSetLayoutname()
    {
        $value = $this->object->setLayoutname('tab');
        $this->assertTrue($value instanceof $this->object);
        $this->assertEquals($this->object->getLayoutname(), 'tab');
    }

    /**
     * @covers Soliant\SimpleFM\Adapter::setCommandstring
     * @covers Soliant\SimpleFM\Adapter::getCommandstring
     */
    public function testGetSetCommandstring()
    {
        $value = $this->object->setCommandstring('A=B&C=D&E=F');
        $this->assertTrue($value instanceof $this->object);
        $this->assertEquals($this->object->getCommandstring(), 'A=B&C=D&E=F');
    }

    /**
     * @covers Soliant\SimpleFM\Adapter::setCommandarray
     * @covers Soliant\SimpleFM\Adapter::getCommandarray
     * @covers Soliant\SimpleFM\Adapter::getCommandstring
     */
    public function testGetSetCommandarray()
    {
        $commandString = 'A=0&C=D';
        $value = $this->object->setCommandstring($commandString);
        $this->assertTrue($value instanceof $this->object);
        $arr = $this->object->getCommandarray();
        $arr1=array('A' => 0,
                    'C' => 'D');
        $this->assertEquals($arr, $arr1);
        $this->assertEquals($commandString, $this->object->getCommandstring());

        // Thanks @garak for https://github.com/soliantconsulting/SimpleFM/pull/32
        $this->object->setCommandarray($arr1);
        $this->assertEquals($commandString, $this->object->getCommandstring());
    }

    /**
     * @covers Soliant\SimpleFM\Adapter::setProtocol
     * @covers Soliant\SimpleFM\Adapter::getProtocol
     */
    public function testGetSetProtocol()
    {
         $value = $this->object->setProtocol('https');
         $this->assertTrue($value instanceof $this->object);
         $this->assertEquals($this->object->getProtocol(), 'https');
    }

    /**
     * @covers Soliant\SimpleFM\Adapter::setSslverifypeer
     * @covers Soliant\SimpleFM\Adapter::getSslverifypeer
     */
    public function testGetSetSslverifypeer()
    {
         $this->assertEquals($this->object->getSslverifypeer(), true);
         $value = $this->object->setSslverifypeer(false);
         $this->assertTrue($value instanceof $this->object);
         $this->assertEquals($this->object->getSslverifypeer(), false);
    }

    /**
     * @covers Soliant\SimpleFM\Adapter::setPort
     * @covers Soliant\SimpleFM\Adapter::getPort
     */
    public function testGetSetPort()
    {
        $value=$this->object->setPort('8080');
        $this->assertTrue($value instanceof $this->object);
        $this->assertEquals($this->object->getPort(), '8080');
    }

    /**
     * @covers Soliant\SimpleFM\Adapter::setRowsbyrecid
     * @covers Soliant\SimpleFM\Adapter::getRowsbyrecid
     */
    public function testGetSetRowsbyrecid()
    {
        $value = $this->object->setRowsbyrecid('1876612984689092');
        $this->assertTrue($value instanceof $this->object);
        $this->assertEquals($this->object->getRowsbyrecid(), true);
    }

    /**
     * @covers Soliant\SimpleFM\Adapter::setSetCommandURLDebug
     * @covers Soliant\SimpleFM\Adapter::getSetCommandURLDebug
     */
    public function testGetSetCommandURLDebug()
    {
         $commandURL = '$http://root@127.0.0.1:8080./abc/fmresult.xml?-db=testdb&-lay=tab&A=B&C=D&E=F';
         $value = $this->object->setCommandURLdebug($commandURL);
         $this->assertTrue($value instanceof $this->object);
         $this->assertEquals($this->object->getCommandURLdebug(), $commandURL);
    }

    /**
     * @covers Soliant\SimpleFM\Adapter::execute
     * @todo Write more assertions for testExecute which exercise un-covered parser edge cases
     */
    public function testExecute()
    {
        $file = dirname(__FILE__) . '/TestAssets/projectsampledata.xml';
        $mockLoader = $this->object->getLoader();
        $mockLoader->setTestXml(file_get_contents($file));

        // return three records
        $result = $this->object->execute();

        $this->assertEquals($result['count'], 3);


        // parsed with rowsbyrecid TRUE
        $this->object->setRowsbyrecid(true);
        $result = $this->object->execute();

        $taskNameField = $result['rows'][7676]['Tasks']['rows'][15001]['Task Name'];
        $this->assertEquals($taskNameField, 'Review mock ups');


        // parsed with rowsbyrecid FALSE (the default behavior)
        $this->object->setRowsbyrecid(false);
        $result = $this->object->execute();

        $nonRepeatingField = $result['rows'][0]['Status'];
        $this->assertEquals($nonRepeatingField, '4');
        $this->assertInternalType('string', $nonRepeatingField);
        $this->assertNotInternalType('array', $nonRepeatingField);

        $repeatingField = $result['rows'][0]['Repeating Field'];
        $this->assertInternalType('array', $repeatingField);
        $this->assertNotInternalType('string', $repeatingField);

        $taskNameField = $result['rows'][1]['Tasks']['rows'][2]['Task Name'];
        $this->assertEquals($taskNameField, 'Complete sketches');
        $this->assertInternalType('string', $taskNameField);
        $this->assertNotInternalType('array', $taskNameField);

        $taskRepeatingField = $result['rows'][1]['Tasks']['rows'][2]['Repeating Field'];
        $this->assertInternalType('array', $taskRepeatingField);
        $this->assertNotInternalType('string', $taskRepeatingField);

    }

    /**
     * @covers Soliant\SimpleFM\Adapter::execute
     * test parse execution with parseFmResultSet()
     */
    public function testExecuteWithParseFmResultSet()
    {
        $file = dirname(__FILE__) . '/TestAssets/sample_fmresultset.xml';
        $mockLoader = $this->object->getLoader();
        $mockLoader->setTestXml(file_get_contents($file));

        $this->object->useResultsetGrammar();
        $result = $this->object->execute();

        $this->assertContains('fmresultset', $result);
    }

    /**
     * @covers Soliant\SimpleFM\Adapter::execute
     * test parse execution for parseFmpXmlLayout()
     */
    public function testExecuteWithParseFmpXmlLayout()
    {
        $file = dirname(__FILE__) . '/TestAssets/sample_fmpxmllayout.xml';
        $mockLoader = $this->object->getLoader();
        $mockLoader->setTestXml(file_get_contents($file));

        $this->object->useLayoutGrammar();
        $result = $this->object->execute();

        $this->assertContains('FMPXMLLAYOUT', $result);
    }

    /**
     * @covers Soliant\SimpleFM\Adapter::execute
     * test parse execution with different values for rowsbyrecid
     */
    public function testExecuteWithIndexing()
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Soliant\SimpleFM\Adapter::execute
     * test parse execution with 2 identical portals on the same layout
     */
    public function testExecuteWithNonUniquePortalsOnSameLayout()
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Soliant\SimpleFM\Adapter::execute
     * test parse execution with invalid field names
     */
    public function testExecuteWithInvalidFieldName()
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Soliant\SimpleFM\Adapter::displayXmlError
     */
    public function testDisplayXmlError()
    {
        $file = dirname(__FILE__) . '/TestAssets/invalid.xml';
        libxml_use_internal_errors(true);
        $xml = simplexml_load_file($file);
        $errors = libxml_get_errors();
        $string = '
----------------------------------------------^
Fatal Error 76: Opening and ending tag mismatch: titles line 4 and title
  Line: 4
  Column: 46
  File: ' . dirname(__FILE__) . '/TestAssets/invalid.xml

--------------------------------------------

';
        foreach ($errors as $error) {
            $this->assertEquals($this->object->displayXmlError($error, $xml), $string);
        }
    }


    /**
     * @covers Soliant\SimpleFM\Adapter::extractErrorFromPhpMessage
     */
    public function testExtractErrorFromPhpMessage()
    {
        $return = array('error' => '401' , 'errortext' => 'Unauthorized' , 'errortype' => 'HTTP');
        $string = 'HTTP/1.1 401 Unauthorized';
        $this->assertEquals($this->object->extractErrorFromPhpMessage($string), $return);
    }

    /**
     * @covers Soliant\SimpleFM\Adapter::errorToEnglish
     */
    public function testErrorToEnglish()
    {
        $error = array( 0 => 'No Error', 10 => 'Requested data is missing');
        $this->assertEquals($this->object->errorToEnglish(10), 'Requested data is missing');
    }
}
