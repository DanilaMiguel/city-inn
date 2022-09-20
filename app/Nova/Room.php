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
            Translatable::make("Назва","title")->sortable()->required(),
            Text::make("Код","code")->required(),
            Text::make("XML","xml_id")->required(),
            Number::make("Сортування",'sort')->default(100)->sortable(),
            MediaField::make("Прев'ю", 'preview_image')->required(),
            MediaField::make("Планшетне Прев'ю", 'tablet_preview_image')->required(),
            MediaField::make("Мобільне Прев'ю", 'mobile_preview_image')->required(),
            Translatable::make("Опис","description")->required(),
            Boolean::make("Активність","active"),
            Text::make("Посилання на бронювання","book_link")->required(),
            Translatable::make("SEO title","seo_title")->required(),
            Translatable::make("SEO description","seo_description")->required(),
            MediaField::make('Зображення', 'images')->multiple()->required(),
            MediaField::make('Планшетні зображення', 'tablet_images')->multiple()->required(),
            MediaField::make('Мобільні зображення', 'mobile_images')->multiple()->required(),
            Text::make("Ціна","price")->required(),
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

    /**
     * The name of menu item the resource corresponds to.
     *
     * @return array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Translation\Translator|string|null
     */
    public static function label()
    {
        return __('Кімнати');
    }
}
