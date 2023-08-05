<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "tasks";
    protected $guarded = [];
    protected $primaryKey = 'id';

    public function user(){
        return $this->belongsTo(User::class, "tasks", "id");
    }

    public function tags(){
        return $this->belongsToMany(Tag::class, "tag_tasks", "task_id", "tag_id");
    }
}
