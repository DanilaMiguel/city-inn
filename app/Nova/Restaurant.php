<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use MrMonat\Translatable\Translatable;
use OptimistDigital\MediaField\MediaField;

class Restaurant extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Restaurant::class;


    /**
     * The name of menu Group item the resource corresponds to.
     *
     * @var string
     */
    public static $group = "Сторінки";


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
            Translatable::make("Назва","title")->required(),
            Translatable::make("Опис","description"),
            Number::make("Сортування",'sort')->default(100)->sortable(),
            Boolean::make("Активність","active"),
            MediaField::make('Зображення', 'image')->multiple(),
            MediaField::make('Планшетне зображення', 'tablet_image')->multiple(),
            MediaField::make('Мобільне зображення', 'mobile_image')->multiple(),
            Translatable::make("Текст кнопки меню","menu_text"),
            Text::make("Посилання кнопки меню","menu_link"),
            Translatable::make("Текст кнопки бронювання","book_text"),
            Text::make("Посилання кнопки бронювання","book_link"),
            Text::make("Початок роботи сервіса","work_start"),
            Text::make("Закінчення роботи сервіса","work_end"),
            BelongsToMany::make('Слайди',"slides","App\Nova\Slide")
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
        return __('Ресторан');
    }
}
