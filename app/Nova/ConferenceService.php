<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Heading;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use MrMonat\Translatable\Translatable;
use OptimistDigital\MediaField\MediaField;

class ConferenceService extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\ConferenceService::class;


    /**
     * The name of menu Group item the resource corresponds to.
     *
     * @var string
     */
    public static $group = "Генеровані сторінки";


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
            Translatable::make("Заголовок","title")->sortable()->required(),
            Translatable::make("Опис","description")->required(),
            Text::make("Код", "code")->required(),
            MediaField::make("Головне зображення","head_image")->required(),
            MediaField::make("Головне планшетне зображення","tablet_head_image")->required(),
            MediaField::make("Головне мобільне зображення","mobile_head_image")->required(),

            Heading::make('Інформація розділу'),
            Translatable::make("Заголовок на сторінці розділу","section_title")->required(),
            Translatable::make("Опис на сторінці розділу","section_description")->required(),
            MediaField::make('Зображення на сторінці розділу', 'preview_image')->required(),
            MediaField::make('Планшетне зображення на сторінці розділу', 'tablet_preview_image')->required(),
            MediaField::make('Мобільне зображення на сторінці розділу', 'mobile_preview_image')->required(),

            Heading::make('SEO інформація'),
            Translatable::make("SEO Заголовок","seo_title")->required(),
            Translatable::make("SEO Опис","seo_description")->required(),

            Heading::make('Загальна інформація'),
            Boolean::make("Активність","active"),
            Number::make("Сортування",'sort')->default(100)->sortable(),
            Translatable::make('Текст кнопки замовлення' , "button_text")->required(),
            Text::make('Посилання кнопки замовлення' , "button_link")->required(),


            Translatable::make('Заголовок блоку "Чому ми?"' , "why_title")->required(),
            MediaField::make('Зображення блоку "Чому ми?"', 'why_images')->multiple()->required(),
            MediaField::make('Планшетне зображення блоку "Чому ми?"', 'tablet_why_images')->multiple()->required(),
            MediaField::make('Мобільне зображення блоку "Чому ми?"', 'mobile_why_images')->multiple()->required(),

            Translatable::make('Заголовок блока "Паркінг"' , "park_title")->required(),
            Translatable::make('Опис блоку "Паркінг"' , "park_description")->required(),
            MediaField::make('Зображення блоку "Паркінг"', 'park_image')->required(),
            MediaField::make('Планшетне зображення блоку "Паркінг"', 'tablet_park_image')->required(),
            MediaField::make('Мобільне зображення блоку "Паркінг"', 'mobile_park_image')->required(),


            BelongsToMany::make('Іконки',"icons","App\Nova\Icon"),
            BelongsToMany::make('Цінова політика',"offers","App\Nova\BusinessSlide"),
            BelongsToMany::make('Харчування',"food","App\Nova\BusinessSlide"),
            BelongsToMany::make('Таби для блоку "Чому ми?"',"tabs","App\Nova\Tab"),
            BelongsToMany::make('Розсадки',"sittings","App\Nova\Sitting"),

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

    /**
     * The name of menu item the resource corresponds to.
     *
     * @return array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Translation\Translator|string|null
     */
    public static function label()
    {
        return __('Конференц сервіси');
    }
}
