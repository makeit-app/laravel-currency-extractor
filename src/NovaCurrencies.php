<?php

namespace App\Nova;

use App\Sorter;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use MakeIT\LaravelCurrencyExtractor\Models\Currency;

class NovaCurrencies extends Resource
{
    /**
     * The model the resource corresponds to.
     */
    public static string $model = Currency::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'code';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'is_active',
        'base',
        'code',
        'rate',
        Sorter::FIELD,
    ];

    public static function group(): string
    {
        return __('Currency');
    }

    public static function label(): string
    {
        return __('Currencies');
    }

    public static function singularLabel(): string
    {
        return __('Currency');
    }

    /**
     * Build an "index" query for the given resource.
     *
     * @param  Builder  $query
     */
    public static function indexQuery(NovaRequest $request, $query): Builder
    {
        if (empty($request->get('orderBy'))) {
            $query->getQuery()->orders = [];

            return $query->orderBy(Sorter::FIELD, 'ASC');
        }

        return $query;
    }

    /**
     * Get the fields displayed by the resource.
     */
    public function fields(NovaRequest $request): array
    {
        return [
            ID::make()->hideFromIndex(),
            Boolean::make(__('Is Acive'), 'is_active'),
            Select::make(__('Base Currency Code'), 'base')->options(
                array_combine(
                    config('currency-extractor.valutes'),
                    config('currency-extractor.valutes')
                )
            ),
            Select::make(__('Currency Code'), 'code')->options(
                array_combine(
                    config('currency-extractor.valutes'),
                    config('currency-extractor.valutes')
                )
            ),
            Number::make(__('Rate'), 'rate')->step(0.000001),
            Number::make(__('Sort Order'), Sorter::FIELD)->min(0)->step(1)->hideFromIndex(),
            Text::make(__('Convertion'), function () {
                $cnv = ! empty($this->rate) ? bcdiv(1 / $this->rate, 1, 2) : 0;

                return '<div>1 <strong>'.$this->code.'</strong> == '.$cnv.' <strong>'.$this->base.'</strong></div>';
            })->asHtml()->exceptOnForms(),
            DateTime::make(__('Updated At'), 'updated_at')->displayUsing(function ($datetime) {
                return $datetime->formatLocalized('%a, %d %B %Y');
            }),
        ];
    }

    public function subtitle(): string
    {
        return ''; //__( 'Rate' ) . ' ' . bcdiv( ( 1 / $this->rate ), 1, 2 );
    }
}
