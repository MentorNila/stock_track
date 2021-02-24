<table class="table table-bordered table-striped table-hover datatable">
  <thead>
    <tr>
      <th>Name</th>
      <th>Email</th>
      <th>Status</th>
      <th>Message</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($reviewers as $reviewer)
      <tr>
        <td>{{$reviewer->name}}</td>
        <td>{{$reviewer->email}}</td>
        <td>{{$reviewer->status}}</td>
        <td>{{$reviewer->message}}</td>
        <td>
            @if($reviewer->status == 'Not Approved')
              <input type="image" class="client-icons" name="button" src="{{ asset('images/resend.svg ')}}" data-reviewer-email="{{$reviewer->email}}" data-filing-id="{{$filingId}}" data-reviewer-id="{{$reviewer->reviewer_id}}" id="resend-email" border="0" alt="Submit" />
              <span class="tooltiptext">Resend</span>
            @endif
            <input type="image" class="deleteReviewer delete-tooltip" name="submit" data-filing-id="{{$filingId}}" data-reviewer-id="{{$reviewer->reviewer_id}}" src="{{ asset('images/delete.svg ')}}" border="0" alt="Submit" />
            <span class="delete-tooltiptext">Delete</span>
        </td>
      </tr>
    @endforeach
  </tbody>
</table>
