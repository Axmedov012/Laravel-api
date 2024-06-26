<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class Project extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
    ];

    public function tasks():HasMany { return $this->hasMany(Task::class,'project_id'); ;}
    public function creator():BelongsTo { return $this->belongsTo(User::class);}
    public function members():BelongsToMany { return $this->belongsToMany(User::class,Member::class); }

    /*  Login qilgan user ning faqat o'zi yozgan POST yoki COMMENT ni
           ko'rishni taminlaydi  Yani qo'shimcha ximoya
     */
    protected static function booted():void {
        static::addGlobalScope('creator',function (Builder $builder){
            $builder->where('creator_id',Auth::id());
        });
    }


}
