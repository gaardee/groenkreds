<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use Mdixon18\Fontawesome\Fontawesome;
use Timothyasp\Badge\Badge;
use Benjaminhirsch\NovaSlugField\Slug;
use Benjaminhirsch\NovaSlugField\TextWithSlug;


class Aktivitet extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\\Aktivitet';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'title',
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
            ID::make()->sortable(),

            Badge::make('Type')->options([
                1 => 'Kredsen i lokalmiljøet',
                2 => 'Kredsens levevej',
                3 => 'Den legende kreds',
            ])->colors([
                1 => '#289438',
                2 => '#EC6411',
                3 => '#FBB800'
            ])->displayUsingLabels(),

            TextWithSlug::make('Titel', 'title')
                ->slug('slug')
                ->sortable()
                ->rules('required', 'max:255'),

            Slug::make('Slug'),

            Fontawesome::make('Ikon')->addButtonText('Vælg ikon'),

            Trix::make('Indhold')->alwaysShow(),

            Trix::make('Materialer')->alwaysShow()
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
        return "Aktiviteter";
    }

    public static function singularLabel()
    {
        return "Aktivitet";
    }
}
