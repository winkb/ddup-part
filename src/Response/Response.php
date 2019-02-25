<?php
/**
 * Created by PhpStorm.
 * User: lixingbo
 * Date: 2018/9/25
 * Time: 下午5:39
 */

namespace Ddup\Part\Response;


class Response extends \Illuminate\Http\Response
{
    private $_code = 'success';
    private $_msg;
    private $_data;

    function data($data)
    {
        $this->_data = $data;

        return self::updateContent();
    }

    function code($code)
    {
        $this->_code = $code;

        return self::updateContent();
    }

    function success()
    {
        $this->_code = 'success';

        return self::updateContent();
    }

    function fail()
    {
        $this->_code = 'fail';

        return self::updateContent();
    }

    function message($msg)
    {
        $this->_msg = $msg;

        return self::updateContent();
    }

    function msg($msg)
    {
        return self::message($msg);
    }

    private function updateContent()
    {
        parent::setContent($this->completeContent());

        return $this;
    }

    public function setContent($content)
    {
        if ($this->shouldBeJson($content)) {
            $this->_data = $content;
        }

        return parent::setContent($this->completeContent()); // TODO: Change the autogenerated stub
    }

    private function completeContent()
    {
        return [
            'retcode' => $this->_code,
            'msg'     => $this->_msg,
            'data'    => $this->_data
        ];
    }
}