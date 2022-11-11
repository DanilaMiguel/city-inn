<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Heading;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Http\Requests\NovaRequest;
use MrMonat\Translatable\Translatable;
use OptimistDigital\MediaField\MediaField;

class Page extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Page::class;


    /**
     * The name of menu Group item the resource corresponds to.
     *
     * @var string
     */
    public static $group = "Main";


    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

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
            Translatable::make("Підзаголовок","subtitle")->sortable(),
            Translatable::make("Опис","description")->sortable(),
            Number::make("Сортування",'sort')->default(100)->sortable(),
            MediaField::make('Головне зображення', 'head_image')->required(),
            MediaField::make('Головне планшетне зображення', 'tablet_head_image')->required(),
            MediaField::make('Головне мобільне зображення', 'mobile_head_image')->required(),

            Heading::make('SEO інформація'),
            Translatable::make("SEO title", "seo_title")->required(),
            Translatable::make("SEO description","seo_description")->required(),

            Heading::make('Інформацію розділу'),
            Translatable::make("Заголовок розділу на головній","section_title"),
            Text::make("Клас разділу на головній","section_name"),
            MediaField::make("Зображення на головній", 'section_image'),
            MediaField::make("Планшетне зображення на головній", 'tablet_section_image'),
            MediaField::make("Мобільне зображення на головній", 'mobile_section_image'),
            Translatable::make("Заголовок розділу №1","header_one"),
            Translatable::make("Заголовок розділу №2","header_two"),
            Boolean::make("Відображення на головній","show_on_main"),
            Translatable::make("Текст кнопки бронювання","reserve_text"),
            Text::make("Посилання кнопки бронювання","reserve_link"),
            Translatable::make("Текст кнопки 'Більше'","more_text"),
            Text::make("Посилання кнопки 'Більше'","more_link"),
            Text::make("Початок роботи сервіса","work_start"),
            Text::make("Закінчення роботи сервіса","work_end"),
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
        return __('Сторінки та розділи');
    }
}
