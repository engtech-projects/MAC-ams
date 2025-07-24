<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\PostingPeriod;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class PostingPeriodController extends Controller
{
    //

    public function index(Request $request)
    {

        $year = $request['year'];
        $postingPeriods = PostingPeriod::whereYear('posting_period', 'like', "$year-%")->get();

        if ($postingPeriods->isEmpty()) {
            $postingPeriod = [];
            for ($month = 1; $month <= 12; $month++) {
                $startDate = Carbon::createFromDate($request['year'], $month, 1);
                $endDate = $startDate->copy()->endOfMonth();
                try {
                    $data = PostingPeriod::create([
                        'posting_period' => $startDate->format('F Y'),
                        'start_date'     => $startDate->format('Y-m-d'),
                        'end_date'       => $endDate->format('Y-m-d'),
                        'status'         => 'closed',
                        'created_at'     => now(),
                        'updated_at'     => now(),
                    ]);
                    $postingPeriod[] = $data;
                } catch (Exception $e) {
                    return new JsonResponse([
                        'message' => $e->getMessage(),
                    ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
                }
            }
        }
        return new JsonResponse([
            'data' => $postingPeriods,
            'message' => 'Successfully fetched.'
        ], JsonResponse::HTTP_OK);
    }

    public function getYears()
    {
        $postingPeriod = new PostingPeriod();

        $open = $postingPeriod->openStatus()->first();
        $years = $postingPeriod::selectRaw('DISTINCT LEFT(posting_period, 4) as year')
            ->orderBy('year', 'desc')
            ->pluck('year');
        return new JsonResponse([
            'data' => [
                'years' => $years,
                'open_period' => $open
            ],
            'message' => 'Successfully fetched.'
        ], JsonResponse::HTTP_OK);
    }

    public function search(Request $request)
    {

        $postingPeriod = PostingPeriod::whereYear('posting_period', $request['year'])->get();
        /* if ($postingPeriod->isEmpty()) {
            $postingPeriod = [];
            for ($month = 1; $month <= 12; $month++) {
                $startDate = Carbon::createFromDate($request['year'], $month, 1);
                $endDate = $startDate->copy()->endOfMonth();
                try {
                    $data = PostingPeriod::create([
                        'posting_period' => $startDate->format('F Y'),
                        'start_date'     => $startDate->format('Y-m-d'),
                        'end_date'       => $endDate->format('Y-m-d'),
                        'status'         => 'closed',
                        'created_at'     => now(),
                        'updated_at'     => now(),
                    ]);
                    $postingPeriod[] = $data;
                } catch (Exception $e) {
                    return new JsonResponse([
                        'message' => $e->getMessage(),
                    ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
                }
            }
        } */
        return new JsonResponse([
            'data' => $postingPeriod,
            'message' => 'Successfully fetched.'
        ], JsonResponse::HTTP_OK);
    }
    public function update(Request $request, PostingPeriod $postingPeriod)
    {
        $data = $request->all();

        $replicate = $postingPeriod->replicate();

        try {
            DB::transaction(function () use ($postingPeriod, $data, $replicate) {
                $postingPeriod->update([
                    'posting_period' => $data['posting_period'],
                    'start_date' => $data['start_date'],
                    'end_date' => $data['end_date'],
                    'status' => $data['status']
                ]);

                activity("Posting Period")->event($postingPeriod->status)->performedOn($postingPeriod)
                    ->withProperties(['attributes' => $postingPeriod, 'old' => $replicate])
                    ->log("updated");
            });
        } catch (\Exception $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ], JsonResponse::HTTP_BAD_REQUEST);
        }

        return new JsonResponse([
            'message' => 'Successfully updated.'
        ], JsonResponse::HTTP_OK);
    }

    public function store(Request $request)
    {
        $postingPeriods = [];
        for ($month = 1; $month <= 12; $month++) {
            $startDate = Carbon::createFromDate($request['year'], $month, 1);
            $endDate = $startDate->copy()->endOfMonth();
            try {
                $data = PostingPeriod::create([
                    'posting_period' => $startDate->format('Y-m'),
                    'start_date'     => $startDate->format('Y-m-d'),
                    'end_date'       => $endDate->format('Y-m-d'),
                    'status'         => 'closed',
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ]);
                $postingPeriods[] = $data;
            } catch (Exception $e) {
                return new JsonResponse([
                    'message' => $e->getMessage(),
                ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
        return new JsonResponse([
            'data' => $postingPeriods,
            'message' => 'Successfully created.'
        ], JsonResponse::HTTP_CREATED);
    }
    public function show(PostingPeriod $postingPeriod)
    {
        if (!$postingPeriod) {
            $postingPeriod = new PostingPeriod();

            return new JsonResponse([
                'data' => $postingPeriod->openStatus(),
                'message' => 'Successfully fetched.'
            ], JsonResponse::HTTP_OK);
        }
        return $postingPeriod;
    }
    public function openPostingPeriod()
    {
        $postingPeriod = new PostingPeriod();

        $open = $postingPeriod->openStatus()->get();
        return new JsonResponse([
            'data' => $open,
            'message' => 'Successfully fetched.'
        ], JsonResponse::HTTP_OK);
    }
    public function destroy() {}
}
