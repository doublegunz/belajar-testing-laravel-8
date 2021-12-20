<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    public function toggleStatus()
    {
        if ($this->is_done == 1) {
            $this->is_done = 0;
        } else {
            $this->is_done = 1;
        }

        $this->save();

        return $this;
    }
}
