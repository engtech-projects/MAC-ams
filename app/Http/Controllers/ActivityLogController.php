<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Spatie\Activitylog\Models\Activity;

class ActivityLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $activityLogs = Activity::when($request['event'], function ($query) use ($request) {
            $query->where('event', $request['event']);
        })
        ->when($request['log_name'], function ($query) use ($request) {
            $query->where('log_name', $request['log_name']);
        })
        ->orderBy('created_at', 'desc')
        ->paginate(15);
        $data = $activityLogs->map(function ($item) {
            return [
                'id' => $item->id,
                'log_name' => $item->log_name,
                'description' => $item->description,
                'subject_type' => Str::headline(class_basename($item->subject_type)),
                'subject' => $item->subject?->id,
                'subject' => [
                    'id' => $item->subject_id,
                    'data' => $activity->properties['model_snapshot'] ?? null
                ],
                'event' => $item->event,
                'causer_type' => Str::headline(class_basename($item->causer_type)),
                'causer' => $item->causer->personal_info->fname ? trim($item->causer->personal_info->fname . ' ' . $item->causer->personal_info->mname . ' ' . $item->causer->personal_info->lname) . ' (' .$item->causer->username. ')': $item->causer->username,
                'user_role' => $item->causer->userRole,
                'properties' => $item->changes(),
                'created_at' => $item->created_at->format('Y-m-d g:i A')
            ];
        });
        return new JsonResponse([
            'data' => $data,
            'current_page' => $activityLogs->currentPage(),
            'last_page' => $activityLogs->lastPage(),
            'per_page' => $activityLogs->perPage(),
            'total' => $activityLogs->total(),
            'from' => $activityLogs->firstItem(),
            'to' => $activityLogs->lastItem(),
            'message' => "Successfully fetched."
        ], JsonResponse::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $activity = Activity::find($id);

        $activity = [
            'id' => $activity->id,
            'log_name' => $activity->log_name,
            'description' => $activity->description,
            'subject_type' => Str::headline(class_basename($activity->subject_type)),
            'subject' => $activity->subject?->id,
            'subject' => [
                'id' => $activity->subject_id,
                'data' => $activity->properties['model_snapshot'] ?? null
            ],
            'event' => $activity->event,
            'causer_type' => Str::headline(class_basename($activity->causer_type)),
            'causer' => $activity->causer->personal_info->fname ? trim($activity->causer->personal_info->fname . ' ' . $activity->causer->personal_info->mname . ' ' . $activity->causer->personal_info->lname) . ' (' .$activity->causer->username. ')': $activity->causer->username,
            'user_role' => $activity->causer->userRole,
            'properties' => $activity->changes(),
            'created_at' => $activity->created_at->format('Y-m-d g:i A')
        ];
        return new JsonResponse([
            'data' => $activity,
            'message' => "Activity fetched."
        ], JsonResponse::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
