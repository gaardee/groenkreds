<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Text;
use GeneaLabs\NovaMapMarkerField\MapMarker;
use Laravel\Nova\Panel;
use Pdewit\ExternalUrl\ExternalUrl;

class Kreds extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\\Kreds';

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
        'id', 'navn', 'key'
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
            Boolean::make('Aktiv', 'active'),

            Text::make('Navn')
                ->sortable()
                ->rules('required', 'max:255'),

            ExternalUrl::make('Kreds side', function () {
                return url("/kreds/{$this->key}");
            })->linkText('Åbn kreds side'),

            MapMarker::make("Location")
                ->latitude('latitude')
                ->longitude('longitude')->hideFromIndex(),


            new Panel('Kontaktperson', [

                Text::make('Navn', 'kontakt_navn')->hideFromIndex(),

                Text::make('Email', 'kontakt_email')->hideFromIndex(),

                Text::make('Telefon', 'kontakt_telefon')->hideFromIndex(),
            ]),
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
        return "Kredse";
    }

    public static function singularLabel()
    {
        return "Kreds";
    }
}
