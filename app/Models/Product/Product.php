<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Product extends Model implements HasMedia
{
    use AttributesTrait,
        RelationsTrait,
        ScopesTrait,
        HasSlug,
        InteractsWithMedia,
        SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'description_short',
        'meta_description',
        'meta_keywords',
        'meta_title',
        'on_sale',
        'online_only',
        'quantity',
        'price',
        'additional_shipping_cost',
        'width',
        'height',
        'weight',
        'out_of_stock',
        'active',
        'virtual'
    ];

    protected $casts = [
        # Date fields
        'available_date' => 'date',

        # Boolean fields
        'on_sale' => 'boolean',
        'online_only' => 'boolean',
        'active' => 'boolean',
        'virtual' => 'boolean',

        # Numeric fields
        'quantity' => 'integer',
        'price' => 'double',
        'additional_shipping_cost' => 'double',
        'width' => 'double',
        'height' => 'double',
        'weight' => 'double',
        'out_of_stock' => 'integer'
    ];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->slugsShouldBeNoLongerThan(190);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('product_featured_image')
            ->singleFile();

        $this->addMediaCollection('product_gallery');
    }
}
