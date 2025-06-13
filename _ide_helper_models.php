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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cimke newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cimke newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cimke query()
 */
	class Cimke extends \Eloquent {}
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
 * @property string|null $date
 * @property int|null $ord
 * @property string|null $meta_title
 * @property string|null $meta_keywords
 * @property string|null $meta_description
 * @property string|null $lang
 * @property string|null $cimke_json
 * @property string|null $lead_pic
 * @property string|null $sdf
 * @property string|null $file
 * @property int|null $ok
 * @property string|null $mysep
 * @property string|null $link
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Content newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Content newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Content query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Content whereCimkeJson($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Content whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Content whereDate($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Content whereTitle($value)
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
 * @property string $title
 * @property string $url
 * @property int $ord
 * @property string $template
 * @property int $parent_id
 * @property string|null $need_login Permission name: admin, super-admin, user or empty
 * @property int|null $show_menu
 * @property string|null $date
 * @property string|null $type
 * @property string|null $content_json
 * @property string|null $title_url
 * @property int $sow_just_super_admin
 * @property int|null $content_category_id
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Page newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Page newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Page query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Page whereContentCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Page whereContentJson($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Page whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Page whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Page whereNeedLogin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Page whereOrd($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Page whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Page whereShowMenu($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Page whereSowJustSuperAdmin($value)
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
 * @property string|null $title
 * @property string|null $status
 * @property string|null $content
 * @property string $date
 * @property string|null $meta_title
 * @property string|null $meta_title_en
 * @property string|null $meta_keywords
 * @property string|null $meta_keywords_en
 * @property string|null $meta_description
 * @property string|null $meta_description_en
 * @property string|null $epites_eve
 * @property string|null $osszterulet
 * @property string|null $jelenleg_kiado
 * @property string|null $max_berleti_dij
 * @property string|null $uzemeletetesi_dij
 * @property string|null $raktar_terulet
 * @property string|null $raktar_berleti_dij
 * @property string|null $parkolas
 * @property string|null $cim_irsz
 * @property string|null $cim_varos
 * @property string|null $cim_utca
 * @property string|null $cim_hazszam
 * @property array<array-key, mixed>|null $cimke_json
 * @property array<array-key, mixed>|null $service_json
 * @property string|null $maps_lat
 * @property string|null $maps_lng
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
 * @property string|null $maps
 * @property string|null $elado_v_kiado
 * @property string|null $updated
 * @property string|null $test
 * @property string|null $egyeb
 * @property string|null $afa
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereAfa($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereCimHazszam($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereCimIrsz($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereCimUtca($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereCimUtcaAddons($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereCimVaros($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereCimkeJson($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereEgyeb($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereEladoVKiado($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereEnContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereEpitesEve($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereJelenlegKiado($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereJelenlegKiadoAddons($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereKodszam($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereKozosTeruletiAranyAddons($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereLang($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereOsszterulet($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereOsszteruletAddons($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereParkolas($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereRaktarBerletiDij($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereRaktarBerletiDijAddons($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereRaktarTerulet($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereRaktarTeruletAddons($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereServiceJson($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereTest($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereUzemeletetesiDij($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereUzemeletetesiDijAddons($value)
 */
	final class Property extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string|null $date
 * @property string $name
 * @property int|null $ord
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereOrd($value)
 */
	final class Service extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
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

