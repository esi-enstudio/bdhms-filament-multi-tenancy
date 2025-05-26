<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Bp extends Model
{
    use HasSlug;

    protected $fillable = [
        'slug',
        'house_id',
        'user_id',
        'arc_name',
        'employee_id',
        'joining_date',
        'resign_date',
        'pool_number',
        'personal_number',
        'last_education',
        'blood_group',
        'present_address',
        'permanent_address',
        'father_name',
        'mother_name',
        'category',
        'nid',
        'date_of_birth',
        'bank_name',
        'bank_account_no',
        'gender',
        'agency',
        'remarks',
        'document',
    ];

    /**
     * @return SlugOptions
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(function () {
                do {
                    $slug = Str::random(10);
                } while (self::where('slug', $slug)->exists());
                return $slug;
            })
            ->saveSlugsTo('slug') // Column to save slug
            ->doNotGenerateSlugsOnUpdate();
    }

    public function getRouteKeyName(): string
    {
        return 'slug'; // Use slug instead of id in routes
    }

    public function house(): BelongsTo
    {
        return $this->belongsTo(House::class);
    }
}
