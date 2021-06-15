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
            'type' => $type
        ];

        if (empty($resumeUser)) {
            ResumeUser::create($data);
        } else {
            if ($type === 'seen') {
                $resumeUser->updated_at = new DateTime();
                $resumeUser->save();
            } elseif ($type === 'collect') {
                $resumeUser->delete();
            } elseif ($type === 'upload' || $type === 'download') {
                ResumeUser::create($data);
            }
        }
    }
}
