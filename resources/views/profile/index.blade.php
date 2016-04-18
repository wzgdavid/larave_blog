@extends('layouts.app')

@section('head')
    <title>Profiles</title>
@endsection


@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-12">
        {{-- success message --}}
        <?php $message = Session::get('message'); ?>
        @if( isset($message) )
        <div class="alert alert-success">{!! $message !!}</div>
        @endif
        @if( $errors->has('model') )
        <div class="alert alert-danger">{!! $errors->first('model') !!}</div>
        @endif
        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="panel-title bariol-thin"><i class="fa fa-user"></i> User profile</h3>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <!--
                <div class="row">
                    <div class="col-md-12">
                        <a href="{!! URL::route('users.edit',['id' => $user_profile->user_id]) !!}" class="btn btn-info pull-right"><i class="fa fa-pencil-square-o"></i> Edit user</a>
                    </div>
                </div>
                -->
                <div class="row">
                    <div class="col-md-6 col-xs-12">

                        <h4><i class="fa fa-cubes"></i> User data</h4>
                        {!! Form::model($user_profile,['route'=>'users.profile.edit', 'method' => 'post']) !!}
                        <!-- code text field -->
                        <div class="form-group">
                            {!! Form::label('code','User code:') !!}
                            {!! Form::text('code', null, ['class' => 'form-control', 'placeholder' => '']) !!}
                        </div>
                        <span class="text-danger">{!! $errors->first('code') !!}</span>
                        <!-- first_name text field -->
                        <div class="form-group">
                            {!! Form::label('first_name','First name:') !!}
                            {!! Form::text('first_name', null, ['class' => 'form-control', 'placeholder' => '']) !!}
                        </div>
                        <span class="text-danger">{!! $errors->first('first_name') !!}</span>
                        <!-- last_name text field -->
                        <div class="form-group">
                            {!! Form::label('last_name','Last name: ') !!}
                            {!! Form::text('last_name', null, ['class' => 'form-control', 'placeholder' => '']) !!}
                        </div>
                        <span class="text-danger">{!! $errors->first('last_name') !!}</span>
                        <!-- phone text field -->
                        <div class="form-group">
                            {!! Form::label('phone','Phone: ') !!}
                            {!! Form::text('phone', null, ['class' => 'form-control', 'placeholder' => '']) !!}
                        </div>
                        <span class="text-danger">{!! $errors->first('phone') !!}</span>
                        <!-- state text field -->
                        <div class="form-group">
                            {!! Form::label('state','State: ') !!}
                            {!! Form::text('state', null, ['class' => 'form-control', 'placeholder' => '']) !!}
                        </div>
                        <span class="text-danger">{!! $errors->first('state') !!}</span>
                        <!-- var text field -->
                        <div class="form-group">
                            {!! Form::label('var','Vat: ') !!}
                            {!! Form::text('var', null, ['class' => 'form-control', 'placeholder' => '']) !!}
                        </div>
                        <span class="text-danger">{!! $errors->first('vat') !!}</span>
                        <!-- city text field -->
                        <div class="form-group">
                            {!! Form::label('city','City: ') !!}
                            {!! Form::text('city', null, ['class' => 'form-control', 'placeholder' => '']) !!}
                        </div>
                        <span class="text-danger">{!! $errors->first('city') !!}</span>
                        <!-- country text field -->
                        <div class="form-group">
                            {!! Form::label('country','Country: ') !!}
                            {!! Form::text('country', null, ['class' => 'form-control', 'placeholder' => '']) !!}
                        </div>
                        <span class="text-danger">{!! $errors->first('country') !!}</span>
                        <!-- zip text field -->
                        <div class="form-group">
                            {!! Form::label('zip','Zip: ') !!}
                            {!! Form::text('zip', null, ['class' => 'form-control', 'placeholder' => '']) !!}
                        </div>
                        <span class="text-danger">{!! $errors->first('zip') !!}</span>
                        <!-- address text field -->
                        <div class="form-group">
                            {!! Form::label('address','Address: ') !!}
                            {!! Form::text('address', null, ['class' => 'form-control', 'placeholder' => '']) !!}
                        </div>
                        <span class="text-danger">{!! $errors->first('address') !!}</span>

        <!-- mugshot text field -->
                        <div class="form-group">
                            {!! Form::label('mugshot','mugshot:') !!}
                            {!! Form::text('mugshot', null, ['class' => 'form-control', 'placeholder' => '']) !!}
                        </div>
                        <span class="text-danger">{!! $errors->first('mugshot') !!}</span>
        <!-- privacy text field -->
                        <div class="form-group">
                            {!! Form::label('privacy','privacy:') !!}
                            {!! Form::text('privacy', null, ['class' => 'form-control', 'placeholder' => '']) !!}
                        </div>
                        <span class="text-danger">{!! $errors->first('privacy') !!}</span>
                                <!-- housing_uid text field -->
                        <div class="form-group">
                            {!! Form::label('housing_uid','housing_uid:') !!}
                            {!! Form::text('housing_uid', null, ['class' => 'form-control', 'placeholder' => '']) !!}
                        </div>
                        <span class="text-danger">{!! $errors->first('housing_uid') !!}</span>
                                <!-- company_name text field -->
                        <div class="form-group">
                            {!! Form::label('company_name','company_name:') !!}
                            {!! Form::text('company_name', null, ['class' => 'form-control', 'placeholder' => '']) !!}
                        </div>
                        <span class="text-danger">{!! $errors->first('company_name') !!}</span>
                                <!-- live_area text field -->
                        <div class="form-group">
                            {!! Form::label("live_area","live_area: ") !!}
                            {!! Form::select('live_area', [
                                '1'=>'Xuhui',
                                '2'=>"Jing'an",
                                '3'=>'Changning',
                                '4'=>'Hongkou',
                                '5'=>'Huangpu',
                                '6'=>'Minhang',
                                '7'=>'Yangpu',
                                '8'=>'Zhabei',
                                '9'=>'Putuo',
                                '10'=>'Baoshan',
                                '11'=>'Fengxian',
                                '12'=>'Jiading',
                                '13'=>'Songjiang',
                                '14'=>'Qingpu',
                                '15'=>'Pudong',
                                '16'=>'Jinshan',
                                '17'=>'Chongming',
                                '18'=>'Others',
                                '19'=>'Outside Shanghai',
                                ], (isset($user_profile->live_area) && $user_profile->live_area) ? $user_profile->live_area : "0", ["class"=> "form-control"] ) !!}
                        </div>
        <!-- come_from text field -->
                        <div class="form-group">
                            {!! Form::label("come_from","come_from: ") !!}
                            {!! Form::select('come_from', [
                                '1'=>'Afghanistan',
                                '2'=>'Albania',
                                '3'=>'Algeria',
                                '4'=>'American Samoa',
                                '5'=>'Andorra',
                                '6'=>'Angola',
                                '7'=>'Anguilla',
                                '8'=>'Antarctica',
                                '9'=>'Antigua and Barbuda',
                                '10'=>'Argentina',
                                '11'=>'Armenia',
                                '12'=>'Aruba',
                                '13'=>'Australia',
                                '14'=>'Austria',
                                '15'=>'Azerbaijan',
                                '16'=>'Bahamas',
                                '17'=>'Bahrain',
                                '18'=>'Bangladesh',
                                '19'=>'Barbados',
                                '20'=>'Belarus',
                                '21'=>'Belgium',
                                '22'=>'Belize',
                                '23'=>'Benin',
                                '24'=>'Bermuda',
                                '25'=>'Bhutan',
                                '26'=>'Bolivia',
                                '27'=>'Bosnia and Herzegovina',
                                '28'=>'Botswana',
                                '29'=>'Bouvet Island',
                                '30'=>'Brazil',
                                '31'=>'British Indian Ocean Territory',
                                '32'=>'Brunei Darussalam',
                                '33'=>'Bulgaria',
                                '34'=>'Burkina Faso',
                                '35'=>'Burundi',
                                '36'=>'Cambodia',
                                '37'=>'Cameroon',
                                '38'=>'Canada',
                                '39'=>'Cape Verde',
                                '40'=>'Cayman Islands',
                                '41'=>'Central African Republic',
                                '42'=>'Chad',
                                '43'=>'Chile',
                                '44'=>'China',
                                '45'=>'Christmas Island',
                                '46'=>"Cocos 'Keeling) Islands",
                                '47'=>'Colombia',
                                '48'=>'Comoros',
                                '49'=>'Congo',
                                '50'=>'Congo, the Democratic Republic of the',
                                '51'=>'Cook Islands',
                                '52'=>'Costa Rica',
                                '53'=>"Cote D'Ivoire",
                                '54'=>'Croatia',
                                '55'=>'Cuba',
                                '56'=>'Cyprus',
                                '57'=>'Czech Republic',
                                '58'=>'Denmark',
                                '59'=>'Djibouti',
                                '60'=>'Dominica',
                                '61'=>'Dominican Republic',
                                '62'=>'Ecuador',
                                '63'=>'Egypt',
                                '64'=>'El Salvador',
                                '65'=>'Equatorial Guinea',
                                '66'=>'Eritrea',
                                '67'=>'Estonia',
                                '68'=>'Ethiopia',
                                '69'=>"Falkland Islands 'Malvinas)",
                                '70'=>'Faroe Islands',
                                '71'=>'Fiji',
                                '72'=>'Finland',
                                '73'=>'France',
                                '74'=>'French Guiana',
                                '75'=>'French Polynesia',
                                '76'=>'French Southern Territories',
                                '77'=>'Gabon',
                                '78'=>'Gambia',
                                '79'=>'Georgia',
                                '80'=>'Germany',
                                '81'=>'Ghana',
                                '82'=>'Gibraltar',
                                '83'=>'Greece',
                                '84'=>'Greenland',
                                '85'=>'Grenada',
                                '86'=>'Guadeloupe',
                                '87'=>'Guam',
                                '88'=>'Guatemala',
                                '89'=>'Guinea',
                                '90'=>'Guinea-Bissau',
                                '91'=>'Guyana',
                                '92'=>'Haiti',
                                '93'=>'Heard Island and Mcdonald Islands',
                                '94'=>"Holy See 'Vatican City State)",
                                '95'=>'Honduras',
                                '96'=>'Hong Kong',
                                '97'=>'Hungary',
                                '98'=>'Iceland',
                                '99'=>'India',
                                '100'=>'Indonesia',
                                '101'=>'Iran, Islamic Republic of',
                                '102'=>'Iraq',
                                '103'=>'Ireland',
                                '104'=>'Israel',
                                '105'=>'Italy',
                                '106'=>'Jamaica',
                                '107'=>'Japan',
                                '108'=>'Jordan',
                                '109'=>'Kazakhstan',
                                '110'=>'Kenya',
                                '111'=>'Kiribati',
                                '112'=>"Korea, Democratic People's Republic of",
                                '113'=>'Korea, Republic of',
                                '114'=>'Kuwait',
                                '115'=>'Kyrgyzstan',
                                '116'=>"Lao People's Democratic Republic",
                                '117'=>'Latvia',
                                '118'=>'Lebanon',
                                '119'=>'Lesotho',
                                '120'=>'Liberia',
                                '121'=>'Libyan Arab Jamahiriya',
                                '122'=>'Liechtenstein',
                                '123'=>'Lithuania',
                                '124'=>'Luxembourg',
                                '125'=>'Macao',
                                '126'=>'Macedonia, the Former Yugoslav Republic of',
                                '127'=>'Madagascar',
                                '128'=>'Malawi',
                                '129'=>'Malaysia',
                                '130'=>'Maldives',
                                '131'=>'Mali',
                                '132'=>'Malta',
                                '133'=>'Marshall Islands',
                                '134'=>'Martinique',
                                '135'=>'Mauritania',
                                '136'=>'Mauritius',
                                '137'=>'Mayotte',
                                '138'=>'Mexico',
                                '139'=>'Micronesia, Federated States of',
                                '140'=>'Moldova, Republic of',
                                '141'=>'Monaco',
                                '142'=>'Mongolia',
                                '143'=>'Montserrat',
                                '144'=>'Morocco',
                                '145'=>'Mozambique',
                                '146'=>'Myanmar',
                                '147'=>'Namibia',
                                '148'=>'Nauru',
                                '149'=>'Nepal',
                                '150'=>'Netherlands',
                                '151'=>'Netherlands Antilles',
                                '152'=>'New Caledonia',
                                '153'=>'New Zealand',
                                '154'=>'Nicaragua',
                                '155'=>'Niger',
                                '156'=>'Nigeria',
                                '157'=>'Niue',
                                '158'=>'Norfolk Island',
                                '159'=>'Northern Mariana Islands',
                                '160'=>'Norway',
                                '161'=>'Oman',
                                '162'=>'Pakistan',
                                '163'=>'Palau',
                                '164'=>'Palestinian Territory, Occupied',
                                '165'=>'Panama',
                                '166'=>'Papua New Guinea',
                                '167'=>'Paraguay',
                                '168'=>'Peru',
                                '169'=>'Philippines',
                                '170'=>'Pitcairn',
                                '171'=>'Poland',
                                '172'=>'Portugal',
                                '173'=>'Puerto Rico',
                                '174'=>'Qatar',
                                '175'=>'Reunion',
                                '176'=>'Romania',
                                '177'=>'Russian Federation',
                                '178'=>'Rwanda',
                                '179'=>'Saint Helena',
                                '180'=>'Saint Kitts and Nevis',
                                '181'=>'Saint Lucia',
                                '182'=>'Saint Pierre and Miquelon',
                                '183'=>'Saint Vincent and the Grenadines',
                                '184'=>'Samoa',
                                '185'=>'San Marino',
                                '186'=>'Sao Tome and Principe',
                                '187'=>'Saudi Arabia',
                                '188'=>'Senegal',
                                '189'=>'Serbia and Montenegro',
                                '190'=>'Seychelles',
                                '191'=>'Sierra Leone',
                                '192'=>'Singapore',
                                '193'=>'Slovakia',
                                '194'=>'Slovenia',
                                '195'=>'Solomon Islands',
                                '196'=>'Somalia',
                                '197'=>'South Africa',
                                '198'=>'South Georgia and the South Sandwich Islands',
                                '199'=>'Spain',
                                '200'=>'Sri Lanka',
                                '201'=>'Sudan',
                                '202'=>'Suriname',
                                '203'=>'Svalbard and Jan Mayen',
                                '204'=>'Swaziland',
                                '205'=>'Sweden',
                                '206'=>'Switzerland',
                                '207'=>'Syrian Arab Republic',
                                '208'=>'Taiwan',
                                '209'=>'Tajikistan',
                                '210'=>'Tanzania, United Republic of',
                                '211'=>'Thailand',
                                '212'=>'Timor-Leste',
                                '213'=>'Togo',
                                '214'=>'Tokelau',
                                '215'=>'Tonga',
                                '216'=>'Trinidad and Tobago',
                                '217'=>'Tunisia',
                                '218'=>'Turkey',
                                '219'=>'Turkmenistan',
                                '220'=>'Turks and Caicos Islands',
                                '221'=>'Tuvalu',
                                '222'=>'Uganda',
                                '223'=>'Ukraine',
                                '224'=>'United Arab Emirates',
                                '225'=>'United Kingdom',
                                '226'=>'United States',
                                '227'=>'United States Minor Outlying Islands',
                                '228'=>'Uruguay',
                                '229'=>'Uzbekistan',
                                '230'=>'Vanuatu',
                                '231'=>'Venezuela',
                                '232'=>'Viet Nam',
                                '233'=>'Virgin Islands, British',
                                '234'=>'Virgin Islands, U.s.',
                                '235'=>'Wallis and Futuna',
                                '236'=>'Western Sahara',
                                '237'=>'Yemen',
                                '238'=>'Zambia',
                                ], (isset($user_profile->come_from) && $user_profile->come_from) ? $user_profile->come_from : "0", ["class"=> "form-control"] ) !!}
                        </div>
        <!-- come_reason  field -->
                        <div class="form-group">
                            {!! Form::label("come_reason","come_reason: ") !!}
                            {!! Form::select('come_reason', [
                                '1'=>'Work',
                                '2'=>'Travel',
                                '3'=>'Study',
                                '4'=>'Family'
                                ], (isset($user_profile->come_reason) && $user_profile->come_reason) ? $user_profile->come_reason : "0", ["class"=> "form-control"] ) !!}
                        </div>
        <!-- gender  field -->
                        <div class="form-group">
                            {!! Form::label("gender","gender: ") !!}
                            {!! Form::select('gender', [
                                '1'=>'Male',
                                '2'=>'Female',
                                ], (isset($user_profile->gender) && $user_profile->gender) ? $user_profile->gender : "0", ["class"=> "form-control"] ) !!}
                        </div>
        <!-- marital  field -->
                        <div class="form-group">
                            {!! Form::label("marital","marital: ") !!}
                            {!! Form::select('marital', [
                                '1'=>'Married',
                                '2'=>'Single',
                                ], (isset($user_profile->marital) && $user_profile->marital) ? $user_profile->marital : "0", ["class"=> "form-control"] ) !!}
                        </div>
        <!-- interests  field -->
                        <div class="form-group">
                            {!! Form::label("kids","kids: ") !!}
                            {!! Form::select('kids', [
                                '1'=>'Over 12',
                                '2'=>'Under 12',
                                '3'=>'None',
                                ], (isset($user_profile->kids) && $user_profile->kids) ? $user_profile->kids : "0", ["class"=> "form-control"] ) !!}
                        </div>
        <!-- kids  field -->
                        <div class="form-group">
                            {!! Form::label("kids","kids: ") !!}
                            {!! Form::select('kids', [
                                '1'=>'Over 12',
                                '2'=>'Under 12',
                                '3'=>'None',
                                ], (isset($user_profile->kids) && $user_profile->kids) ? $user_profile->kids : "0", ["class"=> "form-control"] ) !!}
                        </div>
        <!-- birthday  field -->
                        <div class="form-group">
                            {!! Form::label('birthday','birthday:') !!}
                            {!! Form::date('birthday', null, ['class' => 'form-control', 'placeholder' => '']) !!}
                        </div>
                        <span class="text-danger">{!! $errors->first('birthday') !!}</span>
                                <!-- is_bussiness text field 
                        <div class="form-group">
                            {!! Form::label('is_bussiness','is_bussiness:') !!}
                            {!! Form::text('is_bussiness', null, ['class' => 'form-control', 'placeholder' => '']) !!}
                        </div>
                        <span class="text-danger">{!! $errors->first('is_bussiness') !!}</span>-->
        <!-- is_bussiness  field -->
                        <div class="form-group">
                        {!! Form::label("is_bussiness","is_bussiness: ") !!}
                        {!! Form::select('is_bussiness', ["1" => "Yes", "0" => "No"], (isset($user_profile->is_bussiness) && $user_profile->is_bussiness) ? $user_profile->is_bussiness : "0", ["class"=> "form-control"] ) !!}
                        </div>
        <!-- is_paid_for_classifieds  field -->
                        <div class="form-group">
                        {!! Form::label("is_paid_for_classifieds","is_paid_for_classifieds: ") !!}
                        {!! Form::select('is_paid_for_classifieds', ["1" => "Yes", "0" => "No"], (isset($user_profile->is_paid_for_classifieds) && $user_profile->is_paid_for_classifieds) ? $user_profile->is_paid_for_classifieds : "0", ["class"=> "form-control"] ) !!}
                        </div>
        <!-- is_approved  field -->
                        <div class="form-group">
                        {!! Form::label("is_approved","is_approved: ") !!}
                        {!! Form::select('is_approved', 
                            ["1" => "Yes", 
                            "0" => "No"], 
                        (isset($user_profile->is_approved) && $user_profile->is_approved) ? $user_profile->is_approved : "0", ["class"=> "form-control"] ) !!}
                        </div>


                        {{-- custom profile fields --}}
                        @foreach($custom_profile->getAllTypesWithValues() as $profile_data)
                        <div class="form-group">
                            {!! Form::label($profile_data->description) !!}
                            {!! Form::text("custom_profile_{$profile_data->id}", $profile_data->value, ["class" => "form-control"]) !!}
                            {{-- delete field --}}
                        </div>
                        @endforeach

                        {!! Form::hidden('user_id', $user_profile->user_id) !!}
                        {!! Form::hidden('id', $user_profile->id) !!}
                        {!! Form::submit('Save',['class' =>'btn btn-info pull-right margin-bottom-30']) !!}
                        {!! Form::close() !!}
                    </div>
                    <div class="col-md-6 col-xs-12">

                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
</div>
@endsection
