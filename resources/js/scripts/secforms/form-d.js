$('#add-related-person').on('click', function () {
    $('body').removeClass('brand-minimized sidebar-minimized');
    let tableTwoForm = '<form id="table-related-person">\n' +
        '    <label>Related Person Information</label>\n' +
        '    <div class="form-group">\n' +
        '        <input style="color: #000" class="form-control" name="last-name" type="text" placeholder="Last Name"/>\n' +
        '    </div>\n' +
        '    <div class="form-group">\n' +
        '        <input style="color: #000" class="form-control" name="first-name" type="text" placeholder="First Name"/>\n' +
        '    </div>\n' +
        '    <div class="form-group">\n' +
        '        <input style="color: #000" class="form-control" name="middle-name" type="text" placeholder="Middle Name"/>\n' +
        '    </div>\n' +
        '    <div class="form-group">\n' +
        '        <input style="color: #000" class="form-control" name="address1" type="text" placeholder="Street Address 1"/>\n' +
        '    </div>\n' +
        '    <div class="form-group">\n' +
        '        <input style="color: #000" class="form-control" name="address2" type="text" placeholder="Street Address 2"/>\n' +
        '    </div>\n' +
        '    <div class="form-group">\n' +
        '        <input style="color: #000" class="form-control" name="city" type="text" placeholder="City"/>\n' +
        '    </div>\n' +
        '    <div class="form-group">\n' +
        '     <select class="select" width="25%" name="relatedPersonStateOrCountry" id="relatedPersonStateOrCountryData" >\n' +
        '       <option value=""></option>\n' +
        '      <option value="AL">ALABAMA</option>\n' +
        '      <option value="AK">ALASKA</option>\n' +
        '     <option value="AZ">ARIZONA</option>\n' +
        '      <option value="AR">ARKANSAS</option>\n' +
        '      <option value="CA">CALIFORNIA</option>\n' +
        '      <option value="CO">COLORADO</option>\n' +
        '      <option value="CT">CONNECTICUT</option>\n' +
        '      <option value="DE">DELAWARE</option>\n' +
        '     <option value="DC">DISTRICT OF COLUMBIA</option>\n' +
        '     <option value="FL">FLORIDA</option>\n' +
        '     <option value="GA">GEORGIA</option>\n' +
        '     <option value="HI">HAWAII</option>\n' +
        '     <option value="ID">IDAHO</option>\n' +
        '      <option value="IL">ILLINOIS</option>\n' +
        '      <option value="IN">INDIANA</option>\n' +
        '       <option value="IA">IOWA</option>\n' +
        '      <option value="KS">KANSAS</option>\n' +
        '     <option value="KY">KENTUCKY</option>\n' +
        '      <option value="LA">LOUISIANA</option>\n' +
        '     <option value="ME">MAINE</option>\n' +
        '     <option value="MD">MARYLAND</option>\n' +
        '     <option value="MA">MASSACHUSETTS</option>\n' +
        '<option value="MI">MICHIGAN</option>\n' +
        '<option value="MN">MINNESOTA</option>\n' +
        '<option value="MS">MISSISSIPPI</option>\n' +
        '<option value="MO">MISSOURI</option>\n' +
        '<option value="MT">MONTANA</option>\n' +
        '<option value="NE">NEBRASKA</option>\n' +
        '<option value="NV">NEVADA</option>\n' +
        '<option value="NH">NEW HAMPSHIRE</option>\n' +
        '<option value="NJ">NEW JERSEY</option>\n' +
        '<option value="MN">NEW MEXICO</option>\n' +
        '<option value="NY">NEW YORK</option>\n' +
        ' <option value="NC">NORTH CAROLINA</option>\n' +
        '<option value="ND">NORTH DAKOTA</option>\n' +
        '<option value="OH">OHIO</option>\n' +
        '<option value="OK">OKLAHOMA</option>\n' +
        '<option value="OR">OREGON</option>\n' +
        '<option value="PA">PENNSYLVANIA</option>\n' +
        '<option value="RI">RHODE ISLAND</option>\n' +
        '<option value="SC">SOUTH CAROLINA</option>\n' +
        '<option value="SD">SOUTH DAKOTA</option>\n' +
        ' <option value="TN">TENNESSEE</option>\n' +
        '<option value="TX">TEXAS</option>\n' +
        '<option value="X1">UNITED STATES</option>\n' +
        '<option value="UT">UTAH</option>\n' +
        '<option value="VT">VERMONT</option>\n' +
        '<option value="VA">VIRGINIA</option>\n' +
        '<option value="WA">WASHINGTON</option>\n' +
        '<option value="WV">WEST VIRGINIA</option>\n' +
        '<option value="WI">WISCONSIN</option>\n' +
        '<option value="WY">WYOMING</option>\n' +
        '<option value="A0">ALBERTA, CANADA</option>\n' +
        '<option value="A1">BRITISH COLUMBIA, CANADA</option>\n' +
        '<option value="A2">MANITOBA, CANADA</option>\n' +
        '<option value="A3">NEW BRUNSWICK, CANADA</option>\n' +
        '<option value="A4">NEWFOUNDLAND, CANADA</option>\n' +
        '<option value="A5">NOVA SCOTIA, CANADA</option>\n' +
        '<option value="A6">ONTARIO, CANADA</option>\n' +
        '<option value="A7">PRINCE EDWARD ISLAND, CANADA</option>\n' +
        '<option value="A8">QUEBEC, CANADA</option>\n' +
        '<option value="A9">SASKATCHEWAN, CANADA</option>\n' +
        '<option value="B0">YUKON, CANADA</option>\n' +
        '<option value="Z4">CANADA (FEDERAL LEVEL)</option>\n' +
        '<option value="B2">AFGHANISTAN</option>\n' +
        '<option value="Y6">ALAND ISLANDS</option>\n' +
        '<option value="B3">ALBANIA</option>\n' +
        '<option value="B4">ALGERIA</option>\n' +
        '<option value="B5">AMERICAN SAMOA</option>\n' +
        '<option value="B6">ANDORRA</option>\n' +
        '<option value="B7">ANGOLA</option>\n' +
        '<option value="1A">ANGUILLA</option>\n' +
        '<option value="B8">ANTARCTICA</option>\n' +
        '<option value="B9">ANTIGUA AND BARBUDA</option>\n' +
        '<option value="C1">ARGENTINA</option>\n' +
        '<option value="1B">ARMENIA</option>\n' +
        '<option value="1C">ARUBA</option>\n' +
        '<option value="C3">AUSTRALIA</option>\n' +
        '<option value="C4">AUSTRIA</option>\n' +
        '<option value="1D">AZERBAIJAN</option>\n' +
        '<option value="C5">BAHAMAS</option>\n' +
        '<option value="C6">BAHRAIN</option>\n' +
        '<option value="C7">BANGLADESH</option>\n' +
        '<option value="C8">BARBADOS</option>\n' +
        '<option value="1F">BELARUS</option>\n' +
        '<option value="C9">BELGIUM</option>\n' +
        '<option value="D1">BELIZE</option>\n' +
        '<option value="G6">BENIN</option>\n' +
        '<option value="D0">BERMUDA</option>\n' +
        '<option value="D2">BHUTAN</option>\n' +
        '<option value="D3">BOLIVIA</option>\n' +
        '<option value="1E">BOSNIA AND HERZEGOVINA</option>\n' +
        '<option value="B1">BOTSWANA</option>\n' +
        '<option value="D4">BOUVET ISLAND</option>\n' +
        '<option value="D5">BRAZIL</option>\n' +
        '<option value="D6">BRITISH INDIAN OCEAN TERRITORY</option>\n' +
        '<option value="D9">BRUNEI DARUSSALAM</option>\n' +
        '<option value="E0">BULGARIA</option>\n' +
        '<option value="X2">BURKINA FASO</option>\n' +
        '<option value="E2">BURUNDI</option>\n' +
        '<option value="E3">CAMBODIA</option>\n' +
        '<option value="E4">CAMEROON</option>\n' +
        '<option value="E8">CAPE VERDE</option>\n' +
        '<option value="E9">CAYMAN ISLANDS</option>\n' +
        '<option value="F0">CENTRAL AFRICAN REPUBLIC</option>\n' +
        '<option value="F2">CHAD</option>\n' +
        '<option value="F3">CHILE</option>\n' +
        '<option value="F4">CHINA</option>\n' +
        '<option value="F6">CHRISTMAS ISLAND</option>\n' +
        '<option value="F7">COCOS (KEELING) ISLANDS</option>\n' +
        '<option value="F8">COLOMBIA</option>\n' +
        '<option value="F9">COMOROS</option>\n' +
        '<option value="G0">CONGO</option>\n' +
       '<option value="Y3">CONGO, THE DEMOCRATIC REPUBLIC OF THE</option>\n' +
        '<option value="G1">COOK ISLANDS</option>\n' +
        '<option value="G2">COSTA RICA</option>\n' +
        '<option value="L7">COTE DIVOIRE</option>\n' +
        '<option value="1M">CROATIA</option>\n' +
        '<option value="G3">CUBA</option>\n' +
        '<option value="G4">CYPRUS</option>\n' +
        '<option value="2N">CZECH REPUBLIC</option>\n' +
        '<option value="G7">DENMARK</option>\n' +
        '<option value="1G">DJIBOUTI</option>\n' +
        '<option value="G9">DOMINICA</option>\n' +
        '<option value="G8">DOMINICAN REPUBLIC</option>\n' +
        '<option value="H1">ECUADOR</option>\n' +
        '<option value="H2">EGYPT</option>\n' +
        '<option value="H3">EL SALVADOR</option>\n' +
        '<option value="H4">EQUATORIAL GUINEA</option>\n' +
        '<option value="1J">ERITREA</option>\n' +
        '<option value="1H">ESTONIA</option>\n' +
        '<option value="H5">ETHIOPIA</option>\n' +
        '<option value="H7">FALKLAND ISLANDS (MALVINAS)</option>\n' +
        '<option value="H6">FAROE ISLANDS</option>\n' +
        '<option value="H8">FIJI</option>\n' +
        '<option value="H9">FINLAND</option>\n' +
        '<option value="I0">FRANCE</option>\n' +
        '<option value="I3">FRENCH GUIANA</option>\n' +
        '<option value="I4">FRENCH POLYNESIA</option>\n' +
        '<option value="2C">FRENCH SOUTHERN TERRITORIES</option>\n' +
        '<option value="I5">GABON</option>\n' +
        '<option value="I6">GAMBIA</option>\n' +
        '<option value="2Q">GEORGIA</option>\n' +
        '<option value="2M">GERMANY</option>\n' +
        '<option value="J0">GHANA</option>\n' +
        '<option value="J1">GIBRALTAR</option>\n' +
        '<option value="J3">GREECE</option>\n' +
       '<option value="J4">GREENLAND</option>\n' +
        '<option value="J5">GRENADA</option>\n' +
        '<option value="J6">GUADELOUPE</option>\n' +
       '<option value="GU">GUAM</option>\n' +
        '<option value="J8">GUATEMALA</option>\n' +
        '<option value="Y7">GUERNSEY</option>\n' +
        '<option value="J9">GUINEA</option>\n' +
        '<option value=J0">GUINEA-BISSAU</option>\n' +
        '<option value="K0">GUYANA</option>\n' +
        '<option value="K1">HAITI</option>\n' +
        '<option value="K4">HEARD ISLAND AND MCDONALD ISLANDS</option>\n' +
        '<option value="X4">HOLY SEE (VATICAN CITY STATE)</option>\n' +
        '<option value="K2">HONDURAS</option>\n' +
        '<option value="K3">HONG KONG</option>\n' +
        '<option value="K5">HUNGARY</option>\n' +
        '<option value="K6">ICELAND</option>\n' +
        '<option value="K7">INDIA</option>\n' +
        '<option value="K8">INDONESIA</option>\n' +
        '<option value="K9">IRAN, ISLAMIC REPUBLIC OF</option>\n' +
        '<option value="L0">IRAQ</option>\n' +
        '<option value="L2">IRELAND</option>\n' +
       '<option value="Y8">ISLE OF MAN</option>\n' +
       '<option value="L3">ISRAEL</option>\n' +
        '<option value="L6">ITALY</option>\n' +
        '<option value="L8">JAMAICA</option>\n' +
        '<option value="M0">JAPAN</option>\n' +
        '<option value="Y9">JERSEY</option>\n' +
        '<option value="M2">JORDAN</option>\n' +
        '<option value="1P">KAZAKSTAN</option>\n' +
        '<option value="M3">KENYA</option>\n' +
        '<option value="J2">KIRIBATI</option>\n' +
        '<option value="M4">KOREA, DEMOCRATIC PEOPLES REPUBLIC OF</option>\n' +
        '<option value="M5">KOREA, REPUBLIC OF</option>\n' +
        '<option value="M6">KUWAIT</option>\n' +
        '<option value="1N">KYRGYZSTAN</option>\n' +
        '<option value="M7">LAO PEOPLES DEMOCRATIC REPUBLIC</option>\n' +
        '<option value="1R">LATVIA</option>\n' +
        '<option value="M8">LEBANON</option>\n' +
        '<option value="M9">LESOTHO</option>\n' +
       '<option value="N0">LIBERIA</option>\n' +
        '<option value="N1">LIBYAN ARAB JAMAHIRIYA</option>\n' +
        '<option value="N2">LIECHTENSTEIN</option>\n' +
        '<option value="1Q">LITHUANIA</option>\n' +
        '<option value="N4">LUXEMBOURG</option>\n' +
        '<option value="N5">MACAU</option>\n' +
        '<option value="1U">MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF</option>\n' +
        '<option value="N6">MADAGASCAR</option>\n' +
        '<option value="N7">MALAWI</option>\n' +
        '<option value="N8">MALAYSIA</option>\n' +
        '<option value="N9">MALDIVES</option>\n' +
        '<option value="O0">MALI</option>\n' +
       '<option value="O1">MALTA</option>\n' +
        '<option value="1T">MARSHALL ISLANDS</option>\n' +
        '<option value="O2">MARTINIQUE</option>\n' +
        '<option value="O3">MAURITANIA</option>\n' +
        '<option value="O4">MAURITIUS</option>\n' +
        '<option value="2P">MAYOTTE</option>\n' +
        '<option value="O5">MEXICO</option>\n' +
        '<option value="1K">MICRONESIA, FEDERATED STATES OF</option>\n' +
        '<option value="1S">MOLDOVA, REPUBLIC OF</option>\n' +
        '<option value="O9">MONACO</option>\n' +
        '<option value="P0">MONGOLIA</option>\n' +
        '<option value="Z5">MONTENEGRO</option>\n' +
        '<option value="P1">MONTSERRAT</option>\n' +
        '<option value="P2">MOROCCO</option>\n' +
        '<option value="P3">MOZAMBIQUE</option>\n' +
        '<option value="E1">MYANMAR</option>\n' +
        '<option value="T6">NAMIBIA</option>\n' +
        '<option value="P5">NAURU</option>\n' +
        '<option value="P6">NEPAL</option>\n' +
        '<option value="P7">NETHERLANDS</option>\n' +
        '<option value="P8">NETHERLANDS ANTILLES</option>\n' +
        '<option value="1W">NEW CALEDONIA</option>\n' +
       '<option value="Q2">NEW ZEALAND</option>\n' +
        '<option value="Q3">NICARAGUA</option>\n' +
        '<option value="Q4">NIGER</option>\n' +
        '<option value="Q5">NIGERIA</option>\n' +
        '<option value="Q6">NIUE</option>\n' +
        '<option value="Q7">NORFOLK ISLAND</option>\n' +
        '<option value="1V">NORTHERN MARIANA ISLANDS</option>\n' +
        '<option value="Q8">NORWAY</option>\n' +
        '<option value="P4">OMAN</option>\n' +
       '<option value="R0">PAKISTAN</option>\n' +
        '<option value="1Y">PALAU</option>\n' +
        '<option value="1X">PALESTINIAN TERRITORY, OCCUPIED</option>\n' +
       '<option value="R1">PANAMA</option>\n' +
        '<option value="R2">PAPUA NEW GUINEA</option>\n' +
        '<option value="R4">PARAGUAY</option>\n' +
        '<option value="R5">PERU</option>\n' +
        '<option value="R6">PHILIPPINES</option>\n' +
        '<option value="R8">PITCAIRN</option>\n' +
        '<option value="R9">POLAND</option>\n' +
        '<option value="S1">PORTUGAL</option>\n' +
        '<option value="PR">PUERTO RICO</option>\n' +
        '<option value="S3">QATAR</option>\n' +
        '<option value="S4">REUNION</option>\n' +
        '<option value="S5">ROMANIA</option>\n' +
        '<option value="1Z">RUSSIAN FEDERATION</option>\n' +
        '<option value="S6">RWANDA</option>\n' +
        '<option value="Z0">SAINT BARTHELEMY</option>\n' +
        '<option value="U8">SAINT HELENA</option>\n' +
        '<option value="U7">SAINT KITTS AND NEVIS</option>\n' +
        '<option value="U9">SAINT LUCIA</option>\n' +
        '<option value="Z1">SAINT MARTIN</option>\n' +
        '<option value="V0">SAINT PIERRE AND MIQUELON</option>\n' +
        '<option value="V1">SAINT VINCENT AND THE GRENADINES</option>\n' +
        '<option value="Y0">SAMOA</option>\n' +
        '<option value="S8">SAN MARINO</option>\n' +
        '<option value="S9">SAO TOME AND PRINCIPE</option>\n' +
        '<option value="T0">SAUDI ARABIA</option>\n' +
        '<option value="T1">SENEGAL</option>\n' +
        '<option value="Z2">SERBIA</option>\n' +
        '<option value="T2">SEYCHELLES</option>\n' +
        '<option value="T8">SIERRA LEONE</option>\n' +
         '<option value="U0">SINGAPORE</option>\n' +
        '<option value="2B">SLOVAKIA</option>\n' +
        '<option value="2A">SLOVENIA</option>\n' +
        '<option value="D7">SOLOMON ISLANDS</option>\n' +
         '<option value="U1">SOMALIA</option>\n' +
        '<option value="T3">SOUTH AFRICA</option>\n' +
        '<option value="1L">SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS</option>\n' +
        '<option value="U3">SPAIN</option>\n' +
        '<option value="F1">SRI LANKA</option>\n' +
        '<option value="V2">SUDAN</option>\n' +
        '<option value="V3">SURINAME</option>\n' +
        '<option value="L9">SVALBARD AND JAN MAYEN</option>\n' +
        '<option value="V6">SWAZILAND</option>\n' +
        '<option value="V7">SWEDEN</option>\n' +
        '<option value="V8">SWITZERLAND</option>\n' +
        '<option value="V9">SYRIAN ARAB REPUBLIC</option>\n' +
        '<option value="F5">TAIWAN, PROVINCE OF CHINA</option>\n' +
        '<option value="2D">TAJIKISTAN</option>\n' +
        '<option value="W0">TANZANIA, UNITED REPUBLIC OF</option>\n' +
        '<option value="W1">THAILAND</option>\n' +
        '<option value="Z3">TIMOR-LESTE</option>\n' +
        '<option value="W2">TOGO</option>\n' +
        '<option value="W3">TOKELAU</option>\n' +
        '<option value="W4">TONGA</option>\n' +
        '<option value="W5">TRINIDAD AND TOBAGO</option>\n' +
        '<option value="W6">TUNISIA</option>\n' +
        '<option value="W8">TURKEY</option>\n' +
        '<option value="2E">TURKMENISTAN</option>\n' +
        '<option value="W7">TURKS AND CAICOS ISLANDS</option>\n' +
        '<option value="2G">TUVALU</option>\n' +
        '<option value="W9">UGANDA</option>\n' +
        '<option value="2H">UKRAINE</option>\n' +
        '<option value="CO">UNITED ARAB EMIRATES</option>\n' +
        '<option value="X0">UNITED KINGDOM</option>\n' +
        '<option value="2J">UNITED STATES MINOR OUTLYING ISLANDS</option>\n' +
        '<option value="X3">URUGUAY</option>\n' +
        '<option value="2K">UZBEKISTAN</option>\n' +
        '<option value="2L">VANUATU</option>\n' +
        '<option value="X5">VENEZUELA</option>\n' +
        '<option value="Q1">VIETNAM</option>\n' +
        '<option value="D8">VIRGIN ISLANDS, BRITISH</option>\n' +
        '<option value="VI">VIRGIN ISLANDS, U.S.</option>\n' +
        '<option value="X8">WALLIS AND FUTUNA</option>\n' +
        '<option value="U5">WESTERN SAHARA</option>\n' +
        '<option value="T7">YEMEN</option>\n' +
        '<option value="Y4">ZAMBIA</option>\n' +
        '<option value="Y5">ZIMBABWE</option>\n' +
        '<option value="XX">Unknown</option>\n' +
        ' </select>\n' +
        '<i class="far fa-edit" style="padding-left: 7px;  font-size: 15px; display: none"></i>\n' +
        ' </div>\n' +
        '    <div class="form-group">\n' +
        '        <input style="color: #000" class="form-control" name="postal-code" type="text" placeholder="ZIP/PostalCode"/>\n' +
        '    </div>\n' +
        '    <label>Relationship:</label>\n' +
        '    <div class="checkbox">\n' +
        '      <input type="checkbox" name="executive" value="1"/><i class="far fa-edit" style="padding-left: 7px; font-size: 15px; display: none"></i>\n' +
        '          <td class="FormText">Executive Officer</td>\n' +
        '    </div>\n' +
        '    <div class="checkbox">\n' +
        '         <input type="checkbox" name="director" value="1"/><i class="far fa-edit" style="padding-left: 7px; font-size: 15px; display: none"></i>\n' +
        '          <td class="FormText">Director</td>\n' +
        '    </div>\n' +
        '    <div class="checkbox">\n' +
        '          <input type="checkbox" name="promoter" value="1"/><i class="far fa-edit" style="padding-left: 7px; font-size: 15px; display: none"></i>\n' +
        '          <td class="FormText">Promoter</td>\n' +
        '    </div>\n' +
        '    <div class="form-group">\n' +
        '        <input style="color: #000" class="form-control" name="response-related-persons" type="text" placeholder="Clarification of Response (if Necessary):"/>\n' +
        '    </div>\n';

    tableTwoForm += '<button type="button" id="add-related-person-row" class="btn btn-primary pull-right sidebar-btn" style="margin-left: 5px;">Confirm</button>\n';
    tableTwoForm += '<button type="button" id="discard-row" class="btn btn-primary pull-right sidebar-btn" style="margin-left: 5px;">Discard</button>\n' +
        '<form>\n';

    $('.add-table-row-div').html(tableTwoForm);
});

$('body').on('click', '#add-related-person-row', function (e) {
    let data = [];

    var inputs = $('form#table-related-person').serializeArray();
    $.each(inputs, function (i, field) {
        data[field.name] = field.value;
    });
    data['stateOrCountryDescription'] = $('#relatedPersonStateOrCountryData option:selected').text();
    generateTableRPRow(data);
});

function generateTableRPRow(data) {
    if (data['executive'] == undefined) {
        data['executive'] = '☐';
    } else {
        data['executive'] = '☒';
    }
    if (data['director'] == undefined) {
        data['director'] = '☐';
    } else {
        data['director'] = '☒';
    }
    if (data['promoter'] == undefined) {
        data['promoter'] = '☐';
    } else {
        data['promoter'] = '☒';
    }

    let relatedPerson = '<div class="related-person"><table summary="Related Persons" width="90%">\n' +
        ' <tbody>\n' +
        '<tr>\n' +
        '<th class="FormText" width="30%">Last Name</th>\n' +
        '<th class="FormText" width="30%">First Name</th>\n' +
        '<th class="FormText" width="30%">Middle Name</th>\n' +
        '</tr>\n' +
        '<tr>\n' +
        '<td class="FormData filing-data" data-name="last-name" >' + data['last-name'] + '</td>\n' +
        '<td class="FormData  filing-data" data-name="first-name">' + data['first-name'] + '</td>\n' +
        '<td class="FormData filing-data"  data-name="middle-name">' + data['middle-name'] + '</td>\n' +
        ' </tr>\n' +
        '<tr>\n' +
        '<th class="FormText">Street Address 1</th>\n' +
        '<th class="FormText">Street Address 2</th>\n' +
        '</tr>\n' +
        '<tr>\n' +
        '<td class="FormData filing-data"  data-name="address1">' + data['address1'] + '</td>\n' +
        '<td class="FormData filing-data"  data-name="address2">' + data['address2'] + '</td>\n' +
        ' </tr>\n' +
        '<tr>\n' +
        '<th class="FormText">City</th>\n' +
        ' <th class="FormText">State/Province/Country</th>\n' +
        '<th class="FormText">ZIP/PostalCode</th>\n' +
        '</tr>\n' +
        '<tr>\n' +
        '<td class="FormData filing-data" data-name="city">' + data['city'] + '</td>\n' +
        '<td class="FormData filing-data" data-name="relatedPersonStateOrCountry" data-code="stateOrCountryDescription" data-code-description="'+ data['relatedPersonStateOrCountry']+ '">' + data['stateOrCountryDescription'] + '</td>\n' +
        '<td class="FormData filing-data"  data-name="postal-code">' + data['postal-code'] + '</td>\n' +
        '</tr>\n' +
        ' </tbody>\n' +
        '</table>\n' +
        '<table summary="Relationship of Person">\n' +
        '<tbody>\n' +
        '<tr>\n' +
        '<th class="FormText">Relationship:</th>\n' +
        '<td  class="FormData filing-data"  data-name="executive">' + data['executive'] + '</td>\n' +
        '<td class="FormText">Executive Officer</td>\n' +
        '<td  class="FormData filing-data"  data-name="director">' + data['director'] + '</td>\n' +
        '<td class="FormText">Director</td>\n' +
        '<td  class="FormData filing-data"  data-name="promoter">' + data['promoter'] + '</td>\n' +
        '<td class="FormText">Promoter</td>\n' +
        '</tr>\n' +
        '</tbody>\n' +
        '</table>\n' +
        '<p class="FormText">Clarification of Response (if Necessary):</p>\n' +
        '<tr>\n' +
        '<span class="FormData filing-data"  data-name="response-related-persons">' + data['response-related-persons'] + '</span>\n' +
        '</tr>\n' +
        '</table>\n' +

        '        <td>\n' +
        '           <button type="button" class="btn btn-danger btn-sm delete-related-person">Delete Related Person</button>\n' +
        '        </td>\n' +
        '<hr>\n' +
        '</div>';

    $('.related-persons').append(relatedPerson);
    $('.add-table-row-div').html('');
}

$('body').on('click', '.delete-related-person', function () {
    $(this).closest('.related-person').remove();
});


//ADD RECIPIENT ------------------------------------------------------------------------------------------

$('#add-recipient').on('click', function () {
    $('body').removeClass('brand-minimized sidebar-minimized');
    let tableTwoForm = '<form id="table-recipient">\n' +
        '    <label>Recipient Information</label>\n' +
        '    <div class="form-group">\n' +
        '        <input style="color: #000" class="form-control" name="recipient-name" type="text" placeholder="Recipient"/>\n' +
        '    </div>\n' +
        '    <div class="form-group">\n' +
        '        <input style="color: #000" class="form-control" name="crd-number" type="text" placeholder="Recipient CRD Number"/>\n' +
        '    </div>\n' +
        '    <div class="checkbox">\n' +
        '         <input type="checkbox" name="none" value="☐"/><i class="far fa-edit" style="padding-left: 7px; font-size: 15px; display: none"></i>\n' +
        '          <td class="FormText">None</td>\n' +
        '    </div>\n' +
        '    <div class="form-group">\n' +
        '        <input style="color: #000" class="form-control" name="broker-dealer" type="text" placeholder="(Associated) Broker or Dealer"/>\n' +
        '    </div>\n' +
        '    <div class="checkbox">\n' +
        '         <input type="checkbox" name="none-broker" value="☐"/><i class="far fa-edit" style="padding-left: 7px; font-size: 15px; display: none"></i>\n' +
        '          <td class="FormText">None</td>\n' +
        '    </div>\n' +
        '    <div class="form-group">\n' +
        '        <input style="color: #000" class="form-control" name="broker-dealer-crd" type="text" placeholder="(Associated) Broker or Dealer CRD Number"/>\n' +
        '    </div>\n' +
        '    <div class="checkbox">\n' +
        '         <input type="checkbox" name="none-crd" value="☐"/><i class="far fa-edit" style="padding-left: 7px; font-size: 15px; display: none"></i>\n' +
        '          <td class="FormText">None</td>\n' +
        '    </div>\n' +
        '    <div class="form-group">\n' +
        '        <input style="color: #000" class="form-control" name="address1" type="text" placeholder="Street Address 1"/>\n' +
        '    </div>\n' +
        '    <div class="form-group">\n' +
        '        <input style="color: #000" class="form-control" name="address2" type="text" placeholder="Street Address 2"/>\n' +
        '    </div>\n' +
        '    <div class="form-group">\n' +
        '        <input style="color: #000" class="form-control" name="city" type="text" placeholder="City"/>\n' +
        '    </div>\n' +
        '    <div class="form-group">\n' +
        '    <select class="select" width="25%" name="recipientStateOrCountry" id="recipientStateOrCountryData">\n' +
        '                          <option value=""></option>\n' +
        '                        <option value="AL">ALABAMA</option>\n' +
        '                        <option value="AK">ALASKA</option>\n' +
        '                        <option value="AZ">ARIZONA</option>\n' +
        '                        <option value="AR">ARKANSAS</option>\n' +
        '                        <option value="CA">CALIFORNIA</option>\n' +
        '                        <option value="CO">COLORADO</option>\n' +
        '                        <option value="CT">CONNECTICUT</option>\n' +
        '                        <option value="DE">DELAWARE</option>\n' +
        '                        <option value="DC">DISTRICT OF COLUMBIA</option>\n' +
        '                        <option value="FL">FLORIDA</option>\n' +
        '                        <option value="GA">GEORGIA</option>\n' +
        '                        <option value="HI">HAWAII</option>\n' +
        '                        <option value="ID">IDAHO</option>\n' +
        '                        <option value="IL">ILLINOIS</option>\n' +
        '                        <option value="IN">INDIANA</option>\n' +
        '                        <option value="IA">IOWA</option>\n' +
        '                        <option value="KS">KANSAS</option>\n' +
        '                        <option value="KY">KENTUCKY</option>\n' +
        '                        <option value="LA">LOUISIANA</option>\n' +
        '                        <option value="ME">MAINE</option>\n' +
        '                        <option value="MD">MARYLAND</option>\n' +
        '                        <option value="MA">MASSACHUSETTS</option>\n' +
        '                        <option value="MI">MICHIGAN</option>\n' +
        '                        <option value="MN">MINNESOTA</option>\n' +
        '                        <option value="MS">MISSISSIPPI</option>\n' +
        '                        <option value="MO">MISSOURI</option>\n' +
        '                        <option value="MT">MONTANA</option>\n' +
        '                        <option value="NE">NEBRASKA</option>\n' +
        '                        <option value="NV">NEVADA</option>\n' +
        '                        <option value="NH">NEW HAMPSHIRE</option>\n' +
        '                        <option value="NJ">NEW JERSEY</option>\n' +
        '                        <option value="MN">NEW MEXICO</option>\n' +
        '                        <option value="NY">NEW YORK</option>\n' +
        '                        <option value="NC">NORTH CAROLINA</option>\n' +
        '                        <option value="ND">NORTH DAKOTA</option>\n' +
        '                        <option value="OH">OHIO</option>\n' +
        '                        <option value="OK">OKLAHOMA</option>\n' +
        '                        <option value="OR">OREGON</option>\n' +
        '                        <option value="PA">PENNSYLVANIA</option>\n' +
        '                        <option value="RI">RHODE ISLAND</option>\n' +
        '                        <option value="SC">SOUTH CAROLINA</option>\n' +
        '                        <option value="SD">SOUTH DAKOTA</option>\n' +
        '                        <option value="TN">TENNESSEE</option>\n' +
        '                        <option value="TX">TEXAS</option>\n' +
        '                        <option value="X1">UNITED STATES</option>\n' +
        '                        <option value="UT">UTAH</option>\n' +
        '                        <option value="VT">VERMONT</option>\n' +
        '                        <option value="VA">VIRGINIA</option>\n' +
        '                        <option value="WA">WASHINGTON</option>\n' +
        '                        <option value="WV">WEST VIRGINIA</option>\n' +
        '                        <option value="WI">WISCONSIN</option>\n' +
        '                        <option value="WY">WYOMING</option>\n' +
        '<option value="A0">ALBERTA, CANADA</option>\n' +
        '<option value="A1">BRITISH COLUMBIA, CANADA</option>\n' +
        '<option value="A2">MANITOBA, CANADA</option>\n' +
        '<option value="A3">NEW BRUNSWICK, CANADA</option>\n' +
        '<option value="A4">NEWFOUNDLAND, CANADA</option>\n' +
        '<option value="A5">NOVA SCOTIA, CANADA</option>\n' +
        '<option value="A6">ONTARIO, CANADA</option>\n' +
        '<option value="A7">PRINCE EDWARD ISLAND, CANADA</option>\n' +
        '<option value="A8">QUEBEC, CANADA</option>\n' +
        '<option value="A9">SASKATCHEWAN, CANADA</option>\n' +
        '<option value="B0">YUKON, CANADA</option>\n' +
        '<option value="Z4">CANADA (FEDERAL LEVEL)</option>\n' +
        '<option value="B2">AFGHANISTAN</option>\n' +
        '<option value="Y6">ALAND ISLANDS</option>\n' +
        '<option value="B3">ALBANIA</option>\n' +
        '<option value="B4">ALGERIA</option>\n' +
        '<option value="B5">AMERICAN SAMOA</option>\n' +
        '<option value="B6">ANDORRA</option>\n' +
        '<option value="B7">ANGOLA</option>\n' +
        '<option value="1A">ANGUILLA</option>\n' +
        '<option value="B8">ANTARCTICA</option>\n' +
        '<option value="B9">ANTIGUA AND BARBUDA</option>\n' +
        '<option value="C1">ARGENTINA</option>\n' +
        '<option value="1B">ARMENIA</option>\n' +
        '<option value="1C">ARUBA</option>\n' +
        '<option value="C3">AUSTRALIA</option>\n' +
        '<option value="C4">AUSTRIA</option>\n' +
        '<option value="1D">AZERBAIJAN</option>\n' +
        '<option value="C5">BAHAMAS</option>\n' +
        '<option value="C6">BAHRAIN</option>\n' +
        '<option value="C7">BANGLADESH</option>\n' +
        '<option value="C8">BARBADOS</option>\n' +
        '<option value="1F">BELARUS</option>\n' +
        ' <option value="C9">BELGIUM</option>\n' +
        '<option value="D1">BELIZE</option>\n' +
        '<option value="G6">BENIN</option>\n' +
        '<option value="D0">BERMUDA</option>\n' +
        '<option value="D2">BHUTAN</option>\n' +
        '<option value="D3">BOLIVIA</option>\n' +
        '<option value="1E">BOSNIA AND HERZEGOVINA</option>\n' +
        '<option value="B1">BOTSWANA</option>\n' +
        '<option value="D4">BOUVET ISLAND</option>\n' +
        '<option value="D5">BRAZIL</option>\n' +
        '<option value="D6">BRITISH INDIAN OCEAN TERRITORY</option>\n' +
        '<option value="D9">BRUNEI DARUSSALAM</option>\n' +
        '<option value="E0">BULGARIA</option>\n' +
        '<option value="X2">BURKINA FASO</option>\n' +
        '<option value="E2">BURUNDI</option>\n' +
        '<option value="E3">CAMBODIA</option>\n' +
        '<option value="E4">CAMEROON</option>\n' +
        '<option value="E8">CAPE VERDE</option>\n' +
        '<option value="E9">CAYMAN ISLANDS</option>\n' +
        '<option value="F0">CENTRAL AFRICAN REPUBLIC</option>\n' +
        '<option value="F2">CHAD</option>\n' +
        '<option value="F3">CHILE</option>\n' +
        '<option value="F4">CHINA</option>\n' +
        '<option value="F6">CHRISTMAS ISLAND</option>\n' +
        '<option value="F7">COCOS (KEELING) ISLANDS</option>\n' +
        '<option value="F8">COLOMBIA</option>\n' +
        '<option value="F9">COMOROS</option>\n' +
        '<option value="G0">CONGO</option>\n' +
        '<option value="Y3">CONGO, THE DEMOCRATIC REPUBLIC OF THE</option>\n' +
        '<option value="G1">COOK ISLANDS</option>\n' +
        '<option value="G2">COSTA RICA</option>\n' +
        '<option value="L7">COTE DIVOIRE</option>\n' +
        '<option value="1M">CROATIA</option>\n' +
        '<option value="G3">CUBA</option>\n' +
        '<option value="G4">CYPRUS</option>\n' +
        '<option value="2N">CZECH REPUBLIC</option>\n' +
        '<option value="G7">DENMARK</option>\n' +
        '<option value="1G">DJIBOUTI</option>\n' +
        '<option value="G9">DOMINICA</option>\n' +
        '<option value="G8">DOMINICAN REPUBLIC</option>\n' +
        '<option value="H1">ECUADOR</option>\n' +
        '<option value="H2">EGYPT</option>\n' +
        '<option value="H3">EL SALVADOR</option>\n' +
        '<option value="H4">EQUATORIAL GUINEA</option>\n' +
        '<option value="1J">ERITREA</option>\n' +
        '<option value="1H">ESTONIA</option>\n' +
        '<option value="H5">ETHIOPIA</option>\n' +
        '<option value="H7">FALKLAND ISLANDS (MALVINAS)</option>\n' +
        '<option value="H6">FAROE ISLANDS</option>\n' +
        '<option value="H8">FIJI</option>\n' +
        '<option value="H9">FINLAND</option>\n' +
        '<option value="I0">FRANCE</option>\n' +
        '<option value="I3">FRENCH GUIANA</option>\n' +
        '<option value="I4">FRENCH POLYNESIA</option>\n' +
        '<option value="2C">FRENCH SOUTHERN TERRITORIES</option>\n' +
        '<option value="I5">GABON</option>\n' +
        '<option value="I6">GAMBIA</option>\n' +
        '<option value="2Q">GEORGIA</option>\n' +
        '<option value="2M">GERMANY</option>\n' +
        '<option value="J0">GHANA</option>\n' +
        '<option value="J1">GIBRALTAR</option>\n' +
        '<option value="J3">GREECE</option>\n' +
        '<option value="J4">GREENLAND</option>\n' +
        '<option value="J5">GRENADA</option>\n' +
        '<option value="J6">GUADELOUPE</option>\n' +
        '<option value="GU">GUAM</option>\n' +
        '<option value="J8">GUATEMALA</option>\n' +
        '<option value="Y7">GUERNSEY</option>\n' +
        '<option value="J9">GUINEA</option>\n' +
        '<option value=J0">GUINEA-BISSAU</option>\n' +
        '<option value="K0">GUYANA</option>\n' +
        '<option value="K1">HAITI</option>\n' +
        '<option value="K4">HEARD ISLAND AND MCDONALD ISLANDS</option>\n' +
        '<option value="X4">HOLY SEE (VATICAN CITY STATE)</option>\n' +
        '<option value="K2">HONDURAS</option>\n' +
        '<option value="K3">HONG KONG</option>\n' +
        '<option value="K5">HUNGARY</option>\n' +
        '<option value="K6">ICELAND</option>\n' +
        '<option value="K7">INDIA</option>\n' +
        '<option value="K8">INDONESIA</option>\n' +
        '<option value="K9">IRAN, ISLAMIC REPUBLIC OF</option>\n' +
        '<option value="L0">IRAQ</option>\n' +
        '<option value="L2">IRELAND</option>\n' +
        '<option value="Y8">ISLE OF MAN</option>\n' +
        '<option value="L3">ISRAEL</option>\n' +
        '<option value="L6">ITALY</option>\n' +
        '<option value="L8">JAMAICA</option>\n' +
        '<option value="M0">JAPAN</option>\n' +
        '<option value="Y9">JERSEY</option>\n' +
        '<option value="M2">JORDAN</option>\n' +
        '<option value="1P">KAZAKSTAN</option>\n' +
        '<option value="M3">KENYA</option>\n' +
        '<option value="J2">KIRIBATI</option>\n' +
        '<option value="M4">KOREA, DEMOCRATIC PEOPLES REPUBLIC OF</option>\n' +
        '<option value="M5">KOREA, REPUBLIC OF</option>\n' +
        '<option value="M6">KUWAIT</option>\n' +
        '<option value="1N">KYRGYZSTAN</option>\n' +
        '<option value="M7">LAO PEOPLES DEMOCRATIC REPUBLIC</option>\n' +
        '<option value="1R">LATVIA</option>\n' +
        '<option value="M8">LEBANON</option>\n' +
        '<option value="M9">LESOTHO</option>\n' +
        '<option value="N0">LIBERIA</option>\n' +
        '<option value="N1">LIBYAN ARAB JAMAHIRIYA</option>\n' +
        '<option value="N2">LIECHTENSTEIN</option>\n' +
        '<option value="1Q">LITHUANIA</option>\n' +
        '<option value="N4">LUXEMBOURG</option>\n' +
        '<option value="N5">MACAU</option>\n' +
        '<option value="1U">MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF</option>\n' +
        '<option value="N6">MADAGASCAR</option>\n' +
        '<option value="N7">MALAWI</option>\n' +
        '<option value="N8">MALAYSIA</option>\n' +
        '<option value="N9">MALDIVES</option>\n' +
        '<option value="O0">MALI</option>\n' +
        '<option value="O1">MALTA</option>\n' +
        '<option value="1T">MARSHALL ISLANDS</option>\n' +
        '<option value="O2">MARTINIQUE</option>\n' +
        '<option value="O3">MAURITANIA</option>\n' +
        '<option value="O4">MAURITIUS</option>\n' +
        '<option value="2P">MAYOTTE</option>\n' +
        '<option value="O5">MEXICO</option>\n' +
        '<option value="1K">MICRONESIA, FEDERATED STATES OF</option>\n' +
        '<option value="1S">MOLDOVA, REPUBLIC OF</option>\n' +
        '<option value="O9">MONACO</option>\n' +
        '<option value="P0">MONGOLIA</option>\n' +
        '<option value="Z5">MONTENEGRO</option>\n' +
        '<option value="P1">MONTSERRAT</option>\n' +
        '<option value="P2">MOROCCO</option>\n' +
        '<option value="P3">MOZAMBIQUE</option>\n' +
        '<option value="E1">MYANMAR</option>\n' +
        '<option value="T6">NAMIBIA</option>\n' +
        '<option value="P5">NAURU</option>\n' +
        '<option value="P6">NEPAL</option>\n' +
        '<option value="P7">NETHERLANDS</option>\n' +
        '<option value="P8">NETHERLANDS ANTILLES</option>\n' +
        '<option value="1W">NEW CALEDONIA</option>\n' +
        '<option value="Q2">NEW ZEALAND</option>\n' +
        '<option value="Q3">NICARAGUA</option>\n' +
        '<option value="Q4">NIGER</option>\n' +
        '<option value="Q5">NIGERIA</option>\n' +
        '<option value="Q6">NIUE</option>\n' +
        '<option value="Q7">NORFOLK ISLAND</option>\n' +
        '<option value="1V">NORTHERN MARIANA ISLANDS</option>\n' +
        '<option value="Q8">NORWAY</option>\n' +
        '<option value="P4">OMAN</option>\n' +
        '<option value="R0">PAKISTAN</option>\n' +
        '<option value="1Y">PALAU</option>\n' +
        '<option value="1X">PALESTINIAN TERRITORY, OCCUPIED</option>\n' +
        '<option value="R1">PANAMA</option>\n' +
        '<option value="R2">PAPUA NEW GUINEA</option>\n' +
        '<option value="R4">PARAGUAY</option>\n' +
        '<option value="R5">PERU</option>\n' +
        '<option value="R6">PHILIPPINES</option>\n' +
        '<option value="R8">PITCAIRN</option>\n' +
        '<option value="R9">POLAND</option>\n' +
        '<option value="S1">PORTUGAL</option>\n' +
        '<option value="PR">PUERTO RICO</option>\n' +
        '<option value="S3">QATAR</option>\n' +
        '<option value="S4">REUNION</option>\n' +
        '<option value="S5">ROMANIA</option>\n' +
        '<option value="1Z">RUSSIAN FEDERATION</option>\n' +
        '<option value="S6">RWANDA</option>\n' +
        '<option value="Z0">SAINT BARTHELEMY</option>\n' +
        '<option value="U8">SAINT HELENA</option>\n' +
        '<option value="U7">SAINT KITTS AND NEVIS</option>\n' +
        '<option value="U9">SAINT LUCIA</option>\n' +
        '<option value="Z1">SAINT MARTIN</option>\n' +
        '<option value="V0">SAINT PIERRE AND MIQUELON</option>\n' +
        '<option value="V1">SAINT VINCENT AND THE GRENADINES</option>\n' +
        '<option value="Y0">SAMOA</option>\n' +
        '<option value="S8">SAN MARINO</option>\n' +
        '<option value="S9">SAO TOME AND PRINCIPE</option>\n' +
        '<option value="T0">SAUDI ARABIA</option>\n' +
        '<option value="T1">SENEGAL</option>\n' +
        '<option value="Z2">SERBIA</option>\n' +
        '<option value="T2">SEYCHELLES</option>\n' +
        '<option value="T8">SIERRA LEONE</option>\n' +
        '<option value="U0">SINGAPORE</option>\n' +
        '<option value="2B">SLOVAKIA</option>\n' +
        '<option value="2A">SLOVENIA</option>\n' +
        '<option value="D7">SOLOMON ISLANDS</option>\n' +
        '<option value="U1">SOMALIA</option>\n' +
        '<option value="T3">SOUTH AFRICA</option>\n' +
        '<option value="1L">SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS</option>\n' +
        '<option value="U3">SPAIN</option>\n' +
        '<option value="F1">SRI LANKA</option>\n' +
        '<option value="V2">SUDAN</option>\n' +
        '<option value="V3">SURINAME</option>\n' +
        '<option value="L9">SVALBARD AND JAN MAYEN</option>\n' +
        '<option value="V6">SWAZILAND</option>\n' +
        '<option value="V7">SWEDEN</option>\n' +
        '<option value="V8">SWITZERLAND</option>\n' +
        '<option value="V9">SYRIAN ARAB REPUBLIC</option>\n' +
        '<option value="F5">TAIWAN, PROVINCE OF CHINA</option>\n' +
        '<option value="2D">TAJIKISTAN</option>\n' +
        '<option value="W0">TANZANIA, UNITED REPUBLIC OF</option>\n' +
        '<option value="W1">THAILAND</option>\n' +
        '<option value="Z3">TIMOR-LESTE</option>\n' +
        '<option value="W2">TOGO</option>\n' +
        '<option value="W3">TOKELAU</option>\n' +
        '<option value="W4">TONGA</option>\n' +
        '<option value="W5">TRINIDAD AND TOBAGO</option>\n' +
        '<option value="W6">TUNISIA</option>\n' +
        '<option value="W8">TURKEY</option>\n' +
        '<option value="2E">TURKMENISTAN</option>\n' +
        '<option value="W7">TURKS AND CAICOS ISLANDS</option>\n' +
        '<option value="2G">TUVALU</option>\n' +
        '<option value="W9">UGANDA</option>\n' +
        '<option value="2H">UKRAINE</option>\n' +
        '<option value="CO">UNITED ARAB EMIRATES</option>\n' +
        '<option value="X0">UNITED KINGDOM</option>\n' +
        '<option value="2J">UNITED STATES MINOR OUTLYING ISLANDS</option>\n' +
        '<option value="X3">URUGUAY</option>\n' +
        '<option value="2K">UZBEKISTAN</option>\n' +
        '<option value="2L">VANUATU</option>\n' +
        '<option value="X5">VENEZUELA</option>\n' +
        '<option value="Q1">VIETNAM</option>\n' +
        '<option value="D8">VIRGIN ISLANDS, BRITISH</option>\n' +
        '<option value="VI">VIRGIN ISLANDS, U.S.</option>\n' +
        '<option value="X8">WALLIS AND FUTUNA</option>\n' +
        '<option value="U5">WESTERN SAHARA</option>\n' +
        '<option value="T7">YEMEN</option>\n' +
        '<option value="Y4">ZAMBIA</option>\n' +
        '<option value="Y5">ZIMBABWE</option>\n' +
        '<option value="XX">Unknown</option>\n' +
        '</select>\n' +
        '<i class="far fa-edit" style="padding-left: 7px;  font-size: 15px; display: none"></i>\n' +
        ' </div>\n' +
        '    <div class="form-group">\n' +
        '        <input style="color: #000" class="form-control" name="zip" type="text" placeholder="ZIP/Postal Code"/>\n' +
        '    </div>\n' +
        '   <label>State(s) of Solicitation (select all that apply)<br>Check “All States” or check individual States</label>\n' +
        '    <div class="checkbox">\n' +
        '         <input type="checkbox" name="all-states" value="☐"/><i class="far fa-edit" style="padding-left: 7px; font-size: 15px; display: none"></i>\n' +
        '          <td class="FormText">All States</td>\n' +
        '    </div>\n' +
        '<div class="row">' +
        '    <div class="checkbox col-md-3">' +
        '         <input type="checkbox" name="AL" value="☐"/><i class="far fa-edit" style="padding-left: 7px; font-size: 15px; display: none"></i>' +
        '          <span class="FormText">AL</span>' +
        '    </div>' +
        '    <div class="checkbox col-md-3">' +
        '         <input type="checkbox" name="AK" value="☐"/><i class="far fa-edit" style="padding-left: 7px; font-size: 15px; display: none"></i>' +
        '          <span class="FormText">AK</span>' +
        '    </div>' +
        '    <div class="checkbox col-md-3">' +
        '         <input type="checkbox" name="AZ" value="☐"/><i class="far fa-edit" style="padding-left: 7px; font-size: 15px; display: none"></i>' +
        '          <span class="FormText">AZ</span>' +
        '    </div>' +
        '    <div class="checkbox col-md-3">' +
        '         <input type="checkbox" name="AR" value="☐"/><i class="far fa-edit" style="padding-left: 7px; font-size: 15px; display: none"></i>' +
        '           <span class="FormText">AR</span>' +
        '    </div>' +
        '</div>' +
        '<div class="row">' +
        '    <div class="checkbox col-md-3">\n' +
        '         <input type="checkbox" name="CA" value="☐"/><i class="far fa-edit" style="padding-left: 7px; font-size: 15px; display: none"></i>\n' +
        '           <span class="FormText">CA</span>' +
        '    </div>\n' +
        '    <div class="checkbox col-md-3">\n' +
        '         <input type="checkbox" name="CO" value="☐"/><i class="far fa-edit" style="padding-left: 7px; font-size: 15px; display: none"></i>\n' +
        '          <span class="FormText">CO</span>' +
        '    </div>\n' +
        '    <div class="checkbox col-md-3">\n' +
        '         <input type="checkbox" name="CT" value="☐"/><i class="far fa-edit" style="padding-left: 7px; font-size: 15px; display: none"></i>\n' +
        '          <td class="FormText">CT</td>\n' +
        '    </div>\n' +
        '    <div class="checkbox col-md-3">\n' +
        '         <input type="checkbox" name="DE" value="☐"/><i class="far fa-edit" style="padding-left: 7px; font-size: 15px; display: none"></i>\n' +
        '          <td class="FormText">DE</td>\n' +
        '    </div>\n' +
        '</div>' +
        '<div class="row">' +
        '    <div class="checkbox col-md-3">\n' +
        '         <input type="checkbox" name="DC" value="☐"/><i class="far fa-edit" style="padding-left: 7px; font-size: 15px; display: none"></i>\n' +
        '          <td class="FormText">DC</td>\n' +
        '    </div>\n' +
        '    <div class="checkbox col-md-3">\n' +
        '         <input type="checkbox" name="FL" value="☐"/><i class="far fa-edit" style="padding-left: 7px; font-size: 15px; display: none"></i>\n' +
        '          <td class="FormText">FL</td>\n' +
        '    </div>\n' +
        '    <div class="checkbox col-md-3">\n' +
        '         <input type="checkbox" name="GA" value="☐"/><i class="far fa-edit" style="padding-left: 7px; font-size: 15px; display: none"></i>\n' +
        '          <td class="FormText">GA</td>\n' +
        '    </div>\n' +
        '    <div class="checkbox col-md-3">\n' +
        '         <input type="checkbox" name="HI" value="☐"/><i class="far fa-edit" style="padding-left: 7px; font-size: 15px; display: none"></i>\n' +
        '          <td class="FormText">HI</td>\n' +
        '    </div>\n' +
        '</div>' +
        '<div class="row">' +
        '    <div class="checkbox col-md-3">\n' +
        '         <input type="checkbox" name="HI" value="☐"/><i class="far fa-edit" style="padding-left: 7px; font-size: 15px; display: none"></i>\n' +
        '          <td class="FormText">HI</td>\n' +
        '    </div>\n' +
        '    <div class="checkbox col-md-3">\n' +
        '         <input type="checkbox" name="ID" value="☐"/><i class="far fa-edit" style="padding-left: 7px; font-size: 15px; display: none"></i>\n' +
        '          <td class="FormText">ID</td>\n' +
        '    </div>\n' +
        '    <div class="checkbox col-md-3">\n' +
        '         <input type="checkbox" name="IL" value="☐"/><i class="far fa-edit" style="padding-left: 7px; font-size: 15px; display: none"></i>\n' +
        '          <td class="FormText">IL</td>\n' +
        '    </div>\n' +
        '    <div class="checkbox col-md-3">\n' +
        '         <input type="checkbox" name="IN" value="☐"/><i class="far fa-edit" style="padding-left: 7px; font-size: 15px; display: none"></i>\n' +
        '          <td class="FormText">IN</td>\n' +
        '    </div>\n' +
        '</div>' +
        '<div class="row">' +
        '    <div class="checkbox col-md-3">\n' +
        '         <input type="checkbox" name="IA" value="☐"/><i class="far fa-edit" style="padding-left: 7px; font-size: 15px; display: none"></i>\n' +
        '          <td class="FormText">IA</td>\n' +
        '    </div>\n' +
        '    <div class="checkbox col-md-3">\n' +
        '         <input type="checkbox" name="KS" value="☐"/><i class="far fa-edit" style="padding-left: 7px; font-size: 15px; display: none"></i>\n' +
        '          <td class="FormText">KS</td>\n' +
        '    </div>\n' +
        '    <div class="checkbox col-md-3">\n' +
        '         <input type="checkbox" name="KY" value="☐"/><i class="far fa-edit" style="padding-left: 7px; font-size: 15px; display: none"></i>\n' +
        '          <td class="FormText">KY</td>\n' +
        '    </div>\n' +
        '    <div class="checkbox col-md-3">\n' +
        '         <input type="checkbox" name="LA" value="☐"/><i class="far fa-edit" style="padding-left: 7px; font-size: 15px; display: none"></i>\n' +
        '          <td class="FormText">LA</td>\n' +
        '    </div>\n' +
        '</div>' +
        '<div class="row">' +
        '    <div class="checkbox col-md-3">\n' +
        '         <input type="checkbox" name="ME" value="☐"/><i class="far fa-edit" style="padding-left: 7px; font-size: 15px; display: none"></i>\n' +
        '          <td class="FormText">ME</td>\n' +
        '    </div>\n' +
        '    <div class="checkbox col-md-3">\n' +
        '         <input type="checkbox" name="MD" value="☐"/><i class="far fa-edit" style="padding-left: 7px; font-size: 15px; display: none"></i>\n' +
        '          <td class="FormText">MD</td>\n' +
        '    </div>\n' +
        '    <div class="checkbox col-md-3">\n' +
        '         <input type="checkbox" name="MA" value="☐"/><i class="far fa-edit" style="padding-left: 7px; font-size: 15px; display: none"></i>\n' +
        '          <td class="FormText">MA</td>\n' +
        '    </div>\n' +
        '    <div class="checkbox col-md-3">\n' +
        '         <input type="checkbox" name="MI" value="☐"/><i class="far fa-edit" style="padding-left: 7px; font-size: 15px; display: none"></i>\n' +
        '          <td class="FormText">MI</td>\n' +
        '    </div>\n' +
        '</div>' +
        '<div class="row">' +
        '    <div class="checkbox col-md-3">\n' +
        '         <input type="checkbox" name="MN" value="☐"/><i class="far fa-edit" style="padding-left: 7px; font-size: 15px; display: none"></i>\n' +
        '          <td class="FormText">MN</td>\n' +
        '    </div>\n' +
        '    <div class="checkbox col-md-3">\n' +
        '         <input type="checkbox" name="MS" value="☐"/><i class="far fa-edit" style="padding-left: 7px; font-size: 15px; display: none"></i>\n' +
        '          <td class="FormText">MS</td>\n' +
        '    </div>\n' +
        '    <div class="checkbox col-md-3">\n' +
        '         <input type="checkbox" name="MO" value="☐"/><i class="far fa-edit" style="padding-left: 7px; font-size: 15px; display: none"></i>\n' +
        '          <td class="FormText">MO</td>\n' +
        '    </div>\n' +
        '    <div class="checkbox col-md-3">\n' +
        '         <input type="checkbox" name="MT" value="☐"/><i class="far fa-edit" style="padding-left: 7px; font-size: 15px; display: none"></i>\n' +
        '          <td class="FormText">MT</td>\n' +
        '    </div>\n' +
        '</div>' +
        '<div class="row">' +
        '    <div class="checkbox col-md-3">\n' +
        '         <input type="checkbox" name="NE" value="☐"/><i class="far fa-edit" style="padding-left: 7px; font-size: 15px; display: none"></i>\n' +
        '          <td class="FormText">NE</td>\n' +
        '    </div>\n' +
        '    <div class="checkbox col-md-3">\n' +
        '         <input type="checkbox" name="NV" value="☐"/><i class="far fa-edit" style="padding-left: 7px; font-size: 15px; display: none"></i>\n' +
        '          <td class="FormText">NV</td>\n' +
        '    </div>\n' +
        '    <div class="checkbox col-md-3">\n' +
        '         <input type="checkbox" name="NH" value="☐"/><i class="far fa-edit" style="padding-left: 7px; font-size: 15px; display: none"></i>\n' +
        '          <td class="FormText">NH</td>\n' +
        '    </div>\n' +
        '    <div class="checkbox col-md-3">\n' +
        '         <input type="checkbox" name="NJ" value="☐"/><i class="far fa-edit" style="padding-left: 7px; font-size: 15px; display: none"></i>\n' +
        '          <td class="FormText">NJ</td>\n' +
        '    </div>\n' +

        '</div>' +
        '<div class="row">' +
        '    <div class="checkbox col-md-3">\n' +
        '         <input type="checkbox" name="NM" value="☐"/><i class="far fa-edit" style="padding-left: 7px; font-size: 15px; display: none"></i>\n' +
        '          <td class="FormText">NM</td>\n' +
        '    </div>\n' +
        '    <div class="checkbox col-md-3">\n' +
        '         <input type="checkbox" name="NY" value="☐"/><i class="far fa-edit" style="padding-left: 7px; font-size: 15px; display: none"></i>\n' +
        '          <td class="FormText">NY</td>\n' +
        '    </div>\n' +
        '    <div class="checkbox col-md-3">\n' +
        '         <input type="checkbox" name="NC" value="☐"/><i class="far fa-edit" style="padding-left: 7px; font-size: 15px; display: none"></i>\n' +
        '          <td class="FormText">NC</td>\n' +
        '    </div>\n' +
        '    <div class="checkbox col-md-3">\n' +
        '         <input type="checkbox" name="ND" value="☐"/><i class="far fa-edit" style="padding-left: 7px; font-size: 15px; display: none"></i>\n' +
        '          <td class="FormText">ND</td>\n' +
        '    </div>\n' +
        '</div>' +
        '<div class="row">' +
        '    <div class="checkbox col-md-3">\n' +
        '         <input type="checkbox" name="OH" value="☐"/><i class="far fa-edit" style="padding-left: 7px; font-size: 15px; display: none"></i>\n' +
        '          <td class="FormText">OH</td>\n' +
        '    </div>\n' +
        '    <div class="checkbox col-md-3">\n' +
        '         <input type="checkbox" name="OK" value="☐"/><i class="far fa-edit" style="padding-left: 7px; font-size: 15px; display: none"></i>\n' +
        '          <td class="FormText">OK</td>\n' +
        '    </div>\n' +
        '    <div class="checkbox col-md-3">\n' +
        '         <input type="checkbox" name="OR" value="☐"/><i class="far fa-edit" style="padding-left: 7px; font-size: 15px; display: none"></i>\n' +
        '          <td class="FormText">OR</td>\n' +
        '    </div>\n' +
        '    <div class="checkbox col-md-3">\n' +
        '         <input type="checkbox" name="PA" value="☐"/><i class="far fa-edit" style="padding-left: 7px; font-size: 15px; display: none"></i>\n' +
        '          <td class="FormText">PA</td>\n' +
        '    </div>\n' +
        '</div>' +
        '<div class="row">' +
        '    <div class="checkbox col-md-3">\n' +
        '         <input type="checkbox" name="RI" value="☐"/><i class="far fa-edit" style="padding-left: 7px; font-size: 15px; display: none"></i>\n' +
        '          <td class="FormText">RI</td>\n' +
        '    </div>\n' +
        '    <div class="checkbox col-md-3">\n' +
        '         <input type="checkbox" name="SC" value="☐"/><i class="far fa-edit" style="padding-left: 7px; font-size: 15px; display: none"></i>\n' +
        '          <td class="FormText">SC</td>\n' +
        '    </div>\n' +
        '    <div class="checkbox col-md-3">\n' +
        '         <input type="checkbox" name="SD" value="☐"/><i class="far fa-edit" style="padding-left: 7px; font-size: 15px; display: none"></i>\n' +
        '          <td class="FormText">SD</td>\n' +
        '    </div>\n' +
        '    <div class="checkbox col-md-3">\n' +
        '         <input type="checkbox" name="TN" value="☐"/><i class="far fa-edit" style="padding-left: 7px; font-size: 15px; display: none"></i>\n' +
        '          <td class="FormText">TN</td>\n' +
        '    </div>\n' +
        '</div>' +
        '<div class="row">' +
        '    <div class="checkbox col-md-3">\n' +
        '         <input type="checkbox" name="TX" value="☐"/><i class="far fa-edit" style="padding-left: 7px; font-size: 15px; display: none"></i>\n' +
        '          <td class="FormText">TX</td>\n' +
        '    </div>\n' +
        '    <div class="checkbox col-md-3">\n' +
        '         <input type="checkbox" name="UT" value="☐"/><i class="far fa-edit" style="padding-left: 7px; font-size: 15px; display: none"></i>\n' +
        '          <td class="FormText">UT</td>\n' +
        '    </div>\n' +
        '    <div class="checkbox col-md-3">\n' +
        '         <input type="checkbox" name="VT" value="☐"/><i class="far fa-edit" style="padding-left: 7px; font-size: 15px; display: none"></i>\n' +
        '          <td class="FormText">VT</td>\n' +
        '    </div>\n' +
        '    <div class="checkbox col-md-3">\n' +
        '         <input type="checkbox" name="VA" value="☐"/><i class="far fa-edit" style="padding-left: 7px; font-size: 15px; display: none"></i>\n' +
        '          <td class="FormText">VA</td>\n' +
        '    </div>\n' +
        '</div>' +
        '<div class="row">' +
        '    <div class="checkbox col-md-3">\n' +
        '         <input type="checkbox" name="WA" value="☐"/><i class="far fa-edit" style="padding-left: 7px; font-size: 15px; display: none"></i>\n' +
        '          <td class="FormText">WA</td>\n' +
        '    </div>\n' +
        '    <div class="checkbox col-md-3">\n' +
        '         <input type="checkbox" name="WV" value="☐"/><i class="far fa-edit" style="padding-left: 7px; font-size: 15px; display: none"></i>\n' +
        '          <td class="FormText">WV</td>\n' +
        '    </div>\n' +
        '    <div class="checkbox col-md-3">\n' +
        '         <input type="checkbox" name="WI" value="☐"/><i class="far fa-edit" style="padding-left: 7px; font-size: 15px; display: none"></i>\n' +
        '          <td class="FormText">WI</td>\n' +
        '    </div>\n' +
        '    <div class="checkbox col-md-3">\n' +
        '         <input type="checkbox" name="WY" value="☐"/><i class="far fa-edit" style="padding-left: 7px; font-size: 15px; display: none"></i>\n' +
        '          <td class="FormText">WY</td>\n' +
        '    </div>\n' +
        '    <div class="checkbox col-md-3">\n' +
        '         <input type="checkbox" name="PR" value="☐"/><i class="far fa-edit" style="padding-left: 7px; font-size: 15px; display: none"></i>\n' +
        '          <td class="FormText">PR</td>\n' +
        '    </div>\n' +
        '</div>' +
        '<br>\n' +
        '    <div class="checkbox col-md-12">\n' +
        '         <input type="checkbox" name="foreign" value="☐"/><i class="far fa-edit" style="padding-left: 7px; font-size: 15px; display: none"></i>\n' +
        '          <td class="FormText">Foreign/non-US</td>\n' +
        '    </div>\n' +
        '<br>\n' ;

    tableTwoForm += '<button type="button" id="add-recipient-row" class="btn btn-primary pull-right sidebar-btn" style="margin-left: 5px;">Confirm</button>\n';
    tableTwoForm += '<button type="button" id="discard-row" class="btn btn-primary pull-right sidebar-btn" style="margin-left: 5px;">Discard</button>\n' +
        '<form>\n';

    $('.add-table-row-div').html(tableTwoForm);
});

$('body').on('click', '#add-recipient-row', function (e) {
    let data = [];


    var inputs = $('form#table-recipient').serializeArray();
    $.each(inputs, function (i, field) {
        data[field.name] = field.value;
    });
    data['stateOrCountryDescription'] = $('#recipientStateOrCountryData option:selected').text();
    generateTable(data);
});


function generateTable(data) {
    if (data['none'] == undefined) {
        data['none'] = '☐';
    } else {
        data['none'] = '☒';
    }
    if (data['none-broker'] == undefined) {
        data['none-broker'] = '☐';
    } else {
        data['none-broker'] = '☒';
    }
    if (data['none-crd'] == undefined) {
        data['none-crd'] = '☐';
    } else {
        data['none-crd'] = '☒';
    }
    if (data['all-states'] == undefined) {
        data['all-states'] = '☐';
    } else {
        data['all-states'] = '☒';
    }
    if (data['foreign'] == undefined) {
        data['foreign'] = '☐';
    } else {
        data['foreign'] = '☒';
    }
    if (data['AL'] == undefined) {
        data['AL'] = '☐';
    } else {
        data['AL'] = '☒';
    }
    if (data['AK'] == undefined) {
        data['AK'] = '☐';
    } else {
        data['AK'] = '☒';
    }
    if (data['AZ'] == undefined) {
        data['AZ'] = '☐';
    } else {
        data['AZ'] = '☒';
    }
    if (data['AR'] == undefined) {
        data['AR'] = '☐';
    } else {
        data['AR'] = '☒';
    }
    if (data['CA'] == undefined) {
        data['CA'] = '☐';
    } else {
        data['CA'] = '☒';
    }
    if (data['CO'] == undefined) {
        data['CO'] = '☐';
    } else {
        data['CO'] = '☒';
    }
    if (data['CT'] == undefined) {
        data['CT'] = '☐';
    } else {
        data['CT'] = '☒';
    }
    if (data['DE'] == undefined) {
        data['DE'] = '☐';
    } else {
        data['DE'] = '☒';
    }
    if (data['DC'] == undefined) {
        data['DC'] = '☐';
    } else {
        data['DC'] = '☒';
    }
    if (data['FL'] == undefined) {
        data['FL'] = '☐';
    } else {
        data['FL'] = '☒';
    }
    if (data['GA'] == undefined) {
        data['GA'] = '☐';
    } else {
        data['GA'] = '☒';
    }
    if (data['HI'] == undefined) {
        data['HI'] = '☐';
    } else {
        data['HI'] = '☒';
    }

    if (data['ID'] == undefined) {
        data['ID'] = '☐';
    } else {
        data['ID'] = '☒';
    }
    if (data['IL'] == undefined) {
        data['IL'] = '☐';
    } else {
        data['IL'] = '☒';
    }
    if (data['IN'] == undefined) {
        data['IN'] = '☐';
    } else {
        data['IN'] = '☒';
    }
    if (data['IA'] == undefined) {
        data['IA'] = '☐';
    } else {
        data['IA'] = '☒';
    }
    if (data['KS'] == undefined) {
        data['KS'] = '☐';
    } else {
        data['KS'] = '☒';
    }
    if (data['KY'] == undefined) {
        data['KY'] = '☐';
    } else {
        data['KY'] = '☒';
    }

    if (data['LA'] == undefined) {
        data['LA'] = '☐';
    } else {
        data['LA'] = '☒';
    }
    if (data['ME'] == undefined) {
        data['ME'] = '☐';
    } else {
        data['ME'] = '☒';
    }
    if (data['MD'] == undefined) {
        data['MD'] = '☐';
    } else {
        data['MD'] = '☒';
    }
    if (data['MA'] == undefined) {
        data['MA'] = '☐';
    } else {
        data['MA'] = '☒';
    }

    if (data['MI'] == undefined) {
        data['MI'] = '☐';
    } else {
        data['MI'] = '☒';
    }

    if (data['MN'] == undefined) {
        data['MN'] = '☐';
    } else {
        data['MN'] = '☒';
    }
    if (data['MS'] == undefined) {
        data['MS'] = '☐';
    } else {
        data['MS'] = '☒';
    }
    if (data['MO'] == undefined) {
        data['MO'] = '☐';
    } else {
        data['MO'] = '☒';
    }
    if (data['MT'] == undefined) {
        data['MT'] = '☐';
    } else {
        data['MT'] = '☒';
    }
    if (data['NE'] == undefined) {
        data['NE'] = '☐';
    } else {
        data['NE'] = '☒';
    }
    if (data['NV'] == undefined) {
        data['NV'] = '☐';
    } else {
        data['NV'] = '☒';
    }

    if (data['NH'] == undefined) {
        data['NH'] = '☐';
    } else {
        data['NH'] = '☒';
    }
    if (data['NJ'] == undefined) {
        data['NJ'] = '☐';
    } else {
        data['NJ'] = '☒';
    }
    if (data['NM'] == undefined) {
        data['NM'] = '☐';
    } else {
        data['NM'] = '☒';
    }
    if (data['NY'] == undefined) {
        data['NY'] = '☐';
    } else {
        data['NY'] = '☒';
    }
    if (data['NC'] == undefined) {
        data['NC'] = '☐';
    } else {
        data['NC'] = '☒';
    }
    if (data['ND'] == undefined) {
        data['ND'] = '☐';
    } else {
        data['ND'] = '☒';
    }

    if (data['OH'] == undefined) {
        data['OH'] = '☐';
    } else {
        data['OH'] = '☒';
    }
    if (data['OK'] == undefined) {
        data['OK'] = '☐';
    } else {
        data['OK'] = '☒';
    }
    if (data['OR'] == undefined) {
        data['OR'] = '☐';
    } else {
        data['OR'] = '☒';
    }
    if (data['PA'] == undefined) {
        data['PA'] = '☐';
    } else {
        data['PA'] = '☒';
    }
    if (data['RI'] == undefined) {
        data['RI'] = '☐';
    } else {
        data['RI'] = '☒';
    }
    if (data['SC'] == undefined) {
        data['SC'] = '☐';
    } else {
        data['SC'] = '☒';
    }

    if (data['SD'] == undefined) {
        data['SD'] = '☐';
    } else {
        data['SD'] = '☒';
    }
    if (data['TN'] == undefined) {
        data['TN'] = '☐';
    } else {
        data['TN'] = '☒';
    }
    if (data['TX'] == undefined) {
        data['TX'] = '☐';
    } else {
        data['TX'] = '☒';
    }
    if (data['UT'] == undefined) {
        data['UT'] = '☐';
    } else {
        data['UT'] = '☒';
    }
    if (data['VT'] == undefined) {
        data['VT'] = '☐';
    } else {
        data['VT'] = '☒';
    }
    if (data['VA'] == undefined) {
        data['VA'] = '☐';
    } else {
        data['VA'] = '☒';
    }

    if (data['WA'] == undefined) {
        data['WA'] = '☐';
    } else {
        data['WA'] = '☒';
    }
    if (data['WV'] == undefined) {
        data['WV'] = '☐';
    } else {
        data['WV'] = '☒';
    }
    if (data['WI'] == undefined) {
        data['WI'] = '☐';
    } else {
        data['WI'] = '☒';
    }
    if (data['WY'] == undefined) {
        data['WY'] = '☐';
    } else {
        data['WY'] = '☒';
    }
    if (data['PR'] == undefined) {
        data['PR'] = '☐';
    } else {
        data['PR'] = '☒';
    }



    var allStates_length = $('.allStates').length+1;
    let salesCompensation = '<div class="recipient"  id="recipient-'+allStates_length+'"><table summary="Sales Compensation List" width="90%">\n' +
        ' <tbody>\n' +
        ' <tr>\n' +
        ' <td class="FormText">Recipient</td>\n' +
        ' <td><table border="0" summary="Table with single CheckBox"><tbody><tr>\n' +
        ' <td class="FormText">Recipient CRD Number</td>\n' +
        ' <td  class="FormData filing-data"  data-name="none">' + data['none'] + '</td>\n' +
        ' <td class="FormText">None</td>\n' +
        ' </tr></tbody></table></td>\n' +
        '</tr>\n' +
        '<tr>\n' +
        '<td class="FormData filing-data" data-name="recipient-name">' + data['recipient-name'] + '</td>\n' +
        '<td class="FormData  filing-data" data-name="crd-number">' + data['crd-number'] + '</td>\n' +
        ' </tr>\n' +
        ' <tr>\n' +
        '<td><table border="0" summary="Table with single CheckBox"><tbody><tr>\n' +
        '<td class="FormText">(Associated) Broker or Dealer</td>\n' +
        '<td  class="FormData filing-data"  data-name="none-broker">' + data['none-broker'] + '</td>\n' +
        '<td class="FormText">None</td>\n' +
        '</tr></tbody></table></td>\n' +
        '<td><table border="0" summary="Table with single CheckBox"><tbody><tr>\n' +
        '<td class="FormText">(Associated) Broker or Dealer CRD Number</td>\n' +
        '<td  class="FormData filing-data"  data-name="none-crd">' + data['none-crd'] + '</td>\n' +
        '<td class="FormText">None</td>\n' +
        ' </tr></tbody></table></td>\n' +
        ' </tr>\n' +
        '<tr>\n' +
        '<td class="FormData filing-data"  data-name="broker-dealer">' + data['broker-dealer'] + '</td>\n' +
        '<td class="FormData filing-data"  data-name="broker-dealer-crd">' + data['broker-dealer-crd'] + '</td>\n' +
        ' </tr>\n' +
        '<tr>\n' +
        '<th class="FormText">Street Address 1</th>\n' +
        ' <th class="FormText">Street Address 2</th>\n' +
        '</tr>\n' +
        '<tr>\n' +
        '<td class="FormData filing-data"  data-name="address1">' + data['address1'] + '</td>\n' +
        '<td class="FormData filing-data"  data-name="address2">' + data['address2'] + '</td>\n' +
        ' </tr>\n' +
        '<tr>\n' +
        '<th class="FormText">City</th>\n' +
        ' <th class="FormText">State/Province/Country</th>\n' +
        '<th class="FormText">ZIP/PostalCode</th>\n' +
        '</tr>\n' +
        '<tr>\n' +
        '<td class="FormData filing-data" data-name="city">' + data['city'] + '</td>\n' +
        '<td class="FormData filing-data" data-name="recipientStateOrCountry" data-code="stateOrCountryDescription" data-code-description="'+ data['recipientStateOrCountry']+ '">'+data['stateOrCountryDescription']+'</td>\n' +
        '<td class="FormData filing-data"  data-name="zip">' + data['zip'] + '</td>\n' +
        '</tr>\n' +
        '<tr>\n' +
        '<td><table border="0" summary="Table with single CheckBox"><tbody>\n' +
        '<tr>\n' +
        '<td class="FormText">State(s) of Solicitation (select all that apply)<br>Check “All States” or check individual States</td>\n' +
        '<td  class="FormData filing-data"  data-name="all-states">' + data['all-states'] + '</td>\n' +
        '<td class="FormText">All States</td>\n' +
        '</tr>\n' +
        '</tbody></table></td>\n' +
        '<tr>\n' +
        '</tr>\n' +
        '<tr>\n' +
        '<table summary="checkboxes">\n' +
        '<tbody>\n' +
        '<div class="allStates">\n' +
        '<tr class="sales-compensation-table">\n' +
        '<td  class="FormData filing-data"  data-name="AL" data-parent="states" data-description="ALABAMA">' + data['AL'] +  '</td>\n' +
        '<td class="FormText">AL</td>\n' +
        '<td  class="FormData filing-data"  data-name="AK" data-parent="states" data-description="ALASKA">' + data['AK'] +  '</td>\n' +
        '<td class="FormText">AK</td>\n' +
        '<td  class="FormData filing-data"  data-name="AZ" data-parent="states" data-description="ARIZONA">' + data['AZ'] +  '</td>\n' +
        '<td class="FormText">AZ</td>\n' +
        '<td  class="FormData filing-data"  data-name="AR" data-parent="states" data-description="ARKANSAS">' + data['AR'] +  '</td>\n' +
        '<td class="FormText">AR</td>\n' +
        '<td  class="FormData filing-data"  data-name="CA" data-parent="states" data-description="CALIFORNIA">' + data['CA'] +  '</td>\n' +
        '<td class="FormText">CA</td>\n' +
        '<td  class="FormData filing-data"  data-name="CO" data-parent="states" data-description="COLORADO">' + data['CO'] +  '</td>\n' +
        '<td class="FormText">CO</td>\n' +
        '<td  class="FormData filing-data"  data-name="CT" data-parent="states" data-description="CONNECTICUT">' + data['CT'] +  '</td>\n' +
        '<td class="FormText">CT</td>\n' +
        '<td  class="FormData filing-data"  data-name="DE" data-parent="states" data-description="DELAWARE">' + data['DE'] +  '</td>\n' +
        '<td class="FormText">DE</td>\n' +
        '<td  class="FormData filing-data"  data-name="DC" data-parent="states" data-description="DISTRICT OF COLUMBIA">' + data['DC'] +  '</td>\n' +
        '<td class="FormText">DC</td>\n' +
        '<td  class="FormData filing-data"  data-name="FL" data-parent="states" data-description="FLORIDA">' + data['FL'] +  '</td>\n' +
        '<td class="FormText">FL</td>\n' +
        '<td  class="FormData filing-data"  data-name="GA" data-parent="states" data-description="GEORGIA">' + data['GA'] +  '</td>\n' +
        '<td class="FormText">GA</td>\n' +
        '<td  class="FormData filing-data"  data-name="HI" data-parent="states" data-description="HAWAII">' + data['HI'] +  '</td>\n' +
        '<td class="FormText">HI</td>\n' +
        '<td  class="FormData filing-data"  data-name="ID" data-parent="states" data-description="IDAHO">' + data['ID'] +  '</td>\n' +
        '<td class="FormText">ID</td>\n' +
        '</tr>\n' +
        '<tr class="sales-compensation-table">\n' +
        '<td  class="FormData filing-data"  data-name="IL" data-parent="states" data-description="ILLINOIS">' + data['IL'] +  '</td>\n' +
        '<td class="FormText">IL</td>\n' +
        '<td  class="FormData filing-data"  data-name="IN" data-parent="states" data-description="INDIANA">' + data['IN'] +  '</td>\n' +
        '<td class="FormText">IN</td>\n' +
        '<td  class="FormData filing-data"  data-name="IA" data-parent="states" data-description="IOWA">' + data['IA'] +  '</td>\n' +
        '<td class="FormText">IA</td>\n' +
        '<td  class="FormData filing-data"  data-name="KS" data-parent="states" data-description="KANSAS">' + data['KS'] +  '</td>\n' +
        '<td class="FormText">KS</td>\n' +
        '<td  class="FormData filing-data"  data-name="KY" data-parent="states" data-description="KENTUCKY">' + data['KY'] +  '</td>\n' +
        '<td class="FormText">KY</td>\n' +
        '<td  class="FormData filing-data"  data-name="LA" data-parent="states" data-description="LOUISIANA">' + data['LA'] +  '</td>\n' +
        '<td class="FormText">LA</td>\n' +
        '<td  class="FormData filing-data"  data-name="ME" data-parent="states" data-description="MAINE">' + data['ME'] +  '</td>\n' +
        '<td class="FormText">ME</td>\n' +
        '<td  class="FormData filing-data"  data-name="MD" data-parent="states" data-description="MARYLAND">' + data['MD'] +  '</td>\n' +
        '<td class="FormText">MD</td>\n' +
        '<td  class="FormData filing-data"  data-name="MA" data-parent="states" data-description="MASSACHUSETTS">' + data['MA'] +  '</td>\n' +
        '<td class="FormText">MA</td>\n' +
        '<td  class="FormData filing-data"  data-name="MI" data-parent="states" data-description="MICHIGAN">' + data['MI'] +  '</td>\n' +
        '<td class="FormText">MI</td>\n' +
        '<td  class="FormData filing-data"  data-name="MN" data-parent="states" data-description="MINNESSOTA">' + data['MN'] +  '</td>\n' +
        '<td class="FormText">MN</td>\n' +
        '<td  class="FormData filing-data"  data-name="MS" data-parent="states" data-description="MISSISSIPPI">' + data['MS'] +  '</td>\n' +
        '<td class="FormText">MS</td>\n' +
        '<td  class="FormData filing-data"  data-name="MO" data-parent="states" data-description="MISSOURI">' + data['MO'] +  '</td>\n' +
        '<td class="FormText">MO</td>\n' +
        '</tr>\n' +
        '<tr class="sales-compensation-table">\n' +
        '<td  class="FormData filing-data"  data-name="MT" data-parent="states" data-description="MONTANA">' + data['MT'] +  '</td>\n' +
        '<td class="FormText">MT</td>\n' +
        '<td  class="FormData filing-data"  data-name="NE" data-parent="states" data-description="NEBRASKA">' + data['NE'] +  '</td>\n' +
        '<td class="FormText">NE</td>\n' +
        '<td  class="FormData filing-data"  data-name="NV" data-parent="states" data-description="NEVADA">' + data['NV'] +  '</td>\n' +
        '<td class="FormText">NV</td>\n' +
        '<td  class="FormData filing-data"  data-name="NH" data-parent="states" data-description="NEW HAMPSHIRE">' + data['NH'] +  '</td>\n' +
        '<td class="FormText">NH</td>\n' +
        '<td  class="FormData filing-data"  data-name="NJ" data-parent="states" data-description="NEW JERSEY">' + data['NJ'] +  '</td>\n' +
        '<td class="FormText">NJ</td>\n' +
        '<td  class="FormData filing-data"  data-name="NM" data-parent="states" data-description="NEW MEXICO">' + data['NM'] +  '</td>\n' +
        '<td class="FormText">NM</td>\n' +
        '<td  class="FormData filing-data"  data-name="NY" data-parent="states" data-description="NEW YORK">' + data['NY'] +  '</td>\n' +
        '<td class="FormText">NY</td>\n' +
        '<td  class="FormData filing-data"  data-name="NC" data-parent="states" data-description="NORTH CAROLINE">' + data['NC'] +  '</td>\n' +
        '<td class="FormText">NC</td>\n' +
        '<td  class="FormData filing-data"  data-name="ND" data-parent="states" data-description="NORTH DAKOTA">' + data['ND'] +  '</td>\n' +
        '<td class="FormText">ND</td>\n' +
        '<td  class="FormData filing-data"  data-name="OH" data-parent="states" data-description="OHIO">' + data['OH'] +  '</td>\n' +
        '<td class="FormText">OH</td>\n' +
        '<td  class="FormData filing-data"  data-name="OK" data-parent="states" data-description="OKLAHOMA">' + data['OK'] +  '</td>\n' +
        '<td class="FormText">OK</td>\n' +
        '<td  class="FormData filing-data"  data-name="OR" data-parent="states" data-description="OREGON">' + data['OR'] +  '</td>\n' +
        '<td class="FormText">OR</td>\n' +
        '<td  class="FormData filing-data"  data-name="PA" data-parent="states" data-description="PENNSYLVANIA">' + data['PA'] +  '</td>\n' +
        '<td class="FormText">PA</td>\n' +
        '</tr>\n' +
        '<tr class="sales-compensation-table">\n' +
        '<td  class="FormData filing-data"  data-name="RI" data-parent="states" data-description="RHODE ISLAND">' + data['RI'] +  '</td>\n' +
        '<td class="FormText">RI</td>\n' +
        '<td  class="FormData filing-data"  data-name="SC" data-parent="states" data-description="SOUTH CAROLINA">' + data['SC'] +  '</td>\n' +
        '<td class="FormText">SC</td>\n' +
        '<td  class="FormData filing-data"  data-name="SD" data-parent="states" data-description="SOUTH DAKOTA">' + data['SD'] +  '</td>\n' +
        '<td class="FormText">SD</td>\n' +
        '<td  class="FormData filing-data"  data-name="TN" data-parent="states" data-description="TENNESSEE">' + data['TN'] +  '</td>\n' +
        '<td class="FormText">TN</td>\n' +
        '<td  class="FormData filing-data"  data-name="TX" data-parent="states" data-description="TEXAS">' + data['TX'] +  '</td>\n' +
        '<td class="FormText">TX</td>\n' +
        '<td  class="FormData filing-data"  data-name="UT" data-parent="states" data-description="UTAH">' + data['UT'] +  '</td>\n' +
        '<td class="FormText">UT</td>\n' +
        '<td  class="FormData filing-data"  data-name="VT" data-parent="states" data-description="VERMONT">' + data['VT'] +  '</td>\n' +
        '<td class="FormText">VT</td>\n' +
        '<td  class="FormData filing-data"  data-name="VA" data-parent="states" data-description="VIRGINIA">' + data['VA'] +  '</td>\n' +
        '<td class="FormText">VA</td>\n' +
        '<td  class="FormData filing-data"  data-name="WA" data-parent="states" data-description="WASHINGTON">' + data['WA'] +  '</td>\n' +
        '<td class="FormText">WA</td>\n' +
        '<td  class="FormData filing-data"  data-name="WV" data-parent="states" data-description="WEST VIRGINIA">' + data['WV'] +  '</td>\n' +
        '<td class="FormText">WV</td>\n' +
        '<td  class="FormData filing-data"  data-name="WI" data-parent="states" data-description="WISCONSIN">' + data['WI'] +  '</td>\n' +
        '<td class="FormText">WI</td>\n' +
        '<td  class="FormData filing-data"  data-name="WY" data-parent="states" data-description="WYOMING">' + data['WY'] +  '</td>\n' +
        '<td class="FormText">WY</td>\n' +
        '<td  class="FormData filing-data"  data-name="PR" data-parent="states" data-description="PUERTO RICO">' + data['PR'] +  '</td>\n' +
        '<td class="FormText">PR</td>\n' +
        '</tr>\n' +
        '</tr>\n' +
         '</div>\n' +
        '</tbody>\n' +
        '</table>\n' +
        '<tr>\n' +
        '<td><table border="0" summary="Table with single CheckBox"><tbody>\n' +
        '<tr>\n' +
        '<td  class="FormData filing-data"  data-name="foreign">' + data['foreign'] + '</td>\n' +
        '<td class="FormText">Foreign/non-US</td>\n' +
        '</tr>\n' +
        '</tbody></table></td>\n' +
        '</tr>\n' +
        '</table>\n' +
        '<div class="list-of-states" id="list-of-states-'+allStates_length+'"style="display:none;">\n' +
        '<span class="FormData">\n' +
        '<ul  style="list-style: none;">\n' +
        '</ul>\n' +
        '<span>\n' +
        '</div>\n' +
        '        <td>\n' +
        '           <button type="button" class="btn btn-danger btn-sm delete-recipient">Delete Recipient</button>\n' +
        '        </td>\n' +
        '<hr>\n' +
        '</div>';

    $('.sales-compensation').append(salesCompensation);
    $('.add-table-row-div').html('');
}

$('body').on('click', '.delete-recipient', function () {
    $(this).closest('.recipient').remove();
});

// ADD ISSUER ------------------------------------------------------------------------------------------------------------------------------


$('#add-issuer').on('click', function () {
    $('body').removeClass('brand-minimized sidebar-minimized');
    let tableTwoForm = '<form id="table-issuer">\n' +
        '    <label>Issuer Information</label>\n' +
        '    <div class="form-group">\n' +
        '        <input style="color: #000" class="form-control" name="issuer" type="text" placeholder="Issuer"/>\n' +
        '    </div>\n' +
        '    <div class="form-group">\n' +
        '        <input style="color: #000" class="form-control" name="signature" type="text" placeholder="Signature"/>\n' +
        '    </div>\n' +
        '    <div class="form-group">\n' +
        '        <input style="color: #000" class="form-control" name="name-of-signer" type="text" placeholder="Name of Signer"/>\n' +
        '    </div>\n' +
        '    <div class="form-group">\n' +
        '        <input style="color: #000" class="form-control" name="title" type="text" placeholder="Title"/>\n' +
        '    </div>\n' +
        '    <div class="form-group">\n' +
        '        <input style="color: #000" class="form-control" name="date" type="text" placeholder="Date"/>\n' +
        '    </div>\n';

    tableTwoForm += '<button type="button" id="add-issuer-row" class="btn btn-primary pull-right sidebar-btn" style="margin-left: 5px;">Confirm</button>\n';
    tableTwoForm += '<button type="button" id="discard-row" class="btn btn-primary pull-right sidebar-btn" style="margin-left: 5px;">Discard</button>\n' +
        '<form>\n';

    $('.add-table-row-div').html(tableTwoForm);
});

$('body').on('click', '#add-issuer-row', function (e) {
    let data = [];
    var inputs = $('form#table-issuer').serializeArray();
    $.each(inputs, function (i, field) {
        data[field.name] = field.value;

    });
    generateTableIRow(data);
});

function generateTableIRow(data) {

    let issuer = '<tr class="signature">\n' +
        '            <td class="FormData filing-data" data-name="issuer">' + data['issuer'] + '</td>\n' +
        '            <td class="FormData filing-data" data-name="signature">' + data['signature'] + '</td>\n' +
        '            <td class="FormData filing-data" data-name="name-of-signer">' + data['name-of-signer'] + '</td>\n' +
        '            <td class="FormData filing-data" data-name="title">' + data['title'] + '</td>\n' +
        '            <td class="FormData filing-data" data-name="date">' + data['date'] + '</td>\n' +
        '            <td class="delete-cursor" ><a style="cursor: pointer;" class="delete-issuer-person"><i class="fa fa-times" aria-hidden="true"></i></a>\n</td>' +
        '</tr>';

    $('.issuer').append(issuer);
    $('.add-table-row-div').html('');
}

$('body').on('click', '.delete-issuer-person', function () {
    $(this).parents("tr").remove();
});


function generateFormFilings($button) {
    var data = {};

    data['general-data'] = {};
    $('.general-data .filing-data').each(function() {
        if ($(this).text() === "☒"){
            if(typeof $(this).data('parent') !== 'undefined'){
                if(typeof data['general-data'][$(this).data('parent') === 'undefined']){
                data['general-data'][$(this).data('parent')] = {};
                }
                data['general-data'][$(this).data('parent')][$(this).data('name')] = '1';
            } else {
                data['general-data'][$(this).data('name')] = '1';
            }
        } else if ($(this).text() === "☐"){

        } else {
            data['general-data'][$(this).data('name')] = $(this).text();
        }
    });




    data['contact-informations'] = {};
    $('.contact-informations .filing-data').each(function () {
            if ($(this).data('code')) {
                data['contact-informations'][$(this).data('name')] = $(this).data('code-description');
                data['contact-informations'][$(this).data('code')] = $(this).text();
            } else {
                data['contact-informations'][$(this).data('name')] = $(this).text();
            }
        });




    data['related-persons'] = {};
    $('.related-person').each(function () {
        let i = Object.keys(data['related-persons']).length;
        data['related-persons'][i] = {};
        $(this).find('.filing-data').each(function () {
            if ($(this).text() === "☒") {
                data['related-persons'][i][$(this).data('name')] = '1';
            } else if ($(this).text() === "☐") {
                data['related-persons'][i][$(this).data('name')] = '0';
            } else if ($(this).data('code')) {
                data['related-persons'][i][$(this).data('name')] = $(this).data('code-description');
                data['related-persons'][i][$(this).data('code')] = $(this).text();
            } else {
                data['related-persons'][i][$(this).data('name')] = $(this).text();
            }
            // data['related-persons'][i]['stateOrCountryDescription'] = $('#relatedPersonStateOrCountry option:selected').text();
        });
    });

    data['industry-group'] = {};
    $('.industry-group .filing-data').each(function () {
        if ($(this).text() === "☒") {
            if (typeof $(this).data('parent') !== 'undefined') {
                if (typeof data['industry-group'][$(this).data('parent') === 'undefined']) {
                    data['industry-group'][$(this).data('parent')] = {};
                }
                data['industry-group'][$(this).data('parent')][$(this).data('name')] = '1';
            } else {
                data['industry-group'][$(this).data('name')] = '1';
            }
        } else if ($(this).text() === "☐") {

        } else {

        }
    });


    data['issuer-size'] = {};
    $('.issuer-size .filing-data').each(function () {
        if ($(this).text() === "☒") {
            if (typeof $(this).data('parent') !== 'undefined') {
                if (typeof data['issuer-size'][$(this).data('parent') === 'undefined']) {
                    data['issuer-size'][$(this).data('parent')] = {};
                }
                data['issuer-size'][$(this).data('parent')][$(this).data('name')] = '1';
            } else {
                data['issuer-size'][$(this).data('name')] = '1';
            }
        } else if ($(this).text() === "☐") {

        } else {

        }
    });


    data['federal-exemption'] = {};
    $('.federal-exemption .filing-data').each(function () {
        if ($(this).text() === "☒") {
            if (typeof $(this).data('parent') !== 'undefined') {
                if (typeof data['federal-exemption'][$(this).data('parent') === 'undefined']) {
                    data['federal-exemption'][$(this).data('parent')] = {};
                }
                data['federal-exemption'][$(this).data('parent')][$(this).data('name')] = '1';
            } else {
                data['federal-exemption'][$(this).data('name')] = '1';
            }
        } else if ($(this).text() === "☐") {

        } else {

        }
    });



    data['filing-type'] = {};
    $('.filing-type .filing-data').each(function() {

        if ($(this).text() === "☒"){
            if(typeof $(this).data('parent') !== 'undefined'){
                if(typeof data['filing-type'][$(this).data('parent') === 'undefined']){
                data['filing-type'][$(this).data('parent')] = {};
                }
                data['filing-type'][$(this).data('parent')][$(this).data('name')] = '1';
            } else {
                data['filing-type'][$(this).data('name')] = '1';
            }
        } else if ($(this).text() === "☐") {

        } else {
            data['filing-type'][$(this).data('name')] = $(this).text();
        }
    });


    data['offering'] = {};
    $('.offering .filing-data').each(function () {

        if ($(this).text() === "☒") {
            if (typeof $(this).data('parent') !== 'undefined') {
                if (typeof data['offering'][$(this).data('parent') === 'undefined']) {
                    data['offering'][$(this).data('parent')] = {};
                }
                data['offering'][$(this).data('parent')][$(this).data('name')] = '1';
            } else {
                data['offering'][$(this).data('name')] = '1';
            }
        } else if ($(this).text() === "☐") {

        } else {
            data['offering'][$(this).data('name')] = $(this).text();
        }
    });


    data['securities'] = {};
    $('.securities .filing-data').each(function () {
        if ($(this).text() === "☒") {
            if (typeof $(this).data('parent') !== 'undefined') {
                if (typeof data['securities'][$(this).data('parent') === 'undefined']) {
                    data['securities'][$(this).data('parent')] = {};
                }
                data['securities'][$(this).data('parent')][$(this).data('name')] = '1';
            } else {
                data['securities'][$(this).data('name')] = '1';
            }
        } else if ($(this).text() === "☐") {

        } else {
            data['securities'][$(this).data('name')] = $(this).text();
        }
    });


    data['business-combination'] = {};
    $('.business-combination .filing-data').each(function () {
        if ($(this).text() === "☒") {
            if (typeof $(this).data('parent') !== 'undefined') {
                if (typeof data['business-combination'][$(this).data('parent') === 'undefined']) {
                    data['business-combination'][$(this).data('parent')] = {};
                }
                data['business-combination'][$(this).data('parent')][$(this).data('name')] = '1';
            } else {
                data['business-combination'][$(this).data('name')] = '1';
            }
        } else if ($(this).text() === "☐") {

        } else {
            data['business-combination'][$(this).data('name')] = $(this).text();
        }
    });


    data['minimum-investment'] = {};
    $('.minimum-investment .filing-data').each(function () {
        if ($(this).text() === "☒") {
            data['minimum-investment'][$(this).data('name')] = '1';

        } else if ($(this).text() === "☐") {
            data['minimum-investment'][$(this).data('name')] = '0';
        } else {
            data['minimum-investment'][$(this).data('name')] = $(this).text();
        }
    });



    data['sales-compensation'] = {};
    $('.recipient').each(function () {
        var list_of_states_id = this.id.split('-')[1];
        let i = Object.keys(data['sales-compensation']).length;
        data['sales-compensation'][i] = {};
        data['sales-compensation'][i]['states'] = {};
        $('#list-of-states-'+list_of_states_id+' ul li').remove();
        $(this).find('.filing-data').each(function () {
            if ($(this).text() === "☒") {
                if (typeof $(this).data('parent') !== 'undefined') {
                    data['sales-compensation'][i]['states'][$(this).data('name')] = $(this).data('description');
                    $(' #list-of-states-'+list_of_states_id+' ul').append("<li>"+$(this).data('description')+"</li>");
                }
                else {
                    data['sales-compensation'][i][$(this).data('name')] = '1';
                }
            } else if ($(this).text() === "☐") {
                data['sales-compensation'][i][$(this).data('name')] = '0';
            } else if ($(this).data('code')) {
                data['sales-compensation'][i][$(this).data('name')] = $(this).data('code-description');
                data['sales-compensation'][i][$(this).data('code')] = $(this).text();
            } else {
                data['sales-compensation'][i][$(this).data('name')] = $(this).text();
            }

        });
    });


    data['offering-sales'] = {};
    $('.offering-sales .filing-data').each(function () {

        if ($(this).text() === "☒") {
            if (typeof $(this).data('parent') !== 'undefined') {
                if (typeof data['offering-sales'][$(this).data('parent') === 'undefined']) {
                    data['offering-sales'][$(this).data('parent')] = {};
                }
                data['offering-sales'][$(this).data('parent')][$(this).data('name')] = '1';
            } else {
                data['offering-sales'][$(this).data('name')] = '1';
            }
        } else if ($(this).text() === "☐") {

        } else {
            data['offering-sales'][$(this).data('name')] = $(this).text();
        }
    });


    data['investors'] = {};
    $('.investors .filing-data').each(function () {
        if ($(this).text() === "☒") {
            if (typeof $(this).data('parent') !== 'undefined') {
                if (typeof data['investors'][$(this).data('parent') === 'undefined']) {
                    data['investors'][$(this).data('parent')] = {};
                }
                data['investors'][$(this).data('parent')][$(this).data('name')] = '1';
            } else {
                data['investors'][$(this).data('name')] = '1';
            }
        } else if ($(this).text() === "☐") {

        } else {
            data['investors'][$(this).data('name')] = $(this).text();
        }
    });


    data['sales'] = {};
    $('.sales .filing-data').each(function () {

        if ($(this).text() === "☒") {
            if (typeof $(this).data('parent') !== 'undefined') {
                if (typeof data['sales'][$(this).data('parent') === 'undefined']) {
                    data['sales'][$(this).data('parent')] = {};
                }
                data['sales'][$(this).data('parent')][$(this).data('name')] = '1';
            } else {
                data['sales'][$(this).data('name')] = '1';
            }
        } else if ($(this).text() === "☐") {

        } else {
            data['sales'][$(this).data('name')] = $(this).text();
        }
    });


    data['use-of-proceeds'] = {};
    $('.use-of-proceeds .filing-data').each(function () {

        if ($(this).text() === "☒") {
            if (typeof $(this).data('parent') !== 'undefined') {
                if (typeof data['sales'][$(this).data('parent') === 'undefined']) {
                    data['use-of-proceeds'][$(this).data('parent')] = {};
                }
                data['use-of-proceeds'][$(this).data('parent')][$(this).data('name')] = '1';
            } else {
                data['use-of-proceeds'][$(this).data('name')] = '1';
            }
        } else if ($(this).text() === "☐") {

        } else {
            data['use-of-proceeds'][$(this).data('name')] = $(this).text();
        }
    });


    data['signature'] = {};
    $('.signature').each(function () {
        let i = Object.keys(data['signature']).length;
        data['signature'][i] = {};
        $(this).find('.filing-data').each(function () {
            data['signature'][i][$(this).data('name')] = $(this).text();
        });
    });



    let htmlContent = $("#content").html();
    let stringJson = JSON.stringify(data);
    $.ajax({
        type: 'POST',
        data: {
            formType: formType,
            filingId: filingID,
            data: stringJson,
            htmlContent: htmlContent,
        },
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: '/generate-filing/generate-filing',
        success: function (response) {
            var link = document.createElement("a");
            link.download = response.file_name;
            link.href = response.url_to_file;
            link.click();
        }
    });


}



function yesnoCheck() {
    if (document.getElementById('other').checked) {
        document.getElementById('otherentity').style.display = 'block';
    }
    else document.getElementById('otherentity').style.display = 'none';

}

//
// document.getElementById('radio-1').onchange = function() {
//     document.getElementById('text1').disabled = this.checked;
// };
//
// document.getElementById('radio-2').onchange = function() {
//     document.getElementById('text2').disabled = this.checked;
// };
// document.getElementById('radio-3').onchange = function() {
//     document.getElementById('text3').disabled = this.checked;
// };




document.getElementById('none-checkbox').onchange = function() {
    document.getElementById('issuerPreviousNameList').disabled = this.checked;
    document.getElementById('edgarPreviousNameList').disabled = this.checked;
};

