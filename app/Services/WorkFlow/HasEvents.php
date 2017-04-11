<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 2017-04-11
 * Time: 10:37
 */

namespace App\Services\WorkFlow;

use Illuminate\Contracts\Events\Dispatcher;

trait HasEvents
{
	/**
	 * Get the observable event names.
	 *
	 * @return array
	 */
	public function getObservableEvents()
	{
		return [];
	}

	/**
	 * Register a model event with the dispatcher.
	 *
	 * @param  string  $event
	 * @param  \Closure|string  $callback
	 * @return void
	 */
	protected static function registerEvent($event, $callback)
	{
		if (isset(static::$dispatcher)) {
			$name = static::class;

			static::$dispatcher->listen("workflow.{$event}: {$name}", $callback);
		}
	}

	/**
	 * Fire the given event for the model.
	 *
	 * @param  string  $event
	 * @param  bool  $halt
	 * @return mixed
	 */
	protected function fireEvent($event, $halt = false)
	{
		if (! isset(static::$dispatcher)) {
			return true;
		}

		// First, we will get the proper method to call on the event dispatcher, and then we
		// will attempt to fire a custom, object based event for the given event. If that
		// returns a result we can return that result, or we'll call the string events.
		$method = $halt ? 'until' : 'fire';

		return ! empty($result) ? $result : static::$dispatcher->{$method}(
			"workflow.{$event}: ".static::class, $this
		);
	}

	/**
	 * Remove all of the event listeners for the model.
	 *
	 * @return void
	 */
	public static function flushEventListeners()
	{
		if (! isset(static::$dispatcher)) {
			return;
		}

		$instance = new static;

		foreach ($instance->getObservableEvents() as $event) {
			static::$dispatcher->forget("workflow.{$event}: ".static::class);
		}
	}

	/**
	 * Get the event dispatcher instance.
	 *
	 * @return \Illuminate\Contracts\Events\Dispatcher
	 */
	public static function getEventDispatcher()
	{
		return static::$dispatcher;
	}

	/**
	 * Set the event dispatcher instance.
	 *
	 * @param  \Illuminate\Contracts\Events\Dispatcher  $dispatcher
	 * @return void
	 */
	public static function setEventDispatcher(Dispatcher $dispatcher)
	{
		static::$dispatcher = $dispatcher;
	}

	/**
	 * Unset the event dispatcher for models.
	 *
	 * @return void
	 */
	public static function unsetEventDispatcher()
	{
		static::$dispatcher = null;
	}
}