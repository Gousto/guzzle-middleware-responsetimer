<?php
/**
 * @author       Barney Hanlon <barney@shrikeh.net>
 * @copyright    Barney Hanlon 2017
 * @license      https://opensource.org/licenses/MIT
 */

namespace Shrikeh\GuzzleMiddleware\TimerLogger\Formatter;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Shrikeh\GuzzleMiddleware\TimerLogger\Timer\TimerInterface;

/**
 * Interface RequestStartInterface.
 */
interface RequestStopInterface
{
    /**
     * @param TimerInterface    $timer    The timer to format
     * @param RequestInterface  $request  The Request to format
     * @param ResponseInterface $response The Response to format
     *
     * @return mixed
     */
    public function stop(
        TimerInterface $timer,
        RequestInterface $request,
        ResponseInterface $response
    );

    /**
     * @param TimerInterface    $timer    The timer to format
     * @param RequestInterface  $request  The Request to format
     * @param ResponseInterface $response The Response to format
     *
     * @return mixed
     */
    public function levelStop(
        TimerInterface $timer,
        RequestInterface $request,
        ResponseInterface $response
    );
}
