<?php
/**
 * @codingStandardsIgnoreStart
 *
 * @author       Barney Hanlon <barney@shrikeh.net>
 * @copyright    Barney Hanlon 2017
 * @license      https://opensource.org/licenses/MIT
 *
 * @codingStandardsIgnoreEnd
 */

namespace spec\Shrikeh\GuzzleMiddleware\TimerLogger\RequestTimers;

use PhpSpec\ObjectBehavior;
use Psr\Http\Message\RequestInterface;
use Shrikeh\GuzzleMiddleware\TimerLogger\RequestTimers\Exception\RequestNotFoundException;
use Shrikeh\GuzzleMiddleware\TimerLogger\Timer\TimerInterface;

class RequestTimersSpec extends ObjectBehavior
{
    public function getMatchers()
    {
        return [
            'beAValidDuration' => function ($number) {
                return is_float($number) && $number > 0;
            },
        ];
    }

    public function it_returns_the_timer_for_a_request(RequestInterface $request)
    {
        $this->start($request)->shouldBeAnInstanceOf(TimerInterface::class);
    }

    public function it_returns_the_same_timer_for_a_request(RequestInterface $request)
    {
        $start = $this->start($request);

        $this->stop($request)->shouldReturn($start);
    }

    public function it_returns_the_duration_for_a_request(RequestInterface $request)
    {
        $this->start($request);
        usleep(1000);
        $this->duration($request)->shouldBeAValidDuration();
    }

    public function it_throws_a_request_not_found_exception_if_the_request_has_not_been_registered(
        RequestInterface $request
    ) {
        $this->shouldThrow(RequestNotFoundException::class)
            ->duringStop($request);
    }
}
