<?php

namespace App\Modules\Editor\Controllers;

use App\Modules\Editor\Logic\FilingLogic;
use App\Modules\Filing\Logic\Drafts;
use App\Modules\Filing\Logic\GetFilingData;
use App\Modules\Filing\Logic\Tags;
use App\Modules\Filing\Models\Filing;
use App\Http\Controllers\Controller;
use App\Modules\Company\Models\Company;
use App\Modules\Review\Logic\Comments;
use App\Modules\Taxonomy\Logic\Taxonomy;
use App\Modules\User\Logic\Users;
use App\Modules\User\Models\User;
use App\Modules\User\Models\UserCompany;
use App\Notifications\StatusChanged;
use Illuminate\Support\Facades\Notification;
use Symfony\Component\HttpFoundation\Response;
use Auth;
use DB;
use Illuminate\Http\Request;

class EditorController extends Controller
{
    public function index($filingId)
    {
        $filingLogic = new FilingLogic($filingId);
        $request = \Request::all();
        $filingData = $filingLogic->loadContent($request);
        $exhibits = $filingLogic->loadExhibits();
        $comment = new Comments();
        $comments = $comment->getFilingComments($filingId);
        return view('Editor::index')->with($filingData)
            ->with($filingData['filingProperties'])
            ->with(['exhibits' => $exhibits, 'comments' => $comments]);

    }

    public function upload(Request $request)
    {
        if($request->hasFile('upload')) {
            //get filename with extension
            $filenamewithextension = $request->file('upload')->getClientOriginalName();

            //get filename without extension
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);

            //get file extension
            $extension = $request->file('upload')->getClientOriginalExtension();

            //filename to store
            $filenametostore = $filename.'_'.time().'.'.$extension;

            //Upload File
            $request->file('upload')->storeAs('public/uploads', $filenametostore);

            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('storage/uploads/'.$filenametostore);
            $msg = 'Image successfully uploaded';
            $re = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";

            // Render HTML output
            @header('Content-type: text/html; charset=utf-8');
            echo $re;
        }
    }


    public function saveAsDraft(){
        $request = \Request::all();
        if (isset($request['filingId'])){
            $filingId = $request['filingId'];
            $htmlContent = $request['htmlContent'];
            $draft = new Drafts($filingId, $htmlContent);
            $draft->storeAsDraft();
            Filing::updateStatus($filingId, 'in progress');

        }
    }

    public function searchTag(){
        $request = \Request::all();
        $tag = '';
        $type = null;
        $substitutionGroup = null;

        if (isset($request['tag'])){
            $tag = $request['tag'];
        }
        if (isset($request['type']) && !is_null($request['type'])){
            $type = $request['type'];
        }
        if (isset($request['substitutionGroup']) && !is_null($request['substitutionGroup'])){
            $substitutionGroup = $request['substitutionGroup'];
        }

        $taxonomy = new Taxonomy();
        $results = $taxonomy->searchTag($tag, $type, $substitutionGroup);

        return \Response::json(array(
            'success'=> true,
            'results' => $results
        ), 200);

    }

    public function getTagPeriod(){
        $request = \Request::all();
        $tagName = $request['tagName'];
        $filingData = new GetFilingData($request['filingId']);

        $periods = $filingData->getFilingPeriod();

        $taxonomy = new Taxonomy();
        $tag = $tag = $taxonomy->getElementDataByLabel($tagName, false);

        if($tag){
            $view = (string)view('Editor::periods')->with('periodType', $tag['periodType'])->with($periods);
            return \Response::json(array(
                'success'=> true,
                'periods' => $view
            ), 200);
        } else {
            return \Response::json(array(
                'success' => false,
            ), 200);
        }
    }

    public function getTagAttributes(){
        $request = \Request::all();
        $tagName = $request['tagName'];
        $taxonomy = new Taxonomy();
        $tag = $taxonomy->getElementDataByLabel($tagName, false);
        unset($tag['id']);
        unset($tag['code']);

        if ($tag){
            if (isset($tag['abstract']) && $tag['abstract'] == ''){
                $tag['abstract'] = 'false';
            }
            if (isset($tag['nillable']) && $tag['nillable'] == ''){
                $tag['nillable'] = 'false';
            }

            $attributesView = (string)view('Editor::attributes')->with(['tags' => $tag]);

            return \Response::json(array(
                'success'=> true,
                'attributes' => $attributesView
            ), 200);
        } else {
            return \Response::json(array(
                'success' => false,
            ), 200);
        }
    }

    public function saveExhibitAsDraft(){
        $request = \Request::all();
        if (isset($request['filingId'])){
            $filingId = $request['filingId'];
            $htmlContent = $request['htmlContent'];
            $fileName = $request['fileName'];
            $draft = new Drafts($filingId, $htmlContent);
            $draft->storeExhibitAsDraft($fileName);
        }
    }

    public function checkTagType(){
        $request = \Request::all();
        if (isset($request['tagName'])) {
            $tagName = $request['tagName'];
            $taxonomy = new Taxonomy();
            $tag = $taxonomy->getElementDataByLabel($tagName, false);

            if ($tag && $tag['type'] == 'xbrli:monetaryItemType') {
                return \Response::json(array(
                    'success' => true,
                    'monetary' => true
                ), 200);
            }
        }

        return \Response::json(array(
            'success'=> true,
            'monetary' => false
        ), 200);
    }


    function getFilingProperties($filing){
dd('TESTE');
        $filingId = $filing->id;
        $userId = Auth::user()->id;
        $filingData = new GetFilingData($filing->id);
        $period = $filingData->getFilingPeriod();
        $companyId = $filingData->getCompanyId();
        $filingUser = Company::where('id',$companyId)->first()->user_id;
        $status = false;

        $companyFiling = UserCompany::where('user_id',$userId)->where('company_id',$companyId)->first();
        if(!Auth::user()->is_superadmin){
            abort_if($companyFiling == null, Response::HTTP_FORBIDDEN, '403 Forbidden');
        }

        return
            [
                'clientId' => $companyId,
                'period' => $period,
                'filingUser' => $filingUser,
                'status' => $status,
                'filingData' => $filingData,
                'filingId' => $filingId
            ];
    }

    function getTaxonomyElementWhereLike($text)
    {
        $taxonomy = new Taxonomy();
        return $taxonomy->getTaxonomyElementWhereLike($text);
    }

    public function storeTag(){
        $request = \Request::all();
        $tagId = null;
        $filingId = $request['filingId'];
        $attributes = $request['attributes'];

        if (isset($request['tagId'])){
            $tagId = $request['tagId'];
        }

        if (isset($request['level']) && !is_null($request['level'])){
            $attributes['level'] = $request['level'];
        }

        if ((isset($request['sectionId']) && !is_null($request['sectionId']))){
            $attributes['section_id'] = $request['sectionId'];
        }

        $tags = new Tags($filingId, $tagId, $attributes);
        $tagId = $tags->storeFilingTags();

        if ($tagId){
            return \Response::json(array(
                'success' => true,
                'tag_id' => $tagId
            ), 200);
        } else {
            return \Response::json(array(
                'success' => false
            ), 200);
        }
    }

    public function prepareModal(){
        $request = \Request::all();
        $attributes = null;
        $tagId = null;

        if (isset($request['tagId'])){
            $tagId = $request['tagId'];
        }

        if (isset($request['level'])){
            $attributes['level'] = $request['level'];
        }
        $tags = new Tags(null, $tagId, $attributes);

        $modalContent = $tags->getModalContent();

        return \Response::json(array(
            'success' => true,
            'content' => $modalContent
        ), 200);
    }

    public function deleteTag(){
        $request = \Request::all();
        if (isset($request['tagId']) && !is_null($request['tagId'])){
            $tagId = $request['tagId'];
            $tags = new Tags(null, $tagId);

            if ($tags->deleteTag()){
                return \Response::json(array(
                    'success' => true
                ), 200);
            }

        }
    }

    public function assignUsersToFiling(){
        $request = \Request::all();
        $userIds = [];
        if (isset($request['users'])){
            $userIds = $request['users'];
        }
        $filingId = $request['filingId'];
        $users = new Users();
        $users->assignUsersToFiling($userIds, $filingId);

        return \Response::json(array(
            'success' => true
        ), 200);
    }

    public function getUserFiling(){
        $request = \Request::all();
        $filingId = $request['filingId'];
        $usersContent = '';
        $users = new Users();
        $assignedUsers = $users->getAssignedUsersFiling($filingId);
        $availableUsers = $users->getAvailableUsersToAssign($assignedUsers);

        if (!empty($assignedUsers) || !empty($availableUsers)){
            $usersContent = (new Users())->prepareUsersAsOptions($assignedUsers, $availableUsers);
        }

        return \Response::json(array(
            'success' => true,
            'content' => $usersContent
        ), 200);
    }

    public function getComments(){
        $request = \Request::all();
        if (isset($request['commentId']) && !is_null($request['commentId'])){
            $comments = new Comments();
            $modalData = $comments->prepareModal($request['commentId']);

            return \Response::json(array(
                'success' => true,
                'content' => $modalData
            ), 200);
        }

        return \Response::json(array(
            'success' => false
        ), 200);
    }
}
