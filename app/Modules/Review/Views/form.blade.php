@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        <span style="text-decoration: underline; font-size: 20px;">
            {{ $form->title }} of {{ $form->signer_first_name }} {{ $form->signer_last_name }}
        </span>
        <br>
        <p style="font-size: 13px; margin-bottom: 0px;">This review began on <span style="text-decoration: underline;">{{$review->start_date}}</span></p>
        <div style="border-radius: 5px; padding: 20px; color:black; font-size:13px;" class="">
            <b>Form</b>  {{$form->form_title}}
            <br>
            <b>Current Author</b>  {{$form->author_first_name}} {{$form->author_last_name}}
            <br>
            <b>Due for authors</b>  {{$form->due_date_authors}}
        </div>
    </div>
    <div class="card-body" style="margin-top:0px; border-top: 1px solid lightgray;">
        @foreach($formQuestions as $key => $question)
        <div class="row" style="margin-top: 0px;">
            <div class="col-lg-12">
                <div style="border-radius: 5px; padding: 20px; color:black; font-size:13px; margin-top:0px;" class="">
                    <b>{{$question->question}}</b>
                    <br>
                    <b>{{$question->subtext}}</b>
                    <br>
                </div>
            </div>
        </div>
        @endforeach
        <form action="/admin/reviews/form/submit_form/{{$form->id}}" id="goalsForm" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-lg-12">
                    <button type="button" class="btn btn-success glow mb-1 mb-sm-0 mr-0 mr-sm-1" data-toggle="modal" data-target="#goalsModal">Choose a goal</button>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div id="goalDiscussion" class="col-lg-6" style="margin-top:15px;">
                        @foreach($formGoals as $currentGoal)
                        <div style="border: 1px solid lightgray; margin-left:0px; padding: 5px; margin:5px; border-radius: 10px;">
                            <p style="margin-top:10px; margin-bottom: 0px;">
                                {{$currentGoal->name}}
                            </p><br>
                            <input name="formGoalId[]" hidden value="{{$currentGoal->form_goal_id}}"></input>
                            <label>Discuss the goal:</label><br>
                            <textarea style="width: 100%;" name="formGoalDiscussion[]">{{$currentGoal->discussion}}
                            </textarea><br>
                            <label>Score the goal:</label><br>
                            <input name="formGoalScore[]" value="{{$currentGoal->goal_score}}"></input>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12" style="margin-top: 15px;">
                    <button type="submit" class="btn btn-success glow mb-1 mb-sm-0 mr-0 mr-sm-1">Submit</button><br>
                    <a style="margin-top:20px;" class="btn btn-default pull-right" href="/admin/reviews">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
<div id="goalsModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Goals</h4>
    </div>
    <div class="modal-body">
        <p>Select the goal you would like to include in this review:</p> <br>
        <table class="table table-bordered">
            <thead>
              <tr>
                <th><input type="checkbox"></th>
                <th>ASSIGNEE</th>
                <th>NAME</th>
                <th>DUE DATE</th>
                <th>STATUS</th>
                <th>PROGRESS</th>
            </tr>
        </thead>
        <tbody>
          @foreach($employeeGoals as $key => $goal)
          <tr>
            <td><input type="checkbox" class="goals" value="{{$goal->id}}"></td>
            <td>{{$goal->first_name}} {{$goal->last_name}}</td>
            <td>{{$goal->name}}</td>
            <td>{{$goal->due_date}}</td>
            <td></td>
            <td>{{$goal->progress}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>
<div class="modal-footer">
    <button type="button" data-dismiss="modal" class="btn btn-success glow mb-1 mb-sm-0 mr-0 mr-sm-1 pull-left" id="discussGoalsButton">Discuss</button>
    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
</div>
</div>

</div>
</div>
@endsection
<style type="text/css">
    .modal-ku {
      width: 750px;
      margin: auto;
  }
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">
    $(document).on('click', '#discussGoalsButton', function() {
        let employeeGoals = {!! json_encode($employeeGoals) !!};
        let employeeGoalsArray = [];
        for (i = 0; i < employeeGoals.length; i++) {
            employeeGoalsArray[employeeGoals[i].id] = employeeGoals[i];
        }
        var goals = [];
        let goalDiscussionInputs = '';
        $('input.goals:checkbox:checked').each(function () {
            goals.push($(this).val());
            goalDiscussionInputs = goalDiscussionInputs + '<div style="border: 1px solid lightgray; margin-left:0px; padding: 5px; margin:5px; border-radius: 10px;"><p style="margin-top:10px; margin-bottom: 0px;">' + employeeGoalsArray[$(this).val()].name + '</p><br><input name="goalId[]" hidden value="' + $(this).val() + '"></input><label>Discuss the goal:</label><br><textarea style="width: 100%;" name="discussion[]"></textarea><br> <label>Score the goal:</label><br><input name="goal_score[]"></input></div>';
        });
        $("#goalDiscussion").append(goalDiscussionInputs);
    });
</script>