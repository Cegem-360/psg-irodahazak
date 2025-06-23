<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

final class Property extends Model
{
    protected $guarded = [];

    protected $fillable = [
        'title',
        'status',
        'lead',
        'content',
        'date',
        'ord',
        'meta_title',
        'meta_title_en',
        'meta_keywords',
        'meta_keywords_en',
        'meta_description',
        'meta_description_en',
        'construction_year',
        'total_area',
        'jelenleg_kiado',
        'max_berleti_dij',
        'uzemeletetesi_dij',
        'raktar_terulet',
        'raktar_berleti_dij',
        'parkolas',
        'parkolas_dija',
        'kozos_teruleti_arany',
        'cim_irsz',
        'cim_varos',
        'district',
        'cim_utca',
        'cim_hazszam',
        'tags',
        'services',
        'maps_lat',
        'maps_lng',
        'azonosito',
        'osszterulet_addons',
        'max_berleti_dij_addons',
        'parkolas_dija_addons',
        'min_berleti_dij',
        'min_berleti_dij_addons',
        'raktar_terulet_addons',
        'raktar_berleti_dij_addons',
        'uzemeletetesi_dij_addons',
        'min_parkolas_dija',
        'min_parkolas_dija_addons',
        'max_parkolas_dija',
        'max_parkolas_dija_addons',
        'kozos_teruleti_arany_addons',
        'min_kiado',
        'min_kiado_addons',
        'jelenleg_kiado_addons',
        'kodszam',
        'en_content',
        'min_berleti_idoszak',
        'min_berleti_idoszak_addons',
        'cim_utca_addons',
        'lang',
        'cimke',
        'service',
        'maps',
        'elado_v_kiado',
        'elado_v_kiado_addons',
        'updated',
        'egyeb',
        'afa',
        'slug',
    ];

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function tags()
    {
        return $this->hasMany(Tag::class);
    }

    public function images()
    {
        return $this->hasMany(Gallery::class, 'target_table_id')
            ->where('target_table', 'property')
            ->orderBy('ord');
    }

    /**
     * Get gallery images ordered by ord field
     */
    public function galleryImages()
    {
        return $this->images()->get();
    }

    /**
     * Get all image URLs for this property
     */
    public function getImageUrlsAttribute(): array
    {
        return $this->images->map(function ($image) {
            return $image->image_url;
        })->toArray();
    }

    /**
     * Get the first image URL
     */
    public function getFirstImageUrlAttribute(): ?string
    {
        $firstImage = $this->images->first();

        return $firstImage ? $firstImage->getFirstImageUrl() : null;
    }

    /**
     * Get the first image URL with specified size (default 800x600)
     */
    public function getFirstImageUrl(string $size = '800x600', string $extension = 'jpg'): ?string
    {
        $firstImage = $this->images->first();

        return $firstImage ? $firstImage->getImageUrl($size, $extension) : null;
    }

    /**
     * Get image URLs in a specific size
     */
    public function getImageUrls(?string $size = null): array
    {
        return $this->images->map(function ($image) use ($size) {
            return $image->getImageUrl($size);
        })->toArray();
    }

    #[Scope]
    protected function active(Builder $query): void
    {
        $query->where('status', 'active');
    }

    #[Scope]
    protected function inactive(Builder $query): void
    {
        $query->where('status', 'inactive');
    }

    #[Scope]
    protected function sale(Builder $query): void
    {
        $query->where('elado_v_kiado', 'elado-iroda');
    }

    #[Scope]
    protected function rent(Builder $query): void
    {
        $query->where('elado_v_kiado', 'kiado-iroda');
    }

    protected function slug(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ?: Str::slug($this->title),
            set: fn ($value) => $value ?: Str::slug($this->title)
        );
    }

    protected function casts(): array
    {
        return [
            'tags' => 'array',
            'services' => 'array',

        ];
    }
}
