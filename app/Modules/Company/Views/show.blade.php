@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        Company Information
    </div>

    <div class="card-body">
      <div class="table-responsive">
          <table class=" table table-bordered table-striped table-hover datatable">
              <thead>
                  <tr>
                      <th>
                          Name
                      </th>
                      <th>
                          State
                      </th>
                      <th>
                          Code
                      </th>
                      <th>
                          Phone NR
                      </th>
                      <th>
                          Date Terminated
                      </th>
                  </tr>
              </thead>
              <tbody>
                  <tr>
                    <td>
                      {{$company->name}}
                    </td>
                    <td>
                      {{$company->state}}
                    </td>
                    <td>
                      {{$company->code}}
                    </td>
                    <td>
                      {{$company->phone_one}}
                    </td>
                    <td>
                      {{$company->date_terminated}}
                    </td>
                  </tr>
              </tbody>
          </table>
          <table class=" table table-bordered table-striped table-hover datatable">
              <thead>
                  <tr>
                      <th>
                          Email
                      </th>
                      <th>
                          Address one
                      </th>
                      <th>
                          Address two
                      </th>
                      <th>
                          Address three
                      </th>
                      <th>
                          Phone one
                      </th>
                      <th>
                          Phone two
                      </th>
                      <th>
                          Phone three
                      </th>
                  </tr>
              </thead>
              <tbody>
                  <tr>
                    <td>
                      {{$company->email}}
                    </td>
                    <td>
                      {{$company->address_one}}
                    </td>
                    <td>
                      {{$company->address_two}}
                    </td>
                    <td>
                      {{$company->address_three}}
                    </td>
                    <td>
                      {{$company->phone_one}}
                    </td>
                    <td>
                      {{$company->phone_two}}
                    </td>
                    <td>
                      {{$company->phone_three}}
                    </td>
                  </tr>
              </tbody>
          </table>
          <table class=" table table-bordered table-striped table-hover datatable">
              <thead>
                  <tr>
                      <th>
                          Federal Id No.
                      </th>
                      <th>
                          Incorp. in State/Province
                      </th>
                      <th>
                          Last Trans. No.
                      </th>
                      <th>
                          Proxy Record Date
                      </th>
                      <th>
                          Date
                      </th>
                      <th>
                          Last Holder ID
                      </th>
                  </tr>
              </thead>
              <tbody>
                  <tr>
                    <td>
                      {{$company->federal_id}}
                    </td>
                    <td>
                      {{$company->incorp_in_state}}
                    </td>
                    <td>
                      {{$company->last_holder_id}}
                    </td>
                    <td>
                      {{$company->proxy_record_date}}
                    </td>
                    <td>
                      {{$company->after_proxy_date}}
                    </td>
                    <td>
                      {{$company->last_holder_id}}
                    </td>
                  </tr>
              </tbody>
          </table>
          <a style="margin-top:20px;" class="btn btn-default" href="{{ url()->previous() }}">
              {{ trans('global.back_to_list') }}
          </a>
      </div>

        <!-- <div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.company.fields.id') }}
                        </th>
                        <td>
                            {{ $company->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.company.fields.name') }}
                        </th>
                        <td>
                            {{ $company->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.company.fields.state') }}
                        </th>
                        <td>
                            {{ $company->state }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.company.fields.irs_employer_identification_no') }}
                        </th>
                        <td>
                            {{ $company->irs_employer_identification_no }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.company.fields.address_of_principal_executive_offices') }}
                        </th>
                        <td>
                            {{ $company->address_of_principal_executive_offices }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.company.fields.zip_code') }}
                        </th>
                        <td>
                            {{ $company->zip_code }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.company.fields.phone_nr') }}
                        </th>
                        <td>
                            {{ $company->phone_nr }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.company.fields.nature_of_operations') }}
                        </th>
                        <td>
                            {{ $company->nature_of_operations }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.company.fields.forward_looking_statements') }}
                        </th>
                        <td>
                            {{ $company->forward_looking_statements }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.company.fields.general_overview') }}
                        </th>
                        <td>
                            {{ $company->general_overview }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.company.fields.ceo') }}
                        </th>
                        <td>
                            {{ $company->ceo }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.company.fields.cfo') }}
                        </th>
                        <td>
                            {{ $company->cfo }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.company.fields.cik') }}
                        </th>
                        <td>
                            {{ $company->cik }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.company.fields.nr_of_employees') }}
                        </th>
                        <td>
                            {{ $company->nr_of_employees }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.company.fields.user') }}
                        </th>
                        <td>
                            {{ $company->user->name ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <a style="margin-top:20px;" class="btn btn-default" href="{{ url()->previous() }}">
                {{ trans('global.back_to_list') }}
            </a>
        </div> -->
    </div>
</div>
@endsection
