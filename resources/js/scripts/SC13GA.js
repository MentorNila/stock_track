$('#add-reported-person').on('click', function(){
    var date = $(this).data('date');
    $('.reported').append(`<div class="person"><table summary="Reporting Persons" cellspacing="0" cellpadding="0" style="font-family: Times New Roman, Times, Serif; width: 100%; border-collapse: collapse">
        <tbody>
     <tr style="font-family: Times New Roman, Times, Serif; vertical-align: top">
        <td style="border-top: black 1pt solid; border-bottom: black 1.5pt solid; border-left: black 1pt solid; font: 12pt Times New Roman, Times, Serif; padding-left: 3pt; text-align: center"><font style="font-family: Times New Roman, Times, Serif; font-size: 10pt"><b>1</b></font></td>
     <td colspan="3" style="font-family: Times New Roman, Times, Serif; border-top: black 1pt solid; border-bottom: black 1.5pt solid; border-left: black 1pt solid; padding: 2.9pt">
        <p style="font: 10pt Times New Roman, Times, Serif; margin: 0 0 0 3pt"><font style="font-family: Times New Roman, Times, Serif">NAME OF REPORTING PERSONS</font>
         <p style="MARGIN: 0px"><span class="editable"><span class="attributes"></span><span class="text" style="display: none;"></span><span class="input"><input type="text"  placeholder="" value=""/></span><i class="far fa-edit" style=" font-size: 15px; display: none"></i></span></p>

        <p style="font: 10pt Times New Roman, Times, Serif; margin: 0 0 0 3pt"><font style="font-family: Times New Roman, Times, Serif">&nbsp;</font></p>

        <p style="font: 10pt Times New Roman, Times, Serif; margin: 0"><font style="font-family: Times New Roman, Times, Serif">I.R.S. IDENTIFICATION NO. OF ABOVE PERSONS (ENTITIES ONLY)</font>
        <p style="MARGIN: 0px"><span class="editable"><span class="attributes"></span><span class="text" style="display: none;"></span><span class="input"><input type="text"  placeholder="" value=""/></span><i class="far fa-edit" style=" font-size: 15px; display: none"></i></span></p>

     </td>
        <td style="font-family: Times New Roman, Times, Serif; border-top: black 1pt solid; border-bottom: black 1.5pt solid; padding-left: 2.9pt"><font style="font-family: Times New Roman, Times, Serif">&nbsp;</font></td>
    </tr>
    <tr style="font-family: Times New Roman, Times, Serif; vertical-align: top">
         <td style="border-bottom: black 1.5pt solid; border-left: black 1pt solid; font: 12pt Times New Roman, Times, Serif; padding-left: 3pt; text-align: center"><font style="font-family: Times New Roman, Times, Serif; font-size: 10pt"><b>2</b></font></td>
         <td colspan="3" style="border-bottom: black 1.5pt solid; border-left: black 1pt solid; font: 12pt Times New Roman, Times, Serif; padding-left: 3pt"><font style="font-family: Times New Roman, Times, Serif; font-size: 10pt">CHECK THE APPROPRIATE BOX IF A MEMBER OF A GROUP</font></td>
         <td style="font-family: Times New Roman, Times, Serif; border-bottom: black 1.5pt solid; padding: 2.9pt"><p style="font: 10pt Times New Roman, Times, Serif;"><font style="font-family: Times New Roman, Times, Serif"></font>
             (a) <span class="editable"><span class="attributes"></span><span class="text"  data-name="(a)" style="display: none;"></span><span class="input"><input type="checkbox"  placeholder="" value="☐"/></span><i class="far fa-edit" style=" font-size: 15px; display: none"></i></span><br>
             (b) <span class="editable"><span class="attributes"></span><span class="text"  data-name="(b)" style="display: none;"></span><span class="input"><input type="checkbox"  placeholder="" value="☐"/></span><i class="far fa-edit" style=" font-size: 15px; display: none"></i></span>
        </td>
    </tr>

    <tr style="font-family: Times New Roman, Times, Serif; vertical-align: top">
        <td style="border-bottom: black 1.5pt solid; border-left: black 1pt solid; font: 12pt Times New Roman, Times, Serif; padding-left: 3pt; text-align: center"><font style="font-family: Times New Roman, Times, Serif; font-size: 10pt"><b>3</b></font></td>
    <td colspan="3" style="border-bottom: black 1.5pt solid; border-left: black 1pt solid; font: 12pt Times New Roman, Times, Serif; padding-left: 3pt"><font style="font-family: Times New Roman, Times, Serif; font-size: 10pt">SEC USE ONLY</font>
    <br>
        <p style="MARGIN: 0px"><span class="editable"><span class="attributes"></span><span class="text" style="display: none;"></span><span class="input"><input type="text"  placeholder="" value=""/></span><i class="far fa-edit" style=" font-size: 15px; display: none"></i></span></p>
    </td>
        <td style="font-family: Times New Roman, Times, Serif; border-bottom: black 1.5pt solid; padding-left: 2.9pt"><font style="font-family: Times New Roman, Times, Serif">&nbsp;</font></td>
    </tr>

    <tr style="font-family: Times New Roman, Times, Serif; vertical-align: top">
        <td style="border-bottom: black 1.5pt solid; border-left: black 1pt solid; font: 12pt Times New Roman, Times, Serif; padding-left: 3pt; text-align: center"><font style="font-family: Times New Roman, Times, Serif; font-size: 10pt"><b>4</b></font></td>
    <td colspan="3" style="font-family: Times New Roman, Times, Serif; border-bottom: black 1.5pt solid; border-left: black 1pt solid; padding: 2.9pt"><p style="font: 10pt Times New Roman, Times, Serif; margin: 0 0 0 3pt"><font style="font-family: Times New Roman, Times, Serif">CITIZENSHIP OR PLACE OF ORGANIZATION</font></p>
    <p style="font: 10pt Times New Roman, Times, Serif; margin: 0 0 0 3pt"><font style="font-family: Times New Roman, Times, Serif">
       <p style="MARGIN: 0px"><span class="editable"><span class="attributes"></span><span class="text" style="display: none;"></span><span class="input"><input type="text"  placeholder="" value=""/></span><i class="far fa-edit" style=" font-size: 15px; display: none"></i></span></p>
    </td>
    <td style="font-family: Times New Roman, Times, Serif; border-bottom: black 1.5pt solid; padding-left: 2.9pt"><font style="font-family: Times New Roman, Times, Serif">&nbsp;</font></td>
    </tr>

    <tr style="font-family: Times New Roman, Times, Serif">
        <td colspan="2" rowspan="4" style="font-family: Times New Roman, Times, Serif; border-right: black 1pt solid; border-bottom: black 1.5pt solid; border-left: black 1pt solid; padding-top: 2.9pt"><p style="font: 10pt Times New Roman, Times, Serif; margin: 0; text-align: center"><font style="font-family: Times New Roman, Times, Serif">NUMBER OF<br >SHARES</font></p>
    <p style="font: 10pt Times New Roman, Times, Serif; margin: 0; text-align: center"><font style="font-family: Times New Roman, Times, Serif">BENEFICIALLY<br >OWNED BY</font></p>
    <p style="font: 10pt Times New Roman, Times, Serif; margin: 0; text-align: center"><font style="font-family: Times New Roman, Times, Serif">EACH<br >REPORTING</font></p>
    <p style="font: 10pt Times New Roman, Times, Serif; margin: 0; text-align: center"><font style="font-family: Times New Roman, Times, Serif">PERSON<br >WITH:</font></p></td>
    <td style="border-bottom: black 1.5pt solid; font: 12pt Times New Roman, Times, Serif; padding-top: 2.9pt; padding-left: 2.9pt; text-align: center"><font style="font-family: Times New Roman, Times, Serif; font-size: 10pt"><b>5</b></font></td>
    <td style="font-family: Times New Roman, Times, Serif; border-bottom: black 1.5pt solid; border-left: black 1pt solid; padding-top: 2.9pt; padding-left: 2.9pt"><p style="font: 10pt Times New Roman, Times, Serif; margin: 0"><font style="font-family: Times New Roman, Times, Serif">SOLE VOTING</font></p>
    <p style="font: 10pt Times New Roman, Times, Serif; margin: 0"><font style="font-family: Times New Roman, Times, Serif">
      <p style="MARGIN: 0px"><span class="editable"><span class="attributes"></span><span class="text" style="display: none;"></span><span class="input"><input type="text"  placeholder="" value=""/></span><i class="far fa-edit" style=" font-size: 15px; display: none"></i></span></p>
    </td>
    <td style="font-family: Times New Roman, Times, Serif; vertical-align: top; border-bottom: black 1.5pt solid; padding-top: 2.9pt; padding-left: 2.9pt"><font style="font-family: Times New Roman, Times, Serif">&nbsp;</font></td>
    </tr>

    <tr style="font-family: Times New Roman, Times, Serif">
        <td style="border-bottom: black 1.5pt solid; font: 12pt Times New Roman, Times, Serif; padding-top: 2.9pt; padding-left: 2.9pt; text-align: center"><font style="font-family: Times New Roman, Times, Serif; font-size: 10pt"><b>6</b></font></td>
    <td style="font-family: Times New Roman, Times, Serif; border-bottom: black 1.5pt solid; border-left: black 1pt solid; padding-top: 2.9pt; padding-left: 2.9pt"><p style="font: 10pt Times New Roman, Times, Serif; margin: 0"><font style="font-family: Times New Roman, Times, Serif">SHARED VOTING POWER</font></p>
    <p style="font: 10pt Times New Roman, Times, Serif; margin: 0"><font style="font-family: Times New Roman, Times, Serif">
      <p style="MARGIN: 0px"><span class="editable"><span class="attributes"></span><span class="text" style="display: none;"></span><span class="input"><input type="text"  placeholder="" value=""/></span><i class="far fa-edit" style=" font-size: 15px; display: none"></i></span></p>
    </td>
    <td style="font-family: Times New Roman, Times, Serif; vertical-align: top; border-bottom: black 1.5pt solid; padding-top: 2.9pt; padding-left: 2.9pt"><font style="font-family: Times New Roman, Times, Serif">&nbsp;</font></td>
    </tr>

    <tr style="font-family: Times New Roman, Times, Serif">
        <td style="border-bottom: black 1.5pt solid; font: 12pt Times New Roman, Times, Serif; padding-top: 2.9pt; padding-left: 2.9pt; text-align: center"><font style="font-family: Times New Roman, Times, Serif; font-size: 10pt"><b>7</b></font></td>
    <td style="font-family: Times New Roman, Times, Serif; border-bottom: black 1.5pt solid; border-left: black 1pt solid; padding-top: 2.9pt; padding-left: 2.9pt"><p style="font: 10pt Times New Roman, Times, Serif; margin: 0"><font style="font-family: Times New Roman, Times, Serif">SOLE DISPOSITIVE POWER</font></p>
    <p style="font: 10pt Times New Roman, Times, Serif; margin: 0"><font style="font-family: Times New Roman, Times, Serif">
       <p style="MARGIN: 0px"><span class="editable"><span class="attributes"></span><span class="text" style="display: none;"></span><span class="input"><input type="text"  placeholder="" value=""/></span><i class="far fa-edit" style=" font-size: 15px; display: none"></i></span></p>
    </td>
    <td style="font-family: Times New Roman, Times, Serif; vertical-align: top; border-bottom: black 1.5pt solid; padding-top: 2.9pt; padding-left: 2.9pt"><font style="font-family: Times New Roman, Times, Serif">&nbsp;</font></td>
    </tr>

    <tr style="font-family: Times New Roman, Times, Serif">
        <td style="border-bottom: black 1.5pt solid; font: 12pt Times New Roman, Times, Serif; padding-top: 2.9pt; padding-left: 2.9pt; text-align: center"><font style="font-family: Times New Roman, Times, Serif; font-size: 10pt"><b>8</b></font></td>
    <td style="font-family: Times New Roman, Times, Serif; border-bottom: black 1.5pt solid; border-left: black 1pt solid; padding-top: 2.9pt; padding-left: 2.9pt"><p style="font: 10pt Times New Roman, Times, Serif; margin: 0"><font style="font-family: Times New Roman, Times, Serif">SHARED DISPOSITIVE POWER</font></p>
    <p style="font: 10pt Times New Roman, Times, Serif; margin: 0"><font style="font-family: Times New Roman, Times, Serif">
         <p style="MARGIN: 0px"><span class="editable"><span class="attributes"></span><span class="text" style="display: none;"></span><span class="input"><input type="text"  placeholder="" value=""/></span><i class="far fa-edit" style=" font-size: 15px; display: none"></i></span></p>
    </td>
    <td style="font-family: Times New Roman, Times, Serif; vertical-align: top; border-bottom: black 1.5pt solid; padding-top: 2.9pt; padding-left: 2.9pt"><font style="font-family: Times New Roman, Times, Serif">&nbsp;</font></td>
    </tr>

    <tr style="font-family: Times New Roman, Times, Serif; vertical-align: top">
        <td style="border-bottom: black 1.5pt solid; border-left: black 1pt solid; font: 12pt Times New Roman, Times, Serif; padding-left: 3pt; text-align: center"><font style="font-family: Times New Roman, Times, Serif; font-size: 10pt"><b>9</b></font></td>
    <td colspan="3" style="font-family: Times New Roman, Times, Serif; border-bottom: black 1.5pt solid; border-left: black 1pt solid; padding: 2.9pt"><p style="font: 10pt Times New Roman, Times, Serif; margin: 0 0 0 3pt"><font style="font-family: Times New Roman, Times, Serif">AGGREGATE AMOUNT BENEFICIALLY OWNED BY EACH REPORTING PERSON</font></p>
    <p style="font: 10pt Times New Roman, Times, Serif; margin: 0 0 0 3pt"><font style="font-family: Times New Roman, Times, Serif">
         <p style="MARGIN: 0px"><span class="editable"><span class="attributes"></span><span class="text" style="display: none;"></span><span class="input"><input type="text"  placeholder="" value=""/></span><i class="far fa-edit" style=" font-size: 15px; display: none"></i></span></p>
    </td>
    <td style="font-family: Times New Roman, Times, Serif; border-bottom: black 1.5pt solid; padding-left: 2.9pt"><font style="font-family: Times New Roman, Times, Serif">&nbsp;</font></td>
    </tr>
    <tr style="font-family: Times New Roman, Times, Serif; vertical-align: top">
        <td style="border-bottom: black 1.5pt solid; border-left: black 1pt solid; font: 12pt Times New Roman, Times, Serif; padding-left: 3pt; text-align: center"><font style="font-family: Times New Roman, Times, Serif; font-size: 10pt"><b>10</b></font></td>
    <td colspan="3" style="border-bottom: black 1.5pt solid; border-left: black 1pt solid; font: 12pt Times New Roman, Times, Serif; padding-left: 3pt"><font style="font-family: Times New Roman, Times, Serif; font-size: 10pt">CHECK BOX IF THE AGGREGATE AMOUNT IN ROW 9 EXCLUDES CERTAIN SHARES</font></td>
    <td style="border-bottom: black 1.5pt solid; font: 12pt Times New Roman, Times, Serif; padding-left: 2.9pt"><font style="font-family: Times New Roman, Times, Serif; font-size: 10pt">
             <span class="editable"><span class="attributes"></span><span class="text"  data-name="aggregate" style="display: none;"></span><span class="input"><input type="checkbox"  placeholder="" value="☐"/></span><i class="far fa-edit" style=" font-size: 15px; display: none"></i></span><br>
        </tr>
        <tr style="font-family: Times New Roman, Times, Serif; vertical-align: top">
            <td style="border-bottom: black 1.5pt solid; border-left: black 1pt solid; font: 12pt Times New Roman, Times, Serif; padding-left: 3pt; text-align: center"><font style="font-family: Times New Roman, Times, Serif; font-size: 10pt"><b>11</b></font></td>
            <td colspan="3" style="font-family: Times New Roman, Times, Serif; border-bottom: black 1.5pt solid; border-left: black 1pt solid; padding: 2.9pt"><p style="font: 10pt Times New Roman, Times, Serif; margin: 0 0 0 3pt"><font style="font-family: Times New Roman, Times, Serif">PERCENT OF CLASS REPRESENTED BY AMOUNT IN ROW 9</font></p>
            <p style="font: 10pt Times New Roman, Times, Serif; margin: 0"><font style="font-family: Times New Roman, Times, Serif">
                <p style="MARGIN: 0px"><span class="editable"><span class="attributes"></span><span class="text" style="display: none;"></span><span class="input"><input type="text"  placeholder="" value=""/></span><i class="far fa-edit" style=" font-size: 15px; display: none"></i></span></p>
            </td>
            <td style="font-family: Times New Roman, Times, Serif; border-bottom: black 1.5pt solid; padding-left: 2.9pt"><font style="font-family: Times New Roman, Times, Serif">&nbsp;</font></td>
     </tr>

    <tr style="font-family: Times New Roman, Times, Serif; vertical-align: top">
        <td style="border-bottom: black 1.5pt solid; border-left: black 1pt solid; font: 12pt Times New Roman, Times, Serif; padding-left: 3pt; text-align: center"><font style="font-family: Times New Roman, Times, Serif; font-size: 10pt"><b>12</b></font></td>
        <td colspan="3" style="font-family: Times New Roman, Times, Serif; border-bottom: black 1.5pt solid; border-left: black 1pt solid; padding: 2.9pt"><p style="font: 10pt Times New Roman, Times, Serif; margin: 0 0 0 3pt"><font style="font-family: Times New Roman, Times, Serif">TYPE OF REPORTING PERSON</font></p>
        <p style="font: 10pt Times New Roman, Times, Serif; margin: 0 0 0 3pt"><font style="font-family: Times New Roman, Times, Serif">
            <p style="MARGIN: 0px"><span class="editable"><span class="attributes"></span><span class="text" style="display: none;"></span><span class="input"><input type="text"  placeholder="" value=""/></span><i class="far fa-edit" style=" font-size: 15px; display: none"></i></span></p>
        </td>
        <td style="font-family: Times New Roman, Times, Serif; border-bottom: black 1.5pt solid; padding-left: 2.9pt"><font style="font-family: Times New Roman, Times, Serif">&nbsp;</font></td>
    </tr>
    <td>
     <button type="button" class="btn btn-danger btn-sm delete-reported-person">Delete Reported Person</button>
    </td>
    <tr style="font-family: Times New Roman, Times, Serif">
        <td style="font-family: Times New Roman, Times, Serif; width: 6%"><font style="font-family: Times New Roman, Times, Serif">&nbsp;</font></td>
        <td style="font-family: Times New Roman, Times, Serif; width: 9%"><font style="font-family: Times New Roman, Times, Serif">&nbsp;</font></td>
        <td style="font-family: Times New Roman, Times, Serif; width: 5%"><font style="font-family: Times New Roman, Times, Serif">&nbsp;</font></td>
        <td style="font-family: Times New Roman, Times, Serif; width: 73%"><font style="font-family: Times New Roman, Times, Serif">&nbsp;</font></td>
        <td style="font-family: Times New Roman, Times, Serif; width: 7%"><font style="font-family: Times New Roman, Times, Serif">&nbsp;</font></td>
    </tr>

           <hr size="1" noshade="noshade" align="left" style="width: 15%; color: black" >
                        <table cellpadding="0" cellspacing="0" style="width: 100%; font: 10pt Times New Roman, Times, Serif; margin-top: 0; margin-bottom: 0">
                            <tr style="font-family: Times New Roman, Times, Serif; vertical-align: top">
                                <td style="font-family: Times New Roman, Times, Serif; width: 0"></td>
                                <td style="font-family: Times New Roman, Times, Serif; width: 0.5in"><font style="font-family: Times New Roman, Times, Serif">(1)</font></td>
                                <td style="font-family: Times New Roman, Times, Serif; text-align: justify"><font style="font-family: Times New Roman, Times, Serif">
                                     <p style="MARGIN: 0px"><span class="editable"><span class="attributes"></span><span class="text" style="display: none;"></span><span class="input"><input type="text"  placeholder="" value=""/></span><i class="far fa-edit" style=" font-size: 15px; display: none"></i></span></p>
                                </td>
                            </tr>
                        </table>

                        <table cellpadding="0" cellspacing="0" style="width: 100%; font: 10pt Times New Roman, Times, Serif; margin-top: 0; margin-bottom: 0">
                            <tr style="font-family: Times New Roman, Times, Serif; vertical-align: top">
                                <td style="font-family: Times New Roman, Times, Serif; width: 0"></td><td style="font-family: Times New Roman, Times, Serif; width: 0.5in"><font style="font-family: Times New Roman, Times, Serif">(2)</font></td>
                                <td style="font-family: Times New Roman, Times, Serif; text-align: justify"><font style="font-family: Times New Roman, Times, Serif">
                                      <p style="MARGIN: 0px"><span class="editable"><span class="attributes"></span><span class="text" style="display: none;"></span><span class="input"><input type="text"  placeholder="" value=""/></span><i class="far fa-edit" style=" font-size: 15px; display: none"></i></span></p>
                                </td>
                            </tr>
                        </table>
        </tbody>
        </table>
        </div>`);
});


$('body').on('click', '.delete-reported-person', function () {
    $(this).closest('.person').remove();
});



$('.add-signature1').on('click', function(){
    var date = $(this).data('date');
    $('.signatures').append(`<table class="sig"  style="font: Times New Roman, Times, Serif; width: 100%; border-collapse: collapse">
                            <tr style="font-family: Times New Roman, Times, Serif;">
                                <td><font style="font-family: Times New Roman, Times, Serif; font-size: 10pt"></font></td>
                                <td colspan="2" style="font-family: Times New Roman, Times, Serif; vertical-align: top; padding-right: 1.8pt"><font style="font-family: Times New Roman, Times, Serif; font-size: 10pt">
                               <span class="editable"><span class="attributes"></span><span class="text" style="display: none;"></span><span class="input"><input type="text"  placeholder="Company name" value=""/></span><i class="far fa-edit" style=" font-size: 15px; display: none"></i></span>
                                </td>
                            </tr>
                            <tr style="font-family: Times New Roman, Times, Serif">
                                <td><font style="font-family: Times New Roman, Times, Serif; font-size: 10pt"></font></td>
                                <td style="font-family: Times New Roman, Times, Serif; vertical-align: top; padding-right: 1.8pt"><font style="font-family: Times New Roman, Times, Serif; font-size: 10pt">Date:</font></td>
                                <td style="font-family: Times New Roman, Times, Serif; vertical-align: top; padding-right: 1.8pt"><font style="font-family: Times New Roman, Times, Serif; font-size: 10pt">
                                <span class="editable"><span class="attributes"></span><span class="text" style="display: none;"></span><span class="input"><input class="datepicker"  data-date-format="MM dd, yyyy" placeholder="" value=""/></span><i class="far fa-edit" style="font-size: 15px; display: none"></i></span></p>
                                </td>
                            </tr>

                            <tr style="font-family: Times New Roman, Times, Serif">
                                <td><font style="font-family: Times New Roman, Times, Serif; font-size: 10pt"></font></td>
                                <td style="font-family: Times New Roman, Times, Serif; vertical-align: top; padding-right: 0.8pt"><font style="font-family: Times New Roman, Times, Serif; font-size: 10pt">By:</font></td>
                                <td style="border-bottom: Black 1pt solid; font-family: Times New Roman, Times, Serif; vertical-align: top; padding-right: 0.8pt"><font style="font-family: Times New Roman, Times, Serif; font-size: 10pt">
                                        <p style="MARGIN: 0px">/s/<i> <span class="editable"><span class="attributes"></span><span class="text" style="display: none;"></span><span class="input"><input type="text" placeholder="" value=""/></span><i class="far fa-edit" style=" font-size: 15px; display: none"></i></span></i></p></font>
                                </td>
                            </tr>
                            <tr style="font-family: Times New Roman, Times, Serif">
                                <td><font style="font-family: Times New Roman, Times, Serif; font-size: 10pt"></font></td>
                                <td style="font-family: Times New Roman, Times, Serif; vertical-align: top; padding-right: 0.8pt"><font style="font-family: Times New Roman, Times, Serif; font-size: 10pt">Name:</font></td>
                                <td style="font-family: Times New Roman, Times, Serif; vertical-align: top; padding-right: 0.8pt"><font style="font-family: Times New Roman, Times, Serif; font-size: 10pt">
                                    <p style="MARGIN: 0px"><span class="editable"><span class="attributes"></span><span class="text" style="display: none;"></span><span class="input"><input type="text" placeholder="" value=""/></span><i class="far fa-edit" style="font-size: 15px; display: none"></i></span></p>
                                </td>
                                      <td><a style="cursor: pointer;" class="delete-signature"><i class="fa fa-times" aria-hidden="true"></i></a></td>
                            </tr>
                            <tr style="font-family: Times New Roman, Times, Serif">
                                <td><font style="font-family: Times New Roman, Times, Serif; font-size: 10pt"></font></td>
                                <td style="font-family: Times New Roman, Times, Serif; vertical-align: top; padding-right: 0.8pt"><font style="font-family: Times New Roman, Times, Serif; font-size: 10pt">Title:</td>
                                <td style="font-family: Times New Roman, Times, Serif; vertical-align: top; padding-right: 0.8pt"><font style="font-family: Times New Roman, Times, Serif; font-size: 10pt">
                                  <p style="MARGIN: 0px"><span class="editable"><span class="attributes"></span><span class="text" style="display: none;"></span><span class="input"><input type="text" placeholder="" value=""/></span><i class="far fa-edit" style=" font-size: 15px; display: none"></i></span></p>
                                 </td>
                            </tr>

                            <tr style="font-family: Times New Roman, Times, Serif">
                                <td style="width: 50%"><font style="font-family: Times New Roman, Times, Serif; font-size: 10pt">&nbsp;</font></td>
                                <td style="font-family: Times New Roman, Times, Serif; width: 6%"><font style="font-family: Times New Roman, Times, Serif; font-size: 10pt">&nbsp;</font></td>
                                <td style="font-family: Times New Roman, Times, Serif; width: 44%"><font style="font-family: Times New Roman, Times, Serif; font-size: 10pt">&nbsp;</font></td>
                            </tr>
               </table>`);
    $('.datepicker').datepicker();
});


$('body').on('click','.delete-signature', function(){
    $(this).closest('.sig').remove();
});


    function generateFormFilings($button) {
        var data = {};

        data['reported-persons'] = {};
        $('.reported-person').each(function () {
            let i = Object.keys(data['reported-persons']).length;
            data['reported-persons'][i] = {};
            $(this).find('.filing-data').each(function () {
                if ($(this).text() === "☒") {
                    data['reported-persons'][i][$(this).data('name')] = '1';
                } else if ($(this).text() === "☐") {
                    data['reported-persons'][i][$(this).data('name')] = '0';
                } else {
                    data['reported-persons'][i][$(this).data('name')] = $(this).text();
                }
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
                $('#generateFiles').html('Generate Files');
                $('#generateFiles').removeAttr("disabled");
            }
        });


    }


