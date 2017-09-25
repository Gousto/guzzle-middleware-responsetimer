<?php

namespace Shrikeh\GuzzleMiddleware\TimerLogger\Formatter;

use Psr\Http\Message\RequestInterface;
use Psr\Log\LogLevel;
use Shrikeh\GuzzleMiddleware\TimerLogger\Timer\TimerInterface;

class StartFormatter implements RequestStartInterface
{
    /**
     * @var string|callable
     */
    private $msg;

    /**
     * @var string|callable
     */
    private $level;

    /**
     * StartFormatter constructor.
     *
     * @param $msg
     * @param $level
     */
    public function __construct(callable $msg, $level = LogLevel::DEBUG)
    {
        $this->msg   = $msg;
        $this->level = $level;
    }


    /**
     * @param \Shrikeh\GuzzleMiddleware\TimerLogger\Timer\TimerInterface $timer
     * @param \Psr\Http\Message\RequestInterface                         $request
     *
     * @return string
     */
    public function start(TimerInterface $timer, RequestInterface $request)
    {
        $msg = $this->msg;

        return $msg($timer, $request);
    }

    public function levelStart(TimerInterface $timer, RequestInterface $request)
    {
        $level = $this->level;
        if (is_callable($level)) {
            $level = $level($timer, $request);
        }

        return $level;
    }


}