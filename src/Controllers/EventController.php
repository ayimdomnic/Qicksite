<?php

namespace Ayimdomnic\QuickSite\Controllers;

use Illuminate\Http\Request;
use quicksite;
use URL;
use Ayimdomnic\QuickSite\Models\Event;
use Ayimdomnic\QuickSite\Repositories\EventRepository;
use Ayimdomnic\QuickSite\Requests\EventRequest;
use Ayimdomnic\QuickSite\Services\ValidationService;

class EventController extends quicksiteController
{
    /** @var EventRepository */
    private $eventRepository;

    public function __construct(EventRepository $eventRepo)
    {
        $this->eventRepository = $eventRepo;
    }

    /**
     * Display a listing of the Event.
     *
     * @return Response
     */
    public function index()
    {
        $result = $this->eventRepository->paginated();

        return view('quicksite::modules.events.index')
            ->with('events', $result)
            ->with('pagination', $result->render());
    }

    /**
     * Search.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function search(Request $request)
    {
        $input = $request->all();

        $result = $this->eventRepository->search($input);

        return view('quicksite::modules.events.index')
            ->with('events', $result[0]->get())
            ->with('pagination', $result[2])
            ->with('term', $result[1]);
    }

    /**
     * Show the form for creating a new Event.
     *
     * @return Response
     */
    public function create()
    {
        return view('quicksite::modules.events.create');
    }

    /**
     * Store a newly created Event in storage.
     *
     * @param EventRequest $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $validation = ValidationService::check(Event::$rules);

        if (!$validation['errors']) {
            $event = $this->eventRepository->store($request->all());
            quicksite::notification('Event saved successfully.', 'success');
        } else {
            return $validation['redirect'];
        }

        if (!$event) {
            quicksite::notification('Event could not be saved.', 'warning');
        }

        return redirect(route('quicksite.events.edit', [$event->id]));
    }

    /**
     * Show the form for editing the specified Event.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $event = $this->eventRepository->findEventById($id);

        if (empty($event)) {
            quicksite::notification('Event not found', 'warning');

            return redirect(route('quicksite.events.index'));
        }

        return view('quicksite::modules.events.edit')->with('event', $event);
    }

    /**
     * Update the specified Event in storage.
     *
     * @param int          $id
     * @param EventRequest $request
     *
     * @return Response
     */
    public function update($id, EventRequest $request)
    {
        $event = $this->eventRepository->findEventById($id);

        if (empty($event)) {
            quicksite::notification('Event not found', 'warning');

            return redirect(route('quicksite.events.index'));
        }

        $event = $this->eventRepository->update($event, $request->all());
        quicksite::notification('Event updated successfully.', 'success');

        if (!$event) {
            quicksite::notification('Event could not be saved.', 'warning');
        }

        return redirect(URL::previous());
    }

    /**
     * Remove the specified Event from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $event = $this->eventRepository->findEventById($id);

        if (empty($event)) {
            quicksite::notification('Event not found', 'warning');

            return redirect(route('quicksite.events.index'));
        }

        $event->delete();

        quicksite::notification('Event deleted successfully.', 'success');

        return redirect(route('quicksite.events.index'));
    }
}
