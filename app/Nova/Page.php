<?php

namespace App\Nova;

use Benjaminhirsch\NovaSlugField\Slug;
use Benjaminhirsch\NovaSlugField\TextWithSlug;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Text;
use GeneaLabs\NovaMapMarkerField\MapMarker;
use Laravel\Nova\Panel;
use Pdewit\ExternalUrl\ExternalUrl;
use Illuminate\Support\Str;
use Johnathan\NovaTrumbowyg\NovaTrumbowyg;

class Page extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\\Page';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'navn';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'navn'
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            TextWithSlug::make('Navn')
                ->slug('slug')
                ->sortable()
                ->rules('required', 'max:255'),

            Slug::make('Slug'),

            NovaTrumbowyg::make('Content')->alwaysShow()->hideFromIndex(),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }

    public static function label()
    {
        return "Sider";
    }

    public static function singularLabel()
    {
        return "Side";
    }

    public static function uriKey()
    {
        return Str::slug(static::label());
    }
}
