<?php

namespace App\Observers;

use MakeIT\LaravelCurrencyExtractor\Models\Currency as Model;

class CurrencyObserver
{
    /**
     * @param  Model  $category
     * @return void
     */
    public function creating(Model $model)
    {
    }

    /**
     * @param  Model  $category
     * @return void
     */
    public function created(Model $model)
    {
    }

    /**
     * @param  Model  $category
     * @return void
     */
    public function updating(Model $model)
    {
    }

    /**
     * @param  Model  $category
     * @return void
     */
    public function updated(Model $model)
    {
    }

    /**
     * @param  Model  $category
     * @return void
     */
    public function deleting(Model $model)
    {
    }

    /**
     * @param  Model  $category
     * @return void
     */
    public function deleted(Model $model)
    {
    }

    /**
     * @param  Model  $category
     * @return void
     */
    public function restoring(Model $model)
    {
    }

    /**
     * @param  Model  $category
     * @return void
     */
    public function restored(Model $model)
    {
    }

    /**
     * @param  Model  $category
     * @return void
     */
    public function forceDeleting(Model $model)
    {
    }

    /**
     * @param  Model  $category
     * @return void
     */
    public function forceDeleted(Model $model)
    {
    }
}
