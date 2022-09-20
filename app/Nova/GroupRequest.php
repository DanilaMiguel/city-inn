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

class GroupRequest extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\GroupRequest::class;


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
            Translatable::make("Підзаголовок","subtitle")->sortable(),
            Translatable::make("Опис","description"),
            MediaField::make('Зображення', 'images')->multiple(),
            MediaField::make('Планшетні зображення', 'tablet_images')->multiple(),
            MediaField::make('Мобільні зображення', 'mobile_images')->multiple(),
            Number::make("Сортування",'sort')->default(100)->sortable(),
            Boolean::make("Активність","active"),
            Boolean::make("SMART ROOMS","is_smart_number"),
            Translatable::make("Текст кнопки","button_text"),
            Text::make("Посилання кнопки","button_link"),
            Text::make("Початок работы","work_start"),
            Text::make("Закінчення работы","work_end"),
            BelongsToMany::make('Таби',"tabs","App\Nova\Tab"),
            BelongsToMany::make('Слайди',"slides","App\Nova\Slide"),
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
        return __('Group Request');
    }
}
