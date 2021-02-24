<?php

namespace App\Modules\Taxonomy\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Client\Models\Client;
use App\Modules\Filing\Logic\GetFilingData;
use App\Modules\Filing\Models\Filing;
use App\Modules\Taxonomy\Logic\Taxonomy;
use Elasticsearch\ClientBuilder;

class ExtensionTaxonomyController extends Controller
{

    public function store()
    {
        $request = \Request::all();
        $filingID = $request['filingId'];
        $filingData = new GetFilingData($filingID);

        $company = $filingData->getCompany();
        $symbol = $company->symbol;
        $namespace = $company->uri;

        $hosts = ['0.0.0.0:9200'];
        $clientBuilder = Clientbuilder::create()->build();
        $parentId = $request['tag']['parent_id'];

        $params['index'] = 'taxonomy_2019';
        $params['type'] = 'element';
        $params['body'] =
            [
                'name' => (string)$request['tag']['name'],
                'id'  => $symbol . '_' . $request['tag']['name'],
                'code'  => $symbol . '_' . $request['tag']['name'],
                'abstract'  =>  $request['tag']['abstract'],
                'nillable'  => $request['tag']['nillable'],
                'type'  => $request['tag']['type'],
                'substitutionGroup'  => $request['tag']['substitutionGroup'],
                'balance'  => $request['tag']['balance'],
                'periodType'    => $request['tag']['periodType'],
                'namespace' => $namespace . '/'. $filingData->getEndDate(),
                'documentation' => $request['tag']['documentation'],
                'label' => [
                    [
                        'content' => $request['tag']['label'],
                        'role' => 'http://www.xbrl.org/2003/role/label']
                ],
            ];

        $clientBuilder->index($params);

        $newElementData = [
            'client_id' => Client::getCurrentClientId(),
            'company_id' => (string)$request['tag']['company_id'],
            'code' =>  $symbol . '_' . $request['tag']['name'],
            'label' => $request['tag']['label'],
        ];

        $taxonomy = new Taxonomy();
        $taxonomy->updateMultiDimensionalPresentationTree($parentId, $newElementData);


        return \Response::json(array(
            'id' => $parentId,
            'success' => true
        ));
    }

}
