<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccessRequest;
use App\Models\AccessRule;
use App\Models\Lock;
use App\Models\LockGroup;
use App\Models\Log;
use App\Models\Team;
use App\Models\Worker;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseCode;

class AccessController extends Controller
{
    /**
     * Lock endpoint: A worker tries to access a lock
     * @param string $lock_fingerPrint
     * @param AccessRequest $request
     * @return JsonResponse
     */
    public function enter(string $lock_fingerPrint, AccessRequest $request): JsonResponse{
        //<editor-fold defaultstate="collapsed" desc="Get Models from Request (Lock and Worker)">
        /** @var Lock $lock */
        $lock = Lock::where('device_key', 'like', $lock_fingerPrint)->first() ?? Lock::find($lock_fingerPrint);
        if(!$lock){
            abort(ResponseCode::HTTP_NOT_FOUND, "Lock not found. Fingerprint was '$lock_fingerPrint'");
        }
        /** @var Worker $worker */
        $worker = Worker::where('rfid', ($request->validated()['worker_rfid'] ?? ''))->first() ?? Worker::find($request->validated()['worker_id']);
        if(!$worker){
            abort(ResponseCode::HTTP_NOT_FOUND, 'Worker not found.');
        }
        //</editor-fold>

        //<editor-fold defaultstate="collapsed" desc="Get related groups (LockGroup and Team)">
        $lockGroups = LockGroup::whereHas('locks', function ($q) use ($lock) {
            $q->where('locks.id', $lock->id);
        })->pluck('id');
        $teams = Team::whereHas('workers', function ($q) use ($worker) {
            $q->where('workers.id', $worker->id);
        })->pluck('id');
        //</editor-fold>

        //<editor-fold defaultstate="collapsed" desc="Get common access rule between the LockGroup and the Team">
        /** @var Collection $commonAccessRules */
        $commonAccessRules = AccessRule::whereHas('lockGroups', function ($q) use ($lockGroups) {
            $q->whereIn('lock_group_id', $lockGroups);
        })->whereHas('workerGroups', function ($q) use ($teams) {
            $q->where('team_id', $teams);
        })->get();
        //</editor-fold>

        //<editor-fold defaultstate="collapsed" desc="Check if ANY rule allows access">
        foreach ($commonAccessRules as $rule) {
            /** @var AccessRule $rule */
            if($rule->isAllowing){
                Log::entry('allow', $worker, $lock, $rule);
                return response()->json(['action' => 'allow'], ResponseCode::HTTP_ACCEPTED);
            }
        }
        //</editor-fold>

        //<editor-fold defaultstate="collapsed" desc="Return LOCKED status, because none of the rules allowed access">
        Log::entry('forbid', $worker, $lock);
        return response()->json(['action' => 'forbid'], ResponseCode::HTTP_LOCKED);
        //</editor-fold>
    }
}
