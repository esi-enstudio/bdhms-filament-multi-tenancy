<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Retailer extends Model
{
    use HasSlug;

    protected $fillable = [
        'slug',
        'house_id',
        'rso_id',
        'user_id',
        'is_rso_code',
        'is_bp_code',
        'code',
        'name',
        'type',
        'enabled',
        'sso',
        'itop_number',
        'service_point',
        'category',
        'owner_name',
        'owner_number',
        'division',
        'district',
        'thana',
        'address',
        'nid',
        'dob',
        'lat',
        'long',
        'bts_code',
        'description',
        'remarks',
        'others_operator',
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
