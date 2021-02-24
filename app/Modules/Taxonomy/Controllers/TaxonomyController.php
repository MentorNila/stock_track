<?php

namespace App\Modules\Taxonomy\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Taxonomy\Logic\Taxonomy;
use App\Modules\Taxonomy\Logic\TaxonomyFilesParser;
use Elasticsearch\ClientBuilder;
use Symfony\Component\HttpFoundation\Response;
use Gate;

class TaxonomyController extends Controller{

    public function indexTaxonomy(){
        $hosts = ['0.0.0.0:9200'];
        $client = Clientbuilder::create()->build();
        $indexParams['index']  = 'taxonomy_2019';
        if ($client->indices()->exists($indexParams)){
            dd('Taxonomy elements are already indexed, delete elasticsearch index if you want to update taxonomy!!!');
        }
//        $response = $client->indices()->delete($indexParams);
//        exit;

        $taxonomyFileParser = new TaxonomyFilesParser('us-gaap-2019-01-31','2019','xsd');
        $rolesFile = $taxonomyFileParser->getFiles('us-gaap-2019-01-31');

        $taxonomyFileParser = new TaxonomyFilesParser('us-gaap-2019-01-31','-pre-', 'xml');
        $presentationFiles = $taxonomyFileParser->getFiles('us-gaap-2019-01-31');

        $taxonomy = new Taxonomy($presentationFiles, $rolesFile);
        $taxonomy->indexRoles();
        $taxonomy->indexTaxonomyElements();

        dd('Taxonomy elements have been indexed!');
    }

    function getTaxonomyParentElements(){
        $companyId = 0;
        $parentId = \Request::all()['id'];
        if (isset(\Request::all()['company_id'])){
            $companyId = \Request::all()['company_id'];
        }
        $taxonomy = new Taxonomy();
        $parents = $taxonomy->getTaxonomyChildrenByParentId($parentId, $companyId);
        return \GuzzleHttp\json_encode($parents);
    }

    function presentation(){
        abort_if(Gate::denies('taxonomy_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('Taxonomy::presentation');
    }
}
