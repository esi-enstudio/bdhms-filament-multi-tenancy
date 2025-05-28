<?php

namespace App\Models;

use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

/**
 * @method static create(array $rso)
 * @method static whereNotNull(string $string)
 * @method static firstWhere(string $string, mixed $rso_number)
 * @method static select(string $string)
 * @method static where(string $string, $id)
 */
class Rso extends Model
{
    use HasSlug;


    protected $fillable = [
        'slug',
        'house_id',
        'user_id',
        'supervisor_id',
        'osrm_code',
        'employee_code',
        'rso_code',
        'itop_number',
        'pool_number',
        'personal_number',
        'name_as_bank_account',
        'religion',
        'bank_name',
        'bank_account_number',
        'brunch_name',
        'routing_number',
        'education',
        'blood_group',
        'gender',
        'present_address',
        'permanent_address',
        'father_name',
        'mother_name',
        'market_type',
        'salary',
        'category',
        'agency_name',
        'dob',
        'nid',
        'division',
        'district',
        'thana',
        'sr_no',
        'joining_date',
        'resign_date',
        'status',
        'remarks',
        'document',
    ];

    protected static function booted(): void
    {
        static::creating(function ($rso) {
            if (!$rso->house_id) {
                $rso->house_id = Filament::getTenant()?->id;
            }
        });
    }


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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function supervisor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }

    public function retailer(): HasMany
    {
        return $this->hasMany(Retailer::class);
    }
}
