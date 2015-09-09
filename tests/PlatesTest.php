<?php
/**
 * Slim Framework (http://slimframework.com)
 *
 * @link      https://github.com/codeguy/Slim
 * @copyright Copyright (c) 2011-2015 Josh Lockhart
 * @license   https://github.com/codeguy/Slim/blob/master/LICENSE (MIT License)
 */
namespace Slim\Tests\Views;

use Slim\Views\Plates;

require dirname(__DIR__) . '/vendor/autoload.php';

class PlatesTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Slim\Views\Plates
     */
    protected $view;

    public function setUp()
    {
        $this->view = new Plates([
            'directory' => __DIR__ . '/templates',
            'fileExtension' => 'tpl'
        ]);
    }

    public function testRender()
    {
        $mockBody = $this->getMockBuilder('Psr\Http\Message\StreamInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $mockResponse = $this->getMockBuilder('Psr\Http\Message\ResponseInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $mockBody->expects($this->once())
            ->method('write')
            ->with("<p>Hi, my name is Fery.</p>\n")
            ->willReturn($mockResponse);

        $mockResponse->expects($this->once())
            ->method('getBody')
            ->willReturn($mockBody);

        $response = $this->view->render($mockResponse, 'example', [
            'name' => 'Fery'
        ]);

        $this->assertInstanceOf('Psr\Http\Message\ResponseInterface', $response);
    }
}