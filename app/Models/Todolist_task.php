<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Todolist_task extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "todolists_tasks";
    protected $guarded = [];
    protected $primaryKey = 'id';

    public function user(){
        return $this->belongsTo(User::class, "todolist_tasks", "id");
    }
}
