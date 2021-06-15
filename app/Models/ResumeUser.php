<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DateTime;

class ResumeUser extends Model
{
    protected $table = "resume_user";
    protected $fillable = [];
    protected $guarded = [];

    public static function store($resumeId, $userId, $type)
    {
        $resumeUser = ResumeUser::where('resume_id', $resumeId)->where('user_id', $userId)->where('type', $type)->first();
        $data = [
            'resume_id' => $resumeId,
            'user_id' => $userId,
            'type' => $type,
            'times' => 1
        ];

        if (empty($resumeUser)) {
            ResumeUser::create($data);
        } else {
            if ($type === 'seen' || $type === 'upload' || $type === 'download') {
                $resumeUser->updated_at = new DateTime();
                $resumeUser->increment('times');
                $resumeUser->save();
            } elseif ($type === 'collect') {
                $resumeUser->delete();
            }
        }
    }
}
