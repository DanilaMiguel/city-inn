<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use MrMonat\Translatable\Translatable;
use OptimistDigital\MediaField\MediaField;

class Slide extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Slide::class;

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
            Text::make("Назва","title")->sortable(),
            Translatable::make("Заголовок","header"),
            Translatable::make("Опис","description"),
            Translatable::make("Додатковий текст","description_adder"),
            Translatable::make("Текст кнопки","button_text"),
            Text::make("Посилання кнопки","button_link"),
            MediaField::make('Зображення', 'image'),
            MediaField::make('Планшетне зображення', 'tablet_image'),
            MediaField::make('Мобільне зображення', 'mobile_image'),
            Number::make("Сортування",'sort')->default(100)->sortable(),
            Text::make("Початок роботи","work_start"),
            Text::make("Закінчення роботи","work_end"),
            BelongsToMany::make('Іконки',"icons","App\Nova\Icon"),
            BelongsToMany::make('Контакти',"contacts","App\Nova\ContactItem")
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
