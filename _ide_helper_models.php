<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $language
 * @property string $title
 * @property string $content
 * @property bool $is_active
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AboutUs newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AboutUs newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AboutUs query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AboutUs whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AboutUs whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AboutUs whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AboutUs whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AboutUs whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AboutUs whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AboutUs whereUpdatedAt($value)
 */
	final class AboutUs extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property string $color
 * @property bool $is_active
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\BlogPost> $blogPosts
 * @property-read int|null $blog_posts_count
 * @property-read int $posts_count
 * @method static \Database\Factories\BlogCategoryFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BlogCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BlogCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BlogCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BlogCategory whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BlogCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BlogCategory whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BlogCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BlogCategory whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BlogCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BlogCategory whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BlogCategory whereUpdatedAt($value)
 */
	final class BlogCategory extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string|null $excerpt
 * @property string $content
 * @property string|null $featured_image
 * @property int $blog_category_id
 * @property int $user_id
 * @property bool $is_published
 * @property \Carbon\CarbonImmutable|null $published_at
 * @property array<array-key, mixed>|null $meta_data
 * @property int $views_count
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\User $author
 * @property-read \App\Models\BlogCategory $category
 * @property-read string $reading_time
 * @property-read string $status
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BlogPost byCategory(int $categoryId)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BlogPost draft()
 * @method static \Database\Factories\BlogPostFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BlogPost newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BlogPost newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BlogPost published()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BlogPost query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BlogPost whereBlogCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BlogPost whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BlogPost whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BlogPost whereExcerpt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BlogPost whereFeaturedImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BlogPost whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BlogPost whereIsPublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BlogPost whereMetaData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BlogPost wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BlogPost whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BlogPost whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BlogPost whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BlogPost whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BlogPost whereViewsCount($value)
 */
	final class BlogPost extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $status
 * @property string|null $lead
 * @property string|null $content
 * @property int|null $ord
 * @property string|null $meta_title
 * @property string|null $meta_keywords
 * @property string|null $meta_description
 * @property string|null $lang
 * @property string|null $tags
 * @property string|null $lead_pic
 * @property string|null $sdf
 * @property string|null $file
 * @property int|null $ok
 * @property string|null $mysep
 * @property string|null $link
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Page> $pages
 * @property-read int|null $pages_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Content newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Content newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Content query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Content whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Content whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Content whereFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Content whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Content whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Content whereLead($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Content whereLeadPic($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Content whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Content whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Content whereMetaKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Content whereMetaTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Content whereMysep($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Content whereOk($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Content whereOrd($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Content whereSdf($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Content whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Content whereTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Content whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Content whereUpdatedAt($value)
 */
	final class Content extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Galery newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Galery newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Galery query()
 */
	final class Galery extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string|null $path
 * @property int $target_table_id
 * @property int|null $ord
 * @property string|null $size
 * @property \Carbon\CarbonImmutable|null $date
 * @property string|null $target_table
 * @property string|null $path_without_size_and_ext
 * @property string|null $alt
 * @property int|null $gallery_category_id
 * @property string|null $video_url
 * @property array<array-key, mixed>|null $images
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read string $image_url
 * @property-read string $public_url
 * @property-read \App\Models\Property|null $property
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gallery newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gallery newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gallery query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gallery whereAlt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gallery whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gallery whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gallery whereGalleryCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gallery whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gallery whereImages($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gallery whereOrd($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gallery wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gallery wherePathWithoutSizeAndExt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gallery whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gallery whereTargetTable($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gallery whereTargetTableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gallery whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gallery whereVideoUrl($value)
 */
	final class Gallery extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $language
 * @property string $title
 * @property string|null $content
 * @property bool $is_active
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Impresszum newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Impresszum newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Impresszum query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Impresszum whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Impresszum whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Impresszum whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Impresszum whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Impresszum whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Impresszum whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Impresszum whereUpdatedAt($value)
 */
	final class Impresszum extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $title
 * @property string|null $slug
 * @property string|null $excerpt
 * @property string $content
 * @property string|null $featured_image
 * @property int|null $news_category_id
 * @property int $user_id
 * @property bool $is_published
 * @property bool $is_breaking
 * @property \Carbon\CarbonImmutable|null $published_at
 * @property array<array-key, mixed>|null $meta_data
 * @property int $views_count
 * @property int $priority
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\User $author
 * @property-read \App\Models\NewsCategory|null $category
 * @property-read string $priority_label
 * @property-read string $reading_time
 * @property-read string $status
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News breaking()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News draft()
 * @method static \Database\Factories\NewsFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News whereExcerpt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News whereFeaturedImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News whereIsBreaking($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News whereIsPublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News whereMetaData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News whereNewsCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News whereViewsCount($value)
 */
	final class News extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property string $color
 * @property string|null $icon
 * @property bool $is_active
 * @property int $sort_order
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read int|null $news_count
 * @property-read int|null $published_news_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\News> $news
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\News> $publishedNews
 * @method static \Database\Factories\NewsCategoryFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NewsCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NewsCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NewsCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NewsCategory whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NewsCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NewsCategory whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NewsCategory whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NewsCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NewsCategory whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NewsCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NewsCategory whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NewsCategory whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NewsCategory whereUpdatedAt($value)
 */
	final class NewsCategory extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $title
 * @property string $url
 * @property int $ord
 * @property string $template
 * @property int $parent_id
 * @property int|null $show_menu
 * @property string|null $type
 * @property string|null $content_id
 * @property string|null $title_url
 * @property int|null $content_category_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Content> $contents
 * @property-read int|null $contents_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Page newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Page newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Page query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Page whereContentCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Page whereContentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Page whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Page whereOrd($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Page whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Page whereShowMenu($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Page whereTemplate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Page whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Page whereTitleUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Page whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Page whereUrl($value)
 */
	final class Page extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $iranyitoszam
 * @property string $helyiseg
 * @property string $megye
 * @property string|null $created_at
 * @property string|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostCode newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostCode newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostCode query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostCode whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostCode whereHelyiseg($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostCode whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostCode whereIranyitoszam($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostCode whereMegye($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostCode whereUpdatedAt($value)
 */
	final class PostCode extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $slug
 * @property bool $featured
 * @property array<array-key, mixed>|null $property_photos
 * @property string|null $status
 * @property string|null $lead
 * @property string|null $content
 * @property string $date
 * @property int|null $ord
 * @property string|null $meta_title
 * @property string|null $meta_title_en
 * @property string|null $meta_keywords
 * @property string|null $meta_keywords_en
 * @property string|null $meta_description
 * @property string|null $meta_description_en
 * @property string|null $construction_year
 * @property string|null $total_area
 * @property string|null $jelenleg_kiado
 * @property string|null $max_berleti_dij
 * @property string|null $uzemeletetesi_dij
 * @property string|null $raktar_terulet
 * @property string|null $raktar_berleti_dij
 * @property string|null $parkolas
 * @property string|null $kozos_teruleti_arany
 * @property string|null $cim_irsz
 * @property string|null $cim_varos
 * @property string|null $district
 * @property string|null $cim_utca
 * @property string|null $cim_hazszam
 * @property \Illuminate\Database\Eloquent\Collection<int, \App\Models\Tag> $tags
 * @property \Illuminate\Database\Eloquent\Collection<int, \App\Models\Service> $services
 * @property string|null $maps_lat
 * @property string|null $maps_lng
 * @property string|null $azonosito
 * @property string|null $osszterulet_addons
 * @property string|null $max_berleti_dij_addons
 * @property string|null $min_berleti_dij
 * @property string|null $min_berleti_dij_addons
 * @property string|null $raktar_terulet_addons
 * @property string|null $raktar_berleti_dij_addons
 * @property string|null $uzemeletetesi_dij_addons
 * @property string|null $min_parkolas_dija
 * @property string|null $min_parkolas_dija_addons
 * @property string|null $max_parkolas_dija
 * @property string|null $max_parkolas_dija_addons
 * @property string|null $kozos_teruleti_arany_addons
 * @property string|null $min_kiado
 * @property string|null $min_kiado_addons
 * @property string|null $jelenleg_kiado_addons
 * @property string|null $kodszam
 * @property string|null $en_content
 * @property string|null $min_berleti_idoszak
 * @property string|null $min_berleti_idoszak_addons
 * @property string|null $cim_utca_addons
 * @property string|null $lang
 * @property string|null $cimke
 * @property string|null $service
 * @property string|null $maps
 * @property string|null $elado_v_kiado
 * @property string|null $elado_v_kiado_addons
 * @property string|null $updated
 * @property string|null $egyeb
 * @property bool $vat
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read string|null $first_image_url
 * @property-read array $image_urls
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Gallery> $images
 * @property-read int|null $images_count
 * @property-read int|null $services_count
 * @property-read int|null $tags_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereAzonosito($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereCimHazszam($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereCimIrsz($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereCimUtca($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereCimUtcaAddons($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereCimVaros($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereCimke($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereConstructionYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereEgyeb($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereEladoVKiado($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereEladoVKiadoAddons($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereEnContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereFeatured($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereJelenlegKiado($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereJelenlegKiadoAddons($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereKodszam($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereKozosTeruletiArany($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereKozosTeruletiAranyAddons($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereLead($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereMaps($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereMapsLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereMapsLng($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereMaxBerletiDij($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereMaxBerletiDijAddons($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereMaxParkolasDija($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereMaxParkolasDijaAddons($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereMetaDescriptionEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereMetaKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereMetaKeywordsEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereMetaTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereMetaTitleEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereMinBerletiDij($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereMinBerletiDijAddons($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereMinBerletiIdoszak($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereMinBerletiIdoszakAddons($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereMinKiado($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereMinKiadoAddons($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereMinParkolasDija($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereMinParkolasDijaAddons($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereOrd($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereOsszteruletAddons($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereParkolas($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property wherePropertyPhotos($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereRaktarBerletiDij($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereRaktarBerletiDijAddons($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereRaktarTerulet($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereRaktarTeruletAddons($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereService($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereServices($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereTotalArea($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereUzemeletetesiDij($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereUzemeletetesiDijAddons($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereVat($value)
 */
	final class Property extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $phone
 * @property string $email
 * @property string|null $company
 * @property string|null $message
 * @property int|null $property_id
 * @property string|null $property_name
 * @property string $status
 * @property \Carbon\CarbonImmutable|null $contacted_at
 * @property string|null $notes
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read string $status_color
 * @property-read string $status_label
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuoteRequest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuoteRequest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuoteRequest query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuoteRequest whereCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuoteRequest whereContactedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuoteRequest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuoteRequest whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuoteRequest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuoteRequest whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuoteRequest whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuoteRequest whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuoteRequest wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuoteRequest wherePropertyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuoteRequest wherePropertyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuoteRequest whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuoteRequest whereUpdatedAt($value)
 */
	final class QuoteRequest extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string|null $image
 * @property int $order
 * @property bool $is_active
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @method static \Database\Factories\ReferenceFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reference newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reference newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reference query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reference whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reference whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reference whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reference whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reference whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reference whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reference whereUpdatedAt($value)
 */
	final class Reference extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereUpdatedAt($value)
 */
	final class Service extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property int|null $ord
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag whereOrd($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag whereUpdatedAt($value)
 */
	final class Tag extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $client_name
 * @property string|null $client_position
 * @property string|null $client_company
 * @property string $testimonial
 * @property string|null $client_image
 * @property string|null $company_logo
 * @property int $rating
 * @property string|null $project_type
 * @property bool $is_featured
 * @property bool $is_active
 * @property int $order
 * @property string $lang
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Testimonial newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Testimonial newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Testimonial query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Testimonial whereClientCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Testimonial whereClientImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Testimonial whereClientName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Testimonial whereClientPosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Testimonial whereCompanyLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Testimonial whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Testimonial whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Testimonial whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Testimonial whereIsFeatured($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Testimonial whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Testimonial whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Testimonial whereProjectType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Testimonial whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Testimonial whereTestimonial($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Testimonial whereUpdatedAt($value)
 */
	final class Testimonial extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $translated
 * @property \Carbon\CarbonImmutable|null $date
 * @property string|null $lang
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Translate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Translate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Translate query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Translate whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Translate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Translate whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Translate whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Translate whereTranslated($value)
 */
	final class Translate extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Carbon\CarbonImmutable|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 */
	final class User extends \Eloquent implements \Filament\Models\Contracts\FilamentUser {}
}

