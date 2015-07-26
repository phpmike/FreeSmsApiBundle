<?php
/**
 * Author: Michaël VEROUX
 * Date: 26/07/15
 * Time: 08:50
 */

namespace Mv\FreeSmsApiBundle\Sms;

use Mv\FreeSmsApi\Exception\FailedException;
use Mv\FreeSmsApi\Sms\SenderInterface;

/**
 * Class SenderBuilder
 * @package Mv\FreeSmsApiBundle\Sms
 * @author Michaël VEROUX
 */
class SenderBuilder
{
    /**
     * @var SenderInterface
     */
    protected $senderClass;

    /**
     * @var array
     */
    protected $senderServices;

    /**
     * SenderBuilder constructor.
     * @param string $senderClass
     */
    public function __construct($senderClass)
    {
        $this->senderClass = $senderClass;
    }

    /**
     * @param string $name
     * @param string $userId
     * @param string $userApiKey
     * @return SenderInterface
     * @author Michaël VEROUX
     */
    public function build($name, $userId, $userApiKey)
    {
        $senderClass = $this->senderClass;
        $sender = new $senderClass($userId, $userApiKey);
        if(!$sender instanceof SenderInterface) {
            throw new \RuntimeException(sprintf('Class %s must implement Mv\FreeSmsApi\Sms\SenderInterface', $senderClass));
        }

        $this->senderServices[$name] = $sender;

        return $sender;
    }

    /**
     * @param string $message
     * @return $this
     * @author Michaël VEROUX
     */
    public function addMessage($message)
    {
        foreach($this->senderServices as $service) {
            $service->addMessage($message);
        }

        return $this;
    }

    /**
     * @param string $message
     * @param array $to
     * @return $this
     * @author Michaël VEROUX
     */
    public function addMessageTo($message, array $to = array())
    {
        foreach($to as $name) {
            if(!isset($this->senderServices[$name])) {
                throw new FailedException(sprintf('Free user "%" doesn\'t exists!', $name));
            }

            $this->senderServices[$name]->addMessage($message);
        }

        return $this;
    }

    /**
     * @author Michaël VEROUX
     */
    public function reset()
    {
        foreach($this->senderServices as $service) {
            $service->reset();
        }
    }

    /**
     * @return bool
     * @author Michaël VEROUX
     */
    public function send()
    {
        $errors = array();
        foreach($this->senderServices as $name => $service) {
            try {
                $service->send();
            } catch (FailedException $e) {
                $errors[] = sprintf('%s: %s', $name, $e->getMessage());
            }
        }

        if(count($errors)) {
            throw new FailedException(implode(PHP_EOL, $errors));
        }

        return true;
    }
}