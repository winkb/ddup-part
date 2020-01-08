<?php

namespace Ddup\Part\Test;

use Ddup\Part\Api\ApiResultInterface;
use Ddup\Part\Api\ApiResulTrait;
use Ddup\Part\Request\HasHttpRequest2;
use Ddup\Part\Test\Provider\LoggerProvider;
use Ddup\Part\Test\Provider\MyClient;
use Ddup\Part\Test\Provider\ResultProvider;
use GuzzleHttp\MessageFormatter;

class RequestTest2 extends TestCase
{
    use ApiResulTrait;
    use HasHttpRequest2;

    public function requestOptions()
    {
        return [];
    }

    public function requestParams()
    {
        return [
            'account' => 'blue'
        ];
    }

    public function getBaseUri()
    {
        return 'http://localhost:8000';
    }

    public function newResult($ret):ApiResultInterface
    {
        return new ResultProvider($ret);
    }

    protected function setUp()/* The :void return type declaration that should be here would cause a BC issue */
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $formater = new MessageFormatter('{req_body}');

        $this->pushMiddleware(\GuzzleHttp\Middleware::log(new LoggerProvider(), $formater), 'log');
    }

    public function test_json()
    {

        try {
            $response = $this->json('', ['age' => 20]);

            $this->parseResult($response);

            $this->assertNotNull($response);

            $this->assertEquals('application/json', $this->result()->getData()->get('CONTENT_TYPE'));

            $this->assertTrue($this->result()->isSuccess());

        } catch (\Exception $exception) {

            $this->assertNotFalse(strpos($exception->getMessage(), 'Connection refused'), '没开服务');
        }

    }
}