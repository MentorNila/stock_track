<?php

Route::group(['module' => 'Taxonomy', 'middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\Taxonomy\Controllers'], function() {
    Route::get('taxonomy/presentation', [
        'as' => 'taxonomy.presentation',
        'uses' => 'TaxonomyController@presentation'
    ]);

    Route::get('taxonomy/get-axis', [
        'as' => 'taxonomy.get-axis',
        'uses' => 'TaxonomyController@getAxis'
    ]);
    Route::get('taxonomy/get-monetary', [
        'as' => 'taxonomy.get-monetary',
        'uses' => 'TaxonomyController@getMonetary'
    ]);

    Route::get('taxonomy/get-members', [
        'as' => 'taxonomy.get-members',
        'uses' => 'TaxonomyController@getMembers'
    ]);

    /*Route::get('render-taxonomy', [
        'as' => 'render-taxonomy',
        'uses' => 'GenerateFilingsController@renderTaxonomy'
    ]);*/

    Route::get('taxonomy/load-taxonomy', [
        'as' => 'taxonomy.load-taxonomy',
        'uses' => 'TaxonomyController@loadTaxonomy'
    ]);


    Route::get('taxonomy/store-taxonomy', [
        'as' => 'taxonomy.store-taxonomy',
        'uses' => 'TaxonomyController@storeTaxonomy'
    ]);

    Route::get('taxonomy/index-elastic', [
        'as' => 'taxonomy.index-elastic',
        'uses' => 'TaxonomyController@indexTaxonomy'
    ]);

    Route::get('taxonomy/get-taxonomy-parents', [
        'as' => 'taxonomy.get-taxonomy-parents',
        'uses' => 'TaxonomyController@getTaxonomyParentElements'
    ]);

    Route::post('taxonomy/add-new-tag', [
        'as' => 'taxonomy.add-new-tag',
        'uses' => 'ExtensionTaxonomyController@store'
    ]);
});
