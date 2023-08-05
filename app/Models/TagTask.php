<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TagTask extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];
    protected $primaryKey = 'id';

    public function deleteTag($task_id, $tag_id)
    {
        $this->where("task_id", "=", $task_id)
            ->where("tag_id", "=", $tag_id)->delete();
    }
}
