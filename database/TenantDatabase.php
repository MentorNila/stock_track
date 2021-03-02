<?php

use App\Models\Multitenancy\MultitenancySchema;
use App\Models\Multitenancy\MultitenancyHelper;
use App\Modules\Client\Facade\ClientFacade;
use App\Modules\Form\Models\FormExhibits;
use App\Modules\Permission\Models\Permission;
use App\Modules\Role\Models\PermissionRole;
use App\Modules\Role\Models\Role;
use App\Modules\User\Models\User;
use App\Modules\Employee\Models\Employee;
use App\Modules\Client\Models\Client;
use App\Modules\Form\Models\Exhibits;
use App\Modules\User\Models\UserStatusCode;
use App\Modules\Role\Classes\RoleCode;
use Illuminate\Database\Schema\Blueprint;
use Carbon\Carbon;
use Illuminate\Support\Str;

class TenantDatabase {

    /**
     * Create tables for tenant
     *
     * @param int $clientId
     */
    public static function createTables($clientId = null) {
        $tenant = new TenantDatabase;
        $tenant->beforeThreeSixty($clientId);
        $tenant->afterThreeSixty($clientId);
    }

    private function afterThreeSixty($clientId = null) {
        MultitenancySchema::create('three_sixty_feedbacks', function (Blueprint $table) {
            $table->string('title');
            $table->timestamp('created_at')->nullable();
        }, $clientId);

        MultitenancySchema::create('three_sixty_feedback_members', function (Blueprint $table) {
            $table->string('three_sixty_feedback_id');
            $table->string('employee_id');
            $table->timestamp('created_at')->nullable();
        }, $clientId);
        
        MultitenancySchema::create('three_sixty_feedback_questions', function (Blueprint $table) {
            $table->string('three_sixty_feedback_id');
            $table->string('question');
            $table->string('description')->nullable();
            $table->string('type');
            $table->timestamp('created_at')->nullable();
        }, $clientId);
    }

    private function beforeThreeSixty($clientId = null) {
        MultitenancySchema::create('password_resets', function (Blueprint $table) {
            $table->string('email')->index();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        }, $clientId);

        MultitenancySchema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 50);
            $table->string('title')->nullable();
            $table->tinyInteger('level')->default(0);
            $table->boolean('agency_level')->default(0);
            $table->timestamps();
            $table->softDeletes();
        }, $clientId);


        MultitenancySchema::create('permission_role', function (Blueprint $table) {
            $table->unsignedInteger('role_id');
            $table->unsignedInteger('permission_id');
            $table->unique(['role_id', 'permission_id'], 'u');
        }, $clientId);

        MultitenancySchema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email');
            $table->boolean('is_superadmin')->default(0);
            $table->unsignedInteger('role_id');
            $table->datetime('email_verified_at')->nullable();
            $table->string('password');
            $table->string('remember_token')->nullable();
            $table->timestamps();
            $table->softDeletes();
        }, $clientId);

        MultitenancySchema::create('employees', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->datetime('birthdate')->nullable();
            $table->string('state')->nullable();
            $table->string('address')->nullable();
            $table->string('job_title')->nullable();
            $table->string('phone_nr')->nullable();
            $table->integer('supervisor_id')->nullable();
            $table->datetime('hire_date')->nullable();
            $table->datetime('termination_date')->nullable();
            $table->timestamps();
        }, $clientId);

        MultitenancySchema::create('goals', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->decimal('target', 8, 2);
            $table->string('units');
            $table->datetime('start_date');
            $table->datetime('due_date');
            $table->string('description')->nullable();
            $table->string('category')->nullable();
            $table->integer('employee_id');
            $table->string('transparency')->nullable();
            $table->string('alignment')->nullable();
            $table->timestamps();
        }, $clientId);

        MultitenancySchema::create('feedbacks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('employee_id');
            $table->string('goal_id');
            $table->string('feedback');
            $table->string('created_by');
            $table->timestamps();
        }, $clientId);

        MultitenancySchema::create('forms', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->timestamps();
        }, $clientId);

        MultitenancySchema::create('questions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('form_id');
            $table->string('type');
            $table->string('question');
            $table->string('subtext')->nullable();
            $table->decimal('min_value', 8, 2)->nullable();
            $table->decimal('max_value', 8, 2)->nullable();
            $table->string('value')->nullable();
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        }, $clientId);

        MultitenancySchema::create('templates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->timestamps();
        }, $clientId);

        MultitenancySchema::create('template_forms', function (Blueprint $table) {
            $table->increments('id');
            $table->string('template_id');
            $table->string('form_id');
            $table->string('author');
            $table->string('signer');
            $table->decimal('days_to_author', 8, 2)->nullable();
            $table->decimal('days_to_finish_signing', 8, 2)->nullable();
            $table->timestamps();
        }, $clientId);

        MultitenancySchema::create('checklists', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->timestamps();
        }, $clientId);

        MultitenancySchema::create('reviews', function (Blueprint $table) {
            $table->increments('id');
            $table->string('template_id');
            $table->integer('employee_id');
            $table->integer('author_id');
            $table->datetime('start_date');
            $table->string('status');
            $table->timestamps();
        }, $clientId);

        MultitenancySchema::create('review_forms', function (Blueprint $table) {
            $table->increments('id');
            $table->string('form_id');
            $table->string('review_id');
            $table->string('author');
            $table->string('signer');
            $table->datetime('due_date_authors')->nullable();
            $table->datetime('due_date_signers')->nullable();
            $table->string('status');
            $table->timestamps();
        }, $clientId);

        MultitenancySchema::create('form_goals', function (Blueprint $table) {
            $table->increments('id');
            $table->string('goal_id');
            $table->string('form_id');
            $table->string('question_id')->nullable();
            $table->string('employee_id');
            $table->string('discussion')->nullable();
            $table->string('value')->nullable();
            $table->string('goal_score')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        }, $clientId);

        MultitenancySchema::create('goal_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('category');
            $table->timestamps();
        }, $clientId);

        MultitenancySchema::create('goal_contain_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('goal_id');
            $table->string('category_id');
            $table->timestamps();
        }, $clientId);

        MultitenancySchema::create('review_members', function (Blueprint $table) {
            $table->increments('id');
            $table->string('review_id');
            $table->string('employee_id');
            $table->string('type'); // signer or author
            $table->datetime('signed')->nullable();
            $table->timestamps();
        }, $clientId);

        MultitenancySchema::create('review_form_members', function (Blueprint $table) {
            $table->increments('id');
            $table->string('review_form_id');
            $table->string('employee_id');
            $table->string('type'); // signer or author
            $table->datetime('signed')->nullable();
            $table->timestamps();
        }, $clientId);

        MultitenancySchema::create('shareholders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('company_id');
            $table->string('ref_name');
            $table->string('name_as_appears_on_certificate')->nullable();
            $table->string('registration')->nullable();
            $table->string('ssno')->nullable();
            $table->string('address')->nullable();
            $table->boolean('active')->default(1);
            $table->timestamps();
        }, $clientId);

        MultitenancySchema::create('certificates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('company_id');
            $table->string('shareholder_id');
            $table->string('stock_class');
            $table->string('total_shares')->nullable();
            $table->datetime('issued_date')->nullable();
            $table->string('reservation')->nullable();
            $table->string('address')->nullable();
            $table->string('nr_of_paper')->nullable();
            $table->string('restriction')->nullable();
            $table->string('received_from')->nullable();
            $table->string('acquired')->nullable();
            $table->string('amt_share')->nullable();
            $table->string('broker')->nullable();
            $table->boolean('cost_of_basis_received')->default(0);
            $table->timestamps();
        }, $clientId);

        MultitenancySchema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('company_id');
            $table->string('sec_tracking');
            $table->string('item_count')->nullable();
            $table->string('scl')->nullable();
            $table->string('control_ticket')->nullable();
            $table->datetime('received')->nullable();
            $table->string('how_received')->nullable();
            $table->string('track')->nullable();
            $table->string('content')->nullable();
            $table->string('status')->default(1);
            $table->string('assigned_to')->nullable();
            $table->timestamps();
        }, $clientId);

        MultitenancyHelper::run(function($client) {
            $timestamp = Carbon::now();
            $subdomainForEmail = $client->subdomain;
            if($subdomainForEmail == '') {
                $subdomainForEmail = 'default';
            }

            // insert public role
            $roles = [
                [
                    'id'         => 1,
                    'code'      => 'master_admin',
                    'title'      => 'Master Admin',
                    'level'      => 1,
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp,
                    'deleted_at' => null,
                ],
                [
                    'id'         => 2,
                    'code'      => 'super_admin',
                    'title'      => 'Super Admin',
                    'level'      => 1,
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp,
                    'deleted_at' => null,
                ],
                [
                    'id'         => 3,
                    'code'      => 'admin',
                    'title'      => 'Admin',
                    'level'      => 1,
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp,
                    'deleted_at' => null,
                ],
                [
                    'id'         => 4,
                    'code'      => 'user',
                    'title'      => 'User',
                    'level'      => 1,
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp,
                    'deleted_at' => null,
                ],
                [
                    'id'         => 5,
                    'code'      => 'employee',
                    'title'      => 'Employee',
                    'level'      => 1,
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp,
                    'deleted_at' => null,
                ],
            ];

            Role::insert($roles);
            $permissions = Permission::all();
            if(empty($permissions) || count($permissions) === 0){
                (new PermissionsTableSeeder())->run();
                $permissions = Permission::all();
            }

            foreach ($permissions as $permission){
                PermissionRole::firstOrCreate([
                    'role_id' => 1,
                    'permission_id' => $permission->id,
                ]);
                if(!Str::startsWith($permission->title, ['client_', 'plan_', 'request_'])){
                    PermissionRole::firstOrCreate([
                        'role_id' => 2,
                        'permission_id' => $permission->id,
                    ]);
                }
                if(!Str::startsWith($permission->title, ['client_', 'plan_', 'request_','user_'])){
                    PermissionRole::firstOrCreate([
                        'role_id' => 3,
                        'permission_id' => $permission->id,
                    ]);
                    PermissionRole::firstOrCreate([
                        'role_id' => 4,
                        'permission_id' => $permission->id,
                    ]);
                }
                if(Str::startsWith($permission->title, ['dashboard_', 'filing_data_access', 'filing_data_show'])){
                    PermissionRole::firstOrCreate([
                        'role_id' => 5,
                        'permission_id' => $permission->id,
                    ]);
                    PermissionRole::firstOrCreate([
                        'role_id' => 6,
                        'permission_id' => $permission->id,
                    ]);
                }
            }

            $users = [[
            'id'             => 1,
            'name'           => ($subdomainForEmail == 'rln')? 'Roland Nezaj' : 'Admin',
            'first_name'     => ($subdomainForEmail == 'rln')? 'Roland' : 'Admin',
            'last_name'     => ($subdomainForEmail == 'rln')? 'Nezaj' : 'Admin',
            'email'          => ($subdomainForEmail == 'rln')? 'roland.nezaj@rlnus.com' : 'first_user@' . $subdomainForEmail . '.com',
            'is_superadmin'  => 1,
            'password' => bcrypt('password'),
            'remember_token' => null,
            'role_id'        => 1,
            'created_at'     => '2019-08-19 11:47:42',
            'updated_at'     => '2019-08-19 11:47:42',
            'deleted_at'     => null,
            ]];

            User::insert($users);

            $employees = [[
            'id'             => 1,
            'user_id'        => 1,
            'job_title'      => 'Managing Partner',
            'created_at'     => '2019-08-19 11:47:42',
            'updated_at'     => '2019-08-19 11:47:42',
            ]];

            Employee::insert($employees);

        }, $clientId);


        MultitenancySchema::create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('type');
            $table->morphs('notifiable');
            $table->text('data');
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        }, $clientId);

        MultitenancySchema::create('companies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('code')->nullable();
            $table->datetime('date_terminated')->nullable();
            $table->string('address_one')->nullable();
            $table->string('address_two')->nullable();
            $table->string('address_three')->nullable();
            $table->string('state')->nullable();
            $table->string('state_short')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('phone_one')->nullable();
            $table->string('phone_two')->nullable();
            $table->string('phone_three')->nullable();
            $table->string('ticker_symbol')->nullable();
            $table->string('email')->nullable();
            $table->string('federal_id')->nullable();
            $table->string('incorp_in_state')->nullable();
            $table->string('last_trans_no')->nullable();
            $table->datetime('proxy_record_date')->nullable();
            $table->datetime('after_proxy_date')->nullable();
            $table->string('last_holder_id')->nullable();
            $table->boolean('s_corporation')->default(0);
            $table->boolean('test_company')->default(0);
            $table->boolean('active')->default(1);
            $table->string('nr_of_employees')->nullable();
            $table->timestamps();
            $table->softDeletes();

        }, $clientId);
        
        MultitenancySchema::create('company_history', function (Blueprint $table) {
            $table->increments('id');
            $table->string('company_id');
            $table->string('old_name');
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();

        }, $clientId);

        MultitenancySchema::create('filing_tags', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('filing_id');
            $table->json('attributes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        }, $clientId);


        MultitenancySchema::create('exhibits', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code');
            $table->string('name');
            $table->string('description');
            $table->timestamps();
            $table->softDeletes();
        }, $clientId);


        MultitenancySchema::create('tax_element_relation', function (Blueprint $table) {
            $table->integer('element_id');
            $table->integer('parent_id');
            $table->string('file_name');
            $table->primary(['parent_id', 'element_id', 'file_name']);
        }, $clientId);


        MultitenancySchema::create('taxonomy_elements', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->string('code');
            $table->string('name')->default("");
            $table->string('abstract')->default("");
            $table->string('type')->default("");
            $table->string('nillable')->default("");
            $table->string('substitutionGroup')->default("");
            $table->string('periodType')->default("");
            $table->string('namespace')->default("");
            $table->string('balance')->default("");
            $table->text('documentation')->nullable();
            $table->text('label')->nullable();
            $table->timestamps();
            $table->softDeletes();
        }, $clientId);


        MultitenancySchema::create('extension_taxonomy', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('filing_id');
            $table->integer('client_id')->nullable();
            $table->string('code')->default("");
            $table->string('label')->default("");
            $table->string('name')->default("");
            $table->string('abstract')->default("");
            $table->string('type')->default("");
            $table->string('nillable')->default("");
            $table->string('substitutionGroup')->default("");
            $table->string('periodType')->default("");
            $table->string('namespace')->default("");
            $table->string('balance')->default("");
            $table->text('documentation')->nullable();
            $table->timestamps();
            $table->softDeletes();
        }, $clientId);


        MultitenancySchema::create('filing_exhibits', function (Blueprint $table) {
            $table->integer('filing_id');
            $table->integer('exhibit_id');
            $table->string('exhibit_name')->default("");
            $table->string('exhibit_description')->default("");
            $table->string('exhibit_file_path');
        }, $clientId);

        MultitenancySchema::create('filing_financial_data', function (Blueprint $table) {
            $table->integer('filing_id');
            $table->string('fs_type')->default("");
            $table->string('fs_file_path');
        }, $clientId);

        MultitenancySchema::create('audit_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->text('description');
            $table->unsignedInteger('subject_id')->nullable();
            $table->string('subject_type')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->text('properties')->nullable();
            $table->string('host', 45)->nullable();
            $table->timestamps();
        }, $clientId);

        MultitenancySchema::create('filings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('company_id')->default(0);
            $table->string('filing_type');
            $table->string('status');
            $table->boolean('approved')->default(0);
            $table->boolean('amendment_flag')->default(0);
            $table->string('fiscal_year_end_date')->nullable();
            $table->string('fiscal_period_focus')->nullable();
            $table->string('fiscal_year_focus')->nullable();
            $table->timestamps();
            $table->softDeletes();
        }, $clientId);

        MultitenancySchema::create('user_company', function (Blueprint $table) {
            $table->integer('user_id');
            $table->integer('company_id');
        }, $clientId);

        MultitenancySchema::create('user_filings', function(Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->integer('filing_id')->unsigned();
            $table->unique(['user_id', 'filing_id'], 'u');
        }, $clientId);

        MultitenancySchema::create('comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('filing_id');
            $table->integer('user_id');
            $table->integer('parent_id');
            $table->longText('body');
            $table->boolean('resolved')->default(0);
            $table->timestamps();
            $table->softDeletes();
        }, $clientId);

        (new ExhibitsTableSeeder())->run($clientId);
        (new FormExhibitTableSeeder())->run($clientId);


    }

    /**
     * Drop tables for tenant
     *
     * @param int $clientId
     */
    public static function dropTables($clientId = null) {
        MultitenancySchema::drop('password_resets',$clientId);
        MultitenancySchema::drop('roles',$clientId);
        MultitenancySchema::drop('users',$clientId);
        MultitenancySchema::drop('companies',$clientId);
        MultitenancySchema::drop('filing_tags',$clientId);
        MultitenancySchema::drop('exhibits',$clientId);
        MultitenancySchema::drop('tax_element_relation',$clientId);
        MultitenancySchema::drop('taxonomy_elements',$clientId);
        MultitenancySchema::drop('form_exhibit',$clientId);
        MultitenancySchema::drop('extension_taxonomy',$clientId);
        MultitenancySchema::drop('filing_exhibits',$clientId);
        MultitenancySchema::drop('filing_financial_data',$clientId);
        MultitenancySchema::drop('audit_logs',$clientId);
        MultitenancySchema::drop('filings',$clientId);
        MultitenancySchema::drop('user_company',$clientId);
        MultitenancySchema::drop('permission_role',$clientId);
        MultitenancySchema::drop('user_filings',$clientId);
        MultitenancySchema::drop('notifications',$clientId);
        MultitenancySchema::drop('comments',$clientId);
    }

}
