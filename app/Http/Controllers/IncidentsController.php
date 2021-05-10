<?php

namespace App\Http\Controllers;

use App\Models\Incident;
use App\Services\IncidentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class IncidentsController extends Controller
{
    /**
     * Incident service
     *
     * @var IncidentService
     */
    private IncidentService $service;

    /**
     * Constructor method
     *
     * @param IncidentService $service
     */
    public function __construct(IncidentService $service)
    {
        $this->service = $service;
    }

    /**
     * List incidents
     *
     * @return View
     */
    public function index()
    {
        $incidents = $this->service->list();
        return view('incidents.index', ['incidents' => $incidents]);
    }

    /**
     * Show form to create a new incident
     *
     * @return View
     */
    public function create()
    {
        return view('incidents.create', [
            'criticality' => [
                Incident::CRITICALITY_HIGH,
                Incident::CRITICALITY_MEDIUM,
                Incident::CRITICALITY_LOW,
            ],
            'type'        => [
                Incident::TYPE_ALARM,
                Incident::TYPE_INCIDENT,
                Incident::TYPE_OTHER,
            ],
            'status'      => [
                Incident::STATUS_ACTIVE,
                Incident::STATUS_INACTIVE,
            ]
        ]);
    }

    /**
     * Store a new incident
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        if ($request->status ?? '' === 'on') {
            $request->merge(['status' => Incident::STATUS_ACTIVE]);
        } else {
            $request->merge(['status' => Incident::STATUS_INACTIVE]);
        }

        $validation = Validator::make($request->input(), [
            'title'       => 'required|string|max:80',
            'description' => 'required|string',
            'criticality' => [
                'required',
                Rule::in([
                    Incident::CRITICALITY_HIGH,
                    Incident::CRITICALITY_MEDIUM,
                    Incident::CRITICALITY_LOW,
                ]),
            ],
            'type'        => [
                'required',
                Rule::in([
                    Incident::TYPE_ALARM,
                    Incident::TYPE_INCIDENT,
                    Incident::TYPE_OTHER,
                ]),
            ],
            'status'     => [
                'sometimes',
                'nullable',
                Rule::in([
                    Incident::STATUS_ACTIVE,
                    Incident::STATUS_INACTIVE,
                ]),
            ],
        ]);

        if ($validation->fails()) {
            return redirect(route('incidents.create'))
                ->with('message-error', $validation->getMessageBag()->all())
                ->withInput();
        }

        $saved = $this->service
            ->save(
                $request->input('title'),
                $request->input('description'),
                $request->input('criticality'),
                $request->input('type'),
                $request->input('status')
            );

        if ($saved) {
            return redirect(route('incidents.index'))
                ->with('message-success', [__('messages.SavedSuccessfully')]);
        }

        return redirect(route('incidents.create'))
            ->with('message-error', [__('messages.InternalError')])
            ->withInput();
    }

    /**
     * Show for to edit an incident
     *
     * @param int $id
     *
     * @return View
     */
    public function edit(string $id)
    {
        $validation = Validator::make(
            ['id' => $id],
            ['id' => 'required|integer']
        );

        if ($validation->fails()) {
            return redirect(route('incidents.index'))
                ->with('message-error', $validation->getMessageBag()->all())
                ->withInput();
        }

        $incident = $this->service->get($id);
        if ($incident === null) {
            return redirect(route('incidents.index'))
                ->with('message-error', [__('messages.RecordNotFound')])
                ->withInput();
        }

        return view('incidents.edit', [
            'incident'    => $incident,
            'criticality' => [
                Incident::CRITICALITY_HIGH,
                Incident::CRITICALITY_MEDIUM,
                Incident::CRITICALITY_LOW,
            ],
            'type'        => [
                Incident::TYPE_ALARM,
                Incident::TYPE_INCIDENT,
                Incident::TYPE_OTHER,
            ],
            'status'      => [
                Incident::STATUS_ACTIVE,
                Incident::STATUS_INACTIVE,
            ]
        ]);
    }

    /**
     * Update the incident data
     *
     * @param Request $request
     * @param string  $id
     *
     * @return RedirectResponse
     */
    public function update(Request $request, string $id)
    {
        if ($request->status ?? '' === 'on') {
            $request->merge(['status' => Incident::STATUS_ACTIVE]);
        } else {
            $request->merge(['status' => Incident::STATUS_INACTIVE]);
        }

        $request->merge(['id' => $id]);
        $validation = Validator::make($request->input(), [
            'id'          => 'required|integer',
            'title'       => 'required|string|max:80',
            'description' => 'required|string',
            'criticality' => [
                'required',
                Rule::in([
                    Incident::CRITICALITY_HIGH,
                    Incident::CRITICALITY_MEDIUM,
                    Incident::CRITICALITY_LOW,
                ]),
            ],
            'type'        => [
                'required',
                Rule::in([
                    Incident::TYPE_ALARM,
                    Incident::TYPE_INCIDENT,
                    Incident::TYPE_OTHER,
                ]),
            ],
            'status'     => [
                'sometimes',
                'nullable',
                Rule::in([
                    Incident::STATUS_ACTIVE,
                    Incident::STATUS_INACTIVE,
                ]),
            ],
        ]);

        if ($validation->fails()) {
            return redirect(route('incidents.edit', $id))
                ->with('message-error', $validation->getMessageBag()->all())
                ->withInput();
        }

        $updated = $this->service
            ->update(
                $request->input('id'),
                $request->input('title'),
                $request->input('description'),
                $request->input('criticality'),
                $request->input('type'),
                $request->input('status')
            );

        if ($updated) {
            return redirect(route('incidents.index'))
                ->with('message-success', [__('messages.UpdatedSuccessfully')]);
        }

        return redirect(route('incidents.edit', $id))
            ->with('message-error', [__('messages.InternalError')])
            ->withInput();
    }

    /**
     * Remove an incident
     *
     * @param string $id
     *
     * @return RedirectResponse
     */
    public function destroy(string $id)
    {
        $validation = Validator::make(
            ['id' => $id],
            ['id' => 'required|integer']
        );

        if ($validation->fails()) {
            return redirect(route('incidents.index'))
                ->with('message-error', $validation->getMessageBag()->all());
        }

        $updated = $this->service->delete($id);

        if ($updated) {
            return redirect(route('incidents.index'))
                ->with('message-success', [__('messages.DeletedSuccessfully')]);
        }

        return redirect(route('incidents.index'))
            ->withErrors($validation)
            ->with('message-error', [__('messages.InternalError')]);
    }
}
