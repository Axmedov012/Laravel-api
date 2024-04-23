<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class Task extends Model
{
    use HasFactory;

    protected $fillable=[
      'title',
      'is_done',
      'creator_id',
      'project_id'
    ];
    protected $casts=[
        'is_done'=>'boolean',
    ];


    public function creator():BelongsTo  {return $this->belongsTo(User::class);}
    public function project():BelongsTo { return $this->belongsTo(Project::class);}

       /*  Login qilgan user ning faqat o'zi yozgan POST yoki COMMENT ni
             ko'rishni taminlaydi  Yani qo'shimcha ximoya
       */
    protected static function booted():void {
        static::addGlobalScope('creator',function (Builder $builder){
            $builder->where('creator_id',Auth::id());
        });
    }
}



