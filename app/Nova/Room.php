<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use MrMonat\Translatable\Translatable;
use OptimistDigital\MediaField\MediaField;

class Room extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Room::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
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
            ID::make(__('ID'), 'id')->sortable(),
            Translatable::make("Назва","title")->sortable(),
            Text::make("Код","code"),
            Text::make("XML","xml_id"),
            Number::make("Сортування",'sort')->default(100)->sortable(),
            MediaField::make("Прев'ю", 'preview_image'),
            MediaField::make("Планшетне Прев'ю", 'tablet_preview_image'),
            MediaField::make("Мобільне Прев'ю", 'mobile_preview_image'),
            Translatable::make("Опис","description"),
            Boolean::make("Активність","active"),
            Text::make("Посилання на бронювання","book_link"),
            Translatable::make("SEO title","seo_title"),
            Translatable::make("SEO description","seo_description"),
            MediaField::make('Зображення', 'images')->multiple(),
            MediaField::make('Планшетні зображення', 'tablet_images')->multiple(),
            MediaField::make('Мобільні зображення', 'mobile_images')->multiple(),
            Text::make("Ціна","price"),
            BelongsToMany::make('Основні сервіси',"features","App\Nova\Icon"),
            BelongsToMany::make('Включено в ціну',"cost_include","App\Nova\Icon"),
            BelongsToMany::make("Прев'ю іконки","main_features","App\Nova\Icon"),
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
}
