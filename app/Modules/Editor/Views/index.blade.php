@extends('layouts.editor')
@section('vendor-styles')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/css/forms/select/select2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/css/pickers/pickadate/pickadate.css')}}">
    <style>
        .card-body {
            padding-top: 0 !important;
        }
        .card-header{
            padding-top: 0 !important;
        }
        .nav-tabs .nav-link, .nav-pills .nav-link {
            background-color: #ffffff !important;
        }
        .nav-pills .nav-link.active, .nav-pills .show > .nav-link {
            background-color: #5A8DEE !important;
        }
        #taxonomy-tree li {
            background-color: transparent !important;
        }
        .users .select2-container {
            width: 100% !important;
        }
    </style>
    <link rel="stylesheet" href="{{asset('css/Aimara.css')}}">
@endsection
@section('content')
@if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif
<div class="card">
    <div class="card-header">

        <div class="col-12 d-flex flex-sm-row flex-column justify-content-end mt-1">
            @if(in_array($formType, ['Form3','Form4','Form5','FormD','13FHR'], true ))
                @can('filing_data_edit')
                    <button class="btn btn-secondary glow mb-1 mb-sm-0 mr-0 mr-sm-1" id="edit-content">Edit Mode</button>
                @endcan
            @endif
            <button class="btn btn-primary glow mb-1 mb-sm-0 mr-0 mr-sm-1" data-filing-id="{{$filingId}}" @if($filing) id="saveDraft" @else id="saveExhibitDraft" data-exhibit-type="{{$fileName}}" @endif>Save as Draft</button>
            @if(in_array($formType, ['Form3','Form4','Form5','FormD','13FHR'], true ))
                <button class="btn btn-primary glow mb-1 mb-sm-0 mr-0 mr-sm-1" data-client-id="{{$companyId}}" data-filing-id="{{$filingId}}" data-form-type="{{$formType}}" id="generateFiles">Generate Files</button>
            @endif
            <a type="reset" href="{{ route("filing-datas.index") }}" onclick="return confirm('Are you sure you want to go back?');" class="btn btn-light">Cancel</a>
        </div>
    </div>

    <div class="card-body">
        @if(!in_array($formType, ['Form3','Form4','Form5','FormD','13FHR'], true ))
            <div class="container">

                <div class="inner-container" style="display: flex;position: relative;">
                    <div style="background-color: #fff;padding: 20px 10px 10px 10px;box-shadow: 5px 5px 25px #d7dadc;position: relative;" id="content">
                        <textarea class="form-control" cols="80" rows="10" id="document-ckeditor" name="document-ckeditor">
                            {!! $content !!}
                        </textarea>
                    </div>
                    @include('partials.comments')
                </div>
            </div>
        @else
            <div style="background-color: #fff;padding: 20px 10px 10px 10px;box-shadow: 5px 5px 25px #d7dadc;" id="content">
                {!! $content !!}
            </div>

        @endif
        <div id="update-content" style="display: none;"></div>
    </div>
</div>

@if(!$exhibitMode)
    <div class="modal fade" data-keyboard="false" data-backdrop="static" id="attributesModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"></div>
    <div class="modal fade" data-keyboard="false" data-backdrop="static" id="commentsModal" tabindex="-1" role="dialog" aria-labelledby="commentsModal" aria-hidden="true">
        <div class="modal-dialog" role="document" style="margin-top: 15%;width: 400px;">
            <div class="modal-content">
                <div class="modal-body">
                    <form id="addCommentForm">
                        <div class="modal-body">
                            <div class="form-group">
                                <textarea style="height: calc(1.4em + 0.94rem + 3.7px);" name="comment" placeholder="Comment" id="comment" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer" style="padding: 0 2.3rem;border-top: none;">
                            <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Close</span>
                            </button>
                            <button class="btn btn-primary ml-1" id="add-comment">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Comment</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" data-keyboard="false" data-backdrop="static" id="extensionTagModal" tabindex="-1" role="dialog" aria-labelledby="extensionTagModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="modal-header">
                        <h4 class="modal-title" id="addModalLabel">Add Tag</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="bx bx-x"></i>
                        </button>
                    </div>
                    <form id="tagForm">
                        <div class="modal-body">
                            <div class="form-group">
                                <input hidden="hidden" name="filing_id" value="{{$filingId}}">
                                <input hidden="hidden" id="company_id" name="company_id" value="{{$companyId}}">
                                <input class="form-control" name="label" type="text" placeholder="Label">
                            </div>
                            <div class="form-group">
                                <input class="form-control" name="name" type="text" placeholder="Name">
                            </div>
                            <div class="form-group">
                                <select class="form-control" name="type">
                                    <option disabled selected>Select Type</option>
                                    <option value="xbrli:decimalItemType">Decimal</option>
                                    <option value="xbrli:floatItemType">Float</option>
                                    <option value="xbrli:integerItemType">Integer</option>
                                    <option value="xbrli:nonPositiveIntegerItemType">Non Positive Integer</option>
                                    <option value="xbrli:negativeIntegerItemType">Negative Integer</option>
                                    <option value="xbrli:longItemType">Long</option>
                                    <option value="xbrli:intItemType">Int</option>
                                    <option value="xbrli:shortItemType">Short</option>
                                    <option value="xbrli:byteItemType">Byte</option>
                                    <option value="xbrli:nonNegativeIntegerItemType">Non negative Integer</option>
                                    <option value="xbrli:unsignedLongItemType">Unsigned Long</option>
                                    <option value="xbrli:unsignedIntItemType">Unsigned Int</option>
                                    <option value="xbrli:unsignedShortItemType">Unsigned Short</option>
                                    <option value="xbrli:unsignedByteItemType">Unsigned Byte</option>
                                    <option value="xbrli:positiveIntegerItemType">Positive Integer</option>
                                    <option value="xbrli:monetaryItemType">Monetary</option>
                                    <option value="xbrli:sharesItemType">Shares</option>
                                    <option value="num:percentItemType">Percent</option>
                                    <option value="num:pureItemType">Pure</option>
                                    <option value="xbrli:fractionItemType">Fraction</option>
                                    <option value="xbrli:stringItemType">String</option>
                                    <option value="xbrli:booleanItemType">Boolean</option>
                                    <option value="xbrli:hexBinaryItemType">Hex Binary</option>
                                    <option value="xbrli:base64BinaryItemType">Base 64 Binary</option>
                                    <option value="xbrli:anyURIItemType">Any URI</option>
                                    <option value="xbrli:QNameItemType">Q Name</option>
                                    <option value="xbrli:durationItemType">Duration</option>
                                    <option value="xbrli:dateTimeItemType">Date Time</option>
                                    <option value="xbrli:timeItemType">Time</option>
                                    <option value="xbrli:dateItemType">Date</option>
                                    <option value="xbrli:gYearMonthItemType">G Year Month</option>
                                    <option value="xbrli:gYearItemType">G Year</option>
                                    <option value="xbrli:gMonthDayItemType">G Month Day</option>
                                    <option value="xbrli:gDayItemType">G Day</option>
                                    <option value="xbrli:gMonthItemType">G Month</option>
                                    <option value="xbrli:normalizedStringItemType">Normalized String</option>
                                    <option value="xbrli:tokenItemType">Token</option>
                                    <option value="xbrli:languageItemType">Language</option>
                                    <option value="xbrli:nameItemType">Name</option>
                                    <option value="xbrli:NCNameItemType">NC Name</option>
                                    <option value="nonnum:domainItemType">Domain</option>
                                    <option value="nonnum:textBlockItemType">Text Block</option>
                                    <option value="xbrldt:dimensionItem">Dimension</option>
                                    <option value="num:perShareItemType">Per Share</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <select class="form-control" name="periodType">
                                    <option disabled selected>Select Period</option>
                                    <option value="duration">Duration</option>
                                    <option value="instant">Instant</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <select class="form-control" name="balance">
                                    <option disabled selected>Select Balance</option>
                                    <option value="debit">Debit</option>
                                    <option value="credit">Credit</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <select class="form-control" name="substitutionGroup">
                                    <option disabled selected>Select Substitution Group</option>
                                    <option value="xbrli:item">Item</option>
                                    <option value="xbrldt:hypercubeItem">Hypercube Item</option>
                                    <option value="xbrldt:dimensionItem">Dimension Item</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <select class="form-control" name="nillable">
                                    <option disabled selected>Select Nillable</option>
                                    <option value="true">Yes</option>
                                    <option value="false">No</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <select class="form-control" name="abstract">
                                    <option disabled selected>Select Abstract</option>
                                    <option value="true">Yes</option>
                                    <option value="false">No</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <textarea name="documentation" class="form-control" rows="3" placeholder="Documentation/Definition"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Close</span>
                            </button>
                            <button type="sumbit" class="btn btn-primary ml-1" id="create-tag">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Create</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exhibitLinkModal" tabindex="-1" role="dialog" aria-labelledby="exhibitLinkModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="modal-header">
                        <h4 class="modal-title" id="addModalLabel">Exhibit Link</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="bx bx-x"></i>
                        </button>
                    </div>
                    <form id="exhibitLinkModal">
                        <div class="modal-body">
                            <label for="exhibit">Exhibit</label>
                            <div class="form-group">
                                <select class="form-control" id="exhibit">
                                    <option disabled selected>Select Exhibit</option>
                                    @foreach($exhibits as $name => $description)
                                        <option value="{{$name}}">{{$name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Close</span>
                            </button>
                            <button type="sumbit" class="btn btn-primary ml-1" id="addExhibitLink">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Add Link</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="usersModal" tabindex="-1" role="dialog" aria-labelledby="usersModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="modal-header">
                        <h4 class="modal-title" id="usersModalLabel">Assign Users</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="bx bx-x"></i>
                        </button>
                    </div>
                    <form id="assignUsersForm">
                        <div class="modal-body">
                            <label for="exhibit">Users</label>
                            <div class="form-group users">
                                <select name="users[]" id="users" class="select2 select2-container select2-container--default" multiple="multiple" required>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Close</span>
                            </button>
                            <button class="btn btn-primary ml-1" id="assignUsers">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Assign</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endif
@endsection
{{-- vendor scripts --}}
@section('vendor-scripts')
    <script src="{{ asset('/ckeditor/ckeditor.js') }}"></script>
    <script src="{{asset('vendors/js/forms/select/select2.full.min.js')}}"></script>
    <script src="{{asset('vendors/js/pickers/pickadate/picker.js')}}"></script>
    <script src="{{asset('vendors/js/pickers/pickadate/picker.date.js')}}"></script>

@endsection
@section('page-scripts')
    <script>
        CKEDITOR.config.contentsCss = "{{asset('/ckeditor/contents.css')}}"
        CKEDITOR.replace( 'document-ckeditor', {
            filebrowserUploadUrl: "{{route('editor.ckeditorUpload', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form'
        });

        @can('filing_data_edit')
            CKEDITOR.config.readOnly = false;
        @else
            CKEDITOR.config.readOnly = true;
        @endcan
        @if($status == 'done')
            CKEDITOR.config.readOnly = true;
        @endif
        @if($formType == '10Q')
            CKEDITOR.config.extraPlugins = ['generate', 'levelone', 'leveltwo', 'levelthree', 'levelfour', 'checked', 'unchecked', 'exhibitLink', 'users', 'comment'];
        @else
            CKEDITOR.config.extraPlugins = ['generate', 'checked', 'unchecked', 'exhibitLink', 'users'];
        @endif
    </script>
    <script src="{{asset('js/scripts/editor.js')}}"></script>
    <script src="{{asset('js/scripts/tag-modal.js')}}"></script>
    <script src="{{asset('js/scripts/comments.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/scripts/serializejson.js')}}"></script>
    <script>
        $("#users").select2({
            dropdownAutoWidth: true,
            width: '100%'
        });
    </script>
    <script>
        let filingID = <?php echo $filingId; ?>;
        let formType = "<?php echo $formType; ?>";
    </script>
    @if($formType == '10Q')
        <script src="{{asset('js/scripts/search.js')}}"></script>
    @endif
    <?php
    if (!isset($formType)){
        $formType = '';
    }
    if (!isset($exhibitMode)){
        $exhibitMode = 0;
    }
    ?>
    @if($formType == 'Form3')
        <script src="{{asset('js/scripts/form-three.js')}}"></script>
    @endif
    @if($formType == 'Form4')
        <script src="{{asset('js/scripts/form-four.js')}}"></script>
    @endif
    @if($formType == 'Form5')
        <script src="{{asset('js/scripts/form-five.js')}}"></script>
    @endif
    @if($formType == 'FormD')
        <script src="{{asset('js/scripts/form-d.js')}}"></script>
    @endif
    @if($formType == 'SC13GA')
        <script src="{{asset('js/scripts/SC13GA.js')}}"></script>
    @endif
    @if($formType == '13FHR')
        <script src="{{asset('js/scripts/13FHR.js')}}"></script>
    @endif
    @if($formType == 'Form6-K')
        <script src="{{asset('js/scripts/Form6-K.js')}}"></script>
    @endif
@endsection
